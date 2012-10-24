<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
    public function index(){
        $this->load->helper(array('url','form'));
        $this->load->library('session');
        $this->load->view('admin/modules/login/index');
    }
    
    public function auth(){
        $this->load->helper(array('url','date'));
        $this->load->model('M_login','',True);
        
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        
        $res = $this->M_login->login_admin($username,$password);
        
        if ($res){
            $data = array(
                          'ip' => $this->input->ip_address(),
                          'last_login_time' =>    date("Y-m-d H:i:s")
                          );
            
            $this->load->model('M_login','',True);
            $this->M_login->editAdmin($res,$data);
            redirect('admin/home');
        } else {
            redirect('admin/login');
        }
    }
}

