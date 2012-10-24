<!--<div id="trade_block"><br/>
    <div><a href="<?=$tradeshows->external_url;?>"><?=$tradeshows->title;?></a></div><br/>
    <div><img src="<?=base_url()."images/tradeshows/".$tradeshows->logo_url;?>"/> </div><br/>
    <div><?=$tradeshows->date_from;?></div><br/>
    <div><?=$tradeshows->date_to;?></div><br/>
    <div><?=$tradeshows->venue;?></div><br/>
    <div><?=$tradeshows->descritpion;?></div><br/>
</div>-->
<div id="products_detail_trade_show">
                <p><h3 class="page_links"><a href="<?=base_url()?>">Home</a>
&nbsp;&gt;&nbsp;Trade Show</p>	
                    <!-- PRODUCT DESCRIPTION -->
                    <?php foreach ($tradeshows as $ts): ?>
                    <div class="trade_show">
                        <img src="<?php echo base_url('images/tradeshows/'.$ts->logo_url); ?>" width="260" height="260" alt="" />
                        <div class="trade_show_desc">
                            <div class="head">
                                <h2><?=$ts->title?></h2>
                            </div>
                            <p><b>Date: From - </b> <?=$ts->date_from?>, <b>To - </b> <?=$ts->date_to?></p>
                            <p><b>Website: <a href="<?=$ts->external_url?>" target="_blank"><?=$ts->external_url?></a></b></p>
                            <p><b>Time: <?=$ts->time_from?> - <?=$ts->time_to?></b></p>
                            <p><b>Location:</b> <?=$ts->venue?></p>
                            <p><b>Additional Information:</b><br/><?=nl2br($ts->description)?></p>
                        </div> 
                    </div>
                    <?php endforeach; ?>
                    <!-- End Product Description -->
                    <!-- PRODUCT DESCRIPTION -->
                    <!-- End Product Description -->
                    
                </div>