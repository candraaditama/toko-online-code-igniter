<?php
$dTerbaru=produk_terbaru(12);
if(!empty($dTerbaru))
{
?>
<div class="row g-4 product-grid">
<?php
		foreach($dTerbaru as $rBaru)
		{
			$photoBaru=produk_photo($rBaru->produk_id,1);
			foreach($photoBaru as $rPhotoBaru)
			{
			}
			$urlPhotoBaru=base_url().'assets/images/produk/thumbs/400/'.$rPhotoBaru->photo;
			$pathPhotoBaru=FCPATH.'assets/images/produk/thumbs/400/'.$rPhotoBaru->photo;
			if(!file_exists($pathPhotoBaru))
			{
				$urlPhotoBaru=base_url().'assets/images/avatar/noavatar.jpg';
			}
			$slugBaru=string_create_slug($rBaru->nama_produk);
			$urlProdukBaru=base_url().'produk/'.$rBaru->produk_id.'/'.$slugBaru;
		?>
		<div class="col-6 col-lg-4 hero-feature">
			<div class="thumbnail">
				<a href="<?=$urlProdukBaru;?>" class="link-p">
					<img src="<?=$urlPhotoBaru;?>" alt="<?=$rBaru->nama_produk;?>">
				</a>
				<div class="caption prod-caption">
					<h4><a href="<?=$urlProdukBaru;?>"><?=$rBaru->nama_produk;?></a></h4>
					<div class="prod-price-row">
						<span class="prod-price">Rp <?=number_format($rBaru->harga,0,',','.');?></span>
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
