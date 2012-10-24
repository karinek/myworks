<?php
class M_analytics extends CI_Model {
    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }

    function insert($data) {
        $this->db->insert('analytics',$data);
    }

    
    
}
?>