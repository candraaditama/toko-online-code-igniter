<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akun extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('m_db');
		if(akses()!="member")
		{
			redirect(base_url());
		}
	}
	
	function index()
	{
		
		$this->form_validation->set_rules('nama','Nama Lengkap Anda','required');
		$this->form_validation->set_rules('hp','Nomor Handphone','required');
		$this->form_validation->set_rules('alamat','Alamat','required');
		$this->form_validation->set_rules('kota','Kota','required');
		$this->form_validation->set_rules('email','Email','required');
		if($this->form_validation->run()==TRUE)
		{
			$pelangganid=pelanggan_info('pelanggan_id');
			$nama=$this->input->post('nama',TRUE);			
			$hp=$this->input->post('hp',TRUE);			
			$alamat=$this->input->post('alamat',TRUE);			
			$kota=$this->input->post('kota',TRUE);			
			$email=$this->input->post('email',TRUE);
			$s=array(
			'pelanggan_id'=>$pelangganid,
			);
			$userid=pelanggan_info('user_id');
			$d=array(
			'nama_pelanggan'=>$nama,
			'alamat'=>$alamat,
			'hp'=>$hp,
			'email'=>$email,
			'kota'=>$kota,			
			);
			if($this->m_db->edit_row('pelanggan',$d,$s)==TRUE)
			{
				$s2=array(
				'user_id'=>$userid,
				);
				$d2=array(
				'nama'=>$nama,
				);
				$this->m_db->edit_row('userlogin',$d2,$s2);
				redirect(base_url().'akun');
			}else{
				redirect(base_url().'akun');
			}
		}else{
			$meta['judul']="Profil | ".baca_konfig('nama-aplikasi');
			$meta['judulhalaman']="Profil";
			$meta['homepage']=FALSE;
			$this->load->view('html/header',$meta);
			$this->load->view('html/profilview');
			$this->load->view('html/footer');
		}		
	}
	
	function histori()
	{
		$meta['judul']="Histori Belanja | ".baca_konfig('nama-aplikasi');
		$meta['judulhalaman']="Histori Belanja";
		$meta['homepage']=FALSE;
		$this->load->view('html/header',$meta);
		$pelangganid=pelanggan_info('pelanggan_id');
		$d['data']=$this->m_db->get_data('penjualan',array('pelanggan_id'=>$pelangganid));
		$this->load->view('html/page/historiview',$d);
		$this->load->view('html/footer');
	}
	
}