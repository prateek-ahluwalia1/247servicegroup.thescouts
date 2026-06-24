                    
                      <!-- start of one shift form -->
                      <div class="row" id="shift-multiple-{{$index}}">
                       <div class="col-sm-12 col-md-1" onclick="removeMultipleShift({{$index}})">
                          <div class="fv-row mt-9">
                            <button class="btn btn-default" type="button"><i class="fas fa-trash"></i></button>
                        </div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                          <div class="fv-row mb-9">
                          <!--begin::Label-->
                          <label class="fs-6 fw-bold required mb-2">Select Site</label>
                          <!--end::Label-->
                          <select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" id="eventSiteId_{{$index}}" name="eventSiteId_{{$index}}" onchange="loadGuards({{$index}})">
                            <option value="">Select Site</option>
                          @foreach($sites as $site)
                          <option value="{{$site->jobId}}" >{{$site->site_name}} ({{$site->site_description}})</option>
                          @endforeach
                          </select>
                        </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="fv-row mb-9">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold required mb-2">{{config('custom.guard')}}</label>
                        <!--end::Label-->
                        <select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" id="eventguardId_{{$index}}" name="eventguardId_{{$index}}" >
                        </select>
                      </div>
                      <!--end::Input group-->
                        </div>
                        <div class="col-sm-12 col-md-2">
                          <!--begin::Input group-->
                      <div class="fv-row mb-9">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold mb-2">Start</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid date-time" placeholder="" name="event_starts_{{$index}}" id="event_starts_{{$index}}" />
                        <!--end::Input-->
                      </div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <div class="fv-row mb-9">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold mb-2">End</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid date-time" placeholder="" name="event_ends_{{$index}}" id="event_ends_{{$index}}" />
                        <!--end::Input-->
                      </div>
                      <!--end::Input group-->
                        </div>

                        <div class="col-sm-12 col-md-2">
                            <div class="fv-row mb-9">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold mb-2">Number of users</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="number" min="1" value="1" class="form-control form-control-solid" placeholder="" name="no_of_users_{{$index}}" id="no_of_users_{{$index}}" />
                        <!--end::Input-->
                      </div>
                      <!--end::Input group-->
                        </div>
                      </div>
                      

											<script type="text/javascript">
$('.date-time').flatpickr({enableTime:!0,dateFormat:"d, M Y, H:i"});
												
</script>