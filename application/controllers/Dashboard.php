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

        // Chart data: penjualan per bulan (6 bulan terakhir)
        $chart_penjualan = $this->db->query("
            SELECT DATE_FORMAT(tanggal_transaksi, '%Y-%m') as bulan, COUNT(*) as jumlah, SUM(total_bayar) as total
            FROM penjualan
            WHERE tanggal_transaksi >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
            GROUP BY DATE_FORMAT(tanggal_transaksi, '%Y-%m')
            ORDER BY bulan ASC
        ")->result();

        $data['chart_labels'] = array_map(function($r) {
            $bulan = explode('-', $r->bulan);
            $nama_bulan = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            return $nama_bulan[(int)$bulan[1]] . ' ' . $bulan[0];
        }, $chart_penjualan);
        $data['chart_jumlah'] = array_map(function($r) { return (int)$r->jumlah; }, $chart_penjualan);
        $data['chart_total'] = array_map(function($r) { return (int)$r->total; }, $chart_penjualan);

        // Chart data: produk per kategori
        $chart_kategori = $this->db->query("
            SELECT kategori.nama_kategori, COUNT(produk.id_produk) as jumlah
            FROM kategori
            LEFT JOIN produk ON kategori.id_kategori = produk.id_kategori
            GROUP BY kategori.id_kategori
            ORDER BY jumlah DESC
        ")->result();

        $data['chart_kategori_labels'] = array_map(function($r) { return $r->nama_kategori; }, $chart_kategori);
        $data['chart_kategori_jumlah'] = array_map(function($r) { return (int)$r->jumlah; }, $chart_kategori);

        $this->load->view('dashboard/v_dashboard', $data);
    }
}