<?php
class M_country extends CI_Model {

   
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    public function getAllCountryName()
    {
		$this->db->select('*');
		$query = $this->db->get('country');
		return $query->result_array();  
    }    
    
    public function getAllRegionName()
    {
//        $sql = 'SELECT DISTINCT country_region FROM company ORDER BY country_region';
        $sql = 'SELECT DISTINCT region country_region FROM country WHERE region!=\'\' ORDER BY region';
        $query = $this->db->query($sql);
        return $query->result_array();  
    }
    
    public function getAllCountryByRegion($region) {
        $region = str_replace('%20', ' ', $region);
//        $sql = 'SELECT DISTINCT country_name FROM company WHERE country_region = \''.$region.'\' ORDER BY country_name';
        $sql = 'SELECT DISTINCT name country_name FROM country WHERE region = \''.$region.'\' ORDER BY name';
        $query = $this->db->query($sql);
        return $query->result_array();  
    }
    
    public function getAllCountryOptions()
    {
	$query = $this->db->get('country');
	
	foreach($query->result() as $row)
	{
	    $data[$row->code] = $row->name;     
	}
	return $data;
    }  
    public function getCountryNameByCode($code)
    {
        $this->db->select('name');
        $this->db->where('code', $code);
	$query = $this->db->get('country');
        if($query->num_rows() > 0){
            return $query->row()->name;
        }
	return '';
    }
	
	public function getRegionByCode($code)
    {
        $this->db->select('region');
        $this->db->where('code', $code);
	$query = $this->db->get('country');
        if($query->num_rows() > 0){
            return $query->row()->region;
        }
	return '';
    }
}

?>