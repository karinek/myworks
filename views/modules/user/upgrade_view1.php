<?php if($user['membership'] == 'Platinum'):?>
    You are already Platinum Membership.
<?php else:?> 
<?php echo form_open('user/upgrade'); ?>
    <div id="office_tabs_block">
        <ul id="membership_tabs">
            <li class="step1 active"><a href="#">Step 1</a></li>
            <li class="step2"><a href="#">Step 2</a></li>
            <li class="step3"><a href="#">Step 3</a></li>
            <li class="step4"><a href="#">Step 4</a></li>
        </ul>
        <div id="office_tabs_content" class="membership_wrapper steps">
            <div class="membership_steps_left">
                <h3>Step 1. Select Type and Confirm Details</h3>
                <div class="select_membership_types">
                    <?php if($user['membership'] != 'Platinum'): ?>
                    <div class="platinum" >
                        <div class="select_membership_types_item">
                            <img src="<?=base_url();?>images/platinum.png" width="30" height="48" alt=""/>
                            <input type="radio" name="membership_option" value="platinum_12" />
                            <label><b>Platinum Membership</b> (US $ <?php echo $fees['platinum_12']; ?> per 12 months)</label>
                        </div>
                        <div class="select_membership_types_item">
                            <img src="<?=base_url();?>images/platinum.png" width="30" height="48" alt=""/>
                            <input type="radio" name="membership_option" value="platinum_24" />
                            <label><b>Platinum Membership</b>  (US $ <?php echo $fees['platinum_24']; ?> per 24 months)</label>
                        </div>
                    </div>
                    <?php endif ?>
                    <?php if($user['membership'] != 'Gold' && $user['membership'] != 'Platinum'): ?>
                    <div class="gold">
                        <div class="select_membership_types_item">
                            <img src="<?=base_url();?>images/gold.png" width="30" height="48" alt=""/>
                            <input type="radio" name="membership_option" value="gold_12" />
                            <label><b>Gold Membership</b>  (US $ <?php echo $fees['gold_12']; ?> per 12 months)</label>
                        </div>
                        <div class="select_membership_types_item">
                            <img src="<?=base_url();?>images/gold.png" width="30" height="48" alt=""/>
                            <input type="radio" name="membership_option" value="gold_24" />
                            <label><b>Gold Membership</b>  (US $ <?php echo $fees['gold_24']; ?> per 24 months)</label>
                        </div>
                    </div>
                    <?php endif ?>
                </div>
                <h3>Terms & Conditions</h3>
                <div class="terms_conditions_wrapper">
                    <div class="terms_conditions">
                        <p>Terms and conditions of TradeOffice.com</p>
                        <p>By participating in the Competition entrants agree to be bound by these rules (which may be amended or varied at any time by us) and by our decisions which are final in all matters relating to the Competition. By participating in the Competition, entrants also agree to our Website Terms and Conditions and Privacy Policy rules.</p>
                        <p>All prizes are non-transferable, no cash alternative will be offered. Arrangements for the fulfilment of prizes will be made by us. We reserve the right in our sole discretion to substitute any and all prizes with prizes of comparable value. No changes can be made to the prize by the winner. All prizes are subject to the terms and conditions of the manufacturer or supplier we will not replace any lost or stolen prize items once in the winner's possession. The winner further acknowledges that, to the maximum extent permitted by law, we are not responsible or liable for any warranty, representation, or guarantee (whether express or implied, in fact or in law) in relation to any prize, including but not limited to its quality or mechanical condition.</p>
                        <p>The receipt, by any winner, of any of the prize components of the Competition is conditional upon compliance with any and all laws, rules and regulations. The winner(s) are solely responsible for all insurance, applicable taxes and for any expenses not specified in the prize description.</p>
                        <p>The Competition is open to natural persons registered with the Website who are resident in the UK. Entrants must be aged 18 or over. We reserve the right to implement additional age requirements where necessary. The Competition is not open to employees and their immediate families of Energizer Group Ltd, Sword House, Totteridge road, High Wycombe, Bucks, HP13 6DG, affiliated companies and subsidiaries, their advertising and promotional agencies, any and all sponsors or the immediate family members of those people .
                        By entering the Competition, all entrants assign all rights, title and interest in all creative material uploaded onto the Website and/or sent by SMS.</p>
                        <p>By participating in the Competition entrants agree to be bound by these rules (which may be amended or varied at any time by us) and by our decisions which are final in all matters relating to the Competition. By participating in the Competition, entrants also agree to our Website Terms and Conditions and Privacy Policy rules.</p>
                        <p>All prizes are non-transferable, no cash alternative will be offered. Arrangements for the fulfilment of prizes will be made by us. We reserve the right in our sole discretion to substitute any and all prizes with prizes of comparable value. No changes can be made to the prize by the winner. All prizes are subject to the terms and conditions of the manufacturer or supplier we will not replace any lost or stolen prize items once in the winner's possession. The winner further acknowledges that, to the maximum extent permitted by law, we are not responsible or liable for any warranty, representation, or guarantee (whether express or implied, in fact or in law) in relation to any prize, including but not limited to its quality or mechanical condition.</p>
                        <p>The receipt, by any winner, of any of the prize components of the Competition is conditional upon compliance with any and all laws, rules and regulations. The winner(s) are solely responsible for all insurance, applicable taxes and for any expenses not specified in the prize description.</p>
                        <p>The Competition is open to natural persons registered with the Website who are resident in the UK. Entrants must be aged 18 or over. We reserve the right to implement additional age requirements where necessary. The Competition is not open to employees and their immediate families of Energizer Group Ltd, Sword House, Totteridge road, High Wycombe, Bucks, HP13 6DG, affiliated companies and subsidiaries, their advertising and promotional agencies, any and all sponsors or the immediate family members of those people .
                        By entering the Competition, all entrants assign all rights, title and interest in all creative material uploaded onto the Website and/or sent by SMS.</p>
                        <p>By participating in the Competition entrants agree to be bound by these rules (which may be amended or varied at any time by us) and by our decisions which are final in all matters relating to the Competition. By participating in the Competition, entrants also agree to our Website Terms and Conditions and Privacy Policy rules.</p>
                        <p>All prizes are non-transferable, no cash alternative will be offered. Arrangements for the fulfilment of prizes will be made by us. We reserve the right in our sole discretion to substitute any and all prizes with prizes of comparable value. No changes can be made to the prize by the winner. All prizes are subject to the terms and conditions of the manufacturer or supplier we will not replace any lost or stolen prize items once in the winner's possession. The winner further acknowledges that, to the maximum extent permitted by law, we are not responsible or liable for any warranty, representation, or guarantee (whether express or implied, in fact or in law) in relation to any prize, including but not limited to its quality or mechanical condition.</p>
                        <p>The receipt, by any winner, of any of the prize components of the Competition is conditional upon compliance with any and all laws, rules and regulations. The winner(s) are solely responsible for all insurance, applicable taxes and for any expenses not specified in the prize description.</p>
                        <p>The Competition is open to natural persons registered with the Website who are resident in the UK. Entrants must be aged 18 or over. We reserve the right to implement additional age requirements where necessary. The Competition is not open to employees and their immediate families of Energizer Group Ltd, Sword House, Totteridge road, High Wycombe, Bucks, HP13 6DG, affiliated companies and subsidiaries, their advertising and promotional agencies, any and all sponsors or the immediate family members of those people .
                        By entering the Competition, all entrants assign all rights, title and interest in all creative material uploaded onto the Website and/or sent by SMS.</p>
                        <p>By participating in the Competition entrants agree to be bound by these rules (which may be amended or varied at any time by us) and by our decisions which are final in all matters relating to the Competition. By participating in the Competition, entrants also agree to our Website Terms and Conditions and Privacy Policy rules.</p>
                        <p>All prizes are non-transferable, no cash alternative will be offered. Arrangements for the fulfilment of prizes will be made by us. We reserve the right in our sole discretion to substitute any and all prizes with prizes of comparable value. No changes can be made to the prize by the winner. All prizes are subject to the terms and conditions of the manufacturer or supplier we will not replace any lost or stolen prize items once in the winner's possession. The winner further acknowledges that, to the maximum extent permitted by law, we are not responsible or liable for any warranty, representation, or guarantee (whether express or implied, in fact or in law) in relation to any prize, including but not limited to its quality or mechanical condition.</p>
                        <p>The receipt, by any winner, of any of the prize components of the Competition is conditional upon compliance with any and all laws, rules and regulations. The winner(s) are solely responsible for all insurance, applicable taxes and for any expenses not specified in the prize description.</p>
                        <p>The Competition is open to natural persons registered with the Website who are resident in the UK. Entrants must be aged 18 or over. We reserve the right to implement additional age requirements where necessary. The Competition is not open to employees and their immediate families of Energizer Group Ltd, Sword House, Totteridge road, High Wycombe, Bucks, HP13 6DG, affiliated companies and subsidiaries, their advertising and promotional agencies, any and all sponsors or the immediate family members of those people .
                        By entering the Competition, all entrants assign all rights, title and interest in all creative material uploaded onto the Website and/or sent by SMS.</p>
                    </div>
                </div>
            </div>
            <div class="membership_steps_right">
                <h3>Billing Details</h3>
                <p class="label">Company Name</p>
                <p><input type="text" readonly="readonly" name="bill_company_name" value="<?php echo $company['name'] ?>" class="my_office_buyer_input"/></p>
                <p class="label">Your Email</p>
                <p><input type="text" readonly="readonly" name="bill_email" value="<?php echo $user['email'] ?>" class="my_office_buyer_input"/></p>
                <p class="label"><span style="margin-right: 87px;">First Name *</span>Last Name *</p>
                <p>
                    <input type="text" readonly="readonly" name="bill_first_name" value="<?php echo $user['firstname'] ?>" class="my_office_buyer_input small" style="width:145px; margin-right:0; border-radius:3px 0 0 3px;"/>
                    <input type="text" readonly="readonly" name="bill_last_name" value="<?php echo $user['lastname'] ?>" class="my_office_buyer_input small" style="border-left:none; width:144px; border-radius:0 3px 3px 0; margin-left:-3px;"/>
                </p>
                <p class="label">Street Address</p>
                <p><input type="text" readonly="readonly" name="bill_address" value="<?php echo $company['address'] ?>" class="my_office_buyer_input"/></p>
                <p class="label">City</p>
                <p><input type="text" readonly="readonly" name="bill_city" value="<?php echo $company['city'] ?>" class="my_office_buyer_input"/></p>
                <p class="label"><span style="margin-right:113px;">State</span>Country</p>
                <div class="small" style="float:left; margin-right:20px;">
                <p><input type="text" readonly="readonly" name="bill_city" value="<?php echo $company['state'] ?>" class="my_office_buyer_input" style="width:110px;"/></p>
                </div>
                <input type="text" readonly="readonly" name="bill_country" value="<?php echo $company['country'] ?>" class="my_office_buyer_input" style="width:158px;"/>
                <p class="label">Zip Code</p>
                <p><input type="text" readonly="readonly" name="bill_zip" value="<?php echo $company['zip'] ?>" class="my_office_buyer_input" style="width:110px;"/></p>
                <p class="label"><span style="margin-right: 53px;">Tel</span><span style="margin-right: 82px;">1234567</span>891011121314</p>
                <p>
                    <input type="text" readonly="readonly" name="bill_phone_country" value="<?php echo $company['phone_country'] ?>" class="my_office_buyer_input" style="width:40px; margin-right:15px;"/>
                    <input type="text" readonly="readonly" name="bill_phone_area" value="<?php echo $company['phone_area'] ?>" class="my_office_buyer_input" style="width:100px; margin-right:15px;"/>
                    <input type="text" readonly="readonly" name="bill_phone_number" value="<?php echo $company['phone_number'] ?>" class="my_office_buyer_input" style="width:100px;"/>
                </p>
<!--                <p class="small">
                    <input type="checkbox" />
                    <label><b>Platinum Membership</b> (US $ 2989.00 per 24 months)</label>
                </p>-->
                <div class="submit_block">
                    <input type="submit" value="CONFIRM & CONTINUE" class="submit"/>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>