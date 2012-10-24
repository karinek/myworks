<?php
class M_gallery extends CI_Model {
	
	var $gallery_path;
	var $gallery_path_url;
        
        function __construct()
        {
            
            parent::__construct();
            $this->load->helper(array('url','form'));
            $this->gallery_path = realpath(APPPATH . '../images/product_images');
	    $this->gallery_thumb_path = realpath(APPPATH . '../images/product_thumbs');
            $this->gallery_path_url = base_url().'images/product_images';
            
        }
  
	function do_upload() {
		
		$config = array(
			'allowed_types' => 'jpg|jpeg|gif|png',
			'upload_path' => $this->gallery_path,
			'encrypt_name' => true,
			'max_size' => 2000
		);
		
		//$config['max_size']  = '0';
		//$config['max_width']  = '0';
		//$config['max_height']  = '0';
		
		$this->load->library('upload', $config);
		$this->upload->do_upload();
		$image_data = $this->upload->data();
		
		$config = array(
			'source_image' => $image_data['full_path'],
			'new_image' => $this->gallery_thumb_path,
			'maintain_ration' => true,
			'width' => 150,
			'height' => 100
		);
		$this->load->library('image_lib', $config);
                $this->load->library('upload', $config);
		$this->image_lib->resize();
//		if ( ! $this->upload->do_upload())
//			{
//			    $upload_data = array();
//			}   
//			else
//			{
//			    $upload_data = $this->upload->data();
//			    
//			}
		return $image_data;
	}
	
	function get_images() {
		
		$files = scandir($this->gallery_path);
		$files = array_diff($files, array('.', '..', 'thumbs'));
		
		$images = array();
		
		foreach ($files as $file) {
			$images []= array (
				'url' => $this->gallery_path_url . $file,
				'thumb_url' => $this->gallery_path_url . 'thumbs/' . $file
			);
		}
		
		return $images;
	}
	
}



