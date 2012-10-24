<!DOCTYPE html>
<html lang="en">

<style type="text/css">
ul
{
list-style-type:none;
margin:0;
padding:0;
}
li
{
display:inline;
}

td {
	padding: 20px;
}

.comment_textarea {
	display: none;
}

.comment {
	color: red;
}

table a {
	color:#339900;
}
</style>	
<script language="javascript" src="<?php echo base_url(); ?>js/jquery-1.7.2.min.js"></script>
<script>
	$('.add_comment_link').live("click",function(){
		$(this).parent().find('.comment_textarea').toggle();
	
	})
	
	$('.add_comment').live("click",function(){
		var obj_textarea = $(this).parent();
		var comment = $(this).parent().find('textarea').val();
		var id = $(this).attr('f_id');
		var type = $(this).attr('f_type');
		$.ajax({
			type: "POST",
			url: "<?php echo site_url(); ?>/favorite/add_comment",
			data: {'comment':comment, 'id':id,  'type':type}
		}).success(function( msg ) {
			obj_textarea.hide();
			obj_textarea.parent().find('.comment').html(comment);
		});

	
	})
</script>

<head>
	<meta charset="utf-8">
	<title>My Favorite</title>
</head>
<body>
    <h2></h2>
    
</head>
<p><?php echo anchor('home','Home'); ?></p>
<body>

<fieldset>
	<legend>Company List</legend>
	<table>
		<tr>
			<th>name</th>
			<th>info</th>
			<th>action</th>
		</tr>
		<?php foreach ($c_list as $item) :?>
		<tr>
			<td><div class="title">
				<?php echo anchor('company/show/'.$item['company_id'],$item['company_name']); ?><br />
			    </div>
		            <div><?php echo $item['website'] ?></div>
			    <div class="comment"><?php echo $item['comment'] ?></div>
			    <div class="add_comment_link"><input type="button" value="update comment" /></div>
			    <div class="comment_textarea">
				<textarea><?php echo $item['comment'] ?></textarea>
				<input class="add_comment" type="button" value="add" f_id ="<?php echo $item['id'] ?>" f_type="c"  />
			    </div>
			</td>
			<td>
			    <div><?php echo $item['address']." ".$item['city']." ".$item['state'] ?></div>
			</td>
			<td>remove link</td>
		</tr>
		<?php endforeach ?>
	</table>
</fieldset>

<fieldset>
	<legend>Product List</legend>
	<table>
		<tr>
			<th>name</th>
			<th>info</th>
			<th>action</th>
		</tr>
		<?php foreach ($p_list as $item) :?>
		<tr>
			<td><div class="title">
				<?php echo $item['name']; ?><br />
			    </div>
			    <div class="comment"><?php echo $item['comment'] ?></div>
			    <div class="add_comment_link"><input type="button" value="update comment" /></div>
			    <div class="comment_textarea">
				<textarea><?php echo $item['comment'] ?></textarea>
				<input class="add_comment" type="button" value="add" f_id ="<?php echo $item['id'] ?>" f_type="p"  />
			    </div>
			</td>
			<td>
			    <div><?php echo $item['keywords']; ?></div>
			</td>
			<td>remove link</td>
		</tr>
		<?php endforeach ?>
	</table>
</fieldset>




   
</body>
</html>