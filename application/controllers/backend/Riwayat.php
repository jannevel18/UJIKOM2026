<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Riwayat extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        if ($this->session->userdata('logged') <> 1) {
            redirect(site_url('login-sistem'));
        }
        $this->load->model('Riwayat_model','mdl');
    }
    
    public function index() {
        $this->load->library('Temp');
        
        $data = array(
            'content' => 'backend/form/riwayat',
            'resultPeminjaman' => $this->mdl->findPeminjaman(),
        );
        
        $this->temp->display('index', $data);
    }
    
    public function viewBuku($id) {
        $peminjamanDetail = $this->mdl->findPeminjamanDetail($id);
        
        if($peminjamanDetail) {
            $no = 1;
            foreach ($peminjamanDetail as $rs) {
                echo '
                <tr>
                    <td class="text-center">'.$no.'</td>
                    <td>
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
}