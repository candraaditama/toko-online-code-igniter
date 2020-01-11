<?php
if(!empty($data))
{
	foreach($data as $row){		
	}
	?>
	<h3>Stok List : <?=$row->nama_produk;?></h3>
	<a href="javascript:history.back(-1);" class="btn btn-default btn-flat">Kembali</a><p>&nbsp;</p>
	<?php
	$dstok=$this->m_db->get_data('produk_stok',array('produk_id'=>$row->produk_id));
	$no=0;
	if(!empty($dstok))
	{
		foreach($dstok as $rstok)
		{
			$no+=1;
			$namaToko=field_value('toko','toko_id',$rstok->toko_id,'nama_toko');
			$qty=$rstok->stok;
		?>
		<h3><?=$no;?>) <?=$namaToko;?> <b><?=$qty;?> item</b></h3>
		<?php
		}
	}
}
?>