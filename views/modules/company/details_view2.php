<?php
$latitude = ($the_company->latitude != '')?$the_company->latitude:'-33.865124';
$longitude = ($the_company->longitude != '')?$the_company->longitude:'151.208675';
?>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBXjfrd7Mww1k9_mkmXEdk1WjPsHQkuIls&sensor=false"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/map-info.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/google_map.js"></script>
<script type="text/javascript">
	/**
	* Called on the intiial page load.
	*/
	Shadowbox.init({skipSetup: true});
	var map;
	var comapanyMarker;

	function init() {
		var mapCenter = new google.maps.LatLng(0,0);
		var comLoc = new google.maps.LatLng(<?php echo $latitude; ?>, <?php echo $longitude; ?>);
		map = new google.maps.Map(document.getElementById('map'), {
			zoom: 13,
			center: comLoc,
			panControl: false,
			zoomControl: false,
			mapTypeControl: true,
			scaleControl: false,
			streetViewControl: true,
			overviewMapControl: true,
			draggable:false,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		});
		
		var icon = new google.maps.MarkerImage('<?=base_url('/images/map-pin.png')?>',
			new google.maps.Size(22, 30),
			new google.maps.Point(0,0),
			new google.maps.Point(12, 25)
		);
		
		comapanyMarker = new google.maps.Marker({
			position: comLoc,
			map: map,
			icon: icon
		});
		
		var myOptions = {
			content: '<div style="margin: 8px; text-align: center;font-size:125%;font-weight:bold;">Headquarters</div>',
			disableAutoPan: false,
			maxWidth: 0,
			pixelOffset: new google.maps.Size(-74,-55),
			zIndex: null,
			boxStyle: {
				background: "url('<?=base_url('/images/map-tooltip.png')?>') no-repeat",
				color: '#fff',
				width: "147px",
				height: "41px"
			},
			closeBoxURL: "",
			infoBoxClearance: new google.maps.Size(1, 1),
			isHidden: false,
			pane: "floatPane",
			enableEventPropagation: false
		};
		
		var ib = new InfoBox(myOptions);
		ib.open(map, comapanyMarker);

		google.maps.event.addDomListener(comapanyMarker, 'click', function(e){
			openModal();
		});
		google.maps.event.addDomListener(ib, 'click', function(e){
			openModal();
		});
		google.maps.event.addDomListener(map, 'click', function(e){
			openModal();
		});
		function openModal(){
			Shadowbox.open({
				content: base_url+'company/map/<?=$the_company->id?>',
				player: 'iframe',
				title: 'Company Map',
				height: 380,
				width: 460
			});
		}
	}
	// Register an event listener to fire when the page finishes loading.
	google.maps.event.addDomListener(window, 'load', init);
	
	function intval(s){
		var n = parseInt(s,10);
		return isNaN(n)?null:n;
	}
	var loading = null;
	$(document).ready(function(){
		loading = {
			cont: 'company_network_block',
			el: null,
			el_mask: null,
			width: 0,
			height: 0,
			top: 0,
			left: 0,
			init: function(){
				if(!this.el){
					this.cont = $('#'+this.cont);
					this.el = $('<div class="loading"></div>');
					this.el.css({display:'none'});
					this.el_mask = $('<div class="loading-mask"></div>');
					this.el_mask.css({display:'none'});
					console.log(this.el_mask.length)
					$(document.body).append(this.el).append(this.el_mask);
				}
			},
			show: function(){
				this.init();
				this.width = this.cont.width();
				this.height = this.cont.height();
				this.top = this.cont.offset().top;
				this.left = this.cont.offset().left;
				this.el.css({
					top:this.top+(this.height/2 - 15),
					left:this.left+(this.width/2 - 15)
				});
				this.el.show();
				this.el_mask.css({
					width:this.width,
					height:this.height,
					top:this.top,
					left:this.left
				});
				this.el_mask.show();
			},
			hide:function(){
				this.el.hide();
				this.el_mask.hide();
			}
		};
		var $pagination = $('.my_contacts_pagination');
		var parent = $('.company_network_block');
		function requestPage(obj){
			var $this = $(obj);
			if($this.parent().hasClass('disable')) return false;
			var type = null;
			var url = base_url;
			var page = null;
			url += 'company/getnetwork/<?=$the_company->id?>/';
			page = intval($this.attr('href').replace('#',''));
			if(page!=null && page!=0){
				loading.show();
				var request = $.post(url+page,{},function(r){
					if(r.status){
						if(parent){
							console.log(JSON.stringify(r.result));
							var _item = null;
							parent.find('.company_network_block_item').remove();

							$pagination.find('.next-page').attr('href','#'+(r.pagination.cur<r.pagination.page?intval(r.pagination.cur)+1:r.pagination.page));
							$pagination.find('.last-page').attr('href','#'+r.pagination.page);
							if(r.pagination.cur==r.pagination.page){
								$pagination.find('.next-page').parent().addClass('disable');
								$pagination.find('.last-page').parent().addClass('disable');
							}else{
								$pagination.find('.next-page').parent().removeClass('disable');
								$pagination.find('.last-page').parent().removeClass('disable');
							}

							$pagination.find('.previous-page').attr('href','#'+(r.pagination.cur>1?intval(r.pagination.cur)-1:0));
							if(r.pagination.cur==1) $pagination.find('.previous-page').parent().addClass('disable');
							else $pagination.find('.previous-page').parent().removeClass('disable');

							$pagination.find('.current-page').html(r.pagination.cur);
							var cont = parent;
							var $i = 0;
							for(var i in r.result){
								_item = r.result[i];
								cont.append('<div class="company_network_block_item '+($i%2==1?'right_item':'')+'">'+
						'<div class="imageblock"> <img alt="'+_item.name+'" style="width:260px;height:100px;" src="'+base_url+'images/'+(_item.file!=''? 'company_images/'+_item.file : 'company.png')+'" class="company_logo"> </div>'+
						'<p class="green"><a href="'+base_url+'/company/details/'+_item.id+'">'+_item.name+'</a></p>'+
						'<p><b>Country:</b>China<br>'+
						'	<b>Business Type:</b> '+_item.business_type+'<br>'+
						'	<b>Address:</b> '+_item.address+'</p>'+
						'<a href="'+base_url+'/company/details/'+_item.id+'" class="red">View</a> </div>');
								$i++;
							}
						}
						$this.one('click',function(e){
							requestPage(this);
							e.preventDefault();
							return false;
						});
					}
					loading.hide();
				},'json')
				request.error(function(r){
					loading.hide();
					console.log(JSON.stringify(r));
				});
			}
		}
		
		$('a.last-page, a.next-page, a.previous-page').one('click',function(e){
			requestPage(this);
			e.preventDefault();
			return false;
		});
	});
</script>
<!-- PRODUCT TABS -->
<h3 class="page_links"><a href="<?=base_url()?>">Home</a>&nbsp;&gt;&nbsp; <a href="<?=base_url()?>company/">Company</a>
<div id="office_tabs_block">
	<ul id="office_tabs">
		<li class="my_office active">Home</li>
		<li class="contacts_messages"><a href="<?php echo base_url(); ?>comproductdetail/<?php echo M_encrypt::encode($the_company->id); ?>">Products</a></li>
		<li class="company_page" style="display:none;"><a href="#">Contact</a></li>
	</ul>
	<div id="office_tabs_content">
		<div class="my_office_page company">
			<div class="company_left">
				<div class="imageblock"> <img class="company_logo" src="<?=base_url('images/'.(isset($the_company->file) && !empty($the_company->file)? 'company_images/'.$the_company->file : 'company.png'))?>" style="width:260px;height:100px;" alt="<?=$the_company->name?>"> </div>
				<h2><?php echo $the_company->name; ?></h2>
				<ul class="download_stars" style="display:none;">
					<li class="star active"></li>
					<li class="star active"></li>
					<li class="star active"></li>
					<li class="star active"></li>
					<li class="star"></li>
					<li>( <span>12330</span> )</li>
				</ul>
				<p><b>Website:</b> <a class="green" href="<?php echo $the_company->website; ?>" target="_blank"><?php echo $the_company->website; ?></a><br />
					<b>Email:</b> <a href="emailto:"><?php echo $the_company->email; ?></a><br />
					<b>Phone:</b> <?php echo $the_company->phone; ?><br />
					<b>Fax:</b> <?php echo $the_company->fax; ?></p>
				<p><b>Industry we are in:</b> <?php echo $the_company->business_type; ?> <br />
					<b>Product we buy:</b> <?php echo $the_company->sell_product; ?><br />
					<b>Product Services:</b>
					<?php
						$services = array();
						$services_array = array();
						if($the_company->service != ''):
							$services_array = explode('|', $the_company->service);
						endif; 
						foreach($service_options as $service_option):
							if(in_array($service_option['id'], $services_array)):
								$services[] = $service_option['name'];
							endif;
						endforeach;
						echo empty($services)?'-':implode(', ', $services);
                    ?>
					</p>
					<b>Company Certification:</b><br />
					<?php
							if(count($the_company->company_license) && is_array($the_company->company_license)):
								$i = 0;
								foreach($the_company->company_license as $license):
							?>
					<?=$i%5==0 && $i>0 ? '<div class="clear"></div>':''?>
					<div class="certif_imageblock"><img class="company_licence" src="<?=is_object($license)?base_url('images/certs/'.$license->image):''?>" style="max-width:49;max-height:58;" alt="<?=is_object($license)?$license->image:$license?>"></div>
					<?php
									$i++;
								endforeach;
							else:
								echo '-';
							endif;
							?>
					<br />
					<div class="clear"></div>
				<p><b>Preferred Supplier Location:</b>
					<?php
							if(count($the_company->region) && is_array($the_company->region)):
								$i = 0;
								foreach($the_company->region as $region):
							?>
					<?=$i>0?', ':''?>
					<span>
					<?=$region?>
					</span>
					<?php
									$i++;
								endforeach;
							else:
								echo '-';
							endif;
							?>
					<br>
					<?=M_misc::displayValue($the_company->year,'','<b>Year Registered:</b> \s<br />')?>
					<?=M_misc::displayValue($the_company->no_employee,'','<b>Total No. Employees:</b> \s<br />')?>
					<?=M_misc::displayValue($the_company->brand,'','<b>List Brands:</b> \s<br />')?>
					<?=M_misc::displayValue(($the_company->ownership_type)?M_options::getOwnerShipDetails($the_company->ownership_type):'','','<b>Ownership Type:</b> \s<br />')?>
					<?=M_misc::displayValue(($the_company->registered_capital)?M_options::getRegisteredCapital($the_company->registered_capital):'','','<b>Registered Capital:</b> \s<br />')?>
					<?=M_misc::displayValue($the_company->owner,'','<b>Legal Owner:</b> \s<br />')?>
					<?=M_misc::displayValue(($the_company->annual_sale)?M_options::getAnnualSaleDetails($the_company->annual_sale):'','','<b>Annual Sales Volume:</b> \s<br />')?>
					<?=M_misc::displayValue(($the_company->export_per)?M_options::getExportPercentages($the_company->export_per):'','','<b>Export Percentage:</b> \s<br />')?>
					<?=M_misc::displayValue($the_company->customer,'','<b>List Main Customers:</b> \s<br />')?>
					<?=M_misc::displayValue(($the_company->factory_size)?M_options::getFactorySizeDetails($the_company->factory_size):'','','<b>Factory Location:</b> \s<br />')?>
					<?=M_misc::displayValue($the_company->factory_location,'','<b>Factory Size:</b> \s<br />')?>
					<?=M_misc::displayValue(($the_company->factory_purchase)?M_options::getAnnualPurchaseVolume($the_company->factory_purchase):'','','<b>Total Annual Purchase Volume:</b> \s<br />')?>
					<?=M_misc::displayValue(($the_company->factory_productionline)?M_options::getProductionLines($the_company->factory_productionline):'','','<b>Production Lines:</b> \s<br />')?>
					<?=M_misc::displayValue(($the_company->factory_qc)?M_options::getQualityControlDetails($the_company->factory_qc):'','','<b>Quality Control:</b> \s<br />')?>
					<?=M_misc::displayValue(($the_company->factory_no_staff)?M_options::getNumberofStaff($the_company->factory_no_staff):'','','<b>No. Staff:</b> \s<br />')?>
					<?=M_misc::displayValue(($the_company->factory_no_qc)?M_options::getNumberofStaff($the_company->factory_no_qc):'','','<b>No. QC Staff:</b> \s<br />')?>
					<?=M_misc::displayValue(($the_company->no_employee)?M_options::getNoEmployee($the_company->no_employee):'','','<b>No Employees:</b> \s<br />')?>
				</p>
				<p>
					<?=M_misc::displayValue($the_company->country,'<b>Location:</b> -<br />','<b>Location:</b> \s<br />')?><br />
					<?=M_misc::displayValue($the_company->address."\t".$the_company->city."\t".$the_company->country,'<b>Company Address:</b> -<br />','<b>Company Address:</b> \s<br />')?><br />
				<div class="add_to_my_favourites" id="add_to_favorites<?php echo M_encrypt::encode($the_company->id); ?>" >
					<?php if(in_array($the_company->id, $my_favourites)): ?>
					My Favorite
					<?php else: ?>
					<a class="img_link" style="cursor:pointer;" id="linkAddCompanyFavourite<?php echo M_encrypt::encode($the_company->id); ?>" data-favourite="<?php echo M_encrypt::encode($the_company->id); ?>" > Add To Favorites </a>
					<?php endif; ?>
				</div>
				<div class="add_to_my_contacts" id="contact_company<?php echo M_encrypt::encode($the_company->id); ?>" >
					<?php if(in_array($the_company->id, $my_contacts)): ?>
					My Contact
					<?php else: ?>
					<a id="linkAddCompanyContact<?php echo M_encrypt::encode($the_company->id); ?>" data-contact="<?php echo M_encrypt::encode($the_company->id); ?>">Add to My Contacts</a>
					<?php endif; ?>
				</div>
				<div class="add_to_my_network" id="add_to_wishlist<?php echo M_encrypt::encode($the_company->id); ?>" >
					<?php if(in_array($the_company->id, $my_networks)): ?>
					My Network
					<?php else: ?>
					<a id="linkAddCompanyNetwork<?php echo M_encrypt::encode($the_company->id); ?>" data-network="<?php echo M_encrypt::encode($the_company->id); ?>">Add to My Network</a>
					<?php endif; ?>
				</div>
				<div class="contact_company">
					<a class="email_contact" href="<?php echo base_url(); ?>contact/send_message/<?=md5($the_company->id)?>?to=company">Contact Company</a>
				</div>
				<h2>Company Introduction:</h2>
				<p>
					<?=M_misc::displayValue($the_company->product_keyword)?>
				</p>
				<h2>Company Representatives:</h2>
				<div class="company_representatives">
					<div class="company_representatives_item">
						<div class="contact_imageblock"> <img src="<?=base_url()?>images/user_images/<?=isset($the_user->image) && !empty($the_user->image)? $the_user->image : 'no-photo.jpg'?>" width="100" height="100" alt="<?=$the_user->firstname.' '.$the_user->lastname?>" /> </div>
						<p><a href="#"><span class="green"><?php echo $the_user->firstname."\t".$the_user->lastname; ?></span><br />
							<?php echo $the_user->position; ?></a></p>
					</div>
					<?php if(isset($the_staff) && !empty($the_staff)): ?>
					<?php foreach($the_staff as $staff): ?>
					<div class="company_representatives_item">
						<div class="contact_imageblock"> <img src="<?=base_url()?>images/user_images/<?=isset($staff->image) && !empty($staff->image)? $staff->image : 'no-photo.jpg'?>" width="100" height="100" alt="<?=$staff->firstname.' '.$staff->lastname?>" /> </div>
						<p><a href="#"><span class="green"><?php echo $staff->firstname."\t".$staff->lastname; ?></span><br />
							<?php echo $staff->position; ?></a></p>
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
							<ul>
							<?php if(isset($the_news) && !empty($the_news)): ?>
								<?php foreach($the_news as $news_item): ?>
								<li>
									<p class="head"><b><?php echo $news_item->title; ?></b></p>
									<p><b><?php echo $news_item->content; ?></b></p>
								</li>
								<?php endforeach; ?>
							<?php else: ?>
								<li>
									<p class="head"><b>No News</b></p>
								</li>
							<?php endif; ?>
							</ul>
						</div>
					</div>
				</div>
				<h2>Company Network:</h2>
				<div class="company_network_block" id="company_network_block">
				<?php
					if(count($the_netwroks) && is_array($the_netwroks)):
						$count_networks = count($the_netwroks);
						for($i=0;$i<$count_networks && $i < $this->M_company->net_num;$i++):
							$network = (object)$the_netwroks[$i];
				?>
					<div class="company_network_block_item <?=($i %2 ==1)?"right_item":""; ?>">
						<div class="imageblock"> <img class="company_logo" src="<?=base_url('images/'.(isset($network->file) && !empty($network->file)? 'company_images/'.$network->file : 'company.png'))?>" style="width:260px;height:100px;" alt="<?=$network->name?>"> </div>
						<p class="green"><a href="<?php echo base_url(); ?>compdetail/<?php echo M_encrypt::encode($network->id); ?>"><?php echo $network->name; ?> </a></p>
						<p><b>Country:</b>
							<?php
							foreach ($country_options as $key=>$val):
								if($network->country == $key):
									echo $val;
									break;
								endif;
							endforeach;
							?>
							<br/>
							<b>Business Type:</b> <?php echo $network->business_type; ?><br />
							<b>Address:</b> <?php echo $network->address.",\t".$network->city."\t"; ?></p>
						<a class="red" href="<?php echo base_url(); ?>compdetail/<?php echo M_encrypt::encode($network->id); ?>">View</a>
					</div>
					<?php endfor;?>
				<?php else: ?>
					<div class="company_network_block_item right_item"> <b>No Network</b> </div>
				<?php endif; ?>
				</div>
				<?php if(count($the_netwroks) && is_array($the_netwroks)): ?>
				<ul class="my_contacts_pagination">
					<li><a class="last-page " href="#<?=ceil($count_networks/$this->M_company->net_num)?>">Last Page</a></li>
					<li class="next <?=$count_networks>0 && ceil($count_networks/$this->M_company->net_num)>1?'':'disable'?>"><a class="next-page" href="#<?=ceil($count_networks/$this->M_company->net_num)>1?2:1?>"></a></li>
					<li class="prev disable"><a class="previous-page" href="#0"></a></li>
					<li>Page <?=$count_networks>0?'<span class="current-page">1</span> / '.ceil($count_networks/$this->M_company->net_num):'<span class="current-page">0</span> / 0'?></li>
				</ul>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<!-- End Product Tabs -->
<div id="contentBox"> </div>
