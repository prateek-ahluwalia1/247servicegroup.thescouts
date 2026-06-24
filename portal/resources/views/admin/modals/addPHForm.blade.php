
<!--begin::Header-->
								<div class="card-header" id="kt_explore_header">
									<h3 class="card-title fw-bolder text-gray-700" id="from-title">PH Details</h3>
									<div class="card-toolbar">
										<button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n5" id="kt_explore_close_form">
											<!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
											<span class="svg-icon svg-icon-2">
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
													<g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
														<rect fill="#000000" x="0" y="7" width="16" height="2" rx="1" />
														<rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1" />
													</g>
												</svg>
											</span>
											<!--end::Svg Icon-->
										</button>
									</div>
								</div>
								<!--end::Header-->
								<!--begin::Body-->

<!-- <form class="form" action="#" id="saveEventForm" > -->

								<div class="card-body section " id="kt_explore_body" >
									
									<!--begin::Content-->
									<div id="kt_explore_scroll" class="scroll-y me-n5 pe-5" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_explore_body" data-kt-scroll-dependencies="#kt_explore_header, #kt_explore_footer" data-kt-scroll-offset="5px">
										<!--begin::Demos-->
                    				@if(session()->get('userType')=='admin')
										<div class="mb-0">
												<div class="tab-content" id="myTabContent">
													<div class="tab-pane fade fade active show" id="shift_details" role="tabpanel">
														<!--begin::Input group-->
                      <input type="hidden" id="state" value="{{$state}}" >
											<div class="fv-row mb-9">
												<!--begin::Label-->
												<label class="fs-6 fw-bold required mb-2">Holiday Name</label>
												<!--end::Label-->
											
												
												<input type="text" class="form-control form-control-solid" placeholder="" name="holiday_name" id="holiday_name" />
												
												
											</div>
											<div class="fv-row mb-9">
												<!--begin::Label-->
												<label class="fs-6 fw-bold required mb-2">Information</label>
												<!--end::Label-->
												<textarea class="form-control form-control-solid" placeholder="" name="holiday_information" id="holiday_information"></textarea>
											</div>
											
											
											<div class="fv-row mb-9">
												<!--begin::Label-->
												<label class="fs-6 fw-bold mb-2">Date</label>
												<!--end::Label-->
												<!--begin::Input-->
												<input type="text" class="form-control form-control-solid date-time" placeholder="" name="event_starts" id="event_starts" value="{{date('d-m-Y', strtotime($start))}}" />
												<!--end::Input-->
											</div>

								
													</div>
												</div>
<!--begin::Demo-->
											@endif
											
										<!--end::Demos-->
									</div>
									<!--end::Content-->
								</div>
								<!--end::Body-->
								<!--begin::Footer-->
            
                <div class="text-center" id="kt_explore_footer" style="margin-top: 10%;">
                  	<button type="submit" class="btn btn-primary" id="updateEventFormBtn">Save</button>
				</div>
				


				

								<!--end::Footer-->
										<!-- </form> -->

<script type="text/javascript">
$('.date-time').flatpickr({enableTime:0,dateFormat:"d-m-Y"});

$('#updateEventFormBtn').on('click', function(){
  submitForm();
})

function submitForm(notify = true)
{
  var date = $('#event_starts').val();
	var state = $('#state').val();
	var holiday_name = $('#holiday_name').val();
	var holiday_information = $('#holiday_information').val();
        //$('.saveBtn').prop( "disabled", true );
        var submitted_data = {
            date: date,
            holiday_name: holiday_name,
            holiday_information: holiday_information,
            state : state

        };
        $.ajax({
            url: base_url + "/admin/addPH",
            type: "post",
            dataType: "json",
            data: submitted_data,
            success: function(result) {
                // return;
               
                
                if (result.success == false) {
                    $('.eventsaveBtn').prop("disabled", false);
                    Swal.fire({
                      text: result.message,
                      icon: "error",
                      buttonsStyling: !1,
                      confirmButtonText: "Ok, got it!",
                      customClass: {
                          confirmButton: "btn btn-light"
                      }
                  })
                    // error_alert(``);

                }
                if (result.success == true) {
                    $('#kt_explore_form').removeClass('drawer-on');

                    Swal.fire({
                      text: result.message,
                      icon: "success",
                      buttonsStyling: !1,
                      confirmButtonText: "Ok, got it!",
                      customClass: {
                          confirmButton: "btn btn-light"
                      }
                  })
                    // message_alert("");
                    renderCalendar();
                }
        }
    });
}
	


</script>