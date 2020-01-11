<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('m_db');
		$this->load->library('cart');
		$this->load->model('transaksi_model','mod_transaksi');
	}
	
	function index()
	{
		$meta['judul']="KATALOG | ".baca_konfig('nama-aplikasi');
		$meta['judulhalaman']="Katalog Produk";
		$meta['homepage']=FALSE;
		$this->load->view('html/header',$meta);
		$this->load->view('html/page/katalogview');
		$this->load->view('html/footer');
	}
	
	function detailproduk()
	{
		$id=$this->uri->segment(2);
		redirect(base_url().'produk/add/'.$id);
	}
	
	
	function kategori()
	{
		$id=$this->uri->segment(3);
		$nama=field_value('produk_kategori','kategori_id',$id,'nama_kategori');
		if(!empty($nama))
		{
					
		$meta['judul']="$nama | ".baca_konfig('nama-aplikasi');
		$meta['judulhalaman']="Kategori Produk ".$nama;
		$meta['homepage']=FALSE;
		$this->load->view('html/header',$meta);
		$d['kategoriid']=$id;
		$this->load->view('html/page/kategoriview',$d);
		$this->load->view('html/footer');
		}else{
			redirect(base_url());
		}
	}
	
	function cari()
	{
		$id=$this->input->get('cari');
		$sql="Select * from produk Where nama_produk LIKE '%$id%' OR deskripsi LIKE '%$id%'";		
		$meta['judul']="Pencarian $id | ".baca_konfig('nama-aplikasi');
		$meta['judulhalaman']="Pencarian $id ";
		$meta['homepage']=FALSE;
		$this->load->view('html/header',$meta);
		$d['keyword']=$id;
		$d['dCariTerbaru']=$this->m_db->get_query_data($sql);
		$this->load->view('html/page/cariview',$d);
		$this->load->view('html/footer');		
	}
	
	function beli()
	{
		$id=$this->uri->segment(3);
		$s=array(
		'produk_id'=>$id,
		);		
		if($this->m_db->is_bof('produk',$s)==FALSE)
		{
			$this->form_validation->set_rules('produkid','Produk','required');
			$this->form_validation->set_rules('qty','QTY','required');
			if($this->form_validation->run()==TRUE)
			{
				$produkid=$this->input->post('produkid');
				$qty=$this->input->post('qty');
				$nama=field_value('produk','produk_id',$produkid,'nama_produk');
				$kode=field_value('produk','produk_id',$produkid,'kode_produk');
				$harga=field_value('produk','produk_id',$produkid,'harga');
				$harga2=field_value('produk','produk_id',$produkid,'harga');
				$promo_id=produk_promo_id($produkid);
				$keterangan=$this->input->post('keterangan');
				$promo_nilai=0;
				if(!empty($promo_id))
				{
					$promo_nilai=field_value('promo','promo_id',$promo_id,'nilai');
					$harga=$harga2-$promo_nilai;
				}
				$data = array(
				        'id'      => $kode,
				        'qty'     => $qty,
				        'price'   => $harga,
				        'name'    => $nama,
				        'produk_id'=>$produkid,
				        'diskon'	=>$promo_nilai,
				        'keterangan'=>$keterangan,
				);
				$this->cart->insert($data);
				redirect(base_url().'keranjang');
			}else{
				$nama=$this->m_db->get_row('produk',$s,'nama_produk');
				$meta['judul']="$nama | ".baca_konfig('nama-aplikasi');
				$meta['judulhalaman']="Beli Produk ".$nama;
				$meta['homepage']=FALSE;
				$this->load->view('html/header',$meta);
				$d['produkid']=$id;
				$d['data']=$this->m_db->get_data('produk',$s);
				$this->load->view('html/page/beliview',$d);
				$this->load->view('html/footer');
			}			
		}else{
			redirect(base_url());
		}
	}
	
	function keranjang()
	{
		$this->form_validation->set_rules('aksi','Aksi','required');
		if($this->form_validation->run()==TRUE)
		{
			$data=$_POST['info'];
			$this->cart->update($data);
			redirect(base_url().'keranjang');
			//var_dump($_POST);
		}else{
					
		$meta['judul']="Keranjang Belanja | ".baca_konfig('nama-aplikasi');
		$meta['judulhalaman']="Keranjang Belanja";
		$meta['homepage']=FALSE;
		$this->load->view('html/header',$meta);
		$this->load->view('html/page/keranjangview');
		$this->load->view('html/footer');
		}
	}
	
	function kosongkan()
	{
		$this->cart->destroy();
		redirect(base_url().'keranjang');
	}
	
	function hapus()
	{
		$id=$this->uri->segment(3);
		if(!empty($id))
		{
			$this->cart->remove($id);
			redirect(base_url().'keranjang');
		}else{
			redirect(base_url().'keranjang');
		}
	}
	
	function kurirdata()
	{
		$this->load->library('rajaongkir');
		$tujuan=$this->input->get('kota');
		$dari=toko_info(toko_pusat(),'kota');
		$berat=$this->input->get('berat');
		$kurir=$this->input->get('kurir');
		$dc=$this->rajaongkir->cost($dari,$tujuan,$berat,$kurir);
		$d=json_decode($dc,TRUE);
		$o='';
		if(!empty($d['rajaongkir']['results']))
		{
			$data['data']=$d['rajaongkir']['results'][0]['costs'];
			$this->load->view('html/page/kurirdata',$data);			
		}
	}
	
	function selesai()
	{
		if(akses()!="member")
		{
			$ref=$this->uri->ruri_string();
			redirect(base_url().'member/login?ref='.$ref);
		}else{
			$this->form_validation->set_rules('pelangganid','ID Pelanggan','required');
			$this->form_validation->set_rules('total','Total Belanja','required');
			$this->form_validation->set_rules('ongkir','Ongkos Kirim','required');
			$this->form_validation->set_rules('berat','Berat Produk','required');
			if($this->form_validation->run()==TRUE)
			{
				$pelanggan=$this->input->post('pelangganid');
				$total=$this->input->post('total');
				$kurir=$this->input->post('kurir');
				$ongkir=$this->input->post('ongkir');
				$service=$this->input->post('service');
				$berat=$this->input->post('berat');
				$tarif=$this->input->post('tarif');
				$produk=$this->input->post('produk');
				$diskon=$this->input->post('diskonnilai');
				//var_dump($_POST);
				$ext=$this->mod_transaksi->penjualan_add($pelanggan,$total,$kurir,$service,$ongkir,$produk,$berat,$diskon);
				if($ext['status']==TRUE)
				{					
					$penjualanID=$ext['penjualanid'];
					$this->cart->destroy();
					redirect(base_url().'produk/histori/bayar/'.$penjualanID);
				}else{
					redirect(base_url().'checkout');
				}
			}else{
				$meta['judul']="Checkout Belanja | ".baca_konfig('nama-aplikasi');
				$meta['judulhalaman']="Checkout Belanja";
				$meta['homepage']=FALSE;
				$this->load->view('html/header',$meta);
				$this->load->view('html/page/selesaiview');
				$this->load->view('html/footer');
			}			
		}
	}
}