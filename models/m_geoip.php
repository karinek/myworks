<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_geoip extends CI_Model {
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
	
	function ip2dec($ip){
		$_ip = explode('.',$ip);
		$des = $_ip[3] + $_ip[2] * 256 + $_ip[1] * 256 * 256 + $_ip[0] * 256 * 256 * 256;
		return $des;
	}
	
	function get($ip){
		$dec = $this->ip2dec($ip);
		
		if(!$this->db2) $this->db2 = $this->load->database($this->config_db2,true);

		$sql = "SELECT * FROM geoip_country WHERE ip_dec_start <= ".$dec." AND ip_dec_end >= ".$dec." ;";
		$res = $this->db2->query($sql);
		return $res->result();
	}
}

?>