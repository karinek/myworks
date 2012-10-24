<script>
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

<div class="products_head_form">
	<form action="" method="get">
	<div class="form_controler">
	<?php $pagination['page'] = isset($pagination['page']) ? $pagination['page'] : 0 ?>
	<?php if(isset($source) && $source=='product'): ?>
		<ul class="my_contacts_pagination" style="clear:none; margin-top:6px;">
			<li><a href="?<?=$additional;?>&page=<?=$pagination['page'];?>">Last Page</a></li>
			<li class="next <?=$pagination['cur'] >= $pagination['page'] ?'disable':''?>">
				<?= $pagination['cur'] >= $pagination['page'] ? '<a href="#"></a>' : '<a href="?'.$additional.'&page='.($pagination['cur']+1).'"></a>' ?>
			</li>
			<li class="prev <?=$pagination['cur'] <=1?'disable':''?>">
				<?= $pagination['cur'] <= 1 ? '<a href="#"></a>' : '<a href="?'.$additional.'&page='.($pagination['cur']-1).'"></a>' ?>
			</li>
			<li>Page <span>	<?=$pagination['cur']?>	</span> / <?=$pagination['page']?> </li>
		</ul>
		<input type="hidden" name="category" value="<?=$option['cat_id']?>"/>
	<?php else: ?>
		<ul class="my_contacts_pagination" style="clear:none; margin-top:6px;">
			<li><a href="?<?=$additional;?>&page=<?=$pagination['page'];?>">Last Page</a></li>
			<li class="next <?=$pagination['cur'] >= $pagination['page'] ?'disable':''?>">
				<?= $pagination['cur'] >= $pagination['page'] ? '<a href="#"></a>' : '<a href="?'.$additional.'&page='.($pagination['cur']+1).'"></a>' ?>
			</li>
			<li class="prev <?=$pagination['cur'] <=1?'disable':''?>">
				<?= $pagination['cur'] <= 1 ? '<a href="#"></a>' : '<a href="?'.$additional.'&page='.($pagination['cur']-1).'"></a>' ?>
			</li>
			<li>Page <span>	<?=$pagination['cur']?>	</span> / <?=$pagination['page']?> </li>
		</ul>
	<?php endif; ?>
		<input type="hidden" name="keyword" value="<?=$option['keyword']?>"/>
		<input type="hidden" name="search_type" value="<?=$option['search_type']?>"/>
		<?php if(isset($option['time_period'])): ?>
			<input type="hidden" name="time_period" value="<?=$option['time_period']?>"/>
		<?php endif; ?>
	</div>
    <?php if(strpos($option['membership'], 'free')) $option['membership'] = ''; ?>
	<div class="checkbox"><input type="checkbox" name="membership[]" value="'platinum'" <?=(strpos($option['membership'], 'platinum'))?'checked="checked"':''?>/><label class="platinum_member">Platinum Member</label></div>
	<div class="checkbox"><input type="checkbox" name="membership[]" value="'gold'" <?=(strpos($option['membership'], 'gold'))?'checked="checked"':''?>/><label class="gold_member">Gold Member</label></div>
	<div class="checkbox"><input type="checkbox" name="is_assessed" value="1" <?=intval($option['is_assessed'])==1?'checked="checked"':''?>/><label class="assessed_suplier">Assessed</label></div>

	<div class="input_stage">
		<input type="submit" value="" id="searchFilter" class="submit"/>
	</div>
	</form>	
</div>
<div id="products_main_block">
	<p class="menu_head"><?=isset($source)&&$source=='product'?'Product List':'Search Results'?></p>
	<?php if(empty($products)): ?>
            <div class="product_desc">
                    No Product Found
            </div>
	<?php else: ?>
	<?php foreach($products as $product){ ?>
	<!-- PRODUCT DESCRIPTION -->
	<div class="product_desc">
            <div class="left">
                <div class="img_block">
                        <?php if ($product->image_name): ?>
                        <a href="<?php echo base_url().'images/product_images/'.$product->image_name ?>" rel="lightbox" title=""><img src="<?php echo base_url().'images/product_thumbs/'.$product->image_name ?>" width="150" /></a> <a href="<?php echo base_url().'images/product_thumbs/'.$product->image_name ?>" rel="lightbox" title=""><img src="<?php echo base_url(); ?>images/lup.png" width="13" height="13" alt="" class="zoom" /></a>
                        <?php else: ?>
                        <img src="<?php echo base_url().'images/product_images/NA_image.jpg'.$product->image_name ?>"/>
                        <?php endif ?>
                </div>
            </div>
            <div class="right">
                    <div class="head">
                            <h2><?php echo anchor('prodetail/'.M_encrypt::encode($product->product_id),$product->name); ?></h2>
                            <div class="like"> <span class="like_mask" id="<?=M_encrypt::encode($product->product_id);?>"></span> <span class="like_arrow"><?php echo ($product->liked)?$product->liked:0;?></span> </div>
                    </div>
                    <p><b>Min. Order:</b> <?php echo $product->qty." ". $product->qty_unit;?> <b>Price:</b> <?php echo $product->price_cur." ". $product->price_1 ."--".$product->price_2." pre ".$product->price_unit ;?> <br />
                    <b>Payment Terms:</b> <?php echo $product->pay_terms ?> <b>Supply Ability:</b> <?php echo $product->prod_capacity." ". $product->prod_capacity_unit ." pre ".$product->prod_capacity_per ;?></p>
                    <p><b>Additional Information:</b><br />
                            <?php echo $product->short_description; ?> <?php echo anchor('prodetail/'.M_encrypt::encode($product->product_id),'Read More',array('style'=>'color:#00A651;')) ?></p>
                    <?=$product->is_assessed=='Y'?'<div class="assessed">Assessed Supplier&nbsp;-&nbsp;</div>':''?><div class="green"><a href="<?php echo base_url(); ?>compdetail/<?php echo M_encrypt::encode($product->cid); ?>" style="color:#00A651;"> <?php echo (isset($product->compName))?$product->compName:''; ?></a>
                            <div class="ballon">
                                    <p class="green"> <a href="<?php echo base_url(); ?>compdetail/<?php echo M_encrypt::encode($product->cid); ?>" style="color:#00A651;"> <?php echo (isset($product->compName))?$product->compName:''; ?></a> </p>
                                    <p><b>Address</b><br />
                                            <?php echo (isset($product->compAddress))?$product->compAddress:''; ?></p>
                                    <ul>
                                            <li><a href="<?php echo base_url(); ?>compdetail/<?php echo M_encrypt::encode($product->cid); ?>">View</a></li>
                                    </ul>
                            </div>
                    </div>
                    <p><b>Country:</b> <?php echo $product->country; ?> <b>BusinessType:</b> <?php echo $product->business_type; ?> <b>No of Employees:</b> <?php echo M_options::getNoEmployee($product->no_employee) ?><br />
                            <b>Management Certification:</b>
                            <?php
                        $certifications = array();
                        $certification_array = array();
                        if($product->certification != ''):
                            $certification_array = explode('|', $product->certification);
                        endif; 
                        foreach($certification_options as $certification_option):
                            if(in_array($certification_option['id'], $certification_array)):
                                $certifications[] = $certification_option['name'];
                            endif;
                        endforeach; 
                        echo implode(', ', $certifications);
                        ?>
                            <br />
                    </p>
                    <ul class="product_desc_list">
                            <?php if($product->membership!='Free'): ?>
                            <li class="gold_platinum_member <?=$product->membership=='Gold'?'gold':($product->membership=='Platinum'?'platinum':'free')?>">
                                    <a href="#"><?=$product->membership?> Member</a>
                                    <div class="gold_platinum_membership">
                                            <div class="gold_platinum_membership_image"></div>
                                            <div class="gold_platinum_membership_right">
                                                    <small>Trade Office Verified </small>
                                                    <p><?=$product->membership?> Member</p>
                                                    <a href="<?=base_url();?>user/membership">Find Out More</a>
                                            </div>
                                    </div>
                            </li>
                            <?php endif; ?>
                            <li class="add_to_wishlist add_to_wishlist<?php echo M_encrypt::encode($product->product_id); ?>">
                                    <?php if(in_array($product->product_id,$inWatchList)):?>
                                    On your Watch List
                                    <?php else: ?>
                                    <a onclick="addToWatchlist('<?php echo M_encrypt::encode($product->product_id); ?>')">Add To Watch List</a>
                                    <?php endif; ?>
                            </li>
                            <li class="contact_company"><a class="email_contact" href="<?php echo base_url(); ?>contact/send_message/<?=md5($product->product_id)?>">Contact Company</a></li>
							<?=get_company_online_element( $product->cid,$product->product_id);?>
                    </ul>
                    <input type="hidden" class="productId<?php echo $product->product_id; ?>" value="<?php echo $product->product_id; ?>">
            </div>
	</div>
	<!-- End Product Description -->
	<?php } ?>
	<?php endif; ?>
	<!--    <a href="#" class="load_more">Load More</a>--> 
</div>
<div id="contentBox"></div>
