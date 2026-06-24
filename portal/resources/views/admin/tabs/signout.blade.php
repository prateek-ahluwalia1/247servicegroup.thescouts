@if(!empty($roster_activity) && $roster_activity->signout_time != '')
@if($roster_activity->auto_signout == 1)
<?php 
$signout_time = explode('GMT', $roster_activity->signout_time);
$roster_activity->signout_time = $signout_time[0];
?>
<!--begin::Row-->
<div class="row mb-7">
	<!--begin::Label-->
	<label class="col-lg-12 col-sm-12 fw-bold text-muted">Auto Signout at {{date('d/m/Y H:i', strtotime($roster_activity->signout_time))}}</label>
	
</div>
<!--end::Row-->
@else

<div class="row mb-7">
	<div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative text-center">
		<a href="{{config('custom.asset_url')}}{{$roster_activity->signout_selfie}}" target="_blank">
			<img src="{{config('custom.asset_url')}}{{$roster_activity->signout_selfie}}" alt="image">
		</a>
	</div>
</div>
<!--begin::Row-->
<div class="row mb-7">
	<!--begin::Label-->
	<label class="col-lg-4 col-sm-4 fw-bold text-muted">Signout Time</label>
	<!--end::Label-->
	<!--begin::Col-->
	<?php 
	$signout_time = explode('GMT', $roster_activity->signout_time);
	$roster_activity->signout_time = $signout_time[0];
	$roster_activity->signout_time = str_replace('T', ' ', $roster_activity->signout_time);
	$signout_time1 = explode('+', $roster_activity->signout_time);
	$roster_activity->signout_time = $signout_time1[0];

															// $signout_time = explode('GMT', $roster_activity->signout_time);

															// $roster_activity->signout_time = $signout_time[0];
	?>
	<div class="col-lg-8 col-sm-8">
		<span class="fw-bolder fs-6 text-dark" id="signout-time">{{date('d/m/Y H:i', strtotime($roster_activity->signout_time))}}</span>
	</div>
	<!--end::Col-->
</div>
<!--end::Row-->
<!--begin::Row-->
<div class="row mb-7">
	<!--begin::Label-->
	<label class="col-lg-4 col-sm-4 fw-bold text-muted">Signout Notes</label>
	<!--end::Label-->
	<!--begin::Col-->
	<div class="col-lg-8 col-sm-8">
		<span class="fw-bolder fs-6 text-dark" id="signout-time">{{$roster_activity->signout_notes}}</span>
	</div>
	<!--end::Col-->
</div>
<!--end::Row-->
<!--begin::Row-->
<div class="row mb-7">
	<!--begin::Label-->
	<label class="col-lg-4 col-sm-4 fw-bold text-muted">Signout Location</label>
	<!--end::Label-->
	<!--begin::Col-->
	<div class="col-lg-8 col-sm-8">
		<span class="fw-bolder fs-6 text-dark" id="signout-time">{{$roster_activity->address}}</span>
	</div>
	<!--end::Col-->
</div>
<!--end::Row-->
<div class="row mb-7">
	<div id="map2" style = "height: 200px; width: 100%"></div>
</div>
@endif
@else

<!--begin::Row-->
<div class="row mb-7">
	<!--begin::Label-->
	<label class="col-lg-12 col-sm-12 fw-bold text-muted">No Signout details</label>
	
</div>
<!--end::Row-->
@endif
<?php 
$signout_location = '';
if (!empty($roster_activity)) {
	$signout_location = $roster_activity->signout_location != '' ? $roster_activity->signout_location : $roster_activity->location;
}
?>

<script type="text/javascript">
	var signout_location = '{{$signout_location}}';

	function initMap1(cor_x, cor_y) {
		const uluru = { lat: cor_x, lng: cor_y };
		const map2 = new google.maps.Map(document.getElementById("map2"), {
			zoom: 16,
			center: uluru,
		});
		var marker2 =new google.maps.Marker({
			position: uluru,
			map2,
    // title: "Hello World!",
		});
        // marker1.setMap(map);
		marker2.setMap(map2);
	}
	
	function call_map1(){
		if (signout_location != '') {
			signout_location = signout_location.split(',');
			initMap1(signout_location[0] * 1, signout_location[1] * 1);
      	// console.log(signout_location);
		}
	}
</script>