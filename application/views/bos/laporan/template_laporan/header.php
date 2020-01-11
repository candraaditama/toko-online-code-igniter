<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$judul;?></title>
    <?=asset_bootstrap_css();?>
  </head>
  <body>
    
	<div class="container">
		<div class="header-laporan" style="border-bottom:3px solid #000;">
			<div class="row">
				<div class="col-md-4">
					<img src="<?=base_url();?>assets/kop.png" class="img-responsive" style="width: 100px;"/> <br />
				</div>
				<div class="col-md-8">
					<h4>TOKO Online </h4>
					Jalan Rasuna Said No. 46 C, Jakarta<br/>
					Telp. 021-224453, Email : toko-online@gmail.com
				</div>
			</div>
		</div>
		<div class="deskripsi-laporan text-center">
			<h4><?=$judul;?></h4>
			<h5><?=$deskripsi;?></h5>
		</div>
		<div class="konten-laporan">
					