<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?> - Toko Komputer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><?= $title; ?></h4>
            <a href="<?= base_url('produk/create'); ?>" class="btn btn-primary btn-sm">Tambah Produk</a>
        </div>
        <div class="card-body">
            <?php if ($this->session->flashdata('pesan')) : ?>
                <div class="alert alert-success alert-dismissible fade show"><?= $this->session->flashdata('pesan'); ?></div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show"><?= $this->session->flashdata('error'); ?></div>
            <?php endif; ?>
            <form method="GET" class="form-inline mb-3">
                <input type="text" class="form-control mr-2 mb-2" name="search" placeholder="Cari produk..." value="<?= $search ?? ''; ?>">
                <select class="form-control mr-2 mb-2" name="id_kategori">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($kategori_list as $k) : ?>
                        <option value="<?= $k->id_kategori; ?>" <?= ($id_kategori == $k->id_kategori) ? 'selected' : ''; ?>><?= $k->nama_kategori; ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-info mb-2">Filter</button>
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
                                        <a href="<?= base_url('produk/edit/' . $p->id_produk); ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="<?= base_url('produk/delete/' . $p->id_produk); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</a>
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
</body>
</html>
