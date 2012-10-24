<?php
class M_iphone extends CI_Model {
    
    function __construct(){
        
        parent::__construct();
    }

     function getCategories(){
        $this->db->where('parent_id',0);
        $query = $this->db->get('category');
        if ($query->num_rows()>0){
            return $query->result_array();
        }
        return FALSE;
    }
    
    function isCategoryHasChild($category_id){
        $this->db->where('parent_id',$category_id);
        $num_rows = $this->db->count_all_results('category');
        if ($num_rows >= 1){
            return TRUE;
        }
        return FALSE;
    }
    
    function getSubCategories($category_id){        
          $this->db->where('parent_id',$category_id);
          $query = $this->db->get('category');
          if ($query->num_rows()>0){
              return $query->result_array();

          }
          return FALSE;
    }
    
    function getProducts($category_id,$start,$num,$membership = ""){
        $this->db->select('p.*,poa.*,pi.image_name');
        $this->db->join('product_order_attributes poa','p.product_id = poa.product_id','left');
        $this->db->join('product_images pi','p.product_id = pi.product_id','left');
        $this->db->where('p.category_id',$category_id);
        $this->db->select('c.name as company_name,c.membership, c.country');
        $this->db->join('company c','c.id = p.company_id');
        $this->db->limit($num,$start);
        if ($membership){
            $this->db->where('c.membership',$membership);
        }
        $query = $this->db->get('products p');
       
        return $query->result_array();
        
    }
    
    
    function getCompany($company_id,$membership="") {
        $this->db->where('id',$company_id);
        if ($membership){
            $this->db->where('membership',$membership);
        }
        $query = $this->db->get('company');
        return $query->result_array();
    }
    
    
    
    function searchProducts($keyword){
        if (!$keyword)
            return FALSE;
        
        $keyword = strtoupper ($keyword);     
        $sql = "select p.*
                from products p
                where UPPER(p.name) LIKE '%$keyword%'
                OR UPPER(p.keywords) LIKE '%$keyword%'
                ";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function getAllCompany(){
        $this->db->select('id,name,address,city,state,country');
        $query = $this->db->get('company');
        return $query->result_array();
    }
    
    function getAllBuyers(){
        $this->db->select('id,email,firstname,lastname');
        $this->db->where('role','buyer');
        $this->db->or_where('role','both');
        $query = $this->db->get('users');
        return $query->result_array();
    }
    
    function getProductById($productId){
        $this->db->select('p.*,
                        product_images.image_name,
                        poa.*,
                        pav.attr_id,pav.attr_name,pav.attr_value,pav.attr_other_value,
                        c.name as company_name,c.country,c.business_type,c.website,c.email,c.phone,c.website
                        ');
        $this->db->from('products p');
        $this->db->join('product_images', 'p.product_id = product_images.product_id','left');
        $this->db->join('product_order_attributes poa', 'p.product_id = poa.product_id','left');
        $this->db->join('product_attributes_values pav', 'p.product_id = pav.product_id','left');
        $this->db->join('company c','p.company_id = c.id');
        $this->db->where('p.product_id', $productId);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function getCompanyProducts($company_id) {
        $this->db->where('company_id',$company_id);
        $query = $this->db->get('products');
        return $query->result_array();
    }
    
    function searchCompany($keyword){
        if (!$keyword)
            return "";
        $keyword = strtoupper ($keyword);     
            
        $sql = "select * from company 
                where UPPER(name) LIKE '$keyword%'";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function register($data){
        $this->db->insert('users',$data);
        $result['user_id'] = $this->db->insert_id();
        
        $company['name'] = $data['company'];
        $this->db->insert('company',$company);
        $result['company_id'] = $this->db->insert_id();
        return $result;
    }
    
    function getBusinessType(){
        $query = $this->db->get('option_business_type');
        return $query->result_array();
    }
    
    function getCompanyByBusinessType($type) {
        $this->db->where('business_type',$type);
        $query = $this->db->get('company');
        return $query->result_array();
    }
    
    function getCompanyByCategory($category_id) {
        $this->db->select('c.*');
        $this->db->join('company AS c', 'c.id = p.company_id', 'right');
        $this->db->where('p.category_id',$category_id);
        $this->db->distinct();
        $query = $this->db->get('products AS p');
        return $query->result_array();
    }
    
    function searchBuyer($keyword,$location,$businesstype,$membershiptype,$order,$start,$num){
       
        $this->db->select('br.*');
        $this->db->join('company c', 'c.id = br.company_id', 'left');
        $this->db->like('LOWER(product_name)', $keyword);
        $this->db->or_like('LOWER(product_specification)',$keyword);
        
        if($num)
            $this->db->limit($num,$start);
        if($location)
            $this->db->where('c.country',$location);
        if($businesstype)
            $this->db->where('c.business_type',$businesstype);
        if($membershiptype)
            $this->db->where('c.membership',$membershiptype);
        if ($order)
            $this->db->order_by('br.product_name',$order);
            
        $query = $this->db->get('buying_requests AS br');
        return $query->result_array();
    }
    
    function searchSupplier($keyword,$location,$businesstype,$membershiptype,$order,$start,$num,$searchtype){
        $this->db->select('c.*'); 
        $this->db->like('LOWER(c.name)', $keyword);
        
        if($num)
            $this->db->limit($num,$start);
        if($location)
            $this->db->where('c.country',$location);
        if($businesstype)
            $this->db->where('c.business_type',$businesstype);
        if($membershiptype)
            $this->db->where('c.membership',$membershiptype);
//        if($searchtype == 'accessed')
//          $this->db-where('','');  
        if ($order)
            $this->db->order_by('c.name',$order);
        $query = $this->db->get('company c');
        return $query->result_array();
    }
    
    function searchProduct($keyword,$location,$businesstype,$membershiptype,$order,$start,$num){
        $this->db->select('p.*,poa.*,pi.image_name,c.name as company_name,c.membership, c.country');
        $this->db->join('product_order_attributes poa','p.product_id = poa.product_id','left');
        $this->db->join('product_images pi','p.product_id = pi.product_id','left');
        $this->db->join('company c','c.id = p.company_id');
        $this->db->like('LOWER(p.name)', $keyword);
        
        if($num)
            $this->db->limit($num,$start);
        if($location)
            $this->db->where('c.country',$location);
        if($businesstype)
            $this->db->where('c.business_type',$businesstype);
        if($membershiptype)
            $this->db->where('c.membership',$membershiptype);
        if ($order)
            $this->db->order_by('p.name',$order);
        $query = $this->db->get('products p');
        return $query->result_array();
    }
    
    function getInboxCount($user_id) {
        $getInboxcount = $this->db->select('*')
                ->from('message')
                ->join('message_from_to', 'message_from_to.id = message.message_id')
                ->join('message_trash', 'message_trash.message_id = message.id')
                ->where('message_trash.user_id', $user_id)
                ->where('message_from_to.to_user_id', $user_id)
                ->where('message_trash.trash !=', 1)
                ->get();
        return $getInboxcount->num_rows();
    }
    
    function getInboxList($user_id) {
        $getInboxcount = $this->db->select('m.*,mft.*,mt.*,u.firstname,u.lastname,u.image,u.email,c.name as company_name')
                ->from('message m')
                ->join('message_from_to mft', 'mft.id = m.message_id')
                ->join('message_trash mt', 'mt.message_id = m.id')
                ->join('users u',"mft.from_user_id = u.id")
                ->join('company c',"mft.from_company_id = c.id")
                ->where('mt.user_id', $user_id)
                ->where('mft.to_user_id', $user_id)
                ->where('mt.trash !=',1)
                ->get();
        return $getInboxcount->result_array();
    }
    
    function getWatchList($user_id){
        $this->db->where('user_id', $user_id);
        $this->db->join('products AS p', 'p.product_id = uw.product_id', 'inner');
        $this->db->join('company c','p.company_id = c.id');
        $this->db->join('product_images AS pi', 'pi.product_id = uw.product_id', 'left');
        $this->db->select('p.name as product_name,p.product_id, c.id as company_id, pi.image_name, c.name as company_name, c.email,c.membership');
        $query = $this->db->get('users_watchlist AS uw');
        return $query->result_array();
    }
    
    function getBuyingRequestList($category_id){
        $this->db->where('category_id',$category_id);
        $query = $this->db->get('buying_requests');
        return $query->result_array();
    }
    
    function getBuyingRequest($id){
        $this->db->where('id',$id);
        $query = $this->db->get('buying_requests');
        return $query->result_array();
    }
    
    function login($email,$password){
        $this->db->where('email',$email);
        $this->db->where('password',MD5($password));
        $query = $this->db->get('users');
        
        if ($query->num_rows()==1){
            return $query->result_array();
        }
        return array("error"    =>  "Wrong Email or Password");
    }
    
    function getUser($id){
        $this->db->select('u.*,
                          c.name,c.business_type,c.email as company_email,c.website,c.country,c.address,c.city,c.state,c.membership');
        $this->db->where('u.id',$id);
        $this->db->join('user_company uc','uc.user_id = u.id');
        $this->db->join('company c','c.id = uc.company_id');
        $query = $this->db->get('users u');
        if ($query->num_rows()==1){
            return $query->result_array();
        }
    }
    
    function getCompanyContacts($user_id){
        $this->db->select('c.id as company_id,c.name,u.id as user_id,u.firstname,u.lastname,u.image');
        $this->db->join('company c','c.id = ucc.company_id');
        $this->db->join('user_company uc','uc.company_id = ucc.company_id');
        $this->db->join('users u','uc.user_id=u.id');
        $this->db->where('ucc.user_id', $user_id);
        $query = $this->db->get('user_contact_company ucc');
        return $query->result_array();
    }
    
    function getAllCountries(){
        $query = $this->db->get('country');
        return $query->result_array();
    }
 
    function sendMessage($from_uid,$from_cid,$to_uid,$to_cid,$subject,$message){
        
        $data = array(
            'from_user_id'  =>  $from_uid,
            'from_company_id'   =>  $from_cid,
            'to_user_id'    =>$to_uid,
            'to_company_id' =>  $to_cid
        );
        
        $this->db->insert('message_from_to',$data);
        $id = $this->db->insert_id(); 
        
        
        $data = array(
            'message_id'  =>  $id,
            'date'   =>   date('Y-m-d'),
            'subject'    =>$subject,
            'text' =>  $message
        );
        
        $this->db->insert('message',$data);
        $mes_id = $this->db->insert_id(); 
        
        $data = array(
            'message_id'  =>  $mes_id,
            'user_id'   =>   $from_uid,
            'star'    =>0
        );
        $this->db->insert('message_starred',$data);
     
        $data = array(
            'message_id'  =>  $mes_id,
            'user_id'   =>   $to_uid,
            'star'    =>0
        );
        $this->db->insert('message_starred',$data);
     
        $data = array(
            'message_id'  =>  $mes_id,
            'user_id'   =>   $from_uid,
            'trash'    =>0
        );
        $this->db->insert('message_trash',$data);
     
        $data = array(
            'message_id'  =>  $mes_id,
            'user_id'   =>   $to_uid,
            'trash'    =>0
        );
        $this->db->insert('message_trash',$data); 
        return array("status"   => "success");     
    }
}
?>