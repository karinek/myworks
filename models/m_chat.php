<?php
class M_chat extends CI_Model {
	function __construct(){
		// Call the Model constructor
		parent::__construct();
	}
	

	function initChat($user_from,$user_to,$company_id,$product_id,$product_type=''){	
//		$select="select c.id as chat_id from chat c inner join chat_users cu on cu.chat_id=c.id where c.user_id='$user_from' and c.company_id='$company_id' and c.product_id='$product_id' and cu.user_id='$user_to' and c.status='active' limit 1";
		$select="select c.id as chat_id from chat c inner join chat_users cu on cu.chat_id=c.id where c.user_id='$user_from' and cu.user_id='$user_to' and c.status='active' limit 1";
		
		$query = $this->db->query($select);

	   	$resArray=$query->result_array();
	
		if(!isset($resArray[0]['chat_id'])||!$resArray[0]['chat_id']){
			$data=array('user_id'=>$user_from,'company_id'=>$company_id,'product_id'=>$product_id,'ip_from'=>$_SERVER['REMOTE_ADDR'],'product_type'=>$product_type);	
			$this->db->insert('chat', $data);
			$chat_id = $this->db->insert_id();
			$data=array('user_id'=>$user_to,'chat_id'=>$chat_id);
			$this->db->insert('chat_users', $data);	
			return $chat_id;		
		}else{
			$data=array('product_id'=>$product_id,'company_id'=>$company_id,'product_type'=>$product_type);	
			$this->db->where('id', $resArray[0]['chat_id']);	
			$this->db->update('chat', $data);	
			return $resArray[0]['chat_id'];
		}		
	}
	
	function getStatus($chat_id){
		$this->db->where('id',intval($chat_id));
		$res = $this->db->get('chat');
		return $res->row();
	}
	
	function getChats($user_id){
		$sql="(select c.id,cu.user_id,c.company_id, c.product_id, c.product_type from chat c inner join chat_users cu on cu.chat_id=c.id where c.user_id='$user_id' and c.status='active') union(select c.id,c.user_id,c.company_id, c.product_id, c.product_type from chat c inner join chat_users cu on cu.chat_id=c.id where cu.user_id='$user_id' and c.user_id<>'$user_id' and c.status='active')";	
		
		$query = $this->db->query($sql);
       
        return $query->result_array();
		
	}
	
	function addMessage($user_from,$chat_id,$message){
		$data = array(
			'user_id'   =>  $user_from,
			'chat_id'   =>  $chat_id,
			'posts'=>$message,
			'posted'  =>  date("Y-m-d h:i:s"),
			'ip_from'=>$_SERVER['REMOTE_ADDR']
		);
		$this->db->insert('chat_messages', $data);
	}
	function markMessage($message_id){
		$data = array(
			'is_new'   =>  0);
		$this->db->update('chat_messages', $data,array('id'=>$message_id));
	}
	function closeChat($user_from,$chat_id){
		$data = array(
			'status'=>'close',
			'closed_by'   =>  $user_from);
		$this->db->update('chat', $data,array('id'=>$chat_id));
	}
	function getInfo($user_id,$chat_id,$datetype='DAY',$datevalue=1){
	
		$timewhere="(DAY(m.posted) = DAY(CURDATE()) AND MONTH(m.posted) = MONTH(CURDATE()) AND YEAR(m.posted) = YEAR(CURDATE()))";	
		
		
		$sqlCnt="
		select m.* FROM chat c 
				   inner join chat_messages m on m.chat_id=c.id 
				   inner join chat_users cu on cu.chat_id=c.id
        where m.is_new=1 and
		(c.user_id='$user_id' or cu.user_id='$user_id') and
		 c.id='$chat_id' and m.user_id<>$user_id  and
		date(m.posted) < CURDATE() order by m.posted";
		
	
		
		$query = $this->db->query($sqlCnt);
       
        $findOldNotReadRows=$query->result_array();
		
		if(!isset($findOldNotReadRows)||count($findOldNotReadRows)<=0){
			 $sql = "SELECT m.id,m.user_id as user_from,m.posted,m.posts as message,m.is_new FROM chat c inner join  chat_messages m on m.chat_id=c.id inner join chat_users cu on cu.chat_id=c.id WHERE $timewhere and (c.user_id='$user_id' or cu.user_id='$user_id') and c.id='$chat_id' ORDER BY m.posted ASC";
		}else{
			$sql = "SELECT m.id,m.user_id as user_from,m.posted,m.posts as message,m.is_new FROM chat c inner join  chat_messages m on m.chat_id=c.id inner join chat_users cu on cu.chat_id=c.id WHERE m.id>=".$findOldNotReadRows[0]['id']." and (c.user_id='$user_id' or cu.user_id='$user_id') and c.id='$chat_id' ORDER BY m.posted ASC";
		}			
						
        $query = $this->db->query($sql);
       
        return $query->result_array();
    }
	
	
	function getNewMessagesCount($user_id){
	
		$timewhere="(DAY(m.posted) = DAY(CURDATE()) AND MONTH(m.posted) = MONTH(CURDATE()) AND YEAR(m.posted) = YEAR(CURDATE()))";			$timewhere="1=1";		
        $sql = "SELECT count(m.id) as cnt,c.id as chat_id FROM chat c inner join  chat_messages m on m.chat_id=c.id inner join chat_users cu on cu.chat_id=c.id WHERE $timewhere and (c.user_id='$user_id' or cu.user_id='$user_id') and m.is_new='1' and m.user_id<>'$user_id' and c.status='active' group by c.id ORDER BY m.posted ASC";

        $query = $this->db->query($sql);
       
	    $cntGroups=$query->result_array();	
		
        return $cntGroups;
    }
	
	public function getCompanyOnlineUser($comp_id){
		 $sql = "SELECT u.user_id,u.company_id from user_company u inner join user_online un on un.user_id=u.user_id and u.company_id=$comp_id and un.status='free' limit 1";
		
		 $query = $this->db->query($sql);
       
        if($query->num_rows() > 0){
			foreach ($query->result_array() as $row){
				return $row;
			}
		}else return false;
	}
	
	 function getUserById($id){ 
	 
	 	$sql="select u.*,if(un.status is null,'offline',un.status) from users u left join user_online un on un.user_id=u.id where u.id='$id'";
	      
        $query = $this->db->query($sql);
		 
		 if($query->num_rows() > 0){
			foreach ($query->result_array() as $row){
				return $row;
			}
		}else return false;
    }
		
	
	function getUsersToByChatId($user_from_id,$chat_id)
	{
		$usersto=array();
		$sql="select user_id from chat_users where chat_id='$chat_id'";
		$query = $this->db->query($sql);
		if($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				if($row['user_id']!=$user_from_id)
				{
					$usersto=$this->getUserById($row['user_id']);
				}
			}
		}
		$sql="select user_id from chat where id='$chat_id'";
		$query = $this->db->query($sql);
		$main_user=$query->row_array();
		if(isset($main_user['user_id'])&&$main_user['user_id']!=$user_from_id)
			$usersto=$this->getUserById($main_user['user_id']);
		return $usersto;
	}
	
}
?>