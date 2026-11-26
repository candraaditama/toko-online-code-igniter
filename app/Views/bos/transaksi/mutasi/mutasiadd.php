<?php
echo asset_select2();
echo asset_jqueryui();
echo form_open(base_url(akses().'/transaksi/mutasi/add'),array('id'=>'formcari','class'=>'form-horizontal'));
?>
<div class="form-group">
	<label class="col-sm-2 control-label" for="">Tanggal</label>
	<div class="col-md-4">
		<input type="text" name="tanggal" id="" class="form-control tanggal" autocomplete="off" placeholder="Tanggal Transaksi" required="" value="<?php echo set_value('tanggal',date("Y-m-d")); ?>" readonly=""/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="">Tujuan Toko</label>
	<div class="col-md-10">
		<select name="toko" id="toko" class="form-control select2" required="" data-placeholder="Pilih Toko" style="width: 100%"></select>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="">Produk</label>
	<div class="col-md-10">
		<select name="produk" id="produk" class="form-control select2" required="" data-placeholder="Pilih Produk" style="width: 100%">			
		</select>
	</div>
</div>
<div class="form-group" id="divdetail" style="display: none;">
	<label class="col-sm-2 control-label" for="">Detail Produk</label>
	<div class="col-md-10" id="detailproduk">		
	</div>
</div>
<div class="form-group" id="divket" style="display: none;">
	<label class="col-sm-2 control-label">Keterangan</label>
	<div class="col-md-10">
		<textarea name="keterangan" class="form-control"><?=set_value('keterangan');?></textarea>
	</div>
</div>
<div class="form-group" id="btnsubmit" style="display: none;">
	<label class="col-sm-2 control-label">&nbsp;</label>
	<div class="col-md-10">
		<button type="submit" class="btn btn-default"><i class="fa fa-save"></i> Tambahkan</button>
	</div>
</div>
<?php
echo form_close();
?>

<script>
$(document).ready(function(){

$("#toko").select2({		
	ajax:{
		url:'<?=base_url(akses()."/transaksi/mutasi/getdata");?>',
		dataType:'json',
		delay:0,
		data:function(){	
		},
		processResults: function (data,params) {
			params.page = params.page || 1;
	      	return {
		        results: $.map(data, function(obj) {
		            return { id: obj.toko_id, text: obj.nama_toko };
		        }),
		        pagination: {
		          more: (params.page * 30) < data.total_count
		        }
	    	};
	    }
	}
});

$("#produk").select2({		
	ajax:{
		url:'<?=base_url(akses()."/transaksi/mutasi/getproduk");?>',
		dataType:'json',
		delay:0,
		data:function(){			
		},
		processResults: function (data,params) {
			params.page = params.page || 1;
	      	return {
		        results: $.map(data, function(obj) {
		            return { id: obj.produk_id, text: obj.nama_produk };
		        }),
		        pagination: {
		          more: (params.page * 30) < data.total_count
		        }
	    	};
	    }
	}
});

$("#produk").on("select2:select",function(){
	var did=$(this).val();
	if(did!="")
	{
		$.ajax({
		  method: "get",
		  dataType:"html",
		  url: "<?=base_url(akses().'/transaksi/mutasi/getprodukdetail');?>",
		  data: "id="+did,
		  beforeSend:function(){
		  	$("#divdetail").hide();
		  	$("#btnsubmit").hide();
		  	$("#divket").hide();
		  }
		})
		.done(function( x ) {
		    $("#detailproduk").html(x);
		    $("#divdetail").show();
		    $("#btnsubmit").show();
		    $("#divket").show();
		})
		.fail(function(  ) {
			$("#divdetail").hide();
			$("#btnsubmit").hide();
			$("#divket").hide();
		});		
	}
});

});
</script>