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
        <link href="{{asset('')}}msc/css/evol-colorpicker.min.css" rel="stylesheet" />
		<!-- <link href="{{asset('')}}color/jquery.minicolors.css" rel="stylesheet" type="text/css" /> -->
		<!--end::Global Stylesheets Bundle-->
        <style type="text/css">
            .evo-pop {
                background-color: #eeeeee !important;
            }
            .evo-pointer {
            display: none !important; 
        }
        </style>
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
                <div class="card mt-4">
                    

                    <!--begin::Card header-->
                    <div class="card-header">
                        <!--begin::Card title-->
                        <div class="card-title fs-3 fw-bolder">Portal Colors</div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Form-->
                    <form id="guards-emails-form" method="POST" enctype="multipart/form-data" action="{{url('update_portal_colors')}}" class="form admin-emails-form">
                        <!--begin::Card body-->                   
                        @csrf
                        <div class="card-body p-9">
                             <!--begin::Row-->
                            <div class="row mb-5">
                                <!--begin::Col-->
                                <div class="col-xl-2 col-lg-2">
                                    <div class="fs-6 fw-bold mt-2 mb-3">Background Color</div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-1">
                                    <!--begin:: input-->
                                    <div class="col-xl-9 fv-row">
                                        <input class="form-control demo" name="primary_background" id="primary_background"  value="{{(!empty($colors) && isset($colors['primary_background']) ? $colors['primary_background'] : '#000000')}}">
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
                                    <div class="fs-6 fw-bold mt-2 mb-3">Primary Color</div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-1">
                                    <!--begin:: input-->
                                    <div class="col-xl-9 fv-row">
                                        <input class="form-control demo" name="primary_color" id="primary_color" value="{{(!empty($colors) && isset($colors['primary_color']) ? $colors['primary_color'] : '#000000')}}">
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
                                    <div class="fs-6 fw-bold mt-2 mb-3">Secondary Color</div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-1">
                                    <!--begin:: input-->
                                    <div class="col-xl-9 fv-row">
                                        <input class="form-control demo" name="secondary_background" id="secondary_background" value="{{(!empty($colors) && isset($colors['secondary_background']) ? $colors['secondary_background'] : '#000000')}}">
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
                                    <div class="fs-6 fw-bold mt-2 mb-3">Roster Pending Shifts</div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-1">
                                    <!--begin:: input-->
                                    <div class="col-xl-9 fv-row">
                                        <input class="form-control demo" name="pending_shifts" id="pending_shifts" value="{{(!empty($colors) && isset($colors['pending_shifts']) ? $colors['pending_shifts'] : '#000000')}}">
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
                                    <div class="fs-6 fw-bold mt-2 mb-3">Roster Rejected Shifts</div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-1">
                                    <!--begin:: input-->
                                    <div class="col-xl-9 fv-row">
                                        <input class="form-control demo" name="rejected_shifts" id="rejected_shifts" value="{{(!empty($colors) && isset($colors['rejected_shifts']) ? $colors['rejected_shifts'] : '#000000')}}">
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
                                    <div class="fs-6 fw-bold mt-2 mb-3">Roster Publish Shifts</div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-1">
                                    <!--begin:: input-->
                                    <div class="col-xl-9 fv-row">
                                        <input class="form-control demo" name="publish_shifts" id="publish_shifts" value="{{(!empty($colors) && isset($colors['publish_shifts']) ? $colors['publish_shifts'] : '#000000')}}">
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
                                    <div class="fs-6 fw-bold mt-2 mb-3">Roster Un-Publish Shifts</div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-1">
                                    <!--begin:: input-->
                                    <div class="col-xl-9 fv-row">
                                        <input class="form-control demo" name="unpublish_shifts" id="unpublish_shifts" value="{{(!empty($colors) && isset($colors['unpublish_shifts']) ? $colors['unpublish_shifts'] : '#000000')}}">
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
                                    <div class="fs-6 fw-bold mt-2 mb-3">Roster Mock Shifts</div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-1">
                                    <!--begin:: input-->
                                    <div class="col-xl-9 fv-row">
                                        <input class="form-control demo" name="mock_shifts" id="mock_shifts" value="{{(!empty($colors) && isset($colors['mock_shifts']) ? $colors['mock_shifts'] : '#000000')}}">
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
                                    <div class="fs-6 fw-bold mt-2 mb-3">Roster missed Shifts</div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-1">
                                    <!--begin:: input-->
                                    <div class="col-xl-9 fv-row">
                                        <input class="form-control demo" name="missed_shifts" id="missed_shifts" value="{{(!empty($colors) && isset($colors['missed_shifts']) ? $colors['missed_shifts'] : '#000000')}}">
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
                                    <div class="fs-6 fw-bold mt-2 mb-3">Roster un-covered Shifts</div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-1">
                                    <!--begin:: input-->
                                    <div class="col-xl-9 fv-row">
                                        <input class="form-control demo" name="uncoverd_shifts" id="uncoverd_shifts" value="{{(!empty($colors) && isset($colors['uncoverd_shifts']) ? $colors['uncoverd_shifts'] : '#000000')}}">
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
                                    <div class="fs-6 fw-bold mt-2 mb-3">Roster Operational Notes Shift </div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-1">
                                    <!--begin:: input-->
                                    <div class="col-xl-9 fv-row">
                                        <input class="form-control demo" name="operational_notes_shifts" id="operational_notes_shifts" value="{{(!empty($colors) && isset($colors['operational_notes_shifts']) ? $colors['operational_notes_shifts'] : '#000000')}}">
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
                                    <div class="fs-6 fw-bold mt-2 mb-3">Unpublished Site Shifts</div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-1">
                                    <!--begin:: input-->
                                    <div class="col-xl-9 fv-row">
                                        <input class="form-control demo" name="UnPub_fea_color" id="UnPub_fea_color" value="{{(!empty($colors) && isset($colors['UnPub_fea_color']) ? $colors['UnPub_fea_color'] : '#000000')}}">
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
<!-- <script src="{{asset('')}}color/jquery.minicolors.js"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" type="text/javascript"></script>
<script src="{{asset('')}}msc/js/evol-colorpicker.min.js" type="text/javascript"></script>
<script>
    $(document).ready( function() {

    $('.demo').colorpicker({
        // color:'#ebf1dd',
        // initialHistory: ['#ff0000','#000000','red', 'purple']
    });
      // $('.demo').each( function() {
        //
        // Dear reader, it's actually very easy to initialize MiniColors. For example:
        //
        //  $(selector).minicolors();
        //
        // The way I've done it below is just for the demo, so don't get confused
        // by it. Also, data- attributes aren't supported at this time...they're
        // only used for this demo.
        //
        // $(this).minicolors({
        //   control: $(this).attr('data-control') || 'hue',
        //   defaultValue: $(this).attr('data-defaultValue') || '',
        //   format: $(this).attr('data-format') || 'hex',
        //   keywords: $(this).attr('data-keywords') || '',
        //   inline: $(this).attr('data-inline') === 'true',
        //   letterCase: $(this).attr('data-letterCase') || 'lowercase',
        //   opacity: $(this).attr('data-opacity'),
        //   position: $(this).attr('data-position') || 'bottom',
        //   swatches: $(this).attr('data-swatches') ? $(this).attr('data-swatches').split('|') : [],
        //   change: function(value, opacity) {
        //     if( !value ) return;
        //     if( opacity ) value += ', ' + opacity;
        //     if( typeof console === 'object' ) {
        //       console.log(value);
        //     }
        //   },
        //   theme: 'bootstrap'
        // });

      // });

    });
  </script>
<script>

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
    
    </script>
    @stop