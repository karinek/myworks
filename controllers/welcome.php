<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends CI_Controller {
	function __construct(){
		parent::__construct();

		$this->load->helper('form');
        $this->load->library('session');
		$this->load->model('M_encrypt');
		$this->load->model('M_like');
		$this->load->model('M_session','',True);
		$this->load->model('M_product');
        $this->load->model('M_country');
	}
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -  
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function index() {

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
        /*
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
        $this->load->model(array('M_currency','m_session', 'm_category', 'm_country', 'M_company', 'm_addto','M_pricewatch','m_product','M_slide'));

        $template['modules'] = array(
            'login' => 1,
            'category-menu' => 1,
            'top-menu' => 1
        );
        
        
        $new_products_list = $this->m_product->getNewProductList();
        
        $data['tradeshows'] = $tradeshows;
        $data['topsuppliers'] = $topsuppliers;
        $data['hotregions'] = $hotregions;
        $data['bestProduct'] = $bestProduct;
        $data['newproducts'] = $new_products_list;
        $data['featuredcategories'] = $this->m_category->getFeaturedCategories();
        $data['currencies_base'] = M_misc::changeArrayKey($this->M_currency->get(array('symbol'=>array('USD','EUR','CAD','GBP'))),'symbol');
		$data['currencywatchs'] = $this->M_currency->get(array('symbol'=>array('USD','EUR','CAD','GBP')));
		$data['pricewatchs'] = $this->M_pricewatch->get();
		$data['slides'] = $this->M_slide->getSlides();
        $template['categories'] = $this->m_category->getCategories();
        $template['countries'] = $this->m_country->getAllCountryName();
        $template['regions'] = $this->m_country->getAllRegionName();
        $template['business_type_options'] = $this->M_company->getAllBusinessType();
        $template['content'] = $this->load->view('pages/home', $data, true);
        $this->load->view('template', $template);
    }

    public function like($product_id) {
   
	$product_id = $this->M_encrypt->decode($product_id);   
   
    $res = $this->M_product->getInfo($product_id);
    $like = $res['liked'];
    
    $user_id = $this->session->userdata('user_id');
    if (!$user_id){
        echo $like;
    } else{
        if($this->M_like->isExist($user_id,array('section'=>'product', 'value'=>$product_id))){
            echo $like;
        } else {
            $data = array('liked'    =>    $like+1);
            $this->M_product->update_product($product_id,$data);
            echo $res['liked'] + 1;
        }
    }
    
    }
    
    public function getCountries($region) {
        
        $result = '<select name="country" id="country_id2">';
        if (!empty($region)) {
            $countries = $this->M_country->getAllCountryByRegion($region);
            $result .= '<option value="0">All Country</option>';
            foreach ($countries as $country) {
                $result .= '<option value="'.$country['country_name'].'">'.$country['country_name'].'</option>';
            }
        } else {
            $result .= '<option value="0">All Country</option>';
        }
        $result .= '</select>';
        echo $result;
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */