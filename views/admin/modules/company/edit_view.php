<!DOCTYPE html>
<html lang="en">
<head>
	<title></title>
</head>
<body>
	    <p><?php echo anchor('admin/home','Home'); ?></p>



    <p>Please complete the blank fields below to setup your company profile first. </p>
    
    <?php echo form_open_multipart('admin/company/do_updatecompany',"",$hidden); ?>
   
    <fieldset>
	<legend>Update Company Detail   (can add DB, not validation)</legend><p></p>
	<table>
		<tr>
		    <th><label for="name">Company Name:</label></th>
	            <td><input type="text" id="name_id" name="name" value="<?php echo $name;?>" /></td>
		    <td><?php echo form_error('name'); ?></td>
		</tr>
		<tr>
		    <th><label for="name">Address:</label></th>
	            <td><input type="text" id="address_id" name="address" value="<?php echo $address; ?>" /></td>
		    <td><?php echo form_error('address'); ?></td>
		</tr>
		<tr>
		    <th><label for="name">City:</label></th>
	            <td><input type="text" id="city_id" name="city" value="<?php echo $city; ?>" /></td>
		    <td><?php echo form_error('city'); ?></td>
		</tr>
		<tr>
		    <th><label for="name">State:</label></th>
	            <td><input type="text" id="state_id" name="state" value="<?php echo $state; ?>" /></td>
		    <td><?php echo form_error('state'); ?></td>
		</tr>
		<tr>
		    <th><label for="name">Country:</label></th>
	            <td><?php echo form_dropdown('country', $country_options, $country);?></td>
		    <td><?php echo form_error('country'); ?></td>
		</tr>
		<tr>
		    <th><label for="name">Zip:</label></th>
	            <td><input type="text" id="zip_id" name="zip" value="<?php echo $zip; ?>" /></td>
		    <td><?php echo form_error('zip'); ?></td>
		</tr>
		<tr>
		    <th><label for="name">Telphone:</label></th>
	            <td><input type="text" id="tel_id" name="tel" value="<?php echo $tel; ?>" /></td>
		    <td><?php echo form_error('tel'); ?></td>
		</tr>
		<tr>
		    <th><label for="name">Mobile:</label></th>
	            <td><input type="text" id="mobile_id" name="mobile" value="<?php echo $mobile; ?>" /></td>
		    <td><?php echo form_error('mobile'); ?></td>
		</tr>
		<tr>
		    <th><label for="name">Website:</label></th>
	            <td><input type="text" id="website_id" name="website" value="<?php echo $website; ?>" /></td>
		    <td><?php echo form_error('website'); ?></td>
		</tr>
		<tr>
		    <th><label for="name">Info:</label></th>
	            <td><textarea id="info_id" name="info"><?php echo $info; ?></textarea></td>
		    <td><?php echo form_error('info'); ?></td>
		</tr>
    </table>
    </fieldset>
      
	    <td><input id="submit_id" type="submit" value="Update Company"/></td>
 
    
    <?php echo form_close() ?>
    

</body>
</html>