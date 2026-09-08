<?php

defined('BASEPATH') or exit('No direct script access allowed');

class controllerLogin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->ci = &get_instance();
        $this->load->model('Logint');
    }

    public function index()
    {
        $data['title'] = 'Login';

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == FALSE) {

            $this->load->view('_layout/auth-header', $data);
            $this->load->view('login', $data);
            $this->load->view('_layout/auth-footers', $data);
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $login = $this->Logint->auth($username, $password);
            if ($login) {
                $username = $login->username;
                $id = $login->id_user;
                $level = $login->level_user;


                $array = array(
                    'id' => $id,
                    'level' => $level,
                    'username' => $username,
                );

                $this->session->set_userdata($array);


                if ($level == '1' || $level == '3') {
                    $this->ci->session->set_userdata('username', $username);
                    $this->session->set_flashdata('success', 'Selamat Datang, ', $username);

                    redirect(base_url('dashboard'));
                } else if ($level == '2') {
                    $this->ci->session->set_userdata('username', $username);
                    $this->session->set_flashdata('success', 'Selamat Datang, ', $username);
                    redirect(base_url('dashboard'));
                } else if ($level == '4') {
                    $this->ci->session->set_userdata('username', $username);
                    $this->session->set_flashdata('success', 'Selamat Datang, ', $username);

                    redirect(base_url('dashboard'));
                }
            } else {
                $this->session->set_flashdata('error', 'Username dan Password Salah!!!');
                redirect(base_url('ControllerLogin'));
            }
        }
    }


    public function register()
    {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        $var = 4;

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Register';


            $this->load->view('_layout/auth-header', $data);
            $this->load->view('register', $data);
            $this->load->view('_layout/auth-footers', $data);
        } else {
            $data = array(
                'nama' => $this->input->post('nama'),
                'email' => $this->input->post('email'),
                'no_wa' => $this->input->post('no_wa'),
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'level_user' => $var,
            );
            $this->Logint->registers($data);
            $this->session->set_flashdata('success', 'Berhasil Memasukkan Data User!!!');
            redirect('ControllerLogin');
        }
    }


    public function logout()
    {
        $this->session->unset_userdata(array('id', 'level', 'username', 'error'));
        $this->cart->destroy();
        $this->session->set_flashdata('success', 'Anda Berhasil LogOut!');

        redirect('ControllerLogin');
    }
}
