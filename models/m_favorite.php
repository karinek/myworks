<?php
class M_favorite extends CI_Model {
    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }
/*
    function getAll($user_id){
        $sql = "select f.*,p.name prod_name,c.name as company_name,c.address,c.city,c.state,c.website,c.info
                from favorite f left join products p on f.product_id = p.product_id
                                left join company c on f.company_id = c.id
                where f.user_id = $user_id";

        $query = $this->db->query($sql);
       
        return $query->result_array();
    }
*/
    function getProduct($user_id){
        $sql = "select f.*,p.name,p.keywords,p.short_description
                from favorite_product f left join products p on f.product_id = p.product_id
                where f.user_id = $user_id";
        $query = $this->db->query($sql);
        return $query->result_array();        
    }
    
    function getCompany($user_id){
        $sql = "select f.*,c.name as company_name,c.address,c.city,c.state,c.website
                from favorite_company f left join company c on f.company_id = c.id
                where f.user_id = $user_id";
        $query = $this->db->query($sql);
        return $query->result_array();        
    }
    
    function updateCompany($id,$data){
        $this->db->where('id',$id);
        $this->db->update('favorite_company', $data);
    }
    
    function updateProduct($id,$data){
        $this->db->where('id',$id);
        $this->db->update('favorite_product', $data);
    }
    
    function insertCompany($data) {
        $this->db->where('user_id',$data['user_id']);
        $this->db->where('company_id', isset($data['company_id']) ? intval($data['company_id']) : 0);
        $query = $this->db->get('favorite_company',1);
        if ($query->num_rows()==1){
            return FALSE;
        }
        $this->db->insert('favorite_company',$data);
        return TRUE;
    }

    function insertProduct($data) {
        $this->db->where('user_id',$data['user_id']);
        $this->db->where('product_id', isset($data['product_id']) ? intval($data['product_id']) : 0);
        $query = $this->db->get('favorite_product',1);
        if ($query->num_rows()==1){
            return FALSE;
        }
        $this->db->insert('favorite_product',$data);
        return TRUE;
    }
    
    function removeCompany($id) {
        $this->db->where('id', $id);
        $this->db->delete('favorite_company');              
    }
    
    function removeProduct($id) {
        $this->db->where('id', $id);
        $this->db->delete('favorite_product');              
    }

    
    
}
?>