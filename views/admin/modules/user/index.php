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
  
    <?php echo form_open('admin/user'); ?>
    <fieldset>
	<legend>Search user by firstname/lastname/email</legend>
  	<input name="keyword" />
	<input type="submit" value="search" />
    </fieldset>
    <?php echo form_close() ?>
    
    <fieldset>
	<legend>Result</legend>
	<table>
		<tr>
			<th>Email</th>
			<th>Firstname</th>
			<th>Lastname</th>
			<th>Country</th>
			<th>Company</th>
			<th>Role</th>
			<th>Trade Pass</th>
                        <th>Assess</th>
			<th>Create Date</th>
			<th>Last Login Date</th>
			<th>Last Login IP</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
		<?php foreach ($users as $user): ?>
		<tr>
			<td><?php echo $user['email']; ?></td>
			<td><?php echo $user['firstname']; ?></td>
			<td><?php echo $user['lastname']; ?></td>
			<td><?php echo $user['location']; ?></td>
			<td><?php echo anchor('admin/company/edit/'.$user['company_id'],$user['company']); ?></td>
			<td><?php echo $user['role']; ?></td>
			<td><?php echo $user['is_tradepass']; ?></td>
                        <td><?php echo $user['is_assessed']; ?></td>
			<td><?php echo $user['create_date']; ?></td>
			<td><?php echo $user['last_login_date']; ?></td>
			<td><?php echo $user['last_ip']; ?></td>
			<td><?php echo $user['status']; ?></td>
			<td><?php echo anchor("admin/user/edit/".$user['id'],"edit"); ?></td>
		</tr>
		<?php endforeach ?>
	</table>
    </fieldset>
</body>
</html>