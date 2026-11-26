<?php
if(empty($data))
{
redirect(base_url(akses().'/produk/ukuran'));
}
foreach($data as $row){ 	
}
echo form_open(base_url(akses().'/produk/ukuran/edit'));
?>
<input type="hidden" name="ukuranid" value="<?=$row->ukuran_id;?>" required=""/>
<div class="form-group required">
<label class="ctl">Nama Ukuran</label>
<input type="text" name="nama" class="form-control" required="" placeholder="Nama Ukuran" value="<?=set_value('nama',$row->nama_ukuran);?>"/>
</div>
<div class="form-group">
<button type="submit" class="btn btn-primary btn-flat">Ubah</button>
<a href="javascript:history.back(-1);" class="btn btn-default btn-flat">Batal</a>
</div>
<?php echo form_close();?>