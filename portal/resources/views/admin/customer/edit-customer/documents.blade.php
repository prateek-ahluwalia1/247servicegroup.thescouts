@section('documents')
<?php 
    $disabled = '';
    if (session()->get('userType') == 'customer')
    {
        $disabled = 'disabled';
    } 
?>
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
                    <form id="documents-form" class="form" action="{{url('customer/documents_form')}}" method="POST" enctype="multipart/form-data"> @csrf
                        <div class="row">
                            <div class="col-6 col-sm-6 col-xl">
                                <!--begin::Card-->
                                <div class="card-header border-0">
                                    <!--begin::Card title-->
                                    <div class="card-title">
                                        <h2>Bussiness</h2> </div>
                                    <!--end::Card title-->
                                </div>
                                <div class="card h-100 flex-center">
                                    <div  id="doc_businessfile" class="symbol symbol-60px mb-6 form-group row " style="display: none;">
                                         <div class="col-sm-6" style="float:left;">
                                                <a target="__blank"  id="doc_businessfile_a" style="margin-left: 123px;">
                                     <img src="{{asset('')}}media/svg/files/doc.svg" alt="">

                                                </a>
                                        </div>
                                        <div class="col-sm-6" style="float:right;">

                                             <a type="button" style="margin-left: 90px;margin-top: -16px;" class="btn btn-primary" onclick="this.parentElement.parentElement.style.display = 'none';$('#div_businessfile').show();$('#business_abn_can_file').val('');$('#business_abn_can_number').val('');$('#business_abn_can_expiration').val( '')">
                                            X
                                        </a>
                                            
                                        </div>

                                   

                                           
                                       
                                 </div>
                                    <div class="form-group files" id="div_businessfile">

                                        <input {{$disabled}} accept="image/png, image/gif, image/jpeg" type="file" onchange="upload_file('businessfile', 'business_abn_can_file')" class="form-control form-control-md" id="businessfile" name="businessfile" > 
                                                            <input {{$disabled}} type="hidden" name="business_abn_can_file" id="business_abn_can_file">
                                                        </div>


<!-- 
                                        type="file" class="form-control" multiple=""  class="form-control form-control-md" id="business_abn_can_file" name="business_abn_can_file" > </div> -->
                                    <div class=" form-group">
                                        <label for="recipient-name" class="col-form-label">Business ABN/ACN</label>
                                        <input {{$disabled}} type="text" class="form-control form-control-md" name="business_abn_can_number" id="business_abn_can_number" value="">
                                        <label for="recipient-name" class="col-form-label">Business ABN/ACN Expiration</label>
                                        <input {{$disabled}} type="date" class="form-control form-control-md" name="business_abn_can_expiration" id="business_abn_can_expiration"> </div>
                                </div>
                            </div>
                            <div class="col-6 col-sm-6 col-xl">
                                <!--begin::Card-->
                                <div class="card-header border-0">
                                    <!--begin::Card title-->
                                    <div class="card-title">
                                        <h2>Security</h2> </div>
                                    <!--end::Card title-->
                                </div>
                                <div class="card h-100 flex-center">
                                    <div  id="doc_securityfile" class="symbol symbol-60px mb-6 form-group row" style="display: none;">
                                           <div class="col-sm-6" style="float:left;">
                                                <a target="__blank"  id="doc_securityfile_a" style="margin-left: 123px;">
                                     <img src="{{asset('')}}media/svg/files/doc.svg" alt="">

                                                </a>
                                        </div>
                                        <div class="col-sm-6" style="float:right;">

                                             <a type="button" style="margin-left: 90px;margin-top: -16px;" class="btn btn-primary" onclick="this.parentElement.parentElement.style.display = 'none';$('#div_securityfile').show();$('#security_license_file').val('');$('#security_license_number').val('');$('#security_license_expiration').val( '')">
                                            X
                                        </a>
                                            
                                        </div>

                                   

                                           
                                       
                                 </div>
                                    <div class="form-group files" id="div_securityfile">

                                        <input {{$disabled}} type="file" accept="image/png, image/gif, image/jpeg" type="file" onchange="upload_file('securityfile', 'security_license_file')" class="form-control form-control-md" id="securityfile" name="securityfile" > 
                                                            <input {{$disabled}} type="hidden" name="security_license_file" id="security_license_file">
                                                        </div>

<!-- 
                                         class="form-control" multiple=""  class="form-control form-control-md" id="security_license_file" name="security_license_file" > </div> -->
                                    <div class=" form-group">
                                        <label for="recipient-name" class="col-form-label">Security license number</label>
                                        <input {{$disabled}} type="text" class="form-control form-control-md" name="security_license_number" id="security_license_number">
                                        <label for="recipient-name" class="col-form-label">Security license expiration</label>
                                        <input {{$disabled}} type="date" class="form-control form-control-md" name="security_license_expiration" id="security_license_expiration"> </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <br>
                        <br>
                        
                        <div class="row">
                            <div class="col-6 col-sm-6 col-xl">
                                <!--begin::Card-->
                                <div class="card-header border-0">
                                    <!--begin::Card title-->
                                    <div class="card-title">
                                        <h2>Public Liablity</h2> 
                                    </div>
                                    <!--end::Card title-->
                                  </div>
                                <div class="card h-100 flex-center">
                                         <div  id="doc_publicfile" class="symbol symbol-60px mb-6 form-group row" style="display: none;">
                                           <div class="col-sm-6" style="float:left;">
                                                <a target="__blank"  id="doc_publicfile_a" style="margin-left: 123px;">
                                     <img src="{{asset('')}}media/svg/files/doc.svg" alt="">

                                                </a>
                                        </div>
                                        <div class="col-sm-6" style="float:right;">

                                             <a type="button" style="margin-left: 90px;margin-top: -16px;" class="btn btn-primary" onclick="this.parentElement.parentElement.style.display = 'none';$('#div_publicfile').show();$('#public_liability_file').val('');$('#public_liability_number').val('');$('#public_liability_expiration').val( '')">
                                            X
                                        </a>
                                            
                                        </div>

                                   

                                           
                                       
                                 </div>
                                    <div class="form-group files" id="div_publicfile">
                                        <input {{$disabled}} type="file"
                                        accept="image/png, image/gif, image/jpeg" type="file" onchange="upload_file('publicfile', 'public_liability_file')" class="form-control form-control-md" id="publicfile" name="publicfile" > 
                                                            <input {{$disabled}} type="hidden" name="public_liability_file" id="public_liability_file">
                                                        </div>
                                        <!--  class="form-control" multiple=""  class="form-control form-control-md" id="public_liability_file" name="public_liability_file" /> </div> -->
                                    <div class=" form-group">
                                        <label for="recipient-name" class="col-form-label">Public liability number</label>
                                        <input {{$disabled}} type="text" class="form-control form-control-md" name="public_liability_number" id="public_liability_number">
                                        <label for="recipient-name" class="col-form-label">Public liability expiration</label>
                                        <input {{$disabled}} type="date" class="form-control form-control-md" name="public_liability_expiration" id="public_liability_expiration"> </div>
                                </div>
                            </div>
                            <input {{$disabled}} type="hidden" class="form-control form-control-md" name="customer_id" value="{{$customer_id}}">
                            <div class="col-6 col-sm-6 col-xl">
                                <!--begin::Card-->
                                <div class="card-header border-0">
                                    <!--begin::Card title-->
                                    <div class="card-title">
                                        <h2>Labour Hire</h2> </div>
                                    <!--end::Card title-->
                                </div>
                                <div class="card h-100 flex-center">
                                     <div  id="doc_labourfile" class="symbol symbol-60px mb-6 form-group row" style="display: none;">
                                        
                                           <div class="col-sm-6" style="float:left;">
                                                <a target="__blank" id="doc_labourfile_a" style="margin-left: 123px;">
                                     <img src="{{asset('')}}media/svg/files/doc.svg" alt="">

                                                </a>
                                        </div>
                                        <div class="col-sm-6" style="float:right;">

                                             <a type="button" style="margin-left: 90px;margin-top: -16px;" class="btn btn-primary" onclick="this.parentElement.parentElement.style.display = 'none';$('#div_labourfile').show();$('#labour_hire_file').val('');$('#labour_hire_number').val('');$('#labour_hire_expiration').val( '')">
                                            X
                                        </a>
                                            
                                        </div>

                                   

                                           
                                       
                                 </div>
                                    <div class="form-group files" id="div_labourfile">

                                        <input {{$disabled}} type="file"   accept="image/png, image/gif, image/jpeg" type="file" onchange="upload_file('labourfile', 'labour_hire_file')" class="form-control form-control-md" id="labourfile" name="labourfile" > 
                                        <input {{$disabled}} type="hidden" name="labour_hire_file" id="labour_hire_file">

                                        <!--  class="form-control" multiple=""  class="form-control form-control-md" id="labour_hire_file" name="labour_hire_file" > 
 -->                                     </div>
                                    <div class=" form-group">
                                        <label for="recipient-name" class="col-form-label">Labour hire number</label>
                                        <input {{$disabled}} type="text" class="form-control form-control-md" name="labour_hire_number" id="labour_hire_number">
                                        <label for="recipient-name" class="col-form-label">Labour hire expiration</label>
                                        <input {{$disabled}} type="date" class="form-control form-control-md" name="labour_hire_expiration" id="labour_hire_expiration"> </div>
                                        </div>
                    </div>
                    @if (session()->get('userType') == 'admin') 
                    <div class="text-center" style="margin-top: 79px;">
                                        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit"> <span id="" class="indicator-label">Save</span> <span class="indicator-progress">Please wait...
                                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span> </span>
                                        </button>
                                    </div>
                                    @endif
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