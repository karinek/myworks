	function addAddNewShopButton() {
		var button = document.createElement('DIV');
		button.className = 'button';
		button.innerHTML = 'Add Shop';
		map.controls[google.maps.ControlPosition.TOP_RIGHT].push(button);
		
		google.maps.event.addDomListener(button, 'click', showNewShopForm);
	}

	function reverseGeocodeNewShopMarker() {
		var geocoder = new google.maps.Geocoder();
		var request = {latLng: newShopMarker.getPosition()};
		
		geocoder.geocode(request, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				var address = results[0].formatted_address;
				document.getElementById('new-shop-address').value = address;
			}
		});
	}

	function showNewShopForm() {
		if (!newShopMarker) {
			newShopMarker = new google.maps.Marker();

			google.maps.event.addListener(map, 'click', function(e) {
				newShopMarker.setPosition(e.latLng);
				if (infoWindowIsOpen) {
					reverseGeocodeNewShopMarker();
				}
			});
			
			var formHTML = '<div id="add-new-shop-form">' +
				'<h1>Add a new Coffee Shop</h1>' +
				'<div><label>Name:<label> <input type="text" id="new-shop-name"/></div>' +
				'<div><label>Address:<label> <input type="text" id="new-shop-address"/></div>' +
				'<div><label>Rating:</label>' +
				'<select id="new-shop-rating">' +
				'<option value=""></option>' +
				'<option value="1">1</option>' +
				'<option value="2">2</option>' +
				'<option value="3">3</option>' +
				'<option value="4">4</option>' +
				'<option value="5">5</option>' +
				'</select>' +
				'<div><button id="new-shop-save">Add!</button>';
			
			newShopInfoWindow = new google.maps.InfoWindow({
				content: formHTML
			});
			
			google.maps.event.addListener(newShopInfoWindow, 'closeclick', function() {
				infoWindowIsOpen = false;
			});
			
			google.maps.event.addListener(newShopInfoWindow, 'domready', function() {
				reverseGeocodeNewShopMarker();
			});
			
			
			google.maps.event.addListener(newShopMarker, 'click', function() {
				if (!infoWindowIsOpen) {
				  newShopInfoWindow.open(map, newShopMarker);
				}
			});
		}
		
		newShopMarker.setPosition(map.getCenter());
		newShopMarker.setMap(map);
		
		newShopInfoWindow.open(map, newShopMarker);
		infoWindowIsOpen = true;
	}

	function addGotoUsersLocationButton() {
		var button = document.createElement('DIV');
		button.className = 'button';
		button.innerHTML = 'My Location';
		map.controls[google.maps.ControlPosition.TOP_RIGHT].push(button);
		
		google.maps.event.addDomListener(button, 'click', function() {
			if (userLocation) {
				map.panTo(userLocation);
			} else {
				map.panTo(new google.maps.LatLng(14.597466, 121.0092));
			}
			newShopMarker.setPosition(map.getCenter());
		});
	}

	function setUsersPosition(position) {
		var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
		userLocation = pos;
		userLocationMarker.setPosition(pos);
		if (!userLocationMarker.getMap()) {
			userLocationMarker.setMap(map);
		}
		
		userLocationCircle.setRadius(position.coords.accuracy);
		if (!userLocationCircle.getMap()) {
			userLocationCircle.setMap(map);
		}
	}

	function getUsersLocation() {
/*		if (navigator.geolocation) {
			navigator.geolocation.watchPosition(setUsersPosition);
			navigator.geolocation.getCurrentPosition(function(position) {
				var pos = new google.maps.LatLng(position.coords.latitude,
				position.coords.longitude);
				map.panTo(pos);
				setUsersPosition(position);
			}, function() {
				// Can find the users location
				// Cheat for the talk
				userLocation = new google.maps.LatLng(14.597466, 121.0092);
				userLocationMarker.setPosition(userLocation);
				userLocationMarker.setMap(map);
				
				userLocationCircle.setRadius(150);
				userLocationCircle.setMap(map);
			}, {timeout: 2000});
		} else {
*/			console.log('mooooo');
			userLocationMarker.setPosition(new google.maps.LatLng(14.597466, 121.0092));
			userLocationMarker.setMap(map);
			
			userLocationCircle.setRadius(150);
			userLocationCircle.setMap(map);
//		}
	}