<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('m_db');
		$this->load->model('pelanggan_model','mod_pelanggan');
	}
	
	function index()
	{
		$meta['judul']="Daftar Pelanggan";
		$this->load->view('tema/header',$meta);
		$d['data']=$this->mod_pelanggan->pelanggan_data();
		$this->load->view(akses().'/mitra/pelanggan/pelangganview',$d);
		$this->load->view('tema/footer');
	}
	
	function detail()
	{
		
	}
	
	function delete()
	{
		$id=$this->input->get('id',TRUE);
		if($this->mod_pelanggan->pelanggan_delete($id)==TRUE)
		{
			set_header_message('success','Hapus Pelanggan','Berhasil menghapus pelanggan');
			redirect(base_url(akses().'/mitra/pelanggan'));
		}else{
			set_header_message('danger','Hapus Pelanggan','Gagal menghapus pelanggan');
			redirect(base_url(akses().'/mitra/pelanggan'));
		}
	}
	
}