<?php

echo asset_datatables();
?>

<p>&nbsp;</p>
<table class="table table-bordered data-render">
	<thead>
		<th>Tanggal</th>
		<th>Dientri</th>
		<td></td>
	</thead>
	<tbody>
		<?php
		if(!empty($data))
		{
			foreach($data as $row)
			{
				$id=$row->pembelian_id;
				$tgl=date("d-m-Y",strtotime($row->tanggal));
				$supplier=field_value('supplier','supplier_id',$row->supplier_id,'nama_supplier');
				$user=field_value('userlogin','user_id',$row->user_id,'nama');
			?>
			<tr>
				<td><?=$tgl;?></td>
				<td><?=$user;?></td>
				<td>
					<a href="<?=base_url(akses().'/produk/permintaan/proses').'?id='.$id;?>" class="btn btn-primary btn-xs btn-flat"><i class="fa fa-check"></i> Proses</a>
					<a href="<?=base_url(akses().'/produk/permintaan/detail').'?id='.$id;?>" class="btn btn-default btn-xs btn-flat"><i class="fa fa-info"></i> Detail</a>
				</td>
			</tr>
			<?php
			}
		}
		?>
	</tbody>
</table>