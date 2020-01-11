<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('set_header_message'))
{
	function set_header_message($tipe,$title,$message)
	{
		$CI=& get_instance();
		
		$CI->session->set_flashdata('message_header',array(
		'tipe'=>$tipe,
		'title'=>$title,
		'message'=>$message,
		));				
	}
}

if(!function_exists('menu_html'))
{
	function menu_html($str)
	{
		$CI=& get_instance();
		$slug1=$CI->uri->segment(1);
		if($slug1==$str)
		{
			return 'active';
		}
	}
}

if(!function_exists('baca_konfig'))
{
	function baca_konfig($nama)
	{
		$CI=& get_instance();
		$CI->load->library('m_db');
		$s=array(
		'nama_key'=>$nama,
		);
		$item=$CI->m_db->get_row('konfigurasi',$s,'isi');
		return $item;
	}
}

if(!function_exists('user_info'))
{
	function user_info($output='user_id')
	{
		$CI=& get_instance();
		$CI->load->model('login_model');
		$item=$CI->login_model->user_info($output);
		return $item;
	}
}


if(!function_exists('akses'))
{
	function akses()
	{
		$CI=& get_instance();
		$CI->load->model('login_model');
		$item=$CI->login_model->user_info('akses');
		return $item;
	}
}

if(!function_exists('user_photo'))
{
	function user_photo()
	{
		$CI=& get_instance();
		$CI->load->model('login_model');
		$item=$CI->login_model->user_photo();
		return $item;
	}
}

if(!function_exists('menu_active'))
{
	function menu_active($slug2)
	{
		$CI=& get_instance();
		$s=$CI->uri->segment(2);
		if($slug2==$s)
		{
			return true;
		}else{
			return false;
		}
	}
}

if(!function_exists('tema_logo'))
{
	function tema_logo()
	{
		$biasa=base_url().'assets/images/logo.png';
		$photo=baca_konfig('tema-logo');
		$photofile=base_url().'assets/images/'.$photo;
		if(@getimagesize($photofile))
		{
			return $photofile;
		}else{
			return $biasa;
		}
		
	}
}

if(!function_exists('add_css'))
{
	function add_css($url)
	{
		$tmp='<link rel="stylesheet" href="'.$url.'">';
		return $tmp;
	}
}

if(!function_exists('add_js'))
{
	function add_js($url)
	{
		$tmp='<script src="'.$url.'"></script>';
		return $tmp;
	}
}

if(!function_exists('string_create_slug')){
	function string_create_slug($text)
	{	  
	  if (empty($text))
	  {
		return '';
	  }else{
	  	$text = preg_replace('~[^\\pL\d]+~u', '-', $text);
	  	$text = trim($text, '-');
	  	$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	  	$text = strtolower($text);
	  	$text = preg_replace('~[^-\w]+~', '', $text);
	  	return $text;
	  }
	  
	}
}

if(!function_exists('string_word_limit')){
	function string_word_limit($str,$limit=20,$comaDelimiter=FALSE){
		$CI=& get_instance();
		$CI->load->helper('text');
		$item="";
		if($comaDelimiter==TRUE)
		{
			$item=word_limiter($str,$limit);
		}else{
			$item=word_limiter($str,$limit,"");
		}
		return $item;
	}
}

if(!function_exists('field_value'))
{
	function field_value($table,$key,$keyval,$output)
	{
		$CI=& get_instance();
		$CI->load->library('m_db');
		$s=array(
		$key=>$keyval,
		);
		$item=$CI->m_db->get_row($table,$s,$output);
		return $item;
	}
}

if(!function_exists('field_value_custom'))
{
	function field_value_custom($table,$where=array(),$output)
	{
		$CI=& get_instance();
		$CI->load->library('m_db');		
		$item=$CI->m_db->get_row($table,$where,$output);
		return $item;
	}
}

if(!function_exists('fetch_data'))
{
	function fetch_data($table,$where=array(),$order='',$group='',$limit='',$start='')
	{
		$CI=& get_instance();
		$CI->load->library('m_db');
		$item=$CI->m_db->get_data($table,$where,$order,$group,$limit,$start);
		return $item;
	}
}

if(!function_exists('count_data'))
{
	function count_data($table,$where=array())
	{
		$CI=& get_instance();
		$CI->load->library('m_db');		
		$item=$CI->m_db->count_data($table,$where);
		return $item;
	}
}

if(!function_exists('sum_data'))
{
	function sum_data($table,$where=array(),$field)
	{
		$CI=& get_instance();
		$CI->load->library('m_db');
		$item=$CI->m_db->get_sum_row($table,$where,$field);
		return $item;
	}
}

if ( ! function_exists('string_implode_array'))
{
	function string_implode_array($attributes)
	{
		if (empty($attributes))
		{
			return '';
		}

		if (is_object($attributes))
		{
			$attributes = (array) $attributes;
		}

		if (is_array($attributes))
		{
			$atts = '';

			foreach ($attributes as $key => $val)
			{
				$atts .= ' '.$key.'="'.$val.'"';
			}

			return $atts;
		}

		if (is_string($attributes))
		{
			return ' '.$attributes;
		}

		return FALSE;
	}
}

if(!function_exists('com_select_bulan'))
{
	function com_select_bulan($name,$firstvalue='',$att=array())
	{
		$arr=array(
		'1'=>'Januari',
		'2'=>'Februari',
		'3'=>'Maret',
		'4'=>'April',
		'5'=>'Mei',
		'6'=>'Juni',
		'7'=>'Juli',
		'8'=>'Agustus',
		'9'=>'September',
		'10'=>'Oktober',
		'11'=>'November',
		'12'=>'Desember',
		);
		$o='';
		$attribute="";
		if(!empty($att))
		{
			$attribute=string_implode_array($att);
		}
		$o.='<select name="'.$name.'" '.$attribute.'>';
		foreach($arr as $k=>$v)
		{
			$js='';
			if($firstvalue==$k)
			{
				$js=' selected="selected"';
			}
			$o.='<option value="'.$k.'"'.$js.'>'.$v.'</option>';
		}
		$o.='</select>';
		return $o;
	}
}

if(!function_exists('date_month_name')){
	function date_month_name($bulan)
	{
		$mons = array(1 => "Januari", 2 => "Februari", 3 => "Maret", 4 => "April", 5 => "Mei", 6 => "Juni", 7 => "Juli", 8 => "Agustus", 9 => "September", 10 => "Oktober", 11 => "November", 12 => "Desember");

		$ft= strtr($bulan, $mons);
		return $ft;
	}
}