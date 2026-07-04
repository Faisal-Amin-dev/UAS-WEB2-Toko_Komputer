<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Penjualan</title>
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
    <div class="subtitle">Laporan Data Penjualan - <?= date('d/m/Y'); ?></div>
    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th>Nota</th>
                <th>Tanggal</th>
                <th>Kasir</th>
                <th>Total Bayar</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($penjualan as $p) : ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td><?= $p->nota_transaksi; ?></td>
                <td><?= date('d/m/Y H:i', strtotime($p->tanggal_transaksi)); ?></td>
                <td><?= $p->nama_lengkap; ?></td>
                <td class="text-right">Rp <?= number_format($p->total_bayar, 0, ',', '.'); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>