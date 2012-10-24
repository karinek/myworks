<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_slide extends CI_Model {
        
	function __construct(){
		parent::__construct();
	}
	
	function getSlides($num=4){
		$this->db->limit($num);
		$res = $this->db->get('main_slides');
		return $res->result_array();
	}
}
?>		