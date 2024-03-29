<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_encrypt extends CI_Model {
	
	static $key = "bnsdfgdf";
	
	function __construct(){
		parent::__construct();
	}
	
	public function safe_b64decode($string) {
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }
 
    public function encode($value){ 
	    if(!$value){return false;}
        $text = $value;
        $iv_size = mcrypt_get_iv_size(MCRYPT_3DES, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $crypttext = mcrypt_encrypt(MCRYPT_3DES, self::$key, $text, MCRYPT_MODE_ECB, $iv);
		
		$data = base64_encode($crypttext);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return trim($data);
    }
 
    public function decode($value){
        if(!$value){return false;}
        $crypttext = $this->safe_b64decode($value); 
        $iv_size = mcrypt_get_iv_size(MCRYPT_3DES, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypttext = mcrypt_decrypt(MCRYPT_3DES, self::$key, $crypttext, MCRYPT_MODE_ECB, $iv);
        return trim($decrypttext);
    }
}
?>