<script>
$().ready(function(){
    $('#confirm_no').click(function(){
        $('#popup_bg').hide();
        $('#confirm_window').hide();
        $('#msg').show();
    });
    $('#confirm_yes').click(function(){
        location.href = '<?=base_url('product/confirm_seller_request')?>'
    });
})
</script>
<div id="office_tabs_block">
	<?php $this->load->view('modules/company/tabs_nav',array('selectedPage'=>'Selling')); ?>
	<div id="office_tabs_content">
		<div class="my_office_buyer_page" >
			<div style="min-height: 300px;padding:50px;">
		        <h2 id="msg">Only sellers can access this page!</h2>
			</div>
		</div>
	</div>
</div>

<div id="popup_bg"></div>
<div id="confirm_window">
    <h2>Do you like to be as Seller?</h2>
    <p>
        <input type="button" value="Yes" id="confirm_yes" class="" />
        <input type="button" value="No" id="confirm_no" class="" />
    </p>
</div>