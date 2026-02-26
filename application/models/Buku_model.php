<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Buku_model extends CI_Model { 

    function simpan_data($data) { 
        return $this->db->insert('buku', $data); 
    } 

    function find() { 
        $this->db->from('buku');
        $this->db->order_by('kode_buku', 'ASC'); 
        return $this->db->get()->result(); 
    } 

    function findById($id) { 
        $this->db->from('buku'); 
        $this->db->where('id', $id); 
        return $this->db->get()->row(); 
    } 

    function update($id, $data) { 
        $this->db->where('id', $id); 
        return $this->db->update('buku', $data); 
    } 
    
    function delete($id) { 
        $this->db->where('id', $id); 
        return $this->db->delete('buku'); 
    } 
}