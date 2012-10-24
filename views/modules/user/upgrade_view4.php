<div id="office_tabs_block">
    <ul id="membership_tabs">
        <li class="step1"><a href="#">Step 1</a></li>
        <li class="step2"><a href="#">Step 2</a></li>
        <li class="step3"><a href="#">Step 3</a></li>
        <li class="step3 active"><a href="#">Step 4</a></li>
    </ul>
    <div id="office_tabs_content" class="membership_wrapper steps">

            <div class="membership_steps_left">
                <h3>Step 4. Congratulation, you are our <?=ucfirst($chosen['membership']);?> Memember now.</h3>
                <p class="membership_steps_head_text step3">
                    <b>Member ID:</b> <?=$user['member_id'];?><br/> 
                    <b>Address:</b> <?=$company['address']."\t".$company['city']."\t".$company['state']."\t".$company['country']."\t".$company['zip']?><br/>
                    <b>Contact:</b> <?=$company['phone_country'].$company['phone_area'].$company['phone_number']?><br/>
                    <b>Receipt Number:</b> <?=$payment->transaction_id?><br/>
                    <b>Order ID:</b> i<?=$payment->id?><br/>
                    <b>Service Period:</b> <?=$chosen['period'];?><br/> 
                    <b>Membership:</b> <?=$chosen['membership'];?><br/>
                    <b>Merchant:</b> TradeOffice.com
                </p>
                <div class="membership_steps_total">
                    <p><b>Total Charged:</b> US $ <?=$chosen['fee'];?></p>
                </div>
                <ul class="email_print">
                    <li class="email_li"><a href="#">Email This Page</a></li>
                    <li class="print_li"><a href="#">Print This page</a></li>
                </ul>
            </div>
            <div class="membership_steps_right">
                <div class="trade_confirmation">
                    <h2>Thank you <span class="black"><?=$user['firstname']?></span>.</h2>
                    <h4 class="center">A confirmation email has been sent to:</h4>
                    <h4 class="green center"><?=$user['email']?></h4>
                </div>
            </div>

    </div>
</div>