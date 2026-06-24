@section('pay-rates')
<?php
$progress = 0;
$payrate_data = [];
if (isset($guard_data['guard_payrate']) && !empty($guard_data['guard_payrate'])) {
    $progress += 100;
    $payrate_data = $guard_data['guard_payrate']->payrate;
}
?>
@if (session()->get('userType') == 'admin')
<div class="col-md-4">
    <!--begin::Card-->
    <div class="card card-flush h-md-100">
        <!--begin::Card header-->
        <div class="card-header">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>Pay Rates</h2>
            </div>
            <!--end::Card title-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-1">
            <!--begin::Users-->
            <!-- <div class="fw-bolder text-gray-600 mb-5">Total features with this role</div> -->
            <!--end::Users-->
            <!--begin::Permissions-->
            <div class="d-flex flex-column text-gray-600">


                <div class="d-flex flex-column w-100 me-2">
                    <div class="d-flex flex-stack mb-2">
                        <span class="text-muted me-2 fs-7 fw-bold">{{ $progress }}%</span>
                    </div>
                    <div class="progress h-6px w-100">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $progress }}%"
                        aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

                        <!-- <div class="d-flex align-items-center py-2">
                <span class="bullet bg-primary me-3"></span>Enabled Bulk Reports</div>
                <div class="d-flex align-items-center py-2">
                <span class="bullet bg-primary me-3"></span>View and Edit Payouts</div>
                <div class="d-flex align-items-center py-2">
                <span class="bullet bg-primary me-3"></span>View and Edit Disputes</div>
                <div class='d-flex align-items-center py-2'>
                 <span class='bullet bg-primary me-3'></span>
                 <em>and 7 more...</em>
             </div> -->
         </div>
         <!--end::Permissions-->
     </div>
     <!--end::Card body-->
     <!--begin::Card footer-->
     <div class="card-footer flex-wrap pt-0">
        <button type="button" class="btn btn-white btn-active-light-primary my-1" data-bs-toggle="modal" data-bs-target="#pay-rates-modal1" id="pay-rates-modal-btn">Open Pay Rates</button>
    </div>
    <!--end::Card footer-->
</div>
<!--end::Card-->
</div>






<!-- modal  -->















<div class="modal fade" id="pay-rates-modal" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-750px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder" id="form_head">Pay Rates</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                aria-label="Close">

                <span class="svg-icon svg-icon-2x">X</span>
            </div>
            <!--end::Close-->
        </div>
        <!--end::Modal header-->
        <!--begin::Modal body-->
        <div class="modal-body scroll-y mx-5 my-7">
            <!--begin::Form-->

            <form id="pay-rates-form" class="form" action="{{ url('guard/save_guard_own_payrates') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="guard_id" value="{{ $guard_id }}">
            <div class="row mb-5">
                <div class="col-6">
                    <div class="form-check form-check-custom form-check-solid me-10">
                        <input class="form-check-input h-30px w-30px" type="radio" value="eba" id="pay_by" name="pay_by"  {{$guard_data['guard']->pay_by == 'eba' ? 'checked' : ''}}>
                        <label class="form-check-label" for="pay_by">
                            EBA
                        </label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-check form-check-custom form-check-solid me-10">
                        <input class="form-check-input h-30px w-30px" type="radio" value="award" id="pay_by" name="pay_by" {{$guard_data['guard']->pay_by == 'award' ? 'checked' : ''}}>
                        <label class="form-check-label" for="pay_by">
                            Award
                        </label>
                    </div>
                </div>
            </div>
            <div class="row award-payrates" style="display: {{$guard_data['guard']->pay_by == 'award' ? '' : 'none'}};">
                <div class="col-4 form-group award-payrates">
                    <div class="fv-row mb-10">
                        <label for="recipient-name" class="col-form-label">Award Rate Level</label>
                        <select class="form-select form-select-lg form-select-solid"
                        data-placeholder="Select..." data-allow-clear="true" data-hide-search="true"
                        name="award_rate_level" id="award_rate_level" >
                        <option value="">Select</option>
                        <option value="1" {{$guard_data['guard']->award_rate_level == 1 ? 'selected' : ''}}>Level 1</option>
                        <option value="2" {{$guard_data['guard']->award_rate_level == 2 ? 'selected' : ''}}>Level 2</option>
                        <option value="3" {{$guard_data['guard']->award_rate_level == 3 ? 'selected' : ''}}>Level 3</option>
                        <option value="4" {{$guard_data['guard']->award_rate_level == 4 ? 'selected' : ''}}>Level 4</option>
                        <option value="5" {{$guard_data['guard']->award_rate_level == 5 ? 'selected' : ''}}>Level 5</option>
                    </select>
                </div>
            </div>
            <div class="col-4 form-group award-payrates">
                    <div class="fv-row mb-10">
                        <label for="recipient-name" class="col-form-label">Apply From</label>
                        <input type="" class="form-control form-control-solid date-picker" placeholder="" name="award_rate_apply_from" id="award_rate_apply_from" value="{{$guard_data['guard']->award_rate_apply_from}}" >
                </div>
            </div>
            <div class="col-4 form-group award-payrates">
                    <div class="fv-row mb-10">
                        <label for="recipient-name" class="col-form-label">Apply To</label>
                        <input type="" class="form-control form-control-solid date-picker" placeholder="" name="award_rate_apply_to" id="award_rate_apply_to" value="{{$guard_data['guard']->award_rate_apply_to}}">
                        
                </div>
            </div>
            </div>

            <div class="row eba-rates-section" style="display: {{$guard_data['guard']->pay_by == 'eba' ? '' : 'none'}};">
                <div class="col-md-6">
                    <h4 class="text-center">Default/ABN Rates</h4></div>
                </div>
                <div class="row eba-rates-section" style="display: {{$guard_data['guard']->pay_by == 'eba' ? '' : 'none'}};">
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
                                        <input class="form-control form-control-md" name="flat_metro_week_day_day" type="number" step="any" value="{{!empty($payrate_data) ? $payrate_data['flat_metro_week_day_day'] : 0;}}">
                                    </div>
                                    <div class="rTableCell text-center">Mon-Fri(Day 06:00 - 18:00)</div>
                                    <div class="rTableCell">
                                        <input value="{{!empty($payrate_data) ? $payrate_data['flat_regional_week_day_day'] : 0;}}" class="form-control form-control-md" name="flat_regional_week_day_day" type="number" step="any">
                                    </div>
                                </div>
                                <div class="rTableRow">
                                    <div class="rTableCell">
                                        <input value="{{!empty($payrate_data) ? $payrate_data['flat_metro_week_day_night'] : 0;}}" class="form-control form-control-md" name="flat_metro_week_day_night" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Mon-Fri(Night 18:00 - 06:00)</div>
                                    <div class="rTableCell">
                                        <input value="{{!empty($payrate_data) ? $payrate_data['flat_regional_week_day_night'] : 0;}}" class="form-control form-control-md" name="flat_regional_week_day_night" type="number" step="any">
                                    </div>
                                </div>  
                                <div class="rTableRow" style="display: none;">
                                    <div class="rTableCell">
                                        <input value="{{!empty($payrate_data) ? $payrate_data['flat_metro_friday'] : 0;}}" class="form-control form-control-md" name="flat_metro_friday" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Friday (00:01 till 23:59)</div>
                                    <div class="rTableCell">
                                        <input value="{{!empty($payrate_data) ? $payrate_data['flat_regional_friday'] : 0;}}" class="form-control form-control-md" name="flat_regional_friday" type="number" step="any">
                                    </div>
                                </div>
                                <div class="rTableRow">
                                    <div class="rTableCell">
                                        <input value="{{!empty($payrate_data) ? $payrate_data['flat_metro_saturday'] : 0;}}" class="form-control form-control-md" name="flat_metro_saturday" type="number" step="any" onchange="copyValue('flat_metro_saturday', 'flat_metro_saturday_night')">
                                    </div>
                                    <div class="rTableCell text-center">Saturday </div>
                                    <div class="rTableCell">
                                        <input value="{{!empty($payrate_data) ? $payrate_data['flat_regional_saturday'] : 0;}}" class="form-control form-control-md" name="flat_regional_saturday" type="number" step="any" onchange="copyValue('flat_regional_saturday', 'flat_regional_saturday_night')">
                                    </div>
                                </div>
                                <div class="rTableRow" style="display:none;">
                                    <div class="rTableCell">
                                        <input value="{{!empty($payrate_data) ? $payrate_data['flat_metro_saturday_night'] : 0;}}" class="form-control form-control-md" name="flat_metro_saturday_night" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Saturday (Night 18:00 - 06:00)</div>
                                    <div class="rTableCell">
                                        <input value="{{!empty($payrate_data) ? $payrate_data['flat_regional_saturday_night'] : 0;}}" class="form-control form-control-md" name="flat_regional_saturday_night" type="number" step="any">
                                    </div>
                                </div>
                                <div class="rTableRow">
                                    <div class="rTableCell">
                                        <input value="{{!empty($payrate_data) ? $payrate_data['flat_metro_sunday'] : 0;}}" class="form-control form-control-md" name="flat_metro_sunday" type="number" step="any" onchange="copyValue('flat_metro_sunday', 'flat_metro_sunday_night')">
                                    </div>
                                    <div class="rTableCell text-center">Sunday </div>
                                    <div class="rTableCell">
                                        <input value="{{!empty($payrate_data) ? $payrate_data['flat_regional_sunday'] : 0;}}" class="form-control form-control-md" name="flat_regional_sunday" type="number" step="any" onchange="copyValue('flat_regional_sunday', 'flat_regional_sunday_night')">
                                    </div>
                                </div>
                                <div class="rTableRow" style="display:none;">
                                    <div class="rTableCell">
                                        <input value="{{!empty($payrate_data) ? $payrate_data['flat_metro_sunday_night'] : 0;}}" class="form-control form-control-md" name="flat_metro_sunday_night" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Sunday (Night 18:00 - 06:00)</div>
                                    <div class="rTableCell">
                                        <input value="{{!empty($payrate_data) ? $payrate_data['flat_regional_sunday_night'] : 0;}}" class="form-control form-control-md" name="flat_regional_sunday_night" type="number" step="any">
                                    </div>
                                </div>

                                <div class="rTableRow">
                                    <div class="rTableCell">
                                        <input value="{{!empty($payrate_data) ? $payrate_data['flat_metro_public_holiday'] : 0;}}" class="form-control form-control-md" name="flat_metro_public_holiday" type="number" step="any" onchange="copyValue('flat_metro_public_holiday', 'flat_metro_public_holiday_night')">
                                    </div>
                                    <div class="rTableCell text-center">Public Holiday </div>
                                    <div class="rTableCell">
                                        <input value="{{!empty($payrate_data) ? $payrate_data['flat_regional_public_holiday'] : 0;}}" class="form-control form-control-md" name="flat_regional_public_holiday" type="number" step="any" onchange="copyValue('flat_regional_public_holiday', 'flat_regional_public_holiday_night')">
                                    </div>
                                </div>
                                <div class="rTableRow" style="display:none;">
                                    <div class="rTableCell">
                                        <input value="{{!empty($payrate_data) ? $payrate_data['flat_metro_public_holiday_night'] : 0;}}" class="form-control form-control-md" name="flat_metro_public_holiday_night" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Public Holiday (Night 18:00 - 06:00)</div>
                                    <div class="rTableCell">
                                        <input value="{{!empty($payrate_data) ? $payrate_data['flat_regional_public_holiday_night'] : 0;}}" class="form-control form-control-md" name="flat_regional_public_holiday_night" type="number" step="any">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row eba-rates-section" style="display: {{$guard_data['guard']->pay_by == 'eba' ? '' : 'none'}};">
                    <div class="col-md-6">
                        <h4 class="text-center">EBA Rates</h4></div>
                    </div>
                    <div class="row eba-rates-section" style="display: {{$guard_data['guard']->pay_by == 'eba' ? '' : 'none'}};">
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
                                            <input value="{{!empty($payrate_data) ? $payrate_data['eba_metro_weekday_day'] : 0;}}" class="form-control form-control-md" name="eba_metro_weekday_day" type="number" step="any">
                                        </div>
                                        <div class="rTableCell text-center">Mon-Fri (Day 06:00-18:00)</div>
                                        <div class="rTableCell">
                                            <input value="{{!empty($payrate_data) ? $payrate_data['eba_regional_weekday_day'] : 0;}}" class="form-control form-control-md" name="eba_regional_weekday_day" type="number" step="any">
                                        </div>
                                    </div>

                                    <div class="rTableRow">
                                        <div class="rTableCell">
                                            <input value="{{!empty($payrate_data) ? $payrate_data['eba_metro_weekday_night'] : 0;}}" class="form-control form-control-md" name="eba_metro_weekday_night" type="number" step="any">
                                        </div>
                                        <div class="rTableCell text-center">Mon-Fri (Night 18:00-06:00)</div>
                                        <div class="rTableCell">
                                            <input value="{{!empty($payrate_data) ? $payrate_data['eba_regional_weekday_night'] : 0;}}" class="form-control form-control-md" name="eba_regional_weekday_night" type="number" step="any">
                                        </div>
                                    </div>
                                    <div class="rTableRow">
                                        <div class="rTableCell">
                                            <input value="{{!empty($payrate_data) ? $payrate_data['eba_metro_saturday_day'] : 0;}}" class="form-control form-control-md" name="eba_metro_saturday_day" type="number" step="any" onchange="copyValue('eba_metro_saturday_day', 'eba_metro_saturday_night')">
                                        </div>
                                        <div class="rTableCell text-center">Saturday</div>
                                        <div class="rTableCell">
                                            <input value="{{!empty($payrate_data) ? $payrate_data['eba_regional_saturday_day'] : 0;}}" class="form-control form-control-md" name="eba_regional_saturday_day" type="number" step="any" onchange="copyValue('eba_regional_saturday_day', 'eba_regional_saturday_night')">
                                        </div>
                                    </div>
                                    <div class="rTableRow" style="display:none;">
                                        <div class="rTableCell">
                                            <input value="{{!empty($payrate_data) ? $payrate_data['eba_metro_saturday_night'] : 0;}}" class="form-control form-control-md" name="eba_metro_saturday_night" type="number" step="any">
                                        </div>
                                        <div class="rTableCell text-center">Saturday (Night 06:00 till 18:00)</div>
                                        <div class="rTableCell">
                                            <input value="{{!empty($payrate_data) ? $payrate_data['eba_regional_saturday_night'] : 0;}}" class="form-control form-control-md" name="eba_regional_saturday_night" type="number" step="any">
                                        </div>
                                    </div>
                                    <div class="rTableRow">
                                        <div class="rTableCell">
                                            <input value="{{!empty($payrate_data) ? $payrate_data['eba_metro_sunday_day'] : 0;}}" class="form-control form-control-md" name="eba_metro_sunday_day" type="number" step="any" onchange="copyValue('eba_metro_sunday_day', 'eba_metro_sunday_night')">
                                        </div>
                                        <div class="rTableCell text-center">Sunday</div>
                                        <div class="rTableCell">
                                            <input value="{{!empty($payrate_data) ? $payrate_data['eba_regional_sunday_day'] : 0;}}" class="form-control form-control-md" name="eba_regional_sunday_day" type="number" step="any" onchange="copyValue('eba_regional_sunday_day', 'eba_regional_sunday_night')">
                                        </div>
                                    </div>
                                    <div class="rTableRow" style="display:none;">
                                        <div class="rTableCell">
                                            <input value="{{!empty($payrate_data) ? $payrate_data['eba_metro_sunday_night'] : 0;}}" class="form-control form-control-md" name="eba_metro_sunday_night" type="number" step="any">
                                        </div>
                                        <div class="rTableCell text-center">Sunday (Night 18:00 till 06:00)</div>
                                        <div class="rTableCell">
                                            <input value="{{!empty($payrate_data) ? $payrate_data['eba_regional_sunday_night'] : 0;}}" class="form-control form-control-md" name="eba_regional_sunday_night" type="number" step="any">
                                        </div>
                                    </div>
                                    <div class="rTableRow">
                                        <div class="rTableCell">
                                            <input value="{{!empty($payrate_data) ? $payrate_data['eba_metro_public_holiday'] : 0;}}" class="form-control form-control-md" name="eba_metro_public_holiday" type="number" step="any" onchange="copyValue('eba_metro_public_holiday', 'eba_metro_public_holiday_night')">
                                        </div>
                                        <div class="rTableCell text-center">Public Holiday</div>
                                        <div class="rTableCell">
                                            <input value="{{!empty($payrate_data) ? $payrate_data['eba_regional_public_holiday'] : 0;}}" class="form-control form-control-md" name="eba_regional_public_holiday" type="number" step="any" onchange="copyValue('eba_regional_public_holiday', 'eba_regional_public_holiday_night')">
                                        </div>
                                    </div>
                                    <div class="rTableRow" style="display:none;">
                                        <div class="rTableCell">
                                            <input value="{{!empty($payrate_data) ? $payrate_data['eba_metro_public_holiday_night'] : 0;}}" class="form-control form-control-md" name="eba_metro_public_holiday_night" type="number" step="any">
                                        </div>
                                        <div class="rTableCell text-center">Public Holiday (Night 18:00 till 06:E00)</div>
                                        <div class="rTableCell">
                                            <input value="{{!empty($payrate_data) ? $payrate_data['eba_regional_public_holiday_night'] : 0;}}" class="form-control form-control-md" name="eba_regional_public_holiday_night" type="number" step="any">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </br>
                 <div class="row rates-section" style="display: none;">
                    <div class="col-md-6">
                        <h4 class="text-center">Awards Rates</h4></div>
                    </div>
                    <div class="row rates-section" style="display: none;">
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
                                            <input value="{{(!empty($payrate_data) && isset($payrate_data['award_metro_weekday_day'])) ? $payrate_data['award_metro_weekday_day'] : 0;}}" class="form-control form-control-md" name="award_metro_weekday_day" type="number" step="any">
                                        </div>
                                        <div class="rTableCell text-center">Mon-Fri (Day 06:00-18:00)</div>
                                        <div class="rTableCell">
                                            <input value="{{(!empty($payrate_data) && isset($payrate_data['award_regional_weekday_day'])) ? $payrate_data['award_regional_weekday_day'] : 0;}}" class="form-control form-control-md" name="award_regional_weekday_day" type="number" step="any">
                                        </div>
                                    </div>
                                    
                                    <div class="rTableRow">
                                        <div class="rTableCell">
                                            <input value="{{(!empty($payrate_data) && isset($payrate_data['award_metro_weekday_night'])) ? $payrate_data['award_metro_weekday_night'] : 0;}}" class="form-control form-control-md" name="award_metro_weekday_night" type="number" step="any">
                                        </div>
                                        <div class="rTableCell text-center">Mon-Fri (Night 18:00-06:00)</div>
                                        <div class="rTableCell">
                                            <input value="{{(!empty($payrate_data) && isset($payrate_data['award_regional_weekday_night'])) ? $payrate_data['award_regional_weekday_night'] : 0;}}" class="form-control form-control-md" name="award_regional_weekday_night" type="number" step="any">
                                        </div>
                                    </div>
                                    <div class="rTableRow">
                                        <div class="rTableCell">
                                            <input value="{{(!empty($payrate_data) && isset($payrate_data['award_metro_saturday_day'])) ? $payrate_data['award_metro_saturday_day'] : 0;}}" class="form-control form-control-md" name="award_metro_saturday_day" type="number" step="any" onchange="copyValue('award_metro_saturday_day', 'award_metro_saturday_night')">
                                        </div>
                                        <div class="rTableCell text-center">Saturday</div>
                                        <div class="rTableCell">
                                            <input value="{{(!empty($payrate_data) && isset($payrate_data['award_regional_saturday_day'])) ? $payrate_data['award_regional_saturday_day'] : 0;}}" class="form-control form-control-md" name="award_regional_saturday_day" type="number" step="any" onchange="copyValue('award_regional_saturday_day', 'award_regional_saturday_night')">
                                        </div>
                                    </div>
                                    <div class="rTableRow" style="display:none;">
                                        <div class="rTableCell">
                                            <input value="{{(!empty($payrate_data) && isset($payrate_data['award_metro_saturday_night'])) ? $payrate_data['award_metro_saturday_night'] : 0;}}" class="form-control form-control-md" name="award_metro_saturday_night" type="number" step="any">
                                        </div>
                                        <div class="rTableCell text-center">Saturday (Night 06:00 till 18:00)</div>
                                        <div class="rTableCell">
                                            <input value="{{(!empty($payrate_data) && isset($payrate_data['award_regional_saturday_night'])) ? $payrate_data['award_regional_saturday_night'] : 0;}}" class="form-control form-control-md" name="award_regional_saturday_night" type="number" step="any">
                                        </div>
                                    </div>
                                    <div class="rTableRow">
                                        <div class="rTableCell">
                                            <input value="{{(!empty($payrate_data) && isset($payrate_data['award_metro_sunday_day'])) ? $payrate_data['award_metro_sunday_day'] : 0;}}" class="form-control form-control-md" name="award_metro_sunday_day" type="number" step="any" onchange="copyValue('award_metro_sunday_day', 'award_metro_sunday_night')">
                                        </div>
                                        <div class="rTableCell text-center">Sunday </div>
                                        <div class="rTableCell">
                                            <input value="{{(!empty($payrate_data) && isset($payrate_data['award_regional_sunday_day'])) ? $payrate_data['award_regional_sunday_day'] : 0;}}" class="form-control form-control-md" name="award_regional_sunday_day" type="number" step="any" onchange="copyValue('award_regional_sunday_day', 'award_regional_sunday_night')">
                                        </div>
                                    </div>
                                    <div class="rTableRow" style="display:none;">
                                        <div class="rTableCell">
                                            <input value="{{(!empty($payrate_data) && isset($payrate_data['award_metro_sunday_night'])) ? $payrate_data['award_metro_sunday_night'] : 0;}}" class="form-control form-control-md" name="award_metro_sunday_night" type="number" step="any">
                                        </div>
                                        <div class="rTableCell text-center">Sunday (Night 18:00 till 06:00)</div>
                                        <div class="rTableCell">
                                            <input value="{{(!empty($payrate_data) && isset($payrate_data['award_regional_sunday_night'])) ? $payrate_data['award_regional_sunday_night'] : 0;}}" class="form-control form-control-md" name="award_regional_sunday_night" type="number" step="any">
                                        </div>
                                    </div>
                                    <div class="rTableRow">
                                        <div class="rTableCell">
                                            <input value="{{(!empty($payrate_data) && isset($payrate_data['award_metro_public_holiday'])) ? $payrate_data['award_metro_public_holiday'] : 0;}}" class="form-control form-control-md" name="award_metro_public_holiday" type="number" step="any" onchange="copyValue('award_metro_public_holiday', 'award_metro_public_holiday_night')">
                                        </div>
                                        <div class="rTableCell text-center">Public Holiday </div>
                                        <div class="rTableCell">
                                            <input value="{{(!empty($payrate_data) && isset($payrate_data['award_regional_public_holiday'])) ? $payrate_data['award_regional_public_holiday'] : 0;}}" class="form-control form-control-md" name="award_regional_public_holiday" type="number" step="any" onchange="copyValue('award_regional_public_holiday', 'award_regional_public_holiday_night')">
                                        </div>
                                    </div>
                                    <div class="rTableRow" style="display:none;">
                                        <div class="rTableCell">
                                            <input value="{{(!empty($payrate_data) && isset($payrate_data['award_metro_public_holiday_night'])) ? $payrate_data['award_metro_public_holiday_night'] : 0;}}" class="form-control form-control-md" name="award_metro_public_holiday_night" type="number" step="any">
                                        </div>
                                        <div class="rTableCell text-center">Public Holiday (Night 18:00 till 06:E00)</div>
                                        <div class="rTableCell">
                                            <input value="{{(!empty($payrate_data) && isset($payrate_data['award_regional_public_holiday_night'])) ? $payrate_data['award_regional_public_holiday_night'] : 0;}}" class="form-control form-control-md" name="award_regional_public_holiday_night" type="number" step="any">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </br>
            </br>
            <div class="text-center">
                <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                    <span id="form_submit" class="indicator-label">Submit</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>

        </form>

        <!--end::Form-->
    </div>
    <!--end::Modal body-->
</div>
<!--end::Modal content-->
</div>
<!--end::Modal dialog-->
</div>
<!--end::Modal - Update role-->
<!--end::Modals-->
<script type="text/javascript">

    function copyValue(from, to)
    {
        $('input[name="'+to+'"]').val($('input[name="'+from+'"]').val());   
    }
</script>
@endif
@stop
