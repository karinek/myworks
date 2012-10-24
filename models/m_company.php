<?php
class M_company extends CI_Model {
    
    var $fav_page = 1;
    var $fav_num = 6;
    var $cont_page = 1;
    var $cont_num = 10;
    var $net_page = 1;
    var $net_num = 6;
    
    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }

    function getCompanyById ($company_id){
        $this->db->where('id',$company_id);
        $query = $this->db->get('company');
        if ($query->num_rows()==1){
            return $query->row_array();
        }   
        return false;
    }
    
    function getProductByCompany($company_id) {
        $this->db->join('product_images', 'product_images.product_id = products.product_id');
        $this->db->where('company_id',$company_id);
        $query = $this->db->get('products');
        return $query->result_array();
    }
    
    function getProductByCompanyWithPaging($company_id,$page=1,$limit_per_page=10,$name='',$arrange_by=0) {
    	
    	$this->db->select('COUNT(*) AS num_row');
    	$this->db->join('product_images', 'product_images.product_id = products.product_id','left');
    	$this->db->join('product_order_attributes', 'products.product_id = product_order_attributes.product_id','left');
    	$this->db->where('products.company_id',$company_id);
    	$res = $this->db->get('products');
    	$total_rows = $res->result();
    	if(is_array($total_rows) && count($total_rows)){
    		$total_rows = $total_rows[0]->num_row;
    	}else{
    		$total_rows = 0;
    	}    	

    	
    	$this->db->select('products.*, product_order_attributes.*, product_images.*');
    	$this->db->join('product_images', 'product_images.product_id = products.product_id','left');
    	$this->db->join('product_order_attributes', 'products.product_id = product_order_attributes.product_id','left');
    	$this->db->where('products.company_id',$company_id);    	
    	$this->db->like("name",$name);
    	switch($arrange_by){
    		case 1:
    			$this->db->order_by("products.name", "asc");
    			break;
    		case 2:
    			$this->db->order_by("products.name", "desc");
    			break;
    	}
    
    	$this->db->limit($limit_per_page,($page-1) * $limit_per_page);
    
    	$query = $this->db->get('products');
    	$res= $query->result_array();
    	return array('pagination'=>array('rows'=>$total_rows,'page'=>ceil($total_rows/$limit_per_page)),'result'=>$res);
    }    
    
	function getProductByCompanyAndCategoryWithPaging($company_id,$category_id,$limit_ofsset=0,$limit_per_page=10,$name='',$arrange_by=0) {
	
	
	
	
		
		/*$results = array();
           
        $sql="SELECT p.* FROM `products` p
			  LEFT JOIN product_images pi ON pi.product_id = p.product_id
			  WHERE p.name like '%".mysql_escape_string($company_id)."%' AND
			  p.company_id='$company_id' and
			  p.category_id='$category_id'
			  limit $limit_ofsset,$limit_per_page";
 			echo $sql;exit;	
              $query =$this->db->query($sql);
			  $results=$query->result_array();

           
            return $results;
	*/
	
	
	
		//echo $limit_ofsset;exit;
        $this->db->select('products.*, product_order_attributes.*, product_images.*');    
        $this->db->join('product_images', 'product_images.product_id = products.product_id','left');
        $this->db->join('product_order_attributes', 'products.product_id = product_order_attributes.product_id','left');
        //$this->db->join('product_attributes_values', 'products.product_id = product_attributes_values.product_id','left');
        $this->db->where('products.company_id',$company_id);
		$this->db->where('products.category_id',$category_id);
		$this->db->like("name",$name);
		switch($arrange_by){
			case 1:
				$this->db->order_by("products.name", "asc");
				break;
			case 2:
				$this->db->order_by("products.name", "desc");
				break;
		}
		

		$this->db->limit($limit_per_page,$limit_ofsset);
        $query = $this->db->get('products');
        $res= $query->result_array();
		
		return $res;
    }
    
	function getProductByCompanyAndCategoryCount($company_id,$category_id,$name='') {
	
	
	
	
		
		
           
        $sql="SELECT count(*) as cnt FROM `products` p
			  LEFT JOIN product_images pi ON pi.product_id = p.product_id
			  WHERE p.`name` like '%".mysql_escape_string($name)."%' AND
			  p.company_id='$company_id' and
			  p.category_id='$category_id'";
 			  
              $query =$this->db->query($sql);
			  $results=$query->row_array();

           error_log($results['cnt']);
            return $results['cnt'];

    }
	
	
    function updateContactById($id,$data) {
        $this->db->where('id',$id);
        $this->db->update('company_contact', $data);
    }
    
    function insertContact($data) {
        if($this->db->insert('company_contact',$data))
            return $this->db->insert_id();
        return FALSE;
    }
    
    function update($id,$data) {
        $this->db->where('id',$id);
        return $this->db->update('company', $data);
    }
    
    function insertCompany($data) {
        $this->load->model('M_session','',True);
        $user_id = $this->M_session->getUserID();
        if($this->db->insert('company',$data)){
            $company_id = $this->db->insert_id();
            $this->db->where('id', $user_id);
            $this->db->set('company_id', $company_id);
            $this->db->update('users');
            return $company_id;
        }
        return FALSE;
    }
    
    function getAll(){
        $query = $this->db->get('company');
        return $query->result_array();
    }
    
    function search($keyword) {
        if (!$keyword)
            return $this->getAll();
        $keyword = strtoupper ($keyword);     
            
        $sql = "select * from company 
                where UPPER(name) LIKE '%$keyword%'
                OR UPPER(address) LIKE '%$keyword%'
                OR UPPER(city) LIKE '%$keyword%'";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function getAllBusinessType(){
        $query = $this->db->get('option_business_type');
        $res = $query->result_array();
        $data = array(""=>"All Busuness Type");
        foreach($res as $val){
            $data[$val['name']] = $val['name'];
        }
        return $data;
        
    }
    
    function getAllCertification(){
        $query = $this->db->get('option_certification');
        return $query->result_array();
    }
    
    function getAllRegion(){
        $query = $this->db->get('option_region');
        return $query->result_array();
    }
    
    function getAllService(){
        $query = $this->db->get('option_company_service');
        return $query->result_array();
    }
    
    function addToFavourite($user_id = 0, $company_id = 0){
        if($user_id && $company_id){
            $this->db->select('COUNT(*) as ct');
            $this->db->where('user_id', $user_id);
            $this->db->where('company_id', $company_id);
            $query = $this->db->get('user_favourite_company');
            if($query->row()->ct == 0){
                $data['user_id'] = $user_id;
                $data['company_id'] = $company_id;
                $data['isMyFavourite'] = 1;
                if($this->db->insert('user_favourite_company', $data));
            } else {
                $data['user_id'] = $user_id;
                $data['company_id'] = $company_id;
                $this->db->set('isMyFavourite', 1);
                $this->db->update('user_favourite_company');
            }
            return true;
        }
    }
    
    function addToContact($user_id = 0, $company_id = 0){
        if($user_id && $company_id){
            $this->db->select('COUNT(*) as ct');
            $this->db->where('user_id', $user_id);
            $this->db->where('company_id', $company_id);
            $query = $this->db->get('user_contact_company');
            if($query->row()->ct == 0){
                $data['user_id'] = $user_id;
                $data['company_id'] = $company_id;
                $data['isMyContact'] = 1;
                if($this->db->insert('user_contact_company', $data));
            } else {
                $data['user_id'] = $user_id;
                $data['company_id'] = $company_id;
                $this->db->set('isMyContact', 1);
                $this->db->update('user_contact_company');
            }
        }
        return true;
    }
    
    function addToNetwork($user_id = 0, $company_id = 0){
        if($user_id && $company_id){
            $this->db->select('COUNT(*) as ct');
            $this->db->where('user_id', $user_id);
            $this->db->where('company_id', $company_id);
            $query = $this->db->get('user_network_company');
            if($query->row()->ct == 0){
                $data['user_id'] = $user_id;
                $data['company_id'] = $company_id;
                $data['isMyNetwork'] = 1;
                if($this->db->insert('user_network_company', $data));
            } else {
                $data['user_id'] = $user_id;
                $data['company_id'] = $company_id;
                $this->db->set('isMyNetwork', 1);
                $this->db->update('user_network_company');
            }
        }
        return true;
    }
    
    function getFavouriteCompanies($user_id = 0, $order = '', $page = false){
        if($page){
                $this->db->where('f.user_id',intval($user_id));
                $this->db->join('user_favourite_company AS f','c.id=f.company_id','inner');
                $this->db->select('count(*) as num_row');
                $res = $this->db->get('company AS c');
                $total_rows = $res->result();
                if(is_array($total_rows) && count($total_rows)){
                        $total_rows = $total_rows[0]->num_row;
                }else{
                        $total_rows = 0;
                }
                $start = ($this->fav_page - 1) * $this->fav_num;
                $this->db->limit($this->fav_num, $start);
                $this->fav_page = 1;
        }
        $this->db->where('f.user_id',intval($user_id));
        if($order != '')
                $this->db->order_by("c.name", strtoupper($order));
        $this->db->join('user_favourite_company AS f','c.id=f.company_id','inner');
        $this->db->select('c.*');
        $res = $this->db->get('company AS c');
	
        if($page) return array('pagination'=>array('rows'=>$total_rows,'page'=>ceil($total_rows/$this->fav_num)),'result'=>$res->result_array());
		else return $res->result_array();
    }
    
    function getContactCompanies($user_id = 0, $order = '', $page = false){
        $result = array();
        $result['staff'] = array();
        if($page){
                $this->db->where('ucc.user_id',intval($user_id));
                $this->db->join('user_contact_company AS ucc','c.id=ucc.company_id','inner');
                $this->db->join('user_company AS uc','c.id=uc.company_id','inner');
                $this->db->join('users AS u','uc.user_id=u.id','inner');
                $this->db->select('COUNT(*) AS num_row');
                $res = $this->db->get('company AS c');
                $total_rows = $res->result();
                if(is_array($total_rows) && count($total_rows)){
                        $total_rows = $total_rows[0]->num_row;
                }else{
                        $total_rows = 0;
                }
                $start = ($this->cont_page - 1) * $this->cont_num;
                $this->db->limit($this->cont_num, $start);
                $this->cont_page = 1;
        }
        
        $this->db->where('ucc.user_id',intval($user_id));
        if($order != '')
                $this->db->order_by("c.name", strtoupper($order));
        $this->db->join('user_contact_company AS ucc','c.id=ucc.company_id','inner');
        $this->db->join('user_company AS uc','c.id=uc.company_id','inner');
        $this->db->join('users AS u','uc.user_id=u.id','inner');
        $this->db->select('c.*, u.firstname AS userFirstname, u.lastname AS userLastname, u.image AS userImage');
        $query = $this->db->get('company AS c');
        
        $result['contacts'] = $query->result_array();
        if(count($result['contacts'])){
            $contact_company_ids = array();
            foreach($result['contacts'] as $contact_company){
                $contact_company_ids[] = $contact_company['id'];
            }
            $result['staff'] = $this->_getStafflistByCompanyIds($contact_company_ids);
        }
        if($page)
            $result['pagination'] = array('rows'=>$total_rows,'page'=>ceil($total_rows/$this->cont_num));
        
        return $result;
    }
    
    function getNetworkCompanies($user_id = 0, $order = '', $page = false, $with_staff = true){
        $result = array();
        $result['staff'] = array();
        if($page){
                $this->db->where('unc.user_id',intval($user_id));
                $this->db->join('user_network_company AS unc','c.id=unc.company_id','inner');
                $this->db->join('user_company AS uc','c.id=uc.company_id','inner');
                $this->db->join('users AS u','uc.user_id=u.id','inner');
                $this->db->select('COUNT(*) AS num_row');
                $res = $this->db->get('company AS c');
                $total_rows = $res->result();
                if(is_array($total_rows) && count($total_rows)){
                        $total_rows = $total_rows[0]->num_row;
                }else{
                        $total_rows = 0;
                }
                $start = ($this->net_page - 1) * $this->net_num;
                $this->db->limit($this->net_num, $start);
                $this->net_page = 1;
        }
        
        $this->db->where('unc.user_id',intval($user_id));
        if($order != '')
                $this->db->order_by("c.name", strtoupper($order));
        $this->db->join('user_network_company AS unc','c.id=unc.company_id','inner');
        $this->db->join('user_company AS uc','c.id=uc.company_id','inner');
        $this->db->join('users AS u','uc.user_id=u.id','inner');
        $this->db->select('c.*, u.firstname AS userFirstname, u.lastname AS userLastname, u.image AS userImage');
        $res = $this->db->get('company AS c');
        
        $result['networks'] = $res->result_array();
        
        if($with_staff){
            if(count($result['networks'])){
                $network_company_ids = array();
                foreach($result['networks'] as $network){
                    $network_company_ids[] = $network['id'];
                }
                $result['staff'] = $this->_getStafflistByCompanyIds($network_company_ids);
            }
        }
        
        if($page)
            $result['pagination'] = array('rows'=>$total_rows,'page'=>ceil($total_rows/$this->net_num));
        
        return $result;
    }
    
    function _getStafflistByCompanyIds($ids = array()){
        $staffList = array();
        $this->db->where_in('cc.company_id', $ids);
        $this->db->select('cc.company_id, cc.position, cc.firstname AS contactFirstname, cc.lastname AS contactLastname, cc.image,');
        $query = $this->db->get('company_contact AS cc');
        $employees = $query->result_array();
        if(count($employees)){
            foreach($employees as $employee){
                $staffList[$employee['company_id']]['name'] = $employee['contactFirstname']."\t".$employee['contactLastname'];
                $staffList[$employee['company_id']]['image'] = $employee['image'];
                $staffList[$employee['company_id']]['position'] = $employee['position'];
            }
        }
        return $staffList;
    }
    
    function favouriteDelete($company_id,$user_id){
        if(intval($company_id)==0 || intval($user_id)==0) return false;

        $this->db->where('company_id',intval($company_id));
        $this->db->where('user_id',intval($user_id));

        if($this->db->delete('user_favourite_company')) {
            return true;
        } else {
            return false;
        }
    }
    
    function contactDelete($company_id,$user_id){
        if(intval($company_id)==0 || intval($user_id)==0) return false;

        $this->db->where('company_id',intval($company_id));
        $this->db->where('user_id',intval($user_id));

        if($this->db->delete('user_contact_company')) {
            return true;
        } else {
            return false;
        }
    }
    
    function networkDelete($company_id,$user_id){
        if(intval($company_id)==0 || intval($user_id)==0) return false;

        $this->db->where('company_id',intval($company_id));
        $this->db->where('user_id',intval($user_id));

        if($this->db->delete('user_network_company')) {
            return true;
        } else {
            return false;
        }
    }
        
    function getCompanyByUser($uid){
            $this->db->where('uc.user_id',intval($uid));
            $this->db->join('user_company AS uc','c.id=uc.company_id','inner');
            $this->db->select('c.*');
            $res = $this->db->get('company AS c',1);
            return $res->result();
    }
	
	var $staff_page = 1;
	var $staff_num = 12;
	
	function getDefaultContact($cid=0){
		$this->db->where('company_id',intval($cid));
		$res = $this->db->get('company_contact cc');
		if(!$res->num_rows()){
			return false;
		}
		$rows = $res->result();
		return $rows;
	}
	
    function staffList($cid, $sid=0, $order = '', $page=false){
		if(intval($cid) == 0) return false;
		
		if($page){
			if(intval($sid) != 0) $this->db->where('id',intval($sid));
			$this->db->where('company_id',intval($cid));
			$this->db->where('is_deleted',0);
			$this->db->select('count(*) as num_row');
			$res = $this->db->get('company_contact');
			$total_rows = $res->result();
			
			if(is_array($total_rows) && count($total_rows)){
				$total_rows = $total_rows[0]->num_row;
			}

			$start = ($this->staff_page - 1) * $this->staff_num;

			$this->db->limit($this->staff_num, $start);
			
			$this->staff_page = 1;
		}

		if(intval($sid) != 0) $this->db->where('id',intval($sid));
		$this->db->where('company_id',intval($cid));
		$this->db->where('is_deleted',0);

		if($order != '')
			$this->db->order_by("firstname", strtoupper($order));
		$res = $this->db->get('company_contact');
	
		if($page) return array('pagination'=>array('rows'=>$total_rows,'page'=>ceil($total_rows/$this->staff_num)),'result'=>$res->result());
		else return $res->result();
    }
	
	function staffSave($params){
		if(isset($params['id']) && intval($params['id'])!=0){
			$params['mdate'] = M_misc::getTimestamp();
			$this->db->where('id',$params['id']);
			if(isset($params['company_id']) && intval($params['company_id'])!=0)$this->db->where('company_id',$params['company_id']);
			$this->db->update('company_contact',$params);
			
			return $this->db->affected_rows() ? true : false;
		}else{
			$params['cdate'] = $params['mdate'] = M_misc::getTimestamp();
			$this->db->insert('company_contact',$params);
			return $this->db->insert_id();
		}
	}
	
	function staffDelete($cid=0, $sid=0){
		if(intval($sid)==0 || intval($cid)==0) return false;

		$this->db->where('id',intval($sid));
		$this->db->where('company_id',intval($cid));

		$this->db->set('is_deleted',1);

		$this->db->update('company_contact');

		return $this->db->affected_rows() ? true : false;
	}
	
	function staffSetDefault($params){
		$staffs = $this->staffList($params['company_id'],$params['id']);
		if(count($staffs) && is_array($staffs)){
			$this->db->where('company_id',intval($params['company_id']));
			$this->db->set('is_default',0);
			$this->db->update('company_contact');

			$this->db->where('id',intval($params['id']));
			$this->db->where('company_id',intval($params['company_id']));
			$this->db->set('is_default',1);
			$this->db->update('company_contact');

			return $this->db->affected_rows() ? true : false;
		}
	}
        
       function getProductByCompanyAndCategory($cid, $cat_id){
            $this->db->join('product_images', 'product_images.product_id = products.product_id');
            $this->db->where('category_id', $cat_id);
            $this->db->where('company_id', $cid);
            $res = $this->db->get('products');
            return $res->result_array();
        }
        function getCompanyCategories($cid){
            $this->db->select('category.category_id');
            $this->db->select('category.category_name');
            $this->db->select('products.company_id');
            $this->db->select('product_images.image_name');
            $this->db->from('products');
            $this->db->join('category', 'category.category_id = products.category_id');
            $this->db->join('product_images', 'product_images.product_id = products.product_id');
            $this->db->join('company', 'company.id = products.company_id');
            $this->db->where('company.id', $cid);
            $this->db->group_by("category.category_name"); 
            $res = $this->db->get();
//            echo $this->db->last_query();exit;
            return $res->result_array();
        }
        
}
?>