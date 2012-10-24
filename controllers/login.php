<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
    public function index(){
        $this->load->helper(array('url','form'));
        $this->load->library('session');
        $user_id = $this->session->userdata('user_id');
		if($user_id){
			redirect('myoffice');
		}else{
			$data['error'] = $this->session->userdata('login_fail');
			$this->session->unset_userdata('login_fail');
			
			$template['layout'] = 'columns-content-right';
			$template['modules'] = array();
			$template['content'] = $this->load->view('modules/login/login',$data,true);
			$this->load->view('template-splash', $template);
		}
    }
    
    public function auth(){
        $this->load->helper(array('url','date'));
		$this->load->model('m_sugar');
        $this->load->model('M_login','',True);
		$this->load->model('M_session','',True);
        
        $email = $this->input->post('email');
        $password = $this->input->post('password');
       
        $res = $this->M_login->login($email,$password);
        
        if (is_numeric($res)){
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
            $previous_url = $this->session->userdata('previous_url');
            $this->session->unset_userdata('previous_url');
            if ($previous_url)
                redirect($previous_url);
            redirect('welcome');
        } else {
            $this->load->library('session');
            $this->session->set_userdata('login_fail',$res);
            redirect('login');
        }
    }


public function password_confirmation ()
      {
          $this->load->library('session');
          $template['layout'] = 'columns-content-right';
	   $template['modules'] = array();
           if($this->session->userdata('email_confirmation')){
                $data['email'] = $this->session->userdata('email_confirmation');
                $this->db->where('email',$data['email']);
                $query = $this->db->get('users',1);
                if ($query->num_rows()==1){
                    
                    $data['name'] = $query->row()->firstname;
                }
                $this->session->unset_userdata('email_confirmation');
		$template['content'] = $this->load->view('modules/login/password_confirmation',$data,true);
                $this->load->view('template-splash', $template);
           }else{
                redirect('login/forget_password/');
           }
       }
       
    public function forget_password(){
              $this->load->helper('form');
              if(isset ($_GET['error']) && $_GET['error'] == 'yes')
              {
                  $data['error'] = 'This email is not registered in the database';
              }  else {
                  $data['error'] = '';
              }
		$template['layout'] = 'columns-content-right';
		$template['modules'] = array();
		$template['content'] = $this->load->view('modules/login/forget-password',$data,true);
		$this->load->view('template-splash', $template);
    }
    
    public function reset_password(){
       
        $this->load->helper(array('string','url'));
        $this->load->model('M_login','',True);
        $email = $this->input->post('email');
        $this->load->library('session');
        $this->session->set_userdata('email_confirmation',$email);
        $res = $this->M_login->reset_password($email);
        if ($res) {
            redirect('login/password_confirmation/');
        } else {
            redirect('login/forget_password/?error=yes');
        }
    }
    
    public function new_password(){
        $this->load->helper(array('form','url'));
        $data['hidden'] = array(
                        'old_password'    => $this->uri->segment(3)
                                );
		$template['layout'] = 'columns-content-right';
		$template['modules'] = array();
		$template['content'] = $this->load->view('modules/login/new-password',$data,true);
		$this->load->view('template-splash', $template);
    }
    
    public function update_password(){
        $this->load->helper('url');
        $old_password = $this->input->post('old_password');
        $new_password = $this->input->post('password');
        
        $this->load->model('M_login','',True);
        $res = $this->M_login->update_password($old_password,$new_password);
        if ($res) {
            redirect('login');
        } else {
            echo "the link is incorrect";
        }
    }
}

