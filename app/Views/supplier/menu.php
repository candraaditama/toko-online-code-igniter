<?php
$menu=array(	
	'Permintaan Produk'=>array(		
		'icon'=>'fa fa-shopping-cart',
		'slug'=>'produk',
		'child'=>array(				
				'Permintaan'=>array(
					'icon'=>'fa fa-circle-o',
					'url'=>base_url(akses())."/produk/permintaan",
					'target'=>"",
					),
				'Selesai'=>array(
					'icon'=>'fa fa-circle-o',
					'url'=>base_url(akses())."/produk/selesai",
					'target'=>"",
					),								
			),
	),
);