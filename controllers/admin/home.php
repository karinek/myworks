<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

    public function index(){
        $this->load->helper(array('url','date'));
        $this->load->model('M_session','',True);
        
        $admin_id = $this->M_session->is_auth_support();

        $this->load->model('M_user','',True);
        $data = $this->M_user->getAdminById($admin_id);

        $this->load->view('admin/modules/home_view',$data);
    }
        
    public function logout(){
        $this->load->library('session');
        $this->session->sess_destroy();
        $this->load->helper('url');
        redirect('admin/home');
    }
}
?>