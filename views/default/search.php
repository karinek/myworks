<!-- LEFT BAR -->
<div id="left_bar">
        <?php $this->load->view('modules/product/category-menu'); ?>
	<?php $this->load->view('modules/links-left'); ?>
</div>
<div id="main_bar">
	<?php echo isset($content) ? $content : '';?>
</div>
