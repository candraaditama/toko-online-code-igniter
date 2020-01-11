<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ukuran extends CI_Controller {

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
		$meta['judul']="Semua Ukuran Produk";
		$this->load->view('tema/header',$meta);
		$d['data']=$this->mod_produk->ukuran_data();
		$this->load->view(akses().'/produk/ukuran/ukuranview',$d);
		$this->load->view('tema/footer');
	}
	
	function add()
	{
		$this->form_validation->set_rules('nama','Nama Ukuran Produk','required');
		if($this->form_validation->run()==TRUE)
		{
			$nama=$this->input->post('nama',TRUE);
			
			if($this->mod_produk->ukuran_add($nama)==TRUE)
			{
				set_header_message('success','Tambah Ukuran Produk','Berhasil menambahkan Ukuran Produk');
				redirect(base_url(akses().'/produk/ukuran'),'refresh',301);
			}else{
				set_header_message('danger','Tambah Ukuran Produk','Gagal menambahkan Ukuran Produk');
				redirect(base_url(akses().'/produk/ukuran'),'refresh',301);
			}			
		}else{
			redirect(base_url(akses().'/produk/ukuran'),'refresh',301);
		}
	}
	
	function edit()
	{
		$this->form_validation->set_rules('ukuranid','ID Ukuran Produk','required');
		$this->form_validation->set_rules('nama','Nama Ukuran Produk','required');
		if($this->form_validation->run()==TRUE)
		{
			$ukuranid=$this->input->post('ukuranid',TRUE);
			$nama=$this->input->post('nama',TRUE);
			
			if($this->mod_produk->ukuran_edit($ukuranid,$nama)==TRUE)
			{
				set_header_message('success','Ubah Ukuran Produk','Berhasil mengubah Ukuran Produk');
				redirect(base_url(akses().'/produk/ukuran'),'refresh',301);
			}else{
				set_header_message('danger','Ubah Ukuran Produk','Gagal mengubah Ukuran Produk');
				redirect(base_url(akses().'/produk/ukuran'),'refresh',301);
			}			
		}else{
			$id=$this->input->get('id',TRUE);
			$meta['judul']="Ubah Ukuran Produk";
			$this->load->view('tema/header',$meta);
			$d['data']=$this->mod_produk->ukuran_data(array('ukuran_id'=>$id));
			$this->load->view(akses().'/produk/ukuran/ukuranedit',$d);
			$this->load->view('tema/footer');
		}
	}
	
	function delete()
	{
		$id=$this->input->get('id',TRUE);
		if($this->mod_produk->ukuran_delete($id)==TRUE)
		{
			set_header_message('success','Hapus Ukuran Produk','Berhasil menghapus Ukuran Produk');
			redirect(base_url(akses().'/produk/ukuran'),'refresh',301);
		}else{
			set_header_message('danger','Hapus Ukuran Produk','Gagal menghapus Ukuran Produk');
			redirect(base_url(akses().'/produk/ukuran'),'refresh',301);
		}
	}
}