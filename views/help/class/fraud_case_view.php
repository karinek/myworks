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
                	<li index="1" class="floatL tab1">For Buyers</li>
			<li index="2" class="floatL tab2">For Suppliers</li>
                </ul>
                <div class="tab_content tab_content_1 on">
                <h5>Introduction</h5>
                    <p><br>A series of fraud case studies is summarized from typical fraud cases that buyers or sellers often encounter when doing online
		    business. Learn from real fraud case analysis to avoid being scammed!<br><br></p>
                    <p>For buyers, below typical fraud tricks are recommended to read:<br><br></p>
                
                    <ul>
			<p><b>Common Cases</b></p>
			<li><b>10 Signs </b>of Online Scams</li>
			<li><b>10 Signs </b>of Online Scams</li>
			<li><b>10 Signs </b>of Online Scams</li>
			<li><b>10 Signs </b>of Online Scams</li>
			<br><br><p><b>Specialty Fraud Cases</b></p>
			<li>Brand Name Electronics Products</li>
			<li>Brand Name Electronics Products</li>
			<li>Brand Name Electronics Products</li>
			<li>Brand Name Electronics Products</li>
			<br><br>
                    </ul>      
                </div>  
                <div class="tab_content tab_content_2">
	                <h5>Introduction</h5>
		        <p><br>A series of fraud case studies is summarized from typical fraud cases that buyers or sellers often encounter when doing online
			business. Learn from real fraud case analysis to avoid being scammed!<br><br></p>
			<p>For sellers, below typical fraud tricks are recommended to know:<br><br></p>
                    
	                <ul>
				<li>Be Cautious of <b>Fake Business Impostor</b></li>
				<li>Be Cautious of <b>Fake Business Impostor</b></li>
				<li>Be Cautious of <b>Fake Business Impostor</b></li>
				<li>Be Cautious of <b>Fake Business Impostor</b></li>
			</ul>     
                </div>          
            </div>
</body>
</html>