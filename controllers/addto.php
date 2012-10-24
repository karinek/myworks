<?php
    class Addto extends CI_Controller{
        public function index(){
            
        }
        public function watchList(){
			$this->load->helper(array('url','form'));
            $id = $_POST['data1'];
            $this->load->library('session');
            $user_id = $this->session->userdata('user_id');
	    
			if($user_id != false){
				$this->load->model('M_addTo');
				$this->load->model('M_encrypt');
				$id = $this->M_encrypt->decode($id);
				if($this->M_addTo->addToWatchList($id,$user_id)){
                    $this->session->unset_userdata('watchlist');
                    $this->load->view('modules/product/watchlist/index', array('already_exists'=>false));
                } else {
                    $this->load->view('modules/product/watchlist/index', array('already_exists'=>true));
                }
            }
            else
                $this->load->view('modules/product/login');
        }
// move to user/watchlist
/*
        public function myWatchlist(){
                $this->load->helper(array('form'));
                
		$this->load->model(array('m_session','m_category','m_country','M_optionBusinessType'));
                $this->load->model('M_session','',True);
                $this->load->model('M_addTo');
                $this->load->model('M_product');
                $user_id = $this->M_session->getUserID();
                $data['layout'] = 'watchlist';
                $data['myWatchList'] = $this->M_addTo->myWatchList($user_id);
		$data['products'] = $this->M_product->getInfoByIdArray($data['myWatchList']);
		$data['modules'] = array(
			'login' => 1,
			'category-menu' => 1,
			'top-menu' => 1
		);
                $data['categories'] = $this->m_category->getCategories();
                $data['countries'] = $this->m_country->getAllCountryName();
                $data['businessType'] = $this->M_optionBusinessType->getBusinessTypes();
		$data['content'] = $this->load->view('modules/user/watchlist',$data,true);
		$this->load->view('template', $data);
        }
*/
    }
