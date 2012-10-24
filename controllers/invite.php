<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invite extends CI_Controller {
    
    
	function __construct(){
            parent::__construct();
	}
	
	function step1(){
		$this->load->helper(array('url','form'));
        $data = array();
		$this->load->view('modules/invite/step1',$data);
	}
	
	function step3(){
		
	}
	
	function step2(){
		
		$this->load->helper(array('url','form'));
		$this->load->model('M_invite','',True);
		
		$input_data = $_POST;
		$this->M_invite->insert($input_data);

		//return json_encode(array('status'=>true));
	}
	
	

}
?>