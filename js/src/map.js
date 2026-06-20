(function ($) {
	/*
	 *  new_map
	 *
	 *  This function will render a Google Map onto the selected jQuery element
	 *
	 *  @type	function
	 *  @date	8/11/2013
	 *  @since	4.3.0
	 *
	 *  @param	$el (jQuery element)
	 *  @return	n/a
	 */

	var map = null,
		circle = null,
		miles = 100,
		searchRadius = miles / 0.00062137, // miles to meters
		infowindow = new google.maps.InfoWindow(), // create one global info window
		geocoder = new google.maps.Geocoder();

	function new_map($el) {
		// var
		var $markers = $el.find(".section-map__marker");

		// vars
		var args = {
			zoom: 16,
			center: new google.maps.LatLng(0, 0),
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			disableDefaultUI: true,
			gestureHandling: "cooperative",
			zoomControl: true,
		};

		// create map
		var map_section = $(".section-map");
		var map = new google.maps.Map(map_section[0], args);

		// add a markers reference
		map.markers = [];

		// add markers
		$markers.each(function () {
			add_marker($(this), map);
		});

		// center map
		center_map(map);

		// initialize input filters
		watchFormSubmit(map);
		watchFormReset(map);

		watchBrowserGeo(map);

		// return
		return map;
	}

	/*
	 *  add_marker
	 *
	 *  This function will add a marker to the selected Google Map
	 *
	 *  @type	function
	 *  @date	8/11/2013
	 *  @since	4.3.0
	 *
	 *  @param	$marker (jQuery element)
	 *  @param	map (Google Map object)
	 *  @return	n/a
	 */

	function add_marker($marker, map) {
		// console.log($marker);
		var latLng = new google.maps.LatLng($marker.attr("data-latitude"), $marker.attr("data-longitude"));
		var markerid = $marker.attr("id");
		var markername = $marker.attr("data-name");

		// create marker
		var marker = new google.maps.Marker({
			map: map,
			position: latLng,
			id: markerid,
			title: markername,
		});

		// add to array
		map.markers.push(marker);

		// if marker contains HTML, add it to an infoWindow
		if ($marker.html()) {
			// show info window when marker is clicked
			google.maps.event.addListener(marker, "click", function () {
				infowindow.setContent($marker.html());
				infowindow.open(map, marker);
			});

			google.maps.event.addListener(infowindow, "closeclick", function () {});
		}
	}

	/*
	 *  center_map
	 *
	 *  This function will center the map, showing all markers attached to this map
	 *
	 *  @type	function
	 *  @date	8/11/2013
	 *  @since	4.3.0
	 *
	 *  @param	map (Google Map object)
	 *  @return	n/a
	 */

	function center_map(map) {
		// vars
		var bounds = new google.maps.LatLngBounds();

		// loop through all markers and create bounds
		$.each(map.markers, function (i, marker) {
			var latLng = new google.maps.LatLng(marker.position.lat(), marker.position.lng());
			bounds.extend(latLng);
		});

		// radius bounds?
		if (circle) {
			map.fitBounds(circle.getBounds());
		}
		// only 1 marker?
		else if (map.markers.length == 1) {
			// set center of map
			map.setCenter(bounds.getCenter());
			map.setZoom(15);
		} else {
			// fit to bounds
			map.setCenter(bounds.getCenter());
			map.setZoom(7); // Change the zoom value as required
			map.fitBounds(bounds); // This is the default setting which I have uncommented to stop the World Map being repeated
		}
	}

	function reset_map(map) {
		jQuery("#search-location-none").attr("hidden", "hidden");
		jQuery("#search-location-table").removeAttr("hidden").removeAttr("data-sort-active");
		jQuery("#search-location-table-reset").attr("hidden", "hidden");

		$.each(map.markers, function (i, marker) {
			var listItemID = marker.id.replace("marker", "listing");
			var listItem = $("#" + listItemID);
			listItem.removeClass("is-hidden");
			listItem.find(".listing-dist").attr("data-sort", "").text("");
			marker.setVisible(true);
		});

		center_map(map);
	}

	function updateMapListing(map, search) {
		var geocoder_args = {};

		var userLat = document.getElementById("search-location-latitude").value;
		var userLong = document.getElementById("search-location-longitude").value;

		if ((!userLat || !userLong) && !search) {
			// reset_map();
			return false;
		}

		if (userLat && userLong) {
			// Check if the user has enabled browser geolocation, use those coordinates right away if it is.
			var userLatLng = new google.maps.LatLng(userLat, userLong);
			geocoder_args["location"] = userLatLng;
		} else if (search) {
			// Check to see if the search input is an exact match for a location's city, use the coordinates we already have for that city if it is.
			// (We're only doing this because the Google Maps reverse geocode search was returning "Egypt" on a search for "Alexandria", despite the presence of the "bounds" property, which hypothetically was supposed to prevent this exact problem. It does in other cases but doesn't for Alexandria.)
			$.each(map.markers, function (i, marker) {
				var listItemID = marker.id.replace("marker", "listing");
				var listItem = $("#" + listItemID);
				if (listItem.data("city").toLowerCase() == search.toLowerCase()) {
					// console.log(listItem);
					// console.log(listItem.data("latitude"));
					// console.log(listItem.data("longitude"));
					geocoder_args["location"] = new google.maps.LatLng(listItem.data("latitude"), listItem.data("longitude"));
				}
			});

			// If "location" hasn't already been set then we will try the reverse geocode search
			if (!geocoder_args.hasOwnProperty("location")) {
				geocoder_args["address"] = search;
			}

			// Tried adding componentRestrictions for the US, but when included this seemed to make it ignore the "bounds" property.
			// geocoder_args["componentRestrictions"] = {
			// 	country: "US",
			// };

			// Tried adding a region to keep us in the US, but this didn't seem to really do anything.
			// geocoder_args["region"] = "US";

			// Pull in the lat/long bounds we set when the map is created and all markers are visible.
			var marker_bounds = map.getDiv().getAttribute("data-search-bounds");
			if (marker_bounds) {
				marker_bounds = JSON.parse(marker_bounds);

				var bounds = new google.maps.LatLngBounds(
					new google.maps.LatLng(marker_bounds.south, marker_bounds.west),
					new google.maps.LatLng(marker_bounds.north, marker_bounds.east)
				);
				geocoder_args["bounds"] = bounds;
			}
		}

		// console.log(geocoder_args);

		geocoder.geocode(geocoder_args, function (results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				//Find and set zipcode in visible input
				if (results[0] && document.getElementById("search-location-input").value == "") {
					for (j = 0; j < results[0].address_components.length; j++) {
						if (results[0].address_components[j].types[0] == "postal_code") {
							document.getElementById("search-location-input").value = results[0].address_components[j].short_name;
						}
					}
				}

				map.setCenter(results[0].geometry.location);
				if (circle) {
					circle.setMap(null);
				}
				var searchCenter = results[0].geometry.location;
				var circle = new google.maps.Circle({
					center: searchCenter,
					radius: searchRadius,
				});

				var markersVisible = 0;
				$.each(map.markers, function (i, marker) {
					var listItemID = marker.id.replace("marker", "listing");
					var listItem = jQuery("#" + listItemID);
					var distanceFromUser = google.maps.geometry.spherical.computeDistanceBetween(
						marker.getPosition(),
						searchCenter
					);
					var distanceFromUserInMiles = (distanceFromUser * 0.00062137).toFixed(1);

					if (distanceFromUser < searchRadius) {
						marker.setVisible(true);
						listItem.removeClass("is-hidden");
						listItem
							.find(".listing-dist")
							.attr("data-sort", distanceFromUser)
							.text(distanceFromUserInMiles + " mi.");

						markersVisible += 1;
					} else {
						marker.setVisible(false);
						listItem.addClass("is-hidden");
					}
				});

				if (circle) {
					map.fitBounds(circle.getBounds());
				}

				if (markersVisible == map.markers.length) {
					reset_map(map);
				} else if (markersVisible == 0) {
					jQuery("#search-location-none").removeAttr("hidden");
					jQuery("#search-location-table").attr("hidden", "hidden");
					jQuery("#search-location-table-reset").attr("hidden", "hidden");
				} else if (markersVisible > 0) {
					jQuery("#search-location-none").attr("hidden", "hidden");
					jQuery("#search-location-table").removeAttr("hidden");
					jQuery("#search-location-table").attr("data-sort-active", "true");
					jQuery("#search-location-table-reset").removeAttr("hidden");
				}
			}
		});
		jQuery("#search-location").removeClass("has-spinner");
	}

	function clearLatLongFields() {
		document.getElementById("search-location-latitude").value = "";
		document.getElementById("search-location-longitude").value = "";
	}
	function clearInputField() {
		document.getElementById("search-location-input").value = "";
	}

	function watchFormSubmit(map) {
		var form = document.getElementById("search-location");
		if (form) {
			form.addEventListener("submit", function (event) {
				event.preventDefault();

				var search = $("#search-location-input").val().toLowerCase();
				if (search.length == 0) {
					reset_map(map);
				} else {
					jQuery("#search-location").addClass("has-spinner");
					updateMapListing(map, search);
				}
			});
		}
		var searchInput = document.getElementById("search-location-input");
		if (searchInput) {
			searchInput.addEventListener("change", clearLatLongFields, false);
			searchInput.addEventListener("keyup", clearLatLongFields, false);
		}
	}
	function watchFormReset(map) {
		jQuery(".search-location-reset").on("click", function (event) {
			event.preventDefault();

			clearInputField();

			reset_map(map);
		});
	}
	function watchBrowserGeo(map) {
		jQuery("#search-location-geocode").on("click", function (event) {
			event.preventDefault();
			event.stopPropagation();

			clearInputField();

			if (navigator.geolocation) {
				jQuery("#search-location").addClass("has-spinner");
				navigator.geolocation.getCurrentPosition(
					function (position) {
						document.getElementById("search-location-latitude").value = position.coords.latitude;
						document.getElementById("search-location-longitude").value = position.coords.longitude;

						updateMapListing(map);
					},
					function () {
						handleGeolocationError(true);
					}
				);
			} else {
				// Browser doesn't support Geolocation
				handleGeolocationError(false);
			}
		});
	}

	function handleGeolocationError(browserHasGeolocation) {
		jQuery("#search-location").removeClass("has-spinner");
		if (browserHasGeolocation) {
			jQuery("#geolocation").html(
				"<p><small><em>We couldn't find your location. Try typing in your zip code.</em></small></p>"
			);
			jQuery(".listing-dist").css("display", "none");
		} else {
			jQuery("#geolocation").html("<p><small><em>Your browser doesn't support geolocation.</em></small></p>");
			jQuery(".listing-dist").css("display", "none");
		}
	}

	jQuery(function ($) {
		if (typeof google !== "undefined") {
			$(".section-map__embed").each(function () {
				var map_section = $(this).parents(".section-map");
				map_section.addClass("map-loading");

				// create map
				map = new_map($(this));

				loadListener = google.maps.event.addListenerOnce(map, "idle", function () {
					map_section.removeClass("map-loading");
					map_section.addClass("map-loaded");

					var map_bounds = map.getBounds();

					// var rectangle = new google.maps.Rectangle({});
					// rectangle.setOptions({
					// 	strokeColor: "#FF0000",
					// 	strokeOpacity: 0.8,
					// 	strokeWeight: 2,
					// 	fillColor: "#FF0000",
					// 	fillOpacity: 0.35,
					// 	map,
					// 	bounds: map_bounds,
					// });

					map_section.attr("data-search-bounds", JSON.stringify(map_bounds.toJSON()));
				});
			});
		} else {
			$(".section-map").addClass("map-not-loaded");
		}
	});
})(jQuery);
