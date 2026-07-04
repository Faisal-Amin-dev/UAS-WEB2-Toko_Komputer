<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?> - Toko Komputer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
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
                <a href="<?= base_url('dashboard'); ?>" class="nav-link text-white active"><i class="fas fa-tachometer-alt mr-2"></i>Dashboard</a>
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
                <a href="<?= base_url('laporan'); ?>" class="nav-link text-white"><i class="fas fa-file-alt mr-2"></i>Laporan</a>
            </li>
            <li class="nav-item mt-4">
                <a href="<?= base_url('auth/logout'); ?>" class="nav-link text-danger"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a>
            </li>
        </ul>
    </div>
    <div class="flex-grow-1 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Dashboard</h4>
            <span class="text-muted"><?= date('d F Y'); ?></span>
        </div>

        <?php if ($this->session->flashdata('pesan')) : ?>
            <div class="alert alert-success alert-dismissible fade show"><?= $this->session->flashdata('pesan'); ?></div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')) : ?>
            <div class="alert alert-danger alert-dismissible fade show"><?= $this->session->flashdata('error'); ?></div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card border-left-primary shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="text-muted small">Total Produk</div>
                                <div class="h3 mb-0 font-weight-bold"><?= $total_produk; ?></div>
                            </div>
                            <i class="fas fa-box fa-2x text-muted"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card border-left-success shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="text-muted small">Total Kategori</div>
                                <div class="h3 mb-0 font-weight-bold"><?= $total_kategori; ?></div>
                            </div>
                            <i class="fas fa-tags fa-2x text-muted"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card border-left-primary shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="text-muted small">Total Penjualan</div>
                                <div class="h3 mb-0 font-weight-bold"><?= $total_penjualan; ?></div>
                            </div>
                            <i class="fas fa-shopping-cart fa-2x text-muted"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card border-left-warning shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="text-muted small">Pendapatan</div>
                                <div class="h5 mb-0 font-weight-bold">Rp <?= number_format($total_pendapatan, 0, ',', '.'); ?></div>
                            </div>
                            <i class="fas fa-money-bill-wave fa-2x text-muted"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h6 class="mb-0">Grafik Penjualan (6 Bulan Terakhir)</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="chartPenjualan" height="120"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h6 class="mb-0">Produk per Kategori</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="chartKategori" height="180"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h6 class="mb-0">Penjualan Terbaru</h6>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nota</th>
                                    <th>Tanggal</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($recent_penjualan)) : ?>
                                    <?php foreach ($recent_penjualan as $p) : ?>
                                    <tr>
                                        <td><?= $p->nota_transaksi; ?></td>
                                        <td><?= date('d/m/Y H:i', strtotime($p->tanggal_transaksi)); ?></td>
                                        <td>Rp <?= number_format($p->total_bayar, 0, ',', '.'); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr><td colspan="3" class="text-center">Belum ada transaksi.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h6 class="mb-0">Akses Cepat</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <a href="<?= base_url('produk/create'); ?>" class="btn btn-outline-primary btn-block">
                                    <i class="fas fa-plus mr-1"></i> Tambah Produk
                                </a>
                            </div>
                            <div class="col-6 mb-3">
                                <a href="<?= base_url('kategori/create'); ?>" class="btn btn-outline-success btn-block">
                                    <i class="fas fa-plus mr-1"></i> Tambah Kategori
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="<?= base_url('produk'); ?>" class="btn btn-outline-info btn-block">
                                    <i class="fas fa-list mr-1"></i> Lihat Produk
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="<?= base_url('laporan'); ?>" class="btn btn-outline-danger btn-block">
                                    <i class="fas fa-file-alt mr-1"></i> Laporan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
const chartLabels = <?= json_encode($chart_labels ?: []); ?>;
const chartJumlah = <?= json_encode($chart_jumlah ?: []); ?>;
const chartTotal  = <?= json_encode($chart_total ?: []); ?>;

const chartKategoriLabels = <?= json_encode($chart_kategori_labels ?: []); ?>;
const chartKategoriJumlah = <?= json_encode($chart_kategori_jumlah ?: []); ?>;

if (document.getElementById('chartPenjualan')) {
    new Chart(document.getElementById('chartPenjualan'), {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Jumlah Transaksi',
                data: chartJumlah,
                backgroundColor: 'rgba(26, 35, 126, 0.7)',
                borderColor: 'rgba(26, 35, 126, 1)',
                borderWidth: 1,
                yAxisID: 'y'
            }, {
                label: 'Total (Rp)',
                data: chartTotal,
                backgroundColor: 'rgba(255, 193, 7, 0.5)',
                borderColor: 'rgba(255, 193, 7, 1)',
                borderWidth: 1,
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            interaction: { mode: 'index', intersect: false },
            plugins: { legend: { position: 'top' } },
            scales: {
                y: { beginAtZero: true, position: 'left', title: { display: true, text: 'Jumlah' } },
                y1: { beginAtZero: true, position: 'right', grid: { drawOnChartArea: false }, title: { display: true, text: 'Total (Rp)' } }
            }
        }
    });
}

if (document.getElementById('chartKategori')) {
    new Chart(document.getElementById('chartKategori'), {
        type: 'doughnut',
        data: {
            labels: chartKategoriLabels,
            datasets: [{
                data: chartKategoriJumlah,
                backgroundColor: ['#1a237e', '#0d47a1', '#01579b', '#ffc107', '#ff9800', '#4caf50', '#f44336', '#9c27b0'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } }
            }
        }
    });
}
</script>
</body>
</html>