<?php
class M_currency extends CI_Model {

   
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    public function getAllCurrency(){
		$this->db->select('name');
		$query = $this->db->get('currency');
                $data[''] = '--- Select Currency ---';
		foreach($query->result() as $row)
		{
		 $data[$row->name] = $row->name;     
		}
	return $data;		    
    }
    
    public function load() {
        $this->db->select(array('symbol', 'rate', 'inverse'));
        $query = $this->db->get('currency_rate');
		$data = array();
        foreach($query->result() as $row){
			$data[$row->symbol] = $row;     
        }
        return $data;
    }
    
    function update($xmldata){
		if(!count($xmldata->currency)) return false;

		// Clearing currency table
		$this->clear();

		$sql = "INSERT INTO currency_rate (symbol,name,rate,inverse) VALUES ";
		$sql_values = array();
		foreach ($xmldata->currency as $key => $value) {
			$_sql = "(";
			$_sql .= "'".mysql_escape_string($value->csymbol)."',";
			$_sql .= "'".mysql_escape_string($value->cname)."',";
			$_sql .= floatval($value->crate).",";
			$_sql .= floatval($value->cinverse);
			$_sql .= ")";
			$sql_values[] = $_sql;
/*			$data = array(
				'symbol' => "'".$this->db->escape($value->csymbol)."'",
				'name' => "'".$this->db->escape($value->cname)."'",
				'rate' => $value->crate,
				'inverse' => $value->cinverse
				);
			$this->db->insert('currency_rate',$data);
*/		}
		$this->db->query($sql.implode(',',$sql_values));
		return true;
	}

	function clear(){
		$this->db->query("DELETE FROM currency_rate");
	}

	function get($params = array()){
		$sql = "SELECT * FROM currency_rate WHERE ";
		$cluases = array(1);
		if(isset($params['symbol'])){

			foreach ($params['symbol'] as $key => $value) {
				$params['symbol'][$key] = mysql_escape_string($value);
			}
			$cluases[] = "symbol IN ('".implode("','",$params['symbol'])."')";
		}
		//$res = $this->db->get('currency_rate');
		$res = $this->db->query($sql.implode(' AND ',$cluases));
		return $res->result();
	}
}    
?>