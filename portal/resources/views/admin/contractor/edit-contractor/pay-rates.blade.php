@section('pay-rates')



<div class="tab-pane fade" id="kt_user_view_pay_rates_tab" role="tabpanel">
                                            <!--begin::Card-->
                                            <div class="card pt-4 mb-6 mb-xl-9">
                                                <!--begin::Card header-->
                                                <div class="card-header border-0">
                                                    <!--begin::Card title-->
                                                    <div class="card-title">
                                                        <h2>Pay Rates</h2>
                                                    </div>
                                                    <!--end::Card title-->
                                                </div>

                                    <!--begin::Card-->
                                    <div class="card card-flush h-md-100">
                                        <!--begin::Card header-->
                                        
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body pt-1">
                                            <!--begin::Users-->
                                            <div class="fw-bolder text-gray-600 mb-5">Total features with this role</div>
                                            <!--end::Users-->
                                            <!--begin::Permissions-->
                                            <div class="d-flex flex-column text-gray-600">




                                                
                                            </div>
                                            <!--end::Permissions-->
                                        </div>
                                        <!--end::Card body-->
                                        <!--begin::Card footer-->
                                        <div class="card-footer flex-wrap pt-0">
                                            <button type="button" class="btn btn-white btn-active-light-primary my-1" id="pay-rates-modal-btn">Open Pay Rates</button>
                                            

                                        </div>
                                        <!--end::Card footer-->
                                    </div>
                                    <!--end::Card-->
                                </div>
                                </div>
                                <div class="tab-pane fade" id="kt_user_view_documents_tab" role="tabpanel">
                                            <!--begin::Card-->
                                            <div class="card pt-4 mb-6 mb-xl-9">
                                                <!--begin::Card header-->
                                                <div class="card-header border-0">
                                                    <!--begin::Card title-->
                                                    <div class="card-title">
                                                        <h2>Documents</h2>
                                                    </div>
                                                    <!--end::Card title-->
                                                </div>

                                    <!--begin::Card-->
                                    <div class="card card-flush h-md-100">
                                        <!--begin::Card header-->
                                        
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body pt-1">
                                            <!--begin::Users-->
                                            <div class="fw-bolder text-gray-600 mb-5">Total features with this role</div>
                                            <!--end::Users-->
                                            <!--begin::Permissions-->
                                            <div class="d-flex flex-column text-gray-600">




                                                <div class="d-flex align-items-center py-2">
                                                <span class="bullet bg-primary me-3"></span>Enabled Bulk Reports</div>
                                                <div class="d-flex align-items-center py-2">
                                                <span class="bullet bg-primary me-3"></span>View and Edit Payouts</div>
                                                <div class="d-flex align-items-center py-2">
                                                <span class="bullet bg-primary me-3"></span>View and Edit Disputes</div>
                                                <div class='d-flex align-items-center py-2'>
                                                    <span class='bullet bg-primary me-3'></span>
                                                    <em>and 7 more...</em>
                                                </div>
                                            </div>
                                            <!--end::Permissions-->
                                        </div>
                                        <!--end::Card body-->
                                        <!--begin::Card footer-->
                                        <div class="card-footer flex-wrap pt-0">
                                            <button type="button" class="btn btn-white btn-active-light-primary my-1" data-bs-toggle="modal" data-bs-target="#payrates-modal" id="documents-modal-btn">Open Documents</button>
                                            

                                        </div>
                                        <!--end::Card footer-->
                                    </div>
                                    <!--end::Card-->
                                </div>
                                </div>
                                




<div class="modal fade" id="payrates-modal" tabindex="-1" aria-hidden="true">
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
                                             <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                            
                                                <span class="svg-icon svg-icon-2x">X</span>
                                              </div>
                                                            <!--end::Close-->
                                                        </div>
                                                        <!--end::Modal header-->
                                                        <!--begin::Modal body-->
                                                       <div class="modal-body scroll-y mx-5 my-7">
                                                <!--begin::Form-->

                                                    <form id="pay-rates-form" class="form" action="{{url('contractor/save_charged_rates')}}" method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <input type="hidden" name="contractor_id" value="{{ $contractor_id; }}">
                                                    <div class="row rates-section" style="">
  
    <div class="col-md-3 form-group">
            <div class="fv-row mb-10">
        <label for="recipient-name" class="col-form-label">Job Level</label>
        <select class="form-select form-select-lg form-select-solid"  data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" name="job_level" id="job_level" onchange="load_payrates()">
            <option value="">Select</option>

            <option value="1">Level 1</option>
            <option value="2">Level 2</option>
            <option value="3">Level 3</option>
            <option value="4">Level 4</option>
            <option value="5">Level 5</option>
        </select>
    </div>
    </div>
    <div class="col-md-3 form-group">
        <div class="fv-row mb-10">
        <label for="recipient-name" class="col-form-label">State</label>
        <select class="form-select form-select-lg form-select-solid"  data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" name="payrates_state" id="payrates_state" onchange="load_payrates()">
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
      <div class="col-md-6">
             <div id="payrates_div" class="fv-row mb-10" >
        <label for="recipient-name" class="col-form-label">PayRates</label>
        <select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" name="charged_rates_id" id="charged_rates_id" >
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

@stop