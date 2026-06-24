@section('documents')
<div class="tab-pane fade" id="kt_user_view_documents_tab" role="tabpanel">
    <!--begin::Card-->
    <div class="card pt-4 mb-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0">

            <!--begin::Card-->
            <div class="card card-flush h-md-100">
                <!--begin::Card header-->
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-1">
                    <!--begin::Users-->
                    <!--begin::Permissions-->

                    <!-- if uploaded end -->
                    <!-- if not uploaded start -->
                    <form id="documents-form" class="form" action="{{url('contractor/documents_form')}}" method="POST"
                        enctype="multipart/form-data"> @csrf
                        <div class="row">
                            <div class="col-6 col-sm-6 col-xl">
                                <!--begin::Card-->
                                <div class="card-header border-0">
                                    <!--begin::Card title-->
                                    <div class="card-title">
                                        <h2>Bussiness</h2>
                                    </div>
                                    <!--end::Card title-->
                                </div>
                                <div class="card h-100 flex-center">
                                    <div id="doc_businessfile" class="symbol symbol-60px mb-6 form-group row "
                                        style="display: none;">
                                        <div class="col-sm-6" style="float:left;">
                                            <a target="__blank" id="doc_businessfile_a" style="margin-left: 123px;">
                                                <img src="{{asset('')}}media/svg/files/doc.svg" alt="">

                                            </a>
                                        </div>
                                        <div class="col-sm-6" style="float:right;">

                                            <a type="button" style="margin-left: 90px;margin-top: -16px;"
                                                class="btn btn-primary"
                                                onclick="this.parentElement.parentElement.style.display = 'none';$('#div_businessfile').show();$('#business_abn_can_file').val('');$('#business_abn_can_number').val('');$('#business_abn_can_expiration').val( '')">
                                                X
                                            </a>

                                        </div>
                                    </div>
                                    <div class="form-group files" id="div_businessfile">

                                        <input accept="image/png, image/gif, image/jpeg" type="file"
                                            onchange="upload_file('businessfile', 'business_abn_can_file')"
                                            class="form-control form-control-md" id="businessfile" name="businessfile">
                                        <input type="hidden" name="business_abn_can_file" id="business_abn_can_file">
                                    </div>


                                    <!-- 
                                        type="file" class="form-control" multiple=""  class="form-control form-control-md" id="business_abn_can_file" name="business_abn_can_file" > </div> -->
                                    <div class=" form-group">
                                        <label for="recipient-name" class="col-form-label">Business ABN/ACN</label>
                                        <input type="text" class="form-control form-control-md"
                                            name="business_abn_can_number" id="business_abn_can_number" value="">
                                        <label for="recipient-name" class="col-form-label">Business ABN/ACN
                                            Expiration</label>
                                        <input type="date" class="form-control form-control-md"
                                            name="business_abn_can_expiration" id="business_abn_can_expiration"> </div>
                                </div>
                            </div>
                            <div class="col-6 col-sm-6 col-xl">
                                <!--begin::Card-->
                                <div class="card-header border-0">
                                    <!--begin::Card title-->
                                    <div class="card-title">
                                        <h2>Security</h2>
                                    </div>
                                    <!--end::Card title-->
                                </div>
                                <div class="card h-100 flex-center">
                                    <div id="doc_securityfile" class="symbol symbol-60px mb-6 form-group row"
                                        style="display: none;">
                                        <div class="col-sm-6" style="float:left;">
                                            <a target="__blank" id="doc_securityfile_a" style="margin-left: 123px;">
                                                <img src="{{asset('')}}media/svg/files/doc.svg" alt="">

                                            </a>
                                        </div>
                                        <div class="col-sm-6" style="float:right;">

                                            <a type="button" style="margin-left: 90px;margin-top: -16px;"
                                                class="btn btn-primary"
                                                onclick="this.parentElement.parentElement.style.display = 'none';$('#div_securityfile').show();$('#security_license_file').val('');$('#security_license_number').val('');$('#security_license_expiration').val( '')">
                                                X
                                            </a>

                                        </div>





                                    </div>
                                    <div class="form-group files" id="div_securityfile">

                                        <input type="file" accept="image/png, image/gif, image/jpeg" type="file"
                                            onchange="upload_file('securityfile', 'security_license_file')"
                                            class="form-control form-control-md" id="securityfile" name="securityfile">
                                        <input type="hidden" name="security_license_file" id="security_license_file">
                                    </div>

                                    <!-- 
                                         class="form-control" multiple=""  class="form-control form-control-md" id="security_license_file" name="security_license_file" > </div> -->
                                    <div class=" form-group">
                                        <label for="recipient-name" class="col-form-label">Security license
                                            number</label>
                                        <input type="text" class="form-control form-control-md"
                                            name="security_license_number" id="security_license_number">
                                        <label for="recipient-name" class="col-form-label">Security license
                                            expiration</label>
                                        <input type="date" class="form-control form-control-md"
                                            name="security_license_expiration" id="security_license_expiration"> </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <br>
                        <br>

                        <div class="row">
                            <div class="col-6 col-sm-6 col-xl">
                                <div class="card-header border-0">
                                    <div class="card-title">
                                        <h2>Public Liablity</h2>
                                    </div>
                                </div>
                                <div class="card h-100 flex-center">
                                    <div id="doc_publicfile" class="symbol symbol-60px mb-6 form-group row"
                                        style="display: none;">
                                        <div class="col-sm-6" style="float:left;">
                                            <a target="__blank" id="doc_publicfile_a" style="margin-left: 123px;">
                                                <img src="{{asset('')}}media/svg/files/doc.svg" alt="">

                                            </a>
                                        </div>
                                        <div class="col-sm-6" style="float:right;">
                                            <a type="button" style="margin-left: 90px;margin-top: -16px;"
                                                class="btn btn-primary"
                                                onclick="this.parentElement.parentElement.style.display = 'none';$('#div_publicfile').show();$('#public_liability_file').val('');$('#public_liability_number').val('');$('#public_liability_expiration').val( '')">
                                                X
                                            </a>
                                        </div>
                                    </div>
                                    <div class="form-group files" id="div_publicfile">
                                        <input type="file" accept="image/png, image/gif, image/jpeg" type="file"
                                            onchange="upload_file('publicfile', 'public_liability_file')"
                                            class="form-control form-control-md" id="publicfile" name="publicfile">
                                        <input type="hidden" name="public_liability_file" id="public_liability_file">
                                    </div>
                                    <div class=" form-group">
                                        <label for="recipient-name" class="col-form-label">Public liability
                                            number</label>
                                        <input type="text" class="form-control form-control-md"
                                            name="public_liability_number" id="public_liability_number">
                                        <label for="recipient-name" class="col-form-label">Public liability
                                            expiration</label>
                                        <input type="date" class="form-control form-control-md"
                                            name="public_liability_expiration" id="public_liability_expiration"> 
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" class="form-control form-control-md" name="contractor_id"
                                value="{{$contractor_id}}">
                            <div class="col-6 col-sm-6 col-xl">
                                <div class="card-header border-0">
                                    <div class="card-title">
                                        <h2>Labour Hire</h2>
                                    </div>
                                </div>
                                <div class="card h-100 flex-center">
                                    <div id="doc_labourfile" class="symbol symbol-60px mb-6 form-group row"
                                        style="display: none;">

                                        <div class="col-sm-6" style="float:left;">
                                            <a target="__blank" id="doc_labourfile_a" style="margin-left: 123px;">
                                                <img src="{{asset('')}}media/svg/files/doc.svg" alt="">

                                            </a>
                                        </div>
                                        <div class="col-sm-6" style="float:right;">

                                            <a type="button" style="margin-left: 90px;margin-top: -16px;"
                                                class="btn btn-primary"
                                                onclick="this.parentElement.parentElement.style.display = 'none';$('#div_labourfile').show();$('#labour_hire_file').val('');$('#labour_hire_number').val('');$('#labour_hire_expiration').val( '')">
                                                X
                                            </a>

                                        </div>





                                    </div>
                                    <div class="form-group files" id="div_labourfile">
                                        <input type="file" accept="image/png, image/gif, image/jpeg" type="file"
                                            onchange="upload_file('labourfile', 'labour_hire_file')"
                                            class="form-control form-control-md" id="labourfile" name="labourfile">
                                        <input type="hidden" name="labour_hire_file" id="labour_hire_file">
                                    </div>
                                    <div class=" form-group">
                                        <label for="recipient-name" class="col-form-label">Labour hire number</label>
                                        <input type="text" class="form-control form-control-md"
                                            name="labour_hire_number" id="labour_hire_number">
                                        <label for="recipient-name" class="col-form-label">Labour hire
                                            expiration</label>
                                        <input type="date" class="form-control form-control-md"
                                            name="labour_hire_expiration" id="labour_hire_expiration"> 
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="doc_index_counter" name="doc_index_counter" value="0">
                            <div id="addMoreDocContainer" class="row" style="margin-top: 10%;">

                            </div>
                            <!-- <div class="col-6 col-sm-6 col-xl"  id="addMoreDocContainer">
                            </div> -->
                            <div class="col-md-12 form-group" style="margin-top:17%" >
                                <button type="button" class="btn btn-info btn-sm btn-block _ac-add-more-doc-ids-btn"> Add More Documents
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-earmark-plus-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M2 2a2 2 0 0 1 2-2h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm7.5 1.5v-2l3 3h-2a1 1 0 0 1-1-1zM8.5 7a.5.5 0 0 0-1 0v1.5H6a.5.5 0 0 0 0 1h1.5V11a.5.5 0 0 0 1 0V9.5H10a.5.5 0 0 0 0-1H8.5V7z"/>
                                    </svg>
                                </button>

                            </div>
                            <div class="text-center" style="margin-top: 79px;">
                                <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit"> <span
                                        id="" class="indicator-label">Save</span> <span
                                        class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span> </span>
                                </button>
                            </div>
                        </div>

                    </form>

                </div>
                <!--end::Permissions-->
            </div>
            <!--end::Card body-->
            <!--begin::Card footer-->
            <!--  <div class="card-footer flex-wrap pt-0">
                                            <button type="button" class="btn btn-white btn-active-light-primary my-1" data-bs-toggle="modal" data-bs-target="#documents-modal" id="documents-modal-btn">Open Documents</button>
                                            

                                        </div> -->
            <!--end::Card footer-->
        </div>
        <!--end::Card-->
    </div>
</div>




























@stop
