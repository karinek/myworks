<h3 class="page_links"><a href="<?=base_url('/'); ?>">Home</a> &gt; <a href="<?=base_url('faq');?>">Help Desk</a></h3>
<!-- HELP PAGE -->
<div class="help_page">
    <div class="help_head">
        <div class="help_head_text">
            <h2>Trade Office - <span><a href="<?=base_url('faq');?>">Help Desk</a></span></h2>
            <p>We want to help you:</p>
        </div>
        <?php echo form_open('faq', 'method="get" class="help_head_form"'); ?>
            <div class="text">
                <input type="text" name="q" value="<?=(isset($keyword))?$keyword:''; ?>" />
            </div>
            <div class="submit">
                <input type="submit" value="Ask" />
            </div>
        <?php echo form_close(); ?>   
    </div>
    <ul class="help_nav">
            <li class="buying <?php echo ($type == 'buying')?'active':''; ?>">
            <a href="<?=base_url('faq/index/buying'); ?>">
                    <span class="help_nav_item_title">Buying</span>
                <span class="help_nav_text">Learn ways to sources products, contact suppliers, and post Buying Requests on tradeoffice.com.</span>
            </a>
        </li>
        <li class="selling <?php echo ($type == 'selling')?'active':''; ?>">
            <a href="<?=base_url('faq/index/selling'); ?>">
                    <span class="help_nav_item_title">Selling</span>
                <span class="help_nav_text">Learn ways to search for buyers, manage and promote products, on tradeoffice.com</span>
            </a>
        </li>
        <li class="safety <?php echo ($type == 'security')?'active':''; ?>">
            <a href="<?=base_url('faq/index/security'); ?>">
                    <span class="help_nav_item_title">Safety </span>
                <span class="help_nav_text">Being smart is not enough to protect yourself against cunning scammers,view more tips here.</span>
            </a>
        </li>
        <li class="accounts <?php echo ($type == 'accounts')?'active':''; ?>">
            <a href="<?=base_url('faq/index/accounts'); ?>">
                    <span class="help_nav_item_title">Accounts</span>
                <span class="help_nav_text">Learn about registration, signing in, account management and My Office.</span>
            </a>
        </li>
    </ul>
    <?php echo isset($content) ? $content : '';?>
</div>
