<?php
$promo_id='';
$promo_nilai=0;
$tgl_ini=date("Y-m-d");
$dPromo=$this->m_db->get_data('promo',array('selesai >'=>$tgl_ini),'promo_id DESC');
if(!empty($dPromo))
{
	foreach($dPromo as $rPromo){
	}
	$promo_id=$rPromo->promo_id;
	$promo_nilai=$rPromo->nilai;
	$urlBanner=base_url().'assets/no_picture.jpg';
	$banner=base_url().'assets/images/'.$rPromo->banner_gambar;
	if(@getimagesize($banner))
	{
		$urlBanner=$banner;
	}
?>
<div class="col-12 mb-2">
	<div class="shop-banner">
		<img src="<?=$urlBanner;?>" class="img-responsive" alt="Promo">
	</div>
</div>
<?php
}
?>
<?php
$sql="SELECT produk.* FROM promo_data LEFT JOIN produk ON promo_data.produk_id = produk.produk_id Where promo_data.promo_id='$promo_id' ORDER BY produk_id DESC LIMIT 6";
$dTerbaru=$this->m_db->get_query_data($sql);
if(empty($dTerbaru))
{
	$dTerbaru=produk_terbaru(6);
}
if(!empty($dTerbaru))
{
?>
<div class="row g-4 product-grid">
<?php
		foreach($dTerbaru as $rBaru)
		{
			$urlPhotoBaru=base_url().'assets/no_picture.jpg';
			$photoBaru=produk_photo($rBaru->produk_id,1);
			if(!empty($photoBaru))
			{
			foreach($photoBaru as $rPhotoBaru)
			{
			}
			$urlPhotoBaru=base_url().'assets/images/produk/thumbs/400/'.$rPhotoBaru->photo;
			$pathPhotoBaru=FCPATH.'assets/images/produk/thumbs/400/'.$rPhotoBaru->photo;
			if(!file_exists($pathPhotoBaru))
			{
				$urlPhotoBaru=base_url().'assets/no_picture.jpg';
			}
			}
			$slugBaru=string_create_slug($rBaru->nama_produk);
			$urlProdukBaru=base_url().'produk/'.$rBaru->produk_id.'/'.$slugBaru;
			$hargaPromo=$rBaru->harga-$promo_nilai;
		?>
		<div class="col-6 col-lg-4 hero-feature">
			<div class="thumbnail">
				<a href="<?=$urlProdukBaru;?>" class="link-p">
					<img src="<?=$urlPhotoBaru;?>" alt="<?=$rBaru->nama_produk;?>">
				</a>
				<div class="caption prod-caption">
					<h4><a href="<?=$urlProdukBaru;?>"><?=$rBaru->nama_produk;?></a></h4>
					<?php if($promo_nilai > 0){ ?>
					<div class="prod-old-price"><del>Rp <?=number_format($rBaru->harga,0,',','.');?></del></div>
					<?php } ?>
					<div class="prod-price-row">
						<span class="prod-price">Rp <?=number_format($hargaPromo,0,',','.');?></span>
						<a href="<?=base_url();?>produk/add/<?=$rBaru->produk_id;?>" class="btn btn-primary">
							<i class="fa fa-shopping-cart"></i> Beli
						</a>
					</div>
				</div>
			</div>
		</div>
		<?php
		}
?>
</div>
<?php
}
?>
