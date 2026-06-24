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
    <!--end::Global Stylesheets Bundle-->
    <link href="{{asset('')}}plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css"/>



    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">


<style type="text/css">
tbody, td, tfoot, th, thead, tr {
    border-top: 1px solid #F1416D;
}
.sorting_asc{
background: none !important;
}
table.dataTable thead .sorting{
 background: none !important;
}
.text-dark{
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

.expand-button {
position: relative;
}

.accordion-toggle .expand-button:after
{
position: absolute;
left:.75rem;
top: 50%;
transform: translate(0, -50%);
content: '-';
}
.accordion-toggle.collapsed .expand-button:after
{
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
                <div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
                    <!--begin::Container-->
                    <div class="container d-flex align-items-center justify-content-between" id="kt_header_container">
                        <!--begin::Page title-->
                        <div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-2 pb-2 pb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
                            <!--begin::Heading-->
                            <h1 class="text-dark fw-bolder my-0 fs-2">Audit Report Page</h1>
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
                <div class=" content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Container-->
                    <div class="container" id="kt_content_container">

                    
                        <!--begin::Form-->
                       
                            <!--begin::Card-->
                            <div class="card " style="margin-bottom: 10px;">
                                    <div class="card-body">
                                    <div class="row">
                                                            <div class="col-sm-6">
                                                                <label class="fs-6 form-label fw-bolder text-dark">Select Date</label>
                                                                <div class="fv-row mb-10">
                                                                    <input type="search" class="form-control form-control-solid ps-10" name="search" id="kt_daterangepicker_1" placeholder="" value="{{isset($_POST['search']) ? $_POST['search'] : ''}}" onchange="$('#search_hidden').val($('#kt_daterangepicker_1').val())" />
                                                                    <input type="hidden" id="search_hidden" >
                                                                </div>
                                                                <!--end::Select-->
                                                            </div>
                                                            <!-- <div class="col-sm-6">
                                                                <label class="fs-6 form-label fw-bolder text-dark">Select Customer</label>
                                                                <div class="fv-row mb-10">
                                                                <select class="form-select" data-control="select2"  data-placeholder="Select" id="customer_name" name="customer_name"  onchange="getCustomerSiteData(this)">
                                                                    <option value="">Select</option>

                                                                    @foreach($customers as $result)
                                                                    <option value="{{$result->id}}">{{$result->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 ">
                                                                <label class="fs-6 form-label fw-bolder text-dark">Select Site </label>
                                                              <div class="fv-row mb-10">
                                                                  <select class="form-select specific_customer_sites" data-control="select2"  id="site" name="site" data-placeholder="Select" >
                                                                     
                                                                  </select>
                                                              </div>
                                                              </div> -->
                                                              <div class="col-sm-2" >
                                                                  <button type="button" onclick="get_audit_report()" style="margin-top:30px" class="btn btn-primary">Get Reports</button>
                                                              </div>
                                                        </div>
                                                        
                                                      
                                    </div>

                                </div>
                           
                            <!--end::Card-->
                        <!--end::Form-->
                            <!--begin::Toolbar-->
                                                <div class="card">
                                                        </br>
                                                    
                                                            <div class="row">
                                                                <div class="col-sm-6 " style="float:left;margin-left:10px">
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
                                                                        <input type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search" id="search" />
                                                                    </div>
                                                                    
                                                                </div>
                                                                

                                                    
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table  id="example" class="table table-responsive table-hover table-striped  gy-5 gs-7" style="width:100%">
                                                            <thead>
                                                                <tr class="fw-bold ">

                                                                      <th style="display:;">{{config('custom.guard')}} Name</th>
                                                                        <th style="display:;"> Date(Time)</th>
                                                                        <th style="display:;">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="example_body">
                                                                
                                                                                                      
                                                            </tbody>
                                                           
                                                        </table>




                                                    </div>
                                                </div>	
                        
                        <!--end::Tab Content-->
                    <!--end::Container-->
    
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
                                                
                                                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        
                            <span class="svg-icon svg-icon-2x">X</span>
                           </div>
                                                    <!--end::Close-->
                                                </div>
                                                <!--end::Modal header-->
                                                <!--begin::Modal body-->
                                                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                                    <!--begin::Form-->
                                                    <form id="export_user_form" class="form" action="" method="POST" enctype="multipart/form-data">
                                                @csrf

                                                        <!--begin::Input group-->
                                            
                                                        <!--end::Input group-->
                                                        <!--begin::Input group-->
                                                        <div class="fv-row mb-10">
                                                            <!--begin::Label-->
                                                            <label class="required fs-6 fw-bold form-label mb-2">Select Export Format:</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <select name="format" data-control="select2" data-placeholder="Select a format" data-hide-search="true" class="form-select form-select-solid fw-bolder" id="format">
                                                                <option></option>
                                                                <!-- <option value="excel">Excel</option> -->
                                                                <option value="pdf">PDF</option>
                                                                <option value="excel">Excel</option>
                                                                <option value="csv">CSV</option>
                                                            </select>
                                                            <!--end::Input-->
                                                        </div>
                                                        <!--end::Input group-->
                                                        <!--begin::Actions-->
                                                        <div class="text-center">
                                                            <button type="reset" class="btn btn-white me-3" data-kt-users-modal-action="cancel">Discard</button>
                                                            <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                                                                <span id="form_submit" class="indicator-label">Submit</span>
                                                                <span class="indicator-progress">Please wait...
                                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
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
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

    <!-- <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> -->
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>

<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script> -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>



    <script >
   
        $(document).ready(function() {
            $("#kt_daterangepicker_1").daterangepicker({
                        locale: {
                            format: 'DD/MM/YYYY'
                        }
                    });
            var customerId='';
            oTable = $('#example').DataTable();
  
            });

            $('#search').keyup(function(){
      oTable.search($(this).val()).draw() ;
})

$("#export_user_form").on('submit', function(e){

                         var format =$('#format').val();

                         if(format == "pdf")
                         {

                             $(".buttons-pdf ").click()
                         }
                           if(format == "excel")
                         {
                             console.log('excel');

                             $(".buttons-excel").click()
                         }
                           if(format == "csv")
                         {
                             console.log('csv');

                             $(".buttons-csv").click()
                         }
                           if(format == "copy")
                         {
                             console.log('copy');

                             $(".buttons-copy").click()
                         }
                         e.preventDefault();

                    

});





function getCustomerSiteData(customerId) {
customerId=customerId.value;
$.ajax({
    type: "POST",
    data: {
        _token  : '<?php echo csrf_token() ?>',
        customerId:customerId
    },
    url:' {{url("/task/get_customers_jobs_list")}}',
    success: function(result) {
            siteData = "";
            var siteData2 = '<option></option>';
            $.each(result, function(index, value) {
                siteData2 += '<option value="' + value.jobId + '">' + value.site_name +
                ' ( ' + value.site_description +
                ')</option>';
            });
                $("#site").html(siteData2);
        }
    });
}
function get_audit_report(){
    var customer_id=$("#customer_name").val();
    var site_id=$("#site").val();
    var date=$('#search_hidden').val();
    
$.ajax({type: "POST",url:"{{url('report/get_audit_report/')}}",data:{customer_id:customer_id,site_id:site_id,date:date, _token :'<?php echo csrf_token() ?>'},success: function(result){
    console.log(result);
    $('#example').DataTable().clear().destroy();
var list= ' ';
$.each(result, function(id, data){
if(data.guard_name==null ||  data.guard_name=='' ){
data.job_end="N/A";
}
            list += '<tr>';
            list += '<td style="display:;">'+data.guard_name+'</td>';
            list += '<td style="display:;">'+data.created_at +'</td>';
            list += '<td style="display:"><a target="__blank" href="{{url('guard/audit_report_pdf')}}/'+data.id+'" >Download</a></td>';
            list += '</tr>';
                });
                $('#example_body').html(list);

              $('#example').DataTable({
                    responsive: true,
                    retrieve: true,
                    })

}
});

}
	</script>



@stop