<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Trade Office<?php echo isset($title) ? ' - '.$title : ''; ?></title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<?php $this->load->view('default/head'); ?>
		
	<?=link_tag('css/chat/desktop.css')?>
	<?=link_tag('css/chat/themes/base/jquery.ui.all.css')?>
	<script src="<?=base_url()?>js/chat/ui/jquery.ui.tabs.js"></script>
	<script src="<?=base_url()?>js/chat/ui/jquery.ui.core.js"></script>
	<script src="<?=base_url()?>js/chat/ui/jquery.ui.widget.js"></script>
	<script src="<?=base_url()?>js/chat/ui/jquery.ui.mouse.js"></script>
	<script src="<?=base_url()?>js/chat/ui/jquery.ui.draggable.js"></script>
	<script src="<?=base_url()?>js/chat/ui/jquery.ui.position.js"></script>
	<script src="<?=base_url()?>js/chat/ui/jquery.ui.resizable.js"></script>
	<script src="<?=base_url()?>js/chat/ui/jquery.ui.dialog.js"></script>
	<?php if(!isset($userID)||!$userID): ?>
	<script>
	$(function() {
		// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
		
		$( "#auth-dialog").dialog({
			height: 540,
			width: 450,
			modal: true,
			close: false,
			title:'Sign in or Join Free now'
		});
	});
	$(function(){
		$("#signIn_Join").tabs();
	});
	</script>
	<script type="text/javascript" id="sourcecode">
	$(function(){
		$('.chat_dialogue_block_scroll').jScrollPane();
		
	});
	</script>
	<?php else: ?>
	<!--<script src="<?=base_url()?>js/chat/main.js"></script>	-->
	<script src="<?=base_url()?>js/chat.js"></script>	
	<?php endif; ?>
	<script>
	$(function() {
		$("#infoTabDiv").tabs();
	});
	</script>	
</head>
<body style="background-color:#FFFFFF;">
	<div id="popup" style="display:none"></div>
	<!-- HEADER -->
	<?php $this->load->view('chat/header'); ?>
	
	<?php if(!isset($layout)) $layout = 'chat'; ?>
	<?php $this->load->view('default/'.$layout); ?>
</body>
</html>