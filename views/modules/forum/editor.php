<script type="text/javascript" src="<?php echo base_url(); ?>js/tiny_mce/jquery.tinymce.js"></script>
<textarea id="<?=$text_id?>" name="<?=$text_name?>" cols="<?=isset($text_cols) ? intval($text_cols) : 10?>" rows="<?=isset($text_rows) ? intval($text_rows) : 10?>"><?=isset($content)?"\r\n".$content:"\n"?></textarea>
<script>
	$('#<?=$text_id?>').tinymce({
		// Location of TinyMCE script
		script_url : '<?php echo base_url(); ?>js/tiny_mce/tiny_mce.js',
		width: <?=isset($text_width) ? intval($text_width) : 870?>,
		height: <?=isset($text_height) ? intval($text_height) : 270?>,
		// General options
		theme : "advanced",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist,bbcode",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,fontselect,fontsizeselect,|,emotions,|,cut,copy,paste,pastetext,pasteword,|,charmap,bullist,numlist,|,blockquote,|,undo,redo,|,link,unlink,image,code,|,insertdate,inserttime,|,forecolor,backcolor",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : false,
		theme_advanced_resizing : true,
		theme_advanced_resize_horizontal : false,

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",
	});	
</script>