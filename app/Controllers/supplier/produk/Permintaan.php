<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permintaan extends CI_Controller {

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
		$meta['judul']="Permintaan Produk";
		$this->load->view('tema/header',$meta);
		$d['data']=$this->m_db->get_data('pembelian',array('supplier_id'=>$supplierid,'status'=>'daftar'));
		$this->load->view(akses().'/produk/permintaan/permintaanview',$d);
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
	
	function proses()
	{
		$this->form_validation->set_rules('pembelianid','ID Pembelian','required');
		if($this->form_validation->run()==TRUE)
		{
			$pembelianid=$this->input->post('pembelianid');
			$sBeli=array(
			'pembelian_id'=>$pembelianid,
			);
			$dBeli=$this->m_db->get_data('pembelian_detail',$sBeli);
			$pusat=$this->mod_toko->toko_pusat();
			if(!empty($dBeli))
			{
				foreach($dBeli as $rBeli)
				{
					$produkID=$rBeli->produk_id;					
					$lastBeli=field_value('produk','produk_id',$produkID,'jumlah_beli');
					$newBeli=$lastBeli+$rBeli->qty;
					$sStok=array(
					'toko_id'=>$pusat,
					'produk_id'=>$produkID,
					);
					$lastStok=$this->m_db->get_row('produk_stok',$sStok,'stok');
					$newStok=$lastStok+$rBeli->qty;
					$sProduk1=array(
					'produk_id'=>$produkID,
					);
					$dBeli1=array(
					'jumlah_beli'=>$newBeli,
					);
					$this->m_db->edit_row('produk',$dBeli1,$sProduk1);
					
					$dBeli2=array(
					'stok'=>$newStok,
					);
					$this->m_db->edit_row('produk_stok',$dBeli2,$sStok);
				}
				$dStatus=array(
				'status'=>'selesai',
				);
				$this->m_db->edit_row('pembelian',$dStatus,$sBeli);
				set_header_message('success','Proses Permintaan','Berhasil memproses permintaan produk');
				redirect(base_url(akses().'/produk/permintaan'));
			}else{
				set_header_message('danger','Proses Permintaan','Gagal memproses permintaan produk');
				redirect(base_url(akses().'/produk/permintaan'));
			}
		}else{
			$meta['judul']="Detail Permintaan Produk";
			$this->load->view('tema/header',$meta);
			$d['data']=$this->m_db->get_data('pembelian',array('status'=>'daftar','pembelian_id'=>$this->input->get('id')));
			$this->load->view(akses().'/produk/permintaan/permintaanproses',$d);
			$this->load->view('tema/footer');
		}
	}
}