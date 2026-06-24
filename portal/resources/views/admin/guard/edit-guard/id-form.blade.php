
@section('ID-form')
<?php 
	$progress = 0;
	if(isset($guard_data['ids']) && !empty($guard_data['ids']))
	{
		$progress = 100;
	}
?>
@if(session()->get('userType')=='admin')
	<div class="col-md-4">
									<!--begin::Card-->
									<div class="card card-flush h-md-100">
										<!--begin::Card header-->
										<div class="card-header">
											<!--begin::Card title-->
											<div class="card-title">
												<h2>ID</h2>
											</div>
											<!--end::Card title-->
										</div>
										<!--end::Card header-->
										<!--begin::Card body-->
										<div class="card-body pt-1">
											<!--begin::Users-->
											<!--end::Users-->
											<!--begin::Permissions-->
											<div class="d-flex flex-column text-gray-600">
												<div class="d-flex flex-column w-100 me-2">
																	<div class="d-flex flex-stack mb-2">
																		<span class="text-muted me-2 fs-7 fw-bold">{{$progress}}%</span>
																	</div>
																	<div class="progress h-6px w-100">
																		<div class="progress-bar bg-primary" role="progressbar" style="width: {{$progress}}%" aria-valuenow="{{$progress}}" aria-valuemin="0" aria-valuemax="100"></div>
																	</div>
																</div>
											</div>
											<!--end::Permissions-->
										</div>
										<!--end::Card body-->
										<!--begin::Card footer-->
										<div class="card-footer flex-wrap pt-0">
											<button type="button" class="btn btn-white btn-active-light-primary my-1" data-bs-toggle="modal"  id="ID-modal-btn">Open ID </button>
											

										</div>
										<!--end::Card footer-->
									</div>
									<!--end::Card-->
								</div>





<!-- modal  -->















<div class="modal fade" id="ID-modal" tabindex="-1" aria-hidden="true">
								<!--begin::Modal dialog-->
								<div class="modal-dialog modal-dialog-centered mw-750px">
									<!--begin::Modal content-->
									<div class="modal-content">
										<!--begin::Modal header-->
										<div class="modal-header">
											<!--begin::Modal title-->
											<h2 class="fw-bolder" id="form_head">ID</h2>
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


											<form id="ids-form" class="form" action="{{url('/save_ids_form')}}" method="POST" enctype="multipart/form-data">
																    @csrf
													<!--begin::Heading-->
													<div class="pb-10 pb-lg-15">
														<!--begin::Title-->
														<h2 class="fw-bolder text-dark">Internal ID</h2>
														<!--end::Title-->
													</div>

													<div class="row">
													<div class="col-md-4 form-group">
														<label for="name" class="col-form-label">Internal ID</label>
														<input type="text" class="form-control form-control-md" id="internal_id" name="internal_id" required value="{{ uniqid() }}" readonly=""> 
														<input type="hidden" class="form-control form-control-md" id="guard_id" name="guard_id" required value="{{ $guard_id }}"> 
													</div>
													</div>
													<div class="row ids-section" id="guard-ids-container">
													   
													</div>
													<div class="row ids-section">
													    <div class="col-md-4 form-group"></div>
													    <div class="col-md-4 form-group">
													        <button type="button" class="btn btn-info btn-sm btn-block _ac-add-more-ids-btn"> Add more IDs
													            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-earmark-plus-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
													                <path fill-rule="evenodd" d="M2 2a2 2 0 0 1 2-2h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm7.5 1.5v-2l3 3h-2a1 1 0 0 1-1-1zM8.5 7a.5.5 0 0 0-1 0v1.5H6a.5.5 0 0 0 0 1h1.5V11a.5.5 0 0 0 1 0V9.5H10a.5.5 0 0 0 0-1H8.5V7z"/>
													            </svg>
													        </button>

													    </div>
													</div>
												</br>
												<div class="pb-10 pb-lg-15">
														<!--begin::Title-->
														<h2 class="fw-bolder text-dark">Payroll ID</h2>
														<!--end::Title-->
													</div>
												{{-- <div class="row payroll-ids-section" id="guard-payroll-ids-container">
													   
													</div> --}}
													{{-- <div class="row payroll-ids-section">
													    <div class="col-md-4 form-group"></div>
													    <div class="col-md-4 form-group">
													        <button id="add_more_payroll" type="button" class="btn btn-info btn-sm btn-block _ac-add-more-payroll-ids-btn"> Add more Payroll IDs
													            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-earmark-plus-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
													                <path fill-rule="evenodd" d="M2 2a2 2 0 0 1 2-2h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm7.5 1.5v-2l3 3h-2a1 1 0 0 1-1-1zM8.5 7a.5.5 0 0 0-1 0v1.5H6a.5.5 0 0 0 0 1h1.5V11a.5.5 0 0 0 1 0V9.5H10a.5.5 0 0 0 0-1H8.5V7z"/>
													            </svg>
													        </button>

													    </div>
													</div> --}}
													<?php $index=0;?>
													<div class="row" >
														<div class="col-sm-6">
														<label class="col-form-label">Type</label>
														{{-- name="payroll[<?php echo $index; ?>][payroll_id_type]" --}}
															<input type="text" id="payroll-option"  class="form-control form-control-md" style="    text-transform: capitalize;" readonly>
													</div>
													<div class="col-sm-6 ">
														<label for="recipient-name" class="col-form-label">Payroll ID</label>
														{{-- name="payroll[<?php echo $index; ?>][payroll_id]" --}}
														<input type="text" class="form-control form-control-md" id="payroll-id"  readonly>
													</div>
													</div>
													<br>
													<br>
													
													 <div class="text-center">
														<button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
														<span id="form_submit" class="indicator-label">Save</span>
														<span class="indicator-progress">Please wait...
														<span class="spinner-border spinner-border-sm align-middle ms-2"></span>
														</span>
														</button>
													</div>
													<!--end::Heading-->
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
						@endif




								@stop