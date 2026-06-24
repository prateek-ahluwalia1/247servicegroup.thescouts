
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
		@foreach($admins as $admin)

@if($admin->image == '' || $admin->image == NULL)
		<style>

.profile_image {
  width: 150px;
  height: 150px;
  border-radius: 50%;
  background: #d99f23;
  font-size: 35px;
  color: #fff;
  text-align: center;
  line-height: 150px;
  margin: 20px 0;
}

		</style>
@endif
@endforeach
		@stop
	<!--end::Head-->
	<!--begin::Body-->
	@section('content')
	@foreach($admins as $admin)
	
				
				<!--begin::Wrapper-->
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
					<!--begin::Header-->
					<div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
						<!--begin::Container-->
						<div class="container d-flex align-items-center justify-content-between" id="kt_header_container">
							<!--begin::Page title-->
							<div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-2 pb-2 pb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
								<!--begin::Heading-->
								<h1 class="text-dark fw-bolder my-0 fs-2">Profile Details</h1>
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
							<!--begin::Layout-->
							<div class="d-flex flex-column flex-xl-row">
								<!--begin::Sidebar-->
								<div class="flex-column flex-lg-row-auto w-100 w-xl-400px mb-10">
									<!--begin::Card-->
									<div class="card mb-5 mb-xl-8">
										<!--begin::Card body-->
										<div class="card-body pt-0 pt-lg-1">
											<!--begin::Summary-->
											<!--begin::Card-->
											<div class="card">
												<!--begin::Card body-->
												<div class="card-body d-flex flex-center flex-column pt-12 p-9 px-0">
													<!--begin::Avatar-->
													<div class="symbol symbol-100px symbol-circle mb-7  overflow-hidden profile_image">
														

															<div class=" ">
																<img src="{{config('custom.asset_url')}}{{$admin->image}}" alt="" class="w-100" />
															</div>

													</div>
													<!--end::Avatar-->
													<!--begin::Name-->
													<div id="first_user_name" class="fs-3 text-gray-800 text-hover-primary fw-bolder mb-3 ">{{$admin->name}}</div>
													<!--end::Name-->
													<!--begin::Position-->
													<div class="mb-9">
														<!--begin::Badge-->
														@foreach($access_role as $role)
														<div class="badge badge-lg badge-light-primary d-inline">{{$role->title}}</div>
														@endforeach
														<!--begin::Badge-->
													</div>
													<!--end::Position-->
													<!--begin::Info-->
													<!--begin::Info heading-->
													<div class="fw-bolder mb-3">{{$admin->state}}
													<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true" data-bs-content="State of Administrator."></i></div>
													<!--end::Info heading-->
													
													<!--end::Info-->
												</div>
												<!--end::Card body-->
											</div>
											<!--end::Card-->
											<!--end::Summary-->
											<!--begin::Details toggle-->
											<div class="d-flex flex-stack fs-4 py-3">
												<div class="fw-bolder rotate collapsible" data-bs-toggle="collapse" href="#kt_user_view_details" role="button" aria-expanded="false" aria-controls="kt_user_view_details">Details
												<span class="ms-2 rotate-180">
													<!--begin::Svg Icon | path: icons/duotone/Navigation/Angle-down.svg-->
													<span class="svg-icon svg-icon-3">
														<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
															<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																<polygon points="0 0 24 0 24 24 0 24" />
																<path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999)" />
															</g>
														</svg>
													</span>
													<!--end::Svg Icon-->
												</span></div>
												<span data-bs-toggle="tooltip" data-bs-trigger="hover" title="Edit Admin details">
													<a onclick="getUser( {{ $admin->id }}, {{$admin->access_level_id}})" class="btn btn-sm btn-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">Edit</a>
												</span>
											</div>
											<!--end::Details toggle-->
											<div class="separator"></div>
											<!--begin::Details content-->
											<div id="kt_user_view_details" class="collapse show">
												<div class="pb-5 fs-6">
													<!--begin::Details item-->
													<div class="fw-bolder mt-5">Account Type</div>
													@foreach($access_role as $r)
													<div class="text-gray-600">{{$r->title}}</div>
													@endforeach
													<!--begin::Details item-->
													<!--begin::Details item-->
													<div class="fw-bolder mt-5">Email</div>
													<div class="text-gray-600">
														<a href="#" class="text-gray-600 text-hover-primary">{{$admin->email}}</a>
													</div>
													<!--begin::Details item-->
													<!--begin::Details item-->
													<div class="fw-bolder mt-5">state</div>
													<div class="text-gray-600">{{$admin->state}}
													</div>
													<!--begin::Details item-->
													<!--begin::Details item-->
													
													<!--begin::Details item-->
													<!--begin::Details item-->
												
													<!--begin::Details item-->
												</div>
											</div>
											<!--end::Details content-->
										</div>
										<!--end::Card body-->
									</div>
									<!--end::Card-->
									<!--begin::Connected Accounts-->
									
									<!--end::Connected Accounts-->
								</div>
								<!--end::Sidebar-->
								<!--begin::Content-->
								<div class="flex-lg-row-fluid ms-lg-15">
									<!--begin:::Tabs-->
									<ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
										<!--begin:::Tab item-->
										<!-- <li class="nav-item">
											<a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#kt_user_view_overview_tab">Overview</a>
										</li>
 -->										<!--end:::Tab item-->
										<!--begin:::Tab item-->
										<li class="nav-item">
											<a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab" href="#kt_user_view_overview_security">Profile</a>
										</li>
										<!--end:::Tab item-->
										<!--begin:::Tab item-->
										
										<!--end:::Tab item-->
										<!--begin:::Tab item-->
										
										<!--end:::Tab item-->
									</ul>
									<!--end:::Tabs-->
									<!--begin:::Tab content-->
									<div class="tab-content" id="myTabContent">
										<!--begin:::Tab pane-->
										<div class="tab-pane fade " id="kt_user_view_overview_tab" role="tabpanel">
											<!--begin::Card-->
											
											<!--end::Card-->
											<!--begin::Tasks-->
										
											<!--end::Tasks-->
										</div>
										<!--end:::Tab pane-->
										<!--begin:::Tab pane-->
										<div class="tab-pane fade show active" id="kt_user_view_overview_security" role="tabpanel">
											<!--begin::Card-->
											<div class="card pt-4 mb-6 mb-xl-9">
												<!--begin::Card header-->
												<div class="card-header border-0">
													<!--begin::Card title-->
													<div class="card-title">
														<h2>Profile</h2>
													</div>
													<!--end::Card title-->
												</div>
												<!--end::Card header-->
												<!--begin::Card body-->
												<div class="card-body pt-0 pb-5">
													<!--begin::Table wrapper-->
													<div class="table-responsive">
														<!--begin::Table-->
														<table class="table align-middle table-row-dashed gy-5" id="kt_table_users_login_session">
															<!--begin::Table body-->
															<tbody class="fs-6 fw-bold text-gray-600">
																<tr>
																	<td>Email</td>
																	<td>{{$admin->email}}</td>
															
																</tr>
																<tr>
																	<td>Password</td>
																	<td>*********</td>
																	<td class="text-end">
																		<button type="button" class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto" data-bs-toggle="modal" data-bs-target="#password_modal">
																			<!--begin::Svg Icon | path: icons/duotone/Interface/Edit.svg-->
																			<span class="svg-icon svg-icon-3">
																				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																					<rect opacity="0.25" x="3" y="21" width="18" height="2" rx="1" fill="#191213"></rect>
																					<path fill-rule="evenodd" clip-rule="evenodd" d="M4.08576 11.5L3.58579 12C3.21071 12.375 3 12.8838 3 13.4142V17C3 18.1045 3.89543 19 5 19H8.58579C9.11622 19 9.62493 18.7893 10 18.4142L10.5 17.9142L4.08576 11.5Z" fill="#121319"></path>
																					<path fill-rule="evenodd" clip-rule="evenodd" d="M5.5 10.0858L11.5858 4L18 10.4142L11.9142 16.5L5.5 10.0858Z" fill="#121319"></path>
																					<path opacity="0.25" fill-rule="evenodd" clip-rule="evenodd" d="M18.1214 1.70705C16.9498 0.535476 15.0503 0.535476 13.8787 1.70705L13 2.58576L19.4142 8.99997L20.2929 8.12126C21.4645 6.94969 21.4645 5.0502 20.2929 3.87862L18.1214 1.70705Z" fill="#191213"></path>
																				</svg>
																			</span>
																			<!--end::Svg Icon-->
																		</button>
																	</td>
																	
																</tr>
																<tr>
																	<td>Role</td>
																	<td>{{$admin->access_level}}</td>
																	
																</tr>
															</tbody>
															<!--end::Table body-->
														</table>
														<!--end::Table-->
													</div>
													<!--end::Table wrapper-->
												</div>
												<!--end::Card body-->
											</div>
											<!--end::Card-->
											<!--begin::Card-->

											<!--end::Card-->
											<!--begin::Card-->
											{{-- <div class="card pt-4 mb-6 mb-xl-9">
												<!--begin::Card header-->
												<div class="card-header border-0">
													<!--begin::Card title-->
													<div class="card-title flex-column">
														<h2>Email Notifications</h2>
														<div class="fs-6 fw-bold text-gray-400">Choose what messages you’d like to receive for each of your accounts.</div>
													</div>
													<!--end::Card title-->
												</div>
												<!--end::Card header-->
												<!--begin::Card body-->
												<div class="card-body">
													<!--begin::Form-->
													<form class="form" id="kt_users_email_notification_form">
														<!--begin::Item-->
														<div class="d-flex">
															<!--begin::Checkbox-->
															<div class="form-check form-check-custom form-check-solid">
																<!--begin::Input-->
																<input class="form-check-input me-3" name="email_notification_0" type="checkbox" value="0" id="kt_modal_update_email_notification_0" checked='checked' />
																<!--end::Input-->
																<!--begin::Label-->
																<label class="form-check-label" for="kt_modal_update_email_notification_0">
																	<div class="fw-bolder">Successful Payments</div>
																	<div class="text-gray-600">Receive a notification for every successful payment.</div>
																</label>
																<!--end::Label-->
															</div>
															<!--end::Checkbox-->
														</div>
														<!--end::Item-->
														<div class='separator separator-dashed my-5'></div>
														<!--begin::Item-->
														<div class="d-flex">
															<!--begin::Checkbox-->
															<div class="form-check form-check-custom form-check-solid">
																<!--begin::Input-->
																<input class="form-check-input me-3" name="email_notification_1" type="checkbox" value="1" id="kt_modal_update_email_notification_1" />
																<!--end::Input-->
																<!--begin::Label-->
																<label class="form-check-label" for="kt_modal_update_email_notification_1">
																	<div class="fw-bolder">Payouts</div>
																	<div class="text-gray-600">Receive a notification for every initiated payout.</div>
																</label>
																<!--end::Label-->
															</div>
															<!--end::Checkbox-->
														</div>
														<!--end::Item-->
														<div class='separator separator-dashed my-5'></div>
														<!--begin::Item-->
														<div class="d-flex">
															<!--begin::Checkbox-->
															<div class="form-check form-check-custom form-check-solid">
																<!--begin::Input-->
																<input class="form-check-input me-3" name="email_notification_2" type="checkbox" value="2" id="kt_modal_update_email_notification_2" />
																<!--end::Input-->
																<!--begin::Label-->
																<label class="form-check-label" for="kt_modal_update_email_notification_2">
																	<div class="fw-bolder">Application fees</div>
																	<div class="text-gray-600">Receive a notification each time you collect a fee from an account.</div>
																</label>
																<!--end::Label-->
															</div>
															<!--end::Checkbox-->
														</div>
														<!--end::Item-->
														<div class='separator separator-dashed my-5'></div>
														<!--begin::Item-->
														<div class="d-flex">
															<!--begin::Checkbox-->
															<div class="form-check form-check-custom form-check-solid">
																<!--begin::Input-->
																<input class="form-check-input me-3" name="email_notification_3" type="checkbox" value="3" id="kt_modal_update_email_notification_3" checked='checked' />
																<!--end::Input-->
																<!--begin::Label-->
																<label class="form-check-label" for="kt_modal_update_email_notification_3">
																	<div class="fw-bolder">Disputes</div>
																	<div class="text-gray-600">Receive a notification if a payment is disputed by a customer and for dispute resolutions.</div>
																</label>
																<!--end::Label-->
															</div>
															<!--end::Checkbox-->
														</div>
														<!--end::Item-->
														<div class='separator separator-dashed my-5'></div>
														<!--begin::Item-->
														<div class="d-flex">
															<!--begin::Checkbox-->
															<div class="form-check form-check-custom form-check-solid">
																<!--begin::Input-->
																<input class="form-check-input me-3" name="email_notification_4" type="checkbox" value="4" id="kt_modal_update_email_notification_4" checked='checked' />
																<!--end::Input-->
																<!--begin::Label-->
																<label class="form-check-label" for="kt_modal_update_email_notification_4">
																	<div class="fw-bolder">Payment reviews</div>
																	<div class="text-gray-600">Receive a notification if a payment is marked as an elevated risk.</div>
																</label>
																<!--end::Label-->
															</div>
															<!--end::Checkbox-->
														</div>
														<!--end::Item-->
														<div class='separator separator-dashed my-5'></div>
														<!--begin::Item-->
														<div class="d-flex">
															<!--begin::Checkbox-->
															<div class="form-check form-check-custom form-check-solid">
																<!--begin::Input-->
																<input class="form-check-input me-3" name="email_notification_5" type="checkbox" value="5" id="kt_modal_update_email_notification_5" />
																<!--end::Input-->
																<!--begin::Label-->
																<label class="form-check-label" for="kt_modal_update_email_notification_5">
																	<div class="fw-bolder">Mentions</div>
																	<div class="text-gray-600">Receive a notification if a teammate mentions you in a note.</div>
																</label>
																<!--end::Label-->
															</div>
															<!--end::Checkbox-->
														</div>
														<!--end::Item-->
														<div class='separator separator-dashed my-5'></div>
														<!--begin::Item-->
														<div class="d-flex">
															<!--begin::Checkbox-->
															<div class="form-check form-check-custom form-check-solid">
																<!--begin::Input-->
																<input class="form-check-input me-3" name="email_notification_6" type="checkbox" value="6" id="kt_modal_update_email_notification_6" />
																<!--end::Input-->
																<!--begin::Label-->
																<label class="form-check-label" for="kt_modal_update_email_notification_6">
																	<div class="fw-bolder">Invoice Mispayments</div>
																	<div class="text-gray-600">Receive a notification if a customer sends an incorrect amount to pay their invoice.</div>
																</label>
																<!--end::Label-->
															</div>
															<!--end::Checkbox-->
														</div>
														<!--end::Item-->
														<div class='separator separator-dashed my-5'></div>
														<!--begin::Item-->
														<div class="d-flex">
															<!--begin::Checkbox-->
															<div class="form-check form-check-custom form-check-solid">
																<!--begin::Input-->
																<input class="form-check-input me-3" name="email_notification_7" type="checkbox" value="7" id="kt_modal_update_email_notification_7" />
																<!--end::Input-->
																<!--begin::Label-->
																<label class="form-check-label" for="kt_modal_update_email_notification_7">
																	<div class="fw-bolder">Webhooks</div>
																	<div class="text-gray-600">Receive notifications about consistently failing webhook endpoints.</div>
																</label>
																<!--end::Label-->
															</div>
															<!--end::Checkbox-->
														</div>
														<!--end::Item-->
														<div class='separator separator-dashed my-5'></div>
														<!--begin::Item-->
														<div class="d-flex">
															<!--begin::Checkbox-->
															<div class="form-check form-check-custom form-check-solid">
																<!--begin::Input-->
																<input class="form-check-input me-3" name="email_notification_8" type="checkbox" value="8" id="kt_modal_update_email_notification_8" />
																<!--end::Input-->
																<!--begin::Label-->
																<label class="form-check-label" for="kt_modal_update_email_notification_8">
																	<div class="fw-bolder">Trial</div>
																	<div class="text-gray-600">Receive helpful tips when you try out our products.</div>
																</label>
																<!--end::Label-->
															</div>
															<!--end::Checkbox-->
														</div>
														<!--end::Item-->
														<!--begin::Action buttons-->
														<div class="d-flex justify-content-end align-items-center mt-12">
															<!--begin::Button-->
															<button type="button" class="btn btn-light me-5" id="kt_users_email_notification_cancel">Cancel</button>
															<!--end::Button-->
															<!--begin::Button-->
															<button type="button" class="btn btn-primary" id="kt_users_email_notification_submit">
																<span class="indicator-label">Save</span>
																<span class="indicator-progress">Please wait...
																<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
															</button>
															<!--end::Button-->
														</div>
														<!--begin::Action buttons-->
													</form>
													<!--end::Form-->
												</div>
												<!--end::Card body-->
												<!--begin::Card footer-->
												<!--end::Card footer-->
											</div> --}}
											<!--end::Card-->
										</div>
										<!--end:::Tab pane-->
										<!--begin:::Tab pane-->
										<div class="tab-pane fade" id="kt_user_view_overview_events_and_logs_tab" role="tabpanel">
											<!--begin::Card-->
											
											<!--end::Card-->
											<!--begin::Card-->
											<div class="card pt-4 mb-6 mb-xl-9">
												<!--begin::Card header-->
												<div class="card-header border-0">
													<!--begin::Card title-->
													<div class="card-title">
														<h2>Logs</h2>
													</div>
													<!--end::Card title-->
													<!--begin::Card toolbar-->
													<div class="card-toolbar">
														<!--begin::Button-->
														<button type="button" class="btn btn-sm btn-light-primary">
														<!--begin::Svg Icon | path: icons/duotone/Files/Download.svg-->
														<span class="svg-icon svg-icon-3">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<rect x="0" y="0" width="24" height="24" />
																	<path d="M2,13 C2,12.5 2.5,12 3,12 C3.5,12 4,12.5 4,13 C4,13.3333333 4,15 4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 C2,15 2,13.3333333 2,13 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
																	<rect fill="#000000" opacity="0.3" transform="translate(12.000000, 8.000000) rotate(-180.000000) translate(-12.000000, -8.000000)" x="11" y="1" width="2" height="14" rx="1" />
																	<path d="M7.70710678,15.7071068 C7.31658249,16.0976311 6.68341751,16.0976311 6.29289322,15.7071068 C5.90236893,15.3165825 5.90236893,14.6834175 6.29289322,14.2928932 L11.2928932,9.29289322 C11.6689749,8.91681153 12.2736364,8.90091039 12.6689647,9.25670585 L17.6689647,13.7567059 C18.0794748,14.1261649 18.1127532,14.7584547 17.7432941,15.1689647 C17.3738351,15.5794748 16.7415453,15.6127532 16.3310353,15.2432941 L12.0362375,11.3779761 L7.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000004, 12.499999) rotate(-180.000000) translate(-12.000004, -12.499999)" />
																</g>
															</svg>
														</span>
														<!--end::Svg Icon-->Download Report</button>
														<!--end::Button-->
													</div>
													<!--end::Card toolbar-->
												</div>
												<!--end::Card header-->
												<!--begin::Card body-->
												<div class="card-body py-0">
													<!--begin::Table wrapper-->
													<div class="table-responsive">
														<!--begin::Table-->
														<table class="table align-middle table-row-dashed fw-bold text-gray-600 fs-6 gy-5" id="kt_table_users_logs">
															<!--begin::Table body-->
															<tbody>
																<!--begin::Table row-->
																<tr>
																	<!--begin::Badge=-->
																	<td class="min-w-70px">
																		<div class="badge badge-light-warning">404 WRN</div>
																	</td>
																	<!--end::Badge=-->
																	<!--begin::Status=-->
																	<td>POST /v1/customer/c_60e58e0689df1/not_found</td>
																	<!--end::Status=-->
																	<!--begin::Timestamp=-->
																	<td class="pe-0 text-end min-w-200px">10 Mar 2021, 6:43 am</td>
																	<!--end::Timestamp=-->
																</tr>
																<!--end::Table row-->
																<!--begin::Table row-->
																<tr>
																	<!--begin::Badge=-->
																	<td class="min-w-70px">
																		<div class="badge badge-light-success">200 OK</div>
																	</td>
																	<!--end::Badge=-->
																	<!--begin::Status=-->
																	<td>POST /v1/invoices/in_4941_1626/payment</td>
																	<!--end::Status=-->
																	<!--begin::Timestamp=-->
																	<td class="pe-0 text-end min-w-200px">19 Aug 2021, 2:40 pm</td>
																	<!--end::Timestamp=-->
																</tr>
																<!--end::Table row-->
																<!--begin::Table row-->
																<tr>
																	<!--begin::Badge=-->
																	<td class="min-w-70px">
																		<div class="badge badge-light-danger">500 ERR</div>
																	</td>
																	<!--end::Badge=-->
																	<!--begin::Status=-->
																	<td>POST /v1/invoice/in_8805_1118/invalid</td>
																	<!--end::Status=-->
																	<!--begin::Timestamp=-->
																	<td class="pe-0 text-end min-w-200px">10 Nov 2021, 8:43 pm</td>
																	<!--end::Timestamp=-->
																</tr>
																<!--end::Table row-->
																<!--begin::Table row-->
																<tr>
																	<!--begin::Badge=-->
																	<td class="min-w-70px">
																		<div class="badge badge-light-success">200 OK</div>
																	</td>
																	<!--end::Badge=-->
																	<!--begin::Status=-->
																	<td>POST /v1/invoices/in_5085_1909/payment</td>
																	<!--end::Status=-->
																	<!--begin::Timestamp=-->
																	<td class="pe-0 text-end min-w-200px">05 May 2021, 10:10 pm</td>
																	<!--end::Timestamp=-->
																</tr>
																<!--end::Table row-->
																<!--begin::Table row-->
																<tr>
																	<!--begin::Badge=-->
																	<td class="min-w-70px">
																		<div class="badge badge-light-success">200 OK</div>
																	</td>
																	<!--end::Badge=-->
																	<!--begin::Status=-->
																	<td>POST /v1/invoices/in_3345_4152/payment</td>
																	<!--end::Status=-->
																	<!--begin::Timestamp=-->
																	<td class="pe-0 text-end min-w-200px">25 Oct 2021, 8:43 pm</td>
																	<!--end::Timestamp=-->
																</tr>
																<!--end::Table row-->
															</tbody>
															<!--end::Table body-->
														</table>
														<!--end::Table-->
													</div>
													<!--end::Table wrapper-->
												</div>
												<!--end::Card body-->
											</div>
											<!--end::Card-->
											<!--begin::Card-->
											<div class="card pt-4 mb-6 mb-xl-9">
												<!--begin::Card header-->
												<div class="card-header border-0">
													<!--begin::Card title-->
													<div class="card-title">
														<h2>Events</h2>
													</div>
													<!--end::Card title-->
													<!--begin::Card toolbar-->
													<div class="card-toolbar">
														<!--begin::Button-->
														<button type="button" class="btn btn-sm btn-light-primary">
														<!--begin::Svg Icon | path: icons/duotone/Files/Download.svg-->
														<span class="svg-icon svg-icon-3">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<rect x="0" y="0" width="24" height="24" />
																	<path d="M2,13 C2,12.5 2.5,12 3,12 C3.5,12 4,12.5 4,13 C4,13.3333333 4,15 4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 C2,15 2,13.3333333 2,13 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
																	<rect fill="#000000" opacity="0.3" transform="translate(12.000000, 8.000000) rotate(-180.000000) translate(-12.000000, -8.000000)" x="11" y="1" width="2" height="14" rx="1" />
																	<path d="M7.70710678,15.7071068 C7.31658249,16.0976311 6.68341751,16.0976311 6.29289322,15.7071068 C5.90236893,15.3165825 5.90236893,14.6834175 6.29289322,14.2928932 L11.2928932,9.29289322 C11.6689749,8.91681153 12.2736364,8.90091039 12.6689647,9.25670585 L17.6689647,13.7567059 C18.0794748,14.1261649 18.1127532,14.7584547 17.7432941,15.1689647 C17.3738351,15.5794748 16.7415453,15.6127532 16.3310353,15.2432941 L12.0362375,11.3779761 L7.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000004, 12.499999) rotate(-180.000000) translate(-12.000004, -12.499999)" />
																</g>
															</svg>
														</span>
														<!--end::Svg Icon-->Download Report</button>
														<!--end::Button-->
													</div>
													<!--end::Card toolbar-->
												</div>
												<!--end::Card header-->
												<!--begin::Card body-->
												<div class="card-body py-0">
													<!--begin::Table-->
													<table class="table align-middle table-row-dashed fs-6 text-gray-600 fw-bold gy-5" id="kt_table_customers_events">
														<!--begin::Table body-->
														<tbody>
															<!--begin::Table row-->
															<tr>
																<!--begin::Event=-->
																<td class="min-w-400px">Invoice
																<a href="#" class="fw-bolder text-gray-900 text-hover-primary me-1">#KIO-45656</a>status has changed from
																<span class="badge badge-light-succees me-1">In Transit</span>to
																<span class="badge badge-light-success">Approved</span></td>
																<!--end::Event=-->
																<!--begin::Timestamp=-->
																<td class="pe-0 text-gray-600 text-end min-w-200px">10 Mar 2021, 6:05 pm</td>
																<!--end::Timestamp=-->
															</tr>
															<!--end::Table row-->
															<!--begin::Table row-->
															<tr>
																<!--begin::Event=-->
																<td class="min-w-400px">Invoice
																<a href="#" class="fw-bolder text-gray-900 text-hover-primary me-1">#SEP-45656</a>status has changed from
																<span class="badge badge-light-warning me-1">Pending</span>to
																<span class="badge badge-light-info">In Progress</span></td>
																<!--end::Event=-->
																<!--begin::Timestamp=-->
																<td class="pe-0 text-gray-600 text-end min-w-200px">05 May 2021, 6:43 am</td>
																<!--end::Timestamp=-->
															</tr>
															<!--end::Table row-->
															<!--begin::Table row-->
															<tr>
																<!--begin::Event=-->
																<td class="min-w-400px">
																<a href="#" class="text-gray-600 text-hover-primary me-1">Sean Bean</a>has made payment to
																<a href="#" class="fw-bolder text-gray-900 text-hover-primary">#XRS-45670</a></td>
																<!--end::Event=-->
																<!--begin::Timestamp=-->
																<td class="pe-0 text-gray-600 text-end min-w-200px">20 Jun 2021, 6:43 am</td>
																<!--end::Timestamp=-->
															</tr>
															<!--end::Table row-->
															<!--begin::Table row-->
															<tr>
																<!--begin::Event=-->
																<td class="min-w-400px">
																<a href="#" class="text-gray-600 text-hover-primary me-1">{{$admin->name}}</a>has made payment to
																<a href="#" class="fw-bolder text-gray-900 text-hover-primary">#XRS-45670</a></td>
																<!--end::Event=-->
																<!--begin::Timestamp=-->
																<td class="pe-0 text-gray-600 text-end min-w-200px">05 May 2021, 6:43 am</td>
																<!--end::Timestamp=-->
															</tr>
															<!--end::Table row-->
															<!--begin::Table row-->
															<tr>
																<!--begin::Event=-->
																<td class="min-w-400px">Invoice
																<a href="#" class="fw-bolder text-gray-900 text-hover-primary me-1">#DER-45645</a>status has changed from
																<span class="badge badge-light-info me-1">In Progress</span>to
																<span class="badge badge-light-primary">In Transit</span></td>
																<!--end::Event=-->
																<!--begin::Timestamp=-->
																<td class="pe-0 text-gray-600 text-end min-w-200px">15 Apr 2021, 11:30 am</td>
																<!--end::Timestamp=-->
															</tr>
															<!--end::Table row-->
															<!--begin::Table row-->
															<tr>
																<!--begin::Event=-->
																<td class="min-w-400px">Invoice
																<a href="#" class="fw-bolder text-gray-900 text-hover-primary me-1">#KIO-45656</a>status has changed from
																<span class="badge badge-light-succees me-1">In Transit</span>to
																<span class="badge badge-light-success">Approved</span></td>
																<!--end::Event=-->
																<!--begin::Timestamp=-->
																<td class="pe-0 text-gray-600 text-end min-w-200px">10 Mar 2021, 9:23 pm</td>
																<!--end::Timestamp=-->
															</tr>
															<!--end::Table row-->
															<!--begin::Table row-->
															<tr>
																<!--begin::Event=-->
																<td class="min-w-400px">Invoice
																<a href="#" class="fw-bolder text-gray-900 text-hover-primary me-1">#SEP-45656</a>status has changed from
																<span class="badge badge-light-warning me-1">Pending</span>to
																<span class="badge badge-light-info">In Progress</span></td>
																<!--end::Event=-->
																<!--begin::Timestamp=-->
																<td class="pe-0 text-gray-600 text-end min-w-200px">20 Jun 2021, 8:43 pm</td>
																<!--end::Timestamp=-->
															</tr>
															<!--end::Table row-->
															<!--begin::Table row-->
															<tr>
																<!--begin::Event=-->
																<td class="min-w-400px">Invoice
																<a href="#" class="fw-bolder text-gray-900 text-hover-primary me-1">#KIO-45656</a>status has changed from
																<span class="badge badge-light-succees me-1">In Transit</span>to
																<span class="badge badge-light-success">Approved</span></td>
																<!--end::Event=-->
																<!--begin::Timestamp=-->
																<td class="pe-0 text-gray-600 text-end min-w-200px">24 Jun 2021, 10:10 pm</td>
																<!--end::Timestamp=-->
															</tr>
															<!--end::Table row-->
															<!--begin::Table row-->
															<tr>
																<!--begin::Event=-->
																<td class="min-w-400px">
																<a href="#" class="text-gray-600 text-hover-primary me-1">{{$admin->name}}</a>has made payment to
																<a href="#" class="fw-bolder text-gray-900 text-hover-primary">#XRS-45670</a></td>
																<!--end::Event=-->
																<!--begin::Timestamp=-->
																<td class="pe-0 text-gray-600 text-end min-w-200px">05 May 2021, 6:05 pm</td>
																<!--end::Timestamp=-->
															</tr>
															<!--end::Table row-->
															<!--begin::Table row-->
															<tr>
																<!--begin::Event=-->
																<td class="min-w-400px">
																<a href="#" class="text-gray-600 text-hover-primary me-1">Sean Bean</a>has made payment to
																<a href="#" class="fw-bolder text-gray-900 text-hover-primary">#XRS-45670</a></td>
																<!--end::Event=-->
																<!--begin::Timestamp=-->
																<td class="pe-0 text-gray-600 text-end min-w-200px">10 Nov 2021, 10:30 am</td>
																<!--end::Timestamp=-->
															</tr>
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
										<!--end:::Tab pane-->
									</div>
									<!--end:::Tab content-->
								</div>
								<!--end::Content-->
							</div>
							<!--end::Layout-->
							<!--begin::Modals-->
							<!--begin::Modal - Update user details-->



							<!-- testing -->
							{{-- <div class="modal fade" id="kt_modal_update_details" tabindex="-1" aria-hidden="true">
								<!--begin::Modal dialog-->
								<div class="modal-dialog modal-dialog-centered mw-650px">
									<!--begin::Modal content-->
									<div class="modal-content">
										<!--begin::Form-->
										<form id="kt_modal_update_user_form" class="form" 
														action="{{url('editUser/' . $admin->id)}}" method="POST" enctype="multipart/form-data">
																    @csrf
<!-- 										<form class="form" action="#" id="">
 -->											<!--begin::Modal header-->
											<div class="modal-header" id="kt_modal_update_user_header">
												<!--begin::Modal title-->
												<h2 class="fw-bolder">Update User Details</h2>
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
											<div class="modal-body py-10 px-lg-17">
												<!--begin::Scroll-->
												<div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_update_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_update_user_header" data-kt-scroll-wrappers="#kt_modal_update_user_scroll" data-kt-scroll-offset="300px">
													<!--begin::User toggle-->
													<div class="fw-boldest fs-3 rotate collapsible mb-7" data-bs-toggle="collapse" href="#kt_modal_update_user_user_info" role="button" aria-expanded="false" aria-controls="kt_modal_update_user_user_info">User Information
													<span class="ms-2 rotate-180">
														<!--begin::Svg Icon | path: icons/duotone/Navigation/Angle-down.svg-->
														<span class="svg-icon svg-icon-3">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<polygon points="0 0 24 0 24 24 0 24" />
																	<path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999)" />
																</g>
															</svg>
														</span>
														<!--end::Svg Icon-->
													</span></div>
													<!--end::User toggle-->
													<!--begin::User form-->
													<div id="kt_modal_update_user_user_info" class="collapse show">
														<!--begin::Input group-->
														<div class="mb-7">
															<!--begin::Label-->
															<label class="fs-6 fw-bold mb-2">
																<span>Update Avatar</span>
																<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Allowed file types: png, jpg, jpeg."></i>
															</label>
															<!--end::Label-->
															<!--begin::Image input wrapper-->
															<div class="mt-1">
																<!--begin::Image input-->
																<div class="image-input image-input-outline " data-kt-image-input="true" style="background-image: url({{asset('')}}media/uploads/{{$admin->image}})">
																	<!--begin::Preview existing avatar-->
																	<div class="image-input-wrapper w-125px h-125px profile_image" style="background-image: url({{asset('')}}media/uploads/{{$admin->image}})"></div>
																	<!--end::Preview existing avatar-->
																	<!--begin::Edit-->
																	<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
																		<i class="bi bi-pencil-fill fs-7"></i>
																		<!--begin::Inputs-->
																		<input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
																		<input type="hidden" name="avatar_remove" />
																		<!--end::Inputs-->
																	</label>
																	<!--end::Edit-->
																	<!--begin::Cancel-->
																	<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
																		<i class="bi bi-x fs-2"></i>
																	</span>
																	<!--end::Cancel-->
																	<!--begin::Remove-->
																	<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
																		<i class="bi bi-x fs-2"></i>
																	</span>
																	<!--end::Remove-->
																</div>
																<!--end::Image input-->
															</div>
															<!--end::Image input wrapper-->
														</div>
														<!--end::Input group-->
														<!--begin::Input group-->
														<div class="fv-row mb-7">
															<!--begin::Label-->
															<label class="fs-6 fw-bold mb-2">Name</label>
															<!--end::Label-->
															<!--begin::Input-->
															<input type="text" class="form-control form-control-solid" placeholder="" name="user_name" value="{{$admin->name}}" />
															<!--end::Input-->
														</div>
														<!--end::Input group-->
														<!--begin::Input group-->
														<div class="fv-row mb-7">
															<!--begin::Label-->
															<label class="fs-6 fw-bold mb-2">
																<span>Email</span>
																<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Email address must be active"></i>
															</label>
															<!--end::Label-->
															<!--begin::Input-->
															<input type="email" class="form-control form-control-solid" placeholder="" name="user_email" value="{{$admin->email}}" />
															<!--end::Input-->
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
																			<input class="form-check-input me-3" name="user_role" type="radio" value="{{$role->id}}" id="{{$role->title}}"  />
																			<!--end::Input-->
																			<!--begin::Label-->
																			<label class="form-check-label" for="kt_modal_update_role_option_0">
																				<div class="fw-bolder text-gray-800" id="{{$role->title}}">{{$role->title}}</div>
																				<div class="text-gray-600"></div>
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
														<!--begin::Input group-->
														
														<!--end::Input group-->
													</div>
													<!--end::User form-->
													<!--begin::Address toggle-->
													
													<!--end::Address form-->
												</div>
												<!--end::Scroll-->
											</div>
											<!--end::Modal body-->
											<!--begin::Modal footer-->
											<div class="modal-footer flex-center">
												<!--begin::Button-->
												<button type="reset" class="btn btn-white me-3" data-kt-users-modal-action="cancel">Discard</button>
												<!--end::Button-->
												<!--begin::Button-->
												<button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
													<span class="indicator-label">Submit</span>
													<span class="indicator-progress">Please wait...
													<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
												</button>
												<!--end::Button-->
											</div>
											<!--end::Modal footer-->
										</form>
										<!--end::Form-->
									</div>
								</div>
							</div> --}}
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
											<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
												<span >X</span>
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
													<!--end::Input group-->
												</div>
												<!--end::Scroll-->
												<!--begin::Actions-->
												<div class="text-center pt-15">
													<button data-bs-dismiss="modal" aria-label="Close" class="btn btn-white me-3" >Discard</button>
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
							<!--end::Modal - Update user details-->
							<!--begin::Modal - Add schedule-->
							<div class="modal fade" id="kt_modal_add_schedule" tabindex="-1" aria-hidden="true">
								<!--begin::Modal dialog-->
								<div class="modal-dialog modal-dialog-centered mw-650px">
									<!--begin::Modal content-->
									<div class="modal-content">
										<!--begin::Modal header-->
										<div class="modal-header">
											<!--begin::Modal title-->
											<h2 class="fw-bolder">Add an Event</h2>
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
											<form id="kt_modal_add_schedule_form" class="form" action="#">
												<!--begin::Input group-->
												<div class="fv-row mb-7">
													<!--begin::Label-->
													<label class="fs-6 fw-bold form-label mb-2">
														<span class="required">Date &amp; Time</span>
														<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true" data-bs-content="Select a date &amp; time."></i>
													</label>
													<!--end::Label-->
													<!--begin::Input-->
													<input class="form-control form-control-solid" placeholder="Pick date &amp; time" name="event_datetime" id="kt_modal_add_schedule_datepicker" />
													<!--end::Input-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="fv-row mb-7">
													<!--begin::Label-->
													<label class="required fs-6 fw-bold form-label mb-2">Event Name</label>
													<!--end::Label-->
													<!--begin::Input-->
													<input type="text" class="form-control form-control-solid" name="event_name" value="" />
													<!--end::Input-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="fv-row mb-7">
													<!--begin::Label-->
													<label class="required fs-6 fw-bold form-label mb-2">Event Organiser</label>
													<!--end::Label-->
													<!--begin::Input-->
													<input type="text" class="form-control form-control-solid" name="event_org" value="" />
													<!--end::Input-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="fv-row mb-7">
													<!--begin::Label-->
													<label class="required fs-6 fw-bold form-label mb-2">Send Event Details To</label>
													<!--end::Label-->
													<!--begin::Input-->
													<input id="kt_modal_add_schedule_tagify" type="text" class="form-control form-control-solid" name="event_invitees" value="e.smith@kpmg.com.au, melody@altbox.com" />
													<!--end::Input-->
												</div>
												<!--end::Input group-->
												<!--begin::Actions-->
												<div class="text-center pt-15">
													<button type="reset" class="btn btn-white me-3" data-kt-users-modal-action="cancel">Discard</button>
													<button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
														<span class="indicator-label">Submit</span>
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
							<!--end::Modal - Add schedule-->
							<!--begin::Modal - Add task-->
							<div class="modal fade" id="kt_modal_add_task" tabindex="-1" aria-hidden="true">
								<!--begin::Modal dialog-->
								<div class="modal-dialog modal-dialog-centered mw-650px">
									<!--begin::Modal content-->
									<div class="modal-content">
										<!--begin::Modal header-->
										<div class="modal-header">
											<!--begin::Modal title-->
											<h2 class="fw-bolder">Add a Task</h2>
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
											<form id="kt_modal_add_task_form" class="form" action="#">
												<!--begin::Input group-->
												<div class="fv-row mb-7">
													<!--begin::Label-->
													<label class="fs-6 fw-bold form-label mb-2">
														<span class="required">Task Due Date</span>
														<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true" data-bs-content="Select a due date."></i>
													</label>
													<!--end::Label-->
													<!--begin::Input-->
													<input class="form-control form-control-solid" placeholder="Pick date" name="task_duedate" id="kt_modal_add_task_datepicker" />
													<!--end::Input-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="fv-row mb-7">
													<!--begin::Label-->
													<label class="required fs-6 fw-bold form-label mb-2">Task Name</label>
													<!--end::Label-->
													<!--begin::Input-->
													<input type="text" class="form-control form-control-solid" name="task_name" value="" />
													<!--end::Input-->
												</div>
												<!--end::Input group-->
												<!--begin::Input group-->
												<div class="fv-row mb-7">
													<!--begin::Label-->
													<label class="fs-6 fw-bold form-label mb-2">Task Description</label>
													<!--end::Label-->
													<!--begin::Input-->
													<textarea class="form-control form-control-solid rounded-3"></textarea>
													<!--end::Input-->
												</div>
												<!--end::Input group-->
												<!--begin::Actions-->
												<div class="text-center pt-15">
													<button type="reset" class="btn btn-white me-3" data-kt-users-modal-action="cancel">Discard</button>
													<button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
														<span class="indicator-label">Submit</span>
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
							<!--begin::Modal - Update email-->
							<div class="modal fade" id="kt_modal_update_email" tabindex="-1" aria-hidden="true">
								<!--begin::Modal dialog-->
								<div class="modal-dialog modal-dialog-centered mw-650px">
									<!--begin::Modal content-->
									<div class="modal-content">
										<!--begin::Modal header-->
										<div class="modal-header">
											<!--begin::Modal title-->
											<h2 class="fw-bolder">Update Email Address</h2>
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
											<form id="kt_modal_update_email_form" class="form" action="#">
												<!--begin::Notice-->
												<!--begin::Notice-->
												<div class="notice d-flex bg-light-primary rounded border-primary border border-dashed mb-9 p-6">
													<!--begin::Icon-->
													<!--begin::Svg Icon | path: icons/duotone/Code/Warning-1-circle.svg-->
													<span class="svg-icon svg-icon-2tx svg-icon-primary me-4">
														<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
															<circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10" />
															<rect fill="#000000" x="11" y="7" width="2" height="8" rx="1" />
															<rect fill="#000000" x="11" y="16" width="2" height="2" rx="1" />
														</svg>
													</span>
													<!--end::Svg Icon-->
													<!--end::Icon-->
													<!--begin::Wrapper-->
													<div class="d-flex flex-stack flex-grow-1">
														<!--begin::Content-->
														<div class="fw-bold">
															<div class="fs-6 text-gray-600">Please note that a valid email address is required to complete the email verification.</div>
														</div>
														<!--end::Content-->
													</div>
													<!--end::Wrapper-->
												</div>
												<!--end::Notice-->
												<!--end::Notice-->
												<!--begin::Input group-->
												<div class="fv-row mb-7">
													<!--begin::Label-->
													<label class="fs-6 fw-bold form-label mb-2">
														<span class="required">Email Address</span>
													</label>
													<!--end::Label-->
													<!--begin::Input-->
													<input class="form-control form-control-solid" placeholder="" name="profile_email" value="e.smith@kpmg.com.au" />
													<!--end::Input-->
												</div>
												<!--end::Input group-->
												<!--begin::Actions-->
												<div class="text-center pt-15">
													<button type="reset" class="btn btn-white me-3" data-kt-users-modal-action="cancel">Discard</button>
													<button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
														<span class="indicator-label">Submit</span>
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
							<!--end::Modal - Update email-->
							<!--begin::Modal - Update password-->
						


<div class="modal fade" id="password_modal" tabindex="-1" aria-hidden="true">
	<!--begin::Modal dialog-->
	<div class="modal-dialog modal-dialog-centered mw-750px">
		<!--begin::Modal content-->
		<div class="modal-content">
			<!--begin::Modal header-->
			<div class="modal-header">
				<!--begin::Modal title-->
				<h2 class="fw-bolder" id="form_head">Change Password</h2>
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
								<form id="password_form" class="form" action="{{url('admin/change_password')}}" method="POST" enctype="multipart/form-data"> @csrf												


																<input type="hidden" class="form-control form-control-md" name="id"  value="{{$admin->id}}"> 


									<div class="row mb-7">
										<label>Password</label>
										<input class="form-control" type="text" id="password" name="password" />

									</div>
									<div class="row mb-7">
											<label> Confirm Password</label>
										<input class="form-control" type="confirm_password" id="confirm_password" name="confirm_password" />

									</div>
									<div class="row ">
										<button type="submit" class="btn-primary btn" style="text-align: center;">Submit</button>
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


							<!--end::Modal - Update password-->
							<!--begin::Modal - Update role-->
							<div class="modal fade" id="kt_modal_update_role" tabindex="-1" aria-hidden="true">
								<!--begin::Modal dialog-->
								<div class="modal-dialog modal-dialog-centered mw-650px">
									<!--begin::Modal content-->
									<div class="modal-content">
										<!--begin::Modal header-->
										<div class="modal-header">
											<!--begin::Modal title-->
											<h2 class="fw-bolder">Update User Role</h2>
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
											<form id="kt_modal_update_role_form" class="form" action="#">
												<!--begin::Notice-->
												<!--begin::Notice-->
												<div class="notice d-flex bg-light-primary rounded border-primary border border-dashed mb-9 p-6">
													<!--begin::Icon-->
													<!--begin::Svg Icon | path: icons/duotone/Code/Warning-1-circle.svg-->
													<span class="svg-icon svg-icon-2tx svg-icon-primary me-4">
														<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
															<circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10" />
															<rect fill="#000000" x="11" y="7" width="2" height="8" rx="1" />
															<rect fill="#000000" x="11" y="16" width="2" height="2" rx="1" />
														</svg>
													</span>
													<!--end::Svg Icon-->
													<!--end::Icon-->
													<!--begin::Wrapper-->
													<div class="d-flex flex-stack flex-grow-1">
														<!--begin::Content-->
														<div class="fw-bold">
															<div class="fs-6 text-gray-600">Please note that reducing a user role rank, that user will lose all priviledges that was assigned to the previous role.</div>
														</div>
														<!--end::Content-->
													</div>
													<!--end::Wrapper-->
												</div>
												<!--end::Notice-->
												<!--end::Notice-->
												<!--begin::Input group-->
												<div class="fv-row mb-7">
													<!--begin::Label-->
													<label class="fs-6 fw-bold form-label mb-5">
														<span class="required">Select a user role</span>
													</label>
													<!--end::Label-->
													<!--begin::Input row-->
													<div class="d-flex">
														<!--begin::Radio-->
														<div class="form-check form-check-custom form-check-solid">
															<!--begin::Input-->
															<input class="form-check-input me-3" name="user_role" type="radio" value="0" id="kt_modal_update_role_option_0" checked='checked' />
															<!--end::Input-->
															<!--begin::Label-->
															<label class="form-check-label" for="kt_modal_update_role_option_0">
																<div class="fw-bolder text-gray-800">Administrator</div>
																<div class="text-gray-600"></div>
															</label>
															<!--end::Label-->
														</div>
														<!--end::Radio-->
													</div>
													<!--end::Input row-->
													<div class='separator separator-dashed my-5'></div>
													<!--begin::Input row-->
													<div class="d-flex">
														<!--begin::Radio-->
														<div class="form-check form-check-custom form-check-solid">
															<!--begin::Input-->
															<input class="form-check-input me-3" name="user_role" type="radio" value="1" id="kt_modal_update_role_option_1" />
															<!--end::Input-->
															<!--begin::Label-->
															<label class="form-check-label" for="kt_modal_update_role_option_1">
																<div class="fw-bolder text-gray-800">Developer</div>
																<div class="text-gray-600">Best for developers or people primarily using the API</div>
															</label>
															<!--end::Label-->
														</div>
														<!--end::Radio-->
													</div>
													<!--end::Input row-->
													<div class='separator separator-dashed my-5'></div>
													<!--begin::Input row-->
													<div class="d-flex">
														<!--begin::Radio-->
														<div class="form-check form-check-custom form-check-solid">
															<!--begin::Input-->
															<input class="form-check-input me-3" name="user_role" type="radio" value="2" id="kt_modal_update_role_option_2" />
															<!--end::Input-->
															<!--begin::Label-->
															<label class="form-check-label" for="kt_modal_update_role_option_2">
																<div class="fw-bolder text-gray-800">Analyst</div>
																<div class="text-gray-600">Best for people who need full access to analytics data, but don't need to update business settings</div>
															</label>
															<!--end::Label-->
														</div>
														<!--end::Radio-->
													</div>
													<!--end::Input row-->
													<div class='separator separator-dashed my-5'></div>
													<!--begin::Input row-->
													<div class="d-flex">
														<!--begin::Radio-->
														<div class="form-check form-check-custom form-check-solid">
															<!--begin::Input-->
															<input class="form-check-input me-3" name="user_role" type="radio" value="3" id="kt_modal_update_role_option_3" />
															<!--end::Input-->
															<!--begin::Label-->
															<label class="form-check-label" for="kt_modal_update_role_option_3">
																<div class="fw-bolder text-gray-800">Support</div>
																<div class="text-gray-600">Best for employees who regularly refund payments and respond to disputes</div>
															</label>
															<!--end::Label-->
														</div>
														<!--end::Radio-->
													</div>
													<!--end::Input row-->
													<div class='separator separator-dashed my-5'></div>
													<!--begin::Input row-->
													<div class="d-flex">
														<!--begin::Radio-->
														<div class="form-check form-check-custom form-check-solid">
															<!--begin::Input-->
															<input class="form-check-input me-3" name="user_role" type="radio" value="4" id="kt_modal_update_role_option_4" />
															<!--end::Input-->
															<!--begin::Label-->
															<label class="form-check-label" for="kt_modal_update_role_option_4">
																<div class="fw-bolder text-gray-800">Trial</div>
																<div class="text-gray-600">Best for people who need to preview content data, but don't need to make any updates</div>
															</label>
															<!--end::Label-->
														</div>
														<!--end::Radio-->
													</div>
													<!--end::Input row-->
												</div>
												<!--end::Input group-->
												<!--begin::Actions-->
												<div class="text-center pt-15">
													<button type="reset" class="btn btn-white me-3" data-kt-users-modal-action="cancel">Discard</button>
													<button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
														<span class="indicator-label">Submit</span>
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
							<!--begin::Modal - Add task-->
							<div class="modal fade" id="kt_modal_add_auth_app" tabindex="-1" aria-hidden="true">
								<!--begin::Modal dialog-->
								<div class="modal-dialog modal-dialog-centered mw-650px">
									<!--begin::Modal content-->
									<div class="modal-content">
										<!--begin::Modal header-->
										<div class="modal-header">
											<!--begin::Modal title-->
											<h2 class="fw-bolder">Add Authenticator App</h2>
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
											<!--begin::Content-->
											<div class="fw-bolder d-flex flex-column justify-content-center mb-5">
												<!--begin::Label-->
												<div class="text-center mb-5" data-kt-add-auth-action="qr-code-label">Download the
												<a href="#">Authenticator app</a>, add a new account, then scan this barcode to set up your account.</div>
												<div class="text-center mb-5 d-none" data-kt-add-auth-action="text-code-label">Download the
												<a href="#">Authenticator app</a>, add a new account, then enter this code to set up your account.</div>
												<!--end::Label-->
												<!--begin::QR code-->
												<div class="d-flex flex-center" data-kt-add-auth-action="qr-code">
													<img src="{{asset('')}}media/misc/qr-code.png" alt="Scan this QR code" />
												</div>
												<!--end::QR code-->
												<!--begin::Text code-->
												<div class="border rounded p-5 d-flex flex-center d-none" data-kt-add-auth-action="text-code">
													<div class="fs-1">gi2kdnb54is709j</div>
												</div>
												<!--end::Text code-->
											</div>
											<!--end::Content-->
											<!--begin::Action-->
											<div class="d-flex flex-center">
												<div class="btn btn-light-primary" data-kt-add-auth-action="text-code-button">Enter code manually</div>
												<div class="btn btn-light-primary d-none" data-kt-add-auth-action="qr-code-button">Scan barcode instead</div>
											</div>
											<!--end::Action-->
										</div>
										<!--end::Modal body-->
									</div>
									<!--end::Modal content-->
								</div>
								<!--end::Modal dialog-->
							</div>
							<!--end::Modal - Add task-->
							<!--begin::Modal - Add task-->
							<div class="modal fade" id="kt_modal_add_one_time_password" tabindex="-1" aria-hidden="true">
								<!--begin::Modal dialog-->
								<div class="modal-dialog modal-dialog-centered mw-650px">
									<!--begin::Modal content-->
									<div class="modal-content">
										<!--begin::Modal header-->
										<div class="modal-header">
											<!--begin::Modal title-->
											<h2 class="fw-bolder">Enable One Time Password</h2>
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
									
										<!--end::Modal body-->
									</div>
									<!--end::Modal content-->
								</div>
								<!--end::Modal dialog-->
							</div>
							<!--end::Modal - Add task-->
							<!--end::Modals-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Content-->
					<!--begin::Footer-->
					<!--end::Footer-->
			
		<!--end::Root-->
		<!--begin::Drawers-->
		<!--begin::Activities drawer-->
		@endforeach

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
		<script src="{{asset('')}}js/custom/apps/user-management/users/view/view.js"></script>
		<script src="{{asset('')}}js/custom/apps/user-management/users/view/update-details.js"></script>
		<script src="{{asset('')}}js/custom/apps/user-management/users/view/add-schedule.js"></script>
		<script src="{{asset('')}}js/custom/apps/user-management/users/view/add-task.js"></script>
		<script src="{{asset('')}}js/custom/apps/user-management/users/view/update-email.js"></script>
		<script src="{{asset('')}}js/custom/apps/user-management/users/view/update-password.js"></script>
		<script src="{{asset('')}}js/custom/apps/user-management/users/view/update-role.js"></script>
		<script src="{{asset('')}}js/custom/apps/user-management/users/view/add-auth-app.js"></script>
		<script src="{{asset('')}}js/custom/apps/user-management/users/view/add-one-time-password.js"></script>
		<script src="{{asset('')}}js/custom/widgets.js"></script>
		
		<script src="{{asset('')}}js/custom/apps/chat/chat.js"></script>
		<script src="{{asset('')}}js/custom/modals/create-app.js"></script>
		<script src="{{asset('')}}js/custom/modals/upgrade-plan.js"></script>


		<!--end::Page Custom Javascript-->
		<!--end::Javascript-->
		<!-- additional by hussain -->
	
		
	<script type="text/javascript" >
		
$(document).ready(function() {
	@foreach($admins as $admin)

@if($admin->image == '' || $admin->image == NULL) 
 
 	var firstName = $('#first_user_name').text();
	var intials = $('#first_user_name').text().charAt(0);
	var profileImage = $('.profile_image').text(intials);

	
	@endif
@endforeach
	
})

	</script>

	
		

		


<script>

	
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


		  $('#user_name').val(result.name);
		  $('#user_email').val(result.email);
							// $('current_role').val(result.access_level);

							console.log(`role_${result.access_level_id}`);

		  document.getElementById("form_head").innerHTML = "Edit User";
		

		  document.getElementById('preview_img').style.backgroundImage=`url({{config('custom.asset_url')}}${result.image})`; 
		  document.getElementById(`role_${result.access_level_id}`).checked = true;
	
		//   document.getElementById('avatar').style.backgroundImage=`url({{config('custom.asset_url')}}${result.image})`; // specify the image path here

	   }
	});
}


$("#password_form").on('submit', function(e){
     e.preventDefault();
     console.log(this.id);
	//  console.log(html_bb);
     var data = $('#password_form').serialize();

     $.ajax({type: "POST",url: this.action,data :data ,success: function(result){if(result.success){
     	$('#password_modal').modal('hide');

									Swal.fire({
													text: result.message,
													icon: "success",
													buttonsStyling: !1,
													confirmButtonText: "Ok, got it!",
													customClass: {
														confirmButton: "btn btn-light"
													}
						})
					}else{Swal.fire({
											text: result.message,
											icon: "error",
											buttonsStyling: !1,
											confirmButtonText: "Ok, got it!",
											customClass: {
												confirmButton: "btn btn-light"
											}
										})}}})

  });

</script>
@stop