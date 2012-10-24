<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message extends CI_Controller {
	function __construct(){
		parent::__construct();

		$this->load->helper(array('form','url','html'));
		$this->load->library('session');
                
		$this->load->model('M_options','',True);
                
                $this->load->model('M_message','',True);
		$this->load->model('M_company','',True);
		$this->load->model('M_country','',True);
		$this->load->model('m_session','',True);
		$this->load->model('M_category','',True);
		$this->load->model('m_sugar');
		$this->load->model('M_optionBusinessType','',True);
		$this->load->model('M_user','',True);
                  $this->load->model('m_addto');
	}
            public function _init(){
        
        $data['country_options'] = $this->M_country->getAllCountryOptions();
        $data['business_type_options'] = $this->M_company->getAllBusinessType();
        $data['certification_options'] = $this->M_company->getAllCertification();
        $data['region_options'] = $this->M_company->getAllRegion();
        $data['service_options'] = $this->M_company->getAllService();
        
        $data['businessType']=$this->M_optionBusinessType->getBusinessTypes();
        $data['countries'] = $this->M_country->getAllCountryName();
        $data['categories'] = $this->M_category->getCategories();
        return $data;
    }
	public function inbox(){
              
		$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
		
		$this->M_message->fav_page = $page;
		
		
		$user_id = $this->m_session->getUserID();
		
		$template = $this->_init($user_id);
		$company = $this->M_company->getCompanyByUser($user_id);
		$template['user'] = $this->M_user->getUserById($user_id);
		
		$template['company'] = (array)$company[0];
		$res = $this->M_message->getInboxMessages($user_id,true);
                
               
		//$data['favourites'] = $res['result'];
		
		$template['getInboxCount'] = $this->M_message->getInboxCount($user_id);
		$template['getOutboxCount'] = $this->M_message->getOutboxCount($user_id);
		$template['getTrashCount'] = $this->M_message->getTrashCount($user_id);
		$template['getStaredCount'] = $this->M_message->getStaredCount($user_id);

		$template['pagination'] = $res['pagination'];
		$template['pagination']['cur'] = $page;
		$template['messageInfo'] = $res['result'];
		if(empty ($res['result'])){
			$template['content'] = $this->load->view('modules/company/message/empty', $template, true);
		}else{
			$template['content'] = $this->load->view('modules/company/message/inbox', $template, true);
		}

		$template['modules'] = array(
			'login' => 1,
			'category-menu' => 1,
			'top-menu' => 1
		);

		$template['layout'] = 'company';
		 
		$this->load->view('template', $template);
    }

    public function search()
    {
        $keyword = ($this->input->post('keyword'))?$this->input->post('keyword'):'';
       
       
             
              
              
                $user_id = $this->m_session->getUserID();
	        $template = $this->_init($user_id);
                $company = $this->M_company->getCompanyByUser($user_id);
		$template['user'] = $this->M_user->getUserById($user_id);
		$template['company'] = (array)$company[0];
                
                $res = $this->M_message->getSearchMessages($user_id,$keyword,true);
                
               
               //$data['favourites'] = $res['result'];
                
                $template['user_id'] = $user_id;
              $template['getInboxCount'] = $this->M_message->getInboxCount($user_id);
                $template['getOutboxCount'] = $this->M_message->getOutboxCount($user_id);
                $template['getTrashCount'] = $this->M_message->getTrashCount($user_id);
                $template['getStaredCount'] = $this->M_message->getStaredCount($user_id);
                
              
              
                $template['messageInfo'] = $res['result'];
                  if(empty ($res['result']))
                  {
                 $template['content'] = $this->load->view('modules/company/message/empty', $template, true);
                  }else
                  {
              $template['content'] = $this->load->view('modules/company/message/search', $template, true);
                  }
		

        $template['modules'] = array(
                'login' => 1,
                'category-menu' => 1,
                'top-menu' => 1
        );
        
        
        
        $template['layout'] = 'company';
        $this->load->view('template', $template);
    }
    public function outbox()
    {
           $page = isset($_REQUEST['page'])?$_REQUEST['page']:1;

              $this->M_message->fav_page = $page;
              
              
                $user_id = $this->m_session->getUserID();
	        $template = $this->_init($user_id);
                $company = $this->M_company->getCompanyByUser($user_id);
		$template['user'] = $this->M_user->getUserById($user_id);
		$template['company'] = (array)$company[0];
                  $res = $this->M_message->getOutMessages($user_id,true);
                
                
              $template['getInboxCount'] = $this->M_message->getInboxCount($user_id);
                $template['getOutboxCount'] = $this->M_message->getOutboxCount($user_id);
                $template['getTrashCount'] = $this->M_message->getTrashCount($user_id);
                $template['getStaredCount'] = $this->M_message->getStaredCount($user_id);
                  
                
                $template['pagination'] = $res['pagination'];
               $template['pagination']['cur'] = $page;
                $template['messageInfo'] = $res['result'];
                  if(empty ($res['result']))
                  {
                 $template['content'] = $this->load->view('modules/company/message/empty', $template, true);
                  }else
                  {
                $template['content'] = $this->load->view('modules/company/message/outbox', $template, true);
                  }
		

        $template['modules'] = array(
                'login' => 1,
                'category-menu' => 1,
                'top-menu' => 1
        );
        
        
        
        $template['layout'] = 'company';
        $this->load->view('template', $template);
    }
    public function starred(){
              
       $page = isset($_REQUEST['page'])?$_REQUEST['page']:1;

              $this->M_message->fav_page = $page;
              
              
                $user_id = $this->m_session->getUserID();
	        $template = $this->_init($user_id);
                $company = $this->M_company->getCompanyByUser($user_id);
		$template['user'] = $this->M_user->getUserById($user_id);
		$template['company'] = (array)$company[0];
                  $res = $this->M_message->getStaredMessages($user_id,true);
       
                $template['user_id'] = $user_id;
                  $template['getInboxCount'] = $this->M_message->getInboxCount($user_id);
                $template['getOutboxCount'] = $this->M_message->getOutboxCount($user_id);
                $template['getTrashCount'] = $this->M_message->getTrashCount($user_id);
                $template['getStaredCount'] = $this->M_message->getStaredCount($user_id);
               $template['pagination'] = $res['pagination'];
               $template['pagination']['cur'] = $page;
                $template['messageInfo'] = $res['result'];
                   if(empty ($res['result']))
                  {
                 $template['content'] = $this->load->view('modules/company/message/empty', $template, true);
                  }else
                  {
               $template['content'] = $this->load->view('modules/company/message/starred', $template, true);
                  }
		

        $template['modules'] = array(
                'login' => 1,
                'category-menu' => 1,
                'top-menu' => 1
        );
        
        
        
        $template['layout'] = 'company';
        $this->load->view('template', $template);
    }
    public function info($id)
    {
        $user_id = $this->m_session->getUserID();
	$template = $this->_init($user_id);
        $company = $this->M_company->getCompanyByUser($user_id);
	$template['user'] = $this->M_user->getUserById($user_id);
	$template['company'] = (array)$company[0];
        
          $template['getInboxCount'] = $this->M_message->getInboxCount($user_id);
                $template['getOutboxCount'] = $this->M_message->getOutboxCount($user_id);
                $template['getTrashCount'] = $this->M_message->getTrashCount($user_id);
                $template['getStaredCount'] = $this->M_message->getStaredCount($user_id);
                  
        $messagInfo = $this->M_message->getMessageInfoById($id);
        $update = $this->M_message->UpdateActive($id);
        $attachedIngo = $this->M_message->getAttachedFileById($id);
        $fromCompany = $this->M_message->getFomCompanyNameById($id);
        $template['hidden_id'] = $id;
        $template['fromCompany'] = $fromCompany;
        $template['messagInfo'] = $messagInfo;
        $template['attachedIngo'] = $attachedIngo;
	 $template['content'] = $this->load->view('modules/company/message/info', $template, true);
         $template['modules'] = array(
                'login' => 1,
                'category-menu' => 1,
                'top-menu' => 1
          );          
        
        $template['layout'] = 'company';
        $this->load->view('template', $template);
    }
    
    public function outinfo($id)
    {
        $user_id = $this->m_session->getUserID();
	$template = $this->_init($user_id);
        $company = $this->M_company->getCompanyByUser($user_id);
	$template['user'] = $this->M_user->getUserById($user_id);
	$template['company'] = (array)$company[0];
        
          $template['getInboxCount'] = $this->M_message->getInboxCount($user_id);
                $template['getOutboxCount'] = $this->M_message->getOutboxCount($user_id);
                $template['getTrashCount'] = $this->M_message->getTrashCount($user_id);
                $template['getStaredCount'] = $this->M_message->getStaredCount($user_id);
                  
        $messagInfo = $this->M_message->getMessageInfoById($id);
        $attachedIngo = $this->M_message->getAttachedFileById($id);
        $toCompany = $this->M_message->getToCompanyNameById($id);
        $template['hidden_id'] = $id;
        $template['toCompany'] = $toCompany;
        $template['messagInfo'] = $messagInfo;
        $template['attachedIngo'] = $attachedIngo;
	 $template['content'] = $this->load->view('modules/company/message/outinfo', $template, true);
         $template['modules'] = array(
                'login' => 1,
                'category-menu' => 1,
                'top-menu' => 1
          );          
        
        $template['layout'] = 'company';
        $this->load->view('template', $template);
    }
    
    public function delete()
    {
        $user_id = $this->m_session->getUserID();
         if(isset ($_REQUEST['isdelete']) && $_REQUEST['isdelete'] == 'star'){
        $ids = $_REQUEST['ids'];
         $checked = 0;
         $this->db->where_in('message_id',$ids); 
         $this->db->where('user_id',$user_id); 
         $this->db->set('star',$checked);
         $this->db->update('message_starred');
         }else{
             
         if(isset ($_REQUEST['isdelete']) && $_REQUEST['isdelete'] == 0){
      if(isset ($_REQUEST['ids']) && !empty ($_REQUEST['ids'])){
         $this->db->where_in('message_id',$_REQUEST['ids']); 
         $this->db->where('user_id',$user_id); 
         $this->db->set('trash',1);
         $this->db->update('message_trash');
      }
        }else{
         if(isset ($_REQUEST['ids']) && !empty ($_REQUEST['ids'])){
      
         $this->db->where_in('message_id',$_REQUEST['ids']);
         $this->db->where('user_id',$user_id); 
         $this->db->delete('message_starred');
             
         
         
         foreach ($_REQUEST['ids'] as $id){
                   $getMessageTrahInfo =  $this->db->select('*')
               ->from('message_trash')
               ->where('message_trash.message_id',$id)
              ->get();
      
              if($getMessageTrahInfo->num_rows() == 1){
         $this->M_message->DeleteAttachedFileByIds($id);       
                
         $this->db->where_in('id',$this->M_message->getMessageIdByIds($id)); 
         $this->db->delete('message_from_to');
         
         $this->db->where_in('message_id',$this->M_message->getMessageIdByIds($id)); 
         $this->db->delete('message_file');
         
            $this->db->where_in('id',$id); 
         $this->db->delete('message');
              }
         }
         $this->db->where_in('message_id',$_REQUEST['ids']); 
         $this->db->where('user_id',$user_id); 
         $this->db->delete('message_trash');

         
      }  
        }
         }
    }
    public function favorite()
    {
        $user_id = $this->m_session->getUserID();
        //var_dump($user_id);exit;
        $id = $_REQUEST['id'];
        $checked = $_REQUEST['checked'];
        
         $this->db->where('message_id',$id); 
         $this->db->where('user_id',$user_id); 
         $this->db->set('star',$checked);
         $this->db->update('message_starred');
    }
   
      public function trash()
    {
        $page = isset($_REQUEST['page'])?$_REQUEST['page']:1;

              $this->M_message->fav_page = $page;
              
              
                $user_id = $this->m_session->getUserID();
	        $template = $this->_init($user_id);
                $company = $this->M_company->getCompanyByUser($user_id);
		$template['user'] = $this->M_user->getUserById($user_id);
		$template['company'] = (array)$company[0];
                  $res = $this->M_message->getTrashMessages($user_id,true);
                 
               $template['user_id'] = $user_id;
               $template['getInboxCount'] = $this->M_message->getInboxCount($user_id);
                $template['getOutboxCount'] = $this->M_message->getOutboxCount($user_id);
                $template['getTrashCount'] = $this->M_message->getTrashCount($user_id);
                $template['getStaredCount'] = $this->M_message->getStaredCount($user_id);
                   $template['pagination'] = $res['pagination'];
               $template['pagination']['cur'] = $page;
                $template['messageInfo'] = $res['result'];
               
                     if(empty ($res['result']))
                  {
             $template['content'] = $this->load->view('modules/company/message/empty', $template, true);
                  }else
                  {
             $template['content'] = $this->load->view('modules/company/message/trash', $template, true);
                  }
                
		

        $template['modules'] = array(
                'login' => 1,
                'category-menu' => 1,
                'top-menu' => 1
        );
        
        
        
        $template['layout'] = 'company';
        $this->load->view('template', $template);
    }
        
}