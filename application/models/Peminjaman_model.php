<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peminjaman_model extends CI_Model {
    
    public function findAnggota() {
        $level = $this->session->userdata('level');
        $id_user = $this->session->userdata('id_user');

        $this->db->select('a.*, u.nama');
        $this->db->from('anggota a');
        $this->db->join('users u', 'u.id = a.user_id');
        $this->db->where('a.status', 'aktif');
        if($level == 'siswa') {
            $this->db->where('u.id', $id_user);
        }

        $this->db->order_by('u.nama', 'ASC');
        return $this->db->get()->result();
    }
    
    public function findBuku() {
        $this->db->select('*');
        $this->db->from('buku');
        $this->db->where('stok >', 0);
        $this->db->order_by('judul', 'ASC');
        return $this->db->get()->result();
    }
}