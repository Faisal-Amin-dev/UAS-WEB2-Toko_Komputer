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
                <a href="<?= base_url('penjualan'); ?>" class="nav-link text-white active"><i class="fas fa-shopping-cart mr-2"></i>Penjualan</a>
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
            <a href="<?= base_url('penjualan'); ?>" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left mr-1"></i>Kembali</a>
        </div>

        <?php if ($this->session->flashdata('error')) : ?>
            <div class="alert alert-danger alert-dismissible fade show"><?= $this->session->flashdata('error'); ?></div>
        <?php endif; ?>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Nota:</strong> <?= $nota; ?>
                    </div>
                    <div class="col-md-6 text-right">
                        <strong>Tanggal:</strong> <?= date('d/m/Y H:i'); ?>
                    </div>
                </div>
            </div>
        </div>

        <?= form_open('penjualan/store'); ?>
        <div class="card shadow-sm">
            <div class="card-header">
                <h6 class="mb-0">Pilih Produk</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="produk-table">
                        <thead class="thead-light">
                            <tr>
                                <th width="30"><input type="checkbox" id="check-all"></th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th width="150">Jumlah Beli</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($produk)) : ?>
                                <?php foreach ($produk as $i => $p) : ?>
                                    <tr>
                                        <td><input type="checkbox" name="id_produk[]" value="<?= $p->id_produk; ?>" class="produk-check" data-index="<?= $i; ?>"></td>
                                        <td><?= $p->nama_produk; ?></td>
                                        <td><?= $p->nama_kategori; ?></td>
                                        <td>Rp <?= number_format($p->harga_jual, 0, ',', '.'); ?></td>
                                        <td class="text-center"><?= $p->stok; ?></td>
                                        <td>
                                            <input type="number" name="jumlah_beli[<?= $i; ?>]" class="form-control form-control-sm jumlah-beli" value="1" min="1" max="<?= $p->stok; ?>" disabled>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr><td colspan="6" class="text-center">Tidak ada produk tersedia.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <button type="submit" class="btn btn-success btn-block mt-3" id="btn-submit"><i class="fas fa-save mr-1"></i>Proses Transaksi</button>
            </div>
        </div>
        <?= form_close(); ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('#check-all').change(function() {
        $('.produk-check').prop('checked', this.checked).trigger('change');
    });

    $('.produk-check').change(function() {
        var index = $(this).data('index');
        $('.jumlah-beli').eq(index).prop('disabled', !this.checked);
        if (!this.checked) {
            $('.jumlah-beli').eq(index).val(1);
        }
    });
});
</script>
</body>
</html>