 /*
  * Used by the activity editor 
  *
  */
 
 
 var marker = null;

 function initMap() {
	
	//set default initial map
	var zoomi = 7;
	var lati = -37.811; 
	var	lngi = 144.937;

	//see if location already saved from db
	var latExisting = $('input#lat').val();
	var lngExisting = $('input#lng').val();
	if(latExisting && lngExisting){		
		zoomi = 12;
		lati = parseFloat(latExisting);
		lngi = parseFloat(lngExisting); 
	}

 	var map = new google.maps.Map(document.getElementById('map'), {
 		zoom: zoomi,
		 scrollwheel: false,
 		center: {
 			lat: lati,
			lng: lngi
 		}
 	});
 	var geocoder = new google.maps.Geocoder();
	
 	document.getElementById('find').addEventListener('click', function() { 		
 		createMarker(geocoder, map);
 	});

	google.maps.event.addListener(map, 'click', function(event) {
   		createMarkerByClick(geocoder, map, event.latLng);
	});

	//create initial marker if already saved
	if(latExisting){
		var initialLatLng = {lat: lati, lng: lngi};
	//	createMarkerByClick(geocoder, map, initialLatLng);
		createInitialExistingMarker(geocoder, map, initialLatLng);
	}

 }


function createMarkerByClick(geocoder,resultsMap,location) {
 	//clear previous marker
	if (marker) {
 		marker.setMap(null);
 	}

	marker = new google.maps.Marker({
        draggable: true,
		position: location, 		
        map: resultsMap
    });

	google.maps.event.addListener(marker, 'dragend', function() {
		getPositionInfo(geocoder, marker);
	});

	getPositionInfo(geocoder, marker); //from initial load
 }


 function createInitialExistingMarker(geocoder,resultsMap,location) {

	marker = new google.maps.Marker({
        draggable: true,
		position: location, 		
        map: resultsMap
    });

	google.maps.event.addListener(marker, 'dragend', function() {
		getPositionInfo(geocoder, marker);
	});

	//getPositionInfo(geocoder, marker); //from initial load
 }



 function createMarker(geocoder, resultsMap) {
 	var address = document.getElementById('address').value;
 	geocoder.geocode({
 		'address': address
 	}, function(results, status) {
 		if (status === 'OK') {
 			resultsMap.setCenter(results[0].geometry.location);
 			if (marker) {
 				marker.setMap(null);
 			}
 			marker = new google.maps.Marker({
 				draggable: true,
 				map: resultsMap,
 				position: results[0].geometry.location
 			});

 			google.maps.event.addListener(marker, 'dragend', function() {
 				getPositionInfo(geocoder, marker);
 			});

 			getPositionInfo(geocoder, marker); //from initial load

 		} else {
 			alert('Geocode was not successful for the following reason: ' + status);
 		}
 	});
 }


 function getPositionInfo(geocoder, marker) {

 	//get lat / lng
 	var latlngRaw = marker.getPosition() + " "; // eg "(-33.8688197, 151.20929550000005) "
 	var latlngStr = latlngRaw.replace(/\s|\(|\)/g, ""); //remove space and brackets
	 //console.log(latlngStr);	 
 	var latlngArr = latlngStr.split(',', 2);
 	var latlng = {
 		lat: parseFloat(latlngArr[0]),
 		lng: parseFloat(latlngArr[1])
 	};
 	//reverse geocode to get actual address as reported by maps
 	geocoder.geocode({
 		'location': latlng
 	}, function(results, status) {
 		if (status === 'OK') {
 			if (results[1]) {
 				//the address  
 				var addressStr = results[1].formatted_address;
				 var addressStrFull = results[0].formatted_address;				 
				 
				//extra location info for search
				var locationStr = '';
				var locationArr = results[1].address_components;
				for (var i = 0; i < locationArr.length; i++) {
					locationStr += locationArr[i].long_name + ', ';					
				}

				//save details to input				
				$('input#lat').val(latlngArr[0]);
				$('input#lng').val(latlngArr[1]);				
			

 			} else {
 				window.alert('No results found, please move the marker to another location.');
 			}
 		} else {
 			window.alert('Geocoder failed due to: ' + status);
 		}
 	});

 }

