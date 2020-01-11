<?php
if(empty($data))
{
	redirect(base_url(akses().'/transaksi/permintaan'));
}
foreach($data as $row){	
}
?>
<a href="javascript:history.back(-1);" class="btn btn-default btn-flat">Kembali</a>
<div class="row">
	<div class="col-md-4">
		<b>Tanggal</b><br/>
		<?=date('d-m-Y',strtotime($row->tanggal));?>
	</div>
	<div class="col-md-8">
		<b>Supplier</b><br/>
		<?=field_value('supplier','supplier_id',$row->supplier_id,'nama_supplier');?>
	</div>
</div>
<table class="table table-bordered">
<thead>
	<th></th>
	<th>Nama Produk</th>
	<th>Jumlah</th>
</thead>
<tbody>
<?php
$dataMinta=$this->m_db->get_data('pembelian_detail',array('pembelian_id',$row->pembelian_id));
if(!empty($dataMinta))
{
	foreach($dataMinta as $rowMinta)
	{		
		$photoBaru=produk_photo($rowMinta->produk_id,1);
		foreach($photoBaru as $rPhotoBaru)
		{								
		}
		$urlPhotoBaru=base_url().'assets/images/produk/thumbs/400/'.$rPhotoBaru->photo;
		$pathPhotoBaru=FCPATH.'assets/images/produk/thumbs/400/'.$rPhotoBaru->photo;
		if(!file_exists($pathPhotoBaru) && !file_exists($pathPhotoBaru))
		{
			$urlPhotoBaru=base_url().'assets/images/avatar/noavatar.jpg';
		}			
	?>
	<tr>
		<td>
			<img src="<?=$urlPhotoBaru;?>" class="img-responsive" style="width: 120px;height:90px;"/>
		</td>
		<td><?=field_value('produk','produk_id',$rowMinta->produk_id,'nama_produk');?></td>
		<td><?=$rowMinta->qty;?></td>		
	</tr>
	<?php
	}
?>
</tbody>
</table>
<?php
}else{
	echo '';
}
?>