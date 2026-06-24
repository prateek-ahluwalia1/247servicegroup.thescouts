@extends('layout.app') @extends('layout.sidebar')
@extends('layout.footer')
@include('admin.guard.edit-guard.id-form')
@include('admin.guard.edit-guard.documents-form')
@if(config('custom.own_payrates') == 0)
@include('admin.guard.edit-guard.payrates')
@else
@include('admin.guard.edit-guard.own_payrates_new')
{{--@include('admin.guard.edit-guard.own_payrates') --}}
@endif
@include('admin.guard.edit-guard.sites_blocked')
 @include('admin.guard.edit-guard.sites_trained')
@include('admin.guard.edit-guard.work-limit')
@include('admin.guard.edit-guard.payroll')
@include('admin.guard.edit-guard.change_password')
@include('admin.guard.edit-guard.guard_avability')
@include('admin.guard.edit-guard.guard_uniform')
@include('admin.guard.edit-guard.work_limitation')
@include('admin.guard.edit-guard.leave_management')
@include('admin.guard.edit-guard.profile_tracker')

@section('pageCss')
    <base href="../../../">
    <meta charset="utf-8" />
    <title>{{ config('custom.title') }}</title>
    <meta name="keywords"
        content="{{ config('custom.title')}}" />
    <link rel="canonical" href="Https://preview.keenthemes.com/metronic8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- <link rel="shortcut icon" href="{{ asset('') }}media/logos/favicon.ico" /> -->
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{ asset('') }}plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}css/style.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}css/upload.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .rTable {
            display: table;
            width: 100%;
        }

        .rTableRow {
            display: table-row;
        }

        .rTableBody {
            display: table-row-group;
        }

        .rTableCell,
        .rTableHead {
            display: table-cell;
            padding: 3px 10px;
            border: 1px solid #999999;
        }

        .step.active ..tab-step-number,
        .step.current .tab-step-number {
            color: #3f51b5;
            background-color: #fff;
        }

        .dataTables_wrapper {
            width: 100% !important;
        }

        .dataTables_paginate {
            float: right;
        }
    </style>
<!--end::Global Stylesheets Bundle-->@stop
<!--end::Head-->
<!--begin::Body-->
@section('content')
    <?php
    $progress = 0;
    if (isset($guard_data['guard']) && !empty($guard_data['guard'])) {
        if ($guard_data['guard']->first_name != '') {
            $progress += 12.5;
        }
        if ($guard_data['guard']->last_name != '') {
            $progress += 12.5;
        }
        if ($guard_data['guard']->phone != '') {
            $progress += 12.5;
        }
        if ($guard_data['guard']->address != '') {
            $progress += 12.5;
        }
        if ($guard_data['guard']->emergency_contact_name != '') {
            $progress += 12.5;
        }
        if ($guard_data['guard']->emergency_contact_phone != '') {
            $progress += 12.5;
        }
        if ($guard_data['guard']->email != '') {
            $progress += 12.5;
        }
        if ($guard_data['guard']->profile_image != '') {
            $progress += 12.5;
        }
    }
    
    $item = session()->get('config_arr_job_roster');
    // @dd($item);
    if (!empty($item)) {
        foreach (session()->get('config_arr_job_roster') as $item1) {
            $item = $item1;
        }
    } else {
        $item['add_guards'] = 1;
        $item = json_decode(json_encode($item));
    }
    ?>
    <!--end::Logo-->
    <!--begin::Wrapper-->
    <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
        <!--begin::Header-->
        <div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header"
            data-kt-sticky-offset="{default: '200px', lg: '300px'}">
            <!--begin::Container-->
            <div class="container d-flex align-items-center justify-content-between" id="kt_header_container">
                <!--begin::Page title-->
                <div>
                    <div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-2 pb-2 pb-lg-0"
                        data-kt-swapper="true" data-kt-swapper-mode="prepend"
                        data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
                        <!--begin::Heading-->
                        <h1 class="text-dark fw-bolder my-0 fs-2">
                            @if (session()->get('userType') == 'admin')
                                <a href="{{ url('guards?status=active') }}" class="btn btn-default"><i
                                        class="fas fa-arrow-left"></i></a>
                            @endif
                            Edit {{$guard_data['guard']->name}}
                        </h1>
                        <!--end::Heading-->
                    </div>
                </div>
                <!--end::Page title=-->
                <!--begin::Wrapper-->
                <div class="d-flex d-lg-none align-items-center ms-n2 me-2">
                    <!--begin::Aside mobile toggle-->
                    <div class="btn btn-icon btn-active-icon-primary" id="kt_aside_toggle">
                        <!--begin::Svg Icon | path: icons/duotone/Text/Menu.svg--><span class="svg-icon svg-icon-2x">
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
                    <!--end::Logo-->
                </div>
                <!--end::Wrapper-->@include('layout.toolbar') @yield('toolbar')
            </div>
            <!--end::Container-->
        </div>
        <!--end::Header-->
        <!--begin::Content-->
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <!--begin::Container-->
            <div class="container" id="kt_content_container">
                <!--begin::Row-->
                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-9">
                    <!-- personal form -->
                    <!--begin::Col-->
                    <div class="col-md-4">
                        <!--begin::Card-->
                        <div class="card card-flush h-md-100">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>Personal</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-1">
                                <!--begin::Users-->
                                <!-- <div class="fw-bolder text-gray-600 mb-5">Total features with this role</div> -->
                                <!--end::Users-->
                                <!--begin::Permissions-->
                                <div class="d-flex flex-column text-gray-600">
                                    <div class="d-flex flex-column w-100 me-2">
                                        <div class="d-flex flex-stack mb-2"> <span
                                                class="text-muted me-2 fs-7 fw-bold">{{ $progress }}%</span> </div>
                                        <div class="progress h-6px w-100">
                                            <div class="progress-bar bg-primary" role="progressbar"
                                                style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Permissions-->
                            </div>
                            <!--end::Card body-->
                            <!--begin::Card footer-->
                            <div class="card-footer flex-wrap pt-0">
                                <button type="button" class="btn btn-white btn-active-light-primary my-1"
                                    id="personal-modal-btn">Open Personal Information</button>
                            </div>
                            <!--end::Card footer-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Col-->
                    <!-- ID form -->
                    <!--begin::Col-->@yield('ID-form') @yield('documents-form')
                    @if(session()->get('userType') != 'contractor') @yield('payroll-form') @yield('pay-rates')
                    @yield('work-limit-form') @yield('sites-trained') @yield('sites-blocked') @yield('change_password') @yield('guard_avability')
                    @yield('guard_uniform') @yield('work')@yield('leave_management')@yield('profile_tracker')
                    @endif
                    <!--end::Col-->
                    <!-- documents form -->
                    <!--begin::Col-->
                    <!--end::Col-->
                    <!-- work limitation form -->
                    <!--begin::Col-->
                    <!--end::Col-->
                    <!-- payroll form -->
                    <!--begin::Col-->
                    <!--end::Col-->
                    <!-- Pay Rates form -->
                    <!--begin::Col-->
                    <!--end::Col-->
                    <!-- Sites Trained form -->
                    <!--begin::Col-->
                    <!--end::Col-->
                    <!-- sites blocked form -->
                    <!--begin::Col-->
                    <!--end::Col-->
                    <!--begin::Add new card-->
                    <input type="hidden" name="guard_id" id="guard_id" value="{{ $guard_data['guard']->id }}">
                </div>
                <!--end::Row-->
                <!--begin::Modals-->
                <!--begin::Modal - Add role-->
                <!--end::Modal - Add role-->
                <!--begin::Modal - Update role-->
                <div class="modal fade" id="personal-modal" tabindex="-1" aria-hidden="true">
                    <!--begin::Modal dialog-->
                    <div class="modal-dialog modal-dialog-centered mw-750px">
                        <!--begin::Modal content-->
                        <div class="modal-content">
                            <!--begin::Modal header-->
                            <div class="modal-header">
                                <!--begin::Modal title-->
                                <h2 class="fw-bolder" id="form_head">Personal</h2>
                                <!--end::Modal title-->
                                <!--begin::Close-->
                                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                                    aria-label="Close"> <span class="svg-icon svg-icon-2x">X</span> </div>
                                <!--end::Close-->
                            </div>
                            <!--end::Modal header-->
                            <!--begin::Modal body-->
                            <div class="modal-body scroll-y mx-5 my-7">
                                <!--begin::Form-->
                                <form id="personal-form-guard" class="form"
                                    action="{{ url('guard/save_personal_form') }}" method="POST"
                                    enctype="multipart/form-data"> @csrf
                                    <input type="hidden" class="form-control form-control-md" id="guard_id"
                                        name="guard_id" required value="{{ $guard_id }}">
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="d-block fw-bold fs-6 mb-5">Avatar</label>
                                        <!--end::Label-->
                                        <!--begin::Image input-->
                                        <div class="image-input image-input-outline" data-kt-image-input="true"
                                            id="avatar" style="background-image: url(assets/media/avatars/blank.png)">
                                            <!--begin::Preview existing avatar-->
                                            <div class="image-input-wrapper w-125px h-125px" id="preview_img"
                                                style=""></div>
                                            <!--end::Preview existing avatar-->
                                            <!--begin::Label-->
                                            <label
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                                                data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                title="Change avatar"> <i class="bi bi-pencil-fill fs-7"></i>
                                                <!--begin::Inputs-->
                                                <input accept="image/png, image/gif, image/jpeg" type="file"
                                                    onchange="upload_file('profileImage', 'profileImageUploaded')"
                                                    type="file" class="form-control form-control-md" id="profileImage"
                                                    name="profileImage">
                                                <input type="hidden" name="profileImageUploaded"
                                                    id="profileImageUploaded">
                                                <input type="hidden" name="avatar_remove" />
                                                <!--end::Inputs-->
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Cancel--><span
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                                                data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                                title="Cancel avatar">
                                                <i class="bi bi-x fs-2"></i>
                                            </span>
                                            <!--end::Cancel-->
                                            <!--begin::Remove--><span onclick="avatar_remove()"
                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                                                data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                                title="Remove avatar">
                                                <i class="bi bi-x fs-2"></i>
                                            </span>
                                            <!--end::Remove-->
                                        </div>
                                        <!--end::Image input-->
                                        <!--begin::Hint-->
                                        <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                        <!--end::Hint-->
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label for="name" class="col-form-label">First Name</label>
                                            <input type="text" class="form-control form-control-md" id="first_name"
                                                name="first_name" required>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="name" class="col-form-label">Middle Name</label>
                                            <input type="text" class="form-control form-control-md" id="middle_name"
                                                name="middle_name">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="name" class="col-form-label">Last Name</label>
                                            <input type="text" class="form-control form-control-md" value=""
                                                id="last_name" name="last_name" required>
                                        </div>
                                    </div>
                                    <!-- 			<div class="row">
           <div class="col-md-6 form-group">
            <label for="recipient-name" class="col-form-label">Profile image </label>
            <input accept="image/png, image/gif, image/jpeg" type="file" onchange="upload_file('profileImage', 'profileImageUploaded')" type="file" class="form-control form-control-md" id="profileImage" name="profileImage">
            <input type="hidden" name="profileImageUploaded" id="profileImageUploaded">
           </div>
           </div> -->
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="recipient-name" class="col-form-label">Email</label>
                                            <input type="email" class="form-control form-control-md" name="email"
                                                required>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            {{-- <label for="recipient-name" class="col-form-label">Password</label>
											<input type="text" class="form-control form-control-md"  name="password" required>  --}}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="recipient-name"
                                                class="col-form-label">{{ config('custom.guard') }} Type</label>
                                            <select class="form-select form-select-lg form-select-solid"
                                                data-placeholder="Select..." id="guard_type" name="guard_type">
                                                <!-- <option>Select</option> -->
                                                <option value="Direct">Direct</option>
                                                <option value="Contractor">Contractor</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 form-group" id="contractor_container">
                                            <label for="recipient-name" class="col-form-label">Contractors</label>
                                            <select class="form-select form-select-lg " data-placeholder="Select..."
                                                id="contractor_id" name="contractor_id">

                                            </select>
                                        </div>
                                        @if(config('custom.categorized_payrates') == 1)
                                        <div class="col-md-6 form-group">
                                            <label for="recipient-name" class="col-form-label">{{ config('custom.guard') }} Level</label>
                                            <select class="form-select form-select-lg " data-placeholder="Select..."
                                                id="guard_level" name="guard_level">
                                                <option value="1"> 1</option>
                                                <option value="2"> 2</option>
                                                <option value="3"> 3</option>
                                                <option value="4"> 4</option>
                                                <option value="5"> 5</option>

                                            </select>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label for="recipient-name"
                                                class="col-form-label">{{ config('custom.guard') }} Type</label>

                                            <select class="form-select form-select-lg form-select-solid"
                                                data-control="select2" data-placeholder="Select..."
                                                data-allow-clear="true" data-hide-search="true" id="guard_working_type"
                                                name="guard_working_type">
                                                <option value="guard">{{ config('custom.guard') }}</option>
                                                <option value="covid_marshal">Covid Marshal</option>
                                                <option value="both">Both</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label for="recipient-name"
                                                class="col-form-label">{{ config('custom.guard') }} Position</label>

                                            <select class="form-select form-select-lg form-select-solid"
                                                data-control="select2" data-placeholder="Select..."
                                                data-allow-clear="true" data-hide-search="true" id="position"
                                                name="position">
                                                <option value="full_time">Full-time</option>
                                                <option value="part_time">Part-time</option>
                                                <option value="casual">Casual</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="recipient-name" class="col-form-label">Phone</label>
                                            <input type="text" class="form-control form-control-md"
                                                placeholder="phone " name="phone">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="recipient-name" class="col-form-label">Address</label>
                                            <input type="text" class="form-control form-control-md"
                                                placeholder="address " name="address" id="googleaddressSearch">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label for="recipient-name" class="col-form-label">Suburb</label>
                                            <input type="text" class="form-control form-control-md" name="suburb"
                                                id="locality">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="recipient-name" class="col-form-label">City</label>
                                            <input type="text" class="form-control form-control-md" name="city"
                                                id="administrative_area_level_2">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="recipient-name" class="col-form-label">State</label>
                                            <select class="form-select form-select-lg form-select-solid"
                                                data-control="select2" data-placeholder="Select..."
                                                data-allow-clear="true" data-hide-search="true" name="state"
                                                id="administrative_area_level_1">
                                                <option value="Victoria">Victoria</option>
                                                <option value="New South Wales">NSW</option>
                                                <option value="Queensland">Queensland</option>
                                                <option value="Tasmania">Tasmania</option>
                                                <option value="Western Australia">Western Australia</option>
                                                <option value="South Australia">South Australia</option>
                                                <option value="ACT">ACT</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label for="recipient-name" class="col-form-label">Coordinates</label>
                                            <input type="text" class="form-control form-control-md"
                                                id="coordinate_display" disabled name="coordinate_display">
                                            <input type="hidden" class="form-control form-control-md" id="coordinates"
                                                name="coordinates">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label for="recipient-name" class="col-form-label">Postal code</label>
                                            <input type="text" class="form-control form-control-md" name="postalCode">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="recipient-name" class="col-form-label">Dob</label>
                                            <input type="" class="form-control form-control-md" value="dob "
                                                name="dob">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="recipient-name" class="col-form-label">Gender</label>
                                            <select class="form-select form-select-lg form-select-solid"
                                                data-control="select2" data-placeholder="Select..."
                                                data-allow-clear="true" data-hide-search="true" name="gender">
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <div class="fv-row mb-10">
                                                <label for="recipient-name" class="col-form-label">Emergency contact
                                                    name</label>
                                                <input type="text" class="form-control form-control-md"
                                                    name="emergencyContactName">
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <div class="fv-row mb-10">
                                                <label for="recipient-name" class="col-form-label">Emergency contact
                                                    phone</label>
                                                <input type="text" class="form-control form-control-md"
                                                    name="emergencyContactPhone">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"> </div>
                                    @if (isset($item->add_guards) && $item->add_guards == 1)
                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <div class="fv-row mb-10">
                                                    <label for="recipient-name" class="col-form-label">Select
                                                        Customers</label>

                                                    <select multiple multiselect-search="true"
                                                        multiselect-select-all="true" multiselect-max-items="1"
                                                        id="specific_customers_id" name="specific_customers_id[]"
                                                        multiple="">
                                                        <!-- <option value="">Select Customer</option> -->
                                                        @foreach ($customers as $customer)
                                                            <option value="{{ $customer->id }}">{{ $customer->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary"
                                            data-kt-users-modal-action="submit"> <span id="form_submit"
                                                class="indicator-label">Submit</span> <span
                                                class="indicator-progress">Please wait...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                            </span>
                                        </button>
                                    </div>
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Modal body-->
                        </div>
                        <!--end::Modal content-->
                    </div>
                    <!--end::Modal dialog-->
                </div>
                <!--end::Modal - Update role-->
                <!--end::Modals-->
            </div>
            <!--end::Container-->
        </div>
        <form id="extrafrom"></form>
        <!--end::Content-->
        <!--begin::Footer-->
        <!--end::Footer-->
        <!--end::Root-->
        <!--begin::Drawers-->
        <!--begin::Activities drawer-->@stop @section('pageFooter')
        <!--end::Scrolltop-->
        <!--end::Main-->
        <!--begin::Javascript-->
        <!--begin::Global Javascript Bundle(used by all pages)-->
        <script src="{{ asset('') }}plugins/global/plugins.bundle.js"></script>
        <script src="{{ asset('') }}js/scripts.bundle.js"></script>
        <!--end::Global Javascript Bundle-->
        <!--begin::Page Custom Javascript(used by this page)-->
        <script src="{{ asset('') }}js/custom/apps/user-management/roles/list/add.js"></script>
        <script src="{{ asset('') }}js/custom/apps/user-management/roles/list/update-role.js"></script>
        <script src="{{ asset('') }}js/custom/widgets.js"></script>
        <script src="{{ asset('') }}js/custom/apps/chat/chat.js"></script>
        <script src="{{ asset('') }}js/custom/modals/create-app.js"></script>
        <script src="{{ asset('') }}js/custom/modals/upgrade-plan.js"></script>
        <!--end::Page Custom Javascript-->
        <!--end::Javascript-->
        <script>
            $('.date-picker').flatpickr({
        enableTime: !1,
        dateFormat: "Y-m-d"
    });
            $(document).on('click', '._ac-add-more-ids-btn', function(e) {
                getIDs($('._index').length);
            });
            $(document).on('click', '._ac-add-more-payroll-ids-btn', function(e) {
                getPayrolIDs($('._index_payroll').length);
            });

            function getIDs(index) {
                $.ajax({
                    url: "{{ url('guard/get_guard_ids_form') }}",
                    data: {
                        index: index,
                        _token: '{{ csrf_token() }}'
                    },
                    type: "POST",
                    success: function(result) {
                        // console.log(result);
                        // $("#div1").html(result);
                        $('#guard-ids-container').append(result);
                    }
                });
            }

            function getPayrolIDs(index) {
                $.ajax({
                    url: "{{ url('guard/get_guard_payroll_ids_form') }}",
                    data: {
                        index: index,
                        _token: '{{ csrf_token() }}'
                    },
                    type: "POST",
                    success: function(result) {
                        // console.log(result);
                        // $("#div1").html(result);
                        $('#guard-payroll-ids-container').append(result);

                    }
                });
            }
            $(document).on('click', '._ac-add-more-site-block-btn', function(e) {
                getSiteBlocked($('._site-block-index').length);
            });

            function getSiteBlocked(index) {
                $.ajax({
                    url: "{{ url('guard/get_guard_site_block_form') }}",
                    data: {
                        index: index,
                        isGuard: false,
                        _token: '{{ csrf_token() }}'
                    },
                    type: "POST",
                    success: function(result) {
                        // $("#div1").html(result);
                        $('#guard-site-blocked-container').append(result);
                        // getCustomers(index, 3);
                    }
                });
            }
            $(document).on('change', '._ac-site-block-customer-change', function(e) {
                var _this = $(this);
                var index = _this.attr('data-index');
                getCustomerJobs(_this.val(), index, 'site-block', '');
            });

            $(document).on('change', '._ac-site-trainsed-customer-change', function(e) {
                var _this = $(this);
                var index = _this.attr('data-index');
                getCustomerJobs(_this.val(), index, 'site-trained', '');
            });

            function getCustomerJobs(customerId, index, type, siteId) {
                $.ajax({
                    url: "{{ url('job/get_customers_jobs') }}",
                    data: {
                        customerId: customerId,
                        _token: '{{ csrf_token() }}'
                    },
                    type: "POST",
                    success: function(response) {
                        console.log(response)
                        // response = JSON.parse(response);
                        options = '<option value="">Select Site</option>';
                        $.each(response, function(id, data) {
                            var site_name = data.address;
                            if (data.site_name != '') {
                                site_name = data.site_name + ' (' + data.site_description + ')';
                            }
                            selected_check = (data.jobId === siteId) ? 'selected' : '';
                            options += '<option ' + selected_check + ' value="' + data.jobId + '">' +
                                site_name + '</option>';
                        });
                        if (type === 'site-block') {
                            $('#site_blocked_site-option-' + index).html(options);
                        } else if (type === 'site-trained') {
                            $('#site_trained_site-option-' + index).html(options);
                        } else {
                            $('#site_blocked_site-option-' + index).html(options);
                            $('#site_trained_site-option-' + index).html(options);
                        }
                    }
                });
            }
            $(document).on('click', '._ac-add-more-site-train-btn', function(e) {
                getSiteTraine($('._site-train-index').length);
            });

            function getSiteTraine(index) {
                $.ajax({
                    url: "{{ url('guard/get_guard_site_train_form') }}",
                    data: {
                        index: index,
                        _token: '{{ csrf_token() }}'
                    },
                    type: "POST",
                    success: function(result) {
                        // $("#div1").html(result);
                        $('#guard-site-trained-container').append(result);
                        // getCustomers(index, 2);
                    }
                });
            }
            $("#personal-form-guard").on('submit', function(e) {
                e.preventDefault();
                console.log(this.id)
                var data = $('#' + this.id).serialize();
                $.ajax({
                    type: "POST",
                    url: this.action,
                    data: data,
                    success: function(result) {
                        if (result.success) {
                            $('#personal-modal').modal('hide');
                            Swal.fire({
                                text: result.message,
                                icon: "success",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-light"
                                }
                            })
                            window.location.href = "{{ url('/edit_guard') }}/{{ $guard_id }}";
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

            function upload_file(i, j) {
                call_spinner();
                targetInput = j;
                var formData = new FormData();
                formData.append('file', document.getElementById(i).files[0]);
                $.ajax({
                    url: "{{ url('guard/upload_any_files') }}",
                    type: 'POST',
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    enctype: 'multipart/form-data',
                    processData: false,
                    success: function(response) {
                        $('#' + i).val('');

                        $('#image-upload-message').text('Image upload successfully.');
                        $('#' + targetInput).val(response.path);
                        close_spinner();
                        if (response.success) {
                            $('#' + i).after(
                                '<span style="color:green;">Image Uplaoded successfully. Please submit form to save this image.</span>'
                            );
                            $('#' + i).remove();
                        } else {
                            // alert(response);
                        }
                    }
                });
                setTimeout(function() {
                    // console.log('I am Run')
                    close_spinner();
                    // Do something after 1 second 
                }, 3000);
                // console.log('I am Run2')

                // formData1.append($('#'+i)[0].files[0]);
                // console.log(formData);
                // errorAlert('Please wait image is uploading...');
                // readImage(document.getElementById(i), i);
            }

            function readImage(e, i) {
                if (e.files && e.files[0]) {
                    var FR = new FileReader();
                    FR.addEventListener("load", function(e) {
                        var image = e.target.result;
                        if (image != '') {
                            call_spinner();
                            $.ajax({
                                type: "POST",
                                url: "{{ url('guard/upload_files') }}",
                                data: {
                                    image: image,
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(result) {
                                    // console.log(result)
                                    var obj = result;
                                    close_spinner();
                                    if (obj.success) {
                                        $('#' + i).val('');
                                        $('#image-upload-message').text('Image upload successfully.');
                                        $('#' + targetInput).val(obj.path);
                                        if ('profileImage' == i) {
                                            $('#profileImage').removeAttr('required')
                                        }
                                    } else {
                                        $('#image-upload-message').text('Failed to upload image!');
                                        $('#' + i).val('');
                                    }
                                }
                            });
                        } else {
                            alertify.error('Not a valid image!')
                        }
                    });
                    FR.readAsDataURL(e.files[0]);
                    console.log(`#div_${i}`);
                    $(`#div_${i}`).hide();
                    $(`#doc_${i}`).show();
                }
            }
            var searchInput = 'googleaddressSearch';
            var componentForm = {
                // street_number: 'short_name',
                // route: 'long_name',
                locality: 'long_name',
                administrative_area_level_2: 'short_name',
                administrative_area_level_1: 'long_name',
                // country: 'long_name'
            };
            
            $(document).ready(function() {

                $(".kt_datetimepicker").flatpickr({
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                });

                // $(".kt_daterangepicker").daterangepicker();

                get_personal_data();
                getcontractors();
                var options = {
                    componentRestrictions: {
                        country: "au"
                    }
                };
                var autocomplete;
                autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), options, {
                    types: ['geocode'],
                });
                google.maps.event.addListener(autocomplete, 'place_changed', function() {
                    var near_place = autocomplete.getPlace();
                    console.log(near_place.address_components)
                    latitude = near_place.geometry.location.lat();
                    logitude = near_place.geometry.location.lng();
                    latlng = latitude + "," + logitude
                    $("#coordinate_display").val(latlng);
                    $("#coordinates").val(latlng);
                    for (var i = 0; i < near_place.address_components.length; i++) {
                        var addressType = near_place.address_components[i].types[0];
                        if (componentForm[addressType]) {
                            var val = near_place.address_components[i][componentForm[addressType]];
                            document.getElementById(addressType).value = val;
                        }
                    }
                    // document.getElementById('latitude_view').innerHTML = near_place.geometry.location.lat();
                    // document.getElementById('longitude_view').innerHTML = near_place.geometry.location.lng();
                });
            });
            // });
        </script>
    <script type="text/javascript">
        $('#ID-modal-btn').on('click', function() {
            $.ajax({
                type: "POST",
                url: "{{ url('guard/get_guard_ids') }}",
                data: {
                    guard_id: '{{ $guard_id }}',
                    _token: '{{ csrf_token() }}'
                },
                success: function(result) {
                    // console.log(result)
                    if (result.success == true) {
                        $('#guard-ids-container').html('');
                        $('#internal_id').val(result.ids[0].internal_id);
                        $('#guard-ids-container').append(result.ids_html);

                    } else {
                        $('#guard-ids-container').html('');
                    }
                }
            });
            load_already_payroll_ids();
            $('#ID-modal').modal('show');
        });
        // function getpayrollId()
        // {
        // 	// console.log(type)
        // 	$.ajax({
        // 		type: "POST",
        // 		url: "{{ url('guard/guard_payroll_id') }}",
        // 		data: {
        // 			guard_id :{{ $guard_id }},
        // 			_token: '{{ csrf_token() }}'
        // 		},
        // 		success: function(result) {
        // 			// console.log(result)
        // 			if(result.success == true) {
        // 				$('#payroll-id').val(result.id);
        // 				$('#payroll-option').val(result.type);
        // 			}
        // 		}
        // 	});
        // }

        function load_already_payroll_ids() {
            $.ajax({
                type: "POST",
                url: "{{ url('guard/get_guard_payroll_ids') }}",
                data: {
                    guard_id: '{{ $guard_id }}',
                    _token: '{{ csrf_token() }}'
                },
                success: function(result) {

                    // console.log(result)
                    // $('#add_more_payroll').hide();
                    if (result.success == true) {
                        $('#payroll-option').val(result.ids[0].type);
                        $('#payroll-id').val(result.ids[0].payroll_id);

                    } else {
                        // getpayrollId();

                    }
                    // if(result.type=='direct'){
                    // 	$('#payroll-option').val("direct");
                    // 	getpayrollId();
                    // }else{
                    // 	$('#payroll-option').val("contractor");
                    // 	getpayrollId();
                    // }
                    // if(result.contractor_check==true){
                    // 	console.log('enter');
                    // 	$('#payroll-option').val("contractor");
                    // }else{
                    // $('#add_more_payroll').click();
                    // }
                }
            });
        }
        $("#ids-form").on('submit', function(e) {
            e.preventDefault();
            console.log(this.id)
            var data = $('#' + this.id).serialize();
            $.ajax({
                type: "POST",
                url: this.action,
                data: data,
                success: function(result) {
                    if (result.success) {
                        Swal.fire({
                            text: result.message,
                            icon: "success",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-light"
                            }
                        })
                        window.location.href = "{{ url('/edit_guard') }}/{{ $guard_id }}";
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
        $("#documents-form").on('submit', function(e) {
            e.preventDefault();
            // console.log(this.id)
            var data = $('#' + this.id).serialize();
            $.ajax({
                type: "POST",
                url: this.action,
                data: data,
                success: function(result) {
                    if (result.success) {
                        $('#documents-modal').modal('hide');
                        Swal.fire({
                            text: result.message,
                            icon: "success",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-light"
                            }
                        })
                        // window.location.href = "{{ url('/edit_guard') }}/{{ $guard_id }}";

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

        function get_gaurd_other_files(guardId) {
            // console.log(guardId); 
            $.ajax({
                type: "POST",
                url: "{{ url('guard/get_gaurd_other_files') }}",
                data: {
                    guard_id: guardId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(result) {
                    $('#guard-document-container').html(result);
                }
            });
        }

        $('#documents-modal-btn').on('click', function() {
            $.ajax({
                type: "POST",
                url: "{{ url('guard/get_guard_documents') }}",
                data: {
                    guard_id: '{{ $guard_id }}',
                    _token: '{{ csrf_token() }}'
                },
                success: function(result) {
                    $('#documents-modal').modal('show');
                    if (result.success == true) {
                        get_gaurd_other_files('{{ $guard_id }}');
                        var subselect_check = result.documnets.residential_status_secondary;
                        // console.log(subselect_check);
                        $('select[name="registrationType"]').val(result.documnets.registrationType);
                        $('select[name="residentialStatus"]').val(result.documnets.residentialStatus);
                        $('select[name="subselect"]').val(result.documnets
                        .residential_status_secondary);
                        // $('input[name="medicareNumber"]').val(result.documnets.medicareNumber);
                        $('input[name="medicareNumber"]').val(result.documnets.medicareNumber);
                        $('input[name="medicareExpiration"]').val(result.documnets.medicareExpiration);
                        // if (result.documnets.medicareNumber != null && result.documnets.medicareNumber != '') {
                        // 	$('#medicare-div').css('display', '');
                        // }else{
                        // 	$('#medicare-div').css('display', 'none');
                        // }
                        if (subselect_check == "medicare") {
                            $('#medicare-div').show();
                        } else {
                            $('#medicare-div').hide();
                        }
                        $('input[name="citizenshipNumber"]').val(result.documnets.citizenshipNumber);
                        $('input[name="citizenshipExpiration"]').val(result.documnets
                            .citizenshipExpiration);
                        // if (result.documnets.citizenshipNumber != null && result.documnets.citizenshipNumber != '') {
                        if (subselect_check == "citizenship") {
                            $('#citizenship-div').show();
                        } else {
                            $('#citizenship-div').hide();
                        }
                        // }else{
                        // 	$('#citizenship-div').hide();
                        // }
                        $('input[name="birthcertificateNumber"]').val(result.documnets
                            .birthcertificateNumber);
                        $('input[name="birthcertificateExpiration"]').val(result.documnets
                            .birthcertificateExpiration);
                        // if (result.documnets.birthcertificateNumber != null && result.documnets.birthcertificateNumber != '') {
                        if (subselect_check == "birthcertificate") {
                            $('#birthcertificate-div').css('display', '');
                        } else {
                            $('#birthcertificate-div').hide();
                        }
                        // }else{
                        // 	$('#birthcertificate-div').css('display', 'none');
                        // }
                        $('input[name="passportNumber"]').val(result.documnets.passportNumber);
                        $('input[name="passportExpiration"]').val(result.documnets.passportExpiration);
                        // if (result.documnets.passportNumber != null && result.documnets.passportNumber != '') {
                        if (subselect_check == "subpass") {
                            $('#passport-div').css('display', '');
                        } else {
                            $('#passport-div').hide();
                        }
                        // }else{
                        // 	$('#passport-div').css('display', 'none');
                        // }
                        $('input[name="visaNumber"]').val(result.documnets.visaNumber);
                        $('input[name="visaExpiration"]').val(result.documnets.visaExpiration);
                        // if (result.documnets.visaNumber != null && result.documnets.visaNumber != '') {
                        if (subselect_check == "visa") {
                            $('#visa-div').css('display', '');
                        } else {
                            $('#visa-div').hide();
                        }
                        // }else{
                        // 	$('#visa-div').css('display', 'none');
                        // }
                        // $('input[name="securityLicenseNumberBack"]').val(result.documnets.securityLicenseNumberBack);
                        // $('input[name="securityLicenseExpirationBack"]').val(result.documnets.securityLicenseExpirationBack); 
                        // console.log(result.documnets.securityLicenseExpiration);
                        $('input[name="securityLicenseNumber"]').val(result.documnets
                            .securityLicenseNumber);
                        $('input[name="securityLicenseExpiration"]').val(result.documnets
                            .securityLicenseExpiration);
                        $('input[name="driverLicenseNumber"]').val(result.documnets
                        .driverLicenseNumber);
                        $('input[name="driverLicenseExpiration"]').val(result.documnets
                            .driverLicenseExpiration);
                        $('input[name="firstaidLicenseNumber"]').val(result.documnets
                            .firstaidLicenseNumber);
                        $('input[name="firstaidLicenseExpiration"]').val(result.documnets
                            .firstaidLicenseExpiration);
                        // if (result.documnets.firearmLicenseNumber != null && result.documnets.firearmLicenseNumber != '') {
                        $('#driverLicenseFileUploaded').val(result.documnets.driver_license_file);
                        $('#driverLicenseFileBackUploaded').val(result.documnets
                            .driver_license_file_back);
                        $('#firstaidLicenseUploaded').val(result.documnets.firstaid_license_file);
                        $('#firearmLicenseFileUploaded').val(result.documnets.firearm_license_file);
                        $('#passportFileUploaded').val(result.documnets.passport_file);
                        $('#visaFileUploaded').val(result.documnets.visa_file);
                        $('#birthcertificateFileUploaded').val(result.documnets.birthcertificate_file);
                        $('#citizenshipFileUploaded').val(result.documnets.citizenship_file);
                        $('#medicareFileUploaded').val(result.documnets.medicare_file);
                        $('#securityLicenseFileUploaded').val(result.documnets.security_license_file);
                        $('#securityLicenseFileUploadedBack').val(result.documnets
                            .security_license_file_back);
                        if (subselect_check == "firearm") {
                            $('#firearm-div').css('display', '');
                        } else {
                            $('#firearm-div').hide();
                        }
                        // }else{
                        // 	$('#firearm-div').css('display', 'none');
                        // }
                        $('input[name="firearmLicenseNumber"]').val(result.documnets
                            .firearmLicenseNumber);
                        $('input[name="firearmLicenseExpiration"]').val(result.documnets
                            .firearmLicenseExpiration);
                        // if (result.documnets.firearmLicenseNumber != null && result.documnets.firearmLicenseNumber != '') {
                        // 	$('#firearm-div').css('display', '');
                        // }else{
                        // 	$('#firearm-div').css('display', 'none');
                        // }
                        if (result.documnets.residentialStatus == 'student' || result.documnets
                            .residentialStatus == 'subclass-485') {
                            $('#passport-div').css('display', '');
                            $('#visa-div').css('display', '');
                            $('#security-div').css('display', '');
                            $('#security_back-div').css('display', '');

                            $('#driver-div').css('display', '');
                            $('#subselect-div').css('display', 'none');
                            $('#medicare-div').css('display', 'none');
                            $('#citizenship-div').css('display', 'none');
                            $('#birthcertificate-div').css('display', 'none');
                            $('#firearm-div').css('display', 'none');
                        } else if (result.documnets.residentialStatus == 'permanent-resident') {
                            $('#driver-div').css('display', '');
                            $('#security-div').css('display', '');
                            $('#security_back-div').css('display', '');

                            // $('#citizenship-div').css('display', '');
                            $('#subselect-div').css('display', '');
                            $('#passport-div').css('display', 'none');
                            $('#visa-div').css('display', 'none');
                        } else if (result.documnets.residentialStatus == 'citizen') {
                            $('#driver-div').css('display', '');
                            $('#security-div').css('display', '');
                            $('#security_back-div').css('display', '');

                            // $('#citizenship-div').css('display', '');
                            $('#subselect-div').css('display', '');
                            $('#passport-div').css('display', 'none');
                            $('#visa-div').css('display', 'none');
                        } else {
                            $('#security-div').css('display', '');
                            $('#security_back-div').css('display', '');

                            $('#driver-div').css('display', '');
                        }
                        // files 
                        if (result.documnets.medicare_file != '' && result.documnets.medicare_file !=
                            'null' && result.documnets.medicare_file != null) {
                            var newUrl =
                                `{{ config('custom.asset_url') }}${result.documnets.medicare_file}`;
                            $('#link_medicare').attr("href", newUrl);
                            $('#div_medicareFile').hide();
                            $('#doc_medicareFile').show();
                            $('#medicare-div').show();
                            $('#medicare-check').prop('checked', true);
                        } else {
                            $('#medicare-div').hide();

                        }
                        if (result.documnets.citizenship_file != '' && result.documnets
                            .citizenship_file != 'null' && result.documnets.citizenship_file != null) {
                            var newUrl =
                                `{{ config('custom.asset_url') }}${result.documnets.citizenship_file}`;
                            $('#link_citizen').attr("href", newUrl);
                            $('#div_citizenshipFile').hide();
                            $('#doc_citizenshipFile').show();
                            $('#citizenship-check').prop('checked', true);
                            $('#citizenship-div').show();
                        } else {
                            $('#citizenship-div').hide();
                        }
                        if (result.documnets.passport_file != '' && result.documnets.passport_file !=
                            'null' && result.documnets.passport_file != null) {
                            var newUrl =
                                `{{ config('custom.asset_url') }}${result.documnets.passport_file}`;
                            $('#link_passport').attr("href", newUrl);
                            $('#div_passportFile').hide();
                            $('#doc_passportFile').show();
                            $('#passport-div').css('display', '');
                            $('#passport-check').prop('checked', true);
                            $('#passport-div').show();

                        } else {
                            $('#passport-div').hide();
                        }
                        if (result.documnets.visa_file != '' && result.documnets.visa_file != 'null' &&
                            result.documnets.visa_file != null) {
                            var newUrl =
                                `{{ config('custom.asset_url') }}${result.documnets.visa_file}`;
                            $('#link_visa').attr("href", newUrl);
                            $('#div_visaFile').hide();
                            $('#doc_visaFile').show();
                            $('#visa-check').prop('checked', true);
                            $('#visa-div').show();
                        } else {
                            $('#visa-div').hide();
                        }
                        if (result.documnets.amginduction_file != '' && result.documnets
                            .amginduction_file != 'null' && result.documnets.amginduction_file != null
                            ) {
                            var newUrl =
                                `{{ config('custom.asset_url') }}${result.documnets.amginduction_file}`;
                            $('#link_amginduction_file').attr("href", newUrl);
                            $('#div_amginductionFile').hide();
                            $('#doc_amginductionFile').show();
                            $('#amginduction-check').prop('checked', true);
                            $('#amginduction-div').show();
                        } else {
                            $('#amginduction-div').hide();
                        }
                        if (result.documnets.police_file != '' && result.documnets.police_file !=
                            'null' && result.documnets.police_file != null) {
                            var newUrl =
                                `{{ config('custom.asset_url') }}${result.documnets.amginduction_file}`;
                            $('#link_police_file').attr("href", newUrl);
                            $('#div_policeFile').hide();
                            $('#doc_policeFile').show();
                            $('#police-check').prop('checked', true);
                            $('#policecheck-div').show();
                        } else {
                            $('#policecheck-div').hide();
                        }
                        if (result.documnets.security_license_file != '' && result.documnets
                            .security_license_file != 'null' && result.documnets
                            .security_license_file != null) {
                            var newUrl =
                                `{{ config('custom.asset_url') }}${result.documnets.security_license_file}`;
                            $('#link_security').attr("href", newUrl);
                            $('#div_securityLicenseFile').hide();
                            $('#doc_securityLicenseFile').show();
                            $('#security-check').prop('checked', true);
                            $('#security-div').show();

                        } else {
                            $('#security-div').hide();
                        }
                        if (result.documnets.security_license_file_back != '' && result.documnets
                            .security_license_file_back != 'null' && result.documnets
                            .security_license_file_back != null) {
                            var newUrl =
                                `{{ config('custom.asset_url') }}${result.documnets.security_license_file_back}`;
                            $('#link_security_back').attr("href", newUrl);
                            $('#div_securityLicenseFileBack').hide();
                            $('#doc_securityLicenseFileBack').show();
                            $('#security-check').prop('checked', true);
                        } else {

                        }
                        if (result.documnets.driver_license_file != '' && result.documnets
                            .driver_license_file != 'null' && result.documnets.driver_license_file !=
                            null) {
                            var newUrl =
                                `{{ config('custom.asset_url') }}${result.documnets.driver_license_file}`;
                            $('#link_driver').attr("href", newUrl);
                            // console.log('enter inside of tesitnngsndginsdgjnsdjkhsdjkg');
                            $('#div_driverLicenseFile').hide();
                            $('#doc_driverLicenseFile').show();
                            $('#driver-check').prop('checked', true);
                            $('#driver-div').show();

                        } else {
                            $('#driver-div').hide();
                        }
                        if (result.documnets.workingwithchildren_file != '' && result.documnets
                            .workingwithchildren_file != 'null' && result.documnets
                            .workingwithchildren_file != null) {
                            var newUrl =
                                `{{ config('custom.asset_url') }}${result.documnets.driver_license_file}`;
                            $('#link_workingwithchildren').attr("href", newUrl);
                            $('#div_workingwithchildrenFile').hide();
                            $('#doc_workingwithchildrenFile').show();
                            $('#workingwithchildren-check').prop('checked', true);
                            $('#workingwithchildren-div').show();

                        } else {
                            $('#workingwithchildren-div').hide();
                        }
                        if (result.documnets.driver_license_file_back != '' && result.documnets
                            .driver_license_file_back != 'null' && result.documnets
                            .driver_license_file_back != null) {
                            var newUrl =
                                `{{ config('custom.asset_url') }}${result.documnets.driver_license_file_back}`;
                            $('#link_driver_back').attr("href", newUrl);
                            // console.log('enter inside of tesitnngsndginsdgjnsdjkhsdjkg');
                            $('#div_driverLicenseFileBack').hide();
                            $('#doc_driverLicenseFileBack').show();
                            $('#driver-check').prop('checked', true);
                            $('#driver-div').show();
                        } else {
                            // $('#driver-div').hide();
                        }
                        if (result.documnets.firstaid_license_file != '' && result.documnets
                            .firstaid_license_file != 'null' && result.documnets
                            .firstaid_license_file != null) {
                            var newUrl =
                                `{{ config('custom.asset_url') }}${result.documnets.firstaid_license_file}`;
                            $('#link_firstaid').attr("href", newUrl);
                            $('#div_firstaidLicense').hide();
                            $('#doc_firstaidLicense').show();
                            $('#firstaid-check').prop('checked', true);
                            $('#firstaid-div').show();
                        } else {
                            $('#firstaid-div').hide();
                        }
                        if (result.documnets.firearm_license_file != '' && result.documnets
                            .firearm_license_file != 'null' && result.documnets.firearm_license_file !=
                            null) {
                            var newUrl =
                                `{{ config('custom.asset_url') }}${result.documnets.firearm_license_file}`;
                            $('#link_firearm').attr("href", newUrl);
                            $('#div_firearmLicenseFile').hide();
                            $('#doc_firearmLicenseFile').show();
                            $('#firearm-check').prop('checked', true);
                            // $('#firstaid-div').show();
                        } else {
                            // $('#firstaid-div').hide();
                        }
                        if (result.documnets.birthcertificate_file != '' && result.documnets
                            .birthcertificate_file != 'null' && result.documnets
                            .birthcertificate_file != null) {
                            var newUrl =
                                `{{ config('custom.asset_url') }}${result.documnets.birthcertificate_file}`;
                            $('#link_birth').attr("href", newUrl);
                            $('#div_birthcertificateFile').hide();
                            $('#doc_birthcertificateFile').show();
                            $('#birthcertificate-check').prop('checked', true);
                            $('#birthcertificate-div').show();
                        } else {
                            $('#birthcertificate-div').hide();
                        }

                        if (result.documnets.vaccination_certificate != '' && result.documnets
                            .vaccination_certificate != 'null' && result.documnets
                            .vaccination_certificate != null) {
                            var newUrl =
                                `{{ config('custom.asset_url') }}${result.documnets.vaccination_certificate}`;
                            $('#link_vaccination').attr("href", newUrl);
                            $('#div_vaccinationFile').hide();
                            $('#doc_vaccinationFile').show();
                            $('#vaccination-check').prop('checked', true);
                            $('#vaccination-div').show();
                        } else {
                            $('#vaccination-div').hide();
                        }

                        if (result.state == 'Victoria' || result.state == 'victoria' || result.state ==
                            'Vic') {
                            $('#driver-div-back').show();
                            $('#security-div-back').hide();
                        } else {
                            $('#driver-div-back').hide();
                            $('#security-div-back').show();
                        }
                        if (result.documnets.required_docs != null) {
                            $.each(result.documnets.required_docs, function(ind,vlx){
                                jQuery("input[name='"+ind+"']").prop('checked', vlx);
                                // var pre = ind.split('_');
                                // console.log(pre);
                            });
                            // console.log(result.documnets.required_docs);
                        }
                        if (result.documnets.customer_docs != null) {
                            $.each(result.documnets.customer_docs, function(ind,vlx){
                                jQuery("input[name='"+ind+"']").prop('checked', vlx);
                                // var pre = ind.split('_');
                                // console.log(pre);
                            });
                            // console.log(result.documnets.required_docs);
                        }
                        // endfile
                    }
                }
            });
        });
        $('#payroll-modal-btn').on('click', function() {
            $.ajax({
                type: "POST",
                url: "{{ url('guard/get_guard_payrol') }}",
                data: {
                    guard_id: '{{ $guard_id }}',
                    _token: '{{ csrf_token() }}'
                },
                success: function(result) {
                    $('#payroll_tfn_number').val(result.guard.payroll_tfn_number);
                    $('#payroll_abn_number').val(result.guard.payroll_abn_number);
                    $('#payroll_superannutation').val(result.guard.payroll_superannutation);
                    $('#payroll_superannutation_name').val(result.guard.payroll_superannutation_name);
                    $('#payroll_bank_name').val(result.guard.payroll_bank_name);
                    $('#payroll_bsb').val(result.guard.bsb);
                    $('#payroll_bank_account_number').val(result.guard.payroll_bank_account_number);
                    if (result.guard.superannutation_file != '' && result.guard.superannutation_file !=
                        'null' && result.guard.superannutation_file != null) {
                        var newUrl =
                            `{{ config('custom.asset_url') }}${result.guard.superannutation_file}`;
                        $('#link_superannutation').attr("href", newUrl);
                        $('#div_superannutationFile').hide();
                        $('#doc_superannutationFile').show();
                    }
                    if (result.guard.tfn_file != '' && result.guard.tfn_file != 'null' && result.guard
                        .tfn_file != null) {
                        var newUrl = `{{ config('custom.asset_url') }}${result.guard.tfn_file}`;
                        $('#link_tfn').attr("href", newUrl);
                        $('#div_tfnFile').hide();
                        $('#doc_tfnFile').show();
                    }
                }
            });
            $('#payroll-modal').modal('show');
        });
        $("#payroll-form").on('submit', function(e) {
            e.preventDefault();
            console.log(this.id)
            var data = $('#' + this.id).serialize();
            $.ajax({
                type: "POST",
                url: this.action,
                data: data,
                success: function(result) {
                    if (result.success) {
                        $('#payroll-modal').modal('hide');
                        Swal.fire({
                            text: result.message,
                            icon: "success",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-light"
                            }
                        })
                        window.location.href = "{{ url('/edit_guard') }}/{{ $guard_id }}";
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
        $('#pay-rates-modal-btn').on('click', function() {
            // load_guard_payrates();
            <?php if($guard_data['guard']->manual_custom_payrate == 1){
                ?>
                $('.payrates').css('display', 'none');
                $('.own_payrates_div').css('display','');
                $('#custom_payrate').prop('checked', true);
            <?php }elseif($payrates_id){?>
            reload_payrates({{ $payrates_id }});
            <?php };?>
            // get_guard_payrates();							
            $('#pay-rates-modal').modal('show');
        });

        function load_guard_payrates() {
            $.ajax({
                type: "POST",
                url: "{{ url('guard/get_guard_payrates') }}",
                data: {
                    guard_id: '{{ $guard_id }}',
                    _token: '{{ csrf_token() }}',
                    job_level: $('#job_level').val(),
                    state: $('#payrates_state').val()
                },
                success: function(result) {
                    if (result.success) {
                        $('input[name="flat_metro_week_day"]').val(result.payrates
                            .flat_metro_flat_metro_week_day)
                        $('input[name="flat_metro_weekend"]').val(result.payrates.flat_metro_weekend)
                        $('input[name="flat_metro_public_holiday"]').val(result.payrates
                            .flat_metro_public_holiday)
                        $('input[name="flat_regional_week_day"]').val(result.payrates.flat_regional_week_day)
                        $('input[name="flat_regional_weekend"]').val(result.payrates.flat_regional_weekend)
                        $('input[name="flat_regional_public_holiday"]').val(result.payrates
                            .flat_regional_public_holiday);
                        $('input[name="eba_metro_weekday_day"]').val(result.payrates.eba_metro_weekday_day);
                        $('input[name="eba_metro_weekday_afternoon"]').val(result.payrates
                            .eba_metro_weekday_afternoon);
                        $('input[name="eba_metro_weekday_night"]').val(result.payrates.eba_metro_weekday_night);
                        $('input[name="eba_metro_weekend"]').val(result.payrates.eba_metro_weekend);
                        $('input[name="eba_metro_public_holiday"]').val(result.payrates
                            .eba_metro_public_holiday);
                        $('input[name="eba_regional_weekday_day"]').val(result.payrates
                            .eba_regional_weekday_day);
                        $('input[name="eba_regional_weekday_afternoon"]').val(result.payrates
                            .eba_regional_weekday_afternoon);
                        $('input[name="eba_regional_weekday_night"]').val(result.payrates
                            .eba_regional_weekday_night);
                        $('input[name="eba_regional_weekend"]').val(result.payrates.eba_regional_weekend);
                        $('input[name="eba_regional_public_holiday"]').val(result.payrates
                            .eba_regional_public_holiday);
                    } else {
                        $('input[name="flat_metro_week_day"]').val(0)
                        $('input[name="flat_metro_weekend"]').val(0)
                        $('input[name="flat_metro_public_holiday"]').val(0)
                        $('input[name="flat_regional_week_day"]').val(0)
                        $('input[name="flat_regional_weekend"]').val(0)
                        $('input[name="flat_regional_public_holiday"]').val(0);
                        $('input[name="eba_metro_weekday_day"]').val(0);
                        $('input[name="eba_metro_weekday_afternoon"]').val(0);
                        $('input[name="eba_metro_weekday_night"]').val(0);
                        $('input[name="eba_metro_weekend"]').val(0);
                        $('input[name="eba_metro_public_holiday"]').val(0);
                        $('input[name="eba_regional_weekday_day"]').val(0);
                        $('input[name="eba_regional_weekday_afternoon"]').val(0);
                        $('input[name="eba_regional_weekday_night"]').val(0);
                        $('input[name="eba_regional_weekend"]').val(0);
                        $('input[name="eba_regional_public_holiday"]').val(0);
                    }
                }
            });
        }

        function load_payrates() {
            $.ajax({
                type: "POST",
                url: "{{ url('guard/get_payrates') }}",
                data: {
                    guard_id: '{{ $guard_id }}',
                    _token: '{{ csrf_token() }}',
                    job_level: $('#job_level').val(),
                    state: $('#payrates_state').val(),
                    payrol : $('#payrol').val()
                },
                success: function(result) {
                    if (result.success) {
                        // $('#payrates_div>select').append(`<option value="Victoria">Victoria</option>`);
                        var list = '';
                        var list_1 = '';
                        var selected_check = '';
                        index = 0;
                        $.each(result.payrates, function(id, data) {
                            // console.log(result.payrates[index]);
                            selected_check = '';
                            list += '<option  value="' + data.id + '">' + data.title + '</option>'
                            index++;
                        });
                        $('#payrates_id').html(list);
                        // alert("success");
                    } else {}
                }
            });
        }

        function reload_payrates(id) {
            $.ajax({
                type: "POST",
                url: "{{ url('guard/reload_payrates') }}",
                data: {
                    payrates_id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(result) {
                    if (result.success) {
                        var list = '<option>Select Payrates</option>';
                        var list_1 = '';
                        var selected_check = '';
                        $.each(result.payrates, function(ind, payrate) {
                            var selected = '';
                            if (payrate.id == result.guard_payrate_id) {
                                selected = 'selected';
                                $('#payrates_state').val(payrate.state);
                                $('#job_level').val(payrate.level);
                                $('#payrol').val(payrate.payrate_type)
                                $('.select2-selection__rendered').text(payrate.payrate_type)
                            }
                            list += '<option  value="' + payrate.id + '" ' + selected + '>' + payrate
                                .title + '</option>'
                        });
                        $('#payrates_id').html(list);

                        // document.getElementById("specific_customers_id").value = value;
                        // var text = e.options[e.selectedIndex].text;
                        // 						 var option = $('#payrates_state').children('option[value="'+ result.payrates.state +'"]');
                        // option.attr('selected', true);​​
                        // $("#payrates_state").val(result.payrates.state);
                        // $('select[name="job_level"]').val(result.payrates.level);
                        //    	$('select[name=""]').val(result.payrates.state);
                        // alert("success");
                    } else {}
                }
            });
        }
        // function get_guard_payrates(){
        // 	$.ajax({
        // 						        type: "POST",
        // 						        url: "{{ url('guard/get_guard_payrates') }}",
        // 						        data : {payrates_id:'{{ $payrates_id }}', _token : '{{ csrf_token() }}'},
        // 						        success: function(result){
        // 						        if (result.success) {
        // 						        	// console.log(result.payrates.title);
        // 						        																		 $('#payrates_id').val(result.payrates.title);
        // 						        																		 $('#payrates_state').val(result.payrates.title);
        // 						        																		 $('#job_level').val(result.payrates.title);
        // 						        }else{
        // 						        }
        // 						        }
        // 						        });
        // }
        $("#pay-rates-form").on('submit', function(e) {
            e.preventDefault();
            console.log(this.id)
            var data = $('#' + this.id).serialize();
            $.ajax({
                type: "POST",
                url: this.action,
                data: data,
                success: function(result) {
                    if (result.success) {
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
                        // window.location.href = "{{ url('/edit_guard') }}/{{ $guard_id }}";
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
        $("#work_form").on('submit', function(e) {
            e.preventDefault();
            console.log(this.id)
            var data = $('#' + this.id).serialize();
            $.ajax({
                type: "POST",
                url: this.action,
                data: data,
                success: function(result) {
                    if (result.success) {
                        $('#work-modal').modal('hide');
                        Swal.fire({
                            text: result.message,
                            icon: "success",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-light"
                            }
                        })
                        window.location.href = "{{ url('/edit_guard') }}/{{ $guard_id }}";
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
        $("#status_work").change(function() {
            if (this.checked) {

                $(`#limitation`).show();
                $(`#limitation`).prop("disabled", false);
                $(`#fortnightly_working_holiday_letter`).show();
            } else {
                $(`#limitation`).prop("disabled", true);
                $(`#fortnightly_working_holiday_letter`).hide();
            }
        });

        function toggle_uniform(e, size, quantity) {
            console.log(size, quantity)
            if (e.checked) {
                $('#' + size).show();
                $(`#${quantity}`).show();
            } else {
                $(`#${size}`).hide();
                $(`#${quantity}`).hide();
            }
        };
        $('#work_button').on('click', function() {
            $.ajax({
                type: "POST",
                url: "{{ url('guard/guard_work_limitation') }}",
                data: {
                    guard_id: '{{ $guard_id }}',
                    _token: '{{ csrf_token() }}'
                },
                success: function(result) {
                    // console.log(result.guard);
                    // console.log(result.guard.guard_availability);
                    var check_admin = "{{ session()->get('userType') }}";
                    if (result.guard.fortnightly_working_holiday_letter != null && result.guard
                        .fortnightly_working_holiday_letter != '') {
                        $(`#fortnightly_working_holiday_letter`).show();
                        $('#preview_fortnightly_working_holiday_letter').show();
                        var newUrl =
                            `{{ config('custom.asset_url') }}${result.guard.fortnightly_working_holiday_letter}`;
                        $('#preview_fortnightly_working_holiday_letter').attr("href", newUrl);
                    }
                    if (result.guard.authorized_by != null && result.guard.authorized_by != '') {
                        $('#authorized_by').text(result.guard.authorized_by)
                    }
                    if (result.guard.work_limitation_status == null || result.guard
                        .work_limitation_status == "inactive" || result.guard.work_limitation_status ==
                        '') {
                        $(`#status_work`).prop("checked", false);
                        $(`#limitation`).hide();
                        $(`#fortnightly_working_holiday_letter`).hide();
                        $('#preview_fortnightly_working_holiday_letter').hide();
                        // $('#guard_avability-modal').modal('show');
                    } else {
                        $(`#status_work`).prop("checked", true);
                        $(`#limitation`).show();
                        $(`#fortnightly_working_holiday_letter`).show();
                        $(`#limitation`).val(result.guard.fortnightly_working_hours);
                    }

                    if (result.guard.residential_status == "student") {
                        $(`#status_work`).prop("checked", true);
                        $(`#limitation`).show();
                        // if(result.guard.fortnightly_working_hours=='' || result.guard.fortnightly_working_hours==null ){
                        // $(`#limitation`).val(20);
                        // }else{

                        // }
                        // $('#status_work').hide();
                        // $('#limitation').prop('readonly', true);
                        // $('#preview_fortnightly_working_holiday_letter').hide();
                        // $('#fortnightly_working_holiday_letter').hide();
                    }


                }
            });
            $('#work-modal').modal('show');
        });




        // laevel


        $("#leave_management-form").on('submit', function(e) {
            e.preventDefault();
            console.log(this.id)
            var data = $('#' + this.id).serialize();
            $.ajax({
                type: "POST",
                url: this.action,
                data: data,
                success: function(result) {
                    if (result.success) {
                        $('#leave_management-modal').modal('hide');
                        Swal.fire({
                            text: result.message,
                            icon: "success",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-light"
                            }
                        })
                        window.location.href = "{{ url('/edit_guard') }}/{{ $guard_id }}";
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

        $('#leave_management_button').on('click', function() {
            $.ajax({
                type: "POST",
                url: "{{ url('guard/guard_leave_management') }}",
                data: {
                    guard_id: '{{ $guard_id }}',
                    _token: '{{ csrf_token() }}'
                },
                success: function(result) {
                    var check_admin = "{{ session()->get('userType') }}";
                    $(`#annual_leave_hours`).val(result.guard.annual_leave_hours);
                    $(`#sick_leave_hours`).val(result.guard.sick_leave_hours);
                }
            });
            $('#leave_management-modal').modal('show');
        });
        $('#profile_tracker_button').on('click', function() {
            $.ajax({
                type: "POST",
                url: "{{ url('guard/profile_tracker') }}",
                data: {
                    guard_id: '{{ $guard_id }}',
                    _token: '{{ csrf_token() }}'
                },
                success: function(result) {
                    // console.log(result);
                    var data = '';
                    if (result.success) {

                        $.each(result.data, function(mi, md) {
                            data += '<tr><td>' + md.action + '</td><td>' + md.datetime +
                                '</td></tr>';
                        });
                    }
                    $('#profile_tracker_data').html(data);
                }
            });
            $('#profile_tracker-modal').modal('show');
        });



        $("#update_guard_avability_weak_form").on('submit', function(e) {
            e.preventDefault();
            console.log(this.id)
            var data = $('#' + this.id).serialize();
            $.ajax({
                type: "POST",
                url: this.action,
                data: data,
                success: function(result) {
                    if (result.success) {
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
                        window.location.href = "{{ url('/edit_guard') }}/{{ $guard_id }}";
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
        $('#guard_avability_button').on('click', function() {
            $.ajax({
                type: "POST",
                url: "{{ url('guard/guard_avability_weak') }}",
                data: {
                    guard_id: '{{ $guard_id }}',
                    _token: '{{ csrf_token() }}'
                },
                success: function(result) {
                    // console.log(result.guard);
                    // console.log(result.guard.guard_availability);
                    var check_admin = "{{ session()->get('userType') }}";
                    if (result.guard.guard_availability == null || result.guard.guard_availability ==
                        'null' || result.guard.guard_availability == '') {
                        // $('#guard_avability-modal').modal('show');
                    } else {
                        var response = JSON.parse(result.guard.guard_availability);
                        console.log(response[0]);
                        $.each(response[0], function(key, value) {
                            if (value.length > 1) {
                                if (value[0] != 0) {
                                    $(`#${key}`).prop("checked", true);
                                    $(`#${key}_shift`).val(value[0]);
                                    if (value[0] == 'other') {
                                        $('#' + key + '_other_div').css('display', '')
                                        $('#' + key + '_from').val(value[1])
                                        $('#' + key + '_to').val(value[2])
                                    } else {
                                        $('#' + key + '_other_div').css('display', 'none')
                                    }
                                    // console.log(`#${key}`);
                                } else {
                                    $(`#${key}`).prop("checked", false);
                                }
                            } else {
                                if (value != 0) {
                                    $(`#${key}`).prop("checked", true);
                                    $(`#${key}_shift`).val(value);
                                    if (value == 'other') {
                                        $('#' + key + '_other_div').css('display', '')
                                        // $('#'+key+'_other_div').val(value[1])
                                    } else {
                                        $('#' + key + '_other_div').css('display', 'none')
                                    }
                                    // console.log(`#${key}`);
                                } else {
                                    $(`#${key}`).prop("checked", false);
                                }
                            }
                            // if(check_admin=="admin" && value==0){
                            // 	// console.log(`${key}_shift`);
                            // $(`#${key}_shift`).hide();
                            // }
                            // console.log(key + ": " + value);
                        });
                        // $('#guard-site-trained-container').html('');
                    }
                }
            });
            $('#guard_avability-modal').modal('show');
        });
        // unifrom
        $("#guard_uniform-form").on('submit', function(e) {
            e.preventDefault();
            console.log(this.id)
            var data = $('#' + this.id).serialize();
            $.ajax({
                type: "POST",
                url: this.action,
                data: data,
                success: function(result) {
                    if (result.success) {
                        $('#guard_unifrom-modal').modal('hide');
                        Swal.fire({
                            text: result.message,
                            icon: "success",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-light"
                            }
                        })
                        window.location.href = "{{ url('/edit_guard') }}/{{ $guard_id }}";
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
        $('#guard_uniform_button').on('click', function() {
            $.ajax({
                type: "POST",
                url: "{{ url('guard/get_guard_uniform') }}",
                data: {
                    guard_id: '{{ $guard_id }}',
                    _token: '{{ csrf_token() }}'
                },
                success: function(result) {
                    if (result.guard.gender == "male") {
                        $('#tie_row').show()
                        $('#ascot_row').hide()
                    } else {
                        $('#tie_row').hide()
                        $('#ascot_row').show()
                    }
                    if (result.guard.uniform_type != null && result.guard.uniform_type != []) {
                        var response = JSON.parse(result.guard.uniform_type);
                        console.log(response);
                        // console.log(response.length());
                        $.each(response, function(id, data) {
                            $.each(data, function(key, value) {
                                $.each(value, function(key1, value1) {
                                    if (key1.indexOf('_status') > -1) {
                                        $(`#${key1}`).prop("checked", true);
                                    } else {
                                        $(`#${key1}`).val(value1);
                                        $(`#${key1}`).show();
                                    }
                                });
                            });
                        });
                    }
                }
            });
            $('#guard_uniform-modal').modal('show');
        });
        $('#sites_trained-modal-btn').on('click', function() {
            $.ajax({
                type: "POST",
                url: "{{ url('guard/get_guard_site_trained') }}",
                data: {
                    guard_id: '{{ $guard_id }}',
                    _token: '{{ csrf_token() }}'
                },
                success: function(result) {
                    console.log(result)
                    if (result.success == true) {
                        $('#guard-site-trained-container').html('');
                        $('#guard-site-trained-container').append(result.html);
                    } else {
                        $('#guard-site-trained-container').html('');
                    }
                }
            });
            $('#sites_trained-modal').modal('show');
        });
        $("#sites_trained-form").on('submit', function(e) {
            e.preventDefault();
            console.log(this.id)
            var data = $('#' + this.id).serialize();
            $.ajax({
                type: "POST",
                url: this.action,
                data: data,
                success: function(result) {
                    if (result.success) {
                        $('#sites_trained-modal').modal('hide');
                        Swal.fire({
                            text: result.message,
                            icon: "success",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-light"
                            }
                        })
                        window.location.href = "{{ url('/edit_guard') }}/{{ $guard_id }}";
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
        $(document).on('change', '._ac-customer-change', function(e) {
            var _this = $(this);
            var index = _this.attr('data-index');
            var type = _this.attr('data-type');
            getCustomerJobs(_this.val(), index, 'site-trained', '');
        });

        function getCustomerJobs(customerId, index, type, siteId) {
            $.ajax({
                url: "{{ url('job/get_customers_jobs') }}",
                data: {
                    customerId: customerId,
                    _token: '{{ csrf_token() }}'
                },
                type: "POST",
                success: function(response) {
                    console.log(response)
                    // response = JSON.parse(response);
                    options = '<option value="">Select Site</option>';
                    $.each(response, function(id, data) {
                        var site_name = data.address;
                        if (data.site_name != '') {
                            site_name = data.site_name + ' (' + data.site_description + ')';
                        }
                        selected_check = (data.jobId === siteId) ? 'selected' : '';
                        options += '<option ' + selected_check + ' value="' + data.jobId + '">' +
                            site_name + '</option>';
                    });
                    if (type === 'site-block') {
                        $('#site_blocked_site-option-' + index).html(options);
                    } else if (type === 'site-trained') {
                        $('#site_trained_site-option-' + index).html(options);
                    } else {
                        $('#site_blocked_site-option-' + index).html(options);
                        $('#site_trained_site-option-' + index).html(options);
                    }
                }
            });
        }
        $('#sites_blocked-modal-btn').on('click', function() {
            $.ajax({
                type: "POST",
                url: "{{ url('guard/get_guard_site_blocked') }}",
                data: {
                    guard_id: '{{ $guard_id }}',
                    _token: '{{ csrf_token() }}'
                },
                success: function(result) {
                    if (result.success == true) {
                        $('#guard-site-blocked-container').html('');
                        $('#guard-site-blocked-container').append(result.html);
                    } else {
                        $('#guard-site-blocked-container').html('');
                    }
                }
            });
            $('#sites_blocked-modal').modal('show');
        });
        $("#sites_blocked-form").on('submit', function(e) {
            e.preventDefault();
            console.log(this.id)
            var data = $('#' + this.id).serialize();
            $.ajax({
                type: "POST",
                url: this.action,
                data: data,
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
                        window.location.href = "{{ url('/edit_guard') }}/{{ $guard_id }}";
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

        function get_personal_data() {

            $.ajax({
                type: "POST",
                url: "{{ url('guard/get_personal_data') }}",
                data: {
                    guard_id: '{{ $guard_id }}',
                    _token: '{{ csrf_token() }}'
                },
                success: function(result) {
                    if (result.success == true) {
                        var cid = [];
                        // $('div.multiselect-dropdown').remove();
                        // MultiselectDropdown(window.MultiselectDropdownOptions);
                        // console.log(result.guard.guard_working_type)
                        var text = '';
                        $('._ac-customer-change>ul>li').remove();
                        $('input[name="first_name"]').val(result.guard.first_name);
                        $('input[name="middle_name"]').val(result.guard.middle_name);
                        $('input[name="last_name"]').val(result.guard.last_name);
                        $('input[name="email"]').val(result.guard.email);
                        $('input[name="phone"]').val(result.guard.phone);
                        $('input[name="suburb"]').val(result.guard.suburb);
                        $('input[name="address"]').val(result.guard.address);
                        $('input[name="city"]').val(result.guard.city);
                        $('select[name="guard_level"]').val(result.guard.guard_level);
                        $('select[name="state"]').val(result.guard.state);
                        $('select[name="gender"]').val(result.guard.gender);
                        if (result.guard.gender == 'male') {
                        $('.select2-selection .select2-selection__rendered').text('Male');
                        }else{
                        $('.select2-selection .select2-selection__rendered').text('Female');
                        }
                        $('select[name="guard_type"]').val(result.guard.guard_type);
                        $('input[name="coordinates"]').val(result.guard.coordinates);
                        $('input[name="coordinate_display"]').val(result.guard.coordinates);
                        $('input[name="postalCode"]').val(result.guard.postal_code);
                        $('input[name="emergencyContactName"]').val(result.guard.emergency_contact_name);
                        $('input[name="emergencyContactPhone"]').val(result.guard.emergency_contact_phone);
                        $('input[name="dob"]').val(result.guard.dob);
                        $('input[name="coordinates"]').val(result.guard.coordinates);
                        $('select[name="specific_customers_id[]"]').val(result.guard.specific_customers_id);
                        $('select[name="guard_working_type"]').val(result.guard.guard_working_type);

                        $('#select2-administrative_area_level_1-container').text(result.guard.state);
                        $('select[name="position"]').val(result.guard.position);

                        if (result.guard.guard_type == 'Direct' || result.guard.guard_type == 'direct' || result
                            .guard.guard_type == null) {
                            $('#contractor_container').css('display', 'none')
                            $('select[name="guard_type"]').val('Direct');
                        } else {

                            $('#contractor_container').css('display', '')
                            $('#guard_type').val('Contractor');
                            $('#contractor_id').val(result.guard.contractor_id);
                        }
                        // $("#specific_customers_id option:selected").text();
                        cid = result.guard.specific_customers_id;
                        if (cid != null && cid != '') {
                            cid = result.guard.specific_customers_id;
                        } else {
                            cid = [];
                        }
                        // console.log(result.guard.specific_customers_id);
                        // // $('#specific_customers_id').val(cid);
                        // $.each(cid, function(index, value) {
                        // 	// console.log('iam in');
                        // 	var e = document.getElementById("specific_customers_id");
                        // 	$('#specific_customers_id').val(value);
                        // 	// document.getElementById("specific_customers_id").value = value;
                        // 	text = e.options[e.selectedIndex].text;
                        // 	console.log(text);
                        // 	// document.getElementById("specific_customers_id").options[value].selected = true;
                        // 	// $('#specific_customers_id option[value=value]').attr('selected','selected');
                        // 	$('._ac-customer-change>ul').append(`<li class="select2-selection__choice" title="" data-select2-id="select2-data-65-3jgc"><button type="button" class="select2-selection__choice__remove" tabindex="-1" title="Remove item" aria-label="Remove item" aria-describedby="select2-specific_customers_id-container-choice-b6oa-2"><span aria-hidden="true">×</span></button><span class="select2-selection__choice__display" id="select2-specific_customers_id-container-choice-b6oa-2">${text}</span></li>`);
                        // });
                        // $('#specific_customers_id').val(cid);
                        if (result.guard.profile_image != '') {
                            document.getElementById('preview_img').style.backgroundImage =
                                `url({{ config('custom.asset_url') }}${result.guard.profile_image})`;
                            $('#profileImage').removeAttr('required', '""');

                        } else {
                            document.getElementById('preview_img').style.backgroundImage =
                                `url({{ asset('') }}media/avatars/150-13.jpg)`;
                            $('#profileImage').attr('required', '""');
                        }
                        var guard_working_type = result.guard.guard_working_type;
                        result.guard.guard_working_type = guard_working_type.toUpperCase();
                        $('#select2-guard_working_type-container').text(result.guard.guard_working_type);
                        result.guard.position = result.guard.position.replace("_", "-");
                        result.guard.position = result.guard.position.toUpperCase();
                        $('#select2-position-container').text(result.guard.position);
                    } else {}
                }
            });
            // setTimeout(function(){$('#personal-modal').modal('show');}, 100);
            // setTimeout(function(){$('#personal-modal').modal('hide');}, 1000);
            // setTimeout(function(){$('#personal-modal').modal('show');}, 2000);
        }

        $('#personal-modal-btn').on('click', function() {

            get_personal_data();
            setTimeout(function() {
                $('#personal-modal').modal('show');
            }, 1000);
            // 
            // $('#personal-modal').modal('show');
            $('div.multiselect-dropdown').remove();
            MultiselectDropdown(window.MultiselectDropdownOptions);

        });
        $('#guard_type').on('change', function() {
            if ($(this).val() == 'Direct' || $(this).val() == 'direct' || $(this).val() == '') {
                $('#contractor_container').css('display', 'none');
                // $('#contractor_id').val('');
                // $('#contractor_id_quick').val('');
            } else {
                $('#contractor_container').css('display', '');
                // getcontractors();
            }
        });
        $('#residentialStatus').on('change', function() {
            var selected = $(this).val();
            if (selected == 'student' || selected == 'subclass-485') {
                $('#passport-div').css('display', '');
                $('#visa-div').css('display', '');
                $('#security-div').css('display', '');
                $('#driver-div').css('display', '');
                $('#subselect-div').css('display', 'none');
                $('#medicare-div').css('display', 'none');
                $('#citizenship-div').css('display', 'none');
                $('#birthcertificate-div').css('display', 'none');
                $('#firearm-div').css('display', 'none');
                $('#subselect').removeAttr('required');
                $('#visaNumber').attr('required', '""');
                $('#passportNumber').attr('required', '""');

            } else if (selected == 'permanent-resident') {
                $('#driver-div').css('display', '');
                $('#security-div').css('display', '');
                $('#citizenship-div').css('display', '');
                $('#subselect-div').css('display', '');
                $('#passport-div').css('display', 'none');
                $('#visa-div').css('display', 'none');
                $('#subselect').attr('required', '""');
                $('#visaNumber').removeAttr('required');
                $('#passportNumber').removeAttr('required');
            } else if (selected == 'citizen') {
                $('#driver-div').css('display', '');
                $('#security-div').css('display', '');
                $('#citizenship-div').css('display', '');
                $('#subselect-div').css('display', '');
                $('#passport-div').css('display', 'none');
                $('#visa-div').css('display', 'none');
                $('#subselect').attr('required', '""');
                $('#visaNumber').removeAttr('required');
                $('#passportNumber').removeAttr('required');
            } else {
                $('#security-div').css('display', '');
                $('#driver-div').css('display', '');
                $('#subselect').attr('required', '""');
                $('#visaNumber').removeAttr('required');
                $('#passportNumber').removeAttr('required');
            }
        })
        $('#subselect').on('change', function() {
            //  alert();
            var selected = $(this).val();
            console.log("subselect " + selected);
            if (selected == 'medicare') {
                $('#medicare-div').css('display', '');
            } else {
                $('#medicare-div').css('display', 'none');
            }
            if (selected == 'birthcertificate') {
                $('#birthcertificate-div').css('display', '');
            } else {
                $('#birthcertificate-div').css('display', 'none');
            }
            if (selected == 'citizenship') {
                console.log("enter cityytytyty");
                $('#citizenship-div').show();
                $('#citizenship-div').css('display', '');
            } else {
                $('#citizenship-div').css('display', 'none');
            }
            if (selected == 'subpass') {
                $('#passport-div').css('display', '');
            } else {
                $('#passport-div').css('display', 'none');
            }
        })
        var indexArray =[];
        $(document).on('click', '._ac-add-more-documents-btn', function(e) {
        
            // indexArray =$('._index_documents');
            getDocuments($('._index_documents').length);
        });
        $(document).on('click', '.removedivfromdom', function(e) {
        // console.log($('._index_documents').index('._index_documents'));
        e.preventDefault();
        $(this).parent().parent().parent().remove();
    });


        function getDocuments(index) {
            $.ajax({
                url: "{{ url('guard/get_guard_document_form') }}",
                data: {
                    index: index,
                    isGuard: true,
                    _token: '{{ csrf_token() }}'
                },
                type: "POST",
                success: function(result) {
                    // $("#div1").html(result);
                    $('#guard-document-container').append(result);
                    // if(result.documnets.securityLicenseNumber != '')
                    // {
                    // 	console.log(result.documnets.securityLicenseNumber);
                    // 	$('#div_securityLicenseFile').hide();
                    // 	$('#doc_securityLicenseFile').show();
                    // }
                }
            });
        }

        function avatar_remove() {
            document.getElementById('preview_img').style.backgroundImage = '';
            document.getElementById('file_image').value = '';
        }
        $("#password_form").on('submit', function(e) {
            e.preventDefault();
            console.log(this.id)
            var data = $('#' + this.id).serialize();
            $.ajax({
                type: "POST",
                url: this.action,
                data: data,
                success: function(result) {
                    if (result.success) {
                        Swal.fire({
                            text: "Password changed successfully",
                            icon: "success",
                            buttonsStyling: !1,
                            confirmButtonText: "OK",
                            customClass: {
                                confirmButton: "btn btn-light"
                            }
                        })
                        window.location.href = "{{ url('/edit_guard') }}/{{ $guard_id }}";
                    } else {
                        Swal.fire({
                            text: "Password do not match ",
                            icon: "error",
                            buttonsStyling: !1,
                            confirmButtonText: "Try again!",
                            customClass: {
                                confirmButton: "btn btn-light"
                            }
                        })
                    }
                }
            })
        });
        $('#documentsOnlineVerification2').on('click', function() {
            var license_number = $('#securityLicenseNumber').val();
            var guard_id = $('#guard_id').val();
            if (license_number != '') {
                call_spinner();
                $.ajax({
                    url: "{{ url('guard/documentsOnlineVerification') }}",
                    data: {
                        license_number: license_number,
                        guard_id: guard_id,
                        _token: '{{ csrf_token() }}'
                    },
                    type: "POST",
                    success: function(result) {
                        // console.log(result);
                        close_spinner();
                        if (result.success) {
                            $('#securityLicenseExpiration').val(result.expiry);
                            Swal.fire({
                                text: result.message,
                                icon: "success",
                                buttonsStyling: !1,
                                confirmButtonText: "OK",
                                customClass: {
                                    confirmButton: "btn btn-light"
                                }
                            })
                        } else {
                            Swal.fire({
                                text: result.message,
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "OK",
                                customClass: {
                                    confirmButton: "btn btn-light"
                                }
                            })
                        }
                    }
                });
            } else {
                Swal.fire({
                    text: "Please enter valid security license number!",
                    icon: "error",
                    buttonsStyling: !1,
                    confirmButtonText: "Try again!",
                    customClass: {
                        confirmButton: "btn btn-light"
                    }
                })
            }
        });
        $('#documentsOnlineVerification').on('click', function() {
            var license_number = $('#securityLicenseNumber').val();
            var guard_id = $('#guard_id').val();
            if (license_number != '') {
                call_spinner();
                $.ajax({
                    url: "{{ url('guard/documentsOnlineVerification') }}",
                    data: {
                        license_number: license_number,
                        guard_id: guard_id,
                        _token: '{{ csrf_token() }}'
                    },
                    type: "POST",
                    success: function(result) {
                        // console.log(result);
                        close_spinner();

                        if (result.success) {
                            $('#securityLicenseExpiration').val(result.expiry);
                            Swal.fire({
                                text: result.message,
                                icon: "success",
                                buttonsStyling: !1,
                                confirmButtonText: "OK",
                                customClass: {
                                    confirmButton: "btn btn-light"
                                }
                            })
                        } else {
                            Swal.fire({
                                text: result.message,
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "OK",
                                customClass: {
                                    confirmButton: "btn btn-light"
                                }
                            })
                        }
                    }
                });
            } else {
                Swal.fire({
                    text: "Please enter valid security license number!",
                    icon: "error",
                    buttonsStyling: !1,
                    confirmButtonText: "Try again!",
                    customClass: {
                        confirmButton: "btn btn-light"
                    }
                })
            }
        });

        function getcontractors() {
            $.ajax({
                type: 'GET',
                url: "{{ url('getcontractors') }}",
                data: {
                    _token: '<?php echo csrf_token(); ?>'
                },
                success: function(result) {
                    html = '<option>Select</option>';
                    $.each(result, function(id, data) {
                        html += `<option value="${data.id}">${data.name}</option>`
                    });
                    $('#contractor_id').html(html);
                }
            });
        }

        function deleteOtherFile(documentId) {
            Swal.fire({
                text: "Do you confirm delete this documnet?",
                icon: "success",
                showCancelButton: !0,
                buttonsStyling: !1,
                confirmButtonText: "Yes",
                cancelButtonText: "No, cancel",
                customClass: {
                    confirmButton: "btn fw-bold btn-success",
                    cancelButton: "btn fw-bold btn-active-light-primary"
                }
            }).then((function(e) {
                if (e.value == true) {

                    $.ajax({
                        url: base_url + "/guard/deleteOtherFile",
                        type: "post",
                        dataType: "json",
                        data: {
                            id: documentId,
                            _token: token
                        },
                        success: function(result) {
                            if (result.status == true) {
                                Swal.fire({
                                    text: "Documnet delete successfully.",
                                    icon: "success",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary"
                                    }
                                })
                                $('#other-file-' + documentId).remove();

                            } else {
                                Swal.fire({
                                    text: "Documnet not deleted!",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary"
                                    }
                                });

                            }
                        }
                    });
                } else {
                    Swal.fire({
                        text: "Documnet not deleted!",
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary"
                        }
                    });
                }


            }));
        }

        function showHideother(e, day) {
            if (e.value == 'other') {
                $('#' + day + '_other_div').css('display', '')
            } else {
                $('#' + day + '_other_div').css('display', 'none')
            }
        }

        function showDivs(div, div_id) {
            if ($(div).prop('checked') == true) {
                $('#' + div_id).css('display', '');
            } else {
                $('#' + div_id).css('display', 'none');
            }
        }


        function delGuardFile(type) {
            $.ajax({
                type: "POST",
                url: "{{ url('guard/del_guard_documents') }}",
                data: {
                    type:type,
                    guard_id: '{{ $guard_id }}',
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if(response.success){
                        Swal.fire({
                        text: response.message,
                        icon: "success",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary"
                        }
                    });
                    }

                }
            });
        }
        $('#custom_payrate').on('change', function(){
        if (document.getElementById('custom_payrate').checked == true)
        {
            $('.payrates').css('display', 'none');
            $('.own_payrates_div').css('display','');
        }else{
            $('.payrates').css('display', '');
            $('.own_payrates_div').css('display','none');
        }
    });

    $("input[type='radio'][name='pay_by']").on('change', function(){
        if($("input[type='radio'][name='pay_by']:checked").val() == 'eba')
        {
            $('.award-payrates').css('display','none');
            $('.eba-rates-section').css('display','');
        }else{
            $('.award-payrates').css('display','');
            $('.eba-rates-section').css('display','none');
        }
    });
    </script> @stop
