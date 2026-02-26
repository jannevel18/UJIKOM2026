<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Buku extends CI_Controller { 

    public function __construct() { 
        parent::__construct(); 

        if ($this->session->userdata('logged') <> 1) { 
            redirect(site_url('login-sistem')); 
        } else { 
            $this->load->model('buku_model','mdl'); 
        } 

        $this->role = $this->session->userdata('level');
    } 

    function index() { 
        $this->load->library('Temp'); 
        $data = array( 
           'content' => 'backend/form/buku',
           'result'  => $this->mdl->find(),
           'role'    => $this->role
       ); 
        $this->temp->display('index',$data); 
    } 
    
    function get_next_kode() {
        $this->db->select('kode_buku');
        $this->db->from('buku');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        
        if($query->num_rows() > 0) {
            $row = $query->row();
            $kode_terakhir = $row->kode_buku;
            $angka = (int)substr($kode_terakhir, 3);
            $angka_baru = $angka + 1;
            $kode_baru = 'BK-' . str_pad($angka_baru, 6, '0', STR_PAD_LEFT);
        } else {
            $kode_baru = 'BK-000001';
        }
        
        echo json_encode(['kode' => $kode_baru]);
    }
    
    
    function save() {
        $this->db->select('kode_buku');
        $this->db->from('buku');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        
        if($query->num_rows() > 0) {
            $row = $query->row();
            $kode_terakhir = $row->kode_buku;
            $angka = (int)substr($kode_terakhir, 3);
            $angka_baru = $angka + 1;
            $kode_buku = 'BK-' . str_pad($angka_baru, 6, '0', STR_PAD_LEFT);
        } else {
            $kode_buku = 'BK-000001';
        }
        
        $data = array( 
            'kode_buku' => $kode_buku,
            'judul'     => $this->input->post("judul"), 
            'pengarang' => $this->input->post("pengarang"), 
            'penerbit'  => $this->input->post("penerbit"), 
            'tahun'     => $this->input->post("tahun"), 
            'stok'      => $this->input->post("stok"), 
        ); 

        $query = $this->mdl->simpan_data($data); 
        if($query){ 
            echo json_encode(['status' => true, 'message' => 'Data berhasil disimpan. Kode: ' . $kode_buku]);  
        } else {    
            echo json_encode(['status' => false, 'message' => 'Gagal menyimpan data']);  
        } 
    } 

    function update() {
        $data = array( 
            'judul'     => $this->input->post("judul"), 
            'pengarang' => $this->input->post("pengarang"), 
            'penerbit'  => $this->input->post("penerbit"), 
            'tahun'     => $this->input->post("tahun"), 
            'stok'      => $this->input->post("stok"), 
        ); 
         
        $query = $this->mdl->update($this->input->post('id_buku'), $data); 
        if($query) {
            echo json_encode(['status' => true, 'message' => 'Data berhasil diupdate']);  
        } else {
            echo json_encode(['status' => false, 'message' => 'Gagal update data']);  
        }
    } 

    function edit() { 
        $id = $this->input->post('id');
        $data = $this->mdl->findById($id); 
        echo json_encode($data); 
    } 

    function delete() { 
        $id = $this->input->post('id');
        $query = $this->mdl->delete($id); 
        if($query) {
            echo json_encode(['status' => true, 'message' => 'Data berhasil dihapus']);  
        } else {
            echo json_encode(['status' => false, 'message' => 'Gagal hapus data']);  
        }
    } 
}