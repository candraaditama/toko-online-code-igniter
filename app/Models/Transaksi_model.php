<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Transaksi_model extends CI_Model
{
	function __construct()
	{
		$this->load->library('m_db');
	}
	
	function mutasi_data($where=array(),$order="tanggal DESC")
	{
		$d=$this->m_db->get_data('toko_mutasi',$where,$order);
		return $d;
	}
	
	function mutasi_data_detail($mutasiID)
	{
		$s=array(
		'mutasi_id'=>$mutasiID,
		);
		$d=$this->m_db->get_data('toko_mutasi_detail',$s);
		return $d;
	}
	
	function mutasi_add($tokoid,$tanggal,$keterangan,$mutasi=array())
	{
		$userid=user_info('user_id');
		$d=array(
		'tanggal'=>$tanggal." ".date("H:i:s"),
		'keterangan'=>$keterangan,
		'user_id'=>$userid,
		'toko_id'=>$tokoid,
		);
		if(!empty($mutasi))
		{
			if($this->m_db->add_row('toko_mutasi',$d)==TRUE)
			{
				$mutasiID=$this->m_db->last_insert_id();
				foreach($mutasi as $rmutasi)
				{
					$produkID=$rmutasi['produkid'];					
					$qty=$rmutasi['qty'];
					$s=array(
					'produk_id'=>$produkID,				
					'toko_id'=>toko_pusat(),
					);
					if($this->m_db->is_bof('produk_stok',$s)==FALSE)
					{
						$stokmutasiLast=$this->m_db->get_row('produk_stok',$s,'stok_mutasi');
						$hasilmutasi=$stokmutasiLast+$qty;
						$d2=array(
						'stok_mutasi'=>$hasilmutasi,
						);
						$this->m_db->edit_row('produk_stok',$d2,$s);
						$s2=array(
						'produk_id'=>$produkID,						
						'toko_id'=>$tokoid,
						);
						if($this->m_db->is_bof('produk_stok',$s2)==TRUE)
						{
							$d3=array(
							'produk_id'=>$produkID,							
							'toko_id'=>$tokoid,
							'stok'=>$qty,
							);
							$this->m_db->add_row('produk_stok',$d3);
						}else{
							$lastStok=$this->m_db->get_row('produk_stok',$s2,'stok');
							$hasilstok=$lastStok+$qty;
							$d3=array(
							'produk_id'=>$produkID,
							'toko_id'=>$tokoid,
							'stok'=>$hasilstok,
							);
							$this->m_db->edit_row('produk_stok',$d3,$s2);
						}
						
						$dMutDetil=array(
						'produk_id'=>$produkID,
						'qty'=>$qty,
						'mutasi_id'=>$mutasiID,
						);
						$this->m_db->add_row('toko_mutasi_detail',$dMutDetil);
						return true;
					}
				}
			}else{
				return false;
			}
		}else{
			return false;
		}	
	}
	
	function penjualan_add($pelangganID,$total,$kurir,$pelayanan,$ongkir,$produk=array(),$berat,$diskon)
	{
		$dx=array();
		if(!empty($produk))
		{
			$kota=field_value('pelanggan','pelanggan_id',$pelangganID,'kota');
			$alamat=field_value('pelanggan','pelanggan_id',$pelangganID,'alamat');
			$tgl=date("Y-m-d H:i:s");
			$invoice=strtotime($tgl);
			$d=array(
			'pelanggan_id'=>$pelangganID,
			'invoice'=>$invoice,
			'tanggal'=>$tgl,
			'total'=>$total,
			'kurir'=>$kurir,
			'pelayanan'=>$pelayanan,
			'ongkir'=>$ongkir,
			'berat'=>$berat,
			'status'=>'draft',
			'kota'=>$kota,
			'alamat'=>$alamat,
			'promo'=>$diskon,
			);
			if($this->m_db->add_row('penjualan',$d)==TRUE)
			{
				$penjualanID=$this->m_db->last_insert_id();
				$toko=toko_pusat();				
				foreach($produk as $r)
				{
					$produkID=$r['produkid'];
					$qty=$r['qty'];
					$harga=$r['harga'];
					$subtotal=$r['subtotal'];
					$keterangan=$r['keterangan'];
					$d2=array(
					'penjualan_id'=>$penjualanID,
					'produk_id'=>$produkID,
					'qty'=>$qty,
					'harga'=>$harga,
					'subtotal'=>$subtotal,
					'keterangan'=>$keterangan,
					);
					$this->m_db->add_row('penjualan_detail',$d2);
					/*
					$sStok=array(
					'produk_id'=>$produkID,
					'toko_id'=>$toko,
					);
					$stokJual=$this->m_db->get_row('produk_stok',$sStok,'stok_jual');
					$stokXX=$stokJual+$qty;
					$dStok=array(
					'stok_jual'=>$stokXX,
					);
					$this->m_db->edit_row('produk_stok',$dStok,$sStok);
					*/
				}
				$dx['status']=TRUE;
				$dx['penjualanid']=$penjualanID;
			}else{
				$dx['status']=FALSE;
			}
		}else{
			$dx['status']=FALSE;
		}
		return $dx;
	}
	
	function konfirmasi_pembayaran($penjualanid,$invoice)
	{
		$s=array(
		'penjualan_id'=>$penjualanid,
		'invoice'=>$invoice,
		);
		if($this->m_db->is_bof('penjualan',$s)==FALSE)
		{
			$s2=array(
			'penjualan_id'=>$penjualanid,
			);
			if($this->m_db->is_bof('penjualan_detail',$s2)==FALSE)
			{
				$Detail=$this->m_db->get_data('penjualan_detail',$s2);
				$toko=toko_pusat();
				foreach($Detail as $row)
				{					
					$produkID=$row->produk_id;
					$qty=$row->qty;
					$s3=array(
					'produk_id'=>$produkID,
					'toko_id'=>$toko,
					);
					$s4=array(
					'produk_id'=>$produkID,
					);
					$stok_jual=$this->m_db->get_row('produk_stok',$s3,'stok_jual');
					$qtybaru=$stok_jual+$qty;
					$d=array(
					'stok_jual'=>$qtybaru,
					);
					$beli=$this->m_db->get_row('produk',$s4,'jumlah_beli');
					$belibaru=$beli+$qty;
					$d3=array(
					'jumlah_beli'=>$belibaru,
					);
					$this->m_db->edit_row('produk_stok',$d,$s3);
					$this->m_db->edit_row('produk',$d3,$s4);
				}
				$d2=array(
				'status'=>'lunas',
				);
				$this->m_db->edit_row('penjualan',$d2,$s);
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
}