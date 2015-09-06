<?php
require APPPATH.'/libraries/HB_controller.php';
class lang extends HB_Controller
{
    public function __construct() 
	{
        parent::__construct();
        $this->load->helper('url');
    } 
    function index($language = "") 
	{
        $language = ($language != "") ? $language : "english";	
		
        $this->session->set_userdata('site_lang', $language);
        redirect(base_url()."index");
    }
	function english_get() 
	{
		$get=$this->input->get();
		$page="";
		if($get['page']=="")
			$page=base_url()."index";
		else
			$page=base_url().urldecode($get['page']);
		$page=str_replace("&","?",$page);
        $language = "english";		
        $this->session->set_userdata('site_lang', $language);
       
        redirect($page);
    }
	function arabic_get() 
	{
		$get=$this->input->get();
		$page="";
		if($get['page']=="")
			$page=base_url()."index";
		else
			$page=base_url().urldecode($get['page']);
		
		$page=str_replace("&","?",$page);
        $language = "arabic";		
        $this->session->set_userdata('site_lang', $language);
		
        redirect($page);
    }
}