<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Trade Office</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<?php $this->load->view('splash/head'); ?>
</head>
<body class="splash">
    <!-- HEADER -->
	<div id="header">
    	<div class="wrapper">
			<?php $this->load->view('splash/header'); ?>
                    
            	<a href="<?=base_url()?>"><div class="logo splash_logo">
            </div></a>
		</div>
	</div>
    <!-- CONTENT -->
	<div id="content" class="splash_content">
    	<div class="wrapper splash_wrapper">
			<?php $this->load->view('splash/content'); ?>
        </div>
    </div>
	<!-- FOOTER -->
 <div id="footer" class="splash_footer">
    	<div class="wrapper">
            <p>Copyright © 2012 TradeOffice Pty Ltd </p>
		</div>
    </div>
    <!-- End Footer -->
<div id="close_window"></div>
</body>
</html>