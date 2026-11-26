<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Katalog extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('m_db');
	}
	
	function index()
	{
		
	}
}