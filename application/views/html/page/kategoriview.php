<?php
$dKategoriTerbaru=produk_kategori_data($kategoriid,12);

if(!empty($dKategoriTerbaru))
{
		foreach($dKategoriTerbaru as $rKategori)
		{
			$photoKategori=produk_photo($rKategori->produk_id,1);
			foreach($photoKategori as $rPhotoKategori)
			{								
			}
			$urlPhotoKategori=base_url().'assets/images/produk/thumbs/400/'.$rPhotoKategori->photo;
			$pathPhotoKategori=FCPATH.'assets/images/produk/thumbs/400/'.$rPhotoKategori->photo;
			if(!file_exists($pathPhotoKategori) && !file_exists($pathPhotoKategori))
			{
				$urlPhotoKategori=base_url().'assets/images/avatar/noavatar.jpg';
			}
			$slugKategori=string_create_slug($rKategori->nama_produk);
			$urlProdukKategori=base_url().'produk/'.$rKategori->produk_id.'/'.$slugKategori;
		?>
		<div class="col-lg-4 col-sm-4 hero-feature text-center">
        <div class="thumbnail">
        	<a href="<?=$urlProdukKategori;?>" class="link-p">
            	<img src="<?=$urlPhotoKategori;?>" alt="">
        	</a>
            <div class="caption prod-caption">
                <h4><a href="<?=$urlProdukKategori;?>"><?=$rKategori->nama_produk;?></a></h4>
                <p>
                	<div class="btn-group">
                    	<a href="javascript:;" class="btn btn-default">Rp <?=number_format($rKategori->harga,0);?></a>
                    	<a href="<?=base_url();?>produk/add/<?=$rKategori->produk_id;?>" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Beli</a>
                	</div>
                </p>
            </div>
        </div>
    	</div>
		<?php
		}
}
?>