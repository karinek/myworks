<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Faq extends CI_Controller {
    
        public $type_headers = array('buying'=>'How to Buy?', 'selling'=>'How to Sell?', 'security'=>'Security Information', 'accounts'=>'Account Information');
    
	function __construct(){
            parent::__construct();
            $this->load->library(array('session','pagination'));
            $this->load->helper(array('url', 'form'));
            $this->load->model(array('m_forum','m_misc','m_session', 'm_faq'));
	}
	
	public function index($type = ''){
            $page = ($this->input->get('page'))?$this->input->get_post('page'):1;
            $keyword = $this->input->get('q');
            $this->m_faq->faq_page = $page;
            $faqs = $this->m_faq->getList($type, $keyword);
            $data['keyword'] = $keyword;
            $data['additional'] = $this->_additionalParams(array('q'=>$keyword));
            $data['type'] = $type;
            $data['default'] = array('page'=>$page);
            $data['pagination'] = $faqs['pagination'];
            $data['pagination']['cur'] = $page;
            $data['faqs'] = $faqs['result'];
            $template['content'] = $this->load->view('modules/faq/list',$data,true);
            $template['modules'] = array(
                'login' => 1,
                'top-menu' => 1
            );
            $template['layout'] = 'helpdesk';
            $this->load->view('template',$template);
	}
        
        public function view($id = 0){
            if(!$id)
                redirect('faq');
            $data['faq'] = $this->m_faq->get($id);
            $data['type'] = '';
            $template['content'] = $this->load->view('modules/faq/view', $data, true);
            $template['modules'] = array(
                'login' => 1,
                'top-menu' => 1
            );
            $template['layout'] = 'helpdesk';
            $this->load->view('template',$template);
            
        }
        
        public function _additionalParams($params){
            $result = array();
            foreach($params as $key=>$value){
                if($value != ''){
                    $result[] = $key . '='. $value;
                }
            }
            $result = implode('&', $result);
            return $result;
        }
}
?>