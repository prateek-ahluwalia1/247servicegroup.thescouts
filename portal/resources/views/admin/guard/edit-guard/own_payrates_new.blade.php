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

            <form id="pay-rates-form" class="form" action="{{ url('guard/save_guard_own_payrates_new') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="guard_id" value="{{ $guard_id }}">
            <div class="row mb-5">
                <div class="col-4">
                    <div class="form-check form-check-custom form-check-solid me-10">
                        <input class="form-check-input h-30px w-30px" type="radio" value="abn" id="pay_by" name="pay_by"  {{$guard_data['guard']->pay_by == 'abn' ? 'checked' : ''}}>
                        <label class="form-check-label" for="pay_by">
                            ABN
                        </label>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-check form-check-custom form-check-solid me-10">
                        <input class="form-check-input h-30px w-30px" type="radio" value="eba" id="pay_by" name="pay_by"  {{$guard_data['guard']->pay_by == 'eba' ? 'checked' : ''}}>
                        <label class="form-check-label" for="pay_by">
                            EBA
                        </label>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-check form-check-custom form-check-solid me-10">
                        <input class="form-check-input h-30px w-30px" type="radio" value="award" id="pay_by" name="pay_by" {{$guard_data['guard']->pay_by == 'award' ? 'checked' : ''}}>
                        <label class="form-check-label" for="pay_by">
                            Award
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4 form-group">
                    <div class="fv-row mb-10">
                        <label for="recipient-name" class="col-form-label">ABN Rate</label>
                        <select class="form-select form-select-lg form-select-solid"
                        data-placeholder="Select..." data-allow-clear="true" data-hide-search="true"
                        name="abn_id" id="abn_id" >
                        <option value="">Select</option>
                        @foreach($abn_rate as $abn)
                        <option value="{{$abn->id}}" {{$guard_data['guard']->abn_id == $abn->id ? 'selected' : ''}}>{{$abn->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-4 form-group">
                    <div class="fv-row mb-10">
                        <label for="recipient-name" class="col-form-label">EBA Rate</label>
                        <select class="form-select form-select-lg form-select-solid"
                        data-placeholder="Select..." data-allow-clear="true" data-hide-search="true"
                        name="eba_id" id="eba_id" >
                        <option value="">Select</option>
                        @foreach($eba_rate as $eba)
                        <option value="{{$eba->id}}" {{$guard_data['guard']->eba_id == $eba->id ? 'selected' : ''}}>{{$eba->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-4 form-group">
                    <div class="fv-row mb-10">
                        <label for="recipient-name" class="col-form-label">Award Rate</label>
                        <select class="form-select form-select-lg form-select-solid"
                        data-placeholder="Select..." data-allow-clear="true" data-hide-search="true"
                        name="award_id" id="award_id" >
                        <option value="">Select</option>
                        @foreach($award_rate as $award)
                        <option value="{{$award->id}}" {{$guard_data['guard']->award_id == $award->id ? 'selected' : ''}}>{{$award->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            
            </div>
             
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
