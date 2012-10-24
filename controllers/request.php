<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Request extends CI_Controller {
    
function __construct(){
    parent::__construct();

    $this->load->helper(array('form','url','html'));
    $this->load->library('session');
    $this->load->model('m_session','',True);
    $this->load->model('M_company','',True);
    $this->load->model('M_country','',True);
    $this->load->model('M_category','',True);
    $this->load->model('M_user','',True);
    $this->load->model('M_request','',True);
	$this->load->model('M_encrypt');
} 

public function index() {
    $user_id = $this->m_session->getUserID();
    if(isset($user_id)):
        $data['user'] = $this->M_user->getUserById($user_id);
        $data['categories'] = $this->M_category->getSubCategory(0);
         
        $company = $this->M_company->getCompanyByUser($user_id);
        $template = $this->_init();
        $template['user'] = $this->M_user->getUserById($user_id);
        $template['company'] = (array)$company[0];
        
        if ($data['user']['role'] == 'seller')
            $template['content'] = $this->load->view('modules/request/confirm_role', $data, true);
        else
            $template['content'] = $this->load->view('modules/request/category-select',$data,true);

        $template['modules'] = array(
                'login' => 1,
                'top-menu' => 1
        );
        $template['layout'] = 'company';
        $this->load->view('template', $template);
        
        
    else:
        redirect('login');
    endif;
}    
function confirm_buyer_request() {
    $user_id = $this->m_session->getUserID();
    $this->M_user->changeRole($user_id, 'both');
    
    redirect('request');
}    
public function buy(){
    if (!$this->input->post('category_id'))
        redirect('request');
        $user_id = $this->m_session->getUserID();
        if(isset($user_id)):
            $this->load->model('M_product','',TRUE);
            $this->load->model('m_options','',True);
            $this->_actioncheck($user_id);
            $data['user'] = $this->M_user->getUserById($user_id);
            $data['categories'] = $this->M_category->getSubCategory(0);
            $data['category_id'] = $this->input->post('category_id');
            $data['catdisplay'] = $this->input->post('catdisplay');
            $data['buyingUnits']=$this->M_product->getUnitOptions();
            $data['supplierLocation'] = m_options::getLocations();
            $data['shippingTerms'] = m_options::getShippingTerms();
            $data['currency'] = m_options::getCurrencies();
            $data['paymentTerms'] = m_options::getPaymentTerms();

            $company = $this->M_company->getCompanyByUser($user_id);
            $template = $this->_init();
            $data['country_options'] = $this->M_country->getAllCountryOptions();
            $data['business_type_options'] = $template['business_type_options'];
            $template['user'] = $this->M_user->getUserById($user_id);
            $template['company'] = (array)$company[0];
            $template['content'] = $this->load->view('modules/request/buy',$data,true);

            $template['modules'] = array(
                    'login' => 1,
                    'top-menu' => 1
            );
            $template['layout'] = 'company';
            $this->load->view('template', $template);
        
        
        else:
            redirect('login');
        endif;
}

public function preview() {
    $post = $this->input->post();
    $user_id = $this->m_session->getUserID();
    
    if(!$this->_validation()) {
	    $this->buy();
    } else {
	$company = $this->M_company->getCompanyByUser($user_id);
        $data = array(
	    'company_id'	=>	$company[0]->id,
	    'category_id'	=>	$this->input->post('category_id'),
	    'product_name'	=>	$this->input->post('product_name'),
	    'product_specification'	=>	$this->input->post('product_specification'),
	    'order_quantity'	=>	$this->input->post('order_quantity'),
	    'order_quantity_unit'	=>	$this->input->post('order_quantity_unit'),
	    'purchase_volume'	=>	$this->input->post('purchase_volume'),
	    'purchase_volume_unit'	=>	$this->input->post('purchase_volume_unit'),
	    'expired_time'	=>	$this->input->post('expired_time'),
	    'represent_company'	=>	$this->input->post('represent_company'),
	    'business_type1'	=>	$this->input->post('business_type1'),
	    'website'	=>	$this->input->post('website'),
	    'tel1'	=>$this->input->post('tel1'),
            'tel2'	=>$this->input->post('tel2'),
            'tel3'	=>$this->input->post('tel3'),
            'supplier_location' => $this->input->post('supplier_location'),
            'shipping_terms' => $this->input->post('shipping_terms'),
            'preferred_unit_price' => $this->input->post('unit_price'),
            'currency' => $this->input->post('currency'),
            'destination_port' => $this->input->post('destination_port'),
            'payment_terms' => $this->input->post('payment_terms'),
            'accept_terms' => $this->input->post('accept_terms'),
            'unit_price' => $this->input->post('unit_price'),
            'catdisplay' => $this->input->post('catdisplay'),
            'product_description' => $this->input->post('product_specification'),
	    'image_name'	=>	$this->_upload_img($this->input->post('image_name'))
        );
       
       $this->load->library('upload');
       $config = array(
	        'upload_path'   =>  realpath(APPPATH . '../files/request'),
	        'allowed_types' =>  'doc|txt|pdf|xls|docx|xlsx',
	        'file_name' =>  time()
	    );
        $this->upload->initialize($config);
        if ($this->upload->do_upload('product_file')){
            $upload_data = $this->upload->data();
	    $data['file'] = $upload_data['file_name'];
        }
        
        $template['modules'] = array(
                'login' => 1,
                'top-menu' => 1
        );
        $template['layout'] = 'company';
        $result['request'] = $data;
        $template['content'] = $this->load->view('modules/request/preview',$result,true);
        $this->load->view('template', $template);
    }
}

public function view($id) {
	    $id = $this->M_encrypt->decode($id);
		if(!is_numeric($id)){
			show_404();
		}
        $data['request'] = $this->M_request->getRequestByID($id);
        $data['request'] = $data['request'][0];
        $data['request']->catdisplay = $this->M_category->getCategory($data['request']->category_id);
        $data['request']->catdisplay = $data['request']->catdisplay->category_name;
        $template = $this->_init();
        $template['content'] = $this->load->view('modules/request/view',$data,true);

        $template['modules'] = array(
                'login' => 1,
                'top-menu' => 1
        );
        $template['layout'] = 'company';
        $this->load->view('template', $template);
        

}

public function manage() {
    $user_id = $this->m_session->getUserID();
    $company_id = $this->M_user->getCompanyByUser($user_id);
	
    if($this->input->post('buyingRequests')){
            $buyingRequests = $this->input->post('buyingRequests');
            foreach($buyingRequests as $buyingRequest){
                    $this->M_request->delete_request($buyingRequest);
            }
    }
    $order = ($this->input->get_post('order'))?$this->input->get_post('order'):'';
    $page = $this->input->get_post('page')?$this->input->get_post('page'):1;

    $this->M_company->req_page = $page;
    $res = $this->M_request->get_request($company_id, $order, true);
    $data['default'] = array(
                    'order'=>$order,
                    'page'=>$page,
    );
    $data['pagination'] = $res['pagination'];
    $data['pagination']['cur'] = $page;
    $data['buyingRequests'] = $res['result'];
    
    $template = $this->_init();
    $template['content'] = $this->load->view('modules/request/manage',$data,true);
    $template['modules'] = array(
        'login' => 1,
        'top-menu' => 1
    );
    $template['layout'] = 'company';
    $this->load->view('template', $template);
}

public function _init(){
    $template['categories'] = $this->M_category->getSubCategory(0);
    $template['business_type_options'] = $this->M_company->getAllBusinessType();
    $template['countries'] = $this->M_country->getAllCountryName();
    return $template;
}

public function postBuyRequest(){
    $post = $this->input->post();
    $user_id = $this->m_session->getUserID();
    
    if(!$this->_validation()) {
	    $this->buy();
    } else {
	$company = $this->M_company->getCompanyByUser($user_id);
        $data = array(
	    'company_id'	=>	$company[0]->id,
	    'category_id'	=>	$this->input->post('category_id'),
	    'product_name'	=>	$this->input->post('product_name'),
	    'product_specification'	=>	$this->input->post('product_specification'),
	    'order_quantity'	=>	$this->input->post('order_quantity'),
	    'order_quantity_unit'	=>	$this->input->post('order_quantity_unit'),
	    'purchase_volume'	=>	$this->input->post('purchase_volume'),
	    'purchase_volume_unit'	=>	$this->input->post('purchase_volume_unit'),
	    'expired_time'	=>	$this->input->post('expired_time'),
	    'represent_company'	=>	$this->input->post('represent_company'),
	    'business_type'	=>	$this->input->post('business_type1'),
	    'website'	=>	$this->input->post('website'),
	    'tel'	=>$this->input->post('tel1')."-".$this->input->post('tel2')."-".$this->input->post('tel3'),
            'supplier_location' => $this->input->post('supplier_location'),
            'shipping_terms' => $this->input->post('shipping_terms'),
            'preferred_unit_price' => $this->input->post('unit_price'),
            'currency' => $this->input->post('currency'),
            'destination_port' => $this->input->post('destination_port'),
            'payment_terms' => $this->input->post('payment_terms'),
            'product_description' => $this->input->post('product_specification'),
            'image'	=>	$this->_upload_img($this->input->post('image_name'))
        );
       
	   $this->load->library('upload');
           $config = array(
	        'upload_path'   =>  realpath(APPPATH . '../files/request'),
	        'allowed_types' =>  'doc|txt|pdf|xls|docx|xlsx',
	        'file_name' =>  time()
	    );
        $this->upload->initialize($config);
        if ($this->upload->do_upload('product_file')){
            $upload_data = $this->upload->data();
	    $data['file'] = $upload_data['file_name'];
        }
        $this->M_request->insert_request($data);
	
	$user = $this->M_user->getUserById($user_id);
	$this->M_user->update($user_id,array('buying_count' => $user['buying_count'] + 1));
	
        redirect('request/manage');
    }
}

public function _validation(){
    $this->load->library('form_validation');
    $this->form_validation->set_rules('product_name', 'Product Name', 'required');
    $this->form_validation->set_rules('category_id', 'Category', 'required');
    $this->form_validation->set_rules('product_specification', 'Details and Description', 'required');
    $this->form_validation->set_rules('order_quantity', 'Order Quantity', 'required');
    $this->form_validation->set_rules('order_quantity_unit', 'Order Quantity Unit', 'required');
    $this->form_validation->set_rules('expired_time', 'Expired Time', 'required');
    $this->form_validation->set_rules('represent_company', 'Represent Company', 'required');
    $this->form_validation->set_rules('business_type1', 'Business Type', 'required');
    $this->form_validation->set_rules('accept_terms', 'Terms and Conditions', 'required');
    $this->form_validation->set_error_delimiters('<span class="error" style="color:red;">', '</span>');


    if ($this->form_validation->run() == FALSE) {
            return FALSE;
    } else {
            return TRUE;
    }
    
}

public function _checkBusinessType() {
    if($this->input->post('business_type1') && $this->input->post('business_type1') != '')
        return TRUE;
    $this->form_validation->set_message('_address_check', 'Business Type is required.');
    return FALSE;
}

public function img_preview(){
    $config = array(
	'upload_path'   =>  realpath(APPPATH . '../files/request/images/temp'),
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



public function _upload_img($name){
    if(!$name)
	return "";
	
    copy('files/request/images/temp/'.$name,'files/request/images/'.$name);
	
    $config = array(
		'image_library'	=>'gd2',
		'source_image'	=> 'files/request/images/'.$name,
		'new_image'	=> 'files/request/thumbs/'.$name,
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
    $this->load->model('M_user','',TRUE);
    $user = $this->M_user->getUserById($user_id);
    $this->load->model('M_membership','',True);
    if ($this->M_membership->isBuyingLimited($user['membership'],$user['buying_count'])){
        echo "Sorry, you have reached your limitation for buying request as a Free memeber, upgrade now";
        exit;
    }
}

}

?>