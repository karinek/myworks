<script type="text/javascript" src="<?php echo base_url("js/validation/jquery.validate.min.js"); ?>"></script>

<?php $this->load->view('modules/forum/category_navbar'); ?>
<ul class="my_contacts_pagination" style="margin:15px 0; overflow:visible;">
    <li><?php echo '<a href="'.$pagination['url'].($pagination['page']).'">Last Page</a>' ?></li>
    <li class="next <?=$pagination['cur'] >= $pagination['page'] ?'disable':''?>"><?= $pagination['cur'] >= $pagination['page'] ? '<a href="#"></a>' : '<a href="'.$pagination['url'].($pagination['cur']+1).'"></a>' ?></li>
    <li class="prev <?=$pagination['cur'] <=1?'disable':''?>"><?= $pagination['cur'] <= 1 ? '<a href="#"></a>' : '<a href="'.$pagination['url'].($pagination['cur']-1).'"></a>' ?></li>
    <li>Page <span><?=$pagination['cur']?></span> / <?=$pagination['page']?></li>
	<li class="select">
		<select class="pagination">
			<?php for($i=1;$i<=$pagination['page'] && $i<=50 ;$i++): ?>
			<option value="<?=$i?>" <?=$i==$pagination['cur']?'selected':''?>><?=$i?></option>
			<?php endfor; ?>
		</select>
	</li>
	<li>Go To Page</li>
</ul>
<div class="clear"></div>
<div class="forum_block">
	<div class="forum_block_head">
        <p class="subject_list_head">Subject</p>
        <p class="latest_topics_list_head">Last Updated</p>
        <p class="topics_list_head">Views / Replies </p>
    </div>
<?php if(count($topics) && is_array($topics)): ?>
    <?php $i = 0;?>
	<?php foreach($topics as $key => $topic): ?>
        <?php $i++; ?>
		<?php $comment = $this->m_forum->get('comment',array('id'=>$topic->last_comment_id)); ?>
		<?php $stat = $this->m_forum->get('comment',array('id'=>$topic->last_comment_id)); ?>
		<?php $user =& M_misc::queryUser($topic->user_id,$this->m_forum); ?>
    
    <div class="forum_block_item<?=($i%2==0) ? ' white' : '' ?>">
        <div class="subject_list">
            <p><b><a href="<?=base_url(); ?>forum/topic/<?=$topic->id?>" class="green"><u><?=$topic->subject?></u></a></b></p>
            <p><i><?=M_misc::limitStr($topic->content,140,true)?></i> <?=$topic->replies+1>2?M_misc::renderPagination(base_url('forum/topic/'.$topic->id.'/'),($topic->replies+1)/$pagination['per_page']):''?><br>
            <b>by <a href="<?=base_url(); ?>forum/profile/<?=$user->username?>" class="orange"><?=$user->username?></a> on <?=$this->m_misc->formatDate('d M Y H:i',$topic->cdate)?></b></p>
        </div>
        <div class="latest_topics_list">
            <?php if(count($comment) && is_array($comment)): ?>
				<?php $c_user =& M_misc::queryUser($comment[0]->user_id,$this->m_forum); ?>
                <p class="orange"><b><?=anchor('forum/profile/'.$c_user->username,'<span>'.$c_user->username.'</span>', 'class="orange"')?></b></p>
                <p><b><?=$this->m_misc->formatDate('d M Y H:i',$comment[0]->mdate)?></b></p>
            <?php else: ?>
                <p class="orange"><b><?=anchor('forum/profile/'.$user->username,'<span>'.$user->username.'</span>', 'class="orange"')?></b></p>
                <p><b><?=$this->m_misc->formatDate('d M Y H:i',$topic->cdate)?></b></p>
            <?php endif; ?>
        </div>
        <div class="topics_list">
            <p><?=intval($topic->views)?> / <?=intval($topic->replies)?></p>
        </div>
    </div>
	<?php endforeach; ?>
<?php else: ?>
	<div class="forum_block_item white">
		<div class="subject_list">
            <p><b>No Topic</b></p>
		</div>
	</div>
<?php endif; ?>
</div>

<ul class="my_contacts_pagination" style="margin:15px 0; overflow:visible;">
    <li><?php echo '<a href="'.$pagination['url'].($pagination['page']).'">Last Page</a>' ?></li>
    <li class="next <?=$pagination['cur'] >= $pagination['page'] ?'disable':''?>"><?= $pagination['cur'] >= $pagination['page'] ? '<a href="#"></a>' : '<a href="'.$pagination['url'].($pagination['cur']+1).'"></a>' ?></li>
    <li class="prev <?=$pagination['cur'] <=1?'disable':''?>"><?= $pagination['cur'] <= 1 ? '<a href="#"></a>' : '<a href="'.$pagination['url'].($pagination['cur']-1).'"></a>' ?></li>
    <li>Page <span><?=$pagination['cur']?></span> / <?=$pagination['page']?></li>
	<li class="select">
		<select class="pagination">
			<?php for($i=1;$i<=$pagination['page'] && $i<=50 ;$i++): ?>
			<option value="<?=$i?>" <?=$i==$pagination['cur']?'selected':''?>><?=$i?></option>
			<?php endfor; ?>
		</select>
	</li>
	<li>Go To Page</li>
</ul>
<script>
$(document).ready(function(){
	$('select.pagination').selectbox({
		onChange: function(val,inst){
			window.location = '<?=$pagination['url']?>/'+val;
		}
	})
});
</script>
