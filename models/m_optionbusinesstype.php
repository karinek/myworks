<?php
class M_optionBusinessType extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    function getBusinessTypes(){
        $query = $this->db->get('option_business_type');
        return $query->result_array();
    }
    
    function getBusinessTypeById($id){
       if($id){
           $this->db->select('name');
           $this->db->where('id', $id);
           $query = $this->db->get('option_business_type');
           return $query->row()->name;
       }
       return '';
    }
}
