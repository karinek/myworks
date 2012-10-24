<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Trade Office<?php echo isset($title) ? ' - '.$title : ''; ?></title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<?php $this->load->view('default/head'); ?>
        <script>
            $(document).ready(function () {
                var url = "<?=base_url();?>subscribe/subscribeMe";
                $('.subscribeButton').click(function(){
                    var subscribeInput = $('.subscribeInput').val();
					if(subscribeInput) {
						$('.subscribeLoader').show();
						$('.subscribeSuccess').hide();
						$('#subscribeError').hide();
                   
						$.post(url, {"data1":subscribeInput},
						function(data){
								if(data == ''){
								$('.subscribeSuccess').show();
								$('.subscribeSuccess').html(data);
								$('.subscribeInput').val('');
								$('.subscribeLoader').hide();
								$('.closer').trigger('click');
								}else{
								$('#subscribeError').css('display', 'block');
								$('#subscribeError').html(data);
								$('.subscribeLoader').hide();
								}
						});
					}
                });
            });
        </script>
</head>
<body>
    <div id="popup"></div>
    
    <div id="modal" class="unsubscibe">
        <div class="closer"></div>
        <h3>Subscribe to Our Emails:</h3>
        <form action="" method="post">
            <div id="subscribeError"></div>
            <div class="subscribeSuccess"></div>
            <small>Subscribe to our email newsletter for useful tips and valuable resources, send out every second week.</small>
<!--            <input type="text" value="" onfocus="if(this.value=='Email:') this.value='';" onblur="if(!this.value) this.value='Email:';" class="subscribeInput"/>-->
            <div class="subscribeLoader"><img src="<?=base_url();?>images/loader.gif" /></div>
            <p class="label">Email</p>
            <input type="text" value="" class="subscribeInput"/>
            <input type="button" value="SUBSCRIBE" class="subscribeButton"/>
        </form>
    </div>
    
    <!-- HEADER -->
        <div id="header">
            <div class="wrapper">
                <?php $this->load->view('default/header'); ?>
            </div>
        </div>
         <!-- CONTENT -->
    <div id="content"<?=isset($content_class)?' class="'.$content_class.'"':''?>>
		<?=isset($content_prewrapper)?$content_prewrapper:''?>
    	<div class="wrapper">
                <?php 
                    if(!isset($layout)) $layout = '2-columns-content-left';
                ?>
                    <?php $this->load->view('default/'.$layout); ?>
        </div>
    </div>
        <!-- FOOTER -->
    <div id="footer">
    	<div class="wrapper footer_menu_wrapper">
		<?php $this->load->view('default/footer'); ?>                
        </div>
        <div id="copyright">
        	<div class="wrapper">
            	<p><a href="<?=base_url('pages/copyright')?>" style="color:inherit;"><u>Copyright © TradeOffice Pty Ltd.</u></a> All Rights Reserved.</p>
            </div>
        </div>
    </div>
    <!-- End Footer -->
<div id="close_window"></div>

</body>
</html>