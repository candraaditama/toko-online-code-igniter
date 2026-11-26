<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('m_db');		
		if(akses()!="bos")
		{
			$this->login_model->user_logout();
		}
		$this->load->model('supplier_model','mod_supplier');
		if(toko_user()!=toko_pusat())
		{
			redirect(base_url(akses().'/dashboard'));
		}
	}
	
	function index()
	{		
		$meta['judul']="Semua Supplier";
		$this->load->view('tema/header',$meta);
		$d['data']=$this->mod_supplier->supplier_data();
		$this->load->view(akses().'/mitra/supplier/supplierview',$d);
		$this->load->view('tema/footer');
	}
	
	function add()
	{
		$this->form_validation->set_rules('nama','Nama Supplier','required');
		$this->form_validation->set_rules('telepon','Telepon Supplier','required');
		if($this->form_validation->run()==TRUE)
		{
			$nama=$this->input->post('nama',TRUE);
			$alamat=$this->input->post('alamat',TRUE);
			$telepon=$this->input->post('telepon',TRUE);
			
			if($this->mod_supplier->supplier_add($nama,$alamat,$telepon)==TRUE)
			{
				set_header_message('success','Tambah Supplier','Berhasil menambahkan Supplier');
				redirect(base_url(akses().'/mitra/supplier'),'refresh',301);
			}else{
				set_header_message('danger','Tambah Supplier','Gagal menambahkan Supplier');
				redirect(base_url(akses().'/mitra/supplier'),'refresh',301);
			}			
		}else{
			redirect(base_url(akses().'/mitra/supplier'),'refresh',301);
		}
	}
	
	function edit()
	{
		$this->form_validation->set_rules('supplierid','ID Supplier','required');
		$this->form_validation->set_rules('nama','Nama Supplier','required');
		$this->form_validation->set_rules('telepon','Telepon Supplier','required');
		if($this->form_validation->run()==TRUE)
		{
			$supplierid=$this->input->post('supplierid',TRUE);
			$nama=$this->input->post('nama',TRUE);
			$alamat=$this->input->post('alamat',TRUE);
			$telepon=$this->input->post('telepon',TRUE);
			
			if($this->mod_supplier->supplier_edit($supplierid,$nama,$alamat,$telepon)==TRUE)
			{
				set_header_message('success','Ubah Supplier','Berhasil mengubah Supplier');
				redirect(base_url(akses().'/mitra/supplier'),'refresh',301);
			}else{
				set_header_message('danger','Ubah Supplier','Gagal mengubah Supplier');
				redirect(base_url(akses().'/mitra/supplier'),'refresh',301);
			}			
		}else{
			$id=$this->input->get('id',TRUE);
			$meta['judul']="Ubah Supplier";
			$this->load->view('tema/header',$meta);
			$d['data']=$this->mod_supplier->supplier_data(array('supplier_id'=>$id));
			$this->load->view(akses().'/mitra/supplier/supplieredit',$d);
			$this->load->view('tema/footer');
		}
	}
	
	function delete()
	{
		$id=$this->input->get('id',TRUE);
		if($this->mod_supplier->supplier_delete($id)==TRUE)
		{
			set_header_message('success','Hapus Supplier','Berhasil menghapus Supplier');
			redirect(base_url(akses().'/mitra/supplier'),'refresh',301);
		}else{
			set_header_message('danger','Hapus Supplier','Gagal menghapus Supplier');
			redirect(base_url(akses().'/mitra/supplier'),'refresh',301);
		}
	}
}