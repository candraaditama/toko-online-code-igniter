<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Warna extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('m_db');		
		if(akses()!="op")
		{
			$this->login_model->user_logout();
		}
		$this->load->model('produk_model','mod_produk');
	}
	
	function index()
	{		
		$meta['judul']="Semua Warna Produk";
		$this->load->view('tema/header',$meta);
		$d['data']=$this->mod_produk->warna_data();
		$this->load->view(akses().'/produk/warna/warnaview',$d);
		$this->load->view('tema/footer');
	}
	
	function add()
	{
		$this->form_validation->set_rules('nama','Nama Warna Produk','required');
		if($this->form_validation->run()==TRUE)
		{
			$nama=$this->input->post('nama',TRUE);
			
			if($this->mod_produk->warna_add($nama)==TRUE)
			{
				set_header_message('success','Tambah Warna Produk','Berhasil menambahkan Warna Produk');
				redirect(base_url(akses().'/produk/warna'),'refresh',301);
			}else{
				set_header_message('danger','Tambah Warna Produk','Gagal menambahkan Warna Produk');
				redirect(base_url(akses().'/produk/warna'),'refresh',301);
			}			
		}else{
			redirect(base_url(akses().'/produk/warna'),'refresh',301);
		}
	}
	
	function edit()
	{
		$this->form_validation->set_rules('warnaid','ID Warna Produk','required');
		$this->form_validation->set_rules('nama','Nama Warna Produk','required');
		if($this->form_validation->run()==TRUE)
		{
			$warnaid=$this->input->post('warnaid',TRUE);
			$nama=$this->input->post('nama',TRUE);
			
			if($this->mod_produk->warna_edit($warnaid,$nama)==TRUE)
			{
				set_header_message('success','Ubah Warna Produk','Berhasil mengubah Warna Produk');
				redirect(base_url(akses().'/produk/warna'),'refresh',301);
			}else{
				set_header_message('danger','Ubah Warna Produk','Gagal mengubah Warna Produk');
				redirect(base_url(akses().'/produk/warna'),'refresh',301);
			}			
		}else{
			$id=$this->input->get('id',TRUE);
			$meta['judul']="Ubah Warna Produk";
			$this->load->view('tema/header',$meta);
			$d['data']=$this->mod_produk->warna_data(array('warna_id'=>$id));
			$this->load->view(akses().'/produk/warna/warnaedit',$d);
			$this->load->view('tema/footer');
		}
	}
	
	function delete()
	{
		$id=$this->input->get('id',TRUE);
		if($this->mod_produk->warna_delete($id)==TRUE)
		{
			set_header_message('success','Hapus Warna Produk','Berhasil menghapus Warna Produk');
			redirect(base_url(akses().'/produk/warna'),'refresh',301);
		}else{
			set_header_message('danger','Hapus Warna Produk','Gagal menghapus Warna Produk');
			redirect(base_url(akses().'/produk/warna'),'refresh',301);
		}
	}
}