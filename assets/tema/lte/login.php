<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?=$judul;?></title>
  <link rel="shortcut icon" href="<?php echo tema_logo();?>" type="image/x-icon" />
  <link rel="apple-touch-icon-precomposed" href="<?php echo tema_logo();?>">
  <script>
  (function () {
    try {
      var mode = localStorage.getItem('theme');
      if (mode !== 'dark' && mode !== 'light') {
        mode = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
      }
      document.documentElement.setAttribute('data-bs-theme', mode);
    } catch (e) {}
  })();
  </script>
  <!-- Font Awesome 6 (with v4 shims for legacy "fa fa-*" icons) -->
  <link rel="stylesheet" href="<?=base_url();?>assets/tema/lte/plugins/font-awesome/css/all.min.css">
  <link rel="stylesheet" href="<?=base_url();?>assets/tema/lte/plugins/font-awesome/css/v4-shims.min.css">
  <!-- Bootstrap 5.3 -->
  <link rel="stylesheet" href="<?=base_url();?>assets/tema/lte/bootstrap/css/bootstrap.min.css">
  <!-- AdminLTE 4 -->
  <link rel="stylesheet" href="<?=base_url();?>assets/tema/lte/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?=base_url();?>assets/tema/lte/dist/css/legacy.css">
  <link rel="stylesheet" href="<?=base_url();?>assets/tema/lte/dist/css/admin-theme.css">
</head>
<body class="login-page bg-body-secondary">
<button type="button" class="theme-toggle js-theme-toggle" aria-label="Ganti tema" title="Mode gelap">
  <i class="fa fa-moon"></i>
</button>

<div class="login-box">
  <div class="login-logo">
    <a href="<?=base_url('login');?>"><b><?=$appname;?></b></a>
  </div>

  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Masuk untuk memulai sesi Anda</p>

      <?php
      $info=$this->session->flashdata('info');
      if(!empty($info))
      {
        echo '<div class="alert alert-danger">'.$info.'</div>';
      }
      echo validation_errors();
      ?>

      <form action="<?=base_url();?>login" method="post">
        <div class="mb-3">
          <label class="form-label" for="username">Username</label>
          <div class="input-group">
            <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan username" value="<?=set_value('username');?>" autocomplete="username" autofocus>
            <span class="input-group-text"><i class="fa fa-user"></i></span>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label" for="password">Password</label>
          <div class="input-group">
            <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" autocomplete="current-password">
            <span class="input-group-text"><i class="fa fa-lock"></i></span>
          </div>
        </div>

        <div class="d-flex align-items-center justify-content-between mb-3">
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="remember">
            <label class="form-check-label" for="remember">Ingat saya</label>
          </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2">
          <i class="fa fa-sign-in me-2"></i> Masuk
        </button>
      </form>

      <div class="login-footer">
        &copy; <?=date('Y');?> <?=$appname;?>
      </div>
    </div>
  </div>
</div>

<!-- jQuery 3.7.1 -->
<script src="<?=base_url();?>assets/tema/lte/plugins/jQuery/jQuery-3.7.1.min.js"></script>
<!-- Bootstrap 5.3 bundle -->
<script src="<?=base_url();?>assets/tema/lte/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE 4 -->
<script src="<?=base_url();?>assets/tema/lte/dist/js/adminlte.min.js"></script>
<!-- Light / dark theme toggle -->
<script src="<?=base_url();?>assets/theme.js"></script>
</body>
</html>
