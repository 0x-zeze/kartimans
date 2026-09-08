<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Layanan extends CI_Model
{
    //kelola user
    public function insert_layanan($data)
    {
        $this->db->insert('jasa', $data);
    }
    public function view_layanan()
    {
        $this->db->select('*');
        $this->db->from('jasa');
        $this->db->where('status', "LANGSUNG");
        $this->db->or_where('status', "PESAN");
        return $this->db->get()->result();
    }
    public function view_layanan_dash()
    {
        $this->db->select('*');
        $this->db->from('jasa');
        $this->db->order_by('time', 'DESC');
        return $this->db->get()->result();
    }
    public function view_layanan_dash_pel($user)
    {
        $this->db->select('*');
        $this->db->from('jasa');
        $this->db->where('username', $user);
        return $this->db->get()->result();
    }
    public function view_berhasil()
    {
        $kondisi = 'BERHASIL';
        $this->db->select('*');
        $this->db->where('status', $kondisi);
        $this->db->from('jasa');
        return $this->db->get()->result();
    }
    public function view_cancel()
    {
        $kondisi = 'CANCEL';
        $this->db->select('*');
        $this->db->where('status', $kondisi);
        $this->db->from('jasa');
        return $this->db->get()->result();
    }
    public function view_harga()
    {
        $this->db->select('*');
        $this->db->from('harga');
        return $this->db->get()->result();
    }
    public function select_user()
    {
        $this->db->select('*');
        $this->db->from('user');
        return $this->db->get()->result();
    }
    public function edit_user($id)
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('id_user', $id);
        return $this->db->get()->row();
    }
    public function update_user($id, $data)
    {
        $this->db->where('id_user', $id);
        $this->db->update('user', $data);
    }
    public function delete_user($id)
    {
        $this->db->where('id_user', $id);
        $this->db->delete('user');
    }
    function januari() {
        $this->db->select('*');
        $this->db->from('jasa');
        return $this->db->get()->num_rows();
    }
    public function view_detail($id)
    {
        $this->db->select('*');
        $this->db->from('jasa');
        $this->db->where('jasa.kode', $id);
        return $this->db->get()->row();
    }
    public function view_user($id)
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('user.id_user', $id);
        return $this->db->get()->row();
    }
    public function view_harganya($id)
    {
        $this->db->select('*');
        $this->db->from('harga');
        $this->db->where('harga.id', $id);
        return $this->db->get()->row();
    }
    public function pendapatane() {
        $nilai = "BERHASIL";
        $this->db->select_sum('harga');
        $this->db->from('jasa');
        $this->db->where('MONTH(tanggal)', date('m'));
        $this->db->where('YEAR(tanggal)', date('Y'));
        $this->db->where('status', $nilai);
        return $this->db->get()->row();
    }
    public function pendinge() {
        $nilai = "PESAN";
        $this->db->from('jasa');
        $this->db->where('status', $nilai);
        return $this->db->get()->num_rows();
    }
    public function penjualane() {
        $nilai = "BERHASIL";
        $this->db->from('jasa');
        $this->db->where('status', $nilai);
        return $this->db->get()->num_rows();
    }
    public function penggunane() {
        $nilai = 4;
        $this->db->from('user');
        $this->db->where('level_user', $nilai);
        return $this->db->get()->num_rows();
    }
    public function get_monthly_data() {
        $query = $this->db->query("SELECT MONTH(tanggal) AS MONTH, SUM(harga) AS total_amount FROM jasa GROUP BY MONTH(tanggal)");
        return $query->result_array();
    }
    public function get_monthly() {
        $query = $this->db->query("SELECT MONTH(tanggal) AS tanggale, SUM(harga) AS total_transaksi FROM jasa WHERE YEAR(tanggal) = YEAR(CURRENT_DATE()) GROUP BY MONTH(tanggal)");
        $monthly_data = array_fill(0, 12, 0); // Menginisialisasi array dengan nilai 0 untuk setiap bulan

        // Mengisi data bulanan dari hasil query
        foreach ($query->result() as $row) {
            $monthly_data[$row->tanggale - 1] = $row->total_transaksi;
        }

        return $monthly_data;
    }
}
                        
/* End of file DataMaster.php */
