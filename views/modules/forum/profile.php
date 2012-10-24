<script type="text/javascript" src="<?php echo base_url("js/jquery-1.7.2.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/jquery-ui-1.8.20.custom.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/validation/jquery.validate.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/ckeditor/ckeditor.js"); ?>"></script>
<?=link_tag('css/jquery-ui.css')?>

<div class="my_office_page member_profile">
	<div class="member_profile_head">
		<?php $this->load->view('modules/forum/profile_detail') ?>
	</div>
	<div id="profile-activity" class="tabsH format1 afTab">
		<ul class="tabs">
			<li class="ui-state-default ui-corner-top green ui-tabs-selected"><a href="#user-topics">Topics Posted</a></li>
			<li class="ui-state-default ui-corner-top yellow"><a href="#user-replies">Replies Posted</a></li>
		</ul>
		<div class="box" id="user-topics">
	<?php $this->load->view('modules/forum/profile_topic') ?>
		</div>
		<div class="box" id="user-replies">
	<?php $this->load->view('modules/forum/profile_comment') ?>
		</div>
	</div>

</div>

<script>
var loading;
(function($){
	$(document).ready(function(){
		$('#profile-activity').tabs();
		function intval(s){
			var n = parseInt(s,10);
			return isNaN(n)?null:n;
		}
		var username = '<?=$user->username?>';
		loading = {
			cont: 'user-topics',
			el: null,
			el_mask: null,
			width: 0,
			height: 0,
			top: 0,
			left: 0,
			init: function(){
				if(!this.el){
					this.cont = $('#'+this.cont);
					this.el = $('<div class="loading"></div>');
					this.el.css({display:'none'});
					this.el_mask = $('<div class="loading-mask"></div>');
					this.el_mask.css({display:'none'});
					console.log(this.el_mask.length)
					$(document.body).append(this.el).append(this.el_mask);
				}
			},
			show: function(){
				this.init();
				this.width = this.cont.width();
				this.height = this.cont.height();
				this.top = this.cont.offset().top;
				this.left = this.cont.offset().left;
				this.el.css({
					top:this.top+(this.height/2 - 15),
					left:this.left+(this.width/2 - 15)
				});
				this.el.show();
				this.el_mask.css({
					width:this.width,
					height:this.height,
					top:this.top,
					left:this.left
				});
				this.el_mask.show();
			},
			hide:function(){
				this.el.hide();
				this.el_mask.hide();
			}
		};
		function requestPage(obj){
			var $this = $(obj);
			if($this.parent().hasClass('disable')) return false;
			var parent = null;
			var type = null;
			var url = base_url();
			var page = null;
			if($this.parents('#user-topics').length){
				url +='forum/gettopic/'+username+'/';
				page = intval($this.attr('href').replace('#',''));
				parent = $('#user-topics');
				type = 'user-topics';
			}else if($this.parents('#user-replies').length){
				url +='forum/getcomment/'+username+'/';
				page = intval($this.attr('href').replace('#',''));
				parent = $('#user-replies');
				type = 'user-replies';
			}
			if(page!=null && page!=0){
				loading.show();
				var request = $.post(url+page,{},function(r){
					if(r.status){
						if(parent){
							var _item = null;
							parent.find('.member_posts_item').remove();

							parent.find('.next-page').attr('href','#'+(r.pagination.cur<r.pagination.page?intval(r.pagination.cur)+1:r.pagination.page));
							parent.find('.last-page').attr('href','#'+r.pagination.page);
							if(r.pagination.cur==r.pagination.page){
								parent.find('.next-page').parent().addClass('disable');
								parent.find('.last-page').parent().addClass('disable');
							}else{
								parent.find('.next-page').parent().removeClass('disable');
								parent.find('.last-page').parent().removeClass('disable');
							}

							parent.find('.previous-page').attr('href','#'+(r.pagination.cur>1?intval(r.pagination.cur)-1:0));
							if(r.pagination.cur==1) parent.find('.previous-page').parent().addClass('disable');
							else parent.find('.previous-page').parent().removeClass('disable');

							parent.find('.current-page').html(r.pagination.cur);
							var cont = parent.find('.member_posts');
							for(var i in r.result){
								_item = r.result[i];
								switch(type){
									case 'user-topics':
									cont.append('<div class="member_posts_item '+(i%2==0?'grey':'')+'">'+
										'<p class="subject_list"><a href="'+base_url()+'forum/topic/'+_item.id+'" ><span>'+_item.subject+'</span></a></p>'+
										'<p class="posted_list">'+_item.cdate+'</p>'+
										'<p class="views_list">'+_item.views+' / '+_item.replies+'</p>'+
									'</div>');
									break;
									case 'user-replies':
									cont.append('<div class="member_posts_item '+(i%2==0?'grey':'')+'">'+
										'<p class="subject_list"><a href="'+base_url()+'forum/topic/'+_item.id+'" ><span>'+_item.subject+'</span></a></p>'+
										'<p class="posted_list">'+_item.cdate+'</p>'+
									'</div>');
									break;
								}
							}
						}
						$this.one('click',function(e){
							requestPage(this);
							e.preventDefault();
							return false;
						});
					}
					loading.hide();
				},'json')
				request.error(function(r){
					loading.hide();
					console.log(JSON.stringify(r));
				});
			}
		}
		
		$('a.last-page, a.next-page, a.previous-page').one('click',function(e){
			requestPage(this);
			e.preventDefault();
			return false;
		});
	});
})(jQuery);
</script>