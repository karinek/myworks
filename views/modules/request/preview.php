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
                            <?php if(!empty($product_images)): ?>
                                <a href="<?=base_url()?>/images/product_images/<?=$request->image?>" rel="lightbox" title=""><img src="<?=base_url()?>/images/product_thumbs/<?=$request->image?>" width="157" height="228" alt=""/></a>
                                <a href="<?=base_url()?>/images/product_images/<?=$request->image?>" rel="lightbox" title=""><img src="<?=base_url()?>/images/lup.png" width="13" height="13" alt="" class="zoom"/></a>
                            <?php else: ?>
                                <img src="<?php echo base_url() ?>images/product_images/NA_image.jpg"/>
                            <?php endif; ?>
                        </div>
        </div>
        <div class="right">
                    <div class="head">
                        <h2><?php echo $request['product_name'] ?></h2>
            </div>
                    <p><b>Product Information:</b></p>
                    <p>
                        <b>Category:</b> <?php echo $request['catdisplay'] ?><br />
                        <b>Order quantity:</b> <?php echo $request['order_quantity'].' '.$request['order_quantity_unit'] ?><br />
                        <b>Annual Purchase Volume:</b> <?php echo !empty($request['purchase_volume']) ? $request['purchase_volume'].' '.$request['purchase_volume_unit'] : ''?><br />
                        <b>Expired Time:</b> <?php echo $request['expired_time'] ?>
                    </p>
                    
                    <p><b>Supplier Information:</b></p>
                    <p>
                        <b>Supplier Location:</b> <?php echo $request['supplier_location'] ?><br />
                        <b>Shipping Terms:</b> <?php echo $request['shipping_terms'] ?><br />
                        <b>Preferred Unit price:</b> <?php echo $request['unit_price'].' '.$request['currency'] ?><br />
                        <b>Destination Port:</b> <?php echo $request['destination_port'] ?><br />
                        <b>Payment Terms:</b> <?php echo $request['payment_terms'] ?><br />
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
                        <?php echo nl2br($request['product_specification']) ?>
                        </div>
                        <div class="right">
                    <p><b>Buyer Details</b></p>
                    <p>
                    <b>Represent company:</b> <?php echo $request['represent_company'] ?><br />
                    <b>Business Type:</b> <?php echo $request['business_type1'] ?><br />
                    <b>Company Website:</b> <?php echo $request['website'] ?><br />
                    <b>Tel:</b> <?php echo $request['tel1'].'-'.$request['tel2'].'-'.$request['tel3'] ?><br />
                    </p>
                        </div>
            </div>
            <div class="products_images_page">
                        <ul class="trade_list">
                            <?php echo img(base_url()."files/request/images/temp/".$request['image_name'])?>
            </ul>
                    </div>
                        <div class="clear"></div>
            </div>
</div>
            <!-- End Product Tabs -->
<div class="preview_view_buttons" id="submit_request_form">Submit</div>
<div id="edit_preview_id" class="preview_view_buttons">Edit</div>

<?php echo form_open_multipart('request/postBuyRequest/'/*.$company['id']*/, array('id'=>'form_id')); ?>
<input type="hidden" name="product_name" id="product_name" value="<?php echo $request['product_name'] ?>" />
<input type="hidden" name="category_id" id="category_id" value="<?php echo $request['category_id'] ?>" />
<textarea style="display: none;" name="product_specification" id="product_specification"><?php echo $request['product_specification'] ?></textarea>
<input type="hidden" name="image_name" id="image_name" value="<?php echo $request['image_name'] ?>" />
<input type="hidden" name="order_quantity" id="order_quantity" value="<?php echo $request['order_quantity'] ?>" />
<input type="hidden" name="order_quantity_unit" id="order_quantity_unit" value="<?php echo $request['order_quantity_unit'] ?>" />
<input type="hidden" name="purchase_volume" id="purchase_volume" value="<?php echo $request['purchase_volume'] ?>" />
<input type="hidden" name="purchase_volume_unit" id="purchase_volume_unit" value="<?php echo $request['purchase_volume_unit'] ?>" />
<input type="hidden" name="expired_time" id="expired_time" value="<?php echo $request['expired_time'] ?>" />
<input type="hidden" name="supplier_location" id="supplier_location" value="<?php echo $request['supplier_location'] ?>" />
<input type="hidden" name="shipping_terms" id="shipping_terms" value="<?php echo $request['shipping_terms'] ?>" />
<input type="hidden" name="unit_price" id="unit_price" value="<?php echo $request['unit_price'] ?>" />
<input type="hidden" name="currency" id="currency" value="<?php echo $request['currency'] ?>" />
<input type="hidden" name="destination_port" id="destination_port" value="<?php echo $request['destination_port'] ?>" />
<input type="hidden" name="payment_terms" id="payment_terms" value="<?php echo $request['payment_terms'] ?>" />
<input type="hidden" name="represent_company" id="represent_company" value="<?php echo $request['represent_company'] ?>" />
<input type="hidden" name="business_type1" id="business_type1" value="<?php echo $request['business_type1'] ?>" />                            
<input type="hidden" name="website" id="website" value="<?php echo $request['website'] ?>" />
<input type="hidden" name="tel1" id="tel1" value="<?php echo $request['tel1'] ?>" />
<input type="hidden" name="tel2" id="tel2" value="<?php echo $request['tel2'] ?>" />
<input type="hidden" name="tel3" id="tel3" value="<?php echo $request['tel3'] ?>" />
<input type="hidden" name="accept_terms" id="accept_terms" value="<?php echo $request['accept_terms'] ?>" />

<?php echo form_close(); ?>