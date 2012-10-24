<?php 
//$__users =& M_misc::getUsers();

$mod_users = explode(',',$category->moderator);
$mod_links = array();
foreach($mod_users as $mod_user_id):
	$user =& M_misc::queryUser($mod_user_id,$this->m_forum);
	$mod_links[] = $user ? '<a href="'.base_url('forum/profile/'.$user->username).'" class="orange">'.$user->username.'</a>' : '';
endforeach;
echo implode(', ',$mod_links);
?>