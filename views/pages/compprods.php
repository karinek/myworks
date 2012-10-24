<h3 class="page_links"><a href="<?=base_url()?>">Home</a>&nbsp;&gt;&nbsp; <a href="<?=base_url()?>compdetail/<?php echo M_encrypt::encode($comp_id); ?>">Company</a>&nbsp; &gt; &nbsp;<a href="#">Products ( <span class="green"><?=number_format($allprods,0, '.', '')?></span> )</a></h3>
<!-- PRODUCT TABS -->
<div id="office_tabs_block">
    <ul id="office_tabs">
        <li class="my_office"><a href="<?php echo base_url(); ?>compdetail/<?php echo M_encrypt::encode($comp_id); ?>">Home</a></li>
        <li class="contacts_messages active">Products</li>
    </ul>
    <div id="office_tabs_content">
        <div class="my_office_page company">
            <div class="company_products_left">
                <h3>Products</h3>
<!--                <p class="online_offline"><a href="#" class="green">Online</a> - <a href="#">Offline</a></p>-->
                <ul>
                <?php foreach($comp_categories as $comp_category):?>							
                    <?php
                    if($comp_category['category_id']==$cat_id):
                        $class = "class='active'";
                    else:
                        $class = "";
                    endif;
                    ?>
                    <li <?php echo $class; ?> id="company<?=$comp_id;?>"><a href="#" onclick='changeCategory(<?=$comp_id?>,<?=$comp_category['category_id']?>,0);'><?=$comp_category['category_name']?>&nbsp;(<?=$comp_category['prodcnt']?>)</a></li>
                <?endforeach;?>
                </ul>
            </div>
            <div id='loading_div' style='display:none' align="center"><img src='<?=base_url()?>/images/ajax-loading.gif'/></div>
            <div class="company_products_right">
                <div class="company_products_head_form" style="overflow:visible;">
                    <form action="" class="products_search_form" onsubmit="return changeCategory(<?=$comp_id?>,<?=$cat_id?>,0);">
                        <div class="arrange_by select order">
                        <?php echo form_dropdown('arrange_by', array('0'=>'Arrange By','1'=>'Asc','2'=>'Desc'),empty($arrange_by)?'asc':$arrange_by," id='order' onchange='changeCategory(".$comp_id.",".$cat_id.",0);' ");?>
                        </div>
                        <div class="text_block">
                            <input type="text" class="text" value="eg... Search Mail" onfocus="if(this.value=='eg... Search Mail') this.value='';" onblur="if(!this.value) this.value='eg... Search Mail';" id='searchtext'/>
                        </div>
                        <div class="search">
                            <input type="submit" value="Search" onclick='return changeCategory(<?=$comp_id?>,<?=$cat_id?>,0);'/>
                        </div>
                    </form>
                    <?=get_company_products_paginator($comp_id,$cat_id,$page,$pages);?>
                </div>
                <div class="company_products_main_block">
                    <p class="menu_head"><?=(isset($category['category_name'])?$category['category_name']:'&nbsp;')?></p>
                    <?foreach($catProducts as $product):?>
                    <!-- PRODUCT DESCRIPTION -->
                    <div class="company_product_desc">
                        <div class="left">
                            <div class="img_block">
                                <?php if($product['image_name']): ?>
                                    <a href="<?=base_url()?>images/product_images/<?=$product['image_name']?>" rel="lightbox" title=""><img src="<?=base_url()?>images/product_thumbs/<?=$product['image_name']?>" width="157" height="228" alt=""/></a>
                                    <a href="<?=base_url()?>images/product_images/<?=$product['image_name']?>" rel="lightbox" title=""><img src="<?=base_url()?>images/lup.png" width="13" height="13" alt="" class="zoom"/></a>
                                <?php else: ?>
                                    <a href="<?=base_url()?>images/product_images/NA_image.jpg" rel="lightbox" title=""><img src="<?=base_url()?>/images/product_thumbs/NA_image.jpg" width="157" height="228" alt=""/></a>
                                    <a href="<?=base_url()?>images/product_images/NA_image.jpg" rel="lightbox" title=""><img src="<?=base_url()?>/images/lup.png" width="13" height="13" alt="" class="zoom"/></a>
                                    
                                <?php endif ?>
                            </div>
                        </div>
                        <div class="right">
                            <div class="head">
                                <h2><a href="<?=base_url();?>prodetail/<?=M_encrypt::encode($product['product_id']); ?>"><?=$product['name']?></a></h2>
                                <div class="like">
                                    <span class="like_mask" id="<?=M_encrypt::encode($product['product_id']);?>"></span>
                                            <span class="like_arrow"><?=(isset($product['liked'])?$product['liked']:0);?></span>
                                </div>
                            </div>
                            <p><b>Min. Order:</b> <?php echo $product['qty']." ".$product['qty_unit'] ?> <b>Price:</b> <?php echo $product['price_cur']." ".$product['price_1']. " to ".$product['price_2']." PER ".$product['price_unit']  ?><br/>
                            <b>Payment Terms:</b> <?php echo $product['pay_terms']; ?> <b>Supply Ability:</b> <?php echo $product['prod_capacity']." ".$product['prod_capacity_unit']." per ".$product['prod_capacity_per'] ?><br />
                            <p><b>Additional Information:</b><br/> <?php echo htmlspecialchars_decode($product['long_description']) ?></p>
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
                            
                            <ul class="company_product_desc_list">
                                <li class="select"><input type="checkbox" />Select</li>
                                <li class="contact_company"><a class="email_contact" href="<?php echo base_url(); ?>contact/send_message/<?=md5($product['product_id'])?>">Contact Company</a></li>
                                <li class="add_to_wishlist add_to_wishlist<?php echo M_encrypt::encode($product['product_id']); ?>">
                                <?php if(in_array($product['product_id'],$inWatchList)):?>On your Watch List
                                <?php else: ?><a href="#" onclick="addToWatchlist('<?php echo M_encrypt::encode($product["product_id"]); ?>')">Add To Watch List</a>
                                <?php endif; ?>
                                </li>
<!--                            <li class="add_to_wishlist"><a href="#" onclick="addToWatchlist(<?php echo $product['product_id']; ?>)">Add To Watch List</a></li>-->
                            </ul>
                        </div> 
                    </div>
                    <!-- End Product Description -->
                    <?endforeach;?>
                    <?=get_company_products_paginator($comp_id,$cat_id,$page,$pages);?>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="contentBox"></div>
<!-- End Product Tabs -->
<script type="text/javascript">
        $('#order').selectbox();
        function addToWatchlist(id){
            $("#popup").fadeIn("slaw");
            $("#contentBox").fadeIn("slaw");
            $.post("<?php echo base_url(); ?>addto/watchList/", {"data1":id},
            function(data){
                $('.add_to_wishlist' + id).html('On Your Wathlist');
                $("#contentBox").html(data);
            });
        }  
</script>  