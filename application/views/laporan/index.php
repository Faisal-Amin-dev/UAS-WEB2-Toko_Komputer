<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?> - Toko Komputer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">
    <style>
        .report-card { transition: transform .2s, box-shadow .2s; cursor: pointer; border: none; border-radius: 12px; }
        .report-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,.15); }
        .report-icon { font-size: 2.5rem; }
    </style>
</head>
<body class="bg-light">
<div class="d-flex" style="min-height: 100vh;">
    <div class="text-white" style="width: 250px; min-height: 100vh; background: #1a237e;">
        <div class="p-3 text-center border-bottom border-secondary">
            <h5 class="mb-0">Toko Komputer</h5>
            <small>Sistem Informasi Penjualan</small>
        </div>
        <div class="p-3 border-bottom border-secondary">
            <div class="d-flex align-items-center">
                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mr-2" style="width: 40px; height: 40px; font-weight: bold;">
                    <?= strtoupper(substr($user['nama_lengkap'], 0, 1)); ?>
                </div>
                <div>
                    <strong><?= $user['nama_lengkap']; ?></strong><br>
                    <small class="text-muted"><?= strtoupper($user['role']); ?></small>
                </div>
            </div>
        </div>
        <ul class="nav flex-column p-3">
            <li class="nav-item">
                <a href="<?= base_url('dashboard'); ?>" class="nav-link text-white"><i class="fas fa-tachometer-alt mr-2"></i>Dashboard</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('kategori'); ?>" class="nav-link text-white"><i class="fas fa-tags mr-2"></i>Kategori</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('produk'); ?>" class="nav-link text-white"><i class="fas fa-box mr-2"></i>Produk</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('penjualan'); ?>" class="nav-link text-white"><i class="fas fa-shopping-cart mr-2"></i>Penjualan</a>
            </li>
            <?php if ($user['role'] === 'admin') : ?>
            <li class="nav-item">
                <a href="<?= base_url('users'); ?>" class="nav-link text-white"><i class="fas fa-users mr-2"></i>Users</a>
            </li>
            <?php endif; ?>
            <li class="nav-item">
                <a href="<?= base_url('laporan'); ?>" class="nav-link text-white active"><i class="fas fa-file-alt mr-2"></i>Laporan</a>
            </li>
            <li class="nav-item mt-4">
                <a href="<?= base_url('auth/logout'); ?>" class="nav-link text-danger"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a>
            </li>
        </ul>
    </div>
    <div class="flex-grow-1 p-4">
        <h4 class="mb-4"><?= $title; ?></h4>

        <h5 class="mb-3"><i class="fas fa-box mr-2"></i>Laporan Produk</h5>
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card report-card shadow-sm" onclick="window.location='<?= base_url('laporan/cetak_produk'); ?>'">
                    <div class="card-body text-center">
                        <div class="report-icon text-primary mb-2"><i class="fas fa-print"></i></div>
                        <h6>Cetak Produk</h6>
                        <small class="text-muted">Cetak laporan data produk</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card report-card shadow-sm" onclick="window.location='<?= base_url('laporan/produk_pdf'); ?>'">
                    <div class="card-body text-center">
                        <div class="report-icon text-danger mb-2"><i class="fas fa-file-pdf"></i></div>
                        <h6>Export PDF Produk</h6>
                        <small class="text-muted">Download laporan produk (PDF)</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card report-card shadow-sm" onclick="window.location='<?= base_url('laporan/produk_excel'); ?>'">
                    <div class="card-body text-center">
                        <div class="report-icon text-success mb-2"><i class="fas fa-file-excel"></i></div>
                        <h6>Export Excel Produk</h6>
                        <small class="text-muted">Download laporan produk (Excel)</small>
                    </div>
                </div>
            </div>
        </div>

        <h5 class="mb-3"><i class="fas fa-shopping-cart mr-2"></i>Laporan Penjualan</h5>
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card report-card shadow-sm" onclick="window.location='<?= base_url('laporan/cetak_penjualan'); ?>'">
                    <div class="card-body text-center">
                        <div class="report-icon text-primary mb-2"><i class="fas fa-print"></i></div>
                        <h6>Cetak Penjualan</h6>
                        <small class="text-muted">Cetak laporan data penjualan</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card report-card shadow-sm" onclick="window.location='<?= base_url('laporan/penjualan_pdf'); ?>'">
                    <div class="card-body text-center">
                        <div class="report-icon text-danger mb-2"><i class="fas fa-file-pdf"></i></div>
                        <h6>Export PDF Penjualan</h6>
                        <small class="text-muted">Download laporan penjualan (PDF)</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card report-card shadow-sm" onclick="window.location='<?= base_url('laporan/penjualan_excel'); ?>'">
                    <div class="card-body text-center">
                        <div class="report-icon text-success mb-2"><i class="fas fa-file-excel"></i></div>
                        <h6>Export Excel Penjualan</h6>
                        <small class="text-muted">Download laporan penjualan (Excel)</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>