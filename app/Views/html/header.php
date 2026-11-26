<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <title><?=$judul;?></title>
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
    <link href="<?=base_url();?>assets/html/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/html/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/html/css/font-awesome-v4-shims.min.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/html/css/jquery.bxslider.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/html/css/legacy-bs3.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/html/css/style.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/style.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/html/css/theme.css" rel="stylesheet">
    <script src="<?=base_url();?>assets/html/js/jquery.js"></script>
    <script src="<?=base_url();?>assets/custom.js"></script>
    <?php
    echo add_css(base_url().'assets/plugin/prettyphoto/css/prettyPhoto.css');
    echo add_js(base_url().'assets/plugin/prettyphoto/js/jquery.prettyPhoto.js');
    ?>
    <script type="text/javascript" charset="utf-8">
	$(document).ready(function(){
	    $("a[rel^='prettyPhoto']").prettyPhoto({
	    	default_width: 500,
			default_height: 344,
			sosial_tools:"",
	    });
	});
	</script>
</head>
<body class="site">
	<a class="visually-hidden-focusable" href="#konten-utama">Lewati ke konten</a>

	<header class="site-header hidden-print">
	    <div class="container">

	        <a class="site-brand" href="<?=base_url();?>">
	            <img src="<?=base_url();?>assets/images/food-stand.png" alt="<?=baca_konfig('company-name');?>">
	            <span class="site-brand-text">
	                <strong><?=baca_konfig('company-name');?></strong>
	                <small>Toko online terpercaya</small>
	            </span>
	        </a>

	        <form class="site-search" action="<?=base_url();?>produk/cari" method="get" role="search">
	            <div class="input-group">
	                <input type="text" name="cari" class="form-control" placeholder="Cari produk apapun" aria-label="Cari produk">
	                <button class="btn" type="submit" aria-label="Cari"><i class="fa fa-search"></i></button>
	            </div>
	        </form>

	        <div class="site-actions">
	            <button type="button" class="site-action icon-only js-theme-toggle" aria-label="Ganti tema" title="Mode gelap">
	                <i class="fa fa-moon"></i>
	            </button>

	            <a class="site-action" href="<?=base_url();?>keranjang">
	                <i class="fa fa-shopping-cart"></i>
	                <span class="label-text">Keranjang</span>
	            </a>

	            <?php
	            if(akses()=="member")
	            {
				?>
				<div class="dropdown">
					<a class="site-action dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						<i class="fa fa-user"></i>
						<span class="label-text">Akun Saya</span>
					</a>
					<ul class="dropdown-menu dropdown-menu-end">
						<li><a class="dropdown-item" href="<?=base_url();?>akun">Profil</a></li>
						<li><a class="dropdown-item" href="<?=base_url();?>akun/histori">Histori Belanja</a></li>
						<li><hr class="dropdown-divider"></li>
						<li><a class="dropdown-item" href="<?=base_url();?>logout">Keluar</a></li>
					</ul>
				</div>
				<?php
				}else{
					$ref=$this->uri->ruri_string();
				?>
				<a class="site-action btn-ghost" href="<?=base_url();?>member/login?ref=<?=$ref;?>">Masuk</a>
				<a class="site-action" href="<?=base_url();?>member/daftar?ref=<?=$ref;?>">Daftar</a>
				<?php
				}
	            ?>
	        </div>

	    </div>
	</header>

	<nav class="site-nav navbar navbar-expand-lg hidden-print" aria-label="Navigasi utama">
	    <div class="container">
	        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navUtama" aria-controls="navUtama" aria-expanded="false" aria-label="Buka navigasi">
	            <i class="fa fa-bars"></i>
	        </button>

	        <div class="collapse navbar-collapse" id="navUtama">
	            <ul class="navbar-nav">
	                <li class="nav-item"><a class="nav-link" href="<?=base_url();?>">Home</a></li>
	                <li class="nav-item"><a class="nav-link <?=menu_html('katalog');?>" href="<?=base_url();?>katalog">Katalog</a></li>
	                <li class="nav-item"><a class="nav-link <?=menu_html('keranjang');?>" href="<?=base_url();?>keranjang">Keranjang</a></li>
	                <li class="nav-item"><a class="nav-link <?=menu_html('konfirmasi');?>" href="<?=base_url();?>konfirmasi">Konfirmasi Pembayaran</a></li>
	                <li class="nav-item"><a class="nav-link <?=menu_html('tracking');?>" href="<?=base_url();?>tracking">Tracking Order</a></li>
	                <li class="nav-item dropdown">
	                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
	                        Informasi
	                    </a>
	                    <ul class="dropdown-menu">
	                        <?php
	                        $dHalaman=$this->m_db->get_data('berita',array('jenis'=>'halaman'));
	                        if(!empty($dHalaman))
	                        {
	                        	foreach($dHalaman as $rHalaman)
	                        	{
	                        		$urlpage=base_url().'informasi/'.$rHalaman->slug;
	                        	?>
	                        	<li><a class="dropdown-item" href="<?=$urlpage;?>"><?=$rHalaman->judul;?></a></li>
	                        	<?php
	                        	}
	                        }
	                        ?>
	                    </ul>
	                </li>
	            </ul>
	        </div>
	    </div>
	</nav>

	<main id="konten-utama" class="site-main container">

	    <div class="row g-4">
	    	<?php
	    	$this->load->view('html/sidebar');
	    	?>

			<div class="col-lg-9 order-1 order-lg-2 content-col">
				<div class="page-heading hidden-print">
					<div>
						<h1 class="page-title"><?=$judulhalaman;?></h1>
					</div>
				</div>
