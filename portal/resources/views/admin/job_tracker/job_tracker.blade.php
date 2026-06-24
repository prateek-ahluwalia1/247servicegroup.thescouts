	@extends('layout.app')
	@extends('layout.sidebar')
	@extends('layout.footer')

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
	<!--end::Global Stylesheets Bundle-->
	<link href="{{asset('')}}plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" type="text/css" href="{{asset('')}}js/datetimepicker/build/jquery.datetimepicker.min.css" />

	<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"> -->
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">


	<style type="text/css">
/* .sorting_asc{
	background: none !important;
	} */
/* .sorting_disabled{
	display: none;
	} */
/* .sorting_asc{
	display: none;
	} */
	tbody, td, tfoot, th, thead, tr {
		border-top: 1px solid #F1416D;
	}

	table.dataTable thead .sorting{
		background: none !important;
	}
	.text-dark{
		margin-top: 2px;
	}

	td.details-control {
		background: url('{{asset('')}}media/icons/duotone/Navigation/Angle-right.svg') no-repeat center center;
		cursor: pointer;
	}
	tr.shown td.details-control {
		background: url('{{asset('')}}media/icons/duotone/Navigation/Angle-right.svg') no-repeat center center;
	}
	/*expand*/
	tr.hide-table-padding td {
		padding: 0;
	}

	.expand-button {
		position: relative;
	}

	.accordion-toggle .expand-button:after
	{
		position: absolute;
		left:.75rem;
		top: 50%;
		transform: translate(0, -50%);
		content: '-';
	}
	.accordion-toggle.collapsed .expand-button:after
	{
		content: '+';
	}

</style>


@stop
<!--end::Head-->
<!--begin::Body-->
@section('content')

@section('content')

<!--begin::Form-->
<!--begin::Wrapper-->
<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
	<!--begin::Header-->
	<div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
		<!--begin::Container-->
		<div class="container d-flex align-items-center justify-content-between" id="kt_header_container">
			<!--begin::Page title-->
			<div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-2 pb-2 pb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
				<!--begin::Heading-->
				<h1 class="text-dark fw-bolder my-0 fs-2">Job Tracker</h1>
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
	<div class=" content d-flex flex-column flex-column-fluid" id="kt_content">
		<!--begin::Container-->
		<div class="container" id="kt_content_container">
			<!--begin::Form-->
			<form id="search-form" class="form" action="{{url('job_tracker/timesheet_search')}}" method="POST" enctype="multipart/form-data">
				@csrf
				<!--begin::Card-->
				<div class="card mb-7">
					<!--begin::Card body-->
					<div class="card-body">
						<!--begin::Compact form-->
						<div class="d-flex align-items-center">
							<!--begin::Input group-->
							<div class="position-relative w-md-400px me-md-2">
								<!--begin::Svg Icon | path: icons/duotone/General/Search.svg-->
								<span class="svg-icon svg-icon-3 svg-icon-gray-500 position-absolute top-50 translate-middle ms-6">
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<rect x="0" y="0" width="24" height="24" />
											<path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
											<path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero" />
										</g>
									</svg>
								</span>
								<!--end::Svg Icon-->
								<input type="search" class="form-control form-control-solid ps-10" name="search" id="search" placeholder="Search" />
								<!-- <input type="search" class="form-control form-control-solid ps-10" name="search" id="search" placeholder="Search" /> -->
							</div>
							<!--end::Input group-->
							<!--begin:Action-->
							<div class="d-flex align-items-center">
								<button type="submit" class="btn btn-primary me-5">Search</button>
								<a id="kt_horizontal_search_advanced_link" class="btn btn-link" >Advanced Search</a>
							</div>
							<!--end:Action-->
						</div>
						<!--end::Compact form-->
						<!--begin::Advance form-->
						<div style="display: none" id="kt_advanced_search_form">
							<!--begin::Separator-->
							<div class="separator separator-dashed mt-9 mb-6"></div>
							<!--end::Separator-->
							<!--begin::Row-->
							<div class="row ">
								<!--begin::Col-->
								<div class="mb-0">
									<label class=" fs-6 form-label fw-bolder text-dark">From-To</label>
									<input name ="from_to" class="form-control form-control-solid" placeholder="Pick date rage" id="kt_daterangepicker_1"/>
								</div>
								<!--end::Col-->
								<!--begin::Col-->
								<div class="">
									<!--begin::Row-->
									<div class="row ">
										<!--begin::Col-->
										
										<div id="div_states" class="col-lg-6 ">
											<br>

											<label class="fs-6 form-label fw-bolder text-dark">Select State</label>
											<div class="fv-row mb-10 div_states">
												<select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1" id="State" name="State[]" class="_ac-customer-change">
													<!-- <option value="">Select Customer</option> -->
													<option value="Victoria" >Victoria</option>
													<option value="New South Wales">NSW</option>
													<option value="Queensland">Queensland</option>
													<option value="Tasmania">Tasmania</option>
													<option value="Western Australia">Western Australia</option>
													<option value="South Australia">South Australia</option>
													<option value="ACT">ACT</option>
												</select>
											</div>
										</div>
										<div class="col-lg-6 ">
											<br>

											<label class="fs-6 form-label fw-bolder text-dark">Select Customer</label>
											<div class="fv-row mb-10">
												<select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1" id="customer_name" name="customer_name[]">
													
													@foreach($customers as $result)
													<option value="{{$result->id}}">{{$result->name}}</option>
													@endforeach
												</select>
											</div>
										</div>

										
										
										<div id="div_guards" class="col-lg-6 ">
											<label class="fs-6 form-label fw-bolder text-dark">Select {{config('custom.guard')}}</label>
											<div class="fv-row mb-10">
												<select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1" id="guard_name" name="guard_name[]">
													
													@foreach($guards as $result)
													<option value="{{$result->id}}">{{$result->name}}</option>

													@endforeach
												</select>
											</div>
										</div>
										@if(session()->get('userType') == 'contractor')
										<div class="col-lg-6" id="guard_type_div">
											<label class="fs-6 form-label fw-bolder text-dark">Select {{config('custom.guard')}} Type</label>
											<select disabled multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1" name="guard_type[]" id="guard_type">
												<option value="Contract" selected>Contract </option>
											</select>
										</div>
										@else
										<div class="col-lg-6" id="guard_type_div">
											<label class="fs-6 form-label fw-bolder text-dark">Select {{config('custom.guard')}} Type</label>
											<select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1" name="guard_type[]" id="guard_type">
												<option value="contract">Direct </option>
											</select>
										</div>

										@endif
											
											<div id="div_active" class="col-lg-6 ">
												<label  class="fs-6 form-label fw-bolder text-dark">Select Active Sites</label>
												<div  class="fv-row mb-10">
													<select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1"  id="active_sites" name="address[]" data-placeholder="Select an option">
													</select>
												</div>
												
											</div>
											
											<div id="div_inactive" class="col-lg-6 ">
												<label  class="fs-6 form-label fw-bolder text-dark">Select Inactive Sites</label>
												<div  class="fv-row mb-10"><select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1" id="inactive_sites" name="address[]" data-control="select2" data-placeholder="Select an option">
												</select>
											</div>	
										</div>

										<!--begin::Col-->
										<div class="col-lg-4">
											<label class="fs-6 form-label fw-bolder text-dark">Jobs</label>
											<!--begin::Radio group-->
											
											<div class="nav-group nav-group-fluid">
												<!--begin::Option-->
												<label>
													<input type="radio" class="btn-check" name="status" value="confirmed" checked="checked">
													<span class="btn btn-sm btn-color-muted btn-active btn-active-primary fw-bolder px-4">Past</span>
												</label>
												<!--end::Option-->
												<!--begin::Option-->
												<label>
													<input type="radio" class="btn-check" name="status" value="inprogress">
													<span class="btn btn-sm btn-color-muted btn-active btn-active-primary fw-bolder px-4">Ongoing</span>
												</label>
												<!--end::Option-->
												<!--begin::Option-->
												<label>
													<input type="radio" class="btn-check" name="status" value="pending">
													<span class="btn btn-sm btn-color-muted btn-active btn-active-primary fw-bolder px-4">Upcoming</span>
												</label>
												<label>
													<input type="radio" class="btn-check" name="status" value="missed">
													<span class="btn btn-sm btn-color-muted btn-active btn-active-primary fw-bolder px-4">Missed</span>
												</label>
												<!--end::Option-->
											</div>
											<!--end::Radio group-->
										</div>

										<!--end::Col-->
										
									</div>
									<!--end::Row-->
								</div>
								<!--end::Col-->
							</div>
							<!--end::Row-->
							<!--begin::Row-->
							<div class="row g-8">
								<!--begin::Col-->
								<div class="col-xxl-7">
									
								</div>
								<!--end::Col-->
								<!--begin::Col-->
								<div class="col-xxl-5">
									<!--begin::Row-->
									<div class="row g-8">
										<!--begin::Col-->
										
										<!--end::Col-->
										<!--begin::Col-->
										
										<!--end::Col-->
									</div>
									<!--end::Row-->
								</div>
								<!--end::Col-->
							</div>
							<!--end::Row-->
						</div>
						<!--end::Advance form-->
					</div>
					<!--end::Card body-->
				</div>
				<!--end::Card-->
			</form>
			<!--end::Form-->
			<!--begin::Toolbar-->
			<div class="content d-flex flex-column flex-column-fluid">
				<div class="">
					<div class="card" >
						<div class="card-body">
							<div class="row">
								<div class="col-sm-6 " style="float:left;">

									<ul id="jobs-tab" style="margin-left: 19px; ;" class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6 nav-stretch  nav-fill nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder flex-nowrap">
										<li class="nav-item">
											<a class="nav-link active text-active-primary me-6" data-bs-toggle="tab" id="past_jobs" type="button" onclick="past_jobs()" ><span class="text-center ">Past </span></a>
										</li>
										<li class="nav-item">
											<a class="nav-link text-active-primary me-6" data-bs-toggle="tab" type="button" id="ongoing" onclick="ongoing_jobs()">Ongoing </a>
										</li>
										<li class="nav-item">
											<a class="nav-link text-active-primary me-6" data-bs-toggle="tab" type="button" id="upcoming" onclick="upcoming_jobs()">Upcoming </a>
										</li>
										<li class="nav-item">
											<a class="nav-link text-active-primary me-6" data-bs-toggle="tab" type="button" id="missed" onclick="missed_jobs()">Missed </a>
										</li>
										
									</ul>
								</div>
								<div class="col-sm-6" style="float:right;text-align: end;margin-top:4px;">
									<button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_export_users">
										<!--begin::Svg Icon | path: icons/duotone/Files/Export.svg-->
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
										<!--end::Svg Icon-->Export</button>
										
									</div>
								</div>

								
								{{-- cellpadding="0" cellspacing="0" border="0" class="display cell-border" style="width:100%" --}}
								<div class="row">
									<div class="container-fluid">
										<div id="other-table" style="overflow-x: auto; max-width: 100%;">
											<table id="example" class="table table-responsive" >
												<thead style="background-color: white;" >
													<tr>
														<th >State Name</th>
														<!-- <th style="display: none">Published Location Name</th> -->
														<th >Site Name</th>

														<th style="display:none;">{{config('custom.guard')}} Payroll Id</th>
														<th>{{config('custom.guard')}} Name</th>
														<th style="display: none">{{config('custom.guard')}} Phone</th>

														<th id="st1" style="display:none;">{{config('custom.guard')}} Type</th>
														<th id="cust">Customer</th>
														<th>Schedule Start Date</th>
														<th>Schedule Start Time</th>
														<th>Schedule Finish Time</th>
														<th style="display: none">---</th>
														<th id="ast">Authorized Start Time</th>
														<th style="display: none">--</th>
														<th id="aft">Authorized Finish Time</th>
														<th id="tt2" style="display: none;">Break Payable</th>
														<th id="tt2" style="display: none;">Break Deduction</th>
														<th id="tt2" style="display: none;">Travel Time</th>
														<th id="tt2" style="display: none;">Actual Hours</th>
														<th id="ath">Authorized Total Hours</th>
														<th class="noExport" id="table_status">Status</th>
														<th class="noExport" id="status_change_by" >Status Change by</th>
														<th class="noExport" id="bp">Break Payable</th>
														<th class="noExport" id="bc">Break Chargeable</th>
														<th style="display: none">Operator Notes</th>
													</tr>
												</thead>
												<tbody id="example_body">
													
													
												</tbody>
												
											</table>
										</div>
									</div>
								</div>
								<div id="missed-table" style="display: none;">
									<table  id="missed-example" cellspacing="-2" class=" table-responsive table-fluid  table-hover table-striped  ">
										<thead style="background-color: white" >
											<tr >

												<th >State Name</th>
												<th style="display: none">Published Location Name</th>
												<th >Site Name</th>

												<th style="display:none;">{{config('custom.guard')}} Payroll Id</th>
												<th>{{config('custom.guard')}} Name</th>
												<!-- <th style="display: none">{{config('custom.guard')}} Phone</th> -->

												<!-- <th id="st">{{config('custom.guard')}} Type</th> -->
												<!-- <th id="cust">Customer</th> -->
												<th>Schedule Start Date</th>
												<th>Schedule Start Time</th>
												<th>Schedule Finish Time</th>
												<!-- <th style="display: none">---</th> -->
												<!-- <th id="ast">Authorized Start Time</th> -->
												<!-- <th style="display: none">--</th> -->
												<!-- <th id="aft">Authorized Finish Time</th> -->
												<!-- <th id="tt">Travel Time</th> -->
												<!-- <th id="ath">Authorized Total Hours</th> -->
												<!-- <th class="noExport" id="table_status">Status</th> -->
												<!-- <th class="noExport" id="status_change_by" style="width:12px !important">Status Change by</th> -->
												<!-- <th class="noExport" id="bp">Break Payable</th> -->
												<!-- <th class="noExport" id="bc">Break Chargeable</th> -->
												<!-- <th style="display: none">Operator Notes</th> -->
											</tr>
										</thead>
										<tbody id="example_body_missed">
											
											
										</tbody>
										
									</table>
								</div>
							</div>
						</div>	
					</div>	
				</div>	
				
				<!--end::Tab Content-->
				<!--end::Container-->
				
				<div class="modal fade" id="kt_modal_export_users" tabindex="-1" aria-hidden="true">
					<!--begin::Modal dialog-->
					<div class="modal-dialog modal-dialog-centered mw-650px">
						<!--begin::Modal content-->
						<div class="modal-content">
							<!--begin::Modal header-->
							<div class="modal-header">
								<!--begin::Modal title-->
								<h2 class="fw-bolder">Export Users</h2>
								<!--end::Modal title-->
								<!--begin::Close-->
								
								<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
									
									<span class="svg-icon svg-icon-2x">X</span>
								</div>
								<!--end::Close-->
							</div>
							<!--end::Modal header-->
							<!--begin::Modal body-->
							<div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
								<!--begin::Form-->
								<form id="export_user_form" class="form" action="" method="POST" enctype="multipart/form-data">
									@csrf
									
									<!--begin::Input group-->
									
									<!--end::Input group-->
									<!--begin::Input group-->
									<div class="fv-row mb-10">
										<!--begin::Label-->
										<label class="required fs-6 fw-bold form-label mb-2">Select Export Format:</label>
										<!--end::Label-->
										<!--begin::Input-->
										<select name="format" data-control="select2" data-placeholder="Select a format" data-hide-search="true" class="form-select form-select-solid fw-bolder" id="format">
											<option></option>
											<!-- <option value="excel">Excel</option> -->
											<option value="pdf">PDF</option>
											<option value="excel">Excel</option>
											<option value="copy">Copy</option>
											<option value="csv">CSV</option>
										</select>
										<!--end::Input-->
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
								</div>
								<!--end::Modal body-->
							</div>
							<!--end::Modal content-->
						</div>
						<!--end::Modal dialog-->
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
					
					<script src="{{asset('')}}js/custom/widgets.js"></script>
					<script src="{{asset('')}}js/custom/apps/chat/chat.js"></script>
					<script src="{{asset('')}}js/custom/modals/create-app.js"></script>
					<script src="{{asset('')}}js/custom/modals/upgrade-plan.js"></script>
					<script src="{{asset('')}}plugins/global/plugins.bundle.js"></script>
					<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
					<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
					<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
					<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
					<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
					<script type="text/javascript" src="{{asset('')}}js/datetimepicker/build/jquery.datetimepicker.full.js"></script>
					<script type="text/javascript" src="{{asset('')}}js/datetimepicker/build/jquery.datetimepicker.min.js"></script>
					<script type="text/javascript" src="{{asset('')}}js/datetimepicker/jquery.datetimepicker.js"></script>
					<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
					<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
					<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
					<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
					<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
					<style>
						div.dt-buttons {
							position: relative;
							float: right !important;
						}
					</style>
					<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
					<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
					<script type="text/javascript">



						var scope='';

						var search_to=null;
						var search_from=null;
						var search_guard=[];
						var search_customer=[];
						var guard_arr=[]
			// delete guard_arr

			var customer_arr=[]
			var bolean_search="false";
			var default1 = "Default";
			var multiple1 = "Multiple";

			var total_shifts=0;
			var total_hours=0;

			function active(e,roster_id,guard_ID){
				$(e).flatpickr({enableTime:!0,dateFormat:"Y-m-d H:i",onClose: function () {
					var date=$(e).val();
					console.log(roster_id,guard_ID);
					update_signin(date,roster_id,guard_ID);
				}});



			}
			function active_out(e,roster_id,guard_ID){
				$(e).flatpickr({enableTime:!0,dateFormat:"Y-m-d H:i",onClose: function () {
					var date=$(e).val();
					console.log(roster_id,guard_ID);
					update_signout(date,roster_id,guard_ID);
				}});
			}
			function update_signin(datetime,roster_id,guard_ID){
				$.ajax({type: "POST",url:"{{url('job_tracker/update_signin')}}",data:{datetime:datetime,guard_ID:guard_ID,roster_id:roster_id,_token:'<?php echo csrf_token();?>'} ,success: function(result){
					if(result.success){
						Swal.fire({
							text: result.message,
							icon: "success",
							buttonsStyling: !1,
							confirmButtonText: "Ok, got it!",
							customClass: {
								confirmButton: "btn btn-light"
							}
						})
										// window.location.href = "{{ url('/job_tracker')}}";	

									}
									else{
										Swal.fire({
											text: result.message,
											icon: "error",
											buttonsStyling: !1,
											confirmButtonText: "Ok, got it!",
											customClass: {
												confirmButton: "btn btn-light"
											}
										})
									}	
								}
							});
			}
			function update_signout(datetime,roster_id,guard_ID){
				$.ajax({type: "POST",url:"{{url('job_tracker/update_signout')}}",data:{guard_ID:guard_ID,datetime:datetime,roster_id:roster_id,_token:'<?php echo csrf_token();?>'} ,success: function(result){
					if(result.success){
						Swal.fire({
							text: result.message,
							icon: "success",
							buttonsStyling: !1,
							confirmButtonText: "Ok, got it!",
							customClass: {
								confirmButton: "btn btn-light"
							}
						})
						// window.location.href = "{{ url('/job_tracker')}}";	

					}
					else{
						Swal.fire({
							text: result.message,
							icon: "error",
							buttonsStyling: !1,
							confirmButtonText: "Ok, got it!",
							customClass: {
								confirmButton: "btn btn-light"
							}
						})
					}	
				}
			});
			}
			

			$(document).ready(function() {
				$("#kt_daterangepicker_1").daterangepicker();
				MultiselectDropdown(window.MultiselectDropdownOptions);
				
				var log1='';

				function toDataUrl(url, callback) {
					var xhr = new XMLHttpRequest();
					xhr.onload = function() {
						var reader = new FileReader();
						reader.onloadend = function() {
							callback(reader.result);
							scope=reader.result;
							log(scope);
						}
						reader.readAsDataURL(xhr.response);
					};
					xhr.open('GET', url);
					xhr.responseType = 'blob';
					xhr.send();
				}
				var myBase64='';
// var url='{{asset('')}}media/logo.png';

var url='{{config('custom.logo')}}';
toDataUrl(url, function(myBase64) {
});
function log(data){
	scope = data;
}


$('#example').DataTable({
	"ordering": false,
	"pageLength": 50,
	dom: 'Blrtip',
	buttons: [
	'copyHtml5',
	'excelHtml5',
	'csvHtml5',
	'pdfHtml5'
	]
});
$("#example").removeClass("dataTable");

@if(request()->get('job_status'))
var link ="{{request()->get('job_status')}}";
console.log(link);
$(`#past_jobs`).removeClass('active');

$(`#${link}`).click();

$(`#${link}`).addClass('active');
@else
			// setInterval(function(){ getJobsData ('completed', 'example'); }, 3000);
			setTimeout(function(){ getJobsData ('completed', 'example');  }, 3000);
			@endif
		});

	</script>


	<script >
		
		

		function upcoming_jobs(){
			$('#missed-table').css('display', 'none')
			$('#other-table').css('display', '')
		// $('#example').DataTable().destroy();
		getJobsData ('pending', 'example');

	}


	function ongoing_jobs(){
		$('#missed-table').css('display', 'none')
		$('#other-table').css('display', '')
			// $('#example').DataTable().destroy();
			getJobsData ('inprogress', 'example');

			
		}


		function missed_jobs(){

			$('#missed-example').DataTable().destroy();
			$('#missed-table').css('display', '')
			$('#other-table').css('display', 'none')
			getJobsData ('missed', 'missed-example');
			
		}
		function past_jobs(){
			$('#missed-table').css('display', 'none')
			$('#other-table').css('display', '')
		// $('#example').DataTable().destroy();
		getJobsData ('completed', 'example');
		
	}
	
	function getBase64Image(img) {
		var canvas = document.createElement("canvas");
		canvas.width = img.width;
		canvas.height = img.height;
		var ctx = canvas.getContext("2d");
		ctx.drawImage(img, 0, 0);
		var dataURL = canvas.toDataURL("image/png");
		return dataURL.replace(/^data:image\/(png|jpg);base64,/, "");
	}




	function getDateTime() {
		var now     = new Date(); 
		var year    = now.getFullYear();
		var month   = now.getMonth()+1; 
		var day     = now.getDate();
		var hour    = now.getHours();
		var minute  = now.getMinutes();
		var second  = now.getSeconds(); 
		if(month.toString().length == 1) {
			month = '0'+month;
		}
		if(day.toString().length == 1) {
			day = '0'+day;
		}   
		if(hour.toString().length == 1) {
			hour = '0'+hour;
		}
		if(minute.toString().length == 1) {
			minute = '0'+minute;
		}
		if(second.toString().length == 1) {
			second = '0'+second;
		}   
		var dateTime = year+'/'+month+'/'+day+' '+hour+':'+minute;   
		return dateTime;
	}
	function return_month(M){
		var months = {Jan:01, Feb:02, Mar:03, Apr:04, May:05, Jun:06,July:07,Aug:08,Sep:09,Oct:10,Nov:11,Dec:12};
		if(M=="Jan"){
			return months.Jan;
		}
		if(M=="Feb"){
			return months.Feb;
		}
		if(M=="Mar"){
			return months.Mar;
		}
		if(M=="Apr"){
			return months.Apr;
		}
		if(M=="May"){
			return months.May;
		}
		if(M=="July"){
			return months.July;
		}
		if(M=="Aug"){
			return months.Aug;
		}
		if(M=="Sep"){
			return months.Sep;
		}
		if(M=="Oct"){
			return months.Oct;
		}
		if(M=="Nov"){
			return months.Nov;
		}
		if(M=="Dec"){
			return months.Dec;
		}
	}
	function getJobsData(status, id)
	{

		call_spinner();
		$('#'+id).DataTable().destroy();

		$.ajax({type: "GET",url:' {{url('job_tracker/timesheet_record/')}}',data:{status:status} ,success: function(result){
			var parameter_status=status;
			if(parameter_status=="completed" ||parameter_status=="confirmed"){
				$('#table_status').show();
				$('#status_change_by').show();
				$("#status_change_by").css("width", "12px");
			}else{
				$('#table_status').hide();
				$('#status_change_by').hide();
			}
			if (parameter_status == "missed") {
				$('#aft').hide();
				$('#ath').hide();
				$('#bp').hide();
				$('#tt').hide();
				$('#bc').hide();
				$('#st').hide();
				$('#ast').hide();
				$('#cust').hide();
			}else{
				$('#aft').show();
				$('#ath').show();
				$('#bp').show();
				$('#tt').show();
				$('#bc').show();
				$('#st').show();
				$('#ast').show();
				$('#cust').show();
			}
			$('#example').DataTable().destroy();
			
			var list = '';
									//  var counter=1;
									total_shifts=0;
									total_hours=0;
									$.each(result.results, function(id, data){
										total_hours=total_hours+parseFloat(data.hours);
										total_shifts++;
										var signin_time=data.signin_time;
										var signout_time=data.signout_time;
										
										var signin_time_ex='N/A';
										var signout_time_ex='N/A';
										var newtime=getDateTime();
										var roster_id=data.roster_id;
										var newtime_out=getDateTime();
										if(signin_time!=null){
											if(signin_time.indexOf("GMT") > -1){
												
												signin_time_ex = signin_time.split(" ");
												
												var M=return_month(signin_time_ex[1]);
												newtime=`${signin_time_ex[3]}-${M}-${signin_time_ex[2]} ${signin_time_ex[4]}`;
												signin_time_ex = signin_time_ex[4];
											}
											else if(signin_time.indexOf("M") > -1 || signin_time.indexOf("T") > -1 ||signin_time.indexOf("W") > -1 ||signin_time.indexOf("F") > -1 ||signin_time.indexOf("S") > -1 ){
												signin_time_ex = signin_time.split(" ");
												signin_time_ex = signin_time_ex[4];
											}
											else{
												newtime=signin_time;
												var newtime_ex=newtime.split(" ");
												signin_time_ex=newtime_ex[1];
											}
										}
										else{
											newtime=getDateTime();

										}
										if(signout_time!=null){
											
											if(signout_time.indexOf("GMT") > -1){
												signout_time_ex = signout_time.split(" ");
												var M=return_month(signout_time_ex[1]);
												newtime_out=`${signout_time_ex[3]}-${M}-${signout_time_ex[2]} ${signout_time_ex[4]}`;
												signout_time_ex = signout_time_ex[4];
											}
											else if(signout_time.indexOf("M") > -1 || signout_time.indexOf("T") > -1 ||signout_time.indexOf("W") > -1 ||signout_time.indexOf("F") > -1 ||signout_time.indexOf("S") > -1 ){
												signout_time_ex = signout_time.split(" ");
												signout_time_ex = signout_time_ex[4];
											}
											else{
												newtime_out=signout_time;
												var newtime_out_ex=newtime_out.split(" ");
												signout_time_ex=newtime_out_ex[1];
											}
										}
										else{
											newtime_out=getDateTime();
										}

										var checked = '';
										if (data.status == 'Approved') {
											checked = 'checked';
										}
										if (data.admin_name == null || data.admin_name == 'null') {
											data.admin_name = 'N/A';
										}
										var status='';
										if(data.guard_name!='' && data.guard_name!=null){

										}else
										{
											data.guard_name="N/A";	
										}
										if(data.guard_phone!='' && data.guard_phone!=null){

										}else
										{
											data.guard_phone="N/A";	
										}
										if(data.operators_notes!='' && data.operators_notes!=null){

										}else
										{
											data.operators_notes="N/A";	
										}
										
										if(data.guard_type!='' && data.guard_type!=null){

										}else
										{
											data.guard_type="N/A";	
										}
										if(data.job_status == 'confirmed'){
											status = 'Approved';
										}else{
											status = 'Unapproved';
										}
										var training_shift = '';
										if (data.training == 1) {
											training_shift = '- Training Shift';
										}
										if (parameter_status == "missed") {
											list += '<tr  >';
                         // list += '<td  class="details-control" ></td>';
                         // list += '<td></td>';
                         list += '<td>' + data.state + '</td>';
                         // list += '<td style="display:none;">' + data.address + ' </td>';
                         list += '<td>'+data.site_name+'('+data.site_description+') '+training_shift+'</td>';

                         list += '<td style="display:none;">'+data.guard_payroll_id+'</td>';
                         list += '<td >' + data.guard_name + '</td>';
                         list += '<td>' + data.temp_date + '</td>';
                         list += '<td>' + data.temp_start + '</td>';
                         list += '<td>' + data.temp_end + '</td>';
                         list += '</tr  >';

                     }else{
                     	
                     	list += '<tr  >';
						            // list += '<td  class="details-control" ></td>';
									// list += '<td></td>';
									list += '<td>'+data.state+'</td>';
						            // list += '<td style="display:none;">'+data.address+' </td>';
						            list += '<td>'+data.site_name+'('+data.site_description+') '+training_shift+'</td>';
						            list += '<td style="display:none;">'+data.guard_payroll_id+'</td>';
						            list += '<td style="display:;">'+data.guard_name+'</td>';
						            list += '<td style="display:none;">'+data.guard_phone+'</td>';
						            list += '<td style="display:none;">'+data.guard_type+'</td>';
						            list += '<td>'+data.customer_name+'</td>';
						            list += '<td>'+data.temp_date+'</td>';
						            list += '<td>'+data.temp_start+'</td>';
						            list += '<td>'+data.temp_end+'</td>';
						            list += `<td  style="display:none" id="in_id_${roster_id}" ><input  id="in_id_${roster_id}_" type="text"  onclick="active(this,${data.roster_id},${data.guard_ID})" class="datetimepicker1" value="${newtime}"/></td>`;
						            list += `<td>${signin_time_ex}</td>`;
            						// list += `<td onclick='$("#in_id_${roster_id}").show();$("#in_id_${roster_id}_").click();$(this).hide()'>${signin_time_ex}</td>`;
            						list +=`<td style="display:none" id="out_id_${roster_id}" ><input id="out_id_${roster_id}_"  type="text"  onclick="active_out(this,${data.roster_id},${data.guard_ID})" class="datetimepicker1" value="${newtime_out}"/></td>`;
									// list += `<td onclick='$("#out_id_${roster_id}").show();$("#out_id_${roster_id}_").click();$(this).hide()'>${signout_time_ex}</td>`;
									list += `<td>${signout_time_ex}</td>`;
									list += `<td style="display:none;">0</td>`;
									list += `<td style="display:none;">0</td>`;

									list += '<td style="display:none;">'+data.travel_time+'</td>';

            						// list += '<td  contenteditable="true">'+signout_time_ex+'</td>';

            						list += '<td style="display:none;">0</td>';
            						list += '<td>'+data.hours+'</td>';
						            //   list += '<td>'+status+'</td>';
						            if(parameter_status=="completed" || parameter_status=="confirmed" ){
						            	list +=`<td><div class="form-check form-check-solid form-switch fv-row">`;

						            	if((data.status_change_by != '' && data.status_change_by !=null && data.status_change_by !='null') || (data.check_in_status == true && data.check_out_status == true)){
						            		if (result.signout_diff > 30 || result.signin_diff > 15) {
						            			list +=`<input class="form-check-input w-45px h-30px" type="checkbox" id="tracker_approval_status" name="tracker_approval_status" onchange="tracker_approval_status(${data.roster_id},this)" >`;
						            		}else{
						            			if (data.status_change_by != null && data.status_change_by != '') {

						            			}else{
						            				data.admin_name = 'Auto';
						            			}
						            			list +=`<input class="form-check-input w-45px h-30px" type="checkbox" id="tracker_approval_status" name="tracker_approval_status" onchange="tracker_approval_status(${data.roster_id},this)" checked="checked">`;
						            		}
						            	}else{

						            		list +=`<input class="form-check-input w-45px h-30px" type="checkbox" id="tracker_approval_status" name="tracker_approval_status" onchange="tracker_approval_status(${data.roster_id},this)" >`; 
						            	}
						            	

						            	list +=`</div></td>`;
													// list += '<td><label class="switch"><input type="checkbox" '+checked+' class="_ac-change-status-roster"  data-roster-id="'+data.roster_id+'"><span class="slider round"></span></label></td>';


													list += '<td>'+data.admin_name+'</td>';
												}else{
													list += '<td style="display:none" ></td>';
													list += '<td style="display:none" ></td>';
													
												}
												list += '<td style="text-transform: capitalize;">'+data.payable+'</td>';
												list += '<td style="text-transform: capitalize;">'+data.chargeable+'</td>';
												list += '<td style="text-transform: capitalize;display:none">'+data.operators_notes+'</td>';


												list += '</tr>';
												
											}

											
										});
	if (status == 'missed') {
		$('#example_body_missed').html(list);
	}else{
		$('#example_body').html(list);
	}
	close_spinner();
	$('#'+id).DataTable({
		"ordering": false,
		"pageLength": 50,
								// "pageLength": 25,
								dom: 'Blrtip',
								buttons: [
								'copyHtml5',
								'excelHtml5',
								'csvHtml5',
								{
									extend: 'pdfHtml5',
									title: "Job Tracker",
									orientation: 'landscape',
									text: 'Job Tracker',
									className: 'fa fa-print',

									customize: function ( win ) {
										$(win.document.body).find('h1').css('text-align', 'center');
										$(win.document.messageTop).find('h1').css('text-align', 'center');


										$(win.document.body).css( 'font-size', '9px' );
										$(win.document.messageTop).css( 'font-size', '9px' );
										$(win.document.body).find( 'table' )
										.addClass( 'compact' )
										.css( 'font-size', 'inherit' );
									},
						// 											pageSize: 'LEGAL',
						pageSize: 'LEGAL',
						exportOptions: {
							search: 'applied',
							order: 'applied',
							stripNewlines: false,
							columns: "thead th:not(.noExport)"
						},
						customize: function (doc) {
							var rdoc = doc;
							var rcout = doc.content[doc.content.length - 1].table.body.length - 1;
							doc.content.splice(0, 1);
							var now = new Date();
							
							var jsDate = now.getDate() + '/' + (now.getMonth() + 1) + '/' + now.getFullYear() + '  and Time:' + now.getHours() + ':' + now.getMinutes() + ':' + now.getSeconds();
							doc.pageMargins = [50, 70, 30, 30];
							doc.defaultStyle.fontSize = 8;
							doc.styles.tableHeader.fontSize = 9;
											// doc.content[doc.content.length - 1].table.headerRows = 4;
											doc.content[doc.content.length - 1].table.body[0].splice(0, 0, { text: "SNo.", style: "tableHeader" });
											var iPlus;
											for (var i = 0; i < rcout; i++) {
												iPlus = (i + 1);
												var obj = doc.content[doc.content.length - 1].table.body[i + 1];
												doc.content[doc.content.length - 1].table.body[(i + 1)][0] = { text: obj[0].text, style: [obj[0].style], bold: true };
												doc.content[doc.content.length - 1].table.body[(i + 1)][3] = {
													text: obj[3].text,
													style: [obj[3].style],
													alignment: 'center',
													bold: obj[3].text > 60 ? true : false,
													fillColor: obj[3].text > 60 ? null : null
												};
												var cols = [];
												cols[0] = {text: 'Left part', alignment: 'left', margin:[20] };
												doc.content[doc.content.length - 1].table.body[iPlus].splice(0, 0, { text: iPlus, style: obj[0].style });
											}

											doc['header'] = (function (page, pages) {
												return {
													columns: [
													
													[	
													
													
													{
														height:45,width:50,margin: [0,15,-50,100],alignment:'left',image:`${scope}`},
														
														]
														,					[			
														{
															alignment: 'center',
															text: `{{config('custom.title')}}`,
															fontSize: 14,
															bold: true,
															margin: [0,15,0,0]

															
															
														},	{
															alignment: 'center',
															text: `Address: {{config('custom.address')}}`,
															fontSize: 6,
															margin: [0, 0, 0, 0]	
															

														},
									// if(bolean_search=="true"){
										{
											alignment: 'center',
											text: `Guard  : ${guard_arr.length==1 ? guard_arr[0] : multiple1}`,
											fontSize: 7,
											margin: [0, 0, 15, 0]

											

										}	,
										
										{
											alignment: 'center',
											text: `Customer  : ${customer_arr.length==1 ? customer_arr[0] : multiple1}`,
											fontSize: 7,
											margin: [0, 0, 15, 0]
										}	,
										{
											alignment: 'center',
											text: `From  : ${search_from== null? default1 : search_from } - To :  ${search_to==null ? default1 : search_to }`,
											fontSize: 7,
											margin: [0, 0, 15, 0]
										}	,
										],

										[						
										{
											alignment: 'center',
											text: `Email : {{config('custom.email')}}`,
											fontSize: 9,
											margin: [0, 15, 0, 0]		
										}
										,
										{
											alignment: 'center',
											text: `Phone: {{config('custom.phone')}}`,
											fontSize: 9,
											margin:  [0, 0, 15, 0]	
											

										},
										{
											alignment: 'center',
											text: `Total Shifts: ${total_shifts}   Total Hours: ${total_hours}` ,
											fontSize: 7,
											margin:  [0, 15, 15, 0]	
										}
										
										]
										]

										
									}
								});

											doc['footer'] = (function (page, pages) {
												return {
													columns: [
													{
														alignment: 'left',
														text: ['Printed at: ', { text: jsDate.toString() }]
													},
													
													],
													margin: 10
												}
											});


										}
									}
									]
								});

	
	
	$('#example_filter').hide();
	$('.dt-buttons').hide();
	$("#example").removeClass("dataTable");

	
	


	
}})

}

$("#search-form").on('submit', function(e){
	e.preventDefault();
	call_spinner();
						     // console.log(this.id)
						     var data = $('#'+this.id).serialize();
						     $('#search').val($('#kt_daterangepicker_1').val());
						     bolean_search="true";
						     var search_date1=$('#kt_daterangepicker_1').val();
						     var  search_date=search_date1.split("-");
						     var from = new Date(search_date[0]);
						     var to = new Date(search_date[1]);
						     search_from=moment(from).format('DD-MM-YY');
						     search_to=moment(to).format('DD-MM-YY');
						     
						     
						     search_customer=$('#customer_name  option:selected').toArray().map(item => item.text).join();
								//  search_guard=$('#guard_name  option:selected ').text();	
								search_guard=$('#guard_name  option:selected ').toArray().map(item => item.text).join();
								if(search_guard!=''){
									guard_arr=search_guard.split(",");

								}
								if(search_customer!=''){

									customer_arr=search_customer.split(",");
									if(customer_arr.length==1){

										var temp=customer_arr[0];
										temp=customer_arr[0].split(" ");
										var temp2 =temp[0]+ " " +temp[1];
										customer_arr[0]=temp2;
									}
								}


								console.log("testing",customer_arr);

								$.ajax({type: "POST",url: this.action,data : data ,success: function(result){
									$('#jobs-tab').hide();
									$('#example').DataTable().clear().destroy();
									var parameter_status=result.parameter_status;
									if(parameter_status=="completed" || parameter_status=="confirmed"){
										$('#table_status').show();
										$('#status_change_by').show();
										$("#status_change_by").css("width", "12px");
									}else{
										$('#table_status').hide();
										$('#status_change_by').hide();
									}
									if (parameter_status == "missed") {
										$('#aft').hide();
										$('#ath').hide();
										$('#bp').hide();
										$('#tt').hide();
										$('#bc').hide();
										$('#st').hide();
										$('#ast').hide();
										$('#cust').hide();
									}else{
										$('#aft').show();
										$('#ath').show();
										$('#bp').show();
										$('#tt').show();
										$('#bc').show();
										$('#st').show();
										$('#ast').show();
										$('#cust').show();
									}
									$('#example').DataTable().destroy();
									var list = '';
									//  var counter=1;
									total_shifts=0;
									total_hours=0;
									$.each(result.results, function(id, data){
										total_hours=total_hours+parseFloat(data.hours);
										total_shifts++;
										var signin_time=data.signin_time;
										var signout_time=data.signout_time;
										
										var signin_time_ex='N/A';
										var signout_time_ex='N/A';
										var newtime=getDateTime();
										var roster_id=data.roster_id;
										var newtime_out=getDateTime();
										if(signin_time!=null){
											if(signin_time.indexOf("GMT") > -1){
												
												signin_time_ex = signin_time.split(" ");
												
												var M=return_month(signin_time_ex[1]);
												newtime=`${signin_time_ex[3]}-${M}-${signin_time_ex[2]} ${signin_time_ex[4]}`;
												signin_time_ex = signin_time_ex[4];
											}
											else if(signin_time.indexOf("M") > -1 || signin_time.indexOf("T") > -1 ||signin_time.indexOf("W") > -1 ||signin_time.indexOf("F") > -1 ||signin_time.indexOf("S") > -1 ){
												signin_time_ex = signin_time.split(" ");
												signin_time_ex = signin_time_ex[4];
											}
											else{
												newtime=signin_time;
												var newtime_ex=newtime.split(" ");
												signin_time_ex=newtime_ex[1];
											}
										}
										else{
											newtime=getDateTime();

										}
										if(signout_time!=null){
											
											if(signout_time.indexOf("GMT") > -1){
												signout_time_ex = signout_time.split(" ");
												var M=return_month(signout_time_ex[1]);
												newtime_out=`${signout_time_ex[3]}-${M}-${signout_time_ex[2]} ${signout_time_ex[4]}`;
												signout_time_ex = signout_time_ex[4];
											}
											else if(signout_time.indexOf("M") > -1 || signout_time.indexOf("T") > -1 ||signout_time.indexOf("W") > -1 ||signout_time.indexOf("F") > -1 ||signout_time.indexOf("S") > -1 ){
												signout_time_ex = signout_time.split(" ");
												signout_time_ex = signout_time_ex[4];
											}
											else{
												newtime_out=signout_time;
												var newtime_out_ex=newtime_out.split(" ");
												signout_time_ex=newtime_out_ex[1];
											}
										}
										else{
											newtime_out=getDateTime();
										}

										var checked = '';
										if (data.status == 'Approved') {
											checked = 'checked';
										}
										if (data.admin_name == null || data.admin_name == 'null') {
											data.admin_name = 'N/A';
										}
										var status='';
										if(data.guard_name!='' && data.guard_name!=null){

										}else
										{
											data.guard_name="N/A";	
										}
										if(data.guard_phone!='' && data.guard_phone!=null){

										}else
										{
											data.guard_phone="N/A";	
										}
										
										if(data.operators_notes!='' && data.operators_notes!=null){

										}else
										{
											data.operators_notes="N/A";	
										}

										if(data.guard_type!='' && data.guard_type!=null){

										}else
										{
											data.guard_type="N/A";	
										}
										if(data.job_status == 'confirmed' || data.job_status == 'completed'){
											status = 'Approved';
										}else{
											status = 'Unapproved';
										}
										var training_shift = '';
										if (data.training == 1) {
											training_shift = '- Training Shift';
										}
										if (parameter_status == "missed") {
											list += '<tr  >';
                         // list += '<td  class="details-control" ></td>';
                         // list += '<td></td>';
                         list += '<td>' + data.state + '</td>';
                         // list += '<td>' + data.address + ' </td>';
                         list += '<td>'+data.site_name+'('+data.site_description+') '+training_shift+'</td>';

                         list += '<td style="display:none;">'+data.guard_payroll_id+'</td>';

                         list += '<td >' + data.guard_name + '</td>';
                         list += '<td>' + data.temp_date + '</td>';
                         list += '<td>' + data.temp_start + '</td>';
                         list += '<td>' + data.temp_end + '</td>';
                         list += '</tr>';

                     }else{

                     	
                     	list += '<tr  >';
						            // list += '<td  class="details-control" ></td>';
									// list += '<td></td>';
									list += '<td>'+data.state+'</td>';
						            // list += '<td style="display:none;">'+data.address+' </td>';
						            list += '<td>'+data.site_name+'('+data.site_description+') '+training_shift+'</td>';
						            list += '<td style="display:none;">'+data.guard_payroll_id+'</td>';
						            list += '<td style="display:;">'+data.guard_name+'</td>';
						            list += '<td style="display:none;">'+data.guard_phone+'</td>';
						            list += '<td style="display:none;">'+data.guard_type+'</td>';
						            list += '<td>'+data.customer_name+'</td>';
						            list += '<td>'+data.temp_date+'</td>';
						            list += '<td>'+data.temp_start+'</td>';
						            list += '<td>'+data.temp_end+'</td>';
						            list += `<td  style="display:none" id="in_id_${roster_id}" ><input  id="in_id_${roster_id}_" type="text"  onclick="active(this,${data.roster_id},${data.guard_ID})" class="datetimepicker1" value="${newtime}"/></td>`;
						            list += `<td>${signin_time_ex}</td>`;
            						// list += `<td onclick='$("#in_id_${roster_id}").show();$("#in_id_${roster_id}_").click();$(this).hide()'>${signin_time_ex}</td>`;

            						list +=`<td style="display:none" id="out_id_${roster_id}" ><input id="out_id_${roster_id}_"  type="text"  onclick="active_out(this,${data.roster_id},${data.guard_ID})" class="datetimepicker1" value="${newtime_out}"/></td>`;
            						list += `<td>${signout_time_ex}</td>`;
									// list += `<td onclick='$("#out_id_${roster_id}").show();$("#out_id_${roster_id}_").click();$(this).hide()'>${signout_time_ex}</td>`;
									list += '<td style="display:none;text-transform: capitalize;">'+data.payable+'</td>';
									list += '<td style="display:none">'+data.payable_and_chargeable_time+'</td>';
									list += '<td style="display:none">'+data.travel_time+'</td>';

            						// list += '<td  contenteditable="true">'+signout_time_ex+'</td>';
            						list += '<td style="display:none">'+data.total_hours+'</td>';
            						list += '<td>'+data.hours+'</td>';
						            //   list += '<td>'+status+'</td>';
						            if(parameter_status=="completed" || parameter_status=="confirmed" || data.status_change_by != ''){
						            	list +=`<td><div class="form-check form-check-solid form-switch fv-row">`;
						            	if(data.job_status == 'completed' || (data.status_change_by != null && data.status_change_by != '')){
						            		if ((data.status_change_by == '' || data.status_change_by == null) && (data.signout_diff > 30 || data.signin_diff > 15)) {
						            			list +=`<input class="form-check-input w-45px h-30px" type="checkbox" id="tracker_approval_status" name="tracker_approval_status" onchange="tracker_approval_status(${data.roster_id},this)" >`;
						            		}else{
						            			if (data.status_change_by != null && data.status_change_by != '') {

						            			}else{
						            				data.admin_name = 'Auto';
						            			}
						            			list +=`<input class="form-check-input w-45px h-30px" type="checkbox" id="tracker_approval_status" name="tracker_approval_status" onchange="tracker_approval_status(${data.roster_id},this)" checked="checked">`;
						            		}
						            	}else{
						            		list +=`<input class="form-check-input w-45px h-30px" type="checkbox" id="tracker_approval_status" name="tracker_approval_status" onchange="tracker_approval_status(${data.roster_id},this)" >`;
						            	}

						            	list +=`</div></td>`;
													// list += '<td><label class="switch"><input type="checkbox" '+checked+' class="_ac-change-status-roster"  data-roster-id="'+data.roster_id+'"><span class="slider round"></span></label></td>';


													list += '<td>'+data.admin_name+'</td>';
												}else{
													list += '<td style="display:none" ></td>';
													list += '<td style="display:none" ></td>';
													
												}
												list += '<td style="text-transform: capitalize;">'+data.payable+'</td>';
												list += '<td style="text-transform: capitalize;">'+data.chargeable+'</td>';
												list += '<td style="text-transform: capitalize;display:none">'+data.operators_notes+'</td>';


												list += '</tr>';
												
											}

											
										}); 

	close_spinner();
	$('#example_body').html(list);
	
	$('#example').DataTable({
		"ordering": false,
								// "pageLength": 25,
								dom: 'Blrtip',
								buttons: [
								'copyHtml5',
								'excelHtml5',
								'csvHtml5',
								{
									extend: 'pdfHtml5',
									title: "Job Tracker",
									orientation: 'landscape',
									text: 'Job Tracker',
									className: 'fa fa-print',

									customize: function ( win ) {
										$(win.document.body).find('h1').css('text-align', 'center');
										$(win.document.messageTop).find('h1').css('text-align', 'center');


										$(win.document.body).css( 'font-size', '9px' );
										$(win.document.messageTop).css( 'font-size', '9px' );
										$(win.document.body).find( 'table' )
										.addClass( 'compact' )
										.css( 'font-size', 'inherit' );
									},
						// 											pageSize: 'LEGAL',
						pageSize: 'LEGAL',
						exportOptions: {
							search: 'applied',
							order: 'applied',
							stripNewlines: false,
							columns: "thead th:not(.noExport)"

						},
						customize: function (doc) {
							var rdoc = doc;
							var rcout = doc.content[doc.content.length - 1].table.body.length - 1;
							doc.content.splice(0, 1);
							var now = new Date();
							
							var jsDate = now.getDate() + '/' + (now.getMonth() + 1) + '/' + now.getFullYear() + '  and Time:' + now.getHours() + ':' + now.getMinutes() + ':' + now.getSeconds();
							doc.pageMargins = [50, 70, 30, 30];
							doc.defaultStyle.fontSize = 8;
							doc.styles.tableHeader.fontSize = 9;
											// doc.content[doc.content.length - 1].table.headerRows = 4;
											doc.content[doc.content.length - 1].table.body[0].splice(0, 0, { text: "SNo.", style: "tableHeader" });
											var iPlus;
											for (var i = 0; i < rcout; i++) {
												iPlus = (i + 1);
												var obj = doc.content[doc.content.length - 1].table.body[i + 1];
												doc.content[doc.content.length - 1].table.body[(i + 1)][0] = { text: obj[0].text, style: [obj[0].style], bold: true };
												doc.content[doc.content.length - 1].table.body[(i + 1)][3] = {
													text: obj[3].text,
													style: [obj[3].style],
													alignment: 'center',
													bold: obj[3].text > 60 ? true : false,
													fillColor: obj[3].text > 60 ? 'red' : null
												};
												var cols = [];
												cols[0] = {text: 'Left part', alignment: 'left', margin:[20] };
												doc.content[doc.content.length - 1].table.body[iPlus].splice(0, 0, { text: iPlus, style: obj[0].style });
											}

											doc['header'] = (function (page, pages) {
												return {
													columns: [
													
													[	
													
													
													{
														height:45,width:50,margin: [0,15,-50,100],alignment:'left',image:`${scope}`},
														
														]
														,					[			
														{
															alignment: 'center',
															text: `{{config('custom.title')}}`,
															fontSize: 14,
															bold: true,
															margin: [0,15,0,0]

															
															
														},	{
															alignment: 'center',
															text: `Address: {{config('custom.address')}}`,
															fontSize: 6,
															margin: [0, 0, 0, 0]	
															

														},
									// if(bolean_search=="true"){
										{
											alignment: 'center',
											text: `Guard  : ${guard_arr.length==1 ? guard_arr[0] : multiple1}`,
											fontSize: 7,
											margin: [0, 0, 15, 0]

											

										}	,
										
										{
											alignment: 'center',
											text: `Customer  : ${customer_arr.length==1 ? customer_arr[0] : multiple1}`,
											fontSize: 7,
											margin: [0, 0, 15, 0]
										}	,
										{
											alignment: 'center',
											text: `From  : ${search_from== null? default1 : search_from } - To :  ${search_to==null ? default1 : search_to }`,
											fontSize: 7,
											margin: [0, 0, 15, 0]
										}	,
										],

										[						
										{
											alignment: 'center',
											text: `Email : {{config('custom.email')}}`,
											fontSize: 9,
											margin: [0, 15, 0, 0]		
										}
										,
										{
											alignment: 'center',
											text: `Phone: {{config('custom.phone')}}`,
											fontSize: 9,
											margin:  [0, 0, 15, 0]	
											

										},
										{
											alignment: 'center',
											text: `Total Shifts: ${total_shifts}   Total Hours: ${total_hours}` ,
											fontSize: 7,
											margin:  [0, 15, 15, 0]	
										}
										
										]
										]

									}
								});

											
											doc['footer'] = (function (page, pages) {
												return {
													columns: [
													{
														alignment: 'left',
														text: ['Printed at: ', { text: jsDate.toString() }]
													},
													
													],
													margin: 10
												}
											});


										}
									}
									]
								});


									    			// getsearchdata();
									    			$('#example_filter').hide();
									    			$('.dt-buttons').hide();
									    			$("#example").removeClass("dataTable");

									    			
									    		}})

});
	$("#export_user_form").on('submit', function(e){

		var format =$('#format').val();

		if(format == "pdf")
		{

			$(".buttons-pdf ").click()
		}
		if(format == "excel")
		{
			console.log('excel');

			$(".buttons-excel").click()
		}
		if(format == "csv")
		{
			console.log('csv');

			$(".buttons-csv").click()
		}
		if(format == "copy")
		{
			console.log('copy');

			$(".buttons-copy").click()
		}
		e.preventDefault();

		

	});




// $(document).on('click', '._ac-change-status-roster', function(e) {
//                var confirm = confirmBox('Do you confirm change roster status?');
//                var status = $(this).is(":checked");

//                if(!confirm) {
//                    return;
//                }
//                if (status) {
//                 status = 'completed';
//                }else{
//                 status = 'pending';
//                }
//                uiBlocker();
//                postRequest("", {roster_id: $(this).attr('data-roster-id'), status : status}, function (response) {
//                    response = JSON.parse(response);
//                    if (response.success) {
//                        successAlert(response.message);
//                        // getGuards();
//                        return;
//                    }
//                    errorAlert(response.message);
//                });
//            });




		//
		function tracker_approval_status(id,e){
			if($(e).is(':checked')){
				check="checked";
				$(e).prop("checked", true)
				
				console.log('check admin_approval_status');
				call_spinner();


			}else{
				check="unchecked";
				$(e).prop("checked", false)
				console.log('uncehck admin_approval_status');
				let timerInterval
				call_spinner();


			}
			$.ajax({type: "POST",url: "{{url('tracker_approval_status')}}", data:{id:id,check:check,_token:'<?php echo csrf_token();?>'},success: function(result){
				close_spinner();
				console.log('done admin_approval_status');
				// window.location.href = "{{ url('/job_tracker')}}";	
			}

		});

		}

		$('#customer_name').change(function () {
			call_spinner();
			$('#div_inactive').html('');
			$('#div_active').html('');
		     // $('.multiselect-dropdown').remove();
		     $('#guard_type_div>.multiselect-dropdown').remove();
		     $('.div_states>.multiselect-dropdown').remove();
		     $('#div_states>.multiselect-dropdown').remove();
		     var customer_id = $('#customer_name').val();
		     $.ajax({
		     	type: "POST",
		     	url: "{{url('job_tracker/get_customers_jobs_list')}}",
		     	data: {
		     		customer_id: customer_id,
		     		_token: "<?php echo csrf_token();?>"
		     	},
		     	success: function (result) {
		     		var active_site = `<label  class="fs-6 form-label fw-bolder text-dark">Select Active Sites</label>
		     		<div  class="fv-row mb-10">
		     		<select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1"  id="active_sites" name="address[]" data-placeholder="Select an option">`;
		     		var inactive_site = `<label  class="fs-6 form-label fw-bolder text-dark">Select Inactive Sites</label>
		     		<div  class="fv-row mb-10"><select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1" id="inactive_sites" name="address[]" data-control="select2" data-placeholder="Select an option">`;
		     		$.each(result.active_jobs, function (id, data) {
		     			active_site += `<option value="${data.job_id}">${data.site_name}(${data.site_description})</option>`;
		     		})
		     		active_site += '</select></div>';

		     		$.each(result.inactive_jobs, function (id, data) {
		     			inactive_site += `<option value="${data[0].job_id}">${data[0].site_name}(${data[0].site_description})</option>`;
		     		})
		     		inactive_site += '</select></div>';

		     		$('#guard_name').attr('multiple', false);
		             // $('#guard_type').attr('multiple', false);
		             // $('#State').attr('multiple', false);
		             $('#customer_name').attr('multiple', false);
		             $('#div_active').html(active_site);
		             $('#div_inactive').html(inactive_site);
		             // get_tracker_data();				
		             MultiselectDropdown();
		             $('#guard_name').attr('multiple', true);
		             // $('#State').attr('multiple', true);
		             // $('#guard_type').attr('multiple', true);
		             $('#customer_name').attr('multiple', true);
		             $('#guard_name').val('');
		             // $('#State').val('');
		             $('#customer_name').val(customer_id);
		             close_spinner();


		         }
		     })
		 });

		function get_tracker_data() {
			$('#div_states').html('');
			$('#div_guards').html('');
			$.ajax({
				type: "POST",
				url: "{{url('get_tracker_data')}}",
				data: {
					_token: "<?php echo csrf_token();?>"
				},
				success: function (result) {
					var state_html = `<br>
					<label class="fs-6 form-label fw-bolder text-dark">Select State</label>
					<div class="fv-row mb-10">
					<select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1" id="State" name="State[]" class="_ac-customer-change">`;
					var guard_html = `<label class="fs-6 form-label fw-bolder text-dark">Select {{config('custom.guard')}}</label><div class="fv-row mb-10"><select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1" id="guard_name" name="guard_name[]">	<option value="Victoria" >Victoria</option>
					<option value="New South Wales">NSW</option>
					<option value="Queensland">Queensland</option>
					<option value="Tasmania">Tasmania</option>
					<option value="Western Australia">Western Australia</option>
					<option value="South Australia">South Australia</option>
					<option value="ACT">ACT</option>
					</select>
					</div>`;
					$.each(result.guards, function (id, data) {
						guard_html += `<option value="${data.id}">${data.name}</option>`;
					})
					guard_html += `</select></div>`;
					$('#div_states').html(state_html);
					$('#div_guards').html(guard_html);
				}
			});


		}
	</script>



	<!--end::Page Custom Javascript-->
	<!--end::Javascript-->

	@stop