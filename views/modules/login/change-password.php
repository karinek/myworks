       <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.qtip-1.0.0.min.js"></script>  
<script type="text/javascript" src="<?php echo base_url(); ?>js/change_password.js"></script>  

<div id="content" class="splash_content">
    	<div class="wrapper splash_wrapper">
        	
            <div class="splash_login_text">
            	<p class="big_text">Under Construction. We’re building our faboulous site and we’ll be online soon. So take the opportunity and inquire today.</p>
            </div>
            
            <div id="splash_login_block" class="change_pass">
            	<h3>Change Your Password?</h3>
                <small>To change your password please enter the following details below:</small>
                <?php echo form_open('login/update_change_password','id="change_password"'); ?>
                Old Password
                    <input type="password" name="password"  class="splash_login_input" />
                    New Password
                    <input type="password" name="newpassword" id="newpassword" class="splash_login_input" />
                   Confirm New Password
                   <input type="password" name="confnewpassword" id="confnewpassword" class="splash_login_input" />
                    <input type="submit" value="CHANGE PASSWORD" id="change_password_submit" class="splash_login_submit" />
                    <?php echo form_close() ?>
               
            </div>
        
        </div>
    </div>
