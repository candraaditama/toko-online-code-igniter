<?php
if(!empty($dCariTerbaru))
{
		foreach($dCariTerbaru as $rCari)
		{
			$photoCari=produk_photo($rCari->produk_id,1);
			foreach($photoCari as $rPhotoCari)
			{								
			}
			$urlPhotoCari=base_url().'assets/images/produk/thumbs/400/'.$rPhotoCari->photo;
			$pathPhotoCari=FCPATH.'assets/images/produk/thumbs/400/'.$rPhotoCari->photo;
			if(!file_exists($pathPhotoCari) && !file_exists($pathPhotoCari))
			{
				$urlPhotoCari=base_url().'assets/images/avatar/noavatar.jpg';
			}
			$slugCari=string_create_slug($rCari->nama_produk);
			$urlProdukCari=base_url().'produk/'.$rCari->produk_id.'/'.$slugCari;
		?>
		<div class="col-lg-4 col-sm-4 hero-feature text-center">
        <div class="thumbnail">
        	<a href="<?=$urlProdukCari;?>" class="link-p">
            	<img src="<?=$urlPhotoCari;?>" alt="">
        	</a>
            <div class="caption prod-caption">
                <h4><a href="<?=$urlProdukCari;?>"><?=$rCari->nama_produk;?></a></h4>
                <p>
                	<div class="btn-group">
                    	<a href="javascript:;" class="btn btn-default">Rp <?=number_format($rCari->harga,0);?></a>
                    	<a href="<?=base_url();?>produk/add/<?=$rCari->produk_id;?>" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Beli</a>
                	</div>
                </p>
            </div>
        </div>
    	</div>
		<?php
		}
}else{
	?>
	Tidak menemukan produk dengan keyword <b><?=$keyword;?></b>
	<?php
}
?>