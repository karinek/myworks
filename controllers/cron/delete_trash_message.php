<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Delete_trash_message extends CI_Controller {
    
    public function index(){
      
	$this->load->model('m_message');
	$this->m_message->DeleteTrashMessage('14');
    }
}
