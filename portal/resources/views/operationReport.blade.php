
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
				<h1 class="text-dark fw-bolder my-0 fs-2">Operation Report</h1>
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
						
						<!--begin::Info-->
						<div class="flex-grow-1">
							<!--begin::Title-->
							<div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
							
										</div>
										<!--end::Title-->
										<div class="row">
											<div class="col-md-3 mt-5">
												@if(session()->has('isAdmin') && session()->get('isAdmin') == 1)
												<div class="d-flex flex-wrap flex-stack">

													<!--begin::Progress-->
													<div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
														<div class="d-flex justify-content-between w-100 mt-auto mb-2">
															<span class="fw-bold fs-6 text-gray-400">Sort By User</span>

														</div>
														<div class="h-5px mx-3 w-100 mb-3">
															<select class="form-select form-select-solid" data-control="select2" data-placeholder="" data-hide-search="true" id="admin_id" name="admin_id">
																<option value="">Select</option>
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
											<div class="col-md-3 mt-5">
												<div class="d-flex flex-wrap flex-stack">

													<!--begin::Progress-->
													<div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
														<div class="d-flex justify-content-between w-100 mt-auto mb-2">
															<span class="fw-bold fs-6 text-gray-400">From</span>

														</div>
														<div class="h-5px mx-3 w-100 mb-3">
															<input type="text" class="form-control" id="kt_daterangepicker_from" value="">
														</div>
													</div>
													<!--end::Progress-->
												</div>
											</div>
											<div class="col-md-3 mt-4">
												<div class="d-flex flex-wrap flex-stack">

													<!--begin::Progress-->
													<div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
														<div class="d-flex justify-content-between w-100 mt-auto mb-2">
															<span class="fw-bold fs-6 text-gray-400">To</span>

														</div>
														<div class="h-5px mx-3 w-100 mb-3">
															<input type="text" class="form-control" id="kt_daterangepicker_to" value="">
														</div>
													</div>
													<!--end::Progress-->
												</div>
											</div>
											
											<div class="col-md-3 mt-4">
												<div class="d-flex flex-wrap flex-stack">
													<div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
														<div class="d-flex justify-content-between w-100 mt-auto mb-8">
														</div>
														<div class="h-5px mx-3 w-100 mb-3">
												<button type="submit" value="Generate" class="btn btn-success" onclick="loadActivity()">Generate</button>
											</div>
											</div>
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
											<a class="nav-link text-active-primary me-6 active">
											<!-- Activity -->
										</a>
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
					$('#kt_daterangepicker_from').flatpickr({enableTime:!0,dateFormat:"Y-m-d H:i"});
					$('#kt_daterangepicker_to').flatpickr({enableTime:!0,dateFormat:"Y-m-d H:i"});

					// $("#kt_daterangepicker_1").daterangepicker();

					
					function loadActivity()
					{
						var admin_id = $('#admin_id').val(); 
						var from = $('#kt_daterangepicker_from').val();
						var to = $('#kt_daterangepicker_to').val();
						url = `{{url('getHistory')}}`+'?from='+from+'&to='+to+'&admin_id='+admin_id
						window.open(url, '_blank');
						// window.location.href = 
						// $.ajax({
						// 	type: "POST",
						// 	url: `{{url('getHistory')}}`,
						// 	data:{_token:'<?php echo csrf_token();?>', admin_id : admin_id, from : from, to : to},
						// 	success: function(result){
						// 		// console.log(result)
						// 		// $('#activity_log_data').html(result.data);
						// 	}
						// }) 
			// window.location.href = '{{url("activity_log?admin_id=")}}'+admin_id+'&search='+date
		}
	</script>
	@stop
	<!--end::Footer-->
	<!-- </div> -->
	<!--end::Wrapper-->
	@stop
