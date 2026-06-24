<?php
$permissions = [];
$is_super_admin = 0;
if (session()->has('permissions')) {
    $permissions = json_decode(session()->get('permissions'), true);
}
if (session()->has('isAdmin')) {
    $is_super_admin = session()->get('isAdmin');
}
// print_r($permissions);
// exit();
$item = session()->get('config_arr_job_roster');
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
    $item['publish'] = 1;
    $item['add_site'] = 1;
    $item['ad_shift'] = 1;
    $item['report'] = 1;
    $item['active_sites'] = 1;
    $item['inactive_sites'] = 1;
    $item['rollover_this_week'] = 1;
    $item['site_type'] = 1;
    $item['site_trained'] = 1;
    $item['breaks'] = 1;
    $item['welfare_calls'] = 1;
    $item['site_hours'] = 1;
    $item['charge_rates_level'] = 1;
    $item['charge_rates'] = 1;
    $item['signin_radius'] = 1;
    $item['radius_alert'] = 1;
    $item['job_instrcutions'] = 1;
    $item['sos_phone'] = 1;
    $item['tasks'] = 1;
    $item['start_date'] = 1;
    $item['end_date'] = 1;
    $item['three_dots_shifts'] = 1;
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

    $item = json_decode(json_encode($item));
}
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
@if (session()->get('userType') == 'admin' || session()->get('userType') == 'customer')
<div class="card-header" id="kt_explore_header">
    <h3 class="card-title fw-bolder text-gray-700" id="from-title">Add Shift</h3>
    <div class="card-toolbar">
        <button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n5" id="kt_explore_close_form" onclick="$('#kt_explore_form').css('left', '');">
            <!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
            <span class="svg-icon svg-icon-2">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                height="24px" viewBox="0 0 24 24" version="1.1">
                <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)"
                fill="#000000">
                <rect fill="#000000" x="0" y="7" width="16" height="2"
                rx="1" />
                <rect fill="#000000" opacity="0.5"
                transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)"
                x="0" y="7" width="16" height="2" rx="1" />
            </g>
        </svg>
    </span>
    <!--end::Svg Icon-->
</button>
</div>
@if ($ph)
<div class="text-center col-12">
    <h5 class="text-danger" title="{{ $information }}">Public Holiday: {{ $holiday_name }} <span><i
        class="fas fa-info-circle" title="{{ $information }}"></i></span></h5>
        <!-- <span>{{ $information }}</span> -->
    </div>
    @endif
</div>
<!--end::Header-->
<!--begin::Body-->
<form class="form" action="#" id="saveShiftForm" enctype="multipart/form-data">

    <!-- <form class="form" action="#" id="saveEventForm" > -->

        <div class="card-body" id="kt_explore_body">

            <!--begin::Content-->
            <div id="kt_explore_scroll" class="scroll-y me-n5 pe-5" data-kt-scroll="true" data-kt-scroll-height="auto"
            data-kt-scroll-wrappers="#kt_explore_body"
            data-kt-scroll-dependencies="#kt_explore_header, #kt_explore_footer" data-kt-scroll-offset="5px">
            <!--begin::Demos-->
            <div class="mb-0">
                <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#shift_details">Shift details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#shift_tasks">Shift tasks</a>
                    </li>
                        <!-- <li class="nav-item">
              <a class="nav-link " data-bs-toggle="tab" href="#shift_activity">Shift activity</a>
          </li> -->
      </ul>
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade fade active show" id="shift_details" role="tabpanel">
            <!--begin::Input group-->
            <input type="hidden" id="eventeventId" value="0">
            <input type="hidden" id="eventstartStatus" value="2">
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-bold required mb-2">Select Site</label>
                <!--end::Label-->
                <select class="eventSiteId" id="{{ $gaurds_disabeld != '' ? 'eventSiteId-' : 'eventSiteId' }}" name="eventSiteId" {{ $site_disabeld }}>
                                <!-- <select class="form-select form-select-lg form-select-solid" data-control="select2"
                                    data-placeholder="Select..." data-allow-clear="true" data-hide-search="true"
                                    id="{{ $gaurds_disabeld != '' ? 'eventSiteId-' : 'eventSiteId' }}"
                                    name="eventSiteId" {{ $site_disabeld }}> -->
                                    <option value="">Select Site</option>
                                    @foreach ($sites as $site)
                                    <option value="{{ $site->jobId }}"
                                        {{ $site_id == $site->jobId ? 'selected' : '' }}>{{ $site->site_name }}
                                        ({{ $site->site_description }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="fv-row mb-9">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold required mb-2">{{ config('custom.guard') }}</label>
                                    <!--end::Label-->
                                    <!-- <select class="form-select form-select-solid" data-control="select2" data-dropdown-parent="#kt_modal_new_address" data-placeholder="Select..." id="eventguardId" name="eventguardId" {{ $gaurds_disabeld }}> -->
                                        <select id="eventguardId" name="eventguardId" {{ $gaurds_disabeld }}>
                                            <!-- <option value="0"></option> -->
                                            <option value=""></option>

                                            @foreach ($guards as $guard)
                                            <option value="{{ $guard->id }}"
                                                {{ $guard_id == $guard->id ? 'selected' : '' }}>{{ $guard->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if ((isset($permissions['mock_guard']) && $permissions['mock_guard'] == true) || $is_super_admin == 1)
                                    <!--end::Input group-->
                                    <div class="col-sm-12 ">
                                        <div class="fv-row">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold mb-2">Unprofiled Name</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" class="form-control form-control-solid" placeholder=""
                                            name="calendar_event_description" id="moke_guard" name="moke_guard"
                                            value="" />
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    @endif

                                    <input type="hidden" name="default_start" id="default_start"
                                    value="{{ date('Y-m-d', strtotime($start)) }}">
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-9">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold mb-2">Start Time</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid time-picker"
                                        placeholder="" name="event_start_time" id="event_start_time"
                                        onchange="setDateTimeFormat('start')" />

                                        <input type="hidden" class="form-control form-control-solid date-time1"
                                        placeholder="" name="event_starts" id="event_starts" />
                                        <!--end::Input-->
                                    </div>

                                    <div class="fv-row mb-9">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold mb-2">End Time</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid time-picker"
                                        placeholder="" name="event_end_time" id="event_end_time"
                                        onchange="setDateTimeFormat('end')" />
                                        <input type="hidden" class="form-control form-control-solid date-time1"
                                        placeholder="" name="calendar_event_description" id="event_ends" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->

                                    <div class="fv-row mb-9">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold mb-2">P.O/W.O</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid"
                                        placeholder="" name="pw_order" id="pw_order"/>
                                       
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->

                                    <div class="fv-row mb-9">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold mb-2">Job Instruction</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="file" class="form-control form-control-solid" placeholder=""
                                        name="instructions_file" id="instructions_file" />
                                        <!--end::Input-->
                                    </div>
                                    @if (session()->get('userType') != 'customer')
                                    <!--end::Input group-->
                                    <div class="fv-row mb-9">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold mb-2">Travel Time</label>
                                        <!--end::Label-->
                                        <select class="form-select form-select-lg form-select-solid" data-control="select2"
                                        data-placeholder="Select..." data-allow-clear="true" data-hide-search="true"
                                        id="job-travel-time" name="job-travel-time" onchange="tt_payable_chargeable()">
                                        <option value="">Select Travel Time</option>
                                        <option value="0.5">0.5 hour</option>
                                        <option value="1">1 hour</option>
                                        <option value="1.5">1.5 hour</option>
                                        <option value="2">2 hour</option>
                                        <option value="0">Other</option>
                                    </select>
                                </div>
                                <div class="fv-row mb-9" id="travel_time_amount_div" style="display: none;">
                                    <!--begin::Label-->
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="fs-6 fw-bold mb-2">Travel Time Amount ($)</label>
                                            <!--end::Label-->
                                            <input type="number" class="form-control form-control-solid" placeholder=""
                                            name="travel_time_amount" id="travel_time_amount" step="any" />
                                        </div>
                                        <div class="col-6">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold mb-2">Travel Time Amount chargeable ($)</label>
                                            <!--end::Label-->
                                            <input type="number" class="form-control form-control-solid" placeholder=""
                                            name="travel_time_amount_chargeable" id="travel_time_amount_chargeable"
                                            step="any" />
                                        </div>
                                    </div>

                                </div>
                                <div class="fv-row mb-9">
                                    <!--end::Label-->
                                    <div class="row">
                                        <div class="col-6 tt_payable_chargeable" style="display: none">
                                            <label class="fs-6 fw-bold mb-2">T.T Payable</label>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-check form-check-custom form-check-solid me-10">
                                                        <input class="form-check-input h-30px w-30px"
                                                        name="travel_time_payable" type="radio" value="yes"
                                                        id="travel_time_payable" checked="">
                                                        <label class="form-check-label" for="travel_time_payable">
                                                            Yes
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-check form-check-custom form-check-solid me-10">
                                                        <input class="form-check-input h-30px w-30px"
                                                        name="travel_time_payable" type="radio" value="no"
                                                        id="travel_time_payable">
                                                        <label class="form-check-label" for="travel_time_payable">
                                                            No
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--  -->
                                        <div class="col-6 tt_payable_chargeable" style="display: none">
                                            <label class="fs-6 fw-bold mb-2">T.T Chargeable</label>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-check form-check-custom form-check-solid me-10">
                                                        <input class="form-check-input h-30px w-30px"
                                                        name="travel_time_chargeable" type="radio" value="yes"
                                                        id="travel_time_chargeable" checked="">
                                                        <label class="form-check-label" for="travel_time_chargeable">
                                                            Yes
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-check form-check-custom form-check-solid me-10">
                                                        <input class="form-check-input h-30px w-30px"
                                                        name="travel_time_chargeable" type="radio" value="no"
                                                        id="travel_time_chargeable">
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
                                <div class="fv-row mb-9">
                                    <!--begin::Label-->
                                    <!--end::Label-->
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="fs-6 fw-bold mb-2">Shift Paybale</label>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-check form-check-custom form-check-solid me-10">
                                                        <input class="form-check-input h-30px w-30px" name="job-payable"
                                                        type="radio" value="yes" id="job-payable" checked/>
                                                        <label class="form-check-label" for="job-payable">
                                                            Yes
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-check form-check-custom form-check-solid me-10">
                                                        <input class="form-check-input h-30px w-30px" name="job-payable"
                                                        type="radio" value="no" id="job-payable" />
                                                        <label class="form-check-label" for="job-payable">
                                                            No
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6" id="paid-by-div1" style="display: none;">
                                            <div class="fv-row mb-9">
                                                <!--begin::Label-->
                                                <label class="fs-6 fw-bold mb-2">Paid by</label>
                                                <!--end::Label-->
                                                <select class="form-select form-select-lg form-select-solid"
                                                data-control="select2" data-placeholder="Select..."
                                                data-allow-clear="true" data-hide-search="true" id="job-paid-by"
                                                name="job-paid-by">
                                                <option value="">Paid by</option>
                                                <option value="direct">Paid as direct employee</option>
                                                <option value="contractor">Paid as contractor employee</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- end col-6 outer -->
                                    <div class="col-6">
                                        <label class="fs-6 fw-bold mb-2">Shift Chargeable</label>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-check form-check-custom form-check-solid me-10">
                                                    <input class="form-check-input h-30px w-30px" type="radio"
                                                    value="yes" id="job-chargeable" name="job-chargeable"
                                                    checked />
                                                    <label class="form-check-label" for="job-chargeable">
                                                        Yes
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-check form-check-custom form-check-solid me-10">
                                                    <input class="form-check-input h-30px w-30px" type="radio"
                                                    value="no" id="job-chargeable" name="job-chargeable" />
                                                    <label class="form-check-label" for="job-chargeable">
                                                        No
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col-6 outer -->
                                    <!-- end col-6 outer -->
                                    <div class="col-6">
                                        <label class="fs-6 fw-bold mb-2">Un-published Shift</label>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-check form-check-custom form-check-solid me-10">
                                                    <input class="form-check-input h-30px w-30px" type="radio"
                                                    value="1" id="unpublish_shift" name="unpublish_shift" />
                                                    <label class="form-check-label" for="unpublish_shift">
                                                        Yes
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-check form-check-custom form-check-solid me-10">
                                                    <input class="form-check-input h-30px w-30px" type="radio"
                                                    value="0" id="unpublish_shift" name="unpublish_shift"
                                                    checked />
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
                            <div class="fv-row mb-9">
                                <div class="row">
                                    <!-- end col-6 outer -->
                                    <div class="col-6">
                                        <label class="fs-6 fw-bold mb-2">Break</label>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-check form-check-custom form-check-solid me-10">
                                                    <input class="form-check-input h-30px w-30px" type="radio"
                                                    value="1" id="break_enabled" name="break_enabled" />
                                                    <label class="form-check-label" for="break_enabled">
                                                        Yes
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-check form-check-custom form-check-solid me-10">
                                                    <input class="form-check-input h-30px w-30px" type="radio"
                                                    value="0" id="break_enabled" name="break_enabled"
                                                    checked />
                                                    <label class="form-check-label" for="break_enabled">
                                                        No
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col-6 outer -->

                                    <div class="col-6" id="break-deduction-div" style="display: none;">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold required mb-2">Break Deduction Time</label>
                                        <!--end::Label-->
                                        <select class="form-select form-select-lg form-select-solid"
                                        data-control="select2" data-placeholder="Select..." data-allow-clear="true"
                                        data-hide-search="true" id="break_deduction_time" name="break_deduction_time">
                                        <option value="0">Select Break Deduction Time</option>
                                        <option value="15">15 Mins</option>
                                        <option value="30">30 Mins</option>
                                        <option value="45">45 Mins</option>
                                        <option value="60">1 Hour</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="fv-row mb-9">
                            <!--begin::Label-->
                            <!-- <label class="fs-6 fw-bold mb-2"></label> -->
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="form-check form-check-custom form-check-solid me-10">
                                <input class="form-check-input h-30px w-30px" type="checkbox" value="true"
                                id="public_holiday" name="public_holiday" {{(($ph == true) ? 'checked' : '')}}/>
                                <label class="form-check-label" for="job-custom-rates">
                                    Public Holiday
                                </label>
                            </div>
                            <!--end::Input-->
                        </div>
                        <div class="fv-row mb-9" id="_public_holiday_div{{(($ph == true && config('custom.domain_id') != 58) ? '' : '58')}}" style="display: {{(($ph == true && config('custom.domain_id') != 58) ? 'none' : 'none')}};"">
                            <!-- end col-6 outer -->
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-check form-check-custom form-check-solid me-10">
                                        <input class="form-check-input h-30px w-30px" type="radio"
                                        value="1" id="ph_duration" name="ph_duration" />
                                        <label class="form-check-label" for="ph_duration">
                                            All Shift
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check form-check-custom form-check-solid me-10">
                                        <input class="form-check-input h-30px w-30px" type="radio"
                                        value="0" id="ph_duration" name="ph_duration" checked/>
                                        <label class="form-check-label" for="ph_duration">
                                            Start day only
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- end col-6 outer -->
                        </div>
                        <div class="fv-row mb-9">
                            <!--begin::Label-->
                            <!-- <label class="fs-6 fw-bold mb-2"></label> -->
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="form-check form-check-custom form-check-solid me-10">
                                <input class="form-check-input h-30px w-30px" type="checkbox" value="true"
                                id="overtime" name="overtime" />
                                <label class="form-check-label" for="overtime">
                                    Overtime
                                </label>
                            </div>
                            <!--end::Input-->
                        </div>
                        <div class="fv-row mb-9 overtime-value-div" style="display: none">
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold required mb-2">Overtime Value</label>
                            <!--end::Label-->
                            <select class="form-select form-select-lg form-select-solid" data-control="select2"
                            data-placeholder="Select..." data-allow-clear="true" data-hide-search="true"
                            id="overtime_value" name="overtime_value">
                            <option value="1">Select</option>
                            <option value="1.5">1.5 x</option>
                            <option value="2">2 x</option>
                            <option value="2.5">2.5 x</option>
                        </select>
                    </div>
                    @if($covid_marshal == 1)
                    <div class="fv-row mb-9">
                        <!--begin::Label-->
                        <!-- <label class="fs-6 fw-bold mb-2"></label> -->
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="form-check form-check-custom form-check-solid me-10">
                            <input class="form-check-input h-30px w-30px" type="checkbox" value="true"
                            id="covid_marshal" name="covid_marshal" />
                            <label class="form-check-label">
                                Covid Marshal
                            </label>
                        </div>
                        <!--end::Input-->
                    </div>
                    @endif
                    <div class="fv-row mb-9">
                        <!--begin::Label-->
                        <!-- <label class="fs-6 fw-bold mb-2"></label> -->
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="form-check form-check-custom form-check-solid me-10">
                            <input class="form-check-input h-30px w-30px" type="checkbox" value="true"
                            id="job-training" name="job-training" />
                            <label class="form-check-label" for="job-custom-rates">
                                Training
                            </label>
                        </div>
                        <!--end::Input-->
                    </div>
                    <div class="fv-row mb-9">
                        <!--begin::Label-->
                        <!-- <label class="fs-6 fw-bold mb-2"></label> -->
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="form-check form-check-custom form-check-solid me-10">
                            <input class="form-check-input h-30px w-30px" {{$continuation == 1 ? "checked" : ""}} type="checkbox" value="true"
                            id="job-continuation" name="job-continuation" />
                            <label class="form-check-label" for="job-continuation">
                                Continuation
                            </label>
                        </div>
                        <!--end::Input-->
                    </div>
                    @if(config('custom.own_payrates') == 0 && session()->get('userType') != 'customer')
                    <div class="fv-row mb-9">
                        <!--begin::Label-->
                        <!-- <label class="fs-6 fw-bold mb-2"></label> -->
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="form-check form-check-custom form-check-solid me-10">
                            <input class="form-check-input h-30px w-30px" type="checkbox" value="true"
                            id="job-custom-rates" name="job-custom-rates" />
                            <label class="form-check-label" for="job-custom-rates">
                                Custom Rates
                            </label>
                        </div>
                        <!--end::Input-->
                    </div>
                    @if(isset($settings['custom_payrates']) && $settings['custom_payrates'] == 1 && session()->get('userType') != 'customer')
                    <div class="fv-row mb-9 custom-rates-input-1" style="display: none">
                    <div class="form-check form-check-custom form-check-solid me-10">
                        <input class="form-check-input h-30px w-30px" type="checkbox" value="1" id="custom_payrate" name="custom_payrate"  {{isset($site_data) && $site_data->custom_payrate == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="custom_payrate">
                            Manual Custom Payrate
                        </label>
                    </div>
                    </div>

                    

                     <div class="own_payrates_div" style="display:{{isset($site_data) && $site_data->custom_payrate == 1 ? '' : 'none' }};">
        

           <!--  <div class="row rates-section">
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
                                        <input class="form-control form-control-md" name="flat_metro_week_day_day" type="number" step="any" value="{{isset($site_data) && isset($site_data->custom_rate['flat_metro_week_day_day']) ? $site_data->custom_rate['flat_metro_week_day_day'] : '0' }}">
                                    </div>
                                    <div class="rTableCell text-center">Mon-Fri(Day 06:00 - 18:00)</div>
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_rate['flat_regional_week_day_day']) ? $site_data->custom_rate['flat_regional_week_day_day'] : '0' }}" class="form-control form-control-md" name="flat_regional_week_day_day" type="number" step="any">
                                    </div>
                                </div>
                                <div class="rTableRow">
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_rate['flat_metro_week_day_night']) ? $site_data->custom_rate['flat_metro_week_day_night'] : '0' }}" class="form-control form-control-md" name="flat_metro_week_day_night" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Mon-Fri(Night 18:00 - 06:00)</div>
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_rate['flat_regional_week_day_night']) ? $site_data->custom_rate['flat_regional_week_day_night'] : '0' }}" class="form-control form-control-md" name="flat_regional_week_day_night" type="number" step="any">
                                    </div>
                                </div>  
                                <div class="rTableRow" style="display: none;">
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_rate['flat_metro_friday']) ? $site_data->custom_rate['flat_metro_friday'] : '0' }}" class="form-control form-control-md" name="flat_metro_friday" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Friday (00:01 till 23:59)</div>
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_rate['flat_regional_friday']) ? $site_data->custom_rate['flat_regional_friday'] : '0' }}" class="form-control form-control-md" name="flat_regional_friday" type="number" step="any">
                                    </div>
                                </div>
                                <div class="rTableRow">
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_rate['flat_metro_saturday']) ? $site_data->custom_rate['flat_metro_saturday'] : '0' }}" class="form-control form-control-md" name="flat_metro_saturday" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Saturday </div>
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_rate['flat_regional_saturday']) ? $site_data->custom_rate['flat_regional_saturday'] : '0' }}" class="form-control form-control-md" name="flat_regional_saturday" type="number" step="any">
                                    </div>
                                </div>
                                <div class="rTableRow" style="display:none;">
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_rate['flat_metro_saturday_night']) ? $site_data->custom_rate['flat_metro_saturday_night'] : '0' }}" class="form-control form-control-md" name="flat_metro_saturday_night" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Saturday (Night 18:00 - 06:00)</div>
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_rate['flat_regional_saturday_night']) ? $site_data->custom_rate['flat_regional_saturday_night'] : '0' }}" class="form-control form-control-md" name="flat_regional_saturday_night" type="number" step="any">
                                    </div>
                                </div>
                                <div class="rTableRow">
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_rate['flat_metro_sunday']) ? $site_data->custom_rate['flat_metro_sunday'] : '0' }}" class="form-control form-control-md" name="flat_metro_sunday" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Sunday </div>
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_rate['flat_regional_sunday']) ? $site_data->custom_rate['flat_regional_sunday'] : '0' }}" class="form-control form-control-md" name="flat_regional_sunday" type="number" step="any">
                                    </div>
                                </div>
                                <div class="rTableRow" style="display:none;">
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_rate['flat_metro_sunday_night']) ? $site_data->custom_rate['flat_metro_sunday_night'] : '0' }}" class="form-control form-control-md" name="flat_metro_sunday_night" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Sunday (Night 18:00 - 06:00)</div>
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_rate['flat_regional_sunday_night']) ? $site_data->custom_rate['flat_regional_sunday_night'] : '0' }}" class="form-control form-control-md" name="flat_regional_sunday_night" type="number" step="any">
                                    </div>
                                </div>

                                <div class="rTableRow">
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_rate['flat_metro_public_holiday']) ? $site_data->custom_rate['flat_metro_public_holiday'] : '0' }}" class="form-control form-control-md" name="flat_metro_public_holiday" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Public Holiday </div>
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_rate['flat_regional_public_holiday']) ? $site_data->custom_rate['flat_regional_public_holiday'] : '0' }}" class="form-control form-control-md" name="flat_regional_public_holiday" type="number" step="any">
                                    </div>
                                </div>
                                <div class="rTableRow" style="display:none;">
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_rate['flat_metro_public_holiday_night']) ? $site_data->custom_rate['flat_metro_public_holiday_night'] : '0' }}" class="form-control form-control-md" name="flat_metro_public_holiday_night" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Public Holiday (Night 18:00 - 06:00)</div>
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_rate['flat_regional_public_holiday_night']) ? $site_data->custom_rate['flat_regional_public_holiday_night'] : '0' }}" class="form-control form-control-md" name="flat_regional_public_holiday_night" type="number" step="any">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row rates-section" style="display: none;">
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
                                            <input value="{{isset($site_data) && isset($site_data->custom_rate['eba_metro_weekday_day']) ? $site_data->custom_rate['eba_metro_weekday_day'] : '0' }}" class="form-control form-control-md" name="eba_metro_weekday_day" type="number" step="any">
                                        </div>
                                        <div class="rTableCell text-center">Mon-Fri (Day 06:00-18:00)</div>
                                        <div class="rTableCell">
                                            <input value="{{isset($site_data) && isset($site_data->custom_rate['eba_regional_weekday_day']) ? $site_data->custom_rate['eba_regional_weekday_day'] : '0' }}" class="form-control form-control-md" name="eba_regional_weekday_day" type="number" step="any">
                                        </div>
                                    </div>

                                    <div class="rTableRow">
                                        <div class="rTableCell">
                                            <input value="{{isset($site_data) && isset($site_data->custom_rate['eba_metro_weekday_night']) ? $site_data->custom_rate['eba_metro_weekday_night'] : '0' }}" class="form-control form-control-md" name="eba_metro_weekday_night" type="number" step="any">
                                        </div>
                                        <div class="rTableCell text-center">Mon-Fri (Night 18:00-06:00)</div>
                                        <div class="rTableCell">
                                            <input value="{{isset($site_data) && isset($site_data->custom_rate['eba_regional_weekday_night']) ? $site_data->custom_rate['eba_regional_weekday_night'] : '0' }}" class="form-control form-control-md" name="eba_regional_weekday_night" type="number" step="any">
                                        </div>
                                    </div>
                                    <div class="rTableRow">
                                        <div class="rTableCell">
                                            <input value="{{isset($site_data) && isset($site_data->custom_rate['eba_metro_saturday_day']) ? $site_data->custom_rate['eba_metro_saturday_day'] : '0' }}" class="form-control form-control-md" name="eba_metro_saturday_day" type="number" step="any">
                                        </div>
                                        <div class="rTableCell text-center">Saturday (Day 06:00 till 18:00)</div>
                                        <div class="rTableCell">
                                            <input value="{{isset($site_data) && isset($site_data->custom_rate['eba_regional_saturday_day']) ? $site_data->custom_rate['eba_regional_saturday_day'] : '0' }}" class="form-control form-control-md" name="eba_regional_saturday_day" type="number" step="any">
                                        </div>
                                    </div>
                                    <div class="rTableRow">
                                        <div class="rTableCell">
                                            <input value="{{isset($site_data) && isset($site_data->custom_rate['eba_metro_saturday_night']) ? $site_data->custom_rate['eba_metro_saturday_night'] : '0' }}" class="form-control form-control-md" name="eba_metro_saturday_night" type="number" step="any">
                                        </div>
                                        <div class="rTableCell text-center">Saturday (Night 06:00 till 18:00)</div>
                                        <div class="rTableCell">
                                            <input value="{{isset($site_data) && isset($site_data->custom_rate['eba_regional_saturday_night']) ? $site_data->custom_rate['eba_regional_saturday_night'] : '0' }}" class="form-control form-control-md" name="eba_regional_saturday_night" type="number" step="any">
                                        </div>
                                    </div>
                                    <div class="rTableRow">
                                        <div class="rTableCell">
                                            <input value="{{isset($site_data) && isset($site_data->custom_rate['eba_metro_sunday_day']) ? $site_data->custom_rate['eba_metro_sunday_day'] : '0' }}" class="form-control form-control-md" name="eba_metro_sunday_day" type="number" step="any">
                                        </div>
                                        <div class="rTableCell text-center">Sunday (Day 06:00 till 18:00)</div>
                                        <div class="rTableCell">
                                            <input value="{{isset($site_data) && isset($site_data->custom_rate['eba_regional_sunday_day']) ? $site_data->custom_rate['eba_regional_sunday_day'] : '0' }}" class="form-control form-control-md" name="eba_regional_sunday_day" type="number" step="any">
                                        </div>
                                    </div>
                                    <div class="rTableRow">
                                        <div class="rTableCell">
                                            <input value="{{isset($site_data) && isset($site_data->custom_rate['eba_metro_sunday_night']) ? $site_data->custom_rate['eba_metro_sunday_night'] : '0' }}" class="form-control form-control-md" name="eba_metro_sunday_night" type="number" step="any">
                                        </div>
                                        <div class="rTableCell text-center">Sunday (Night 18:00 till 06:00)</div>
                                        <div class="rTableCell">
                                            <input value="{{isset($site_data) && isset($site_data->custom_rate['eba_regional_sunday_night']) ? $site_data->custom_rate['eba_regional_sunday_night'] : '0' }}" class="form-control form-control-md" name="eba_regional_sunday_night" type="number" step="any">
                                        </div>
                                    </div>
                                    <div class="rTableRow">
                                        <div class="rTableCell">
                                            <input value="{{isset($site_data) && isset($site_data->custom_rate['eba_metro_public_holiday']) ? $site_data->custom_rate['eba_metro_public_holiday'] : '0' }}" class="form-control form-control-md" name="eba_metro_public_holiday" type="number" step="any">
                                        </div>
                                        <div class="rTableCell text-center">Public Holiday (Day 06:00 till 18:00)</div>
                                        <div class="rTableCell">
                                            <input value="{{isset($site_data) && isset($site_data->custom_rate['eba_regional_public_holiday']) ? $site_data->custom_rate['eba_regional_public_holiday'] : '0' }}" class="form-control form-control-md" name="eba_regional_public_holiday" type="number" step="any">
                                        </div>
                                    </div>
                                    <div class="rTableRow">
                                        <div class="rTableCell">
                                            <input value="{{isset($site_data) && isset($site_data->custom_rate['eba_metro_public_holiday_night']) ? $site_data->custom_rate['eba_metro_public_holiday_night'] : '0' }}" class="form-control form-control-md" name="eba_metro_public_holiday_night" type="number" step="any">
                                        </div>
                                        <div class="rTableCell text-center">Public Holiday (Night 18:00 till 06:E00)</div>
                                        <div class="rTableCell">
                                            <input value="{{isset($site_data) && isset($site_data->custom_rate['eba_regional_public_holiday_night']) ? $site_data->custom_rate['eba_regional_public_holiday_night'] : '0' }}" class="form-control form-control-md" name="eba_regional_public_holiday_night" type="number" step="any">
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
                                            <input value="{{isset($site_data) && isset($site_data->custom_rate['award_metro_weekday_day']) ? $site_data->custom_rate['award_metro_weekday_day'] : '0' }}" class="form-control form-control-md" name="award_metro_weekday_day" type="number" step="any">
                                        </div>
                                        <div class="rTableCell text-center">Mon-Fri (Day 06:00-18:00)</div>
                                        <div class="rTableCell">
                                            <input value="{{isset($site_data) && isset($site_data->custom_rate['award_regional_weekday_day']) ? $site_data->custom_rate['award_regional_weekday_day'] : '0' }}" class="form-control form-control-md" name="award_regional_weekday_day" type="number" step="any">
                                        </div>
                                    </div>
                                    
                                    <div class="rTableRow">
                                        <div class="rTableCell">
                                            <input value="{{isset($site_data) && isset($site_data->custom_rate['award_metro_weekday_night']) ? $site_data->custom_rate['award_metro_weekday_night'] : '0' }}" class="form-control form-control-md" name="award_metro_weekday_night" type="number" step="any">
                                        </div>
                                        <div class="rTableCell text-center">Mon-Fri (Night 18:00-06:00)</div>
                                        <div class="rTableCell">
                                            <input value="{{isset($site_data) && isset($site_data->custom_rate['award_regional_weekday_night']) ? $site_data->custom_rate['award_regional_weekday_night'] : '0' }}" class="form-control form-control-md" name="award_regional_weekday_night" type="number" step="any">
                                        </div>
                                    </div>
                                    <div class="rTableRow">
                                        <div class="rTableCell">
                                            <input value="{{isset($site_data) && isset($site_data->custom_rate['award_metro_saturday_day']) ? $site_data->custom_rate['award_metro_saturday_day'] : '0' }}" class="form-control form-control-md" name="award_metro_saturday_day" type="number" step="any">
                                        </div>
                                        <div class="rTableCell text-center">Saturday (Day 06:00 till 18:00)</div>
                                        <div class="rTableCell">
                                            <input value="{{isset($site_data) && isset($site_data->custom_rate['award_regional_saturday_day']) ? $site_data->custom_rate['award_regional_saturday_day'] : '0' }}" class="form-control form-control-md" name="award_regional_saturday_day" type="number" step="any">
                                        </div>
                                    </div>
                                    <div class="rTableRow">
                                        <div class="rTableCell">
                                            <input value="{{isset($site_data) && isset($site_data->custom_rate['award_metro_saturday_night']) ? $site_data->custom_rate['award_metro_saturday_night'] : '0' }}" class="form-control form-control-md" name="award_metro_saturday_night" type="number" step="any">
                                        </div>
                                        <div class="rTableCell text-center">Saturday (Night 06:00 till 18:00)</div>
                                        <div class="rTableCell">
                                            <input value="{{isset($site_data) && isset($site_data->custom_rate['award_regional_saturday_night']) ? $site_data->custom_rate['award_regional_saturday_night'] : '0' }}" class="form-control form-control-md" name="award_regional_saturday_night" type="number" step="any">
                                        </div>
                                    </div>
                                    <div class="rTableRow">
                                        <div class="rTableCell">
                                            <input value="{{isset($site_data) && isset($site_data->custom_rate['award_metro_sunday_day']) ? $site_data->custom_rate['award_metro_sunday_day'] : '0' }}" class="form-control form-control-md" name="award_metro_sunday_day" type="number" step="any">
                                        </div>
                                        <div class="rTableCell text-center">Sunday (Day 06:00 till 18:00)</div>
                                        <div class="rTableCell">
                                            <input value="{{isset($site_data) && isset($site_data->custom_rate['award_regional_sunday_day']) ? $site_data->custom_rate['award_regional_sunday_day'] : '0' }}" class="form-control form-control-md" name="award_regional_sunday_day" type="number" step="any">
                                        </div>
                                    </div>
                                    <div class="rTableRow">
                                        <div class="rTableCell">
                                            <input value="{{isset($site_data) && isset($site_data->custom_rate['award_metro_sunday_night']) ? $site_data->custom_rate['award_metro_sunday_night'] : '0' }}" class="form-control form-control-md" name="award_metro_sunday_night" type="number" step="any">
                                        </div>
                                        <div class="rTableCell text-center">Sunday (Night 18:00 till 06:00)</div>
                                        <div class="rTableCell">
                                            <input value="{{isset($site_data) && isset($site_data->custom_rate['award_regional_sunday_night']) ? $site_data->custom_rate['award_regional_sunday_night'] : '0' }}" class="form-control form-control-md" name="award_regional_sunday_night" type="number" step="any">
                                        </div>
                                    </div>
                                    <div class="rTableRow">
                                        <div class="rTableCell">
                                            <input value="{{isset($site_data) && isset($site_data->custom_rate['award_metro_public_holiday']) ? $site_data->custom_rate['award_metro_public_holiday'] : '0' }}" class="form-control form-control-md" name="award_metro_public_holiday" type="number" step="any">
                                        </div>
                                        <div class="rTableCell text-center">Public Holiday (Day 06:00 till 18:00)</div>
                                        <div class="rTableCell">
                                            <input value="{{isset($site_data) && isset($site_data->custom_rate['award_regional_public_holiday']) ? $site_data->custom_rate['award_regional_public_holiday'] : '0' }}" class="form-control form-control-md" name="award_regional_public_holiday" type="number" step="any">
                                        </div>
                                    </div>
                                    <div class="rTableRow">
                                        <div class="rTableCell">
                                            <input value="{{isset($site_data) && isset($site_data->custom_rate['award_metro_public_holiday_night']) ? $site_data->custom_rate['award_metro_public_holiday_night'] : '0' }}" class="form-control form-control-md" name="award_metro_public_holiday_night" type="number" step="any">
                                        </div>
                                        <div class="rTableCell text-center">Public Holiday (Night 18:00 till 06:E00)</div>
                                        <div class="rTableCell">
                                            <input value="{{isset($site_data) && isset($site_data->custom_rate['award_regional_public_holiday_night']) ? $site_data->custom_rate['award_regional_public_holiday_night'] : '0' }}" class="form-control form-control-md" name="award_regional_public_holiday_night" type="number" step="any">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
    </div>
@if(session()->has('isAdmin') && session()->has('isAdmin') == 1 && session()->get('userType') != 'customer')
    <div class="fv-row mb-9 custom-rates-input-1" style="display: none">
                    <div class="form-check form-check-custom form-check-solid me-10">
                        <input class="form-check-input h-30px w-30px" type="checkbox" value="1" id="custom_chargerate" name="custom_chargerate">
                        <label class="form-check-label" for="custom_chargerate">
                            Manual Custom Chargerate
                        </label>
                    </div>
                    </div>

                     <div class="own_chargerate_div" style="display:{{(isset($site_data) && $site_data->custom_chargerate == 1 && session()->has('isAdmin') && session()->has('isAdmin') == 1 ) ? '' : 'none' }};">
            
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
                                        <input class="form-control form-control-md" name="charge_rate_flat_metro_week_day_day" type="number" step="any" value="{{isset($site_data) && isset($site_data->custom_charge_rate['flat_metro_week_day_day']) ? $site_data->custom_charge_rate['flat_metro_week_day_day'] : '0' }}">
                                    </div>
                                    <div class="rTableCell text-center">Mon-Fri(Day 06:00 - 18:00)</div>
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_charge_rate['flat_regional_week_day_day']) ? $site_data->custom_charge_rate['flat_regional_week_day_day'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_regional_week_day_day" type="number" step="any">
                                    </div>
                                </div>
                                <div class="rTableRow">
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_charge_rate['flat_metro_week_day_night']) ? $site_data->custom_charge_rate['flat_metro_week_day_night'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_metro_week_day_night" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Mon-Fri(Night 18:00 - 06:00)</div>
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_charge_rate['flat_regional_week_day_night']) ? $site_data->custom_charge_rate['flat_regional_week_day_night'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_regional_week_day_night" type="number" step="any">
                                    </div>
                                </div>  
                                <div class="rTableRow" style="display: none;">
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_charge_rate['flat_metro_friday']) ? $site_data->custom_charge_rate['flat_metro_friday'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_metro_friday" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Friday (00:01 till 23:59)</div>
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_charge_rate['flat_regional_friday']) ? $site_data->custom_charge_rate['flat_regional_friday'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_regional_friday" type="number" step="any">
                                    </div>
                                </div>
                                <div class="rTableRow">
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_charge_rate['flat_metro_saturday']) ? $site_data->custom_charge_rate['flat_metro_saturday'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_metro_saturday" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Saturday</div>
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_charge_rate['flat_regional_saturday']) ? $site_data->custom_charge_rate['flat_regional_saturday'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_regional_saturday" type="number" step="any">
                                    </div>
                                </div>
                                <div class="rTableRow" style="display:none;">
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_charge_rate['flat_metro_saturday_night']) ? $site_data->custom_charge_rate['flat_metro_saturday_night'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_metro_saturday_night" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Saturday (Night 18:00 - 06:00)</div>
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_charge_rate['flat_regional_saturday_night']) ? $site_data->custom_charge_rate['flat_regional_saturday_night'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_regional_saturday_night" type="number" step="any">
                                    </div>
                                </div>
                                <div class="rTableRow">
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_charge_rate['flat_metro_sunday']) ? $site_data->custom_charge_rate['flat_metro_sunday'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_metro_sunday" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Sunday </div>
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_charge_rate['flat_regional_sunday']) ? $site_data->custom_charge_rate['flat_regional_sunday'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_regional_sunday" type="number" step="any">
                                    </div>
                                </div>
                                <div class="rTableRow" style="display:none;">
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_charge_rate['flat_metro_sunday_night']) ? $site_data->custom_charge_rate['flat_metro_sunday_night'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_metro_sunday_night" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Sunday (Night 18:00 - 06:00)</div>
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_charge_rate['flat_regional_sunday_night']) ? $site_data->custom_charge_rate['flat_regional_sunday_night'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_regional_sunday_night" type="number" step="any">
                                    </div>
                                </div>

                                <div class="rTableRow">
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_charge_rate['flat_metro_public_holiday']) ? $site_data->custom_charge_rate['flat_metro_public_holiday'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_metro_public_holiday" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Public Holiday </div>
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_charge_rate['flat_regional_public_holiday']) ? $site_data->custom_charge_rate['flat_regional_public_holiday'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_regional_public_holiday" type="number" step="any">
                                    </div>
                                </div>
                                <div class="rTableRow" style="display:none;">
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_charge_rate['flat_metro_public_holiday_night']) ? $site_data->custom_charge_rate['flat_metro_public_holiday_night'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_metro_public_holiday_night" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Public Holiday (Night 18:00 - 06:00)</div>
                                    <div class="rTableCell">
                                        <input value="{{isset($site_data) && isset($site_data->custom_charge_rate['flat_regional_public_holiday_night']) ? $site_data->custom_charge_rate['flat_regional_public_holiday_night'] : '0' }}" class="form-control form-control-md" name="charge_rate_flat_regional_public_holiday_night" type="number" step="any">
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
                    <div class="fv-row mb-9 custom-rates-input" style="display: none">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold required mb-2">Payrates Level</label>
                        <!--end::Label-->
                        <select class="form-select form-select-lg form-select-solid" data-control="select2"
                        data-placeholder="Select..." data-allow-clear="true" data-hide-search="true"
                        id="job-payrate-level" name="job-payrate-level"
                        onchange="getPayChargeRate('payrate', 'job-payrate-level')">
                        <option value="">Select payrate level</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
                <div class="fv-row mb-9 custom-rates-input" style="display: none">
                    <!--begin::Label-->
                    <label class="fs-6 fw-bold required mb-2">Payrates</label>
                    <!--end::Label-->
                    <select class="form-select form-select-lg form-select-solid" data-control="select2"
                    data-placeholder="Select..." data-allow-clear="true" data-hide-search="true"
                    id="job-payrate-id" name="job-payrate-id">
                    <option value="">Select payrate</option>

                    @foreach ($payrates as $payrate)
                    <option value="{{ $payrate->id }}">{{ $payrate->title }}</option>
                    @endforeach
                </select>
            </div>
            @if (isset($item->charge_rates_and_level) && $item->charge_rates_and_level == 1)
            <div class="fv-row mb-9 custom-rates-input" style="display: none">
                <!--begin::Label-->
                <label class="fs-6 fw-bold required mb-2">Chargerates Level</label>
                <!--end::Label-->
                <select class="form-select form-select-lg form-select-solid"
                data-control="select2" data-placeholder="Select..." data-allow-clear="true"
                data-hide-search="true" id="job-chargerate-level" name="job-chargerate-level"
                onchange="getPayChargeRate('chargerate', 'job-chargerate-level')">
                <option value="">Select chargerate level</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>
        <div class="fv-row mb-9 custom-rates-input" style="display: none">
            <!--begin::Label-->
            <label class="fs-6 fw-bold required mb-2">Chargerates</label>
            <!--end::Label-->
            <select class="form-select form-select-lg form-select-solid"
            data-control="select2" data-placeholder="Select..." data-allow-clear="true"
            data-hide-search="true" id="job-chargerate-id" name="job-chargerate-id">
            <option value="">Select chargerate</option>

            @foreach ($charged_rates as $charged_rate)
            <option value="{{ $charged_rate->id }}">{{ $charged_rate->title }}
            </option>
            @endforeach
        </select>
    </div>
    @endif
    @else
    <div class="fv-row mb-9 custom-rates-input">
        <!--begin::Label-->
        <label class="fs-6 fw-bold required mb-2">Payrate</label>
        <!--end::Label-->
        <select class="form-select form-select-lg form-select-solid"
        data-control="select2" data-placeholder="Select..." data-allow-clear="true"
        data-hide-search="true" id="own_payrate" name="own_payrate">
        <option value="">Select</option>
        <option value="eba">EBA</option>
        <option value="award">Award</option>
        <option value="abn">Default/ABN</option>
        <!-- <option value="custom">Custom</option> -->
    </select>
</div>
<div class="fv-row mb-9 custom-rates-selection" style="display:none;">
        <!--begin::Label-->
        <label class="fs-6 fw-bold required mb-2">Select Payrate</label>
        <!--end::Label-->
        <select class="form-select form-select-lg form-select-solid"
        data-control="select2" data-placeholder="Select..." data-allow-clear="true"
        data-hide-search="true" id="payrate_id" name="payrate_id">
        <option value="">Select</option>
    </select>
</div>
<div class="fv-row mb-9 custom-rate" style="display: none;">
    <label class="fs-6 fw-bold required mb-2">Mon-Fri(Day 06:00 - 18:00)</label>
    <!--end::Label-->
    <input type="number" class="form-control form-control-solid" placeholder="" name="custom_payrate[flat_metro_week_day_day]" id="flat_metro_week_day_day" step="any" />
</div>
<div class="fv-row mb-9 custom-rate" style="display: none;">
    <label class="fs-6 fw-bold required mb-2">Mon-Fri(Night 18:00 - 06:00)</label>
    <!--end::Label-->
    <input type="number" class="form-control form-control-solid" placeholder="" name="custom_payrate[flat_metro_week_day_night]" id="flat_metro_week_day_night" step="any" />
</div>
<div class="fv-row mb-9 custom-rate" style="display: none;">
    <label class="fs-6 fw-bold required mb-2">Saturday (Day 06:00 - 18:00)</label>
    <!--end::Label-->
    <input type="number" class="form-control form-control-solid" placeholder="" name="custom_payrate[flat_metro_saturday]" id="flat_metro_saturday" step="any" />
</div>
<div class="fv-row mb-9 custom-rate" style="display: none;">
    <label class="fs-6 fw-bold required mb-2">Saturday (Night 18:00 - 06:00)</label>
    <!--end::Label-->
    <input type="number" class="form-control form-control-solid" placeholder="" name="custom_payrate[flat_metro_saturday_night]" id="flat_metro_saturday_night" step="any" />
</div>
<div class="fv-row mb-9 custom-rate" style="display: none;">
    <label class="fs-6 fw-bold required mb-2">Sunday (Day 06:00 - 18:00)</label>
    <!--end::Label-->
    <input type="number" class="form-control form-control-solid" placeholder="" name="custom_payrate[flat_metro_sunday]" id="flat_metro_sunday" step="any" />
</div>
<div class="fv-row mb-9 custom-rate" style="display: none;">
    <label class="fs-6 fw-bold required mb-2">Sunday (Night 18:00 - 06:00)</label>
    <!--end::Label-->
    <input type="number" class="form-control form-control-solid" placeholder="" name="custom_payrate[flat_metro_sunday_night]" id="flat_metro_sunday_night" step="any" />
</div>
<div class="fv-row mb-9 custom-rate" style="display: none;">
    <label class="fs-6 fw-bold required mb-2">Public Holiday (Day 06:00 - 18:00)</label>
    <!--end::Label-->
    <input type="number" class="form-control form-control-solid" placeholder="" name="custom_payrate[flat_metro_public_holiday]" id="flat_metro_public_holiday" step="any" />
</div>
<div class="fv-row mb-9 custom-rate" style="display: none;">
    <label class="fs-6 fw-bold required mb-2">Public Holiday (Night 18:00 - 06:00)</label>
    <!--end::Label-->
    <input type="number" class="form-control form-control-solid" placeholder="" name="custom_payrate[flat_metro_public_holiday_night]" id="flat_metro_public_holiday_night" step="any" />
</div>
@endif
@endif

<!-- end -->
</div>
<div class="tab-pane fade" id="shift_tasks" role="tabpanel">
    <input type="hidden" name="task_counter" id="task_counter"
    value="{{ $site_specific_tasks != 'invalid' && $site_specific_tasks != null && $site_specific_tasks != '[]' && !empty(json_decode($site_specific_tasks, true)) ? count(json_decode($site_specific_tasks, true)) : 0 }}">
    <div class="row" id="tasks-inputs">
        <?php if($site_specific_tasks != "invalid" && $site_specific_tasks != ''){
            $tasks = json_decode($site_specific_tasks,true);
            foreach ( $tasks as $key => $task ){
                ?>
                <div class="col-md-4 form-group task-counter-{{ $key }}"><label
                    for="recipient-name" class="col-form-label">Task Time</label><input
                    type="text" class="form-control form-control-md"
                    name="task-start-time-{{ $key }}"
                    id="task-start-time-{{ $key }}"></div>
                    <div class="col-md-8 task-counter-{{ $key }} form-group"><label
                        for="recipient-name" class="col-form-label">Description</label>
                        <div class="row">
                            <div class="col-md-10 ">
                                <textarea class="form-control form-control-md" name="task-description-0" id="task-description-{{ $key }}"
                                rows="1">{{ $task }}</textarea>
                            </div>
                            <div class="col-md-2"><a class="btn-danger btn" id="add-task-inputs"
                                onclick="delete_task_inputs{{ $key }}"
                                style="display: inline-block;height: 30px;padding: 2px 10px;"><i
                                class="fas fa-trash fs-1x"
                                style="padding: 0px;margin: 0px;font-size: 16px;"></i></a></div>
                            </div>
                        </div>

                        <?php	
                    }
                }
                ?>
            </div>
            <div class="row mt-4">
                <div class="col-sm-12 col-md-12 text-center">
                    <button type="button" class="btn btn-success" style="border-radius: 25px;"
                    onclick="addTasks()">+ Add new task</button>
                </div>
            </div>
        </div>
        <div class="tab-pane " id="shift_activity" role="tabpanel">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <h5>No activity yet </h5>
                </div>
            </div>
        </div>
    </div>
    <!--begin::Demo-->




    <!--end::Demo-->
</div>
<!--end::Demos-->
</div>
<!--end::Content-->
</div>
<!--end::Body-->
<!--begin::Footer-->
@if (isset($item->create_shift_button) && $item->create_shift_button == 1)
<div class="card-footer py-5 text-center" id="kt_explore_footer">
    <button type="submit" class="btn btn-action" id="saveEventFormBtn">Save</button>
    <button type="submit" class="btn btn-primary btn-action"
    id="saveEventFormBtnPublish">Publish</button>
</div>
@else
<div class="card-footer py-5 text-center" id="kt_explore_footer">
    <button type="submit" class="btn btn-primary btn-action"
    id="saveEventFormBtnPublish">Save</button>
</div>

@endif

<!--end::Footer-->
</form>

@endif


<script type="text/javascript">
    $(document).ready(function() {
    

        var task_counter = $('#task_counter').val();
        console.log("task counter", task_counter);
        for (var i = 0; i < task_counter; i++) {
            initialize_time_input('#task-start-time-' + i);
        }
    });

    var submitted_roster_data_global = [];
    $('.date-time').flatpickr({
        enableTime: !0,
        dateFormat: "Y-m-d H:i",
        defaultDate: '{{ $start }}'
    });
    $('.time-picker').flatpickr({
        noCalendar: true,
        enableTime: true,
        dateFormat: 'H:i',
        defaultDate: '00:00',
        time_24hr: true,

    });
    $('#eventSiteId').on('change', function() {
        var jobId = $(this).val();
        loadSiteGaurds(jobId);

    });

    function loadSiteGaurds(jobId, guardId = null) {
        $.ajax({
            url: base_url + "/guard/getGuards",
            type: "post",
            dataType: "json",
            data: {
                jobId: jobId,
                _token: token
            },
            success: function(result) {
                var options = '<option value="">Select {{config("custom.guard")}}</option>';
                $.each(result, function(mindex, mvalue) {
                    var selected = '';
                    if (guardId != null) {
                        if (mvalue.id == guardId) {
                            selected = 'selected';
                        }
                    }
                    options += '<option value="' + mvalue.id + '" ' + selected + '>' + mvalue.name +
                    '</option>';
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

    $('#saveEventFormBtnPublish').on('click', function() {
        // $('#saveEventForm').submit();
        // alert('hiii');
        submitForm(1);
    })
    $('#saveEventFormBtn').on('click', function() {
        // $('#saveEventForm').submit();
        submitForm(0);
    })

    function task_cal() {
        var tasks = [];
        var task_counter = $('#task_counter').val();

        for (var i = 0; i <= task_counter; i++) {
            var task_start_time = $('#task-start-time-' + i).val();
            var task_description = $('#task-description-' + i).val();
            if (task_start_time != '' && task_description != '' && task_start_time != undefined) {
                tasks.push({
                    task_start_time: task_start_time,
                    task_description: task_description
                })
            }
        }
        return tasks;
    }

    function submitForm(publish_status = 0) {
        var own_payrate = "{{config('custom.own_payrates')}}";
        var default_start = $('#default_start').val();
        var start_time = $('#event_start_time').val();
        var end_time = $('#event_end_time').val();
        var start_temp = start_time.replace(':', '.') * 1;
        var end_temp = end_time.replace(':', '.') * 1;
        if (end_temp == 0) {
         Swal.fire({
            text: 'Please enter valid end time!',
            icon: "error",
            buttonsStyling: !1,
            confirmButtonText: "Ok, got it!",
            customClass: {
                confirmButton: "btn btn-light"
            }
        });
       //     return;
     }
        // alert(end_time);
        // return;
     if (end_temp < start_temp) {
        var startDate = new Date(default_start);
        default_start = new Date(startDate.setDate(startDate.getDate() + 1));
        default_start = moment(default_start).format('YYYY-MM-DD');
                // console.log(default_start)
        $('#event_ends').val(default_start + ' ' + end_time)
    }

    var start_date = $('#event_starts').val();
    var start_date = moment(start_date).format('YYYY-MM-DDTHH:mm:ssZ');
    var temp_start = moment(start_date).format('YYYY-MM-DD HH:mm');
    var tempDate = moment(start_date).format('YYYY-MM-DD');
    var end_date = $('#event_ends').val();
    var eventId = $("#eventeventId").val();
    var siteId = $('select[name="eventSiteId"]').val();
    var guardId = $("#eventguardId").val();
    var startStatus = $("#eventstartStatus").val();
    var tasks = task_cal();
    var payable = $('input[name="job-payable"]:checked').val();
    var chargeable = $('input[name="job-chargeable"]:checked').val();
    if (own_payrate == '1') {
    var payrate_id = $("#payrate_id").val();

    }else{
    var payrate_id = $("#job-payrate-id").val();
    }
    var chargerate_id = $("#job-chargerate-id").val();
    var travel_time = $('#job-travel-time').val();
    var paid_by = $('#job-paid-by').val();
    var travel_time_payable = $('input[name="travel_time_payable"]:checked').val();
    var travel_time_chargeable = $('input[name="travel_time_chargeable"]:checked').val();
        // var overtime = $('input[name="overtime"]:checked').val();
    var travel_time_amount_chargeable = $('#travel_time_amount_chargeable').val();
    var travel_time_amount = $('#travel_time_amount').val();
    var moke_guard = $('#moke_guard').val();
    var overtime_value = $('#overtime_value').val();
    var unpublish_shift = $('input[name="unpublish_shift"]:checked').val();
    var break_enabled = $('input[name="break_enabled"]:checked').val();
    var break_deduction_time = $('#break_deduction_time').val();
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
    var own_payrate = $('#own_payrate').val();

    var custom_rates = 'no';
    if ($('#job-custom-rates').prop('checked') == true) {
        custom_rates = 'yes';
    } else {
        custom_rates = 'no';
    }

    var manual_custom_payrate = 0;
    if ($('#custom_payrate').prop('checked') == true) {
        manual_custom_payrate = 1;
    }

    var custom_chargerate = 0;
    if ($('#custom_chargerate').prop('checked') == true) {
        custom_chargerate = 1;
    }
    var training = 0;
    if ($('#job-training').prop('checked') == true) {
        training = 1;
    } else {
        training = 0;
    }
    var public_holiday = 0;
    var ph_duration = $('input[name="ph_duration"]:checked').val();
    if ($('#public_holiday').prop('checked') == true) {
        public_holiday = 1;
    } else {
        public_holiday = 0;
    }
    var continuation = 0;
    if ($('#job-continuation').prop('checked') == true) {
        continuation = 1;
    } else {
        continuation = 0;
    }
    var covid_marshal = 0;
    if ($('#covid_marshal').prop('checked') == true) {
        covid_marshal = 1;
    } else {
        covid_marshal = 0;
    }

    var overtime = 0;
    if ($('#overtime').prop('checked') == true) {
        overtime = 1;
    } else {
        overtime = 0;
    }
    var  pw_order = $('#pw_order').val();
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
            // return;
    }
        //$('.saveBtn').prop( "disabled", true );
    submitted_roster_data_global = {
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
            // tasks: tasks,
        publish_status: publish_status,
        payable: payable,
        chargeable: chargeable,
        custom_rates: custom_rates,
        payrate_id: payrate_id,
        chargerate_id: chargerate_id,
        training: training,
        continuation: continuation,
        travel_time: travel_time,
        paid_by: paid_by,
        public_holiday: public_holiday,
        travel_time_payable: travel_time_payable,
        travel_time_chargeable: travel_time_chargeable,
        covid_marshal: covid_marshal,
        overtime: overtime,
        travel_time_amount: travel_time_amount,
        travel_time_amount_chargeable: travel_time_amount_chargeable,
        moke_guard: moke_guard,
        overtime_value: overtime_value,
        unpublish_shift: unpublish_shift,
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
    $.each(submitted_roster_data_global, function(key, input) {
        form_data.append(key, input);
    });
    form_data.append('tasks', JSON.stringify(tasks));

    form_data.append('instructions_file', $('input#instructions_file')[0].files[0]);
        // form_data.append(submitted_roster_data_global)
        // console.log(submitted_roster_data_global)
        // return;
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
                    text: 'Roaster updated successfully.',
                    icon: "success",
                    buttonsStyling: !1,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-light"
                    }
                })
                    // message_alert("");
                renderCalendar(0, $('#userType').val())
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
                @if(session()->get('userType') == 'customer')
                Swal.fire({
                    text: result.message,
                    icon: "error",
                    buttonsStyling: !1,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-light"
                    }
                });
                return;
                @else
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
                        // Swal.fire({
                        //     text: result.message,
                        //     icon: "error",
                        //     buttonsStyling: !1,
                        //     confirmButtonText: "Ok, got it!",
                        //     customClass: {
                        //         confirmButton: "btn btn-light"
                        //     }
                        // });
                    bypass_job();

                        // confirm_from_super_admin(result.message);
                }
                return;
                @endif

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

function addTasks() {
    var task_counter = $('#task_counter').val();
        // if (day_counter < 6) {
    var html = '<div class="col-md-4 form-group task-counter-' + task_counter +
    '"><label for="recipient-name" class="col-form-label">Task Time</label><input type="text" class="form-control form-control-md" name="task-start-time-' +
    task_counter + '" id="task-start-time-' + task_counter + '"></div><div class="col-md-8 task-counter-' +
    task_counter +
    ' form-group"><label for="recipient-name" class="col-form-label">Description</label><div class="row"><div class="col-md-10 "><textarea class="form-control form-control-md" name="task-description-0" id="task-description-' +
    task_counter +
    '" rows="1"></textarea></div><div class="col-md-2"><a class="btn-danger btn" id="add-task-inputs" onclick="delete_task_inputs(' +
    task_counter +
    ')" style="display: inline-block;height: 30px;padding: 2px 10px;"><i class="fas fa-trash fs-1x" style="padding: 0px;margin: 0px;font-size: 16px;"></i></a></div></div></div>';
    $('#tasks-inputs').append(html);
    initialize_time_input('#task-start-time-' + task_counter);
    task_counter++;
    $('#task_counter').val(task_counter);
        // initialize_time_input('#shift-end-time-'+day_counter);
        // }
}

function initialize_time_input(id) {
    $(id).flatpickr({
        enableTime: true,
        time_24hr: true,
        noCalendar: true,
        dateFormat: "H:i",
    });


}

function delete_task_inputs(index, id = null) {


    if (id != null) {
        $.ajax({
            url: base_url + "/guard/deleteTask",
            type: "post",
            dataType: "json",
            data: {
                task_id: id,
                _token: token
            },
            success: function(result) {
                $('.task-counter-' + index).remove();
            }

        });
    } else {
        $('.task-counter-' + index).remove();
    }
}
$('#job-custom-rates').on('change', function() {
    if ($(this).prop('checked') == true) {
        $('.custom-rates-input').css('display', '');
        $('.custom-rates-input-1').css('display', '');
    } else {
        $('.custom-rates-input').css('display', 'none');
        $('.custom-rates-input-1').css('display', 'none');
    }
});
$('input[type=radio][name=job-payable]').on('change', function() {
    console.log($(this).val())
    if ($(this).val() == 'no') {
        $('#paid-by-div').css('display', 'none');
    } else {
        $('#paid-by-div').css('display', '');
    }
});
$('#overtime').on('change', function() {
    if ($(this).prop('checked') == true) {
        $('.overtime-value-div').css('display', '');
    } else {
        $('.overtime-value-div').css('display', 'none');
    }
});

function check_availibilty(publish_status = 0) {
    var default_start = $('#default_start').val();
    var start_time = $('#event_start_time').val();
    var end_time = $('#event_end_time').val();
    var start_temp = start_time.replace(':', '.') * 1;
    var end_temp = end_time.replace(':', '.') * 1;
    if (end_temp == 0) {
     Swal.fire({
        text: 'Please enter valid end time!',
        icon: "error",
        buttonsStyling: !1,
        confirmButtonText: "Ok, got it!",
        customClass: {
            confirmButton: "btn btn-light"
        }
    });
       //     return;
 }
        // alert(end_time);
        // return;
 if (end_temp < start_temp) {
    var startDate = new Date(default_start);
    default_start = new Date(startDate.setDate(startDate.getDate() + 1));
    default_start = moment(default_start).format('YYYY-MM-DD');
                // console.log(default_start)
    $('#event_ends').val(default_start + ' ' + end_time)
}

var start_date = $('#event_starts').val();
var start_date = moment(start_date).format('YYYY-MM-DDTHH:mm:ssZ');
var temp_start = moment(start_date).format('YYYY-MM-DD HH:mm');
var tempDate = moment(start_date).format('YYYY-MM-DD');
var end_date = $('#event_ends').val();
var eventId = $("#eventeventId").val();
var siteId = $('select[name="eventSiteId"]').val();
var guardId = $("#eventguardId").val();
var startStatus = $("#eventstartStatus").val();
var tasks = task_cal();
var payable = $('input[name="job-payable"]:checked').val();
var chargeable = $('input[name="job-chargeable"]:checked').val();
var payrate_id = $("#job-payrate-id").val();
var chargerate_id = $("#job-chargerate-id").val();
var travel_time = $('#job-travel-time').val();
var paid_by = $('#job-paid-by').val();
var travel_time_payable = $('input[name="travel_time_payable"]:checked').val();
var travel_time_chargeable = $('input[name="travel_time_chargeable"]:checked').val();
        // var overtime = $('input[name="overtime"]:checked').val();
var travel_time_amount_chargeable = $('#travel_time_amount_chargeable').val();
var travel_time_amount = $('#travel_time_amount').val();
var moke_guard = $('#moke_guard').val();
var overtime_value = $('#overtime_value').val();
var unpublish_shift = $('input[name="unpublish_shift"]:checked').val();
var break_enabled = $('input[name="break_enabled"]:checked').val();
var break_deduction_time = $('#break_deduction_time').val();
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
var own_payrate = $('#own_payrate').val();

var custom_rates = 'no';
if ($('#job-custom-rates').prop('checked') == true) {
    custom_rates = 'yes';
} else {
    custom_rates = 'no';
}
var training = 0;
if ($('#job-training').prop('checked') == true) {
    training = 1;
} else {
    training = 0;
}
var public_holiday = 0;
var ph_duration = $('input[name="ph_duration"]:checked').val();
if ($('#public_holiday').prop('checked') == true) {
    public_holiday = 1;
} else {
    public_holiday = 0;
}
var continuation = 0;
if ($('#job-continuation').prop('checked') == true) {
    continuation = 1;
} else {
    continuation = 0;
}
var covid_marshal = 0;
if ($('#covid_marshal').prop('checked') == true) {
    covid_marshal = 1;
} else {
    covid_marshal = 0;
}

var overtime = 0;
if ($('#overtime').prop('checked') == true) {
    overtime = 1;
} else {
    overtime = 0;
}


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
            // return;
}
        //$('.saveBtn').prop( "disabled", true );
submitted_roster_data_global = {
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
            // tasks: tasks,
    publish_status: publish_status,
    payable: payable,
    chargeable: chargeable,
    custom_rates: custom_rates,
    payrate_id: payrate_id,
    chargerate_id: chargerate_id,
    training: training,
    continuation: continuation,
    travel_time: travel_time,
    paid_by: paid_by,
    public_holiday: public_holiday,
    travel_time_payable: travel_time_payable,
    travel_time_chargeable: travel_time_chargeable,
    covid_marshal: covid_marshal,
    overtime: overtime,
    travel_time_amount: travel_time_amount,
    travel_time_amount_chargeable: travel_time_amount_chargeable,
    moke_guard: moke_guard,
    overtime_value: overtime_value,
    unpublish_shift: unpublish_shift,
    break_enabled : break_enabled,
    break_deduction_time : break_deduction_time,
    custom_payrate : JSON.stringify(custom_payrate),
    own_payrate : own_payrate,
    ph_duration : ph_duration,
    by_pass : true
};
$.each(submitted_roster_data_global, function(key, input) {
    form_data.append(key, input);
});
form_data.append('tasks', JSON.stringify(tasks));

form_data.append('instructions_file', $('input#instructions_file')[0].files[0]);
$.ajax({
    url: base_url + "/guard/checkAvailability",
    type: "post",
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
                text: 'Roaster updated successfully.',
                icon: "success",
                buttonsStyling: !1,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn btn-light"
                }
            })
                    // message_alert("");
            renderCalendar(0, $('#userType').val())
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

function tt_payable_chargeable() {
    var tt = $('#job-travel-time').val();
    console.log(tt)
    if (tt == 0 || tt == '') {
        if (tt == 0) {
            $('#travel_time_amount_div').css('display', '');
        } else {
            $('#travel_time_amount_div').css('display', 'none');
        }
        $('.tt_payable_chargeable').css('display', 'none');
    } else {
        $('.tt_payable_chargeable').css('display', '');
    }
}

function setDateTimeFormat(type) {
    var default_start = $('#default_start').val();
    if (type == 'start') {
        var start_time = $('#event_start_time').val();
        $('#event_starts').val(default_start + ' ' + start_time)
    } else {
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
        $('#event_ends').val(default_start + ' ' + end_time)
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
$('#own_payrate').on('change', function(){
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
    }
    // if ($(this).val() == 'custom') {
    //     $('.custom-rate').css('display', '');
    // }else{
    //     $('.custom-rate').css('display', 'none');
    // }
});
$('#public_holiday').on('change', function() {
    if ($(this).prop('checked') == true) {
        $('#public_holiday_div').css('display', '');
    } else {
        $('#public_holiday_div').css('display', 'none');
    }
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
