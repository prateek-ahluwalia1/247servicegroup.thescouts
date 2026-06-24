@section('pay-rates')
<?php
$progress = 0;
if (isset($guard_data['guard']) && $guard_data['guard']->payrates_id != '' && $guard_data['guard']->payrates_id > 0) {
    $progress += 100;
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
        <button type="button" class="btn btn-white btn-active-light-primary my-1" data-bs-toggle="modal"
        data-bs-target="#pay-rates-modal1" id="pay-rates-modal-btn">Open Pay Rates</button>


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

            <form id="pay-rates-form" class="form" action="{{ url('guard/save_guard_payrates') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="guard_id" value="{{ $guard_id }}">
            <div class="row rates-section" style="">
                <div class="col-md-12">
                    <div class="form-check form-check-custom form-check-solid me-10">
                        <input class="form-check-input h-30px w-30px" type="checkbox" value="1" id="custom_payrate" name="custom_payrate"  {{isset($guard_data['guard']) && $guard_data['guard']->manual_custom_payrate == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="custom_payrate">
                            Custom Payrate
                        </label>
                    </div>
                </div>
                <div class="own_payrates_div" style="display: none;">
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
                                        <input class="form-control form-control-md" name="flat_metro_week_day_day" type="number" step="any" value="{{isset($guard_data) && isset($guard_data['guard']->manual_custom_payrates['flat_metro_week_day_day']) ? $guard_data['guard']->manual_custom_payrates['flat_metro_week_day_day'] : '0' }}">
                                    </div>
                                    <div class="rTableCell text-center">Mon-Fri(Day 06:00 - 18:00)</div>
                                    <div class="rTableCell">
                                        <input value="{{isset($guard_data) && isset($guard_data['guard']->manual_custom_payrates['flat_regional_week_day_day']) ? $guard_data['guard']->manual_custom_payrates['flat_regional_week_day_day'] : '0' }}" class="form-control form-control-md" name="flat_regional_week_day_day" type="number" step="any">
                                    </div>
                                </div>
                                <div class="rTableRow">
                                    <div class="rTableCell">
                                        <input value="{{isset($guard_data) && isset($guard_data['guard']->manual_custom_payrates['flat_metro_week_day_night']) ? $guard_data['guard']->manual_custom_payrates['flat_metro_week_day_night'] : '0' }}" class="form-control form-control-md" name="flat_metro_week_day_night" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Mon-Fri(Night 18:00 - 06:00)</div>
                                    <div class="rTableCell">
                                        <input value="{{isset($guard_data) && isset($guard_data['guard']->manual_custom_payrates['flat_regional_week_day_night']) ? $guard_data['guard']->manual_custom_payrates['flat_regional_week_day_night'] : '0' }}" class="form-control form-control-md" name="flat_regional_week_day_night" type="number" step="any">
                                    </div>
                                </div>  
                                <div class="rTableRow" style="display: none;">
                                    <div class="rTableCell">
                                        <input value="{{isset($guard_data) && isset($guard_data['guard']->manual_custom_payrates['flat_metro_friday']) ? $guard_data['guard']->manual_custom_payrates['flat_metro_friday'] : '0' }}" class="form-control form-control-md" name="flat_metro_friday" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Friday (00:01 till 23:59)</div>
                                    <div class="rTableCell">
                                        <input value="{{isset($guard_data) && isset($guard_data['guard']->manual_custom_payrates['flat_regional_friday']) ? $guard_data['guard']->manual_custom_payrates['flat_regional_friday'] : '0' }}" class="form-control form-control-md" name="flat_regional_friday" type="number" step="any">
                                    </div>
                                </div>
                                <div class="rTableRow">
                                    <div class="rTableCell">
                                        <input value="{{isset($guard_data) && isset($guard_data['guard']->manual_custom_payrates['flat_metro_saturday']) ? $guard_data['guard']->manual_custom_payrates['flat_metro_saturday'] : '0' }}" class="form-control form-control-md" name="flat_metro_saturday" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Saturday </div>
                                    <div class="rTableCell">
                                        <input value="{{isset($guard_data) && isset($guard_data['guard']->manual_custom_payrates['flat_regional_saturday']) ? $guard_data['guard']->manual_custom_payrates['flat_regional_saturday'] : '0' }}" class="form-control form-control-md" name="flat_regional_saturday" type="number" step="any">
                                    </div>
                                </div>
                                <div class="rTableRow" style="display:none;">
                                    <div class="rTableCell">
                                        <input value="{{isset($guard_data) && isset($guard_data['guard']->manual_custom_payrates['flat_metro_saturday_night']) ? $guard_data['guard']->manual_custom_payrates['flat_metro_saturday_night'] : '0' }}" class="form-control form-control-md" name="flat_metro_saturday_night" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Saturday (Night 18:00 - 06:00)</div>
                                    <div class="rTableCell">
                                        <input value="{{isset($guard_data) && isset($guard_data['guard']->manual_custom_payrates['flat_regional_saturday_night']) ? $guard_data['guard']->manual_custom_payrates['flat_regional_saturday_night'] : '0' }}" class="form-control form-control-md" name="flat_regional_saturday_night" type="number" step="any">
                                    </div>
                                </div>
                                <div class="rTableRow">
                                    <div class="rTableCell">
                                        <input value="{{isset($guard_data) && isset($guard_data['guard']->manual_custom_payrates['flat_metro_sunday']) ? $guard_data['guard']->manual_custom_payrates['flat_metro_sunday'] : '0' }}" class="form-control form-control-md" name="flat_metro_sunday" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Sunday</div>
                                    <div class="rTableCell">
                                        <input value="{{isset($guard_data) && isset($guard_data['guard']->manual_custom_payrates['flat_regional_sunday']) ? $guard_data['guard']->manual_custom_payrates['flat_regional_sunday'] : '0' }}" class="form-control form-control-md" name="flat_regional_sunday" type="number" step="any">
                                    </div>
                                </div>
                                <div class="rTableRow" style="display:none;">
                                    <div class="rTableCell">
                                        <input value="{{isset($guard_data) && isset($guard_data['guard']->manual_custom_payrates['flat_metro_sunday_night']) ? $guard_data['guard']->manual_custom_payrates['flat_metro_sunday_night'] : '0' }}" class="form-control form-control-md" name="flat_metro_sunday_night" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Sunday (Night 18:00 - 06:00)</div>
                                    <div class="rTableCell">
                                        <input value="{{isset($guard_data) && isset($guard_data['guard']->manual_custom_payrates['flat_regional_sunday_night']) ? $guard_data['guard']->manual_custom_payrates['flat_regional_sunday_night'] : '0' }}" class="form-control form-control-md" name="flat_regional_sunday_night" type="number" step="any">
                                    </div>
                                </div>

                                <div class="rTableRow">
                                    <div class="rTableCell">
                                        <input value="{{isset($guard_data) && isset($guard_data['guard']->manual_custom_payrates['flat_metro_public_holiday']) ? $guard_data['guard']->manual_custom_payrates['flat_metro_public_holiday'] : '0' }}" class="form-control form-control-md" name="flat_metro_public_holiday" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Public Holiday</div>
                                    <div class="rTableCell">
                                        <input value="{{isset($guard_data) && isset($guard_data['guard']->manual_custom_payrates['flat_regional_public_holiday']) ? $guard_data['guard']->manual_custom_payrates['flat_regional_public_holiday'] : '0' }}" class="form-control form-control-md" name="flat_regional_public_holiday" type="number" step="any">
                                    </div>
                                </div>
                                <div class="rTableRow" style="display:none;">
                                    <div class="rTableCell">
                                        <input value="{{isset($guard_data) && isset($guard_data['guard']->manual_custom_payrates['flat_metro_public_holiday_night']) ? $guard_data['guard']->manual_custom_payrates['flat_metro_public_holiday_night'] : '0' }}" class="form-control form-control-md" name="flat_metro_public_holiday_night" type="number" step="any">
                                    </div>
                                    <div class="rTableCell text-center">Public Holiday</div>
                                    <div class="rTableCell">
                                        <input value="{{isset($guard_data) && isset($guard_data['guard']->manual_custom_payrates['flat_regional_public_holiday_night']) ? $guard_data['guard']->manual_custom_payrates['flat_regional_public_holiday_night'] : '0' }}" class="form-control form-control-md" name="flat_regional_public_holiday_night" type="number" step="any">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <div class="col-md-3 form-group payrates">
                    <div class="fv-row mb-10">
                        <label for="recipient-name" class="col-form-label">Job Level</label>
                        <select class="form-select form-select-lg form-select-solid"
                        data-placeholder="Select..." data-allow-clear="true" data-hide-search="true"
                        name="job_level" id="job_level" onchange="load_payrates()">
                        <option value="">Select</option>

                        <option value="1">Level 1</option>
                        <option value="2">Level 2</option>
                        <option value="3">Level 3</option>
                        <option value="4">Level 4</option>
                        <option value="5">Level 5</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3 form-group payrates">
                <div class="fv-row mb-10">
                    <label for="recipient-name" class="col-form-label">State</label>
                    <select class="form-select form-select-lg form-select-solid"
                    data-placeholder="Select..." data-allow-clear="true" data-hide-search="true"
                    name="payrates_state" id="payrates_state" onchange="load_payrates()">
                    <option value="">Select</option>

                    <option value="Victoria">Victoria</option>
                    <option value="New South Wales">NSW</option>
                    <option value="Queensland">Queensland</option>
                    <option value="Tasmania">Tasmania</option>
                    <option value="Western Australia">Western Australia</option>
                    <option value="South Australia">South Australia</option>
                    <option value="ACT">ACT</option>
                </select>
            </div>
        </div>
        @if(config('custom.categorized_payrates') == 1)
        <div class="col-md-3 payrates">
            <label for="recipient-name" class="col-form-label">Payrol</label>
            <select class="form-select form-select-lg form-select-solid" data-control="select2"
            data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" id="payrol"
            name="payrol" onchange="load_payrates()">
            <option value="default">Default Rates</option>
            <option value="award">Award Rates</option>
            <option value="eba">EBA Rates</option>
        </select>
    </div>
    @endif
    <div class="col-md-3 payrates">
        <div id="payrates_div" class="fv-row mb-10">
            <label for="recipient-name" class="col-form-label">PayRates</label>
            <select data-dropdown-parent="#pay-rates-modal" data-allow-clear="true"
            data-control="select2" class="form-select form-select-solid"
            data-placeholder="Select..." name="payrates_id" id="payrates_id">
                                            <!--             <option value="Victoria">Victoria</option>
                <option value="New South Wales">NSW</option>
                <option value="Queensland">Queensland</option>
                <option value="Tasmania">Tasmania</option>
                <option value="Western Australia">Western Australia</option>
                <option value="South Australia">South Australia</option>
                <option value="ACT">ACT</option> -->
            </select>
        </div>

    </div>
</div>

</br>
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






<script type="text/javascript">
    
</script>



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
@endif
@stop
