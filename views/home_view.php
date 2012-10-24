<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body{
		margin: 0 15px 0 15px;
	}
	
	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	
	#container{
		margin: 10px;
		border: 1px solid #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
	
<script language="javascript" src="<?php echo base_url(); ?>js/jquery-1.7.2.min.js"></script>
<link type="text/css" href="<?php echo base_url(); ?>css/jquery-ui-1.8.20.custom.css" rel="Stylesheet" />
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-ui-1.8.20.custom.min.js"></script>
<script>
        $(document).ready( function(){       
            $("#myButton").click(function(){
		$('#myDiv').dialog({
			 modal: true,

                        autoOpen:false,
                        title:'Share Your Comments or Suggestions',
                        overlay: { opacity: 0.7, background: 'black'}
                        });
		$('#myDiv').dialog("open");
	    });
	    
	    $(".submit-btn").click(function(){
		$('#myDiv').html('Contragulation, your feedback has been submitted');
	    });
        });

</script>

</head>
<body>

<div id="container">
	<h1>Welcome to User Page</h1>

	<div id="body">
		<fieldset>
			<legend>This is <?php echo $firstname; ?>'s home page.</legend>
				<?php if($status == 'actived'): ?>
					<p>Congratulation, you are already an actived user.<p>
					<?php echo anchor('login/change_password','Change My Password')."<br/>"; ?>
					<?php echo anchor('user/editprofile','Edit My Profile')."<br/>"; ?>
					<?php echo anchor('user/upgrade','Upgrade my account')."<br/>";?>
					<?php echo anchor('favorite/home','My Favorite')."<br/>";?>
                                        <?php if($company):
                                                echo anchor('company/add/'.$company,'View My Company');
                                              endif;
                                        ?>
					<?php /*if($company_id == 0):
							echo anchor('company/add','Add Company');
						else:	
							echo anchor('company/add/'.$company_id,'Update My Company')."<br/>";
							echo anchor('company/show/'.$company_id,'View My Company');
						endif;*/
					?><br />
					<?php echo anchor('help/safety_security','Security Info')."<br/>";?>
                                        <?php if($role="both"): ?>
                                            <?php echo anchor('request/buy','Buying')."<br/>";?>
                                            <?php echo anchor('product','Selling')."<br/>";?>
                                        <?php elseif($role="buyer"): ?>
                                            <?php echo anchor('request/buy','Buying')."<br/>";?>
                                        <?php elseif($role="seller"): ?>
                                            <?php echo anchor('product','Selling')."<br/>";?>
                                        <?php endif?>
				<?php elseif($status == 'banned'): ?>
					You are banned
				<?php else: ?>
					In order to enjoy our service, Please check your email or click
					<?php echo anchor('register/verify/'.$verifycode,'here') ?>
					to verify your account.
				<?php endif; ?>
		</fieldset>
		<?php echo form_open('search'); ?>
		<fieldset>
			<legend>Search</legend>
			<table>
				<tr>
					<td><input name="keyword" /></td>
					<td><select name="search_type">
						<option value="user">User</option>
						<option value="company">Company</option>
						<option value="product">Product</option>
					</select></td>
					<td><input type="submit" value="search" /></td>
				</tr>
			</table>
		</fieldset>
		<?php echo form_close() ?>
		
		
	</div>

	<div>
		<p><?php echo anchor('home/logout','Log Out'); ?></p>
	
</div>
					<div style="position:fixed;width: 100%;">
						<div style="float: right; margin-right: 60px;margin-top: 40px;">
					<input id="myButton" name="myButton" value="Suggestion" type="button" />
					</div>
					</div>	
	
	
	
<div id="myDiv" style="display:none">
<p class="popup-header">Please tell us how we can be better. If you use this form to ask question, we won't be able to respond.
For help, please contact Customer Support.</p>
<textarea class="suggestion"></textarea>
<div class="popup-info">Your feedback will appear in our Suggestion Center.
</div>
<input type="button" value="Submit" class="submit-btn">    
</div>	

</body>
</html>