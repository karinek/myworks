    <div style="margin-top:15px; display:none;">
    	<a href="#"><b>Previous Topic</b></a> / <a href="#" class="green"><b>Next Topic</b></a>
    </div>
    <div class="clear"></div>
	<!-- Forum Head Form -->
    
    <div class="forum_head_form topic">
		<form action="<?=base_url('forum/search')?>" class="products_search_form forum">
			<div class="arrange_by">
				<a href="#"><span>Topics</span><i class="arrow"></i></a>
			</div>
			<div class="text_block">
				<input type="text" name="q" class="text" value="eg... Search Mail" onfocus="if(this.value=='eg... Search Mail') this.value='';" onblur="if(!this.value) this.value='eg... Search Mail';">
			</div>
			<div class="search">
				<input type="hidden" name="cat_id" value="<?php echo isset($cat_id)?$cat_id:0; ?>" />
				<input type="submit" value="Search">
			</div>
		</form>
        
        <a class="forum_head_form_button" href="<?php echo base_url().'forum/post/topic/'.$category->id ?>/new">Post Topic</a>
        <a class="forum_head_form_button" href="<?=base_url('forum/post/comment/'.$topic->id.'/0')?>">Post Reply</a>
        
        <div class="clear"></div>
    </div>
    <!-- End Forum Head Form -->
