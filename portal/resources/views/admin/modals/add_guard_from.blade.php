		<div class="row">
			<div class="col-sm-12 col-md-6">
				<div class="fv-row mb-9">
					@csrf
					<!--begin::Label-->
					<label class="fs-6 fw-bold required mb-2">Customer</label>
					<!--end::Label-->
					<select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" id="guard_customer" name="guard_customer" required="">
						<option value="">Select Customer</option>

						@foreach($customers as $customer)
						<option value="{{$customer->id}}">{{$customer->name}}</option>
						@endforeach
					</select>
				</div>
				<!--end::Input group-->
			</div>
			<div class="col-sm-12 col-md-6">
				<div class="fv-row mb-9">
					<!--begin::Label-->
					<label class="fs-6 fw-bold required mb-2">Site in ad-hoc shift</label>
					<!--end::Label-->
					<select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" id="guard_site" name="guard_site" required="">
						
					</select>
				</div>
				<!--end::Input group-->
			</div>
		</div>	
		

		<div class="fv-row mb-9">
			<!--begin::Label-->
			<label class="fs-6 fw-bold required mb-2">State</label>
			<!--end::Label-->
			<select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" id="le-guard_state" name="le-guard_state" disabled="">
				<option>Select</option>
				<option value="New South Wales">New South Wales</option>
				<option value="Queensland">Queensland</option>
				<option value="South Australia">South Australia</option>
				<option value="Tasmania">Tasmania</option>
				<option value="Victoria">Victoria</option>
				<option value="Western Australia">Western Australia</option>
				<option value="Australian Capital Territory">Australian Capital Territory</option>
				<option value="Northern Territory">Northern Territory</option>
			</select>
		</div>
		<div class="row">
			<div class="col-sm-12 col-md-6">
				<div class="fv-row mb-9">
				<label class="fs-6 fw-bold mb-2">Site Trained</label>
				<div class="row">
					<div class="col-sm-12 col-md-6" id="le-guard_site_trained" style="text-transform: capitalize;">
					</div>
				</div>
			</div>
			</div>
		</div>

		<!--begin::Input group-->
		<div class="row">
			<div class="col-sm-12 col-md-6">
				<div class="fv-row mb-9">
					<!--begin::Label-->
					<label class="fs-6 fw-bold mb-2">Job Start Date & Time</label>
					<!--end::Label-->
					<!--begin::Input-->
					<input type="text" class="form-control form-control-solid date-time" placeholder="" name="le-start_date" id="le-start_date" required="" />
					<!--end::Input-->
				</div>
			</div>
			<div class="col-sm-12 col-md-6">
				<!--begin::Input group-->
				<div class="fv-row mb-9">
					<!--begin::Label-->
					<label class="fs-6 fw-bold mb-2">Job End Date & Time</label>
					<!--end::Label-->
					<!--begin::Input-->
					<input type="text" class="form-control form-control-solid date-time" placeholder="" name="le-end_date" id="le-end_date" required="" />
					<!--end::Input-->
				</div>
			</div>
		</div>

		<div class="fv-row mb-9">
			<!--begin::Label-->
			<label class="fs-6 fw-bold mb-2">Job Instrcutions</label>
			<!--end::Label-->
			<!--begin::Input-->
			<textarea class="form-control form-control-solid" name="instrcutions" id="instrcutions"></textarea>
			<!--end::Input-->
		</div>
		<div class="row">
			<div class="col-sm-12 col-md-6">
				<div class="fv-row mb-9">
			<!--begin::Label-->
			<label class="fs-6 fw-bold mb-2">SOS Phone</label>
			<!--end::Label-->
			<!--begin::Input-->
			<input type="text" class="form-control form-control-solid" placeholder="" name="sos_phone" id="sos_phone" readonly="" />
			<!--end::Input-->
		</div>
			</div>
			<div class="col-sm-12 col-md-6">
			<div class="fv-row mb-9">
						<!--begin::Label-->
						<label class="fs-6 fw-bold mb-2">No. of {{config('custom.guard')}}</label>
						<!--end::Label-->
						<!--begin::Input-->
						<input type="text" class="form-control form-control-solid" placeholder="" name="no_of_guard" id="no_of_guard" readonly="" />
						<!--end::Input-->
					</div>
			</div>
		</div>
		
		<div class="fv-row mb-9">
			<!--begin::Label-->
			<label class="fs-6 fw-bold mb-2">Address</label>
			<!--end::Label-->
			<!--begin::Input-->
			<input type="text" class="form-control form-control-solid" placeholder="" name="address" id="address" required="" readonly="" />
			<!--end::Input-->
		</div>
		<div class="fv-row mb-9">
			<!--begin::Label-->
			<label class="fs-6 fw-bold mb-2">Coordinates</label>
			<!--end::Label-->
			<!--begin::Input-->
			<input type="text" class="form-control form-control-solid" placeholder="" name="le-guard_coordinates" id="le-guard_coordinates" readonly="" />
			<!--end::Input-->
		</div>
		<script type="text/javascript">
			$('.date-time').flatpickr({
				enableTime:!0,
				dateFormat:"d, M Y H:i",
        time_24hr: true,

			});
			$('#guard_customer').on('change', function(){
        console.log($(this).val())
        getCustomerSiteData($(this).val(), true);
     });
			$('#guard_site').on('change', function(){
    $.ajax({
            type: "POST",
            url: base_url + "/job/get_site_data",
            data: { _token : token, siteId : $(this).val()},
            success: function(result) {
            	if (result.site_data != null) {
            		$('#le-guard_state').val(result.site_data.state);
            		$('#sos_phone').val(result.site_data.sos_phone);
            		$('#no_of_guard').val(result.site_data.guards_count);
            		$('#address').val(result.site_data.address);
            		$('#le-guard_coordinates').val(result.site_data.coordinates);
            		$('#le-guard_site_trained').text(result.site_data.trained);
            	}

            }
        });
  })


</script>