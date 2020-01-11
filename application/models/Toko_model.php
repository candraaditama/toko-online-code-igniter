<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Toko_model extends CI_Model
{
	function __construct()
	{
		$this->load->library('m_db');
	}
	
	function toko_data($where=array(),$order="nama_toko ASC")
	{
		$d=$this->m_db->get_data('toko',$where,$order);
		return $d;
	}
	
	function toko_add($nama,$alamat,$telepon,$kota,$tipe)
	{
		$d=array(
		'nama_toko'=>$nama,
		'alamat'=>$alamat,
		'telepon'=>$telepon,
		'kota'=>$kota,
		'tipe'=>$tipe,
		);
		$s=array(
		'tipe'=>'pusat',
		);
		$c=$this->m_db->count_data('toko',$s);
		if($tipe=="pusat" && $c==1)
		{
			return false;
		}else{
			if($this->m_db->add_row('toko',$d)==TRUE)
			{
				return true;
			}else{
				return false;
			}
		}
	}
	
	function toko_edit($tokoID,$nama,$alamat,$telepon,$kota)
	{
		$s=array(
		'toko_id'=>$tokoID,
		);
		$d=array(
		'nama_toko'=>$nama,
		'alamat'=>$alamat,
		'telepon'=>$telepon,
		'kota'=>$kota,		
		);
		
		if($this->m_db->edit_row('toko',$d,$s)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function toko_delete($tokoID)
	{
		$s=array(
		'toko_id'=>$tokoID,
		'tipe'=>'cabang',
		);		
		
		if($this->m_db->delete_row('toko',$s)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function toko_pusat()
	{
		$s=array(
		'tipe'=>'pusat',
		);
		$item=$this->m_db->get_row('toko',$s,'toko_id');
		return $item;
	}
	
	function toko_user_data($tokoID)
	{		
		$tipe=toko_info($tokoID,'tipe');
		if($tipe=="cabang")
		{
			$s=array(
			'toko_id'=>$tokoID,
			);
			$d=$this->m_db->get_data('userlogin',$s);
			return $d;
		}else{
			return null;
		}
	}
	
	function toko_user_add($tokoID,$nama,$username,$password,$akses)
	{
		$this->load->model('login_model');
		if($this->login_model->user_daftar($nama,$username,$password,$akses)==TRUE)
		{
			$userid=$this->m_db->last_insert_id();
			$s=array(
			'user_id'=>$userid,
			);
			$d=array(
			'toko_id'=>$tokoID,
			);
			$this->m_db->edit_row('userlogin',$d,$s);
			return true;
		}else{
			return false;
		}
	}
	
	
	function toko_user_delete($id)
	{
		$this->load->model('login_model');
		$id=$this->input->get('id');
		$tokoid=field_value('userlogin','user_id',$id,'toko_id');
		if(!empty($tokoid))
		{
			if($this->login_model->user_delete_umum($id)==TRUE)
			{
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}	
	}
	
}