<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

    public function index(){
        $this->load->helper(array('url','form','date'));
        $this->load->model('M_session','',True);
        
        $admin_id = $this->M_session->is_auth_support();
        $this->load->model('M_user','',True);
        $this->M_user->getAdminById($admin_id);
        
        $keyword = $this->input->post('keyword'); 
        $data['users'] = $this->M_user->getUserBySearch($keyword);
         
        $this->load->view('admin/modules/user/index',$data);
    }
    
    
    public function edit(){
        $this->load->helper(array('url','form'));
        $this->load->model('M_user','',True);
        $this->load->model('M_country','',True);
        $this->load->model('M_session','',True);
        $this->M_session->is_auth_support();
        
        $user_id = $this->uri->segment(4);
        $data = $this->M_user->getUserById($user_id);
        if($data['role'] == 'both'){
            $data['role1'] = TRUE;
            $data['role2'] = TRUE;
        } else if ($data['role'] == 'buyer'){
            $data['role1'] = TRUE;
            $data['role2'] = FALSE;
        } else {
            $data['role1'] = FALSE;
            $data['role2'] = TRUE;
        }
        $data['country_options'] = $this->M_country->getAllCountryOptions();
        $data['status_options'] = array(
                            'pending' => 'pending',
                            'actived' => 'actived',
                            'banned' => 'banned'
        );
        $data['membership_options'] = array(
                            'N' => 'No',
                            'Y' => 'Yes'
        );
        $data['hidden'] = array('user_id' => $user_id);
        
        if ($data['is_tradepass'] == 'Y') {
            $this->load->model('M_membership','',True);
            $data['membership'] = $this->M_membership->get($user_id);
        } else {
            $data['membership']['start_date'] = "null";
            $data['membership']['end_date'] = "null";
        }
        $this->load->view('admin/modules/user/edit_view',$data);
         
    }
    
    public function do_edit(){
        $this->load->helper('url');
        $status = $this->input->post('status');
        $membership = $this->input->post('membership');
        $user_id = $this->input->post('user_id');
        

        
        $data = array(
	    'location' => $this->input->post('location'),
	    'firstname'	=> $this->input->post('firstname'),
            'lastname'	=> $this->input->post('lastname'),
	    'company'	=> $this->input->post('company'),
	    'phone_country' => $this->input->post('phone_country'),
	    'phone_area' => $this->input->post('phone_area'),
	    'phone_number' => $this->input->post('phone_number'),
            'status' => $status,
            'is_tradepass' => $membership[0],
            'is_assessed' => $membership[1]
	);
	if($this->input->post('role1') && $this->input->post('role2')){
	    $data['role'] = 'both';
	} else {
	    $data['role'] = $this->input->post('role1').$this->input->post('role2');
        }
        
        $this->load->model('M_user','',True);
        $this->M_user->update($user_id,$data);
        
        //es em pakel
//        if($membership == 'Y')
//            $this->_update_tradepass($user_id);                
        if ($status == "banned")
            $this->_ban_comapny_by_user($user_id);
        redirect('admin/user');
    }
    
//    function _update_tradepass($user_id){
//        
//        $data = array(
//                      'start_date' => $this->input->post('membership_start'),
//                      'end_date' => $this->input->post('membership_end')
//                      );
//        $this->load->model('M_membership','',True);
//        $this->M_membership->update($user_id,$data);
//        
//    }
    
    function _ban_comapny_by_user($user_id) {
        $this->load->model('M_user','',True);
        $company_id = $this->M_user->getCompanyByUser($user_id);
        
        $data = array('status' => 'banned');
        $this->load->model('M_company','',True);
        $this->M_company->update($company_id,$data);
    }
}
?>