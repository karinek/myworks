<html>
    <head>
        <?=link_tag('css/style.css')?>
        <!--jQuery-->
	<script type="text/javascript" src="<?=base_url()?>js/jquery-1.7.2.min.js"></script>
	<script src="<?php echo base_url(); ?>js/jquery.reveal.js"></script>

	<script type="text/javascript">
		$(document).ready(function() { // Button which will activate our modal
			   	$('#modal').reveal({ // The item which will be opened with reveal
				  	animation: 'fade',                   // fade, fadeAndPop, none
					animationspeed: 600,                       // how fast animtions are
					closeonbackgroundclick: false,              // if you click background will modal close?
					dismissmodalclass: 'close'    // the class of a button or element that will close an open modal
				});
			return false;
		});
	</script>
        <script>
            function redirectHome(){
                location.href = "<?php echo base_url(); ?>";
            }
            $(document).ready(function () {
                var url = "<?php echo base_url(); ?>subscribe/unsubscribe";
                $('#no').click(function(){
                    redirectHome();
                });
                $('#yes').click(function(){
                    $('#subscribeError').hide();
                    $('.subscribeSuccess').hide();
                    var subscribeInput = '<?php echo $hash; ?>';
                    
                    $.post(url, {"data1":subscribeInput},
                    function(data){
                        if(data == "<p style='color:#ff0000'>There is no such email</p>"){
                            $('#subscribeError').show();
                            $('#subscribeError').html(data);
                            setTimeout(redirectHome(), 50000);
                        }
                        else{
                            $('.subscribeSuccess').show();
                            $('.subscribeSuccess').html(data);
                            setTimeout(redirectHome(), 50000);
                        }
                    });
                });
            });
        </script>
    </head>
    <body>
        <div id="modal" class="unsubscibe">
            <h3>Do you really want to unsubscribe from TradeOffice?</h3>
            <div id="subscribeError"></div>
            <div class="subscribeSuccess"></div>
            <form action="">
<!--                <small>To unsubscribe please enter your email address and clcik unsubscribe</small>-->
<!--                <input type="text" value="" id="unsubscribeInput" class="splash_login_input"/>-->
                <input type="button" value="No" id="no" class="splash_login_submit"/>
                <input type="button" value="Yes" id="yes" class="splash_login_submit"/>
            </form>
        </div>
	
    </body>
</html>
