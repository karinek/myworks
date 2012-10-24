<!-- Just for test before , can be delete later-->
<!DOCTYPE html>
<html lang="en">
<script language="javascript" src="<?php echo base_url(); ?>js/jquery-1.7.2.min.js"></script>
<script>
$(document).ready(function(){
	$('.add_favorite').click(function(){
		$.ajax({
			type: "POST",
			url: "<?php echo site_url(); ?>/favorite/add_favorite_company",
			data: {'company_id':<?php echo $company_detail['company_id'] ?>}
		}).success(function( msg ) {
			alert(msg);
		});
	});
});
</script>
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>
</head>
<body>
   <p><?php echo anchor('home','Home'); ?></p>
   <p><div class="add_favorite"><a href="javascript:void(0)">Add to my Favorites</a></div></p>
   <fieldset>
	<legend>Company Profile</legend>
    <table>
        <tr>
            <th>Company Name:</th>
            <td><?php echo $company_detail['name']?></td>
        </tr>
	<tr>
            <th>Company Address:</th>
            <td><?php echo $company_detail['address'] ?></td>
        </tr>
	<tr>
            <th>City:</th>
            <td><?php echo $company_detail['city'] ?></td>
        </tr>
	<tr>
            <th>State:</th>
            <td><?php echo $company_detail['state'] ?></td>
        </tr>
	<tr>
            <th>Country:</th>
            <td><?php echo $country_name[0]['name']; ?></td>
        </tr>
	<tr>
            <th>Zip:</th>
            <td><?php echo $company_detail['zip'] ?></td>
        </tr>
<!--	<tr>
            <th>Telephone:</th>
            <td><?php //    echo $company_detail['tel'] ?></td>
        </tr>-->
<!--	<tr>
            <th>Mobile:</th>
            <td><?php //echo $company_detail['mobile'] ?></td>
        </tr>-->
	<tr>
            <th>Website:</th>
            <td><?php echo $company_detail['website'] ?></td>
        </tr>
    </table>
   </fieldset>
   <fieldset>
	<legend>Hot Product</legend>
	<table>
		<?php foreach($products as $product): ?>
		<tr>
			<?php echo $product['prod_name'] ?>
		</tr>
		<?php endforeach ?>
	</table>
   </fieldset>
   <fieldset>
	<legend>Contact Person</legend>
	
	<table>
	<tr>
	    <td><img width="500" height="300" src="../../images/company_contact/<?php echo $company_detail['file']; ?>" /></td>
	</tr>
<!--	<tr>
            <th>Name:</th>
            <td><?php //echo $company_detail['firstname']; ?>
		<?php //echo $company_detail['lastname']; ?></td>
	</tr>-->
	</table>
   </fieldset>
   

   
   
</body>
</html>