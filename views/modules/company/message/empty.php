
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

                        <div class="contacts_block_main" style="margin-top:82px">


                          
                           <div class="contacts_block_main_head" style="margin-left:182px">Sorry no message avaialbe at the moment</div>
                        

               


                        </div>
                    </div>

                    <!-- End Contacts Block -->



                </div>
            </div>
        </div>
        <!-- End Product Tabs -->


    </div>
</div>