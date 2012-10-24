<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library(array('session','pagination'));
		$this->load->helper(array('url', 'form'));
		$this->load->model(array('m_forum','m_misc','m_session','M_encrypt'));
	}
	
	public function index(){
		$this->load->helper(array('form'));
		
		$this->load->model(array('m_session'));
		
		$template['content'] = $this->load->view('pages/home','',true);
		$this->load->view('template', $template);
	}
	
	public function information(){
		$this->load->helper(array('form'));
		
		$this->load->model(array('m_session'));
		
		$template['content'] = $this->load->view('pages/home','',true);
		$this->load->view('template', $template);
	}
	
	public function advertisers(){
		$this->load->helper(array('form'));
		
		$this->load->model(array('m_session'));
		
		$template['content'] = $this->load->view('pages/home','',true);
		$this->load->view('template', $template);
	}
	
	public function partners(){
		$this->load->helper(array('form'));
		
		$this->load->model(array('m_session'));
		
		$template['content'] = $this->load->view('pages/home','',true);
		$this->load->view('template', $template);
	}
	
	public function sitemap(){
		$this->load->helper(array('form'));
		
		$this->load->model(array('m_session'));
		
		$template['content'] = $this->load->view('pages/home','',true);
		$this->load->view('template', $template);
	}
	
	public function terms_of_service(){
		$template['title'] = 'Terms of Service';
		$template['layout'] = 'pages';
		$template['content'] = $this->load->view('pages/terms_of_service','',true);
		$template['modules'] = array(
			'login' => 1,
			'category-menu' => 1,
			'top-menu' => 1
		);
		$this->load->view('template', $template);
	}

	public function privacy_policy(){
		$template['title'] = 'Privacy Policy';
		$template['layout'] = 'pages';
		$template['content'] = $this->load->view('pages/privacy_policy','',true);
		$template['modules'] = array(
			'login' => 1,
			'category-menu' => 1,
			'top-menu' => 1
		);
		$this->load->view('template', $template);
	}

	public function membership_details(){
		$template['title'] = 'Membersip Details';
		$template['layout'] = 'membership';
		$template['content_prewrapper'] = '<img class="map" src="'.base_url('images/splash_map2.jpg').'" width="100%">';
		$template['content_class'] = 'membership_map_content';
		$template['content'] = $this->load->view('pages/membership_details','',true);
		$template['modules'] = array(
			'login' => 1,
			'category-menu' => 1,
			'top-menu' => 1
		);
		$this->load->view('template', $template);
	}

	public function product_list_policy(){
		$template['title'] = 'Product Listing Policy';
		$template['layout'] = 'pages';
		$template['content'] = $this->load->view('pages/product_list_policy','',true);
		$template['modules'] = array(
			'login' => 1,
			'category-menu' => 1,
			'top-menu' => 1
		);
		$this->load->view('template', $template);
	}

	public function intellectual_policy(){
		
		$template['title'] = 'Intellectual Property Infringment Policy';
		$template['layout'] = 'pages';
		$template['content'] = $this->load->view('pages/intellectual','',true);
		$template['modules'] = array(
			'login' => 1,
			'category-menu' => 1,
			'top-menu' => 1
		);
		$this->load->view('template', $template);
	}

	public function copyright(){
		
		$template['title'] = 'Copyright Notice';
		$template['layout'] = 'pages';
		$template['content'] = $this->load->view('pages/copyright','',true);
		$template['modules'] = array(
			'login' => 1,
			'category-menu' => 1,
			'top-menu' => 1
		);
		$this->load->view('template', $template);
	}
}