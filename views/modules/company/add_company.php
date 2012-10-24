<!-- not used any more -->


<?php
//    exit('asd');
?>

<!-- CONTENT -->
    <div id="content">
    	<div class="wrapper">
        	
            <!-- PRODUCT TABS -->
            <div id="office_tabs_block">
			<?php $this->load->view('modules/company/tabs_nav',array('selectedPage'=>'My Company')); ?>
                <div id="office_tabs_content">
                	<div class="my_office_buyer_page">
                    	<div class="left">
                        	<h2>Manage Company</h2>
                            <p class="online_offline"><a href="#" class="green">Online</a> - <a href="#">Offline</a></p>
                            <ul>
                            	<li class="active"><a href="#">Post Buying<br /> Request</a></li>
                                <li><a href="#">Manage Buying<br /> Request</a></li>
                                <li><a href="#">Manage Requests<br /> for Quotations</a></li>
                                <li><a href="#">Manage Sample<br /> Request</a></li>
                            </ul>
                            <div class="support">
                            	<p class="head_text">Support</p>
                                <p>Jaqueline is <span>Online</span></p>
                            </div>
                            <form action="">
                            	<textarea cols="" rows="" onfocus="if(this.value=='eg... Ask me a question?') this.value='';" onblur="if(!this.value) this.value='eg... Ask me a question?';" >eg... Ask me a question?</textarea>
                                <input type="submit" value="Ask" />
                            </form>
                        </div>
                        <?php echo form_open_multipart('company/do_addcompany','',''); ?>  
                            <div class="middle">
                                    <h2>Edit Company Profile</h2>
                                    <?php if(isset($error)): ?>
                                        <h1 style="color:red;"><?php echo $error; ?></h1><br />
                                    <?php endif; ?>
                                <h2>Company Details:</h2>
                                <form action="">
                                    <p><input name="name" type="text" value="Company Name *" class="my_office_buyer_input" onfocus="if(this.value=='Company Name *') this.value='';" onblur="if(!this.value) this.value='Company Name *';"/></p>
                                    <p><input name="address" type="text" value="Street Address" class="my_office_buyer_input" onfocus="if(this.value=='Street Address') this.value='';" onblur="if(!this.value) this.value='Street Address';"/></p>
                                    <p><input name="city" type="text" value="City" class="my_office_buyer_input" onfocus="if(this.value=='City') this.value='';" onblur="if(!this.value) this.value='City';"/></p>
                                    <div class="select">
                                        <select id="select2" name="country">
                                            <option>Country</option>
                                            <?php foreach ($countries as $country): ?>
                                            <option><?php echo $country['name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <p><input name="state" type="text" value="State" class="my_office_buyer_input small" onfocus="if(this.value=='State') this.value='';" onblur="if(!this.value) this.value='State';"/>
                                    <input name="zip" type="text" value="Zip Code" class="my_office_buyer_input small" onfocus="if(this.value=='Zip Code') this.value='';" onblur="if(!this.value) this.value='Zip Code';"/></p>

                                    <hr />

                                    <h2>Contact Address:</h2>
                                    <p class="head_text"><input name="contact_check" type="checkbox" /><label> Same as Above</label></p>
<!--                                    <p><input name="contact_name" type="text" value="Company Name *" class="my_office_buyer_input" onfocus="if(this.value=='Company Name *') this.value='';" onblur="if(!this.value) this.value='Company Name *';"/></p>-->
                                    <p><input name="contact_address" type="text" value="Street Address" class="my_office_buyer_input" onfocus="if(this.value=='Street Address') this.value='';" onblur="if(!this.value) this.value='Street Address';"/></p>
                                    <p><input name="contact_city" type="text" value="City" class="my_office_buyer_input" onfocus="if(this.value=='City') this.value='';" onblur="if(!this.value) this.value='City';"/></p>
                                    <div class="select">
                                        <select name="contact_country" id="select3">
                                            <option>Country</option>
                                            <?php foreach ($countries as $country): ?>
                                            <option><?php echo $country['name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <p><input name="contact_state" type="text" value="State" class="my_office_buyer_input small" onfocus="if(this.value=='State') this.value='';" onblur="if(!this.value) this.value='State';"/>
                                    <input name="contact_zip" type="text" value="Zip Code" class="my_office_buyer_input small" onfocus="if(this.value=='Zip Code') this.value='';" onblur="if(!this.value) this.value='Zip Code';"/></p>

                                    <hr />

                                    <h2>Business Type:</h2>
                                    <ul class="checkboxes_list">
                                        <?php foreach ($businessType as $bt):  ?>
                                            <li><input name="business_types" type="radio" value="<?php echo $bt['id']; ?>" /><label><?php echo $bt['name']; ?></label></li>
                                        <?php endforeach; ?>
                                    </ul>

                                    <hr />

                                    <h2>Products or Services - We Sell:</h2>
                                    <p><input name="sell_product" type="text" value="List Items/Services *" class="my_office_buyer_input" onfocus="if(this.value=='List Items/Services *') this.value='';" onblur="if(!this.value) this.value='List Items/Services *';"/></p>
                                    <h2>Contract Manufacturing:</h2>
                                    <ul class="checkboxes_list">
                                        <li><input type="checkbox" name="services[]" value="1" /><label>OEM Service</label></li>
                                        <li><input type="checkbox" name="services[]" value="2" /><label>Design Service</label></li>
                                        <li><input type="checkbox" name="services[]" value="3" /><label>Buyer Label Offered</label></li>
                                    </ul>

                                    <hr />

                                    <h2>Company Information:</h2>
                                    <p><input name="year" type="text" value="Year Registered" class="my_office_buyer_input small" onfocus="if(this.value=='Year Registered') this.value='';" onblur="if(!this.value) this.value='Year Registered';"/>
                                    <input name="no_employee" type="text" value="No. Employees" class="my_office_buyer_input small" onfocus="if(this.value=='No. Employees') this.value='';" onblur="if(!this.value) this.value='No. Employees';"/></p>
                                    <p><input name="brand" type="text" value="List Brands *" class="my_office_buyer_input" onfocus="if(this.value=='List Brands *') this.value='';" onblur="if(!this.value) this.value='List Brands *';"/></p>
                                    <p><input name="ownership_type" type="text" value="Ownership Type*" class="my_office_buyer_input" onfocus="if(this.value=='Ownership Type*') this.value='';" onblur="if(!this.value) this.value='Ownership Type*';"/></p>
                                    <p><input name="registered_capital" type="text" value="Registered Capital*" class="my_office_buyer_input" onfocus="if(this.value=='Registered Capital*') this.value='';" onblur="if(!this.value) this.value='Registered Capital*';"/></p>
                                    <p><input name="owner" type="text" value="Legal Owner *" class="my_office_buyer_input" onfocus="if(this.value=='Legal Owner *') this.value='';" onblur="if(!this.value) this.value='Legal Owner *';"/></p>

                                    <hr />

                                    <h2>Production &amp; Markets:</h2>
                                    <p><input name="annual_sale" type="text" value="Annual Sales Volume" class="my_office_buyer_input small" onfocus="if(this.value=='Annual Sales Volume') this.value='';" onblur="if(!this.value) this.value='Annual Sales Volume';"/></p>
                                    <p><input name="export_per" type="text" value="Export Percentage" class="my_office_buyer_input small" onfocus="if(this.value=='Export Percentage') this.value='';" onblur="if(!this.value) this.value='Export Percentage';"/></p>
                                    <h2>Main Markets:</h2>
                                    <ul class="checkboxes_list">
                                        <li><input type="checkbox" name="regions[]" value="1" /><label>North America</label></li>
                                        <li><input type="checkbox" name="regions[]" value="2" /><label>South America</label></li>
                                        <li><input type="checkbox" name="regions[]" value="3" /><label>Eastern Europe</label></li>
                                        <li><input type="checkbox" name="regions[]" value="4" /><label>Africa</label></li>
                                        <li><input type="checkbox" name="regions[]" value="5" /><label>Southeast Asia</label></li>
                                        <li><input type="checkbox" name="regions[]" value="6" /><label>Oceania</label></li>
                                        <li><input type="checkbox" name="regions[]" value="7" /><label>Middle East	</label></li>
                                        <li><input type="checkbox" name="regions[]" value="8" /><label>East Asia</label></li>
                                        <li><input type="checkbox" name="regions[]" value="9" /><label>Western Europe</label></li>
                                        <li><input type="checkbox" name="regions[]" value="10" /><label>Northern Europe</label></li>
                                        <li><input type="checkbox" name="regions[]" value="11" /><label>South Europe</label></li>
                                        <li><input type="checkbox" name="regions[]" value="12" /><label>South Asia</label></li>
                                    </ul>
                                    <p><input name="customer" type="text" value="List Main Customers *" class="my_office_buyer_input" onfocus="if(this.value=='List Main Customers *') this.value='';" onblur="if(!this.value) this.value='List Main Customers *';"/></p>

                                    <hr />

                                    <h2>Company Certification:</h2>
                                    <ul class="checkboxes_list">
                                        <li><input type="checkbox" name="certifications[]" value="1" /><label>HACCP</label></li>
                                        <li><input type="checkbox" name="certifications[]" value="2" /><label>ISO 9001:2000</label></li>
                                        <li><input type="checkbox" name="certifications[]" value="3" /><label>ISO 9001:2008</label></li>
                                        <li><input type="checkbox" name="certifications[]" value="4" /><label>QS-90000</label></li>
                                        <li><input type="checkbox" name="certifications[]" value="5" /><label>ISO14001:2004</label></li>
                                        <li><input type="checkbox" name="certifications[]" value="6" /><label>ISO/TS 16949</label></li>
                                        <li><input type="checkbox" name="certifications[]" value="7" /><label>SA8000</label></li>
                                        <li><input type="checkbox" name="certifications[]" value="8" /><label>ISO 17799</label></li>
                                        <li><input type="checkbox" name="certifications[]" value="9" /><label>OHSAS 18001</label></li>
                                        <li><input type="checkbox" name="certifications[]" value="10" /><label>TL 9000</label></li>
                                    </ul>

                                    <hr />

                                    <h2>Facory Details:</h2>
                                    <p><input name="factory_location" type="text" value="Factory Location *" class="my_office_buyer_input" onfocus="if(this.value=='Factory Location *') this.value='';" onblur="if(!this.value) this.value='Factory Location *';"/></p>
                                    <p><input name="factory_size" type="text" value="Factory Size" class="my_office_buyer_input small" onfocus="if(this.value=='Factory Size') this.value='';" onblur="if(!this.value) this.value='Factory Size';"/>
                                    <input name="factory_productionline" type="text" value="Production Lines" class="my_office_buyer_input small" onfocus="if(this.value=='Production Lines') this.value='';" onblur="if(!this.value) this.value='Production Lines';"/>
                                    <input name="factory_purchase" type="text" value="Purchase Volume" class="my_office_buyer_input small" onfocus="if(this.value=='Purchase Volume') this.value='';" onblur="if(!this.value) this.value='Purchase Volume';"/>
                                    <input name="factory_qc" type="text" value="Quality Control" class="my_office_buyer_input small" onfocus="if(this.value=='Quality Control') this.value='';" onblur="if(!this.value) this.value='Quality Control';"/>
                                    <input name="factory_no_staff" type="text" value="No. Staff" class="my_office_buyer_input small" onfocus="if(this.value=='No. Staff') this.value='';" onblur="if(!this.value) this.value='No. Staff';"/>
                                    <input name="factory_no_qc" type="text" value="No. QC Staff" class="my_office_buyer_input small" onfocus="if(this.value=='No. QC Staff') this.value='';" onblur="if(!this.value) this.value='No. QC Staff';"/>
                                    </p>

                                    <hr />

                                    <div id="file_input_img">* Maximum 2MB</div>
                                    <div id="mask1">
                                        <div class="mask_button1">Upload Image</div>
                                        <input name="userfile" type="file" id="fileInput1" />
                                    </div>
                                    <p><textarea name="product_keyword" cols="" rows="" onfocus="if(this.value=='Product Keywords *') this.value='';" onblur="if(!this.value) this.value='Product Keywords *';" style="height:150px;">Product Keywords *</textarea></p>
                                    <p class="small">* Maximum 2000 Characters</p>
                                    <p style="margin-bottom:30px;"><input name="website" type="text" value="Company Website *" class="my_office_buyer_input" onfocus="if(this.value=='Company Website *') this.value='';" onblur="if(!this.value) this.value='Company Website *';"/></p>
                                    <div class="submit_block">
                                        <input type="submit" value="Submit" class="submit" />
                                        <input type="button" value="Preview" class="preview" />
                                    </div>
                                    <p class="head_text"><input type="checkbox" /><label>I have read and accept the <a href="#">Terms</a> and <a href="#">Conditions</a> of XXXXXX. </label></p>
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