<?php
echo asset_datatables();
?>
<div>
	<a href="<?=base_url(akses().'/transaksi/orderan');?>?status=draft" class="btn btn-md btn-default">Order</a>
	<a href="<?=base_url(akses().'/transaksi/orderan');?>?status=konfirmasi" class="btn btn-md btn-info">Konfirmasi</a>
	<a href="<?=base_url(akses().'/transaksi/orderan');?>?status=lunas" class="btn btn-md btn-success">Lunas</a>
</div>
<p>&nbsp;</p>
<table class="table table-bordered data-render">
	<thead>
		<th>INVOICE</th>
		<th>Tanggal</th>
		<th>Total Jual</th>
		<th>Kurir</th>
		<th>Grand Total</th>
		<th></th>
	</thead>
	<tbody>
		<?php
		if(!empty($data))
		{
			foreach($data as $row)
			{
				$total=$row->total;
				$ongkir=$row->ongkir;
				$grand=$total+$ongkir;
			?>
			<tr>
				<td><?=$row->invoice;?></td>
				<td><?=date("d-m-Y",strtotime($row->tanggal));?></td>
				<td>Rp <?=number_format($total,0);?></td>
				<td>
					<?=strtoupper($row->kurir)."(".$row->pelayanan.") Rp".number_format($ongkir,0);?><br/>
				</td>
				<td>Rp <?=number_format($grand,0);?></td>
				<td>
					<a href="<?=base_url(akses());?>/transaksi/orderan/detail?id=<?=$row->penjualan_id;?>" class="btn btn-default btn-xs btn-flat"><i class="fa fa-info"></i> Detail</a>
					<?php
					if($row->status=="draft")
					{
						?>
						<a onclick="return confirm('Yakin ingin menghapus order ini?');" href="<?=base_url(akses());?>/transaksi/orderan/delete?id=<?=$row->penjualan_id;?>" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-trash"></i></a>
						<?php
					}elseif($row->status=="konfirmasi"){
						?>
						<a href="<?=base_url(akses());?>/transaksi/orderan/approve?id=<?=$row->penjualan_id;?>" class="btn btn-success btn-xs btn-flat"><i class="fa fa-money"></i> Validasi</a>
						<?php
					}elseif($row->status=="lunas"){
						?>
						Lunas
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