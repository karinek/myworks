<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {
      function __construct(){
        parent::__construct();
        
		$this->load->helper(array('url','form','date'));
		$this->load->model(array('M_addTo','M_company','m_session','m_category','m_search','m_country','M_optionBusinessType', 'm_user','M_options','M_encrypt'));
    }

	
	
	public function index(){
		$user_id = $this->session->userdata('user_id');
		
		$option['search_type'] = ($this->input->get_post('search_type'))?$this->input->get_post('search_type'):'products';
		$option['keyword'] = ($this->input->get_post('keyword'))?trim($this->input->get_post('keyword')):'';
		$page = $this->input->get_post('page')?$this->input->get_post('page'):1;

		$membership = $this->input->get_post('membership');
		if(is_array($membership)){
			$option['membership'] = implode(',',$membership);
		}else{
			$option['membership'] = $membership?$membership:"";
		}
		$option['is_assessed'] = ($this->input->get_post('is_assessed'))?$this->input->get_post('is_assessed'):'';
		
		$data['additional'] = $this->_additionalParams($option);
		$data['keyword'] = $option['keyword'];
		$data['search_type'] = $option['search_type'];
		$data['search_options'] = array(
			'user' => 'User',
			'company' => 'Company',
			'product' => 'Product'
		);
		
		$template['modules'] = array('top-menu'=>1,'login'=>1, 'category-menu'=>1);
		$template['categories'] = $this->m_category->getCategories();
        $template['countries'] = $this->m_country->getAllCountryName();
        $template['regions'] = $this->m_country->getAllRegionName();
		$template['business_type_options'] = $this->M_company->getAllBusinessType();
		$template['layout'] = 'search';
                
		switch($option['search_type']){
			case "products":
				$this->m_search->search_page = $page;
				$res = $this->m_search->getProduct($option);
				$data['products'] = $res['result'];
				$data['default'] = array(
					'page'=>$page,
				);
				$data['pagination'] = $res['pagination'];
				$data['pagination']['cur'] = $page;
	
				if(!empty($data['products'])) $data['inWatchList'] = $this->M_addTo->inWatchList($data['products'], $user_id);
				$data['certification_options'] = $this->M_company->getAllCertification();
	
				$data['option'] =& $option;
	
				$template['content'] = $this->load->view('modules/search/products',$data,true);
				$this->load->view('template',$template);
				break;
			case "buyer":
				$this->m_search->search_page = $page;
				$res = $this->m_search->getBuyer($option);
				$data['buyers'] = $res['result'];
				$data['default'] = array(
					'page'=>$page,
				);
				$data['pagination'] = $res['pagination'];
				$data['pagination']['cur'] = $page;

				$data['certification_options'] = $this->M_company->getAllCertification();
	
				$template['content'] = $this->load->view('modules/search/buyer',$data,true);
				$this->load->view('template',$template);
				break;
			case "seller":
				$this->m_search->search_page = $page;
				$res = $this->m_search->getSupplier($option);
				$data['sellers'] = $res['result'];
				$data['default'] = array(
					'page'=>$page,
				);
				$data['pagination'] = $res['pagination'];
				$data['pagination']['cur'] = $page;
	
				$template['content'] = $this->load->view('modules/search/seller',$data,true);
				$this->load->view('template',$template);
				break;
		}
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
	
    public function advancesearch(){
        $user_id = $this->session->userdata('user_id');
        
        $membership = $this->input->get('membership');
		if(is_array($membership)){
			$option['membership'] = implode(',',$membership);
		}else{
			$option['membership'] = $membership?$membership:"";
		}
        $option['search_type'] = ($this->input->get_post('search_type'))?$this->input->get_post('search_type'):'products';
        $option['businessType'] = ($this->input->get_post('business_type'))?$this->input->get_post('business_type'):"";
        $option['keyword'] = ($this->input->get_post('keyword'))?trim($this->input->get_post('keyword')):'';
        $option['region'] = ($this->input->get_post('region'))?$this->input->get_post('region'):'';
        $option['country'] = ($this->input->get_post('country'))?$this->input->get_post('country'):'';
        $option['cat_id'] = ($this->input->get_post('cat_id'))?$this->input->get_post('cat_id'):0;
        $option['opt'] = ($this->input->get_post('opt'))?$this->input->get_post('opt'):'AND';
        $option['time_period'] = ($this->input->get_post('time_period'))?$this->input->get_post('time_period'):0;
		$option['is_assessed'] = ($this->input->get_post('is_assessed'))?$this->input->get_post('is_assessed'):'';
        
        $page = $this->input->get_post('page')?$this->input->get_post('page'):1;
        $data['additional'] = $this->_additionalParams($option);
        $data['keyword'] = $option['keyword'];
        $data['search_type'] = $option['search_type'];
        $data['search_options'] = array(
                'user' => 'User',
                'company' => 'Company',
                'product' => 'Product'
                );
        $template['modules'] = array('top-menu'=>1,'login'=>1, 'category-menu'=>1);
        $template['categories'] = $this->m_category->getCategories();
        $template['countries'] = $this->m_country->getAllCountryName();
        $template['regions'] = $this->m_country->getAllRegionName();
        $template['business_type_options'] = $this->M_company->getAllBusinessType();
        $template['layout'] = 'search';
		
        switch($option['search_type']){
            case "products":
                $this->m_search->search_page = $page;
                $res = $this->m_search->getProduct($option);
                $data['products'] = $res['result'];
                $data['default'] = array(
                    'page'=>$page,
                );
                $data['pagination'] = $res['pagination'];
                $data['pagination']['cur'] = $page;

                if(!empty($data['products'])) $data['inWatchList'] = $this->M_addTo->inWatchList($data['products'], $user_id);
                $data['certification_options'] = $this->M_company->getAllCertification();

                $data['option'] =& $option;

                $template['content'] = $this->load->view('modules/search/products',$data,true);
                $this->load->view('template',$template);
                break;
            case "buyer":
                $this->m_search->search_page = $page;
                $res = $this->m_search->getBuyer($option);
                $data['buyers'] = $res['result'];
                $data['default'] = array(
                    'page'=>$page,
                );
                $data['pagination'] = $res['pagination'];
                $data['pagination']['cur'] = $page;

                $data['certification_options'] = $this->M_company->getAllCertification();

                $template['content'] = $this->load->view('modules/search/buyer',$data,true);
                $this->load->view('template',$template);
                break;
            case "seller":
                $this->m_search->search_page = $page;
                $res = $this->m_search->getSupplier($option);
                $data['sellers'] = $res['result'];
                $data['default'] = array(
                    'page'=>$page,
                );
                $data['pagination'] = $res['pagination'];
                $data['pagination']['cur'] = $page;

                $template['content'] = $this->load->view('modules/search/seller',$data,true);
                $this->load->view('template',$template);
                break;
        }
    }
    
    public function autocomplete(){
    	$query_string = ($this->input->get_post('q'))?trim($this->input->get_post('q')):'';
    	 
    	$result_json = $this->m_search->getAutocompleteResults($query_string);
    	echo json_encode($result_json);
    	exit();
    }    
}
?>