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
				<h1 class="text-dark fw-bolder my-0 fs-2">App Status</h1>
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
				<img alt="Logo" src="{{config('custom.logo')}}" class="h-30px" /> 
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

		<!--begin::Toolbar-->
		<div class="card">
		</br>

		<div class="container">
			<div class="table-responsive" id="table-div">
				<table  id="example" class="table table-responsive table-hover table-striped  gy-5 gs-7" style="width:100%">
					<thead>
						<tr class="fw-bold ">
							<th>Site Name</th>
							<th>{{config('custom.guard')}} Name</th>
							<th>Date</th>
							<th>Shift Start Time</th>
							<th>Shift End Time</th>	
							<th>Signin Time</th>	
							<th>App Status</th>	
							<th>Action</th>	
						</tr>
					</thead>
					<tbody id="example_body">
						@foreach($data as $key => $val)
						<?php 
						$app_status = 'Just Started';
						$badge = 'badge-info';
						$diff = 0;
						if ($val->Guards->last_seen != null) {
							$to_time = time();
							$from_time = $val->Guards->last_seen;
							$diff = round(abs($to_time - $from_time) / 60,2);
						}
						if ($val->Guards->in_radius == 0 || $val->Guards->in_radius == false) {
							if ($diff > 3) {
								$badge = 'badge-warning';
								$app_status = 'Closed';
							}else{
							$badge = 'badge-warning';
							$app_status = 'Leave Location';
							}
						}elseif ($val->Guards->last_seen != null) {

							if ($diff < 3) {
								$badge = 'badge-success';
								$app_status = 'Running';
							}else{
								$badge = 'badge-warning';
								$app_status = 'Closed';
							}
						}else{
							$to_time = time();
							$from_time = strtotime($val->activity->signin_time);
							$diff = round(abs($to_time - $from_time) / 60,2);
							if ($diff < 3) {
								$app_status = 'Just Started';
								$badge = 'badge-info';
							}else{
								$app_status = 'Closed';
								$badge = 'badge-warning';

							}
						}
						
						?>
						<tr>
							<td>{{$val->Site->site_name}}</td>
							<td>{{$val->Guards->name}}</td>
							<td>{{date('d/m/Y', strtotime($val->temp_start))}}</td>
							<td>{{date('H:i:s', strtotime($val->temp_start))}}</td>
							<td>{{date('H:i:s', strtotime($val->temp_end))}}</td>
							<td>{{date('H:i:s', strtotime($val->activity->signin_time))}}</td>
							<td><span class="badge {{$badge}}">{{$app_status}}</span></td>
							<td></td>

						</tr>
						@endforeach

					</tbody>
				</table>
				
			</div>
			<!-- <div class="row"> -->
				<div style="text-align: right;">
					<!-- <nav aria-label="Page navigation example"> -->
						<!-- <ul class="pagination"> -->
							<?php echo $data->render(); ?>
							<!-- </ul> -->
							<!-- </nav> -->
						</div>
						<!-- </div> -->
					</div>
				</div>	

				<!--end::Tab Content-->
				<!--end::Container-->


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

					$(document).ready(function() {
			// var table = $('#example').DataTable();
						$("#kt_daterangepicker_1").daterangepicker();
    	    // var table = $('#example').DataTable({
    	    // 	dom: 'Bfrtip',
			// 	responsive: true,
			// 	retrieve: true,
			// 	searching: true,
			// 	buttons: [
			// 		'copyHtml5',
			// 		'excelHtml5',
			// 		'csvHtml5',
			// 		{
            //     extend: 'pdfHtml5',
            //     orientation: 'landscape',
            //     pageSize: 'A4'
            // }						]
			// });
					});


	// 	</script>



	@stop