<?php
echo asset_datatables();
?>
<table class="table table-border data-render">
	<thead>
		<th>Nama Pelanggan</th>
		<th>Kontak Info</th>
		<th>Kota</th>
		<th>Username</th>
		<th></th>
	</thead>
	<tbody>
		<?php
		if(!empty($data))
		{
			foreach($data as $row)
			{
			?>
			<tr>
				<td><?=$row->nama_pelanggan;?></td>
				<td>
					<b>Email : </b> <?=$row->email;?><br/>					
					<b>HP : </b> <?=$row->hp;?><br/>					
				</td>
				<td><?=field_value('lokasi_kota','kota_id',$row->kota,'nama_kota');?></td>
				<td><?=field_value('userlogin','user_id',$row->user_id,'username');?></td>
				<td>
					<!-- <a href="<?=base_url(akses().'/mitra/pelanggan/detail').'?id='.$row->pelanggan_id;?>" class="btn btn-info btn-md"><i class="fa fa-info"></i></a> -->
					<a href="<?=base_url(akses().'/mitra/pelanggan/delete').'?id='.$row->pelanggan_id;?>" class="btn btn-danger btn-md" onclick="return confirm('Yakin ingin menghapus pelanggan <?=$row->nama_pelanggan;?>');"><i class="fa fa-trash"></i></a>
				</td>
			</tr>
			<?php
			}
		}
		?>
	</tbody>
</table>