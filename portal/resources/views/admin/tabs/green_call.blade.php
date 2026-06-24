	
                              <div class="col-sm-12">
                                <div class="card-body">
                  <!--begin::Tab Content-->
                  <div class="tab-content">
                   
                    <!--begin::Tab panel-->
                    <div id="kt_activity_week" class="card-body p-0 tab-pane fade show active" role="tabpanel" aria-labelledby="kt_activity_week_tab">
                      <!--begin::Timeline-->
                      <div class="timeline">
                      	<?php 
																$green_call_location_pins = array();
																?>
	@if(!empty($green_calls) && count($green_calls) > 0)
						<div class="timeline-item">
													<!--begin::Timeline line-->
													<div class="timeline-line w-40px"></div>
													<!--end::Timeline line-->
													<!--begin::Timeline icon-->
													<div class="timeline-icon symbol symbol-circle symbol-40px me-4">
														<div class="symbol-label bg-light">
															<!--begin::Svg Icon | path: icons/duotone/Communication/Chat2.svg-->
															<span class="svg-icon svg-icon-2 svg-icon-gray-500">
																<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<polygon fill="#000000" opacity="0.3" points="5 15 3 21.5 9.5 19.5"></polygon>
																	<path d="M13.5,21 C8.25329488,21 4,16.7467051 4,11.5 C4,6.25329488 8.25329488,2 13.5,2 C18.7467051,2 23,6.25329488 23,11.5 C23,16.7467051 18.7467051,21 13.5,21 Z M9,8 C8.44771525,8 8,8.44771525 8,9 C8,9.55228475 8.44771525,10 9,10 L18,10 C18.5522847,10 19,9.55228475 19,9 C19,8.44771525 18.5522847,8 18,8 L9,8 Z M9,12 C8.44771525,12 8,12.4477153 8,13 C8,13.5522847 8.44771525,14 9,14 L14,14 C14.5522847,14 15,13.5522847 15,13 C15,12.4477153 14.5522847,12 14,12 L9,12 Z" fill="#000000"></path>
																</svg>
															</span>
															<!--end::Svg Icon-->
														</div>
													</div>
													<!--end::Timeline icon-->
													<!--begin::Timeline content-->
													<div class="timeline-content mb-10 mt-n1">
														<!--begin::Timeline heading-->
														<div class="pe-3 mb-5">
															<!--begin::Title-->
															<div class="fs-5 fw-bold mb-2">Green Call Status:</div>
															<!--end::Title-->
															<!--begin::Description-->
															<div class="d-flex align-items-center mt-1 fs-6">
																<!--begin::Info-->
																<!-- <div class="text-muted me-2 fs-7">Added at 4:23 PM by</div> -->
																<!--end::Info-->
																<!--begin::User-->
																<!-- <div class="symbol symbol-circle symbol-25px" data-bs-toggle="tooltip" data-bs-boundary="window" data-bs-placement="top" title="" data-bs-original-title="Nina Nilson">
																	<img src="assets/media/avatars/150-11.jpg" alt="img">
																</div> -->
																<!--end::User-->
															</div>
															<!--end::Description-->
														</div>
														<!--end::Timeline heading-->
														<!--begin::Timeline details-->
														<div class="overflow-auto pb-5">
															@foreach($green_calls as $green_call)
															<?php 
																$location = explode(',', $green_call->coordinates);
																$green_call_location_pins[] = array(
																	0 => "Green call before ".$green_call->before_time." mins ",
																	1 => $location[0] * 1,
																	2 => $location[1] * 1
																);
																?>
															<!--begin::Record-->
															<div class="d-flex align-items-center border border-dashed border-gray-300 rounded min-w-350px px-7 py-3 mb-5">
																<!--begin::Title-->
																<a href="#" class="fs-5 text-dark text-hover-primary fw-bold min-w-200px">Green call before {{$green_call->before_time}} mins</a>
																<!--end::Title-->
																<!--begin::Label-->
																<div class="pe-2">
																	<span class="badge badge-light text-muted">{{$green_call->status}}</span>
																</div>
																<!--end::Label-->
																<div class=" pe-2">
																	<span class="badge badge-light-primary">{{date('d/m/Y H:i', strtotime($green_call->created_at))}}</span>
																</div>
															</div>
															<!--end::Record-->
															@endforeach
														</div>
														<!--end::Timeline details-->
													</div>
													<!--end::Timeline content-->
												</div>
												<div id="map4" style = "height: 400px; width: 100%"></div>
						
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php 
	
	$green_call_location_pins = json_encode($green_call_location_pins);
	// print_r($location_pins);	
?>
<script type="text/javascript">
var green_call_location_pins = JSON.parse('<?php echo $green_call_location_pins; ?>');
   function show_multiple_locations1(locations)
  {
    var map = new google.maps.Map(document.getElementById('map4'), {
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
  function green_call_locations_maps(){
  if (green_call_location_pins.length > 0) {
  	show_multiple_locations1(green_call_location_pins);
  }
}
</script>