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
	'Laporan'=>array(		
		'icon'=>'fa fa-file-o',
		'slug'=>'laporan',
		'child'=>array(				
				'Penjualan'=>array(
					'icon'=>'fa fa-circle-o',
					'url'=>base_url(akses())."/laporan/penjualan",
					'target'=>"",
					),
				'Permintaan'=>array(
					'icon'=>'fa fa-circle-o',
					'url'=>base_url(akses())."/laporan/permintaan",
					'target'=>"",
					),				
			),
	),
);