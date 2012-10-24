<div class="member_profile_left">
	<h3>Member Profile</h3>
<?php
	$avatar = 'images/user_images/';
	$avatar .= (!empty($user->image)) ? $user->image : 'no_photo.jpg';
?>
	<?php echo anchor('forum/profile/'.$user->username,'<img alt="'.$user->username.'" src="'.base_url($avatar).'" border="0" width="100" height="100" class="circle_image">')?>

	<p class="orange"><?=$user->username?></p>
	<p><b>Overall Ranking:</b> <?=$this->m_misc->formatNumber($user->rank)?><br/>
		<b>MVP:</b> <?=$this->m_misc->formatNumber($user->point)?><br/>
		<b>Name:</b> <?=$user->firstname?> <?=$user->lastname?><br/>
		<b>Member Since:</b> <?=$this->m_misc->formatDate('m Y',$user->create_date)?><br/>
		<b>Gender:</b> <?=$this->m_misc->gender($user->gender)?><br/>
		<b>Country/Region:</b> <?=$this->m_misc->country($user->location)?><br/>
		<b>Member Type:</b> <?=$user->membership?> Member</p>
</div>
<div class="member_profile_right">
<?php if(isset($company)): ?>
	<h3>Company Profile</h3>
	<img class="company_logo" src="<?=base_url('images/'.(isset($company->file) && !empty($company->file)? 'company_images/'.$company->file : 'company.png'))?>" style="width:260px;height:100px;" alt="<?=$company->name?>">
	<p>
		<b>Company:</b> <?php echo anchor('compdetail/'.M_encrypt::encode($company->id),M_misc::displayValue($company->name),'class="green"')?><br/>
		<b>Website:</b> <a class="green" href="<?=$company->website?>"><?=M_misc::displayValue($company->website)?></a><br/>
		<b>Email:</b> <?=M_misc::displayValue($company->email)?><br/>
		<b>Ph:</b> <?=$company->phone_country?> <?=$company->phone_area?> <?=$company->phone_number?></p>
	<p><b>Industry we are in:</b> <?=M_misc::displayValue($company->business_type)?><br/>
		<b>Product we sell:</b> <?=M_misc::displayValue($company->sell_product)?><br/>
		<b>Purchasing Frequency:</b> Weekly<br/>
		<b>Annual Purchase Volume:</b> 6000 Metric Tons</p>
	<p><b>Company Introduction:</b> <?=M_misc::displayValue($company->product_keyword)?> <?php echo anchor('compdetail/'.M_encrypt::encode($company->id),'View Profile...','class="green"')?></p>
<?php else: ?>
	<h4>No Company Name</h4>
	<p>-</p>
	Website: -
<?php endif; ?>
</div>
