<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayat_model extends CI_Model {
    
    public function findPeminjaman() {
        $level = $this->session->userdata('level');
        $id_user = $this->session->userdata('id_user');
        
        $this->db->select("peminjaman.*, anggota.nis, anggota.kelas, users.nama");
        $this->db->from('peminjaman');
        $this->db->join("anggota", "anggota.id = peminjaman.anggota_id");
        $this->db->join("users", "users.id = anggota.user_id");
        if($level == 'siswa') {
        $this->db->where('users.id', $id_user);
        }
        
        $this->db->order_by('peminjaman.tgl_pinjam', 'DESC');
        
        $query = $this->db->get();
        return $query->result();
    }
    
    public function findPeminjamanDetail($id) {
        $this->db->select("peminjaman_detail.*, buku.kode_buku, buku.judul, buku.pengarang, buku.penerbit");
        $this->db->from('peminjaman_detail');
        $this->db->join("buku", "buku.id = peminjaman_detail.buku_id");
        $this->db->where('peminjaman_detail.peminjaman_id', $id);
        
        $query = $this->db->get();
        return $query->result();
    }
}