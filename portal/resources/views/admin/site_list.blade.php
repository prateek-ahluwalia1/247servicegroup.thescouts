
@extends('layout.app')
@extends('layout.sidebar')
@include('layout.toolbar')	
@extends('layout.footer')

@section('pageCss')
<base href="../../../">
<meta charset="utf-8" />
<title>{{ config('custom.title');}}</title>
<!--begin::Fonts-->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700" />
<!--end::Fonts-->
<!--begin::Global Stylesheets Bundle(used by all pages)-->
<link href="{{asset('')}}plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
<link href="{{asset('')}}css/style.bundle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	th,td{
		padding: 5px !important;
	}
	th{
		font-weight: bold !important;
	}
</style>
<!--end::Global Stylesheets Bundle-->
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
				<h1 class="text-dark fw-bolder my-0 fs-2">Site List</h1>
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
			<!--begin::Navbar-->
			<div class="card mb-6">
				<div class="card-body pt-9 pb-0">
					<!--begin::Details-->
					<div class="d-flex flex-wrap flex-sm-nowrap mb-3">
						
						<!--begin::Info-->
						<div class="flex-grow-1">
							
							<div class="row">
								<div class="col-6">
									<div class="d-flex flex-wrap flex-stack">

										<!--begin::Progress-->
										<div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
											<div class="d-flex justify-content-between w-100 mt-auto mb-2">
												<span class="fw-bold fs-6 text-gray-400" style="color:#000000 !important;">Sort By Customer</span>

											</div>
											<div class="h-5px mx-3 w-100 mb-3">
												<select name="customer-selection" id="customer-selection" multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1" onchange="loadSites()">
													<?php 
													?>
													@foreach($customers as $ad)
													<option value="{{$ad->id}}">{{$ad->name}}</option>
													@endforeach
												</select>
											</div>
										</div>
										<!--end::Progress-->
									</div>
								</div>

								<div class="col-6">
									<div class="d-flex flex-wrap flex-stack">

										<!--begin::Progress-->
										<div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
											<div class="d-flex justify-content-between w-100 mt-auto mb-2">
												<span class="fw-bold fs-6 text-gray-400" style="color:#000000 !important;">Sort By</span>

											</div>
											<div class="h-5px mx-3 w-100 mb-3">
												<select name="sort_by" id="sort_by" class="form-control" multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1" onchange="loadSites()">
													<option value="all">All</option>
													<option value="active">Active</option>
													<option value="inactive">Inactive</option>
												</select>
											</div>
										</div>
										<!--end::Progress-->
									</div>

								</div>
							</div>
							<!--  -->

						</div>
						<!--end::Info-->
					</div>
					<!--end::Details-->
					<!--begin::Navs-->
					<div class="d-flex overflow-auto h-55px">
						<ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder flex-nowrap">
							<!--begin::Nav item-->
							<li class="nav-item">
								<a class="nav-link text-active-primary me-6 active"></a>
							</li>
							<!--end::Nav item-->
						</ul>
					</div>
					<!--begin::Navs-->
				</div>
			</div>
			<!--end::Navbar-->
			<!--begin::Timeline-->
			<div class="card mt-5 mt-xxl-8">
				<!--begin::Card body-->
				<div class="card-body">
					<!--begin::Tab Content-->
					<div class="tab-content">
						<!--begin::Tab panel-->
						<div id="kt_activity_today" class="card-body p-0 tab-pane fade show active" role="tabpanel" aria-labelledby="kt_activity_today_tab">
							<!--begin::Timeline-->
							<div class="timeline" id="activity_log_data">
								<div class="row">
									<div class="container-fluid">
										<div id="other-table" style="overflow-x: auto; max-width: 100%;">
											<table id="example" class="table table-responsive table-striped table-bordered" >
												<thead style="background-color: white; padding: 10px;" >
													<tr>
														<th>ID</th>
														<th >Site Name</th>
														<th >Site Description</th>
														<th >Edit</th>
														<th >Delete</th>
													</tr>
												</thead>
												<tbody id="example_body">


												</tbody>

											</table>
										</div>
									</div>
								</div>
							</div>
							<!--end::Timeline-->
						</div>
						<!--end::Tab panel-->
					</div>
					<!--end::Tab Content-->
				</div>
				<!--end::Card body-->
			</div>
			<!--end::Timeline-->
		</div>
		<!--end::Container-->
	</div>
	
<!--begin::Modal - New site-->
<div class="modal fade" id="kt_modal_edit_site" tabindex="-1" aria-hidden="true">
	<!--begin::Modal dialog-->
	<div class="modal-dialog modal-dialog-centered mw-650px">
		<!--begin::Modal content-->
		<div class="modal-content">
			<!--begin::Form-->

			<form class="form" action="#" id="savesiteForm" enctype="multipart/form-data">
				<!--begin::Modal header-->
				<div class="modal-header">
					<!--begin::Modal title-->
					<h2 class="fw-bolder" data-kt-calendar="title">Update Site</h2>
					<!--end::Modal title-->
					<!--begin::Close-->
					<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
						<span class="svg-icon svg-icon-1">
							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
								<g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
									<rect fill="#000000" x="0" y="7" width="16" height="2" rx="1"></rect>
									<rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1"></rect>
								</g>
							</svg>
						</span>
						<!--end::Svg Icon-->
					</div>
					<!--end::Close-->
				</div>
				<!--end::Modal header-->
				<!--begin::Modal body-->
				<div class="modal-body py-10 px-lg-17" id="edit-site-form-html">


					<!--end::Input group-->
				</div>
				<!--end::Modal body-->
				<!--begin::Modal footer-->
				<div class="modal-footer flex-center">
					<!--begin::Button-->
					<button type="reset" id="kt_modal_add_site_cancel" class="btn btn-white me-3" data-bs-dismiss="modal">Cancel</button>
					<!--end::Button-->
					<!--begin::Button-->
					<button type="submit" id="kt_modal_add_event_submit eventsaveBtn" class="btn btn-primary">
						<span class="indicator-label">Save</span>
						<span class="indicator-progress">Please wait...
							<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
						</button>
						<!--end::Button-->
					</div>
					<!--end::Modal footer-->
				</form>
				<!--end::Form-->
			</div>
		</div>
	</div>
	<!--end::Modal - New Product-->
 <!--begin::Modal - Pay Charge History-->
    <div class="modal fade" id="kt_modal_pay_charge_history" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Form-->
                <form class="form" action="#" id="savesiteForm">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2 class="fw-bolder" data-kt-calendar="title">History</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
                            <span class="svg-icon svg-icon-1">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)"
                                        fill="#000000">
                                        <rect fill="#000000" x="0" y="7" width="16"
                                            height="2" rx="1"></rect>
                                        <rect fill="#000000" opacity="0.5"
                                            transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)"
                                            x="0" y="7" width="16" height="2"
                                            rx="1"></rect>
                                    </g>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body py-10 px-lg-17" id="pay-charge-html">


                        <!--end::Input group-->
                    </div>
                    <!--end::Modal body-->
                    <!--begin::Modal footer-->
                    <div class="modal-footer flex-center">
                    </div>
                    <!--end::Modal footer-->
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
    <!--end::Modal - New Product-->

	<!--end::Content-->
	<!--begin::Footer-->
	@section('pageFooter')
	<!--end::Scrolltop-->
	<!--end::Main-->
	<!--begin::Javascript-->
	<!--begin::Global Javascript Bundle(used by all pages)-->
	<script src="{{asset('')}}plugins/global/plugins.bundle.js"></script>
	<script src="{{asset('')}}js/scripts.bundle.js"></script>
	<!--end::Global Javascript Bundle-->
	<!--begin::Page Custom Javascript(used by this page)-->
	<script src="{{asset('')}}js/custom/modals/offer-a-deal.bundle.js"></script>
	<script src="{{asset('')}}js/custom/widgets.js"></script>
	<script src="{{asset('')}}js/custom/apps/chat/chat.js"></script>
	<script src="{{asset('')}}js/custom/modals/create-app.js"></script>
	<script src="{{asset('')}}js/custom/modals/upgrade-plan.js"></script>
	<script src="{{asset('')}}js/custom/apps/calendar/calendar.js"></script>
	{{-- <script src="{{asset('')}}js/job_roster.js"></script> --}}


	<!--end::Page Custom Javascript-->
	<!--end::Javascript-->
	<script type="text/javascript">

$("#savesiteForm").submit(function(e) {
    // alert('here waqas');
    e.preventDefault();
    // var data = $(this).serialize();
    // console.log(data)
    var data = new FormData(this);
    console.log(data)
    $.ajax({
        type: "POST",
        url: base_url + "/job/add_site",
        data: data,
        dataType: "json",
                    cache: false,
                    contentType: false,
                    processData: false,
        success: function(result) {
            if (result.success) {
                $('#kt_modal_add_site').modal('hide');
                $('#kt_modal_edit_site').modal('hide');
                Swal.fire({
                    text: result.message,
                    icon: "success",
                    buttonsStyling: !1,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-light"
                    }
                })
            }else{
                Swal.fire({
                    text: result.message,
                    icon: "error",
                    buttonsStyling: !1,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-light"
                    }
                })
            }
                // $('#add-site-form-html').html(result);
                // $('#customer-selection').html(list);

            }
        });
})

		$("#kt_daterangepicker_1").daterangepicker();

		$( document ).ready(function() {
			MultiselectDropdown();
			$('#kt_daterangepicker_1').on('change', function(){
				loadActivity();
			});

		});
		function loadSites()
		{
			var customers_id = $('#customer-selection').val(); 
			var sort_by = $('#sort_by').val();
			$.ajax({
				type: "POST",
				url: `{{url('get_site_list')}}`,
				data:{_token:'<?php echo csrf_token();?>', customers_id : customers_id, sort_by : sort_by},
				success: function(result){
					console.log(result.permissions);
					if(result.permissions.site_edit == true && result.permissions.site_delete == true){
						var table = '';
							$.each(result.data, function(indx, valx){
								table += '<tr><td>'+valx.id+'</td><td><a href="{{url("site_list_detail")}}?site='+valx.id+'&customer_id='+valx.customer_id+'" target="_blank">'+valx.site_name+'</a></td><td>'+valx.site_description+'</td><td><i class="fas fa-edit m-1" onclick="editSite('+valx.id+')"></i></td><td><i class="fas fa-trash m-1" onclick="deleteSite('+valx.id+')"></i></td></tr>';
							});
						$('#example_body').html(table);
					}else if(result.permissions.site_edit == true){
						var table = '';
							$.each(result.data, function(indx, valx){
								table += '<tr><td>'+valx.id+'</td><td><a href="{{url("site_list_detail")}}?site='+valx.id+'&customer_id='+valx.customer_id+'" target="_blank">'+valx.site_name+'</a></td><td>'+valx.site_description+'</td><td><i class="fas fa-edit m-1" onclick="editSite('+valx.id+')"></i></td></tr>';
							});
						$('#example_body').html(table);
					}else if(result.permissions.site_delete == true){
						var table = '';
							$.each(result.data, function(indx, valx){
								table += '<tr><td>'+valx.id+'</td><td><a href="{{url("site_list_detail")}}?site='+valx.id+'&customer_id='+valx.customer_id+'" target="_blank">'+valx.site_name+'</a></td><td>'+valx.site_description+'</td><td><i class="fas fa-trash m-1" onclick="deleteSite('+valx.id+')"></i></td></tr>';
							});
						$('#example_body').html(table);
					}else{
						var table = '';
							$.each(result.data, function(indx, valx){
								table += '<tr><td>'+valx.id+'</td><td><a href="{{url("site_list_detail")}}?site='+valx.id+'&customer_id='+valx.customer_id+'" target="_blank">'+valx.site_name+'</a></td><td>'+valx.site_description+'</td></tr>';
							});
						$('#example_body').html(table);
					}
				}
			}) 
			// window.location.href = '{{url("activity_log?admin_id=")}}'+admin_id+'&search='+date
		}
		function load_chargerates() {

            var level = $('#site_chargerate_level').val();
            $.ajax({
                type: "POST",
                url: "{{ url('guard/load_chargerates') }}",
                data: {
                    level: level,
                    _token: "<?php echo csrf_token(); ?>"
                },
                success: function(result) {
                    html = '<option>Select</option>';
                    $.each(result, function(id, data) {
                        html += `<option value="${data.id}">${data.title}</option>`;
                    });
                    $('#site_charge_rate').html(html);
                }

            });
        }
        function load_payrates(site_id = false) {
            var level = $('#site_payrate_level').val();
            // console.log(level);
            $.ajax({
                type: "POST",
                url: "{{ url('guard/load_payrates') }}",
                data: {
                    level: level,
                    _token: "<?php echo csrf_token(); ?>",
                    site_id : site_id
                },
                success: function(result) {
                    html = '<option>Select</option>';
                    $.each(result, function(id, data) {
                        html += `<option value="${data.id}">${data.title}</option>`;
                    });
                    $('#site_payrate').html(html);
                }

            });
        }
	</script>
	@stop
	<!--end::Footer-->
	<!-- </div> -->
	<!--end::Wrapper-->
	@stop
