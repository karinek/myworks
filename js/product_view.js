$(document).ready(function(){
    $('#prod_name').blur(validate_pname);
    $('#prod_kwd').blur(validate_pkwd);
    $('#short_desc').blur(validate_sht_desc);
    
    $('#submit_add').click(function(){
	//alert("add");
	if(validate_pname()&&validate_pkwd()&&validate_sht_desc())
	    $('#addProdForm').submit();	
    });
    
    $('#submit_update').click(function(){
	//alert("update");
	if(validate_pname()&&validate_pkwd()&&validate_sht_desc())
	    $('#updateProdForm').submit();	
    });
});

function validate_pname(){
    if($('#prod_name').val()){
	$('#pname_err').text('');        
	return true;
    } else {
	$('#pname_err').text('Please Input product name');	
	return false;
    }     
}

function validate_pkwd(){
	if($('#prod_kwd').val()){
	$('#pkwd_err').text('');        
	return true;
    } else {
	$('#pkwd_err').text('Please Input Product Keyword');	
	return false;
    }
}

function validate_sht_desc(){
	if($('#short_desc').val()){
	$('#sht_desc_err').text('');        
	return true;
    } else {
	$('#sht_desc_err').text('Please Input Listing Description');	
	return false;
    }
}

function showSubMenu(val) {
    var info = document.getElementById(val);
    if(info.style.display == "block") {
	info.style.display = "none";
    }
    else {
	info.style.display = "block";
    }
}

