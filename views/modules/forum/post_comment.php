<script type="text/javascript" src="<?php echo base_url("js/jquery-1.7.2.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/jquery-ui-1.8.20.custom.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/validation/jquery.validate.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/ckeditor/ckeditor.js"); ?>"></script>
<pre>

</pre>
<div id="office_tabs_content" class="forum_posting_content">
    <div class="my_office_page forum_posting">
        <?php echo form_open('forum/save/comment/'.$topic->id,array('name'=>'post-comment'),array('topic_id'=>$topic->id, 'comment_id'=> $comment ? $comment->id : 0, 'action'=>'comment')); ?>
            <h2>Reply</h2>
            <p class="label">Subject - Re: <?=$topic->subject?></p>
            <p class="label">Message <span class="required">*</span></p>
            <p><?php $this->load->view('modules/forum/editor',array('text_name' => 'params[content]', 'text_id' => 'params-content', 'content'=>isset($is_quote) && $is_quote?"&nbsp;\r\n[quote]".(preg_replace('/\[img\](\.\.\/)+/ms','[img]../../../../',$comment?$comment->content:$topic->content))."[/quote]":'')); ?></p>
            <p class="small">* Maximum 2000 Characters</p>
            <br />
            <div class="submit_block">
                <?php echo form_submit('Reply','Reply', 'class="submit"');?>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>
