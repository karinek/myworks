<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Update_counter extends CI_Controller {
    
    public function index(){
	$this->load->model('m_category');
	$this->m_category->updateProductCounter();
    }
}
