<table class="table table-bordered table-stripped">
<thead>
	<th>Tanggal</th>
	<th>Invoice</th>
	<th>Total Belanja</th>
	<th>Ongkos Kirim</th>
	<th>Diskon</th>
	<th>Sub Total</th>
</thead>
<tbody>
<?php
$total=0;
$tot_belanja=0;
$tot_ongkir=0;
$tot_promo=0;
if(!empty($data))
{	
	foreach($data as $row)
	{
		$subtotal=($row->total+$row->ongkir)-$row->promo;
		$total+=$subtotal;
		$tot_belanja+=$row->total;
		$tot_ongkir+=$row->ongkir;
		$tot_promo+=$row->promo;
	?>
	<tr>
		<td><?=$row->tanggal;?></td>
		<td><?=$row->invoice;?></td>		
		<td>Rp <?=number_format($row->total,0);?></td>
		<td>Rp <?=number_format($row->ongkir,0);?></td>
		<td>Rp <?=number_format($row->promo,0);?></td>
		<td>Rp <?=number_format($subtotal,0);?></td>
	</tr>
	<?php
	}
}
?>
</tbody>
<tfoot>
	<tr>
		<td colspan="2" align="center"><b>Total</b></td>
		<td>Rp <?=number_format($tot_belanja,0);?></td>
		<td>Rp <?=number_format($tot_ongkir,0);?></td>
		<td>Rp <?=number_format($tot_promo,0);?></td>
		<td>Rp <?=number_format($total,0);?></td>
	</tr>
</tfoot>
</table>