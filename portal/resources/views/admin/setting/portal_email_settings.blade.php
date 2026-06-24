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
                    <h1 class="text-dark fw-bolder my-0 fs-2">Portal Settings</h1>
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
                        <div class="card-title fs-3 fw-bolder">Admin Emails</div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Form-->
                      <form id="admin-emails-form" method="POST" enctype="multipart/form-data" action="{{url('update_admin_email_permissions')}}" class="form admin-emails-form">
                        <!--begin::Card body-->                   
                        @csrf
                        <div class="card-body p-9">
                            <!--begin::Row-->
                            <div class="row mb-5">
                                <!--begin::Col-->
                                <div class="col-xl-2 col-lg-2">
                                    <div class="fs-6 fw-bold mt-2 mb-3">Document Expiry </div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-1">
                                    <!--begin:: input-->
                                    <div class="col-xl-9 fv-row">
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="1" name="document_expiry" id="document_expiry" {{(!empty($document_expiry) && $document_expiry->permission == 1) ? 'checked' : ''}} onchange="showHideDiv('document_expiry', 'document_expiry_admin_emails_div')">
                                        </label>
                                        </div>
                                    <!--end::input-->
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-8" id="document_expiry_admin_emails_div" style="display: {{(!empty($document_expiry) && $document_expiry->permission == 1) ? '' : 'none'}}"> 
                                    <!--begin:: input-->
                                    <div class="col-xl-12 fv-row">
                                        <input class="form-control kt_tagify" id="document_expiry_admin_emails" name="document_expiry_admin_emails"  value="{{(!empty($document_expiry) ? $document_expiry->users_emails : '')}}">
                                        </div>
                                    <!--end::input-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->

  <!--begin::Row-->
                            <div class="row mb-5">
                                <!--begin::Col-->
                                <div class="col-xl-2 col-lg-2">
                                    <div class="fs-6 fw-bold mt-2 mb-3">Job Rejection </div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-1">
                                    <!--begin:: input-->
                                    <div class="col-xl-9 fv-row">
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input " type="checkbox" value="1" name="job_rejection" id="job_rejection" {{(!empty($job_rejection) && $job_rejection->permission == 1) ? 'checked' : ''}} onchange="showHideDiv('job_rejection', 'job_rejection_admin_emails_div')">
                                        </label>
                                        </div>
                                    <!--end::input-->
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-8" id="job_rejection_admin_emails_div" style="display: {{(!empty($job_rejection) && $job_rejection->permission == 1) ? '' : 'none'}}"> 
                                    <!--begin:: input-->
                                    <div class="col-xl-12 fv-row">
                                        <input class="form-control kt_tagify1" id="job_rejection_admin_emails" name="job_rejection_admin_emails" value="{{(!empty($job_rejection) && $job_rejection->permission == 1) ? $job_rejection->users_emails : ''}}">
                                        </div>
                                    <!--end::input-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->

                             <!--begin::Row-->
                            <div class="row mb-5">
                                <!--begin::Col-->
                                <div class="col-xl-2 col-lg-2">
                                    <div class="fs-6 fw-bold mt-2 mb-3">Green Call Miss </div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-1">
                                    <!--begin:: input-->
                                    <div class="col-xl-9 fv-row">
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="1" name="green_call_miss" id="green_call_miss" {{(!empty($green_call_miss) && $green_call_miss->permission == 1) ? 'checked' : ''}} onchange="showHideDiv('green_call_miss', 'green_call_miss_admin_emails_div')">
                                        </label>
                                        </div>
                                    <!--end::input-->
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-8" id="green_call_miss_admin_emails_div" style="display: {{(!empty($green_call_miss) && $green_call_miss->permission == 1) ? '' : 'none'}}"> 
                                    <!--begin:: input-->
                                    <div class="col-xl-12 fv-row">
                                        <input class="form-control kt_tagify2" id="green_call_miss_admin_emails" name="green_call_miss_admin_emails" value="{{(!empty($green_call_miss) && $green_call_miss->permission == 1) ? $green_call_miss->users_emails : ''}}">
                                        </div>
                                    <!--end::input-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->

                             <!--begin::Row-->
                            <div class="row mb-5">
                                <!--begin::Col-->
                                <div class="col-xl-2 col-lg-2">
                                    <div class="fs-6 fw-bold mt-2 mb-3">Shift Update </div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-1">
                                    <!--begin:: input-->
                                    <div class="col-xl-9 fv-row">
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="1" name="admin_update_shift" id="admin_update_shift" {{(!empty($admin_update_shift) && $admin_update_shift->permission == 1) ? 'checked' : ''}} onchange="showHideDiv('admin_update_shift', 'admin_update_shift_admin_emails_div')">
                                        </label>
                                        </div>
                                    <!--end::input-->
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-8" id="admin_update_shift_admin_emails_div" style="display: {{(!empty($admin_update_shift) && $admin_update_shift->permission == 1) ? '' : 'none'}}"> 
                                    <!--begin:: input-->
                                    <div class="col-xl-12 fv-row">
                                        <input class="form-control kt_tagify4" id="admin_update_shift_admin_emails" name="admin_update_shift_admin_emails" value="{{(!empty($admin_update_shift) && $admin_update_shift->permission == 1) ? $admin_update_shift->users_emails : ''}}">
                                        </div>
                                    <!--end::input-->
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


                     <!--begin::Card-->
                <div class="card mt-4">
                    

                    <!--begin::Card header-->
                    <div class="card-header">
                        <!--begin::Card title-->
                        <div class="card-title fs-3 fw-bolder">{{ config('custom.guard') }} Emails</div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Form-->
                    <form id="guards-emails-form" method="POST" enctype="multipart/form-data" action="{{url('update_guard_email_permissions')}}" class="form admin-emails-form">
                        <!--begin::Card body-->                   
                        @csrf
                        <div class="card-body p-9">
                             <!--begin::Row-->
                            <div class="row mb-5">
                                <!--begin::Col-->
                                <div class="col-xl-2 col-lg-2">
                                    <div class="fs-6 fw-bold mt-2 mb-3">Signup </div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-1">
                                    <!--begin:: input-->
                                    <div class="col-xl-9 fv-row">
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="1" name="signup" id="signup"  {{(!empty($signup) && $signup->permission == 1) ? 'checked' : ''}}>
                                        </label>
                                        </div>
                                    <!--end::input-->
                                </div>
                                <!--end::Col-->
                                
                            </div>
                            <!--end::Row-->
                             <!--begin::Row-->
                            <div class="row mb-5">
                                <!--begin::Col-->
                                <div class="col-xl-2 col-lg-2">
                                    <div class="fs-6 fw-bold mt-2 mb-3">Profile Update </div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-1">
                                    <!--begin:: input-->
                                    <div class="col-xl-9 fv-row">
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="1" name="profile_update" id="profile_update"  {{(!empty($profile_update) && $profile_update->permission == 1) ? 'checked' : ''}}>
                                        </label>
                                        </div>
                                    <!--end::input-->
                                </div>
                                <!--end::Col-->
                                
                            </div>
                            <!--end::Row-->
                             <!--begin::Row-->
                            <div class="row mb-5">
                                <!--begin::Col-->
                                <div class="col-xl-2 col-lg-2">
                                    <div class="fs-6 fw-bold mt-2 mb-3">Incident Report </div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-1">
                                    <!--begin:: input-->
                                    <div class="col-xl-9 fv-row">
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="1" name="incident_report" id="incident_report"  {{(!empty($incident_report) && $incident_report->permission == 1) ? 'checked' : ''}}>
                                        </label>
                                        </div>
                                    <!--end::input-->
                                </div>
                                <!--end::Col-->
                                
                            </div>
                            <!--end::Row-->

                            <!--begin::Row-->
                            <div class="row mb-5">
                                <!--begin::Col-->
                                <div class="col-xl-2 col-lg-2">
                                    <div class="fs-6 fw-bold mt-2 mb-3">Publish Shift </div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-1">
                                    <!--begin:: input-->
                                    <div class="col-xl-9 fv-row">
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="1" name="publish_shift" id="publish_shift"  {{(!empty($publish_shift) && $publish_shift->permission == 1) ? 'checked' : ''}}>
                                        </label>
                                        </div>
                                    <!--end::input-->
                                </div>
                                <!--end::Col-->
                                
                            </div>
                            <!--end::Row-->

                             <!--begin::Row-->
                            <div class="row mb-5">
                                <!--begin::Col-->
                                <div class="col-xl-2 col-lg-2">
                                    <div class="fs-6 fw-bold mt-2 mb-3">Update Shift </div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-1">
                                    <!--begin:: input-->
                                    <div class="col-xl-9 fv-row">
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="1" name="update_shift" id="update_shift"  {{(!empty($update_shift) && $update_shift->permission == 1) ? 'checked' : ''}}>
                                        </label>
                                        </div>
                                    <!--end::input-->
                                </div>
                                <!--end::Col-->
                                
                            </div>
                            <!--end::Row-->
                             <!--begin::Row-->
                            <div class="row mb-5">
                                <!--begin::Col-->
                                <div class="col-xl-2 col-lg-2">
                                    <div class="fs-6 fw-bold mt-2 mb-3">Delete Shift </div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-1">
                                    <!--begin:: input-->
                                    <div class="col-xl-9 fv-row">
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="1" name="delete_shift" id="delete_shift"  {{(!empty($delete_shift) && $delete_shift->permission == 1) ? 'checked' : ''}}>
                                        </label>
                                        </div>
                                    <!--end::input-->
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
    var input1 = document.querySelector(".kt_tagify");
    new Tagify(input1);
    var input2 = document.querySelector(".kt_tagify1");
    new Tagify(input2);
    var input3 = document.querySelector(".kt_tagify2");
    new Tagify(input3);
    var input4 = document.querySelector(".kt_tagify4");
    new Tagify(input4);

		// fetch_setting();
        let timerInterval
// Swal.fire({
//   title: 'Fetching most recent changes for you!',
//   html: 'It will take some milliseconds.',
//   timer: 2000,
//   timerProgressBar: true,
//   didOpen: () => {
//     Swal.showLoading()
//     const b = Swal.getHtmlContainer().querySelector('b')
//     timerInterval = setInterval(() => {
//       b.textContent = Swal.getTimerLeft()
//     }, 100)
//   },
//   willClose: () => {
//     clearInterval(timerInterval)
//   }
// }).then((result) => {
//   /* Read more about handling dismissals below */
//   if (result.dismiss === Swal.DismissReason.timer) {
//     console.log('I was closed by the timer')
//   }
// })
	});
	function fetch_setting(){
		$.ajax({type: "POST",url: "{{url('fetch_setting_basic')}}",data :{_token: '<?php echo csrf_token();?>'} ,success: function(result){
			$.each(result, function (id, data) {

			if(data.shift_decline_button)
			{
				$('#shift_decline_button').prop("checked", true);

			}
			if(data.asap_decline_button)
			{
				$('#asap_decline_button').prop("checked", true);

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
            $('#primary_color').val(data.primary_color);
            $('#secondary_color').val(data.secondary_color);
            $('#first_green_call').val(data.first_green_call);
            $('#second_green_call').val(data.second_green_call);
            $('#admin_user').val(data.admin_user);
            $('#operations_user').val(data.operations_user);
            $('#hr_user').val(data.hr_user);

            $('#payroll_user').val(data.payroll_user);

            document.getElementById('cover_frame').style.backgroundImage=`url({{asset('')}}media/uploads/${data.cover})`; 

			console.log(data.announcemnet);
		});
		}
	})

	}
    $(".admin-emails-form").on('submit', function(e){
                                 e.preventDefault();
                                 console.log(this.id)
                                 var data = $('#'+this.id).serialize();
    
                                 $.ajax({type: "POST",url: this.action,data : data ,success: function(result){
                                    if(result.success){
                                     $('#pay-rates-modal').modal('hide');
    
                                     Swal.fire({
                                                    text: result.message,
                                                    icon: "success",
                                                    buttonsStyling: !1,
                                                    confirmButtonText: "Data save successfully.",
                                                    customClass: {
                                                        confirmButton: "btn btn-light"
                                                    }
                        })
                                 }else{
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
    function showHideDiv(id, divId)
    {
        if ($('#'+id).prop('checked')) {
            $('#'+divId).css('display', '');
        }else{
            $('#'+divId).css('display', 'none');
        }
    }
    

    
    </script>
    @stop