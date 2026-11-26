<?php
if(empty($data))
{
	redirect(base_url(akses().'/pengguna'));
}
foreach($data as $row){	
}
echo asset_select2();
echo validation_errors();
echo form_open(base_url(akses().'/pengguna/edit'),array('class'=>'form-horizontal'));
?>
<input type="hidden" name="userid" value="<?=$row->user_id;?>"/>
<div class="form-group required">
	<label class="col-sm-2 control-label" for="">Nama</label>
	<div class="col-md-10">
		<input type="text" name="nama" id="" class="form-control " autocomplete="off" placeholder="Nama Lengkap" required="" value="<?php echo set_value('nama',$row->nama); ?>"/>
	</div>
</div>
<div class="form-group required">
	<label class="col-sm-2 control-label" for="">Username</label>
	<div class="col-md-6">
		<input type="text" name="username" readonly="" id="username" class="form-control " autocomplete="off" placeholder="Username" required="" value="<?php echo set_value('username',$row->username); ?>"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="">Password</label>
	<div class="col-md-6">
		<input type="password" name="password" id="" class="form-control " autocomplete="off" placeholder="Password" value="<?php echo set_value('password'); ?>"/>
		<small class="text-info">Entri jika ingin mengubah password</small>
	</div>
</div>
<div class="form-group required">
	<label class="col-sm-2 control-label" for="">Akses</label>
	<div class="col-md-8">
		<select name="akses" class="form-control select2" data-placeholder="Pilih Akses" style="width: 100%" required="">
			<option></option>
			<?php
			if(!empty($akses))
			{
				foreach($akses as $rakses)
				{
					$j='';
					if($rakses==$row->akses)
					{
						$j='selected="selected"';
					}
					echo '<option value="'.$rakses.'" '.set_select('akses',$rakses).' '.$j.'>'.ucfirst($rakses).'</option>';
				}
			}
			?>
		</select>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label">&nbsp;</label>
	<div class="col-md-10">
		<button type="submit" class="btn btn-primary btn-flat">Ubah</button>
		<a href="javascript:history.back(-1);" class="btn btn-default btn-flat">Batal</a>
	</div>
</div>
<?php
echo form_close();
?>