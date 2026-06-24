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
			<!--begin::Wrapper-->
			<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
				<!--begin::Header-->
				<div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
					<!--begin::Container-->
					<div class="container d-flex align-items-center justify-content-between" id="kt_header_container">
						<!--begin::Page title-->
						<div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-2 pb-2 pb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
							<!--begin::Heading-->
							<h1 class="text-dark fw-bolder my-0 fs-2">App Notification Settings</h1>
							<!--end::Heading-->
						</div>
						<!--end::Page title=-->
						<!--begin::Wrapper-->
						<div class="d-flex d-lg-none align-items-center ms-n2 me-2">
							<!--begin::Aside mobile toggle-->
							<div class="btn btn-icon btn-active-icon-primary" id="kt_aside_toggle">
								<!--begin::Svg Icon | path: icons/duotone/Text/Menu.svg--><span class="svg-icon svg-icon-2x">
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
						<!--begin::Card-->
						<div class="card">
							<!--begin::Card header-->
							<div class="card-header">
								<!--begin::Card title-->
								<div class="card-title fs-3 fw-bolder">Push-up Notifications Settings</div>
								<!--end::Card title-->
							</div>
							<!--end::Card header-->
							<div id="kt_account_notifications" class="collapse show" style="">
								<!--begin::Form-->
								<form class="form" id="notifications-form" method="POST" enctype="multipart/form-data" action="{{url('update_notification_selection')}}">
									<!--begin::Card body-->
									@csrf
									<div class="card-body border-top px-9 pt-3 pb-4">
										<!--begin::Table-->
										<div class="table-responsive">
											<table class="table table-row-dashed border-gray-300 align-middle gy-6">
												<tbody class="fs-6 fw-bold">
													<!--begin::Table row-->
													<tr>
														<td class="min-w-250px fs-4 fw-bolder">Notifications</td>
														<td class="w-125px"> </td>
													</tr>
													<!--begin::Table row-->
													<!--begin::Table row-->
													<tr>
														<td>New Roster Notifications</td>
														<td>
															<label class="form-check form-switch form-check-custom form-check-solid">
																<input name="new_roster" id="new_roster" class="form-check-input" type="checkbox"  value="1"  >  </label>
														</td>
													</tr>
													<!--begin::Table row-->
													<!--begin::Table row-->
													<tr>
														<td>Profile Update Notifications</td>
														<td>
															<label class="form-check form-switch form-check-custom form-check-solid">
																<input name="profile_udpate" id="profile_udpate" class="form-check-input" type="checkbox"  value="1"  >  </label>
														</td>
													</tr>
													<!--begin::Table row-->
													<!--begin::Table row-->
													<tr>
														<td>Tasks Additiion Notification</td>
														<td>
															<label class="form-check form-switch form-check-custom form-check-solid">
																<input name="tasks_add" id="tasks_add" class="form-check-input" type="checkbox"  value="1"  >  </label>
														</td>
													</tr>
													<!--begin::Table row-->
													<!--begin::Table row-->
													<tr>
														<td>Tasks Reminder Notifications</td>
														<td>
															<label class="form-check form-switch form-check-custom form-check-solid">
																<input name="tasks_reminder" id="tasks_reminder " class="form-check-input" type="checkbox"  value="1"  >  </label>
														</td>
													</tr>
													<!--begin::Table row-->
													<!--begin::Table row-->
													<tr>
														<td>Shift Update Notification</td>
														<td>
															<label class="form-check form-switch form-check-custom form-check-solid">
																<input name="shift_update" id="shift_update" class="form-check-input" type="checkbox"  value="1"  >  </label>
														</td>
													</tr>
													<!--begin::Table row-->
													<!--begin::Table row-->
													<tr>
														<td>Shift Delete Notification</td>
														<td>
															<label class="form-check form-switch form-check-custom form-check-solid">
																<input id="shift_delete" name="shift_delete" class="form-check-input" type="checkbox"  value="1"  >  </label>
														</td>
													</tr>
													<!--begin::Table row-->
													<!--begin::Table row-->
													<tr>
														<td>ASAP Job Notification</td>
														<td>
															<label class="form-check form-switch form-check-custom form-check-solid">
																<input name="asap_job" id="asap_job" class="form-check-input" type="checkbox"  value="1"  >  </label>
														</td>
													</tr>
													<!--begin::Table row-->
													<!--begin::Table row-->
													<tr>
														<td>New Announcement Notification</td>
														<td>
															<label class="form-check form-switch form-check-custom form-check-solid">
																<input name="announcemnet" id="announcemnet" class="form-check-input" type="checkbox"  value="1"  >  </label>
														</td>
													</tr>
													<!--begin::Table row-->
													<!--begin::Table row-->
													<tr>
														<td>New Induction Notification</td>
														<td>
															<label class="form-check form-switch form-check-custom form-check-solid">
																<input name="induction" id="induction" class="form-check-input" type="checkbox"  value="1"  >  </label>
														</td>
													</tr>
													<!--begin::Table row-->
													<!--begin::Table row-->
													<tr>
														<td>Chat Notification</td>
														<td>
															<label class="form-check form-switch form-check-custom form-check-solid">
																<input class="form-check-input" type="checkbox"  value="1" name="chat" id="chat"  >  </label>
														</td>
													</tr>
													<!--begin::Table row-->
													<!--begin::Table row-->
													<tr>
														<td>Leave Approval Notification</td>
														<td>
															<label class="form-check form-switch form-check-custom form-check-solid">
																<input name="leave_approval" id="leave_approval" class="form-check-input" type="checkbox"  value="1"  >  </label>
														</td>
													</tr>
													<!--begin::Table row-->
												</tbody>
											</table>
										</div>
										<!--end::Table-->
									</div>
									<!--end::Card body-->
									<!--begin::Card footer-->
									<div class="card-footer d-flex justify-content-end py-6 px-9">
										<button class="btn btn-white btn-active-light-primary me-2">Discard</button>
										<button class="btn btn-primary px-6">Save Changes</button>
									</div>
									<!--end::Card footer-->
								</form>
								<!--end::Form-->
							</div>
						</div>
						<!--end::card-->
					</div>
					<!--end::Container-->
				</div>
				<!--end::Content-->
		
			</div>
			</div>

			<!--end::Wrapper-->
		</div>
@stop
@section('pageFooter')
    
<script src="{{asset('')}}plugins/global/plugins.bundle.js"></script>
<script src="{{asset('')}}js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Page Vendors Javascript(used by this page)-->
<script src="{{asset('')}}plugins/custom/datatables/datatables.bundle.js"></script>
<!--end::Page Vendors Javascript-->
<!--begin::Page Custom Javascript(used by this page)-->
<script src="{{asset('')}}js/custom/pages/projects/settings/settings.js"></script>
<script src="{{asset('')}}js/custom/modals/users-search.js"></script>
<script src="{{asset('')}}js/custom/modals/new-target.js"></script>
<script src="{{asset('')}}js/custom/widgets.js"></script>
<script src="{{asset('')}}js/custom/apps/chat/chat.js"></script>
<script src="{{asset('')}}js/custom/modals/create-app.js"></script>
<script src="{{asset('')}}js/custom/modals/upgrade-plan.js"></script>

<script>
	$( document ).ready(function() {
		fetch_setting();
		let timerInterval
Swal.fire({
  title: 'Fetching most recent changes for you!',
  html: 'It will take some milliseconds.',
  timer: 2000,
  timerProgressBar: true,
  didOpen: () => {
    Swal.showLoading()
    const b = Swal.getHtmlContainer().querySelector('b')
    timerInterval = setInterval(() => {
      b.textContent = Swal.getTimerLeft()
    }, 100)
  },
  willClose: () => {
    clearInterval(timerInterval)
  }
}).then((result) => {
  /* Read more about handling dismissals below */
  if (result.dismiss === Swal.DismissReason.timer) {
    console.log('I was closed by the timer')
  }
})
	});
	function fetch_setting(){
		$.ajax({type: "POST",url: "{{url('fetch_setting_notifications')}}",data :{_token: '<?php echo csrf_token();?>'} ,success: function(result){
			$.each(result, function (id, data) {

			if(data.new_roster)
			{
				$('#new_roster').prop("checked", true);

			}
			if(data.profile_udpate)
			{
				$('#profile_udpate').prop("checked", true);

			}
			if(data.tasks_add)
			{
				$('#tasks_add').prop("checked", true);

			}
			if(data.tasks_reminder)
			{
				$('#tasks_reminder').prop("checked", true);

			}
			if(data.shift_update)
			{
				$('#shift_update').prop("checked", true);

			}
			if(data.shift_delete)
			{
				$('#shift_delete').prop("checked", true);

			}
		
			if(data.announcemnet)
			{
				$('#announcemnet').prop("checked", true);

			}
			if(data.induction)
			{
				$('#induction').prop("checked", true);

			}	if(data.chat)
			{
				$('#chat').prop("checked", true);

			}	if(data.leave_approval)
			{
				$('#leave_approval').prop("checked", true);

			}
			console.log(data.announcemnet);
		});
		}
	})

	}
	$("#notifications-form").on('submit', function(e){
								 e.preventDefault();
								 console.log(this.id)
								 var data = $('#'+this.id).serialize();
	
								 $.ajax({type: "POST",url: this.action,data : data ,success: function(result){if(result.success){
									 $('#pay-rates-modal').modal('hide');
	
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
													text: result.error,
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