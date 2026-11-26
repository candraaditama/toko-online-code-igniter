</div>
		<div class="footer-laporan text-center">
			<div class="row">
				<div class="col-md-5 pull-right">
					Padang, <?=date("d-m-Y");?><br/>
					<?php
					$bosID=field_value('userlogin','akses','bos','nama');
					?>
					<b>Diketahui oleh</b>
					<p>&nbsp;</p>
					<p>&nbsp;</p>
					<p>&nbsp;</p>
					<p>(<?=$bosID;?>)</p>
				</div>
			</div>
		</div>
	</div>
    
  </body>
</html>