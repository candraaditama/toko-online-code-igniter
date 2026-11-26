<?php
echo asset_select2();
echo add_js(base_url().'assets/plugin/ckeditor/ckeditor.js');
echo form_open(base_url(akses().'/cms/berita/add'));
?>
<div class="col-md-8">
	<div class="form-group">
		<input type="text" name="judul" class="form-control" required="" placeholder="Judul Berita" value="<?=set_value('judul');?>"/>
	</div>
	<div class="form-group">
		<textarea name="isi" class="form-control" id="isi" required="" placeholder="Isi Berita"><?=set_value('isi');?></textarea>
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
				echo '<option value="'.$rKat->berita_kategori_id.'">'.$rKat->nama_kategori.'</option>';
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
			<option value="publish">Publikasi</option>
			<option value="draft">Draft</option>
		</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">&nbsp;</label>
		<div class="col-md-10">
			<button type="submit" class="btn btn-primary btn-flat">Tambah</button>
			<a href="javascript:history.back(-1);" class="btn btn-default btn-flat">Batal</a>
		</div>
	</div>
</div>
<?php
echo form_close();
?>