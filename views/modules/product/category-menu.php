<ul id="left_menu" >
	<li class="menu_head" onclick="javascript: window.location.href='<?=base_url()?>category';"><a href="<?=base_url()?>category">Browse Our Categories</a></li>
<?php if(!isset($this->m_category)): ?>
	<li>missing the Model</li>
<?php else : ?>
	<?php $categories = $this->m_category->getSubCategory(0); ?>
	<?php foreach($categories as $category): ?>
	<li><span><?=$category['category_name']?></span>
		<?php $subcats = $this->m_category->getSubCategory($category['category_id']) ?>
		<?php $n = count($subcats); ?>
		<?php if($n && is_array($subcats)): ?>
		<ul class="sub_category">
			<li class="sub_img_block">
				<h3>Ads</h3>
				<div>
					<img src="<?php echo base_url('images/ads/iphone_ad.jpg'); ?>" width="156" height="198" alt="" />
				</div>
			</li>
			<li class="sub_title"><a href="<?=base_url() . 'category/show/' . $category['category_id'] . '/' . urlencode(str_replace(array(' ', '&'), '_', $category['category_name'])); ?>"><?=$category['category_name']?> (<?=$category['total_products']?>)</a></li>
                            
			<?php for($i=0; $i < 9; $i++): ?>
				<?php if(!isset($subcats[$i]))continue; ?>
				<?php $subcat = $subcats[$i]; ?>
			<li><a href="<?=base_url() . 'category/show/' . $subcat['category_id'] . '/' . urlencode(str_replace(array(' ', '&'), '_', $subcat['category_name'])); ?>"><?=$subcat['category_name']?> (<?=$subcat['total_products']?>)</a></li>
			<?php endfor; ?>
			<?php if($n > 9): ?>
				<?php for($i=10; $i < $n; $i++): ?>
					<?php if(!isset($subcats[$i]))continue; ?>
					<?php $subcat = $subcats[$i]; ?>
							<li class="hide"><a href="#"><?=$subcat['category_name']?> (<?=$subcat['total_products']?>)</a></li>
				<?php endfor; ?>
			<li class="more" style="height:10px"><b>Load More...</b></li>
<!--                        <li class="less" style="height:33px; display:none; cursor:pointer;"><b>Load Less...</b></li>-->
			<?php endif; ?>
		</ul>
		<?php endif; ?>
	</li>
	<?php endforeach; ?>
<?php endif; ?>
</ul>
