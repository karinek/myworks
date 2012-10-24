<script type="text/javascript" src="<?php echo base_url(); ?>js/ajaxupload.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/toggleformtext.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.qtip-1.0.0.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/chat/signup.js"></script>
<!--<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/register_view.css" />
-->

<!-- CONTENT -->

<style>
    input.error1,
    textarea.error1,
    select.error1,
    div.error1
    {
        border:1px solid red !important;
    }

    input[type='text'].error1 {border:1px solid #e1e1e1;  }
</style>
    <div id="tabNewUser">
    <?php if(isset($varifymsg)): ?>
        <div class="registration_head" style="height:133px;">
        	<div class="wrapper">
            	<h1>Welcome to <?php echo $firstname; ?>'s Page. <?php echo $varifymsg ?></h1>
            </div>
        </div>
    <?php else: ?>
        <?php echo form_open_multipart('chat/auth',array('id'=>'form_id')); ?>

        <div class="wrapper">
        	<div class="registration_page">
            	<div class="registration_popup" style="display:none;">
                	Your name is how your friends, co-workers, family, and others can identify you throughout Windows Live.
                </div>
                <div class="reg_first_colomn">
                	
					<p class="label"><label>Country</label><?php echo form_error('location'); ?></p>
                    <div class="select">
						<select name="location" class="inputbox" style="width:281px;" id="location_id">
							<option value="0">--select country--</option>
							<?php foreach($country_options as $country_option): ?>
							<option value="<?=$country_option['code']?>" label="<?=$country_option['dialing_code']?>" <?=set_value('location')==$country_option['code']?" selected=\"selected\"":""?>><?=$country_option['name']?></option>
							<?php endforeach; ?>
						</select>
                            <?php //echo form_dropdown('location', $country_options, set_value('location'),'class="inputbox" style="width:281px;"');?>
                    </div>
<!--                    <p><input type="text" value="Memeber ID *" class="registration_input" onfocus="if(this.value=='Memeber ID *') this.value='';" onblur="if(!this.value) this.value='Memeber ID *';"/></p>-->
                    
                    <p class="label"><label>I am a:</label><?php echo form_error('role'); ?></p>
                    <ul class="registration_checkbox_list">
                        <li><input type="radio" name="role" value="buyer" class="checkbox"  <?php echo (isset($_POST['role']) && $_POST['role'] == 'buyer')?'checked="checked"':''; ?> /><label>Buyer</label></li>
                        <li><input type="radio" name="role" value="seller" class="checkbox" <?php echo (isset($_POST['role']) && $_POST['role'] == 'seller')?'checked="checked"':''; ?> /><label>Supplier </label></li>
                        <li><input type="radio" name="role" value="both" checked="checkrd" class="checkbox" <?php echo (isset($_POST['role']) && $_POST['role'] == 'both')?'checked="checked"':''; ?> /><label>Both</label></li>
                    </ul>
                    
                    
                    <div class="split_inputs">
						<p class="label"><label>First name</label><?php echo form_error('firstname'); ?></p>
                    	<p> <input type="text" title="First Name *" name="firstname" id="firstname_id" value="<?php echo set_value('firstname'); ?>" class="registration_input"/></p>
						<p class="label"><label>Last name</label><?php echo form_error('lastname'); ?></p>
                        <p><input type="text" title="Last Name *" name="lastname" id="lastname_id" value="<?php echo set_value('lastname'); ?>" class="registration_input"/></p>
                       
                    </div>
					<p class="label"><label>Gender</label><?php echo form_error('gender'); ?></p>
                    <div class="select small">
						<?php echo form_dropdown('gender', array(
							'0' => '--select--',
							'M' => 'Male',
							'F' => 'Female'
						), set_value('gender'),' class="inputbox" id="gender" style="width:281px;"');?>
                    </div>
                   
					<p class="label"><label>Date Of Birth</label><?php echo form_error('birthday'); ?></p>
                    <div class="input_line">
                    	<div class="select smallest">
                            <?php echo form_dropdown('birth_day', $day_options, set_value('birth_day'), 'class="birth_option inputbox birth-date" style="width:67px;"');?>
                        </div>
                        <div class="select smallest">
                            <?php echo form_dropdown('birth_month', $month_options, set_value('birth_month'), 'class="birth_option inputbox birth-month" style="width:67px;"');?>
                        </div>
                        <div class="select smallest" style="margin-right:0;">
                            <?php echo form_dropdown('birth_year', $year_options, set_value('birth_year'), 'class="birth_option inputbox birth-year" style="width:67px;');?>
                        </div>
                    </div>
                    <div><?php echo form_error('company'); ?></div>
					<p class="label"><label>Company Name *</label><?php echo form_error('company'); ?></p>
                    <p><input title="Company Name *" class="registration_input" type="text" id="company_id" name="company" value="<?php echo set_value('company'); ?>" /></p>
                    
					<p class="label"><label>Phone Number *</label><?php echo form_error('phone_country'); ?></p>
                    <div class="input_line">
                        <p><input title="Tel" class="registration_input" type="text" id="phone_country_id" value="<?php echo set_value('phone_country'); ?>" style="width:40px;" disabled="disabled" /><input name="phone_country" id="phone_country_id_hidden" type="hidden" value="<?php echo set_value('phone_country'); ?>" /></p>
                        <p><input title="Area" class="registration_input" type="text" id="phone_area_id" name="phone_area" value="<?php echo set_value('phone_area'); ?>" /></p>
                        <p style="margin-right:0;"><input title="Number" class="registration_input" type="text" id="phone_number_id" name="phone_number" value="<?php echo set_value('phone_number'); ?>" /></p>
                    </div>                 
                    

                    

               
                    
                    <div><?php echo form_error('email'); ?></div>
                    <div style="color:red;"><?php echo (isset($error))?$error:''; ?></div>
					<p class="label"><label>Email Address *</label><?php echo form_error('email'); ?></p>
                    <p><input title="Email *" class="registration_input" type="text" id="email_id" name="email" value="<?php echo set_value('email'); ?>" /></p>
                    
                    <div style="color:red; display:none;" id="validate_pass_length">Password length must be at least 6 characters.</div>
                   	<p class="label"><label>Create Password *</label><?php echo form_error('password'); ?></p>
                    <input  class="registration_input"  type="password" id="password_id" name="password" value="<?php echo set_value('password'); ?>" />
                   	<p class="label"><label>Re-Enter Password *</label><?php echo form_error('repassword'); ?></p>
                    <input  class="registration_input"   type="password" id="repassword_id" name="repassword" value="<?php echo set_value('repassword'); ?>" />
                    
                    <div class="img_code"><img src="<?php echo site_url('imgcaptcha') ?>" id="captcha_id" action="<?php echo site_url('imgcaptcha') ?>"/><br/></div>
		    <p class="label"><a href="javascript:void(0)" onclick="change_captcha()" id="captcha_id">Not readable? Change text.</a></p>
                    <div><?php echo form_error('captcha'); ?></div>
                    <p><input title="Enter Security Code *" class="registration_input small" id="capcha_id" name="captcha" /></p>
<!--                    
                    <h2>In Case You Forget Your Password</h2>
                    <div class="select">
                        <?php echo form_dropdown('question', $question_options, set_value('question'), 'id="question_id" class="inputbox" style="width:281px;"');?>
                    </div>
                    <p><input title="Answer" class="registration_input" id="answer_id" name="answer" /></p>
-->
                    <p><input class="submit" id="submit_id" type="button" value="CREATE MY ACCOUNT"/></p>
                    <p><?php echo form_checkbox('agreement', 'agree', set_value('agreement'),'class="checkbox"'); ?>
                        <label style=" float: left; width: 290px; margin-bottom: 20px; color:#878d95;">
                            Upon creating my account i agree to receive emails relating to membership and services from #######
                        </label>
                    <div><?php echo form_error('agreement'); ?></div>
                    </p>
                </div>

                <div class="clear"></div>
            </div>
            
        </div>
        <?php echo form_close(); ?>
    <?php endif; ?>    
    </div>
    <!-- End Content -->
    
