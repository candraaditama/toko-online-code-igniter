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
  <!-- Font Awesome 6 (with v4 shims for legacy "fa fa-*" icons) -->
  <link rel="stylesheet" href="<?=base_url();?>assets/tema/lte/plugins/font-awesome/css/all.min.css">
  <link rel="stylesheet" href="<?=base_url();?>assets/tema/lte/plugins/font-awesome/css/v4-shims.min.css">
  <!-- Bootstrap 5.3 -->
  <link rel="stylesheet" href="<?=base_url();?>assets/tema/lte/bootstrap/css/bootstrap.min.css">
  <!-- AdminLTE 4 -->
  <link rel="stylesheet" href="<?=base_url();?>assets/tema/lte/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?=base_url();?>assets/tema/lte/dist/css/legacy.css">
</head>
<body class="login-page bg-body-secondary">
<div class="login-box">
  <div class="login-logo">
    <a href="<?=base_url('login');?>"><b><?=$appname;?></b></a>
  </div>
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>
      <?php
      $info=$this->session->flashdata('info');
      if(!empty($info))
      {
        echo '<div class="alert alert-danger">'.$info.'</div>';
      }
      echo validation_errors();
      ?>
      <form action="<?=base_url();?>login" method="post">
        <div class="input-group mb-3">
          <input type="text" name="username" class="form-control" placeholder="Username" value="<?=set_value('username');?>">
          <span class="input-group-text"><i class="fa fa-user"></i></span>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <span class="input-group-text"><i class="fa fa-lock"></i></span>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="remember">
              <label class="form-check-label" for="remember">Remember Me</label>
            </div>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary w-100">Sign In</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- jQuery 3.7.1 -->
<script src="<?=base_url();?>assets/tema/lte/plugins/jQuery/jQuery-3.7.1.min.js"></script>
<!-- Bootstrap 5.3 bundle -->
<script src="<?=base_url();?>assets/tema/lte/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE 4 -->
<script src="<?=base_url();?>assets/tema/lte/dist/js/adminlte.min.js"></script>
</body>
</html>
