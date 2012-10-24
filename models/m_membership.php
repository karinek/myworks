<?php
class M_membership extends CI_Model {

    function __construct(){
		// Call the Model constructor
		parent::__construct();
    }
    
    public function get($user_id){
		$this->db->where('user_id',$user_id);
		$query = $this->db->get('membership');
		return $query->row_array();	    
    }
    
    public function update($user_id,$data){
		if($this->get($user_id)){
			$this->db->update('membership', $data);
		} else {
			$data['user_id'] = $user_id;
			$this->db->insert('membership', $data);
		}
    }
    
	function upgradeTo($user_id, $type){
		$this->db->where('user_id',$user_id);
		$res = $this->db->get('user_company',1);
		if($res->num_rows()){
			$row = $res->row();
			$date = date("Y-m-d h:i:s");
			$this->db->where('id',$row->user_id);
			$this->db->set('membership', $type);
			$this->db->set('membership_date', $date);
			$status1 = $this->db->update('users');
	
			$this->db->where('id',$row->company_id);
			$this->db->set('membership', $type);
			$this->db->set('membership_date', $date);
			$status2 = $this->db->update('company');
			
			return true;
		}
		return false;
	}
	
    public function getTypes(){
		$results = array();
		$query = $this->db->get('membership_type');
		$types = $query->result();
		foreach($types as $type){
			$results[$type->key] = $type->price;
		}
		return $results;	
    }
    
    public function isContactLimited($membership,$count){
		if ($membership != 'Free')
			return FALSE;
		
		
		$this->db->where('name','free_contact_limit');
		$query = $this->db->get('global_var');
		$data = $query->row_array();
		
		if ($count < $data['value'])
			return FALSE;
		return TRUE;
		}
		
		public function isBuyingLimited($membership,$count){
		if ($membership != 'Free')
			return FALSE;
		
		
		$this->db->where('name','free_buying_limit');
		$query = $this->db->get('global_var');
		$data = $query->row_array();
		
		if ($count < $data['value'])
			return FALSE;
		return TRUE;
		}
		
		public function isSellingLimited($membership,$count){
		if ($membership != 'Free')
			return FALSE;
		
		
		$this->db->where('name','free_selling_limit');
		$query = $this->db->get('global_var');
		$data = $query->row_array();
		
		if ($count < $data['value'])
			return FALSE;
		return TRUE;
    }
}    
?>