<?php echo form_open('forum/register/save','', array('params[user_id]'=>$user->id)); ?>
<h1>Welcome <?=$user->firstname?>,</h1>
<h3>User Registration for Forum</h3>
<table border="0">
	<tr>
		<td><span>Username :</span></td>
		<td><?=form_input(array('name'=>'params[username]'))?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><?=form_submit('submit','Submit')?></td>
	</tr>
</table>
<?php echo form_close(); ?>