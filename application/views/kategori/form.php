<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?> - Toko Komputer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0"><?= $title; ?></h4>
                </div>
                <div class="card-body">
                    <?php if ($this->session->flashdata('error')) : ?>
                        <div class="alert alert-danger alert-dismissible fade show"><?= $this->session->flashdata('error'); ?></div>
                    <?php endif; ?>
                    <?= form_open(($kategori ? base_url('kategori/edit/' . $kategori->id_kategori) : base_url('kategori/create'))); ?>
                        <div class="form-group">
                            <label for="nama_kategori">Nama Kategori</label>
                            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="<?= set_value('nama_kategori', $kategori->nama_kategori ?? ''); ?>">
                            <?= form_error('nama_kategori', '<small class="text-danger">', '</small>'); ?>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="<?= base_url('kategori'); ?>" class="btn btn-secondary">Kembali</a>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
