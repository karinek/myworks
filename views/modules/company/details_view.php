<!-- might not used any more -->

<?php
$my_favourites = array();
$my_contacts = array();
$my_networks = array();
$userID = $this->m_session->isLogin();
if($userID){
    $my_favourites = $this->M_user->getFavouriteCompanyIds($userID);
    $my_contacts = $this->M_user->getContactCompanyIds($userID);
    $my_networks = $this->M_user->getNetworkCompanyIds($userID);
}
$latitude = ($company_detail['latitude'] != '')?$company_detail['latitude']:'14.597466';
$longitude = ($company_detail['longitude'] != '')?$company_detail['longitude']:'121.0092';
?>
<script type="text/javascript">
    var baseurl = '<?php echo base_url(); ?>';
</script>
<script type="text/javascript" src="http://www.google.com/jsapi?autoload={'modules':[{name:'maps',version:3,other_params:'sensor=false'}]}"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/google_map.js"></script>
<script type="text/javascript">
      /**
       * Called on the intiial page load.
      */
      var map;
      var userLocationMarker;
      var userLocation;
      var userLocationCircle;
      var newShopMarker;
      var newShopInfoWindow;
      var infoWindowIsOpen;
      function init() {
        var mapCenter = new google.maps.LatLng(0, 0);
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 5,
          center: new google.maps.LatLng(<?php echo $latitude; ?>, <?php echo $longitude; ?>),
          mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var icon = new google.maps.MarkerImage('my-location.png',
          new google.maps.Size(5, 5),
          new google.maps.Point(0, 0),
          new google.maps.Point(7, 7));

        userLocationMarker = new google.maps.Marker({
          icon: icon
          });

        userLocationCircle = new google.maps.Circle({
          fillColor: '#00f',
          fillOpacity: 0.1,
          strokeColor: '#00f',
          strokeOpacity: 0.3,
          strokeWeight: 1
        });
        userLocationCircle.bindTo('center', userLocationMarker, 'position');
        getUsersLocation();
        addGotoUsersLocationButton();
        addAddNewShopButton();
      }
      // Register an event listener to fire when the page finishes loading.
      google.maps.event.addDomListener(window, 'load', init);
</script>
<!-- PRODUCT TABS -->
            <div id="office_tabs_block">
            	<ul id="office_tabs">
                    <li class="my_office active">Home</li>
                    <li class="contacts_messages"><a href="<?php echo base_url(); ?>compproducts/index/<?php echo $company_detail['id']; ?>">Products</a></li>
                    <li class="company_page"><a href="#">Contact</a></li>
                </ul>
                <div id="office_tabs_content">
                	<div class="my_office_page company">
                    	<div class="company_left">
                            <?php if($company_detail['file'] != ''): ?>
                                <img src="<?php echo base_url(); ?>images/company_images/<?php echo $company_detail['file']; ?>" alt="" />
                            <?php else: ?>
                                <img src="<?php echo base_url(); ?>images/no_photo_detail.gif" width="120" height="120" alt="" style="border:1px solid #999999;" />
                            <?php endif; ?>    
                            <h2><?php echo $company_detail['name']; ?></h2>
                            <p><b>Website:</b> <a class="green" href="<?php echo $company_detail['website']; ?>" target="_blank"><?php echo $company_detail['website']; ?></a><br />
                            <b>Email:</b> <a href="emailto:"><?php echo $company_detail['email']; ?></a>
                            <b>Phone:</b> <?php echo $company_detail['phone']; ?><br />
                            <b>Fax:</b> <?php echo $company_detail['fax']; ?></p>
                            <p><b>Business Type:</b> <?php echo $company_detail['business_type']; ?> <br />
                            <b> We Sell:</b> <?php echo $company_detail['sell_product']; ?><br />
                            <b>Product Services:</b> 
                            <?php
                            $services = array();
                            $services_array = array();
                            if($company_detail['service'] != ''):
                                $services_array = explode('|', $company_detail['service']);
                            endif; 
                            foreach($service_options as $service_option):
                                if(in_array($service_option['id'], $services_array)):
                                    $services[] = $service_option['name'];
                                endif;
                            endforeach;
                            echo implode(', ', $services);
                            ?> <br />
                            <b>Company Certification::</b> 
                            <?php
                            $certifications = array();
                            $certification_array = array();
                            if($company_detail['certification'] != ''):
                                $certification_array = explode('|', $company_detail['certification']);
                            endif; 
                            foreach($certification_options as $certification_option):
                                if(in_array($certification_option['id'], $certification_array)):
                                    $certifications[] = $certification_option['name'];
                                endif;
                            endforeach; 
                            echo implode(', ', $certifications);
                            ?> <br />
                            <b>Year Registered:</b> <?php echo $company_detail['year']; ?><br />
                            <b>List Brands:</b> <?php echo $company_detail['brand']; ?><br />
                            
                            <b>Ownership Type:</b> <?php echo ($company_detail['ownership_type'])?M_options::getOwnerShipDetails($company_detail['ownership_type']):''; ?><br />
                            <b>Registered Capital:</b> <?php echo ($company_detail['registered_capital'])?M_options::getRegisteredCapital($company_detail['registered_capital']):''; ?><br />
                            <b>Legal Owner:</b> <?php echo $company_detail['owner']; ?><br />
                            <b>Annual Sales Volume:</b> <?php echo ($company_detail['annual_sale'])?M_options::getAnnualSaleDetails($company_detail['annual_sale']):''; ?><br />
                            <b>Export Percentage:</b> <?php echo ($company_detail['export_per'])?M_options::getExportPercentages($company_detail['export_per']):''; ?><br />
                            <b>List Main Customers:</b> <?php echo $company_detail['customer']; ?><br />
                            <b>Factory Location:</b> <?php echo $company_detail['factory_location']; ?><br />
                            <b>Factory Size:</b> <?php echo ($company_detail['factory_size'])?M_options::getFactorySizeDetails($company_detail['factory_size']):''; ?><br />
                            <b>Total Annual Purchase Volume:</b> <?php echo ($company_detail['factory_purchase'])?M_options::getAnnualPurchaseVolume($company_detail['factory_purchase']):''; ?><br />
                            <b>Production Lines:</b> <?php echo ($company_detail['factory_productionline'])?M_options::getProductionLines($company_detail['factory_productionline']):''; ?><br />
                            <b>Quality Control:</b> <?php echo ($company_detail['factory_qc'])?M_options::getQualityControlDetails($company_detail['factory_qc']):''; ?><br />
                            <b>No. Staff:</b> <?php echo ($company_detail['factory_no_staff'])?M_options::getNumberofStaff($company_detail['factory_no_staff']):''; ?><br />
                            <b>No. QC Staff:</b> <?php echo ($company_detail['factory_no_qc'])?M_options::getNumberofStaff($company_detail['factory_no_qc']):''; ?><br />
                            <b>No Employees:</b> <?php echo ($company_detail['no_employee'])?M_options::getNoEmployee($company_detail['no_employee']):''; ?><br />
                            </p>
                            <p><b>Location:</b> <?php echo $country_name; ?><br />
                            <b>Company Address:</b> <?php echo $company_detail['address']."\t".$company_detail['city']."\t".$country_name; ?></p>
                            
                            <div class="add_to_my_favourites" id="add_to_favorites<?php echo $company_detail['id']; ?>" >
                            <?php if(in_array($company_detail['id'], $my_favourites)): ?>
                                     My Favorite
                            <?php else: ?>
                                    <a class="img_link" style="cursor:pointer;" id="linkAddCompanyFavourite<?php echo $company_detail['id']; ?>" data-favourite="<?php echo $company_detail['id']; ?>" >
                                        Add To Favorites
                                    </a>
                            <?php endif; ?>
                            </div>
                            <div class="add_to_my_contacts" id="contact_company<?php echo $company_detail['id']; ?>" >
                                <?php if(in_array($company_detail['id'], $my_contacts)): ?>
                                     My Contact
                                <?php else: ?>
                                     <a id="linkAddCompanyContact<?php echo $company_detail['id']; ?>" data-contact="<?php echo $company_detail['id']; ?>">Add to My Contacts</a>
                                <?php endif; ?>
                            </div>
                            <div class="add_to_my_network" id="add_to_wishlist<?php echo $company_detail['id']; ?>" >
                                <?php if(in_array($company_detail['id'], $my_networks)): ?>
                                     My Network
                                <?php else: ?>
                                     <a id="linkAddCompanyNetwork<?php echo $company_detail['id']; ?>" data-network="<?php echo $company_detail['id']; ?>">Add to My Network</a>
                                <?php endif; ?>
                            </div>
                            <h2>Company Introduction:</h2>
                            <p><?php echo $company_detail['product_keyword']; ?></p>
                            <h2>Company Representatives:</h2>
                            <div class="company_representatives">
                                <?php if(isset($staffList) && !empty($staffList)): ?>
                                        <?php foreach($staffList as $staff): ?>
                                            <div class="company_representatives_item">
                                                <img src="<?=base_url()?>images/user_images/<?=isset($staff->image) && !empty($staff->image)? $staff->image : 'no-photo.jpg'?>" width="100" height="100" alt="" />
                                                <p><a href="#"><span class="green"><?php echo $staff->firstname."\t".$staff->lastname; ?></span><br /><?php echo $staff->position; ?></a></p>
                                            </div>
                                        <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="company_right">
                        	<div style="overflow:hidden">
                            <div class="headquarters">
                            	<h2>Headquarters:</h2>
                                <div id="map" style="width:260px; height:240px;"></div>
                            </div>
                            <div class="news">
                            	<h2>News:</h2>
                                <div class="news_scrollbar">
                                        <?php if(isset($news) && !empty($news)): ?>
                                            <ul>
                                                <?php foreach($news as $news_item): ?>
                                                        <li>
                                                            <p class="head"><b><?php echo $news_item->title; ?></b></p>
                                                            <p><b><?php echo $news_item->content; ?></b></p>
                                                        </li>
                                                <?php endforeach; ?>
                                            </ul>    
                                        <?php endif; ?>
                                    </div>
                            </div>
                            </div>
                            <h2>Company Network:</h2>
                            
                            <div class="company_network_block">
                            	<?php if(isset($networks) && !empty($networks)): ?>
                                    <?php $i = 1; ?>
                                    <?php foreach($networks as $network): ?>
                                        <div class="company_network_block_item <?=($i %2 ==0)?"right_item":""; ?>">
                                            <a href="#">
                                                <img src="<?=base_url()?>images/<?=isset($network['file']) && !empty($network['file'])? 'company_images/'.$network['file'] : 'no_photo_detail.gif'; ?>" width="257" height="100" alt="" />
                                            </a>
                                            <p class="green"><a href="<?php echo base_url(); ?>company/details/<?php echo $network['id']; ?>"><?php echo $network['name']; ?> </a></p>
                                            <p><b>Country:</b> 
                                            <?php foreach ($country_options as $key=>$val):
                                                    if($network['country'] == $key):
                                                        echo $val;
                                                        break;
                                                    endif;
                                            endforeach; ?><br/>
                                            <b>Business Type:</b> <?php echo $network['business_type']; ?><br />
                                            <b>Address:</b> <?php echo $network['address'].",\t".$network['city']."\t"; ?></p>
                                            <a class="red" href="<?php echo base_url(); ?>company/details/<?php echo $network['id']; ?>">View</a>
                                        </div>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
			    <?php if(isset($networks) && !empty($networks)): ?>
                            <ul class="my_contacts_pagination">
                                <li><a href="#">Last Page</a></li>
                                <li class="next disable"><a href="#"></a></li>
                                <li class="prev disable"><a href="#"></a></li>
                                <li>Page <span>1</span> / 1</li>
                            </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Product Tabs -->
    <div id="contentBox">
    	
</div>