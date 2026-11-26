<?php
echo add_js(base_url().'assets/plugin/ckeditor/ckeditor.js');
echo asset_select2();
if(empty($data))
{
	redirect(base_url(akses().'/produk/produk'));
}
foreach($data as $row){	
}
$produkID=$row->produk_id;
echo validation_errors();
echo form_open_multipart(base_url(akses().'/produk/produk/edit'),array('class'=>'form-horizontal'));
?>
<input type="hidden" name="produkid" value="<?=$row->produk_id;?>"/>
<div class="form-group required">
	<label class="col-sm-2 control-label" for="">Kode Produk</label>
	<div class="col-md-5">
		<input type="text" name="kode" id="" class="form-control " autocomplete="off" placeholder="Kode Produk" required="" value="<?php echo set_value('kode',$row->kode_produk); ?>"/>
	</div>
</div>
<div class="form-group required">
	<label class="col-sm-2 control-label" for="">Nama Produk</label>
	<div class="col-md-10">
		<input type="text" name="nama" id="" class="form-control " autocomplete="off" placeholder="Nama Produk" required="" value="<?php echo set_value('nama',$row->nama_produk); ?>"/>
	</div>
</div>
<div class="form-group required">
	<label class="col-sm-2 control-label" for="">Supplier</label>
	<div class="col-md-10">
		<select name="supplier" id="supplier" class="form-control select2 ajx" required="" data-placeholder="Pilih Supplier" style="width: 100%">
		<option value="<?=$row->supplier_id;?>"><?=field_value('supplier','supplier_id',$row->supplier_id,'nama_supplier');?></option>
		</select>
		<a href="<?=base_url(akses().'/mitra/supplier');?>" class="btn btn-link" target="_blank">+ Tambah Supplier</a>
	</div>
</div>
<div class="form-group required">
	<label class="col-sm-2 control-label" for="">Kategori</label>
	<div class="col-md-10">
		<select name="kategori" id="kategori" class="form-control select2 ajx" required="" data-placeholder="Pilih Kategori" style="width: 100%">
		
		<option value="<?=$row->kategori_id;?>"><?=field_value('produk_kategori','kategori_id',$row->kategori_id,'nama_kategori');?></option>
		</select>
		<a href="<?=base_url(akses().'/produk/kategori');?>" class="btn btn-link" target="_blank">+ Tambah Kategori</a>
	</div>
</div>
<div class="form-group required">
	<label class="col-sm-2 control-label" for="">Merek</label>
	<div class="col-md-10">
		<select name="merek" id="merek" class="form-control select2 ajx" required="" data-placeholder="Pilih Merek" style="width: 100%">
		<option value="<?=$row->merek_id;?>"><?=field_value('produk_merek','merek_id',$row->merek_id,'nama_merek');?></option>
		</select>
		<a href="<?=base_url(akses().'/produk/merek');?>" class="btn btn-link" target="_blank">+ Tambah Merek</a>
	</div>
</div>
<div class="form-group required">
	<label class="col-sm-2 control-label" for="">Harga</label>
	<div class="col-md-10">
		<input type="text" name="harga" id="harga" class="form-control duit" autocomplete="off" placeholder="Harga Produk" required="" value="<?php echo set_value('harga',$row->harga); ?>"/>
	</div>
</div>
<div class="form-group required">
	<label class="col-sm-2 control-label" for="">Berat</label>
	<div class="col-md-5">
		<div class="input-group">		  
		  <input type="number" name="berat" id="" class="form-control " autocomplete="off" placeholder="Berat Produk" required="" value="<?php echo set_value('berat',$row->berat); ?>" step="0.1"/>
		  <span class="input-group-addon" id="">Gram</span>
		</div>		
	</div>
</div>
<div class="form-group required">
	<label class="col-sm-2 control-label" for="">Deskripsi</label>
	<div class="col-md-10">
		<textarea name="deskripsi" class="form-control" id="isi" required="" placeholder="Isi Halaman"><?=set_value('deskripsi','deskripsi');?></textarea>
		<script>
		CKEDITOR.replace('isi', {	    	    
		    filebrowserBrowseUrl: '<?=base_url();?>filemanager/index_single',		    
		});
		</script>
	</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label" for="">Photo</label>
<div class="col-md-10">
	<div class="row">
	<?php	
	for($i=1;$i<=4;$i++)
	{		
		$this->load->library('m_db');
		$photo=base_url().'assets/images/uploadbg.png';
		$fphoto="produk_".$produkID."-".$i;
		$sql="Select photo FROM produk_photo Where produk_id='$produkID' AND photo LIKE '$fphoto%'";
		$gPhoto=$this->m_db->get_query_row($sql,"photo");
		$pathfile=FCPATH.'assets/images/produk/'.$gPhoto;
		if(is_file($pathfile))
		{
			$photo=base_url().'assets/images/produk/'.$gPhoto;
		}		
	?>
	<div class="col-xs-3">
	    <a href="javascript:;" class="thumbnail uploadbox" data-id="<?=$i;?>" id="upload_<?=$i;?>">
	      <img src="<?=$photo;?>" class="gg" id="preview_img_<?=$i;?>" style="width: 128px;height:94px"/>
	    </a>
	</div>
	<input type="file" name="upload<?=$i;?>" class="ff" onchange="preview_image(this,'preview_img_<?=$i;?>');" data-id="<?=$i;?>" id="ele_upload_<?=$i;?>" style="display: none;"/>
	<input type="hidden" name="fupload<?=$i;?>" value="<?=$gPhoto;?>"/>
	<?php
	}
	?>	
	</div>	  		
</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label">&nbsp;</label>
	<div class="col-md-10">
		<button type="submit" class="btn btn-primary btn-flat">Ubah</button>
		<a href="javascript:history.back(-1);" class="btn btn-default btn-flat">Batal</a>
	</div>
</div>
<?php
echo form_close();
?>
<script>
$(document).ready(function(){

$(".uploadbox").each(function(){
	$(this).click(function(){		
		var did=$(this).attr('data-id');
		$("#ele_upload_"+did).trigger("click");
	});
});

$("#supplier").select2({		
	ajax:{
		url:'<?=base_url(akses()."/produk/produk/getdata");?>',
		dataType:'json',
		delay:0,
		data:function(){
			return {
			tipe:"supplier",		        
	    	};
		},
		processResults: function (data,params) {
			params.page = params.page || 1;
	      	return {
		        results: $.map(data, function(obj) {
		            return { id: obj.supplier_id, text: obj.nama_supplier };
		        }),
		        pagination: {
		          more: (params.page * 30) < data.total_count
		        }
	    	};
	    }
	}
});

$("#merek").select2({		
	ajax:{
		url:'<?=base_url(akses()."/produk/produk/getdata");?>',
		dataType:'json',
		delay:0,
		data:function(){
			return {
			tipe:"merek",		        
	    	};
		},
		processResults: function (data,params) {
			params.page = params.page || 1;
	      	return {
		        results: $.map(data, function(obj) {
		            return { id: obj.merek_id, text: obj.nama_merek };
		        }),
		        pagination: {
		          more: (params.page * 30) < data.total_count
		        }
	    	};
	    }
	}
});

$("#kategori").select2({		
	ajax:{
		url:'<?=base_url(akses()."/produk/produk/getdata");?>',
		dataType:'json',
		delay:0,
		data:function(){
			return {
			tipe:"kategori",		        
	    	};
		},
		processResults: function (data,params) {
			params.page = params.page || 1;
	      	return {
		        results: $.map(data, function(obj) {
		            return { id: obj.kategori_id, text: obj.nama_kategori };
		        }),
		        pagination: {
		          more: (params.page * 30) < data.total_count
		        }
	    	};
	    }
	}
});


});


function preview_image(fileInput,targetID) {
    var files = fileInput.files;
    for (var i = 0; i < files.length; i++) {           
        var file = files[i];
                
        var img=document.getElementById(targetID);            
        img.file = file;    
        var reader = new FileReader();
        reader.onload = (function(aImg) { 
            return function(e) { 
                aImg.src = e.target.result; 
            }; 
        })(img);
        reader.readAsDataURL(file);
    }    
}
</script>