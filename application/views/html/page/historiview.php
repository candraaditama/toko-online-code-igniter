<?php
echo asset_datatables();
?>
<table class="table table-bordered data-render">
<thead>
	<th>Tanggal</th>
	<th>Invoice</th>
	<th>Total Belanja</th>
	<th>Ongkos Kirim</th>
	<th>Total Bayar</th>
	<th></th>
</thead>
<tbody>
<?php
if(!empty($data))
{
	foreach($data as $row){
	?>
	<tr>
		<td><?=date("d-m-Y",strtotime($row->tanggal));?></td>
		<td><?=$row->invoice;?></td>
		<td><?=number_format($row->total,0);?></td>
		<td><?=number_format($row->ongkir,0);?></td>
		<td><?=number_format($row->total+$row->ongkir,0);?></td>
		<td>
			<?php
			if($row->status=="draft")
			{
				?>
				<a href="<?=base_url();?>produk/histori/bayar/<?=$row->penjualan_id;?>" class="btn btn-success btn-xs btn-flat">Bayar</a>
				<?php
			}elseif($row->status=="konfirmasi"){
				?>
				Tahap Verifikasi Pembayaran
				<?php
			}elseif($row->status=="lunas"){
				?>
				Packing Item
				<?php
			}
			?>
		</td>
	</tr>
	<?php
	}
}
?>
</tbody>
</table>