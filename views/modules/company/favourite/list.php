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
                                <li class="active"><?php echo anchor('company/favourites/','My Favourites'); ?></li>
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
                        <?php echo form_open_multipart('company/favourites', 'id="form"'); ?>   
                        <div class="middle">
                             <div class="my_company">
                                 <ul class="my_contacts_pagination">
                                        <li><?php echo '<a href="?page='.($pagination['page']).'&order='.set_value('order',$default['order']).'&view='.set_value('view',$default['view']).'">Last Page</a>' ?></li>
                                        <li class="next <?=$pagination['cur'] >= $pagination['page'] ?'disable':''?>"><?= $pagination['cur'] >= $pagination['page'] ? '<a href="#"></a>' : '<a href="?page='.($pagination['cur']+1).'&order='.set_value('order',$default['order']).'&view='.set_value('view',$default['view']).'"></a>' ?></li>
                                        <li class="prev <?=$pagination['cur'] <=1?'disable':''?>"><?= $pagination['cur'] <= 1 ? '<a href="#"></a>' : '<a href="?page='.($pagination['cur']-1).'&order='.set_value('order',$default['order']).'&view='.set_value('view',$default['view']).'"></a>' ?></li>
                                        <li>Page <span><?=$pagination['cur']?></span> / <?=$pagination['page']?></li>
                                </ul>
                                
                                <ul class="my_company_menu my_favorites">
                                        <li class="arrange_by select order" style="padding:0px;">
                                            <?php $order_types = array(''=>'Arrange By', 'asc'=>'Asscending', 'desc'=>'Descending') ?>
                                            <?php echo form_dropdown('order', $order_types, set_value('order',$default['order']), 'id="order"');?>
                                        </li>
<!--                                    <li class="arrange_by1"><span>Arrange By</span><i class="arrow"></i></li>-->
                                	<li class="check">
                                    	<i class="delete"></i>Delete
                                        <input type="submit" name="delete" value="" />
                                    </li>
                                    <li class="arrange_by"><span>View:</span><i class="table" id="grid_view"></i><i class="list" id="list_view"></i></li>
                                </ul>
                                <input type="hidden" value="<?=set_value('view',$default['view'])?>" name="view"/>
                                <input type="hidden" name="page" value="<?=set_value('page',$default['page'])?>" />
                               
                                 <?php if(isset($favourites) && count($favourites) && is_array($favourites)){ ?>
                                        <div class="my_company_my_favorites">
                                        <?php
                                        foreach($favourites as $favourite){ ?>
                                            <div class="<?=set_value('view',$default['view']) == 'list' ? 'company_network_block_item_list' : 'company_network_block_item'?>">
                                                <div class="my_company_my_favorites_image" style="width:230px;height:90px;text-align:center;border: 1px solid #CCC;">
                                                    <a href="<?php echo base_url(); ?>compdetail/<?php echo M_encrypt::encode($favourite['id']); ?>">
                                                        <img alt="<?php echo $favourite['name']; ?>" src="<?=base_url()?>images/<?=isset($favourite['file']) && !empty($favourite['file'])? 'company_images/'.$favourite['file'] : 'company.png'; ?>" style="width:230px;height:90px;" />
                                                    </a>
                                                </div>
                                                <p class="my_company_my_favorites_detail">
                                                    <p class="green"><a href="<?php echo base_url(); ?>compdetail/<?php echo M_encrypt::encode($favourite['id']); ?>"><?php echo $favourite['name']; ?> </a></p>
                                                    <p><b>Country:</b>
                                                    <?php foreach ($country_options as $key=>$val):
                                                            if($favourite['country'] == $key):
                                                                    echo $val;
                                                                    break;
                                                            endif;
                                                    endforeach; ?><br />    
                                                    <b>Business Type:</b> <?php echo $favourite['business_type']; ?><br />
                                                    <b>Address:</b> <?php echo $favourite['address'].",\t".$favourite['city']."\t"; ?></p>
                                                    <a class="red" href="<?php echo base_url(); ?>compdetail/<?php echo M_encrypt::encode($favourite['id']); ?>">View</a>
                                                    <input type="checkbox" name="favourites[]" value="<?php echo $favourite['id']; ?>" />
                                                </p>
                                                <div class="clear"></div>
                                            </div>
                                        <?php }
                                        ?>
                                        </div>
                                 <?php } ?>
                                 <ul class="my_contacts_pagination position_bottom">
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
            </div>

<div id="contentBox" style="height:500px; margin-top: -315px; "></div>
<!-- End Content -->

<script type="text/javascript">
    $('.my_company_my_favorites input').checkBox();
    $('#order').selectbox();
    $(document).ready(function(){
		$('#grid_view').click(function(){
			$('input[name="view"]').val('grid');
			$('.my_company_my_favorites .company_network_block_item_list').addClass('company_network_block_item').removeClass('company_network_block_item_list');
		});
		$('#list_view').click(function(){
			$('input[name="view"]').val('list');
			$('.my_company_my_favorites .company_network_block_item').addClass('company_network_block_item_list').removeClass('company_network_block_item');
		});
       $('#order').change(function(){
          $('#form').submit();
       });
    });
</script>    