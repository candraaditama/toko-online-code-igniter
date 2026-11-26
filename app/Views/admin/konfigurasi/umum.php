<?php
if(!empty($data))
{
echo validation_errors();
echo form_open(base_url(akses().'/konfigurasi/updateumum'),array('class'=>'form-horizontal'));

foreach($data as $row)
{
	$title1=str_replace("-"," ",$row->nama_key);
	$title=ucwords($title1);
?>
<div class="form-group">
	<label class="col-sm-2 control-label" for=""><?=$title;?></label>
	<div class="col-md-10">
		<input type="text" name="<?=$row->nama_key;?>" id="" class="form-control " autocomplete="off" placeholder="<?=$title;?>" required="" value="<?php echo set_value($row->nama_key,$row->isi); ?>"/>
	</div>
</div>
<?php
}
?>
<div class="form-group">
	<label class="col-sm-2 control-label">&nbsp;</label>
	<div class="col-md-10">
		<button type="submit" class="btn btn-primary btn-flat">Ubah</button>		
	</div>
</div>
<?php
echo form_close();
}
?>