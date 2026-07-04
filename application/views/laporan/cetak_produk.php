<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?> - Toko Komputer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        @media print {
            .no-print { display: none !important; }
            body { font-size: 12px; }
        }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin-bottom: 0; }
        .header small { color: #666; }
    </style>
</head>
<body>
    <div class="container-fluid p-4">
        <div class="no-print mb-3">
            <button class="btn btn-primary" onclick="window.print()"><i class="fas fa-print mr-1"></i>Cetak</button>
            <a href="<?= base_url('laporan'); ?>" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i>Kembali</a>
        </div>

        <div class="header">
            <h2>TOKO KOMPUTER</h2>
            <small>Laporan Data Produk - <?= date('d/m/Y H:i'); ?></small>
        </div>

        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th width="30">No</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga Jual</th>
                    <th>Stok</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($produk)) : ?>
                    <?php $no = 1; foreach ($produk as $p) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $p->nama_produk; ?></td>
                        <td><?= $p->nama_kategori; ?></td>
                        <td>Rp <?= number_format($p->harga_jual, 0, ',', '.'); ?></td>
                        <td class="text-center"><?= $p->stok; ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr><td colspan="5" class="text-center">Tidak ada data produk.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/js/all.min.js"></script>
</body>
</html>