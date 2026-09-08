<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Layanan');
        date_default_timezone_set('Asia/Jakarta');

        if (!$this->session->userdata('id') || !$this->session->userdata('username')) {
            redirect('ControllerLogin');
        }
    }

    public function index()
    {
        $data = array(
            'pendapatan' => $this->Layanan->pendapatane(),
            'pending' => $this->Layanan->pendinge(),
            'listdata' => $this->Layanan->view_layanan_dash(),
            'listdatapel' => $this->Layanan->view_layanan_dash_pel($this->session->userdata('username')),
            'penjualan' => $this->Layanan->penjualane(),
            'pengguna' => $this->Layanan->penggunane(),
            'title' => 'Dashboard',
            
        );


        $this->load->view('_layout/header', $data);
        $this->load->view('_layout/sidebar', $data);
        $this->load->view('_layout/topbar', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('_layout/footer');
    }

    
}
