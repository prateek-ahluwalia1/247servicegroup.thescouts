

@extends('layout.app')
@extends('layout.sidebar')
@extends('layout.footer')

@section('pageCss')

<meta charset="utf-8" />
<title>{{config('custom.title');}}</title>
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
                        <a href="index.html" class="text-muted">Home</a>
                    </li>
                    <li class="breadcrumb-item text-dark">Sites Stats</li>
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
                    <img alt="Logo" src="{{asset('')}}media/logos/logo-demo-3.svg" class="h-30px" />
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

           


            <div class="card card-xl-stretch mb-5 mb-xl-8">
                <div class="row gy-5 g-xl-8 ">
                

                <div class="col-sm-4">
                    <form id="shift_form" method="POST" action="{{url('shift_hours_detail_data')}}" enctype="multipart/form-data">
                        @csrf
                    <div style="margin: 5px;" class=" form-control">
                        <label class=" fs-6 form-label fw-bolder text-dark">From-To</label>
                        <input name="from_to" class="form-control form-control-solid" placeholder="Pick date rage" id="kt_daterangepicker_1">
                    </div>
               
                </div>
                <div class="col-sm-2" style="margin-top:5%">
                    <div><button type="submit" class="btn btn-primary">Submit</button></div>
                </form>
                </div>
                <div class="col-sm-6">
                 
                   
                </div>
            </div>

            </div>



          



<div class="row gy-5 g-xl-8 ">
    <!-- <a href="{{url('shift_hours_detail')}}" > -->
    <div class="card card-xl-stretch mb-5 mb-xl-8" id="kt_chartjs_2">
    <canvas id="kt_chartjs_1" class="mh-400px"></canvas>
    </div>
    <!-- </a> -->
</div>
        	
                    <!--end::Charts Widget 5-->
                </div>

            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Content-->




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
    <script src="{{asset('')}}js/custom/shift_hour_detail.js"></script>

    <script src="{{asset('')}}js/custom/apps/chat/chat.js"></script>
    <script src="{{asset('')}}js/custom/modals/create-app.js"></script>
    <script src="{{asset('')}}js/custom/modals/upgrade-plan.js"></script>
    <!--end::Page Custom Javascript-->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <!--end::Javascript-->

    <script src="{{asset('')}}js/custom/documentation/charts/chartjs.js"></script>

        <script>
            	  $( document ).ready(function() {
                    $("#kt_daterangepicker_1").daterangepicker();

  });

  $("#shift_form").on('submit', function(e){
						     e.preventDefault();
						     console.log(this.id)
						     var data = $('#'+this.id).serialize();

						     $.ajax({type: "POST",url: this.action,data : data ,success: function(result){
                                if(result.range==true){
									Swal.fire({
													text: 'Date range must be less than a year !',
													icon: "warning",
													buttonsStyling: !1,
													confirmButtonText: "Ok, got it!",
													customClass: {
														confirmButton: "btn btn-light"
													}
						})
					}else{
                                // var grapharea = document.getElementById("kt_chartjs_1");
                                // // grapharea.destroy();
                                // // grapharea.clear();
                                // grapharea.empty();   


                                // document.getElementById('kt_chartjs_1').empty();
                                $('#kt_chartjs_1').html('')
                                var dash_shifts=result.shifts;
                                // console.log(dash_shifts);
                                // $('#kt_chartjs_2').html('')
                                $('#kt_chartjs_2').html('<canvas id="kt_chartjs_1" class="mh-400px"></canvas>')
	                            get_chart_shift_form(dash_shifts,result.hours,result.months);
//                                 var doc1 = document.getElementById("kt_chartjs_1");
// var ctx1 = doc1.getContext("2d");
// ctx1.destroy();
                    }
                                 }})

  });


            </script>

    @stop