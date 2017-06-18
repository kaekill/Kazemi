<?php
/**
 * Vehicle Single Map Display
 */

$address = get_field('vehicle_position');

if(get_field('set_vehicle_as_featured')) {
	$marker = get_field('featured_vehicle_marker','option');
} else {
    $marker = get_field('marker_custom_image','option');
}

?>

<script type="text/javascript">
	
	function initializeMaps(marker) {
			var marker;
			var myLatlng = new google.maps.LatLng(<?php echo $address['coordinates'];?>);
			var mapOptions = {
				zoom: 14,
				center: myLatlng,
				disableDefaultUI: true,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			}
			var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
			google.maps.event.trigger(map, 'resize');
			map.setZoom( map.getZoom() );
			
			if(marker == "dealer") {
				var marker = new google.maps.Marker({
					icon: "<?php echo $marker;?>",
					position: myLatlng,
					map: map
				});
			}
			
			marker.setMap(map);
			google.maps.event.addListener(marker, "click", function() {
				// Add optionally an action for when the marker is clicked
			});
		}

</script>

<div id="map-canvas" class="post-img" style="height: 400px;"></div>


