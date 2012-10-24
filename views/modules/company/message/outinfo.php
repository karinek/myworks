 
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
                  ids.push($('#hiiden_id').val());
               
          
            $.post("<?= base_url() ?>message/delete/", {'ids[]':ids,isdelete:isdelete}, function(data){
            window.location.href = "<?= base_url() ?>message/outbox/";
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
                                  
                                     <li class="delete"><a href="#" id="delete"><i class="delete_img"></i><span>Delete</span></a></li>
                                </ul>



                            <div style="margin-top: 45px;">
                                <p>To : <strong><?= $toCompany ?></strong></p>
                                <p>Subject:<strong><?= $messagInfo->subject ?></strong></p><br/>
                                <p><?= $messagInfo->text ?></p>

                                <ul>Attached:
                                    <? foreach ($attachedIngo as $attached) { ?>
                                        <li><a href="<?= base_url() ?>files/message/<?= $attached['file_path'] ?>"><?= $attached['name'] ?></a></li>

                                    <? } ?>

                                </ul><br/><br/>
                                   
                            </div>
  <input type="hidden" name="is_delete" id="is_delete" value="0"/>
                                <input type="hidden" id="hiiden_id" value="<?=$hidden_id?>"/>

 <ul class="contacts_menu" style="margin-top:20px;">
                                 
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