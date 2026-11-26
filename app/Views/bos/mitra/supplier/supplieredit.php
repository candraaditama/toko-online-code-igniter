<?php
if(empty($data))
{
redirect(base_url(akses().'/produk/supplier'));
}
foreach($data as $row){ 	
}
echo form_open(base_url(akses().'/produk/supplier/edit'));
?>
<input type="hidden" name="supplierid" value="<?=$row->supplier_id;?>" required=""/>
<div class="form-group required">
<label class="ctl">Nama Supplier</label>
<input type="text" name="nama" class="form-control" required="" placeholder="Nama Supplier" value="<?=set_value('nama',$row->nama_supplier);?>"/>
</div>
<div class="form-group">
<label class="ctl">Alamat</label>
<textarea name="alamat" class="form-control" placeholder="Alamat Supplier"><?=set_value('alamat',$row->alamat);?></textarea>
</div>
<div class="form-group required">
<label class="ctl">Telepon</label>
<input type="text" name="telepon" class="form-control" required="" placeholder="Telp. Supplier" value="<?=set_value('telepon',$row->telepon);?>"/>
</div>
<div class="form-group">
<button type="submit" class="btn btn-primary btn-flat">Ubah</button>
<a href="javascript:history.back(-1);" class="btn btn-default btn-flat">Batal</a>
</div>
<?php echo form_close();?>