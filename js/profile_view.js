
 $(document).ready(function() {

	Shadowbox.init({'modal':true});
	$('#thumb').each(function(){
		var $this = $(this);
		var staff_id = $this.attr('id').split('-');
		
		$this.hover(function(e){
				$this.css({
					'box-shadow': '1px 1px 5px #666'
				})
			},function(e){
				$this.css({
					'box-shadow': 'none'
				})
			}
		);
	});
     
/*	var thumb = $('#thumb');	

	new AjaxUpload('fileInput1', {
		action: $('#mask1').attr('action'),
		name: 'userfile',
		onSubmit: function(file, extension) {
			thumb.attr('width', "30px");
			thumb.attr('height', "30px");
			thumb.attr('src', $('#upload_image_folder').val() + "/" + "loading.gif");
		},
		onComplete: function(file, response) {
//			thumb.load(function(){
//				$('.preview').removeClass('loading');
//				thumb.unbind();
//			});
			thumb.attr('width', "150px");
			thumb.attr('height', "150px");
			thumb.attr('src', $('#upload_image_folder').val() + "/" + response);
			$('#upload_image').val(response);
		}
	});
*/
$('form#profile_form input:checkbox').checkBox();
	$('form#profile_form select#location_id').selectbox({
		onChange: function (val, inst) {
			var dialing_code =$('#location_id').find('option[value="'+val+'"]').attr('label');
			$('#phone_country_id').val('+'+dialing_code).attr('disabled',true);
			$('#phone_country_id_hidden').val('+'+dialing_code);
		}
	});
	$('form#profile_form select').selectbox();
    //profile_form
    //submit_id
   $("#profile_form").validate({
        ignore: ".ignore",
        focusInvalid: true,
        hideErrElem : "#validate_error",
        errorPlacement: function(error,element) {
            changeTip(element);
            return true;
        },

        rules: {
        
           /* phone_country:  {
                required : true
            },*/
           phone_area: {
                required : true
            },
            phone_number:   {
                required : true
            },
            firstname: {
                required : true
                
            },
            lastname : {
                required : true
              
            },
            password : {
                required : true,
                minlength: 6
            },
            repassword : {
                required : true,
                minlength: 6,
                pass:true
            },
            email: {
                required : true,
                minlength: 6,
                email:true
            },
          
            company:{
                required : true
               
            },
            captcha: {
                required : true
               
            }
            /*    location:{
                required : true,
                selectbox: true
            },
            gender:{
                required : true,
                selectbox: true
            }*/
        }
    });
    $("#submit_id").click(function() {
        var valid = $("#profile_form").valid();
         var validate = 1; 
        var $this1 = $('#location_id');
        var $val1 = $('#location_id option:selected').val();
       if($val1 !=0 && $val1 !=''){
            $this1.parent().css({
                'border-color':'#B9BCBE'
            });
          
        }else{
            $this1.parent().css({
                'border-color':'red'
            });
           validate = 0;
        }
            var $this2 = $('#gender');
        var $val2 = $('#gender option:selected').val();
       if($val2 !=0 && $val2 !=''){
            $this2.parent().css({
                'border-color':'#B9BCBE'
            });
          
        }else{
            $this2.parent().css({
                'border-color':'red'
            });
           validate = 0;
        }
        if(validate == 1){
       if(valid)
        {
            document.forms["profile_form"].submit()
        }}
    });



    jQuery.validator.addMethod('email', function(value, element, param)
    {
        var pattern=/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
        if(pattern.test(value))
        {
            return true;
        }

        return false;
    });

    jQuery.validator.addMethod("pass", function(value, element)
    {
        if($('#password_id').val() == $('#repassword_id').val())
        {
            return true;
        }

        return false;
    });

    
    fields_tip = {
     
        tip_w : 300,
        tip_r : 3,
        tip_color : 'light',
        tip_show : 'click',
        tip_show_ready : false,
        tip_hide : 'blur',
        tip_border_w : 0,
        tip_screen : false,
        tip_hide_delay : 0,

       

      
        firstname : function() {
            $('*[name="firstname"]').qtip({
               content: {
                    text: 'Enter First Name',
                    title: {
                       
                    }
                },
                position: {
                    corner: {
                        target: 'rightMiddle',
                        tooltip: 'leftMiddle'
                    },
                    adjust: {
                        screen: this.tip_screen
                    }
                },
                show: {
                    when: this.tip_show,
                    solo: false,
                    ready : this.tip_show_ready
                },
                hide: {
                    when: {
                        event: this.tip_hide
                    },
                    delay: this.tip_hide_delay
                },
                style: {
                    background: '#FFF',
                    tip: true,
                    border: {
                        color: '#ffecec',
                        width: this.tip_border_w,
                        radius: this.tip_r
                    },
                    name: this.tip_color,
                    width: this.tip_w,
                    height:'50px'
                    
                }
            });
        },
        firstname_destruct : function() {
            $('*[name="firstname"]').qtip('destroy');
        },
      
       /* phone_country : function() {
            $('*[name="phone_country"]').qtip({
                content: {
                    text: 'Enter Phone Country',
                    title: {
                       
                }
                },
                position: {
                    corner: {
                        target: 'rightMiddle',
                        tooltip: 'leftMiddle'
                    },
                    adjust: {
                        screen: this.tip_screen
                    }
                },
                show: {
                    when: this.tip_show,
                    solo: false,
                    ready : this.tip_show_ready
                },
                hide: {
                    when: {
                        event: this.tip_hide
                    },
                    delay: this.tip_hide_delay
                },
                style: {
                    background: '#FFF',
                    tip: true,
                    border: {
                        color: '#ffecec',
                        width: this.tip_border_w,
                        radius: this.tip_r
                    },
                    name: this.tip_color,
                    width: this.tip_w,
                    height:'50px'
                    
                }
            });
        },
        phone_country_destruct : function() {
            $('*[name="phone_country"]').qtip('destroy');
        },*/
        phone_number : function() {
            $('*[name="phone_number"]').qtip({
                content: {
                    text: 'Enter Phone Country',
                    title: {
                       
                }
                },
                position: {
                    corner: {
                        target: 'rightMiddle',
                        tooltip: 'leftMiddle'
                    },
                    adjust: {
                        screen: this.tip_screen
                    }
                },
                show: {
                    when: this.tip_show,
                    solo: false,
                    ready : this.tip_show_ready
                },
                hide: {
                    when: {
                        event: this.tip_hide
                    },
                    delay: this.tip_hide_delay
                },
                style: {
                    background: '#FFF',
                    tip: true,
                    border: {
                        color: '#ffecec',
                        width: this.tip_border_w,
                        radius: this.tip_r
                    },
                    name: this.tip_color,
                    width: this.tip_w,
                    height:'50px'
                    
                }
            });
        },
        phone_number_destruct : function() {
            $('*[name="phone_number"]').qtip('destroy');
        },
        
          
        phone_area : function() {
            $('*[name="phone_area"]').qtip({
                content: {
                    text: 'Enter Phone Area',
                    title: {
                       
                }
                },
                position: {
                    corner: {
                        target: 'rightMiddle',
                        tooltip: 'leftMiddle'
                    },
                    adjust: {
                        screen: this.tip_screen
                    }
                },
                show: {
                    when: this.tip_show,
                    solo: false,
                    ready : this.tip_show_ready
                },
                hide: {
                    when: {
                        event: this.tip_hide
                    },
                    delay: this.tip_hide_delay
                },
                style: {
                    background: '#FFF',
                    tip: true,
                    border: {
                        color: '#ffecec',
                        width: this.tip_border_w,
                        radius: this.tip_r
                    },
                    name: this.tip_color,
                    width: this.tip_w,
                    height:'50px'
                    
                }
            });
        },
        phone_area_destruct : function() {
            $('*[name="phone_area"]').qtip('destroy');
        },
        
        
        company : function() {
            $('*[name="company"]').qtip({
                content: {
                    text: 'Enter Company Name',
                    title: {
                       
                }
                },
                position: {
                    corner: {
                        target: 'rightMiddle',
                        tooltip: 'leftMiddle'
                    },
                    adjust: {
                        screen: this.tip_screen
                    }
                },
                show: {
                    when: this.tip_show,
                    solo: false,
                    ready : this.tip_show_ready
                },
                hide: {
                    when: {
                        event: this.tip_hide
                    },
                    delay: this.tip_hide_delay
                },
                style: {
                    background: '#FFF',
                    tip: true,
                    border: {
                        color: '#ffecec',
                        width: this.tip_border_w,
                        radius: this.tip_r
                    },
                    name: this.tip_color,
                    width: this.tip_w,
                    height:'50px'
                    
                }
            });
        },
        company_destruct : function() {
            $('*[name="company"]').qtip('destroy');
        },
        captcha : function() {
            $('*[name="captcha"]').qtip({
              
                    
                content: {
                    text: 'Please enter the word correctly.',
                    title: {
                       
                }
                },
                position: {
                    corner: {
                        target: 'rightMiddle',
                        tooltip: 'leftMiddle'
                    },
                    adjust: {
                        screen: this.tip_screen
                    }
                },
                show: {
                    when: this.tip_show,
                    solo: false,
                    ready : this.tip_show_ready
                },
                hide: {
                    when: {
                        event: this.tip_hide
                    },
                    delay: this.tip_hide_delay
                },
                style: {
                    background: '#FFF',
                    tip: true,
                    border: {
                        color: '#ffecec',
                        width: this.tip_border_w,
                        radius: this.tip_r
                    },
                    name: this.tip_color,
                    width: this.tip_w,
                    height:'50px'
                    
                }
            });
        },
        captcha_destruct : function() {
            $('*[name="captcha"]').qtip('destroy');
        },
        email : function() {
            $('*[name="email"]').qtip({
                   
                content: {
                    text: 'The Email address you enter allows you to sign in to TradeOffice',
                    title: {
                       
                }
                },
                position: {
                    corner: {
                        target: 'rightMiddle',
                        tooltip: 'leftMiddle'
                    },
                    adjust: {
                        screen: this.tip_screen
                    }
                },
                show: {
                    when: this.tip_show,
                    solo: false,
                    ready : this.tip_show_ready
                },
                hide: {
                    when: {
                        event: this.tip_hide
                    },
                    delay: this.tip_hide_delay
                },
                style: {
                    background: '#FFF',
                    tip: true,
                    border: {
                        color: '#ffecec',
                        width: this.tip_border_w,
                        radius: this.tip_r
                    },
                    name: this.tip_color,
                    width: this.tip_w,
                    height:'50px'
                    
                }
            });
        },
        email_destruct : function() {
            $('*[name="email"]').qtip('destroy');
        },
        password : function() {
            $('*[name="password"]').qtip({
                   
                content: {
                    text: 'For a more secure password:<br/>1. More than 6 characters<br/>2. Use both letters and numbers<br/>3. Mix capital and lowercase letters</li></ul>',
                    title: {
                       
                }
                },
                position: {
                    corner: {
                        target: 'rightMiddle',
                        tooltip: 'leftMiddle'
                    },
                    adjust: {
                        screen: this.tip_screen
                    }
                },
                show: {
                    when: this.tip_show,
                    solo: false,
                    ready : this.tip_show_ready
                },
                hide: {
                    when: {
                        event: this.tip_hide
                    },
                    delay: this.tip_hide_delay
                },
                style: {
                    background: '#FFF',
                    tip: true,
                    border: {
                        color: '#ffecec',
                        width: this.tip_border_w,
                        radius: this.tip_r
                    },
                    name: this.tip_color,
                    width: this.tip_w,
                    height:'50px'
                    
                }
            });
        },
        password_destruct : function() {
            $('*[name="password"]').qtip('destroy');
        },
       repassword : function() {
            $('*[name="repassword"]').qtip({
                   
                    content: {
                    text: 'Please enter Re Passwprd equals Password and more than 6 characters.',
                    title: {
                       
                    }
                },
                position: {
                    corner: {
                        target: 'rightMiddle',
                        tooltip: 'leftMiddle'
                    },
                    adjust: {
                        screen: this.tip_screen
                    }
                },
                show: {
                    when: this.tip_show,
                    solo: false,
                    ready : this.tip_show_ready
                },
                hide: {
                    when: {
                        event: this.tip_hide
                    },
                    delay: this.tip_hide_delay
                },
                style: {
                    background: '#FFF',
                    tip: true,
                    border: {
                        color: '#ffecec',
                        width: this.tip_border_w,
                        radius: this.tip_r
                    },
                    name: this.tip_color,
                    width: this.tip_w,
                    height:'50px'
                    
                }
            });
        },
        repassword_destruct : function() {
            $('*[name="repassword"]').qtip('destroy');
        },
      
        lastname : function() {
            $('*[name="lastname"]').qtip({
                    
                    content: {
                    text: 'Please enter Last Name.',
                    title: {
                       
                    }
                },
                position: {
                    corner: {
                        target: 'rightMiddle',
                        tooltip: 'leftMiddle'
                    },
                    adjust: {
                        screen: this.tip_screen
                    }
                },
                show: {
                    when: this.tip_show,
                    solo: false,
                    ready : this.tip_show_ready
                },
                hide: {
                    when: {
                        event: this.tip_hide
                    },
                    delay: this.tip_hide_delay
                },
                style: {
                    background: '#FFF',
                    tip: true,
                    border: {
                        color: '#ffecec',
                        width: this.tip_border_w,
                        radius: this.tip_r
                    },
                    name: this.tip_color,
                    width: this.tip_w,
                    height:'50px'
                    
                }
            });
        },
        lastname_destruct : function() {
            $('*[name="lastname"]').qtip('destroy');
        },
                location : function() {
            $('*[name="location"]').qtip({
                    
                    content: {
                    text: 'Please enter Last Name.',
                    title: {
                       
                    }
                },
                position: {
                    corner: {
                        target: 'rightMiddle',
                        tooltip: 'leftMiddle'
                    },
                    adjust: {
                        screen: this.tip_screen
                    }
                },
                show: {
                    when: this.tip_show,
                    solo: false,
                    ready : this.tip_show_ready
                },
                hide: {
                    when: {
                        event: this.tip_hide
                    },
                    delay: this.tip_hide_delay
                },
                style: {
                    background: '#FFF',
                    tip: true,
                    border: {
                        color: '#ffecec',
                        width: this.tip_border_w,
                        radius: this.tip_r
                    },
                    name: this.tip_color,
                    width: this.tip_w,
                    height:'50px'
                    
                }
            });
        },
        location_destruct : function() {
            $('*[name="location"]').qtip('destroy');
        },
       
                gender : function() {
            $('*[name="location"]').qtip({
                    
                    content: {
                    text: 'Please enter Last Name.',
                    title: {
                       
                    }
                },
                position: {
                    corner: {
                        target: 'rightMiddle',
                        tooltip: 'leftMiddle'
                    },
                    adjust: {
                        screen: this.tip_screen
                    }
                },
                show: {
                    when: this.tip_show,
                    solo: false,
                    ready : this.tip_show_ready
                },
                hide: {
                    when: {
                        event: this.tip_hide
                    },
                    delay: this.tip_hide_delay
                },
                style: {
                    background: '#FFF',
                    tip: true,
                    border: {
                        color: '#ffecec',
                        width: this.tip_border_w,
                        radius: this.tip_r
                    },
                    name: this.tip_color,
                    width: this.tip_w,
                    height:'50px'
                    
                }
            });
        },
        gender_destruct : function() {
            $('*[name="gender"]').qtip('destroy');
        },
        
      
        init : function() {
           
            
         
           /* this.phone_country();
            $('*[name="phone_country"]').mouseover();
            */
            this.phone_area();
            $('*[name="phone_area"]').mouseover();
            
            this.phone_number();
            $('*[name="phone_number"]').mouseover();
            this.firstname();
            $('*[name="firstname"]').mouseover();
                  
            this.lastname();
            $('*[name="lastname"]').mouseover();
          
            this.password();
            $('*[name="password"]').mouseover();
         this.repassword();
            $('*[name="repassword"]').mouseover();

            this.email();
            $('*[name="email"]').mouseover();
            this.captcha();
            $('*[name="captcha"]').mouseover();
            this.company();
            $('*[name="company"]').mouseover();
               this.location();
            $('*[name="location"]').mouseover();
                 this.gender();
            $('*[name="gender"]').mouseover();
        },

        destructor : function() {
            
         
           
         //   this.phone_country_destruct();
             this.phone_area_destruct();
            this.phone_number_destruct();
            this.firstname_destruct();
            this.lastname_destruct();
            this.password_destruct();
            this.repassword_destruct();
            this.email_destruct();
            this.captcha_destruct();
            this.company_destruct();
             this.gender_destruct();
             this.location_destruct();
        }

    };

    fields_tip.init();
});

function changeTip(element)
{

    if(!($(element).hasClass('error1')))
    {
       
        $(element).qtip('destroy');
        
        fields_tip.tip_r = 2;
        fields_tip.tip_border_w = 2;
        fields_tip.tip_show_ready = false;
        fields_tip.tip_color = 'light';
        fields_tip.tip_show = 'mouseover focus';
        fields_tip.tip_hide = 'mouseout click blur';
        fields_tip[$(element)[0].name].call(fields_tip);
        $('*[name="' + $(element)[0].name + '"]').mouseover();
    }
    else
    {
      
        $(element).qtip('destroy');

        fields_tip.tip_color = 'red';
        fields_tip.tip_show_ready = true;
        fields_tip.tip_show = 'mouseover focus';
        fields_tip.tip_hide = 'click mouseout blur';

        
        fields_tip[$(element)[0].name].call(fields_tip);
        $('*[name="' + $(element)[0].name + '"]').mouseover();
                           
        setTimeout('$(\'*[name="' + $(element)[0].name + '"]\').qtip("hide");', 3000);
    }
}

function change_captcha(){
    var src = $('#captcha_id').attr('action');
    src = src + "?" + Math.random();
    $('#captcha_id').attr('src',src);
}
 
