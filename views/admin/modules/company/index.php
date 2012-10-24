<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>
</head>
<style>
	th {
		width: 200px;
	}
	
	td {
		text-align: center;
	}
</style>
<body>

  <p><?php echo anchor('admin/home','Home'); ?></p>
  
    <?php echo form_open('admin/company'); ?>
    <fieldset>
	<legend>Search Company by name/city</legend>
  	<input name="keyword" />
	<input type="submit" value="search" />
    </fieldset>
    <?php echo form_close() ?>
    
    <fieldset>
	<legend>Result</legend>
	<table>
		<tr>
			<th>Name</th>
			<th>Address</th>
			<th>City</th>
			<th>Website</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
		<?php foreach ($companies as $company): ?>
		<tr>
			<td><?php echo $company['name']; ?></td>
			<td><?php echo $company['address']; ?></td>
			<td><?php echo $company['city']; ?></td>
			<td><?php echo $company['website']; ?></td>
			<td><?php echo $company['status']; ?></td>
			<td><?php echo anchor("admin/company/edit/".$company['id'],"edit"); ?></td>
		</tr>
		<?php endforeach ?>
	</table>
    </fieldset>
</body>
</html>