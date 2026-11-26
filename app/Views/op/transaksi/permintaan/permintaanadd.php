<?php
echo asset_jqueryui();
echo asset_select2();
echo validation_errors();
echo form_open(base_url(akses().'/transaksi/permintaan/add'),array('class'=>'form-horizontal'));
?>
<div class="row">
	<div class="col-md-4">
		<b>Tanggal</b><br/>
		<input type="text" name="tanggal" id="tanggal" required="" class="form-control tanggal" value="<?=set_value('tanggal',date('Y-m-d'));?>"/>
	</div>
	<div class="col-md-8">
		<b>Supplier</b><br/>
		<select name="supplierid" id="supplier" class="form-control select2" required="" style="width: 100%" data-placeholder="Pilih Supplier">
			<option></option>
			<?php
			if(!empty($supplier))
			{
				foreach($supplier as $rsup)
				{
					echo '<option value="'.$rsup->supplier_id.'">'.$rsup->nama_supplier.'</option>';
				}
			}
			?>
		</select>
	</div>
</div>
<hr/>
<div class="row">
	<div class="col-md-12">
	<table class="table table-bordered">
		<thead>
			<th>Nama Produk</th>
			<th width="20%">Jumlah</th>
			<th width="10%"></th>
		</thead>
		<tbody>
			<tr>
				<td>
					<select name="produkid" id="produkid" class="form-control select2" style="width: 100%" data-placeholder="Pilih Produk">
					<option></option>
					<?php
					if(!empty($produk))
					{
						foreach($produk as $rpro)
						{
							echo '<option value="'.$rpro->produk_id.'">'.$rpro->nama_produk.'</option>';
						}
					}
					?>
				</select>
				</td>
				<td>
					<input type="number" name="jumlah" id="jumlah" class="form-control" value=""/>
				</td>
				<td>
					<button type="button" id="tambah" class="btn btn-default"><i class="fa fa-plus"></i></button>
				</td>
			</tr>
		</tbody>
	</table>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="pull-left">
			<b>List Permintaan</b> <a href="javascript:;" onclick="getlist();">Refresh List</a>
		</div>
		<div class="pull-right">
			<button type="submit" id="selesai" style="display: none;" class="btn btn-primary">Selesai</button>
		</div>
		
		<table class="table table-bordered">
			<thead>
				<th></th>
				<th>Nama Produk</th>
				<th>Jumlah</th>
				<th></th>
			</thead>
			<tbody id="listminta"></tbody>
		</table>
	</div>
</div>
<?php
echo form_close();
?>
<script>
$(document).ready(function(){

getlist();

$("#tambah").on('click',function(){
	var produk=$("#produkid").val();
	var jumlah=$("#jumlah").val();
	var tanggal=$("#tanggal").val();
	var supplier=$("#supplier").val();
	if(produk!="" && parseInt(jumlah) > 0 && supplier !="" && tanggal !="")
	{
		$.ajax({
		  method: "get",
		  dataType:"json",
		  url: "<?=base_url(akses().'/transaksi/permintaan/additem');?>",
		  data: "produk="+produk+"&jumlah="+jumlah+'&tanggal='+tanggal+'&supplier='+supplier,
		  beforeSend:function(){
		  	$("#produkid").attr("disabled","disabled");
		  	$("#jumlah").attr("disabled","disabled");
		  	$("#tambah").attr("disabled","disabled");
		  }
		})
		.done(function( x ) {
		    if(x.status=="ok")
		    {
				getlist();
			}
			$("#produkid").removeAttr("disabled");
		  	$("#jumlah").removeAttr("disabled");
		  	$("#tambah").removeAttr("disabled");
		})
		.fail(function(  ) {
			$("#produkid").removeAttr("disabled");
		  	$("#jumlah").removeAttr("disabled");
		  	$("#tambah").removeAttr("disabled");
		});
	}else{
		alert('Lengkapi form !!');
	}
});

});

function getlist()
{
	var tanggal=$("#tanggal").val();
	var supplier=$("#supplier").val();
	$.get('<?=base_url(akses()."/transaksi/permintaan/getlist");?>?tanggal='+tanggal+'&supplier='+supplier,function(ht){
		$("#listminta").html(ht);
		jumlah();
	});
}

function hapus(id)
{	
		$.ajax({
		  method: "get",
		  dataType:"json",
		  url: "<?=base_url(akses().'/transaksi/permintaan/deleteitem');?>",
		  data: "id="+id,
		  beforeSend:function(){
		  	
		  }
		})
		.done(function( x ) {
		    getlist();
		})
		.fail(function(  ) {
			getlist();
		});

}

function jumlah()
{
	var jj=$("#listminta tr").length;
	if(jj > 0)
	{
		$("#selesai").show();
	}else{
		$("#selesai").hide();
	}
}

</script>