<!--begin::Header-->
								<div class="card-header" id="kt_explore_header">
									<h3 class="card-title fw-bolder text-gray-700" id="from-title">Multiple Shifts</h3>
									<div class="card-toolbar">
										<button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n5" id="kt_explore_close_add_multiple_shifts">
											<!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
											<span class="svg-icon svg-icon-2">
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
													<g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
														<rect fill="#000000" x="0" y="7" width="16" height="2" rx="1" />
														<rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1" />
													</g>
												</svg>
											</span>
											<!--end::Svg Icon-->
										</button>
									</div>
								</div>
								<!--end::Header-->
								<!--begin::Body-->

<!-- <form class="form" action="#" id="saveEventForm" > -->

								<div class="card-body" id="kt_explore_body" style="max-height: 500px; overflow-x: auto;">
									
									<!--begin::Content-->
									<div id="kt_explore_scroll" class="scroll-y me-n5 pe-5" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_explore_body" data-kt-scroll-dependencies="#kt_explore_header, #kt_explore_footer" data-kt-scroll-offset="5px">
										<!--begin::Demos-->
										<div class="mb-0">
										  <div id="multipleShiftDiv">
														<!--begin::Input group-->
											<input type="hidden" id="eventeventId" value="0" >
                      <input type="hidden" id="eventstartStatus" value="2" >
											<input type="hidden" id="shift_counter" value="5" >
                      @for($i = 1; $i < 5; $i++)
                      <!-- start of one shift form -->
                      <div class="row" id="shift-multiple-{{$i}}">
                        <div class="col-sm-12 col-md-1" onclick="removeMultipleShift({{$i}})">
                          <div class="fv-row mt-9">
                            <button class="btn btn-default" type="button"><i class="fas fa-trash"></i></button>
                        </div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                          <div class="fv-row mb-9">
                          <!--begin::Label-->
                          <label class="fs-6 fw-bold required mb-2">Select Site</label>
                          <!--end::Label-->
                          <select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" id="eventSiteId_{{$i}}" name="eventSiteId_{{$i}}" onchange="loadGuards({{$i}})">
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
                        <select class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" id="eventguardId_{{$i}}" name="eventguardId_{{$i}}" >
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
                        <input type="text" class="form-control form-control-solid date-time" placeholder="" name="event_starts_{{$i}}" id="event_starts_{{$i}}" />
                        <!--end::Input-->
                      </div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <div class="fv-row mb-9">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold mb-2">End</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid date-time" placeholder="" name="event_ends_{{$i}}" id="event_ends_{{$i}}" />
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
                        <input type="number" min="1" value="1" class="form-control form-control-solid" placeholder="" name="no_of_users_{{$i}}" id="no_of_users_{{$i}}" />
                        <!--end::Input-->
                      </div>
                      <!--end::Input group-->
                        </div>
                      </div>
                      @endfor
                      <!-- end of one shift form -->
                    </div>
                      <div class="row">
                        <div class="col-sm-12 text-center">
                          <button type="button" class="btn btn-default" onclick="addNewShift()"><i class="fas fa-plus" ></i> Add shift</button>
                        </div>
                      </div>
</div>
										<!--end::Demos-->
									</div>
									<!--end::Content-->
								</div>
								<!--end::Body-->
								<!--begin::Footer-->
								<div class="card-footer py-5 text-center" id="kt_explore_footer">
                  <button type="submit" class="btn btn-action" id="saveMultipleFormBtndraft">Save as draft</button>
									<button type="submit" class="btn btn-primary" id="saveMultipleFormBtn">Save & publish shift</button>
								</div>
								<!--end::Footer-->
										<!-- </form> -->


											<script type="text/javascript">
$('.date-time').flatpickr({enableTime:!0,dateFormat:"d, M Y, H:i"});
												$('#eventSiteId').on('change', function(){
    
    
});
  function loadGuards(index)
  {
    var jobId = $('#eventSiteId_'+index).val();
    loadSiteGaurds(jobId, index);
  }
function loadSiteGaurds(jobId, index){
   $.ajax({
        url: base_url+"/guard/getGuards",
        type: "post",
        dataType: "json",
        data: {
            jobId : jobId,
            _token : token
        },
        success: function(result) {
            var options = '<option value="">Select {{config("custom.guard")}}</option>';
            $.each(result, function(mindex, mvalue){
                options += '<option value="'+mvalue.id+'">'+mvalue.name+'</option>';
            })
            $('#eventguardId_'+index).html(options);
     }
 });
}
$('#saveMultipleFormBtndraft').on('click', function(){
  submitForm(false);
});
$('#saveMultipleFormBtn').on('click', function(){
  submitForm(true);
});
function task_cal()
{
  var tasks = [];
  var task_counter = $('#task_counter').val();

  for (var i = 0; i <= task_counter; i++) {
      var task_start_time = $('#task-start-time-'+i).val();
      var task_description = $('#task-description-'+i).val();
      if (task_start_time != '' && task_description != '' && task_start_time != undefined) {
      tasks.push({
        task_start_time : task_start_time,
        task_description : task_description
      })
    }
  }
  return tasks;
}

function submitForm(publish = false)
{
	  var shift_counter = $('#shift_counter').val();
    var shifts = [];
    for (var i = 1; i < shift_counter; i++) {
      var eventSiteId = $('#eventSiteId_'+i).val();
      var eventguardId = $('#eventguardId_'+i).val();
      var event_starts = $('#event_starts_'+i).val();
      var event_ends = $('#event_ends_'+i).val();
      var no_of_users = $('#no_of_users_'+i).val();

      if (eventSiteId != '' && eventSiteId != undefined && event_starts != '' && event_ends != '') {
      shifts.push({
        site_id : eventSiteId,
        guard_id : eventguardId,
        start : moment(event_starts).format('YYYY-MM-DD HH:mm'),
        end : moment(event_ends).format('YYYY-MM-DD HH:mm'),
        no_of_users : no_of_users, 
        publish : publish

      })
    }
  }
   $.ajax({
        url: base_url+"/guard/addMultipleShifts",
        type: "post",
        dataType: "json",
        data: {
          shifts : shifts,
          _token : token
        },
        success: function(result) {
          if (result.success) {
            $('#kt_explore_add_multiple_shifts').removeClass('drawer-on');
            renderCalendar($('#customer-selection').val());

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
     }
 });
}

function initialize_time_input(id)
{
	$(id).flatpickr({
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
});

    
}			


function addNewShift()
{
  var index = $('#shift_counter').val() * 1;
  $('#shift_counter').val(index + 1);
  $.ajax({
        url: base_url+"/guard/addNewShift",
        type: "post",
        dataType: "json",
        data: {
            index : index,
            customerId : $('#customer-selection').val(),
            _token : token
        },
        success: function(result) {
           $('#multipleShiftDiv').append(result);

     }

 });
}		
function removeMultipleShift(index)
{
  $('#shift-multiple-'+index).remove();
}				

</script>