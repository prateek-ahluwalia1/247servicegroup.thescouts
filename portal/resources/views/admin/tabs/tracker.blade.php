<div class="row mb-7 m-3">
															<table class="table table-hover dataTable table-striped w-full table-responsive"><thead> <tr> <th>Time</th><th>Location</th> <th>Distance</th> </tr></thead> 
															<tbody id="">
																<?php 
																$location_pins = array();
																?>
																@foreach($guard_location_at_job as $gl)
																<?php 
																if ($gl->coordinates != '') {
																$location = explode(',', $gl->coordinates);
																$location_pins[] = array(
																	0 => "The Guard was here at ". $gl->event_time,
																	1 => ($location[0] * 1),
																	2 => ($location[1] * 1)
																);
																}
																?>
																<tr><td style="text-transform: capitalize;">{{$gl->event_time}}</td><td>{{$gl->address}}</td><td>{{$gl->distance*1.609344}} KM</td></tr>
																@endforeach

															</tbody> </table>
															<div id="map3" style = "height: 400px; width: 100%"></div>

														</div>

												<?php 
	
	$location_pins = json_encode($location_pins);
	// print_r($location_pins);	
?>

<script type="text/javascript">
var location_pins = JSON.parse('<?php echo $location_pins; ?>');
   function show_multiple_locations(locations)
  {
    var map = new google.maps.Map(document.getElementById('map3'), {
  zoom: 15,
  center: new google.maps.LatLng(locations[0][1], locations[0][2]),
  mapTypeId: google.maps.MapTypeId.ROADMAP
});

var infowindow = new google.maps.InfoWindow();

var marker, i;

for (i = 0; i < locations.length; i++) {
  marker = new google.maps.Marker({
    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
    map: map
  });

  google.maps.event.addListener(marker, 'click', (function(marker, i) {
    return function() {
      infowindow.setContent(locations[i][0]);
      infowindow.open(map, marker);
    }
  })(marker, i));
}
  }
  function locations_maps(){
  if (location_pins.length > 0) {
  	show_multiple_locations(location_pins);
  }
}
</script>