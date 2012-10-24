<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_invite extends CI_Model {
	var $db3 = null;
	
	var $config_db3	= array();
	
	function __construct(){
		parent::__construct();
				
		$this->config_db3['hostname'] = "31.222.163.77";
		$this->config_db3['username'] = "mediax";
		$this->config_db3['password'] = "5ydn3y123";
		$this->config_db3['database'] = "tradeoffice_beta";
		$this->config_db3['dbdriver'] = "mysql";
		$this->config_db3['dbprefix'] = "";
		$this->config_db3['pconnect'] = false;
		$this->config_db3['db_debug'] = TRUE;
		$this->config_db3['cache_on'] = FALSE;
		$this->config_db3['cachedir'] = "";
		$this->config_db3['char_set'] = 'utf8';
		$this->config_db3['dbcollat'] = 'utf8_general_ci';
		$this->config_db3['swap_pre'] = '';
		$this->config_db3['autoinit'] = TRUE;
		$this->config_db3['stricton'] = FALSE;
		
		if(!$this->db3)
			$this->db3 = $this->load->database($this->config_db3,true);
	}
	
	function insert ($data) {
		$this->db3->insert('invite_list',$data);
		return  $this->db3->insert_id();
	}
}

?>