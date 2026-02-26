<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Register extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('anggota_model', 'mdl');
    }
    
    public function index() {
        $this->load->view('backend/form/register');
    }
    
    public function ajax($action = '') {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        header('Content-Type: application/json');
        
        switch($action) {
            case 'save':
                $this->_save();
                break;
            default:
                echo json_encode(['status' => false, 'message' => 'Action tidak valid']);
        }
    }
    
    private function _save() {
        $this->form_validation->set_rules('nis', 'NIS', 'required');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('kelas', 'Kelas', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[3]');
        
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array(
                "status" => false,
                "message" => validation_errors()
            ));
            return;
        }
        
        $data_user = array(
            'nama' => $this->input->post("nama"),
            'username' => $this->input->post("username"),
            'password' => $this->input->post('password'),
            'role' => 'siswa'
        );

        $id_user = $this->mdl->save($data_user);
        
        if($id_user) {
            $data_anggota = array(
                'user_id' => $id_user,
                'nis' => $this->input->post("nis"),
                'kelas' => $this->input->post("kelas"),
                'alamat' => $this->input->post("alamat"),
                'status' => 'aktif'
            );
            
            $query = $this->mdl->save_anggota($data_anggota);
            
            if($query) {
                echo json_encode(array(
                    "status" => true,
                    "message" => "Registrasi berhasil! Silakan login."
                ));
            } else {
                echo json_encode(array(
                    "status" => false,
                    "message" => "Gagal menyimpan data anggota"
                ));
            }
        } else {
            echo json_encode(array(
                "status" => false,
                "message" => "Gagal menyimpan data user"
            ));
        }
    }
}