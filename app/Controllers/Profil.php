<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('m_db');
		$this->load->model('login_model');
		if(empty(akses()))
		{
			$this->login_model->user_logout();
		}
	}
	
	function index()
	{		
		$meta['judul']="Ubah Profil";
		$this->load->view('tema/header',$meta);
		$this->load->view('profilview');
		$this->load->view('tema/footer');
	}
	
	function uploadphoto()
    {
		$gambar=$_FILES['file']['name'];		
        $ext=pathinfo($gambar,PATHINFO_EXTENSION);
		$imgname="ava-".md5(user_info('user_id')).".".$ext;
		$path = FCPATH.'assets/images/avatar/';
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
			'user_id'=>user_info('user_id'),
			);
			$d=array(
			'photo'=>$imgname,
			);
			$this->m_db->edit_row('userlogin',$d,$s);
			echo json_encode(array(
			'status'=>'ok',
			'message'=>'Avatar berhasil diupload dan diubah',
			'url'=>base_url().'assets/images/avatar/'.$imgname,
			));
        }else{
			echo json_encode(array(
			'status'=>'no',
			'message'=>'Avatar gagal diupload dan diubah.',
			));
		}		
	}
	
	function profilupdate()
	{		
		$this->form_validation->set_rules('nama','Nama','required');
		if($this->form_validation->run())
		{			
			$s=array(
			'user_id'=>user_info('user_id'),
			);
			$nama=$this->input->post('nama',TRUE);
			$pass=$this->input->post('password',TRUE);
			if(!empty($pass))
			{				
				$dPass=array(
				'password'=>md5($pass),
				);				
				$this->m_db->edit_row('userlogin',$dPass,$s);
			}
			
			$d=array(
			'nama'=>$nama,
			);
			
			if($this->m_db->edit_row('userlogin',$d,$s)==TRUE)
			{
				set_header_message('success','Profil','Berhasil mengubah profil');
				redirect(base_url("profil"),'refresh',301);
			}else{
				set_header_message('danger','Profil','Gagal mengubah profil');
				redirect(base_url("profil"),'refresh',301);
			}
			
		}else{
			redirect(base_url("profil"),'refresh',301);
		}
	}
}