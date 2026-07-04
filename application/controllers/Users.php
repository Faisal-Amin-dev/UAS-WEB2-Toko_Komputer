<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu!');
            redirect('auth');
        }
        
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

    public function create() {
        $data['title'] = 'Tambah User';

        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[users.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[4]');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('role', 'Role', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['user'] = array(
                'nama_lengkap' => $this->session->userdata('nama_lengkap'),
                'role'         => $this->session->userdata('role')
            );
            $this->load->view('users/v_form', $data);
        } else {
            $insert = array(
                'username'     => $this->input->post('username', true),
                'password'     => password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
                'nama_lengkap' => $this->input->post('nama_lengkap', true),
                'role'         => $this->input->post('role', true)
            );

            $this->db->insert('users', $insert);
            $this->session->set_flashdata('pesan', 'User berhasil ditambahkan!');
            redirect('users');
        }
    }

    public function edit($id) {
        $data['user_data'] = $this->db->get_where('users', array('id_user' => $id))->row();
        if (!$data['user_data']) {
            $this->session->set_flashdata('error', 'User tidak ditemukan!');
            redirect('users');
        }

        $data['title'] = 'Edit User';

        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('role', 'Role', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['user'] = array(
                'nama_lengkap' => $this->session->userdata('nama_lengkap'),
                'role'         => $this->session->userdata('role')
            );
            $this->load->view('users/v_form', $data);
        } else {
            $update = array(
                'username'     => $this->input->post('username', true),
                'nama_lengkap' => $this->input->post('nama_lengkap', true),
                'role'         => $this->input->post('role', true)
            );

            $password = $this->input->post('password', true);
            if ($password !== '') {
                $update['password'] = password_hash($password, PASSWORD_DEFAULT);
            }

            $this->db->where('id_user', $id);
            $this->db->update('users', $update);
            $this->session->set_flashdata('pesan', 'User berhasil diubah!');
            redirect('users');
        }
    }

    public function delete($id) {
        $user = $this->db->get_where('users', array('id_user' => $id))->row();
        if (!$user) {
            $this->session->set_flashdata('error', 'User tidak ditemukan!');
            redirect('users');
        }

        $this->db->where('id_user', $id);
        $this->db->delete('users');
        $this->session->set_flashdata('pesan', 'User berhasil dihapus!');
        redirect('users');
    }
}