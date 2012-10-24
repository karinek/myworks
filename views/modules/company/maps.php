<?php
$latitude = ($company->latitude != '')?$company->latitude:'-33.865124';
$longitude = ($company->longitude != '')?$company->longitude:'151.208675';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<?=link_tag('css/reset.css')?>
<?=link_tag('css/style.css')?>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBXjfrd7Mww1k9_mkmXEdk1WjPsHQkuIls&sensor=false"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/map-info.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/google_map.js"></script>
<script type="text/javascript">
	/**
	* Called on the intiial page load.
	*/
	var map;
	var comapanyMarker;

	function init() {
		var mapCenter = new google.maps.LatLng(0,0);
		var comLoc = new google.maps.LatLng(<?php echo $latitude; ?>, <?php echo $longitude; ?>);
		map = new google.maps.Map(document.getElementById('map'), {
			zoom: 13,
			center: comLoc,
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
	}
	// Register an event listener to fire when the page finishes loading.
	google.maps.event.addDomListener(window, 'load', init);

</script>
<body>
	<div id="map" style="width:460px; height:380px;"></div>
</body>
</html>