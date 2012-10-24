<!DOCTYPE html>
<html lang="en">
<head>
	<title>Trade with the World</title>
</head>
<script language="javascript" src="<?php echo base_url(); ?>js/jquery-1.7.2.min.js"></script>
<link type="text/css" href="<?php echo base_url(); ?>css/jquery-ui-1.8.20.custom.css" rel="Stylesheet" />
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-ui-1.8.20.custom.min.js"></script>
<script>
	$(document).ready( function(){
		var options = {
			dateFormat: "yy-mm-dd",
			changeYear: true
		}
		$('.datepicker').datepicker(options);
		
		
	});
	
	
	
</script>


<body>
<p><?php echo anchor('admin/home','Home'); ?></p>
    <h2>Edit this user's profile  </h2>
      
    <?php echo form_open('admin/user/do_edit','',$hidden); ?>
    <fieldset>
	<legend>Select his Business Location & Account Type</legend><p></p>
	<table>
	    <tr>
		    <th><label for="location">Business Location:</label></th>
	            <td><?php echo form_dropdown('location', $country_options, $location);?> </td>
	    </tr>
	    <tr>
            <th><label for="role">I am a :</label></th>
            <td><strong><?php echo form_checkbox('role1', 'buyer', $role1).'buyer'
				.form_checkbox('role2', 'seller', $role2).'seller';?></strong></td>
        </tr>
    </table>
    </fieldset>
    
    <fieldset>
    <legend>Enter your Contact Information</legend>
    <table>
	<tr>
            <th><label for="username">Name:</label></th>
            <td><input type="text" id="firstname_id" name="firstname" value="<?php echo $firstname ?>" />
		<input type="text" id="lastname_id" name="lastname" value="<?php echo $lastname ?>" /></td>
	</tr>
	<tr>
            <th><label for="company">Company Name:</label></th>
            <td><input type="text" id="company_id" name="company" value="<?php echo $company ?>" /></td>
	</tr>
	<tr>
            <th><label for="phone">Tel:</label></th>
            <td><input type="text" id="phone_country_id" style='width: 50px' name="phone_country" value="<?php echo $phone_country ?>"/>
		-- <input type="text" id="phone_area_id" name="phone_area" value="<?php echo $phone_area ?>"/>
		-- <input type="text" id="phone_number_id" name="phone_number" value="<?php echo $phone_number ?>"/>
		<div class="hint"> e.g. 12 - 345 - 67890</div></td>
	</tr>
      </table>
      </fieldset>
    
	<fieldset>
		<legend>Edit user's status</legend>
		<table>
			<tr>
				<th>Status</th>
				<td><?php echo form_dropdown('status', $status_options, $status);?> </td>
			</tr>
		</table>
	</fieldset>
	
	<fieldset>
		<legend>Edit user's membership</legend>
		<table>
			<tr>
				<th>Trade Pass</th>
				<td><?php echo form_dropdown('membership[]', $membership_options, $is_tradepass);?> </td>
			</tr>
                        <tr>
				<th>Assessed</th>
				<td><?php echo form_dropdown('membership[]', $membership_options, $is_assessed);?> </td>
			</tr>
			<tr><td>Leave these field blank if user's is not a Trade Pass </td></tr>
			<tr>
				<td>Start: <input name="membership_start" class="datepicker" type="text" value="<?php echo $membership['start_date'] ?>"></td>
				<td>End: <input name="membership_end" class="datepicker" type="text" value="<?php echo $membership['end_date'] ?>"></td>
			</tr>
		</table>
	</fieldset>
      
      <fieldset>
    <legend>Enter your Email Address & Create a Password</legend>
    <table>
	<tr>
            <th><label for="email">Email:</label></th>
            <td><?php echo $email ?></td>
        </tr>
        <tr>
	    <td></td>	
	    <td><input type="submit" value="Update My Account"/></td>
        </tr>
    </table>
    
    
    <?php echo form_close() ?>
</body>
</html>