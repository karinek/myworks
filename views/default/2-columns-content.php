<div class="contentLeft">
	<?php $this->load->view('modules/product/category-menu'); ?>
	<?php $this->load->view('modules/links-left'); ?>
	<?php $this->load->view('modules/ads-left'); ?>
</div>
<div class="contentRight">
<!--	<div id="slideshow">
		<div class="ribbon"></div>
		<div class="slideBox">
			<img src="<?php echo base_url('images/slideshowImage.jpg'); ?>" alt="image" />
			<img src="<?php echo base_url('images/slideshowImage.jpg'); ?>" alt="image" />
			<img src="<?php echo base_url('images/slideshowImage.jpg'); ?>" alt="image" />
			<img src="<?php echo base_url('images/slideshowImage.jpg'); ?>" alt="image" />
			<img src="<?php echo base_url('images/slideshowImage.jpg'); ?>" alt="image" />
		</div>
		<div class="slideNav clearfix">

		</div>
	</div>-->
    <!-- TOP SLIDER -->
                <div id="slider" class="nivoSlider">
                	<img src="<?php echo base_url(); ?>images/slider1.jpg" width="745" height="302" alt="" />
                    <img src="<?php echo base_url(); ?>images/slider2.jpg" width="745" height="302" alt="" />
                    <img src="<?php echo base_url(); ?>images/slider1.jpg" width="745" height="302" alt="" />
                    <img src="<?php echo base_url(); ?>images/slider2.jpg" width="745" height="302" alt="" />
                </div>
                <!-- End Top Slider -->
	<?php echo isset($content) ? $content : ''; ?>
	
</div>
<div class="featuredPartners">
	<h1>Featured Partners</h1>
	<img src="<?php echo base_url('images/partners1.jpg'); ?>" alt="partner" />
	<img src="<?php echo base_url('images/partners2.jpg'); ?>" alt="partner" />
	<img src="<?php echo base_url('images/partners3.jpg'); ?>" alt="partner" />
	<img src="<?php echo base_url('images/partners4.jpg'); ?>" alt="partner" />
	<img src="<?php echo base_url('images/partners5.jpg'); ?>" alt="partner" />
	<img src="<?php echo base_url('images/partners6.jpg'); ?>" alt="partner" />
	<img src="<?php echo base_url('images/partners7.jpg'); ?>" alt="partner" />
</div>