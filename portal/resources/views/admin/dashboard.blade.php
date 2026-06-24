

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
                <div class="col-xl-3">
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
                <div class="col-xl-3">
                    <!--begin::Statistics Widget 5-->
                    @if (session()->get('userType') == 'admin')

                    <a target="_blank" href="{{url('asap_jobs')}}" class="card bg-dark hoverable card-xl-stretch mb-xl-8">
                        @else
                    <a class="card bg-dark hoverable card-xl-stretch mb-xl-8">
                    @endif
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Svg Icon | path: icons/duotone/Home/Building.svg-->
                            <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<rect x="0" y="0" width="24" height="24" />
														<path d="M13.5,21 L13.5,18 C13.5,17.4477153 13.0522847,17 12.5,17 L11.5,17 C10.9477153,17 10.5,17.4477153 10.5,18 L10.5,21 L5,21 L5,4 C5,2.8954305 5.8954305,2 7,2 L17,2 C18.1045695,2 19,2.8954305 19,4 L19,21 L13.5,21 Z M9,4 C8.44771525,4 8,4.44771525 8,5 L8,6 C8,6.55228475 8.44771525,7 9,7 L10,7 C10.5522847,7 11,6.55228475 11,6 L11,5 C11,4.44771525 10.5522847,4 10,4 L9,4 Z M14,4 C13.4477153,4 13,4.44771525 13,5 L13,6 C13,6.55228475 13.4477153,7 14,7 L15,7 C15.5522847,7 16,6.55228475 16,6 L16,5 C16,4.44771525 15.5522847,4 15,4 L14,4 Z M9,8 C8.44771525,8 8,8.44771525 8,9 L8,10 C8,10.5522847 8.44771525,11 9,11 L10,11 C10.5522847,11 11,10.5522847 11,10 L11,9 C11,8.44771525 10.5522847,8 10,8 L9,8 Z M9,12 C8.44771525,12 8,12.4477153 8,13 L8,14 C8,14.5522847 8.44771525,15 9,15 L10,15 C10.5522847,15 11,14.5522847 11,14 L11,13 C11,12.4477153 10.5522847,12 10,12 L9,12 Z M14,12 C13.4477153,12 13,12.4477153 13,13 L13,14 C13,14.5522847 13.4477153,15 14,15 L15,15 C15.5522847,15 16,14.5522847 16,14 L16,13 C16,12.4477153 15.5522847,12 15,12 L14,12 Z" fill="#000000" />
														<rect fill="#FFFFFF" x="13" y="8" width="3" height="3" rx="1" />
														<path d="M4,21 L20,21 C20.5522847,21 21,21.4477153 21,22 L21,22.4 C21,22.7313708 20.7313708,23 20.4,23 L3.6,23 C3.26862915,23 3,22.7313708 3,22.4 L3,22 C3,21.4477153 3.44771525,21 4,21 Z" fill="#000000" opacity="0.3" />
													</g>
												</svg>
											</span>
                            <!--end::Svg Icon-->
                            <div class="text-inverse-dark fw-bolder fs-2 mb-2 mt-5" id="asap_count"></div>
                            <div class="fw-bold text-inverse-dark fs-7">ASAP Jobs</div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 5-->
                </div>
                <div class="col-xl-3">
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
                <div class="col-xl-3">
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
            <!--end::Row-->






            <div class="row g-5 g-xl-8">
                <div class="col-xl-4">
                    <!--begin::Statistics Widget 2-->
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body d-flex align-items-center pt-3 pb-0">
                            <div class="d-flex flex-column flex-grow-1 py-2 py-lg-13 me-2">
                                <a target="_blank" href="{{url('guards') . '?status=active'}}" class="fw-bolder text-dark fs-4 mb-2 text-hover-primary" id="active_guards_count"></a>
                                <span class="fw-bold text-muted fs-5">Active {{config('custom.guard')}}s</span>
                            </div>
                            <img src="{{asset('')}}media/svg/avatars/boy3-cus.svg" alt="" class="align-self-end h-100px" />
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Statistics Widget 2-->
                </div>
                <div class="col-xl-4">
                    <!--begin::Statistics Widget 2-->
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body d-flex align-items-center pt-3 pb-0">
                            <div class="d-flex flex-column flex-grow-1 py-2 py-lg-13 me-2">
                                <a target="_blank"  href="{{url('guards') . '?status=pending'}}" class="fw-bolder text-dark fs-4 mb-2 text-hover-primary" id="pending_guards_count"></a>
                                <span class="fw-bold text-muted fs-5">Pending {{config('custom.guard')}}s</span>
                            </div>
                            <img src="{{asset('')}}media/svg/avatars/boy2-cus.svg" alt="" class="align-self-end h-100px" />
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Statistics Widget 2-->
                </div>
                <div class="col-xl-4">
                    <!--begin::Statistics Widget 2-->
                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body d-flex align-items-center pt-3 pb-0">
                            <div class="d-flex flex-column flex-grow-1 py-2 py-lg-13 me-2">
                                <a target="_blank"  href="{{url('guards') . '?status=new'}}" class="fw-bolder text-dark fs-4 mb-2 text-hover-primary" id="new_guards_count"></a>
                                <span class="fw-bold text-muted fs-5">New {{config('custom.guard')}}s</span>
                            </div>
                            <img src="{{asset('')}}media/svg/avatars/boy1-cus.svg" alt="" class="align-self-end h-100px" />
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Statistics Widget 2-->
                </div>
            </div>
            <!--end::Row-->



<div class="row gy-5 g-xl-8 ">
                    @if (session()->get('userType') == 'admin')

    <a target="__blank" href="{{url('shift_hours_detail')}}" >
        @endif
    <div class="card card-xl-stretch mb-5 mb-xl-8">
    <canvas id="kt_chartjs_1" class="mh-400px"></canvas>
    </div>
                    @if (session()->get('userType') == 'admin')

    </a>
    @endif
</div>








            <!--begin::Row-->
            <div class="row gy-5 g-xl-8">
                <!--begin::Col-->
                <div class="col-xxl-4">
                    <!--begin::Mixed Widget 12-->
                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                        <!--begin::Header-->
                        <div class="card-header border-0 bg-primary py-5">
                            <h3 class="card-title fw-bolder text-white">App Usage Progress</h3>

                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body p-0">
                            <!--begin::Chart-->
                            <div class="mixed-widget-12-chart card-rounded-bottom bg-primary" data-kt-color="primary" style="height: 250px"></div>
                            <!--end::Chart-->
                            <!--begin::Stats-->
                            <div class="card-rounded bg-white mt-n10 position-relative card-px py-15">
                                <!--begin::Row-->
                                <div class="row g-0 mb-7">
                                    <!--begin::Col-->
                                    <p>Current Month</p>
                                    <div class="col mx-5">
                                        <div class="fs-6 text-gray-400">Total Shifts</div>
                                        <div class="fs-2 fw-bolder text-gray-800" id="shifts_count"></div>
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col mx-5">
                                        <div class="fs-6 text-gray-400">Completed Shift</div>
                                        <div class="fs-2 fw-bolder text-gray-800" id="completed_shifts_count"></div>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row g-0">
                                    <!--begin::Col-->
                                    <div class="col mx-5">
                                        <div class="fs-6 text-gray-400">Missed sign-in</div>
                                        <div class="fs-2 fw-bolder text-gray-800" id="missed_count2"></div>
                                    </div>
                                    <div class="col mx-5">
                                        <div class="fs-6 text-gray-400">Auto Completed</div>
                                        <div class="fs-2 fw-bolder text-gray-800" id="auto_completed_jobs_count"></div>
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <!--end::Col-->
                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Stats-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Mixed Widget 12-->
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-xxl-8">
                    <!--begin::Tables Widget 9-->
                    <div class="card card-xxl-stretch mb-5 mb-xl-8">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                    @if (session()->get('userType') == 'admin')

                               <a href="{{url('guards?status=active')}}" >
                                @endif
                                <span class="card-label  text-hover-primary fw-bolder fs-3 mb-1">Latest New {{config('custom.guard')}}s</span>
                    @if (session()->get('userType') == 'admin')

                            </a>
                            @endif
                                <span class="text-muted mt-1 fw-bold fs-7">Go to {{config('custom.guard')}}s Section to make Changes</span>
                            </h3>

                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body py-3">
                            <!--begin::Table container-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                    <!--begin::Table head-->
                                    <thead>
                                    <tr class="fw-bolder text-muted">
                                       
                                        <th class="min-w-150px">{{config('custom.guard')}}s</th>
                                        <th class="min-w-140px">Email Address</th>
                                        <th class="min-w-120px">Progress</th>
                    @if (session()->get('userType') == 'admin')

                                        <th class="min-w-100px text-end">Actions</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody>
                                        @foreach($new_guards as $guard)
                                    <tr>
                                      
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-45px me-5">
                                                    
                                                    @if($guard->profile_image!=null)
                                                    <img src="{{config('custom.asset_url')}}/{{$guard->profile_image}}" alt="" />

                                                    
                                                    @else
                                                    <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                        <div class="symbol-label " id="profile_l_{{$guard->id}}" class="profile_null">
                                                            <img  alt="" class="w-100" />
                                                        </div>
                                                      </div>
                                                    @endif
                                                </div>
                                                <div class="d-flex justify-content-start flex-column">
                                                    <a  class="text-dark fw-bolder text-hover-primary fs-6">{{$guard->name}}</a>
                                                    <span class="text-muted fw-bold text-muted d-block fs-7">{{$guard->phone}}</span>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <a  class="text-dark fw-bolder text-hover-primary d-block fs-6">{{$guard->email}}</a>
                                            @if($guard->status !='active')
                                            <span class="text-muted fw-bold text-muted d-block fs-7">Email not verified</span>
                                                
                                            @else
                                            <span class="text-muted fw-bold text-muted d-block fs-7">Email verified</span>
                                                
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <?php 
                                            $percent=0;
                                            if($guard->name!='' && $guard->coordinates!='' && $guard->address!='')
                                                {	
                                                    $percent=$percent+20;
                                                }
                                                
                                                if($guard->security_license_number!='' && $guard->passport_number!='')
                                                {	
                                                    $percent=$percent+10;
                                                }
                                                
                                                
                                                if($guard->visa_number!='')
                                                {	
                                                    $percent=$percent+10;
                                                }

                                                if($guard->payroll_tfn_number!='' && $guard->payroll_abn_number !='' && $guard->payroll_bank_name !=''  && $guard->payroll_bank_account_number !='')
                                                {	
                                                    $percent=$percent+20;
                                                }
                                                
                                                if($guard->payrates_id!=''&& $guard->payrates_id!=null)
                                                {	
                                                    $percent=$percent+20;
                                                }
                                                
                                                if($guard->specific_customers_id!='' && $guard->specific_customers_id!= null)
                                                {	
                                                    $percent=$percent+20;
                                                }
                                                
                                                ;?>
                                                @if($percent<=50)

                                                <div class="progress h-5px w-100">
                                                    <div class="progress-bar bg-danger" role="progressbar" style="width: {{$percent}}%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="fw-bolder fs-6">{{$percent}}%</span>

                            

                                                    @else
                                                    <div class="progress h-5px w-100">
                                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{$percent}}%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                                        
                                                    </div>
                                                <span class="fw-bolder fs-6">{{$percent}}%</span>

                                                            
                                                @endif
                                        </td>
                    @if (session()->get('userType') == 'admin')

                                        <td>
                                            <div class="d-flex justify-content-end flex-shrink-0">
                                                <a href="{{url('guard_profile')}}/{{$guard->id}}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                    <!--begin::Svg Icon | path: icons/duotone/General/Settings-1.svg-->
                                                    <span class="svg-icon svg-icon-3">
																			i
																		</span>
                                                    <!--end::Svg Icon-->
                                                </a>
                                                <a href="{{url('edit_guard')}}/{{$guard->id}}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                    <!--begin::Svg Icon | path: icons/duotone/Communication/Write.svg-->
                                                    <span class="svg-icon svg-icon-3">
																			<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																				<path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953)" />
																				<path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
																			</svg>
																		</span>
                                                    <!--end::Svg Icon-->
                                                </a>
                                                <a type="button" onclick="deleteguard({{$guard->id}})" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                                    <!--begin::Svg Icon | path: icons/duotone/General/Trash.svg-->
                                                    <span class="svg-icon svg-icon-3">
																			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																				<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																					<rect x="0" y="0" width="24" height="24" />
																					<path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero" />
																					<path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3" />
																				</g>
																			</svg>
																		</span>
                                                    <!--end::Svg Icon-->
                                                </a>
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                    @endforeach
                             
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Table container-->
                        </div>
                        <!--begin::Body-->
                    </div>
                    <!--end::Tables Widget 9-->
                </div>
                <!--end::Col-->
            </div>
            <!--end::Row-->
            <!--begin::Row-->
            <div class="row gy-5 g-xl-8">
                <!--begin::Col-->
                <div class="col-xxl-4">
                    <!--begin::Statistics Widget 4-->
                    <div class="row"> 
                    <div class="col-sm-12 col-md-6">
                        
                    <div class="card card-xxl-stretch-50 mb-5 mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body p-0">
                            <div class="d-flex flex-stack card-p flex-grow-1">
												<span class="symbol symbol-circle symbol-50px me-2">
													<span class="symbol-label bg-light-danger">
														<!--begin::Svg Icon | path: icons/duotone/Interface/Grid.svg-->
														<span class="svg-icon svg-icon-2x svg-icon-danger">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<path opacity="0.25" d="M13.1721 15.4724C13.3364 14.2725 14.2725 13.3364 15.4724 13.1721C16.1606 13.0778 16.9082 13 17.5 13C18.0918 13 18.8394 13.0778 19.5276 13.1721C20.7275 13.3364 21.6636 14.2725 21.8279 15.4724C21.9222 16.1606 22 16.9082 22 17.5C22 18.0918 21.9222 18.8394 21.8279 19.5276C21.6636 20.7275 20.7275 21.6636 19.5276 21.8279C18.8394 21.9222 18.0918 22 17.5 22C16.9082 22 16.1606 21.9222 15.4724 21.8279C14.2725 21.6636 13.3364 20.7275 13.1721 19.5276C13.0778 18.8394 13 18.0918 13 17.5C13 16.9082 13.0778 16.1606 13.1721 15.4724Z" fill="#12131A" />
																<path opacity="0.25" d="M2.17209 15.4724C2.33642 14.2725 3.27253 13.3364 4.47244 13.1721C5.16065 13.0778 5.90816 13 6.5 13C7.09184 13 7.83935 13.0778 8.52756 13.1721C9.72747 13.3364 10.6636 14.2725 10.8279 15.4724C10.9222 16.1606 11 16.9082 11 17.5C11 18.0918 10.9222 18.8394 10.8279 19.5276C10.6636 20.7275 9.72747 21.6636 8.52756 21.8279C7.83935 21.9222 7.09184 22 6.5 22C5.90816 22 5.16065 21.9222 4.47244 21.8279C3.27253 21.6636 2.33642 20.7275 2.17209 19.5276C2.07784 18.8394 2 18.0918 2 17.5C2 16.9082 2.07784 16.1606 2.17209 15.4724Z" fill="#12131A" />
																<path opacity="0.25" d="M13.1721 4.47244C13.3364 3.27253 14.2725 2.33642 15.4724 2.17209C16.1606 2.07784 16.9082 2 17.5 2C18.0918 2 18.8394 2.07784 19.5276 2.17209C20.7275 2.33642 21.6636 3.27253 21.8279 4.47244C21.9222 5.16065 22 5.90816 22 6.5C22 7.09184 21.9222 7.83935 21.8279 8.52756C21.6636 9.72747 20.7275 10.6636 19.5276 10.8279C18.8394 10.9222 18.0918 11 17.5 11C16.9082 11 16.1606 10.9222 15.4724 10.8279C14.2725 10.6636 13.3364 9.72747 13.1721 8.52756C13.0778 7.83935 13 7.09184 13 6.5C13 5.90816 13.0778 5.16065 13.1721 4.47244Z" fill="#12131A" />
																<path d="M2.17209 4.47244C2.33642 3.27253 3.27253 2.33642 4.47244 2.17209C5.16065 2.07784 5.90816 2 6.5 2C7.09184 2 7.83935 2.07784 8.52756 2.17209C9.72747 2.33642 10.6636 3.27253 10.8279 4.47244C10.9222 5.16065 11 5.90816 11 6.5C11 7.09184 10.9222 7.83935 10.8279 8.52756C10.6636 9.72747 9.72747 10.6636 8.52756 10.8279C7.83935 10.9222 7.09184 11 6.5 11C5.90816 11 5.16065 10.9222 4.47244 10.8279C3.27253 10.6636 2.33642 9.72747 2.17209 8.52756C2.07784 7.83935 2 7.09184 2 6.5C2 5.90816 2.07784 5.16065 2.17209 4.47244Z" fill="#12131A" />
															</svg>
														</span>
                                                        <!--end::Svg Icon-->
													</span>
												</span>
                                <div class="d-flex flex-column text-end">
                                    <span class="text-dark fw-bolder fs-2" id="completed_jobs_count"></span>
                                    <span class="text-muted fw-bold mt-1">Monthly Completed Jobs</span>
                                </div>
                            </div>
                            <div class="statistics-widget-4-chart card-rounded-bottom" data-kt-chart-color="danger" style="height: 150px"></div>
                        </div>
                        <!--end::Body-->
                    </div>
                    </div>
                    <!--end::Statistics Widget 4-->
                    <div class="col-sm-12 col-md-6">
                    <!--begin::Statistics Widget 4-->
                    <div class="card card-xxl-stretch-50 mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body p-0">
                            <div class="d-flex flex-stack card-p flex-grow-1">
												<span class="symbol symbol-circle symbol-50px me-2">
													<span class="symbol-label bg-light-success">
														<!--begin::Svg Icon | path: icons/duotone/Shopping/Cart3.svg-->
														<span class="svg-icon svg-icon-2x svg-icon-success">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<rect x="0" y="0" width="24" height="24" />
																	<path d="M12,4.56204994 L7.76822128,9.6401844 C7.4146572,10.0644613 6.7840925,10.1217854 6.3598156,9.76822128 C5.9355387,9.4146572 5.87821464,8.7840925 6.23177872,8.3598156 L11.2317787,2.3598156 C11.6315738,1.88006147 12.3684262,1.88006147 12.7682213,2.3598156 L17.7682213,8.3598156 C18.1217854,8.7840925 18.0644613,9.4146572 17.6401844,9.76822128 C17.2159075,10.1217854 16.5853428,10.0644613 16.2317787,9.6401844 L12,4.56204994 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
																	<path d="M3.5,9 L20.5,9 C21.0522847,9 21.5,9.44771525 21.5,10 C21.5,10.132026 21.4738562,10.2627452 21.4230769,10.3846154 L17.7692308,19.1538462 C17.3034221,20.271787 16.2111026,21 15,21 L9,21 C7.78889745,21 6.6965779,20.271787 6.23076923,19.1538462 L2.57692308,10.3846154 C2.36450587,9.87481408 2.60558331,9.28934029 3.11538462,9.07692308 C3.23725479,9.02614384 3.36797398,9 3.5,9 Z M12,17 C13.1045695,17 14,16.1045695 14,15 C14,13.8954305 13.1045695,13 12,13 C10.8954305,13 10,13.8954305 10,15 C10,16.1045695 10.8954305,17 12,17 Z" fill="#000000" />
																</g>
															</svg>
														</span>
                                                        <!--end::Svg Icon-->
													</span>
												</span>
                                <div class="d-flex flex-column text-end">
                                    <span class="text-dark fw-bolder fs-2" id="upcoming_jobs_count_2"></span>
                                    <span class="text-muted fw-bold mt-1">Monthly Upcoming Jobs</span>
                                </div>
                            </div>
                            <div class="statistics-widget-4-chart_upcoming card-rounded-bottom" data-kt-chart-color="success" style="height: 150px"></div>
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Statistics Widget 4-->
                    </div>
                    </div>
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-xxl-4">
                    <!--begin::List Widget 3-->
                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                        <!--begin::Header-->
                        <div class="card-header border-0">
                            <h3 class="card-title align-items-start flex-column">
                    @if (session()->get('userType') == 'admin')

                                <a type="button" onclick="get_operations()">
                                    @endif
                                    <span class="fw-bolder text-hover-primary mb-2 text-dark">Shift Notes</span>
                    @if (session()->get('userType') == 'admin')
                                </a>
                                @endif 
                                <span style="margin-top: 1px" class="text-muted fw-bold fs-7">click shift notes to view all notes</span>
                            </h3>

                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body pt-2" id="dashboard_shift_notes">
                        
                           
                     
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end:List Widget 3-->
                    <!--end::List Widget 2-->
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-xxl-4" style="display: none;">
                    <!--begin::List Widget 4-->
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Header-->
                        <div class="card-header align-items-center border-0 mt-4">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="fw-bolder mb-2 text-dark">Activities</span>
                                <span class="text-muted fw-bold fs-7">890,344 Sales</span>
                            </h3>
                          
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body pt-5">
                            <!--begin::Timeline-->
                            <div class="timeline-label">
                                <!--begin::Item-->
                                <div class="timeline-item">
                                    <!--begin::Label-->
                                    <div class="timeline-label fw-bolder text-gray-800 fs-6">08:42</div>
                                    <!--end::Label-->
                                    <!--begin::Badge-->
                                    <div class="timeline-badge">
                                        <i class="fa fa-genderless text-warning fs-1"></i>
                                    </div>
                                    <!--end::Badge-->
                                    <!--begin::Text-->
                                    <div class="fw-mormal timeline-content text-muted ps-3">Outlines keep you honest. And keep structure</div>
                                    <!--end::Text-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="timeline-item">
                                    <!--begin::Label-->
                                    <div class="timeline-label fw-bolder text-gray-800 fs-6">10:00</div>
                                    <!--end::Label-->
                                    <!--begin::Badge-->
                                    <div class="timeline-badge">
                                        <i class="fa fa-genderless text-success fs-1"></i>
                                    </div>
                                    <!--end::Badge-->
                                    <!--begin::Content-->
                                    <div class="timeline-content d-flex">
                                        <span class="fw-bolder text-gray-800 ps-3">AEOL meeting</span>
                                    </div>
                                    <!--end::Content-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="timeline-item">
                                    <!--begin::Label-->
                                    <div class="timeline-label fw-bolder text-gray-800 fs-6">14:37</div>
                                    <!--end::Label-->
                                    <!--begin::Badge-->
                                    <div class="timeline-badge">
                                        <i class="fa fa-genderless text-danger fs-1"></i>
                                    </div>
                                    <!--end::Badge-->
                                    <!--begin::Desc-->
                                    <div class="timeline-content fw-bolder text-gray-800 ps-3">Make deposit
                                        <a  class="text-primary">USD 700</a>. to ESL</div>
                                    <!--end::Desc-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="timeline-item">
                                    <!--begin::Label-->
                                    <div class="timeline-label fw-bolder text-gray-800 fs-6">16:50</div>
                                    <!--end::Label-->
                                    <!--begin::Badge-->
                                    <div class="timeline-badge">
                                        <i class="fa fa-genderless text-primary fs-1"></i>
                                    </div>
                                    <!--end::Badge-->
                                    <!--begin::Text-->
                                    <div class="timeline-content fw-mormal text-muted ps-3">Indulging in poorly driving and keep structure keep great</div>
                                    <!--end::Text-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="timeline-item">
                                    <!--begin::Label-->
                                    <div class="timeline-label fw-bolder text-gray-800 fs-6">21:03</div>
                                    <!--end::Label-->
                                    <!--begin::Badge-->
                                    <div class="timeline-badge">
                                        <i class="fa fa-genderless text-danger fs-1"></i>
                                    </div>
                                    <!--end::Badge-->
                                    <!--begin::Desc-->
                                    <div class="timeline-content fw-bold text-gray-800 ps-3">New order placed
                                        <a  class="text-primary">#XF-2356</a>.</div>
                                    <!--end::Desc-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="timeline-item">
                                    <!--begin::Label-->
                                    <div class="timeline-label fw-bolder text-gray-800 fs-6">16:50</div>
                                    <!--end::Label-->
                                    <!--begin::Badge-->
                                    <div class="timeline-badge">
                                        <i class="fa fa-genderless text-primary fs-1"></i>
                                    </div>
                                    <!--end::Badge-->
                                    <!--begin::Text-->
                                    <div class="timeline-content fw-mormal text-muted ps-3">Indulging in poorly driving and keep structure keep great</div>
                                    <!--end::Text-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="timeline-item">
                                    <!--begin::Label-->
                                    <div class="timeline-label fw-bolder text-gray-800 fs-6">21:03</div>
                                    <!--end::Label-->
                                    <!--begin::Badge-->
                                    <div class="timeline-badge">
                                        <i class="fa fa-genderless text-danger fs-1"></i>
                                    </div>
                                    <!--end::Badge-->
                                    <!--begin::Desc-->
                                    <div class="timeline-content fw-bold text-gray-800 ps-3">New order placed
                                        <a  class="text-primary">#XF-2356</a>.</div>
                                    <!--end::Desc-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="timeline-item">
                                    <!--begin::Label-->
                                    <div class="timeline-label fw-bolder text-gray-800 fs-6">10:30</div>
                                    <!--end::Label-->
                                    <!--begin::Badge-->
                                    <div class="timeline-badge">
                                        <i class="fa fa-genderless text-success fs-1"></i>
                                    </div>
                                    <!--end::Badge-->
                                    <!--begin::Text-->
                                    <div class="timeline-content fw-mormal text-muted ps-3">Finance KPI Mobile app launch preparion meeting</div>
                                    <!--end::Text-->
                                </div>
                                <!--end::Item-->
                            </div>
                            <!--end::Timeline-->
                        </div>
                        <!--end: Card Body-->
                    </div>
                    <!--end::List Widget 4-->
                </div>
                <!--end::Col-->
            </div>
            <!--end::Row-->
            <!--begin::Tables Widget 12-->
            <div class="card mb-5 mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Top Rated {{config('custom.guard')}}s</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Best 5 {{config('custom.guard')}}s in terms of Ratings</span>
                    </h3>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3">
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                            <!--begin::Table head-->
                            <thead>
                            <tr class="fw-bolder text-muted">
                            
                                <th class="min-w-150px">{{config('custom.guard')}}s</th>
                                <th class="min-w-140px">Email Address</th>
                                <th class="min-w-120px">Rating</th>
                                <th class="min-w-120px">Profile</th>
                                <th class="min-w-100px text-end">Actions</th>
                            </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>
                                @foreach($top_rated as $guard)
                            <tr>
                               
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-45px me-5">
                                            @if($guard->profile_image!=null)
                                            <img src="{{config('custom.asset_url')}}/{{$guard->profile_image}}" alt="" />
                                            @else
                                            <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                <div class="symbol-label " id="profile_t_{{$guard->id}}" class="profile_null">
                                                    <img  alt="" class="w-100" />
                                                </div>
                                              </div>
                                            
                                            @endif                                        </div>
                                        <div class="d-flex justify-content-start flex-column">
                                            <a  class="text-dark fw-bolder text-hover-primary fs-6">{{$guard->name}}</a>
                                            <span class="text-muted fw-bold text-muted d-block fs-7">{{$guard->phone}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a  class="text-dark fw-bolder text-hover-primary d-block fs-6">{{$guard->email}}</a>
                                    @if($guard->status !='active')
                                    <span class="text-muted fw-bold text-muted d-block fs-7">Email not verified</span>
                                        
                                    @else
                                    <span class="text-muted fw-bold text-muted d-block fs-7">Email verified</span>
                                        
                                    @endif
                                </td>
                                <td>
                                    <div class="rating">   
                                        <?php $rating=round( (5/100) * $guard->rating);
                                        ?> 
                                        
                                        @for ($i = 1; $i < 6; $i++)
                                        @if ($i<=$rating)
                                        <div class="rating-label me-2 checked">
                                            <i class="bi bi-star-fill fs-5"></i>
                                        </div>
                                        @else
                                        <div class="rating-label me-2 ">
                                            <i class="bi bi-star-fill fs-5"></i>
                                        </div>
                                        @endif
                                         @endfor
{{--                                        
                                        <div class="rating-label me-2 checked">
                                            <i class="bi bi-star-fill fs-5"></i>
                                        </div>
                                        <div class="rating-label me-2 checked">
                                            <i class="bi bi-star-fill fs-5"></i>
                                        </div>
                                        <div class="rating-label me-2 checked">
                                            <i class="bi bi-star-fill fs-5"></i>
                                        </div>
                                        <div class="rating-label me-2 checked">
                                            <i class="bi bi-star-fill fs-5"></i>
                                        </div> --}}
                                    </div>
                                    <span class="text-muted fw-bold text-muted d-block fs-7 mt-1">Best Rated</span>
                                </td>
                                <td class="text-end">
                                    <?php 
                                    $percent=0;
                                    if($guard->name!='' && $guard->coordinates!='' && $guard->address!='')
                                        {	
                                            $percent=$percent+20;
                                        }
                                        
                                        if($guard->security_license_number!='' && $guard->passport_number!='')
                                        {	
                                            $percent=$percent+10;
                                        }
                                        
                                        
                                        if($guard->visa_number!='')
                                        {	
                                            $percent=$percent+10;
                                        }

                                        if($guard->payroll_tfn_number!='' && $guard->payroll_abn_number !='' && $guard->payroll_bank_name !=''  && $guard->payroll_bank_account_number !='')
                                        {	
                                            $percent=$percent+20;
                                        }
                                        
                                        if($guard->payrates_id!=''&& $guard->payrates_id!=null)
                                        {	
                                            $percent=$percent+20;
                                        }
                                        
                                        if($guard->specific_customers_id!='' && $guard->specific_customers_id!= null)
                                        {	
                                            $percent=$percent+20;
                                        }
                                        
                                        ;?>
                                        @if($percent<=50)

                                        <div class="progress h-5px w-100">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: {{$percent}}%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span class="fw-bolder fs-6">{{$percent}}%</span>

                    

                                            @else
                                            <div class="progress h-5px w-100">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: {{$percent}}%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                                
                                            </div>
                                        <span class="fw-bolder fs-6">{{$percent}}%</span>

                                                    
                                        @endif
                                </td>
                    @if (session()->get('userType') == 'admin')

                                <td>
                                    <div class="d-flex justify-content-end flex-shrink-0">
                                        <a target="_blank" href="{{url('guard_profile')}}/{{$guard->id}}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                            <!--begin::Svg Icon | path: icons/duotone/General/Settings-1.svg-->
                                            <span class="svg-icon svg-icon-3">
                                                                    i
                                                                </span>
                                            <!--end::Svg Icon-->
                                        </a>
                                        <a href="{{url('edit_guard')}}/{{$guard->id}}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                            <!--begin::Svg Icon | path: icons/duotone/Communication/Write.svg-->
                                            <span class="svg-icon svg-icon-3">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953)" />
                                                                        <path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                                    </svg>
                                                                </span>
                                            <!--end::Svg Icon-->
                                        </a>
                                        <a type="button" onclick="deleteguard({{$guard->id}})" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                            <!--begin::Svg Icon | path: icons/duotone/General/Trash.svg-->
                                            <span class="svg-icon svg-icon-3">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <rect x="0" y="0" width="24" height="24" />
                                                                            <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero" />
                                                                            <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3" />
                                                                        </g>
                                                                    </svg>
                                                                </span>
                                            <!--end::Svg Icon-->
                                        </a>
                                    </div>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                     
                            </tbody>
                            <!--end::Table body-->
                        </table>
                       
                        <!--end::Table-->
                    </div>
                    <!--end::Table container-->
                </div>
                <!--begin::Body-->
            </div>
            <!--end::Tables Widget 12-->
            <!--begin::Tables Widget 13-->
            <div class="card mb-5 mb-xl-8" style="display: none;">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Recent Sites</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Newly Added Job Sites</span>
                    </h3>

                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3">
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                            <!--begin::Table head-->
                            <thead>
                            <tr class="fw-bolder text-muted">
                               
                                <th class="min-w-150px">Booking Id</th>
                                <th class="min-w-140px">Customer</th>
                                <th class="min-w-120px">Site</th>
                                <th class="min-w-120px">Date</th>
                                <th class="min-w-120px">Status</th>
                            </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>
                                
                                @foreach ($shifts as $shift)
                                    
                            <tr>
                              
                                <td>
                                    <a  class="text-dark fw-bolder text-hover-primary fs-6">{{$shift->booking_id}}</a>
                                </td>
                                <td>
                                    <a  class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6">{{$shift->customer_name}}</a>
                                    <span class="text-muted fw-bold text-muted d-block fs-7"></span>
                                </td>
                              
                                <td>
                                    <a  class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6">{{$shift->site_name}}({{$shift->site_description}})</a>
                                    <span class="text-muted fw-bold text-muted d-block fs-7"></span>
                                </td>
                                <td>
                                    <a  class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6">{{
                                    Date("d-m-Y",strtotime($shift->temp_date))
                                    }}</a>
                                    <span class="text-muted fw-bold text-muted d-block fs-7"></span>
                                </td>
                              
                                <td>
                                    @if($shift->jobs_status=='active')
                                    <span class="badge badge-light-success"> Active</span>
                                    @else
                                    <span class="badge badge-light-success">{{$shift->jobs_status}}</span>
                                    @endif
                                </td>
                                {{-- <td class="text-end">
                                    <a  class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                        <!--begin::Svg Icon | path: icons/duotone/General/Settings-1.svg-->
                                        <span class="svg-icon svg-icon-3">
																<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																		<rect x="0" y="0" width="24" height="24" />
																		<path d="M7,3 L17,3 C19.209139,3 21,4.790861 21,7 C21,9.209139 19.209139,11 17,11 L7,11 C4.790861,11 3,9.209139 3,7 C3,4.790861 4.790861,3 7,3 Z M7,9 C8.1045695,9 9,8.1045695 9,7 C9,5.8954305 8.1045695,5 7,5 C5.8954305,5 5,5.8954305 5,7 C5,8.1045695 5.8954305,9 7,9 Z" fill="#000000" />
																		<path d="M7,13 L17,13 C19.209139,13 21,14.790861 21,17 C21,19.209139 19.209139,21 17,21 L7,21 C4.790861,21 3,19.209139 3,17 C3,14.790861 4.790861,13 7,13 Z M17,19 C18.1045695,19 19,18.1045695 19,17 C19,15.8954305 18.1045695,15 17,15 C15.8954305,15 15,15.8954305 15,17 C15,18.1045695 15.8954305,19 17,19 Z" fill="#000000" opacity="0.3" />
																	</g>
																</svg>
															</span>
                                        <!--end::Svg Icon-->
                                    </a>
                                    <a  class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                        <!--begin::Svg Icon | path: icons/duotone/Communication/Write.svg-->
                                        <span class="svg-icon svg-icon-3">
																<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953)" />
																	<path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
																</svg>
															</span>
                                        <!--end::Svg Icon-->
                                    </a>
                                    <a  class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                        <!--begin::Svg Icon | path: icons/duotone/General/Trash.svg-->
                                        <span class="svg-icon svg-icon-3">
																<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																		<rect x="0" y="0" width="24" height="24" />
																		<path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero" />
																		<path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3" />
																	</g>
																</svg>
															</span>
                                        <!--end::Svg Icon-->
                                    </a>
                                </td> --}}
                            </tr>
                            @endforeach
                       
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Table container-->
                </div>
            </div>
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
                    dashboard_shift_notes();
                    roster_progress();


                    count_dashboard();
                    shifts_hour_chart();
                    @if (session()->get('userType') == 'admin')
                    security_license_expiry_check();
                    uncovered_shifts_check();   
                    most_recent_operation_note({{session()->get('userId')}});
                    @endif
 
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

  
  function security_license_expiry_check(){
  $.ajax({
        type: "POST",
        url: "{{url('security_license_expiry_check')}}", 
        data:{_token:'<?php echo csrf_token();?>'},
        success: function(result){

            // result = JSON.parse(result);
            var list = '';
        if (result.length === 0) {

        }
        else{
          list +=`<h4 class="popup_head text-center" id="myModalLabel">Documents Expiry</h4></br><table id="security_modal_body_table" align="center" class="nowrap table-bordered  " border="1"  ><thead><tr><th  class="popup_head" >Document</th><th  class="popup_head" >{{config('custom.guard')}} Name</th><th  class="popup_head" >Expiry Date</th></tr></thead>`;
            $.each(result, function(id, data){
              list += '<tr><th scope="row">Security License</th><td>' + data.name + '</td><td>' + data.security_license_expiration + '</td></tr>';
               });
               list+=`</table>`;


               $('#security_modal_body').html(list);
            //    $('#security_modal_body_table').DataTable();
               $("#security_modal").modal('show');
        }
        }
        });
}



         function uncovered_shifts_check(){
  $.ajax({
        type: "POST",
        url: "{{url('uncovered_shifts_check')}}",
        data:{_token:'<?php echo csrf_token();?>'},

        success: function(result){

            // result = JSON.parse(result);
            var list = '';
        if (result.length === 0) {

        }
        else{
          list +=`<h4 class="popup_head text-center" id="myModalLabel">Uncovered Shifts</h4></br>
<table align="center" id="uncover_modal_body_table" class="nowrap table-bordered  "   border="1"><thead><tr><th class="popup_head">Site Name</th><th  class="popup_head">Site Description</th><th  class="popup_head">From-To</th><th  class="popup_head" >Date</th></tr></thead>`;
            $.each(result, function(id, data){
              list += '<tr><td>' + data.site_name + '</td><td>' + data.site_description + '</td><td>' + data.temp_start + '-' + data.temp_end  + '</td><td>' + data.temp_date + '</td></tr>';
               });
               list+=`</table>`;


               $('#uncover_modal_body').html(list);
            //    $('#uncover_modal_body_table').DataTable();
               $("#uncover_modal").modal('show');
        }
        }
        });
}



            </script>

    @stop