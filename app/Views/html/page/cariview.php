<?php
if(!empty($dCariTerbaru))
{
?>
<div class="row g-4 product-grid">
<?php
		foreach($dCariTerbaru as $rCari)
		{
			$photoCari=produk_photo($rCari->produk_id,1);
			foreach($photoCari as $rPhotoCari)
			{
			}
			$urlPhotoCari=base_url().'assets/images/produk/thumbs/400/'.$rPhotoCari->photo;
			$pathPhotoCari=FCPATH.'assets/images/produk/thumbs/400/'.$rPhotoCari->photo;
			if(!file_exists($pathPhotoCari))
			{
				$urlPhotoCari=base_url().'assets/images/avatar/noavatar.jpg';
			}
			$slugCari=string_create_slug($rCari->nama_produk);
			$urlProdukCari=base_url().'produk/'.$rCari->produk_id.'/'.$slugCari;
		?>
		<div class="col-6 col-lg-4 hero-feature">
			<div class="thumbnail">
				<a href="<?=$urlProdukCari;?>" class="link-p">
					<img src="<?=$urlPhotoCari;?>" alt="<?=$rCari->nama_produk;?>">
				</a>
				<div class="caption prod-caption">
					<h4><a href="<?=$urlProdukCari;?>"><?=$rCari->nama_produk;?></a></h4>
					<div class="prod-price-row">
						<span class="prod-price">Rp <?=number_format($rCari->harga,0,',','.');?></span>
						<a href="<?=base_url();?>produk/add/<?=$rCari->produk_id;?>" class="btn btn-primary">
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
}else{
?>
<div class="alert alert-warning">Tidak menemukan produk dengan keyword <b><?=$keyword;?></b></div>
<?php
}
?>
