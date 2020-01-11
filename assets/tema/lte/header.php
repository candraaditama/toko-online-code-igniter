
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?=$judul;?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="shortcut icon" href="<?php echo tema_logo();?>" type="image/x-icon" />    <!-- Favicon -->
  <link rel="apple-touch-icon-precomposed" href="<?php echo tema_logo();?>">	<!-- For iPhone -->
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo tema_logo();?>">    <!-- For iPhone 4 Retina display -->
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo tema_logo();?>">    <!-- For iPad -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo tema_logo();?>">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="<?=base_url();?>assets/tema/lte/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url();?>assets/tema/lte/plugins/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?=base_url();?>assets/tema/lte/plugins/ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url();?>assets/tema/lte/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?=base_url();?>assets/tema/lte/dist/css/skins/_all-skins.min.css">
  <!-- jQuery 2.1.4 -->
  <script src="<?=base_url();?>assets/tema/lte/plugins/jQuery/jQuery-2.1.4.min.js"></script>
  <?php
  echo add_css(base_url().'assets/style.css');
  echo add_js(base_url().'assets/custom.js');
  ?>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?=base_url(akses().'/dashboard');?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b><?=baca_konfig('nama-aplikasi');?></b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b><?=baca_konfig('nama-aplikasi');?></b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?=user_photo();?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?=user_info('nama');?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?=user_photo();?>" class="img-circle" alt="User Image">

                <p>
                  <?=user_info('nama');?> - <?=user_info('akses');?>                  
                </p>
              </li>              
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?=base_url();?>profil" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?=base_url();?>logout" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?=user_photo();?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?=user_info('nama');?></p>          
        </div>
      </div>      
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li class="treeview">
          <a href="<?=base_url(akses().'/dashboard');?>"><i class="fa fa-dashboard"></i> Dashboard</a>
        </li>
        <?php
        require_once(APPPATH.'views/'.akses().'/menu.php');
        $output='';
			foreach($menu as $m1=>$r1)
			{	
				$a=menu_active($r1['slug']);
				$s1="";
				$s2="";
				if($a==TRUE)
				{
					$s1="active";
					$s2="treeview";
				}
				if(empty($r1['child']))
				{
					$output.='<li class="treeview '.$s1.'">
					<a href="'.$r1['url'].'">							
						<i class="'.$r1['icon'].'"></i> <span>'.$m1.'</span>
					</a></li>';
				}else{
					$output.='<li class="treeview '.$s1.'">';
					$output.='<a href="#" data-toggle="dropdown">
						<i class="'.$r1['icon'].'"></i> <span>'.$m1.'</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>';
					$output.='<ul class="treeview-menu">';
					foreach($r1['child'] as $m2=>$r2)
					{
						$output.='<li><a href="'.$r2['url'].'">'.$m2.'</a></li>';
					}
					$output.='</ul>';
					$output.='</li>';
				}	
			}
			echo $output;
        ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$judul;?>
      </h1>      
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header">          
        </div>
        <div class="box-body">
        <?php
		$msgHeader=$this->session->flashdata('message_header');
		if(!empty($msgHeader))
		{
		$msgTipe=$msgHeader['tipe'];
		$msgIcon="";
		switch($msgTipe){
				case "danger":
					$msgIcon="fa-ban";
					break;						
				case "success":
					$msgIcon="fa-check";
					break;
				case "warning":
					$msgIcon="fa-warning";
					break;
				case "info":
					$msgIcon="fa-info";
					break;
			}
		?>
		<div class="alert alert-<?=$msgTipe;?> alert-dismissable" id="message_header">
		    <button type="button" class="close" data-dismiss="alert">&times;</button>
		    <h4><?=$msgHeader['title'];?></h4>
		    <?=$msgHeader['message'];?>
		</div>				                
		<?php	
		}
		?>
        
