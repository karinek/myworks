<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_news extends CI_Model {
	function __counstruct(){
		parent::__construct();
	}

	var $news_page = 1;
	var $news_num = 12;
	
	function get($cid, $nid=0, $is_approve = false, $page=false){
		if(intval($cid) == 0) return false;

		if($page){
			if(intval($nid) != 0) $this->db->where('id',intval($nid));
			$this->db->where('company_id',intval($cid));
			$this->db->where('is_deleted',0);
			$this->db->select('count(*) as num_row');
			$res = $this->db->get('company_news');
			$total_rows = $res->result();
			
			if(is_array($total_rows) && count($total_rows)){
				$total_rows = $total_rows[0]->num_row;
			}

			$start = ($this->news_page - 1) * $this->news_num;

			$this->db->limit($this->news_num, $start);
			
			$this->news_page = 1;
		}

		if(intval($nid) != 0) $this->db->where('id',intval($nid));
		$this->db->where('company_id',intval($cid));
		$this->db->where('is_deleted',0);
		if($is_approve)
			$this->db->where('is_approve',1);
		$this->db->order_by('cdate','desc');
		$res = $this->db->get('company_news');
		
		if($page) return array('pagination'=>array('rows'=>$total_rows,'page'=>ceil($total_rows/$this->news_num)),'result'=>$res->result());
		else return $res->result();
	}
	
	function save($params){
		if(isset($params['id']) && intval($params['id'])!=0){
			$params['mdate'] = M_misc::getTimestamp();
			$this->db->where('id',$params['id']);
			$this->db->where('company_id',$params['company_id']);
			$this->db->update('company_news',$params);
			
			return $this->db->affected_rows() ? true : false;
		}else{
			$params['cdate'] = $params['mdate'] = M_misc::getTimestamp();
			$this->db->insert('company_news',$params);
			return $this->db->insert_id();
		}
	}
	
	function delete($cid=0, $nid=0){
		if(intval($nid)==0 || intval($cid)==0) return false;

		$this->db->where('id',intval($nid));
		$this->db->where('company_id',intval($cid));

		$this->db->set('is_deleted',1);

		$this->db->update('company_news');

		return $this->db->affected_rows() ? true : false;
	}
	
	function approve($params){
		$news = $this->get($params['company_id'],$params['id']);
		if(count($news) && is_array($news)){
			$this->db->where('id',intval($params['id']));
			$this->db->where('company_id',intval($params['company_id']));
			$this->db->set('is_approve',1);
			$this->db->update('company_news');

			return $this->db->affected_rows() ? true : false;
		}
	}
}
?>