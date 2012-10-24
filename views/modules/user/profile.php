<script type="text/javascript" src="<?php echo base_url(); ?>js/ajaxupload.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/toggleformtext.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.qtip-1.0.0.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/profile_view.js"></script>
<!--<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/register_view.css" />
-->
<!-- CONTENT -->
<style type="text/css">
    input.error1,
    textarea.error1,
    select.error1,
    div.error1
    {
        border:1px solid red !important;
    }

    input[type='text'].error1 {border:1px solid #e1e1e1;  }
</style>
<!-- PRODUCT TABS -->
            <div id="office_tabs_block">
			<?php $this->load->view('modules/company/tabs_nav',array('selectedPage'=>'My Proflie')); ?>
                <?php echo form_open_multipart('user/do_editprofile',array('id'=>'profile_form')); ?>
                <div id="office_tabs_content">
                	<div class="my_office_buyer_page">
                    	<div class="left">
                        	<h2>My Profile</h2>
                            <ul>
                            	<li class="active"><a href="<?php echo base_url(); ?>user/editprofile/">Edit Profile Details</a></li>
                                <li><a href="<?php echo base_url(); ?>user/change_password/">Password</a></li>
                            </ul>
                            <div class="support" style="display:none;">
                            	<p class="head_text">Support</p>
                                <p>Jaqueline is <span>Online</span></p>
                            </div>
                        </div>
                        <div class="middle" style="overflow:visible;">
                            <div class="my_profile_left">
                            <h2>Edit Profile Details:</h2>
                            
                            	<p class="label">Business Location *</p>
                                <p class="label"><?php echo form_error('location'); ?></p>
                                <div class="select">
                                    <select name="location" class="inputbox" style="width:281px;" id="location_id">
                                            <option value="0">--select country--</option>
                                            <?php foreach($country_options as $country_option): ?>

                                            <option value="<?=$country_option['code']?>" label="<?=$country_option['dialing_code']?>" <?=$user['location']==$country_option['code']?" selected=\"selected\"":""?>><?=$country_option['name']?></option>
                                            <?php endforeach; ?>
                                    </select>
                                </div>    
                                <p class="label"><?php echo form_error('role'); ?></p>
                                <ul class="checkboxes_list small">
                                    <li class="black">I am a:</li>
                                    <ul class="registration_checkbox_list">
                                        <li><input type="radio" name="role" value="buyer" <?php echo ($user['role'] == 'buyer')?'checked="checked"':''; ?> /><label>Buyer</label></li>
                                        <li><input type="radio" name="role" value="seller" <?php echo ($user['role'] == 'seller')?'checked="checked"':''; ?> /><label>Supplier </label></li>
                                        <li><input type="radio" name="role" value="both" <?php echo ($user['role'] == 'both')?'checked="checked"':''; ?> /><label>Both</label></li>
                                    </ul>
                                </ul>
                                
                                <h2>Personal Details</h2>
                                <div class="split_inputs">
                                     <div class="split_inputs">
                                        <p class="label"><label>First name</label><?php echo form_error('firstname'); ?></p>
                                        <p> <input type="text" title="First Name *" name="firstname" id="firstname_id" value="<?php echo $user['firstname']; ?>" class="my_office_buyer_input"/></p>
                                        <p class="label clear"><label>Last name</label><?php echo form_error('lastname'); ?></p>
                                        <p><input type="text" title="Last Name *" name="lastname" id="lastname_id" value="<?php echo $user['lastname']; ?>" class="my_office_buyer_input"/></p>

                                    </div>
                                </div>
                                
                                <p class="label"><label>Gender</label><?php echo form_error('gender'); ?></p>
                                <div class="select small">
                                    <?php echo form_dropdown('gender', array(
                                            '0' => '--select--',
                                            'M' => 'Male',
                                            'F' => 'Female'
                                    ), $user['gender'],' class="inputbox" id="gender" style="width:281px;"');?>
                                </div>
                                
                                <h2>Date Of Birth &amp; Contact</h2>
                                <p class="label"><?php echo form_error('birthday'); ?></p>
                                <div class="input_line">
                                    <div class="select smallest">
                                        <?php echo form_dropdown('birth_day', $day_options, $user['birth_day'], 'class="birth_option inputbox birth-date" style="width:67px;"');?>
                                    </div>
                                    <div class="select smallest">
                                        <?php echo form_dropdown('birth_month', $month_options, $user['birth_month'], 'class="birth_option inputbox birth-month" style="width:67px;"');?>
                                    </div>
                                    <div class="select smallest" style="margin-right:0;">
                                        <?php echo form_dropdown('birth_year', $year_options, $user['birth_year'], 'class="birth_option inputbox birth-year" style="width:67px;');?>
                                    </div>
                                </div>
                                
                                <p class="label clear"><label>Phone Number *</label><?php echo form_error('phone_country'); ?></p>
                                <div class="input_line">
                                    <p><input title="Tel" class="registration_input" type="text" id="phone_country_id" value="<?php echo $user['phone_country']; ?>" style="width:40px;" disabled="disabled" /><input name="phone_country" id="phone_country_id_hidden" type="hidden" value="<?php echo $user['phone_country']; ?>" /></p>
                                    <p><input title="Area" class="registration_input" type="text" id="phone_area_id" name="phone_area" value="<?php echo $user['phone_area']; ?>" /></p>
                                    <p style="margin-right:0;"><input title="Number" class="registration_input" type="text" id="phone_number_id" name="phone_number" value="<?php echo $user['phone_number']; ?>" /></p>
                                </div>
                                <small> * Indicates Manditory Fields</small>
                            </div>
                            
                            <div class="my_profile_right">
                            	<h2>Edit Company Profile</h2>
                    
                                <div style="overflow:hidden;"> 
                                    <div id="file_input_img" class="preview" style="margin-top: 10px;cursor: pointer">
										<a href="<?=base_url().'upload?module=user&module_id=?'?>" rel="shadowbox;height=550;width=715;">
                                        <?php if(isset($user['image'])): ?>
                                                <img src="<?php echo base_url(); ?>images/user_images/<?php echo $user['image']; ?>?r=<?=rand(1,10000); ?>" id="thumb" width="150" height="150" />* Maximum 2MB
                                        <?php else: ?>
                                                <img src="" id="thumb"/>* Maximum 2MB
                                        <?php endif; ?>
										</a>
                                    </div>
                                    <div id="mask1" action="<?php echo site_url('register/img_preview'); ?>" style="width: 140px;cursor: pointer; display:none;" >
                                            <div class="mask_button1" style="width: 138px;cursor: pointer">Upload Image</div>
                                            <input name="userfile" type="file"  style="width: 140px;cursor: pointer" id="fileInput1" />
                                            <input id="upload_image" name="image_name" type="hidden"/>
                                            <input id="upload_image_folder" type="hidden" value="<?php echo site_url('images/user_images/temp/'); ?>"/>
                                    </div>
                                </div>
                                
                                <h2>Position Information</h2>
                                <p class="label">Position Title</p>
                                <p><input type="text" name="position" class="my_office_buyer_input" value="<?php echo $user['position']; ?>" /></p>
                                
                                <p class="label">Introduction</p>
                                <p><textarea cols="" rows="" name="introduction" style="height:200px; width: 300px; color: #44463A;"><?php echo $user['introduction']; ?></textarea></p>
                                
                                <div class="submit_block">
                                    <input type="button" value="SAVE" id="submit_id" class="submit" style="width:312px;" />
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                 <?php echo form_close(); ?>
            </div>
            <!-- End Product Tabs -->
