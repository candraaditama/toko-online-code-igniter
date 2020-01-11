<?php
echo asset_datatables();
?>
<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default">
		  <div class="panel-heading">Tambah Kategori</div>
		  <div class="panel-body">
		    <?php echo form_open(base_url(akses().'/produk/kategori/add'));?>
		    <div class="form-group required">
		    	<label class="ctl">Nama Kategori</label>
		    	<input type="text" name="nama" class="form-control" required="" placeholder="Nama Kategori" value="<?=set_value('nama');?>"/>
		    </div>		    
		    <div class="form-group">
		    	<button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-plus"></i> Tambah</button>
		    </div>
		    <?php echo form_close();?>
		  </div>
		</div>
	</div>
	<div class="col-md-8">
	<table class="table table-bordered data-render">
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
					$id=$row->kategori_id;
				?>
				<tr>
					<td><?=$row->nama_kategori;?></td>
					<td>
						<a href="<?=base_url(akses().'/produk/kategori/edit').'?id='.$id;?>" class="btn btn-md btn-info"><i class="fa fa-pencil"></i> Ubah</a>
						<a onclick="return confirm('Yakin ingin menghapus Kategori ini?');" href="<?=base_url(akses().'/produk/kategori/delete').'?id='.$id;?>" class="btn btn-md btn-danger"><i class="fa fa-trash"></i> Hapus</a>
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