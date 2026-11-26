<?php
echo asset_datatables();
?>
<div>
	<a href="<?=base_url(akses().'/pengguna/add');?>" class="btn btn-primary btn-flat">Tambah Pengguna</a>
</div>
<p>&nbsp;</p>
<table class="table table-bordered table-hover table-stripped data-render">
	<thead>
		<th>Nama</th>
		<th>Username</th>
		<th>Akses</th>
		<th>Aksi</th>
	</thead>
	<tbody>
		<?php
		if(!empty($data))
		{
			foreach($data as $row)
			{
				$id=$row->user_id;
			?>
			<tr>
				<td><?=$row->nama;?></td>
				<td><?=$row->username;?></td>
				<td><?=$row->akses;?></td>
				<td>
					<a href="<?=base_url(akses().'/pengguna/edit?id='.$id);?>" class="btn btn-flat btn-md btn-info"><i class="fa fa-pencil"></i> Edit</a>
					<a onclick="return confirm('Yakin ingin menghapus user <?=$row->nama;?> ?');" href="<?=base_url(akses().'/pengguna/delete?id='.$id);?>" class="btn btn-flat btn-md btn-danger"><i class="fa fa-trash"></i> Delete</a>
				</td>
			</tr>
			<?php
			}
		}
		?>
	</tbody>
</table>