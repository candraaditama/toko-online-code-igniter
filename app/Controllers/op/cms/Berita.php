<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berita extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('m_db');		
		$this->load->model('login_model');
		$this->load->model('cms_model');
		if(akses()!="op")
		{
			$this->login_model->user_logout();
		}
	}
	
	function index()
	{		
		$meta['judul']="Semua Berita";
		$this->load->view('tema/header',$meta);
		$d['data']=$this->cms_model->konten_data(array('jenis'=>'berita'));
		$this->load->view(akses().'/cms/berita/beritaview',$d);
		$this->load->view('tema/footer');
	}
	
	function add()
	{
		$this->form_validation->set_rules('judul','Judul Berita','required');
		$this->form_validation->set_rules('kategoriid','ID Kategori','required');
		$this->form_validation->set_rules('isi','Isi Berita','required');
		$this->form_validation->set_rules('status','Status Berita','required');
		if($this->form_validation->run()==TRUE)
		{
			$judul=$this->input->post('judul');
			$kategoriid=$this->input->post('kategoriid');
			$isi=$this->input->post('isi');
			$status=$this->input->post('status');
			if($this->cms_model->berita_add($kategoriid,$judul,$isi,$status)==TRUE)
			{
				set_header_message('success','Tambah Berita','Berhasil menambah Berita');
				redirect(base_url(akses().'/cms/berita'));
			}else{
				set_header_message('danger','Tambah Berita','Gagal menambah Berita');
				redirect(base_url(akses().'/cms/berita'));
			}
		}else{
			$meta['judul']="Tambah Berita";
			$this->load->view('tema/header',$meta);
			$d['kategori']=$this->cms_model->kategori_data();
			$this->load->view(akses().'/cms/berita/beritaadd',$d);
			$this->load->view('tema/footer');
		}
	}
	
	function edit()
	{
		$this->form_validation->set_rules('beritaid','ID Berita','required');
		$this->form_validation->set_rules('judul','Judul Berita','required');
		$this->form_validation->set_rules('kategoriid','ID Kategori','required');
		$this->form_validation->set_rules('isi','Isi Berita','required');
		$this->form_validation->set_rules('status','Status Berita','required');
		if($this->form_validation->run()==TRUE)
		{
			$beritaid=$this->input->post('beritaid');
			$judul=$this->input->post('judul');
			$kategoriid=$this->input->post('kategoriid');
			$isi=$this->input->post('isi');
			$status=$this->input->post('status');
			if($this->cms_model->berita_edit($beritaid,$kategoriid,$judul,$isi,$status)==TRUE)
			{
				set_header_message('success','Ubah Berita','Berhasil mengubah Berita');
				redirect(base_url(akses().'/cms/berita'));
			}else{
				set_header_message('danger','Ubah Berita','Gagal mengubah Berita');
				redirect(base_url(akses().'/cms/berita'));
			}
		}else{
			$id=$this->input->get('id');
			$meta['judul']="Ubah Berita";
			$this->load->view('tema/header',$meta);
			$d['kategori']=$this->cms_model->kategori_data();
			$d['data']=$this->cms_model->konten_data(array('berita_id'=>$id,'jenis'=>'berita'));
			$this->load->view(akses().'/cms/berita/beritaedit',$d);
			$this->load->view('tema/footer');
		}
	}
	
	function delete()
	{
		$id=$this->input->get('id');
		if($this->cms_model->berita_delete($id)==TRUE)
		{
			set_header_message('success','Hapus Berita','Berhasil menghapus Berita');
			redirect(base_url(akses().'/cms/berita'));
		}else{
			set_header_message('danger','Hapus Berita','Gagal menghapus Berita');
			redirect(base_url(akses().'/cms/berita'));
		}
	}
}