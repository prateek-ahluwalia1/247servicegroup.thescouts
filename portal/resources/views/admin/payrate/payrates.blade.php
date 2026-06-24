

	@extends('layout.app')
	@extends('layout.sidebar')
	@extends('layout.footer')
	
	@section('pageCss')

	<base href="../../../">
		<meta charset="utf-8" />
		<title>{{ config('custom.title');}}</title>
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link rel="canonical" href="Https://preview.keenthemes.com/metronic8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!-- <link rel="shortcut icon" href="{{ asset('')}}media/logos/favicon.ico" /> -->
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Vendor Stylesheets(used by this page)-->
		<link href="{{ asset('')}}plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Page Vendor Stylesheets-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="{{ asset('')}}plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="{{ asset('')}}css/style.bundle.css" rel="stylesheet" type="text/css" />


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
	
		<!--begin::Main-->
		<!--begin::Root-->
	@section('content')
						<?php $type="created"; ?>
						<!--end::Logo-->
				
				<!--begin::Wrapper-->
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
					<!--begin::Header-->
					<div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
						<!--begin::Container-->
						<div class="container d-flex align-items-center justify-content-between" id="kt_header_container">
							<!--begin::Page title-->
							<div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-2 pb-2 pb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
								<!--begin::Heading-->
								<h1 class="text-dark fw-bolder my-0 fs-2">Pay Rates List</h1>
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
									<img alt="Logo" src="{{config('custom.logo')}}" class="h-30px" />
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
								<!--begin::Card header-->
								<div class="card-header border-0 pt-6" style="display: inline-block !important;">
									<!--begin::Card title-->
									<div class="card-title">
										<!--begin::Search-->
										<div class="d-flex align-items-center position-relative my-1">
											<!--begin::Svg Icon | path: icons/duotone/General/Search.svg-->
											<span class="svg-icon svg-icon-1 position-absolute ms-6">
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<rect x="0" y="0" width="24" height="24" />
														<path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
														<path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero" />
													</g>
												</svg>
											</span>
											<!--end::Svg Icon-->
											<input type="text" id="search"  class="form-control form-control-solid w-250px ps-14" placeholder="Search Pay Rate" />
										</div>
										<!--end::Search-->
									</div>
									<!--begin::Card title-->
									<!--begin::Card toolbar-->
									<div class="card-toolbar">
										<!--begin::Toolbar-->
										<div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
											<!--begin::Filter-->
							
											<!--begin::Menu 1-->
										
											<!--end::Menu 1-->
											<!--end::Filter-->
											<!--begin::Export-->
						<!-- 					<button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_export_users">
											<span class="svg-icon svg-icon-2">
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<rect x="0" y="0" width="24" height="24" />
														<path d="M17,8 C16.4477153,8 16,7.55228475 16,7 C16,6.44771525 16.4477153,6 17,6 L18,6 C20.209139,6 22,7.790861 22,10 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,9.99305689 C2,7.7839179 3.790861,5.99305689 6,5.99305689 L7.00000482,5.99305689 C7.55228957,5.99305689 8.00000482,6.44077214 8.00000482,6.99305689 C8.00000482,7.54534164 7.55228957,7.99305689 7.00000482,7.99305689 L6,7.99305689 C4.8954305,7.99305689 4,8.88848739 4,9.99305689 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,10 C20,8.8954305 19.1045695,8 18,8 L17,8 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
														<rect fill="#000000" opacity="0.3" transform="translate(12.000000, 8.000000) scale(1, -1) rotate(-180.000000) translate(-12.000000, -8.000000)" x="11" y="2" width="2" height="12" rx="1" />
														<path d="M12,2.58578644 L14.2928932,0.292893219 C14.6834175,-0.0976310729 15.3165825,-0.0976310729 15.7071068,0.292893219 C16.0976311,0.683417511 16.0976311,1.31658249 15.7071068,1.70710678 L12.7071068,4.70710678 C12.3165825,5.09763107 11.6834175,5.09763107 11.2928932,4.70710678 L8.29289322,1.70710678 C7.90236893,1.31658249 7.90236893,0.683417511 8.29289322,0.292893219 C8.68341751,-0.0976310729 9.31658249,-0.0976310729 9.70710678,0.292893219 L12,2.58578644 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 2.500000) scale(1, -1) translate(-12.000000, -2.500000)" />
													</g>
												</svg>
											</span>
										Export</button>
											 -->
										
											<!--begin::Add user-->
               
        		   
											<button type="button" id="#payrate-modal" class="btn btn-primary" onclick="add_modal()">
											<!--begin::Svg Icon | path: icons/duotone/Navigation/Plus.svg-->
											<span class="svg-icon svg-icon-2">
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
													<rect fill="#000000" x="4" y="11" width="16" height="2" rx="1" />
													<rect fill="#000000" opacity="0.5" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000)" x="4" y="11" width="16" height="2" rx="1" />
												</svg>
											</span>
											<!--end::Svg Icon--><span >Add Pay Rate</span></button>
											<!--end::Add user-->
										</div>
										<!--end::Toolbar-->
										<!--begin::Group actions-->
									<!-- 	<div class="d-flex justify-content-end align-items-center d-none" data-kt-user-table-toolbar="selected">
											<div class="fw-bolder me-5">
											<span class="me-2" data-kt-user-table-select="selected_count"></span>Selected</div>
											<button type="button" class="btn btn-danger" data-kt-user-table-select="delete_selected">Delete Selected</button>
										</div> -->
										<!--end::Group actions-->
										<!--begin::Modal - Adjust Balance-->
									
										<!--end::Modal - New Card-->
										<!-- active edit pay rate model -->
										<!--begin::Modal - edit task-->
										<div class="modal fade" id="payrate-modal" tabindex="-1" aria-hidden="true">
											<!--begin::Modal dialog-->
											<div class="modal-dialog modal-dialog-centered mw-650px">
												<!--begin::Modal content-->
												<div class="modal-content ">
													<!--begin::Modal header-->
													<div class="modal-header modal_custom_head" id="kt_modal_add_user_header">
														<!--begin::Modal title-->
														<h2 class="fw-bolder" id="form_head">Add Pay Rate</h2>
														<!--end::Modal title-->
														<!--begin::Close-->
														<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close"> <span class="svg-icon svg-icon-2x">X</span> </div>
														<!--end::Close-->
													</div>
													<!--end::Modal header-->
													<!--begin::Modal body-->
													<div class="modal-body modal_custom_body scroll-y mx-5 mx-xl-15 my-7 modal_card_custom ">
														<!--begin::Form-->
														<form id="payrates-form" class="form" action="{{url('create_payrate')}}" method="POST" enctype="multipart/form-data"> @csrf
															<input type="hidden" name="update_payrate_id" id="update_payrate_id">
															<!--begin::Scroll-->
															<div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
																<!--begin::Input group-->
																<div class="fv-row mb-7">
																	<!--begin::Label-->
																	<label class="required fw-bold fs-6 mb-2">Title</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="text" id="title-name" name="title" class="form-control form-control-solid mb-3 mb-lg-0 form-control-md" placeholder="Title" value="" required />
																	<!--end::Input-->
																</div>
																<!--end::Input group-->
																<!--begin::Input group-->

																	<div class="fv-row mb-7">
																		<!--begin::Label-->
																		<label class="required fw-bold fs-6 mb-2">Customer</label>
																		<!--end::Label-->
																		<!--begin::Input-->
																		<select class="form-select form-select-lg form-select-solid" data-placeholder="Select..." name="customer_id" required="" id="customer_id">
																			<option value="">Select Customer</option>
																			@foreach($customers as $customer)
																			<option value="{{$customer->id}}">{{$customer->name}}</option>
																			@endforeach
																		</select>
																		<!--end::Input-->
																	</div>
																	<!--end::Input group-->
																<!--begin::Input group-->

																	<!-- <div class="fv-row mb-7">
																		<label class="required fw-bold fs-6 mb-2">Date</label>
																		<input type="date" id="effective_date" name="effective_date" class="form-control form-control-solid mb-3 mb-lg-0 form-control-md datepicker flatpickr-input" placeholder="Effective Date" value=""  />
																	</div> -->
																	<!--end::Input group-->
																<!--begin::Input group-->
																<input type="hidden" id="payrate_id" name="payrate_id" />
																<div class="row rates-section" style="">
																	<div class="col-md-4" style="display: none;">
																		<div class="fv-row mb-10">
																				<label for="recipient-name" class="col-form-label">Position</label>
																				<select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" id="position" name="position" onchange="load_guard_payrates(0, 'job_level', 'payrates_state', 'position')">
															<option value="full_time">Full-time</option>
															<option value="part_time" >Part-time</option>
															<option value="casual" >Casual</option>
														</select>
																			</div>
																	 </div>
																	<div class="col-md-6 form-group">
																		<div class="fv-row mb-10">
																			<label for="recipient-name" class="col-form-label">Job Level</label>
																			<select class="form-select form-select-lg form-select-solid" data-placeholder="Select..." name="job_level" id="job_level" onchange="load_guard_payrates(0, 'job_level', 'payrates_state', 'position')">
																				<option value="1">Level 1</option>
																				<option value="2">Level 2</option>
																				<option value="3">Level 3</option>
																				<option value="4">Level 4</option>
																				<option value="5">Level 5</option>
																			</select>
																		</div>
																	</div>
																	<div class="col-md-6 form-group">
																		<div class="fv-row mb-10">
																			<label for="recipient-name" class="col-form-label">State</label>
																			<select class="form-select  form-select-solid" data-placeholder="Select..." name="payrates_state" id="payrates_state" onchange="load_guard_payrates(0, 'job_level', 'payrates_state', 'position')">
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
																						<div class="rTableCell">
																							<input value="0" class="form-control form-control-md" name="flat_metro_week_day_day" type="number" step="any">
																						</div>
																						<div class="rTableCell text-center">Mon-Fri(Day 06:00 - 18:00)</div>
																						<div class="rTableCell">
																							<input value="0" class="form-control form-control-md" name="flat_regional_week_day_day" type="number" step="any">
																						</div>
																					</div>
																					<div class="rTableRow">
																						<div class="rTableCell">
																							<input value="0" class="form-control form-control-md" name="flat_metro_week_day_night" type="number" step="any">
																						</div>
																						<div class="rTableCell text-center">Mon-Fri(Night 18:00 - 06:00)</div>
																						<div class="rTableCell">
																							<input value="0" class="form-control form-control-md" name="flat_regional_week_day_night" type="number" step="any">
																						</div>
																					</div>	
																					<div class="rTableRow" style="display: none;">
																						<div class="rTableCell">
																							<input value="0" class="form-control form-control-md" name="flat_metro_friday" type="number" step="any">
																						</div>
																						<div class="rTableCell text-center">Friday (00:01 till 23:59)</div>
																						<div class="rTableCell">
																							<input value="0" class="form-control form-control-md" name="flat_regional_friday" type="number" step="any">
																						</div>
																					</div>
																					<div class="rTableRow">
																						<div class="rTableCell">
																							<input value="0" class="form-control form-control-md" name="flat_metro_saturday" type="number" step="any">
																						</div>
																						<div class="rTableCell text-center">Saturday (Day 06:00 - 18:00)</div>
																						<div class="rTableCell">
																							<input value="0" class="form-control form-control-md" name="flat_regional_saturday" type="number" step="any">
																						</div>
																					</div>
																					<div class="rTableRow">
																						<div class="rTableCell">
																							<input value="0" class="form-control form-control-md" name="flat_metro_saturday_night" type="number" step="any">
																						</div>
																						<div class="rTableCell text-center">Saturday (Night 18:00 - 06:00)</div>
																						<div class="rTableCell">
																							<input value="0" class="form-control form-control-md" name="flat_regional_saturday_night" type="number" step="any">
																						</div>
																					</div>
																					<div class="rTableRow">
																						<div class="rTableCell">
																							<input value="0" class="form-control form-control-md" name="flat_metro_sunday" type="number" step="any">
																						</div>
																						<div class="rTableCell text-center">Sunday (Day 06:00 - 18:00)</div>
																						<div class="rTableCell">
																							<input value="0" class="form-control form-control-md" name="flat_regional_sunday" type="number" step="any">
																						</div>
																					</div>
																					<div class="rTableRow">
																						<div class="rTableCell">
																							<input value="0" class="form-control form-control-md" name="flat_metro_sunday_night" type="number" step="any">
																						</div>
																						<div class="rTableCell text-center">Sunday (Night 18:00 - 06:00)</div>
																						<div class="rTableCell">
																							<input value="0" class="form-control form-control-md" name="flat_regional_sunday_night" type="number" step="any">
																						</div>
																					</div>
																				<!-- <div class="rTableRow">
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="flat_metro_week_day" type="number" step="any">
																					</div>
																					<div class="rTableCell text-center">Mon-Fri</div>
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="flat_regional_week_day" type="number" step="any">
																					</div>
																				</div>
																				<div class="rTableRow">
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="flat_metro_weekend" type="number" step="any">
																					</div>
																					<div class="rTableCell text-center">Sat	</div>
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="flat_regional_weekend" type="number" step="any">
																					</div>
																				</div> -->
																				<div class="rTableRow">
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="flat_metro_public_holiday" type="number" step="any">
																					</div>
																					<div class="rTableCell text-center">Public Holiday (Day 06:00 - 18:00)</div>
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="flat_regional_public_holiday" type="number" step="any">
																					</div>
																				</div>
																				<div class="rTableRow">
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="flat_metro_public_holiday_night" type="number" step="any">
																					</div>
																					<div class="rTableCell text-center">Public Holiday (Night 18:00 - 06:00)</div>
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="flat_regional_public_holiday_night" type="number" step="any">
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
																<hr>
																<div class="row rates-section">
																	<div class="col-md-6">
																		<h4 class="text-center">EBA-Awards</h4></div>
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
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="eba_metro_weekday_day" type="number" step="any">
																					</div>
																					<div class="rTableCell text-center">Mon-Fri (Day 06:00-18:00)</div>
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="eba_regional_weekday_day" type="number" step="any">
																					</div>
																				</div>
																				<!-- <div class="rTableRow">
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="eba_metro_weekday_afternoon" type="number" step="any">
																					</div>
																					<div class="rTableCell text-center">Mon-Fri (afternoon 15:00-18:00)</div>
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="eba_regional_weekday_afternoon" type="number" step="any">
																					</div>
																				</div> -->
																				<div class="rTableRow">
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="eba_metro_weekday_night" type="number" step="any">
																					</div>
																					<div class="rTableCell text-center">Mon-Fri (Night 18:00-06:00)</div>
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="eba_regional_weekday_night" type="number" step="any">
																					</div>
																				</div>
																				<div class="rTableRow">
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="eba_metro_saturday_day" type="number" step="any">
																					</div>
																					<div class="rTableCell text-center">Saturday (Day 06:00 till 18:00)</div>
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="eba_regional_saturday_day" type="number" step="any">
																					</div>
																				</div>
																				<div class="rTableRow">
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="eba_metro_saturday_night" type="number" step="any">
																					</div>
																					<div class="rTableCell text-center">Saturday (Night 06:00 till 18:00)</div>
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="eba_regional_saturday_night" type="number" step="any">
																					</div>
																				</div>
																				<div class="rTableRow">
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="eba_metro_sunday_day" type="number" step="any">
																					</div>
																					<div class="rTableCell text-center">Sunday (Day 06:00 till 18:00)</div>
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="eba_regional_sunday_day" type="number" step="any">
																					</div>
																				</div>
																				<div class="rTableRow">
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="eba_metro_sunday_night" type="number" step="any">
																					</div>
																					<div class="rTableCell text-center">Sunday (Night 18:00 till 06:00)</div>
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="eba_regional_sunday_night" type="number" step="any">
																					</div>
																				</div>
																				<div class="rTableRow">
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="eba_metro_public_holiday" type="number" step="any">
																					</div>
																					<div class="rTableCell text-center">Public Holiday (Day 06:00 till 18:00)</div>
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="eba_regional_public_holiday" type="number" step="any">
																					</div>
																				</div>
																				<div class="rTableRow">
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="eba_metro_public_holiday_night" type="number" step="any">
																					</div>
																					<div class="rTableCell text-center">Public Holiday (Night 18:00 till 06:00)</div>
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="eba_regional_public_holiday_night" type="number" step="any">
																					</div>
																				</div>
																			</div>
																		<br>
																		<br> </div>
																		<div class="col-12">
																			<!--begin::Input group-->
																<div class="fv-row mb-7">
																	<!--begin::Label-->
																	<label class="required fw-bold fs-6 mb-2">OT base rate</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="text" id="ot_base_rate" name="ot_base_rate" class="form-control form-control-solid mb-3 mb-lg-0 form-control-md" placeholder="TT Base Rate" value="22.84"/>
																	<!--end::Input-->
																</div>
																<!--end::Input group-->
																		</div>
																</div>
																</br>
																<button type="button" class="btn btn-primary" id="save-btn" data-kt-users-modal-action="" onclick="savePayrate_edit()"> <span class="indicator-label" id="">Save</span>
																</button>
																</br>
																</br>
															</div>
															<!--end::Scroll-->
															<!--begin::Actions-->
															<div id="form_submit-button" class="text-center pt-15">

																<button type="button" class="btn btn-white me-3" data-bs-dismiss="modal" aria-label="Close">Discard</button>
																<button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit"> <span class="indicator-label" id="form_button">Submit</span> <span class="indicator-progress">Please wait...
																											<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
																</button>
															</div>
															<!--end::Actions-->
														</form>
														<!--end::Form-->
													</div>
													<!--end::Modal body-->
												</div>
												<!--end::Modal content-->
											</div>
											<!--end::Modal dialog-->
										</div>
										<!--end::Modal - edit task-->

										
										
										
										
									</div>
									<!--end::Card toolbar-->
								</div>
								<!--end::Card header-->
								<!--begin::Card body-->
								<div class="card-body pt-0">
									<div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                                    <div class="d-flex overflow-auto h-55px">
                                        <ul
                                            class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6 nav-stretch  nav-fill nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder flex-nowrap">
                                                <li class="nav-item">

                                                    <a class="nav-link text-active-primary me-6 {{$rate_type == 'Active' ? 'active' : ''}}" href="{{url('payrates')}}">Active</a>

                                                </li>
                                                <li class="nav-item">

                                                    <a class="nav-link  text-active-primary me-6 {{$rate_type == 'Archive' ? 'active' : ''}}" 
                                                        href="{{url('payrates?type=archive')}}">Archive</a>

                                                </li>
                                            </ul>
                                        </div>
                                    </div>
									<!--begin::Table-->
									<table class="table align-middle table-row-dashed fs-6 gy-5" id="table">
										<!--begin::Table head-->
										<thead>
											<!--begin::Table row-->
											<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
												<th class="w-10px pe-2">
													<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
														<input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_table_users .form-check-input" value="1" />
													</div>
												</th>
												<th class="min-w-125px">PayRate</th>
											
												<th class="min-w-125px">state</th>
												<th class="min-w-125px">Job Level</th>
												<th class="min-w-125px">{{$rate_type}}</th>
											<th class="min-w-125px"></th>
											</tr>
											<!--end::Table row-->
										</thead>
										<!--end::Table head-->
										<!--begin::Table body-->
										<tbody class="text-gray-600 fw-bold">
											<!--begin::Table row-->
											@foreach($payrates as $payrate)
											
											<tr>
												<!--begin::Checkbox-->
												<td>
													<div class="form-check form-check-sm form-check-custom form-check-solid">
														<input class="form-check-input" type="checkbox" value="1" />
													</div>
												</td>
												<!--end::Checkbox-->
												<!--begin::User=-->
												<td class="d-flex align-items-center">
													<!--begin:: Avatar -->
												
													<!--end::Avatar-->
													<!--begin::User details-->
													<div class="d-flex flex-column">
														<a  class="text-gray-800 text-hover-primary mb-1" type="button"  data-bs-toggle="modal" data-bs-target="" onclick="get_payrates_detail( {{ $payrate->id }})">{{$payrate->title}}</a>
													</div>
													<!--begin::User details-->
												</td>
												<!--end::User=-->
												<!--begin::Role=-->


												<!--end::Role=-->
												<!--begin::Last login=-->
											
												<!--end::Last login=-->
												<!--begin::Two step=-->
												<!-- <td></td> -->
												<!--end::Two step=-->
												<!--begin::Joined-->
												<td>
													{{$payrate->state}}
												</td>
												<td>
													@foreach($payrate->groupData as  $index => $data)
													{{$data->level}}
													@if($index < count($payrate->groupData)-1)
													,
													@endif
													@endforeach
												</td>

												<td>
												<div class="form-check form-check-solid form-switch fv-row">

														
														<input class="form-check-input w-45px h-30px" type="checkbox" id="active_inactive_status" name="active_inactive_status" onchange="changeStatus({{$payrate->id}},this)" {{$payrate->archive == 1 ? 'checked' : ''}}>
																											
													</div>
											</td>
												<!--begin::Joined-->
												<!--begin::Action=-->
												<td class="text-end">
													<a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">Actions
													<!--begin::Svg Icon | path: icons/duotone/Navigation/Angle-down.svg-->
													<span class="svg-icon svg-icon-5 m-0">
														<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
															<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																<polygon points="0 0 24 0 24 24 0 24" />
																<path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999)" />
															</g>
														</svg>
													</span>
													<!--end::Svg Icon--></a>
													<!--begin::Menu-->
													<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
														<!--begin::Menu item-->
														<!-- <div class="menu-item px-3">
														<a type="button" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="" onclick="get_payrates( {{ $payrate->id }})">Edit</a>
														</div> -->
														<!--end::Menu item-->
														<!--begin::Menu item-->
														<div class="menu-item px-3">
															<a type="button" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="" onclick="delete_payrate( {{ $payrate->id }})" >Delete</a>
														</div>
														<!--end::Menu item-->
													</div>
													<!--end::Menu-->
												</td>
												<!--end::Action=-->
											</tr>

											@endforeach
											<!--end::Table row-->
										</tbody>
										<!--end::Table body-->
									</table>
									<!--end::Table-->
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
			
		<!--end::Root-->
		<!--begin::Drawers-->
		<!--begin::Activities drawer-->
		
		<!--end::Chat drawer-->
		<!-- active add payrate -->
		<!--begin::Exolore drawer toggle-->
		<div class="modal fade" id="payrate-modal_add" tabindex="-1">
											<!--begin::Modal dialog-->
											<div class="modal-dialog modal-dialog-centered mw-650px">
												<!--begin::Modal content-->
												<div class="modal-content">
													<!--begin::Modal header-->
													<div class="modal-header modal_custom_head" id="kt_modal_add_user_header">
														<!--begin::Modal title-->
														<h2 class="fw-bolder" id="form_head">Add Pay Rate</h2>
														<!--end::Modal title-->
														<!--begin::Close-->
														<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close"> <span class="svg-icon svg-icon-2x">X</span> </div>
														<!--end::Close-->
													</div>
													<!--end::Modal header-->
													<!--begin::Modal body-->
													<div class="modal-body modal_custom_body scroll-y mx-5 mx-xl-15 my-7 modal_card_custom">
														<!--begin::Form-->

											
														<form id="payrates-form_add" class="form" action="{{url('create_payrate')}}" method="POST" enctype="multipart/form-data"> @csrf
															<!--begin::Scroll-->
															<div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
																<!--begin::Input group-->
																<div class="fv-row mb-7">
																	<!--begin::Label-->
																	<label class="required fw-bold fs-6 mb-2">Title</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="text" id="title" name="title" class="form-control form-control-solid mb-3 mb-lg-0 form-control-md" placeholder="Title" value="" required />
																	<!--end::Input-->
																</div>
																<!--end::Input group-->
																<!--begin::Input group-->

																	<div class="fv-row mb-7">
																		<!--begin::Label-->
																		<label class="required fw-bold fs-6 mb-2">Customer</label>
																		<!--end::Label-->
																		<!--begin::Input-->
																		<select class="form-select form-select-lg form-select-solid" data-placeholder="Select..." name="customer_id" required="">
																			<option value="">Select Customer</option>
																			@foreach($customers as $customer)
																			<option value="{{$customer->id}}">{{$customer->name}}</option>
																			@endforeach
																		</select>
																		<!--end::Input-->
																	</div>
																	<!--end::Input group-->
																<!--begin::Input group-->
																	<!-- <div class="fv-row mb-7">
																		<label class="required fw-bold fs-6 mb-2">Date</label>
																		<input type="date" name="effective_date" class="form-control form-control-solid mb-3 mb-lg-0 form-control-md datepicker flatpickr-input" placeholder="Effective Date" value="" required />
																	</div> -->
																	<!--end::Input group-->
																<!--begin::Input group-->
																<div class="row rates-section" style="">
																	<div class="col-md-4"> 
																	<div class="fv-row mb-10">
																				<label for="recipient-name" class="col-form-label">Position</label>
																				<select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" id="position" name="position">
															<option value="full_time">Full-time</option>
															<option value="part_time" >Part-time</option>
															<option value="casual" >Casual</option>
														</select>
																			</div> 
																		</div>
																	<div class="col-md-4 form-group">
																		<div class="fv-row mb-10">
																			<label for="recipient-name" class="col-form-label">Job Level</label>
																			<select class="form-select form-select-lg form-select-solid" data-placeholder="Select..." name="job_level" id="job_level" onchange="load_guard_payrates()">
																				<option value="1">Level 1</option>
																				<option value="2">Level 2</option>
																				<option value="3">Level 3</option>
																				<option value="4">Level 4</option>
																				<option value="5">Level 5</option>
																			</select>
																		</div>
																	</div>
																	<div class="col-md-4 form-group">
																		<div class="fv-row mb-10">
																			<label for="recipient-name" class="col-form-label">State</label>
																			<select class="form-select  form-select-solid" data-placeholder="Select..." name="payrates_state" id="payrates_state" onchange="load_guard_payrates()">
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
																						<div class="rTableCell">
																							<input value="0" class="form-control form-control-md" name="flat_metro_week_day_day" type="number" step="any">
																						</div>
																						<div class="rTableCell text-center">Mon-Fri(Day 06:00 - 18:00)</div>
																						<div class="rTableCell">
																							<input value="0" class="form-control form-control-md" name="flat_regional_week_day_day" type="number" step="any">
																						</div>
																					</div>
																					<div class="rTableRow">
																						<div class="rTableCell">
																							<input value="0" class="form-control form-control-md" name="flat_metro_week_day_night" type="number" step="any">
																						</div>
																						<div class="rTableCell text-center">Mon-Fri(Night 18:00 - 06:00)</div>
																						<div class="rTableCell">
																							<input value="0" class="form-control form-control-md" name="flat_regional_week_day_night" type="number" step="any">
																						</div>
																					</div>	
																					<div class="rTableRow" style="display: none;">
																						<div class="rTableCell">
																							<input value="0" class="form-control form-control-md" name="flat_metro_friday" type="number" step="any">
																						</div>
																						<div class="rTableCell text-center">Friday (00:01 till 23:59)</div>
																						<div class="rTableCell">
																							<input value="0" class="form-control form-control-md" name="flat_regional_friday" type="number" step="any">
																						</div>
																					</div>
																					<div class="rTableRow">
																						<div class="rTableCell">
																							<input value="0" class="form-control form-control-md" name="flat_metro_saturday" id="flat_metro_saturday" type="number" step="any" onchange="copyValue('flat_metro_saturday', 'flat_metro_saturday_night')">
																						</div>
																						<div class="rTableCell text-center">Saturday </div>
																						<div class="rTableCell">
																							<input value="0" class="form-control form-control-md" name="flat_regional_saturday" id="flat_regional_saturday" type="number" step="any" onchange="copyValue('flat_regional_saturday', 'flat_regional_saturday_night')">
																						</div>
																					</div>
																					<div class="rTableRow" style="display:none;">
																						<div class="rTableCell">
																							<input value="0" class="form-control form-control-md" name="flat_metro_saturday_night" id="flat_metro_saturday_night" type="number" step="any">
																						</div>
																						<div class="rTableCell text-center">Saturday (Night 18:00 - 06:00)</div>
																						<div class="rTableCell">
																							<input value="0" class="form-control form-control-md" name="flat_regional_saturday_night" id="flat_regional_saturday_night" type="number" step="any">
																						</div>
																					</div>
																					<div class="rTableRow">
																						<div class="rTableCell">
																							<input value="0" class="form-control form-control-md" name="flat_metro_sunday" id="flat_metro_sunday" type="number" step="any" onchange="copyValue('flat_metro_sunday', 'flat_metro_sunday_night')">
																						</div>
																						<div class="rTableCell text-center">Sunday </div>
																						<div class="rTableCell">
																							<input value="0" class="form-control form-control-md" name="flat_regional_sunday" id="flat_regional_sunday" type="number" step="any" onchange="copyValue('flat_regional_sunday', 'flat_regional_sunday_night')">
																						</div>
																					</div>
																					<div class="rTableRow" style="display:none;">
																						<div class="rTableCell">
																							<input value="0" class="form-control form-control-md" name="flat_metro_sunday_night" id="flat_metro_sunday_night" type="number" step="any">
																						</div>
																						<div class="rTableCell text-center">Sunday (Night 18:00 - 06:00)</div>
																						<div class="rTableCell">
																							<input value="0" class="form-control form-control-md" name="flat_regional_sunday_night" id="flat_regional_sunday_night" type="number" step="any">
																						</div>
																					</div>
																				<!-- <div class="rTableRow">
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="flat_metro_week_day" type="number" step="any">
																					</div>
																					<div class="rTableCell text-center">Mon-Fri</div>
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="flat_regional_week_day" type="number" step="any">
																					</div>
																				</div>
																				<div class="rTableRow">
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="flat_metro_weekend" type="number" step="any">
																					</div>
																					<div class="rTableCell text-center">Sat-Sun</div>
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="flat_regional_weekend" type="number" step="any">
																					</div>
																				</div> -->
																				<div class="rTableRow">
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="flat_metro_public_holiday" id="flat_metro_public_holiday" type="number" step="any" onchange="copyValue('flat_metro_public_holiday', 'flat_metro_public_holiday_night')">
																					</div>
																					<div class="rTableCell text-center">Public Holiday </div>
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="flat_regional_public_holiday" id="flat_regional_public_holiday" type="number" step="any" onchange="copyValue('flat_regional_public_holiday', 'flat_regional_public_holiday_night')">
																					</div>
																				</div>
																				<div class="rTableRow" style="display:none;">
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="flat_metro_public_holiday_night" id="flat_metro_public_holiday_night" type="number" step="any">
																					</div>
																					<div class="rTableCell text-center">Public Holiday (Night 18:00 - 06:00)</div>
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="flat_regional_public_holiday_night" id="flat_regional_public_holiday_night" type="number" step="any">
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
																<hr>
																<div class="row rates-section">
																	<div class="col-md-6">
																		<h4 class="text-center">EBA-Awards</h4></div>
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
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="eba_metro_weekday_day" type="number" step="any">
																					</div>
																					<div class="rTableCell text-center">Mon-Fri (Day 06:00-18:00)</div>
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="eba_regional_weekday_day" type="number" step="any">
																					</div>
																				</div>
																				<!-- <div class="rTableRow">
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="eba_metro_weekday_afternoon" type="number" step="any">
																					</div>
																					<div class="rTableCell text-center">Mon-Fri (afternoon 15:00-18:00)</div>
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="eba_regional_weekday_afternoon" type="number" step="any">
																					</div>
																				</div> -->
																				<div class="rTableRow">
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="eba_metro_weekday_night" type="number" step="any">
																					</div>
																					<div class="rTableCell text-center">Mon-Fri (Night 18:00-06:00)</div>
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="eba_regional_weekday_night" type="number" step="any">
																					</div>
																				</div>
																				<div class="rTableRow">
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="eba_metro_saturday_day" id="eba_metro_saturday_day" type="number" step="any" onchange="copyValue('eba_metro_saturday_day', 'eba_metro_saturday_night')">
																					</div>
																					<div class="rTableCell text-center">Saturday</div>
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="eba_regional_saturday_day" id="eba_regional_saturday_day" type="number" step="any" onchange="copyValue('eba_regional_saturday_day', 'eba_regional_saturday_night')">
																					</div>
																				</div>
																				<div class="rTableRow" style="display:none;">
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="eba_metro_saturday_night" id="eba_metro_saturday_night" type="number" step="any">
																					</div>
																					<div class="rTableCell text-center">Saturday (Night 06:00 till 18:00)</div>
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="eba_regional_saturday_night" id="eba_regional_saturday_night" type="number" step="any">
																					</div>
																				</div>
																				<div class="rTableRow">
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="eba_metro_sunday_day" id="eba_metro_sunday_day" type="number" step="any" onchange="copyValue('eba_metro_sunday_day', 'eba_metro_sunday_night')">
																					</div>
																					<div class="rTableCell text-center">Sunday</div>
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="eba_regional_sunday_day" id="eba_regional_sunday_day" type="number" step="any" onchange="copyValue('eba_regional_sunday_day', 'eba_regional_sunday_night')">
																					</div>
																				</div>
																				<div class="rTableRow" style="display:none;">
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="eba_metro_sunday_night" id="eba_metro_sunday_night" type="number" step="any">
																					</div>
																					<div class="rTableCell text-center">Sunday (Night 18:00 till 06:00)</div>
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="eba_regional_sunday_night" id="eba_regional_sunday_night" type="number" step="any">
																					</div>
																				</div>
																				<div class="rTableRow">
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="eba_metro_public_holiday" id="eba_metro_public_holiday" type="number" step="any" onchange="copyValue('eba_metro_public_holiday', 'eba_metro_public_holiday_night')">
																					</div>
																					<div class="rTableCell text-center">Public Holiday </div>
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="eba_regional_public_holiday" id="eba_regional_public_holiday" type="number" step="any" onchange="copyValue('eba_regional_public_holiday', 'eba_regional_public_holiday_night')">
																					</div>
																				</div>
																				<div class="rTableRow" style="display:none;">
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="eba_metro_public_holiday_night" id="eba_metro_public_holiday_night" type="number" step="any">
																					</div>
																					<div class="rTableCell text-center">Public Holiday (Night 18:00 till 06:E00)</div>
																					<div class="rTableCell">
																						<input value="0" class="form-control form-control-md" name="eba_regional_public_holiday_night" id="eba_regional_public_holiday_night" type="number" step="any">
																					</div>
																				</div>
																			</div>
																		</div>
																		</div>
																		<div class="col-12">
																			<!--begin::Input group-->
																<div class="fv-row mb-7">
																	<!--begin::Label-->
																	<label class="required fw-bold fs-6 mb-2">OT base rate</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="text" id="ot_base_rate" name="ot_base_rate" class="form-control form-control-solid mb-3 mb-lg-0 form-control-md" placeholder="TT Base Rate" value="22.84"/>
																	<!--end::Input-->
																</div>
																<!--end::Input group-->
																		</div>
																</div>
																<button type="button" class="btn btn-primary" data-kt-users-modal-action="" onclick="savePayrate()"> <span class="indicator-label" id="">Save</span>
																</button>
															</div>
															<!--end::Scroll-->
															<!--begin::Actions-->
															<div id="form_submit-button" class="text-center pt-15">
																<button type="button" class="btn btn-white me-3" data-bs-dismiss="modal" aria-label="Close">Discard</button>
																<button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit"> <span class="indicator-label" id="form_button">Submit</span> 
																<span class="indicator-progress">Please wait...
																<span class="spinner-border spinner-border-sm align-middle ms-2"></span>
																</span>
																</button>
															</div>
															<!--end::Actions-->
														</form>
														
										

														<!--end::Form-->
													</div>
													<!--end::Modal body-->
												</div>
												<!--end::Modal content-->
											</div>
											<!--end::Modal dialog-->
										</div>
										<!--end::Modal - Add task-->
		@stop
		<!--end::Scrolltop-->
		<!--end::Main-->
		<!--begin::Javascript-->
		<!--begin::Global Javascript Bundle(used by all pages)-->
		@section('pageFooter')
		<script src="{{ asset('')}}plugins/global/plugins.bundle.js"></script>
		<script src="{{ asset('')}}js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Page Vendors Javascript(used by this page)-->
		<script src="{{ asset('')}}plugins/custom/datatables/datatables.bundle.js"></script>
		<!--end::Page Vendors Javascript-->
		<!--begin::Page Custom Javascript(used by this page)-->
		<script src="{{ asset('')}}js/custom/apps/user-management/users/list/table.js"></script>
		<script src="{{ asset('')}}js/custom/apps/user-management/users/list/export-users.js"></script>
		<script src="{{ asset('')}}js/custom/apps/user-management/users/list/add.js"></script>
		<script src="{{ asset('')}}js/custom/widgets.js"></script>
		<script src="{{ asset('')}}js/custom/apps/chat/chat.js"></script>
		<script src="{{ asset('')}}js/custom/modals/create-app.js"></script>
		<script src="{{ asset('')}}js/custom/modals/upgrade-plan.js"></script>
		<!--end::Page Custom Javascript-->
		<!--end::Javascript-->


<script type="text/javascript" >
	//search custom
var $rows = $('#table tr');
$('#search').keyup(function() {
    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
    
    $rows.show().filter(function() {
        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
        return !~text.indexOf(val);
    }).hide();
});

	 function avatar_remove(){
	 					  document.getElementById('preview_img').style.backgroundImage=''; 
	 					  				  document.getElementById('file_image').value=''; 

	 }


function get_payrates(id){
	  $("#payrates_edit-form :input").prop("disabled", false);
        		    $('#form_submit-button').show();

					load_guard_payrates(id);
               	           $('#payrate-modal').modal('show');
						document.getElementById("form_button").innerHTML = "Update!";
					$('#payrates-form').attr('id','payrates_edit-form');
					$('#payrates_edit-form').attr('method', "POST");


				    $('#payrates_edit-form').attr('action', `{{url('update_payrates')}}/${id}`);
				  document.getElementById("form_head").innerHTML = "Edit Pay Rate";
               }
function openModal() {
           $('#kt_modal_add_user').modal('show');
       }
	   

function get_payrates_detail(id){

					load_guard_payrates(id);
            $('#payrate-modal').modal('show');
				  document.getElementById("form_head").innerHTML = " Payrate Details";
                // document.getElementsByClassName("form-control-md").disabled = true; 
                $("#payrates_edit-form :input").prop("disabled", true);
                $("#payrates-form :input").prop("disabled", true);
                $("#job_level").prop("disabled", false);
                $("#payrates_state").prop("disabled", false);
                $("#save-btn").css("display", 'none');



						// document.getElementById("form_submit-button").display = none;

            $('#form_submit-button').hide();


               }
function openModal() {
					

           $('#kt_modal_add_user').modal('show');
       }

function add_modal(){ 

			// document.getElementById("payrates-form").reset();
			// document.getElementById("payrates_edit-form").reset();
			//  $('#payrates-form :input').prop('disabled', false);  
			// 	$('#form_submit-button').show();
			// 			// document.getElementById("payrates_edit-form").reset();
			// 			         	           // $('#payrate-modal').modal('show');
			// 			document.getElementById("form_button").innerHTML = "Save";
			// 		$('#payrates_edit-form').attr('id','payrates-form');
			// 		$('#payrates-form').attr('method', "POST");


			// 	    $('payrates-form').attr('action', "/create_payrate/");
			// 	  document.getElementById("form_head").innerHTML = "Add Payrate";
			$('.form').trigger("reset");
           $('#payrate-modal_add').modal('show');


}

function delete_payrate(id){


	var id=id;

Swal.fire({
					text: "Are you sure you want to delete ?",
					icon: "warning",
					showCancelButton: !0,
					buttonsStyling: !1,
					confirmButtonText: "Yes!",
					cancelButtonText: "No, return",
					customClass: {
						confirmButton: "btn btn-primary",
						cancelButton: "btn btn-active-light"
					}
				}).then((function (t) {
					t.value ? (
						$.ajax({type: "POST",url: `{{url('delete_payrate')}}/${id}`, data:{_token:'<?php echo csrf_token();?>'},success: function(result){
							Swal.fire({
						text: "Deleted Succesfully.",
						icon: "success",
						buttonsStyling: !1,
						confirmButtonText: "Ok, got it!",
						customClass: {
							confirmButton: "btn btn-primary"
						}
					})
					
					$("#payrates-form").trigger('reset');
										window.location.href = "{{ url('/payrates')}}";
					

				}
						})

					) : "cancel" === t.dismiss && Swal.fire({
						text: "Your action has not been cancelled!.",
						icon: "error",
						buttonsStyling: !1,
						confirmButtonText: "Ok, got it!",
						customClass: {
							confirmButton: "btn btn-primary"
						}
					})
				}))

       }



   //     	$('#payrate-modal').click({
	 	// $("#payrates-form")[0].reset();

	 	// });





  $("#export_user_form").on('submit', function(e){
     // e.preventDefault();
     console.log(this.id)
     var data = $('#'+this.id).serialize();

     $.ajax({type: "POST",url: this.action,data : data ,success: function(result){
     	$('#kt_modal_export_users').modal('hide');

						     	Swal.fire({
						                        text: "Your Request Downloaded Successfully",
						                        icon: "success",
						                        buttonsStyling: !1,
						                        confirmButtonText: "Ok, got it!",
						                        customClass: {
						                            confirmButton: "btn btn-light"
						                        }
                    })
    }})

  });
 function savePayrate()
 {
 	var data = $('#payrates-form_add').serialize();
					     $.ajax({type: "POST",url: "{{url('create_payrate')}}",data : data,success: function(result){if(result.success){
											     	Swal.fire({
											                        text: "Payrate Created Successfully! ",
											                        icon: "success",
											                        buttonsStyling: !1,
											                        confirmButtonText: "OK",
											                        customClass: {
											                            confirmButton: "btn btn-light"
											                        }

					                    })

					     }else{Swal.fire({
					                        text: "something went wrong!!!! ",
					                        icon: "error",
					                        buttonsStyling: !1,
					                        confirmButtonText: "Try again!",
					                        customClass: {
					                            confirmButton: "btn btn-light"
					                        }
					                    })}}})
 }

 function savePayrate_edit()
 {
 	// var data = $('#payrates_edit-form').submit();
 	var id = $('#update_payrate_id').val();
var data = $('#payrates_edit-form').serialize();
	 var id=$('#payrate_id').val();
					     $.ajax({type: "POST",url: "{{url('update_payrates')}}"+'/'+id,data : data,success: function(result){if(result.success){
											     	Swal.fire({
											                        text: "Payrate update Successfully! ",
											                        icon: "success",
											                        buttonsStyling: !1,
											                        confirmButtonText: "OK",
											                        customClass: {
											                            confirmButton: "btn btn-light"
											                        }

					                    })

					     }else{Swal.fire({
					                        text: "something went wrong!!!! ",
					                        icon: "error",
					                        buttonsStyling: !1,
					                        confirmButtonText: "Try again!",
					                        customClass: {
					                            confirmButton: "btn btn-light"
					                        }
					                    })}}})
 }

  $("#payrates-form_add").on('submit', function(e){
					     e.preventDefault();
					     console.log(this.id)
					     var data = $('#'+this.id).serialize();
					     $.ajax({type: "POST",url: this.action,data : data,success: function(result){if(result.success){
											     	Swal.fire({
											                        text: "Payrate Created Successfully! ",
											                        icon: "success",
											                        buttonsStyling: !1,
											                        confirmButtonText: "OK",
											                        customClass: {
											                            confirmButton: "btn btn-light"
											                        }

					                    })
										window.location.href = "{{ url('/payrates')}}";

					     }else{Swal.fire({
					                        text: "something went wrong!!!! ",
					                        icon: "error",
					                        buttonsStyling: !1,
					                        confirmButtonText: "Try again!",
					                        customClass: {
					                            confirmButton: "btn btn-light"
					                        }
					                    })}}})
					  });


    $("#payrates-form").on('submit', function(e){
					     e.preventDefault();
					     console.log(this.id)
					     var data = $('#'+this.id).serialize();
					     $.ajax({type: "POST",url: this.action,data : data,success: function(result){if(result.success){
											     	Swal.fire({
											                        text: "Payrate Created Successfully! ",
											                        icon: "success",
											                        buttonsStyling: !1,
											                        confirmButtonText: "OK",
											                        customClass: {
											                            confirmButton: "btn btn-light"
											                        }

					                    })
										window.location.href = "{{ url('/payrates')}}";

					     }else{Swal.fire({
					                        text: "something went wrong!!!! ",
					                        icon: "error",
					                        buttonsStyling: !1,
					                        confirmButtonText: "Try again!",
					                        customClass: {
					                            confirmButton: "btn btn-light"
					                        }
					                    })}}})
					  });




    $("#payrates_edit-form").on('submit', function(e){
					     e.preventDefault();
					     console.log(this.id)
					     var data = $('#'+this.id).serialize();
					     $.ajax({type: "POST",url: this.action,data : data,success: function(result){if(result.success){
											     	Swal.fire({
											                        text: "Payrate Updated Successfully! ",
											                        icon: "success",
											                        buttonsStyling: !1,
											                        confirmButtonText: "OK",
											                        customClass: {
											                            confirmButton: "btn btn-light"
											                        }
					                    })
										window.location.href = "{{ url('/payrates')}}";

					     }else{Swal.fire({
					                        text: "something went wrong!!!! ",
					                        icon: "error",
					                        buttonsStyling: !1,
					                        confirmButtonText: "Try again!",
					                        customClass: {
					                            confirmButton: "btn btn-light"
					                        }
					                    })}}})
					  });

    				// function load_guard_payrates(id){
					// 			$.ajax({
					// 	        type: "POST",
					// 	        url: "{{url('/get_payrates/')}}" + '/' + id,
					// 	        data : {id:id , _token : '{{ csrf_token()}}'},
					
    				function load_guard_payrates(id, level_id, state_id = null, position = null){
    							$('#update_payrate_id').val(id)
    							var level = $('#'+level_id).val();
    							var state = $('#'+state_id).val();
    							var position = $('#'+position).val();
    							var name = $('#title-name').val();
								$.ajax({
						        type: "POST",
						        url: "{{url('/get_payrates/')}}" + '/' + id+'?rate_type={{$rate_type}}',
						        data : {id:id , _token : '{{ csrf_token()}}', level:level, state:state, name:name, position:position},
						        success: function(result){
						        if (result.success) {
						        	$('#update_payrate_id').val(result.payrates.id)
						        	$('#position').val(result.payrates.position)
						        	$('#customer_id').val(result.payrates.customer_id)

						        	$('#effective_date').val(result.payrates.effective_date)
						        	$('input[name="flat_metro_week_day"]').val(result.payrates.flat_metro_flat_metro_week_day)
						        	$('input[name="flat_metro_weekend"]').val(result.payrates.flat_metro_weekend)
						        	$('input[name="flat_metro_public_holiday"]').val(result.payrates.flat_metro_public_holiday)
						        	$('input[name="flat_regional_week_day"]').val(result.payrates.flat_regional_week_day)
						        	$('input[name="flat_regional_weekend"]').val(result.payrates.flat_regional_weekend)
						        	$('input[name="flat_regional_public_holiday"]').val(result.payrates.flat_regional_public_holiday);
						        	$('input[name="eba_metro_weekday_day"]').val(result.payrates.eba_metro_weekday_day);
						        	$('input[name="eba_metro_weekday_afternoon"]').val(result.payrates.eba_metro_weekday_afternoon);
						        	$('input[name="eba_metro_weekday_night"]').val(result.payrates.eba_metro_weekday_night);
						        	$('input[name="eba_metro_public_holiday"]').val(result.payrates.eba_metro_public_holiday);
						        	$('input[name="eba_regional_weekday_day"]').val(result.payrates.eba_regional_weekday_day);
						        	$('input[name="eba_regional_weekday_afternoon"]').val(result.payrates.eba_regional_weekday_afternoon);
						        	$('input[name="eba_regional_weekday_night"]').val(result.payrates.eba_regional_weekday_night);
						        	$('input[name="eba_regional_weekend"]').val(result.payrates.eba_regional_weekend);
						        	$('input[name="eba_regional_public_holiday"]').val(result.payrates.eba_regional_public_holiday);
						        	$('input[name="title"]').val(result.payrates.title);
						        	$('input[name="eba_metro_weekend"]').val(result.payrates.eba_metro_weekend);

						        	$('input[name="eba_regional_weekend_sun"]').val(result.payrates.eba_regional_weekend_sun);
						        	$('input[name="eba_metro_weekend_sun"]').val(result.payrates.eba_metro_weekend_sun);
									$('#job_level').val(result.payrates.level);
									$('#payrates_state').val(result.payrates.state);
									$('#payrate_id').val(result.payrates.id);
									$('input[name="flat_metro_week_day_day"]').val(result.payrates.flat_metro_week_day_day);
						        	$('input[name="flat_regional_week_day_day"]').val(result.payrates.flat_regional_week_day_day);
						        	$('input[name="flat_metro_week_day_night"]').val(result.payrates.flat_metro_week_day_night);
						        	$('input[name="flat_regional_week_day_night"]').val(result.payrates.flat_regional_week_day_night);
						        	$('input[name="flat_metro_friday"]').val(result.payrates.flat_metro_friday);
						        	$('input[name="flat_regional_friday"]').val(result.payrates.flat_regional_friday);
						        	$('input[name="flat_metro_saturday"]').val(result.payrates.flat_metro_saturday);
						        	$('input[name="flat_regional_saturday"]').val(result.payrates.flat_regional_saturday);
						        	$('input[name="flat_metro_sunday"]').val(result.payrates.flat_metro_sunday);
						        	$('input[name="flat_regional_sunday"]').val(result.payrates.flat_regional_sunday);

						        	$('input[name="flat_regional_sunday_night"]').val(result.payrates.flat_regional_sunday_night);
						        	$('input[name="flat_metro_sunday_night"]').val(result.payrates.flat_metro_sunday_night);
						        	$('input[name="flat_metro_saturday_night"]').val(result.payrates.flat_metro_saturday_night);
						        	$('input[name="flat_regional_saturday_night"]').val(result.payrates.flat_regional_saturday_night);
						        	$('input[name="flat_metro_public_holiday_night"]').val(result.payrates.flat_metro_public_holiday_night);
						        	$('input[name="flat_regional_public_holiday_night"]').val(result.payrates.flat_regional_public_holiday_night);

						        	$('input[name="eba_metro_saturday_day"]').val(result.payrates.eba_metro_saturday_day);
						        	$('input[name="eba_regional_saturday_day"]').val(result.payrates.eba_regional_saturday_day);
						        	$('input[name="eba_metro_saturday_night"]').val(result.payrates.eba_metro_saturday_night);
						        	$('input[name="eba_regional_saturday_night"]').val(result.payrates.eba_regional_saturday_night);
						        	$('input[name="eba_metro_sunday_day"]').val(result.payrates.eba_metro_sunday_day);
						        	$('input[name="eba_regional_sunday_day"]').val(result.payrates.eba_regional_sunday_day);
						        	$('input[name="eba_metro_sunday_night"]').val(result.payrates.eba_metro_sunday_night);
						        	$('input[name="eba_regional_sunday_night"]').val(result.payrates.eba_regional_sunday_night);
						        	$('input[name="eba_metro_public_holiday_night"]').val(result.payrates.eba_metro_public_holiday_night);
						        	$('input[name="eba_regional_public_holiday_night"]').val(result.payrates.eba_regional_public_holiday_night);

						        	$('input[name="ot_base_rate"]').val(result.payrates.ot_base_rate);

						        	



									
						        }else{
						        	$('input[name="flat_metro_week_day"]').val(0)
						        	$('input[name="flat_metro_weekend"]').val(0)
						        	$('input[name="flat_metro_public_holiday"]').val(0)
						        	$('input[name="flat_regional_week_day"]').val(0)
						        	$('input[name="flat_regional_weekend"]').val(0)
						        	$('input[name="flat_regional_public_holiday"]').val(0);
						        	$('input[name="eba_metro_weekday_day"]').val(0);
						        	$('input[name="eba_metro_weekday_afternoon"]').val(0);
						        	$('input[name="eba_metro_weekday_night"]').val(0);
						        	$('input[name="eba_metro_weekend"]').val(0);
						        	$('input[name="eba_metro_public_holiday"]').val(0);
						        	$('input[name="eba_regional_weekday_day"]').val(0);
						        	$('input[name="eba_regional_weekday_afternoon"]').val(0);
						        	$('input[name="eba_regional_weekday_night"]').val(0);
						        	$('input[name="eba_regional_weekend"]').val(0);
						        	$('input[name="eba_regional_public_holiday"]').val(0);
						        	$('input[name="eba_regional_weekend_sun"]').val(0);
						        	$('input[name="eba_metro_weekend_sun"]').val(0);
						        	$('input[name="flat_metro_week_day_day"]').val(0);
						        	$('input[name="flat_regional_week_day_day"]').val(0);
						        	$('input[name="flat_metro_week_day_night"]').val(0);
						        	$('input[name="flat_regional_week_day_night"]').val(0);
						        	$('input[name="flat_metro_friday"]').val(0);
						        	$('input[name="flat_regional_friday"]').val(0);
						        	$('input[name="flat_metro_saturday"]').val(0);
						        	$('input[name="flat_regional_saturday"]').val(0);
						        	$('input[name="flat_metro_sunday"]').val(0);
						        	$('input[name="flat_regional_sunday"]').val(0);
						        	$('input[name="flat_regional_sunday_night"]').val(0);
						        	$('input[name="flat_metro_sunday_night"]').val(0);
						        	$('input[name="flat_metro_saturday_night"]').val(0);
						        	$('input[name="flat_regional_saturday_night"]').val(0);
						        	$('input[name="flat_metro_public_holiday_night"]').val(0);
						        	$('input[name="flat_regional_public_holiday_night"]').val(0);
						        	$('input[name="eba_metro_saturday_day"]').val(0);
						        	$('input[name="eba_regional_saturday_day"]').val(0);
						        	$('input[name="eba_metro_saturday_night"]').val(0);
						        	$('input[name="eba_regional_saturday_night"]').val(0);
						        	$('input[name="eba_metro_sunday_day"]').val(0);
						        	$('input[name="eba_regional_sunday_day"]').val(0);
						        	$('input[name="eba_metro_sunday_night"]').val(0);
						        	$('input[name="eba_regional_sunday_night"]').val(0);
						        	$('input[name="eba_metro_public_holiday_night"]').val(0);
						        	$('input[name="eba_regional_public_holiday_night"]').val(0);
						        }

						        }
						        });
}
function changeStatus(id, e) {
            if ($(e).is(':checked')) {
                check = "checked";
                $(e).prop("checked", true)

                let timerInterval
                Swal.fire({
                    title: 'Status Update !',
                    //   html: 'I will close in <b></b> milliseconds.',
                    timer: 1000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                        const b = Swal.getHtmlContainer().querySelector('b')
                        timerInterval = setInterval(() => {
                            b.textContent = Swal.getTimerLeft()
                        }, 100)
                    },
                    willClose: () => {
                        clearInterval(timerInterval)
                    }
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {}
                })


            } else {
                check = "unchecked";
                $(e).prop("checked", false)
                console.log('uncehck admin_approval_status');
                let timerInterval
                Swal.fire({
                    title: 'Status Update !',
                    timer: 1000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                        const b = Swal.getHtmlContainer().querySelector('b')
                        timerInterval = setInterval(() => {
                            b.textContent = Swal.getTimerLeft()
                        }, 100)
                    },
                    willClose: () => {
                        clearInterval(timerInterval)
                    }
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {}
                })


            }
            $.ajax({
                type: "POST",
                url: "{{ url('changeStatusPayRate') }}",
                data: {
                    id: id,
                    check: check,
                    _token: '<?php echo csrf_token(); ?>'
                },
                success: function(result) {

                    window.location.href = "{{ url('/payrates') }}?type={{$rate_type}}";


                }

            });
        }
        function copyValue(input1, input2)
        {
        	$('#'+input2).val($('#'+input1).val());
        }
     </script>



		@stop
