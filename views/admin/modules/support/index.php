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
    <fieldset>
	<legend>Existed Supports</legend>
	<table>
		<tr>
			<th>Username</th>
			<th>Last IP</th>
			<th>Last Login Time</th>
			<th>Type</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
		<?php foreach ($supports as $support): ?>
		<tr>
			<td><?php echo $support['username']; ?></td>
			<td><?php echo $support['ip']; ?></td>
			<td><?php echo $support['last_login_time']; ?></td>
			<td><?php echo $support['type']; ?></td>
			<td><?php echo $support['status']; ?></td>
			<td><?php echo anchor("admin/support/edit/".$support['id'],"edit"); ?>
				<?php echo anchor("admin/support/ban/".$support['id'],"ban"); ?></td>
		</tr>
		<?php endforeach ?>
	</table>
    </fieldset>
    
    
    <br /><br /><br />
    
    
    <?php echo form_open('admin/support/add'); ?>
    <fieldset>
	<legend>Add a new support</legend>
	Username: <input name="username" /><br />
	Password: <input name="password" /><br />
	<input type="radio" name="type" value="support">Support
	<input type="radio" name="type" value="admin">Admin(with full control)
    <input type="submit" value="add" />
    </fieldset>
    <?php echo form_close() ?>
</body>
</html>