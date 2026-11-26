<?php
$ref=$this->input->get('ref');
echo validation_errors();
echo form_open(base_url('login').'?ref='.$ref,array('class'=>'form-horizontal'));
?>
<div class="form-group">
	<label class="col-sm-2 control-label" for="">Username</label>
	<div class="col-md-6">
		<input type="text" name="username" id="" class="form-control " autocomplete="off" placeholder="Username" required="" value="<?php echo set_value('username'); ?>"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="">Password</label>
	<div class="col-md-6">
		<input type="password" name="password" id="" class="form-control " autocomplete="off" placeholder="Password" required="" value="<?php echo set_value('password'); ?>"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label">&nbsp;</label>
	<div class="col-md-6">
		<button type="submit" class="btn btn-primary btn-flat">Login</button>
		<a href="<?=base_url();?>member/daftar?ref=<?=$ref;?>" class="btn btn-default btn-flat">Belum punya akun?</a>
	</div>
</div>
<?php
echo form_close();
?>