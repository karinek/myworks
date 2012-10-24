<script>

		function openChat(url){
			//$('#mainChatWindow').css({top:'50%',left:'50%'});
			//$('#mainChatWindow').css('margin-left','-500px');
			
			
			$('html, body').animate({scrollTop:0}, 'slow');


			$('#mainChatWindow').show();
			$('#mainChatBg').show();
			
			setTimeout(function(){
			      $('#mainChatContent').html('<iframe src="'+url+'" width="900" height="770" noresize="0" border="1" ></iframe>');
			},800);
						
		}
		
	
		function closeChat(){
			$('#mainChatContent').html("<img src='<?php echo base_url(); ?>images/ajax-loading.gif'/>");
			$('#mainChatWindow').hide();
			$('#mainChatBg').hide();			
		}

	   function checkNewMessages(){
	   var burl='<?=base_url()?>chat/isnews';
	   
	   	$.ajax({ 
				  type: 'POST',
				  dataType:'JSON',
				  data:{},
				  url: burl, 
				  success: function(json){
				  	$('#chatCnt').html(json.count);
				  }
				});  
	   }
	   chatMsgProc = setInterval('checkNewMessages()', 30000);
	   </script>
	   <div class="popup" id='mainChatBg' style='display:none;'>
	   </div>
	   
	   
	  
        <div class="chat_popup" style="display:none;" id='mainChatWindow'>
            <div class="close" onclick="closeChat();"></div>
			
			<div id='mainChatContent'><img src='<?php echo base_url(); ?>images/ajax-loading.gif'/></div>

        </div>
	   
	   
	   
	 