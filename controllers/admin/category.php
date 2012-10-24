<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Controller {
    
    public function display($category_id = 0){
        $this->load->helper(array('url','form'));
        $this->load->model('M_category','',True);
        
        if(!$category_id)
            $category_id = 0;

        
        $data['category'] = $this->M_category->getSubCategory($category_id);
        $data['nav'] = $this->M_category->getNav($category_id);
        $data['hidden'] = array(
                            'current_id'   => $category_id);
        $this->load->view('admin/modules/category/display_view',$data);
    }
    
    public function add(){
        $this->load->helper(array('url'));
        
        $parent_id = $this->input->post('current_id');
        $category_name = $this->input->post('new_category');
        
        if (is_numeric($parent_id) && $category_name){
            $data = array(
                    'parent_id' => $parent_id,
                    'category_name' => $category_name
                    );
            $this->load->model('M_category','',True);
            $this->M_category->insert($data);
        }
        redirect ('attribute/display/'.$parent_id);
    }
    
    /* helman code start */
    public function edit($category_id){
        $this->load->helper(array('url','form'));
        $this->load->model('M_category','',True);
        $this->load->model('M_attribute','',True);
        
        $data = array();
        $data['category_id'] = $category_id;
        if(!$data['category_id'])
            $data['category_id'] = 0;

        $data['category'] = $this->M_category->getCategory($data['category_id']);
        $data['isLeaf'] = $this->M_category->isLeaf($data['category_id']);
        $data['attributes'] = $this->M_attribute->getByCategoryId($data['category_id']);
        $data['hidden'] = array(
            'category_id' => $data['category_id']
        );

        $this->load->view('admin/modules/category/edit',$data);
    }

    function update(){
        $this->load->helper(array('url','form'));
        $this->load->model('M_category','',True);
        $this->load->model('M_attribute','',True);
        
        $data = array();
        $data['category_name'] = $this->input->post('category_name');
        $data['category_id'] = $this->input->post('category_id');
        $data['params'] = $this->input->post('params');
        
        $this->M_category->update($data['category_id'],array('category_name' => $data['category_name']));
        $this->M_attribute->process($data['category_id'],$data['params']['attribute']);

        /*$data['category'] = $this->M_category->getCategory($data['category_id']);
        $data['isLeaf'] = $this->M_category->isLeaf($data['category_id']);
        $data['attributes'] = $this->M_attribute->getByCategoryId($data['category_id']);
        $data['hidden'] = array(
            'category_id' => $data['category_id']
        );*/
        redirect('attribute/edit/'.$data['category_id']);
    }
    /* helman code end */    
}
