<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('m_db');		
		$this->load->model('login_model');
		$this->load->model('cms_model');
		if(akses()!="bos")
		{
			$this->login_model->user_logout();
		}
	}
	
	function index()
	{		
		$meta['judul']="Kategori Berita";
		$this->load->view('tema/header',$meta);
		$d['data']=$this->cms_model->kategori_data();
		$this->load->view(akses().'/cms/kategori/kategoriview',$d);
		$this->load->view('tema/footer');
	}
	
	function add()
	{
		$this->form_validation->set_rules('nama','Nama Kategori','required');
		if($this->form_validation->run()==TRUE)
		{
			$nama=$this->input->post('nama');
			if($this->cms_model->kategori_add($nama)==TRUE)
			{
				set_header_message('success','Tambah Kategori','Berhasil menambah Kategori');
				redirect(base_url(akses().'/cms/kategori'));
			}else{
				set_header_message('danger','Tambah Kategori','Gagal menambah Kategori');
				redirect(base_url(akses().'/cms/kategori'));
			}
		}else{
			redirect(base_url(akses().'/cms/kategori'));
		}
	}
	
	function edit()
	{
		$this->form_validation->set_rules('kategoriid','ID Kategori','required');
		$this->form_validation->set_rules('nama','Nama Kategori','required');
		if($this->form_validation->run()==TRUE)
		{
			$kategoriid=$this->input->post('kategoriid');
			$nama=$this->input->post('nama');
			if($this->cms_model->kategori_edit($kategoriid,$nama)==TRUE)
			{
				set_header_message('success','Ubah Kategori','Berhasil mengubah Kategori');
				redirect(base_url(akses().'/cms/kategori'));
			}else{
				set_header_message('danger','Ubah Kategori','Gagal mengubah Kategori');
				redirect(base_url(akses().'/cms/kategori'));
			}
		}else{
			$id=$this->input->get('id');
			$meta['judul']="Ubah Berita";
			$this->load->view('tema/header',$meta);
			$d['data']=$this->cms_model->kategori_data(array('berita_kategori_id'=>$id));
			$this->load->view(akses().'/cms/kategori/kategoriedit',$d);
			$this->load->view('tema/footer');
		}
	}
	
	function delete()
	{
		$id=$this->input->get('id');
		if($this->cms_model->kategori_delete($id)==TRUE)
		{
			set_header_message('success','Hapus Kategori','Berhasil menghapus Kategori');
			redirect(base_url(akses().'/cms/kategori'));
		}else{
			set_header_message('danger','Hapus Kategori','Gagal menghapus Kategori');
			redirect(base_url(akses().'/cms/kategori'));
		}
	}
}