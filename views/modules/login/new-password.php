   <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.qtip-1.0.0.min.js"></script>  
<script type="text/javascript" src="<?php echo base_url(); ?>js/new_password.js"></script>  
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
  <div id="splash_login_block" class="reset_pass">
            	<h3>Please Update Your Password?</h3>
		
		<?php echo form_open('login/update_password','id="new_password"',$hidden); ?>
		<input type="password" id="password" name="password" class="inputbox"/><br />
                <input type="submit" class="splash_login_submit" id="new_password_send" value="Submit"/>
		<?php echo form_close() ?>
	</div>
</div>