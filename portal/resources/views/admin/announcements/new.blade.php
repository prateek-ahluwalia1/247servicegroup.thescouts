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
<link href="{{asset('')}}plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css"/>
{{-- richtedxt --}}
<link rel="stylesheet" href="{{asset('')}}richtext/richtext.min.css">
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="https://cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="{{ asset('')}}plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />

@stop
<!--end::Head-->
<!--begin::Body-->
@section('content')


<!--begin::Form-->			
<!--begin::Wrapper-->
<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
    <!--begin::Header-->
    <div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
        <!--begin::Container-->
        <div class="container d-flex align-items-center justify-content-between" id="kt_header_container">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-2 pb-2 pb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
                <!--begin::Heading-->
                <h1 class="text-dark fw-bolder my-0 fs-2">Announcements</h1>
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
                            <!-- <a href="index.html" class="d-flex align-items-center">
                                <img alt="Logo" src="{{config('custom.logo')}}" class="h-30px" />
                            </a> -->
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
                        <!--begin::Card-->
                        <div class="card">
                            <!--begin::Card body-->
                            <div class="card-body p-0">

                                <!--begin::Row-->
                                <div class="row p-20 container">
                                    <div class="col-12 text-center mb-4">
                                        <a class="btn btn-flex flex-center btn-bg-white btn-text-gray-500 btn-active-color-primary w-40px w-md-auto h-40px px-0 px-md-6" tooltip="New App" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app" id="kt_toolbar_primary_button" onclick="openCreateApp()">Add New</a>
                                    </div>
                                    <div class="col-md-6" style="border-right: 1px dotted ;">
                                        <div class="card-px text-center">
                                            <!--begin::Title-->
                                            <h2 class="fs-2x fw-bolder mb-10">Announcements</h2>
                                            <!--end::Title-->
                                        </div>
                                        <div class="m-0">

                                        @foreach($results as $key => $an)
                                                <!--begin::Item-->
                                                <div class="d-flex flex-stack mb-7">
                                                    <!--begin::Symbol-->
                                                    <div class="symbol symbol-60px symbol-2by3 me-4">
                                                        <div class="symbol-label" style="background-image: url('{{asset('')}}media/announcement.jpg')"></div>
                                                    </div>
                                                    <!--end::Symbol-->
                                                    <!--begin::Title-->
                                                    <div class="m-0">
                                                        <a class="text-dark fw-bolder text-hover-primary fs-6">{{$an->title}}</a>
                                                        <span class="text-gray-600 fw-bold d-block pt-1 fs-7">{{$an->updated_at}}</span>
                                                    </div>
                                                    <!--end::Title-->
                                                    <div class="d-flex align-items-center py-2">
                                                        <div class="card-toolbar">            
            <!--begin::Menu-->
            <button class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">                
                <!--begin::Svg Icon | path: icons/duotune/general/gen023.svg-->
<span class="svg-icon svg-icon-1 svg-icon-gray-300 me-n1"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="4" fill="currentColor"></rect>
<rect x="11" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor"></rect>
<rect x="15" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor"></rect>
<rect x="7" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor"></rect>
</svg>
</span>
<!--end::Svg Icon-->                             
            </button><div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px" data-kt-menu="true" style="">
   
    <div class="menu-item px-3">
        <a class="menu-link px-3" onclick="viewData('announcement', {{$an->id}})">
            View
        </a>
    </div>
    <!--begin::Menu item-->
    <div class="menu-item px-3">
        <a class="menu-link px-3" onclick="editData('announcement', {{$an->id}})">
            Edit
        </a>
    </div>
    <!--end::Menu item-->
    
    <!--begin::Menu item-->
    <div class="menu-item px-3">
        <a onclick="deleteData('announcement', {{$an->id}})" class="menu-link px-3">
            Delete
        </a>
    </div>
    <!--end::Menu item-->

</div>

            
<!--begin::Menu 2-->

<!--end::Menu 2-->
 
            <!--end::Menu-->             
        </div>
                                                        <!-- <button type="reset" class="btn btn-sm btn-white btn-active-light-primary me-3" onclick="deleteData('announcement', {{$an->id}})">Delete</button>
                                                        <button class="btn btn-sm btn-light btn-active-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_new_card" onclick="editData('announcement', {{$an->id}})">Edit</button> -->
                                                    </div>
                                                </div>
                                                <!--end::Item-->
                                                
                                        @endforeach
                                            </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card-px text-center">
                                            <!--begin::Title-->
                                            <h2 class="fs-2x fw-bolder mb-10">Inductions</h2>
                                            <!--end::Title-->
                                        </div>
                                        <div class="m-0">

                                        @foreach($inductions as $key => $in)
                                                <!--begin::Item-->
                                                <div class="d-flex flex-stack mb-7">
                                                    <!--begin::Symbol-->
                                                    <div class="symbol symbol-60px symbol-2by3 me-4">
                                                        <div class="symbol-label" style="background-image: url('{{asset('')}}media/induction.jpeg')"></div>
                                                    </div>
                                                    <!--end::Symbol-->
                                                    <!--begin::Title-->
                                                    <div class="m-0">
                                                        <a class="text-dark fw-bolder text-hover-primary fs-6">{{$in->title}}</a>
                                                        <span class="text-gray-600 fw-bold d-block pt-1 fs-7">{{$in->updated_at}}</span>
                                                    </div>
                                                    <!--end::Title-->
                                                    <div class="d-flex align-items-center py-2">
                                                         <div class="card-toolbar">            
            <!--begin::Menu-->
            <button class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">                
                <!--begin::Svg Icon | path: icons/duotune/general/gen023.svg-->
<span class="svg-icon svg-icon-1 svg-icon-gray-300 me-n1"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="4" fill="currentColor"></rect>
<rect x="11" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor"></rect>
<rect x="15" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor"></rect>
<rect x="7" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor"></rect>
</svg>
</span>
<!--end::Svg Icon-->                             
            </button><div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px" data-kt-menu="true" style="">
   
                <div class="menu-item px-3">
        <a class="menu-link px-3" onclick="viewData('induction', {{$in->id}})">
            view
        </a>
    </div>
    <!--begin::Menu item-->
    <div class="menu-item px-3">
        <a class="menu-link px-3" onclick="editData('induction', {{$in->id}})">
            Edit
        </a>
    </div>
    <!--end::Menu item-->
    
    <!--begin::Menu item-->
    <div class="menu-item px-3">
        <a onclick="deleteData('induction', {{$in->id}})" class="menu-link px-3">
            Delete
        </a>
    </div>
    <!--end::Menu item-->

</div>

            
<!--begin::Menu 2-->

<!--end::Menu 2-->
 
            <!--end::Menu-->             
        </div>
                                                      <!--   <button type="reset" class="btn btn-sm btn-white btn-active-light-primary me-3" onclick="deleteData('induction', {{$in->id}})">Delete</button>
                                                        <button class="btn btn-sm btn-light btn-active-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_new_card" onclick="editData('induction', {{$in->id}})">Edit</button> -->
                                                    </div>
                                                </div>
                                                <!--end::Item-->
                                                
                                        @endforeach
                                            </div>
                                    </div>
                                </div>

                            </div>
                            
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                       
                                <!--end::Modal - New Target-->

                                

                                        </div>
                                        <!--end::Container-->
                                    </div>
                                    <!--end::Content-->
                                    <!--begin::Footer-->

                                    <!--end::Footer-->
                                    <!--end::Wrapper-->
<div class="modal" id="kt_modal_detail" tabindex="-1" aria-modal="true" role="dialog">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-900px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2>Detail</h2>
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
                    <div class="modal-body py-lg-10 px-lg-10">
                        <h5><span id="p-title"></span></h5>
                        <div id="p-body"></div>
                    </div>
                </div>
            </div>
        </div>




                                    <div class="modal" id="kt_modal_create_app" tabindex="-1" aria-modal="true" role="dialog">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-900px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2 id="app-title">ADD NEW</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal" onclick="$('#kt_modal_create_app').toggle(); $('.modal-backdrop ').removeClass('show'); $('#kt_modal_create_app').css('display','none')">
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
                    <div class="modal-body py-lg-10 px-lg-10">
                        <!--begin::Stepper-->
                        <div class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid" id="kt_modal_create_app_stepper" data-kt-stepper="true">
                            <!--begin::Aside-->
                            <div class="d-flex justify-content-center justify-content-xl-start flex-row-auto w-100 w-xl-300px">
                                <!--begin::Nav-->
                                <div class="stepper-nav ps-lg-10">
                                    <!--begin::Step 1-->
                                    <div class="stepper-item current" data-kt-stepper-element="nav">
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
                                            <h3 class="stepper-title">Select Type</h3>
                                            <!-- <div class="stepper-desc">Select Type</div> -->
                                        </div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Step 1-->
                                    <!--begin::Step 2-->
                                    <div class="stepper-item" data-kt-stepper-element="nav">
                                        <!--begin::Line-->
                                        <div class="stepper-line w-40px"></div>
                                        <!--end::Line-->
                                        <!--begin::Icon-->
                                        <div class="stepper-icon w-40px h-40px">
                                            <i class="stepper-check fas fa-check"></i>
                                            <span class="stepper-number">2</span>
                                        </div>
                                        <!--begin::Icon-->
                                        <!--begin::Label-->
                                        <div class="stepper-label">
                                            <h3 class="stepper-title">Select</h3>
                                            <!-- <div class="stepper-desc">Define your app framework</div> -->
                                        </div>
                                        <!--begin::Label-->
                                    </div>
                                    <!--end::Step 2-->
                                    <!--begin::Step 3-->
                                    <div class="stepper-item" data-kt-stepper-element="nav">
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
                                            <h3 class="stepper-title">Details</h3>
                                            <!-- <div class="stepper-desc">Select the app database type</div> -->
                                        </div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Step 3-->
                                   
                                    
                                </div>
                                <!--end::Nav-->
                            </div>
                            <!--begin::Aside-->
                            <!--begin::Content-->
                            <div class="flex-row-fluid py-lg-5 px-lg-15">
                                <!--begin::Form-->
                                <form class="form fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate" id="kt_modal_add_new">
                                    <!--begin::Step 1-->
                                    <div class="current" data-kt-stepper-element="content">
                                        <div class="w-100">
                                            <input type="hidden" name="id" id="id">
                                            <!--begin::Input group-->
                                            <div class="fv-row">
                                                <!--begin::Label-->
                                                <label class="d-flex align-items-center fs-5 fw-bold mb-4">
                                                    <span class="required">Type</span>
                                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="" data-bs-original-title="Select your app category" aria-label="Select your app category"></i>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin:Options-->
                                                <div class="fv-row fv-plugins-icon-container">
                                                    <!--begin:Option-->
                                                    <label class="d-flex flex-stack mb-5 cursor-pointer">
                                                        <!--begin:Label-->
                                                        <span class="d-flex align-items-center me-2">
                                                            <!--begin:Icon-->
                                                            <span class="symbol symbol-50px me-6">
                                                                <span class="symbol-label bg-light-primary">
                                                                    <!--begin::Svg Icon | path: icons/duotone/Home/Globe.svg-->
                                                                    <span class="svg-icon svg-icon-1 svg-icon-primary">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                                                <path d="M13,18.9450712 L13,20 L14,20 C15.1045695,20 16,20.8954305 16,22 L8,22 C8,20.8954305 8.8954305,20 10,20 L11,20 L11,18.9448245 C9.02872877,18.7261967 7.20827378,17.866394 5.79372555,16.5182701 L4.73856106,17.6741866 C4.36621808,18.0820826 3.73370941,18.110904 3.32581341,17.7385611 C2.9179174,17.3662181 2.88909597,16.7337094 3.26143894,16.3258134 L5.04940685,14.367122 C5.46150313,13.9156769 6.17860937,13.9363085 6.56406875,14.4106998 C7.88623094,16.037907 9.86320756,17 12,17 C15.8659932,17 19,13.8659932 19,10 C19,7.73468744 17.9175842,5.65198725 16.1214335,4.34123851 C15.6753081,4.01567657 15.5775721,3.39010038 15.903134,2.94397499 C16.228696,2.49784959 16.8542722,2.4001136 17.3003976,2.72567554 C19.6071362,4.40902808 21,7.08906798 21,10 C21,14.6325537 17.4999505,18.4476269 13,18.9450712 Z" fill="#000000" fill-rule="nonzero"></path>
                                                                                <circle fill="#000000" opacity="0.3" cx="12" cy="10" r="6"></circle>
                                                                            </g>
                                                                        </svg>
                                                                    </span>
                                                                    <!--end::Svg Icon-->
                                                                </span>
                                                            </span>
                                                            <!--end:Icon-->
                                                            <!--begin:Info-->
                                                            <span class="d-flex flex-column">
                                                                <span class="fw-bolder fs-6">Induction</span>
                                                            </span>
                                                            <!--end:Info-->
                                                        </span>
                                                        <!--end:Label-->
                                                        <!--begin:Input-->
                                                        <span class="form-check form-check-custom form-check-solid">
                                                            <input class="form-check-input" type="radio" name="type" value="induction" checked="">
                                                        </span>
                                                        <!--end:Input-->
                                                    </label>
                                                    <!--end::Option-->
                                                    <!--begin:Option-->
                                                    <label class="d-flex flex-stack mb-5 cursor-pointer">
                                                        <!--begin:Label-->
                                                        <span class="d-flex align-items-center me-2">
                                                            <!--begin:Icon-->
                                                            <span class="symbol symbol-50px me-6">
                                                                <span class="symbol-label bg-light-danger">
                                                                    <!--begin::Svg Icon | path: icons/duotone/Layout/Layout-4-blocks-2.svg-->
                                                                    <span class="svg-icon svg-icon-1 svg-icon-danger">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                                <rect x="5" y="5" width="5" height="5" rx="1" fill="#000000"></rect>
                                                                                <rect x="14" y="5" width="5" height="5" rx="1" fill="#000000" opacity="0.3"></rect>
                                                                                <rect x="5" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3"></rect>
                                                                                <rect x="14" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3"></rect>
                                                                            </g>
                                                                        </svg>
                                                                    </span>
                                                                    <!--end::Svg Icon-->
                                                                </span>
                                                            </span>
                                                            <!--end:Icon-->
                                                            <!--begin:Info-->
                                                            <span class="d-flex flex-column">
                                                                <span class="fw-bolder fs-6">Announcements</span>
                                                            </span>
                                                            <!--end:Info-->
                                                        </span>
                                                        <!--end:Label-->
                                                        <!--begin:Input-->
                                                        <span class="form-check form-check-custom form-check-solid">
                                                            <input class="form-check-input" type="radio" name="type" value="announcement">
                                                        </span>
                                                        <!--end:Input-->
                                                    </label>
                                                    <!--end::Option-->
                                                <div class="fv-plugins-message-container invalid-feedback"></div></div>
                                                <!--end:Options-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                    </div>
                                    <!--end::Step 1-->
                                    <!--begin::Step 2-->
                                    <div data-kt-stepper-element="content">
                                        <div class="w-100">
                                            <!--begin::Input group-->
                                            <div class="fv-row fv-plugins-icon-container">
                                                <div class="fv-row mb-10 ">
                                                <!--begin::Label-->
                                                <label class="d-flex align-items-center fs-5 fw-bold mb-2">
                                                    <span class="required">Title</span>
                                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="" data-bs-original-title="Specify your unique name" aria-label="Specify your unique name"></i>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" class="form-control form-control-lg form-control-solid" name="title" placeholder="">
                                                <!--end::Input-->
                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                        </div>
                                            <!-- end here -->
                                                <div class="fv-row mb-10 " style="display: none;">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="form-check form-check-custom form-check-solid me-10" style="padding-top:27px;">
                                                                <input class="form-check-input h-30px w-30px" type="radio" name="sent_by"  value="guards" checked="" />
                                                                <label class="form-check-label" for="flexRadio30">
                                                                    {{config('custom.guard')}}
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-check form-check-custom form-check-solid me-10" style="padding-top:27px;">
                                                                <input class="form-check-input h-30px  w-30px" type="radio" name="sent_by" value="customers"/>
                                                                <label class="form-check-label" for="flexRadio30">
                                                                    Customers
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="fv-row mb-10" id="guard-div">
                                                <!--begin::Label-->
                                                <label class="d-flex align-items-center fs-5 fw-bold mb-4">
                                                    <span class="required">Select {{config('custom.guard')}}s</span>
                                                    
                                                </label>
                                                <!--end::Label-->
                                              
                                               
                                                <!--begin:Option-->
                                                    <select name="guard_selection[]" id="guard_selection" multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1">
                                                        @foreach($guards as $guard)
                                                        <option value="{{$guard->id}}">{{$guard->name}}</option>
                                                        @endforeach
                                                    </select>
                                                <!--end::Option-->
                                            </div>
                                            <div class="fv-row mb-10" style="display:none;" id="customer-div">
                                                <!--begin::Label-->
                                                <label class="d-flex align-items-center fs-5 fw-bold mb-4">
                                                    <span class="required">Select Customer's</span>
                                                    
                                                </label>
                                                <!--end::Label-->
                                              
                                               
                                                <!--begin:Option-->
                                                    <select name="customer_selection[]" id="customer_selection" multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1">
                                                        @foreach($customers as $c)
                                                        <option value="{{$c->id}}">{{$c->name}}</option>
                                                        @endforeach
                                                    </select>
                                                <!--end::Option-->
                                            </div>

                                            <div class="fv-plugins-message-container invalid-feedback"></div></div>
                                            <!--end::Input group-->
                                        </div>
                                    </div>
                                    <!--end::Step 2-->
                                    <!--begin::Step 3-->
                                    <div data-kt-stepper-element="content">
                                        <div class="w-100">
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-10 fv-plugins-icon-container">
                                                <!--begin::Label-->
                                                <label class="required fs-5 fw-bold mb-2">Select Image</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="file" class="form-control form-control-md" name="image" id="add_image" accept="application/pdf, image/*">
                                                <!--end::Input-->
                                            <div class="fv-plugins-message-container invalid-feedback"></div></div>
                                            <!--end::Input group-->

                                            <!--begin::Input group-->
                                            <div class="fv-row mb-10 fv-plugins-icon-container">
                                                <!--begin::Label-->
                                                <label class="required fs-5 fw-bold mb-2">Uploaded image link</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <div class="d-flex">
                                                    <input id="image_input_path" type="text" class="form-control kt_share_earn_link_input form-control-solid me-3 flex-grow-1" >
                                                    <a id="" class="btn btn-light fw-bolder kt_share_earn_link_copy_button flex-shrink-0" data-clipboard-target="#image_input_path">Copy Link</a>
                                                </div>
                                                <!--end::Input-->
                                            <div class="fv-plugins-message-container invalid-feedback"></div></div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="fv-row fv-plugins-icon-container">
                                                
                                                <div id="editor" class="form-group d-flex flex-stack mb-8">
                                                    <textarea class="rich_text_content1" name="htmlBody" id="htmlBody"></textarea>
                                                  
                                                  </div>
                                                
                                            <div class="fv-plugins-message-container invalid-feedback"></div></div>
                                            <!--end::Input group-->
                                        </div>
                                    </div>
                                    <!--end::Step 3-->
                                    <!--begin::Actions-->
                                    <div class="d-flex flex-stack pt-10">
                                        <!--begin::Wrapper-->
                                        <div class="me-2">
                                            <button type="button" class="btn btn-lg btn-light-primary me-3" data-kt-stepper-action="previous">
                                            <!--begin::Svg Icon | path: icons/duotone/Navigation/Left-2.svg-->
                                            <span class="svg-icon svg-icon-3 me-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                        <rect fill="#000000" opacity="0.3" transform="translate(15.000000, 12.000000) scale(-1, 1) rotate(-90.000000) translate(-15.000000, -12.000000)" x="14" y="7" width="2" height="10" rx="1"></rect>
                                                        <path d="M3.7071045,15.7071045 C3.3165802,16.0976288 2.68341522,16.0976288 2.29289093,15.7071045 C1.90236664,15.3165802 1.90236664,14.6834152 2.29289093,14.2928909 L8.29289093,8.29289093 C8.67146987,7.914312 9.28105631,7.90106637 9.67572234,8.26284357 L15.6757223,13.7628436 C16.0828413,14.136036 16.1103443,14.7686034 15.7371519,15.1757223 C15.3639594,15.5828413 14.7313921,15.6103443 14.3242731,15.2371519 L9.03007346,10.3841355 L3.7071045,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(9.000001, 11.999997) scale(-1, -1) rotate(90.000000) translate(-9.000001, -11.999997)"></path>
                                                    </g>
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->Back</button>
                                        </div>
                                        <!--end::Wrapper-->
                                        <!--begin::Wrapper-->
                                        <div>
                                            <button type="button" class="btn btn-lg btn-primary" data-kt-stepper-action="submit" onclick="submitForm()">
                                                <span class="indicator-label">Submit
                                                <!--begin::Svg Icon | path: icons/duotone/Navigation/Right-2.svg-->
                                                <span class="svg-icon svg-icon-3 ms-2 me-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                            <rect fill="#000000" opacity="0.5" transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000)" x="7.5" y="7.5" width="2" height="9" rx="1"></rect>
                                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)"></path>
                                                        </g>
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon--></span>
                                                <span class="indicator-progress">Please wait...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            </button>
                                            <button type="button" class="btn btn-lg btn-primary" data-kt-stepper-action="next">Continue
                                            <!--begin::Svg Icon | path: icons/duotone/Navigation/Right-2.svg-->
                                            <span class="svg-icon svg-icon-3 ms-1 me-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                        <rect fill="#000000" opacity="0.5" transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000)" x="7.5" y="7.5" width="2" height="9" rx="1"></rect>
                                                        <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)"></path>
                                                    </g>
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon--></button>
                                        </div>
                                        <!--end::Wrapper-->
                                    </div>
                                    <!--end::Actions-->
                                <div></div><div></div><div></div><div></div></form>
                                <!--end::Form-->
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
        <!-- end here model -->
                                    @stop

                                    @section('pageFooter')
                                    <!--end::Scrolltop-->
                                    <!--end::Main-->
                                    <!--begin::Javascript-->
                                    <!--begin::Global Javascript Bundle(used by all pages)-->
                                    <script src="{{asset('')}}plugins/global/plugins.bundle.js"></script>
                                    <script src="{{asset('')}}js/scripts.bundle.js"></script>
                                    <!--end::Global Javascript Bundle-->
                                    <!--begin::Page Custom Javascript(used by this page)-->
                                    {{-- <script src="{{asset('')}}js/custom/modals/share-earn.js"></script> --}}
                                    <script src="{{asset('')}}js/custom/widgets.js"></script>
                                    <script src="{{asset('')}}js/custom/apps/chat/chat.js"></script>
                                    <script src="{{asset('')}}js/custom/modals/create-app.js"></script>
                                    <script src="{{asset('')}}js/custom/modals/upgrade-plan.js"></script>
                                    <script src="{{asset('')}}plugins/global/plugins.bundle.js"></script>
                                    {{-- richtext --}}
                                    <script type="text/javascript" src="{{asset('')}}richtext/jquery.richtext.js"></script>
                                    <script type="text/javascript" src="{{asset('')}}richtext/jquery.richtext.min.js"></script>
                                    <script src="{{ asset('')}}plugins/custom/datatables/datatables.bundle.js"></script>

                                    <script>
                                        $("input[type='radio'][name='sent_by']").click(function() {
    var value = $(this).val();
    if(value == 'guards')
    {
        $('#guard-div').css('display', 'block');
        $('#customer-div').css('display', 'none');
    }else{
        $('#guard-div').css('display', 'none');
        $('#customer-div').css('display', 'block');
    }
});
                                        // custom
var KTModalShareEarn={init:function(){var e,n,s;e=document.querySelector(".kt_share_earn_link_copy_button"),n=document.querySelector(".kt_share_earn_link_input"),(s=new ClipboardJS(e))&&s.on("success",(function(s){var t=e.innerHTML;n.classList.add("bg-success"),n.classList.add("text-inverse-success"),e.innerHTML="Copied!",setTimeout((function(){e.innerHTML=t,n.classList.remove("bg-success"),n.classList.remove("text-inverse-success")}),3e3),s.clearSelection()}))}};KTUtil.onDOMContentLoaded((function(){KTModalShareEarn.init()}));

var KTModalShareEarn2={init:function(){var e,n,s;e=document.querySelector(".kt_share_earn_link_copy_button_edit"),n=document.querySelector(".kt_share_earn_link_input_edit"),(s=new ClipboardJS(e))&&s.on("success",(function(s){var t=e.innerHTML;n.classList.add("bg-success"),n.classList.add("text-inverse-success"),e.innerHTML="Copied!",setTimeout((function(){e.innerHTML=t,n.classList.remove("bg-success"),n.classList.remove("text-inverse-success")}),3e3),s.clearSelection()}))}};KTUtil.onDOMContentLoaded((function(){KTModalShareEarn2.init()}));

                                        var editor;
                                        $(document).ready(function() {
                                           editor = $('.rich_text_content1').richText();
                                            MultiselectDropdown();
                                        });



                                        var $rows = $('#card_induction_body tr');
                                        $('#search').keyup(function() {
                                            var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

                                            $rows.show().filter(function() {
                                                var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
                                                return !~text.indexOf(val);
                                            }).hide();
                                        });

                                        var image = '';
                                        function readImage() {
                                            if (this.files && this.files[0]) {
// console.log(this.files)

var FR= new FileReader();

FR.addEventListener("load", function(e) {
    console.log(e);
    image =  e.target.result;
    console.log(image);
    if (image != '') {
     $.ajax({
        type: "POST",
        url: "{{url('announcements/upload_image_induction')}}",
        data : {image:image,_token:'<?php echo csrf_token();?>'},
        success: function(result){
            console.log(result);
            var obj = JSON.parse(result);
            if (obj.success) {
    // alert('Image upload successfully.'); 
    // obj.path=`{{asset('')}}${obj.path}`;
    $('#image_input_path').val(obj.path)
    $('#add_image').val('');
}else{
        // alert('Failed to upload image!')

    }

}
});

 }else{
    alert('Not a valid image!')

}


}); 

FR.readAsDataURL(this.files[0] );
}


}
document.getElementById("add_image").addEventListener("change", readImage);


var image_edit = '';
function readImageEdit() {

    if (this.files && this.files[0]) {

        var FR= new FileReader();

        FR.addEventListener("load", function(e) {
           image_edit =  e.target.result;
           if (image_edit != '') {
             $.ajax({
                type: "POST",
                url: "{{url('announcements/upload_image_induction')}}",
                data : {image:image_edit,_token:'<?php echo csrf_token();?>'},
                success: function(result){
                    console.log(result);
                    var obj = JSON.parse(result);
                    if (obj.success) {
    // alert('Image upload successfully.'); 
    // obj.path=`{{asset('')}}${obj.path}`;
    $('#image_path_upload_edit').val(obj.path)
    $('#add_image_edit').val('');
}else{
        // alert('Failed to upload image!')

    }
}
});

         }else{
            alert('Not a valid image!')

        }
    }); 

        FR.readAsDataURL( this.files[0] );
    }

// console.log(image);


}
document.getElementById("add_image_edit").addEventListener("change", readImageEdit);
function submitForm()
{
    call_spinner();
    var data = $('#kt_modal_add_new').serialize();

     $.ajax({type: "POST",url: "{{url('add_new_announcement_induction')}}", data : data ,success: function(result){if(result.success){
         $('#kt_modal_create_app').modal('hide');
         close_spinner();
                             Swal.fire({
                                            text: result.message,
                                            icon: "success",
                                            buttonsStyling: !1,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton: "btn btn-light"
                                            }
                })
                window.location.href = "{{ url('announcements/new')}}";
 }else{
         close_spinner();
    Swal.fire({
                    text: result.error,
                    icon: "error",
                    buttonsStyling: !1,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-light"
                    }
                })}}})
    // $('.modal-backdrop').removeClass('show')
}
function editData(type, id)
{
    $('#app-title').text('Update ' + type);
    $('#id').val(id);
    $.ajax({type: "POST",url: `{{url('getEditData')}}/${id}`, data:{ _token:'<?php echo csrf_token();?>', type : type},success: function(result){
        // editor.delete();
        // var editor = $('.rich_text_content1').richText();
        // editor.setValue(result.data.html_body);
        $('.multiselect-dropdown').remove();
        $('input:radio[name="type"]').filter('[value="'+type+'"]').attr('checked', true);
        $('input[name=title]').val(result.data.title);
        $('#editor').html('<textarea class="rich_text_content1" name="htmlBody" id="htmlBody">'+result.data.html_body+'</textarea>')
        // $('.richText-editor').html(result.data.html_body)
        var editor = $('.rich_text_content1').richText();
        $('#kt_modal_create_app').toggle();
        $('#guard_selection').val(result.data.selected_guards)
        MultiselectDropdown();
                            }
                            })
}
function viewData(type, id)
{
    // $('#app-title').text('Update ' + type);
    $('#id').val(id);
    $.ajax({type: "POST",url: `{{url('getEditData')}}/${id}`, data:{ _token:'<?php echo csrf_token();?>', type : type},success: function(result){
        $('#kt_modal_detail').modal('show');
        $('#p-title').text(result.data.title);
        $('#p-body').html(result.data.html_body);

                            }
                            })
}
function openCreateApp()
{
    $('#app-title').text('ADD NEW');
    $('#id').val('');
}

function deleteData(type, id)
{
    Swal.fire({
                        text: "Are you sure you want to delete?",
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
                            $.ajax({type: "POST",url: `{{url('delete_ann_data')}}/${id}`, data:{ _token:'<?php echo csrf_token();?>', type : type},success: function(result){
                                Swal.fire({
                            text: "Deleted Succesfully.",
                            icon: "success",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        })
                        window.location.href = "{{ url('/announcements/new')}}";
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


</script>
@stop