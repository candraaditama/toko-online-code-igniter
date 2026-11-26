<?php
$menu=array(	
	'Produk'=>array(		
		'icon'=>'fa fa-cube',
		'slug'=>'produk',
		'child'=>array(				
				'Kategori'=>array(
					'icon'=>'fa fa-circle-o',
					'url'=>base_url(akses())."/produk/kategori",
					'target'=>"",
					),
				'Merek'=>array(
					'icon'=>'fa fa-circle-o',
					'url'=>base_url(akses())."/produk/merek",
					'target'=>"",
					),				
				'Produk'=>array(
					'icon'=>'fa fa-circle-o',
					'url'=>base_url(akses())."/produk/produk",
					'target'=>"",
					),
				'Promo'=>array(
					'icon'=>'fa fa-circle-o',
					'url'=>base_url(akses())."/produk/promo",
					'target'=>"",
					),
			),
	),
	'Transaksi'=>array(		
		'icon'=>'fa fa-shopping-cart',
		'slug'=>'transaksi',
		'child'=>array(				
				'Order'=>array(
					'icon'=>'fa fa-circle-o',
					'url'=>base_url(akses())."/transaksi/orderan",
					'target'=>"",
					),				
				'Mutasi Stok'=>array(
					'icon'=>'fa fa-circle-o',
					'url'=>base_url(akses())."/transaksi/mutasi",
					'target'=>"",
					),
				'Permintaan Produk'=>array(
					'icon'=>'fa fa-circle-o',
					'url'=>base_url(akses())."/transaksi/permintaan",
					'target'=>"",
					),
			),
	),
	'Mitra'=>array(		
		'icon'=>'fa fa-user',
		'slug'=>'mitra',
		'child'=>array(
				'Supplier'=>array(
					'icon'=>'fa fa-circle-o',
					'url'=>base_url(akses())."/mitra/supplier",
					'target'=>"",
					),		
				'Pelanggan'=>array(
					'icon'=>'fa fa-circle-o',
					'url'=>base_url(akses())."/mitra/pelanggan",
					'target'=>"",
					),
				'Outlet'=>array(
					'icon'=>'fa fa-circle-o',
					'url'=>base_url(akses())."/mitra/outlet",
					'target'=>"",
					),				
			),
	),
	'Konten Web'=>array(		
		'icon'=>'fa fa-globe',
		'slug'=>'cms',
		'child'=>array(				
				'Semua Halaman'=>array(
					'icon'=>'fa fa-circle-o',
					'url'=>base_url(akses())."/cms/halaman",
					'target'=>"",
					),
				'Tambah Halaman'=>array(
					'icon'=>'fa fa-circle-o',
					'url'=>base_url(akses())."/cms/halaman/add",
					'target'=>"",
					),
			),
	),	
);