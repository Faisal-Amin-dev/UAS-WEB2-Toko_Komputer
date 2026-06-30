<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Memuat model M_auth secara manual jika belum ada di autoload.php
        $this->load->model('M_auth');
    }

    // Menampilkan Halaman Login
    public function index() {
        // Jika user sudah login, langsung alihkan ke dashboard, tidak perlu login lagi
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }
        $this->load->view('auth/v_login');
    }

    // Memproses Aksi Login
    public function login_process() {
        // 1. Atur Aturan Validasi Form
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            // Jika inputan kosong atau tidak valid, kembalikan ke view login
            $this->index();
        } else {
            $username = $this->input->post('username', true);
            $password = $this->input->post('password', true);

            // 2. Cari user di database melalui model
            $user = $this->M_auth->check_login($username);

            if ($user) {
                // 3. Jika user ditemukan, verifikasi password hash
                if (password_verify($password, $user['password'])) {
                    
                    // 4. Jika password cocok, susun data session
                    $session_data = array(
                        'id_user'      => $user['id_user'],
                        'username'     => $user['username'],
                        'nama_lengkap' => $user['nama_lengkap'],
                        'role'         => $user['role'],
                        'logged_in'    => TRUE
                    );
                    
                    // Simpan ke session CodeIgniter
                    $this->session->set_userdata($session_data);
                    
                    // Set flash message sukses (Ketentuan UAS)
                    $this->session->set_flashdata('pesan', 'Selamat datang, ' . $user['nama_lengkap'] . '!');
                    redirect('dashboard');

                } else {
                    // Jika password salah
                    $this->session->set_flashdata('error', 'Password yang Anda masukkan salah!');
                    redirect('auth');
                }
            } else {
                // Jika user tidak ditemukan
                $this->session->set_flashdata('error', 'Username tidak terdaftar!');
                redirect('auth');
            }
        }
    }

    // Fungsi Logout untuk Menghapus Session
    public function logout() {
        $this->session->sess_destroy(); // Hancurkan seluruh session aktif
        redirect('auth');
    }
}