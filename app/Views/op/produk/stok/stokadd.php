<?php
echo asset_select2();
if(empty($data))
{
	redirect(base_url(akses().'/produk/produk'));
}
foreach($data as $row){	
}
$nama=$row->kode_produk."-".$row->nama_produk;
$supplier=field_value('supplier','supplier_id',$row->supplier_id,'nama_supplier');
$kategori=field_value('produk_kategori','kategori_id',$row->kategori_id,'nama_kategori');
$merek=field_value('produk_merek','merek_id',$row->merek_id,'nama_merek');
?>
<div class="form-horizontal">
	<div class="col-md-8">
		<?php
		echo validation_errors();
		echo form_open('#',array('class'=>'form-horizontal','id'=>'formadd'));
		?>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="">Ukuran</label>
			<div class="col-md-10">
				<select name="ukuran" id="ukuran" class="form-control select2" data-placeholder="Pilih Ukuran" required="" style="width: 100%">
				</select>
				<a href="<?=base_url(akses().'/produk/ukuran');?>" class="btn btn-link" target="_blank">+ Tambah Ukuran</a>
			</div>
		</div>		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="">Warna</label>
			<div class="col-md-10">
				<select name="warna" id="warna" class="form-control select2" data-placeholder="Pilih Warna" required="" style="width: 100%">
				</select>
				<a href="<?=base_url(akses().'/produk/warna');?>" class="btn btn-link" target="_blank">+ Tambah Warna</a>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="">Stok</label>
			<div class="col-md-4">
				<input type="number" name="stok" id="stok" class="form-control" value="0" required=""/>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">&nbsp;</label>
			<div class="col-md-10">
				<button type="submit" class="btn btn-primary btn-flat">Tambah</button>				
			</div>
		</div>
		<?php
		echo form_close();
		?>
		<?php
		echo form_open(base_url(akses().'/produk/stok'),array('id'=>'formselesai'));
		?>
		<input type="hidden" name="produkid" value="<?=$row->produk_id;?>"/>
		<input type="hidden" name="tokoid" value="<?=$tokoid;?>"/>
		<table class="table table-bordered">
			<thead>
				<th width="30%">Ukuran</th>
				<th width="30%">Warna</th>
				<th width="20%">Stok</th>
				<th></th>
			</thead>
			<tbody id="tabelitem">		
			</tbody>
			<tfoot>
				<tr>
					<td colspan="3">
						<button type="submit" onclick="return confirm('Yakin data ini benar?');" class="btn btn-primary" id="btnselesai" style="display: none;">Tambah Stok</button>
					</td>
				</tr>
			</tfoot>
		</table>
		<?php echo form_close();?>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label class="col-sm-3 control-label">Nama Produk</label>
			<div class="col-md-9">
				<p class="form-control-static"><?=$nama;?></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">Supplier</label>
			<div class="col-md-9">
				<p class="form-control-static"><?=$supplier;?></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">kategori</label>
			<div class="col-md-9">
				<p class="form-control-static"><?=$kategori;?></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">Merek</label>
			<div class="col-md-9">
				<p class="form-control-static"><?=$merek;?></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label"></label>
			<div class="col-md-9">
				<p class="form-control-static"></p>
			</div>
		</div>
	</div>
</div>

<script>
var last_no=0;
$(document).ready(function(){


$("#formadd").submit(function(e_handle){
	e_handle.preventDefault();
	last_no+=1;
	var ukuran_nama=$("#ukuran").text();
	var ukuran_id=$("#ukuran").val();
	var warna_nama=$("#warna").text();
	var warna_id=$("#warna").val();
	var stok=$("#stok").val();
	if(parseInt(stok) > 0)
	{			
	var og='<tr id="item'+last_no+'" class="item">'+
		'<td>'+ukuran_nama+'</td>'+
		'<td>'+warna_nama+'</td>'+
		'<td>'+stok+'</td>'+
		'<td>'+
		'<a href="javascript:;" onclick="deleteitem('+last_no+')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>'+
		'<input type="hidden" name="info[ukuran][]" value="'+ukuran_id+'"/>'+
		'<input type="hidden" name="info[warna][]" value="'+warna_id+'"/>'+
		'<input type="hidden" name="info[stok][]" value="'+stok+'"/>'+
		'</td>'+
		'</tr>';
	$(og).appendTo("#tabelitem");
	cek_ada();
	}else{
		alert('Stok harus ada');
	}
});

$("#ukuran").select2({		
	ajax:{
		url:'<?=base_url(akses()."/produk/produk/getdata");?>',
		dataType:'json',
		delay:0,
		data:function(){
			return {
			tipe:"ukuran",		        
	    	};
		},
		processResults: function (data,params) {
			params.page = params.page || 1;
	      	return {
		        results: $.map(data, function(obj) {
		            return { id: obj.ukuran_id, text: obj.nama_ukuran };
		        }),
		        pagination: {
		          more: (params.page * 30) < data.total_count
		        }
	    	};
	    }
	}
});

$("#warna").select2({		
	ajax:{
		url:'<?=base_url(akses()."/produk/produk/getdata");?>',
		dataType:'json',
		delay:0,
		data:function(){
			return {
			tipe:"warna",		        
	    	};
		},
		processResults: function (data,params) {
			params.page = params.page || 1;
	      	return {
		        results: $.map(data, function(obj) {
		            return { id: obj.warna_id, text: obj.nama_warna };
		        }),
		        pagination: {
		          more: (params.page * 30) < data.total_count
		        }
	    	};
	    }
	}
});

});

function cek_ada()
{
	var jml=$(".item").length;
	if(jml > 0)
	{
		$("#btnselesai").show();
	}else{
		$("#btnselesai").hide();
	}
}

function deleteitem(id)
{
	$("#item"+id).remove();
	cek_ada();
}
</script>