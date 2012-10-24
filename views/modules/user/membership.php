<div id="office_tabs_block">
    <div id="office_tabs_content" class="membership_wrapper">
        <div class="membership_content">
            <div class="membership_blocks">
                <div class="membership_platinum">
                    <div class="membership_platinum_logo"></div>
                    <div class="membership_platinum_ribon"></div>
                    <div class="membership_platinum_head">
                        <p>The Best Money Can Buy</p>
                    </div>
                    <div class="membership_platinum_price">
                        <img src="<?=base_url();?>images/membership_platinum_price.png" width="298" height="115" alt=""/>
                    </div>
                    <ul class="membership_platinum_text">
                        <li>The latin text generator is here</li>
                        <li>The latin text generator is here</li>
                        <li>The latin text generator is here</li>
                        <li>The latin text generator is here</li>
                    </ul>
                    <?php if(!empty($user) && $user['membership'] == "Free"): ?>
                            <a class="membership_platinum_button" href="<?=base_url();?>user/upgrade">Upgrade Now!</a>
                    <?php elseif(empty($user)): ?>
                            <a class="membership_platinum_button" href="<?=base_url();?>register">Sign up now!</a>
                    <?php endif; ?>
                </div>
                <div class="membership_gold">
                    <div class="membership_gold_logo"></div>
                    <div class="membership_gold_ribon"></div>
                    <div class="membership_gold_head">
                        <p>The Best Money Can Buy</p>
                    </div>
                    <div class="membership_gold_price">
                        <img src="<?=base_url();?>images/membership_gold_price.png" width="238" height="92" alt=""/>
                    </div>
                    <ul class="membership_gold_text">
                        <li>The latin text generator is here</li>
                        <li>The latin text generator is here</li>
                        <li>The latin text generator is here</li>
                        <li>The latin text generator is here</li>
                    </ul>
                    <?php if(!empty($user) && $user['membership'] == "Free"): ?>
                            <a class="membership_gold_button" href="<?=base_url();?>user/upgrade">Upgrade Now!</a>
                    <?php elseif(empty($user)): ?>
                            <a class="membership_gold_button" href="<?=base_url();?>register">Sign up now!</a>
                    <?php endif; ?>
                </div>
                <div class="membership_free">
                    <div class="membership_free_head">
                        <p>No Cost All Welcome</p>
                    </div>
                    <div class="membership_free_price">
                        <img src="<?=base_url();?>images/membership_free_price.png" width="238" height="92" alt=""/>
                    </div>
                    <ul class="membership_free_text">
                        <li>The latin text generator is here</li>
                        <li>The latin text generator is here</li>
                        <li>The latin text generator is here</li>
                        <li>The latin text generator is here</li>
                    </ul>
                    <?php if(empty($user)): ?>
                            <a class="membership_free_button" href="<?=base_url();?>register">Sign up now!</a>
                    <?php endif; ?>
                </div>
                <div class="membership_shadow"></div>
            </div>
            <div class="membership_description">
                <p>Platinum & Gold premium membership for suppliers on tradeoffice.com It provides an extensive number of promotional opportunities to maximize their exposure and return-on-investment. To qualify for a Platinum or Gold Membership, a supplier must complete an authentication and verification process by a reputable third-party security service provider appointed by Tradeoffice.com. Once approved, Platinum or Gold Members will display a special Membership icon to demonstrate their authenticity and service.</p>
            </div>
        </div>
    </div>
</div>