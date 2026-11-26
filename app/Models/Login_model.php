<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login_model extends CI_Model
{
	private $tbl_login='userlogin';
	private $tbl_sesi='infologin';
    function __construct()
    {
         $this->load->library('m_db');
    }
    
    function user_data($where=array(),$order="nama ASC")
    {
		$d=$this->m_db->get_data($this->tbl_login,$where,$order);
		return $d;
	}
	
	function user_akses_data()
	{
		$query = "SHOW COLUMNS FROM ".$this->tbl_login." LIKE 'akses'";
        $row = $this->db->query("SHOW COLUMNS FROM ".$this->tbl_login." LIKE 'akses'")->row()->Type;
        $regex = "/'(.*?)'/";
        preg_match_all( $regex , $row, $enum_array );
        $enum_fields = $enum_array[1];
        foreach ($enum_fields as $key=>$value)
        {
            $enums[$value] = $value; 
        }
        return $enums;
	}
    
    function user_info($output='user_id')
    {
		$sesi=$this->session->userdata($this->tbl_sesi);
		if(empty($sesi))
		{
			return "";
		}else{
			$username=$sesi['username'];
			$s=array(
			'username'=>$username,
			);
			$item=$this->m_db->get_row($this->tbl_login,$s,$output);
			return $item;
		}
	}
	
	function user_photo()
	{
		$biasa=base_url().'assets/images/avatar/noavatar.jpg';
		$photo=$this->user_info('photo');
		$photofile=base_url().'assets/images/avatar/'.$photo;
		if(@getimagesize($photofile))
		{
			return $photofile;
		}else{
			return $biasa;
		}
		
	}
    
    function user_login($username,$password)
    {
		$s=array(
		'username'=>$username,
		);
		if($this->m_db->is_bof($this->tbl_login,$s)==FALSE)
		{
			$s2=array(
			'username'=>$username,
			'password'=>md5($password),
			);
			if($this->m_db->is_bof($this->tbl_login,$s2)==FALSE)
			{
				$akses=$this->m_db->get_row($this->tbl_login,$s2,'akses');
				$this->session->set_userdata($this->tbl_sesi,array(
				'username'=>$username,
				'akses'=>$akses,
				));
				$d=array(
				'terakhir_login'=>date("Y-m-d H:i:s"),
				);
				$this->m_db->edit_row($this->tbl_login,$d,$s2);
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	function user_daftar($nama,$username,$password,$akses)
	{
		$s=array(
		'username'=>$username,
		);
		if($this->m_db->is_bof($this->tbl_login,$s)==TRUE)
		{
			$d=array(
			'nama'=>$nama,
			'username'=>$username,
			'password'=>md5($password),
			'akses'=>$akses,
			);
			if($this->m_db->add_row($this->tbl_login,$d)==TRUE)
			{
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	function user_edit($userid,$nama,$username,$password='',$akses)
	{
		$s=array(
		'user_id'=>$userid,
		);
		if($this->m_db->is_bof($this->tbl_login,$s)==FALSE)
		{
			$d=array(
			'nama'=>$nama,
			'username'=>$username,			
			'akses'=>$akses,
			);
			if($this->m_db->edit_row($this->tbl_login,$d,$s)==TRUE)
			{
				if(!empty($password))
				{
					$d2=array(
					'password'=>md5($password),
					);
					$this->m_db->edit_row($this->tbl_login,$d2,$s);
				}
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	function user_delete($userid)
	{
		if(akses()=="admin")
		{
			$s=array(
			'user_id'=>$userid,
			);
			if($this->m_db->delete_row($this->tbl_login,$s)==TRUE)
			{
				return true;
			}else{
				return false;
			}
		}
	}
	
	function user_delete_umum($userid)
	{		
		$s=array(
		'user_id'=>$userid,
		);
		if($this->m_db->delete_row($this->tbl_login,$s)==TRUE)
		{
			return true;
		}else{
			return false;
		}	
	}
	
	function user_logout()
	{
		$this->session->unset_userdata($this->tbl_sesi);
		redirect(base_url());
	}
	
	
	
}