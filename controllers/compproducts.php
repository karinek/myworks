<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class CompProducts extends CI_Controller {

	function __construct(){
        parent::__construct();
		$this->load->model('M_encrypt');
    }

    /**
     * Index Page for this controller.
     * 
     */
	
	
	
    public function index($comp_id=0,$cat_id=0,$page=0) {
        $comp_id = $this->M_encrypt->decode($comp_id);
		if(!is_numeric($comp_id)){
			show_404();
		}
		
		$this->load->helper(array('form'));
        $this->load->library('session');
		$cnt_per_page=10;

		
		
        //Trade show
        $this->db->order_by('trade_id', 'DESC'); // Order by
        $query = $this->db->get('tradeshows', 3);
        $tradeshows = array();
        for ($i = 0; $i < 3; $i++) {
            $tradeshows[$i]['id'] = $query->row($i)->trade_id;
            $tradeshows[$i]['title'] = $query->row($i)->title;
            $tradeshows[$i]['from'] = $query->row($i)->date_from;
            $tradeshows[$i]['to'] = $query->row($i)->date_to;
            $tradeshows[$i]['logourl'] = $query->row($i)->logo_url;
        }
        //end trade show
        //hot Region     
        
        $this->db->order_by('RAND()');
       
        $query1 = $this->db->get('hotregions', 9);
        $hotregions = array();
        for ($j = 0; $j < 9; $j++) {
            $hotregions[$j]['id'] = $query1->row($j)->id;
            $hotregions[$j]['country'] = $query1->row($j)->country;
            $hotregions[$j]['ranking'] = $query1->row($j)->ranking;
            $hotregions[$j]['icon_url'] = $query1->row($j)->icon_url;
        }


        //end hot region
        //Best Producr

            $bestProduct = array();
        $query_product = $this->db->select('products.product_id,products.liked,product_order_attributes.price_1,product_images.image_name')
                ->from('products')
                ->join('product_order_attributes', 'product_order_attributes.product_id = products.product_id')
                ->join('product_images', 'product_images.product_id = products.product_id', 'RIGHT')
                ->group_by('product_id')
                ->limit(5)
                ->get();
        $product_count = $query_product->num_rows; 
        if($product_count > 0){
        	$product_count = ($product_count > 5)?5:$product_count;
	        for ($k = 0; $k < $product_count; $k++) {
	            $bestProduct[$k]['product_id'] = $query_product->row($k)->product_id;
	            $bestProduct[$k]['liked'] = $query_product->row($k)->liked;
	            $bestProduct[$k]['price_1'] = $query_product->row($k)->price_1;
	            $bestProduct[$k]['image_name'] = $query_product->row($k)->image_name;
	        }
        }    
        // var_dump($bestProduct);exit;                     
        //End Best Product
        //Suppliers


        $topsuppliers = array();
        $query_suppliers = $this->db->select('company.id AS id,company.file AS image')
                ->from('featured_suppliers')
                ->join('users', 'featured_suppliers.supplier_id = users.id')
                ->join('user_company', 'user_company.user_id = users.id')
                ->join('company', 'company.id  = user_company.company_id')
                ->limit(5)
                ->get();
        $suppliers_count = $query_suppliers->num_rows; 
        if($suppliers_count > 0){
        	$suppliers_count = ($suppliers_count  > 5)?5:$suppliers_count;
	        for ($s = 0; $s < $suppliers_count; $s++) {
	            $topsuppliers[$s]['id'] = $query_suppliers->row($s)->id;
	            $topsuppliers[$s]['image'] = $query_suppliers->row($s)->image;
	        }
        }        
        //var_dump($topsuppliers);exit;
        //end Suppliers
        $this->load->model(array('m_session', 'm_category', 'm_company', 'm_country', 'M_addTo', 'M_options'));
        $user_id = $this->m_session->isLogin();//getUserID();
		
        if(!isset($comp_id)||$comp_id<=0){
                $companies=$this->m_company->getAll();		
                $comp_id=$companies[0]['id'];
        }

        $template['modules'] = array(
            'login' => 1,
            'category-menu' => 1,
            'top-menu' => 1
        );
		$template['layout'] = 'company';
		
		$data['comp_categories'] =$this->m_category->getCompanyCategories($comp_id);
		
		if(!isset($cat_id)||$cat_id<=0){
			if(isset($data['comp_categories'][0]['category_id']))
				$cat_id=$data['comp_categories'][0]['category_id'];
		}
		$allprods=0;
		$allcatprods=0;
		$category=null;
		foreach($data['comp_categories'] as $prodcat){
			$allprods+=$prodcat['prodcnt'];
			if($prodcat['category_id']==$cat_id){
				$allcatprods=$prodcat['prodcnt'];
				$category=$prodcat;
			}
				
		}
		
		$data['category'] = $category;
		$data['cat_id'] = $cat_id;
                $data['company'] = $this->m_company->getCompanyById($comp_id);
		$data['comp_id'] = $comp_id;
		$data['allprods'] = $allprods;
                $data['tradeshows'] = $tradeshows;
                $data['topsuppliers'] = $topsuppliers;
                $data['hotregions'] = $hotregions;
                $data['bestProduct'] = $bestProduct;		
		$data['catProducts'] = $this->m_company->getProductByCompanyAndCategoryWithPaging($comp_id,$cat_id,$cnt_per_page*$page,$cnt_per_page);
                $data['inWatchList'] = $this->M_addTo->inWatchList($data['catProducts'], $user_id);
		$data['page']=$page+1;
		$data['pages']=round($allcatprods/$cnt_per_page);		
        $template['categories'] = $this->m_category->getCategories();
        $data['countries'] = $template['countries'] = $this->m_country->getAllCountryName();
        $template['business_type_options'] = $this->m_company->getAllBusinessType();
        $data['certification_options'] = $this->m_company->getAllCertification();
        $template['content'] = $this->load->view('pages/compprods', $data, true);
        $this->load->view('template', $template);
    }
    
     public function search($comp_id=0,$cat_id=0,$page=0,$arrange_by=0,$search='') {
	    session_start();
        $this->load->helper(array('form'));
        $this->load->library('session');
		$cnt_per_page=10;
        
        $this->load->model(array('m_session', 'm_category', 'm_company', 'm_country', 'M_addTo', 'M_options'));
        $user_id = $this->m_session->isLogin();//$this->m_session->getUserID();
		
		if(!isset($comp_id)||$comp_id<=0){
			$companies=$this->m_company->getAll();
			$comp_id=$companies[0]['id'];
		}       
		
		$data['comp_categories'] =$this->m_category->getCompanyCategories($comp_id);
		
		if(!isset($cat_id)||$cat_id<=0){
		
			$cat_id=$data['comp_categories'][0]['category_id'];
		}
		$allprods=0;
		$allcatprods=0;
		foreach($data['comp_categories'] as $prodcat){
			$allprods+=$prodcat['prodcnt'];
			if($prodcat['category_id']==$cat_id){
				$allcatprods=$prodcat['prodcnt'];
				$category=$prodcat;
			}
				
		}
		$data['category'] = $category;
		$data['cat_id'] = $cat_id;
		$data['comp_id'] = $comp_id;
                $data['company'] = $this->m_company->getCompanyById($comp_id);
		//$data['allprods'] = $allprods;
		if($search=='eg... Search Mail'){
			$search='';
		}
		
		
		$data['search'] = $search;
		$data['arrange_by'] = $arrange_by;
		$data['allprods'] = $allprods;
                $data['countries'] = $template['countries'] = $this->m_country->getAllCountryName();
                $data['certification_options'] = $this->m_company->getAllCertification();
		$allcatprods = $this->m_company->getProductByCompanyAndCategoryCount($comp_id,$cat_id,$search);
		$data['catProducts'] = $this->m_company->getProductByCompanyAndCategoryWithPaging($comp_id,$cat_id,$cnt_per_page*$page,$cnt_per_page,$search,$arrange_by);
                $data['inWatchList'] = $this->M_addTo->inWatchList($data['catProducts'], $user_id);
		$data['page']=$page+1;
		$data['pages']=round($allcatprods/$cnt_per_page);
        $this->load->view('pages/compprodssearch', $data);
	 }


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */