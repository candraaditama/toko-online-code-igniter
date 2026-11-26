<?php
if(empty($data))
{
	redirect(base_url(akses().'/cms/kategori'));
}
foreach($data as $row){
}
echo validation_errors();
echo form_open(base_url(akses()).'/cms/kategori/edit',array('class'=>'form-horizontal'));
?>
<input type="hidden" name="kategoriid" value="<?=$row->berita_kategori_id;?>"/>
<div class="form-group">
	<label class="col-sm-2 control-label" for="">Nama Kategori</label>
	<div class="col-md-10">
		<input type="text" name="nama" id="" class="form-control " autocomplete="" placeholder="" required="" value="<?php echo set_value('nama',$row->nama_kategori); ?>"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label">&nbsp;</label>
	<div class="col-md-10">
		<button type="submit" class="btn btn-primary btn-flat">Update</button>
		<a href="javascript:history.back(-1);" class="btn btn-default btn-flat">Batal</a>
	</div>
</div>
<?php
echo form_close();
?>