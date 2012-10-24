<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Help extends CI_Controller {
    public function safety_security(){
	$this->load->helper(array('url'));
        
	$type = $this->uri->segment(3);
	$item = $this->uri->segment(4);
	
	if (!$type){
	    $this->load->view('help/index');
	    
	} else if ($type == "class"){
	    if ($item == "buying")
		$this->_class_buying();
	    else if($item == "selling")
		$this->_class_selling();
	    else if($item == "ban")
		$this->_class_ban();
	    else if($item == "fraudcase")
		$this->_class_fraudcase();
	    else
		$this->_class_account();
	} else if ($type == "policy") {
	    if ($item == "product")
		$this->_policy_product();
	    else if ($item == "IPR")
		$this->_policy_ipr();
	    else if ($item == "dispute")
		$this->_policy_dispute();
	    else if ($item == "other")
		$this->_policy_other();
	    else
		$this->_policy_agreement();
	}
    }
    
    
    public function _class_buying(){
	$this->load->view('help/side_view');
	$this->load->view('help/class/buying_view');
	$this->load->view('help/class/ban_members_view');
    }
    
    public function _class_selling(){
	$this->load->view('help/side_view');
	$this->load->view('help/class/selling_view');
	$this->load->view('help/class/ban_members_view');
    }
    
    public function _class_ban(){
	$month = $this->uri->segment(5);
	if (!$month) {
	    $this->load->view('help/side_view');
	    $this->load->view('help/class/ban_members_view');
	} else {
	    $this->load->view('help/side_view');
	    $this->load->view('help/class/ban_month_view');
	}
    }
    
    public function _class_fraudcase(){
	$this->load->view('help/side_view');
	$this->load->view('help/class/fraud_case_view');
    }
    
    public function _class_account(){
	$this->load->view('help/side_view');
	$this->load->view('help/class/account_view');
    }
    
    public function _policy_agreement(){
	$this->load->view('help/side_view');
	$this->load->view('help/policy/agreement_view');
    }
    
    public function _policy_product(){
	$this->load->view('help/side_view');
	$this->load->view('help/policy/product_view');
    }
    
    public function _policy_ipr(){
	$this->load->view('help/side_view');
	$this->load->view('help/policy/ipr_view');
    }

    public function _policy_dispute(){
	$this->load->view('help/side_view');
	$this->load->view('help/policy/dispute_view');
    }
    
    public function _policy_other(){
	$this->load->view('help/side_view');
	$this->load->view('help/policy/other_view');
    }

}
?>