<div class="contentLeft">
	<?php if(isset($modules) && M_misc::checkModule($modules,'slidehow-home')) $this->load->view('modules/slideshow-home'); ?>
	<?php echo isset($content) ? $content : ''; ?>
</div>
<div class="contentRight">
	<?php if(isset($modules) && M_misc::checkModule($modules,'product/category-menu')) $this->load->view('modules/product/category-menu'); ?>
	<?php // $this->load->view('modules/links-left'); ?>
	<?php // $this->load->view('modules/ads-left'); ?>
</div>
