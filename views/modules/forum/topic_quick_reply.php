<div class="post-replay clearfix">
	<h2>Post a Reply</h2>
	<div class="replay-box">
		<?php echo form_open('forum/save/comment/'.$topic->id,array('name'=>'post-comment'),array('topic_id'=>$topic->id, 'action'=>'comment')); ?>
			<?php $this->load->view('modules/forum/editor',array('text_name' => 'params[content]', 'text_id' => 'params-content', 'text_width'=>958)); ?>
            <br />
			<div class="submit_block">
                <?php echo form_submit('Reply','Reply', 'class="submit"');?>
            </div>
		<?php echo form_close(); ?>
	</div>
</div>