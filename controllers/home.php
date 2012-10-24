<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

    public function index(){
        $this->load->helper(array('url','form'));
        $this->load->model('M_session','',True);
        $user_id = $this->M_session->getUserID();
        if ($user_id){
            $this->load->model('M_user','',True);
            $data = $this->M_user->getUserById($user_id);
            $data['company'] = $this->M_user->getCompanyByUser($user_id);
            $this->load->view('home_view',$data);
        } else {
            redirect('login');                }
    }
        
    public function logout(){
        $this->load->library('session');
		$this->load->model('M_session','',True);
		$userId=$this->M_session->isLogin();

        $this->session->sess_destroy();
		if(isset($userId)&&$userId){		
			$this->M_session->setOffLine($userId);
		}
        //unset($_SESSION['user_id']);
        $this->load->helper('url');
        redirect('/');
    }
}
?>