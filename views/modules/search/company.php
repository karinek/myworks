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
<script language="javascript" src="<?php echo base_url(); ?>js/jquery-1.7.2.min.js"></script>
<script>
$(document).ready( function(){
	$('.company_link').click(function(){
		var keyword = $('#keyword_id').val();
		var link = $(this).attr('link');
		$.ajax({
			type: "POST",
			url: "<?php echo site_url(); ?>/analytics",
			data: { 'keyword': keyword, 'link': link }
			}).success(function( msg ) {
				window.location.href = "<?php echo site_url();?>" + link;
			});
	});
});
</script>



<body>

  <p><?php echo anchor('home','Home'); ?></p>
  
    <?php echo form_open('search'); ?>
    <fieldset>
	<legend>Search</legend>
	    <table>
		<tr>
		    <td><input id="keyword_id" name="keyword" value="<?php echo $keyword ?>"/></td>
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
			<th>Name</th>
			<th>Address</th>
			<th>City</th>
			<th>Website</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
		<?php foreach ($companies as $company): ?>
		<tr>
			<td><div class='company_link' style="cursor: pointer;" link="<?php echo '/company/show/'.$company['id']?>" >
				<?php echo $company['name']; ?>
			</div></td>
			<td><?php echo $company['address']; ?></td>
			<td><?php echo $company['city']; ?></td>
			<td><?php echo $company['website']; ?></td>
			<td><?php echo $company['status']; ?></td>
			
		</tr>
		<?php endforeach ?>
	</table>
    </fieldset>
</body>
</html>