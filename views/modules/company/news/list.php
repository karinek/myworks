<!-- CONTENT -->
    <div id="content">
    	<div class="wrapper">
            <!-- PRODUCT TABS -->
            <div id="office_tabs_block">
			<?php $this->load->view('modules/company/tabs_nav',array('selectedPage'=>'My Company')); ?>
                <div id="office_tabs_content">
                	<div class="my_office_buyer_page">
                    	<div class="left">
                      	<h2>My Company</h2>
                            <ul>
                            	<li><?php echo anchor('company/','My company'); ?></li>
                                <li><?php echo anchor('company/contacts/','My Contacts'); ?></li>
                                <li><?php echo anchor('company/favourites/','My Favourites'); ?></li>
                                <li><?php echo anchor('company/networks/','My Networks'); ?></li>
                                <li><?php echo anchor('company/staff/','My Staff'); ?></li>
                                <li class="active"><?php echo anchor('news/','My News'); ?></li>
                            </ul>
                            <div class="support" style="display:none;">
                            	<p class="head_text">Support</p>
                                <p>Jaqueline is <span>Online</span></p>
                            </div>
<!--                            <form action="">
                            	<textarea cols="" rows="" onfocus="if(this.value=='eg... Ask me a question?') this.value='';" onblur="if(!this.value) this.value='eg... Ask me a question?';" >eg... Ask me a question?</textarea>
                                <input type="submit" value="Ask" />
                            </form>-->
                        </div>
                        <?php echo form_open_multipart('news'); ?>   
                        <div class="middle">
                            
                            <div class="my_company">
                                <ul class="my_contacts_pagination">
                                    <li><?php echo '<a href="?page='.($pagination['page']).'&order='.set_value('order').'&view='.set_value('view').'">Last Page</a>' ?></li>
                                    <li class="next <?=$pagination['cur'] >= $pagination['page'] ?'disable':''?>"><?= $pagination['cur'] >= $pagination['page'] ? '<a href="#"></a>' : '<a href="?page='.($pagination['cur']+1).'"></a>' ?></li>
                                    <li class="prev <?=$pagination['cur'] <=1?'disable':''?>"><?= $pagination['cur'] <= 1 ? '<a href="#"></a>' : '<a href="?page='.($pagination['cur']-1).'"></a>' ?></li>
                                    <li>Page <span><?=$pagination['cur']?></span> / <?=$pagination['page']?></li>
                                </ul>
                                
                                <ul class="my_company_menu my_favorites">
                                    <li class="arrange_by1"><span><a class="green" href="<?=base_url('news/add')?>" rel="shadowbox;height=440;width=360;">Add</a></span></li>
                                	<li class="check">
                                    	<i class="delete"></i>Delete
                                        <input type="submit" value="" name="delete" />
                                    </li>
                                </ul>
                                <div class="my_company_my_news">
                                    <div class="my_company_my_news_head">
                                        <div class="title_head">Title:</div>
                                        <div class="content_head">Content:</div>
                                        <div class="date_head">Date:</div>
                                        <div class="approved_head">Approved</div>
                                        <div class="action_head"></div>
                                    </div>
                                    <?php
                                    if(isset($news) && count($news) && is_array($news)):
                                            for($i=0; $i<count($news); $i++){
                                                    $_news = $news[$i];
                                    ?>
                                    <div class="my_company_my_news_line">
                                        <div class="checkbox_blocks"><input type="checkbox" name="news[]" value="<?=$_news->id?>" /></div>
                                        <div class="title_block"><p><a class="green" href="<?=base_url('news/view/'.$_news->id)?>" rel="shadowbox;height=350;width=350;"><?=M_misc::limitStr($_news->title,20,true)?></a></p></div>
                                        <div class="content_block"><p><?=M_misc::limitStr($_news->content,40,true)?></p></div>
                                        <div class="date_block"><p><?=M_misc::_formatDate('d M Y H:i',$_news->cdate)?></p></div>
                                        <div class="approved_block"><p><?=$_news->is_approve==1?'Approved':'<a style="color:#00A651;" href="'.base_url().'news/approve/'.$_news->id.'">Pending</a>'?></p></div>
                                    </div>
                                            <?php } ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <ul class="my_contacts_pagination position_bottom">
								<li><?php echo '<a href="?page='.($pagination['page']).'&order='.set_value('order').'&view='.set_value('view').'">Last Page</a>' ?></li>
								<li class="next <?=$pagination['cur'] >= $pagination['page'] ?'disable':''?>"><?= $pagination['cur'] >= $pagination['page'] ? '<a href="#"></a>' : '<a href="?page='.($pagination['cur']+1).'"></a>' ?></li>
								<li class="prev <?=$pagination['cur'] <=1?'disable':''?>"><?= $pagination['cur'] <= 1 ? '<a href="#"></a>' : '<a href="?page='.($pagination['cur']-1).'"></a>' ?></li>
								<li>Page <span><?=$pagination['cur']?></span> / <?=$pagination['page']?></li>
                            </ul>
                        </div>
                        <?php echo form_close(); ?>    
                </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>

<div id="contentBox" style="height:435px; margin-top: -315px; "></div>
<!-- End Content -->

<script type="text/javascript">
	Shadowbox.init({'modal':true});
    $('.my_company_my_news_line input').checkBox();
    $(document).ready(function() {
        $('.editIcon').click(function(){
            $('#popup').show();
            $.get($(this).attr('data-href'), function(data) {
                $('#contentBox').html(data);
                $('#contentBox').fadeIn('fast');
            });
        });

        $('.addIcon').click(function(){
            $('#popup').show();
            $('#contentBox').show();
            $.get($(this).attr('data-href'), function(data) {
                $('#contentBox').html(data);
            });
        });
    });    
</script>    