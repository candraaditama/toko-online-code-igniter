<?php
if(empty($data))
{
	legacy_redirect(base_url());
}
foreach($data as $rBaru){
}
$toko=toko_pusat();
$sStok=array(
'produk_id'=>$rBaru->produk_id,
'toko_id'=>$toko,
);

$harga=$rBaru->harga;
$promo_nilai=0;
$promo_id=produk_promo_id($rBaru->produk_id);
if(!empty($promo_id))
{
	$promo_nilai=field_value('promo','promo_id',$promo_id,'nilai');
	$harga=$rBaru->harga-$promo_nilai;
}

$stok_awal=$this->m_db->get_row('produk_stok',$sStok,'stok');
$stok_jual=$this->m_db->get_row('produk_stok',$sStok,'stok_jual');
$stok_mutasi=$this->m_db->get_row('produk_stok',$sStok,'stok_mutasi');
$stok=$stok_awal-($stok_jual+$stok_mutasi);
$N_merek=field_value('produk_merek','merek_id',$rBaru->merek_id,'nama_merek');
$S_merek=string_create_slug($N_merek);
$N_kategori=field_value('produk_kategori','kategori_id',$rBaru->kategori_id,'nama_kategori');
$S_kategori=string_create_slug($N_kategori);
$photoBaru=produk_photo($rBaru->produk_id,1);
foreach($photoBaru as $rPhotoBaru)
{
}
$urlPhotoBaru=base_url().'assets/images/produk/thumbs/400/'.$rPhotoBaru->photo;
$pathPhotoBaru=FCPATH.'assets/images/produk/thumbs/400/'.$rPhotoBaru->photo;
if(!file_exists($pathPhotoBaru))
{
	$urlPhotoBaru=base_url().'assets/images/avatar/noavatar.jpg';
}
$slugBaru=string_create_slug($rBaru->nama_produk);
$urlProdukBaru=base_url().'produk/'.$rBaru->produk_id.'/'.$slugBaru;
?>
<div class="row g-4">
	<div class="col-lg-5">
		<div class="product-detail-media">
			<a href="<?=base_url().'assets/images/produk/'.$rPhotoBaru->photo;?>" rel="prettyPhoto">
				<img src="<?=$urlPhotoBaru;?>" alt="<?=$rBaru->nama_produk;?>">
			</a>

			<div class="product-detail-price">
				<?php if($promo_nilai > 0){ ?>
				<span class="price-old">Rp <?=number_format($harga+$promo_nilai,0,',','.');?></span>
				<span class="price-now">Rp <?=number_format($harga,0,',','.');?></span>
				<?php } else { ?>
				<span class="price-now">Rp <?=number_format($harga,0,',','.');?></span>
				<?php } ?>
			</div>
		</div>
	</div>

	<div class="col-lg-7">
		<div class="product-detail-info">
			<h4><?=$rBaru->nama_produk;?></h4>

			<div class="product-meta">
				<span><i class="fa fa-tag"></i> Merek <a href="<?=base_url();?>produk/merek/<?=$rBaru->merek_id;?>/<?=$S_merek;?>"><?=$N_merek;?></a></span>
				<span><i class="fa fa-folder-open"></i> Kategori <a href="<?=base_url();?>produk/kategori/<?=$rBaru->kategori_id;?>/<?=$S_kategori;?>"><?=$N_kategori;?></a></span>
				<span><i class="fa fa-cubes"></i> Stok <strong><?=$stok;?></strong></span>
			</div>

			<div class="product-description">
				<?=$rBaru->deskripsi;?>
			</div>

			<?php
			if($stok > 0)
			{
			echo validation_errors();
			echo form_open(base_url('produk/add/'.$produkid),array('class'=>'product-buy-form'));
			?>
			<input type="hidden" name="produkid" value="<?=$produkid;?>"/>

			<div class="row g-3">
				<div class="col-sm-3">
					<label class="control-label" for="qty">Jumlah</label>
					<input type="number" name="qty" id="qty" class="form-control" min="1" autocomplete="off" placeholder="Qty" required value="<?php echo set_value('qty',1); ?>">
				</div>
				<div class="col-sm-9">
					<label class="control-label" for="keterangan">Keterangan</label>
					<textarea name="keterangan" id="keterangan" class="form-control" rows="1" placeholder="Ukuran, warna, atau catatan lain"><?=set_value('keterangan');?></textarea>
				</div>
			</div>

			<button type="submit" class="btn btn-primary btn-lg mt-3">
				<i class="fa fa-shopping-cart"></i> Tambah ke Keranjang
			</button>
			<?php
			echo form_close();
			}else{
			?>
			<div class="alert alert-danger mb-0">Stok produk sedang kosong.</div>
			<?php
			}
			?>
		</div>
	</div>
</div>
