<?php
if(empty($data))
{
	redirect(base_url(akses().'/mitra/supplier'),'refresh',301);
}
foreach($data as $row){	
}
?>

<?php
echo validation_errors();
echo form_open(base_url(akses().'/mitra/supplier/buatakun'),array('class'=>'form-horizontal'));
?>
<input type="hidden" name="supplierid" value="<?=$row->supplier_id;?>"/>
<input type="hidden" name="userid" value="<?=$row->user_id;?>"/>
<div class="form-group">
	<label class="col-sm-2 control-label" for="">Nama</label>
	<div class="col-md-7">
		<input type="text" name="nama" id="" class="form-control " autocomplete="off" placeholder="Nama" required="" value="<?php echo set_value('nama',field_value('userlogin','user_id',$row->user_id,'nama')); ?>"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="">Username</label>
	<div class="col-md-7">
		<input type="text" name="username" id="" class="form-control " autocomplete="off" placeholder="Username" required="" value="<?php echo set_value('username',field_value('userlogin','user_id',$row->user_id,'username')); ?>"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="">Password</label>
	<div class="col-md-5">
		<input type="password" name="password" id="" class="form-control " autocomplete="off" placeholder="Password"/>
		<small class="text-info">Silahkan entri jika ingin mengubah password</small>
	</div>
</div>
<?php
$lbl="Tambahkan";
if(!empty($row->user_id))
{
	$lbl="Ubah";
}
?>
<div class="form-group">
	<label class="col-sm-2 control-label">&nbsp;</label>
	<div class="col-md-10">
		<button type="submit" class="btn btn-primary btn-flat"><?=$lbl;?></button>
		<a href="javascript:history.back(-1);" class="btn btn-default btn-flat">Batal</a>
	</div>
</div>
<?php
echo form_close();
?>