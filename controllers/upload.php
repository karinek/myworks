<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller {
	var $user_id = null;
	var $user = null;
	function __construct(){
		parent::__construct();

		$this->load->helper(array('form','url','html'));
		$this->load->library('session');
		$this->load->model(array('m_user','m_optionBusinessType','m_company','m_country','m_session','m_options'));

		$module = $this->input->get_post('module');
		if(is_array($module)){
			$module = $module['name'];
		}
		if($module=='register'){
		}else{
			$this->user_id = $this->m_session->getUserID();
			
			$this->user = (object)$this->m_user->getUserById($this->user_id);
		}
	}
	
	function index(){
		$module = $this->input->get_post('module');
		$module_id = $this->input->get_post('module_id');
		if($module=='company'){
			$this->load->view('modules/upload/company-upload-form',array(
				'module' => array(
					'name' => $module,
					'id' => $module_id
				)
			));
		}else{
			$this->load->view('modules/upload/upload-form',array(
				'module' => array(
					'name' => $module,
					'id' => $module_id
				)
			));
		}
	}
	
	function processImage(){
		$data = array('status'=>false);
		$task = $this->input->post('task');
		$format = $this->input->post('format');
		
		if($task=='cancel'){
			$this->_deleteTempImage();
			$data['status'] = true;
		}else{
			$module = $this->input->post('module');
			$module_id = $this->input->post('module_id');
			
			$params = $this->input->post('params');
	
			$config['image_library'] = 'gd2';
			$config['source_image']	= realpath(APPPATH . '../images/user_images/temp/'.$this->session->userdata('tempfile'));
			$config['x_axis'] = intval($params['x'] ? $params['x'] : 0);
			$config['y_axis'] = intval($params['y'] ? $params['y'] : 0);
			$config['maintain_ratio'] = false;
			if(isset($params['w']) && intval($params['w']) != 0) $config['width'] = intval($params['w']);
			if(isset($params['h']) && intval($params['h']) != 0) $config['height'] = intval($params['h']);
			
			$this->load->library('image_lib',$config);
			
			if ( $this->image_lib->crop()){
				$data['source'] = $config['source_image'];
				$data['module_id'] = isset($module['id'])?$module['id']:0;
				$data['image'] = $this->session->userdata('tempfile');
				$data['dest'] = realpath(APPPATH . '../images/user_images/'.$this->session->userdata('tempfile'));
				
				switch($module['name']){
					case 'register':
						$data2 = $this->_updateRegisterImage($data);
						$data = array_merge($data,$data2);
					break;
					case 'company':
						$data2 = $this->_updateCompanyImage($data);
						$data = array_merge($data,$data2);
					break;
					case 'staff':
						$data2 = $this->_updateStaffImage($data);
						$data = array_merge($data,$data2);
					break;
					case 'user':
						$data2 = $this->_updateUserImage($data);
						$data = array_merge($data,$data2);
					break;
					default:
						if(!copy($data['source'],$data['dest'])){
							unlink($data['source']);
							$data2 = array(
								'status' => true,
								'width' => $params['w'],
								'height' => $params['h'],
								'path' => base_url('images/user_images/temp/'),
								'file' => $this->session->userdata('tempfile')
							);
							$data = array_merge($data,$data2);
						}
					break;
				}
				
			}else{
				$data['error'] = $this->image_lib->display_errors();
			}
			$this->session->unset_userdata('tempfile');
		}
		
		if($format=='json'){
			$this->load->view('json',array('response'=>$data));
		}else{
			$this->load->view('json',array('response'=>$data));
		}
	}
	
	function _updateRegisterImage($params){
		$data = array('status'=>false);

		if(!isset($params['image'])){
			$data['debug'] = 'no image';
			return $data;
		}

		if(isset($params['source']) && !empty($params['source'])){
			$data['path'] = base_url('images/user_images/temp/');
			$data['image'] = $params['image'];
			$data['status'] = true;
			
			$data['callback'] = 'app.reloadRegisterImage';
		}else{
			$data['debug'] = 'no valid image';
			unset($params['image']);
		}
		return $data;
	}
	
	function _updateCompanyImage($params){
		$data = array('status'=>false);

		if(!isset($params['module_id']) || !isset($params['image'])){
			return $data;
		}

		$company = $this->m_company->getCompanyByUser($this->user->id);
		if(!empty($company) && isset($params['source']) && !empty($params['source'])){
			if(!copy($params['source'],realpath(APPPATH . '../images/company_images').'/'.$params['image'])){
				unset($params['image']);
			}else{
				unlink($params['source']);
				$data['path'] = base_url('images/company_images/');
				$data['image'] = $params['image'];
				$data['status'] = $this->m_company->update($company[0]->id,array(
					'file' => $params['image']
				));
				
				$data['callback'] = 'app.reloadCompanyImage';
			}
		}else{
			unset($params['image']);
		}
		return $data;
	}
	
	function _updateUserImage($params){
		$data = array('status'=>false);

		if(!isset($params['module_id']) || !isset($params['image'])){
			return $data;
		}

		if(isset($params['source']) && !empty($params['source'])){
			'images/user_images/';
			if(!copy($params['source'],realpath(APPPATH . '../images/user_images').'/'.$params['image'])){
				unset($params['image']);
			}else{
				unlink($params['source']);
				$data['path'] = base_url('images/user_images/');
				$data['image'] = $params['image'];
				$data['status'] = $this->m_user->update($this->user->id,array(
					'image' => $params['image']
				));
				
				$data['callback'] = 'app.reloadUserImage';
			}
		}else{
			unset($params['image']);
		}
		return $data;
	}
	
	function _updateStaffImage($params){
		$data = array('status'=>false);

		if(!isset($params['module_id']) || !isset($params['image']) || intval($params['module_id'])==0 || $params['image']==''){
			return $data;
		}

		if(isset($params['source']) && !empty($params['source'])){
			'images/user_images/';
			if(!copy($params['source'],realpath(APPPATH . '../images/user_images').'/'.$params['image'])){
				unset($params['image']);
			}else{
				unlink($params['source']);
				$this->load->model('m_company');

				$data['path'] = base_url('images/user_images/');
				$data['image'] = $params['image'];
				
				$data['status'] = $this->m_company->staffSave(array(
					'id' => $params['module_id'],
					'image' => $params['image']
				));
				
				$data['callback'] = 'app.reloadStaffImage';
			}
		}else{
			unset($params['image']);
		}
		return $data;
	}
	
	function priviewImage(){
		$data = array('status' => false);
		$module = $this->input->get_post('module');
		$this->_deleteTempImage();
		$config = array(
			'upload_path'   =>  realpath(APPPATH . '../images/user_images/temp'),
			'allowed_types' =>  'gif|jpg|png',
			'file_name' => MD5(M_misc::getTimestamp())
		);
		
		$this->load->library('upload', $config);
		
		if ($this->upload->do_upload('contactimage')){
			$file = $this->upload->data();

			$config['image_library'] = 'gd2';
			$config['source_image']	= $file['full_path'];
			$config['maintain_ratio'] = true;
			$config['width'] = 512;
			$config['height'] = 512;
			
			switch($module){
				case 'company':
					$config['width'] = 685;
					$config['height'] = 575;
				break;
			}
			
			$this->load->library('image_lib',$config);
			
			if ( $this->image_lib->resize()){
				$image = getimagesize($file['full_path']);
				$data = array(
					'status' => true,
					'width' => $image[0],
					'height' => $image[1],
					'path' => base_url('images/user_images/temp/'),
					'file' => $file['file_name']
				);
			}
			$this->session->set_userdata('tempfile',$file['file_name']);
		}
		$this->load->view('json',array('response'=>$data));
	}
	
	function cancelUpload(){
		$this->_deleteTempImage();
	}
	
	function _deleteTempImage(){
		$temp = $this->session->userdata('tempfile');
		if($temp!=''){
			$file = realpath(APPPATH . '../images/user_images/temp/'.$temp);
			if(is_file($file)){
				unlink($file);
			}
			$this->session->unset_userdata('tempfile');
		}
	}
	
	function view($module='',$data=array()){
		$template['title'] = 'Upload'.(isset($data['title'])? ' - '.$data['title']:'');
		$template['layout'] = 'one-column';
		$template['templatePath'] = $this->path;
		
		$template['content'] = $this->load->view($this->pathView.$module,$data,true);
		$this->load->view($this->path.'template',$template);
	}
}
?>