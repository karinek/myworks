<?php if($already_exists): ?>
    <h3>This Company has been added as contact before!</h3>
    <input type="button" value="Ok" id="btnAlreadyAdded" class="splash_login_submit" />
    <a href="<?php echo base_url(); ?>company/contacts" class="splash_login_submit" style="display: block; text-align: center;">Go to My Contacts</a>
<?php else:?>
    <h3>This Company has been added as contact successfully</h3>
    <input type="button" value="Ok" id="btnAlreadyAdded" class="splash_login_submit" />
    <a href="<?php echo base_url(); ?>company/contacts" class="splash_login_submit" style="display: block; text-align: center;">Go to My Contacts</a>
<?php endif; ?>