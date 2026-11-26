<?php
echo asset_datatables();
?>
<div class="col-md-5">
	<?php
echo asset_select2();
echo validation_errors();
echo form_open(base_url(akses().'/mitra/outlet/penggunaadd'),array('class'=>'form-horizontal'));
?>
<input type="hidden" name="tokoid" value="<?=$tokoid;?>"/>
<div class="form-group required">
	<label class="col-sm-3 control-label" for="">Nama</label>
	<div class="col-md-9">
		<input type="text" name="nama" id="" class="form-control " autocomplete="off" placeholder="Nama Lengkap" required="" value="<?php echo set_value('nama'); ?>"/>
	</div>
</div>
<div class="form-group required">
	<label class="col-sm-3 control-label" for="">Username</label>
	<div class="col-md-6">
		<input type="text" name="username" id="username" class="form-control " autocomplete="off" placeholder="Username" required="" value="<?php echo set_value('username'); ?>"/>
	</div>
</div>
<div class="form-group required">
	<label class="col-sm-3 control-label" for="">Password</label>
	<div class="col-md-6">
		<input type="password" name="password" id="" class="form-control " autocomplete="off" placeholder="Password" required="" value="<?php echo set_value('password'); ?>"/>
	</div>
</div>
<div class="form-group required">
	<label class="col-sm-3 control-label" for="">Akses</label>
	<div class="col-md-8">
		<select name="akses" class="form-control select2" data-placeholder="Pilih Akses" style="width: 100%" required="">
			<option></option>
			<option value="op">Operator</option>
			<option value="bos">Pimpinan</option>
		</select>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-3 control-label">&nbsp;</label>
	<div class="col-md-9">
		<button type="submit" class="btn btn-primary btn-flat">Tambah</button>
		<a href="javascript:history.back(-1);" class="btn btn-default btn-flat">Batal</a>
	</div>
</div>
<?php
echo form_close();
?>
</div>
<div class="col-md-7">

<table class="table table-bordered table-hover table-stripped data-render">
	<thead>
		<th>Nama</th>
		<th>Username</th>
		<th>Akses</th>
		<th>Aksi</th>
	</thead>
	<tbody>
		<?php
		if(!empty($data))
		{
			foreach($data as $row)
			{
				$id=$row->user_id;
				switch($row->akses){
					case "op":
						$akses="Operator";
						break;
					case "bos":
						$akses="Pimpinan";
						break;
				}
			?>
			<tr>
				<td><?=$row->nama;?></td>
				<td><?=$row->username;?></td>
				<td><?=$akses;?></td>
				<td>					
					<a onclick="return confirm('Yakin ingin menghapus user <?=$row->nama;?> ?');" href="<?=base_url(akses().'/mitra/outlet/penggunadelete?id='.$id);?>" class="btn btn-flat btn-xs btn-danger"><i class="fa fa-trash"></i> Delete</a>
				</td>
			</tr>
			<?php
			}
		}
		?>
	</tbody>
</table>
</div>