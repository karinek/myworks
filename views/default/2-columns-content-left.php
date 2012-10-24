<!-- LEFT BAR -->
<div id="left_bar">
        <?php if(isset($modules) && M_misc::checkModule($modules,'category-menu')) $this->load->view('modules/product/category-menu'); ?>
        <?php $this->load->view('modules/links-left'); ?>
        <?php //$this->load->view('modules/ads-left'); ?>
</div>
<div id="main_bar">
        <?php $this->load->view('modules/slideshow-home'); ?>
        <?php echo isset($content) ? $content : '';?>

</div>
<?php //$this->load->view('modules/featured-partners'); ?>

