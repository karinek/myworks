<!--<script type="text/javascript" id="sourcecode">
    $(function()
    {
        $('.left_scrollbar ul').jScrollPane({showArrows: true});
        $('.middle_scrollbar ul').jScrollPane({showArrows: true});
        $('.right_scrollbar ul').jScrollPane({showArrows: true});
    });
</script>-->
<script type="text/javascript">
    $(function(){
        $('#advanced_search_block input').checkBox();
        $('.my_office_buyer_page .middle input').checkBox();
    });
</script>
<script language="javascript">
  $(document).ready(function () {
    var disp = document.getElementById("cDisp");
    var stringTitle1 = '';
    var stringTitle2 = '';
    var stringTitle3 = '';
    var stringTitle4 = '';
  function getIndexValue(oSel)
{
    var index = oSel.selectedIndex;
    return oSel[index].value;    
}
   $("#sel_level_1 li", this).live('click', function(){
       $('#sel_level_1 .background').removeClass();
       $(this).addClass('background');
   });
   $("#sel_level_2 li", this).live('click', function(){
       $('#sel_level_2 .background').removeClass();
       $(this).addClass('background');
   });
   $("#sel_level_3 li", this).live('click', function(){
       $('#sel_level_3 .background').removeClass();
       $(this).addClass('background');
   });
   $("#sel_level_4 li", this).live('click', function(){
       $('#sel_level_4 .background').removeClass();
       $(this).addClass('background');
   });
  $("#sel_level_1 li").click(function() {
           $('.scrollbars').css('width','auto');
//    alert($(this).attr('id'));
        $(".scrollbars").css('pointer-events','none');
        document.getElementById('category_id').value = $(this).attr('id');
       
        stringTitle1 =  "<i>" + $(this).text() + "</i>";
        disp.innerHTML = stringTitle1;  
        document.getElementById('catdisplay').value = disp.innerHTML;
        stringTitle2 = '';
        stringTitle3 = '';
        stringTitle4 = '';
         
        var urlstring = "<?php echo base_url(); ?>index.php/product/addproductstep1/" + $(this).attr('id');
        $.get(urlstring,
        function(data) {
            $(".scrollbars").css('pointer-events','auto');
        
          var sel3 = $("#sel_level_3");
          sel3.empty(); 
          var sel4 = $("#sel_level_4");
          sel4.empty();
          
          
          var sel = $("#sel_level_2");
          sel.empty();
         if(jQuery.isEmptyObject(data))
         {
          
          document.getElementById('next').disabled = false;
         }
         else
         {
            document.getElementById('category_id').value = '';
            document.getElementById('next').disabled = true;
            for (var i=0; i<data.length; i++) {
                sel.append('<li id="' + data[i].category_id+ '">' + data[i].category_name + '</li>');
            }
         }
        }, "json");
    });
     $("#sel_level_2 li").live('click', function() {
           $('.scrollbars').css('width','auto');
         document.getElementById('category_id').value = $(this).attr('id');   
        stringTitle2 =  "<i>" + $(this).text() + "</i>";
        disp.innerHTML = stringTitle1 + "   >>   " +stringTitle2;
        document.getElementById('catdisplay').value = disp.innerHTML;
        stringTitle3 = '';
        stringTitle4 = '';
         var urlstring = "<?php echo base_url(); ?>index.php/product/addproductstep1/" + $(this).attr('id');
       
        $.get(urlstring,
        function(data) {

          var sel4 = $("#sel_level_4");
          sel4.empty();
          
          var sel = $("#sel_level_3");
          sel.empty();
          
          
         if(jQuery.isEmptyObject(data))
         {
          document.getElementById('next').disabled = false;
         }
         else
         {
            document.getElementById('category_id').value = '';
            document.getElementById('next').disabled = true;
            for (var i=0; i<data.length; i++) {
              sel.append('<li id="' + data[i].category_id+ '">' + data[i].category_name + '</li>');
            }
         }
      }, "json");
      });
  
       $("#sel_level_3 li").live('click', function() {
         document.getElementById('category_id').value = $(this).attr('id');
        stringTitle3 =  "<i>" + $(this).text() + "</i>";
        disp.innerHTML = stringTitle1 + "   >>   " +stringTitle2 + "   >>   " +stringTitle3;
        document.getElementById('catdisplay').value = disp.innerHTML;
        stringTitle4 = '';
        document.getElementById('category_id').value = $(this).attr('id');
        
        var urlstring = "<?php echo base_url(); ?>index.php/product/addproductstep1/" + $(this).attr('id');
       
        $.get(urlstring,
        function(data) {
          
        
          
          var sel = $("#sel_level_4");
          sel.empty();
         if(jQuery.isEmptyObject(data))
         {
           $('.scrollbars').css('width','auto');
          document.getElementById('next').disabled = false;
         }
         else
         {
            $('.scrollbarsContainer').animate({scrollLeft:300},'slow');
            document.getElementById('category_id').value = '';
            document.getElementById('next').disabled = true;
            for (var i=0; i<data.length; i++) {
              $('.scrollbars').css('width','951px');
              sel.append('<li id="' + data[i].category_id+ '">' + data[i].category_name + '</li>');
            }
         }
      }, "json");
      });
       
     $("#sel_level_4 li").live('click', function() {
         document.getElementById('category_id').value = $(this).attr('id');
         document.getElementById('next').disabled = false;
         stringTitle4 =  "<i>" + $(this).text() + "</i>";
         disp.innerHTML = stringTitle1 + "   >>   " +stringTitle2 + "   >>   " +stringTitle3 + "   >>   " +stringTitle4;
         document.getElementById('catdisplay').value = disp.innerHTML;
     });

});
</script><div id="office_tabs_block">
                <?php $this->load->view('modules/company/tabs_nav',array('selectedPage'=>'Buying')); ?>
<div id="office_tabs_content">
    <div class="my_office_buyer_page" >
            <div class="left" onclick='a()'>
                    <h2>Post a Buying Request</h2>
					<ul style="width:149px;">
						<li class="active"><a href="<?=base_url();?>request/buy">Post Buying Request</a></li>
						<li><a href="<?=base_url();?>request/manage">Manage Buying Request</a></li>
	<!--                    <li><a href="#">Manage Requests<br /> for Quotations</a></li>-->
	<!--                    <li><a href="#">Manage Sample<br /> Request</a></li>-->
					</ul>
<!--                <p class="online_offline"><a href="#" class="green">Online</a> - <a href="#">Offline</a></p>-->
<!--                <ul>
                    <li class="active"><a href="#">Post Buying<br /> Request</a></li>
                    <li><a href="#">Manage Buying<br /> Request</a></li>
                    <li><a href="#">Manage Requests<br /> for Quotations</a></li>
                    <li><a href="#">Manage Sample<br /> Request</a></li>
                </ul>-->
<!--                <div class="support">
                    <p class="head_text">Support</p>
                    <p>Jaqueline is <span>Online</span></p>
                </div>-->
<!--                <form action="">
                    <textarea cols="" rows="" onfocus="if(this.value=='eg... Ask me a question?') this.value='';" onblur="if(!this.value) this.value='eg... Ask me a question?';" >eg... Ask me a question?</textarea>
                    <input type="submit" value="Ask" />
                </form>-->
            </div>
            <div class="middle">
            <h2>Add a New Buying Request</h2>
                                        <h2>Select your Catergory:</h2>
                                        <form method="post" action="<?php echo base_url(); ?>request/buy/">
                                            <div class="scrollbarsContainer">
                                                <div class="scrollbars">
                                                        <div class="left_scrollbar">
                                                        <ul id="sel_level_1">
                                                            <?php
                                                                foreach($categories as $list){
                                                                //echo "<option value='".$list['category_id']."'".">";
                                                                    echo "<li id='".$list['category_id']."'>";
                                                                    echo $list['category_name'];
                                                                    echo "</li>";                                
                                                                }                        
                                                            ?>   
                                                        </ul>
                                                    </div>
                                                    <div class="middle_scrollbar">
                                                        <ul id="sel_level_2">
                                                                <li> </li>
                                                        </ul>
                                                    </div>
                                                    <div class="middle_scrollbar">
                                                        <ul id="sel_level_3">
                                                                <li> </li>
                                                        </ul>
                                                    </div>
                                                    <div class="right_scrollbar">
                                                        <ul id="sel_level_4">
                                                                <li> </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <table>
                        <tr>
                            <td colspna="4">
                            Categories Selected :
                            <div id="cDisp"></div>
                            </td>
                        </tr>
                        <tr>
                            <td colspna="4">
                            <input type ='hidden' name='category_id' id='category_id' value=''>
                            <input type ='hidden' name='catdisplay' id='catdisplay' value=''>
                            <input type="submit" id="next" name="next" onclick="next();" value="Next" disabled class="select_category_next" />
                            </td>                    
                        </tr>
                    </table>  
            </div>
        </div>
    </div>
</div>