@section('personal')
	
					
<div class="modal fade" id="personal-modal" tabindex="-1" aria-hidden="true">
	<!--begin::Modal dialog-->
	<div class="modal-dialog modal-dialog-centered mw-750px">
		<!--begin::Modal content-->
		<div class="modal-content">
			<!--begin::Modal header-->
			<div class="modal-header">
				<!--begin::Modal title-->
				<h2 class="fw-bolder" id="form_head">Personal Profile</h2>
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
				<form id="personal-form" class="form" action="{{url('contractor/save_personal_form')}}" method="POST" enctype="multipart/form-data"> @csrf
					<!--begin::Table-->
					<input type="hidden" value="{{$contractor_id}}"  name="contractor_id" > 

					<div class="panel-body container-fluid">
						<div class="row">
							<div class="col-md-6 form-group">
								<label for="recipient-name" class="col-form-label">Name</label>
								<input type="text" class="form-control form-control-md" name="name" required> </div>
							<div class="col-md-6 form-group">
								<label for="recipient-name" class="col-form-label">Phone</label>
								<input type="text" class="form-control form-control-md" name="phone"> </div>
						</div>
						{{-- <div class="row">
						<div class="col-md-6 form-group">
							<label for="recipient-name" class="col-form-label">Profile image </label>
							<input accept="image/png, image/gif, image/jpeg" type="file" onchange="upload_file('image', 'profileImageUploaded')" type="file" class="form-control form-control-md" id="image" name="image"> 
							<input type="hidden" name="profileImageUploaded" id="profileImageUploaded">
						</div>
						</div> --}}

						<div class="row">
							<div class="col-md-6 form-group">
								<label for="recipient-name" class="col-form-label">Email</label>
								<input type="email" class="form-control form-control-md" name="email" required> </div>
							<div class="col-md-6 form-group">
								<label for="recipient-name" class="col-form-label">Password</label>
								<input type="text" class="form-control form-control-md" name="password" > </div>
						</div>
						<div class="row">
							<div class="col-md-12 form-group">
								<label for="recipient-name" class="col-form-label">Web URL</label>
								<input type="text" class="form-control form-control-md" name="url"> </div>
						</div>
						<div class="row personal-section">
							<div class="col-md-12 form-group">
								<label for="recipient-name" class="col-form-label">Address</label>
									<input type="text" class="form-control form-control-md" placeholder="address " name="address" id="googleaddressSearch"> </div>
							</div>
						<div class="row">
							<div class="col-md-4 form-group">
								<label for="recipient-name" class="col-form-label">City</label>
								<input readonly style="background-color: #80808021" type="text" class="form-control form-control-md" value=" " name="city" id="administrative_area_level_2"> </div>
							<div class="col-md-4 form-group">
								<label for="recipient-name" class="col-form-label">State</label>
								<select readonly class="form-select form-select-lg form-select-solid"  name="state" id="administrative_area_level_1">
									<option value="Victoria">Victoria</option>
									<option value="New South Wales">NSW</option>
									<option value="Queensland">Queensland</option>
									<option value="Tasmania">Tasmania</option>
									<option value="Western Australia">Western Australia</option>
									<option value="South Australia">South Australia</option>
									<option value="ACT">ACT</option>
								</select>
							</div>
							<div class="col-md-4 form-group">
								<label for="recipient-name" class="col-form-label">Postal code</label>
								<input readonly style="background-color: #80808021" type="text" id="postal_code" class="form-control form-control-md" value=" " name="postalCode"> </div>

						</div>
					</div>

				<!--end::Item-->
				<!--begin::Action buttons-->
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
			@stop