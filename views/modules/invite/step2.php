<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>TradeOffice</title>
		<?=link_tag('css/reset.css')?>
        <?=link_tag('css/style.css')?>
		<?=link_tag('css/jquery.selectbox.css')?>
	
        <script type="text/javascript" src="<?=base_url()?>js/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>js/jquery-ui-1.8.18.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>js/jquery.ui.widget.js"></script>
        <script type="text/javascript" src="<?=base_url()?>js/ui.checkbox.js"></script>
        <script type="text/javascript" src="<?=base_url()?>js/jquery.selectbox-0.1.3.min.js"></script>
        <script type="text/javascript">
            $(function(){
                $('.registration_edm_link input').checkBox();
            });
        </script>
    </head>

    <body class="splash">
        <div class="popup"></div>
<div class="registration_edm_link">
            <div class="close"></div>
            <h1>Thank you</h1>
			</div>
        <!-- HEADER -->
        <div id="header">
            <div class="wrapper">
                <!-- LOGO -->
                <div class="logo splash_logo">
                    <a href="#"></a>
                </div>
                <!-- End Logo -->
            </div>
        </div>
        <!-- End Header -->

        <!-- CONTENT -->
        <div id="content" class="splash_content">
            <img src="images/splash_map.jpg" width="100%" />

        </div>
        <!-- End Content -->

        <!-- FOOTER -->
        <div id="footer" class="splash_footer">
            <div class="wrapper">

            </div>
        </div>
        <!-- End Footer -->
    </body>
</html>
