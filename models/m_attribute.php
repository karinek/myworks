<?php
class M_attribute extends CI_Model{
	function __construct(){
		parent::__construct();
	}

	/* new attribute */
	function add($catId, $params){
		$catId = intval($catId);

		if(!$catId) return false;
		if(!count($params) || !is_array($params)) return false;

		$fields = array();
		foreach($params as $key => $value){
			if($key == 'attr_new' || $key == 'ordering') continue;
			if($key == 'attr_value'){
				switch($params['attr_type']){
					case 'selectbox':
					case 'checkbox':
					case 'optionbox':
						$fields[$key] = mysql_escape_string(str_replace("\n",'|',str_replace("\r",'',$value)));
					break;
					default:
						$fields[$key] = mysql_escape_string($value);
					break;
				}
			}else{
				$fields[$key] = mysql_escape_string($value);
			}
		}

		$this->db->insert('attribute',$fields);

		$fields['attr_id'] = $this->db->insert_id();
		$fields['attr_order'] = $params['ordering'];
		$fields['category_id'] = $catId;

		$this->db->insert('category_attributes',array(
			'category_id' => $catId,
			'attr_order' => $fields['attr_order'],
			'attr_id' => $fields['attr_id']
		));

		return $fields;
	}

	/* delete attribute */
	function delete($params){
		
	}

	/* updating attribute */
	function update($catId, $attrId, $params){
		$catId = intval($catId);
		$attrId = intval($attrId);

		if(!$catId || !$attrId) return false;
		if(!count($params) || !is_array($params)) return false;

		$fields = array();
		foreach($params as $key => $value){
			if($key == 'attr_new' || $key == 'ordering') continue;
			if($key == 'attr_value'){
				switch($params['attr_type']){
					case 'selectbox':
					case 'checkbox':
					case 'optionbox':
						$fields[$key] = mysql_escape_string(str_replace("\n",'|',str_replace("\r",'',$value)));
					break;
					default:
						$fields[$key] = mysql_escape_string($value);
					break;
				}
			}else{
				$fields[$key] = mysql_escape_string($value);
			}
		}

		$this->db->update('attribute', $fields, array('attr_id'=>$attrId));

		$fields['attr_order'] = $params['ordering'];

		$this->db->update('category_attributes', array(
			'attr_order' => $fields['attr_order']
		), array('attr_id'=>$attrId, 'category_id'=>$catId));

		return $fields;
	}

	/* process of checking attribute is existing or new-one*/
	function process($catId, $items){
		$catId = intval($catId);

		if(!$catId) return false;
		if(!count($items) || !is_array($items)) return false;

		$ordering = 1;
		foreach($items as $key => $item){
			$attrId = intval($key);
			if(isset($item['attr_new']) && intval($item['attr_new'])){
				$attrId = 0;	
			}
			unset($item['attr_new']);

			$attr = $this->get($attrId);
			$item['ordering'] = $ordering;
			
			if(!$attr){
				echo('adding new<br>');
				$this->add($catId, $item);
			}else{
				$this->update($catId, $attrId, $item);
			}
			
			$ordering++;
		}
	}

	/* get attribute by attribute id */
	function get($attrId){
		$this->db->where('attr_id',intval($attrId));
		$res = $this->db->get('attribute');
		if ($res->num_rows()) return $res->result();
		return false;
	}


	/* get attribute by attribute id */
	function getByCategoryId($catId = 0){
		if(intval($catId) < 1) return false;
		$sql = "SELECT * FROM category_attributes ca LEFT JOIN attribute a ON (ca.attr_id=a.attr_id) WHERE ca.category_id=".intval($catId)." ORDER BY attr_order ASC;";
		$res = $this->db->query($sql);
		if ($res->num_rows()) return $res->result();
		return false;
	}
        function getAttributeNames(){
            $this->db->select('attr_name');
            $this->db->from('attribute');
            $this->db->where('attr_value !=', 'NULL');
            $res = $this->db->get()->result();
            return $res;
        }
}
?>