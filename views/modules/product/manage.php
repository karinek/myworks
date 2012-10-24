<div id="office_tabs_block">
            	<?php $this->load->view('modules/company/tabs_nav',array('selectedPage'=>'Selling')); ?>
<div id="office_tabs_content">
    <div class="my_office_buyer_page" >
            <div class="left" onclick='a()'>
                    <h2>Selling</h2>
                <ul>
                    <li><a href="<?php echo base_url(); ?>product">Add New Product</a></li>
                    <li class="active"><a href="<?php echo base_url(); ?>product/manage">Manage Products</a></li>
                </ul>
            </div>
            <div class="middle">
            	<div class="my_watchlist" style="padding:0;">
                            <ul class="my_contacts_pagination">
                                <li><?php echo '<a href="?page='.($pagination['page']).'&order='.set_value('order',$default['order']).'">Last Page</a>' ?></li>
                                <li class="next <?=$pagination['cur'] >= $pagination['page'] ?'disable':''?>"><?= $pagination['cur'] >= $pagination['page'] ? '<a href="#"></a>' : '<a href="?page='.($pagination['cur']+1).'&order='.set_value('order',$default['order']).'"></a>' ?></li>
                                <li class="prev <?=$pagination['cur'] <=1?'disable':''?>"><?= $pagination['cur'] <= 1 ? '<a href="#"></a>' : '<a href="?page='.($pagination['cur']-1).'&order='.set_value('order',$default['order']).'"></a>' ?></li>
                                <li>Page <span><?=$pagination['cur']?></span> / <?=$pagination['page']?></li>
                            </ul>            	
            	<?php echo form_open_multipart('product/manage', 'id="form"'); ?>
                            <ul class="my_company_menu">
                                <li class="check"><input type="checkbox" name="select_all" /></li>
                                <li class="arrange_by select order" style="padding:0px;">
                                    <?php $order_types = array(''=>'Arrange By', 'asc'=>'Asscending', 'desc'=>'Descending') ?>
                                    <?php echo form_dropdown('order', $order_types, set_value('order',$default['order']), 'id="order"');?>
                                </li>
                                <li class="delete">
                                    <i class="delete"></i>Delete
                                    <input type="submit" name="delete" onclick="return confirm('Are You sure to delete selected products?');" value="" />
                                </li>
                            </ul>    
                            <div class="clear"></div>
                            <div class="my_watchlist_line_head">
                                <div class="product_head" style="width:180px;">Product</div>
                                <div class="description_head" style="width:340px;">Description:</div>
                                <div class="date_head">Date Added:</div>
                            </div>                            
                            <?php if(!empty($products)): ?>
                                <?php foreach($products as $product): ?>
                                    <div class="my_watchlist_line<?=($product['status']=='pending')?' trash':'';?>">
                                        <div class="checkbox_blocks"><input type="checkbox" name="products[]" value="<?php echo $product['product_id']; ?>"/></div>
                                        <div class="watchlist"></div>
                                        <div class="product_block" style="width:180px;"><p><?php echo $product['name']; ?></p></div>
                                        <div class="description_block" style="width:285px; margin:0;"></div>
                                        <div class="date_block" style="width:50px; margin-right: 5px; float:left;"><p><?php echo anchor('prodetail/'.M_encrypt::encode($product['product_id']),'More',array('style'=>'color:#00A651; ')) ?>|<?php echo anchor('product/edit/'.$product['product_id'],'Edit',array('style'=>'color:#00A651;')) ?></p></div>
                                        <?php $time = strtotime($product['upload_time']); ?>
                                        <div class="date_block" style="float:left;" ><p><?php echo date("d.m.Y",$time); ?></p></div>
                                    </div>

                                    <div class="my_watchlist_hide_line">
                                        <?php if($product['image_name']): ?>
                                            <img src="<?=base_url()?>images/product_thumbs/<?=$product['image_name'];?>" width="104" height="104" alt=""  style="border: 1px solid 
gray;"/>
                                        <?php else: ?>
                                            <img src="<?=base_url()?>images/no_photo_detail.gif" width="104" height="104" alt="" style="border: 1px solid 
gray;"/>
                                        <?php endif; ?>
                                        <div style="width:310px; float:left; padding:10px; margin-left: 65px;"><?php echo $product['short_description']; ?></div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>      
                            <div class="clear"></div>  
                            <ul class="my_contacts_pagination" style="margin-top: 20px;">
                                <li><?php echo '<a href="?page='.($pagination['page']).'&order='.set_value('order',$default['order']).'">Last Page</a>' ?></li>
                                <li class="next <?=$pagination['cur'] >= $pagination['page'] ?'disable':''?>"><?= $pagination['cur'] >= $pagination['page'] ? '<a href="#"></a>' : '<a href="?page='.($pagination['cur']+1).'&order='.set_value('order',$default['order']).'"></a>' ?></li>
                                <li class="prev <?=$pagination['cur'] <=1?'disable':''?>"><?= $pagination['cur'] <= 1 ? '<a href="#"></a>' : '<a href="?page='.($pagination['cur']-1).'&order='.set_value('order',$default['order']).'"></a>' ?></li>
                                <li>Page <span><?=$pagination['cur']?></span> / <?=$pagination['page']?></li>
                            </ul>                             
                <?php echo form_close(); ?>                               
              </div>                                      
            </div>
     </div>
</div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#order').selectbox();
        $('.checkbox_blocks input').checkBox();
        $('.my_company_menu .check input').checkBox({
            'change': function(e, ui){
                if(ui.checked){
                    $('.checkbox_blocks input').each(function(){
                        $(this).checkBox('changeCheckStatus', true);
                    })
                } else
                {
                    $('.checkbox_blocks input').each(function(){
                        $(this).checkBox('changeCheckStatus', false);
                    })
                }
            }
        });
        $('.product_block, .description_block').click(function(){
            $(this).parent('.my_watchlist_line').next('.my_watchlist_hide_line').slideToggle(300);
        });
        $('#order').change(function(){
          $('#form').submit();
       });
    });
</script>   