<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>TradeOffice</title>
		<?=link_tag('css/reset.css')?>
        <?=link_tag('css/style.css')?>
		<?=link_tag('css/jquery.selectbox.css')?>
	
        <script type="text/javascript" src="<?=base_url()?>js/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>js/jquery-ui-1.8.18.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>js/jquery.ui.widget.js"></script>
        <script type="text/javascript" src="<?=base_url()?>js/ui.checkbox.js"></script>
        <script type="text/javascript" src="<?=base_url()?>js/jquery.selectbox-0.1.3.min.js"></script>
		<script type="text/javascript" src="<?=base_url()?>js/jquery.validate.js"></script>
        <script type="text/javascript">
            $(function(){
                $('.registration_edm_link input').checkBox();
            });
			$(document).ready(function() { 
				$("#form_id").validate({
					 rules: {
						lastname : {
							required:true,
			            },
						password : {
							required:true,
							minlength: 6
						},
						repassword : {
							required:true,
							minlength: 6,
							pass:true
						},
			            email: {
							required:true,
							minlength: 6,
							email:true
						},
						company: {
							required:true
						},
						agreement: {
							required:true
						}
						
					 }
				});
				
				$.validator.addMethod('email', function(value, element, param){
					var pattern=/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
					if(pattern.test(value))
			            return true;
			        return false;
				});
				
				$.validator.addMethod("pass", function(value, element){
					if($('#password_id').val() == $('#repassword_id').val())
			            return true;
			        return false;
				},"Please enter Re Passwprd equals Password.");

				$("#submit_id").click(function(){
					var valid = $("#form_id").valid();
					if(valid)
						$("#form_id").submit();
				});
			});
			
			
        </script>
    </head>

    <body class="splash">
        <div class="popup"></div>


        <div class="registration_edm_link">
            <div class="close"></div>
            <h1>Register a Beta Account</h1>
            
               <?php echo form_open_multipart('invite/step2','id="form_id"'); ?>
                    <div class="registration_edm_link_first_colomn">
                        <h2>Enter your Details:</h2>
                        <div class="split_inputs" style="margin-bottom: 15px;">
                            <p>First Name *  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Last Name *</p>
							<input type="text" name="firstname" class="registration_input small" />
                            <input type="text" name="lastname" class="registration_input small" style="border-left:none; width:144px;"/>
                        </div>
						<div style="margin-bottom: 15px;">
							<p>Email *</p>
							<input type="text" name="email" class="registration_input" />
						</div>
						<div style="margin-bottom: 15px;">
							<p>Create Password *</p>
							<input type="password" id="password_id" name="password" class="registration_input" />
						</div>
						<div style="margin-bottom: 15px;">
							<p>Re-Enter Password *</p>
							<input type="password" id="repassword_id" name="repassword" class="registration_input" />
						</div>
						<div style="margin-bottom: 15px;">
							<p>Company Name *</p>
							<input type="text" name="company" class="registration_input" />
						</div>	
                        
                        <small>* Indicates Manditory Fields</small>
                    </div>

                    <div class="registration_edm_link_second_colomn">
                        <h2>Upload your Own Products & Details:</h2>
                        <div class="files_upload_block">
                            <input type="file" name="userfile" class="files_upload_input" />
  <!--                          <div id="files_upload_mask">
                                <div class="pdf"></div>
                                <input type="file" class="files_upload_input" />
                            </div>

                            <div id="files_upload_mask">
                                <div class="xls"></div>
                                <input type="file" class="files_upload_input" />
                            </div>
                            
                            <div id="files_upload_mask">
                                <div class="doc"></div>
                                <input type="file" class="files_upload_input" />
                            </div>
                            
                            <div id="files_upload_mask">
                                <div class="txt"></div>
                                <input type="file" class="files_upload_input" />
                            </div>
                          
                        </div>
                        
                        <div id="files_upload_progress_bar">
                            <p>50%</p>
                            <div class="progress_bar">
                                <div class="progress_bar_percent">
                                    
                                </div>
                            </div>
                        </div>
                        
                        <div class="files_upload_cancel"></div>  -->
						</div>
                        
                        <small style="clear:both; display:block; margin-bottom:20px;">*  Max 50Mb Pdf, Doc, Excel, Txt, Zip file only</small>
                        
                        <h2>Grab Details from an external site:</h2>
                        <div class="checkbox_block">
                            <input name="source[]" type="checkbox" value="alibaba" checked/>
                            <label>Alibaba.com</label>
                        </div>
                        <div class="checkbox_block">
                            <input name="source[]" type="checkbox" value="ec21" checked/>
                            <label>EC21.com</label>
                        </div>
                        <div class="checkbox_block">
                            <input name="source[]" type="checkbox" value="tradekey" checked/>
                            <label>Tradekey.com</label>
                        </div>
                        <p><input id="submit_id" value="		CREATE MY ACCOUNT" class="submit" /></p>
                        <input type="checkbox" name="agreement"><small style="text-align:center; display:block;">I agree to give Tradeoffice Pty Ltd the rights to use my details and store information on behalf of me the account holder.</small>
                    </div>
                <?php echo form_close() ?>
                <div class="clear"></div>

            </div>

        


























        <!-- HEADER -->
        <div id="header">
            <div class="wrapper">
                <!-- LOGO -->
                <div class="logo splash_logo">
                    <a href="#"></a>
                </div>
                <!-- End Logo -->
            </div>
        </div>
        <!-- End Header -->

        <!-- CONTENT -->
        <div id="content" class="splash_content">
            <img src="images/splash_map.jpg" width="100%" />

        </div>
        <!-- End Content -->

        <!-- FOOTER -->
        <div id="footer" class="splash_footer">
            <div class="wrapper">

            </div>
        </div>
        <!-- End Footer -->
    </body>
</html>
