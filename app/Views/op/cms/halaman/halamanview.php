<?php
echo asset_datatables();
?>
<div>
	<a href="<?=base_url(akses().'/cms/halaman/add');?>" class="btn btn-flat btn-primary">Tambah Halaman</a>
</div>
<p>&nbsp;</p>
<table class="table table-bordered table-hover table-stripped data-render">
	<thead>
		<th>Tanggal</th>
		<th>Judul</th>
		<th>Status</th>
		<th>Pembuat</th>
		<th></th>
	</thead>
	<tbody>
		<?php
		if(!empty($data))
		{
			foreach($data as $row)
			{
				$id=$row->berita_id;
				$tgl=date("d-m-Y",strtotime($row->tanggal));
				$status=ucfirst($row->status);
				$isi=string_word_limit($row->isi,30,'..');
				$user=field_value('userlogin','user_id',$row->user_id,'nama');
			?>
			<tr>
				<td><?=$tgl;?></td>
				<td><?=$row->judul;?></td>
				<td><?=$status;?></td>
				<td><?=$user;?></td>
				<td>
					<a href="<?=base_url(akses().'/cms/halaman/edit?id='.$id);?>" class="btn btn-flat btn-xs btn-info"><i class="fa fa-pencil"></i> Edit</a>
					<a onclick="return confirm('Yakin ingin menghapus halaman ini?');" href="<?=base_url(akses().'/cms/halaman/delete?id='.$id);?>" class="btn btn-flat btn-xs btn-danger"><i class="fa fa-trash"></i> Delete</a>
				</td>
			</tr>
			<?php
			}
		}
		?>
	</tbody>
</table>