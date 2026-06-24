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



		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">


<style type="text/css">
/* .sorting_asc{
	background: none !important;
} */	
tbody, td, tfoot, th, thead, tr {
    border-top: 1px solid #F1416D;
}
table.dataTable thead .sorting{
     background: none !important;
}
.text-dark{
	margin-top: 2px;
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
								<h1 class="text-dark fw-bolder my-0 fs-2">Timesheet</h1>
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
								<a href="index.html" class="d-flex align-items-center">
									<img alt="Logo" src="{{config('custom.logo')}}" class="h-30px" />
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
					<div class=" content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Container-->
						<div class="container" id="kt_content_container">
							<!--begin::Form-->
							<form id="search-form" class="form" action="{{url('timesheet_search')}}" method="POST" enctype="multipart/form-data">
								@csrf
								<!--begin::Card-->
								<div class="card mb-7">
									<!--begin::Card body-->
									<div class="card-body">
										<!--begin::Compact form-->
										<div class="d-flex align-items-center">
											<!--begin::Input group-->
											<div class="position-relative w-md-400px me-md-2">
												<!--begin::Svg Icon | path: icons/duotone/General/Search.svg-->
												<span class="svg-icon svg-icon-3 svg-icon-gray-500 position-absolute top-50 translate-middle ms-6">
													<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
														<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
															<rect x="0" y="0" width="24" height="24" />
															<path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
															<path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero" />
														</g>
													</svg>
												</span>
												<!--end::Svg Icon-->
												<input type="search" class="form-control form-control-solid ps-10" name="search" id="search" placeholder="Search" />
											</div>
											<!--end::Input group-->
											<!--begin:Action-->
											<div class="d-flex align-items-center">
												<button type="submit" class="btn btn-primary me-5">Search</button>
												<a id="kt_horizontal_search_advanced_link" class="btn btn-link" >Advanced Search</a>
											</div>
											<!--end:Action-->
										</div>
										<!--end::Compact form-->
										<!--begin::Advance form-->
										<div style="display: none" id="kt_advanced_search_form">
											<!--begin::Separator-->
											<div class="separator separator-dashed mt-9 mb-6"></div>
											<!--end::Separator-->
											<!--begin::Row-->
											<div class="row ">
												<!--begin::Col-->
													<div class="mb-0">
													    <label class=" fs-6 form-label fw-bolder text-dark">From-To</label>
													    <input name ="from_to" class="form-control form-control-solid" placeholder="Pick date rage" id="kt_daterangepicker_1"/>
													</div>
													<!--end::Col-->
												<!--begin::Col-->
												<div class="">
													<!--begin::Row-->
													<div class="row ">
														<!--begin::Col-->
													
														       <div class="col-lg-6 ">
															<br>

														              	<label class="fs-6 form-label fw-bolder text-dark">Select State</label>
            															<div class="fv-row mb-10">
															            <select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1" id="State" name="State[]" class=="_ac-customer-change">
															                <!-- <option value="">Select Customer</option> -->
																	@foreach($states as $result)
																<option value="{{$result->state}}">{{$result->state}}</option>

																@endforeach
															            </select>
																        </div>
																        </div>
														              <div class="col-lg-6 ">
															<br>

														              	<label class="fs-6 form-label fw-bolder text-dark">Select Customer</label>
            															<div class="fv-row mb-10">
																            <select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1" id="customer_name" name="customer_name[]" class="_ac-customer-change">
																				<!-- <option value="">Select Customer</option> -->
															          	@foreach($customers as $result)
																		<option value="{{$result->id}}">{{$result->name}}</option>
																		@endforeach
															            </select>
																        </div>
																        </div>

															
												
														    <div class="col-lg-6 ">
														              	<label class="fs-6 form-label fw-bolder text-dark">Select {{config('custom.guard')}}</label>
            															<div class="fv-row mb-10">
																            <select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1" id="guard_name" name="guard_name[]" class="_ac-customer-change">
																                <!-- <option value="">Select Customer</option> -->
																			          	@foreach($guards as $result)
																						<option value="{{$result->id}}">{{$result->name}}</option>

																						@endforeach
																            </select>
																        </div>
																        </div>
														<div class="col-lg-6">
															<label class="fs-6 form-label fw-bolder text-dark">Select {{config('custom.guard')}} Type</label>
															<!--begin::Select-->
															<select name="guard_type" id="guard_type" class="form-select form-select-solid" data-control="select2" data-placeholder="Type" data-hide-search="true">
																
																<option value="">Select </option>
																<option value="Direct">Direct </option>
																<option value="Contractor">Contractor </option>

																
																
															</select>
															<!--end::Select-->
														</div>
														<!--end::Col-->
														<!--begin::Col-->
														<div class="col-lg-4">
															<label class="fs-6 form-label fw-bolder text-dark">Admin Approval</label>
															<!--begin::Radio group-->
												
													<div class="nav-group nav-group-fluid">
																		<!--begin::Option-->
																		<label>
																			<input type="radio" class="btn-check" name="status" value="all" checked="checked">
																			<span class="btn btn-sm btn-color-muted btn-active btn-active-primary fw-bolder px-4">All</span>
																		</label>
																		<!--end::Option-->
																		<!--begin::Option-->
																		<label>
																			<input type="radio" class="btn-check" name="status" value="completed">
																			<span class="btn btn-sm btn-color-muted btn-active btn-active-primary fw-bolder px-4">Approved</span>
																		</label>
																		<!--end::Option-->
																		<!--begin::Option-->
																		<label>
																			<input type="radio" class="btn-check" name="status" value="pending">
																			<span class="btn btn-sm btn-color-muted btn-active btn-active-primary fw-bolder px-4">Unapproved</span>
																		</label>
																		<!--end::Option-->
																	</div>
															<!--end::Radio group-->
														</div>

														<!--end::Col-->
															    <div class="col-lg-12 ">
														              	<label class="fs-6 form-label fw-bolder text-dark">Select Location</label>
            															<div class="fv-row mb-10">
																            <select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1" id="address" name="address[]" class="_ac-customer-change">
																                <!-- <option value="">Select Customer</option> -->
																			         		@foreach($address as $result)
																<option value="{{$result->address}}">{{$result->address}}</option>

																@endforeach
																            </select>
																        </div>
																        </div>
												
													</div>
													<!--end::Row-->
												</div>
												<!--end::Col-->
											</div>
											<!--end::Row-->
											<!--begin::Row-->
											<div class="row g-8">
												<!--begin::Col-->
												<div class="col-xxl-7">
													
												</div>
												<!--end::Col-->
												<!--begin::Col-->
												<div class="col-xxl-5">
													<!--begin::Row-->
													<div class="row g-8">
														<!--begin::Col-->
														
														<!--end::Col-->
														<!--begin::Col-->
														
														<!--end::Col-->
													</div>
													<!--end::Row-->
												</div>
												<!--end::Col-->
											</div>
											<!--end::Row-->
										</div>
										<!--end::Advance form-->
									</div>
									<!--end::Card body-->
								</div>
								<!--end::Card-->
							</form>
							<!--end::Form-->
								<!--begin::Toolbar-->
													<div class="card">
															</br>
														
																<div class="row">
																	<div class="col-sm-6 " style="float:left"></div>
																	<div class="col-sm-6" style="float:right;text-align: end;margin-top:4px;">
																		<button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_export_users">
																		<!--begin::Svg Icon | path: icons/duotone/Files/Export.svg-->
																		<span class="svg-icon svg-icon-2">
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
														<span class="card" >
														    <table  id="example" class="table table-striped table-row-bordered gy-5 gs-7 border rounded  table-hover gy-7 gs-7"  style="width:100%;">
														        <thead>
														            <tr class="fw-bold ">
														                <th class="min-w-">State Name</th>
														                <th class="min-w-">Site Name(Description)</th>
																		<th class="min-w-">Staff Payroll Id</th>
														                <th class="min-w-">Staff Name</th>
														                <th class="min-w-">Stafff Type</th>
														                <th class="min-w-">Customer</th>
														                <th class="min-w-">Schedule Start Date</th>
														                <th class="min-w-">Schedule Start Time</th>
														                <th class="min-w-">Schedule Finish Time</th>
														                <th class="min-w-">Actual Start Time</th>
														                <th class="min-w-">Actual Finish Time</th>
														                <th>Travel Time</th>
														                <th class="min-w-">Authorized Total Hours</th>



														            </tr>
														        </thead>
														        <tbody id="example_body">
														        	
           															       				        	
														        </tbody>
														       
														    </table>
														</span>
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
																		<option value="copy">Copy</option>
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
		<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
		<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>

<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script> -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>



		<script >
			// var table = $('#example').DataTable();
var scope='';

			var search_to=null;
			var search_from=null;
			var search_guard=[];
			var search_customer=[];
			var guard_arr=[]
			// delete guard_arr
			var global_guard_email;
			var global_guard_phone;

			var customer_arr=[]
			var bolean_search="false";
			var default1 = "Default";
			var multiple1 = "Multiple";
			var none='';
			var total_shifts=0;
			var total_hours=0;

			$(document).ready(function() {
				$("#kt_daterangepicker_1").daterangepicker();
				MultiselectDropdown(window.MultiselectDropdownOptions);
				
var log1='';

function toDataUrl(url, callback) {
    var xhr = new XMLHttpRequest();
    xhr.onload = function() {
        var reader = new FileReader();
        reader.onloadend = function() {
            callback(reader.result);
			scope=reader.result;
			// console.log(scope);
			log(scope);
        }
        reader.readAsDataURL(xhr.response);
    };
    xhr.open('GET', url);
    xhr.responseType = 'blob';
    xhr.send();
}
var myBase64='';
// var url='{{asset('')}}media/logo.png';

var url='{{config('custom.logo')}}';
 toDataUrl(url, function(myBase64) {
    // return myBase64;
		// log(myBase64)
// console.log(myBase64); // myBase64 is the base64 string
	 // myBase64 is the base64 string
});
// console.log("outside" ); // myBase64 is the base64 string
// console.log("outside"+url); // myBase64 is the base64 string
function log(data){
//    console.log(data);
//    return data;
   scope = data;
}
 

    $('#example').DataTable({
        "ordering": false,
        "pageLength": 25,
        dom: 'Blrtip',
        buttons: [
												'copyHtml5',
									            'excelHtml5',
									            'csvHtml5',
												'pdfHtml5'
	        ]
    });
		 setTimeout(function(){ getsearchdata ();  }, 3000);
    })
				$("#search").on("input", function (e) {
		e.preventDefault();
		$('#example').DataTable().search($(this).val()).draw();
} );

function getsearchdata()
{
	call_spinner();


	// console.log(multiple1);
						     $.ajax({type: "GET",url:' {{url('/timesheet_record/')}}' ,success: function(result){

										$('#example').DataTable().destroy();
								
						     		var list = '';
									 total_shifts=0;
									 total_hours=0;

						     	 $.each(result.results, function(id, data){
									total_hours=total_hours+parseFloat(data.hours);
									 total_shifts++;
									 var signin_time=data.signin_time;
						          var signout_time=data.signout_time;
						          
								  var signin_time_ex='N/A';
						          var signout_time_ex='N/A';
								  var newtime=getDateTime();
								  var roster_id=data.roster_id;
								  var newtime_out=getDateTime();
								  if(signin_time!=null){
									  if(signin_time.indexOf("GMT") > -1){
											
																			signin_time_ex = signin_time.split(" ");
																			
																			var M=return_month(signin_time_ex[1]);
																		   newtime=`${signin_time_ex[3]}-${M}-${signin_time_ex[2]} ${signin_time_ex[4]}`;
																		   signin_time_ex = signin_time_ex[4];
														        		}
																		else if(signin_time.indexOf("M") > -1 || signin_time.indexOf("T") > -1 ||signin_time.indexOf("W") > -1 ||signin_time.indexOf("F") > -1 ||signin_time.indexOf("S") > -1 ){
																			signin_time_ex = signin_time.split(" ");
																			signin_time_ex = signin_time_ex[4];
										}
										else{
												newtime=signin_time;
												var newtime_ex=newtime.split(" ");
												signin_time_ex=newtime_ex[1];
											}
										}
																		else{
											 newtime=getDateTime();

																		}
								  if(signout_time!=null){
																		
																		if(signout_time.indexOf("GMT") > -1){
																			signout_time_ex = signout_time.split(" ");
											var M=return_month(signout_time_ex[1]);
										   newtime_out=`${signout_time_ex[3]}-${M}-${signout_time_ex[2]} ${signout_time_ex[4]}`;
										   signout_time_ex = signout_time_ex[4];
										}
										else if(signout_time.indexOf("M") > -1 || signout_time.indexOf("T") > -1 ||signout_time.indexOf("W") > -1 ||signout_time.indexOf("F") > -1 ||signout_time.indexOf("S") > -1 ){
																		signout_time_ex = signout_time.split(" ");
										   signout_time_ex = signout_time_ex[4];
										}
										else{
												newtime_out=signout_time;
												var newtime_out_ex=newtime_out.split(" ");
												signout_time_ex=newtime_out_ex[1];
											}
										}
										else{
											 newtime_out=getDateTime();
										}

										if(data.guard_name==null || data.guard_name==''){
											data.guard_name="N/A";
										}
						            list += '<tr>';
						            list += '<td>'+data.state+'</td>';
						            list += '<td>'+data.site_name+'('+data.site_description+') </td>';
						            list += '<td style="display:;">'+data.guard_payroll_id+'</td>';
						            list += '<td style="display:;">'+data.guard_name+'</td>';
						            list += '<td>'+data.guard_type+'</td>';
						            list += '<td>'+data.customer_name+'</td>';
						            list += '<td>'+data.temp_date+'</td>';
						            list += '<td>'+data.temp_start+'</td>';
						            list += '<td>'+data.temp_end+'</td>';
						            list += '<td>'+signin_time_ex+'</td>';
            						list += '<td>'+signout_time_ex+'</td>';
						            list += '<td>'+data.travel_time+'</td>';
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
								buttons: [
											'copyHtml5',
											{
													extend:'excelHtml5',
													orientation: 'landscape',
											},'csvHtml5',
											{
										extend: 'pdfHtml5',
										title: "TimeSheet",
										// 					exportOptions: {
										// 	columns: "thead th:not(.noExport)"
										// },
										orientation: 'landscape',
										// messageTop:  '{{config('custom.title')}}',
										text: 'TimeSheet',
										className: 'fa fa-print',

										customize: function ( win ) {
                        $(win.document.body).find('h1').css('text-align', 'center');
						$(win.document.messageTop).find('h1').css('text-align', 'center');


                        $(win.document.body).css( 'font-size', '9px' );
                        $(win.document.messageTop).css( 'font-size', '9px' );
                        $(win.document.body).find( 'table' )
                        .addClass( 'compact' )
                        .css( 'font-size', 'inherit' );
                },
						// 											pageSize: 'LEGAL',
										pageSize: 'LEGAL',
										exportOptions: {
											search: 'applied',
											order: 'applied',
											stripNewlines: false
										},
										customize: function (doc) {
											var rdoc = doc;
											var rcout = doc.content[doc.content.length - 1].table.body.length - 1;
											doc.content.splice(0, 1);
											var now = new Date();
											
											var jsDate = now.getDate() + '/' + (now.getMonth() + 1) + '/' + now.getFullYear() + '  and Time:' + now.getHours() + ':' + now.getMinutes() + ':' + now.getSeconds();
											doc.pageMargins = [50, 70, 30, 30];
											doc.defaultStyle.fontSize = 8;
											doc.styles.tableHeader.fontSize = 9;
											// doc.content[doc.content.length - 1].table.headerRows = 4;
											doc.content[doc.content.length - 1].table.body[0].splice(0, 0, { text: "SNo.", style: "tableHeader" });
											var iPlus;
											for (var i = 0; i < rcout; i++) {
												iPlus = (i + 1);
												var obj = doc.content[doc.content.length - 1].table.body[i + 1];
												doc.content[doc.content.length - 1].table.body[(i + 1)][0] = { text: obj[0].text, style: [obj[0].style], bold: true };
												doc.content[doc.content.length - 1].table.body[(i + 1)][3] = {
													text: obj[3].text,
													style: [obj[3].style],
													alignment: 'center',
													bold: obj[3].text > 60 ? true : false,
													fillColor: obj[3].text > 60 ? 'red' : null
												};
												var cols = [];
												cols[0] = {text: 'Left part', alignment: 'left', margin:[20] };
												doc.content[doc.content.length - 1].table.body[iPlus].splice(0, 0, { text: iPlus, style: obj[0].style });
											}

											doc['header'] = (function (page, pages) {
												return {
													columns: [
													
																			[	
										
																			
							{
						height:45,width:50,margin: [0,15,-50,100],alignment:'left',image:`${scope}`},
						
						]
	,					[			
									{
										alignment: 'center',
										text: `{{config('custom.title')}}`,
										fontSize: 14,
										bold: true,
									margin: [0,15,0,0]

									
									
									},	{
										alignment: 'center',
										text: `Address: {{config('custom.address')}}`,
										fontSize: 6,
										margin: [0, 0, 0, 0]	
																				

									},
									// if(bolean_search=="true"){
										{
										alignment: 'center',
										text: `Guard  : ${guard_arr.length==1 ? guard_arr[0] : multiple1}`,
										fontSize: 7,
										margin: [0, 0, 15, 0]

									

									}	,
									
									{
										alignment: 'center',
										text: `Customer  : ${customer_arr.length==1 ? customer_arr[0] : multiple1}`,
										fontSize: 7,
										margin: [0, 0, 15, 0]
									}	,
									{
										alignment: 'center',
										text: `From  : ${search_from== null? default1 : search_from } - To :  ${search_to==null ? default1 : search_to }`,
										fontSize: 7,
										margin: [0, 0, 15, 0]
									}	,
								
									// 	{
									// 	alignment: 'center',
									// 	text: 'Report Type : TimeSheet',
									// 	fontSize: 7,
									// 	margin: [0, 0, 15, 0]
										
									// },
								
								],

							[						
								{
										alignment: 'center',
										text: ` ${guard_arr.length==1 ? `Email: ${global_guard_email}` : `${none}`}`,
										fontSize: 9,
										margin: [0, 15, 0, 0]		
																		}
																		,
									{
										alignment: 'center',
										text: ` ${guard_arr.length==1 ? `Phone: ${global_guard_phone}` : `${none}`}`,
										fontSize: 9,
										margin:  [0, 0, 15, 0]	
																				

									},
									{
										alignment: 'center',
										text: `Total Shifts: ${total_shifts}   Total Hours: ${total_hours}` ,
										fontSize: 7,
										margin:  [0, 15, 15, 0]	
									}
								
							]
					

																
														]

												
												}
											});

											doc['footer'] = (function (page, pages) {
												return {
													columns: [
														{
															alignment: 'left',
															text: ['Printed at: ', { text: jsDate.toString() }]
														},
												
													],
													margin: 10
												}
											});


                }
            }
        ]
    });
											$('#example_filter').hide();
											$('.dt-buttons').hide();
											close_spinner();

    			


				
						     }})

  }

  


 $("#search-form").on('submit', function(e){
	call_spinner();

						     e.preventDefault();
						     console.log(this.id)
						     var data = $('#'+this.id).serialize();
								 bolean_search="true";
								 var search_date1=$('#kt_daterangepicker_1').val();
								var  search_date=search_date1.split("-");
								 var from = new Date(search_date[0]);
									var to = new Date(search_date[1]);
									search_from=moment(from).format('DD-MM-yy');
									search_to=moment(to).format('DD-MM-yy');
								
								 
								 search_customer=$('#customer_name  option:selected').toArray().map(item => item.text).join();
								//  search_guard=$('#guard_name  option:selected ').text();	
								 search_guard=$('#guard_name  option:selected ').toArray().map(item => item.text).join();
								 	if(search_guard!=''){
										guard_arr=search_guard.split(",");

									 }
									 if(search_customer!=''){

										customer_arr=search_customer.split(",");

									 }
								// console.log(guard_arr);
						     $.ajax({type: "POST",url: this.action,data : data ,success: function(result){
										$('#example').DataTable().clear().destroy();

						     	var list = '';
	        							        	
																
								 total_shifts=0;
									 total_hours=0;
						     	 $.each(result.results.data, function(id, data){
									  global_guard_email=data.guard_email;
									  global_guard_phone=data.guard_phone;
									  total_hours=total_hours+parseFloat(data.hours);
									 total_shifts++;
									 var signin_time=data.signin_time;
						          var signout_time=data.signout_time;
						          
								  var signin_time_ex='N/A';
						          var signout_time_ex='N/A';
								  var newtime=getDateTime();
								  var roster_id=data.roster_id;
								  var newtime_out=getDateTime();
								  if(signin_time!=null){
									  if(signin_time.indexOf("GMT") > -1){
											
																			signin_time_ex = signin_time.split(" ");
																			
																			var M=return_month(signin_time_ex[1]);
																		   newtime=`${signin_time_ex[3]}-${M}-${signin_time_ex[2]} ${signin_time_ex[4]}`;
																		   signin_time_ex = signin_time_ex[4];
														        		}
																		else if(signin_time.indexOf("M") > -1 || signin_time.indexOf("T") > -1 ||signin_time.indexOf("W") > -1 ||signin_time.indexOf("F") > -1 ||signin_time.indexOf("S") > -1 ){
																			signin_time_ex = signin_time.split(" ");
																			signin_time_ex = signin_time_ex[4];
										}
										else{
												newtime=signin_time;
												var newtime_ex=newtime.split(" ");
												signin_time_ex=newtime_ex[1];
											}
										}
																		else{
											 newtime=getDateTime();

																		}
								  if(signout_time!=null){
																		
																		if(signout_time.indexOf("GMT") > -1){
																			signout_time_ex = signout_time.split(" ");
											var M=return_month(signout_time_ex[1]);
										   newtime_out=`${signout_time_ex[3]}-${M}-${signout_time_ex[2]} ${signout_time_ex[4]}`;
										   signout_time_ex = signout_time_ex[4];
										}
										else if(signout_time.indexOf("M") > -1 || signout_time.indexOf("T") > -1 ||signout_time.indexOf("W") > -1 ||signout_time.indexOf("F") > -1 ||signout_time.indexOf("S") > -1 ){
																		signout_time_ex = signout_time.split(" ");
										   signout_time_ex = signout_time_ex[4];
										}
										else{
												newtime_out=signout_time;
												var newtime_out_ex=newtime_out.split(" ");
												signout_time_ex=newtime_out_ex[1];
											}
										}
										else{
											 newtime_out=getDateTime();
										}
						   
						            list += '<tr>';
						            list += '<td>'+data.state+'</td>';
						            list += '<td>'+data.site_name+'('+data.site_description+') </td>';
						            list += '<td style="display:;">'+data.guard_payroll_id+'</td>';
						            list += '<td style="">'+data.guard_name+'</td>';
						            list += '<td>'+data.guard_type+'</td>';
						            list += '<td>'+data.customer_name+'</td>';
						            list += '<td>'+data.temp_date+'</td>';
						            list += '<td>'+data.temp_start+'</td>';
						            list += '<td>'+data.temp_end+'</td>';

						            list += '<td>'+signin_time_ex+'</td>';
            						list += '<td>'+signout_time_ex+'</td>';
						            list += '<td>'+data.travel_time+'</td>';
						            list += '<td>'+data.hours+'</td>';


						            list += '</tr>';
						        });


						 //     	$("#example").dataTable({
							//   'destroy': true
							// })
							// console.log(scope);
						     	 $('#example_body').html(list);
								  $('#example').DataTable({
								"ordering": false,
								"pageLength": 25,
								dom: 'Blrtip',
								buttons: [
											'copyHtml5',
											'excelHtml5',
											'csvHtml5',
											{
										extend: 'pdfHtml5',
										title: "TimeSheet",
										// 					exportOptions: {
										// 	columns: "thead th:not(.noExport)"
										// },
										orientation: 'landscape',
										// messageTop:  '{{config('custom.title')}}',
										text: 'TimeSheet',
										className: 'fa fa-print',

										customize: function ( win ) {
                        $(win.document.body).find('h1').css('text-align', 'center');
						$(win.document.messageTop).find('h1').css('text-align', 'center');


                        $(win.document.body).css( 'font-size', '9px' );
                        $(win.document.messageTop).css( 'font-size', '9px' );
                        $(win.document.body).find( 'table' )
                        .addClass( 'compact' )
                        .css( 'font-size', 'inherit' );
                },
						// 											pageSize: 'LEGAL',
										pageSize: 'LEGAL',
										exportOptions: {
											search: 'applied',
											order: 'applied',
											stripNewlines: false
										},
										customize: function (doc) {
											var rdoc = doc;
											var rcout = doc.content[doc.content.length - 1].table.body.length - 1;
											doc.content.splice(0, 1);
											var now = new Date();
											
											var jsDate = now.getDate() + '/' + (now.getMonth() + 1) + '/' + now.getFullYear() + '  and Time:' + now.getHours() + ':' + now.getMinutes() + ':' + now.getSeconds();
											doc.pageMargins = [50, 70, 30, 30];
											doc.defaultStyle.fontSize = 8;
											doc.styles.tableHeader.fontSize = 9;
											// doc.content[doc.content.length - 1].table.headerRows = 4;
											doc.content[doc.content.length - 1].table.body[0].splice(0, 0, { text: "SNo.", style: "tableHeader" });
											var iPlus;
											for (var i = 0; i < rcout; i++) {
												iPlus = (i + 1);
												var obj = doc.content[doc.content.length - 1].table.body[i + 1];
												doc.content[doc.content.length - 1].table.body[(i + 1)][0] = { text: obj[0].text, style: [obj[0].style], bold: true };
												doc.content[doc.content.length - 1].table.body[(i + 1)][3] = {
													text: obj[3].text,
													style: [obj[3].style],
													alignment: 'center',
													bold: obj[3].text > 60 ? true : false,
													fillColor: obj[3].text > 60 ? 'red' : null
												};
												var cols = [];
												cols[0] = {text: 'Left part', alignment: 'left', margin:[20] };
												doc.content[doc.content.length - 1].table.body[iPlus].splice(0, 0, { text: iPlus, style: obj[0].style });
											}

											doc['header'] = (function (page, pages) {
												return {
													columns: [
													
																			[	
										
																			
							{
						height:45,width:50,margin: [0,15,-50,100],alignment:'left',image:`${scope}`},
						
						]
	,					[			
									{
										alignment: 'center',
										text: `{{config('custom.title')}}`,
										fontSize: 14,
										bold: true,
									margin: [0,15,0,0]

									
									
									},	{
										alignment: 'center',
										text: `Address: {{config('custom.address')}}`,
										fontSize: 6,
										margin: [0, 0, 0, 0]	
																				

									},
									// if(bolean_search=="true"){
										{
										alignment: 'center',
										text: `Guard  : ${guard_arr.length==1 ? guard_arr[0] : multiple1}`,
										fontSize: 7,
										margin: [0, 0, 15, 0]

									

									}	,
									
									{
										alignment: 'center',
										text: `Customer  : ${customer_arr.length==1 ? customer_arr[0] : multiple1}`,
										fontSize: 7,
										margin: [0, 0, 15, 0]
									}	,
									{
										alignment: 'center',
										text: `From  : ${search_from== null? default1 : search_from } - To :  ${search_to==null ? default1 : search_to }`,
										fontSize: 7,
										margin: [0, 0, 15, 0]
									}	,
								
									// 	{
									// 	alignment: 'center',
									// 	text: 'Report Type : TimeSheet',
									// 	fontSize: 7,
									// 	margin: [0, 0, 15, 0]
										
									// },
								
								],

							[						
								{
										alignment: 'center',
										text: ` ${guard_arr.length==1 ? `Email: ${global_guard_email}` : `${none}`}`,
										fontSize: 9,
										margin: [0, 15, 0, 0]		
																		}
																		,
									{
										alignment: 'center',
										text: ` ${guard_arr.length==1 ? `Phone: ${global_guard_phone}` : `${none}`}`,
										fontSize: 9,
										margin:  [0, 0, 15, 0]	
																				

									},
									{
										alignment: 'center',
										text: `Total Shifts: ${total_shifts}   Total Hours: ${total_hours}` ,
										fontSize: 7,
										margin:  [0, 15, 15, 0]	
									}
								
							]
					

																
														]

												
												}
											});

											doc['footer'] = (function (page, pages) {
												return {
													columns: [
														{
															alignment: 'left',
															text: ['Printed at: ', { text: jsDate.toString() }]
														},
												
													],
													margin: 10
												}
											});


                }
            }
        ]
    });


									    			// getsearchdata();
											$('#example_filter').hide();
											$('.dt-buttons').hide();
											close_spinner();
										console.log(customer_arr);


				
						     }})

  });
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

  
function getDateTime() {
        var now     = new Date(); 
        var year    = now.getFullYear();
        var month   = now.getMonth()+1; 
        var day     = now.getDate();
        var hour    = now.getHours();
        var minute  = now.getMinutes();
        var second  = now.getSeconds(); 
        if(month.toString().length == 1) {
             month = '0'+month;
        }
        if(day.toString().length == 1) {
             day = '0'+day;
        }   
        if(hour.toString().length == 1) {
             hour = '0'+hour;
        }
        if(minute.toString().length == 1) {
             minute = '0'+minute;
        }
        if(second.toString().length == 1) {
             second = '0'+second;
        }   
        var dateTime = year+'/'+month+'/'+day+' '+hour+':'+minute;   
         return dateTime;
    }
	function return_month(M){
		var months = {Jan:01, Feb:02, Mar:03, Apr:04, May:05, Jun:06,July:07,Aug:08,Sep:09,Oct:10,Nov:11,Dec:12};
		if(M=="Jan"){
			return months.Jan;
		}
		if(M=="Feb"){
			return months.Feb;
		}
		if(M=="Mar"){
			return months.Mar;
		}
		if(M=="Apr"){
			return months.Apr;
		}
		if(M=="May"){
			return months.May;
		}
		if(M=="July"){
			return months.July;
		}
		if(M=="Aug"){
			return months.Aug;
		}
		if(M=="Sep"){
			return months.Sep;
		}
		if(M=="Oct"){
			return months.Oct;
		}
		if(M=="Nov"){
			return months.Nov;
		}
		if(M=="Dec"){
			return months.Dec;
		}
	}


 
	// 	</script>



		<!--end::Page Custom Javascript-->
		<!--end::Javascript-->

@stop