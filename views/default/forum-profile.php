<!-- PRODUCT TABS -->
<h3 class="page_links"><a href="<?=base_url()?>">Home</a> &gt; <a href="<?=base_url('forum')?>">Forum </a>
<?php if(!empty($breadcrumbs)): ?>
	<?php foreach($breadcrumbs as $breadcrumb): ?>
	&nbsp;&gt;&nbsp;<a href="<?=$breadcrumb->link?>"><?=$breadcrumb->title?></a>
	<?php endforeach; ?>
<?php endif; ?>
</h3>
<div id="office_tabs_block" class="member_profile_border">
	<div id="office_tabs_content" class="member_profile_wrapper">
		<?=isset($content)?$content:''?>
	</div>
</div>

<!-- End Product Tabs --> 

