<html>
<head>
<script language="javascript" src="<?php echo base_url(); ?>js/jquery-1.7.2.min.js"></script>

<script language="javascript" src="<?php echo base_url(); ?>js/test_view.js"></script>
<title>Trade Office Test Page</title>

<script language="javascript">
 var attr_count = 0;
 
 
function trim(stringToTrim) {
	return stringToTrim.replace(/^\s+|\s+$/g,"");
    }
function addCustAttr()
{
   attr_count++;
   if(attr_count > 10)
   {
      alert('Only 10 custom attributes allow for this category.thank you.');
      attr_count--;
      return false;
   }
   
   title_name = "title_" + attr_count;
   value_name = "value_" + attr_count;
   div_name = "attr_div" + attr_count;
   parent_div = document.getElementById('my_div');
   
   inner_div = document.createElement("div"); 
   inner_div.id = div_name;
   
   el = document.createElement("input");  
   el.name = title_name;
   el.type = "text";
   el.value = "";
   el.id = title_name;
   inner_div.appendChild(el);
   
   el = document.createElement("input");  
   el.name = title_name;
   el.type = "text";
   el.value = "";
   el.id = value_name;
   inner_div.appendChild(el); 
   
   parent_div.appendChild(inner_div);
   
   }
function remCustAttr()
{
   if(attr_count>0)
   { 
      div_name = "attr_div" + attr_count;   
      child_div = document.getElementById(div_name);
      parent_div = document.getElementById('my_div');
      parent_div.removeChild(child_div);
      attr_count--;
   }
}
function validateCustAttr()
{
        for (i=1;i<= attr_count;i++)
         {
            title_name = "title_" + i;
            value_name = "value_" + i;
            title_field = document.getElementById(title_name);
            value_field = document.getElementById(value_name);
            title_field_str = trim(title_field.value);
            value_field_str = trim(value_field.value);
            
             if(title_field_str.length == 0)
             {
               alert('please enter the value in the required field.');
               title_field.focus();
               return false;
             }
             else if(value_field_str.length == 0)
             {
               alert('please enter the value in the required field.');
               value_field.focus();
               return false;
             }
         }
       
}
function updateFieldValue(ele)
{
   ele.value= ele.value;
}

</script>

<style type="text/css">

body {
 background-color: #fff;
 margin: 40px;
 font-family: Lucida Grande, Verdana, Sans-serif;
 font-size: 14px;
 color: #4F5155;
}

</style>
<!--
<script type="text/javascript">
$(document).ready(function(){
  $("button").click(function(){
    $("p").slideToggle()
  });
});
</script>
-->

</head>
<body>

<h1> Hello World, This is test page. Today Friday Evening. </h1>
<br>
<body>
    <?php //echo $content; ?>
	<?php echo 'hello'; ?>
</body>

</body>
</html>