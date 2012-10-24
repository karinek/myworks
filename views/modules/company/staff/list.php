<style type="text/css">
.staff{
	border: 4px solid #CCCCCC;
	float: left;
	height: 200px;
	overflow: hidden;
	padding: 5px;
	width: 150px;
	margin:5px;
}
.staff .staffImage{ text-align:center; }
</style>
<!-- PRODUCT TABS -->
<div id="office_tabs_block">
<?php $this->load->view('modules/company/tabs_nav',array('selectedPage'=>'My Company')); ?>
<div id="office_tabs_content">
    <div class="my_office_buyer_page">
    <div class="left">
    <h2>My Company</h2>
		<?php $this->load->view('modules/company/company_left_menu'); ?>

        <div style="margin-top:-30px;" class="my_company_my_staf_head">
        <?php renderStaff($defaultStaff,false); ?>
        </div>
        <div class="clear" style="display:none;">
            <hr />
            <div class="support">
                <p class="head_text">Support</p>
                <p>Jaqueline is <span>Online</span></p>
            </div>
        </div>
<!--                            <form action="">
            <textarea cols="" rows="" onfocus="if(this.value=='eg... Ask me a question?') this.value='';" onblur="if(!this.value) this.value='eg... Ask me a question?';" >eg... Ask me a question?</textarea>
            <input type="submit" value="Ask" />
        </form>-->
    </div>
    <?php echo form_open_multipart('company/staff/', 'id="form"'); ?>   
    <div class="middle">
         <div class="my_company">
             <ul class="my_contacts_pagination">
				<li><?php echo '<a href="?page='.($pagination['page']).'&order='.set_value('order').'&view='.set_value('view').'">Last Page</a>' ?></li>
				<li class="next <?=$pagination['cur'] >= $pagination['page'] ?'disable':''?>"><?= $pagination['cur'] >= $pagination['page'] ? '<a href="#"></a>' : '<a href="?page='.($pagination['cur']+1).'&order='.set_value('order').'&view='.set_value('view').'"></a>' ?></li>
				<li class="prev <?=$pagination['cur'] <=1?'disable':''?>"><?= $pagination['cur'] <= 1 ? '<a href="#"></a>' : '<a href="?page='.($pagination['cur']-1).'&order='.set_value('order').'&view='.set_value('view').'"></a>' ?></li>
				<li>Page <span><?=$pagination['cur']?></span> / <?=$pagination['page']?></li>
            </ul>

            <ul class="my_company_menu">
                <li class="check" style="display:none;"><input type="checkbox" name="select_all" /></li>
                <li class="arrange_by select order" style="padding:0px;">
                    <?php $order_types = array(''=>'Arrange By', 'asc'=>'Asscending', 'desc'=>'Descending') ?>
                    <?php echo form_dropdown('order', $order_types, set_value('order',$default['order']), 'id="order"');?>
                </li>
                <li class="add_staf"><span><a href="<?=base_url()?>company/staff/add" rel="shadowbox;height=450;width=380;">Add New Staff</a></span></li>
            </ul>

            <ul class="my_company_menu right_menu">
                <li class="check">
                    <i class="delete"></i>Delete
                    <input type="submit" value="" name="delete"/>
                </li>
                <li class="arrange_by"><span>View:</span><i class="table" id="grid_view"></i><i class="list" id="list_view"></i></li>
            </ul>
<input type="hidden" value="<?=set_value('view',$default['view'])?>" name="view"/>
<input type="hidden" name="page" value="<?=set_value('page',$default['page'])?>" />
            </div>
             <?php if(isset($staffs) && count($staffs) && is_array($staffs)){ ?>
                    <div class="my_company_my_staf">
                    <?php
                    foreach($staffs as $staff){
                        renderStaff((array)$staff,1,$default['view']);
                    }
                    ?>
                    </div>
             <?php } ?>
             <ul class="my_contacts_pagination position_bottom">
				<li><?php echo '<a href="?page='.($pagination['page']).'&order='.set_value('order').'&view='.set_value('view').'">Last Page</a>' ?></li>
				<li class="next <?=$pagination['cur'] >= $pagination['page'] ?'disable':''?>"><?= $pagination['cur'] >= $pagination['page'] ? '<a href="#"></a>' : '<a href="?page='.($pagination['cur']+1).'&order='.set_value('order').'&view='.set_value('view').'"></a>' ?></li>
				<li class="prev <?=$pagination['cur'] <=1?'disable':''?>"><?= $pagination['cur'] <= 1 ? '<a href="#"></a>' : '<a href="?page='.($pagination['cur']-1).'&order='.set_value('order').'&view='.set_value('view').'"></a>' ?></li>
				<li>Page <span><?=$pagination['cur']?></span> / <?=$pagination['page']?></li>
             </ul>
         </div>
    </div>
    <?php echo form_close(); ?>
<?php
function renderStaff($data, $editable = 1, $view=''){
?>
<div class="<?=set_value('view',$view) == 'list' ? 'my_company_my_staf_item_list' : 'my_company_my_staf_item'?>">
    <div class="my_company_my_staf_image">
		<?php if($editable): ?><a id="edit-popup" href="<?=base_url().'upload?module=staff&module_id='.$data['id']?>" rel="shadowbox;height=550;width=715;"><?php endif;?>
    	<img title="<?=$data['firstname']?> <?=$data['lastname']?>" src="<?=base_url()?>images/user_images/<?=isset($data['image']) && !empty($data['image'])? $data['image'] : 'no-photo.jpg'?>" width="100" height="100" class="<?=$editable?'staffImage':''?>" id="staffimage-<?=$data['id']?>" alt="">
		<?php if($editable): ?></a><?php endif;?>
    </div>
    <p class="my_company_my_staf_detail">
        <?php if($data['is_default']): ?>
        <span style="color:green;font-weight:bold;">Default</span>
        <?php else : ?>
        <a class="defaultIcon" alt="Set As Default Contact" href="<?=base_url()?>company/staff/setDefault/<?=$data['id']?>">Default</a>
        <?php endif; ?>
        <?=$editable?' | <a alt="Edit Contact Detail" href="'.base_url().'company/staff/edit/'.$data['id'].'" rel="shadowbox;height=450;width=380;">Edit</a>':''?>
		<br />
        <span class="green"><?=$data['firstname']?> <?=$data['lastname']?></span><br>
        <b><?=$data['position']?></b><br />
        <b>Ph:</b> <?=$data['phone']?><br />
        <b>Mob:</b> <?=$data['mobile']?><br />
        <b>Email:</b> <?=$data['email']?>
    </p>
    <?=$editable?' <input type="checkbox" name="employees[]" value="'.$data['id'].'" />':''?>
</div>                          
<?php } ?>

                <div class="clear"></div>
                    </div>
                </div>
            <!-- End Product Tabs -->
<div id="contentBox" style="height:597px; margin-top: -315px; "></div>
<!-- End Content -->
<script type="text/javascript">
	
    $('.my_company_my_staf_item input, .my_company_my_staf_item_list input').checkBox();
    $('.my_company_menu input').checkBox();
    $('#order').selectbox();
    $(document).ready(function(){
		Shadowbox.init({'modal':true});
		$('.my_company_my_staf_item img.staffImage').each(function(){
			var $this = $(this);
			var staff_id = $this.attr('id').split('-');
			
			$this.hover(function(e){
					$this.css({
						'box-shadow': '1px 1px 5px #666'
					})
				},function(e){
					$this.css({
						'box-shadow': 'none'
					})
				}
			);
		});
		$('#grid_view').click(function(){
			$('input[name="view"]').val('grid');
			$('.my_company_my_staf .my_company_my_staf_item_list').addClass('my_company_my_staf_item').removeClass('my_company_my_staf_item_list');
		});
		$('#list_view').click(function(){
			$('input[name="view"]').val('list');
			$('.my_company_my_staf .my_company_my_staf_item').addClass('my_company_my_staf_item_list').removeClass('my_company_my_staf_item');
		});
		$('#order').change(function(){
			$('#form').submit();
		});
    });
</script>    