<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mutasi extends CI_Controller {

	private $is_pusat=FALSE;
	function __construct()
	{
		parent::__construct();
		$this->load->library('m_db');		
		if(akses()!="bos")
		{
			$this->login_model->user_logout();
		}
		if(toko_user()==toko_pusat())
		{
			$this->is_pusat=TRUE;
		}
		$this->load->model('transaksi_model','mod_trans');
		$this->load->model('toko_model','mod_toko');
	}
		
	
	function index()
	{		
		$meta['judul']="Mutasi Stok";
		$this->load->view('tema/header',$meta);
		if($this->is_pusat)
		{
			$d['data']=$this->mod_trans->mutasi_data();
			$this->load->view(akses().'/transaksi/mutasi/mutasiview',$d);
		}else{
			$d['data']=$this->mod_trans->mutasi_data(array('toko_id'=>toko_user()));
			$this->load->view(akses().'/transaksi/mutasi/mutasimitraview',$d);
		}
		$this->load->view('tema/footer');
	}
	
	function getproduk()
	{
		$pusat=toko_pusat();
		$stok=toko_stok($pusat,'produk_id');
		if(!empty($stok))
		{
			$output=array();
			foreach($stok as $rstok)
			{
				$nama=produk_info($rstok->produk_id,'nama_produk');
				$output[]=array(
				'produk_id'=>$rstok->produk_id,
				'nama_produk'=>$nama,
				);
			}
			echo json_encode($output);
		}else{
			echo json_encode(array());
		}
	}
	
	function getprodukdetail()
	{
		$id=$this->input->get('id',TRUE);
		$d['produkid']=$id;
		$d['tokoid']=toko_pusat();
		$this->load->view(akses().'/transaksi/mutasi/detailproduk',$d);
	}
	
	function getdata()
	{
		$d=$this->mod_toko->toko_data(array('tipe'=>'cabang'));
		if(!empty($d))
		{
			echo json_encode($d);
		}else{
			echo json_encode(array());
		}
	}
	
	function add()
	{
		if($this->is_pusat)
		{
			$this->form_validation->set_rules('toko','ID Toko','required');
			$this->form_validation->set_rules('tanggal','Tanggal Transaksi','required');
			$this->form_validation->set_rules('info[][]','Informasi Mutasi','required');
			if($this->form_validation->run()==TRUE)
			{
				$toko=$this->input->post('toko');
				$tanggal=$this->input->post('tanggal');
				$keterangan=$this->input->post('keterangan');
				$count=count($_POST['info']['ukuran']);
				$output=array();
				for($i=0;$i<$count;$i++)
				{
					$output[]=array(
					'produkid'=>$_POST['info']['produkid'][$i],
					'tokoid'=>$toko,
					'ukuranid'=>$_POST['info']['ukuran'][$i],
					'warnaid'=>$_POST['info']['warna'][$i],
					'qty'=>$_POST['info']['qty'][$i],
					);
				}
				
				if($this->mod_trans->mutasi_add($toko,$tanggal,$keterangan,$output)==TRUE)
				{
					set_header_message('success','Tambah Mutasi','Berhasil Tambah Mutasi Stok');
					redirect(base_url(akses().'/transaksi/mutasi'));
				}else{
					set_header_message('danger','Tambah Mutasi','Gagal Tambah Mutasi Stok');
					redirect(base_url(akses().'/transaksi/mutasi/add'));
				}				
			}else{
				$meta['judul']="Transaksi Mutasi Stok";
				$this->load->view('tema/header',$meta);
				$this->load->view(akses().'/transaksi/mutasi/mutasiadd');
				$this->load->view('tema/footer');
			}			
		
		}else{
			redirect(base_url(akses().'/transaksi/mutasi'));
		}
	}
	
	function detail()
	{
		$meta['judul']="Detail Transaksi Mutasi Stok";
		$this->load->view('tema/header',$meta);
		$id=$this->input->get('id',TRUE);
		$d['data']=$this->mod_trans->mutasi_data(array('mutasi_id'=>$id));
		$this->load->view(akses().'/transaksi/mutasi/mutasidetail',$d);
		$this->load->view('tema/footer');
	}
	
}