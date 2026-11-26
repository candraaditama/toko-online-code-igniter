<?php
echo asset_datatables();
?>
<div class="col-md-4">
	<div class="panel panel-default">
		<div class="panel-heading">Tambah Kategori</div>
		<div class="panel-body">
		<?php
		echo validation_errors();
		echo form_open(base_url(akses()).'/cms/kategori/add',array('class'=>'form-horizontal'));
		?>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="">Nama Kategori</label>
			<div class="col-md-10">
				<input type="text" name="nama" id="" class="form-control " autocomplete="" placeholder="" required="" value="<?php echo set_value('nama'); ?>"/>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">&nbsp;</label>
			<div class="col-md-10">
				<button type="submit" class="btn btn-primary btn-flat">Tambah</button>			
			</div>
		</div>
		<?php
		echo form_close();
		?>
		</div>
	</div>	
</div>
<div class="col-md-8">
	<table class="table table-bordered table-hover table-stripped data-render">
		<thead>
			<th>Nama Kategori</th>
			<th></th>
		</thead>
		<tbody>
			<?php
			if(!empty($data))
			{
				foreach($data as $row)
				{
					$id=$row->berita_kategori_id;
				?>
				<tr>
					<td><?=$row->nama_kategori;?></td>
					<td>
						<a href="<?=base_url(akses().'/cms/kategori/edit?id='.$id);?>" class="btn btn-flat btn-xs btn-info"><i class="fa fa-pencil"></i> Edit</a>
					<a onclick="return confirm('Yakin ingin menghapus kategori <?=$row->nama_kategori;?> ?');" href="<?=base_url(akses().'/cms/kategori/delete?id='.$id);?>" class="btn btn-flat btn-xs btn-danger"><i class="fa fa-trash"></i> Delete</a>
					</td>
				</tr>
				<?php
				}
			}
			?>
		</tbody>
	</table>
</div>