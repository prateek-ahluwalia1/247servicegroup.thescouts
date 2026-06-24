
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
		<!--end::Page Vendor Stylesheets-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="{{ asset('')}}plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="{{ asset('')}}css/style.bundle.css" rel="stylesheet" type="text/css" />

<style>
.margin_top_doc{
	margin-top: 40px;
}

</style>
@stop
@section('content')
	<!--begin::Wrapper-->
	@foreach($guards as $guard)
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
					<!--begin::Header-->
					<div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
						<!--begin::Container-->
						<div class="container d-flex align-items-center justify-content-between" id="kt_header_container">
							<!--begin::Page title-->
							<div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-2 pb-2 pb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
								<!--begin::Heading-->
								<h1 class="text-dark fw-bolder my-0 fs-2">{{config('custom.guard')}} Profile</h1>
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
							
							<!--begin::Toolbar wrapper-->
							<div class="d-flex flex-shrink-0">
								<!--begin::Invite user-->
							
								<!--end::Invite user-->
								<!--begin::Create app-->
								
								<!--end::Create app-->
								<!--begin::Chat-->
								
								<!--end::Chat-->
							</div>
							@include('layout.toolbar') @yield('toolbar') 
							<!--end::Toolbar wrapper-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Header-->
					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Container-->
						<div class="container" id="kt_content_container">
							<!--begin::Navbar-->
							<div class="card mb-5 mb-xl-10">
								<div class="card-body pt-9 pb-0">
									<!--begin::Details-->
									<div class="d-flex flex-wrap flex-sm-nowrap mb-3">
										<!--begin: Pic-->
										<div class="me-7 mb-4">
											@if ($guard->profile_image!=null && $guard->profile_image!='' && $guard->profile_image!=' ' && $guard->profile_image!='null')
											<div class="symbol profile_image symbol-100px symbol-lg-160px symbol-fixed position-relative">
												<img src="{{config('custom.asset_url').$guard->profile_image}}"  />
											</div>
												@else
												<div class="symbol profile_image symbol-100px symbol-lg-160px symbol-fixed position-relative">
													<img style="background-color: #d99f23;color:#d99f23" src="https://img.icons8.com/material-outlined/96/000000/user--v1.png"/>
												</div>
											@endif
											

										</div>
										<!--end::Pic-->
										<!--begin::Info-->
										<div class="flex-grow-1">
											<!--begin::Title-->
											<div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
												<!--begin::User-->
												<div class="d-flex flex-column">
													<!--begin::Name-->
													<div class="d-flex align-items-center mb-2">

														<a  class="text-gray-800 text-hover-primary fs-2 fw-bolder me-1">{{$guard->name}}</a>
													@if($guard->status == 'active' )
														<!--begin::Svg Icon | path: icons/duotone/Design/Verified.svg-->
															<span class="svg-icon svg-icon-1 svg-icon-primary">
																<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<path d="M10.0813 3.7242C10.8849 2.16438 13.1151 2.16438 13.9187 3.7242V3.7242C14.4016 4.66147 15.4909 5.1127 16.4951 4.79139V4.79139C18.1663 4.25668 19.7433 5.83365 19.2086 7.50485V7.50485C18.8873 8.50905 19.3385 9.59842 20.2758 10.0813V10.0813C21.8356 10.8849 21.8356 13.1151 20.2758 13.9187V13.9187C19.3385 14.4016 18.8873 15.491 19.2086 16.4951V16.4951C19.7433 18.1663 18.1663 19.7433 16.4951 19.2086V19.2086C15.491 18.8873 14.4016 19.3385 13.9187 20.2758V20.2758C13.1151 21.8356 10.8849 21.8356 10.0813 20.2758V20.2758C9.59842 19.3385 8.50905 18.8873 7.50485 19.2086V19.2086C5.83365 19.7433 4.25668 18.1663 4.79139 16.4951V16.4951C5.1127 15.491 4.66147 14.4016 3.7242 13.9187V13.9187C2.16438 13.1151 2.16438 10.8849 3.7242 10.0813V10.0813C4.66147 9.59842 5.1127 8.50905 4.79139 7.50485V7.50485C4.25668 5.83365 5.83365 4.25668 7.50485 4.79139V4.79139C8.50905 5.1127 9.59842 4.66147 10.0813 3.7242V3.7242Z" fill="#00A3FF" />
																	<path class="permanent" d="M14.8563 9.1903C15.0606 8.94984 15.3771 8.9385 15.6175 9.14289C15.858 9.34728 15.8229 9.66433 15.6185 9.9048L11.863 14.6558C11.6554 14.9001 11.2876 14.9258 11.048 14.7128L8.47656 12.4271C8.24068 12.2174 8.21944 11.8563 8.42911 11.6204C8.63877 11.3845 8.99996 11.3633 9.23583 11.5729L11.3706 13.4705L14.8563 9.1903Z" fill="white" />
																</svg>
															</span>
															<!--end::Svg Icon-->
													<span class="btn btn-sm btn-light-success fw-bolder ms-2 fs-8 py-1 px-3">Active </span>
													@else
													<span class="btn btn-sm btn-light-danger fw-bolder ms-2 fs-8 py-1 px-3" >In Active </span>
													@endif
													<div style="margin-left:5px" class="rating d-flex  mt-auto mb-2">										

														<?php $rating=round( (5/100) * $guard->rating);
														?> 
														@for ($i = 1; $i < 6; $i++)
														@if ($i<=$rating)
														<div class="rating-label me-2 checked">
															<i class="bi bi-star-fill fs-5"></i>
														</div>
														@else
														<div class="rating-label me-2 ">
															<i class="bi bi-star-fill fs-5"></i>
														</div>
														@endif
														 @endfor
													</div>
												
														
													
												
													</div>
													<!--end::Name-->
													<!--begin::Info-->
													<div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2">
														<a  class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
														<!--begin::Svg Icon | path: icons/duotone/General/User.svg-->
														<span class="svg-icon svg-icon-4 me-1">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<polygon points="0 0 24 0 24 24 0 24" />
																	<path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
																	<path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
																</g>
															</svg>
														</span>
														<!--end::Svg Icon-->{{config('custom.guard')}}</a>
														<a  class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
														<!--begin::Svg Icon | path: icons/duotone/Map/Marker1.svg-->
														<span class="svg-icon svg-icon-4 me-1">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<rect x="0" y="0" width="24" height="24" />
																	<path d="M5,10.5 C5,6 8,3 12.5,3 C17,3 20,6.75 20,10.5 C20,12.8325623 17.8236613,16.03566 13.470984,20.1092932 C12.9154018,20.6292577 12.0585054,20.6508331 11.4774555,20.1594925 C7.15915182,16.5078313 5,13.2880005 5,10.5 Z M12.5,12 C13.8807119,12 15,10.8807119 15,9.5 C15,8.11928813 13.8807119,7 12.5,7 C11.1192881,7 10,8.11928813 10,9.5 C10,10.8807119 11.1192881,12 12.5,12 Z" fill="#000000" fill-rule="nonzero" />
																</g>
															</svg>
														</span>
														<!--end::Svg Icon-->{{$guard->address}}</a>
														<a  class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
														<!--begin::Svg Icon | path: icons/duotone/Communication/Mail-at.svg-->
														<span class="svg-icon svg-icon-4 me-1">
															<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																<path d="M11.575,21.2 C6.175,21.2 2.85,17.4 2.85,12.575 C2.85,6.875 7.375,3.05 12.525,3.05 C17.45,3.05 21.125,6.075 21.125,10.85 C21.125,15.2 18.825,16.925 16.525,16.925 C15.4,16.925 14.475,16.4 14.075,15.65 C13.3,16.4 12.125,16.875 11,16.875 C8.25,16.875 6.85,14.925 6.85,12.575 C6.85,9.55 9.05,7.1 12.275,7.1 C13.2,7.1 13.95,7.35 14.525,7.775 L14.625,7.35 L17,7.35 L15.825,12.85 C15.6,13.95 15.85,14.825 16.925,14.825 C18.25,14.825 19.025,13.725 19.025,10.8 C19.025,6.9 15.95,5.075 12.5,5.075 C8.625,5.075 5.05,7.75 5.05,12.575 C5.05,16.525 7.575,19.1 11.575,19.1 C13.075,19.1 14.625,18.775 15.975,18.075 L16.8,20.1 C15.25,20.8 13.2,21.2 11.575,21.2 Z M11.4,14.525 C12.05,14.525 12.7,14.35 13.225,13.825 L14.025,10.125 C13.575,9.65 12.925,9.425 12.3,9.425 C10.65,9.425 9.45,10.7 9.45,12.375 C9.45,13.675 10.075,14.525 11.4,14.525 Z" fill="#000000" />
															</svg>
														</span>
														<!--end::Svg Icon-->{{$guard->email}}</a>
													</div>
													<!--end::Info-->
												</div>
												<!--end::User-->
												<!--begin::Actions-->
												<div class="d-flex my-4">
													
													<!-- <a  class="btn btn-sm btn-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_offer_a_deal">Hire Me</a> -->
													<!--begin::Menu-->
													<div class="me-0">
														<!-- <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
															<i class="bi bi-three-dots fs-3"></i>
														</button> -->
														<!--begin::Menu 3-->
														<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3" data-kt-menu="true">
															<!--begin::Heading-->
															<div class="menu-item px-3">
																<div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Payments</div>
															</div>
															<!--end::Heading-->
															<!--begin::Menu item-->
															<div class="menu-item px-3">
																<a  class="menu-link px-3">Create Invoice</a>
															</div>
															<!--end::Menu item-->
															<!--begin::Menu item-->
															<div class="menu-item px-3">
																<a  class="menu-link flex-stack px-3">Create Payment
																</a>
															</div>
															<!--end::Menu item-->
															<!--begin::Menu item-->
															<div class="menu-item px-3">
																<a  class="menu-link px-3">Generate Bill</a>
															</div>
															<!--end::Menu item-->
															<!--begin::Menu item-->
															<div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="left-start" data-kt-menu-flip="center, top">
																<a  class="menu-link px-3">
																	<span class="menu-title">Subscription</span>
																	<span class="menu-arrow"></span>
																</a>
																<!--begin::Menu sub-->
																<div class="menu-sub menu-sub-dropdown w-175px py-4">
																	<!--begin::Menu item-->
																	<div class="menu-item px-3">
																		<a  class="menu-link px-3">Plans</a>
																	</div>
																	<!--end::Menu item-->
																	<!--begin::Menu item-->
																	<div class="menu-item px-3">
																		<a  class="menu-link px-3">Billing</a>
																	</div>
																	<!--end::Menu item-->
																	<!--begin::Menu item-->
																	<div class="menu-item px-3">
																		<a  class="menu-link px-3">Statements</a>
																	</div>
																	<!--end::Menu item-->
																	<!--begin::Menu separator-->
																	<div class="separator my-2"></div>
																	<!--end::Menu separator-->
																	<!--begin::Menu item-->
																	<div class="menu-item px-3">
																		<div class="menu-content px-3">
																			<!--begin::Switch-->
																			<label class="form-check form-switch form-check-custom form-check-solid">
																				<!--begin::Input-->
																				<input class="form-check-input w-30px h-20px" type="checkbox" value="1" checked="checked" name="notifications" />
																				<!--end::Input-->
																				<!--end::Label-->
																				<span class="form-check-label text-muted fs-6">Recuring</span>
																				<!--end::Label-->
																			</label>
																			<!--end::Switch-->
																		</div>
																	</div>
																	<!--end::Menu item-->
																</div>
																<!--end::Menu sub-->
															</div>
															<!--end::Menu item-->
															<!--begin::Menu item-->
															<div class="menu-item px-3 my-1">
																<a  class="menu-link px-3">Settings</a>
															</div>
															<!--end::Menu item-->
														</div>
														<!--end::Menu 3-->
													</div>
													<!--end::Menu-->
												</div>
												<!--end::Actions-->
											</div>
											<!--end::Title-->
											<!--begin::Stats-->
											
<!-- remove stats -->
	<div class="d-flex flex-wrap flex-stack">
												<!--begin::Wrapper-->
												<div class="d-flex flex-column flex-grow-1 pe-8">
													<!--begin::Stats-->
													<div class="d-flex flex-wrap">
															<!--begin::Stat-->
														<div class=" min-w-125px py-3 px-4 me-6 mb-3">
															@if(session()->get('userType')=='admin')
														
															<!--begin::Number-->
															<div class="d-flex align-items-center">
																<!--begin::Svg Icon | path: icons/duotone/Navigation/Arrow-up.svg-->
																<span class="svg-icon svg-icon-3 svg-icon-success me-2">
																	<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																		<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																			<polygon points="0 0 24 0 24 24 0 24" />
																			<rect fill="#000000" opacity="0.5" x="11" y="5" width="2" height="14" rx="1" />
																			<path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero" />
																		</g>
																	</svg>
																</span>
																<!--end::Svg Icon-->
																<div class="fs-2 fw-bolder" data-kt-countup="true" data-kt-countup-value="0" data-kt-countup-prefix="$">0</div>
															</div>
															<!--end::Number-->
															<!--begin::Label-->
															<div class="fw-bold fs-6 text-gray-400">Earnings</div>
															<!--end::Label-->
															@endif

														</div>
														<!--end::Stat-->
														<!--begin::Stat-->
														<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
															<!--begin::Number-->
															<div class="d-flex align-items-center">
																<!--begin::Svg Icon | path: icons/duotone/Navigation/Arrow-down.svg-->
															
																<!--end::Svg Icon-->
																<div class="fs-2 fw-bolder" data-kt-countup="true" data-kt-countup-value="{{$shifts}}">0</div>
															</div>
															<!--end::Number-->
															<!--begin::Label-->
															<div class="fw-bold fs-6 text-gray-400">All Time Shifts</div>
															<!--end::Label-->
														</div>
														<!--end::Stat-->
														<!--begin::Stat-->
														<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
															<!--begin::Number-->
																		<div class="d-flex align-items-center">
																<!--begin::Svg Icon | path: icons/duotone/Navigation/Arrow-down.svg-->
															
																<!--end::Svg Icon-->
																<div class="fs-2 fw-bolder" data-kt-countup="true" data-kt-countup-value="{{round($total_hours)}}">0</div>
															</div>
															<!--end::Number-->
															<!--begin::Label-->
															<div class="fw-bold fs-6 text-gray-400">All Time Hours</div>
															<!--end::Label-->
														</div>
														<!--end::Stat-->
													</div>
													<!--end::Stats-->
												</div>
												<!--end::Wrapper-->
												<!--begin::Progress-->
												
												<div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
													{{-- <div class="rating">    --}}
												


													<?php 
													$percent=0;
													if($guard->name!='' && $guard->coordinates!='' && $guard->address!='')
														{	
															$percent=$percent+20;
														}
														
														if($guard->security_license_number!= ''|| $guard->driver_license_number!='' )
														{	
															$percent=$percent+10;
														}
														
														
														if($guard->visa_number!='')
														{	
															$percent=$percent+10;
														}
														if($guard->security_license_file!= ''|| $guard->driver_license_file!='' ){
															$percent=$percent+10;

														}

														if($guard->payroll_abn_number !='' && $guard->payroll_bank_name !=''  && $guard->payroll_bank_account_number !='')
														{	
															$percent=$percent+10;
														}
														
														if($guard->payrates_id !='' && $guard->payrates_id!=null)
														{	
															$percent=$percent+20;
														}
														
														if($guard->specific_customers_id!='' && $guard->specific_customers_id!= null)
														{	
															$percent=$percent+20;
														}
															if ($percent > 100) {
															$percent == 100;
														}
														
														?>
														@if($percent<=50)
														<div class="d-flex justify-content-between w-100 mt-auto mb-2">										
															<span class="fw-bold fs-6 text-gray-400">Profile Completion</span>
															<span class="fw-bolder fs-6">{{$percent}}%</span>
														</div>
	
														<div class="h-5px mx-3 w-100 bg-light mb-3">
															<div class="bg-danger rounded h-5px" role="progressbar" style="width: {{$percent}}%;" aria-valuenow="{{$percent}}" aria-valuemin="0" aria-valuemax="100"></div>
														</div>
															@else
															<div class="d-flex justify-content-between w-100 mt-auto mb-2">										
																<span class="fw-bold fs-6 text-gray-400">Profile Completion</span>
																<span class="fw-bolder fs-6">{{$percent}}%</span>
	
															</div>
															<div class="h-5px mx-3 w-100 bg-light mb-3">

																<div class="bg-success rounded h-5px" role="progressbar" style="width: {{$percent}}%;" aria-valuenow="{{$percent}}" aria-valuemin="0" aria-valuemax="100"></div>
															</div>
																	
														@endif
												
												</div>
												<!--end::Progress-->
											</div>

											<!--end::Stats-->
										</div>
										<!--end::Info-->
									</div>
									<!--end::Details-->
									<!--begin::Navs-->
									<div class="d-flex overflow-auto h-55px">
										<!-- <ul class="nav nav-tabs nav-stretch  nav-fill nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder flex-nowrap">
											<li class="nav-item">
												<a class="nav-link text-active-primary me-6 active nav-item nav-link active" id="personal_information-tab" data-toggle="tab" href="#personal_information" role="tab" aria-controls="personal_information" aria-selected="true">Personal Profile Overview</a>
											</li>
											
										</ul> -->
										<ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6 nav-stretch  nav-fill nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder flex-nowrap">
										    <li class="nav-item">
										        <a class="nav-link active text-active-primary me-6" data-bs-toggle="tab" href="#personal_information">Personal Information</a>
										    </li>
											@if(session()->get('userType')=='admin' || session()->get('userType')=='customer')

										    <li class="nav-item">
										        <a class="nav-link text-active-primary me-6" data-bs-toggle="tab" href="#internal_id">Internal ID</a>
										    </li>
											@endif


										     <li class="nav-item">
										        <a class="nav-link text-active-primary me-6" data-bs-toggle="tab" href="#documents">Documents</a>
										    </li>
											@if(session()->get('userType')=='admin')

											<li class="nav-item">
										        <a class="nav-link text-active-primary me-6" onclick="get_avalibilty()" data-bs-toggle="tab" href="#avalibility">Availability</a>
										    </li>
										    @endif
											@if(session()->get('userType')=='admin')
										     <li class="nav-item">
										        <a class="nav-link text-active-primary me-6" data-bs-toggle="tab" href="#payroll">PayRoll</a>
										    </li>

										     <li class="nav-item">
										        <a class="nav-link text-active-primary me-6" data-bs-toggle="tab" href="#payrates">Pay Rates</a>
										    </li>
										     <li class="nav-item">
										        <a class="nav-link text-active-primary me-6" data-bs-toggle="tab" href="#sites_trained">Sites Trained</a>
										    </li>
										     <li class="nav-item">
										        <a class="nav-link text-active-primary me-6" data-bs-toggle="tab" href="#sites_blocked">Sites Blocked</a>
										    </li>
											<li class="nav-item">
										        <a class="nav-link text-active-primary me-6" onclick="get_specific_guard_customer()" data-bs-toggle="tab" href="#customer_tab">Customers</a>
										    </li>
										     <li class="nav-item">
										        <a class="nav-link text-active-primary me-6" data-bs-toggle="tab" href="#password">Change Password</a>
										    </li>
											@endif
										</ul>
									</div>
									<!--begin::Navs-->
								</div>
							</div>
							<!--end::Navbar-->
							<!--begin::details View-->
							<!-- begin::tab by hhh -->
							    <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">

									<div class="card mb-5 mb-xl-10 tab-pane fade show active"  id="personal_information" role="tabpanel" aria-labelledby="personal_information-tab">
										<!--begin::Card header-->
										<div class="card-header cursor-pointer">
											<!--begin::Card title-->
											<div class="card-title m-0">
												<h3 class="fw-bolder m-0">Personal Information</h3>
											</div>
											<!--end::Card title-->
											<!--begin::Action-->
											@if(session()->get('userType')=='admin')
											<a href="{{url('edit_guard') . '/' . $guard->id}}" class="btn btn-primary align-self-center">Edit Profile</a>
											@endif
											<!--end::Action-->
										</div>
										<!--begin::Card header-->
										<!--begin::Card body-->
										<div class="card-body p-9">
											<!--begin::Row-->
											<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">Full Name</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8">
													<span class="fw-bolder fs-6 text-dark">{{$guard->name}}</span>
												</div>
												<!--end::Col-->
											</div>
											<!--end::Row-->
											<!--begin::Input group-->
											<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">Email</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8 fv-row">
													<span class="fw-bold fs-6">{{$guard->email}}</span>
												</div>
												<!--end::Col-->
											</div>
											<!--end::Input group-->
											<!--begin::Input group-->
											<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">Contact Phone
												<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Phone number must be active"></i></label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8 d-flex align-items-center">
													<span class="fw-bolder fs-6 me-2">{{$guard->phone}}</span>
													<span class="badge badge-success"></span>
												</div>
												<!--end::Col-->

											</div>
											<!--end::Input group-->

												<!--begin::Input group-->
											<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">{{config('custom.guard')}} Type</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8 d-flex align-items-center">
													@if($guard->guard_type == null )
													<span class="fw-bolder fs-6 me-2">Not Available</span>
													@else
													<span class="fw-bolder fs-6 me-2">{{$guard->guard_type}}</span>

													@endif
													<span class="badge badge-success"></span>
												</div>
												<!--end::Col-->
												
											</div>
											<!--end::Input group-->


												<!--begin::Input group-->
											<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">Date of Birth</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8 d-flex align-items-center">
													<span class="fw-bolder fs-6 me-2">{{$guard->dob}}</span>
													<span class="badge badge-success"></span>
												</div>
												<!--end::Col-->
												
											</div>
											<!--end::Input group-->


												<!--begin::Input group-->
											<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">Gender</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8 d-flex align-items-center">
													<span class="fw-bolder fs-6 me-2">{{ucfirst($guard->gender)}}</span>
													<span class="badge badge-success"></span>
												</div>
												<!--end::Col-->
												
											</div>
											<!--end::Input group-->

												<!--begin::Input group-->
											<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">Emergency Contact Name</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8 d-flex align-items-center">
													<span class="fw-bolder fs-6 me-2">{{ucfirst($guard->emergency_contact_name)}}</span>
													<span class="badge badge-success"></span>
												</div>
												<!--end::Col-->
												
											</div>
											<!--end::Input group-->
													<!--begin::Input group-->
											<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">Emergency Contact Phone</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8 d-flex align-items-center">
													<span class="fw-bolder fs-6 me-2">{{$guard->emergency_contact_phone}}</span>
													<span class="badge badge-success"></span>
												</div>
												<!--end::Col-->
												
											</div>

													<!--begin::Input group-->
											<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">City</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8 d-flex align-items-center">
													<span class="fw-bolder fs-6 me-2">{{ucfirst($guard->city)}}</span>
													<span class="badge badge-success"></span>
												</div>
												<!--end::Col-->
												
											</div>
											<!--end::Input group-->


												<!--begin::Input group-->
											<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">Address</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8 d-flex align-items-center">
													<span class="fw-bolder fs-6 me-2">{{$guard->address}}</span>
													<span class="badge badge-success"></span>
												</div>
												<!--end::Col-->
												
											</div>
											<!--end::Input group-->


												<!--begin::Input group-->
											<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">Postal Code</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8 d-flex align-items-center">
													<span class="fw-bolder fs-6 me-2">{{$guard->postal_code}}</span>
													<span class="badge badge-success"></span>
												</div>
												<!--end::Col-->
												
											</div>
											<!--end::Input group-->


											<!--end::Input group-->
											<!--begin::Input group-->
										
											<!--end::Input group-->
											<!--begin::Input group-->
											<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">State</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8">
													<span class="fw-bolder fs-6 text-dark">{{$guard->state}}</span>
												</div>
												<!--end::Col-->
											</div>
											<!--end::Input group-->
											<!--begin::Input group-->
								
											<!--end::Input group-->
											<!--begin::Input group-->
					
											<!--end::Input group-->
											<!--begin::Notice-->
											
											<!--end::Notice-->
										</div>
										<!--end::Card body-->
									</div>
									<!-- begin::tabs by hussain -->

									<div class="card mb-5 mb-xl-10 tab-pane fade"  id="internal_id" role="tabpanel" aria-labelledby="internal_id-tab">
										<!--begin::Card header-->
										
										<div class="card-header cursor-pointer">
											<!--begin::Card title-->
											<div class="card-title m-0">
												<h3 class="fw-bolder m-0">Internal ID</h3>
											</div>
											<!--end::Card title-->
											<!--begin::Action-->
											@if(session()->get('userType')=='admin')
											<a href="{{url('edit_guard') . '/' . $guard->id}}" class="btn btn-primary align-self-center">Edit Profile</a>
											@endif
											<!--end::Action-->
										</div>
										<!--begin::Card header-->
										<!--begin::Card body-->
										<?php $counter = 0; ?>
										@foreach($internal_ids as $id)

										<div class="card-body" style="padding: 1rem 2.25rem !important;">
											<!--begin::Row-->
											<div class="row mb-2">
												<!--begin::Label-->
												@foreach($customers as $customer)
												<label class="col-lg-4 fw-bold text-muted">Customer Name</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8">
													<span class="fw-bolder fs-6 text-dark">{{$customer->name}}</span>
												</div>
												@endforeach
												<!--end::Col-->
											</div>
											<!--end::Row-->
											<!--begin::Input group-->
											@if($counter == 0)

											<div class="row mb-2">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">Internal ID</label>
												<!--end::Label-->
												<!--begin::Col-->
												
												<div class="col-lg-8 fv-row">
													<span class="fw-bold fs-6">{{$id->internal_id}}</span>
												</div>
												<!--end::Col-->
											</div>
											@endif

											<!--end::Input group-->
											<!--begin::Input group-->
											@if($counter > 0 || $id->external_id != '')
											<div class="row mb-2">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">External ID
												<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="External Id provided by customers to any specific guard"></i></label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8 d-flex align-items-center">
													<span class="fw-bolder fs-6 me-2">{{$id->external_id}}</span>
													<span class="badge badge-success"></span>
												</div>
												<!--end::Col-->
											</div>
												@endif

											
											<!--end::Notice-->
										</div>
										<!--end::Card body-->
										<?php $counter++; ?>
									@endforeach

									</div>	

									<!-- begin documents -->

										<div class="card mb-5 mb-xl-10 tab-pane fade"  id="documents" role="tabpanel" aria-labelledby="internal_id-tab">
										<!--begin::Card header-->
									
										<div class="card-header cursor-pointer">
											<!--begin::Card title-->
											<div class="card-title m-0">
												<h3 class="fw-bolder m-0">Documents </h3>
											</div>
											<!--end::Card title-->
											<!--begin::Action-->
											@if(session()->get('userType')=='admin')
											<a href="{{url('edit_guard') . '/' . $guard->id}}" class="btn btn-primary align-self-center">Edit Profile</a>
											@endif
											<!--end::Action-->
										</div>
										<!--begin::Card header-->
										<!--begin::Card body-->
										<div class="card-body p-9">
											<!--begin::Row-->
											@if(session()->get('userType')=='admin' || session()->get('userType')=='customer')
												@if($guard->birthcertificate_number == null || (session()->get('userType')=='customer' && isset($guard->customer_docs['birthcertificate_customer']) && $guard->customer_docs['birthcertificate_customer'] == false))
												<div style="display: none">

												<div class="row mb-7 margin_top_doc" >
													
												@else
												<div>
												<div class="row mb-7 margin_top_doc">
													
												@endif
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted ">Document </label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8">
													<span class="fw-bolder fs-6 text-dark">Birth Certificate</span>
												</div>
												<!--end::Col-->
											</div>

											<!--end::Row-->
												<div class="row mb-7 ">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted"> NUMBER
											</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8 d-flex align-items-center">
													<span class="fw-bolder fs-6 me-2">
																@if($guard->birthcertificate_number == null)
																				N/A
																			@else
																					{{$guard->birthcertificate_number}}
																			@endif
													</span>
													<span class="badge badge-success"></span>
												</div>
												<!--end::Col-->
											</div>
											<!--end::Row-->
												<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">VALID TILL
												</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8 d-flex align-items-center">
													<span class="fw-bolder fs-6 me-2">
																@if($guard->birthcertificate_expiration == null)
																				N/A
																			@else
																					{{$guard->birthcertificate_expiration}}
																			@endif
													</span>
													<span class="badge badge-success"></span>
												</div>
												<!--end::Col-->
											</div>
											<!--begin::Input group-->
											<div class="row ">
															<div class="col-12 col-sm-12 col-xl">
																<div class="card h-100">
																	<!--begin::Card body-->
																	<div class="card-body d-flex justify-content-center text-center flex-column p-8">
																		<!--begin::Name-->
																		@if($guard->birthcertificate_file == null)
																		<a href="{{url('edit_guard'.'/' .$guard->id)}}" class="text-gray-800 text-hover-primary d-flex flex-column">
																			<!--begin::Image-->
																			<div class="symbol symbol-60px mb-6">
																				<img src="{{asset('')}}media/svg/files/no-img.png" alt="">
																			</div>
																			<!--end::Image-->
																			<!--begin::Title-->
																			<div class="fs-5 fw-bolder mb-2">Birth Certificate</div>
																			<!--end::Title-->
																		</a>

																		@else
																		<a href="{{asset('../../asset_uploads').'/'.$guard->birthcertificate_file}}" class="text-gray-800 text-hover-primary d-flex flex-column">
																			<!--begin::Image-->
																			<div class="symbol symbol-60px mb-6">
																				<img src="{{asset('')}}media/svg/files/doc.svg" alt="">
																			</div>
																			<!--end::Image-->
																			<!--begin::Title-->
																			<div class="fs-5 fw-bolder mb-2">Birth Certificate</div>
																			<!--end::Title-->
																		</a>
																		@endif
																		<!--end::Name-->
																		<!--begin::Description-->
																		<div class="fs-7 fw-bold text-gray-400 mt-auto">
																			@if($guard->birthcertificate_expiration == null)
																				N/A
																			@else
																					{{$guard->birthcertificate_expiration}}
																			@endif
																		</div>
																		<!--end::Description-->
																	</div>
																	<!--end::Card body-->
																</div>
																<!--end::Card-->
															</div>
											</div>
											<!--end::Input group-->
											<!--begin::Input group-->
										
											</div>
											@endif
											@if(session()->get('userType')=='admin' || session()->get('userType')=='customer')

													@if($guard->passport_number == null || (session()->get('userType')=='customer' && isset($guard->customer_docs['passport_customer']) && $guard->customer_docs['passport_customer'] == false))
													<div style="display: none">
													<div class="row mb-7 margin_top_doc" style="display: none">
														
													@else
													<div>
													<div class="row mb-7 margin_top_doc">
														
													@endif
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">Document </label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8">
													<span class="fw-bolder fs-6 text-dark">Passport</span>
												</div>
												<!--end::Col-->
											</div>

											<!--end::Row-->
												<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted"> NUMBER
											</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8 d-flex align-items-center">
													<span class="fw-bolder fs-6 me-2">
																@if($guard->passport_number == null)
																				N/A
																			@else
																					{{$guard->passport_number}}
																			@endif
													</span>
													<span class="badge badge-success"></span>
												</div>
												<!--end::Col-->
											</div>
											<!--end::Row-->
												<div class="row mb-7 ">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">VALID TILL
												</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8 d-flex align-items-center">
													<span class="fw-bolder fs-6 me-2">
																@if($guard->passport_expiration == null)
																				N/A
																			@else
																					{{$guard->passport_expiration}}
																			@endif
													</span>
													<span class="badge badge-success"></span>
												</div>
												<!--end::Col-->
											</div>
											<!--begin::Input group-->
											<div class="row ">
															<div class="col-12 col-sm-12 col-xl">
																<div class="card h-100">
																	<!--begin::Card body-->
																	<div class="card-body d-flex justify-content-center text-center flex-column p-8">
																		<!--begin::Name-->
																		@if($guard->passport_file == null)
																		<a href="{{url('edit_guard'.'/' .$guard->id)}}" class="text-gray-800 text-hover-primary d-flex flex-column">
																			<!--begin::Image-->
																			<div class="symbol symbol-60px mb-6">
																				<img src="{{asset('')}}media/svg/files/no-img.png" alt="">
																			</div>
																			<!--end::Image-->
																			<!--begin::Title-->
																			<div class="fs-5 fw-bolder mb-2">Passport</div>
																			<!--end::Title-->
																		</a>

																		@else
																		<a href="{{asset('../../asset_uploads').'/'.$guard->passport_file}}" class="text-gray-800 text-hover-primary d-flex flex-column">
																			<!--begin::Image-->
																			<div class="symbol symbol-60px mb-6">
																				<img src="{{asset('')}}media/svg/files/doc.svg" alt="">
																			</div>
																			<!--end::Image-->
																			<!--begin::Title-->
																			<div class="fs-5 fw-bolder mb-2">Passport</div>
																			<!--end::Title-->
																		</a>
																		@endif
																		<!--end::Name-->
																		<!--begin::Description-->
																		<div class="fs-7 fw-bold text-gray-400 mt-auto">
																			@if($guard->passport_expiration == null)
																				N/A
																			@else
																					{{$guard->passport_expiration}}
																			@endif
																		</div>
																		<!--end::Description-->
																	</div>
																	<!--end::Card body-->
																</div>
																<!--end::Card-->
															</div>
											</div>
											<!--end::Input group-->
											<!--begin::Input group-->
										
											</div>
												@endif
											@if(session()->get('userType')=='admin' || session()->get('userType')=='customer')

													@if($guard->medicare_number == null || (session()->get('userType')=='customer' && isset($guard->customer_docs['medicare_customer']) && $guard->customer_docs['medicare_customer'] == false))
													<div style="display: none">
													<div class="row mb-7 margin_top_doc" style="display: none">
														
													@else
												<div>

													<div class="row mb-7 margin_top_doc">
														
													@endif
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">Document </label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8">
													<span class="fw-bolder fs-6 text-dark">Medicare</span>
												</div>
												<!--end::Col-->
											</div>

											<!--end::Row-->
												<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">Number</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8 d-flex align-items-center">
													<span class="fw-bolder fs-6 me-2">
																@if($guard->medicare_number == null)
																				N/A
																			@else
																					{{$guard->medicare_number}}
																			@endif
													</span>
													<span class="badge badge-success"></span>
												</div>
												<!--end::Col-->
											</div>
											<!--end::Row-->
												<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">VALID TILL
												</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8 d-flex align-items-center">
													<span class="fw-bolder fs-6 me-2">
																@if($guard->medicare_expiration == null)
																				N/A
																			@else
																					{{$guard->medicare_expiration}}
																			@endif
													</span>
													<span class="badge badge-success"></span>
												</div>
												<!--end::Col-->
											</div>
											<!--begin::Input group-->
											<div class="row ">
															<div class="col-12 col-sm-12 col-xl">
																<div class="card h-100">
																	<!--begin::Card body-->
																	<div class="card-body d-flex justify-content-center text-center flex-column p-8">
																		<!--begin::Name-->
																		@if($guard->medicare_file == null)
																		<a href="{{url('edit_guard'.'/' .$guard->id)}}" class="text-gray-800 text-hover-primary d-flex flex-column">
																			<!--begin::Image-->
																			<div class="symbol symbol-60px mb-6">
																				<img src="{{asset('')}}media/svg/files/no-img.png" alt="">
																			</div>
																			<!--end::Image-->
																			<!--begin::Title-->
																			<div class="fs-5 fw-bolder mb-2">Medicare</div>
																			<!--end::Title-->
																		</a>

																		@else
																		<a href="{{asset('../../asset_uploads').'/'.$guard->medicare_file}}" class="text-gray-800 text-hover-primary d-flex flex-column">
																			<!--begin::Image-->
																			<div class="symbol symbol-60px mb-6">
																				<img src="{{asset('')}}media/svg/files/doc.svg" alt="">
																			</div>
																			<!--end::Image-->
																			<!--begin::Title-->
																			<div class="fs-5 fw-bolder mb-2">Medicare</div>
																			<!--end::Title-->
																		</a>
																		@endif
																		<!--end::Name-->
																		<!--begin::Description-->
																		<div class="fs-7 fw-bold text-gray-400 mt-auto">
																			@if($guard->medicare_expiration == null)
																				N/A
																			@else
																					{{$guard->medicare_expiration}}
																			@endif
																		</div>
																		<!--end::Description-->
																	</div>
																	<!--end::Card body-->
																</div>
																<!--end::Card-->
															</div>
											</div>
											<!--end::Input group-->
											<!--begin::Input group-->
										
											</div>
@endif
											@if(session()->get('userType')=='admin' || session()->get('userType')=='customer')


													@if($guard->visa_number == null || (session()->get('userType')=='customer' && isset($guard->customer_docs['visa_customer']) && $guard->customer_docs['visa_customer'] == false))
													<div style="display: none">

													<div class="row mb-7 margin_top_doc" style="display: none">
														
													@else
												<div>

													<div class="row mb-7 margin_top_doc">
														
													@endif
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">Document </label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8">
													<span class="fw-bolder fs-6 text-dark">Visa</span>
												</div>
												<!--end::Col-->
											</div>

											<!--end::Row-->
												<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">Number</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8 d-flex align-items-center">
													<span class="fw-bolder fs-6 me-2">
																@if($guard->visa_number == null)
																				N/A
																			@else
																					{{$guard->visa_number}}
																			@endif
													</span>
													<span class="badge badge-success"></span>
												</div>
												<!--end::Col-->
											</div>
											<!--end::Row-->
												<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">VALID TILL
												</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8 d-flex align-items-center">
													<span class="fw-bolder fs-6 me-2">
																@if($guard->visa_expiration == null)
																				N/A
																			@else
																					{{$guard->visa_expiration}}
																			@endif
													</span>
													<span class="badge badge-success"></span>
												</div>
												<!--end::Col-->
											</div>
											<!--begin::Input group-->
											<div class="row ">
															<div class="col-12 col-sm-12 col-xl">
																<div class="card h-100">
																	<!--begin::Card body-->
																	<div class="card-body d-flex justify-content-center text-center flex-column p-8">
																		<!--begin::Name-->
																		@if($guard->visa_file == null)
																		<a href="{{url('edit_guard'.'/' .$guard->id)}}" class="text-gray-800 text-hover-primary d-flex flex-column">
																			<!--begin::Image-->
																			<div class="symbol symbol-60px mb-6">
																				<img src="{{asset('')}}media/svg/files/no-img.png" alt="">
																			</div>
																			<!--end::Image-->
																			<!--begin::Title-->
																			<div class="fs-5 fw-bolder mb-2">Visa</div>
																			<!--end::Title-->
																		</a>

																		@else
																		<a href="{{asset('../../asset_uploads').'/'.$guard->visa_file}}" class="text-gray-800 text-hover-primary d-flex flex-column">
																			<!--begin::Image-->
																			<div class="symbol symbol-60px mb-6">
																				<img src="{{asset('')}}media/svg/files/doc.svg" alt="">
																			</div>
																			<!--end::Image-->
																			<!--begin::Title-->
																			<div class="fs-5 fw-bolder mb-2">Visa</div>
																			<!--end::Title-->
																		</a>
																		@endif
																		<!--end::Name-->
																		<!--begin::Description-->
																		<div class="fs-7 fw-bold text-gray-400 mt-auto">
																			@if($guard->visa_expiration == null)
																				N/A
																			@else
																					{{$guard->visa_expiration}}
																			@endif
																		</div>
																		<!--end::Description-->
																	</div>
																	<!--end::Card body-->
																</div>
																<!--end::Card-->
															</div>
											</div>
											<!--end::Input group-->
											<!--begin::Input group-->
										
											</div>
@endif
											@if(session()->get('userType')=='admin' || session()->get('userType')=='customer')
													@if($guard->citizenship_number == null || (session()->get('userType')=='customer' && isset($guard->customer_docs['citizenship_customer']) && $guard->customer_docs['citizenship_customer'] == false))
													<div style="display: none">


													<div class="row mb-7 margin_top_doc" style="display: none">
														
													@else
												<div>

													<div class="row mb-7 margin_top_doc">
														
													@endif												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">Document </label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8">
													<span class="fw-bolder fs-6 text-dark">Citizenship </span>
												</div>
												<!--end::Col-->
											</div>

											<!--end::Row-->
												<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">Number</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8 d-flex align-items-center">
													<span class="fw-bolder fs-6 me-2">
																@if($guard->citizenship_number == null)
																				N/A
																			@else
																					{{$guard->citizenship_number}}
																			@endif
													</span>
													<span class="badge badge-success"></span>
												</div>
												<!--end::Col-->
											</div>
											<!--end::Row-->
												<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">VALID TILL
												</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8 d-flex align-items-center">
													<span class="fw-bolder fs-6 me-2">
																@if($guard->citizenship_expiration == null)
																				N/A
																			@else
																					{{$guard->citizenship_expiration}}
																			@endif
													</span>
													<span class="badge badge-success"></span>
												</div>
												<!--end::Col-->
											</div>
											<!--begin::Input group-->
											<div class="row ">
															<div class="col-12 col-sm-12 col-xl">
																<div class="card h-100">
																	<!--begin::Card body-->
																	<div class="card-body d-flex justify-content-center text-center flex-column p-8">
																		<!--begin::Name-->
																		@if($guard->citizenship_file == null)
																		<a href="{{url('edit_guard'.'/' .$guard->id)}}" class="text-gray-800 text-hover-primary d-flex flex-column">
																			<!--begin::Image-->
																			<div class="symbol symbol-60px mb-6">
																				<img src="{{asset('')}}media/svg/files/no-img.png" alt="">
																			</div>
																			<!--end::Image-->
																			<!--begin::Title-->
																			<div class="fs-5 fw-bolder mb-2">Citizenship</div>
																			<!--end::Title-->
																		</a>

																		@else
																		<a href="{{asset('../../asset_uploads').'/'.$guard->citizenship_file}}" class="text-gray-800 text-hover-primary d-flex flex-column">
																			<!--begin::Image-->
																			<div class="symbol symbol-60px mb-6">
																				<img src="{{asset('')}}media/svg/files/doc.svg" alt="">
																			</div>
																			<!--end::Image-->
																			<!--begin::Title-->
																			<div class="fs-5 fw-bolder mb-2">Citizenship</div>
																			<!--end::Title-->
																		</a>
																		@endif
																		<!--end::Name-->
																		<!--begin::Description-->
																		<div class="fs-7 fw-bold text-gray-400 mt-auto">
																			@if($guard->citizenship_expiration == null)
																				N/A
																			@else
																					{{$guard->citizenship_expiration}}
																			@endif
																		</div>
																		<!--end::Description-->
																	</div>
																	<!--end::Card body-->
																</div>
																<!--end::Card-->
															</div>
											</div>
											<!--end::Input group-->
											<!--begin::Input group-->
										
											</div>

												@endif
											
													@if($guard->security_license_number == null || (session()->get('userType')=='customer' && isset($guard->customer_docs['securityLicense_customer']) && $guard->customer_docs['securityLicense_customer'] == false))
													<div style="display: none">

													<div class="row mb-7 margin_top_doc" style="display: none">
														
													@else
													<div>

													<div class="row mb-7 margin_top_doc">
														
													@endif													<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">Document </label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8">
													<span class="fw-bolder fs-6 text-dark">Security License</span>
												</div>
												<!--end::Col-->
											</div>

											<!--end::Row-->
												<div class="row mb-7 ">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">Number</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8 d-flex align-items-center">
													<span class="fw-bolder fs-6 me-2">
																@if($guard->security_license_number == null)
																				N/A
																			@else
																					{{$guard->security_license_number}}
																			@endif
													</span>
													<span class="badge badge-success"></span>
												</div>
												<!--end::Col-->
											</div>
											<!--end::Row-->
												<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">VALID TILL
												</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8 d-flex align-items-center">
													<span class="fw-bolder fs-6 me-2">
																@if($guard->security_license_expiration == null)
																				N/A
																			@else
																					{{$guard->security_license_expiration}}
																			@endif
													</span>
													<span class="badge badge-success"></span>
												</div>
												<!--end::Col-->
											</div>
											<!--begin::Input group-->
											<div class="row ">
															<div class="col-12 col-sm-12 col-xl">
																<div class="card h-100">
																	<!--begin::Card body-->
																	<div class="card-body d-flex justify-content-center text-center flex-column p-8">
																		<!--begin::Name-->
																		@if($guard->security_license_file == null)
																		<a href="{{url('edit_guard'.'/' .$guard->id)}}" class="text-gray-800 text-hover-primary d-flex flex-column">
																			<!--begin::Image-->
																			<div class="symbol symbol-60px mb-6">
																				<img src="{{asset('')}}media/svg/files/no-img.png" alt="">
																			</div>
																			<!--end::Image-->
																			<!--begin::Title-->
																			<div class="fs-5 fw-bolder mb-2">Security License</div>
																			<!--end::Title-->
																		</a>

																		@else
																		<a href="{{asset('../../asset_uploads').'/'.$guard->security_license_file}}" class="text-gray-800 text-hover-primary d-flex flex-column">
																			<!--begin::Image-->
																			<div class="symbol symbol-60px mb-6">
																				<img src="{{asset('')}}media/svg/files/doc.svg" alt="">
																			</div>
																			<!--end::Image-->
																			<!--begin::Title-->
																			<div class="fs-5 fw-bolder mb-2">Security License</div>
																			<!--end::Title-->
																		</a>
																		@endif
																		<!--end::Name-->
																		<!--begin::Description-->
																		<div class="fs-7 fw-bold text-gray-400 mt-auto">
																			@if($guard->security_license_expiration == null)
																				N/A
																			@else
																					{{$guard->security_license_expiration}}
																			@endif
																		</div>
																		<!--end::Description-->
																	</div>
																	<!--end::Card body-->
																</div>
																<!--end::Card-->
															</div>
											</div>
											<!--end::Input group-->
											<!--begin::Input group-->
										
											</div>
											@if(session()->get('userType')=='admin' || session()->get('userType')=='customer')

													@if($guard->driver_license_number == null || (session()->get('userType')=='customer' && isset($guard->customer_docs['driverLicense_customer']) && $guard->customer_docs['driverLicense_customer'] == false))
													<div style="display: none">


													<div class="row mb-7 margin_top_doc" style="display: none">
														
													@else
												<div>

													<div class="row mb-7 margin_top_doc">
														
													@endif												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">Document </label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8">
													<span class="fw-bolder fs-6 text-dark">Driver License</span>
												</div>
												<!--end::Col-->
											</div>

											<!--end::Row-->
												<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">Number</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8 d-flex align-items-center">
													<span class="fw-bolder fs-6 me-2">
																@if($guard->driver_license_number == null)
																				N/A
																			@else
																					{{$guard->driver_license_number}}
																			@endif
													</span>
													<span class="badge badge-success"></span>
												</div>
												<!--end::Col-->
											</div>
											<!--end::Row-->
												<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">VALID TILL
												</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8 d-flex align-items-center">
													<span class="fw-bolder fs-6 me-2">
																@if($guard->driver_license_expiration == null)
																				N/A
																			@else
																					{{$guard->driver_license_expiration}}
																			@endif
													</span>
													<span class="badge badge-success"></span>
												</div>
												<!--end::Col-->
											</div>
											<!--begin::Input group-->
											<div class="row ">
															<div class="col-12 col-sm-12 col-xl">
																<div class="card h-100">
																	<!--begin::Card body-->
																	<div class="card-body d-flex justify-content-center text-center flex-column p-8">
																		<!--begin::Name-->
																		@if($guard->driver_license_file == null)
																		<a href="{{url('edit_guard'.'/' .$guard->id)}}" class="text-gray-800 text-hover-primary d-flex flex-column">
																			<!--begin::Image-->
																			<div class="symbol symbol-60px mb-6">
																				<img src="{{asset('')}}media/svg/files/no-img.png" alt="">
																			</div>
																			<!--end::Image-->
																			<!--begin::Title-->
																			<div class="fs-5 fw-bolder mb-2">Driver License</div>
																			<!--end::Title-->
																		</a>

																		@else
																		<a href="{{asset('../../asset_uploads').'/'.$guard->driver_license_file}}" class="text-gray-800 text-hover-primary d-flex flex-column">
																			<!--begin::Image-->
																			<div class="symbol symbol-60px mb-6">
																				<img src="{{asset('')}}media/svg/files/doc.svg" alt="">
																			</div>
																			<!--end::Image-->
																			<!--begin::Title-->
																			<div class="fs-5 fw-bolder mb-2">Driver License</div>
																			<!--end::Title-->
																		</a>
																		@endif
																		<!--end::Name-->
																		<!--begin::Description-->
																		<div class="fs-7 fw-bold text-gray-400 mt-auto">
																			@if($guard->driver_license_expiration == null)
																				N/A
																			@else
																					{{$guard->driver_license_expiration}}
																			@endif
																		</div>
																		<!--end::Description-->
																	</div>
																	<!--end::Card body-->
																</div>
																<!--end::Card-->
															</div>
											</div>
											<!--end::Input group-->
											<!--begin::Input group-->
										
											</div>

@endif
											@if(session()->get('userType')=='admin' || session()->get('userType')=='customer')
													@if($guard->firstaid_license_number == null || (session()->get('userType')=='customer' && isset($guard->customer_docs['firstaid_customer']) && $guard->customer_docs['firstaid_customer'] == false))
													<div style="display: none">

													<div class="row mb-7 margin_top_doc" style="display: none">
														
													@else
												<div>

													<div class="row mb-7 margin_top_doc">
														
													@endif													<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">Document </label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8">
													<span class="fw-bolder fs-6 text-dark">First-Aid License</span>
												</div>
												<!--end::Col-->
											</div>

											<!--end::Row-->
												<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">Number</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8 d-flex align-items-center">
													<span class="fw-bolder fs-6 me-2">
																@if($guard->firstaid_license_number == null)
																				N/A
																			@else
																					{{$guard->firstaid_license_number}}
																			@endif
													</span>
													<span class="badge badge-success"></span>
												</div>
												<!--end::Col-->
											</div>
											<!--end::Row-->
												<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">VALID TILL
												</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8 d-flex align-items-center">
													<span class="fw-bolder fs-6 me-2">
																@if($guard->firstaid_license_expiration == null)
																				N/A
																			@else
																					{{$guard->firstaid_license_expiration}}
																			@endif
													</span>
													<span class="badge badge-success"></span>
												</div>
												<!--end::Col-->
											</div>
											<!--begin::Input group-->
											<div class="row ">
															<div class="col-12 col-sm-12 col-xl">
																<div class="card h-100">
																	<!--begin::Card body-->
																	<div class="card-body d-flex justify-content-center text-center flex-column p-8">
																		<!--begin::Name-->
																		@if($guard->firstaid_license_file == null)
																		<a href="{{url('edit_guard'.'/' .$guard->id)}}" class="text-gray-800 text-hover-primary d-flex flex-column">
																			<!--begin::Image-->
																			<div class="symbol symbol-60px mb-6">
																				<img src="{{asset('')}}media/svg/files/no-img.png" alt="">
																			</div>
																			<!--end::Image-->
																			<!--begin::Title-->
																			<div class="fs-5 fw-bolder mb-2">First-Aid License </div>
																			<!--end::Title-->
																		</a>

																		@else
																		<a href="{{asset('../../asset_uploads').'/'.$guard->firstaid_license_file}}" class="text-gray-800 text-hover-primary d-flex flex-column">
																			<!--begin::Image-->
																			<div class="symbol symbol-60px mb-6">
																				<img src="{{asset('')}}media/svg/files/doc.svg" alt="">
																			</div>
																			<!--end::Image-->
																			<!--begin::Title-->
																			<div class="fs-5 fw-bolder mb-2">First-Aid License </div>
																			<!--end::Title-->
																		</a>
																		@endif
																		<!--end::Name-->
																		<!--begin::Description-->
																		<div class="fs-7 fw-bold text-gray-400 mt-auto">
																			@if($guard->firstaid_license_expiration == null)
																				N/A
																			@else
																					{{$guard->firstaid_license_expiration}}
																			@endif
																		</div>
																		<!--end::Description-->
																	</div>
																	<!--end::Card body-->
																</div>
																<!--end::Card-->
															</div>
											</div>
											<!--end::Input group-->
											<!--begin::Input group-->
										
											</div>

@endif
											@if(session()->get('userType')=='admin' || session()->get('userType')=='customer')
													@if($guard->firearm_license_number == null || (session()->get('userType')=='customer' && isset($guard->customer_docs['firearm_license_customer']) && $guard->customer_docs['firearm_license_customer'] == false))
													<div style="display: none">

													<div class="row mb-7 margin_top_doc" style="display: none">
														
													@else
												<div>

													<div class="row mb-7 margin_top_doc">
														
													@endif												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">Document </label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8">
													<span class="fw-bolder fs-6 text-dark">Fire-Arm License </span>
												</div>
												<!--end::Col-->
											</div>

											<!--end::Row-->
												<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">Number</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8 d-flex align-items-center">
													<span class="fw-bolder fs-6 me-2">
																@if($guard->firearm_license_number == null)
																				N/A
																			@else
																					{{$guard->firearm_license_number}}
																			@endif
													</span>
													<span class="badge badge-success"></span>
												</div>
												<!--end::Col-->
											</div>
											<!--end::Row-->
												<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">VALID TILL
												</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8 d-flex align-items-center">
													<span class="fw-bolder fs-6 me-2">
																@if($guard->firearm_license_expiration == null)
																				N/A
																			@else
																					{{$guard->firearm_license_expiration}}
																			@endif
													</span>
													<span class="badge badge-success"></span>
												</div>
												<!--end::Col-->
											</div>
											<!--begin::Input group-->
											<div class="row ">
															<div class="col-12 col-sm-12 col-xl">
																<div class="card h-100">
																	<!--begin::Card body-->
																	<div class="card-body d-flex justify-content-center text-center flex-column p-8">
																		<!--begin::Name-->
																		@if($guard->firearm_license_file == null)
																		<a href="{{url('edit_guard'.'/' .$guard->id)}}" class="text-gray-800 text-hover-primary d-flex flex-column">
																			<!--begin::Image-->
																			<div class="symbol symbol-60px mb-6">
																				<img src="{{asset('')}}media/svg/files/no-img.png" alt="">
																			</div>
																			<!--end::Image-->
																			<!--begin::Title-->
																			<div class="fs-5 fw-bolder mb-2">Fire-Arm License</div>
																			<!--end::Title-->
																		</a>

																		@else
																		<a href="{{asset('../../asset_uploads').'/'.$guard->firearm_license_file}}" class="text-gray-800 text-hover-primary d-flex flex-column">
																			<!--begin::Image-->
																			<div class="symbol symbol-60px mb-6">
																				<img src="{{asset('')}}media/svg/files/doc.svg" alt="">
																			</div>
																			<!--end::Image-->
																			<!--begin::Title-->
																			<div class="fs-5 fw-bolder mb-2">Fire-Arm License</div>
																			<!--end::Title-->
																		</a>
																		@endif
																		<!--end::Name-->
																		<!--begin::Description-->
																		<div class="fs-7 fw-bold text-gray-400 mt-auto">
																			@if($guard->firearm_license_expiration == null)
																				N/A
																			@else
																					{{$guard->firearm_license_expiration}}
																			@endif
																		</div>
																		<!--end::Description-->
																	</div>
																	<!--end::Card body-->
																</div>
																<!--end::Card-->
															</div>
											</div>
											<!--end::Input group-->
											<!--begin::Input group-->
										
											</div>
											@endif
											<!--end::Notice-->
										</div>
										<!--end::Card body-->

									</div>	
									<!-- end documents -->

									

									<!-- begin payroll -->
									<div class="card mb-5 mb-xl-10 tab-pane fade " id="payroll" role="tabpanel" aria-labelledby="payroll">
										<!--begin::Card header-->
										<div class="card-header cursor-pointer">
											<!--begin::Card title-->
											<div class="card-title m-0">
												<h3 class="fw-bolder m-0">Payroll Details</h3>
											</div>
											<!--end::Card title-->
											<!--begin::Action-->
											<a href="{{url('edit_guard') . '/' . $guard->id}}" class="btn btn-primary align-self-center">Edit Profile</a>
											<!--end::Action-->
										</div>
										<!--begin::Card header-->
										<!--begin::Card body-->
										<div class="card-body p-9">
											<!--begin::Row-->
											<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">TFN</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8">
													<span class="fw-bolder fs-6 text-dark">{{$guard->payroll_tfn_number}}</span>
												</div>
												<!--end::Col-->
											</div>
											<!--end::Row-->
											<!--begin::Input group-->
											<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">ABN</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8 fv-row">
													@if($guard->payroll_abn_number=='')
													<span class="fw-bolder fs-6 me-2">N/A</span>
													
														@else	
													<span class="fw-bold fs-6">{{$guard->payroll_abn_number}}</span>
@endif

												</div>
												<!--end::Col-->
											</div>
											<!--end::Input group-->
											<!--begin::Input group-->
											<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">Super Annuation</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8 d-flex align-items-center">
													@if($guard->payroll_superannutation_name==''|| $guard->payroll_superannutation_name==null )
													<span class="fw-bolder fs-6 me-2">N/A</span>
													
	@else	
	<span class="fw-bolder fs-6 me-2">{{$guard->payroll_superannutation_name}}</span>
@endif

													<span class="badge badge-success"></span>
												</div>
												<!--end::Col-->

											</div>
											<!--end::Input group-->

												<!--begin::Input group-->
											<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">Bank Name</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8 d-flex align-items-center">
													@if($guard->guard_type == null )
													<span class="fw-bolder fs-6 me-2">Not Available</span>
													@else
													<span class="fw-bolder fs-6 me-2">{{$guard->payroll_bank_name}}</span>

													@endif
													<span class="badge badge-success"></span>
												</div>
												<!--end::Col-->
												
											</div>
											<!--end::Input group-->

											<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">BSB</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8 d-flex align-items-center">
													@if($guard->bsb == null )
													<span class="fw-bolder fs-6 me-2">Not Available</span>
													@else
													<span class="fw-bolder fs-6 me-2">{{$guard->bsb}}</span>

													@endif
													<span class="badge badge-success"></span>
												</div>
												<!--end::Col-->
												
											</div>

												<!--begin::Input group-->
											<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">Account Number</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8 d-flex align-items-center">
													<span class="fw-bolder fs-6 me-2">{{$guard->payroll_bank_account_number}}</span>
													<span class="badge badge-success"></span>
												</div>
												<!--end::Col-->
												
											</div>
						
											<!--end::Notice-->
										</div>
										<!--end::Card body-->
									</div>

									<!-- end payroll -->

									<!-- begin payrates -->


									<!-- end  payrates-->
									

									{{-- avalibity --}}
									<div class="card mb-5 mb-xl-10 tab-pane fade  "  id="avalibility" role="tabpanel" aria-labelledby="payrates">
										<!--begin::Card header-->
												<div class="card-header cursor-pointer">
													<!--begin::Card title-->
													<div class="card-title m-0">
														<h3 class="fw-bolder m-0">Guard Avalibility</h3>
													</div>
													<!--end::Card title-->
													<!--begin::Action-->
													<a href="{{url('edit_guard') . '/' . $guard->id}}" class="btn btn-primary align-self-center">Edit Profile</a>
													<!--end::Action-->
												</div>
										<!--begin::Card header-->
										<!--begin::Card body-->
										<div class="card-body p-9">
											<!--begin::Row-->
											<?php 
											$week=['monday','tuesday','wednesday','thursday','friday','sat','sun'];?>
											@foreach ($week as $day) 
											<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">{{ucfirst($day)}}</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8">
													<span id="{{$day}}_shift" class="fw-bolder fs-6 text-dark">
														
													</span>
												</div>
												<!--end::Col-->
											</div>	
												@endforeach
											
										

						
											<!--end::Notice-->
										</div>
										<!--end::Card body-->
									</div>
									{{-- end --}}

									<div class="card mb-5 mb-xl-10 tab-pane fade  "  id="payrates" role="tabpanel" aria-labelledby="payrates">
										<!--begin::Card header-->
												<div class="card-header cursor-pointer">
													<!--begin::Card title-->
													<div class="card-title m-0">
														<h3 class="fw-bolder m-0">Pay-Rates</h3>
													</div>
													<!--end::Card title-->
													<!--begin::Action-->
													<a href="{{url('edit_guard') . '/' . $guard->id}}" class="btn btn-primary align-self-center">Edit Profile</a>
													<!--end::Action-->
												</div>
										<!--begin::Card header-->
										<!--begin::Card body-->
										<div class="card-body p-9">
											<!--begin::Row-->
											@foreach($payrates as $payrate)
											<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">PayRate</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8">
													<span class="fw-bolder fs-6 text-dark">{{$payrate->title}}</span>
												</div>
												<!--end::Col-->
											</div>
											<!--end::Row-->
											<!--begin::Input group-->
											<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">State</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8 fv-row">
													<span class="fw-bold fs-6">{{$payrate->state}}</span>
												</div>
												<!--end::Col-->
											</div>
											<!--end::Input group-->
											<!--begin::Input group-->
											<div class="row mb-7">
												<label class="col-lg-4 fw-bold text-muted">Level no</label>
												<div class="col-lg-8 d-flex align-items-center">
													<span class="fw-bolder fs-6 me-2">{{$payrate->level}}</span>
													<span class="badge badge-success"></span>
												</div>
												<!--end::Col-->

											</div>
											@endforeach
											<!--end::Input group-->

						
											<!--end::Notice-->
										</div>
										<!--end::Card body-->
									</div>

									<!-- end -->


									<!-- begin sites -->

									<div class="card mb-5 mb-xl-10 tab-pane fade "  id="sites_trained" role="tabpanel" aria-labelledby="sites_trained">
										<!--begin::Card header-->
												

										<div class="card-header cursor-pointer">
											<!--begin::Card title-->
											<div class="card-title m-0">
												<h3 class="fw-bolder m-0">Sites Trained</h3>
											</div>
											<!--end::Card title-->
											<!--begin::Action-->
											<a href="{{url('edit_guard') . '/' . $guard->id}}" class="btn btn-primary align-self-center">Edit Profile</a>
											<!--end::Action-->
										</div>
										<!--begin::Card header-->
										<!--begin::Card body-->
										<!--begin::Row-->
										<div class="card-body">
											@foreach($site_trained as $site)
											<div class="row mb-7">
												<!--begin::Label-->
												
												<label class="col-lg-4 fw-bold text-muted">Trained Site Booking ID</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8">
													<span class="fw-bolder fs-6 text-dark">
														@if($site =='')
															N/A
														@else

														{{$site->booking_id}}
														@endif
													</span>
												</div>

												<!--end::Col-->
											</div>
											<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">Trained Site Details</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8">
													<span class="fw-bolder fs-6 text-dark">
														

																			@if($site==null)
														N/A
														@else

														{{$site->site_name}}
														@endif
													</span>
												</div>

												<!--end::Col-->
											</div>
											<hr>
											@endforeach

											</div>
										
										<!--end::Card body-->
									</div>


									<!-- begin block -->

									<div class="card mb-5 mb-xl-10 tab-pane fade "  id="sites_blocked" role="tabpanel" aria-labelledby="sites_blocked">
										<!--begin::Card header-->
												

										<div class="card-header cursor-pointer">
											<!--begin::Card title-->
											<div class="card-title m-0">
												<h3 class="fw-bolder m-0">Sites Blocked</h3>
											</div>
											<!--end::Card title-->
											<!--begin::Action-->
											<a href="{{url('edit_guard') . '/' . $guard->id}}" class="btn btn-primary align-self-center">Edit Profile</a>
											<!--end::Action-->
										</div>
										<!--begin::Card header-->
										<!--begin::Card body-->
										<!--begin::Row-->
										<div class="card-body">
											@foreach($site_blocked as $site)
											<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">Blocked Site Booking ID</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8">
													<span class="fw-bolder fs-6 text-dark">
														@if($site==null)
														N/A
														@else

														{{$site->booking_id}}
														@endif
													</span>
												</div>

												<!--end::Col-->
											</div>
											<div class="row mb-7">
												<!--begin::Label-->
												<label class="col-lg-4 fw-bold text-muted">Blocked Site Details</label>
												<!--end::Label-->
												<!--begin::Col-->
												<div class="col-lg-8">
													<span class="fw-bolder fs-6 text-dark">
														

																			@if($site==null)
														N/A
														@else

														{{$site->site_name}}
														@endif
													</span>
												</div>

												<!--end::Col-->
											</div>
											<hr>
											@endforeach
											</div>
										
										<!--end::Card body-->
									</div>

									<!-- begin password -->

										<div class="card mb-5 mb-xl-10 tab-pane fade "  id="password" role="tabpanel" aria-labelledby="password">
										<!--begin::Card header-->

										<div class="card-header cursor-pointer">
											<!--begin::Card title-->
											<div class="card-title m-0">
												<h3 class="fw-bolder m-0">Change Password</h3>
											</div>
											<!--end::Card title-->
											<!--begin::Action-->
											<!-- <a href="{{url('edit_guard') . '/' . $guard->id}}" class="btn btn-primary align-self-center">Edit Profile</a> -->
											<!--end::Action-->
										</div>
										<!--begin::Card header-->
										<!--begin::Card body-->
										<!--begin::Row-->
										<div class="card-body">
<form id="password_form" class="form" action="{{url('guard/change_password')}}" method="POST" enctype="multipart/form-data"> @csrf													<input type="hidden" name="guard_id" value="{{$guard->id}}">
											<div class="row mb-7">
												<label>New Password</label>
											    <input class="form-control" type="password" id="password" name="password" />
	
											</div>
											<div class="row mb-7">
													<label> Confirm Password</label>
											    <input class="form-control" type="confirm_password" id="confirm_password" name="confirm_password" />
	
											</div>
											<div class="row ">
												<button type="submit" class="btn-primary btn" style="text-align: center;">Submit</button>
											</div>
											</form>

										</div>

										
										<!--end::Card body-->
									</div>

		
		
									{{-- customer tab --}}
									<div class="card-body mb-5 mb-xl-10 tab-pane fade "  id="customer_tab" role="tabpanel" aria-labelledby="customer_tab">

									</div>

									{{-- customer tab --}}		

									<!-- end tabs by hussain -->

								</div>
								<!-- endtab -->

							<!--end::details View-->
							<!--begin::Row-->
							<div class="row gy-10 gx-xl-10" style="display:none;">
								<!--begin::Col-->
								<div class="col-xl-12">
									<!--begin::Charts Widget 1-->
									<div class="card card-xxl-stretch mb-5 mb-xl-10">
										<!--begin::Header-->
										<div class="card-header border-0 pt-5">
											<!--begin::Title-->
											<h3 class="card-title align-items-start flex-column">
												<span class="card-label fw-bolder fs-3 mb-1"> Monthly Statistics</span>
												<span class="text-muted fw-bold fs-7">Shifts and Hours</span>
											</h3>
											<!--end::Title-->
											<!--begin::Toolbar-->
											<div class="card-toolbar">
										 
											</div>
											<!--end::Toolbar-->
										</div>
										<!--end::Header-->
										<!--begin::Body-->
										<div class="card-body">
											<!--begin::Chart-->
											<div id="kt_charts_widget_1_chart" style="height: 350px"></div>
											<!--end::Chart-->
										</div>
										<!--end::Body-->
									</div>
									<!--end::Charts Widget 1-->
								</div>
								<!--end::Col-->
								<!--begin::Col-->
							
							</div>
							<!--end::Row-->
							<!--begin::Row-->
							<div class="row gy-10 gx-xl-10">
								<!--begin::Col-->
								
								<!--end::Col-->
								<!--begin::Col-->
								
								<!--end::Col-->
							</div>
							<!--end::Row-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Content-->
					<!--begin::Footer-->
				
					<!--end::Footer-->
				@endforeach
				<!--end::Wrapper-->
				@stop 
				@section('pageFooter')

		<script src="{{asset('')}}plugins/global/plugins.bundle.js"></script>
		<script src="{{asset('')}}js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Page Custom Javascript(used by this page)-->
		{{-- <script src="{{asset('')}}js/custom/widgets.js"></script> --}}
		<script src="{{asset('')}}js/custom/guard_stats.js"></script>

		<script src="{{asset('')}}js/custom/apps/chat/chat.js"></script>
		<script src="{{asset('')}}js/custom/modals/create-app.js"></script>
		<script src="{{asset('')}}js/custom/modals/upgrade-plan.js"></script>
		<script>
		var guard_hours_stats=[];
		var guard_shifts_stats=[];
		var guard_months_stats=[];
	</script>

		<script type="text/javascript">
		$(document).ready(function() {
		guard_shift_hours_stats();

	  	
});


			// $('#confirm_password').on('change',function(e)){
			// 	alert();
			// };
					  $("#password_form").on('submit', function(e){
					     e.preventDefault();



					     console.log(this.id)
					     var data = $('#'+this.id).serialize();

					     $.ajax({type: "POST",url: this.action,data : data
					 ,success: function(result){if(result.success){

											     	Swal.fire({
											                        text: "Password changed successfully",
											                        icon: "success",
											                        buttonsStyling: !1,
											                        confirmButtonText: "OK",
											                        customClass: {
											                            confirmButton: "btn btn-light"
											                        }
					                    })
					     }else{Swal.fire({
					                        text: "Password do not match ",
					                        icon: "error",
					                        buttonsStyling: !1,
					                        confirmButtonText: "Try again!",
					                        customClass: {
					                            confirmButton: "btn btn-light"
					                        }
					                    })}}})
					  });


					  function guard_shift_hours_stats()
{
	$.ajax({type: "POST",url: "{{url('guard_shift_hours_stats')}}", data:{id:{{$guard_id}},_token:'<?php echo csrf_token();?>'},success: function(result){
		 guard_hours_stats=result.specific_month_hours;
		 guard_shifts_stats=result.shifts;
		 guard_months_stats=result.months;
		 
		 show_stats(guard_hours_stats,guard_shifts_stats,guard_months_stats);
	
		// console.log(guard_months_stats);	

	}
});
}	



function get_avalibilty(){
							$.ajax({
						        type: "POST",
						        url: "{{url('guard/guard_avability_weak')}}",
						        data : {guard_id:'{{ $guard_id }}', _token : '{{ csrf_token()}}'},
						        success: function(result){
						        	// console.log(result.guard);

						        	// console.log(result.guard.guard_availability);

						        	if (result.guard.guard_availability == null || result.guard.guard_availability == 'null' ||  result.guard.guard_availability == '') {
						        	

						        	}else{
										var response=JSON.parse(result.guard.guard_availability);
										// console.log(response[0]);
										$.each(response[0], function ( key, value) {
											if(value!=0 ){
											// $(`#${key}`).prop("checked", true);
											if(value=='day')
											{
												value="Day Shift";
											}
											if(value=='night')
											{
												value="Night Shift";
											}
											if(value=='full')
											{
												value="Full Day Shift";
											}
											$(`#${key}_shift`).text(value);	
											console.log(`#${key}`);
											}else{
												$(`#${key}_shift`).text('N/A');	
											}
										// console.log(key + ": " + value);

										});
						        		// $('#guard-site-trained-container').html('');
						        	}
						        }
						        });

					}
 

 function get_specific_guard_customer(){
	 
$.ajax({type: "POST",url:"{{url('get_specific_guard_customer')}}",data:{id:{{$guard_id}},_token:'<?php echo csrf_token();?>'} ,success: function(result){
		var siteData2 ='<div class="row g-6 g-xl-9">';
		var Lenght=0;
		var message=1;
			// res=JSON.parse(result);
			console.log(result.length);
			if(result.length!=0){

			
		$.each(result, function(id, data) {
			siteData2+=`<div class="col-md-6 col-xxl-4">
											<!--begin::Card-->
											<div class="card">
												<!--begin::Card body-->
												<div class="card-body d-flex flex-center flex-column pt-12 p-9">
													<!--begin::Avatar-->
													<div class="symbol symbol-65px symbol-circle mb-5">
														<img src="https://img.icons8.com/fluency/48/000000/gender-neutral-user.png"/>
													
													</div>
													<!--end::Avatar-->
													<!--begin::Name-->
													<a  class="fs-4 text-gray-800 text-hover-primary fw-bolder mb-0">${data[0]}</a>
													<!--end::Name-->
													<!--begin::Position-->
													<div class="fw-bold text-gray-400 mb-6"><b>Email:&nbsp;  </b>${data[1]}.</div>
													<div class="fw-bold text-gray-400 mb-6"><b>Address:&nbsp;  </b>${data[2]}.</div>
													<div class="fw-bold text-gray-400 mb-6"><b>Phone:&nbsp;  </b>${data[3]}.</div>
													<!--end::Position-->
													<!--begin::Info-->
													
													<!--end::Info-->
												</div>
												<!--end::Card body-->
											</div>
											<!--end::Card-->
										</div>`;
			});
			siteData2+=`</div>`;
			$('#customer_tab').html(siteData2);
	}
	else{
		console.log('i enftered');
	siteData2+=`<div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
										<!--begin::Icon-->
										<!--begin::Svg Icon | path: icons/duotone/Code/Warning-1-circle.svg-->
										<span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
											<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"></circle>
												<rect fill="#000000" x="11" y="7" width="2" height="8" rx="1"></rect>
												<rect fill="#000000" x="11" y="16" width="2" height="2" rx="1"></rect>
											</svg>
										</span>
										<!--end::Svg Icon-->
										<!--end::Icon-->
										<!--begin::Wrapper-->
										<div class="d-flex flex-stack flex-grow-1">
											<!--begin::Content-->
											<div class="fw-bold">
												<h4 class="text-gray-800 fw-bolder">This {{config('custom.guard')}} is'nt assigned to any customer!</h4>
												<div class="fs-6 text-gray-600">You can assign a customer to this {{config('custom.guard')}} by clicking 
												<a class="fw-bolder" target="__blank" href="{{url('edit_guard').'/'.$guard_id	}}">Add Customer</a>.</div>
											</div>
											<!--end::Content-->
										</div>
										<!--end::Wrapper-->
									</div>`;
			$('#customer_tab').html(siteData2);
}
}
});
  }

	</script>


				@stop