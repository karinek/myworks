<link type="text/css" href="<?php echo base_url(); ?>css/jquery-ui-1.8.20.custom.css" rel="Stylesheet" />
<script type="text/javascript" src="<?php echo base_url(); ?>js/ajaxupload.js"></script>

<script type="text/javascript">
    $(function(){
        $('#advanced_search_block input').checkBox();
        $('.my_office_buyer_page .middle input').checkBox();
        $("#country_id1").selectbox();
        $("#country_id2").selectbox();
        $("#country_id3").selectbox();
        $("#country_id4").selectbox();
        $("#supplier_location").selectbox();
        $("#shipping_terms").selectbox();
        $("#currency").selectbox();
        $("#payment_terms").selectbox();
        
        $("#select1").selectbox();
        $("#purchase_volume_unit").selectbox();
        $("#order_quantity_unit").selectbox();
        $("#business_type1").selectbox();
        
        $('.preview').click(function(){
            var new_action = $('#form_id').attr('action').replace('postBuyRequest','preview');
            $('#form_id').attr('action',new_action);
            $('#form_id').submit();
        });
    });
    
    $(function(){
        $('#advanced_search_block input').checkBox();
        $('.my_office_buyer_page .middle input').checkBox();
    });

  $(document).ready(function () {
    
    var thumb = $('#thumb');	

	new AjaxUpload('fileInput1', {
		action: $('#mask1').attr('action'),
		name: 'userfile',
		onSubmit: function(file, extension) {
			$('#preview').addClass('loading');
		},
		onComplete: function(file, response) {
			thumb.load(function(){
				$('#preview').removeClass('loading');
				thumb.unbind();
			});
			
			thumb.attr('src', $('#upload_image_folder').val() + "/" + response);
			$('#upload_image').val(response);
		}
	});
    
    
    $('.my_office_buyer_page .middle ul.show_hide li').click(function(){
            $(this).parent('ul').children('li').removeClass('active');
            $(this).addClass('active');
            
        });
    
    
    var disp = document.getElementById("cDisp");
    var stringTitle1 = '';
    var stringTitle2 = '';
    var stringTitle3 = '';
    var stringTitle4 = '';
  function getIndexValue(oSel)
{
    var index = oSel.selectedIndex;
    return oSel[index].value;    
}
   $("#sel_level_1 li", this).live('click', function(){
       $('#sel_level_1 .background').removeClass();
       $(this).addClass('background');
   });
   $("#sel_level_2 li", this).live('click', function(){
       $('#sel_level_2 .background').removeClass();
       $(this).addClass('background');
   });
   $("#sel_level_3 li", this).live('click', function(){
       $('#sel_level_3 .background').removeClass();
       $(this).addClass('background');
   });
   $("#sel_level_4 li", this).live('click', function(){
       $('#sel_level_4 .background').removeClass();
       $(this).addClass('background');
   });
  $("#sel_level_1 li").click(function() {
           $('.scrollbars').css('width','auto');
        $(".scrollbars").css('pointer-events','none');
        document.getElementById('category_id').value = $(this).attr('id');
       
        stringTitle1 =  "<i>" + $(this).text() + "</i>";
        disp.innerHTML = stringTitle1;  
        document.getElementById('catdisplay').value = disp.innerHTML;
        stringTitle2 = '';
        stringTitle3 = '';
        stringTitle4 = '';
         
        var urlstring = "<?php echo base_url(); ?>index.php/product/addproductstep1/" + $(this).attr('id');
        $.get(urlstring,
        function(data) {
            $(".scrollbars").css('pointer-events','auto');
        
          var sel3 = $("#sel_level_3");
          sel3.empty(); 
          var sel4 = $("#sel_level_4");
          sel4.empty();
          
          
          var sel = $("#sel_level_2");
          sel.empty();
         if(jQuery.isEmptyObject(data))
         {
          
          document.getElementById('next').disabled = false;
         }
         else
         {
            document.getElementById('category_id').value = '';
            document.getElementById('next').disabled = true;
            for (var i=0; i<data.length; i++) {
                sel.append('<li id="' + data[i].category_id+ '">' + data[i].category_name + '</li>');
            }
         }
        }, "json");
    });
     $("#sel_level_2 li").live('click', function() {
           $('.scrollbars').css('width','auto');
         document.getElementById('category_id').value = $(this).attr('id');   
        stringTitle2 =  "<i>" + $(this).text() + "</i>";
        disp.innerHTML = stringTitle1 + "   >>   " +stringTitle2;
        document.getElementById('catdisplay').value = disp.innerHTML;
        stringTitle3 = '';
        stringTitle4 = '';
         var urlstring = "<?php echo base_url(); ?>index.php/product/addproductstep1/" + $(this).attr('id');
       
        $.get(urlstring,
        function(data) {

          var sel4 = $("#sel_level_4");
          sel4.empty();
          
          var sel = $("#sel_level_3");
          sel.empty();
          
          
         if(jQuery.isEmptyObject(data))
         {
          document.getElementById('next').disabled = false;
         }
         else
         {
            document.getElementById('category_id').value = '';
            document.getElementById('next').disabled = true;
            for (var i=0; i<data.length; i++) {
              sel.append('<li id="' + data[i].category_id+ '">' + data[i].category_name + '</li>');
            }
         }
      }, "json");
      });
  
       $("#sel_level_3 li").live('click', function() {
         document.getElementById('category_id').value = $(this).attr('id');
        stringTitle3 =  "<i>" + $(this).text() + "</i>";
        disp.innerHTML = stringTitle1 + "   >>   " +stringTitle2 + "   >>   " +stringTitle3;
        document.getElementById('catdisplay').value = disp.innerHTML;
        stringTitle4 = '';
        document.getElementById('category_id').value = $(this).attr('id');
        
        var urlstring = "<?php echo base_url(); ?>index.php/product/addproductstep1/" + $(this).attr('id');
       
        $.get(urlstring,
        function(data) {
          
        
          
          var sel = $("#sel_level_4");
          sel.empty();
         if(jQuery.isEmptyObject(data))
         {
           $('.scrollbars').css('width','auto');
          document.getElementById('next').disabled = false;
         }
         else
         {
            $('.scrollbarsContainer').animate({scrollLeft:300},'slow');
            document.getElementById('category_id').value = '';
            document.getElementById('next').disabled = true;
            for (var i=0; i<data.length; i++) {
              $('.scrollbars').css('width','951px');
              sel.append('<li id="' + data[i].category_id+ '">' + data[i].category_name + '</li>');
            }
         }
      }, "json");
      });
       
     $("#sel_level_4 li").live('click', function() {
         document.getElementById('category_id').value = $(this).attr('id');
         document.getElementById('next').disabled = false;
         stringTitle4 =  "<i>" + $(this).text() + "</i>";
         disp.innerHTML = stringTitle1 + "   >>   " +stringTitle2 + "   >>   " +stringTitle3 + "   >>   " +stringTitle4;
         document.getElementById('catdisplay').value = disp.innerHTML;
     });
     
        var options = {
        dateFormat: "yy-mm-dd",
        changeYear: true
    }
    $('#expired_time_id').datepicker(options);
            


});
</script>

 <div id="office_tabs_block">
    <?php $this->load->view('modules/company/tabs_nav',array('selectedPage'=>'Buying')); ?>
    <div id="office_tabs_content">
        <div class="my_office_buyer_page">
            <div class="left">
                <h2>Post a Buying Request</h2>
                <ul style="width:149px;">
                    <li class="active"><a href="<?php echo base_url(); ?>request/buy">Post Buying Request</a></li>
                    <li><a href="<?php echo base_url(); ?>request/manage">Manage Buying Request</a></li>
                </ul>
                <div class="support">
                    <p class="head_text">Support</p>
                    <p>Jaqueline is <span>Online</span></p>
                </div>
            </div>
            <div class="middle">
                <h2>Tell the supplier what your looking for?</h2>
                    <?php echo form_open_multipart('request/postBuyRequest/'/*.$company['id']*/, array('id'=>'form_id')); ?>
                        <div>
                            <p class="label">Product Name <span class="required">*</span></p>
                            <input type="text" name="product_name" id="product_name" value="<?php echo set_value("product_name"); ?>" class="product_name" /> <?php echo form_error('product_name')?>
                            
                        </div>
                        
                    <div>
                        <h2 style="font-size: 13px;width: 470px;line-height: 1.5;">Categories Selected: <?php echo $catdisplay; ?></h2>
                        <div class="reSelect" style="margin-bottom: 30px;font-weight: bold;">
                            <a href="<?php echo base_url().'request';?>">Select a category</a>
                        </div>
                    </div>
                        <input type="hidden" value="<?php echo $category_id; ?>" name="category_id" />
                        <input type="hidden" value="<?php echo $catdisplay; ?>" name="catdisplay" />
                        <div>
                            <p class="label">Details and Description <span class="required">*</span></p>
                            <p><?php echo form_error('product_specification')?><br /></p>
                            <textarea name="product_specification" id="description" cols="" rows=""><?php echo set_value("product_specification"); ?></textarea>
                        </div>
                        <p class="small">* Maximum 2000 Characters</p>
                        
                        
                        <div id="file_input_img" class="preview" style="margin-top: 50px;cursor: pointer">
			    <img width="150px" height="150px" src="" id="thumb"/>
			</div>
                        <div id="mask1" action="<?php echo site_url('request/img_preview'); ?>" style="width: 140px;cursor: pointer" >
                            <div class="mask_button1" style="width: 138px;cursor: pointer">Upload Image</div>
                            <input name="userfile" type="file"  style="width: 140px;cursor: pointer" id="fileInput1" />
			    <input id="upload_image" name="image_name" type="hidden"/>
                            <input id="upload_image_folder" type="hidden" value="<?php echo site_url('files/request/images/temp'); ?>"/>
			</div>
                        
                         <div id="mask" style="margin-bottom: 180px;">
                            <div class="mask_button">Upload Files</div>
                            <input type="file" id="fileInput" name="product_file" size="11" onchange="document.getElementsByClassName('product_file_text')[0].value = this.value;"/>
                            <input type="text" id="fileInputText" class="product_file_text" value="* Maximum 2MB" onfocus="if(this.value=='* Maximum 2MB') this.value='';" onblur="if(!this.value) this.value='* Maximum 2MB';"/>
                        </div>
                        <div>
                            <p class="label">Order Quantity <span class="required">*</span></p>
                            <input type="text" value="<?php echo set_value("order_quantity"); ?>" name="order_quantity" class="my_office_buyer_input" /> <?php echo form_error('order_quantity')?>
                            <p class="label">Select Unit <span class="required">*</span></p>
                            <div class="select">
                                <?php echo form_dropdown('order_quantity_unit',$buyingUnits, set_value("order_quantity_unit"), 'id="order_quantity_unit"'); ?> <?php echo form_error('order_quantity_unit')?>
                            </div>
                        </div>
                        <div>
                            <p class="label">Annual Purchase Volume</p>
                            <input type="text" value="<?php echo set_value("purchase_volume"); ?>" name="purchase_volume" class="my_office_buyer_input" />
                            <p class="label">Select Unit</p>
                            <div class="select">
                                <?php echo form_dropdown('purchase_volume_unit',$buyingUnits, set_value("purchase_volume_unit"), 'id="purchase_volume_unit"'); ?>
                            </div>
                        </div>
                        <div>
                            <p class="label">Expired Time <span class="required">*</span></p>
                            <input type="text" value="<?php echo date('Y-m-d', time()+3600*24*30)?>" name="expired_time" id="expired_time_id" class="my_office_buyer_input" /> <?php echo form_error('expired_time')?>
                        </div>
                        <hr />
                        <h2>For suppliers to better understand your request, enter more info here.</h2>
                        <p class="label">Supplier Location</p>
                        <div class="select">
							<?php echo form_dropdown('supplier_location', $country_options, set_value("supplier_location"), 'id="supplier_location"');?>
                        </div>
                        <p class="label">Shipping Terms</p>
                        <div class="select">
                            <?php echo form_dropdown('shipping_terms',$shippingTerms, set_value("shipping_terms"), 'id="shipping_terms"'); ?>
                        </div>
                        <p class="label">Preferred Unit price</p>
                        <input type="text" value="<?php echo set_value("unit_price"); ?>" name="unit_price" id="unit_price" class="my_office_buyer_input" />
                        <div class="select">
                            <?php echo form_dropdown('currency',$currency, set_value("currency"), 'id="currency"'); ?>
                        </div>
                        <p class="label">Destination Port</p>
                        <input type="text" value="" name="destination_port" id="destination_port" class="my_office_buyer_input" />
                        <p class="label">Payment Terms</p>
                        <div class="select">
                            <?php echo form_dropdown('payment_terms',$paymentTerms, set_value("payment_terms"), 'id="payment_terms"'); ?>
                        </div>
                        <hr />
                        <p class="head_text" style="float:none;"><b>Who are you?</b> Supplier Needs Information!</p>
                        <div class="head_text">
                            <p>Do you represent a company? <span class="required">*</span></p>
                            <p><input type="radio" name="represent_company" value="Yes" /><label>Yes</label></p>
                            <p><input type="radio" name="represent_company" value="No" /><label>No</label></p>
                             <p><?php echo form_error('represent_company')?></p>
                        </div>
                        <div>
                            <p class="label">Business Type <span class="required">*</span></p>
                            <p><?php echo form_error('business_type1')?></p>
                            <div class="select">
                                <?php echo form_dropdown('business_type1',$business_type_options, set_value("business_type1"), 'id="business_type1"'); ?>
                            </div>
                        </div>
                        <div>
                            <p class="label">Company Website</p>
                            <input type="text" value="<?php echo set_value("website"); ?>" name="website" class="my_office_buyer_input" />
                        </div>
                        <div>
                            <p class="label">Tel. (Country/Area/Number)</p>
                            <input type="text" value="<?php echo set_value("tel1"); ?>" name="tel1" class="my_office_buyer_input small_tel" />
                            <input type="text" value="<?php echo set_value("tel2"); ?>" name="tel2" class="my_office_buyer_input small" />
                            <input type="text" value="<?php echo set_value("tel3"); ?>" name="tel3" class="my_office_buyer_input small" />
                        </div>
                        <hr />
                        <div class="submit_block">
                            
                            <input type="submit" value="Submit" class="submit" />
                            <input type="button" value="Preview" class="preview" />
                            
                        </div>
                        <p class="head_text"><input type="checkbox" name="accept_terms" /><label><span class="required">*</span> I have read and accept the <a href="#">Terms</a> and <a href="#">Conditions</a> of XXXXXX. </label></p>
                        <p> <?php echo form_error('accept_terms')?></p>
                    <?php echo form_close() ?>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>