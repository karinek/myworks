<link rel="stylesheet" type="text/css" href="http://31.222.163.77/htmlpages/kolya/css/reset.css" />
<link rel="stylesheet" type="text/css" href="http://31.222.163.77/htmlpages/kolya/css/style.css" />
<link rel="stylesheet" type="text/css" href="http://31.222.163.77/htmlpages/kolya/css/nivo.css" />
<link rel="stylesheet" type="text/css" href="http://31.222.163.77/htmlpages/kolya/css/skin.css" />
<link rel="stylesheet" type="text/css" href="http://31.222.163.77/htmlpages/kolya/css/jquery.selectbox.css" />
<link rel="stylesheet" type="text/css" href="http://31.222.163.77/htmlpages/kolya/css/lightbox.css" />
<script type="text/javascript">
    $(function(){
        $('.products_head_form input').checkBox();
		$('#advanced_search_block input').checkBox();
    });
	
    function addToWatchlist(id){
        $("#popup").fadeIn("slaw");
        $("#contentBox").fadeIn("slaw");
        $.post("<?php echo base_url(); ?>addto/watchList/", {"data1":id},
        function(data){
            $("#contentBox").html(data);
        });
    }  
</script>
<script type="text/javascript">
	$(function () {
		$("#country_id1").selectbox();
		$("#country_id2").selectbox();
		$("#country_id3").selectbox();
		$("#country_id4").selectbox();
	});
</script>
<script type="text/javascript">
$(window).load(function() {
	$('#slider1').nivoSlider();
});
</script>
<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery('#latest_offers').jcarousel({
        wrap: 'circular',
		scroll: 1,
		auto:5,
		vertical: true
    });
});
</script>            
            <div class="category_top_block">
                <!-- TOP SLIDER -->
                <div id="slider1" class="nivoSlider1">
                    <img src="http://31.222.163.77/htmlpages/kolya/images/slider11.jpg" width="560" height="300" alt="" />
                    <img src="http://31.222.163.77/htmlpages/kolya/images/slider12.jpg" width="560" height="300" alt="" />
                    <img src="http://31.222.163.77/htmlpages/kolya/images/slider11.jpg" width="560" height="300" alt="" />
                    <img src="http://31.222.163.77/htmlpages/kolya/images/slider12.jpg" width="560" height="300" alt="" />
                </div>
                <!-- End Top Slider -->
             
                <div class="company_vertical_carusel">
                <ul id="latest_offers" class="jcarousel-skin">
                        	
                            <?php foreach ($bestProducts as $key => $best):?>
                            <li class="latest_offers_item">
                            	<ul class="latest_offers_item_right">
                                    <li class="latest_wishlist"><a onclick="addToWatchlist('<?php echo M_encrypt::encode($best['product_id']); ?>')">Add to Watchlist</a></li>
                                    <li class="latest_cart"><a href="#">Add to Cart</a></li>
                                </ul>
                                <div class="latest_offers_item_left">
                                	<a href="#"><img src="<?=base_url().((empty($best['image_name']))?"images/no_photo_detail.gif":"images/product_images/".$best['image_name']);?>" width="92" height="92" alt="" /></a>
                                </div>
                                <div class="latest_offers_item_main">
                                	<div class="like">
                                        <span id="<?php echo M_encrypt::encode($best['product_id']); ?>" class="like_mask"></span>
										<span class="like_arrow"><?=$best['liked']?></span>
                                    </div>
                                    <div class="best_price">
                                    	<span>Instant</span><br />Best Price<br/><span class="orange">Unit: <?=$best['unit']?></span>
                                    </div>
                                    <div class="offers_price">
                                    	<p class="textreflection"><span>$</span><?=$best['price']?></p>
                                    </div>
                                </div>
                            </li>
                            <?php endforeach;?>
                        </ul>
                </div>
            </div>
            
            <?php $_categories = $categories;?>
            <div class="trade_office_buyers top_block">
            	<div class="left_block">
                	<h3>A - C</h3>
                    
                    <?php foreach ($_categories as $key=>$_category):?>
                      <?php if(substr(strtolower($_category['category_name']),0,1) >= 'a' && substr(strtolower($_category['category_name']),0,1) <= 'c'):?>
                      <?php $_subcats = $this->m_category->getSubCategory($_category['category_id']);?>
	                    <h4><a href="<?=base_url() . 'category/show/' . $_category['category_id'] . '/' . urlencode(str_replace(array(' ', '&'), '_', $_category['category_name'])); ?>"><?=$_category['category_name']?> (<?=$_category['total_products']?>)</a></h4>
	                    <ul>
	                    	<?php foreach ($_subcats as $skey=>$_subcat):?>
	                    		<li><a href="<?=base_url() . 'category/show/' . $_subcat['category_id'] . '/' . urlencode(str_replace(array(' ', '&'), '_', $_subcat['category_name'])); ?>"><?=$_subcat['category_name']?></a></li>
	                    		<?php if($skey > 8) break;?>
	                        <?php endforeach;?>
		                   <?php if(count($_subcats) > 10):?><a>
	                    		<li><a href="<?=base_url() . 'category/show/' . $_category['category_id'] . '/' . urlencode(str_replace(array(' ', '&'), '_', $_category['category_name'])); ?>">...</a></li>		                   
		                   <?php endif;?>
	                    </ul>
	                   <?php endif;?> 
                    <?php endforeach;?>
                    <img class="bottom_img" src="images/medium_rectangle.jpg" width="300" height="250" alt="" />
                    
                </div>
                <div class="middle_block">
                	<h3>D - F</h3>
                    
                    <?php foreach ($_categories as $key=>$_category):?>
                      <?php if(substr(strtolower($_category['category_name']),0,1) >= 'd' && substr(strtolower($_category['category_name']),0,1) <= 'f'):?>
                      <?php $_subcats = $this->m_category->getSubCategory($_category['category_id']);?>
	                    <h4><a href="<?=base_url() . 'category/show/' . $_category['category_id'] . '/' . urlencode(str_replace(array(' ', '&'), '_', $_category['category_name'])); ?>"><?=$_category['category_name']?> (<?=$_category['total_products']?>)</a></h4>
	                    <ul>
	                    	<?php foreach ($_subcats as $skey=>$_subcat):?>
	                    		<li><a href="<?=base_url() . 'category/show/' . $_subcat['category_id'] . '/' . urlencode(str_replace(array(' ', '&'), '_', $_subcat['category_name'])); ?>"><?=$_subcat['category_name']?></a></li>
	                    		<?php if($skey > 8) break;?>
	                        <?php endforeach;?>
		                   <?php if(count($_subcats) > 10):?><a>
	                    		<li><a href="<?=base_url() . 'category/show/' . $_category['category_id'] . '/' . urlencode(str_replace(array(' ', '&'), '_', $_category['category_name'])); ?>">...</a></li>		                   
		                   <?php endif;?>
	                    </ul>
	                   <?php endif;?> 
                    <?php endforeach;?>
                    
                    <img class="bottom_img" src="images/medium_rectangle.jpg" width="300" height="250" alt="" />
                    
                </div>
                <div class="right_block">
                	
                    
                    <h3>G - H</h3>
                
                    <?php foreach ($_categories as $key=>$_category):?>
                      <?php if(substr(strtolower($_category['category_name']),0,1) >= 'g' && substr(strtolower($_category['category_name']),0,1) <= 'h'):?>
                      <?php $_subcats = $this->m_category->getSubCategory($_category['category_id']);?>
	                    <h4><a href="<?=base_url() . 'category/show/' . $_category['category_id'] . '/' . urlencode(str_replace(array(' ', '&'), '_', $_category['category_name'])); ?>"><?=$_category['category_name']?> (<?=$_category['total_products']?>)</a></h4>
	                    <ul>
	                    	<?php foreach ($_subcats as $skey=>$_subcat):?>
	                    		<li><a href="<?=base_url() . 'category/show/' . $_subcat['category_id'] . '/' . urlencode(str_replace(array(' ', '&'), '_', $_subcat['category_name'])); ?>"><?=$_subcat['category_name']?></a></li>
	                    		<?php if($skey > 8) break;?>
	                        <?php endforeach;?>
		                   <?php if(count($_subcats) > 10):?><a>
	                    		<li><a href="<?=base_url() . 'category/show/' . $_category['category_id'] . '/' . urlencode(str_replace(array(' ', '&'), '_', $_category['category_name'])); ?>">...</a></li>		                   
		                   <?php endif;?>
	                    </ul>
	                   <?php endif;?> 
                    <?php endforeach;?>
                    
                    
                </div>
            </div>
            
            <div class="trade_office_buyers bottom_block">
            	<div class="left_block">
                	<h3>I - O</h3>
                	
                    <?php foreach ($_categories as $key=>$_category):?>
                      <?php if(substr(strtolower($_category['category_name']),0,1) >= 'i' && substr(strtolower($_category['category_name']),0,1) <= 'o'):?>
                      <?php $_subcats = $this->m_category->getSubCategory($_category['category_id']);?>
	                    <h4><a href="<?=base_url() . 'category/show/' . $_category['category_id'] . '/' . urlencode(str_replace(array(' ', '&'), '_', $_category['category_name'])); ?>"><?=$_category['category_name']?> (<?=$_category['total_products']?>)</a></h4>
	                    <ul>
	                    	<?php foreach ($_subcats as $skey=>$_subcat):?>
	                    		<li><a href="<?=base_url() . 'category/show/' . $_subcat['category_id'] . '/' . urlencode(str_replace(array(' ', '&'), '_', $_subcat['category_name'])); ?>"><?=$_subcat['category_name']?></a></li>
	                    		<?php if($skey > 8) break;?>
	                        <?php endforeach;?>
		                   <?php if(count($_subcats) > 10):?><a>
	                    		<li><a href="<?=base_url() . 'category/show/' . $_category['category_id'] . '/' . urlencode(str_replace(array(' ', '&'), '_', $_category['category_name'])); ?>">...</a></li>		                   
		                   <?php endif;?>
	                    </ul>
	                   <?php endif;?> 
                    <?php endforeach;?>
                    
                    
                    <img class="bottom_img" src="images/rectangle.jpg" width="180" height="150" alt="" />
                    
                </div>
                <div class="middle_block">
                	<h3>P - S</h3>
                
                    <?php foreach ($_categories as $key=>$_category):?>
                      <?php if(substr(strtolower($_category['category_name']),0,1) >= 'p' && substr(strtolower($_category['category_name']),0,1) <= 's'):?>
                      <?php $_subcats = $this->m_category->getSubCategory($_category['category_id']);?>
	                    <h4><a href="<?=base_url() . 'category/show/' . $_category['category_id'] . '/' . urlencode(str_replace(array(' ', '&'), '_', $_category['category_name'])); ?>"><?=$_category['category_name']?> (<?=$_category['total_products']?>)</a></h4>
	                    <ul>
	                    	<?php foreach ($_subcats as $skey=>$_subcat):?>
	                    		<li><a href="<?=base_url() . 'category/show/' . $_subcat['category_id'] . '/' . urlencode(str_replace(array(' ', '&'), '_', $_subcat['category_name'])); ?>"><?=$_subcat['category_name']?></a></li>
	                    		<?php if($skey > 8) break;?>
	                        <?php endforeach;?>
		                   <?php if(count($_subcats) > 10):?><a>
	                    		<li><a href="<?=base_url() . 'category/show/' . $_category['category_id'] . '/' . urlencode(str_replace(array(' ', '&'), '_', $_category['category_name'])); ?>">...</a></li>		                   
		                   <?php endif;?>
	                    </ul>
	                   <?php endif;?> 
                    <?php endforeach;?>
                    
                    <img class="bottom_img" src="images/rectangle.jpg" width="180" height="150" alt="" />
                    
                    
                
                </div>
                <div class="right_block">
                	<h3>T - Z</h3>
                
                    <?php foreach ($_categories as $key=>$_category):?>
                      <?php if(substr(strtolower($_category['category_name']),0,1) >= 't' && substr(strtolower($_category['category_name']),0,1) <= 'z'):?>
                      <?php $_subcats = $this->m_category->getSubCategory($_category['category_id']);?>
	                    <h4><a href="<?=base_url() . 'category/show/' . $_category['category_id'] . '/' . urlencode(str_replace(array(' ', '&'), '_', $_category['category_name'])); ?>"><?=$_category['category_name']?> (<?=$_category['total_products']?>)</a></h4>
	                    <ul>
	                    	<?php foreach ($_subcats as $skey=>$_subcat):?>
	                    		<li><a href="<?=base_url() . 'category/show/' . $_subcat['category_id'] . '/' . urlencode(str_replace(array(' ', '&'), '_', $_subcat['category_name'])); ?>"><?=$_subcat['category_name']?></a></li>
	                    		<?php if($skey > 8) break;?>
	                        <?php endforeach;?>
		                   <?php if(count($_subcats) > 10):?><a>
	                    		<li><a href="<?=base_url() . 'category/show/' . $_category['category_id'] . '/' . urlencode(str_replace(array(' ', '&'), '_', $_category['category_name'])); ?>">...</a></li>		                   
		                   <?php endif;?>
	                    </ul>
	                   <?php endif;?> 
                    <?php endforeach;?>
                    
                    <img class="bottom_img" src="images/medium_rectangle.jpg" width="300" height="250" alt="" />
                
                </div>
            </div>
			<div id="contentBox"></div>