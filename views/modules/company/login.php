<h3>Please Sign In.</h3>
<?php echo form_open('login/auth','id="login-form"'); ?>
        <small style="margin-bottom:11px;">Email</small>
        <input type="text"  name="email"   class="splash_login_input" />
        <small style="margin-bottom:11px;">Password</small>
        <input type="password"  name="password" class="splash_login_input" />
        <input type="submit" value="Login" id="submit_id" class="splash_login_submit" />
<?php echo form_close(); ?>

