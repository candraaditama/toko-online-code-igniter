<?php
echo asset_datatables();
?>
<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default">
		  <div class="panel-heading">Tambah Supplier</div>
		  <div class="panel-body">
		    <?php echo form_open(base_url(akses().'/mitra/supplier/add'));?>
		    <div class="form-group required">
		    	<label class="ctl">Nama Supplier</label>
		    	<input type="text" name="nama" class="form-control" required="" placeholder="Nama Supplier" value="<?=set_value('nama');?>"/>
		    </div>
		    <div class="form-group">
		    	<label class="ctl">Alamat</label>
		    	<textarea name="alamat" class="form-control" placeholder="Alamat Supplier"><?=set_value('alamat');?></textarea>
		    </div>
		    <div class="form-group required">
		    	<label class="ctl">Telepon</label>
		    	<input type="text" name="telepon" class="form-control" required="" placeholder="Telp. Supplier" value="<?=set_value('telepon');?>"/>
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
			<th>Nama Supplier</th>
			<th>Alamat</th>
			<th>Telepon</th>
			<th></th>
		</thead>
		<tbody>
			<?php
			if(!empty($data))
			{
				foreach($data as $row)
				{
					$id=$row->supplier_id;
				?>
				<tr>
					<td><?=$row->nama_supplier;?></td>
					<td><?=$row->alamat;?></td>
					<td><?=$row->telepon;?></td>
					<td>						
						<a href="<?=base_url(akses().'/mitra/supplier/buatakun').'?id='.$id;?>" class="btn btn-md btn-default"><i class="fa fa-user"></i></a>						
						<a href="<?=base_url(akses().'/mitra/supplier/edit').'?id='.$id;?>" class="btn btn-md btn-info"><i class="fa fa-pencil"></i></a>
						<a onclick="return confirm('Yakin ingin menghapus supplier ini?');" href="<?=base_url(akses().'/mitra/supplier/delete').'?id='.$id;?>" class="btn btn-md btn-danger"><i class="fa fa-trash"></i></a>
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