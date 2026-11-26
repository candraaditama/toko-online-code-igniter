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
            url: '<?=base_url(akses()."/konfigurasi/logoupdate");?>',
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
			  	$("#photo").attr('src',x.url);
            }
        });
     
          return false;
    });
});
</script>
<div class="col-md-8">
<?php
echo validation_errors();
echo form_open(base_url(akses()).'/konfigurasi/temaupdate',array('class'=>'form-horizontal'));
?>
<div class="form-group">
	<label class="col-sm-2 control-label">Tema Admin</label>
	<div class="col-md-8">
		<select name="tema-aktif" class="form-control">
			<?php			
			$dir=FCPATH.'assets/tema/';
			$arr=array_slice(scandir($dir), 2);
			$curThemeData=baca_konfig('tema-aktif');
			$curTheme=$curThemeData;
			foreach($arr as $k=>$v)
			{				
				if(is_dir($dir.$v))
				{
					$chk='';
					if($v==$curTheme)
					{
						$chk='selected="selected"';
					}
					echo '<option value="'.$v.'" '.$chk.'>'.ucwords($v).'</option>';
				}
			}
			?>
		</select>		
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label">&nbsp;</label>
	<div class="col-md-10">
		<button type="submit" class="btn btn-primary btn-flat">Update</button>		
	</div>
</div>
<?php
echo form_close();
?>
</div>
<div class="col-md-4">
<form id="formphoto">
  <div class="thumbnail">                        
    <img alt="" id="photo" src="<?=tema_logo();?>"/>
    <span id="tukarphoto" style="margin-top: 5px" class="btn btn-link">Tukar Logo</span>
    <input type="file" name="file" id="file" style="display: none;"/>
  </div>
</form>
</div>