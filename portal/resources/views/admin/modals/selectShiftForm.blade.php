<!--begin::Header-->
								<div class="card-header" id="kt_explore_header">
									<h3 class="card-title fw-bolder text-gray-700" id="from-title">Select Shifts</h3>
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
                      <!-- start of one shift form -->
                      <div class="row" >
                        <div class="col-sm-12 col-md-2">
                          <div class="form-check form-check-custom form-check-solid me-10">
                            <input class="form-check-input h-30px w-30px" type="checkbox" value="true" onclick="selectAllRoster();" id="selectAllRoster">
                            <label class="fs-6 fw-bold mb-2 m-1"> <strong>Select All</strong></label>
                        </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                          <div class="fv-row mb-9">
                          <!--begin::Label-->
                          <label class="fs-6 fw-bold mb-2"><strong>{{config('custom.guard')}}</strong></label>
                          <!--end::Label-->
                          
                        </div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <div class="fv-row mb-9">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold mb-2"><strong>Day</strong></label>
                        
                      </div>
                      <!--end::Input group-->
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <div class="fv-row mb-9">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold mb-2"><strong>Start</strong></label>
                        
                      </div>
                      <!--end::Input group-->
                        </div>
                        <div class="col-sm-12 col-md-3">
                          <!--begin::Input group-->
                      <div class="fv-row mb-9">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold mb-2"><strong>End</strong></label>
                        <!--end::Label-->
                        
                        <!--end::Input-->
                      </div>
                        </div>
                        <hr>

                      </div>
														<!--begin::Input group-->
                      @foreach($roster as $r)
                      <!-- start of one shift form -->
                      <div class="row" >
                        <div class="col-sm-12 col-md-2">
                          <div class="form-check form-check-custom form-check-solid me-10">
                            <input class="form-check-input h-30px w-30px checkbox-select" type="checkbox" value="{{$r->roster_id}}" id="roster_id_{{$r->roster_id}}" name="roster_id_{{$r->roster_id}}" onclick="selectRoster({{$r->roster_id}})">
                        </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                          <div class="fv-row mb-9">
                          <!--begin::Label-->
                          <label class="fs-6 fw-bold mb-2">{{($r->name) ? $r->name : "N/A"}}</label>
                          <!--end::Label-->
                          
                        </div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <div class="fv-row mb-9">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold mb-2">{{date('l', strtotime($r->temp_start))}}</label>
                        
                      </div>
                      <!--end::Input group-->
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <div class="fv-row mb-9">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold mb-2">{{date('d/m/Y H:i', strtotime($r->temp_start))}}</label>
                        
                      </div>
                      <!--end::Input group-->
                        </div>
                        <div class="col-sm-12 col-md-3">
                          <!--begin::Input group-->
                      <div class="fv-row mb-9">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold mb-2">{{date('d/m/Y H:i', strtotime($r->temp_end))}}</label>
                        <!--end::Label-->
                        
                        <!--end::Input-->
                      </div>
                        </div>

                      </div>
                      <hr>
                      @endforeach
                      <!-- end of one shift form -->
</div>
										<!--end::Demos-->
									</div>
									<!--end::Content-->
								</div>
								<!--end::Body-->
								<!--begin::Footer-->
								<div class="card-footer py-5 text-center" id="kt_explore_footer">
                  <!-- <button type="submit" class="btn btn-action saveMultipleFormBtndraft" id="saveMultipleFormBtndraft">Close</button> -->
                  <button type="submit" class="btn btn-action saveMultipleFormBtndraft" id="saveMultipleFormBtndraft">Select</button>
									<!-- <button type="submit" class="btn btn-primary" id="saveMultipleFormBtn">Save & publish shift</button> -->
								</div>
								<!--end::Footer-->
										<!-- </form> -->


											<script type="text/javascript">

$('.saveMultipleFormBtndraft').on('click', function(){
$('#kt_explore_select_shifts').removeClass('drawer-on');

});
function selectAllRoster(){
  var x = $('.checkbox-select');
  if ($('#selectAllRoster').is(":checked")) {
  $.each(x, function(index, val){
    // $(val).click()
    $('#roster_id_'+x[index].value).prop('checked', true);
    selectedRosterId.push(x[index].value);
    $('.custom-roster-'+x[index].value).css('border','5px solid #d99f22');

    // console.log(x[index].value)
  });
}else{
  $.each(x, function(index, val){
    $('#roster_id_'+x[index].value).prop('checked', false);

    // $(val).click()
    var index1 = selectedRosterId.indexOf(x[index].value);
    selectedRosterId.splice(index1, 1);
    $('.custom-roster-'+x[index].value).css('border','1px solid #84b3cd40');
    

    // console.log(x[index].value)
  });
  // $('.checkbox-select').click();
}
}
function selectCheckbox()
{
console.log(selectedRosterId);
$.each(selectedRosterId, function(index, val){
  $('#roster_id_'+val).prop('checked', true);
})
}
selectCheckbox();

</script>