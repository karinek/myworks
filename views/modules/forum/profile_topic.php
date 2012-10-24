	<ul class="my_contacts_pagination" style="margin-top:15px; float:right; overflow:visible;">
		<li><a class="last-page " href="#<?=ceil($user->topics/$this->m_forum->per_page_records)?>">Last Page</a></li>
		<li class="next <?=$user->topics>0 && ceil($user->topics/$this->m_forum->per_page_records)>1?'':'disable'?>"><a class="next-page" href="#<?=ceil($user->topics/$this->m_forum->per_page_records)>1?2:1?>"></a></li>
		<li class="prev disable"><a class="previous-page" href="#0"></a></li>
		<li>Page <?=$user->topics>0?'<span class="current-page">1</span> / '.ceil($user->topics/$this->m_forum->per_page_records):'<span class="current-page">0</span> / 0'?></li>
	</ul>
	<h3 style="margin-top: 20px;">Members Posts</h3>
	<div class="member_posts">
		<div class="member_posts_head">
			<p class="subject_list_head">Subject</p>
			<p class="posted_list_head">Posted</p>
			<p class="views_list_head">Views / Replies </p>
		</div>
<?php if(count($topics) && is_array($topics)): ?>
	<?php $i=0 ?>
	<?php foreach($topics as $key => $topic): ?>
		<div class="member_posts_item <?=$i%2==0?'grey':''?>">
			<p class="subject_list"><?=anchor('forum/topic/'.$topic->id,'<span>'.$topic->subject.'</span>')?></p>
			<p class="posted_list"><?=$this->m_misc->formatDate('d M Y H:i',$topic->cdate)?></p>
			<p class="views_list"><?=$topic->views?> / <?=$topic->replies?></p>
		</div>
		<?php $i++; ?>
	<?php endforeach; ?>
<?php else: ?>
		<div class="member_posts_item grey">
			<p class="subject_list">Don't have any Topic</p>
		</div>
<?php endif; ?>
	</div>
	<ul class="my_contacts_pagination" style="margin-top:15px; float:right; overflow:visible;">
		<li><a class="last-page " href="#<?=ceil($user->topics/$this->m_forum->per_page_records)?>">Last Page</a></li>
		<li class="next <?=$user->topics>0 && ceil($user->topics/$this->m_forum->per_page_records)>1?'':'disable'?>"><a class="next-page" href="#<?=ceil($user->topics/$this->m_forum->per_page_records)>1?2:1?>"></a></li>
		<li class="prev disable"><a class="previous-page" href="#0"></a></li>
		<li>Page <?=$user->topics>0?'<span class="current-page">1</span> / '.ceil($user->topics/$this->m_forum->per_page_records):'<span class="current-page">0</span> / 0'?></li>
	</ul>
	<div class="clear"></div>
