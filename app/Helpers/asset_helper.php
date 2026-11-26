<?php
defined('BASEPATH') OR exit('No direct script access allowed');


if(!function_exists('asset_datatables'))
{
	function asset_datatables()
	{
		$a='';				
		$a.=add_css(base_url().'assets/plugin/datatables/DataTables/css/dataTables.bootstrap.min.css');
		$a.=add_css(base_url().'assets/plugin/datatables/Responsive/css/responsive.bootstrap.min.css');
		$a.=add_css(base_url().'assets/plugin/datatables/Buttons/css/buttons.dataTables.min.css');
		$a.=add_js(base_url().'assets/plugin/datatables/DataTables/js/jquery.dataTables.min.js');
		$a.=add_js(base_url().'assets/plugin/datatables/Responsive/js/dataTables.responsive.min.js');
		$a.=add_js(base_url().'assets/plugin/datatables/DataTables/js/dataTables.bootstrap.min.js');
		$a.=add_js(base_url().'assets/plugin/datatables/Responsive/js/responsive.bootstrap.min.js');
		$a.=add_js(base_url().'assets/plugin/datatables/Buttons/js/dataTables.buttons.min.js');
		$a.=add_js(base_url().'assets/plugin/datatables/Buttons/js/buttons.flash.min.js');
		$a.=add_js(base_url().'assets/plugin/datatables/JSZip/jszip.min.js');
		$a.=add_js(base_url().'assets/plugin/datatables/pdfmake/build/pdfmake.min.js');
		$a.=add_js(base_url().'assets/plugin/datatables/pdfmake/build/vfs_fonts.js');
		$a.=add_js(base_url().'assets/plugin/datatables/Buttons/js/buttons.html5.min.js');
		$a.=add_js(base_url().'assets/plugin/datatables/Buttons/js/buttons.print.min.js');		
		
		return $a;
	}
}


if(!function_exists('asset_jquery'))
{
	function asset_jquery()
	{				
		return add_js(base_url().'assets/plugin/jquery/jquery-1.11.3.min.js');;
	}
}

if(!function_exists('asset_font_awesome'))
{
	function asset_font_awesome()
	{		
		return add_css(base_url().'assets/plugin/font-awesome/css/font-awesome.min.css');
	}
}

if(!function_exists('asset_ionicons'))
{
	function asset_ionicons()
	{		
		return add_css(base_url().'assets/plugin/ionicons/css/ionicons.min.css');
	}
}

if(!function_exists('asset_bootstrap_css'))
{
	function asset_bootstrap_css()
	{		
		return add_css(base_url().'assets/plugin/bootstrap/css/bootstrap.min.css');
	}
}

if(!function_exists('asset_bootstrap_js'))
{
	function asset_bootstrap_js()
	{		
		return add_js(base_url().'assets/plugin/bootstrap/js/bootstrap.min.js');
	}
}

if(!function_exists('asset_jqueryui'))
{
	function asset_jqueryui($theme="smoothness")
	{
		$a='';
		$a.=add_css(base_url().'assets/plugin/jqueryui/jquery-ui.min.css');
		$a.=add_css(base_url().'assets/plugin/jqueryui/themes/'.$theme.'/jquery-ui.min.css');
		$a.=add_js(base_url().'assets/plugin/jqueryui/jquery-ui.min.js');
		return $a;
	}
}

if(!function_exists('asset_select2'))
{
	function asset_select2()
	{
		$a='';
		$a.=add_css(base_url().'assets/plugin/select2/css/select2.min.css');
		$a.=add_js(base_url().'assets/plugin/select2/js/select2.full.min.js');
		$a.=add_js(base_url().'assets/plugin/select2/js/i18n/id.js');
		return $a;
	}
}

if(!function_exists('asset_highchart'))
{
	function asset_highchart($theme='')
	{
		$a='';
		$a.=add_js(base_url().'assets/plugin/highcharts/js/highcharts.js');
		if(!empty($theme))
		{
			$a.=add_js(base_url().'assets/plugin/highcharts/js/themes/'.$theme.'.js');		
		}		
		return $a;
	}
}
