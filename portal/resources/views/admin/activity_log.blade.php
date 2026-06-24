
@foreach($activity as $act)
<!--begin::Timeline item-->
<div class="timeline-item">
	<!--begin::Timeline line-->
	<div class="timeline-line w-40px"></div>
	<!--end::Timeline line-->
	<!--begin::Timeline icon-->
	<div class="timeline-icon symbol symbol-circle symbol-40px me-4">
		<div class="symbol-label bg-light">
			<!--begin::Svg Icon | path: icons/duotone/Communication/Chat2.svg-->
			<span class="svg-icon svg-icon-2 svg-icon-gray-500">
				<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
					<polygon fill="#000000" opacity="0.3" points="5 15 3 21.5 9.5 19.5" />
					<path d="M13.5,21 C8.25329488,21 4,16.7467051 4,11.5 C4,6.25329488 8.25329488,2 13.5,2 C18.7467051,2 23,6.25329488 23,11.5 C23,16.7467051 18.7467051,21 13.5,21 Z M9,8 C8.44771525,8 8,8.44771525 8,9 C8,9.55228475 8.44771525,10 9,10 L18,10 C18.5522847,10 19,9.55228475 19,9 C19,8.44771525 18.5522847,8 18,8 L9,8 Z M9,12 C8.44771525,12 8,12.4477153 8,13 C8,13.5522847 8.44771525,14 9,14 L14,14 C14.5522847,14 15,13.5522847 15,13 C15,12.4477153 14.5522847,12 14,12 L9,12 Z" fill="#000000" />
				</svg>
			</span>
			<!--end::Svg Icon-->
		</div>
	</div>
	<!--end::Timeline icon-->
	<!--begin::Timeline content-->
	<div class="timeline-content mb-10 mt-n1">
		<!--begin::Timeline heading-->
		<div class="pe-3 mb-5">
			<!--begin::Title-->
			<div class="fs-5 fw-bold mb-2">{{strtoupper(str_replace('_', ' ', $act->action))}}</div>
			<!--end::Title-->
			<!--begin::Description-->
			<div class="d-flex align-items-center mt-1 fs-6">
				<!--begin::Info-->
				<div class="text-muted me-2 fs-7">at {{$act->created_at}} by </div>
				<!--end::Info-->
				<!--begin::User-->
				<div class="symbol symbol-circle symbol-25px" data-bs-toggle="tooltip" data-bs-boundary="window" data-bs-placement="top" title="Nina Nilson">
					{{$act->user}}
				</div>
				<!--end::User-->
			</div>
			<!--end::Description-->
		</div>
		<!--end::Timeline heading-->
		<?php
		$data = json_decode($act->data, true);
		?>
		@if($act->action == 'site_update' || $act->action == 'site_add')
		<!--begin::Timeline details-->
		<div class="overflow-auto pb-5"> 
			<!--begin::Record-->
			<div class="d-flex align-items-center border border-dashed border-gray-300 rounded min-w-300px px-7 py-3 mb-5">
				<!--begin::Title-->
				<a class="fs-5 text-dark text-hover-primary fw-bold w-200px min-w-200px">{{$data['site_name']}}</a>
				<!--end::Title-->
				<!--begin::Label-->
				<div class="min-w-175px pe-2">
					<span class="badge badge-light text-muted">{{$data['site_description']}}</span>
				</div>
				<!--end::Label-->
			</div>
			<!--end::Record-->
		</div>
		<!--end::Timeline details-->
		@endif

		@if($act->action == 'shift_bulk_copy' || $act->action == 'shift_roll_over')
		<!--begin::Timeline details-->
		<div class="overflow-auto pb-5"> 
			<!--begin::Record-->
			<div class="d-flex align-items-center border border-dashed border-gray-300 rounded min-w-300px px-7 py-3 mb-5">
				<!--begin::Title-->
				<a class="fs-5 text-dark text-hover-primary fw-bold w-400px min-w-200px">{{$data['message']}}</a>
				<!--end::Title-->
				<!--begin::Label-->
				
				<!--end::Label-->
			</div>
			<!--end::Record-->
		</div>
		<!--end::Timeline details-->
		@endif
		@if($act->action == 'guard_creation' || $act->action == 'guard_update' || $act->action == 'guard_delete')
		<!--begin::Timeline details-->
		<div class="overflow-auto pb-5">
			<!--begin::Record-->
			<div class="d-flex align-items-center border border-dashed border-gray-300 rounded min-w-750px px-7 py-3 mb-5">
				<!--begin::Title-->
				<a class="fs-5 text-dark text-hover-primary fw-bold w-200px min-w-200px">{{$data[0]['name']}}</a>
				<!--end::Title-->
				<!--begin::Label-->
				<div class="min-w-175px pe-2">
					<span class="badge badge-light text-muted">{{$data[0]['email']}}</span>
				</div>
				<!--end::Label-->
				<!--begin::Users-->
				<div class="symbol-group symbol-hover flex-nowrap flex-grow-1 min-w-100px pe-2">

					<!--begin::User-->
					<div class="symbol symbol-circle symbol-25px">
						@if($data[0]['profile_image'] != '')
						<img src="{{config('custom.asset_url')}}{{$data[0]['profile_image']}}" alt="img" />
						@else
						<img src="https://place-hold.it/50x50" alt="img" />
						@endif
					</div>
					<!--end::User-->
					<!--begin::User-->
					<div class="symbol symbol-circle symbol-25px">
						<div class="symbol-label fs-8 fw-bold bg-primary text-inverse-primary">{{$data[0]['name'][0]}}</div>
					</div>
					<!--end::User-->
				</div>
				<!--end::Users-->
			</div>
			<!--end::Record-->
		</div>
		<!--end::Timeline details-->
		@endif

		@if($act->action == 'shift_change' || $act->action == 'shift_add' || $act->action == 'shift_delete' || $act->action == 'shift_drag_copy')
		<!--begin::Timeline details-->
		<div class="overflow-auto pb-5">
			<label>Old Data</label>
			<!--begin::Record-->
			<div class="d-flex align-items-center border border-dashed border-gray-300 rounded min-w-750px px-7 py-3 mb-5">
				<!--begin::Title-->
				<a class="fs-5 text-dark text-hover-primary fw-bold w-200px min-w-200px">{{isset($data['temp_start']) ? date('d/m/Y H:i', strtotime($data['temp_start'])) : date('d/m/Y H:i', strtotime($data[0]['temp_start']))}}
				</a>
				<!--end::Title-->
				<!--begin::Title-->
				<a class="fs-5 text-dark text-hover-primary fw-bold w-200px min-w-200px">{{isset($data['temp_end']) ? date('d/m/Y H:i', strtotime($data['temp_end'])) : date('d/m/Y H:i', strtotime($data[0]['temp_end']))}}
				</a>
				<!--end::Title-->


				<!--begin::Progress-->
				<div class="min-w-125px pe-2">
					<span class="badge badge-light-primary">Site: {{$act->site}}</span>
				</div>
				<!--end::Progress-->

				<!--begin::Progress-->
				<div class="min-w-125px pe-2">
					<span class="badge badge-light-primary">Guard: {{$act->guard_name}}</span>
				</div>
				<!--end::Progress-->

			</div>
			<!--end::Record-->
		</div>
		<!--end::Timeline details-->
		@if(isset($act->current_data) && !empty($act->current_data))
<!--begin::Timeline details-->
		<div class="overflow-auto pb-5">
			<label>Current Data</label>
			<!--begin::Record-->
			<div class="d-flex align-items-center border border-dashed border-gray-300 rounded min-w-750px px-7 py-3 mb-5">
				<!--begin::Title-->
				<a class="fs-5 text-dark text-hover-primary fw-bold w-200px min-w-200px">{{isset($act->current_data->temp_start) ? date('d/m/Y H:i', strtotime($act->current_data->temp_start)) : date('d/m/Y H:i', strtotime($act->current_data[0]->temp_start))}}
				</a>
				<!--end::Title-->
				<!--begin::Title-->
				<a class="fs-5 text-dark text-hover-primary fw-bold w-200px min-w-200px">{{isset($act->current_data->temp_end) ? date('d/m/Y H:i', strtotime($act->current_data->temp_end)) : date('d/m/Y H:i', strtotime($act->current_data[0]->temp_end))}}
				</a>
				<!--end::Title-->


				<!--begin::Progress-->
				<div class="min-w-125px pe-2">
					<span class="badge badge-light-primary">Site: - </span>
				</div>
				<!--end::Progress-->

				<!--begin::Progress-->
				<div class="min-w-125px pe-2">
					<span class="badge badge-light-primary">Guard: - </span>
				</div>
				<!--end::Progress-->

			</div>
			<!--end::Record-->
		</div>
		<!--end::Timeline details-->
		@endif
		@endif
	</div>
	<!--end::Timeline content-->
</div>
<!--end::Timeline item-->
@endforeach
