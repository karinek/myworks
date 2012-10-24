<script>
$(document).ready(function() {
    $('#edit_preview_id').click(function(){
        parent.history.back();
    });
    $('#submit_request_form').click(function(){
        $('#form_id').submit();
    });
});
</script>

<div class="product_description">
        <div class="left">
                    <div class="img_block">
                            <?php if(!empty($request->image)): ?>
                                <a href="<?=base_url()?>files/request/images/<?=$request->image?>" rel="lightbox" title=""><img src="<?=base_url()?>files/request/thumbs/<?=$request->image?>" width="157" height="228" alt=""/></a>
                                <a href="<?=base_url()?>files/request/images/<?=$request->image?>" rel="lightbox" title=""><img src="<?=base_url()?>images/lup.png" width="13" height="13" alt="" class="zoom"/></a>
                            <?php else: ?>
                                <img src="<?php echo base_url() ?>images/product_images/NA_image.jpg"/>
                            <?php endif; ?>
                        </div>
        </div>
        <div class="right">
                    <div class="head">
                        <h2><?php echo $request->product_name ?></h2>
            </div>
                    <p><b>Product Information:</b></p>
                    <p>
                        <b>Category:</b> <?php echo $request->catdisplay ?><br />
                        <b>Order quantity:</b> <?php echo $request->order_quantity.' '.$request->order_quantity_unit ?><br />
                        <b>Annual Purchase Volume:</b> <?php echo !empty($request->purchase_volume) ? $request->purchase_volume.' '.$request->purchase_volume_unit : ''?><br />
                        <b>Expired Time:</b> <?php echo $request->expired_time ?>
                    </p>
                    
                    <p><b>Supplier Information:</b></p>
                    <p>
                        <b>Supplier Location:</b> <?php echo $request->supplier_location ?><br />
                        <b>Shipping Terms:</b> <?php echo $request->shipping_terms ?><br />
                        <b>Preferred Unit price:</b> <?php echo $request->preferred_unit_price.' '.$request->currency ?><br />
                        <b>Destination Port:</b> <?php echo $request->destination_port ?><br />
                        <b>Payment Terms:</b> <?php echo $request->payment_terms ?><br />
                    </p>
            </div> 
</div>
            

<div id="product_tabs_block">
        <ul id="product_tabs">
                    <li class="product_details active"><a href="#">Details</a></li>
                    <li class="products_images"><a href="#">Product Images</a></li>
            </ul>
            <div id="product_tabs_content">
                    <div class="product_details_page">
                        <div class="left">
            <p><b>Details and Description</b></p>
                        <?php echo nl2br($request->product_specification) ?>
                        </div>
                        <div class="right">
                    <p><b>Buyer Details</b></p>
                    <p>
                    <b>Represent company:</b> <?php echo $request->represent_company ?><br />
                    <b>Business Type:</b> <?php echo $request->business_type ?><br />
                    <b>Company Website:</b> <?php echo $request->website ?><br />
                    <b>Tel:</b> <?php echo $request->tel ?><br />
                    </p>
                        </div>
            </div>
            <div class="products_images_page">
                        <ul class="trade_list">
                            <?php echo img(base_url()."files/request/images/".$request->image)?>
            </ul>
                    </div>
                        <div class="clear"></div>
            </div>
</div>
            <!-- End Product Tabs -->