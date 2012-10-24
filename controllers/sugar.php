<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sugar extends CI_Controller {
	
	function index(){
		show_404();
	}
	
	function get(){
		$this->load->model(array('m_user','m_sugar'));
		
		print_r($this->m_sugar->getRegisteredUser());
	}
	
	function import(){
		$this->load->model(array('m_user','m_sugar'));
		echo $this->m_sugar->importRegisteredUsers();
	}
	
	function loginhistory(){
		$this->load->model(array('m_user','m_sugar','m_geoip'));
		echo "<pre>";
		$histories = $this->m_sugar->getLoginHistory($this->input->get('record'));
		$items = array();
		
		$last_ip = '';
		$last_location = '';
		$n_hist = count($histories);
		for($i=0;$i<$n_hist;$i++){
			$item = array();
			if($histories[$i]->field_name == 'last_login_c' && $histories[$i]->after_value_string != ''){
				$item['login_time'] = $histories[$i]->after_value_string;
				if(isset($histories[$i+1]) && $histories[$i+1]->field_name == 'ip_address_c'){
					$i++;
					$item['login_ip'] = $last_ip = $histories[$i]->after_value_string;
					$country = $this->m_geoip->get($histories[$i]->after_value_string);
					if(count($country) && is_array($country))
						$item['login_location'] = $last_location = $country[0]->name;
					else $item['login_location'] = $last_location = $last_ip == '127.0.0.1' ? 'localhost' : $last_ip;
				}else if($last_ip == ''){
					for($j=$i+1;$j<$n_hist;$j++){
						if(isset($histories[$j]) && $histories[$j]->field_name == 'ip_address_c'){
							$item['login_ip'] = $last_ip = $histories[$j]->after_value_string;
							$country = $this->m_geoip->get($histories[$j]->after_value_string);
							if(count($country) && is_array($country))
								$item['login_location'] = $last_location = $country[0]->name;
							else $item['login_location'] = $last_location = $last_ip == '127.0.0.1' ? 'localhost' : $last_ip;
							// Exit from 2nd loop
							break;
						}
					}
				}else{
					$item['login_ip'] = $last_ip;
					$item['login_location'] = $last_location;
				}
				$items[] = $item;
			}
		}
		$this->load->view('modules/sugar/login-history',array('items'=>$items));
	}
}

?>