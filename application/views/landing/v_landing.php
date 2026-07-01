<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Komputer - Sistem Informasi Penjualan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body { padding-top: 56px; }
        .hero {
            background: linear-gradient(135deg, #1a237e 0%, #0d47a1 50%, #01579b 100%);
            color: #fff;
            padding: 100px 0;
            margin-top: -56px;
        }
        .hero h1 { font-size: 3rem; font-weight: 700; }
        .hero p { font-size: 1.2rem; opacity: 0.9; }
        .hero .btn-cta {
            padding: 12px 36px;
            font-size: 1.1rem;
            border-radius: 50px;
            font-weight: 600;
        }
        .feature-icon {
            font-size: 2.5rem;
            color: #0d47a1;
        }
        .feature-card {
            border: none;
            border-radius: 12px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.12);
        }
        .about {
            background-color: #f8f9fa;
        }
        footer {
            background-color: #1a237e;
            color: rgba(255,255,255,0.8);
        }
        footer a { color: rgba(255,255,255,0.8); }
        footer a:hover { color: #fff; text-decoration: none; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: #1a237e;">
    <div class="container">
        <a class="navbar-brand font-weight-bold" href="<?= base_url(); ?>">
            <i class="fas fa-laptop mr-2"></i>Toko Komputer
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active"><a class="nav-link" href="#beranda">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="#fitur">Fitur</a></li>
                <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
                <li class="nav-item ml-lg-3">
                    <a class="btn btn-light btn-sm font-weight-bold px-4" href="<?= base_url('auth'); ?>">
                        <i class="fas fa-sign-in-alt mr-1"></i>Masuk
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<section id="beranda" class="hero text-center">
    <div class="container">
        <h1 class="mb-3">Sistem Informasi Penjualan Toko Komputer</h1>
        <p class="lead mb-4">Kelola produk, kategori, stok barang dan transaksi penjualan<br>dengan mudah dalam satu sistem terintegrasi.</p>
        <a href="<?= base_url('auth'); ?>" class="btn btn-warning btn-cta">
            <i class="fas fa-arrow-right mr-2"></i>Mulai Sekarang
        </a>
    </div>
</section>

<section id="fitur" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="font-weight-bold">Mengapa Memilih Kami?</h2>
            <p class="text-muted">Fitur unggulan yang memudahkan pengelolaan toko komputer Anda</p>
        </div>
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card feature-card h-100 text-center p-4 shadow-sm">
                    <div class="card-body">
                        <div class="feature-icon mb-3"><i class="fas fa-tags"></i></div>
                        <h5 class="card-title font-weight-bold">Kategori Produk</h5>
                        <p class="card-text text-muted">Kelola kategori produk seperti Laptop, Desktop, Aksesoris, dan Printer secara terstruktur.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card feature-card h-100 text-center p-4 shadow-sm">
                    <div class="card-body">
                        <div class="feature-icon mb-3"><i class="fas fa-box"></i></div>
                        <h5 class="card-title font-weight-bold">Data Produk</h5>
                        <p class="card-text text-muted">Input, edit, dan hapus produk lengkap dengan gambar, harga, dan stok.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card feature-card h-100 text-center p-4 shadow-sm">
                    <div class="card-body">
                        <div class="feature-icon mb-3"><i class="fas fa-warehouse"></i></div>
                        <h5 class="card-title font-weight-bold">Manajemen Stok</h5>
                        <p class="card-text text-muted">Pantau ketersediaan stok barang secara real-time untuk menghindari kehabisan.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card feature-card h-100 text-center p-4 shadow-sm">
                    <div class="card-body">
                        <div class="feature-icon mb-3"><i class="fas fa-users-cog"></i></div>
                        <h5 class="card-title font-weight-bold">Multi User</h5>
                        <p class="card-text text-muted">Dukungan dua level akses (Admin & Petugas) untuk keamanan data.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="tentang" class="about py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h2 class="font-weight-bold">Tentang Aplikasi</h2>
                <p class="text-muted lead">Aplikasi ini dikembangkan sebagai proyek UAS mata kuliah Web 2.</p>
                <p class="text-muted">Dibangun menggunakan framework CodeIgniter 3 dengan database MySQL. Aplikasi ini menyediakan fitur CRUD untuk produk dan kategori, sistem autentikasi multi-level, serta manajemen stok barang untuk mendukung operasional toko komputer.</p>
                <ul class="list-unstyled text-muted">
                    <li class="mb-2"><i class="fas fa-check-circle text-success mr-2"></i>Antarmuka responsif berbasis Bootstrap 4</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success mr-2"></i>Autentikasi aman dengan password terenkripsi</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success mr-2"></i>Pencarian dan filter produk</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success mr-2"></i>Upload gambar produk</li>
                </ul>
            </div>
            <div class="col-lg-6 text-center">
                <i class="fas fa-laptop-code" style="font-size: 10rem; color: #0d47a1; opacity: 0.15;"></i>
            </div>
        </div>
    </div>
</section>

<footer class="py-4">
    <div class="container text-center">
        <p class="mb-1">
            <i class="fas fa-laptop mr-1"></i>
            <strong>Toko Komputer</strong> &mdash; Sistem Informasi Penjualan
        </p>
        <p class="mb-0 small">
            &copy; <?= date('Y'); ?> Project UAS Web 2
        </p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>