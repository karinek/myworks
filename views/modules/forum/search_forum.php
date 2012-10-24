<form action="<?=base_url('forum/search')?>" class="products_search_form forum">
	<input type="hidden" name="cat_id" value="<?=isset($category_id) ? intval($category_id): 0?>">
	<div class="arrange_by"> <a href="#"><span>Topics</span><i class="arrow"></i></a> </div>
	<div class="text_block">
		<input name="q" type="text" class="text" value="eg... Search Mail" onfocus="if(this.value=='eg... Search Mail') this.value='';" onblur="if(!this.value) this.value='eg... Search Mail';">
	</div>
	<div class="search">
		<input type="submit" value="Search">
	</div>
</form>
