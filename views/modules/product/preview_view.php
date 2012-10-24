<script>
$(document).ready(function() {
	    $('#edit_preview_id').click(function(){
			 parent.history.back();
			
			});
});
	    
</script>

<div class="product_description">
	    <div class="left">
                	<div class="img_block">
                    	<a href="<?php echo base_url(); ?>images/product_images/<?php echo $product_images['image_name']; ?>" rel="lightbox" title=""><img src="<?php echo base_url(); ?>images/product_images/<?php echo $product_images['image_name']; ?>" width="250" alt="" /></a>
                        <a href="<?php echo base_url(); ?>images/product_images/<?php echo $product_images['image_name']; ?>" rel="lightbox" title=""><img src="<?php echo base_url(); ?>images/lup.png" width="13" height="13" alt="" class="zoom" /></a>
			</div>
	    </div>
	    <div class="right">
                    <div class="head">
                        <h2><?php echo $product['name'] ?></h2>
		    </div>
                    <p><b>Min. Order:</b> <?php echo $product_order['qty']." ".$product_order['qty_unit'] ?> 
                    <b>Price:</b> <?php echo $product_order['price_cur']." ".$product_order['price_1']. " to ".$product_order['price_2']." PER ".$product_order['price_unit']  ?><br />
                    <b>Payment Terms:</b> <?php echo $product_order['pay_terms']; ?> 
                    <p><b>Additional Information:</b><br /> <?php echo $product['short_description'] ?> </p>
                    <p><b>Supply Ability:</b><?php echo $product_order['prod_capacity']." ".$product_order['prod_capacity_unit']." PER ".$product_order['prod_capacity_per'] ?></p>
            </div> 
</div>
            

<div id="product_tabs_block">
	    <ul id="product_tabs">
                    <li class="product_details active"><a href="#">Product Details</a></li>
                    <li class="products_images"><a href="#">Product Images</a></li>
            </ul>
            <div id="product_tabs_content">
                	<div class="product_details_page">
                    	<div class="left">
			<b>Product Attributes</b>
                        <table>
				    <?php foreach($product_attrs as $product_attr): ?>
				    <tr>
						<?php if($product_attr['attr_value'] != ''): ?>
						<th style="text-align:left;height:50px;"><?php echo $product_attr['attr_name'] ?></th>
							    <?php if($product_attr['attr_value'] == 'other' || $product_attr['attr_value'] == 'Other'): ?>
									<td><?php echo $product_attr['attr_other_value'] ?></td>
							    <?php else: ?>
									<td><?php echo $product_attr['attr_value'] ?></td>
							    <?php  endif; ?>	
						<?php  endif; ?>
				    </tr>
				    <?php endforeach ?>
			</table>
                        </div>
                        <div class="right">
				    <b>Product Detail</b>
			                        <table>
				   
				    <tr>
					<th style="text-align:left;height:50px;">keyword</th>
				        <td><?php echo $product['keywords'] ?></td>
				    </tr>
				    <tr>
					<th style="text-align:left;height:50px;">short description</th>
				        <td><?php echo $product['short_description'] ?></td>
				    </tr>
				    <tr>
					<th style="text-align:left;height:50px;">long description</th>
				        <td><?php echo htmlspecialchars_decode($product['long_description']) ?></td>
				    </tr>

			</table>
                        </div>
			</div>
			<div class="products_images_page">
                    	<ul class="trade_list">
                            <?php echo img(base_url()."images/product_images/".$product_images['image_name'])?>
			</ul>
                    </div>
                        <div class="clear"></div>
            </div>
</div>
            <!-- End Product Tabs -->
            
<div class="preview_view_buttons"><?php echo anchor('product/preview_submit/'.$product_order['product_id'],'Submit'); ?></div>
<div id="edit_preview_id" class="preview_view_buttons">Edit</div>
