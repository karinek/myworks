<script>
$().ready(function(){
    $("#go_to_page_list").selectbox();
});
</script>
<ul class="my_contacts_pagination" style="margin-top:15px; float:right; overflow:visible;">
        <li><a href="#">Last Page</a></li>
        <li class="next"><a href="#"></a></li>
        <li class="prev disable"><a href="#"></a></li>
        <li>Page <span>1</span> / 287</li>
        <li class="select">
            <select id="go_to_page_list">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                <option>6</option>
            </select>
        </li>
        <li>Go To Page</li>
    </ul>
    <div style="margin-top:15px;">
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
                <input type="text" class="text" name="q" value="eg... Search Mail" onfocus="if(this.value=='eg... Search Mail') this.value='';" onblur="if(!this.value) this.value='eg... Search Mail';">
            </div>
            <div class="search">
                <input type="submit" value="Search">
            </div>
        </form>
        
        <a class="forum_head_form_button" href="<?php echo base_url().'forum/post/topic/'.$category->id ?>">Post Topic</a>
        
        <div class="clear"></div>
    </div>
    <!-- End Forum Head Form -->
