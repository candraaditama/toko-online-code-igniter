<?php
echo validation_errors();
if(empty($data))
{
	redirect(base_url(akses().'/produk/promo'));
}
foreach($data as $row){	
}
$urlOK='';
$urlBanner=base_url().'assets/images/'.$row->banner_gambar;
if(@getimagesize($urlBanner))
{
	$urlOK=$urlBanner;
}
echo form_open_multipart(base_url(akses().'/produk/promo/gambar'),array('class'=>'form-horizontal'));
?>
<input type="hidden" name="promoid" value="<?=$row->promo_id;?>"/>
<div class="form-group">
	<label class="col-sm-2 control-label" for="">Banner</label>
	<div class="col-md-10">
		<?php
		if(!empty($urlOK))
		{
		?>
		<a href="<?=$urlOK;?>" target="_blank">
			<img src="<?=$urlOK;?>" class="img-responsive" style="height: 200px;width:300px;"/><br/>
			<a href="<?=base_url(akses().'/produk/promo/deletebanner').'?id='.$row->promo_id;?>" class="btn btn-danger btn-lg">Hapus Banner</a>
		</a>
		<?php	
		}else{					
		?>
		<input type="file" name="file" id="" class="form-control " autocomplete="" placeholder="" required=""/>
		<?php
		}
		?>
	</div>
</div>
<?php
if(empty($urlOK))
{
?>
<div class="form-group">
	<label class="col-sm-2 control-label">&nbsp;</label>
	<div class="col-md-10">
		<button type="submit" class="btn btn-primary btn-flat">Upload</button>
		<a href="javascript:history.back(-1);" class="btn btn-default btn-flat">Kembali</a>
	</div>
</div>
<?php
}
?>
<?php
echo form_close();
?>