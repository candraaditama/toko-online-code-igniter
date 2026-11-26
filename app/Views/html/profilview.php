<?php
echo asset_select2();
$ref=$this->input->get('ref');
echo validation_errors();
echo form_open(base_url('akun').'?ref='.$ref,array('class'=>'form-horizontal'));
?>
<div class="form-group required">
	<label class="col-sm-2 control-label" for="">Nama Lengkap</label>
	<div class="col-md-10">
		<input type="text" name="nama" id="" class="form-control " autocomplete="off" placeholder="Nama Lengkap" required="" value="<?php echo set_value('nama',pelanggan_info('nama_pelanggan')); ?>"/>
	</div>
</div>
<div class="form-group required">
	<label class="col-sm-2 control-label" for="">No HP</label>
	<div class="col-md-5">
		<input type="text" name="hp" id="" class="form-control " autocomplete="off" placeholder="Nomor Handphone" required="" value="<?php echo set_value('hp',pelanggan_info('hp')); ?>"/>
	</div>
</div>
<div class="form-group required">
	<label class="col-sm-2 control-label" for="">Alamat</label>
	<div class="col-md-10">
		<textarea name="alamat" required="" class="form-control" placeholder="Alamat Pengiriman"><?=set_value('alamat',pelanggan_info('alamat'));?></textarea>
	</div>
</div>
<div class="form-group required">
	<label class="col-sm-2 control-label" for="">Kota</label>
	<div class="col-md-7">
		<select name="kota" class="form-control select2" required="" style="width: " data-placeholder="Pilih Kota">
    		<option></option>
    		<?php
    		$dKota=$this->m_db->get_data('lokasi_kota',array(),'nama_kota ASC');
    		if(!empty($dKota))
    		{
				foreach($dKota as $rKota)
				{
					$jj='';
					if(pelanggan_info('kota')==$rKota->kota_id)
					{
						$jj='selected="selected"';
					}
					echo '<option value="'.$rKota->kota_id.'" '.$jj.'>'.$rKota->nama_kota.'</option>';
				}
			}
    		?>
    	</select>
	</div>
</div>
<div class="form-group required">
	<label class="col-sm-2 control-label" for="">Email</label>
	<div class="col-md-6">
		<input type="email" name="email" id="" class="form-control " autocomplete="off" placeholder="Email Anda" required="" value="<?php echo set_value('email',pelanggan_info('email')); ?>"/>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-2 control-label">&nbsp;</label>
	<div class="col-md-6">
		<button type="submit" class="btn btn-primary btn-flat">Update Akun</button>
	</div>
</div>
<?php
echo form_close();
?>