<h3 class="page_links"><a href="<?=base_url()?>">Home</a> &gt; <a href="<?=base_url('forum')?>">Forum </a>
<?php if(!empty($breadcrumbs)): ?>
	<?php foreach($breadcrumbs as $breadcrumb): ?>
	&nbsp;&gt;&nbsp;<a href="<?=$breadcrumb->link?>"><?=$breadcrumb->title?></a>
	<?php endforeach; ?>
<?php endif; ?>
( <span class="green"><?=M_misc::formatNumber($totalTopics->topics)?></span> )</h3>
<div id="office_tabs_block">
	<div id="office_tabs_content">
		<div class="my_office_page forum"> 
			
			<!-- FORUM HEAD BLOCK -->
			<div class="forum_head_block">
                            
                <div class="forum_head_block_left">
                    <h3>Hottest Topics Today</h3>
                    <div class="forum_head_left_box">
                        <?php if(!empty($lastTopic)): ?>
                            <?php
                                $avatar = 'images/user_images/';
                                if (!empty($lastTopicAuthor->image))
                                    $avatar .= $lastTopicAuthor->image;
                                else
                                    $avatar .= 'no_photo.jpg';
                            ?>
                            <a href="<?=base_url('forum/profile/'.$lastTopicAuthor->username)?>"><img src="<?=base_url($avatar); ?>" width="124" height="124" alt=""></a>
                            <div class="big_box_text">
                                <p class="green"><b><u><a href="<?=base_url('forum/topic/'.$lastTopic->id)?>"><?=$lastTopic->subject?></a></u></b></p>
                                <p><b>By <?=anchor('forum/profile/'.$lastTopicAuthor->username,'<span class="orange">'.$lastTopicAuthor->username.'</span>')?> on <?=$this->m_misc->formatDate('d M Y H:i',$lastTopic->cdate)?></b></p>
                                <p style="margin-bottom:0;"><i><?=M_misc::limitStr($lastTopic->content,140,true)?></i></p>
                            </div>
                        <?php else: ?>
                            <div class="big_box_text">
                            <p style="margin-bottom:0;">There is no topics.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="forum_head_block_middle">
                    <h3>Popular Forums</h3>
                    <div class="forum_head_box big_box">
                        <?php
                            $group_n = 0;
                            foreach ($groups as $group):
                                $group_n++;
                                $categories = $this->m_forum->get('category',array('group_id'=>$group->id));
                        ?>
                                <ul>
                                    <li class="head_li"><b><a href="<?=base_url(); ?>forum/group/<?php echo $group->name ?>"><?php echo M_misc::limitStr($group->name,20,true) ?></a></b></li>
                                <?php
                                    $cat_n = 0;
                                    foreach ($categories as $cat):
                                        $cat_n++;
                                ?>
                                    <li><a href="<?=base_url(); ?>forum/category/<?php echo $cat->id ?>"><?php echo M_misc::limitStr($cat->name,20,true) ?></a></li>
                                <?php
                                        if ($cat_n == 4) break;
                                    endforeach;
                                ?>
                                    <li><a href="<?=base_url(); ?>forum/group/<?php echo $group->name ?>">View all</a></li>
                                </ul>
                        <?php
                                if ($group_n == 3) break;
                            endforeach;
                        ?>
                    </div>
                </div>
                
                <div class="forum_head_block_right">
                    <a href="#"><img src="<?=base_url(); ?>images/forum_banner.jpg" width="180" height="150"></a>
                </div>
            
            </div>
			
			<!-- END FORUM HEAD BLOCK --> 
			
			<!-- FORUM BLOCK -->
			<div class="forum_block">
				<?php echo isset($content) ? $content : '';?>
			</div>
			<!-- END FORUM BLOCK --> 
			
		</div>
	</div>
</div>
