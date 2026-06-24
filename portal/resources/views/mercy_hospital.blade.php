<!DOCTYPE html>

<html lang="en">
<!--begin::Head-->
<head><base href="">
	<meta charset="utf-8" />
	<title>{{ config('custom.title')}}</title>
	<meta name="description" content="{{ config('custom.title') }}" />
	<meta name="keywords" content="{{ config('custom.title')}}" />
	<link rel="canonical" href="Https://preview.keenthemes.com/metronic8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="shortcut icon" href="{{config('custom.logo')}}" />
	<!--begin::Fonts-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700" />
	<!--end::Fonts-->
	<!--begin::Page Vendor Stylesheets(used by this page)-->
	<link href="{{ asset(''); }}plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
	<!--end::Page Vendor Stylesheets-->
	<!--begin::Global Stylesheets Bundle(used by all pages)-->
	<link href="{{ asset(''); }}plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="{{ asset(''); }}css/style.bundle.css" rel="stylesheet" type="text/css" />
	<!--end::Global Stylesheets Bundle-->
	<style type="text/css">
		body, label, span{
			color: #dfdfdf !important;
		}
		.card{
			/*background-color: #3C4256;*/
			/* background: rgba(0, 0, 0, .6);*/
		}
		.page{
			/*background-color: #000000;*/
		}
		span.select2-selection__rendered{
			color: #000000 !important;
		}
		.input--file {
			position: relative;
			color: #7f7f7f;
		}

		.input--file input[type="file"] {
			position: absolute;
			top: 0;
			left: 0;
			opacity: 0;
		}

	</style>
</head>

<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-enabled">
	<!--begin::Main-->
	<!--begin::Root-->
	<div class="d-flex flex-column flex-root">
		<!--begin::Page-->
		<div class="page d-flex flex-row flex-column-fluid" style="background: url('https://{{request()->getHttpHost()}}/asset_uploads/mercy_hospital_northwest_arkansas__inpatient_tower_addition_0264.jpeg'); background-size:cover;">

			<!--begin::Wrapper-->
			<div class="d-flex flex-column flex-row-fluid" id="kt_wrapper" style=" background: rgba(0, 0, 0, .6);">

				<!--begin::Content-->
				<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
					<!--begin::Container-->
					<div class="container" id="kt_content_container">
						
						<!--begin::Row-->
						<div class="row g-5 gx-xxl-8" >

							<!--begin::Col-->
							<div class="col-xxl-8" style="margin: 0 auto;">
								<!--begin::Tables Widget 5-->
								<div class="card card-xxl-stretch mb-5 mb-xxl-8">
									<!--begin::Header-->
									<div class="text-center border-0 pt-5 mt-10">
										<h3 class="card-title align-items-start flex-column">
											<span class="card-label fw-bolder fs-3 mb-1">Welcome to Mercy Hospital Attendance Portal</span>
											<!-- <span class="text-muted mt-1 fw-bold fs-7">More than 400 new products</span> -->
										</h3>

									</div>
									<!--end::Header-->
									<!--begin::Body-->
									<div class="card-body py-3">
										<div class="tab-content">
											<!--begin::Tap pane-->
											<div class="tab-pane fade show active" id="kt_table_widget_5_tab_1">
												<!--begin::Plans-->
												<div class="d-flex flex-column">
													<!--begin::Input group-->
													<div class="fv-row mb-15" data-kt-buttons="true">
														<div class="row">
															<div class="col-6">
																<!--begin::Option-->
																<label class="btn btn-outline btn-outline-dashed btn-outline-default d-flex text-start p-6 mb-6" onclick="showFrom('core-form','adhoc-form')">
																	<!--begin::Input-->
																	<input class="btn-check" type="radio" checked="checked" name="project_type" value="1" />
																	<!--end::Input-->
																	<!--begin::Label-->
																	<span class="d-flex">
																		<!--begin::Icon-->
																		<!--begin::Svg Icon | path: icons/duotone/General/User.svg-->
																		<!-- <span class="svg-icon svg-icon-3hx">
																			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																				<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																					<rect x="5" y="5" width="5" height="5" rx="1" fill="#000000" />
																					<rect x="14" y="5" width="5" height="5" rx="1" fill="#000000" opacity="0.3" />
																					<rect x="5" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3" />
																					<rect x="14" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3" />
																				</g>
																			</svg>
																		</span> -->
																		<!--end::Svg Icon-->
																		<!--end::Icon-->
																		<!--begin::Info-->
																		<span class="ms-4">
																			<span class="fs-3 fw-bolder  mb-2 d-block">Core</span>
																			<!-- <span class="fw-bold fs-4 text-gray-400">If you need more info, please check it out</span> -->
																		</span>
																		<!--end::Info-->
																	</span>
																	<!--end::Label-->
																</label>
																<!--end::Option-->
															</div>
															<div class="col-6">
																<!--begin::Option-->
																<label class="btn btn-outline btn-outline-dashed btn-outline-default d-flex text-start p-6" onclick="showFrom('adhoc-form', 'core-form')">
																	<!--begin::Input-->
																	<input class="btn-check" type="radio" name="project_type" value="2" />
																	<!--end::Input-->
																	<!--begin::Label-->
																	<span class="d-flex">
																		<!--begin::Icon-->
																		<!--begin::Svg Icon | path: icons/duotone/Layout/Layout-4-blocks-2.svg-->
																		<!-- <span class="svg-icon svg-icon-3hx">
																			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																				<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																					<rect x="5" y="5" width="5" height="5" rx="1" fill="#000000" />
																					<rect x="14" y="5" width="5" height="5" rx="1" fill="#000000" opacity="0.3" />
																					<rect x="5" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3" />
																					<rect x="14" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3" />
																				</g>
																			</svg>
																		</span> -->
																		<!--end::Svg Icon-->
																		<!--end::Icon-->
																		<!--begin::Info-->
																		<span class="ms-4">
																			<span class="fs-3 fw-bolder  mb-2 d-block">Ad-hoc</span>
																			<!-- <span class="fw-bold fs-4 text-gray-400">Create corporate account to manage users</span> -->
																		</span>
																		<!--end::Info-->
																	</span>
																	<!--end::Label-->
																</label>
																<!--end::Option-->
															</div>
														</div>
													</div>
													<!--end::Input group-->
													<!-- end of it -->
													<!--begin::Nav group-->
													<!-- <div class="nav-group nav-group-outline mx-auto" data-kt-buttons="true">
														<a href="#" class="btn btn-color-gray-400 btn-active btn-active-secondary px-6 py-3 me-2 active" data-kt-plan="month">Core</a>
														<a href="#" class="btn btn-color-gray-400 btn-active btn-active-secondary px-6 py-3" data-kt-plan="annual">Ad-hoc</a>
													</div> -->
													<!--end::Nav group-->
													<!--begin::Row-->
													<div class="row mt-10" id="core-form" style="display: none;">
														<form id="core-form" class="form" action="{{url('mercy_hospital_signin_form')}}" method="POST" enctype="multipart/form-data">
															<!--begin::Col-->
															<input type="hidden" name="type" value="core">
															<input type="hidden" name="site_id" value="{{$core_site->id}}">
															<input type="hidden" name="signin_time" value="{{time()}}">
															<input type="hidden" name="core_action" id="core_action" value="signin">
															<input type="hidden" name="core_roster_id" id="core_roster_id" value="">
															<div class="col-lg-12 mb-10 mb-lg-0">
															<!-- <div class="nav flex-column">
																<div class="col-sm-12 col-md-12 col-lg-12">
																	<label class="fs-6 form-label fw-bolder ">Signin Time</label>
																	<h4>{{date('d/m/Y H:i a')}}</h4>
																	</div>
																</div>
																<hr> -->
																<!--begin::Tabs-->
																<div class="nav flex-column">
																	<div class="col-sm-12 col-md-12 col-lg-12">
																		<label class="fs-6 form-label fw-bolder ">Signin Location</label>
																		<h4>Mercy Hospital Werribee</h4>
																		<!-- <h4>{{$core_site->site_name}} ({{$core_site->site_description}}) - {{$core_site->address}}</h4> -->

																	</div>
																</div>
																<!--end::Tabs-->
																<hr>
																<!--begin::Tabs-->
																<div class="nav flex-column">
																	<div class="row">
																		<div class="col-sm-12 col-md-8 col-lg-8">
																			<label class="fs-6 form-label fw-bolder ">Select Security Officer</label>
																			<!--begin::Select-->
																			<select class="form-select form-select-solid" data-control="select2" data-placeholder="" id="guard_id" name="guard_id" tabindex="0" aria-hidden="false" required="" onchange="checkCoreGuardShift()">
																				<option value="">Select Security Officer</option>
																				@foreach($core_guards as $key => $guard)
																				<option value="{{$guard->id}}">{{$guard->name}}</option>
																				@endforeach
																			</select>
																		</div>
																		<div class="col-sm-12 col-md-4 col-lg-4 text-center">
																			<div class="symbol symbol-100px overflow-hidden me-3 mt-2">
																				<div class="symbol-label ">
																					<img src="" id="core-image-preview" alt="" class="w-100">
																				</div>
																			</div>
																		</div>
																	</div>
																</div>

																<!--begin::Tabs-->
																<div class="nav flex-column">
																	<div class="row">
																		<!-- <div class="col-sm-12 col-md-12 col-lg-12">
																			<label class="fs-6 form-label fw-bolder ">Upload Picture</label>
																			<input type="file" accept="image/*" capture name="image" class="form-control" required="" id="core-image" >
																		</div> -->
																		<div class="col-sm-4 col-md-4 col-lg-4">
																			<label class="fs-6 form-label fw-bolder ">Take Picture</label>
																		</div>
																		<div class="col-sm-8 col-md-8 col-lg-8 text-center">
																			<!-- <label class="fs-6 form-label fw-bolder ">Take Picture</label> -->
																			<div class="input--file">
																				<span>
																					<svg fill="#ffffff" xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24">
																						<circle cx="12" cy="12" r="3.2"/>
																						<path d="M9 2l-1.83 2h-3.17c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2v-12c0-1.1-.9-2-2-2h-3.17l-1.83-2h-6zm3 15c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5z"/>
																						<path d="M0 0h24v24h-24z" fill="none"/>
																					</svg>
																				</span>
																				<input type="file" accept="image/*" capture="camera" name="image" class="form-control" required="" id="core-image" />
																			</div>
																		</div>
																		
																	</div>
																</div>
																<!--end::Tabs-->
																<!--begin::Actions-->
																<div class="d-flex flex-center flex-row-fluid pt-12">
																	<button type="submit" class="btn btn-primary" id="core-btn">Signin</button>
																</div>
																<!--end::Actions-->
															</div>
															<!--end::Col-->
														</form>
													</div>
													<!--end::Row-->

													<div class="row mt-10" id="adhoc-form" style="display: none;">
														<form id="adhoc-form" class="form" action="{{url('mercy_hospital_signin_form')}}" method="POST" enctype="multipart/form-data">
															<!--begin::Col-->
															<input type="hidden" name="type" value="adhoc">
															<input type="hidden" name="signin_time" value="{{time()}}">
															<input type="hidden" name="adhoc_action" id="adhoc-action" value="signin">
															<div class="col-lg-12 mb-10 mb-lg-0">
																<!--begin::Tabs-->
															<!-- <div class="nav flex-column">
																<div class="col-sm-12 col-md-12 col-lg-12">
																	<label class="fs-6 form-label fw-bolder ">Signin Time</label>
																	<h4>{{date('d/m/Y H:i a')}}</h4>
																	</div>
																</div> -->
																<!--end::Tabs-->
																<!-- <hr> -->
																
																<!--begin::Tabs-->
																<div class="nav flex-column">
																	<div class="row">
																		<div class="col-sm-12 col-md-8 col-lg-8">
																			<label class="fs-6 form-label fw-bolder ">Select Security Officer</label>
																			<!--begin::Select-->
																			<select class="form-select form-select-solid" data-control="select2" data-placeholder="" id="guard_id_adhoc" name="guard_id" tabindex="0" aria-hidden="false" required="" onchange="getGuardShift();">
																				<option value="">Select Security Officer</option>
																				@foreach($adhoc_guards as $key => $guard)
																				<option value="{{$guard->id}}">{{$guard->name}}</option>
																				@endforeach
																			</select>
																		</div>
																		<div class="col-sm-12 col-md-4 col-lg-4 text-center">
																			<div class="symbol symbol-100px overflow-hidden me-3 mt-2">
																				<div class="symbol-label ">
																					<img src="" id="adhoc-image-preview" alt="" class="w-100">
																				</div>
																			</div>
																		</div>
																	</div>
																	<!--begin::Tabs-->
																	<div class="nav flex-column">
																		<div class="col-sm-12 col-md-12 col-lg-12">
																			<label class="fs-6 form-label fw-bolder ">Shift Time</label>
																			<h4 id="shift_time"></h4>
																			<input type="hidden" name="roster_id" id="roster_id" required="">
																		</div>
																	</div>
																	<!--end::Tabs-->

																	<!--begin::Tabs-->
																	<div class="nav flex-column">
																		<div class="row">
																			<div class="col-sm-4 col-md-4 col-lg-4">
																				<label class="fs-6 form-label fw-bolder ">Take Picture</label>
																			</div>
																			<div class="col-sm-8 col-md-8 col-lg-8 text-center">
																				<!-- <label class="fs-6 form-label fw-bolder ">Take Picture</label> -->
																				<div class="input--file">
																					<span>
																						<svg fill="#ffffff" xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24">
																							<circle cx="12" cy="12" r="3.2"/>
																							<path d="M9 2l-1.83 2h-3.17c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2v-12c0-1.1-.9-2-2-2h-3.17l-1.83-2h-6zm3 15c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5z"/>
																							<path d="M0 0h24v24h-24z" fill="none"/>
																						</svg>
																					</span>
																					<input type="file" accept="image/*" capture="camera" name="image" class="form-control" required=""  />
																				</div>
																			</div>
																		</div>
																	<!-- <div class="col-sm-12 col-md-12 col-lg-12">
																		<label class="fs-6 form-label fw-bolder ">Upload Picture</label>
																		<input type="file" accept="image/*" capture name="image" class="form-control" required="">
																	</div> -->
																</div>
																<!--end::Tabs-->
																<!--begin::Actions-->
																<div class="d-flex flex-center flex-row-fluid pt-12">
																	<button type="submit" class="btn btn-primary" id="adhoc-btn">Signin</button>
																</div>
																<!--end::Actions-->
															</div>
															<!--end::Col-->
														</form>
													</div>
													<!--end::Row-->
												</div>
												<!--end::Plans-->

											</div>
											<!--end::Tap pane-->


										</div>
									</div>
									<!--end::Body-->
								</div>
								<!--end::Tables Widget 5-->
							</div>
							<!--end::Col-->
						</div>
						<!--end::Row-->
					</div>
					<!--end::Container-->
				</div>
				<!--end::Content-->
				<!--begin::Footer-->
				<div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
					<!--begin::Container-->
					<div class="container d-flex flex-column flex-md-row flex-stack" style="display: none !important;">
						<!--begin::Copyright-->
						<div class=" order-2 order-md-1">
							<span class="text-gray-400 fw-bold me-1">Created by</span>
							<a href="https://keenthemes.com" target="_blank" class="text-muted text-hover-primary fw-bold me-2 fs-6">Keenthemes</a>
						</div>
						<!--end::Copyright-->
						<!--begin::Menu-->
						<ul class="menu menu-gray-600 menu-hover-primary fw-bold order-1">
							<li class="menu-item">
								<a href="https://keenthemes.com" target="_blank" class="menu-link px-2">About</a>
							</li>
							<li class="menu-item">
								<a href="https://keenthemes.com/support" target="_blank" class="menu-link px-2">Support</a>
							</li>
							<li class="menu-item">
								<a href="https://1.envato.market/EA4JP" target="_blank" class="menu-link px-2">Purchase</a>
							</li>
						</ul>
						<!--end::Menu-->
					</div>
					<!--end::Container-->
				</div>
				<!--end::Footer-->
			</div>
			<!--end::Wrapper-->
		</div>
		<!--end::Page-->
	</div>
	<!--end::Root-->
	<!--begin::Drawers-->


	<!--end::Main-->
	<!--begin::Javascript-->
	<!--begin::Global Javascript Bundle(used by all pages)-->
	<script src="{{ asset(''); }}plugins/global/plugins.bundle.js"></script>
	<script src="{{ asset(''); }}js/scripts.bundle.js"></script>
	<!--end::Global Javascript Bundle-->
	<!--begin::Page Vendors Javascript(used by this page)-->
	<!-- <script src="{{ asset(''); }}plugins/custom/fullcalendar/fullcalendar.bundle.js"></script> -->
	<!--end::Page Vendors Javascript-->
	<!--begin::Page Custom Javascript(used by this page)-->
	<script src="{{ asset(''); }}js/custom/modals/create-project.bundle.js"></script>
	<script src="{{ asset(''); }}js/custom/modals/offer-a-deal.bundle.js"></script>
	<script src="{{ asset(''); }}js/custom/widgets.js"></script>
	<script src="{{ asset(''); }}js/custom/apps/chat/chat.js"></script>
	<script src="{{ asset(''); }}js/custom/modals/create-app.js"></script>
	<script src="{{ asset(''); }}js/custom/modals/upgrade-plan.js"></script>
	<!--end::Page Custom Javascript-->
	<script type="text/javascript">
			// $("#core-form").on('submit', function(e) {
				$(document).on('submit', '.form', function(e) {
					e.preventDefault();
			// console.log(this.id)
			// var formdata = $('#' + this.id).serialize();
			// var formElement = document.querySelector("form");
			var formdata = new FormData(this);
			// console.log(data);
			// return;
			$.ajax({
				type: "POST",
				url: this.action,
				data: formdata,
				cache: false,
				contentType: false,
				processData: false,
				success: function(result) {
					if(result.success) {
						Swal.fire({
							text: result.message,
							icon: "success",
							buttonsStyling: !1,
							confirmButtonText: "Ok, got it!",
							customClass: {
								confirmButton: "btn btn-light"
							}
						})
						window.location.href = "{{ url('mercy_hospital')}}/";

					} else {
						Swal.fire({
							text: result.error,
							icon: "error",
							buttonsStyling: !1,
							confirmButtonText: "Ok, got it!",
							customClass: {
								confirmButton: "btn btn-light"
							}
						})
					}
				}
			})
		});
				function showFrom(show, hide)
				{
					$('#'+show).css('display', '');
					$('#'+hide).css('display', 'none');
				}
				function getGuardShift()
				{
					var guard_id = $('#guard_id_adhoc').val();
					$.ajax({
						type: "POST",
						url: '{{url("getGuardShift")}}',
						data: {guard_id : guard_id},
						success: function(result) {
							$('#adhoc-image-preview').attr('src', result.guard.profile_image);
							if(result.success) {
								$('#roster_id').val(result.shift.roster_id);
								if (result.shift.signin_status == 1) {
									$('#adhoc-btn').text('Signout');
									$('#adhoc-action').val('signout');
									$('#shift_time').text(result.shift.temp_end);
								}else{
									$('#adhoc-action').val('signin');
									$('#shift_time').text(result.shift.temp_start);
									$('#adhoc-btn').text('Signin');
								}
							} else {
								$('#shift_time').text('');
								$('#roster_id').val('');

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
					})
				}
				function checkCoreGuardShift()
				{
					var guard_id = $('#guard_id').val();
					$.ajax({
						type: "POST",
						url: '{{url("checkCoreGuardShift")}}',
						data: {guard_id : guard_id},
						success: function(result) {
							$('#core-image-preview').attr('src', result.guard.profile_image);
							if(result.success) {
								$('#core_action').val('signout');
								$('#core_roster_id').val(result.shift.roster_id);
								$('#core-btn').text('Signout');
							} else {
								$('#core_action').val('signin');
								$('#core_roster_id').val('');
								$('#core-btn').text('Signin');

						// Swal.fire({
						// 	text: result.message,
						// 	icon: "error",
						// 	buttonsStyling: !1,
						// 	confirmButtonText: "Ok, got it!",
						// 	customClass: {
						// 		confirmButton: "btn btn-light"
						// 	}
						// })
					}
					
				}
			})
				}

			</script>
			<!--end::Javascript-->
		</body>
		<!--end::Body-->
		</html>