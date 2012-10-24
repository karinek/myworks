<?php
class M_session extends CI_Model {
    function __construct(){
        // Call the Model constructor
        parent::__construct();
        $this->load->library('session');
    }
	public function isLogin(){	
		
        $user_id = $this->session->userdata('user_id');
		
       	$this->refreshOnlineUsers();
        if ($user_id){		
			$this->setOnLine($user_id);			
			return $user_id;
		}		 
        else return false;
	}
	public function setOffLine($user_id){
	
		$this->db->query("update user_online set status='offline', last_checked_time=NOW() where user_id='$user_id'");
	}
	public function setOnLine($user_id){
		
		$sql="select count(*) as cnt from  user_online  where user_id='$user_id'";		
	      
        $query = $this->db->query($sql);
		 
		$cntArray=$query->row_array();
		
        if($cntArray['cnt']>1){
			$this->db->query("delete from user_online where user_id='$user_id'");
			$this->db->insert('user_online', array('user_id'=>$user_id));
		
		}elseif($cntArray['cnt']>0){
			$this->db->query("update user_online set status='free', last_checked_time=NOW() where user_id='$user_id'");
		
//			$this->db->query("delete from user_online where user_id='$user_id'");
		}else{
			$this->db->insert('user_online', array('user_id'=>$user_id));
		}
	}
	
	public function refreshOnlineUsers(){
		 //$this->db->query("update user_online set status='away', last_checked_time=NOW() where last_checked_time<=date_sub(NOW(),INTERVAL 10 MINUTE) and status!='offline'"); 
	}
	
    public function getUserID(){
        $this->load->library('session');
        $user_id = $this->session->userdata('user_id');
        if ($user_id)
            return $user_id;
        else{
            $this->load->helper('url');
            $this->session->set_userdata('previous_url',$this->full_url());//uri_string());
            redirect('login');
        }
    }
    
    public function is_auth_support(){
        $this->load->library('session');
        $admin_id = $this->session->userdata('admin_id');
        if ($admin_id)
            return $admin_id;
        else{
            redirect('admin/login');
        }
    }
    function getInboxCount($user_id)
    {
           $getInboxcount = $this->db->select('*')
                ->from('message')
                ->join('message_from_to', 'message_from_to.id = message.message_id')
                     ->join('message_trash', 'message_trash.message_id = message.id')  
                ->where('message_trash.user_id',$user_id)
                ->where('message_from_to.to_user_id', $user_id)
                ->where('message_trash.trash !=', 1)
                ->get();
        return $getInboxcount->num_rows();
    }
    
    function getWatchListCount($user_id){
        if(!$user_id) return false;
        $this->load->library('session');
        
            $result = '';
            $this->db->select('COUNT(*) AS ct');
            $this->db->where('user_id', $user_id);
            $res = $this->db->get('users_watchlist');
            $result = $res->row();
            $this->session->set_userdata('watchlist',$result->ct);
            return $result->ct;
        
    }
    
    function full_url(){
            $ci=& get_instance();
            $return = $ci->config->site_url().$ci->uri->uri_string();
            if(count($_GET) > 0){
                    $get =  array();
                    foreach($_GET as $key => $val){
                            $get[] = $key.'='.$val;
                    }
                    $return .= '?'.implode('&',$get);
            }
            return $return;
    } 
}
?>