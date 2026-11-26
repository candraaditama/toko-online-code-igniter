<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Supplier_model extends CI_Model
{
	function __construct()
	{
		$this->load->library('m_db');
	}
	
	function supplier_data($where=array(),$order="nama_supplier ASC")
	{
		$d=$this->m_db->get_data('supplier',$where,$order);
		return $d;
	}
	
	function supplier_add($nama,$alamat,$telepon)
	{
		$d=array(
		'nama_supplier'=>$nama,
		'alamat'=>$alamat,
		'telepon'=>$telepon,
		);
		if($this->m_db->add_row('supplier',$d)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function supplier_edit($supplierID,$nama,$alamat,$telepon)
	{
		$s=array(
		'supplier_id'=>$supplierID,
		);
		$d=array(
		'nama_supplier'=>$nama,
		'alamat'=>$alamat,
		'telepon'=>$telepon,
		);
		if($this->m_db->edit_row('supplier',$d,$s)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function supplier_delete($supplierID)
	{
		$s=array(
		'supplier_id'=>$supplierID,
		);
		
		if($this->m_db->delete_row('supplier',$s)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
}