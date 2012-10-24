<script type="text/javascript" src="<?php echo base_url(); ?>js/toggleformtext.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.qtip-1.0.0.min.js"></script>  
<script type="text/javascript" src="<?php echo base_url(); ?>js/login.js"></script>  
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
           <div id="splash_login_block" class="sign_in">
            	<h3>Please Sign In.</h3>
<?php echo form_open('login/auth','id="login-form"'); ?>
	User Name
                <input type="text"  name="email"   class="splash_login_input" />
                   
                    Password
                    <div style="color: red;"><?php echo $error; ?></div>
                    <input type="password"  name="password" class="splash_login_input" />
                    
                    <input type="submit" value="Login" id="submit_id" class="splash_login_submit" />
                   <p>
                Not a Member Yet ? <?php echo anchor('register','Sign Up', 'class="green"'); ?>
	</p>
             
                    <p class="small"><?php echo anchor('login/forget_password','Forget Your Password ?','class="forgot"') ?></p>
  
<?php echo form_close(); ?>
	</div>


	
