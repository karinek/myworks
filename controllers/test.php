<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Test extends CI_Controller {

    /**
     * Index Page for this controller.
     * 
     */
    public function index($comp_id=0,$cat_id=0,$page=0) {
        session_start();
        echo "HLLOE WORLD";
	exit;
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
        for ($k = 0; $k < 5; $k++) {
            $bestProduct[$k]['product_id'] = $query_product->row($k)->product_id;
            $bestProduct[$k]['liked'] = $query_product->row($k)->liked;
            $bestProduct[$k]['price_1'] = $query_product->row($k)->price_1;
            $bestProduct[$k]['image_name'] = $query_product->row($k)->image_name;
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
        for ($s = 0; $s < 5; $s++) {
            $topsuppliers[$s]['id'] = $query_suppliers->row($s)->id;
            $topsuppliers[$s]['image'] = $query_suppliers->row($s)->image;
        }
        //var_dump($topsuppliers);exit;
        //end Suppliers
        $this->load->model(array('m_session', 'm_category', 'm_company', 'm_country', 'M_optionBusinessType'));
		
		if(!isset($comp_id)||$comp_id<=0){
			$companies=$this->m_company->getAll();			
			$comp_id=$companies[0]['id'];
		}

        $template['modules'] = array(
            'login' => 1,
            'category-menu' => 1,
            'top-menu' => 1
        );
		$data['layout'] = 'company';
		
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
		$data['comp_id'] = $comp_id;
		$data['allprods'] = $allprods;
        $data['tradeshows'] = $tradeshows;
        $data['topsuppliers'] = $topsuppliers;
        $data['hotregions'] = $hotregions;
        $data['bestProduct'] = $bestProduct;		
		$data['catProducts'] = $this->m_company->getProductByCompanyAndCategoryWithPaging($comp_id,$cat_id,$cnt_per_page*$page,$cnt_per_page);
		$data['page']=$page+1;
		$data['pages']=round($allcatprods/$cnt_per_page);		
        //$template['categories'] = $this->m_category->getCategories();
        //$template['countries'] = $this->m_country->getAllCountryName();
        $template['businessType'] = $this->M_optionBusinessType->getBusinessTypes();
        $template['content'] = $this->load->view('pages/compprods', $data, true);
        $this->load->view('template', $template);
    }
	 public function search($comp_id=0,$cat_id=0,$page=0,$search='') {
	    session_start();
        $this->load->helper(array('form'));
        $this->load->library('session');
		$cnt_per_page=10;

		
		
        
        $this->load->model(array('m_session', 'm_category', 'm_company', 'm_country', 'M_optionBusinessType'));
		
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
		//$data['allprods'] = $allprods;
		$data['search'] = $search;
		$data['allprods'] = $allprods;
		$allcatprods = $this->m_company->getProductByCompanyAndCategoryCount($comp_id,$cat_id,$search);
		$data['catProducts'] = $this->m_company->getProductByCompanyAndCategoryWithPaging($comp_id,$cat_id,$cnt_per_page*$page,$cnt_per_page,$search);
		$data['page']=$page+1;
		$data['pages']=round($allcatprods/$cnt_per_page);
        $this->load->view('pages/compprodssearch', $data);
	 }


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */