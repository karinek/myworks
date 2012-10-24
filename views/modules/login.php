<?=chattop();?>
<?php $userID = $this->m_session->isLogin(); ?>
<?php if(!$userID): ?>
<form class="login_block" method="post" action="<?php echo base_url(); ?>login/auth">
        <ul id="submit_mask">
            <li class="login_li"><img src="<?php echo base_url(); ?>images/login_user.png" width="15" height="14" alt="" />Log In</li>
        </ul>
        <input type="submit" class="login" value="" />
        <div class="hide_form">
            <span class="form_links">
                <?php echo anchor('login/forget_password','Forget?','class="forgot"') ?>
                <?php echo anchor('register','Sign Up', 'class="green"'); ?>
            </span>
            <label>Email</label>
            <input type="text" name="email" class="username" />
            <label>Password <span>?</span></label>
            <input type="password" name="password" class="password" />
        </div>
    </form>
<?php else: 
  $getInboxCount = $this->m_session->getInboxCount($userID);
  $getWatchListCount = $this->m_session->getWatchListCount($userID); 
?>
    <div class="login_block">
      <ul id="submit_mask">
            <li class="login_li"><img src="<?php echo base_url(); ?>images/login_user.png" width="15" height="14" alt="" /><?php echo anchor('home/logout','Log Out'); ?></li>			
			<?=getchatmenu();?>
            <li><a href="<?php echo base_url(); ?>message/inbox"><img src="<?php echo base_url(); ?>images/message.png" width="19" height="14" alt="" />(<?=$getInboxCount?>)</a></li>
            <li><img src="<?php echo base_url(); ?>images/basket.png" width="23" height="21" alt="" />(5)</li>
            <li class="account">
                <img src="<?php echo base_url(); ?>images/account.png" width="16" height="16" alt="" />
                <?php echo anchor('user/editprofile/','Account'); ?><img src="<?php echo base_url(); ?>images/sub.png" width="7" height="4" alt="" />
                <div class="account_submenu">
                    <p><?php echo anchor('myoffice','My Office'); ?></p>
                    <p><?php echo anchor('message/inbox','My Messages'); ?></p>
                    <p><?php echo anchor('company','My Company'); ?></p>
                    <p><?php echo anchor('user/editprofile','My Profile'); ?></p>
                    <p><?php echo anchor('request/buy','Buying'); ?></p>
                    <p><?php echo anchor('product','Selling'); ?></p>
                </div>
            </li>
            <li><?php echo anchor('product','Sell'); ?></li>
            <li><?php echo anchor('request/buy','Buy'); ?></li>
            <li class="active_li">
                <a href="<?php echo base_url(); ?>user/watchlist"><img src="<?php echo base_url(); ?>images/watchlist.png" width="20" height="16" alt="" />
                    (<?php echo $getWatchListCount; ?>) items on your Watchlist.
                </a>
            </li>
      </ul>  
        </div>  
<?php endif; ?>