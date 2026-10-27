<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Booking_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        if (!isset($this->db)) {
            $this->load->database();
        }
        $this->_ensure_schema();
    }

    private function _ensure_schema()
    {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `barber` (
                `id_barber` int(11) NOT NULL AUTO_INCREMENT,
                `nama` varchar(100) NOT NULL,
                `spesialisasi` varchar(150) DEFAULT 'Hair Stylist & Grooming Specialist',
                `foto` varchar(255) DEFAULT 'assets/img/team/team-1.jpg',
                `pengalaman` varchar(50) DEFAULT '5+ Tahun',
                `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
                PRIMARY KEY (`id_barber`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
        ");

        $count = $this->db->count_all('barber');
        if ($count == 0) {
            $initial_barbers = [
                [
                    'id_barber'    => 1,
                    'nama'         => 'Bagus Pamungkas',
                    'spesialisasi' => 'Master Barber & Fade Expert',
                    'foto'         => 'assets/img/team/team-1.jpg',
                    'pengalaman'   => '6+ Tahun',
                    'status'       => 'aktif'
                ],
                [
                    'id_barber'    => 2,
                    'nama'         => 'Dimas Setiawan',
                    'spesialisasi' => 'Classic Cut & Hot Towel Specialist',
                    'foto'         => 'assets/img/team/team-2.jpg',
                    'pengalaman'   => '4+ Tahun',
                    'status'       => 'aktif'
                ],
            ];
            $this->db->insert_batch('barber', $initial_barbers);
        }

        // Pastikan Rian Pratama dinonaktifkan dari sistem barber
        $this->db->where('nama', 'Rian Pratama')->update('barber', ['status' => 'nonaktif']);

        $fields = $this->db->list_fields('jasa');
        if (!in_array('barber', $fields)) {
            $this->db->query("ALTER TABLE `jasa` ADD COLUMN `barber` VARCHAR(100) NULL AFTER `nama`");
        }
        if (!in_array('no_wa', $fields)) {
            $this->db->query("ALTER TABLE `jasa` ADD COLUMN `no_wa` VARCHAR(30) NULL AFTER `barber`");
        }
        if (!in_array('catatan', $fields)) {
            $this->db->query("ALTER TABLE `jasa` ADD COLUMN `catatan` TEXT NULL AFTER `no_wa`");
        }
        if (!in_array('username', $fields)) {
            $this->db->query("ALTER TABLE `jasa` ADD COLUMN `username` VARCHAR(255) NULL");
        }

        $query = $this->db->get_where('harga', ['jenis' => 'Regular Haircut']);
        if ($query->num_rows() == 0) {
            $checkHaircut = $this->db->get_where('harga', ['id' => 1])->row();
            if ($checkHaircut) {
                $this->db->where('id', 1)->update('harga', [
                    'jenis'      => 'Regular Haircut',
                    'label'      => 'Regular Haircut (Keramas, Hair Tonic, Styling, Hot Towel)',
                    'harga'      => 'Rp 35.000',
                    'data_harga' => 35000
                ]);
            } else {
                $this->db->insert('harga', [
                    'jenis'      => 'Regular Haircut',
                    'label'      => 'Regular Haircut (Keramas, Hair Tonic, Styling, Hot Towel)',
                    'harga'      => 'Rp 35.000',
                    'data_harga' => 35000
                ]);
            }
        }
    }

    public function get_selected_service()
    {
        $service = $this->db->get_where('harga', ['jenis' => 'Regular Haircut'])->row();
        if (!$service) {
            $service = $this->db->get_where('harga', ['id' => 1])->row();
        }
        if (!$service) {
            return (object) [
                'id'         => 1,
                'jenis'      => 'Regular Haircut',
                'label'      => 'Regular Haircut (Keramas, Hair Tonic, Styling, Hot Towel)',
                'harga'      => 'Rp 35.000',
                'data_harga' => 35000,
                'deskripsi'  => 'Potong rambut reguler termasuk konsultasi model, keramas, hot towel, dan styling pomade.'
            ];
        }

        if (empty($service->deskripsi)) {
            $service->deskripsi = 'Potong rambut reguler dengan teknik presisi, cuci rambut bersih, hot towel rileks, dan penataan styling akhir.';
        }
        return $service;
    }

    public function get_active_barbers()
    {
        $this->db->select('id_barber, nama, spesialisasi, foto, pengalaman, status');
        $this->db->from('barber');
        $this->db->where('status', 'aktif');
        $this->db->order_by('id_barber', 'ASC');
        return $this->db->get()->result();
    }

    public function get_barber_by_id($id_barber)
    {
        return $this->db->get_where('barber', [
            'id_barber' => (int) $id_barber,
            'status'    => 'aktif'
        ])->row();
    }

    public function get_operational_slots()
    {
        return [
            '10:00',
            '11:00',
            '12:00',
            '13:00',
            '14:00',
            '15:00',
            '16:00',
            '17:00',
            '18:30',
            '19:30',
            '20:30'
        ];
    }

    public function get_available_slots($barber_name, $tanggal)
    {
        $all_slots = $this->get_operational_slots();

        $this->db->select('waktu_booking');
        $this->db->from('jasa');
        $this->db->where('tanggal_pesan', $tanggal);
        $this->db->where('barber', $barber_name);
        $this->db->where_in('status', ['PESAN', 'LANGSUNG', 'BERHASIL']);
        $query = $this->db->get();

        $booked_slots = [];
        foreach ($query->result() as $row) {
            if (!empty($row->waktu_booking)) {
                $trimmed = substr(trim($row->waktu_booking), 0, 5);
                $booked_slots[] = $trimmed;
            }
        }

        date_default_timezone_set('Asia/Jakarta');
        $today = date('Y-m-d');
        $currentTime = date('H:i');

        $result = [];
        foreach ($all_slots as $slot) {
            $is_passed = false;
            if ($tanggal === $today && strcmp($slot, $currentTime) <= 0) {
                $is_passed = true;
            }

            $is_booked = in_array($slot, $booked_slots, true);

            $result[] = [
                'time'      => $slot,
                'available' => (!$is_booked && !$is_passed),
                'reason'    => $is_booked ? 'Sudah dipesan' : ($is_passed ? 'Waktu telah lewat' : 'Tersedia')
            ];
        }

        return $result;
    }

    public function is_slot_available($barber_name, $tanggal, $jam)
    {
        date_default_timezone_set('Asia/Jakarta');
        $today = date('Y-m-d');
        $currentTime = date('H:i');

        if ($tanggal < $today) {
            return false;
        }

        if ($tanggal === $today && strcmp($jam, $currentTime) <= 0) {
            return false;
        }

        $all_slots = $this->get_operational_slots();
        if (!in_array($jam, $all_slots, true)) {
            return false;
        }

        $this->db->select('kode');
        $this->db->from('jasa');
        $this->db->where('tanggal_pesan', $tanggal);
        $this->db->where('barber', $barber_name);
        $this->db->where('waktu_booking', $jam);
        $this->db->where_in('status', ['PESAN', 'LANGSUNG', 'BERHASIL']);
        $count = $this->db->count_all_results();

        return ($count === 0);
    }

    public function generate_booking_code()
    {
        $chars = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
        $max_attempts = 10;
        for ($i = 0; $i < $max_attempts; $i++) {
            $random = '';
            for ($c = 0; $c < 5; $c++) {
                $random .= $chars[random_int(0, strlen($chars) - 1)];
            }
            $code = 'KB-' . $random;
            $exists = $this->db->get_where('jasa', ['kode' => $code])->num_rows();
            if ($exists === 0) {
                return $code;
            }
        }
        return 'KB-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 5));
    }

    public function create_booking($data)
    {
        return $this->db->insert('jasa', $data);
    }

    public function get_booking_by_code($kode)
    {
        return $this->db->get_where('jasa', ['kode' => $kode])->row();
    }

}

