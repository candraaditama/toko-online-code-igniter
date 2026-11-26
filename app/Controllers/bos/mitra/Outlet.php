<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Outlet extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('m_db');		
		if(akses()!="bos")
		{
			$this->login_model->user_logout();
		}
		$this->load->model('toko_model','mod_toko');
		if(toko_user()!=toko_pusat())
		{
			redirect(base_url(akses().'/dashboard'));
		}
	}
		
	
	function index()
	{		
		$meta['judul']="Daftar Toko Outlet/Cabang";
		$this->load->view('tema/header',$meta);
		$d['data']=$this->mod_toko->toko_data(array('tipe'=>'cabang'));
		$this->load->view(akses().'/mitra/outlet/outletview',$d);
		$this->load->view('tema/footer');
	}
	
	function add()
	{
		$this->form_validation->set_rules('nama','Nama Toko','required');
		$this->form_validation->set_rules('telepon','Telepon Toko','required');
		$this->form_validation->set_rules('kota','Kota Toko','required');
		if($this->form_validation->run()==TRUE)
		{
			$nama=$this->input->post('nama',TRUE);
			$alamat=$this->input->post('alamat',TRUE);
			$telepon=$this->input->post('telepon',TRUE);
			$kota=$this->input->post('kota',TRUE);
			$tipe='cabang';
			
			if($this->mod_toko->toko_add($nama,$alamat,$telepon,$kota,$tipe)==TRUE)
			{
				set_header_message('success','Tambah Toko','Berhasil menambahkan Toko');
				redirect(base_url(akses().'/mitra/outlet'),'refresh',301);
			}else{
				set_header_message('danger','Tambah Toko','Gagal menambahkan Toko');
				redirect(base_url(akses().'/mitra/outlet'),'refresh',301);
			}			
		}else{
			redirect(base_url(akses().'/mitra/outlet'),'refresh',301);
		}
	}
	
	function edit()
	{
		$this->form_validation->set_rules('tokoid','ID Toko','required');
		$this->form_validation->set_rules('nama','Nama Toko','required');
		$this->form_validation->set_rules('telepon','Telepon Toko','required');
		$this->form_validation->set_rules('kota','Kota Toko','required');
		if($this->form_validation->run()==TRUE)
		{
			$tokoID=$this->input->post('tokoid',TRUE);
			$nama=$this->input->post('nama',TRUE);
			$alamat=$this->input->post('alamat',TRUE);
			$telepon=$this->input->post('telepon',TRUE);
			$kota=$this->input->post('kota',TRUE);
			$tipe='cabang';
			if($this->mod_toko->toko_edit($tokoID,$nama,$alamat,$telepon,$kota)==TRUE)
			{
				set_header_message('success','Ubah Toko','Berhasil mengubah Toko');
				redirect(base_url(akses().'/mitra/outlet'),'refresh',301);
			}else{
				set_header_message('danger','Ubah Toko','Gagal mengubah Toko');
				redirect(base_url(akses().'/mitra/outlet'),'refresh',301);
			}			
		}else{
			$id=$this->input->get('id',TRUE);
			$meta['judul']="Ubah Toko";
			$this->load->view('tema/header',$meta);
			$d['data']=$this->mod_toko->toko_data(array('toko_id'=>$id));
			$this->load->view(akses().'/mitra/outlet/outletedit',$d);
			$this->load->view('tema/footer');
		}
	}
	
	function delete()
	{
		$id=$this->input->get('id',TRUE);
		if($this->mod_toko->toko_delete($id)==TRUE)
		{
			set_header_message('success','Hapus Toko','Berhasil menghapus Toko');
			redirect(base_url(akses().'/mitra/outlet'),'refresh',301);
		}else{
			set_header_message('danger','Hapus Toko','Gagal menghapus Toko');
			redirect(base_url(akses().'/mitra/outlet'),'refresh',301);
		}
	}
	
	function pengguna()
	{
		$id=$this->input->get('id',TRUE);
		$nama=toko_info($id,'nama_toko');
		$meta['judul']="Pengguna Toko ".$nama;
		$this->load->view('tema/header',$meta);
		$d['tokoid']=$id;
		$d['data']=$this->mod_toko->toko_user_data($id);
		$this->load->view(akses().'/mitra/outlet/outletuser',$d);
		$this->load->view('tema/footer');
	}
	
	function penggunaadd()
	{
		$this->form_validation->set_rules('tokoid','ID Toko','required');
		$this->form_validation->set_rules('nama','Nama Lengkap','required');
		$this->form_validation->set_rules('username','Username','required');
		$this->form_validation->set_rules('password','Password','required');
		$this->form_validation->set_rules('akses','Akses','required');
		if($this->form_validation->run()==TRUE)
		{
			$tokoid=$this->input->post('tokoid',TRUE);
			$nama=$this->input->post('nama',TRUE);
			$username=$this->input->post('username',TRUE);
			$password=$this->input->post('password',TRUE);
			$akses=$this->input->post('akses',TRUE);
			if($this->mod_toko->toko_user_add($tokoid,$nama,$username,$password,$akses)==TRUE)
			{
				set_header_message('success','Tambah Pengguna','Berhasil menambahkan pengguna');
				redirect(base_url(akses().'/mitra/outlet/pengguna').'?id='.$tokoid);
			}else{
				set_header_message('danger','Tambah Pengguna','Gagal menambahkan pengguna');
				redirect(base_url(akses().'/mitra/outlet/pengguna').'?id='.$tokoid);
			}
		}else{
			redirect(base_url(akses().'/mitra/outlet/pengguna').'?id='.$tokoid);
		}
	}
	
	function penggunadelete()
	{
		$id=$this->input->get('id');
		$tokoid=field_value('userlogin','user_id',$id,'toko_id');
		if($this->mod_toko->toko_user_delete($id)==TRUE)
		{
			set_header_message('success','Hapus Pengguna','Berhasil menghapus pengguna');
			redirect(base_url(akses().'/mitra/outlet/pengguna').'?id='.$tokoid);
		}else{
			set_header_message('danger','Hapus Pengguna','Gagal menghapus pengguna');
			redirect(base_url(akses().'/mitra/outlet/pengguna').'?id='.$tokoid);
		}
	}
}