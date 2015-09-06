<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class HB_controller extends REST_Controller 
{	
	public function __construct()
	{
		parent::__construct();				
		$this->load->library('session');		
		$this->load->helper('url');
		$this->load->helper('utilities_helper','utils');	
	
		$this->site_lang="";
		$this->site_lang=$this->session->userdata('site_lang');		
		if(isset($this->site_lang) && $this->site_lang!="")
		$this->site_lang=substr($this->site_lang,0,2);			
		else
	    $this->site_lang="en";		
		$newdata['gblTimeZone'] = 'Asia/Kolkata';
		$this->session->set_userdata($newdata);						
		$session_data=($this->session->all_userdata());
	
	}	
}
?>