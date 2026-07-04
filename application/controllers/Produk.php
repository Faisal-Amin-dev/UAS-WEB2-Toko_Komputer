<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu!');
            redirect('auth');
        }
        $this->load->model('M_produk');
        $this->load->model('M_kategori');
        $this->load->library('pagination');
        $this->load->helper('file');
    }

    private function _is_admin() {
        if ($this->session->userdata('role') !== 'admin') {
            $this->session->set_flashdata('error', 'Akses ditolak! Hanya admin yang bisa melakukan aksi ini.');
            redirect('dashboard');
        }
    }

    private function _upload_gambar() {
        if (!empty($_FILES['gambar']['name'])) {
            $config['upload_path'] = './assets/uploads/produk/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048;
            $config['file_name'] = 'produk_' . time();

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('gambar')) {
                return $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                return false;
            }
        }
        return null;
    }

    public function index() {
        $search = $this->input->get('search');
        $kategori_filter = $this->input->get('id_kategori');

        $config['base_url'] = base_url('produk/index');
        $config['total_rows'] = $this->M_produk->count_all_produk($search, $kategori_filter);
        $config['per_page'] = 5;
        $config['reuse_query_string'] = TRUE;

        $config['full_tag_open'] = '<nav><ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['attributes'] = array('class' => 'page-link');

        $this->pagination->initialize($config);

        $start = $this->uri->segment(3, 0);
        $data['produk'] = $this->M_produk->get_produk_with_kategori($config['per_page'], $start, $search, $kategori_filter);
        $data['pagination'] = $this->pagination->create_links();
        $data['kategori_list'] = $this->M_kategori->get_all_kategori();
        $data['search'] = $search;
        $data['id_kategori'] = $kategori_filter;
        $data['title'] = 'Data Produk';
        $data['user'] = array(
            'nama_lengkap' => $this->session->userdata('nama_lengkap'),
            'role'         => $this->session->userdata('role')
        );

        $this->load->view('produk/index', $data);
    }

    public function create() {
        $this->_is_admin();
        $data['kategori_list'] = $this->M_kategori->get_all_kategori();

        $this->form_validation->set_rules('nama_produk', 'Nama Produk', 'required|trim');
        $this->form_validation->set_rules('harga_jual', 'Harga Jual', 'required|numeric');
        $this->form_validation->set_rules('stok', 'Stok', 'required|numeric');
        $this->form_validation->set_rules('id_kategori', 'Kategori', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Tambah Produk';
            $data['produk'] = null;
            $data['user'] = array(
                'nama_lengkap' => $this->session->userdata('nama_lengkap'),
                'role'         => $this->session->userdata('role')
            );
            $this->load->view('produk/form', $data);
        } else {
            $gambar = $this->_upload_gambar();
            if ($gambar === false) {
                redirect('produk/create');
            }

            $insert = array(
                'nama_produk' => $this->input->post('nama_produk', true),
                'harga_jual'  => $this->input->post('harga_jual', true),
                'stok'        => $this->input->post('stok', true),
                'id_kategori' => $this->input->post('id_kategori', true),
                'gambar'      => $gambar ?: 'default.jpg'
            );

            $this->M_produk->insert_produk($insert);
            $this->session->set_flashdata('pesan', 'Produk berhasil ditambahkan!');
            redirect('produk');
        }
    }

    public function edit($id) {
        $this->_is_admin();
        $data['produk'] = $this->M_produk->get_produk_by_id($id);
        if (!$data['produk']) {
            $this->session->set_flashdata('error', 'Produk tidak ditemukan!');
            redirect('produk');
        }
        $data['kategori_list'] = $this->M_kategori->get_all_kategori();

        $this->form_validation->set_rules('nama_produk', 'Nama Produk', 'required|trim');
        $this->form_validation->set_rules('harga_jual', 'Harga Jual', 'required|numeric');
        $this->form_validation->set_rules('stok', 'Stok', 'required|numeric');
        $this->form_validation->set_rules('id_kategori', 'Kategori', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Edit Produk';
            $data['user'] = array(
                'nama_lengkap' => $this->session->userdata('nama_lengkap'),
                'role'         => $this->session->userdata('role')
            );
            $this->load->view('produk/form', $data);
        } else {
            $gambar = $this->_upload_gambar();
            if ($gambar === false) {
                redirect('produk/edit/' . $id);
            }

            $update = array(
                'nama_produk' => $this->input->post('nama_produk', true),
                'harga_jual'  => $this->input->post('harga_jual', true),
                'stok'        => $this->input->post('stok', true),
                'id_kategori' => $this->input->post('id_kategori', true)
            );

            if ($gambar) {
                $old = $data['produk']->gambar;
                if ($old !== 'default.jpg' && file_exists('./assets/uploads/produk/' . $old)) {
                    unlink('./assets/uploads/produk/' . $old);
                }
                $update['gambar'] = $gambar;
            }

            $this->M_produk->update_produk($id, $update);
            $this->session->set_flashdata('pesan', 'Produk berhasil diubah!');
            redirect('produk');
        }
    }

    public function delete($id) {
        $this->_is_admin();
        $produk = $this->M_produk->get_produk_by_id($id);
        if (!$produk) {
            $this->session->set_flashdata('error', 'Produk tidak ditemukan!');
            redirect('produk');
        }
        if ($produk->gambar !== 'default.jpg' && file_exists('./assets/uploads/produk/' . $produk->gambar)) {
            unlink('./assets/uploads/produk/' . $produk->gambar);
        }
        $this->M_produk->delete_produk($id);
        $this->session->set_flashdata('pesan', 'Produk berhasil dihapus!');
        redirect('produk');
    }
}
