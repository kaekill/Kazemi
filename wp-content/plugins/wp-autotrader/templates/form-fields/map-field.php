<?php $uid = 'front_map'; ?>

<script type="text/javascript">

	function location_init(uid){
		function addMarker(position,address){
			if(marker){marker.setMap(null)}
			marker = new google.maps.Marker({map:map,position:position,title:address,draggable:true});
			map.setCenter(position);
			dragdropMarker()
		}
		function dragdropMarker(){
			google.maps.event.addListener(marker,'dragend',function(mapEvent){
				coordinates = mapEvent.latLng.lat()+','+mapEvent.latLng.lng();locateByCoordinates(coordinates)})
		}
		function locateByAddress(address){
			geocoder.geocode({'address':address},function(results,status){
				if(status == google.maps.GeocoderStatus.OK){
					addMarker(results[0].geometry.location,address);
					coordinates = results[0].geometry.location.lat()+','+results[0].geometry.location.lng();
					coordinatesAddressInput.value = address+'|'+coordinates;ddAddress.innerHTML=address;
					ddCoordinates.innerHTML = coordinates
				}
				else{
					alert("<?php _e("This address could not be found: ",'auto_manager');?>"+status)
				}
			})
		}
		function locateByCoordinates(coordinates){
			latlngTemp = coordinates.split(',',2);
			lat = parseFloat(latlngTemp[0]);
			lng = parseFloat(latlngTemp[1]);
			latlng = new google.maps.LatLng(lat,lng);
			geocoder.geocode({'latLng':latlng},function(results,status){
				if(status == google.maps.GeocoderStatus.OK){
					address = results[0].formatted_address;addMarker(latlng,address);
					coordinatesAddressInput.value = address+'|'+coordinates;ddAddress.innerHTML=address;ddCoordinates.innerHTML=coordinates
				}
				else{
					alert("<?php _e("This place could not be found: ",'auto_manager');?>"+status)
				}
			})
		}
		var map,lat,lng,latlng,marker,coordinates,address,val;
		var geocoder = new google.maps.Geocoder();
		var ddAddress = document.getElementById('location_dd-address_'+uid);
		var dtAddress = document.getElementById('location_dt-address_'+uid);
		var ddCoordinates = document.getElementById('location_dd-coordinates_'+uid);
		var locationInput = document.getElementById('location_input_'+uid);
		var location = locationInput.value;
		var coordinatesAddressInput = document.getElementById('location_coordinates-address_'+uid);
		var coordinatesAddress = coordinatesAddressInput.value;
		if(coordinatesAddress){
			var coordinatesAddressTemp = coordinatesAddress.split('|',2);
			coordinates = coordinatesAddressTemp[1];
			address = coordinatesAddressTemp[0]
		}if(address){
			ddAddress.innerHTML = address
		}
		if(coordinates){
			ddCoordinates.innerHTML = coordinates;
			var latlngTemp = coordinates.split(',',2);
			lat = parseFloat(latlngTemp[0]);
			lng = parseFloat(latlngTemp[1])
		}else{
			lat = '<?php echo get_field("map_center_latitude", "option");?>';
			lng = '<?php echo get_field("map_center_longitude", "option");?>'
		}
		latlng = new google.maps.LatLng(lat,lng);
		var mapOptions = {
			zoom:15,
			center:latlng,
			mapTypeId:google.maps.MapTypeId.ROADMAP,scrollwheel: 1
		};
		map = new google.maps.Map(document.getElementById('location_map_'+uid),mapOptions);
		if(coordinates){
			addMarker(map.getCenter())
		}
		google.maps.event.addListener(map,'click',function(point){
			locateByCoordinates(point.latLng.lat()+','+point.latLng.lng())
		});


		locationInput.addEventListener('keypress',function(event){
			if(event.keyCode == 13){
				location=locationInput.value;
				var regexp = new RegExp('^\-?[0-9]{1,3}\.[0-9]{6,},\-?[0-9]{1,3}\.[0-9]{6,}$');
				if(location){
					if(regexp.test(location)){
						locateByCoordinates(location)
					}
					else{
						locateByAddress(location)}
					}
					event.stopPropagation();
					event.preventDefault();
					return false
				}
			},false);
		dtAddress.addEventListener('click',function(){
			if(coordinates){
				locateByCoordinates(coordinates)
			}
		},false)
	};

	
	jQuery(document).ready(function(){
		location_init("<?php echo $uid;?>");
	});

	function displayMap() {
		document.getElementById('location_map_<?php echo $uid; ?>').style.display="block";
		location_init("<?php echo $uid;?>");
	};
	
</script>

<input type="hidden" value="" id="location_coordinates-address_<?php echo $uid; ?>" name="<?php echo esc_attr( $key ); ?>"/>
<input type="text" id="location_input_<?php echo $uid; ?>" placeholder="<?php _e('Search for a location','auto_manager'); ?>" />
<dl class="location_dl">
	<dt class="location_dt-address" id="location_dt-address_<?php echo $uid; ?>" role="button" title="<?php _e('Find the complete address','auto_manager'); ?>"><?php _e('Address: ','auto_manager'); ?></dt>
	<dd class="location_dd" id="location_dd-address_<?php echo $uid; ?>">&nbsp;</dd>
	<dt class="location_dt-coordinates"><?php _e('Coordinates: ','auto_manager'); ?></dt>
	<dd class="location_dd" id="location_dd-coordinates_<?php echo $uid; ?>">&nbsp;</dd>
</dl>
<div class="location_map-container">
	<div class="location_map" id="location_map_<?php echo $uid; ?>"></div>
</div>