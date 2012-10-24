<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Support extends CI_Controller {

    public function index(){
        $this->load->helper(array('url','form','date'));
        $this->load->model('M_session','',True);
        
        $admin_id = $this->M_session->is_auth_support();
        $this->load->model('M_user','',True);
        $data['admin'] = $this->M_user->getAdminById($admin_id);
         
        
        if ($data['admin']['type'] != 'admin'){
            echo "sorry, you are just a support, no right to see this page";
            exit;
        }
        $data['supports'] = $this->M_user->getAllAdmin();
        $this->load->view('admin/modules/support/index',$data);
    }
    
    public function add(){
        $this->load->helper(array('url','date'));
        
        $data = array(
            "username" =>           $this->input->post('username'),
            "password" =>           MD5($this->input->post('password')),
            "ip" =>                 $this->input->ip_address(),
            "last_login_time" =>    now(),
            "type" =>               $this->input->post('type')
        );
        $this->load->model('M_login','',True);
        $this->M_login->addAdmin($data);
        redirect('admin/support');
    }
    
    public function edit(){

        $this->load->helper(array('url','form'));
        $id = $this->uri->segment(4);
        $this->load->model('M_user','',True);
        $data = $this->M_user->getAdminById($id);
        $data['hidden'] = array('id' => $id);
        
        $this->load->view('admin/modules/support/edit',$data);
    }
    
    public function do_edit(){
        $this->load->helper(array('url','date'));
        
        $id = $this->input->post('id');
        $password =$this->input->post('password');
        $data = array(
            "username" =>           $this->input->post('username'),
            "type" =>               $this->input->post('type')
        );
        
        if($password)
            $data['password'] = MD5($password);
            
        $this->load->model('M_login','',True);
        $this->M_login->editAdmin($id,$data);
        redirect('admin/support');
    }
    
    public function ban(){
        $this->load->helper(array('url','form'));
        $id = $this->uri->segment(4);
        $this->load->model('M_login','',True);
        $this->M_login->editAdmin($id,array('status'=>'banned'));
        redirect('admin/support');
    }
}
?>