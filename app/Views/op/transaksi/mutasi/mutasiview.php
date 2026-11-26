<?php

echo asset_datatables();
?>
<div>
	<a href="<?=base_url(akses().'/transaksi/mutasi/add');?>" class="btn btn-primary btn-flat">Tambah Mutasi Stok</a>
</div>
<p>&nbsp;</p>
<table class="table table-bordered data-render">
	<thead>
		<th>Tanggal</th>
		<th>Toko</th>
		<th>Dientri</th>
		<th>Keterangan</th>
		<td></td>
	</thead>
	<tbody>
		<?php
		if(!empty($data))
		{
			foreach($data as $row)
			{
				$id=$row->mutasi_id;
				$tgl=date("d-m-Y",strtotime($row->tanggal));
				$namaToko=toko_info($row->toko_id,'nama_toko');
				$user=field_value('userlogin','user_id',$row->user_id,'nama');
			?>
			<tr>
				<td><?=$tgl;?></td>
				<td><?=$namaToko;?></td>
				<td><?=$user;?></td>
				<td><?=$row->keterangan;?></td>
				<td>
					<a href="<?=base_url(akses().'/transaksi/mutasi/detail').'?id='.$id;?>" class="btn btn-default btn-xs btn-flat"><i class="fa fa-info"></i> Detail</a>
				</td>
			</tr>
			<?php
			}
		}
		?>
	</tbody>
</table>