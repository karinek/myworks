  $(document).ready(function() {

    $("#change_password").validate({
        ignore: ".ignore, :hidden",
        focusInvalid: true,
        hideErrElem : "#validate_error",
        errorPlacement: function(error,element) {
            
            changeTip(element);
            return true;
        },

        rules: {
           
                password: {
                required : true,
                minlength: 6
                
            },
            newpassword:{
                required : true,
                minlength: 6
                },
                 confnewpassword:{
                required : true,
                minlength: 6,
                 pass:true
                }
        }
    });
    $("#change_password_submit").click(function() {
        var valid = $("#change_password").valid();
        if(valid)
        {
            document.forms["change_password"].submit()
        }
    });

    jQuery.validator.addMethod("pass", function(value, element)
    {
        if($('#newpassword').val() == $('#confnewpassword').val())
        {
            return true;
        }

        return false;
    });


    

    
    fields_tip = {
     
        tip_w : 300,
        tip_r : 3,
        tip_color : 'light',
        tip_show : 'mouseover focus',
        tip_show_ready : false,
        tip_hide : 'mouseout click blur',
        tip_border_w : 0,
        tip_screen : false,
        tip_hide_delay : 0,

       

     
       
        password : function() {
            $('*[name="password"]').qtip({
                   
                    content: {
                    text: 'Please enter valid password more than 6 characters',
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

      
         newpassword : function() {
            $('*[name="newpassword"]').qtip({
                   
                    content: {
                    text: 'Please enter valid password more than 6 characters',
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
        newpassword_destruct : function() {
            $('*[name="newpassword"]').qtip('destroy');
        },
           confnewpassword : function() {
            $('*[name="confnewpassword"]').qtip({
                   
                    content: {
                    text: 'Please enter Re Passwprd equals Password and more than 6 characters',
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
        confnewpassword_destruct : function() {
            $('*[name="confnewpassword"]').qtip('destroy');
        },
        init : function() {
           
          
          
             this.password();
            $('*[name="password"]').mouseover();
             this.newpassword();
            $('*[name="newpassword"]').mouseover();
             this.confnewpassword();
            $('*[name="confnewpassword"]').mouseover();
          
          
        },

        destructor : function() {
          
            
            
              this.password_destruct();
                this.newpassword_destruct();
                  this.confnewpassword_destruct();
              
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
 

