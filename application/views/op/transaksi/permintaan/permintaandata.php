<?php
if(!empty($data))
{
	foreach($data as $row)
	{
		$id=$row->pembelian_temp_id;
		$photoBaru=produk_photo($row->produk_id,1);
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
		<td><?=field_value('produk','produk_id',$row->produk_id,'nama_produk');?></td>
		<td><?=$row->jumlah;?></td>
		<td>
			<a href="javascript:;" class="btn btn-xs btn-danger" onclick="hapus(<?=$id;?>);"><i class="fa fa-trash"></i></a>
		</td>
	</tr>
	<?php
	}
}else{
	echo '';
}
?>