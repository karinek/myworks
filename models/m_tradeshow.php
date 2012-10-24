<?php
class M_tradeshow extends CI_Model {

   
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    public function getAll(){
        $this->db->select('*');
        $query = $this->db->get('tradeshows');
        
        return $query->result();
    }
}
?>
