<h3 class="page_links"><a href="<?=base_url()?>">Home</a> &gt; <a href="#"><?=$title?></a></h3>
<div class="conditional_page_wrapper">
	<div class="conditional_page">
	<?php echo isset($content)?$content:''; ?>
	</div>
</div>