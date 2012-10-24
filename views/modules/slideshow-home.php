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
                <div id="slider" class="nivoSlider">
						<?php foreach($slides as $slide): ?>
								<img src="<?=base_url('images/main_sliders/'.$slide['name'])?>" width="745" height="300" alt="" />
						<?endforeach?>
                </div>      
