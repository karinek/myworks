// JavaScript Document
if(typeof app == 'undefined') var app = {};
(function($){
	app.reloadStaffImage = function(r){
		if(r.status){
			$('#staffimage-'+r.module_id).attr('src',r.path+'/'+r.image);
		}
	}
	app.reloadUserImage = function(r){
		if(r.status){
			$('#thumb').attr('src',r.path+'/'+r.image);
		}
	}
	app.reloadCompanyImage = function(r){
		if(r.status){
			$('#thumb').attr('src',r.path+'/'+r.image);
		}
	}
	app.reloadRegisterImage = function(r){
		if(r.status){
			$('#thumb').attr('src',r.path+'/'+r.image);
            $('#upload_image').val(r.image);
		}
	}
	app.redirect = function(page){
		window.location = this.base_url()+'/'+page;
	}
})(jQuery);
