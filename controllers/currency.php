<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Currency extends CI_Controller {

     public function __construct() {
        parent::__construct();
        $this->load->helper(array('form','url','html'));
        $this->load->library('session');
        $this->load->model('m_session','',True);
        $this->load->model('M_category','',True);
        $this->load->model('M_user','',True);
        $this->load->model('M_currency','',True);
        
     }
     
     function out($var) {
         echo '<pre>';
         print_r($var);
         echo '</pre>';
     }
	public function index(){
        
        $data = array();
        $data['currencies_base'] = M_misc::changeArrayKey($this->M_currency->get(array('symbol'=>array('USD','EUR','CAD','GBP'))),'symbol');
        $data['currencies'] = $this->M_currency->load();
//        $data['currencies'] = array_slice($this->M_currency->load(), 0, 20);
//		$this->out($data);
        $template['title'] = 'Currency Watch';
        $template['layout'] = 'company';
        $template['content'] = $this->load->view('modules/currency/default',$data,true);
        $template['modules'] = array(
            'login' => 1,
            'top-menu' => 1
        );
        $this->load->view('template',$template);
		//$this->template->build('modules/currency/default');
	}

	function update(){
		// need to change it to the correct live server
		$this->load->library('curl');
		$this->load->model('m_currency');
		$response = $this->curl->simple_get('http://www.xe.com/dfs/sample-usd.xml');
		$xml = new SimpleXMLElement($response);

		$this->m_currency->update($xml);
	}

	function get(){
		$this->load->helper('url');
		$this->load->model('m_currency');

		$res = $this->m_currency->get(array('symbol' => explode(',',$this->input->get('cur'))));
		$data = array('status' => false);
		if(count($res)){
			$data['status'] = true;
			$data['result'] = $res;
		}

		//if($this->input->get_post('format')){
			$params['response'] = $data;
			$this->load->view('json',$params);
		//}
	}
}
