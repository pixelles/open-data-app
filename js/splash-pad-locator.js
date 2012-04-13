$(document).ready(function () {
	// Create an object that holds options for the GMap
	var gmapOptions = {
		center : new google.maps.LatLng(45.3631333357264,-75.672066666632)
		, zoom : 11
		, mapTypeId: google.maps.MapTypeId.ROADMAP
	};

	// Create a variable to hold the GMap and add the GMap to the page
	var map = new google.maps.Map(document.getElementById('map'), gmapOptions);

	// Share one info window variable for all the markers
	var infoWindow;

	// Loop through all the places and add a marker to the GMap
	$('.locations li').each(function (i, elem) {
		var location = $(this).find('a').html();

		// Create some HTML content for the info window
		// Style the content in your CSS
		var info = '<div class="info-window">'
			+ '<strong>' + location + '</strong>'
			+ '</div>'
		;

		// Determine this dino's latitude and longitude
		var latitude = $(this).find('meta[itemprop="latitude"]').attr('content');
		var longitude = $(this).find('meta[itemprop="longitude"]').attr('content');
		var pos = new google.maps.LatLng(latitude, longitude);

		// Create a marker object for this dinosaur
		var marker = new google.maps.Marker({
			position : pos
			, map : map
			, title : location
			, icon : 'images/marker.png'
			, animation: google.maps.Animation.DROP
		});

		// A function for showing this dinosaur's info window
		function showInfoWindow (ev) {
			if (ev.preventDefault) {
				ev.preventDefault();
			}

			// Close the previous info window first, if one already exists
			if (infoWindow) {
				infoWindow.close();
			}

			// Create an info window object and assign it the content
			infoWindow = new google.maps.InfoWindow({
				content : info
			});

			infoWindow.open(map, marker);
		}

		// Add a click event listener for the marker
		google.maps.event.addListener(marker, 'click', showInfoWindow);
		// Add a click event listener to the list item
		google.maps.event.addDomListener($(this).children('a').get(0), 'click', showInfoWindow);
	});

	/****************************************************/
	/***** Geolocation **********************************/
	/****************************************************/

	var userMarker;

	// A function to display the user on the Google Map
	//  and display the list of closest locations
	function displayUserLoc (latitude, longitude) {
		var locDistances = []
			, totalLocs = location.length
			, userLoc = new google.maps.LatLng(latitude, longitude);
		;

		// Create a new marker on the Google Map for the user
		//  or just reposition the already existent one
		if (userMarker) {
			userMarker.setPosition(userLoc);
		} else {
			userMarker = new google.maps.Marker({
				position : userLoc
				, map : map
				, title : 'You are here.'
				, icon : 'images/user.png'
				, animation: google.maps.Animation.DROP
			});
		}

		// Center the map on the user's location
		map.setCenter(userLoc);

		// Create a new LatLon object for using with latlng.min.js
		var current = new LatLon(latitude, longitude);

		// Loop through all the locations and calculate their distances
		for (var i = 0; i < totalLocs; i++) {
			locDistances.push({
				id : locations[i].id
				, distance : parseFloat(current.distanceTo(new LatLon(locations[i].latitude, locations[i].longitude)))
			});
		}

		// Sort the distances with the smallest first
		locDistances.sort(function (a, b) {
			return a.distance - b.distance;
		});

		var $locationList = $('.locations');

		// We can use the resorted locations to reorder the list in place
		// You may want to do something different like clone() the list and display it in a new tab
		for (var j = 0; j < totalLocs; j++) {
			// Find the <li> element that matches the current location
			var $li = $locationList.find('[data-id="' + locDistances[j].id + '"]');

			// Add the distance to the start
			// `toFixed()` makes the distance only have 1 decimal place
			$li.find('.distance').html(locDistances[j].distance.toFixed(1) + ' km');

			$locationList.append($li);
		}
	}

	// Check if the browser supports geolocation
	// It would be best to hide the geolocation button if the browser doesn't support it
	if (navigator.geolocation) {
		$('#geo').click(function () {
			// Request access for the current position and wait for the user to grant it
			navigator.geolocation.getCurrentPosition(function (pos) {
				displayUserLoc(pos.coords.latitude, pos.coords.longitude);
			});
		});
	}

	$('#geo-form').on('submit', function (ev) {
		ev.preventDefault();

		// Google Maps Geo-coder will take an address and convert it to lat/lng
		var geocoder = new google.maps.Geocoder();

		geocoder.geocode({
			// Append 'Ottawa, ON' so our users don't have to
			address : $('#adr').val() + ', Ottawa, ON'
			, region : 'CA'
		}, function (results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					displayUserLoc(results[0].geometry.location.latitude(), results[0].geometry.location.longitude());
				}
			}
		);
	});
});


