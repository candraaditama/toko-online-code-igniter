<?php
echo asset_jqueryui();
echo asset_select2();
?>

<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default">
		  <div class="panel-heading">Permintaan Periode</div>
		  <div class="panel-body">
		    <?php
			echo validation_errors();
			echo form_open(base_url(akses().'/laporan/permintaan/periode'),array('class'=>'form-horizontal','target'=>'_blank'));
			?>
			<div class="form-group">
				<label class="col-sm-3 control-label" for="">Dari</label>
				<div class="col-md-6">
					<input type="text" name="t1" id="" class="form-control tanggal" autocomplete="off" placeholder="Dari Tanggal" required="" value="<?php echo set_value('t1',date('Y-m-d')); ?>"/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label" for="">Hingga</label>
				<div class="col-md-6">
					<input type="text" name="t2" id="" class="form-control tanggal" autocomplete="off" placeholder="Hingga Tanggal" required="" value="<?php echo set_value('t2',date('Y-m-d')); ?>"/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">&nbsp;</label>
				<div class="col-md-9">
					<button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-search"></i> Tampilkan</button>
				</div>
			</div>
			<?php
			echo form_close();
			?>
		  </div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-default">
		  <div class="panel-heading">Permintaan Bulanan</div>
		  <div class="panel-body">
		    <?php
			echo validation_errors();
			echo form_open(base_url(akses().'/laporan/permintaan/bulanan'),array('class'=>'form-horizontal','target'=>'_blank'));
			?>
			<div class="form-group">
				<label class="col-sm-3 control-label" for="">Bulan</label>
				<div class="col-md-9">
					<?=com_select_bulan('bulan',1,array('class'=>'form-control select2'));?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label" for="">Tahun</label>
				<div class="col-md-6">
					<input type="text" name="tahun" id="" class="form-control tanggal" autocomplete="off" placeholder="Tahun" required="" value="<?php echo set_value('tahun',date('Y')); ?>"/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">&nbsp;</label>
				<div class="col-md-9">
					<button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-search"></i> Tampilkan</button>
				</div>
			</div>
			<?php
			echo form_close();
			?>
		  </div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
		  <div class="panel-heading">Per Produk</div>
		  <div class="panel-body">
		    <?php
			echo validation_errors();
			echo form_open(base_url(akses().'/laporan/permintaan/produk'),array('class'=>'form-horizontal','target'=>'_blank'));
			?>
			<div class="form-group">
				<label class="col-sm-3 control-label" for="">Produk</label>
				<div class="col-md-9">
					<select name="produk" class="form-control select2" required="" style="width: 100%" data-placeholder="Pilih Produk">
					<option></option>
					<?php
					$dProduk=$this->m_db->get_data('produk',array(),'nama_produk ASC');
					if(!empty($dProduk))
					{
						foreach($dProduk as $rProduk)
						{
							echo '<option value="'.$rProduk->produk_id.'">'.$rProduk->nama_produk.'</option>';
						}
					}
					?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label" for="">Dari</label>
				<div class="col-md-6">
					<input type="text" name="t1" id="" class="form-control tanggal" autocomplete="off" placeholder="Dari Tanggal" required="" value="<?php echo set_value('t1',date('Y-m-d')); ?>"/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label" for="">Hingga</label>
				<div class="col-md-6">
					<input type="text" name="t2" id="" class="form-control tanggal" autocomplete="off" placeholder="Hingga Tanggal" required="" value="<?php echo set_value('t2',date('Y-m-d')); ?>"/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">&nbsp;</label>
				<div class="col-md-9">
					<button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-search"></i> Tampilkan</button>
				</div>
			</div>
			<?php
			echo form_close();
			?>
		  </div>
		</div>
	</div>
</div>