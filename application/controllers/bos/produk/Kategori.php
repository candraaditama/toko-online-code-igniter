<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('m_db');		
		if(akses()!="bos")
		{
			$this->login_model->user_logout();
		}
		$this->load->model('produk_model','mod_produk');
	}
	
	function index()
	{		
		$meta['judul']="Semua Kategori Produk";
		$this->load->view('tema/header',$meta);
		$d['data']=$this->mod_produk->kategori_data();
		$this->load->view(akses().'/produk/kategori/kategoriview',$d);
		$this->load->view('tema/footer');
	}
	
	function add()
	{
		$this->form_validation->set_rules('nama','Nama Kategori Produk','required');
		if($this->form_validation->run()==TRUE)
		{
			$nama=$this->input->post('nama',TRUE);
			
			if($this->mod_produk->kategori_add($nama)==TRUE)
			{
				set_header_message('success','Tambah Kategori Produk','Berhasil menambahkan Kategori Produk');
				redirect(base_url(akses().'/produk/kategori'),'refresh',301);
			}else{
				set_header_message('danger','Tambah Kategori Produk','Gagal menambahkan Kategori Produk');
				redirect(base_url(akses().'/produk/kategori'),'refresh',301);
			}			
		}else{
			redirect(base_url(akses().'/produk/kategori'),'refresh',301);
		}
	}
	
	function edit()
	{
		$this->form_validation->set_rules('kategoriid','ID Kategori Produk','required');
		$this->form_validation->set_rules('nama','Nama Kategori Produk','required');
		if($this->form_validation->run()==TRUE)
		{
			$kategoriid=$this->input->post('kategoriid',TRUE);
			$nama=$this->input->post('nama',TRUE);
			
			if($this->mod_produk->kategori_edit($kategoriid,$nama)==TRUE)
			{
				set_header_message('success','Ubah Kategori Produk','Berhasil mengubah Kategori Produk');
				redirect(base_url(akses().'/produk/kategori'),'refresh',301);
			}else{
				set_header_message('danger','Ubah Kategori Produk','Gagal mengubah Kategori Produk');
				redirect(base_url(akses().'/produk/kategori'),'refresh',301);
			}			
		}else{
			$id=$this->input->get('id',TRUE);
			$meta['judul']="Ubah Kategori Produk";
			$this->load->view('tema/header',$meta);
			$d['data']=$this->mod_produk->kategori_data(array('kategori_id'=>$id));
			$this->load->view(akses().'/produk/kategori/kategoriedit',$d);
			$this->load->view('tema/footer');
		}
	}
	
	function delete()
	{
		$id=$this->input->get('id',TRUE);
		if($this->mod_produk->kategori_delete($id)==TRUE)
		{
			set_header_message('success','Hapus Kategori Produk','Berhasil menghapus Kategori Produk');
			redirect(base_url(akses().'/produk/kategori'),'refresh',301);
		}else{
			set_header_message('danger','Hapus Kategori Produk','Gagal menghapus Kategori Produk');
			redirect(base_url(akses().'/produk/kategori'),'refresh',301);
		}
	}
}