<?php if($already_exists): ?>
    <h3>This Product has been added to your watchlist before!</h3>
    <input type="button" value="Ok" id="btnAlreadyAdded" class="splash_login_submit" />
    <a href="<?php echo base_url(); ?>user/watchlist" class="splash_login_submit" style="display: block; text-align: center;">Go to My Watchlist</a>
<?php else:?>
    <h3>This Product has been added to your watchlist successfully</h3>
    <input type="button" value="Ok" id="btnAlreadyAdded" class="splash_login_submit" />
    <a href="<?php echo base_url(); ?>user/watchlist" class="splash_login_submit" style="display: block; text-align: center;">Go to My Watchlist</a>
<?php endif; ?>