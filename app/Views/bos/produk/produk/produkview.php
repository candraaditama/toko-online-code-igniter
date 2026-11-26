<?php
echo asset_datatables();
?>
<div>
	<a href="<?=base_url(akses().'/produk/produk/add');?>" class="btn btn-primary btn-flat">Tambah Produk</a>
</div>
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
					<a href="<?=base_url(akses().'/produk/produk/edit').'?id='.$id;?>" class="btn btn-md btn-info"><i class="fa fa-pencil"></i></a>
						<a onclick="return confirm('Yakin ingin menghapus produk ini?');" href="<?=base_url(akses().'/produk/produk/delete').'?id='.$id;?>" class="btn btn-md btn-danger"><i class="fa fa-trash"></i></a>
				</td>
			</tr>
			<?php
			}
		}
		?>
	</tbody>
</table>