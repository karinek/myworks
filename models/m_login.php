<?php

class M_login extends CI_Model {

   
    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }
    
    function login($email,$password){
     
        $this->db->where('email',$email);
        $this->db->where('password',MD5($password));
        $query = $this->db->get('users',1);
        if ($query->num_rows()==1){
            if($query->row()->status!='actived')
                return 'Account not verified';    
            
            $this->load->library('session');
            $this->session->set_userdata('user_id',$query->row()->id);
            //$this->session->userid = $query->row()->id;
           // $_SESSION['user_id'] = $query->row()->id;
            return $query->row()->id;
        }
        return 'Wrong Password';
    }
    
    function register($data){
        if (!$this->is_existed($data['email'])){
            $company['name'] = $data['company'];
            $this->db->insert('users',$data);
            $userCompany['user_id'] = $this->db->insert_id();
            $this->db->insert('company',$company);
            $userCompany['company_id'] = $this->db->insert_id();
            $userCompany['is_main'] = 1;
            $this->db->insert('user_company',$userCompany);
            
            $query = $this->db->get('users',1);
            $emailconfig['msg'] = 'Click the link below to activate your account   ' . anchor('register/verify/'.$data['verifycode'],' Confirmation Register ');
            $emailconfig['email'] = $data['email'];
            $emailconfig['subject'] = 'Registration Confirmation';
            $this->_send_email($emailconfig);
            
            $this->load->library('session');
            $this->session->set_userdata('username',$data['firstname']);
            return $userCompany['user_id'];
        } else {
            // msg tell user the email is existed
            return FALSE;
        }
        
    }

    function _send_email($emailconfig){
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtpout.asia.secureserver.net',
            'smtp_port' => 465,
            'smtp_user' => 'emailtest@tradeoffice.com',
            'smtp_pass' => '123456',
            'mailtype'  =>  'html'
        );
        $this->load->library('email', $config);
        $this->email->from('emailtest@tradeoffice.com', 'TradeOffice');
        $this->email->to($emailconfig['email']);
        $this->email->subject($emailconfig['subject']);
        $this->email->message($emailconfig['msg']);
        $this->email->send();
    }
    
    function is_existed($email){
        $this->db->where('email',$email);
        $query = $this->db->get('users',1);
        if ($query->num_rows()>0){
            return TRUE;
        }
        return FALSE;
    }
    
    function reset_password ($email) {
        $this->db->where('email',$email);
        $query = $this->db->get('users',1);
        if ($query->num_rows()==1){
            $tmp_password = random_string('alnum',32);
            $this->db->where('email',$email);
            $this->db->set('password',$tmp_password);
            $this->db->update('users');

            $emailconfig['msg'] = 'Click the link below to reset your password ' . anchor('login/new_password/'.$tmp_password,'reset password');
            $emailconfig['email'] = $email;
            $emailconfig['subject'] = 'Reset Password';
            $this->_send_email($emailconfig);
            return TRUE;
        }
        return FALSE;
    }
    
    function update_password($old_password,$new_password){
        $this->db->where('password',$old_password);
        $query = $this->db->get('users',1);
        if ($query->num_rows()==1){
            $this->db->where('password',$old_password);
            $this->db->set('password',MD5($new_password));
            $this->db->update('users');
            return TRUE;
        }
        return FALSE;        
    }
    
    function verify($code) {
        $this->db->select('id,location,status');
        $this->db->where('verifycode',$code);
        $query = $this->db->get('users',1);
        if ($query->num_rows()==1){
            $user = $query->row();
            if ($user->status == 'actived')
                return FALSE;
            $this->session->set_userdata('user_id',$user->id);
            
            $data = array(
                        'status'=>'actived',
                        'member_id' => $this->_createMemberID($user->location)
                          );
            
            $this->db->where('verifycode',$code);
            $this->db->update('users',$data);
           // var_dump("xcxc");exit;
            return TRUE;
        }
        return FALSE;
    }
    
    function login_admin($username,$password){
        $this->db->where('username',$username);
        $this->db->where('password',MD5($password));
        $query = $this->db->get('admin_users',1);
        if ($query->num_rows()==1){
            $this->load->library('session');
            $this->session->set_userdata('admin_id',$query->row()->id);
            return $query->row()->id;
        }
        return FALSE;
    }
    
    function addAdmin($data){
        $this->db->insert('admin_users',$data);
    }
    
    function editAdmin($id,$data){
        $this->db->where('id',$id);
        $this->db->update('admin_users',$data);
    }
    
    function _createMemberID($code){
        $sql = "select member_id
                from users
                where member_id LIKE '$code%'
                ";
        $query = $this->db->query($sql);
        $res =  $query->result_array();
        
        $res_array = array();
        foreach ($res as $val)
            $res_array[] = $val['member_id'];
        
        $tmp = $code.rand(100000,999999);
        while(in_array($tmp,$res_array))
            $tmp = $code.rand(100000,999999);
            
        return $tmp;
    }
}
?>