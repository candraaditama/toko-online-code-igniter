<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('m_db');		
		if(akses()!="bos")
		{
			$this->login_model->user_logout();
		}
		$this->load->model('produk_model','mod_produk');
		$this->load->model('supplier_model','mod_supplier');
		$this->load->model('toko_model','mod_toko');
	}
	
	function index()
	{		
		$meta['judul']="Semua Produk";
		$this->load->view('tema/header',$meta);
		$d['data']=$this->mod_produk->produk_data();
		$this->load->view(akses().'/produk/produk/produkview',$d);
		$this->load->view('tema/footer');
	}
	
	function getdata()
	{
		$tipe=$this->input->get('tipe');
		if(!empty($tipe))
		{
			$tb="produk_".$tipe;
			if($tipe=="supplier")
			{
				$tb="supplier";
			}
			$d=$this->m_db->get_data($tb);
			echo json_encode($d);
		}else{
			echo json_encode(array());
		}
	}
	
	function add()
	{
		$this->form_validation->set_rules('kode','Kode Produk','required');
		$this->form_validation->set_rules('nama','Nama Produk','required');
		$this->form_validation->set_rules('supplier','Supplier Produk','required');
		$this->form_validation->set_rules('kategori','kategori Produk','required');
		$this->form_validation->set_rules('merek','merek Produk','required');
		$this->form_validation->set_rules('harga','harga Produk','required');
		$this->form_validation->set_rules('berat','berat Produk','required');
		$this->form_validation->set_rules('deskripsi','deskripsi Produk','required');
		$this->form_validation->set_rules('stok','Stok Produk','required');
		if($this->form_validation->run()==TRUE)
		{
			$kode=$this->input->post('kode',TRUE);
			$nama=$this->input->post('nama',TRUE);
			$supplier=$this->input->post('supplier',TRUE);
			$kategori=$this->input->post('kategori',TRUE);
			$merek=$this->input->post('merek',TRUE);
			$harga=$this->input->post('harga',TRUE);
			$berat=$this->input->post('berat',TRUE);
			$stok=$this->input->post('stok',TRUE);
			$deskripsi=$this->input->post('deskripsi',TRUE);
			$toko=$this->mod_toko->toko_pusat();
			$photo='upload';
			if($this->mod_produk->produk_add_single($toko,$kode,$nama,$supplier,$merek,$kategori,$deskripsi,$stok,$harga,$berat,$photo)==TRUE)
			{
				$produkid=$this->m_db->last_insert_id();
				set_header_message('success','Tambah Produk','Berhasil menambah produk');
				redirect(base_url(akses().'/produk/produk'),'refresh',301);
			}else{
				set_header_message('danger','Tambah Produk','Gagal menambah produk');
				redirect(base_url(akses().'/produk/produk/add'),'refresh',301);
			}
		}else{
			$meta['judul']="Tambah Produk";
			$this->load->view('tema/header',$meta);
			$this->load->view(akses().'/produk/produk/produkadd');
			$this->load->view('tema/footer');
		}		
	}
	
	function edit()
	{
		$this->form_validation->set_rules('produkid','ID Produk','required');
		$this->form_validation->set_rules('kode','Kode Produk','required');
		$this->form_validation->set_rules('nama','Nama Produk','required');
		$this->form_validation->set_rules('supplier','Supplier Produk','required');
		$this->form_validation->set_rules('kategori','kategori Produk','required');
		$this->form_validation->set_rules('merek','merek Produk','required');
		$this->form_validation->set_rules('harga','harga Produk','required');
		$this->form_validation->set_rules('berat','berat Produk','required');
		$this->form_validation->set_rules('deskripsi','deskripsi Produk','required');
		if($this->form_validation->run()==TRUE)
		{
			$produkid=$this->input->post('produkid',TRUE);
			$kode=$this->input->post('kode',TRUE);
			$nama=$this->input->post('nama',TRUE);
			$supplier=$this->input->post('supplier',TRUE);
			$kategori=$this->input->post('kategori',TRUE);
			$merek=$this->input->post('merek',TRUE);
			$harga=$this->input->post('harga',TRUE);
			$berat=$this->input->post('berat',TRUE);
			$deskripsi=$this->input->post('deskripsi',TRUE);
			$photo='upload';
			if($this->mod_produk->produk_edit($produkid,$kode,$nama,$supplier,$merek,$kategori,$deskripsi,$harga,$berat,$photo)==TRUE)
			{				
				set_header_message('success','Ubah Produk','Berhasil mengubah produk');
				redirect(base_url(akses().'/produk/produk'),'refresh',301);
			}else{
				set_header_message('danger','Ubah Produk','Gagal mengubah produk');
				redirect(base_url(akses().'/produk/produk'),'refresh',301);
			}
		}else{
			$id=$this->input->get('id',TRUE);
			$meta['judul']="Ubah Produk";
			$this->load->view('tema/header',$meta);
			$d['data']=$this->mod_produk->produk_data(array('produk_id'=>$id));
			$this->load->view(akses().'/produk/produk/produkedit',$d);
			$this->load->view('tema/footer');
		}		
	}
	
	function delete()
	{
		$produkid=$this->input->get('id',TRUE);
		if($this->mod_produk->produk_delete($produkid)==TRUE)
		{			
			set_header_message('success','Hapus Produk','Berhasil menghapus produk');
			redirect(base_url(akses().'/produk/produk'),'refresh',301);
		}else{
			set_header_message('danger','Hapus Produk','Gagal menghapus produk');
			redirect(base_url(akses().'/produk/produk'),'refresh',301);
		}
	}
}