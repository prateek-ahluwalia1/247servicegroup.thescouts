@if(!empty($roster_activity))
<div class="row mb-7">
	<div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative text-center">
		<a href="{{config('custom.asset_url')}}{{$roster_activity->signin_selfie}}" target="_blank">
			<img src="{{config('custom.asset_url')}}{{$roster_activity->signin_selfie}}" alt="image">
		</a>
	</div>
</div>
<!--begin::Row-->
<div class="row mb-7">
	<!--begin::Label-->
	<label class="col-lg-4 col-sm-4 fw-bold text-muted">Signin Time</label>
	<!--end::Label-->
	<!--begin::Col-->
	<?php 
	$signin_time = explode('GMT', $roster_activity->signin_time);
	$roster_activity->signin_time = trim($signin_time[0]);
	$roster_activity->signin_time = str_replace('T', ' ', $roster_activity->signin_time);
	$signin_time1 = explode('+', $roster_activity->signin_time);
	$roster_activity->signin_time = $signin_time1[0];
	
	?>
	<div class="col-lg-8 col-sm-8">
		<span class="fw-bolder fs-6 text-dark" id="signin-time">{{date('d/m/Y H:i', strtotime($roster_activity->signin_time))}}</span>
	</div>
	<!--end::Col-->
</div>
<!--end::Row-->
<!--begin::Row-->
<div class="row mb-7">
	<!--begin::Label-->
	<label class="col-lg-4 col-sm-4 fw-bold text-muted">Signin Notes</label>
	<!--end::Label-->
	<!--begin::Col-->
	<div class="col-lg-8 col-sm-8">
		<span class="fw-bolder fs-6 text-dark" id="signin-time">{{$roster_activity->signin_notes}}</span>
	</div>
	<!--end::Col-->
</div>
<!--end::Row-->
<!--begin::Row-->
<div class="row mb-7">
	<!--begin::Label-->
	<label class="col-lg-4 col-sm-4 fw-bold text-muted">Signin Location</label>
	<!--end::Label-->
	<!--begin::Col-->
	<div class="col-lg-8 col-sm-8">
		<span class="fw-bolder fs-6 text-dark" id="signin-time">{{$roster_activity->address}}</span>
	</div>
	<!--end::Col-->
</div>
<!--end::Row-->
<div class="row mb-7">
	<div id="map" style = "height: 200px; width: 100%"></div>
</div>
@else

<!--begin::Row-->
<div class="row mb-7">
	<!--begin::Label-->
	<label class="col-lg-12 col-sm-12 fw-bold text-muted">No Signin details</label>
	
</div>
<!--end::Row-->
@endif
<?php 
$signin_location = '';
if (!empty($roster_activity)) {
	$signin_location = $roster_activity->location;
}
?>

<script type="text/javascript">
	var signin_location = '{{$signin_location}}';

	function initMap(cor_x, cor_y) {
        // The location of Uluru
		const uluru = { lat: cor_x, lng: cor_y };
        // The map, centered at Uluru
		const map = new google.maps.Map(document.getElementById("map"), {
			zoom: 16,
			center: uluru,
		});
		var marker1 = new google.maps.Marker({
			position: uluru,
			map,
    // title: "Hello World!",
		});
  //       const map2 = new google.maps.Map(document.getElementById("map2"), {
  //         zoom: 16,
  //         center: uluru,
  //       });
  //       var marker2 =new google.maps.Marker({
  //   position: uluru,
  //   map2,
  //   // title: "Hello World!",
  // });
		marker1.setMap(map);
        // marker2.setMap(map2);
	}
	
	function call_map(){
		if (signin_location != '') {
			signin_location = signin_location.split(',');
			initMap(signin_location[0] * 1, signin_location[1] * 1);
			console.log(signin_location);
		}
	}
</script>