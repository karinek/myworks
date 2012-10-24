<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_forum extends CI_Model {
	var $point_reply = 2;
	var $point_topic = 10;
	var $point_like = 50;
	var $point_dislike = -50;
	var $point_spam = -100;
	var $point_delete = -30;
	var $per_page_records = 10;
	var $forum_page = 1;

	function __construct(){
		parent::__construct();
	}
	
	private $fields = array(
		'topic' => array(
			'id', 'cat_id', 'subject', 'content', 'notify', 'notify_option', 'last_comment_id', 'cdate', 'mdate', 'user_id'
		),
		'comment' => array(
			'id', 'topic_id', 'subject', 'content', 'cdate', 'mdate', 'user_id'
		),
		'user' => array(
			'user_id', 'username', 'point', 'rank', 'avatar', 'signature', 'status', 'topics', 'replies', 'watchlists'
		)
	);
	
	protected function validate($action,$params){
		$fields = array();		
		foreach($this->fields[$action] as $field){
			if(isset($params[$field])) $fields[$field] = $params[$field];
		}
		return $fields;
	}
	
	/*  */
	function get($action = '', $params = array(),$options = array()){
		$table = '';
		switch($action){
			case 'group':
			case 'category':
			case 'topic':
			case 'comment':
			case 'user':
				$table = "forum_{$action}";
			break;
			case 'company':
				$table = "{$action}";
			break;
			case 'user_complete':
				$table = "forum_user";
				$this->db->select('users.*, users.id id, forum_user.*, forum_user.user_id user_id, user_company.*');
				$this->db->join('users','users.id=forum_user.user_id','inner');
				$this->db->join('user_company', 'users.id=user_company.user_id', 'inner');
//				$this->db->join('company', 'company.id=user_company.company_id', 'inner');
//				$this->db->join('company','company.id=users.company_id','left');
			break;
			default:
				return false;
			break;
		}
		
		if(count($params) && is_array($params)){
			foreach($params as $key => $value){
				$this->db->where($table.'.'.mysql_escape_string($key),mysql_escape_string($value));
			}
		}
		
		$limit = isset($options['limit']) ? intval($options['limit']) : $this->m_forum->per_page_records;
		$start = isset($options['start']) ? intval($options['start']) : 0;
		$order = isset($options['order']) ? $options['order'] : 0;
        if (!empty($order))
            $this->db->order_by($order);
			
		$this->db->limit($limit, $start);
		
		$res = $this->db->get($table);

		return $res->result();
	}
	
	/*  */
	function add($action = '', $params = array()){
		$data = array('status' => false);
		$table = '';
		switch($action){
			case 'group':
			case 'category':
			break;
			case 'topic':
			case 'comment':
				$table = "forum_{$action}";
				$params['cdate'] = $params['mdate'] = $this->m_misc->getTimestamp();
				$fields = $this->validate($action,$params);
				$data['status'] = $this->db->insert($table,$fields);
				$data['insert_id'] = $this->db->insert_id();
				$this->updateStatistic($action,'add',$data['insert_id'],0,$params['user_id']);
			break;
			case 'user':
				$table = "forum_{$action}";
				$params['cdate'] = $params['mdate'] = $this->m_misc->getTimestamp();
				$fields = $this->validate($action,$params);
				$data['status'] = $this->db->insert($table,$fields);
				$data['insert_id'] = $this->db->insert_id();
			break;
			default:
				return false;
			break;
		}
		return $data;
	}
	
	/*  */
	function updateStatistic($action,$task,$id,$id2=0,$user_id = NULL){
		$table = '';
		$where = array();
		switch($action){
			case 'user':
				$user = $this->get('user',array('user_id'=>$id));
				if(count($user) && is_array($user)){
					$where = array('user_id'=>$user[0]->user_id);
					switch($task){
						case 'reply':
							$this->db->update('forum_user',array('replies' => $user[0]->replies+1, 'point' => $user[0]->point + $this->point_reply),$where);
						break;
						case 'topic':
							$this->db->update('forum_user',array('topics' => $user[0]->topics+1, 'point' => $user[0]->point + $this->point_topic),$where);
						break;
						case 'like':
							$this->db->update('forum_user',array('like' => $user[0]->like+1, 'point' => $user[0]->point + $this->point_like),$where);
						break;
						case 'dislike':
							$this->db->update('forum_user',array('dislike' => $user[0]->dislike+1, 'point' => $user[0]->point + $this->point_dislike),$where);
						break;
					}
				}
			break;
			case 'group':
			break;
			case 'category':
				$category = $this->get('category',array('id'=>$id));
				if(count($category) && is_array($category)){
					$where = array('id'=>$category[0]->id);
					switch($task){
						case 'reply':
							$this->db->update('forum_category',array('replies' => $category[0]->replies+1),$where);
						break;
						case 'topic':
							$this->db->update('forum_category',array('topics' => $category[0]->topics+1, 'last_topic_id' => $id2),$where);
						break;
					}
				}
			break;
			case 'topic':
				$topic = $this->get('topic',array('id'=>$id));
				if(count($topic) && is_array($topic)){
					$where = array('id'=>$topic[0]->id);
					switch($task){
						case 'add':
							$this->updateStatistic('category','topic',$topic[0]->cat_id,$id);
							$this->updateStatistic('user','topic',$user_id,$topic[0]->id);
						break;
						case 'reply':
							$this->db->update('forum_topic',array('replies' => $topic[0]->replies+1,'last_comment_id' => $id2),$where);
							$this->updateStatistic('category','reply',$topic[0]->cat_id);
						break;
						case 'view':
							$this->db->update('forum_topic',array('views' => $topic[0]->views+1),$where);
						break;
						case 'like':
							$this->db->update('forum_topic',array('like' => $topic[0]->like+1),$where);
						break;
						case 'dislike':
							$this->db->update('forum_topic',array('dislike' => $topic[0]->dislike+1),$where);
						break;
					}
				}
			break;
			case 'comment':
				$comment = $this->get('comment',array('id'=>$id));
				if(count($comment) && is_array($comment)){
					switch($task){
						case 'add':
							$this->updateStatistic('topic','reply',$comment[0]->topic_id,$id);
							$this->updateStatistic('user','reply',$user_id,$comment[0]->id);
						break;
					}
				}
			break;
			case 'user':
				$table = "forum_{$action}";
			break;
			default:
				return false;
			break;
		}
	}
	
	/*  */
	function update($action,$params,$data){
		$table = '';
		switch($action){
			case 'group':
			case 'category':
			case 'topic':
			case 'comment':
			case 'user':
				$table = "forum_{$action}";
			break;
			default:
				return false;
			break;
		}
		if(count($params) && is_array($params)){
			foreach($params as $key => $value){
				$this->db->where(mysql_escape_string($key),mysql_escape_string($value));
			}
		}
		$res = $this->db->update($table, $data);
	}
	
	/*  */
	function search($params = array(), $options = array()){
        
		$table = "forum_topic";
		
		$total = 0;
		{ // pagination
			if (!empty($params['cat_id']))
				$this->db->where('cat_id',$params['cat_id']);
				
			$params['q'] = mysql_escape_string($params['q']);
			$this->db->where('( subject LIKE \'%'.$params['q'].'%\' OR content LIKE \'%'.$params['q'].'%\')');
			$this->db->select('count(*) total_rows');
			$res = $this->db->get($table);
			$res = $res->result();
			if(!empty($res))$total = $res[0]->total_rows;
		}
        if (!empty($params['cat_id']))
		    $this->db->where('cat_id',$params['cat_id']);
            
		$params['q'] = mysql_escape_string($params['q']);
		$this->db->where('( subject LIKE \'%'.$params['q'].'%\' OR content LIKE \'%'.$params['q'].'%\')');
		
		$start = isset($options['start']) ? intval($options['start']) : 0;
		$limit = isset($options['limit']) ? intval($options['limit']) : $this->m_forum->per_page_records;
		
		$this->db->limit($limit, $start);
		
		$res = $this->db->get($table);
		
		return array('result'=>$res->result(),'page'=>array('total'=>$total));
	}
	
	/*  */
	function getTopicCount($cat_id=0){
		$cat_id = intval($cat_id);
		if($cat_id){
			$this->db->where('id',$cat_id);
		}
		$this->db->select('SUM(topics) AS topics');
		$this->db->select('SUM(replies) AS replies');
		$res = $this->db->get('forum_category');
		return $res->row();
	}
	
	/*  */
	function viewTopic($session_id=0,$user_id=0,$topic_id=0){
		$this->db->where("user_id",$user_id);
		$this->db->where("session_id",$session_id);
		$this->db->where("topic_id",$topic_id);
		$query = $this->db->get('forum_topic_viewed');
		if ($query->num_rows()<1 && $topic_id!=0){
			$data = array(
				'user_id' => $user_id,
				'session_id' => $session_id,
				'topic_id' => $topic_id,
				'time' => date("Y-m-d h:i:s")
			);
			$this->db->insert('forum_topic_viewed', $data);
			$this->updateStatistic('topic','view',$topic_id);
		}
	}
	
	/*  */
	function doRanking(){
		$this->db->order_by('point','desc');
		$this->db->order_by('like','desc');
		$this->db->order_by('topics','desc');
		$this->db->order_by('replies','desc');
		$this->db->order_by('dislike','asc');
		$res = $this->db->get('forum_user');
		$n = $res->num_rows();
		$rows = $res->result();
		$sql = array();
		for($i = 0;$i<$n;$i++){
			$sql[] = array(
				'user_id' => $rows[$i]->user_id,
				'rank' => $i+1
			);//"UPDATE forum_user SET rank=".($i+1)." WHERE user_id=".$rows[$i]->user_id;
//			$sql[] = "UPDATE forum_user SET rank=".($i+1)." WHERE user_id=".$rows[$i]->user_id;
		}
		if(!empty($sql))$this->db->update_batch('forum_user',$sql,'user_id');
//		if(!empty($sql))$this->db->query(implode(';',$sql).';');
	}
}
?>