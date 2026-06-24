@extends('layout.app')
@extends('layout.sidebar')
@extends('layout.footer')

@section('pageCss')
<base href="../../../">
<meta charset="utf-8" />
<title>{{ config('custom.title') }}</title>
<meta name="description"
content="{{ config('custom.title') }}" />
<meta name="keywords"
content="{{ config('custom.title')}}" />
<link rel="canonical" href="Https://preview.keenthemes.com/metronic8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<!-- <link rel="shortcut icon" href="{{ asset('') }}media/logos/favicon.ico" /> -->
<!--begin::Fonts-->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700" />
<!--end::Fonts-->
<!--begin::Page Vendor Stylesheets(used by this page)-->
<link href="{{ asset('') }}plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
<!--end::Page Vendor Stylesheets-->
<!--begin::Global Stylesheets Bundle(used by all pages)-->
<link href="{{ asset('') }}plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
<link href="{{ asset('') }}css/style.bundle.css" rel="stylesheet" type="text/css" />
@stop

@section('content')
<!--begin::Wrapper-->
<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
    <!--begin::Header-->
    <div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
        <!--begin::Container-->
        <div class="container d-flex align-items-center justify-content-between" id="kt_header_container">
            <!--begin::Page title-->
            <div>
                <div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-2 pb-2 pb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
                    <!--begin::Heading-->
                    <h1 class="text-dark fw-bolder my-0 fs-2">Authenticator</h1>
                    <!--end::Heading-->
                </div>
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
                <a href="{{url('')}}">
                    @if(config('custom.business_type')=="demo")
                    <img alt="Logo" crossorigin="anonymous" id="bussiness_logo" src="{{asset('')}}media/logo.png" class="h-60px">
                    @else
                    <img alt="Logo" crossorigin="anonymous" id="bussiness_logo" src="{{config('custom.logo')}}" class="h-60px">
                    @endif

                </a>
                <!--end::Logo-->
            </div>
            @include('layout.toolbar')  
            @yield('toolbar')
        </div>
    </div>
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Container-->
        <div class="container" id="kt_content_container">
            <div class="row">
                <div class="card">

                    <div class="card-body">

                        <ol class="list-left-align">
                            <li>Open your OTP app and <b>scan the following QR-code</b>
                                <p class="text-center">
                                    {!! $qr_code !!}
                                </p>
                            </li>
                            @if(session()->get('userType') == 'admin')
                            <li>Generate New.
                                <button type="button" class="form-control btn-sm btn-primary" onclick="generateQR()">Generate New</button>
                            </li>
                            @endif
                        </ol>

                    </div>
                </div>
            </div>
        </div>
    </div>


    @endsection

    @section('pageFooter')
    <script src="{{ asset('') }}plugins/global/plugins.bundle.js"></script>
    <script src="{{ asset('') }}js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Page Vendors Javascript(used by this page)-->
    <script src="{{ asset('') }}plugins/custom/datatables/datatables.bundle.js"></script>
    <!--end::Page Vendors Javascript-->
    <!--begin::Page Custom Javascript(used by this page)-->
    <script src="{{ asset('') }}js/custom/apps/user-management/users/list/table.js"></script>
    <script src="{{ asset('') }}js/custom/apps/user-management/users/list/export-users.js"></script>
    <script src="{{ asset('') }}js/custom/apps/user-management/users/list/add.js"></script>
    <script src="{{ asset('') }}js/custom/widgets.js"></script>
    <script src="{{ asset('') }}js/custom/apps/chat/chat.js"></script>
    <script src="{{ asset('') }}js/custom/modals/create-app.js"></script>
    <script src="{{ asset('') }}js/custom/modals/upgrade-plan.js"></script>
    <script type="text/javascript">
        function generateQR()
        {
            Swal.fire({
                text: "Are you sure you want to generate new ?",
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
                    $.ajax({type: "POST",url: `{{url('generateQR')}}`, data:{_token:'<?php echo csrf_token();?>'},success: function(result){
                        Swal.fire({
                            text: "Generate successfully.",
                            icon: "success",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        })
                        window.location.href = "{{ url('/authenticationQr')}}";
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
