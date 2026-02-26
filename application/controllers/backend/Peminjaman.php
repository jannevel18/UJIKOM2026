<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Peminjaman extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged')) {
            redirect(site_url('login-sistem'));
        }
        
        $this->load->model('peminjaman_model','mdl');
    }
    
    public function index() {
        $this->load->library('Temp');
        $this->session->unset_userdata('cart_peminjaman');
        $data = array(
            'content' => 'backend/form/peminjaman',
            'resultAnggota' => $this->mdl->findAnggota(),
            'resultBuku' => $this->mdl->findBuku(),
        );
        
        $this->temp->display('index', $data);
    }
    
    public function ajax($action = '') {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        header('Content-Type: application/json');
        
        switch($action) {
            case 'tambah_buku':
                $this->_tambah_buku();
                break;
                
            case 'update_qty':
                $this->_update_qty();
                break;
                
            case 'hapus_buku':
                $this->_hapus_buku();
                break;
                
            case 'view_cart':
                $this->_view_cart();
                break;
                
            case 'simpan':
                $this->_simpan_peminjaman();
                break;
                
            default:
                echo json_encode(['status' => false, 'message' => 'Action tidak valid']);
        }
    }
    
    private function _tambah_buku() {
        $buku_id = $this->input->post('id_buku');
        $qty = $this->input->post('qty') ?: 1;
        
        $buku = $this->db->get_where('buku', ['id' => $buku_id])->row();    
        if (!$buku) {
            echo json_encode(['status' => false, 'message' => 'Buku tidak ditemukan']);
            return;
        }
        
        $cart = $this->session->userdata('cart_peminjaman') ?: [];
        
        if (isset($cart[$buku_id])) {
            echo json_encode(['status' => false, 'message' => 'Buku sudah ada dalam daftar']);
            return;
        }
        
        if ($buku->stok < $qty) {
            echo json_encode(['status' => false, 'message' => 'Stok tidak mencukupi. Tersedia: ' . $buku->stok]);
            return;
        }
        
        $cart[$buku_id] = [
            'buku_id' => $buku->id,
            'kode_buku' => $buku->kode_buku,
            'judul' => $buku->judul,
            'pengarang' => $buku->pengarang,
            'penerbit' => $buku->penerbit,
            'tahun' => $buku->tahun,
            'qty' => $qty,
            'stok_tersedia' => $buku->stok
        ];
        
        $this->session->set_userdata('cart_peminjaman', $cart);
        
        echo json_encode([
            'status' => true, 
            'message' => 'Buku berhasil ditambahkan',
            'cart_count' => count($cart)
        ]);
    }
    
    private function _update_qty() {
        $buku_id = $this->input->post('buku_id');
        $qty = $this->input->post('qty');
        
        $cart = $this->session->userdata('cart_peminjaman');
        
        if (!isset($cart[$buku_id])) {
            echo json_encode(['status' => false, 'message' => 'Buku tidak ditemukan di keranjang']);
            return;
        }
        
        $buku = $this->db->get_where('buku', ['id' => $buku_id])->row();
        if ($buku->stok < $qty) {
            echo json_encode(['status' => false, 'message' => 'Stok tidak mencukupi. Maksimal: ' . $buku->stok]);
            return;
        }
        
        $cart[$buku_id]['qty'] = $qty;
        $this->session->set_userdata('cart_peminjaman', $cart);
        
        echo json_encode([
            'status' => true, 
            'message' => 'Jumlah buku diupdate',
            'cart_count' => count($cart)
        ]);
    }
    
    private function _hapus_buku() {
        $buku_id = $this->input->post('buku_id');
        $cart = $this->session->userdata('cart_peminjaman');
        
        if (isset($cart[$buku_id])) {
            unset($cart[$buku_id]);
            $this->session->set_userdata('cart_peminjaman', $cart);
            
            echo json_encode([
                'status' => true, 
                'message' => 'Buku berhasil dihapus',
                'cart_count' => count($cart)
            ]);
        } else {
            echo json_encode(['status' => false, 'message' => 'Buku tidak ditemukan di cart']);
        }
    }
    
    private function _view_cart() {
        $cart = $this->session->userdata('cart_peminjaman');
        
        if (empty($cart)) {
            echo json_encode([
                'status' => true,
                'html' => '<tr><td colspan="5" class="text-center">Belum ada buku dipilih</td></tr>',
                'cart_count' => 0
            ]);
            return;
        }
        
        $html = '';
        $no = 1;
        foreach ($cart as $item) {
            $html .= '
            <tr>
                <td class="text-center">'.$no.'</td>
                <td>
                    <strong>Kode:</strong> '.$item['kode_buku'].'<br>
                    <strong>Judul:</strong> '.$item['judul'].'<br>
                    <strong>Pengarang:</strong> '.$item['pengarang'].'
                </td>
                <td class="text-center">
                    <div class="input-group input-group-sm" style="width: 100px; margin: 0 auto;">
                        <input type="number" class="form-control text-center qty-input" 
                               data-id="'.$item['buku_id'].'" 
                               value="'.$item['qty'].'" 
                               min="1" 
                               max="'.$item['stok_tersedia'].'">
                    </div>
                </td>
                <td class="text-center">'.$item['stok_tersedia'].'</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-danger btn-hapus-buku" data-id="'.$item['buku_id'].'">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>';
            $no++;
        }
        
        echo json_encode([
            'status' => true,
            'html' => $html,
            'cart_count' => count($cart)
        ]);
    }
    
    private function _simpan_peminjaman() {
        if (empty($this->input->post('anggota_id'))) {
            echo json_encode(['status' => false, 'message' => 'Pilih anggota terlebih dahulu']);
            return;
        }
        
        if (empty($this->input->post('tgl_pinjam')) || empty($this->input->post('tgl_kembali'))) {
            echo json_encode(['status' => false, 'message' => 'Tanggal pinjam dan kembali harus diisi']);
            return;
        }
        
        $cart = $this->session->userdata('cart_peminjaman');
        if (empty($cart)) {
            echo json_encode(['status' => false, 'message' => 'Tambahkan buku terlebih dahulu']);
            return;
        }
        
        $no_pinjam = "PJ-" . date('YmdHis') . rand(100, 999);
        
        $data_peminjaman = [
            'no_peminjaman' => $no_pinjam,
            'anggota_id' => $this->input->post('anggota_id'),
            'tgl_pinjam' => $this->input->post('tgl_pinjam'),
            'tgl_kembali' => $this->input->post('tgl_kembali'),
            'status' => 'dipinjam',
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->trans_start();
        $this->db->insert('peminjaman', $data_peminjaman);
        $peminjaman_id = $this->db->insert_id();
        
        foreach ($cart as $item) {
            $detail = [
                'peminjaman_id' => $peminjaman_id,
                'buku_id' => $item['buku_id'],
                'qty' => $item['qty']
            ];
            $this->db->insert('peminjaman_detail', $detail);
            $this->db->where('id', $item['buku_id'])
                     ->set('stok', 'stok - ' . (int)$item['qty'], false)
                     ->update('buku');
        }

        $this->db->trans_complete();
        
        if ($this->db->trans_status()) {
            $this->session->unset_userdata('cart_peminjaman');
            
            echo json_encode([
                'status' => true,
                'message' => 'Peminjaman berhasil disimpan! No. Peminjaman: ' . $no_pinjam
            ]);
        } else {
            echo json_encode(['status' => false, 'message' => 'Gagal menyimpan peminjaman']);
        }
    }
}