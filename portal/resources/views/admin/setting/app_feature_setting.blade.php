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
                    <h1 class="text-dark fw-bolder my-0 fs-2">App Features Settings</h1>
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
                        <div class="card-title fs-3 fw-bolder">Features Selection</div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Form-->
                    <form id="selection-form" method="POST" enctype="multipart/form-data" action="{{url('update_feature_selection')}}" class="form">
                        <!--begin::Card body-->                        @csrf

                        <div class="card-body p-9">
                            <!--begin::Row-->
                            <div class="row mb-5">
                                <!--begin::Col-->
                                <div class="col-xl-3">
                                    <div class="fs-6 fw-bold mt-2 mb-3">Leave Requests </div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin:: input-->
                                    <div class="col-xl-9 fv-row">
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox"  value="1"  id="leave" name="leave" >  </label>
                                    </div>
                                    <!--end::input-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="row mb-5">
                                <!--begin::Col-->
                                <div class="col-xl-3">
                                    <div class="fs-6 fw-bold mt-2 mb-3">ASAP Jobs</div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin:: input-->
                                    <div class="col-xl-9 fv-row">
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" name="asap_job" id="asap_job" type="checkbox"  value="1"  >  </label>
                                    </div>
                                    <!--end:: input-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="row mb-5">
                                <!--begin::Col-->
                                <div class="col-xl-3">
                                    <div class="fs-6 fw-bold mt-2 mb-3">Chat</div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin:: input-->
                                    <div class="col-xl-9 fv-row">
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input name="chat" id="chat" class="form-check-input" type="checkbox"  value="1" value="" >  </label>
                                    </div>
                                    <!--end:: input-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="row mb-5">
                                <!--begin::Col-->
                                <div class="col-xl-3">
                                    <div class="fs-6 fw-bold mt-2 mb-3">Inductions</div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin:: input-->
                                    <div class="col-xl-9 fv-row">
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox"  value="1"  name="induction" id="induction" >  </label>
                                    </div>
                                    <!--end:: input-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="row mb-5">
                                <!--begin::Col-->
                                <div class="col-xl-3">
                                    <div class="fs-6 fw-bold mt-2 mb-3">Announcements</div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin:: input-->
                                    <div class="col-xl-9 fv-row">
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox"  value="1" name="announcements" id="announcements">  </label>
                                    </div>
                                    <!--end:: input-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="row mb-5">
                                <!--begin::Col-->
                                <div class="col-xl-3">
                                    <div class="fs-6 fw-bold mt-2 mb-3">Shift Tasks</div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin:: input-->
                                    <div class="col-xl-9 fv-row">
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox"  value="1" name="tasks" id="tasks" >  </label>
                                    </div>
                                    <!--end:: input-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="row mb-5">
                                <!--begin::Col-->
                                <div class="col-xl-3">
                                    <div class="fs-6 fw-bold mt-2 mb-3">Shift Breaks</div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin:: input-->
                                    <div class="col-xl-9 fv-row">
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox"  value="1"  name="break" id="break" >  </label>
                                    </div>
                                    <!--end:: input-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="row mb-5">
                                <!--begin::Col-->
                                <div class="col-xl-3">
                                    <div class="fs-6 fw-bold mt-2 mb-3">Geo-Fencing</div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin:: input-->
                                    <div class="col-xl-9 fv-row">
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox"  value="1" name="geo_fencing" id="geo_fencing"  >  </label>
                                    </div>
                                    <!--end:: input-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                            <!--begin::Card footer-->
                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                                <button type="submit" class="btn btn-primary" id="">Save Changes</button>
                            </div>
                            <!--end::Card footer-->
                        </div>
                    </form>
                    <!--end::form-->
                </div>
                <!--end::card-->
                <br>
                <!--begin::Card-->
                <div class="card">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <!--begin::Card title-->
                        <div class="card-title fs-3 fw-bolder">Features Settings</div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Form-->
                    <form id="setting-form"  method="POST" enctype="multipart/form-data" action="{{url('update_feature_setting')}}" class="form">
                        <!--begin::Card body-->
                        <div class="card-body p-9">                        @csrf

                            <!--begin::Row-->
                            <div class="row mb-5">
                                <!--begin::Col-->
                                <div class="col-xl-3">
                                    <div class="fs-6 fw-bold mt-2 mb-3">Clock-in Selfie Required </div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin:: input-->
                                    <div class="col-xl-9 fv-row">
                                        <select name="clock_in_selfie" id="clock_in_selfie" class="form-select form-select-solid select2-hidden-accessible" data-control="select2" data-hide-search="true" data-placeholder="Select time ..." name="team_assign" -61-7ju1" tabindex="-1" aria-hidden="true">
                                            <option   value="1">Yes</option>
                                            <option  value="0">No</option>
                                        </select>
                                    </div>
                                    <!--end::input-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="row mb-5">
                                <!--begin::Col-->
                                <div class="col-xl-3">
                                    <div class="fs-6 fw-bold mt-2 mb-3">Clock-in Note Required</div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin:: input-->
                                    <div class="col-xl-9 fv-row">
                                        <select name="clock_in_notes" id="clock_in_notes" class="form-select form-select-solid select2-hidden-accessible" data-control="select2" data-hide-search="true" data-placeholder="Select time..." name="team_assign" -61-7juw" tabindex="-1" aria-hidden="true">
                                            <option value="1" >Yes</option>
                                            <option value="0" >No</option>
                                        </select>
                                    </div>
                                    <!--end:: input-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="row mb-5">
                                <!--begin::Col-->
                                <div class="col-xl-3">
                                    <div class="fs-6 fw-bold mt-2 mb-3">Clock-out Selfie Required</div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin:: input-->
                                    <div class="col-xl-9 fv-row">
                                        <select name="clock_out_selfie" id="clock_out_selfie" class="form-select form-select-solid select2-hidden-accessible" data-control="select2" data-hide-search="true" data-placeholder="Select time..." name="team_assign" -61-7juw" tabindex="-1" aria-hidden="true">
                                            <option value="1" >Yes</option>
                                            <option value="0" >No</option>
                                        </select>
                                    </div>
                                    <!--end:: input-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="row mb-5">
                                <!--begin::Col-->
                                <div class="col-xl-3">
                                    <div class="fs-6 fw-bold mt-2 mb-3">Clock-out Note Required</div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin:: input-->
                                    <div class="col-xl-9 fv-row">
                                        <select name="clock_out_notes" id="clock_out_notes" class="form-select form-select-solid select2-hidden-accessible" data-control="select2" data-hide-search="true" data-placeholder="Select time..." name="team_assign" -61-7juw" tabindex="-1" aria-hidden="true">
                                            <option value="1" >Yes</option>
                                            <option value="0" >No</option>
                                        </select>
                                    </div>
                                    <!--end:: input-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="row mb-5">
                                <!--begin::Col-->
                                <div class="col-xl-3">
                                    <div class="fs-6 fw-bold mt-2 mb-3">Auto Clock-In after 30 mins</div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin:: input-->
                                    <div class="col-xl-9 fv-row">
                                        <select name="clock_in_auto" id="clock_in_auto" class="form-select form-select-solid select2-hidden-accessible" data-control="select2" data-hide-search="true" data-placeholder="Select time..." name="team_assign" -61-7juw" tabindex="-1" aria-hidden="true">
                                            <option value="1" >Yes</option>
                                            <option value="0" >No</option>
                                        </select>
                                    </div>
                                    <!--end:: input-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="row mb-5">
                                <!--begin::Col-->
                                <div class="col-xl-3">
                                    <div class="fs-6 fw-bold mt-2 mb-3">Auto-Clock-out after 30 mins</div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin:: input-->
                                    <div class="col-xl-9 fv-row">
                                        <select name="clock_out_auto" id="clock_out_auto" class="form-select form-select-solid select2-hidden-accessible" data-control="select2" data-hide-search="true" data-placeholder="Select time..." name="team_assign" -61-7juw" tabindex="-1" aria-hidden="true">
                                            <option value="1" >Yes</option>
                                            <option value="0" >No</option>
                                        </select>
                                    </div>
                                    <!--end:: input-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="row mb-5">
                                <!--begin::Col-->
                                <div class="col-xl-3">
                                    <div class="fs-6 fw-bold mt-2 mb-3">Allow clock-in after 30 mins of Start Time</div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin:: input-->
                                    <div class="col-xl-9 fv-row">
                                        <select name="clock_in_allow" id="clock_in_allow" class="form-select form-select-solid select2-hidden-accessible" data-control="select2" data-hide-search="true" data-placeholder="Select time..." name="team_assign" -61-7juw" tabindex="-1" aria-hidden="true">
                                            <option value="1" >Yes</option>
                                            <option value="0" >No</option>
                                        </select>
                                    </div>
                                    <!--end:: input-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                            <!--begin::Card footer-->
                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                                <button type="submit" class="btn btn-primary" id="kt_project_settings_submit">Save Changes</button>
                            </div>
                            <!--end::Card footer-->
                        </div>
                    </form>
                    <!--end::form-->
                </div>
                <!--end::card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Content-->
  
    </div>
</div>

    <!--end::Wrapper-->
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
		$.ajax({type: "POST",url: "{{url('fetch_setting_features')}}",data :{_token: '<?php echo csrf_token();?>'} ,success: function(result){
			$.each(result, function (id, data) {

			if(data.tasks)
			{
				$('#tasks').prop("checked", true);

			}
			if(data.break)
			{
				$('#break').prop("checked", true);

			}
			if(data.geo_fencing)
			{
				$('#geo_fencing').prop("checked", true);

			}
			if(data.announcemnet)
			{
				$('#announcemnet').prop("checked", true);

			}
			if(data.induction)
			{
				$('#induction').prop("checked", true);

			}
			if(data.chat)
			{
				$('#chat').prop("checked", true);

			}
		
			if(data.leave)
			{
				$('#leave').prop("checked", true);

			}
            $('#clock_in_selfie').val(data.clock_in_selfie);
            $('#clock_in_note').val(data.clock_in_note);
            $('#clock_out_note').val(data.clock_out_note);
            $('#clock_out_selfie').val(data.clock_out_selfie);
            $('#clock_in_auto').val(data.clock_in_auto);
            $('#clock_out_auto').val(data.clock_out_auto);
            $('#clock_in_allow').val(data.clock_in_allow);


			console.log(data.announcemnet);
		});
		}
	})

	}
$("#selection-form").on('submit', function(e){
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

  $("#setting-form").on('submit', function(e){
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