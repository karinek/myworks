<?php
class M_user extends CI_Model {

   
    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }
    
    function getCompanyByUser($id){
        $this->db->where('user_id',$id);
        $this->db->where('is_main',1);
        $this->db->select('company_id');
        $query = $this->db->get('user_company');
        
        if ($query->num_rows()==1)
            return $query->row()->company_id;
        else
            return 0;
    }
    
    function getUserByCompany($cid){
        $this->db->where('uc.company_id',$cid);
        $this->db->where('uc.is_main',1);
        $this->db->select('u.*');
        $this->db->from('user_company AS uc');
        $this->db->join('users AS u', 'uc.user_id = u.id', 'inner');
        $query = $this->db->get();
        return $query->row();
    }
    
    function getUserById($id){
        $this->db->where('id',$id);
        $query = $this->db->get('users');
        return $query->row_array();
    }
    
    function getAllUser(){
        $query = $this->db->get('users');
        return $query->result_array();
    }
    
    function update($id,$data) {
        $this->db->where('id',$id);
        return $this->db->update('users',$data);
    }
    
    function getUserBySearch($keyword) {
        if (!$keyword)
            return $this->getAllUser();
        $keyword = strtoupper ($keyword);     
            
        $sql = "select * from users 
                where UPPER(email) LIKE '%$keyword%'
                OR UPPER(firstname) LIKE '%$keyword%'
                OR UPPER(lastname) LIKE '%$keyword%'";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function getFavouriteCompanyIds($userId){
        $company_ids = array();
        $this->db->select('company_id');
        $this->db->where('user_id',$userId);
        $this->db->where('isMyFavourite',1);
        $query = $this->db->get('user_favourite_company');
        $results = $query->result_array();
        if(!empty($results)){
            foreach($results as $result){
                $company_ids[] = $result['company_id'];
            }
        }
        return $company_ids;
    }
    
    function getContactCompanyIds($userId){
        $company_ids = array();
        $this->db->select('company_id');
        $this->db->where('user_id',$userId);
        $this->db->where('isMyContact',1);
        $query = $this->db->get('user_contact_company');
        $results = $query->result_array();
        if(!empty($results)){
            foreach($results as $result){
                $company_ids[] = $result['company_id'];
            }
        }
        return $company_ids;
    }
    
    function getNetworkCompanyIds($userId){
        $company_ids = array();
        $this->db->select('company_id');
        $this->db->where('user_id',$userId);
        $this->db->where('isMyNetwork',1);
        $query = $this->db->get('user_network_company');
        $results = $query->result_array();
        if(!empty($results)){
            foreach($results as $result){
                $company_ids[] = $result['company_id'];
            }
        }
        return $company_ids;
    }
    
    function checkPassword($user_id, $password){
        $this->db->where('id',$user_id);
        $this->db->where('password',MD5($password));
        $query = $this->db->get('users',1);
        if($query->num_rows() == 1){
            return true;
        }
        return false;
    }
    
    function changePassword($user_id, $oldpassword, $newpassword){
        $this->db->where('id',$user_id);
        $this->db->where('password',MD5($oldpassword)); 
        $this->db->set('password',MD5($newpassword));
        $this->db->update('users');
    }
    
    /****************************/
    /*      Admin User Part     */
    /****************************/
    
    
    function getAdminById($id){
        $this->db->where('id',$id);
        $query = $this->db->get('admin_users');
        return $query->row_array();
    }
    
    function getAllAdmin(){
        $query = $this->db->get('admin_users');
        return $query->result_array();
    }
    
    /* Helman Code Started */
    function getSearchUser($role='',$keyword=''){
            $keyword = strtoupper ($keyword);

            // from user table
            $this->db->or_like('UPPER(users.firstname)',"{$keyword}");
            $this->db->or_like('UPPER(users.lastname)',"{$keyword}");

            // from company table
            $this->db->or_like('UPPER(company.city)',"{$keyword}");
            $this->db->or_like('UPPER(company.website)',"{$keyword}");
            $this->db->or_like('UPPER(company.info)',"{$keyword}");
            $this->db->or_like('UPPER(company.name)',"{$keyword}");

            $this->db->where('role',$role);

            $this->db->join('company','users.company_id=company.id');
            $res = $this->db->get('users');
            return $res->result();
    }
    /* Helman Code End */
    function changeRole($user_id, $role) {
        $this->db->where('id',$user_id);
        $this->db->set('role',$role);
        $this->db->update('users');
    }
}
?>