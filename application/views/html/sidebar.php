<div class="col-lg-3 col-md-3 col-sm-12 hidden-print">



<!-- Categories -->
<div class="col-lg-12 col-md-12 col-sm-6">
	<div class="no-padding">
    		<span class="title">Kategori</span>
    	</div>

		<div id="main_menu">
            <div class="list-group panel panel-cat">
            	<?php
            	$dKat=produk_kategori();
            	if(!empty($dKat))
            	{
					foreach($dKat as $rKat)
					{
						$slugCat=string_create_slug($rKat->nama_kategori);
						$urlcat=base_url().'produk/kategori/'.$rKat->kategori_id.'/'.$slugCat;
					?>
					<a href="<?=$urlcat;?>" class="list-group-item" ><?=$rKat->nama_kategori;?></a>
					<?php
					}
				}
            	?>                            
            </div>
        </div>

	</div>
	<!-- End Categories -->

	<!-- Best Seller -->
	<div class="col-lg-12 col-md-12 col-sm-6">
		<div class="no-padding">
    		<span class="title">BEST SELLER</span>
    	</div>
    	<?php
    	$dBest=produk_best_seller(2);
    	if(!empty($dBest))
    	{
    		$iBest=0;
			foreach($dBest as $rBest)
			{
				$iBest+=1;
				$cBestFeat='';
				if($iBest==1)
				{
					$cBestFeat="hidden-sm";
				}							
				$photoBest=produk_photo($rBest->produk_id,1);
				if(empty($photoBest))
				{
					$urlPhotoBest=base_url().'assets/images/avatar/noavatar.jpg';
				}else{
					
				
					foreach($photoBest as $rPhotoBest)
					{								
					}
					$urlPhotoBest=base_url().'assets/images/produk/thumbs/400/'.$rPhotoBest->photo;
					$pathPhotoBest=FCPATH.'assets/images/produk/thumbs/400/'.$rPhotoBest->photo;					
					if(!file_exists($pathPhotoBest) && !file_exists($pathPhotoBest))
					{
						$urlPhotoBest=base_url().'assets/images/avatar/noavatar.jpg';
					}
				}
				$slugBest=string_create_slug($rBest->nama_produk);
				$urlProdukBest=base_url().'produk/'.$rBest->produk_id.'/'.$slugBest;
			?>
			<div class="hero-feature <?=$cBestFeat;?>">
                <div class="thumbnail text-center">
                	<a href="<?=$urlProdukBest;?>" class="link-p">
                    	<img src="<?=$urlPhotoBest;?>" alt="">
                	</a>
                    <div class="caption prod-caption">
                        <h4><a href="<?=$urlProdukBest;?>"><?=$rBest->nama_produk;?></a></h4>
                        <p>
                        	<div class="btn-group">
	                        	<a href="javascript:;" class="btn btn-default">Rp <?=number_format($rBest->harga,0);?></a>
	                        	<a href="<?=base_url();?>produk/add/<?=$rBest->produk_id;?>" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Beli</a>
                        	</div>
                        </p>
                    </div>
                </div>
            </div>
			<?php
			}
		}
    	?>
	</div>
	<!-- End Best Seller -->

</div>