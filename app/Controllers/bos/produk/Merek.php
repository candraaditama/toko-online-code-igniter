<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Merek extends CI_Controller {

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
		$meta['judul']="Semua Merek Produk";
		$this->load->view('tema/header',$meta);
		$d['data']=$this->mod_produk->merek_data();
		$this->load->view(akses().'/produk/merek/merekview',$d);
		$this->load->view('tema/footer');
	}
	
	function add()
	{
		$this->form_validation->set_rules('nama','Nama Merek Produk','required');
		if($this->form_validation->run()==TRUE)
		{
			$nama=$this->input->post('nama',TRUE);
			
			if($this->mod_produk->merek_add($nama)==TRUE)
			{
				set_header_message('success','Tambah Merek Produk','Berhasil menambahkan Merek Produk');
				redirect(base_url(akses().'/produk/merek'),'refresh',301);
			}else{
				set_header_message('danger','Tambah Merek Produk','Gagal menambahkan Merek Produk');
				redirect(base_url(akses().'/produk/merek'),'refresh',301);
			}			
		}else{
			redirect(base_url(akses().'/produk/merek'),'refresh',301);
		}
	}
	
	function edit()
	{
		$this->form_validation->set_rules('merekid','ID Merek Produk','required');
		$this->form_validation->set_rules('nama','Nama Merek Produk','required');
		if($this->form_validation->run()==TRUE)
		{
			$merekid=$this->input->post('merekid',TRUE);
			$nama=$this->input->post('nama',TRUE);
			
			if($this->mod_produk->merek_edit($merekid,$nama)==TRUE)
			{
				set_header_message('success','Ubah Merek Produk','Berhasil mengubah Merek Produk');
				redirect(base_url(akses().'/produk/merek'),'refresh',301);
			}else{
				set_header_message('danger','Ubah Merek Produk','Gagal mengubah Merek Produk');
				redirect(base_url(akses().'/produk/merek'),'refresh',301);
			}			
		}else{
			$id=$this->input->get('id',TRUE);
			$meta['judul']="Ubah Merek Produk";
			$this->load->view('tema/header',$meta);
			$d['data']=$this->mod_produk->merek_data(array('merek_id'=>$id));
			$this->load->view(akses().'/produk/merek/merekedit',$d);
			$this->load->view('tema/footer');
		}
	}
	
	function delete()
	{
		$id=$this->input->get('id',TRUE);
		if($this->mod_produk->merek_delete($id)==TRUE)
		{
			set_header_message('success','Hapus Merek Produk','Berhasil menghapus Merek Produk');
			redirect(base_url(akses().'/produk/merek'),'refresh',301);
		}else{
			set_header_message('danger','Hapus Merek Produk','Gagal menghapus Merek Produk');
			redirect(base_url(akses().'/produk/merek'),'refresh',301);
		}
	}
}