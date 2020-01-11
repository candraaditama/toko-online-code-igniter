<?php
echo asset_select2();
if(empty($data))
{
	redirect(base_url(akses().'/mitra/outlet'));
}
foreach($data as $row){	
}
echo form_open(base_url(akses().'/mitra/outlet/edit'));
?>
<input type="hidden" name="tokoid" value="<?=$row->toko_id;?>"/>
	<div class="form-group required">
	<label class="ctl">Nama Toko</label>
	<input type="text" name="nama" class="form-control" required="" placeholder="Nama Toko" value="<?=set_value('nama',$row->nama_toko);?>"/>
</div>
<div class="form-group">
	<label class="ctl">Alamat</label>
	<textarea name="alamat" class="form-control" placeholder="Alamat Toko"><?=set_value('alamat',$row->alamat);?></textarea>
	</div>
<div class="form-group required">
	<label class="ctl">Telepon</label>
	<input type="text" name="telepon" class="form-control" required="" placeholder="Telp. Toko" value="<?=set_value('telepon',$row->telepon);?>"/>
	</div>
<div class="form-group required">
<label class="ctl">Kota</label>
<select name="kota" class="form-control select2" required="" style="width: " data-placeholder="Pilih Kota">
	<option value="<?=$row->kota;?>"><?=field_value('lokasi_kota','kota_id',$row->kota,'nama_kota');?></option>
	<?php
	$dKota=$this->m_db->get_data('lokasi_kota',array(),'nama_kota ASC');
	if(!empty($dKota))
	{
			foreach($dKota as $rKota)
			{
				$jj='';
				if($rKota->kota_id==$row->kota)
				{
					$jj='seleted="selected"';
				}
				echo '<option value="'.$rKota->kota_id.'" '.$jj.'>'.$rKota->nama_kota.'</option>';
			}
		}
	?>
</select>
</div>
<div class="form-group">
<button type="submit" class="btn btn-primary btn-flat">Ubah</button>
<a href="javascript:history.back(-1);" class="btn btn-default btn-flat">Batal</a>
</div>
<?php echo form_close();?>