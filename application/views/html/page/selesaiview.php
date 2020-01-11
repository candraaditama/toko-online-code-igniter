<?php
echo asset_select2();
if(akses()!="member")
{
	redirect(base_url());
}
$berat=0;
$pembelian=$this->cart->contents();

if(!empty($pembelian)){

$tgl_ini=date("Y-m-d");
$this->load->model('produk_model','mod_produk');
$dPromo=$this->mod_produk->promo_data(array('selesai >'=>$tgl_ini),'promo_id DESC');
$promo=0;

?>
<?php
echo validation_errors();
echo form_open(base_url('produk/selesai'),array('class'=>'form-horizontal'));
?>
<input type="hidden" name="pelangganid" value="<?=pelanggan_info('pelanggan_id');?>"/>
<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<label class="col-md-3 control-label" for="">Kepada</label>
			<div class="col-md-9">
				<p class="form-control-static"><?=user_info('nama');?></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label" for="">Alamat</label>
			<div class="col-md-9">
				<p class="form-control-static"><?=pelanggan_info('alamat');?></p>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label class="col-md-3 control-label" for="">Handphone</label>
			<div class="col-md-9">
				<p class="form-control-static"><?=pelanggan_info('hp');?></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label" for="">Kota</label>
			<div class="col-md-9">
				<p class="form-control-static"><?=field_value('lokasi_kota','kota_id',pelanggan_info('kota'),'nama_kota');?></p>
			</div>
		</div>		
	</div>	
	<div class="col-md-4">
		<b>Total Bayar : </b>
		<h3 id="totalbayar"></h3>		
		<button type="submit" id="oksimpan" class="btn btn-success btn-flat" style="display: none">Pembayaran</button>
	</div>
</div>
<hr style="border-bottom: 1px dotted #ccc"/>
<div class="">

		<table class="table table-bordered">
		<thead>
			<th>Nama Produk</th>
			<th width="10%">Jumlah</th>
			<th width="20%">Harga</th>
			<th width="20%">Diskon</th>
			<th width="20%">Sub Total</th>
		</thead>
		<tbody>
			<?php
			$i=0;	
			if(!empty($pembelian))
			{
				foreach($pembelian as $item)
				{
					$i+=1;
					$id=$item['rowid'];
					$berat_tmp=field_value('produk','kode_produk',$item['id'],'berat');
					$produk_id=field_value('produk','kode_produk',$item['id'],'produk_id');
					$berat+=$berat_tmp;
					$produkid=$item['produk_id'];
					$promo_id=produk_promo_id($produkid);
					$promo_nilai=0;
					$harga2=$item['price'];
					$harga=produk_info($produkid,'harga');
					if(!empty($promo_id))
					{
						$promo_nilai=field_value('promo','promo_id',$promo_id,'nilai');						
					}
					$promo+=$promo_nilai;
				?>
				<tr>
					<td>
						<?=$item['id'];?>-<?=$item['name'];?><br/>
						Berat : <?=$berat_tmp;?> gram<br/>
						Keterangan : <?=$item['keterangan'];?>
					</td>
					<td>
						<?=$item['qty'];?>
					</td>
					<td>
						Rp <?=number_format($harga,0);?>
					</td>
					<td>
						Rp <?=number_format($promo_nilai,0);?>
					</td>
					<td>
						Rp <?=number_format($item['subtotal'],0);?>
					</td>			
				</tr>
				<input type="hidden" name="produk[<?=$i;?>][produkid]" value="<?=$produk_id;?>"/>
				<input type="hidden" name="produk[<?=$i;?>][qty]" value="<?=$item['qty'];?>"/>
				<input type="hidden" name="produk[<?=$i;?>][harga]" value="<?=$item['price'];?>"/>
				<input type="hidden" name="produk[<?=$i;?>][keterangan]" value="<?=$item['keterangan'];?>"/>
				<input type="hidden" name="produk[<?=$i;?>][subtotal]" value="<?=$item['subtotal'];?>"/>
				<?php
				}
			}
			?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="4">Total</td>
				<td>
					Rp <?=number_format($this->cart->total(),0);?>
				</td>
			</tr>
		</tfoot>
		</table>

</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="">Pilihan Kurir</label>
	<div class="col-md-10">
		<?php		
		$kurir=array('jne','pos','tiki');
		foreach($kurir as $rkurir)
		{
			?>			
				<label class="radio-inline">
				<input type="radio" name="kurir" class="kurir" value="<?=$rkurir;?>"/> <?=strtoupper($rkurir);?>
				</label>
			<?php
		}
		?>
	</div>
</div>
<div id="kuririnfo" style="display: none;">
	<div class="form-group">
		<label class="col-sm-2 control-label" for="">Service</label>
		<div class="col-md-10">
			<p class="form-control-static" id="kurirserviceinfo"></p>
		</div>
	</div>
</div>

<input type="hidden" name="total" id="total" value="<?=$this->cart->total();?>"/>
<input type="hidden" name="ongkir" id="ongkir" value="0"/>
<input type="hidden" name="berat" value="<?=$berat;?>"/>
<input type="hidden" name="diskonnilai" id="diskonnilai" value="<?=$promo;?>"/>
<?php
echo form_close();
?>
<script>
$(document).ready(function(){

$(".kurir").each(function(o_index,o_val){
	$(this).on("change",function(){
		var did=$(this).val();
		var berat="<?=$berat;?>";
		var kota="<?=pelanggan_info('kota');?>";
		$.ajax({
		  method: "get",
		  dataType:"html",
		  url: "<?=base_url();?>produk/kurirdata",
		  data: "kurir="+did+"&berat="+berat+"&kota="+kota,
		  beforeSend:function(){
		  	$("#oksimpan").hide();
		  }
		})
		.done(function( x ) {			
		    $("#kurirserviceinfo").html(x);
		    $("#kuririnfo").show();		    
		})
		.fail(function(  ) {
			$("#kurirserviceinfo").html("");
		    $("#kuririnfo").hide();
		});
	});
});

$("#diskon").html(toDuit(<?=$promo;?>));
hitung();

});

function hitung()
{
	var diskon=$('#diskonnilai').val();
	var total=$('#total').val();
	var ongkir=$("#ongkir").val();
	var bayar=(parseFloat(total)+parseFloat(ongkir));
	if(parseFloat(ongkir) > 0)
	{
		$("#oksimpan").show();
	}else{
		$("#oksimpan").hide();
	}
	$("#totalbayar").html(toDuit(bayar));
}

</script>
<?php
}else{
	redirect(base_url().'keranjang');
}
?>
