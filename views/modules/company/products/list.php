<!-- might not used any more -->

<script type="text/javascript">
    $(document).ready(function() {
        $('.company_products_left li', this).live('click',function(){
            window.history.pushState({}, '', '/tradeoffice/company/products/<?php echo $company_id; ?>/' + $(this).attr('id')); 
            $('.company_products_left li').removeClass('active');
            $(this).addClass('active');
                            $('.ajax').hide();
            setInterval($('.ajaxImage').css('display', 'block'), 1000);
            var url = '/tradeoffice/company/products/<?php echo $company_id; ?>/' + $(this).attr('id');
                    $.post(url,
                    function(data){
                            $('.ajaxImage').css('display', 'none');
                            $('.company_products_main_block').html(data);
                        });
        });
    })
</script>
<!-- PRODUCT TABS -->
            <div id="office_tabs_block">
            	<ul id="office_tabs">
                    <li class="my_office"><a href="<?php echo base_url(); ?>company/details/<?php echo $company_id; ?>">Home</a></li>
                    <li class="contacts_messages active">Products</li>
                    <li class="company_page"><a href="#">Contact</a></li>
                </ul>
                <div id="office_tabs_content">
                	<div class="my_office_page company">
                    	<div class="company_products_left">
                        	<h3>Products</h3>
<!--                            <p class="online_offline"><a href="#" class="green">Online</a> - <a href="#">Offline</a></p>-->
                            <ul>
                                <li class="<?php echo ($cat_id == 0)?'active':''; ?>" style="cursor:pointer" id="0">All Categories</li>
                                <?php foreach($categories as $cs):?>
                                <li class="<?php echo ($cat_id == $cs['category_id'])?'active':''?>" style="cursor:pointer" id="<?php echo $cs['category_id']; ?>"><?php echo $cs['category_name']; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        
                        <div class="company_products_right">
                        	<div class="company_products_head_form">
                                <form action="" class="products_search_form">
                                    <div class="check">
                                    	<a href="#"><i class="check_box"></i><i class="arrow"></i></a>
                                    </div>
                                    <div class="arrange_by">
                                    	<a href="#"><span>Arrange By</span><i class="arrow"></i></a>
                                    </div>
                                    <div class="text_block">
                                    	<input type="text" class="text" value="eg... Search Mail" onfocus="if(this.value=='eg... Search Mail') this.value='';" onblur="if(!this.value) this.value='eg... Search Mail';"/>
                                    </div>
                                    <div class="search">
                                        <input type="submit" value="Search"/>
                                    </div>
                                </form>
                                <ul class="my_contacts_pagination" style="clear:none; margin-top:6px;">
                                    <li><a href="#">Last Page</a></li>
                                    <li class="next"><a href="#"></a></li>
                                    <li class="prev disable"><a href="#"></a></li>
                                    <li>Page <span>1</span> / 287</li>
                                </ul>
                			</div>
                			<div class="company_products_main_block" style="position: relative">
                                            <image class="ajaxImage" src="<?php echo base_url(); ?>images/loader.gif">
                                            <div class="ajax">
                				<p class="menu_head"><?php echo ($category)?$category->category_name:'All Categories'; ?></p>
                                 <!-- PRODUCT DESCRIPTION -->                    
                                <?php if(!empty($products)){ ?>
                                    <?php foreach($products as $product){ 
                                        if(isset($product['image_name'])){}
                                        else
                                            $product['image_name'] = '';
                                            ?>
                                        <div class="company_product_desc">
                                            <div class="left">
                                                <div class="img_block">
                                                    <a href="<?php echo base_url(); ?>images/product_images/<?php echo $product['image_name'];?>" rel="lightbox" title=""><img src="<?php echo base_url(); ?>images/product_images/<?php echo $product['image_name'];?>" width="125" height="85" alt="" /></a>
                                                    <a href="<?php echo base_url(); ?>images/product_images/<?php echo $product['image_name'];?>" rel="lightbox" title=""><img src="<?php echo base_url(); ?>images/product_images/<?php echo $product['image_name'];?>" width="13" height="13" alt="" class="zoom" /></a>
                                                </div>
                                            </div>
                                            <div class="right">
                                                <div class="head">
                                                    <h2><?php echo $product['name']; ?></h2>
                                                    <div class="like">
                                                        <span class="like_arrow">692</span>
                                                    </div>
                                                </div>
                                                <p><b>Min. Order:</b> 1 Ton <b>Price:</b> US $900-1150 / Ton<br />
                                                <b>Payment Terms:</b> L/C,D/P,T/T <b>Supply Ability:</b> 50 Ton per Day</p>
                                                <p><b>Additional Information:</b><br /><?php echo $product['short_description']; ?> <?php echo anchor('prodetail/'.$product['product_id'],'Read More'); ?></p>
                                                
                                                <ul class="company_product_desc_list">
                                                    <li class="select"><input type="checkbox" />Select</li>
                                                    <li class="add_to_favorites"><a href="#">Add to Favorites</a></li>
                                                    <li class="contact_company"><a href="#">Contact Company</a></li>
                                                    <li class="add_to_wishlist"><a href="#">Add To Watchlist</a></li>
                                                </ul>
                                            </div> 
                                        </div>
                                    <?php } ?>
                                 <?php } ?>
                                <!-- End Product Description -->
                                
                                <ul class="my_contacts_pagination" style="margin-top:15px;">
                                    <li><a href="#">Last Page</a></li>
                                    <li class="next"><a href="#"></a></li>
                                    <li class="prev disable"><a href="#"></a></li>
                                    <li>Page <span>1</span> / 287</li>
                                </ul>
                    		
                            </div>
                                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Product Tabs -->