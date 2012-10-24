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

  <p><?php echo anchor('home','Home'); ?></p>
  
    <?php echo form_open('search'); ?>
    <fieldset>
	<legend>Search</legend>
	    <table>
		<tr>
		    <td><input name="keyword" value="<?php echo $keyword ?>" /></td>
		    <td><?php echo form_dropdown('search_type', $search_options, $search_type);?></td>
                    <td><input type="submit" value="search" /></td>
		</tr>
	    </table>
    </fieldset>
    <?php echo form_close() ?>
    
    <fieldset>
	<legend>Result</legend>
	<table>
		<tr>
			<th>Email</th>
			<th>Firstname</th>
			<th>Lastname</th>
			<th>Gender</th>
			<th>Company</th>
			<th>Role</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
		<?php foreach ($users as $user): ?>
		<tr>
			<td><?php echo $user['email']; ?></td>
			<td><?php echo $user['firstname']; ?></td>
			<td><?php echo $user['lastname']; ?></td>
			<td><?php echo $user['gender']; ?></td>
			<td><?php echo $user['company']; ?></td>
			<td><?php echo $user['role']; ?></td>
			<td><?php echo $user['status']; ?></td>
		</tr>
		<?php endforeach ?>
	</table>
    </fieldset>
</body>
</html>