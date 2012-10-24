<html>
<head>
<script language="javascript" src="<?php echo base_url(); ?>js/jquery-1.7.2.min.js"></script>
<script language="javascript" src="<?php echo base_url(); ?>js/product/add.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/product_view.css" />
<title>Upload New Product</title>
</head>


<style type="text/css">

body {
 background-color: #fff;
 margin: 40px;
 font-family: Lucida Grande, Verdana, Sans-serif;
 font-size: 14px;
 color: #4F5155;
}

</style>
<body>
<H1>Add New Product</H1>

<form action="<?php echo base_url(); ?>index.php/product/add" method="post" accept-charset="utf-8" id="frm_addproduct" id="frm_addproduct" enctype="multipart/form-data">
<table>
    <tr>
        <td>
            1.Select a Category <b>2.Add Product Details</b> 3.Awaiting Approval
        </td>
    </tr>
    <tr>
        <td>
            <b>Categories Selected : </b>
            <?php
            echo $_POST['catdisplay'];
            ?>
        </td>
    </tr>
    <tr>
        <td><label for="binfo">Basic Information</label>
            <table>
                <tr>
                    <td>
                        <label>*Product Name : &nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text" name="prod_name" id="prod_name" size="55" >
                    </td>
                    <td>
                         <div class="error" id="pname_err"></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>*Product Keyword : </label><input type="text" name="prod_kwd" id="prod_kwd" size="55" >
                    </td>
                    <td>
                         <div class="error" id="pkwd_err"></div>
                    </td>                                        
                </tr>
                <tr>
                    <td>
                        <label>*Listing Description :</label>
		    
                        <textarea rows="4" cols="40" name="short_desc" id="short_desc"></textarea>
                    </td>
                    <td>
                        <div class="error" id="sht_desc_err"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label>Product Photo :</label>
                        <input type="file" name="userfile" size='50px' />
                        
                    </td>
                </tr>
                
                <?php                            if(!empty($attrList))
                {
                    echo "<tr>";
                    echo "<td colspan=\"2\">";
                    echo "<label>Product Details :</label>";
                    echo "<fieldset>";
                    echo $attrList;                                      
                    echo "</fieldset>";
                    echo "</td>";    
                    echo "</tr>";
                }
                ?>
                              
            </table>
        </td>
    </tr>
     <tr>
        <td>
            <a id="prodDetaiDesc" href="javascript:showSubMenu('detailDesc');">Detailed Description</a>
            <div id="detailDesc" style="display: none">
                <textarea name="long_desc" id="long_desc" cols="100" rows="5">
                </textarea>
           </div>
           
        </td>
    </tr>
     <tr>
        <td>
            <a id="extTradeInfo" href="javascript:showSubMenu('tradeInfo');">Additional Trade Information</a>
            <div id="tradeInfo" style="display: none">
            <table>
                <tr>
                    <td>
                        Min.Order Quantity : <input type="text" name="qty" id="qty" >
                        <?php echo form_dropdown('qty_unit', $unitList);?> 
                    </td>
                </tr>
                <tr>
                    <td>
                        FOB Price
                        <?php echo form_dropdown('prc_cur', $curList);?> 
                        <input type="text" name="cur_prc1" id="cur_prc1"> - <input type="text" name="cur_prc2" id="cur_prc2"> per
                        <?php echo form_dropdown('cur_unit', $unitList);?> 
                    </td>
                </tr>
                <tr>
                    <td>
                        Port <input type="text" name="port" id="port">
                    </td>
                </tr>
                <tr>
                    <td>
                        Payment Terms
                        <input type="checkbox" name="pay_terms[]" value="L/C" />L/C
                        <input type="checkbox" name="pay_terms[]" value="D/A" />D/A
                        <input type="checkbox" name="pay_terms[]" value="D/P" />D/P
                        <input type="checkbox" name="pay_terms[]" value="T/T" />T/T
                        <input type="checkbox" name="pay_terms[]" value="Western Union" />Western Union
                        <input type="checkbox" name="pay_terms[]" value="MoneyGram" />MoneyGram
                        <input type="checkbox" name="pay_terms[]" value="MoneyGram" />Other
                    </td>
                </tr>
                <tr>
                    <td>
                       Production Capacity
                       <input type="text" name="prod_cpt">
                      <?php echo form_dropdown('cpt_unit', $unitList);?> 
                        per
                       <select name="cpt_prd">
                            <option>Day</option>
                            <option>Quarter</option>
                            <option>Week</option>
                            <option>Month</option>
                            <option>Year</option>
                       </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        Delivery Times <input type="text" name="dlv_t">
                    </td>
                </tr>
                <tr>
                    <td>
                        Packaging Details
                        <textarea id="p_dts" name="p_dts" cols="100" rows="5">
                        </textarea>
                    </td>
                </tr>
            </table>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <input type="hidden" name="category_id" value="<?php echo $_POST['category_id']; ?>"> 
            <input type='hidden' name='submit_addprdduct' value="1">
            <input type='hidden' name="dyn_attr_count" id="dyn_attr_count"  value="">
            <input type="button" id="submit_add" name="submit_add" value="Add Product" onClick='javascript:submitfrm();'/>            
        </td>
               
    </tr>
</table>        
</form>

</body>
</html>