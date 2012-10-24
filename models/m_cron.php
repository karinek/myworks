<?php
class M_cron extends CI_Model {
    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }
    
    function active_product($time){
        $sql = "update products
                set status = 'actived'
                where upload_time >= DATE_SUB(now(),INTERVAL $time SECOND) and status = 'pending'";
        $query = $this->db->query($sql);
    }
}
?>