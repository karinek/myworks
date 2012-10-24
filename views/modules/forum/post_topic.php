<script type="text/javascript" src="<?php echo base_url("js/jquery-1.7.2.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/jquery-ui-1.8.20.custom.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/validation/jquery.validate.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/ckeditor/ckeditor.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/jquery.nivo.slider.pack.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/jquery.jscrollpane.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/ui.checkbox.js"); ?>"></script>
<script type="text/javascript">
    $(function(){
        $('.forum_posting .head_text input').checkBox();
    });
</script>

<div id="office_tabs_content" class="forum_posting_content">
    <div class="my_office_page forum_posting">
        <?php echo form_open('forum/save/topic/'.$category->id,array('name'=>'post-topic'),array('params[cat_id]'=>$category->id, 'action'=>'topic', 'task'=>'save')); ?>
            <h2>Post New Article or Topic - <i><?=$category->name?></i></h2>
            <p class="label">Subject <span class="required">*</span></p>
            <p><input type="text" class="my_office_buyer_input" name="params[subject]" /></p>
            <p class="label">Message <span class="required">*</span></p>
            <p><?php $this->load->view('modules/forum/editor',array('text_name' => 'params[content]', 'text_id' => 'params-content')); ?></p>
            <p class="small">* Maximum 2000 Characters</p>
            <p class="head_text">
                <input type="checkbox" name="params[notify]" />
                <label><b>Notify me by email when someone replies.</b></label>
            </p>
            <div class="submit_block">
                <input type="submit" value="Post" name="post" class="submit" />
                <input type="button" value="Preview" class="preview" onclick="forum.preview()" style="display:none;" />
            </div>
        <?php echo form_close(); ?>
    </div>
</div>





<!--
<?php echo form_open('forum/save/topic/'.$category->id,array('name'=>'post-topic'),array('params[cat_id]'=>$category->id, 'action'=>'topic', 'task'=>'save')); ?>
	<div style="padding:5px 5px 0 0" class="floatright"><span class="required">* </span>Required information</div>
	<h2>Post New Article or Topic</h2>
	<br>
	<div style="border:1px solid #CEE9F9;background:#EEF7FD;" class="paddedbox12 remark"> <strong>Note: </strong>Share your e-commerce experiences with other members here. </div>
	<br>
	<table cellspacing="0" cellpadding="0" border="0" width="100%" id="form">
		<tbody>
			<tr>
				<th width="20%"><span class="required">*</span> Subject</th>
				<td><?php 
			echo form_input(array(
				'name' => 'params[subject]',
				'class' => 'required',
				'value' => ''
			));
		?></td>
			</tr>
			<tr>
				<th><span class="required">*</span> Message</th>
				<td><?php $this->load->view('modules/forum/editor',array('text_name' => 'params[content]', 'text_id' => 'params[content]')); ?></td>
			</tr>
			<tr>
				<th>Notify me when someone replies</th>
				<td><?php 
			echo form_radio(array(
				'name' => 'params[notify]',
				'class' => 'required',
				'checked' => true,
				'value' => '1'
			)); echo form_label('Yes');
			echo form_radio(array(
				'name' => 'params[notify]',
				'class' => 'required',
				'value' => '0'
			)); echo form_label('No');
		?></td>
			</tr>
			<tr id="re_notifyTr">
				<th></th>
				<td><?php
			echo form_radio(array(
				'name' => 'params[notify_option]',
				'class' => 'required',
				'checked' => true,
				'value' => 'email'
			)); echo form_label('by Email');
		?></td>
			</tr>
		</tbody>
	</table>
	<br>
	<div align="center">
		<?php
			echo form_button(array(
				'id' => 'topic-preview',
				'onclick' => 'forum.preview()',
				'content' => 'Preview'
			));
		?>&nbsp;&nbsp;
		<?php echo form_submit('post','Post'); ?>&nbsp;&nbsp;
		<?php
			echo form_button(array(
				'id' => 'topic-cancel',
				'onclick' => 'forum.cancel()',
				'content' => 'Cancel'
			));
		?>
	</div>
<?php echo form_close(); ?>
-->