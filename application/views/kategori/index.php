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
            <a href="<?= base_url('kategori/create'); ?>" class="btn btn-primary btn-sm">Tambah Kategori</a>
        </div>
        <div class="card-body">
            <?php if ($this->session->flashdata('pesan')) : ?>
                <div class="alert alert-success alert-dismissible fade show"><?= $this->session->flashdata('pesan'); ?></div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show"><?= $this->session->flashdata('error'); ?></div>
            <?php endif; ?>
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
                                        <a href="<?= base_url('kategori/edit/' . $k->id_kategori); ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="<?= base_url('kategori/delete/' . $k->id_kategori); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus kategori ini?')">Hapus</a>
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
</body>
</html>
