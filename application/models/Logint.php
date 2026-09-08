<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Logint extends CI_Model
{

    public function auth($username, $password)
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where(array(
            'username' => $username,
            'password' => $password
        ));
        return $this->db->get()->row();
    }

    //login suplier
    public function auth_supplier($username, $password)
    {
        $this->db->select('*');
        $this->db->from('supplier');
        $this->db->where(array(
            'username_supp' => $username,
            'pass_supp' => $password
        ));
        return $this->db->get()->row();
    }

    public function registers($data)
    {
        $this->db->insert('user', $data);
    }

    public function tampilan_awal()
    {
        $this->db->select('*');
        $this->db->from('produk_masuk');
        $this->db->where('status', 'SELESAI');
        $this->db->order_by('tgl_masuk', 'desc');

        return $this->db->get()->result();
    }
}
                        
/* End of file Login.php */
