<!-- this index.blade.php is a multiple form we'er not using it  -->
	@extends('layout.app')
	@extends('layout.sidebar')
	@extends('layout.footer')

	@include('admin.guard.personal_form')
	@section('pageCss')
	<base href="../../../">
		<meta charset="utf-8" />
		<title>{{ config('custom.title');}}</title>
				<meta name="keywords" content="{{ config('custom.title')}}" />
		<link rel="canonical" href="Https://preview.keenthemes.com/metronic8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!-- <link rel="shortcut icon" href="{{asset('')}}media/logos/favicon.ico" /> -->
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="{{asset('')}}plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="{{asset('')}}css/style.bundle.css" rel="stylesheet" type="text/css" />
 		 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCS-DB39Kk-Z25C5GWymVGshXIALbjXPGY&libraries=places"></script>

		<!--end::Global Stylesheets Bundle-->
		<style type="text/css">
			 .rTable {
      display: table;
      width: 100%;
    }

    .rTableRow {
      display: table-row;
    }

    .rTableBody {
      display: table-row-group;
    }

    .rTableCell, .rTableHead {
      display: table-cell;
      padding: 3px 10px;
      border: 1px solid #999999;
    }

    .step.active ..tab-step-number, .step.current .tab-step-number {
      color: #3f51b5;
      background-color: #fff;
    }
    .dataTables_wrapper{
      width: 100% !important;
    }
    .dataTables_paginate{
      float: right;
    }
		</style>
@stop
	<!--end::Head-->
	<!--begin::Body-->
	@section('content')
	
					<!--begin::Wrapper-->
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
					<!--begin::Header-->
					<div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
						<!--begin::Container-->
						<div class="container d-flex align-items-center justify-content-between" id="kt_header_container">
							<!--begin::Page title-->
							<div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-2 pb-2 pb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
								<!--begin::Heading-->
								<h1 class="text-dark fw-bolder my-0 fs-2">Wizard Horizontal</h1>
								<!--end::Heading-->
							</div>
							<!--end::Page title=-->
							<!--begin::Wrapper-->
							<div class="d-flex d-lg-none align-items-center ms-n2 me-2">
								<!--begin::Aside mobile toggle-->
								<div class="btn btn-icon btn-active-icon-primary" id="kt_aside_toggle">
									<!--begin::Svg Icon | path: icons/duotone/Text/Menu.svg-->
									<span class="svg-icon svg-icon-2x">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<rect x="0" y="0" width="24" height="24" />
												<rect fill="#000000" x="4" y="5" width="16" height="3" rx="1.5" />
												<path d="M5.5,15 L18.5,15 C19.3284271,15 20,15.6715729 20,16.5 C20,17.3284271 19.3284271,18 18.5,18 L5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 Z M5.5,10 L18.5,10 C19.3284271,10 20,10.6715729 20,11.5 C20,12.3284271 19.3284271,13 18.5,13 L5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 Z" fill="#000000" opacity="0.3" />
											</g>
										</svg>
									</span>
									<!--end::Svg Icon-->
								</div>
								<!--end::Aside mobile toggle-->
								<!--begin::Logo-->
								<a href="index.html" class="d-flex align-items-center">
									<img alt="Logo" src="{{asset('')}}media/logos/logo-demo-3.svg" class="h-30px" />
								</a>
								<!--end::Logo-->
							</div>
							<!--end::Wrapper-->
							@include('layout.toolbar')	
							@yield('toolbar')
						</div>
						<!--end::Container-->
					</div>
					<!--end::Header-->
					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Container-->
						<div class="container" id="kt_content_container">
							<!--begin::Card-->
							<div class="card">
								<!--begin::Card body-->
								<div class="card-body">
									<!--begin::Stepper-->
									<div class="stepper stepper-links d-flex flex-column pt-15" id="kt_create_account_stepper">
										<!--begin::Nav-->
										<div class="stepper-nav mb-5">
											<!--begin::Step 1-->
											<div class="stepper-item current" data-kt-stepper-element="nav">
												<h3 class="stepper-title">Personal</h3>
											</div>
											<!--end::Step 1-->
											<!--begin::Step 2-->
											<div class="stepper-item" data-kt-stepper-element="nav">
												<h3 class="stepper-title">IDs</h3>
											</div>
											<!--end::Step 2-->
											
											<!--begin::Step 3-->
											<div class="stepper-item" data-kt-stepper-element="nav">
												<h3 class="stepper-title">Documents </h3>
											</div>
											<!--end::Step 3-->
											<!--begin::Step 4-->
											<div class="stepper-item" data-kt-stepper-element="nav">
												<h3 class="stepper-title">Work Limitation</h3>
											</div>
											<!--end::Step 4-->
											<!--begin::Step 5-->
											<div class="stepper-item" data-kt-stepper-element="nav">
												<h3 class="stepper-title">Payroll</h3>
											</div>
											<!--end::Step 5-->
											<div class="stepper-item" data-kt-stepper-element="nav">
												<h3 class="stepper-title">Pay Rates</h3>
											</div>

											<!-- 6 -->
											<div class="stepper-item" data-kt-stepper-element="nav">
												<h3 class="stepper-title">Sites Trained</h3>
											</div>

											<!-- 7 -->

											<div class="stepper-item" data-kt-stepper-element="nav">
												<h3 class="stepper-title">Sites Blocked</h3>
											</div>
										</div>
										<!--end::Nav-->
										<!--begin::Form-->
										<!-- <form class="mx-auto mw-600px w-100 pt-15 pb-10" novalidate="novalidate" > -->
											<!--begin::Step 1-->
										<!--  -->
										<div id="kt_create_account_form">
										<!--begin::Step 1-->
											<div class="current" data-kt-stepper-element="content">
	<!--begin::Wrapper-->
	<div class="w-100">
		<!--begin::Heading-->
		<div class="pb-10 pb-lg-15">
			<!--begin::Title-->
			<h2 class="fw-bolder d-flex align-items-center text-dark">Personal 
			<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Contain Personal Information"></i></h2>
		</div>
		<!--end::Heading-->
		<!--begin::Input group-->
		<div class="">

			<form id="personal-form" class="form" action="{{url('guard/save_personal_form')}}" method="POST" enctype="multipart/form-data">
																    @csrf
					<div class="row">
					<div class="col-md-4 form-group">
						<label for="name" class="col-form-label">First Name</label>
						<input type="text" class="form-control form-control-md" value=" " id="first_name" name="first_name" required> </div>
					<div class="col-md-4 form-group">
						<label for="name" class="col-form-label">Middle Name</label>
						<input type="text" class="form-control form-control-md"  id="middle_name" name="middle_name"> </div>
					<div class="col-md-4 form-group">
						<label for="name" class="col-form-label">Last Name</label>
						<input type="text" class="form-control form-control-md" value="" id="last_name" name="last_name" required> </div>
			</div>
			<div class="row">
			<div class="col-md-6 form-group">
				<label for="recipient-name" class="col-form-label">Profile image </label>
				<input accept="image/png, image/gif, image/jpeg" type="file" onchange="upload_file('profileImage', 'profileImageUploaded')" type="file" class="form-control form-control-md" id="profileImage" name="profileImage"> 
				<input type="hidden" name="profileImageUploaded" id="profileImageUploaded">
			</div>
			</div>
		<div class="row">
			<div class="col-md-6 form-group">
				<label for="recipient-name" class="col-form-label">Email</label>
				<input type="email" class="form-control form-control-md" value=" " name="email" required> </div>
			<div class="col-md-6 form-group">
				<label for="recipient-name" class="col-form-label">Password</label>
				<input type="text" class="form-control form-control-md" value=" " name="password" required> </div>
		</div>
		<div class="row">
			<div class="col-md-6 form-group">
			<label for="recipient-name" class="col-form-label">Guard Type</label>

				<select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" id="guard_type" name="guard_type">
					<option value="direct" name="direct">Direct</option>
					<option value="contractor" name="contractor_type">Contractor</option>
				 </select>
			</div>
			 <div class="col-md-6 form-group" id="contractor_container">
            <label for="recipient-name" class="col-form-label">Contractors</label>
            <select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" id="contractor_id" name="contractor_id">
            	<option value="0"> Select Contractor</option>
            </select>
        </div>
		</div>
		<div class="row">
			<div class="col-md-6 form-group">
				<label for="recipient-name" class="col-form-label">Phone</label>
				<input type="text" class="form-control form-control-md" placeholder="phone " name="phone"> </div>
			<div class="col-md-6 form-group">
				<label for="recipient-name" class="col-form-label">Address</label>
				<input type="text" class="form-control form-control-md" placeholder="address " name="address" id="googleaddress"> </div>
		</div>
		
		<div class="row">
			<div class="col-md-4 form-group">
				<label for="recipient-name" class="col-form-label">Suburb</label>
				<input type="text" class="form-control form-control-md" value=" " name="suburb" id="locality"> </div>
			<div class="col-md-4 form-group">
				<label for="recipient-name" class="col-form-label">City</label>
				<input type="text" class="form-control form-control-md" value=" " name="city" id="administrative_area_level_2"> </div>

				<div class="col-md-4 form-group">
            <label for="recipient-name" class="col-form-label">State</label>
            
            <select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" name="state" id="administrative_area_level_1">
            <option value="Victoria">Victoria</option>
            <option value="New South Wales">NSW</option>
            <option value="Queensland">Queensland</option>
            <option value="Tasmania">Tasmania</option>
            <option value="Western Australia">Western Australia</option>
            <option value="South Australia">South Australia</option>
            <option value="ACT">ACT</option>
        </select>
        </div>
		</div>
		<div class="row">
			<div class="col-md-12 form-group">
				<label for="recipient-name" class="col-form-label">Coordinates</label>
				<input type="text" class="form-control form-control-md" value="coordinates " id="coordinate_display" disabled name="coordinate_display">
				<input type="hidden" class="form-control form-control-md" value=" " id="coordinates" name="coordinates"> </div>
		</div>
		<div class="row">
			<div class="col-md-4 form-group">
				<label for="recipient-name" class="col-form-label">Postal code</label>
				<input type="text" class="form-control form-control-md" value=" " name="postalCode"> </div>
			<div class="col-md-4 form-group">
				<label for="recipient-name" class="col-form-label">Dob</label>
				<input type="date" class="form-control form-control-md" value="dob " name="dob"> </div>
			<div class="col-md-4 form-group">
				<label for="recipient-name" class="col-form-label">Gender</label>
				<select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" name="gender"> 
				<option value="male">Male</option>
                <option value="female">Female</option>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 form-group">
            <div class="fv-row mb-10">

				<label for="recipient-name" class="col-form-label">Emergency contact name</label>
				<input type="text" class="form-control form-control-md" value=" " name="emergencyContactName"> </div>
			</div>
			<div class="col-md-6 form-group">
            <div class="fv-row mb-10">

				<label for="recipient-name" class="col-form-label">Emergency contact phone</label>
				<input type="text" class="form-control form-control-md" value=" " name="emergencyContactPhone"> </div>
			</div>
		</div>
		<div class="row">
		</div>

		<div class="row">
               <div class="col-md-12 form-group">
            <div class="fv-row mb-10">
            <select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1" id="specific_customers_id" name="specific_customers_id[]"  class="_ac-customer-change">
                <option value="">Select Customer</option>
                @foreach($customers as $customer)
                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
            </select>
        </div>
        </div>
    </div>
	</form>
		</div>
		</div> 
		
		</div> 
											
											
											<!--end::Step 1-->
											
											<!--begin::Step 2-->
											<div data-kt-stepper-element="content">
												<!--begin::Wrapper-->
												<div class="w-100">
													<form id="ids-form" class="form" action="{{url('personal_form')}}" method="POST" enctype="multipart/form-data">
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
													<!--end::Heading-->
												</form>
													
													
													
												</div>
												<!--end::Wrapper-->
											</div>
											<!--end::Step 2-->
											<!--begin::Step 3-->
											<div data-kt-stepper-element="content">
												<!--begin::Wrapper-->
												<div class="w-100">
													<!--begin::Heading-->
													<div class="pb-10 pb-lg-15">
														<!--begin::Title-->
														<h2 class="fw-bolder text-dark">Documents</h2>
														<!--end::Title-->
													</div>
													<!--end::Heading-->
													<form id="documents-form" class="form" action="{{url('personal_form')}}" method="POST" enctype="multipart/form-data">
													@csrf
													<div class="row">
													<div class="col-md-3 form-group">
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
													<div class="col-md-3 form-group">
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
													<div class="col-md-3 form-group">
														<div class="fv-row mb-10">
														<!--begin::Label-->
														<label class="form-label required">Residential status</label>
														<!--end::Label-->
														<!--begin::Input-->
														<select name="residentialStatus" class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true">
															<option value="citizen" >Citizen</option>
															<option value="student">Student</option>
            												<option value="subclass-485">Visa Subclass 485</option>
            												<option value="permanent-resident">Permanent Resident</option>
														</select>
														<!--end::Input-->
													</div>
													</div>
													<div class="col-md-3 form-group">
														<div class="fv-row mb-10">
														<!--begin::Label-->
														<label class="form-label required">Select Below status</label>
														<!--end::Label-->
														<!--begin::Input-->
														<select name="subselect" class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true">
															<option  value="" >Select</option>
															<option value="medicare">Medicare</option>
															<option value="birthcertificate">Birth Certificate</option>
															<option value="citizenship">Citizenship</option>
															<option value="passport">Passport</option>
														</select>
														<!--end::Input-->
													</div>
													</div>

													</div>
													<!-- end of selction -->
													<div class="row">
														<div class="col-md-4 form-group">
														<label for="name" class="col-form-label">Medicare number</label>
														<input type="text" class="form-control form-control-md" id="medicareNumber" name="medicareNumber" > 
													</div>
													<div class="col-md-4 form-group">
														<label for="name" class="col-form-label">Medicare expiration</label>
														<input type="date" class="form-control form-control-md" id="medicareExpiration" name="medicareExpiration"> 
													</div>
														<div class="col-md-4 form-group">
															<label for="recipient-name" class="col-form-label">Medicare file </label>
															<input accept="image/png, image/gif, image/jpeg" type="file" onchange="validateSize(this)" type="file" class="form-control form-control-md" id="medicareFile" name="medicareFile" > 
														</div>
													</div>
													<!--  -->
													<div class="row">
														<div class="col-md-4 form-group">
														<label for="name" class="col-form-label">Citizenship number</label>
														<input type="text" class="form-control form-control-md" id="citizenshipNumber" name="citizenshipNumber" > 
													</div>
													<div class="col-md-4 form-group">
														<label for="name" class="col-form-label">Citizenship expiration</label>
														<input type="date" class="form-control form-control-md" id="citizenshipExpiration" name="citizenshipExpiration"> 
													</div>
														<div class="col-md-4 form-group">
															<label for="recipient-name" class="col-form-label">Citizenship file </label>
															<input accept="image/png, image/gif, image/jpeg" type="file" onchange="validateSize(this)" type="file" class="form-control form-control-md" id="citizenshipFile" name="citizenshipFile" > 
														</div>
													</div>
													<!--  -->
													<div class="row">
														<div class="col-md-4 form-group">
														<label for="name" class="col-form-label">Birthcertificate number</label>
														<input type="text" class="form-control form-control-md" id="birthcertificateNumber" name="birthcertificateNumber" > 
													</div>
													<div class="col-md-4 form-group">
														<label for="name" class="col-form-label">Birthcertificate expiration</label>
														<input type="date" class="form-control form-control-md" id="birthcertificateExpiration" name="birthcertificateExpiration"> 
													</div>
														<div class="col-md-4 form-group">
															<label for="recipient-name" class="col-form-label">Birthcertificate file </label>
															<input accept="image/png, image/gif, image/jpeg" type="file" onchange="validateSize(this)" type="file" class="form-control form-control-md" id="birthcertificateFile" name="birthcertificateFile" > 
														</div>
													</div>
													<!--  -->
													<div class="row">
														<div class="col-md-4 form-group">
														<label for="name" class="col-form-label">Passport number</label>
														<input type="text" class="form-control form-control-md" id="passportNumber" name="passportNumber" > 
													</div>
													<div class="col-md-4 form-group">
														<label for="name" class="col-form-label">Passport expiration</label>
														<input type="date" class="form-control form-control-md" id="passportExpiration" name="passportExpiration"> 
													</div>
														<div class="col-md-4 form-group">
															<label for="recipient-name" class="col-form-label">Passport file </label>
															<input accept="image/png, image/gif, image/jpeg" type="file" onchange="validateSize(this)" type="file" class="form-control form-control-md" id="passportFile" name="passportFile" > 
														</div>
													</div>
													<!--  -->
													<div class="row">
														<div class="col-md-4 form-group">
														<label for="name" class="col-form-label">Visa number</label>
														<input type="text" class="form-control form-control-md" id="visaNumber" name="visaNumber" > 
													</div>
													<div class="col-md-4 form-group">
														<label for="name" class="col-form-label">Visa expiration</label>
														<input type="date" class="form-control form-control-md" id="visaExpiration" name="visaExpiration"> 
													</div>
														<div class="col-md-4 form-group">
															<label for="recipient-name" class="col-form-label">Visa file </label>
															<input accept="image/png, image/gif, image/jpeg" type="file" onchange="validateSize(this)" type="file" class="form-control form-control-md" id="visaFile" name="visaFile" > 
														</div>
													</div>
													<!--  -->
													<div class="row">
														<div class="col-md-4 form-group">
														<label for="name" class="col-form-label">Security License number</label>
														<input type="text" class="form-control form-control-md" id="securityLicenseNumber" name="securityLicenseNumber" > 
													</div>
													<div class="col-md-4 form-group">
														<label for="name" class="col-form-label">Security License expiration</label>
														<input type="date" class="form-control form-control-md" id="securityLicenseExpiration" name="securityLicenseExpiration"> 
													</div>
														<div class="col-md-4 form-group">
															<label for="recipient-name" class="col-form-label">Security License file </label>
															<input accept="image/png, image/gif, image/jpeg" type="file" onchange="validateSize(this)" type="file" class="form-control form-control-md" id="securityLicenseFile" name="securityLicenseFile" > 
														</div>
													</div>
													<!--  -->
													<div class="row">
														<div class="col-md-4 form-group">
														<label for="name" class="col-form-label">Driver License number</label>
														<input type="text" class="form-control form-control-md" id="driverLicenseNumber" name="driverLicenseNumber" > 
													</div>
													<div class="col-md-4 form-group">
														<label for="name" class="col-form-label">Driver License expiration</label>
														<input type="date" class="form-control form-control-md" id="driverLicenseExpiration" name="driverLicenseExpiration"> 
													</div>
													<div class="col-md-4">
														 <div class="row">
														 
														<div class="col-md-6 form-group">
															<label for="recipient-name" class="col-form-label">Driver License file </label>
															<input accept="image/png, image/gif, image/jpeg" type="file" onchange="validateSize(this)" type="file" class="form-control form-control-md" id="driverLicenseFile" name="driverLicenseFile" > 
														</div>
														<div class="col-md-6 form-group">
															<label for="recipient-name" class="col-form-label">Driver License file back</label>
															<input accept="image/png, image/gif, image/jpeg" type="file" onchange="validateSize(this)" type="file" class="form-control form-control-md" id="driverLicenseFileBack" name="driverLicenseFileBack" > 
														</div>
														</div>
													</div>
													</div>
													<!--  -->
													<div class="row">
														<div class="col-md-4 form-group">
														<label for="name" class="col-form-label">Firstaid license number</label>
														<input type="text" class="form-control form-control-md" id="firstaidLicenseNumber" name="firstaidLicenseNumber" > 
													</div>
													<div class="col-md-4 form-group">
														<label for="name" class="col-form-label">Firstaid license expiration</label>
														<input type="date" class="form-control form-control-md" id="firstaidLicenseExpiration" name="firstaidLicenseExpiration"> 
													</div>
														<div class="col-md-4 form-group">
															<label for="recipient-name" class="col-form-label">Firstaid license file </label>
															<input accept="image/png, image/gif, image/jpeg" type="file" onchange="validateSize(this)" type="file" class="form-control form-control-md" id="firstaidLicenseFile" name="firstaidLicenseFile" > 
														</div>
													</div>
													<!--  -->
													<div class="row">
														<div class="col-md-4 form-group">
														<label for="name" class="col-form-label">Firearm license number</label>
														<input type="text" class="form-control form-control-md" id="firearmLicenseNumber" name="firearmLicenseNumber" > 
													</div>
													<div class="col-md-4 form-group">
														<label for="name" class="col-form-label">Firearm license expiration</label>
														<input type="date" class="form-control form-control-md" id="firearmLicenseExpiration" name="firearmLicenseExpiration"> 
													</div>
														<div class="col-md-4 form-group">
															<label for="recipient-name" class="col-form-label">Firearm license file </label>
															<input accept="image/png, image/gif, image/jpeg" type="file" onchange="validateSize(this)" type="file" class="form-control form-control-md" id="firearmLicenseFile" name="firearmLicenseFile" > 
														</div>
													</div>

													<div class="row ids-document" id="guard-document-container">
													   
													</div>
													<div class="row mt-4 py-5">
													    <div class="col-md-4 form-group"></div>
													    <div class="col-md-4 form-group">
													        <button type="button" class="btn btn-info btn-sm btn-block _ac-add-more-ids-btn"> Add more Document
													            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-earmark-plus-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
													                <path fill-rule="evenodd" d="M2 2a2 2 0 0 1 2-2h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm7.5 1.5v-2l3 3h-2a1 1 0 0 1-1-1zM8.5 7a.5.5 0 0 0-1 0v1.5H6a.5.5 0 0 0 0 1h1.5V11a.5.5 0 0 0 1 0V9.5H10a.5.5 0 0 0 0-1H8.5V7z"/>
													            </svg>
													        </button>

													    </div>
													</div>

													</form>
													
													
													
												</div>
												<!--end::Wrapper-->
											</div>
											<!--end::Step 3-->
											<!--begin::Step 4-->
											<div data-kt-stepper-element="content">
												<!--begin::Wrapper-->
												<div class="w-100">
													<!--begin::Heading-->
													<div class="pb-10 pb-lg-15">
														<!--begin::Title-->
														<h2 class="fw-bolder text-dark">Enable work limitation</h2>
														<!--end::Title-->
													</div>
													<!--end::Heading-->
													<form id="work-limitation-form" class="form" action="{{url('guard/personal_form')}}" method="POST" enctype="multipart/form-data">
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
												</form>
													
													
													
												</div>
												<!--end::Wrapper-->
											</div>
											<!--end::Step 4-->
											<!--begin::Step 5-->
											<div data-kt-stepper-element="content">
												<!--begin::Wrapper-->
												<div class="w-100">
													<!--begin::Heading-->
													<div class="pb-10 pb-lg-15">
														<!--begin::Title-->
														<h2 class="fw-bolder text-dark">Payroll</h2>
														<!--end::Title-->
														
													</div>
													<!--end::Heading-->
													<form id="payroll-form" class="form" action="{{url('guard/personal_form')}}" method="POST" enctype="multipart/form-data">
																    @csrf
													<div class="row">
															<div class="col-md-4 form-group">
																<label for="name" class="col-form-label">TFN</label>
																<input type="text" class="form-control form-control-md"  id="payroll_tfn_number" name="payroll_tfn_number"> 
															</div>
															<div class="col-md-4 form-group">
																<label for="name" class="col-form-label">ABN</label>
																<input type="text" class="form-control form-control-md"  id="payroll_abn_number" name="payroll_abn_number"> 
															</div>
															<div class="col-md-4 form-group">
																<label for="name" class="col-form-label">Superannutation</label>
																<input type="text" class="form-control form-control-md"  id="payroll_superannutation" name="payroll_superannutation"> 
															</div>
													</div>
													<div class="row">
															<div class="col-md-4 form-group">
																<label for="name" class="col-form-label">Bank Name</label>
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
												</form>
													
													
													
												</div>
												<!--end::Wrapper-->
											</div>
											<!--end::Step 5-->
											<!--begin::Step 6-->
											<div data-kt-stepper-element="content">
												<!--begin::Wrapper-->
												<div class="w-100">
													<!--begin::Heading-->
													<div class="pb-10 pb-lg-15">
														<!--begin::Title-->
														<h2 class="fw-bolder text-dark">Pay Rates</h2>
														<!--end::Title-->
														
													</div>
													<!--end::Heading-->
													<form id="pay-rates-form" class="form" action="{{url('guard/personal_form')}}" method="POST" enctype="multipart/form-data">
																    @csrf
													<div class="row rates-section" style="">
    <div class="col-md-6">
            <div class="fv-row mb-10">
    	<h4 class="text-center">Default Rates</h4></div>
    </div>
    <div class="col-md-3 form-group">
            <div class="fv-row mb-10">
        <label for="recipient-name" class="col-form-label">Job Level</label>
        <select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" name="job_level">
            <option value="1">Level 1</option>
            <option value="2">Level 2</option>
            <option value="3">Level 3</option>
            <option value="4">Level 4</option>
            <option value="5">Level 5</option>
        </select>
    </div>
    </div>
    <div class="col-md-3 form-group">
        <div class="fv-row mb-10">
        <label for="recipient-name" class="col-form-label">State</label>
        <select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" name="payrates_state">
            <option value="Victoria">Victoria</option>
            <option value="New South Wales">NSW</option>
            <option value="Queensland">Queensland</option>
            <option value="Tasmania">Tasmania</option>
            <option value="Western Australia">Western Australia</option>
            <option value="South Australia">South Australia</option>
            <option value="ACT">ACT</option>
        </select>
    </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="rTable">
            <div class="rTableBody">
                <div class="rTableRow">
                    <div class="rTableHead text-center">Metro</div>
                    <div class="rTableHead">&nbsp;</div>
                    <div class="rTableHead text-center">Regional</div>
                </div>
                <div class="rTableRow">
                    <div class="rTableCell"><input class="form-control form-control-md" name="flat_metro_week_day" type="number"></div>
                    <div class="rTableCell text-center">Mon-Fri</div>
                    <div class="rTableCell"><input class="form-control form-control-md" name="flat_regional_week_day" type="number"></div>
                </div>
                <div class="rTableRow">
                    <div class="rTableCell"><input class="form-control form-control-md" name="flat_metro_weekend" type="number"></div>
                    <div class="rTableCell text-center">Sat-Sun</div>
                    <div class="rTableCell"><input class="form-control form-control-md" name="flat_regional_weekend" type="number"></div>
                </div>
                <div class="rTableRow">
                    <div class="rTableCell"><input class="form-control form-control-md" name="flat_metro_public_holiday" type="number"></div>
                    <div class="rTableCell text-center">Public Holiday</div>
                    <div class="rTableCell"><input class="form-control form-control-md" name="flat_regional_public_holiday" type="number"></div>
                </div>
            </div>
        </div>


    </div>

</div>
<hr>

<div class="row rates-section">
    <div class="col-md-6"><h4 class="text-center">EBA-Awards</h4></div>
    
</div>


<div class="row rates-section">
    <div class="col-md-12">
        <div class="rTable">
            <div class="rTableBody">
                <div class="rTableRow">
                    <div class="rTableHead text-center">Metro</div>
                    <div class="rTableHead">&nbsp;</div>
                    <div class="rTableHead text-center">Regional</div>
                </div>
                <div class="rTableRow">
                    <div class="rTableCell"><input class="form-control form-control-md" name="eba_metro_weekday_day" type="number"></div>
                    <div class="rTableCell text-center">Mon-Fri (Day 06:00-15:00)</div>
                    <div class="rTableCell"><input class="form-control form-control-md" name="eba_regional_weekday_day" type="number"></div>
                </div>
                <div class="rTableRow">
                    <div class="rTableCell"><input class="form-control form-control-md" name="eba_metro_weekday_afternoon" type="number"></div>
                    <div class="rTableCell text-center">Mon-Fri (afternoon 15:00-18:00)</div>
                    <div class="rTableCell"><input class="form-control form-control-md" name="eba_regional_weekday_afternoon" type="number"></div>
                </div>
                <div class="rTableRow">
                    <div class="rTableCell"><input class="form-control form-control-md" name="eba_metro_weekday_night" type="number"></div>
                    <div class="rTableCell text-center">Mon-Fri (Night 18:00-06:00)</div>
                    <div class="rTableCell"><input class="form-control form-control-md" name="eba_regional_weekday_night" type="number"></div>
                </div>
                <div class="rTableRow">
                    <div class="rTableCell"><input class="form-control form-control-md" name="eba_metro_weekend" type="number"></div>
                    <div class="rTableCell text-center">Weekend (Sat 00:01-Sun 23:59</div>
                    <div class="rTableCell"><input class="form-control form-control-md" name="eba_regional_weekend" type="number"></div>
                </div>
                <div class="rTableRow">
                    <div class="rTableCell"><input class="form-control form-control-md" name="eba_metro_public_holiday" type="number"></div>
                    <div class="rTableCell text-center">Public Holiday (00:01 till 23:59)</div>
                    <div class="rTableCell"><input class="form-control form-control-md" name="eba_regional_public_holiday" type="number"></div>
                </div>
            </div>
        </div>
        <br><br>
    </div>
</div>
													</form>
													
													
												</div>
												<!--end::Wrapper-->
											</div>
											<!--end::Step 6-->
											<!--begin::Step 7-->
											<div data-kt-stepper-element="content">
												<!--begin::Wrapper-->
												<div class="w-100">
													<!--begin::Heading-->
													<div class="pb-10 pb-lg-15">
														<!--begin::Title-->
														<h2 class="fw-bolder text-dark">Site Trained</h2>
														<!--end::Title-->
													</div>
													<!--end::Heading-->
													<form id="site-trained-form" class="form" action="{{url('guard/personal_form')}}" method="POST" enctype="multipart/form-data">
																    @csrf
													<div class="row">
															<div class="col-md-4 form-group">
																<label for="name" class="col-form-label">Customer Name</label>
														
															</div>
															<div class="col-md-4 form-group">
																<label for="name" class="col-form-label">Site Name</label>
																 
															</div>
															<div class="col-md-4 form-group">
																<label for="name" class="col-form-label">Induction Status</label>
															</div>
													</div>
													<div id="guard-site-trained-container">
													</div>
													<div class="row training-section">
													    <div class="col-md-4 form-group"></div>
													    <div class="col-md-4 form-group">
													        <button type="button" class="btn btn-success btn-sm btn-block _ac-add-more-site-train-btn">Add More
													            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-earmark-plus-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
													                <path fill-rule="evenodd" d="M2 2a2 2 0 0 1 2-2h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm7.5 1.5v-2l3 3h-2a1 1 0 0 1-1-1zM8.5 7a.5.5 0 0 0-1 0v1.5H6a.5.5 0 0 0 0 1h1.5V11a.5.5 0 0 0 1 0V9.5H10a.5.5 0 0 0 0-1H8.5V7z"></path>
													            </svg></button>
													    </div>
													    <div class="col-md-4 form-group"></div>
													</div>
												</form>
													
													
												</div>
												<!--end::Wrapper-->
											</div>
											<!--end::Step 7-->

											<!--begin::Step 7-->
											<div data-kt-stepper-element="content">
												<!--begin::Wrapper-->
												<div class="w-100">
													<!--begin::Heading-->
													<div class="pb-10 pb-lg-15">
														<!--begin::Title-->
														<h2 class="fw-bolder text-dark">Site Blocked</h2>
														<!--end::Title-->
													</div>
													<!--end::Heading-->
													<form id="site-trained-form" class="form" action="{{url('guard/personal_form')}}" method="POST" enctype="multipart/form-data">
																    @csrf
													<div class="row">
															<div class="col-md-4 form-group">
																<label for="name" class="col-form-label">Customer Name</label>
														
															</div>
															<div class="col-md-4 form-group">
																<label for="name" class="col-form-label">Site Name</label>
																 
															</div>
															<div class="col-md-4 form-group">
																<label for="name" class="col-form-label">Status</label>
															</div>
													</div>
													<div id="guard-site-blocked-container">
													</div>
													<div class="row training-section">
													    <div class="col-md-4 form-group"></div>
													    <div class="col-md-4 form-group">
													        <button type="button" class="btn btn-success btn-sm btn-block _ac-add-more-site-block-btn">Add More
													            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-earmark-plus-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
													                <path fill-rule="evenodd" d="M2 2a2 2 0 0 1 2-2h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm7.5 1.5v-2l3 3h-2a1 1 0 0 1-1-1zM8.5 7a.5.5 0 0 0-1 0v1.5H6a.5.5 0 0 0 0 1h1.5V11a.5.5 0 0 0 1 0V9.5H10a.5.5 0 0 0 0-1H8.5V7z"></path>
													            </svg></button>
													    </div>
													    <div class="col-md-4 form-group"></div>
													</div>
												</form>
													
													
												</div>
												<!--end::Wrapper-->
											</div>
											<!--end::Step 7-->
											
											
											
											
											<!--begin::Actions-->
											<div class="d-flex flex-stack pt-15">
												<!--begin::Wrapper-->
												<div class="mr-2">
													<button type="button" class="btn btn-lg btn-light-primary me-3" data-kt-stepper-action="previous">
													<!--begin::Svg Icon | path: icons/duotone/Navigation/Left-2.svg-->
													<span class="svg-icon svg-icon-4 me-1">
														<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
															<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																<polygon points="0 0 24 0 24 24 0 24" />
																<rect fill="#000000" opacity="0.3" transform="translate(15.000000, 12.000000) scale(-1, 1) rotate(-90.000000) translate(-15.000000, -12.000000)" x="14" y="7" width="2" height="10" rx="1" />
																<path d="M3.7071045,15.7071045 C3.3165802,16.0976288 2.68341522,16.0976288 2.29289093,15.7071045 C1.90236664,15.3165802 1.90236664,14.6834152 2.29289093,14.2928909 L8.29289093,8.29289093 C8.67146987,7.914312 9.28105631,7.90106637 9.67572234,8.26284357 L15.6757223,13.7628436 C16.0828413,14.136036 16.1103443,14.7686034 15.7371519,15.1757223 C15.3639594,15.5828413 14.7313921,15.6103443 14.3242731,15.2371519 L9.03007346,10.3841355 L3.7071045,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(9.000001, 11.999997) scale(-1, -1) rotate(90.000000) translate(-9.000001, -11.999997)" />
															</g>
														</svg>
													</span>
													<!--end::Svg Icon-->Back</button>
												</div>
												<!--end::Wrapper-->
												<!--begin::Wrapper-->
												<div>
													<button type="button" class="btn btn-lg btn-primary me-3" data-kt-stepper-action="submit">
														<span class="indicator-label">Submit
														<!--begin::Svg Icon | path: icons/duotone/Navigation/Right-2.svg-->
														<span class="svg-icon svg-icon-3 ms-2 me-0">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<polygon points="0 0 24 0 24 24 0 24" />
																	<rect fill="#000000" opacity="0.5" transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000)" x="7.5" y="7.5" width="2" height="9" rx="1" />
																	<path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
																</g>
															</svg>
														</span>
														<!--end::Svg Icon--></span>
														<span class="indicator-progress">Please wait...
														<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
													</button>
													<button type="button" class="btn btn-lg btn-primary" data-kt-stepper-action="next">Continue
													<!--begin::Svg Icon | path: icons/duotone/Navigation/Right-2.svg-->
													<span class="svg-icon svg-icon-4 ms-1 me-0">
														<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
															<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																<polygon points="0 0 24 0 24 24 0 24" />
																<rect fill="#000000" opacity="0.5" transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000)" x="7.5" y="7.5" width="2" height="9" rx="1" />
																<path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
															</g>
														</svg>
													</span>
													<!--end::Svg Icon--></button>
												</div>
												<!--end::Wrapper-->
											</div>
											<!--end::Actions-->
											</div>
										<!-- </form> -->
										<!--end::Form-->
									</div>
									<!--end::Stepper-->
								</div>
								<!--end::Card body-->
							</div>
							<!--end::Card-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Content-->
					<!--begin::Footer-->
					
					<!--end::Footer-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::Root-->
		<!--begin::Drawers-->
		<!--begin::Activities drawer-->
	
		<!--end::Activities drawer-->
		<!--begin::Chat drawer-->

		<!--begin::Scrolltop-->
		<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
			<!--begin::Svg Icon | path: icons/duotone/Navigation/Up-2.svg-->
			<span class="svg-icon">
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						<polygon points="0 0 24 0 24 24 0 24" />
						<rect fill="#000000" opacity="0.5" x="11" y="10" width="2" height="10" rx="1" />
						<path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero" />
					</g>
				</svg>
			</span>
			<!--end::Svg Icon-->
		</div>

		@stop

		@section('pageFooter')
		<!--end::Scrolltop-->
		<!--end::Main-->
		<!--begin::Javascript-->
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="{{asset('')}}plugins/global/plugins.bundle.js"></script>
		<script src="{{asset('')}}js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Page Custom Javascript(used by this page)-->
		<script src="{{asset('')}}js/custom/modals/create-account.js"></script>
		<script src="{{asset('')}}js/custom/widgets.js"></script>
		<script src="{{asset('')}}js/custom/apps/chat/chat.js"></script>
		<script src="{{asset('')}}js/custom/modals/create-app.js"></script>
		<script src="{{asset('')}}js/custom/modals/upgrade-plan.js"></script>
		<!--end::Page Custom Javascript-->
		<!--end::Javascript-->
		<!-- additional script by hussain -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxy/1.6.1/scripts/jquery.ajaxy.min.js"></script>
		<script type="text/javascript">
			$(document).on('click', '._ac-add-more-ids-btn', function(e) {
               getIDs($('._index').length);
           });
			function getIDs(index) {
				$.ajax({
					url: "{{url('guard/get_guard_ids_form')}}",
					data:{index: index, isGuard: false} ,
					type : "POST",
					success: function(result){
						console.log(result);
			      // $("#div1").html(result);
               $('#guard-ids-container').append(result);

			    }});
           
       }
       $(document).on('click', '._ac-add-more-site-block-btn', function(e) {
               
               getSiteBlocked($('._site-block-index').length);
           });
       function getSiteBlocked(index) {
       	$.ajax({
					url: "{{url('guard/get_guard_site_block_form')}}",
					data:{index: index, isGuard: false, _token : '{{ csrf_token()}}'} ,
					type : "POST",
					success: function(result){
			      // $("#div1").html(result);
               $('#guard-site-blocked-container').append(result);
               // getCustomers(index, 3);


			    }});
           
       }
       $(document).on('change', '._ac-site-block-customer-change', function(e) {
               var _this = $(this);
               var index = _this.attr('data-index');
               getCustomerJobs(_this.val(), index, 'site-block', '');
           });

       function getCustomerJobs (customerId, index, type, siteId) {

       	$.ajax({
					url: "{{url('job/get_customers_jobs')}}",
					data:{customerId: customerId, _token : '{{ csrf_token()}}'} ,
					type : "POST",
					success: function(response){
						console.log(response)
			    	// response = JSON.parse(response);
		               options = '<option value="">Select Site</option>';
		               $.each(response, function (id, data) {
		                var site_name = data.address;
		                if(data.site_name != ''){
		                  site_name = data.site_name +' ('+data.site_description+')';
		                }
		                   selected_check = (data.jobId === siteId) ? 'selected' : '';
		                   options += '<option '+ selected_check +' value="' + data.jobId + '">' + site_name + '</option>';
		               });
		               if (type === 'site-block') {
		                   $('#site_blocked_site-option-'+index).html(options);
		               } else if (type === 'site-trained') {
		                   $('#site_trained_site-option-'+index).html(options);
		               } else {
		                   $('#site_blocked_site-option-'+index).html(options);
		                   $('#site_trained_site-option-'+index).html(options);
		               }


			    }});

       }
       $(document).on('click', '._ac-add-more-site-train-btn', function(e) {
               getSiteTraine($('._site-train-index').length);
           });
       function getSiteTraine(index) {
               $.ajax({
					url: "{{url('guard/get_guard_site_train_form')}}",
					data:{index: index, _token : '{{ csrf_token()}}'} ,
					type : "POST",
					success: function(result){
			      // $("#div1").html(result);
               $('#guard-site-trained-container').append(result);
               // getCustomers(index, 2);
			    }});
           
       }
       $(document).on('change', '._ac-customer-change', function(e) {
               var _this = $(this);
               var index = _this.attr('data-index');
               var type = _this.attr('data-type');
               getCustomerJobs(_this.val(), index, 'site-trained', '');
           });

       
       var searchInput = 'googleaddress';
var componentForm = {
    // street_number: 'short_name',
  // route: 'long_name',
  locality: 'long_name',
  administrative_area_level_2: 'short_name',
  administrative_area_level_1: 'long_name',
  // country: 'long_name'
};
	 $(document).ready(function(){
         var options = {
  componentRestrictions: {country: "au"}
 };
   var autocomplete;
    autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), options, {
        types: ['geocode'],
    });
  
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        var near_place = autocomplete.getPlace();
        console.log(near_place.address_components)
        latitude = near_place.geometry.location.lat();
        logitude = near_place.geometry.location.lng();
        latlng = latitude+","+logitude
        $("#coordinate_display").val(latlng);
        $("#coordinates").val(latlng);
        for (var i = 0; i < near_place.address_components.length; i++) {
            var addressType = near_place.address_components[i].types[0];
            if (componentForm[addressType]) {
              var val = near_place.address_components[i][componentForm[addressType]];
              document.getElementById(addressType).value = val;
            }
          }
        // document.getElementById('latitude_view').innerHTML = near_place.geometry.location.lat();
        // document.getElementById('longitude_view').innerHTML = near_place.geometry.location.lng();
    });

});

	  var targetInput = '';
    function upload_file(i, j)
    {
        targetInput = j;
        // errorAlert('Please wait image is uploading...');
        readImage(document.getElementById(i), i);
    }

    function readImage(e, i) {
  if (e.files && e.files[0]) {

    var FR= new FileReader();

    FR.addEventListener("load", function(e) {
     var image =  e.target.result;
     if (image != '') {
     $.ajax({
        type: "POST",
        url: "{{url('guard/upload_files')}}",
        data : {image:image, _token : '{{ csrf_token()}}'},
        success: function(result){
        	console.log(result)
            var obj = result;
            if (obj.success) {
                $('#'+i).val('');
                // successAlert('Image upload successfully.');
                $('#'+targetInput).val(obj.path);
            }else{
            // errorAlert('Failed to upload image!');
                $('#'+i).val('');
            }

        }
        });

  }else{
    alertify.error('Not a valid image!')

  }
   }); 

    FR.readAsDataURL( e.files[0] );
  }

}
		</script>

@stop