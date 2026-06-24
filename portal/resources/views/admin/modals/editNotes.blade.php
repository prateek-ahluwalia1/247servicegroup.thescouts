<?php
$permissions = [];
$is_super_admin = 0;
if (session()->has('permissions')) {
    $permissions = json_decode(session()->get('permissions'), true);
}
if (session()->has('isAdmin')) {
    $is_super_admin = session()->get('isAdmin');
}
$item = session()->get('config_arr_job_roster');
// @dd($item);
if (!empty($item)) {
    foreach (session()->get('config_arr_job_roster') as $item1) {
        $item = $item1;
    }
} else {
    $item['select_state'] = 1;
    $item['select_customer'] = 1;
    $item['select_sites'] = 1;
    $item['action'] = 1;
    $item['sign_in_detail'] = 1;
    $item['add_site'] = 1;
    $item['ad_shift'] = 1;
    $item['sign_out_detail'] = 1;
    $item['break_detail'] = 1;
    $item['green_call'] = 1;
    $item['rollover_this_week'] = 1;
    $item['site_type'] = 1;
    $item['site_trained'] = 1;
    $item['breaks'] = 1;
    $item['welfare_calls'] = 1;
    $item['site_hours'] = 1;
    $item['charge_rates_level'] = 1;
    $item['charge_rates'] = 1;
    $item['shift_activity'] = 1;
    $item['shift_task'] = 1;
    $item['job_instrcutions'] = 1;
    $item['sos_phone'] = 1;
    $item['tasks'] = 1;
    $item['tracker'] = 1;
    $item['incident_report'] = 1;
    $item['welfare_call'] = 1;
    $item['view_guards'] = 1;
    $item['shift_site_name'] = 1;
    $item['shift_available_guard'] = 1;
    $item['shift_paybale'] = 1;
    $item['paid_by'] = 1;
    $item['shift_start_time'] = 1;
    $item['shift_end_time'] = 1;
    $item['shift_guard_name'] = 1;
    $item['travel_time'] = 1;
    $item['create_shift_button'] = 1;
    $item['operation_notes'] = 1;

    $item = json_decode(json_encode($item));
}
// print_r($permissions);
// exit();
?>
<!--begin::Header-->
<div class="card-header" id="kt_explore_header">
    <h3 class="card-title fw-bolder text-gray-700" id="from-title">Shift Details</h3>
    <div class="card-toolbar">
        <button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n5" id="kt_explore_close_form"
            onclick="$('#kt_explore_form').css('left', '');">
            <!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
            <span class="svg-icon svg-icon-2">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                    height="24px" viewBox="0 0 24 24" version="1.1">
                    <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)"
                        fill="#000000">
                        <rect fill="#000000" x="0" y="7" width="16" height="2"
                            rx="1" />
                        <rect fill="#000000" opacity="0.5"
                            transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)"
                            x="0" y="7" width="16" height="2" rx="1" />
                    </g>
                </svg>
            </span>
            <!--end::Svg Icon-->
        </button>
    </div>

</div>
<!--end::Header-->
<!--begin::Body-->

<form class="form" action="#" id="saveShiftForm">

    <div class="card-body section " id="kt_explore_body">

        <!--begin::Content-->
        <div id="kt_explore_scroll" class="scroll-y me-n5 pe-5" data-kt-scroll="true" data-kt-scroll-height="auto"
            data-kt-scroll-wrappers="#kt_explore_body"
            data-kt-scroll-dependencies="#kt_explore_header, #kt_explore_footer" data-kt-scroll-offset="5px">
            <!--begin::Demos-->
            @if (session()->get('userType') == 'admin' || session()->get('userType') == 'customer')
                <div class="mb-0">
                    <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6">

                        @if (isset($item->operation_notes) && $item->operation_notes == 1)
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#operations_notes">Operations notes</a>
                            </li>
                        @endif

                    </ul>
                    <div class="tab-content" id="myTabContent">



                        <div class="tab-pane fade fade active show" id="operations_notes" role="tabpanel">
                            <input type="hidden" id="eventeventId" value="{{ $roster->event_id }}">
                            <div class="fv-row mb-9">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">Operations notes</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea class="form-control form-control-solid" placeholder="" rows="3" name="operators_notes_input"
                                    id="operators_notes_input">{{ $roster->operators_notes }}</textarea>
                                <!--end::Input-->
                            </div>
                        </div>


                    </div>
                    <!--begin::Demo-->
            @endif

            @if (session()->get('userType') == 'guard')
                <!--begin::Demos-->
                <div class="mb-0">
                    <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#shift_details">Shift details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#shift_tasks">Shift tasks</a>
                        </li>

                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade fade active show" id="shift_details" role="tabpanel">
                            <!--begin::Input group-->
                            <input type="hidden" id="eventeventId" value="{{ $roster->event_id }}">
                            <input type="hidden" id="eventstartStatus" value="2">
                            <div class="fv-row mb-9">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold required mb-2">Select Site</label>
                                <!--end::Label-->
                                <select class="form-select form-select-lg form-select-solid" data-control="select2"
                                    data-placeholder="Select..." data-allow-clear="true" data-hide-search="true"
                                    id="{{ $gaurds_disabeld != '' ? 'eventSiteId-' : 'eventSiteId' }}"
                                    name="eventSiteId" {{ $site_disabeld }} disabled>
                                    <option value="">Select Site</option>
                                    @foreach ($sites as $site)
                                        <option value="{{ $site->jobId }}"
                                            {{ $site_id == $site->jobId ? 'selected' : '' }}>{{ $site->site_name }}
                                            ({{ $site->site_description }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="fv-row mb-9">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold required mb-2">{{config('custom.guard')}}</label>
                                <!--end::Label-->
                                <select class="form-select form-select-lg form-select-solid" data-control="select2"
                                    data-placeholder="Select..." data-allow-clear="true" data-hide-search="true"
                                    id="eventguardId" name="eventguardId" {{ $gaurds_disabeld }} disabled>
                                    <option value="">Select {{ config('custom.guard') }}</option>

                                    @foreach ($guards as $guard)
                                        <option value="{{ $guard->id }}"
                                            {{ $guard_id == $guard->id ? 'selected' : '' }}>{{ $guard->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-9">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">Start</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid date-time"
                                    placeholder="" name="event_starts" id="event_starts"
                                    value="{{ date('Y-m-d, H:i', $roster->job_start) }}}" disabled />
                                <!--end::Input-->
                            </div>

                            <div class="fv-row mb-9">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">End</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid date-time"
                                    placeholder="" name="calendar_event_description" id="event_ends"
                                    value="{{ date('Y-m-d, H:i', $roster->job_end) }}" disabled />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <div class="tab-pane fade" id="shift_tasks" role="tabpanel">
                            <input type="hidden" name="task_counter" id="task_counter"
                                value="{{ count($tasks) }}">
                            <div class="row" id="tasks-inputs">
                                <?php $index = 0; ?>
                                @foreach ($tasks as $task)
                                    <div class="col-md-4 form-group task-counter-{{ $index }}"><label
                                            for="recipient-name" class="col-form-label">Task Time</label><input
                                            type="text" class="form-control form-control-md task-time"
                                            name="task-start-time-{{ $index }}"
                                            id="task-start-time-{{ $index }}"
                                            value="{{ $task->task_time }}"disabled><input type="hidden"
                                            class="form-control form-control-md" name="task-id-{{ $index }}"
                                            id="task-id-{{ $index }}" value="{{ $task->id }}"disabled>
                                    </div>
                                    <div class="col-md-8 task-counter-{{ $index }} form-group"><label
                                            for="recipient-name" class="col-form-label">Description</label>
                                        <div class="row">
                                            <div class="col-md-10 ">
                                                <textarea class="form-control form-control-md" name="task-description-0" id="task-description-{{ $index }}"
                                                    rows="1" disabled>{{ $task->task_name }}</textarea>
                                            </div>
                                            <div class="col-md-2"></div>
                                        </div>
                                    </div>
                                    <?php $index++; ?>
                                @endforeach

                            </div>
                            {{-- <div class="row mt-4">
															<div class="col-sm-12 col-md-12 text-center">
																<button type="button" class="btn btn-success" style="border-radius: 25px;" onclick="addTasks()">+ Add new task</button>
															</div>
														</div> --}}
                        </div>
                        <div class="tab-pane " id="shift_activity" role="tabpanel">
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <div class="card-body">
                                        <!--begin::Tab Content-->
                                        <div class="tab-content">

                                            <!--begin::Tab panel-->
                                            <div id="kt_activity_week" class="card-body p-0 tab-pane fade show active"
                                                role="tabpanel" aria-labelledby="kt_activity_week_tab">
                                                <!--begin::Timeline-->
                                                <div class="timeline">
                                                    @foreach ($activity as $act)
                                                        <div class="timeline-item">
                                                            <!--begin::Timeline line-->
                                                            <div class="timeline-line w-40px"></div>
                                                            <!--end::Timeline line-->
                                                            <!--begin::Timeline icon-->
                                                            <div
                                                                class="timeline-icon symbol symbol-circle symbol-40px">
                                                                <div class="symbol-label bg-light">
                                                                    <!--begin::Svg Icon | path: icons/duotone/Communication/Thumbtack.svg-->
                                                                    <span
                                                                        class="svg-icon svg-icon-2 svg-icon-gray-500">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            width="24px" height="24px"
                                                                            viewBox="0 0 24 24" version="1.1">
                                                                            <path
                                                                                d="M11.6734943,8.3307728 L14.9993074,6.09979492 L14.1213255,5.22181303 C13.7308012,4.83128874 13.7308012,4.19812376 14.1213255,3.80759947 L15.535539,2.39338591 C15.9260633,2.00286161 16.5592283,2.00286161 16.9497526,2.39338591 L22.6066068,8.05024016 C22.9971311,8.44076445 22.9971311,9.07392943 22.6066068,9.46445372 L21.1923933,10.8786673 C20.801869,11.2691916 20.168704,11.2691916 19.7781797,10.8786673 L18.9002333,10.0007208 L16.6692373,13.3265608 C16.9264145,14.2523264 16.9984943,15.2320236 16.8664372,16.2092466 L16.4344698,19.4058049 C16.360509,19.9531149 15.8568695,20.3368403 15.3095595,20.2628795 C15.0925691,20.2335564 14.8912006,20.1338238 14.7363706,19.9789938 L5.02099894,10.2636221 C4.63047465,9.87309784 4.63047465,9.23993286 5.02099894,8.84940857 C5.17582897,8.69457854 5.37719743,8.59484594 5.59418783,8.56552292 L8.79074617,8.13355557 C9.76799113,8.00149544 10.7477104,8.0735815 11.6734943,8.3307728 Z"
                                                                                fill="#000000"></path>
                                                                            <polygon fill="#000000" opacity="0.3"
                                                                                transform="translate(7.050253, 17.949747) rotate(-315.000000) translate(-7.050253, -17.949747)"
                                                                                points="5.55025253 13.9497475 5.55025253 19.6640332 7.05025253 21.9497475 8.55025253 19.6640332 8.55025253 13.9497475">
                                                                            </polygon>
                                                                        </svg>
                                                                    </span>
                                                                    <!--end::Svg Icon-->
                                                                </div>
                                                            </div>
                                                            <!--end::Timeline icon-->
                                                            <!--begin::Timeline content-->
                                                            <div class="timeline-content mb-10 mt-n2">
                                                                <!--begin::Timeline heading-->
                                                                <div class="overflow-auto pe-3">
                                                                    <!--begin::Title-->
                                                                    <div class="fs-5 fw-bold mb-2"
                                                                        style="text-align: left;">{{ $act->activity }}
                                                                    </div>
                                                                    <!--end::Title-->
                                                                    <!--begin::Description-->
                                                                    <div class="d-flex align-items-center mt-1 fs-6">
                                                                        <!--begin::Info-->
                                                                        <div class="text-muted me-2 fs-7">at
                                                                            {{ date('Y-m-d H:i', $act->activity_time) }}
                                                                        </div>
                                                                        <!--end::Info-->
                                                                        <!--begin::User-->
                                                                        <!-- <div class="symbol symbol-circle symbol-25px" data-bs-toggle="tooltip" data-bs-boundary="window" data-bs-placement="top" title="" data-bs-original-title="Alan Nilson">
                                  <img src="assets/media/avatars/150-2.jpg" alt="img">
                                </div> -->
                                                                        <!--end::User-->
                                                                    </div>
                                                                    <!--end::Description-->
                                                                </div>
                                                                <!--end::Timeline heading-->
                                                            </div>
                                                            <!--end::Timeline content-->
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <!--end::Timeline-->
                                            </div>
                                            <!--end::Tab panel-->

                                        </div>
                                        <!--end::Tab Content-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--begin::Demo-->


            @endif


            <!--end::Demo-->
        </div>
        <!--end::Demos-->
    </div>
    <!--end::Content-->
    </div>
    <!--end::Body-->
    <!--begin::Footer-->

    <div class="text-center" id="kt_explore_footer" style="margin-top: 10%;">
        <button type="submit" class="btn btn-primary" id="updateEventFormBtn">Update</button>




        <!--end::Footer-->
</form>

<script type="text/javascript">
    $('.date-time').flatpickr({
        enableTime: !0,
        dateFormat: "Y-m-d H:i"
    });
    $('.time-picker').flatpickr({
        noCalendar: true,
        enableTime: true,
        dateFormat: 'H:i',
        time_24hr: true,
    });

    $('#eventSiteId').on('change', function() {
        var jobId = $(this).val();
        loadSiteGaurds(jobId);
    });
    $('#overtime').on('change', function() {
        if ($(this).prop('checked') == true) {
            $('.overtime-value-div').css('display', '');
        } else {
            $('.overtime-value-div').css('display', 'none');
        }
    });

    function loadSiteGaurds(jobId, guardId = null) {
        $.ajax({
            url: base_url + "/guard/getGuards",
            type: "post",
            dataType: "json",
            data: {
                jobId: jobId,
                _token: token
            },
            success: function(result) {
                var options = '<option value="">Select {{config("custom.guard")}}</option>';
                $.each(result, function(mindex, mvalue) {
                    var selected = '';
                    if (guardId != null) {
                        if (mvalue.id == guardId) {
                            selected = 'selected';
                        }
                    }
                    options += '<option value="' + mvalue.id + '" ' + selected + '>' + mvalue.name +
                        '</option>';
                })
                $('#eventguardId').html(options);
                //    if (is_customer == true) {
                //     $('#eventguardId').attr('disabled', '');

                // }
            }

        });
    }
    var form_data = new FormData();
    $("#saveShiftForm").submit(function(e) {
        e.preventDefault();
        form_data = new FormData(this);
        // form_data.append('name', "Mohsin")
    });
    $('#updateEventFormBtn').on('click', function() {
        // $('#saveEventForm').submit();
        submitForm();
    })
    $('#updateEventFormBtn1').on('click', function() {
        // $('#saveEventForm').submit();
        console.log('i am')
        submitForm(false);
    })

    function task_cal() {
        var tasks = [];
        var task_counter = $('#task_counter').val();

        for (var i = 0; i <= task_counter; i++) {
            var task_start_time = $('#task-start-time-' + i).val();
            var task_description = $('#task-description-' + i).val();
            var task_id = $('#task-id-' + i).val();
            if (task_start_time != '' && task_description != '' && task_start_time != undefined) {
                tasks.push({
                    task_start_time: task_start_time,
                    task_description: task_description,
                    task_id: task_id
                })
            }
        }
        return tasks;
    }

    function submitForm(notify = true) {

        var eventId = $("#eventeventId").val();

        var operators_notes = $('#operators_notes_input').val();
        var submitted_roster_data = {

            eventId: eventId,

            operators_notes: operators_notes,


        };
        $.each(submitted_roster_data, function(key, input) {
            form_data.append(key, input);
        });
        $.ajax({
            url: base_url + "/guard/updateNotes",
            type: "post",
            dataType: "json",
            data: form_data,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                // return;
                if(result.success == true){
                
                  Swal.fire({
                        text: result.message,
                        icon: "success",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-light"
                        }
                    })
                }
                if (result.message == "start") {
                    $('.eventsaveBtn').prop("disabled", false);
                    Swal.fire({
                        text: 'You cannot add before job date.',
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-light"
                        }
                    })
                    // error_alert(`You cannot add ${guard_url} before job date.`);
                    // info.revert();
                    // info.event.remove();
                    return;
                }
                if (result.message == "end") {
                    $('.eventsaveBtn').prop("disabled", false);
                    // error_alert(`You cannot add ${guard_url} after job date.`);
                    Swal.fire({
                        text: 'You cannot add after job date.',
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-light"
                        }
                    })
                    // info.revert();
                    return;
                }
                if (result.message == "already") {
                    $('.eventsaveBtn').prop("disabled", false);
                    Swal.fire({
                        text: 'These timings are contradicting with other site timings because this guard is already added in another site.',
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-light"
                        }
                    })
                    // error_alert(``);
                    return;

                }
                if (result.message == "updated") {
                    $('.eventsaveBtn').prop("disabled", false);
                    $('#kt_explore_form').css('left', '');
                    // $('#kt_modal_add_event').modal('toggle');
                    $('#kt_explore_form').removeClass('drawer-on');

                    // message_alert(`${guard_url} Added successfully.`);
                    Swal.fire({
                        text: 'Roster updated successfully.',
                        icon: "success",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-light"
                        }
                    })
                    // message_alert("");
                    renderCalendar(0, $('#userType').val());
                }

                if (result.message == "added") {
                    $('.eventsaveBtn').prop("disabled", false);
                    $('#kt_explore_form').css('left', '');
                    // $('#kt_modal_add_event').modal('toggle');
                    $('#kt_explore_form').removeClass('drawer-on');
                    // message_alert(`${guard_url} Added successfully.`);
                    Swal.fire({
                        text: 'Added successfully',
                        icon: "success",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-light"
                        }
                    })
                    renderCalendar(0, $('#userType').val());
                    // renderCalendar(siteId, 'calendar' + siteId, '', start_date);
                }

                if (result.message == "exceeded") {
                    Swal.fire({
                        text: 'limit exceeded',
                        icon: "success",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-light"
                        }
                    })
                    // error_alert(`${guard_url} limit exceeded`);
                    // info.event.remove();

                    return;
                }

                if (result.type == "unauthorized") {
                    // error_alert(result.message);
                    // info.revert();
                    if (result.by_pass == false) {
                        // error_alert(result.message);
                        Swal.fire({
                            text: result.message,
                            icon: "success",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-light"
                            }
                        });
                        // info.revert();
                    } else {
                        Swal.fire({
                            text: result.message,
                            icon: "error",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-light"
                            }
                        });
                        // confirm_from_super_admin(result.message);
                    }
                    return;
                }
                if (result.type == "Visa Expired") {
                    Swal.fire({
                        text: 'Visa Expired',
                        icon: "success",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-light"
                        }
                    });
                    return;
                }
            }
        });
    }

    function addTasks() {
        var task_counter = $('#task_counter').val();
        // if (day_counter < 6) {
        var html = '<div class="col-md-4 form-group task-counter-' + task_counter +
            '"><label for="recipient-name" class="col-form-label">Task Time</label><input type="text" class="form-control form-control-md" name="task-start-time-' +
            task_counter + '" id="task-start-time-' + task_counter + '"></div><div class="col-md-8 task-counter-' +
            task_counter +
            ' form-group"><label for="recipient-name" class="col-form-label">Description</label><div class="row"><div class="col-md-10 "><textarea class="form-control form-control-md" name="task-description-0" id="task-description-' +
            task_counter +
            '" rows="1"></textarea></div><div class="col-md-2"><a class="btn-danger btn" id="add-task-inputs" onclick="delete_task_inputs(' +
            task_counter +
            ')" style="display: inline-block;height: 30px;padding: 2px 10px;"><i class="fas fa-trash fs-1x" style="padding: 0px;margin: 0px;font-size: 16px;"></i></a></div></div></div>';
        $('#tasks-inputs').append(html);
        initialize_time_input('#task-start-time-' + task_counter);
        task_counter++;
        $('#task_counter').val(task_counter);
        // initialize_time_input('#shift-end-time-'+day_counter);
        // }
    }

    function initialize_time_input(id) {
        $(id).flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
        });

    }

    function delete_task_inputs(index, id = null) {


        if (id != null) {
            $.ajax({
                url: base_url + "/guard/deleteTask",
                type: "post",
                dataType: "json",
                data: {
                    task_id: id,
                    _token: token
                },
                success: function(result) {
                    $('.task-counter-' + index).remove();
                }

            });
        } else {
            $('.task-counter-' + index).remove();
        }
    }

    $('#job-custom-rates').on('change', function() {
        if ($(this).prop('checked') == true) {
            $('.custom-rates-input').css('display', '');
        } else {
            $('.custom-rates-input').css('display', 'none');
        }
    });




    function show_leave_option() {
        $('.leave_option_div').css('display', '');
    }

    function checkGuardLeave(roster_id, guard_id) {
        var leave_option = $('#leave_option').val();
        $.ajax({
            url: base_url + "/guard/checkGuardLeave",
            type: "post",
            dataType: "json",
            data: {
                roster_id: roster_id,
                guard_id: guard_id,
                leave_option: leave_option,
                _token: token
            },
            success: function(result) {
                if (result.success) {
                    Swal.fire({
                        text: result.message,
                        icon: "success",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-light"
                        }
                    });
                    $('.leave_option_div').css('display', 'none');
                    $('.guard-leave-option').css('display', 'none');
                    $('#eventguardId').val('');
                    // renderCalendar(0)
                    renderCalendar(0, $('#userType').val());

                } else {
                    // Swal.fire({
                    //               text: result.message,
                    //               icon: "error",
                    //               buttonsStyling: !1,
                    //               confirmButtonText: "Ok, got it!",
                    //               customClass: {
                    //                   confirmButton: "btn btn-light"
                    //               }
                    //           });

                    Swal.fire({
                        text: result.message,
                        icon: "success",
                        showCancelButton: !0,
                        buttonsStyling: !1,
                        confirmButtonText: "Yes",
                        cancelButtonText: "No, cancel",
                        customClass: {
                            confirmButton: "btn fw-bold btn-success",
                            cancelButton: "btn fw-bold btn-active-light-primary"
                        }
                    }).then((function(e) {
                        if (e.value == true) {
                            $.ajax({
                                url: base_url + "/guard/assignGuardLeave",
                                type: "post",
                                dataType: "json",
                                data: {
                                    roster_id: roster_id,
                                    guard_id: guard_id,
                                    leave_option: leave_option,
                                    _token: token
                                },
                                success: function(result) {
                                    if (result.success == true) {
                                        Swal.fire({
                                            text: result.message,
                                            icon: "success",
                                            buttonsStyling: !1,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton: "btn btn-light"
                                            }
                                        });
                                        $('.leave_option_div').css('display',
                                            'none');
                                        $('.guard-leave-option').css('display',
                                            'none');
                                        $('#eventguardId').val('');
                                        // renderCalendar(0)
                                        renderCalendar(0, $('#userType').val());

                                    }

                                }
                            });
                        } else {
                            // Swal.fire({text:"Roster not published!",icon:"error",buttonsStyling:!1,confirmButtonText:"Ok, got it!",customClass:{confirmButton:"btn fw-bold btn-primary"}});
                        }


                    }));
                }
            }

        });


    }

    function loadTabData(tab, guard_id, roster_id, data_id) {
        call_spinner();
        // console.log('I am')
        $.ajax({
            url: base_url + "/guard/loadTabData",
            type: "post",
            dataType: "json",
            data: {
                roster_id: roster_id,
                guard_id: guard_id,
                tab: tab,
                _token: token
            },
            success: function(result) {
                close_spinner();
                $('#' + data_id).html(result);
                if (tab == 'signin') {
                    call_map();
                }
                if (tab == 'signout') {
                    call_map1();
                }
                if (tab == 'tracker') {
                    locations_maps();
                }
                if (tab == 'green_call') {
                    green_call_locations_maps();
                }
            }
        });
    }

    function deleteShift(roster_id) {
        Swal.fire({
            text: "Are you sure you want to delete this shift??",
            icon: "success",
            showCancelButton: !0,
            buttonsStyling: !1,
            confirmButtonText: "Yes",
            cancelButtonText: "No, cancel",
            customClass: {
                confirmButton: "btn fw-bold btn-success",
                cancelButton: "btn fw-bold btn-active-light-primary"
            }
        }).then((function(e) {
            if (e.value == true) {
                $.ajax({
                    url: base_url + "/guard/deleteShift",
                    type: "post",
                    dataType: "json",
                    data: {
                        roster_id: roster_id,
                        _token: token
                    },
                    success: function(result) {
                        if (result.success == true) {
                            $('#kt_explore_form').css('left', '');
                            Swal.fire({
                                text: "Your shift delete successfully.",
                                icon: "success",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary"
                                }
                            })
                            $('#kt_explore_form').removeClass('drawer-on')
                            renderCalendar(0, $('#userType').val());
                        } else {
                            Swal.fire({
                                text: result.message,
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary"
                                }
                            })
                        }
                    }
                });
            } else {
                Swal.fire({
                    text: "Cancel!",
                    icon: "error",
                    buttonsStyling: !1,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn fw-bold btn-primary"
                    }
                });
            }


        }));
    }
    $('input[type=radio][name=job-payable]').on('change', function() {
        console.log($(this).val())
        if ($(this).val() == 'no') {
            $('#paid-by-div').css('display', 'none');
        } else {
            $('#paid-by-div').css('display', '');
        }
    });

    function tt_payable_chargeable() {
        var tt = $('#job-travel-time').val();
        if (tt == 0 || tt == '') {
            if (tt == 0) {
                $('#travel_time_amount_div').css('display', '');
            } else {
                $('#travel_time_amount_div').css('display', 'none');
            }
            $('.tt_payable_chargeable').css('display', 'none');
        } else {
            $('.tt_payable_chargeable').css('display', '');
        }
    }

    function setDateTimeFormat(type) {
        var default_start = $('#default_start').val();
        if (type == 'start') {
            var start_time = $('#event_start_time').val();
            $('#event_starts').val(default_start + ' ' + start_time)
        } else {
            var start_time = $('#event_start_time').val();
            var end_time = $('#event_end_time').val();
            var start_temp = start_time.replace(':', '.') * 1;
            var end_temp = end_time.replace(':', '.') * 1;
            if (end_temp < start_temp) {
                var startDate = new Date(default_start);
                default_start = new Date(startDate.setDate(startDate.getDate() + 1));
                default_start = moment(default_start).format('YYYY-MM-DD');
                // console.log(default_start)
            }
            $('#event_ends').val(default_start + ' ' + end_time)
        }
    }
</script>
