<?php
class M_vcode extends CI_Model {
    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }

    function create (){
      
        $this->load->helper('captcha');
        $vals = array(
          'word' => $this->getrandomstring(5),
         'img_path' => str_replace(SELF, "", FCPATH).'captcha'.DIRECTORY_SEPARATOR,
        'img_url' => base_url().'captcha/',
            'font_path'     => './system/fonts/texb.ttf',
           // 'img_path' => BASEPATH.'../captcha/',
           // 'img_url' => base_url().'/captcha/',
			'img_width' => '310',
			'img_height' => 70,
              'expiration'    => 3600
        );

        return create_captcha($vals);
    }
    public  function getrandomstring($length) {

       global $template;
       settype($template, "string");

       $template = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ12345678910";
       /* this line can include numbers or not */

       settype($length, "integer");
       settype($rndstring, "string");
       settype($a, "integer");
       settype($b, "integer");

       for ($a = 0; $a <= $length; $a++) {
               $b = rand(0, strlen($template) - 1);
               $rndstring .= $template[$b];
       }

       return $rndstring; 
}


}
?>