<?php
class M_subscribe extends CI_Model {
    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }
    function compareEmail($email){
         $this->db->where('email', $email);
         $res = $this->db->get('subscribe');
         if($res->num_rows() == 0)
             return TRUE;
         else 
             return FALSE;
    }
    function compareHash($hash){
         $this->db->where('hash', $hash);
         $res = $this->db->get('subscribe');
         if($res->num_rows() != 0)
             return TRUE;
         else 
             return FALSE;
    }
    function save($name){
        if($this->compareEmail($name)){
            $hash = hash('md5', $name)  ;
            $data = array(
                'email' => $name,
                'hash' => $hash
            );
            $this->db->insert('subscribe',$data);
            return $hash;
        }
        else{
            return FALSE;
        }
    }
    function unsubscribe($hash){
        if($this->compareHash($hash)){
            $this->db->where('hash', $hash);
            $this->db->delete('subscribe');
            return TRUE;
        }
        return FALSE;
    }
}