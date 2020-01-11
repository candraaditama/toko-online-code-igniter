<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('m_db');
	}
	
	function index()
	{
		if(!empty(akses()))
		{
			if(akses()=="member")
			{
				redirect(base_url());
			}else{
				redirect(base_url());
			}
		}else{
			redirect(base_url().'member/login');
		}		
	}
	
	function login()
	{
		$meta['judul']="Member Login | ".baca_konfig('nama-aplikasi');
		$meta['judulhalaman']="Member Login";
		$meta['homepage']=FALSE;
		$this->load->view('html/header',$meta);
		$this->load->view('html/loginview');
		$this->load->view('html/footer');
	}
	
	function daftar()
	{
		$this->form_validation->set_rules('nama','Nama Lengkap Anda','required');
		$this->form_validation->set_rules('hp','Nomor Handphone','required');
		$this->form_validation->set_rules('alamat','Alamat','required');
		$this->form_validation->set_rules('kota','Kota','required');
		$this->form_validation->set_rules('email','Email','required');
		$this->form_validation->set_rules('username','Username','required');
		$this->form_validation->set_rules('password','Password','required');
		if($this->form_validation->run()==TRUE)
		{
			$nama=$this->input->post('nama',TRUE);			
			$hp=$this->input->post('hp',TRUE);			
			$alamat=$this->input->post('alamat',TRUE);			
			$kota=$this->input->post('kota',TRUE);			
			$email=$this->input->post('email',TRUE);
			$username=$this->input->post('username',TRUE);
			$password=$this->input->post('password',TRUE);
			$this->load->model('login_model');
			if($this->login_model->user_daftar($nama,$username,$password,"member")==TRUE)
			{
				$userid=$this->m_db->last_insert_id();
				$d=array(
				'nama_pelanggan'=>$nama,
				'alamat'=>$alamat,
				'hp'=>$hp,
				'email'=>$email,
				'kota'=>$kota,
				'user_id'=>$userid,
				);
				if($this->m_db->add_row('pelanggan',$d)==TRUE)
				{
					redirect(base_url().'member/login');
				}else{
					$s=array(
					'user_id'=>$userid,
					);
					$this->m_db->delete_row('userlogin',$s);
					redirect(base_url().'member/daftar');
				}
			}else{
				redirect(base_url().'member/daftar');
			}
		}else{
			$meta['judul']="Member Register | ".baca_konfig('nama-aplikasi');
			$meta['judulhalaman']="Member Register";
			$meta['homepage']=FALSE;
			$this->load->view('html/header',$meta);
			$this->load->view('html/registerview');
			$this->load->view('html/footer');
		}		
	}
}