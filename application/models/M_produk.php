<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_produk extends CI_Model {

    public function get_all_kategori() {
        return $this->db->order_by('nama_kategori', 'ASC')->get('kategori')->result();
    }

    public function get_produk_with_kategori($limit, $start, $search = '', $id_kategori = '') {
        $this->db->select('produk.*, kategori.nama_kategori');
        $this->db->from('produk');
        $this->db->join('kategori', 'produk.id_kategori = kategori.id_kategori');

        if (!empty($search)) {
            $this->db->like('produk.nama_produk', $search);
        }
        if (!empty($id_kategori)) {
            $this->db->where('produk.id_kategori', $id_kategori);
        }

        $this->db->limit($limit, $start);
        $this->db->order_by('produk.id_produk', 'DESC');
        return $this->db->get()->result();
    }

    public function count_all_produk($search = '', $id_kategori = '') {
        $this->db->from('produk');

        if (!empty($search)) {
            $this->db->like('nama_produk', $search);
        }
        if (!empty($id_kategori)) {
            $this->db->where('id_kategori', $id_kategori);
        }

        return $this->db->count_all_results();
    }

    public function get_produk_by_id($id) {
        $this->db->select('produk.*, kategori.nama_kategori');
        $this->db->from('produk');
        $this->db->join('kategori', 'produk.id_kategori = kategori.id_kategori');
        $this->db->where('produk.id_produk', $id);
        return $this->db->get()->row();
    }

    public function insert_produk($data) {
        $this->db->insert('produk', $data);
        return $this->db->insert_id();
    }

    public function update_produk($id, $data) {
        $this->db->where('id_produk', $id);
        $this->db->update('produk', $data);
        return $this->db->affected_rows();
    }

    public function delete_produk($id) {
        $this->db->where('id_produk', $id);
        $this->db->delete('produk');
        return $this->db->affected_rows();
    }
}
