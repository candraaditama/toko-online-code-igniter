<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stok extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('m_db');		
		if(akses()!="op")
		{
			$this->login_model->user_logout();
		}
		$this->load->model('produk_model','mod_produk');
		$this->load->model('toko_model','mod_toko');
	}
	
	function index()
	{
		$this->form_validation->set_rules('produkid','ID Produk','required');
		$this->form_validation->set_rules('tokoid','ID TOKO','required');
		$this->form_validation->set_rules('info[][]',"Warna",'required');
		if($this->form_validation->run()==TRUE)
		{
			$produkid=$this->input->post('produkid',TRUE);
			$tokoid=$this->input->post('tokoid',TRUE);
			$count=count($_POST['info']['ukuran']);
			$output=array();
			for($i=0;$i<$count;$i++)
			{
				$output[]=array(
				'produk_id'=>$produkid,
				'toko_id'=>$tokoid,
				'ukuran'=>$_POST['info']['ukuran'][$i],
				'warna'=>$_POST['info']['warna'][$i],
				'stok'=>$_POST['info']['stok'][$i],
				);
			}
			$nama=produk_info($produkid,'nama_produk');
			if($this->mod_produk->produk_add_stok($tokoid,$produkid,$output)==TRUE)
			{
				
				set_header_message('success',"Tambah Stok Produk",'Berhasil menambah stok '.$nama);
				redirect(base_url(akses().'/produk/produk'));
			}else{
				set_header_message('danger',"Tambah Stok Produk",'Gagal menambah stok '.$nama);
				redirect(base_url(akses().'/produk/produk'));
			}
		}else{
			
		
		$id=$this->input->get('id',TRUE);
		$nama=produk_info($id,'nama_produk');
		if(!empty($nama))
		{
			$meta['judul']="Tambah Stok";
			$this->load->view('tema/header',$meta);
			$pusat=$this->mod_toko->toko_pusat();
			$toko=user_info('toko_id');
			if(empty($toko))
			{
				$toko=$pusat;
			}
			$d['tokoid']=$toko;
			$d['data']=$this->mod_produk->produk_data(array('produk_id'=>$id));
			$this->load->view(akses().'/produk/stok/stokadd',$d);
			$this->load->view('tema/footer');
		}else{
			redirect(base_url(akses().'/produk/produk'));
		}	
		
		}
	}
}