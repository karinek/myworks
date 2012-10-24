<?php
    class M_addTo extends CI_Model{
        
        var $fav_page = 1;
        var $fav_num = 10;
        
        function __construct(){
            // Call the Model constructor
            parent::__construct();
        }
        
        function compareWatchlist($id,$user_id){
            $this->db->where('product_id', $id);
            $this->db->where('user_id', $user_id);
            $res = $this->db->get('users_watchlist');
            if($res->num_rows() == 0)
                return TRUE;
            else 
                return FALSE;
        }
        function addToWatchList($id,$user_id){
            if($this->compareWatchlist($id,$user_id)){
                $data = array(
                'user_id' => $user_id,
                'product_id' => $id
                );
                $this->db->insert('users_watchlist', $data);
                return true;
            }
            else 
                return FALSE;
        }
        function inWatchList($data = array(), $user_id){
            $result = array();
            foreach ($data as $product){
                if(is_array($product)) $product = (object)$product;
                $this->db->where('product_id', $product->product_id);
                $this->db->where('user_id', $user_id);
                $res = $this->db->get('users_watchlist');
                if($res->num_rows() == 1)
                    $result[$product->product_id] = $product->product_id;
            }
            return $result;
        }
        
        function getWatchListProductIds($user_id){
            if(!$user_id) return array();
            $result = array();
            $this->db->select('product_id');
            $this->db->where('user_id', $user_id);
            $res = $this->db->get('users_watchlist');
            if($res->num_rows() > 0) {
                $items = $res->result();
                foreach($items as $item){
                    $result[] = $item->product_id;
                }
                return $result;
            }
                
                return $res->result_array();
            return $result;
        }
        
        function myWatchList($user_id, $order='', $page = false){
            if($page){
                $this->db->where('user_id', $user_id);
                $this->db->join('products AS p', 'p.product_id = uw.product_id', 'inner');
                $this->db->join('product_images AS pi', 'pi.product_id = uw.product_id', 'left');
                $this->db->select('COUNT(*) AS num_row');
                $res = $this->db->get('users_watchlist AS uw');
                $total_rows = $res->result();
                
                if(is_array($total_rows) && count($total_rows)){
                        $total_rows = $total_rows[0]->num_row;
                }else{
                        $total_rows = 0;
                }
                $start = ($this->fav_page - 1) * $this->fav_num;
                $this->db->limit($this->fav_num, $start);
                $this->fav_page = 1;
            }
            
            $this->db->where('user_id', $user_id);
            if($order != '')
                $this->db->order_by('p.name', $order);
            $this->db->join('products AS p', 'p.product_id = uw.product_id', 'inner');
            $this->db->join('product_images AS pi', 'pi.product_id = uw.product_id', 'left');
            $this->db->select('p.*, pi.image_name');
            $res = $this->db->get('users_watchlist AS uw');
            
            if($page) return array('pagination'=>array('rows'=>$total_rows,'page'=>ceil($total_rows/$this->fav_num)),'result'=>$res->result());
		else return $res->result();
                
        }
        
        function deleteFromWatchList($user_id, $product_id = ''){
            if(intval($user_id)==0 || intval($product_id)==0) return false;

            $this->db->where('user_id',intval($user_id));
            $this->db->where('product_id',intval($product_id));

            if($this->db->delete('users_watchlist')) {
                return true;
            } else {
                return false;
            }
        }
    }
