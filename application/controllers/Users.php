<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    
    public function __construct() {
        parent::__construct();
        
        // Proteksi 1: Pastikan sudah login
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu!');
            redirect('auth');
        }
        
        // Proteksi 2: Pastikan yang login adalah 'admin'. Jika 'petugas' yang masuk, TENDANG! 
        if ($this->session->userdata('role') !== 'admin') {
            $this->session->set_flashdata('error', 'Akses ditolak! Petugas tidak boleh masuk ke menu ini.');
            redirect('dashboard'); 
        }
    }

    public function index() {
        $data['title'] = 'Data Users';
        $data['users'] = $this->db->get('users')->result();
        $data['user'] = array(
            'nama_lengkap' => $this->session->userdata('nama_lengkap'),
            'role'         => $this->session->userdata('role')
        );
        $this->load->view('users/v_list', $data);
    }
}