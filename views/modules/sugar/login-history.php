<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>User Login History</title>
</head>

<body>
<table width="100%" border="1" cellspacing="0" cellpadding="4">
	<tbody>
		<tr class="thead">
			<td valign="top"><b class="nowrap">Location (IP address)</b></td>
			<td valign="top"><b class="nowrap">Date/Time</b></td>
		</tr>
<?php if(count($items) && is_array($items)): ?>
	<?php foreach($items as $item): ?>
		<tr class="fs">
			<td valign="top"><b>*</b> <?=$item['login_location']?> (<?=$item['login_ip']?>) </td>
			<td valign="top"> <?=$item['login_time']?> </td>
		</tr>
	<?php endforeach; ?>
<?php else: ?>
		<tr>
			<td colspan="">Not Login</td>
		</tr>
<?php endif; ?>
	</tbody>
</table>
</body>
</html>