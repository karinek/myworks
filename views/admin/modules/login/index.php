<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>
</head>
<body>
    <p>Please fill in the form to login !!!</p>
    <p>Username:  admin </p>
    <p>Password:  1 </p>

    
    
    <?php echo form_open('admin/login/auth'); ?>
    <table>
        <tr>
            <th><label for="email">Username:</label></th>
            <td><input type="text" id="email" name="email"></td>
        </tr>
        <tr>
            <th><label for="email">Password:</label></th>
            <td><input type="password" id="password" name="password"></td>
        </tr>
        <tr>
            <td><input type="submit" value="Login"></td>
        </tr>
    </table>
    <?php echo form_close() ?>
</body>
</html>