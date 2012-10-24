<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Analytics extends CI_Controller {

    public function index(){
	$this->load->helper(array('url'));
	$link = $this->input->post('link');
	$keyword = $this->input->post('keyword');
	$ip = $this->input->ip_address();
	$time = date( 'Y-m-d H:i:s');
	
	$data = array(
		'link' => $link,
		'keyword' => $keyword,
		'ip' => $ip,
		'time' => $time
		);
	
	$this->load->model('M_analytics','',True);
	$this->M_analytics->insert($data);
    }
}
?>