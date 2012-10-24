<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_misc extends CI_Model {
	
	var $point_reply = 2;
	var $point_topic = 10;
	var $point_recom = 50;
	var $point_spam = -100;
	var $point_delete = -30;
	var $per_page_records = 5;
	var $forum_page = 1;
	static $smiley_path = null;
	
	static $users = array();
	
	function __construct(){
		parent::__construct();
		$this->smiley_path = base_url('js/ckeditor/plugins/smiley/images/');	
	}
	
	public static function getUsers(){
		$users = 'users';
		return self::$users;
	}

	public static function queryUser($id,&$class){
		$users = 'users';
		if(!isset(self::$users[$id])){ 
			self::$users[$id] = $class->get('user_complete',array('user_id'=>$id));
			self::$users[$id] = !empty(self::$users[$id])?self::$users[$id][0]:false; 
		}
		return self::$users[$id];
	}
	
	public static function jsonReturn(&$data = array()){
		return array('response'=>&$data);
	}

	public static function checkLogin(&$user_id = false){
		if (!$user_id){
			redirect('login');
		}
	}

	function send_email($emailconfig){
		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtpout.asia.secureserver.net',
			'smtp_port' => 465,
			'smtp_user' => 'emailtest@tradeoffice.com',
			'smtp_pass' => 'w5a1n!!bo3',
			'mailtype'  =>  'html'
		);
		if(!isset($this->email)) $this->load->library('email', $config);
		
		$this->email->from('emailtest@tradeoffice.com', 'TradeOffice');
		$this->email->to($emailconfig['email']);
		$this->email->subject($emailconfig['subject']);
		$this->email->message($emailconfig['msg']);
		$this->email->send();
	}

	public static function BBCode2Html($text) {
		$smile_path = 'smiley_path';
		if(!self::$smiley_path)self::$smiley_path = base_url('js/ckeditor/plugins/smiley/images/');	

		$text = trim($text);
	
		// BBCode [code]
		if (!function_exists('escape')) {
			function escape($s) {
				global $text;
				$text = strip_tags($text);
				$code = $s[1];
				$code = htmlspecialchars($code);
				$code = str_replace("[", "&#91;", $code);
				$code = str_replace("]", "&#93;", $code);
				return '<pre><code>'.$code.'</code></pre>';
			}	
		}
		
		$text = preg_replace_callback('/\[code\](.*?)\[\/code\]/ms', "escape", $text);
	
		// Smileys to find...
		$in = array(
				">:-)",
				">:(",
				":/",
				":)",
				":(",
				";)",
				":D",
				":P",
				":*)",
				":-o",
				":|",
				"o:)",
				"8-)",
				";(",
				":-*",
				":yes:",
				":no:",
				":heart:",
				":mail:",
				":light:",
				":bheart:",
		);
	
		// And replace them by...
		$out = array(
				'<img alt=">:-)" src="'.self::$smiley_path.'/devil_smile.gif" />',
				'<img alt=">:(" src="'.self::$smiley_path.'/angry_smile.gif" />',
				'<img alt=":/" src="'.self::$smiley_path.'/confused_smile.gif" />',
				'<img alt=":)" src="'.self::$smiley_path.'/regular_smile.gif" />',
				'<img alt=":(" src="'.self::$smiley_path.'/sad_smile.gif" />',
				'<img alt=";)" src="'.self::$smiley_path.'/wink_smile.gif" />',
				'<img alt=":D" src="'.self::$smiley_path.'/teeth_smile.gif" />',
				'<img alt=":p" src="'.self::$smiley_path.'/tounge_smile.gif" />',
				'<img alt="blush" src="'.self::$smiley_path.'/embaressed_smile.gif" />',
				'<img alt="surprise" src="'.self::$smiley_path.'/omg_smile.gif" />',
				'<img alt="confuse" src="'.self::$smiley_path.'/whatchutalkingabout_smile.gif" />',
				'<img alt="angel" src="'.self::$smiley_path.'/angel_smile.gif" />',
				'<img alt="cool" src="'.self::$smiley_path.'/shades_smile.gif" />',
				'<img alt="crying" src="'.self::$smiley_path.'/cry_smile.gif" />',
				'<img alt="kiss" src="'.self::$smiley_path.'/kiss.gif" />',
				'<img alt="yes" src="'.self::$smiley_path.'/thumbs_up.gif" />',
				'<img alt="no" src="'.self::$smiley_path.'/thumbs_down.gif" />',
				'<img alt="heart" src="'.self::$smiley_path.'/heart.gif" />',
				'<img alt="mail" src="'.self::$smiley_path.'/envelope.gif" />',
				'<img alt="light" src="'.self::$smiley_path.'/lightbulb.gif" />',
				'<img alt="broken heart" src="'.self::$smiley_path.'/broken_heart.gif" />'
		);

		$text = str_replace($in, $out, $text);
		
		// BBCode to find...
		$in = array( 	 '/\[b\](.*?)\[\/b\]/ms',	
						 '/\[i\](.*?)\[\/i\]/ms',
						 '/\[u\](.*?)\[\/u\]/ms',
						 '/\[img\](\.\.\/)+(.*?)\[\/img\]/ms',
						 '/\[email\](.*?)\[\/email\]/ms',
						 '/\[url\="?(.*?)"?\](.*?)\[\/url\]/ms',
						 '/\[size\="?(.*?)"?\](.*?)\[\/size\]/ms',
						 '/\[color\="?(.*?)"?\](.*?)\[\/color\]/ms',
						 '/\[quote\](.*?)\[\/quote\]/ms',
						 '/\[list\=(.*?)\](.*?)\[\/list\]/ms',
						 '/\[list\](.*?)\[\/list\]/ms',
						 '/\[\*\]\s?(.*?)\n/ms'
		);
		// And replace them by...
		$out = array(	 '<strong>\1</strong>',
						 '<em>\1</em>',
						 '<u>\1</u>',
						 '<img src="'.base_url().'/\2" alt="\1" />',
						 '<a href="mailto:\1">\1</a>',
						 '<a href="\1">\2</a>',
						 '<span style="font-size:\1%">\2</span>',
						 '<span style="color:\1">\2</span>',
						 '<blockquote><span class="quote">&#8220;</span>\1<span class="quote">&#8221;</span></blockquote>',
						 '<ol start="\1">\2</ol>',
						 '<ul>\1</ul>',
						 '<li>\1</li>'
		);
		
		$cnt = 1;
		while($cnt != 0){
			$text = preg_replace($in, $out, $text, -1, $cnt);
		}
		
		// paragraphs
		$text = str_replace("\r", "", $text);
		$text = "<p>".preg_replace("/(\n){2,}/", "</p><p>", $text)."</p>";
		$text = nl2br($text);
		
		// clean some tags to remain strict
		// not very elegant, but it works. No time to do better ;)
		if (!function_exists('removeBr')) {
			function removeBr($s) {
				return str_replace("<br />", "", $s[0]);
			}
		}	
		$text = preg_replace_callback('/<pre>(.*?)<\/pre>/ms', "removeBr", $text);
		$text = preg_replace('/<p><pre>(.*?)<\/pre><\/p>/ms', "<pre>\\1</pre>", $text);
		
		$text = preg_replace_callback('/<ul>(.*?)<\/ul>/ms', "removeBr", $text);
		$text = preg_replace('/<p><ul>(.*?)<\/ul><\/p>/ms', "<ul>\\1</ul>", $text);
		
		return $text;
	}

	public static function checkModule(&$modules=array(),$value=''){
		$isOn = false;
		foreach($modules as $module => $active){
			if($module == $value){
				$isOn = intval($active);
				break;
			}
		}
		return $isOn;
	}
	/*  */
	public static function formatNumber($int = 0, $separator = ',', $digit = 3){
		$_s = ''.$int;
		$_new = '';
		$_n = strlen($_s);
		for($i=$_n-1; $i>=0;$i--){
			$_new = $_s[$i] . ( ($i % $digit == 0) && ($i > $digit) ? $separator : '') . $_new;
		}
		return $_new;
	}

	/*  */
	public static function limitStr($s, $limit = 0, $dotted = false){
		$limit = intval($limit);
		if($limit){
			$new_s = '';
			$limit = strlen($s) < $limit ? strlen($s) : $limit;
			for($i=0;$i<$limit;$i++){
				$new_s .= $s[$i];
			}
			return $new_s.(strlen($s) > $limit && $dotted?'...':'');
		}else{
			return $s;
		}
	}

	/*  */
	function formatDate($format, $secs){
		return date($format, intval($secs));
	}
	
	public static function displayValue($value,$default='-',$style='\s'){
		if(empty($value)||$value == '' || !isset($value)){
			return $default;
		}
		return str_replace('\s',$value,$style);
	}
	
	public static function getOption($options,$value){
		foreach($options as $option){
			if($option->id==$value){
				return $option;
			}
		}
		return false;
	}
	
	public static function _formatDate($format, $secs){
		return date($format, intval($secs));
	}
	
	public static function getTimestamp(){
		return gmmktime();
	}
	
	public static function renderPagination($url, $pages){
		$pages = intval($pages);
		$html = '';
		if($pages < 2 ) return $html;
		
		$html = '<span class="pagination">[';
		if($pages <= 7){
			for($i=1;$i<=$pages;$i++){
				$html .= '&nbsp;<a href="'.$url.$i.'" class>'.$i.'</a>';
			}
		}else{
			$html .= '&nbsp;<a href="'.$url.'1" class>1</a>&nbsp;.&nbsp;.&nbsp;.';
			for($i=$pages-6;$i<=$pages;$i++){
				$html .= '&nbsp;<a href="'.$url.$i.'" class>'.$i.'</a>';
			}
		}
		$html .= '&nbsp;]</span>';
		
		return $html;	
	}

	
	function gender($g=''){
		return $g == 'M' ? 'Male' : 'Female';
	}
	
	function country($code){
		$this->db->where('code',$code);
		$res = $this->db->get('country');
		$country = $res->result();
		if(count($country) && is_array($country)){
			return '<img alt="'.$country[0]->name.'" src="'.base_url("images/country/{$country[0]->code}.gif").'"> '.$country[0]->name;
		}else{
			return "Not Registered";
		}
	}
	
	function membertype(){
		echo 'Gold Supplier';
	}
	
	static function changeArrayKey($arr=array(),$key=''){
		if($key != ''){
			if(!empty($arr)){
				$new = array();
				if( is_object($arr[0]) && isset($arr[0]->$key)){
					foreach($arr as $val){
						$new[$val->$key] = $val;
					}
				}else if( is_array($arr[0]) && isset($arr[0][$key])){
					foreach($arr as $val){
						$new[$val[$key]] = $val;
					}
				}
				return $new;
			}
		}
		return $arr;
	}
}
?>