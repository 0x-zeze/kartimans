<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Booking extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Booking_model');
        $this->load->helper(['url', 'form']);
        $this->load->library(['form_validation', 'session']);
    }

    /**
     * Halaman Utama Booking Publik
     */
    public function index()
    {
        $service = $this->Booking_model->get_selected_service();
        $barbers = $this->Booking_model->get_active_barbers();

        $data = [
            'title'   => 'Booking Jadwal Cukur - Kartimans Barbershop',
            'service' => $service,
            'barbers' => $barbers,
            'today'   => date('Y-m-d')
        ];

        $this->load->view('booking/index', $data);
    }

    /**
     * Endpoint AJAX: Mendapatkan slot waktu yang tersedia berdasarkan barber dan tanggal
     */
    public function get_slots()
    {
        // Response JSON header
        $this->output->set_content_type('application/json');

        $barber_id = $this->input->get('barber_id', true);
        $tanggal   = $this->input->get('tanggal', true);

        if (empty($barber_id) || empty($tanggal)) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Barber dan tanggal harus dipilih.'
            ]);
            return;
        }

        // Validasi format tanggal YYYY-MM-DD
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal)) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Format tanggal tidak valid.'
            ]);
            return;
        }

        // Cek tanggal tidak boleh lampau
        date_default_timezone_set('Asia/Jakarta');
        if ($tanggal < date('Y-m-d')) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Tanggal booking tidak boleh sudah lewat.'
            ]);
            return;
        }

        // Ambil data barber
        $barber = $this->Booking_model->get_barber_by_id($barber_id);
        if (!$barber) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Barber tidak ditemukan atau sedang tidak aktif.'
            ]);
            return;
        }

        $slots = $this->Booking_model->get_available_slots($barber->nama, $tanggal);

        echo json_encode([
            'status' => 'success',
            'data'   => [
                'barber_name' => $barber->nama,
                'tanggal'     => $tanggal,
                'slots'       => $slots
            ]
        ]);
    }

    /**
     * Submit Booking (Validasi frontend & backend, Server-authoritative Pricing & Anti-collision)
     */
    public function submit()
    {
        // Tangani AJAX / Fetch request
        $is_ajax = $this->input->is_ajax_request() || ($this->input->server('HTTP_ACCEPT') && strpos($this->input->server('HTTP_ACCEPT'), 'application/json') !== false);

        // Validasi Form
        $this->form_validation->set_rules('barber_id', 'Barber', 'required|numeric');
        $this->form_validation->set_rules('tanggal', 'Tanggal Booking', 'required|regex_match[/^\d{4}-\d{2}-\d{2}$/]');
        $this->form_validation->set_rules('jam', 'Jam Booking', 'required|regex_match[/^\d{2}:\d{2}$/]');
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('no_wa', 'Nomor WhatsApp', 'required|trim|min_length[8]|max_length[20]');
        $this->form_validation->set_rules('catatan', 'Catatan Tambahan', 'trim|max_length[300]');

        if ($this->form_validation->run() === FALSE) {
            $errors = validation_errors(' ', ' ');
            if ($is_ajax) {
                $this->output->set_content_type('application/json');
                echo json_encode([
                    'status'  => 'error',
                    'message' => trim($errors) ?: 'Data yang dimasukkan belum lengkap atau tidak valid.'
                ]);
                return;
            } else {
                $this->session->set_flashdata('error', trim($errors));
                redirect('booking');
                return;
            }
        }

        $barber_id = (int) $this->input->post('barber_id', true);
        $tanggal   = $this->input->post('tanggal', true);
        $jam       = $this->input->post('jam', true);
        $nama      = strip_tags($this->input->post('nama', true));
        $no_wa     = strip_tags($this->input->post('no_wa', true));
        $catatan   = strip_tags($this->input->post('catatan', true));

        // 1. Validasi Barber aktif dari database
        $barber = $this->Booking_model->get_barber_by_id($barber_id);
        if (!$barber) {
            $msg = 'Barber yang dipilih tidak valid atau sedang nonaktif.';
            if ($is_ajax) {
                $this->output->set_content_type('application/json');
                echo json_encode(['status' => 'error', 'message' => $msg]);
                return;
            }
            $this->session->set_flashdata('error', $msg);
            redirect('booking');
            return;
        }

        // 2. Validasi Layanan & Harga Otoritatif dari Database (Server-side authoritative)
        $service = $this->Booking_model->get_selected_service();
        $final_price = (float) $service->data_harga; // Pastikan harga selalu Rp 35.000 / dari DB
        $service_name = $service->jenis;

        // 3. Validasi Anti-Collision: Cek apakah slot masih tersedia detik ini
        if (!$this->Booking_model->is_slot_available($barber->nama, $tanggal, $jam)) {
            $msg = 'Maaf, slot waktu pukul ' . $jam . ' untuk barber ' . $barber->nama . ' pada tanggal ' . $tanggal . ' baru saja dipesan oleh pelanggan lain. Silakan pilih slot atau tanggal lain.';
            if ($is_ajax) {
                $this->output->set_content_type('application/json');
                echo json_encode(['status' => 'error', 'message' => $msg]);
                return;
            }
            $this->session->set_flashdata('error', $msg);
            redirect('booking');
            return;
        }

        // 4. Buat kode booking unik
        $booking_code = $this->Booking_model->generate_booking_code();
        date_default_timezone_set('Asia/Jakarta');

        $booking_data = [
            'kode'          => $booking_code,
            'nama'          => $nama,
            'barber'        => $barber->nama,
            'no_wa'         => $no_wa,
            'catatan'       => $catatan,
            'jenis'         => $service_name,
            'tanggal'       => date('Y-m-d'),
            'tanggal_pesan' => $tanggal,
            'waktu_booking' => $jam,
            'status'        => 'PESAN',
            'harga'         => $final_price,
            'username'      => 'pelanggan_web'
        ];

        // 5. Simpan ke database
        $saved = $this->Booking_model->create_booking($booking_data);

        if (!$saved) {
            $msg = 'Terjadi kesalahan sistem saat menyimpan booking. Silakan coba kembali.';
            if ($is_ajax) {
                $this->output->set_content_type('application/json');
                echo json_encode(['status' => 'error', 'message' => $msg]);
                return;
            }
            $this->session->set_flashdata('error', $msg);
            redirect('booking');
            return;
        }

        $redirect_url = site_url('booking/success/' . $booking_code);

        if ($is_ajax) {
            $this->output->set_content_type('application/json');
            echo json_encode([
                'status'       => 'success',
                'message'      => 'Booking berhasil dikonfirmasi!',
                'booking_code' => $booking_code,
                'redirect_url' => $redirect_url
            ]);
            return;
        }

        redirect('booking/success/' . $booking_code);
    }

    /**
     * Halaman Konfirmasi Sukses / E-Voucher Booking
     */
    public function success($kode = null)
    {
        if (empty($kode)) {
            redirect('booking');
            return;
        }

        $booking = $this->Booking_model->get_booking_by_code($kode);
        if (!$booking) {
            show_404();
            return;
        }

        $data = [
            'title'   => 'Konfirmasi Booking - ' . $booking->kode,
            'booking' => $booking
        ];

        $this->load->view('booking/success', $data);
    }
}
