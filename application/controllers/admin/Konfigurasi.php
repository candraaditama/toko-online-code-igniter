<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konfigurasi extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('m_db');
		if(akses()!="admin")
		{
			$this->login_model->user_logout();
		}
	}
	
	function index()
	{
		$meta['judul']="Konfigurasi Aplikasi";
		$this->load->view('tema/header',$meta);
		$d['data']=$this->m_db->get_data('konfigurasi',array('tipe'=>'umum'));
		$this->load->view(akses().'/konfigurasi/umum',$d);
		$this->load->view('tema/footer');
	}
	
	function updateumum()
	{
		foreach($_POST as $k=>$v)
		{
			$s=array(
			'nama_key'=>$k,
			);
			$d=array(
			'isi'=>$v,
			);
			$this->m_db->edit_row('konfigurasi',$d,$s);
		}
		redirect(base_url(akses().'/konfigurasi'));
	}
	
	function tema()
	{
		$meta['judul']="Konfigurasi Tema";
		$this->load->view('tema/header',$meta);		
		$this->load->view(akses().'/konfigurasi/tema');
		$this->load->view('tema/footer');
	}
	
	function temaupdate()
	{
		foreach($_POST as $k=>$v)
		{
			$s=array(
			'nama_key'=>$k,
			);
			$d=array(
			'isi'=>$v,
			);
			$this->m_db->edit_row('konfigurasi',$d,$s);
		}
		redirect(base_url(akses().'/konfigurasi/tema'));
	}
	
	function logoupdate()
	{
		$gambar=$_FILES['file']['name'];		
        $ext=pathinfo($gambar,PATHINFO_EXTENSION);
		$imgname="logo-".md5(user_info('user_id')).".".$ext;
		$path = FCPATH.'assets/images/';
		$allow= "jpg|bmp|gif|png|jpeg";
		$maxsize	= 1000;
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
        	$s=array(
			'nama_key'=>'tema-logo',
			);
			$d=array(
			'isi'=>$imgname,
			);
			$this->m_db->edit_row('konfigurasi',$d,$s);
			echo json_encode(array(
			'status'=>'ok',
			'message'=>'Avatar berhasil diupload dan diubah',
			'url'=>base_url().'assets/images/'.$imgname,
			));
        }else{
			echo json_encode(array(
			'status'=>'no',
			'message'=>'Avatar gagal diupload dan diubah.',
			));
		}
	}
}