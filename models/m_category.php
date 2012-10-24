<?php
class M_category extends CI_Model {
    public $all_sub_categories = array();
    public $all_sub_category_ids = array();
    
    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }

    function getSubCategory($c_id){
        $this->db->where('parent_id',$c_id);
        $query = $this->db->get('category');
        
	return $query->result_array();	
    }
    
    function insert($data) {
        $this->db->where('category_name',$data['category_name']);
        $this->db->where('parent_id',$data['parent_id']);
        $query = $this->db->get('category',1);
        if ($query->num_rows()==1){
            return FALSE;
        }
        $this->db->insert('category',$data);
        return TRUE;
    }
    
    function update($id,$data) {
        $this->db->where('category_id',$id);
        $this->db->update('category',$data);
    }
    
    function getParent($c_id){
        $this->db->select('parent_id');
        $this->db->where('category_id',$c_id);
        $query = $this->db->get('category',1);
        if ($query->num_rows()==1){
            return $query->row()->parent_id;
        }
        return FALSE;
    }
    
    function getCategory($c_id){
        $this->db->where('category_id',$c_id);
        $query = $this->db->get('category',1);
        if ($query->num_rows()==1){
            return $query->row();
        }
        return FALSE;
    }
    
    function getCategories(){
        $this->db->where('parent_id',0);
        $query = $this->db->get('category');
        if ($query->num_rows()>0){
            return $query->result();
        }
        return FALSE;
    }
    
    function getNav($c_id){
        if (!$c_id)
            return "";
        $tmp = $this->getCategory($c_id);
        while($tmp->parent_id != 0) {
            return $this->getNav($tmp->parent_id)."-----".anchor('attribute/display/'.$tmp->category_id,$tmp->category_name);    
        }
        return anchor('attribute/display','Home')."-----".anchor('attribute/display/'.$tmp->category_id,$tmp->category_name);
    }
    
    function getList($c_id){
        $tmp = $this->getCategory($c_id);
        while($tmp->parent_id != 0) {
            return $this->getList($tmp->parent_id).">>>>".$tmp->category_name;    
        }
        return $tmp->category_name;
        
    }
    
    function getBreadcrumbs($c_id){
        $tmp = $this->getCategory($c_id);
        $tmpArray[] = array('link'=>base_url('category/show/'.$c_id),'title'=>$tmp->category_name);
        while($tmp->parent_id != 0) {
            return array_merge($this->getBreadcrumbs($tmp->parent_id),$tmpArray);    
        }
        return $tmpArray;
    }
    

	/* helman code start */
	
	function updateProductCounter(){
//		$this->db->where('parent_id',$catId);
		$this->db->select('COUNT(category_id) as counter');
		$this->db->select('category_id');
		$this->db->group_by('category_id');
		$this->db->order_by('category_id');
		$res = $this->db->get('products');
		if ($res->num_rows()){
			$rows =& $res->result();
			$sql = array();
			foreach($rows as $row){
				$cats[$row->category_id] = array(
					'category_id' => $row->category_id,
					'total_products' => $row->counter
				);
			}
			$this->db->update_batch('category',$cats,'category_id');
		}
		
		$res = $this->db->get('category');
		if ($res->num_rows()){
			$cats =& $res->result();
			$parents = array();
			foreach($cats as $cat){
				if(!isset($parents[$cat->parent_id]) || !is_array($parents[$cat->parent_id])) $parents[$cat->parent_id] = array();
				array_push($parents[$cat->parent_id], array(
					'category_id' => $cat->category_id,
					'total_products' => $cat->total_products
				));
			}

			$total = $this->productCounter($parents,0);
			
			foreach($parents as $parent){
				$this->db->update_batch('category',$parent,'category_id');
			}
		}
		return true;
	}
	
	function productCounter(&$arr = array(), $index, $key='total_products'){
		if(!isset($arr[$index]) || !count($arr[$index])) return false;
		$total = 0;
		foreach($arr[$index] as $key => $val){
			$product_count = $this->productCounter($arr,$arr[$index][$key]['category_id']);
			if($product_count==false){
				$product_count = $arr[$index][$key]['total_products'];
			}
			$arr[$index][$key]['total_products'] = $product_count;

			$total += $arr[$index][$key]['total_products'];
		}
		return $total;
	}
		
	function isLeaf($catId=0){
		$this->db->where('parent_id',$catId);
		$query = $this->db->get('category',1);
		if ($query->num_rows()==1){
			return false;
		}
		return true;
	}
        
        function getSubCategories($cat_id){
            $this->load->helper(array('category'));
            get_all_subcategories($this, $cat_id);
            $results = $this->all_sub_categories;
            return $results;
        }
        
        function getAllSubCategoryIds($cat_id){
            $this->load->helper(array('category'));
            $this->all_sub_category_ids[] = $cat_id;
            get_all_subcategory_ids($this, $cat_id);
        }
        
        function getProductListByCategory($cat_id = 0){
            $results = array();
            if(isset($cat_id)) {
                $category = $this->getCategory($cat_id);
                $this->getAllSubCategoryIds($cat_id);

                $this->db->select('p.*, c.name AS compName, c.address AS compAddress');
                $this->db->from('products AS p');
                $this->db->join('company AS c', 'p.company_id = c.id', 'left');
                $this->db->where_in('p.category_id', $this->all_sub_category_ids);

                $query = $this->db->get();
                $results = $query->result();

            }
            return $results;
        }
		
		function getCompanyCategories($company_id){
			$results = array();
            if(isset($company_id)&&$company_id>0) {
                $sql="SELECT c. * , count( p.product_id ) AS prodcnt
						FROM `category` c
						INNER JOIN products p ON p.category_id = c.category_id
						WHERE p.company_id ='".mysql_escape_string($company_id)."'
						GROUP BY c.category_id
						HAVING count( p.product_id ) >0
						order by c.category_name";
 				}else{
				 $sql="SELECT c. * , count( p.product_id ) AS prodcnt
						FROM `category` c
						INNER JOIN products p ON p.category_id = c.category_id						
						GROUP BY c.category_id
						HAVING count( p.product_id ) >0
						order by c.category_name";
				}
                $query =$this->db->query($sql);
				$results=$query->result_array();

           
            return $results;
		}
	
	/* helman code end */
		
		function getFeaturedCategories(){
			$sql="SELECT fc.*, c.category_name , c.total_products
					FROM `featured_categories` as fc
					LEFT JOIN category as c ON c.category_id = fc.category_id
					GROUP BY fc.category_id";
			$query =$this->db->query($sql);
			$results=$query->result_array();
			return $results;
		}
		
		function parseKeyword($keyword) {
			preg_match_all('/".*?("|$)|((?<=[\\s",+])|^)[^\\s",+]+/', $keyword, $matches);
			$search_items = array_map(create_function('$a', 'return trim($a, "\\"\'\\n\\r ");'), $matches[0]);
			return $search_items;
		}
		
		function getCategoriesBySearch($keywords){
			$keyword = mysql_escape_string($keywords);
		
			$sql = "SELECT c.* FROM category AS c ";
		
			$search_items = $this->parseKeyword($keyword);
			$i = 1;
			$where = '';
			foreach($search_items as $search_item){
				if($i > 1)
					$where .= " OR c.category_name LIKE '%{$search_item}%'";
				else
					$where .= "c.category_name LIKE '%{$search_item}%'";
				$i++;
			}
		
			if($where!='') $where = '('.$where.')';
		
			$sql .= 'WHERE '.$where;
			$sql .= 'ORDER BY c.parent_id, c.category_name';
			$query = $this->db->query($sql);
			$result = $query->result_array();
		
			return $result;
		}		
}
?>