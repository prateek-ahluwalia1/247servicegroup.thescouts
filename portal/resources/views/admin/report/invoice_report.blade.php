@extends('layout.app')
@extends('layout.sidebar')
@extends('layout.footer')

@section('pageCss')
<base href="../../../">
<meta charset="utf-8" />
<title>{{ config('custom.title');}}</title>
<meta name="keywords"
content="{{ config('custom.title')}}" />
<link rel="canonical" href="Https://preview.keenthemes.com/metronic8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<!-- <link rel="shortcut icon" href="{{asset('')}}media/logos/favicon.ico" /> -->
<!--begin::Fonts-->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700" />
<!--end::Fonts-->
<!--begin::Global Stylesheets Bundle(used by all pages)-->
<link href="{{asset('')}}plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
<link href="{{asset('')}}css/style.bundle.css" rel="stylesheet" type="text/css" />
<!--end::Global Stylesheets Bundle-->
<link href="{{asset('')}}plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />



<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"> -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"> -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.css" />

<style type="text/css">
    tbody,
    td,
    tfoot,
    th,
    thead,
    tr {
        border-top: 1px solid #F1416D;
    }

    .sorting_asc {
        background: none !important;
    }

    table.dataTable thead .sorting {
        background: none !important;
    }

    .text-dark {
        margin-top: 2px;
    }

    td.details-control {
        background: url('{{asset('')}}media/icons/duotone/Navigation/Angle-right.svg') no-repeat center center;
            cursor: pointer;
        }

        tr.shown td.details-control {
            background: url('{{asset('')}}media/icons/duotone/Navigation/Angle-right.svg') no-repeat center center;
            }

            /*expand*/
            tr.hide-table-padding td {
                padding: 0;
            }

            td.details-control {
                background: url('{{asset('media/icons/details_open.png')}}') no-repeat center center;
    cursor: pointer;
}

tr.shown td.details-control {
    background: url('{{asset('media/icons/details_close.png')}}') no-repeat center center;
}

.expand-button {
    position: relative;
}

.accordion-toggle .expand-button:after {
    position: absolute;
    left: .75rem;
    top: 50%;
    transform: translate(0, -50%);
    content: '-';
}

.accordion-toggle.collapsed .expand-button:after {
    content: '+';
}
</style>


@stop
<!--end::Head-->
<!--begin::Body-->
@section('content')

@section('content')

<!--begin::Form-->
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
        <h1 class="text-dark fw-bolder my-0 fs-2">{{strtoupper($report_type)}} Report</h1>
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
    <a href="index.html" class="d-flex align-items-center">
        <!-- <img alt="Logo" src="{{config('custom.logo')}}" class="h-30px" /> -->
    </a>
    <!--end::Logo-->
</div>
@include('layout.toolbar')
@yield('toolbar')
</div>
<!--end::Container-->
</div>
<!--begin::Content-->
<div class=" content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Container-->
    <div class="container" id="kt_content_container">
        <!--begin::Card-->
        <form id="search-form" class="form" action="{{url('report/generate_invoice_report')}}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <!--begin::Card-->
        <input type="hidden" value="" name="type_of_export" id="type_of_export"/>
        <div class="card mb-7">
            <!--begin::Card body-->
            <div class="card-body">
                <!--begin::Compact form-->
                <div class="d-flex align-items-center">
                    <div class="row">
                        <!--begin::Input group-->
                        <div class="position-relative w-md-400px me-md-2 col">
                            <label class="fs-6 form-label fw-bolder text-dark">From - To</label>
                                    <!-- <input type="search" class="form-control form-control-solid ps-10" name="search" id="kt_daterangepicker_1" placeholder="" value="" />
                                        <input type="hidden" id="search_hidden" value=""> -->
                                        <input name="search" class="form-control form-control-solid"
                                        placeholder="Pick date rage" id="kt_daterangepicker_1" />
                                    </div>
                                    <!--end::Input group-->
                                    <div class="position-relative w-md-400px me-md-2 col">
                                        <label class="fs-6 form-label fw-bolder text-dark">Select Customer</label>
                                        <!-- <select   class="form-select form-select-solid" data-control="select2" data-placeholder="Select Customer"  id="customer_id" name="customer_id[]" onchange="customer_sites()"> -->
                                            <select multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1"  multiple="multiple" id="customer_id" name="customer_id[]" onchange="customer_sites()">
                                                <!-- <option value="">Select</option> -->
                                                @foreach($customers as $result)
                                                <option value="{{$result->id}}">{{$result->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="position-relative w-md-400px me-md-2 col" id="div_inactive">
                                            <label class="fs-6 form-label fw-bolder text-dark">Select 
                                            Sites</label>
                                            <div class="fv-row mb-10"><select multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1"  multiple="multiple"
                                                id="sites" name="sites[]" data-control="select2"
                                                data-placeholder="Select a site" onchange="site_guards()">
                                            </select>
                                        </div>
                                    </div> 

                                    <div class="position-relative w-md-400px me-md-2 col" id="div_guards">
                                        <label class="fs-6 form-label fw-bolder text-dark">Select 
                                        {{config('custom.guard')}} </label>
                                        <div class="fv-row mb-10"><select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1"
                                            id="guards" name="guards[]" data-control="select2"
                                            data-placeholder="Select a site">
                                        </select>
                                    </div>
                                </div> 

                            </div>
                            <!--begin:Action-->
                                <!-- <div class="d-flex align-items-center">
                                    <a id="kt_horizontal_search_advanced_link" class="btn btn-link" >Advanced Search</a>
                                </div>
                            -->
                            <!--end:Action-->
                        </div>
                        <!--end::Compact form-->
                        
                        <!--end::Compact form-->
                        <!--begin::Advance form-->
                        <div style="display:" id="kt_advanced_search_form">
                            <!--begin::Separator-->
                            <div class="separator separator-dashed mt-9 mb-6"></div>
                            <!--end::Separator-->
                            <!--begin::Row-->
                            <div class="row ">
                                <!--begin::Col-->
                                <div class="col-lg-6 ">
                                    <label class="fs-6 form-label fw-bolder text-dark">Select State</label>
                                    <div class="fv-row mb-10">
                                        @if(config('custom.shift_po') == 0)
                                        <select class="form-select form-select-lg form-select-solid _ac-customer-change" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true"
                                        id="state" name="state" >
                                        @else
                                        <select multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1"  multiple="multiple"
                                        id="state" name="state" >
                                        @endif
                                        <option value="Victoria" >Victoria</option>
                                        <option value="New South Wales">NSW</option>
                                        <option value="Queensland">Queensland</option>
                                        <option value="Tasmania">Tasmania</option>
                                        <option value="Western Australia">Western Australia</option>
                                        <option value="South Australia">South Australia</option>
                                        <option value="ACT">ACT</option>
                                    </select>
                                </div>
                            </div>

                             <div class="col-lg-6 ">
                                    <label class="fs-6 form-label fw-bolder text-dark">Select Type</label>
                                    <div class="fv-row mb-10">
                                        <select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true"
                                        id="type" name="type" >
                                        <option value="normal" >Normal</option>
                                        <option value="divide">Divide</option>
                                    </select>
                                </div>
                            </div>


                        </div>
                    </form>

                    <div class="row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-2">
                            <input type="button" onclick="invoice_report_data(this)" id="excel-btn" value="Excel"  class="btn btn-success me-5" disabled="" />
                        </div>
                                        <!-- <div class="col-sm-2">
                                            <input type="button" onclick="invoice_report_data(this)" value="pdf" class="btn btn-primary me-5"/>
                                        </div> -->
                                        <div class="col-sm-4"></div>

                                        <br>
                                        <br>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        {{-- <button type="submit" class="btn btn-primary me-5">Search</button> --}}
                                        <!-- <a id="kt_horizontal_search_advanced_link" class="btn btn-link">Advanced Search</a>  -->
                                    </div>
                                    <!--end::Row-->

                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Advance form-->
                    <!--end::Card body-->
                    <!--end::Card-->
                    <div class="modal fade" id="kt_modal_export_users" tabindex="-1" aria-hidden="true">
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

                                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                                    aria-label="Close">

                                    <span class="svg-icon svg-icon-2x">X</span>
                                </div>
                                <!--end::Close-->
                            </div>
                            <!--end::Modal header-->
                            <!--begin::Modal body-->
                            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                <!--begin::Form-->
                                <form id="export_user_form" class="form" action="" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <!--begin::Input group-->

                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="fv-row mb-10">
                                    <!--begin::Label-->
                                    <label class="required fs-6 fw-bold form-label mb-2">Select Export Format:</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select name="format" data-control="select2" data-placeholder="Select a format"
                                    data-hide-search="true" class="form-select form-select-solid fw-bolder"
                                    id="format">
                                    <option></option>
                                    <!-- <option value="excel">Excel</option> -->
                                    <option value="pdf">PDF</option>
                                    <option value="excel">Excel</option>
                                    <!-- <option value="csv">CSV</option> -->
                                </select>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Actions-->
                            <div class="text-center">
                                <button type="reset" class="btn btn-white me-3"
                                data-kt-users-modal-action="cancel">Discard</button>
                                <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                                    <span id="form_submit" class="indicator-label">Submit</span>
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

            <script src="{{asset('')}}js/custom/widgets.js"></script>
            <script src="{{asset('')}}js/custom/apps/chat/chat.js"></script>
            <script src="{{asset('')}}js/custom/modals/create-app.js"></script>
            <script src="{{asset('')}}js/custom/modals/upgrade-plan.js"></script>
            <script src="{{asset('')}}plugins/global/plugins.bundle.js"></script>


            <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
            <!-- <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> -->
            <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.js"></script>


            <!-- <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> -->
            <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
            <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>

            <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script> -->
            <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js">
            </script>



            <script>
                $(document).ready(function () {
                    $("#kt_daterangepicker_1").daterangepicker({
                        locale: {
                            format: 'DD/MM/YYYY'
                        }
                    });
                    MultiselectDropdown(window.MultiselectDropdownOptions);
                    site_guards();
                })
                function invoice_report_data(e){
                    // console.log($(e).val());
                    $('#type_of_export').val($(e).val());
                    if($(e).val() == "Excel" ){
                        // $("#search-form").submit();
                        var date=$('#kt_daterangepicker_1').val();
                        var customer_id=$('#customer_id').val();
                        var state=$('#state').val();
                        var sites=$('#sites').val();
                        var guards=$('#guards').val();
                        var url = "{{url('report/generate_invoice_report/')}}?customer_id="+customer_id+"&date="+date+'&type=excel&state='+state+'&sites='+sites+'&report_type={{$report_type}}&guards='+guards+'&data_type='+$('#type').val()
                        window.open(url,'_blank');
                    }else{
                        var date=$('#kt_daterangepicker_1').val();
                        var customer_id=$('#customer_id').val();
                        var url = "{{url('report/generate_invoice_report/')}}?customer_id="+customer_id+"&date="+date+'&type=pdf&report_type={{$report_type}}&guards='+guards+'&data_type='+$('#type').val()
                        window.open(url,'_blank');	
                    }

                }
                $("#search-form").on('submit', function(e){
                 e.preventDefault();
     // console.log(this.id);
	//  console.log(html_bb);
                 var data = $('#'+this.id).serialize();

                 $.ajax({type: "POST",url: this.action,data :data ,success: function(result){if(result.success){
     	// $('#operation_notes_modal').modal('hide');

                     Swal.fire({
                         text: "Your file downloaded Succesfully",
                         icon: "success",
                         buttonsStyling: !1,
                         confirmButtonText: "Ok, got it!",
                         customClass: {
                          confirmButton: "btn btn-light"
                      }
                  })
                 }else{Swal.fire({
                   text: "select all fields",
                   icon: "error",
                   buttonsStyling: !1,
                   confirmButtonText: "Ok, got it!",
                   customClass: {
                    confirmButton: "btn btn-light"
                }
            })}}})

             });

                function customer_sites(){
                   $('#div_inactive').html('');
                   var customer_id = $('#customer_id').val();
                   if (customer_id == '') {
                    $('#excel-btn').attr('disabled', '')
                }else{
                    $('#excel-btn').removeAttr('disabled')
                }
                var date = $('#kt_daterangepicker_1').val();
             var state = $('#state').val();

                $.ajax({
                   type: "POST",
                   url: "{{url('report/customer_sites')}}",
                   data: {
                       customer_id: customer_id,
                     // date:date,
                       _token: "<?php echo csrf_token();?>"
                   },
                   success: function (result) {
                       var inactive_site = `<label  class="fs-6 form-label fw-bolder text-dark">Select Sites</label>
                       <div  class="fv-row mb-10"><select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1" id="sites" name="sites[]" data-control="select2" data-placeholder="Select an option" onchange="site_guards()">`;
                       $.each(result, function (id, data) {
                           inactive_site += `<option value="${data.job_id}">${data.site_name}(${data.site_description})</option>`;
                       })
                       inactive_site += '</select></div>';
                     $('#state').attr('multiple', false);
                       $('#customer_id').attr('multiple', false);
                       $('#div_inactive').html(inactive_site);
                       $('#div_guards').html(`<label class="fs-6 form-label fw-bolder text-dark">Select 
                        {{config('custom.guard')}}</label
                        <div class="fv-row mb-10"><select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1"
                        id="guards" name="guards[]" data-control="select2"
                        data-placeholder="Select a guard"></select></div>`);
                       MultiselectDropdown();
                       $('#customer_id').attr('multiple', true);
                       '<?php if(config("custom.shift_po") == 1){ ?>'
                     $('#state').attr('multiple', true);
                     $('#state').val(state);
                     '<?php } ?>'
                       $('#customer_id').val(customer_id);
                       site_guards();


                   }
               })
            };


            function site_guards(){
             var customer_id = $('#customer_id').val();
             var sites = $('#sites').val();
             var state = $('#state').val();

             $.ajax({
                 type: "POST",
                 // url: "{{url('report/site_guards')}}",
                 url: "{{url('job_tracker/get_customers_guards_list_filter')}}",
                 data: {
                     // sites: sites,
                     // date:date,
                     _token: "<?php echo csrf_token();?>",
                     status : 'active',
                     state : '',
                     customer_id : $('#customer_id').val()
                 },
                 success: function (result) {
                     var inactive_site = `<label class="fs-6 form-label fw-bolder text-dark">Select 
                     {{config('custom.guard')}}</label
                     <div class="fv-row mb-10"><select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1"
                     id="guards" name="guards[]" data-control="select2"
                     data-placeholder="Select a guard">`;
                     $.each(result.guards, function (id, data) {
                         inactive_site += `<option value="${data.guard_id}">${data.guard_name}</option>`;
                     })
                     inactive_site += '</select></div>';
                     $('#customer_id').attr('multiple', false);
                     $('#state').attr('multiple', false);
                     $('#sites').attr('multiple', false);
                     $('#div_guards').html(inactive_site);
                     MultiselectDropdown();
                     $('#customer_id').attr('multiple', true);
                     $('#sites').attr('multiple', true);
                     $('#customer_id').val(customer_id);
                     $('#sites').val(sites);
                       '<?php if(config("custom.shift_po") == 1){ ?>'
                     $('#state').attr('multiple', true);
                     $('#state').val(state);

                       '<?php } ?>'


                 }
             })
         };


     </script>