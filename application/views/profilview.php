<script>
$(document).ready(function(){
    $("#tukarphoto").click(function(e){
        e.preventDefault();
        $("#file").trigger('click');
    });
    
    $("#file").change(function(){
        var photo=$(this).val();
        if(photo=="")
        {
            return false;
        }else{
            $("#formphoto").trigger('submit');
        }
    });
    
    $("#formphoto").submit(function(e){
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: '<?=base_url();?>profil/uploadphoto',
            type: 'POST',
            dataType:'JSON',
            data: formData,
            async: true,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend:function(){
                
            },
            success: function (x) {
              if(x.status=="ok")
              {
              	reload_avatar(x.url);
			  	$("#photo").attr('src',x.url);			  	
			  	alert(x.message);
			  }else{
			  	alert(x.message);
			  }			  
            }
        });               
    });
});
</script>
<div class="col-md-3">
	<form id="formphoto">
      <div class="thumbnail">                        
        <img alt="" id="photo" src="<?=user_photo();?>"/>
        <span id="tukarphoto" style="margin-top: 5px" class="btn btn-link">Tukar Avatar</span>
        <input type="file" name="file" id="file" style="display: none;"/>
      </div>
    </form>
</div>
<div class="col-md-9">
	<?php
	echo form_open(base_url().'profil/profilupdate',array('class'=>'form-horizontal'));
	?>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="nama">Nama</label>
		<div class="col-md-8">
			<input type="text" name="nama" id="nama" class="form-control" autocomplete="off" placeholder="Entri nama lengkap" required="" value="<?=user_info('nama');?>"/>
		</div>
	</div>	
	<div class="form-group">
		<label class="col-sm-2 control-label" for="password">Password</label>
		<div class="col-md-4">
			<input type="password" name="password" id="password" class="form-control" autocomplete="off" placeholder="Entri jika ingin mengubah password"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="hp">&nbsp;</label>
		<div class="col-md-4">
			<button type="submit" class="btn btn-primary btn-flat">Simpan</button>
		</div>
	</div>
	<?php
	echo form_close();
	?>
</div>