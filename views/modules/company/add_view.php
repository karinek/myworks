<!-- not used anymore -- >

<!DOCTYPE html>
<html lang="en">
<head>
	<title></title>
</head>
<body>
	    <p><?php echo anchor('home','Home'); ?></p>
    <h2>Edit Company Profile</h2>
   
    <?php echo form_open_multipart('company/do_addcompany','',$hidden); ?>
   
    <fieldset>
	<legend>Contact Details</legend><p></p>
	<table>
		<tr>
		    <th>Company Name:</th>
	            <td><input name="name" /></td>
		</tr>
		<tr>
		    <th>Street Address:</label></th>
	            <td><input name="address" /></td>
		</tr>
		<tr>
		    <th>City:</th>
	            <td><input name="city" /></td>
		</tr>
		<tr>
		    <th>Country:</th>
	            <td><?php echo form_dropdown('country', $country_options);?></td>
		</tr>
		<tr>
		    <th>State:</th>
	            <td><input name="state" /></td>
		    <th>Zip:</th>
	            <td><input name="zip" /></td>
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
	            <td><input name="contact_name" /></td>
		</tr>
		<tr>
		    <th>Street Address:</label></th>
	            <td><input name="contact_address" /></td>
		</tr>
		<tr>
		    <th>City:</th>
	            <td><input name="contact_city" /></td>
		</tr>
		<tr>
		    <th>Country:</th>
	            <td><?php echo form_dropdown('contact_country', $country_options);?></td>
		</tr>
		<tr>
		    <th>State:</th>
	            <td><input name="contact_state" /></td>
		    <th>Zip:</th>
	            <td><input name="contact_zip" /></td>
		</tr>
	</table>
    </fieldset>
<br /><br />
    <fieldset>
	<legend>Business Type</legend>
	<?php foreach($business_type_options as $item): ?>
		<?php echo form_checkbox('business_types[]', $item['id']).$item['name']; ?>
	<?php endforeach;?>
    </fieldset>
<br /><br />
    <fieldset>
	<legend>Products or Services - We Sell:</legend>
	List Items/Services <input name="sell_product" /><br />
	<?php foreach($service_options as $item): ?>
		<?php echo form_checkbox('services[]', $item['id']).$item['name']; ?>
	<?php endforeach;?>
    </fieldset>
<br /><br />
    <fieldset>
	<legend>Company Information:</legend>
	Year Registered  <input name="year" />
	No. Employees  <input name="no_employee" /> <br />
	List Brands <input name="brand" /><br />
	Ownership Type <input name="ownership_type" /><br />
	Registered Capital <input name="registered_capital" /><br />
	Legal Owner <input name="owner" />
    </fieldset>
<br /><br />
    <fieldset>
	<legend>Production & Markets:</legend>
	Annual Sales Volume <input name="annual_sale" /> <br />
	Export Percentage <input name="export_per" /> <br />
	<?php foreach($region_options as $item): ?>
		<?php echo form_checkbox('regions[]', $item['id']).$item['name']; ?>
	<?php endforeach;?>
	<br />
	List Main Customers <input name="customer" />
    </fieldset>
<br /><br />
    <fieldset>
	<legend>Company Certification</legend>
	<table>
		<?php foreach($certification_options as $item): ?>
			<?php echo form_checkbox('certifications[]', $item['id']).$item['name']; ?>
		<?php endforeach;?>
	</table>
    </fieldset>
<br /><br />
    
    <fieldset>
	<legend>Factory Details:</legend>
	Factory Location <input name="factory_location" /> <br />
	Factory Size <input name="factory_size" />
	Production Lines <input name="factory_productionline" />
	Purchase Volume <input name="factory_purchase" />
	Quality Control <input name="factory_qc" /> <br />
	No.Staff <input name="factory_no_staff" />
	No. QC Staff <input name="factory_no_qc" />
    </fieldset>    
    
    
    
    <fieldset>
	<legend>Update Contact Detail   (can add DB)</legend>
	<input type="file" name="userfile" size="20" />
	Product Keywords<textarea name="product_keyword"></textarea>
	Company Website <input name="website" />
     </fieldset>
      
 

     <input  type="submit" value="Submit"/>
     <input  type="button" value="Preview"/><br />
     <input type="checkbox" /> I have read and accept the Terms and Conditions of XXXXXXX
    <?php echo form_close() ?>
</body>
</html>