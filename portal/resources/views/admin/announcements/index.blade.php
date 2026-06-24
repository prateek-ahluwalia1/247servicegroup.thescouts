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
                                <!--begin::Heading-->
                                @if(session()->get('userType')=='admin')
                                <div class="card-px text-center py-20 my-10">
                                    <!--begin::Title-->
                                    <h2 class="fs-2x fw-bolder mb-10">New Announcements</h2>
                                    <!--end::Title-->
                                    <!--begin::Description-->
                                   
                                    <!--end::Description-->
                                    <!--begin::Action-->
                                    <a href="#" class="btn btn-primary er fs-6 px-8 py-4" data-bs-toggle="modal" data-bs-target="#induction_modal">Add New Announcements</a>
                                    <!--end::Action-->
                                </div>
                                @endif
                                <!-- <div class="separator separator-dashed mb-9"></div> -->
                                    <!--end::Separator-->
                                    <!--begin::Row-->
                                    <div class="row p-20 container">
                                        @foreach($results as $result)
                                        <div class="col-md-4">
                                            <div class="card-xl-stretch me-md-6">
                                                <div class="overlay mt-8">
                                                    <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px" style="background-image:url('{{asset('')}}media/announcement.jpg ')"></div>
                                                    <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                                        <a class="action_button  btn btn-icon btn-circle btn-active-color-primary bg-white shadow" href="{{url('announcements/induction')}}/{{$result->id}}" style="margin: 9px;" >view</a>
                                                        @if(session()->get('userType')=='admin')

                                                        <a type="button" class="action_button  btn btn-icon btn-circle btn-active-color-primary bg-white shadow" onclick="edit_induction({{$result->id}})" style="margin: 9px;" >
                                                            <i class="bi bi-pencil-fill fs-7"></i>
                                                        </a>		
                                                        <a type="button" class=" action_button btn btn-icon btn-circle btn-active-color-primary  bg-white shadow" onclick="delete_induction({{$result->id}})" style="margin: 9px; ">
                                                            <i class="bi bi-x fs-2"></i>
                                                        </a>
                                                        <a class="action_button  btn btn-icon btn-circle btn-active-color-primary bg-white shadow" type="button" onclick="induction_seen_status({{$result->id}})" style="margin: 9px;" >i</a>

                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="mt-5">
                                                    <a href="{{url('announcements/induction')}}/{{$result->id}} " class="fs-4 text-dark fw-bolder text-hover-primary text-dark lh-base">{{$result->title}}</a>
                                                    <div class="fw-bold fs-5 text-gray-600 text-dark mt-3 p-2">Updated at: <span class="text-muted">{{$result->updated_at}}</span></div>
                                                    @if(session()->get('userType')=='admin')

                                                    {{-- <div class="fs-6 fw-bolder mt-5 d-flex flex-stack">
                                                        

                                                        <a type="button" onclick="get_induction_images({{$result->id}})"
                                                            class="btn btn-primary" style="width:100%; " class="btn btn-primary">{{config('custom.guard')}}'s induction card</a>
                                                    </div> --}}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
<!-- cards by hussain -->
                            
                            </div>
                            
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                        <!--begin::Modal - New Target-->
                        <div class="modal fade" id="induction_modal" tabindex="-1" aria-hidden="true">
                            <!--begin::Modal dialog-->
                            <div class="modal-dialog modal-dialog-centered mw-650px">
                                <!--begin::Modal content-->
                                <div class="modal-content rounded">
                                    <!--begin::Modal header-->
                                    <div class="modal-header pb-0 border-0 justify-content-end">
                                        <!--begin::Close-->
                                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                            <!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
                                            <span class="svg-icon svg-icon-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                                                        <rect fill="#000000" x="0" y="7" width="16" height="2" rx="1" />
                                                        <rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1" />
                                                    </g>
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </div>
                                        <!--end::Close-->
                                    </div>
                                    <!--begin::Modal header-->
                                    <!--begin::Modal body-->
                                    <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                                        <!--begin:Form-->
                                        <form id="induction-form" action="{{url('announcements/add_induction')}}" class="form"  method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <!--begin::Heading-->
                                            <div class="mb-13 text-center">
                                                <!--begin::Title-->
                                                <h1 class="mb-3">Add Announcement</h1>
                                                <!--end::Title-->
                                                <!--begin::Description-->
                                                <div class="text-gray-400 fw-bold fs-5">You can specify your announcement below
                                                <a href="#" class="fw-bolder link-primary"></a>.</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Heading-->
                                            <!--begin::Input group-->
                                            <div class="d-flex flex-column mb-8 fv-row">
                                                <!--begin::Label-->
                                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                    <span class="required"> Title</span>
                                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify a announcement name for future usage and reference"></i>
                                                </label>
                                                <!--end::Label-->
                                                <input type="text" class="form-control form-control-solid" placeholder="Enter announcement Title" name="title" id="title" />
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="row g-9 mb-8">
                                                <!--begin::Col-->
                                                <div class="col-md-6 fv-row" id="send_to_div">
                                                    <label class="required fs-6 fw-bold mb-2">Sent to</label>
                                                    <select class="form-select form-select-solid" data-control="select2" data-dropdown-parent="#induction_modal" data-placeholder="Sent to" id="send_to" name="send_to">
                                                        <option value="">Select user...</option>
                                                        <option value="1">{{config('custom.guard')}}s</option>
                                                        
                                                    </select>
                                                </div>
                                                <div class="col-md-6 fv-row" id="send_by_div">
                                                    <label class="required fs-6 fw-bold mb-2">Select {{config('custom.guard')}} Type</label>
                                                    <select class="form-select form-select-solid" data-control="select2" data-dropdown-parent="#induction_modal" data-placeholder="Select {{config('custom.guard')}} Type"  id="send_by" name="send_by">
                                                        <option value="">Select</option>
                                                        <option value="customer">Customers {{config('custom.guard')}}s</option>
                                                        <option value="contractor">Contractors {{config('custom.guard')}}s</option>
                                                        <option value="direct">Direct {{config('custom.guard')}}s</option>

                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row g-9 mb-8">
                                                <!--end::Col-->
                                                <div class="col-md-6 fv-row" id="send_by_list_div">
                                                    <label class="required fs-6 fw-bold mb-2">Select</label>
                                                    <select class="form-select form-select-solid  " data-control="select2" data-dropdown-parent="#induction_modal" data-placeholder="Select  {{config('custom.guard')}} " id="send_by_list" name="send_by_list">
                                                        
                                                    

                                                        
                                                    </select>
                                                </div>
                                                <!--begin::Col-->
                                                <div class="col-md-6 fv-row" id="send_to_guards_div">
                                                    <label class="required fs-6 fw-bold mb-2">Select {{config('custom.guard')}}s</label>
                                                    <select class="form-select form-select-solid " data-control="select2" data-dropdown-parent="#induction_modal" data-placeholder="Select  {{config('custom.guard')}} " id="send_to_guards" name="send_to_guards" multiple="">

                                                        
                                                    </select>
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                              <div class="mb-10">
                                                <h4 class="fs-5 fw-bold text-gray-800">Select Image</h4>
                                                <div class="d-flex">
                                                    <input type="file" class="form-control form-control-md" name="image" id="add_image">
                                                </div>
                                            </div>

                                              <div class="mb-10">
                                                <h4 class="fs-5 fw-bold text-gray-800">Uploaded image link</h4>
                                                <div class="d-flex">
                                                    <input id="image_input_path" type="text" class="form-control kt_share_earn_link_input form-control-solid me-3 flex-grow-1" name="search" >
                                                    <button id="" class="btn btn-light fw-bolder kt_share_earn_link_copy_button flex-shrink-0" data-clipboard-target="#image_input_path">Copy Link</button>
                                                </div>
                                            </div>

                                                <div id="editor" class="form-group d-flex flex-stack mb-8">
                                                    <textarea class="rich_text_content1" name="htmlBody" id="htmlBody"></textarea>
                                                  
                                                  </div>
                                            <div class="d-flex flex-stack mb-8">
                                                <!--begin::Label-->
                                            
                                                <!--end::Label-->
                                                <!--begin::Switch-->
                                         
                                                <!--end::Switch-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="mb-15 fv-row">
                                                <!--begin::Wrapper-->
                                                <div class="d-flex flex-stack">
                                                    <!--begin::Label-->
                                                    <div class="fw-bold me-5">
                                                        <label class="fs-6">Notifications</label>
                                                        <div class="fs-7 text-gray-400">Allow Notifications by  Email</div>
                                                    </div>
                                                    <!--end::Label-->
                                                    <!--begin::Checkboxes-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Checkbox-->
                                                        <label class="form-check form-check-custom form-check-solid me-10">
                                                            <input class="form-check-input h-20px w-20px" type="checkbox" name="communication[]" value="email" checked="checked" />
                                                            <span class="form-check-label fw-bold">Email</span>
                                                        </label>
                                                        <!--end::Checkbox-->
                                                        <!--begin::Checkbox-->
                                                    
                                                        <!--end::Checkbox-->
                                                    </div>
                                                    <!--end::Checkboxes-->
                                                </div>
                                                <!--end::Wrapper-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Actions-->
                                            <div class="text-center">
                                                <button type="reset" id="kt_modal_new_target_cancel" class="btn btn-white me-3">Cancel</button>
                                                <button type="submit" id="kt_modal_new_target_submit" class="btn btn-primary">
                                                    <span class="indicator-label">Submit</span>
                                                    <span class="indicator-progress">Please wait...
                                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                </button>
                                            </div>
                                            <!--end::Actions-->
                                        </form>
                                        <!--end:Form-->
                                    </div>
                                    <!--end::Modal body-->
                                </div>
                                <!--end::Modal content-->
                            </div>
                            <!--end::Modal dialog-->
                        </div>
                        <!--end::Modal - New Target-->

                        <!--begin::Modal EDIT - New Target-->
                        <div class="modal fade" id="induction_modal_edit" tabindex="-1" aria-hidden="true">
                            <!--begin::Modal dialog-->
                            <div class="modal-dialog modal-dialog-centered mw-650px">
                                <!--begin::Modal content-->
                                <div class="modal-content rounded">
                                    <!--begin::Modal header-->
                                    <div class="modal-header pb-0 border-0 justify-content-end">
                                        <!--begin::Close-->
                                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                            <!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
                                            <span class="svg-icon svg-icon-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                                                        <rect fill="#000000" x="0" y="7" width="16" height="2" rx="1" />
                                                        <rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1" />
                                                    </g>
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </div>
                                        <!--end::Close-->
                                    </div>
                                    <!--begin::Modal header-->
                                    <!--begin::Modal body-->
                                    <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                                        <!--begin:Form-->
                                        <form id="induction-form_edit" action="{{url('announcements/edit_induction')}}" class="form"  method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <!--begin::Heading-->
                                            <div class="mb-13 text-center">
                                                <!--begin::Title-->
                                                <h1 class="mb-3">Change Announcement</h1>
                                                <!--end::Title-->
                                                <!--begin::Description-->
                                                <div class="text-gray-400 fw-bold fs-5">You can specify your announcement below
                                                <a href="#" class="fw-bolder link-primary"></a>.</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Heading-->
                                            <!--begin::Input group-->
                                            <div class="d-flex flex-column mb-8 fv-row">
                                                <!--begin::Label-->
                                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                    <span class="required"> Title</span>
                                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify a announcement name for future usage and reference"></i>
                                                </label>
                                                <!--end::Label-->
                                                <input type="text" class="form-control form-control-solid" placeholder="Enter announcement Title" name="title" id="title" />
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="row g-9 mb-8">
                                                <!--begin::Col-->
                                                <div class="col-md-6 fv-row" id="send_to_div_edit">
                                                    <label class="required fs-6 fw-bold mb-2">Sent to</label>
                                                    <select class="form-select form-select-solid"  data-dropdown-parent="#induction_modal_edit" data-placeholder="Sent to" id="send_to_edit" name="send_to_edit">
                                                        <option value="">Select user...</option>
                                                        <option value="guards">{{config('custom.guard')}}s</option>
                                                        
                                                    </select>
                                                </div>
                                                <div class="col-md-6 fv-row" id="send_by_div_edit">
                                                    <label class="required fs-6 fw-bold mb-2">Select {{config('custom.guard')}} Type</label>
                                                    <select class="form-select form-select-solid"  data-dropdown-parent="#induction_modal_edit" data-placeholder="Select {{config('custom.guard')}} Type"  id="send_by_edit" name="send_by_edit">
                                                        <option value="">Select</option>
                                                        <option value="customer">Customers {{config('custom.guard')}}s</option>
                                                        <option value="contractor">Contractors {{config('custom.guard')}}s</option>
                                                        <option value="direct">Direct {{config('custom.guard')}}s</option>

                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row g-9 mb-8">
                                                <!--end::Col-->
                                                <div class="col-md-6 fv-row" id="send_by_list_div_edit">
                                                    <label class="required fs-6 fw-bold mb-2">Select</label>
                                                    <select class="form-select form-select-solid  " data-dropdown-parent="#induction_modal_edit" data-placeholder="Select  {{config('custom.guard')}} " id="send_by_list_edit" name="send_by_list_edit">
                                                        
                                                    

                                                        
                                                    </select>
                                                </div>
                                                <!--begin::Col-->
                                                <div class="col-md-6 fv-row" id="send_to_guards_div_edit">
                                                    <label class="required fs-6 fw-bold mb-2">Select {{config('custom.guard')}}s</label>
                                                    <!-- <select class="form-select form-select-solid " data-control="select2" data-dropdown-parent="#induction_modal_edit" data-placeholder="Select  {{config('custom.guard')}} " id="send_to_guards_edit" name="send_to_guards_edit[]" multiple=" "> -->
                                                        <select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1" id="send_to_guards_edit" name="send_to_guards_edit[]">
                                                        
                                                    </select>
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                              <div class="mb-10">
                                                <h4 class="fs-5 fw-bold text-gray-800">Select Image</h4>
                                                <div class="d-flex">
                                                    <input type="file" class="form-control form-control-md" name="image_edit" id="add_image_edit">
                                                </div>
                                            </div>

                                              <div class="mb-10">
                                                <h4 class="fs-5 fw-bold text-gray-800">Uploaded image link</h4>
                                                <div class="d-flex">
                                                    <input id="image_path_upload_edit" type="text" class="form-control kt_share_earn_link_input_edit  form-control-solid me-3 flex-grow-1" name="search" >
                                                    <button id="" class="btn btn-light kt_share_earn_link_copy_button_edit  fw-bolder flex-shrink-0" data-clipboard-target="#image_path_upload_edit">Copy Link</button>
                                                </div>
                                            </div>
                                                <div class="form-group d-flex flex-stack mb-8"  id="rich-text-div">
                                                    {{-- <textarea class="rich_text_content_edit" name="htmlBody_edit" id="htmlBody_edit"></textarea>
                                                   --}}
                                                  </div>
                                          <input type="hidden" name="inductionId">

                                            <div class="d-flex flex-stack mb-8">
                                                <!--begin::Label-->
                                            
                                                <!--end::Label-->
                                                <!--begin::Switch-->
                                             
                                                <!--end::Switch-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="mb-15 fv-row">
                                                <!--begin::Wrapper-->
                                                <div class="d-flex flex-stack">
                                                    <!--begin::Label-->
                                                    <div class="fw-bold me-5">
                                                        <label class="fs-6">Notifications</label>
                                                        <div class="fs-7 text-gray-400">Allow Notifications by  Email</div>
                                                    </div>
                                                    <!--end::Label-->
                                                    <!--begin::Checkboxes-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Checkbox-->
                                                        <label class="form-check form-check-custom form-check-solid me-10">
                                                            <input class="form-check-input h-20px w-20px" type="checkbox" name="communication[]" value="email" checked="checked" />
                                                            <span class="form-check-label fw-bold">Email</span>
                                                        </label>
                                                        <!--end::Checkbox-->
                                                        <!--begin::Checkbox-->
                                                    
                                                        <!--end::Checkbox-->
                                                    </div>
                                                    <!--end::Checkboxes-->
                                                </div>
                                                <!--end::Wrapper-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Actions-->
                                            <div class="text-center">
                                                <button class="btn btn-white me-3" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" id="kt_modal_new_target_submit" class="btn btn-primary">
                                                    <span class="indicator-label">Update</span>
                                                    <span class="indicator-progress">Please wait...
                                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                </button>
                                            </div>
                                            <!--end::Actions-->
                                        </form>
                                        <!--end:Form-->
                                    </div>
                                    <!--end::Modal body-->
                                </div>
                                <!--end::Modal content-->
                            </div>
                            <!--end::Modal dialog-->
                        </div>
                        <!--end::Modal - New Target-->
                            <!--begin::Modal EDIT - New Target-->
                            <div class="modal fade" id="card_modal" tabindex="-1" aria-hidden="true">
                                <!--begin::Modal dialog-->
                                <div class="modal-dialog modal-dialog-centered mw-650px">
                                    <!--begin::Modal content-->
                                    <div class="modal-content rounded">
                                        <!--begin::Modal header-->
                                        <div class="modal-header pb-0 border-0 justify-content-end">
                                            <!--begin::Close-->
                                                
                                            
                                                <div class="card-title">
                                    
                                </div>
                                
                                            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                                <!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
                                                <span class="svg-icon svg-icon-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                                                            <rect fill="#000000" x="0" y="7" width="16" height="2" rx="1" />
                                                            <rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1" />
                                                        </g>
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </div>
                                            <!--end::Close-->
                                        </div>
                                        <!--begin::Modal header-->
                                        <!--begin::Modal body-->
                                        <div  class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                                            <div   class="row g-10">
                                                <h3 class="text-center">{{config('custom.guard')}} Induction Card</h3>
                                                <div style="text-align: start" class="row">
                                                    <!--begin::Search-->
                                    <div class="d-flex align-items-center position-relative my-1">
                                        <!--begin::Svg Icon | path: icons/duotone/General/Search.svg-->
                                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                    <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero" />
                                                </g>
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <input type="text" id="search"  class="form-control form-control-solid w-250px ps-14" placeholder="Search user" />
                                    </div>
                                    <!--end::Search-->
                                                </div>
                                                <table id="card_induction_body_table" class="table table-striped ">
                                                    <thead>
                                                        <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
                                                            <th>{{config('custom.guard')}} Name</th>
                                                            <th>{{config('custom.guard')}} Induction Card</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody  id="card_induction_body">
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!--begin:Form-->
                                        
                                            <!--end:Form-->
                                        </div>
                                        <!--end::Modal body-->
                                    </div>
                                    <!--end::Modal content-->
                                </div>
                                <!--end::Modal dialog-->
                            </div>
                            <!--end::Modal - New Target-->

                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Content-->
                <!--begin::Footer-->
            
                <!--end::Footer-->
            <!--end::Wrapper-->





            <div class="modal fade" tabindex="-1" id="kt_modal_1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Seen By</h5>
            
                            <!--begin::Close-->
                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                <span class="svg-icon svg-icon-2x"></span>
                            </div>
                            <!--end::Close-->
                        </div>
            
                        <div class="modal-body" id="induction_seen">
                            {{-- <p></p> --}}
                        </div>
            
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
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

$(document).ready(function() {
        $('.rich_text_content1').richText();

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

var global_tutorials = [];

function update_induction(id){
            call_spinner();
        $('.multiselect-dropdown').remove();

    $.ajax({
    type: "POST",
    data: {id: id,_token:'<?php echo csrf_token()?>'},
    url: "{{url('announcements/update_induction')}}", 
    success: function(result){
        global_tutorials=result;
        $.each(global_tutorials, function(id, data){
            selected_guards = data.selected_guards;

            $('#rich-text-div').html('');
         $('#rich-text-div').html('	<textarea class="rich_text_content_edit" name="htmlBody_edit" id="htmlBody_edit"></textarea>');
        //  $('.rich_text_content_edit').richText();
              console.log(data.html_body)
            $('#induction-form_edit').find('input[name="title"]').val(data.title);
            $('#induction-form_edit').find('textarea[name="htmlBody_edit"]').val(data.html_body);

            $('#induction-form_edit').find('input[name="inductionId"]').val(data.id);
            $('#induction-form_edit').find('textarea[name="htmlBody_edit"]').richText();
            $('#send_to_edit').val(data.send_to);
            $('#send_by_edit').val(data.send_by);
            if (data.send_by == 'direct') {
                close_spinner()
                $('#send_by_list_div_edit').css('display', 'none');
                load_guards_edit();
            }else if(data.send_by != null){
                $('#send_by_list_div_edit').css('display', '');
                close_spinner()
                load_send_by_list(data.send_by, data.send_by_list);
                setTimeout(function(){
                    $('#send_by_list_edit').val(data.send_by_list);
                    $('#send_to_guards_edit').val(data.selected_guards);
                    close_spinner();

                }, 2000);
                setTimeout(function(){
                    // MultiselectDropdown(window.MultiselectDropdownOptions);
        $('.multiselect-dropdown').remove();
                    
                    MultiselectDropdown();
                }, 3000);

            }else{
                close_spinner()
                $('#send_by_list_div_edit').css('display', 'none');
                $('#send_to_guards_div_edit').css('display', 'none');

            }


  });
      }
    })
    
    
    
    
}	

$("#induction-form_edit").on('submit', function(e){
 e.preventDefault();
 call_spinner();
    console.log(this.id)
     var data = $('#'+this.id).serialize();

     $.ajax({type: "POST",url: this.action,data : data ,success: function(result){if(result.success){
         $('#induction_modal_edit').modal('hide');
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
                window.location.href = "{{ url('announcements/inductions')}}";
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

});





function delete_induction(id){
	var id=id;

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
							$.ajax({type: "POST",url: `{{url('/announcements/delete_induction')}}/${id}`, data:{_token:'<?php echo csrf_token();?>'},success: function(result){
								Swal.fire({
                            text: "Deleted Succesfully.",
                            icon: "success",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        })
                        window.location.href = "{{ url('announcements/inductions')}}";
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



$('#send_by_edit').change(function(){


      selected_guards = [];
var send_by = $(this).val();
if (send_by == 'direct') {
  $('#send_by_list_div_edit').hide();
  load_guards_edit();

}else{
  $('#send_to_guards_div_edit').hide();

load_send_by_list(send_by);
}
});


$('#send_by_list_edit').change(function(){
load_guards_edit();
});






$('#send_by').change(function(){
//    selected_guards = [];
var send_by = $(this).val();
console.log(send_by);
if (send_by == 'direct') {
$('#send_by_list_div').hide();
load_guards();

}
else{
$('#send_to_guards_div').hide();
$.ajax({
 type: "POST",
 data: {send_by : send_by,_token  : '<?php echo csrf_token() ?>'},
 url: "{{url('announcements/get_send_by_list')}}",
 success: function(result){
    
     var options= '';
    //  $.each(result, function(mind, mval){
    //    options += '<option value="'+mval.id+'">'+mval.name+'</option>';
    //  });
         $.each(result, function(id, data){
       options += '<option value="'+data.id+'">'+data.name+'</option>';
     });
   $('#send_by_list').html(options);
   $('#send_by_list_div').show();
//    var siteData = '<div class="list-group-item" data-plugin="editlist"> <div class="list-content"> <b>No data found.</b></div></div>';
// 			 $(".le-search-menu").html(siteData);

   }

 });
}
});


function load_guards()
{
// alert();
var send_by_list_id = $('#send_by_list').val();
var send_by = $('#send_by').val();
        $('.multiselect-dropdown').remove();

$.ajax({
 type: "POST",
 data: {send_by : send_by, send_by_list_id: send_by_list_id,_token:'<?php echo csrf_token() ?>'},
 url: "{{url('announcements/get_guard_list')}}",
 success: function(result){
     var siteData2 = '';
         $.each(result, function(id, data) {
            siteData2  += '<option value="'+data.id+'">'+data.name+'</option>';
         });
         $('.multiselect-dropdown').remove();
         $("#send_to_guards").html(siteData2);
       $('#send_to_guards_div').show();
       MultiselectDropdown();
       // $('#send_to_guards_div_edit').css('display','');
   }
 });
}

$('#send_by_list').change(function(){
load_guards();
});



$("#induction-form").on('submit', function(e){
 e.preventDefault();
 // console.log(this.id)
 call_spinner();
 var data = $('#'+this.id).serialize();

 $.ajax({type: "POST",url: this.action,data : data ,success: function(result){if(result.success){
     $('#induction_modal').modal('hide');
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
                window.location.href = "{{ url('announcements/inductions')}}";

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

});


function edit_induction(id){
update_induction(id);
$('.rich_text_content_edit').richText();

  $('#induction_modal_edit').modal('show');	

}
function load_guards_edit()
{
    close_spinner();
    // console.log(selected_guards) 
        $('.multiselect-dropdown').remove();
// alert();
var send_by_list_id = $('#send_by_list_edit').val();
var send_by = $('#send_by_edit').val();
$.ajax({
    type: "POST",
    data: {send_by : send_by, send_by_list_id: send_by_list_id,_token:'<?php echo csrf_token();?>'},
    url: "{{url('announcements/get_guard_list')}}",
    success: function(result){
        var siteData2 = '';
         $.each(result, function(id, data) {
            var checked = '';
            var unselected_guard_id = data.id;
    //         var  index = selected_guards.indexOf(unselected_guard_id);
    //         console.log(selected_guards) 
    //         if (index > -1) {
    //         var checked = 'selected';
    // console.log('i am in')

    //     }
            siteData2  += '<option value="'+data.id+'" '+checked+'>'+data.name+'</option>';
         });
        // var siteData2 = '';
            $("#send_to_guards_edit").html(siteData2);
            $("#send_to_guards_edit").val(selected_guards);
          // $('#send_to_guards_div').css('display','');
          $('#send_to_guards_div_edit').css('display','');
          MultiselectDropdown();
      }
    });
}

function load_guards_edit2(send_by_list_id)
{
// alert();
        $('.multiselect-dropdown').remove();

// var send_by_list_id = send_by_list_id;
var send_by = $('#send_by_edit').val();
$.ajax({
    type: "POST",
    data: {send_by : send_by, send_by_list_id: send_by_list_id,_token:'<?php echo csrf_token();?>'},
    url: "{{url('announcements/get_guard_list')}}",
    success: function(result){
        // $('.multiselect-dropdown').remove();
        var siteData2 = '';
        $.each(result, function(id, data) {
        var checked = '';
        var unselected_guard_id = data.id;
        var  index = selected_guards.indexOf(unselected_guard_id);
            if (index > -1) {
            var checked = 'selected';
        }
            siteData2  += '<option value="'+data.id+'" '+checked+'>'+data.name+'</option>';
         });
        // var siteData2 = '';
            $("#send_to_guards_edit").html(siteData2);
          // $('#send_to_guards_div').css('display','');
          $('#send_to_guards_div_edit').css('display','');
          MultiselectDropdown();
      }
    });
}


function load_send_by_list(send_by, send_by_list_id = null){
    // alert(send_by_list_id)
    $.ajax({
    type: "POST",
    data: {send_by : send_by,_token:'<?php echo csrf_token();?>'},
    url: "{{url('announcements/get_send_by_list_induction')}}",
    success: function(result){

        // result = JSON.parse(result);
        var options= '<option value="" >Select</option>';
        $.each(result, function(id, data){
            var selected = '';
            // if (send_by_list_id != null && send_by_list_id == data.id) {
            // var selected = 'selected';

            // }
          options += '<option value="'+data.id+'" >'+data.name+'</option>';
        });
      $('#send_by_list_edit').html(options);
    //   $('#send_by_list_edit').html(options);
      $('#send_by_list_div_edit').show();
    //   var siteData = '<div class="list-group-item" data-plugin="editlist"> <div class="list-content"> <b>No data found.</b></div></div>';
    //             $(".le-search-menu-edit").html(siteData);
                if (send_by_list_id != null) {
                load_guards_edit2(send_by_list_id);
                }

      }

    });
}


function get_induction_images(id){
$('#card_modal').modal('show');	
$.ajax({

      type: "POST",
    data: {id : id,_token:'<?php echo csrf_token();?>'},
    url: "{{url('announcements/get_induction_images')}}", 
success: function(result){
//   result = JSON.parse(result);
  var options= '';
  $.each(result, function(id, data){
    // data.picture= `{{asset('')}}${data.image}`;
    options += `<tr><td>${data.name}</td><td style="text-align:end"><a style="font-size: 11px;" target="__blank" href="${data.image}" class="btn btn-primary">View Card</a></td></tr>`;
    // console(data.picture);
    //   options += `<div class="col-md-4">
    // 										<div class="card-xl-stretch me-md-6">
    // 											<span class="d-block overlay" data-fslightbox="lightbox-hot-sales" >
    // 												<a href="${data.image}" target="_blank" >
    // 												<div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px" style="background-image:url('announcements/${data.picture}')"></div></a>
    // 												<div class="overlay-layer card-rounded bg-dark bg-opacity-25">
    // 												</div>
    // 											</span>
    // 											<div class="mt-5">
    // 												<a type="button" class="fs-4 text-dark fw-bolder text-hover-primary text-dark lh-base">${data.name}</a>
    // 												<a  class="text-gray-700 text-hover-primary">updated at: </a>
    // 													<span class="text-muted">${data.created_at}</span>
    // 											</div>
    // 										</div>
    // 									</div>`;
     });
   $('#card_induction_body').html(options);
   $('#card_induction_body_table').DataTable({
    lengthMenu: [5, 10, 20, 50, 100, 200, 500],
   });
   

}
})

}



// custom
var KTModalShareEarn={init:function(){var e,n,s;e=document.querySelector(".kt_share_earn_link_copy_button"),n=document.querySelector(".kt_share_earn_link_input"),(s=new ClipboardJS(e))&&s.on("success",(function(s){var t=e.innerHTML;n.classList.add("bg-success"),n.classList.add("text-inverse-success"),e.innerHTML="Copied!",setTimeout((function(){e.innerHTML=t,n.classList.remove("bg-success"),n.classList.remove("text-inverse-success")}),3e3),s.clearSelection()}))}};KTUtil.onDOMContentLoaded((function(){KTModalShareEarn.init()}));

var KTModalShareEarn2={init:function(){var e,n,s;e=document.querySelector(".kt_share_earn_link_copy_button_edit"),n=document.querySelector(".kt_share_earn_link_input_edit"),(s=new ClipboardJS(e))&&s.on("success",(function(s){var t=e.innerHTML;n.classList.add("bg-success"),n.classList.add("text-inverse-success"),e.innerHTML="Copied!",setTimeout((function(){e.innerHTML=t,n.classList.remove("bg-success"),n.classList.remove("text-inverse-success")}),3e3),s.clearSelection()}))}};KTUtil.onDOMContentLoaded((function(){KTModalShareEarn2.init()}));




function induction_seen_status(id){
$.ajax({type: "POST",url:"{{url('announcements/induction_seen_status')}}",data:{id:id,_token:'<?php echo csrf_token();?>'} ,success: function(result){
    var html='';
    $('#induction_seen').empty();

    $('#kt_modal_1').modal('show');
    if(result!=''){

        $.each(result,function(id,data){
            html+=`<p>${data.name} ,</p>`;
            $('#induction_seen').append(html);

        });
        
    }
    else{
        html+=`<p>No view yet</p>`;
            $('#induction_seen').append(html);

    }
    var html='';


}
});


}

            </script>
    @stop