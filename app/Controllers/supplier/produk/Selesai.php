<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Selesai extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('m_db');		
		if(akses()!="supplier")
		{
			$this->login_model->user_logout();
		}
		$this->load->model('toko_model','mod_toko');
	}
		
	
	function index()
	{		
		$supplierid=field_value('supplier','user_id',user_info('user_id'),'supplier_id');
		$meta['judul']="Permintaan Produk Yang selesai";
		$this->load->view('tema/header',$meta);
		$d['data']=$this->m_db->get_data('pembelian',array('supplier_id'=>$supplierid,'status'=>'selesai'));
		$this->load->view(akses().'/produk/selesaiview',$d);
		$this->load->view('tema/footer');
	}
	
	function detail()
	{
		$meta['judul']="Detail Permintaan Produk";
		$this->load->view('tema/header',$meta);
		$d['data']=$this->m_db->get_data('pembelian',array('pembelian_id'=>$this->input->get('id')));
		$this->load->view(akses().'/produk/permintaan/permintaandetail',$d);
		$this->load->view('tema/footer');
	}
}