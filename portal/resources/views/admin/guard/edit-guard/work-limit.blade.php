{{-- @section('work-limitations')
<div class="col-md-4">
									<!--begin::Card-->
									<div class="card card-flush h-md-100">
										<!--begin::Card header-->
										<div class="card-header">
											<!--begin::Card title-->
											<div class="card-title">
												<h2>Work Limitations</h2>
											</div>
											<!--end::Card title-->
										</div>
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
											<button type="button" class="btn btn-white btn-active-light-primary my-1" data-bs-toggle="modal" data-bs-target="#work-limitation-modal" >Open Work Limit</button>
											

										</div>
										<!--end::Card footer-->
									</div>
									<!--end::Card-->
								</div>






<!-- modal  -->















<div class="modal fade" id="work-limitation-modal" tabindex="-1" aria-hidden="true">
								<!--begin::Modal dialog-->
								<div class="modal-dialog modal-dialog-centered mw-750px">
									<!--begin::Modal content-->
									<div class="modal-content">
										<!--begin::Modal header-->
										<div class="modal-header">
											<!--begin::Modal title-->
											<h2 class="fw-bolder" id="form_head">Work Limitations</h2>
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
<form id="work-limitation-form" class="form" action="{{url('guard/work_limitation_form')}}" method="POST" enctype="multipart/form-data">
																    @csrf
															<div class="row">
															<div class="col-md-6 form-group">
														<div class="fv-row mb-10">
														<!--begin::Label-->
														<label class="col-form-label required">Enable work limitation</label>
														<!--end::Label-->
														<!--begin::Input-->
														<select name="work_limitation_status" class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true">
															<option value="active">Active</option>
															<option value="inactive">Inactive</option>
														</select>
														<!--end::Input-->
													</div>
													</div>
															<div class="col-md-6 form-group">
																<label for="name" class="col-form-label">Weekly working hours</label>
																<input type="text" class="form-control form-control-md"  id="fortnightly_working_hours" name="fortnightly_working_hours"> </div>
													</div>
													<div class="row">
														<div class="col-md-12 form-group">
														<label for="recipient-name" class="col-form-label">Letter from Educational Institute </label>
															<input accept="image/png, image/gif, image/jpeg" type="file" onchange="validateSize(this)" type="file" class="form-control form-control-md" id="ffortnightly_working_holiday_letter" name="ffortnightly_working_holiday_letter" > 
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
					











					<script type="text/javascript">


							  $("#work-limitation-form").on('submit', function(e){
						     e.preventDefault();
						     console.log(this.id)
						     var data = $('#'+this.id).serialize();

						     $.ajax({type: "POST",url: this.action,data : data ,success: function(result){if(result.success){
						     	
						     }else{Swal.fire({
						                        text: result.error,
						                        icon: "error",
						                        buttonsStyling: !1,
						                        confirmButtonText: "Ok, got it!",
						                        customClass: {
						                            confirmButton: "btn btn-light"
						                        }
                    })}}})

  });



					</script>
								@stop --}}