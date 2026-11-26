<?php
if(empty($data))
{
	redirect(base_url());
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
if(!file_exists($pathPhotoBaru) && !file_exists($pathPhotoBaru))
{
	$urlPhotoBaru=base_url().'assets/images/avatar/noavatar.jpg';
}
$slugBaru=string_create_slug($rBaru->nama_produk);
$urlProdukBaru=base_url().'produk/'.$rBaru->produk_id.'/'.$slugBaru;
?>
<div class="col-lg-4 col-sm-4">
	<div class="thumbnail">
		<a href="<?=base_url().'assets/images/produk/'.$rPhotoBaru->photo;?>" rel="prettyPhoto"><img src="<?=$urlPhotoBaru;?>" alt=""></a><br/>
		<h3 class="alert alert-danger" align="center"><del>Rp <?=number_format($harga+$promo_nilai,0);?></del></h3>
		<h3 class="alert alert-info" align="center">Rp <?=number_format($harga,0);?></h3>
	</div>
</div>
<div class="col-lg-8 col-sm-8">
	<h4><?=$rBaru->nama_produk;?></h4>
	<p>
		Merek <a href="<?=base_url();?>produk/merek/<?=$rBaru->merek_id;?>/<?=$S_merek;?>" target="_blank"><?=$N_merek;?></a>
		<br/> Kategori <a href="<?=base_url();?>produk/kategori/<?=$rBaru->kategori_id;?>/<?=$S_kategori;?>" target="_blank"><?=$N_kategori;?></a>
	</p>
	<p><?=$rBaru->deskripsi;?></p>	
	<p>
		<?php
		if($stok > 0)
		{
					
		echo validation_errors();
		echo form_open(base_url('produk/add/'.$produkid),array('class'=>'form-horizontal'));
		?>
		<input type="hidden" name="produkid" value="<?=$produkid;?>"/>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="">QTY</label>
			<div class="col-md-2">
				<input type="number" name="qty" id="" class="form-control " autocomplete="off" placeholder="Jumlah Beli" required="" value="<?php echo set_value('qty',1); ?>"/>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Keterangan</label>
			<div class="col-md-6">
				<textarea name="keterangan" class="form-control" placeholder="Buat keterangan tambahan seperti ukuran atau warna"><?=set_value('keterangan');?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">&nbsp;</label>
			<div class="col-md-6">
				<button type="submit" class="btn btn-primary btn-flat">Beli</button>				
			</div>
		</div>
		<?php
		echo form_close();
		}else{
			echo "STOK KOSONG";
		}
		?>
	</p>
</div>