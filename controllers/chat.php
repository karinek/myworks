<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Chat extends CI_Controller {
	/**
	* Chat controller 
	*/
	public function index($user_to_id=0,$company_to_id=0,$product_to_id=0,$product_type=''){
		$this->load->helper(array('form'));
		$this->load->library('session');
		$chats=$this->session->userdata('chats');
		$this->load->model('M_chat');
		$this->load->model('M_session','',True);
		$userID = $this->M_session->isLogin();

		if(!isset($userID)||!$userID){
            $this->session->set_userdata('previous_url',$this->M_session->full_url());
			$template['content'] = $this->load->view('chat/login',array(), true);
			$this->load->view('chat-login-template', $template);
			return false;
		}
		$this->session->unset_userdata('previous_url');

		if($user_to_id>0){//&&$company_to_id>0&&$product_to_id>0){
			if($userID>0)
				$template['chat_id']=$this->M_chat->initChat($userID,$user_to_id,$company_to_id,$product_to_id,$product_type);
			
		}
		$chats=$this->M_chat->getChats($userID);
		
		
		$usertolist=array();
		foreach($chats as $tchat_id=>$chat)
		{
		
			$usertolist[$chat['id']]=$this->M_chat->getUserById($chat['user_id']);
			if(!isset($template['chat_id']))
			{
				$template['chat_id']=$chat['id'];
			}
		}
		if(isset($template['chat_id'])&&isset($userID)&&$userID){
			$template['userto']=$this->M_chat->getUsersToByChatId($userID,$template['chat_id']);
			
		}
		$data=array();
		//$template['layout'] = 'columns-content-right';{
		$this->load->model('M_session','',True);
		$this->load->model('M_login','',True);
		$template['userID'] = $this->M_session->isLogin();
		$template['layout'] = 'chat';
		if(!isset($template['userID'])||!$template['userID'])
		{
			$template['login'] = $this->load->view('chat/login',array(), true);
			$template['signup'] = $this->load->view('chat/signup', $this->signup_init(), true);
			$template['auth'] = $this->load->view('chat/auth', $template, true);
		}
		else{
			$this->load->model('M_user','',True);
			$template['user']=$this->M_user->getUserById($template['userID']);
		}
		$template['usertolist']=$usertolist;
		$template['content'] = $this->load->view('chat/screen', $template, true);
		//$template['content'] = $this->load->view('register_view',$this->signup_init(),true);
		$this->load->view('chat-template', $template);
		//$this->load->view('default/chat', $template);
	}
	public function showchat($chat_id)
	{
		showchat($chat_id);
	}
	public function isnews(){
		$this->load->library('session');
		$this->load->model('M_chat','',True);
		$this->load->model('M_session','',True);
		$this->load->model('M_login','',True);
		$this->load->model('M_user','',True);
		$userID = $this->M_session->isLogin();
		$groups=$this->M_chat->getNewMessagesCount($userID);	
		$cnt=0;
		
		if(isset($groups)){
			foreach($groups as $group){
				$cnt+=$group['cnt'];
			}
		}		
		echo json_encode(array('count'=>$cnt,'groups'=>$groups));
		exit;
	}
	public function closechat($chat_id){
		$this->load->library('session');
		$this->load->model('M_chat','',True);
		$this->load->model('M_session','',True);
		$this->load->model('M_login','',True);
		$this->load->model('M_user','',True);
		$userID = $this->M_session->isLogin();
		$this->M_chat->closeChat($userID,$chat_id);
		$chats=$this->M_chat->getChats($userID);
//		if(isset($chats[0]['id'])){
//			showchat($chats[0]['id']);
//		}else{
			showchat(-1);
//		}
	}
	public function auth()
	{
		$this->load->helper('url');
		$this->load->helper('string');
		$this->load->model('M_login','',True);
		$this->load->model('m_sugar');
		$this->load->model('M_vcode','',True);
		$this->load->helper('form');
		// set form rles
		if(!$this->_signup_validation())
		{
			//            echo $this->input->post('captcha_code'); exit;
			$template['layout'] = 'chat';
			if(!isset($template['userID'])||!$template['userID'])
			{
				$template['login'] = $this->load->view('chat/login',array(), true);
				$template['signup'] = $this->load->view('chat/signup', $this->signup_init(), true);
				$template['auth'] = $this->load->view('chat/auth', $template, true);
			}
			$template['content'] = $this->load->view('chat/screen', $template, true);
			$this->load->view('chat-template', $template);
		}
		else {
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
			'birth_year'	=> 1900 + $this->input->post('birth_year'),
			'gender'	=> $this->input->post('gender'),
			//'question'	=> $this->input->post('question'),
			//'answer'	=> $this->input->post('answer'),
			'create_date'   => date("Y-m-d H:i:s"),
			'role'          => $this->input->post('role'),
			'image' => null,
			'member_id'=>'',
			'is_assessed'=>'',
			'last_ip'=>$_SERVER['REMOTE_ADDR'],
			'position'=>null,
			'last_login_date'=>date("Y-m-d H:i:s"),
			'contact_count'=>0,
			'buying_count'=>0,
			'selling_count'=>0);
			$res = $this->M_login->register($data);
			if ($res)
			{
				$this->m_sugar->setUserToSugar($res);
				$session_data = $this->session->all_userdata();
				$data['username']=$session_data['username'];
				$data['varifymsg'] = "Last step, Please click the link in your email to verify your account";
				$template['layout'] = 'chat';
				if(!isset($template['userID'])||!$template['userID'])
				{
					$template['login'] = $this->load->view('chat/login',array(), true);
					$template['signup'] = $this->load->view('chat/signup', $this->signup_init(), true);
					$template['auth'] = $this->load->view('chat/auth', $template, true);
				}
				$template['content'] = $this->load->view('chat/screen', $template, true);
				$this->load->view('chat-template', $template);
			}
			else {
				$this->load->library('session');
				$this->session->set_userdata('error','used email address');
				$template['layout'] = 'chat';
				if(!isset($template['userID'])||!$template['userID'])
				{
					$template['login'] = $this->load->view('chat/login',array(), true);
					$template['signup'] = $this->load->view('chat/signup', $this->signup_init(), true);
					$template['auth'] = $this->load->view('chat/auth', $template, true);
				}
				$template['content'] = $this->load->view('chat/screen', $template, true);
				$this->load->view('chat-template', $template);
			}
		}
	}
	public function login()
	{
		$this->load->helper(array('url','date'));
		$this->load->model('m_sugar');
		$this->load->model('M_session','',True);
		$this->load->model('M_login','',True);
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$res = $this->M_login->login($email,$password);
		if ($res)
		{
			$data = array(
			'last_ip' => $this->input->ip_address(),
			'last_login_date' => date("Y-m-d H:i:s")
				);
			$this->load->model('M_user','',True);
			$this->M_user->update($res,$data);
			$this->M_session->setOnLine($res);
			// Update Sugar data
			$this->m_sugar->setUserToSugar($res);
			$this->load->library('session');
			echo json_encode(array('res'=>1));
		}
		else {
			echo json_encode(array('res'=>0,'login_fail'=>'Wrong Password'));
		}
		exit;
	}
	public function signup_init()
	{
		$this->load->helper(array('form','url'));
		//$this->load->model('M_captcha','',True);
		$this->load->model('M_country','',True);
		$this->load->library('session');
		$data['country_options'] = $this->M_country->getAllCountryName();
		//array_splice($data['country_options'],0,0,array(''=>'--Select Country--'));
		$data['year_options'] = range(1900, date("Y"));
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
	public function _signup_validation()
	{
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
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		if ($this->form_validation->run() == FALSE)
		{
			return FALSE;
		}
		else {
			return TRUE;
		}
	}
	public function _captcha_check()
	{
		$this->load->library('session');
		if ($this->input->post('captcha') == $this->session->userdata('captcha'))
		{
			$this->session->unset_userdata('captcha');
			return TRUE;
		}
		$this->form_validation->set_message('_captcha_check', 'Please enter the word correctly.');
		return FALSE;
	}
	public function _name_check()
	{
		if ($this->input->post('firstname') && $this->input->post('lastname'))
			return TRUE;
		$this->form_validation->set_message('_name_check', 'Please fill your full name.');
		return FALSE;
	}
	public function _tel_check()
	{
		if ($this->input->post('phone_country') && $this->input->post('phone_area') && $this->input->post('phone_number'))
			return TRUE;
		$this->form_validation->set_message('_tel_check', 'Please fill your telphone number.');
		return FALSE;
	}
	public function _role_check()
	{
		if($this->input->post('role'))
			return TRUE;
		$this->form_validation->set_message('_role_check', 'Please choose your role.');
		return FALSE;
	}
	public function _email_check()
	{
		if($this->input->post('email'))
			return TRUE;
		$this->form_validation->set_message('_email_check', 'Please choose email.');
		return FALSE;
	}
	public function proccess($chat_id)
	{
		$this->load->library('session');
		$this->load->model('M_chat','',True);
		$this->load->model('M_session','',True);
		$this->load->model('M_login','',True);
		$this->load->model('M_user','',True);
		$userID = $this->M_session->isLogin();
		$_chat = null;
		if(isset($userID)&&$userID && $chat_id){
			$_chat = $this->M_chat->getStatus($chat_id);
			if( isset($_POST['message']) && $_chat->status != 'close'){
				if( !empty($_POST['message'])){
					$message = strip_tags(mysql_real_escape_string(trim($_POST['message']))); 						
					
					$this->M_chat-> addMessage($userID,$chat_id,$message);
				}
			}
			$this->drawmessages($chat_id);
		}
	}
	public function drawmessages($chat_id)
	{
		$this->load->library('session');			
		$this->load->model('M_session','',True);
		$userID = $this->M_session->isLogin();
		echo getdrawmessages($userID,$chat_id);
		exit;
	}
}	
	/* End of file chat.php */
/* Location: ./application/controllers/chat.php */