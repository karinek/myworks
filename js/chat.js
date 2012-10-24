app.debugMode = false;
if(typeof app.debug == 'undefined') app.debug = function(o){ if(app.debugMode)console.log(JSON.stringify(o));};
var Chat = Chat || {};
(function($){
	Chat = $.extend(Chat,{
		chat_id: null,
		_process: null,
		_log: null,
		_obj: null,
		init: function(){
			app.debug('init');
			var self = this;

			self._log = $('#log');
			self.setChatID($('#chat_id').val());

			self.autoScroll();
			self.startInterval();
		},
		setChatID: function(id){
			this.chat_id = id;
		},
		autoScroll: function(){
			app.debug('auto Scroll');
			var self = this;
			self._log.scrollTop(self._log[0].scrollHeight);
		},
		renderMessage: function(msg){
			app.debug('render messege');
			var self = this;
			self._log = $('#log');
			self._log.html(msg);
		},
		check: function(){
			var self = this;
//			if(self.chat_id>0){
				$.ajax({ 
					type: "POST",
					dataType:"JSON",
					data:{},
					url: app.base_url("chat/isnews"), 
					success: function(json){
						if(json.count>0){
							$.each(json.groups, function(i, row) {
								$('#cnt'+row.chat_id).html(row.cnt);
								if(row.chat_id==self.chat_id){
									$.ajax({ 
										type: "POST",
										data:{},
										url: $('#base_url').val()+"chat/drawmessages/"+self.chat_id, 
										success: function(msg){
											self.renderMessage(msg);
											self.autoScroll();
										}
									});					  
								}else{
									app.debug('check chat_id='+row.chat_id);
									var $tab = $('#cnt'+row.chat_id);
									if($tab.length>0){
										app.debug('already exist chat_id='+row.chat_id);
									}else{
										app.debug('create new tab for chat_id='+row.chat_id);
										$tab = $('<li class="another active userTab" lang="'+row.chat_id+'"><a href="#"><span id="userto'+row.chat_id+'" onclick="Chat.selectChat(\''+base_url('chat/showchat/'+row.chat_id)+'\',$(this).parent().parent(),'+row.chat_id+');">[NEW]</span>( <span class="red" id=\'cnt'+row.chat_id+'\'>'+row.cnt+'</span> )</a><span class="chat_tab_close" id="close<?=$temp_chat_id?>"  onclick="Chat.closeChat(\''+base_url('chat/closechat/'+row.chat_id)+'\',$(this));return false;" style="z-index:2000">x</span></li>');
										$('#chat_tabs').append($tab);
									}
								}
							});
							//{"count":1,"groups":[{"cnt":"1","chat_id":"3"}]}
						}else{
							$('.userTab').each(function(){ 
								var chat_id=$(this).attr('lang');
								
								$('#cnt'+self.chat_id).html('0');
							});
						}	
					}
				});
//			}
		},
		selectChat: function(url,obj,chat_id){
			app.debug('select chat');
			var self = this;
			
			self.chat_id = chat_id;
			self.stopInterval();
			self.showProgress();
			$.ajax({ 
				type: "POST",
				data:{},
				url: url, 
				success: function(msg){
					$('#chatDiv').html(msg);
					$('#chat_id').val(self.chat_id);
					
					var chat_person = $('#chatPerson').html();
					
					$('.userTab').each(function(){
						$(this).attr('class','another active userTab');
						var c_id=$(this).attr('lang');
						$('#close'+c_id).show();
					});
		
					obj.attr('class','chat_session userTab');
					$('#userto'+self.chat_id).html(chat_person)
					$('#usertotop').html(chat_person);

					$('#close'+self.chat_id).hide();
					$("#infoTabDiv").tabs();
		
					self.autoScroll();
		
					self.startInterval();
					self.hideProgress();
				}
			});
		},
		getPage: function(page, message){
			app.debug('get page');
			var self = this;

			self.stopInterval();
			self.showProgress();
			$.ajax({ 
				type: "POST",
				data:{message:message},
				url: page, 
				success: function(msg){
					self.renderMessage(msg);
					self.autoScroll();

					self.startInterval();
					self.hideProgress();
				}
			});
		},
		send: function(){
			app.debug('chat');
			var self = this;// chat_id = $('#chat_id').val();
			
			self.getPage(app.base_url("chat/proccess/"+self.chat_id), $('#message').val());
			$('#message').val('');
		},
		startInterval: function(){
			app.debug('start interval');
			var self = this;
			self._process = setInterval(function(){self.check()}, 1000);
		},
		stopInterval: function(){
			app.debug('stop interval');
			var self = this;
			clearInterval(self._process);
		},
		showProgress: function(){
			app.debug('show progress');
			$('#mainProccess').css({top:'50%',left:'50%',margin:'-'+($('#myDiv').height() / 2)+'px 0 0 -'+($('#myDiv').width() / 2)+'px'});
			$('#mainProccess').show();
		},
		hideProgress: function(){
			app.debug('hide progress');
			$('#mainProccess').hide();
		},
		closeChat: function(url,obj){
			app.debug('close chat');
			var self = this;
			self.stopInterval();
			self.showProgress();

			$.ajax({ 
				type: "POST",
				data:{},
				url: url, 
				success: function(msg){
					obj.parent().remove();
					
					$('#chatDiv').html(msg);
					$('#usertotop').html('nobody');
					self.chat_id = 0;

					self.startInterval();
					self.hideProgress();
				}
			});
		}
	});

	$(document).ready(function() {	
		Chat.init();
		$('#message').keydown(function(e){
			if(e.keyCode == 13){
				Chat.send();
			}
		});
	});

})(jQuery);