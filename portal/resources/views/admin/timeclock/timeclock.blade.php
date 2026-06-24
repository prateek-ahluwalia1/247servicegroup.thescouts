@extends('layout.app') @extends('layout.sidebar') @extends('layout.footer') 

@section('pageCss')
@include('admin.timeclock.today_sheet')
<!-- @include('admin.timeclock.timesheet') -->
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
<link href="{{asset('')}}plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css"> 
<!-- <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script> -->
<script src="https://unpkg.com/@google/markerclustererplus@4.0.1/dist/markerclustererplus.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.css"/>

<style type="text/css">
/* .sorting_asc{
	background: none !important;
} */	
tbody, td, tfoot, th, thead, tr {
    border-top: 1px solid #F1416D;
}
.redClass{
	color: red !important;
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
#example_filter{
	float: left !important;
}
#example_filter > label{
	display: no
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
.text-dark{
	margin-top: 2px;
}
td { cursor: pointer; }

.text-dark {
	margin-top: 2px;
}

#map2 {
	height: 100%;
}
.img-responsive{
	height:50% !important;
	width: 50% !important;
}

.map-container {
	overflow: hidden;
	/* padding-bottom:56.25%; */
	position: relative;
	height: 0;
}

.map-container iframe {
	left: 0;
	top: 0;
	height: 100%;
	width: 100%;
	position: absolute;
}


/* Optional: Makes the sample page fill the window. */
</style> 
@stop
<!--end::Head-->
<!--begin::Body-->@section('content') @section('content')
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
				<h1 class="text-dark fw-bolder my-0 fs-2">Time Clock</h1>
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
				<a href="index.html" class="d-flex align-items-center"> <img alt="Logo" src="{{config('custom.logo')}}" class="h-30px" /> </a>
				<!--end::Logo-->
			</div>
			<!--end::Wrapper-->@include('layout.toolbar') @yield('toolbar') </div>
		<!--end::Container-->
	</div>
	<!--end::Header-->
	<!--begin::Content-->
	<div class=" content d-flex flex-column flex-column-fluid" id="kt_content">
		<!--begin::Container-->
		<div class="container" id="kt_content_container">
			<!--begin::Form-->
			<form id="search-form" class="form" action="{{url('timesheet_search')}}" method="POST" enctype="multipart/form-data" style="display: none;"> @csrf
				<!--begin::Card-->
				<div class="card mb-7">
					<!--begin::Card body-->
					<div class="card-body">
						<!--begin::Compact form-->
						<div class="d-flex align-items-center">
							<!--begin::Input group-->
							<div class="row">
								<div class="col-sm-6" style="float: left">
									<div class="position-relative w-md-400px me-md-2">
										<!--begin::Svg Icon | path: icons/duotone/General/Search.svg--><span class="svg-icon svg-icon-3 svg-icon-gray-500 position-absolute top-50 translate-middle ms-6">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                        <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero" />
                                                    </g>
                                                </svg>
                                            </span>
										<!--end::Svg Icon-->
										<input type="search" class="form-control form-control-solid ps-10" name="search" id="search" placeholder="Search" /> </div>
								</div>
							</div>
							{{-- <div class="col-sm-6" style="text-align: end;margin-top:3%">
								<div class="nav-group  d-inline-flex mb-15" data-kt-buttons="true" style="border: 1px "> <a class="nav-link btn btn-color-gray-600 btn-active btn-active-primary px-6 py-3 me-2 active" data-kt-plan="Today"><strong class="text-center" >Today</strong></a> 
									<a class="nav-link btn btn-color-gray-600 btn-active btn-active-primary px-6 py-3" data-kt-plan="Timesheets"><strong class="text-center" >Timesheets</strong></a> </div>
							</div> --}}
							<!--end::Input group-->
							<!--begin:Action-->
							<!--end:Action-->
						</div>
						<!--end::Compact form-->
					</div>
					<!--end::Card body-->
				</div>
				<!--end::Card-->
			</form>
			<!--end::Form-->
			<!--begin::Toolbar-->
			<div class="card">
				
                <div class="row">
                    <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6 nav-stretch  nav-fill nav-line-tabs-2x border-transparent fs-5 fw-bolder flex-nowrap">
                        <li></li>
						<li class="nav-item">
                            <a class="nav-link  nav-pills   text-active-primary " id="today" href="{{url('timeclock?status=today')}}"><strong class="text-center" style="font-size: 22px;margin-left:40%" ><img src="https://img.icons8.com/ultraviolet/20/000000/today.png"/>&nbsp Today</strong></a>
                        </li>
                        <!-- <li class="nav-item">
                            <a  class="nav-link nav-pills text-active-primary " id="timesheet"  href="{{url('timeclock?status=timesheet')}}"><strong class="text-center"  style="font-size: 22px;margin-left:40%" >
								<img src="https://img.icons8.com/office/20/000000/property-time.png"/>&nbsp Timesheet</strong></a>
                        </li> -->
						
					</ul>
                </div>
		
				<div class="row">
				
					<div class="col-sm-12" style="float:right;text-align: end;margin-top:4px;">
						<button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_export_users">
							<!--begin::Svg Icon | path: icons/duotone/Files/Export.svg--><span class="svg-icon svg-icon-2">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                                <rect x="0" y="0" width="24" height="24" />
                                                                                <path d="M17,8 C16.4477153,8 16,7.55228475 16,7 C16,6.44771525 16.4477153,6 17,6 L18,6 C20.209139,6 22,7.790861 22,10 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,9.99305689 C2,7.7839179 3.790861,5.99305689 6,5.99305689 L7.00000482,5.99305689 C7.55228957,5.99305689 8.00000482,6.44077214 8.00000482,6.99305689 C8.00000482,7.54534164 7.55228957,7.99305689 7.00000482,7.99305689 L6,7.99305689 C4.8954305,7.99305689 4,8.88848739 4,9.99305689 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,10 C20,8.8954305 19.1045695,8 18,8 L17,8 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                                                <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 8.000000) scale(1, -1) rotate(-180.000000) translate(-12.000000, -8.000000)" x="11" y="2" width="2" height="12" rx="1" />
                                                                                <path d="M12,2.58578644 L14.2928932,0.292893219 C14.6834175,-0.0976310729 15.3165825,-0.0976310729 15.7071068,0.292893219 C16.0976311,0.683417511 16.0976311,1.31658249 15.7071068,1.70710678 L12.7071068,4.70710678 C12.3165825,5.09763107 11.6834175,5.09763107 11.2928932,4.70710678 L8.29289322,1.70710678 C7.90236893,1.31658249 7.90236893,0.683417511 8.29289322,0.292893219 C8.68341751,-0.0976310729 9.31658249,-0.0976310729 9.70710678,0.292893219 L12,2.58578644 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 2.500000) scale(1, -1) translate(-12.000000, -2.500000)" />
                                                                            </g>
                                                                        </svg>
                                                                    </span>
							<!--end::Svg Icon-->Export</button>
					</div>
				</div>
                <div class="tab-content card-body pt-0  ">
					@if(request()->get('status')=='today')
                    @yield('today_sheet')
					@else
                    @yield('timesheet')
					@endif
                 
                 </div>


			
             </div>
			 <div style="height:5%" class="row g-5 g-xl-8">
			 </div>
			<div class="row g-5 g-xl-8">
				<!--begin::Col-->
				<div class="col-xl-6" style="display: none;">
					<!--begin::Tables Widget 1-->
					<div class="card card-xl-stretch mb-xl-8">
						<!--begin::Header-->
						<div class="card-header border-0 pt-5">
							<h3 class="card-title align-items-start flex-column">
                                                                    <span class="card-label fw-bolder fs-3 mb-1">Shift Details</span>
                                                                    <span class="text-muted fw-bold fs-7"></span>
                                                                </h3> </div>
						<!--end::Header-->
						<!--begin::Body-->
						<div id="shift_detail" class="card-body py-3">
								<!--begin::Card body-->
							
								<!--end::Card body-->
							</div>
							<!--end::Table container-->
					</div>
					<!--endW::Tables Widget 1-->
				</div>
				<!--end::Col-->
				<!--begin::Col-->
				<div class="col-xl-12">
					<!--begin::Tables Widget 1-->
					<div class="card card-xl-stretch mb-xl-8">
						<div id="map-container-google-1" class="z-depth-1-half map-container" style="height: 500px">
							<div id="map2"></div>
						</div>
						<!--endW::Tables Widget 1-->
					</div>
					<!--end::Col-->
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
								<h2 class="fw-bolder">Export</h2>
								<!--end::Modal title-->
								<!--begin::Close-->
								<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close"> <span class="svg-icon svg-icon-2x">X</span> </div>
								<!--end::Close-->
							</div>
							<!--end::Modal header-->
							<!--begin::Modal body-->
							<div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
								<!--begin::Form-->
								<form id="export_user_form" class="form" action="" method="POST" enctype="multipart/form-data"> @csrf
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
											<option value="copy">Copy</option>
											<option value="csv">CSV</option>
										</select>
										<!--end::Input-->
									</div>
									<!--end::Input group-->
									<!--begin::Actions-->
									<div class="text-center">
										<button type="reset" class="btn btn-white me-3" data-kt-users-modal-action="cancel">Discard</button>
										<button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit"> <span id="form_submit" class="indicator-label">Submit</span> <span class="indicator-progress">Please wait...
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
				</div> @stop @section('pageFooter')
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
				<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
				<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
				<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
				<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
				<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
				<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
				<!-- <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.js"></script> -->

				<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script> -->
				<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script> {{--
				<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap&v=weekly" async></script>
				 --}}
		
				<script>
				var loc=[];
				// var map_images=['https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQn7FxcackzavRQ31C4qnqJxBgg759EvQOpNg&usqp=CAU','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT-u44KYXbCYLzrclIPU5Ylev_kL3aFZA_Sbg&usqp=CAU'];
				var table = $('#example').DataTable();
				$(document).ready(function() {
					// initMap();
					$('#example').DataTable();
					$('#example_filter').hide();
					$('.dt-buttons').hide();
					$("#kt_daterangepicker_1").daterangepicker();
					$("#search").on("input", function(e) {
						e.preventDefault();
						$('#example').DataTable().search($(this).val()).draw();
					});

					@if(request()->get('status')=='today')
					$('#today').addClass("active");
					today();
					// setInterval(function(){ today(); }, 1000);
					// setTimeout(function(){ initMap(); }, 6000);
					@else
					$('#timesheet').addClass("active");
					// timesheet();
					@endif
				});

				</script>

				<script>
					function format ( d ) {
						var color_class = '';
						if (d.color == 'red') {
							color_class = 'redClass';
						}
						var signin_selfie = '';
						var signout_selfie = '';
						if (d.signin_selfie == null || d.signin_selfie == 'null') {
							signin_selfie = "{{asset('')}}media//avatars/blank.png";
						}else{
							signin_selfie = "{{config('custom.asset_url')}}"+d.signin_selfie;
						}
						if (d.signout_selfie == null || d.signout_selfie == 'null') {
							signout_selfie = "{{asset('')}}media//avatars/blank.png";
						}else{
							signout_selfie = "{{config('custom.asset_url')}}"+d.signout_selfie;
						}
    // `d` is the original data object for the row
    return '<table class="table table-responsive table-hover table-striped  gy-5 gs-7" cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
    '<tr class="fw-bold ">'+
            '<th>Signin Selfie</th>'+
            '<th>Signout Selfie</th>'+
            '<th>Signin notes</th>'+
            '<th>Signout notes</th>'+
            '<th>Site Name</th>'+
            '<th>Site Description</th>'+
        '</tr>'+
        '<tr class="'+color_class+'">'+
            '<td class="fw-bold "><img class="img-responsive" src="'+signin_selfie+'" alt="image"></td>'+
            '<td><img class="img-responsive" src="'+signout_selfie+'" alt="image"></td>'+
            '<td>'+d.signin_notes+'</td>'+
            '<td>'+d.signout_notes+'</td>'+
            '<td>'+d.site_name+'</td>'+
            '<td>'+d.site_description+'</td>'+
        '</tr>'+    
    '</table>';
}
var openRows = new Array();
function closeOpenedRows(table, selectedRow) {
    $.each(openRows, function (index, openRow) {
        // not the selected row!
        if ($.data(selectedRow) !== $.data(openRow)) {
            var rowToCollapse = table.row(openRow);
            rowToCollapse.child.hide();
            openRow.removeClass('shown');
            // replace icon to expand
            $(openRow).find('td.details-control').html('<span class="glyphicon glyphicon-plus"></span>');
            // remove from list
            var index = $.inArray(selectedRow, openRows);
            openRows.splice(index, 1);
        }
    });
}

					function today(){
						$.ajax({type:"POST",url:"{{url('timeclock/today')}}",data:{_token:"<?php echo csrf_token();?>"},success:function(result){
							// console.log(result);
							$('#example1').DataTable().destroy();
								var list = '';
								var table = $('#example1').DataTable( {
									data : result.data,
									dom: 'Bfrtip',
									buttons: [
										'copyHtml5',
										'excelHtml5',
										'csvHtml5',
										{
									extend: 'pdfHtml5',
									// orientation: 'landscape',
									pageSize: 'A4'
								}						
								],
									createdRow : function( row, data, dataIndex){
                if( data['color'] ==  `red`){
					// console.log(data['color'])

                    $(row).addClass('redClass');
                }
            },
			        				columns: [
						            {
						                "className":      'details-control',
						                "orderable":      false,
						                "data":           null,
						                "defaultContent": ''
						            },
						            { "data": "state"},
						            { "data": "guard_name"},
						            { "data": "temp_date"},
						            { "data": "temp_start"},
						            { "data": "temp_end"},
						            { "data": "green_call_120"},
						            { "data": "green_call_30"},
						            { "data": "signin_time_2"},
						            { "data": "break_start_time"},
						            { "data": "break_end_time"},
						            { "data": "signout_time_2"},
						            { "data": "hours" }
						        ],
			        			order: [[1, 'asc']],
									// responsive: true,
									// retrieve: true,
									// searching: true,
									
			    				} );
								$('#example_filter').hide();
					$('.dt-buttons').hide();
			    				$('#example1 tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
        	closeOpenedRows(table, tr);
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');

            openRows.push(tr);
        }
    });
								loc=result.locations;
							
										setTimeout(function(){ initMap(); }, 4000);


						}
						});
						
					}

					function timesheet(){
						$.ajax({type:"POST",url:"{{url('timeclock/timesheet')}}",data:{_token:"<?php echo csrf_token();?>"},success:function(result){
							// console.log(result);
							$('#example').DataTable().destroy();
								var list = '';
							 $.each(result, function(id, data){
								var signin_time=data.signin_time_2;
								 var signout_time=data.signout_time_2;
							 if(signin_time!=null){
								   }
								   else{
									signin_time='N/A';
										}
							if(signout_time!=null){
								   }
								   else{
									signout_time='N/A';
									   }
									   list += `<tr onclick='append_shift_detail("${data.signin_selfie}","${data.signout_selfie}","${data.signout_notes}","${data.signin_notes}","${data.signin_time}","${data.signout_time}")' style="color:${data.color}">`;
							   list += '<td>'+data.state+'</td>';
							   list += '<td>'+data.address+' </td>';
							   list += '<td >'+data.guard_name+'</td>';
							   list += '<td>'+data.guard_type+'</td>';
							   list += '<td>'+data.customer_name+'</td>';
							   list += '<td>'+data.temp_date+'</td>';
							   list += '<td>'+data.temp_start+'</td>';
							   list += '<td>'+data.temp_end+'</td>';
							   list += '<td>'+signin_time+'</td>';
							   list += '<td>'+signout_time+'</td>';
							//    list += '<td>'+data.travel_time+'</td>';
							   list += '<td>'+data.hours+'</td>';
							   // list += '<td>'+data.hours+'</td>';
							   // list += '<td>'+data.hours+'</td>';
						 

							   list += '</tr>';
						   });
										$('#example_body').html(list);
										$('#example').DataTable({
						   "ordering": false,
						   "pageLength": 25,
						   dom: 'Blrtip',
						   buttons: [],
										});
										initMap();

						}})
					}

					function append_shift_detail(signin_selfie,signout_selfie,signout_notes,signin_notes,signin_time,signout_time){
						html='';
						html+=`	<div class="card-body d-flex flex-center flex-column pt-12 p-9">
									<!--begin::Avatar-->
									<div class="row">
										<div style="float:left" class="col-sm-6">
											
											<div class=" symbol-circle mb-5">
											${(signin_selfie!=null && signin_selfie!='null' && signin_selfie!='')?`<img class="img-responsive" src="{{config('custom.asset_url')}}${signin_selfie}" alt="image"><br>`:`<img class="img-responsive" src="{{asset('')}}media//avatars/blank.png" alt="image"><br>`}
												
												<a class=" text-gray-800 text-hover-primary fw-bolder text-center">Signin Selfie </a>
											</div>
										</div>
										<div style="float:right" class="col-sm-6">
											<div class=" symbol-circle mb-5">
												${(signout_selfie!=null && signout_selfie!='null' && signout_selfie!='' )?`<img class="img-responsive"  src="{{config('custom.asset_url')}}${signout_selfie}" alt="image"><br>`:`<img class="img-responsive"  src="{{asset('')}}media//avatars/blank.png" alt="image"><br>`}
												<a class=" text-gray-800 text-hover-primary fw-bolder text-center nowrap">Signout Selfie  </a>
											</div>
										</div>
									</div>
									
									<!--end::Name-->
									<!--begin::Position
									 d-flex flex-center flex-wrap
									-->
									<div class="w-100">
										<div class="notice d-flex bg-light-primary rounded border-primary border border-dashed p-6">
											<!--begin::Wrapper-->
											<div class="d-flex flex-stack flex-grow-1">
												<!--begin::Content-->
												<div class="fw-bold">
													<div class="fs-6 text-gray-600">
													<a  class="fw-bolder me-1">Signin Time: ${(signin_time!=null && signin_time!='null' && signin_time!='') ? `${signin_time}`: `N/A`}</a></div><br>
													<div class="fs-6 text-gray-600">
													<a  class="fw-bolder me-1">Signin Notes: ${(signin_notes!=null && signin_notes!='null' && signin_notes!='' &&  signin_notes!='undefined') ? `${signin_notes}`: `N/A`}</a></div><br>
													<div class="fs-6 text-gray-600">
													<a  class="fw-bolder me-1">Signout Time: ${(signout_time!=null && signout_time!='null' && signout_time!='') ? `${signout_time}`: `N/A`}</a></div><br>
													<div class="fs-6 text-gray-600">
													<a  class="fw-bolder me-1">Signout Notes: ${(signout_notes!=null && signout_notes!='null' && signout_notes!='' && signout_notes!='undefined') ? `${signout_notes}`:`N/A`}</a></div>
												</div>
												<!--end::Content-->
											</div>
											<!--end::Wrapper-->
										</div>
									</div>
									<!--end::Info-->
								</div>`;
								$('#shift_detail').html(html);
					}
				</script>
						<script>
				function initMap() {
					const locations = loc;
				console.log(loc);
					const map = new google.maps.Map(document.getElementById("map2"), {
						zoom: 3,
						center: {
							lat: -28.024,
							lng: 140.887
						},
					});
					const labels = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
					const markers = locations.map((location, i) => {
						return new google.maps.Marker({
							styles: styles,
   							clusterClass: "custom-clustericon",
							position: location,
							label: labels[i % labels.length],
							icon:''
						});
					});
					// Add a marker clusterer to manage the markers.
					new MarkerClusterer(map, markers, {
						imagePath: "https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m",
					});
				}
				var styles = [{
      width: 30,
      height: 30,
      className: "custom-clustericon-1",
    },
    {
      width: 20,
      height: 20,
      className: "custom-clustericon-2",
    },
    {
      width: 50,
      height: 50,
      className: "custom-clustericon-3",
    },
  ];

				$("#export_user_form").on('submit', function(e) {
				var format = $('#format').val();
				if(format == "pdf") {
					$(".buttons-pdf ").click()
				}
				if(format == "excel") {
					console.log('excel');
					$(".buttons-excel").click()
				}
				if(format == "csv") {
					console.log('csv');
					$(".buttons-csv").click()
				}
				if(format == "copy") {
					console.log('copy');
					$(".buttons-copy").click()
				}
				e.preventDefault();
			});
				
				</script>
				<!--end::Page Custom Javascript-->
				<!--end::Javascript-->@stop