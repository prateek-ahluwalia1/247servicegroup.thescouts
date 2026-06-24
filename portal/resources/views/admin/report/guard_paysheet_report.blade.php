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

		<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"> -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.css"/>
 
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
								<h1 class="text-dark fw-bolder my-0 fs-2">Quick Paysheet</h1>
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
							<!--begin::Form-->
							<!-- <form class="form" action="{{url('guard_payseet')}}" method="POST" enctype="multipart/form-data">  -->
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
												<input type="search" class="form-control form-control-solid ps-10" name="search" id="kt_daterangepicker_1" placeholder="" />
											</div>
											<!--end::Input group-->
											<!--begin:Action-->
											<div class="d-flex align-items-center">
												<button type="submit" class="btn btn-primary me-5" onclick="get_paysheet(true)">Search</button>
												
											</div>
											<!--end:Action-->
										</div>
										<!--end::Compact form-->
										
									</div>
									<!--end::Card body-->
								</div>
								<!--end::Card-->
							<!-- </form> -->
							<!--end::Form-->
								<!--begin::Toolbar-->
													<div class="card">
															<div class="card-body">
																<div class="row">
																	<div class="col-sm-6 " style="float:left;">

																		
																	</div>
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
														<div class="table-responsive" id="payrate-table">
														    <table id="example" class="table table-responsive gy-5 gs-7" style="width:100%">
														        <thead>
														    <tr class="fw-bold ">
														    <th></th>
														     <th> {{config('custom.guard')}} Payroll ID</th>
														     <th> {{config('custom.guard')}} Name</th>
								                              <th>BSB</th>
								                              <th>Account</th>	
								                              <th>Amount</th>	
														     	</tr>
														        </thead>
														        <tbody id="example_body">
														        	
           															       				        	
														        </tbody>
														       
														    </table>
														</div>
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
																	<!-- <option value="csv">CSV</option> -->
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
		<!-- <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> -->
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.js"></script>


		<!-- <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> -->
		<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
		<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>

<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script> -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>



		<script >
			var is_date = false;
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

			function format ( d ) {
    // `d` is the original data object for the row
    return '<table class="table table-responsive table-hover table-striped  gy-5 gs-7" cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
    '<tr class="fw-bold ">'+
            '<th></th>'+
            '<th>Hours</th>'+
            // '<th>Rate</th>'+
            '<th>Amount</th>'+
        '</tr>'+
        '<tr>'+
            '<td class="fw-bold ">Day:</td>'+
            '<td>'+d.day+'</td>'+
            // '<td>$'+d.rate+'</td>'+
            '<td>$'+(d.day_pay).toFixed(2)+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td class="fw-bold ">Night:</td>'+
            '<td>'+d.night+'</td>'+
            // '<td>$'+d.rate+'</td>'+
            '<td>$'+(d.night_pay).toFixed(2)+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td class="fw-bold ">Saturday:</td>'+
            '<td>'+d.saturday+'</td>'+
            // '<td>$'+d.rate+'</td>'+
            '<td>$'+(d.saturday_pay).toFixed(2)+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td class="fw-bold ">Sunday:</td>'+
            '<td>'+d.sunday+'</td>'+
            // '<td>$'+d.rate+'</td>'+
            '<td>$'+(d.sunday_pay).toFixed(2)+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td class="fw-bold ">Public Holiday:</td>'+
            '<td>'+d.ph+'</td>'+
            // '<td>$'+d.rate+'</td>'+
            '<td>$'+(d.ph_pay).toFixed(2)+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td></td>'+
            '<td>'+(d.total_hours).toFixed(2)+'</td>'+
            // '<td class="fw-bold">Total Gross</td>'+
            '<td>'+d.pay+'</td>'+
        '</tr>'+
        
    '</table>';
}
			function get_paysheet(is_date = false)
			{
				var date = '';
				$('#payrate-table').html(`<table id="example" class="table table-responsive gy-5 gs-7" style="width:100%">
														        <thead>
														    <tr class="fw-bold ">
														    <th></th>
														     <th> {{config('custom.guard')}} Payroll ID</th>
														     <th> {{config('custom.guard')}} Name</th>
								                              <th>BSB</th>
								                              <th>Account</th>	
								                              <th>Amount</th>	
														     	</tr>
														        </thead>
														        <tbody id="example_body">
														        	
           															       				        	
														        </tbody>
														       
														    </table>`);
				if (is_date) {
					date = $('#kt_daterangepicker_1').val();
				}
				$.ajax({
					type: "POST",
					url:"{{url('guard_paysheet_report')}}",
					data : { _token : '<?php echo csrf_token(); ?>', search : date},
					success: function(result){
						console.log(result.data)

						$('#example').DataTable().destroy();

						var table = $('#example').DataTable( {
							data : result.data,
        				columns: [
			            {
			                "className":      'details-control',
			                "orderable":      false,
			                "data":           null,
			                "defaultContent": ''
			            },
			            { "data": "guard_payroll_id" },
			            { "data": "name" },
			            { "data": "bsb" },
			            { "data": "bank" },
			            { "data": "pay" }
			        ],
        			order: [[2, 'asc']],
     //    			buttons: [
					// 'copyHtml5',
					// 'excelHtml5',
					// 'csvHtml5',
					// 'pdfHtml5'
					// ],
					// dom: 'Bfrtip',
    } );
     
    // Add event listener for opening and closing details
    $('#example tbody').on('click', 'td.details-control', function () {
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
								
						 }})
			}
			
			$(document).ready(function() {
				// get_paysheet();
			// var table = $('#example').DataTable();
   //  	    var dt = $('#example').DataTable({
   //  	    	dom: 'Bfrtip',
			// 	responsive: true,
			// 	retrieve: true,
			// 	buttons: [
			// 		'copyHtml5',
			// 		'excelHtml5',
			// 		'csvHtml5',
			// 		'pdfHtml5'
			// 		]
			// });
    	    // $('#example_filter').hide();
			// $('.dt-buttons').hide();
			$("#kt_daterangepicker_1").daterangepicker();
			$('#kt_daterangepicker_1').on('change', function(){
	is_date = true;
})
});

			function upcoming_jobs(){

		$('#example').DataTable().destroy();
        getJobsData ('pending', 'example');

			}

			
			function generate_paysheet_pdf(check, is_date = false)
			{
				var date = '';
				if (is_date) {
					date = $('#kt_daterangepicker_1').val();
				}
				// if(check=="pdf"){
				// 	var url = "{{url('generate_paysheet_pdf/')}}?search="+date
				// 		window.open(url,'_blank');
				// }else{


				// $.ajax({
				// 	type: "POST",
				// 	url:"{{url('generate_paysheet_pdf')}}",
				// 	data : { _token : '<?php echo csrf_token(); ?>', search : date,type:check},
				// 	success: function(result){
						
						var url = "{{url('generate_paysheet_pdf/')}}?search="+date+"&type="+check
						window.open(url,'_blank');						
					// }
					// });
			// }
		}

  $("#export_user_form").on('submit', function(e){

						     var format =$('#format').val();

						     if(format == "pdf")
						     {
								generate_paysheet_pdf("pdf", is_date);
						    
						     }
						       if(format == "excel")
						     {
						     	console.log('excel');

								generate_paysheet_pdf("excel", is_date);


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






	// 	</script>



@stop