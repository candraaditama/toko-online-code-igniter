<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promo extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('m_db');		
		if(akses()!="bos")
		{
			$this->login_model->user_logout();
		}
		$this->load->model('produk_model','mod_produk');
	}
	
	function index()
	{
		$tgl=date("Y-m-d");
		$meta['judul']="Semua Kupon Promo";
		$this->load->view('tema/header',$meta);
		$d['data']=$this->mod_produk->promo_data(array('selesai >'=>$tgl));
		$this->load->view(akses().'/produk/promo/promoview',$d);
		$this->load->view('tema/footer');
	}
	
	function add()
	{
		$this->form_validation->set_rules('kode','Kode Kupon','required');
		$this->form_validation->set_rules('nilai','Nilai Kupon','required');
		$this->form_validation->set_rules('judul','Judul Promo','required');
		$this->form_validation->set_rules('deskripsi','Deskripsi','required');
		$this->form_validation->set_rules('t1','Mulai Promo','required');
		$this->form_validation->set_rules('t2','Akhir Promo','required');
		$this->form_validation->set_rules('jumlah','Jumlah Kupon','required');
		$this->form_validation->set_rules('minimal','Minimal Order','required');
		if($this->form_validation->run()==TRUE)
		{
			$judul=$this->input->post('judul',TRUE);
			$nilai=$this->input->post('nilai',TRUE);
			$kode=$this->input->post('kode',TRUE);
			$deskripsi=$this->input->post('deskripsi');
			$mulai=$this->input->post('t1',TRUE);
			$selesai=$this->input->post('t2',TRUE);
			$jumlah=$this->input->post('jumlah',TRUE);
			$minimal=$this->input->post('minimal',TRUE);
			if($this->mod_produk->promo_add($judul,$deskripsi,$nilai,$mulai,$selesai,$kode,$jumlah,$minimal)==TRUE)
			{
				set_header_message('success','Tambah Kupon Promo','Berhasil menambahkan kupon promo');
				redirect(base_url(akses().'/produk/promo'),'refresh',301);
			}else{
				set_header_message('danger','Tambah Kupon Promo','Gagal menambahkan kupon promo');
				redirect(base_url(akses().'/produk/promo/add'),'refresh',301);
			}
		}else{
			$meta['judul']="Tambah Kupon Promo";
			$this->load->view('tema/header',$meta);
			$this->load->view(akses().'/produk/promo/promoadd');
			$this->load->view('tema/footer');
		}		
	}
	
	function edit()
	{
		$this->form_validation->set_rules('promoid','ID Kupon','required');
		$this->form_validation->set_rules('nilai','Nilai Kupon','required');
		$this->form_validation->set_rules('judul','Judul Promo','required');
		$this->form_validation->set_rules('deskripsi','Deskripsi','required');
		$this->form_validation->set_rules('t1','Mulai Promo','required');
		$this->form_validation->set_rules('t2','Akhir Promo','required');
		$this->form_validation->set_rules('jumlah','Jumlah Kupon','required');
		$this->form_validation->set_rules('minimal','Minimal Order','required');
		if($this->form_validation->run()==TRUE)
		{
			$promoid=$this->input->post('promoid',TRUE);
			$judul=$this->input->post('judul',TRUE);
			$nilai=$this->input->post('nilai',TRUE);
			$deskripsi=$this->input->post('deskripsi');
			$mulai=$this->input->post('t1',TRUE);
			$selesai=$this->input->post('t2',TRUE);
			$jumlah=$this->input->post('jumlah',TRUE);
			$minimal=$this->input->post('minimal',TRUE);
			if($this->mod_produk->promo_edit($promoid,$judul,$deskripsi,$nilai,$mulai,$selesai,$jumlah,$minimal)==TRUE)
			{
				set_header_message('success','Ubah Kupon Promo','Berhasil mengubah kupon promo');
				redirect(base_url(akses().'/produk/promo'),'refresh',301);
			}else{
				set_header_message('danger','Ubah Kupon Promo','Gagal mengubah kupon promo');
				redirect(base_url(akses().'/produk/promo'),'refresh',301);
			}
		}else{
			$tgl=date("Y-m-d");
			$id=$this->input->get('id',TRUE);
			$meta['judul']="Ubah Kupon Promo";
			$this->load->view('tema/header',$meta);
			$d['data']=$this->mod_produk->promo_data(array('promo_id'=>$id,'selesai > '=>$tgl));
			$this->load->view(akses().'/produk/promo/promoedit',$d);
			$this->load->view('tema/footer');
		}		
	}
	
	function delete()
	{
		$id=$this->input->get("id",TRUE);
		if($this->mod_produk->promo_delete($id)==TRUE)
		{
			set_header_message('success','Hapus Kupon Promo','Berhasil menghapus kupon promo');
			redirect(base_url(akses().'/produk/promo'),'refresh',301);
		}else{
			set_header_message('danger','Hapus Kupon Promo','Gagal menghapus kupon promo');
			redirect(base_url(akses().'/produk/promo'),'refresh',301);
		}
	}
}