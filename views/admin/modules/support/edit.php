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
    
    <?php echo form_open('admin/support/do_edit','',$hidden); ?>
    <fieldset>
	<legend>Edit a support</legend>
	Username: <input name="username" value="<?php echo $username; ?>" /><br />
	Password: <input name="password" />(leave it blank if you dont wanna change it)<br />
	<?php echo form_radio('type','support',($type=='support')); ?> Support
	<?php echo form_radio('type','admin',($type=='admin')); ?> Admin(with full control) <br />
	
    <input type="submit" value="edit" />
    </fieldset>
    <?php echo form_close() ?>
</body>
</html>