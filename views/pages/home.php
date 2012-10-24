<script>
    function addToWatchlist(id){
        $("#popup").fadeIn("slaw");
        $("#contentBox").fadeIn("slaw");
        $.post("<?php echo base_url(); ?>addto/watchList/", {"data1":id},
        function(data){
            $("#contentBox").html(data);
        });
    }  
</script>

<div id="trade_block">
    <!-- BLOCK POPULAR LINKS -->
    <!--<ul id="popular_links">
        <li class="menu_head">Popular Links</li>
        <li><a href="#"><img src="images/trade_messenger.png" width="25" height="25" alt="" />Trade Messenger</a></li>
        <li><a href="#"><img src="images/trade_alerts.png" width="25" height="25" alt="" />Trade Alerts</a></li>
        <li><a href="#"><img src="images/favorites.png" width="25" height="25" alt="" />Favorites</a></li>
        <li><a href="#"><img src="images/sign_up.png" width="25" height="25" alt="" />Sign Up</a></li>
        <li><a href="#"><img src="images/calculator_tools.png" width="25" height="25" alt="" />Calculator Tools</a></li>
        <li><a href="#"><img src="images/company_info.png" width="25" height="25" alt="" />Company Info</a></li>
        <li><a href="#"><img src="images/user_support.png" width="25" height="25" alt="" />User Support</a></li>
        <li><a href="#"><img src="images/help_desk.png" width="25" height="25" alt="" />Help Desk</a></li>
    </ul>-->
    <!-- End Block Popular Links -->

    <!-- BLOCK TRADE PASS -->
    <div id="trade_pass">
        <p class="menu_head">Latest Offers</p>
        <ul id="latest_offers" class="jcarousel-skin">
            <?
            foreach ($bestProduct as $best) {

                echo "<li class=\"latest_offers_item\">
                            	<ul class=\"latest_offers_item_right\">
                                    <li class=\"latest_wishlist\"><a onclick=addToWatchlist('" . M_encrypt::encode($best['product_id']) . "')>Add to Watchlist</a></li>
                                    <li class=\"latest_cart\"><a href=\"#\">Add to Cart</a></li>
                                </ul>
                                <div class=\"latest_offers_item_left\">
                                	<a href=\"" . base_url() . "prodetail/" . M_encrypt::encode($best['product_id']) . "\"><img src=\"" . base_url() . "images/product_images/" . $best['image_name'] . "\" width=\"92\" height=\"92\" alt=\"\" /></a>
                                </div>
                                <div class=\"latest_offers_item_main\">
                                    <div style=\"overflow:hidden;\">                                        
                                        <div class=\"like\" >
                                            <span class=\"like_mask\" id=\"" . M_encrypt::encode($best['product_id']) . "\"></span>
                                            <span class=\"like_arrow\">" . $best['liked'] . "</span>
                                        </div>
                                        <div class=\"best_price\">
                                            <span>Instant</span><br />Best Price<br/><span class=\"orange\">Unit: ".$best['unit']."</span>
                                        </div>
                                    </div>                                    
                                    <div class=\"offers_price\">
                                    	<p class=\"textreflection\"><span>$</span>" . $best['price'] . "</p>
                                    </div>
                                </div>
                            </li>";
            }
            ?>
        </ul>
    </div>
    <!-- End Block Trade Pass -->

    <!-- BLOCK TRADE SHOWS -->
    <div id="trade_shows" style="width: 300px;">

        <p class="menu_head">Upcoming Trade Shows</p>
        <ul class="trade_list small">
            <li>
                <a href="<?php echo base_url(); ?>tradeshow/index">
                    <img src="<?php echo base_url(); ?>images/tradeshow_small1.jpg" width="80" height="54" alt="" />
                </a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>tradeshow/index">
                    <img src="<?php echo base_url(); ?>images/tradeshow_small2.jpg" width="80" height="54" alt="" />
                </a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>tradeshow/index">
                    <img src="<?php echo base_url(); ?>images/tradeshow_small3.jpg" width="80" height="54" alt="" />
                </a>
            </li>
            <?
            /* foreach ($tradeshows as $tradeshow)
              {
              echo "<li>
              <a href=\"./tradeshow/index/".$tradeshow['id']."\">
              <img src=\"". base_url()."images/tradeshows/".$tradeshow['logourl']."\" width=\"80\" height=\"54\" alt=\"\" />
              <span class=\"overlay\">
              <span><font>Title:</font>".$tradeshow['title']."</span>
              <span><font>From:</font>".$tradeshow['from']."</span>
              <span><font>To:</font>".$tradeshow['from']."</span>
              <span class=\"more\">More info</span>
              </span>
              </a>
              </li>";
              } */
            ?>

        </ul>
    </div>
    <!-- End Block Trade Shows -->

    <!-- HOT REGIONS -->
    <div id="hot_regions" style="width: 300px;">

        <p class="menu_head">Hot Regions</p>
        <ul class="regions">
            <?
            foreach ($hotregions as $hotregion) {
                echo "<li>
                                  <img src=\"" . base_url() . "images/flags/" . $hotregion['icon_url'] . "\" width=\"16\" height=\"11\" alt=\"" . $hotregion['country'] . "\" />" . $hotregion['country'] . "
                            </li>";
            }
            ?>
        </ul>
    </div>
    <!-- End Hot Regions -->

    <!-- NEW PRODUCTS -->
    <div id="new_products">
        <p class="menu_head">New Products</p>
        <?php if (count($newproducts) > 0): ?>
            <ul class="trade_list jcarousel-skin" id="mycarousel1">
                <?php foreach ($newproducts as $new): ?>
                    <li>
                        <a href="<?php echo base_url() ?>prodetail/<?= M_encrypt::encode($new['product_id']) ?>">
                            <img src="<?php echo base_url() ?>images/product_images/<?= $new['image_name'] ?>" width="125" height="85" alt="" />
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    <!-- End New Products -->

    <!-- FEATURED CATEGORIES -->
    <div id="featured_categories">
        <p class="menu_head">Featured Categories</p>
        <?php if (count($featuredcategories) > 0): ?> 
            <?php $part1 = array_slice($featuredcategories, 0, count($featuredcategories) / 2); ?>                       
            <?php $part2 = array_slice($featuredcategories, count($featuredcategories) / 2); ?>
            <ul class="trade_list jcarousel-skin" id="mycarousel2">
                <?php foreach ($part1 as $el): ?>
                    <li>
                        <a href="<?php echo base_url() ?>category/show/<?php echo $el['category_id'] . '/' . urlencode(str_replace(array(' ', '&'), '_', $el['category_name'])); ?>">
                            <img src="<?php echo base_url(); ?>images/category_images/<?php echo $el['image'] ?>" width="125" height="85" alt="" />
                            <span class="overlay" style="display:none; opacity:0; visibility:hidden;">
                                <span><font>Date:</font> 21.04.13</span>
                                <span><font>Time:</font> 13:00-22:00</span>
                                <span><font>Location:</font> Sydney</span>
                                <span class="more">More info</span>
                            </span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <ul class="trade_list jcarousel-skin" id="mycarousel3">
                <?php foreach ($part2 as $el): ?>
                    <li>
                        <a href="<?php echo base_url() ?>category/show/<?php echo $el['category_id'] . '/' . urlencode(str_replace(array(' ', '&'), '_', $el['category_name'])); ?>">
                            <img src="<?php echo base_url(); ?>images/category_images/<?php echo $el['image']; ?>" width="125" height="85" alt="" />
                            <span class="overlay" style="display:none; opacity:0; visibility:hidden;">
                                <span><font>Date:</font> 21.04.13</span>
                                <span><font>Time:</font> 13:00	-22:00</span>
                                <span><font>Location:</font> Sydney</span>
                                <span class="more">More info</span>
                            </span>				
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    <!-- End Featured Categories -->

    <div id="tables">
        <!-- CURRENCY WATCH -->
        <?php
        $this->load->view('modules/currency-watch');
        ?>
        <!-- End Currency Watch -->

        <!-- PRICE WATCH -->
        <div id="price_watch">
            <p class="menu_head">Price Watch</p>
            <table cellpadding="1" cellspacing="1" border="1">
                <tr>
                    <th width="40%" class="left">Commodity</th>
                    <th width="20%">%Change</th>
                    <th width="40%">Price per unit</th>
                </tr>
                <?php foreach ($pricewatchs as $pricewatch): ?>
                    <tr>
                        <td class="left"><?php echo $pricewatch['commodity'] ?></td>
                        <?php if ($pricewatch['change'] > 0): ?>
                            <td class="red">
                            <?php else: ?>
                            <td class="green">
                            <?php endif ?>
                            <?php echo $pricewatch['change'] ?>%</td>
                        <td><?php echo $pricewatch['price'] ?></td>
                    </tr>
                <?php endforeach ?>
            </table>
        </div>
        <!-- End Price Watch -->
    </div>

    <!-- FEATURED SUPPLIERS -->
    <div id="featured_suppliers">
        <p class="menu_head">Featured Suppliers</p>
        <ul class="trade_list">

            <?
            foreach ($topsuppliers as $topsupplier) {
                echo "<li>
                                <a href=\"./compdetail/" . M_encrypt::encode($topsupplier['id']) . "\">
	                                <img src=\"" . base_url() . "images/company_images/" . $topsupplier['image'] . "\" width=\"100\" height=\"85\" alt=\"\" />
                                </a>
                            </li>";
            }
            ?>
        </ul>
    </div>
    <!-- End Featured Suppliers -->

    <!-- Start newslider-vertical -->
    <div class="sliderkit newslider-vertical">


        <div class="sliderkit-nav">
            <div class="sliderkit-nav-clip">
                <ul>
                    <li><a href="#"><span class="sliderkit_title">Try Our New App</span><span class="sliderkit_text">Easy to use will the most relevant tools for on the go.</span></a></li>
                    <li><a href="#"><span class="sliderkit_title">Forum</span><span class="sliderkit_text">Ask questions, Discuss , Connect to people and more.... </span></a></li>
                    <li><a href="#"><span class="sliderkit_title">Help Desk</span><span class="sliderkit_text">24hr Phone Service for all Enquiries and Support issues.</span></a></li>
                </ul>
            </div>
        </div>


        <div class="sliderkit-panels">

            <div class="sliderkit-panel">
                <div class="sliderkit-news">
                    <a href="#"><img src="<?php echo base_url(); ?>images/bottom_slider_1.jpg" width="560" height="195" alt="" /></a>
                </div>
            </div>

            <div class="sliderkit-panel">
                <div class="sliderkit-news">
                    <a href="#"><img src="<?php echo base_url(); ?>images/bottom_slider_2.jpg" width="560" height="195" alt="" /></a>
                </div>
            </div>

            <div class="sliderkit-panel">
                <div class="sliderkit-news">
                    <a href="#"><img src="<?php echo base_url(); ?>images/bottom_slider_3.jpg" width="560" height="195" alt="" /></a>
                </div>
            </div>

        </div>

    </div>
    <!-- // end of newslider-vertical -->

    <!-- ADVERTISMENT -->
    <div id="adverstiment">
        <p class="menu_head">Adverstiment</p>
        <div class="advertisments_block">
            <a href=""><img src="<?php echo base_url(); ?>images/adverstiment_1.jpg" width="143" height="97" alt=""/></a>
            <div class="advertisments_block_text">
                <h3>THE NEW CANON EOS 5D MARK iii</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. dolore magna aliqua. dolore magna aliqua. dolore magna aliqua. </p>
                <a href="">www.canon.com.au/canon5dmarkiii/offers</a>
            </div>
        </div>

        <div class="advertisments_block">
            <a href=""><img src="<?php echo base_url(); ?>images/adverstiment_1.jpg" width="143" height="97" alt=""/></a>
            <div class="advertisments_block_text">
                <h3>THE NEW CANON EOS 5D MARK iii</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. dolore magna aliqua. dolore magna aliqua. dolore magna aliqua. </p>
                <a href="">www.canon.com.au/canon5dmarkiii/offers</a>
            </div>
        </div>
    </div>
    <!-- End Adverstiment -->
</div>

<div id="contentBox"></div>
