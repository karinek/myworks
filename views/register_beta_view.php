<script type="text/javascript" src="<?php echo base_url(); ?>js/ajaxupload.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/toggleformtext.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.qtip-1.0.0.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/register_view.js"></script>
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
    <div id="content">
		<?php if ($country_options): ?> 
			<?php echo form_open('register_beta/auth'); ?>
			<div class="registration_head">
				<div class="wrapper">
					<h1>Open a New Account     (Click <?php echo anchor('register_beta/forget','<font color="red">here</font>'); ?> if you forget password)</h1>
					
				</div>
			</div>
		<?php else: ?>
			<?php echo form_open('register_beta/forget_password'); ?>
			<div class="registration_head">
        	<div class="wrapper">
            	<h1>Get your password</h1>
            </div>
        </div>
		<?php endif ?>

        <div class="wrapper">
        	<div class="registration_page">
				<?php if ($country_options): ?>                
				<div class="reg_first_colomn">
                	<h2>Registration</h2>

					<p class="label"><label>Company Name *</label></p>
                    <p><input type="text" name="company" /></p>
                    <br /><br />
					<p class="label"><label>Country</label></p>
					<?php echo form_dropdown('location', $country_options);?> 
				</div>
				<?php endif ?>
                <div class="reg_second_colomn">
                    <h2>Enter Your Email and Password</h2>
                    <div><?php echo form_error('email'); ?></div>
                    <div style="color:red;"><?php echo (isset($error))?$error:''; ?></div>
					<p class="label"><label>Email Address *</label><?php echo form_error('email'); ?></p>
                    <p><input title="Email *" class="registration_input" type="text" id="email_id" name="email" value="<?php echo set_value('email'); ?>" /></p>
                    <p><input class="submit" type="submit" value="Next"/></p>
				</div>
			</div>
        </div>
        <?php echo form_close(); ?>

    </div>
    <!-- End Content -->
    
