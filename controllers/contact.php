<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contact extends CI_Controller {
    
    
     public function replay_message($id)
    {
       $this->load->model('M_message','',True);
       $messagInfo = $this->M_message->getReplayById($id);
       
         
           $data['uid'] =  $messagInfo->row()->from_user_id;
           $data['cid'] =  $messagInfo->row()->from_company_id;
       
 
        $this->load->model(array('m_session'));
        if($this->m_session->isLogin())
        {
            $data['id'] = $id;
            $this->load->view('contact/send_message',$data);
          
        }else{
        $this->load->view('contact/login','');
        }
    }
    
    public function send_message($id)
    {
       $to = $this->input->get_post('to');
	   if($to=='company'){
	       $grtCompanyInfo =  $this->db->select('company.id AS cid,company.name as name,user_company.user_id AS uid')
                ->from('company')
                ->join('user_company', 'user_company.company_id = company.id')
                ->where('MD5(company.id)',$id)
                ->get();
	   }else{
	       $grtCompanyInfo =  $this->db->select('products.company_id AS cid,company.name as name,user_company.user_id AS uid')
                ->from('products')
                ->join('user_company', 'user_company.company_id = products.company_id')
                ->join('company', 'company.id = products.company_id')
                ->where('MD5(products.product_id)',$id)
                ->get();
	   }
       if($grtCompanyInfo->num_rows() == 1)
       {
           $data['name'] =  $grtCompanyInfo->row()->name;
           $data['uid'] =  $grtCompanyInfo->row()->uid;
           $data['cid'] =  $grtCompanyInfo->row()->cid;
       }
 
        $this->load->model(array('m_session'));
        if($this->m_session->isLogin())
        {
            $data['id'] = $id;
            $this->load->view('contact/send_message',$data);
          
        }else{
        $this->load->view('contact/login','');
        }
    }
     public function _upload_img($oldname,$newname){
	if(!$oldname)
	    return "";
	
	copy('files/message/temp/'.$oldname,'files/message/'.$newname);
	
    }
    public function save_message()
    {
       
        $data = array();
        $to_user_id = $_REQUEST['uid'];
        $to_company_id = $_REQUEST['cid'];
        
        
         $toUserInfo =  $this->db->select('users.id as id')
                ->from('users')
                ->where('MD5(id)',$to_user_id)
                ->get();
            if($toUserInfo->num_rows() == 1)
       {
           $data['to_user_id'] =  $toUserInfo->row()->id;
          
       }
          $toCompanyInfo =  $this->db->select('company.id as id')
                ->from('company')
                ->where('MD5(id)',$to_company_id)
                ->get();
      
         if($toCompanyInfo->num_rows() == 1)
       {
           $data['to_company_id'] =  $toCompanyInfo->row()->id;
          
       }
         
         
        
        $this->load->model('M_session','',True);
        $data['from_user_id'] = $this->M_session->getUserID();
        
    ///////////////////// contact limitation /////////////////
    $this->load->model('M_user','',True);
    $user = $this->M_user->getUserById($data['from_user_id']);
    $this->load->model('M_membership','',True);
    if ($this->M_membership->isContactLimited($user['membership'],$user['contact_count'])){
        echo "Sorry, you have reached your limitation for contacting as a Free memeber, upgrade now";
        exit;
    }
    $this->M_user->update($data['from_user_id'],array('contact_count' => $user['contact_count'] + 1));
    //////////////////////////////////////////////////////////
        
        
        $fromCompanyInfo =  $this->db->select('company.id AS id,company.name as name')
                ->from('company')
                ->join('user_company', 'user_company.company_id = company.id')
                ->where('user_company.user_id',$this->M_session->getUserID())
                ->get();
           if($fromCompanyInfo->num_rows() == 1)
       {
         
          $data['from_company_id'] =  $fromCompanyInfo->row()->id;
         
       }

		$this->db->insert('message_from_to',$data);
		$id = $this->db->insert_id(); 
		if(isset ($_REQUEST['file_name'])){
			foreach ($_REQUEST['file_name'] as $name){
			   $data = array();
			   $data['message_id'] = $id;
			   $names = explode("...", $name);
			   $data['file_path'] = $names[0];
			   $data['name'] = $names[1];
			   $this->db->insert('message_file',$data);
			   $this->_upload_img($names[0],$names[0]);
				
			}
		}
       
		$data = array();
		$data['message_id'] = $id;
		$data['date'] = date('Y-m-d');
		$data['subject'] = $_REQUEST['subject'];
		$data['text'] = $_REQUEST['message'];
		$this->db->insert('message',$data);
		$mes_id = $this->db->insert_id(); 

		$data = array();
		$data['message_id'] = $mes_id;
		$data['user_id'] = $this->M_session->getUserID();
		$data['star'] = 0;
		if(!$this->_isExist('message_starred',array('message_id'=>$data['message_id'],'user_id'=>$data['user_id']))){
			$this->db->insert('message_starred',$data);
		}
		
		$data = array();
		$data['message_id'] = $mes_id;
		$data['user_id'] = $toUserInfo->row()->id;
		$data['star'] = 0;

		if(!$this->_isExist('message_starred',array('message_id'=>$data['message_id'],'user_id'=>$data['user_id']))){
			$this->db->insert('message_starred',$data);
		}

		$data = array();
		$data['message_id'] = $mes_id;
		$data['user_id'] = $this->M_session->getUserID();
		$data['trash'] = 0;
		if(!$this->_isExist('message_trash',array('message_id'=>$data['message_id'],'user_id'=>$data['user_id']))){
			$this->db->insert('message_trash',$data);
		}
		
		$data = array();
		$data['message_id'] = $mes_id;
		$data['user_id'] = $toUserInfo->row()->id;
		$data['trash'] = 0;
		if(!$this->_isExist('message_trash',array('message_id'=>$data['message_id'],'user_id'=>$data['user_id']))){
			$this->db->insert('message_trash',$data);
		}

		$this->load->view('contact/thanks','');
    }
	
	function _isExist($table='',$clause=array()){
		$this->db->where($clause);
		$res = $this->db->get($table);
		if($res->num_rows()){
			return true;
		}
		return false;
	}
	
    public function file_preview()
    {
         $config = array(
	    'upload_path'   =>  realpath(APPPATH . '../files/message/temp'),
	    'allowed_types' =>  'docx|rar|gz|pdf|tar|zip|gif|jpg|jpeg|png|txt|doc',
	    'file_name' =>  time()
	);
 
		$this->load->library('upload', $config);
      
        if (!$this->upload->do_upload()){
            echo 1;
        }else{
            $data = $this->upload->data();
	      echo $data['file_name'];
        }
    }
    
    
}
 