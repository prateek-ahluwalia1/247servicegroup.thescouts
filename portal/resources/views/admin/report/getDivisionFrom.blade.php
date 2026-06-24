
<!--begin::Form-->
								

									<!--begin::Input group-->
									<!--begin::Input group-->
									@if($type == 'input')
									<form class="form" action="{{url('add_division_consolidation')}}" method="POST" enctype="multipart/form-data">
									@csrf
									<div class="fv-row mb-10">
										<!--begin::Label-->
										<label class="required fs-6 fw-bold form-label mb-2">Title:</label>
										<!--end::Label-->
										<input type="text" id="name" name="name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Title" value="" required="">
									</div>
									@else
									<form class="form" action="{{url('add_division_consolidation_rates')}}" method="POST" enctype="multipart/form-data">
									@csrf
									<div class="fv-row mb-10">
										<!--begin::Label-->
										<label class="required fs-6 fw-bold form-label mb-2">Division:</label>
										<select class="form-control" name="division_id" id="division_id">
											<option value="">Select Division</option>
											@foreach($list as $l)
												<option value="{{$l->id}}">{{$l->name}}</option>
											@endforeach
										</select>
									</div>

									@endif
									<div class="fv-row mb-10">
										<!--begin::Label-->
										<label class="required fs-6 fw-bold form-label mb-2">Rate:</label>
										<!--end::Label-->
										<input type="number" step="any" id="rate" name="rate" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Rate" value="" required="">
									</div>
									<!--end::Input group-->
									<!--begin::Input group-->
									<!--begin::Input group-->
									<!-- <div class="fv-row mb-10"> -->
										<!--begin::Label-->
										<!-- <label class="required fs-6 fw-bold form-label mb-2">Rate:</label> -->
										<!--end::Label-->
										<!-- <input type="number" id="rate" name="rate" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Rate" value="" required="" step="any"> -->
										<!-- </div> -->
										<!--end::Input group-->
										<!--end::Input group-->
										<!--begin::Input group-->
										<div class="fv-row mb-10">
											<!--begin::Label-->
											<label class="required fs-6 fw-bold form-label mb-2">Select Customers:</label>
											<!--end::Label-->
											<select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1"
											id="customer_name" name="customer_name[]"  onchange="getCustomerSiteData(this)">
											<!-- <option value="">Select</option> -->
											@foreach($customers as $result)
											<option value="{{$result->id}}">{{$result->name}}</option>
										@endforeach                                                                    </select>
									</div>
									<!--end::Input group-->
									<!--begin::Input group-->
									<div class="fv-row mb-10">
										<!--begin::Label-->
										<label class="required fs-6 fw-bold form-label mb-2">Select Sites:</label>
										<!--end::Label-->
										<select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1" id="specific_customer_sites" class="specific_customer_sites" name="sites[]" >
											<!-- <option value="">Select Customer</option> -->

										</select>
									</div>
									<!--end::Input group-->
									<!--begin::Actions-->
									<div class="text-center">
										<button type="reset" class="btn btn-white me-3" data-kt-users-modal-action="cancel">Discard</button>
										<button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
											<span id="form_submit" class="indicator-label">Submit</span>
											<span class="indicator-progress">Please wait...
												<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
											</button>
										</div>
										<!--end::Actions-->
									</form>
									<!--end::Form-->


