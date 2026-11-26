			</div>
			<!-- /.content-col -->
	    </div>
	    <!-- /.row -->
	</main>

	<footer class="site-footer hidden-print">
	    <div class="container">
	        <div class="row g-4">
	            <div class="col-lg-4 col-md-6">
	                <div class="footer-brand">
	                    <img src="<?=base_url();?>assets/images/food-stand.png" alt="<?=baca_konfig('company-name');?>">
	                    <span><?=baca_konfig('company-name');?></span>
	                </div>
	                <p class="footer-about">Belanja kebutuhan fashion pilihan dengan proses mudah, pembayaran aman, dan pengiriman ke seluruh Indonesia.</p>
	            </div>

	            <div class="col-lg-3 col-md-6 col-6">
	                <h4>Informasi</h4>
	                <ul>
	                    <?php
	                    $dHalaman=$this->m_db->get_data('berita',array('jenis'=>'halaman'));
	                    if(!empty($dHalaman))
	                    {
	                    	foreach($dHalaman as $rHalaman)
	                    	{
	                    		$urlpage=base_url().'informasi/'.$rHalaman->slug;
	                    	?>
	                    	<li><a href="<?=$urlpage;?>"><?=$rHalaman->judul;?></a></li>
	                    	<?php
	                    	}
	                    }
	                    ?>
	                    <li><a href="<?=base_url();?>kontak-kami">Kontak Kami</a></li>
	                </ul>
	            </div>

	            <div class="col-lg-2 col-md-6 col-6">
	                <h4>Kategori</h4>
	                <ul>
	                    <?php
	                    $dKat=produk_kategori();
	                    if(!empty($dKat))
	                    {
	                    	foreach($dKat as $rKat)
	                    	{
	                    		$slugCat=string_create_slug($rKat->nama_kategori);
	                    		$urlcat=base_url().'produk/kategori/'.$rKat->kategori_id.'/'.$slugCat;
	                    	?>
	                    	<li><a href="<?=$urlcat;?>"><?=$rKat->nama_kategori;?></a></li>
	                    	<?php
	                    	}
	                    }
	                    ?>
	                </ul>
	            </div>

	            <div class="col-lg-3 col-md-6">
	                <h4>Hubungi Kami</h4>
	                <ul>
	                    <li><i class="fa fa-phone"></i> <?=baca_konfig('company-phone');?></li>
	                    <li><i class="fa fa-envelope"></i> <?=baca_konfig('company-email');?></li>
	                    <li><i class="fa fa-map-marker"></i> <?=baca_konfig('company-address');?></li>
	                </ul>
	            </div>
	        </div>

	        <div class="footer-bottom">
	            <span>Copyright &copy; <?=date("Y");?> <?=baca_konfig('company-name');?>. All rights reserved.</span>
	            <span>Belanja aman &middot; Pengiriman cepat</span>
	        </div>
	    </div>
	</footer>

	<a href="#konten-utama" class="back-top text-center" aria-label="Kembali ke atas">
	    <i class="fa fa-angle-double-up"></i>
	</a>

	<script src="<?=base_url();?>assets/html/js/bootstrap.bundle.min.js"></script>
	<script src="<?=base_url();?>assets/theme.js"></script>
	<script src="<?=base_url();?>assets/tema/lte/dist/js/legacy.js"></script>
	<script src="<?=base_url();?>assets/html/js/jquery.bxslider.min.js"></script>
	<script src="<?=base_url();?>assets/html/js/jquery.blImageCenter.js"></script>
	<script src="<?=base_url();?>assets/html/js/mimity.js"></script>
	<script>
	$(window).on('scroll', function () {
	    if ($(this).scrollTop() > 300) { $('.back-top').fadeIn(); } else { $('.back-top').fadeOut(); }
	});
	</script>
</body>
</html>
