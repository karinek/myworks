<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        
        $this->load->helper(array('form','url','html'));
        $this->load->library('session');
        $this->load->model('M_product','Product',TRUE);
        $this->load->model('M_company','',True);
        $this->load->model('M_country','',True);
        $this->load->model('M_currency','',True);
        $this->load->model('m_session','',True);
        $this->load->model('M_category','',True);
        $this->load->model('M_user','',True);
        $this->load->model('m_sugar');
        $this->load->model('M_optionBusinessType','',True);
        $this->load->model('m_addto');
        $this->load->model('M_options','',True);
		$this->load->model('M_encrypt');
    }

    public function index(){
        $user_id = $this->m_session->getUserID();
		$data['categories'] = $this->M_category->getSubCategory(0);
        $data['countries'] = $this->M_country->getAllCountryName();
        $data['business_type_options'] = $this->M_company->getAllBusinessType();
        $data['user'] =  $this->M_user->getUserById($user_id);
        $data['modules'] = array(
                    'login' => 1,
                    'category-menu' => 1,
                    'top-menu' => 1
            );
        $data['layout'] = 'selling';
        if ($data['user']['role'] == 'buyer')
            $data['content'] = $this->load->view('modules/product/confirm_role', $data, true);
        else
            $data['content'] = $this->load->view('modules/product/selling_step_1', $data, true);
        $this->load->view('template', $data);
    }
    function confirm_seller_request() {
        $user_id = $this->m_session->getUserID();
        $this->M_user->changeRole($user_id, 'both');
        
        redirect('product');
    }
    function addproductstep1($category_id){
        $categroies = $this->M_category->getSubCategory($category_id);
        print_r(json_encode($categroies));
    }

    function addproductstep2(){
        $user_id = $this->m_session->getUserID();
        $this->_actioncheck($user_id);
        if($this->input->post('category_id')){
            $newdata = array(
                        'category_id'  => $this->input->post('category_id'),
                    );

            $this->session->set_userdata($newdata);
            $category_id = $this->session->userdata['category_id'];
        }
        else{
            $category_id = $this->session->userdata['category_id'];
            if (!$category_id)
                redirect('product');
        }
        $data = $this->_init($category_id);
         if($this->input->post('catdisplay')){
            $newdata = array(
                        'catdisplay'  => $this->input->post('catdisplay'),
                    );

            $this->session->set_userdata($newdata);
            $data['catdisplay'] = $this->session->userdata['catdisplay'];
        }
        else{
             $data['catdisplay'] = $this->session->userdata['catdisplay'];
        }
        $data['category_id'] = $category_id;
        $data['modules'] = array(
                'login' => 1,
                'top-menu' => 1,
        );
        $data['layout'] = 'selling';
        $data['content'] = $this->load->view('modules/product/selling_step_2', $data, true);
        $this->load->view('template', $data);
    }

    public function edit($product_id){
        $user_id = $this->m_session->getUserID();
		$product_info = $this->Product->getInfo($product_id);
		$company_id = $this->M_user->getCompanyByUser($user_id);
		
		if ($company_id !== $product_info['company_id']) {
			redirect('welcome');
		}
        $product_attrs = $this->Product->getAttributeValues($product_id);

        $data = $this->_init($product_info['category_id'],$product_attrs);

        $data['product_id'] = $product_id;
        $data['product'] = $product_info;
        $data['product_category_list'] = $this->M_category->getList($data['product']['category_id']);
        $data['product_images'] = $this->Product->getImages($product_id);
        $data['product_attrs'] = $product_attrs;
        $data['product_order'] = $this->Product->getOrderAttributes($product_id);

        $data['category_id'] = $data['product']['category_id'];
        $data['catdisplay'] = $this->M_category->getList($data['category_id']);

        $data['hidden'] = array('product_id' => $product_id,
                                'category_id' => $data['product']['category_id']);

        $data['modules'] = array(
                'login' => 1,
                'top-menu' => 1,
        );
        $data['layout'] = 'selling';
        $data['content'] = $this->load->view('modules/product/edit_view', $data, true);
        $this->load->view('template', $data);

    }


    public function add(){
        $user_id = $this->m_session->getUserID();
        $company_id = $this->M_user->getCompanyByUser($user_id);
        $category_id = $this->input->post('category_id');

        if (!$category_id)
            redirect('product');

        if(!$this->_product_validation()){
            $category_id = $this->input->post('category_id'); 
            $data = $this->_init($category_id);
            $data['catdisplay'] = $this->session->userdata['catdisplay'];
            $data['category_id'] = $category_id;
            $data['modules'] = array(
                    'login' => 1,
                    'top-menu' => 1,
            );
            $data['layout'] = 'selling';
            $data['content'] = $this->load->view('modules/product/selling_step_2', $data, true);
            $this->load->view('template', $data);
        }
        else{
        $data = array(
            'name' => $this->input->post('prod_name') ,
            'keywords' => $this->input->post('prod_kwd') ,
            'category_id' => $category_id,
            'company_id' => $company_id,
            'short_description' => $this->input->post('short_desc'),
            'long_description' => $this->input->post('long_desc'),
            'upload_time' => date("Y-m-d h:i:s"),
            'update_time' => date("Y-m-d h:i:s")
        );

        $data['long_description'] = str_replace('&nbsp;', "", $data['long_description']);
        $product_id = $this->Product->insert_product($data);
        $payment_terms_post = $this->input->post('pay_terms');
        $payment_terms ="";
        if(!empty($payment_terms_post) && is_array($payment_terms_post)){
            $payment_terms = implode("|", $payment_terms_post);
        }

        $data = array(
                'product_id' => $product_id,
                'qty' => ($this->input->post('qty'))?$this->input->post('qty'):'',
                'qty_unit' => $this->input->post('qty_unit'),
                'price_cur' => $this->input->post('prc_cur'),
                'price_1' => $this->input->post('cur_prc1'),
                'price_2' => $this->input->post('cur_prc2'),
                'price_unit' => $this->input->post('cur_unit'),
                'port' => $this->input->post('port'),
                'pay_terms' => $payment_terms,
                'prod_capacity' => $this->input->post('prod_cpt'),
                'prod_capacity_unit' => $this->input->post('cpt_unit'),
                'prod_capacity_per' => $this->input->post('cpt_prd'),
                'delivery_time' => $this->input->post('dlv_t'),
                'pkg_details' => $this->input->post('p_dts')
                );
        $this->Product->insert_product_order_attributes($data);

        $data = array(
                'product_id' => $product_id,
                'image_name' => $this->_upload_img($this->input->post('image_name'),$product_id)
        );

        $this->Product->insert_product_image($data);

        $attributes= $this->Product->getAttributesForCategory($category_id);
        $data = array();          
        foreach ($attributes as $attribute){
            $attr_field_name = "attr_".$attribute->attr_id;
            $attr_field_value = $this->input->post($attr_field_name);

            $field_value = "";
            if(isset($attr_field_value)){
                if(is_array($attr_field_value)){
                    $field_value = implode("|", $attr_field_value);
                }else{                        
                    $field_value = $attr_field_value;
                }
            }
            // Other values special case.
            $attr_field_other_name = "othertext_".$attribute->attr_id;
            $attr_field_other_value = $this->input->post($attr_field_other_name);
            $field_other_value = "";

            if(isset($attr_field_other_value)){
                $field_other_value = $attr_field_other_value;
            }

            $data[] = array(
                            'product_id' 	=> $product_id,
                            'category_id'	=> $category_id,
                            'attr_id'	=> $attribute->attr_id,
                            'attr_name'	=> $attribute->attr_name,
                            'attr_value'	=> $field_value,
                            'attr_other_value'	=>  $field_other_value
                            );
        }

        $dynmaic_attr_count = $this->input->post('dyn_attr_count'); 

        for($i = 1; $i <= $dynmaic_attr_count; $i++) {
            $data[] = array(
                            'product_id' 	=> $product_id,
                            'category_id'	=> $category_id,
                            'attr_id'	=> 0,
                            'attr_name'	=> $this->input->post('title_'.$i),
                            'attr_value'	=> $this->input->post('value_'.$i),
                            'attr_other_value'	=>  $field_other_value
                            );
        }

        if(count($data) >= 1){
            $this->Product->insert_product_attributes($data); 
        }


        $user = $this->M_user->getUserById($user_id);
        $this->M_user->update($user_id,array('selling_count' => $user['selling_count'] + 1));	   

        redirect('prodetail/'.$this->M_encrypt->encode($product_id));
    //    $this->load->view('product_add_step3');	
            }      
    }

    public function ok(){
        $this->load->view('product_add_step3');
    }

    public function do_edit(){
        $category_id = $this->input->post('category_id');
        $product_id = $this->input->post('product_id');

        $data = array(
            'keywords' => $this->input->post('prod_kwd') ,
            'short_description' => $this->input->post('short_desc'),
            'long_description' => $this->input->post('long_desc'),
            'update_time' => date("Y-m-d h:i:s")
        );

        $data['long_description'] = str_replace('&nbsp;', "", $data['long_description']);
        $this->Product->update_product($product_id,$data);


        $payment_terms_post = $this->input->post('pay_terms');
        $payment_terms ="";
        if(!empty($payment_terms_post)){
            $payment_terms = implode("|", $payment_terms_post);
        }

        $data = array(
                'qty' => $this->input->post('qty'),
                'qty_unit' => $this->input->post('qty_unit'),
                'price_cur' => $this->input->post('prc_cur'),
                'price_1' => $this->input->post('cur_prc1'),
                'price_2' => $this->input->post('cur_prc2'),
                'price_unit' => $this->input->post('cur_unit'),
                'port' => $this->input->post('port'),
                'pay_terms' => $payment_terms,
                'prod_capacity' => $this->input->post('prod_cpt'),
                'prod_capacity_unit' => $this->input->post('cpt_unit'),
                'prod_capacity_per' => $this->input->post('cpt_prd'),
                'delivery_time' => $this->input->post('dlv_t'),
                'pkg_details' => $this->input->post('p_dts')
                );


        $this->Product->update_product_order_attributes($product_id,$data);

        $image_name = $this->input->post('image_name');

        if(isset($image_name) && !empty($image_name)){
            $data = array(
                    'image_name' => $this->_upload_img($image_name,$product_id)
            );
            $this->Product->update_product_image($product_id,$data);
        }

        $attributes= $this->Product->getAttributesForCategory($category_id);
        $data = array();          

        foreach ($attributes as $attribute){
            $attr_field_name = "attr_".$attribute->attr_id;
            $attr_field_value = $this->input->post($attr_field_name);

            $field_value = "";
            if(isset($attr_field_value)){
                if(is_array($attr_field_value)){
                    $field_value = implode("|", $attr_field_value);
                }else{                        
                    $field_value = $attr_field_value;
                }
            }
            // Other values special case.
            $attr_field_other_name = "othertext_".$attribute->attr_id;
            $attr_field_other_value = $this->input->post($attr_field_other_name);
            $field_other_value = "";

            if(isset($attr_field_other_value)){
                $field_other_value = $attr_field_other_value;
            }

            $data = array(
                            'attr_value'	=> $field_value,
                            'attr_other_value'	=>  $field_other_value
                            );

            $this->Product->update_product_attributes($product_id, $attribute->attr_id, $data);
        }

        $this->Product->del_additional_attributes($product_id);
        $dynmaic_attr_count = $this->input->post('dyn_attr_count'); 
        $data = array();
        for($i = 1; $i <= $dynmaic_attr_count; $i++) {
            $data[] = array(
                            'product_id' 	=> $product_id,
                            'category_id'	=> $category_id,
                            'attr_id'	=> 0,
                            'attr_name'	=> $this->input->post('title_'.$i),
                            'attr_value'	=> $this->input->post('value_'.$i),
                            'attr_other_value'	=>  $field_other_value
                            );
        }
        if(count($data) >= 1){
            $this->Product->insert_product_attributes($data); 
        }

        redirect('prodetail/'.$this->M_encrypt->encode($product_id));

    }

    public function img_preview(){

            $config = array(
                'upload_path'   =>  realpath(APPPATH . '../images/product_images/temp'),
                'allowed_types' =>  'gif|jpg|png',
                'file_name' =>  time()
            );

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()){
                echo $this->upload->display_errors();
            }else{
                $data = $this->upload->data();



                echo $data['file_name'];
            }
        }

    public function show($product_id){
		$product_id = $this->M_encrypt->decode($product_id);
		if(!is_numeric($product_id)){
			show_404();
		}
		$data['product_id'] = $product_id;
        $data['product'] = $this->Product->getInfo($product_id);
		
		if(!$data['product']){
			show_404();
		}
		
        if(isset($data['product']['category_id'])){
            $data['breadcrumbs'] = $this->M_category->getBreadcrumbs($data['product']['category_id']);
            $data['company'] = $this->M_company->getCompanyById($data['product']['company_id']);
        }
        $data['product_images'] = $this->Product->getImages($product_id);
        $data['product_attrs'] = $this->_attrs_show($this->Product->getAttributeValues($product_id));
        $data['product_order'] = $this->Product->getOrderAttributes($product_id);
        $data['related_products'] = $this->Product->getRelatedProducts($product_id, $data['product']['name']);
        $data['certification_options'] = $this->M_company->getAllCertification();
        $data['newproducts'] = $this->Product->getNewProductList();
     //   $data['inWatchList'] = $this->m_addto->getWatchListProductIds($user_id);

        $template['modules'] = array(
                'login' => 1,
                'top-menu' => 1,
        );

        $template['layout'] = 'product';
        $data['countries'] = $template['countries'] = $this->M_country->getAllCountryName();
        $template['categories'] = $this->M_category->getCategories();
        $template['business_type_options'] = $this->M_company->getAllBusinessType();
        $template['content'] = $this->load->view('modules/product/show_view',$data, true);
        $this->load->view('template', $template);
    }

    public function preview(){
        $user_id = $this->m_session->getUserID();
        $category_id = $this->input->post('category_id');
        $company_id = $this->M_user->getCompanyByUser($user_id);

        if(!$this->_product_validation()){

            $data = $this->_init($category_id);
            $data['catdisplay'] = $this->session->userdata['catdisplay'];
            $data['category_id'] = $category_id;
            $data['modules'] = array(
                    'login' => 1,
                    'top-menu' => 1,
            );
            $data['layout'] = 'selling';
            $data['content'] = $this->load->view('modules/product/selling_step_2', $data, true);
            $this->load->view('template', $data);
        }
        else{
            $data = array(
                'name' => $this->input->post('prod_name') ,
                'keywords' => $this->input->post('prod_kwd') ,
                'category_id' => $category_id,
                'company_id' => $company_id,
                'short_description' => $this->input->post('short_desc'),
                'long_description' => $this->input->post('long_desc'),
                'upload_time' => date("Y-m-d h:i:s"),
                'update_time' => date("Y-m-d h:i:s")
            );


            $product_id = $this->Product->insert_temp_product($data);


            $preview_data['product'] = $data;
            $preview_data['product']['product_id'] = $product_id;

            $payment_terms_post = $this->input->post('pay_terms');
            $payment_terms ="";
            if(!empty($payment_terms_post)){
                $payment_terms = $payment_terms_post;
            }

            $data = array(
                'product_id' => $product_id,
                'qty' => ($this->input->post('qty'))?$this->input->post('qty'):'',
                'qty_unit' => $this->input->post('qty_unit'),
                'price_cur' => $this->input->post('prc_cur'),
                'price_1' => $this->input->post('cur_prc1'),
                'price_2' => $this->input->post('cur_prc2'),
                'price_unit' => $this->input->post('cur_unit'),
                'port' => $this->input->post('port'),
                'pay_terms' => $payment_terms,
                'prod_capacity' => $this->input->post('prod_cpt'),
                'prod_capacity_unit' => $this->input->post('cpt_unit'),
                'prod_capacity_per' => $this->input->post('cpt_prd'),
                'delivery_time' => $this->input->post('dlv_t'),
                'pkg_details' => $this->input->post('p_dts')
                );

            $preview_data['product_order'] = $data;
            $this->Product->insert_temp_product_order_attributes($data);

            $data = array(
                    'product_id' => $product_id,
                    'image_name' => $this->_upload_img($this->input->post('image_name'),$product_id)
            );
            $preview_data['product_images'] = $data;
            $this->Product->insert_temp_product_image($data);



            $attributes= $this->Product->getAttributesForCategory($category_id);
            $data = array();          
            foreach ($attributes as $attribute){
                $attr_field_name = "attr_".$attribute->attr_id;
                $attr_field_value = $this->input->post($attr_field_name);

                $field_value = "";
                if(isset($attr_field_value)){
                    if(is_array($attr_field_value)){
                        $field_value = implode("|", $attr_field_value);
                    } else {
                        $field_value = $attr_field_value;
                    }
                }
            // Other values special case.
                $attr_field_other_name = "othertext_".$attribute->attr_id;
                $attr_field_other_value = $this->input->post($attr_field_other_name);
                $field_other_value = "";

                if(isset($attr_field_other_value)){
                   $field_other_value = $attr_field_other_value;
                }

                $data[] = array(
                            'product_id' 	=> $product_id,
                            'category_id'	=> $category_id,
                            'attr_id'	=> $attribute->attr_id,
                            'attr_name'	=> $attribute->attr_name,
                            'attr_value'	=> $field_value,
                            'attr_other_value'	=>  $field_other_value
                            );
            }

            $dynmaic_attr_count = $this->input->post('dyn_attr_count');

            for($i = 1; $i <= $dynmaic_attr_count; $i++) {
                $data[] = array(
                            'product_id' 	=> $product_id,
                            'category_id'	=> $category_id,
                            'attr_id'	=> 0,
                            'attr_name'	=> $this->input->post('title_'.$i),
                            'attr_value'	=> $this->input->post('value_'.$i),
                            'attr_other_value'	=>  $field_other_value
                            );
            }

            $preview_data['product_attrs'] = $data;

            if(count($data) >= 1){
                $this->Product->insert_temp_product_attribute_value($data); 
        }

        $template['modules'] = array(
                'login' => 1,
                'top-menu' => 1,
        );

        $template['layout'] = 'product';
        $template['categories'] = $this->M_category->getCategories();
        $template['countries'] = $this->M_country->getAllCountryName();
        $template['businessType'] = $this->M_optionBusinessType->getBusinessTypes();
        $template['content'] = $this->load->view('modules/product/preview_view',$preview_data, true);
        $this->load->view('template', $template);
        }      
    }

    public function preview_submit($temp_product_id){
        $data = $this->Product->get_temp_info($temp_product_id);
        unset($data['product_id']);
        $data['update_time'] = date("Y-m-d h:i:s");
        $product_id = $this->Product->insert_product($data);

        $data = $this->Product->get_temp_product_order_attributes($temp_product_id);
        unset($data['pattr_id']);
        $data['product_id'] = $product_id;
        $this->Product->insert_product_order_attributes($data);

        $data = $this->Product->get_temp_product_image($temp_product_id);
        unset($data['id']);
        $data['product_id'] = $product_id;
        $this->Product->insert_product_image($data);


        $res = $this->Product->get_temp_product_attribute_values($temp_product_id);
        $data = array();
        foreach ($res as $val){
            unset($val['id']);
            $val['product_id'] = $product_id;
            $data[] = $val;
        }
        if(count($data)>=1)
            $this->Product->insert_product_attributes($data); 
        redirect('prodetail/'.$this->M_encrypt->encode($product_id));
    }

    public function manage(){
        $user_id = $this->m_session->getUserID();
        $company_id = $this->M_user->getCompanyByUser($user_id);

        if($this->input->post('products') && isset($_POST['delete'])){
            $products = $this->input->post('products');
            foreach($products as $product){
                    $pObj = $this->Product->getProductById((int)$product);
                    if($pObj[0]->company_id == $company_id){
                            $this->Product->del_additional_attributes((int)$product);
                            $this->Product->delete_product((int)$product);
                    }	
            }
        }

        $order = ($this->input->post('order'))?$this->input->post('order'):'';
        $page = $this->input->get_post('page')?$this->input->get_post('page'):1;

        switch ($order){
            case '': $arrange_by = 0; break;
            case 'asc': $arrange_by = 1; break;
            case 'desc': $arrange_by = 2; break;
        }

        $res = $this->M_company->getProductByCompanyWithPaging($company_id,$page,10,'',$arrange_by);

        $data['pagination'] = $res['pagination'];
        $data['pagination']['cur'] = $page;
        $data['products'] = $res['result'];

        $data['default'] = array(
                    'order'=>$order,
                    'page'=>$page,
        );

        $template['content'] = $this->load->view('modules/product/manage',$data,true);
        $template['modules'] = array(
                'login' => 1,
                'top-menu' => 1
        );
        $template['layout'] = 'company';
        $this->load->view('template', $template);
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function _init($category_id,$product_attrs = false){
        $data = array();
        $data['attrList'] = $this->_catattr($category_id, $product_attrs);

        $data['unitList'] = $this->Product->getUnitOptions();
        $data['paymentList'] = $this->Product->getAllPayment();

        $data['curList'] = $this->M_currency->getAllCurrency();		

        $countries = $this->M_country->getAllCountryName();

        return $data;
    }

    function _catattr($category_id,$product_attrs=false){
        $html='';
        $html .= $this->_genFormFields($category_id,$product_attrs);
        $html = trim($html);
        return $html;
    }

    function _genFormFields($category_id,$product_attrs=false){		
        $attributes= $this->Product->getAttributesForCategory($category_id);

        $product_attr_value = array();
        $product_additional_attr = array();

        if($product_attrs){
            foreach($product_attrs as $product_attr){
                if ($product_attr['attr_id']){
                    $product_attr_value[$product_attr['attr_id']] = $product_attr['attr_value'];
                    $product_attr_other_value[$product_attr['attr_id']] = $product_attr['attr_other_value'];
                } else {
                    $product_additional_attr[] = $product_attr;
                }
            }
        } 

        $countries= $this->M_country->getAllCountryName();

        $country_array = array();
        foreach($countries as $country){
            array_push($country_array, $country['name']);
        }

        $ret_string = '';
        if(count($attributes) > 0){
            foreach ($attributes as $attribute){
                if(!$product_attrs)
                    $product_attr_value[$attribute->attr_id] = "";

                $astring = stripslashes($attribute->attr_value);
                if($attribute->attr_type == 'checkbox'){
                    if(!empty($astring)){  
                        $options = explode("|", $astring);
                        $attr_value_array = array();
                        $attr_value_array = explode("|", $product_attr_value[$attribute->attr_id]);
                        $count=0;
                        $ret_string .= "<ul class='checkboxes_list small'>";
                        foreach ($options as $option){
                            $count++;
                            $name= "attr_{$attribute->attr_id}[]";

                            $checked = false;
                            if(in_array($option,$attr_value_array))
                                $checked = true;

                            $ret_string .=  "<li>".$this->_genCheckboxField($attribute->attr_id,$name,$option,$checked). "  " . $option."</li>";
                        }
                        $ret_string .= "</ul><br />";
                        $otherid= "other_{$attribute->attr_id}";
                        if (in_array('other',$attr_value_array) ||in_array('Other',$attr_value_array)){
                            $other_val = $product_attr_other_value[$attribute->attr_id];
                            $ret_string .= "<div  id='$otherid' ><input name='othertext_".$attribute->attr_id."' value='$other_val'></div></td></tr>";
                        } else {
                            $ret_string .= "<div  id='$otherid' style='display:none'><input name='othertext_".$attribute->attr_id."'></div></td></tr>";
                        }
                    }
                }

                if($attribute->attr_type == 'selectbox'){
                    $options = explode("|", $astring);
                    $name = "attr_{$attribute->attr_id}";
                    $otherid= "other_{$attribute->attr_id}";
                    $class = 'myselect';
                    $string = $this->_genSelectField($attribute->attr_id, $name,$options,$product_attr_value[$attribute->attr_id], $class);			
                    $ret_string .= "<div><b>".$attribute->attr_name.":</b></div><br />";
                    $ret_string .= "<div class='select'>".$string."</div>";
                    if ($product_attr_value[$attribute->attr_id] == 'other' || $product_attr_value[$attribute->attr_id] == 'Other'){
                            $other_val = $product_attr_other_value[$attribute->attr_id];
                            $ret_string .= "<div'  id='$otherid'><input name='othertext_".$attribute->attr_id."' value='$other_val'></div></td></tr>";
                        } else {
                            $ret_string .= "<div  id='$otherid' style='display:none'><input name='othertext_".$attribute->attr_id."'></div></td></tr>";
                    }

                }

                if($attribute->attr_type == 'textbox'){
                    $class = 'my_office_buyer_input';
                    $name = $attribute->attr_name;			
                    $id= "attr_{$attribute->attr_id}";
                    $string = "<p class='label'><label>".$name."</label></p>";
                    $string .= $this->_genTextboxField( $id, $name, $product_attr_value[$attribute->attr_id], $class);			
                    $ret_string .=  $string;
                }

                if($attribute->attr_type == 'optionbox'){
                    if(!empty($astring)){  
                        $options = explode("|", $astring);
                        foreach ($options as $option){
                            $name=$id= "attr_{$attribute->attr_id}[]";
                            $ret_string .=  $this->_genRadioboxField($name, $option, $option == $product_attr_value[$attribute->attr_id]). "  " . $option;
                        }
                        $ret_string .= "</td></tr>";
                    }
                }

                if($attribute->attr_type == 'textarea'){
                    $options = $astring;		
                    $name=$id= "attr_{$attribute->attr_id}";			
                    $string = $this->_genTextAreaboxField( $name, $id, $options);			
                    $ret_string .=  $string;
                }

                if($attribute->attr_type == 'label'){
                    $options = $astring;		
                    $name=$id= "attr_{$attribute->attr_id}";	
                    $string = "<input id='$id' type='hidden' name='$name' value='$options'><span style='font: 13px arial;'>".$options."</span>";			
                    $ret_string .=  "<tr><td><h2 style='display:block;font-size:13px'>" .$attribute->attr_name. ": </td><td>" . $string. "</td></tr></h2>";
                }

                if($attribute->attr_type == 'country'){
                    $name=$id= "attr_{$attribute->attr_id}";
                    $class = 'myselect';
                    $othername=$otherid= "other_{$attribute->attr_id}";
                    $string = $this->_genSelectField( $attribute->attr_id,$name,$country_array,$product_attr_value[$attribute->attr_id], $class);			
                    $ret_string .= "<div><b>Select Country:</b></div><br />";
                    $ret_string .= "<div class='select'>".$string."</div>";
                }
            }
            $ret_string .= "<div id=\"my_div\">";
            for($i=1;$i<=count($product_additional_attr);$i++){
               $ret_string.= '<div id="attr_div' . $i .'">
                                <input type="text" name="title_' . $i .'" id="title_' . $i .'" value="'.$product_additional_attr[$i-1]["attr_name"] .'"/>
                                <input type="text"  name="value_' . $i .'" id="value_' . $i .'" value="'.$product_additional_attr[$i-1]["attr_value"] .'"/>
                            </div>';

            }
            $ret_string .= "</div><input type=\"button\" class=\"add_product_add\" value=\"Add More\" onClick=\"addCustAttr()\">";
            $ret_string .= "<input type=\"button\" class=\"add_product_remove\" name='btn_rem' id='btn_rem' value=\"Remove\" onClick=\"remCustAttr()\">";
            $ret_string .="<br><br>";
            $ret_string .= "<input type='hidden' name='category_id'  value='$category_id'/>";		
        }
        return $ret_string;
    }

    function _genSelectField($attr_id, $name,$options,$value = false, $class){
        $data = array();
        foreach($options as $option){
            $data[$option] = $option;
        }
        return form_dropdown($name,$data,$value,"id='$name' attr_id = '$attr_id' class='$class'  onchange='otherselectbox(this)'");
    } 

    function _genCheckboxField($attr_id,$name,$value, $checked=false){
        $data = array(
                    'name'        => $name,
                    'value'       => $value,
                    'checked'     => $checked,
                    'style'       => 'margin:7px',
                    );

        if ($value == 'other' || $value == 'Other'){
            $data['onclick'] = 'othercheckbox(this)';
            $data['attr_id'] = $attr_id;
        }
        return form_checkbox($data);
    }

    function _genTextboxField($id, $name, $value, $class){
        $data = array(
                    'name'        => $id,
                    'id'          => $id,
                    'maxlength'   => '100',
                    'size'        => '42',
                    'style'       => '',
                    'class'       => $class,
                    'alt'         => $name
                    );

        if ($value) {
            $data['value'] = $value;
        } else {
            $data['value'] = set_value($id);
        }

        return form_input($data);
    }

    function _genRadioboxField($name, $value, $checked=false){
        $data = array(
                    'name'        => $name,
                    'id'          => $name,
                    'value'       => $value,
                    'style'       => 'margin:7px',
                    'checked'     => $checked
                    );
        return form_radio($data);
    }

    function _genTextAreaboxField($name, $id, $value){
        $data = array(
                    'name'        => $name,
                    'id'          => $id,
                    'value'       => set_value($name),
                    'rows'        => '2',
                    'cols'        => '31',
                    'style'       => '',
                    'alt'         => $value
                    );
        return form_textarea($data);
    }

    function _attrs_show($datas){
        $tmp = array();

        foreach($datas as $data) {
            $value = str_replace('|',', ',$data['attr_value']);
            if($data['attr_other_value'])
                $value = str_replace('other',$data['attr_other_value'],$value);
            $tmp[] = array(
                'attr_id'	=> $data['attr_id'],
                'attr_name' => $data['attr_name'],
                'attr_value' => $value
            );
        }

        return $tmp;
    }

    public function _product_validation(){
                $this->load->library('form_validation');
                    $this->form_validation->set_rules('prod_kwd', 'Product Keyword', 'required');
                $this->form_validation->set_rules('prod_name', 'Product Name', 'required');
                $this->form_validation->set_rules('short_desc', 'Short Description', 'required');
                $this->form_validation->set_rules('licence', 'Licence', 'required');

                if ($this->form_validation->run() == FALSE) {
                        return FALSE;
                } else {
                        return TRUE;
                }
    }

    public function _prod_name(){
        if($this->input->post('prod_name') && $this->input->post('prod_name') != 'Product Name *')
            return TRUE;
        $this->form_validation->set_message('Prod_Name', 'Product Name is required.');
            return FALSE;
    }

    public function _prod_kwd(){
        if($this->input->post('prod_kwd') && $this->input->post('prod_kwd') != 'Product Keywords *')
            return TRUE;
        $this->form_validation->set_message('_prod_name_check', 'Product Name is required.');
            return FALSE;
    }

    public function _short_desc(){
        if($this->input->post('short_desc') && $this->input->post('short_desc') != 'Product Keywords *')
            return TRUE;
        $this->form_validation->set_message('_prod_name_check', 'Product Name is required.');
            return FALSE;
    }

    public function _qty(){
        if($this->input->post('qty')){
            if(is_numeric($this->input->post('qty')))
                return TRUE;
                $this->form_validation->set_message('_qty_check', 'qty must be number');
                return FALSE;
        }
        return TRUE;
    }
    public function _cur_prc1(){
        if($this->input->post('cur_prc1')){
            if(is_numeric($this->input->post('cur_prc1')))
                return TRUE;
                $this->form_validation->set_message('_cur_prc1_check', 'cur_prc1 must be number');
                return FALSE;
        }
        return TRUE;
    }
    public function _cur_prc2(){
        if($this->input->post('cur_prc2')){
            if(is_numeric($this->input->post('cur_prc2')))
                return TRUE;
                $this->form_validation->set_message('_cur_prc1_check', 'cur_prc2 must be number');
                return FALSE;
        }
        return TRUE;
    }

    public function _upload_img($oldname,$project_id){
            if(!$oldname)
                return "";

            $res = explode(".",$oldname);
            $name = MD5($project_id).".".$res[1];

            copy('images/product_images/temp/'.$oldname,'images/product_images/'.$name);


            $config = array(
                            'image_library'	=>'gd2',
                            'source_image'	=> 'images/product_images/'.$name,
                            'new_image'	=> 'images/product_thumbs/'.$name,
                            'width'	=>200,
                            'height' =>200
                            );
            $this->load->library('image_lib',$config);
            if ( ! $this->image_lib->resize()){
                echo $this->image_lib->display_errors();
            }

            return $name;
    }

    public function _actioncheck($user_id){
        $user = $this->M_user->getUserById($user_id);
        $this->load->model('M_membership','',True);
        if ($this->M_membership->isSellingLimited($user['membership'],$user['selling_count'])){
            echo "Sorry, you have reached your limitation for selling product as a Free memeber, upgrade now";
            exit;
        }
    }
}

?>