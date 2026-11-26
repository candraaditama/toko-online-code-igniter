<?php
echo asset_datatables();
if(empty($data))
{
	redirect(base_url(akses().'/transaksi/mutasi'));
}
foreach($data as $row)
{	
}
$tgl=date("d-m-Y",strtotime($row->tanggal));
$namaToko=toko_info($row->toko_id,'nama_toko');
$user=field_value('userlogin','user_id',$row->user_id,'nama');
?>
<div class="form-horizontal">
	<div class="form-group">
		<label class="col-sm-2 control-label" for="">Tanggal</label>
		<div class="col-md-10">
			<p class="form-control-static"><?=$tgl;?></p>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="">Tujuan</label>
		<div class="col-md-10">
			<p class="form-control-static"><?=$namaToko;?></p>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="">Keterangan</label>
		<div class="col-md-10">
			<p class="form-control-static"><?=$row->keterangan;?></p>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="">Dientri</label>
		<div class="col-md-10">
			<p class="form-control-static"><?=$user;?></p>
		</div>
	</div>	
</div>
<table class="table table-bordered data-render">
	<thead>
		<th>Nama Produk</th>
		<th>Ukuran</th>
		<th>Warna</th>
		<th>Jumlah</th>
	</thead>
	<tbody>
		<?php
		$dDetail=$this->mod_trans->mutasi_data_detail($row->mutasi_id);
		if(!empty($dDetail))
		{
			foreach($dDetail as $rd)
			{
				$produk=produk_info($rd->produk_id,'nama_produk');
				$ukuran=field_value('produk_ukuran','ukuran_id',$rd->ukuran_id,'nama_ukuran');
				$warna=field_value('produk_warna','warna_id',$rd->warna_id,'nama_warna');
			?>
			<tr>
				<td><?=$produk;?></td>
				<td><?=$ukuran;?></td>
				<td><?=$warna;?></td>
				<td><?=$rd->qty;?></td>
			</tr>
			<?php
			}
		}
		?>
	</tbody>
</table>