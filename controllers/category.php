<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Controller {
    function __construct(){
		parent::__construct();
		$this->load->helper(array('url','form','date'));
		$this->load->model(array('m_addto','M_company','m_session','m_category','m_search','m_country','M_optionBusinessType', 'm_user','M_options','M_encrypt'));
		$this->load->library('session');
	}
    
    
    public function index(){
		//Best Producr
		$bestProduct = array();
		/*
		$query_product = $this->db->select('products.product_id,products.liked,product_order_attributes.price_1,product_images.image_name')
		->from('products')
		->join('product_order_attributes', 'product_order_attributes.product_id = products.product_id')
		->join('product_images', 'product_images.product_id = products.product_id', 'RIGHT')
		->group_by('product_id')
		->limit(5)
		->get();
		for ($k = 0; $k < 5; $k++) {
			$bestProduct[$k]['product_id'] = $query_product->row($k)->product_id;
			$bestProduct[$k]['liked'] = $query_product->row($k)->liked;
			$bestProduct[$k]['price_1'] = $query_product->row($k)->price_1;
			$bestProduct[$k]['image_name'] = $query_product->row($k)->image_name;
		}
		*/
		$this->load->model('M_offer','',true);
		$latest_offers = $this->M_offer->getActiveOffers();
		if(count($latest_offers) > 0){
			foreach ($latest_offers as $k => $offer){
				$bestProduct[$k]['product_id'] = $offer->product_id;
				$bestProduct[$k]['liked'] = $offer->liked;
				$bestProduct[$k]['price'] = $offer->price;
                $bestProduct[$k]['unit'] = $offer->unit;
				$bestProduct[$k]['image_name'] = $offer->image_name;
			}
		}            
		//End Best Product            
		
		$template['modules'] = array(
				'login' => 1,
				'top-menu' => 1
		);
		//$template['cat_id'] = $id;
		$template['layout'] = 'one-column-page';
		$template['categories'] = $this->m_category->getCategories();
		$template['countries'] = $this->m_country->getAllCountryName();
		$template['business_type_options'] = $this->M_company->getAllBusinessType();
		$template['content'] = $this->load->view('pages/category',array('categories'=> $this->m_category->getSubCategory(0), 'bestProducts' => $bestProduct),true);
		$this->load->view('template', $template);     
    }
    
    public function show($id){
        if(is_numeric($id)) {
			

			$user_id = $this->session->userdata('user_id');
			$option['search_type'] = ($this->input->get_post('search_type'))?$this->input->get_post('search_type'):'products';
			$option['businessType'] = ($this->input->get_post('business_type'))?$this->input->get_post('business_type'):'';
			$membership = $this->input->get_post('membership');
			$membership = $this->input->get_post('membership');
			if(is_array($membership)){
				$option['membership'] = implode(',',$membership);
			}else{
				$option['membership'] = $membership?$membership:"";
			}
			$option['keyword'] = ($this->input->get_post('keyword'))?$this->input->get_post('keyword'):'';
			$option['region'] = ($this->input->get_post('region'))?$this->input->get_post('region'):'';
			$option['cat_id'] = ($this->input->get_post('cat_id'))?$this->input->get_post('cat_id'):$id;
			$option['opt'] = 'AND';
			$option['time_period'] = ($this->input->get_post('time_period'))?$this->input->get_post('time_period'):0;
			$option['is_assessed'] = ($this->input->get_post('is_assessed'))?$this->input->get_post('is_assessed'):'';
			
			$page = $this->input->get_post('page')?$this->input->get_post('page'):1;

			$this->m_search->search_page = $page;
			$this->m_search->search_num = 20;
			$res = $this->m_search->getProduct($option);

			$data['additional'] = $this->_additionalParams($option);
			$data['products'] = $res['result'];
			$data['source'] = 'product';
			$data['option'] =& $option;
			$data['pagination'] = $res['pagination'];
			$data['pagination']['cur'] = $page;
			if(!empty($data['products'])) $data['inWatchList'] = $this->m_addto->inWatchList($data['products'], $user_id);
                        $data['certification_options'] = $this->M_company->getAllCertification();
                        $data['breadcrumbs'] = $this->m_category->getBreadcrumbs($id);

            $template['modules'] = array(
                    'login' => 1,
                    'top-menu' => 1,
            );
			$template['cat_id'] = $id;
			$template['modules'] = array('top-menu'=>1,'login'=>1, 'category-menu'=>1);
			$template['categories'] = $this->m_category->getCategories();
			$template['countries'] = $this->m_country->getAllCountryName();
			$template['businessType'] = $this->M_optionBusinessType->getBusinessTypes();
			$template['business_type_options'] = $this->M_company->getAllBusinessType();
			$template['layout'] = 'category';
			$template['content'] = $this->load->view('modules/search/products',$data,true);

            $this->load->view('template', $template);
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
	
}
