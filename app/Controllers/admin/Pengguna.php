<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('m_db');
		$this->load->model('login_model');
	}
	
	function index()
	{
		$meta['judul']="Semua Pengguna";
		$this->load->view('tema/header',$meta);		
		$d['data']=$this->login_model->user_data(array('akses !='=>'admin'));
		$this->load->view(akses().'/pengguna/penggunaview',$d);
		$this->load->view('tema/footer');
	}
	
	function add()
	{
		$this->form_validation->set_rules('nama','Nama Lengkap','required');
		$this->form_validation->set_rules('username','Username','required');
		$this->form_validation->set_rules('password','Password','required');
		$this->form_validation->set_rules('akses','Akses','required');
		if($this->form_validation->run()==TRUE)
		{
			$nama=$this->input->post('nama',TRUE);
			$username=$this->input->post('username',TRUE);
			$password=$this->input->post('password',TRUE);
			$akses=$this->input->post('akses',TRUE);
			if($this->login_model->user_daftar($nama,$username,$password,$akses)==TRUE)
			{
				set_header_message('success','Tambah Pengguna','Berhasil menambahkan pengguna');
				redirect(base_url(akses().'/pengguna'));
			}else{
				set_header_message('danger','Tambah Pengguna','Gagal menambahkan pengguna');
				redirect(base_url(akses().'/pengguna/add'));
			}
		}else{
			$meta['judul']="Tambah Pengguna";
			$this->load->view('tema/header',$meta);		
			$d['akses']=$this->login_model->user_akses_data();
			$this->load->view(akses().'/pengguna/penggunaadd',$d);
			$this->load->view('tema/footer');
		}
	}
	
	function edit()
	{
		$this->form_validation->set_rules('userid','ID User','required');
		$this->form_validation->set_rules('nama','Nama Lengkap','required');
		$this->form_validation->set_rules('username','Username','required');		
		$this->form_validation->set_rules('akses','Akses','required');
		if($this->form_validation->run()==TRUE)
		{
			$userid=$this->input->post('userid',TRUE);
			$nama=$this->input->post('nama',TRUE);
			$username=$this->input->post('username',TRUE);
			$password=$this->input->post('password',TRUE);
			$akses=$this->input->post('akses',TRUE);
			if($this->login_model->user_edit($userid,$nama,$username,$password,$akses)==TRUE)
			{
				set_header_message('success','Ubah Pengguna','Berhasil mengubah pengguna');
				redirect(base_url(akses().'/pengguna'));
			}else{
				set_header_message('danger','Ubah Pengguna','Gagal mengubah pengguna');
				redirect(base_url(akses().'/pengguna'));
			}
		}else{
			$id=$this->input->get('id');
			$meta['judul']="Ubah Pengguna";
			$this->load->view('tema/header',$meta);		
			$d['akses']=$this->login_model->user_akses_data();
			$d['data']=$this->login_model->user_data(array('user_id'=>$id));
			$this->load->view(akses().'/pengguna/penggunaedit',$d);
			$this->load->view('tema/footer');
		}
	}
	
	function delete()
	{
		$id=$this->input->get('id');
		if($this->login_model->user_delete($id)==TRUE)
		{
			set_header_message('success','Hapus Pengguna','Berhasil menghapus pengguna');
			redirect(base_url(akses().'/pengguna'));
		}else{
			set_header_message('danger','Hapus Pengguna','Gagal menghapus pengguna');
			redirect(base_url(akses().'/pengguna'));
		}
	}
}