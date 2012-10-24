<?php
class M_offer extends CI_Model {
	
	var $offer_page = 1;
	var $offer_num = 6;
	
    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }

    function getAllOffers(){

    	$this->db->select('COUNT(*) as num_row');
        $this->db->from('latest_offers as o');
        $this->db->join('products AS p', 'p.product_id = o.product_id', 'left');
        $query = $this->db->get();
        $this->db->last_query();
        $total_rows = $query->result();
        
        if(is_array($total_rows) && count($total_rows)){
        	$total_rows = $total_rows[0]->num_row;
        }else{
        	$total_rows = 0;
        }
        
        
        $start = ($this->offer_page - 1) * $this->offer_num;
        
        $this->db->select('o.*,p.*');
        $this->db->from('latest_offers as o');
        $this->db->join('products AS p', 'p.product_id = o.product_id', 'left');
        $this->db->limit($this->offer_num,$start);
        
        $query = $this->db->get();
        
        return array('pagination'=>array('rows'=>$total_rows,'page'=>ceil($total_rows/$this->offer_num)),'result'=>$query->result());        
    }
    
    function insert($data) {
        $this->db->insert('latest_offers',$data);
        return TRUE;
    }
    
    function update($id,$data) {
        $this->db->where('offer_id',$id);
        return $this->db->update('latest_offers',$data);
        
    }
    
	function delete($id){
		$this->db->where('offer_id',$id);
		return $this->db->delete('latest_offers');
	}    

    function getActiveOffers(){
        $this->db->select('o.*,p.liked,pi.image_name');
        $this->db->from('latest_offers as o');
        $this->db->join('products AS p', 'p.product_id = o.product_id', 'left');
        $this->db->join('product_images AS pi', 'pi.product_id = o.product_id', 'RIGHT');
    	$this->db->where('o.offer_status','active');
    	$this->db->where('NOW() BETWEEN o.start_date AND o.end_date');
    	$this->db->where('p.status != "banned"');
    	$query = $this->db->get();
    	return $query->result();
    }
    
    function parseKeyword($keyword) {
    	preg_match_all('/".*?("|$)|((?<=[\\s",+])|^)[^\\s",+]+/', $keyword, $matches);
    	$search_items = array_map(create_function('$a', 'return trim($a, "\\"\'\\n\\r ");'), $matches[0]);
    	return $search_items;
    }    
    
    function getProductsAutocomplete($keyword){
    	$search_items = $this->parseKeyword($keyword);

    	$where = '';
    	$i = 1;
    	foreach($search_items as $search_item){
    		if($i > 1)
    			$where .= " OR p.name LIKE '%{$search_item}%' OR p.short_description LIKE '%{$search_item}%' OR p.keywords LIKE '%{$search_item}%'";
    		else
    			$where .= "p.name LIKE '%{$search_item}%' OR p.short_description LIKE '%{$search_item}%' OR p.keywords LIKE '%{$search_item}%'";
    		$i++;
    	}
    	
    	$this->db->select('p.product_id, p.name, po.price_cur, po.price_1');
    	$this->db->from('products as p');
    	$this->db->join('product_order_attributes AS po', 'po.product_id = p.product_id', 'left');
    	$this->db->where('p.status != "banned"');
    	$this->db->where($where);
    	$query = $this->db->get();
        $result = $query->result_array();

    	return $result;
    }    

}
?>