<div style="min-height:63px; position: relative; margin-bottom:-30px;"><h3 class="page_links" style="margin:0; position:absolute; bottom:7px;"><a href="<?=base_url()?>">Home</a>
<?php if(!empty($breadcrumbs)): ?>
	<?php foreach($breadcrumbs as $breadcrumb): ?>
	&nbsp;&gt;&nbsp;<a href="<?=$breadcrumb['link']?>"><?=$breadcrumb['title']?></a>
	<?php endforeach; ?>
<?php endif; ?></h3></div>

<!-- LEFT MENU -->
    <div id="product_left_menu" style="margin-top: 30px;">
        <?php $category = $this->m_category->getCategory($cat_id); ?>
        <?php $subCategories = $this->m_category->getSubCategories($cat_id); ?>
        <?php //echo "<pre>"; var_dump($subCategories); echo "</pre>"; exit; ?>
        <div class="menu_head"><span><?php echo $category->category_name; ?></span></div>
        <ul class="product_left_menu_list">
            <?php if(isset($subCategories['sub'][$cat_id]) && !empty($subCategories['sub'][$cat_id])){ ?>
                <?php foreach($subCategories['sub'][$cat_id] as $value){ ?>
                    <li class="product_left_menu_list_head wrapp">
                        <span><a href="<?=base_url() . 'category/show/' . $value['category_id']; ?>" style="padding-left:0; color:#44463A;">
                            <?php echo $value['category_name']; ?></a></span>
                        <?php if(isset($subCategories['sub_sub'][$value['category_id']]) && !empty($subCategories['sub_sub'][$value['category_id']])){ ?>
                            <ul>
                            <?php foreach($subCategories['sub_sub'][$value['category_id']] as $value1){ ?>
                                <li><a href="<?=base_url() . 'category/show/' . $value1['category_id']; ?>"><?php echo $value1['category_name']; ?></a></li>
                            <?php } ?>
                            </ul>
                        <?php } ?>
                    </li>
                <?php } ?>
            <?php } ?>
<!--            <li class="product_left_menu_list_head">
                    <span>Load More</span>
            </li>-->
        </ul>
    </div>
<!-- End Left Menu -->

