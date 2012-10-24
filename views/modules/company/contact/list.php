            <!-- PRODUCT TABS -->
            <div id="office_tabs_block">
			<?php $this->load->view('modules/company/tabs_nav',array('selectedPage'=>'My Company')); ?>
                <div id="office_tabs_content">
                	<div class="my_office_buyer_page">
                    	<div class="left">
                      	<h2>My Company</h2>
                            <ul>
                            	<li><?php echo anchor('company/','My company'); ?></li>
                                <li class="active"><?php echo anchor('company/contacts/','My Contacts'); ?></li>
                                <li><?php echo anchor('company/favourites/','My Favourites'); ?></li>
                                <li><?php echo anchor('company/networks/','My Networks'); ?></li>
                                <li><?php echo anchor('company/staff/','My Staff'); ?></li>
                                <li><?php echo anchor('news/','My News'); ?></li>
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
                        <?php echo form_open_multipart('company/contacts', 'id="form"'); ?>   
                        <div class="middle">
                             <div class="my_company">
                                 <ul class="my_contacts_pagination">
                                    <li><?php echo '<a href="?page='.($pagination['page']).'&order='.set_value('order',$default['order']).'&view='.set_value('view',$default['view']).'">Last Page</a>' ?></li>
                                    <li class="next <?=$pagination['cur'] >= $pagination['page'] ?'disable':''?>"><?= $pagination['cur'] >= $pagination['page'] ? '<a href="#"></a>' : '<a href="?page='.($pagination['cur']+1).'&order='.set_value('order',$default['order']).'&view='.set_value('view',$default['view']).'"></a>' ?></li>
                                    <li class="prev <?=$pagination['cur'] <=1?'disable':''?>"><?= $pagination['cur'] <= 1 ? '<a href="#"></a>' : '<a href="?page='.($pagination['cur']-1).'&order='.set_value('order',$default['order']).'&view='.set_value('view',$default['view']).'"></a>' ?></li>
                                    <li>Page <span><?=$pagination['cur']?></span> / <?=$pagination['page']?></li>
                                </ul>
                                
                                <ul class="my_company_menu">
                                    <li class="check"><input type="checkbox" name="select_all" /></li>
                                    <li class="arrange_by select order" style="padding:0px;">
                                        <?php $order_types = array(''=>'Arrange By', 'asc'=>'Asscending', 'desc'=>'Descending') ?>
                                        <?php echo form_dropdown('order', $order_types, set_value('order',$default['order']), 'id="order"');?>
                                    </li>
                                </ul>
                                
                                <ul class="my_company_menu right_menu">
                                    <li class="check">
                                    	<i class="delete"></i>Delete
                                        <input type="submit" value="" />
                                    </li>
                                    <li class="arrange_by"><span>View:</span><i class="table" id="grid_view"></i><i class="list" id="list_view"></i></li>
                                </ul>
                                 
                                 <input type="hidden" value="<?=set_value('view',$default['view'])?>" name="view"/>
                                 <input type="hidden" name="page" value="<?=set_value('page',$default['page'])?>" />
                                 
                                 <?php if(isset($company_contacts) && count($company_contacts) && is_array($company_contacts)){ ?>
                                        <div class="my_company_my_contacts"  style="margin-bottom:30px;">
                                        <?php
                                        foreach($company_contacts as $company_contact){ ?>
                                            <div class="<?=set_value('view',$default['view']) == 'list' ? 'my_company_my_contacts_list' : 'my_company_my_contacts_item'?>">
                                                <?php if(key_exists($company_contact['id'], $staff)){ ?>
                                                    <a href="#">
                                                        <?php $image = $staff[$company_contact['id']]['image']; ?>
                                                        <img src="<?=base_url()?>images/user_images/<?=isset($image) && !empty($image)? $image : 'no-photo.jpg'?>" width="100" height="100" alt="">
                                                    </a>
                                                    <p><?php echo $company_contact['name']; ?><br />
                                                        <a href="#"><span class="green"><?php echo $staff[$company_contact['id']]['name']; ?></span><br />
                                                            <?php echo $staff[$company_contact['id']]['position']; ?></a>
                                                    </p>
                                                <?php } else { ?>
                                                    <a href="#"><img src="<?=base_url()?>images/user_images/<?=isset($company_contact['userImage']) && !empty($company_contact['userImage'])? $company_contact['userImage'] : 'no-photo.jpg'?>" width="100" height="100" alt="" /></a>
                                                    <p><a href="#"><span class="green"><?php echo $company_contact['userFirstname']."\t".$company_contact['userLastname']; ?></span><br></a></p>
                                                <?php } ?>
                                                <input type="checkbox" name="contacts[]" value="<?php echo $company_contact['id']; ?>" />
                                            </div>
                                        <?php }
                                        ?>
                                        </div>
                                 <?php } ?>
                                 <ul class="my_contacts_pagination">
                                    <li><?php echo '<a href="?page='.($pagination['page']).'&order='.set_value('order',$default['order']).'&view='.set_value('view',$default['view']).'">Last Page</a>' ?></li>
                                    <li class="next <?=$pagination['cur'] >= $pagination['page'] ?'disable':''?>"><?= $pagination['cur'] >= $pagination['page'] ? '<a href="#"></a>' : '<a href="?page='.($pagination['cur']+1).'&order='.set_value('order',$default['order']).'&view='.set_value('view',$default['view']).'"></a>' ?></li>
                                    <li class="prev <?=$pagination['cur'] <=1?'disable':''?>"><?= $pagination['cur'] <= 1 ? '<a href="#"></a>' : '<a href="?page='.($pagination['cur']-1).'&order='.set_value('order',$default['order']).'&view='.set_value('view',$default['view']).'"></a>' ?></li>
                                    <li>Page <span><?=$pagination['cur']?></span> / <?=$pagination['page']?></li>
                                </ul>
                             </div>
                        </div>
                        <?php echo form_close(); ?>    
                </div>
                        <div class="clear"></div>
                    </div>
                </div>

<div id="contentBox" style="height:500px; margin-top: -315px; "></div>
<!-- End Content -->

<script type="text/javascript">
    $('.my_company_my_contacts_item input').checkBox();
    $('.my_company_menu input').checkBox();
    $('#order').selectbox();
    $(document).ready(function(){
		$('#grid_view').click(function(){
			$('input[name="view"]').val('grid');
			$('.my_company_my_contacts .my_company_my_contacts_list').addClass('my_company_my_contacts_item').removeClass('my_company_my_contacts_list');
		});
		$('#list_view').click(function(){
			$('input[name="view"]').val('list');
			$('.my_company_my_contacts .my_company_my_contacts_item').addClass('my_company_my_contacts_list').removeClass('my_company_my_contacts_item');
		});
       $('#order').change(function(){
          $('#form').submit();
       });
    });
    
</script>    