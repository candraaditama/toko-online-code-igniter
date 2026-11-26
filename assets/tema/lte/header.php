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
  <!-- AdminLTE 3 colour palette (bg-aqua, bg-green, ...) -->
  <link rel="stylesheet" href="<?=base_url();?>assets/tema/lte/dist/css/adminlte-colors-v3.min.css">
  <!-- Compatibility layer for legacy AdminLTE 2 / Bootstrap 3 view markup -->
  <link rel="stylesheet" href="<?=base_url();?>assets/tema/lte/dist/css/legacy.css">
  <!-- jQuery 3.7.1 -->
  <script src="<?=base_url();?>assets/tema/lte/plugins/jQuery/jQuery-3.7.1.min.js"></script>
  <?php
  echo add_css(base_url().'assets/style.css');
  echo add_js(base_url().'assets/custom.js');
  ?>
  <!-- Panel refinements + dark mode (dimuat terakhir agar menimpa style lama) -->
  <link rel="stylesheet" href="<?=base_url();?>assets/tema/lte/dist/css/admin-theme.css">
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
<div class="app-wrapper">

  <!-- ============ Header ============ -->
  <nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button" aria-label="Toggle sidebar">
            <i class="fa fa-bars"></i>
          </a>
        </li>
      </ul>

      <ul class="navbar-nav ms-auto align-items-center gap-1">
        <li class="nav-item d-none d-sm-block">
          <a class="nav-link" href="<?=base_url();?>" target="_blank" title="Lihat toko">
            <i class="fa fa-external-link"></i>
          </a>
        </li>
        <li class="nav-item">
          <button type="button" class="theme-toggle js-theme-toggle ms-1 me-2" aria-label="Ganti tema" title="Mode gelap">
            <i class="fa fa-moon"></i>
          </button>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle user-toggle" href="#" data-bs-toggle="dropdown" role="button" aria-expanded="false">
            <img src="<?=user_photo();?>" class="avatar" alt="<?=user_info('nama');?>">
            <span class="d-none d-md-flex flex-column text-start">
              <span class="user-name"><?=user_info('nama');?></span>
              <span class="user-role"><?=user_info('akses');?></span>
            </span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end shadow">
            <li class="text-center px-3 py-3">
              <img src="<?=user_photo();?>" class="rounded-circle mb-2" style="width:72px;height:72px;object-fit:cover;" alt="<?=user_info('nama');?>">
              <div class="fw-semibold"><?=user_info('nama');?></div>
              <div class="small text-body-secondary text-capitalize"><?=user_info('akses');?></div>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="<?=base_url();?>profil"><i class="fa fa-user me-2"></i>Profile</a></li>
            <li><a class="dropdown-item" href="<?=base_url();?>logout"><i class="fa fa-sign-out me-2"></i>Sign out</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>

  <!-- ============ Sidebar ============ -->
  <aside class="app-sidebar bg-body-secondary shadow">
    <div class="sidebar-brand">
      <a href="<?=base_url(akses().'/dashboard');?>" class="brand-link">
        <span class="brand-text fw-semibold"><?=baca_konfig('nama-aplikasi');?></span>
      </a>
    </div>
    <div class="sidebar-wrapper">
      <nav class="mt-2">
        <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" data-accordion="false">
          <li class="nav-item">
            <a href="<?=base_url(akses().'/dashboard');?>" class="nav-link<?php echo menu_active('dashboard')?' active':'';?>">
              <i class="nav-icon fa fa-dashboard"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-header">MAIN NAVIGATION</li>
          <?php
          $menuFile=APPPATH.'views/'.akses().'/menu.php';
          $menu=array();
          if(is_file($menuFile))
          {
            require_once($menuFile);
          }
          if(!empty($menu))
          {
            $currentPath=trim((string)parse_url(current_url(), PHP_URL_PATH), '/');
            foreach($menu as $m1=>$r1)
            {
              $active=menu_active($r1['slug']);
              $childActive=false;
              if(!empty($r1['child']))
              {
                foreach($r1['child'] as $r2)
                {
                  $childPath=trim((string)parse_url($r2['url'], PHP_URL_PATH), '/');
                  if($childPath!=='' && ($currentPath===$childPath || strpos($currentPath, $childPath.'/')===0))
                  {
                    $childActive=true;
                    break;
                  }
                }
              }
              $isActive=($active || $childActive);
              if(empty($r1['child']))
              {
                echo '<li class="nav-item">';
                echo '<a href="'.$r1['url'].'" class="nav-link'.($isActive?' active':'').'" target="'.(isset($r1['target'])?$r1['target']:'').'">';
                echo '<i class="nav-icon '.$r1['icon'].'"></i><p>'.$m1.'</p>';
                echo '</a></li>';
              }
              else
              {
                echo '<li class="nav-item has-treeview'.($isActive?' menu-open':'').'">';
                echo '<a href="#" class="nav-link'.($isActive?' active':'').'">';
                echo '<i class="nav-icon '.$r1['icon'].'"></i><p>'.$m1.'<i class="nav-arrow fa fa-angle-left"></i></p>';
                echo '</a>';
                echo '<ul class="nav nav-treeview">';
                foreach($r1['child'] as $m2=>$r2)
                {
                  $childPath=trim((string)parse_url($r2['url'], PHP_URL_PATH), '/');
                  $childLinkActive=($childPath!=='' && ($currentPath===$childPath || strpos($currentPath, $childPath.'/')===0));
                  echo '<li class="nav-item">';
                  echo '<a href="'.$r2['url'].'" class="nav-link'.($childLinkActive?' active':'').'" target="'.(isset($r2['target'])?$r2['target']:'').'">';
                  echo '<i class="nav-icon '.$r2['icon'].'"></i><p>'.$m2.'</p>';
                  echo '</a></li>';
                }
                echo '</ul></li>';
              }
            }
          }
          ?>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- ============ Content ============ -->
  <main class="app-main">
    <div class="app-content-header">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-sm-8">
            <h3 class="mb-0"><?=$judul;?></h3>
          </div>
        </div>
      </div>
    </div>
    <div class="app-content">
      <div class="container-fluid">
        <div class="card card-outline card-primary shadow-sm">
          <div class="card-body">
        <?php
        $msgHeader=$this->session->flashdata('message_header');
        if(!empty($msgHeader))
        {
          $msgTipe=$msgHeader['tipe'];
        ?>
        <div class="alert alert-<?=$msgTipe;?> alert-dismissible" id="message_header" role="alert">
            <h4 class="alert-heading"><?=$msgHeader['title'];?></h4>
            <?=$msgHeader['message'];?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php
        }
        ?>
