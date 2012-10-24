<?php
class M_helpdesk extends CI_Model {
	
	var $helpdesk_page = 1;
	var $helpdesk_num = 10;
	
    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }

    function getMessages(){

    	$this->db->select('COUNT(*) as num_row');
        $this->db->from('helpdesk_messages as hm');
        $this->db->join('helpdesk_sections AS hs', 'hs.section_id = hm.section_id', 'left');
        $query = $this->db->get();
        $this->db->last_query();
        $total_rows = $query->result();
        
        if(is_array($total_rows) && count($total_rows)){
        	$total_rows = $total_rows[0]->num_row;
        }else{
        	$total_rows = 0;
        }
        
        
        $start = ($this->offer_page - 1) * $this->offer_num;
        
        $this->db->select('hm.*,hs.name');
        $this->db->from('helpdesk_messages as hm');
        $this->db->join('helpdesk_sections AS hs', 'hs.section_id = hm.section_id', 'left');
        $this->db->limit($this->offer_num,$start);
        
        $query = $this->db->get();
        
        return array('pagination'=>array('rows'=>$total_rows,'page'=>ceil($total_rows/$this->offer_num)),'result'=>$query->result());        
    }
    
    function insertMessage($data) {
        return $this->db->insert('helpdesk_messages',$data);
    }
    
    function updateMessage($id,$data) {
        $this->db->where('id',$id);
        return $this->db->update('helpdesk_messages',$data);
        
    }
    
	function deleteMessage($id){
		$this->db->where('id',$id);
		return $this->db->delete('helpdesk_messages');
	} 

	function getSections(){
		$query = $this->db->get('helpdesk_sections');
		$result = $query->result_array();
		$sections = array();
		foreach ($result as $row){
			$sections[$row['section_id']]=$row['name'];
		}
		return $sections;
	}
	
	function insertSection($data) {
		return $this->db->insert('helpdesk_sections',$data);
	}
	
	function updateSection($id,$data) {
		$this->db->where('section_id',$id);
		return $this->db->update('helpdesk_sections',$data);
	
	}
	
	function deleteSection($id){
		$this->db->where('section_id',$id);
		return $this->db->delete('helpdesk_sections');
	}

	function getAnswerTemplates($section_id = null){
		if($section_id != null)
			$this->db->where('section_id',$section_id);
		
		$query = $this->db->get('helpdesk_answer_templates');
		return $query->result_array();
	}
	
	function insertTemplate($data) {
		return $this->db->insert('helpdesk_answer_templates',$data);
	}
	
	function updateTemplate($id,$data) {
		$this->db->where('id',$id);
		return $this->db->update('helpdesk_answer_templates',$data);
	
	}
	
	function deleteTemplate($id){
		$this->db->where('id',$id);
		return $this->db->delete('helpdesk_answer_templates');
	}	
}
?>