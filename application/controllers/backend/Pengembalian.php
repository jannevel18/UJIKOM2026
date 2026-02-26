<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pengembalian extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        if ($this->session->userdata('logged') <> 1) {
            redirect(site_url('login-sistem'));
        }
        $this->load->model('pengembalian_model','mdl');
    }
    
    public function index() {
        $this->load->library('Temp');
        $data_peminjaman = $this->mdl->findPeminjaman();
        $data = array(
            'content' => 'backend/form/pengembalian',
            'resultPeminjaman' => $data_peminjaman,
        );
        $this->temp->display('index', $data);
    }
    
    public function peminjaman($id) {
        $row = $this->mdl->findPeminjamanById($id);
        echo json_encode($row);
    }
    
    public function viewDetailPeminjaman($id) {
        $peminjamanDetail = $this->mdl->findPeminjamanDetail($id);
        if($peminjamanDetail){
            $no = 1;
            foreach ($peminjamanDetail as $rs) {
                echo '
                <tr>
                    <td class="text-center">'.$no.'</td>
                    <td class="">
                        <strong>Kode:</strong> '.$rs->kode_buku.'<br>
                        <strong>Judul:</strong> '.$rs->judul.'<br>
                        <strong>Pengarang:</strong> '.$rs->pengarang.'<br>
                        <strong>Penerbit:</strong> '.$rs->penerbit.'
                    </td>
                    <td class="text-center">'.$rs->qty.'</td>
                </tr>
                ';
                $no++;
            }
        } else {
            echo '<tr><td colspan="3" class="text-center">Tidak ada buku</td></tr>';
        }
    }
    
    public function save() {
        $peminjaman_id = $this->input->post("peminjaman_id");
        $tgl_pengembalian = $this->input->post("tgl_pengembalian");
        $denda = $this->input->post("denda") ?: 0;
        
        if(empty($peminjaman_id) || empty($tgl_pengembalian)) {
            echo json_encode(array("status" => false, "message" => "Data tidak lengkap"));
            return;
        }

        $cek = $this->db->get_where('pengembalian', ['peminjaman_id' => $peminjaman_id])->row();
        if($cek) {
            echo json_encode(array("status" => false, "message" => "Buku sudah pernah dikembalikan"));
            return;
        }
        
        $this->db->trans_start();
        
        $data_pengembalian = array(
            'peminjaman_id' => $peminjaman_id,
            'tgl_pengembalian' => $tgl_pengembalian,
            'denda' => $denda
        );
        $this->db->insert('pengembalian', $data_pengembalian);
        $this->db->where('id', $peminjaman_id)
                 ->update('peminjaman', array('status' => 'dikembalikan'));
        $peminjamanDetail = $this->mdl->findPeminjamanDetail($peminjaman_id);
        foreach($peminjamanDetail as $buku) {
            $this->db->set('stok', 'stok + ' . (int)$buku->qty, FALSE)
                     ->where('id', $buku->buku_id)
                     ->update('buku');
        }
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status()) {
            echo json_encode(array("status" => true, "message" => "Pengembalian berhasil!"));
        } else {
            echo json_encode(array("status" => false, "message" => "Gagal memproses pengembalian"));
        }
    }
}