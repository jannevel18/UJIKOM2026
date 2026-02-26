<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Auth_login extends CI_Controller {
        public function __construct() {
            parent::__construct();
        }
        
        public function index() {
            if ($this->session->userdata('logged') == true) {
            redirect(site_url('halaman-sistem'));
            }else{
            $data['admin'] = "";
            $this->load->view('backend/layout/login', $data);
            }
        }

        public function login() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        
        $result = $this->db
            ->where('username', $username)
            ->where('password', $password)
            ->limit(1)
            ->get('users');
        
        if ($result->num_rows() == 1) {
            $user = $result->row();
            $session_data = [
                'id_user' => $user->id,
                'username' => $user->username,
                'level' => $user->role,
                'logged' => TRUE,
                'nama' => $user->nama
            ];
            
            $this->session->set_userdata($session_data);
            if ($user->role == 'admin') {
                redirect('halaman-sistem'); 
            } else {
                redirect('halaman-sistem');
            }
            
        } else {
            $this->session->set_flashdata('error', 'Username atau password salah!');
            redirect('login-sistem');
        }
    }

        public function logout() {
        $this->session->set_flashdata('success', 'Anda berhasil logout dari sistem.');
        $this->session->sess_destroy();
        redirect(site_url('login-sistem'));
    }
}