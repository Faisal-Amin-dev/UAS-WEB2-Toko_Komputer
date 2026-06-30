<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body class="p-5">
    <div class="container">
        <div class="jumbotron">
            <h1 class="display-4">Halo, <?= $user['nama_lengkap']; ?>!</h1>
            <p class="lead">Anda login sebagai <strong><?= strtoupper($user['role']); ?></strong>.</p>
            <hr class="my-4">
            <p>Sistem Informasi Penjualan Toko Komputer siap dikembangkan.</p>
            <a class="btn btn-danger btn-lg" href="<?= base_url('auth/logout'); ?>" role="button">Keluar / Logout</a>
        </div>
    </div>
</body>
</html>