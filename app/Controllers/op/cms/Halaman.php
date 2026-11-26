<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Halaman extends CI_Controller {

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
		$meta['judul']="Semua Halaman";
		$this->load->view('tema/header',$meta);
		$d['data']=$this->cms_model->konten_data(array('jenis'=>'halaman'));
		$this->load->view(akses().'/cms/halaman/halamanview',$d);
		$this->load->view('tema/footer');
	}
	
	function add()
	{
		$this->form_validation->set_rules('judul','Judul Halaman','required');
		$this->form_validation->set_rules('isi','Isi Halaman','required');
		$this->form_validation->set_rules('status','Status Halaman','required');
		if($this->form_validation->run()==TRUE)
		{
			$judul=$this->input->post('judul');
			$isi=$this->input->post('isi');
			$status=$this->input->post('status');
			if($this->cms_model->halaman_add($judul,$isi,$status)==TRUE)
			{
				set_header_message('success','Tambah Halaman','Berhasil menambah Halaman');
				redirect(base_url(akses().'/cms/halaman'));
			}else{
				set_header_message('danger','Tambah Halaman','Gagal menambah Halaman');
				redirect(base_url(akses().'/cms/halaman'));
			}
		}else{
			$meta['judul']="Tambah Halaman";
			$this->load->view('tema/header',$meta);
			$this->load->view(akses().'/cms/halaman/halamanadd');
			$this->load->view('tema/footer');
		}
	}
	
	function edit()
	{
		$this->form_validation->set_rules('beritaid','ID Halaman','required');
		$this->form_validation->set_rules('judul','Judul Halaman','required');
		$this->form_validation->set_rules('isi','Isi Halaman','required');
		$this->form_validation->set_rules('status','Status Halaman','required');
		if($this->form_validation->run()==TRUE)
		{
			$beritaid=$this->input->post('beritaid');
			$judul=$this->input->post('judul');
			$isi=$this->input->post('isi');
			$status=$this->input->post('status');
			if($this->cms_model->halaman_edit($beritaid,$judul,$isi,$status)==TRUE)
			{
				set_header_message('success','Ubah Halaman','Berhasil mengubah Halaman');
				redirect(base_url(akses().'/cms/halaman'));
			}else{
				set_header_message('danger','Ubah Halaman','Gagal mengubah Halaman');
				redirect(base_url(akses().'/cms/halaman'));
			}
		}else{
			$id=$this->input->get('id');
			$meta['judul']="Ubah Halaman";
			$this->load->view('tema/header',$meta);
			$d['data']=$this->cms_model->konten_data(array('berita_id'=>$id,'jenis'=>'halaman'));
			$this->load->view(akses().'/cms/halaman/halamanedit',$d);
			$this->load->view('tema/footer');
		}
	}
	
	function delete()
	{
		$id=$this->input->get('id');
		if($this->cms_model->berita_delete($id)==TRUE)
		{
			set_header_message('success','Hapus Halaman','Berhasil menghapus Halaman');
			redirect(base_url(akses().'/cms/halaman'));
		}else{
			set_header_message('danger','Hapus Halaman','Gagal menghapus Halaman');
			redirect(base_url(akses().'/cms/halaman'));
		}
	}
}