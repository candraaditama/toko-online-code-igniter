<?php
echo asset_select2();
$ref=$this->input->get('ref');
echo validation_errors();
echo form_open(base_url('member/daftar').'?ref='.$ref,array('class'=>'form-horizontal'));
?>
<div class="form-group required">
	<label class="col-sm-2 control-label" for="">Nama Lengkap</label>
	<div class="col-md-10">
		<input type="text" name="nama" id="" class="form-control " autocomplete="off" placeholder="Nama Lengkap" required="" value="<?php echo set_value('nama'); ?>"/>
	</div>
</div>
<div class="form-group required">
	<label class="col-sm-2 control-label" for="">No HP</label>
	<div class="col-md-5">
		<input type="text" name="hp" id="" class="form-control " autocomplete="off" placeholder="Nomor Handphone" required="" value="<?php echo set_value('hp'); ?>"/>
	</div>
</div>
<div class="form-group required">
	<label class="col-sm-2 control-label" for="">Alamat</label>
	<div class="col-md-10">
		<textarea name="alamat" required="" class="form-control" placeholder="Alamat Pengiriman"><?=set_value('alamat');?></textarea>
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
					echo '<option value="'.$rKota->kota_id.'" '.set_select('kota',$rKota->kota_id).'>'.$rKota->nama_kota.'</option>';
				}
			}
    		?>
    	</select>
	</div>
</div>
<div class="form-group required">
	<label class="col-sm-2 control-label" for="">Email</label>
	<div class="col-md-6">
		<input type="email" name="email" id="" class="form-control " autocomplete="off" placeholder="Email Anda" required="" value="<?php echo set_value('email'); ?>"/>
	</div>
</div>
<div class="form-group required">
	<label class="col-sm-2 control-label" for="">Username</label>
	<div class="col-md-6">
		<input type="text" name="username" id="" class="form-control " autocomplete="off" placeholder="Username" required="" value="<?php echo set_value('username'); ?>"/>
	</div>
</div>
<div class="form-group required">
	<label class="col-sm-2 control-label" for="">Password</label>
	<div class="col-md-6">
		<input type="password" name="password" id="" class="form-control " autocomplete="off" placeholder="Password" required="" value="<?php echo set_value('password'); ?>"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label">&nbsp;</label>
	<div class="col-md-6">
		<button type="submit" class="btn btn-primary btn-flat">Daftar</button>
		<a href="<?=base_url();?>member/login?ref=<?=$ref;?>" class="btn btn-default btn-flat">Sudah punya akun?</a>
	</div>
</div>
<?php
echo form_close();
?>