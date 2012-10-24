<!-- CONTENT -->
<script type="text/javascript" src="<?php echo base_url(); ?>js/ajaxupload.js"></script>
    <div id="content">
    	<div class="wrapper">
        	
            <!-- PRODUCT TABS -->
            <div id="office_tabs_block">
			<?php $this->load->view('modules/company/tabs_nav',array('selectedPage'=>'My Company')); ?>
                <div id="office_tabs_content">
                	<div class="my_office_buyer_page">
                    	<div class="left">
                            <ul>
                            	<li class="active"><?php echo anchor('company','My company'); ?></li>
                                <li><?php echo anchor('company/contacts/','My Contacts'); ?></li>
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
                        <?php echo form_open_multipart('company/do_update/', array('id'=>'form_id')); ?>
                            <div class="middle">
                                <div class="error_block">
                                    <ul>
                                        <li></li>
                                        <li></li>
                                        <li></li>
                                        <li></li>
                                    </ul>
                                    
                                </div>    
                                
                                
                                <h2>Company Details:</h2>
                                <form action="">
                                    
                                    <p class="label"><label>Company Name *</label><?php echo form_error('name'); ?></p>
                                    <p><input name="name" type="text" value="<?php echo ($company['name'] != '')?$company['name']:''; ?>" class="my_office_buyer_input" /></p>
                                    <p class="label"><label>Street Address *</label><?php echo form_error('address'); ?></p>
                                    <p><input name="address" type="text" value="<?php echo ($company['address'] != '')?$company['address']:''; ?>" class="my_office_buyer_input" /></p>
                                    <p class="label"><label>City *</label><?php echo form_error('city'); ?></p>
                                    <p><input name="city" type="text" value="<?php echo ($company['city'] != '')?$company['city']:''; ?>" class="my_office_buyer_input" /></p>
                                    <p class="label"><label>Country</label></p>
                                    <div class="select">
                                        <?php echo form_dropdown('country', $country_options, empty($company['country'])?$user['location']:$company['country']);?>
                                    </div>
                                    <p class="label"><label>State</label> <label style="margin-left:130px;">Zip Code</label><?php echo form_error('zip'); ?></p>
                                    <p><input name="state" type="text" value="<?php echo ($company['state'] != '')?$company['state']:''; ?>" class="my_office_buyer_input small" />
                                    <input name="zip" type="text" value="<?php echo ($company['zip'] != '')?$company['zip']:''; ?>" class="my_office_buyer_input small" /></p>
                                    <p class="label"><label>Company Website</label></p>
                                    <p><input name="website" type="text" value="<?php echo ($company['website'] != '')?$company['website']:''; ?>" class="my_office_buyer_input" /></p>
                                    <p class="label"><label>Email</label></p>
                                    <p><input name="email" type="text" value="<?php echo ($company['email'] != '')?$company['email']:$user['email']; ?>" class="my_office_buyer_input" /></p>
									<p class="label"><label>Phone Number</label><?php echo form_error('phone_country'); ?></p>
									<p>
										<input title="Tel" class="my_office_buyer_input" type="text" id="phone_country_id" name="phone_country" value="<?php echo isset($company['phone_country'])&&$company['phone_country']!=''?$company['phone_country']:$user['phone_country']; ?>" style="width:40px;" maxlength="3" />
										<input title="Area" class="my_office_buyer_input" type="text" id="phone_area_id" name="phone_area" value="<?php echo isset($company['phone_area'])&&$company['phone_area']!=''?$company['phone_area']:$user['phone_area']; ?>" style="width:107px;margin-left: 10px;" maxlength="4" />
										<input title="Number" class="my_office_buyer_input" type="text" id="phone_number_id" name="phone_number" value="<?php echo isset($company['phone_number'])&&$company['phone_number']!=''?$company['phone_number']:$user['phone_number']; ?>"  style="width:107px;margin-left: 10px;" maxlength="10"/>
									</p>

                                    <p class="label"><label>Fax Number</label></p>
									<p>
										<input title="Tel" class="my_office_buyer_input" type="text" id="phone_country_id" name="fax_country" value="<?php echo isset($company['fax_country'])&&$company['fax_country']!=''?$company['fax_country']:''; ?>" style="width:40px;" maxlength="3" />
										<input title="Area" class="my_office_buyer_input" type="text" id="phone_area_id" name="fax_area" value="<?php echo isset($company['fax_area'])&&$company['fax_area']!=''?$company['fax_area']:''; ?>" style="width:107px;margin-left: 10px;" maxlength="4" />
										<input title="Number" class="my_office_buyer_input" type="text" id="phone_number_id" name="fax_number" value="<?php echo isset($company['fax_number'])&&$company['fax_number']!=''?$company['fax_number']:''; ?>"  style="width:107px;margin-left: 10px;" maxlength="10"/>
									</p>
                                    
                                    <hr />

                                    <h2>Business Type:*</h2>
                                    <div><?php echo form_error('business_types'); ?></div>
				    <div class="select small" style="float:left;">
                                    <?php echo form_dropdown('business_types',$business_type_options, $company['business_type']);?>
				    </div>
				    <br /><br /><br /><br />
                                    <h2>Products or Services - We Sell:*</h2>
                                    <div><?php echo form_error('sell_product'); ?></div>
                                    <p><input alt="List Items/Services *" name="sell_product" type="text" value="<?php echo ($company['sell_product'] != '')?$company['sell_product']:''; ?>" class="my_office_buyer_input" /></p>
                                    <h2>Contract Manufacturing:</h2>
                                    <?php if(isset($service_options)): ?>
                                        <?php 
                                        $services_array = array();
                                        if($company['service'] != ''):
                                            $services_array = explode('|', $company['service']);
                                        endif; 
                                        ?>
                                        <ul class="checkboxes_list">
                                            <?php foreach($service_options as $service_option): ?>
                                            <li><input type="checkbox" name="services[]" value="<?php echo $service_option['id']; ?>" <?php echo (in_array($service_option['id'], $services_array))?'checked="checked"':''; ?> />
                                                    <label><?php echo $service_option['name']; ?></label>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>

                                    <hr />

                                    <h2>Company Information:</h2>
                                    <p class="label"><label>Year Registered:</label> <label style="margin-left:63px;">Total No. Employees:</label></p>
                                    <div class="select small" style="float:left;">
                                        <?php echo form_dropdown('year', M_options::getRegisteredYears(), $company['year']);?>
                                    </div>
                                    <div class="select small" style="float:left; margin-left:10px;">
                                        <?php echo form_dropdown('no_employee', M_options::getNoEmployee(), $company['no_employee']);?>
                                    </div>
                                    <div class="clear"></div>
                                    <p class="label"><label>List Brands</label></p>
                                    <p><input name="brand" type="text" value="<?php echo ($company['brand'] != '')?$company['brand']:''; ?>" class="my_office_buyer_input" /></p>
                                    <p class="label"><label>Ownership Type</label></p>
                                    <div class="select">
                                        <?php echo form_dropdown('ownership_type', M_options::getOwnerShipDetails(), $company['ownership_type']);?>
                                    </div>
                                    <p class="label"><label>Registered Capital</label></p>
                                    <div class="select">
                                        <?php echo form_dropdown('registered_capital', M_options::getOwnerShipDetails(), $company['registered_capital']);?>
                                    </div>
                                    <p class="label"><label>Legal Owner</label></p>
                                    <p><input alt="" name="owner" type="text" value="<?php echo ($company['owner'] != '')?$company['owner']:''; ?>" class="my_office_buyer_input" /></p>

                                    <hr />

                                    <h2>Production &amp; Markets:</h2>
                                    <p class="label"><label>Annual Sales Volume</label></p>
                                    <div class="select">
                                        <?php echo form_dropdown('annual_sale', M_options::getAnnualSaleDetails(), $company['annual_sale']);?>
                                    </div>
                                    <p class="label"><label>Export Percentage</label></p>
                                    <div class="select small">
                                        <?php echo form_dropdown('export_per', M_options::getExportPercentages(), $company['export_per']);?>
                                    </div>
                                    <h2>Main Markets:</h2>
                                    <?php if(isset($region_options)): ?>
                                        <?php 
                                        $regions_array = array();
                                        if($company['region'] != ''):
                                            $regions_array = explode('|', $company['region']);
                                        endif; 
                                        ?>
                                        <ul class="checkboxes_list">
                                            <?php foreach($region_options as $region_option): ?>
                                            <li><input type="checkbox" name="regions[]" value="<?php echo $region_option['id']; ?>" <?php echo (in_array($region_option['id'], $regions_array))?'checked="checked"':''; ?> />
                                                    <label><?php echo $region_option['name']; ?></label>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                    
                                    <p class="label"><label>List Main Customers</label></p>
                                    <p><input name="customer" type="text" value="<?php echo ($company['customer'] != '')?$company['customer']:''; ?>" class="my_office_buyer_input" /></p>

                                    <hr />

                                    <?php if(isset($certification_options)): ?>
                                        <?php 
                                        $certification_array = array();
                                        if($company['certification'] != ''):
                                            $certification_array = explode('|', $company['certification']);
                                        endif; 
                                        ?>
                                        <h2>Company Certification:</h2>
                                        <ul class="checkboxes_list">
                                            <?php foreach($certification_options as $certification_option): ?>
                                            <li><input type="checkbox" name="certifications[]" value="<?php echo $certification_option['id']; ?>" <?php echo (in_array($certification_option['id'], $certification_array))?'checked="checked"':''; ?> />
                                                    <label><?php echo $certification_option['name']; ?></label>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>

                                    <hr />

                                    <h2>Factory Details:</h2>
                                    <p class="label"><label>Factory Location</label></p>
                                    <p><input name="factory_location" type="text" value="<?php echo ($company['factory_location'] != '')?$company['factory_location']:''; ?>" class="my_office_buyer_input" /></p>
                                    <p class="label"><label>Factory Size</label></p>
                                    <div class="select">
                                        <?php echo form_dropdown('factory_size', M_options::getFactorySizeDetails(), $company['factory_size']);?>
                                    </div>
                                    <p class="label"><label>Total Annual Purchase Volume</label></p>
                                    <div class="select">
                                        <?php echo form_dropdown('factory_purchase', M_options::getAnnualPurchaseVolume(), $company['factory_purchase']);?>
                                    </div>
                                    <p class="label"><label>Production Lines</label><label style="margin-left:61px;">Quality Control</label></p>
                                    <div class="select small" style="float:left;">
                                        <?php echo form_dropdown('factory_productionline', M_options::getProductionLines(), $company['factory_productionline']);?>
                                    </div>
                                    <div class="select small" style="float:left; margin-left:10px;">
                                        <?php echo form_dropdown('factory_qc', M_options::getQualityControlDetails(), $company['factory_qc']);?>
                                    </div>
                                    <div class="clear"></div>
                                    <p class="label"><label>No. Staff</label><label style="margin-left:115px;">No. QC Staff</label></p>
                                    <div class="select small" style="float:left;">
                                        <?php echo form_dropdown('factory_no_staff', M_options::getNumberofStaff(), $company['factory_productionline']);?>
                                    </div>
                                    <div class="select small" style="float:left; margin-left:10px;">
                                        <?php echo form_dropdown('factory_no_qc', M_options::getNumberofStaff(), $company['factory_qc']);?>
                                    </div>
                                    <div class="clear"></div>
                                    
                                    <hr />
                                    
                                    <p>
                                    
                                <div style="overflow:hidden;"> 
										<a href="<?=base_url().'upload?module=company&module_id='.$company['id']?>" rel="shadowbox;height=750;width=715;">
                                    <div id="file_input_img" class="preview" style="margin-top: 10px;cursor: pointer; width:260px; height:100px; border:1px solid #ccc;">
                                        <?php if(isset($user['image'])): ?>
                                                <img src="<?php echo base_url(); ?>images/company_images/<?php echo $company['file']; ?>?r=<?=rand(1,10000); ?>" id="thumb" style="width:260px;height:100px;" />
                                        <?php else: ?>
                                                <img src="<?php echo base_url('images/company.png'); ?>" id="thumb"/>* Maximum 2MB
                                        <?php endif; ?>
                                    </div>
										</a>
                                    <div id="mask1" action="<?php echo site_url('register/img_preview'); ?>" style="width: 140px;cursor: pointer; display:none;" >
                                            <div class="mask_button1" style="width: 138px;cursor: pointer">Upload Image</div>
                                            <input name="userfile" type="file"  style="width: 140px;cursor: pointer" id="fileInput1" />
                                            <input id="upload_image" name="image_name" type="hidden"/>
                                            <input id="upload_image_folder" type="hidden" value="<?php echo site_url('images/company_images/temp/'); ?>"/>
                                    </div>
                                </div>
<!--									<div id="file_input_img">
										<img id="thumb" alt="* Maximum 2MB" width="150px" height="150px" src="<?php echo (isset($company['file']))?base_url().'images/company_images/'.$company['file']:''; ?>" />
                                    </div>
                                    <div id="mask1"  action="<?php echo site_url('company/uploadimage'); ?>">
                                        <div class="mask_button1">Upload Image</div>
                                        <input name="userfile" type="file" id="fileInput1" size="11" />
										<input id="upload_image" name="userimage" type="hidden"/>
										<input id="upload_image_folder" type="hidden" value="<?php echo site_url('images/company_images/temp/'); ?>"/>
                                    </div>
-->									
                                    </p>
                                    <div class="clear"><h2>Detailed Company Introduction:</h2></div>
                                    <p><textarea name="product_keyword" rows="" cols="" style="height:150px;"><?php echo ($company['product_keyword'] != '')?$company['product_keyword']:''; ?></textarea></p>
                                    <p class="small">* Maximum 2000 Characters</p>
                                    
                                    <div class="submit_block">
                                        <input type="submit" value="Submit" class="submit" />
                                    </div>
<!--                                    <p class="head_text"><input type="checkbox" /><label>I have read and accept the <a href="#">Terms</a> and <a href="#">Conditions</a> of XXXXXX. </label></p>-->
                                </form>
                            </div>
                        <?php echo form_close() ?>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            <!-- End Product Tabs -->
            
            
        </div>
    </div>
    <!-- End Content -->
    
<script type="text/javascript">
(function($){
	Shadowbox.init({'modal':true});
	
	$('form#form_id input:checkbox').checkBox();
	$('form#form_id input:radio').checkBox();
	$('form#form_id select').selectbox();
	
	$(document).ready(function(e) {
/*		var thumb = $('#thumb');	
		
		new AjaxUpload('fileInput1', {
			action: $('#mask1').attr('action'),
			name: 'userfile',
			onSubmit: function(file, extension) {
				thumb.attr('width', "30px");
				thumb.attr('height', "30px");
				thumb.attr('src', "<?=base_url()?>images/" + "loading.gif");
				$('form input:submit').attr('disabled',true);
			},
			onComplete: function(file, response) {
				thumb.attr('width', "150px");
				thumb.attr('height', "150px");
				thumb.attr('src', $('#upload_image_folder').val() + "/" + response);
				$('#upload_image').val(response);
				$('form input:submit').attr('disabled',false);
			}
		});
*/		
	});

//	$('form#form_id input:text, form#form_id input:password, form#form_id textarea').click(function(){
//		var $this = $(this);
//		var val = $this.val();
//		if(val == $this.attr('alt')){
//			if($this.attr('id') == 'layer-password_id' || $this.attr('id') == 'layer-repassword_id'){
//				$this.hide();
//				$('#'+$this.attr('id').substr(6)).show().val('').focus();
//			}else{
//				$this.val('');
//			}
//		}
//	});
//	
//	$('form#form_id input:not(.submitbox)').on('focus,change',function(){
//		var $this = $(this);
//		var x = $this.offset().left + $this.width(), y = $this.offset().top + $this.height();
//		$('#tooltips .content').html($this.attr('alt'));
//		$('#tooltips').css({
//			top: y - $('#tooltips').height()/2,
//			left: x + 14,
//			display: 'block'
//		}).show(500);
//	});
//	
//	$('form#form_id input:text, form#form_id input:password').blur(function(){
//		$('#tooltips').hide(200);
//		var $this = $(this);
//		var val = $this.val();
//		if(val == ''){
//			if($this.attr('type') == 'password'){
//				$this.hide();
//				$('#layer-'+$this.attr('id')).show().val($this.attr('alt'));
//			}else{
//				$this.val($this.attr('alt'));
//			}
//		}
//	});
//	$('form#form_id input:text, form#form_id input:password').each(function(){
//		var $this = $(this);
//		var val = $this.val();
//		if(val == ''){
//			if($this.attr('type') == 'password'){
//				$this.hide();
//				$('#layer-'+$this.attr('id')).show().val($this.attr('alt'));
//			}else{
//				$this.val($this.attr('alt'));
//			}
//		}
//	});

})(jQuery);

</script>