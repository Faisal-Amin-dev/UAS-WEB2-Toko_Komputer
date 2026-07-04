<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu!');
            redirect('auth');
        }

        $this->load->model('M_produk');
        $this->load->model('M_kategori');
    }

    public function index() {
        $data['title'] = 'Dashboard';
        $data['user'] = array(
            'nama_lengkap' => $this->session->userdata('nama_lengkap'),
            'role'         => $this->session->userdata('role')
        );
        $data['total_produk']   = $this->M_produk->count_all_produk();
        $data['total_kategori'] = $this->db->count_all('kategori');
        $data['total_users']    = $this->db->count_all('users');
        $data['total_penjualan'] = $this->db->count_all('penjualan');
        $data['total_pendapatan'] = $this->db->query("SELECT COALESCE(SUM(total_bayar), 0) as total FROM penjualan")->row()->total;
        $data['recent_penjualan'] = $this->db->order_by('tanggal_transaksi', 'DESC')->limit(5)->get('penjualan')->result();
        $this->load->view('dashboard/v_dashboard', $data);
    }
}