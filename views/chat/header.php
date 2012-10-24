<?php if(isset($user)): ?>

<p class="chat_title">Welcome: <span class="green">
	<?=$user['firstname']?>
	<?=$user['lastname']?>
	</span> you are now chatting with <span class="orange" id='usertotop'>
	<?php if(isset($userto['firstname'])): ?>
		<?=$userto['firstname']?>
		<?=$userto['lastname']?>
	<?php else: ?>
	N/A
	<?php endif; ?>
	</span></p>
<input type="hidden" id='chat_id' value='<?=$chat_id?>'/>
<input type="hidden" id='base_url' value='<?= base_url();?>'/>
<?php if(false): ?>
<?php if(isset($user['image'])): ?>
<img src="<?=base_url()?>images/user_images/<?=$user['image']?>" id="avatar">
<?php else: ?>
<img src="<?=base_url()?>images/avatars/no_avatar.jpg" id="avatar">
<?php endif; ?>
<div id="status">
	<?php if(isset($userID)&&$userID): ?>
	Welcome, <span id="username">
	<?=$user['firstname']?>
	<?=$user['lastname']?>
	</span>!
	<?php endif; ?>
</div>
<?php endif; ?>
<?php endif; ?>
