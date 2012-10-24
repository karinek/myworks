<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Trade Office<?php echo isset($title) ? ' - '.$title : ''; ?></title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<?=link_tag('css/reset.css')?>
	<?=link_tag('css/style.css')?>
	<?=link_tag('css/nivo.css')?>
	<?=link_tag('css/skin.css')?>
	<?=link_tag('css/jquery.selectbox.css')?>   
	<?=link_tag('css/jquery.jscrollpane.css')?>
	<?=link_tag('js/shadowbox/shadowbox.css')?>
	<script type="text/javascript" src="<?=base_url()?>js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>js/jquery.colorbox.js"></script>
	<script type="text/javascript" src="<?=base_url()?>js/jquery-ui-1.8.18.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>js/jquery.nivo.slider.pack.js"></script>
	<script type="text/javascript" src="<?=base_url()?>js/jquery.jcarousel.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>js/jquery.ui.widget.js"></script>
	<script type="text/javascript" src="<?=base_url()?>js/ui.checkbox.js"></script>
	<script type="text/javascript" src="<?=base_url()?>js/jquery.selectbox-0.1.3.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>js/jquery.reveal.js"></script>
	<script type="text/javascript" src="<?=base_url()?>js/shadowbox/shadowbox.js"></script>
	<script type="text/javascript" src="<?=base_url()?>js/app.js"></script>

	<script type="text/javascript">
		if(typeof app == 'undefined') var app = {};
		app.base_url = function(uri){return '<?=base_url()?>'+(uri!=null?uri:'');};
        $(document).ready(function() {
			// hack for input box for changing the font color
			$('input').bind('click change',function(){
				var $this = $(this);
				$this.data('ori_setting',{
					value: $this.val(), 
					style: {
						'color':$this.css('color'),
						'font-style':$this.css('font-style'),
						'font-weight':$this.css('font-weight')
					}
				});
				$this.css({'color':'#44463A','font-style':'normal','font-weight':'bold'});
				$this.one('blur',function(){
					var $data = $this.data('ori_setting');
					if($this.val()==$data.value){
						$this.css($data.style);
					}
				})
			})
		});
	</script>
</head>
<body>
	<?=isset($content_prewrapper)?$content_prewrapper:''?>
	<?php if(!isset($layout)) $layout = 'one-column-page'; ?>
	<?php $this->load->view('default/'.$layout); ?>
	<div id="close_window"></div>

</body>
</html>