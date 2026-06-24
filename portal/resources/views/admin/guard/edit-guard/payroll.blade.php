@section('payroll-form')
<?php 
$progress = 0;
if(isset($guard_data['guard']) && !empty($guard_data['guard']))
{
	if ($guard_data['guard']->payroll_tfn_number != '') {
		$progress += 7.5;
	}
	if ($guard_data['guard']->tfn_file != '') {
		$progress += 7.5;
	}
	if ($guard_data['guard']->payroll_superannutation != '') {
		$progress += 7.5;
	}
	if ($guard_data['guard']->superannutation_file != '') {
		$progress += 7.5;
	}
	if ($guard_data['guard']->payroll_superannutation_name != '' && $guard_data['guard']->payroll_superannutation_name != null) {
		$progress += 10;
	}
	if ($guard_data['guard']->payroll_abn_number != '') {
		$progress += 15;
	}
	if ($guard_data['guard']->payroll_bank_name != '') {
		$progress += 15;
	}
	if ($guard_data['guard']->payroll_bank_account_number != '') {
		$progress += 15;
	}
	if ($guard_data['guard']->bsb != '') {
		$progress += 15;	
	}
}
?>
<div class="col-md-4">
	<!--begin::Card-->
	<div class="card card-flush h-md-100">
		<!--begin::Card header-->
		<div class="card-header">
			<!--begin::Card title-->
			<div class="card-title">
				<h2>PayRoll</h2>
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
			<button type="button" class="btn btn-white btn-active-light-primary my-1" data-bs-toggle="modal" data-bs-target="#payroll-modal1" id="payroll-modal-btn" >Open Payroll </button>


		</div>
		<!--end::Card footer-->
	</div>
	<!--end::Card-->
</div>






<!-- modal  -->















<div class="modal fade" id="payroll-modal" tabindex="-1" aria-hidden="true">
	<!--begin::Modal dialog-->
	<div class="modal-dialog modal-dialog-centered mw-750px">
		<!--begin::Modal content-->
		<div class="modal-content">
			<!--begin::Modal header-->
			<div class="modal-header">
				<!--begin::Modal title-->
				<h2 class="fw-bolder" id="form_head">Payroll</h2>
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




				<form id="payroll-form" class="form" action="{{url('guard/save_payroll_form')}}" method="POST" enctype="multipart/form-data">
					@csrf
					<input type="hidden" class="form-control form-control-md"  id="guard_id" name="guard_id" value="{{$guard_id}}"> 
					<div class="row">
						<div class="col-4 col-sm-12 col-xl-4 mb-4">
							<!--begin::Card-->
							<div class="card-header border-0">
								<!--begin::Card title-->
								<div class="card-title">
									<h2>TFN</h2> </div>
									<!--end::Card title-->
								</div>
								<div class="card h-100 flex-center">
									<div id="doc_tfnFile" class="symbol symbol-60px mb-6 form-group row " style="display: none;">
										<div class="col-sm-6" style="float:left;">
											<a target="__blank" id="link_tfn" style="margin-left: 70px;"> <img src="{{asset('')}}media/svg/files/doc.svg" alt=""> </a>
										</div>
										<div class="col-sm-6" style="float:right;"> <a type="button" style="margin-left: 37px;margin-top: -13px;" class="btn btn-primary" onclick="this.parentElement.parentElement.style.display = 'none';$('#div_tfnFile').show();$('#tfnFileUploaded').val('');">
											X
										</a> </div>
									</div>
									<div class="form-group files" id="div_tfnFile">
										<input accept="image/png, image/gif, image/jpeg" type="file" onchange="upload_file('tfnFile', 'tfnFileUploaded')" class="form-control form-control-md" id="tfnFile" name="tfnFile">
										<input type="hidden" name="tfnFileUploaded" id="tfnFileUploaded"> 
									</div>
										<div class=" form-group">
											<label for="name" class="col-form-label">TFN</label>
											<input type="text" class="form-control form-control-md" id="payroll_tfn_number" name="payroll_tfn_number" required="">
										</div>
									</div>
								</div>

								<div class="col-md-4 form-group">
									<!--begin::Card-->
							<div class="card-header border-0">
								<!--begin::Card title-->
								<div class="card-title">
									<h2>Superannutation</h2> </div>
									<!--end::Card title-->
								</div>
								<div class="card h-100 flex-center">
									<div id="doc_superannutationFile" class="symbol symbol-60px mb-6 form-group row " style="display: none;">
										<div class="col-sm-6" style="float:left;">
											<a target="__blank" id="link_superannutation" style="margin-left: 70px;"> <img src="{{asset('')}}media/svg/files/doc.svg" alt=""> </a>
										</div>
										<div class="col-sm-6" style="float:right;"> <a type="button" style="margin-left: 37px;margin-top: -13px;" class="btn btn-primary" onclick="this.parentElement.parentElement.style.display = 'none';$('#div_superannutationFile').show();$('#superannutationFileUploaded').val('');">
											X
										</a> </div>
									</div>
									<div class="form-group files" id="div_superannutationFile">
										<input accept="image/png, image/gif, image/jpeg" type="file" onchange="upload_file('superannutationFile', 'superannutationFileUploaded')" class="form-control form-control-md" id="superannutationFile" name="superannutationFile">
										<input type="hidden" name="superannutationFileUploaded" id="superannutationFileUploaded"> 
									</div>
										<div class=" form-group">
											<label for="name" class="col-form-label">Superannutation Number</label>
											<input type="text" class="form-control form-control-md" id="payroll_superannutation" name="payroll_superannutation" required="">
										</div>
									</div>
									<!-- <label for="name" class="col-form-label">Superannutation Number</label>
									<input type="text" class="form-control form-control-md"  id="payroll_superannutation" name="payroll_superannutation"> --> 
								</div>
									<!-- <div class="col-md-4 form-group">
										<label for="name" class="col-form-label">TFN</label>
										<input type="text" class="form-control form-control-md"  id="payroll_tfn_number" name="payroll_tfn_number"> 

									</div> -->
									<div class="col-md-4 form-group">
										<label for="name" class="col-form-label">ABN</label>
										<input type="text" class="form-control form-control-md"  id="payroll_abn_number" name="payroll_abn_number"> 
										<label for="name" class="col-form-label">Superannutation Company</label>
										<input type="text" class="form-control form-control-md"  id="payroll_superannutation_name" name="payroll_superannutation_name"> 
									</div>
									
								</div>
								<div class="row">
									<div class="col-md-4 form-group">
									</div>
									<div class="col-md-4 form-group">
										
									</div>
									<div class="col-md-4 form-group">
									</div>
								</div>
								<div class="row mt-12">
									<div class="col-md-4 form-group">
										<label for="name" class="col-form-label">Account name</label>
										<input type="text" class="form-control form-control-md"  id="payroll_bank_name" name="payroll_bank_name"> 
									</div>
									<div class="col-md-4 form-group">
										<label for="name" class="col-form-label">BSB</label>
										<input type="text" class="form-control form-control-md"  id="payroll_bsb" name="payroll_bsb"> 
									</div>
									<div class="col-md-4 form-group">
										<label for="name" class="col-form-label">Bank account number</label>
										<input type="text" class="form-control form-control-md"  id="payroll_bank_account_number" name="payroll_bank_account_number"> 
									</div>
								</div>
							</br>
						</br>
					</br>
					<div class="text-center">
						<button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
							<span id="form_submit" class="indicator-label">Save</span>
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