<?php
for($i=1; $i<=12; $i++) { 
    $month_array[$i] = $i;
}
$years = array(2012 => 2012, 2013 => 2013, 2014 => 2014, 2015 => 2015, 2016 => 2016, 2017 => 2017, 2018 => 2018, 2019 => 2019);
?>
<?php // echo form_open('user/upgrade'); ?>
<?php echo form_open('payment/checkout'); ?>

<input type="hidden" name="membership" value="<?=$chosen['membership'];?>" />
<input type="hidden" name="method" value="<?=$chosen['method'];?>" />
<input type="hidden" name="fee" value="<?=$chosen['fee']?>" />
<input type="hidden" name="period" value="<?=$chosen['period']?>" />
<input type="hidden" name="payment" value="1" />
<div id="office_tabs_block">
    <ul id="membership_tabs">
        <li class="step1"><a href="#">Step 1</a></li>
        <li class="step2"><a href="#">Step 2</a></li>
        <li class="step3 active"><a href="#">Step 3</a></li>
        <li class="step4"><a href="#">Step 4</a></li>
    </ul>
    <div id="office_tabs_content" class="membership_wrapper steps step3">
        <div class="membership_steps_left">
            <h3>Step 3. Payment</h3>
            <p class="membership_steps_head_text step3">
                <b>Member ID:</b> <?=$user['member_id'];?><br/> 
                <b>Service Period:</b> <?=$chosen['period'];?><br/>
                <b>Membership:</b> <?=ucfirst($chosen['membership']);?><br/>
                <b>Merchant:</b> TradeOffice.com<br/>
            </p>
            <div class="membership_steps_total">
                <p><b>Total:</b> US $ <?=$chosen['fee'];?></p>
            </div>
			<input type='image' name='submit' src='https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif' border='0' align='top' alt='Check out with PayPal'/>
        </div>
        <div class="membership_steps_right">
            <h3>Card Details</h3>
            <p class="label">Card Number *</p>
            <?php echo form_error("ccNumber"); ?> 
            <p><input type="text" name="ccNumber" value="<?php echo set_value('ccNumber'); ?>" class="my_office_buyer_input"/></p>
            <p class="label">Name On Card *</p>
            <?php echo form_error("ccName"); ?> 
            <p><input type="text" name="ccName" value="<?php echo set_value('ccName'); ?>" class="my_office_buyer_input"/></p>
            <p class="label"><span style="margin-right: 105px;">Month *</span>Year *</p>
            <div class="select small" style="float:left; margin-right:20px;">
                <?php echo form_dropdown('month', $month_array, set_value('month' ,date("n")), 'id="month"');?>
            </div>
            <div class="select small" style="margin-left:140px;">
                <?php echo form_dropdown('year', $years, set_value('year' ,date("Y")), 'id="year"');?>
            </div>
            <p class="label">CVC *</p>
            <?php echo form_error("ccCVC"); ?> 
            <p><input type="text" name="ccCVC" value="<?php echo set_value('ccCVC'); ?>" class="my_office_buyer_input" style="width:110px;"/></p>
            <p class="label">Street Address *</p>
            <?php echo form_error("address"); ?> 
            <p><input type="text" name="address" value="<?=$company['address']; ?>" readonly="readonly" class="my_office_buyer_input"/></p>
            <p class="label">City *</p>
            <?php echo form_error("city"); ?> 
            <p><input type="text" name="city" value="<?=$company['city']; ?>" readonly="readonly" class="my_office_buyer_input"/></p>
            <p class="label"><span style="margin-right:113px;">State</span>Country *</p>
            <?php echo form_error("country"); ?> 
            <div class="small" style="float:left; margin-right:20px;">
            <input type="text" name="state" value="<?=$company['state']; ?>" readonly="readonly" class="my_office_buyer_input" style="width:111px;" />
            </div>
            <input type="text" name="country" value="<?=$company['country']; ?>" readonly="readonly" class="my_office_buyer_input" style="width:158px;"/>
            <p class="label">Zip Code</p>
            <p><input type="text" name="zip" value="<?=$company['zip']; ?>" readonly="readonly" class="my_office_buyer_input" style="width:110px;"/></p>
            <div class="submit_block">
                <input type="submit" value="SUBMIT" class="submit" style="margin-bottom:30px; margin-top:0;"/>
            </div>
        </div>
    </div>
</div>
<?php echo form_close() ?>