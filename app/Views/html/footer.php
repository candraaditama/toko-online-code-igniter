</div>
        	<!-- End Featured -->

        	<div class="clearfix visible-sm"></div>
        </div>
	</div>

	<footer class="hidden-print">
    	<div class="container">
        	<div class="col-lg-3 col-md-3 col-sm-6">
        		<div class="column">
        			<h4>Information</h4>
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
        			</ul>
        		</div>
        	</div>
        	<div class="col-lg-3 col-md-3 col-sm-6">
        		<div class="column">
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
        	</div>
        	<div class="col-lg-3 col-md-3 col-sm-6">
        		<div class="column">
        			<h4>Kontak Info</h4>
        			<ul>
        				<li><a href="<?=base_url();?>kontak-kami">Kontak Kami</a></li>
        				<li><a href="#"><?=baca_konfig('company-name');?></a></li>
        				<li><a href="#"><i class="fa fa-phone"></i> <?=baca_konfig('company-phone');?></a></li>
        				<li><a href="#"><i class="fa fa-envelope"></i> <?=baca_konfig('company-email');?></a></li>
        			</ul>
        		</div>
        	</div>
        	<div class="col-lg-3 col-md-3 col-sm-6">
        		<div class="column">
        			<h4>Follow Us</h4>
        			<ul class="social">
        				<li><a href="#">Google Plus</a></li>
        				<li><a href="#">Facebook</a></li>
        				<li><a href="#">Twitter</a></li>
        				<li><a href="#">RSS Feed</a></li>
        			</ul>
        		</div>
        	</div>
        </div>
        <div class="navbar-inverse text-center copyright">
        	Copyright &copy; <?=date("Y");?> Online Shop
        </div>
    </footer>

    <a href="#top" class="back-top text-center hidden-print" onclick="$('body,html').animate({scrollTop:0},500); return false">
    	<i class="fa fa-angle-double-up"></i>
    </a>

    
    <script src="<?=base_url();?>assets/html/js/bootstrap.js"></script>
    <script src="<?=base_url();?>assets/html/js/jquery.bxslider.min.js"></script>
    <script src="<?=base_url();?>assets/html/js/jquery.blImageCenter.js"></script>
    <script src="<?=base_url();?>assets/html/js/mimity.js"></script>
</body>
</html>