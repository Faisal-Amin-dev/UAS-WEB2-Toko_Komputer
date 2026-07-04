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
                <a href="<?= base_url('kategori'); ?>" class="nav-link text-white"><i class="fas fa-tags mr-2"></i>Kategori</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('produk'); ?>" class="nav-link text-white"><i class="fas fa-box mr-2"></i>Produk</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('penjualan'); ?>" class="nav-link text-white"><i class="fas fa-shopping-cart mr-2"></i>Penjualan</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('users'); ?>" class="nav-link text-white active"><i class="fas fa-users mr-2"></i>Users</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('laporan'); ?>" class="nav-link text-white"><i class="fas fa-file-alt mr-2"></i>Laporan</a>
            </li>
            <li class="nav-item mt-4">
                <a href="<?= base_url('auth/logout'); ?>" class="nav-link text-danger"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a>
            </li>
        </ul>
    </div>
    <div class="flex-grow-1 p-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4 class="mb-0"><?= $title; ?></h4>
                    </div>
                    <div class="card-body">
                        <?php if ($this->session->flashdata('error')) : ?>
                            <div class="alert alert-danger alert-dismissible fade show"><?= $this->session->flashdata('error'); ?></div>
                        <?php endif; ?>
                        <?= form_open(isset($user_data) ? base_url('users/edit/' . $user_data->id_user) : base_url('users/create')); ?>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?= set_value('username', $user_data->username ?? ''); ?>">
                                <?= form_error('username', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label for="password">Password <?= isset($user_data) ? '<small class="text-muted">(Kosongkan jika tidak diganti)</small>' : ''; ?></label>
                                <input type="password" class="form-control" id="password" name="password" value="<?= set_value('password'); ?>">
                                <?= form_error('password', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label for="nama_lengkap">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?= set_value('nama_lengkap', $user_data->nama_lengkap ?? ''); ?>">
                                <?= form_error('nama_lengkap', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select class="form-control" id="role" name="role">
                                    <option value="">-- Pilih Role --</option>
                                    <option value="admin" <?= set_select('role', 'admin', isset($user_data) && $user_data->role == 'admin'); ?>>Admin</option>
                                    <option value="petugas" <?= set_select('role', 'petugas', isset($user_data) && $user_data->role == 'petugas'); ?>>Petugas</option>
                                </select>
                                <?= form_error('role', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="<?= base_url('users'); ?>" class="btn btn-secondary">Kembali</a>
                        <?= form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>