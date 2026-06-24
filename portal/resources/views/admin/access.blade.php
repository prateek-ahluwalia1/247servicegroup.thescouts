
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
@stop
<!--end::Head-->
<!--begin::Body-->
@section('content')

<!--end::Logo-->
<!--begin::Wrapper-->
<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
	<!--begin::Header-->
	<div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
		<!--begin::Container-->
		<div class="container d-flex align-items-center justify-content-between" id="kt_header_container">
			<!--begin::Page title-->
			<div>
				<div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-2 pb-2 pb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
					<!--begin::Heading-->
					<h1 class="text-dark fw-bolder my-0 fs-2">Roles List</h1>
					<!--end::Heading-->
				</div>
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
				<a href="{{url('')}}">
            @if(config('custom.business_type')=="demo")
            <img alt="Logo" crossorigin="anonymous" id="bussiness_logo" src="{{asset('')}}media/logo.png" class="h-60px">
            @else
            <img alt="Logo" crossorigin="anonymous" id="bussiness_logo" src="{{config('custom.logo')}}" class="h-60px">
            @endif

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
			<div class="row">
				<div  style="text-align:end;float:right;margin-bottom: 10px;">
					<button type="button" class="btn btn-white btn-active-light-primary my-1" data-bs-toggle="modal" data-bs-target="#kt_modal_update_role" onclick="resetForm()">Add a Role</button>
				</div>	
			</div>
			<!--begin::Row-->
			<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-9">



				@foreach($roles as $role)

				<!--begin::Col-->
				<div class="col-md-4">
					<!--begin::Card-->
					<div class="card card-flush h-md-100">
						<!--begin::Card header-->
						<div class="card-header">
							<!--begin::Card title-->
							<div class="card-title">
								<h2>{{$role->title}}</h2>
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



								{{-- <?php    $permissions =json_decode($role->permissions);   ?>
									@foreach ($permissions as $item)
									--}}

									{{-- <div class="d-flex align-items-center py-2">
										<span class="bullet bg-primary me-3"></span>{{$item}}</div>	 --}}
										{{-- @endforeach --}}
										{{-- <div class='d-flex align-items-center py-2'>
											<span class='bullet bg-primary me-3'></span>
											<em>and  more...</em>
										</div> --}}
									</div>
									<!--end::Permissions-->
								</div>
								<!--end::Card body-->
								<!--begin::Card footer-->
								<div class="card-footer flex-wrap pt-0">
									<button type="button" class="btn btn-white btn-active-light-primary my-1" data-bs-toggle="modal" data-bs-target="#kt_modal_update_role" onclick="getAccess({{$role->id}})">Edit Role</button>
									<a type="button" class="btn btn-light btn-active-warning my-1 me-2"onclick="deleteAccess({{$role->id}})">Delete Role</a>

								</div>
								<!--end::Card footer-->
							</div>
							<!--end::Card-->
						</div>
						<!--end::Col-->
						@endforeach




						<!--begin::Add new card-->
					</div>
					<!--end::Row-->
					<!--begin::Modals-->
					<!--begin::Modal - Add role-->

					<!--end::Modal - Add role-->
					<!--begin::Modal - Update role-->
					<div class="modal fade" id="kt_modal_update_role" tabindex="-1" aria-hidden="true">
						<!--begin::Modal dialog-->
						<div class="modal-dialog modal-dialog-centered mw-750px">
							<!--begin::Modal content-->
							<div class="modal-content">
								<!--begin::Modal header-->
								<div class="modal-header">
									<!--begin::Modal title-->
									<h2 class="fw-bolder" id="form_head">Add a Role</h2>
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
									<form id="kt_modal_update_role_form" class="form" action="{{url('insertAccess')}}" method="POST" enctype="multipart/form-data">
										@csrf
										<div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_update_role_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_update_role_header" data-kt-scroll-wrappers="#kt_modal_update_role_scroll" data-kt-scroll-offset="300px">
											<!--begin::Input group-->
											<div class="fv-row mb-10">
												<!--begin::Label-->
												<label class="fs-5 fw-bolder form-label mb-2">
													<span class="required">Role name</span>
												</label>
												<!--end::Label-->
												<!--begin::Input-->
												<input class="form-control form-control-solid" placeholder="Enter a role name" name="role_name"  id="role_name" value="" />
												<!--end::Input-->
											</div>
											<!--end::Input group-->
											<!--begin::Input group-->
											<div class="fv-row mb-10" style="display: none;">
												<!--begin::Label-->
												<label class="fs-5 fw-bolder form-label mb-2">
													<span class="required">Customers</span>
												</label>
												<!--end::Label-->
												<select name="customer_selection[]" id="customer-selection" multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1">
													@foreach($customers as $cust)
													<option value="{{$cust->id}}">{{$cust->name}}</option>
													@endforeach
												</select>

											</div>
											<!--end::Input group-->
											<div class="fv-row mb-10" id="select_sites_div" style="display: none;">
												

											</div>
											<!--end::Input group-->
											<!--begin::Permissions-->
											<div class="fv-row">
												<!--begin::Label-->
												<label class="fs-5 fw-bolder form-label mb-2">Role Permissions</label>
												<!--end::Label-->
												<!--begin::Table wrapper-->
												<div class="table-responsive">
													<!--begin::Table-->
													<table class="table align-middle table-row-dashed fs-6 gy-5">
														<!--begin::Table body-->
														<tbody class="text-gray-600 fw-bold">
															<!--begin::Table row-->


															<!-- uncomment in future -->
																	<!-- <tr>
																		<td class="text-gray-800">Administrator Access
																		<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Allows a full access to the system"></i></td>
																		<td> -->
																			<!--begin::Checkbox-->
																		<!-- 	<label class="form-check form-check-sm form-check-custom form-check-solid me-9">
																				<input class="form-check-input" type="checkbox"  value="" id="kt_roles_select_all" />
																				<span class="form-check-label" for="kt_roles_select_all">Select all</span>
																			</label> -->
																			<!--end::Checkbox-->
																	<!-- 	</td>
																	</tr> -->
																	<!--end::Table row-->
																	<!--begin::Table row-->
																	<!-- <tr>
																		<td class="text-gray-800">Dashboard Management</td>
																		<td>
																			<div class="d-flex">
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="dashboard" name="dashboard" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="radio" id="dashboard_full_access" name="dashboard_full_access" value="view_only"  />
																					<span class="form-check-label">View Only</span>
																				</label>
																				<label class="form-check form-check-custom form-check-solid">
																					<input class="form-check-input" type="radio" id="dashboard_full_access" name="dashboard_full_access" value="full_access" />
																					<span class="form-check-label">Full Access</span>
																				</label>
																			</div>
																		</td>
																	</tr> -->
																	<!--end::Table row-->
																	<!--begin::Table row-->


																	<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">Job Roster</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="job_roster" name="job_roster" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="radio" id="job_roster_full_access" name="job_roster_full_access" value="view_only"  />
																					<span class="form-check-label">View Only</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid">
																					<input class="form-check-input" type="radio" id="job_roster_full_access" name="job_roster_full_access" value="full_access" />
																					<span class="form-check-label">Full Access</span>
																				</label>
																				<!--end::Checkbox-->
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->

																	<!--begin::Table row-->
																	<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">Add Site</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="add_site" name="add_site" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				
																				
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->
																	<!--begin::Table row-->
																	<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">Ad-hoc shift</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="adhoc_shift" name="adhoc_shift" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				
																				
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->
																	<!--begin::Table row-->
																	<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">Roster Report</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="roster_report" name="roster_report" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				
																				
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->
																	<!--begin::Table row-->
																	<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">Roster Action</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="roster_action" name="roster_action" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				
																				
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->
																	<!--begin::Table row-->
																	<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">View by {{config('custom.guard')}}</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="view_by_guard" name="view_by_guard" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				
																				
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->
																	<!--begin::Table row-->
																	<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">Roster Shifts</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="roster_shifts" name="roster_shifts" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				
																				
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->
																	<!--begin::Table row-->
																	<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">Site Edit</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="site_edit" name="site_edit" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				
																				
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">Site Delete</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="site_delete" name="site_delete" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				
																				
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->

																	<!--begin::Table row-->

																	<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">Edit/Delete Roster</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="rosterControl" name="rosterControl" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->
																	<!--begin::Table row-->

																	<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">Lock Roster</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="lock_roster" name="lock_roster" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->
																	<!--begin::Table row-->

																	<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">8 hour break bypass</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="break_bypass" name="break_bypass" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->


																	<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">22 hour limit</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="22_hour_limit" name="22_hour_limit" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->


																	<!--begin::Table row-->
																	<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">Time Sheet</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="timesheet" name="timesheet" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="radio" id="timesheet-full_access" name="timesheet_full_access" value="view_only"  />
																					<span class="form-check-label">View Only</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid">
																					<input class="form-check-input" type="radio" id="timesheet_full_access" name="timesheet_full_access" value="full_access" />
																					<span class="form-check-label">Full Access</span>
																				</label>
																				<!--end::Checkbox-->
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->
<!--begin::Table row-->

																	<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">Job Tracker</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="job_tracker" name="job_tracker" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="radio" id="job_tracker_full_access" name="job_tracker_full_access" value="view_only"  />
																					<span class="form-check-label">View Only</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid">
																					<input class="form-check-input" type="radio" id="job_tracker_full_access" name="job_tracker_full_access" value="full_access" />
																					<span class="form-check-label">Full Access</span>
																				</label>
																				<!--end::Checkbox-->
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->

																	<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">Job Tracker Approval</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="job_tracker_approval" name="job_tracker_approval" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->
																	<!--begin::Table row-->
																	<!--begin::Table row-->
																	<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">Leave Management</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="leave_management" name="leave_management" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->
																	<!--begin::Table row-->
																	<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">Time Clock</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="time_clock" name="time_clock" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->
																	<!--begin::Table row-->

																	<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">Log user activity</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="staff_audit" name="staff_audit" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="radio" id="staff_audit_full_access" name="staff_audit_full_access" value="view_only"  />
																					<span class="form-check-label">View Only</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid">
																					<input class="form-check-input" type="radio" id="staff_audit_full_access" name="staff_audit_full_access" value="full_access" />
																					<span class="form-check-label">Full Access</span>
																				</label>
																				<!--end::Checkbox-->
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->



																	<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">Administrator</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="administrator" name="administrator" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="radio" id="administrator_full_access" name="administrator_full_access" value="view_only"  />
																					<span class="form-check-label">View Only</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid">
																					<input class="form-check-input" type="radio" id="administrator_full_access" name="administrator_full_access" value="full_access" />
																					<span class="form-check-label">Full Access</span>
																				</label>
																				<!--end::Checkbox-->
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->
																	<!--begin::Table row-->




						



																	<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">Customer</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="customer" name="customer" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="radio" id="customer_full_access" name="customer_full_access" value="view_only"  />
																					<span class="form-check-label">View Only</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid">
																					<input class="form-check-input" type="radio" id="customer_full_access" name="customer_full_access" value="full_access" />
																					<span class="form-check-label">Full Access</span>
																				</label>
																				<!--end::Checkbox-->
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->
																	<!--begin::Table row-->





																	<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">Contractor</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="contractor" name="contractor" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="radio" id="contractor_full_access" name="contractor_full_access" value="view_only"  />
																					<span class="form-check-label">View Only</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid">
																					<input class="form-check-input" type="radio" id="contractor_full_access" name="contractor_full_access" value="full_access" />
																					<span class="form-check-label">Full Access</span>
																				</label>
																				<!--end::Checkbox-->
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->
																	<!--begin::Table row-->
																	<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">{{config('custom.guard')}}</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="guard" name="guard" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="radio" id="guard_full_access" name="guard_full_access" value="view_only"  />
																					<span class="form-check-label">View Only</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid">
																					<input class="form-check-input" type="radio" id="guard_full_access" name="guard_full_access" value="full_access" />
																					<span class="form-check-label">Full Access</span>
																				</label>
																				<!--end::Checkbox-->
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->
																	<!--begin::Table row-->

																	<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">Reports</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="reports" name="reports" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="radio" id="reports_full_access" name="reports_full_access" value="view_only"  />
																					<span class="form-check-label">View Only</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid">
																					<input class="form-check-input" type="radio" id="reports_full_access" name="reports_full_access" value="full_access" />
																					<span class="form-check-label">Full Access</span>
																				</label>
																				<!--end::Checkbox-->
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->
																	<!--begin::Table row-->


<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">Task Report</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="task_report" name="task_report" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="radio" id="task_report_full_access" name="task_report_full_access" value="view_only"  />
																					<span class="form-check-label">View Only</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid">
																					<input class="form-check-input" type="radio" id="task_report_full_access" name="task_report_full_access" value="full_access" />
																					<span class="form-check-label">Full Access</span>
																				</label>
																				<!--end::Checkbox-->
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->
																	<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">Contractor Report</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="contractor_report" name="contractor_report" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="radio" id="contractor_report_full_access" name="contractor_report_full_access" value="view_only"  />
																					<span class="form-check-label">View Only</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid">
																					<input class="form-check-input" type="radio" id="contractor_report_full_access" name="contractor_report_full_access" value="full_access" />
																					<span class="form-check-label">Full Access</span>
																				</label>
																				<!--end::Checkbox-->
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->
																	<!--begin::Table row-->


																	






																	<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">Customer Report</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="customer_report" name="customer_report" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="radio" id="customer_report_full_access" name="customer_report_full_access" value="view_only"  />
																					<span class="form-check-label">View Only</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid">
																					<input class="form-check-input" type="radio" id="customer_report_full_access" name="customer_report_full_access" value="full_access" />
																					<span class="form-check-label">Full Access</span>
																				</label>
																				<!--end::Checkbox-->
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->
																	<!--begin::Table row-->

<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">{{config('custom.guard')}} Report</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="guard_report" name="guard_report" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->
																	<!--begin::Table row-->

																	
<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">Invoice Report</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="invoice_report" name="invoice_report" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="radio" id="invoice_report_full_access" name="invoice_report_full_access" value="view_only"  />
																					<span class="form-check-label">View Only</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid">
																					<input class="form-check-input" type="radio" id="invoice_report_full_access" name="invoice_report_full_access" value="full_access" />
																					<span class="form-check-label">Full Access</span>
																				</label>
																				<!--end::Checkbox-->
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->

<!--begin::Table row-->

																	<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">Paysheet Report</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="paysheet_report" name="paysheet_report" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="radio" id="paysheet_report_full_access" name="paysheet_report_full_access" value="view_only"  />
																					<span class="form-check-label">View Only</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid">
																					<input class="form-check-input" type="radio" id="paysheet_report_full_access" name="paysheet_report_full_access" value="full_access" />
																					<span class="form-check-label">Full Access</span>
																				</label>
																				<!--end::Checkbox-->
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->

																	
<!--begin::Table row-->

																	

																	


																	<!--begin::Table row-->

																	<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">Incident Report</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="incident_report" name="incident_report" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="radio" id="incident_report_full_access" name="incident_report_full_access" value="view_only"  />
																					<span class="form-check-label">View Only</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid">
																					<input class="form-check-input" type="radio" id="incident_report_full_access" name="incident_report_full_access" value="full_access" />
																					<span class="form-check-label">Full Access</span>
																				</label>
																				<!--end::Checkbox-->
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->

																	<!--begin::Table row-->

																	

																	<!--begin::Table row-->

																	<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">Complete Report</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="complete_report" name="complete_report" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="radio" id="complete_report_full_access" name="complete_report_full_access" value="view_only"  />
																					<span class="form-check-label">View Only</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid">
																					<input class="form-check-input" type="radio" id="complete_report_full_access" name="complete_report_full_access" value="full_access" />
																					<span class="form-check-label">Full Access</span>
																				</label>
																				<!--end::Checkbox-->
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->
																	<!-- <tr>
																		<td class="text-gray-800">Green & Welfare Call Report</td>
																		<td>
																			<div class="d-flex">
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="green_and_welfare_report" name="green_and_welfare_report" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				
																			</div>
																		</td>
																	</tr> -->
																	<!--end::Table row-->
																	
																	<!--begin::Table row-->




																	<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">Chat</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="communication" name="communication" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="radio" id="communication_full_access" name="communication_full_access" value="view_only"  />
																					<span class="form-check-label">View Only</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid">
																					<input class="form-check-input" type="radio" id="communication_full_access" name="communication_full_access" value="full_access" />
																					<span class="form-check-label">Full Access</span>
																				</label>
																				<!--end::Checkbox-->
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->
																	<!--begin::Table row-->

																	<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800"> Announcements</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="announcements" name="announcements" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="radio" id="announcements_full_access" name="announcements_full_access" value="view_only"  />
																					<span class="form-check-label">View Only</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid">
																					<input class="form-check-input" type="radio" id="announcements_full_access" name="announcements_full_access" value="full_access" />
																					<span class="form-check-label">Full Access</span>
																				</label>
																				<!--end::Checkbox-->
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->
																	<!--begin::Table row-->
<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">Induction</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="tutorial" name="tutorial" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="radio" id="tutorial_full_access" name="tutorial_full_access" value="view_only"  />
																					<span class="form-check-label">View Only</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid">
																					<input class="form-check-input" type="radio" id="tutorial_full_access" name="tutorial_full_access" value="full_access" />
																					<span class="form-check-label">Full Access</span>
																				</label>
																				<!--end::Checkbox-->
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->
																	


																	<!-- <tr>
																		<td class="text-gray-800">Charge Rates</td>
																		<td>
																			<div class="d-flex">
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="charge_rates" name="charge_rates" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="radio" id="charge_rates_full_access" name="charge_rates_full_access" value="view_only"  />
																					<span class="form-check-label">View Only</span>
																				</label>
																				<label class="form-check form-check-custom form-check-solid">
																					<input class="form-check-input" type="radio" id="charge_rates_full_access" name="charge_rates_full_access" value="full_access" />
																					<span class="form-check-label">Full Access</span>
																				</label>
																			</div>
																		</td>
																	</tr>
 -->																	

																	<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">Pay Rates</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="pay_rates" name="pay_rates" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="radio" id="pay_rates_full_access" name="pay_rates_full_access" value="view_only"  />
																					<span class="form-check-label">View Only</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid">
																					<input class="form-check-input" type="radio" id="pay_rates_full_access" name="pay_rates_full_access" value="full_access" />
																					<span class="form-check-label">Full Access</span>
																				</label>
																				<!--end::Checkbox-->
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->
																	
																	<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">App Settings</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="app_settings" name="app_settings" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="radio" id="app_settings_full_access" name="app_settings_full_access" value="view_only"  />
																					<span class="form-check-label">View Only</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid">
																					<input class="form-check-input" type="radio" id="app_settings_full_access" name="app_settings_full_access" value="full_access" />
																					<span class="form-check-label">Full Access</span>
																				</label>
																				<!--end::Checkbox-->
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->


																	<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">Portal Settings</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="portal_settings" name="portal_settings" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="radio" id="portal_settings_full_access" name="portal_settings_full_access" value="view_only"  />
																					<span class="form-check-label">View Only</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid">
																					<input class="form-check-input" type="radio" id="portal_settings_full_access" name="portal_settings_full_access" value="full_access" />
																					<span class="form-check-label">Full Access</span>
																				</label>
																				<!--end::Checkbox-->
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->
																	<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">Mock {{config('custom.guard')}}</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="mock_guard" name="mock_guard" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->

																	<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">Division Consolidation</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="division_consolidation" name="division_consolidation" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->

																	<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">About Us</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="about_us" name="about_us" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="radio" id="about_us_full_access" name="about_us_full_access" value="view_only"  />
																					<span class="form-check-label">View Only</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid">
																					<input class="form-check-input" type="radio" id="about_us_full_access" name="about_us_full_access" value="full_access" />
																					<span class="form-check-label">Full Access</span>
																				</label>
																				<!--end::Checkbox-->
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<tr>
																		<!--begin::Label-->
																		<td class="text-gray-800">Audit Report</td>
																		<!--end::Label-->
																		<!--begin::Input group-->
																		<td>
																			<!--begin::Wrapper-->
																			<div class="d-flex">
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="checkbox" id="audit_report" name="audit_report" />
																					<span class="form-check-label">Enable</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
																					<input class="form-check-input" type="radio" id="audit_report_full_access" name="audit_report_full_access" value="view_only"  />
																					<span class="form-check-label">View Only</span>
																				</label>
																				<!--end::Checkbox-->
																				<!--begin::Checkbox-->
																				<label class="form-check form-check-custom form-check-solid">
																					<input class="form-check-input" type="radio" id="audit_report_full_access" name="audit_report_full_access" value="full_access" />
																					<span class="form-check-label">Full Access</span>
																				</label>
																				<!--end::Checkbox-->
																			</div>
																			<!--end::Wrapper-->
																		</td>
																		<!--end::Input group-->
																	</tr>
																	<!--end::Table row-->
																	

																	<!--end::Table row-->
																	<!--begin::Table row-->
																	<!--end::Table row-->
																</tbody>
																<!--end::Table body-->
															</table>
															<!--end::Table-->
														</div>
														<!--end::Table wrapper-->
													</div>
													<!--end::Permissions-->
												</div>
												<!--end::Scroll-->
												<!--begin::Actions-->
												<div class="text-center pt-15">
													<button type="button" class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close"><span style="margin-right: 74px;font-size: 15px;">Discard</span></button>
													<button type="submit" class="btn btn-primary" data-kt-roles-modal-action="submit">
														<span class="indicator-label" id="form_button">Submit</span>
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
								<!--end::Modal - Update role-->
								<!--end::Modals-->
							</div>
							<!--end::Container-->
						</div>
						<!--end::Content-->
						<!--begin::Footer-->

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
						<script src="{{asset('')}}js/custom/apps/user-management/roles/list/add.js"></script>
						<script src="{{asset('')}}js/custom/apps/user-management/roles/list/update-role.js"></script>
						<script src="{{asset('')}}js/custom/widgets.js"></script>
						<script src="{{asset('')}}js/custom/apps/chat/chat.js"></script>
						<script src="{{asset('')}}js/custom/modals/create-app.js"></script>
						<script src="{{asset('')}}js/custom/modals/upgrade-plan.js"></script>
						<!--end::Page Custom Javascript-->
						<!--end::Javascript-->

						<script>


							function getAccess(id){
								call_spinner();

								$.ajax({
									type:'GET',
									url:`{{url('getAccess')}}/${id}`,
									data:{ _token  : '<?php echo csrf_token() ?>'},
									success:function(result) {
										console.log(result)
										$('#kt_modal_update_role').modal('show');
										var  messageArray= JSON.parse(result['permissions']);

										$('.multiselect-dropdown').remove();
										$('#customer-selection').val(result.specific_customer);
										MultiselectDropdown();
										$.each(messageArray , function(index, value){
											if (value == "view_only") {
												$("input[name="+index+"][value='"+value+"']").prop('checked', true);

											}
										})
										$.each(messageArray , function(index, value){
											if (value == "full_access") {
												$("input[name="+index+"][value='"+value+"']").prop('checked', true);

											}

										})

										$.each(messageArray , function(index, value){
											if (value == true) {
												$('#'+index).prop('checked', true);

											}
				 	// else{
				 	// 	$('#'+index).prop('checked', false);
				 	// }
				 	// console.log(index, value)
				 })

// 				 	var index=0;
//                	           while(index < messageArray.length){
//   console.log(messageArray[index]);
//   index += 1;
// }

				  // console.log(current_role);
				  $('#role_name').val(result.title);

				  obj=result['permissions'];

				  var array=[];

				 // console.log(JSON.stringify(obj)); // {"a":1,"b":2,"c":{"d":3,"e":4}}


//console.log(result['permissions']);
// console.log(result.permissions);

document.getElementById("form_head").innerHTML = "Edit a role";



document.getElementById("form_button").innerHTML = "Update";
$('#kt_modal_update_role_form').attr('action', `{{url('editAccess')}}/${id}`);
// getSites(result.sites);
close_spinner()
}
});
							}
							function openModal() {
								$('#kt_modal_add_user').modal('show');
							}



							function deleteAccess(id){


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
										$.ajax({type: "POST",url: `{{url('deleteAccess')}}/${id}`, data:{_token:'<?php echo csrf_token();?>'},success: function(result){
											Swal.fire({
												text: "Deleted Succesfully.",
												icon: "success",
												buttonsStyling: !1,
												confirmButtonText: "Ok, got it!",
												customClass: {
													confirmButton: "btn btn-primary"
												}
											})
											window.location.href = "{{ url('/access')}}";
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
							function resetForm()
							{
								document.getElementById('kt_modal_update_role_form').reset();
							}	
							$( document ).ready(function() {
								MultiselectDropdown();
							});
							$('#customer-selection').change(function(){
								// getSites();
							});
							function getSites(sites = null)
							{
								var customer_id = $('#customer-selection').val();
								$.ajax({type: "POST",url: `{{url('job_tracker/get_customers_jobs_list_filter')}}`, data:{_token:'<?php echo csrf_token();?>', customer_id : customer_id, from : 'access'},success: function(result){
											var opt = `<label class="fs-5 fw-bolder form-label mb-2">
													<span class="required">Sites</span>
												</label>
												<select name="sites[]" id="site-selection" multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1">`;
									$.each(result.jobs, function(indx, valx){
										opt += `<option value="${valx.job_id}">${valx.site_name}</option>`

									});
												opt += `</select>`;
									$('#customer-selection').attr('multiple', false);
									$('#select_sites_div').html(opt);
									if (sites != null) {
										$('#site-selection').val(sites);
									}
		             				MultiselectDropdown();
									$('#customer-selection').attr('multiple', true);

										}
									})
							}
						</script>


						@stop
