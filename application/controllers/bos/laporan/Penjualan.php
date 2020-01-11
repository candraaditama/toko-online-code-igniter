<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('m_db');		
		if(akses()!="bos")
		{
			$this->login_model->user_logout();
		}
		$this->load->model('toko_model','mod_toko');
	}
		
	
	function index()
	{		
		$meta['judul']="Laporan Penjualan";
		$this->load->view('tema/header',$meta);
		$this->load->view(akses().'/laporan/penjualanview');
		$this->load->view('tema/footer');
	}
	
	function periode()
	{
		$this->form_validation->set_rules('t1','Dari Tanggal','required');
		$this->form_validation->set_rules('t2','Hingga Tanggal','required');
		if($this->form_validation->run()==TRUE)
		{
			$t1=$this->input->post('t1');
			$t2=$this->input->post('t2');
			$meta['judul']="Laporan Penjualan Barang";
			$meta['deskripsi']="Periode ".date("d-m-Y",strtotime($t1))." hingga ".date("d-m-Y",strtotime($t2));
			$this->load->view(akses().'/laporan/template_laporan/header',$meta);
			$sql="Select * FROM penjualan where DATE(tanggal) BETWEEN '$t1' AND '$t2' AND status='lunas' ORDER BY tanggal DESC";
			$d['data']=$this->m_db->get_query_data($sql);
			$this->load->view(akses().'/laporan/penjualan/detailview',$d);
			$this->load->view(akses().'/laporan/template_laporan/footer');
		}else{
			redirect(base_url(akses().'/laporan/penjualan'));
		}
	}
	
	function bulanan()
	{
		$this->form_validation->set_rules('bulan','Bulan','required');
		$this->form_validation->set_rules('tahun','Tahun','required');
		if($this->form_validation->run()==TRUE)
		{
			$t1=$this->input->post('bulan');
			$t2=$this->input->post('tahun');
			$meta['judul']="Laporan Penjualan Barang";
			$namaBulan=date_month_name($t1);
			$meta['deskripsi']="Bulan ".$namaBulan." Tahun ".$t2;
			$this->load->view(akses().'/laporan/template_laporan/header',$meta);
			$sql="Select * FROM penjualan where MONTH(tanggal)='$t1' AND YEAR(tanggal)='$t2' AND status='lunas' ORDER BY tanggal DESC";
			$d['data']=$this->m_db->get_query_data($sql);
			$this->load->view(akses().'/laporan/penjualan/detailview',$d);
			$this->load->view(akses().'/laporan/template_laporan/footer');
		}else{
			redirect(base_url(akses().'/laporan/penjualan'));
		}
	}
	
	function produk()
	{
		$this->form_validation->set_rules('t1','Dari Tanggal','required');
		$this->form_validation->set_rules('t2','Hingga Tanggal','required');
		$this->form_validation->set_rules('produk','ID Produk','required');
		if($this->form_validation->run()==TRUE)
		{
			$pro=$this->input->post('produk');
			$t1=$this->input->post('t1');
			$t2=$this->input->post('t2');
			$namaProduk=field_value('produk','produk_id',$pro,'nama_produk');
			$meta['judul']="Laporan Penjualan Barang";
			$meta['deskripsi']=$namaProduk."<br/>Periode ".date("d-m-Y",strtotime($t1))." hingga ".date("d-m-Y",strtotime($t2));
			$this->load->view(akses().'/laporan/template_laporan/header',$meta);
			$sql="Select * FROM penjualan_detail LEFT JOIN penjualan ON penjualan_detail.penjualan_id = penjualan.penjualan_id where DATE(penjualan.tanggal) BETWEEN '$t1' AND '$t2' AND penjualan.status='lunas' AND penjualan_detail.produk_id='$pro' ORDER BY penjualan.tanggal DESC";
			$d['data']=$this->m_db->get_query_data($sql);
			$this->load->view(akses().'/laporan/penjualan/detailview',$d);
			$this->load->view(akses().'/laporan/template_laporan/footer');
		}else{
			redirect(base_url(akses().'/laporan/penjualan'));
		}
	}
}