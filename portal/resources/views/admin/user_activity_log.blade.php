
@extends('layout.app')
@extends('layout.sidebar')
@include('layout.toolbar')	
@extends('layout.footer')

@section('pageCss')
<base href="../../../">
<meta charset="utf-8" />
<title>{{ config('custom.title');}}</title>
<!--begin::Fonts-->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700" />
<!--end::Fonts-->
<!--begin::Global Stylesheets Bundle(used by all pages)-->
<link href="{{asset('')}}plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
<link href="{{asset('')}}css/style.bundle.css" rel="stylesheet" type="text/css" />
<!--end::Global Stylesheets Bundle-->
@stop

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
				<h1 class="text-dark fw-bolder my-0 fs-2">Activity</h1>
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
			<!--begin::Toolbar wrapper-->
			@include('layout.toolbar')	
			@yield('toolbar')
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
			<div class="card mb-6">
				<div class="card-body pt-9 pb-0">
					<!--begin::Details-->
					<div class="d-flex flex-wrap flex-sm-nowrap mb-3">
						<!--begin: Pic-->
						<div class="me-7 mb-4">
							<div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
								<img src="{{($admin->image != '' ? config('custom.asset_url').$admin->image : 'https://place-hold.it/150x150')}}" alt="image" />
								<div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-white h-20px w-20px"></div>
							</div>
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
										<a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bolder me-1">{{$admin->name}}</a>
										<a href="#">
											<!--begin::Svg Icon | path: icons/duotone/Design/Verified.svg-->
											<span class="svg-icon svg-icon-1 svg-icon-primary">
												<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
													<path d="M10.0813 3.7242C10.8849 2.16438 13.1151 2.16438 13.9187 3.7242V3.7242C14.4016 4.66147 15.4909 5.1127 16.4951 4.79139V4.79139C18.1663 4.25668 19.7433 5.83365 19.2086 7.50485V7.50485C18.8873 8.50905 19.3385 9.59842 20.2758 10.0813V10.0813C21.8356 10.8849 21.8356 13.1151 20.2758 13.9187V13.9187C19.3385 14.4016 18.8873 15.491 19.2086 16.4951V16.4951C19.7433 18.1663 18.1663 19.7433 16.4951 19.2086V19.2086C15.491 18.8873 14.4016 19.3385 13.9187 20.2758V20.2758C13.1151 21.8356 10.8849 21.8356 10.0813 20.2758V20.2758C9.59842 19.3385 8.50905 18.8873 7.50485 19.2086V19.2086C5.83365 19.7433 4.25668 18.1663 4.79139 16.4951V16.4951C5.1127 15.491 4.66147 14.4016 3.7242 13.9187V13.9187C2.16438 13.1151 2.16438 10.8849 3.7242 10.0813V10.0813C4.66147 9.59842 5.1127 8.50905 4.79139 7.50485V7.50485C4.25668 5.83365 5.83365 4.25668 7.50485 4.79139V4.79139C8.50905 5.1127 9.59842 4.66147 10.0813 3.7242V3.7242Z" fill="#00A3FF" />
													<path class="permanent" d="M14.8563 9.1903C15.0606 8.94984 15.3771 8.9385 15.6175 9.14289C15.858 9.34728 15.8229 9.66433 15.6185 9.9048L11.863 14.6558C11.6554 14.9001 11.2876 14.9258 11.048 14.7128L8.47656 12.4271C8.24068 12.2174 8.21944 11.8563 8.42911 11.6204C8.63877 11.3845 8.99996 11.3633 9.23583 11.5729L11.3706 13.4705L14.8563 9.1903Z" fill="white" />
												</svg>
											</span>
											<!--end::Svg Icon-->
										</a>
									</div>
									<!--end::Name-->
									<!--begin::Info-->
									<div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2">
										<a class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
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
											<!--end::Svg Icon-->{{strtoupper($admin->access_level)}}</a>
											<a class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
												<!--begin::Svg Icon | path: icons/duotone/Map/Marker1.svg-->
												<span class="svg-icon svg-icon-4 me-1">
													<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
														<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
															<rect x="0" y="0" width="24" height="24" />
															<path d="M5,10.5 C5,6 8,3 12.5,3 C17,3 20,6.75 20,10.5 C20,12.8325623 17.8236613,16.03566 13.470984,20.1092932 C12.9154018,20.6292577 12.0585054,20.6508331 11.4774555,20.1594925 C7.15915182,16.5078313 5,13.2880005 5,10.5 Z M12.5,12 C13.8807119,12 15,10.8807119 15,9.5 C15,8.11928813 13.8807119,7 12.5,7 C11.1192881,7 10,8.11928813 10,9.5 C10,10.8807119 11.1192881,12 12.5,12 Z" fill="#000000" fill-rule="nonzero" />
														</g>
													</svg>
												</span>
												<!--end::Svg Icon-->{{$admin->state}}</a>
												<a class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
													<!--begin::Svg Icon | path: icons/duotone/Communication/Mail-at.svg-->
													<span class="svg-icon svg-icon-4 me-1">
														<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
															<path d="M11.575,21.2 C6.175,21.2 2.85,17.4 2.85,12.575 C2.85,6.875 7.375,3.05 12.525,3.05 C17.45,3.05 21.125,6.075 21.125,10.85 C21.125,15.2 18.825,16.925 16.525,16.925 C15.4,16.925 14.475,16.4 14.075,15.65 C13.3,16.4 12.125,16.875 11,16.875 C8.25,16.875 6.85,14.925 6.85,12.575 C6.85,9.55 9.05,7.1 12.275,7.1 C13.2,7.1 13.95,7.35 14.525,7.775 L14.625,7.35 L17,7.35 L15.825,12.85 C15.6,13.95 15.85,14.825 16.925,14.825 C18.25,14.825 19.025,13.725 19.025,10.8 C19.025,6.9 15.95,5.075 12.5,5.075 C8.625,5.075 5.05,7.75 5.05,12.575 C5.05,16.525 7.575,19.1 11.575,19.1 C13.075,19.1 14.625,18.775 15.975,18.075 L16.8,20.1 C15.25,20.8 13.2,21.2 11.575,21.2 Z M11.4,14.525 C12.05,14.525 12.7,14.35 13.225,13.825 L14.025,10.125 C13.575,9.65 12.925,9.425 12.3,9.425 C10.65,9.425 9.45,10.7 9.45,12.375 C9.45,13.675 10.075,14.525 11.4,14.525 Z" fill="#000000" />
														</svg>
													</span>
													<!--end::Svg Icon-->{{$admin->email}}</a>
												</div>
												<!--end::Info-->
											</div>
											<!--end::User-->
										</div>
										<!--end::Title-->
										<div class="row">
											<div class="col-md-6">
												@if(session()->has('isAdmin') && session()->get('isAdmin') == 1)
												<div class="d-flex flex-wrap flex-stack">

													<!--begin::Progress-->
													<div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
														<div class="d-flex justify-content-between w-100 mt-auto mb-2">
															<span class="fw-bold fs-6 text-gray-400">Sort By User</span>

														</div>
														<div class="h-5px mx-3 w-100 mb-3">
															<select name="admin-selection" id="admin-selection" multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1" onchange="loadActivity()">
																<?php 
																?>
																@foreach($admins as $ad)
																<option value="{{$ad->id}}">{{$ad->name}}</option>
																@endforeach
															</select>
														</div>
													</div>
													<!--end::Progress-->
												</div>
												@endif
											</div>
											<div class="col-md-6">
												<div class="d-flex flex-wrap flex-stack">

													<!--begin::Progress-->
													<div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
														<div class="d-flex justify-content-between w-100 mt-auto mb-2">
															<span class="fw-bold fs-6 text-gray-400">From - To</span>

														</div>
														<div class="h-5px mx-3 w-100 mb-3">
															<input type="text" class="form-control" id="kt_daterangepicker_1" value="">
														</div>
													</div>
													<!--end::Progress-->
												</div>
											</div>
											<div class="col-md-6 mt-6">
												<div class="d-flex flex-wrap flex-stack">

													<!--begin::Progress-->
													<div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
														<div class="d-flex justify-content-between w-100 mt-auto mb-2">
															<span class="fw-bold fs-6 text-gray-400">Sort By</span>

														</div>
														<div class="h-5px mx-3 w-100 mb-3">
															<select name="sort_by" id="sort_by" multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1" onchange="loadActivity()">
																<option value="shift_add">Shift Add</option>
																<option value="shift_delete">Shift Delete</option>
																<option value="shift_change">Shift Change</option>
																<option value="guard_delete">Guard Delete</option>
																<option value="guard_blocking">Guard Blocking</option>
																<option value="guard_creation">Guard Creation</option>
																<option value="guard_update">Guard Update</option>
																<option value="guard_admin_approval">Guard Admin Approval</option>
															</select>
														</div>
													</div>
													<!--end::Progress-->
												</div>

											</div>
										</div>
										<!--  -->

									</div>
									<!--end::Info-->
								</div>
								<!--end::Details-->
								<!--begin::Navs-->
								<div class="d-flex overflow-auto h-55px">
									<ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder flex-nowrap">
										<!--begin::Nav item-->
										<li class="nav-item">
											<a class="nav-link text-active-primary me-6 active">Activity</a>
										</li>
										<!--end::Nav item-->
									</ul>
								</div>
								<!--begin::Navs-->
							</div>
						</div>
						<!--end::Navbar-->
						<!--begin::Timeline-->
						<div class="card mt-5 mt-xxl-8">
							<!--begin::Card head-->
							<div class="card-header card-header-stretch" style="display: none !important;">
								<!--begin::Title-->
								<div class="card-title d-flex align-items-center">
									<!--begin::Svg Icon | path: icons/duotone/Interface/Calendar.svg-->
									<span class="svg-icon svg-icon-1 svg-icon-primary me-3 lh-0">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
											<path opacity="0.25" fill-rule="evenodd" clip-rule="evenodd" d="M6 3C6 2.44772 6.44772 2 7 2C7.55228 2 8 2.44772 8 3V4H16V3C16 2.44772 16.4477 2 17 2C17.5523 2 18 2.44772 18 3V4H19C20.6569 4 22 5.34315 22 7V19C22 20.6569 20.6569 22 19 22H5C3.34315 22 2 20.6569 2 19V7C2 5.34315 3.34315 4 5 4H6V3Z" fill="#191213" />
											<path fill-rule="evenodd" clip-rule="evenodd" d="M10 12C9.44772 12 9 12.4477 9 13C9 13.5523 9.44772 14 10 14H17C17.5523 14 18 13.5523 18 13C18 12.4477 17.5523 12 17 12H10ZM7 16C6.44772 16 6 16.4477 6 17C6 17.5523 6.44772 18 7 18H13C13.5523 18 14 17.5523 14 17C14 16.4477 13.5523 16 13 16H7Z" fill="#121319" />
										</svg>
									</span>
									<!--end::Svg Icon-->
									<h3 class="fw-bolder m-0 text-gray-800">Jan 23, 2021</h3>
								</div>
								<!--end::Title-->
							</div>
							<!--end::Card head-->
							<!--begin::Card body-->
							<div class="card-body">
								<!--begin::Tab Content-->
								<div class="tab-content">
									<!--begin::Tab panel-->
									<div id="kt_activity_today" class="card-body p-0 tab-pane fade show active" role="tabpanel" aria-labelledby="kt_activity_today_tab">
										<!--begin::Timeline-->
										<div class="timeline" id="activity_log_data">

										</div>
										<!--end::Timeline-->
									</div>
									<!--end::Tab panel-->
								</div>
								<!--end::Tab Content-->
							</div>
							<!--end::Card body-->
						</div>
						<!--end::Timeline-->
					</div>
					<!--end::Container-->
				</div>
				<!--end::Content-->
				<!--begin::Footer-->
				@section('pageFooter')
				<!--end::Scrolltop-->
				<!--end::Main-->
				<!--begin::Javascript-->
				<!--begin::Global Javascript Bundle(used by all pages)-->
				<script src="{{asset('')}}plugins/global/plugins.bundle.js"></script>
				<script src="{{asset('')}}js/scripts.bundle.js"></script>
				<!--end::Global Javascript Bundle-->
				<!--begin::Page Custom Javascript(used by this page)-->
				<script src="{{asset('')}}js/custom/modals/offer-a-deal.bundle.js"></script>
				<script src="{{asset('')}}js/custom/widgets.js"></script>
				<script src="{{asset('')}}js/custom/apps/chat/chat.js"></script>
				<script src="{{asset('')}}js/custom/modals/create-app.js"></script>
				<script src="{{asset('')}}js/custom/modals/upgrade-plan.js"></script>
				<!--end::Page Custom Javascript-->
				<!--end::Javascript-->
				<script type="text/javascript">
					$("#kt_daterangepicker_1").daterangepicker();

					$( document ).ready(function() {
						MultiselectDropdown();
						$('#kt_daterangepicker_1').on('change', function(){
							loadActivity();
						});

					});
					function loadActivity()
					{
						var admin_id = $('#admin-selection').val(); 
						var date = $('#kt_daterangepicker_1').val();
						var sort_by = $('#sort_by').val();
						$.ajax({
							type: "POST",
							url: `{{url('activity_log')}}`,
							data:{_token:'<?php echo csrf_token();?>', admin_id : admin_id, search : date, sort_by : sort_by},
							success: function(result){
								// console.log(result)
								$('#activity_log_data').html(result.data);
							}
						}) 
			// window.location.href = '{{url("activity_log?admin_id=")}}'+admin_id+'&search='+date
		}
	</script>
	@stop
	<!--end::Footer-->
	<!-- </div> -->
	<!--end::Wrapper-->
	@stop
