<?php
echo asset_jqueryui();
echo validation_errors();
echo form_open_multipart(base_url('konfirmasi'),array('class'=>'form-horizontal'));
?>
<div class="col-md-6">
	<div class="form-group">
		<label class="col-sm-2 control-label" for="">No. Invoice</label>
		<div class="col-md-8">
			<div class="input-group">		  
			  <input type="text" id="invoice" name="invoice" class="form-control " placeholder="Nomor Invoice" required="">
			  <span class="input-group-btn">
			    <button class="btn btn-default" type="button" onclick="getinvoice();"><i class="fa fa-plus"></i></button>
			  </span>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="">Total</label>
		<div class="col-md-10">
			<p class="form-control" id="total">Rp 0</p>
			<input type="hidden" name="total" id="htotal"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="">Ditransfer ke</label>
		<div class="col-md-10">
			<select name="bankid" class="form-control" required="">
			<?php
			$dBank=$this->m_db->get_data('bank');
			if(!empty($dBank))
			{
				foreach($dBank as $rBank)
				{
					$nama=$rBank->nama_bank;
					$pemilik=$rBank->pemilik;
					$norek=$rBank->no_rek;
					$lbl=$nama."-".$norek." (".$pemilik.")";
					echo '<option value="'.$rBank->bank_id.'">'.$lbl.'</option>';
				}
			}
			?>
			</select>
		</div>
	</div>
</div>
<div class="col-md-6">	
	<div class="form-group">
		<label class="col-sm-2 control-label" for="">Nama Pengirim</label>
		<div class="col-md-10">
			<input type="text" name="pemilik" id="pemilik" class="form-control " autocomplete="off" placeholder="Nama Pengirim Dana" required="" value="<?php echo set_value('pemilik'); ?>"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="">Tanggal Transfer</label>
		<div class="col-md-5">
			<input type="text" name="tanggal" id="" class="form-control tanggal" autocomplete="off" placeholder="Tanggal Transfer" required="" value="<?php echo set_value('tanggal',date("Y-m-d")); ?>"/>
		</div>
	</div>	
	<div class="form-group">
		<label class="col-sm-2 control-label" for="">Bukti Transfer</label>
		<div class="col-md-10">
			<input type="file" name="bukti" id="" class="form-control " autocomplete="off" placeholder="Upload Bukti Transfer"/>
			<small class="text-info">Untuk konfirmasi di atas jam kerja, harap upload bukti pembayaran. Format file PDF,JPG,BMP,PNG</small>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">&nbsp;</label>
		<div class="col-md-10">
			<button type="submit" class="btn btn-primary btn-flat">Konfirmasi</button>			
		</div>
	</div>
</div>


<?php
echo form_close();
?>
<script>
$(document).ready(function(){



});

function getinvoice()
{
	var iv=$("#invoice").val();
	if(iv=="")
	{
		return;
	}
	$.ajax({
	  method: "get",
	  dataType:"json",
	  url: "<?=base_url();?>pembayaran/getinvoice",
	  data: "invoice="+iv,
	  beforeSend:function(){
	  	$("form input").attr("disabled","disabled");
	  	$("form button").attr("disabled","disabled");
	  	$("#htotal").val(0);
	  	$("#total").html("Rp 0");
		$("#pemilik").val("");
	  }
	})
	.done(function( x ) {
	    if(x.status=="ok")
	    {
			$("#total").html(x.total);
			$("#pemilik").val(x.nama);
			$("#htotal").val(x.total2);
		}else{
			$("#total").html("Rp 0");
			$("#pemilik").val("");
			$("#htotal").val(0);
		}
		$("form input").removeAttr("disabled");
	  	$("form button").removeAttr("disabled");
	})
	.fail(function(  ) {
		$("form input").removeAttr("disabled");
	  	$("form button").removeAttr("disabled");
	  	$("#htotal").val(0);
	  	$("#total").html("Rp 0");
		$("#pemilik").val("");
	});
}
</script>