<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('m_db');
	}
	
	function index()
	{
		$id=$this->uri->segment(4);
		$pelanggan=pelanggan_info('pelanggan_id');
		$s=array(
		'penjualan_id'=>$id,
		'pelanggan_id'=>$pelanggan,
		);
		if($this->m_db->is_bof('penjualan',$s)==FALSE)
		{			
			$meta['judul']="Tagihan | ".baca_konfig('nama-aplikasi');
			$meta['judulhalaman']="Tagihan Order";
			$meta['homepage']=FALSE;
			$this->load->view('html/header',$meta);
			$d['data']=$this->m_db->get_data('penjualan',$s);
			$this->load->view('html/page/tagihanview',$d);
			$this->load->view('html/footer');
		}else{
			//redirect(base_url());
		}	
	}
	
	function konfirmasi()
	{
		$this->form_validation->set_rules('invoice','Nomor Invoice','required');
		$this->form_validation->set_rules('bankid','Tujuan Bank','required');
		$this->form_validation->set_rules('pemilik','Pemilik Rekening','required');
		$this->form_validation->set_rules('tanggal','Tanggal Transfer','required');
		if($this->form_validation->run()==TRUE)
		{
			$invoice=$this->input->post('invoice');
			$bank=$this->input->post('bankid');
			$pemilik=$this->input->post('pemilik');
			$tanggal=$this->input->post('tanggal');
			$penjualanid=field_value('penjualan','invoice',$invoice,'penjualan_id');
			$d=array();
			$ok=FALSE;
			$bukti=$_FILES['bukti']['name'];
			if(!empty($bukti))
			{
				$ext=pathinfo($bukti,PATHINFO_EXTENSION);
				$imgname="bukti-".$invoice.".".$ext;
				$path = FCPATH.'assets/uploads/';
				$allow= "jpg|bmp|pdf|png|jpeg";
				$maxsize	= 0;
				$max_filename=0;				
				$config['upload_path']          = $path;
		        $config['allowed_types']        = $allow;
		        $config['max_size']             = $maxsize;
		        $config['max_width']            = 0;
		        $config['max_height']           = 0;
		        $config['file_name'] 			= $imgname;
		        $config['overwrite']			= TRUE;

		        $this->load->library('upload', $config);
		        if($this->upload->do_upload('bukti'))
        		{
        			$d=array(
        			'invoice'=>$invoice,
        			'bank_id'=>$bank,
        			'pemilik'=>$pemilik,
        			'tanggal'=>date("Y-m-d H:i:s"),
        			'tanggal_transfer'=>$tanggal,
        			'bukti_transfer'=>$imgname,
        			'penjualan_id'=>$penjualanid,
        			);
        		}
			}else{
				$d=array(
    			'invoice'=>$invoice,
    			'bank_id'=>$bank,
    			'pemilik'=>$pemilik,
    			'tanggal'=>date("Y-m-d H:i:s"),
    			'tanggal_transfer'=>$tanggal,
    			'penjualan_id'=>$penjualanid,
    			);
			}
			$s=array(
			'penjualan_id'=>$penjualanid,
			);
			if($this->m_db->is_bof('penjualan_konfirmasi',$s)==FALSE)
			{
				redirect(base_url().'tracking'.'?invoice='.$invoice);
			}else{
				if($this->m_db->add_row('penjualan_konfirmasi',$d)==TRUE)
				{
					$d2=array(
					'status'=>'konfirmasi',
					);
					$this->m_db->edit_row('penjualan',$d2,$s);
					redirect(base_url().'tracking'.'?invoice='.$invoice);
				}else{
					redirect(base_url().'konfirmasi?s=1');
				}
			}
		}else{
			$meta['judul']="Konfirmasi Pembayaran | ".baca_konfig('nama-aplikasi');
			$meta['judulhalaman']="Konfirmasi Pembayaran";
			$meta['homepage']=FALSE;
			$this->load->view('html/header',$meta);
			$this->load->view('html/page/konfirmasiview');
			$this->load->view('html/footer');
		}
	}
	
	function getinvoice()
	{
		$pelanggan=pelanggan_info('pelanggan_id');
		$invoice=$this->input->get('invoice');
		$s=array(
		'pelanggan_id'=>$pelanggan,
		'invoice'=>$invoice,
		);
		if($this->m_db->is_bof('penjualan',$s)==FALSE)
		{
			$nama=field_value('pelanggan','pelanggan_id',$pelanggan,'nama_pelanggan');
			$jual=$this->m_db->get_row('penjualan',$s,'total');
			$ongkir=$this->m_db->get_row('penjualan',$s,'ongkir');
			$promo=$this->m_db->get_row('penjualan',$s,'promo');
			$total=($jual+$ongkir)-$promo;
			echo json_encode(array(
			'status'=>'ok',
			'total'=>"Rp ".number_format($total,0),
			'nama'=>$nama,
			));
		}else{
			echo json_encode(array('status'=>'no'));
		}
	}
	
	function cektagihan()
	{
		$invoice=$this->input->get('invoice',TRUE);
		$d=array();
		if(!empty($invoice))
		{
			$d=$this->m_db->get_data('penjualan',array('invoice'=>$invoice));
		}
		
		$meta['judul']="Tracking Order #$invoice | ".baca_konfig('nama-aplikasi');
		$meta['judulhalaman']="Tracking Order #$invoice ";
		$meta['homepage']=FALSE;
		$this->load->view('html/header',$meta);
		$dx['data']=$d;
		$this->load->view('html/page/trackingview',$dx);
		$this->load->view('html/footer');
	}
}