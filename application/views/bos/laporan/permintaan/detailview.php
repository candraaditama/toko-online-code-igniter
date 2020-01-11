<table class="table table-bordered table-stripped">
<thead>
	<th>Tanggal</th>
	<th>Supplier</th>
	<th>Item</th>	
</thead>
<tbody>
<?php

if(!empty($data))
{	
	foreach($data as $row)
	{		
	?>
	<tr>
		<td><?=$row->tanggal;?></td>
		<td><?=field_value('supplier','supplier_id',$row->supplier_id,'nama_supplier');?></td>		
		<td>
			<?php
			$dDetail=$this->m_db->get_data('pembelian_detail',array('pembelian_id'=>$row->pembelian_id));
			if(!empty($dDetail))
			{
				foreach($dDetail as $rD)
				{
					$namaProduk=field_value('produk','produk_id',$rD->produk_id,'nama_produk');
					echo '<li>'.$namaProduk.' '.$rD->qty.' item </li>';
				}
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