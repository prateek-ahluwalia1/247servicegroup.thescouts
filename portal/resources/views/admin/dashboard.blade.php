

@extends('layout.app')
@extends('layout.sidebar')
@extends('layout.footer')

@section('pageCss')


<meta charset="utf-8" />
<title>{{config('custom.title')}}</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<link rel="canonical" href="" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<!-- <link rel="shortcut icon" href="{{ asset('')}}media/logos/favicon.ico" /> -->
<!--begin::Fonts-->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700" />
<!--end::Fonts-->
<!--begin::Page Vendor Stylesheets(used by this page)-->
<link href="{{ asset('')}}plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
<!--end::Page Vendor Stylesheets-->
<!--begin::Global Stylesheets Bundle(used by all pages)-->
<link href="{{ asset('')}}plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
<link href="{{ asset('')}}css/style.bundle.css" rel="stylesheet" type="text/css" />
<link href="{{ asset('')}}css/bootstrap-extend.min.css" rel="stylesheet" type="text/css" />

<link href="{{ asset('')}}plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />



<style>
#kt_footer {
		margin-left: 18% !important;
	}
   
    </style>
    @if(count($new_guards) > 0)
     @foreach($new_guards as $guards)
    <style>
     #profile_l_{{$guards->id}}{
     width: 50px;
     height: 50px;
     border-radius: 50%;
     background: #d99f23;
     font-size: 15px;
     color: white;
     text-align: center;
     line-height: 50px;
     margin: 5px 0;
     }
     
     #profile_t_{{$guards->id}}{
     width: 50px;
     height: 50px;
     border-radius: 50%;
     background: #d99f23;
     font-size: 15px;
     color: white;
     text-align: center;
     line-height: 50px;
     margin: 5px 0;
     }
     </style>
 @endforeach
 @endif


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
                <h1 class="text-dark fw-bolder my-0 fs-2">Dashboard</h1>
                <!--end::Heading-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb fw-bold fs-base my-1">
                    <li class="breadcrumb-item text-muted">
                        <a  class="text-muted">Home</a>
                    </li>
                    <li class="breadcrumb-item text-dark">Dashboard</li>
                </ul>
                <!--end::Breadcrumb-->
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

            <!--begin::Row-->
            <div class="row g-5 g-xl-8">
                <div class="col-xl-4">
                    <!--begin::Statistics Widget 5-->
                    @if (session()->get('userType') == 'admin')
                    <a target="_blank" href="{{url('job_tracker') . '?job_status=ongoing'}}" class="card bg-white hoverable card-xl-stretch mb-xl-8">
                    @else
                    <a class="card bg-white hoverable card-xl-stretch mb-xl-8">
                    @endif
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Svg Icon | path: icons/duotone/Media/Equalizer.svg-->
                            <span class="svg-icon svg-icon-primary svg-icon-3x ms-n1">
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<rect x="0" y="0" width="24" height="24" />
														<rect fill="#000000" opacity="0.3" x="13" y="4" width="3" height="16" rx="1.5" />
														<rect fill="#000000" x="8" y="9" width="3" height="11" rx="1.5" />
														<rect fill="#000000" x="18" y="11" width="3" height="9" rx="1.5" />
														<rect fill="#000000" x="3" y="13" width="3" height="7" rx="1.5" />
													</g>
												</svg>
											</span>
                            <!--end::Svg Icon-->
                            <div class="text-inverse-white fw-bolder fs-2 mb-2 mt-5 " id="ongoing_count"></div>
                            <div class="fw-bold text-inverse-white fs-7">Ongoing Jobs</div>
                        </div>
                        <!--end::Body-->

                    </a>
                    <!--end::Statistics Widget 5-->
                </div>
                <div class="col-xl-4">
                    <!--begin::Statistics Widget 5-->
                    @if (session()->get('userType') == 'admin')
                    <a target="_blank"  href="{{url('job_tracker') . '?job_status=missed'}}" class="card bg-warning hoverable card-xl-stretch mb-xl-8">
                    @else
                    <a class="card bg-warning hoverable card-xl-stretch mb-xl-8">
                        @endif
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Svg Icon | path: icons/duotone/Communication/Group.svg-->
                            <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
												<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
													<path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
													<path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
												</svg>
											</span>
                            <!--end::Svg Icon-->
                            <div class="text-inverse-warning fw-bolder fs-2 mb-2 mt-5" id="missed_count"></div>
                            <div class="fw-bold text-inverse-warning fs-7">Missed sign-in</div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 5-->
                </div>
                <div class="col-xl-4">
                    <!--begin::Statistics Widget 5-->
                    @if (session()->get('userType') == 'admin')

                    <a target="_blank" href="{{url('job_tracker') . '?job_status=upcoming'}}" class="card bg-info hoverable card-xl-stretch mb-5 mb-xl-8">

                    @else
                    <a class="card bg-info hoverable card-xl-stretch mb-5 mb-xl-8">
                        @endif
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Svg Icon | path: icons/duotone/Shopping/Chart-pie.svg-->
                            <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<rect x="0" y="0" width="24" height="24" />
														<path d="M4.00246329,12.2004927 L13,14 L13,4.06189375 C16.9463116,4.55399184 20,7.92038235 20,12 C20,16.418278 16.418278,20 12,20 C7.64874861,20 4.10886412,16.5261253 4.00246329,12.2004927 Z" fill="#000000" opacity="0.3" />
														<path d="M3.0603968,10.0120794 C3.54712466,6.05992157 6.91622084,3 11,3 L11,11.6 L3.0603968,10.0120794 Z" fill="#000000" />
													</g>
												</svg>
											</span>
                            <!--end::Svg Icon-->
                            <div class="text-inverse-info fw-bolder fs-2 mb-2 mt-5" id="upcoming_count"></div>
                            <div class="fw-bold text-inverse-info fs-7">Upcoming Jobs</div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 5-->
                </div>
            </div>
            <div class="row g-5 g-xl-8">
                <div class="col-xl-12">
                    <!--begin::Body-->
                    <div class="card-body">
                        <div class="fw-bold text-inverse-white fs-7 text-center"><h2>Welcome Back!</h2></div>
                    </div>
                    <!--end::Body-->
                </div>
            </div>


            <!--end::Row-->
                </div>
            </div>
        </div>
    </div>





    @stop


    @section('pageFooter')

    <!--begin::Javascript-->
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="{{asset('')}}plugins/global/plugins.bundle.js"></script>
    <script src="{{asset('')}}js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Page Vendors Javascript(used by this page)-->
    <script src="{{asset('')}}plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
    <!--end::Page Vendors Javascript-->
    <!--begin::Page Custom Javascript(used by this page)-->
    <script src="{{asset('')}}js/custom/widgets.js"></script>
    <script src="{{asset('')}}js/custom/roster_progress.js"></script>

    <script src="{{asset('')}}js/custom/apps/chat/chat.js"></script>
    <script src="{{asset('')}}js/custom/modals/create-app.js"></script>
    <script src="{{asset('')}}js/custom/modals/upgrade-plan.js"></script>
    <!--end::Page Custom Javascript-->
    <!--end::Javascript-->
    <script src="{{ asset('')}}plugins/custom/datatables/datatables.bundle.js"></script>

    <script src="{{asset('')}}js/custom/documentation/charts/chartjs.js"></script>

        <script>
            	  $( document ).ready(function() {

                    count_dashboard();
 
                    @foreach($new_guards as $guards)
	        	@if($guards->profile_image  == NULL)
                var firstName =`{{$guards->name}}`;
                    console.log(firstName);
                    // var firstName =firstName.text();
                    console.log(firstName);
                    var intials = firstName.charAt(0);
                    console.log(intials);

                    var profileImage = $('#profile_l_{{$guards->id}}').text(intials);
                    var profileImage = $('#profile_t_{{$guards->id}}').text(intials);
			@endif
			@endforeach


            
       
  });


            </script>

    @stop