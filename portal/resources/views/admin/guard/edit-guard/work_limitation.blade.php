@section('work')
<?php
$item = session()->get('guards_navigation_bar');
// @dd($item);
if (!empty($item)) {
foreach(session()->get('guards_navigation_bar') as $item1) {
	$item = $item1;
}
}else{
	$item['guard_work_limitation'] = 1;
	$item = json_decode(json_encode($item));
}
?>
@if (isset($item->guard_work_limitation) && $item->guard_work_limitation ==1)
@if(session()->get('userType')=='admin')
<div class="col-md-4">
	<!--begin::Card-->
	<div class="card card-flush h-md-100">
		<!--begin::Card header-->
		<div class="card-header">
			<!--begin::Card title-->
			<div class="card-title">
				<h2>{{config('custom.guard')}}  Work Limitation </h2>
			</div>
			<!--end::Card title-->
		</div>
		<!--end::Card header-->
		<!--begin::Card body-->
		<div class="card-body pt-1">
			<div class="fw-bolder text-gray-600 mb-5">Optional</div>




		</div>
		<!--end::Card body-->
		<!--begin::Card footer-->
		<div class="card-footer flex-wrap pt-0">
			{{-- data-bs-target="#guard_avability-modal" --}}


			<button type="button" class="btn btn-white btn-active-light-primary my-1" data-bs-toggle="modal"  id="work_button">Check {{config('custom.guard')}}  Work Limitation</button>

		</div>
		<!--end::Card footer-->
	</div>
	<!--end::Card-->
</div>
<!-- modal  -->
<div class="modal fade" id="work-modal" tabindex="-1" aria-hidden="true">
	<!--begin::Modal dialog-->
	<div class="modal-dialog modal-dialog-centered mw-750px">
		<!--begin::Modal content-->
		<div class="modal-content">
			<!--begin::Modal header-->
			<div class="modal-header">
				<!--begin::Modal title-->
				<h2 class="fw-bolder" id="form_head">
				{{config('custom.guard')}}  Work Limitation </h2>

				<!--end::Modal title-->
				<!--begin::Close-->
				<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">

					<span class="svg-icon svg-icon-2x">X</span>
				</div>
				<!--end::Close-->
			</div>
			<!--end::Modal header-->
			<!--begin::Modal body-->
			<div class="modal-body scroll-y mx-5 my-7">
				<!--begin::Form-->
				<form id="work_form" class="form" action="{{url('guard/update_guard_work_limitation')}}" method="POST" enctype="multipart/form-data"> @csrf												

					<input type="hidden" class="form-control form-control-md" id="guard_id" name="guard_id"  value="{{ $guard_id }}"> 


					<table class="table table-striped gy-7 gs-7">
						<thead>
							<tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
								<th>Status</th>
								<th>Weekly Work Limitation Hours</th>
								<th>Letter from Educational Institute</th>
								<th></th>
								<th>Authorized By</th>


							</tr>
						</thead>
						<tbody>

							<tr>

								<td>
									<div class="form-check form-check-solid form-switch fv-row">
										<input class="form-check-input w-45px h-30px" type="checkbox" id="status_work" name="status"   >
									</div>
								</td>
								<td>
									<input type="text" class="form-control " name="limitation" id="limitation">
								</td>
								<td>
									<input type="hidden" name="fortnightly_working_holiday_letterUploaded" id="fortnightly_working_holiday_letterUploaded">
									<input accept="image/png, image/gif, image/jpeg"  type="file" onchange="upload_file('fortnightly_working_holiday_letter', 'fortnightly_working_holiday_letterUploaded')" class="form-control form-control-md" id="fortnightly_working_holiday_letter" name="fortnightly_working_holiday_letter" > 
									<span id="image-upload-message" class="success"></span>
								</td>
								<td>
									<a style="display: none" href="" target="__blank" class="btn-default" id="preview_fortnightly_working_holiday_letter">
										<img src="https://img.icons8.com/emoji/40/000000/envelope-.png"/>
									</a>

								</td>
								<td>
									<div id="authorized_by"></div>
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
<!--end::Modals-->
@endif
@endif
@stop