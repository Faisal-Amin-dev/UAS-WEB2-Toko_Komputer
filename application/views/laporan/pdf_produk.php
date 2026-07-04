<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Produk</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 5px; }
        .subtitle { text-align: center; color: #666; margin-bottom: 20px; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 6px 8px; text-align: left; }
        th { background: #1a237e; color: #fff; text-align: center; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h2>TOKO KOMPUTER</h2>
    <div class="subtitle">Laporan Data Produk - <?= date('d/m/Y'); ?></div>
    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga Jual</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($produk as $p) : ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td><?= $p->nama_produk; ?></td>
                <td><?= $p->nama_kategori; ?></td>
                <td class="text-right">Rp <?= number_format($p->harga_jual, 0, ',', '.'); ?></td>
                <td class="text-center"><?= $p->stok; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>