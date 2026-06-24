@section('change_password')

<div class="col-md-4">
									<!--begin::Card-->
									<div class="card card-flush h-md-100">
										<!--begin::Card header-->
										<div class="card-header">
											<!--begin::Card title-->
											<div class="card-title">
												<h2>Change Password</h2>
											</div>
											<!--end::Card title-->
										</div>
										<!--end::Card header-->
										<!--begin::Card body-->
										<div class="card-body pt-1">
											<div class="fw-bolder text-gray-600 mb-5">Optional</div>

							
											

										</div>
										<!--end::Card body-->
										<!--begin::Card footer-->
										<div class="card-footer flex-wrap pt-0">
											<button type="button" class="btn btn-white btn-active-light-primary my-1" data-bs-toggle="modal" data-bs-target="#change_password-modal">Change Password</button>

										</div>
										<!--end::Card footer-->
									</div>
									<!--end::Card-->
</div>






<!-- modal  -->















<div class="modal fade" id="change_password-modal" tabindex="-1" aria-hidden="true">
								<!--begin::Modal dialog-->
								<div class="modal-dialog modal-dialog-centered mw-750px">
									<!--begin::Modal content-->
									<div class="modal-content">
										<!--begin::Modal header-->
										<div class="modal-header">
											<!--begin::Modal title-->
											<h2 class="fw-bolder" id="form_head">Change Password</h2>
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
															<form id="password_form" class="form" action="{{url('guard/change_password')}}" method="POST" enctype="multipart/form-data"> @csrf												


																                            <input type="hidden" class="form-control form-control-md" id="guard_id" name="guard_id"  value="{{ $guard_id }}"> 


																<div class="row mb-7">
																	<label>Password</label>
																    <input class="form-control" type="text" id="password" name="password" />
						
																</div>
																<div class="row mb-7">
																		<label> Confirm Password</label>
																    <input class="form-control" type="confirm_password" id="confirm_password" name="confirm_password" />
						
																</div>
																<div class="row ">
																	<button type="submit" class="btn-primary btn" style="text-align: center;">Submit</button>
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