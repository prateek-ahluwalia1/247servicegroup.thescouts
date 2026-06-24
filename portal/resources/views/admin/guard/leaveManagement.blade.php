

	@extends('layout.app')
	@extends('layout.sidebar')
	@extends('layout.footer')

	@section('pageCss')
	<base href="../../../">
		<meta charset="utf-8" />
		<title>{{ config('custom.title');}}</title>
		<meta name="description" content="{{ config('custom.title') }}" />
		<meta name="keywords" content="{{ config('custom.title')}}" />
		<link rel="canonical" href="Https://preview.keenthemes.com/metronic8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!-- <link rel="shortcut icon" href="{{ asset('')}}media/logos/favicon.ico" /> -->
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Vendor Stylesheets(used by this page)-->
		<link href="{{ asset('')}}plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Page Vendor Stylesheets-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="{{ asset('')}}plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="{{ asset('')}}css/style.bundle.css" rel="stylesheet" type="text/css" />
<style>
.bod
{
	/*border: 1px solid #000000;*/
}
		<!--end::Global Stylesheets Bundle-->

@foreach($guards as $guard)
		@if($guard->profile_image  == NULL)



#profile_{{$guard->id}} {
width: 50px;
height: 50px;
border-radius: 50%;
background: #512DA8;
font-size: 15px;
color: #fff;
text-align: center;
line-height: 50px;
margin: 5px 0;
}


	
	@endif
@endforeach 

@stop
</style>

	<!--end::Head-->
	<!--begin::Body-->
	
		<!--begin::Main-->
		<!--begin::Root-->
	@section('content')
						<!--end::Logo-->
				
				<!--begin::Wrapper-->
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
					<!--begin::Header-->
					<div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
						<!--begin::Container-->
						<div class="container d-flex align-items-center justify-content-between" id="kt_header_container">
							<!--begin::Page title-->
							<div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-2 pb-2 pb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
								<!--begin::Heading-->
								<h1 class="text-dark fw-bolder my-0 fs-2">{{config('custom.guard')}}s Leave Management</h1>
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
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Container-->
						<div class="container" id="kt_content_container">
							<!--begin::Card-->
							<div class="card">
								<div class="card-header p-2">
									<div class="row flex-row-fluid pe-11 mb-5">
													<!--begin::Label-->
													<div class="col-sm-12 col-md-6 col-lg-4 d-flex fs-6 fw-bold align-items-center">
														<div class="bullet bg-primary me-3"></div>
														<div class="text-gray-400">WH = Worked Hours</div>
														<!-- <div class="ms-auto fw-bolder text-gray-700">30</div> -->
													</div>
													<!--end::Label-->
													<!--begin::Label-->
													<div class="col-sm-12 col-md-6 col-lg-4 d-flex fs-6 fw-bold align-items-center">
														<div class="bullet bg-success me-3"></div>
														<div class="text-gray-400">AAL = Accumulated Annual Leaves</div>
														<!-- <div class="ms-auto fw-bolder text-gray-700">45</div> -->
													</div>
													<!--end::Label-->
													<!--begin::Label-->
													<div class="col-sm-12 col-md-6 col-lg-4 d-flex fs-6 fw-bold align-items-center">
														<div class="bullet bg-gray-300 me-3"></div>
														<div class="text-gray-400">ASL = Accumulated Sick Leaves</div>
														<!-- <div class="ms-auto fw-bolder text-gray-700">25</div> -->
													</div>
													<!--end::Label-->
													<!--begin::Label-->
													<div class="col-sm-12 col-md-6 col-lg-4 d-flex fs-6 fw-bold align-items-center">
														<div class="bullet bg-primary me-3"></div>
														<div class="text-gray-400">UAL = Used Annual Leaves</div>
														<!-- <div class="ms-auto fw-bolder text-gray-700">30</div> -->
													</div>
													<!--end::Label-->
													<!--begin::Label-->
													<div class="col-sm-12 col-md-6 col-lg-4 d-flex fs-6 fw-bold align-items-center">
														<div class="bullet bg-success me-3"></div>
														<div class="text-gray-400">USL = Used Sick Leaves</div>
														<!-- <div class="ms-auto fw-bolder text-gray-700">45</div> -->
													</div>
													<!--end::Label-->
													<!--begin::Label-->
													<div class="col-sm-12 col-md-6 col-lg-4 d-flex fs-6 fw-bold align-items-center">
														<div class="bullet bg-gray-300 me-3"></div>
														<div class="text-gray-400">RAL = Remaining Anual Leaves</div>
														<!-- <div class="ms-auto fw-bolder text-gray-700">25</div> -->
													</div>
													<!--end::Label-->
													<!--begin::Label-->
													<div class="col-sm-12 col-md-6 col-lg-4 d-flex fs-6 fw-bold align-items-center">
														<div class="bullet bg-success me-3"></div>
														<div class="text-gray-400">RSL = Remaining Sick Leaves</div>
														<!-- <div class="ms-auto fw-bolder text-gray-700">25</div> -->
													</div>
													<!--end::Label-->
												</div>
								</div>
								<!--begin::Card header-->
								<div class="card-header border-0 pt-6">
									<div class="card-title">
										<!--begin::Search-->
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
											<input type="text" id="search"  class="form-control form-control-solid w-250px ps-14" placeholder="Search user" />
										</div>
										<!--end::Search-->
									</div>
									</div>	
									<!--begin::Card toolbar-->
									<div class="card-toolbar">
										
								<!--end::Card header-->
								<!--begin::Card body-->
								<div class="tab-content card-body pt-0  " >

								<div  class="tab-pane fade show active"  id="active_guards" role="tabpanel" aria-labelledby="active_guards-tab">
									<!--begin::Table-->
									<table id="leave_table" class="table table-striped  align-middle table-row-dashed fs-6 gy-5" style="width: 100%;">
										<!--begin::Table head-->
										<thead class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
											<!--begin::Table row-->
											{{-- <tr > --}}
												
											
												<th class="min-w-125px">{{config('custom.guard')}}</th>
												<!-- <th class="">Phone</th> -->
												<th class="">WH</th>
												<th class="">AAL</th>
												<th class="">ASL</th>
												<th class="">UAL</th>
												<th class="">USL</th>
												<th class="">RAL</th>
												<th class="">RSL</th>
												<th class="">Details</th>

											{{-- </tr> --}}
											<!--end::Table row-->
										</thead>
										<!--end::Table head-->
										<!--begin::Table body-->
										<tbody id="leave_table_body" class="text-gray-600 fw-bold">
											<!--begin::Table row-->
											@foreach($guards as $active_guard)
											<tr>
												<!--begin::Checkbox-->
												
												<!--end::Checkbox-->
												<!--begin::User=-->
												<td class="d-flex align-items-center">
													<!--begin:: Avatar -->
						
																@if ($active_guard->profile_image!=null)
																<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
																	<div class="symbol-label ">
																	<img src="{{config('custom.asset_url').$active_guard->profile_image}}" alt="" class="w-100" />
																</div>
															</div>
																	@else
																<div class="symbol symbol-circle  symbol-50px overflow-hidden me-3">
																	<div class="symbol-label" id="profile_{{$active_guard->id}}" style="background: #d99f23;color:white" class="">
																		<img  alt="" class=" w-100" />
																	</div>
																  </div>
																	
																@endif
													
													<!--end::Avatar-->
													<!--begin::User details-->
													<div class="d-flex flex-column">
														<a href="{{url('guard_profile') . '/' . $active_guard->id}}" class="text-gray-800 text-hover-primary mb-1">{{$active_guard->name}}</a>
														<span>{{$active_guard->email}}</span>
														<span>{{$active_guard->phone}}</span>
													</div>
													<!--begin::User details-->
												</td>
												<!--end::User=-->
												<!--begin::Role=-->


												<!--end::Role=-->
												<!--begin::Last login=-->
												
												<td>
													{{number_format($active_guard->hours_worked, 2)}}
												</td>
												<td>
													{{number_format($active_guard->annual_hours,2)}}
												</td>
												<td>
													{{number_format($active_guard->sick_leave_hours,2)}}
												</td>
												<td>
													{{number_format($active_guard->leave_hours_annual,2)}}
												</td>
												<td>
													{{number_format($active_guard->leave_hours_sick,2)}}
												</td>
												<td>
													{{number_format(($active_guard->annual_hours - $active_guard->leave_hours_annual),2)}}
												</td>
												<td>
													{{number_format(($active_guard->sick_leave_hours - $active_guard->leave_hours_sick),2)}}
												</td>
												<td>
													<i class="fas fa-clipboard-list" style="cursor: pointer;" onclick="leaveDetails({{$active_guard->id}})"><span class="badge badge-sm badge-circle badge-light-success">{{$active_guard->leave_request}}</span></i>
												</td>
											</tr>
											@endforeach
											<!--end::Table row-->
										</tbody>
										<!--end::Table body-->
									</table>
									<!--end::Table-->
								</div>
								</div>

								<!--end::Card body-->
							</div>
							<!--end::Card-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Content-->
					<!--begin::Footer-->
				</div>
			
		<!--end::Root-->
		<!--begin::Drawers-->
		<!--begin::Activities drawer-->
		
		<!--end::Chat drawer-->
		<!--begin::Exolore drawer toggle-->
		<div class="modal" id="kt_modal_leave_details" tabindex="-1" aria-modal="true" role="dialog">
			<!--begin::Modal dialog-->
			<div class="modal-dialog mw-650px">
				<!--begin::Modal content-->
				<div class="modal-content">
					<!--begin::Modal header-->
					<div class="modal-header pb-0 border-0 justify-content-end">
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
					<!--begin::Modal header-->
					<!--begin::Modal body-->
					<div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
						<!--begin::Heading-->
						<div class="text-center mb-7">
							<!--begin::Title-->
							<h1 class="mb-3">Guard Leave Details</h1>
							<!--end::Title-->
						</div>
						<!--end::Heading-->
					
						<!--begin::Users-->
						<div class="mb-10">
							<!--begin::List-->
							<div class="me-n7 pe-7">
								<ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
								    <li class="nav-item">
								        <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_pane_1">Leave by Admin</a>
								    </li>
								    <li class="nav-item">
								        <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_2">Leave request by Guard</a>
								    </li>
								    
								</ul>
								<div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
            	<div class="kt_table_leave_error" style="display: none;">
            		<h4>There is no leave details!</h4>
            	</div>
            	<div class="kt_table_leave_details">
                <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer" id="kt_table_leave_details" role="grid">
										<!--begin::Table head-->
										<thead>
											<!--begin::Table row-->
											<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0" role="row" >
												<th class="bod">Type</th>
												<th class="bod">Start Time</th>
												<th class="bod">End Time</th>
												<th class="bod">Total Hours</th>
												<th class="bod">Paid hours</th>
												<th class="bod">Non-paid Hours</th>
											</tr>
											<!--end::Table row-->
										</thead>
										<!--end::Table head-->
										<!--begin::Table body-->
										<tbody class="text-gray-600 fw-bold" id="leaveDetailsData">
										
												
										</tbody>
										<!--end::Table body-->
									</table>
								</div>
            </div>

            <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
                <div class="kt_table_leave_request_error" style="display: none;">
            		<h4>There is no leave request!</h4>
            	</div>
            	<div class="kt_table_leave_request">
                <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer" id="kt_table_leave_request" role="grid">
										<!--begin::Table head-->
										<thead>
											<!--begin::Table row-->
											<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0" role="row" >
												<th class="bod">Start Time</th>
												<th class="bod">End Time</th>
												<th class="bod">Notes</th>
												<th class="bod">Action</th>
											</tr>
											<!--end::Table row-->
										</thead>
										<!--end::Table head-->
										<!--begin::Table body-->
										<tbody class="text-gray-600 fw-bold" id="leaveRequestData">
										
												
										</tbody>
										<!--end::Table body-->
									</table>
								</div>
            </div>

           
        </div>
								
							</div>
							<!--end::List-->
						</div>
						<!--end::Users-->
						
					</div>
					<!--end::Modal body-->
				</div>
				<!--end::Modal content-->
			</div>
			<!--end::Modal dialog-->
		</div>
<!--  -->

<!--begin::Exolore drawer toggle-->
		<div class="modal" id="kt_modal_leave_aproved_type" tabindex="-1" aria-modal="true" role="dialog">
			<!--begin::Modal dialog-->
			<div class="modal-dialog mw-650px">
				<!--begin::Modal content-->
				<div class="modal-content">
					<!--begin::Modal header-->
					<div class="modal-header pb-0 border-0 justify-content-end">
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
					<!--begin::Modal header-->
					<!--begin::Modal body-->
					<div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
						<!--begin::Heading-->
						<div class="text-center mb-7">
							<!--begin::Title-->
							<h1 class="mb-3">Leave Type</h1>
							<!--end::Title-->
						</div>
						<!--end::Heading-->
					
						<!--begin::Users-->
						<div class="mb-10">
							<!--begin::List-->
							<div class="me-n7 pe-7">
								<input type="hidden" name="leaveId" id="leaveId">
																				<div class="row g-9 mb-8">
													<!--begin::Col-->
													<div class="col-md-6 fv-row">
														<label class="required fs-6 fw-bold mb-2">Select Leave Type</label>
														<select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Select a type" name="leaveType" id="leaveType">
															<option value="">Select...</option>
															<option value="annual">Annual Leave</option>
															<option value="sick">Sick Leave</option>
															<option value="basic">Basic Leave</option>
														</select>
													</div>
												</div>
								<div class="text-center">
													<button data-bs-dismiss="modal" class="btn btn-white me-3">Cancel</button>
													<button type="submit" id="kt_modal_new_target_submit" class="btn btn-primary">
														<span class="indicator-label">Approved</span>
														<!-- <span class="indicator-progress">Please wait...
														<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span> -->
													</button>
												</div>
							</div>
							<!--end::List-->
						</div>
						<!--end::Users-->
						
					</div>
					<!--end::Modal body-->
				</div>
				<!--end::Modal content-->
			</div>
			<!--end::Modal dialog-->
		</div>
		@stop
		<!--end::Scrolltop-->
		<!--end::Main-->
		<!--begin::Javascript-->
		<!--begin::Global Javascript Bundle(used by all pages)-->
		@section('pageFooter')
		<script src="{{ asset('')}}plugins/global/plugins.bundle.js"></script>
		<script src="{{ asset('')}}js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Page Vendors Javascript(used by this page)-->
		<script src="{{ asset('')}}plugins/custom/datatables/datatables.bundle.js"></script>
		<!--end::Page Vendors Javascript-->
		<!--begin::Page Custom Javascript(used by this page)-->
		<script src="{{ asset('')}}js/custom/apps/user-management/users/list/table.js"></script>
		<script src="{{ asset('')}}js/custom/apps/user-management/users/list/export-users.js"></script>
		<script src="{{ asset('')}}js/custom/apps/user-management/users/list/add.js"></script>
		<script src="{{ asset('')}}js/custom/widgets.js"></script>
		<script src="{{ asset('')}}js/custom/apps/chat/chat.js"></script>
		<script src="{{ asset('')}}js/custom/modals/create-app.js"></script>
		<script src="{{ asset('')}}js/custom/modals/upgrade-plan.js"></script>
		<!--end::Page Custom Javascript-->
		<!--end::Javascript-->

<script>
$(document).ready(function(){	
	
	@foreach($guards as $guard)
		@if($guard->profile_image  == NULL)
		// alert(`{{session()->get('userName')}}`);
		var firstName =`{{$guard->name}}`;
			console.log(firstName);
			// var firstName =firstName.text();
			console.log(firstName);
			var intials = firstName.charAt(0);
			console.log(intials);

			var profileImage = $(`#profile_{{$guard->id}}`).text(intials);
			@endif
			@endforeach
			
			$('#leave_table').DataTable();

})
var $rows = $('#leave_table_body tr');
$('#search').keyup(function() {
    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
    
    $rows.show().filter(function() {
        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
        return !~text.indexOf(val);
    }).hide();
});

@if(request()->get('status'))
			var link ="{{request()->get('status')}}";
			console.log(link);
			if (link!='active'){
				$(`#active`).removeClass('active');
			}
			$(`#${link}`).addClass('active');
			$(`#${link}`).click();
			$(`#${link}`).tab("show");
			$(`#${link}`).trigger('click');
			@endif

</script>


	 <script>




	 
	 function avatar_remove(){
	 					  document.getElementById('preview_img').style.backgroundImage=''; 
	 					  				  document.getElementById('file_image').value=''; 

	 }


function getUser(id){
	

			$.ajax({
               type:'POST',
               url:'/getUser/',
               data:{ _token  : '<?php echo csrf_token() ?>', id : id, status : access_level_id},
               success:function(result) {
               	           $('#kt_modal_add_user').modal('show');
						document.getElementById("form_button").innerHTML = "Update!";
					$('#kt_modal_add_user_form').attr('method', "POST");

				    $('#kt_modal_add_user_form').attr('action', "/editUser/"+id);

   
		 		 $('#user_name').val(result.name);
				  $('#user_email').val(result.email);
				  				  // $('current_role').val(result.access_level);

				  				  console.log(`role_${result.access_level_id}`);

				  document.getElementById("form_head").innerHTML = "Edit User";
				

				  document.getElementById('preview_img').style.backgroundImage=`url({{asset('')}}media/uploads/${result.image})`; 
				  document.getElementById(`role_${result.access_level_id}`).checked = true;
			
				//   document.getElementById('avatar').style.backgroundImage=`url({{asset('')}}media/uploads/${result.image})`; // specify the image path here

               }
            });
}
function openModal() {
           $('#kt_modal_add_user').modal('show');
       }
	   


	   function resend_guard_email(id){
						     console.log(this.id)

						     $.ajax({type: "POST",url: "{{url('resend_guard_email')}}" ,data :{id:id,_token:'<?php echo csrf_token();?>'} ,success: function(result){if(result.success){
						     	$('#sites_blocked-modal').modal('hide');

						     	Swal.fire({
						                        text: result.message,
						                        icon: "success",
						                        buttonsStyling: !1,
						                        confirmButtonText: "Ok, got it!",
						                        customClass: {
						                            confirmButton: "btn btn-light"
						                        }
                    })
						     }else{Swal.fire({
						                        text: result.error,
						                        icon: "error",
						                        buttonsStyling: !1,
						                        confirmButtonText: "Ok, got it!",
						                        customClass: {
						                            confirmButton: "btn btn-light"
						                        }
                    })}}})
	   }




function deleteUser(id){

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
						$.ajax({type: "POST",url: '/deleteguard/'+id, data:{_token:'<?php echo csrf_token();?>'},success: function(result){
							Swal.fire({
						text: "Deleted Succesfully.",
						icon: "success",
						buttonsStyling: !1,
						confirmButtonText: "Ok, got it!",
						customClass: {
							confirmButton: "btn btn-primary"
						}
					})
				}
						})

					) : "cancel" === t.dismiss && Swal.fire({
						text: "Your action has  been cancelled!.",
						icon: "error",
						buttonsStyling: !1,
						confirmButtonText: "Ok, got it!",
						customClass: {
							confirmButton: "btn btn-primary"
						}
					})
				}))


       }


	   
function restoreguard(id){

var id=id;

Swal.fire({
				text: "Are you sure you want to restore ?",
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
					$.ajax({type: "POST",url: '/restoreguard/'+id, data:{_token:'<?php echo csrf_token();?>'},success: function(result){
						Swal.fire({
					text: "Restored Succesfully.",
					icon: "success",
					buttonsStyling: !1,
					confirmButtonText: "Ok, got it!",
					customClass: {
						confirmButton: "btn btn-primary"
					}
				})
			}
					})

				) : "cancel" === t.dismiss && Swal.fire({
					text: "Your action has been cancelled!.",
					icon: "error",
					buttonsStyling: !1,
					confirmButtonText: "Ok, got it!",
					customClass: {
						confirmButton: "btn btn-primary"
					}
				})
			}))


   }

$("#kt_modal_add_user_form").trigger('reset')


   //     	$('#kt_modal_add_user_button').click({
	 	// $("#kt_modal_add_user_form")[0].reset();

	 	// });




		 function covid_status(id,e){
			var check='';
			//  console.log(($(e).value());
			if($(e).is(':checked')){
				check="checked";
				$(e).prop("checked", true)
				console.log('check covid');

			}else{
				check="unchecked";
				$(e).prop("checked", false)
				console.log('uncehck covid');


			}
			
			$.ajax({type: "POST",url: "{{url('covid_status')}}", data:{id:id,check:check,_token:'<?php echo csrf_token();?>'},success: function(result){
				

				console.log('done covid');
	}

	});
		 }
		 
		 function admin_approval_status(id,e){
			if($(e).is(':checked')){
				check="checked";
				$(e).prop("checked", true)
				
				console.log('check admin_approval_status');


			}else{
				check="unchecked";
				$(e).prop("checked", false)
				console.log('uncehck admin_approval_status');
				let timerInterval
				Swal.fire({
  title: 'Covid Status Unchecked !',
//   html: 'I will close in <b></b> milliseconds.',
  timer: 1000,
  timerProgressBar: true,
  didOpen: () => {
    Swal.showLoading()
    const b = Swal.getHtmlContainer().querySelector('b')
    timerInterval = setInterval(() => {
      b.textContent = Swal.getTimerLeft()
    }, 100)
  },
  willClose: () => {
    clearInterval(timerInterval)
  }
}).then((result) => {
  if (result.dismiss === Swal.DismissReason.timer) {
  }
})


			}
			$.ajax({type: "POST",url: "{{url('admin_approval_status')}}", data:{id:id,check:check,_token:'<?php echo csrf_token();?>'},success: function(result){

				console.log('done admin_approval_status');
	}

	});
		 }
var table = $('#kt_table_leave_details').DataTable();
var table1 = $('#kt_table_leave_request').DataTable();
function leaveDetails(guard_id)
{
	call_spinner();
	$.ajax({
		type: "POST",
		url: "{{url('guard/leaveDetails')}}", 
		data:{guard_id:guard_id, _token:'<?php echo csrf_token();?>'},
		success: function(result){
			if ((result.data).length > 0) {
				$('.kt_table_leave_details').css('display', '');
				$('.kt_table_leave_error').css('display','none')

				var leaveDetailsData = '';
				table.destroy();
				$.each(result.data, function(mind, mval){
					leaveDetailsData += '<tr><td style="text-transform: capitalize;">'+mval.type+'</td><td>'+mval.start_time+'</td><td>'+mval.end_time+'</td><td>'+mval.hours+'</td><td>'+mval.paid_hour+'</td><td>'+mval.nonpaid_hour+'</td></tr>';
				});
				
				$('#leaveDetailsData').html(leaveDetailsData);
				table = $('#kt_table_leave_details').DataTable();
			}else{
				$('.kt_table_leave_error').css('display','')
				$('.kt_table_leave_details').css('display', 'none');
				// Swal.fire({
				// 	text: "There is no leave details!",
				// 	icon: "error",
				// 	buttonsStyling: !1,
				// 	confirmButtonText: "Ok, got it!",
				// 	customClass: {
				// 		confirmButton: "btn btn-primary"
				// 	}
				// })
			}
			if ((result.guard_leaves).length > 0) {
				$('.kt_table_leave_request').css('display', '');
				$('.kt_table_leave_request_error').css('display','none')

				var leaveRequestData = '';
				table1.destroy();
				$.each(result.guard_leaves, function(mind, mval){
					leaveRequestData += '<tr><td>'+mval.start+'</td><td>'+mval.end+'</td><td style="text-transform: capitalize;">'+mval.notes+'</td><td><i class="fas fa-check" style="cursor: pointer;" onclick="changeLeaveStatus('+mval.id+',\'approve\')"></i> <i class="fas fa-times" style="cursor: pointer;" onclick="changeLeaveStatus('+mval.id+',\'reject\')"></i></td></tr>';
				});
				
				$('#leaveRequestData').html(leaveRequestData);
				table1 = $('#kt_table_leave_request').DataTable();
			}else{
				$('.kt_table_leave_request_error').css('display','')
				$('.kt_table_leave_request').css('display', 'none');
				// Swal.fire({
				// 	text: "There is no leave details!",
				// 	icon: "error",
				// 	buttonsStyling: !1,
				// 	confirmButtonText: "Ok, got it!",
				// 	customClass: {
				// 		confirmButton: "btn btn-primary"
				// 	}
				// })
			}
				$('#kt_modal_leave_details').modal('show');
				close_spinner();

		}

	});
}
function changeLeaveStatus(leaveId, action){
if (action == 'reject') {
 Swal.fire({text:"Do you really want to reject this leave?",
       icon:"error",
       showCancelButton:!0,
       buttonsStyling:!1,
       confirmButtonText:"Reject",
       cancelButtonText:"Cancel",
       customClass:{
          confirmButton:"btn fw-bold btn-success",
          cancelButton:"btn fw-bold btn-active-light-primary"
      }
  }).then((function(e){
   if (e.value == true) {
    $.ajax({
        url: base_url + "/guard/changeLeaveStatus",
        type: "post",
        dataType: "json",
        data: {
        	leaveId :leaveId,
        	action : action,
        	_token : token
        },
        success: function(result) {
            if (result.success) {
                Swal.fire({
                   text: result.message,
                   icon:"success",
                   buttonsStyling:!1,
                   confirmButtonText:"Ok, got it!",
                   customClass:{
                      confirmButton:"btn fw-bold btn-primary"
                  }})
				$('#kt_modal_leave_details').modal('hide');

            }else{

                Swal.fire({text:result.message,icon:"error",buttonsStyling:!1,confirmButtonText:"Ok, got it!",customClass:{confirmButton:"btn fw-bold btn-primary"}});
            }
        }
    });
  }
}));
}else{
	$('#leaveId').val(leaveId);
	$('#kt_modal_leave_aproved_type').modal('show');
}

}
$('#kt_modal_new_target_submit').on('click', function(){
	var leaveId = $('#leaveId').val();
	var leaveType = $('#leaveType').val();
	Swal.fire({text:"Do you really want to approve this leave request?",
       icon:"success",
       showCancelButton:!0,
       buttonsStyling:!1,
       confirmButtonText:"Yes",
       cancelButtonText:"Cancel",
       customClass:{
          confirmButton:"btn fw-bold btn-success",
          cancelButton:"btn fw-bold btn-active-light-primary"
      }
  }).then((function(e){
   if (e.value == true) {
    $.ajax({
        url: base_url + "/guard/changeLeaveStatus",
        type: "post",
        dataType: "json",
        data: {
        	leaveId :leaveId,
        	leaveType : leaveType,
        	action : 'approved',
        	_token : token
        },
        success: function(result) {
            if (result.success) {
                Swal.fire({
                   text: result.message,
                   icon:"success",
                   buttonsStyling:!1,
                   confirmButtonText:"Ok, got it!",
                   customClass:{
                      confirmButton:"btn fw-bold btn-primary"
                  }})
				$('#kt_modal_leave_details').modal('hide');
				$('#kt_modal_leave_aproved_type').modal('hide');

            }else{

                Swal.fire({text:result.message,icon:"error",buttonsStyling:!1,confirmButtonText:"Ok, got it!",customClass:{confirmButton:"btn fw-bold btn-primary"}});
            }
        }
    });
  }
}));

});
     </script>



		@stop
