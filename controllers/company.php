<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company extends CI_Controller {
	function __construct(){
		parent::__construct();

		$this->load->helper(array('form','url','html'));
		$this->load->library('session');
		$this->load->model('M_options','',True);
		$this->load->model('M_company','',True);
		$this->load->model('M_country','',True);
		$this->load->model('m_session','',True);
		$this->load->model('M_category','',True);
		$this->load->model('m_sugar');
		$this->load->model('M_optionBusinessType','',True);
		$this->load->model('M_user','',True);
        $this->load->model('m_addto');
		$this->load->model('M_encrypt');
	}
	
    public function index(){
		$this->add();
    }
    
    public function like_company($id){
        if(!isset($id)){ 
            echo $like;
            exit;
        }
        $this->load->model('M_like');
        
        $res = $this->M_company->getCompanyById($id);
        var_dump($res); exit;
        $like = $res[0]->like;
        $author_id = $res[0]->user_id;
        
        $user_id = $this->session->userdata('user_id');
        if (!$user_id){
            echo $like;
        } else{
            if($this->M_like->isExist($user_id,array('section'=>'topic', 'value'=>$id))){
                echo $like;
            } else {
                $data = array('like'    =>    $like+1);
                $this->m_forum->update('topic',array('id'=>$id),$data);
				$this->m_forum->updateStatistic('user','like',$author_id);
				$this->m_forum->doRanking();
                echo $like + 1;
            }
        }
    
    }
/*    
    public function show(){
        $this->load->helper(array('form','url','html'));
        $cid = $this->uri->segment(3);
        $this->load->model('M_company','',True);
        $this->load->model('M_country');
        $data['company_detail'] = $this->M_company->getCompanyById($cid);
        if ($data['company_detail']['status'] == 'banned'){
            $this->load->view('modules/company/banned_view');
        } else {
            $data['country_name'] = $this->M_country->getCountryNameByCode(strtoupper($data['company_detail']['country']));
            $data['products'] = $this->M_company->getProductByCompany($cid);
            $data['hidden']= array(
                    'contact_id'    =>  $data['company_detail']['contact_id'],
                    'company_id'    =>  $data['company_detail']['id']
                    );
            if($data)
                $this->load->view('modules/company/show_view',$data);
            else
               var_dump("fail to get company info");
        }
    }
*/
/*
    public function details2($cid = 0){
        if($cid){
            $this->load->library('session'); 
            $this->load->model('M_news','',True);
            $template = $this->_init();
            $company = $this->M_company->getCompanyById($cid);
            if (!$company){
               show_404(array('message'=>'This company no longer exist'));
               exit;
            }
            $template['staffList'] = $this->M_company->staffList($cid);
            $user = $this->M_user->getUserByCompany($cid);
            if (!$user){
                echo "Sorry, errors, please contact us";
                exit;
            }
            $res = $this->M_company->getNetworkCompanies($user->id, '', false, false);
            $template['networks'] = $res['networks'];
            $template['news'] = $this->M_news->get($cid, 0, true);
            $template['company_detail'] = $company;
            $template['country_name'] = $this->M_country->getCountryNameByCode(strtoupper($company['country']));
            $template['content'] = $this->load->view('modules/company/details_view',$template, True);
            
            $template['modules'] = array(
                'login' => 1,
                'top-menu' => 1
            );
            $template['layout'] = 'company';
            $this->load->view('template', $template);
        }
    }
*/    
	function map($cid = 0){
		$company = $this->M_company->getCompanyById($cid);
		if (!$company){
		   show_404(array('message'=>'This company no longer exist'));
		   exit;
		}
		$company = (object)$company;
		$data = array(
			'company' => &$company
		);
		$this->load->view('modules/company/maps', $data);
	}
	
	function getnetwork($cid = 0){
		$page = intval($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
		$start = $page>0?($page - 1) * 6:0;

		$company = $this->M_company->getCompanyById($cid);
		if (!$company){
		   show_404(array('message'=>'This company no longer exist'));
		   exit;
		}
		$company = (object)$company;
		$user = $this->M_user->getUserByCompany($cid);
		if (!$user){
			echo "Sorry, errors, please contact us";
			exit;
		}
		$this->M_company->net_page = $page;
		
		$the_networks = $this->M_company->getNetworkCompanies($user->id,'', $page);

		$data = array(
			'status'=>!empty($the_networks['networks']),
			'result'=>$the_networks['networks']
		);
		$data['pagination'] = array(
			'url'=>base_url('comapny/getnetwork/'.$cid.'/'),
			'rows'=>$the_networks['pagination']['rows'],
			'page'=>$the_networks['pagination']['page'],
			'per_page' => $this->M_company->net_num,
			'cur' => $page
		);
		
		$this->load->view('json',array('response'=>$data));
	}
	
	function details($cid = 0){
		$this->load->model('M_news','',True);
		$cid = $this->M_encrypt->decode($cid);
		if(!is_numeric($cid)){
			show_404();
		}
		$company = $this->M_company->getCompanyById($cid);
		if (!$company){
		   show_404();
		}
		$company = (object)$company;
		$user = $this->M_user->getUserByCompany($cid);
		if (!$user){
			echo "Sorry, errors, please contact us";
			exit;
		}
		
		$company->country = $this->M_country->getCountryNameByCode(strtoupper($company->country));

		$business_type = $this->db->get('option_business_type');
		$certification = $this->db->get('option_certification');
		$company_service = $this->db->get('option_company_service');
		$payment = $this->db->get('option_payment');
		$region = $this->db->get('option_region');
		$unit = $this->db->get('option_unit');
		
		$company_license = explode('|',$company->certification);
		$company->company_license = array();
		foreach($company_license as $key => $value){
			$this->db->where('id',$value);
			$res = $this->db->get('option_certification',1);
			$company->company_license[$key] = $res->result();
			if(count($company->company_license[$key]) && is_array($company->company_license[$key])){
				$company->company_license[$key] = $company->company_license[$key][0];//->name;
			}else unset($company->company_license[$key]);// = '';
		}
	
		$industry = explode('|',$company->service);
		$company->industry = array();
		foreach($industry as $key => $value){
			$this->db->where('id',$value);
			$res = $this->db->get('option_company_service',1);
			$company->industry[$key] = $res->result();
			if(count($company->industry[$key]) && is_array($company->industry[$key])){
				$company->industry[$key] = $company->industry[$key][0]->name;
			}else $company->industry[$key] = '';
		}
	
		$company->status = 'Operating';
		$company->company_size = M_options::getFactorySizeDetails($company->factory_size);
		if(is_array($company->company_size) && count($company->company_size))$company->company_size = $company->company_size[1];
		$company->acn_no = '';
		$company->purchase_volume = M_options::getAnnualPurchaseVolume($company->factory_purchase);
		if(is_array($company->purchase_volume) && count($company->purchase_volume))$company->purchase_volume = $company->purchase_volume[1];
		
		$region = explode('|',$company->region);
		$company->region = array();
		foreach($region as $key => $value){
			$this->db->where('id',$value);
			$res = $this->db->get('option_region',1);
			$company->region[$key] = $res->result();
			if(count($company->region[$key]) && is_array($company->region[$key])){
				$company->region[$key] = $company->region[$key][0]->name;
			}else $company->region[$key] = '';
		}
		
		$the_networks = $this->M_company->getNetworkCompanies($user->id);
		$the_networks = $the_networks['networks'];
		
		$contact = $this->M_company->getDefaultContact($company->id);
		if(!count($contact) || !is_array($contact)){
			$contact =& $user;
		}else{
			$contact = $contact[0];
		}

		$my_favourites = array();
		$my_contacts = array();
		$my_networks = array();
		$my_userID = $this->m_session->isLogin();
		if($my_userID){
			$my_favourites = $this->M_user->getFavouriteCompanyIds($my_userID);
			$my_contacts = $this->M_user->getContactCompanyIds($my_userID);
			$my_networks = $this->M_user->getNetworkCompanyIds($my_userID);
		}
	
		$data = array(
			'my_favourites' => &$my_favourites,
			'my_contacts' => &$my_contacts,
			'my_networks' => &$my_networks,
			'the_user' => &$user,
			'the_staff' => $this->M_company->staffList($cid),
			'the_news' => $this->M_news->get($cid, 0, true),
			'the_netwroks' => &$the_networks,
			'the_company' => &$company,
			'the_contact' => &$contact
		);

        $data['country_options'] = $this->M_country->getAllCountryOptions();
        $data['business_type_options'] = $this->M_company->getAllBusinessType();
        $data['certification_options'] = $this->M_company->getAllCertification();
        $data['region_options'] = $this->M_company->getAllRegion();
        $data['service_options'] = $this->M_company->getAllService();
        
        $data['countries'] = $this->M_country->getAllCountryName();
        $data['categories'] = $this->M_category->getCategories();
	
		$template['content'] = $this->load->view('modules/company/details_view2',$data, True);
		
		$template['modules'] = array(
			'login' => 1,
			'top-menu' => 1
		);
		$template['layout'] = 'company';
		$this->load->view('template', $template);
	}

	// not used ,replace by     /compproducts/index/$c_id
/*
    public function products($cid = 0, $cat_id = 0){
        if($this->input->is_ajax_request() && $cid){
            $this->load->model('M_company','',True);
                $template = $this->_init();
                if($cat_id == 0){
                    $products = $this->M_company->getProductByCompany($cid);
                }
                else{
                    $products = $this->M_company->getProductByCompanyAndCategory($cid, $cat_id);
                }
                $category = $this->M_category->getCategory($cat_id) ;
                echo '<image class="ajaxImage" src="'.base_url().'images/loader.gif">
                    <p class="menu_head">'.(($category)?$category->category_name:'All Categories').'</p>';
                if(!empty($products)){
                    foreach($products as $product){
                                        if(isset($product['image_name'])){}
                                        else
                                            $product['image_name'] = '';
                        $productName = $product['name'];
                        $image = $product['image_name'];
                        $short_description = $product['short_description'];
                        echo "<div class='company_product_desc'>
                                <div class='left'>
                                    <div class='img_block'>
                                        <a href='".base_url()."images/product_images/".$image."' rel='lightbox' title=''><img src='".base_url()."images/product_images/".$image."' width='125' height='85' alt='' /></a>
                                        <a href='".base_url()."images/product_images/".$image."' rel='lightbox' title=''><img src='".base_url()."images/product_images/".$image."' width='13' height='13' alt='' class='zoom' /></a>
                                    </div>
                                </div>
                                <div class='right'>
                                    <div class='head'>
                                        <h2>" .$productName." </h2>
                                            <div class='like'>
                                                <span class='like_arrow'>692</span>
                                            </div>
                                    </div>
                                    <p><b>Min. Order:</b> 1 Ton <b>Price:</b> US $900-1150 / Ton<br />
                                    <b>Payment Terms:</b> L/C,D/P,T/T <b>Supply Ability:</b> 50 Ton per Day</p>
                                    <p><b>Additional Information:</b><br />". $short_description.' '.anchor('prodetail/'.M_encrypt::encode($product['product_id']),'Read More')."</p>
                                        
                                    <ul class='company_product_desc_list'>
                                        <li class='select'><input type='checkbox' />Select</li>
                                        <li class='add_to_favorites'><a href='#'>Add to Favorites</a></li>
                                        <li class='contact_company'><a href='#'>Contact Company</a></li>
                                        <li class='add_to_wishlist'><a href='#'>Add To Wishlist</a></li>
                                    </ul>
                                </div>
                            </div>";
                    }
                }
        }
        else{
            if($cid){
                $this->load->model('M_company','',True);
                $this->load->library('session'); 
                $template = $this->_init();
                if($cat_id == 0){
                    $template['products'] = $this->M_company->getProductByCompany($cid);
                }
                else{
                    $template['products'] = $this->M_company->getProductByCompanyAndCategory($cid, $cat_id);
                }
                $template['cat_id'] = $cat_id;
                $template['categories'] = $this->M_company->getCompanyCategories($cid);
                $template['category'] = $this->M_category->getCategory($cat_id) ;
                $template['company_id'] = $cid;
                $template['modules'] = array(
                    'login' => 1,
                    'top-menu' => 1
                );
                $template['layout'] = 'company';
                $template['content'] = $this->load->view('modules/company/products/list',$template, True); 
                $this->load->view('template', $template);
            }
        }
    }
*/   
    public function _init(){
        
        $data['country_options'] = $this->M_country->getAllCountryOptions();
        $data['business_type_options'] = $this->M_company->getAllBusinessType();
        $data['certification_options'] = $this->M_company->getAllCertification();
        $data['region_options'] = $this->M_company->getAllRegion();
        $data['service_options'] = $this->M_company->getAllService();
        
       // $data['businessType']=$this->M_optionBusinessType->getBusinessTypes();
        $data['countries'] = $this->M_country->getAllCountryName();
        $data['categories'] = $this->M_category->getCategories();
        return $data;
    }
    
    public function add($id = 0){
        $user_id = $this->m_session->getUserID();
		
        $template = $this->_init($user_id);
        
		$company = $this->M_company->getCompanyByUser($user_id);

		$template['user'] = $this->M_user->getUserById($user_id);
		$template['company'] = (array)$company[0];
		$template['content'] = $this->load->view('modules/company/edit_company', $template, true);

        $template['modules'] = array(
                'login' => 1,
                'category-menu' => 1,
                'top-menu' => 1
        );
        $template['layout'] = 'company';
        $this->load->view('template', $template);
    }
    
    public function do_update($company_id = 0){
        $user_id = $this->m_session->getUserID();

		$company = $this->M_company->getCompanyByUser($user_id);

        $data = $this->_getInputField();
/*        if(isset($_FILES['userfile']) && $_FILES['userfile']['name'] != ''){
            $data['file'] = $this->_upload_img();
        }
*/      
		if(isset($data['file']) && $data['file']!=''){
			if(!copy('images/company_images/temp/'.$data['file'],'images/company_images/'.$data['file'])){
				unset($data['file']);
			}
		}else{
			unset($data['file']);
		}
		if(!$this->_company_validation($data)){

			$template = $this->_init($user_id);
			$template['user'] = $this->M_user->getUserById($user_id);
			$template['company'] = (array)$company[0];
            $template['content'] = $this->load->view('modules/company/edit_company', $template, true);

            $template['modules'] = array(
                    'login' => 1,
                    'category-menu' => 1,
                    'top-menu' => 1
            );
            $template['layout'] = 'company';
            $this->load->view('template', $template);
        } else {
        
            $this->M_company->update($company[0]->id,$data);
			// Update Sugar Data
			$this->m_sugar->setCompanyToSugar($company[0]->id,$user_id);
			
            redirect(site_url('/myoffice'));
        }
    }

	function uploadimage(){
		$config = array(
			'upload_path'   =>  realpath(APPPATH . '../images/company_images/temp'),
			'allowed_types' =>  'gif|jpg|png',
			'file_name' => MD5(M_misc::getTimestamp())
		);
		
		$this->load->library('upload', $config);
		
		if (!$this->upload->do_upload()){
			echo $this->upload->display_errors();
		}else{
			$file = $this->upload->data();
			
			$config = array(
				'image_library'	=>'gd2',
				'source_image'	=> $file['full_path'],
				'width'	=>150,
				'height' =>150
			);
			
			$this->load->library('image_lib',$config);
			
			if ( ! $this->image_lib->resize()){
				echo $this->image_lib->display_errors();
			}
			echo $file['file_name'];
		}
	}
	
/*  
    public function do_addcompany(){
        $this->load->helper('url');
        $this->load->model('M_company','',True);
        $this->load->model('M_user','',True);
        
        $data_contact = array(
            'firstname' =>  $this->input->post('firstname'),
            'lastname' =>  $this->input->post('lastname'),
            'image' =>  $this->_upload_img()
        );
        
//        $contact_id = $this->input->post('contact_id');
//        if($contact_id){
//           $this->M_company->updateContactById($contact_id,$data_contact);
//        } else {
//           $contact_id = $this->M_company->insertContact($data_contact); 
//        }
        
        $data = $this->_getInputField();  
        $data['file'] = $data_contact['image'];
        if(!$this->_company_validation($data)){
            redirect(site_url('/company/add/?error=1'));
        }
        $company_id = $this->M_company->insertCompany($data);
        
        redirect(site_url('/company/add/'.$company_id));
    }
*/
/*
    public function _upload_img(){
        $config = array(
        'upload_path'   =>  realpath(APPPATH . '../images/company_contact'),
        'allowed_types' =>  'gif|jpg|png',
        'file_name' =>  time()
        );
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload()){
            return "";
        }else{
            $data = $this->upload->data();
            $config = array(
            'source_image' => $data['full_path'],
            'new_image' => realpath(APPPATH . '../images/company_thumbs'),
            'maintain_ration' => true,
            'width' => 150,
            'height' => 150
            );
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
            
            return $data['file_name'];
        }
    }
*/
    function _getInputField(){
        $businessType=($this->input->post('business_types'))? $this->input->post('business_types'):'';
        $data_company = array(
			'name'              => $this->input->post('name'),
            'address'	        => $this->input->post('address'),
			'city'	        => $this->input->post('city'),
            'state'	        => $this->input->post('state'),
			'country'           => $this->input->post('country'),
            'zip'               => $this->input->post('zip'),
            'website'	        => $this->input->post('website'),
            'email'             => $this->input->post('email'),
            'phone_country'     => $this->input->post('phone_country'),
            'phone_area'        => $this->input->post('phone_area'),
            'phone_number'      => $this->input->post('phone_number'),
            'fax_country'       => $this->input->post('fax_country'),
            'fax_area'          => $this->input->post('fax_area'),
            'fax_number'        => $this->input->post('fax_number'),
    	    'business_type'    => $this->input->post('business_types'),
            'sell_product'      => $this->input->post('sell_product'),
            'service'           => ($this->input->post('services'))? implode("|",$this->input->post('services')):'',
            'year'              => $this->input->post('year'),
            'no_employee'       => $this->input->post('no_employee'),
            'brand'             => $this->input->post('brand'),
            'ownership_type'    => $this->input->post('ownership_type'),
            'registered_capital'=> $this->input->post('registered_capital'),
            'owner'             => $this->input->post('owner'),
            'annual_sale'       => $this->input->post('annual_sale'),
            'export_per'        => $this->input->post('export_per'),
            'region'            => ($this->input->post('regions'))? implode("|",$this->input->post('regions')):'',
            'customer'          => $this->input->post('customer'),
            'certification'     => ($this->input->post('certifications'))? implode("|",$this->input->post('certifications')):'',
            'factory_location'  => $this->input->post('factory_location'),
            'factory_size'      => $this->input->post('factory_size'),
            'factory_productionline'    => $this->input->post('factory_productionline'),
            'factory_purchase'  => $this->input->post('factory_purchase'),
            'factory_qc'        => $this->input->post('factory_qc'),
            'factory_no_staff'  => $this->input->post('factory_no_staff'),
            'factory_no_qc'     => $this->input->post('factory_no_qc'),
            'product_keyword'	=> $this->input->post('product_keyword'),
            'file'	=> $this->input->post('userimage')
        );
        $data_company['country_name'] = $this->M_country->getCountryNameByCode($data_company['country']);
		$data_company['country_region'] = $this->M_country->getRegionByCode($data_company['country']);
		
        $coordinates = $this->_getCoordinates($data_company);
        if(!empty($coordinates)){
            $data_company['longitude'] = $coordinates['longitude'];
            $data_company['latitude'] = $coordinates['latitude'];
        }
		
		
		
        return $data_company;
    }
    
    function _getCoordinates($data){
        $coordinates = array();
        if($data['address'] != '' && $data['country'] != '' && $data['city'] != '' && $data['zip'] != ''){
            $adr = urlencode($data['country'].$data['city'].$data['address'].$data['zip']);
            $geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$adr.'&sensor=false');
            $output= json_decode($geocode);
            $lat = $output->results[0]->geometry->location->lat;
            $long = $output->results[0]->geometry->location->lng;
            $coordinates['latitude'] = $lat;
            $coordinates['longitude'] = $long;
        }
        return $coordinates;
    }
    
    function _company_validation($data){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Company Name *', 'required');
        $this->form_validation->set_rules('address', 'Street Address', 'callback__address_check');
        $this->form_validation->set_rules('city', 'City *', 'callback__city_check');
        $this->form_validation->set_rules('country', 'Country *', 'callback__country_check');
        //$this->form_validation->set_rules('zip', 'Zip Code *', 'callback__zip_check');
        $this->form_validation->set_rules('phone_country', 'Phone Country Code', 'callback__business_phone');
        $this->form_validation->set_rules('phone_area', 'Area Code', 'numeric');
        $this->form_validation->set_rules('phone_number', 'Phone Number', 'numeric');
        $this->form_validation->set_rules('fax_area', 'Area Code', 'numeric');
        $this->form_validation->set_rules('fax_number', 'Phone Number', 'numeric');
        $this->form_validation->set_rules('business_types', 'Business Type', 'callback__business_types_check');
        $this->form_validation->set_rules('sell_product', 'Product Service', 'callback__sell_product_check');
        $this->form_validation->set_error_delimiters('<span class="error" style="color:red;float:right;">', '</span>');


        if ($this->form_validation->run() == FALSE) {
                return FALSE;
        } else {
                return TRUE;
        }       
    }
    function _address_check(){
        if($this->input->post('address'))
	    return TRUE;
	$this->form_validation->set_message('_address_check', 'Company Address is required.');
        return FALSE;
    }
    
    function _city_check(){
        if($this->input->post('city'))
            return TRUE;
	$this->form_validation->set_message('_city_check', 'City is required.');
        return FALSE;
    }
    
    function _country_check(){
        if($this->input->post('country'))
            return TRUE;
	$this->form_validation->set_message('_country_check', 'Country is required.');
        return FALSE;
    }
    
    function _zip_check(){
        if($this->input->post('zip'))
            return TRUE;
	$this->form_validation->set_message('_zip_check', 'Zip Code is required.');
        return FALSE;
    }
    
    function _sell_product_check(){
        if($this->input->post('sell_product') && $this->input->post('sell_product') != 'List Items/Services *')
	    return TRUE;
	$this->form_validation->set_message('_sell_product_check', 'Product Service is required.');
        return FALSE;
    }
    
    function _business_types_check(){
        if($this->input->post('business_types'))
	    return TRUE;
	$this->form_validation->set_message('_business_types_check', 'Please choose your business type.');
        return FALSE;
    }
    
    function addCompanyDetails($company_id = 0, $action = ''){
        $this->load->helper(array('url','form'));
        if($company_id){
            $user_id = $this->m_session->isLogin();
            if($user_id){
				$company_id = $this->M_encrypt->decode($company_id);
                $action = $this->uri->segment(5);
                switch($action){
                    case "favourite":
                        if($this->M_company->addToFavourite($user_id, $company_id)){
                            $this->load->view('modules/company/favourite/index', array('already_exists'=>false));
                        } else {
                            $this->load->view('modules/company/favourite/index', array('already_exists'=>true));
                        }
                        break;
                    case "contact":
                        if($this->M_company->addToContact($user_id, $company_id)){
                            $this->load->view('modules/company/contact/index', array('already_exists'=>false));
                        } else {
                            $this->load->view('modules/company/contact/index', array('already_exists'=>true));
                        }
                        break;
                    case "network":
                        if($this->M_company->addToNetwork($user_id, $company_id)){
                            $this->load->view('modules/company/network/index', array('already_exists'=>false));
                        } else {
                            $this->load->view('modules/company/network/index', array('already_exists'=>true));
                        }
                        break;
                }
            } else {
                $this->load->view('modules/company/login');
            }
        }
    }
    
    function editCompanyDetails($action = ''){
        $data = array();
        $data = $this->_init();
        $user_id = $this->m_session->getUserID();
        $user = $this->M_user->getUserById($user_id);
        $data['user'] = $user;
        $company = $this->M_company->getCompanyByUser($user_id);
        $company = $company[0];
        $data['company'] = $company;
       
        switch($action){
            case "favourite":
                if($this->input->post('favourites')){
                    $favourites = $this->input->post('favourites');
                    foreach($favourites as $favourite){
                        $this->M_company->favouriteDelete($favourite, $user_id);
                    }
                }
				
                $order = ($this->input->get_post('order'))?$this->input->get_post('order'):'';
                $view = $this->input->get_post('view')?$this->input->get_post('view'):'';
                $page = $this->input->get_post('page')?$this->input->get_post('page'):1;

                $this->M_company->fav_page = $page;
                $res = $this->M_company->getFavouriteCompanies($user_id, $order, true);
                $data['default'] = array(
                        'order'=>$order,
                        'view'=>$view,
                        'page'=>$page,
                );
                $data['pagination'] = $res['pagination'];
                $data['pagination']['cur'] = $page;
                $data['favourites'] = $res['result'];
				
                $template['content'] = $this->load->view('modules/company/favourite/list',$data, True);
                break;
            case "contact":
                if($this->input->post('contacts')){
                    $contacts = $this->input->post('contacts');
                    foreach($contacts as $contact){
                        $this->M_company->contactDelete($contact, $user_id);
                    }
                }
                $order = ($this->input->post('order'))?$this->input->post('order'):'';
                $view = $this->input->get_post('view')?$this->input->get_post('view'):'';
                $page = $this->input->get_post('page')?$this->input->get_post('page'):1;
                
                $this->M_company->cont_page = $page;
                $res = $this->M_company->getContactCompanies($user_id, $order, true);
                $data['default'] = array(
                        'order'=>$order,
                        'view'=>$view,
                        'page'=>$page,
                );
                
                
                $data['pagination'] = $res['pagination'];
                $data['pagination']['cur'] = $page;
                $data['company_contacts'] = $res['contacts'];
                $data['staff'] = $res['staff'];
                
//                $data['company_contacts'] = $this->M_company->getContactCompanies($user_id, $order);
                $template['content'] = $this->load->view('modules/company/contact/list',$data, True);
                break;
            case "network":
                if($this->input->post('networks')){
                    $networks = $this->input->post('networks');
                    foreach($networks as $network){
                        $this->M_company->networkDelete($network, $user_id);
                    }
                }
                
                $order = ($this->input->post('order'))?$this->input->post('order'):'';
                $view = $this->input->get_post('view')?$this->input->get_post('view'):'';
                $page = $this->input->get_post('page')?$this->input->get_post('page'):1;
                
                $this->M_company->net_page = $page;
                $res = $this->M_company->getNetworkCompanies($user_id, $order, true);
                $data['default'] = array(
                        'order'=>$order,
                        'view'=>$view,
                        'page'=>$page,
                );
                
                $data['pagination'] = $res['pagination'];
                $data['pagination']['cur'] = $page;
                $data['networks'] = $res['networks'];
                $data['staff'] = $res['staff'];
                
                $template['content'] = $this->load->view('modules/company/network/list',$data, True);
                break;
        }
        $template['modules'] = array(
                'login' => 1,
                'top-menu' => 1
        );
        $template['layout'] = 'company';
        $this->load->view('template', $template);
    }
    
    public function favourites(){
        $this->editCompanyDetails('favourite');
    }
    
    public function contacts(){
        $this->editCompanyDetails('contact');
    }
    
    public function networks(){
        $this->editCompanyDetails('network');
    }
    
    function staff(){

		$action = $this->uri->segment(3);
		$staff_id = $this->uri->segment(4);

		$user_id = $this->m_session->getUserID();
		
		$user = $this->M_user->getUserById($user_id);
		
		$company = $this->M_company->getCompanyByUser($user_id);
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
		
		$company = $company[0];
		
		if($this->input->post('employees')){
			$employees = $this->input->post('employees');
			foreach($employees as $employee){
				$this->M_company->staffDelete($company->id,$employee);
			}
		}
		switch($action){
			case 'upload':
				$config = array(
					'upload_path'   =>  realpath(APPPATH . '../images/user_images/temp'),
					'allowed_types' =>  'gif|jpg|png',
					'file_name' => MD5(M_misc::getTimestamp())
				);
				
				$this->load->library('upload', $config);
				
				if (!$this->upload->do_upload('contactimage')){
					echo $this->upload->display_errors();
				}else{
					$file = $this->upload->data();
					
					$config = array(
						'image_library'	=>'gd2',
						'source_image'	=> $file['full_path'],
						'width'	=>150,
						'height' =>150
					);
					
					$this->load->library('image_lib',$config);
					
					if ( ! $this->image_lib->resize()){
						echo $this->image_lib->display_errors();
					}
					echo $file['file_name'];
				}
			break;
			case 'edit':
				$data = array();
				if(!intval($staff_id)){
					echo "Please Select Your Contact / Staff First";
				}else{
					$staff = $this->M_company->staffList($company->id,$staff_id);
					$data['staff'] = (array)$staff[0];
					$this->load->view('modules/company/staff/staff_fields',$data);
				}
			break;
			case 'add':
				$data = array();
				$data['staff'] = array(
					'company_id' => $company->id
				);
				$this->load->view('modules/company/staff/staff_fields',$data);
			break;
			case 'setDefault':
				$params['company_id'] = $company->id;
				$params['id'] = $staff_id;
				$params['is_default'] = 1;
				
				$data['status'] = $this->M_company->staffSetDefault($params);
				
				redirect('company/staff');
			//                            $this->load->view('json',array('response'=>$data));
			break;
			case 'save':
				$params = $this->input->post('params');
				
				if(isset($params['image']) && !empty($params['image'])){
					if(!copy('images/user_images/temp/'.$params['image'],'images/user_images/'.$params['image'])){
						unset($params['image']);
					}
				}else{
					unset($params['image']);
				}
				
				$data['status'] = $this->M_company->staffSave($params);
				
				echo "
				<script>top.app.redirect('company/staff');top.Shadowbox.close();</script>
				";
				//redirect('company/staff');
				//$this->load->view('json',array('response'=>$data));
			break;
			case 'page':
			case 'list':
			default:
				$data = array();
				$data = $this->_init();
				
				$data['company'] = $company;
				$data['defaultStaff'] = array(
					'id' => 0,
					'image' => $user['image'],
					'firstname' => $user['firstname'],
					'lastname' => $user['lastname'],
					'mobile' => '',
					'position' => '',
					'phone' => $user['phone_country'].$user['phone_area'].$user['phone_number'],
					'email' => $user['email'],
					'is_default' => 0
				);
				
				$order = $this->input->get_post('order')?$this->input->get_post('order'):'';
				$view = $this->input->get_post('view')?$this->input->get_post('view'):'';
				$page = $this->input->get_post('page')?$this->input->get_post('page'):1;
				$this->M_company->staff_page = $page;
				$res = $this->M_company->staffList($company->id, 0, $order,true);
				$data['default'] = array(
					'order'=>$order,
					'view'=>$view,
					'page'=>$page,
				);
				$data['pagination'] = $res['pagination'];
				$data['pagination']['cur'] = $page;
				$data['staffs'] = $res['result'];
				
				$template['content'] = $this->load->view('modules/company/staff/list',$data, True);
				
				$template['modules'] = array(
					'login' => 1,
					'top-menu' => 1
				);
				$template['layout'] = 'company';
				$this->load->view('template', $template);
				
			break;
		}
    }
}
