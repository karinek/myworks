<?php
class M_product extends CI_Model {

    
    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }
    
    function getAttributesForCategory($category_id){         
        $sql = "select * from `attribute` a join `category_attributes` ca on a.`attr_id` = ca.`attr_id` where ca.`category_id` = $category_id order by ca.`attr_order`;";
      	$query = $this->db->query($sql);
	$results = $query->result();
        return $results;                          
    }

    function getInfo ($product_id){
	$this->db->where('product_id',$product_id);
	$query = $this->db->get('products');
	return $query->row_array();
    }
    
    function getInfoByIdArray($ids){
        if(is_array($ids)){
            foreach($ids as $id){ 
                $this->db->where('product_id', $id->product_id);
                $res[$id->product_id] = $this->db->get('products')->result();
            }
            return $res;
        }
        return FALSE;
    }
    
    function getAttributeValues($product_id){
	$this->db->where('product_id',$product_id);
	$query = $this->db->get('product_attributes_values');
	return $query->result_array();
    }
    
    function getImages($product_id){
	$this->db->where('product_id',$product_id);
	$query = $this->db->get('product_images');
	return $query->row_array();
    }
    
    
    function getOrderAttributes($product_id){
	$this->db->where('product_id',$product_id);
	$query = $this->db->get('product_order_attributes');
	return $query->row_array();
    }
    
    function insert_product($data){
        $this->db->insert('products', $data);
        return $this->db->insert_id();
    }
    
    function update_product($id,$data){
	$this->db->where('product_id',$id);
        $this->db->update('products', $data);
    }
    
    function insert_product_image($data){
        $this->db->insert('product_images', $data);
    }
    
    function update_product_image($id,$data){
	$this->db->where('product_id',$id);
        $this->db->update('product_images', $data);
    }
    
    function insert_product_order_attributes($data){       
        $this->db->insert('product_order_attributes', $data);        
    }
    
    function update_product_order_attributes($id,$data){
	$this->db->where('product_id',$id);
        $this->db->update('product_order_attributes', $data);
    }
   
    
    function insert_product_attributes($data){
        $this->db->insert_batch('product_attributes_values', $data);  
    }
    
    function update_product_attributes($product_id,$attr_id,$data){
	$this->db->where('product_id',$product_id);
	$this->db->where('attr_id',$attr_id);
        $this->db->update('product_attributes_values', $data);      
    }
    
    function del_additional_attributes($product_id){
	$this->db->where('product_id',$product_id);
	$this->db->where('attr_id',0);
        $this->db->delete('product_attributes_values');      
    }
    
    
    function delete_product($id){
        $this->db->where('product_id', $id);
        $this->db->delete('products');              
    }
    
    function getProductById($productId){
        $this->db->select('*');
        $this->db->from('products');
        $this->db->join('product_images', 'products.product_id = product_images.product_id');
        $this->db->join('product_order_attributes', 'products.product_id = product_order_attributes.product_id');
        $this->db->join('product_attributes_values', 'products.product_id = product_attributes_values.product_id');
        $this->db->where('products.product_id', $productId);
        return $query = $this->db->get()->result();
//        echo "<pre>";print_r($query);exit;
    }
	function getProductArrayById($productId){
        $this->db->select('*');
        $this->db->from('products');
        $this->db->join('product_images', 'products.product_id = product_images.product_id','left');
        $this->db->join('product_order_attributes', 'products.product_id = product_order_attributes.product_id','left');
        $this->db->join('product_attributes_values', 'products.product_id = product_attributes_values.product_id','left');
        $this->db->where('products.product_id', $productId);
        return $this->db->get()->row_array();
//        echo "<pre>";print_r($query);exit;
    }
    
    public function getUnitOptions(){
	$this->db->select('name');
	$query = $this->db->get('option_unit');
        //$data[''] = 'Select Unit';
	foreach($query->result() as $row){
	    $data[$row->name] = $row->name;     
	}
	return $data;	    
    }
    
    public function getAllPayment(){
	$this->db->select('name');
	$query = $this->db->get('option_payment');
	return $query->result_array();	    
    }
    
    public function getRelatedProducts($id = 0, $name = ''){
        if(!$id || $name == '') return array();
        $nameParams = $this->parseName($name);
        $nameParams = array_diff($nameParams, array('of','the'));
        $results = array();
        
        $this->db->select('product_id,name');
        $this->db->where("product_id != {$id}");
        if(!empty($nameParams)){
            foreach($nameParams as $nameParam){
                $this->db->like('name', $nameParam);
            }
            
            $this->db->limit(15, 0);
            $res = $this->db->get('products')->result();
            $num_rows = count($res);
            $product_ids = array($id);
            foreach($res as $v){
                $product_ids[] = $v->product_id;
            }
            $results = $res;
            if($num_rows < 15){
                $this->db->select('product_id,name');
                $where = "product_id NOT IN(".implode(',', $product_ids).") AND (";
                $i = 1;
                foreach($nameParams as $nameParam){
                    if($i >1)
                        $where .= ' OR `name` LIKE "%'.$nameParam.'%"';
                    else
                        $where .= '`name` LIKE "%'.$nameParam.'%"';
                    $i++;    
                }
                $where .= ")";
                $this->db->where($where);
                $this->db->limit(15 - $num_rows, 0);
                $res = $this->db->get('products')->result();
                $results = array_merge($results, $res);
            }
        }
        return $results;
    }
    
    public function parseName($name) {
        preg_match_all('/".*?("|$)|((?<=[\\s",+])|^)[^\\s",+]+/', $name, $matches);
        $search_items = array_map(create_function('$a', 'return trim($a, "\\"\'\\n\\r ");'), $matches[0]);
        return $search_items;
    }
    
////////////////////////////////////////////////////////////////////////////////////////    
///////////////////////////////////////Preview Part ///////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////

    function insert_temp_product($data){
        $this->db->insert('temp_products', $data);
        return $this->db->insert_id();
    }

    
    function insert_temp_product_image($data){
        $this->db->insert('temp_product_images', $data);
    }
    
    function insert_temp_product_order_attributes($data){       
        $this->db->insert('temp_product_order_attributes', $data);        
    }
    
    function insert_temp_product_attribute_value($data){
        $this->db->insert_batch('temp_product_attributes_values', $data);  
    }

    function get_temp_info ($product_id){
		$this->db->where('product_id',$product_id);
		$query = $this->db->get('temp_products');
		return $query->row_array();
    }

    function get_temp_product_order_attributes($product_id){
		$this->db->where('product_id',$product_id);
		$query = $this->db->get('temp_product_order_attributes');
		return $query->row_array();
    }

    function get_temp_product_image($product_id){
		$this->db->where('product_id',$product_id);
		$query = $this->db->get('temp_product_images');
		return $query->row_array();
    }
    
    function get_temp_product_attribute_values($product_id){
		$this->db->where('product_id',$product_id);
		$query = $this->db->get('temp_product_attributes_values');
		return $query->result_array();
    }
    

    function getNewProductList(){
    	$this->db->select('p.*, pi.image_name, c.category_name');
    	$this->db->from('products as p');
    	$this->db->join('product_images as pi', 'p.product_id = pi.product_id','left');
    	$this->db->join('category as c', 'c.category_id = p.category_id','left');
    	$this->db->where('p.new_list','1');
    	$query = $this->db->get();
    	$res = $query->result_array();
    	return $res;
    }    
}
?>