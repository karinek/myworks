<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mobileapi extends CI_Controller {
    
    public function index(){
                
    }

    public function getallcategories(){
            
                $this->load->helper(array('form', 'url'));
                $this->load->model('M_iphone','Mobile',TRUE);
                $categories = $this->Mobile->getCategories(0);
                $data = array();
                foreach($categories as $category)
                {
                    $temp = array();
                    $temp['category_id'] = $category['category_id'];
                    $temp['category_name'] = $category['category_name'];
                    $temp['parent_id'] = $category['parent_id'];
                    $temp['total_products'] = $category['total_products'];
                    if($this->Mobile->isCategoryHasChild($category['category_id']))
                    {
                        $temp['has_subcategory'] = "true";
                    }
                    else
                    {
                         $temp['has_subcategory'] = "false";
                    }
                   
                    array_push($data,$temp);
                    
                }              
           
                echo json_encode($data);
           
            
    }
    
    public function getcategories($category_id = null){
        
            if($category_id != null && is_numeric($category_id))
            {
            
            $this->load->helper(array('form', 'url'));
            $this->load->model('M_iphone','Mobile',TRUE);
            $categories = $this->Mobile->getSubCategories($category_id);
            
            $data = array();
            foreach($categories as $category)
            {
               
             
                $temp = array();
                $temp['category_id'] = $category['category_id'];
                $temp['category_name'] = $category['category_name'];
                $temp['parent_id'] = $category['parent_id'];
                $temp['total_products'] = $category['total_products'];
                if(!$this->Mobile->getSubCategories($category['category_id']))
                {
                    $temp['has_subcategory'] = "true";
                }
                else
                {
                     $temp['has_subcategory'] = "false";
                }
               
                array_push($data,$temp);
                
                
            }              
           
            echo json_encode($data);
            }
            else
            {
                echo json_encode("false");
            }
            
    }

// url:    mobileapi/getproducts?cid=4091&start=0&num=15&membership=gold
    public function getproducts(){
    
        $category_id = $this->input->get('cid');
        $start = $this->input->get('start');
        $num = $this->input->get('num');
        $membership = $this->input->get('membership');
        
        $this->load->helper(array('form', 'url'));
        $this->load->model('M_iphone','Mobile',TRUE);
        $this->load->model('M_ads','',TRUE);
        $data['result'] = $this->Mobile->getProducts($category_id,$start,$num,$membership);
        $data['image'] = $this->M_ads->get();
        echo json_encode($data);
    }
    
    public function getcompany($company_id,$membership=""){
        $this->load->helper(array('form', 'url'));
        $this->load->model('M_iphone','Mobile',TRUE);
        $data = $this->Mobile->getCompany($company_id,$membership);
              
        echo json_encode($data);
        
    }
    public function searchproducts($keyword){
        $this->load->helper(array('form', 'url'));
        $this->load->model('M_iphone','Mobile',TRUE);
        $data = $this->Mobile->searchProducts($keyword);
              
        echo json_encode($data);
    }
    
    public function getallcompany(){
        $this->load->helper(array('form', 'url'));
        $this->load->model('M_iphone','Mobile',TRUE);
        $data = $this->Mobile->getAllCompany();
              
        echo json_encode($data);
    }
    
    public function getallbuyers(){
        $this->load->helper(array('form', 'url'));
        $this->load->model('M_iphone','Mobile',TRUE);
        $data = $this->Mobile->getAllBuyers();
              
        echo json_encode($data);
    }
    
    public function product($id){
        $this->load->helper(array('form', 'url'));
        $this->load->model('M_iphone','Mobile',TRUE);
        $data = $this->Mobile->getProductById($id);
        echo json_encode($data);
    }
    
    public function companyproducts($id){
        $this->load->helper(array('form', 'url'));
        $this->load->model('M_iphone','Mobile',TRUE);
        $data = $this->Mobile->getCompanyProducts($id);
              
        echo json_encode($data);
    }
    
    public function searchcompany($keyword){
        $this->load->helper(array('form', 'url'));
        $this->load->model('M_iphone','Mobile',TRUE);
        $data = $this->Mobile->searchCompany($keyword);
              
        echo json_encode($data);
    }
    
/* url:    mobileapi/register?location=china&firstname=Fir&lastname=Las&company=geegle&phone_country=1
            &phone_area=2&phone_number=3&email=bob@bob.com&password=123445&birth_day=1&birth_month=1&birth_year=2000
            &gender=M&role=both
*/    
    public function register(){
        $this->load->helper('string');
        $data = array(
		'location' => $this->input->get('location'),
		'firstname'	=> $this->input->get('firstname'),
		'lastname'	=> $this->input->get('lastname'),
		'company'	=> $this->input->get('company'),
		'phone_country' => $this->input->get('phone_country'),
		'phone_area' => $this->input->get('phone_area'),
		'phone_number' => $this->input->get('phone_number'),
		'email'	=> $this->input->get('email'),
		'password'	=> MD5($this->input->get('password')),
		'status'	=> "pending",
		'verifycode'	=> random_string('alnum',10),
		'birth_day'	=> $this->input->get('birth_day'),
		'birth_month'	=> $this->input->get('birth_month'),
		'birth_year'	=> $this->input->get('birth_year'),
		'gender'	=> $this->input->get('gender'),
		//'question'	=> $this->input->post('question'),
		//'answer'	=> $this->input->post('answer'),
		'create_date'   => date("Y-m-d H:i:s"),
                'role'          => $this->input->get('role'),
               // 'image' =>  $this->_upload_img($this->input->post('image_name'),$this->input->post('email'))

	    );
        $this->load->model('M_iphone','Mobile',TRUE);
        $res = $this->Mobile->register($data);

        echo json_encode($res);
    }
    
    public function getbusinesstype(){
        $this->load->helper(array('form', 'url'));
        $this->load->model('M_iphone','Mobile',TRUE);
        $data = $this->Mobile->getBusinessType();
              
        echo json_encode($data);
    }
    
    public function getcompanybybusinesstype($type){
        $this->load->helper(array('form', 'url'));
        $this->load->model('M_iphone','Mobile',TRUE);
        $data = $this->Mobile->getCompanyByBusinessType($type);
              
        echo json_encode($data);
    }
    
    public function getcompanybycategory($category_id){
        $this->load->helper(array('form', 'url'));
        $this->load->model('M_iphone','Mobile',TRUE);
        $data = $this->Mobile->getCompanyByCategory($category_id);
              
        echo json_encode($data);
    }
    
 //   search?keyword=o&location=AU&businesstype=&searchtype=buyer&membershiptype=gold&order=asc&start=0&num=15
 //   search?keyword=m&location=AU&businesstype=&searchtype=supplier&membershiptype=&order=desc&start=0&num=15
 //   search?keyword=bob&location=&businesstype=Service&searchtype=product&membershiptype=&order=asc&start=0&num=15
    
    public function search(){
        $this->load->helper(array('form', 'url'));
        $this->load->model('M_iphone','Mobile',TRUE);
         $this->load->model('M_ads','',TRUE);
        
        $keyword = strtolower($this->input->get('keyword'));
        $location = $this->input->get('location');
        $businesstype = $this->input->get('businesstype');
        $searchtype = $this->input->get('searchtype');
        $membershiptype = $this->input->get('membershiptype');
        $order = $this->input->get('order');
        $start = $this->input->get('start');
        $num = $this->input->get('num');
        
        if ($searchtype == 'buyer'){
            $data['result'] = $this->Mobile->searchBuyer($keyword,$location,$businesstype,$membershiptype,$order,$start,$num);
        } else if($searchtype == 'supplier'){
            $data['result'] = $this->Mobile->searchSupplier($keyword,$location,$businesstype,$membershiptype,$order,$start,$num,$searchtype);
        } else if ($searchtype == 'product') {
            $data['result'] = $this->Mobile->searchProduct($keyword,$location,$businesstype,$membershiptype,$order,$start,$num);
        }
        $data['image'] = $this->M_ads->get();
        echo json_encode($data);
               
    }
    
    public function getinboxcount($user_id){
        $this->load->helper(array('form', 'url'));
        $this->load->model('M_iphone','Mobile',TRUE);
        $data = $this->Mobile->getInboxCount($user_id);
              
        echo json_encode($data);
    }
    
    public function getinboxlist($user_id){
        $this->load->model('M_iphone','Mobile',TRUE);
        $data = $this->Mobile->getInboxList($user_id);
        echo json_encode($data);
    }
    
    public function getwatchlist($user_id){
        $this->load->helper(array('form', 'url'));
        $this->load->model('M_iphone','Mobile',TRUE);
        $data = $this->Mobile->getWatchList($user_id);
              
        echo json_encode($data);
    }
    
    public function getbuyingrequestlist($category_id){
        $this->load->model('M_iphone','Mobile',TRUE);
        $data = $this->Mobile->getBuyingRequestList($category_id);
        echo json_encode($data);
    }
    
    public function getbuyingrequest($id){
        $this->load->model('M_iphone','Mobile',TRUE);
        $data = $this->Mobile->getBuyingRequest($id);
        echo json_encode($data);
    }
    
    //   login?email=wanbo@mediamessenger.com.au&password=111111
    public function login(){
        $this->load->model('M_iphone','Mobile',TRUE);
        
        $email = $this->input->get('email');
        $password = $this->input->get('password');
        
        $data = $this->Mobile->login($email,$password);
        echo json_encode($data);
    }
    
    public function getuser($id){
        $this->load->model('M_iphone','Mobile',TRUE);
        $data = $this->Mobile->getUser($id);
        echo json_encode($data);
    }
    
    public function getcompanycontacts($user_id){
        $this->load->model('M_iphone','Mobile',TRUE);
        $data = $this->Mobile->getCompanyContacts($user_id);
        echo json_encode($data);
    }
    
    public function getallcountries(){
        $this->load->model('M_iphone','Mobile',TRUE);
        $data = $this->Mobile->getAllCountries();
        echo json_encode($data);
    }
    
    
//sendmessage?from_uid=85&from_cid=125&to_uid=86&to_cid=126&subject=Test&message=HelloWorld
    public function sendmessage(){
        $from_uid = $this->input->get('from_uid');
        $from_cid = $this->input->get('from_cid');
        $to_uid = $this->input->get('to_uid');
        $to_cid = $this->input->get('to_cid');
        $subject = $this->input->get('subject');
        $message = $this->input->get('message');
        
        $this->load->model('M_iphone','Mobile',TRUE);
        $data = $this->Mobile->sendMessage($from_uid,$from_cid,$to_uid,$to_cid,$subject,$message);
        echo json_encode($data);
    }
}