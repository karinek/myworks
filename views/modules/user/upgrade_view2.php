<?php echo form_open('user/upgrade'); ?>
<div id="office_tabs_block">
    <ul id="membership_tabs">
        <li class="step1"><a href="#">Step 1</a></li>
        <li class="step2 active"><a href="#">Step 2</a></li>
        <li class="step3"><a href="#">Step 3</a></li>
        <li class="step4"><a href="#">Step 4</a></li>
    </ul>
    <div id="office_tabs_content" class="membership_wrapper steps">

            <div class="membership_steps_left">
                <h3>Step 2. Select Payment Type</h3>
                <p class="membership_steps_head_text">
                    <b>Membership Type:</b> <?=ucfirst($chosen['membership']);?> <br>
                    <b>Membership Period:</b> <?=$chosen['period']?>
                <div class="membership_steps_total">
                    <p><b>Total:</b> <?=$chosen['fee']?></p>
                </div>
                <p class="right"><i>This may take a few minutes...</i></p>
                <h3>Select Payment Option:</h3>
                <div class="select_membership_types step2">
                    <input type="hidden" name="membership" value="<?=$chosen['membership'];?>" />
                    <input type="hidden" name="fee" value="<?=$chosen['fee']?>" />
                    <input type="hidden" name="period" value="<?=$chosen['period']?>" />
                    <div class="select_membership_types_item" style="display:none;">
                        <img src="<?=base_url(); ?>images/wire_transfer.png" width="55" height="38" alt=""/>
                        <?php echo form_radio('method', 'wire')?>
                        <label><b>Wire Transfer</b></label>
                    </div>
                    <div class="select_membership_types_item">
                        <img src="<?=base_url(); ?>images/paypal.png" width="55" height="38" alt=""/>
                        <?php echo form_radio('method', 'paypal', true)?>
                        <label><b>Paypal</b></label>
                    </div>
                    <div class="select_membership_types_item" style="display:none;">
                        <img src="<?=base_url(); ?>images/visa.png" width="55" height="38" alt=""/>
                        <?php echo form_radio('method', 'visa')?>
                        <label><b>Visa</b></label>
                    </div>
                    <div class="select_membership_types_item" style="display:none;">
                        <img src="<?=base_url(); ?>images/mastercard.png" width="55" height="38" alt=""/>
                        <?php echo form_radio('method', 'master')?>
                        <label><b>MasterCard</b></label>
                    </div>
                </div>
            </div>
            <div class="membership_steps_right">
                <div class="membership_note">
                    <img src="<?=base_url(); ?>images/membership_note.png" width="52" height="58" alt=""/>
                    <p>Note: You can pay with any of the following credit cards: MasterCard, Visa, Diners Club, American Express.<br />
                    This payment method is provided by BIBIT. Except for Wire Transfer, you will be directed to an authorized <br />
                    payment platform where your information will be kept confidential using Secure Socket Layer (SSL) technology,<br />
                    the highest level of security available.</p>
                </div>

                <div class="submit_block">
                    <input type="submit" value="CONFIRM & CONTINUE" class="submit"  style="margin:20px auto; float:none;"/>
                </div>
            </div>

    </div>
</div>
<?php echo form_close() ?>