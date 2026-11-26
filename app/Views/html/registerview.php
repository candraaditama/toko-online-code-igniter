<?php
echo asset_select2();
$ref=$this->input->get('ref');
?>
<div class="auth-card">
	<div class="auth-head">
		<h2>Buat Akun Baru</h2>
		<p>Lengkapi data berikut untuk mulai berbelanja.</p>
	</div>

	<?php
	echo validation_errors();
	echo form_open(base_url('member/daftar').'?ref='.$ref, array('class'=>'auth-form'));
	?>

	<div class="mb-3">
		<label class="control-label" for="nama">Nama Lengkap</label>
		<input type="text" name="nama" id="nama" class="form-control" autocomplete="name" placeholder="Nama Lengkap" required value="<?php echo set_value('nama'); ?>">
	</div>

	<div class="row g-3">
		<div class="col-sm-6">
			<div class="mb-3">
				<label class="control-label" for="hp">No HP</label>
				<input type="text" name="hp" id="hp" class="form-control" autocomplete="tel" placeholder="Nomor Handphone" required value="<?php echo set_value('hp'); ?>">
			</div>
		</div>
		<div class="col-sm-6">
			<div class="mb-3">
				<label class="control-label" for="email">Email</label>
				<input type="email" name="email" id="email" class="form-control" autocomplete="email" placeholder="Email Anda" required value="<?php echo set_value('email'); ?>">
			</div>
		</div>
	</div>

	<div class="mb-3">
		<label class="control-label" for="alamat">Alamat</label>
		<textarea name="alamat" id="alamat" rows="2" required class="form-control" placeholder="Alamat Pengiriman"><?=set_value('alamat');?></textarea>
	</div>

	<div class="mb-3">
		<label class="control-label" for="kota">Kota</label>
		<select name="kota" id="kota" class="form-control select2" required data-placeholder="Pilih Kota">
			<option></option>
			<?php
			$dKota=$this->m_db->get_data('lokasi_kota',array(),'nama_kota ASC');
			if(!empty($dKota))
			{
				foreach($dKota as $rKota)
				{
					echo '<option value="'.$rKota->kota_id.'" '.set_select('kota',$rKota->kota_id).'>'.$rKota->nama_kota.'</option>';
				}
			}
			?>
		</select>
	</div>

	<div class="row g-3">
		<div class="col-sm-6">
			<div class="mb-3">
				<label class="control-label" for="username">Username</label>
				<input type="text" name="username" id="username" class="form-control" autocomplete="username" placeholder="Username" required value="<?php echo set_value('username'); ?>">
			</div>
		</div>
		<div class="col-sm-6">
			<div class="mb-3">
				<label class="control-label" for="password">Password</label>
				<input type="password" name="password" id="password" class="form-control" autocomplete="new-password" placeholder="Password" required>
			</div>
		</div>
	</div>

	<button type="submit" class="btn btn-primary w-100">Daftar</button>

	<div class="auth-alt">
		Sudah punya akun? <a href="<?=base_url();?>member/login?ref=<?=$ref;?>">Masuk di sini</a>
	</div>

	<?php
	echo form_close();
	?>
</div>
