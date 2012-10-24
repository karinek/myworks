<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company extends CI_Controller {

    public function index(){
        $this->load->helper(array('url','form','date'));
        $this->load->model('M_session','',True);
        
        $admin_id = $this->M_session->is_auth_support();
	$this->load->model('M_user','',True);
        $this->M_user->getAdminById($admin_id);
        
        $keyword = $this->input->post('keyword');
	$this->load->model('M_company','',True);
        $data['companies'] = $this->M_company->search($keyword);
         
        $this->load->view('admin/modules/company/index',$data);
    }
    
    public function edit(){
        $this->load->helper(array('form','url','html'));
        $this->load->model('M_session','',True);
       
        $admin_id = $this->M_session->is_auth_support();
	$this->load->model('M_user','',True);
        $this->M_user->getAdminById($admin_id);
	
	
	$company_id = $this->uri->segment(4);
	$this->load->model('M_company','',True);
	$data = $this->M_company->getCompanyById($company_id);

	$this->load->model('M_country','',True);
        $data['country_options'] = $this->M_country->getAllCountryOptions();
        $data['hidden'] = array(
				'company_id' => $company_id
				);
        $this->load->view('admin/modules/company/edit_view',$data);
    }
    
    public function do_updatecompany(){
        $this->load->helper('url');
        $this->load->model('M_company','',True);
        $this->load->model('M_user','',True);
        
        $data_company = array(
	    'name'      => $this->input->post('name'),
            'address'	=> $this->input->post('address'),
	    'city'	=> $this->input->post('city'),
            'state'	=> $this->input->post('state'),
	    'country'   => $this->input->post('country'),
            'zip'       => $this->input->post('zip'),
	    'tel'       => $this->input->post('tel'),
            'mobile'	=> $this->input->post('mobile'),
	    'website'	=> $this->input->post('website'),
            'info'	=> $this->input->post('info'),
        );
        $company_id = $this->input->post('company_id');

        $this->M_company->update($company_id,$data_company);
        redirect('admin/company');
    }
}
?>