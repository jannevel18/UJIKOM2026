<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Anggota extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
            if ($this->session->userdata('logged') <> 1) {
                redirect(site_url('login-sistem'));
                    }else{
                $this->load->model('anggota_model','mdl');
        }
    }
   
    function index() {
        $this->load->library('Temp');
            $data = array(
                    'content' => 'backend/form/anggota',
                    'result' => $this->mdl->find(),
                );
        $this->temp->display('index',$data);
    }

    function save() {
        $data = array(
            'nama' => $this->input->post("nama"),
            'username' => $this->input->post("username"),
            'password' => $this->input->post('password'),
            'role' => 'siswa',
            );

        $id_user = $this->mdl->save($data);
        if($id_user) {
        $dataAnggota = array(
            'user_id' => $id_user,
            'nis' => $this->input->post("nis"),
            'kelas' => $this->input->post("kelas"),
            'alamat' => $this->input->post("alamat"), );
        $query = $this->mdl->save_anggota($dataAnggota);
            echo json_encode(array("status" => TRUE));
            }else{
            echo json_encode(array("status" => false));
        }
    }

    function update() {
        if($this->input->post('password') == "" )
        {
        $password = "";
        }
        $data = array(
            'nama' => $this->input->post("nama"),
            'username' => $this->input->post("username"),
            'role' => 'siswa',
            );
    
            if($this->input->post('password') != "" ) {
                $data['password'] = $this->input->post('password');
                };
    
        $update_user = $this->mdl->update_user($this->input->post('user_id'), $data);
        if($update_user) {
            $dataAnggota = array(
                'nis' => $this->input->post("nis"),
                'kelas' => $this->input->post("kelas"),
                'alamat' => $this->input->post("alamat"), );
            $update_user = $this->mdl->update_anggota($this->input->post('id_siswa'), $dataAnggota);
            echo json_encode(array("status" => TRUE)); 
            }else{
                echo json_encode(array("status" => false));
                }
    }
    
    function edit($id) {
        $data = $this->mdl->findById($id);
        echo json_encode($data);
    }
    
    function hapus($user_id) {
        $query = $this->mdl->delete($user_id);
        echo json_encode(array("status" => TRUE));
    }
    
    function status($id) {
        $row = $this->mdl->findById($id);
        if($row->status=="aktif") {
        
        $data = array(
            'status' => 'nonaktif' );  
        }else{
            $data = array(
            'status' => 'aktif' );
            }

        $this->mdl->update_anggota($id,$data);
        $row = $this->mdl->findById($id);
        if($row->status=='nonaktif') {
        $aktif = '<button class="btn btn-sm btn-danger" id="btn-status"onClick="status('."'".$row->id."'".')" ><i class="fa fa-eye-slash p-1" ariahidden="true"></i> Non Aktif</button>';
            }else{
        $aktif = '<button class="btn btn-sm btn-success" id="btn-status"onClick="status('."'".$row->id."'".')" ><i class="fa fa-eye p-1" ariahidden="true"></i> Aktif</button>';
        }
      
        echo $aktif;
    }
    }