<!-- not used anymore -->


<!DOCTYPE html>
<html lang="en">
<head>
	<title></title>
</head>
<body>
	    <p><?php echo anchor('home','Home'); ?></p>
    <h2>Edit Company Profile</h2>
   
    <?php echo form_open_multipart('company/do_updatecontact','',$hidden); ?>
   
    <fieldset>
	<legend>Contact Details</legend><p></p>
	<table>
		<tr>
		    <th>Company Name:</th>
	            <td><input name="name" value="<?php echo $company['name']; ?>" /></td>
		</tr>
		<tr>
		    <th>Street Address:</label></th>
	            <td><input name="address" value="<?php echo $company['address']; ?>" /></td>
		</tr>
		<tr>
		    <th>City:</th>
	            <td><input name="city" value="<?php echo $company['city']; ?>" /></td>
		</tr>
		<tr>
		    <th>Country:</th>
	            <td><?php echo form_dropdown('country', $country_options, $company['country']);?></td>
		</tr>
		<tr>
		    <th>State:</th>
	            <td><input name="state" value="<?php echo $company['state']; ?>" /></td>
		    <th>Zip:</th>
	            <td><input name="zip" value="<?php echo $company['zip']; ?>" /></td>
		</tr>
    </table>
    </fieldset>
    <br /><br />
    <fieldset>
	<legend>Contact Details</legend><p></p>
	<input type="checkbox" name="contact_check" /> Same as Above
	<table>
		<tr>
		    <th>Company Name:</th>
	            <td><input name="contact_name" value="<?php echo $company['contact_name']; ?>" /></td>
		</tr>
		<tr>
		    <th>Street Address:</label></th>
	            <td><input name="contact_address" value="<?php echo $company['contact_address']; ?>" /></td>
		</tr>
		<tr>
		    <th>City:</th>
	            <td><input name="contact_city" value="<?php echo $company['contact_city']; ?>" /></td>
		</tr>
		<tr>
		    <th>Country:</th>
	            <td><?php echo form_dropdown('contact_country', $country_options, $company['contact_country']);?></td>
		</tr>
		<tr>
		    <th>State:</th>
	            <td><input name="contact_state" value="<?php echo $company['contact_state']; ?>" /></td>
		    <th>Zip:</th>
	            <td><input name="contact_zip" value="<?php echo $company['contact_zip']; ?>" /></td>
		</tr>
	</table>
    </fieldset>
<br /><br />
    <fieldset>
	<legend>Business Type</legend>
	<?php foreach($business_type_options as $item): ?>
		<?php echo form_checkbox('business_types[]', $item['id'], $item['checked']).$item['name']; ?>
	<?php endforeach;?>
    </fieldset>
<br /><br />
    <fieldset>
	<legend>Products or Services - We Sell:</legend>
	List Items/Services <input name="sell_product" value="<?php echo $company['sell_product']; ?>" /><br />
	<?php foreach($service_options as $item): ?>
		<?php echo form_checkbox('services[]', $item['id'], $item['checked']).$item['name']; ?>
	<?php endforeach;?>
    </fieldset>
<br /><br />
    <fieldset>
	<legend>Company Information:</legend>
	Year Registered  <input name="year" value="<?php echo $company['year']; ?>" />
	No. Employees  <input name="no_employee" value="<?php echo $company['no_employee']; ?>" /> <br />
	List Brands <input name="brand" value="<?php echo $company['brand']; ?>" /><br />
	Ownership Type <input name="ownership_type" value="<?php echo $company['ownership_type']; ?>" /><br />
	Registered Capital <input name="registered_capital" value="<?php echo $company['registered_capital']; ?>" /><br />
	Legal Owner <input name="owner" value="<?php echo $company['owner']; ?>" />
    </fieldset>
<br /><br />
    <fieldset>
	<legend>Production & Markets:</legend>
	Annual Sales Volume <input name="annual_sale" value="<?php echo $company['annual_sale']; ?>" /> <br />
	Export Percentage <input name="export_per" value="<?php echo $company['export_per']; ?>" /> <br />
	<?php foreach($region_options as $item): ?>
		<?php echo form_checkbox('regions[]', $item['id'], $item['checked']).$item['name']; ?>
	<?php endforeach;?>
	<br />
	List Main Customers <input name="customer" value="<?php echo $company['customer']; ?>" />
    </fieldset>
<br /><br />
    <fieldset>
	<legend>Company Certification</legend>
	<table>
		<?php foreach($certification_options as $item): ?>
			<?php echo form_checkbox('certifications[]', $item['id'], $item['checked']).$item['name']; ?>
		<?php endforeach;?>
	</table>
    </fieldset>
<br /><br />
    
    <fieldset>
	<legend>Factory Details:</legend>
	Factory Location <input name="factory_location" value="<?php echo $company['factory_location']; ?>" /> <br />
	Factory Size <input name="factory_size" value="<?php echo $company['factory_size']; ?>" />
	Production Lines <input name="factory_productionline" value="<?php echo $company['factory_productionline']; ?>" />
	Purchase Volume <input name="factory_purchase" value="<?php echo $company['factory_purchase']; ?>" />
	Quality Control <input name="factory_qc" value="<?php echo $company['factory_qc']; ?>" /> <br />
	No.Staff <input name="factory_no_staff" value="<?php echo $company['factory_no_staff']; ?>" />
	No. QC Staff <input name="factory_no_qc" value="<?php echo $company['factory_no_qc']; ?>" />
    </fieldset>    
    
    
    
    <fieldset>
	<legend>Update Contact Detail   (can add DB)</legend>
	<input type="file" name="userfile" size="20" />
	Product Keywords<textarea name="product_keyword"><?php echo $company['product_keyword']; ?></textarea>
	Company Website <input name="website" value="<?php echo $company['website']; ?>" />
     </fieldset>
      
 

     <input  type="submit" value="Submit"/>
     <input  type="button" value="Preview"/><br />
     <input type="checkbox" /> I have read and accept the Terms and Conditions of XXXXXXX
    <?php echo form_close() ?>
</body>
</html>