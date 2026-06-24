@section('sites-trained')
    <?php
    $site_trained_progress = 0;
    if (isset($guard_data['guard_site_trained']) && !empty($guard_data['guard_site_trained']) && count($guard_data['guard_site_trained']) > 0) {
        $site_trained_progress += 100;
    }
    
    $item = session()->get('guards_navigation_bar');
    // @dd($item);
    if (!empty($item)) {
        foreach (session()->get('guards_navigation_bar') as $item1) {
            $item = $item1;
        }
    } else {
        $item['site_trained'] = 1;
        $item = json_decode(json_encode($item));
    }
    ?>
    @if (session()->get('userType') == 'admin')
	@if (isset($item->site_trained) && $item->site_trained ==1)
	<div class="col-md-4">
		<!--begin::Card-->
		<div class="card card-flush h-md-100">
			<!--begin::Card header-->
			<div class="card-header">
				<!--begin::Card title-->
				<div class="card-title">
					<h2>Sites trained</h2>
				</div>
				<!--end::Card title-->
			</div>
			<!--end::Card header-->
			<!--begin::Card body-->
			<div class="card-body pt-1">
				<!--begin::Users-->
				<div class="fw-bolder text-gray-600 mb-5">Optional</div>
				<!--end::Users-->
				<!--begin::Permissions-->
				<div class="d-flex flex-column text-gray-600">

					<div class="d-flex flex-column w-100 me-2" style="display: none !important;">
						<div class="d-flex flex-stack mb-2">
							<span class="text-muted me-2 fs-7 fw-bold">{{ $site_trained_progress }}%</span>
						</div>
						<div class="progress h-6px w-100">
							<div class="progress-bar bg-primary" role="progressbar"
								style="width: {{ $site_trained_progress }}%"
								aria-valuenow="{{ $site_trained_progress }}" aria-valuemin="0" aria-valuemax="100">
							</div>
						</div>
					</div>
				</div>
				<!--end::Permissions-->
			</div>
			<!--end::Card body-->
			<!--begin::Card footer-->
			<div class="card-footer flex-wrap pt-0">
				<button type="button" class="btn btn-white btn-active-light-primary my-1" data-bs-toggle="modal"
					data-bs-target="#sites_trained-modal1" id="sites_trained-modal-btn">Open Trained Sites</button>


			</div>
			<!--end::Card footer-->
		</div>
		<!--end::Card-->
	</div>
	@endif
        <!-- modal  -->
        <div class="modal fade" id="sites_trained-modal" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-750px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2 class="fw-bolder" id="form_head">Trained Sites</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">

                            <span class="svg-icon svg-icon-2x">X</span>
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body scroll-y mx-5 my-7">
                        <!--begin::Form-->



                        <form id="sites_trained-form" class="form" action="{{ url('guard/save_sites_trained_form') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="guard_id" value="{{ $guard_id }}">
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label for="name" class="col-form-label">Customer Name</label>

                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="name" class="col-form-label">Site Name</label>

                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="name" class="col-form-label">Status</label>
                                </div>
                            </div>
                            <div id="guard-site-trained-container">
                            </div>
                            <div class="row training-section">
                                <div class="col-md-4 form-group"></div>
                                <div class="col-md-4 form-group">
                                    <button type="button"
                                        class="btn btn-success btn-sm btn-train _ac-add-more-site-train-btn">Add More
                                        <svg width="1em" height="1em" viewBox="0 0 16 16"
                                            class="bi bi-file-earmark-plus-fill" fill="currentColor"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M2 2a2 2 0 0 1 2-2h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm7.5 1.5v-2l3 3h-2a1 1 0 0 1-1-1zM8.5 7a.5.5 0 0 0-1 0v1.5H6a.5.5 0 0 0 0 1h1.5V11a.5.5 0 0 0 1 0V9.5H10a.5.5 0 0 0 0-1H8.5V7z">
                                            </path>
                                        </svg></button>
                                </div>
                                <div class="col-md-4 form-group"></div>
                            </div>

                            </br>
                            </br>
                            </br>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                                    <span id="form_submit" class="indicator-label">Save</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
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
@stop

<script type="text/javascript">
    function getCustomerSites(index)
    {
        var customer_id = $('#site_trained_customer-option-'+index).val();
        console.log(customer_id);
    }
</script>