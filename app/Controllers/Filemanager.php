<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Filemanager extends CI_Controller
{
	public $pathUpload;
	public $urlUpload;
    function __construct()
    {
        parent::__construct();        
        $this->load->model('login_model');
        if(empty(akses()))
        {
			$this->login_model->user_logout();
		}
		
		$this->pathUpload=FCPATH.'assets/images/photo/';
		$this->urlUpload=base_url().'assets/images/photo/';
    }
    
    function index()
    {    	
        $meta['judul']="File Manager";
        $this->load->view('res/header',$meta);
        $this->load->view('filemanagerview');
        $this->load->view('res/footer');
    }
    
    function _get_user_folder()
    {
		$hashuser=md5(user_info('user_id'));    	
        $userfolder=$this->pathUpload;
        $userfolderurl=$this->urlUpload;
        
        $d=array();
        $d['path']=$userfolder;
        $d['url']=$userfolderurl;
        return $d;
	}
    
    function elfinder_init()
	{
	  $h=$this->_get_user_folder();
	  $opts = array(
	    // 'debug' => true, 
	    'roots' => array(
	      array( 
	        'driver' 			=> 'LocalFileSystem', 
	        'path'   			=> $h['path'], 
        	'URL'    			=> $h['url'],        	
	    	'uploadAllow' 		=> $this->_get_mime(),
	    	'accessControl' 	=> 'access',
	    	'attributes' => array(
               
            )
	        // more elFinder options here
	      ),	    
	    )
	  );
	  $this->load->library('elfinder_lib', $opts);
	}
	
	function _get_mime()
	{
		$d=include APPPATH.'config/mimes.php';
		extract($d,EXTR_OVERWRITE);
		$o=array();
		foreach($d as $k=>$v)
		{
			$o[]=$v;
		}
		return $o;
	}
	
	function index_single()
    {
    	$d['method']='single';
		$this->load->view('filemanagerview',$d);
	}
    
}