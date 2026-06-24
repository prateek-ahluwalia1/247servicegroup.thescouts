@section('guard_avability')

<div class="col-md-4">
	<!--begin::Card-->
	<div class="card card-flush h-md-100">
		<!--begin::Card header-->
		<div class="card-header">
			<!--begin::Card title-->
			<div class="card-title">
				<h2>{{config('custom.guard')}} Availability </h2>
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


			<button type="button" class="btn btn-white btn-active-light-primary my-1" data-bs-toggle="modal"  id="guard_avability_button">Check {{config('custom.guard')}} Availability</button>

		</div>
		<!--end::Card footer-->
	</div>
	<!--end::Card-->
</div>






<!-- modal  -->













<div class="modal fade" id="guard_avability-modal" tabindex="-1" aria-hidden="true">
	<!--begin::Modal dialog-->
	<div class="modal-dialog modal-dialog-centered mw-750px">
		<!--begin::Modal content-->
		<div class="modal-content">
			<!--begin::Modal header-->
			<div class="modal-header">
				<!--begin::Modal title-->
				<h2 class="fw-bolder" id="form_head">
				{{config('custom.guard')}} Availability </h2>

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
				<form id="update_guard_avability_weak_form" class="form" action="{{url('guard/update_guard_avability_weak')}}" method="POST" enctype="multipart/form-data"> @csrf												

					<input type="hidden" class="form-control form-control-md" id="guard_id" name="guard_id"  value="{{ $guard_id }}"> 


					<table class="table table-striped gy-7 gs-7">
						<thead>
							<tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
								<th>Day</th>
								<th>Status</th>
								<th>Shift</th>

							</tr>
						</thead>
						<tbody>
							<?php 
							$week=['monday','tuesday','wednesday','thursday','friday','sat','sun'];?>
							@foreach ($week as $day) 
							<tr>

								<td><h4>{{ucfirst($day)}}</h4></td>
								<td>
									<div class="form-check form-check-solid form-switch fv-row">
										<input class="form-check-input w-45px h-30px" type="checkbox" id="{{$day}}" name="{{$day}}"   checked="">
									</div>
								</td>
								<td>
									<select class="form-select form-select-lg form-select-solid"  data-placeholder="Select..." data-allow-clear="true" data-hide-search="true"  name="{{$day}}_shift" id="{{$day}}_shift" onchange="showHideother(this, '{{$day}}')">

										<option value="full" >Full Time</option>
										<option value="other">Other</option>
										<!-- <option value="day">Day Time</option> -->
										<!-- <option value="night">Night Time</option> -->
									</select>
									<div style="display: none;" id="{{$day}}_other_div">
										<div class="row">
											<div class="col-6"><input type="" name="{{$day}}_from" class="form-control kt_datetimepicker" id="{{$day}}_from"></div>
											<div class="col-6"><input type="" name="{{$day}}_to" class="form-control kt_datetimepicker" id="{{$day}}_to"></div>
										</div>
										
									</div>
								</td>
							</tr>

							@endforeach
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
<script type="text/javascript">
// 		$(document).ready(function() {
// 		$(".kt_datetimepicker").flatpickr({
//     enableTime: true,
//     noCalendar: true,
//     dateFormat: "H:i",
// });

// 	// $(".kt_daterangepicker").datetimepicker();
// });
</script>
@stop