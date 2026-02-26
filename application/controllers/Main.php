<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Main extends CI_Controller {
    public function __construct() {
        parent::__construct();

         if (!$this->session->userdata('logged')) {
         redirect(site_url('login-sistem'));
         exit;
     }
     date_default_timezone_set("Asia/Jakarta");
    }

     function index() {
         $this->load->library('Temp');
        $data = array('content' => 'backend/layout/home',);
        $this->temp->display('index',$data);
    }

}