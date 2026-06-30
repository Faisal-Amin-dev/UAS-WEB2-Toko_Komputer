<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_auth extends CI_Model {

    // Fungsi untuk mengambil data user berdasarkan username
    public function check_login($username) {
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        return $query->row_array(); // Mengembalikan 1 baris data dalam bentuk array
    }
}