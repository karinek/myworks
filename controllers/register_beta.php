<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register_beta extends CI_Controller {
  
    function __construct(){
		parent::__construct();

		$this->load->helper(array('form','url','html'));
		$this->load->library('session');
		$this->load->model('M_country','',True);
		$this->load->model('M_encrypt');
		$this->load->model('m_sugar');
	}
	
	public function index(){
		$template['layout'] = 'columns-content-right';
		$template['modules'] = array();
		$data['country_options'] = $this->M_country->getAllCountryOptions();
		$template['content'] = $this->load->view('register_beta_view',$data,true);
		$this->load->view('template', $template);
    }
	
	public function forget(){
		$template['layout'] = 'columns-content-right';
		$template['modules'] = array();
		$data['country_options'] = "";
		$template['content'] = $this->load->view('register_beta_view',$data,true);
		$this->load->view('template', $template);
	}
    
	public function forget_password(){
		$data = array(
		'email'	=> $this->input->post('email'),
		'password'	=> $this->M_encrypt->encode($this->input->post('email'))
	    );
        $template['layout'] = 'columns-content-right';
		$template['modules'] = array();
		$template['content'] = $this->load->view('register_beta_forget_view',$data,true);
        $this->load->view('template', $template);
		
	}
	
	
	
    public function auth(){
        $this->load->helper('url');
        $this->load->model('M_login','',True);
		$this->load->model('m_sugar');
		$this->load->model('M_vcode','',True);
        $this->load->helper('form');

        
        $data = array(
		'location' => $this->input->post('location'),
		'company'	=> $this->input->post('company'),
		'email'	=> $this->input->post('email'),
		'password'	=> MD5($this->M_encrypt->encode($this->input->post('email'))),
		'status'	=> "actived",
		'create_date'   => date("Y-m-d H:i:s"),
		'verifycode'	=> "test",
		'firstname' 	=>"test"
	    );
        
		$res = $this->M_login->register($data);
        
		$data['password'] = $this->M_encrypt->encode($this->input->post('email'));
		
		
		$this->m_sugar->setUserToSugar($res);
        $template['layout'] = 'columns-content-right';
		$template['modules'] = array();
		$template['content'] = $this->load->view('register_beta_done_view',$data,true);
        $this->load->view('template', $template);
		
        
    }
    
 
}    

