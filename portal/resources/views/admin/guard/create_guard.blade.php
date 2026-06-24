@extends('layout.app')
@extends('layout.sidebar')
@extends('layout.footer')

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

    <style>
        .hidden {
            display: none;
        }
    </style>
    <!--end::Global Stylesheets Bundle-->
@stop
<!--end::Head-->
<!--begin::Body-->
@section('content')
<?php

$item = session()->get('guards_navigation_bar');
// @dd($item);
if (!empty($item)) {
    foreach (session()->get('guards_navigation_bar') as $item1) {
        $item = $item1;
    }
} else {
    $item['add_guards'] = 1;
    $item['password'] = 1;
    $item['email'] = 1;
    $item['profile_image'] = 1;
    $item['coordinates'] = 1;
    $item['emergency_contact_name'] = 1;
    $item['emergency_contact_phone'] = 1;
    $item['guard_type'] = 1;
    $item['address'] = 1;
    $item['suburb'] = 1;
    $item['city'] = 1;
    $item['state'] = 1;
    $item['postal_code'] = 1;
    $item['dob'] = 1;
    $item['gender'] = 1;
    $item['select_customer'] = 1;
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
                        <h1 class="text-dark fw-bolder my-0 fs-2">Create a {{ config('custom.guard') }}</h1>
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
                        <img alt="Logo" src="{{ asset('') }}media/logos/logo-demo-3.svg" class="h-30px" />
                    </a>
                    <!--end::Logo-->
                </div>


                <!--end::Wrapper-->
                @include('layout.toolbar')
                @yield('toolbar')
                <div style="float:right">
                    <!-- 								<button type="button" class="btn btn-white btn-active-light-primary my-1" data-bs-toggle="modal" data-bs-target="#kt_modal_update_role">Add a Role</button>
                -->
                </div>
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
                                <div class="fw-bolder text-gray-600 mb-5">Create new {{ config('custom.guard') }} personal
                                </div>
                                <!--end::Users-->
                                <!--begin::Permissions-->
                                <div class="d-flex flex-column text-gray-600">
                                    <div class="d-flex align-items-center py-2">

                                    </div>
                                    <!--end::Permissions-->
                                </div>
                                <!--end::Card body-->
                                <!--begin::Card footer-->
                                <div class="card-footer flex-wrap pt-0">
                                    <button style="margin-left:25px" type="button"
                                        class="btn btn-white btn-active-light-primary my-1" data-bs-toggle="modal"
                                        data-bs-target="#personal-modal">Create New {{ config('custom.guard') }}</button>
                                    <button type="button" class="btn btn-white btn-default my-1" data-bs-toggle="modal"
                                        data-bs-target="#quick-modal">OR<br>Send Quick Onboarding
                                        {{ config('custom.guard') }}</button>


                                </div>
                                <!--end::Card footer-->
                            </div>
                            <!--end::Card-->

                        </div>
                        <!--end::Col-->





                        <!--begin::Add new card-->
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
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <label for="name" class="col-form-label">First Name</label>
                                                <input type="text" class="form-control form-control-md"
                                                    id="first_name" name="first_name" required>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="name" class="col-form-label">Middle Name</label>
                                                <input type="text" class="form-control form-control-md"
                                                    id="middle_name" name="middle_name">
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="name" class="col-form-label">Last Name</label>
                                                <input type="text" class="form-control form-control-md" value=""
                                                    id="last_name" name="last_name" required>
                                            </div>
                                        </div>
                                        @if (isset($item->profile_image) && $item->profile_image==1)
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="recipient-name" class="col-form-label">Profile image </label>
                                                <input accept="image/png, image/gif, image/jpeg" type="file"
                                                    onchange="upload_file('profileImage', 'profileImageUploaded')"
                                                    type="file" class="form-control form-control-md" id="profileImage"
                                                    name="profileImage">
                                                <input type="hidden" name="profileImageUploaded"
                                                    id="profileImageUploaded">
                                            </div>
                                        </div>
                                        @endif
                                        
                                        <div class="row">
                                            @if (isset($item->email) && $item->email==1)
                                            <div class="col-md-6 form-group">
                                                <label for="recipient-name" class="col-form-label">Email</label>
                                                <input type="email" class="form-control form-control-md" name="email"
                                                    required>
                                            </div>
                                            @endif
                                            @if (isset($item->password) && $item->password==1)
                                            <div class="col-md-6 form-group">
                                                <label for="recipient-name" class="col-form-label">Password</label>
                                                <input type="text" class="form-control form-control-md"
                                                    name="password">
                                            </div>
                                            @endif
                                        </div>
                                        <div class="row">
                                            @if (isset($item->guard_type) && $item->guard_type==1)
                                            <div class="col-md-6 form-group">
                                                <label for="recipient-name"
                                                    class="col-form-label">{{ config('custom.guard') }} Type</label>

                                                <select class="form-select form-select-lg form-select-solid"
                                                    data-control="select2" data-placeholder="Select..."
                                                    data-allow-clear="true" data-hide-search="true" id="guard_type"
                                                    name="guard_type">
                                                    <option value="Direct">Direct</option>
                                                    <option value="Contractor">Contractor</option>
                                                </select>
                                            </div>
                                            @else
                                            <div class="col-md-6 form-group" style="display: none">
                                                <label for="recipient-name"
                                                    class="col-form-label">{{ config('custom.guard') }} Type</label>

                                                <select class="form-select form-select-lg form-select-solid"
                                                    data-control="select2" data-placeholder="Select..."
                                                    data-allow-clear="true" data-hide-search="true" id="guard_type"
                                                    name="guard_type">
                                                    <option value="Direct">Direct</option>
                                                </select>
                                            </div>
                                            @endif

                                            <div class="col-md-6 form-group" id="contractor_container"
                                                style="display: none">
                                                <label for="recipient-name" class="col-form-label">Contractors</label>
                                                <select class="form-select form-select-lg form-select-solid"
                                                    data-control="select2" data-placeholder="Select..."
                                                    data-allow-clear="true" id="contractor_id" name="contractor_id">
                                                    <option value="0"> Select Contractor</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <label for="recipient-name"
                                                    class="col-form-label">{{ config('custom.guard') }} Type</label>

                                                <select class="form-select form-select-lg form-select-solid"
                                                    data-control="select2" data-placeholder="Select..."
                                                    data-allow-clear="true" data-hide-search="true"
                                                    id="guard_working_type" name="guard_working_type">
                                                    <option value="Guard">{{ config('custom.guard') }}</option>
                                                    <option value="covid_marshal">Covid Marshal</option>
                                                    <option value="both">Both</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="recipient-name" class="col-form-label">Phone</label>
                                                <input type="text" id="mobile-num"
                                                    class="form-control form-control-md" placeholder="phone "
                                                    name="phone">
													<div class="label mt-3">
														<div class="label-1">
															<span id="mobile-valid" class="hidden mob">
																<i class="fa fa-check pwd-valid mx-2"></i>Valid Mobile No
															</span>
															<span id="folio-invalid" class="hidden mob-helpers">
																<i class="fa fa-times mobile-invalid mx-2"></i>Please put 10  digit mobile number
															</span>
														</div>
													</div>
                                            </div>
                                            @if (isset($item->address) && $item->address ==1)
                                            <div class="col-md-6 form-group">
                                                <label for="recipient-name" class="col-form-label">Address</label>
                                                <input type="text" class="form-control form-control-md"
                                                    placeholder="address " name="address" id="googleaddressSearch">
                                            </div>
                                            @endif
                                        </div>

                                        <div class="row">
                                            @if (isset($item->suburb) && $item->suburb ==1)
                                            <div class="col-md-4 form-group">
                                                <label for="recipient-name" class="col-form-label">Suburb</label>
                                                <input type="text" class="form-control form-control-md" name="suburb"
                                                    id="locality">
                                            </div>
                                            @endif
                                            @if (isset($item->city) && $item->city ==1)
                                            <div class="col-md-4 form-group">
                                                <label for="recipient-name" class="col-form-label">City</label>
                                                <input type="text" class="form-control form-control-md" name="city"
                                                    id="administrative_area_level_2">
                                            </div>
                                            @endif
                                            @if (isset($item->state) && $item->state ==1)
                                            <div class="col-md-4 form-group">
                                                <label for="recipient-name" class="col-form-label">State</label>

                                                <select class="form-select form-select-lg form-select-solid"
                                                    data-control="" data-placeholder="Select..." data-allow-clear="true"
                                                    data-hide-search="true" name="state"
                                                    id="administrative_area_level_1">
                                                    <option></option>
                                                    <option value="Victoria">Victoria</option>
                                                    <option value="New South Wales">NSW</option>
                                                    <option value="Queensland">Queensland</option>
                                                    <option value="Tasmania">Tasmania</option>
                                                    <option value="Western Australia">Western Australia</option>
                                                    <option value="South Australia">South Australia</option>
                                                    <option value="ACT">ACT</option>
                                                </select>
                                            </div>
                                            @endif
                                        </div>
                                        @if (isset($item->coordinates) && $item->coordinates ==1)
                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <label for="recipient-name" class="col-form-label">Coordinates</label>
                                                <input type="text" class="form-control form-control-md"
                                                    onfocus="this.value=''"
                                                    value="Make sure to select address from Google Suggestion to fill Coordinates field"
                                                    id="coordinate_display" disabled name="coordinate_display"
                                                    style="color: red">
                                                <input type="hidden" class="form-control form-control-md"
                                                    id="coordinates" name="coordinates">
                                            </div>
                                        </div>
                                        @endif
                                       
                                        <div class="row">
                                            @if (isset($item->postal_code) && $item->postal_code ==1)
                                            <div class="col-md-4 form-group">
                                                <label for="recipient-name" class="col-form-label">Postal code</label>
                                                <input type="text" class="form-control form-control-md"
                                                    id="postal_code" name="postalCode">
                                            </div>
                                            @endif
                                            @if (isset($item->dob) && $item->dob ==1)
                                            <div class="col-md-4 form-group">
                                                <label for="recipient-name" class="col-form-label">Dob</label>
                                                <input type="date" class="form-control form-control-md" value="dob "
                                                    name="dob">
                                            </div>
                                            @endif
                                            @if (isset($item->gender) && $item->gender ==1)
                                            <div class="col-md-4 form-group">
                                                <label for="recipient-name" class="col-form-label">Gender</label>
                                                <select class="form-select form-select-lg form-select-solid"
                                                    data-control="select2" data-placeholder="Select..."
                                                    data-allow-clear="true" data-hide-search="true" name="gender">
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                </select>
                                            </div>
                                            @endif
                                        </div>
                                       
                                        <div class="row">
                                            @if (isset($item->emergency_contact_name) && $item->emergency_contact_name ==1)
                                            <div class="col-md-6 form-group">
                                                <div class="fv-row mb-10">

                                                    <label for="recipient-name" class="col-form-label">Emergency contact
                                                        name</label>
                                                    <input type="text" class="form-control form-control-md"
                                                        name="emergencyContactName">
                                                </div>
                                            </div>
                                            @endif
                                            @if (isset($item->emergency_contact_phone) && $item->emergency_contact_phone ==1)
                                            <div class="col-md-6 form-group">
                                                <div class="fv-row mb-10">
                                                    <label for="recipient-name" class="col-form-label">Emergency contact
                                                        phone</label>
                                                    <input type="text" class="form-control form-control-md"
                                                        name="emergencyContactPhone">
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        
                                        <div class="row">
                                        </div>
                                        @if (isset($item->select_customer) && $item->select_customer == 1)
                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <div class="fv-row mb-10">
                                                    <label for="recipient-name" class="col-form-label">Select
                                                        Customer</label>
                                                    <select multiple multiselect-search="true"
                                                        multiselect-select-all="true" multiselect-max-items="1"
                                                        id="specific_customers_id" name="specific_customers_id[]"
                                                        multiple="">

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
                                                data-kt-users-modal-action="submit">
                                                <span id="form_submit" class="indicator-label">Submit</span>
                                                <span class="indicator-progress">Please wait...
                                                    <span
                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span>
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
            <!--end::Content-->
            <!--begin::Footer-->
            <div class="modal fade" id="quick-modal" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-750px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2 class="fw-bolder" id="form_head">Send Quick Onboarding</h2>
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
                            <form id="quick-form-guard" class="form" action="{{ url('guard/save_personal_form') }}"
                                method="POST" enctype="multipart/form-data">

                                @csrf

                                <input type="hidden" value="quick" id="form_type" name="form_type" required>

                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label for="name" class="col-form-label">First Name</label>
                                        <input type="text" class="form-control form-control-md" id="first_name"
                                            name="first_name" required>
                                    </div>
                                    {{-- <div class="col-md-4 form-group">
																						<label for="name" class="col-form-label">Middle Name</label>
																						<input type="text" class="form-control form-control-md"  id="middle_name" name="middle_name"> </div> --}}
                                    <div class="col-md-4 form-group">
                                        <label for="name" class="col-form-label">Middle Name</label>
                                        <input type="text" class="form-control form-control-md" value=""
                                            id="middle_name" name="middle_name">
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label for="name" class="col-form-label">Last Name</label>
                                        <input type="text" class="form-control form-control-md" value=""
                                            id="last_name" name="last_name" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="recipient-name" class="col-form-label">Email</label>
                                        <input type="email" class="form-control form-control-md" name="email"
                                            required>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="recipient-name" class="col-form-label">Phone</label>
                                        <input type="text" class="form-control form-control-md" placeholder="phone "
                                            name="phone">
                                    </div>



                                </div>
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label for="recipient-name" class="col-form-label">{{ config('custom.guard') }}
                                            Type</label>

                                        <select class="form-select form-select-lg form-select-solid"
                                            data-control="select2" data-placeholder="Select..." data-allow-clear="true"
                                            data-hide-search="true" id="guard_working_type" name="guard_working_type">
                                            <option value="guard">{{ config('custom.guard') }}</option>
                                            <option value="covid_marshal">Covid Marshal</option>
                                            <option value="both">Both</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label for="recipient-name" class="col-form-label">{{ config('custom.guard') }}
                                            Type</label>

                                        <select class="form-select form-select-lg form-select-solid"
                                            data-control="select2" data-placeholder="Select..." data-allow-clear="true"
                                            data-hide-search="true" id="guard_type_quick" name="guard_type">
                                            <option value="Direct">Direct</option>
                                            <option value="Contractor">Contractor</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group" id="contractor_container_quick"
                                        style="display: none">
                                        <label for="recipient-name" class="col-form-label">Contractors</label>
                                        <select class="form-select form-select-lg form-select-solid"
                                            data-control="select2" data-placeholder="Select..." data-allow-clear="true"
                                            id="contractor_id_quick" name="contractor_id">
                                            <option value="0"> Select Contractor</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="recipient-name" class="col-form-label">State</label>

                                        <select class="form-select form-select-lg form-select-solid" data-control=""
                                            data-placeholder="Select..." data-allow-clear="true" data-hide-search="true"
                                            name="state" id="administrative_area_level_1">
                                            <option value="Victoria">Victoria</option>
                                            <option value="New South Wales">NSW</option>
                                            <option value="Queensland">Queensland</option>
                                            <option value="Tasmania">Tasmania</option>
                                            <option value="Western Australia">Western Australia</option>
                                            <option value="South Australia">South Australia</option>
                                            <option value="ACT">ACT</option>
                                        </select>
                                    </div>
                                    @if (isset($item->add_guards) && $item->add_guards ==1)
                                    <div class="col-md-4 form-group">

                                        <label for="recipient-name" class="col-form-label">Select Customers</label>

                                        <select multiple multiselect-search="true" multiselect-select-all="true"
                                            multiselect-max-items="1" id="specific_customers_id"
                                            name="specific_customers_id[]" multiple="">
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                        <!-- </div> -->
                                    </div>
                                    @endif
                                   
                                </div>
                                <br>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                                        <span id="form_submit" class="indicator-label">Submit</span>
                                        <span class="indicator-progress">Please wait...
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

            <!--end::Root-->
            <!--begin::Drawers-->
            <!--begin::Activities drawer-->

            <!--end::Exolore drawer-->
            <!--end::Drawers-->
            <!--begin::Modals-->
            <!--begin::Modal - Invite Friends-->

            <!--end::Modal - Create App-->

            <!--begin::Scrolltop-->
            <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
                <!--begin::Svg Icon | path: icons/duotone/Navigation/Up-2.svg-->
                <span class="svg-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                        height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24" />
                            <rect fill="#000000" opacity="0.5" x="11" y="10" width="2"
                                height="10" rx="1" />
                            <path
                                d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z"
                                fill="#000000" fill-rule="nonzero" />
                        </g>
                    </svg>
                </span>
                <!--end::Svg Icon-->
            </div>
        </div>


    @stop
    @section('pageFooter')
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
            $("#mobile-num").on("blur", function() {
                var mobNum = $(this).val();
                var filter = /^\d*(?:\.\d{1,2})?$/;

                if (filter.test(mobNum)) {
                    if (mobNum.length == 10) {
                        $("#mobile-valid").removeClass("hidden");
                        $("#mobile-valid").css("color", "green");
                        $("#folio-invalid").addClass("hidden");
                    } else {
                        // alert('Please put 10  digit mobile number');
                        $("#folio-invalid").removeClass("hidden");
                        $("#folio-invalid").css("color", "red");
                        $("#mobile-valid").addClass("hidden");
                        return false;
                    }
                } else {
                    alert('Not a valid number');
                    $("#folio-invalid").removeClass("hidden");
                    $("#mobile-valid").addClass("hidden");
                    return false;
                }

            });
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
                            window.location.href = "{{ url('edit_guard') }}" + '/' + result.guard_id;
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

            $("#quick-form-guard").on('submit', function(e) {
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
                                text: "Created Successfully",
                                icon: "success",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-light"
                                }
                            })
                            window.location.href = "{{ url('edit_guard') }}" + '/' + result.guard_id;
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
                targetInput = j;
                // errorAlert('Please wait image is uploading...');
                readImage(document.getElementById(i), i);
            }

            function readImage(e, i) {
                if (e.files && e.files[0]) {

                    var FR = new FileReader();

                    FR.addEventListener("load", function(e) {
                        var image = e.target.result;
                        if (image != '') {
                            $.ajax({
                                type: "POST",
                                url: "{{ url('guard/upload_files') }}",
                                data: {
                                    image: image,
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(result) {
                                    console.log(result)
                                    var obj = result;
                                    if (obj.success) {
                                        $('#' + i).val('');
                                        // successAlert('Image upload successfully.');
                                        $('#' + targetInput).val(obj.path);
                                    } else {
                                        // errorAlert('Failed to upload image!');
                                        $('#' + i).val('');
                                    }

                                }
                            });

                        } else {
                            alertify.error('Not a valid image!')

                        }
                    });

                    FR.readAsDataURL(e.files[0]);
                }

            }

            var searchInput = 'googleaddressSearch';
            var componentForm = {
                // street_number: 'short_name',
                // route: 'long_name',
                locality: 'long_name',
                administrative_area_level_2: 'short_name',
                administrative_area_level_1: 'long_name',
                postal_code: 'long_name'
                //   political: 'short_name',


                // country: 'long_name'
            };
            $(document).ready(function() {
                getcontractors();
                MultiselectDropdown(window.MultiselectDropdownOptions);
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
                    latlng = latitude + "," + logitude;
                    $("#coordinate_display").css("color", "black");
                    $("#coordinate_display").val(latlng);
                    $("#coordinates").val(latlng);
                    for (var i = 0; i < near_place.address_components.length; i++) {
                        var addressType = near_place.address_components[i].types[0];
                        // if(addressType=="")
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
                        $('#contractor_id_quick').html(html);
                    }
                });
            }
            $('#guard_type').on('change', function() {
                if ($(this).val() == 'Direct' || $(this).val() == 'direct' || $(this).val() == '') {
                    $('#contractor_container').css('display', 'none');
                    $('#contractor_id').val('');
                } else {
                    $('#contractor_container').css('display', '');

                    // getcontractors();
                }
            });
            $('#guard_type_quick').on('change', function() {
                if ($(this).val() == 'Direct' || $(this).val() == 'direct' || $(this).val() == '') {
                    $('#contractor_container_quick').css('display', 'none');
                    $('#contractor_id_quick').val('');
                } else {
                    $('#contractor_container_quick').css('display', '');

                    // getcontractors();
                }
            });
        </script>
    @stop
