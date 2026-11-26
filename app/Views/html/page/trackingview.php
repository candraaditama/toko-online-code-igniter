<?php
if(empty($data))
{
?>
<?php
echo validation_errors();
echo form_open(base_url('tracking'),array('class'=>'form-horizontal','method'=>'get'));
?>
<div class="form-group">
	<label class="col-sm-2 control-label" for="">No Invoice</label>
	<div class="col-md-5">
		<input type="text" name="invoice" id="" class="form-control " autocomplete="" placeholder="Invoice" required="" value="<?php echo set_value('invoice'); ?>"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label">&nbsp;</label>
	<div class="col-md-10">
		<button type="submit" class="btn btn-primary btn-flat">Cek</button>		
	</div>
</div>
<?php
echo form_close();
?>
<?php
}else{
	foreach($data as $row){		
	}
	$status=$row->status;
	$invoice=$row->invoice;	
	if($status=="draft")
	{
		?>
		<div class="alert alert-danger">Invoice Belum dibayarkan atau belum dikonfirmasi</div>
		<?php
	}elseif($status=="konfirmasi"){
		?>
		<div class="alert alert-info">Invoice Tahap Validasi</div>
		<?php
	}elseif($status=="lunas"){
		?>
		<div class="alert alert-success">Order telah dikirim</div>
		<?php
	}
	?>
	<table class="table table-bordered">
		<thead>
			<th width="10%"></th>
			<th>Produk</th>
			<th>Jumlah</th>
			<th>Harga</th>
			<th>Subtotal</th>
		</thead>
		<tbody>
			<?php
			$sItem=array(
			'penjualan_id'=>$row->penjualan_id,
			);
			$dItem=$this->m_db->get_data('penjualan_detail',$sItem);
			if(!empty($dItem))
			{
				foreach($dItem as $rItem)
				{
					$photoBaru=produk_photo($rItem->produk_id,1);
					foreach($photoBaru as $rPhotoBaru)
					{								
					}
					$urlPhotoBaru=base_url().'assets/images/produk/thumbs/400/'.$rPhotoBaru->photo;
					$pathPhotoBaru=FCPATH.'assets/images/produk/thumbs/400/'.$rPhotoBaru->photo;
					if(!file_exists($pathPhotoBaru) && !file_exists($pathPhotoBaru))
					{
						$urlPhotoBaru=base_url().'assets/images/avatar/noavatar.jpg';
					}
					$namaProduk=produk_info($rItem->produk_id,'nama_produk')
				?>
				<tr>
					<td>
						<a href="<?=$urlPhotoBaru;?>" rel="prettyPhoto">
						<img src="<?=$urlPhotoBaru;?>" class="img-responsive" style="width: 100px;"/>
						</a>
					</td>
					<td><?=$namaProduk;?></td>
					<td><?=$rItem->qty;?></td>
					<td>Rp <?=number_format($rItem->harga,0);?></td>
					<td>Rp <?=number_format($rItem->subtotal,0);?></td>
				</tr>
				<?php
				}
			}
			?>
		</tbody>
	</table>
	<?php
}
?>