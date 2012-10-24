<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_sugar extends CI_Model {
	private $fields = array(
		'accounts' => array('id','name','data_entered','date_modified','description','deleted','account_type','industry','annual_revenue','phone_fax','billing_address_street','billing_address_city','billing_address_state','billing_address_postalcode','billing_address_country','rating','phone_office','phone_alternate','website','ownership','employees','ticker_symbol','shipping_Address_street','shipping_address_city','shipping_address_State','shipping_address_postalcode','shipping_address_country','email1','sic_code','member_id_c','last_login_c','firstname_c','lastname_c','ip_address_c','detail_link_c','user_status_c','company_status_c','region_c','origin_c','business_type_c','role_c'),
		'audits' => 'id 	parent_id 	date_created 	created_by 	field_name 	data_type 	before_value_string 	after_value_string 	before_value_text 	after_value_text'
	);
	private $map = array(
		'user' => array(
			'sugar_id' => 'id',
			'location' => 'origin_c',
			'firstname'	=> 'firstname_c',
			'lastname' => 'lastname_c',
			'company' => 'name',
			'phone_office' => 'phone_office',
			'member_id' => 'member_id_c',
			'email'	=> 'email1',
			'status' => 'user_status_c',
			'create_date' => 'data_entered',
			'role' => 'role_c',
			'last_login_date' => 'last_login_c',
			'last_ip' => 'ip_address_c'
		),
		'company' => array(
			'sugar_id'			=> 'id',
			'name'				=> 'name',
			'address'			=> 'billing_address_street',
			'city'				=> 'billing_address_city',
			'state'				=> 'billing_address_state',
			'country'			=> 'billing_address_country',
			'zip'				=> 'billing_address_postalcode',
			'business_type'	=> 'business_type_c',
			'no_employee'       => 'employees',
			'annual_sale'       => 'annual_revenue',
			'region'			=> 'region_c',
			'website'	        => 'website'
		)
	);
	
	var $db2 = null;

	var $config_db2	= array();
	
	function __construct(){
		parent::__construct();
		$this->load->library('SugarRest');

		$this->config_db2['hostname'] = "31.222.163.77";
		$this->config_db2['username'] = "mediax";
		$this->config_db2['password'] = "5ydn3y123";
		$this->config_db2['database'] = "tradeoffice_crm";
		$this->config_db2['dbdriver'] = "mysql";
		$this->config_db2['dbprefix'] = "";
		$this->config_db2['pconnect'] = false;
		$this->config_db2['db_debug'] = TRUE;
		$this->config_db2['cache_on'] = FALSE;
		$this->config_db2['cachedir'] = "";
		$this->config_db2['char_set'] = 'utf8';
		$this->config_db2['dbcollat'] = 'utf8_general_ci';
		$this->config_db2['swap_pre'] = '';
		$this->config_db2['autoinit'] = TRUE;
		$this->config_db2['stricton'] = FALSE;
		
	}
	
	protected function mapFields($source = '', $data = array()){
		$fields = array();
		switch($source){
			case 'user':
				$data['phone_office'] = $data['phone_country'] . $data['phone_area'] . $data['phone_number'];
//				$data['company'] = $data['firstname'];
			break;
			case 'company':
				$data['business_type'] = '^'.str_replace('|','^,^',$data['business_type']).'^';
				$data['region'] = '^'.str_replace('|','^,^',$data['region']).'^';
			break;
		}
		foreach($data as $key => $value){
			if(isset($this->map[$source][$key])){
				$fields[$this->map[$source][$key]] = $value;
			}
		}
		return $fields;
	}
	
	protected function validate($action,$params){
		$fields = array();		
		foreach($this->fields[$action] as $field){
			if(isset($params[$field])) $fields[$field] = $params[$field];
		}
		return $fields;
	}
	
	function setUserToSugar($id=0,$field='id'){
		$this->db->where($field,$id);
		$res = $this->db->get('users',1);
		$users = $res->result();
		$data = array('status' => false, 'result' => array());
		if(count($users) && is_array($users)){
			$user = (array) $users[0];
			if(!isset($user['member_id']) || $user['member_id']=='') $user['member_id'] = $user['id'];
			if(isset($user['sugar_id'])) unset($user['company']);
			$data['result'][] = $sugar = $this->setRegisteredUser('user',$user);
			if(isset($sugar['id'])){
				$this->db->where('id',$user['id']);
				$this->db->set('sugar_id',$sugar['id']);
				$this->db->update('users');
				$data['status'] = $this->db->affected_rows() ? true : false;
			}
		}
		return $data;
	}
	
	function setCompanyToSugar($cid=0,$uid){
		$this->db->where('id',intval($cid));
		$res = $this->db->get('company',1);
		$companies = $res->result();

		$this->db->where('id',intval($uid));
		$res = $this->db->get('users',1);
		$users = $res->result();
		
		$data = array('status' => false, 'result' => array());
		$sugar_id = '';
		if(count($users) && is_array($users)){
			$sugar_id = $users[0]->sugar_id;
		}
		if(count($companies) && is_array($companies)){
			$company = (array) $companies[0];
			$company['sugar_id'] = $sugar_id;
			$data['result'][] = $sugar = $this->setRegisteredUser('company', $company);
		}
		return $data;
	}
	
	function setRegisteredUser($map = 'user',$params = array()){
		$data =& $this->mapFields($map,$params);
		$valid_fields =& $this->validate('accounts',$data);
		return $this->sugarrest->set('Accounts',$valid_fields);
	}

	function getRegisteredUser($params = array()){
		$valid_fields =& $this->validate('accounts',$params);
		return $this->sugarrest->get('Accounts',$this->fields['accounts'],array('where'=>'id=\''.$params['id'].'\''));
	}
	
	function getLoginHistory($id=''){
		if(!$this->db2) $this->db2 = $this->load->database($this->config_db2,true);
		
		$sql = "SELECT accounts_audit . * , users.user_name FROM accounts_audit, users";
		$sql .= " WHERE accounts_audit.created_by = users.id AND field_name IN ('last_login_c','ip_address_c')";
		$sql .= " AND accounts_audit.parent_id = '{$id}'";
		$sql .= " ORDER BY accounts_audit.date_created DESC";

		$res = $this->db2->query($sql);
		return $res->result();
//		$valid_fields =& $this->validate('accounts',$params);
//		return $this->sugarrest->get('Accounts',$this->fields['accounts'],array('where'=>'id=\''.$params['id'].'\''));
	}
	
	function importRegisteredUsers(){
		$this->db->where('sugar_id is NULL');
		$res = $this->db->get('users');
		$users = $res->result();
		$data = array('result' => array());
		if(count($users) && is_array($users)){
			foreach($users as $user){
				$user = (array) $user;
				if(!isset($user['member_id']) || $user['member_id']=='') $user['member_id'] = $user['id'];
				$data['result'][] = $sugar = $this->setRegisteredUser('user',$user);
				if(isset($sugar['id'])){
					$this->db->where('id',$user['id']);
					$this->db->set('sugar_id',$sugar['id']);
					$this->db->update('users');
					$data['status'] = $this->db->affected_rows() ? true : false;
				}
			}
		}
		return $data;
	}
}

?>