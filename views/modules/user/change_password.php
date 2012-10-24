<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.qtip-1.0.0.min.js"></script>  
<script type="text/javascript" src="<?php echo base_url(); ?>js/change_password.js"></script>  
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
    <?php echo form_open('user/update_change_password','id="change_password"'); ?>
    <div id="office_tabs_content">
            <div class="my_office_buyer_page">
            <div class="left">
                    <h2>My Profile</h2>
                <ul>
                    <li><a href="<?php echo base_url(); ?>user/editprofile/">Edit Profile Details</a></li>
                    <li class="active"><a href="<?php echo base_url(); ?>user/change_password/">Password</a></li>
                </ul>
                <div class="support">
                    <p class="head_text">Support</p>
                    <p>Jaqueline is <span>Online</span></p>
                </div>
            </div>
            <div class="middle">
                <div class="my_profile_left">
                    <h2>Change Your Password?</h2>
                    <small>To change your password please enter the following details below:</small>
                    <?php if(isset($error)): ?>
                        <p style="padding-top:10px; color:red;"><?php echo $error; ?></p>
                    <?php endif; ?>
                    
                    <div class="split_inputs" style="padding-top:15px;">
                         <div class="split_inputs">
                            <p class="label"><label>Old Password</label></p>
                            <p><input type="password" name="password" class="my_office_buyer_input" /></p>
                            <p class="label clear"><label>New Password</label></p>
                            <p><input type="password" name="newpassword" id="newpassword" class="my_office_buyer_input" /></p>
                            <p class="label"><label>Confirm New Password</label></p>
                            <p><input type="password" name="confnewpassword" id="confnewpassword" class="my_office_buyer_input" /></p>
                            
                            <div class="submit_block"><input type="button" value="CHANGE PASSWORD" id="change_password_submit" class="submit" style="width:312px;" /></div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="clear"></div>
        </div>
    </div>
     <?php echo form_close(); ?>
</div>
<!-- End Product Tabs -->

