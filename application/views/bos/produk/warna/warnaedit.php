<?php
if(empty($data))
{
redirect(base_url(akses().'/produk/warna'));
}
foreach($data as $row){ 	
}
echo form_open(base_url(akses().'/produk/warna/edit'));
?>
<input type="hidden" name="warnaid" value="<?=$row->warna_id;?>" required=""/>
<div class="form-group required">
<label class="ctl">Nama Warna</label>
<input type="text" name="nama" class="form-control" required="" placeholder="Nama Warna" value="<?=set_value('nama',$row->nama_warna);?>"/>
</div>
<div class="form-group">
<button type="submit" class="btn btn-primary btn-flat">Ubah</button>
<a href="javascript:history.back(-1);" class="btn btn-default btn-flat">Batal</a>
</div>
<?php echo form_close();?>