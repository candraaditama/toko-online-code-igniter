<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pelanggan_model extends CI_Model
{
	function __construct()
	{
		$this->load->library('m_db');
	}
	
	function pelanggan_data($where=array(),$order="nama_pelanggan ASC")
	{
		$d=$this->m_db->get_data('pelanggan',$where,$order);
		return $d;
	}
	
	function pelanggan_delete($pelangganID)
	{
		$s=array(
		'pelanggan_id'=>$pelangganID,
		);
		if($this->m_db->is_bof('pelanggan',$s)==FALSE)
		{
			$userid=$this->m_db->get_row('pelanggan',$s,'user_id');
			$suser=array(
			'user_id'=>$userid,
			);
			$this->m_db->delete_row('pelanggan',$s);
			$this->m_db->delete_row('userlogin',$suser);
			return true;
		}else{
			return false;
		}
	}
	
}