// JavaScript Document
var searchApp = {};
var formPath = '';
$(document).ready(function(){
    searchApp.onSubmitWithQueryReport = function(){
            if($('#keyword').val() == '' || $('#keyword').val() == 'eq... Rubber Housing'){
                $('#keyword').focus();
                return false;
            }
            $('#search_form').submit();
    };
    
    $('.addvanced_search_go').click(function(){
        var keyword = $('#keyword').val();
        if(keyword == '' || keyword == 'eq... Rubber Housing'){
            $('#keyword').focus();
            return false;
        }
        var search_type = $('#search_type').val();
        formPath = base_url+'search/advancesearch?keyword=' + keyword + '&search_type=' + search_type;
        
        if(search_type == 'products'){
            formPath = formPath + getProductParams();
        }
        else
        if(search_type == 'seller'){
            formPath = formPath + getSellerParams();
        }
        else
        if(search_type == 'buyer'){
            formPath = formPath + getBuyerParams();
        }
    
        $('#advanced_search_form').attr('action', formPath);
        $('#advanced_search_form').submit();
    });
    
	$('#searchFilter').click(function(){
//		alert("test");
	});
});

function getProductParams(){
    var data = '';
    var members = new Array();
    data = data + '&opt=' + $('.advanced_item input[type=radio]:checked').val();
    $('.advanced_item input[type=checkbox]:checked').each(function(){
        members.push($(this).val());
    });
    if(members != '') data = data + '&membership=' + members;
    if($('#category_field').val() > 0)
        data = data + '&cat_id=' + $('#category_field').val();
    if($('#country_id2').val() != '')
        data = data + '&country=' + $('#country_id2').val();
    if($('#region').val() != '')
        data = data + '&region=' + $('#region').val();
    
        
    return data;
}

function getSellerParams(){
    var data = '';
    var members = new Array();
    data = data + '&opt=' + $('.advanced_item input[type=radio]:checked').val();
    $('.advanced_item input[type=checkbox]:checked').each(function(){
        members.push($(this).val());
    });
    if(members != '') data = data + '&membership=' + members;
    if($('#category_field').val() > 0)
        data = data + '&cat_id=' + $('#category_field').val();
    if($('#country_id2').val() != '')
        data = data + '&country=' + $('#country_id2').val();
    if($('#region').val() != '')
        data = data + '&region=' + $('#region').val();
    if($('#business_type').val())
        data = data + '&business_type=' + $('#business_type').val();
    
    return data;
}

function getBuyerParams(){
    var data = '';
    var members = new Array();
    data = data + '&opt=' + $('.advanced_item input[type=radio]:checked').val();
    $('.advanced_item input[type=checkbox]:checked').each(function(){
        members.push($(this).val());
    });
    if(members != '') data = data + '&membership=' + members;
    if($('#category_field').val() > 0)
        data = data + '&cat_id=' + $('#category_field').val();
    if($('#country_id2').val() != '')
        data = data + '&country=' + $('#country_id2').val();
    if($('#region').val() != '')
        data = data + '&region=' + $('#region').val();
    if($('#time_period1').val())
        data = data + '&time_period=' + $('#time_period1').val();
    
    return data;
}

function changeCategory(company,category,page){
	$('.company_products_right').hide();
	$('#loading_div').show();
	var searchval=$('#searchtext').val();
	
	if(searchval=='eg... Search Mail'){
		searchval='';
	}
	
	var order = $('#order').val();	
	
			$.ajax({
			   type:'GET',
			   url: '/tradeoffice/compproducts/search/'+company+'/'+category+'/'+page+'/'+order+'/'+searchval, 
			   data: {company: company, category: category},
			   success: function(data) {
			   	$('.company_products_right').show();
				$('#loading_div').hide();
			   	$('.company_products_right').html(data);
			   }	
		});
		return false;
}

