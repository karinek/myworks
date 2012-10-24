<?php if($already_exists): ?>
    <h3>This Company has been added as network before!</h3>
    <input type="button" value="Ok" id="btnAlreadyAdded" class="splash_login_submit" />
    <a href="<?php echo base_url(); ?>company/networks" class="splash_login_submit" style="display: block; text-align: center;">Go to My Networks</a>
<?php else:?>
    <h3>This Company has been added as network successfully</h3>
    <input type="button" value="Ok" id="btnAlreadyAdded" class="splash_login_submit" />
    <a href="<?php echo base_url(); ?>company/networks" class="splash_login_submit" style="display: block; text-align: center;">Go to My Networks</a>
<?php endif; ?>