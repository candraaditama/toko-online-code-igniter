<?php
echo asset_datatables();
?>
<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default">
		  <div class="panel-heading">Tambah Warna</div>
		  <div class="panel-body">
		    <?php echo form_open(base_url(akses().'/produk/warna/add'));?>
		    <div class="form-group required">
		    	<label class="ctl">Nama Warna</label>
		    	<input type="text" name="nama" class="form-control" required="" placeholder="Nama Warna" value="<?=set_value('nama');?>"/>
		    </div>		    
		    <div class="form-group">
		    	<button type="submit" class="btn btn-primary btn-flat">Tambah</button>
		    </div>
		    <?php echo form_close();?>
		  </div>
		</div>
	</div>
	<div class="col-md-8">
	<table class="table table-bordered data-render">
		<thead>
			<th>Nama Warna</th>
			<th></th>
		</thead>
		<tbody>
			<?php
			if(!empty($data))
			{
				foreach($data as $row)
				{
					$id=$row->warna_id;
				?>
				<tr>
					<td><?=$row->nama_warna;?></td>
					<td>
						<a href="<?=base_url(akses().'/produk/warna/edit').'?id='.$id;?>" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i></a>
						<a onclick="return confirm('Yakin ingin menghapus Warna ini?');" href="<?=base_url(akses().'/produk/warna/delete').'?id='.$id;?>" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
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