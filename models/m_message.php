<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_message extends CI_Model {

    var $fav_page = 1;
    var $fav_num = 6;
    var $start = 0;

    function __counstruct() {
        parent::__construct();
    }

    function getInboxMessages($user_id = 0, $page = false) {

        if ($page) {
            $getMessageInfo = $this->db->select('*')
                    ->from('message')
                    ->join('message_from_to', 'message_from_to.id = message.message_id')
                    ->join('message_starred', 'message_starred.message_id = message.id')
                    ->join('message_trash', 'message_trash.message_id = message.id')
                    ->where('message_trash.user_id', $user_id)
                    ->where('message_starred.user_id', $user_id)
                    ->where('message_from_to.to_user_id', $user_id)
                    ->where('message_starred.user_id', $user_id)
                    ->where('message_trash.trash !=', 1)
                    ->get();


            $total_rows = $getMessageInfo->num_rows();

            $start = ($this->fav_page - 1) * $this->fav_num;
            $this->start = $start;
            $limit = $this->db->limit($this->fav_num, $start);
            $this->fav_page = 1;
        }

        $getMessageInfo = $this->db->select('message.subject as subject,message.id as id,message.active as active,message_starred.star as favorite,message.date as date,company.name as from_name,message_file.file_path as path')
                ->from('message')
                ->join('message_from_to', 'message_from_to.id = message.message_id')
                ->join('company', 'company.id = message_from_to.from_company_id')
                ->join('message_starred', 'message_starred.message_id = message.id','left')
                ->join('message_trash', 'message_trash.message_id = message.id','left')
                ->join('message_file', 'message_file.message_id = message.message_id','left')
                ->where('message_trash.user_id', $user_id)
                ->where('message_from_to.to_user_id', $user_id)
                ->where('message_starred.user_id', $user_id)
                ->where('message_trash.trash !=', 1)
                ->order_by('message.id')
                ->limit($this->fav_num, $this->start)
                ->get();
		
        $messageInfo = array();
        for ($i = 0; $i < $getMessageInfo->num_rows(); $i++) {
            $messageInfo[$i]['from_company'] = $getMessageInfo->row($i)->from_name;
            $messageInfo[$i]['subject'] = $getMessageInfo->row($i)->subject;
            $messageInfo[$i]['date'] = $getMessageInfo->row($i)->date;
            $messageInfo[$i]['favorite'] = $getMessageInfo->row($i)->favorite;
            $messageInfo[$i]['id'] = $getMessageInfo->row($i)->id;
            $messageInfo[$i]['active'] = $getMessageInfo->row($i)->active;
            $messageInfo[$i]['path'] = $getMessageInfo->row($i)->path;
        }

        if ($page)
            return array('pagination' => array('rows' => $total_rows, 'page' => ceil($total_rows / $this->fav_num)), 'result' => $messageInfo);
        else
            return $messageInfo;
    }

    function getSearchMessages($user_id = 0, $keyword, $page = false) {
        if ($keyword == '')
            return false;
        $getMessageInfo = $this->db->select('message.subject as subject,message_from_to.to_user_id as userid,message.active as active,message.id as id,message_starred.star as favorite,message.date as date,company.name as from_name')
                ->from('message')
                ->join('message_from_to', 'message_from_to.id = message.message_id')
                ->join('company', 'company.id = message_from_to.from_company_id')
                ->join('message_starred', 'message_starred.message_id = message.id','left')
                ->where('message_starred.user_id', $user_id)
                ->where('(message_from_to.to_user_id = ' . $user_id . ' OR message_from_to.from_user_id = ' . $user_id . ')')
                ->where("(message.subject LIKE '%{$keyword}%' OR company.name LIKE '%{$keyword}%')")
                ->order_by('message.id')
                ->get();
        $messageInfo = array();
        for ($i = 0; $i < $getMessageInfo->num_rows(); $i++) {
            $messageInfo[$i]['from_company'] = $getMessageInfo->row($i)->from_name;
            $messageInfo[$i]['subject'] = $getMessageInfo->row($i)->subject;
            $messageInfo[$i]['date'] = $getMessageInfo->row($i)->date;
            $messageInfo[$i]['favorite'] = $getMessageInfo->row($i)->favorite;
            $messageInfo[$i]['id'] = $getMessageInfo->row($i)->id;
            $messageInfo[$i]['userid'] = $getMessageInfo->row($i)->userid;
            $messageInfo[$i]['active'] = $getMessageInfo->row($i)->active;
        }

        if ($page)
            return array('result' => $messageInfo);
        else
            return $messageInfo;
    }

    function getOutMessages($user_id = 0, $page = false) {

        if ($page) {
            $getMessageInfo = $this->db->select('*')
                    ->from('message')
                    ->join('message_from_to', 'message_from_to.id = message.message_id')
                    ->join('message_starred', 'message_starred.message_id = message.id')
                    ->join('message_trash', 'message_trash.message_id = message.id')
                    ->where('message_trash.user_id', $user_id)
                    ->where('message_starred.user_id', $user_id)
                    ->where('message_from_to.from_user_id', $user_id)
                    ->where('message_trash.trash !=', 1)
                    ->get();

            $total_rows = $getMessageInfo->num_rows();

            $start = ($this->fav_page - 1) * $this->fav_num;
            $this->start = $start;
            $limit = $this->db->limit($this->fav_num, $start);
            $this->fav_page = 1;
        }

        $getMessageInfo = $this->db->select('message.subject as subject,message.id as id,message_starred.star as favorite,message.date as date,company.name as to_name,message_file.file_path as path')
                ->from('message')
                ->join('message_from_to', 'message_from_to.id = message.message_id')
                ->join('company', 'company.id = message_from_to.to_company_id')
                ->join('message_starred', 'message_starred.message_id = message.id', 'left')
                ->join('message_trash', 'message_trash.message_id = message.id', 'left')
                ->join('message_file', 'message_file.message_id = message.message_id', 'left')
                ->where('message_trash.user_id', $user_id)
                ->where('message_starred.user_id', $user_id)
                ->where('message_from_to.from_user_id', $user_id)
                ->where('message_trash.trash !=', 1)
                ->order_by('message.id')
                ->limit($this->fav_num, $this->start)
                ->get();
        $messageInfo = array();
        for ($i = 0; $i < $getMessageInfo->num_rows(); $i++) {
            $messageInfo[$i]['to_company'] = $getMessageInfo->row($i)->to_name;
            $messageInfo[$i]['subject'] = $getMessageInfo->row($i)->subject;
            $messageInfo[$i]['date'] = $getMessageInfo->row($i)->date;
            $messageInfo[$i]['favorite'] = $getMessageInfo->row($i)->favorite;
            $messageInfo[$i]['id'] = $getMessageInfo->row($i)->id;
            $messageInfo[$i]['path'] = $getMessageInfo->row($i)->path;
        }

        if ($page)
            return array('pagination' => array('rows' => $total_rows, 'page' => ceil($total_rows / $this->fav_num)), 'result' => $messageInfo);
        else
            return $messageInfo;
    }

    function getStaredMessages($user_id = 0, $page = false) {
        if ($page) {
            $getMessageInfo = $this->db->select('*')
                    ->from('message')
                    ->join('message_from_to', 'message_from_to.id = message.message_id')
                    ->join('message_starred', 'message_starred.message_id = message.id','left')
                    ->where('message_starred.user_id', $user_id)
                    ->where('message_from_to.to_user_id', $user_id)
                    ->where('message_starred.star', 1)
                    ->get();


            $total_rows = $getMessageInfo->num_rows();

            $start = ($this->fav_page - 1) * $this->fav_num;
            $this->start = $start;
            $limit = $this->db->limit($this->fav_num, $start);
            $this->fav_page = 1;
        }

        $getMessageInfo = $this->db->select('message.subject as subject,message.id as id,message_starred.star as favorite,message_from_to.to_user_id as userid,message.active as active,message.date as date,company.name as from_name')
                ->from('message')
                ->join('message_from_to', 'message_from_to.id = message.message_id')
                ->join('company', 'company.id = message_from_to.from_company_id')
                ->join('message_starred', 'message_starred.message_id = message.id','left')
                ->where('message_starred.user_id', $user_id)
                ->where('message_starred.star', 1)
                ->order_by('message.id')
                ->limit($this->fav_num, $this->start)
                ->get();
        $messageInfo = array();
        for ($i = 0; $i < $getMessageInfo->num_rows(); $i++) {
            $messageInfo[$i]['from_company'] = $getMessageInfo->row($i)->from_name;
            $messageInfo[$i]['subject'] = $getMessageInfo->row($i)->subject;
            $messageInfo[$i]['date'] = $getMessageInfo->row($i)->date;
            $messageInfo[$i]['favorite'] = $getMessageInfo->row($i)->favorite;
            $messageInfo[$i]['id'] = $getMessageInfo->row($i)->id;
            $messageInfo[$i]['active'] = $getMessageInfo->row($i)->active;
            $messageInfo[$i]['userid'] = $getMessageInfo->row($i)->userid;
        }

        if ($page)
            return array('pagination' => array('rows' => $total_rows, 'page' => ceil($total_rows / $this->fav_num)), 'result' => $messageInfo);
        else
            return $messageInfo;
    }

    function getTrashMessages($user_id = 0, $page = false) {
        if ($page) {
            $getMessageInfo = $this->db->select('*')
                    ->from('message')
                    ->join('message_from_to', 'message_from_to.id = message.message_id')
                    ->join('message_trash', 'message_trash.message_id = message.id')
                    ->join('message_starred', 'message_starred.message_id = message.id')
                    ->where('message_starred.user_id', $user_id)
                    ->where('message_trash.user_id', $user_id)
                    ->where('message_trash.trash', 1)
                    ->get();


            $total_rows = $getMessageInfo->num_rows();

            $start = ($this->fav_page - 1) * $this->fav_num;
            $this->start = $start;
            $limit = $this->db->limit($this->fav_num, $start);
            $this->fav_page = 1;
        }

        $getMessageInfo = $this->db->select('message.subject as subject,message.id as id,message_from_to.to_user_id as userid,message.active as active,message_starred.star as favorite,message.date as date,company.name as from_name')
                ->from('message')
                ->join('message_from_to', 'message_from_to.id = message.message_id')
                ->join('company', 'company.id = message_from_to.from_company_id')
                ->join('message_trash', 'message_trash.message_id = message.id','left')
                ->join('message_starred', 'message_starred.message_id = message.id','left')
                ->where('message_starred.user_id', $user_id)
                ->where('message_trash.user_id', $user_id)
                ->where('message_trash.trash', 1)
                ->order_by('message.id')
                ->limit($this->fav_num, $this->start)
                ->get();
        $messageInfo = array();
        for ($i = 0; $i < $getMessageInfo->num_rows(); $i++) {
            $messageInfo[$i]['from_company'] = $getMessageInfo->row($i)->from_name;
            $messageInfo[$i]['subject'] = $getMessageInfo->row($i)->subject;
            $messageInfo[$i]['date'] = $getMessageInfo->row($i)->date;
            $messageInfo[$i]['favorite'] = $getMessageInfo->row($i)->favorite;
            $messageInfo[$i]['id'] = $getMessageInfo->row($i)->id;
            $messageInfo[$i]['userid'] = $getMessageInfo->row($i)->userid;
            $messageInfo[$i]['active'] = $getMessageInfo->row($i)->active;
        }

        if ($page)
            return array('pagination' => array('rows' => $total_rows, 'page' => ceil($total_rows / $this->fav_num)), 'result' => $messageInfo);
        else
            return $messageInfo;
    }

    function getMessageInfoById($id) {
        $getMessageInfo = $this->db->select('*,message.id as id,message.message_id as message_id')
                ->from('message')
                ->join('message_from_to', 'message_from_to.id = message.message_id', 'left')
                ->where('message.id', $id)
                ->get();
        return $getMessageInfo->row();
    }

    function getMessageIdByIds($ids) {
        $getMessageInfo = $this->db->select('message.message_id as message_id')
                ->from('message')
                ->where_in('message.id', $ids)
                ->get();
        $message_ids = array();
        for ($i = 0; $i < $getMessageInfo->num_rows(); $i++) {
            $message_ids[$i] = $getMessageInfo->row($i)->message_id;
        }
        return $message_ids;
    }

    function getAttachedFileById($id) {

        $getAttachedInfo = $this->db->select('message_file.id,message_file.file_path,message_file.message_id,message_file.name as name')
                ->from('message')
                ->join('message_file', 'message_file.message_id = message.message_id', 'right')
                ->where('message.id', $id)
                ->get();
        $attachedInfo = array();
        for ($i = 0; $i < $getAttachedInfo->num_rows(); $i++) {
            $attachedInfo[$i]['id'] = $getAttachedInfo->row($i)->id;
            $attachedInfo[$i]['file_path'] = $getAttachedInfo->row($i)->file_path;
            $attachedInfo[$i]['message_id'] = $getAttachedInfo->row($i)->message_id;
            $attachedInfo[$i]['name'] = $getAttachedInfo->row($i)->name;
        }
        return $attachedInfo;
    }

    function DeleteAttachedFileByIds($ids) {
        $dleteInfo = $this->db->select('message_file.file_path as file_path')
                ->from('message')
                ->join('message_file', 'message_file.message_id = message.message_id', 'right')
                ->where_in('message.id', $ids)
                ->get();

        for ($i = 0; $i < $dleteInfo->num_rows(); $i++) {

            if (file_exists(FCPATH . 'files/message/' . $dleteInfo->row($i)->file_path)) {
                unlink(FCPATH . 'files/message/' . $dleteInfo->row($i)->file_path);
            }
        }
    }

    function getFomCompanyNameById($id) {


        $getFromCompanyName = $this->db->select('company.name')
                ->from('message')
                ->join('message_from_to', 'message_from_to.id = message.message_id', 'left')
                ->join('company', 'company.id = message_from_to.from_company_id', 'left')
                ->where('message.id', $id)
                ->get();

        return $getFromCompanyName->row()->name;
    }

    function getToCompanyNameById($id) {


        $getFromCompanyName = $this->db->select('company.name')
                ->from('message')
                ->join('message_from_to', 'message_from_to.id = message.message_id', 'left')
                ->join('company', 'company.id = message_from_to.to_company_id', 'left')
                ->where('message.id', $id)
                ->get();

        return $getFromCompanyName->row()->name;
    }

    function getReplayById($id) {
        $getReplay = $this->db->select('message_from_to.from_company_id,message_from_to.from_user_id')
                ->from('message')
                ->join('message_from_to', 'message_from_to.id = message.message_id', 'left')
                ->join('company', 'company.id = message_from_to.from_company_id', 'left')
                ->where('message.id', $id)
                ->get();

        return $getReplay;
    }

    function parseKeyword($keyword) {
        preg_match_all('/".*?("|$)|((?<=[\\s",+])|^)[^\\s",+]+/', $keyword, $matches);
        $search_items = array_map(create_function('$a', 'return trim($a, "\\"\'\\n\\r ");'), $matches[0]);

        return $search_items;
    }

    function getInboxCount($user_id) {
        $getInboxcount = $this->db->select('*')
                ->from('message')
                ->join('message_from_to', 'message_from_to.id = message.message_id')
                ->join('message_trash', 'message_trash.message_id = message.id')
                ->where('message_trash.user_id', $user_id)
                ->where('message_from_to.to_user_id', $user_id)
                ->where('message_trash.trash !=', 1)
                ->get();
        return $getInboxcount->num_rows();
    }

    function getOutboxCount($user_id) {
        $getOutboxcount = $this->db->select('*')
                ->from('message')
                ->join('message_from_to', 'message_from_to.id = message.message_id')
                ->join('message_trash', 'message_trash.message_id = message.id')
                ->where('message_trash.user_id', $user_id)
                ->where('message_from_to.from_user_id', $user_id)
                ->where('message_trash.trash !=', 1)
                ->get();
        return $getOutboxcount->num_rows();
    }

    function getTrashCount($user_id) {
        $getTrashboxcount = $this->db->select('*')
                ->from('message')
                ->join('message_from_to', 'message_from_to.id = message.message_id')
                ->join('message_trash', 'message_trash.message_id = message.id', 'left')
                ->where('message_trash.user_id', $user_id)
                ->where('message_trash.trash =', 1)
                ->where('(message_from_to.to_user_id = ' . $user_id . ' OR message_from_to.from_user_id = ' . $user_id . ')')
                ->get();
        return $getTrashboxcount->num_rows();
    }

    function getStaredCount($user_id) {
        $getStaredboxcount = $this->db->select('*')
                ->from('message')
                ->join('message_from_to', 'message_from_to.id = message.message_id')
                ->join('message_starred', 'message_starred.message_id = message.id')
                ->where('message_starred.user_id', $user_id)
                ->where('message_starred.star', 1)
                ->where('(message_from_to.to_user_id = ' . $user_id . ' OR message_from_to.from_user_id = ' . $user_id . ')')
                ->get();
        return $getStaredboxcount->num_rows();
    }

    public function UpdateActive($id) {
        $this->db->where('id', $id);
        $this->db->set('active', 1);
        $this->db->update('message');
    }
    
    public function DeleteTrashMessage($day) {

        $getDeleteMessages = $this->db->select('message.id as id,message.message_id as message_id,message_trash.user_id as user_id')
                ->from('message')
                ->join('message_trash', 'message.id = message_trash.message_id')
                ->where('TO_DAYS( NOW( ) ) - TO_DAYS(`date`) > ', $day)
                ->where('trash', 1)
                ->get();
        $getDeleteMessage = array();
        for ($i = 0; $i < $getDeleteMessages->num_rows(); $i++) {



            $this->db->where('message_id', $getDeleteMessages->row($i)->id);
            $this->db->where('user_id', $getDeleteMessages->row($i)->user_id);
            $this->db->delete('message_starred');

            $getMessageTrahInfo = $this->db->select('*')
                    ->from('message_trash')
                    ->where('message_trash.message_id', $getDeleteMessages->row($i)->id)
                    ->get();

            if ($getMessageTrahInfo->num_rows() == 1) {
                $this->DeleteAttachedFileByIds($getDeleteMessages->row($i)->id);

                $this->db->where('id', $getDeleteMessages->row($i)->message_id);
                $this->db->delete('message_from_to');

                $this->db->where('message_id', $getDeleteMessages->row($i)->message_id);
                $this->db->delete('message_file');

                $this->db->where('id', $getDeleteMessages->row($i)->id);
                $this->db->delete('message');
            }

            $this->db->where('message_id', $getDeleteMessages->row($i)->id);
            $this->db->where('user_id', $getDeleteMessages->row($i)->user_id);
            $this->db->delete('message_trash');
        }
    }

}

?>