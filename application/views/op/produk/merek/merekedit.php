<?php
if(empty($data))
{
redirect(base_url(akses().'/produk/merek'));
}
foreach($data as $row){ 	
}
echo form_open(base_url(akses().'/produk/merek/edit'));
?>
<input type="hidden" name="merekid" value="<?=$row->merek_id;?>" required=""/>
<div class="form-group required">
<label class="ctl">Nama Merek</label>
<input type="text" name="nama" class="form-control" required="" placeholder="Nama Merek" value="<?=set_value('nama',$row->nama_merek);?>"/>
</div>
<div class="form-group">
<button type="submit" class="btn btn-primary btn-flat">Ubah</button>
<a href="javascript:history.back(-1);" class="btn btn-default btn-flat">Batal</a>
</div>
<?php echo form_close();?>