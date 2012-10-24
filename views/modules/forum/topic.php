<script type="text/javascript" src="<?php echo base_url("js/validation/jquery.validate.min.js"); ?>"></script>

<script type="text/javascript">
$(function () {
    $("#go_to_page_list").selectbox();
    
    $('.like_mask.topic').click(function(){
        var $this =  $(this);
        $.get("<?php echo base_url()?>forum/like_topic/"+$(this).attr('id'), {}, function(data){
            $this.next().html(data);
        });
    });
    
    $('.like_mask.comment').click(function(){
        var $this =  $(this);
        $.get("<?php echo base_url()?>forum/like_comment/"+$(this).attr('id'), {}, function(data){
            $this.next().html(data);
        });
    });

    $('.dislike_mask.topic').click(function(){
        var $this =  $(this);
        $.get("<?php echo base_url()?>forum/dislike_topic/"+$(this).attr('id'), {}, function(data){
            $this.next().html(data);
        });
    });
    
    $('.dislike_mask.comment').click(function(){
        var $this =  $(this);
        $.get("<?php echo base_url()?>forum/dislike_comment/"+$(this).attr('id'), {}, function(data){
            $this.next().html(data);
        });
    });
});
</script>
<?php if($topic): ?>
	<?php $user =& M_misc::queryUser($topic->user_id,$this->m_forum); ?>
	<?php $this->load->view('modules/forum/topic_navbar'); ?>

	<ul class="my_contacts_pagination" style="margin:15px 0; overflow:visible;">
		<li><?php echo '<a href="'.$pagination['url'].'/'.($pagination['page']).'">Last Page</a>' ?></li>
		<li class="next <?=$pagination['cur'] >= $pagination['page'] ?'disable':''?>"><?= $pagination['cur'] >= $pagination['page'] ? '<a href="#"></a>' : '<a href="'.$pagination['url'].'/'.($pagination['cur']+1).'"></a>' ?></li>
		<li class="prev <?=$pagination['cur'] <=1?'disable':''?>"><?= $pagination['cur'] <= 1 ? '<a href="#"></a>' : '<a href="'.$pagination['url'].'/'.($pagination['cur']-1).'"></a>' ?></li>
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
    <!-- FORUM BLOCK -->
        <div class="forum_block">
            <!-- FORUM TOPIC ITEM -->
			<?php if($pagination['cur']==1): ?>
            <div class="forum_topic_item white">
                <div class="forum_topic_item_left">
                <?php
                    $avatar = 'images/user_images/';
                    $avatar .= (!empty($user->image)) ? $user->image : 'no_photo.jpg';
                ?>
                    <?php echo anchor('forum/profile/'.$user->username,'<img alt="'.$user->username.'" src="'.base_url($avatar).'" border="0" width="100" height="100">')?>
                    <p class="image_title orange"><?php echo anchor('forum/profile/'.$user->username,'<span>'.$user->username.'</span>', 'class="orange"')?></p>
                    <p><?php echo anchor('compdetail/'.M_encrypt::encode($user->company_id),'My Company Profile')?></p>
                    <p>Overall Ranking: <span class="author-mvp">MVP:<?php echo $user->point?></span> <span class="author-rank">Rank:<?php echo $user->rank?></span></p>
                    
                    <p><span <?php echo $user->status?'class="green"':''?>>Online</span> - <span <?php echo $user->status?'':'class="red"'?>>Offline</span></p>
                </div>
                <div class="forum_topic_item_main">
                    <div class="forum_topic_item_main_head">
                        <p class="post_number"><b>Post <span class="green">1</span> / <span class="green"><?php echo intval($topic->replies)?></span></b></p>
                        <h2><?php echo $topic->subject?></h2>
                        <div class="like">
                            <span class="like_mask topic" id="<?php echo $topic->id?>"></span>
                            <span class="like_arrow"><?php echo $topic->like?></span>
                        </div>
                        <div class="dislike">
                            <span class="dislike_mask topic" id="<?php echo $topic->id?>"></span>
                            <span class="dislike_arrow"><?php echo $topic->dislike?></span>
                        </div>
                    </div>
                    <p><i><?php echo M_misc::bbcode2html($topic->content)?></i></p>
                    <p>TradeOffice.com Forum<br><b>by <a href="<?php echo base_url('forum/profile/'.$user->username)?>" class="orange"><?php echo $user->username?></a> on <?php echo $this->m_misc->formatDate('d M Y H:i',$topic->cdate)?></b></p>
                    <div class="reply_quote"><?php echo anchor('forum/post/comment/'.$topic->id.'/0','Reply', 'class="green"')?> / <?php echo anchor('forum/post/comment/'.$topic->id.'/0?quote=1','Quote', 'class="green"')?></div>
                </div>
            </div> 
			<?php endif; ?>
            <!-- End Forum Topic Item -->
        
    <!-- End Forum Block -->
    <?php if(count($comments) && is_array($comments)): ?>
        <?php $counter = 2; ?>
        <?php foreach($comments as $comment): ?>
            <?php $user =& M_misc::queryUser($comment->user_id,$this->m_forum); ?>
            <?php //$user = $this->m_forum->get('user_complete',array('id'=>$comment->user_id)); $user = $user[0]; ?>
                <?php
                    $avatar = 'images/user_images/';
                    $avatar .= (!empty($user->image)) ? $user->image : 'no_photo.jpg';
                ?>
                <div class="forum_topic_item <?php echo ($counter%2!=0) ? 'white' : '' ?>">
                    <div class="forum_topic_item_left">
                        <?php echo anchor('forum/profile/'.$user->username,'<img alt="'.$user->username.'" src="'.base_url($avatar).'" border="0" width="100" height="100">')?>
                        <p class="image_title orange"><?php echo anchor('forum/profile/'.$user->username,'<span>'.$user->username.'</span>', 'class="orange"')?></p>
						<p><?php echo anchor('compdetail/'.M_encrypt::encode($user->company_id),'My Company Profile')?></p>
                        <p>Overall Ranking: <span class="author-mvp">MVP:<?php echo $user->point?></span> <span class="author-rank">Rank:<?php echo $user->rank?></span></p>
                        
                        <p><span <?php echo $user->status?'class="green"':''?>>Online</span> - <span <?php echo $user->status?'':'class="red"'?>>Offline</span></p>
                    </div>
                    <div class="forum_topic_item_main">
                        <div class="forum_topic_item_main_head">
                            <p class="post_number"><b>Post <span class="green"><?php echo ($pagination['cur']!=1?(($pagination['cur']-1)*$this->m_forum->per_page_records)-1:0)+$counter?></span> / <span class="green"><?php echo intval($topic->replies)?></span></b></p>
                            <h2><?php echo $comment->subject?></h2>
                            <div class="like">
                                <span class="like_mask comment" id="<?php echo $comment->id?>"></span>
                                <span class="like_arrow"><?php echo $comment->like?></span>
                            </div>
							<div class="dislike">
								<span class="dislike_mask comment" id="<?php echo $comment->id?>"></span>
								<span class="dislike_arrow"><?php echo $comment->dislike?></span>
							</div>
                        </div>
                        <p><i><?php echo M_misc::bbcode2html($comment->content)?></i></p>
                        <p>TradeOffice.com Forum<br><b>by <a href="<?php echo base_url('forum/profile/'.$user->username)?>" class="orange"><?php echo $user->username?></a> on <?php echo $this->m_misc->formatDate('d M Y H:i',$comment->cdate)?></b></p>
                        <div class="reply_quote"><?php echo anchor('forum/post/comment/'.$topic->id.'/'.$comment->id,'Reply', 'class="green"')?> / <?php echo anchor('forum/post/comment/'.$topic->id.'/'.$comment->id.'?quote=1','Quote', 'class="green"')?></div>
                    </div>
                </div>
            <?php $counter++; ?>
        <?php endforeach; ?>
    <?php endif; ?>
    </div>
	<ul class="my_contacts_pagination" style="margin:15px 0; overflow:visible;">
		<li><?php echo '<a href="'.$pagination['url'].'/'.($pagination['page']).'">Last Page</a>' ?></li>
		<li class="next <?=$pagination['cur'] >= $pagination['page'] ?'disable':''?>"><?= $pagination['cur'] >= $pagination['page'] ? '<a href="#"></a>' : '<a href="'.$pagination['url'].'/'.($pagination['cur']+1).'"></a>' ?></li>
		<li class="prev <?=$pagination['cur'] <=1?'disable':''?>"><?= $pagination['cur'] <= 1 ? '<a href="#"></a>' : '<a href="'.$pagination['url'].'/'.($pagination['cur']-1).'"></a>' ?></li>
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
<script>
$(document).ready(function(){
	$('select.pagination').selectbox({
		onChange: function(val,inst){
			window.location = '<?=$pagination['url']?>/'+val;
		}
	})
});
</script>
	<?php $this->load->view('modules/forum/topic_quick_reply'); ?>
<?php else: ?>
<div>Please Select the topic</div>
<?php endif; ?>