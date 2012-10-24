$(document).ready(function(e) {
    /* LEFT MENU */
    $(document).find("ul.product_left_menu_list li.product_left_menu_list_head").each(function(){ //changes for left menu 
        if($(this).children('ul').length === 0){
            $(this).removeClass("product_left_menu_list_head wrapp");
            $(this).css('color', '#44463A');
        }
    });

	$('#left_menu>li').hover(function(){
		$('#left_menu>li').removeClass('active');
		$('.sub_category, li.hide').hide();
		$(this).addClass('active');
		$(this).children('.sub_category').show();
		$(this).children('.sub_category').children('.more').show();
		},function(){
			$(this).removeClass('active');
			$(this).children('.sub_category').hide();
			});
	$('#left_menu li.more').click(function(){
		$(this).parent('ul').children('li.hide').show();
		$(this).hide();
                $(this).next('li.less').show();
		});
                
        $('#left_menu li.less').click(function(){
                $(this).parent('ul').show();
		$(this).parent('ul').children('li.hide').hide();
                $(this).hide();
                $(this).prev('li.more').show();
		});        
                
	/* LOGIN FORM */
	$('#submit_mask .login_li').click(function(e){
		var forget_pass = $('.forgot_password');
		if(forget_pass.css('display')=='none'){
			if($('.login_block input[name="email"]').val()!='' && $('.login_block input[name="email"]').val()!=''){
				$('.login_block').submit();
			}else{
				$('.login_block div.hide_form').animate({'top':'-34px'},500);
				$('.forgot_password').fadeIn();
			}
		}else{
			$('.login_block div.hide_form').animate({'top':'0px'},500);
			$('.forgot_password').fadeOut();
		}
	});

	/* RADIO INPUTS TEXTS */
	$('#advanced_search_block :radio').change(function() {
		$(this).parent().parent().children().children('label').removeClass('select_label');
		$(this).parent().children('label').addClass('select_label');
	});
	
	/* PROCESS SLIDE */
	$( ".slider" ).slider({
		min: 0,
		max: 5000,
		step: 1,
		slide: function( event, ui ) {
			$( ".slider span").text( "$ " + ui.value );
			$( ".slider span").css({'left':(ui.value/5000) * 100 - 10 +'%'});
		}
	});
	
	/* ADVANCED SEARCH */
                if($('#advanced_search_block .business_type').css('display') == 'list-item' && $('#advanced_search_block .time_period').css('display') == 'list-item' && $('.active a').attr('title') == 'products'){
                    $('.supplier_options').css('display','none');
                    $('#advanced_search_block .time_period1').css('display','none');
                    //$('#advanced_item').css('display','none');
                }
        
        $('.top_nav .advanced_search').click(function(e){
		$('#advanced_search_block').slideDown(200);
                if($('#advanced_search_block .business_type').css('display') == 'list-item' && $('#advanced_search_block .time_period').css('display') == 'list-item' && $('.products.active a').attr('title') == 'products'){
                    $('#advanced_search_block .business_type').css('display','none'); 
                    $('#advanced_search_block .time_period').css('display','none');
                    //$('#advanced_item').css('display','none');
                }
                
                if($('.active a').attr('title') == 'seller'){
                    $('#advanced_search_block .time_period').css('display','none');
                    $('.advanced_item .supplier_options .checkbox').css('display','block');
                }
                 
                if($('.active a').attr('title') == 'buyer'){
                     $('#advanced_search_block .business_type').css('display','none'); 
                    $('.advanced_item .supplier_options .checkbox').css('display','none');
                }
            
//                if($('#advanced_search_block .business_type').css('display') == 'none')
//                    $('#advanced_search_block .advanced_item .supplier_options .checkbox').css('display','none');
		e.preventDefault();
		});
	$('#advanced_search_block .close').click(function(){
		$('#advanced_search_block').slideUp(200);
		});
		
	/* TABS */
	$('#tabs li').click(function(e){
                $('#search_type').val($(this).children().attr('title'));
		$('#tabs li').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
		});

	/* PRODUCT TABS */
        $('#tabs .products').click(function(){
           $('#advanced_search_block .business_type').css('display','none'); 
           $('#advanced_search_block .time_period').css('display','none');
           //$('#advanced_item').css('display','none');
           $('#advanced_search_block .advanced_item .supplier_options .checkbox').css('display','none');
        });
        $('#tabs .suppliers').click(function(){
           $('#advanced_search_block .time_period').css('display','none');
           $('#advanced_search_block .business_type').css('display','block');
           $('#advanced_item').css('display','block');
           $('.supplier_options').css('display','block');
           $('#advanced_search_block .advanced_item .supplier_options .checkbox').css('display','block');
        });
        $('#tabs .buyers').click(function(){
           $('#advanced_search_block .business_type').css('display','none'); 
           $('#advanced_search_block .time_period').css('display','block');
           $('#advanced_item').css('display','block');
           if($('#advanced_search_block .advanced_item .supplier_options .checkbox').css('display') == 'block')
                    $('#advanced_search_block .advanced_item .supplier_options .checkbox').css('display','none');
        });
	$('#product_tabs li').click(function(e){
		$('#product_tabs li').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
		});
	$('#product_tabs li.product_details').click(function(e){
		e.preventDefault(e);
		$('#product_tabs_block .product_details_page').show();
		$('#product_tabs_block .products_images_page, #product_tabs_block .contact_company_page').hide()
		});
	$('#product_tabs li.products_images').click(function(e){
		e.preventDefault(e);
		$('#product_tabs_block .products_images_page').show();
		$('#product_tabs_block .product_details_page, #product_tabs_block .contact_company_page').hide()
		});
	$('#product_tabs li.contact_company').click(function(e){
		e.preventDefault(e);
		$('#product_tabs_block .contact_company_page').show();
		$('#product_tabs_block .products_images_page, #product_tabs_block .product_details_page').hide()
		});
		
	/* PRODUCT LEFT MENU */
	$('.menu_head').toggle(function(){
		$('.product_left_menu_list').slideUp(500,function(){
			$('.menu_head').addClass('wrapp');
			});
		},function(){
			$('.product_left_menu_list').slideDown(500,function(){
			$('.menu_head').removeClass('wrapp');
			});
			});
	$('.product_left_menu_list .product_left_menu_list_head span').toggle(function(){
        $(this).parent('li').children('ul').stop(true,true).slideDown(500,function(){
            $(this).parent('li').removeClass('wrapp');
        });
		
		},function(){
            $(this).parent('li').children('ul').stop(true,true).slideUp(500,function(){
                $(this).parent('li').addClass('wrapp');
            });

		});
			
//	/* OFFICE TABS */
//	$('#office_tabs li').click(function(e){
//		$('#office_tabs li').removeClass('active');
//		$(this).addClass('active');
//		e.preventDefault();
//		});
        
        /* ADD COMPANY TO FAVOURITE */       
        $('[id^="linkAddCompanyFavourite"]').click(function(){
            $("#popup").fadeIn("slaw");
            $("#contentBox").fadeIn("slaw");
            var company_id = $(this).attr('data-favourite');
            $.get(app.base_url() + 'company/addCompanyDetails/'+company_id+'/action/favourite', function(data) {
                $('#add_to_favorites'+company_id).html('My Favourite');
                $("#contentBox").html(data);
            });
        });        
        
        /* ADD COMPANY TO CONTACT */
        $('[id^="linkAddCompanyContact"]').click(function(){
            $("#popup").fadeIn("slaw");
            $("#contentBox").fadeIn("slaw");
            var company_id = $(this).attr('data-contact');
            $.get(app.base_url() + 'company/addCompanyDetails/'+company_id+'/action/contact', function(data) {
                $('#contact_company'+company_id).html('My Contact');
                $("#contentBox").html(data);
            });
        }); 
        
        /* ADD COMPANY TO NETWORK */
        $('[id^="linkAddCompanyNetwork"]').click(function(){
            $("#popup").fadeIn("slaw");
            $("#contentBox").fadeIn("slaw");
            var company_id = $(this).attr('data-network');
            $.get(app.base_url() + 'company/addCompanyDetails/'+company_id+'/action/network', function(data) {
                $('#add_to_wishlist'+company_id).html('My Network');
                $("#contentBox").html(data);
            });
        }); 
        
        $('#btnAlreadyAdded').live('click', function(){
            $("#popup").fadeOut("slaw");
            $("#contentBox").fadeOut("slaw");
            $("#contentBox").html('');
        });
        
        $('.my_company_menu .check span').click(function(){
           if($(this).hasClass("ui-checkbox-checked")) {
               $('#office_tabs_block input[type=checkbox]').each(function(){
                  $(this).attr("checked", "checked"); 
                  $(this).next('span').addClass('ui-checkbox-state-checked ui-checkbox-checked');
               });
           } else {
               $('#office_tabs_block input[type=checkbox]').each(function(){
                  $(this).removeAttr("checked");
                  $(this).next('span').removeClass('ui-checkbox-state-checked ui-checkbox-checked');
               });
           }
        });

});