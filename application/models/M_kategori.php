<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kategori extends CI_Model {

    public function get_all_kategori() {
        return $this->db->order_by('id_kategori', 'DESC')->get('kategori')->result();
    }

    public function get_kategori_by_id($id) {
        return $this->db->get_where('kategori', array('id_kategori' => $id))->row();
    }

    public function insert_kategori($data) {
        $this->db->insert('kategori', $data);
        return $this->db->insert_id();
    }

    public function update_kategori($id, $data) {
        $this->db->where('id_kategori', $id);
        $this->db->update('kategori', $data);
        return $this->db->affected_rows();
    }

    public function delete_kategori($id) {
        $this->db->where('id_kategori', $id);
        $this->db->delete('kategori');
        return $this->db->affected_rows();
    }
}
