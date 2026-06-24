@section('contacts')






<div class="tab-pane fade" id="kt_user_view_contacts_tab" role="tabpanel">
                                            <!--begin::Card-->
                                            <div class="card pt-4 mb-6 mb-xl-9">
                                                <!--begin::Card header-->
                                                <div class="card-header border-0">
                                                    <!--begin::Card title-->
                                                    <div class="card-title">
                                                        <h2>Contacts</h2>
                                                    </div>
                                                    <!--end::Card title-->
                                                </div>

                                    <!--begin::Card-->
                                    <div class="card card-flush h-md-100">
                                        <!--begin::Card header-->
                                        
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body pt-1">
                                            <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                            <!--begin::Table head-->
                            <thead>
                            <tr class="fw-bolder text-muted">
                                <th class="min-w-150px">Name</th>
                                <th class="min-w-140px">Email</th>
                                <th class="min-w-120px">Phone</th>
                                <th class="min-w-120px">Notes</th>
                            </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>
                                                       
                                    @foreach($contacts as $c)
<tr>
    <td>{{$c->name}}</td>
    <td>{{$c->email}}</td>
    <td>{{$c->phone}}</td>
    <td>{{$c->notes}}</td>
</tr>
                                            @endforeach                
                            </tbody>
                            <!--end::Table body-->
                        </table>
                       
                        <!--end::Table-->
                    </div>
                                            
                                         
                                        </div>
                                        <!--end::Card body-->
                                        <!--begin::Card footer-->

                                        <!--data-bs-target="#contacts-modal"  -->
                                        <div class="card-footer flex-wrap pt-0">
                                            <button type="button" class="btn btn-white btn-active-light-primary my-1" data-bs-toggle="modal"  id="documents-modal-btn"() onclick="getContacts()">Open Contacts</button>
                                            

                                        </div>
                                        <!--end::Card footer-->
                                    </div>
                                    <!--end::Card-->
                                </div>
                                </div>
                                




<div class="modal fade" id="contacts-modal" tabindex="-1" aria-hidden="true">
                                <!--begin::Modal dialog-->
                                <div class="modal-dialog modal-dialog-centered mw-750px">
                                    <!--begin::Modal content-->
                                    <div class="modal-content">
                                        <!--begin::Modal header-->
                                        <div class="modal-header">
                                            <!--begin::Modal title-->
                                            <h2 class="fw-bolder" id="form_head">Contacts</h2>
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


        <form id="contacts-form"  action="{{url('customer/save_contacts')}}" method="POST" enctype="multipart/form-data">
                                                    @csrf
 
  <input type="hidden" class="form-control form-control-md" name="customer_id" value="{{$customer_id}}">
  <input type="hidden" id="index_counter" name="index_counter" value="">
 <div id="contacts_container2">

</div>
    <div class="row ids-section" id="guard-ids-container">
													   
    </div>
        <div class="row ids-section">
            <div class="col-md-4 form-group"></div>
            <div class="col-md-4 form-group" style="margin-top:5%" >
                <button type="button" class="btn btn-info btn-sm btn-block _ac-add-more-ids-btn"> Add More Contacts
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-earmark-plus-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M2 2a2 2 0 0 1 2-2h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm7.5 1.5v-2l3 3h-2a1 1 0 0 1-1-1zM8.5 7a.5.5 0 0 0-1 0v1.5H6a.5.5 0 0 0 0 1h1.5V11a.5.5 0 0 0 1 0V9.5H10a.5.5 0 0 0 0-1H8.5V7z"/>
                    </svg>
                </button>

            </div>
        </div>
   <!--  <div class="row">
        <div class="col-md-4 form-group">
            <label for="recipient-name" class="col-form-label">Name</label>
            <input type="text" class="form-control form-control-md"  name="contact[1][name]">
        </div>
        <div class="col-md-4 form-group">
            <label for="recipient-name" class="col-form-label">Email</label>
            <input type="email" class="form-control form-control-md"  name="contact[1][email]">
        </div>
        <div class="col-md-4 form-group">
            <label for="recipient-name" class="col-form-label">Phone</label>
            <input type="phone" class="form-control form-control-md"  name="contact[1][phone]">
        </div>
    </div> -->

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
                

               
@stop