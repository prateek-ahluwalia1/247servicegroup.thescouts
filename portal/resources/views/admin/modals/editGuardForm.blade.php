<?php 
$permissions = array();
$is_super_admin = 0;
if (session()->has('permissions')) {
	$permissions = json_decode(session()->get('permissions'), true);
}
if (session()->has('isAdmin')) {
	$is_super_admin = session()->get('isAdmin');
}
$item = session()->get('config_arr_job_roster');
$display = "";
if(session()->get('userType')=='customer')
{
	$display = 'style=display:none;';
}

// @dd($item);
if (!empty($item)) {
	foreach (session()->get('config_arr_job_roster') as $item1) {
		$item = $item1;
	}
} else {
	$item['select_state'] = 1;
	$item['select_customer'] = 1;
	$item['select_sites'] = 1;
	$item['action'] = 1;
	$item['sign_in_detail'] = 1;
	$item['add_site'] = 1;
	$item['ad_shift'] = 1;
	$item['sign_out_detail'] = 1;
	$item['break_detail'] = 1;
	$item['green_call'] = 1;
	$item['rollover_this_week'] = 1;
	$item['site_type'] = 1;
	$item['site_trained'] = 1;
	$item['breaks'] = 1;
	$item['welfare_calls'] = 1;
	$item['site_hours'] = 1;
	$item['charge_rates_level'] = 1;
	$item['charge_rates'] = 1;
	$item['shift_activity'] = 1;
	$item['shift_task'] = 1;
	$item['job_instrcutions'] = 1;
	$item['sos_phone'] = 1;
	$item['tasks'] = 1;
	$item['tracker'] = 1;
	$item['incident_report'] = 1;
	$item['foot_patrol_report'] = 1;
	$item['welfare_call'] = 1;
	$item['view_guards'] = 1;
	$item['shift_site_name'] = 1;
	$item['shift_available_guard'] = 1;
	$item['shift_paybale'] = 1;
	$item['paid_by'] = 1;
	$item['shift_start_time'] = 1;
	$item['shift_end_time'] = 1;
	$item['shift_guard_name'] = 1;
	$item['travel_time'] = 1;
	$item['create_shift_button'] = 1;
	$item['operation_notes'] = 1;

	$item = json_decode(json_encode($item));
}
    // print_r($permissions);
    // exit();
?>
<style type="text/css">
        .rTable {
            display: table;
            width: 100%;
        }

        .rTableRow {
            display: table-row;
        }

        .rTableBody {
            display: table-row-group;
        }

        .rTableCell,
        .rTableHead {
            display: table-cell;
            padding: 3px 10px;
            border: 1px solid #999999;
        }

        .step.active ..tab-step-number,
        .step.current .tab-step-number {
            color: #3f51b5;
            background-color: #fff;
        }

        .dataTables_wrapper {
            width: 100% !important;
        }

        .dataTables_paginate {
            float: right;
        }
    </style>
<!--begin::Header-->
<div class="card-header" id="kt_explore_header">
	<h3 class="card-title fw-bolder text-gray-700" id="from-title">Shift Details</h3>
	<div class="card-toolbar">
		<button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n5" id="kt_explore_close_form" onclick="$('#kt_explore_form').css('left', '');">
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
	@if($ph)
	<div class="text-center col-12">
		<h5 class="text-danger" title="{{$information}}">Public Holiday: {{$holiday_name}} <span><i class="fas fa-info-circle" title="{{$information}}"></i></span></h5>
		<!-- <span>{{$information}}</span> -->
	</div>
	@endif
</div>
<!--end::Header-->
<!--begin::Body-->

<form class="form" action="#" id="saveShiftForm" >

	<div class="card-body section " id="kt_explore_body" >

		<!--begin::Content-->
		<div id="kt_explore_scroll" class="scroll-y me-n5 pe-5" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_explore_body" data-kt-scroll-dependencies="#kt_explore_header, #kt_explore_footer" data-kt-scroll-offset="5px">
			<!--begin::Demos-->
			@if(session()->get('userType')=='admin' || session()->get('userType')=='customer')
			<div class="mb-0">
				<ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6">
					<li class="nav-item">
						<a class="nav-link active" data-bs-toggle="tab" href="#shift_details">Shift details</a>
					</li>
					@if (isset($item->sign_in_detail) && $item->sign_in_detail == 1)
					<li class="nav-item">
						<a class="nav-link" data-bs-toggle="tab" href="#signin_details" onclick="loadTabData('signin', {{$roster->guard_id}}, {{$roster->roster_id}}, 'signin_details')">Sign In details</a>
					</li>
					@endif
					@if (isset($item->sign_out_detail) && $item->sign_out_detail == 1)
					<li class="nav-item">
						<a class="nav-link" data-bs-toggle="tab" href="#signout_details" onclick="loadTabData('signout', {{$roster->guard_id}}, {{$roster->roster_id}}, 'signout_details')">Sign out details</a>
					</li>
					@endif
					@if (isset($item->break_detail) && $item->break_detail == 1)
					<li class="nav-item">
						<a class="nav-link" data-bs-toggle="tab" href="#break_details" onclick="loadTabData('break_details', {{$roster->guard_id}}, {{$roster->roster_id}}, 'break_details')">Break Details</a>
					</li>
					@endif
					@if (isset($item->gree_call) && $item->gree_call == 1)
					<li class="nav-item">
						<a class="nav-link" data-bs-toggle="tab" href="#green_call" onclick="loadTabData('green_call', {{$roster->guard_id}}, {{$roster->roster_id}}, 'green_call')">Green Call</a>
					</li>
					@endif
					@if (isset($item->welfare_call) && $item->welfare_call == 1)
					<li class="nav-item">
						<a class="nav-link" data-bs-toggle="tab" href="#welfare_call" onclick="loadTabData('welfare_call', {{$roster->guard_id}}, {{$roster->roster_id}}, 'welfare_call')">Welfare Call</a>
					</li>
					@endif
					@if (isset($item->tracker) && $item->tracker == 1)
					<li class="nav-item">
						<a class="nav-link" data-bs-toggle="tab" href="#tracker" onclick="loadTabData('tracker', {{$roster->guard_id}}, {{$roster->roster_id}}, 'tracker')">Tracker</a>
					</li>
					@endif
					@if (isset($item->foot_patrol_report) && $item->foot_patrol_report == 1)
					<li class="nav-item">
						<a class="nav-link" data-bs-toggle="tab" href="#foot_patrol_report" onclick="loadTabData('foot_patrol_report', {{$roster->guard_id}}, {{$roster->roster_id}}, 'foot_patrol_report')">Foot Patol Report</a>
					</li>
					@endif
					@if (isset($item->incident_report) && $item->incident_report == 1)
					<li class="nav-item">
						<a class="nav-link" data-bs-toggle="tab" href="#incident_report" onclick="loadTabData('incident', {{$roster->guard_id}}, {{$roster->roster_id}}, 'incident_report')">Incident Report</a>
					</li>
					@endif
					@if (isset($item->operation_notes) && $item->operation_notes == 1)
					<li class="nav-item">
						<a class="nav-link" data-bs-toggle="tab" href="#operations_notes" >Operations notes</a>
					</li>
					@endif
					@if (isset($item->shift_task) && $item->shift_task == 1)
					<li class="nav-item">
						<a class="nav-link" data-bs-toggle="tab" href="#shift_tasks">Shift tasks</a>
					</li>
					@endif
					@if (isset($item->shift_activity) && $item->shift_activity == 1)
					<li class="nav-item">
						<a class="nav-link " data-bs-toggle="tab" href="#shift_activity" onclick="loadTabData('shift_activity', {{$roster->guard_id}}, {{$roster->roster_id}}, 'shift_activity')">Shift activity</a>
					</li>
					@endif
				</ul>
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade fade active show" id="shift_details" role="tabpanel">
						<!--begin::Input group-->
						<input type="hidden" id="eventeventId" value="{{$roster->event_id}}" >
						<input type="hidden" id="eventstartStatus" value="2" >
						<div class="fv-row mb-9">
							<!--begin::Label-->
							<label class="fs-6 fw-bold required mb-2">Site</label>
							<!--end::Label-->
							<!-- <select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" id="{{$gaurds_disabeld != '' ? 'eventSiteId-' : 'eventSiteId'}}" name="eventSiteId" {{$site_disabeld}}> -->
								<!-- <option value="">Select Site</option> -->
								@foreach($sites as $site)
								@if($site_id == $site->jobId)
								<input type="text" class="form-control form-control-solid" placeholder="" name="" id="" value="{{$site->site_name}} ({{$site->site_description}})" {{$site_disabeld}} />
								<input type="hidden" class="form-control form-control-solid" placeholder="" id="{{$gaurds_disabeld != '' ? 'eventSiteId-' : 'eventSiteId'}}" name="eventSiteId"  value="{{$site->jobId}}" />
								<!-- <option value="{{$site->jobId}}" {{($site_id == $site->jobId) ? 'selected' : ''}}>{{$site->site_name}} ({{$site->site_description}})</option> -->
								@endif
								@endforeach
								<!-- </select> -->
							</div>
							<div class="fv-row mb-9">
								<label class="fs-6 fw-bold required mb-2">{{config('custom.guard')}}</label>
								<div class="row">
									<div class="col-{{($roster->guard_id > 0 ? 8 : 10)}}">
										<!--begin::Label-->
										<!--end::Label-->
										<!-- <select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" id="eventguardId" name="eventguardId" {{$gaurds_disabeld}}> -->
											<select id="eventguardId" name="eventguardId" {{$gaurds_disabeld}}>
												<!-- <option value="0"></option> -->
												<option value=""></option>

												@foreach($guards as $guard)

												<option value="{{$guard->id}}" {{($guard_id == $guard->id) ? 'selected' : ''}}>{{$guard->name}}</option>
												@endforeach
											</select>
										</div>
										@if($roster->guard_id > 0)
										<div class="col-2">
											<a class="btn-default" href="{{url('guard_profile').'/'.$roster->guard_id}}" target="_blank"><img class="btn" src="https://img.icons8.com/windows/24/000000/security-guard.png"/></a>
										</div>
										@endif
										<div class="col-2">
											<a class="btn-default" type="button" onclick="getAavailableGuards()"><img class=" btn btn-primary" src="https://img.icons8.com/windows/24/000000/security-guard.png"/><span style="margin-left: 5px;
											FONT-SIZE: 8px;
											FONT-WEIGHT: BOLD;" >Available {{config('custom.guard')}}s</span></a>
											{{-- <i class="fas fa-users text-success icon-custom"></i> --}}
										</div>
										@if((isset($permissions['mock_guard']) && $permissions['mock_guard'] == true) || $is_super_admin == 1)
										@if($roster->guard_id == 0 || $roster->guard_id == null)
										<div class="col-sm-12 " >
											<div class="fv-row">
												<!--begin::Label-->
												<label class="fs-6 fw-bold mb-2">Unprofiled Name</label>
												<!--end::Label-->
												<!--begin::Input-->
												<input type="text" class="form-control form-control-solid" placeholder="" id="moke_guard" name="moke_guard" value="{{$roster->moke_guard}}" />
												<!--end::Input-->
											</div>
										</div>
										@endif
										@endif

										@if($roster->convert_asap_status!=1 && $roster->job_start > time())
										<div id="convert_asap_div" class="col-sm-12 " >
											<a class="btn-primary btn" onclick="convert_asap({{$roster->roster_id}})" type="button">Convert into ASAP </a>
										</div>
										@endif

										@if($roster->guard_id > 0)
										<div class="col-sm-12 guard-leave-option" >
											<a class="btn-default" onclick="show_leave_option()" type="button">Guard on leave</a>
										</div>
										<div class="col-sm-10 leave_option_div" style="display: none;">
											<select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" id="leave_option" name="leave_option">
												<option value="annual">Annual leave</option>
												<option value="sick">Sick leave</option>
											</select>

										</div>
										<div class="col-sm-2 leave_option_div" style="display: none;">
											<button class="btn btn-success" onclick="checkGuardLeave({{$roster->roster_id}},{{$roster->guard_id}})">Assign</button>
										</div>
										@endif



									</div>

								</div>

								<input type="hidden" name="default_start" id="default_start" value="{{date('Y-m-d', strtotime($roster->temp_start))}}">
								<div class="fv-row mb-9">
									<!--begin::Label-->
									<label class="fs-6 fw-bold mb-2">Start Time</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" class="form-control form-control-solid time-picker" placeholder="" name="event_start_time" id="event_start_time" onchange="setDateTimeFormat('start')" value="{{date('H:i', strtotime($roster->temp_start))}}" />

									<input type="hidden" class="form-control form-control-solid date-time1" placeholder="" name="event_starts" id="event_starts" value="{{date('Y-m-d H:i', strtotime($roster->temp_start))}}" />
									<!--end::Input-->
								</div>

								<div class="fv-row mb-9">
									<!--begin::Label-->
									<label class="fs-6 fw-bold mb-2">End</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" class="form-control form-control-solid time-picker" placeholder="" name="event_end_time" id="event_end_time" onchange="setDateTimeFormat('end')" value="{{date('H:i', strtotime($roster->temp_end))}}" />

									<input type="hidden" class="form-control form-control-solid date-time1" placeholder="" name="calendar_event_description" id="event_ends" value="{{date('Y-m-d H:i', strtotime($roster->temp_end))}}" />
									<!--end::Input-->
								</div>

								  <div class="fv-row mb-9">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold mb-2">P.O/W.O</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid"
                                        placeholder="" name="pw_order" id="pw_order" value="{{$roster->pw_order}}"/>
                                       
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->

								<div class="fv-row mb-9">
									<!--begin::Label-->
									<label class="fs-6 fw-bold mb-2">Job Instruction</label>
									<!--end::Label-->
									@if(isset($roster) && $roster->instructions_file != '')
									<a href="{{config('custom.asset_url').$roster->instructions_file}}" target="_blank" class="btn btn-sm btn-success"><i class="fas fa-file"></i></a>
									<a class="btn btn-sm btn-danger" onclick="deleteFile({{$roster->roster_id}})"><i class="fas fa-trash"></i></a>
									@endif
									<!--begin::Input-->
									<input type="file" class="form-control form-control-solid" placeholder="" name="instructions_file" id="instructions_file" />
									<!--end::Input-->
								</div>
								<!--end::Input group-->
								<div class="fv-row mb-9" {{$display}}>
									<!--begin::Label-->
									<label class="fs-6 fw-bold mb-2">Travel Time</label>
									<!--end::Label-->
									<select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" id="job-travel-time" name="job-travel-time" onchange="tt_payable_chargeable()">
										<option value="" {{($roster->travel_time == '') ? 'selected' : ''}}>Select Travel Time</option>
										<option value="0.5" {{($roster->travel_time == 0.5) ? 'selected' : ''}}>0.5 hour</option>
										<option value="1" {{($roster->travel_time == 1) ? 'selected' : ''}}>1 hour</option>
										<option value="1.5" {{($roster->travel_time == 1.5) ? 'selected' : ''}}>1.5 hour</option>
										<option value="2" {{($roster->travel_time == 2) ? 'selected' : ''}}>2 hour</option>
										<option value="0" {{($roster->travel_time == 0 && $roster->travel_time_amount != '') ? 'selected' : ''}}>Other</option>

									</select>
								</div>
								<div class="fv-row mb-9" id="travel_time_amount_div" style="display: {{($roster->travel_time_amount == '' ? 'none' : '')}};"  {{$display}}>
									<div class="row">
										<div class="col-6">
											<!--begin::Label-->
											<label class="fs-6 fw-bold mb-2">Travel Time Amount payable ($)</label>
											<!--end::Label-->
											<input type="number" class="form-control form-control-solid" placeholder="" name="travel_time_amount" id="travel_time_amount" step="any" value="{{$roster->travel_time_amount}}" />
										</div>
										<div class="col-6">
											<!--begin::Label-->
											<label class="fs-6 fw-bold mb-2">Travel Time Amount chargeable ($)</label>
											<!--end::Label-->
											<input type="number" class="form-control form-control-solid" placeholder="" name="travel_time_amount_chargeable" id="travel_time_amount_chargeable" step="any" value="{{$roster->travel_time_amount_chargeable}}" />
										</div>
									</div>

								</div>
								<div class="fv-row mb-9"  {{$display}}>
									<!--end::Label-->
									<div class="row">
										<div class="col-6 tt_payable_chargeable" style="display: {{($roster->travel_time == 0 ? 'none' : '')}}">
											<label class="fs-6 fw-bold mb-2">T.T Payable</label>
											<div class="row">
												<div class="col-6">
													<div class="form-check form-check-custom form-check-solid me-10">
														<input class="form-check-input h-30px w-30px" name="travel_time_payable" type="radio" value="yes" id="travel_time_payable" {{($roster->travel_time_payable == 'yes' ? 'checked' : '')}}/ >
														<label class="form-check-label" for="travel_time_payable" >
															Yes
														</label>
													</div>
												</div>
												<div class="col-6">
													<div class="form-check form-check-custom form-check-solid me-10">
														<input class="form-check-input h-30px w-30px" name="travel_time_payable" type="radio" value="no" id="travel_time_payable" {{$roster->travel_time_payable == 'no' ? 'checked' : ''}}/>
														<label class="form-check-label" for="travel_time_payable">
															No
														</label>
													</div>
												</div>
											</div>
										</div>
										<!--  -->
										<div class="col-6 tt_payable_chargeable" style="display: {{($roster->travel_time == 0 ? 'none' : '')}}">
											<label class="fs-6 fw-bold mb-2">T.T Chargeable</label>
											<div class="row">
												<div class="col-6">
													<div class="form-check form-check-custom form-check-solid me-10">
														<input class="form-check-input h-30px w-30px" name="travel_time_chargeable" type="radio" value="yes" id="travel_time_chargeable" {{($roster->travel_time_chargeable == 'yes' ? 'checked' : '')}}/ >
														<label class="form-check-label" for="travel_time_chargeable" >
															Yes
														</label>
													</div>
												</div>
												<div class="col-6">
													<div class="form-check form-check-custom form-check-solid me-10">
														<input class="form-check-input h-30px w-30px" name="travel_time_chargeable" type="radio" value="no" id="travel_time_chargeable" {{$roster->travel_time_chargeable == 'no' ? 'checked' : ''}}/>
														<label class="form-check-label" for="travel_time_chargeable">
															No
														</label>
													</div>
												</div>
											</div>
										</div>

									</div>
									<!-- end of row -->
								</div>
								<div class="fv-row mb-9"  {{$display}}>
									<!--begin::Label-->
									<!--end::Label-->
									<div class="row">
										<div class="col-6">
											<label class="fs-6 fw-bold mb-2">Shift Payable</label>
											<div class="row">
												<div class="col-6">
													<div class="form-check form-check-custom form-check-solid me-10">
														<input class="form-check-input h-30px w-30px" name="job-payable" type="radio" value="yes" id="job-payable" {{($roster->payable == 'yes' ? 'checked' : '')}}/ >
														<label class="form-check-label" for="job-payable" >
															Yes
														</label>
													</div>
												</div>
												<div class="col-6">
													<div class="form-check form-check-custom form-check-solid me-10">
														<input class="form-check-input h-30px w-30px" name="job-payable" type="radio" value="no" id="job-payable" {{$roster->payable == 'no' ? 'checked' : ''}}/>
														<label class="form-check-label" for="job-payable">
															No
														</label>
													</div>
												</div>
											</div>
										</div>
										<!-- end col-6 outer -->
										<div class="col-6" id="paid-by-div1" style="display: {{($roster->payable == 'yes' ? 'none' : 'none')}};">
											<div class="fv-row mb-9">
												<!--begin::Label-->
												<label class="fs-6 fw-bold mb-2">Paid by</label>
												<!--end::Label-->
												<select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" id="job-paid-by" name="job-paid-by">
													<option value="">Paid by</option>
													<option value="direct" {{($roster->paid_by == 'direct') ? 'selected' : ''}}>Paid as direct employee</option>
													<option value="contractor" {{($roster->paid_by == 'contractor') ? 'selected' : ''}}>Paid as contractor employee</option>
												</select>
											</div>
										</div>
										<div class="col-6">
											<label class="fs-6 fw-bold mb-2">Shift Chargeable</label>
											<div class="row">
												<div class="col-6">
													<div class="form-check form-check-custom form-check-solid me-10">
														<input class="form-check-input h-30px w-30px" type="radio" value="yes" id="job-chargeable" name="job-chargeable" {{($roster->chargeable == 'yes' ? 'checked' : '')}} />
														<label class="form-check-label" for="job-chargeable">
															Yes
														</label>
													</div>
												</div>
												<div class="col-6">
													<div class="form-check form-check-custom form-check-solid me-10">
														<input class="form-check-input h-30px w-30px" type="radio" value="no" id="job-chargeable" name="job-chargeable" {{($roster->chargeable == 'no' ? 'checked' : '')}} />
														<label class="form-check-label" for="job-chargeable">
															No
														</label>
													</div>
												</div>
											</div>
										</div>
										<!-- end col-6 outer -->
										<div class="col-6">
											<label class="fs-6 fw-bold mb-2">Un-published Shift</label>
											<div class="row">
												<div class="col-6">
													<div class="form-check form-check-custom form-check-solid me-10">
														<input class="form-check-input h-30px w-30px" type="radio" value="1" id="unpublish_shift" name="unpublish_shift" {{($roster->unpublish_shift == 1 ? 'checked' : '')}} />
														<label class="form-check-label" for="unpublish_shift">
															Yes
														</label>
													</div>
												</div>
												<div class="col-6">
													<div class="form-check form-check-custom form-check-solid me-10">
														<input class="form-check-input h-30px w-30px" type="radio" value="0" id="unpublish_shift" name="unpublish_shift" {{($roster->unpublish_shift == 0 ? 'checked' : '')}} />
														<label class="form-check-label" for="unpublish_shift">
															No
														</label>
													</div>
												</div>
											</div>
										</div>
										<!-- end col-6 outer -->


									</div>
									<!-- end of row -->
								</div>
								@if($break_management == 1)
								<div class="fv-row mb-9"  {{$display}}>
									<div class="row">
										<!-- end col-6 outer -->
										<div class="col-6">
											<label class="fs-6 fw-bold mb-2">Break</label>
											<div class="row">
												<div class="col-6">
													<div class="form-check form-check-custom form-check-solid me-10">
														<input class="form-check-input h-30px w-30px" type="radio" value="1" id="break_enabled" name="break_enabled"{{($roster->break_enabled == 1 ? 'checked' : '')}} />
														<label class="form-check-label" for="break_enabled" >
															Yes
														</label>
													</div>
												</div>
												<div class="col-6">
													<div class="form-check form-check-custom form-check-solid me-10">
														<input class="form-check-input h-30px w-30px" type="radio" value="0" id="break_enabled" name="break_enabled"
														{{($roster->break_enabled == 0 ? 'checked' : '')}} />
														<label class="form-check-label" for="break_enabled">
															No
														</label>
													</div>
												</div>
											</div>
										</div>
										<!-- end col-6 outer -->

										<div class="col-6" id="break-deduction-div" style="display: {{($roster->break_enabled == '1' ? '' : 'none')}};">
											<!--begin::Label-->
											<label class="fs-6 fw-bold required mb-2">Break Deduction Time</label>
											<!--end::Label-->
											<select class="form-select form-select-lg form-select-solid"
											data-control="select2" data-placeholder="Select..." data-allow-clear="true"
											data-hide-search="true" id="break_deduction_time" name="break_deduction_time">
											<option value="0" {{($roster->break_deduction_time == 0) ? 'selected' : ''}}>Select Break Deduction Time</option>
											<option value="15" {{($roster->break_deduction_time == 15) ? 'selected' : ''}}>15 Mins</option>
											<option value="30" {{($roster->break_deduction_time == 30) ? 'selected' : ''}}>30 Mins</option>
											<option value="45" {{($roster->break_deduction_time == 45) ? 'selected' : ''}}>45 Mins</option>
											<option value="60" {{($roster->break_deduction_time == 60) ? 'selected' : ''}}>1 Hour</option>
										</select>
									</div>
								</div>
							</div>
							@endif
							<div class="fv-row mb-9"  {{$display}}>
								<!--begin::Label-->
								<!-- <label class="fs-6 fw-bold mb-2"></label> -->
								<!--end::Label-->
								<!--begin::Input-->
								<div class="form-check form-check-custom form-check-solid me-10">
									<input class="form-check-input h-30px w-30px" type="checkbox" value="true" id="job-training" name="job-training" {{($roster->training == 1 ? 'checked' : '')}}/>
									<label class="form-check-label" for="job-custom-rates">
										Training
									</label>
								</div>
								<!--end::Input-->
							</div>
							<div class="fv-row mb-9"  {{$display}}>
								<!--begin::Label-->
								<!-- <label class="fs-6 fw-bold mb-2"></label> -->
								<!--end::Label-->
								<!--begin::Input-->
								<div class="form-check form-check-custom form-check-solid me-10">
									<input class="form-check-input h-30px w-30px" type="checkbox" value="true" id="public_holiday" name="public_holiday" {{(($roster->public_holiday == 1 || $ph == true) ? 'checked' : '')}} />
									<label class="form-check-label" for="job-custom-rates">
										Public Holiday
									</label>
								</div>
								<!--end::Input-->
							</div>
							<div {{$display}}>
								<div class="fv-row mb-9" id="_public_holiday_div{{(($ph == true && config('custom.domain_id') != 58) ? '' : '58')}}" style="display: {{((($roster->public_holiday == 1 || $ph == true) && config('custom.domain_id') != 58) ? 'none' : 'none')}};" >
									<!-- end col-6 outer -->
									<div class="row">
										<div class="col-6">
											<div class="form-check form-check-custom form-check-solid me-10">
												<input class="form-check-input h-30px w-30px" type="radio"
												value="1" id="ph_duration" name="ph_duration" {{(($roster->ph_duration == 1) ? 'checked' : '')}}/>
												<label class="form-check-label" for="ph_duration">
													All Shift
												</label>
											</div>
										</div>
										<div class="col-6">
											<div class="form-check form-check-custom form-check-solid me-10">
												<input class="form-check-input h-30px w-30px" type="radio"
												value="0" id="ph_duration" name="ph_duration" {{(($roster->ph_duration == 0) ? 'checked' : '')}}/>
												<label class="form-check-label" for="ph_duration">
													Start day only
												</label>
											</div>
										</div>
									</div>
									<!-- end col-6 outer -->
								</div>
							</div>
							<div class="fv-row mb-9"  {{$display}}>
								<!--begin::Label-->
								<!-- <label class="fs-6 fw-bold mb-2"></label> -->
								<!--end::Label-->
								<!--begin::Input-->
								<div class="form-check form-check-custom form-check-solid me-10">
									<input class="form-check-input h-30px w-30px" type="checkbox" value="true" id="overtime" name="overtime" {{($roster->overtime == 1 ? 'checked' : '')}} />
									<label class="form-check-label" for="overtime">
										Overtime
									</label>
								</div>
								<!--end::Input-->
							</div>
							<div {{$display}}>
								<div class="fv-row mb-9 overtime-value-div" style="display: {{($roster->overtime_value > 1 ? '' : 'none')}}" >
									<!--begin::Label-->
									<label class="fs-6 fw-bold required mb-2">Overtime Value</label>
									<!--end::Label-->
									<select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" id="overtime_value" name="overtime_value">
										<option value="1" {{($roster->overtime_value == 1) ? 'selected' : ''}}>Select</option>
										<option value="1.5" {{($roster->overtime_value == 1.5) ? 'selected' : ''}}>1.5 x</option>
										<option value="2" {{($roster->overtime_value == 2) ? 'selected' : ''}}>2 x</option>
										<option value="2.5" {{($roster->overtime_value == 2.5) ? 'selected' : ''}}>2.5 x</option>
									</select>
								</div>
							</div>
							@if($covid_marshal == 1)
							<div class="fv-row mb-9"  {{$display}}>
								<!--begin::Label-->
								<!-- <label class="fs-6 fw-bold mb-2"></label> -->
								<!--end::Label-->
								<!--begin::Input-->
								<div class="form-check form-check-custom form-check-solid me-10">
									<input class="form-check-input h-30px w-30px" type="checkbox" value="true" id="covid_marshal" name="covid_marshal" {{(($roster->covid_marshal == 1) ? 'checked' : '')}} />
									<label class="form-check-label">
										Covid Marshal
									</label>
								</div>
								<!--end::Input-->
							</div>
							@endif
							<div class="fv-row mb-9"  {{$display}}>
								<!--begin::Label-->
								<!-- <label class="fs-6 fw-bold mb-2"></label> -->
								<!--end::Label-->
								<!--begin::Input-->
								<div class="form-check form-check-custom form-check-solid me-10">
									<input class="form-check-input h-30px w-30px" type="checkbox" value="true" id="job-continuation" name="job-continuation" {{($roster->continuation == 1 ? 'checked' : '')}} />
									<label class="form-check-label" for="job-continuation">
										Continuation
									</label>
								</div>
								<!--end::Input-->
							</div>
							@if(config('custom.own_payrates') == 0 && session()->get('userType') != 'customer')

							<div class="fv-row mb-9"  {{$display}}>
								<!--begin::Label-->
								<!-- <label class="fs-6 fw-bold mb-2"></label> -->
								<!--end::Label-->
								<!--begin::Input-->
								<div class="form-check form-check-custom form-check-solid me-10">
									<input class="form-check-input h-30px w-30px" type="checkbox" value="true" id="job-custom-rates" name="job-custom-rates" {{($roster->custom_rates == 'yes' ? 'checked' : '')}}/>
									<label class="form-check-label" for="job-custom-rates">
										Custom rates
									</label>
								</div>
								<!--end::Input-->
							</div>
							@if(isset($settings['custom_payrates']) && $settings['custom_payrates'] == 1 && session()->get('userType') != 'customer')  
							<div class="fv-row mb-9 custom-rates-input-1" style="display: {{($roster->custom_rates == 'yes' ? '' : 'none')}}">
								<div class="form-check form-check-custom form-check-solid me-10">
									<input class="form-check-input h-30px w-30px" type="checkbox" value="1" id="custom_payrate" name="custom_payrate"  {{isset($roster) && $roster->manual_custom_payrate == 1 ? 'checked' : '' }}>
									<label class="form-check-label" for="custom_payrate">
										Manual Custom Payrate
									</label>
								</div>
							</div>
							<div class="own_payrates_div" style="display:{{isset($roster) && $roster->manual_custom_payrate == 1 ? '' : 'none' }};">


								<!-- <div class="row rates-section">
									<div class="col-md-6">
										<h4 class="text-center">Default/ABN Rates</h4></div>
									</div> -->
									<div class="row">
										<div class="col-md-12">
											<div class="rTable">
												<div class="rTableBody">
													<div class="rTableRow">
														<div class="rTableHead text-center">Metro</div>
														<div class="rTableHead">&nbsp;</div>
														<div class="rTableHead text-center">Regional</div>
													</div>
													<div class="rTableRow">
														<div class="rTableCell">
															<input class="form-control form-control-md" name="flat_metro_week_day_day" type="number" step="any" value="{{isset($roster) && isset($roster->manual_custom_payrates['flat_metro_week_day_day']) ? $roster->manual_custom_payrates['flat_metro_week_day_day'] : '0' }}">
														</div>
														<div class="rTableCell text-center">Mon-Fri(Day 06:00 - 18:00)</div>
														<div class="rTableCell">
															<input value="{{isset($roster) && isset($roster->manual_custom_payrates['flat_regional_week_day_day']) ? $roster->manual_custom_payrates['flat_regional_week_day_day'] : '0' }}" class="form-control form-control-md" name="flat_regional_week_day_day" type="number" step="any">
														</div>
													</div>
													<div class="rTableRow">
														<div class="rTableCell">
															<input value="{{isset($roster) && isset($roster->manual_custom_payrates['flat_metro_week_day_night']) ? $roster->manual_custom_payrates['flat_metro_week_day_night'] : '0' }}" class="form-control form-control-md" name="flat_metro_week_day_night" type="number" step="any">
														</div>
														<div class="rTableCell text-center">Mon-Fri(Night 18:00 - 06:00)</div>
														<div class="rTableCell">
															<input value="{{isset($roster) && isset($roster->manual_custom_payrates['flat_regional_week_day_night']) ? $roster->manual_custom_payrates['flat_regional_week_day_night'] : '0' }}" class="form-control form-control-md" name="flat_regional_week_day_night" type="number" step="any">
														</div>
													</div>  
													<div class="rTableRow" style="display: none;">
														<div class="rTableCell">
															<input value="{{isset($roster) && isset($roster->manual_custom_payrates['flat_metro_friday']) ? $roster->manual_custom_payrates['flat_metro_friday'] : '0' }}" class="form-control form-control-md" name="flat_metro_friday" type="number" step="any">
														</div>
														<div class="rTableCell text-center">Friday (00:01 till 23:59)</div>
														<div class="rTableCell">
															<input value="{{isset($roster) && isset($roster->manual_custom_payrates['flat_regional_friday']) ? $roster->manual_custom_payrates['flat_regional_friday'] : '0' }}" class="form-control form-control-md" name="flat_regional_friday" type="number" step="any">
														</div>
													</div>
													<div class="rTableRow">
														<div class="rTableCell">
															<input value="{{isset($roster) && isset($roster->manual_custom_payrates['flat_metro_saturday']) ? $roster->manual_custom_payrates['flat_metro_saturday'] : '0' }}" class="form-control form-control-md" name="flat_metro_saturday" type="number" step="any">
														</div>
														<div class="rTableCell text-center">Saturday</div>
														<div class="rTableCell">
															<input value="{{isset($roster) && isset($roster->manual_custom_payrates['flat_regional_saturday']) ? $roster->manual_custom_payrates['flat_regional_saturday'] : '0' }}" class="form-control form-control-md" name="flat_regional_saturday" type="number" step="any">
														</div>
													</div>
													<div class="rTableRow" style="display:none;">
														<div class="rTableCell">
															<input value="{{isset($roster) && isset($roster->manual_custom_payrates['flat_metro_saturday_night']) ? $roster->manual_custom_payrates['flat_metro_saturday_night'] : '0' }}" class="form-control form-control-md" name="flat_metro_saturday_night" type="number" step="any">
														</div>
														<div class="rTableCell text-center">Saturday (Night 18:00 - 06:00)</div>
														<div class="rTableCell">
															<input value="{{isset($roster) && isset($roster->manual_custom_payrates['flat_regional_saturday_night']) ? $roster->manual_custom_payrates['flat_regional_saturday_night'] : '0' }}" class="form-control form-control-md" name="flat_regional_saturday_night" type="number" step="any">
														</div>
													</div>
													<div class="rTableRow">
														<div class="rTableCell">
															<input value="{{isset($roster) && isset($roster->manual_custom_payrates['flat_metro_sunday']) ? $roster->manual_custom_payrates['flat_metro_sunday'] : '0' }}" class="form-control form-control-md" name="flat_metro_sunday" type="number" step="any">
														</div>
														<div class="rTableCell text-center">Sunday </div>
														<div class="rTableCell">
															<input value="{{isset($roster) && isset($roster->manual_custom_payrates['flat_regional_sunday']) ? $roster->manual_custom_payrates['flat_regional_sunday'] : '0' }}" class="form-control form-control-md" name="flat_regional_sunday" type="number" step="any">
														</div>
													</div>
													<div class="rTableRow" style="display:none;">
														<div class="rTableCell">
															<input value="{{isset($roster) && isset($roster->manual_custom_payrates['flat_metro_sunday_night']) ? $roster->manual_custom_payrates['flat_metro_sunday_night'] : '0' }}" class="form-control form-control-md" name="flat_metro_sunday_night" type="number" step="any">
														</div>
														<div class="rTableCell text-center">Sunday (Night 18:00 - 06:00)</div>
														<div class="rTableCell">
															<input value="{{isset($roster) && isset($roster->manual_custom_payrates['flat_regional_sunday_night']) ? $roster->manual_custom_payrates['flat_regional_sunday_night'] : '0' }}" class="form-control form-control-md" name="flat_regional_sunday_night" type="number" step="any">
														</div>
													</div>

													<div class="rTableRow">
														<div class="rTableCell">
															<input value="{{isset($roster) && isset($roster->manual_custom_payrates['flat_metro_public_holiday']) ? $roster->manual_custom_payrates['flat_metro_public_holiday'] : '0' }}" class="form-control form-control-md" name="flat_metro_public_holiday" type="number" step="any">
														</div>
														<div class="rTableCell text-center">Public Holiday </div>
														<div class="rTableCell">
															<input value="{{isset($roster) && isset($roster->manual_custom_payrates['flat_regional_public_holiday']) ? $roster->manual_custom_payrates['flat_regional_public_holiday'] : '0' }}" class="form-control form-control-md" name="flat_regional_public_holiday" type="number" step="any">
														</div>
													</div>
													<div class="rTableRow" style="display:none;">
														<div class="rTableCell">
															<input value="{{isset($roster) && isset($roster->manual_custom_payrates['flat_metro_public_holiday_night']) ? $roster->manual_custom_payrates['flat_metro_public_holiday_night'] : '0' }}" class="form-control form-control-md" name="flat_metro_public_holiday_night" type="number" step="any">
														</div>
														<div class="rTableCell text-center">Public Holiday (Night 18:00 - 06:00)</div>
														<div class="rTableCell">
															<input value="{{isset($roster) && isset($roster->manual_custom_payrates['flat_regional_public_holiday_night']) ? $roster->manual_custom_payrates['flat_regional_public_holiday_night'] : '0' }}" class="form-control form-control-md" name="flat_regional_public_holiday_night" type="number" step="any">
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row rates-section" style="display:none;">
										<div class="col-md-6">
											<h4 class="text-center">EBA Rates</h4></div>
										</div>
										<div class="row rates-section" style="display:none;">
											<div class="col-md-12">
												<div class="rTable">
													<div class="rTableBody">
														<div class="rTableRow">
															<div class="rTableHead text-center">Metro</div>
															<div class="rTableHead">&nbsp;</div>
															<div class="rTableHead text-center">Regional</div>
														</div>
														<div class="rTableRow">
															<div class="rTableCell">
																<input value="{{isset($roster) && isset($roster->manual_custom_payrates['eba_metro_weekday_day']) ? $roster->manual_custom_payrates['eba_metro_weekday_day'] : '0' }}" class="form-control form-control-md" name="eba_metro_weekday_day" type="number" step="any">
															</div>
															<div class="rTableCell text-center">Mon-Fri (Day 06:00-18:00)</div>
															<div class="rTableCell">
																<input value="{{isset($roster) && isset($roster->manual_custom_payrates['eba_regional_weekday_day']) ? $roster->manual_custom_payrates['eba_regional_weekday_day'] : '0' }}" class="form-control form-control-md" name="eba_regional_weekday_day" type="number" step="any">
															</div>
														</div>

														<div class="rTableRow">
															<div class="rTableCell">
																<input value="{{isset($roster) && isset($roster->manual_custom_payrates['eba_metro_weekday_night']) ? $roster->manual_custom_payrates['eba_metro_weekday_night'] : '0' }}" class="form-control form-control-md" name="eba_metro_weekday_night" type="number" step="any">
															</div>
															<div class="rTableCell text-center">Mon-Fri (Night 18:00-06:00)</div>
															<div class="rTableCell">
																<input value="{{isset($roster) && isset($roster->manual_custom_payrates['eba_regional_weekday_night']) ? $roster->manual_custom_payrates['eba_regional_weekday_night'] : '0' }}" class="form-control form-control-md" name="eba_regional_weekday_night" type="number" step="any">
															</div>
														</div>
														<div class="rTableRow">
															<div class="rTableCell">
																<input value="{{isset($roster) && isset($roster->manual_custom_payrates['eba_metro_saturday_day']) ? $roster->manual_custom_payrates['eba_metro_saturday_day'] : '0' }}" class="form-control form-control-md" name="eba_metro_saturday_day" type="number" step="any">
															</div>
															<div class="rTableCell text-center">Saturday (Day 06:00 till 18:00)</div>
															<div class="rTableCell">
																<input value="{{isset($roster) && isset($roster->manual_custom_payrates['eba_regional_saturday_day']) ? $roster->manual_custom_payrates['eba_regional_saturday_day'] : '0' }}" class="form-control form-control-md" name="eba_regional_saturday_day" type="number" step="any">
															</div>
														</div>
														<div class="rTableRow">
															<div class="rTableCell">
																<input value="{{isset($roster) && isset($roster->manual_custom_payrates['eba_metro_saturday_night']) ? $roster->manual_custom_payrates['eba_metro_saturday_night'] : '0' }}" class="form-control form-control-md" name="eba_metro_saturday_night" type="number" step="any">
															</div>
															<div class="rTableCell text-center">Saturday (Night 06:00 till 18:00)</div>
															<div class="rTableCell">
																<input value="{{isset($roster) && isset($roster->manual_custom_payrates['eba_regional_saturday_night']) ? $roster->manual_custom_payrates['eba_regional_saturday_night'] : '0' }}" class="form-control form-control-md" name="eba_regional_saturday_night" type="number" step="any">
															</div>
														</div>
														<div class="rTableRow">
															<div class="rTableCell">
																<input value="{{isset($roster) && isset($roster->manual_custom_payrates['eba_metro_sunday_day']) ? $roster->manual_custom_payrates['eba_metro_sunday_day'] : '0' }}" class="form-control form-control-md" name="eba_metro_sunday_day" type="number" step="any">
															</div>
															<div class="rTableCell text-center">Sunday (Day 06:00 till 18:00)</div>
															<div class="rTableCell">
																<input value="{{isset($roster) && isset($roster->manual_custom_payrates['eba_regional_sunday_day']) ? $roster->manual_custom_payrates['eba_regional_sunday_day'] : '0' }}" class="form-control form-control-md" name="eba_regional_sunday_day" type="number" step="any">
															</div>
														</div>
														<div class="rTableRow">
															<div class="rTableCell">
																<input value="{{isset($roster) && isset($roster->manual_custom_payrates['eba_metro_sunday_night']) ? $roster->manual_custom_payrates['eba_metro_sunday_night'] : '0' }}" class="form-control form-control-md" name="eba_metro_sunday_night" type="number" step="any">
															</div>
															<div class="rTableCell text-center">Sunday (Night 18:00 till 06:00)</div>
															<div class="rTableCell">
																<input value="{{isset($roster) && isset($roster->manual_custom_payrates['eba_regional_sunday_night']) ? $roster->manual_custom_payrates['eba_regional_sunday_night'] : '0' }}" class="form-control form-control-md" name="eba_regional_sunday_night" type="number" step="any">
															</div>
														</div>
														<div class="rTableRow">
															<div class="rTableCell">
																<input value="{{isset($roster) && isset($roster->manual_custom_payrates['eba_metro_public_holiday']) ? $roster->manual_custom_payrates['eba_metro_public_holiday'] : '0' }}" class="form-control form-control-md" name="eba_metro_public_holiday" type="number" step="any">
															</div>
															<div class="rTableCell text-center">Public Holiday (Day 06:00 till 18:00)</div>
															<div class="rTableCell">
																<input value="{{isset($roster) && isset($roster->manual_custom_payrates['eba_regional_public_holiday']) ? $roster->manual_custom_payrates['eba_regional_public_holiday'] : '0' }}" class="form-control form-control-md" name="eba_regional_public_holiday" type="number" step="any">
															</div>
														</div>
														<div class="rTableRow">
															<div class="rTableCell">
																<input value="{{isset($roster) && isset($roster->manual_custom_payrates['eba_metro_public_holiday_night']) ? $roster->manual_custom_payrates['eba_metro_public_holiday_night'] : '0' }}" class="form-control form-control-md" name="eba_metro_public_holiday_night" type="number" step="any">
															</div>
															<div class="rTableCell text-center">Public Holiday (Night 18:00 till 06:E00)</div>
															<div class="rTableCell">
																<input value="{{isset($roster) && isset($roster->manual_custom_payrates['eba_regional_public_holiday_night']) ? $roster->manual_custom_payrates['eba_regional_public_holiday_night'] : '0' }}" class="form-control form-control-md" name="eba_regional_public_holiday_night" type="number" step="any">
															</div>
														</div>
													</div>
												</div>
											</div>

										</div>
										<br>
										<div class="row rates-section" style="display:none;">
											<div class="col-md-6">
												<h4 class="text-center">Awards Rates</h4></div>
											</div>
											<div class="row rates-section" style="display:none;">
												<div class="col-md-12">
													<div class="rTable">
														<div class="rTableBody">
															<div class="rTableRow">
																<div class="rTableHead text-center">Metro</div>
																<div class="rTableHead">&nbsp;</div>
																<div class="rTableHead text-center">Regional</div>
															</div>
															<div class="rTableRow">
																<div class="rTableCell">
																	<input value="{{isset($roster) && isset($roster->manual_custom_payrates['award_metro_weekday_day']) ? $roster->manual_custom_payrates['award_metro_weekday_day'] : '0' }}" class="form-control form-control-md" name="award_metro_weekday_day" type="number" step="any">
																</div>
																<div class="rTableCell text-center">Mon-Fri (Day 06:00-18:00)</div>
																<div class="rTableCell">
																	<input value="{{isset($roster) && isset($roster->manual_custom_payrates['award_regional_weekday_day']) ? $roster->manual_custom_payrates['award_regional_weekday_day'] : '0' }}" class="form-control form-control-md" name="award_regional_weekday_day" type="number" step="any">
																</div>
															</div>

															<div class="rTableRow">
																<div class="rTableCell">
																	<input value="{{isset($roster) && isset($roster->manual_custom_payrates['award_metro_weekday_night']) ? $roster->manual_custom_payrates['award_metro_weekday_night'] : '0' }}" class="form-control form-control-md" name="award_metro_weekday_night" type="number" step="any">
																</div>
																<div class="rTableCell text-center">Mon-Fri (Night 18:00-06:00)</div>
																<div class="rTableCell">
																	<input value="{{isset($roster) && isset($roster->manual_custom_payrates['award_regional_weekday_night']) ? $roster->manual_custom_payrates['award_regional_weekday_night'] : '0' }}" class="form-control form-control-md" name="award_regional_weekday_night" type="number" step="any">
																</div>
															</div>
															<div class="rTableRow">
																<div class="rTableCell">
																	<input value="{{isset($roster) && isset($roster->manual_custom_payrates['award_metro_saturday_day']) ? $roster->manual_custom_payrates['award_metro_saturday_day'] : '0' }}" class="form-control form-control-md" name="award_metro_saturday_day" type="number" step="any">
																</div>
																<div class="rTableCell text-center">Saturday (Day 06:00 till 18:00)</div>
																<div class="rTableCell">
																	<input value="{{isset($roster) && isset($roster->manual_custom_payrates['award_regional_saturday_day']) ? $roster->manual_custom_payrates['award_regional_saturday_day'] : '0' }}" class="form-control form-control-md" name="award_regional_saturday_day" type="number" step="any">
																</div>
															</div>
															<div class="rTableRow">
																<div class="rTableCell">
																	<input value="{{isset($roster) && isset($roster->manual_custom_payrates['award_metro_saturday_night']) ? $roster->manual_custom_payrates['award_metro_saturday_night'] : '0' }}" class="form-control form-control-md" name="award_metro_saturday_night" type="number" step="any">
																</div>
																<div class="rTableCell text-center">Saturday (Night 06:00 till 18:00)</div>
																<div class="rTableCell">
																	<input value="{{isset($roster) && isset($roster->manual_custom_payrates['award_regional_saturday_night']) ? $roster->manual_custom_payrates['award_regional_saturday_night'] : '0' }}" class="form-control form-control-md" name="award_regional_saturday_night" type="number" step="any">
																</div>
															</div>
															<div class="rTableRow">
																<div class="rTableCell">
																	<input value="{{isset($roster) && isset($roster->manual_custom_payrates['award_metro_sunday_day']) ? $roster->manual_custom_payrates['award_metro_sunday_day'] : '0' }}" class="form-control form-control-md" name="award_metro_sunday_day" type="number" step="any">
																</div>
																<div class="rTableCell text-center">Sunday (Day 06:00 till 18:00)</div>
																<div class="rTableCell">
																	<input value="{{isset($roster) && isset($roster->manual_custom_payrates['award_regional_sunday_day']) ? $roster->manual_custom_payrates['award_regional_sunday_day'] : '0' }}" class="form-control form-control-md" name="award_regional_sunday_day" type="number" step="any">
																</div>
															</div>
															<div class="rTableRow">
																<div class="rTableCell">
																	<input value="{{isset($roster) && isset($roster->manual_custom_payrates['award_metro_sunday_night']) ? $roster->manual_custom_payrates['award_metro_sunday_night'] : '0' }}" class="form-control form-control-md" name="award_metro_sunday_night" type="number" step="any">
																</div>
																<div class="rTableCell text-center">Sunday (Night 18:00 till 06:00)</div>
																<div class="rTableCell">
																	<input value="{{isset($roster) && isset($roster->manual_custom_payrates['award_regional_sunday_night']) ? $roster->manual_custom_payrates['award_regional_sunday_night'] : '0' }}" class="form-control form-control-md" name="award_regional_sunday_night" type="number" step="any">
																</div>
															</div>
															<div class="rTableRow">
																<div class="rTableCell">
																	<input value="{{isset($roster) && isset($roster->manual_custom_payrates['award_metro_public_holiday']) ? $roster->manual_custom_payrates['award_metro_public_holiday'] : '0' }}" class="form-control form-control-md" name="award_metro_public_holiday" type="number" step="any">
																</div>
																<div class="rTableCell text-center">Public Holiday (Day 06:00 till 18:00)</div>
																<div class="rTableCell">
																	<input value="{{isset($roster) && isset($roster->manual_custom_payrates['award_regional_public_holiday']) ? $roster->manual_custom_payrates['award_regional_public_holiday'] : '0' }}" class="form-control form-control-md" name="award_regional_public_holiday" type="number" step="any">
																</div>
															</div>
															<div class="rTableRow">
																<div class="rTableCell">
																	<input value="{{isset($roster) && isset($roster->manual_custom_payrates['award_metro_public_holiday_night']) ? $roster->manual_custom_payrates['award_metro_public_holiday_night'] : '0' }}" class="form-control form-control-md" name="award_metro_public_holiday_night" type="number" step="any">
																</div>
																<div class="rTableCell text-center">Public Holiday (Night 18:00 till 06:E00)</div>
																<div class="rTableCell">
																	<input value="{{isset($roster) && isset($roster->manual_custom_payrates['award_regional_public_holiday_night']) ? $roster->manual_custom_payrates['award_regional_public_holiday_night'] : '0' }}" class="form-control form-control-md" name="award_regional_public_holiday_night" type="number" step="any">
																</div>
															</div>
														</div>
													</div>
												</div>

											</div>
										</div>
@if(session()->has('isAdmin') && session()->has('isAdmin') == 1 && session()->get('userType') != 'customer')
										<div class="fv-row mb-9 custom-rates-input-1" tyle="display: {{($roster->custom_chargerate == 'yes' ? '' : 'none')}}">
                    <div class="form-check form-check-custom form-check-solid me-10">
                        <input class="form-check-input h-30px w-30px" type="checkbox" value="1" id="custom_chargerate" name="custom_chargerate" {{isset($roster) && $roster->custom_chargerate == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="custom_chargerate">
                            Manual Custom Chargerate
                        </label>
                    </div>
                    </div>

                    <div class="own_chargerate_div" style="display:{{isset($roster) && $roster->custom_chargerate == 1 && session()->has('isAdmin') && session()->has('isAdmin') == 1 ? '' : 'none' }};">
            
                <div class="row">
                    <div class="col-md-12">
                        <div class="rTable">
                            <div class="rTableBody">
                                <div class="rTableRow">
                                    <div class="rTableHead text-center">Metro</div>
                                    <div class="rTableHead">&nbsp;</div>
                                    <div class="rTableHead text-center">Regional</div>
                                </div>
                                <div class="rTableRow">
                                    <div class="rTableCell">
                                        <input class="form-control form-control-md" name="charge_rate_flat_metro_week_day_day" type="number" step="any" value="{{isset($roster) && isset($roster->custom_charge_rate['flat_metro_week_day_day']) ? $roster->custom_charge_rate['flat_metro_week_day_day'] : '0' }}">
                                    </div>
                                    <div class="rTableCell text-center">Mon-Fri(Day 06:00 - 18:00)</div>
                                    <div class="rTableCell">
                                        <input value="{{isset($roster) && isset($roster->custom_charge_rate['flat_regional_week_day_day']) ? $roster->custom_charge_rate['flat_regional_week_day_day'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_regional_week_day_day" type="number" step="any">
                                    </div>
                                </div>
                                <div class="rTableRow">
                                    <div class="rTableCell">
                                        <input value="{{isset($roster) && isset($roster->custom_charge_rate['flat_metro_week_day_night']) ? $roster->custom_charge_rate['flat_metro_week_day_night'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_metro_week_day_night" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Mon-Fri(Night 18:00 - 06:00)</div>
                                    <div class="rTableCell">
                                        <input value="{{isset($roster) && isset($roster->custom_charge_rate['flat_regional_week_day_night']) ? $roster->custom_charge_rate['flat_regional_week_day_night'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_regional_week_day_night" type="number" step="any">
                                    </div>
                                </div>  
                                <div class="rTableRow" style="display: none;">
                                    <div class="rTableCell">
                                        <input value="{{isset($roster) && isset($roster->custom_charge_rate['flat_metro_friday']) ? $roster->custom_charge_rate['flat_metro_friday'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_metro_friday" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Friday (00:01 till 23:59)</div>
                                    <div class="rTableCell">
                                        <input value="{{isset($roster) && isset($roster->custom_charge_rate['flat_regional_friday']) ? $roster->custom_charge_rate['flat_regional_friday'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_regional_friday" type="number" step="any">
                                    </div>
                                </div>
                                <div class="rTableRow">
                                    <div class="rTableCell">
                                        <input value="{{isset($roster) && isset($roster->custom_charge_rate['flat_metro_saturday']) ? $roster->custom_charge_rate['flat_metro_saturday'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_metro_saturday" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Saturday </div>
                                    <div class="rTableCell">
                                        <input value="{{isset($roster) && isset($roster->custom_charge_rate['flat_regional_saturday']) ? $roster->custom_charge_rate['flat_regional_saturday'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_regional_saturday" type="number" step="any">
                                    </div>
                                </div>
                                <div class="rTableRow" style="display:none;">
                                    <div class="rTableCell">
                                        <input value="{{isset($roster) && isset($roster->custom_charge_rate['flat_metro_saturday_night']) ? $roster->custom_charge_rate['flat_metro_saturday_night'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_metro_saturday_night" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Saturday (Night 18:00 - 06:00)</div>
                                    <div class="rTableCell">
                                        <input value="{{isset($roster) && isset($roster->custom_charge_rate['flat_regional_saturday_night']) ? $roster->custom_charge_rate['flat_regional_saturday_night'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_regional_saturday_night" type="number" step="any">
                                    </div>
                                </div>
                                <div class="rTableRow">
                                    <div class="rTableCell">
                                        <input value="{{isset($roster) && isset($roster->custom_charge_rate['flat_metro_sunday']) ? $roster->custom_charge_rate['flat_metro_sunday'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_metro_sunday" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Sunday </div>
                                    <div class="rTableCell">
                                        <input value="{{isset($roster) && isset($roster->custom_charge_rate['flat_regional_sunday']) ? $roster->custom_charge_rate['flat_regional_sunday'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_regional_sunday" type="number" step="any">
                                    </div>
                                </div>
                                <div class="rTableRow" style="display:none">
                                    <div class="rTableCell">
                                        <input value="{{isset($roster) && isset($roster->custom_charge_rate['flat_metro_sunday_night']) ? $roster->custom_charge_rate['flat_metro_sunday_night'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_metro_sunday_night" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Sunday (Night 18:00 - 06:00)</div>
                                    <div class="rTableCell">
                                        <input value="{{isset($roster) && isset($roster->custom_charge_rate['flat_regional_sunday_night']) ? $roster->custom_charge_rate['flat_regional_sunday_night'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_regional_sunday_night" type="number" step="any">
                                    </div>
                                </div>

                                <div class="rTableRow">
                                    <div class="rTableCell">
                                        <input value="{{isset($roster) && isset($roster->custom_charge_rate['flat_metro_public_holiday']) ? $roster->custom_charge_rate['flat_metro_public_holiday'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_metro_public_holiday" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Public Holiday </div>
                                    <div class="rTableCell">
                                        <input value="{{isset($roster) && isset($roster->custom_charge_rate['flat_regional_public_holiday']) ? $roster->custom_charge_rate['flat_regional_public_holiday'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_regional_public_holiday" type="number" step="any">
                                    </div>
                                </div>
                                <div class="rTableRow" style="display:none;">
                                    <div class="rTableCell">
                                        <input value="{{isset($roster) && isset($roster->custom_charge_rate['flat_metro_public_holiday_night']) ? $roster->custom_charge_rate['flat_metro_public_holiday_night'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_metro_public_holiday_night" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Public Holiday (Night 18:00 - 06:00)</div>
                                    <div class="rTableCell">
                                        <input value="{{isset($roster) && isset($roster->custom_charge_rate['flat_regional_public_holiday_night']) ? $roster->custom_charge_rate['flat_regional_public_holiday_night'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_regional_public_holiday_night" type="number" step="any">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </div>
										@endif
										@endif
										<!--end::Input group-->
										<div {{$display}}>
											<div class="fv-row mb-9 custom-rates-input" style="display: {{($roster->custom_rates == 'yes' && ($roster->manual_custom_payrate == 0 && $roster->custom_chargerate == 0) ? '' : 'none')}}" >
												<!--begin::Label-->
												<label class="fs-6 fw-bold required mb-2">Payrates Level</label>
												<!--end::Label-->
												<select class="form-select form-select-lg form-select-solid" data-control="select2"
												data-placeholder="Select..." data-allow-clear="true" data-hide-search="true"
												id="job-payrate-level" name="job-payrate-level"
												onchange="getPayChargeRate('payrate', 'job-payrate-level')">
												<option value="">Select payrate level</option>
												<option value="1" {{($roster->payrate_level == 1) ? 'selected' : ''}}>1</option>
												<option value="2" {{($roster->payrate_level == 2) ? 'selected' : ''}}>2</option>
												<option value="3" {{($roster->payrate_level == 3) ? 'selected' : ''}}>3</option>
												<option value="4" {{($roster->payrate_level == 4) ? 'selected' : ''}}>4</option>
												<option value="5" {{($roster->payrate_level == 5) ? 'selected' : ''}}>5</option>
											</select>
										</div>
									</div>
									<!--end::Input group-->
									<div {{$display}}>
										<div class="fv-row mb-9 custom-rates-input" style="display: {{($roster->custom_rates == 'yes' && ($roster->manual_custom_payrate == 0 && $roster->custom_chargerate == 0) ? '' : 'none')}};" >
											<!--begin::Label-->
											<label class="fs-6 fw-bold required mb-2">Payrates</label>
											<!--end::Label-->
											<select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" id="job-payrate-id" name="job-payrate-id">
												<option value="">Select payrate</option>

												@foreach($payrates as $payrate)

												<option value="{{$payrate->id}}" {{$payrate->id == $roster->payrate_id ? "selected" : ''}}>{{$payrate->title}}</option>
												@endforeach
											</select>
										</div>
										<div class="fv-row mb-9 custom-rates-input" style="display: {{($roster->custom_rates == 'yes' && $roster->manual_custom_payrate == 0 && $roster->custom_chargerate == 0 ? '' : 'none')}}"  >
											<!--begin::Label-->
											<label class="fs-6 fw-bold required mb-2">Chargerates Level</label>
											<!--end::Label-->
											<select class="form-select form-select-lg form-select-solid"
											data-control="select2" data-placeholder="Select..." data-allow-clear="true"
											data-hide-search="true" id="job-chargerate-level" name="job-chargerate-level"
											onchange="getPayChargeRate('chargerate', 'job-chargerate-level')">
											<option value="">Select chargerate level</option>
											<option value="1" {{($roster->chargedrate_level == 1) ? 'selected' : ''}}>1</option>
											<option value="2" {{($roster->chargedrate_level == 2) ? 'selected' : ''}}>2</option>
											<option value="3" {{($roster->chargedrate_level == 3) ? 'selected' : ''}}>3</option>
											<option value="4" {{($roster->chargedrate_level == 4) ? 'selected' : ''}}>4</option>
											<option value="5" {{($roster->chargedrate_level == 5) ? 'selected' : ''}}>5</option>
										</select>
									</div>
									<div class="fv-row mb-9 custom-rates-input" style="display: {{($roster->custom_rates == 'yes' && $roster->manual_custom_payrate == 0 && $roster->custom_chargerate == 0 ? '' : 'none')}};"  >
										<!--begin::Label-->
										<label class="fs-6 fw-bold required mb-2">Chargerates</label>
										<!--end::Label-->
										<select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" id="job-chargerate-id" name="job-chargerate-id">
											<option value="">Select chargerate</option>

											@foreach($charged_rates as $charged_rate)

											<option value="{{$charged_rate->id}}" {{$charged_rate->id == $roster->chargerate_id ? "selected" : ''}}>{{$charged_rate->title}}</option>
											@endforeach
										</select>
									</div>
								</div>
								@else
								<div class="fv-row mb-9 custom-rates-input"  {{$display}}>
									<!--begin::Label-->
									<label class="fs-6 fw-bold required mb-2">Payrate</label>
									<!--end::Label-->
									<select class="form-select form-select-lg form-select-solid"
									data-control="select2" data-placeholder="Select..." data-allow-clear="true"
									data-hide-search="true" id="own_payrate" name="own_payrate">
									<option value="">Select Payrate</option>
									<option value="eba" {{($roster->own_payrate == 'eba') ? 'selected' : ''}}>EBA</option>
									<option value="award" {{($roster->own_payrate == 'award') ? 'selected' : ''}}>Award</option>
									<option value="default" {{($roster->own_payrate == 'abn') ? 'selected' : ''}}>Default/ABN</option>
									<!-- <option value="default" {{($roster->own_payrate == 'default') ? 'selected' : ''}}>Default/ABN</option> -->
									<!-- <option value="custom" {{($roster->own_payrate == 'custom') ? 'selected' : ''}}>Custom</option> -->
								</select>
							</div>
							<div class="fv-row mb-9 custom-rates-selection" style="display:{{$roster->own_payrate != '' ? '' : 'none'}};">
        <!--begin::Label-->
        <label class="fs-6 fw-bold required mb-2">Select Payrate</label>
        <!--end::Label-->
        <select class="form-select form-select-lg form-select-solid"
        data-control="select2" data-placeholder="Select..." data-allow-clear="true"
        data-hide-search="true" id="payrate_id" name="payrate_id">
        <option value="">Select</option>
        @foreach($payrates as $p)
        <option value="{{$p->id}}" {{($roster->payrate_id == $p->id) ? 'selected' : ''}}>{{$p->title}}</option>
       	@endforeach
    </select>
</div>
							<?php 
							$custom_rate = json_decode($roster->custom_payrate, true);
							?>
							<div {{$display}}>
								<div class="fv-row mb-9 custom-rate" style="display: {{($roster->own_payrate != null && $roster->own_payrate == 'custom' ? '' : 'none')}};" >
									<label class="fs-6 fw-bold required mb-2">Mon-Fri(Day 06:00 - 18:00)</label>
									<!--end::Label-->
									<input type="number" class="form-control form-control-solid" placeholder="" name="custom_payrate[flat_metro_week_day_day]" id="flat_metro_week_day_day" step="any" value="{{((!empty($custom_rate) && isset($custom_rate['flat_metro_week_day_day']) && $custom_rate['flat_metro_week_day_day'] >= 0) ? $custom_rate['flat_metro_week_day_day'] : 0)}}" />
								</div>
								<div class="fv-row mb-9 custom-rate" style="display: {{($roster->own_payrate != null && $roster->own_payrate == 'custom') ? '' : 'none'}};">
									<label class="fs-6 fw-bold required mb-2">Mon-Fri(Night 18:00 - 06:00)</label>
									<!--end::Label-->
									<input type="number" class="form-control form-control-solid" placeholder="" name="custom_payrate[flat_metro_week_day_night]" id="flat_metro_week_day_night" step="any" value="{{((!empty($custom_rate) && isset($custom_rate['flat_metro_week_day_night']) && $custom_rate['flat_metro_week_day_night'] >= 0) ? $custom_rate['flat_metro_week_day_night'] : 0)}}"/>
								</div>
								<div class="fv-row mb-9 custom-rate" style="display: {{($roster->own_payrate != null && $roster->own_payrate == 'custom') ? '' : 'none'}};">
									<label class="fs-6 fw-bold required mb-2">Saturday (Day 06:00 - 18:00)</label>
									<!--end::Label-->
									<input type="number" class="form-control form-control-solid" placeholder="" name="custom_payrate[flat_metro_saturday]" id="flat_metro_saturday" step="any" value="{{((!empty($custom_rate) && isset($custom_rate['flat_metro_saturday']) && $custom_rate['flat_metro_saturday'] >= 0) ? $custom_rate['flat_metro_saturday'] : 0)}}" />
								</div>
								<div class="fv-row mb-9 custom-rate" style="display: {{($roster->own_payrate != null && $roster->own_payrate == 'custom') ? '' : 'none'}};">
									<label class="fs-6 fw-bold required mb-2">Saturday (Night 18:00 - 06:00)</label>
									<!--end::Label-->
									<input type="number" class="form-control form-control-solid" placeholder="" name="custom_payrate[flat_metro_saturday_night]" id="flat_metro_saturday_night" step="any" value="{{((!empty($custom_rate) && isset($custom_rate['flat_metro_saturday_night']) && $custom_rate['flat_metro_saturday_night'] >= 0) ? $custom_rate['flat_metro_saturday_night'] : 0)}}" />
								</div>
								<div class="fv-row mb-9 custom-rate" style="display: {{($roster->own_payrate != null && $roster->own_payrate == 'custom') ? '' : 'none'}};">
									<label class="fs-6 fw-bold required mb-2">Sunday (Day 06:00 - 18:00)</label>
									<!--end::Label-->
									<input type="number" class="form-control form-control-solid" placeholder="" name="custom_payrate[flat_metro_sunday]" id="flat_metro_sunday" step="any" value="{{((!empty($custom_rate) && isset($custom_rate['flat_metro_sunday']) && $custom_rate['flat_metro_sunday'] >= 0) ? $custom_rate['flat_metro_sunday'] : 0)}}" />
								</div>
								<div class="fv-row mb-9 custom-rate" style="display: {{($roster->own_payrate != null && $roster->own_payrate == 'custom') ? '' : 'none'}};">
									<label class="fs-6 fw-bold required mb-2">Sunday (Night 18:00 - 06:00)</label>
									<!--end::Label-->
									<input type="number" class="form-control form-control-solid" placeholder="" name="custom_payrate[flat_metro_sunday_night]" id="flat_metro_sunday_night" step="any" value="{{((!empty($custom_rate) && isset($custom_rate['flat_metro_sunday_night']) && $custom_rate['flat_metro_sunday_night'] >= 0) ? $custom_rate['flat_metro_sunday_night'] : 0)}}" />
								</div>
								<div class="fv-row mb-9 custom-rate" style="display: {{($roster->own_payrate != null && $roster->own_payrate == 'custom') ? '' : 'none'}};">
									<label class="fs-6 fw-bold required mb-2">Public Holiday (Day 06:00 - 18:00)</label>
									<!--end::Label-->
									<input type="number" class="form-control form-control-solid" placeholder="" name="custom_payrate[flat_metro_public_holiday]" id="flat_metro_public_holiday" step="any" value="{{((!empty($custom_rate) && isset($custom_rate['flat_metro_public_holiday']) && $custom_rate['flat_metro_public_holiday'] >= 0) ? $custom_rate['flat_metro_public_holiday'] : 0)}}" />
								</div>
								<div class="fv-row mb-9 custom-rate" style="display: {{($roster->own_payrate != null && $roster->own_payrate == 'custom') ? '' : 'none'}};">
									<label class="fs-6 fw-bold required mb-2">Public Holiday (Night 18:00 - 06:00)</label>
									<!--end::Label-->
									<input type="number" class="form-control form-control-solid" placeholder="" name="custom_payrate[flat_metro_public_holiday_night]" id="flat_metro_public_holiday_night" step="any" value="{{((!empty($custom_rate) && isset($custom_rate['flat_metro_public_holiday_night']) && $custom_rate['flat_metro_public_holiday_night'] >= 0) ? $custom_rate['flat_metro_public_holiday_night'] : 0)}}" />
								</div>
							</div>
							@endif
						</div>
						<div class="tab-pane fade" id="signin_details" role="tabpanel">

						</div>
						<div class="tab-pane fade" id="signout_details" role="tabpanel">

						</div>
						<div class="tab-pane fade" id="break_details" role="tabpanel">

						</div>
						<div class="tab-pane fade" id="green_call" role="tabpanel">

						</div>
						<div class="tab-pane fade" id="welfare_call" role="tabpanel">

						</div>
						<div class="tab-pane fade" id="tracker" role="tabpanel">

						</div>
						<div class="tab-pane fade" id="foot_patrol_report" role="tabpanel">

						</div>
						<div class="tab-pane fade" id="incident_report" role="tabpanel">

						</div>
						<div class="tab-pane fade" id="operations_notes" role="tabpanel">
							<div class="fv-row mb-9">
								<!--begin::Label-->
								<label class="fs-6 fw-bold mb-2">Operations notes</label>
								<!--end::Label-->
								<!--begin::Input-->
								<textarea class="form-control form-control-solid" placeholder="" name="operators_notes_input" id="operators_notes_input" >{{$roster->operators_notes}}</textarea>
								<!--end::Input-->
							</div>
						</div>
						<!-- end of operations notes tab -->
						<div class="tab-pane fade" id="shift_tasks" role="tabpanel">
							<input type="hidden" name="task_counter" id="task_counter" value="{{count($tasks)}}">
							<div class="row" id="tasks-inputs">
								<?php $index = 0; ?>
								@foreach($tasks as $task)
								<div class="col-md-4 form-group task-counter-{{$index}}"><label for="recipient-name" class="col-form-label">Task Time</label><input type="text" class="form-control form-control-md task-time" name="task-start-time-{{$index}}" id="task-start-time-{{$index}}" value="{{$task->task_time}}" {{($task->status != 'pending') ? "disabled" : ''}}><input type="hidden" class="form-control form-control-md" name="task-id-{{$index}}" id="task-id-{{$index}}" value="{{$task->id}}" {{($task->status != 'pending') ? "disabled" : ''}}></div><div class="col-md-8 task-counter-{{$index}} form-group"><label for="recipient-name" class="col-form-label">Description</label><div class="row"><div class="col-md-10 "><textarea class="form-control form-control-md" name="task-description-0" id="task-description-{{$index}}" rows="1" {{($task->status != 'pending') ? "disabled" : ''}}>{{$task->task_name}}</textarea></div><div class="col-md-2">
									@if($task->status == 'pending')
									<a class="btn-danger btn" id="add-task-inputs" onclick="delete_task_inputs({{$index}},{{$task->id}})" style="display: inline-block;height: 30px;padding: 2px 10px;"><i class="fas fa-trash fs-1x" style="padding: 0px;margin: 0px;font-size: 16px;"></i></a>
									@endif
								</div>
							</div>
						</div>
						@if($task->status != 'pending')
						<div class="col-12 mt-3 mb-3">
							<div class="timeline">
								<div class="timeline-item">

									<!--begin::Timeline content-->
									<div class="timeline-content mb-10 mt-n1">

										<!--begin::Timeline details-->
										<div class="overflow-auto pb-5">

											<!--begin::Record-->
											<div class="d-flex align-items-center border border-dashed border-gray-300 rounded min-w-350px px-7 py-3 mb-5">
												<!--begin::Title-->
												<a href="#" class="fs-5 text-dark text-hover-primary fw-bold min-w-50px">Start</a>
												<!--end::Title-->
												<!--begin::Label-->
												<div class="pe-2">
													<span class="badge badge-light text-muted">{{($task->start_time != '' ? date('d/m/Y H:i', strtotime($task->start_time)) : 'N/A')}}</span>
												</div>
												<a href="#" class="fs-5 text-dark text-hover-primary fw-bold min-w-50px">End</a>
												<!--end::Label-->
												<div class=" pe-2">
													<span class="badge badge-light-primary">{{($task->end_time != '' ? date('d/m/Y H:i', strtotime($task->end_time)) : 'N/A')}}</span>
												</div>
											</div>

										</div>
										<!--end::Timeline details-->
									</div>
									<!--end::Timeline content-->
								</div>
							</div>
						</div>
						@endif
						<?php $index++; ?>
						@endforeach
						@foreach($tasks_photos as $ky => $tp)
						<div class="col-12">
						<a href="{{config('custom.asset_url')}}{{$tp}}" target="_blank">
							<img src="{{config('custom.asset_url')}}{{$tp}}" alt="image" width="100">
						</a>
						<hr>
						</div>
						@endforeach
						
					</div>
					<div class="row mt-4">
						<div class="col-sm-12 col-md-12 text-center">
							<button type="button" class="btn btn-success" style="border-radius: 25px;" onclick="addTasks()">+ Add new task</button>
						</div>
					</div>
				</div>
				<div class="tab-pane " id="shift_activity" role="tabpanel">

				</div>
			</div>
			<!--begin::Demo-->
			@endif

			@if(session()->get('userType')=='guard')
			<!--begin::Demos-->
			<div class="mb-0">
				<ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6">
					<li class="nav-item">
						<a class="nav-link active" data-bs-toggle="tab" href="#shift_details">Shift details</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-bs-toggle="tab" href="#shift_tasks">Shift tasks</a>
					</li>

				</ul>
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade fade active show" id="shift_details" role="tabpanel">
						<!--begin::Input group-->
						<input type="hidden" id="eventeventId" value="{{$roster->event_id}}" >
						<input type="hidden" id="eventstartStatus" value="2" >
						<div class="fv-row mb-9">
							<!--begin::Label-->
							<label class="fs-6 fw-bold required mb-2">Select Site</label>
							<!--end::Label-->
							<select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" id="{{$gaurds_disabeld != '' ? 'eventSiteId-' : 'eventSiteId'}}" name="eventSiteId" {{$site_disabeld}} disabled>
								<option value="">Select Site</option>
								@foreach($sites as $site)

								<option value="{{$site->jobId}}" {{($site_id == $site->jobId) ? 'selected' : ''}}>{{$site->site_name}} ({{$site->site_description}})</option>
								@endforeach
							</select>
						</div>
						<div class="fv-row mb-9">
							<!--begin::Label-->
							<label class="fs-6 fw-bold required mb-2">{{config('custom.guard')}}</label>
							<!--end::Label-->
							<select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" id="eventguardId" name="eventguardId" {{$gaurds_disabeld}} disabled>
								<option value="">Select {{config('custom.guard')}}</option>

								@foreach($guards as $guard)

								<option value="{{$guard->id}}" {{($guard_id == $guard->id) ? 'selected' : ''}}>{{$guard->name}}</option>
								@endforeach
							</select>
						</div>
						<!--end::Input group-->
						<!--begin::Input group-->
						<div class="fv-row mb-9">
							<!--begin::Label-->
							<label class="fs-6 fw-bold mb-2">Start</label>
							<!--end::Label-->
							<!--begin::Input-->
							<input type="text" class="form-control form-control-solid date-time" placeholder="" name="event_starts" id="event_starts" value="{{date('Y-m-d, H:i', $roster->job_start)}}}"  disabled/>
							<!--end::Input-->
						</div>

						<div class="fv-row mb-9">
							<!--begin::Label-->
							<label class="fs-6 fw-bold mb-2">End</label>
							<!--end::Label-->
							<!--begin::Input-->
							<input type="text" class="form-control form-control-solid date-time" placeholder="" name="calendar_event_description" id="event_ends" value="{{date('Y-m-d, H:i', $roster->job_end)}}" disabled/>
							<!--end::Input-->
						</div>
						<!--end::Input group-->
					</div>
					<div class="tab-pane fade" id="shift_tasks" role="tabpanel">
						<input type="hidden" name="task_counter" id="task_counter" value="{{count($tasks)}}">
						<div class="row" id="tasks-inputs">
							<?php $index = 0; ?>
							@foreach($tasks as $task)
							<div class="col-md-4 form-group task-counter-{{$index}}"><label for="recipient-name" class="col-form-label">Task Time</label><input type="text" class="form-control form-control-md task-time" name="task-start-time-{{$index}}" id="task-start-time-{{$index}}" value="{{$task->task_time}}"disabled><input type="hidden" class="form-control form-control-md" name="task-id-{{$index}}" id="task-id-{{$index}}" value="{{$task->id}}"disabled></div><div class="col-md-8 task-counter-{{$index}} form-group"><label for="recipient-name" class="col-form-label">Description</label><div class="row"><div class="col-md-10 "><textarea class="form-control form-control-md" name="task-description-0" id="task-description-{{$index}}" rows="1" disabled>{{$task->task_name}}</textarea></div><div class="col-md-2"></div></div></div>
							<?php $index++; ?>
							@endforeach

						</div>
						{{-- <div class="row mt-4">
							<div class="col-sm-12 col-md-12 text-center">
								<button type="button" class="btn btn-success" style="border-radius: 25px;" onclick="addTasks()">+ Add new task</button>
							</div>
						</div> --}}
					</div>
					<div class="tab-pane " id="shift_activity" role="tabpanel">
						<div class="row">
							<div class="col-sm-12 text-center">
								<div class="card-body">
									<!--begin::Tab Content-->
									<div class="tab-content">

										<!--begin::Tab panel-->
										<div id="kt_activity_week" class="card-body p-0 tab-pane fade show active" role="tabpanel" aria-labelledby="kt_activity_week_tab">
											<!--begin::Timeline-->
											<div class="timeline">
												@foreach($activity as $act)

												<div class="timeline-item">
													<!--begin::Timeline line-->
													<div class="timeline-line w-40px"></div>
													<!--end::Timeline line-->
													<!--begin::Timeline icon-->
													<div class="timeline-icon symbol symbol-circle symbol-40px">
														<div class="symbol-label bg-light">
															<!--begin::Svg Icon | path: icons/duotone/Communication/Thumbtack.svg-->
															<span class="svg-icon svg-icon-2 svg-icon-gray-500">
																<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<path d="M11.6734943,8.3307728 L14.9993074,6.09979492 L14.1213255,5.22181303 C13.7308012,4.83128874 13.7308012,4.19812376 14.1213255,3.80759947 L15.535539,2.39338591 C15.9260633,2.00286161 16.5592283,2.00286161 16.9497526,2.39338591 L22.6066068,8.05024016 C22.9971311,8.44076445 22.9971311,9.07392943 22.6066068,9.46445372 L21.1923933,10.8786673 C20.801869,11.2691916 20.168704,11.2691916 19.7781797,10.8786673 L18.9002333,10.0007208 L16.6692373,13.3265608 C16.9264145,14.2523264 16.9984943,15.2320236 16.8664372,16.2092466 L16.4344698,19.4058049 C16.360509,19.9531149 15.8568695,20.3368403 15.3095595,20.2628795 C15.0925691,20.2335564 14.8912006,20.1338238 14.7363706,19.9789938 L5.02099894,10.2636221 C4.63047465,9.87309784 4.63047465,9.23993286 5.02099894,8.84940857 C5.17582897,8.69457854 5.37719743,8.59484594 5.59418783,8.56552292 L8.79074617,8.13355557 C9.76799113,8.00149544 10.7477104,8.0735815 11.6734943,8.3307728 Z" fill="#000000"></path>
																	<polygon fill="#000000" opacity="0.3" transform="translate(7.050253, 17.949747) rotate(-315.000000) translate(-7.050253, -17.949747)" points="5.55025253 13.9497475 5.55025253 19.6640332 7.05025253 21.9497475 8.55025253 19.6640332 8.55025253 13.9497475"></polygon>
																</svg>
															</span>
															<!--end::Svg Icon-->
														</div>
													</div>
													<!--end::Timeline icon-->
													<!--begin::Timeline content-->
													<div class="timeline-content mb-10 mt-n2">
														<!--begin::Timeline heading-->
														<div class="overflow-auto pe-3">
															<!--begin::Title-->
															<div class="fs-5 fw-bold mb-2" style="text-align: left;">{{$act->activity}}</div>
															<!--end::Title-->
															<!--begin::Description-->
															<div class="d-flex align-items-center mt-1 fs-6">
																<!--begin::Info-->
																<div class="text-muted me-2 fs-7">at {{date('Y-m-d H:i', $act->activity_time)}}</div>
																<!--end::Info-->
																<!--begin::User-->
                                <!-- <div class="symbol symbol-circle symbol-25px" data-bs-toggle="tooltip" data-bs-boundary="window" data-bs-placement="top" title="" data-bs-original-title="Alan Nilson">
                                  <img src="assets/media/avatars/150-2.jpg" alt="img">
                              </div> -->
                              <!--end::User-->
                          </div>
                          <!--end::Description-->
                      </div>
                      <!--end::Timeline heading-->
                  </div>
                  <!--end::Timeline content-->
              </div>

              @endforeach              
          </div>
          <!--end::Timeline-->
      </div>
      <!--end::Tab panel-->

  </div>
  <!--end::Tab Content-->
</div>
</div>
</div>            
</div>
</div>
<!--begin::Demo-->


@endif


<!--end::Demo-->
</div>
<!--end::Demos-->
</div>
<!--end::Content-->
</div>
<!--end::Body-->
<!--begin::Footer-->
@if(session()->get('userType') == 'customer')
<div class="text-center" id="kt_explore_footer" style="margin-top: 10%;">
	<button type="submit" class="btn btn-primary" id="updateEventFormBtn1">Update without notify</button>
	<button type="submit" class="btn btn-primary" id="updateEventFormBtn">Update</button>
</div>
@endif
@if(session()->get('userType') == 'admin')
@if (isset($item->create_shift_button) && $item->create_shift_button == 0)
<div class="text-center" id="kt_explore_footer" style="margin-top: 10%;">
	<button type="submit" class="btn btn-primary" id="updateEventFormBtn">Update</button>
	<button type="submit" class="btn btn-success" id="deleteEventFormBtn" onclick="deleteShift({{$roster->roster_id}})">Delete</button>
</div>
@elseif($is_super_admin == 1)
@if($roster->publish_status == 1 || $roster->guard_id <= 0)
<div class="text-center" id="kt_explore_footer" style="margin-top: 10%;">
	<!-- <button type="submit" class="btn btn-primary" id="updateEventFormBtn1">Update without notify</button> -->
	<button type="submit" class="btn btn-primary" id="updateEventFormBtn">Update</button>
	<button type="submit" class="btn btn-success" id="deleteEventFormBtn" onclick="deleteShift({{$roster->roster_id}})">Delete</button>
</div>
@else
<div class="text-center" id="kt_explore_footer" style="margin-top: 10%;">
	<button type="submit" class="btn btn-primary" id="updateEventFormBtn">Save</button>
	<button type="submit" class="btn btn-primary" id="updateEventFormBtn2">Publish</button>
	<button type="submit" class="btn btn-success" id="deleteEventFormBtn" onclick="deleteShift({{$roster->roster_id}})">Delete</button>
</div>
@endif
@elseif(isset($permissions['lock_roster']))
<?php 
if ($permissions['lock_roster'] == true) {
	if ($roster->job_start > (strtotime('monday this week'))){
						// if (time() > (strtotime('tuesday this week') + 60*60*12)) {
		?>
		<div class="text-center" id="kt_explore_footer" style="margin-top: 10%;">
			<!-- <button type="submit" class="btn btn-primary" id="updateEventFormBtn1">Update without notify</button> -->
			<button type="submit" class="btn btn-primary" id="updateEventFormBtn">Update</button>
			<button type="submit" class="btn btn-success" id="deleteEventFormBtn" onclick="deleteShift({{$roster->roster_id}})">Delete</button>
		</div>
	<?php }elseif(time() < (strtotime('tuesday this week') + 60*60*22)){ ?>
		<div class="text-center" id="kt_explore_footer" style="margin-top: 10%;">
			<!-- <button type="submit" class="btn btn-primary" id="updateEventFormBtn1">Update without notify</button> -->
			<button type="submit" class="btn btn-primary" id="updateEventFormBtn">Update</button>
			<button type="submit" class="btn btn-success" id="deleteEventFormBtn" onclick="deleteShift({{$roster->roster_id}})">Delete</button>
		</div>
	<?php }else{
		?>
		<div class="text-center footer-unlock-btns" id="kt_explore_footer" style="margin-top: 10%;">
			<button type="submit" class="btn btn-primary" id="unlockShift">Unlock Shift</button>
		</div>
		<div class="text-center footer-btns" id="kt_explore_footer" style="margin-top: 10%; display: none;">
			<!-- <button type="submit" class="btn btn-primary" id="updateEventFormBtn1">Update without notify</button> -->
			<button type="submit" class="btn btn-primary" id="updateEventFormBtn">Update</button>
			<button type="submit" class="btn btn-success" id="deleteEventFormBtn" onclick="deleteShift({{$roster->roster_id}})">Delete</button>
		</div>
	<?php } }else{
		if($roster->publish_status == 0 && $roster->guard_id > 0){
			?>
		<div class="text-center" id="kt_explore_footer" style="margin-top: 10%;">
			<button type="submit" class="btn btn-primary" id="updateEventFormBtn">Save</button>
			<button type="submit" class="btn btn-primary" id="updateEventFormBtn2">Publish</button>
			<button type="submit" class="btn btn-success" id="deleteEventFormBtn" onclick="deleteShift({{$roster->roster_id}})">Delete</button>
		</div>
	<?php	}else{
	 ?>

		<div class="text-center" id="kt_explore_footer" style="margin-top: 10%;">
			<!-- <button type="submit" class="btn btn-primary" id="updateEventFormBtn1">Update without notify</button> -->
			<button type="submit" class="btn btn-primary" id="updateEventFormBtn">Update</button>
			<button type="submit" class="btn btn-success" id="deleteEventFormBtn" onclick="deleteShift({{$roster->roster_id}})">Delete</button>
		</div>
	<?php } } ?>

	@else

	<?php if($roster->publish_status == 0 && $roster->guard_id > 0){
			?>
		<div class="text-center" id="kt_explore_footer" style="margin-top: 10%;">
			<button type="submit" class="btn btn-primary" id="updateEventFormBtn">Save</button>
			<button type="submit" class="btn btn-primary" id="updateEventFormBtn2">Publish</button>
			<button type="submit" class="btn btn-success" id="deleteEventFormBtn" onclick="deleteShift({{$roster->roster_id}})">Delete</button>
		</div>
	<?php	}else{
	 ?>
	<div class="text-center" id="kt_explore_footer" style="margin-top: 10%;">
		<!-- <button type="submit" class="btn btn-primary" id="updateEventFormBtn1">Update without notify</button> -->
		<button type="submit" class="btn btn-primary" id="updateEventFormBtn">Update</button>
		<button type="submit" class="btn btn-success" id="deleteEventFormBtn" onclick="deleteShift({{$roster->roster_id}})">Delete</button>
	</div>
<?php } ?>
	@endif
	@endif

	<!--end::Footer-->
</form>

<script type="text/javascript">
	$('.date-time').flatpickr({enableTime:!0,dateFormat:"Y-m-d H:i"});
	$('.time-picker' ).flatpickr({
		noCalendar: true,
		enableTime: true,
		dateFormat: 'H:i',
		time_24hr: true,
	});

	$('#eventSiteId').on('change', function(){
		var jobId = $(this).val();
		loadSiteGaurds(jobId);    
	});
	$('#overtime').on('change', function(){
		if($(this).prop('checked') == true){
			$('.overtime-value-div').css('display', '');
		}else{
			$('.overtime-value-div').css('display', 'none');
		}
	});
	function loadSiteGaurds(jobId, guardId = null){
		$.ajax({
			url: base_url+"/guard/getGuards",
			type: "post",
			dataType: "json",
			data: {
				jobId : jobId,
				_token : token
			},
			success: function(result) {
				var options = '<option value="">Select {{config("custom.guard")}}</option>';
				$.each(result, function(mindex, mvalue){
					var selected = '';
					if (guardId != null) {
						if (mvalue.id == guardId) {
							selected = 'selected';
						}
					}
					options += '<option value="'+mvalue.id+'" '+selected+'>'+mvalue.name+'</option>';
				})
				$('#eventguardId').html(options);
         //    if (is_customer == true) {
         //     $('#eventguardId').attr('disabled', '');

         // }
			}

		});
	}
	var form_data = new FormData();
	$("#saveShiftForm").submit(function(e) {
		e.preventDefault();
		form_data = new FormData(this);
    // form_data.append('name', "Mohsin")
	});
	$('#updateEventFormBtn').on('click', function(){
		if ($('#eventguardId').val() == '' || '{{$roster->publish_status}}' == 0) {
submitForm()
		}else{
		// console.log('<?php echo config("custom.roster_btns");?>');
		'@if(config("custom.roster_btns") == 0)'
  			submitForm(false)
		'@else'
		Swal.fire({text:"Please Confirm?",
       icon:"success",
       showCancelButton:!0,
       buttonsStyling:!1,
       confirmButtonText:"Notify",
       cancelButtonText:"Without Notify",
       customClass:{
          confirmButton:"btn fw-bold btn-success",
          cancelButton:"btn fw-bold btn-active-light-primary"
      }
  }).then((function(e){
   if (e.value == true) {
     submitForm()
  }else{
  submitForm(false)
}


}));
  '@endif'
}
		// submitForm();
	})
	$('#updateEventFormBtn1').on('click', function(){
  // $('#saveEventForm').submit();
		submitForm(false);
	})
	$('#updateEventFormBtn2').on('click', function(){
		submitForm(true, 1);
	})
	function task_cal()
	{
		var tasks = [];
		var task_counter = $('#task_counter').val();

		for (var i = 0; i <= task_counter; i++) {
			var task_start_time = $('#task-start-time-'+i).val();
			var task_description = $('#task-description-'+i).val();
			var task_id = $('#task-id-'+i).val();
			if (task_start_time != '' && task_description != '' && task_start_time != undefined) {
				tasks.push({
					task_start_time : task_start_time,
					task_description : task_description,
					task_id : task_id
				})
			}
		}
		return tasks;
	}

	function submitForm(notify = true, publish_status = null)
	{
        var own_payrate = "{{config('custom.own_payrates')}}";
		var start_date = $('#event_starts').val();
		var start_date = moment(start_date).format('YYYY-MM-DDTHH:mm:ssZ');
		var temp_start = moment(start_date).format('YYYY-MM-DD HH:mm');
		var tempDate = moment(start_date).format('YYYY-MM-DD');
		var end_date = $('#event_ends').val();
		var eventId = $("#eventeventId").val();
		var siteId = $('#eventSiteId').val();
		var guardId = $("#eventguardId").val();
		var startStatus = $("#eventstartStatus").val();
		var payable = $('input[name="job-payable"]:checked').val();
		var chargeable = $('input[name="job-chargeable"]:checked').val();
		if (own_payrate == '1') {
    var payrate_id = $("#payrate_id").val();

    }else{
    var payrate_id = $("#job-payrate-id").val();
    }
		// var payrate_id = $("#job-payrate-id").val();
		var chargerate_id = $("#job-chargerate-id").val();
		var  travel_time = $('#job-travel-time').val();
		var  paid_by = $('#job-paid-by').val();
		var  moke_guard = $('#moke_guard').val();
		var travel_time_payable = $('input[name="travel_time_payable"]:checked').val();
		var travel_time_chargeable = $('input[name="travel_time_chargeable"]:checked').val();
		var  travel_time_amount = $('#travel_time_amount').val();
		var  travel_time_amount_chargeable = $('#travel_time_amount_chargeable').val();
		var  overtime_value = $('#overtime_value').val();
		var unpublish_shift = $('input[name="unpublish_shift"]:checked').val();
		var break_enabled = $('input[name="break_enabled"]:checked').val();
		var break_deduction_time = $('#break_deduction_time').val();
		var custom_payrate = {
			'flat_metro_week_day_day' : $('#flat_metro_week_day_day').val(),
			'flat_metro_week_day_night' : $('#flat_metro_week_day_night').val(),
			'flat_metro_saturday' : $('#flat_metro_saturday').val(),
			'flat_metro_saturday_night' : $('#flat_metro_saturday_night').val(),
			'flat_metro_sunday' : $('#flat_metro_sunday').val(),
			'flat_metro_sunday_night' : $('#flat_metro_sunday_night').val(),
			'flat_metro_public_holiday' : $('#flat_metro_public_holiday').val(),
			'flat_metro_public_holiday_night' : $('#flat_metro_public_holiday_night').val()
		};
		var manual_custom_payrates = {
        'flat_metro_week_day_day' : $('input[name="flat_metro_week_day_day"]').val(),
        'flat_regional_week_day_day' : $('input[name="flat_regional_week_day_day"]').val(),
        'flat_metro_week_day_night' : $('input[name="flat_metro_week_day_night"]').val(),
        'flat_regional_week_day_night' : $('input[name="flat_regional_week_day_night"]').val(),
        'flat_metro_friday' : $('input[name="flat_metro_friday"]').val(),
        'flat_regional_friday' : $('input[name="flat_regional_friday"]').val(),
        'flat_metro_saturday' : $('input[name="flat_metro_saturday"]').val(),
        'flat_regional_saturday' : $('input[name="flat_regional_saturday"]').val(),
        'flat_metro_saturday_night' : $('input[name="flat_metro_saturday_night"]').val(),
        'flat_regional_saturday_night' : $('input[name="flat_regional_saturday_night"]').val(),
        'flat_metro_sunday' : $('input[name="flat_metro_sunday"]').val(),
        'flat_regional_sunday' : $('input[name="flat_regional_sunday"]').val(),
        'flat_metro_sunday_night' : $('input[name="flat_metro_sunday_night"]').val(),
        'flat_regional_sunday_night' : $('input[name="flat_regional_sunday_night"]').val(),
        'flat_metro_public_holiday' : $('input[name="flat_metro_public_holiday"]').val(),
        'flat_regional_public_holiday' : $('input[name="flat_regional_public_holiday"]').val(),
        'flat_metro_public_holiday_night' : $('input[name="flat_metro_public_holiday_night"]').val(),
        'flat_regional_public_holiday_night' : $('input[name="flat_regional_public_holiday_night"]').val(),

        'eba_metro_weekday_day' : $('input[name="eba_metro_weekday_day"]').val(),
        'eba_regional_weekday_day' : $('input[name="eba_regional_weekday_day"]').val(),
        'eba_metro_weekday_night' : $('input[name="eba_metro_weekday_night"]').val(),
        'eba_regional_weekday_night' : $('input[name="eba_regional_weekday_night"]').val(),
        'eba_metro_saturday_day' : $('input[name="eba_metro_saturday_day"]').val(),
        'eba_regional_saturday_day' : $('input[name="eba_regional_saturday_day"]').val(),
        'eba_metro_saturday_night' : $('input[name="eba_metro_saturday_night"]').val(),
        'eba_regional_saturday_night' : $('input[name="eba_regional_saturday_night"]').val(),
        'eba_metro_sunday_day' : $('input[name="eba_metro_sunday_day"]').val(),
        'eba_regional_sunday_day' : $('input[name="eba_regional_sunday_day"]').val(),
        'eba_metro_sunday_night' : $('input[name="eba_metro_sunday_night"]').val(),
        'eba_regional_sunday_night' : $('input[name="eba_regional_sunday_night"]').val(),
        'eba_metro_public_holiday' : $('input[name="eba_metro_public_holiday"]').val(),
        'eba_regional_public_holiday' : $('input[name="eba_regional_public_holiday"]').val(),
        'eba_metro_public_holiday_night' : $('input[name="eba_metro_public_holiday_night"]').val(),
        'eba_regional_public_holiday_night' : $('input[name="eba_regional_public_holiday_night"]').val(),

        'award_metro_weekday_day' : $('input[name="award_metro_weekday_day"]').val(),
        'award_regional_weekday_day' : $('input[name="award_regional_weekday_day"]').val(),
        'award_metro_weekday_night' : $('input[name="award_metro_weekday_night"]').val(),
        'award_regional_weekday_night' : $('input[name="award_regional_weekday_night"]').val(),
        'award_metro_saturday_day' : $('input[name="award_metro_saturday_day"]').val(),
        'award_regional_saturday_day' : $('input[name="award_regional_saturday_day"]').val(),
        'award_metro_saturday_night' : $('input[name="award_metro_saturday_night"]').val(),
        'award_regional_saturday_night' : $('input[name="award_regional_saturday_night"]').val(),
        'award_metro_sunday_day' : $('input[name="award_metro_sunday_day"]').val(),
        'award_regional_sunday_day' : $('input[name="award_regional_sunday_day"]').val(),
        'award_metro_sunday_night' : $('input[name="award_metro_sunday_night"]').val(),
        'award_regional_sunday_night' : $('input[name="award_regional_sunday_night"]').val(),
        'award_metro_public_holiday' : $('input[name="award_metro_public_holiday"]').val(),
        'award_regional_public_holiday' : $('input[name="award_regional_public_holiday"]').val(),
        'award_metro_public_holiday_night' : $('input[name="award_metro_public_holiday_night"]').val(),
        'award_regional_public_holiday_night' : $('input[name="award_regional_public_holiday_night"]').val(),

    };
    var manual_custom_chargerates = {
        'flat_metro_week_day_day' : $('input[name="charge_rate_flat_metro_week_day_day"]').val(),
        'flat_regional_week_day_day' : $('input[name="charge_rate_flat_regional_week_day_day"]').val(),
        'flat_metro_week_day_night' : $('input[name="charge_rate_flat_metro_week_day_night"]').val(),
        'flat_regional_week_day_night' : $('input[name="charge_rate_flat_regional_week_day_night"]').val(),
        'flat_metro_friday' : $('input[name="charge_rate_flat_metro_friday"]').val(),
        'flat_regional_friday' : $('input[name="charge_rate_flat_regional_friday"]').val(),

        'flat_metro_saturday' : $('input[name="charge_rate_flat_metro_saturday"]').val(),
        'flat_regional_saturday' : $('input[name="charge_rate_flat_regional_saturday"]').val(),
        // 'flat_metro_saturday_night' : $('input[name="charge_rate_flat_metro_saturday_night"]').val(),
        'flat_metro_saturday_night' : $('input[name="charge_rate_flat_metro_saturday"]').val(),
        // 'flat_regional_saturday_night' : $('input[name="charge_rate_flat_regional_saturday_night"]').val(),
        'flat_regional_saturday_night' : $('input[name="charge_rate_flat_regional_saturday"]').val(),

        'flat_metro_sunday' : $('input[name="charge_rate_flat_metro_sunday"]').val(),
        'flat_regional_sunday' : $('input[name="charge_rate_flat_regional_sunday"]').val(),
        // 'flat_metro_sunday_night' : $('input[name="charge_rate_flat_metro_sunday_night"]').val(),
        'flat_metro_sunday_night' : $('input[name="charge_rate_flat_metro_sunday"]').val(),
        // 'flat_regional_sunday_night' : $('input[name="charge_rate_flat_regional_sunday_night"]').val(),
        'flat_regional_sunday_night' : $('input[name="charge_rate_flat_regional_sunday"]').val(),

        'flat_metro_public_holiday' : $('input[name="charge_rate_flat_metro_public_holiday"]').val(),
        'flat_regional_public_holiday' : $('input[name="charge_rate_flat_regional_public_holiday"]').val(),
        'flat_metro_public_holiday_night' : $('input[name="charge_rate_flat_metro_public_holiday"]').val(),
        // 'flat_metro_public_holiday_night' : $('input[name="charge_rate_flat_metro_public_holiday_night"]').val(),
        'flat_regional_public_holiday_night' : $('input[name="charge_rate_flat_regional_public_holiday"]').val(),
        // 'flat_regional_public_holiday_night' : $('input[name="charge_rate_flat_regional_public_holiday_night"]').val(),

        'eba_metro_weekday_day' : 0,
        'eba_regional_weekday_day' : 0,
        'eba_metro_weekday_night' : 0,
        'eba_regional_weekday_night' : 0,
        'eba_metro_saturday_day' : 0,
        'eba_regional_saturday_day' : 0,
        'eba_metro_saturday_night' : 0,
        'eba_regional_saturday_night' : 0,
        'eba_metro_sunday_day' : 0,
        'eba_regional_sunday_day' : 0,
        'eba_metro_sunday_night' : 0,
        'eba_regional_sunday_night' : 0,
        'eba_metro_public_holiday' : 0,
        'eba_regional_public_holiday' : 0,
        'eba_metro_public_holiday_night' : 0,
        'eba_regional_public_holiday_night' : 0,

        'award_metro_weekday_day' : 0,
        'award_regional_weekday_day' : 0,
        'award_metro_weekday_night' : 0,
        'award_regional_weekday_night' : 0,
        'award_metro_saturday_day' : 0,
        'award_regional_saturday_day' : 0,
        'award_metro_saturday_night' : 0,
        'award_regional_saturday_night' : 0,
        'award_metro_sunday_day' : 0,
        'award_regional_sunday_day' : 0,
        'award_metro_sunday_night' : 0,
        'award_regional_sunday_night' : 0,
        'award_metro_public_holiday' : 0,
        'award_regional_public_holiday' : 0,
        'award_metro_public_holiday_night' : 0,
        'award_regional_public_holiday_night' : 0,

    };
		var  own_payrate = $('#own_payrate').val();
		var  pw_order = $('#pw_order').val();

		var ph_duration = $('input[name="ph_duration"]:checked').val();
		var public_holiday = 0;
		if ($('#public_holiday').prop('checked') == true) {
			public_holiday = 1;
		}else{
			public_holiday = 0;
		}
		var training = 0;
		if ($('#job-training').prop('checked') == true) {
			training = 1;
		}else{
			training = 0;
		}
		var continuation = 0;
		if ($('#job-continuation').prop('checked') == true) {
			continuation = 1;
		}else{
			continuation = 0;
		}
		var custom_rates = 'no';
		if ($('#job-custom-rates').prop('checked') == true) {
			custom_rates = 'yes';
		}else{
			custom_rates = 'no';
		}

		var covid_marshal = 0;
		if ($('#covid_marshal').prop('checked') == true) {
			covid_marshal = 1;
		}else{
			covid_marshal = 0;
		}
		var overtime = 0;
		if ($('#overtime').prop('checked') == true) {
			overtime = 1;
		}else{
			overtime = 0;
		}
		var tasks = task_cal();
        // console.log(tasks);
        // return;
		if (end_date === "") {
			end_date = start_date;
			temp_end = temp_start;
		} else {
			end_date = moment(end_date).format('YYYY-MM-DDTHH:mm:ssZ');
			temp_end = moment(end_date).format('YYYY-MM-DD HH:mm');;
		}
var manual_custom_payrate = 0;
    if ($('#custom_payrate').prop('checked') == true) {
        manual_custom_payrate = 1;
    }
    var custom_chargerate = 0;
    if ($('#custom_chargerate').prop('checked') == true) {
        custom_chargerate = 1;
    }
		if (Date.parse(temp_start) >= Date.parse(temp_end)) {
            // error_alert("Please select different end date and time.");
			return;
		}
        //$('.saveBtn').prop( "disabled", true );
		var operators_notes = $('#operators_notes_input').val();
		var submitted_roster_data = {
			start: start_date,
			end: end_date,
			siteId: siteId,
			guardId: guardId,
			eventId: eventId,
			tempDate: tempDate,
			startStatus: startStatus,
			temp_start: temp_start,
			temp_end: temp_end,
			save: "save",
			post_status: 0,
            // tasks:tasks,
			operators_notes : operators_notes,
			payable : payable,
			chargeable : chargeable, 
			custom_rates : custom_rates,
			payrate_id : payrate_id,
			chargerate_id : chargerate_id,
			training : training,
			continuation : continuation,
			travel_time : travel_time,
			paid_by : paid_by,
			notify : notify,
			public_holiday : public_holiday,
			travel_time_payable : travel_time_payable,
			travel_time_chargeable : travel_time_chargeable,
			covid_marshal : covid_marshal,
			moke_guard : moke_guard,
			overtime : overtime,
			travel_time_amount : travel_time_amount,
			overtime_value : overtime_value,
			travel_time_amount_chargeable :travel_time_amount_chargeable,
			unpublish_shift : unpublish_shift,
			break_enabled : break_enabled,
			break_deduction_time : break_deduction_time,
			custom_payrate : JSON.stringify(custom_payrate),
			own_payrate : own_payrate,
			ph_duration : ph_duration,
			manual_custom_payrate : manual_custom_payrate,
        manual_custom_payrates : JSON.stringify(manual_custom_payrates),
       		pw_order : pw_order,
       		 custom_chargerate : custom_chargerate,
        custom_charge_rate : JSON.stringify(manual_custom_chargerates)

		};

        // form_data = new FormData(document.querySelector('form'));
		$.each(submitted_roster_data,function(key,input){
			form_data.append(key, input);
		});
		if (publish_status != null) {
			form_data.append('publish_status', publish_status);
		}
        // submitted_roster_data_global = form_data;
        // console.log(form_data);
        // return;
		form_data.append('tasks', JSON.stringify(tasks));
		form_data.append('instructions_file', $('input#instructions_file')[0].files[0]);
		$.ajax({
			url: base_url + "/guard/checkAvailability",
			type: "post",
			dataType: "json",
			data: form_data,
			dataType: "json",
			cache: false,
			contentType: false,
			processData: false,
			success: function(result) {
                // return;
				if (result.message == "start") {
					$('.eventsaveBtn').prop("disabled", false);
					Swal.fire({
						text: 'You cannot add before job date.',
						icon: "error",
						buttonsStyling: !1,
						confirmButtonText: "Ok, got it!",
						customClass: {
							confirmButton: "btn btn-light"
						}
					})
                    // error_alert(`You cannot add ${guard_url} before job date.`);
                    // info.revert();
                    // info.event.remove();
					return;
				}
				if (result.message == "end") {
					$('.eventsaveBtn').prop("disabled", false);
                    // error_alert(`You cannot add ${guard_url} after job date.`);
					Swal.fire({
						text: 'You cannot add after job date.',
						icon: "error",
						buttonsStyling: !1,
						confirmButtonText: "Ok, got it!",
						customClass: {
							confirmButton: "btn btn-light"
						}
					})
                    // info.revert();
					return;
				}
				if (result.message == "already") {
					$('.eventsaveBtn').prop("disabled", false);
					Swal.fire({
						text: 'These timings are contradicting with other site timings because this guard is already added in another site.',
						icon: "error",
						buttonsStyling: !1,
						confirmButtonText: "Ok, got it!",
						customClass: {
							confirmButton: "btn btn-light"
						}
					})
                    // error_alert(``);
					return;

				}
				if (result.message == "updated") {
					$('.eventsaveBtn').prop("disabled", false);
					$('#kt_explore_form').css('left', '');
                    // $('#kt_modal_add_event').modal('toggle');
					$('#kt_explore_form').removeClass('drawer-on');

                    // message_alert(`${guard_url} Added successfully.`);
					Swal.fire({
						text: 'Roster updated successfully.',
						icon: "success",
						buttonsStyling: !1,
						confirmButtonText: "Ok, got it!",
						customClass: {
							confirmButton: "btn btn-light"
						}
					})
                    // message_alert("");
					renderCalendar(0, $('#userType').val());
				}

				if (result.message == "added") {
					$('.eventsaveBtn').prop("disabled", false);
					$('#kt_explore_form').css('left', '');
                    // $('#kt_modal_add_event').modal('toggle');
					$('#kt_explore_form').removeClass('drawer-on');
                    // message_alert(`${guard_url} Added successfully.`);
					Swal.fire({
						text: 'Added successfully',
						icon: "success",
						buttonsStyling: !1,
						confirmButtonText: "Ok, got it!",
						customClass: {
							confirmButton: "btn btn-light"
						}
					})
					renderCalendar(0, $('#userType').val());
                    // renderCalendar(siteId, 'calendar' + siteId, '', start_date);
				}

				if (result.message == "exceeded") {
					Swal.fire({
						text: 'limit exceeded',
						icon: "success",
						buttonsStyling: !1,
						confirmButtonText: "Ok, got it!",
						customClass: {
							confirmButton: "btn btn-light"
						}
					})
                    // error_alert(`${guard_url} limit exceeded`);
                    // info.event.remove();

					return;
				}

				if (result.type == "unauthorized") {
                    // error_alert(result.message);
                    // info.revert();
					if (result.by_pass == false) {
                      // error_alert(result.message);
						Swal.fire({
							text: result.message,
							icon: "success",
							buttonsStyling: !1,
							confirmButtonText: "Ok, got it!",
							customClass: {
								confirmButton: "btn btn-light"
							}
						});
                      // info.revert();
					}else{
                  	// Swal.fire({
                    //       text: result.message,
                    //       icon: "error",
                    //       buttonsStyling: !1,
                    //       confirmButtonText: "Ok, got it!",
                    //       customClass: {
                    //           confirmButton: "btn btn-light"
                    //       }
                    //   });
                      // confirm_from_super_admin(result.message);
						bypass_job();
					}
					return;
				}
				if (result.type == "Visa Expired") {
					Swal.fire({
						text: 'Visa Expired',
						icon: "success",
						buttonsStyling: !1,
						confirmButtonText: "Ok, got it!",
						customClass: {
							confirmButton: "btn btn-light"
						}
					});
					return;
				}
			}
		});
}
function addTasks()
{
	var task_counter = $('#task_counter').val();
   // if (day_counter < 6) {
	var html = '<div class="col-md-4 form-group task-counter-'+task_counter+'"><label for="recipient-name" class="col-form-label">Task Time</label><input type="text" class="form-control form-control-md" name="task-start-time-'+task_counter+'" id="task-start-time-'+task_counter+'"></div><div class="col-md-8 task-counter-'+task_counter+' form-group"><label for="recipient-name" class="col-form-label">Description</label><div class="row"><div class="col-md-10 "><textarea class="form-control form-control-md" name="task-description-0" id="task-description-'+task_counter+'" rows="1"></textarea></div><div class="col-md-2"><a class="btn-danger btn" id="add-task-inputs" onclick="delete_task_inputs('+task_counter+')" style="display: inline-block;height: 30px;padding: 2px 10px;"><i class="fas fa-trash fs-1x" style="padding: 0px;margin: 0px;font-size: 16px;"></i></a></div></div></div>';
	$('#tasks-inputs').append(html);
	initialize_time_input('#task-start-time-'+task_counter);
	task_counter++;
	$('#task_counter').val(task_counter);
        // initialize_time_input('#shift-end-time-'+day_counter);
    // }
}
function initialize_time_input(id)
{
	$(id).flatpickr({
		enableTime: true,
		time_24hr: true,
		noCalendar: true,
		dateFormat: "H:i",
	});

}	
function delete_task_inputs(index, id = null){


	if (id != null) {
		$.ajax({
			url: base_url+"/guard/deleteTask",
			type: "post",
			dataType: "json",
			data: {
				task_id : id,
				_token : token
			},
			success: function(result) {
				$('.task-counter-'+index).remove();
			}

		});
	}else{
		$('.task-counter-'+index).remove();
	}
}								

$('#job-custom-rates').on('change', function(){
	if($(this).prop('checked') == true){
        $('.custom-rates-input-1').css('display', '');
		$('.custom-rates-input').css('display', '');
	}else{
        $('.custom-rates-input-1').css('display', 'none');
		$('.custom-rates-input').css('display', 'none');
	}
});




function show_leave_option()
{
	$('.leave_option_div').css('display', '');	
}
function checkGuardLeave(roster_id, guard_id)
{
	var leave_option = $('#leave_option').val();
	$.ajax({
		url: base_url+"/guard/checkGuardLeave",
		type: "post",
		dataType: "json",
		data: {
			roster_id : roster_id,
			guard_id : guard_id,
			leave_option : leave_option,
			_token : token
		},
		success: function(result) {
			if (result.success) {
				Swal.fire({
					text: result.message,
					icon: "success",
					buttonsStyling: !1,
					confirmButtonText: "Ok, got it!",
					customClass: {
						confirmButton: "btn btn-light"
					}
				});
				$('.leave_option_div').css('display', 'none');
				$('.guard-leave-option').css('display', 'none');
				$('#eventguardId').val('');
		 // renderCalendar(0)
				renderCalendar(0, $('#userType').val());

			}else{
          	 // Swal.fire({
            //               text: result.message,
            //               icon: "error",
            //               buttonsStyling: !1,
            //               confirmButtonText: "Ok, got it!",
            //               customClass: {
            //                   confirmButton: "btn btn-light"
            //               }
            //           });

				Swal.fire({text:result.message,
					icon:"success",
					showCancelButton:!0,
					buttonsStyling:!1,
					confirmButtonText:"Yes",
					cancelButtonText:"No, cancel",
					customClass:{
						confirmButton:"btn fw-bold btn-success",
						cancelButton:"btn fw-bold btn-active-light-primary"
					}
				}).then((function(e){
					if (e.value == true) {
						$.ajax({
							url: base_url + "/guard/assignGuardLeave",
							type: "post",
							dataType: "json",
							data: {
								roster_id : roster_id,
								guard_id : guard_id,
								leave_option : leave_option,
								_token : token
							},
							success: function(result) {
								if (result.success == true) {
									Swal.fire({
										text: result.message,
										icon: "success",
										buttonsStyling: !1,
										confirmButtonText: "Ok, got it!",
										customClass: {
											confirmButton: "btn btn-light"
										}
									});
									$('.leave_option_div').css('display', 'none');
									$('.guard-leave-option').css('display', 'none');
									$('#eventguardId').val('');
		 // renderCalendar(0)
									renderCalendar(0, $('#userType').val());

								}

							}
						});
					}else{
   // Swal.fire({text:"Roster not published!",icon:"error",buttonsStyling:!1,confirmButtonText:"Ok, got it!",customClass:{confirmButton:"btn fw-bold btn-primary"}});
					}


				}));
			}
		}

	});


}
function loadTabData(tab, guard_id, roster_id, data_id)
{
	call_spinner();
  	// console.log('I am')
	$.ajax({
		url: base_url+"/guard/loadTabData",
		type: "post",
		dataType: "json",
		data: {
			roster_id : roster_id,
			guard_id : guard_id,
			tab : tab,
			_token : token
		},
		success: function(result) {
			close_spinner();
			$('#'+data_id).html(result);
			if (tab == 'signin') {
				call_map();
			}
			if (tab == 'signout') {
				call_map1();
			}
			if (tab == 'tracker') {
				locations_maps();
			}
			if (tab == 'green_call') {
				green_call_locations_maps();
			}
		}
	});
}

function deleteShift(roster_id)
{
	Swal.fire({text:"Are you sure you want to delete this shift??",
		icon:"success",
		showCancelButton:!0,
		buttonsStyling:!1,
		confirmButtonText:"Yes",
		cancelButtonText:"No, cancel",
		customClass:{
			confirmButton:"btn fw-bold btn-success",
			cancelButton:"btn fw-bold btn-active-light-primary"
		}
	}).then((function(e){
		if (e.value == true) {
			$.ajax({
				url: base_url + "/guard/deleteShift",
				type: "post",
				dataType: "json",
				data: {
					roster_id: roster_id,
					_token : token
				},
				success: function(result) {
					if (result.success == true) {
						$('#kt_explore_form').css('left', '');
						Swal.fire({
							text:"Your shift delete successfully.",
							icon:"success",
							buttonsStyling:!1,
							confirmButtonText:"Ok, got it!",
							customClass:{
								confirmButton:"btn fw-bold btn-primary"
							}})
						$('#kt_explore_form').removeClass('drawer-on')
						renderCalendar(0, $('#userType').val());
					}else{
						Swal.fire({
							text:result.message,
							icon: "error",
							buttonsStyling:!1,
							confirmButtonText:"Ok, got it!",
							customClass:{
								confirmButton:"btn fw-bold btn-primary"
							}})
					}
				}
			});
		}else{
			Swal.fire({text:"Cancel!",icon:"error",buttonsStyling:!1,confirmButtonText:"Ok, got it!",customClass:{confirmButton:"btn fw-bold btn-primary"}});
		}


	}));
}
$('input[type=radio][name=job-payable]').on('change', function(){
	console.log($(this).val())
	if ($(this).val() == 'no') {
		$('#paid-by-div').css('display', 'none');
	}else{
		$('#paid-by-div').css('display', '');
	}
});
function tt_payable_chargeable()
{
	var tt = $('#job-travel-time').val();
	if (tt == 0 || tt == '') {
		if (tt == 0) {
			$('#travel_time_amount_div').css('display', '');
		}else{
			$('#travel_time_amount_div').css('display', 'none');
		}
		$('.tt_payable_chargeable').css('display', 'none');
	}else{
		$('.tt_payable_chargeable').css('display', '');
	}
}
function setDateTimeFormat(type)
{
	var default_start = $('#default_start').val();
	if (type == 'start') 
	{
		var start_time = $('#event_start_time').val();
		$('#event_starts').val(default_start +' '+start_time)
	}else{
		var start_time = $('#event_start_time').val();
		var end_time = $('#event_end_time').val();
		var start_temp = start_time.replace(':', '.') * 1;
		var end_temp = end_time.replace(':', '.') * 1;
		if (end_temp < start_temp) {
			var startDate = new Date(default_start);
			default_start = new Date(startDate.setDate(startDate.getDate() + 1));
			default_start = moment(default_start).format('YYYY-MM-DD');
      // console.log(default_start)
		}
		$('#event_ends').val(default_start +' '+end_time)
	}
}
$('input[type=radio][name=break_enabled]').on('change', function() {
	console.log($(this).val())
	if ($(this).val() == '0') {
		$('#break-deduction-div').css('display', 'none');
	} else {
		$('#break-deduction-div').css('display', '');
	}
});
function getPayChargeRate(type, id) {
	var level = $('#' + id).val();
        // console.log($('#' + id).val())
	var site_id = $('#eventSiteId').val();
	var state = $('#customer-state').val();
	$.ajax({
		url: base_url + "/guard/getPayChargeRate",
		type: "post",
		dataType: "json",
		data: {
			level: level,
			state: state,
			type: type,
			_token: '<?php echo csrf_token(); ?>',
			site_id : site_id
		},
		success: function(result) {
			var options = '';
			if (result.rates.length > 0) {
				$.each(result.rates, function(index, value) {
					options += '<option value="' + value.id + '">' + value.title + '</option>';
				});
			}
			$('#job-' + type + '-id').html(options);
		}
	})

}
$('#own_payrate').on('change', function(){
	// if ($(this).val() == 'custom') {
	// 	$('.custom-rate').css('display', '');
	// }else{
	// 	$('.custom-rate').css('display', 'none');
	// }
	var type = $(this).val();
    $.ajax({
        url: base_url + "/payrates/getTypePayrate",
        type: "post",
        dataType: "json",
        data: {
            type: type,
            _token: '<?php echo csrf_token(); ?>',
        },
        success: function(result) {
            var options = '';
            if (result.rates.length > 0) {
                $.each(result.rates, function(index, value) {
                    options += '<option value="' + value.id + '">' + value.title + '</option>';
                });
            }
            $('#payrate_id').html(options);
        }
    })
    if ($(this).val() != '') {
        $('.custom-rates-selection').css('display', '')
    }else{
        $('.custom-rates-selection').css('display', 'none')
        var own_payrate = "{{config('custom.own_payrates')}}";
    }
});
$('#public_holiday').on('change', function() {
	if ($(this).prop('checked') == true) {
		$('#public_holiday_div').css('display', '');
	} else {
		$('#public_holiday_div').css('display', 'none');
	}
});

function check_availibilty(notify = true) {
	var start_date = $('#event_starts').val();
	var start_date = moment(start_date).format('YYYY-MM-DDTHH:mm:ssZ');
	var temp_start = moment(start_date).format('YYYY-MM-DD HH:mm');
	var tempDate = moment(start_date).format('YYYY-MM-DD');
	var end_date = $('#event_ends').val();
	var eventId = $("#eventeventId").val();
	var siteId = $('#eventSiteId').val();
	var guardId = $("#eventguardId").val();
	var startStatus = $("#eventstartStatus").val();
	var payable = $('input[name="job-payable"]:checked').val();
	var chargeable = $('input[name="job-chargeable"]:checked').val();
	var payrate_id = $("#job-payrate-id").val();
	var chargerate_id = $("#job-chargerate-id").val();
	var  travel_time = $('#job-travel-time').val();
	var  paid_by = $('#job-paid-by').val();
	var  moke_guard = $('#moke_guard').val();
	var travel_time_payable = $('input[name="travel_time_payable"]:checked').val();
	var travel_time_chargeable = $('input[name="travel_time_chargeable"]:checked').val();
	var  travel_time_amount = $('#travel_time_amount').val();
	var  travel_time_amount_chargeable = $('#travel_time_amount_chargeable').val();
	var  overtime_value = $('#overtime_value').val();
	var unpublish_shift = $('input[name="unpublish_shift"]:checked').val();
	var break_enabled = $('input[name="break_enabled"]:checked').val();
	var break_deduction_time = $('#break_deduction_time').val();
	var custom_payrate = {
		'flat_metro_week_day_day' : $('#flat_metro_week_day_day').val(),
		'flat_metro_week_day_night' : $('#flat_metro_week_day_night').val(),
		'flat_metro_saturday' : $('#flat_metro_saturday').val(),
		'flat_metro_saturday_night' : $('#flat_metro_saturday_night').val(),
		'flat_metro_sunday' : $('#flat_metro_sunday').val(),
		'flat_metro_sunday_night' : $('#flat_metro_sunday_night').val(),
		'flat_metro_public_holiday' : $('#flat_metro_public_holiday').val(),
		'flat_metro_public_holiday_night' : $('#flat_metro_public_holiday_night').val()
	};
	var  own_payrate = $('#own_payrate').val();

	var ph_duration = $('input[name="ph_duration"]:checked').val();
	var public_holiday = 0;
	if ($('#public_holiday').prop('checked') == true) {
		public_holiday = 1;
	}else{
		public_holiday = 0;
	}
	var training = 0;
	if ($('#job-training').prop('checked') == true) {
		training = 1;
	}else{
		training = 0;
	}
	var continuation = 0;
	if ($('#job-continuation').prop('checked') == true) {
		continuation = 1;
	}else{
		continuation = 0;
	}
	var custom_rates = 'no';
	if ($('#job-custom-rates').prop('checked') == true) {
		custom_rates = 'yes';
	}else{
		custom_rates = 'no';
	}

	var covid_marshal = 0;
	if ($('#covid_marshal').prop('checked') == true) {
		covid_marshal = 1;
	}else{
		covid_marshal = 0;
	}
	var overtime = 0;
	if ($('#overtime').prop('checked') == true) {
		overtime = 1;
	}else{
		overtime = 0;
	}
	var tasks = task_cal();
        // console.log(tasks);
        // return;
	if (end_date === "") {
		end_date = start_date;
		temp_end = temp_start;
	} else {
		end_date = moment(end_date).format('YYYY-MM-DDTHH:mm:ssZ');
		temp_end = moment(end_date).format('YYYY-MM-DD HH:mm');;
	}

	if (Date.parse(temp_start) >= Date.parse(temp_end)) {
            // error_alert("Please select different end date and time.");
		return;
	}
        //$('.saveBtn').prop( "disabled", true );
	var operators_notes = $('#operators_notes_input').val();
	var submitted_roster_data = {
		start: start_date,
		end: end_date,
		siteId: siteId,
		guardId: guardId,
		eventId: eventId,
		tempDate: tempDate,
		startStatus: startStatus,
		temp_start: temp_start,
		temp_end: temp_end,
		save: "save",
		post_status: 0,
            // tasks:tasks,
		operators_notes : operators_notes,
		payable : payable,
		chargeable : chargeable, 
		custom_rates : custom_rates,
		payrate_id : payrate_id,
		chargerate_id : chargerate_id,
		training : training,
		continuation : continuation,
		travel_time : travel_time,
		paid_by : paid_by,
		notify : notify,
		public_holiday : public_holiday,
		travel_time_payable : travel_time_payable,
		travel_time_chargeable : travel_time_chargeable,
		covid_marshal : covid_marshal,
		moke_guard : moke_guard,
		overtime : overtime,
		travel_time_amount : travel_time_amount,
		overtime_value : overtime_value,
		travel_time_amount_chargeable :travel_time_amount_chargeable,
		unpublish_shift : unpublish_shift,
		break_enabled : break_enabled,
		break_deduction_time : break_deduction_time,
		custom_payrate : JSON.stringify(custom_payrate),
		own_payrate : own_payrate,
		ph_duration : ph_duration,
		by_pass : true

	};
        // submitted_roster_data_global.append('by_pass', true);
	$.each(submitted_roster_data,function(key,input){
		form_data.append(key, input);
	});
        // submitted_roster_data_global = form_data;
        // console.log(form_data);
        // return;
	form_data.append('tasks', JSON.stringify(tasks));
	form_data.append('instructions_file', $('input#instructions_file')[0].files[0]);
	$.ajax({
		url: base_url + "/guard/checkAvailability",
		type: "post",
		dataType: "json",
		data: form_data,
		dataType: "json",
		cache: false,
		contentType: false,
		processData: false,
		success: function(result) {
                // return;
			if (result.message == "start") {
				$('.eventsaveBtn').prop("disabled", false);
				Swal.fire({
					text: 'You cannot add before job date.',
					icon: "error",
					buttonsStyling: !1,
					confirmButtonText: "Ok, got it!",
					customClass: {
						confirmButton: "btn btn-light"
					}
				})
                    // error_alert(`You cannot add ${guard_url} before job date.`);
                    // info.revert();
                    // info.event.remove();
				return;
			}
			if (result.message == "end") {
				$('.eventsaveBtn').prop("disabled", false);
                    // error_alert(`You cannot add ${guard_url} after job date.`);
				Swal.fire({
					text: 'You cannot add after job date.',
					icon: "error",
					buttonsStyling: !1,
					confirmButtonText: "Ok, got it!",
					customClass: {
						confirmButton: "btn btn-light"
					}
				})
                    // info.revert();
				return;
			}
			if (result.message == "already") {
				$('.eventsaveBtn').prop("disabled", false);
				Swal.fire({
					text: 'These timings are contradicting with other site timings because this guard is already added in another site.',
					icon: "error",
					buttonsStyling: !1,
					confirmButtonText: "Ok, got it!",
					customClass: {
						confirmButton: "btn btn-light"
					}
				})
                    // error_alert(``);
				return;

			}
			if (result.message == "updated") {
				$('.eventsaveBtn').prop("disabled", false);
				$('#kt_explore_form').css('left', '');
                    // $('#kt_modal_add_event').modal('toggle');
				$('#kt_explore_form').removeClass('drawer-on');

                    // message_alert(`${guard_url} Added successfully.`);
				Swal.fire({
					text: 'Roster updated successfully.',
					icon: "success",
					buttonsStyling: !1,
					confirmButtonText: "Ok, got it!",
					customClass: {
						confirmButton: "btn btn-light"
					}
				})
                    // message_alert("");
				renderCalendar(0, $('#userType').val());
			}

			if (result.message == "added") {
				$('.eventsaveBtn').prop("disabled", false);
				$('#kt_explore_form').css('left', '');
                    // $('#kt_modal_add_event').modal('toggle');
				$('#kt_explore_form').removeClass('drawer-on');
                    // message_alert(`${guard_url} Added successfully.`);
				Swal.fire({
					text: 'Added successfully',
					icon: "success",
					buttonsStyling: !1,
					confirmButtonText: "Ok, got it!",
					customClass: {
						confirmButton: "btn btn-light"
					}
				})
				renderCalendar(0, $('#userType').val())
			}

			if (result.message == "exceeded") {
				Swal.fire({
					text: 'limit exceeded',
					icon: "success",
					buttonsStyling: !1,
					confirmButtonText: "Ok, got it!",
					customClass: {
						confirmButton: "btn btn-light"
					}
				})
                    // error_alert(`${guard_url} limit exceeded`);
                    // info.event.remove();

				return;
			}

			if (result.type == "unauthorized") {
                    // error_alert(result.message);
                    // info.revert();
				if (result.by_pass == false) {
                        // error_alert(result.message);
					Swal.fire({
						text: result.message,
						icon: "success",
						buttonsStyling: !1,
						confirmButtonText: "Ok, got it!",
						customClass: {
							confirmButton: "btn btn-light"
						}
					});
                        // info.revert();
				} else {
					Swal.fire({
						text: result.message,
						icon: "error",
						buttonsStyling: !1,
						confirmButtonText: "Ok, got it!",
						customClass: {
							confirmButton: "btn btn-light"
						}
					});
                        // bypass_job();

                        // confirm_from_super_admin(result.message);
				}
				return;
			}
			if (result.type == "Visa Expired") {
				Swal.fire({
					text: 'Visa Expired',
					icon: "success",
					buttonsStyling: !1,
					confirmButtonText: "Ok, got it!",
					customClass: {
						confirmButton: "btn btn-light"
					}
				});
				return;
			}
		}
	});

}
$('#unlockShift').on('click', function(){
	unlockShift();
});
function unlockShift() {
            	// commented by Mohsin and now not used
	Swal.fire({
		text: "Are you sure you want to request code from Super admin ?",
		icon: "warning",
		showCancelButton: !0,
		buttonsStyling: !1,
		confirmButtonText: "Yes!",
		cancelButtonText: "No, return",
		customClass: {
			confirmButton: "btn btn-primary",
			cancelButton: "btn btn-active-light"
		}
	}).then((function(t) {
		t.value ? (
			$('#validate_shift_passcode_modal').modal('show')

			) : "cancel" === t.dismiss && Swal.fire({
				text: "Your action has been cancelled!.",
				icon: "error",
				buttonsStyling: !1,
				confirmButtonText: "Ok, got it!",
				customClass: {
					confirmButton: "btn btn-primary"
				}
			})
		}))
}
$("#shift_validate_form").on('submit', function(e) {
	e.preventDefault();
            // console.log(this.id)
	var data = $('#' + this.id).serialize();
	$.ajax({
		type: "POST",
		url: this.action,
		data: data,
		success: function(result) {
			if (result.success) {
				Swal.fire({
					text: result.message,
					icon: "success",
					buttonsStyling: !1,
					confirmButtonText: "Ok, got it!",
					customClass: {
						confirmButton: "btn btn-light"
					}
				})
				$('#shift_code').val('');
				$('#validate_shift_passcode_modal').modal('hide');
				$('.footer-unlock-btns').css('display', 'none');
				$('.footer-btns').css('display', '');

			} else {
				Swal.fire({
					text: result.message,
					icon: "error",
					buttonsStyling: !1,
					confirmButtonText: "Ok, got it!",
					customClass: {
						confirmButton: "btn btn-light"
					}
				})
			}
		}
	})
});
$('#custom_payrate').on('change', function(){
        if (document.getElementById('custom_payrate').checked == true)
        {
            $('.custom-rates-input').css('display', 'none');
            $('.own_payrates_div').css('display','');
        }else{
            $('.custom-rates-input').css('display', '');
            $('.own_payrates_div').css('display','none');
        }
    });
$('#custom_chargerate').on('change', function(){
        if (document.getElementById('custom_chargerate').checked == true)
        {
            $('.custom-rates-input').css('display', 'none');
            $('.own_chargerate_div').css('display','');
        }else{
            $('.custom-rates-input').css('display', '');
            $('.own_chargerate_div').css('display','none');
        }
    });
</script>