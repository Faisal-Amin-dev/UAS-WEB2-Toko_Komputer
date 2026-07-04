<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Toko Komputer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1a237e 0%, #0d47a1 50%, #01579b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0,0,0,.3);
        }
        .login-header {
            background: #1a237e;
            padding: 30px;
            text-align: center;
            color: #fff;
        }
        .login-header .icon {
            font-size: 3rem;
            margin-bottom: 10px;
            color: #ffc107;
        }
        .login-header h4 {
            font-weight: 600;
            margin: 0;
        }
        .login-header p {
            opacity: .7;
            margin: 5px 0 0;
            font-size: .9rem;
        }
        .login-body {
            background: #fff;
            padding: 30px;
        }
        .login-body .form-group {
            position: relative;
        }
        .login-body .form-group .input-icon {
            position: absolute;
            left: 12px;
            top: 38px;
            color: #aaa;
        }
        .login-body .form-control {
            padding-left: 38px;
            border-radius: 8px;
            height: 45px;
            border: 1px solid #e0e0e0;
        }
        .login-body .form-control:focus {
            border-color: #0d47a1;
            box-shadow: 0 0 0 .2rem rgba(13,71,161,.25);
        }
        .btn-login {
            background: #0d47a1;
            border: none;
            border-radius: 8px;
            height: 45px;
            font-weight: 600;
            color: #fff;
            transition: opacity .3s;
        }
        .btn-login:hover {
            opacity: .85;
            color: #fff;
        }
        .login-footer {
            text-align: center;
            padding: 12px 30px;
            background: #f8f9fc;
            color: #999;
            font-size: .85rem;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card login-card">
                <div class="login-header">
                    <div class="icon"><i class="fas fa-laptop"></i></div>
                    <h4>Toko Komputer</h4>
                    <p>Sistem Informasi Penjualan</p>
                </div>
                <div class="login-body">
                    <?php if($this->session->flashdata('error')) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle mr-1"></i> <?= $this->session->flashdata('error'); ?>
                        </div>
                    <?php endif; ?>
                    <form action="<?= base_url('auth/login_process'); ?>" method="POST">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" class="form-control" id="username" name="username" value="<?= set_value('username'); ?>" placeholder="Masukkan username">
                            <small class="text-danger"><?= form_error('username'); ?></small>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password">
                            <small class="text-danger"><?= form_error('password'); ?></small>
                        </div>
                        <button type="submit" class="btn btn-login btn-block"><i class="fas fa-sign-in-alt mr-1"></i> Masuk</button>
                    </form>
                </div>
                <div class="login-footer">
                    &copy; <?= date('Y'); ?> Toko Komputer
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>