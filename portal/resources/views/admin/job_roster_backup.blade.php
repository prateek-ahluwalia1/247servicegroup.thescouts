@extends('layout.app')
@extends('layout.sidebar')
@include('layout.toolbar')	
@extends('layout.footer')

@section('pageCss')

<link rel="canonical" href="Https://247staffingsolutions.com.au" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<!-- <link rel="shortcut icon" href="{{asset('')}}media/logos/favicon.ico" /> -->
<!--begin::Fonts-->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700" />
<!--end::Fonts-->
<!--begin::Page Vendor Stylesheets(used by this page)-->
<!-- <link href="{{asset('')}}plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" /> -->
<link href="{{asset('')}}fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" />
<!-- <link href="https://bootswatch.com/4/slate/bootstrap.min.css" rel="stylesheet" type="text/css" /> -->

<!--end::Page Vendor Stylesheets-->
<!--begin::Global Stylesheets Bundle(used by all pages)-->
<link href="{{asset('')}}plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
<link href="{{asset('')}}css/style.bundle.css" rel="stylesheet" type="text/css" />
<!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.print.css" media="print"> -->


<!-- <link href='https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.css' rel='stylesheet' /> -->
<!-- <link href='https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.13.1/css/all.css' rel='stylesheet'> -->
<style type="text/css">
.available_guard {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}
.fc-dayGridMonth-button, .fc-today-button{
	text-transform: capitalize !important;
}
.siteBtn{
	float: right !important; 
}
/* 
.available_guard td, #customers th {
  border: 1px solid rgb(0, 0, 0);
  padding: 8px;
}

.available_guard th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  /* background-color: #d99f23; */
  color: rgb(0, 0, 0);
} */




.section {
  max-height: 250px;
  padding: 1rem;
  overflow-y: auto;
  direction: ltr;
  /* scrollbar-color: #d4aa70 #e4e4e4; */
  scrollbar-width: auto;

  h2 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
  }

  p + p {
    margin-top: 1rem;
  }
}

.section::-webkit-scrollbar {
  width: 20px;
}

.section::-webkit-scrollbar-track {
  background-color: #bbbbbb;
  border-radius: 100px;
}

.section::-webkit-scrollbar-thumb {
  border-radius: 100px;
  border: 6px solid #bbbbbb;
  border-left: 0;
  border-right: 0;
  background-color:#bbbbbb;
}




	 .hoverEffect {
    font-size: 29px;
    position: absolute;
    /*margin: 30px 55px;*/
    cursor: pointer;
}
	.cyan-red{
		color: red !important;
	}
	.tooltips {
		position: relative;
		display: inline-block;
		font-size: 16px;
	}

	.tooltips .tooltiptext {
		/* visibility: hidden;*/
		background-color: black;
		color: #fff;
		text-align: center;
		padding: 5px 0;
		border-radius: 6px;
 /*    position: absolute;
 z-index: 1;*/
 width: 120px;
   /* top: 100%;
   left: 50%;*/
   margin-left: -60px;
   font-size: 12px;
}
a.list-group-item{
	padding: 0px 1rem !important;
}
.icon-custom{
	margin: 0px 16px 0px 0px;
}
.tooltips:hover .tooltiptext {
	/*   visibility: visible;*/
	display: block!important;
}
.ui-tooltip .tooltiptext {
	/* visibility: hidden;*/
	background-color: black;
	color: #fff;
	text-align: center;
	padding: 5px 0;
	border-radius: 6px;
 /*    position: absolute;
 z-index: 1;*/
 width: 120px;
   /* top: 100%;
   left: 50%;*/
   margin-left: -60px;
   font-size: 12px;
}

.ui-tooltip:hover .tooltiptext {
	/*   visibility: visible;*/
	display: block!important;
}
/*moiz*/
.fc-theme-standard td, .fc-theme-standard th
{
    height:5em !important;
    
}
.fc .fc-resource-timeline-divider
{
    width:0 !important;
}
.fc-highlight{
    height:5em;
}
.hide{
	display: none;
}
</style>
@stop

@section('content')
<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
	<!--begin::Header-->
	<div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
		<!--begin::Container-->
		<div class="container d-flex align-items-center justify-content-between" id="kt_header_container">
			<!--begin::Page title-->
			<div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-2 pb-2 pb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
				<!--begin::Heading-->
				<!-- <h1 class="text-dark fw-bolder my-0 fs-2">Roster</h1> -->
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
			
			<!--begin::Toolbar wrapper-->
			@if(session()->get('userType')=='admin')
			<!--begin::Toolbar wrapper-->
			@yield('toolbar')
			<!--end::Toolbar wrapper-->
			@endif
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
							<div class="card-header">
								<h2 class="card-title fw-bolder">Roster</h2>
								<div class="card-toolbar">
									<!-- button was here -->
									</div>
								</div>

								<!-- search Start here -->
								<div class="row">
									<div class="col-12">
										<!--begin::Form-->
										<form action="#">
											<!--begin::Card-->
											<div class="card mb-7" style="box-shadow: none !important;">
												<!--begin::Card body-->
												<div class="card-body">
													<!--begin::Compact form-->
				@if(session()->get('userType')=='admin')
													
													<div class="align-items-center">
														<!--begin::Input group-->
														<div class="position-relative me-md-2">
															<div class="row">
																<div class="col-sm-12 col-md-3 col-lg-2">
																	<label class="fs-6 form-label fw-bolder text-dark">Select State</label>
																	<!--begin::Select-->
																	<select class="form-select form-select-solid" data-control="select2" data-placeholder="" data-hide-search="true" id="customer-state" name="customer-state">
																		@if(session()->has('isAdmin') && session()->get('isAdmin') == 1)
																		<option value="Victoria" >Victoria</option>
																		<option value="New South Wales">NSW</option>
																		<option value="Queensland">Queensland</option>
																		<option value="Tasmania">Tasmania</option>
																		<option value="Western Australia">Western Australia</option>
																		<option value="South Australia">South Australia</option>
																		<option value="ACT">ACT</option>
																		@endif
																		@if(session()->has('isAdmin') && session()->get('isAdmin') == 0)
																		<option value="{{session()->get('state')}}" >{{session()->get('state')}}</option>
																		@endif
																	</select>
																	<!--end::Select-->
																</div>
																<div class="col-sm-12 col-md-3 col-lg-2">
																	<label class="fs-6 form-label fw-bolder text-dark">Select Customer</label>
																	<!--begin::Select-->
																	<!-- <select class="form-select form-select-solid" data-control="select2" data-placeholder="" data-hide-search="true" id="customer-selection" name="customer-selection[]" multiple=""> -->
																	<select onchange="get_customers_jobs_list_filter()" name="customer-selection[]" id="customer-selection" multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1">

																	</select>
																	<!--end::Select-->
																</div>
																<!-- <div class="col-sm-12 col-md-3 col-lg-3"></div> -->
																<div class="col-sm-12 col-md-6 col-lg-8" style="margin-top:2.5%">
																	<!--begin::Menu-->
														<button  class="btn btn-action" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
															Action
															<span class="fas fa-sort-down"></span>
														</button>
														<!--begin::Menu 3-->
														<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3" data-kt-menu="true">
															<!--begin::Menu item-->
															<div class="menu-item px-3 my-1 hide action-month">
																<a href="#" class="menu-link px-3" onclick="callAction('copy','month', 'current')">Copy to this month</a>
															</div>
															<div class="menu-item px-3 my-1 hide action-month">
																<a href="#" class="menu-link px-3" onclick="callAction('copy','month', 'next')">Copy this month next to current month</a>
															</div>
															<div class="menu-item px-3 my-1 hide action-month">
																<a href="#" class="menu-link px-3" onclick="callAction('clear','month')">Clear month</a>
															</div>
															<div class="menu-item px-3 my-1 hide action-month">
																<a href="#" class="menu-link px-3" onclick="callAction('unpublish','month')">Unpublish month</a>
															</div>
															<div class="menu-item px-3 my-1 hide action-month">
																<a href="#" class="menu-link px-3" onclick="callAction('unassign','month')">Unassign month</a>
															</div>
															<!--end::Menu item-->
															<div class="menu-item px-3 my-1 hide action-week">
																<a href="#" class="menu-link px-3" onclick="callAction('copy','week', 'current')">
																	<!-- Copy to this week -->
																	Copy this to Current Week
																</a>
															</div>
															<div class="menu-item px-3 my-1 hide action-week">
																<a href="#" class="menu-link px-3" onclick="callAction('copy','week', 'next')">
																<!-- Copy this Week next to current week -->
																Rollover this Week
															</a>
															</div>
															<div class="menu-item px-3 my-1 hide action-week">
																<a href="#" class="menu-link px-3" onclick="callAction('clear','week')">Clear week</a>
															</div>
															<div class="menu-item px-3 my-1 hide action-week">
																<a href="#" class="menu-link px-3" onclick="callAction('unpublish','week')">Unpublish week</a>
															</div>
															<div class="menu-item px-3 my-1 hide action-week">
																<a href="#" class="menu-link px-3" onclick="callAction('unassign','week')">Unassign week</a>
															</div>
															<div class="menu-item px-3 my-1">
																<a href="#" class="menu-link px-3" onclick="addMultipleShifts()">Add multiple shifts</a>
															</div>
														</div>
														<!--end::Menu 3-->
													
													<!--end::Menu-->
																	<button  type="button" class="btn btn-action ml-2" id="publish-calendar-btn" data-backdrop="static" data-keyboard="false" style="margin-left: 5px;" disabled="">Publish <span style="display: none;" id="unpublish-count"></span></button>
																	<button  type="button" class="btn btn-action" id="addSiteBtn" data-toggle="modal" data-target="#addSite" data-backdrop="static" data-keyboard="false">
										<!--begin::Svg Icon | path: icons/duotone/Navigation/Plus.svg-->
										<span class="svg-icon svg-icon-2">
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<rect fill="#000000" x="4" y="11" width="16" height="2" rx="1" />
												<rect fill="#000000" opacity="0.5" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000)" x="4" y="11" width="16" height="2" rx="1" />
											</svg>
										</span>
										<!--end::Svg Icon-->Add Site</button>

										<button type="button"  class="btn btn-action ml-2" id="addGuardFormBtn" data-backdrop="static" data-keyboard="false" style="margin-left: 5px;">
										Ad-hoc Shift</button>

										<button type="button" class="btn btn-action ml-2" id="rosterReportBtn" data-backdrop="static" data-keyboard="false" style="margin-left: 5px; margin-top: 5px;">
										Report</button>
																</div>
																<div class="col-lg-12 col-sm-12 col-md-12" style="display: none;">
																	<label class="fs-6 form-label fw-bolder text-dark">Select Site</label>
																	<!--begin::Select-->
																<!-- <select class="form-select form-select-solid le-search-menu" data-control="select2" data-placeholder="" data-hide-search="true" id="le-search-menu">

																</select> -->
																<!--end::Select-->
																<div class="fv-row mb-10">
																	<select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1" id="le-search-menu" name="le-search-menu[]" class="_ac-customer-change">

																	</select>
																</div>
															</div>
														</div>
														<!--begin::Svg Icon | path: icons/duotone/General/Search.svg-->

														<!--end::Svg Icon-->
														<!-- <input type="text" class="form-control form-control-solid ps-10" name="search" value="" placeholder="Search" /> -->
													</div>
													<!--end::Input group-->
													<!--begin:Action-->
													<!-- <div class="d-flex align-items-center"> -->
														<!-- <button type="submit" class="btn btn-primary me-5">Search</button> -->
														<!-- <a id="kt_horizontal_search_advanced_link" class="btn btn-link me-5" data-bs-toggle="collapse" href="#kt_advanced_search_form">Advanced Search</a>
													</div> -->
													<!--end:Action-->
												</div>
												<!--end::Compact form-->
												<!--begin::Advance form-->
												<div class="collapse" id="kt_advanced_search_form">
													<!--begin::Separator-->
													<div class="separator separator-dashed mt-9 mb-6"></div>
													<!--end::Separator-->
													<!--begin::Row-->
													
													<!--begin::Row-->
													<div class="row g-8">
														
														<!--end::Col-->
														<!--begin::Col-->
														<div class="col-xxl-5">
															<!--begin::Row-->
															<div class="row g-8">
																<!--begin::Col-->
																

																<!--end::Col-->
																<!--begin::Col-->
																<!-- <div class="col-lg-6">
																	<label class="fs-6 form-label fw-bolder text-dark">Status</label>
																	<div class="form-check form-switch form-check-custom form-check-solid mt-1">
																		<input class="form-check-input" type="checkbox" value="" id="flexSwitchChecked" checked="checked" />
																		<label class="form-check-label" for="flexSwitchChecked">Active</label>
																	</div>
																</div> -->
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
											@endif
										</div>
										<!--end::Card-->
									</form>
									<!--end::Form-->
								</div>
							</div>
							<!-- search ends here -->
							<!--end::Card header-->
							<!--begin::Card body-->
							<div class="card-body">
								<!--begin::Calendar-->
								<div class="row" id="calendars-filters" style="display: none;">
									<div class="col-sm-12 col-md-4">
										<div id="search_value_div" class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
											{{-- <input type="text" class="form-control form-control-solid" placeholder="Search" name="search_value" id="search_value"> --}}
											<label  class="fs-6 form-label fw-bolder text-dark">Select Sites</label>
																	<div  class="fv-row mb-10">
																	<select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1"  name="search_value[]" id="search_value" data-placeholder="Select an option">`;
																	</select>
																	</div>
										</div>
									</div> 
									<div class="col-sm-12 col-md-8" id="calendars-filters-right">
										<div class="d-flex align-items-center">
															<!--begin::Checkbox-->
															<div class="form-check form-check-custom form-check-solid me-10 guard-filters">
															    <input class="form-check-input h-30px w-30px" type="radio" name="filter" value="active" id="active-guards" />
															    <label class="form-check-label" for="flexRadio30">
															        Active {{config('custom.guard')}}
															    </label>
															</div>
															<div class="form-check form-check-custom form-check-solid me-10 guard-filters">
															    <input class="form-check-input h-30px w-30px" type="radio" name="filter" value="inactive"/>
															    <label class="form-check-label" for="flexRadio30">
															        Inactive {{config('custom.guard')}}
															    </label>
															</div>
															<div class="form-check form-check-custom form-check-solid me-10 guard-filters">
															    <input class="form-check-input h-30px w-30px" type="radio" name="filter" value="all"/>
															    <label class="form-check-label" for="flexRadio30">
															        All {{config('custom.guard')}}
															    </label>
															</div>

															<div class="form-check form-check-custom form-check-solid me-10 site-filters">
															    <input class="form-check-input filter_sites h-30px w-30px" type="radio" name="filter"  value="active" checked=""  id="active-sites" />
															    <label class="form-check-label" for="flexRadio30">
															        Active Sites
															    </label>
															</div>
															<div class="form-check form-check-custom form-check-solid me-10 site-filters">
															    <input class="form-check-input h-30px filter_sites w-30px" type="radio" name="filter" value="inactive"/>
															    <label class="form-check-label" for="flexRadio30">
															        Inactive Sites
															    </label>
															</div>
															<div class="form-check form-check-custom form-check-solid me-10 site-filters">
															    <input class="form-check-input filter_sites h-30px w-30px" type="radio" name="filter" value="all"/>
															    <label class="form-check-label" for="flexRadio30">
															        All Sites
															    </label>
															</div>
														</div>
									</div>
								</div>
								<div id="kt_calendar_app"></div>
								<div id="calendars"></div>
								<!--end::Calendar-->
							</div>
							<!--end::Card body-->
						</div>
						<!--end::Card-->
						<!--begin::Exolore drawer toggle-->
				@if(session()->get('userType')=='admin')

						<button id="kt_explore_toggle" class="btn btn-sm btn-white btn-active-primary shadow-sm position-fixed px-5 fw-bolder zindex-2 top-50 mt-10 end-0 transform-90 fs-6 rounded-top-0" title="Add {{config('custom.guard')}}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-trigger="hover">
							<span id="kt_explore_toggle_label">Add {{config('custom.guard')}}</span>
						</button>
						@endif
						<!--end::Exolore drawer toggle-->
						<!--begin::Exolore drawer-->
						<div id="kt_explore" class="bg-white drawer drawer-end" data-kt-drawer="true" data-kt-drawer-name="explore" data-kt-drawer-activate="true" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'300px', 'lg': '375px'}" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_explore_toggle" data-kt-drawer-close="#kt_explore_close">
							<!--begin::Card-->
							<div class="card shadow-none w-100">
								<!--begin::Header-->
								<div class="card-header" id="kt_explore_header">
									<h3 class="card-title fw-bolder text-gray-700">{{config('custom.guard')}}</h3>
									<div class="card-toolbar">
										<button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n5" id="kt_explore_close">
											<!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
											<span class="svg-icon svg-icon-2">
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
													<g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
														<rect fill="#000000" x="0" y="7" width="16" height="2" rx="1" />
														<rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1" />
													</g>
												</svg>
											</span>
											<!--end::Svg Icon-->
										</button>
									</div>
								</div>
								<!--end::Header-->
								<!--begin::Body-->

								<div class="card-body" id="kt_explore_body">
									<div class="row mb-5">
										<div class="col-lg-12 col-sm-12">
											<label class="fs-6 form-label fw-bolder text-dark">Select customer</label>
											<!--begin::Select-->
											<select class="form-select form-select-solid" data-control="select2" data-placeholder="In Progress"  id="le-customers">

											</select>
											<!--end::Select-->
										</div>
									</div>
									<div class="row mb-5">
										<div class="col-lg-12 col-sm-12">
											<label class="fs-6 form-label fw-bolder text-dark">Select site to load {{config('custom.guard')}}s</label>
											<!--begin::Select-->
											<select class="form-select form-select-solid" data-control="select2" data-placeholder="In Progress"  id="le-site-guards">

											</select>
											<!--end::Select-->
										</div>
									</div>
									<!--begin::Content-->
									<div id="kt_explore_scroll" class="scroll-y me-n5 pe-5" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_explore_body" data-kt-scroll-dependencies="#kt_explore_header, #kt_explore_footer" data-kt-scroll-offset="5px">
										<!--begin::Demos-->
										<ul id="guard-list-tab" style="display:" class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
											<li class="nav-item">
												<a  onclick="$('#guard-list-site').hide();$('#guard-list-customer').show();"  class="nav-link active" id="default_link_guards" data-bs-toggle="tab" href="#guard-list-customer">View By Guards</a>
											</li>
											<li class="nav-item">
												<a onclick="$('#guard-list-customer').hide();$('#guard-list-site').show();"  class="nav-link" data-bs-toggle="tab" id="default_link_sites" href="#guard-list-site">View By Sites</a>
											</li>
										</ul>
										<div class="mb-0"  id="guard-list">
											<div class="tab-pane mb-0 show active  fade" id="guard-list-customer" role="tabpanel">

											</div>

											<div class="tab-pane mb-0  fade" id="guard-list-site" role="tabpanel">

											</div>
											
											<!--begin::Demo-->

											<!--end::Demo-->
										</div>
										<!--end::Demos-->
									</div>
									<!--end::Content-->
								</div>
								<!--end::Body-->
								<!--begin::Footer-->
								<!-- <div class="card-footer py-5 text-center" id="kt_explore_footer">
									<button id="add-site-guard" class="btn btn-primary">Add Guard</button>
								</div> -->
								<!--end::Footer-->
							</div>
							<!--end::Card-->
						</div>
						<!--end::Exolore drawer-->
						<!--end::Drawers-->
						<!--begin::Exolore drawer-->
						<div id="kt_explore_form" class="bg-white drawer drawer-end" data-kt-drawer="true" data-kt-drawer-name="explore" data-kt-drawer-activate="true" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'50%', 'lg': '50%'}" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_explore_toggle_form" data-kt-drawer-close="#kt_explore_close_form" style="width: 50% !important;">
							<!--begin::Card-->
							<div class="card shadow-none w-100" id="kt-model-form">
								

											
										
							</div>
							<!--end::Card-->
						</div>
						<!--end::Exolore drawer-->
						<!--end::Drawers-->

						<!--begin::Exolore drawer-->
						<div id="kt_explore_available_guard" class="bg-white drawer drawer-end" data-kt-drawer="true" data-kt-drawer-name="explore" data-kt-drawer-activate="true" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'50%', 'lg': '50%'}" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_explore_toggle_available_guard" data-kt-drawer-close="#kt_explore_close_available_guard" style="width: 50% !important;">
							<!--begin::Card-->
							<div class="card shadow-none w-100" >
								<!--begin::Header-->
								<div class="card-header" id="kt_explore_header">
									<h3 class="card-title fw-bolder text-gray-700" id="from-title">Available {{config('custom.guard')}}s</h3>
									<div class="card-toolbar">
										<button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n5" id="kt_explore_close_available_guard">
											<!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
											<span class="svg-icon svg-icon-2">
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
													<g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
														<rect fill="#000000" x="0" y="7" width="16" height="2" rx="1" />
														<rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1" />
													</g>
												</svg>
											</span>
											<!--end::Svg Icon-->
										</button>
									</div>
								</div>
								<!--end::Header-->
									<div class="card-body" id="kt_explore_body" style="max-height: 500px; overflow-x: auto;">
									
									<!--begin::Content-->
									<div id="kt_explore_scroll" class="scroll-y me-n5 pe-5" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_explore_body" data-kt-scroll-dependencies="#kt_explore_header, #kt_explore_footer" data-kt-scroll-offset="5px">
								{{-- <div class="mb-0" id="kt-model-avaialble-gaurd-data">
								</div> --}}
							</div>
									
								</div>

											
										
							</div>
							<!--end::Card-->
						{{-- </div> --}}
						<!--end::Exolore drawer-->
						<!--end::Drawers-->


						

						

						<!--begin::Modals-->
						<!--begin::Modal - New Product-->
						<div class="modal fade" id="kt_modal_add_event" tabindex="-1" aria-hidden="true">
							<!--begin::Modal dialog-->
							<div class="modal-dialog modal-dialog-centered mw-650px">
								<!--begin::Modal content-->
								<div class="modal-content">
									<!--begin::Form-->
									<!-- <form class="form" action="#" id="saveEventForm" > -->
										<!--begin::Modal header-->
										<div class="modal-header">
											<!--begin::Modal title-->
											<h2 class="fw-bolder" data-kt-calendar="title">Add Event</h2>
											<!--end::Modal title-->
											<!--begin::Close-->
											<div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
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
											<!--begin::Input group-->
											<input type="hidden" id="eventeventId_old" >
											<input type="hidden" id="eventsiteId_old" >
											<input type="hidden" id="eventstartStatus_old" >
											<div class="fv-row mb-9">
												<!--begin::Label-->
												<label class="fs-6 fw-bold required mb-2">{{config('custom.guard')}}</label>
												<!--end::Label-->
												<select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" id="eventguardId_old" name="eventguardId">

												</select>
											</div>
											<!--end::Input group-->
											<!--begin::Input group-->
											<div class="fv-row mb-9">
												<!--begin::Label-->
												<label class="fs-6 fw-bold mb-2">Start</label>
												<!--end::Label-->
												<!--begin::Input-->
												<input type="text" class="form-control form-control-solid date-time" placeholder="" name="event_starts" id="event_starts_old" />
												<!--end::Input-->
											</div>

											<div class="fv-row mb-9">
												<!--begin::Label-->
												<label class="fs-6 fw-bold mb-2">End</label>
												<!--end::Label-->
												<!--begin::Input-->
												<input type="text" class="form-control form-control-solid date-time" placeholder="" name="calendar_event_description" id="event_ends_old" />
												<!--end::Input-->
											</div>
											<!--end::Input group-->
										</div>
										<!--end::Modal body-->
										<!--begin::Modal footer-->
										<div class="modal-footer flex-center">
											<!--begin::Button-->
											<button type="reset" id="kt_modal_add_event_cancel" class="btn btn-white me-3" data-bs-dismiss="modal">Cancel</button>
											<!--end::Button-->
											<!--begin::Button-->
											<button type="submit" id="kt_modal_add_event_submit eventsaveBtn" class="btn btn-primary">
												<span class="indicator-label">Submit</span>
												<span class="indicator-progress">Please wait...
													<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
												</button>
												<!--end::Button-->
											</div>
											<!--end::Modal footer-->
										<!-- </form> -->
										<!--end::Form-->
									</div>
								</div>
							</div>
							<!--end::Modal - New Product-->
							<!--begin::Modal - New Product-->
							<div class="modal fade" id="kt_modal_view_event" tabindex="-1" aria-hidden="true">
								<!--begin::Modal dialog-->
								<div class="modal-dialog modal-dialog-centered mw-650px">
									<!--begin::Modal content-->
									<div class="modal-content">
										<!--begin::Modal header-->
										<div class="modal-header border-0 justify-content-end">
											<!--begin::Edit-->
											<div class="btn btn-icon btn-sm btn-color-gray-400 btn-active-icon-primary me-2" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Edit Event" id="kt_modal_view_event_edit">
												<!--begin::Svg Icon | path: icons/duotone/General/Edit.svg-->
												<span class="svg-icon svg-icon-2">
													<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
														<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
															<rect x="0" y="0" width="24" height="24" />
															<path d="M7.10343995,21.9419885 L6.71653855,8.03551821 C6.70507204,7.62337518 6.86375628,7.22468355 7.15529818,6.93314165 L10.2341093,3.85433055 C10.8198957,3.26854411 11.7696432,3.26854411 12.3554296,3.85433055 L15.4614112,6.9603121 C15.7369117,7.23581259 15.8944065,7.6076995 15.9005637,7.99726737 L16.1199293,21.8765672 C16.1330212,22.7048909 15.4721452,23.3869929 14.6438216,23.4000848 C14.6359205,23.4002097 14.6280187,23.4002721 14.6201167,23.4002721 L8.60285976,23.4002721 C7.79067946,23.4002721 7.12602744,22.7538546 7.10343995,21.9419885 Z" fill="#000000" fill-rule="nonzero" transform="translate(11.418039, 13.407631) rotate(-135.000000) translate(-11.418039, -13.407631)" />
														</g>
													</svg>
												</span>
												<!--end::Svg Icon-->
											</div>
											<!--end::Edit-->
											<!--begin::Edit-->
											<div class="btn btn-icon btn-sm btn-color-gray-400 btn-active-icon-danger me-2" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Delete Event" id="kt_modal_view_event_delete">
												<!--begin::Svg Icon | path: icons/duotone/General/Trash.svg-->
												<span class="svg-icon svg-icon-2">
													<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
														<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
															<rect x="0" y="0" width="24" height="24" />
															<path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero" />
															<path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3" />
														</g>
													</svg>
												</span>
												<!--end::Svg Icon-->
											</div>
											<!--end::Edit-->
											<!--begin::Close-->
											<div class="btn btn-icon btn-sm btn-color-gray-500 btn-active-icon-primary" data-bs-toggle="tooltip" title="Hide Event" data-bs-dismiss="modal">
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
										<div class="modal-body pt-0 pb-20 px-lg-17">
											<!--begin::Row-->
											<div class="d-flex">
												<!--begin::Icon-->
												<!--begin::Svg Icon | path: icons/duotone/Interface/Calendar.svg-->
												<span class="svg-icon svg-icon-1 svg-icon-muted me-5">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<path opacity="0.25" fill-rule="evenodd" clip-rule="evenodd" d="M6 3C6 2.44772 6.44772 2 7 2C7.55228 2 8 2.44772 8 3V4H16V3C16 2.44772 16.4477 2 17 2C17.5523 2 18 2.44772 18 3V4H19C20.6569 4 22 5.34315 22 7V19C22 20.6569 20.6569 22 19 22H5C3.34315 22 2 20.6569 2 19V7C2 5.34315 3.34315 4 5 4H6V3Z" fill="#191213" />
														<path fill-rule="evenodd" clip-rule="evenodd" d="M10 12C9.44772 12 9 12.4477 9 13C9 13.5523 9.44772 14 10 14H17C17.5523 14 18 13.5523 18 13C18 12.4477 17.5523 12 17 12H10ZM7 16C6.44772 16 6 16.4477 6 17C6 17.5523 6.44772 18 7 18H13C13.5523 18 14 17.5523 14 17C14 16.4477 13.5523 16 13 16H7Z" fill="#121319" />
													</svg>
												</span>
												<!--end::Svg Icon-->
												<!--end::Icon-->
												<div class="mb-9">
													<!--begin::Event name-->
													<div class="d-flex align-items-center mb-2">
														<span class="fs-3 fw-bolder me-3" data-kt-calendar="event_name"></span>
														<span class="badge badge-light-success" data-kt-calendar="all_day"></span>
													</div>
													<!--end::Event name-->
													<!--begin::Event description-->
													<div class="fs-6" data-kt-calendar="event_description"></div>
													<!--end::Event description-->
												</div>
											</div>
											<!--end::Row-->
											<!--begin::Row-->
											<div class="d-flex align-items-center mb-2">
												<!--begin::Icon-->
												<!--begin::Svg Icon | path: icons/duotone/Design/Circle.svg-->
												<span class="svg-icon svg-icon-1 svg-icon-success me-5">
													<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
														<circle fill="#000000" cx="12" cy="12" r="8" />
													</svg>
												</span>
												<!--end::Svg Icon-->
												<!--end::Icon-->
												<!--begin::Event start date/time-->
												<div class="fs-6">
													<span class="fw-bolder">Starts</span>
													<span data-kt-calendar="event_start_date"></span>
												</div>
												<!--end::Event start date/time-->
											</div>
											<!--end::Row-->
											<!--begin::Row-->
											<div class="d-flex align-items-center mb-9">
												<!--begin::Icon-->
												<!--begin::Svg Icon | path: icons/duotone/Design/Circle.svg-->
												<span class="svg-icon svg-icon-1 svg-icon-danger me-5">
													<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
														<circle fill="#000000" cx="12" cy="12" r="8" />
													</svg>
												</span>
												<!--end::Svg Icon-->
												<!--end::Icon-->
												<!--begin::Event end date/time-->
												<div class="fs-6">
													<span class="fw-bolder">Ends</span>
													<span data-kt-calendar="event_end_date"></span>
												</div>
												<!--end::Event end date/time-->
											</div>
											<!--end::Row-->
											<!--begin::Row-->
											<div class="d-flex align-items-center">
												<!--begin::Icon-->
												<!--begin::Svg Icon | path: icons/duotone/Interface/Map-Marker.svg-->
												<span class="svg-icon svg-icon-1 svg-icon-muted me-5">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<path opacity="0.25" d="M21 10C21 15.4917 16.1746 20.1791 13.5904 22.2957C12.6534 23.0631 11.3466 23.0631 10.4096 22.2957C7.82537 20.1791 3 15.4917 3 10C3 5.02944 7.02944 1 12 1C16.9706 1 21 5.02944 21 10Z" fill="#191213" />
														<path d="M15 9C15 10.6569 13.6569 12 12 12C10.3431 12 9 10.6569 9 9C9 7.34315 10.3431 6 12 6C13.6569 6 15 7.34315 15 9Z" fill="#121319" />
													</svg>
												</span>
												<!--end::Svg Icon-->
												<!--end::Icon-->
												<!--begin::Event location-->
												<div class="fs-6" data-kt-calendar="event_location"></div>
												<!--end::Event location-->
											</div>
											<!--end::Row-->
										</div>
										<!--end::Modal body-->
									</div>
								</div>
							</div>
							<!--end::Modal - New Product-->

							
								<!--end::Modals-->


									<!--begin::Modal - Create App-->
									<div class="modal fade" id="kt_modal_create_app" tabindex="-1" aria-hidden="true">
										<!--begin::Modal dialog-->
										<div class="modal-dialog modal-dialog-centered mw-900px">
											<!--begin::Modal content-->
											<div class="modal-content">
												<!--begin::Modal header-->
												<div class="modal-header">
													<!--begin::Modal title-->
													<h2>Update Event</h2>
													<!--end::Modal title-->
													<!--begin::Close-->
													<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
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
												<div class="modal-body py-lg-10 px-lg-10">
													<!--begin::Stepper-->
													<div class="stepper stepper-pills stepper-column flex-column" id="kt_modal_create_app_stepper">
														<!--begin::Aside-->
														<div class="row">
															<div class="col-md-3 col-lg-3 col-sm-3">
																<div class="justify-content-center justify-content-xl-start">
																	<!--begin::Nav-->
																	<div class="stepper-nav ps-lg-10">
																		<!--begin::Step 1-->
																		<div class="stepper-item current" id="schedule-tab" onclick="currentTab('schedule')"data-kt-stepper-element="nav">
																			<!--begin::Line-->
																			<div class="stepper-line w-40px"></div>
																			<!--end::Line-->
																			<!--begin::Icon-->
																			<div class="stepper-icon w-40px h-40px">
																				<i class="stepper-check fas fa-check"></i>
																				<span class="stepper-number">1</span>
																			</div>
																			<!--end::Icon-->
																			<!--begin::Label-->
																			<div class="stepper-label">
																				<h3 class="stepper-title">Schedule</h3>
																				<div class="stepper-desc"></div>
																			</div>
																			<!--end::Label-->

																		</div>
																		<!--end::Step 1-->
																		<!--begin::Step 1-->
																		<div class="stepper-item" id="signin-tab" onclick="currentTab('signin')" data-kt-stepper-element="nav">
																			<!--begin::Line-->
																			<div class="stepper-line w-40px"></div>
																			<!--end::Line-->
																			<!--begin::Icon-->
																			<div class="stepper-icon w-40px h-40px">
																				<i class="stepper-check fas fa-check"></i>
																				<span class="stepper-number">2</span>
																			</div>
																			<!--end::Icon-->
																			<!--begin::Label-->
																			<div class="stepper-label">
																				<h3 class="stepper-title">Sign In Detailse</h3>
																				<div class="stepper-desc"></div>
																			</div>
																			<!--end::Label-->

																		</div>
																		<!--end::Step 1-->
																		<!--begin::Step 1-->
																		<div class="stepper-item" id="signout-tab" onclick="currentTab('signout')" data-kt-stepper-element="nav">
																			<!--begin::Line-->
																			<div class="stepper-line w-40px"></div>
																			<!--end::Line-->
																			<!--begin::Icon-->
																			<div class="stepper-icon w-40px h-40px">
																				<i class="stepper-check fas fa-check"></i>
																				<span class="stepper-number">3</span>
																			</div>
																			<!--end::Icon-->
																			<!--begin::Label-->
																			<div class="stepper-label">
																				<h3 class="stepper-title">Sign Out Details</h3>
																				<div class="stepper-desc"></div>
																			</div>
																			<!--end::Label-->

																		</div>
																		<!--end::Step 1-->
																		<!--begin::Step 1-->
																		<div class="stepper-item" id="incident-tab" onclick="currentTab('incident')" data-kt-stepper-element="nav">
																			<!--begin::Line-->
																			<div class="stepper-line w-40px"></div>
																			<!--end::Line-->
																			<!--begin::Icon-->
																			<div class="stepper-icon w-40px h-40px">
																				<i class="stepper-check fas fa-check"></i>
																				<span class="stepper-number">4</span>
																			</div>
																			<!--end::Icon-->
																			<!--begin::Label-->
																			<div class="stepper-label">
																				<h3 class="stepper-title">Incident Report Tab</h3>
																				<div class="stepper-desc"></div>
																			</div>
																			<!--end::Label-->

																		</div>
																		<!--end::Step 1-->
																		<!--begin::Step 1-->
																		<div class="stepper-item" id="tracker-tab" onclick="currentTab('tracker')" data-kt-stepper-element="nav">
																			<!--begin::Line-->
																			<div class="stepper-line w-40px"></div>
																			<!--end::Line-->
																			<!--begin::Icon-->
																			<div class="stepper-icon w-40px h-40px">
																				<i class="stepper-check fas fa-check"></i>
																				<span class="stepper-number">5</span>
																			</div>
																			<!--end::Icon-->
																			<!--begin::Label-->
																			<div class="stepper-label">
																				<h3 class="stepper-title">Tracker</h3>
																				<div class="stepper-desc"></div>
																			</div>
																			<!--end::Label-->

																		</div>
																		<!--end::Step 1-->
																		<!--begin::Step 1-->
																		<div class="stepper-item" id="green-call-tab" onclick="currentTab('green-call')" data-kt-stepper-element="nav">
																			<!--begin::Line-->
																			<div class="stepper-line w-40px"></div>
																			<!--end::Line-->
																			<!--begin::Icon-->
																			<div class="stepper-icon w-40px h-40px">
																				<i class="stepper-check fas fa-check"></i>
																				<span class="stepper-number">6</span>
																			</div>
																			<!--end::Icon-->
																			<!--begin::Label-->
																			<div class="stepper-label">
																				<h3 class="stepper-title">Green Call</h3>
																				<div class="stepper-desc"></div>
																			</div>
																			<!--end::Label-->

																		</div>
																		<!--end::Step 1-->
																		<!--begin::Step 1-->
																		<div class="stepper-item" id="welfare-call-tab" onclick="currentTab('welfare-call')" data-kt-stepper-element="nav">
																			<!--begin::Line-->
																			<div class="stepper-line w-40px"></div>
																			<!--end::Line-->
																			<!--begin::Icon-->
																			<div class="stepper-icon w-40px h-40px">
																				<i class="stepper-check fas fa-check"></i>
																				<span class="stepper-number">7</span>
																			</div>
																			<!--end::Icon-->
																			<!--begin::Label-->
																			<div class="stepper-label">
																				<h3 class="stepper-title">Welfare Call</h3>
																				<div class="stepper-desc"></div>
																			</div>
																			<!--end::Label-->

																		</div>
																		<!--end::Step 1-->
																		<!--begin::Step 1-->
																		<div class="stepper-item" id="operators-tab" onclick="currentTab('operators')" data-kt-stepper-element="nav">
																			<!--begin::Line-->
																			<div class="stepper-line w-40px"></div>
																			<!--end::Line-->
																			<!--begin::Icon-->
																			<div class="stepper-icon w-40px h-40px">
																				<i class="stepper-check fas fa-check"></i>
																				<span class="stepper-number">8</span>
																			</div>
																			<!--end::Icon-->
																			<!--begin::Label-->
																			<div class="stepper-label">
																				<h3 class="stepper-title">Operators Notes</h3>
																				<div class="stepper-desc"></div>
																			</div>
																			<!--end::Label-->

																		</div>
																		<!--end::Step 1-->
																		<!--begin::Step 1-->
																		<div class="stepper-item" id="break-tab" onclick="currentTab('break')" data-kt-stepper-element="nav">
																			<!--begin::Line-->
																			<div class="stepper-line w-40px"></div>
																			<!--end::Line-->
																			<!--begin::Icon-->
																			<div class="stepper-icon w-40px h-40px">
																				<i class="stepper-check fas fa-check"></i>
																				<span class="stepper-number">9</span>
																			</div>
																			<!--end::Icon-->
																			<!--begin::Label-->
																			<div class="stepper-label">
																				<h3 class="stepper-title">Break Details</h3>
																				<div class="stepper-desc"></div>
																			</div>
																			<!--end::Label-->

																		</div>
																		<!--end::Step 1-->
																	</div>
																	<!--end::Nav-->
																</div>
															</div>
															<!--begin::Aside-->
															<div class="col-md-9 col-lg-9 col-sm-9">
																<!--begin::Content-->
																<div class="">
																	<!--begin::Form-->
																	<form class="form" novalidate="novalidate" id="kt_modal_update_event_form">
																		<!--begin::Step 1-->
																		<div class="current tabs-custom" id="schedule-div" data-kt-stepper-element="content">
																			<div class="w-100">
																				<!--begin::Input group-->
																				<div class="fv-row mb-9">
																					<input type="hidden" id="eventId" >
																					<input type="hidden" id="siteId" >
																					<input type="hidden" id="startStatusedit" >
																					<!--begin::Label-->
																					<label class="fs-6 fw-bold required mb-2">{{config('custom.guard')}}</label>
																					<!--end::Label-->
																					<select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" id="guardId" name="guardId">

																					</select>
																				</div>
																				<!--begin::Input group-->
																				<div class="fv-row mb-9">
																					<!--begin::Label-->
																					<label class="fs-6 fw-bold mb-2">Start</label>
																					<!--end::Label-->
																					<!--begin::Input-->
																					<input type="text" class="form-control form-control-solid date-time" placeholder="" name="event_starts" id="event_starts_edit" />
																					<!--end::Input-->
																				</div>

																				<div class="fv-row mb-9">
																					<!--begin::Label-->
																					<label class="fs-6 fw-bold mb-2">End</label>
																					<!--end::Label-->
																					<!--begin::Input-->
																					<input type="text" class="form-control form-control-solid date-time" placeholder="" name="calendar_event_description" id="event_ends_edit" />
																					<!--end::Input-->
																				</div>
																				<div class="modal-footer flex-center">
																					<!--begin::Button-->
																					<!-- <button type="reset" id="kt_modal_add_event_cancel" class="btn btn-white me-3">Cancel</button> -->
																					<!--end::Button-->
																					<!--begin::Button-->
																					<button type="submit" id="kt_modal_add_event_submit eventsaveBtn" class="btn btn-primary">
																						<span class="indicator-label">Save</span>
																						<span class="indicator-progress">Please wait...
																							<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
																						</button>
																						<!--end::Button-->
																					</div>
																					<!--end::Input group-->
																					<!--end::Input group-->

																				</div>

																			</div>
																			<!--end::Step 1-->

																		</form>
																		<!--end::Form-->
																		<div class="tabs-custom"  data-kt-stepper-element="content" id="signin-div">
																			<div class="w-100">
																				<div class="card mb-6">
								<div class="card-body pt-9 pb-0">
									<!--begin::Details-->
									<div class="d-flex flex-wrap flex-sm-nowrap mb-3">
										
										<!--begin::Info-->
										<div class="flex-grow-1">
											<!--begin::Stats-->
											<div class="pe-8">
												
													
													
														
													<div class="card-body">
									<!--begin::Row-->
									<div class="row mb-7">
										<!--begin::Label-->
										<label class="col-lg-4 fw-bold text-muted">Signin Time</label>
										<!--end::Label-->
										<!--begin::Col-->
										<div class="col-lg-8">
											<span class="fw-bolder fs-6 text-dark" id="signin-time"></span>
										</div>
										<!--end::Col-->
									</div>
									<!--end::Row-->
									<!--begin::Input group-->
									<div class="row mb-7">
										<!--begin::Label-->
										<label class="col-lg-4 fw-bold text-muted">Notes</label>
										<!--end::Label-->
										<!--begin::Col-->
										<div class="col-lg-8 fv-row">
											<span class="fw-bold fs-6" id="signin-notes"></span>
										</div>
										<!--end::Col-->
									</div>
									<!--end::Input group-->
									<!--begin::Input group-->
									<div class="row mb-7">
										<!--begin::Label-->
										<label class="col-lg-4 fw-bold text-muted">Signin Location</label>
										<!--end::Label-->
										<!--begin::Col-->
										<div class="col-lg-8 d-flex align-items-center">
											<span class="fw-bolder fs-6 me-2" id="signin-address"></span>
										</div>
										<!--end::Col-->
									</div>
									<!--end::Input group-->

									<!--begin::Notice-->
									
									<!--end::Notice-->
								</div>
											</div>
											<!--end::Stats-->
										</div>
										<!--end::Info-->
										<!--begin: Pic-->
										<div class="me-7 mb-4">
											<div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
												<img src="{{asset('')}}media/avatars/150-26.jpg" alt="image" id="signin-selfie">
												<div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-white h-20px w-20px"></div>
											</div>
										</div>
										<!--end::Pic-->

									</div>
									<!--end::Details-->
									<div class="notice d-flex rounded p-6" style="min-height: 200px;" id="signin-map">
									</div>
									
								</div>
							</div>
							<!-- end of signin tab -->
																			</div>
																		</div>
																		<div class="tabs-custom"  data-kt-stepper-element="content" id="signout-div">
																			<div class="w-100">
																				<div class="card mb-6">
								<div class="card-body pt-9 pb-0">
									<!--begin::Details-->
									<div class="d-flex flex-wrap flex-sm-nowrap mb-3">
										
										<!--begin::Info-->
										<div class="flex-grow-1">
											<!--begin::Stats-->
											<div class="pe-8">
												
													
													
														
													<div class="card-body">
									<!--begin::Row-->
									<div class="row mb-7">
										<!--begin::Label-->
										<label class="col-lg-4 fw-bold text-muted">Signout Time</label>
										<!--end::Label-->
										<!--begin::Col-->
										<div class="col-lg-8">
											<span class="fw-bolder fs-6 text-dark" id="signout-time"></span>
										</div>
										<!--end::Col-->
									</div>
									<!--end::Row-->
									<!--begin::Input group-->
									<div class="row mb-7">
										<!--begin::Label-->
										<label class="col-lg-4 fw-bold text-muted">Notes</label>
										<!--end::Label-->
										<!--begin::Col-->
										<div class="col-lg-8 fv-row">
											<span class="fw-bold fs-6" id="signout-notes"></span>
										</div>
										<!--end::Col-->
									</div>
									<!--end::Input group-->
									<!--begin::Input group-->
									<div class="row mb-7">
										<!--begin::Label-->
										<label class="col-lg-4 fw-bold text-muted">Signout Location</label>
										<!--end::Label-->
										<!--begin::Col-->
										<div class="col-lg-8 d-flex align-items-center">
											<span class="fw-bolder fs-6 me-2" id="signout-address"></span>
										</div>
										<!--end::Col-->
									</div>
									<!--end::Input group-->

									<!--begin::Notice-->
									
									<!--end::Notice-->
								</div>
											</div>
											<!--end::Stats-->
										</div>
										<!--end::Info-->
										<!--begin: Pic-->
										<div class="me-7 mb-4">
											<div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
												<img src="{{asset('')}}media/avatars/150-26.jpg" alt="image" id="signout-selfie">
												<div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-white h-20px w-20px"></div>
											</div>
										</div>
										<!--end::Pic-->
									</div>
									<div class="notice d-flex rounded p-6" style="min-height: 200px;" id="signout-map">
									</div>
									<!--end::Details-->
									
								</div>
							</div>
						</div>
																		</div>
																		<div class="tabs-custom"  data-kt-stepper-element="content" id="incident-div">4
																		</div>
																		<div class="tabs-custom"  data-kt-stepper-element="content" id="tracker-div">
																			<div class="w-100">
																				<div class="card-body">
									<!--begin::Tab Content-->
									<div class="tab-content">
										
											<!--begin::Timeline-->
											<div class="timeline" id="tracking-data">
												
												
												
											</div>
											<div id="tracker-map" style="min-height: 250px;"></div>
											<!--end::Timeline-->
										
										
										<!--begin::Tab panel-->
									</div>
									<!--end::Tab Content-->
								</div>
																			</div>
																		</div>
																		<div class="tabs-custom"  data-kt-stepper-element="content" id="green-call-div">
																			<div class="w-100">
																				<div class="card-body">
									<!--begin::Tab Content-->
									<div class="tab-content">
										
											<!--begin::Timeline-->
											<div class="timeline" id="green-call-data">
												
												
												
											</div>
											<div id="green-call-location" style="min-height: 250px;"></div>
											<!--end::Timeline-->
										
										
										<!--begin::Tab panel-->
									</div>
									<!--end::Tab Content-->
								</div>
																		</div>
																	</div>
																		<div class="tabs-custom"  data-kt-stepper-element="content" id="welfare-call-div">
																			<div class="w-100">
																				<div class="card-body">
									<!--begin::Tab Content-->
									<div class="tab-content">
										
											<!--begin::Timeline-->
											<div class="timeline" id="welfare-call-data">
												
												
												
											</div>
											
										<!--begin::Tab panel-->
									</div>
									<!--end::Tab Content-->
								</div>
																		</div>
																		</div>
																		<div class="tabs-custom"  data-kt-stepper-element="content" id="operators-div">
																			<div class="w-100">
																				
																			

																				<div class="fv-row mb-9">
																					<!--begin::Label-->
																					<label class="fs-6 fw-bold mb-2">Operators Notes</label>
																					<!--end::Label-->
																					<!--begin::Input-->
																					<textarea class="form-control form-control-solid date-time" placeholder="" id="operators_notes" name="operators_notes"> </textarea>
																					
																					<!--end::Input-->
																				</div>
																				<div class="modal-footer flex-center">
																					<!--begin::Button-->
																					<!-- <button type="reset" id="kt_modal_add_event_cancel" class="btn btn-white me-3">Cancel</button> -->
																					<!--end::Button-->
																					<!--begin::Button-->
																					<button type="submit" id="kt_modal_add_event_submit eventsaveBtn" class="btn btn-primary">
																						<span class="indicator-label">Save</span>
																						<span class="indicator-progress">Please wait...
																							<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
																						</button>
																						<!--end::Button-->
																					</div>
																					<!--end::Input group-->
																					<!--end::Input group-->

																				</div>
																		</div>
																		<div class="tabs-custom"  data-kt-stepper-element="content" id="break-div">9
																		</div>
																	</div>
																</div>
															</div>
															<!--end::Content-->
														</div>
														<!--end::Stepper-->
													</div>
													<!--end::Modal body-->
												</div>
												<!--end::Modal content-->
											</div>
											<!--end::Modal dialog-->
										</div>
										<!--end::Modal - Create App-->
									</div>
									<!--end::Container-->
								</div>
								<!--end::Content-->
							</div>



							<!--begin:: add site modal -->

							<div id="addSite" class="modal fade" role="dialog">
								<div class="modal-dialog">
									<div class="modal-content">
										<div id="addsitemodal"></div>
									</div>
								</div>
							</div>

							<!--end:: add site modal -->

<!--begin::Modal - New site-->
							<div class="modal fade" id="kt_modal_edit_site" tabindex="-1" aria-hidden="true">
								<!--begin::Modal dialog-->
								<div class="modal-dialog modal-dialog-centered mw-650px">
									<!--begin::Modal content-->
									<div class="modal-content">
										<!--begin::Form-->
										<form class="form" action="#" id="savesiteForm" >
											<!--begin::Modal header-->
											<div class="modal-header">
												<!--begin::Modal title-->
												<h2 class="fw-bolder" data-kt-calendar="title">Update Site</h2>
												<!--end::Modal title-->
												<!--begin::Close-->
												<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
													<!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
													<span class="svg-icon svg-icon-1">
														<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
															<g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
																<rect fill="#000000" x="0" y="7" width="16" height="2" rx="1"></rect>
																<rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1"></rect>
															</g>
														</svg>
													</span>
													<!--end::Svg Icon-->
												</div>
												<!--end::Close-->
											</div>
											<!--end::Modal header-->
											<!--begin::Modal body-->
											<div class="modal-body py-10 px-lg-17" id="edit-site-form-html">


												<!--end::Input group-->
											</div>
											<!--end::Modal body-->
											<!--begin::Modal footer-->
											<div class="modal-footer flex-center">
												<!--begin::Button-->
												<button type="reset" id="kt_modal_add_site_cancel" class="btn btn-white me-3" data-bs-dismiss="modal">Cancel</button>
												<!--end::Button-->
												<!--begin::Button-->
												<button type="submit" id="kt_modal_add_event_submit eventsaveBtn" class="btn btn-primary">
													<span class="indicator-label">Save</span>
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
								</div>
								<!--end::Modal - New Product-->
<!--begin::Modal - New site-->
							<div class="modal fade" id="kt_modal_add_site" tabindex="-1" aria-hidden="true">
								<!--begin::Modal dialog-->
								<div class="modal-dialog modal-dialog-centered mw-650px">
									<!--begin::Modal content-->
									<div class="modal-content">
										<!--begin::Form-->
										<form class="form" action="#" id="savesiteFormNew" >
											<!--begin::Modal header-->
											<div class="modal-header">
												<!--begin::Modal title-->
												<h2 class="fw-bolder" data-kt-calendar="title">Add Site</h2>
												<!--end::Modal title-->
												<!--begin::Close-->
												<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
													<!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
													<span class="svg-icon svg-icon-1">
														<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
															<g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
																<rect fill="#000000" x="0" y="7" width="16" height="2" rx="1"></rect>
																<rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1"></rect>
															</g>
														</svg>
													</span>
													<!--end::Svg Icon-->
												</div>
												<!--end::Close-->
											</div>
											<!--end::Modal header-->
											<!--begin::Modal body-->
											<div class="modal-body py-10 px-lg-17" id="add-site-form-html">


												<!--end::Input group-->
											</div>
											<!--end::Modal body-->
											<!--begin::Modal footer-->
											<div class="modal-footer flex-center">
												<!--begin::Button-->
												<button id="kt_modal_add_site_cancel" class="btn btn-white me-3" data-bs-dismiss="modal">Cancel</button>
												<!--end::Button-->
												<!--begin::Button-->
												<button type="submit" id="kt_modal_add_event_submit eventsaveBtn" class="btn btn-primary">
													<span class="indicator-label">Save</span>
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
								</div>
								<!--end::Modal - New Product-->
								<!--end::Modals-->

								<!--begin::Modal - New site-->
								<div class="modal fade" id="kt_modal_add_guard_form" tabindex="-1" aria-hidden="true">
									<!--begin::Modal dialog-->
									<div class="modal-dialog modal-dialog-centered mw-650px">
										<!--begin::Modal content-->
										<div class="modal-content">
											<!--begin::Form-->
											<form class="form" action="#" id="saveguardForm" >
												<!--begin::Modal header-->
												<div class="modal-header">
													<!--begin::Modal title-->
													<h2 class="fw-bolder" data-kt-calendar="title">Create Ad-hoc Shift</h2>
													<!--end::Modal title-->
													<!--begin::Close-->
													<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
														<!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
														<span class="svg-icon svg-icon-1">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																<g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
																	<rect fill="#000000" x="0" y="7" width="16" height="2" rx="1"></rect>
																	<rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1"></rect>
																</g>
															</svg>
														</span>
														<!--end::Svg Icon-->
													</div>
													<!--end::Close-->
												</div>
												<!--end::Modal header-->
												<!--begin::Modal body-->
												<div class="modal-body py-10 px-lg-17" id="add-guard-form-html">


													<!--end::Input group-->
												</div>
												<!--end::Modal body-->
												<!--begin::Modal footer-->
												<div class="modal-footer flex-center">
													<!--begin::Button-->
													<button type="reset" id="kt_modal_add_site_cancel" class="btn btn-white me-3" data-bs-dismiss="modal">Cancel</button>
													<!--end::Button-->
													<!--begin::Button-->
													<button type="submit" id="kt_modal_add_event_submit eventsaveBtn" class="btn btn-primary">
														<span class="indicator-label">Save</span>
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
									</div>
									<!--end::Modal - New Product-->
									<!--begin::Exolore drawer-->
						<div id="kt_explore_add_multiple_shifts" class="bg-white drawer drawer-end" data-kt-drawer="true" data-kt-drawer-name="explore" data-kt-drawer-activate="true" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'80%', 'lg': '80%'}" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_explore_toggle_add_multiple_shifts" data-kt-drawer-close="#kt_explore_close_add_multiple_shifts" style="width: 80% !important;">
							<!--begin::Card-->
							<div class="card shadow-none w-100" id="kt-model-add-multiple-shifts-form">
								

											
										
							</div>
							<!--end::Card-->
						</div>
						<!--end::Exolore drawer-->

						<!--begin::Exolore drawer-->
						<div id="kt_explore_select_shifts" class="bg-white drawer drawer-end" data-kt-drawer="true" data-kt-drawer-name="explore" data-kt-drawer-activate="true" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'80%', 'lg': '80%'}" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_explore_toggle_add_multiple_shifts" data-kt-drawer-close="#kt_explore_close_add_multiple_shifts" style="width: 80% !important;">
							<!--begin::Card-->
							<div class="card shadow-none w-100" id="kt-model-select-shifts">
								

											
										
							</div>
							<!--end::Card-->
						</div>
						<!--end::Exolore drawer-->

						

								<!-- add models here -->
							<!--begin::Modal - Users Search-->
							<div class="modal fade" id="kt_modal_users_search" tabindex="-1" aria-hidden="true">
								<!--begin::Modal dialog-->
								<div class="modal-dialog modal-dialog-centered mw-650px">
									<!--begin::Modal content-->
									<div class="modal-content">
										<!--begin::Modal header-->
										<div class="modal-header pb-0 border-0 justify-content-end">
											<!--begin::Close-->
											<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
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
										<!--begin::Modal header-->
										<!--begin::Modal body-->
										<div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
											<!--begin::Content-->
											<div class="text-center mb-13">
												<h1 class="mb-3">Add {{config('custom.guard')}}</h1>
												<!-- <div class="text-gray-400 fw-bold fs-5">Invite Collaborators To Your Project</div> -->
											</div>
											<!--end::Content-->
											<!--begin::Search-->
											<div id="kt_modal_users_search_handler" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="inline">
												<!--begin::Form-->
												<form data-kt-search-element="form" class="w-100 position-relative mb-5" autocomplete="off">
													<!--begin::Hidden input(Added to disable form autocomplete)-->
													<input type="hidden" />
													<!--end::Hidden input-->
													<!--begin::Icon-->
													<!--begin::Svg Icon | path: icons/duotone/General/Search.svg-->
													<span class="svg-icon svg-icon-2 svg-icon-lg-1 svg-icon-gray-500 position-absolute top-50 ms-5 translate-middle-y">
														<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
															<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																<rect x="0" y="0" width="24" height="24" />
																<path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
																<path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero" />
															</g>
														</svg>
													</span>
													<!--end::Svg Icon-->
													<!--end::Icon-->
													<!--begin::Input-->
													<input type="text" class="form-control form-control-lg form-control-solid px-15" name="search" value="" placeholder="Search full name or email..." data-kt-search-element="input" />
													<!--end::Input-->
													<!--begin::Spinner-->
													<span class="position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-5" data-kt-search-element="spinner">
														<span class="spinner-border h-15px w-15px align-middle text-gray-400"></span>
													</span>
													<!--end::Spinner-->
													<!--begin::Reset-->
													<span class="btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 me-5 d-none" data-kt-search-element="clear">
														<!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
														<span class="svg-icon svg-icon-2 svg-icon-lg-1 me-0">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																<g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
																	<rect fill="#000000" x="0" y="7" width="16" height="2" rx="1" />
																	<rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1" />
																</g>
															</svg>
														</span>
														<!--end::Svg Icon-->
													</span>
													<!--end::Reset-->
												</form>
												<!--end::Form-->
												<!--begin::Wrapper-->
												<div class="py-5">
													<!--begin::Suggestions-->
													<div data-kt-search-element="suggestions">
														<!--begin::Heading-->
														<!-- <h3 class="fw-bold mb-5">Recently searched:</h3> -->
														<!--end::Heading-->
														<!--begin::Users-->
														<div class="mh-375px scroll-y me-n7 pe-7" id="guard_list">

														</div>
														<!--end::Users-->
													</div>
													<!--end::Suggestions-->
													<!--begin::Results(add d-none to below element to hide the users list by default)-->
													<div data-kt-search-element="results" class="d-none">
														<!--begin::Users-->
														<div class="mh-375px scroll-y me-n7 pe-7" id="search_guard_list">


														</div>
														<!--end::Users-->
														<!--begin::Actions-->
														<div class="d-flex flex-center mt-15">
															<button type="reset" id="kt_modal_users_search_reset" data-bs-dismiss="modal" class="btn btn-active-light me-3">Cancel</button>
															<button type="submit" id="kt_modal_users_search_submit" class="btn btn-primary">Add Selected Users</button>
														</div>
														<!--end::Actions-->
													</div>
													<!--end::Results-->
													<!--begin::Empty-->
													<div data-kt-search-element="empty" class="text-center d-none">
														<!--begin::Message-->
														<div class="fw-bold py-10">
															<div class="text-gray-600 fs-3 mb-2">No users found</div>
															<div class="text-gray-400 fs-6">Try to search by full name or email...</div>
														</div>
														<!--end::Message-->
														<!--begin::Illustration-->
														<div class="text-center px-5">
															<img src="assets/media/illustrations/alert.png" alt="" class="mw-100 mh-200px" />
														</div>
														<!--end::Illustration-->
													</div>
													<!--end::Empty-->
												</div>
												<!--end::Wrapper-->
											</div>
											<!--end::Search-->
										</div>
										<!--end::Modal body-->
									</div>
									<!--end::Modal content-->
								</div>
								<!--end::Modal dialog-->
							</div>
							<!--end::Modal - Users Search-->
							


							{{-- design by husain --}}
							<div class="modal fade" id="select_guards_modal" tabindex="-1" aria-hidden="true">
								<!--begin::Modal dialog-->
							<div class="modal-dialog mw-650px">
								<!--begin::Modal content-->
								<div class="modal-content">
									<!--begin::Modal header-->
									<div class="modal-header modal_custom_head pb-0 border-0 justify-content-end">
										<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close"> <span class="svg-icon svg-icon-2x">X</span> </div>

									</div>
									<!--begin::Modal header-->
									<!--begin::Modal body-->
										<div class="modal-body modal_custom_body2 scroll-y mx-5 mx-xl-18 pt-0 pb-15" style="">
										<!--begin::Heading-->
										<div class="text-center mb-13">
											<!--begin::Title-->
											<h1 class="mb-3" style="margin-top:1px ">Select Available
												{{config('custom.guard')}}</h1>
											<!--end::Title-->
											<!--begin::Description-->
											
											<!--end::Description-->
										</div>
										<!--end::Heading-->
										<!--begin::Google Contacts Invite-->
										
										<div class="mb-10">
											<!--begin::Heading-->
											<!--begin::List-->
											<div  id="kt-model-avaialble-gaurd-data" class=" modal_card_custom mh-400px scroll-y me-n7 pe-7">
											</div>
											<!--end::List-->
												<div class="text-center">
													<div style="
													margin-top: 15px;
												" class="btn btn-primary ms-2" data-bs-dismiss="modal" aria-label="Close"> <span class="svg-icon svg-icon-2x">Close</span> </div>
												</div>
										</div>
										<!--end::Users-->
										<!--begin::Notice-->
						
										<!--end::Notice-->
									</div>
									<!--end::Modal body-->
								</div>
								<!--end::Modal content-->
							</div>
							<!--end::Modal dialog-->
						</div>
					
						<div class="modal fade" tabindex="-1" id="validate_passcode_modal">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">Bypass Code </h5>
						
										<!--begin::Close-->
										<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
											<span class="svg-icon svg-icon-2x"></span>
										</div>
										<!--end::Close-->
									</div>
						
									<div class="modal-body">
										<form id="validate_form" class="form" action="{{url('validate_passcode')}}" method="POST" enctype="multipart/form-data">
										@csrf
										<input type="hidden" name="bypass_id" id="bypass_id">
										<div class="mb-10">
											<label class="required form-label">Enter Bypass Code</label>
											<input type="text" class="form-control form-control-solid" name="code" placeholder="Enter Bypass Code"/>
										</div>
										<div class="footer">
											<button type="submit" class="btn btn-primary">Submit</button>
										</div>
										</form>
									</div>
						
									<div class="modal-footer">
										<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
									</div>
								</div>
							</div>
						</div>

							@stop


							@section('pageFooter')
							<script type="text/javascript">
								var base_url = '{{url('')}}';
								var asset_url = '{{asset('')}}';
								var asset_url_uploads = "{{config('custom.asset_url')}}";
								var token = '{{ csrf_token()}}';
							</script>
							<!--begin::Global Javascript Bundle(used by all pages)-->
							<script src="{{asset('')}}plugins/global/plugins.bundle.js"></script>
							<script src="{{asset('')}}js/scripts.bundle.js"></script>
							<!--end::Global Javascript Bundle-->
							<!--begin::Page Vendors Javascript(used by this page)-->
							<!-- <script src="{{asset('')}}plugins/custom/fullcalendar/fullcalendar.bundle.js"></script> -->
							<script src="{{asset('')}}fullcalendar/fullcalendar.js"></script>
							<!--end::Page Vendors Javascript-->
							<!--begin::Page Custom Javascript(used by this page)-->
							

							<script src="{{asset('')}}js/custom/widgets.js"></script>
							<script src="{{asset('')}}js/custom/apps/chat/chat.js"></script>
							<script src="{{asset('')}}js/custom/modals/create-app.js"></script>
							<script src="{{asset('')}}js/custom/modals/upgrade-plan.js"></script>
							<!-- <script type="text/javascript" src="https://unpkg.com/popper.js/dist/umd/popper.min.js"></script> -->

							<!-- <script type="text/javascript" src="https://unpkg.com/tooltip.js/dist/umd/tooltip.min.js"></script> -->

							<script src="{{asset('')}}js/custom/apps/calendar/calendar.js"></script>
							<script src="{{asset('')}}js/custom/modals/users-search.js"></script>

							<script src="{{asset('')}}js/job_roster.js"></script>
							<script type="text/javascript">
								$( function() {
									$('[data-toggle="tooltip"]').tooltip();
								});
								function call_spinner(){
									let timerInterval;
									Swal.fire({
									  title: 'Please wait!',
									  html: 'It will take some time.',
									  timer: 2000,
									  timerProgressBar: false,
									  didOpen: () => {
									    Swal.showLoading();
									    // const b = Swal.getHtmlContainer().querySelector('b')
									    timerInterval = setInterval(() => {
									     Swal.getTimerLeft()
									    })
									  },
									  willClose: () => {
									    clearInterval(timerInterval)
									  }
									})
								}
								function close_spinner(){
									$('.swal2-container').remove();
									$('.swal2-container').removeClass('swal2-backdrop-show');
									$('.swal2-container').removeClass('swal2-center');
									$('.swal2-container').css('display', 'none !important');

									// Swal.getTimerLeft();
									// Swal.getTimerLeft();
									// Swal.getTimerLeft();
									// console.log('i am called');
								}

								function convert_asap(roster_id){
					// 				$.ajax({type:"POST",url:"{{url('guard/convert_asap')}}",data:{roster_id:roster_id,_token : "<?php echo csrf_token() ?>"},success:function(result){
					// 					if(result.success==true){
					// 						Swal.fire({
					// 								text: result.message,
					// 								icon: "success",
					// 								buttonsStyling: !1,
					// 								confirmButtonText: "Ok, got it!",
					// 								customClass: {
					// 									confirmButton: "btn btn-light"
					// 								}
					// 	})
					// }else{Swal.fire({
					// 						text: result.message,
					// 						icon: "error",
					// 						buttonsStyling: !1,
					// 						confirmButtonText: "Ok, got it!",
					// 						customClass: {
					// 							confirmButton: "btn btn-light"
					// 						}
					// 					}
					// 					)}
					// 				}
					// 				})
					
	Swal.fire({
                        text: "Are you sure you want to convert into ASAP ?",
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
							$.ajax({type:"POST",url:"{{url('guard/convert_asap')}}",data:{roster_id:roster_id,_token : "<?php echo csrf_token() ?>"},success:function(result){
										if(result.success==true){
											Swal.fire({
													text: result.message,
													icon: "success",
													buttonsStyling: !1,
													confirmButtonText: "Ok, got it!",
													customClass: {
														confirmButton: "btn btn-light"
													}
						})
						$('#convert_asap_div').hide();
					}else{Swal.fire({
											text: result.message,
											icon: "error",
											buttonsStyling: !1,
											confirmButtonText: "Ok, got it!",
											customClass: {
												confirmButton: "btn btn-light"
											}
										}
										)}
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

								function get_customers_jobs_list_filter(status){
									var state=	$('#customer-state').val();
									$('#search_value_div').html('');
		     var customer_id = $('#customer-selection').val();
			 console.log(customer_id);
		     $.ajax({
		         type: "POST",
		         url: "{{url('job_tracker/get_customers_jobs_list_filter')}}",
		         data: {
					customer_id: customer_id,
					state: state,
					status:status,
		             _token: "<?php echo csrf_token();?>"
		         },
		         success: function (result) {
		             var inactive_site = `<label  class="fs-6 form-label fw-bolder text-dark">Select Sites</label>
																	<div  class="fv-row mb-10">
																	<select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1"   name="search_value[]" id="search_value" data-placeholder="Select an option" onchange="getSite()">`;
						$.each(result.jobs, function (id, data) {
		                 inactive_site += `<option value="${data.job_id}">${data.site_name}(${data.site_description})</option>`;
		             });
		             inactive_site += '</select></div>';
		             $('#customer-selection').attr('multiple', false);
		             $('#search_value_div').html(inactive_site);
		             MultiselectDropdown();
		             $('#customer-selection').attr('multiple', true);
		             $('#customer-selection').val(customer_id);
		         }
		     })

								}
								function get_customers_guards_list_filter(status){
									var state=	$('#customer-state').val();
									$('#search_value_div').html('');
		     var customer_id = $('#customer-selection').val();
			 console.log(customer_id);
		     $.ajax({
		         type: "POST",
		         url: "{{url('job_tracker/get_customers_guards_list_filter')}}",
		         data: {
					customer_id: customer_id,
					state: state,
					status:status,
		             _token: "<?php echo csrf_token();?>"
		         },
		         success: function (result) {
		             var inactive_site = `<label  class="fs-6 form-label fw-bolder text-dark">Select Guards</label>
																	<div  class="fv-row mb-10">
																	<select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1"   name="search_value[]" id="search_value" data-placeholder="Select an option" onchange="getSite()">`;
						$.each(result.guards, function (id, data) {
		                 inactive_site += `<option value="${data.guard_id}">${data.guard_name}</option>`;
		             });
		             inactive_site += '</select></div>';
		             $('#customer-selection').attr('multiple', false);
		             $('#search_value_div').html(inactive_site);
		             MultiselectDropdown();
		             $('#customer-selection').attr('multiple', true);
		             $('#customer-selection').val(customer_id);
		         }
		     })

								}
								function load_payrates(){  
      var level=$('#site_payrate_level').val();
      console.log(level);
    $.ajax({
        type: "POST",
        url: "{{url('guard/load_payrates')}}",
        data: {level : level,_token:"<?php echo csrf_token();?>"},
        success: function(result) {
            html='<option>Select</option>';
            $.each(result,function(id,data){
                html+=`<option value="${data.id}">${data.title}</option>`;
            });
            $('#site_payrate').html(html);
        }

});
}
 

function load_chargerates(){
    
 var level=$('#site_chargerate_level').val();
    $.ajax({
        type: "POST",
        url: "{{url('guard/load_chargerates')}}",
        data: {level : level,_token:"<?php echo csrf_token();?>"},
        success: function(result) {
            html='<option>Select</option>';
            $.each(result,function(id,data){
                html+=`<option value="${data.id}">${data.title}</option>`;
            });
            $('#site_charge_rate').html(html);
        }

});
}

 function bypass_job(){
	
	@if(session()->get('isAdmin') == 1)
		check_availibilty();
	@else
	

	Swal.fire({
                        text: "Are you sure you want to request for job bypass to Super admin ?",
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
							$.ajax({type: "POST",url: `{{url('bypass_job')}}`, data:{_token:'<?php echo csrf_token();?>'},success: function(result){
								if(result.success){
									
								Swal.fire({
                            text: result.message,
                            icon: "success",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        })
						$('#bypass_id').val(result.bypass_id);
						$('#validate_passcode_modal').modal('show');
					}
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
					@endif

       }

	 
	   $("#validate_form").on('submit', function(e) {
			e.preventDefault();
			console.log(this.id)
			var data = $('#' + this.id).serialize();
			$.ajax({
				type: "POST",
				url: this.action,
				data: data,
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
						check_availibilty();
						$('#validate_passcode_modal').modal('hide');

					} else {
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
		});

// $('.popover').mouseleave(function () {
//     console.log('out');
//     $('.popover').remove();
    
// });
															</script>
							<!--end::Page Custom Javascript-->
							<!--end::Javascript-->
							
							@stop

