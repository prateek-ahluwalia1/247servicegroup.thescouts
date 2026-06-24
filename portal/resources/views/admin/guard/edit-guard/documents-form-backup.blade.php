@section('documents-form')
<?php 
	$progress = 0;
	if(isset($guard_data['guard']) && !empty($guard_data['guard']))
	{
		if ($guard_data['guard']->residential_status == 'student') {
			if ($guard_data['guard']->driver_license_file != '') {
				$progress += 25;
			}
			if ($guard_data['guard']->security_license_file != '') {
				$progress += 25;
			}
			if ($guard_data['guard']->visa_file != '') {
				$progress += 25;
			}
			if ($guard_data['guard']->passport_file != '') {
				$progress += 25;
			}
		}elseif($guard_data['guard']->residential_status == 'citizen'){
			if ($guard_data['guard']->driver_license_file != '') {
				$progress += 50;
			}
			if ($guard_data['guard']->security_license_file != '') {
				$progress += 50;
			}
		}elseif ($guard_data['guard']->residential_status == 'subclass-485') {
			if ($guard_data['guard']->driver_license_file != '') {
				$progress += 25;
			}
			if ($guard_data['guard']->security_license_file != '') {
				$progress += 25;
			}
			if ($guard_data['guard']->visa_file != '') {
				$progress += 25;
			}
			if ($guard_data['guard']->passport_file != '') {
				$progress += 25;
			}
		}elseif ($guard_data['guard']->residential_status == 'permanent-resident') {
			if ($guard_data['guard']->driver_license_file != '') {
				$progress += 33;
			}
			if ($guard_data['guard']->security_license_file != '') {
				$progress += 33;
			}
			if ($guard_data['guard']->citizenship_file != '') {
				$progress += 34;
			}
			
		}else {
			if ($guard_data['guard']->driver_license_file != '') {
				$progress += 25;
			}
			if ($guard_data['guard']->security_license_file != '') {
				$progress += 25;
			}
			if ($guard_data['guard']->visa_file != '') {
				$progress += 25;
			}
			if ($guard_data['guard']->passport_file != '') {
				$progress += 25;
			}
		}
		// if ($guard_data['guard']->driver_license_file != '') {
		// $progress += 25;
			
		// }
		// if($guard_data['guard']->state!='Victoria'){
		// 	if ($guard_data['guard']->security_license_file_back != '') {
		// $progress += 25;
		// }
		// }else{
		// 	if ($guard_data['guard']->driver_license_file_back != '') {
		// $progress += 25;
			
		// }
		
		// }
		// if ($guard_data['guard']->security_license_file != '') {
		// $progress += 50;
			
		// }
	}
?>
	<div class="col-md-4">
		<!--begin::Card-->
		<div class="card card-flush h-md-100">
			<!--begin::Card header-->
			<div class="card-header">
				<!--begin::Card title-->
				<div class="card-title">
					<h2>Documents</h2> </div>
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
						<div class="d-flex flex-stack mb-2"> <span class="text-muted me-2 fs-7 fw-bold">{{$progress}}%</span> </div>
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
				<button type="button" class="btn btn-white btn-active-light-primary my-1" data-bs-toggle="modal" data-bs-target="#documents-modal1" id="documents-modal-btn">Open Documents</button>
			</div>
			<!--end::Card footer-->
		</div>
		<!--end::Card-->
	</div>
	<!-- modal  -->
	<div class="modal fade" id="documents-modal" tabindex="-1" aria-hidden="true">
		<!--begin::Modal dialog-->
		<div class="modal-dialog modal-dialog-centered mw-900px ">
			<!--begin::Modal content-->
			<div class="modal-content">
				<!--begin::Modal header-->
				<div class="modal-header">
					<!--begin::Modal title-->
					<h2 class="fw-bolder" id="form_head">Documents</h2>
					<!--end::Modal title-->
					<!--begin::Close-->
					<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close"> <span class="svg-icon svg-icon-2x">X</span> </div>
					<!--end::Close-->
				</div>
				<!--end::Modal header-->
				<!--begin::Modal body-->
				<div class="modal-body scroll-y mx-5 my-7">
					<!--begin::Form-->
					<form id="documents-form" class="form" action="{{url('documents_form')}}" method="POST" enctype="multipart/form-data"> @csrf
						<div class="row">
							<div class="col-md-3 form-group" style="display: none;">
								<div class="fv-row mb-10">
									<!--begin::Label-->
									<label class="form-label required">Position</label>
									<!--end::Label-->
									<!--begin::Input-->
									<select name="position" class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" readonly="">
										<option value="full_time">Full-time</option>
										<option value="part_time">Part-time</option>
										<option value="casual">Casual</option>
									</select>
									<!--end::Input-->
								</div>
							</div>
							<div class="col-md-3 form-group" style="display: none;">
								<div class="fv-row mb-10">
									<!--begin::Label-->
									<label class="form-label required">Work type</label>
									<!--end::Label-->
									<!--begin::Input-->
									<select name="registrationType" class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" readonly="">
										<option value="Employee">Employee</option>
										<option value="Contractor">Contractor</option>
									</select>
									<!--end::Input-->
								</div>
							</div>
							<div class="col-md-6 form-group">
								<div class="fv-row mb-10">
									<!--begin::Label-->
									<label class="form-label required">Residential status</label>
									<!--end::Label-->
									<!--begin::Input-->
									<select name="residentialStatus" id="residentialStatus" class="form-select form-select-lg form-select-solid" data-placeholder="..." data-allow-clear="true" data-hide-search="true">
										<option value="">Select</option>
										<option value="citizen">Citizen</option>
										<option value="student">Student</option>
										<option value="subclass-485">Visa Subclass 485</option>
										<option value="permanent-resident">Permanent Resident</option>
										<option value="other">Other</option>
									</select>
									<!--end::Input-->
								</div>
							</div>
							<div class="col-md-6 form-group" id="subselect-div">
								<div class="fv-row mb-10">
									<!--begin::Label-->
									<label class="form-label required">Select Below status</label>
									<!--end::Label-->
									<!--begin::Input-->
									<select name="subselect" id="subselect" class="form-select form-select-lg form-select-solid" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true">
										<option value="">Select</option>
										<option value="medicare">Medicare</option>
										<option value="birthcertificate">Birth Certificate</option>
										<option value="citizenship">Citizenship</option>
										<option value="subpass">Passport</option>
									</select>
									<!--end::Input-->
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-lg-4 col-xl-3">
									<!--begin::Card-->
									<div class="card h-100">
										<!--begin::Card body-->
										<div class="card-body d-flex justify-content-center text-center flex-column p-8">
											<!--begin::Name-->
											<a target="__blank" id="link_vaccination" class="text-gray-800 text-hover-primary d-flex flex-column">
												<!--begin::Image-->
												<div class="symbol symbol-60px mb-5">
													<img src="{{asset('')}}media/svg/files/pdf.svg" alt="">
												</div>
												<!--end::Image-->
												<!--begin::Title-->
												<div class="fs-5 fw-bolder mb-2">Vaccination Certificate</div>
												<!--end::Title-->
											</a>
											<!--end::Name-->
											<!--begin::Description-->
											<div class="fs-7 fw-bold text-gray-400">3 days ago</div>
											<!--end::Description-->
										</div>
										<!--end::Card body-->
										<div class="col-sm-6" style="position: absolute;left: 15px;padding-bottom: 10px;"> <a type="button" style="margin-left: 90px;margin-top: -16px;" class="btn btn-primary" onclick="this.parentElement.parentElement.style.display = 'none';$('#div_vaccinationFile').show();$('#vaccinationFileUploaded').val('');$('#vaccinationNumber').val('');$('#vaccinationExpiration').val( '')">
                                            X
                                        </a> </div>
									</div>
									<!--end::Card-->
								</div>
								<!-- end here -->
							<div class="col-6 col-sm-6 col-xl" id="vaccination-div">
								<!--begin::Card-->
								<div class="card-header border-0">
									<!--begin::Card title-->
									<div class="card-title">
										<h2>Vaccination Certificate</h2> </div>
									<!--end::Card title-->
								</div>
								<div class="card h-100 flex-center">
									<div id="doc_vaccinationFile" class="symbol symbol-60px mb-6 form-group row " style="display: none;">
										<div class="col-sm-6" style="float:left;">
											<a target="__blank" id="link_vaccination" style="margin-left: 123px;"> <img src="{{asset('')}}media/svg/files/folder-document.svg" alt=""> </a>
										</div>
										<div class="col-sm-6" style="float:right;"> <a type="button" style="margin-left: 90px;margin-top: -16px;" class="btn btn-primary" onclick="this.parentElement.parentElement.style.display = 'none';$('#div_vaccinationFile').show();$('#vaccinationFileUploaded').val('');$('#vaccinationNumber').val('');$('#vaccinationExpiration').val( '')">
                                            X
                                        </a> </div>
									</div>
									<div class="form-group files" id="div_vaccinationFile">
										<input accept="image/png, application/pdf, image/gif, image/jpeg" type="file" onchange="upload_file('vaccinationFile', 'vaccinationFileUploaded')" class="form-control form-control-md" id="vaccinationFile" name="vaccinationFile">
										<input type="hidden" name="vaccinationFileUploaded" id="vaccinationFileUploaded"> </div>
									
								</div>
							</div>
							<div class="col-6 col-sm-6 col-xl" id="driver-div" style="display:none;">
								<!--begin::Card-->
								<div class="card-header border-0">
									<!--begin::Card title-->
									<div class="card-title">
										<h2>Driver License</h2> </div>
									<!--end::Card title-->
								</div>
								<div class="card h-100 flex-center">
									<div class="row">
										<div style="float:left;margin-top: 59px;" class="col-sm-6">
											<h5 class="text-center">Front</h5>
											<div id="doc_driverLicenseFile" class="symbol symbol-60px mb-6 form-group row" style="display: none;">
												<div class="col-sm-6" style="float:left;">
													<a target="__blank" id="link_driver" style="margin-left: 61px;"> <img src="{{asset('')}}media/svg/files/folder-document.svg" alt=""> </a>
												</div>
												<div class="col-sm-6" style="float:right;"> <a type="button" style="margin-left: 54px;font-size: 10px;" class="btn btn-primary" onclick="this.parentElement.parentElement.style.display = 'none';$('#div_driverLicenseFile').show();$('#driverLicenseFileUploaded').val('');$('#driverLicenseNumber').val('');$('#driverLicenseExpiration').val( '')">
													X
												</a> </div>
											</div>
											<div class="form-group files" id="div_driverLicenseFile">
												<input type="file" accept="image/png, application/pdf, image/gif, image/jpeg" type="file" onchange="upload_file('driverLicenseFile', 'driverLicenseFileUploaded')" class="form-control form-control-md" id="driverLicenseFile" name="driverLicenseFile">
												<input type="hidden" name="driverLicenseFileUploaded" id="driverLicenseFileUploaded"> </div>
		
										</div>
										<div id="driver-div-back"  style="float:right;margin-top: 59px;" class="col-sm-6">
											<h5 class="text-center">Back</h5>
											
											<div id="doc_driverLicenseFileBack" class="symbol symbol-60px mb-6 form-group row" style="display: none;">
												<div class="col-sm-6" style="float:left;">
													<a target="__blank" id="link_driver_back" style="margin-left: 61px;"> <img src="{{asset('')}}media/svg/files/folder-document.svg" alt=""> </a>
												</div>
												<div class="col-sm-6" style="float:right;"> <a type="button" style="margin-left: 27px;font-size: 10px;" class="btn btn-primary" onclick="this.parentElement.parentElement.style.display = 'none';$('#div_driverLicenseFileBack').show();$('#driverLicenseFileBackUploaded').val('');">
													X
												</a> </div>
											</div>
											<div class="form-group files" id="div_driverLicenseFileBack">
												<input type="file" accept="image/png, application/pdf, image/gif, image/jpeg" type="file" onchange="upload_file('driverLicenseFileBack', 'driverLicenseFileBackUploaded')" class="form-control form-control-md" id="driverLicenseFileBack" name="driverLicenseFileBack">
												<input type="hidden" name="driverLicenseFileBackUploaded" id="driverLicenseFileBackUploaded"> </div>
	
										</div>
									</div>
									
																			<div class=" form-group">
										<label for="recipient-name" class="col-form-label">Driver license number</label>
										<input type="text" class="form-control form-control-md" id="driverLicenseNumber" name="driverLicenseNumber">
										<label for="recipient-name" class="col-form-label">Driver license expiration</label>
										<input type="date" class="form-control form-control-md" id="driverLicenseExpiration" name="driverLicenseExpiration"> </div>
								</div>
							</div>
							<div class="col-6 col-sm-6 col-xl mt-12" id="security-div" style="display:none;">
								<!--begin::Card-->
								<div class="card-header border-0">
									<!--begin::Card title-->
									<div class="card-title">
										<h2>Security License </h2> </div>
									<!--end::Card title-->
								</div>
								<div class="card h-100 flex-center">
									<div class="row">
										<div style="float:left;margin-top: 59px;" class="col-sm-6">
											<h5 class="text-center">Front</h5>
											<div id="doc_securityLicenseFile" class="symbol symbol-60px mb-6 form-group row" style="display: none;">
												<div class="col-sm-6" style="float:left;">
													<a target="__blank" id="link_security" style="margin-left: 61px;"> <img src="{{asset('')}}media/svg/files/folder-document.svg" alt=""> </a>
												</div>
												<div  class="col-sm-6" style="float:right;"> <a type="button" style="margin-left: 54px;font-size: 10px;" class="btn btn-primary" onclick="this.parentElement.parentElement.style.display = 'none';$('#div_securityLicenseFile').show();$('#securityLicenseFileUploaded').val('');$('#securityLicenseNumber').val('');$('#securityLicenseExpiration').val( '')">
													X
												</a> </div>
											</div>
											<div class="form-group files" id="div_securityLicenseFile">
												<input type="file" accept="image/png, application/pdf, image/gif, image/jpeg" type="file" onchange="upload_file('securityLicenseFile', 'securityLicenseFileUploaded')" class="form-control form-control-md" id="securityLicenseFile" name="securityLicenseFile">
												<input type="hidden" name="securityLicenseFileUploaded" id="securityLicenseFileUploaded"> </div>

										</div>
										<div id="security-div-back" style="float:right;margin-top: 59px;" class="col-sm-6">
											<h5 class="text-center">Back</h5>

											<div id="doc_securityLicenseFileBack" class="symbol symbol-60px mb-6 form-group row" style="display: none;">
												<div class="col-sm-6" style="float:left;">
													<a target="__blank" id="link_security_back" style="margin-left: 61px;"> <img src="{{asset('')}}media/svg/files/folder-document.svg" alt=""> </a>
												</div>
												<div class="col-sm-6" style="float:right;"> <a type="button" style="margin-left: 27px;font-size: 10px;" class="btn btn-primary" onclick="this.parentElement.parentElement.style.display = 'none';$('#div_securityLicenseFileBack').show();$('#securityLicenseFileUploadedBack').val('');">
													X
												</a> </div>
											</div>
											<div class="form-group files" id="div_securityLicenseFileBack">
												<input type="file" accept="image/png, application/pdf, image/gif, image/jpeg" type="file" onchange="upload_file('securityLicenseFileBack', 'securityLicenseFileUploadedBack')" class="form-control form-control-md" id="securityLicenseFileBack" name="securityLicenseFileBack">
												<input type="hidden" name="securityLicenseFileUploadedBack" id="securityLicenseFileUploadedBack"> </div>
										</div>
									</div>
								
									<!-- 
                                         class="form-control" multiple=""  class="form-control form-control-md" id="security_license_file" name="security_license_file" > </div> -->
									<div class=" form-group">
										<label for="recipient-name" class="col-form-label">Security license number</label>
										<div class="row">
											<div class="col-9">
												<input type="text" class="form-control form-control-md" id="securityLicenseNumber" name="securityLicenseNumber"> </div>
											<div class="col-3">
												<button type="button" class="btn btn-info" id="documentsOnlineVerification2">Check</button>
											</div>
										</div>
										<label for="recipient-name" class="col-form-label">Security license expiration</label>
										<input type="date" class="form-control form-control-md" id="securityLicenseExpiration" name="securityLicenseExpiration" readonly=""> </div>
								</div>
							</div>
						</div>
						<br>
						<br>
						
						<div class="row">
							<div class="col-6 col-sm-6 col-xl" id="visa-div" style="display:none;">
								<!--begin::Card-->
								<div class="card-header border-0">
									<!--begin::Card title-->
									<div class="card-title">
										<h2>Visa</h2> </div>
									<!--end::Card title-->
								</div>
								<div class="card h-100 flex-center">
									<div id="doc_visaFile" class="symbol symbol-60px mb-6 form-group row " style="display: none;">
										<div class="col-sm-6" style="float:left;">
											<a target="__blank" id="link_visa" style="margin-left: 123px;"> <img src="{{asset('')}}media/svg/files/folder-document.svg" alt=""> </a>
										</div>
										<div class="col-sm-6" style="float:right;"> <a type="button" style="margin-left: 90px;margin-top: -16px;" class="btn btn-primary" onclick="this.parentElement.parentElement.style.display = 'none';$('#div_visaFile').show();$('#visaFileUploaded').val('');$('#visaNumber').val('');$('#visaExpiration').val( '')">
                                            X
                                        </a> </div>
									</div>
									<div class="form-group files" id="div_visaFile">
										<input accept="image/png, application/pdf, image/gif, image/jpeg" type="file" onchange="upload_file('visaFile', 'visaFileUploaded')" class="form-control form-control-md" id="visaFile" name="visaFile">
										<input type="hidden" name="visaFileUploaded" id="visaFileUploaded"> </div>
									<div class=" form-group">
										<label for="name" class="col-form-label">Visa number</label>
										<input type="text" class="form-control form-control-md" id="visaNumber" name="visaNumber">
										<label for="name" class="col-form-label">Visa expiration</label>
										<input type="date" class="form-control form-control-md" id="visaExpiration" name="visaExpiration"> </div>
								</div>
							</div>
							<div class="col-6 col-sm-6 col-xl" id="passport-div" style="display:none;">
								<!--begin::Card-->
								<div class="card-header border-0">
									<!--begin::Card title-->
									<div class="card-title">
										<h2>Passport</h2> </div>
									<!--end::Card title-->
								</div>
								<div class="card h-100 flex-center">
									<div id="doc_passportFile" class="symbol symbol-60px mb-6 form-group row" style="display: none;">
										<div class="col-sm-6" style="float:left;">
											<a target="__blank" id="link_passport" style="margin-left: 123px;"> <img src="{{asset('')}}media/svg/files/folder-document.svg" alt=""> </a>
										</div>
										<div class="col-sm-6" style="float:right;"> <a type="button" style="margin-left: 90px;margin-top: -16px;" class="btn btn-primary" onclick="this.parentElement.parentElement.style.display = 'none';$('#div_passportFile').show();$('#passportFileUploaded').val('');$('#passportNumber').val('');$('#passportExpiration').val( '')">
                                            X
                                        </a> </div>
									</div>
									<div class="form-group files" id="div_passportFile">
										<input type="file" accept="image/png, application/pdf, image/gif, image/jpeg" type="file" onchange="upload_file('passportFile', 'passportFileUploaded')" class="form-control form-control-md" id="passportFile" name="passportFile">
										<input type="hidden" name="passportFileUploaded" id="passportFileUploaded"> </div>
									<!-- 
                                         class="form-control" multiple=""  class="form-control form-control-md" id="security_license_file" name="security_license_file" > </div> -->
									<div class=" form-group">
										<label for="recipient-name" class="col-form-label">Passport  number</label>
										<input type="text" class="form-control form-control-md" id="passportNumber" name="passportNumber">
										<label for="recipient-name" class="col-form-label">Passport  expiration</label>
										<input type="date" class="form-control form-control-md" id="passportExpiration" name="passportExpiration"> </div>
								</div>
							</div>
						</div>
						<br>
						<br>
						
						<div class="row">
							<div class="col-6 col-sm-6 col-xl" id="birthcertificate-div" style="display:none;">
								<!--begin::Card-->
								<div class="card-header border-0">
									<!--begin::Card title-->
									<div class="card-title">
										<h2>Birthcertificate</h2> </div>
									<!--end::Card title-->
								</div>
								<div class="card h-100 flex-center">
									<div id="doc_birthcertificateFile" class="symbol symbol-60px mb-6 form-group row " style="display: none;">
										<div class="col-sm-6" style="float:left;">
											<a target="__blank" id="link_birth" style="margin-left: 123px;"> <img src="{{asset('')}}media/svg/files/folder-document.svg" alt=""> </a>
										</div>
										<div class="col-sm-6" style="float:right;"> <a type="button" style="margin-left: 90px;margin-top: -16px;" class="btn btn-primary" onclick="this.parentElement.parentElement.style.display = 'none';$('#div_birthcertificateFile').show();$('#birthcertificateFileUploaded').val('');$('#birthcertificateNumber').val('');$('#birthcertificateExpiration').val( '')">
                                            X
                                        </a> </div>
									</div>
									<div class="form-group files" id="div_birthcertificateFile">
										<input accept="image/png, application/pdf, image/gif, image/jpeg" type="file" onchange="upload_file('birthcertificateFile', 'birthcertificateFileUploaded')" class="form-control form-control-md" id="birthcertificateFile" name="birthcertificateFile">
										<input type="hidden" name="birthcertificateFileUploaded" id="birthcertificateFileUploaded"> </div>
									<div class=" form-group">
										<label for="name" class="col-form-label">Birthcertificate number</label>
										<input type="text" class="form-control form-control-md" id="birthcertificateNumber" name="birthcertificateNumber">
										<label for="name" class="col-form-label">Birthcertificate expiration</label>
										<input type="date" class="form-control form-control-md" id="birthcertificateExpiration" name="birthcertificateExpiration"> </div>
								</div>
							</div>
							<div class="col-6 col-sm-6 col-xl" id="medicare-div" style="display:none;">
								<!--begin::Card-->
								<div class="card-header border-0">
									<!--begin::Card title-->
									<div class="card-title">
										<h2>Medicare</h2> </div>
									<!--end::Card title-->
								</div>
								<div class="card h-100 flex-center">
									<div id="doc_medicareFile" class="symbol symbol-60px mb-6 form-group row " style="display: none;">
										<div class="col-sm-6" style="float:left;">
											<a target="__blank" id="link_medicare" style="margin-left: 123px;"> <img src="{{asset('')}}media/svg/files/folder-document.svg" alt=""> </a>
										</div>
										<div class="col-sm-6" style="float:right;"> <a type="button" style="margin-left: 90px;margin-top: -16px;" class="btn btn-primary" onclick="this.parentElement.parentElement.style.display = 'none';$('#div_medicareFile').show();$('#medicareFileUploaded').val('');$('#medicareNumber').val('');$('#medicareExpiration').val( '')">
                                            X
                                        </a> </div>
									</div>
									<div class="form-group files" id="div_medicareFile">
										<input accept="image/png, application/pdf, image/gif, image/jpeg" type="file" onchange="upload_file('medicareFile', 'medicareFileUploaded')" class="form-control form-control-md" id="medicareFile" name="medicareFile">
										<input type="hidden" name="medicareFileUploaded" id="medicareFileUploaded"> </div>
									<div class=" form-group">
										<label for="name" class="col-form-label">Medicare number</label>
										<input type="text" class="form-control form-control-md" id="medicareNumber" name="medicareNumber">
										<label for="name" class="col-form-label">Medicare expiration</label>
										<input type="date" class="form-control form-control-md" id="medicareExpiration" name="medicareExpiration"> </div>
								</div>
							</div>
						</div>
						<br>
						<br>
						
						<div class="row">
							<div class="col-6 col-sm-6 col-xl" id="firstaid-div" style="display:none;">
								<!--begin::Card-->
								<div class="card-header border-0">
									<!--begin::Card title-->
									<div class="card-title">
										<h2>Firstaid</h2> </div>
									<!--end::Card title-->
								</div>
								<div class="card h-100 flex-center">
									<div id="doc_firstaidLicense" class="symbol symbol-60px mb-6 form-group row " style="display: none;">
										<div class="col-sm-6" style="float:left;">
											<a target="__blank" id="link_firstaid" style="margin-left: 123px;"> <img src="{{asset('')}}media/svg/files/folder-document.svg" alt=""> </a>
										</div>
										<div class="col-sm-6" style="float:right;"> <a type="button" style="margin-left: 90px;margin-top: -16px;" class="btn btn-primary" onclick="this.parentElement.parentElement.style.display = 'none';$('#div_firstaidLicense').show();$('#firstaidLicenseUploaded').val('');$('#firstaidLicenseUploaded').val('');$('#firstaidLicenseExpiration').val( '')">
                                            X
                                        </a> </div>
									</div>
									<div class="form-group files" id="div_firstaidLicense">
										<input accept="image/png, application/pdf, image/gif, image/jpeg" type="file" onchange="upload_file('firstaidLicense', 'firstaidLicenseUploaded')" class="form-control form-control-md" id="firstaidLicense" name="firstaidLicense">
										<input type="hidden" name="firstaidLicenseUploaded" id="firstaidLicenseUploaded"> </div>
									<div class=" form-group">
										<label for="name" class="col-form-label">Firstaid license number</label>
										<input type="text" class="form-control form-control-md" id="firstaidLicenseUploaded" name="firstaidLicenseUploaded">
										<label for="name" class="col-form-label">Firstaid license expiration</label>
										<input type="date" class="form-control form-control-md" id="firstaidLicenseExpiration" name="firstaidLicenseExpiration"> </div>
								</div>
							</div>
							<div class="col-6 col-sm-6 col-xl" id="firearm-div" style="display:none;">
								<!--begin::Card-->
								<div class="card-header border-0">
									<!--begin::Card title-->
									<div class="card-title">
										<h2>Firearm</h2> </div>
									<!--end::Card title-->
								</div>
								<div class="card h-100 flex-center">
									<div id="doc_firearmLicenseFile" class="symbol symbol-60px mb-6 form-group row" style="display: none;">
										<div class="col-sm-6" style="float:left;">
											<a target="__blank" id="link_firearm" style="margin-left: 123px;"> <img src="{{asset('')}}media/svg/files/folder-document.svg" alt=""> </a>
										</div>
										<div class="col-sm-6" style="float:right;"> <a type="button" style="margin-left: 90px;margin-top: -16px;" class="btn btn-primary" onclick="this.parentElement.parentElement.style.display = 'none';$('#div_firearmLicenseFile').show();$('#firearmLicenseFileUploaded').val('');$('#firearmLicenseNumber').val('');$('#firearmLicenseExpiration').val( '')">
                                            X
                                        </a> </div>
									</div>
									<div class="form-group files" id="div_firearmLicenseFile">
										<input type="file" accept="image/png, application/pdf, image/gif, image/jpeg" type="file" onchange="upload_file('firearmLicenseFile', 'firearmLicenseFileUploaded')" class="form-control form-control-md" id="firearmLicenseFile" name="firearmLicenseFile">
										<input type="hidden" name="firearmLicenseFileUploaded" id="firearmLicenseFileUploaded"> </div>
									<!-- 
                                         class="form-control" multiple=""  class="form-control form-control-md" id="security_license_file" name="security_license_file" > </div> -->
									<div class=" form-group">
										<label for="recipient-name" class="col-form-label">Firearm license number</label>
										<input type="text" class="form-control form-control-md" id="firearmLicenseNumber" name="firearmLicenseNumber">
										<label for="recipient-name" class="col-form-label">Firearm license expiration</label>
										<input type="date" class="form-control form-control-md" id="firearmLicenseExpiration" name="firearmLicenseExpiration"> </div>
								</div>
							</div>
						</div>
						<br>
							
					
						<div class="row">
							<div class="col-6 col-sm-6 col-xl" id="citizenship-div" style="display:none;">
								<!--begin::Card-->
								<div class="card-header border-0">
									<!--begin::Card title-->
									<div class="card-title">
										<h2>citizenship</h2> </div>
									<!--end::Card title-->
								</div>
								<div class="card h-100 flex-center">
									<div id="doc_citizenshipFile" class="symbol symbol-60px mb-6 form-group row " style="display: none;">
										<div class="col-sm-6" style="float:left;">
											<a target="__blank" id="link_citizen" style="margin-left: 123px;"> <img src="{{asset('')}}media/svg/files/folder-document.svg" alt=""> </a>
										</div>
										<div class="col-sm-6" style="float:right;"> <a type="button" style="margin-left: 90px;margin-top: -16px;" class="btn btn-primary" onclick="this.parentElement.parentElement.style.display = 'none';$('#div_citizenshipFile').show();$('#citizenshipFileUploaded').val('');$('#citizenshipNumber').val('');$('#citizenshipExpiration').val( '')">
                                            X
                                        </a> </div>
									</div>
									<div class="form-group files" id="div_citizenshipFile">
										<input accept="image/png, application/pdf, image/gif, image/jpeg" type="file" onchange="upload_file('citizenshipFile', 'citizenshipFileUploaded')" class="form-control form-control-md" id="citizenshipFile" name="citizenshipFile">
										<input type="hidden" name="citizenshipFileUploaded" id="citizenshipFileUploaded"> </div>
									<div class=" form-group">
										<label for="name" class="col-form-label">citizenship number</label>
										<input type="text" class="form-control form-control-md" id="citizenshipNumber" name="citizenshipNumber">
										<label for="name" class="col-form-label">citizenship expiration</label>
										<input type="date" class="form-control form-control-md" id="citizenshipExpiration" name="citizenshipExpiration"> </div>
								</div>
							</div>
							{{-- <div class="col-6 col-sm-6 col-xl" id="security_back-div" style="display:none;">
								<div class="card-header border-0">
									<div class="card-title">
										<h2>Security License Back </h2> </div>
								</div>
								<div class="card h-100 flex-center">
									<div id="doc_securityLicenseFileBack" class="symbol symbol-60px mb-6 form-group row" style="display: none;">
										<div class="col-sm-6" style="float:left;">
											<a target="__blank" id="link_security_back" style="margin-left: 123px;"> <img src="{{asset('')}}media/svg/files/folder-document.svg" alt=""> </a>
										</div>
										<div class="col-sm-6" style="float:right;"> <a type="button" style="margin-left: 90px;margin-top: -16px;" class="btn btn-primary" onclick="this.parentElement.parentElement.style.display = 'none';$('#div_securityLicenseFileBack').show();$('#securityLicenseFileUploadedBack').val('');$('#securityLicenseNumberBack').val('');$('#securityLicenseExpirationBack').val( '')">
                                            X
                                        </a> </div>
									</div>
									<div class="form-group files" id="div_securityLicenseFileBack">
										<input type="file" accept="image/png, application/pdf, image/gif, image/jpeg" type="file" onchange="upload_file('securityLicenseFileBack', 'securityLicenseFileUploadedBack')" class="form-control form-control-md" id="securityLicenseFileBack" name="securityLicenseFileBack">
										<input type="hidden" name="securityLicenseFileUploadedBack" id="securityLicenseFileUploadedBack"> </div>
							
								</div>
							</div> --}}
						</div>
						<br>
						<br>
						<br>

						
						<div class="row ids-document pb-5" id="guard-document-container" style="padding-bottom: 20px">
							
						</div>
						<br>
						<br>
						
						<div class="row">
							<input type="hidden" class="form-control form-control-md" id="guard_id" name="guard_id" value="{{ $guard_id }}">
							<div class="">
								<!--begin::Card-->
								<!-- <div class="row ids-document" id="guard-document-container">
													   
													</div> -->
								<div class="row mt-12">
									<!--     <div class="col-md-4 form-group"></div> -->
									<div class="col-md-12 form-group pt-5 mt-5 py-5 my-5" style="text-center ;text-align: center;">
										<button type="button" class="btn btn-info btn-sm btn-block _ac-add-more-documents-btn"> Add more Document
											<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-earmark-plus-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
												<path fill-rule="evenodd" d="M2 2a2 2 0 0 1 2-2h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm7.5 1.5v-2l3 3h-2a1 1 0 0 1-1-1zM8.5 7a.5.5 0 0 0-1 0v1.5H6a.5.5 0 0 0 0 1h1.5V11a.5.5 0 0 0 1 0V9.5H10a.5.5 0 0 0 0-1H8.5V7z" /> </svg>
										</button>
									</div>
								</div>
								</br>
								</br>
								</br>
							</div>
							<div class="text-center" style="margin-top: 79px;">
								<button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit"> <span id="" class="indicator-label">Save</span> <span class="indicator-progress">Please wait...
                                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span> </span>
								</button>
							</div>
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
	<!--end::Modals-->@stop