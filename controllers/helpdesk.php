<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Helpdesk extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form','url','html'));
        $this->load->library('session');
        $this->load->model('m_session','',True);
        $this->load->model('M_category','',True);
        $this->load->model('M_user','',True);
        $this->load->model('M_currency','',True);
        $this->load->model('M_options','',True);
        $this->load->model('M_helpdesk','',True);
        
     }
     
     public function index(){
        
        $user_id = $this->m_session->getUserID();
        $user = $this->M_user->getUserById($user_id);
       
        $data = array();
        $data['user'] = $user;
        $data['hidden'] = array('user_id'   =>  $user['id']);
        $data['sections'] = $this->M_helpdesk->getSections();
        $data['msg'] = false;
        $template['title'] = 'Help Desk';
        $template['layout'] = 'company';
        $template['content'] = $this->load->view('modules/helpdesk/ask_form',$data,true);
        $template['modules'] = array(
            'login' => 1,
            'top-menu' => 1
        );
        $this->load->view('template',$template);
    }
    
    public function _validate() {
        
    }
    
    public function add() {
        $data = array(
                    'user_id'   =>  $this->input->post('user_id'),
                    'section_id'   =>  (int)$this->input->post('section'),
                    'priority'   =>  $this->input->post('priority'),
                    'message'   =>  $this->input->post('message'),
                    'date'  => date("Y-m-d H:i:s"),
        			'status' => 'active'
                    );
        if($data['user_id'] && $data['message'])
	        $this->M_helpdesk->insertMessage($data);
        redirect('');
    }
}
?>