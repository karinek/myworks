<script type="text/javascript" src="<?php echo base_url(); ?>js/ajaxupload.js"></script>
<script language="javascript" src="<?php echo base_url(); ?>js/product/add.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript">
$(document).ready(function() {
     
  	var thumb = $('#thumb');	

	new AjaxUpload('fileInput1', {
		action: $('#mask1').attr('action'),
		name: 'userfile',
		onSubmit: function(file, extension) {
			thumb.attr('width', "30px");
			thumb.attr('height', "30px");
			thumb.attr('src', "<?php echo base_url(); ?>images/" + "loading.gif");
		},
		onComplete: function(file, response) {
			thumb.load(function(){
				thumb.unbind();
				thumb.attr('width', "150px");
				thumb.attr('height', "150px");
			});
			thumb.attr('src', "<?php echo base_url(); ?>images/product_images/temp/" + response);
			
			$('#upload_image').val(response);
		}
	});
	
	$('.preview').click(function(){
		submitfrm();
		var new_action = $('#form_id').attr('action').replace('add','preview');
		$('#form_id').attr('action',new_action);
		$('#form_id').submit();
	});
	
	$('.submit').click(function(){
		submitfrm();
		var new_action = $('#form_id').attr('action').replace('preview','add');
		$('#form_id').attr('action',new_action);
		$('#form_id').submit();
	});

	$('#long_desc_editor').tinymce({
		// Location of TinyMCE script
		script_url : '<?php echo base_url(); ?>js/tiny_mce/tiny_mce.js',
		width: 730,
		height: 450,
		// General options
		theme : "advanced",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,table,charmap,bullist,numlist,|,blockquote,|,undo,redo,|,link,unlink,image,code,|,insertdate,inserttime,|,forecolor,backcolor",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		theme_advanced_resize_horizontal : false,

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
	
});



	$(function () {
		$(".myselect").selectbox();
	});


    $(function(){
        $('#advanced_search_block input').checkBox();
		$('.my_office_buyer_page .middle input').checkBox();
    });

    function validate(evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode( key );
    var regex = /[0-9]|\./;
    if( !regex.test(key) ) {
        theEvent.returnValue = false;
        if(theEvent.preventDefault) theEvent.preventDefault();
    }

}
    function escapeHtml(unsafe) {
  	  return unsafe
  	      .replace(/&(?!amp;)/g, "&amp;")
  	      .replace(/<(?!lt;)/g, "&lt;")
  	      .replace(/>(?!gt;)/g, "&gt;")
  	      .replace(/"(?!quot;)/g, "&quot;")
  	      .replace(/'(?!#039;)/g, "&#039;");
  	}
    function checkForm(){
        var prod_name  = trim($('#prod_name').val()),
        	prod_kwd   = trim($('#prod_kwd').val()),
        	short_desc = trim($('#short_desc').val()),
        	licence    = $('#licence').is(':checked');

        if(prod_name == '' || prod_kwd == '' || short_desc == ''){
            alert('You must fill all required fields.');
			return false;     
        }else{
            if(licence){
            	$('#long_desc').val(escapeHtml($('#long_desc_editor').val()));
             	return true;
            }
            else{
            	alert('You must acknowledge licence at the bottom of page before submitting.');
            	return false;
            }
        }
		
    }    
</script>
<div id="office_tabs_block">
            	<?php $this->load->view('modules/company/tabs_nav',array('selectedPage'=>'Selling')); ?>
<div id="office_tabs_content">
    <div class="my_office_buyer_page">
        <div class="left">
		<h2>Product</h2>
<!--                <p class="online_offline"><a href="#" class="green">Online</a> - <a href="#">Offline</a></p>-->
                <ul>
                    <li class="active"><a href="<?php echo base_url(); ?>product">Add New Product</a></li>
                    <li><a href="<?php echo base_url(); ?>product/manage">Manage Products</a></li>
                </ul>
<!--                            <p class="online_offline"><a href="#" class="green">Online</a> - <a href="#">Offline</a></p>-->
<!--                            <ul>
                            	<li class="active"><a href="#">Post Buying<br /> Request</a></li>
                                <li><a href="#">Manage Buying<br /> Request</a></li>
                                <li><a href="#">Manage Requests<br /> for Quotations</a></li>
                                <li><a href="#">Manage Sample<br /> Request</a></li>
                            </ul>-->
<!--                            <div class="support">
                            	<p class="head_text">Support</p>
                                <p class='label'>Jaqueline is <span>Online</span></p>
                            </div>-->
<!--                            <form action="">
                            	<textarea cols="" rows="" onfocus="if(this.value=='eg... Ask me a question?') this.value='';" onblur="if(!this.value) this.value='eg... Ask me a question?';" >eg... Ask me a question?</textarea>
                                <input type="submit" value="Ask" />
                            </form>-->
                        </div>
        <div class="middle"> 
		<div class="error_block">
                                    <ul>
                                        <li><?php echo form_error('prod_name'); ?></li>
                                        <li><?php echo form_error('prod_kwd'); ?></li>
                                        <li><?php echo form_error('short_desc'); ?></li>
                                        <li><?php echo form_error('licence'); ?></li>
                                    </ul>
                                    
                                </div>  
                        	<h2>Display and Add a New Product</h2>
                                <?php echo form_open_multipart('product/add', array('id'=>'form_id','onsubmit'=>'return checkForm();')); ?>
				
				
				
<!--                            <form action="<?php //echo base_url(); ?>index.php/product/add" method="post" accept-charset="utf-8" id="form_id" enctype="multipart/form-data">-->
                            	<input type="hidden" value="<?php echo $category_id; ?>" name="category_id" />
				<input type='hidden' name="dyn_attr_count" id="dyn_attr_count"  value="">
                                
                                
                                <h2>Product Info:</h2>
                                <div>
                                    <h2 style="font-size: 13px;width: 470px;line-height: 1.5;">Categories Selected: <?php echo $catdisplay; ?></h2>
                                    <div class="reSelect" style="margin-bottom: 30px;font-weight: bold;">
                                        <a href="<?php echo base_url().'product';?>"">Select a category</a>
                                    </div>
                                </div>
                                <p class='label'><label for="prod_name">Product Name *</label></p>
                                <p class='label'><input id="prod_name" alt="Product Name *" type="text" name="prod_name" value="<?php echo set_value('prod_name'); ?>" class="my_office_buyer_input" /></p>
                                
                                <p class='label'><label for="prod_kwd">Product Keywords *</label></p>
                                <p class='label'><input id="prod_kwd" type="text" name="prod_kwd" alt="Product Keywords *" value="<?php echo set_value('prod_kwd'); ?>" class="my_office_buyer_input" /></p>
                     
                                <p class='label'><label for="short_desc">Short Description*</label></p>
                                <p class='label'><textarea id="short_desc" name="short_desc" cols="" rows="" alt="" style="height:150px;"><?php echo set_value('short_desc'); ?></textarea></p>
                              
                                <p class="small">* Maximum 2000 Characters</p>
				
                                <div id="file_input_img" class="preview" style="margin-top: 10px;cursor: pointer">
					<img width="150px" height="150px" src="" id="thumb"/>
				</div>
                                <div id="mask1" action="<?php echo site_url('product/img_preview'); ?>" style="width: 140px;cursor: pointer" >
                                        <div class="mask_button1" style="width: 138px;cursor: pointer">Upload Image</div>
                                        <input name="userfile" type="file"  style="width: 140px;cursor: pointer" id="fileInput1" />
					<input id="upload_image" name="image_name" type="hidden"/>
				</div>
                                
                                <hr style="clear:both" />
                                
                                
                                <?php if(!empty($attrList)): ?>
                                <h2>Specific Product Description Information:</h2>
                                <?php 
                                    echo "<tr>";
                                    echo "<td colspan=\"2\">";
                                    echo "<fieldset>";
                                    echo $attrList;                                      
                                    echo "</fieldset>";
                                    echo "</td>";    
                                    echo "</tr>";
                                    endif;
                                ?>
<!--                                <p class='label'><input type="text" name="attr_101" value="CAS Number *" class="my_office_buyer_input" onfocus="if(this.value=='CAS Number *') this.value='';" onblur="if(!this.value) this.value='CAS Number *';"/></p>
                                <p class='label'><input type="text" name="attr_102" value="Other Names" class="my_office_buyer_input" onfocus="if(this.value=='Other Names') this.value='';" onblur="if(!this.value) this.value='Other Names';"/></p>
                                <p class='label'><input type="text" name="attr_103" value="MF" class="my_office_buyer_input" onfocus="if(this.value=='MF') this.value='';" onblur="if(!this.value) this.value='MF';"/></p>
                                <p class='label'><input type="text" name="attr_104" value="EINECS Number" class="my_office_buyer_input" onfocus="if(this.value=='EINECS Number') this.value='';" onblur="if(!this.value) this.value='EINECS Number';"/></p>
                                <div  class="select">
                                    <select name="attr_105" id="select4">
                                        <option>Place of Origin</option>
                                        <option>Place of Origin</option>
                                        <option>Place of Origin</option>
                                        <option>Place of Origin</option>
                                        <option>Place of Origin</option>
                                        <option>Place of Origin</option>
                                        <option>Place of Origin</option>
                                    </select>
                                </div>
                                <p class='label'><input type="text" name="attr_107" value="Purity *" class="my_office_buyer_input" onfocus="if(this.value=='Purity *') this.value='';" onblur="if(!this.value) this.value='Purity *';"/></p>
                                <div class="select">
                                    <select id="select5">
                                        <option>Classification *</option>
                                        <option>Classification *</option>
                                        <option>Classification *</option>
                                        <option>Classification *</option>
                                        <option>Classification *</option>
                                        <option>Classification *</option>
                                        <option>Classification *</option>
                                    </select>
                                </div>
                                <p class='label'><input type="text" name="attr_109" value="Brand Name" class="my_office_buyer_input" onfocus="if(this.value=='Brand Name') this.value='';" onblur="if(!this.value) this.value='Brand Name';"/></p>
                                -->
                                <hr />
                                
                                <h2>Additional Description Information:</h2>
                                <p class='label'>
                                	<textarea id="long_desc_editor" cols="" rows="" alt="" ><?php echo set_value('long_desc'); ?></textarea></p>
                                	<input type="hidden" id="long_desc" value="<?php echo set_value('long_desc'); ?>" name="long_desc">
                                <p class="small">* Maximum 2000 Characters</p>
                                
                                <hr />
                                
                                <h2>Additional Trade Information:</h2>
                                <p class='label'><label for="qty">Minimun Order Quantity</label></p>
                                    <div class="form_inline_block" style="float:none;display:block">
                                        <input id="qty" type="text" name="qty" alt="Minimun Order Quantity" value="<?php echo set_value('qty'); ?>" onkeypress='validate(event)' class="my_office_buyer_input medium" >
                                        <div class="select small form_inline">
                                            <?php  echo form_dropdown('qty_unit', $unitList, '', 'class="myselect"');?> 
                                        </div>
                                    </div>
                                <p class='label'><lablel>FOB Price</label></p>
                                    <div class="form_inline_block" style="display:block;width:100%">
                                        <div class="select small form_inline">
                                            <?php  echo form_dropdown('prc_cur', $curList, '', 'class="myselect"');?>
                                        </div>
                                        <p class="form_inline"><input name="cur_prc1" type="text" alt="Lowest" onkeypress='validate(event)' value="<?php echo set_value('cur_prc1'); ?>" class="my_office_buyer_input small" /></p>
                                        <p class="form_inline"><input name="cur_prc2" type="text" alt="Highest" onkeypress='validate(event)' value="<?php echo set_value('cur_prc2'); ?>" class="my_office_buyer_input small" /></p>
                                        <div class="select small form_inline">
                                            <?php echo form_dropdown('cur_unit', $unitList, '', 'class="myselect"');?> 
                                        </div>
                                    </div>
                                <p class='label'><label for="port">Port</label></p>
                                <p class='label'><input id="port" type="text" name="port" alt="Port" value="<?php echo set_value('port'); ?>" class="my_office_buyer_input" /></p>
                                
                                <hr />
                                
                                <h2>Payment Terms:</h2>
                                <ul class="checkboxes_list small">
                                	<li><input type="radio" name="pay_terms" value="Cash" /><label>Cash</label></li>
                                        <li><input type="radio" name="pay_terms" value="Credit" /><label>Credit</label></li>
                                        <li><input type="radio" name="pay_terms" value="Cheque" /><label>Cheque</label></li>
                                        <li><input type="radio" name="pay_terms" value="Bank Deposit" /><label>Bank Deposit</label></li>
                                        <li><input type="radio" name="pay_terms" value="COD" /><label>COD</label></li>
                                </ul>
                                <p class='label'><label for="prod_cpt">Production Capacity</label></p>
                                <div class="form_inline_block" style="width:100%">
                                    <p class="form_inline"><input id="prod_cpt" type="text" name="prod_cpt" alt="Production Capacity" onkeypress='validate(event)' value="<?php echo set_value('prod_cpt'); ?>" class="my_office_buyer_input small" /></p>
                                    <div class="select small form_inline">
                                        <?php echo form_dropdown('cpt_unit', $unitList, '', "class='myselect'");?> 
                                    </div>
                                    <p class="form_inline"><label>per</label></p>
                                    <div class="select small form_inline">
                                        <select name="cpt_prd" class="myselect">
                                            <option>Time</option>
                                            <option value="Day">Day</option>
                                            <option value="Quarter">Quarter</option>
                                            <option value="Week">Week</option>
                                            <option value="Month">Month</option>
                                            <option value="Year">Year</option>
                                        </select>
                                    </div>
                                </div>
                                <p class='label'><label for="dlv_t">Delivery Time</label></p>
                                <p class='label'><input id="dlv_t" type="text" name="dlv_t" alt="Delivery Time" value="<?php echo set_value('dlv_t'); ?>" class="my_office_buyer_input" /></p>
                                <p class='label'><label for="p_dts">Packing Details</label></p>
                                <p class='label'><textarea id="p_dts" name="p_dts" cols="" rows=""  style="height:150px;"></textarea></p>
                                <div class="submit_block" style="margin-top:30px;">
                                    <input type="button" value="Submit" class="submit" style="margin-right: 15px" />
                                    <input type="button" value="Preview" class="preview" />
                                </div>
                                <p class="head_text"><input name="licence" id="licence" type="checkbox" /><label style=" float: left; width: 670px; margin-bottom: 20px; ">By clicking submit, you acknowledge that your information does not violate any listing policies. You can 
                                    edit the listing again once it is published onto the website or returned to you.</label></p>
                            </form>
            </div>
        </div>
    </div>
</div>
<!--<script type="text/javascript">

(function($){
	$('form#form_id input:checkbox').checkBox();
	$('form#form_id select').selectbox();
	$('form#form_id input:text, form#form_id input:password, form#form_id textarea').click(function(){
		var $this = $(this);
		var val = $this.val();
		if(val == $this.attr('alt')){
			if($this.attr('id') == 'layer-password_id' || $this.attr('id') == 'layer-repassword_id'){
				$this.hide();
				$('#'+$this.attr('id').substr(6)).show().val('').focus();
			}else{
				$this.val('');
			}
		}
	});
	
	$('form#form_id input:not(.submitbox)').on('focus,change',function(){
		var $this = $(this);
		var x = $this.offset().left + $this.width(), y = $this.offset().top + $this.height();
		$('#tooltips .content').html($this.attr('alt'));
		$('#tooltips').css({
			top: y - $('#tooltips').height()/2,
			left: x + 14,
			display: 'block'
		}).show(500);
	});
	
	$('form#form_id input:text, form#form_id input:password').blur(function(){
		$('#tooltips').hide(200);
		var $this = $(this);
		var val = $this.val();
		if(val == ''){
			if($this.attr('type') == 'password'){
				$this.hide();
				$('#layer-'+$this.attr('id')).show().val($this.attr('alt'));
			}else{
				$this.val($this.attr('alt'));
			}
		}
	});
	$('form#form_id input:text').each(function(){
		var $this = $(this);
		var val = $this.val();
		if(val == ''){
			if($this.attr('type') == 'password'){
				$this.hide();
				$('#layer-'+$this.attr('id')).show().val($this.attr('alt'));
			}else{
				$this.val($this.attr('alt'));
			}
		}
	});

})(jQuery);
</script>-->