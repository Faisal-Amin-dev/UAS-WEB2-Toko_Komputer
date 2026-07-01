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
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0"><?= $title; ?></h4>
                </div>
                <div class="card-body">
                    <?php if ($this->session->flashdata('error')) : ?>
                        <div class="alert alert-danger alert-dismissible fade show"><?= $this->session->flashdata('error'); ?></div>
                    <?php endif; ?>
                    <?= form_open_multipart(($produk ? base_url('produk/edit/' . $produk->id_produk) : base_url('produk/create'))); ?>
                        <div class="form-group">
                            <label for="nama_produk">Nama Produk</label>
                            <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="<?= set_value('nama_produk', $produk->nama_produk ?? ''); ?>">
                            <?= form_error('nama_produk', '<small class="text-danger">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="id_kategori">Kategori</label>
                            <select class="form-control" id="id_kategori" name="id_kategori">
                                <option value="">-- Pilih Kategori --</option>
                                <?php foreach ($kategori_list as $k) : ?>
                                    <option value="<?= $k->id_kategori; ?>" <?= set_select('id_kategori', $k->id_kategori, ($produk && $produk->id_kategori == $k->id_kategori)); ?>><?= $k->nama_kategori; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('id_kategori', '<small class="text-danger">', '</small>'); ?>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="harga_jual">Harga Jual (Rp)</label>
                                <input type="number" class="form-control" id="harga_jual" name="harga_jual" value="<?= set_value('harga_jual', $produk->harga_jual ?? ''); ?>">
                                <?= form_error('harga_jual', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="stok">Stok</label>
                                <input type="number" class="form-control" id="stok" name="stok" value="<?= set_value('stok', $produk->stok ?? ''); ?>">
                                <?= form_error('stok', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="gambar">Gambar Produk</label>
                            <input type="file" class="form-control-file" id="gambar" name="gambar">
                            <?php if ($produk && $produk->gambar && $produk->gambar != 'default.jpg') : ?>
                                <div class="mt-2">
                                    <img src="<?= base_url('assets/uploads/produk/' . $produk->gambar); ?>" width="100" class="img-thumbnail" alt="Current">
                                    <small class="d-block text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
                                </div>
                            <?php endif; ?>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="<?= base_url('produk'); ?>" class="btn btn-secondary">Kembali</a>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
