<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    
    public function __construct() {
        parent::__construct();
        
        // Cek jika user BELUM login, langsung usir ke halaman login
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu!');
            redirect('auth');
        }
    }

    public function index() {
        // Halaman ini aman, hanya bisa dilihat kalau sudah login 
        $this->load->view('dashboard/v_main');
    }
}