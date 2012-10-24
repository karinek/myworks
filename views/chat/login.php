<style>
body{background-color:#ccc !important;}
</style>
<div id="tabCurrentMember">
	<div class="wrapper">
		<div class="registration_page">
			<?=form_open('login/auth','id="login-form"')?>
			<div class="reg_first_colomn" style="background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #AAAAAA;left: -175px;margin-left: 50%;margin-top: 50%;padding: 20px;position: absolute;top: -170px;">
					<h3 style="font-size:150%; font-weight:bold;margin-bottom:50px;">Please Login</h3>
					<p class="label"><label>Email or Member ID:</label><?php echo form_error('firstname'); ?></p>
					<p><input type="text" title="Login *" name="email" value="" class="registration_input"/></p>
					<p class="label"><label>Password:</label></p>
					<p><input type="password" title="Password *" name="password" value="" class="registration_input"/></p>
					<p><input class="submit" type="submit" value="LOGIN"/></p>
					<p style="font-weight:bold;text-align:right;">Not a Member Yet ? <?php echo anchor('register','Sign Up', 'class="green"'); ?></p>
                    <p style="font-weight:bold;text-align:right; font-size:80%;"><?php echo anchor('login/forget_password','Forget Your Password ?','class="forgot"') ?></p>
				</div>
			<?=form_close()?>
			<div class="clear"></div>
		</div>
		<div id='login-proccess' style="display:none;width:350px" align="center"><img src='<?php echo base_url(); ?>images/ajax-loading.gif'/></div>
		<div id='login-error' style="display:none;color:red">&nbsp;</div>
	</div>
</div>
