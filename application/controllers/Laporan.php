<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH . 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Laporan extends CI_Controller {

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
        $data['title'] = 'Laporan';
        $data['user'] = array(
            'nama_lengkap' => $this->session->userdata('nama_lengkap'),
            'role'         => $this->session->userdata('role')
        );
        $this->load->view('laporan/index', $data);
    }

    // ==================== PDF ====================

    public function produk_pdf() {
        $produk = $this->M_produk->get_produk_with_kategori(999, 0);
        $html = $this->load->view('laporan/pdf_produk', ['produk' => $produk], true);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('laporan-produk-' . date('Ymd') . '.pdf', ['Attachment' => true]);
    }

    public function penjualan_pdf() {
        $penjualan = $this->db->select('penjualan.*, users.nama_lengkap')
            ->from('penjualan')
            ->join('users', 'penjualan.id_user = users.id_user')
            ->order_by('penjualan.tanggal_transaksi', 'DESC')
            ->get()->result();

        $html = $this->load->view('laporan/pdf_penjualan', ['penjualan' => $penjualan], true);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('laporan-penjualan-' . date('Ymd') . '.pdf', ['Attachment' => true]);
    }

    // ==================== EXCEL ====================

    public function produk_excel() {
        $produk = $this->M_produk->get_produk_with_kategori(999, 0);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Produk');

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Produk');
        $sheet->setCellValue('C1', 'Kategori');
        $sheet->setCellValue('D1', 'Harga Jual');
        $sheet->setCellValue('E1', 'Stok');

        $row = 2;
        $no = 1;
        foreach ($produk as $p) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $p->nama_produk);
            $sheet->setCellValue('C' . $row, $p->nama_kategori);
            $sheet->setCellValue('D' . $row, $p->harga_jual);
            $sheet->setCellValue('E' . $row, $p->stok);
            $row++;
        }

        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'laporan-produk-' . date('Ymd') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function penjualan_excel() {
        $penjualan = $this->db->select('penjualan.*, users.nama_lengkap')
            ->from('penjualan')
            ->join('users', 'penjualan.id_user = users.id_user')
            ->order_by('penjualan.tanggal_transaksi', 'DESC')
            ->get()->result();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Penjualan');

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nota');
        $sheet->setCellValue('C1', 'Tanggal');
        $sheet->setCellValue('D1', 'Kasir');
        $sheet->setCellValue('E1', 'Total Bayar');

        $row = 2;
        $no = 1;
        foreach ($penjualan as $p) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $p->nota_transaksi);
            $sheet->setCellValue('C' . $row, $p->tanggal_transaksi);
            $sheet->setCellValue('D' . $row, $p->nama_lengkap);
            $sheet->setCellValue('E' . $row, $p->total_bayar);
            $row++;
        }

        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'laporan-penjualan-' . date('Ymd') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    // ==================== CETAK ====================

    public function cetak_produk() {
        $data['produk'] = $this->M_produk->get_produk_with_kategori(999, 0);
        $data['title'] = 'Laporan Data Produk';
        $this->load->view('laporan/cetak_produk', $data);
    }

    public function cetak_penjualan() {
        $data['penjualan'] = $this->db->select('penjualan.*, users.nama_lengkap')
            ->from('penjualan')
            ->join('users', 'penjualan.id_user = users.id_user')
            ->order_by('penjualan.tanggal_transaksi', 'DESC')
            ->get()->result();
        $data['title'] = 'Laporan Data Penjualan';
        $this->load->view('laporan/cetak_penjualan', $data);
    }
}
