<?php
if(!empty($method))
{
if($method=="single")
{
	echo asset_jquery();
}	
}
?>
<link rel="stylesheet" type="text/css" href="<?=base_url().'assets/plugin/';?>elfinder/css/elfinder.min.css"/>
<link rel="stylesheet" type="text/css" href="<?=base_url().'assets/plugin/';?>elfinder/css/theme.css"/>
<link rel="stylesheet" type="text/css" href="<?=base_url().'assets/plugin/';?>elfinder/themes/windows-10/css/theme.css"/>
<?php
echo asset_jqueryui();
?>
<script src="<?=base_url().'assets/plugin/';?>elfinder/js/elfinder.min.js"></script>
<script src="<?=base_url().'assets/plugin/';?>elfinder/js/i18n/elfinder.id.js"></script>

<script type="text/javascript" charset="utf-8">
	
	function getUrlParam(paramName) {
        var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i') ;
        var match = window.location.search.match(reParam) ;

        return (match && match.length > 1) ? match[1] : '' ;
    }
	
    $(document).ready(function() {
    	var funcNum = getUrlParam('CKEditorFuncNum');
    	var optelfinder=[];
    	if(funcNum!="")
    	{
			var optelfinder={
				url : '<?=base_url();?>filemanager/elfinder_init',
	            lang: 'id',
	            resizable: false,	            
	            getFileCallback : function(file) {
	                window.opener.CKEDITOR.tools.callFunction(funcNum, file.url);
	                window.close();
	            },
			}
		}else{
			var optelfinder={
				url : '<?=base_url();?>filemanager/elfinder_init',
	            lang: 'id',
	            resizable: false,	            
			}
		}    	
        $('#elfinder').elfinder(optelfinder);
    });
</script>

<div id="elfinder"></div>