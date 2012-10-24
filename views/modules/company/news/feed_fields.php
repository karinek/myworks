<script type="text/javascript" src="<?php echo base_url(); ?>js/ajaxupload.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.validate.js"></script>
<div style="padding:20px;">
    <?=form_open('news/save','id="feed"',array('params[company_id]'=>$news['company_id'],'params[id]'=>isset($feed['id'])?$feed['id']:0))?>
	<h3 style="font-size:150%; font-weight:bold; margin-bottom:20px;">Feed Details:</h3>
	<p><span style="font-weight:bold;">Title</span>&nbsp;(<span id="title-limit">0</span>/70)</p>
	<input type="text" id="news-title" name="params[title]" class="required staff_edit_popup_input" value="<?=isset($feed['title'])?$feed['title']:''?>" alt="Title" style="width:308px; color:#333;" maxlength="70" />
	
	<p><span style="font-weight:bold;">Link</span></p>
	<input type="text" name="params[link]" value="<?=isset($feed['link'])?$feed['link']:''?>" alt="Phone Number" class="staff_edit_popup_input" style="width:308px; color:#333;" />
	
	<p><span style="font-weight:bold;">Content</span>&nbsp;(<span id="content-limit">0</span>/140)</p>
	<textarea maxlength="140" id="news-content" name="params[content]" class="required staff_edit_popup_input" style="width:308px; height:150px; color:#333;"><?=isset($feed['content'])?$feed['content']:''?></textarea>
	
	<input type="submit" class="submit_staff" value="Submit" />
    <script type="text/javascript">
    $(document).ready(function(e) {
		$('#news-content').on('keydown keyup change',function(e){
			var len = parseInt(this.getAttribute("maxlength"), 10); 
			$('#content-limit').html(this.value.length);
			if(this.value.length > len) { 
				this.value = this.value.substr(0, len); 
				return false; 
			} 
		});

		$('#news-title').on('keydown keyup change',function(e){
			var len = parseInt(this.getAttribute("maxlength"), 10); 
			$('#title-limit').html(this.value.length);
			if(this.value.length > len) { 
				this.value = this.value.substr(0, len); 
				return false; 
			} 
		});

		$('.close').click(function(){
			$('#contentBox').hide();
			$('#popup').hide(); 
		});
		$('form#feed').validate();
    });
    </script>
    <?=form_close()?>
</div>