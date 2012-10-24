<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Favorite extends CI_Controller {

    public function home(){
		$this->load->helper(array('url'));
		$this->load->model('M_favorite','',True);
		$this->load->model('M_session','',True);
		$user_id = $this->M_session->getUserID();
		
		$type = $this->uri->segment(3);
		
		$data['p_list'] = $this->M_favorite->getProduct($user_id);
		$data['c_list'] = $this->M_favorite->getCompany($user_id);
		
		$this->load->view('favorite_view',$data);
    }
    
    public function add_comment(){
	$this->load->model('M_favorite','',True);
	$data = array('comment' => $this->input->post('comment'));
	$type = $this->input->post('type');
	$f_id = $this->input->post('id');
	if ($type == 'p'){
	    $this->M_favorite->updateProduct($f_id,$data);
	} else if ($type == 'c'){
	    $this->M_favorite->updateCompany($f_id,$data);
	} else {
	
	}
    }
    
    public function add_favorite_company(){
	$this->load->model('M_favorite','',True);
	$this->load->model('M_session','',True);
	$user_id = $this->M_session->getUserID();
	
	$data = array(
	    'user_id' => $user_id,
	    'company_id' => $this->input->post('company_id'),
	    'comment' => "",
	    'add_time'	=> date('Y-m-d H:i:s')
	);
	
	if($this->M_favorite->insertCompany($data)){
	    echo "Done";
	} else {
	    echo "Did it before";
	}
    }
    
    public function add_favorite_product(){
	$this->load->model('M_favorite','',True);
	$this->load->model('M_session','',True);
	$user_id = $this->M_session->getUserID();
	
	$data = array(
	    'user_id' => $user_id,
	    'product_id' => $this->input->post('product_id'),
	    'comment' => "",
	    'add_time'	=> date('Y-m-d H:i:s')
	);
	
	if($this->M_favorite->insertProduct($data)){
	    echo "Done";
	} else {
	    echo "Did it before";
	}
    }
}
?>