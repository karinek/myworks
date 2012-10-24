<?php
class M_like extends CI_Model {
	function __construct(){
		// Call the Model constructor
		parent::__construct();
	}
	
	function isExist($user_id,$params){
		$this->db->where("user_id",$user_id);
		$this->db->where($params['section']."_id",$params['value']);
		$query = $this->db->get('like');
		if ($query->num_rows()==1){
			return TRUE;
		}
		$this->insert($user_id,$params);
		return FALSE;
	}
	
	function insert($user_id,$params){
		$data = array(
			'user_id'   =>  $user_id,
			$params['section'].'_id'    =>  $params['value'],
			'time'  =>  date("Y-m-d h:i:s")
		);
		$this->db->insert('like', $data);
	}
	
	function dislikeExist($user_id,$id,$module){
		$this->db->where("user_id",$user_id);
		$this->db->where("related_id",$id);
		$this->db->where("module",$module);
		$query = $this->db->get('dislike');
		if ($query->num_rows()==1){
			return TRUE;
		}
		$this->dislikeInsert($user_id,$id,$module);
		return FALSE;
	}

	function dislikeInsert($user_id,$id,$module){
		$data = array(
			'user_id'   =>  $user_id,
			'related_id'    =>  $id,
			'module'    =>  $module,
			'time'  =>  date("Y-m-d h:i:s")
		);
		$this->db->insert('dislike', $data);
	}
	
}
?>