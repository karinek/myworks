<script type="text/javascript">
    $(function(){
        $('#advanced_search_block input').checkBox();
        $('.contact_line .star_block input').checkBox({
            'change': function(e, ui){
                var checked = 0;
                if(ui.checked){checked = 1;}
                var $this = $(this);
                $.post("<?= base_url() ?>message/favorite/", {id:$(this).attr('id'),checked:checked}, function(data){
                    $this.parents(".contact_line").remove();
                    location.reload();

                });
            },
            'disabledchange': function(e, ui){ $(this).attr('disabled') === ui.disabled }
        });})
</script>

<script type="text/javascript">
    $(function () {
        $("#country_id1").selectbox();
        $("#country_id2").selectbox();
        $("#country_id3").selectbox();
        $("#country_id4").selectbox();
        $('.contact_line input').checkBox();
        $('.check_box').click(function(){
            if($(this).hasClass('selected')){
                $('.contact_line .checkbox_blocks input[type=checkbox]').checkBox('changeCheckStatus', false);
                $(this).removeClass('selected');
                $(this).addClass('notselected');
            }else
            {
                $(this).addClass('selected');
                $(this).removeClass('notselected');
                $('.contact_line .checkbox_blocks input[type=checkbox]').checkBox('changeCheckStatus', true);
            } });
                
                
        $('#delete').click(function(){
            var ids = new Array();
            var isdelete = $('#is_delete').val();
            $('.contact_line .checkbox_blocks input[type=checkbox]:checked').each(function(){
                ids.push($(this).attr('id'));
            
                $(this).parents(".contact_line").remove();
            })
            $.post("<?= base_url() ?>message/delete/", {'ids[]':ids,isdelete:isdelete}, function(data){
             location.reload();
            }); 
        })
                
    });
</script>
<div id="content">
    <div class="wrapper">

        <!-- PRODUCT TABS -->
        <div id="office_tabs_block">
			<?php $this->load->view('modules/company/tabs_nav',array('selectedPage'=>'My Messages')); ?>
            <div id="office_tabs_content">
                <div class="my_office_page contacts">

                    <!-- CONTACTS HEADER BLOCK -->
                    <div class="contacts_header">

     <?php $this->load->view('modules/company/message/pagination.php'); ?> 

                        <div class="contacts_head">
                            <h2>My Messages</h2>
                        </div>

                     
                    </div>
                   

                    <div class="contacts_block">

                        <div class="contacts_block_left">
                                  <ul>       
                                <li><a href="<?= base_url() ?>message/inbox/">Inbox ( <span><?= $getInboxCount; ?></span> )</a></li>
                                <li><a href="<?= base_url() ?>message/outbox/">Sent Mail( <span><?= $getOutboxCount; ?></span> )</a></li>
                                <li><a href="<?= base_url() ?>message/starred/">Starred( <span><?= $getStaredCount; ?></span> )</a></li>
                                <li><a href="<?= base_url() ?>message/trash/">Trash( <span><?=$getTrashCount ; ?></span> )</a></li>
                            </ul>


                        </div>

                        <div class="contacts_block_main">

                        <ul class="contacts_menu" style="float:right;">
     <li style="border:none">
  <form action="<?= base_url() ?>message/search/" class="contacts_search_form" method="post">
                            <input type="text" name="keyword" class="text" />
                            <div class="search">
                                <input type="submit" value="Search"/>
                            </div>
                        </form>
</li></ul>
                             <ul class="contacts_menu">
                                    <li class="check" style="border-left:1px solid #bbb;"><a href="#"><i class="check_box"></i> </a></li>
                                     <li class="delete"><a href="#" id="delete"><i class="delete_img"></i><span>Delete</span></a></li>
                                </ul>


                            <div class="contacts_block_main_head">
                      
                            </div>
                            <!-- add class gray -->
                            <input type="hidden" name="is_delete" id="is_delete" value="star"/>
                            <? foreach ($messageInfo as $message) { 
                                  if($message['userid'] == $user_id)
                                {
                                      $from = 'From:';
                                    $action = 'info';
                                }  else {
                                    $from = 'To:';
                                    $action = 'outinfo';
                                }
                                ?> 
                                <div class="contact_line" style="cursor: pointer">
                                    <div class="checkbox_blocks"><input type="checkbox" id="<?= $message['id'] ?>"/></div>
                                    <div class="star_block"><input type="checkbox" id="<?= $message['id'] ?>" <? if ($message['favorite'] == 1) { ?>checked="checked"<? } ?>/></div>
                                    <div class="star_block"></div>
                                    <div class="from_block"><p><?=$from?><a href="<?= base_url() ?>message/<?=$action?>/<?= $message['id']; ?>"><?= $message['from_company'] ?></a></p></div>
                                    <div class="subject_block"><p><a href="<?= base_url() ?>message/info/<?= $message['id']; ?>"><?= $message['subject'] ?></a></p></div>
                                    <div class="date_block"><p><a href="<?= base_url() ?>message/info/<?= $message['id']; ?>"><?= date('d.m.Y', strtotime($message['date'])) ?></a></p></div>
                                </div>

                            <? } ?>
  <ul class="contacts_menu" style="margin-top:20px;">
                                    <li class="check" style="border-left:1px solid #bbb;"><a href="#"><i class="check_box"></i></a></li>
                                    <li class="delete"><a href="#"><i class="delete_img"></i><span>Delete</span></a></li>
                                </ul>

                        </div>
                    </div>

                    <!-- End Contacts Block -->



                </div>
            </div>
        </div>
        <!-- End Product Tabs -->


    </div>
</div>