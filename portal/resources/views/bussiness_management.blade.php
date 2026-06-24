
@section('pageCss')
<base href="../../../">
<meta charset="utf-8" />
<title>{{ config('custom.title');}}</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<link rel="canonical" href="Https://preview.keenthemes.com/metronic8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<!-- <link rel="shortcut icon" href="{{ asset('')}}media/logos/favicon.ico" /> -->
<!--begin::Fonts-->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700" />
<!--end::Fonts-->
<!--begin::Page Vendor Stylesheets(used by this page)-->
<link href="{{ asset('')}}plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
<!--end::Page Vendor Stylesheets-->
<!--begin::Global Stylesheets Bundle(used by all pages)-->
<link href="{{ asset('')}}plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
<link href="{{ asset('')}}css/style.bundle.css" rel="stylesheet" type="text/css" />
<!--begin::Wrapper-->
<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
    <!--begin::Header-->
    <div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header"
        data-kt-sticky-offset="{default: '200px', lg: '300px'}">
        <!--begin::Container-->
        <div class="container d-flex align-items-center justify-content-between" id="kt_header_container">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-2 pb-2 pb-lg-0"
                data-kt-swapper="true" data-kt-swapper-mode="prepend"
                data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
                <!--begin::Heading-->
                <h1 class="text-dark fw-bolder my-0 fs-2">Bussinesses List</h1>
                <!--end::Heading-->
            </div>
            <!--end::Page title=-->
            <!--begin::Wrapper-->
            <div class="d-flex d-lg-none align-items-center ms-n2 me-2">
                <!--begin::Aside mobile toggle-->
                <div class="btn btn-icon btn-active-icon-primary" id="kt_aside_toggle">
                    <!--begin::Svg Icon | path: icons/duotone/Text/Menu.svg-->
                    <span class="svg-icon svg-icon-2x">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <rect fill="#000000" x="4" y="5" width="16" height="3" rx="1.5" />
                                <path
                                    d="M5.5,15 L18.5,15 C19.3284271,15 20,15.6715729 20,16.5 C20,17.3284271 19.3284271,18 18.5,18 L5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 Z M5.5,10 L18.5,10 C19.3284271,10 20,10.6715729 20,11.5 C20,12.3284271 19.3284271,13 18.5,13 L5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 Z"
                                    fill="#000000" opacity="0.3" />
                            </g>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Aside mobile toggle-->
                <!--begin::Logo-->
             
                <!--end::Logo-->
            </div>
            <!--end::Wrapper-->
            {{-- @include('layout.toolbar')
            @yield('toolbar') --}}
            <a href="{{url('bussiness_do_logout')}}" class="btn-primary btn text-end">Log out</a>
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
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            <!--begin::Svg Icon | path: icons/duotone/General/Search.svg-->
                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <path
                                            d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z"
                                            fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                        <path
                                            d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z"
                                            fill="#000000" fill-rule="nonzero" />
                                    </g>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <input type="text" id="search" class="form-control form-control-solid w-250px ps-14"
                                placeholder="Search bussiness" />
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">

                            <!--begin::Add user-->
                            <button type="button" id="#add_bussiness_button" class="btn btn-primary"
                                data-bs-toggle="modal" data-bs-target="#add_bussiness_modal">
                                <!--begin::Svg Icon | path: icons/duotone/Navigation/Plus.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1" />
                                        <rect fill="#000000" opacity="0.5"
                                            transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000)"
                                            x="4" y="11" width="16" height="2" rx="1" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon--><span>Add Bussiness</span></button>
                            <!--end::Add user-->
                        </div>
                        <!--end::Toolbar-->
                        <!--begin::Group actions-->
                        <div class="d-flex justify-content-end align-items-center d-none"
                            data-kt-user-table-toolbar="selected">
                            <div class="fw-bolder me-5">
                                <span class="me-2" data-kt-user-table-select="selected_count"></span>Selected</div>
                            <button type="button" class="btn btn-danger"
                                data-kt-user-table-select="delete_selected">Delete Selected</button>
                        </div>
                        <!--end::Group actions-->
                        <!--begin::Modal - Adjust Balance-->
                     
                        <!--end::Modal - New Card-->
                     
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="table">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-">Bussiness</th>
                                <th class="min-w-">Unique ID</th>
                                <th class=" min-w-">Address</th>
                                <th class=" min-w-">Domain</th>
                                <th class=" min-w-">Bussiness Type	</th>
                                <th class="min-w-">Action</th>
                                </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="text-gray-600 fw-bold">
                            <!--begin::Table row-->
                            @foreach($bussinesss as $bussiness)
                            <tr>
                                <td class="d-flex align-items-center">
                                    <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                        <div class="symbol-label ">
                                            <img src="{{config('custom.asset_url')}}{{$bussiness->logo}}" alt=""
                                                class="w-100" />
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <a href="{{url('profile') . '/' . $bussiness->id}}"
                                            class="text-gray-800 text-hover-primary mb-1">{{$bussiness->title}}</a>
                                        <span>{{$bussiness->email}}</span>
                                    </div>
                                </td>
                                <td>
                                    {{$bussiness->unique_id}}
                                </td>
                                <td>
                                    {{$bussiness->address}}
                                </td>
                                <td>{{$bussiness->domain}}</td>
                                <td>{{$bussiness->business_type}}</td>
                                <td class="text-end">
                                    @if($bussiness->approve==0 && $bussiness->business_type=="demo")
                                    <div class="d-flex justify-content-end flex-shrink-0">
                                    <a type="button" onclick="approve_bussiness({{$bussiness->id}})" class="btn-primary btn-sm ">approve
                                    </a>
                                    </div>
                                    @endif
                                    <div class="d-flex justify-content-end flex-shrink-0">


                                        <a type="button" onclick="window.open('{{url('bussiness_management_config')}}/{{$bussiness->id}}','_blank')" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                            <!--begin::Svg Icon | path: icons/duotone/Communication/Write.svg-->
                                            <span class="svg-icon svg-icon-3">
                                                <svg class="svg-icon" viewBox="0 0 20 20">
                                                    <path d="M17.498,11.697c-0.453-0.453-0.704-1.055-0.704-1.697c0-0.642,0.251-1.244,0.704-1.697c0.069-0.071,0.15-0.141,0.257-0.22c0.127-0.097,0.181-0.262,0.137-0.417c-0.164-0.558-0.388-1.093-0.662-1.597c-0.075-0.141-0.231-0.22-0.391-0.199c-0.13,0.02-0.238,0.027-0.336,0.027c-1.325,0-2.401-1.076-2.401-2.4c0-0.099,0.008-0.207,0.027-0.336c0.021-0.158-0.059-0.316-0.199-0.391c-0.503-0.274-1.039-0.498-1.597-0.662c-0.154-0.044-0.32,0.01-0.416,0.137c-0.079,0.106-0.148,0.188-0.22,0.257C11.244,2.956,10.643,3.207,10,3.207c-0.642,0-1.244-0.25-1.697-0.704c-0.071-0.069-0.141-0.15-0.22-0.257C7.987,2.119,7.821,2.065,7.667,2.109C7.109,2.275,6.571,2.497,6.07,2.771C5.929,2.846,5.85,3.004,5.871,3.162c0.02,0.129,0.027,0.237,0.027,0.336c0,1.325-1.076,2.4-2.401,2.4c-0.098,0-0.206-0.007-0.335-0.027C3.001,5.851,2.845,5.929,2.77,6.07C2.496,6.572,2.274,7.109,2.108,7.667c-0.044,0.154,0.01,0.32,0.137,0.417c0.106,0.079,0.187,0.148,0.256,0.22c0.938,0.936,0.938,2.458,0,3.394c-0.069,0.072-0.15,0.141-0.256,0.221c-0.127,0.096-0.181,0.262-0.137,0.416c0.166,0.557,0.388,1.096,0.662,1.596c0.075,0.143,0.231,0.221,0.392,0.199c0.129-0.02,0.237-0.027,0.335-0.027c1.325,0,2.401,1.076,2.401,2.402c0,0.098-0.007,0.205-0.027,0.334C5.85,16.996,5.929,17.154,6.07,17.23c0.501,0.273,1.04,0.496,1.597,0.66c0.154,0.047,0.32-0.008,0.417-0.137c0.079-0.105,0.148-0.186,0.22-0.256c0.454-0.453,1.055-0.703,1.697-0.703c0.643,0,1.244,0.25,1.697,0.703c0.071,0.07,0.141,0.15,0.22,0.256c0.073,0.098,0.188,0.152,0.307,0.152c0.036,0,0.073-0.004,0.109-0.016c0.558-0.164,1.096-0.387,1.597-0.66c0.141-0.076,0.22-0.234,0.199-0.393c-0.02-0.129-0.027-0.236-0.027-0.334c0-1.326,1.076-2.402,2.401-2.402c0.098,0,0.206,0.008,0.336,0.027c0.159,0.021,0.315-0.057,0.391-0.199c0.274-0.5,0.496-1.039,0.662-1.596c0.044-0.154-0.01-0.32-0.137-0.416C17.648,11.838,17.567,11.77,17.498,11.697 M16.671,13.334c-0.059-0.002-0.114-0.002-0.168-0.002c-1.749,0-3.173,1.422-3.173,3.172c0,0.053,0.002,0.109,0.004,0.166c-0.312,0.158-0.64,0.295-0.976,0.406c-0.039-0.045-0.077-0.086-0.115-0.123c-0.601-0.6-1.396-0.93-2.243-0.93s-1.643,0.33-2.243,0.93c-0.039,0.037-0.077,0.078-0.116,0.123c-0.336-0.111-0.664-0.248-0.976-0.406c0.002-0.057,0.004-0.113,0.004-0.166c0-1.75-1.423-3.172-3.172-3.172c-0.054,0-0.11,0-0.168,0.002c-0.158-0.312-0.293-0.639-0.405-0.975c0.044-0.039,0.085-0.078,0.124-0.115c1.236-1.236,1.236-3.25,0-4.486C3.009,7.719,2.969,7.68,2.924,7.642c0.112-0.336,0.247-0.664,0.405-0.976C3.387,6.668,3.443,6.67,3.497,6.67c1.75,0,3.172-1.423,3.172-3.172c0-0.054-0.002-0.11-0.004-0.168c0.312-0.158,0.64-0.293,0.976-0.405C7.68,2.969,7.719,3.01,7.757,3.048c0.6,0.6,1.396,0.93,2.243,0.93s1.643-0.33,2.243-0.93c0.038-0.039,0.076-0.079,0.115-0.123c0.336,0.112,0.663,0.247,0.976,0.405c-0.002,0.058-0.004,0.114-0.004,0.168c0,1.749,1.424,3.172,3.173,3.172c0.054,0,0.109-0.002,0.168-0.004c0.158,0.312,0.293,0.64,0.405,0.976c-0.045,0.038-0.086,0.077-0.124,0.116c-0.6,0.6-0.93,1.396-0.93,2.242c0,0.847,0.33,1.645,0.93,2.244c0.038,0.037,0.079,0.076,0.124,0.115C16.964,12.695,16.829,13.021,16.671,13.334 M10,5.417c-2.528,0-4.584,2.056-4.584,4.583c0,2.529,2.056,4.584,4.584,4.584s4.584-2.055,4.584-4.584C14.584,7.472,12.528,5.417,10,5.417 M10,13.812c-2.102,0-3.812-1.709-3.812-3.812c0-2.102,1.71-3.812,3.812-3.812c2.102,0,3.812,1.71,3.812,3.812C13.812,12.104,12.102,13.812,10,13.812"></path>                                 
                                                 </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </a>
                                        
                                        <a type="button" onclick="get_bussiness({{$bussiness->id}})" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                            <!--begin::Svg Icon | path: icons/duotone/Communication/Write.svg-->
                                            <span class="svg-icon svg-icon-3">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953)"></path>
                                                                        <path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                                                    </svg>
                                                                </span>
                                            <!--end::Svg Icon-->
                                        </a>
                                        <a type="button" onclick="deletebussiness({{$bussiness->id}})" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                            <!--begin::Svg Icon | path: icons/duotone/General/Trash.svg-->
                                            <span class="svg-icon svg-icon-3">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <rect x="0" y="0" width="24" height="24"></rect>
                                                                            <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path>
                                                                            <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path>
                                                                        </g>
                                                                    </svg>
                                                                </span>
                                            <!--end::Svg Icon-->
                                        </a>
                                        
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            <!--end::Table row-->
                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Content-->
    <!--begin::Footer-->
    <div class="modal fade" id="add_bussiness_modal" tabindex="-1" aria-hidden="true" data-backdrop="static"
        data-keyboard="false">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header" id="add_bussiness_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bolder" id="form_head">Add Bussiness</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                     X
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <!--begin::Form-->
                    <form id="add_bussiness_form" class="form" action="{{url('update_bussiness')}}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="bussiness_id" name="bussiness_id" />
                        <div class="d-flex flex-column scroll-y me-n7 pe-7" id="add_bussiness_scroll"
                            data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                            data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#add_bussiness_header"
                            data-kt-scroll-wrappers="#add_bussiness_scroll" data-kt-scroll-offset="300px">
                            <div class="row">
                                    <div class="col-sm-6">
                                        <div class="fv-row mb-7">
                                            <label class="required fw-bold fs-6 mb-2">Domain</label>
                                            <input placeholder="Domain" type="text" id="domain" name="domain"
                                                class="form-control form-control-solid mb-3 mb-lg-0"
                                                required />
                                        </div>
                                    </div>
                            <div class="col-sm-6">
                            <div class="fv-row mb-7">
                                <label class="d-block fw-bold fs-6 mb-2">Logo</label>
                                <input accept="image/png, image/gif, image/jpeg" type="file" onchange="upload_file('logo', 'logoUploaded')" type="file" class="form-control form-control-md" id="logo" name="logo"> 
                                <input type="hidden" name="logoUploaded" id="logoUploaded">

                                </div>
                            </div>

                            </div>
                        </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="fv-row mb-7">
                                        <label class="required fw-bold fs-6 mb-2">Bussiness Name</label>
                                        <input type="text" id="title" name="title"
                                            class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Bussiness Name"
                                            required />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="fv-row mb-7">
                                        <label class="required fw-bold fs-6 mb-2">Email</label>
                                        <input type="text" id="email" name="email"
                                            class="form-control form-control-solid mb-3 mb-lg-0"
                                            placeholder="example@domain.com"  required />
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <div id="unique_id_div" style="display: none" class="fv-row mb-7">
                                        <label class="required fw-bold fs-6 mb-2">Unique ID</label>
                                        <input placeholder="Unique ID" type="text" id="unique_id"
                                            class="form-control form-control-solid mb-3 mb-lg-0"
                                             />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="fv-row mb-7">
                                        <label class="required fw-bold fs-6 mb-2">Address</label>
                                        <input placeholder="Address" type="text" id="address" name="address"
                                            class="form-control form-control-solid mb-3 mb-lg-0"
                                            required />
                                    </div>
                                </div>
                            </div>
                            
                        

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="fv-row mb-7">
                                        <label class="required fw-bold fs-6 mb-2">Bussiness Status</label>
                                        <select id="business_type" name="business_type" class="form-select"   data-placeholder="Select Bussiness Status option">
                                        <option value="live">Live<option>
                                            <option value="demo">Demo</option>
                                        </select>
                                        </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="fv-row mb-7">
                                        <label class="required fw-bold fs-6 mb-2">Business Type</label>
                                        <select id="guard" name="guard" class="form-select"   data-placeholder="Select Business Type option">
                                            <option value="Guard">Guard<option>
                                                <option value="Cleaner">Cleaner</option>
                                                <option value="Staff">Staff</option>
                                            </select>
                                       
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="fv-row mb-7">
                                        <label class="required fw-bold fs-6 mb-2">App ID</label>
                                        <input placeholder="App ID" type="text" id="app_id" name="app_id"
                                            class="form-control form-control-solid mb-3 mb-lg-0"
                                            required />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="fv-row mb-7">
                                        <label class="required fw-bold fs-6 mb-2">Server Key</label>
                                        <input placeholder="Server Key " type="text" id="server_key" name="server_key"
                                            class="form-control form-control-solid mb-3 mb-lg-0"
                                            required />
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="fv-row mb-7">
                                        <label class="fw-bold fs-6 mb-2">About Company</label>
                                       <textarea name="about_us" id="about_us" class="form-control form-control-solid mb-3 mb-lg-0" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                            <div class="fv-row mb-7">
                                <label class="d-block fw-bold fs-6 mb-2">About Files</label>
                                <input type="file" multiple class="form-control form-control-md" id="about_files" name="about_files[]"> 

                                </div>
                            </div>
                            </div>

                        </div>
                        <!--end::Scroll-->
                        <!--begin::Actions-->
                        <div class="modal-footer footer text-center ">
                            <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                                <span class="indicator-label" id="form_button">Submit</span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>


    <script src="{{ asset('')}}plugins/global/plugins.bundle.js"></script>
    <script src="{{ asset('')}}js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Page Vendors Javascript(used by this page)-->
    <script src="{{ asset('')}}plugins/custom/datatables/datatables.bundle.js"></script>
    <!--end::Page Vendors Javascript-->
    <!--begin::Page Custom Javascript(used by this page)-->
    <script src="{{ asset('')}}js/custom/apps/user-management/users/list/table.js"></script>
    <script src="{{ asset('')}}js/custom/apps/user-management/users/list/export-users.js"></script>
    <script src="{{ asset('')}}js/custom/apps/user-management/users/list/add.js"></script>
    <script src="{{ asset('')}}js/custom/widgets.js"></script>
    <script src="{{ asset('')}}js/custom/apps/chat/chat.js"></script>
    <script src="{{ asset('')}}js/custom/modals/create-app.js"></script>
    <script src="{{ asset('')}}js/custom/modals/upgrade-plan.js"></script>
    <!--end::Page Custom Javascript-->
    <!--end::Javascript-->


    <script>
        $(document).ready(function () {
            var table = $('#table').DataTable();
// #myInput is a <input type="text"> element
$('#search').on( 'keyup', function () {
    table.search( this.value ).draw();
} );
        });

       function approve_bussiness(id)
{
    $.ajax({type: "GET",url: "{{url('bussiness/approve_bussiness')}}" ,data:{id:id,
                            _token: '<?php echo csrf_token();?>'
                        } ,success: function(result){if(result.success){
									Swal.fire({
													text: result.message,
													icon: "success",
													buttonsStyling: !1,
													confirmButtonText: "Ok, got it!",
													customClass: {
														confirmButton: "btn btn-light"
													}
						})
                        window.location.href = "{{ url('/bussiness_management')}}";

					}else{Swal.fire({
											text: result.error,
											icon: "error",
											buttonsStyling: !1,
											confirmButtonText: "Ok, got it!",
											customClass: {
												confirmButton: "btn btn-light"
											}
										})
                                        }
                                        }})
}        
   
        function deletebussiness(id) {
            var id = id;

            Swal.fire({
                text: "Are you sure you want to delete ?",
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
                    $.ajax({
                        type: "POST",
                        url: `{{url('deletebussiness')}}`,
                        data: {id:id,
                            _token: '<?php echo csrf_token();?>'
                        },
                        success: function (result) {
                            Swal.fire({
                                text: "Deleted Succesfully.",
                                icon: "success",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            })
                            window.location.href = "{{ url('/bussiness_management')}}";
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
        function get_bussiness(id){
            $('#add_bussiness_modal').modal('show');
        $.ajax({type:"GET",url:"{{url('get_bussiness')}}",data:{id:id,_token:"<?php echo csrf_token() ?>"},success:function(result){
                $('#title').val(result.result.title);
                $('#domain').val(result.result.domain);
                $('#app_id').val(result.result.app_id);
                $('#server_key').val(result.result.server_key);
                $('#logoUploaded').val(result.result.logo);
                $('#email').val(result.result.email);
                $('#address').val(result.result.address);
                $('#business_type').val(result.result.business_type);
                $('#guard').val(result.result.guard);
                $('#unique_id').val(result.result.unique_id);
                $('#unique_id').prop("readonly",true);
                $('#unique_id_div').show();
                $('#bussiness_id').val(result.result.id);
                $('#about_us').val(result.result.about_us);
            }
        })

        }      
        
        
        $("#add_bussiness_form").on('submit', function(e) {
			e.preventDefault();
			// console.log(this.id)
            var data = new FormData(this);
            // data.append('about_files', $('input#about_files')[0].files[0]);
            // var filesLength=document.getElementById('about_files').files.length;
            // for(var i=0;i<filesLength;i++){
                // data.append("about_files", document.getElementById('about_files').files[0]);
                // data.append("about_files[]", $('input#about_files')[i].files[0]);
            // }
            // console.log(filesLength);
            // return;
			// var data = $('#' + this.id).serialize();
			$.ajax({
				type: "POST",
				url: this.action,
				data: data,
                dataType: "json",
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
						window.location.href = "{{ url('/bussiness_management')}}";
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
	  var targetInput = '';
    function upload_file(i, j)
    {
        targetInput = j;
        // errorAlert('Please wait image is uploading...');
        readImage(document.getElementById(i), i);
    }

    function readImage(e, i) {
  if (e.files && e.files[0]) {

    var FR= new FileReader();

    FR.addEventListener("load", function(e) {
     var image =  e.target.result;
     if (image != '') {
     $.ajax({
        type: "POST",
        url: "{{url('guard/upload_files')}}",
        data : {image:image, _token : '{{ csrf_token()}}'},
        success: function(result){
        	console.log(result)
            var obj = result;
            if (obj.success) {
                $('#'+i).val('');
                // successAlert('Image upload successfully.');
                $('#'+targetInput).val(obj.path);
            }else{
            // errorAlert('Failed to upload image!');
                $('#'+i).val('');
            }

        }
        });

  }else{
    alertify.error('Not a valid image!')

  }
   }); 

    FR.readAsDataURL( e.files[0] );
  }

}
    </script>



