<?php
class M_search extends CI_Model {
    
	var $search_page = 1;
	var $search_num = 6;
	
    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }
    
    function getProduct($params = array()) {
        if(empty($params) || ($params['keyword'] == '' && !intval($params['cat_id']))) return false;//
        $keyword = mysql_escape_string($params['keyword']);
        $opt = (isset($params['opt']))?mysql_escape_string($params['opt']):'AND';
        $region = (isset($params['region']))?mysql_escape_string($params['region']):'';
		$country = (isset($params['country']))?mysql_escape_string($params['country']):'';
        $membership = (isset($params['membership']))?$params['membership']:"";
        $time_period = (isset($params['time_period']))?$params['time_period']:'';
        $cat_id = (isset($params['cat_id']))?intval($params['cat_id']):0;
        $category_ids = '';
        $is_assessed = (isset($params['is_assessed']))?intval($params['is_assessed']):'';
        if($cat_id){
            $m_category = new M_category();
            $m_category->getAllSubCategoryIds($cat_id);
            $category_ids = $m_category->all_sub_category_ids;
        }
        
        $sql = "SELECT :attributes FROM products AS p
			LEFT JOIN company as c ON p.company_id = c.id
			INNER JOIN user_company AS uc ON uc.company_id = c.id
			INNER JOIN users AS u ON uc.user_id = u.id
			LEFT JOIN product_images AS pi ON pi.product_id = p.product_id
			LEFT JOIN product_order_attributes AS poa ON poa.product_id = p.product_id WHERE 1=1";
 
        $where = '';
      
        if($opt == 'EXT'){
            $where .= "p.name LIKE '%{$keyword}%' OR p.short_description LIKE '%{$keyword}%' OR p.keywords LIKE '%{$keyword}%'";
        } elseif($opt == 'AND') {
            $search_items = $this->parseKeyword($keyword);
            $i = 1;
            foreach($search_items as $search_item){
                if($i > 1)
                    $where .= " AND (p.name LIKE '%{$search_item}%' OR p.short_description LIKE '%{$search_item}%' OR p.keywords LIKE '%{$search_item}%')";
                else
                    $where .= "(p.name LIKE '%{$search_item}%' OR p.short_description LIKE '%{$search_item}%' OR p.keywords LIKE '%{$search_item}%')";
                $i++;
            }
        } elseif($opt == 'OR') {
            $search_items = $this->parseKeyword($keyword);
            $i = 1;
            foreach($search_items as $search_item){
                if($i > 1)
                    $where .= " OR p.name LIKE '%{$search_item}%' OR p.short_description LIKE '%{$search_item}%' OR p.keywords LIKE '%{$search_item}%'";
                else
                    $where .= "p.name LIKE '%{$search_item}%' OR p.short_description LIKE '%{$search_item}%' OR p.keywords LIKE '%{$search_item}%'";
                $i++;
            }    
        }

		if($where!='') $where = ' AND ('.$where.')';
        
        if($category_ids != '') {
            $where .= " AND p.category_id IN(".implode(',', $category_ids).")";
        }
        if($region) {
            $where .= " AND c.country_region='".$region."'";
        }
		
		if($country) {
            $where .= " AND c.country_name='".$country."'";
        }
		
        if($membership != ''){
            $membership = explode(',', $membership);
            for($i=0;$i<count($membership);$i++) $membership[$i] = "'".mysql_escape_string(strtoupper(trim($membership[$i],"'")))."'";
            $membership = implode(",",$membership);
            $where .= " AND UPPER(u.membership) IN(".$membership.")";
        }

        if($is_assessed != ''){
            $where .= " AND u.is_assessed = '".(intval($is_assessed)?'Y':'N')."'";
        }

        $sql .= $where;

        $select = ' COUNT(*) as num_row';
        $count_sql = str_replace(":attributes", $select, $sql);
        $query = $this->db->query($count_sql);
        $this->db->last_query();
        $total_rows = $query->result();
        if(is_array($total_rows) && count($total_rows)){
                        $total_rows = $total_rows[0]->num_row;
        }else{
                        $total_rows = 0;
        }
        $start = ($this->search_page - 1) * $this->search_num;
        $sql .= " LIMIT $start, $this->search_num";
        $select = ' p.*, poa.*,pi.image_name,c.id AS cid, c.name AS compName, c.address AS compAddress,c.country,c.no_employee,c.business_type,c.certification, u.membership, u.is_assessed';
        $sql = str_replace(":attributes", $select, $sql);

        $query = $this->db->query($sql);

        return array('pagination'=>array('rows'=>$total_rows,'page'=>ceil($total_rows/$this->search_num)),'result'=>$query->result());
    }
    
    function getSupplier($params = array()){
        if(empty($params) || ($params['keyword'] == '')) return false;//
        $keyword = mysql_escape_string($params['keyword']);
        $opt = (isset($params['opt']))?mysql_escape_string($params['opt']):'AND';
        $region = (isset($params['region']))?mysql_escape_string($params['region']):'';
		$country = (isset($params['country']))?mysql_escape_string($params['country']):'';
        $membership = (isset($params['membership']))?$params['membership']:"";
        $businessType = (isset($params['businessType']))?$params['businessType']:'';
        $cat_id = (isset($params['cat_id']))?intval($params['cat_id']):0;
        $category_ids = '';
        
        if($cat_id){
            $m_category = new M_category();
            $m_category->getAllSubCategoryIds($cat_id);
            $category_ids = $m_category->all_sub_category_ids;
        }
        
        $this->db->select('SQL_CALC_FOUND_ROWS c.*, ct.name AS countryName', FALSE);
        $this->db->from('company AS c');
        $this->db->join('country AS ct', 'ct.code = c.country', 'left');
        $this->db->join('user_company AS uc', 'uc.company_id = c.id', 'inner');
        $this->db->join('users AS u', 'uc.user_id = u.id', 'inner');
        
        $where = '1=1';
        $where = '(';
        if($opt == 'EXT'){
            $where .= "c.name LIKE '%{$keyword}%' OR c.product_keyword LIKE '%{$keyword}%'";
        } elseif($opt == 'AND') {
            $search_items = $this->parseKeyword($keyword);
            $i = 1;
            foreach($search_items as $search_item){
                if($i > 1)
                    $where .= " AND (c.name LIKE '%{$search_item}%' OR c.product_keyword LIKE '%{$search_item}%')";
                else
                    $where .= "(c.name LIKE '%{$search_item}%' OR c.product_keyword LIKE '%{$search_item}%')";
                $i++;
            }
        } elseif($opt == 'OR') {
            $search_items = $this->parseKeyword($keyword);
            $i = 1;
            foreach($search_items as $search_item){
                if($i > 1)
                    $where .= " OR c.name LIKE '%{$search_item}%' OR c.product_keyword LIKE '%{$search_item}%'";
                else
                    $where .= "c.name LIKE '%{$search_item}%' OR c.product_keyword LIKE '%{$search_item}%'";
                $i++;
            }    
        }
        $where .= ')';
        
        if($membership != ''){
            $membership = explode(',', $membership);
            for($i=0;$i<count($membership);$i++) $membership[$i] = "'".mysql_escape_string(strtoupper(trim($membership[$i],"'")))."'";
            $membership = implode(",",$membership);
            $where .= " AND UPPER(c.membership) IN(".$membership.")";
        }
        
        $this->db->where($where);
        
        if($category_ids != '') {
            $this->db->join('products AS p', 'p.company_id = c.id', 'inner');
            $this->db->where_in('p.category_id', $category_ids);
        }
        if($region)
            $this->db->where('c.country_region', $region);
		if($country)
            $this->db->where('c.country_name', $country);
        if($businessType != '')
            $this->db->where('c.business_type', $businessType);
        
        $start = ($this->search_page - 1) * $this->search_num;
        $this->db->limit($this->search_num, $start);
        $query = $this->db->get();
        $result = $query->result();
        
        $this->db->select('FOUND_ROWS() AS num_rows', FALSE);
        $res = $this->db->get();
        $total_rows = $res->row()->num_rows;
        
        return array('pagination'=>array('rows'=>$total_rows,'page'=>ceil($total_rows/$this->search_num)),'result'=>$result);
     }
     
     function getBuyer($params = array()){
        if(empty($params) || ($params['keyword'] == '')) return false;//
        $keyword = mysql_escape_string($params['keyword']);
        $opt = (isset($params['opt']))?mysql_escape_string($params['opt']):'AND';
        $region = (isset($params['region']))?mysql_escape_string($params['region']):'';
		$country = (isset($params['country']))?mysql_escape_string($params['country']):'';
        $membership = (isset($params['membership']))?$params['membership']:"";
        $time_period = (isset($params['time_period']))?$params['time_period']:'';
        $cat_id = (isset($params['cat_id']))?intval($params['cat_id']):0;
        $category_ids = '';
        
        if($cat_id){
            $m_category = new M_category();
            $m_category->getAllSubCategoryIds($cat_id);
            $category_ids = $m_category->all_sub_category_ids;
        }
        $this->db->select('SQL_CALC_FOUND_ROWS b.*, c.name, c.email, c.country', FALSE);
        $this->db->from('buying_requests AS b');
        $this->db->join('company AS c', 'b.company_id = c.id', 'left');
        $this->db->join('user_company AS uc', 'uc.company_id = c.id', 'inner');
        $this->db->join('users AS u', 'uc.user_id = u.id', 'inner');
        
        $where = '1=1';
        $where = '(';
        if($opt == 'EXT'){
            $where .= "b.product_name LIKE '%{$keyword}%' OR b.product_specification LIKE '%{$keyword}%'";
        } elseif($opt == 'AND') {
            $search_items = $this->parseKeyword($keyword);
            $i = 1;
            foreach($search_items as $search_item){
                if($i > 1)
                    $where .= " AND (b.product_name LIKE '%{$search_item}%' OR b.product_specification LIKE '%{$search_item}%')";
                else
                    $where .= "(b.product_name LIKE '%{$search_item}%' OR b.product_specification LIKE '%{$search_item}%')";
                $i++;
            }
        } elseif($opt == 'OR') {
            $search_items = $this->parseKeyword($keyword);
            $i = 1;
            foreach($search_items as $search_item){
                if($i > 1)
                    $where .= " OR b.product_name LIKE '%{$search_item}%' OR b.product_specification LIKE '%{$search_item}%'";
                else
                    $where .= "b.product_name LIKE '%{$search_item}%' OR b.product_specification LIKE '%{$search_item}%'";
                $i++;
            }    
        }
        $where .= ')';
        
        if($membership != ''){
            $membership = explode(',', $membership);
            for($i=0;$i<count($membership);$i++) $membership[$i] = "'".mysql_escape_string(strtoupper(trim($membership[$i],"'")))."'";
            $membership = implode(",",$membership);
            $where .= " AND UPPER(c.membership) IN(".$membership.")";
        }
        
        $this->db->where($where);
        if($category_ids != '')
            $this->db->where_in('b.product_category', $category_ids);
        if($region)
            $this->db->where("c.country_region", $region);
		if($country)
            $this->db->where("c.country_name", $country);			
        if($time_period == 7){
            $this->db->where("UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(expired_time) <=", 7 * 86400);
        } elseif($time_period == 8){
            $this->db->where("UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(expired_time) >", 8 * 86400);
        }
        $start = ($this->search_page - 1) * $this->search_num;
        $this->db->limit($this->search_num, $start);
		$select = ' b.*, c.id AS cid, c.name AS compName, c.address AS compAddress, c.country, c.no_employee, c.business_type, c.certification, u.membership, u.is_assessed';

		$this->db->select($select);
		$query = $this->db->get();
        $result = $query->result();
        
        $this->db->select('FOUND_ROWS() AS num_rows', FALSE);
        $res = $this->db->get();
        $total_rows = $res->row()->num_rows;
        
        return array('pagination'=>array('rows'=>$total_rows,'page'=>ceil($total_rows/$this->search_num)),'result'=>$result);
    }
    
    function parseKeyword($keyword) {
        preg_match_all('/".*?("|$)|((?<=[\\s",+])|^)[^\\s",+]+/', $keyword, $matches);
        $search_items = array_map(create_function('$a', 'return trim($a, "\\"\'\\n\\r ");'), $matches[0]);
        return $search_items;
    }
    
    function getAutocompleteResults($keywords){
    	$keyword = mysql_escape_string($keywords);
    	
    	$sql = "SELECT :attributes FROM products AS p ";
    	
    	$search_items = $this->parseKeyword($keyword);
    	$i = 1;
    	$where = '';
    	foreach($search_items as $search_item){
    		if($i > 1)
    			$where .= " OR p.name LIKE '%{$search_item}%' OR p.short_description LIKE '%{$search_item}%' OR p.keywords LIKE '%{$search_item}%'";
    		else
    			$where .= "p.name LIKE '%{$search_item}%' OR p.short_description LIKE '%{$search_item}%' OR p.keywords LIKE '%{$search_item}%'";
    		$i++;
    	}
    	
    	if($where!='') $where = '('.$where.')';
    	
    	$sql .= 'WHERE '.$where;
    	
    	$sql .= 'GROUP BY p.category_id';
		
    	$select = ' p.name, p.category_id, COUNT(p.name) as num_row';
    	
    	$sql = str_replace(":attributes", $select, $sql);
    	
    	$query = $this->db->query($sql);

    	$result = $query->result_array();
    	$result_array = array();
    	foreach ($result as $res){
    		$result_array[] = array('name'=>$res['name'],'count'=>$res['num_row']);
    	}
    	//print_r($result);
    	return $result_array;	
    }
    

}
?>