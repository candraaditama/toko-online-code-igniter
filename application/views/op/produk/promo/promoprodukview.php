<?php
echo asset_datatables();
?>
<p>&nbsp;</p>
<table class="table table-bordered data-render">
	<thead>		
		<th>Nama Produk</th>
		<th>Supplier</th>
		<th>Metadata</th>
		<th>Harga</th>
		<th>Stok</th>
		<th></th>
	</thead>
	<tbody>
		<?php
		if(!empty($data))
		{
			foreach($data as $row)
			{
				$id=$row->produk_id;
				$nama=$row->kode_produk."-".$row->nama_produk;
				$supplier=field_value('supplier','supplier_id',$row->supplier_id,'nama_supplier');
				$kategori=field_value('produk_kategori','kategori_id',$row->kategori_id,'nama_kategori');
				$merek=field_value('produk_merek','merek_id',$row->merek_id,'nama_merek');
				
			?>
			<tr>				
				<td><?=$nama;?></td>
				<td><?=$supplier;?></td>				
				<td>
					<li>Kategori <?=$kategori;?></li>
					<li>Merek <?=$merek;?></li>
					<li>Berat <?=number_format($row->berat,2);?> Gram</li>
				</td>				
				<td>Rp <?=number_format($row->harga,0);?></td>				
				<td>
					<?php
					$dStok=produk_stok_data(toko_user(),$id);
					if(!empty($dStok))
					{
						foreach($dStok as $rStok)
						{							
							$mutasi=$rStok->stok_mutasi;
							$jual=$rStok->stok_jual;
							$stok=$rStok->stok-($mutasi+$jual);
							?>
							<li><?=$stok;?></li>
							<?php
						}
					}else{
					?>
					<a href="<?=base_url(akses().'/produk/stok').'?id='.$id;?>" class="btn btn-link">+ Tambah Stok</a>
					<?php
					}
					?>
					
				</td>
				<td>
					<?php
					$sPromo=array(
					'produk_id'=>$row->produk_id,
					'promo_id'=>$promoid,
					);
					if($this->m_db->is_bof('promo_data',$sPromo)==FALSE)
					{
						?>
						<a href="<?=base_url(akses().'/produk/promo/aksi');?>?aksi=delete&id=<?=$row->produk_id;?>&promo=<?=$promoid;?>" class="btn btn-xs btn-danger">Hapus Promo</a>
						<?php
					}else{
						?>
						<a href="<?=base_url(akses().'/produk/promo/aksi');?>?aksi=add&id=<?=$row->produk_id;?>&promo=<?=$promoid;?>" class="btn btn-xs btn-primary">Tambah Promo</a>
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