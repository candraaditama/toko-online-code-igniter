<?php

echo asset_datatables();
?>
<div>
	<a href="<?=base_url(akses().'/transaksi/permintaan/add');?>" class="btn btn-primary btn-flat">Tambah Permintaan Produk</a>
</div>
<p>&nbsp;</p>
<table class="table table-bordered data-render">
	<thead>
		<th>Tanggal</th>
		<th>supplier</th>
		<th>Dientri</th>
		<th>Status</th>
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
				<td><?=$supplier;?></td>
				<td><?=$user;?></td>
				<td><?=ucfirst($row->status);?></td>
				<td>
					<a href="<?=base_url(akses().'/transaksi/permintaan/detail').'?id='.$id;?>" class="btn btn-default btn-md btn-flat"><i class="fa fa-info"></i> Detail</a>
				</td>
			</tr>
			<?php
			}
		}
		?>
	</tbody>
</table>