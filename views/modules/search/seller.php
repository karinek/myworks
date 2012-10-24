<?php
$my_favourites = array();
$my_contacts = array();
$my_networks = array();
$userID = $this->m_session->isLogin();
if($userID){
    $my_favourites = $this->m_user->getFavouriteCompanyIds($userID);
    $my_contacts = $this->m_user->getContactCompanyIds($userID);
    $my_networks = $this->m_user->getNetworkCompanyIds($userID);
}
?>
<script type="text/javascript">
    var baseurl = '<?php echo base_url(); ?>';
//    jQuery(document).ready(function() {
//        jQuery('.like_mask.comp').click(function(){
//            var $this =  $(this);
//            $.get("<?php echo base_url()?>company/like_company/"+$(this).attr('id'), {}, function(data){
//                $(this).next().html(data);
//            });
//        });
//    });
</script>  
<div id="products_main_block">
    <p class="menu_head">Search Results</p>
    <?php if(!empty($sellers)): ?>
        <ul class="my_contacts_pagination" style="clear:none; margin-top:6px;">
            <li><a href="?<?=$additional;?>&page=<?=$pagination['page'];?>">Last Page</a></li>
            <li class="next <?=$pagination['cur'] >= $pagination['page'] ?'disable':''?>"><?= $pagination['cur'] >= $pagination['page'] ? '<a href="#"></a>' : '<a href="?'.$additional.'&page='.($pagination['cur']+1).'"></a>' ?></li>
            <li class="prev <?=$pagination['cur'] <=1?'disable':''?>"><?= $pagination['cur'] <= 1 ? '<a href="#"></a>' : '<a href="?'.$additional.'&page='.($pagination['cur']-1).'"></a>' ?></li>
            <li>Page <span><?=$pagination['cur']?></span> / <?=$pagination['page']?></li>
        </ul>
        <?php foreach($sellers as $seller){ ?>
            <!-- COMPANY DESCRIPTION -->
            <div class="product_desc">
                <div class="left">
                    <div class="img_block">
                        <?php if($seller->file != ''): ?>
                            <a href="<?php echo base_url(); ?>images/company_images/<?php echo $seller->file; ?>" rel="lightbox" title=""><img src="<?php echo base_url(); ?>images/company_images/<?php echo $seller->file; ?>" width="125" height="85" alt="" /></a>
                            <a href="<?php echo base_url(); ?>images/company_images/<?php echo $seller->file; ?>" rel="lightbox" title=""><img src="<?php echo base_url(); ?>images/lup.png" width="13" height="13" alt="" class="zoom" /></a>
                        <?php else: ?>
                            <img src="<?php echo base_url(); ?>images/product_images/NA_image.jpg" />
                        <?php endif; ?>
                    </div>
                </div>
                <div class="right">
                    <div class="head">
                        <h2><a href="<?=base_url("compdetail/".M_encrypt::encode($seller->id)); ?>"><?php echo $seller->name; ?></a> <?php echo ($seller->countryName)?'['.$seller->countryName.']':''; ?></h2>
                    </div>
                    <p><b>Address: </b> <?php echo $seller->address."\t".$seller->city."\t".$seller->countryName; ?><br />
                    <b>Year Registered: </b> <?php echo $seller->year; ?><br />
                    <b>Business Type: </b> <?php echo $seller->business_type; ?><br />
                    <b>Total No. Employees: </b> <?php echo M_options::getNoEmployee($seller->no_employee); ?><br />
                    <b>List Brands: </b> <?php echo $seller->brand; ?><br /></p>
                    
                    <p><b>Detailed Company Introduction:</b><br /><?php echo $seller->product_keyword; ?> <?php //echo anchor('prodetail/'.$product->product_id,'Read More'); ?></p>
                    <ul class="product_desc_list">
                        <li class="add_to_favorites" id="add_to_favorites<?php echo M_encrypt::encode($seller->id); ?>">
                            <?php if(in_array($seller->id, $my_favourites)): ?>
                                    My Favourite
                            <?php else: ?>
                                    <div class="details" id="linkAddCompanyFavourite<?php echo M_encrypt::encode($seller->id); ?>" data-favourite="<?php echo M_encrypt::encode($seller->id); ?>" >Add to Favourites</div>
                            <?php endif; ?>
                        </li>
                        <li class="contact_company" id="contact_company<?php echo M_encrypt::encode($seller->id); ?>">
                            <?php if(in_array($seller->id, $my_contacts)): ?>
                                    My Contact
                            <?php else: ?>
                                    <div class="details" id="linkAddCompanyContact<?php echo M_encrypt::encode($seller->id); ?>" data-contact="<?php echo M_encrypt::encode($seller->id); ?>" >Add to Contacts</div>
                            <?php endif; ?>
                        </li>
                        <li class="add_to_wishlist" id="add_to_wishlist<?php echo M_encrypt::encode($seller->id); ?>">
                            <?php if(in_array($seller->id, $my_networks)): ?>
                                    My Network
                            <?php else: ?>
                                    <div class="details" id="linkAddCompanyNetwork<?php echo M_encrypt::encode($seller->id); ?>" data-network="<?php echo M_encrypt::encode($seller->id); ?>" >Add To Networks</div>
                            <?php endif; ?>
                        </li>
						<?=get_company_online_element($seller->id,0);?>
                    </ul>
                </div> 
            </div>
            <!-- End Company Description -->
        <?php } ?>
    <?php else: ?>
        <div class="product_desc">
                No Product Found
        </div>
    <?php endif; ?>        
    <div id="contentBox">
    	
    </div>
</div>
