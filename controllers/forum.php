<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forum extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library(array('session','pagination'));
		$this->load->helper(array('url', 'form'));
		$this->load->model(array('m_forum','m_misc','m_session','M_encrypt'));
	}
	
	public function index(){
		$this->group();
	}
	
	function group($group = ''){
		$data['selectedGroup'] = urldecode($this->uri->segment(3)? $this->uri->segment(3): '');
		if($data['selectedGroup'] != ''){
			$data['groups'] = $this->m_forum->get('group', array('name'=>$data['selectedGroup']));
		}else{
			$data['groups'] = $this->m_forum->get('group');
		}
		$template['title'] = 'Forum';
		$template['selectedGroup'] =& $data['selectedGroup'];
		$template['groups'] = $this->m_forum->get('group');
		$template['totalTopics'] = $this->m_forum->getTopicCount();
		$template['layout'] = 'forum';
		$template['lastTopic'] = $this->get_last_topic();
		if(!empty($template['lastTopic'])){
			$template['lastTopic'] = $template['lastTopic'][0];
			$template['lastTopicAuthor'] = $this->m_forum->get('user_complete',array('user_id'=>$template['lastTopic']->user_id));
			$template['lastTopicAuthor'] = $template['lastTopicAuthor'][0];
		}
        
		$template['content'] = $this->load->view('modules/forum/groups',$data,true);
                $template['modules'] = array(
                    'login' => 1,
                    'category-menu' => 1,
                    'top-menu' => 1
                );
		$this->load->view('template',$template);
	}
	
	public function category(){
		$category_id = $this->uri->segment(3);
		$page = intval($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
		$start = $page>0?($page - 1) * $this->m_forum->per_page_records:0;
		
		$data['category'] = $this->m_forum->get('category',array('id'=>intval($category_id)));
		if(count($data['category']) && is_array($data['category'])){
			$data['category'] = $data['category'][0];
		}
		
		$data['topics'] = $this->m_forum->get('topic',array('cat_id'=>intval($category_id)),array('start'=>$start));

		$data['group'] = $this->m_forum->get('group', array('id'=>$data['category']->group_id));
                $data['cat_id'] = $category_id;
		if(count($data['group']) && is_array($data['group'])){
			$data['group'] = $data['group'][0];
		}
                
		$this->m_forum->forum_page = $page;
		$total_rows = $data['category']->topics;
		$data['default'] = array(
				'page'=>$page,
		);

		$data['pagination'] = array(
			'url'=>base_url('forum/category/'.$data['category']->id.'/'),
			'rows'=>$total_rows,
			'page'=>ceil($total_rows/$this->m_forum->per_page_records),
			'per_page' => $this->m_forum->per_page_records,
			'cur' => $page
		);
		
		$data['cat_id'] = $data['category']->id;
		
		$template['title'] = 'Forum - '.$data['category']->name;
		$template['selectedGroup'] = $data['group']->name;
		$template['totalTopics'] =& $data['category'];
		$template['breadcrumbs'] = array( (object)array('title'=>$data['category']->name, 'link'=>base_url('forum/category/'.$data['category']->id)));
		$template['groups'] = $this->m_forum->get('group');
		$template['layout'] = 'forum';
		$template['lastTopic'] = $this->get_last_topic();
		if(!empty($template['lastTopic'])){
			$template['lastTopic'] = $template['lastTopic'][0];
			$template['lastTopicAuthor'] = $this->m_forum->get('user_complete',array('user_id'=>$template['lastTopic']->user_id));
			$template['lastTopicAuthor'] = $template['lastTopicAuthor'][0];
		}
		$template['modules'] = array('search'=>1);
		$template['category_id'] = $data['category']->id;
		$template['content'] = $this->load->view('modules/forum/category',$data,true);
		$template['modules'] = array(
			'login' => 1,
			'category-menu' => 1,
			'top-menu' => 1
		);
		$this->load->view('template',$template);
	}
	
	public function search(){
		$q = $this->input->get_post('q');
		$cat_id = intval($this->input->get_post('cat_id'));
		$page = intval($this->uri->segment(3)) ? $this->uri->segment(3) : ($this->input->get_post('page')?$this->input->get_post('page'):0);
		$start = $page > 0 ? ($page - 1) * $this->m_forum->per_page_records:0;
		
		if(intval($cat_id)==0) $this->index();
		$data['category'] = $this->m_forum->get('category',array('id'=>$cat_id));
		if(count($data['category']) && is_array($data['category'])){
			$data['category'] = $data['category'][0];
		}

		$search = $this->m_forum->search(array('cat_id'=>$cat_id, 'q'=>$q),array('start'=>$start));
		$data['topics'] = $search['result'];
        
		$data['group'] = $this->m_forum->get('group', array('id'=>$data['category']->group_id));
		if(count($data['group']) && is_array($data['group'])){
			$data['group'] = $data['group'][0];
		}

		$data['cat_id'] = $data['category']->id;
		$data['query'] = $q;

		$data['pagination'] = array(
			'url'=>base_url('forum/search/?q='.$q.'&cat_id='.$data['category']->id),
			'rows'=>$search['page']['total'],
			'page'=>ceil($search['page']['total']/$this->m_forum->per_page_records),
			'per_page' => $this->m_forum->per_page_records,
			'cur' => $page
		);
		
		$template['title'] = 'Forum - '.$data['category']->name;
		$template['selectedGroup'] = $data['group']->name;
		$template['totalTopics'] =& $data['category'];
		$template['groups'] = $this->m_forum->get('group');
		$template['layout'] = 'forum';
		$template['lastTopic'] = $this->get_last_topic();
		$template['breadcrumbs'] = array( (object)array('title'=>$data['category']->name, 'link'=>base_url('forum/category/'.$data['category']->id)));
		if(!empty($template['lastTopic'])){
			$template['lastTopic'] = $template['lastTopic'][0];
			$template['lastTopicAuthor'] = $this->m_forum->get('user_complete',array('user_id'=>$template['lastTopic']->user_id));
			$template['lastTopicAuthor'] = $template['lastTopicAuthor'][0];
		}
		$template['modules'] = array('search'=>1);
		$template['category_id'] = $data['category']->id;
		$template['content'] = $this->load->view('modules/forum/search_category',$data,true);
        $template['modules'] = array(
            'login' => 1,
            'category-menu' => 1,
            'top-menu' => 1
        );
		$this->load->view('template',$template);
	}
	
	public function topic(){
		$topic_id = $this->uri->segment(3);
		$page = intval($this->uri->segment(4) ? $this->uri->segment(4) : 1);
		$start = $page > 1 ? (($page - 1) * $this->m_forum->per_page_records) - 1 : 0;

		$data['topic'] = $this->m_forum->get('topic',array('id'=>intval($topic_id)));
		if(count($data['topic']) && is_array($data['topic'])){
			$data['topic'] = $data['topic'][0];
			$data['topic']->replies++;
			
			$data['comments'] = $this->m_forum->get('comment',array('topic_id'=>intval($topic_id)),array('start'=>$start,'limit'=>$page==1?$this->m_forum->per_page_records-1:$this->m_forum->per_page_records));
		}

		$data['category'] = $this->m_forum->get('category',array('id'=>intval($data['topic']->cat_id)));
		if(count($data['category']) && is_array($data['category'])){
			$data['category'] = $data['category'][0];
		}
		$data['cat_id'] = $data['category']->id;
		
		$data['group'] = $this->m_forum->get('group', array('id'=>$data['category']->group_id));
		if(count($data['group']) && is_array($data['group'])){
			$data['group'] = $data['group'][0];
		}

		$data['pagination'] = array(
			'url'=>base_url('forum/topic/'.$data['topic']->id.'/'),
			'rows'=>$data['topic']->replies,
			'page'=>ceil($data['topic']->replies/$this->m_forum->per_page_records),
			'per_page' => $this->m_forum->per_page_records,
			'cur' => $page
		);
		
		$this->m_forum->viewTopic($this->session->userdata('session_id'),$this->session->userdata('user_id'),$data['topic']->id);

		$data['cat_id'] = $data['category']->id;
				
		$template['title'] = 'Forum - '.$data['topic']->subject;
		$template['selectedGroup'] = $data['group']->name;
		$template['totalTopics'] =& $data['category'];
		$template['breadcrumbs'] = array( (object)array('title'=>$data['category']->name, 'link'=>base_url('forum/category/'.$data['category']->id)));
		$template['groups'] = $this->m_forum->get('group');
		$template['layout'] = 'forum';
		$template['lastTopic'] = $this->get_last_topic();
		if(!empty($template['lastTopic'])){
			$template['lastTopic'] = $template['lastTopic'][0];
			$template['lastTopicAuthor'] = $this->m_forum->get('user_complete',array('user_id'=>$template['lastTopic']->user_id));
			$template['lastTopicAuthor'] = $template['lastTopicAuthor'][0];
		}
		$template['modules'] = array('search'=>1);
		$template['category_id'] = $data['category']->id;
		$template['content'] = $this->load->view('modules/forum/topic',$data,true);
        $template['modules'] = array(
            'login' => 1,
            'category-menu' => 1,
            'top-menu' => 1
        );
		$this->load->view('template',$template);
	}
	
	
	
	public function post(){
		$userID = $this->m_session->getUserID();
		$action = $this->uri->segment(3) ? $this->uri->segment(3) : $this->input->post('action');
		$task = $this->input->post('task');
		$params = $this->input->post('params');
		
		$data = array();

		$data['user'] = $this->m_forum->get('user_complete',array('user_id'=>$userID));
		
		if(!is_array($data['user']) || !count($data['user'])){
			$this->session->set_userdata('previous_url',$this->m_session->full_url());
			redirect('forum/register');
			return false;
		}
		
		switch($action){
			case 'topic':
				$category_id = $this->uri->segment(4) ? $this->uri->segment(4) : $this->input->post('cat_id');
				$data['category'] = $this->m_forum->get('category',array('id'=>intval($category_id)));
				if(count($data['category']) && is_array($data['category'])){
					$data['category'] = $data['category'][0];
				}else{
					$this->index();
					return false;
				}
			break;
			case 'comment':
				$topic_id = $this->uri->segment(4) ? $this->uri->segment(4) : $this->input->post('topic_id');
				$comment_id = $this->uri->segment(5) ? $this->uri->segment(5) : $this->input->post('comment_id');

				$data['is_quote'] = $this->input->get_post('quote') == 1 ? true : false;				
				$data['comment'] = $this->m_forum->get('comment',array('id'=>intval($comment_id)));
				if(is_array($data['comment']) && count($data['comment'])){
					$data['comment'] = $data['comment'][0];
				}else{
					$data['comment'] = false;
				}

				$data['topic'] = $this->m_forum->get('topic',array('id'=>intval($topic_id)));
				if(count($data['topic']) && is_array($data['topic'])){
					$data['topic'] = $data['topic'][0];
				}else{
					$this->index();
					return false;
				}

				$data['category'] = $this->m_forum->get('category',array('id'=>intval($data['topic']->cat_id)));
				if(count($data['category']) && is_array($data['category'])){
					$data['category'] = $data['category'][0];
				}
				
			break;
			default:
				show_404();
				return false;
			break;
		}

		$template['title'] = 'Forum - Post Topic';
		$template['groups'] = $this->m_forum->get('group');
		$template['layout'] = 'forum';
		$template['lastTopic'] = $this->get_last_topic();
		if(!empty($template['lastTopic'])){
			$template['lastTopic'] = $template['lastTopic'][0];
			$template['lastTopicAuthor'] = $this->m_forum->get('user_complete',array('user_id'=>$template['lastTopic']->user_id));
			$template['lastTopicAuthor'] = $template['lastTopicAuthor'][0];
		}
		$template['modules'] = array('search'=>1);
		$template['category_id'] = $data['category']->id;
		$template['totalTopics'] =& $data['category'];
		$template['breadcrumbs'] = array( (object)array('title'=>$data['category']->name, 'link'=>base_url('forum/category/'.$data['category']->id)));
		$template['content'] = $this->load->view('modules/forum/post_'.$action,$data,true);
        $template['modules'] = array(
            'login' => 1,
            'category-menu' => 1,
            'top-menu' => 1
        );
		$this->load->view('template',$template);
	}
	
	protected function validation($action){
		$this->load->library('form_validation');
		switch($action){
			case 'topic':
				$this->form_validation->set_rules('params[content]', 'Content', 'required');
				$this->form_validation->set_rules('params[subject]', 'Subject', 'required');
			break;
			case 'user':
				$this->form_validation->set_rules('params[username]', 'Username', 'required');
				$this->form_validation->set_rules('params[user_id]', 'User', 'required');
			break;
			case 'comment':
				$this->form_validation->set_rules('params[content]', 'Content', 'required');
			break;
		}

		return $this->form_validation->run();
	}
	
	public function register(){
		$userID = $this->m_session->getUserID();
		$action = $this->uri->segment(3) ? $this->uri->segment(3) : $this->input->post('action');

		$data['user'] = $this->m_forum->get('user_complete',array('user_id'=>$userID));
		if(is_array($data['user']) || count($data['user'])>0){
			$data['user'] = $data['user'][0];
		}
		switch($action){
			case 'save':
				$params = $this->input->post('params');
				if(!$this->validation('user')){
					echo 'not valid';
					//$this->load->view('modules/forum/profile_register',$data);
					return false;
				}
				$res = $this->m_forum->add('user',$params);
				if($res['status']){
					$uri = $this->session->userdata('previous_url');
					$this->session->unset_userdata($array_items);
					$this->m_forum->doRanking();
					redirect($uri);
				}
			break;
			default:
//				$this->load->view('modules/forum/profile_register',$data);
			break;
		}

		$template['title'] = 'Forum - Register User';
		$template['groups'] = $this->m_forum->get('group');
		$template['totalTopics'] =& $data['category'];
		$template['breadcrumbs'] = array( (object)array('title'=>$data['category']->name, 'link'=>base_url('forum/category/'.$data['category']->id)));
		$template['layout'] = 'forum';
		$template['lastTopic'] = $this->get_last_topic();
		if(!empty($template['lastTopic'])){
			$template['lastTopic'] = $template['lastTopic'][0];
			$template['lastTopicAuthor'] = $this->m_forum->get('user_complete',array('user_id'=>$template['lastTopic']->user_id));
			$template['lastTopicAuthor'] = $template['lastTopicAuthor'][0];
		}
		$template['content'] = $this->load->view('modules/forum/profile_register',$data,true);
        $template['modules'] = array(
            'login' => 1,
            'category-menu' => 1,
            'top-menu' => 1
        );
		$this->load->view('template',$template);
	}
	
	public function profile(){
		$this->load->model('m_company');
		$username = $this->uri->segment(3) ? $this->uri->segment(3) : $this->input->post('username');
		
		$company = false;
		$data['user'] = $this->m_forum->get('user_complete',array('username'=>$username));
		if(is_array($data['user']) || count($data['user'])>0){
			$data['user'] = $data['user'][0];
			
			$company = (object)$this->m_company->getCompanyById($data['user']->company_id);
		}
		$data['company'] =& $company;

		$data['topics'] = $this->m_forum->get('topic',array('user_id'=>$data['user']->user_id));
		$data['comments'] = $this->m_forum->get('comment',array('user_id'=>$data['user']->user_id));
// disabled for now
//		$data['watchlist'] = $this->m_forum->get('user_watchlist',array('user_id'=>$data['user']->user_id));

		$template['title'] = 'Forum - Profile';
		$template['totalTopics'] = $this->m_forum->getTopicCount();
		$template['groups'] = $this->m_forum->get('group');
		$template['breadcrumbs'] = array( (object)array('title'=>'Member Profile', 'link'=>'#'));
		$template['layout'] = 'forum-profile';
		$template['lastTopic'] = $this->get_last_topic();
		if(!empty($template['lastTopic'])){
			$template['lastTopic'] = $template['lastTopic'][0];
			$template['lastTopicAuthor'] = $this->m_forum->get('user_complete',array('user_id'=>$template['lastTopic']->user_id));
			$template['lastTopicAuthor'] = $template['lastTopicAuthor'][0];
		}
		$template['content'] = $this->load->view('modules/forum/profile',$data,true);
        $template['modules'] = array(
            'login' => 1,
            'category-menu' => 1,
            'top-menu' => 1
        );
		$this->load->view('template',$template);
	}
	
	public function doRangking(){
		$this->m_forum->doRanking();
	}
	
	public function save(){
		$userID = $this->m_session->getUserID();
		$action = $this->uri->segment(3) ? $this->uri->segment(3) : $this->input->post('action');
		$params = $this->input->post('params');
		
		$data = array();

		$data['user'] = $this->m_forum->get('user',array('user_id'=>$userID));
		$this->m_forum->doRanking();
		if(!$this->validation($action)){
			//$this->load->view('modules/forum/post_'.$action,$data);
			return false;
		}
		switch($action){
			case 'topic':
                
				$category_id = $this->uri->segment(4) ? $this->uri->segment(4) : $this->input->post('params[cat_id]');
				$params['cat_id'] = $category_id;
				$params['user_id'] = $userID;
				$res = $this->m_forum->add('topic',$params);
				$this->m_forum->doRanking();
				if($res['status']){
					redirect('forum/topic/'.$res['insert_id']);
				}
			break;
			case 'comment':
				$topic_id = $this->uri->segment(4) ? $this->uri->segment(4) : $this->input->post('params[topic_id]');
				$topic = $this->m_forum->get('topic',array('id'=>$topic_id));
				$params['topic_id'] = $topic_id;
				$params['user_id'] = $userID;
				$params['subject'] = 'RE: '.$topic[0]->subject;				
				$res = $this->m_forum->add('comment',$params);
				$this->m_forum->doRanking();
				if($res['status']){
					redirect('forum/topic/'.$topic_id);
				}
			break;
			default:
				show_404();
				return false;
			break;
		}
	}
    
	function gettopic(){
		$username = $this->uri->segment(3) ? $this->uri->segment(3) : $this->input->post('username');
		$page = intval($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
		$start = ($page - 1) * $this->m_forum->per_page_records;
		
		$user = $this->m_forum->get('user_complete',array('username'=>$username));
		if(is_array($user) || count($user)>0){
			$user = $user[0];
		}

		$data['result'] = $this->m_forum->get('topic',array('user_id'=>$user->user_id),array('start'=>$start));

		if(!empty($data['result']))
			for($i=0; $i<count($data['result']);$i++){
				$data['result'][$i]->cdate = $this->m_misc->formatDate('d M Y H:i',$data['result'][$i]->cdate);
			}

		$data['status'] = empty($data['result'])?false:true;
		
		$data['pagination'] = array(
			'url'=>base_url('forum/gettopic/'.$username.'/'),
			'rows'=>$user->topics,
			'page'=>ceil($user->topics/$this->m_forum->per_page_records),
			'per_page' => $this->m_forum->per_page_records,
			'cur' => $page
		);
		
		$this->load->view('json',array('response'=>$data));
	}

	function getcomment(){
		$username = $this->uri->segment(3) ? $this->uri->segment(3) : $this->input->post('username');
		$page = intval($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
		$start = ($page - 1) * $this->m_forum->per_page_records;
		
		$user = $this->m_forum->get('user_complete',array('username'=>$username));
		if(is_array($user) || count($user)>0){
			$user = $user[0];
		}

		$data['result'] = $this->m_forum->get('comment',array('user_id'=>$user->user_id),array('start'=>$start));

		if(!empty($data['result']))
			for($i=0; $i<count($data['result']);$i++){
				$data['result'][$i]->cdate = $this->m_misc->formatDate('d M Y H:i',$data['result'][$i]->cdate);
			}

		$data['status'] = empty($data['result'])?false:true;
		
		$data['pagination'] = array(
			'url'=>base_url('forum/gettopic/'.$username.'/'),
			'rows'=>$user->replies,
			'page'=>ceil($user->replies/$this->m_forum->per_page_records),
			'per_page' => $this->m_forum->per_page_records,
			'cur' => $page
		);
		
		$this->load->view('json',array('response'=>$data));
	}

    public function get_last_topic() {
        return $this->m_forum->get('topic', '', array('order' => 'id DESC', 'limit' => 1));
    }
    
    public function like_topic($id) {
        
        $this->load->model('M_like');
        
        $res = $this->m_forum->get('topic', array('id'=>$id));
        $like = $res[0]->like;
		$author_id = $res[0]->user_id;
        
        $user_id = $this->session->userdata('user_id');
        if (!$user_id){
            echo $like;
        } else{
            if($this->M_like->isExist($user_id,array('section'=>'topic', 'value'=>$id))){
                echo $like;
            } else {
                $data = array('like'    =>    $like+1);
                $this->m_forum->update('topic',array('id'=>$id),$data);
				$this->m_forum->updateStatistic('user','like',$author_id);
				$this->m_forum->doRanking();
                echo $like + 1;
            }
        }
    
    }
    
    public function like_comment($id) { 
        
        $this->load->model('M_like');
        
        $res = $this->m_forum->get('comment', array('id'=>$id));
        $like = $res[0]->like;
		$author_id = $res[0]->user_id;

        $user_id = $this->session->userdata('user_id');
        if (!$user_id){
            echo $like;
        } else{
            if($this->M_like->isExist($user_id,array('section'=>'comment', 'value'=>$id))){
                echo $like;
            } else {
                $data = array('like'    =>    $like+1);
                $this->m_forum->update('comment',array('id'=>$id),$data);
				$this->m_forum->updateStatistic('user','like',$author_id);
				$this->m_forum->doRanking();
                echo $like + 1;
            }
        }
    
    }

	public function dislike_topic($id) {
		$this->load->model('M_like');
		
		$res = $this->m_forum->get('topic', array('id'=>$id));
		$dislike = $res[0]->dislike;
		$author_id = $res[0]->user_id;
		
		$user_id = $this->session->userdata('user_id');
		if (!$user_id){
			echo $dislike;
		} else{
			if($this->M_like->dislikeExist($user_id,$id,'topic')){
				echo $dislike;
			} else {
				$data = array('dislike'    =>    $dislike+1);
				$this->m_forum->update('topic',array('id'=>$id),$data);
				$this->m_forum->updateStatistic('user','dislike',$author_id);
				$this->m_forum->doRanking();
				echo $dislike + 1;
			}
		}
	}
	
	public function dislike_comment($id) { 
		$this->load->model('M_like');
		
		$res = $this->m_forum->get('comment', array('id'=>$id));
		$dislike = $res[0]->dislike;
		$author_id = $res[0]->user_id;
	
		$user_id = $this->session->userdata('user_id');
		if (!$user_id){
			echo $dislike;
		} else{
			if($this->M_like->dislikeExist($user_id,$id,'comment')){
				echo $dislike;
			} else {
				$data = array('dislike'    =>    $dislike+1);
				$this->m_forum->update('comment',array('id'=>$id),$data);
				$this->m_forum->updateStatistic('user','dislike',$author_id);
				$this->m_forum->doRanking();
				echo $dislike + 1;
			}
		}
	}
}
?>