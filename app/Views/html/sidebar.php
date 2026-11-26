<aside class="col-lg-3 order-2 order-lg-1 shop-sidebar hidden-print">

	<!-- Kategori -->
	<div class="shop-card">
		<span class="title">Kategori</span>
		<div class="shop-category-list">
			<?php
			$dKat=produk_kategori();
			if(!empty($dKat))
			{
				foreach($dKat as $rKat)
				{
					$slugCat=string_create_slug($rKat->nama_kategori);
					$urlcat=base_url().'produk/kategori/'.$rKat->kategori_id.'/'.$slugCat;
				?>
				<a href="<?=$urlcat;?>"><?=$rKat->nama_kategori;?></a>
				<?php
				}
			}
			?>
		</div>
	</div>
	<!-- /Kategori -->

	<!-- Best Seller -->
	<div class="shop-card">
		<span class="title">Best Seller</span>
		<?php
		$dBest=produk_best_seller(3);
		if(!empty($dBest))
		{
			foreach($dBest as $rBest)
			{
				$photoBest=produk_photo($rBest->produk_id,1);
				$urlPhotoBest=base_url().'assets/images/avatar/noavatar.jpg';
				if(!empty($photoBest))
				{
					foreach($photoBest as $rPhotoBest)
					{
					}
					$urlPhotoBest=base_url().'assets/images/produk/thumbs/400/'.$rPhotoBest->photo;
					$pathPhotoBest=FCPATH.'assets/images/produk/thumbs/400/'.$rPhotoBest->photo;
					if(!file_exists($pathPhotoBest))
					{
						$urlPhotoBest=base_url().'assets/images/avatar/noavatar.jpg';
					}
				}
				$slugBest=string_create_slug($rBest->nama_produk);
				$urlProdukBest=base_url().'produk/'.$rBest->produk_id.'/'.$slugBest;
			?>
			<a class="mini-product" href="<?=$urlProdukBest;?>">
				<span class="mini-product-img"><img src="<?=$urlPhotoBest;?>" alt="<?=$rBest->nama_produk;?>"></span>
				<span class="mini-product-body">
					<span class="mini-product-name"><?=$rBest->nama_produk;?></span>
					<span class="mini-product-price">Rp <?=number_format($rBest->harga,0,',','.');?></span>
				</span>
			</a>
			<?php
			}
		}
		?>
	</div>
	<!-- /Best Seller -->

</aside>
