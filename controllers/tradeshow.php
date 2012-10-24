<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tradeshow extends CI_Controller {
    public function index($id = 0)
	{
//        $this->db->where('trade_id',$id);
//        $query = $this->db->get('tradeshows',1);
//        if ($query->num_rows()==1){
//          $tradeshows = $query->row();
//          
//          $data['tradeshows'] = $tradeshows;
          $this->load->helper(array('form'));
          $this->load->library('session');
          $this->load->model(array('m_session','m_category','m_country','M_company', 'm_tradeshow'));
          $template['modules'] = array(
			'login' => 1,
			'category-menu' => 1,
			'top-menu' => 1
		);
          $template['layout'] = 'company';
          $data = array();
          $data['tradeshows'] = $this->m_tradeshow->getAll();
          
          $template['categories'] = $this->m_category->getCategories();
          $template['countries'] = $this->m_country->getAllCountryName();
          $template['business_type_options'] = $this->M_company->getAllBusinessType();
          
	  $template['content'] = $this->load->view('pages/tradeshow',$data,true);
	   $this->load->view('template', $template);
//        }
	}
}








