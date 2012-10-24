<h3 class="page_links"><a href="<?=base_url()?>">Home</a>
<?php if(!empty($breadcrumbs)): ?>
	<?php foreach($breadcrumbs as $breadcrumb): ?>
	&nbsp;&gt;&nbsp;<a href="<?=$breadcrumb['link']?>"><?=$breadcrumb['title']?></a>
	<?php endforeach; ?>
<?php endif; ?></h3>

<!-- PRODUCT DESCRIPTION -->
            <div class="product_description">
           		<div class="left">
                	<div class="img_block">
                            <?php if(!empty($product_images)): ?>
                                <a href="<?=base_url()?>images/product_images/<?=$product_images['image_name']?>" rel="lightbox" title=""><img src="<?=base_url()?>images/product_thumbs/<?=$product_images['image_name']?>" width="250" alt=""/></a>
                                <a href="<?=base_url()?>images/product_images/<?=$product_images['image_name']?>" rel="lightbox" title=""><img src="<?=base_url()?>images/lup.png" width="13" height="13" alt="" class="zoom"/></a>
                            <?php else: ?>
                                <img src="<?php echo base_url() ?>images/product_images/NA_image.jpg" />
                            <?php endif; ?>
                        </div>
                </div>
               
                <div class="right">
                    <div class="head">
                        <h2><?php echo $product['name'] ?></h2>
                        <div class="like">
                           <span class="like_mask" id="<?=M_encrypt::encode($product_id);?>"></span>
                                        <span class="like_arrow"><?php echo ($product['liked'])?$product['liked']:0;?></span>
                        </div>

                    	</div>
                    <p><b>Min. Order:</b> <?php echo $product_order['qty']." ".$product_order['qty_unit'] ?> 
                    <b>Price:</b> <?php echo $product_order['price_cur']." ".$product_order['price_1']. " to ".$product_order['price_2']." PER ".$product_order['price_unit']  ?><br />
                    <b>Payment Terms:</b> <?php echo $product_order['pay_terms']; ?> 
                    <b>Supply Ability:</b> <?php echo $product_order['prod_capacity']." ".$product_order['prod_capacity_unit']." PER ".$product_order['prod_capacity_per'] ?></p>
                    <p><b>Additional Information:</b><br /> <?php echo $product['short_description']; ?> </p>
                    <p class="green">Assessed Supplier   -    <a href="<?=base_url();?>compdetail/<?=M_encrypt::encode($company['id']);?>" style="color:#00A651;"><?=$company['name'];?></a></p>
                    <?php if($company): ?>
                        <p><b>Country:</b>
                        <?php
                        foreach($countries as $country):
                            if($country['code'] == $company['country']):
                                echo $country['name'];
                                break;
                            endif;
                        endforeach; 
                        ?>
                        <b>Type:</b> <?php echo $company['business_type']; ?> 
                        <b>No of Employees:</b> <?php echo M_options::getNoEmployee($company['no_employee']) ?> <br/>
                        <b>Management Certification:</b>
                        <?php
                        $certifications = array();
                        $certification_array = array();
                        if($company['certification'] != ''):
                            $certification_array = explode('|', $company['certification']);
                        endif; 
                        foreach($certification_options as $certification_option):
                            if(in_array($certification_option['id'], $certification_array)):
                                $certifications[] = $certification_option['name'];
                            endif;
                        endforeach; 
                        echo implode(', ', $certifications);
                        ?>
                       </p>
                    <?php endif; ?>
                    <ul class="product_desc_list">
			<?php if($company['membership'] == 'Platinum'): ?>
				<li class="platinum_member">Platinum Member</li>
			<?php elseif($company['membership'] == 'Gold'): ?>
				<li class="gold_member">Gold Member</li>
			<?php endif ?>
                        <li class="contact_company"><a class="email_contact" href="<?php echo base_url(); ?>contact/send_message/<?=md5($product_id)?>">Contact Company</a></li>
                        <li class="add_to_wishlist">
                        <a href="#" onclick="addToWatchlist('<?php echo M_encrypt::encode($product["product_id"]); ?>')">Add To Watch List</a>
                        </li>
                        <li class="add_to_cart"><a href="#">Add To Cart</a></li>
                    </ul>
                </div> 
            </div>
            <!-- End Product Description -->
            
            <!-- PRODUCT TABS -->
            <div id="product_tabs_block">
            	<ul id="product_tabs">
                    <li class="product_details active"><a href="#">Product Details</a></li>
                    <li class="products_images"><a href="#">Product Images</a></li>
                   <!-- <li class="contact_company"><a href="#">Contact Company</a></li> -->
                </ul>
                <div id="product_tabs_content">
                	
                    <div class="product_details_page">
                    	<div class="left">
                            <p style="color: #00A651; font-size: 13px; font-weight: bold; height: 21px; line-height: 21px; margin-bottom:15px;">Product Attributes</p>
                            <?php foreach($product_attrs as $product_attr): ?>
                                <?php if($product_attr['attr_value'] != ''): ?>
                                        <p><b><?php echo $product_attr['attr_name']; ?></b>
                                        <?php if($product_attr['attr_value'] == 'other' || $product_attr['attr_value'] == 'Other'): ?>
                                                    <?php echo $product_attr['attr_other_value']; ?>
                                        <?php else: ?>
                                                    <?php echo $product_attr['attr_value']; ?>
                                        <?php  endif; ?>
                                        </p>
                                <?php endif; ?>
                            <?php endforeach; ?>

                        </div>
                        <div class="right">
                            <p style="color: #00A651; font-size: 13px; font-weight: bold; height: 21px; line-height: 21px;">Packaging & Delivery</p>
                            <p>
                            <b>Packaging Detail:</b> <?php echo $product_order['pkg_details']; ?> <br />
                            <b>Delivery Detail:</b> <?php echo $product_order['delivery_time']; ?><br />
                            </p>
                            
                            
                            <p>
                            <b>Keyword:</b> <?php echo $product['keywords'] ?> <br />
                            <b>Additional:</b> <?php echo htmlspecialchars_decode($product['long_description']); ?><br />


                            </p>

                        </div>
                        <div class="clear"></div>
                    </div>
                    
                    <div class="products_images_page">
                        <?php if(!empty($product_images)): ?>
                            <ul class="trade_list">
                                <li>
                                    <a href="#">
                                        <img src="<?=base_url()?>images/product_thumbs/<?=$product_images['image_name']?>" width="100" alt=""/>
                                        <span class="overlay" style="display:none; opacity:0; visibility:hidden;">
                                            <span><font>Date:</font> 21.04.13</span>
                                            <span><font>Time:</font> 13:00-22:00</span>
                                            <span><font>Location:</font> Sydney</span>
                                            <span class="more">More info</span>
                                        </span>
                                    </a>
                                </li>
                             </ul>
                        <?php endif; ?>
                    </div>
					<!--
                    <div class="contact_company_page">
                    	<form action="">
                        	<h2><span>Assessed Supplier</span> - Tianjin Yufeng Chemical Company. Ltd.</h2>
                            <p><input type="text" class="name" value="Name" onfocus="if(this.value=='Name') this.value='';" onblur="if(!this.value) this.value='Name';" /></p>
                            <p><input type="text" class="email" value="Email" onfocus="if(this.value=='Email') this.value='';" onblur="if(!this.value) this.value='Email';" /></p>
                            <textarea cols="" rows="" ></textarea>
                            <div class="checkbox_block">
                                <input type="submit" value="Submit Message"  class="submit"/>
                                <div class="checkbox"><input type="checkbox" /><label style="position: relative; left: 3px; top: 1px;">Quote</label></div>
                                <div class="checkbox"><input type="checkbox" /><label style="position: relative; left: 3px; top: 1px;">General Enquiry</label></div>
                            </div>
                        </form>
                    </div> -->
                </div>
            </div>
            <!-- End Product Tabs -->
            
            <!-- RELATED PRODUCTS -->
                    <div id="related_products" style="width:1000px;">
                    	<p class="menu_head">New Products</p>
                        <ul class="trade_list jcarousel-skin" id="mycarousel1">
                        <?php
                            foreach($newproducts as $new):
                        ?>
                        
                        	<li>
                                <a href="<?php echo base_url()?>prodetail/<?=M_encrypt::encode($new['product_id'])?>">
	                                <img src="<?=base_url('images/product_images/'.$new['image_name']); ?>" width="125" height="85" alt="" />
                                    <span class="overlay" style="display:none; opacity:0; visibility:hidden;">
                                    	<span><font>Date:</font> 21.04.13</span>
                                        <span><font>Time:</font> 13:00-22:00</span>
                                        <span><font>Location:</font> Sydney</span>
                                        <span class="more" onclick="window.location.href='<?php echo base_url()?>prodetail/<?=M_encrypt::encode($new['product_id'])?>';">More info</span>
                                    </span>
                                </a>
                            </li>
                        <?php
                            endforeach;
                        ?>
                        </ul>
                    </div>
                    <!-- End Related Products -->
                    
                    <!-- RELATED SEARCHES -->
                    <?php if(isset($related_products) && !empty($related_products)): ?>
                        <div id="related_searches">
                            <p class="menu_head">Related Searches:</p>
                                <div class="realted_searches_wrapper">
                                    <p><b>You may also be interested in :</b></p>
                                    <?php $i = 1; ?>
                                        <ul>
                                    <?php foreach($related_products as $related_product): ?>
                                            <li><a href="<?=base_url('prodetail/'.M_encrypt::encode($related_product->product_id));?>"><?=$related_product->name;?></a></li>
                                            <?php $i++; ?>
                                            <?php if($i%5 == 1): ?>
                                                </ul><ul>
                                            <?php endif; ?>

                                    <?php endforeach; ?>
                                         </ul>
<!--                                    <ul>
                                        <li class="email_li"><a href="#">Email This Page</a></li>
                                        <li class="print_li"><a href="#">Print This page</a></li>
                                    </ul>-->
                                </div>
                        </div>
                    <?php endif; ?>
                    <!-- End Related Searches -->
<div id="contentBox"></div>
<!-- End Product Tabs -->
<script type="text/javascript">
        $('#order').selectbox();
        function addToWatchlist(id){
            $("#popup").fadeIn("slaw");
            $("#contentBox").fadeIn("slaw");
            $.post("<?php echo base_url(); ?>addto/watchList/", {"data1":id},
            function(data){
                $('.add_to_wishlist').html('On Your Wathlist');
                $("#contentBox").html(data);
            });
        }  
</script>
<script type="text/javascript">
    $(function(){
        $('.contact_company_page input').checkBox();

    });
</script>
