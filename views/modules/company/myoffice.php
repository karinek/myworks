<div id="office_tabs_block">
	<?php $this->load->view('modules/company/tabs_nav',array('selectedPage'=>'My Office')); ?>
	<div id="office_tabs_content">
		<div class="my_office_page">
			<div class="right">
				<p><b>Company Logo:</b></p>
				<img class="company_logo" src="<?=base_url('images/'.(isset($my_company->file) && !empty($my_company->file)? 'company_images/'.$my_company->file : 'company.png'))?>" style="width:260px;height:100px;" alt="">
				<p><b>Company License:</b></p>
				<?php
				if(count($my_company->company_license) && is_array($my_company->company_license)):
					foreach($my_company->company_license as $license):
				?>
				<div class="certif_imageblock"><img class="company_licence" src="<?= is_object($license)? base_url('images/certs/'.$license->image):''?>" style="max-width:49;max-height:58;" alt="<?=is_object($license)?$license->image:$license?>"></div>
				<?php
					endforeach;
				else:
					echo '-';
				endif;
				?>
				<div class="clear"></div>
				<p class="company_network"><b>Company Network:</b></p>
				<?php
				if(count($my_netwroks) && is_array($my_netwroks)):
					foreach($my_netwroks as $network):
						$network = (object)$network;
				?>
				<img class="company_logo" src="<?=base_url('images/'.(isset($network->file) && !empty($network->file)? 'company_images/'.$network->file : 'company_logo.jpg'))?>" style="max-width:50px;max-height:50px;" alt="<?=$network->name?>">
				<?php
					endforeach;
				endif;
				?>
			</div>
			<div class="left">
				<p><b>Profile Image:</b></p>
				<img src="<?=base_url('images/'.(isset($my_contact->image) && !empty($my_contact->image)? 'user_images/'.$my_contact->image : 'no-photo.jpg'))?>"" width="130" height="130" alt="" class="user_img">
				<p><b>Name:</b> <?=$my_contact->firstname?> <?=$my_contact->lastname?><br>
					<b>Display Name:</b> <?=$my_contact->firstname?></p>
				<p><b>Company:</b> <span class="green"><?=$my_company->name?></span><br>
					<b>Industry:</b>
				<?php
				if(count($my_company->industry) && is_array($my_company->industry)):
					$i=0;
					foreach($my_company->industry as $industry):
				?><?=$i>0?', ':''?>
				<span><?=$industry?></span>
				<?php
						$i++;
					endforeach;
				else:
					echo '-';
				endif;
				?><br />
					<b>Status:</b> <?=M_misc::displayValue($my_company->status)?></p>
				<p><b>Company Size:</b> <?=M_misc::displayValue($my_company->company_size)?><br>
					<b>ACN No:</b> <?=M_misc::displayValue($my_company->acn_no)?></p>
				<p class="edit"><a href="<?=base_url('company')?>">Edit Company Details</a></p>
			</div>
			<div class="middle">
				<?php if($my_company->membership == 'Platinum'): ?>
					<p><img src="<?php echo base_url(); ?>images/platinum_ico.png" /> Platinum Member</li></p>
				<?php elseif($my_company->membership == 'Gold'): ?>
					<p><img src="<?php echo base_url(); ?>images/gold_ico.png" />Gold Member</li></p>
				<?php endif ?>
				<p><b>Website:</b>  <?=M_misc::displayValue($my_company->website)?><br>
					<b>Email:</b>  <?=M_misc::displayValue($my_company->email)?><br>
					<b>Ph:</b> <?=$my_company->phone_country?> <?=$my_company->phone_area?> <?=$my_company->phone_number?></p>
				<p><b>Industry we are in:</b> <?=M_misc::displayValue($my_company->business_type)?><br>
					<b>Product we sell:</b> <?=M_misc::displayValue($my_company->sell_product)?><br>
					<b>Annual Purchase Volume:</b> <?=M_misc::displayValue($my_company->purchase_volume)?></p>
				<p><b>Preferred Supplier Location:</b> 
				<?php
				if(count($my_company->region) && is_array($my_company->region)):
					$i = 0;
					foreach($my_company->region as $region):
				?><?=$i>0?', ':''?>
				<span><?=$region?></span>
				<?php
						$i++;
					endforeach;
				else:
					echo '-';
				endif;
				?>
				<br>
					<b>Company Address:</b> <?=M_misc::displayValue($my_company->address)?></p>
				<p><b>Company Introduction:</b> <?=M_misc::displayValue($my_company->product_keyword)?></p>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
