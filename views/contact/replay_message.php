<script type="text/javascript" src="<?php echo base_url(); ?>js/ajaxupload.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/toggleformtext.js"></script>
<script>
jQuery(document).ready(function() {
    	var thumb = $('#thumb');	

	new AjaxUpload('fileInput1', {
		action: $('#mask7').attr('action'),
		name: 'userfile',
		onSubmit: function(file, extension) {
			thumb.attr('width', "30px");
			thumb.attr('height', "30px");
			thumb.attr('src', $('#upload_image_folder').val() + "/" + "loading.gif");
		},
		onComplete: function(file, response) {
                   
//			thumb.load(function(){
//				$('.preview').removeClass('loading');
//				thumb.unbind();
//			});
			$('#mask7').append('<input id="upload_file" name="file_name[]" value="'+response+"..."+file+'" type="hidden"/>');
                        $('#list').append('<li>'+file+'</li>');
			//$('#upload_image').val();
		}});
                
      $(".send_message").click(function(){
          
     var data = $('#send_message').serialize();
   $(".send_message").colorbox({
       fixed:true,
       data:data
   });
})
})
</script>


<div style="height: 350px;">
    <form id="send_message" action="#">
        <input type="hidden" name="name" value="<?=$name?>"/>
        <input type="hidden" name="uid" value="<?=  md5($uid)?>"/>
        <input type="hidden" name="cid" value="<?=  md5($cid)?>"/>
        <input type="text" name="subject" class="subject" title="Subject"/>
        <textarea class="message" name="message" title="Message"></textarea>
        <div id="mask7"  action="<?php echo site_url('contact/file_preview'); ?>" style="width: 140px;cursor: pointer" >
                                        <div class="mask_button1" style="width: 138px;cursor: pointer">Upload File</div>
                                        <input name="userfile" type="file"  style="width: 140px;cursor: pointer" id="fileInput1" />
					<input id="upload_image_folder" type="hidden" value="<?php echo site_url('images/user_images/temp/'); ?>"/>
                                      
					
                                    </div>
          <ul id="list">
                                            
                                        </ul>
        <a class="send_message" href="<?php echo base_url(); ?>contact/save_message/">Send Message</a>
    </form>
</div>
