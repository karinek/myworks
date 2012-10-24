<?php if($user): ?>
<li style="cursor:pointer" onclick='open("<?php echo base_url(); ?>chat/index/<?=$user['user_id']?>/<?=$user['company_id']?>/<?=$product_id?><?=$chat_type!=''?'/'.$chat_type:''?>","Chat","width=950,height=850,toolbar=no",true)'>
<!--<li style="cursor:pointer" onclick='openChat("<?php echo base_url(); ?>chat/index/<?=$user['user_id']?>/<?=$user['company_id']?>/<?=$product_id?>")'>-->
	<div style="background: transparent url(<?php echo base_url(); ?>/images/onlineNow.png) no-repeat left center;padding-left:33px;margin-top:-8px;margin-left:-15px">
		<div><strong><b>I'm Online</b></strong></div>
		<div style="margin-top:-15px"><strong><b>Chat Now!</b></strong></div>
	</div>
</li>
<?php else: ?>
<li>
	<div style="background: transparent url(<?php echo base_url(); ?>/images/offline.png) no-repeat left center;padding-left:33px;margin-left:-15px">
		<div><strong><b>I'm Offline</b></strong></div>
	</div>
</li>
<?php endif; ?>
