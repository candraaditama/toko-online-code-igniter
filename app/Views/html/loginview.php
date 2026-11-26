<?php
$ref=$this->input->get('ref');
?>
<div class="auth-card">
	<div class="auth-head">
		<h2>Masuk ke Akun</h2>
		<p>Masuk untuk melanjutkan belanja dan melihat histori pesanan Anda.</p>
	</div>

	<?php
	echo validation_errors();
	echo form_open(base_url('login').'?ref='.$ref, array('class'=>'auth-form'));
	?>

	<div class="mb-3">
		<label class="control-label" for="username">Username</label>
		<input type="text" name="username" id="username" class="form-control" autocomplete="username" placeholder="Username" required value="<?php echo set_value('username'); ?>">
	</div>

	<div class="mb-3">
		<label class="control-label" for="password">Password</label>
		<input type="password" name="password" id="password" class="form-control" autocomplete="current-password" placeholder="Password" required>
	</div>

	<button type="submit" class="btn btn-primary w-100">Masuk</button>

	<div class="auth-alt">
		Belum punya akun? <a href="<?=base_url();?>member/daftar?ref=<?=$ref;?>">Daftar sekarang</a>
	</div>

	<?php
	echo form_close();
	?>
</div>
