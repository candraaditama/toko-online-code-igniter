<?php
echo asset_select2();
echo asset_datatables();
?>
<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default">
		  <div class="panel-heading">Tambah Toko</div>
		  <div class="panel-body">
		    <?php echo form_open(base_url(akses().'/mitra/outlet/add'));?>
		    <div class="form-group required">
		    	<label class="ctl">Nama Toko</label>
		    	<input type="text" name="nama" class="form-control" required="" placeholder="Nama Toko" value="<?=set_value('nama');?>"/>
		    </div>
		    <div class="form-group">
		    	<label class="ctl">Alamat</label>
		    	<textarea name="alamat" class="form-control" placeholder="Alamat Toko"><?=set_value('alamat');?></textarea>
		    </div>
		    <div class="form-group required">
		    	<label class="ctl">Telepon</label>
		    	<input type="text" name="telepon" class="form-control" required="" placeholder="Telp. Toko" value="<?=set_value('telepon');?>"/>
		    </div>
		    <div class="form-group required">
		    	<label class="ctl">Kota</label>
		    	<select name="kota" class="form-control select2" required="" style="width: " data-placeholder="Pilih Kota">
		    		<option></option>
		    		<?php
		    		$dKota=$this->m_db->get_data('lokasi_kota',array(),'nama_kota ASC');
		    		if(!empty($dKota))
		    		{
						foreach($dKota as $rKota)
						{
							echo '<option value="'.$rKota->kota_id.'" '.set_select('kota',$rKota->kota_id).'>'.$rKota->nama_kota.'</option>';
						}
					}
		    		?>
		    	</select>
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
			<th>Nama Toko</th>
			<th>Alamat</th>
			<th>Telepon</th>
			<th>Kota</th>
			<th></th>
		</thead>
		<tbody>
			<?php
			if(!empty($data))
			{
				foreach($data as $row)
				{
					$id=$row->toko_id;
					$kota=field_value('lokasi_kota','kota_id',$row->kota,'nama_kota');
				?>
				<tr>
					<td><?=$row->nama_toko;?></td>
					<td><?=$row->alamat;?></td>
					<td><?=$row->telepon;?></td>
					<td><?=$kota;?></td>
					<td>
						<a href="<?=base_url(akses().'/mitra/outlet/pengguna').'?id='.$id;?>" class="btn btn-md btn-default"><i class="fa fa-users"></i></a>
						<a href="<?=base_url(akses().'/mitra/outlet/edit').'?id='.$id;?>" class="btn btn-md btn-info"><i class="fa fa-pencil"></i></a>
						<a onclick="return confirm('Yakin ingin menghapus toko ini?');" href="<?=base_url(akses().'/mitra/outlet/delete').'?id='.$id;?>" class="btn btn-md btn-danger"><i class="fa fa-trash"></i></a>
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