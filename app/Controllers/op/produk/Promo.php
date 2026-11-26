<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promo extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('m_db');		
		if(akses()!="op")
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
		//$d['data']=$this->mod_produk->promo_data(array('selesai >'=>$tgl));
			$d['data']=$this->mod_produk->promo_data();
		$this->load->view(akses().'/produk/promo/promoview',$d);
		$this->load->view('tema/footer');
	}
	
	function add()
	{		
		$this->form_validation->set_rules('nilai','Nilai Kupon','required');
		$this->form_validation->set_rules('judul','Judul Promo','required');
		$this->form_validation->set_rules('deskripsi','Deskripsi','required');
		$this->form_validation->set_rules('t1','Mulai Promo','required');
		$this->form_validation->set_rules('t2','Akhir Promo','required');
		if($this->form_validation->run()==TRUE)
		{
			$judul=$this->input->post('judul',TRUE);
			$deskripsi=$this->input->post('deskripsi',TRUE);
			$nilai=$this->input->post('nilai',TRUE);
			$mulai=$this->input->post('t1',TRUE);
			$selesai=$this->input->post('t2',TRUE);
			if($this->mod_produk->promo_add($judul,$deskripsi,$nilai,$mulai,$selesai)==TRUE)
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
		if($this->form_validation->run()==TRUE)
		{
			$promoid=$this->input->post('promoid',TRUE);
			$judul=$this->input->post('judul',TRUE);
			$nilai=$this->input->post('nilai',TRUE);
			$deskripsi=$this->input->post('deskripsi');
			$mulai=$this->input->post('t1',TRUE);
			$selesai=$this->input->post('t2',TRUE);
			if($this->mod_produk->promo_edit($promoid,$judul,$deskripsi,$nilai,$mulai,$selesai)==TRUE)
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
	
	function produk()
	{
		$tgl=date("Y-m-d");
		$id=$this->input->get('id',TRUE);
		$meta['judul']="Ubah Produk Promo";
		$this->load->view('tema/header',$meta);
		$d['data']=$this->mod_produk->produk_data();
		$d['promoid']=$id;
		$this->load->view(akses().'/produk/promo/promoprodukview',$d);
		$this->load->view('tema/footer');
	}
	
	function aksi()
	{
		$aksi=$this->input->get('aksi');
		$produkid=$this->input->get('id');
		$promo=$this->input->get('promo');
		$sProduk=array(
		'produk_id'=>$produkid,
		);
		if($this->m_db->is_bof('produk',$sProduk)==FALSE)
		{
			$sPromo=array(
			'promo_id'=>$promo,
			);
			if($this->m_db->is_bof('promo',$sPromo)==FALSE)
			{
				$sCek=array(
				'promo_id'=>$promo,
				'produk_id'=>$produkid,
				);
				if($aksi=="add")
				{					
					if($this->m_db->is_bof('promo_data',$sCek)==TRUE)
					{
						$dAdd=array(
						'promo_id'=>$promo,
						'produk_id'=>$produkid,
						);
						$this->m_db->add_row('promo_data',$dAdd);
						set_header_message('success','Tambah Produk Promo','Berhasil menambah produk promo');
						redirect(base_url(akses().'/produk/promo/produk').'?id='.$promo);
					}else{
						set_header_message('danger','Tambah Produk Promo','Gagal menambah produk promo');
						redirect(base_url(akses().'/produk/promo/produk').'?id='.$promo);
					}
				}elseif($aksi=="delete"){
					$this->m_db->delete_row('promo_data',$sCek);
					set_header_message('success','Tambah Produk Promo','Berhasil menghapus produk promo');
					redirect(base_url(akses().'/produk/promo/produk').'?id='.$promo);
				}
			}else{
				set_header_message('danger','Tambah Produk Promo','Gagal menambah produk promo');
				redirect(base_url(akses().'/produk/promo'));
			}
		}else{
			set_header_message('danger','Tambah Produk Promo','Gagal menambah produk promo');
			redirect(base_url(akses().'/produk/promo/produk').'?id='.$promo);
		}
	}
	
	function gambar()
	{
		$this->form_validation->set_rules('promoid','ID Promo','required');
		if($this->form_validation->run()==TRUE)
		{
			$promoid=$this->input->post('promoid');
			$gambar=$_FILES['file']['name'];		
	        $ext=pathinfo($gambar,PATHINFO_EXTENSION);
			$imgname="promo-".md5($promoid).".".$ext;
			$path = FCPATH.'assets/images/';
			$allow= "jpg|bmp|gif|png|jpeg";
			$maxsize	= 0;
			$max_filename=0;				
			$config['upload_path']          = $path;
	        $config['allowed_types']        = $allow;
	        $config['max_size']             = $maxsize;
	        $config['max_width']            = 0;
	        $config['max_height']           = 0;
	        $config['file_name'] 			= $imgname;

	        $this->load->library('upload', $config);

	        if($this->upload->do_upload('file'))
	        {
	        	$dPromo=array(
	        	'banner_gambar'=>$imgname,
	        	);
	        	$this->m_db->edit_row('promo',$dPromo,array('promo_id'=>$promoid));
	        	set_header_message('success','Tambah Banner Promo','Berhasil menambah banner promo');
				redirect(base_url(akses().'/produk/promo'));
	        }else{
				set_header_message('danger','Tambah Banner Promo','Gagal menambah banner promo');
				redirect(base_url(akses().'/produk/promo'));
			}
		}else{
			$tgl=date("Y-m-d");
			$id=$this->input->get('id',TRUE);
			$meta['judul']="Ubah Kupon Promo";
			$this->load->view('tema/header',$meta);
			$d['data']=$this->mod_produk->promo_data(array('promo_id'=>$id,'selesai > '=>$tgl));
			$this->load->view(akses().'/produk/promo/promobanner',$d);
			$this->load->view('tema/footer');
		}
	}
	
	function deletebanner()
	{
		$id=$this->input->get('id');
		$d=array(
		'banner_gambar'=>'',
		);
		$s=array(
		'promo_id'=>$id,
		);
		if($this->m_db->is_bof('promo',$s)==FALSE)
		{
			$gambar=$this->m_db->get_row('promo',$s,'banner_gambar');
			$pathGambar=FCPATH.'assets/images/'.$gambar;
			if(file_exists($pathGambar) && is_file($pathGambar))
			{
				unlink($pathGambar);
			}
			if($this->m_db->edit_row('promo',$d,$s)==TRUE)
			{
				set_header_message('success','Hapus Banner Promo','Berhasil menghapus banner');
				redirect(base_url(akses().'/produk/promo'));
			}else{
				set_header_message('danger','Hapus Banner Promo','Gagal menghapus banner');
				redirect(base_url(akses().'/produk/promo'));
			}
		}else{
			set_header_message('danger','Hapus Banner Promo','Gagal menghapus banner');
			redirect(base_url(akses().'/produk/promo'));
		}
	}
	
}