<h1>Selamat Datang, <?=user_info('nama');?></h1>
<p>&nbsp;</p>
<div class="row">	
	 <div class="col-lg-3 col-xs-6"> <!-- small box -->             
         <div class="small-box bg-aqua">
            <div class="inner">
                <h3>
					Produk
                 </h3>
                 <p>
					Manajemen Produk
				 </p>
            </div>
            <div class="icon">
                <span class="fa fa-cubes"></span>
            </div>
            <a href="<?=base_url(akses().'/produk/produk');?>" class="small-box-footer">
                Lihat Daftar Produk <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
        </div>
    </div><!-- ./col -->
	
		 <div class="col-lg-3 col-xs-6"> <!-- small box -->             
         <div class="small-box bg-green">
            <div class="inner">
                <h3>
					Transaksi
                 </h3>
                 <p>
					Manajemen halaman berita
				 </p>
            </div>
            <div class="icon">
                <span class="fa fa-shopping-cart"></span>
            </div>
            <a href="<?=base_url(akses().'/cms/berita');?>" class="small-box-footer">
                Lihat Detail Transaksi <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
        </div>
    </div><!-- ./col -->
	
	<div class="col-lg-3 col-xs-6"> <!-- small box -->             
         <div class="small-box bg-yellow">
            <div class="inner">
                <h3>
					Mitra
                 </h3>
                 <p>
					Manajemen Mitra Usaha
				 </p>
            </div>
            <div class="icon">
                <span class="fa fa-users"></span>
            </div>
            <a href="<?=base_url(akses().'/cms/halaman');?>" class="small-box-footer">
                Lihat Daftar Halaman <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
        </div>
    </div><!-- ./col -->
	
		<div class="col-lg-3 col-xs-6"> <!-- small box -->             
         <div class="small-box bg-red">
            <div class="inner">
                <h3>
					Konten
                 </h3>
                 <p>
					Manajemen Konten
				 </p>
            </div>
            <div class="icon">
                <span class="fa fa-globe"></span>
            </div>
            <a href="<?=base_url(akses().'/konfigurasi');?>" class="small-box-footer">
                Atur Konten<span class="glyphicon glyphicon-chevron-right"></span>
            </a>
        </div>
    </div><!-- ./col -->
	
	
</div>