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
		<h1>Safe Selling</h1>
            	<ul class="clearfix" id="tab_head"> 
		       	<li index="1" class="floatL s_tab1 current">Building Trust with Buyers</li>
			<li index="2" class="floatL s_tab2">Payment &amp; Shipment</li>
			<li index="3" class="floatL s_tab3">Account Protection</li>
			<li index="4" class="floatL s_tab4">Solving Disputes</li>
                </ul>
                <div class="tab_content tab_content_1 on">
                	<h5>Introduction</h5>
                    <p>What kind of supplier buyers trust most?</p>
                    <p>It's a tough question for all suppliers. Here, we provide some tips which may help you to build trust with your potential buyers.</p>
                    <h5 class="title">Related Tips and Articles:</h5>
                    <ul>
                    	<li>Simple Tips to Build Trust with Buyers</li>
                        <li>Simple Tips to Build Trust with Buyers</li>
			<li>Simple Tips to Build Trust with Buyers</li>
		    </ul>
                </div> 
                <div class="tab_content tab_content_2">
                	<h5>Introduction</h5>
                    <p>Choosing a suitable payment method is important for suppliers too. Use secure payment methods such as L/C or Escrow to protect yourself and use tracking services when shipping…</p>
                    
                    <h5 class="title">Related Tips and Articles:</h5>
                    <ul>
                    	<li>Payment &amp; Shipment Tips</li>       
                    </ul>               	
                </div> 
                <div class="tab_content tab_content_3">
                	<h5>Introduction</h5>
                    <p>Trade Office is the world's largest online B2B marketplace connecting buyers and suppliers worldwide. We are committed to promoting and providing a safe and fair trading environment to all users.
		    However, fraudsters are always devising new ways to cheat the honest trader and negatively affect the trading environment.
		    One example is by using phishing emails and websites. This fraud was mainly invented to cheat you of your Member ID, password and other personal details. When obtained, fraudsters will sign in to your account, pretend to be you and commit scams in your name.</p>
                    
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
                    
                    <h5 class="title">Related Tips and Articles:</h5>
                    <ul>
			<li>Millions of website passwords posted online in hacker attack</li>
			<li>Millions of website passwords posted online in hacker attack</li>
                    </ul>               	
                </div>         
            </div>
	

</body>
</html>