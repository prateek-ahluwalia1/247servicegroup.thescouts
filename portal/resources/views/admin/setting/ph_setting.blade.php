@extends('layout.app')
@extends('layout.sidebar')
@include('layout.toolbar')	
@extends('layout.footer')

@section('pageCss')

<?php 
$permissions = array();
$is_super_admin = 0;
if (session()->has('permissions')) {
	$permissions = json_decode(session()->get('permissions'), true);
}
if (session()->has('isAdmin')) {
	$is_super_admin = session()->get('isAdmin');
}
    // print_r($permissions);
    // exit();
?>
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

	.available_guard td, #customers th {
		border: 1px solid rgb(0, 0, 0);
		padding: 8px;
	}

	.available_guard th {
		padding-top: 12px;
		padding-bottom: 12px;
		text-align: left;
  /* background-color: #d99f23; 
  /*color: rgb(0, 0, 0);*/
  /*} */



  .section {
  	min-height: 250px;
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
  tfoot{
  	display: none !important;
  }

  .section::-webkit-scrollbar {
  	/*width: 20px;*/
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
  @media (max-width: 991.98px){
  	.header-tablet-and-mobile-fixed[data-kt-sticky-header=on] .header {
  		position: inherit  !important;
  	} 
  }
  @media (min-width: 992px){
  	.header-tablet-and-mobile-fixed[data-kt-sticky-header=on] .header {
  		position: inherit  !important;
  	} 
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
				
				<h1 class="text-dark fw-bolder my-0 fs-2">Public Holiday</h1>
				
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
			@if(session()->get('userType')=='admin' || session()->get('userType')=='customer')
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
							<!--begin::Card header
							<div class="card-header">
								<h2 class="card-title fw-bolder">Roster</h2>
								<div class="card-toolbar">
									 //button was here
									</div>
								</div> -->

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
													@if(session()->get('userType')=='admin' || session()->get('userType')=='customer')
													
													<div class="align-items-center">
														<!--begin::Input group-->
														<div class="position-relative me-md-2">
															<div class="row" style="border: 1px solid black;box-shadow: 5px 10px #888888">
																<div class="col-sm-12 col-md-6 col-lg-6 mb-4">
																	<label class="fs-6 form-label fw-bolder text-dark">Select State</label>
																	<!--begin::Select-->
																	<select class="form-select form-select-solid" data-control="select2" data-placeholder="" data-hide-search="true" id="customer-state" name="customer-state">
																		@if(session()->has('isAdmin') && session()->get('isAdmin') == 1)
																		<option value="vic" >Victoria</option>
																		<option value="nsw">NSW</option>
																		<option value="qld">Queensland</option>
																		<option value="tas">Tasmania</option>
																		<option value="wa">Western Australia</option>
																		<option value="sa">South Australia</option>
																		<option value="act">ACT</option>
																		@endif
																		@if(session()->has('isAdmin') && session()->get('isAdmin') == 0)
																		<option value="{{session()->get('state')}}" >{{session()->get('state')}}</option>
																		@if(session()->has('multiple_states') && session()->get('multiple_states') != '')
																		<?php 
																		$multiple_states = json_decode(session()->get('multiple_states'), true);
																		?>
																		@foreach($multiple_states as $key => $ms)
																		<option value="{{$ms}}">{{$ms}}</option>
																		@endforeach
																		@endif
																		@endif
																	</select>
																	<!--end::Select-->
																</div>
															</div>
														</div>
													</div>
													<!--end::Compact form-->
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
									<div id="kt_calendar_app"></div>
									<div id="calendars"></div>
									<!--end::Calendar-->
								</div>
								<!--end::Card body-->
							</div>
							<!--end::Card-->
							<!--begin::Exolore drawer toggle-->

							<!--begin::Exolore drawer-->
							<div id="kt_explore_form" class="bg-white drawer drawer-end" data-kt-drawer="true" data-kt-drawer-name="explore" data-kt-drawer-activate="true" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'50%', 'lg': '50%'}" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_explore_toggle_form" data-kt-drawer-close="#kt_explore_close_form" style="width: 50% !important;">
								<!--begin::Card-->
								<div class="card shadow-none w-100" id="kt-model-form">




								</div>
								<!--end::Card-->
							</div>
							<!--end::Exolore drawer-->
							<!--end::Drawers-->

						</div>
					</div>
					<!--end::Container-->
				</div>
				<!--end::Content-->
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

			<script src="{{asset('')}}js/ph.js"></script>
			<!-- <script src="{{asset('')}}js/custom/modals/users-search.js"></script> -->

			<!-- <script src="{{asset('')}}js/job_roster.js"></script> -->
			<script type="text/javascript">

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
								renderCalendar();

							</script>
							<!--end::Page Custom Javascript-->
							<!--end::Javascript-->
							
							@stop

