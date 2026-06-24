@section('leave_management') 
<?php

$item = session()->get('guards_navigation_bar');
// @dd($item);
if (!empty($item)) {
	foreach (session()->get('guards_navigation_bar') as $item1) {
		$item = $item1;
	}
} else {
	$item['leave_management'] = 1;
	$item = json_decode(json_encode($item));
}
?>
@if (isset($item->leave_management) && $item->leave_management ==1)
@if(session()->get('userType')!='guard')
<div class="col-md-4">
	<!--begin::Card-->
	<div class="card card-flush h-md-100">
		<!--begin::Card header-->
		<div class="card-header">
			<!--begin::Card title-->
			<div class="card-title">
				<h2>Leave Management </h2> </div>
			<!--end::Card title-->
		</div>
		<!--end::Card header-->
		<!--begin::Card body-->
		<div class="card-body pt-1">
			<div class="fw-bolder text-gray-600 mb-5">Optional</div>
		</div>
		<!--end::Card body-->
		<!--begin::Card footer-->
		<div class="card-footer flex-wrap pt-0"> {{-- data-bs-target="#guard_avability-modal" --}}
			<button type="button" class="btn btn-white btn-active-light-primary my-1" data-bs-toggle="modal" id="leave_management_button">Open Leave Management</button>
		</div>
		<!--end::Card footer-->
	</div>
	<!--end::Card-->
</div>
<!-- modal  -->
<div class="modal fade" id="leave_management-modal" tabindex="-1" aria-hidden="true">
	<!--begin::Modal dialog-->
	<div class="modal-dialog modal-dialog-centered mw-750px">
		<!--begin::Modal content-->
		<div class="modal-content">
			<!--begin::Modal header-->
			<div class="modal-header">
				<!--begin::Modal title-->
				<h2 class="fw-bolder" id="form_head">
												{{config('custom.guard')}} Leave Management </h2>
				<!--end::Modal title-->
				<!--begin::Close-->
				<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close"> <span class="svg-icon svg-icon-2x">X</span> </div>
				<!--end::Close-->
			</div>
			<!--end::Modal header-->
			<!--begin::Modal body-->
			<div class="modal-body scroll-y mx-5 my-7">
				<!--begin::Form-->
				<form id="leave_management-form" class="form" action="{{url('guard/update_guard_leave_management')}}" method="POST" enctype="multipart/form-data"> @csrf
					<input type="hidden" class="form-control form-control-md" id="guard_id" name="guard_id" value="{{ $guard_id }}">
					<table class="table table-striped gy-7 gs-7">
						<thead>
							<tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
								<th>Annual Leave as per hours </th>
								<th>Sick Leave as per hours</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
								<input type="text" name="annual_leave_hours" id="annual_leave_hours" placeholder="Enter Annually Leave Hours"/>
								</td>
                                
								<td>
                                    <input type="text" name="sick_leave_hours" id="sick_leave_hours" placeholder="Enter Annually Leave Hours"/>
                                    </td>
							
							</tr>
						</tbody>
					</table>
					<div class="row ">
						<button type="submit" class="btn-primary btn" style="text-align: center;">Submit</button>
					</div>
				</form>
				<!--end::Form-->
			</div>
			<!--end::Modal body-->
		</div>
		<!--end::Modal content-->
	</div>
	<!--end::Modal dialog-->
</div>
<!--end::Modal - Update role-->
<!--end::Modals-->@endif 
@endif
@stop