<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Admin Panel</title>
</head>
<body>

<div id="container">
	<h1>Category page</h1>
	<?php echo $nav; ?>
	<?php echo form_open('attribute/add','',$hidden); ?>
	<ul>
		<?php foreach($category as $val): ?>
			<li><?php echo anchor('attribute/display/'.$val['category_id'],$val['category_name']); ?> <?php echo anchor('attribute/edit/'.$val['category_id'],'<span>Edit</span>'); ?></li>
		<?php endforeach ?>
		
	</ul>
	
	<input name="new_category" />
	<input type="submit" value="add" />
	
	 <?php echo form_close() ?>

</body>
</html>