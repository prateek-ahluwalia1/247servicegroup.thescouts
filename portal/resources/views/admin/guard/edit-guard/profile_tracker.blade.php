@section('profile_tracker') @if(session()->get('userType')!='guard')
<div class="col-md-4">
	<!--begin::Card-->
	<div class="card card-flush h-md-100">
		<!--begin::Card header-->
		<div class="card-header">
			<!--begin::Card title-->
			<div class="card-title">
				<h2>Profile Tracker </h2> </div>
			<!--end::Card title-->
		</div>
		<!--end::Card header-->
		<!--begin::Card body-->
		<div class="card-body pt-1">
			<!-- <div class="fw-bolder text-gray-600 mb-5">Optional</div> -->
		</div>
		<!--end::Card body-->
		<!--begin::Card footer-->
		<div class="card-footer flex-wrap pt-0"> {{-- data-bs-target="#guard_avability-modal" --}}
			<button type="button" class="btn btn-white btn-active-light-primary my-1" data-bs-toggle="modal" id="profile_tracker_button">Open Profile Tracker</button>
		</div>
		<!--end::Card footer-->
	</div>
	<!--end::Card-->
</div>
<!-- modal  -->
<div class="modal fade" id="profile_tracker-modal" tabindex="-1" aria-hidden="true">
	<!--begin::Modal dialog-->
	<div class="modal-dialog modal-dialog-centered mw-750px">
		<!--begin::Modal content-->
		<div class="modal-content">
			<!--begin::Modal header-->
			<div class="modal-header">
				<!--begin::Modal title-->
				<h2 class="fw-bolder" id="form_head">
					{{config('custom.guard')}} Profile Tracker
				</h2>
				<!--end::Modal title-->
				<!--begin::Close-->
				<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close"> <span class="svg-icon svg-icon-2x">X</span> </div>
				<!--end::Close-->
			</div>
			<!--end::Modal header-->
			<!--begin::Modal body-->
			<div class="modal-body scroll-y mx-5 my-7">
				<!--begin::Table container-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                    <!--begin::Table head-->
                                    <thead>
                                    <tr class="fw-bolder text-muted">
                                        <th class="min-w-150px">Action</th>
                                        <th class="min-w-100px">Date & Time</th>
                                    </tr>
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody id="profile_tracker_data">

                                    </tbody>
                                </table>
                            </div>
			</div>
			<!--end::Modal body-->
		</div>
		<!--end::Modal content-->
	</div>
	<!--end::Modal dialog-->
</div>
<!--end::Modal - Update role-->
<!--end::Modals-->@endif @stop