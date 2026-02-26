<?php defined('BASEPATH') OR exit('No direct script access allowed');
 class Anggota_model extends CI_Model {
    function save($data) {
    $this->db->insert('users',$data);
    return $this->db->insert_id();
    }

    function save_anggota($data) {
        $query = $this->db->insert('anggota',$data);
        return $query;
    }
    
    function find() {
        $this->db->select("anggota.*, users.nama");
        $this->db->from('anggota');
        $this->db->join("users","users.id = anggota.user_id");
        $this->db->order_by('users.id','ASC');
        $query = $this->db->get()->result();
        return $query;
    }
    
    function findById($id) {
        $this->db->select("anggota.*, users.nama, users.username");
        $this->db->from('anggota');
        $this->db->join("users","users.id = anggota.user_id");
        $this->db->where('anggota.id',$id);
        $this->db->order_by('users.id','ASC');
        $query = $this->db->get()->row();
        return $query;
    }
    
    function update_user($id, $data) {
        $this->db->where('id',$id); 
        $query = $this->db->update('users',$data);
        return $query;
    }
    
    function update_anggota($id, $data) {
        $this->db->where('id',$id);
        $query = $this->db->update('anggota',$data);
        return $query;
    }
    
    function delete($user_id) {
        $this->db->trans_start();
        $this->db->where('user_id', $user_id);
        $this->db->delete('anggota');
        $this->db->where('id', $user_id);
        $this->db->delete('users');
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
 }