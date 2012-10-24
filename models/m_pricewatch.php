<?php
class M_pricewatch extends CI_Model {
    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }

    function get(){
	$query = $this->db->get('price_watch');
	return $query->result_array();
    }

}
?>