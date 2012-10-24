<script>
$().ready(function(){
   $("#section").selectbox(); 
   $("#priority").selectbox();
});
	function escapeHtml(unsafe) {
	  return unsafe
	      .replace(/&(?!amp;)/g, "&amp;")
	      .replace(/<(?!lt;)/g, "&lt;")
	      .replace(/>(?!gt;)/g, "&gt;")
	      .replace(/"(?!quot;)/g, "&quot;")
	      .replace(/'(?!#039;)/g, "&#039;");
	}
	function checkForm(){
		if($('#params-message').html().trim() == ''){
			alert('Message should be not empty');
			return false;
		}
		$('input[name="message"]').val(escapeHtml($('#params-message').html()));
		return true;
	}
</script>
<h3 class="page_links"><a href="<?=base_url()?>">Home</a> &gt; <a href="javascript:;">Help Desk</a></h3>

<div id="office_tabs_content" class="forum_posting_content">
    <div class="my_office_page forum_posting">
        <?php echo form_open('helpdesk/add/',array('name'=>'post-question','onsubmit'=>'return checkForm();'),$hidden); ?>
            <?=form_error("params['message']")?>
            <h2>Ask a Question</h2>
            <p class="green"><?=($msg) ? 'Your question successfully sent.' : ''?></p>
            <p class="label">Section <span class="required">*</span></p>
            <div class="select">
                <?php echo form_dropdown('section', $sections, '', 'id="section"'); ?>
            </div>
            <p class="label">Priority <span class="required">*</span></p>
            <div class="select">
                <?php echo form_dropdown('priority',array('high'=>'High', 'medium'=>'Medium', 'low'=>'Low'), '', 'id="priority"'); ?>
            </div>
            <p class="label">Username</p>
            <div>
               <?php echo $user['firstname']." ".$user['lastname'] ?>   
            </div>
            <p class="label">Message <span class="required">*</span></p>
            <p><?php $this->load->view('modules/forum/editor',array('text_name' => 'params-message', 'text_id' => 'params-message')); ?></p>
            <?php echo form_hidden('message','');?>
            <p class="small">* Maximum 2000 Characters</p>
            <br />
            <div class="submit_block">
                <?php echo form_submit('Ask','Ask', 'class="submit"');?>
            </div>
            <p>&nbsp;</p>
        <?php echo form_close(); ?>    
    </div>
</div>