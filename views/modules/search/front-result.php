<div class="contentBox clearfix">
	<h1>
	<?php
		switch($search_type){
			case 'buyer': echo 'Result of Buyer Search'; break;
			case 'seller': echo 'Result of Supplier Search'; break;
			case 'product': echo 'Result of Product Search'; break;
		}
	?>
	</h1>
	<?php if(count($result) && is_array($result)): ?>
		<?php foreach($result as $item): ?>
	<div class="productBox contentBox clearfix">
			<?php if($search_type == 'product'): ?>
		<div class="productImgBox sliderItem">
			<div class="itemImage"> <img src="images/chlorine.jpg" alt="chlorine"> <a href="#" class="zoomImage"></a> </div>
		</div>
			<?php endif; ?>
		<div class="productTextBox">
			<p class="onlineNow">'Online Now'</p>
			<div class="clearfix">
				<h2><?=$item->firstname?></h2>
				<a href="#" class="likes"></a> <span class="numOfLikes">692</span>
			</div>
			<p class="assessedSupplierPara"> <img src="images/assSupp.png" alt=""> <?php echo $item->role == 'seller' ? 'Assessed Supplier' : 'Assessed Buyer' ?>   -    <?=$item->name?>. </p>
			<br>
			<p> <span>Country:</span> <?=$this->m_misc->country($item->country)?> <span>Business Type:</span> ??? <span>No of Employees:</span> ??? <br>
				<span>Management Certification:</span> ?? </p>
			<p> <span>Information:</span><br><?=$item->info?></p>
			<br>
			<p class="productTextLinks"> <a href="#" class="addToFav">Add to Favorites</a> <a href="#" class="contactComp">Contact Company</a> <a href="#" class="addToWish">Add to Watchlist</a> </p>
		</div>
	</div>
		<?php endforeach; ?>
	<?php else: ?>
	<div class="productBox contentBox clearfix">
		<div>No Result</div>
	</div>	
	<?php endif; ?>
</div>
