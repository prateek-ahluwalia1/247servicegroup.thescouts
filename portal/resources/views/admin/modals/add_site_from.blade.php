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

<?php
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
    $item['charge_rates_and_level'] = 1;
    $item['start_end_date'] = 1;

    $item = json_decode(json_encode($item));
}
$display = "";
if(session()->get('userType')=='customer')
{
    $display = 'style=display:none;';
}
?>


<div class="row">

    @if (!isset($add))
    <div class="col-12">
        <button type="button" class="btn-primary btn-sm" onclick="pay_charge_history('payrate')"> Pay Rate History
        </button>
        <button type="button" class="btn-primary btn-sm" onclick="pay_charge_history('chargerate')"> Charge Rate
        History </button>
    </div>
    @endif
    <div class="col-sm-12 col-md-6" {{$display}}>
        <div class="fv-row mb-9">
            @csrf
            <!--begin::Label-->
            @if (isset($site_data))
            <input type="hidden" name="site_id" id="site_id" value="{{ $site_data->id }}">
            @endif
            <label class="fs-6 fw-bold required mb-2">Customer</label>
            <!--end::Label-->
            <select class="form-select form-select-lg form-select-solid" data-control="select2"
            data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" id="site_customer_id"
            name="site_customer_id" required="">
            @if(count($customers) > 1)
            <option value="">Select Customer</option>
            @endif
            @foreach ($customers as $customer)
            <option value="{{ $customer->id }}"
                {{ isset($site_data) && $site_data->customer_id == $customer->id ? 'selected' : '' }}>
                {{ $customer->name }}</option>
                @endforeach
            </select>
        </div>
        <!--end::Input group-->
    </div>
    @if (isset($item->site_type)  && $item->site_type == 1)
    <div class="col-sm-12 col-md-6" {{$display}}>
        <div class="fv-row mb-9">
            <!--begin::Label-->
            <label class="fs-6 fw-bold required mb-2">Site Type</label>
            <!--end::Label-->
            <select class="form-select form-select-lg form-select-solid" data-control="select2"
            data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" id="site_employer"
            name="site_employer">
            <option value="direct"
            {{ isset($site_data) && $site_data->site_employer == 'direct' ? 'selected' : '' }}>Direct
        </option>
        <option value="all" {{ isset($site_data) && $site_data->site_employer == 'all' ? 'selected' : '' }}>
            Direct or
        Contractor</option>
    </select>
</div>
<!--end::Input group-->
</div>
@else
<div {{$display}}>
	<div class="col-sm-12 col-md-6" id="site-type-direct-none" style="display: none">
        <div class="fv-row mb-9">
            <!--begin::Label-->
            <label class="fs-6 fw-bold required mb-2">Site Type</label>
            <!--end::Label-->
            <select class="form-select form-select-lg form-select-solid" data-control="select2"
            data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" id="site_employer"
            name="site_employer">
            <option value="direct"
            {{ isset($site_data) && $site_data->site_employer == 'direct' ? 'selected' : '' }}>Direct
        </option>
    </select>
</div>
<!--end::Input group-->
</div>
</div>
@endif

</div>
<!--begin::Input group-->
<div class="fv-row mb-9">
    <!--begin::Label-->
    <label class="fs-6 fw-bold mb-2">Site Name</label>
    <!--end::Label-->
    <!--begin::Input-->
    <input type="text" class="form-control form-control-solid" placeholder="" name="site_name" id="site_name"
    required="" value="{{ isset($site_data) ? $site_data->site_name : '' }}" />
    <!--end::Input-->
</div>

<!--begin::Input group-->
<div class="fv-row mb-9">
    <!--begin::Label-->
    <label class="fs-6 fw-bold mb-2">Description</label>
    <!--end::Label-->
    <!--begin::Input-->
    <textarea class="form-control form-control-solid" name="site_description" id="site_description">{{ isset($site_data) ? $site_data->site_description : '' }}</textarea>
    <!--end::Input-->
</div>
<div class="fv-row mb-9">
    <!--begin::Label-->
    <label class="fs-6 fw-bold required mb-2">State</label>
    <!--end::Label-->
    <select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..."
    data-allow-clear="true" data-hide-search="true" id="site_state" name="site_state">
    <option>Select</option>
    <option value="New South Wales"
    {{ isset($site_data) && $site_data->state == 'New South Wales' ? 'selected' : '' }}>New South Wales
</option>
<option value="Queensland" {{ isset($site_data) && $site_data->state == 'Queensland' ? 'selected' : '' }}>
Queensland</option>
<option value="South Australia"
{{ isset($site_data) && $site_data->state == 'South Australia' ? 'selected' : '' }}>South Australia
</option>
<option value="Tasmania" {{ isset($site_data) && $site_data->state == 'Tasmania' ? 'selected' : '' }}>
Tasmania</option>
<option value="Victoria" {{ isset($site_data) && $site_data->state == 'Victoria' ? 'selected' : '' }}>
Victoria</option>
<option value="Western Australia"
{{ isset($site_data) && $site_data->state == 'Western Australia' ? 'selected' : '' }}>Western Australia
</option>
<option value="Australian Capital Territory"
{{ isset($site_data) && $site_data->state == 'Australian Capital Territory' ? 'selected' : '' }}>
Australian Capital Territory</option>
<option value="Northern Territory"
{{ isset($site_data) && $site_data->state == 'Northern Territory' ? 'selected' : '' }}>Northern
Territory</option>
</select>
</div>

@if (isset($item->site_type) && $item->site_type == 1)
<div class="fv-row mb-9" {{$display}}>
    <!--begin::Label-->
    <label class="fs-6 fw-bold required mb-2">Site Type</label>
    <!--end::Label-->
    <select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..."
    data-allow-clear="true" data-hide-search="true" id="site_type" name="site_type">
    <option value="normal" {{ isset($site_data) && $site_data->site_type == 'normal' ? 'selected' : '' }}>
    Security</option>
    <option value="covid_marshal"
    {{ isset($site_data) && $site_data->site_type == 'covid_marshal' ? 'selected' : '' }}>Covid Marshal
</option>
<option value="both" {{ isset($site_data) && $site_data->site_type == 'both' ? 'selected' : '' }}>Both
</option>
</select>
</div>
@endif
<div class="fv-row mb-9">
    <!--begin::Label-->
    <label class="fs-6 fw-bold required mb-2">Site Level</label>
    <!--end::Label-->
    <select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..."
    data-allow-clear="true" data-hide-search="true" id="site_level" name="site_level">
    <option>Select</option>
    <option value="1" {{ isset($site_data) && $site_data->level == '1' ? 'selected' : '' }}>1</option>
    <option value="2" {{ isset($site_data) && $site_data->level == '2' ? 'selected' : '' }}>2</option>
    <option value="3" {{ isset($site_data) && $site_data->level == '3' ? 'selected' : '' }}>3</option>
    <option value="4" {{ isset($site_data) && $site_data->level == '4' ? 'selected' : '' }}>4</option>
    <option value="5" {{ isset($site_data) && $site_data->level == '5' ? 'selected' : '' }}>5</option>
    <option value="5" {{ isset($site_data) && $site_data->level == 'DR' ? 'selected' : '' }}>DR</option>
</select>
</div>

<div class="row">
    @if(isset($settings['un_publish_site']) && $settings['un_publish_site'] == 1)
    <div class="col-sm-12 col-md-6" {{$display}}>
        <div class="fv-row mb-9">
            <label class="fs-6 fw-bold mb-2">Un-published Site</label>
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="form-check form-check-custom form-check-solid">
                        <input class="form-check-input" type="radio" value="1" name="unpublished_site"
                        {{ isset($site_data) && $site_data->unpublished_site == 1 ? 'checked' : '' }} />
                        <label class="form-check-label" for="flexRadioChecked">
                            Yes
                        </label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-check form-check-custom form-check-solid">
                        <input class="form-check-input" type="radio" value="0" name="unpublished_site"
                        {{ isset($site_data) && $site_data->unpublished_site == 0 ? 'checked' : (!isset($site_data) ? 'checked' : '') }} />
                        <label class="form-check-label" for="flexRadioChecked">
                            No
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if (isset($item->site_trained)  && $item->site_trained == 1)
    <div class="col-sm-12 col-md-6" {{$display}}>
        <div class="fv-row mb-9">
            <label class="fs-6 fw-bold mb-2">Site Trained</label>
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="form-check form-check-custom form-check-solid">
                        <input class="form-check-input" type="radio" value="yes" name="site_trained"
                        {{ isset($site_data) && $site_data->trained == 'yes' ? 'checked' : '' }} />
                        <label class="form-check-label" for="flexRadioChecked">
                            Yes
                        </label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-check form-check-custom form-check-solid">
                        <input class="form-check-input" type="radio" value="no" name="site_trained"
                        {{ isset($site_data) && $site_data->trained == 'no' ? 'checked' : '' }} />
                        <label class="form-check-label" for="flexRadioChecked">
                            No
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="col-sm-12 col-md-6" style="display: none">
      <div class="form-check form-check-custom form-check-solid">
         <input class="form-check-input" type="radio" value="no" name="site_trained" checked=""
         {{ isset($site_data) && $site_data->trained == 'no' ? 'checked' : '' }} />
         <label class="form-check-label" for="flexRadioChecked">
            No
        </label>
    </div>
</div>
@endif

<div class="col-sm-12 col-md-6">
    <div class="fv-row mb-9">
        <label class="fs-6 fw-bold mb-2">Break</label>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="form-check form-check-custom form-check-solid">
                    <input class="form-check-input" type="radio" value="1" name="site_break"
                    {{ isset($site_data) && $site_data->break == '1' ? 'checked' : '' }} />
                    <label class="form-check-label" for="flexRadioChecked">
                        Yes
                    </label>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-check form-check-custom form-check-solid">
                    <input class="form-check-input" type="radio" value="0" name="site_break"
                    {{ isset($site_data) && $site_data->break == '0' ? 'checked' : '' }} />
                    <label class="form-check-label" for="flexRadioChecked">
                        No
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-12 col-md-6 break-div"
{{ isset($site_data) && $site_data->break == '1' ? '' : 'style=display:none' }}>
<div class="fv-row mb-9">
    <label class="fs-6 fw-bold mb-2">Break payable</label>
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="form-check form-check-custom form-check-solid">
                <input class="form-check-input" type="radio" value="yes" name="payable"
                {{ isset($site_data) && $site_data->payable == 'yes' ? 'checked' : '' }} />
                <label class="form-check-label" for="flexRadioChecked">
                    Yes
                </label>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-check form-check-custom form-check-solid">
                <input class="form-check-input" type="radio" value="no" name="payable"
                {{ isset($site_data) && $site_data->payable == 'no' ? 'checked' : '' }} />
                <label class="form-check-label" for="flexRadioChecked">
                    No
                </label>
            </div>
        </div>
    </div>
</div>
</div>
<div class="col-sm-12 col-md-6 break-div"
{{ isset($site_data) && $site_data->break == '1' ? '' : 'style=display:none' }}>
<div class="fv-row mb-9">
    <label class="fs-6 fw-bold mb-2">Break Chargeable</label>
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="form-check form-check-custom form-check-solid">
                <input class="form-check-input" type="radio" value="yes" name="chargeable"
                {{ isset($site_data) && $site_data->chargeable == 'yes' ? 'checked' : '' }} />
                <label class="form-check-label" for="flexRadioChecked">
                    Yes
                </label>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-check form-check-custom form-check-solid">
                <input class="form-check-input" type="radio" value="no" name="chargeable"
                {{ isset($site_data) && $site_data->chargeable == 'no' ? 'checked' : '' }} />
                <label class="form-check-label" for="flexRadioChecked">
                    No
                </label>
            </div>
        </div>
    </div>
</div>
</div>
<div class="col-sm-12 col-md-6 payable-time-div"
{{ isset($site_data) && $site_data->payable == 'no' && $site_data->break == '1' ? '' : 'style=display:none' }}>
<div class="fv-row mb-9">
    <label class="fs-6 fw-bold mb-2">Break Deduction (Payable)</label>
    <select class="form-select form-select-lg form-select-solid" data-control="select2"
    data-placeholder="Select..." data-allow-clear="true" data-hide-search="true"
    id="payable_and_chargeable_time" name="payable_and_chargeable_time">
    <option value="15"
    {{ isset($site_data) && $site_data->payable_and_chargeable_time == '0' ? 'selected' : '' }}>0
minutes</option>
<option value="15"
{{ isset($site_data) && $site_data->payable_and_chargeable_time == '15' ? 'selected' : '' }}>15
minutes</option>
<option value="30"
{{ isset($site_data) && $site_data->payable_and_chargeable_time == '30' ? 'selected' : '' }}>30
minutes</option>
<option value="45"
{{ isset($site_data) && $site_data->payable_and_chargeable_time == '45' ? 'selected' : '' }}>45
minutes</option>
<option value="60"
{{ isset($site_data) && $site_data->payable_and_chargeable_time == '60' ? 'selected' : '' }}>1
hour</option>
</select>
</div>
</div>
<div class="col-sm-12 col-md-6 chargeable-time-div"
{{ isset($site_data) && $site_data->chargeable == 'no' && $site_data->break == '1' ? '' : 'style=display:none' }}>
<div class="fv-row mb-9">
    <label class="fs-6 fw-bold mb-2">Break Deduction (Chargeable)</label>
    <select class="form-select form-select-lg form-select-solid" data-control="select2"
    data-placeholder="Select..." data-allow-clear="true" data-hide-search="true"
    id="break_deduction_chargeable" name="break_deduction_chargeable">
    <option value="15"
    {{ isset($site_data) && $site_data->break_deduction_chargeable == '0' ? 'selected' : '' }}>0
minutes</option>
<option value="15"
{{ isset($site_data) && $site_data->break_deduction_chargeable == '15' ? 'selected' : '' }}>15
minutes</option>
<option value="30"
{{ isset($site_data) && $site_data->break_deduction_chargeable == '30' ? 'selected' : '' }}>30
minutes</option>
<option value="45"
{{ isset($site_data) && $site_data->break_deduction_chargeable == '45' ? 'selected' : '' }}>45
minutes</option>
<option value="60"
{{ isset($site_data) && $site_data->break_deduction_chargeable == '60' ? 'selected' : '' }}>1
hour</option>
</select>
</div>
</div>
</div>
<div class="row">
	@if (isset($item->welfare_calls) && $item->welfare_calls == 1)
	<div class="col-sm-12 col-md-6">
        <div class="fv-row mb-9">
            <label class="fs-6 fw-bold mb-2">Welfare Call</label>
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="form-check form-check-custom form-check-solid">
                        <input class="form-check-input" type="radio" value="yes" name="welfare_call"
                        {{ isset($site_data) && $site_data->welfare_call == 'yes' ? 'checked' : '' }} />
                        <label class="form-check-label" for="flexRadioChecked">
                            Yes
                        </label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-check form-check-custom form-check-solid">
                        <input class="form-check-input" type="radio" value="no" name="welfare_call"
                        {{ isset($site_data) && $site_data->welfare_call == 'no' ? 'checked' : '' }} />
                        <label class="form-check-label" for="flexRadioChecked">
                            No
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    
    <div class="col-sm-12 col-md-6">
        <div class="fv-row mb-9 welfare_timing"
        style="display:{{ isset($site_data) && $site_data->welfare_call == 'yes' ? '' : 'none' }}">
        <!--begin::Label-->
        <label class="fs-6 fw-bold required mb-2">Timing</label>
        <!--end::Label-->
        <select class="form-select form-select-lg form-select-solid" data-control="select2"
        data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" id="welfare_timing"
        name="welfare_timing">
        <option value="1" {{ isset($site_data) && $site_data->welfare_timing == 1 ? 'selected' : '' }}>
            After every 1 Hour
        </option>
        <option value="2" {{ isset($site_data) && $site_data->welfare_timing == 2 ? 'selected' : '' }}>
            After every 2 Hour
        </option>
        <option value="3" {{ isset($site_data) && $site_data->welfare_timing == 3 ? 'selected' : '' }}>
            After every 3 Hour
        </option>
        <option value="4" {{ isset($site_data) && $site_data->welfare_timing == 4 ? 'selected' : '' }}>
            After every 4 Hour
        </option>
    </select>
</div>
<!--end::Input group-->
</div>
<div class="col-sm-12 col-md-6">
    <div class="fv-row mb-9">
        <label class="fs-6 fw-bold mb-2">Type</label>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="form-check form-check-custom form-check-solid">
                    <input class="form-check-input" type="radio" value="metropolitan" name="stateType"
                    {{ isset($site_data) && $site_data->stateType == 'metropolitan' ? 'checked' : '' }}
                    {{ !isset($site_data) ? 'checked' : '' }} />
                    <label class="form-check-label" for="flexRadioChecked">
                        Metropolitan
                    </label>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-check form-check-custom form-check-solid">
                    <input class="form-check-input" type="radio" value="regional" name="stateType"
                    {{ isset($site_data) && $site_data->stateType == 'regional' ? 'checked' : '' }} />
                    <label class="form-check-label" for="flexRadioChecked">
                        Regional
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
@if(isset($settings['payroll']) && $settings['payroll'] == 1)
<div class="col-sm-12 col-md-6" {{$display}}>
    <div class="fv-row mb-9">
        <label class="fs-6 fw-bold mb-2">Payroll</label>
        <select class="form-select form-select-lg form-select-solid" data-control="select2"
        data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" id="payrol"
        name="payrol">
        <option value="Default Rates"
        {{ isset($site_data) && $site_data->payrol == 'Default Rates' ? 'selected' : '' }}>Default
    Rates</option>
    <option value="Award Rates"
    {{ isset($site_data) && $site_data->payrol == 'Award Rates' ? 'selected' : '' }}>Award
Rates</option>

<option value="EBA Rates"
{{ isset($site_data) && $site_data->payrol == 'EBA Rates' ? 'selected' : '' }}>EBA
Rates</option>
@if(isset($site_data) && $site_data->payrol == 'EBA/Award Rates')
<option value="EBA/Award Rates"
{{ isset($site_data) && $site_data->payrol == 'EBA/Award Rates' ? 'selected' : '' }}>EBA/Award
Rates</option>
@endif
</select>
</div>
</div>
@endif
@if (isset($item->site_hours) && $item->site_hours == 1)
<div class="col-sm-12 col-md-6">
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-bold required mb-2">Site hours</label>
        <!--end::Label-->
        <select class="form-select form-select-lg form-select-solid" data-control="select2"
        data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" id="site_hours"
        name="site_hours">
        <option value="" {{ isset($site_data) && $site_data->site_hours == '' ? 'selected' : '' }}>
        Select</option>
        <option value="adhoc" {{ isset($site_data) && $site_data->site_hours == 'adhoc' ? 'selected' : '' }}>
        Adhoc</option>
        <option value="permanent"
        {{ isset($site_data) && $site_data->site_hours == 'permanent' ? 'selected' : '' }}>Permanent
    </option>
</select>
</div>
<!--end::Input group-->
</div>
@endif

</div>
@if(config('custom.own_payrates') == 0)
<div class="row" {{$display}}>
    @if(isset($settings['custom_payrates']) && $settings['custom_payrates'] == 1)
    <div class="form-check form-check-custom form-check-solid me-10">
        <input class="form-check-input h-30px w-30px" type="checkbox" value="1" id="custom_payrate" name="custom_payrate"  {{isset($site_data) && $site_data->custom_payrate == 1 ? 'checked' : '' }}>
        <label class="form-check-label" for="custom_payrate">
            Custom Payrate
        </label>
    </div>
    <div class="own_payrates_div" style="display:{{isset($site_data) && $site_data->custom_payrate == 1 ? '' : 'none' }};">
            
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
                                <div class="rTableRow" style="display:none">
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
    @endif
    <div class="col-sm-12 col-md-6 payrates" style="display:{{isset($site_data) && $site_data->custom_payrate == 1 ? 'none' : '' }};">
        <div class="fv-row mb-9">

            <!--begin::Label-->
            <label class="fs-6 fw-bold  mb-2">Pay Rates Level</label>
            <!--end::Label-->
            <select onchange="load_payrates({{ isset($site_data) ? $site_data->id : true;}})" class="form-select form-select-lg form-select-solid"
                name="site_payrate_level" id="site_payrate_level">
                <option>Select level</option>
                <option value="1"
                {{ isset($site_data) && $site_data->site_payrate_level == '1' ? 'selected' : '' }}>1</option>
                <option value="2"
                {{ isset($site_data) && $site_data->site_payrate_level == '2' ? 'selected' : '' }}>2</option>
                <option value="3"
                {{ isset($site_data) && $site_data->site_payrate_level == '3' ? 'selected' : '' }}>3</option>
                <option value="4"
                {{ isset($site_data) && $site_data->site_payrate_level == '4' ? 'selected' : '' }}>4</option>
                <option value="5"
                {{ isset($site_data) && $site_data->site_payrate_level == '5' ? 'selected' : '' }}>5</option>
            </select>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 payrates" {{$display}} style="display:{{isset($site_data) && $site_data->custom_payrate == 1 ? 'none' : '' }};">
        <div class="fv-row mb-9">

            <!--begin::Label-->
            <label class="fs-6 fw-bold  mb-2">Pay rates</label>
            <!--end::Label-->

            <select class="form-select form-select-lg form-select-solid" id="site_payrate" name="site_payrate"
            onchange="$('#payrate_change').val(1); $('#apply_date_div_check').css('display', '')">

        </select>
    </div>
</div>

<div class="col-sm-12 col-md-6" id="apply_date_div_check" style="display: none;">
    <div class="fv-row mb-9">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="form-check form-check-custom form-check-solid">
                    <input class="form-check-input" type="radio" value="same" name="apply_date_check" />
                    <label class="form-check-label" for="flexRadioChecked">
                        Same Day
                    </label>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-check form-check-custom form-check-solid">
                    <input class="form-check-input" type="radio" value="different" name="apply_date_check" />
                    <label class="form-check-label" for="flexRadioChecked">
                        Different Date
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="col-sm-12 col-md-12 apply_date_div" style="display: none;">
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-bold  mb-2">Apply From Date</label>
        <!--end::Label-->
        <input class="form-control" id="apply_date" name="apply_date" type="date"
        onchange="$('#payrate_change').val(1)"
        value="{{ isset($site_data) && $site_data->apply_date != '' ? $site_data->apply_date : '' }}">
        <input class="form-control" id="payrate_change" name="payrate_change" type="hidden">
    </div>
</div>

<div class="col-sm-12 col-md-12 apply_date_div" style="display: none;">
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-bold  mb-2">Apply to Date</label>
        <!--end::Label-->
        <input class="form-control" id="apply_to_date" name="apply_to_date" type="date"
        onchange="$('#payrate_change').val(1)"
        value="{{ isset($site_data) && $site_data->apply_to_date != '' ? $site_data->apply_to_date : '' }}">
    </div>
</div>
</div>
@else
<div class="row">
<div class="col-6 fv-row mb-9 custom-rates-input">
        <!--begin::Label-->
        <label class="fs-6 fw-bold required mb-2">Payrate</label>
        <!--end::Label-->
        <select class="form-select form-select-lg form-select-solid"
        data-control="select2" data-placeholder="Select..." data-allow-clear="true"
        data-hide-search="true" id="own_payrate" name="payrate_type">
        <option value="">Select</option>
        <option value="eba" {{ isset($site_data) && $site_data->site_payrate_type == 'eba' ? 'selected' : '' }}>EBA</option>
        <option value="award" {{ isset($site_data) && $site_data->site_payrate_type == 'award' ? 'selected' : '' }}>Award</option>
        <option value="abn" {{ isset($site_data) && $site_data->site_payrate_type == 'abn' ? 'selected' : '' }}>Default/ABN</option>
        <!-- <option value="custom">Custom</option> -->
    </select>
</div>
<div class="col-6 fv-row mb-9 custom-rates-selection" style="display:{{isset($site_data) && $site_data->site_payrate_type != '' ? '' : 'none' }};">
        <!--begin::Label-->
        <label class="fs-6 fw-bold required mb-2">Select Payrate</label>
        <!--end::Label-->
        <select class="form-select form-select-lg form-select-solid"
        data-control="select2" data-placeholder="Select..." data-allow-clear="true"
        data-hide-search="true" id="payrate_id" name="payrate_id">
        <option value="">Select</option>
        @foreach($payrates as $p)
        <option value="{{$p->id}}" {{(isset($site_data) && $site_data->site_payrate == $p->id ? 'selected' : '')}}>{{$p->title}}</option>
        @endforeach
    </select>
</div>
</div>
@endif
@if (isset($item->charge_rates_and_level) && $item->charge_rates_and_level == 1)
<div class="row">
    <div class="col-sm-12 col-md-6" {{$display}}>
        @if(session()->has('isAdmin') && session()->has('isAdmin') == 1)
        <div class="form-check form-check-custom form-check-solid me-10">
        <input class="form-check-input h-30px w-30px" type="checkbox" value="1" id="custom_chargerate" name="custom_chargerate"  {{isset($site_data) && $site_data->custom_chargerate == 1 ? 'checked' : '' }}>
        <label class="form-check-label" for="custom_chargerate">
            Custom Chargerate
        </label>
    </div>
    <div class="own_chargerate_div" style="display:{{isset($site_data) && $site_data->custom_chargerate == 1 && session()->has('isAdmin') && session()->has('isAdmin') == 1 ? '' : 'none' }};">
            
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
                                    <div class="rTableCell text-center">Saturday </div>
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
        <div class="fv-row mb-9 chargerate" style="display:{{isset($site_data) && $site_data->custom_chargerate == 1 ? 'none' : '' }};">

            <!--begin::Label-->
            <label class="fs-6 fw-bold  mb-2">Charge Rates Level</label>
            <!--end::Label-->
            <select onchange="load_chargerates()" class="form-select form-select-lg form-select-solid"
            name="site_chargerate_level" id="site_chargerate_level">
            <option>Select level</option>
            <option value="1"
            {{ isset($site_data) && $site_data->site_chargerate_level == '1' ? 'selected' : '' }}>1
        </option>
        <option value="2"
        {{ isset($site_data) && $site_data->site_chargerate_level == '2' ? 'selected' : '' }}>2
    </option>
    <option value="3"
    {{ isset($site_data) && $site_data->site_chargerate_level == '3' ? 'selected' : '' }}>3
</option>
<option value="4"
{{ isset($site_data) && $site_data->site_chargerate_level == '4' ? 'selected' : '' }}>4
</option>
<option value="5"
{{ isset($site_data) && $site_data->site_chargerate_level == '5' ? 'selected' : '' }}>5
</option>
</select>
</div>
</div>
<div class="col-sm-12 col-md-6 chargerate" {{$display}} style="display:{{isset($site_data) && $site_data->custom_chargerate == 1 ? 'none' : '' }};"> 
    <div class="fv-row mb-9">

        <!--begin::Label-->
        <label class="fs-6 fw-bold  mb-2">Charge rates</label>
        <!--end::Label-->

        <select class="form-select form-select-lg form-select-solid" id="site_charge_rate"
        name="site_charge_rate"
        onchange="$('#charge_change').val(1); $('#charge_apply_date_div_check').css('display', '')">

    </select>
</div>
</div>
<div class="col-sm-12 col-md-6" id="charge_apply_date_div_check" style="display: none;">
    <div class="fv-row mb-9">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="form-check form-check-custom form-check-solid">
                    <input class="form-check-input" type="radio" value="same"
                    name="charge_apply_date_check" />
                    <label class="form-check-label" for="flexRadioChecked">
                        Same Day
                    </label>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-check form-check-custom form-check-solid">
                    <input class="form-check-input" type="radio" value="different"
                    name="charge_apply_date_check" />
                    <label class="form-check-label" for="flexRadioChecked">
                        Different Date
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-sm-12 col-md-12" id="charge_apply_date_div" style="display: none;">
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-bold  mb-2">Apply Date</label>
        <!--end::Label-->
        <input class="form-control" id="charge_apply_date" name="charge_apply_date" type="date"
        onchange="$('#charge_change').val(1)"
        value="{{ isset($site_data) && $site_data->charge_apply_date != '' ? $site_data->charge_apply_date : '' }}">
        <input class="form-control" id="charge_change" name="charge_change" type="hidden">
    </div>
</div>
</div>
@endif

<div class="row">
	@if (isset($item->signin_radius) && $item->signin_radius == 1)
	<div class="col-sm-12 col-md-6">
        <!--begin::Input group-->
        <div class="fv-row mb-9">
            <!--begin::Label-->
            <label class="fs-6 fw-bold mb-2">Sign-in Radius (Meters)</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="number" class="form-control form-control-solid" placeholder="" name="signin_radius"
            id="signin_radius" value="{{ isset($site_data) ? $site_data->signin_radius : '' }}" />
            <!--end::Input-->
        </div>
    </div>
    @endif
    @if (isset($item->radius_alert) && $item->radius_alert == 1)
    <div class="col-sm-12 col-md-6">

        <div class="fv-row mb-9">
            <!--begin::Label-->
            <label class="fs-6 fw-bold mb-2">Radius Alert (Meters)</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="number" class="form-control form-control-solid" placeholder="" name="radius_alert"
            id="radius_alert" value="{{ isset($site_data) ? $site_data->alert_radius : '' }}" />
            <!--end::Input-->
        </div>

    </div>
    @endif
    <!--begin::Input group-->
    
</div>

<!--begin::Input group-->
@if (isset($item->start_end_date) && $item->start_end_date == 1)
<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="fv-row mb-9">
            <!--begin::Label-->
            <label class="fs-6 fw-bold mb-2">Start Date</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="text" class="form-control form-control-solid date-picker" placeholder=""
            name="site_start_date" id="site_start_date" required=""
            value="{{ isset($site_data) ? $site_data->start : '' }}" />
            <!--end::Input-->
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <!--begin::Input group-->
        <div class="fv-row mb-9">
            <!--begin::Label-->
            <label class="fs-6 fw-bold mb-2">End Date</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="text" class="form-control form-control-solid date-picker" placeholder=""
            name="site_end_date" id="site_end_date" value="{{ isset($site_data) ? $site_data->end : '' }}" />
            <!--end::Input-->
        </div>
    </div>
</div>
@endif
@if(isset($settings['job_instrcution_file']) && $settings['job_instrcution_file'] == 1)

<div class="fv-row mb-9">
    <!--begin::Label-->
    <label class="fs-6 fw-bold mb-2">Job Instrcutions File</label>
    @if(isset($site_data) && $site_data->job_instruction_file != '')
    <a href="{{config('custom.asset_url').$site_data->job_instruction_file}}" target="_blank" class="btn btn-sm btn-success"><i class="fas fa-file"></i></a>
    <a class="btn btn-sm btn-danger" onclick="deleteFile({{$site_data->id}})"><i class="fas fa-trash"></i></a>
    @endif
    <!--end::Label-->
    <!--begin::Input-->
    <input type="file" name="job_instruction_file" id="job_instruction_file" class="form-control" accept="application/pdf">

    <!--end::Input-->
</div>
@endif
@if (isset($item->job_instrcutions) && $item->job_instrcutions == 1)
<div class="fv-row mb-9">
    <!--begin::Label-->
    <label class="fs-6 fw-bold mb-2">Job Instrcutions</label>
    <!--end::Label-->
    <!--begin::Input-->
    <textarea class="form-control form-control-solid" name="instrcutions" id="instrcutions">{{ isset($site_data) ? $site_data->details : '' }}</textarea>
    <!--end::Input-->
</div>
@endif
@if (isset($item->sos_phone) && $item->sos_phone == 1)
<div class="fv-row mb-9">
    <!--begin::Label-->
    <label class="fs-6 fw-bold mb-2">SOS Phone</label>
    <!--end::Label-->
    <!--begin::Input-->
    <input type="text" class="form-control form-control-solid" placeholder="" name="sos_phone" id="sos_phone"
    value="{{ isset($site_data) ? $site_data->sos_phone : '' }}" />
    <!--end::Input-->
</div>
@endif
<div class="fv-row mb-9">
    <!--begin::Label-->
    <label class="fs-6 fw-bold mb-2">Address</label>
    <!--end::Label-->
    <!--begin::Input-->
    <input type="text" class="form-control form-control-solid" placeholder="" name="address"
    id="googleaddressSearch" required="" value="{{ isset($site_data) ? $site_data->address : '' }}" />
    <!--end::Input-->
</div>
@if(isset($settings['coordinates']) && $settings['coordinates'] == 1)

<div class="fv-row mb-9">
    <!--begin::Label-->
    <label class="fs-6 fw-bold mb-2">Coordinates</label>
    <!--end::Label-->
    <!--begin::Input-->
    <input type="text" class="form-control form-control-solid" placeholder="" name="coordinates"
    id="coordinates" readonly="" value="{{ isset($site_data) ? $site_data->coordinates : '' }}" />
    <!--end::Input-->
</div>
@endif
<div class="fv-row mb-9">
    <!--begin::Label-->
    <label class="fs-6 fw-bold mb-2">P.O/W.O</label>
    <!--end::Label-->
    <!--begin::Input-->
    <input type="text" class="form-control form-control-solid" name="pw_order"
    id="pw_order" value="{{ isset($site_data) ? $site_data->pw_order : '' }}" />
    <!--end::Input-->
</div>
@if (isset($item->tasks) && $item->tasks == 1)
<div class="fv-row mb-9">
    <label class="fs-6 fw-bold mb-2">Tasks(Optional)</label>
    <button type="button" class="btn-primary btn-sm" onclick="site_tasks()"> + Add tasks for site </button>
    <br>
    <div id="tasks_div">
        <?php if(isset($site_data) && $site_data->site_tasks != null){
           $tasks = json_decode($site_data->site_tasks,true);
           foreach ( $tasks as $key => $task ){
              ?>
              <input value="{{ $task }}" type="text" class="form-control form-control-solid" placeholder=""
              name="site_tasks[{{ $key }}]" id="site_tasks_{{ $key }}" />
              <?php	
          }
      }
      ?>
      <input type="hidden"
      value="{{ isset($site_data) && $site_data->site_tasks != null ? count(json_decode($site_data->site_tasks)) : 0 }}"
      id="task_index">

  </div>
</div>
@endif

<script type="text/javascript">
    function site_tasks() {
        var index = parseInt($('#task_index').val());
        var html =
        `<input placeholder="Enter site tasks here .." type="text" class="form-control form-control-solid" placeholder="" name="site_tasks[${index}]" id="site_tasks_${index}"/>`;
        $('#tasks_div').append(html);
        var new_index = index + 1;
        $('#task_index').val(new_index);
    }
    $('.date-picker').flatpickr({
        enableTime: !1,
        dateFormat: "Y-m-d"
    });
    var searchInput = 'googleaddressSearch';
    var componentForm = {
        // street_number: 'short_name',
        // route: 'long_name',
        locality: 'long_name',
        administrative_area_level_2: 'short_name',
        administrative_area_level_1: 'long_name',
        // country: 'long_name'
    };
    $(document).ready(function() {
        @if (isset($site_data))
        load_chargerates("{{ $site_data->site_charge_rate }}");
        load_payrates("{{ $site_data->id }}");
        setTimeout(function() {
            $('#site_payrate').val("{{ $site_data->site_payrate }}");
            $('#site_charge_rate').val("{{ $site_data->site_charge_rate }}");
        }, 2000);
        @endif
        // Make sure to update this after DOM is loaded
        var searchInput = document.getElementById('googleaddressSearch'); // Correct input element ID
    
        // Options for the Place Autocomplete
        var options = {
            types: ['geocode'],
            componentRestrictions: { country: 'au' } // Example: Restrict to Australia
        };

        // Create the autocomplete object correctly
        var autocomplete = new google.maps.places.PlaceAutocompleteElement(searchInput, options);
        
        // Add event listener for 'place_changed' event
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var near_place = autocomplete.getPlace();
            
            // Check if geometry data is available
            if (!near_place.geometry) {
                console.log("No details available for the input: " + near_place.name);
                return;
            }

            // Log the address components for debugging
            console.log(near_place.address_components);

            // Extract latitude and longitude
            var latitude = near_place.geometry.location.lat();
            var longitude = near_place.geometry.location.lng();
            var latlng = latitude + "," + longitude;

            // Set the values for coordinates input fields
            $("#coordinate_display").val(latlng);
            $("#coordinates").val(latlng);

            // Fill in address components
            var componentForm = {
                locality: 'long_name',
                administrative_area_level_2: 'short_name',
                administrative_area_level_1: 'long_name'
            };
            
            for (var i = 0; i < near_place.address_components.length; i++) {
                var addressType = near_place.address_components[i].types[0];
                if (componentForm[addressType]) {
                    var val = near_place.address_components[i][componentForm[addressType]];
                    document.getElementById(addressType).value = val;
                }
            }
        });
    });
    $('input[type=radio][name=welfare_call]').change(function() {
        if (this.value == 'yes') {
            $('.welfare_timing').css('display', '')
        } else if (this.value == 'no') {
            $('.welfare_timing').css('display', 'none')
        }
    });


    $('input[type=radio][name=charge_apply_date_check]').change(function() {
        if (this.value == 'different') {
            $('#charge_apply_date_div').css('display', '');
        } else {
            var today = new Date();
            today = moment(today).format('YYYY-MM-DD');
            $('#charge_apply_date_div').css('display', 'none');
            $('#charge_apply_date').val(today)
        }
    });

    $('input[type=radio][name=apply_date_check]').change(function() {
        if (this.value == 'different') {
            $('.apply_date_div').css('display', '');
        } else {
            var today = new Date();
            today = moment(today).format('YYYY-MM-DD');
            $('.apply_date_div').css('display', 'none');
            $('#apply_date').val(today)
        }
    });
    $('input[type=radio][name=site_break]').change(function() {
        console.log(this.value)
        if (this.value == '1') {
            $('.break-div').css('display', '')
        } else if (this.value == '0') {
            $('.break-div').css('display', 'none')
            $('.payable-time-div').css('display', 'none')
            $('.chargeable-time-div').css('display', 'none');
            $('input[type=radio][name=payable]').filter('[value="yes"]').prop('checked', true)
            $('input[type=radio][name=chargeable]').filter('[value="yes"]').prop('checked', true)
        }
    });
    $('input[type=radio][name=payable]').change(function() {
        if (this.value == 'no') {
            $('.payable-time-div').css('display', '')
        } else if (this.value == 'yes') {
            $('.payable-time-div').css('display', 'none')
        }
    });
    $('input[type=radio][name=chargeable]').change(function() {

        if (this.value == 'no') {
            $('.chargeable-time-div').css('display', '')
        } else if (this.value == 'yes') {
            $('.chargeable-time-div').css('display', 'none')
        }
    });

    function pay_charge_history(type) {
        if (type == 'payrate') {
            var id = $('#site_id').val();
        } else {
            var id = $('#site_id').val();
        }
        if (id == null || id == 'Select') {
            Swal.fire({
                text: 'No History',
                icon: "error",
                buttonsStyling: !1,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn btn-light"
                }
            })
        } else {
            $.ajax({
                type: "POST",
                url: "{{ url('job/pay_charge_history') }}",
                data: {
                    type: type,
                    id: id
                },
                success: function(result) {
                    if (result.success) {
                        $('#kt_modal_pay_charge_history').modal('show');
                        $('#pay-charge-html').html(result.html);

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
        }
    }

    function confirmDate() {
        $('#payrate_change').val(1);
        Swal.fire({
            text: "Apply Date?",
            icon: "success",
            showCancelButton: !0,
            buttonsStyling: !1,
            confirmButtonText: "Same Day",
            cancelButtonText: "Different Date",
            customClass: {
                confirmButton: "btn fw-bold btn-success",
                cancelButton: "btn fw-bold btn-active-light-primary"
            }
        }).then((function(e) {
            if (e.value == true) {
                var today = new Date();
                today = moment(today).format('YYYY-MM-DD');
                $('#apply_date_div').css('display', 'none');
                $('#apply_date').val(today)

            } else {
                //   		Swal.fire({
                //     title: "Apply Date",
                //     text: '',
                //     // input: 'text',
                //     html : '<input type="text" id="datetimepicker" class="form-control">',
                //     showCancelButton: true        
                // }).then((result) => {
                //     if (result.value) {
                //         console.log("Result: " + result.value);
                //     }
                // });
                $('#apply_date_div').css('display', '');
            }
        }));
    }

    function confirmDateChargerate() {
        $('#charge_change').val(1);
        Swal.fire({
            text: "Apply Date?",
            icon: "success",
            showCancelButton: !0,
            buttonsStyling: !1,
            confirmButtonText: "Same Day",
            cancelButtonText: "Different Date",
            customClass: {
                confirmButton: "btn fw-bold btn-success",
                cancelButton: "btn fw-bold btn-active-light-primary"
            }
        }).then((function(e) {
            if (e.value == true) {
                var today = new Date();
                today = moment(today).format('YYYY-MM-DD');
                $('#charge_apply_date_div').css('display', 'none');
                $('#charge_apply_date').val(today)

            } else {
                $('#charge_apply_date_div').css('display', '');
            }
        }));
    }
    $('#custom_payrate').on('change', function(){
        if (document.getElementById('custom_payrate').checked == true)
        {
            $('.payrates').css('display', 'none');
            $('.own_payrates_div').css('display','');
        }else{
            $('.payrates').css('display', '');
            $('.own_payrates_div').css('display','none');
        }
    });
    $('#custom_chargerate').on('change', function(){
        if (document.getElementById('custom_chargerate').checked == true)
        {
            $('.chargerate').css('display', 'none');
            $('.own_chargerate_div').css('display','');
        }else{
            $('.chargerate').css('display', '');
            $('.own_chargerate_div').css('display','none');
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
</script>
