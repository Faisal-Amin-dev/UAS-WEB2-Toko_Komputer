<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Toko Komputer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-sm mt-5">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Aplikasi Toko Komputer</h3>
                    
                    <?php if($this->session->flashdata('error')) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('error'); ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('auth/login_process'); ?>" method="POST">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= set_value('username'); ?>">
                            <small class="text-danger"><?= form_error('username'); ?></small>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <small class="text-danger"><?= form_error('password'); ?></small>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Masuk</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>