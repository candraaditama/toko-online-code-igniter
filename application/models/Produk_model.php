<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Produk_model extends CI_Model
{
	function __construct()
	{
		$this->load->library('m_db');
		$this->load->model('toko_model','mod_toko');
	}
	
	function merek_data($where=array(),$order="nama_merek ASC")
	{
		$d=$this->m_db->get_data('produk_merek',$where,$order);
		return $d;
	}
	
	function merek_add($nama)
	{
		$d=array(
		'nama_merek'=>$nama,
		);
		if($this->m_db->add_row('produk_merek',$d)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function merek_edit($merekID,$nama)
	{
		$s=array(
		'merek_id'=>$merekID,
		);
		$d=array(
		'nama_merek'=>$nama
		);
		if($this->m_db->edit_row('produk_merek',$d,$s)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function merek_delete($merekID)
	{
		$s=array(
		'merek_id'=>$merekID,
		);
		
		if($this->m_db->delete_row('produk_merek',$s)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function warna_data($where=array(),$order="nama_warna ASC")
	{
		$d=$this->m_db->get_data('produk_warna',$where,$order);
		return $d;
	}
	
	function warna_add($nama)
	{
		$d=array(
		'nama_warna'=>$nama,
		);
		if($this->m_db->add_row('produk_warna',$d)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function warna_edit($warnaID,$nama)
	{
		$s=array(
		'warna_id'=>$warnaID,
		);
		$d=array(
		'nama_warna'=>$nama
		);
		if($this->m_db->edit_row('produk_warna',$d,$s)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function warna_delete($warnaID)
	{
		$s=array(
		'warna_id'=>$warnaID,
		);
		
		if($this->m_db->delete_row('produk_warna',$s)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function ukuran_data($where=array(),$order="nama_ukuran ASC")
	{
		$d=$this->m_db->get_data('produk_ukuran',$where,$order);
		return $d;
	}
	
	function ukuran_add($nama)
	{
		$d=array(
		'nama_ukuran'=>$nama,
		);
		if($this->m_db->add_row('produk_ukuran',$d)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function ukuran_edit($ukuranID,$nama)
	{
		$s=array(
		'ukuran_id'=>$ukuranID,
		);
		$d=array(
		'nama_ukuran'=>$nama
		);
		if($this->m_db->edit_row('produk_ukuran',$d,$s)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function ukuran_delete($ukuranID)
	{
		$s=array(
		'ukuran_id'=>$ukuranID,
		);
		
		if($this->m_db->delete_row('produk_ukuran',$s)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function kategori_data($where=array(),$order="nama_kategori ASC")
	{
		$d=$this->m_db->get_data('produk_kategori',$where,$order);
		return $d;
	}
	
	function kategori_add($nama)
	{
		$d=array(
		'nama_kategori'=>$nama,
		);
		if($this->m_db->add_row('produk_kategori',$d)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function kategori_edit($kategoriID,$nama)
	{
		$s=array(
		'kategori_id'=>$kategoriID,
		);
		$d=array(
		'nama_kategori'=>$nama
		);
		if($this->m_db->edit_row('produk_kategori',$d,$s)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function kategori_delete($kategoriID)
	{
		$s=array(
		'kategori_id'=>$kategoriID,
		);
		
		if($this->m_db->delete_row('produk_kategori',$s)==TRUE)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function promo_data($where=array(),$order="mulai DESC")
	{
		$d=$this->m_db->get_data('promo',$where,$order);
		return $d;
	}
	
	function promo_add($promoID,$judul,$deskripsi,$nilai,$mulai,$selesai)
	{
		$s=array(
		'promo_id'=>$promoID,
		);
		if($this->m_db->is_bof('promo',$s)==TRUE)
		{
			$d=array(
			'judul'=>$judul,
			'deskripsi'=>$deskripsi,
			'nilai'=>$nilai,
			'mulai'=>$mulai,
			'selesai'=>$selesai,
			);
			if($this->m_db->add_row('promo',$d)==TRUE)
			{
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	function promo_edit($promoID,$judul,$deskripsi,$nilai,$mulai,$selesai)
	{
		$s=array(
		'promo_id'=>$promoID,
		);
		if($this->m_db->is_bof('promo',$s)==FALSE)
		{
			$d=array(
			'judul'=>$judul,
			'deskripsi'=>$deskripsi,
			'mulai'=>$mulai,
			'selesai'=>$selesai,
			'nilai'=>$nilai,
			);
			if($this->m_db->edit_row('promo',$d,$s)==TRUE)
			{
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	function promo_delete($promoID)
	{
		$s=array(
		'promo_id'=>$promoID,
		);
		if($this->m_db->delete_row('promo',$s)==FALSE)
		{
			$this->m_db->delete_row('promo_data',$s);
			return true;
		}else{
			return false;
		}
	}
	
	function produk_data($where=array(),$order="nama_produk ASC")
	{
		$d=$this->m_db->get_data('produk',$where,$order);
		return $d;
	}
	
	function produk_add_single($toko,$kode,$nama,$supplierID,$merekID,$kategoriID,$deskripsi,$stok,$harga,$berat='1',$photo='')
	{		
		$d=array(
		'kode_produk'=>$kode,
		'nama_produk'=>$nama,
		'supplier_id'=>$supplierID,
		'merek_id'=>$merekID,
		'kategori_id'=>$kategoriID,
		'deskripsi'=>$deskripsi,
		'harga'=>$harga,
		'berat'=>$berat,
		);
		if($this->m_db->add_row('produk',$d)==TRUE)
		{
			$produkID=$this->m_db->last_insert_id();
			$pathupload=FCPATH.'assets/images/produk/';
			$allowtype="jpg|bmp|png|jpeg";
			$config['upload_path'] = $pathupload;
			$config['allowed_types'] = $allowtype;
			$config['max_size']	= 0;
			$config['max_filename']=0;
			$config['max_width'] = 0;
			$config['max_height'] = 0;
			$config['overwrite']=TRUE;
			$this->produk_add_stok_single($toko,$produkID,$stok);
			if(!empty($photo))
			{
				$this->load->library('upload');
				$this->load->library('m_file');
				$count=4;
				$field="upload";
				for($i=1;$i<=$count;$i++){					
					if (!empty($_FILES[$field.$i]['name'])) {						
						$gambar=$_FILES[$field.$i]['name'];
		        		$ext=pathinfo($gambar,PATHINFO_EXTENSION);
		        		$imgname="produk_".$produkID."-".$i.".".$ext;
		        		$config['file_name'] = $imgname;
		        		$this->upload->initialize($config);
						if ($this->upload->do_upload($field.$i))
						{							
							$sdata=$this->upload->data();
							$folder=$sdata['file_path'];
							$oripath=$sdata['full_path'];
							$imgname=$sdata['orig_name'];														
							$this->m_file->imageThumbs($pathupload,$oripath,$imgname);
							$d2=array(
							'produk_id'=>$produkID,
							'photo'=>$imgname,
							);
							$this->m_db->add_row('produk_photo',$d2);
						}
					}
				}				
			}
			return true;
		}else{
			return false;
		}
	}
	
	function produk_edit($produkID,$kode,$nama,$supplierID,$merekID,$kategoriID,$deskripsi,$harga,$berat='1',$photo='')
	{
		$s=array(
		'produk_id'=>$produkID,
		);
		$d=array(
		'kode_produk'=>$kode,
		'nama_produk'=>$nama,
		'supplier_id'=>$supplierID,
		'merek_id'=>$merekID,
		'kategori_id'=>$kategoriID,
		'deskripsi'=>$deskripsi,
		'harga'=>$harga,
		'berat'=>$berat,
		);
		if($this->m_db->edit_row('produk',$d,$s)==TRUE)
		{			
			$pathupload=FCPATH.'assets/images/produk/';
			$allowtype="jpg|bmp|png|jpeg";
			$config['upload_path'] = $pathupload;
			$config['allowed_types'] = $allowtype;
			$config['max_size']	= 0;
			$config['max_filename']=0;
			$config['max_width'] = 0;
			$config['max_height'] = 0;
			$config['overwrite']=TRUE;
			
			if(!empty($photo))
			{
				$this->m_db->delete_row('produk_photo',array('produk_id'=>$produkID));
				$this->load->library('upload');
				$this->load->library('m_file');
				$count=4;
				$field="upload";
				for($i=1;$i<=$count;$i++){					
					if (!empty($_FILES[$field.$i]['name'])) {						
						$gambar=$_FILES[$field.$i]['name'];
		        		$ext=pathinfo($gambar,PATHINFO_EXTENSION);
		        		$imgname="produk_".$produkID."-".$i.".".$ext;
		        		$config['file_name'] = $imgname;
		        		$this->upload->initialize($config);
						if ($this->upload->do_upload($field.$i))
						{							
							$sdata=$this->upload->data();
							$folder=$sdata['file_path'];
							$oripath=$sdata['full_path'];
							$imgname=$sdata['orig_name'];														
							$this->m_file->imageThumbs($pathupload,$oripath,$imgname);
							$d2=array(
							'produk_id'=>$produkID,
							'photo'=>$imgname,
							);
							$this->m_db->add_row('produk_photo',$d2);
						}
					}else{
						$last=$this->input->post('fupload'.$i);
						$d2=array(
						'produk_id'=>$produkID,
						'photo'=>$last,
						);
						$this->m_db->add_row('produk_photo',$d2);
					}
				}				
			}
			$this->m_db->delete_row('produk_photo',array('produk_id'=>$produkID,'photo'=>''));
			return true;
		}else{
			return false;
		}
	}
	
	function produk_add_stok_single($toko,$produkID,$stok)
	{
		if(!empty($stok))
		{							
			$d=array(
			'produk_id'=>$produkID,
			'toko_id'=>$toko,
			'stok'=>$stok,
			);
			$this->m_db->add_row('produk_stok',$d);			
			return true;
		}else{
			return false;
		}
	}
		
	function produk_add_stok($toko,$produkID,$stok=array())
	{
		if(!empty($stok))
		{
			foreach($stok as $rstok)
			{				
				$ukuranID=$rstok['ukuran'];
				$warnaID=$rstok['warna'];
				$stok=$rstok['stok'];
												
				$d=array(
				'produk_id'=>$produkID,
				'toko_id'=>$toko,
				'ukuran_id'=>$ukuranID,
				'warna_id'=>$warnaID,
				'stok'=>$stok,
				);
				$this->m_db->add_row('produk_stok',$d);
			}
			return true;
		}else{
			return false;
		}
	}
	
	function produk_delete($id)
	{
		$s=array(
		'produk_id'=>$id,
		);
		if($this->m_db->is_bof('produk_photo',$s)==FALSE)
		{
			$dPhoto=$this->m_db->get_data('produk_photo',$s);
			if(!empty($dPhoto))
			{
				$this->load->library('m_file');
				$pathupload=FCPATH.'assets/images/produk/';
				foreach($dPhoto as $rPhoto)
				{
					$filename=$rPhoto->photo;
					$this->m_file->deleteImage($pathupload,$filename);
				}
			}
			$this->m_db->delete_row('produk_stok',$s);
			$this->m_db->delete_row('produk',$s);
			return true;
		}else{
			return false;
		}
	}
		
}