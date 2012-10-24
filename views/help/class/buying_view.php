<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>My Favorite</title>
</head>
<body>
    <h2></h2>
    
</head>
<style>
	#table_container {
		margin-left: 250px;
		padding: 10px;
	}
	
	#tab_head{
		list-style-type:none;
	}
	
	#tab_head li {
		display:inline;
	}
	
	#tab_head li {
    background-color: #DCE9F7;
    background-image: none;
    color: #0066CC;
    cursor: pointer;
    font-size: 13px;
    font-weight: bold;
    height: 47px;
    line-height: 47px;
    margin-right: 1px;
    text-align: center;
}

.tab_content{
	display: none;
}

.tab_content.on {
	display: block;
}



</style>


<script language="javascript" src="<?php echo base_url(); ?>js/jquery-1.7.2.min.js"></script>
<script>
$(document).ready(function(){
	$("#tab_head li").mouseenter (function(){
		var current_tab = $(this).attr('index');
		$('.tab_content').removeClass('on');
		$('.tab_content_' + current_tab).addClass('on');
	});
})	
</script>
<body>
	<div id="table_container">
		<h1>Safe Buying</h1>
            	<ul class="clearfix" id="tab_head"> 
                	<li index="1" class="floatL tab1">Finding Reliable Suppliers</li>
			<li index="2" class="floatL tab2">Payment &amp; Shipment</li>
			<li index="3" class="floatL tab3">Privacy &amp; Account Protection</li>
			<li index="4" class="floatL tab4">Solving Disputes</li>
                </ul>
                <div class="tab_content tab_content_1 on">
			<h5>Introduction</h5>
			<p>Every buyer wants to find reliable suppliers for their products. However, the Internet is full of scammers who are out to get the most
			out of unsuspecting buyers. One famous scam that is frequently used is the low price trap. Buyers who fall for this scam will be
			asked to pay money for products that are never delivered. That's why always encourages buyers to conduct due diligence
			before paying suppliers. In order to build trust faster, buyers can also trade with Factory Audited Gold Suppliers .
			Factory Audited Gold Suppliers have already been inspected onsite and have Audit Reports ready to download online.</p>
			<h5 class="title">Related Tips and Articles:</h5>
			<ul>
				<li>Should I use </li>
				<li>The Smart Way to Search Products</li>
				<li>What is Trade Pass?</li>
				<li>How do I Know if a Supplier is Reliable?</li>
				<li>Tips for Online Shopping When Making a Purchase</li>
			</ul>               	
                </div>  
                <div class="tab_content tab_content_2">
                    <h5>Introduction</h5>
                    <p>Please negotiate with the supplier about payment terms and payment methods before making actual payment. Contact details for suppliers can be found in their Company Website. You can also send messages to suppliers or chat with them on TradeManager.
		    Also, it is advisable to conduct pre-shipment inspection to reduce your risks. To secure your payment, you might want to consider using Escrow.</p>
                    <h5 class="title">Related Tips and Articles:</h5>
                    <ul>
                        <li>Accounts Suspected of Fraud </li>
			<li>3 Steps to Place an Order</li>
                    </ul>               	
                </div>  
                <div class="tab_content tab_content_3">
                	<h5>Introduction</h5>
                    <p>We will never give out your information without prior permission unless stated in our Privacy Policy.</p>
                    <p>We will never ask you to provide your password, credit card information, or other sensitive information in emails. If you do receive emails requesting your personal information, it might be a phishing scam.</p>
                    <p>Besides, you need to keep your passwords secret and protect your computer as daily care.</p>
                    <h5 class="title">Related Tips and Articles:</h5>
                    <ul>
			<li>Millions of website passwords posted online in hacker attack</li>
			<li>Millions of website passwords posted online in hacker attack</li>
			<li>Millions of website passwords posted online in hacker attack</li>
			<li>Millions of website passwords posted online in hacker attack</li>
                    </ul>               	
                </div>
                <div class="tab_content tab_content_4">
                	<h5>Introduction</h5>
                    <p>Disputes are common in international trade. However, disputes also happen because of misunderstandings between buyers and suppliers.</p>
                    <p>If you want to report a trade dispute click here.</p>
                    <p>Are you a victim of fraud? Learn more about our Fair Play Fund here.</p>
                    <h5 class="title">Related Tips and Articles:</h5>
                    <ul>
                    	<li>What are Common Trade Disputes?</li>
			<li>What are Common Trade Disputes?</li>
			<li>What are Common Trade Disputes?</li>
			<li>What are Common Trade Disputes?</li>
                    </ul>               	
                </div>          
            </div>
	

</body>
</html>