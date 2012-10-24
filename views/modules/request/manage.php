<div id="office_tabs_block">
	<?php $this->load->view('modules/company/tabs_nav',array('selectedPage'=>'Buying')); ?>
    <div id="office_tabs_content">
            <div class="my_office_buyer_page">
            <div class="left">
                    <h2>Post a Buying Request</h2>
                <ul style="width:149px;">
                    <li><a href="<?=base_url();?>request/buy">Post Buying Request</a></li>
                    <li class="active"><a href="<?=base_url();?>request/manage">Manage Buying Request</a></li>
<!--                    <li><a href="#">Manage Requests<br /> for Quotations</a></li>-->
<!--                    <li><a href="#">Manage Sample<br /> Request</a></li>-->
                </ul>
            </div>
            <div class="middle">
                <div class="my_company">
                    <?php echo form_open_multipart('request/manage', 'id="form"'); ?>  
                    <ul class="my_contacts_pagination">
						<li><?php echo '<a href="?page='.($pagination['page']).'">Last Page</a>' ?></li>
						<li class="next <?=$pagination['cur'] >= $pagination['page'] ?'disable':''?>"><?= $pagination['cur'] >= $pagination['page'] ? '<a href="#"></a>' : '<a href="?page='.($pagination['cur']+1).'"></a>' ?></li>
						<li class="prev <?=$pagination['cur'] <=1?'disable':''?>"><?= $pagination['cur'] <= 1 ? '<a href="#"></a>' : '<a href="?page='.($pagination['cur']-1).'"></a>' ?></li>
						<li>Page <span><?=$pagination['cur']?></span> / <?=$pagination['page']?></li>
                    </ul>

                    <div class="my_company_buying_request">
                            <ul class="my_company_menu my_favorites">
                                <li class="arrange_by select order" style="padding:0px;">
                                    <?php $order_types = array(''=>'Arrange By', 'asc'=>'Asscending', 'desc'=>'Descending') ?>
                                    <?php echo form_dropdown('order', $order_types, set_value('order',$default['order']), 'id="order"');?>
                                </li>
                                <li class="check">
                                    <i class="delete"></i>Delete
                                    <input type="submit" name="delete" value="" />
                                </li>
                            </ul>

                            <div class="buying_request_head clear">
                                <div class="from_head">Product Name:</div>
                                <div class="subject_head">Product Specification:</div>
                                <div class="date_head">Expired Time:</div>
                            </div>

                            <?php if(!empty($buyingRequests)): ?>
                                <?php foreach($buyingRequests as $buyingRequest): ?>
                                    <div class="buying_request_line">
                                        <div><input type="checkbox" name="buyingRequests[]" value="<?php echo $buyingRequest->id; ?>" /></div>
                                        <div class="from_block"><p><a href="<?=base_url();?>buydetail/<?php echo M_encrypt::encode($buyingRequest->id) ?>"><?php echo $buyingRequest->product_name; ?></a></p></div>
                                        <div class="subject_block"><p><?php echo M_misc::limitStr($buyingRequest->product_specification,57,true); ?></p></div>
                                        <?php $expired_time = strtotime($buyingRequest->expired_time); ?>
                                        <div class="date_block"><p><?php echo date("d.m.Y", $expired_time); ?></p></div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                    </div>
                    <?php echo form_close(); ?>  

                </div>
                <ul class="my_contacts_pagination">
					<li><?php echo '<a href="?page='.($pagination['page']).'">Last Page</a>' ?></li>
					<li class="next <?=$pagination['cur'] >= $pagination['page'] ?'disable':''?>"><?= $pagination['cur'] >= $pagination['page'] ? '<a href="#"></a>' : '<a href="?page='.($pagination['cur']+1).'"></a>' ?></li>
					<li class="prev <?=$pagination['cur'] <=1?'disable':''?>"><?= $pagination['cur'] <= 1 ? '<a href="#"></a>' : '<a href="?page='.($pagination['cur']-1).'"></a>' ?></li>
					<li>Page <span><?=$pagination['cur']?></span> / <?=$pagination['page']?></li>
				</ul>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.my_company input').checkBox();
    $('#order').selectbox();
    $(document).ready(function(){
       $('#order').change(function(){
          $('#form').submit();
       });
    });
</script> 
