<?php
if(empty($data))
{
redirect(base_url(akses().'/produk/kategori'));
}
foreach($data as $row){ 	
}
echo form_open(base_url(akses().'/produk/kategori/edit'));
?>
<input type="hidden" name="kategoriid" value="<?=$row->kategori_id;?>" required=""/>
<div class="form-group required">
<label class="ctl">Nama Kategori</label>
<input type="text" name="nama" class="form-control" required="" placeholder="Nama Kategori" value="<?=set_value('nama',$row->nama_kategori);?>"/>
</div>
<div class="form-group">
<button type="submit" class="btn btn-primary btn-flat">Ubah</button>
<a href="javascript:history.back(-1);" class="btn btn-default btn-flat">Batal</a>
</div>
<?php echo form_close();?>