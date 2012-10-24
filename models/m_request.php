<?php
class M_request extends CI_Model {
	
	var $req_page = 1;
    var $req_num = 6;

    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }
    
    function insert_request($data){
        $this->db->insert('buying_requests',$data);
    }
    
    function get_request($company_id, $order = '', $page = false){
		if($page){
			$this->db->select('count(*) as num_row');
			$this->db->where('company_id', $company_id);
			$res = $this->db->get('buying_requests');
			$total_rows = $res->result();
			if(is_array($total_rows) && count($total_rows)){
					$total_rows = $total_rows[0]->num_row;
			}else{
					$total_rows = 0;
			}
			$start = ($this->req_page - 1) * $this->req_num;
			$this->db->limit($this->req_num, $start);
			$this->req_page = 1;
		}

		$this->db->where('company_id', $company_id);
        if($order != '')
                $this->db->order_by("product_name", strtoupper($order));
		$res = $this->db->get('buying_requests');
	
        if($page) return array('pagination'=>array('rows'=>$total_rows,'page'=>ceil($total_rows/$this->req_num)),'result'=>$res->result());
		else return $res->result();
    }
    
    function getRequestByID($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('buying_requests');
        if($query->num_rows > 0)
            return $query->result();
        return array();
    }
	
	function delete_request($id){
		if(intval($id) == 0) return false;

        $this->db->where('id',intval($id));

        if($this->db->delete('buying_requests')) {
            return true;
        } else {
            return false;
        }
	}
}
?>