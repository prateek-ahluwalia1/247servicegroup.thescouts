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


    <!--end::Global Stylesheets Bundle-->

    @foreach ($guards as $guard)
        @if ($guard->profile_image == null)
            <style>
                #profile_{{ $guard->id }} {
                    width: 50px;
                    height: 50px;
                    border-radius: 50%;
                    background: #512DA8;
                    font-size: 15px;
                    color: #fff;
                    text-align: center;
                    line-height: 50px;
                    margin: 5px 0;
                }
            </style>
        @endif
    @endforeach


@stop

<!--end::Head-->
<!--begin::Body-->

<!--begin::Main-->
<!--begin::Root-->
<?php
$item = session()->get('guards_navigation_bar');
// @dd($item);
if (!empty($item)) {
    foreach (session()->get('guards_navigation_bar') as $item1) {
        $item = $item1;
    }
} else {
    $item['active_guards'] = 1;
    $item['active_guards'] = 1;
    $item['inactive_guards'] = 1;
    $item['new_guards'] = 1;
    $item['pending_guards'] = 1;
    $item['deleted_guards'] = 1;
    $item['add_guards'] = 1;
    $item['site_trained'] = 1;
    $item['guard_uniform'] = 1;
    $item['guard_work_limitation'] = 1;
    $item['leave_management'] = 1;
    $item['select_customer'] = 1;
    $item['gender'] = 1;
    $item['dob'] = 1;
    $item['postal_code'] = 1;
    $item['state'] = 1;
    $item['city'] = 1;
    $item['suburb'] = 1;
    $item['address'] = 1;
    $item['guard_type'] = 1;
    $item['password'] = 1;
    $item['email'] = 1;
    $item['profile_image'] = 1;
    $item['coordinates'] = 1;
    $item['emergency_contact_name'] = 1;
    $item['emergency_contact_phone'] = 1;

    $item = json_decode(json_encode($item));
}
?>
@if (true)
    @section('content')
        <!--end::Logo-->

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
                        <h1 class="text-dark fw-bolder my-0 fs-2">{{ config('custom.guard') }}s List</h1>
                        <!--end::Heading-->
                    </div>
                    <!--end::Page title=-->
                    <!--begin::Wrapper-->
                    <div class="d-flex d-lg-none align-items-center ms-n2 me-2">
                        <!--begin::Aside mobile toggle-->
                        <div class="btn btn-icon btn-active-icon-primary" id="kt_aside_toggle">
                            <!--begin::Svg Icon | path: icons/duotone/Text/Menu.svg-->
                            <span class="svg-icon svg-icon-2x">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <rect fill="#000000" x="4" y="5" width="16" height="3"
                                            rx="1.5" />
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
                        <a href="index.html" class="d-flex align-items-center">
                            <img alt="Logo" src="{{ config('custom.logo') }}" class="h-30px" />
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
                    <!--begin::Card-->
                    <div class="card">
                        <!--begin::Card header-->
                        <div class="card-header border-0 pt-6">
                            <!--begin::Card title-->
                            <div class="card-title" style="display: block; width: 100% !important;">
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
                                    <input type="text" data-kt-user-table-filter="search"
                                        class="form-control form-control-solid w-250px ps-14"
                                        placeholder="Search {{ config('custom.guard') }}s" id="search" />
                                </div>
                                <!--end::Search-->
                            </div>
                            <!--begin::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <!--begin::Toolbar-->
                                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                                    <div class="d-flex overflow-auto h-55px">
                                        <ul
                                            class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6 nav-stretch  nav-fill nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder flex-nowrap">
                                            @if (isset($item->active_guards) && $item->active_guards == 1)
                                                <li class="nav-item">

                                                    <a class="nav-link  text-active-primary me-6" data-bs-toggle="tab"
                                                        id="active" onclick="fetch('active')"
                                                        href="#active_guards">{{ config('custom.guard') }}s</a>

                                                </li>
                                            @endif
                                            @if (isset($item->active_guards) && $item->active_guards == 0)
                                                <li class="nav-item">

                                                    <a class="nav-link  text-active-primary me-6" data-bs-toggle="tab"
                                                        id="active" onclick="fetch('active')"
                                                        href="{{url('guards?status=active')}}">Active {{ config('custom.guard') }}s</a>

                                                </li>
                                            @endif
                                            @if (isset($item->inactive_guards) && $item->inactive_guards == 1)
                                                <li class="nav-item">
                                                    <a class="nav-link text-active-primary me-6" data-bs-toggle="tab"
                                                        onclick="fetch('inactive')" id="inactive"
                                                        href="{{url('guards?status=inactive')}}">Inactive {{ config('custom.guard') }}s</a>
                                                </li>
                                            @endif
                                            @if (isset($item->new_guards) && $item->new_guards == 1)
                                                <li class="nav-item">
                                                    <a class="nav-link text-active-primary me-6" data-bs-toggle="tab"
                                                        onclick="fetch('new')" id="new" href="{{url('guards?status=new')}}">New
                                                        {{ config('custom.guard') }}s</a>
                                                </li>
                                            @endif
                                            @if (isset($item->pending_guards) && $item->pending_guards == 1)
                                                <li class="nav-item">
                                                    <a class="nav-link text-active-primary me-6"
                                                        onclick="fetch('pending')" data-bs-toggle="tab" id="pending"
                                                        href="{{url('guards?status=pending')}}">Pending {{ config('custom.guard') }}s</a>
                                                </li>
                                            @endif
                                            @if (isset($item->deleted_guards) && $item->deleted_guards == 1)
                                                <li class="nav-item">
                                                    <a class="nav-link text-active-primary me-6"
                                                        onclick="fetch('deleted')" id="deleted" data-bs-toggle="tab"
                                                        href="{{url('guards?status=deleted')}}">Deleted {{ config('custom.guard') }}s</a>
                                                </li>
                                            @endif

                                        </ul>

                                        <!--begin::Filter-->
                                        <!-- 			<button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
               <span class="svg-icon svg-icon-2">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                 <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <rect x="0" y="0" width="24" height="24" />
                  <path d="M5,4 L19,4 C19.2761424,4 19.5,4.22385763 19.5,4.5 C19.5,4.60818511 19.4649111,4.71345191 19.4,4.8 L14,12 L14,20.190983 C14,20.4671254 13.7761424,20.690983 13.5,20.690983 C13.4223775,20.690983 13.3458209,20.6729105 13.2763932,20.6381966 L10,19 L10,12 L4.6,4.8 C4.43431458,4.5790861 4.4790861,4.26568542 4.7,4.1 C4.78654809,4.03508894 4.89181489,4 5,4 Z" fill="#000000" />
                 </g>
                </svg>
               </span>
               Filter</button>
     -->
                                        <!--begin::Menu 1-->
                                        <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px"
                                            data-kt-menu="true">
                                            <!--begin::Header-->
                                            <div class="px-7 py-5">
                                                <div class="fs-5 text-dark fw-bolder">Filter Options</div>
                                            </div>
                                            <!--end::Header-->
                                            <!--begin::Separator-->
                                            <div class="separator border-gray-200"></div>
                                            <!--end::Separator-->
                                            <!--begin::Content-->
                                            <div class="px-7 py-5" data-kt-user-table-filter="form">
                                                <!--begin::Input group-->
                                                <div class="mb-10">
                                                    <label class="form-label fs-6 fw-bold">Role:</label>
                                                    <select class="form-select form-select-solid fw-bolder"
                                                        data-kt-select2="true" data-placeholder="Select option"
                                                        data-allow-clear="true" data-kt-user-table-filter="role"
                                                        data-hide-search="true">
                                                        <option></option>
                                                        <option value="Administrator">Administrator</option>
                                                        <option value="Analyst">Analyst</option>
                                                        <option value="Developer">Developer</option>
                                                        <option value="Support">Support</option>
                                                        <option value="Trial">Trial</option>
                                                    </select>
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Input group-->
                                                <div class="mb-10">
                                                    <label class="form-label fs-6 fw-bold">Two Step Verification:</label>
                                                    <select class="form-select form-select-solid fw-bolder"
                                                        data-kt-select2="true" data-placeholder="Select option"
                                                        data-allow-clear="true" data-kt-user-table-filter="two-step"
                                                        data-hide-search="true">
                                                        <option></option>
                                                        <option value="Enabled">Enabled</option>
                                                    </select>
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Actions-->
                                                <div class="d-flex justify-content-end">
                                                    <button type="reset"
                                                        class="btn btn-white btn-active-light-primary fw-bold me-2 px-6"
                                                        data-kt-menu-dismiss="true"
                                                        data-kt-user-table-filter="reset">Reset</button>
                                                    <button type="submit" class="btn btn-primary fw-bold px-6"
                                                        data-kt-menu-dismiss="true"
                                                        data-kt-user-table-filter="filter">Apply</button>
                                                </div>
                                                <!--end::Actions-->
                                            </div>
                                            <!--end::Content-->
                                        </div>
                                        <!--end::Menu 1-->
                                        <!--end::Filter-->

                                        <!--begin::Add user-->
                                        @if (isset($item->add_guards) && $item->add_guards == 1)
                                            <a style="height: 44px;" href="{{ url('create_guard') }}"
                                                class="btn btn-primary btn">
                                                <!--begin::Svg Icon | path: icons/duotone/Navigation/Plus.svg-->
                                                <span class="svg-icon svg-icon-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                        height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <rect fill="#000000" x="4" y="11"
                                                            width="16" height="2" rx="1" />
                                                        <rect fill="#000000" opacity="0.5"
                                                            transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000)"
                                                            x="4" y="11" width="16" height="2"
                                                            rx="1" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->Add a {{ config('custom.guard') }}
                                            </a>
                                        @endif
                                        <!--end::Add user-->
                                    </div>
                                    <!--end::Toolbar-->
                                    <!--begin::Group actions-->
                                    <div class="d-flex justify-content-end align-items-center d-none"
                                        data-kt-user-table-toolbar="selected">
                                        <div class="fw-bolder me-5">
                                            <span class="me-2"
                                                data-kt-user-table-select="selected_count"></span>Selected
                                        </div>
                                        <button type="button" class="btn btn-danger"
                                            data-kt-user-table-select="delete_selected">Delete Selected</button>
                                    </div>
                                    <!--end::Group actions-->
                                    <!--begin::Modal - Adjust Balance-->
                                    <div class="modal fade" id="kt_modal_export_users" tabindex="-1"
                                        aria-hidden="true">
                                        <!--begin::Modal dialog-->
                                        <div class="modal-dialog modal-dialog-centered mw-650px">
                                            <!--begin::Modal content-->
                                            <div class="modal-content">
                                                <!--begin::Modal header-->
                                                <div class="modal-header">
                                                    <!--begin::Modal title-->
                                                    <h2 class="fw-bolder">Export Users</h2>
                                                    <!--end::Modal title-->
                                                    <!--begin::Close-->
                                                    <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                                        data-kt-users-modal-action="close">
                                                        <!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
                                                        <span class="svg-icon svg-icon-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                                height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)"
                                                                    fill="#000000">
                                                                    <rect fill="#000000" x="0" y="7"
                                                                        width="16" height="2" rx="1" />
                                                                    <rect fill="#000000" opacity="0.5"
                                                                        transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)"
                                                                        x="0" y="7" width="16"
                                                                        height="2" rx="1" />
                                                                </g>
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </div>
                                                    <!--end::Close-->
                                                </div>
                                                <!--end::Modal header-->
                                                <!--begin::Modal body-->
                                                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                                    <!--begin::Form-->
                                                    <form id="kt_modal_export_users_form" class="form" action="#">
                                                        <!--begin::Input group-->
                                                        <div class="fv-row mb-10">
                                                            <!--begin::Label-->
                                                            <label class="fs-6 fw-bold form-label mb-2">Select
                                                                Roles:</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <select name="role" data-control="select2"
                                                                data-placeholder="Select a role" data-hide-search="true"
                                                                class="form-select form-select-solid fw-bolder">
                                                                <option></option>
                                                                <option value="Administrator">Administrator</option>
                                                                <option value="Analyst">Analyst</option>
                                                                <option value="Developer">Developer</option>
                                                                <option value="Support">Support</option>
                                                                <option value="Trial">Trial</option>
                                                            </select>
                                                            <!--end::Input-->
                                                        </div>
                                                        <!--end::Input group-->
                                                        <!--begin::Input group-->
                                                        <div class="fv-row mb-10">
                                                            <!--begin::Label-->
                                                            <label class="required fs-6 fw-bold form-label mb-2">Select
                                                                Export Format:</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <select name="format" data-control="select2"
                                                                data-placeholder="Select a format" data-hide-search="true"
                                                                class="form-select form-select-solid fw-bolder">
                                                                <option></option>
                                                                <option value="excel">Excel</option>
                                                                <option value="pdf">PDF</option>
                                                                <option value="cvs">CVS</option>
                                                                <option value="zip">ZIP</option>
                                                            </select>
                                                            <!--end::Input-->
                                                        </div>
                                                        <!--end::Input group-->
                                                        <!--begin::Actions-->
                                                        <div class="text-center">
                                                            <button type="reset" class="btn btn-white me-3"
                                                                data-kt-users-modal-action="cancel">Discard</button>
                                                            <button type="submit" class="btn btn-primary"
                                                                data-kt-users-modal-action="submit">
                                                                <span id="form_submit"
                                                                    class="indicator-label">Submit</span>
                                                                <span class="indicator-progress">Please wait...
                                                                    <span
                                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
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
                                    <!--end::Modal - New Card-->
                                    <!--begin::Modal - Add task-->
                                    <div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">
                                        <!--begin::Modal dialog-->
                                        <div class="modal-dialog modal-dialog-centered mw-650px">
                                            <!--begin::Modal content-->
                                            <div class="modal-content">
                                                <!--begin::Modal header-->
                                                <div class="modal-header" id="kt_modal_add_user_header">
                                                    <!--begin::Modal title-->
                                                    <h2 class="fw-bolder" id="form_head">Add User</h2>
                                                    <!--end::Modal title-->
                                                    <!--begin::Close-->
                                                    <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                                        data-kt-users-modal-action="close">
                                                        <!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
                                                        <span class="svg-icon svg-icon-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                                height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)"
                                                                    fill="#000000">
                                                                    <rect fill="#000000" x="0" y="7"
                                                                        width="16" height="2" rx="1" />
                                                                    <rect fill="#000000" opacity="0.5"
                                                                        transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)"
                                                                        x="0" y="7" width="16"
                                                                        height="2" rx="1" />
                                                                </g>
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </div>
                                                    <!--end::Close-->
                                                </div>
                                                <!--end::Modal header-->
                                                <!--begin::Modal body-->
                                                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                                    <!--begin::Form-->
                                                    <form id="kt_modal_add_user_form" class="form"
                                                        action="{{ url('insertUser') }}" method="POST"
                                                        enctype="multipart/form-data">
                                                        @csrf

                                                        <!--begin::Scroll-->
                                                        <div class="d-flex flex-column scroll-y me-n7 pe-7"
                                                            id="kt_modal_add_user_scroll" data-kt-scroll="true"
                                                            data-kt-scroll-activate="{default: false, lg: true}"
                                                            data-kt-scroll-max-height="auto"
                                                            data-kt-scroll-dependencies="#kt_modal_add_user_header"
                                                            data-kt-scroll-wrappers="#kt_modal_add_user_scroll"
                                                            data-kt-scroll-offset="300px">
                                                            <!--begin::Input group-->
                                                            <div class="fv-row mb-7">
                                                                <!--begin::Label-->
                                                                <label class="d-block fw-bold fs-6 mb-5">Avatar</label>
                                                                <!--end::Label-->
                                                                <!--begin::Image input-->
                                                                <div class="image-input image-input-outline"
                                                                    data-kt-image-input="true" id="avatar"
                                                                    style="background-image: url(assets/media/avatars/blank.png)">
                                                                    <!--begin::Preview existing avatar-->
                                                                    <div class="image-input-wrapper w-125px h-125px"
                                                                        id="preview_img" style=""></div>
                                                                    <!--end::Preview existing avatar-->
                                                                    <!--begin::Label-->
                                                                    <label
                                                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                                                                        data-kt-image-input-action="change"
                                                                        data-bs-toggle="tooltip" title="Change avatar">
                                                                        <i class="bi bi-pencil-fill fs-7"></i>
                                                                        <!--begin::Inputs-->
                                                                        <input type="file" name="avatar"
                                                                            id="file_image" accept=".png, .jpg, .jpeg" />
                                                                        <input type="hidden" name="avatar_remove" />
                                                                        <!--end::Inputs-->
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Cancel-->
                                                                    <span
                                                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                                                                        data-kt-image-input-action="cancel"
                                                                        data-bs-toggle="tooltip" title="Cancel avatar">
                                                                        <i class="bi bi-x fs-2"></i>
                                                                    </span>
                                                                    <!--end::Cancel-->
                                                                    <!--begin::Remove-->
                                                                    <span onclick="avatar_remove()"
                                                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                                                                        data-kt-image-input-action="remove"
                                                                        data-bs-toggle="tooltip" title="Remove avatar">
                                                                        <i class="bi bi-x fs-2"></i>
                                                                    </span>
                                                                    <!--end::Remove-->
                                                                </div>
                                                                <!--end::Image input-->
                                                                <!--begin::Hint-->
                                                                <div class="form-text">Allowed file types: png, jpg, jpeg.
                                                                </div>
                                                                <!--end::Hint-->
                                                            </div>
                                                            <!--end::Input group-->
                                                            <!--begin::Input group-->
                                                            <div class="fv-row mb-7">
                                                                <!--begin::Label-->
                                                                <label class="required fw-bold fs-6 mb-2">Full Name</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" id="user_name" name="user_name"
                                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                                    placeholder="Full name" value="" required />

                                                                <!--end::Input-->
                                                            </div>
                                                            <!--end::Input group-->
                                                            <!--begin::Input group-->
                                                            <div class="fv-row mb-7">
                                                                <!--begin::Label-->
                                                                <label class="required fw-bold fs-6 mb-2">Email</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->

                                                                <input type="email" id="user_email" name="user_email"
                                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                                    placeholder="example@domain.com" value=""
                                                                    required />
                                                                <!--end::Input-->
                                                            </div>
                                                            <!--end::Input group-->
                                                            <!--begin::Input group-->
                                                            <!--end::Input group-->
                                                        </div>
                                                        <!--end::Scroll-->
                                                        <!--begin::Actions-->
                                                        <div class="text-center pt-15">
                                                            <button type="reset" class="btn btn-white me-3"
                                                                data-kt-users-modal-action="cancel">Discard</button>
                                                            <button type="submit" class="btn btn-primary"
                                                                data-kt-users-modal-action="submit">
                                                                <span class="indicator-label"
                                                                    id="form_button">Submit</span>
                                                                <span class="indicator-progress">Please wait...
                                                                    <span
                                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
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
                                    <!--end::Modal - Add task-->
                                </div>
                                <!--end::Card toolbar-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="tab-content card-body pt-0  " style="max-width: 100%;">
                                @if (request()->get('status') == 'active')
                                    @include('admin.guard.active_guards')
                                    @yield('active_guards')
                                @elseif(request()->get('status') == 'pending')
                                    @include('admin.guard.pending_guards')
                                    @yield('pending_guards')
                                @elseif(request()->get('status') == 'new')
                                    @include('admin.guard.new_guards')
                                    @yield('new_guards')
                                @elseif(request()->get('status') == 'inactive')
                                    @include('admin.guard.inactive_guards')
                                    @yield('inactive_guards')
                                @else
                                    @include('admin.guard.deleted_guards')
                                    @yield('deleted_guards')
                                @endif
                            </div>

                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Content-->
                <!--begin::Footer-->

                <!--end::Root-->
                <!--begin::Drawers-->
                <!--begin::Activities drawer-->

                <!--end::Chat drawer-->
                <!--begin::Exolore drawer toggle-->

            @stop
            <!--end::Scrolltop-->
            <!--end::Main-->
            <!--begin::Javascript-->
            <!--begin::Global Javascript Bundle(used by all pages)-->
            @section('pageFooter')
    @endif
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
    <!--end::Page Custom Javascript-->
    <!--end::Javascript-->

    <script>
        var link = '';
        $(document).ready(function() {
            @if (request()->get('status'))
                link = "{{ request()->get('status') }}";
                console.log(link);
                $(`#${link}`).addClass('active');
                // $(`#${link}`).click();
            @endif


            oTable = $(table).DataTable({
                "pageLength": 50
            });
            $('#search').keyup(function() {
                oTable.search($(this).val()).draw();
            })

        });

        function fetch(status) {


            var url = "{{ url('guards/') }}?status=" + status
            window.location = url;
        }

        function avatar_remove() {
            document.getElementById('preview_img').style.backgroundImage = '';
            document.getElementById('file_image').value = '';

        }


        function getUser(id) {


            $.ajax({
                type: 'POST',
                url: "{{ url('getUser') }}",
                data: {
                    _token: '<?php echo csrf_token(); ?>',
                    id: id,
                    status: access_level_id
                },
                success: function(result) {
                    $('#kt_modal_add_user').modal('show');
                    document.getElementById("form_button").innerHTML = "Update!";
                    $('#kt_modal_add_user_form').attr('method', "POST");

                    $('#kt_modal_add_user_form').attr('action', "/editUser/" + id);


                    $('#user_name').val(result.name);
                    $('#user_email').val(result.email);
                    // $('current_role').val(result.access_level);

                    console.log(`role_${result.access_level_id}`);

                    document.getElementById("form_head").innerHTML = "Edit User";


                    document.getElementById('preview_img').style.backgroundImage =
                        `url({{ asset('') }}media/uploads/${result.image})`;
                    document.getElementById(`role_${result.access_level_id}`).checked = true;

                    //   document.getElementById('avatar').style.backgroundImage=`url({{ asset('') }}media/uploads/${result.image})`; // specify the image path here

                }
            });
        }

        function openModal() {
            $('#kt_modal_add_user').modal('show');
        }



        function resend_guard_email(id) {
            console.log(this.id)

            $.ajax({
                type: "POST",
                url: "{{ url('resend_guard_email') }}",
                data: {
                    id: id,
                    _token: '<?php echo csrf_token(); ?>'
                },
                success: function(result) {
                    if (result.success) {
                        $('#sites_blocked-modal').modal('hide');

                        Swal.fire({
                            text: result.message,
                            icon: "success",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-light"
                            }
                        })
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
        }




        function deleteUser(id) {

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
            }).then((function(t) {
                t.value ? (
                    $.ajax({
                        type: "POST",
                        url: `{{ url('deleteguard') }}/${id}`,
                        data: {
                            _token: '<?php echo csrf_token(); ?>'
                        },
                        success: function(result) {
                            Swal.fire({
                                text: "Deleted Succesfully.",
                                icon: "success",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            })
                            window.location.href = "{{ url('/guards') }}?status=" + link;


                        }
                    })

                ) : "cancel" === t.dismiss && Swal.fire({
                    text: "Your action has  been cancelled!.",
                    icon: "error",
                    buttonsStyling: !1,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                })
            }))


        }



        function restoreguard(id) {

            var id = id;

            Swal.fire({
                text: "Are you sure you want to restore ?",
                icon: "warning",
                showCancelButton: !0,
                buttonsStyling: !1,
                confirmButtonText: "Yes!",
                cancelButtonText: "No, return",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light"
                }
            }).then((function(t) {
                t.value ? (
                    $.ajax({
                        type: "POST",
                        url: `{{ url('restoreguard') }}/${id}`,
                        data: {
                            _token: '<?php echo csrf_token(); ?>'
                        },
                        success: function(result) {
                            Swal.fire({
                                text: "Restored Succesfully.",
                                icon: "success",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            })
                            window.location.href = "{{ url('/guards') }}?status=" + link;


                        }
                    })

                ) : "cancel" === t.dismiss && Swal.fire({
                    text: "Your action has been cancelled!.",
                    icon: "error",
                    buttonsStyling: !1,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                })
            }))


        }

        $("#kt_modal_add_user_form").trigger('reset')


        //     	$('#kt_modal_add_user_button').click({
        // $("#kt_modal_add_user_form")[0].reset();

        // });




        function covid_status(id, e) {
            var check = '';
            //  console.log(($(e).value());
            if ($(e).is(':checked')) {
                check = "checked";
                $(e).prop("checked", true)
                console.log('check covid');

            } else {
                check = "unchecked";
                $(e).prop("checked", false)
                console.log('uncehck covid');


            }

            $.ajax({
                type: "POST",
                url: "{{ url('covid_status') }}",
                data: {
                    id: id,
                    check: check,
                    _token: '<?php echo csrf_token(); ?>'
                },
                success: function(result) {


                    console.log('done covid');
                }

            });
        }

        function admin_approval_status(id, e) {
            if ($(e).is(':checked')) {
                check = "checked";
                $(e).prop("checked", true)

                console.log('check admin_approval_status');
                let timerInterval
                Swal.fire({
                    title: 'Admin Approved !',
                    //   html: 'I will close in <b></b> milliseconds.',
                    timer: 1000,
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
                    if (result.dismiss === Swal.DismissReason.timer) {}
                })


            } else {
                check = "unchecked";
                $(e).prop("checked", false)
                console.log('uncehck admin_approval_status');
                let timerInterval
                Swal.fire({
                    title: 'Admin Unapproved !',
                    timer: 1000,
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
                    if (result.dismiss === Swal.DismissReason.timer) {}
                })


            }
            $.ajax({
                type: "POST",
                url: "{{ url('admin_approval_status') }}",
                data: {
                    id: id,
                    check: check,
                    _token: '<?php echo csrf_token(); ?>'
                },
                success: function(result) {

                    console.log('done admin_approval_status');
                    window.location.href = "{{ url('/guards') }}?status=" + link;


                }

            });
        }



        function guard_active_inactive_status(id, e) {
            console.log(id)
            if ($(e).is(':checked')) {
                check = "checked";
                $(e).prop("checked", true)
                let timerInterval
                Swal.fire({
                    title: 'Admin Approved !',
                    //   html: 'I will close in <b></b> milliseconds.',
                    timer: 1000,
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
                    if (result.dismiss === Swal.DismissReason.timer) {}
                })


            } else {
                check = "unchecked";
                $(e).prop("checked", false)
                let timerInterval
                Swal.fire({
                    title: 'Status Changed !',
                    timer: 1000,
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
                    if (result.dismiss === Swal.DismissReason.timer) {}
                })


            }
            $.ajax({
                type: "POST",
                url: "{{ url('guard_active_inactive_status') }}",
                data: {
                    id: id,
                    check: check,
                    _token: '<?php echo csrf_token(); ?>'
                },
                success: function(result) {

                    console.log('done guard_active_inactive_status');
                    window.location.href = "{{ url('/guards') }}?status=" + link;

                }

            });
        }

       
        
    </script>



@stop
