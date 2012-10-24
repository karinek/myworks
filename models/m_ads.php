<?php
class M_ads extends CI_Model {
	
    function __construct(){
		parent::__construct();
    }
	
	function get(){
		$sql = "SELECT name,link FROM ad
				ORDER BY RAND()
				LIMIT 1";
		$res = $this->db->query($sql);
		$data = $res->row_array();
		$data['name'] = base_url('images/iphone_ads/'). "/" .$data['name'];
		return $data;
	}
}
	