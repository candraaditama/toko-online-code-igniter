<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('m_db');		
		if(akses()!="op")
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
	
	function buatakun()
	{
		$this->form_validation->set_rules('supplierid','ID Supplier','required');
		$this->form_validation->set_rules('username','Username','required');
		$this->form_validation->set_rules('nama','Nama Supplier','required');
		if($this->form_validation->run()==TRUE)
		{
			$username=$this->input->post('username',TRUE);
			$nama=$this->input->post('nama',TRUE);
			$password=$this->input->post('password',TRUE);
			$supplierid=$this->input->post('supplierid',TRUE);
			$userid=$this->input->post('userid');
			
			$sUser=array(
			'user_id'=>$userid,
			);
			if($this->m_db->is_bof('userlogin',$sUser)==TRUE)
			{
				$sUser2=array(
				'username'=>$username,
				);
				if($this->m_db->is_bof('userlogin',$sUser2)==TRUE)
				{
					$dUser=array(
					'nama'=>$nama,
					'username'=>$username,
					'password'=>md5($password),
					'akses'=>'supplier',
					);
					if($this->m_db->add_row('userlogin',$dUser)==TRUE)
					{
						$userIDNew=$this->m_db->last_insert_id();
						$dSupUser=array(
						'user_id'=>$userIDNew,
						);
						$sSup=array(
						'supplier_id'=>$supplierid,
						);
						$this->m_db->edit_row('supplier',$dSupUser,$sSup);
					}else{
						set_header_message('danger','User Supplier','Gagal set user Supplier');
						redirect(base_url(akses().'/mitra/supplier'),'refresh',301);
					}
				}else{
					set_header_message('danger','User Supplier','Gagal set user Supplier');
					redirect(base_url(akses().'/mitra/supplier'),'refresh',301);
				}
				
			}else{
				$dH=array();
				if(!empty($password))
				{
					$dH=array(
					'username'=>$username,
					'nama'=>$nama,
					'password'=>md5($password),
					);
				}else{
					$dH=array(
					'username'=>$username,
					'nama'=>$nama,
					);
				}
				$this->m_db->edit_row('userlogin',$dH,$sUser);
			}	
			set_header_message('success','User Supplier','Berhasil set user Supplier');
			redirect(base_url(akses().'/mitra/supplier'),'refresh',301);
		}else{
			$id=$this->input->get('id',TRUE);
			$meta['judul']="Akun Supplier";
			$this->load->view('tema/header',$meta);
			$d['data']=$this->mod_supplier->supplier_data(array('supplier_id'=>$id));
			$this->load->view(akses().'/mitra/supplier/supplierakun',$d);
			$this->load->view('tema/footer');
		}
	}
}