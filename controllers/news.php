<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends CI_Controller {
	function __construct(){
		parent::__construct();
        $this->load->helper(array('form','url','html'));
		$this->load->model(array('m_news','m_company','m_user','m_session'));
	}
	
	function index(){
        $action = $this->uri->segment(3);
        $staff_id = $this->uri->segment(4);
		
		if($this->input->post('news')){
			$user_id = $this->m_session->getUserID();
			$company =& $this->_checkCompany($user_id);
			$news = $this->input->post('news');
			foreach($news as $news_item){
				$this->m_news->delete($company->id,$news_item);
			}
		}	
		$this->get();		
	}
	
	function _checkCompany($id=0,$src='user'){
		
		switch($src){
			case 'company':
				$company =$this->m_company->getCompanyById($id);
				if($company) $company =  array($company);
			break;
			case 'user':
			default:
				$company = $this->m_company->getCompanyByUser($id);
			break;
		}

		if(!count($company) || !is_array($company)){
			$template['content'] = $this->load->view('modules/company/error_no_company','', True);
			$template['modules'] = array(
				'login' => 1,
				'top-menu' => 1
			);
			$template['layout'] = 'company';
			$this->load->view('template', $template);
			return false;
		}

		return (object)$company[0];
	}
	
	function getList($cid = 0){
		$cid = $cid == 0 ? $this->uri->segment(3) : $cid;
		$data = array('status'=>false);
		$data['result'] = $this->m_news->get($cid);
		if(count($data['result']) && is_array($data['result'])){
			$data['status'] = true;
		}
		$this->load->view('json',array('response'=>$data));
	}
	
	function get(){
		$user_id = $this->m_session->getUserID();
		if($user_id){
			$user = $this->m_user->getUserById($user_id);
			$company =& $this->_checkCompany($user_id);
			$data = array();
			$data['company'] = $company;
			
			$page = $this->input->get_post('page')?$this->input->get_post('page'):1;
			$this->m_news->news_page = $page;
			
			$res = $this->m_news->get($company->id, 0, false, true);

			$data['pagination'] = $res['pagination'];
			$data['pagination']['cur'] = $page;
			$data['news'] = $res['result'];
			
			$template['content'] = $this->load->view('modules/company/news/list',$data, True);

			$template['modules'] = array(
				'login' => 1,
				'top-menu' => 1
			);
			$template['layout'] = 'company';
			$this->load->view('template', $template);
		} else {
			redirect('login');
		}
	}
	
	function add(){
		$user_id = $this->m_session->getUserID();
		$user = $this->m_user->getUserById($user_id);

		$company =& $this->_checkCompany($user_id);

		$data = array();

		$data['news'] = array(
			'company_id' => $company->id
		);
		$template['title'] = 'News';
		$template['content'] = $this->load->view('modules/company/news/feed_fields',$data,true);
		$this->load->view('plain-template',$template);
		
	}
        
	function edit($feed_id = 0){
		$user_id = $this->m_session->getUserID();
		$user = $this->m_user->getUserById($user_id);

		$company =& $this->_checkCompany($user_id);
		$data = array();
		if(!intval($feed_id)){
			echo "Please Select Feed";
		}else{
			$feed = $this->m_news->get($company->id, $feed_id);
			$data['feed'] = (array)$feed[0];
			$data['news'] = array(
					'company_id' => $company->id
			);
			$this->load->view('modules/company/news/feed_fields',$data);
		}
	}
        
	function view($feed_id = 0){
		$user_id = $this->m_session->getUserID();
		$user = $this->m_user->getUserById($user_id);

		$company =& $this->_checkCompany($user_id);
		$data = array();
		if(!intval($feed_id)){
			echo "Please Select Feed";
		}else{
			$feed = $this->m_news->get($company->id, $feed_id);
			$data['feed'] = (array)$feed[0];
			$data['news'] = array(
					'company_id' => $company->id
			);
			$template['title'] = 'News';
			$template['content'] = $this->load->view('modules/company/news/view',$data,true);
			$this->load->view('plain-template',$template);
		}
	}
        
	function save(){
		$user_id = $this->m_session->getUserID();
		$user = $this->m_user->getUserById($user_id);

		$company =& $this->_checkCompany($user_id);

		$params = $this->input->post('params');
		
		$data['status'] = $this->m_news->save($params);
		if($data['status']){
                        if(isset($params['id']) && is_numeric($params['id']))
                            $data['result'] = $this->m_news->get($company->id,$params['id']);
                        else
                            $data['result'] = $this->m_news->get($company->id,$data['status']);
			$data['result'][0]->cdate = M_misc::_formatDate('d M Y H:i',$data['result'][0]->cdate);
			$data['result'][0]->delete_link = base_url('news/delete/'.$data['result'][0]->id);
			if($data['status']!==true){
				$this->load->model('m_misc');
				$this->m_misc->send_email(array(
					'email' => 'helman@heldes.com',
					'subject' => 'New news entry',
					'msg' => "New news Entry<br /><br />Author:{$company->name}<br />title:\"{$data['result'][0]->title}\"<br /><br />content:<br />\"{$data['result'][0]->content}\""
				));
			}
//			redirect('news');
			$this->load->view('redirect',array('task'=>'shadowbox','url'=>'news?uid='.time()));
		}
		//$this->load->view('json',array('response'=>$data));
	}

	function approve(){
		$user_id = $this->m_session->getUserID();
		$user = $this->m_user->getUserById($user_id);

                $nid = $this->uri->segment(3);

		$company =& $this->_checkCompany($user_id);

		$params['company_id'] = $company->id;
		$params['id'] = $nid;
		$params['is_approve'] = 1;
		
		$data['status'] = $this->m_news->approve($params);
                redirect('news');
	}
}
?>