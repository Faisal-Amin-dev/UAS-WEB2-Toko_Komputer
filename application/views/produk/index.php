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
                <a href="<?= base_url('produk'); ?>" class="nav-link text-white active"><i class="fas fa-box mr-2"></i>Produk</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('penjualan'); ?>" class="nav-link text-white"><i class="fas fa-shopping-cart mr-2"></i>Penjualan</a>
            </li>
            <?php if ($user['role'] === 'admin') : ?>
            <li class="nav-item">
                <a href="<?= base_url('users'); ?>" class="nav-link text-white"><i class="fas fa-users mr-2"></i>Users</a>
            </li>
            <?php endif; ?>
            <li class="nav-item mt-4">
                <a href="<?= base_url('auth/logout'); ?>" class="nav-link text-danger"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a>
            </li>
        </ul>
    </div>
    <div class="flex-grow-1 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0"><?= $title; ?></h4>
            <a href="<?= base_url('produk/create'); ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus mr-1"></i>Tambah Produk</a>
        </div>

        <?php if ($this->session->flashdata('pesan')) : ?>
            <div class="alert alert-success alert-dismissible fade show"><?= $this->session->flashdata('pesan'); ?></div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')) : ?>
            <div class="alert alert-danger alert-dismissible fade show"><?= $this->session->flashdata('error'); ?></div>
        <?php endif; ?>

        <div class="card shadow-sm">
            <div class="card-body">
                <form method="GET" class="form-inline mb-3">
                    <input type="text" class="form-control mr-2 mb-2" name="search" placeholder="Cari produk..." value="<?= $search ?? ''; ?>">
                    <select class="form-control mr-2 mb-2" name="id_kategori">
                        <option value="">Semua Kategori</option>
                        <?php foreach ($kategori_list as $k) : ?>
                            <option value="<?= $k->id_kategori; ?>" <?= ($id_kategori == $k->id_kategori) ? 'selected' : ''; ?>><?= $k->nama_kategori; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-primary mb-2">Filter</button>
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th width="50">No</th>
                                <th width="80">Gambar</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Harga Jual</th>
                                <th>Stok</th>
                                <th width="180">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($produk)) : ?>
                                <?php $no = 1 + ($this->uri->segment(3) ?? 0); foreach ($produk as $p) : ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><img src="<?= base_url('assets/uploads/produk/' . $p->gambar); ?>" width="50" height="50" class="img-thumbnail" alt="Gambar"></td>
                                        <td><?= $p->nama_produk; ?></td>
                                        <td><?= $p->nama_kategori; ?></td>
                                        <td><?= 'Rp ' . number_format($p->harga_jual, 0, ',', '.'); ?></td>
                                        <td><?= $p->stok; ?></td>
                                        <td>
                                            <a href="<?= base_url('produk/edit/' . $p->id_produk); ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit mr-1"></i>Edit</a>
                                            <a href="<?= base_url('produk/delete/' . $p->id_produk); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus produk ini?')"><i class="fas fa-trash mr-1"></i>Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr><td colspan="7" class="text-center">Belum ada data produk.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?= $pagination; ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>