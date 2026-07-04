<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?> - Toko Komputer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">
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
                <a href="<?= base_url('kategori'); ?>" class="nav-link text-white active"><i class="fas fa-tags mr-2"></i>Kategori</a>
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
            <h4 class="mb-0"><?= $title; ?></h4>
            <a href="<?= base_url('kategori/create'); ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus mr-1"></i>Tambah Kategori</a>
        </div>

        <?php if ($this->session->flashdata('pesan')) : ?>
            <div class="alert alert-success alert-dismissible fade show"><?= $this->session->flashdata('pesan'); ?></div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')) : ?>
            <div class="alert alert-danger alert-dismissible fade show"><?= $this->session->flashdata('error'); ?></div>
        <?php endif; ?>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th width="50">No</th>
                                <th>Nama Kategori</th>
                                <th width="180">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($kategori)) : ?>
                                <?php $no = 1; foreach ($kategori as $k) : ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $k->nama_kategori; ?></td>
                                        <td>
                                            <a href="<?= base_url('kategori/edit/' . $k->id_kategori); ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit mr-1"></i>Edit</a>
                                            <a href="<?= base_url('kategori/delete/' . $k->id_kategori); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus kategori ini?')"><i class="fas fa-trash mr-1"></i>Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr><td colspan="3" class="text-center">Belum ada data kategori.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>