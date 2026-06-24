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
		.none{
			display: none;
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
					<h1 class="text-dark fw-bolder my-0 fs-2">Division Consolidation</h1>
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
						<!-- <img alt="Logo" src="{{config('custom.logo')}}" class="h-30px" /> -->
					</a>
					<!--end::Logo-->
				</div>
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
				<div class="card">
					<div class="card-body">
						<div class="row">
							<!--begin::Col-->
							<div class="mb-0 col">
								<label class=" fs-6 form-label fw-bolder text-dark">From-To</label>
								<input name ="from_to" class="form-control form-control-solid" placeholder="Pick date rage" id="kt_daterangepicker_1"/>
							</div>
							<!--end::Col-->
							<div class="col mb-0 ">

								<label class="fs-6 form-label fw-bolder text-dark">Select Customer</label>
								<div class="fv-row mb-10">
									<select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1" id="customer_filter" name="customer_filter[]">

										@foreach($customers as $result)
										<option value="{{$result->id}}">{{$result->name}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col mb-0" id="div_sites">
								<label  class="fs-6 form-label fw-bolder text-dark">Select Sites</label>
								<div  class="fv-row mb-10">
									<select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1"  id="sites" name="sites[]" data-placeholder="Select an option">
									</select>
								</div>

							</div>
							<div class="col mb-0 mt-9">
								<div class="d-flex align-items-center">
									<button type="submit" class="btn btn-primary me-5" onclick="reloadGraphsData()">Search</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--begin::Toolbar-->
				<div class="card mt-2">
					<div class="card-body">
						<div class="">
							<h3 class="card-title fw-bolder text-gray-700" id="from-title">Shift by Customers</h3>
						</div>
						<div class="row">
							<div class="col-12">
								<div id="kt_amcharts_3" style="height: 500px;"></div>
							</div>
						</div>
					</div>
				</div>	
				<div class="card mt-4 card-bordered">
					<div class="card-body">
						<div class="">
							<h3 class="card-title fw-bolder text-gray-700" id="from-title">Profit & Loss</h3>
						</div>
						<div class="card-body">
							<div id="kt_apexcharts_5" style="height: 350px;"></div>
						</div>
					</div>
				</div>
				<!--end::Tab Content-->

				<div class="card mt-4 card-bordered">
					<div class="card-body">
						<div class="">
							<h3 class="card-title fw-bolder text-gray-700" id="from-title">Division Consolidation</h3>
							<button type="button" class="btn btn-light-primary me-3 pull-right" data-bs-toggle="modal" data-bs-target="#kt_modal_add_division" onclick="getDivisionFrom('list')">
								<span class="svg-icon svg-icon-2" >
									<i class="fas fa-plus"></i>
								</span>
								Add
							</button>
							<button type="button" class="btn btn-light-primary me-3 pull-right" data-bs-toggle="modal" data-bs-target="#kt_modal_add_division" onclick="getDivisionFrom('input')">
								<span class="svg-icon svg-icon-2">
									<i class="fas fa-plus"></i>
								</span>
								Add New
							</button>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table  id="example" class="table table-responsive table-hover table-striped  gy-5 gs-7" style="width:100%">
									<thead>
										<tr>
											<th>Name</th>
											<th>Rate</th>
											<th>Share</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody id="example_body">

									</tbody>

								</table>
							</div>
							<!-- <div id="kt_apexcharts_5" style="height: 350px;"></div> -->
						</div>
					</div>
				</div>
				<!--end::Container-->

				<div class="card mt-4 card-bordered">
					<div class="card-body">
						<div class="">
							<h3 class="card-title fw-bolder text-gray-700" id="from-title">Division Consolidation Report</h3>
							<div class="text-center">
								<button data-bs-toggle="modal" data-bs-target="#kt_modal_export_users" class="btn btn-light-primary me-3 pull-right">
									Export
								</button>
							</div>
						</div>
						<div class="card-body">
							
						</div>
					</div>
				</div>
				<!--end::Container-->

				<!-- model add division -->
				<div class="modal fade" id="kt_modal_add_division" tabindex="-1" aria-hidden="true">
					<!--begin::Modal dialog-->
					<div class="modal-dialog modal-dialog-centered mw-650px">
						<!--begin::Modal content-->
						<div class="modal-content">
							<!--begin::Modal header-->
							<div class="modal-header">
								<!--begin::Modal title-->
								<h2 class="fw-bolder">Add Division</h2>
								<!--end::Modal title-->
								<!--begin::Close-->

								<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">

									<span class="svg-icon svg-icon-2x">X</span>
								</div>
								<!--end::Close-->
							</div>
							<!--end::Modal header-->
							<!--begin::Modal body-->
							<div class="modal-body scroll-y mx-5 mx-xl-15 my-7" id="divisionFrom">
								
							</div>
							<!--end::Modal body-->
						</div>
						<!--end::Modal content-->
					</div>
					<!--end::Modal dialog-->
				</div>

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
          						<label class="required fs-6 fw-bold form-label mb-2">Select:</label>
          						<!--end::Label-->
          						<!--begin::Input-->
          						<select name="format" data-control="select2" data-placeholder="Select a format" data-hide-search="true" class="form-select form-select-solid fw-bolder" id="format" onchange="showHide()">
          							<option></option>
          							<!-- <option value="excel">Excel</option> -->
          							<option value="individual">Individual</option> 
          							<option value="combine">Combine</option>
          							<!-- <option value="csv">CSV</option> -->
          						</select>
          						<!--end::Input-->
          					</div>
          					<!--end::Input group-->

          					<!--begin::Input group-->
          					<div class="fv-row mb-10" id="diviion_div" style="display: none;">
          						<!--begin::Label-->
          						<label class="required fs-6 fw-bold form-label mb-2">Select:</label>
          						<!--end::Label-->
          						<!--begin::Input-->
          						<select name="format" data-control="select2" data-placeholder="Select a format" data-hide-search="true" class="form-select form-select-solid fw-bolder" id="division_id">
          							<option></option>
          							@foreach($list as $l)
          							<option value="{{$l->id}}">{{$l->name}}</option>
          							@endforeach
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

				<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
				<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
				<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>



				<script >

					function loadTableData()
					{
						$('#example').DataTable({
							"processing": true,
							"serverSide": true,
							"ajax": {
								"url": base_url + '/get_division_consolidation',
								"type": "POST",
								"data": {
									_token : token,
									date : $('#kt_daterangepicker_1').val(),
									customer_id : $('#customer_filter').val(),
									sites : $('#sites').val()
								}
							},
							"destroy":true,
							"columns": [{
								"data": "name"
							},
							{
								"data": "rate"
							},
							{
								"data": "share"
							},
							{
								"data": "action"
							}
							]
      // "deferLoading": 57
  });
					}
					function reloadGraphsData()
					{
							// loadCutsomerProfitLoss();
							loadCustomerPieChart();
							loadTableData();

						}
						$(document).ready(function() {
							$("#kt_daterangepicker_1").daterangepicker();
									MultiselectDropdown(window.MultiselectDropdownOptions);

							loadCustomerPieChart();
							loadTableData();
							loadCutsomerProfitLoss();
							
						});

						function loadCustomerPieChart()
						{
							$.ajax({
								url: base_url+"/getCustomerPieChart",
								type: "post",
								dataType: "json",
								data: {
									_token : token,
									date : $('#kt_daterangepicker_1').val(),
									customer_id : $('#customer_filter').val(),
									sites : $('#sites').val()
								},
								success: function(result) {

									am4core.ready(function () {

    // Themes begin
    // am4core.useTheme(am4themes_dataviz);
    am4core.useTheme(am4themes_animated);
    // Themes end

    // Create chart
    chart = am4core.create('kt_amcharts_3', am4charts.PieChart);
    chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

    chart.data = result;

    var series = chart.series.push(new am4charts.PieSeries());
    series.dataFields.value = 'value';
    series.dataFields.radiusValue = 'value';
    series.dataFields.category = 'country';
    series.slices.template.cornerRadius = 6;
    series.colors.step = 3;

    series.hiddenState.properties.endAngle = -90;

    chart.legend = new am4charts.Legend();
    $('g:has(> g[aria-labelledby="id-66-title"])').hide();
}); // end am4core.ready()
								}

							});
						}
						function loadCutsomerProfitLoss()
						{
							$('#kt_apexcharts_5').html('');
							$.ajax({
								url: base_url+"/getCutsomerProfitLoss",
								type: "post",
								dataType: "json",
								data: {
									_token : token,
									date : $('#kt_daterangepicker_1').val(),
									customer_id : $('#customer_filter').val(),
									sites : $('#sites').val()
								},
								success: function(result) {
									var element = document.getElementById('kt_apexcharts_5');

									var height = parseInt(KTUtil.css(element, 'height'));
									var labelColor = KTUtil.getCssVariableValue('--bs-gray-500');
									var borderColor = KTUtil.getCssVariableValue('--bs-gray-200');

									var baseColor = KTUtil.getCssVariableValue('--bs-primary');
									var baseLightColor = KTUtil.getCssVariableValue('--bs-light-primary');
									var secondaryColor = KTUtil.getCssVariableValue('--bs-info');
									var secondaryLightColor = KTUtil.getCssVariableValue('--bs-warning');

									if (!element) {
										return;
									}

									var options = {
										series: [{
											name: 'Total Charge',
											type: 'bar',
											stacked: true,
											data: result.charge
										},{
											name: 'Expense',
											type: 'bar',
											stacked: true,
											data: result.expense
										}, {
											name: 'Total Pay',
											type: 'bar',
											stacked: true,
											data: result.pay
										}, 
										{
											name: 'Profit',
											type: 'area',
											stacked: true,
											data: result.profit
										}],
										chart: {
											fontFamily: 'inherit',
											stacked: true,
											height: height,
											toolbar: {
												show: false
											}
										},
										plotOptions: {
											bar: {
												stacked: true,
												horizontal: false,
												endingShape: 'rounded',
												columnWidth: ['12%']
											},
										},
										legend: {
											show: false
										},
										dataLabels: {
											enabled: false
										},
										stroke: {
											curve: 'smooth',
											show: true,
											width: 2,
											colors: ['transparent']
										},
										xaxis: {
											categories: result.months,
											axisBorder: {
												show: false,
											},
											axisTicks: {
												show: false
											},
											labels: {
												style: {
													colors: labelColor,
													fontSize: '12px'
												}
											}
										},
										yaxis: {
											max: result.max,
											labels: {
												style: {
													colors: labelColor,
													fontSize: '12px'
												}
											}
										},
										fill: {
											opacity: 1
										},
										states: {
											normal: {
												filter: {
													type: 'none',
													value: 0
												}
											},
											hover: {
												filter: {
													type: 'none',
													value: 0
												}
											},
											active: {
												allowMultipleDataPointsSelection: false,
												filter: {
													type: 'none',
													value: 0
												}
											}
										},
										tooltip: {
											style: {
												fontSize: '12px'
											},
											y: {
												formatter: function (val) {
													return '$' + val
												}
											}
										},
										colors: [baseColor, secondaryColor, baseLightColor, secondaryLightColor],
										grid: {
											borderColor: borderColor,
											strokeDashArray: 4,
											yaxis: {
												lines: {
													show: true
												}
											},
											padding: {
												top: 0,
												right: 0,
												bottom: 0,
												left: 0
											}
										}
									};

									var chart = new ApexCharts(element, options);
									chart.render();
									// chart.disposeAllCharts();
								}

							});
						}
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
									siteData = "";
									var siteData2 = '';

									$.each(result, function(index, value) {
					//jobId
					siteData2 += '<option value="' + value.jobId + '">' + value.site_name +
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


						$('#customer_filter').change(function () {
							call_spinner();
							$('#div_sites').html('');
							var customer_id = $('#customer_filter').val();
							$.ajax({
								type: "POST",
								url: "{{url('job_tracker/get_customers_jobs_list')}}",
								data: {
									customer_id: customer_id,
									_token: "<?php echo csrf_token();?>"
								},
								success: function (result) {
									var sites = `<label class="fs-6 form-label fw-bolder text-dark">Select Active Sites</label>
									<div  class="fv-row mb-10">
									<select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1"  id="sites" name="sites[]" data-placeholder="Select an option">`;

									$.each(result.active_jobs, function (id, data) {
										sites += `<option value="${data.job_id}">${data.site_name}(${data.site_description})</option>`;
									})

									$.each(result.inactive_jobs, function (id, data) {
										sites += `<option value="${data[0].job_id}">${data[0].site_name}(${data[0].site_description})</option>`;
									})
									sites += '</select></div>';


									$('#customer_name').attr('multiple', false);
									$('#customer_filter').attr('multiple', false);
									$('#specific_customer_sites').attr('multiple', false);
									$('#div_sites').html(sites);
		             // get_tracker_data();				
		             MultiselectDropdown();
		             $('#customer_name').attr('multiple', true);
		             $('#customer_filter').attr('multiple', true);
		             $('#specific_customer_sites').attr('multiple', true);
		             $('#customer_filter').val(customer_id);
		             close_spinner();


		         }
		     })
						});
						function exportReport()
						{
							var link = '{{url("exportDivision")}}'+'?date='+$('#kt_daterangepicker_1').val()+'&customer_id='+$('#customer_filter').val()+'&sites='+$('#sites').val();
							window.open(link, '_blank');
						}
						$("#export_user_form").on('submit', function(e){
          			e.preventDefault();

          			var format =$('#format').val();
          			$('.modal').modal('hide');
					$('.modal-backdrop').css('display', 'none')
          			if (format == 'combine') {
          				var link = '{{url("exportDivision")}}'+'?date='+$('#kt_daterangepicker_1').val()+'&customer_id='+$('#customer_filter').val()+'&sites='+$('#sites').val();
							window.open(link, '_blank');
          			}
          			if (format == 'individual') {
          				var link = '{{url("exportDivision")}}'+'?date='+$('#kt_daterangepicker_1').val()+'&customer_id='+$('#customer_filter').val()+'&sites='+$('#sites').val()+'&division_id='+$('#division_id').val();
							window.open(link, '_blank');
          			}

	          		});
						function deleteDivision(id){
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
									$.ajax({type: "POST",url: `{{url('deleteDivision')}}/${id}`, data:{_token:'<?php echo csrf_token();?>'},success: function(result){
										Swal.fire({
											text: "Deleted Succesfully.",
											icon: "success",
											buttonsStyling: !1,
											confirmButtonText: "Ok, got it!",
											customClass: {
												confirmButton: "btn btn-primary"
											}
										})
										loadTableData();
						// window.location.href = "{{ url('/division_consolidation')}}";
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

						function getDivisionFrom(type)
						{
							$('.multiselect-dropdown').remove();
							$.ajax({
								type: "POST",
								url: "{{url('report/getDivisionFrom')}}",
								data: {
									type: type,
									_token: "<?php echo csrf_token();?>"
								},
								success: function (result) {
									$('#divisionFrom').html(result);
									MultiselectDropdown(window.MultiselectDropdownOptions);
								}

							})

						}
						function showHide()
						{
							var format = $('#format').val();
							if (format == 'combine') {
								$('#diviion_div').css('display', 'none');
							}else{
								$('#diviion_div').css('display', '');

							}
						}
					// 	</script>



					@stop