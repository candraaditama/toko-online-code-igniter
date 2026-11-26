<?php
$pembelian=$this->cart->contents();
if(!empty($pembelian))
{
echo form_open(base_url().'produk/keranjang');
?>
<input type="hidden" name="aksi" value="1"/>
<table class="table table-bordered">
<thead>
	<th>Nama Produk</th>
	<th width="10%">Jumlah</th>
	<th width="20%">Harga</th>
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
		?>
		<tr>
			<td>
				<?=$item['id'];?>-<?=$item['name'];?><br/>
				Keterangan : <?=$item['keterangan'];?>
			</td>
			<td>
				<input type="number" name="info[<?=$i;?>][qty]" class="form-control" value="<?=$item['qty'];?>"/><br/>
				<a onclick="return confirm('Yakin ingin menghapusnya?');" href="<?=base_url();?>produk/delete/<?=$id;?>" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Hapus</a>
			</td>
			<td>
				<?php
				$produkid=$item['produk_id'];
				$promo_id=produk_promo_id($produkid);
				$harga2=$item['price'];
				$harga=produk_info($produkid,'harga');
				$label='';
				
				if(!empty($promo_id))
				{
					$promo_nilai=field_value('promo','promo_id',$promo_id,'nilai');
					$promo_nama=field_value('promo','promo_id',$promo_id,'judul');
					$label='<del>Rp '.number_format($harga,0).'</del> ('.$promo_nama.' Rp '.number_format($promo_nilai,0).')';
				}
				?>				
				Rp <?=number_format($item['price'],0);?><br/>
				<?=$label;?>
			</td>
			<td>
				Rp <?=number_format($item['subtotal'],0);?>
			</td>			
		</tr>
		<input type="hidden" name="info[<?=$i;?>][rowid]" value="<?=$item['rowid'];?>"/>
		<?php
		}
	}
	?>
</tbody>
<tfoot>
	<tr>
		<td colspan="3">Total</td>
		<td>
			Rp <?=number_format($this->cart->total(),0);?>
		</td>
	</tr>
	<tr>
		<td colspan="3">
			<button type="submit" class="btn btn-primary btn-flat">Update Keranjang</button>
			<a onclick="return confirm('Yakin ingin mengkosongkan keranjang belanja?');" href="<?=base_url();?>emptycart" class="btn btn-danger btn-flat">Kosongkan Keranjang</a>
		</td>
		<td>			
			<a href="<?=base_url();?>checkout" class="btn btn-success btn-flat">Selesai Belanja</a>
		</td>
	</tr>
</tfoot>
</table>
<?php
echo form_close();
}else{
	?>
	<div class="alert alert-warning">Keranjang Belanja Anda Kosong</div>
	<?php
}
?>