<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Active_product extends CI_Controller {
    
    public function index(){
	$this->load->model('M_cron','',True);
	$this->M_cron->active_product(3000);
    }
}
