<!-- might not used  -->


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mediax</title>
<link rel="stylesheet" type="text/css" href="css/reset.css" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/nivo.css" />
<link rel="stylesheet" type="text/css" href="css/skin.css" />
<link rel="stylesheet" type="text/css" href="css/jquery.selectbox.css" />
<link rel="stylesheet" type="text/css" href="css/lightbox.css" />
<link type="text/css" href="css/jquery.jscrollpane.css" rel="stylesheet" media="all" />
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.18.min.js"></script>
<script type="text/javascript" src="js/jquery.nivo.slider.pack.js"></script>
<script type="text/javascript" src="js/myscript.js"></script>
<script type="text/javascript" src="js/jquery.jcarousel.min.js"></script>
<script type="text/javascript" src="js/jquery.ui.widget.js"></script>
<script type="text/javascript" src="js/ui.checkbox.js"></script>
<script type="text/javascript" src="js/jquery.selectbox-0.1.3.min.js"></script>
<script type="text/javascript" src="js/lightbox.js"></script>
<script type="text/javascript" src="js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="js/jquery.jscrollpane.min.js"></script>
<script type="text/javascript" id="sourcecode">
	$(function()
	{
		$('.news_scrollbar ul').jScrollPane({showArrows: true});
	});
</script>
<script type="text/javascript">
    $(function(){
        $('#advanced_search_block input').checkBox();
		$('.company_product_desc_list .select input').checkBox();
	});
</script>
<script type="text/javascript">
	$(function () {
		$("#country_id1").selectbox();
		$("#country_id2").selectbox();
		$("#country_id3").selectbox();
		$("#country_id4").selectbox();
	});
</script>
</head>

<body>

	<!-- HEADER -->
    <div id="header">
    	<div class="wrapper">
        	
            <!-- RSS BLOCK -->
            <a href="#" class="rss_block">
            	<span>Subscribe <i><b>by</b></i> RSS <i><b>or</b></i> Email</span>
            </a>
            <!-- End Rss Block -->
            
            <!-- LOGIN BLOCK -->
            <form class="login_block" method="get" action="">
            	<ul id="submit_mask">
                	<li class="login_li"><img src="images/login_user.png" width="15" height="14" alt="" />Log In</li>
                    <li class=""><img src="images/message.png" width="19" height="14" alt="" />(28)</li>
                    <li class=""><img src="images/star.png" width="19" height="20" alt="" />(28)</li>
                    <li class=""><img src="images/basket.png" width="23" height="21" alt="" />(5)</li>
                    <li class=""><img src="images/account.png" width="16" height="16" alt="" />Account<img src="images/sub.png" width="7" height="4" alt="" /></li>
                    <li class="">Sell<img src="images/sub.png" width="7" height="4" alt="" /></li>
                    <li class="">Buy<img src="images/sub.png" width="7" height="4" alt="" /></li>
                    <li class="active_li"><img src="images/add.png" width="17" height="12" alt="" />(48) items on your washlist.</li>
                </ul>
                <input type="submit" class="login" value="" />
                <div class="hide_form">
                    <span class="form_links">
                    	<a href="#">Forgot?</a>
                        <a href="#" class="green">Sign Up</a>
                    </span>
                    <label>User Id</label>
                    <input type="text" class="username" />
                    <label>Password <span>?</span></label>
                    <input type="password" class="password" />
               	</div>
            </form>
            <!-- End Login Block -->
            
            <!-- LOGO -->
            <div class="logo">
            	<a href="#"></a>
            </div>
            <!-- End Logo -->
            
            <!-- TOP MENU -->
            <form name="search_form" action="" method="post">
            <ul class="top_nav">
            	
                <li class="input_state">
                	<input type="text" value="eq... Rubber Housing" onfocus="if(this.value=='eq... Rubber Housing') this.value='';" onblur="if(!this.value) this.value='eq... Rubber Housing';" />
                    <ul id="tabs">
                    	<li class="products active"><a href="#">Products</a></li>
                        <li class="suppliers"><a href="#">Suppliers</a></li>
                        <li class="buyers"><a href="#">Buyers</a></li>
                    </ul>
                </li>
                <li class="search">
                	<span class="lup">
                    	<input type="submit" value="Search" />
                    </span>
                </li>
                <li class="advanced_search">
                	<a href="#">Advanced Search</a>
               		
                </li>
                <li id="advanced_search_block">
                    <div class="advanced_item">
                        <div class="checkbox"><input type="radio" name="word" /><label>Exact match</label></div>
                        <div class="checkbox"><input type="radio" name="word" /><label>All this words</label></div>
                        <div class="checkbox"><input type="radio" name="word" /><label>One or more of these words</label></div>
                    </div>
                    <div class="advanced_item">
                        <div class="checkbox"><input type="radio" name="trade" /><label>Trade Pass Memebers</label></div>
                        <div class="checkbox"><input type="radio" name="trade" /><label>Assessed Supplier</label></div>
                    </div>
                  <div class="advanced_item">
                        <ul class="advanced_categories">
                        	<li class="type_li" style="float:none; margin-bottom:25px;">
                                <select name="country_id" id="country_id4">
                                    <option value="1">Business Type</option>
                                    <option value="1">Business Type</option>
                                    <option value="1">Business Type</option>
                                    <option value="1">Business Type</option>
                                    <option value="1">Business Type</option>
                                    <option value="1">Business Type</option>
                                    <option value="1">Business Type</option>
                                    <option value="1">Business Type</option>
                                </select>
                            </li>
                            <li class="currency">
                                <select name="country_id" id="country_id1">
                                    <option value="1">$ AU</option>
                                    <option value="1">$ USA</option>
                                    <option value="9">$ Canada</option>
                                    <option value="2">$ France</option>
                                    <option value="3">$ Spain</option>
                                    <option value="6">$ Bulgaria</option>
                                    <option value="7" disabled="disabled">$ Greece</option>
                                    <option value="8">$ Italy</option>
                                    <option value="5">$ Japan</option>
                                    <option value="11">$ China</option>
                                    <option value="4">$ Brazil</option>
                                    <option value="10">$ South Africa</option>
                                </select>
                            </li>
                            <li class="region">
                                <select name="country_id" id="country_id2">
                                    <option value="">Country/Region</option>
                                    <option value="1">USA</option>
                                    <option value="9">Canada</option>
                                    <option value="2">France</option>
                                    <option value="3">Spain</option>
                                    <option value="6">Bulgaria</option>
                                    <option value="7" disabled="disabled">Greece</option>
                                    <option value="8">Italy</option>
                                    <option value="5">Japan</option>
                                    <option value="11">China</option>
                                    <option value="4">Brazil</option>
                                    <option value="10">South Africa</option>
                                </select>
                            </li>
                            <li class="categories">
                                <select name="country_id" id="country_id3">
                                    <option value="">All Categories</option>
                                    <option value="1">USA</option>
                                    <option value="9">Canada</option>
                                    <option value="2">France</option>
                                    <option value="3">Spain</option>
                                    <option value="6">Bulgaria</option>
                                    <option value="7" disabled="disabled">Greece</option>
                                    <option value="8">Italy</option>
                                    <option value="5">Japan</option>
                                    <option value="11">China</option>
                                    <option value="4">Brazil</option>
                                    <option value="10">South Africa</option>
                                    <option value="">All Categories</option>
                                    <option value="1">USA</option>
                                    <option value="9">Canada</option>
                                    <option value="2">France</option>
                                    <option value="3">Spain</option>
                                    <option value="6">Bulgaria</option>
                                    <option value="7" disabled="disabled">Greece</option>
                                    <option value="8">Italy</option>
                                    <option value="5">Japan</option>
                                    <option value="11">China</option>
                                    <option value="4">Brazil</option>
                                    <option value="10">South Africa</option>
                                    <option value="">All Categories</option>
                                    <option value="1">USA</option>
                                    <option value="9">Canada</option>
                                    <option value="2">France</option>
                                    <option value="3">Spain</option>
                                    <option value="6">Bulgaria</option>
                                    <option value="7" disabled="disabled">Greece</option>
                                    <option value="8">Italy</option>
                                    <option value="5">Japan</option>
                                    <option value="11">China</option>
                                    <option value="4">Brazil</option>
                                    <option value="10">South Africa</option>
                                    <option value="">All Categories</option>
                                    <option value="1">USA</option>
                                    <option value="9">Canada</option>
                                    <option value="2">France</option>
                                    <option value="3">Spain</option>
                                    <option value="6">Bulgaria</option>
                                    <option value="7" disabled="disabled">Greece</option>
                                    <option value="8">Italy</option>
                                    <option value="5">Japan</option>
                                    <option value="11">China</option>
                                    <option value="4">Brazil</option>
                                    <option value="10">South Africa</option>
                                </select>
                            </li>
                         </ul>
                    </div>
                    <div class="close"></div>
                </li>
            </ul>
            </form>
            <!-- End Top Menu -->
            
        </div>
    </div>
    <!-- End Header -->
    
    <!-- CONTENT -->
    <div id="content">
    	<div class="wrapper">
        	
            <h3 class="page_links"><a href="#"><span class="grey">Home</span></a> &gt; <a href="#"><span class="grey">Company</span></a> &gt; <a href="#">Products ( <span class="green">43,014</span> )</a></h3>
            <!-- PRODUCT TABS -->
            <div id="office_tabs_block">
            	<ul id="office_tabs">
                    <li class="my_office"><a href="#">Home</a></li>
                    <li class="contacts_messages active"><a href="#">Products</a></li>
                    <li class="company_page"><a href="#">Contact</a></li>
                </ul>
                <div id="office_tabs_content">
                	<div class="my_office_page company">
                    	<div class="company_products_left">
                        	<h3>Products</h3>
                            <p class="online_offline"><a href="#" class="green">Online</a> - <a href="#">Offline</a></p>
                            <ul>
                            	<li class="active"><a href="#">Cotton Screen Print Shirts</a></li>
                                <li><a href="#">Cotton Screen Print Shirts</a></li>
                                <li><a href="#">Cotton Screen Print Shirts</a></li>
                                <li><a href="#">Cotton Screen Print Shirts</a></li>
                                <li><a href="#">Cotton Screen Print Shirts</a></li>
                                <li><a href="#">Cotton Screen Print Shirts</a></li>
                                <li><a href="#">Cotton Screen Print Shirts</a></li>
                                <li><a href="#">Cotton Screen Print Shirts</a></li>
                                <li><a href="#">Cotton Screen Print Shirts</a></li>
                                <li><a href="#">Cotton Screen Print Shirts</a></li>
                            </ul>
                        </div>
                        
                        <div class="company_products_right">
                        	<div class="company_products_head_form">
                                <form action="" class="products_search_form">
                                    <div class="check">
                                    	<a href="#"><i class="check_box"></i><i class="arrow"></i></a>
                                    </div>
                                    <div class="arrange_by">
                                    	<a href="#"><span>Arrange By</span><i class="arrow"></i></a>
                                    </div>
                                    <div class="text_block">
                                    	<input type="text" class="text" value="eg... Search Mail" onfocus="if(this.value=='eg... Search Mail') this.value='';" onblur="if(!this.value) this.value='eg... Search Mail';"/>
                                    </div>
                                    <div class="search">
                                        <input type="submit" value="Search"/>
                                    </div>
                                </form>
                                <ul class="my_contacts_pagination" style="clear:none; margin-top:6px;">
                                    <li><a href="#">Last Page</a></li>
                                    <li class="next"><a href="#"></a></li>
                                    <li class="prev disable"><a href="#"></a></li>
                                    <li>Page <span>1</span> / 287</li>
                                </ul>
                			</div>
                			<div class="company_products_main_block">
                				<p class="menu_head">Cotton Screen Print Shirts</p>
                                
                                <!-- PRODUCT DESCRIPTION -->
                                <div class="company_product_desc">
                                    <div class="left">
                                        <div class="img_block">
                                            <a href="images/product1.jpg" rel="lightbox" title="Chlorine"><img src="images/product1.jpg" width="157" height="228" alt=""/></a>
                                            <a href="images/product1.jpg" rel="lightbox" title="Chlorine"><img src="images/lup.png" width="13" height="13" alt="" class="zoom"/></a>
                                        </div>
                                    </div>
                                    <div class="right">
                                        <div class="head">
                                            <h2>Chlorine</h2>
                                            <div class="like">
                                                <span class="like_arrow">692</span>
                                            </div>
                                        </div>
                                        <p><b>Min. Order:</b> 1 Ton <b>Price:</b> US $900-1150 / Ton<br/>
                                        <b>Payment Terms:</b> L/C,D/P,T/T <b>Supply Ability:</b> 50 Ton per Day</p>
                                        <p><b>Additional Information:</b><br/> Packed in 10kg, 25kg, 40kg, 50kg II class dtrums with PVC plastic bag inside with 5.1 Oxidizing agent mark or 50kg round iron drum.</p>
                                        <p><b>Country:</b> China (Mainland) Business <b>Type:</b> Manufacturer <b>No of Employees:</b> 101 - 200<br/><b>Management Certification:</b> ISO 9001:2000; ISO 14001:2004;</p>
                                        <ul class="company_product_desc_list">
                                            <li class="select"><input type="checkbox" />Select</li>
                                            <li class="add_to_favorites"><a href="#">Add to Favorites</a></li>
                                            <li class="contact_company"><a href="#">Contact Company</a></li>
                                            <li class="add_to_wishlist"><a href="#">Add To Wishlist</a></li>
                                        </ul>
                                    </div> 
                                </div>
                                <!-- End Product Description -->
                                
                                <!-- PRODUCT DESCRIPTION -->
                                <div class="company_product_desc">
                                    <div class="left">
                                        <div class="img_block">
                                            <a href="images/product2.jpg" rel="lightbox" title="Chlorine"><img src="images/product2.jpg" width="157" height="228" alt=""/></a>
                                            <a href="images/product2.jpg" rel="lightbox" title="Chlorine"><img src="images/lup.png" width="13" height="13" alt="" class="zoom"/></a>
                                        </div>
                                    </div>
                                    <div class="right">
                                        <div class="head">
                                            <h2>Chlorine</h2>
                                            <div class="like">
                                                <span class="like_arrow">692</span>
                                            </div>
                                        </div>
                                        <p><b>Min. Order:</b> 1 Ton <b>Price:</b> US $900-1150 / Ton<br/>
                                        <b>Payment Terms:</b> L/C,D/P,T/T <b>Supply Ability:</b> 50 Ton per Day</p>
                                        <p><b>Additional Information:</b><br/> Packed in 10kg, 25kg, 40kg, 50kg II class dtrums with PVC plastic bag inside with 5.1 Oxidizing agent mark or 50kg round iron drum.</p>
                                        <p><b>Country:</b> China (Mainland) Business <b>Type:</b> Manufacturer <b>No of Employees:</b> 101 - 200<br/><b>Management Certification:</b> ISO 9001:2000; ISO 14001:2004;</p>
                                        <ul class="company_product_desc_list">
                                            <li class="select"><input type="checkbox" />Select</li>
                                            <li class="add_to_favorites"><a href="#">Add to Favorites</a></li>
                                            <li class="contact_company"><a href="#">Contact Company</a></li>
                                            <li class="add_to_wishlist"><a href="#">Add To Wishlist</a></li>
                                        </ul>
                                    </div> 
                                </div>
                                <!-- End Product Description -->
                                
                                <!-- PRODUCT DESCRIPTION -->
                                <div class="company_product_desc">
                                    <div class="left">
                                        <div class="img_block">
                                            <a href="images/product3.jpg" rel="lightbox" title="Chlorine"><img src="images/product3.jpg" width="157" height="228" alt=""/></a>
                                            <a href="images/product3.jpg" rel="lightbox" title="Chlorine"><img src="images/lup.png" width="13" height="13" alt="" class="zoom"/></a>
                                        </div>
                                    </div>
                                    <div class="right">
                                        <div class="head">
                                            <h2>Chlorine</h2>
                                            <div class="like">
                                                <span class="like_arrow">692</span>
                                            </div>
                                        </div>
                                        <p><b>Min. Order:</b> 1 Ton <b>Price:</b> US $900-1150 / Ton<br/>
                                        <b>Payment Terms:</b> L/C,D/P,T/T <b>Supply Ability:</b> 50 Ton per Day</p>
                                        <p><b>Additional Information:</b><br/> Packed in 10kg, 25kg, 40kg, 50kg II class dtrums with PVC plastic bag inside with 5.1 Oxidizing agent mark or 50kg round iron drum.</p>
                                        <p><b>Country:</b> China (Mainland) Business <b>Type:</b> Manufacturer <b>No of Employees:</b> 101 - 200<br/><b>Management Certification:</b> ISO 9001:2000; ISO 14001:2004;</p>
                                        <ul class="company_product_desc_list">
                                            <li class="select"><input type="checkbox" />Select</li>
                                            <li class="add_to_favorites"><a href="#">Add to Favorites</a></li>
                                            <li class="contact_company"><a href="#">Contact Company</a></li>
                                            <li class="add_to_wishlist"><a href="#">Add To Wishlist</a></li>
                                        </ul>
                                    </div> 
                                </div>
                                <!-- End Product Description -->
                                
                                <!-- PRODUCT DESCRIPTION -->
                                <div class="company_product_desc">
                                    <div class="left">
                                        <div class="img_block">
                                            <a href="images/product4.jpg" rel="lightbox" title="Chlorine"><img src="images/product4.jpg" width="157" height="228" alt=""/></a>
                                            <a href="images/product4.jpg" rel="lightbox" title="Chlorine"><img src="images/lup.png" width="13" height="13" alt="" class="zoom"/></a>
                                        </div>
                                    </div>
                                    <div class="right">
                                        <div class="head">
                                            <h2>Chlorine</h2>
                                            <div class="like">
                                                <span class="like_arrow">692</span>
                                            </div>
                                        </div>
                                        <p><b>Min. Order:</b> 1 Ton <b>Price:</b> US $900-1150 / Ton<br/>
                                        <b>Payment Terms:</b> L/C,D/P,T/T <b>Supply Ability:</b> 50 Ton per Day</p>
                                        <p><b>Additional Information:</b><br/> Packed in 10kg, 25kg, 40kg, 50kg II class dtrums with PVC plastic bag inside with 5.1 Oxidizing agent mark or 50kg round iron drum.</p>
                                        <p><b>Country:</b> China (Mainland) Business <b>Type:</b> Manufacturer <b>No of Employees:</b> 101 - 200<br/><b>Management Certification:</b> ISO 9001:2000; ISO 14001:2004;</p>
                                        <ul class="company_product_desc_list">
                                            <li class="select"><input type="checkbox" />Select</li>
                                            <li class="add_to_favorites"><a href="#">Add to Favorites</a></li>
                                            <li class="contact_company"><a href="#">Contact Company</a></li>
                                            <li class="add_to_wishlist"><a href="#">Add To Wishlist</a></li>
                                        </ul>
                                    </div> 
                                </div>
                                <!-- End Product Description -->
                                
                                <!-- PRODUCT DESCRIPTION -->
                                <div class="company_product_desc">
                                    <div class="left">
                                        <div class="img_block">
                                            <a href="images/product5.jpg" rel="lightbox" title="Chlorine"><img src="images/product5.jpg" width="157" height="228" alt=""/></a>
                                            <a href="images/product5.jpg" rel="lightbox" title="Chlorine"><img src="images/lup.png" width="13" height="13" alt="" class="zoom"/></a>
                                        </div>
                                    </div>
                                    <div class="right">
                                        <div class="head">
                                            <h2>Chlorine</h2>
                                            <div class="like">
                                                <span class="like_arrow">692</span>
                                            </div>
                                        </div>
                                        <p><b>Min. Order:</b> 1 Ton <b>Price:</b> US $900-1150 / Ton<br/>
                                        <b>Payment Terms:</b> L/C,D/P,T/T <b>Supply Ability:</b> 50 Ton per Day</p>
                                        <p><b>Additional Information:</b><br/> Packed in 10kg, 25kg, 40kg, 50kg II class dtrums with PVC plastic bag inside with 5.1 Oxidizing agent mark or 50kg round iron drum.</p>
                                        <p><b>Country:</b> China (Mainland) Business <b>Type:</b> Manufacturer <b>No of Employees:</b> 101 - 200<br/><b>Management Certification:</b> ISO 9001:2000; ISO 14001:2004;</p>
                                        <ul class="company_product_desc_list">
                                            <li class="select"><input type="checkbox" />Select</li>
                                            <li class="add_to_favorites"><a href="#">Add to Favorites</a></li>
                                            <li class="contact_company"><a href="#">Contact Company</a></li>
                                            <li class="add_to_wishlist"><a href="#">Add To Wishlist</a></li>
                                        </ul>
                                    </div> 
                                </div>
                                <!-- End Product Description -->
                                
                                <ul class="my_contacts_pagination" style="margin-top:15px;">
                                    <li><a href="#">Last Page</a></li>
                                    <li class="next"><a href="#"></a></li>
                                    <li class="prev disable"><a href="#"></a></li>
                                    <li>Page <span>1</span> / 287</li>
                                </ul>
                    		
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Product Tabs -->
            
            
        </div>
    </div>
    <!-- End Content -->
    
    <!-- FOOTER -->
    <div id="footer">
    	<div class="wrapper">
        	<div class="footer_left">
            	<ul class="first_list">
                	<li class="footer_head">About</li>
                    <li><a href="#">Information</a></li>
                    <li><a href="#">Advertisers</a></li>
                    <li><a href="#">Partners</a></li>
                    <li><a href="#">Sitemap</a></li>
                </ul>
                <ul class="second_list">
                	<li class="footer_head">Contact &amp; Support</li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Support Ticket</a></li>
                    <li><a href="#">Email Enquiries</a></li>
                    <li><a href="#">Support Guide</a></li>
                    <li><a href="#">Call Centre</a></li>
                    <li><a href="#">Safety &amp; Security</a></li>
                </ul>
            </div>
            <div class="footer_left">
            	<ul class="first_list">
                	<li class="footer_head">Buying</li>
                    <li><a href="#">Requirements for Buying</a></li>
                    <li><a href="#">Terms &amp; Conditions</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Membership Details</a></li>
                </ul>
                <ul class="second_list">
                	<li class="footer_head">Selling</li>
                    <li><a href="#">Requirements for Selling</a></li>
                    <li><a href="#">Terms &amp; Conditions</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Membership Details</a></li>
                </ul>
            </div>
            <ul class="main_list">
                	<li class="footer_head">Managers</li>
                    <li><a href="#">User Login</a></li>
                    <li><a href="#">Assesement Tools</a></li>
                    <li><a href="#">Calculators</a></li>
                    <li><a href="#">Currency Converter</a></li>
                    <li><a href="#">Market Watch</a></li>
                    <li><a href="#">Alerts</a></li>
            </ul>
        </div>
        <div id="copyright">
        	<div class="wrapper">
            	<p>Copyright 2012 ##########. All Rights Reserved.</p>
            </div>
        </div>
    </div>
    <!-- End Footer -->
</body>
</html>
