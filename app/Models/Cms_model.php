<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cms_model extends CI_Model
{	
    function __construct()
    {
         $this->load->library('m_db');
    }
    
    function konten_data($where=array(),$order="tanggal DESC")
    {
		$d=$this->m_db->get_data('berita',$where,$order);
		return $d;
	}
	
	function kategori_data($where=array(),$order="nama_kategori ASC")
	{
		$d=$this->m_db->get_data('berita_kategori',$where,$order);
		return $d;
	}
	
	function kategori_add($nama)
	{
		$slug=string_create_slug($nama);
		$d=array(
		'nama_kategori'=>$nama,
		'slug'=>$slug,
		);
		if($this->m_db->add_row('berita_kategori',$d)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function kategori_edit($kategoriID,$nama)
	{
		$s=array(
		'berita_kategori_id'=>$kategoriID,
		);
		$d=array(
		'nama_kategori'=>$nama,
		);
		if($this->m_db->edit_row('berita_kategori',$d,$s)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function kategori_delete($kategoriID)
	{
		$s=array(
		'berita_kategori_id'=>$kategoriID,
		);
		
		if($this->m_db->delete_row('berita_kategori',$s)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function berita_add($kategoriID,$judul,$isi,$status='draft')
	{
		$slug=string_create_slug($judul);
		$d=array(
		'berita_kategori_id'=>$kategoriID,
		'judul'=>$judul,
		'slug'=>$slug,
		'isi'=>$isi,
		'tanggal'=>date("Y-m-d H:i:s"),
		'jenis'=>'berita',
		'status'=>$status,
		'user_id'=>user_info('user_id'),
		);
		if($this->m_db->add_row('berita',$d)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function berita_edit($beritaID,$kategoriID,$judul,$isi,$status='draft')
	{
		$s=array(
		'berita_id'=>$beritaID,
		);
		$d=array(
		'berita_kategori_id'=>$kategoriID,
		'judul'=>$judul,
		'isi'=>$isi,
		'status'=>$status,
		);
		if($this->m_db->edit_row('berita',$d,$s)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function berita_delete($beritaID)
	{
		$s=array(
		'berita_id'=>$beritaID,
		);
		
		if($this->m_db->delete_row('berita',$s)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function halaman_add($judul,$isi,$status='draft')
	{
		$slug=string_create_slug($judul);
		$d=array(		
		'judul'=>$judul,
		'slug'=>$slug,
		'isi'=>$isi,
		'tanggal'=>date("Y-m-d H:i:s"),
		'jenis'=>'halaman',
		'status'=>$status,
		'user_id'=>user_info('user_id'),
		);
		if($this->m_db->add_row('berita',$d)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function halaman_edit($beritaID,$judul,$isi,$status='draft')
	{
		$s=array(
		'berita_id'=>$beritaID,
		);
		$d=array(		
		'judul'=>$judul,
		'isi'=>$isi,
		'status'=>$status,
		);
		if($this->m_db->edit_row('berita',$d,$s)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function halaman_delete($beritaID)
	{
		$s=array(
		'berita_id'=>$beritaID,
		);
		
		if($this->m_db->delete_row('berita',$s)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
}