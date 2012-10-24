<?php if(count($groups) && is_array($groups)): ?>
	<?php foreach($groups as $group): ?>
<div>
	<div class="forum_block_head">
		<p class="trade_forum_head"><?=$group->name?></p>
		<p class="subject_head">Subject</p>
		<p class="latest_topics_head">Latest Topics</p>
		<p class="topics_head">Topics</p>
	</div>
	<?php $categories = $this->m_forum->get('category',array('group_id'=>$group->id)); ?>
	<?php if(count($categories) && is_array($categories)): ?>
		<?php $n_cat = 1; ?>
		<?php foreach($categories as $category): ?>
			<?php $topic = $this->m_forum->get('topic',array('id'=>$category->last_topic_id)); ?>
	<div class="forum_block_item">
		<div class="trade_forum">
			<a href="<?=base_url('forum/category/'.$category->id)?>"><img src="<?=base_url('/images/'.($category->image!=''?'forum/'.$category->image:'forum4.jpg'))?>" width="98" height="99" alt=""></a>
		</div>
		<div class="forum_subject">
			<h3><?=anchor('forum/category/'.$category->id,$category->name)?></h3>
			<i><p><?=stripslashes($category->desc)?></p></i>
			<p> <b>Moderator: <?php $this->load->view('modules/forum/group_moderator',array('category'=>$category)); ?></b> </p></td>
		</div>
		<div class="latest_topics">
		<?php if($topic): ?>
			<?php $t_user = $this->m_forum->get('user',array('user_id'=>$topic[0]->user_id)); ?>
			<h3 class="green"><?=anchor('forum/topic/'.$topic[0]->id,$topic[0]->subject,'class="green"')?></h3>
			<b>
				<p>By: <?=anchor('forum/profile/'.$t_user[0]->username,'<span class="orange">'.$t_user[0]->username.'</span>')?></p>
				<p><?=$this->m_misc->formatDate('d M Y H:i',intval($category->cdate))?></p>
			</b>
		<?php else: ?>
			No topic
		<?php endif; ?>
		</div>
		<div class="topics">
			<h3><?=$this->m_misc->formatNumber(intval($category->topics))?></h3>
		</div>
	</div>			
		<?php if($n_cat<4) $n_cat++; else break; ?>
		<?php endforeach; ?>
	<?php endif; ?>
</div>
	<?php endforeach; ?>
<?php endif; ?>
