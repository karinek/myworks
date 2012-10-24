
<div class="chat_left">
	<div class="chat_dialogue_block">
		<div class="chat_dialogue_block_scroll" style="overflow-y:scroll;max-height:373px;min-height:373px" id="log">
			<?=$msg?>
		</div>
	</div>
	<div class="chat_reply_block_wrapper">
		<div class="chat_reply_block">
			<textarea name="message" id="message"></textarea>
		</div>
	<input type="submit" class="submit_chat" onClick="Chat.send();return false" value="Send" />
	</div>
</div>
<div class="chat_right">
	<?php if(false): ?>
	<?php if($company['file']): ?>
	<a href="<?=base_url()?>images/company_images/<?=$company['file']?>" rel="lightbox" title=""><img src="<?=base_url()?>images/company_images/<?=$company['file']?>" width="157" height="228" alt=""/></a> <a href="<?=base_url()?>images/company_images/<?=$company['file']?>" rel="lightbox" title=""><img src="<?=base_url()?>images/lup.png" width="13" height="13" alt="" class="zoom"/></a>
	<?php else: ?>
	<a href="<?=base_url()?>images/product_images/NA_image.jpg" rel="lightbox" title=""><img src="<?=base_url()?>/images/product_thumbs/NA_image.jpg" width="157" height="228" alt=""/></a> <a href="<?=base_url()?>images/product_images/NA_image.jpg" rel="lightbox" title=""><img src="<?=base_url()?>/images/lup.png" width="13" height="13" alt="" class="zoom"/></a>
	<?php endif ?>
	<?php endif ?>
	<div class="chat_right_description">
		<?php if(isset($userto)): ?>
		<?php
			if(isset($userto['image'])){
				$userfileexists=is_file(FCPATH."images//user_images//".$userto['image']);
			}else{
				$userfileexists=false;
			}
			$username=(isset($userto['firstname'])?$userto['firstname']:'').' '.(isset($userto['lastname'])?$userto['lastname']:'');
			if($userfileexists){
				 $userimage=base_url()."images/user_images/".$userto['image'];
				 if(isset($userto['membership'])&&$userto['membership']!='Free'){
					 $membership=base_url()."images/membership_".strtolower($userto['membership'])."_big_logo.png";
				 }
			}else{
				 $userimage=base_url()."images/avatars/no_avatar.jpg";
				 $membership=null;
			}
		?>
		<?php else: ?>
		<?php
			$userimage=base_url()."images/avatars/no_avatar.jpg";
			$membership=null;
			$username='N/A';
		?>
		<?php endif; ?>
		<img src="<?=$userimage?>" width="70" height="70" alt="" class="circle_image"/>
		<?php if(isset($membership)): ?>
		<img src="<?=$membership?>" width="" height="70" alt=""/>
		<?php endif; ?>
		<p class="orange">You are speaking with:</p>
		<p class="green" id="chatPerson">
			<?=$username?>
		</p>
		<?php if(isset($company)): ?>
		<p><a href="<?=base_url();?>compdetail/<?=M_encrypt::encode($company['id']); ?>"><b>
			<?=$company['name']?>
			</b></a><br/>
		</p>
		<p>
			<?=$company['address']?>
		</p>
		<?php endif; ?>
	</div>
	<?php if(isset($product)): ?>
	<div class="chat_right_product">
		<?php
			$imgxists=false;
			$detailLink = '#';
			$imgpath = 'images/product_images/NA_image.jpg';
			$imgthumbspath = 'images/product_images/NA_image.jpg';
			if($product_type=='request'){
				if(isset($product['image'])){
					$imgxists=is_file(FCPATH."//files//request//images//".$product['image']);
					$imgpath = $imgxists ? 'files/request/images/'.$product['image'] : $imgpath;
					$imgthumbspath = $imgxists ? 'files/request/thumbs/'.$product['image'] : '';
				}
				$product['name'] = $product['product_name'];
				$product['product_id'] = $product['id'];
				$product['short_description'] = $product['product_specification'];

				$product['qty'] = $product['order_quantity'];
				$product['qty_unit'] = $product['order_quantity_unit'];
				$detailLink = 'buydetail/'.M_encrypt::encode($product['product_id']);
			}else{
				if(isset($product['image_name'])){
					$imgxists=is_file(FCPATH."images//product_images//".$product['image_name']);
					$imgpath = $imgxists ? 'images/product_images/'.$product['image_name'] : $imgpath;
					$imgthumbspath = $imgxists ? 'images/product_thumbs/'.$product['image_name'] : $imgthumbspath;
				}
				$detailLink = 'prodetail/'.M_encrypt::encode($product['product_id']);
			}
		?>
		<a href="<?=base_url($imgpath)?>" rel="lightbox" title=""><img src="<?=base_url($imgthumbspath)?>" width="157" height="228" alt=""/></a> <a href="<?=base_url($imgpath)?>" rel="lightbox" title=""><img src="<?=base_url()?>images/lup.png" width="13" height="13" alt="" class="zoom"/></a>

		<h3><a href="<?=base_url($detailLink);?>">
			<?=$product['name']?>
			</a></h3>
		<p>
			<b>Min. Order:</b> <?php echo $product['qty']." ".$product['qty_unit'] ?> 
			<?php if($product_type!='request'): ?>
			<b>Price:</b> <?php echo $product['price_cur']." ".$product['price_1']. " to ".$product['price_2']." PER ".$product['price_unit']  ?><br/>
			<b>Payment Terms:</b> <?php echo $product['pay_terms']; ?> 
			<b>Supply Ability:</b> <?php echo $product['prod_capacity']." ".$product['prod_capacity_unit']." per ".$product['prod_capacity_per'] ?><br />
			<?php endif; ?>
		</p>
		<p><b>Additional Information:</b><br/>
			<?=$product['short_description']?>
		</p>
	</div>
	<?php endif; ?>
</div>
