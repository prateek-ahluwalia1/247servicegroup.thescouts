

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

@foreach($admins as $admin)
		@if($admin->image  == NULL)

<style>

#profile_{{$admin->id}} {
width: 50px;
height: 50px;
border-radius: 50%;
background: #986A32;
font-size: 15px;
color: #fff;
text-align: center;
line-height: 50px;
margin: 5px 0;
}

	</style>
	@endif
@endforeach


@stop

	<!--end::Head-->
	<!--begin::Body-->
	
		<!--begin::Main-->
		<!--begin::Root-->
	@section('content')
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
								<h1 class="text-dark fw-bolder my-0 fs-2">Users List</h1>
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
								<div class="card-header border-0 pt-6">
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
											<input type="text" id="search"  class="form-control form-control-solid w-250px ps-14" placeholder="Search user" />
										</div>
										<!--end::Search-->
									</div>
									<!--begin::Card title-->
									<!--begin::Card toolbar-->
									<div class="card-toolbar">
										<!--begin::Toolbar-->
										<div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
											
											<!--begin::Export-->
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
											
										
											<!--begin::Add user-->
											<button type="button" id="#kt_modal_add_user_button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user" onclick="resetForm()">
											<!--begin::Svg Icon | path: icons/duotone/Navigation/Plus.svg-->
											<span class="svg-icon svg-icon-2">
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
													<rect fill="#000000" x="4" y="11" width="16" height="2" rx="1" />
													<rect fill="#000000" opacity="0.5" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000)" x="4" y="11" width="16" height="2" rx="1" />
												</svg>
											</span>
											<!--end::Svg Icon--><span >Add User</span></button>
											<!--end::Add user-->
										</div>
										<!--end::Toolbar-->
										<!--begin::Group actions-->
										<div class="d-flex justify-content-end align-items-center d-none" data-kt-user-table-toolbar="selected">
											<div class="fw-bolder me-5">
											<span class="me-2" data-kt-user-table-select="selected_count"></span>Selected</div>
											<button type="button" class="btn btn-danger" data-kt-user-table-select="delete_selected">Delete Selected</button>
										</div>
										<!--end::Group actions-->
										<!--begin::Modal - Adjust Balance-->
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
														<div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
															<!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
															<span class="svg-icon svg-icon-1">
																<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
																		<rect fill="#000000" x="0" y="7" width="16" height="2" rx="1" />
																		<rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1" />
																	</g>
																</svg>
															</span>
															<!--end::Svg Icon-->
														</div>
														<!--end::Close-->
													</div>
													<!--end::Modal header-->
													<!--begin::Modal body-->
													<div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
														<!--begin::Form-->
														<form id="export_user_form" class="form" action="{{url('admin/admin_pdf')}}" method="POST" enctype="multipart/form-data">
                                                    @csrf
 
															<!--begin::Input group-->
															<div class="fv-row mb-10">
																<!--begin::Label-->
																<label class="fs-6 fw-bold form-label mb-2">Select Roles:</label>
																<!--end::Label-->
																<!--begin::Input-->
																<select name="role" data-control="select2" data-placeholder="Select a role" data-hide-search="true" class="form-select form-select-solid fw-bolder" required>

																	@foreach($roles as $role)
																	<option value="{{$role->id}}">{{$role->title}}</option>
																	@endforeach
																</select>
																<!--end::Input-->
															</div>
															<!--end::Input group-->
															<!--begin::Input group-->
															<div class="fv-row mb-10">
																<!--begin::Label-->
																<label class="required fs-6 fw-bold form-label mb-2">Select Export Format:</label>
																<!--end::Label-->
																<!--begin::Input-->
																<select name="format" data-control="select2" data-placeholder="Select a format" data-hide-search="true" class="form-select form-select-solid fw-bolder">
																	<option></option>
																	<!-- <option value="excel">Excel</option> -->
																	<option value="pdf">PDF</option>
																	<!-- <option value="cvs">CVS</option>
																	<option value="zip">ZIP</option> -->
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
										<!--end::Modal - New Card-->
										<!--begin::Modal - Add task-->
										<div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true" data-backdrop="static" data-keyboard="false">
											<!--begin::Modal dialog-->
											<div class="modal-dialog modal-dialog-centered mw-650px">
												<!--begin::Modal content-->
												<div class="modal-content">
													<!--begin::Modal header-->
													<div class="modal-header" id="kt_modal_add_user_header">
														<!--begin::Modal title-->
														<h2 class="fw-bolder" id="form_head">Add User</h2>
														<!--end::Modal title-->
														<!--begin::Close-->
														<div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
															<!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
															<span class="svg-icon svg-icon-1">
																<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
																		<rect fill="#000000" x="0" y="7" width="16" height="2" rx="1" />
																		<rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1" />
																	</g>
																</svg>
															</span>
															<!--end::Svg Icon-->
														</div>
														<!--end::Close-->
													</div>
													<!--end::Modal header-->
													<!--begin::Modal body-->
													<div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
														<!--begin::Form-->
														<form id="kt_modal_add_user_form" class="form" 
														action="{{url('insertUser')}}" method="POST" enctype="multipart/form-data">
																    @csrf

															<!--begin::Scroll-->
															<div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
																<!--begin::Input group-->
																<div class="fv-row mb-7">
																	<!--begin::Label-->
																	<label class="d-block fw-bold fs-6 mb-5">Avatar</label>
																	<!--end::Label-->
																	<!--begin::Image input-->
																	<div class="image-input image-input-outline" data-kt-image-input="true" id="avatar" style="background-image: url(assets/media/avatars/blank.png)">
																		<!--begin::Preview existing avatar-->
																		<div class="image-input-wrapper w-125px h-125px" id="preview_img" style=""></div>
																		<!--end::Preview existing avatar-->
																		<!--begin::Label-->
																		<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
																			<i class="bi bi-pencil-fill fs-7"></i>
																			<!--begin::Inputs-->
																			<input type="file"  name="avatar" id="file_image" accept=".png, .jpg, .jpeg" />	
																			<input type="hidden" name="avatar_remove" />
																			<!--end::Inputs-->
																		</label>
																		<!--end::Label-->
																		<!--begin::Cancel-->
																		<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
																			<i class="bi bi-x fs-2"></i>
																		</span>
																		<!--end::Cancel-->
																		<!--begin::Remove-->
																		<span onclick ="avatar_remove()"class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
																			<i class="bi bi-x fs-2"></i>
																		</span>
																		<!--end::Remove-->
																	</div>
																	<!--end::Image input-->
																	<!--begin::Hint-->
																	<div class="form-text">Allowed file types: png, jpg, jpeg.</div>
																	<!--end::Hint-->
																</div>
																<!--end::Input group-->
																<!--begin::Input group-->
																<div class="fv-row mb-7">
																	<!--begin::Label-->
																	<label class="required fw-bold fs-6 mb-2">Full Name</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="text" id="user_name" name="user_name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Full name" value="" required />
																	
																	<!--end::Input-->
																</div>
																<!--end::Input group-->
																<!--begin::Input group-->
																<div class="fv-row mb-7">
																	<!--begin::Label-->
																	<label class="required fw-bold fs-6 mb-2">Email</label>
																	<!--end::Label-->
																	<!--begin::Input-->

																	<input type="email"  id="user_email" name="user_email" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="example@domain.com" value="" required />
																	<!--end::Input-->
																</div>
																<div class="row">
																	<div id="div_states" class="col-sm-6 ">
																		<label class="fs-6 required form-label fw-bolder text-dark">Primary State</label>
																	  <div class="fv-row mb-10">
																	  <select  id="state" name="state" class="form-select">
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
																	<div id="multiple_states_div" class="col-sm-6 ">
																		<label class="fs-6 form-label fw-bolder text-dark">Multiple State</label>
																	  <div class="fv-row mb-10">
																	  <select class="multiselect-selection" multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1" id="multiple_states" name="multiple_states[]" >
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
																</div>
																<!--end::Input group-->
																<!--begin::Input group-->
											<div class="fv-row mb-10" id="customer-selection-div">
												<!--begin::Label-->
												<label class="fs-5 fw-bolder form-label mb-2">
													<span class="required">Customers</span>
												</label>
												<!--end::Label-->
												<select name="customer_selection[]" class="multiselect-selection" id="customer-selection" multiple multiselect-search="true" multiselect-select-all="true">
													@foreach($customers as $cust)
													<option value="{{$cust->id}}">{{$cust->name}}</option>
													@endforeach
												</select>

											</div>
											<!--end::Input group-->
											<!--end::Input group-->
											<div class="fv-row mb-10" id="select_sites_div">
												

											</div>

											<div class="fv-row mb-10">
												<label class="fs-5 fw-bolder form-label mb-2">
													<span class="required">Status</span>
												</label>
												<div class="d-flex fv-row">
													<!--begin::Radio-->
													<div class="form-check form-check-custom form-check-solid">
																			<!--begin::Input-->
													<input class="form-check-input me-3" name="status" type="radio" value="active"  />

													<label class="form-check-label" for="kt_modal_update_role_option_0">
													<div class="fw-bolder text-gray-800">Active</div>
													</label>				
													</div>
													</div>
													<div class="d-flex fv-row">
													<!--begin::Radio-->
													<div class="form-check form-check-custom form-check-solid">
																			<!--begin::Input-->
													<input class="form-check-input me-3" name="status" type="radio" value="inactive"  />

													<label class="form-check-label" for="kt_modal_update_role_option_0">
													<div class="fw-bolder text-gray-800">In-Active</div>
													</label>				
													</div>
													</div>
											</div>
											<!--end::Input group-->
																<!--begin::Input group-->
																<div class="mb-7">
																	<!--begin::Label-->
																	<label class="required fw-bold fs-6 mb-5">Role</label>
																	<!--end::Label-->
																	<!--begin::Roles-->
																	<!--begin::Input row-->
											@foreach($roles as $role)
																	<div class="d-flex fv-row">
																		<!--begin::Radio-->
																		<div class="form-check form-check-custom form-check-solid">
																			<!--begin::Input-->
																		<input class="form-check-input me-3" name="user_role" type="radio" value="{{$role->id}}" id="role_{{$role->id}}"  />
																		<!-- <input class="form-check-input me-3" name="user_role_id" type="hidden" value="{{$role->id}}" id="role_hidden_{{$role->id}}"  /> -->

																			<!--end::Input-->
																			<!--begin::Label-->
																			<label class="form-check-label" for="kt_modal_update_role_option_0">
																				<div class="fw-bolder text-gray-800" id="{{$role->title}}">{{$role->title}}</div>
																				<!-- <div class="text-gray-600">Best for business owners and company administrators</div> -->
																			</label>
																			<!--end::Label-->
																		</div>
																		<!--end::Radio-->
																	</div>
																	<!--end::Input row-->
																	<div class='separator separator-dashed my-5'></div>
															@endforeach
																	<!--end::Roles-->
																</div>
															
															
																<!--end::Input group-->
															</div>
															<!--end::Scroll-->
															<!--begin::Actions-->
															<div class="text-center pt-15">
																<button type="reset" class="btn btn-white me-3" data-kt-users-modal-action="cancel">Discard</button>
																<button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
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
										<!--end::Modal - Add task-->
									</div>
									<!--end::Card toolbar-->
								</div>
								<!--end::Card header-->
								<!--begin::Card body-->
								<div class="card-body pt-0">
									<!--begin::Table-->
									<table class="table align-middle table-row-dashed fs-6 gy-5" id="table">
										<!--begin::Table head-->
										<thead>
											<!--begin::Table row-->
											<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
												<th class="min-w-125px">User</th>
												<!-- <th class="min-w-125px">Role</th> -->
												<th class="min-w-125px">Last login</th>
												<!-- <th class="min-w-125px">Two-step</th> -->
												<th class="min-w-125px">Role</th>
												<th class="min-w-125px">Status</th>
												<th class="text-end min-w-100px">Actions</th>
											</tr>
											<!--end::Table row-->
										</thead>
										<!--end::Table head-->
										<!--begin::Table body-->
										<tbody class="text-gray-600 fw-bold">
											<!--begin::Table row-->
											@foreach($admins as $admin)
											<tr>
												<!--begin::Checkbox-->
												
												<!--end::Checkbox-->
												<!--begin::User=-->
												<td class="d-flex align-items-center">
													<!--begin:: Avatar -->
													<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
															<div class="symbol-label " id="profile_{{$admin->id}}">
																<img src="{{config('custom.asset_url')}}{{$admin->image}}" alt="" class="w-100" />
															</div>
													</div>
													<!--end::Avatar-->
													<!--begin::User details-->
													<div class="d-flex flex-column">
														<a href="{{url('profile') . '/' . $admin->id}}" class="text-gray-800 text-hover-primary mb-1">{{$admin->name}}</a>
														<span>{{$admin->email}}</span>
													</div>
													<!--begin::User details-->
												</td>
												<!--end::User=-->
												<!--begin::Role=-->


												<!--end::Role=-->
												<!--begin::Last login=-->
												<td>
													<div class="badge badge-light fw-bolder">{{date("d-m-Y",strtotime($admin->last_login))}}</div>
												</td>
												<!--end::Last login=-->
												<!--begin::Two step=-->
												<!-- <td></td> -->
												<!--end::Two step=-->
												<!--begin::Joined-->
												
												<td>{{$admin->role_name}}</td>
												<td>

													<div class="form-check form-check-solid form-switch fv-row">
														<input class="form-check-input w-45px h-30px" type="checkbox" id="status" name="status" onchange="active_status({{$admin->id}},this)" {{($admin->status == 'active' ? 'checked' : '')}}>
															
														<label class="form-check-label" for="status"></label>
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
														<div class="menu-item px-3">
														<a type="button" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="" onclick="getUser( {{ $admin->id }}, {{$admin->access_level_id}})">Edit</a>
														</div>
														<!--end::Menu item-->
														<!--begin::Menu item-->
														<div class="menu-item px-3">
															<a type="button" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="" onclick="deleteUser( {{ $admin->id }})" >Delete</a>
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
		<!--begin::Exolore drawer toggle-->

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

		@foreach($admins as $admin)
		@if($admin->image  == NULL)
<script type="text/javascript" >
	//search custom







		// alert(`{{session()->get('userName')}}`);
		var firstName =`{{$admin->name}}`;
			// console.log(firstName);
			// var firstName =firstName.text();
			// console.log(firstName);
			var intials = firstName.charAt(0);
			// console.log(intials);

			var profileImage = $(`#profile_{{$admin->id}}`).text(intials);
			</script>
			@endif
			@endforeach


	 <script>
		 		 			 $(document).ready(function() {
								MultiselectDropdown(window.MultiselectDropdownOptions);
	$('#table').DataTable({
		fixedHeader: true
	});
});

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



function getUser(id,access_level_id){
	

			$.ajax({
               type:'POST',
               url:"{{url('/getUser/')}}",
               data:{ _token  : '<?php echo csrf_token() ?>', id : id, access_level_id : access_level_id},
               success:function(result) {
               	           $('#kt_modal_add_user').modal('show');
						document.getElementById("form_button").innerHTML = "Update!";
					$('#kt_modal_add_user_form').attr('method', "POST");

				    $('#kt_modal_add_user_form').attr('action', `{{url('editUser')}}/${id}`);

					$('#state').val(result.state);

				// $('#multiple_states').val(result.multiple_states);
				// $('#multiple_states').attr('multiple', false);
				if (result.multiple_states != '') {
					var arr_new = JSON.parse(result.multiple_states);
				}else{
					var arr_new = [];
				}
				// $('#multiple_states').attr('multiple', true);
				generate_mutiple();
				$('select[name="multiple_states[]"]').val(arr_new);
				$('.multiselect-dropdown').remove();
				$('#customer-selection').val(result.specific_customer);
				$("input:radio[name=status][value="+result.status+"]").prop('checked', 'checked');
				$('#customer-selection-div>.multiselect-dropdown').remove();
				if (result.specific_sites != null && result.specific_sites != '') {
				getSites(result.specific_sites);
				}else{
				// $('#customer-selection').attr('multiple', false);
				MultiselectDropdown();
				// $('#customer_selection').attr('multiple', true);

				}
				// $('customer_selection').attr('multiple', false)
				// MultiselectDropdown(window.MultiselectDropdownOptions);
				// 

				// $.each(arr_new,function(id,data){
				// 	var element = $(`label:contains(${data})`);
				// 	var input=$(element).parents().closest('input');
				// 	$(element).parents().closest('div').addClass('checked');
				// 	$(input).prop('checked', true);
				// });
		 		 $('#user_name').val(result.name);
				  $('#user_email').val(result.email);
				  				  // console.log(`role_${result.access_level_id}`);
				  document.getElementById("form_head").innerHTML = "Edit User";
				  document.getElementById('preview_img').style.backgroundImage=`url({{config('custom.asset_url')}}${result.image})`; 
				  document.getElementById(`role_${result.access_level_id}`).checked = true;
			
				//   document.getElementById('avatar').style.backgroundImage=`url({{config('custom.asset_url')}}${result.image})`; // specify the image path here

               }
            });
}
function openModal() {
           $('#kt_modal_add_user').modal('show');
       }
	   

	   function generate_mutiple(){
		$('#multiple_states_div').html('');

    var html=`<label class="fs-6 form-label fw-bolder text-dark">Multiple State</label>
																	  <div class="fv-row mb-10">
																	  <select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1" id="multiple_states" name="multiple_states[]" class="_ac-customer-change">
																		  <option value="Victoria" >Victoria</option>
																		  <option value="New South Wales">NSW</option>
																		  <option value="Queensland">Queensland</option>
																		  <option value="Tasmania">Tasmania</option>
																		  <option value="Western Australia">Western Australia</option>
																		  <option value="South Australia">South Australia</option>
																		  <option value="ACT">ACT</option>
																		  </select>
																	  </div>`;
	$('#multiple_states_div').html(html);
	// MultiselectDropdown(window.MultiselectDropdownOptions);

	   }

function deleteUser(id){
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
							$.ajax({type: "POST",url: `{{url('deleteUser')}}/${id}`, data:{_token:'<?php echo csrf_token();?>'},success: function(result){
								Swal.fire({
                            text: "Deleted Succesfully.",
                            icon: "success",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        })
						window.location.href = "{{ url('/administrators')}}";
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




//  swal.fire({
//       title: "?",
//       text: "You will not be able to recover this contractor!",
//       icon: "warning",
//       buttons: [
//         'No, cancel it!',
//         'Yes, I am sure!'
//       ]
//     }).then(function(isConfirm) {
//       if (isConfirm) {
//         swal.fire({
//           title: 'Shortlisted!',
//           text: 'User Deleted successfully!',
//           icon: 'success'
//         }).then(function() {

//         		$.ajax({
//                type:'POST',
//                url:'/deleteUser/'+id,
//                data:{ _token  : '<?php echo csrf_token() ?>'}
              
//             });      
// 		            	window.location.href = "{{ url('/')}}";

//         });
//       } else {
//         swal.fire("Cancelled", "error");
//       }
//     })
       }

$("#kt_modal_add_user_form").trigger('reset')
function resetForm(){
	
	 	$('.multiselect-dropdown').remove();
		MultiselectDropdown();
	}





  $("#export_user_form").on('submit', function(e){
     // e.preventDefault();
     // console.log(this.id)
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

$('#customer-selection').change(function(){
								getSites();
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
									
									$('#select_sites_div').html(opt);
									if (sites != null) {
										$('#site-selection').val(sites);
		             					MultiselectDropdown();
									}else{
									generate_mutiple()
									// $('#multiple_states').attr('multiple', false);
									// $('#customer-selection').attr('multiple', false);
		             				$('#customer-selection-div>.multiselect-dropdown').remove();

		             				MultiselectDropdown();

		             				// $('#multiple_states').attr('multiple', true);
									// $('#customer-selection').attr('multiple', true);

									}
									// $('#multiple_states').attr('multiple', true);
									// $('#customer-selection').attr('multiple', true);

										}
									})
							}

	function active_status(id,e){
			var check='';
			//  console.log(($(e).value());
			if($(e).is(':checked')){
				check = "active";
				$(e).prop("checked", true)
			}else{
				check = "inactive";
				$(e).prop("checked", false)
			}
			$.ajax({type: "POST",url: "{{url('changeAdminStatus')}}", data:{id:id,check:check,_token: '<?php echo csrf_token();?>'},success: function(result){				
	}

	});
}
     </script>



		@stop
