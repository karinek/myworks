<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Myoffice extends CI_Controller {
	function __construct(){
		parent::__construct();

		$this->load->helper(array('form','url','html'));
		$this->load->library('session');
		$this->load->model(array('m_user','m_optionBusinessType','m_company','m_country','m_session','m_options'));
	}
	
	function index(){
		$user_id = $this->m_session->getUserID();
		
		$user = (object)$this->m_user->getUserById($user_id);
		
		$company = $this->m_company->getCompanyByUser($user_id);
		if(!count($company) || !is_array($company)){
			$template['content'] = $this->load->view('modules/company/error_no_company','', True);
			$template['modules'] = array(
				'login' => 1,
				'top-menu' => 1
			);
			$template['layout'] = 'company';
			$this->load->view('template', $template);
			return false;
		}
		$company = $company[0];
		
		$business_type = $this->db->get('option_business_type');
		$certification = $this->db->get('option_certification');
		$company_service = $this->db->get('option_company_service');
		$payment = $this->db->get('option_payment');
		$region = $this->db->get('option_region');
		$unit = $this->db->get('option_unit');
		
		$company_license = explode('|',$company->certification);
		$company->company_license = array();
		foreach($company_license as $key => $value){
			$this->db->where('id',$value);
			$res = $this->db->get('option_certification',1);
			$company->company_license[$key] = $res->result();
			if(count($company->company_license[$key]) && is_array($company->company_license[$key])){
				$company->company_license[$key] = $company->company_license[$key][0];//->name;
			}else unset($company->company_license[$key]);// = '';
		}

		$industry = explode('|',$company->service);
		$company->industry = array();
		foreach($industry as $key => $value){
			$this->db->where('id',$value);
			$res = $this->db->get('option_company_service',1);
			$company->industry[$key] = $res->result();
			if(count($company->industry[$key]) && is_array($company->industry[$key])){
				$company->industry[$key] = $company->industry[$key][0]->name;
			}else $company->industry[$key] = '';
		}

		$company->status = 'Operating';
		$company->company_size = M_options::getFactorySizeDetails($company->factory_size);
		if(is_array($company->company_size) && count($company->company_size))$company->company_size = $company->company_size[1];
		$company->acn_no = '';
		$company->purchase_volume = M_options::getAnnualPurchaseVolume($company->factory_purchase);
		if(is_array($company->purchase_volume) && count($company->purchase_volume))$company->purchase_volume = $company->purchase_volume[1];
		
		$region = explode('|',$company->region);
		$company->region = array();
		foreach($region as $key => $value){
			$this->db->where('id',$value);
			$res = $this->db->get('option_region',1);
			$company->region[$key] = $res->result();
			if(count($company->region[$key]) && is_array($company->region[$key])){
				$company->region[$key] = $company->region[$key][0]->name;
			}else $company->region[$key] = '';
		}
		
		$my_networks = $this->m_company->getNetworkCompanies($user_id);
		$my_networks = $my_networks['networks'];
		
		$contact = $this->m_company->getDefaultContact($company->id);
		if(!count($contact) || !is_array($contact)){
			$contact =& $user;
		}else{
			$contact = $contact[0];
		}

		$data = array(
			'my_netwroks' => &$my_networks,
			'my_company' => &$company,
			'my_contact' => &$contact,
			'my_user' => &$user,
		);

		$template['content'] = $this->load->view('modules/company/myoffice',$data,true);		
        $template['modules'] = array(
                'login' => 1,
                'top-menu' => 1
        );
        $template['layout'] = 'company';
        $this->load->view('template', $template);
	}
}
?>