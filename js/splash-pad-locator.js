/**
* Description: a file containing functions to run the Google Maps application, rating system as well as geolocation.
*
* @package com.trishajessica.splashpadlocator
* @copyright 2012 Trisha Jessica
* @author Trisha Jessica <hello@trishajessica.ca>
* @link <http://www.pixelles.github.com/open-data-app>
* @license New BSD License <https://github.com/pixelles/open-data-app/blob/master/LICENSE.txt>
* @version <https://github.com/pixelles/open-data-app/blob/master/VERSION.txt>
*/

$(document).ready(function () {
	
	var locations = [];
	
/* Google Maps */
	if (document.getElementById('map')) {

	var gmapOptions = {
		center : new google.maps.LatLng(45.3631333357264,-75.672066666632)
		, zoom : 11
		, mapTypeId: google.maps.MapTypeId.ROADMAP
	};

	var map = new google.maps.Map(document.getElementById('map'), gmapOptions);

	var infoWindow;

	$('.locations li').each(function (i, elem) {
		var location = $(this).find('a').text();

		var street_address =$(this).find('meta[itemprop="address"]').attr('content');
		var rating_count =$(this).find('meta[itemprop="ratingCount"]').attr('content');
		var rating_total =$(this).find('meta[itemprop="ratingValue"]').attr('content');

		var info = '<div class="info-window">'
			+ '<p><strong>' + location + '</strong></p>'
			+ '<p class="info-street-address">' + street_address + '</p>'
			+ '<p class="info-rating"><strong>Rated</strong> ' + rating_total + ' out of 5 <em>(based on ' + rating_count + ' rating(s))</em></p>'
			+ '<p class="info-rating"><a href="single.php?id=' + $(this).attr('data-id') + '">Rate this location</a></p>'
			+ '</div>'
		;

		var latitude = parseFloat($(this).find('meta[itemprop="latitude"]').attr('content'));
		var longitude = parseFloat($(this).find('meta[itemprop="longitude"]').attr('content'));
		
		var pos = new google.maps.LatLng(latitude, longitude, street_address);

		locations.push({
			id : $(this).attr('data-id')
			, lat : latitude
			, lng : longitude
		});

		var marker = new google.maps.Marker({
			position : pos
			, map : map
			, title : location
			, icon : 'images/marker.png'
		});

		function showInfoWindow (ev) {
			if (ev.preventDefault) {
					ev.preventDefault();
			}

			if (infoWindow) {
					infoWindow.close();
			}

			infoWindow = new google.maps.InfoWindow({
				content : info
			});

			infoWindow.open(map, marker);
		}

		google.maps.event.addListener(marker, 'click', showInfoWindow);
		google.maps.event.addDomListener($(this).get(0), 'click', showInfoWindow);
	});
}

/* Ratings */

	var $raterLi = $('.rater-usable li');
	
	$raterLi
		.on('mouseenter', function (ev) {
		var current = $(this).index();
	
		for (var i = 0; i < current; i++) {
			$raterLi.eq(i).addClass('is-rated-hover');
		}
	})
	
	.on('mouseleave', function (ev) {
		$raterLi.removeClass('is-rated-hover');
	})
;

	var userMarker;

	function displayUserLoc (latitude, longitude) {
		var locDistances = []
			, totalLocs = locations.length
			, userLoc = new google.maps.LatLng(latitude, longitude);
		;

		if (userMarker) {
			userMarker.setPosition(userLoc);
		} else {
			userMarker = new google.maps.Marker({
				position : userLoc
				, map : map
				, title : 'You are here.'
				, icon : 'images/user.png'
				, animation: google.maps.Animation.DROP
				, zIndex : 5000
			});
		}

		map.setCenter(userLoc);

		var current = new LatLon(latitude, longitude);

		for (var i = 0; i < totalLocs; i++) {
			locDistances.push({
				id : locations[i].id
				, distance : parseFloat(current.distanceTo(new LatLon(locations[i].lat, locations[i].lng)))
			});
		}

		locDistances.sort(function (a, b) {
			return a.distance - b.distance;
		});

		var $locationList = $('.locations');

		for (var j = 0; j < totalLocs; j++) {
			var $li = $locationList.find('[data-id="' + locDistances[j].id + '"]');

			$li.find('.distance').html(locDistances[j].distance.toFixed(1) + ' km');

			$locationList.append($li);
		}
		
		$('.locations > li').removeClass('visible');
		$('.locations > li').slice(0,4).addClass('visible');
	}

	if (navigator.geolocation) {
		$('#geo-button').click(function () {
			navigator.geolocation.getCurrentPosition(function (pos) {
				displayUserLoc(pos.coords.latitude, pos.coords.longitude);
			});
		});
	}

	$('#geo-form').on('submit', function (ev) {
		ev.preventDefault();

		var geocoder = new google.maps.Geocoder();

		geocoder.geocode({
			address : $('#adr').val() + ', Ottawa, ON'
			, region : 'CA'
		}, function (results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					displayUserLoc(results[0].geometry.location.lat(), results[0].geometry.location.lng());
				}
			}
		);
	});
});




