<?php
echo asset_datatables();
?>
<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default">
		  <div class="panel-heading">Tambah Merek</div>
		  <div class="panel-body">
		    <?php echo form_open(base_url(akses().'/produk/merek/add'));?>
		    <div class="form-group required">
		    	<label class="ctl">Nama Merek</label>
		    	<input type="text" name="nama" class="form-control" required="" placeholder="Nama Merek" value="<?=set_value('nama');?>"/>
		    </div>		    
		    <div class="form-group">
		    	<button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-plus"></i>  Tambah</button>
		    </div>
		    <?php echo form_close();?>
		  </div>
		</div>
	</div>
	<div class="col-md-8">
	<table class="table table-bordered data-render">
		<thead>
			<th>Nama Merek</th>
			<th></th>
		</thead>
		<tbody>
			<?php
			if(!empty($data))
			{
				foreach($data as $row)
				{
					$id=$row->merek_id;
				?>
				<tr>
					<td><?=$row->nama_merek;?></td>
					<td>
						<a href="<?=base_url(akses().'/produk/merek/edit').'?id='.$id;?>" class="btn btn-md btn-info"><i class="fa fa-pencil"></i>  Ubah</a>
						<a onclick="return confirm('Yakin ingin menghapus Merek ini?');" href="<?=base_url(akses().'/produk/merek/delete').'?id='.$id;?>" class="btn btn-md btn-danger"><i class="fa fa-trash"></i>  Hapus</a>
					</td>
				</tr>
				<?php
				}
			}
			?>
		</tbody>
	</table>
	</div>
</div>