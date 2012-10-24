<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {
  
    public function index(){
		$this->load->helper('url');
		
		$user_id = $this->session->userdata('user_id');
		
		if($user_id){
			redirect('myoffice');
		}else{
			$template['layout'] = 'columns-content-right';
			$template['modules'] = array();
			$template['content'] = $this->load->view('register_view',$this->_init(),true);
			$this->load->view('template', $template);
		}
		
    }
    
    public function img_preview(){
		$config = array(
			'upload_path'   =>  realpath(APPPATH . '../images/user_images/temp'),
			'allowed_types' =>  'gif|jpg|png',
			'file_name' =>  time()
		);
	
		$this->load->library('upload', $config);
	  
		if (!$this->upload->do_upload()){
			echo $this->upload->display_errors();
		}else{
			$data = $this->upload->data();
			$config = array(
				'image_library'	=>'gd2',
				'source_image'	=> $data['full_path'],
				'width'	=>200,
				'height' =>200
			);
	
			$this->load->library('image_lib',$config);
			if ( ! $this->image_lib->resize()){
				echo $this->image_lib->display_errors();
			}
			echo $data['file_name'];
		}
    }
    
    public function auth(){
        $this->load->helper('url');
        $this->load->helper('string');
        $this->load->model('M_login','',True);
	$this->load->model('m_sugar');
	$this->load->model('M_vcode','',True);
        $this->load->helper('form');

// set form rles
        if(!$this->_register_validation()){
//            echo $this->input->post('captcha_code'); exit;
			$template['layout'] = 'columns-content-right';
			$template['modules'] = array();
			$template['content'] = $this->load->view('register_view',$this->_init(),true);
			$this->load->view('template', $template);
//           $this->load->view('register_view',$this->_init());
        } else {
            $data = array(
		'location' => $this->input->post('location'),
		'firstname'	=> $this->input->post('firstname'),
		'lastname'	=> $this->input->post('lastname'),
		'company'	=> $this->input->post('company'),
		'phone_country' => $this->input->post('phone_country'),
		'phone_area' => $this->input->post('phone_area'),
		'phone_number' => $this->input->post('phone_number'),
		'email'	=> $this->input->post('email'),
		'password'	=> MD5($this->input->post('password')),
		'status'	=> "pending",
		'verifycode'	=> random_string('alnum',10),
		'birth_day'	=> $this->input->post('birth_day'),
		'birth_month'	=> $this->input->post('birth_month'),
		'birth_year'	=> 1939 + $this->input->post('birth_year'),
		'gender'	=> $this->input->post('gender'),
		//'question'	=> $this->input->post('question'),
		//'answer'	=> $this->input->post('answer'),
		'create_date'   => date("Y-m-d H:i:s"),
                'role'          => $this->input->post('role'),
                'image' =>  $this->_upload_img($this->input->post('image_name'),$this->input->post('email'))
	    );
         
       
//	    if($this->input->post('role1') && $this->input->post('role2')){
//		$data['role'] = 'both';
//	    } else {
//		$data['role'] = $this->input->post('role1').$this->input->post('role2');
//	    }
        
            $res = $this->M_login->register($data);
            if ($res){
                $this->m_sugar->setUserToSugar($res);
                $session_data = $this->session->all_userdata();
                $data['username']=$session_data['username'];
                $data['varifymsg'] = "Last step, Please click the link in your email to verify your account";
                $template['layout'] = 'columns-content-right';
		$template['modules'] = array();
		$template['content'] = $this->load->view('register_view',$data,true);
                $this->load->view('template', $template);
//                $this->load->view('home_view',$data);
            } else {
                $this->load->library('session');
                $this->session->set_userdata('error','used email address');
                $template['layout'] = 'columns-content-right';
		$template['modules'] = array();
		$template['content'] = $this->load->view('register_view',$this->_init(),true);
                $this->load->view('template', $template);
                //redirect('register');
            }   
        }
        
    }
    
    public function _upload_img($oldname,$email){
		if(!$oldname || !is_file(realpath(APPPATH . '../images/user_images/temp').'/'.$oldname))
			return "";
		
		$res = explode(".",$oldname);
		$name = MD5($email).".".$res[1];
		
		copy('images/user_images/temp/'.$oldname,'images/user_images/'.$name);
		return $name;
    }
    
    public function verify(){
        $this->load->helper('url');
        $code = $this->uri->segment(3);
        $this->load->model('M_login','',True);
        $this->load->model('m_sugar');
        $this->load->model('m_session');
        $this->load->model('m_user');
        
        $res = $this->M_login->verify($code);
		$this->m_sugar->setUserToSugar($code,'verifycode');
        if($res){
            $user_id = $this->m_session->getUserID();
            $company = $this->m_user->getCompanyByUser($user_id);
            redirect('company');
        }else{
            redirect('login');
        }
        
    }
    
    public function _init(){
		$this->load->helper(array('form','url'));
		//$this->load->model('M_captcha','',True);
		$this->load->model('M_country','',True);
		$this->load->library('session');
		
		
		$data['country_options'] = $this->M_country->getAllCountryName();
		//array_splice($data['country_options'],0,0,array(''=>'--Select Country--'));
		
		$data['year_options'] = range(1930, date("Y"));
		array_splice($data['year_options'],0,0,array(''=>'--year--'));
		$data['month_options'] = range(1, 12);
		array_splice($data['month_options'],0,0,array(''=>'--month--'));
		$data['day_options'] = range(1, 31);
		array_splice($data['day_options'],0,0,array(''=>'--day--'));
		
		$data['question_options'] = array(
				'' => '-Select One-',
				'What is the first name of your favorite uncle?'=> 'What is the first name of your favorite uncle?',
				'Where did you meet your spouse?' => 'Where did you meet your spouse?');
		
		//$data['captcha'] = $this->M_captcha->CreateImage();
		//var_dump($data['captcha']);
		//exit;
		//$data['hidden'] = array('captcha_code' =>  $data['captcha']['word']);
		$session_data = $this->session->all_userdata();
		$this->session->unset_userdata('error');
		if (isset($session_data['error']))
			$data['error'] = $session_data['error'];
		else
			$data['error'] = "";

		return $data;
    }
    
    public function _register_validation(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('location', 'Location', 'required');
		$this->form_validation->set_rules('role', 'Role', 'callback__role_check');
//		$this->form_validation->set_rules('role2', 'Role', 'callback__role_check');
		$this->form_validation->set_rules('firstname', 'Firstname', 'required|callback__name_check');
		$this->form_validation->set_rules('lastname', 'Lastname', 'required|callback__name_check');
		$this->form_validation->set_rules('gender', 'Gender', 'required');
		$this->form_validation->set_rules('company', 'Company', 'required');
		$this->form_validation->set_rules('phone_country', 'TEL', 'required|callback__tel_check');
		$this->form_validation->set_rules('phone_area', 'TEL', 'numeric|callback__tel_check');
		$this->form_validation->set_rules('phone_number', 'TEL', 'numeric|callback__tel_check');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback__email_check');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[20]|alpha_numeric');
		$this->form_validation->set_rules('repassword', 'Confirm Password', 'required|matches[password]');
		$this->form_validation->set_rules('captcha', 'Captcha', 'required|callback__captcha_check');
		$this->form_validation->set_rules('agreement', 'Agreement', 'required');
		$this->form_validation->set_rules('image_name', 'Image', '');
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
	
	
		if ($this->form_validation->run() == FALSE) {
			return FALSE;
		} else {
			return TRUE;
		}
    }

    public function _captcha_check(){
	$this->load->library('session');
	if ($this->input->post('captcha') == $this->session->userdata('captcha')){
	    $this->session->unset_userdata('captcha');
	    return TRUE;
	}
	$this->form_validation->set_message('_captcha_check', 'Please enter the word correctly.');
        return FALSE;
    }
    
    public function _name_check(){
	if ($this->input->post('firstname') && $this->input->post('lastname'))
	    return TRUE;
	$this->form_validation->set_message('_name_check', 'Please fill your full name.');
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
    
    public function _email_check(){
        if($this->input->post('email'))
	    return TRUE;
	$this->form_validation->set_message('_email_check', 'Please choose email.');
        return FALSE;
    }
}    

