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
				<h1 class="text-dark fw-bolder my-0 fs-2">Task Report</h1>
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
			<form id="search-form" class="form"  method="POST" enctype="multipart/form-data">
				@csrf
				<input type="hidden" name="isEdit" id="isEdit">
				<!--begin::Card-->
                               <!--  <div class="card " style="margin-bottom: 10px;">
                                        <div class="card-body">
                                        
                                        </div>

                                    </div> -->
                                    <div class="card mb-7">
                                    	<!--begin::Card body-->
                                    	<div class="card-body">
                                    		<!--begin::Compact form-->
                                    		<div class="d-flex align-items-center">
                                    			<div class="position-relative w-md-400px me-md-2 mr-2">

                                    				<select class="form-select form-select-lg form-select-solid _ac-customer-change" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true"
                                    				id="customer_name" name="customer_name"  onchange="getCustomerSiteData(this)">
                                    				`<option>Select Customer</option>
                                    				@foreach($customers as $result)
                                    				<option value="{{$result->id}}">{{$result->name}}</option>
                                    			@endforeach                                                                    </select>
                                    			<!--end::Select-->
                                    		</div>
                                    		<!--begin::Input group-->
                                    		<div class="position-relative w-md-400px me-md-2" style="display: none;">
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
                                    	<div style="display: none"  id="kt_advanced_search_form">
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
                                    							<select id="specific_state" multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1" id="state" name="state[]" >
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




                                    					<div class="col-lg-6 " style="margin-top: 20px;">
                                    						<label class="fs-6 form-label fw-bolder text-dark">Select {{config('custom.guard')}}</label>
                                    						<div class="fv-row mb-10">
                                    							<select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1" id="guard_name" name="guard_name[]" >
                                    								<!-- <option value="">Select Customer</option> -->

                                    							</select>
                                    						</div>
                                    					</div>

                                    					<div class="col-lg-6 ">
                                    						<label class="fs-6 form-label fw-bolder text-dark">Select Site </label>
                                    						<div class="fv-row mb-10">
                                    							<select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1" id="specific_customer_sites" class="specific_customer_sites" name="sites[]" >
                                    								<!-- <option value="">Select Customer</option> -->

                                    							</select>
                                    						</div>
                                    					</div>

                                    					<!--begin::Col-->


                                    					<!--end::Col-->

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
                            	<div class="col-sm-6 " style="float:left;">


                            	</div>



                            </div>
                            <div class="table-responsive">
                            	<table  id="example" class="table table-responsive table-hover table-striped  gy-5 gs-7" style="width:100%">
                            		<thead>
                            			<tr class="fw-bold ">
                            				<th style="display:;">{{config('custom.guard')}} Name</th>
                            				<th style="display:;">Site Name (Site description)</th>
                            				<th style="display:;">Shift Address</th>
                            				<th style="display:;">Shift Date</th>
                            				<th style="display:;">No. of Tasks</th>
                            				<th style="display:;">Action</th>
                            			</tr>
                            		</thead>
                            		<tbody id="example_body">


                            		</tbody>

                            	</table>




                            	<table   id="example2" class="table table-responsive table-hover table-striped  gy-5 gs-7" style="width:100%;display:none">
                            		<thead>
                            			<tr class="fw-bold ">

                            				<th style="display:;">#</th>
                            				<th style="display:;">Task Name</th>
                            				<th style="display:;">Assigned Task Time</th>
                            				<th style="display:;">Task Started At</th>
                            				<th style="display:;">Task Completed At</th>
                            				<th style="display:;">Task Status</th>
                            				<th style="display:;">Task Location</th>


                            			</tr>
                            		</thead>
                            		<tbody id="example2_body">


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
				// var table = $('#example').DataTable();
                        			var customerId='';
                        			var dt = $('#example').DataTable({
                        				responsive: true,
                        				retrieve: true
                        			});
                        			$('#example2').DataTable({
                        				responsive: true,
                        				retrieve: true,
                        			})
                        			// $('#example_filter').hide();
                        			$('#example2_filter').hide();
                        			$('#example2_paginate').hide();
                        			$('#example2_info').hide();	
                        			$('.dt-buttons').hide();



                        			$("#kt_daterangepicker_1").daterangepicker();
				 // getsearchdata();
        			// get_customers();


                        			var $rows = $('#example tr');
                        			$('#search').keyup(function() {
                        				var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

                        				$rows.show().filter(function() {
                        					var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
                        					return !~text.indexOf(val);
                        				}).hide();
                        			});

           // getJobsData ('completed', 'example');

                        		} );




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
                        			$(".calendar-list").html("");
                        			$.ajax({
                        				type: "POST",
                        				data: {
                        					_token  : '<?php echo csrf_token() ?>',
                        					customerId: customerId
                        				},
                        				url:' {{url("/task/get_customers_jobs_list")}}',
                        				success: function(result) {
                        					task_report_onchange(customerId);

                // result = JSON.parse(result);
                        					siteData = "";
                        					var siteData2 = '';

                        					$.each(result, function(index, value) {
					//jobId
                        						siteData2 += '<option value="' + value.site_name + '">' + value.site_name +
                        						' ( ' + value.site_description +
                        						')</option>';
                        					});
                // if (check == false) {
                        					$("#specific_customer_sites").html(siteData2);
                        					$('div.multiselect-dropdown').remove();
                        					MultiselectDropdown(window.MultiselectDropdownOptions);


                        				}
                        			});

                        		}

                        		function task_report_onchange(customerId){
                        			$.ajax({type: "GET",url:' {{url('task/task_report_onchange/')}}',data:{customerId:customerId, _token :'<?php echo csrf_token() ?>'},success: function(result){

                        				$('#example').DataTable().destroy();
                        				var list = '';
                        				var siteData3= '';
                        				var siteData2='';
                        				$.each(result.guards, function(id, data)
                        				{
                        					siteData2+= '<option value="' + data.id + '">' + data.name +'</option>';
                        				});
                        				$("#guard_name").html(siteData2);
                        				$('div.multiselect-dropdown').remove();
                        				MultiselectDropdown(window.MultiselectDropdownOptions);

// $.each(result.results, function(id, data){
// 				list += '<tr>';
// 				list += '<td style="display:;">'+data.guard_name+'</td>';
// 				// list += '<td style="display:;">'+data.task_name+'</td>';
// 				list += '<td style="display:;">'+data.site_name +'<span style="font-size:10px">(  '+  data.site_description +')</span></td>';
// 				list += '<td style="display:;">'+data.address+'</td>';
// 				list += '<td style="display:;">'+data.job_added+'</td>';
// 				list += '<td style="display:;">'+data.total_count+'</td>';
// 				list += '<td style="display:"><a type="button" onclick="export_table_pdf('+data.roster_id+')"><img src="https://img.icons8.com/material-outlined/24/000000/pdf-2.png"/></a><a style="margin-left:10px;" type="button" onclick="export_table_excel('+data.roster_id+')"><img src="https://img.icons8.com/metro/26/000000/ms-excel.png"/></a></td>';
// 				list += '</tr>';
// 					});
                        				$('#example_body').html(list);
                        				$('#example').DataTable({
                        					responsive: true,
                        					retrieve: true,
                        				})
                        				$('#example_filter').hide();
    // $('.dt-buttons').hide();
                        			}})

                        			$('div.multiselect-dropdown').remove();
                        			MultiselectDropdown(window.MultiselectDropdownOptions);
                        		}
                        		$("#search-form").on('submit', function(e){
                        			e.preventDefault();
                        			console.log(this.id)
                        			$('#isEdit').val("yes");
                        			var data = $('#'+this.id).serialize();
                        			$.ajax({type: "POST",url: "{{url('task/task_report_search/')}}",data :data,success: function(result){
                        				$('#example').DataTable().clear().destroy();
                        				var list = '';
                        				var pdf="pdf";
                        				var excel="excel";
                        				var img = '';
                        				global_guards = result;
                        				$.each(result.results, function(id, data){
                        					list += '<tr>';
                        					list += '<td style="display:;">'+data.guard_name+'</td>';
                        					list += '<td style="display:;">'+data.site_name +'<span style="font-size:10px">(  '+  data.site_description +')</span></td>';
                        					list += '<td style="display:;">'+data.address+'</td>';
                        					list += '<td style="display:;">'+data.job_added+'</td>';
                        					list += '<td style="display:;">'+data.total_count+'</td>';
                        					list += '<td style="display:"><a type="button" onclick="export_table_pdf('+data.roster_id+')"><img src="https://img.icons8.com/material-outlined/24/000000/pdf-2.png"/></a>';
                        					// list += '<a style="margin-left:10px;" type="button" onclick="export_table_excel('+data.roster_id+')"><img src="https://img.icons8.com/metro/26/000000/ms-excel.png"/></a>';
                        					list += '</td>';
                        					list += '</tr>';
                        				});
                        				$('#example_body').html(list);
                        				$('#example').DataTable({
                        					responsive: true,
                        					retrieve: true,
                        				});
                        				$('#example_filter').hide();
                        			}})
                        		});
                        		function export_table_excel(roster_id){
                        			var type="pdf";
                        			export_table(roster_id,type);
                        		}
                        		function export_table_pdf(roster_id){
                        			var type="pdf";
                        			export_table(roster_id,type);
                        		}


                        		function export_table(roster_id,type){
                        			call_spinner();

                        			$.ajax({type: "GET",url:"{{url('task/export_table/')}}", data:{roster_id:roster_id,_token :'<?php echo csrf_token() ?>'},success: function(result){
                        				close_spinner();
                        				var counter=0;
                        				$('#example2').DataTable().clear().destroy();
                        				var list='';
                        				var task_name='';
                        				var site_name=result.site_name;
                        				$.each(result.tasks, function(id, data){
                        					counter++;
                        					if(data.task_completed_time==null ||  data.task_completed_time=='' ){
                        						data.task_completed_time="N/A";
                        					}
                        					if(data.task_location==null || data.task_location==''){
                        						data.task_location="N/A";
                        					}
                        					list += '<tr>';
                        					list += '<td style="display:;">'+counter+'</td>';
                        					list += '<td style="display:;">'+data.task_name+'</td>';
                        					list += '<td style="display:;">'+data.task_assigned_task_time +'</td>';
                        					list += '<td style="display:;">'+data.task_assigned_task_time +'</td>';
                        					list += '<td style="display:;">'+data.task_completed_time+'</td>';
                        					list += '<td style="display:;">'+data.task_status+'</td>';
                        					list += '<td style="display:">'+data.task_location+'</td>';
                        					list += '</tr>';
                        				});
                        				$('#example2_body').html(list);
                        				$('#example2').DataTable({
                        					dom: 'Bfrtip',
                        					responsive: true,
                        					retrieve: true,
                        					buttons: [{
                        						extend: 'pdfHtml5',
                        						title: 'Task Report',
                        						messageTop: 'The information in this table is of jobs included tasks within it.',
                        						pageSize: 'LEGAL',
                        						customize: function(doc) {
                        							doc.content.splice(0,1);
                        							var now = new Date();
                        							var jsDate = now.getDate()+'-'+(now.getMonth()+1)+'-'+now.getFullYear();
                        							doc.pageMargins = [20,60,20,30];
                        							doc.defaultStyle.fontSize =10;
                        							doc.styles.tableHeader.fontSize = 12;
                        							doc.styles.title = {
                        								fontSize: '50',
                        								alignment: 'center'
                        							}
                        							doc['header']=(function() {
                        								return {
                        									columns: [
                        									{
                        										alignment: 'left',
                        										text: 'Task Report ',
                        										fontSize: 18,
                        										margin: [10,0]
                        									},
                        									{
                        										alignment: 'right',
                        										fontSize: 13,
                        										text: 'Site Name :' + site_name,
                        										margin: [10,10]

                        									}
                        									],
                        									margin: 20
                        								}
                        							});
                        							doc['footer']=(function(page, pages) {
                        								return {
                        									columns: [
                        									{
                        										alignment: 'left',
                        										text: ['Printed on: ', { text: jsDate.toString() }]
                        									},
                        									{
                        										alignment: 'right',
                        										text: ['page ', { text: page.toString() },  ' of ', { text: pages.toString() }]
                        									}
                        									],
                        									margin:5
                        								}
                        							});

                        						},
                        						exportOptions: {
                        							columns: "thead th:not(.noExport)"
                        						}
                        					},
                        					{
                        						extend: 'excelHtml5',
                        						title: 'Task Report ',
                        						messageTop: 'The information in this table is of jobs included tasks within it.',
                        						orientation: 'landscape',
                        						pageSize: 'LEGAL',
                        						exportOptions: {
                        							columns: "thead th:not(.noExport)"
                        						}
                        					}
                        					]
                        				})
                        				$('#example2_filter').hide();
                        				$('#example2_paginate').hide();
                        				$('#example2_info').hide();	
                        				$('.dt-buttons').hide();
                        				if(type=="pdf"){
                        					$(".buttons-pdf").click()
                        				}else{
                        					$(".buttons-excel").click()
                        				}
                        			}})
	close_spinner();
	close_spinner();
}
	// 	</script>



	@stop