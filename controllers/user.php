<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
    
    function __construct(){
            parent::__construct();
            
            $this->load->helper(array('form','url','html'));
            $this->load->library('session');
            $this->load->model('M_options','',True);
            $this->load->model('M_company','',True);
            $this->load->model('M_country','',True);
            $this->load->model('m_session','',True);
            $this->load->model('M_category','',True);
            $this->load->model('m_sugar');
            $this->load->model('M_optionBusinessType','',True);
            $this->load->model('M_user','',True);
            $this->load->model('m_addto');
    }
    
    public function _init(){
        $user_id = $this->m_session->getUserID();
        $data['user'] = $this->M_user->getUserById($user_id);
        $company_id = $this->M_user->getCompanyByUser($user_id);
        $data['user']['company'] = $this->M_company->getCompanyById($company_id);
        
        $data['country_options'] = $this->M_country->getAllCountryName();
        $data['year_options'] = range(1900, date("Y"));
        array_splice($data['year_options'],0,0,array(''=>'--year--'));
        $data['month_options'] = range(1, 12);
        array_splice($data['month_options'],0,0,array(''=>'--month--'));
        $data['day_options'] = range(1, 31);
        array_splice($data['day_options'],0,0,array(''=>'--day--'));

        $session_data = $this->session->all_userdata();
        $this->session->unset_userdata('error');
        if (isset($session_data['error']))
                $data['error'] = $session_data['error'];
        else
                $data['error'] = "";

        return $data;
    }
    
    public function editprofile(){
        $template = $this->_init();
        $template['modules'] = array(
            'login' => 1,
            'category-menu' => 1,
            'top-menu' => 1
        );
        
        $template['categories'] = $this->M_category->getCategories();
        $template['countries'] = $this->M_country->getAllCountryName();
        $template['business_type_options'] = $this->M_company->getAllBusinessType();
        $template['content'] = $this->load->view('modules/user/profile',$template, True);
        $template['layout'] = 'company';
        $this->load->view('template', $template);
    }
    
    public function do_editprofile(){
        $this->load->helper('url');
        $template = $this->_init();
        $data = array(
            'location' => $this->input->post('location'),
            'firstname'	=> $this->input->post('firstname'),
            'lastname'	=> $this->input->post('lastname'),
            'gender'	=> $this->input->post('gender'),
            'birth_day'	=> $this->input->post('birth_day'),
            'birth_month' => $this->input->post('birth_month'),
            'birth_year' => $this->input->post('birth_year'),
            'phone_country' => $this->input->post('phone_country'),
            'phone_area' => $this->input->post('phone_area'),
            'phone_number' => $this->input->post('phone_number'),
            'role'      => $this->input->post('role'),
            'position'      => $this->input->post('position'),
            'introduction'      => $this->input->post('introduction'),
        );
        
        if($this->input->post('image_name')) {
            $data['image'] = $this->_upload_img($this->input->post('image_name'),$template['user']['email']);
        }
        
        
        // set form rles
        if(!$this->_profile_validation()){
            $image = $template['user']['image'];
            $template['user'] = $data;
            $template['user']['image'] = $image;
            $template['modules'] = array(
                'login' => 1,
                'category-menu' => 1,
                'top-menu' => 1
            );

            $template['categories'] = $this->M_category->getCategories();
            $template['countries'] = $this->M_country->getAllCountryName();
            $template['business_type_options'] = $this->M_company->getAllBusinessType();
            $template['content'] = $this->load->view('modules/user/profile',$template, True);
            $template['layout'] = 'company';
            $this->load->view('template', $template);
        } else {
            $this->load->model('M_user','',True);
            $this->load->model('M_session','',True);
            $user_id = $this->M_session->getUserID();
            $this->M_user->update($user_id,$data);
            redirect('user/editprofile/');
        }    
        
    }
    
    public function _upload_img($oldname,$email){
	if(!$oldname)
	    return "";
	
	$res = explode(".",$oldname);
	$name = MD5($email).".".$res[1];
	
	copy('images/user_images/temp/'.$oldname,'images/user_images/'.$name);
	return $name;
    }
    
    public function _profile_validation(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('location', 'Location', 'required|callback__location_check');
		$this->form_validation->set_rules('role', 'Role', 'callback__role_check');
		$this->form_validation->set_rules('firstname', 'Firstname', 'required|callback__firstname_check');
		$this->form_validation->set_rules('lastname', 'Lastname', 'required|callback__lastname_check');
		$this->form_validation->set_rules('gender', 'Gender', 'required');
		$this->form_validation->set_rules('phone_country', 'TEL', 'required|callback__tel_check');
		$this->form_validation->set_rules('phone_area', 'TEL', 'numeric|callback__tel_check');
		$this->form_validation->set_rules('phone_number', 'TEL', 'numeric|callback__tel_check');
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
	
		if ($this->form_validation->run() == FALSE) {
			return FALSE;
		} else {
			return TRUE;
		}
    }
    
    public function _location_check(){
	if ($this->input->post('location'))
	    return TRUE;
	$this->form_validation->set_message('_location_check', 'Please select your location.');
        return FALSE;
    }

    public function _firstname_check(){
	if ($this->input->post('firstname'))
	    return TRUE;
	$this->form_validation->set_message('_name_check', 'Please fill your first name.');
        return FALSE;
    }
    
    public function _lastname_check(){
	if ($this->input->post('lastname'))
	    return TRUE;
	$this->form_validation->set_message('_name_check', 'Please fill your last name.');
        return FALSE;
    }
    
    public function _tel_check(){
	if ($this->input->post('phone_country') && $this->input->post('phone_area') && $this->input->post('phone_number'))
	    return TRUE;
	$this->form_validation->set_message('_tel_check', 'Please fill your telphone number.');
        return FALSE;
    }
    
    public function _role_check(){
	if($this->input->post('role'))
	    return TRUE;
	$this->form_validation->set_message('_role_check', 'Please choose your role.');
        return FALSE;
    }
    
    public function change_password($error = array()){
        $template = $this->_init();
        $user_id = $this->m_session->getUserID();
        if ($user_id){
            $template['modules'] = array(
                'login' => 1,
                'category-menu' => 1,
                'top-menu' => 1
            );
           $template['layout'] = 'company';
           if(is_array($error) && !empty($error)) {
               $template = array_merge($template, $error);
           }
           $template['categories'] = $this->M_category->getCategories();
           $template['countries'] = $this->M_country->getAllCountryName();
           $template['business_type_options'] = $this->M_company->getAllBusinessType();
           $template['content'] = $this->load->view('modules/user/change_password',$template,true);
           $this->load->view('template', $template);
        } else {
            redirect('login');                
        }
    }
    
    /*   forget_password:     display field to let user input his email address
    *    reset_password:      generate temp password to DB and send email
    *    new_password:        force users to submit new password
    *    update_password:     update DB
    */
    public function update_change_password(){
        if(!$this->input->post('password'))
            redirect('user/change_password');
        $oldpassword = $this->input->post('password');
        $newpassword = $this->input->post('newpassword');
        $confnewpassword = $this->input->post('confnewpassword');
        $user_id = $this->m_session->getUserID();
        
        $checkOldPass = $this->M_user->checkPassword($user_id, $oldpassword);
        
        if(!$checkOldPass){
             $error = array('error' => 'Please enter valid password.');
             $this->change_password($error);
        } elseif($newpassword == '' && $confnewpassword == ''){
             $error = array('error' => 'Please enter new password.');
             $this->change_password($error);
        } elseif($newpassword != $confnewpassword){
             $error = array('error' => 'New Password and Confirm New Password do not match.');
             $this->change_password($error);
        } elseif($checkOldPass && $newpassword == $confnewpassword){
            $this->M_user->changePassword($user_id, $oldpassword, $newpassword);
            redirect('user/editprofile');
        }
    }
    
    public function membership(){
        $this->load->helper(array('url','form'));
	$this->load->model('M_user','',True);
	$this->load->model('M_company','',True);
	$this->load->model('M_session','',True);
        $this->load->model('M_country','',True);
        $this->load->model('M_category','',True);
        $user_id = $this->M_session->isLogin();
        if($user_id){
            $template['user'] = $this->M_user->getUserById($user_id);
        } else {
            $template['user'] = array();
        }
        
        $template['modules'] = array(
            'login' => 1,
            'category-menu' => 1,
            'top-menu' => 1
        );
        
        $template['content'] = $this->load->view('modules/user/membership',$template,true);
        $template['categories'] = $this->M_category->getCategories();
        $template['countries'] = $this->M_country->getAllCountryName();
        $template['business_type_options'] = $this->M_company->getAllBusinessType();
        $template['layout'] = 'company';
	$this->load->view('template', $template);
    }
    
    public function upgrade(){
		$this->load->helper(array('url','form'));
		$this->load->model('M_user','',True);
		$this->load->model('M_company','',True);
		$this->load->model('M_session','',True);
		$this->load->model('M_country','',True);
		$this->load->model('M_membership','',True);
		$user_id = $this->M_session->getUserID();
	
		$method = $this->input->post('fee');
		
		$types = $this->M_membership->getTypes();
		$template['fees'] = $types;
	
		$template['modules'] = array(
			'login' => 1,
			'category-menu' => 1,
			'top-menu' => 1
		);

		$template['user'] = $this->M_user->getUserById($user_id);
		$company_id = $this->M_user->getCompanyByUser($user_id);
		$template['company'] = $this->M_company->getCompanyById($company_id);
			
		if ($this->input->post('membership_option')) {
			$template['content'] = $this->_step2($template);
		} else if($this->input->post('payment')){
			$template['content'] = $this->_step4($template);
		} else if($this->input->post('method')){
			$template['content'] = $this->_step3($template);
		} else {   
			$template['content'] = $this->_step1($template);
		}		
		$template['layout'] = 'company';
		$this->load->view('template', $template);
    }   
        
	public function _step1($template){
		return $this->load->view('modules/user/upgrade_view1',$template,true);
	}
    
    public function _step2($template){
		$option = $this->input->post('membership_option');
		$optionArray = explode("_",$option);
		$template['chosen']['membership'] = $optionArray[0];
		$template['chosen']['period'] = $optionArray[1]." Months";
		$template['chosen']['fee'] = $template['fees'][$option];
		return $this->load->view('modules/user/upgrade_view2',$template,true);
    }
    
    public function _step3($template){
		$membership = $this->input->post('membership');
		$method = $this->input->post('method');
		$template['chosen']['membership'] = $membership;
		$template['chosen']['fee'] = $this->input->post('fee');
		$template['chosen']['period'] = $this->input->post('period');
		$template['chosen']['method'] = $this->input->post('method');
		
		if($method=='paypal'){
			$this->load->library(array('paypal'));
			$params['invoice'] = M_misc::limitStr((string)time(),9);
			$params['shipToName'] = $template['user']['id'];
			$params['shipToStreet'] = $template['company']['address'];
			$params['shipToCity'] = $template['company']['city'];
			$params['shipToState'] = $template['company']['state'];
			$params['shipToCountryCode'] = $template['company']['country'];
			$params['shipToZip'] = $template['company']['zip'];
			$params['shipToStreet2'] = $template['company']['email'];
			$params['phoneNum'] = $template['company']['phone_country']. $template['company']['phone_area']. $template['company']['phone_number'];
			$params['itemName'] = $template['chosen']['membership'].';'.$template['chosen']['period'];
			$params['itemDesc'] = 'Membership for TradeOffice';
			$params['itemQty'] = 1;
			$params['itemAmount'] = $template['chosen']['fee'];
			$this->session->set_userdata('Payment_Amount',$template['chosen']['fee']);
			$this->session->set_userdata('Payment_Item',$params['itemName']);
			$resArray = $this->paypal->CallMarkExpressCheckout($template['chosen']['fee'], $params['invoice'], $params['shipToName'], $params['shipToStreet'], $params['shipToCity'], $params['shipToState'], $params['shipToCountryCode'], $params['shipToZip'], $params['shipToStreet2'], $params['phoneNum'], $params['itemName'], $params['itemDesc'], $params['itemQty'], $params['itemAmount'],1);
			if($this->paypal->payflow){
				$ack = strtoupper($resArray["RESULT"]);
				if($ack=="0"){
					$this->paypal->RedirectToPayPal ( $resArray["TOKEN"] );
				}else{
					//Display a user friendly Error on the page using any of the following error information returned by Payflow
					$ErrorCode = $ack;
					$ErrorMsg = $resArray["RESPMSG"];
					
					echo "Error Message: " . $ErrorMsg;
					echo "Error Code: " . $ErrorCode;
				}
			}else{
				$ack = strtoupper($resArray["ACK"]);
				if($ack=="SUCCESS" || $ack=="SUCCESSWITHWARNING"){
					$this->paypal->RedirectToPayPal ( $resArray["TOKEN"] );
				}else{
				//Display a user friendly Error on the page using any of the following error information returned by PayPal
					// See Table 4.2 and 4.3 in http://www.paypal.com/en_US/pdf/PayflowPro_Guide.pdf for a list of RESULT values (error codes)
					$ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
					$ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
					$ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
					$ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);
				}
			}
		}else{
			return $this->load->view('modules/user/upgrade_view3',$template,true);
		}
    }
    
    public function _step4($template){
		$data_membership = array(
			'membership'        => $this->input->post('membership'),
			'fee'	        => $this->input->post('fee'),
			'period'	        => $this->input->post('period'),
			'method'	        => $this->input->post('method'),
			'ccNumber'          => $this->input->post('ccNumber'),
			'ccName'            => $this->input->post('ccName'),
			'month'	        => $this->input->post('month'),
			'year'              => $this->input->post('year'),
			'ccCVC'             => $this->input->post('ccCVC'),
			'address'           => $this->input->post('address'),
			'city'              => $this->input->post('city'),
			'state'             => $this->input->post('state'),
			'country'           => $this->input->post('country'),
			'zip'               => $this->input->post('zip'),
		);
        
		$template['chosen'] = $data_membership;
		
		if(!$this->_membership_validation()){
			return $this->load->view('modules/user/upgrade_view3',$template,true);
		} else {
			//$this->M_user->update($template['user']['id'],array('membership'=>$membership));
			//$this->M_company->update($template['company']['id'],array('membership'=>$membership));
			return $this->load->view('modules/user/upgrade_view4',$template,true);
		}
    }
    
    public function _membership_validation(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('ccNumber', 'Card Number *', 'required');
		$this->form_validation->set_rules('ccName', 'Name On Card *', 'required');
		$this->form_validation->set_rules('ccCVC', 'CVC *', 'required');
		$this->form_validation->set_rules('country', 'Country *', 'required');
		$this->form_validation->set_rules('city', 'City *', 'required');
		$this->form_validation->set_rules('address', 'Street Address *', 'required');
		$this->form_validation->set_error_delimiters('<span class="error" style="color:red;float:right;">', '</span>');
	
		if ($this->form_validation->run() == FALSE) {
			return FALSE;
		} else {
			return TRUE;
		}       
    }
    
    public function watchlist($error = array()){
	
		$this->load->helper(array('form'));
                
		$this->load->model(array('M_session','M_category','M_country','M_optionBusinessType','M_addTo', 'M_product'));
		$this->load->model('M_encrypt');
		$user_id = $this->m_session->getUserID();
		if ($user_id){
			$template['modules'] = array(
				'login' => 1,
				'category-menu' => 1,
				'top-menu' => 1
			);
			$template['layout'] = 'company';
			if(is_array($error) && !empty($error)) {
				$template = array_merge($template, $error);
			}
			
			if($this->input->post('products')){
				$products = $this->input->post('products');
				foreach($products as $product){
					$this->M_addTo->deleteFromWatchList($user_id, $product);
				}
			}
		
			$order = ($this->input->post('order'))?$this->input->post('order'):'';
			$page = $this->input->get_post('page')?$this->input->get_post('page'):1;
			$this->M_addTo->fav_page = $page;
		
			$res = $this->M_addTo->myWatchList($user_id, $order, true);
		
			$data['default'] = array(
					'order'=>$order,
					'page'=>$page,
			);
			$data['pagination'] = $res['pagination'];
			$data['pagination']['cur'] = $page;
			$data['products'] = $res['result'];
				
			$template['categories'] = $this->M_category->getCategories();
			$template['countries'] = $this->M_country->getAllCountryName();
			$template['business_type_options'] = $this->M_company->getAllBusinessType();
			$template['content'] = $this->load->view('modules/user/watchlists',$data,true);
			$this->load->view('template', $template);
		} else {
			redirect('login');                
		}
    }
}
?>