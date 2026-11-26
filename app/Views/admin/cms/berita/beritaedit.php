<?php
if(empty($data))
{
	redirect(base_url(akses().'/cms/berita'));
}
foreach($data as $row){	
}
echo asset_select2();
echo add_js(base_url().'assets/plugin/ckeditor/ckeditor.js');
echo form_open(base_url(akses().'/cms/berita/edit'));
?>
<input type="hidden" name="beritaid" value="<?=$row->berita_id;?>"/>
<div class="col-md-8">
	<div class="form-group">
		<input type="text" name="judul" class="form-control" required="" placeholder="Judul Berita" value="<?=set_value('judul',$row->judul);?>"/>
	</div>
	<div class="form-group">
		<textarea name="isi" class="form-control" id="isi" required="" placeholder="Isi Berita"><?=set_value('isi',$row->isi);?></textarea>
	</div>
	<script>
	CKEDITOR.replace('isi', {	    	    
	    filebrowserBrowseUrl: '<?=base_url();?>filemanager/index_single',	    
	});
	</script>
</div>
<div class="col-md-4">
	<div class="panel panel-default">
		<div class="panel-heading">Kategori</div>
		<div class="panel-body">
		<select name="kategoriid" class="form-control select2" data-placeholder="Pilih Kategori" required="" style="width: 100%">
		<option></option>
		<?php
		if(!empty($kategori))
		{
			foreach($kategori as $rKat)
			{
				$kk='';
				if($rKat->berita_kategori_id==$row->berita_kategori_id)
				{
					$kk='selected="selected"';
				}
				echo '<option value="'.$rKat->berita_kategori_id.'" '.$kk.'>'.$rKat->nama_kategori.'</option>';
			}
		}
		?>
		</select>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">Posting</div>
		<div class="panel-body">
		<select name="status" class="form-control" required="">
			<?php
			$c1='';
			$c2='';
			if($row->status=="publish")
			{
				$c1='selected="selected"';
				$c2='';
			}else{
				$c2='selected="selected"';
				$c1='';
			}
			?>
			<option value="publish" <?=$c1;?>>Publikasi</option>
			<option value="draft" <?=$c2;?>>Draft</option>
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
</div>
<?php
echo form_close();
?>