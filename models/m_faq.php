<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_faq extends CI_Model {
        
	function __construct(){
		parent::__construct();
	}
        
        public  $faq_num = 6;
        public  $faq_page = 1;
        private $table_name = 'faqs';
        private $types = array('buying', 'selling', 'security', 'accounts');
	
	/*  */
	public function getList($type = '', $keyword = ''){
                $start = ($this->faq_page - 1) * $this->faq_num;
                $this->faq_page = 1;
                
                $this->db->select('SQL_CALC_FOUND_ROWS faqs.*', FALSE);
                if($type != '' && in_array($type, $this->types))
                    $this->db->where('qtype', $type);
                if($keyword != '') {
                    $this->db->or_like('question', $keyword);
                    $this->db->or_like('answer', $keyword);
                }
                $this->db->order_by("update_date DESC");
                $this->db->limit($this->faq_num, $start);
                $res = $this->db->get($this->table_name);
                $results = $res->result();
                
                $this->db->select('FOUND_ROWS() AS num_rows', FALSE);
                $res = $this->db->get();
                $total_rows = $res->row()->num_rows;
                
                return array('pagination'=>array('rows'=>$total_rows,'page'=>ceil($total_rows/$this->faq_num)),'result'=>$results);
	}
	
	/*  */
	public function get($id){
                if(!isset($id)) return array();
                $result = array();
                $this->db->where('id', $id);
                $query = $this->db->get($this->table_name);
                if($query->num_rows > 0)
                    $result = $query->row();
                
                return $result;
	}
	
}
?>