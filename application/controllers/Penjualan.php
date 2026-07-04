<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu!');
            redirect('auth');
        }
        $this->load->model('M_produk');
    }

    private function _is_admin() {
        if ($this->session->userdata('role') !== 'admin') {
            $this->session->set_flashdata('error', 'Akses ditolak! Hanya admin yang bisa melakukan aksi ini.');
            redirect('penjualan');
        }
    }

    private function _generate_nota() {
        $this->db->select_max('id_penjualan');
        $row = $this->db->get('penjualan')->row();
        $next = ($row->id_penjualan ?? 0) + 1;
        return 'NOTA-' . date('Ymd') . '-' . str_pad($next, 4, '0', STR_PAD_LEFT);
    }

    public function index() {
        $search = $this->input->get('search');
        $tanggal = $this->input->get('tanggal');

        $this->db->select('penjualan.*, users.nama_lengkap');
        $this->db->from('penjualan');
        $this->db->join('users', 'penjualan.id_user = users.id_user');

        if (!empty($search)) {
            $this->db->like('penjualan.nota_transaksi', $search);
        }
        if (!empty($tanggal)) {
            $this->db->where('DATE(penjualan.tanggal_transaksi)', $tanggal);
        }

        $this->db->order_by('penjualan.tanggal_transaksi', 'DESC');
        $data['penjualan'] = $this->db->get()->result();
        $data['search'] = $search;
        $data['tanggal'] = $tanggal;
        $data['title'] = 'Data Penjualan';
        $data['user'] = array(
            'nama_lengkap' => $this->session->userdata('nama_lengkap'),
            'role'         => $this->session->userdata('role')
        );
        $this->load->view('penjualan/index', $data);
    }

    public function create() {
        $data['title'] = 'Transaksi Penjualan';
        $data['produk'] = $this->M_produk->get_produk_with_kategori(999, 0);
        $data['nota'] = $this->_generate_nota();
        $data['user'] = array(
            'nama_lengkap' => $this->session->userdata('nama_lengkap'),
            'role'         => $this->session->userdata('role')
        );
        $this->load->view('penjualan/create', $data);
    }

    public function store() {
        $id_produk = $this->input->post('id_produk');
        $jumlah_beli = $this->input->post('jumlah_beli');

        if (empty($id_produk) || empty($jumlah_beli)) {
            $this->session->set_flashdata('error', 'Pilih minimal satu produk!');
            redirect('penjualan/create');
        }

        $this->db->trans_start();

        $nota = $this->_generate_nota();
        $total_bayar = 0;
        $detail = array();

        foreach ($id_produk as $i => $pid) {
            $jml = (int) $jumlah_beli[$i];
            if ($jml <= 0) continue;

            $produk = $this->M_produk->get_produk_by_id($pid);
            if (!$produk) continue;
            if ($produk->stok < $jml) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', "Stok {$produk->nama_produk} tidak mencukupi (sisa: {$produk->stok})!");
                redirect('penjualan/create');
            }

            $subtotal = $produk->harga_jual * $jml;
            $total_bayar += $subtotal;

            $detail[] = array(
                'id_produk'   => $pid,
                'jumlah_beli' => $jml,
                'subtotal'    => $subtotal
            );

            $this->db->where('id_produk', $pid);
            $this->db->set('stok', "stok - $jml", FALSE);
            $this->db->update('produk');
        }

        if (empty($detail)) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Tidak ada produk valid yang dipilih!');
            redirect('penjualan/create');
        }

        $penjualan = array(
            'nota_transaksi'    => $nota,
            'tanggal_transaksi' => date('Y-m-d H:i:s'),
            'total_bayar'       => $total_bayar,
            'id_user'           => $this->session->userdata('id_user')
        );

        $this->db->insert('penjualan', $penjualan);
        $id_penjualan = $this->db->insert_id();

        foreach ($detail as &$d) {
            $d['id_penjualan'] = $id_penjualan;
        }
        $this->db->insert_batch('detail_penjualan', $detail);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error', 'Transaksi gagal diproses!');
            redirect('penjualan/create');
        }

        $this->session->set_flashdata('pesan', "Transaksi $nota berhasil!");
        redirect('penjualan/detail/' . $id_penjualan);
    }

    public function detail($id) {
        $data['penjualan'] = $this->db->select('penjualan.*, users.nama_lengkap')
            ->from('penjualan')
            ->join('users', 'penjualan.id_user = users.id_user')
            ->where('penjualan.id_penjualan', $id)
            ->get()->row();

        if (!$data['penjualan']) {
            $this->session->set_flashdata('error', 'Transaksi tidak ditemukan!');
            redirect('penjualan');
        }

        $data['detail'] = $this->db->select('detail_penjualan.*, produk.nama_produk, produk.harga_jual')
            ->from('detail_penjualan')
            ->join('produk', 'detail_penjualan.id_produk = produk.id_produk')
            ->where('detail_penjualan.id_penjualan', $id)
            ->get()->result();

        $data['title'] = 'Detail Penjualan';
        $data['user'] = array(
            'nama_lengkap' => $this->session->userdata('nama_lengkap'),
            'role'         => $this->session->userdata('role')
        );
        $this->load->view('penjualan/detail', $data);
    }

    public function delete($id) {
        $this->_is_admin();
        $penjualan = $this->db->get_where('penjualan', array('id_penjualan' => $id))->row();
        if (!$penjualan) {
            $this->session->set_flashdata('error', 'Transaksi tidak ditemukan!');
            redirect('penjualan');
        }

        $detail = $this->db->get_where('detail_penjualan', array('id_penjualan' => $id))->result();
        foreach ($detail as $d) {
            $this->db->set('stok', "stok + {$d->jumlah_beli}", FALSE);
            $this->db->where('id_produk', $d->id_produk);
            $this->db->update('produk');
        }

        $this->db->where('id_penjualan', $id)->delete('detail_penjualan');
        $this->db->where('id_penjualan', $id)->delete('penjualan');

        $this->session->set_flashdata('pesan', "Transaksi {$penjualan->nota_transaksi} berhasil dibatalkan!");
        redirect('penjualan');
    }
}
