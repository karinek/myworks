<script type="text/javascript" src="<?php echo base_url(); ?>js/toggleformtext.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.qtip-1.0.0.min.js"></script>  
<script type="text/javascript" src="<?php echo base_url(); ?>js/login_forget.js"></script>    
<div class="splash_login_text">
            	<p>International B2B Portal.</p>
                <ul>
                	<li>Unlimited Access</li>
                    <li>Priority Listing</li>
                    <li>Extended Searches</li>
                    <li>Advertising Benefits</li>
                    <li>Buying Tools</li>
                    <li>B2B Network</li>
                    <li>24Hr Support</li>
                </ul>
            </div>
     <div id="splash_login_block" class="forget_pass_1">
            	<h3>Forget Your Password?</h3>
		
		
		<?php echo form_open('login/reset_password','id="login-forget"'); ?>
                <div style="color:red;padding-bottom: 10px;"><?php echo $error;?></div>
                <small>To reset your password please enter your most current registered email address:</small>
		<input type="text" id="email" title="Email Address" class="inputbox" name="email"/><br />
                <input type="submit" value="submit" id="login-submit" class="splash_login_submit"/>
		<?php echo form_close() ?>
	</div>
