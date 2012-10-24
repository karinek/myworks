<html>
<head>
<title>Add Product - Select Category</title>
<script language="javascript" src="<?php echo base_url(); ?>js/jquery-1.7.2.min.js"></script>

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
  $("#sel_level_1").click(function() {
    
        $("#select_id").css('pointer-events','none');
    
        document.getElementById('category_id').value = this .value;
        stringTitle1 =  "<i>" + this.options[this.selectedIndex].innerHTML + "</i>";
         
        disp.innerHTML = stringTitle1;  
        document.getElementById('catdisplay').value = disp.innerHTML;
        stringTitle2 = '';
        stringTitle3 = '';
        stringTitle4 = '';
         
        var urlstring = "<?php echo base_url(); ?>index.php/product/addproductstep1/" + this .value;
        
        $.get(urlstring,
        function(data) {
            $("#select_id").css('pointer-events','auto');
        
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
              sel.append('<option value="' + data[i].category_id+ '">' + data[i].category_name + '</option>');
            }
         }
        }, "json");
    });
  
     $("#sel_level_2").click(function() {
         document.getElementById('category_id').value = this .value;   
        stringTitle2 =  "<i>" + this.options[this.selectedIndex].innerHTML + "</i>";
        disp.innerHTML = stringTitle1 + "   >>   " +stringTitle2;
        document.getElementById('catdisplay').value = disp.innerHTML;
        stringTitle3 = '';
        stringTitle4 = '';
         var urlstring = "<?php echo base_url(); ?>index.php/product/addproductstep1/" + this .value;
       
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
              sel.append('<option value="' + data[i].category_id+ '">' + data[i].category_name + '</option>');
            }
         }
      }, "json");
      });
  
       $("#sel_level_3").click(function() {
         document.getElementById('category_id').value = this .value;
        stringTitle3 =  "<i>" + this.options[this.selectedIndex].innerHTML + "</i>";
        disp.innerHTML = stringTitle1 + "   >>   " +stringTitle2 + "   >>   " +stringTitle3;
        document.getElementById('catdisplay').value = disp.innerHTML;
        stringTitle4 = '';
        document.getElementById('category_id').value = this .value;
        
        var urlstring = "<?php echo base_url(); ?>index.php/product/addproductstep1/" + this .value;
       
        $.get(urlstring,
        function(data) {
          
        
          
          var sel = $("#sel_level_4");
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
              sel.append('<option value="' + data[i].category_id+ '">' + data[i].category_name + '</option>');
            }
         }
      }, "json");
      });
       
     $("#sel_level_4").click(function() {
     
         document.getElementById('category_id').value = this .value;
         document.getElementById('next').disabled = false;
         stringTitle4 =  "<i>" + this.options[this.selectedIndex].innerHTML + "</i>";
         disp.innerHTML = stringTitle1 + "   >>   " +stringTitle2 + "   >>   " +stringTitle3 + "   >>   " +stringTitle4;
         document.getElementById('catdisplay').value = disp.innerHTML;
     });

});
  </script>
</head>
<body>
<H1>Upload New Product - Product Categories</H1>
        <table>
            <tr>
                <td>                    
                    <b>1.Select a Category</b> 2.Add Product Details 3.Awaiting Approval
                </td>
            </tr>
            <tr>            
                <td>
                <br>
                Select Category
                <td>
            </tr>
           
        </table>
	<br>
	
        <form name="cList" method="post" action="<?php echo base_url(); ?>index.php/product/addproductstep2/">        
       
       <div id='select_id' style='overflow-x:scroll;overflow-y:hidden;width:490px;height:220px;border:1px solid #ff0000;'>
	


        <table name="dispCategory">
            <tr>
                <td>
                    
		    <div id="fDesc">
                    <select style='width:150px;' name="sel_level_1" id="sel_level_1" size="10">
                        <?php
                            foreach($categories as $list){
                            //echo "<option value='".$list['category_id']."'".">";
                                echo "<option id='".$list['category_id']."' "."value='".$list['category_id']."'".">";
                                echo $list['category_name'];
                                echo "</option>";                                
                            }                        
                        ?>                        
                    </select>
                    </div>
                </td>
                <td>
                   <div id="sDesc"><select style='width:150px;' name="sel_level_2" id="sel_level_2" size="10"></select></div>
                </td>
                <td>
                    <div id="tDesc"><div id="sDesc"><select style='width:150px;' name="sel_level_3" id="sel_level_3" size="10"></select></div></div>                    
                </td>
                <td>
                    <div id="mDesc"><div id="sDesc"><select style='width:150px;' name="sel_level_4" id="sel_level_4" size="10"></select></div></div>
                </td>
            </tr>
        </table>
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
                <input type="submit" id="next" name="next" onclick="next();" value="Next" disabled />
                </td>                    
            </tr>
        </table>    
        </form>
</body>
</html>
