<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Informasi extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('m_db');
	}
	
	function index()
	{
		$slug2=$this->uri->segment(2);
		$s=array(
		'slug'=>$slug2,
		);
		if($this->m_db->is_bof('berita',$s)==FALSE)
		{
			$judul=$this->m_db->get_row('berita',$s,'judul');
			$meta['judul']="$judul | ".baca_konfig('nama-aplikasi');
			$meta['judulhalaman']="$judul";
			$meta['homepage']=FALSE;
			$this->load->view('html/header',$meta);
			$d['data']=$this->m_db->get_data('berita',$s);
			$this->load->view('html/beritaview',$d);
			$this->load->view('html/footer');
		}else{
			show_404("Halaman tidak ditemukan");
		}
	}
}