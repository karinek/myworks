<div id="products_main_block">
    <p class="menu_head">Search Results</p>
    <?php if(!empty($buyers)){ ?>
        <ul class="my_contacts_pagination" style="clear:none; margin-top:6px;">
                <li><a href="?<?=$additional;?>&page=<?=$pagination['page'];?>">Last Page</a></li>
                <li class="next <?=$pagination['cur'] >= $pagination['page'] ?'disable':''?>"><?= $pagination['cur'] >= $pagination['page'] ? '<a href="#"></a>' : '<a href="?'.$additional.'&page='.($pagination['cur']+1).'"></a>' ?></li>
                <li class="prev <?=$pagination['cur'] <=1?'disable':''?>"><?= $pagination['cur'] <= 1 ? '<a href="#"></a>' : '<a href="?'.$additional.'&page='.($pagination['cur']-1).'"></a>' ?></li>
                <li>Page <span><?=$pagination['cur']?></span> / <?=$pagination['page']?></li>
        </ul>
        <?php foreach($buyers as $buyer){ ?>
            <!-- PRODUCT DESCRIPTION -->
            <div class="product_desc">
                <div class="left">
                    <div class="img_block">
                        <?php if(!empty($buyer->image)): ?>
                            <a href="<?=base_url()?>files/request/images/<?=$buyer->image?>" rel="lightbox" title=""><img src="<?=base_url()?>files/request/thumbs/<?=$buyer->image?>" width="157" alt=""/></a>
                            <a href="<?=base_url()?>files/request/images/<?=$buyer->image?>" rel="lightbox" title=""><img src="<?=base_url()?>images/lup.png" width="13" height="13" alt="" class="zoom"/></a>
                        <?php else: ?>
                            <img src="<?php echo base_url() ?>images/product_images/NA_image.jpg"/>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="right">
                    <div class="head">
                        <h2><a href="<?=base_url();?>buydetail/<?=M_encrypt::encode($buyer->id);?>"><?php echo $buyer->product_name; ?></a></h2>
                    </div>
                    <p><b>Quantity Required:</b> <b> <?php echo $buyer->order_quantity ?> <?php echo $buyer->order_quantity_unit; ?> </b> </p><br />
                    <p><b>Additional Information:</b><br /><?php echo $buyer->product_specification; ?></p>

                    <?=$buyer->is_assessed=='Y'?'<div class="assessed">Assessed Supplier&nbsp;-&nbsp;</div>':''?>
					<div class="green"><a href="<?php echo base_url(); ?>compdetail/<?php echo M_encrypt::encode($buyer->cid); ?>" style="color:#00A651;"> <?php echo (isset($buyer->compName))?$buyer->compName:''; ?></a>
						<div class="ballon">
							<p class="green"> <a href="<?php echo base_url(); ?>compdetail/<?php echo M_encrypt::encode($buyer->cid); ?>" style="color:#00A651;"> <?php echo (isset($buyer->compName))?$buyer->compName:''; ?></a> </p>
							<p><b>Address</b><br />
									<?php echo (isset($buyer->compAddress))?$buyer->compAddress:''; ?></p>
							<ul>
									<li><a href="<?php echo base_url(); ?>compdetail/<?php echo M_encrypt::encode($buyer->cid); ?>">View</a></li>
							</ul>
						</div>
                    </div>
                    <p><b>Country:</b> <?php echo $buyer->country; ?> <b>BusinessType:</b> <?php echo $buyer->business_type; ?><br />
                    </p>

                    <ul class="product_desc_list">
						<?php if($buyer->membership!='Free'): ?>
						<li class="gold_platinum_member <?=$buyer->membership=='Gold'?'gold':($buyer->membership=='Platinum'?'platinum':'free')?>">
								<a href="#"><?=$buyer->membership?> Member</a>
								<div class="gold_platinum_membership">
										<div class="gold_platinum_membership_image"></div>
										<div class="gold_platinum_membership_right">
												<small>Trade Office Verified </small>
												<p><?=$buyer->membership?> Member</p>
												<a href="<?=base_url();?>user/membership">Find Out More</a>
										</div>
								</div>
						</li>
						<?php endif; ?>
						<li class="contact_company"><a class="email_contact" href="<?php echo base_url(); ?>contact/send_message/<?=md5($buyer->id)?>/request">Contact Company</a></li>
						<?=get_company_online_element( $buyer->cid,$buyer->id,'request');?>
						<!--<li class="contact_company"><a href="mailto:<?php echo $buyer->email;?>">Contact now</a></li>-->
                    </ul>
                </div>
                    
                </div> 
            <!-- End Product Description -->
        <?php } ?>
    <?php } else { ?>
        <div class="product_desc">
		No Product Found
	</div>
    <?php } ?>        
</div>
