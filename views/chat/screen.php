
<div id='mainProccess' style='display:none;position:absolute'><img src='<?php echo base_url(); ?>images/ajax-loading.gif'/></div>
<?php if(!isset($userID)||!$userID): ?>
<?=$auth;?>
<?php endif; ?>
<ul id="chat_tabs">
	<?php foreach($usertolist as $temp_chat_id=>$info): ?>
	<?php
		$close=0;
		$class='class="chat_session userTab"';
		if(isset($chat_id)){
			if($temp_chat_id!=$chat_id){
				$class='class="another active userTab"';
				$close=1;
			}
		}
	?>
	<li <?=$class?> lang='<?=$temp_chat_id?>'> <a href="#"><span id='userto<?=$temp_chat_id?>' onclick="Chat.selectChat('<?php echo base_url(); ?>chat/showchat/<?=$temp_chat_id?>',$(this).parent().parent(),<?=$temp_chat_id?>);">
		<?=$info['firstname']?>
		<?=$info['lastname']?>
		</span>( <span class="red" id='cnt<?=$temp_chat_id?>'>0</span> )</a> <span class="chat_tab_close" id="close<?=$temp_chat_id?>"  onclick="Chat.closeChat('<?php echo base_url(); ?>chat/closechat/<?=$temp_chat_id?>',$(this));return false;" style="z-index:2000<?=($close==1)?'':'display:none;'?>">x</span> </li>
	<?php endforeach; ?>
</ul>
<div id='chatDiv'>
	<?php
		if(isset($chat_id))
		showchat($chat_id);
	?>
</div>
