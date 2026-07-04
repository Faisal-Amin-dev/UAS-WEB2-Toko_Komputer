<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu!');
            redirect('auth');
        }
        $this->load->model('M_kategori');
    }

    private function _is_admin() {
        if ($this->session->userdata('role') !== 'admin') {
            $this->session->set_flashdata('error', 'Akses ditolak! Hanya admin yang bisa melakukan aksi ini.');
            redirect('dashboard');
        }
    }

    public function index() {
        $data['title'] = 'Data Kategori';
        $data['kategori'] = $this->M_kategori->get_all_kategori();
        $data['user'] = array(
            'nama_lengkap' => $this->session->userdata('nama_lengkap'),
            'role'         => $this->session->userdata('role')
        );
        $this->load->view('kategori/index', $data);
    }

    public function create() {
        $this->_is_admin();
        $this->form_validation->set_rules('nama_kategori', 'Nama Kategori', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Tambah Kategori';
            $data['kategori'] = null;
            $data['user'] = array(
                'nama_lengkap' => $this->session->userdata('nama_lengkap'),
                'role'         => $this->session->userdata('role')
            );
            $this->load->view('kategori/form', $data);
        } else {
            $this->M_kategori->insert_kategori(array(
                'nama_kategori' => $this->input->post('nama_kategori', true)
            ));
            $this->session->set_flashdata('pesan', 'Kategori berhasil ditambahkan!');
            redirect('kategori');
        }
    }

    public function edit($id) {
        $this->_is_admin();
        $data['kategori'] = $this->M_kategori->get_kategori_by_id($id);
        if (!$data['kategori']) {
            $this->session->set_flashdata('error', 'Kategori tidak ditemukan!');
            redirect('kategori');
        }

        $this->form_validation->set_rules('nama_kategori', 'Nama Kategori', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Edit Kategori';
            $data['user'] = array(
                'nama_lengkap' => $this->session->userdata('nama_lengkap'),
                'role'         => $this->session->userdata('role')
            );
            $this->load->view('kategori/form', $data);
        } else {
            $this->M_kategori->update_kategori($id, array(
                'nama_kategori' => $this->input->post('nama_kategori', true)
            ));
            $this->session->set_flashdata('pesan', 'Kategori berhasil diubah!');
            redirect('kategori');
        }
    }

    public function delete($id) {
        $this->_is_admin();
        $kategori = $this->M_kategori->get_kategori_by_id($id);
        if (!$kategori) {
            $this->session->set_flashdata('error', 'Kategori tidak ditemukan!');
            redirect('kategori');
        }
        $this->M_kategori->delete_kategori($id);
        $this->session->set_flashdata('pesan', 'Kategori berhasil dihapus!');
        redirect('kategori');
    }
}
