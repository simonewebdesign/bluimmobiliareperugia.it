var GOOGLE_MAPS_API_KEY = 'AIzaSyBYoJyMyuOAnVmeNSv_kFwqnZN1-nWjU_w';
//var CLIENT = "gme-xxx";
//var VERSION = "3.9";

function trim(stringToTrim) {
	return stringToTrim.replace(/^\s+|\s+$/g,"");
}
function ltrim(stringToTrim) {
	return stringToTrim.replace(/^\s+/,"");
}
function rtrim(stringToTrim) {
	return stringToTrim.replace(/\s+$/,"");
}

  function initialize() {

	var PG_LAT = 43.110701
	var PG_LNG = 12.389172
	var input_lat = parseFloat(document.getElementById('lat').value)
	var input_lng = parseFloat(document.getElementById('lng').value)
	console.log('input_lat = ' + input_lat)
	console.log('input_lng = ' + input_lng)	
	var lat = (input_lat > 0) ? input_lat : PG_LAT
	var lng = (input_lng > 0) ? input_lng : PG_LNG
	console.log('lat = ' + lat)
	console.log('lng = ' + lng)
	
	var mapOptions = {
	  center: new google.maps.LatLng(lat, lng),
	  zoom: 16,
	  mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	var map = new google.maps.Map(document.getElementById('map_canvas'),
	  mapOptions);

	var input = document.getElementById('searchTextField');
	var autocomplete = new google.maps.places.Autocomplete(input);

	autocomplete.bindTo('bounds', map);

	var infowindow = new google.maps.InfoWindow();
	var marker = new google.maps.Marker({
	  map: map
	});

	google.maps.event.addListener(autocomplete, 'place_changed', function() {
	  infowindow.close();
	  var place = autocomplete.getPlace();
	  if (place.geometry.viewport) {
		map.fitBounds(place.geometry.viewport);
	  } else {
		map.setCenter(place.geometry.location);
		map.setZoom(17);  // Why 17? Because it looks good.
	  }

	  var image = new google.maps.MarkerImage(
		  place.icon,
		  new google.maps.Size(71, 71),
		  new google.maps.Point(0, 0),
		  new google.maps.Point(17, 34),
		  new google.maps.Size(35, 35));
	  marker.setIcon(image);
	  marker.setPosition(place.geometry.location);
	
	/* begin get coords */
	var lat;
	var lng;
	var coord;
	
	coord=place.geometry.location.toString();
	coord=coord.replace("(", "");
	coord=coord.replace(")", "");
			
	coord=coord.split(",");
	lat=coord[0];
	lng=trim(coord[1]);
	
	document.getElementById('lat').value=lat;
	document.getElementById('lng').value=lng;
	/* end get coords */
	
	  var address = '';
	  if (place.address_components) {
		address = [(place.address_components[0] &&
					place.address_components[0].short_name || ''),
				   (place.address_components[1] &&
					place.address_components[1].short_name || ''),
				   (place.address_components[2] &&
					place.address_components[2].short_name || '')
				  ].join(' ');
	  }

	  infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
	  infowindow.open(map, marker);
	});

	// Sets a listener on a radio button to change the filter type on Places
	// Autocomplete.
	function setupClickListener(id, types) {
	  var radioButton = document.getElementById(id);
	  google.maps.event.addDomListener(radioButton, 'click', function() {
		autocomplete.setTypes(types);
	  });
	}

	setupClickListener('changetype-all', []);
	setupClickListener('changetype-establishment', ['establishment']);
	setupClickListener('changetype-geocode', ['geocode']);
  }
  
// asynchronous loading...
function loadScript() {
  var script = document.createElement("script");
  script.type = "text/javascript";
  script.src = "http://maps.googleapis.com/maps/api/js?key="+GOOGLE_MAPS_API_KEY+"&sensor=false&libraries=places&callback=initialize"; //&client="+CLIENT+"&v="+VERSION;
  document.body.appendChild(script);
}

window.onload = eval(loadScript());