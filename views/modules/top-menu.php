<?php
	if(!isset($regions))
		$regions = isset($this->m_country)?$this->m_country->getAllRegionName():(isset($this->M_country)?$this->M_country->getAllRegionName():array());
?>
<script>
    var base_url = '<?php echo base_url(); ?>';
    $(document).ready(function(e) {
        
        
        $('#region').selectbox({
            onChange: function (val, inst) {
                $.ajax({
                    type: "GET",
                    url: base_url + '/welcome/getcountries/' + val,
                    success: function (data) {
                        $("#country").html(data);
                        $("#country_id2").selectbox();
                    }
                });
            }
        });
        
        /* LEFT MENU */
        var adv_search_cdisp = document.getElementById("adv_search_cdisp");
        var catTitle1 = '';
        var catTitle2 = '';
        var catTitle3 = '';
        var catTitle4 = '';
        
        var formPath = '';

        $('.advanced_categories li').hover(function(){
            var id = $(this).attr('id');
            $('#'+id+' .advanced_submenu').show();
        },
        function(){
            var id = $(this).attr('id');
            $('#'+id+' .advanced_submenu').hide();
        });
        
        $('#categories_1 a').live('click', function(event){

        	$('#categories_1 .advanced_submenu').hide();
        	$('#categories_1 .advanced_submenu_title').html($(this).text()+'<span></span>');
        	var col = $(this) .attr('tp');
        	$('.advanced_search_path .green').text(col);
        	$('.advanced_search_path #path').text($(this).text());
        	$('#category_field').val($(this) .attr('id'));
        	if(parseInt($(this) .attr('id')) == 0){
                var sel3 = $("#category_inner_1");
                sel3.html('<span>Sub Category 1</span>');
                var sel3 = $("#category_inner_2");
                sel3.html('<span>Sub Category 2</span>');
                var sel4 = $("#category_inner_3");
                sel4.html('<span>Sub Category 3</span>');
                $("#category_inner_1").addClass('disable');
                $("#category_inner_2").addClass('disable');
                $("#category_inner_3").addClass('disable');
                return false;
            }
                var urlstring = "<?php echo base_url(); ?>index.php/product/addproductstep1/" + $(this) .attr('id');
                var id = $(this) .attr('id');
                $.get(urlstring,
                function(data) {
                    var sel3 = $("#category_inner_2");
                    sel3.html('<span>Sub Category 2</span>');
                    var sel4 = $("#category_inner_3");
                    sel4.html('<span>Sub Category 3</span>');
                    if(jQuery.isEmptyObject(data))
                    {
                        var sel4 = $("#category_inner_2");
                        sel4.html('<span>Sub Category 2</span>'); 
                    }
                    else
                    {
                        var str = "";
                        str += '<a href="#" class="advanced_submenu_title">Choose Category1<span></span></a>';
                        str += '<div class="advanced_submenu">';
                        str += '<p><a href="#" tp="'+col+'" id="0" rel="'+id+'">All</a></p>';
                        for (var i=0; i<data.length; i++) {

                            str += '<p><a href="#" tp="' + data[i].total_products + '" id="' + data[i].category_id + '">' + data[i].category_name + '</a></p>';
                            //str += '<option value="' + data[i].category_id+ '">' + data[i].category_name + '</option>';
                        }
                        str += '</div>';
                        $("#category_inner_1").removeClass('disable');
                        $("#category_inner_2").addClass('disable');
                        $("#category_inner_3").addClass('disable');
                    }
                    $("#category_inner_1").html(str);
              
            	}, "json");
        });
        $('#category_inner_1 a').live('click', function(event){
        	$('#category_inner_1 .advanced_submenu').hide();
        	$('#category_inner_1 .advanced_submenu_title').html($(this).text()+'<span></span>');
        	var col = $(this) .attr('tp');
        	$('.advanced_search_path .green').text(col);        	
        	$('.advanced_search_path #path').text($('#categories_1 .advanced_submenu_title').text()+' > '+$(this).text());
        	$('#category_field').val($(this) .attr('id'));
        	if(parseInt($(this) .attr('id')) == 0){
                var sel3 = $("#category_inner_2");
                sel3.html('<span>Sub Category 2</span>');
                var sel4 = $("#category_inner_3");
                sel4.html('<span>Sub Category 3</span>'); 
                $('#category_field').val($(this) .attr('rel'));
                $("#category_inner_2").addClass('disable');
                $("#category_inner_3").addClass('disable');
                return false;       	
            }        	
                var urlstring = "<?php echo base_url(); ?>index.php/product/addproductstep1/" + $(this) .attr('id');
                var id = $(this) .attr('id');
                $.get(urlstring,
                function(data) {
                    var sel4 = $("#category_inner_3");
                    sel4.html('<span>Sub Category 3</span>');
                    if(jQuery.isEmptyObject(data))
                    {
                        var sel4 = $("#category_inner_3");
                        sel4.html('<span>Sub Category 3</span>'); 
                    }
                    else
                    {
                        var str = "";
                        str += '<a href="#" class="advanced_submenu_title">Choose Category2<span></span></a>';
                        str += '<div class="advanced_submenu">';
                        str += '<p><a href="#" tp="'+col+'"  rel="'+id+'" id="0">All</a></p>';
                        for (var i=0; i<data.length; i++) {

                            str += '<p><a href="#" tp="' + data[i].total_products + '" id="' + data[i].category_id + '">' + data[i].category_name + '</a></p>';
                            //str += '<option value="' + data[i].category_id+ '">' + data[i].category_name + '</option>';
                        }
                        str += '</div>';
                        $("#category_inner_2").removeClass('disable');
                    }
                    $("#category_inner_2").html(str);
        
              
            	}, "json");
        });

        $('#category_inner_2 a').live('click', function(event){
        	$('#category_inner_2 .advanced_submenu').hide();
        	$('#category_inner_2 .advanced_submenu_title').html($(this).text()+'<span></span>');
        	var col = $(this) .attr('tp');
        	$('.advanced_search_path .green').text(col);        	
        	$('.advanced_search_path #path').text($('#categories_1 .advanced_submenu_title').text() + ' > ' + $('#category_inner_1 .advanced_submenu_title').text()+' > '+$(this).text());
        	$('#category_field').val($(this) .attr('id'));
        	if(parseInt($(this) .attr('id')) == 0){
                var sel4 = $("#category_inner_3");
                sel4.html('<span>Sub Category 3</span>');    
                $('#category_field').val($(this) .attr('rel'));
                return false;       	
            }        	
                var urlstring = "<?php echo base_url(); ?>index.php/product/addproductstep1/" + $(this) .attr('id');
                var id = $(this) .attr('id');
                $.get(urlstring,
                function(data) {
                    var sel4 = $("#category_inner_3");
                    sel4.html('<span>Sub Category 3</span>');
                    if(jQuery.isEmptyObject(data))
                    {
                        var sel4 = $("#category_inner_3");
                        sel4.html('<span>Sub Category 3</span>');
                        $("#category_inner_3").addClass('disable');
                    }
                    else
                    {
                        var str = "";
                        str += '<a href="#" class="advanced_submenu_title">Choose Category3<span></span></a>';
                        str += '<div class="advanced_submenu">';
                        str += '<p><a href="#" tp="'+col+'" id="0"  rel="'+id+'">All</a></p>';
                        for (var i=0; i<data.length; i++) {

                            str += '<p><a href="#" tp="' + data[i].total_products + '" id="' + data[i].category_id + '">' + data[i].category_name + '</a></p>';
                            //str += '<option value="' + data[i].category_id+ '">' + data[i].category_name + '</option>';
                        }
                        str += '</div>';
                        $("#category_inner_3").removeClass('disable');
                    }
                    $("#category_inner_3").html(str);
        
              
            	}, "json");
        });        

        $('#category_inner_3 a').live('click', function(event){
        	$('#category_inner_3 .advanced_submenu').hide();
        	$('#category_inner_3 .advanced_submenu_title').html($(this).text()+'<span></span>');
        	var col = $(this) .attr('tp');
        	$('.advanced_search_path .green').text(col);   
        	$('.advanced_search_path #path').text($('#categories_1 .advanced_submenu_title').text() + ' > ' + $('#category_inner_1 .advanced_submenu_title').text() + ' > ' + $('#category_inner_2 .advanced_submenu_title').text() +' > '+$(this).text());

        	$('#category_field').val($(this) .attr('id'));
        	if(parseInt($(this) .attr('id')) == 0){
                $('#category_field').val($(this) .attr('rel')); 
                return false;       	
            }         	     	
        });

    	function format(item) {
    		return item.name + " <span>" +  item.count + " results</span>";
    	}
    	
        $('#keyword').autocomplete('<?php echo base_url(); ?>search/autocomplete',{
        		dataType: "json",
        		parse: function(data) {
        			return $.map(data, function(row) {
        				return {
        					data: row,
        					value: row.name,
        					result: row.name
        				};
        			});
        		},
        		formatItem: function(item) {
        			return format(item);
        		},
        		minChars: 2        		
            });
            
           
    })
</script>
<?php if (isset($modules) && M_misc::checkModule($modules, 'top-menu')): ?>
<!--//<?php //echo base_url(); ?>search-->
    <!-- TOP MENU -->
    
        <ul class="top_nav">
            <form name="search_form" id="search_form" action="<?php echo base_url(); ?>search" method="get">
            <li class="input_state">
                <input type="text" name="keyword" id="keyword" value="<?php echo (isset($_GET['keyword'])) ? $_GET['keyword'] : 'eq... Rubber Housing'; ?>" onfocus="if(this.value=='eq... Rubber Housing') this.value='';" onblur="if(!this.value) this.value='eq... Rubber Housing';" />
                <ul id="tabs">
                    <?php $active_tab = (isset($_GET['search_type'])) ? $_GET['search_type'] : 'products'; ?>
                    <li class="products <?php echo ($active_tab == 'products') ? 'active' : ''; ?>"><a href="#" title="products">Products</a></li>
                    <li class="suppliers <?php echo ($active_tab == 'seller') ? 'active' : ''; ?>"><a href="#" title="seller">Suppliers</a></li>
                    <li class="buyers <?php echo ($active_tab == 'buyer') ? 'active' : ''; ?>"><a href="#" title="buyer">Buyers</a></li>
                    <input type="hidden" name="search_type" id="search_type" value="<?php echo $active_tab; ?>" />
                </ul>
            </li>
            
            <li class="search">
                <span class="lup">
                    <input type="submit" value="Search" id="searchSubmit" onmousedown="searchApp.onSubmitWithQueryReport()" />
                </span>
            </li>
            </form>
            
            <form name="search_form" id="advanced_search_form" action="javascript:" method="post">
                <li class="advanced_search">
                    <a href="#">Advanced Search</a>

                </li>
                <li id="advanced_search_block">
                    <div class="advanced_item">
                        <?php $search_option = (isset($_GET['opt'])) ? $_GET['opt'] : 'AND'; ?>
                        <div class="checkbox"><input type="radio" name="opt" value="EXT" <?php echo ($search_option == 'EXT') ? 'checked="checked"' : ''; ?> /><label>Exact match</label></div>
                        <div class="checkbox"><input type="radio" name="opt" value="AND" <?php echo ($search_option == 'AND') ? 'checked="checked"' : ''; ?> /><label>All this words</label></div>
                        <div class="checkbox"><input type="radio" name="opt" value="OR" <?php echo ($search_option == 'OR') ? 'checked="checked"' : ''; ?> /><label>One or more of these words</label></div>
                        <div class="clear"></div>
                        <?php $membership_option = (isset($_GET['membership'])) ? $_GET['membership'] : 'free,gold,platinum'; ?>
                        <?php
							if(is_array($membership_option)){
								for($_i=0;$_i<count($membership_option);$_i++) $membership_option[$_i] = str_replace('\'','',$membership_option[$_i]);
							}else{
								$membership_option = explode(',', $membership_option);
							}
						?>
                        <div class="checkbox" style="display: none"><input type="checkbox" name="membership[]" id="searchFree" value="free" /><label>Free Memberships</label></div>
                        <div class="checkbox" style="display: none"><input type="checkbox" name="membership[]" id="searchGold" value="gold" /><label>Gold Memberships</label></div>
                        <div class="checkbox" style="display: none"><input type="checkbox" name="membership[]" id="searchPlatinum" value="platinum" /><label>Platinum Memberships</label></div>
                    </div>
                    <div class="clear"></div>
                    <div class="advanced_item" id="advanced_item">
                        <ul class="advanced_categories" style="margin-top:0px;">
                        <?php if (isset($regions) && is_array($regions)) { ?>
                                <li class="region">
                                    <select name="region" id="region" onchange="loadCountries()">
                                        <option value="0">All Region</option>
                                        <?php foreach ($regions as $region) { ?>
                                            <?php
                                                if (!empty($region['country_region'])) :
                                            ?> 
                                            <option value="<?php echo $region['country_region']; ?>">
                                                <?php echo $region['country_region']; ?>
                                            </option>
                                            <?php endif; ?>
                                        <?php } ?>
                                    </select>           
                                </li>
                            <?php } ?> 
                            <?php if (isset($countries) && is_array($countries)) { ?>
                                <li class="country region_country" id="country">
                                    <select name="country" id="country_id2">
                                        <option value="0">All Country</option>
                                    </select>           
                                </li>
                            <?php } ?>
                            
                        </ul>
                    </div>
                    <div class="advanced_item">
                        <ul class="advanced_categories" style="margin-top:0px;">
                            <li class="currency" style="display:none;">
                                <select name="currency" id="country_id1">
                                    <option value="1">$ AU</option>
                                    <option value="1">USA</option>
                                    <option value="9">Canada</option>
                                    <option value="2">France</option>
                                    <option value="3">Spain</option>
                                    <option value="6">Bulgaria</option>
                                    <option value="7" disabled="disabled">Greece</option>
                                    <option value="8">Italy</option>
                                    <option value="5">Japan</option>
                                    <option value="11">China</option>
                                    <option value="4">Brazil</option>
                                    <option value="10">South Africa</option>
                                </select>
                            </li>
                            <li class="time_period">
                                <select name="time_period" id="time_period1">
                                    <option value="0">Time Period</option>
                                    <option value="7" <?php echo (isset($_POST['time_period']) && $_POST['time_period'] == 7) ? 'selected="selected"' : ''; ?>>Last 7 days</option>
                                    <option value="8" <?php echo (isset($_POST['time_period']) && $_POST['time_period'] == 8) ? 'selected="selected"' : ''; ?>>Older</option>
                                </select>           
                            </li>
                            <li class="business_type">
                                    <?php echo form_dropdown('business_types',$business_type_options, set_value('business_types'), 'id="business_type"');?>
                            </li>
                            
                            <?php $total_products = 0;?>
                            <input type="hidden" name="category" id="category_field" value="0">   
                            <?php if (isset($categories) && is_array($categories)): ?>

                                <li class="categories" style="width:248px" id="categories_1">
                                    <a href="#" class="advanced_submenu_title">All Categories<span></span></a>
                                    <div class="advanced_submenu">
                                            <p><a href="#" tp="" id="0">All Categories</a></p>
                                        <?php foreach ($categories as $category) { ?>
                                            <?php $category = (object)$category; $total_products+= $category->total_products;?>
                                            <p><a href="#" tp="<?php echo $category->total_products; ?>" id="<?php echo $category->category_id; ?>"><?php echo $category->category_name; ?></a></p>
                                        <?php } ?>
                                    </div>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="advanced_item">
                        <ul class="advanced_categories" style="margin-top:0px;">
                            <li class="sub_categories disable" id="category_inner_1">
                                <span>Sub Category 1</span>
                            </li>
                            <li class="sub_categories disable" id="category_inner_2">
                                <span>Sub Category 2</span>
                            </li>
                            <li class="sub_categories disable" id="category_inner_3">
                                <span>Sub Category 3</span>
                            </li>
                        </ul>       
                    </div>
                    <div class="close"></div>
                    <input type="button" value="Go" class="addvanced_search_go" />
    <!--                <a href="#" class="addvanced_search_go">Go</a>-->
                    <div class="advanced_search_path"><span id="path" style="color:#000;">All Categories</span> ( <span class="green"><?=$total_products;?></span> )</div>
                </li>
            </form>
        </ul>
        
    
<?php endif; ?>