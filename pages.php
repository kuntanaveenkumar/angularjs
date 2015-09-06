<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH.'/libraries/HB_controller.php';
class Pages extends HB_controller 
{
	function __construct()
	{		
		parent::__construct();		
		
	}
	public function index_get($page = 'index')
	{	
		
		
		$data=array();
		$data['session_data'] = $this->session->all_userdata();	
		
		$this -> load -> model('cms_model', 'Cms');
		$this->load->library('cache_fragment');
		$data['banners']=$this->Cms->getBanners();
		$priceranges=$this->Cms->priceRanges();
		$data['news']=$this->Cms->getHomeNews(); 
		$data['start_prange']=$priceranges['0']['start_range'];
		$data['end_prange']=$priceranges['0']['end_range'];		
		$arearanges=$this->Cms->areaRanges();
		$data['start_arange']=$arearanges['0']['start_area'];
		$data['end_arange']=$arearanges['0']['end_area'];
		$this->load->view($this->site_lang.'/layouts/indexheader-'.$this->site_lang.'.php',$data);	
		$this->load->view($this->site_lang.'/main-'.$this->site_lang.'.php',$data);		
		$this->load->view($this->site_lang.'/layouts/footer-'.$this->site_lang.'.php',$data);	        
	}	
	
	public function verifyemail_get($page='')
	{	
	
		$data=array();
		$data['session_data'] = $this->session->all_userdata();		
		$data['page_name']="verifyemail";

		$this->load->view($this->site_lang.'/layouts/header-'.$this->site_lang.'.php',$data);		
		$this->load->view($this->site_lang.'/verifyemail-'.$this->site_lang.'.php',$data);		
		$this->load->view($this->site_lang.'/layouts/footer-'.$this->site_lang.'.php',$data);
	}	
	public function login_get($page='')
	{	
		
		$data=array();
		$data['session_data'] = $this->session->all_userdata();		
		$data['page_name']="login";

		$this->load->view($this->site_lang.'/layouts/header-'.$this->site_lang.'.php',$data);		
		$this->load->view($this->site_lang.'/login-'.$this->site_lang.'.php',$data);		
		$this->load->view($this->site_lang.'/layouts/footer-'.$this->site_lang.'.php',$data);
	}	
	public function brokers_get($page='')
	{	
		
		$data=array();
		$data['session_data'] = $this->session->all_userdata();		
		$data['page_name']="brokers";
		$this -> load -> model('cms_model', 'Cms');		
		$priceranges=$this->Cms->priceRanges();
		$data['start_prange']=$priceranges['0']['start_range'];
		$data['end_prange']=$priceranges['0']['end_range'];
		$arearanges=$this->Cms->areaRanges();
		$data['start_arange']=$arearanges['0']['start_area'];
		$data['end_arange']=$arearanges['0']['end_area'];
		$this->load->view($this->site_lang.'/layouts/header-'.$this->site_lang.'.php',$data);		
		$this->load->view($this->site_lang.'/brokers-'.$this->site_lang.'.php',$data);		
		$this->load->view($this->site_lang.'/layouts/footer-'.$this->site_lang.'.php',$data);
	}	
	public function brokers1_get($page='')
	{	
		$data=array();
		$data['session_data'] = $this->session->all_userdata();		
		$data['page_name']="brokers1";
		$this -> load -> model('cms_model', 'Cms');		
		$priceranges=$this->Cms->priceRanges();
		$data['start_prange']=$priceranges['0']['start_range'];
		$data['end_prange']=$priceranges['0']['end_range'];
		$arearanges=$this->Cms->areaRanges();
		$data['start_arange']=$arearanges['0']['start_area'];
		$data['end_arange']=$arearanges['0']['end_area'];
		$this->load->view($this->site_lang.'/layouts/header-'.$this->site_lang.'.php',$data);		
		$this->load->view($this->site_lang.'/brokers1-'.$this->site_lang.'.php',$data);		
		$this->load->view($this->site_lang.'/layouts/footer-'.$this->site_lang.'.php',$data);
	}	
		public function ads_get($id)
	{	
		$data=array();
		$data['session_data'] = $this->session->all_userdata();		
		$data['page_name']="ads";
		$data['id']=$id;		
		$this->load->view($this->site_lang.'/ads-'.$this->site_lang.'.php',$data);		

	}	
	public function news_list_get()
	{
		$data=array();
		$data['session_data'] = $this->session->all_userdata();		
		$data['page_name']="news_list";
		$this -> load -> model('cms_model', 'Cms');		
		$priceranges=$this->Cms->priceRanges();
		$data['start_prange']=$priceranges['0']['start_range'];
		$data['end_prange']=$priceranges['0']['end_range'];
		$arearanges=$this->Cms->areaRanges();
		$data['start_arange']=$arearanges['0']['start_area'];
		$data['end_arange']=$arearanges['0']['end_area'];
		$this->load->view($this->site_lang.'/layouts/header-'.$this->site_lang.'.php',$data);		
		$this->load->view($this->site_lang.'/news_list-'.$this->site_lang.'.php',$data);		
		$this->load->view($this->site_lang.'/layouts/footer-'.$this->site_lang.'.php',$data);
	}
	public function broker_details_get($page='')
	{	
		$data=array();
		$data['session_data'] = $this->session->all_userdata();		
		$data['page_name']="broker_details";
		$this -> load -> model('cms_model', 'Cms');		
		$priceranges=$this->Cms->priceRanges();
		$data['start_prange']=$priceranges['0']['start_range'];
		$data['end_prange']=$priceranges['0']['end_range'];
		$arearanges=$this->Cms->areaRanges();
		$data['start_arange']=$arearanges['0']['start_area'];
		$data['end_arange']=$arearanges['0']['end_area'];
		$this->load->view($this->site_lang.'/layouts/header-'.$this->site_lang.'.php',$data);		
		$this->load->view($this->site_lang.'/broker_details-'.$this->site_lang.'.php',$data);		
		$this->load->view($this->site_lang.'/layouts/footer-'.$this->site_lang.'.php',$data);
	}	
	public function view_get($page='')
	{	
		$data=array();
		$data['session_data'] = $this->session->all_userdata();		
		$this -> load -> model('cms_model', 'Cms');
		$data['cms']=$this->Cms->getCms($page);
		$data['page_name']=$page;
		$this->load->view($this->site_lang.'/layouts/header-'.$this->site_lang.'.php',$data);		
		$this->load->view($this->site_lang.'/pages-'.$this->site_lang.'.php',$data);		
		$this->load->view($this->site_lang.'/layouts/footer-'.$this->site_lang.'.php',$data);
	}	
	public function contact_us_get()
	{
		$this->output->cache(30);
		$data=array();
		$data['session_data'] = $this->session->all_userdata();		
		$data['page_name']='contact_us';
		$this -> load -> model('cms_model', 'Cms');		
		$priceranges=$this->Cms->priceRanges();
		$data['start_prange']=$priceranges['0']['start_range'];
		$data['end_prange']=$priceranges['0']['end_range'];
		$arearanges=$this->Cms->areaRanges();
		$data['start_arange']=$arearanges['0']['start_area'];
		$data['end_arange']=$arearanges['0']['end_area'];
		$this->load->view($this->site_lang.'/layouts/header-'.$this->site_lang.'.php',$data);		
		$this->load->view($this->site_lang.'/contact_us-'.$this->site_lang.'.php',$data);		
		$this->load->view($this->site_lang.'/layouts/footer-'.$this->site_lang.'.php',$data);
	}	
	public function forgotpassword_get($page='')
	{	
		
		$data=array();
		$data['session_data'] = $this->session->all_userdata();		
		$data['page_name']="forgotpassword";
		$this->load->view($this->site_lang.'/layouts/header-'.$this->site_lang.'.php',$data);		
		$this->load->view($this->site_lang.'/forgotpassword-'.$this->site_lang.'.php',$data);		
		$this->load->view($this->site_lang.'/layouts/footer-'.$this->site_lang.'.php',$data);
	}	
	public function register_get()
	{
		
		$data=array();
		$data['session_data'] = $this->session->all_userdata();	
		$data['page_name']='register';

		$this->load->view($this->site_lang.'/layouts/header-'.$this->site_lang.'.php',$data);		
		$this->load->view($this->site_lang.'/register-'.$this->site_lang.'.php',$data);		
		$this->load->view($this->site_lang.'/layouts/footer-'.$this->site_lang.'.php',$data);
	}	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */