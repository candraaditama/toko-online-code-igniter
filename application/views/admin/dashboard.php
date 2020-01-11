<h1>Selamat Datang, <?=user_info('nama');?></h1>
<p>&nbsp;</p>
<div class="row">	
	 <div class="col-lg-3 col-xs-6"> <!-- small box -->             
         <div class="small-box bg-aqua">
            <div class="inner">
                <h3>
					User Manager
                 </h3>
                 <p>
					Manajemen pengguna sistem
				 </p>
            </div>
            <div class="icon">
                <span class="fa fa-users"></span>
            </div>
            <a href="<?=base_url(akses().'/pengguna');?>" class="small-box-footer">
                Lihat Daftar Pengguna <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
        </div>
    </div><!-- ./col -->
	
		 <div class="col-lg-3 col-xs-6"> <!-- small box -->             
         <div class="small-box bg-green">
            <div class="inner">
                <h3>
					Berita
                 </h3>
                 <p>
					Manajemen halaman berita
				 </p>
            </div>
            <div class="icon">
                <span class="fa fa-newspaper-o"></span>
            </div>
            <a href="<?=base_url(akses().'/cms/berita');?>" class="small-box-footer">
                Lihat Daftar Berita <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
        </div>
    </div><!-- ./col -->
	
	<div class="col-lg-3 col-xs-6"> <!-- small box -->             
         <div class="small-box bg-yellow">
            <div class="inner">
                <h3>
					Halaman
                 </h3>
                 <p>
					Manajemen halaman website
				 </p>
            </div>
            <div class="icon">
                <span class="fa fa-file"></span>
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
					Info Sistem
                 </h3>
                 <p>
					Manajemen informasi sistem
				 </p>
            </div>
            <div class="icon">
                <span class="fa fa-gears"></span>
            </div>
            <a href="<?=base_url(akses().'/konfigurasi');?>" class="small-box-footer">
                Atur Informasi Sistem <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
        </div>
    </div><!-- ./col -->
	
	
</div>