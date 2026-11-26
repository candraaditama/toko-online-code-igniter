<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permintaan extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('m_db');		
		if(akses()!="op")
		{
			$this->login_model->user_logout();
		}		
	}		
	
	function index()
	{		
		$meta['judul']="Permintaan Produk";
		$this->load->view('tema/header',$meta);
		$d['data']=$this->m_db->get_data('pembelian');
		$this->load->view(akses().'/transaksi/permintaan/permintaanview',$d);
		$this->load->view('tema/footer');
	}
	
	function add()
	{
		$this->form_validation->set_rules('supplierid','ID Supplier','required');
		$this->form_validation->set_rules('tanggal','Tanggal','required');
		if($this->form_validation->run()==TRUE)
		{
			$supplier=$this->input->post('supplierid');
			$tanggal=$this->input->post('tanggal');
			$s=array(
			'tanggal'=>$tanggal,
			'supplier_id'=>$supplier,
			);
			if($this->m_db->is_bof('pembelian_temp',$s)==FALSE)
			{				
				$d1=array(
				'tanggal'=>$tanggal." ".date("H:i:s"),
				'supplier_id'=>$supplier,
				'user_id'=>user_info('user_id'),
				'status'=>'daftar',
				);
				if($this->m_db->add_row('pembelian',$d1)==TRUE)
				{
					$pembelianID=$this->m_db->last_insert_id();
					$d=$this->m_db->get_data('pembelian_temp',$s);
					foreach($d as $r){
						$d2=array(
						'pembelian_id'=>$pembelianID,
						'produk_id'=>$r->produk_id,
						'qty'=>$r->jumlah,
						);
						$this->m_db->add_row('pembelian_detail',$d2);
					}
					$this->m_db->delete_row('pembelian_temp',$s);
					set_header_message('success','Tambah Permintaan produk','berhasil menambahkan data transaksi');
					redirect(base_url(akses().'/transaksi/permintaan'));
				}else{
					set_header_message('danger','Tambah Permintaan produk','Gagal menambahkan data transaksi');
					redirect(base_url(akses().'/transaksi/permintaan/add'));
				}
			}else{
				set_header_message('danger','Tambah Permintaan produk','Gagal menambahkan data transaksi');
				redirect(base_url(akses().'/transaksi/permintaan/add'));
			}
		}else{
			$meta['judul']="Permintaan Produk";
			$this->load->view('tema/header',$meta);
			$d['supplier']=$this->m_db->get_data('supplier',array(),'nama_supplier ASC');
			$d['produk']=$this->m_db->get_data('produk',array(),'nama_produk ASC');
			$this->load->view(akses().'/transaksi/permintaan/permintaanadd',$d);
			$this->load->view('tema/footer');
		}
	}
	
	function getlist()
	{
		$tanggal=$this->input->get('tanggal');
		$supplier=$this->input->get('supplier');
		$s=array(
		'tanggal'=>$tanggal,
		'supplier_id'=>$supplier,
		);
		$d['data']=$this->m_db->get_data('pembelian_temp',$s);
		$this->load->view(akses().'/transaksi/permintaan/permintaandata',$d);
	}
	
	function additem()
	{
		$tanggal=$this->input->get('tanggal');
		$supplier=$this->input->get('supplier');
		$produk=$this->input->get('produk');
		$jumlah=$this->input->get('jumlah');
		$s=array(
		'tanggal'=>$tanggal,
		'supplier_id'=>$supplier,
		'produk_id'=>$produk,
		);
		if($this->m_db->is_bof('pembelian_temp',$s)==TRUE)
		{
			$d=array(
			'tanggal'=>$tanggal,
			'supplier_id'=>$supplier,
			'produk_id'=>$produk,
			'jumlah'=>$jumlah,
			);
			if($this->m_db->add_row('pembelian_temp',$d)==TRUE)
			{
				echo json_encode(array('status'=>'ok'));
			}else{
				echo json_encode(array('status'=>'no'));
			}
		}else{
			$lastJumlah=$this->m_db->get_row('pembelian_temp',$s,'jumlah');
			$newJumlah=$lastJumlah+$jumlah;
			$d=array(
			'jumlah'=>$newJumlah,
			);
			if($this->m_db->edit_row('pembelian_temp',$d,$s)==TRUE)
			{
				echo json_encode(array('status'=>'ok'));
			}else{
				echo json_encode(array('status'=>'no'));
			}
		}
	}
	
	function deleteitem()
	{
		$id=$this->input->get('id');
		$s=array(
		'pembelian_temp_id'=>$id,
		);
		$this->m_db->delete_row('pembelian_temp',$s);
		echo json_encode(array('status'=>'ok'));
	}
	
	function detail()
	{
		$meta['judul']="Detail Permintaan Produk";
		$this->load->view('tema/header',$meta);
		$d['data']=$this->m_db->get_data('pembelian',array('pembelian_id'=>$this->input->get('id')));
		$this->load->view(akses().'/transaksi/permintaan/permintaandetail',$d);
		$this->load->view('tema/footer');
	}
}