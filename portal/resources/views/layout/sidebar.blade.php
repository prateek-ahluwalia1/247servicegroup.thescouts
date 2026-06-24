<!--begin::Nav-->@section('sidebar')
<!--begin::Nav-->
@if(session()->get('image') == '' && session()->get('image') == NULL)
<style>
    .sidebar_profile {
        width: 30px;
        height: 30px;
        border-radius: 63%;
        background: #d99f23;
        font-size: 17px;
        color: #fff;
        text-align: center;
        line-height: 33px;
        margin: 5px 0;
    }

</style> @endif
<?php 
$permissions = array();
$is_super_admin = 0;
if (session()->has('permissions')) {
    $permissions = json_decode(session()->get('permissions'), true);
}
if (session()->has('isAdmin')) {
    $is_super_admin = session()->get('isAdmin');
}
    // print_r($permissions);
    // exit();
?>
<style>
    #kt_aside {
        width: 200px !important;
    }

    #kt_content {
        margin-left: 1% !important;
        margin-right: -1% !important;
    }

    #kt_wrapper {
        margin-left: 8% !important;
        margin-right: 0% !important;
    }


    /* .card{
				margin-left: 5% !important;
		margin-right: -4% !important;
       }*/

    .page-title {
        margin-left: 5% !important;
    }

    .footer {
        /* margin-left: 6% !important; */
    }


    }

    }

</style>
<!--begin::Primary-->
<link rel="stylesheet" href="{{asset('')}}css/sidebar/custom.css" />
<div data-rbd-droppable-id="sidebar"
    class="  sidebar-size-arrow-container open-sidebar fade-in card d-flex flex-column flex-shrink-0 p-3"
    style="width:210px; overflow-y: auto; ">
    <div class="margin-top-10 margin-bottom-10">
        <div class="aside-logo d-none d-lg-flex flex-column align-items-center flex-column-auto py-10"
            id="kt_aside_logo">
            <a href="{{url('')}}">
                @if(config('custom.business_type')=="demo")
                <!-- <img alt="Logo" crossorigin="anonymous" id="bussiness_logo" src="{{asset('')}}media/logo.png" class="h-140px"> -->
                <img alt="Logo" crossorigin="anonymous" id="bussiness_logo" src="{{config('custom.logo')}}"
                    class="h-70px">
                @else
                <img alt="Logo" crossorigin="anonymous" id="bussiness_logo" src="{{config('custom.logo')}}"
                    class="h-70px">
                @endif

            </a>
        </div>
        @if(session()->get('userType')=='contractor')
        <div class="sidebar-section " data-v-49d408a5="">
            <div class="static-sidebar-item" data-v-5aa85418="">
                <a href="{{url('guard_timesheet')}}">
                    <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
                        <div class="image-container" data-v-5aa85418="">
                            <img class="item-icon" data-v-5aa85418=""
                                src="https://img.icons8.com/color/48/000000/dashboard-layout.png" />
                        </div>
                        <span class="item-name" data-v-5aa85418="">TimeSheet</span>
                    </div>
                </a>
            </div>
            <div class="static-sidebar-item" data-v-5aa85418="">
                <a href="{{url('guard_complete_report')}}">
                    <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
                        <div class="image-container" data-v-5aa85418="">
                            <img class="item-icon" data-v-5aa85418=""
                                src="https://img.icons8.com/color/48/000000/dashboard-layout.png" />
                        </div>
                        <span class="item-name" data-v-5aa85418="">Complete Paysheet</span>
                    </div>
                </a>
            </div>
            <div class="static-sidebar-item" data-v-5aa85418="">
                <a href="{{url('job_tracker')}}">
                    <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
                        <div class="image-container" data-v-5aa85418="">
                            <img class="item-icon" data-v-5aa85418=""
                                src="https://img.icons8.com/color/48/000000/dashboard-layout.png" />
                        </div>
                        <span class="item-name" data-v-5aa85418="">Job Tracker</span>
                    </div>
                </a>
            </div>
            <div class="static-sidebar-item" data-v-5aa85418="">
                <a href="{{url('job_roster')}}">
                    <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
                        <div class="image-container" data-v-5aa85418="">

                            <img src="https://img.icons8.com/color/20/000000/calendar.png" /></div><span
                            class="item-name" data-v-5aa85418="">Job Roster</span>
                    </div>
                    <div class="sidebar-badge-container" data-v-5aa85418=""></div>
                </a>
            </div>
            <div class="static-sidebar-item" data-v-5aa85418="">
                <a href="{{url('invoice_report')}}">
                    <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
                        <div class="image-container" data-v-5aa85418="">
                            <img class="item-icon" data-v-5aa85418=""
                                src="https://img.icons8.com/color/48/000000/dashboard-layout.png" />
                        </div>
                        <span class="item-name" data-v-5aa85418="">Invoice Report</span>
                    </div>
                </a>
            </div>
            <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="directory"
                data-v-d4a9e6b5="">
                <div class="item-container" data-v-d4a9e6b5="">
                    <a href="{{url('guards/?status=active')}}">
                        <div class="item-inner-container" data-v-d4a9e6b5="">
                            <img tabindex="0" role="button" aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                data-rbd-drag-handle-draggable-id="directory"
                                data-rbd-drag-handle-context-id="0" draggable="false" class="drag-handle"
                                data-v-d4a9e6b5="">
                            <img class="item-icon drag-animation-item-icon"
                                src="https://img.icons8.com/ios/30/000000/user-male-circle.png"
                                data-v-d4a9e6b5="" style="background-color: rgb(46, 217, 185);">
                            <div class="name-container" data-v-d4a9e6b5="">Staff</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        @endif
        @if(session()->get('config_recods'))
        @foreach(session()->get('config_recods') as $item)

        <div class="margin-top-10 margin-bottom-10 ">

            @if($item->dashboard === '1' || session()->get('userType') == 'customer')
            @if(session()->get('userType') == 'admin' || session()->get('userType') == 'customer')
            <div class="static-sidebar-item" data-v-5aa85418="">
                <a href="{{url('dashboard')}}">
                    <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
                        <div class="image-container" data-v-5aa85418="">
                            <img class="item-icon" data-v-5aa85418=""
                                src="https://img.icons8.com/color/48/000000/dashboard-layout.png" />
                        </div>
                        <span class="item-name" data-v-5aa85418="">Dashboard</span>
                    </div>
                </a>
            </div>
            @endif
            @if(session()->get('userType') == 'admin' && $is_super_admin == 1)
            @if(config('custom.authenticator') == 1)

            <div class="static-sidebar-item" data-v-5aa85418="">
                <a href="{{url('authenticationQr')}}">
                    <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
                        <div class="image-container" data-v-5aa85418="">
                            <img class="item-icon" data-v-5aa85418=""
                                src="https://img.icons8.com/color/48/000000/dashboard-layout.png" />
                        </div>
                        <span class="item-name" data-v-5aa85418="">Authenticator</span>
                    </div>
                </a>
            </div>
            @endif
            @endif
            @endif
            @if($item->job_roster === '1')
            @if((session()->get('userType') == 'admin' && ($is_super_admin == 1 || (isset($permissions['job_roster']) &&
            $permissions['job_roster'] == true))) || session()->get('userType') == 'customer')
            <div class="static-sidebar-item" data-v-5aa85418="">
                <a href="{{url('job_roster')}}">
                    <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
                        <div class="image-container" data-v-5aa85418="">

                            <img src="https://img.icons8.com/color/20/000000/calendar.png" /></div><span
                            class="item-name" data-v-5aa85418="">Job Roster</span>
                    </div>
                    <div class="sidebar-badge-container" data-v-5aa85418=""></div>
                </a>
            </div>
            @endif
            @endif
            @if($item->time_sheet === '1')
            @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['timesheet']) &&
            $permissions['timesheet'] == true)))
            <div class="static-sidebar-item" data-v-5aa85418="">
                <a href="{{url('guard_timesheet')}}">
                    <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
                        <div class="image-container" data-v-5aa85418="">
                            <img src="https://img.icons8.com/ultraviolet/20/000000/property-time.png" /></div><span
                            class="item-name" data-v-5aa85418="">TimeSheet</span>
                    </div>
                    <div class="sidebar-badge-container" data-v-5aa85418=""></div>
                </a>
            </div>
            @endif
            @endif
            @if($item->job_tracker === '1')
            @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['job_tracker']) &&
            $permissions['job_tracker'] == true)))
            <div class="static-sidebar-item" data-v-5aa85418="">
                <a href="{{url('job_tracker')}}">
                    <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
                        <div class="image-container" data-v-5aa85418="">
                            <img class="item-icon" data-v-5aa85418=""
                                src="https://img.icons8.com/fluency/48/000000/shortlist.png" />
                        </div>
                        <span class="item-name" data-v-5aa85418="">Job Tracker</span>
                    </div>
                    <div class="sidebar-badge-container" data-v-5aa85418=""></div>
                </a>
            </div>
            @endif
            @endif
            @if($item->leave_management === '1')
            @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['leave_management'])
            && $permissions['leave_management'] == true)))
            <div class="static-sidebar-item" data-v-5aa85418="">
                <a href="{{url('guard/activeGuardLeaveManagement')}}">
                    <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
                        <div class="image-container" data-v-5aa85418="">
                            <img class="item-icon" data-v-5aa85418=""
                                src="https://img.icons8.com/fluency/48/000000/shortlist.png" />
                        </div>
                        <span class="item-name" data-v-5aa85418="">Leave Management</span>
                    </div>
                    <div class="sidebar-badge-container" data-v-5aa85418=""></div>
                </a>
            </div>
            @endif
            @endif
            {{-- waqas start working --}}
            @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['leave_management'])
            && $permissions['leave_management'] == true)))
            @if(isset($item->guard_license) && $item->guard_license == '1')
            <div class="static-sidebar-item" data-v-5aa85418="">
                <a href="{{url('guard/guardLicenseFind')}}">
                    <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
                        <div class="image-container" data-v-5aa85418="">
                            <img class="item-icon" data-v-5aa85418=""
                                src="https://img.icons8.com/fluency/48/000000/shortlist.png" />
                        </div>
                        <span class="item-name" data-v-5aa85418="">{{config('custom.guard')}} License</span>
                    </div>
                    <div class="sidebar-badge-container" data-v-5aa85418=""></div>
                </a>
            </div>
            @endif
            @endif
            {{-- waqas ending working --}}
            @if($item->time_clock === '1')
            @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['time_clock']) &&
            $permissions['time_clock'] == true)))
            <div class="static-sidebar-item" data-v-5aa85418="">
                <a href="{{url('timeclock?status=today')}}">
                    <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
                        <div class="image-container" data-v-5aa85418="">
                            <img class="item-icon" data-v-5aa85418=""
                                src="https://img.icons8.com/fluency/48/000000/shortlist.png" /></div><span
                            class="item-name" data-v-5aa85418="">Time Clock</span>
                    </div>
                    <div class="sidebar-badge-container" data-v-5aa85418=""></div>
                </a>
            </div>
            @endif
            @endif
            @if($item->log_user_activities === '1')
            @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['staff_audit']) &&
            $permissions['staff_audit'] == true)))
            <div class="static-sidebar-item" data-v-5aa85418="">
                <a type="button" href="{{url('user_activity_log')}}" class="btn-default" data-kt-menu-trigger="click"
                    data-kt-menu-overflow="true" data-kt-menu-placement="top-start" data-kt-menu-flip="top-end">
                    <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
                        <div class="image-container" data-v-5aa85418="">
                            <img class="item-icon" data-v-5aa85418=""
                                src="https://img.icons8.com/fluency/48/000000/shortlist.png" /></div><span
                            class="item-name" data-v-5aa85418="">Log User Activities</span>
                    </div>
                    <div class="sidebar-badge-container" data-v-5aa85418=""></div>
                </a>
            </div>
            <!-- <div class="static-sidebar-item" data-v-5aa85418="">
                        <a type="button" onclick="fetch_activity_log()" class="btn-default"  data-kt-menu-trigger="click" data-kt-menu-overflow="true" data-kt-menu-placement="top-start" data-kt-menu-flip="top-end" id="kt_activities_toggle" >
                            <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
                                <div class="image-container" data-v-5aa85418="">
                                    <img class="item-icon" data-v-5aa85418=""
                                    src="https://img.icons8.com/fluency/48/000000/shortlist.png" /></div><span
                                    class="item-name" data-v-5aa85418="">Log User Activities</span>
                                </div>
                                <div class="sidebar-badge-container" data-v-5aa85418=""></div>
                            </a>
                        </div> -->
            @endif
            @endif
            @if(isset($item->site_list) && $item->site_list == 1)
            @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['site_list']) &&
            $permissions['site_list'] == true)))
            <div class="static-sidebar-item" data-v-5aa85418="">
                <a type="button" href="{{url('site_list')}}" class="btn-default" data-kt-menu-trigger="click"
                    data-kt-menu-overflow="true" data-kt-menu-placement="top-start" data-kt-menu-flip="top-end">
                    <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
                        <div class="image-container" data-v-5aa85418="">
                            <img class="item-icon" data-v-5aa85418=""
                                src="https://img.icons8.com/fluency/48/000000/shortlist.png" /></div><span
                            class="item-name" data-v-5aa85418="">Site List</span>
                    </div>
                    <div class="sidebar-badge-container" data-v-5aa85418=""></div>
                </a>
            </div>
            @endif
            @endif
            @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['administrator']) &&
            $permissions['administrator'] == true)))
            <div class="static-sidebar-item" data-v-5aa85418="">
                <a type="button" href="{{url('app_status')}}" class="btn-default" data-kt-menu-trigger="click"
                    data-kt-menu-overflow="true" data-kt-menu-placement="top-start" data-kt-menu-flip="top-end">
                    <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
                        <div class="image-container" data-v-5aa85418="">
                            <img class="item-icon" data-v-5aa85418=""
                                src="https://img.icons8.com/fluency/48/000000/shortlist.png" /></div><span
                            class="item-name" data-v-5aa85418="">App Status</span>
                    </div>
                    <div class="sidebar-badge-container" data-v-5aa85418=""></div>
                </a>
            </div>
            <!--  <div class="static-sidebar-item" data-v-5aa85418="">
                <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
                    <div class="image-container" data-v-5aa85418="">
                        <div    data-kt-menu-trigger="click" data-kt-menu-overflow="true" data-kt-menu-placement="top-start" data-kt-menu-flip="top-end" id="kt_activities_toggle">
                            <button class=" btn btn-icon btn-active-color-primary btn-color-gray-400 btn-active-light" onclick="fetch_activity_log()">
                              
                            </button>
                    </div>
                </div>
                    
                </div>
                <div class="sidebar-badge-container" data-v-5aa85418=""></div>
            </div>  -->
            @endif
            @if(session()->get('userType')=='guard')
            <div class="static-sidebar-item" data-v-5aa85418="">
                <a href="{{url('edit_guard').'/'.session()->get('userId')}}">
                    <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
                        <div class="image-container" data-v-5aa85418="">
                            <img class="item-icon" data-v-5aa85418=""
                                src="https://img.icons8.com/fluency/48/000000/shortlist.png" /></div>
                        <span class="item-name" data-v-5aa85418="">Profile Setting</span>
                    </div>
                    <div class="sidebar-badge-container" data-v-5aa85418=""></div>
                </a>
            </div>
            @endif
            <!--  <div class="static-sidebar-item" data-v-5aa85418="">
                <a href="{{url('access')}}">
					<div class="static-sidebar-item-inner-container" data-v-5aa85418="">
						<div class="image-container" data-v-5aa85418="">
							<img class="item-icon" data-v-5aa85418=""
                src="https://img.icons8.com/ios-filled/48/000000/user-rights.png" />
        </div><span class="item-name" data-v-5aa85418="">Permissions</span>
    </div>
    <div class="sidebar-badge-container" data-v-5aa85418=""></div>
    </a>
</div> -->

        </div>
    </div>
    <div>
        @if(session()->get('userType') == 'admin')
        <div data-rbd-droppable-context-id="0">
            <div id="aaf40970-be04-44c0-9058-52f535a6ac9f" data-v-49d408a5="">
                <!-- <div data-rbd-draggable-context-id="0" data-rbd-draggable-id="aaf40970-be04-44c0-9058-52f535a6ac9f" data-v-49d408a5="">  -->
                <div class="sidebar-section " data-v-49d408a5="" style="height: ;">
                    <div class="sidebar-section-inner-container" data-v-49d408a5="">
                        <div class="handle-container" data-v-49d408a5=""><img tabindex="0" role="button"
                                aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                data-rbd-drag-handle-draggable-id="aaf40970-be04-44c0-9058-52f535a6ac9f"
                                data-rbd-drag-handle-context-id="0" draggable="false"
                                class="visibility-hidden drag-handle" data-v-49d408a5="">
                            <div class="section-name false" data-v-49d408a5="">Users</div>
                        </div>
                        <div class="flex-row-centered" data-v-49d408a5="">
                            <a type="button" id="users_dropdown" onclick="toggle_sidebar(this)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17">
                                    <g fill="none" fill-rule="evenodd" transform="translate(0 .5)">
                                        <rect width="15" height="15" x=".5" y=".5" stroke="#AAA" rx="4" />
                                        <path fill="#AAA" fill-rule="nonzero"
                                            d="M9.359 11.7L10.177 10.942 7.802 8.506 10.2 6.104 9.359 5.3 6.2 8.494 6.2 8.506z"
                                            transform="rotate(-90 8.2 8.5)" />
                                    </g>
                                </svg>
                            </a>
                            <div class="margin-right-15" data-v-49d408a5="">
                                <div class="dropdown-menu-wrapper" data-v-45dae309="">
                                    <div class="dropdown-menu-wrapper-toggle" data-v-45dae309="">
                                        <div class="toggle-container" data-v-49d408a5="">
                                            <img src="https://img.icons8.com/material-outlined/64/000000/menu-2.png"
                                                class="meatballs-button dropdown-toggle" data-v-49d408a5="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    @if($item->administrator === '1')
                    @if(session()->get('userType') == 'admin' && ($is_super_admin == 1 ||
                    (isset($permissions['administrator']) && $permissions['administrator'] == true)))
                    <div id="users_dropdown_content" data-rbd-droppable-id="aaf40970-be04-44c0-9058-52f535a6ac9f"
                        data-rbd-droppable-context-id="0" data-v-49d408a5="" style="min-height: 1px;">
                        <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="chat"
                            data-v-d4a9e6b5="">
                            <div class="item-container" data-v-d4a9e6b5="">
                                <a href="{{url('administrators')}}">
                                    <div class="item-inner-container" data-v-d4a9e6b5="">
                                        <img tabindex="0" role="button"
                                            aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                            data-rbd-drag-handle-draggable-id="chat" data-rbd-drag-handle-context-id="0"
                                            draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
                                        <img class="item-icon drag-animation-item-icon"
                                            src="https://img.icons8.com/ios/30/000000/user-male-circle.png"
                                            data-v-d4a9e6b5="" style="background-color: rgb(46, 217, 185);">
                                        <div class="name-container" data-v-d4a9e6b5="">Administrator</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endif
                    @if($item->customer === '1')
                    @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['customer'])
                    && $permissions['customer'] == true)))
                    <div class="sidebar-item" data-rbd-draggable-context-id="0" data-rbd-draggable-id="messages"
                        data-v-d4a9e6b5="">
                        <div class="item-container" data-v-d4a9e6b5="">
                            <a href="{{url('customers')}}">
                                <div class="item-inner-container" data-v-d4a9e6b5="">
                                    <img tabindex="0" role="button" aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                        data-rbd-drag-handle-draggable-id="messages" data-rbd-drag-handle-context-id="0"
                                        draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
                                    <img class="item-icon drag-animation-item-icon"
                                        src="https://img.icons8.com/ios/30/000000/user-male-circle.png"
                                        data-v-d4a9e6b5="" style="background-color: rgb(65, 118, 255);">
                                    <div class="name-container" data-v-d4a9e6b5=""> Customer </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    @endif
                    @endif
                    @if($item->contractor === '1')
                    @if(session()->get('userType')=='admin' && ($is_super_admin == 1 ||
                    (isset($permissions['contractor']) && $permissions['contractor'] == true)))
                    <div class="sidebar-item" data-rbd-draggable-context-id="0" data-rbd-draggable-id="directory"
                        data-v-d4a9e6b5="">
                        <div class="item-container" data-v-d4a9e6b5="">
                            <a href="{{url('contractors')}}">
                                <div class="item-inner-container" data-v-d4a9e6b5="">
                                    <img tabindex="0" role="button" aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                        data-rbd-drag-handle-draggable-id="directory"
                                        data-rbd-drag-handle-context-id="0" draggable="false" class="drag-handle"
                                        data-v-d4a9e6b5="">
                                    <img class="item-icon drag-animation-item-icon"
                                        src="https://img.icons8.com/ios/30/000000/user-male-circle.png"
                                        data-v-d4a9e6b5="" style="background-color: rgb(225, 48, 113);">
                                    <div class="name-container" data-v-d4a9e6b5="">Contractor </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endif
                    @endif
                    @endif
                    @if($item->guards === '1')
                    @if((session()->get('userType') == 'admin' && ($is_super_admin == 1 || (isset($permissions['guard'])
                    && $permissions['guard'] == true))) || session()->get('userType') == 'customer')
                    <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="directory"
                        data-v-d4a9e6b5="">
                        <div class="item-container" data-v-d4a9e6b5="">
                            <a href="{{url('guards/?status=active')}}">
                                <div class="item-inner-container" data-v-d4a9e6b5="">
                                    <img tabindex="0" role="button" aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                        data-rbd-drag-handle-draggable-id="directory"
                                        data-rbd-drag-handle-context-id="0" draggable="false" class="drag-handle"
                                        data-v-d4a9e6b5="">
                                    <img class="item-icon drag-animation-item-icon"
                                        src="https://img.icons8.com/ios/30/000000/user-male-circle.png"
                                        data-v-d4a9e6b5="" style="background-color: rgb(46, 217, 185);">
                                    <div class="name-container" data-v-d4a9e6b5="">{{config('custom.guard')}}</div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endif
                    @endif
                    @if($item->permissions === '1')
                    @if(session()->get('userType') == 'admin' && $is_super_admin == 1)
                    <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="directory"
                        data-v-d4a9e6b5="">
                        <div class="item-container" data-v-d4a9e6b5="">
                            <a href="{{url('access')}}">
                                <div class="item-inner-container" data-v-d4a9e6b5="">
                                    <img tabindex="0" role="button" aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                        data-rbd-drag-handle-draggable-id="directory"
                                        data-rbd-drag-handle-context-id="0" draggable="false" class="  drag-handle"
                                        data-v-d4a9e6b5="">
                                    <img class="item-icon drag-animation-item-icon" data-v-d4a9e6b5=""
                                        style="background-color: rgb(46, 217, 185);"
                                        src="https://img.icons8.com/ios-filled/48/000000/user-rights.png" /><span
                                        class="item-name" style="margin-left:2px" data-v-5aa85418="">Permissions</span>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endif
                    @endif


                    <!--  {{-- </div> --}} -->

                </div>
            </div>
        </div>
        <!-- {{-- </div> --}} -->
        @if(session()->get('userType') == 'admin')
        @if($item->chat === '1' || $item->announcements_induction == '')
        <div class="sidebar-section " data-v-49d408a5="" style="height: ;">
            <div class="sidebar-section-inner-container" data-v-49d408a5="">
                <div class="handle-container" data-v-49d408a5=""><img tabindex="0" role="button"
                        aria-describedby="rbd-hidden-text-0-hidden-text-0"
                        data-rbd-drag-handle-draggable-id="aaf40970-be04-44c0-9058-52f535a6ac9f"
                        data-rbd-drag-handle-context-id="0" draggable="false" class="visibility-hidden drag-handle"
                        data-v-49d408a5="">
                    <div class="section-name false" data-v-49d408a5="">Communication</div>
                </div>
                <div class="flex-row-centered" data-v-49d408a5="">
                    <a type="button" id="communication_dropdown" onclick="toggle_sidebar(this)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17">
                            <g fill="none" fill-rule="evenodd" transform="translate(0 .5)">
                                <rect width="15" height="15" x=".5" y=".5" stroke="#AAA" rx="4" />
                                <path fill="#AAA" fill-rule="nonzero"
                                    d="M9.359 11.7L10.177 10.942 7.802 8.506 10.2 6.104 9.359 5.3 6.2 8.494 6.2 8.506z"
                                    transform="rotate(-90 8.2 8.5)" />
                            </g>
                        </svg>
                    </a>
                    <div class="margin-right-15" data-v-49d408a5="">
                        <div class="dropdown-menu-wrapper" data-v-45dae309="">
                            <div class="dropdown-menu-wrapper-toggle" data-v-45dae309="">
                                <div class="toggle-container" data-v-49d408a5=""><img
                                        src="https://img.icons8.com/material-outlined/64/000000/menu-2.png"
                                        class="meatballs-button dropdown-toggle" data-v-49d408a5="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if($item->chat === '1')
            @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['communication']) &&
            $permissions['communication'] == true)))
            <div id="communication_dropdown_content" data-rbd-droppable-id="aaf40970-be04-44c0-9058-52f535a6ac9f"
                data-rbd-droppable-context-id="0" data-v-49d408a5="" style="min-height: 1px;">
                <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="chat"
                    data-v-d4a9e6b5="">
                    <div class="item-container" data-v-d4a9e6b5="">
                        <a href="{{url('chat')}}">
                            <div class="item-inner-container" data-v-d4a9e6b5="">
                                <img tabindex="0" role="button" aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                    data-rbd-drag-handle-draggable-id="chat" data-rbd-drag-handle-context-id="0"
                                    draggable="false" class="drag-handle" data-v-d4a9e6b5="">
                                <img class="item-icon drag-animation-item-icon"
                                    src="https://s3.eu-central-1.amazonaws.com/onefid.content.assets/shared/subCategoryIcons/Icon_chat.png"
                                    data-v-d4a9e6b5="" style="background-color: rgb(46, 217, 185);">
                                <div class="name-container" data-v-d4a9e6b5="">Chat</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            @endif
            @endif
            @if($item->announcements_induction === '1')
            @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['announcements_induction']) &&
            $permissions['announcements_induction'] == true)))
            <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="messages"
                data-v-d4a9e6b5="">
                <div class="item-container" data-v-d4a9e6b5="">
                    <a href="{{url('announcements/new')}}">
                        <div class="item-inner-container" data-v-d4a9e6b5="">
                            <img tabindex="0" role="button" aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                data-rbd-drag-handle-draggable-id="messages" data-rbd-drag-handle-context-id="0"
                                draggable="false" class="drag-handle" data-v-d4a9e6b5="">
                            <img class="item-icon drag-animation-item-icon"
                                src="https://s3.eu-central-1.amazonaws.com/onefid.content.assets/shared/subCategoryIcons/Icon_envelope.png"
                                data-v-d4a9e6b5="" style="background-color: rgb(65, 118, 255);">
                            <div class="name-container" data-v-d4a9e6b5="">Announcements | Induction</div>
                        </div>
                    </a>
                </div>
            </div>
            @endif
            @endif
            @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['announcements']) &&
            $permissions['announcements'] == true)))
            <!--  <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="messages" data-v-d4a9e6b5="">
            <div class="item-container" data-v-d4a9e6b5="">
                <a href="{{url('announcements/inductions')}}">
                <div class="item-inner-container" data-v-d4a9e6b5="">
                    <img tabindex="0" role="button" aria-describedby="rbd-hidden-text-0-hidden-text-0"data-rbd-drag-handle-draggable-id="messages" data-rbd-drag-handle-context-id="0" draggable="false" class="drag-handle" data-v-d4a9e6b5="">
                    <img class="item-icon drag-animation-item-icon" src="https://s3.eu-central-1.amazonaws.com/onefid.content.assets/shared/subCategoryIcons/Icon_envelope.png" data-v-d4a9e6b5="" style="background-color: rgb(65, 118, 255);">
                        <div class="name-container" data-v-d4a9e6b5="">Announcements </div>
                </div>
                </a>
            </div>
        </div> -->
            @endif

            @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['tutorial']) &&
            $permissions['tutorial'] == true)))
            <!-- <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="directory" data-v-d4a9e6b5="">
            <div class="item-container" data-v-d4a9e6b5="">
                <a href="{{url('inductions')}}">
                <div class="item-inner-container" data-v-d4a9e6b5="">
                    <img tabindex="0" role="button" aria-describedby="rbd-hidden-text-0-hidden-text-0" data-rbd-drag-handle-draggable-id="directory" data-rbd-drag-handle-context-id="0" draggable="false" class="drag-handle" data-v-d4a9e6b5="">
                    <img class="item-icon drag-animation-item-icon" src="https://s3.eu-central-1.amazonaws.com/onefid.content.assets/shared/subCategoryIcons/Icon_Directory.png" data-v-d4a9e6b5="" style="background-color: rgb(225, 48, 113);">
                        <div class="name-container" data-v-d4a9e6b5="">Induction</div>
                </div>
                </a>
            </div>
        </div> -->
            @endif
        </div>
        <!-- </div> -->
        @endif
        @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['reports']) &&
        $permissions['reports'] == true)))
        <div class="sidebar-section " data-v-49d408a5="" style="height: ;">
            <div class="sidebar-section-inner-container" data-v-49d408a5="">
                <div class="handle-container" data-v-49d408a5=""><img tabindex="0" role="button"
                        aria-describedby="rbd-hidden-text-0-hidden-text-0"
                        data-rbd-drag-handle-draggable-id="aaf40970-be04-44c0-9058-52f535a6ac9f"
                        data-rbd-drag-handle-context-id="0" draggable="false" class="visibility-hidden drag-handle"
                        data-v-49d408a5="">
                    <div class="section-name false" data-v-49d408a5="">Reports</div>
                </div>
                <div class="flex-row-centered" data-v-49d408a5="">
                    <a type="button" id="reports_dropdown" onclick="toggle_sidebar(this)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17">
                            <g fill="none" fill-rule="evenodd" transform="translate(0 .5)">
                                <rect width="15" height="15" x=".5" y=".5" stroke="#AAA" rx="4" />
                                <path fill="#AAA" fill-rule="nonzero"
                                    d="M9.359 11.7L10.177 10.942 7.802 8.506 10.2 6.104 9.359 5.3 6.2 8.494 6.2 8.506z"
                                    transform="rotate(-90 8.2 8.5)" />
                            </g>
                        </svg>
                    </a>
                    <div class="margin-right-15" data-v-49d408a5="">
                        <div class="dropdown-menu-wrapper" data-v-45dae309="">
                            <div class="dropdown-menu-wrapper-toggle" data-v-45dae309="">
                                <div class="toggle-container" data-v-49d408a5=""><img
                                        src="https://img.icons8.com/material-outlined/64/000000/menu-2.png"
                                        class="meatballs-button dropdown-toggle" data-v-49d408a5=""></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if($item->tasks_report === '1')
            @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['task_report']) &&
            $permissions['task_report'] == true)))

            <div id="reports_dropdown_content" data-rbd-droppable-id="aaf40970-be04-44c0-9058-52f535a6ac9f"
                data-rbd-droppable-context-id="0" data-v-49d408a5="" style="min-height: 1px;">
                <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="chat"
                    data-v-d4a9e6b5="">
                    <div class="item-container" data-v-d4a9e6b5="">
                        <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                                aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                data-rbd-drag-handle-draggable-id="chat" data-rbd-drag-handle-context-id="0"
                                draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
                            <a href="{{url('task_report')}}"><img class="item-icon drag-animation-item-icon"
                                    src="https://img.icons8.com/external-flatart-icons-flat-flatarticons/64/000000/external-report-project-planing-flatart-icons-flat-flatarticons-1.png"
                                    data-v-d4a9e6b5="">
                                <div class="name-container" data-v-d4a9e6b5="">Tasks Report
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endif
            @if(isset($item->signin_out_report) && $item->signin_out_report === '1')
            <!--  <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="chat" data-v-d4a9e6b5="">
            <div class="item-container" data-v-d4a9e6b5="">
                <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                    aria-describedby="rbd-hidden-text-0-hidden-text-0" data-rbd-drag-handle-draggable-id="chat"
                    data-rbd-drag-handle-context-id="0" draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
                    <a href="{{url('signin_out_report')}}"><img class="item-icon drag-animation-item-icon"
                        src="https://img.icons8.com/external-flatart-icons-flat-flatarticons/64/000000/external-report-project-planing-flatart-icons-flat-flatarticons-1.png"
                        data-v-d4a9e6b5="">
                        <div class="name-container" data-v-d4a9e6b5="">Signin-Out Report
                        </a>
                    </div>
                </div>
            </div>
        </div> -->
            @endif
            @if($item->audit_report === '1')
            @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['audit_report']) &&
            $permissions['audit_report'] == true)))
            <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="messages"
                data-v-d4a9e6b5="">
                <div class="item-container" data-v-d4a9e6b5="">
                    <a href="{{url('audit_report')}}">
                        <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                                aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                data-rbd-drag-handle-draggable-id="chat" data-rbd-drag-handle-context-id="0"
                                draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
                            <img class="item-icon drag-animation-item-icon"
                                src="https://img.icons8.com/external-flatart-icons-flat-flatarticons/64/000000/external-report-project-planing-flatart-icons-flat-flatarticons-1.png"
                                data-v-d4a9e6b5="">
                            <div class="name-container" data-v-d4a9e6b5="">Audit Report
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @endif
            @endif
            @if($item->contractor_report === '1')
            @if(session()->get('userType')=='admin' && ($is_super_admin == 1 ||
            (isset($permissions['contractor_report']) && $permissions['contractor_report'] == true)))
            <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="messages"
                data-v-d4a9e6b5="">
                <div class="item-container" data-v-d4a9e6b5="">
                    <a href="{{url('contractor_report')}}">
                        <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                                aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                data-rbd-drag-handle-draggable-id="chat" data-rbd-drag-handle-context-id="0"
                                draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
                            <img class="item-icon drag-animation-item-icon"
                                src="https://img.icons8.com/external-flatart-icons-flat-flatarticons/64/000000/external-report-project-planing-flatart-icons-flat-flatarticons-1.png"
                                data-v-d4a9e6b5="">
                            <div class="name-container" data-v-d4a9e6b5="">Contractor Report
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @endif
            @endif
            @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['customer_report'])
            && $permissions['customer_report'] == true)))
            <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="directory"
                data-v-d4a9e6b5="">
                <div class="item-container" data-v-d4a9e6b5="">
                    <a href="{{url('customer_report')}}">
                        <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                                aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                data-rbd-drag-handle-draggable-id="chat" data-rbd-drag-handle-context-id="0"
                                draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
                            <img class="item-icon drag-animation-item-icon"
                                src="https://img.icons8.com/external-flatart-icons-flat-flatarticons/64/000000/external-report-project-planing-flatart-icons-flat-flatarticons-1.png"
                                data-v-d4a9e6b5="">
                            <div class="name-container" data-v-d4a9e6b5="">Customer Report
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @endif
            @if($item->report === '1')
            @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['guard_report']) &&
            $permissions['guard_report'] == true)))
            <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="directory"
                data-v-d4a9e6b5="">
                <div class="item-container" data-v-d4a9e6b5="">
                    <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                            aria-describedby="rbd-hidden-text-0-hidden-text-0" data-rbd-drag-handle-draggable-id="chat"
                            data-rbd-drag-handle-context-id="0" draggable="false" class="  drag-handle"
                            data-v-d4a9e6b5="">

                        <div class="name-container" data-v-d4a9e6b5=""><a href="{{url('guard_detail_report')}}"><img
                                    class="item-icon drag-animation-item-icon"
                                    src="https://img.icons8.com/external-flatart-icons-flat-flatarticons/64/000000/external-report-project-planing-flatart-icons-flat-flatarticons-1.png"
                                    data-v-d4a9e6b5="">{{config('custom.guard')}} Report</a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endif
            @if($item->invoice_report === '1')
            @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['invoice_report'])
            && $permissions['invoice_report'] == true)))

            <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="messages"
                data-v-d4a9e6b5="">
                <div class="item-container" data-v-d4a9e6b5="">
                    <a href="{{url('invoice_report')}}">
                        <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                                aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                data-rbd-drag-handle-draggable-id="chat" data-rbd-drag-handle-context-id="0"
                                draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
                            <img class="item-icon drag-animation-item-icon"
                                src="https://img.icons8.com/external-flatart-icons-flat-flatarticons/64/000000/external-report-project-planing-flatart-icons-flat-flatarticons-1.png"
                                data-v-d4a9e6b5="">
                            <div class="name-container" data-v-d4a9e6b5="">Invoice Report
                            </div>
                        </div>
                    </a>

                </div>
            </div>
            @endif
            @endif
            @if($item->signin_out_report === '1')
            @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['signin_out_report'])
            && $permissions['signin_out_report'] == true)))
            <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="messages"
                data-v-d4a9e6b5="">
                <div class="item-container" data-v-d4a9e6b5="">
                    <a href="{{url('signinout_report')}}">
                        <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                                aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                data-rbd-drag-handle-draggable-id="chat" data-rbd-drag-handle-context-id="0"
                                draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
                            <img class="item-icon drag-animation-item-icon"
                                src="https://img.icons8.com/external-flatart-icons-flat-flatarticons/64/000000/external-report-project-planing-flatart-icons-flat-flatarticons-1.png"
                                data-v-d4a9e6b5="">
                            <div class="name-container" data-v-d4a9e6b5="">Signin-out Report
                            </div>
                        </div>
                    </a>

                </div>
            </div>
            @endif
            @endif
            @if(isset($item->hour_report) && $item->hour_report === '1')

            <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="messages"
                data-v-d4a9e6b5="">
                <div class="item-container" data-v-d4a9e6b5="">
                    <a href="{{url('invoice_report?type=hour')}}">
                        <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                                aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                data-rbd-drag-handle-draggable-id="chat" data-rbd-drag-handle-context-id="0"
                                draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
                            <img class="item-icon drag-animation-item-icon"
                                src="https://img.icons8.com/external-flatart-icons-flat-flatarticons/64/000000/external-report-project-planing-flatart-icons-flat-flatarticons-1.png"
                                data-v-d4a9e6b5="">
                            <div class="name-container" data-v-d4a9e6b5="">Hour Report
                            </div>
                        </div>
                    </a>

                </div>
            </div>
            @endif
            @if($item->quick_Paysheet === '1')
            @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['paysheet_report'])
            && $permissions['paysheet_report'] == true)))

            <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="directory"
                data-v-d4a9e6b5="">
                <div class="item-container" data-v-d4a9e6b5="">
                    <a href="{{url('guard_payseet')}}">
                        <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                                aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                data-rbd-drag-handle-draggable-id="chat" data-rbd-drag-handle-context-id="0"
                                draggable="false" class="  drag-handle" data-v-d4a9e6b5="">

                            <div class="name-container" data-v-d4a9e6b5=""><img
                                    class="item-icon drag-animation-item-icon"
                                    src="https://img.icons8.com/external-flatart-icons-flat-flatarticons/64/000000/external-report-project-planing-flatart-icons-flat-flatarticons-1.png"
                                    data-v-d4a9e6b5="">Quick Paysheet
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @endif
            @endif
            <!-- <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="directory" data-v-d4a9e6b5="">
    <div class="item-container" data-v-d4a9e6b5="">
        <a href="{{url('guard_timesheet')}}">
            <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                    aria-describedby="rbd-hidden-text-0-hidden-text-0" data-rbd-drag-handle-draggable-id="chat"
                    data-rbd-drag-handle-context-id="0" draggable="false" class="  drag-handle" data-v-d4a9e6b5="">

                <div class="name-container" data-v-d4a9e6b5=""><img class="item-icon drag-animation-item-icon"
                        src="https://img.icons8.com/external-flatart-icons-flat-flatarticons/64/000000/external-report-project-planing-flatart-icons-flat-flatarticons-1.png"
                        data-v-d4a9e6b5="">Timesheet Report
                </div>
            </div>
        </a>
    </div>
</div> -->
            @if($item->incident_report_page === '1')
            @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['incident_report'])
            && $permissions['incident_report'] == true)))

            <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="directory"
                data-v-d4a9e6b5="">
                <div class="item-container" data-v-d4a9e6b5="">
                    <a href="{{url('incident_report_page')}}">
                        <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                                aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                data-rbd-drag-handle-draggable-id="chat" data-rbd-drag-handle-context-id="0"
                                draggable="false" class="  drag-handle" data-v-d4a9e6b5="">

                            <div class="name-container" data-v-d4a9e6b5=""><img
                                    class="item-icon drag-animation-item-icon"
                                    src="https://img.icons8.com/external-flatart-icons-flat-flatarticons/64/000000/external-report-project-planing-flatart-icons-flat-flatarticons-1.png"
                                    data-v-d4a9e6b5="">Incident Report Page
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @endif
            @endif
            @if($item->complete_paysheet === '1')
            @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['complete_report'])
            && $permissions['complete_report'] == true)))

            <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="directory"
                data-v-d4a9e6b5="">
                <div class="item-container" data-v-d4a9e6b5="">
                    <a href="{{url('guard_complete_report')}}">
                        <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                                aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                data-rbd-drag-handle-draggable-id="chat" data-rbd-drag-handle-context-id="0"
                                draggable="false" class="  drag-handle" data-v-d4a9e6b5="">

                            <div class="name-container" data-v-d4a9e6b5=""><img
                                    class="item-icon drag-animation-item-icon"
                                    src="https://img.icons8.com/external-flatart-icons-flat-flatarticons/64/000000/external-report-project-planing-flatart-icons-flat-flatarticons-1.png"
                                    data-v-d4a9e6b5="">Complete Paysheet
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @endif
            @endif
            @if($item->division_consolidation === '1')
            @if(session()->get('userType')=='admin' && ($is_super_admin == 1 ||
            (isset($permissions['division_consolidation']) && $permissions['division_consolidation'] == true)))

            <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="directory"
                data-v-d4a9e6b5="">
                <div class="item-container" data-v-d4a9e6b5="">
                    <a href="{{url('division_consolidation')}}">
                        <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                                aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                data-rbd-drag-handle-draggable-id="chat" data-rbd-drag-handle-context-id="0"
                                draggable="false" class="  drag-handle" data-v-d4a9e6b5="">

                            <div class="name-container" data-v-d4a9e6b5=""><img
                                    class="item-icon drag-animation-item-icon"
                                    src="https://img.icons8.com/external-flatart-icons-flat-flatarticons/64/000000/external-report-project-planing-flatart-icons-flat-flatarticons-1.png"
                                    data-v-d4a9e6b5="">Division Consolidation
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @endif
            @endif
            @if(config('custom.multi_report') == 1)
            <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="directory"
                data-v-d4a9e6b5="">
                <div class="item-container" data-v-d4a9e6b5="">
                    <a href="{{url('combine_report')}}">
                        <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                                aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                data-rbd-drag-handle-draggable-id="chat" data-rbd-drag-handle-context-id="0"
                                draggable="false" class="  drag-handle" data-v-d4a9e6b5="">

                            <div class="name-container" data-v-d4a9e6b5=""><img
                                    class="item-icon drag-animation-item-icon"
                                    src="https://img.icons8.com/external-flatart-icons-flat-flatarticons/64/000000/external-report-project-planing-flatart-icons-flat-flatarticons-1.png"
                                    data-v-d4a9e6b5="">Multi Report
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <!-- </div> -->
            <!-- </div> -->
            @endif
            @if(config('custom.own_payrates') == 1)
            <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="directory"
                data-v-d4a9e6b5="">
                <div class="item-container" data-v-d4a9e6b5="">
                    <a href="{{url('award_report')}}">
                        <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                                aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                data-rbd-drag-handle-draggable-id="chat" data-rbd-drag-handle-context-id="0"
                                draggable="false" class="  drag-handle" data-v-d4a9e6b5="">

                            <div class="name-container" data-v-d4a9e6b5=""><img
                                    class="item-icon drag-animation-item-icon"
                                    src="https://img.icons8.com/external-flatart-icons-flat-flatarticons/64/000000/external-report-project-planing-flatart-icons-flat-flatarticons-1.png"
                                    data-v-d4a9e6b5="">Award Report
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @endif

            @endif
        </div>


        @if(($is_super_admin == 1 || ((isset($permissions['charge_rates']) && $permissions['charge_rates'] == true) ||
        (isset($permissions['pay_rates']) && $permissions['pay_rates'] == true))))
        <div class="sidebar-section " data-v-49d408a5="" style="height: ;">
            <div class="sidebar-section-inner-container" data-v-49d408a5="">
                <div class="handle-container" data-v-49d408a5=""><img tabindex="0" role="button"
                        aria-describedby="rbd-hidden-text-0-hidden-text-0"
                        data-rbd-drag-handle-draggable-id="aaf40970-be04-44c0-9058-52f535a6ac9f"
                        data-rbd-drag-handle-context-id="0" draggable="false" class="visibility-hidden drag-handle"
                        data-v-49d408a5="">
                    <div class="section-name false" data-v-49d408a5="">Rates</div>
                </div>
                <div class="flex-row-centered" data-v-49d408a5="">
                    <a type="button" id="rates_dropdown" onclick="toggle_sidebar(this)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17">
                            <g fill="none" fill-rule="evenodd" transform="translate(0 .5)">
                                <rect width="15" height="15" x=".5" y=".5" stroke="#AAA" rx="4" />
                                <path fill="#AAA" fill-rule="nonzero"
                                    d="M9.359 11.7L10.177 10.942 7.802 8.506 10.2 6.104 9.359 5.3 6.2 8.494 6.2 8.506z"
                                    transform="rotate(-90 8.2 8.5)" />
                            </g>
                        </svg>
                    </a>
                    <div class="margin-right-15" data-v-49d408a5="">
                        <div class="dropdown-menu-wrapper" data-v-45dae309="">
                            <div class="dropdown-menu-wrapper-toggle" data-v-45dae309="">
                                <div class="toggle-container" data-v-49d408a5=""><img
                                        src="https://img.icons8.com/material-outlined/64/000000/menu-2.png"
                                        class="meatballs-button dropdown-toggle" data-v-49d408a5=""></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="rates_dropdown_content" data-rbd-droppable-id="aaf40970-be04-44c0-9058-52f535a6ac9f"
                data-rbd-droppable-context-id="0" data-v-49d408a5="" style="min-height: 1px;">
                @if(isset($item->charge_rates) && $item->charge_rates == '1' && config('custom.own_payrates') == 0)

                @if(session()->get('userType') == 'admin' && ($is_super_admin == 1 ||
                (isset($permissions['charge_rates']) && $permissions['charge_rates'] == true)))

                <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="chat"
                    data-v-d4a9e6b5="">
                    <div class="item-container" data-v-d4a9e6b5="">
                        <a href="{{url('charged_rates')}}">
                            <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                                    aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                    data-rbd-drag-handle-draggable-id="chat" data-rbd-drag-handle-context-id="0"
                                    draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
                                <img class="item-icon drag-animation-item-icon"
                                    src="https://img.icons8.com/external-kiranshastry-lineal-kiranshastry/64/000000/external-dollar-banking-and-finance-kiranshastry-lineal-kiranshastry-6.png"
                                    data-v-d4a9e6b5="" style="background-color: rgb(46, 217, 185);">
                                <div class="name-container" data-v-d4a9e6b5="">Charge Rates
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                @endif
                @endif
                @if($item->pay_rates == '1' && config('custom.own_payrates') == 0)
                @if(session()->get('userType') == 'admin' && ($is_super_admin == 1 || (isset($permissions['pay_rates'])
                && $permissions['pay_rates'] == true)))
                <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="messages"
                    data-v-d4a9e6b5="">
                    <div class="item-container" data-v-d4a9e6b5="">
                        <a href="{{url('payrates')}}">
                            <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                                    aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                    data-rbd-drag-handle-draggable-id="messages" data-rbd-drag-handle-context-id="0"
                                    draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
                                <img class="item-icon drag-animation-item-icon"
                                    src="https://img.icons8.com/external-kiranshastry-lineal-kiranshastry/64/000000/external-dollar-banking-and-finance-kiranshastry-lineal-kiranshastry-6.png"
                                    data-v-d4a9e6b5="" style="background-color: rgb(65, 118, 255);">
                                <div class="name-container" data-v-d4a9e6b5="">Pay Rates
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                @endif
                @endif
                @if(config('custom.own_payrates') == 1)
                <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="messages"
                    data-v-d4a9e6b5="">
                    <div class="item-container" data-v-d4a9e6b5="">
                        <a href="{{url('payrates_new?type=abn')}}">
                            <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                                    aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                    data-rbd-drag-handle-draggable-id="messages" data-rbd-drag-handle-context-id="0"
                                    draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
                                <img class="item-icon drag-animation-item-icon"
                                    src="https://img.icons8.com/external-kiranshastry-lineal-kiranshastry/64/000000/external-dollar-banking-and-finance-kiranshastry-lineal-kiranshastry-6.png"
                                    data-v-d4a9e6b5="" style="background-color: rgb(65, 118, 255);">
                                <div class="name-container" data-v-d4a9e6b5="">ABN Rates
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="messages"
                    data-v-d4a9e6b5="">
                    <div class="item-container" data-v-d4a9e6b5="">
                        <a href="{{url('payrates_new?type=eba')}}">
                            <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                                    aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                    data-rbd-drag-handle-draggable-id="messages" data-rbd-drag-handle-context-id="0"
                                    draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
                                <img class="item-icon drag-animation-item-icon"
                                    src="https://img.icons8.com/external-kiranshastry-lineal-kiranshastry/64/000000/external-dollar-banking-and-finance-kiranshastry-lineal-kiranshastry-6.png"
                                    data-v-d4a9e6b5="" style="background-color: rgb(65, 118, 255);">
                                <div class="name-container" data-v-d4a9e6b5="">EBA Rates
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="messages"
                    data-v-d4a9e6b5="">
                    <div class="item-container" data-v-d4a9e6b5="">
                        <a href="{{url('award_payrates')}}">
                            <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                                    aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                    data-rbd-drag-handle-draggable-id="messages" data-rbd-drag-handle-context-id="0"
                                    draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
                                <img class="item-icon drag-animation-item-icon"
                                    src="https://img.icons8.com/external-kiranshastry-lineal-kiranshastry/64/000000/external-dollar-banking-and-finance-kiranshastry-lineal-kiranshastry-6.png"
                                    data-v-d4a9e6b5="" style="background-color: rgb(65, 118, 255);">
                                <div class="name-container" data-v-d4a9e6b5="">Award Rates
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif
        <div class="flex-row-centered add-new-feature">
            <div class=""> </div>
        </div>
         @if(isset($item->ph_settings) && $item->ph_settings === '1' && $is_super_admin == 1)
            <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="directory"
                data-v-d4a9e6b5="">
                <div class="item-container" data-v-d4a9e6b5="">
                    <a href="{{url('ph_settings')}}">
                        <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                                aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                data-rbd-drag-handle-draggable-id="directory" data-rbd-drag-handle-context-id="0"
                                draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
                            <img class="item-icon drag-animation-item-icon"
                                src="https://img.icons8.com/ios-glyphs/30/000000/settings--v1.png"
                                data-v-d4a9e6b5="" style="background-color: rgb(225, 48, 113);">
                            <div class="name-container" data-v-d4a9e6b5="">PH Settings
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @endif
         @if(isset($item->app_status) && $item->app_status === '1' && $is_super_admin != 1)
            <div class="static-sidebar-item" data-v-5aa85418="">
                    <a type="button" href="{{url('app_status')}}" class="btn-default" data-kt-menu-trigger="click"
                        data-kt-menu-overflow="true" data-kt-menu-placement="top-start" data-kt-menu-flip="top-end">
                        <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
                            <div class="image-container" data-v-5aa85418="">
                                <img class="item-icon" data-v-5aa85418=""
                                    src="https://img.icons8.com/fluency/48/000000/shortlist.png" /></div><span
                                class="item-name" data-v-5aa85418="">App Status</span>
                        </div>
                        <div class="sidebar-badge-container" data-v-5aa85418=""></div>
                    </a>
                </div>
            @endif
        @if($item->email === '1' || $item->ph_settings === '1' || $item->color_settings === '1')
        <!--@if(session()->get('userType') == 'admin' && $is_super_admin == 1)-->
        <div class="sidebar-section " data-v-49d408a5="">
            <div class="sidebar-section-inner-container" data-v-49d408a5="">
                <div class="handle-container" data-v-49d408a5=""><img tabindex="0" role="button"
                        aria-describedby="rbd-hidden-text-0-hidden-text-0"
                        data-rbd-drag-handle-draggable-id="aaf40970-be04-44c0-9058-52f535a6ac9f"
                        data-rbd-drag-handle-context-id="0" draggable="false" class="visibility-hidden drag-handle"
                        data-v-49d408a5="">
                    <div class="section-name false" data-v-49d408a5="">Portal Setting</div>
                </div>
                <div class="flex-row-centered" data-v-49d408a5="">
                    <a type="button" id="app_dropdown" onclick="toggle_sidebar(this)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17">
                            <g fill="none" fill-rule="evenodd" transform="translate(0 .5)">
                                <rect width="15" height="15" x=".5" y=".5" stroke="#AAA" rx="4" />
                                <path fill="#AAA" fill-rule="nonzero"
                                    d="M9.359 11.7L10.177 10.942 7.802 8.506 10.2 6.104 9.359 5.3 6.2 8.494 6.2 8.506z"
                                    transform="rotate(-90 8.2 8.5)" />
                            </g>
                        </svg>
                    </a>
                    <div class="margin-right-15" data-v-49d408a5="">
                        <div class="dropdown-menu-wrapper" data-v-45dae309="">
                            <div class="dropdown-menu-wrapper-toggle" data-v-45dae309="">
                                <div class="toggle-container" data-v-49d408a5=""><img
                                        src="https://img.icons8.com/material-outlined/64/000000/menu-2.png"
                                        class="meatballs-button dropdown-toggle" data-v-49d408a5=""></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="app_dropdown_content" data-rbd-droppable-id="aaf40970-be04-44c0-9058-52f535a6ac9f"
                data-rbd-droppable-context-id="0" data-v-49d408a5="" style="min-height: 1px;">
                @if($item->email === '1')
                <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="chat"
                    data-v-d4a9e6b5="">

                    <div class="item-container" data-v-d4a9e6b5="">
                        <a href="{{url('portal_email_settings')}}">
                            <div class="item-inner-container" data-v-d4a9e6b5="">
                                <img tabindex="0" role="button" aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                    data-rbd-drag-handle-draggable-id="chat" data-rbd-drag-handle-context-id="0"
                                    draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
                                <img class="item-icon drag-animation-item-icon"
                                    src="https://s3.eu-central-1.amazonaws.com/onefid.content.assets/shared/subCategoryIcons/Icon_envelope.png"
                                    data-v-d4a9e6b5="" style="background-color: rgb(46, 217, 185);">
                                <div class="name-container" data-v-d4a9e6b5="">Email
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                @endif
                @if($item->ph_settings === '1')
                <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="directory"
                    data-v-d4a9e6b5="">
                    <div class="item-container" data-v-d4a9e6b5="">
                        <a href="{{url('ph_settings')}}">
                            <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                                    aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                    data-rbd-drag-handle-draggable-id="directory" data-rbd-drag-handle-context-id="0"
                                    draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
                                <img class="item-icon drag-animation-item-icon"
                                    src="https://img.icons8.com/ios-glyphs/30/000000/settings--v1.png"
                                    data-v-d4a9e6b5="" style="background-color: rgb(225, 48, 113);">
                                <div class="name-container" data-v-d4a9e6b5="">PH Settings
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                @endif
                @if($item->color_settings === '1')
                <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="directory"
                    data-v-d4a9e6b5="">
                    <div class="item-container" data-v-d4a9e6b5="">
                        <a href="{{url('color_settings')}}">
                            <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                                    aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                    data-rbd-drag-handle-draggable-id="directory" data-rbd-drag-handle-context-id="0"
                                    draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
                                <img class="item-icon drag-animation-item-icon"
                                    src="https://img.icons8.com/ios-glyphs/30/000000/settings--v1.png"
                                    data-v-d4a9e6b5="" style="background-color: rgb(225, 48, 113);">
                                <div class="name-container" data-v-d4a9e6b5="">Color Settings
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
        <!--@endif-->
        @endif
        @if($item->basics === '1' || $item->features === '1' || $item->notifications === '1')
        @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['app_settings']) &&
        $permissions['app_settings'] == true)))
        <div class="sidebar-section " data-v-49d408a5="">
            <div class="sidebar-section-inner-container" data-v-49d408a5="">
                <div class="handle-container" data-v-49d408a5=""><img tabindex="0" role="button"
                        aria-describedby="rbd-hidden-text-0-hidden-text-0"
                        data-rbd-drag-handle-draggable-id="aaf40970-be04-44c0-9058-52f535a6ac9f"
                        data-rbd-drag-handle-context-id="0" draggable="false" class="visibility-hidden drag-handle"
                        data-v-49d408a5="">
                    <div class="section-name false" data-v-49d408a5="">App Settings</div>
                </div>
                <div class="flex-row-centered" data-v-49d408a5="">
                    <a type="button" id="app_dropdown" onclick="toggle_sidebar(this)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17">
                            <g fill="none" fill-rule="evenodd" transform="translate(0 .5)">
                                <rect width="15" height="15" x=".5" y=".5" stroke="#AAA" rx="4" />
                                <path fill="#AAA" fill-rule="nonzero"
                                    d="M9.359 11.7L10.177 10.942 7.802 8.506 10.2 6.104 9.359 5.3 6.2 8.494 6.2 8.506z"
                                    transform="rotate(-90 8.2 8.5)" />
                            </g>
                        </svg>
                    </a>
                    <div class="margin-right-15" data-v-49d408a5="">
                        <div class="dropdown-menu-wrapper" data-v-45dae309="">
                            <div class="dropdown-menu-wrapper-toggle" data-v-45dae309="">
                                <div class="toggle-container" data-v-49d408a5=""><img
                                        src="https://img.icons8.com/material-outlined/64/000000/menu-2.png"
                                        class="meatballs-button dropdown-toggle" data-v-49d408a5=""></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="app_dropdown_content" data-rbd-droppable-id="aaf40970-be04-44c0-9058-52f535a6ac9f"
                data-rbd-droppable-context-id="0" data-v-49d408a5="" style="min-height: 1px;">
                @if($item->basics === '1')
                <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="chat"
                    data-v-d4a9e6b5="">
                    <div class="item-container" data-v-d4a9e6b5="">
                        <a href="{{url('basic_setting')}}">
                            <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                                    aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                    data-rbd-drag-handle-draggable-id="chat" data-rbd-drag-handle-context-id="0"
                                    draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
                                <img class="item-icon drag-animation-item-icon"
                                    src="https://img.icons8.com/ios-glyphs/30/000000/settings--v1.png"
                                    data-v-d4a9e6b5="" style="background-color: rgb(46, 217, 185);">
                                <div class="name-container" data-v-d4a9e6b5="">Basics
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                @endif
                @if($item->features === '1')
                <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="messages"
                    data-v-d4a9e6b5="">
                    <div class="item-container" data-v-d4a9e6b5="">
                        <a href="{{url('feature_setting')}}">
                            <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                                    aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                    data-rbd-drag-handle-draggable-id="messages" data-rbd-drag-handle-context-id="0"
                                    draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
                                <img class="item-icon drag-animation-item-icon"
                                    src="https://img.icons8.com/ios-glyphs/30/000000/settings--v1.png"
                                    data-v-d4a9e6b5="" style="background-color: rgb(65, 118, 255);">
                                <div class="name-container" data-v-d4a9e6b5="">Features
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                @endif
                @if($item->notifications === '1')
                <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="directory"
                    data-v-d4a9e6b5="">
                    <div class="item-container" data-v-d4a9e6b5="">
                        <a href="{{url('notification_setting')}}">
                            <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                                    aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                    data-rbd-drag-handle-draggable-id="directory" data-rbd-drag-handle-context-id="0"
                                    draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
                                <img class="item-icon drag-animation-item-icon"
                                    src="https://img.icons8.com/ios-glyphs/30/000000/settings--v1.png"
                                    data-v-d4a9e6b5="" style="background-color: rgb(225, 48, 113);">
                                <div class="name-container" data-v-d4a9e6b5="">Notifications
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                @endif
            </div>
            @endif
            @endif

        </div>
        @if((session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['about_us']) &&
        $permissions['about_us'] == true))) || session()->get('userType')=='customer')
        <div class="static-sidebar-item" data-v-5aa85418="">
            <a href="{{url('about_us')}}">
                <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
                    <div class="image-container" data-v-5aa85418="">
                        <img class="item-icon" data-v-5aa85418=""
                            src="https://img.icons8.com/color/48/000000/dashboard-layout.png" />
                    </div>
                    <span class="item-name" data-v-5aa85418="">Company Docs</span>
                </div>
            </a>
        </div>
        @endif
        {{-- uncomment for notificaitons --}}
        {{-- <div class="static-sidebar-item" data-v-5aa85418="">
       <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
          <div class="d-flex align-items-center mb-2">
             <!--begin::Menu wrapper-->
             <div class="btn btn-icon btn-active-color-primary btn-color-gray-400 btn-active-light" data-kt-menu-trigger="click" data-kt-menu-overflow="true" data-kt-menu-placement="top-start" data-kt-menu-flip="top-end" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click" title="" data-bs-original-title="Notifications">
                <!--begin::Svg Icon | path: icons/duotone/Layout/Layout-4-blocks.svg--><span class="svg-icon svg-icon-2 svg-icon-lg-1">
                   <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                      <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                         <rect x="0" y="0" width="24" height="24"></rect>
                         <rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5"></rect>
                         <path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z" fill="#000000" opacity="0.3"></path>
                     </g>
                 </svg>
             </span>
             <!--end::Svg Icon-->
         </div>
         <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true" style="">
            <!--begin::Heading-->
            <div class="d-flex flex-column bgi-no-repeat rounded-top" style="background-image:url('{{asset('')}}media/misc/dropdown-header-bg.png')">
        <!--begin::Title-->
        <h3 class="text-white fw-bold px-9 mt-10 mb-6">Notifications
            <span class="fs-8 opacity-75 ps-3">24 reports</span></h3>
        <!--end::Title-->
        <!--begin::Tabs-->
        <ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-bold px-9">
            <li class="nav-item"> <a class="nav-link text-white opacity-75 opacity-state-100 pb-4" data-bs-toggle="tab"
                    href="#kt_topbar_notifications_1">Green</a> </li>
            <li class="nav-item"> <a class="nav-link text-white opacity-75 opacity-state-100 pb-4 active"
                    data-bs-toggle="tab" href="#kt_topbar_notifications_2">Welfare</a> </li>
            <li class="nav-item"> <a class="nav-link text-white opacity-75 opacity-state-100 pb-4" data-bs-toggle="tab"
                    href="#kt_topbar_notifications_3">Guard Leave</a> </li>
        </ul>
        <!--end::Tabs-->
    </div>
    <!--end::Heading-->
    <!--begin::Tab content-->
    <div class="tab-content">
        <!--begin::Tab panel-->
        <div class="tab-pane fade" id="kt_topbar_notifications_1" role="tabpanel">
            <!--begin::Items-->
            <div class="scroll-y mh-325px my-5 px-8">
                <!--begin::Item-->
                <div class="d-flex flex-stack py-4">
                    <!--begin::Section-->
                    <div class="d-flex align-items-center">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-35px me-4"> <span class="symbol-label bg-light-primary">
                                <!--begin::Svg Icon | path: icons/duotone/Clothes/Crown.svg-->
                                <span class="svg-icon svg-icon-2 svg-icon-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                        viewBox="0 0 24 24" version="1.1">
                                        <path
                                            d="M11.2600599,5.81393408 L2,16 L22,16 L12.7399401,5.81393408 C12.3684331,5.40527646 11.7359848,5.37515988 11.3273272,5.7466668 C11.3038503,5.7680094 11.2814025,5.79045722 11.2600599,5.81393408 Z"
                                            fill="#000000" opacity="0.3"></path>
                                        <path
                                            d="M12.0056789,15.7116802 L20.2805786,6.85290308 C20.6575758,6.44930487 21.2903735,6.42774054 21.6939717,6.8047378 C21.8964274,6.9938498 22.0113578,7.25847607 22.0113578,7.535517 L22.0113578,20 L16.0113578,20 L2,20 L2,7.535517 C2,7.25847607 2.11493033,6.9938498 2.31738608,6.8047378 C2.72098429,6.42774054 3.35378194,6.44930487 3.7307792,6.85290308 L12.0056789,15.7116802 Z"
                                            fill="#000000"></path>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Title-->
                        <div class="mb-0 me-2"> <a href="#"
                                class="fs-6 text-gray-800 text-hover-primary fw-bolder">Project
                                Alice</a>
                            <div class="text-gray-400 fs-7">Phase 1 development</div>
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Section-->
                    <!--begin::Label--><span class="badge badge-light fs-8">1 hr</span>
                    <!--end::Label-->
                </div>
                <!--end::Item-->
                <!--begin::Item-->
                <div class="d-flex flex-stack py-4">
                    <!--begin::Section-->
                    <div class="d-flex align-items-center">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-35px me-4"> <span class="symbol-label bg-light-danger">
                                <!--begin::Svg Icon | path: icons/duotone/Code/Warning-2.svg-->
                                <span class="svg-icon svg-icon-2 svg-icon-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                        viewBox="0 0 24 24" version="1.1">
                                        <path
                                            d="M11.1669899,4.49941818 L2.82535718,19.5143571 C2.557144,19.9971408 2.7310878,20.6059441 3.21387153,20.8741573 C3.36242953,20.9566895 3.52957021,21 3.69951446,21 L21.2169432,21 C21.7692279,21 22.2169432,20.5522847 22.2169432,20 C22.2169432,19.8159952 22.1661743,19.6355579 22.070225,19.47855 L12.894429,4.4636111 C12.6064401,3.99235656 11.9909517,3.84379039 11.5196972,4.13177928 C11.3723594,4.22181902 11.2508468,4.34847583 11.1669899,4.49941818 Z"
                                            fill="#000000" opacity="0.3"></path>
                                        <rect fill="#000000" x="11" y="9" width="2" height="7" rx="1"></rect>
                                        <rect fill="#000000" x="11" y="17" width="2" height="2" rx="1"></rect>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Title-->
                        <div class="mb-0 me-2"> <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bolder">HR
                                Confidential</a>
                            <div class="text-gray-400 fs-7">Confidential staff documents</div>
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Section-->
                    <!--begin::Label--><span class="badge badge-light fs-8">2 hrs</span>
                    <!--end::Label-->
                </div>
                <!--end::Item-->
                <!--begin::Item-->
                <div class="d-flex flex-stack py-4">
                    <!--begin::Section-->
                    <div class="d-flex align-items-center">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-35px me-4"> <span class="symbol-label bg-light-warning">
                                <!--begin::Svg Icon | path: icons/duotone/Communication/Group.svg-->
                                <span class="svg-icon svg-icon-2 svg-icon-warning">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                        viewBox="0 0 24 24" version="1.1">
                                        <path
                                            d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                                            fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                        <path
                                            d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                                            fill="#000000" fill-rule="nonzero"></path>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Title-->
                        <div class="mb-0 me-2"> <a href="#"
                                class="fs-6 text-gray-800 text-hover-primary fw-bolder">Company
                                HR</a>
                            <div class="text-gray-400 fs-7">Corporeate staff profiles</div>
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Section-->
                    <!--begin::Label--><span class="badge badge-light fs-8">5 hrs</span>
                    <!--end::Label-->
                </div>
                <!--end::Item-->
                <!--begin::Item-->
                <div class="d-flex flex-stack py-4">
                    <!--begin::Section-->
                    <div class="d-flex align-items-center">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-35px me-4"> <span class="symbol-label bg-light-success">
                                <!--begin::Svg Icon | path: icons/duotone/General/Thunder.svg-->
                                <span class="svg-icon svg-icon-2 svg-icon-success">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"></rect>
                                            <path
                                                d="M12.3740377,19.9389434 L18.2226499,11.1660251 C18.4524142,10.8213786 18.3592838,10.3557266 18.0146373,10.1259623 C17.8914367,10.0438285 17.7466809,10 17.5986122,10 L13,10 L13,4.47708173 C13,4.06286817 12.6642136,3.72708173 12.25,3.72708173 C11.9992351,3.72708173 11.7650616,3.85240758 11.6259623,4.06105658 L5.7773501,12.8339749 C5.54758575,13.1786214 5.64071616,13.6442734 5.98536267,13.8740377 C6.10856331,13.9561715 6.25331908,14 6.40138782,14 L11,14 L11,19.5229183 C11,19.9371318 11.3357864,20.2729183 11.75,20.2729183 C12.0007649,20.2729183 12.2349384,20.1475924 12.3740377,19.9389434 Z"
                                                fill="#000000"></path>
                                        </g>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Title-->
                        <div class="mb-0 me-2"> <a href="#"
                                class="fs-6 text-gray-800 text-hover-primary fw-bolder">Project
                                Redux</a>
                            <div class="text-gray-400 fs-7">New frontend admin theme</div>
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Section-->
                    <!--begin::Label--><span class="badge badge-light fs-8">2 days</span>
                    <!--end::Label-->
                </div>
                <!--end::Item-->
                <!--begin::Item-->
                <div class="d-flex flex-stack py-4">
                    <!--begin::Section-->
                    <div class="d-flex align-items-center">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-35px me-4"> <span class="symbol-label bg-light-primary">
                                <!--begin::Svg Icon | path: icons/duotone/Communication/Flag.svg-->
                                <span class="svg-icon svg-icon-2 svg-icon-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                        viewBox="0 0 24 24" version="1.1">
                                        <path
                                            d="M3.5,3 L5,3 L5,19.5 C5,20.3284271 4.32842712,21 3.5,21 L3.5,21 C2.67157288,21 2,20.3284271 2,19.5 L2,4.5 C2,3.67157288 2.67157288,3 3.5,3 Z"
                                            fill="#000000"></path>
                                        <path
                                            d="M6.99987583,2.99995344 L19.754647,2.99999303 C20.3069317,2.99999474 20.7546456,3.44771138 20.7546439,3.99999613 C20.7546431,4.24703684 20.6631995,4.48533385 20.497938,4.66895776 L17.5,8 L20.4979317,11.3310353 C20.8673908,11.7415453 20.8341123,12.3738351 20.4236023,12.7432941 C20.2399776,12.9085564 20.0016794,13 19.7546376,13 L6.99987583,13 L6.99987583,2.99995344 Z"
                                            fill="#000000" opacity="0.3"></path>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Title-->
                        <div class="mb-0 me-2"> <a href="#"
                                class="fs-6 text-gray-800 text-hover-primary fw-bolder">Project
                                Breafing</a>
                            <div class="text-gray-400 fs-7">Product launch status update</div>
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Section-->
                    <!--begin::Label--><span class="badge badge-light fs-8">21 Jan</span>
                    <!--end::Label-->
                </div>
                <!--end::Item-->
                <!--begin::Item-->
                <div class="d-flex flex-stack py-4">
                    <!--begin::Section-->
                    <div class="d-flex align-items-center">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-35px me-4"> <span class="symbol-label bg-light-info">
                                <!--begin::Svg Icon | path: icons/duotone/Design/Image.svg-->
                                <span class="svg-icon svg-icon-2 svg-icon-info">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                        viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                            <path
                                                d="M6,5 L18,5 C19.6568542,5 21,6.34314575 21,8 L21,17 C21,18.6568542 19.6568542,20 18,20 L6,20 C4.34314575,20 3,18.6568542 3,17 L3,8 C3,6.34314575 4.34314575,5 6,5 Z M5,17 L14,17 L9.5,11 L5,17 Z M16,14 C17.6568542,14 19,12.6568542 19,11 C19,9.34314575 17.6568542,8 16,8 C14.3431458,8 13,9.34314575 13,11 C13,12.6568542 14.3431458,14 16,14 Z"
                                                fill="#000000"></path>
                                        </g>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Title-->
                        <div class="mb-0 me-2"> <a href="#"
                                class="fs-6 text-gray-800 text-hover-primary fw-bolder">Banner
                                Assets</a>
                            <div class="text-gray-400 fs-7">Collection of banner images</div>
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Section-->
                    <!--begin::Label--><span class="badge badge-light fs-8">21 Jan</span>
                    <!--end::Label-->
                </div>
                <!--end::Item-->
                <!--begin::Item-->
                <div class="d-flex flex-stack py-4">
                    <!--begin::Section-->
                    <div class="d-flex align-items-center">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-35px me-4"> <span class="symbol-label bg-light-warning">
                                <!--begin::Svg Icon | path: icons/duotone/Design/Component.svg-->
                                <span class="svg-icon svg-icon-2 svg-icon-warning">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                        viewBox="0 0 24 24" version="1.1">
                                        <path
                                            d="M12.7442084,3.27882877 L19.2473374,6.9949025 C19.7146999,7.26196679 20.003129,7.75898194 20.003129,8.29726722 L20.003129,15.7027328 C20.003129,16.2410181 19.7146999,16.7380332 19.2473374,17.0050975 L12.7442084,20.7211712 C12.2830594,20.9846849 11.7169406,20.9846849 11.2557916,20.7211712 L4.75266256,17.0050975 C4.28530007,16.7380332 3.99687097,16.2410181 3.99687097,15.7027328 L3.99687097,8.29726722 C3.99687097,7.75898194 4.28530007,7.26196679 4.75266256,6.9949025 L11.2557916,3.27882877 C11.7169406,3.01531506 12.2830594,3.01531506 12.7442084,3.27882877 Z M12,14.5 C13.3807119,14.5 14.5,13.3807119 14.5,12 C14.5,10.6192881 13.3807119,9.5 12,9.5 C10.6192881,9.5 9.5,10.6192881 9.5,12 C9.5,13.3807119 10.6192881,14.5 12,14.5 Z"
                                            fill="#000000"></path>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Title-->
                        <div class="mb-0 me-2"> <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bolder">Icon
                                Assets</a>
                            <div class="text-gray-400 fs-7">Collection of SVG icons</div>
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Section-->
                    <!--begin::Label--><span class="badge badge-light fs-8">20 March</span>
                    <!--end::Label-->
                </div>
                <!--end::Item-->
            </div>
            <!--end::Items-->
            <!--begin::View more-->
            <div class="py-3 text-center border-top"> <a href="pages/profile/activity.html"
                    class="btn btn-color-gray-600 btn-active-color-primary">View All
                    <!--begin::Svg Icon | path: icons/duotone/Navigation/Right-2.svg-->
                    <span class="svg-icon svg-icon-5">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                <rect fill="#000000" opacity="0.5"
                                    transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000)"
                                    x="7.5" y="7.5" width="2" height="9" rx="1"></rect>
                                <path
                                    d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z"
                                    fill="#000000" fill-rule="nonzero"
                                    transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)">
                                </path>
                            </g>
                        </svg>
                    </span>
                    <!--end::Svg Icon--></a> </div>
            <!--end::View more-->
        </div>
        <!--end::Tab panel-->
        <!--begin::Tab panel-->
        <div class="tab-pane fade show active" id="kt_topbar_notifications_2" role="tabpanel">
            <!--begin::Wrapper-->
            <div class="d-flex flex-column px-9">
                <!--begin::Section-->
                <div class="pt-10 pb-0">
                    <!--begin::Title-->
                    <h3 class="text-dark text-center fw-bolder">Get Pro Access</h3>
                    <!--end::Title-->
                    <!--begin::Text-->
                    <div class="text-center text-gray-600 fw-bold pt-1">Outlines keep you honest. They stoping you from
                        amazing poorly about drive</div>
                    <!--end::Text-->
                    <!--begin::Action-->
                    <div class="text-center mt-5 mb-9"> <a href="#" class="btn btn-sm btn-primary px-6"
                            data-bs-toggle="modal" data-bs-target="#kt_modal_upgrade_plan">Upgrade</a> </div>
                    <!--end::Action-->
                </div>
                <!--end::Section-->
                <!--begin::Illustration-->
                <div class="text-center px-4"> <img class="mw-100 mh-200px" alt="metronic"
                        src="{{asset('')}}media/illustrations/work.png"> </div>
                <!--end::Illustration-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Tab panel-->
        <!--begin::Tab panel-->
        <div class="tab-pane fade" id="kt_topbar_notifications_3" role="tabpanel">
            <!--begin::Items-->
            <div class="scroll-y mh-325px my-5 px-8">
                <!--begin::Item-->
                <div class="d-flex flex-stack py-4">
                    <!--begin::Section-->
                    <div class="d-flex align-items-center me-2">
                        <!--begin::Code--><span class="w-70px badge badge-light-success me-4">200 OK</span>
                        <!--end::Code-->
                        <!--begin::Title--><a href="#" class="text-gray-800 text-hover-primary fw-bold">New order</a>
                        <!--end::Title-->
                    </div>
                    <!--end::Section-->
                    <!--begin::Label--><span class="badge badge-light fs-8">Just now</span>
                    <!--end::Label-->
                </div>
                <!--end::Item-->
                <!--begin::Item-->
                <div class="d-flex flex-stack py-4">
                    <!--begin::Section-->
                    <div class="d-flex align-items-center me-2">
                        <!--begin::Code--><span class="w-70px badge badge-light-danger me-4">500 ERR</span>
                        <!--end::Code-->
                        <!--begin::Title--><a href="#" class="text-gray-800 text-hover-primary fw-bold">New customer</a>
                        <!--end::Title-->
                    </div>
                    <!--end::Section-->
                    <!--begin::Label--><span class="badge badge-light fs-8">2 hrs</span>
                    <!--end::Label-->
                </div>
                <!--end::Item-->
                <!--begin::Item-->
                <div class="d-flex flex-stack py-4">
                    <!--begin::Section-->
                    <div class="d-flex align-items-center me-2">
                        <!--begin::Code--><span class="w-70px badge badge-light-success me-4">200 OK</span>
                        <!--end::Code-->
                        <!--begin::Title--><a href="#" class="text-gray-800 text-hover-primary fw-bold">Payment
                            process</a>
                        <!--end::Title-->
                    </div>
                    <!--end::Section-->
                    <!--begin::Label--><span class="badge badge-light fs-8">5 hrs</span>
                    <!--end::Label-->
                </div>
                <!--end::Item-->
                <!--begin::Item-->
                <div class="d-flex flex-stack py-4">
                    <!--begin::Section-->
                    <div class="d-flex align-items-center me-2">
                        <!--begin::Code--><span class="w-70px badge badge-light-warning me-4">300 WRN</span>
                        <!--end::Code-->
                        <!--begin::Title--><a href="#" class="text-gray-800 text-hover-primary fw-bold">Search query</a>
                        <!--end::Title-->
                    </div>
                    <!--end::Section-->
                    <!--begin::Label--><span class="badge badge-light fs-8">2 days</span>
                    <!--end::Label-->
                </div>
                <!--end::Item-->
                <!--begin::Item-->
                <div class="d-flex flex-stack py-4">
                    <!--begin::Section-->
                    <div class="d-flex align-items-center me-2">
                        <!--begin::Code--><span class="w-70px badge badge-light-success me-4">200 OK</span>
                        <!--end::Code-->
                        <!--begin::Title--><a href="#" class="text-gray-800 text-hover-primary fw-bold">API
                            connection</a>
                        <!--end::Title-->
                    </div>
                    <!--end::Section-->
                    <!--begin::Label--><span class="badge badge-light fs-8">1 week</span>
                    <!--end::Label-->
                </div>
                <!--end::Item-->
                <!--begin::Item-->
                <div class="d-flex flex-stack py-4">
                    <!--begin::Section-->
                    <div class="d-flex align-items-center me-2">
                        <!--begin::Code--><span class="w-70px badge badge-light-success me-4">200 OK</span>
                        <!--end::Code-->
                        <!--begin::Title--><a href="#" class="text-gray-800 text-hover-primary fw-bold">Database
                            restore</a>
                        <!--end::Title-->
                    </div>
                    <!--end::Section-->
                    <!--begin::Label--><span class="badge badge-light fs-8">Mar 5</span>
                    <!--end::Label-->
                </div>
                <!--end::Item-->
                <!--begin::Item-->
                <div class="d-flex flex-stack py-4">
                    <!--begin::Section-->
                    <div class="d-flex align-items-center me-2">
                        <!--begin::Code--><span class="w-70px badge badge-light-warning me-4">300 WRN</span>
                        <!--end::Code-->
                        <!--begin::Title--><a href="#" class="text-gray-800 text-hover-primary fw-bold">System
                            update</a>
                        <!--end::Title-->
                    </div>
                    <!--end::Section-->
                    <!--begin::Label--><span class="badge badge-light fs-8">May 15</span>
                    <!--end::Label-->
                </div>
                <!--end::Item-->
                <!--begin::Item-->
                <div class="d-flex flex-stack py-4">
                    <!--begin::Section-->
                    <div class="d-flex align-items-center me-2">
                        <!--begin::Code--><span class="w-70px badge badge-light-warning me-4">300 WRN</span>
                        <!--end::Code-->
                        <!--begin::Title--><a href="#" class="text-gray-800 text-hover-primary fw-bold">Server OS
                            update</a>
                        <!--end::Title-->
                    </div>
                    <!--end::Section-->
                    <!--begin::Label--><span class="badge badge-light fs-8">Apr 3</span>
                    <!--end::Label-->
                </div>
                <!--end::Item-->
                <!--begin::Item-->
                <div class="d-flex flex-stack py-4">
                    <!--begin::Section-->
                    <div class="d-flex align-items-center me-2">
                        <!--begin::Code--><span class="w-70px badge badge-light-warning me-4">300 WRN</span>
                        <!--end::Code-->
                        <!--begin::Title--><a href="#" class="text-gray-800 text-hover-primary fw-bold">API rollback</a>
                        <!--end::Title-->
                    </div>
                    <!--end::Section-->
                    <!--begin::Label--><span class="badge badge-light fs-8">Jun 30</span>
                    <!--end::Label-->
                </div>
                <!--end::Item-->
                <!--begin::Item-->
                <div class="d-flex flex-stack py-4">
                    <!--begin::Section-->
                    <div class="d-flex align-items-center me-2">
                        <!--begin::Code--><span class="w-70px badge badge-light-danger me-4">500 ERR</span>
                        <!--end::Code-->
                        <!--begin::Title--><a href="#" class="text-gray-800 text-hover-primary fw-bold">Refund
                            process</a>
                        <!--end::Title-->
                    </div>
                    <!--end::Section-->
                    <!--begin::Label--><span class="badge badge-light fs-8">Jul 10</span>
                    <!--end::Label-->
                </div>
                <!--end::Item-->
                <!--begin::Item-->
                <div class="d-flex flex-stack py-4">
                    <!--begin::Section-->
                    <div class="d-flex align-items-center me-2">
                        <!--begin::Code--><span class="w-70px badge badge-light-danger me-4">500 ERR</span>
                        <!--end::Code-->
                        <!--begin::Title--><a href="#" class="text-gray-800 text-hover-primary fw-bold">Withdrawal
                            process</a>
                        <!--end::Title-->
                    </div>
                    <!--end::Section-->
                    <!--begin::Label--><span class="badge badge-light fs-8">Sep 10</span>
                    <!--end::Label-->
                </div>
                <!--end::Item-->
                <!--begin::Item-->
                <div class="d-flex flex-stack py-4">
                    <!--begin::Section-->
                    <div class="d-flex align-items-center me-2">
                        <!--begin::Code--><span class="w-70px badge badge-light-danger me-4">500 ERR</span>
                        <!--end::Code-->
                        <!--begin::Title--><a href="#" class="text-gray-800 text-hover-primary fw-bold">Mail tasks</a>
                        <!--end::Title-->
                    </div>
                    <!--end::Section-->
                    <!--begin::Label--><span class="badge badge-light fs-8">Dec 10</span>
                    <!--end::Label-->
                </div>
                <!--end::Item-->
            </div>
            <!--end::Items-->
            <!--begin::View more-->
            <div class="py-3 text-center border-top"> <a href="pages/profile/activity.html"
                    class="btn btn-color-gray-600 btn-active-color-primary">View All
                    <!--begin::Svg Icon | path: icons/duotone/Navigation/Right-2.svg-->
                    <span class="svg-icon svg-icon-5">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                <rect fill="#000000" opacity="0.5"
                                    transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000)"
                                    x="7.5" y="7.5" width="2" height="9" rx="1"></rect>
                                <path
                                    d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z"
                                    fill="#000000" fill-rule="nonzero"
                                    transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)">
                                </path>
                            </g>
                        </svg>
                    </span>
                    <!--end::Svg Icon--></a> </div>
            <!--end::View more-->
        </div>
        <!--end::Tab panel-->
    </div>
    <!--end::Tab content-->
</div>
<!--begin::Menu-->
<!--end::Menu-->
<!--end::Menu wrapper-->
</div>
</div>
<div class="sidebar-badge-container" data-v-5aa85418=""></div>
</div> --}}




<div class="flex-row-centered add-new-feature">
    <div class=""> </div>
</div>
</div>
@endif
</div>

</div>
</div>
@endforeach
@else
{{-- @dd('here else'); --}}
<div class="margin-top-10 margin-bottom-10 ">

    @if(session()->get('userType') == 'admin' || session()->get('userType') == 'customer')
    <div class="static-sidebar-item" data-v-5aa85418="">
        <a href="{{url('dashboard')}}">
            <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
                <div class="image-container" data-v-5aa85418="">
                    <img class="item-icon" data-v-5aa85418=""
                        src="https://img.icons8.com/color/48/000000/dashboard-layout.png" />
                </div>
                <span class="item-name" data-v-5aa85418="">Dashboard</span>
            </div>
        </a>
    </div>
    @endif
    @if(session()->get('userType') == 'admin' && $is_super_admin == 1)
    @if(config('custom.authenticator') == 1)
    <div class="static-sidebar-item" data-v-5aa85418="">
        <a href="{{url('authenticationQr')}}">
            <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
                <div class="image-container" data-v-5aa85418="">
                    <img class="item-icon" data-v-5aa85418=""
                        src="https://img.icons8.com/color/48/000000/dashboard-layout.png" />
                </div>
                <span class="item-name" data-v-5aa85418="">Authenticator</span>
            </div>
        </a>
    </div>
    @endif
    @endif
    @if((session()->get('userType') == 'admin' && ($is_super_admin == 1 || (isset($permissions['job_roster']) &&
    $permissions['job_roster'] == true))) || session()->get('userType') == 'customer')
    <div class="static-sidebar-item" data-v-5aa85418="">
        <a href="{{url('job_roster')}}">
            <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
                <div class="image-container" data-v-5aa85418="">

                    <img src="https://img.icons8.com/color/20/000000/calendar.png" /></div><span class="item-name"
                    data-v-5aa85418="">Job Roster</span>
            </div>
            <div class="sidebar-badge-container" data-v-5aa85418=""></div>
        </a>
    </div>
    @endif


    @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['timesheet']) &&
    $permissions['timesheet'] == true)))
    <div class="static-sidebar-item" data-v-5aa85418="">
        <a href="{{url('guard_timesheet')}}">
            <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
                <div class="image-container" data-v-5aa85418="">
                    <img src="https://img.icons8.com/ultraviolet/20/000000/property-time.png" /></div><span
                    class="item-name" data-v-5aa85418="">TimeSheet</span>
            </div>
            <div class="sidebar-badge-container" data-v-5aa85418=""></div>
        </a>
    </div>
    @endif
    @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['job_tracker']) &&
    $permissions['job_tracker'] == true)))
    <div class="static-sidebar-item" data-v-5aa85418="">
        <a href="{{url('job_tracker')}}">
            <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
                <div class="image-container" data-v-5aa85418="">
                    <img class="item-icon" data-v-5aa85418=""
                        src="https://img.icons8.com/fluency/48/000000/shortlist.png" />
                </div>
                <span class="item-name" data-v-5aa85418="">Job Tracker</span>
            </div>
            <div class="sidebar-badge-container" data-v-5aa85418=""></div>
        </a>
    </div>
    @endif
    @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['leave_management']) &&
    $permissions['leave_management'] == true)))
    <div class="static-sidebar-item" data-v-5aa85418="">
        <a href="{{url('guard/activeGuardLeaveManagement')}}">
            <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
                <div class="image-container" data-v-5aa85418="">
                    <img class="item-icon" data-v-5aa85418=""
                        src="https://img.icons8.com/fluency/48/000000/shortlist.png" />
                </div>
                <span class="item-name" data-v-5aa85418="">Leave Management</span>
            </div>
            <div class="sidebar-badge-container" data-v-5aa85418=""></div>
        </a>
    </div>
    @endif
    {{-- waqas start working --}}
    @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['leave_management']) &&
    $permissions['leave_management'] == true)))
    <div class="static-sidebar-item" data-v-5aa85418="">
        <a href="{{url('guard/guardLicenseFind')}}">
            <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
                <div class="image-container" data-v-5aa85418="">
                    <img class="item-icon" data-v-5aa85418=""
                        src="https://img.icons8.com/fluency/48/000000/shortlist.png" />
                </div>
                <span class="item-name" data-v-5aa85418="">{{config('custom.guard')}} License</span>
            </div>
            <div class="sidebar-badge-container" data-v-5aa85418=""></div>
        </a>
    </div>
    @endif
    {{-- waqas ending working --}}
    @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['time_clock']) &&
    $permissions['time_clock'] == true)))
    <div class="static-sidebar-item" data-v-5aa85418="">
        <a href="{{url('timeclock?status=today')}}">
            <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
                <div class="image-container" data-v-5aa85418="">
                    <img class="item-icon" data-v-5aa85418=""
                        src="https://img.icons8.com/fluency/48/000000/shortlist.png" /></div><span class="item-name"
                    data-v-5aa85418="">Time Clock</span>
            </div>
            <div class="sidebar-badge-container" data-v-5aa85418=""></div>
        </a>
    </div>
    @endif
    @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['staff_audit']) &&
    $permissions['staff_audit'] == true)))
    <div class="static-sidebar-item" data-v-5aa85418="">
        <a type="button" href="{{url('user_activity_log')}}" class="btn-default" data-kt-menu-trigger="click"
            data-kt-menu-overflow="true" data-kt-menu-placement="top-start" data-kt-menu-flip="top-end">
            <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
                <div class="image-container" data-v-5aa85418="">
                    <img class="item-icon" data-v-5aa85418=""
                        src="https://img.icons8.com/fluency/48/000000/shortlist.png" /></div><span class="item-name"
                    data-v-5aa85418="">Log User Activities</span>
            </div>
            <div class="sidebar-badge-container" data-v-5aa85418=""></div>
        </a>
    </div>
    <!-- <div class="static-sidebar-item" data-v-5aa85418="">
                    <a type="button" onclick="fetch_activity_log()" class="btn-default"  data-kt-menu-trigger="click" data-kt-menu-overflow="true" data-kt-menu-placement="top-start" data-kt-menu-flip="top-end" id="kt_activities_toggle" >
                        <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
                            <div class="image-container" data-v-5aa85418="">
                                <img class="item-icon" data-v-5aa85418=""
                                src="https://img.icons8.com/fluency/48/000000/shortlist.png" /></div><span
                                class="item-name" data-v-5aa85418="">Log User Activities</span>
                            </div>
                            <div class="sidebar-badge-container" data-v-5aa85418=""></div>
                        </a>
                    </div> -->
    @endif
    @if(session()->get('userType')=='admin' || $is_super_admin == 1)
    <div class="static-sidebar-item" data-v-5aa85418="">
        <a type="button" href="{{url('site_list')}}" class="btn-default" data-kt-menu-trigger="click"
            data-kt-menu-overflow="true" data-kt-menu-placement="top-start" data-kt-menu-flip="top-end">
            <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
                <div class="image-container" data-v-5aa85418="">
                    <img class="item-icon" data-v-5aa85418=""
                        src="https://img.icons8.com/fluency/48/000000/shortlist.png" /></div><span class="item-name"
                    data-v-5aa85418="">Site List</span>
            </div>
            <div class="sidebar-badge-container" data-v-5aa85418=""></div>
        </a>
    </div>
    @endif
    @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['administrator']) &&
    $permissions['administrator'] == true)))
    <div class="static-sidebar-item" data-v-5aa85418="">
        <a type="button" href="{{url('app_status')}}" class="btn-default" data-kt-menu-trigger="click"
            data-kt-menu-overflow="true" data-kt-menu-placement="top-start" data-kt-menu-flip="top-end">
            <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
                <div class="image-container" data-v-5aa85418="">
                    <img class="item-icon" data-v-5aa85418=""
                        src="https://img.icons8.com/fluency/48/000000/shortlist.png" /></div><span class="item-name"
                    data-v-5aa85418="">App Status</span>
            </div>
            <div class="sidebar-badge-container" data-v-5aa85418=""></div>
        </a>
    </div>
    <!--  <div class="static-sidebar-item" data-v-5aa85418="">
            <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
                <div class="image-container" data-v-5aa85418="">
                    <div    data-kt-menu-trigger="click" data-kt-menu-overflow="true" data-kt-menu-placement="top-start" data-kt-menu-flip="top-end" id="kt_activities_toggle">
                        <button class=" btn btn-icon btn-active-color-primary btn-color-gray-400 btn-active-light" onclick="fetch_activity_log()">
                          
                        </button>
                </div>
            </div>
                
            </div>
            <div class="sidebar-badge-container" data-v-5aa85418=""></div>
        </div>  -->
    @endif
    @if(session()->get('userType')=='guard')
    <div class="static-sidebar-item" data-v-5aa85418="">
        <a href="{{url('edit_guard').'/'.session()->get('userId')}}">
            <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
                <div class="image-container" data-v-5aa85418="">
                    <img class="item-icon" data-v-5aa85418=""
                        src="https://img.icons8.com/fluency/48/000000/shortlist.png" /></div>
                <span class="item-name" data-v-5aa85418="">Profile Setting</span>
            </div>
            <div class="sidebar-badge-container" data-v-5aa85418=""></div>
        </a>
    </div>
    @endif

    <!--  <div class="static-sidebar-item" data-v-5aa85418="">
            <a href="{{url('access')}}">
                <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
                    <div class="image-container" data-v-5aa85418="">
                        <img class="item-icon" data-v-5aa85418=""
            src="https://img.icons8.com/ios-filled/48/000000/user-rights.png" />
    </div><span class="item-name" data-v-5aa85418="">Permissions</span>
</div>
<div class="sidebar-badge-container" data-v-5aa85418=""></div>
</a>
</div> -->

</div>
</div>
<div>
    @if(session()->get('userType') == 'admin')
    <div data-rbd-droppable-context-id="0">
        <div id="aaf40970-be04-44c0-9058-52f535a6ac9f" data-v-49d408a5="">
            <!-- <div data-rbd-draggable-context-id="0" data-rbd-draggable-id="aaf40970-be04-44c0-9058-52f535a6ac9f" data-v-49d408a5="">  -->
            <div class="sidebar-section " data-v-49d408a5="" style="height: ;">
                <div class="sidebar-section-inner-container" data-v-49d408a5="">
                    <div class="handle-container" data-v-49d408a5=""><img tabindex="0" role="button"
                            aria-describedby="rbd-hidden-text-0-hidden-text-0"
                            data-rbd-drag-handle-draggable-id="aaf40970-be04-44c0-9058-52f535a6ac9f"
                            data-rbd-drag-handle-context-id="0" draggable="false" class="visibility-hidden drag-handle"
                            data-v-49d408a5="">
                        <div class="section-name false" data-v-49d408a5="">Users</div>
                    </div>
                    <div class="flex-row-centered" data-v-49d408a5="">
                        <a type="button" id="users_dropdown" onclick="toggle_sidebar(this)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17">
                                <g fill="none" fill-rule="evenodd" transform="translate(0 .5)">
                                    <rect width="15" height="15" x=".5" y=".5" stroke="#AAA" rx="4" />
                                    <path fill="#AAA" fill-rule="nonzero"
                                        d="M9.359 11.7L10.177 10.942 7.802 8.506 10.2 6.104 9.359 5.3 6.2 8.494 6.2 8.506z"
                                        transform="rotate(-90 8.2 8.5)" />
                                </g>
                            </svg>
                        </a>
                        <div class="margin-right-15" data-v-49d408a5="">
                            <div class="dropdown-menu-wrapper" data-v-45dae309="">
                                <div class="dropdown-menu-wrapper-toggle" data-v-45dae309="">
                                    <div class="toggle-container" data-v-49d408a5="">
                                        <img src="https://img.icons8.com/material-outlined/64/000000/menu-2.png"
                                            class="meatballs-button dropdown-toggle" data-v-49d408a5="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                @if(session()->get('userType') == 'admin' && ($is_super_admin == 1 ||
                (isset($permissions['administrator']) && $permissions['administrator'] == true)))
                <div id="users_dropdown_content" data-rbd-droppable-id="aaf40970-be04-44c0-9058-52f535a6ac9f"
                    data-rbd-droppable-context-id="0" data-v-49d408a5="" style="min-height: 1px;">
                    <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="chat"
                        data-v-d4a9e6b5="">
                        <div class="item-container" data-v-d4a9e6b5="">
                            <a href="{{url('administrators')}}">
                                <div class="item-inner-container" data-v-d4a9e6b5="">
                                    <img tabindex="0" role="button" aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                        data-rbd-drag-handle-draggable-id="chat" data-rbd-drag-handle-context-id="0"
                                        draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
                                    <img class="item-icon drag-animation-item-icon"
                                        src="https://img.icons8.com/ios/30/000000/user-male-circle.png"
                                        data-v-d4a9e6b5="" style="background-color: rgb(46, 217, 185);">
                                    <div class="name-container" data-v-d4a9e6b5="">Administrator</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                @endif
                @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['customer']) &&
                $permissions['customer'] == true)))
                <div class="sidebar-item" data-rbd-draggable-context-id="0" data-rbd-draggable-id="messages"
                    data-v-d4a9e6b5="">
                    <div class="item-container" data-v-d4a9e6b5="">
                        <a href="{{url('customers')}}">
                            <div class="item-inner-container" data-v-d4a9e6b5="">
                                <img tabindex="0" role="button" aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                    data-rbd-drag-handle-draggable-id="messages" data-rbd-drag-handle-context-id="0"
                                    draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
                                <img class="item-icon drag-animation-item-icon"
                                    src="https://img.icons8.com/ios/30/000000/user-male-circle.png" data-v-d4a9e6b5=""
                                    style="background-color: rgb(65, 118, 255);">
                                <div class="name-container" data-v-d4a9e6b5=""> Customer </div>
                            </div>
                        </a>
                    </div>
                </div>

                @endif
                @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['contractor'])
                && $permissions['contractor'] == true)))
                <div class="sidebar-item" data-rbd-draggable-context-id="0" data-rbd-draggable-id="directory"
                    data-v-d4a9e6b5="">
                    <div class="item-container" data-v-d4a9e6b5="">
                        <a href="{{url('contractors')}}">
                            <div class="item-inner-container" data-v-d4a9e6b5="">
                                <img tabindex="0" role="button" aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                    data-rbd-drag-handle-draggable-id="directory" data-rbd-drag-handle-context-id="0"
                                    draggable="false" class="drag-handle" data-v-d4a9e6b5="">
                                <img class="item-icon drag-animation-item-icon"
                                    src="https://img.icons8.com/ios/30/000000/user-male-circle.png" data-v-d4a9e6b5=""
                                    style="background-color: rgb(225, 48, 113);">
                                <div class="name-container" data-v-d4a9e6b5="">Contractor </div>
                            </div>
                        </a>
                    </div>
                </div>
                @endif
                @endif
                @if((session()->get('userType') == 'admin' && ($is_super_admin == 1 || (isset($permissions['guard']) &&
                $permissions['guard'] == true))) || session()->get('userType') == 'customer')
                <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="directory"
                    data-v-d4a9e6b5="">
                    <div class="item-container" data-v-d4a9e6b5="">
                        <a href="{{url('guards/?status=active')}}">
                            <div class="item-inner-container" data-v-d4a9e6b5="">
                                <img tabindex="0" role="button" aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                    data-rbd-drag-handle-draggable-id="directory" data-rbd-drag-handle-context-id="0"
                                    draggable="false" class="drag-handle" data-v-d4a9e6b5="">
                                <img class="item-icon drag-animation-item-icon"
                                    src="https://img.icons8.com/ios/30/000000/user-male-circle.png" data-v-d4a9e6b5=""
                                    style="background-color: rgb(46, 217, 185);">
                                <div class="name-container" data-v-d4a9e6b5="">{{config('custom.guard')}}</div>
                            </div>
                        </a>
                    </div>
                </div>
                @endif
                @if(session()->get('userType') == 'admin' && $is_super_admin == 1)
                <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="directory"
                    data-v-d4a9e6b5="">
                    <div class="item-container" data-v-d4a9e6b5="">
                        <a href="{{url('access')}}">
                            <div class="item-inner-container" data-v-d4a9e6b5="">
                                <img tabindex="0" role="button" aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                    data-rbd-drag-handle-draggable-id="directory" data-rbd-drag-handle-context-id="0"
                                    draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
                                <img class="item-icon drag-animation-item-icon" data-v-d4a9e6b5=""
                                    style="background-color: rgb(46, 217, 185);"
                                    src="https://img.icons8.com/ios-filled/48/000000/user-rights.png" /><span
                                    class="item-name" style="margin-left:2px" data-v-5aa85418="">Permissions</span>
                            </div>
                        </a>
                    </div>
                </div>
                @endif

                <!--  {{-- </div> --}} -->
                @if(session()->get('userType') == 'customer')
                <div class="static-sidebar-item" data-v-5aa85418="">
                    <a href="{{url('about_us')}}">
                        <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
                            <div class="image-container" data-v-5aa85418="">
                                <img class="item-icon" data-v-5aa85418=""
                                    src="https://img.icons8.com/color/48/000000/dashboard-layout.png" />
                            </div>
                            <span class="item-name" data-v-5aa85418="">Company Docs</span>
                        </div>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
    <!-- {{-- </div> --}} -->
    @if(session()->get('userType') == 'admin')
    @if(session()->get('userType')=='admin')
    <div class="sidebar-section " data-v-49d408a5="" style="height: ;">
        <div class="sidebar-section-inner-container" data-v-49d408a5="">
            <div class="handle-container" data-v-49d408a5=""><img tabindex="0" role="button"
                    aria-describedby="rbd-hidden-text-0-hidden-text-0"
                    data-rbd-drag-handle-draggable-id="aaf40970-be04-44c0-9058-52f535a6ac9f"
                    data-rbd-drag-handle-context-id="0" draggable="false" class="visibility-hidden drag-handle"
                    data-v-49d408a5="">
                <div class="section-name false" data-v-49d408a5="">Communication</div>
            </div>
            <div class="flex-row-centered" data-v-49d408a5="">
                <a type="button" id="communication_dropdown" onclick="toggle_sidebar(this)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17">
                        <g fill="none" fill-rule="evenodd" transform="translate(0 .5)">
                            <rect width="15" height="15" x=".5" y=".5" stroke="#AAA" rx="4" />
                            <path fill="#AAA" fill-rule="nonzero"
                                d="M9.359 11.7L10.177 10.942 7.802 8.506 10.2 6.104 9.359 5.3 6.2 8.494 6.2 8.506z"
                                transform="rotate(-90 8.2 8.5)" />
                        </g>
                    </svg>
                </a>
                <div class="margin-right-15" data-v-49d408a5="">
                    <div class="dropdown-menu-wrapper" data-v-45dae309="">
                        <div class="dropdown-menu-wrapper-toggle" data-v-45dae309="">
                            <div class="toggle-container" data-v-49d408a5=""><img
                                    src="https://img.icons8.com/material-outlined/64/000000/menu-2.png"
                                    class="meatballs-button dropdown-toggle" data-v-49d408a5="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['communication']) &&
        $permissions['communication'] == true)))
        <div id="communication_dropdown_content" data-rbd-droppable-id="aaf40970-be04-44c0-9058-52f535a6ac9f"
            data-rbd-droppable-context-id="0" data-v-49d408a5="" style="min-height: 1px;">
            <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="chat"
                data-v-d4a9e6b5="">
                <div class="item-container" data-v-d4a9e6b5="">
                    <a href="{{url('chat')}}">
                        <div class="item-inner-container" data-v-d4a9e6b5="">
                            <img tabindex="0" role="button" aria-describedby="rbd-hidden-text-0-hidden-text-0"
                                data-rbd-drag-handle-draggable-id="chat" data-rbd-drag-handle-context-id="0"
                                draggable="false" class="drag-handle" data-v-d4a9e6b5="">
                            <img class="item-icon drag-animation-item-icon"
                                src="https://s3.eu-central-1.amazonaws.com/onefid.content.assets/shared/subCategoryIcons/Icon_chat.png"
                                data-v-d4a9e6b5="" style="background-color: rgb(46, 217, 185);">
                            <div class="name-container" data-v-d4a9e6b5="">Chat</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        @endif
        <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="messages"
            data-v-d4a9e6b5="">
            <div class="item-container" data-v-d4a9e6b5="">
                <a href="{{url('announcements/new')}}">
                    <div class="item-inner-container" data-v-d4a9e6b5="">
                        <img tabindex="0" role="button" aria-describedby="rbd-hidden-text-0-hidden-text-0"
                            data-rbd-drag-handle-draggable-id="messages" data-rbd-drag-handle-context-id="0"
                            draggable="false" class="drag-handle" data-v-d4a9e6b5="">
                        <img class="item-icon drag-animation-item-icon"
                            src="https://s3.eu-central-1.amazonaws.com/onefid.content.assets/shared/subCategoryIcons/Icon_envelope.png"
                            data-v-d4a9e6b5="" style="background-color: rgb(65, 118, 255);">
                        <div class="name-container" data-v-d4a9e6b5="">Announcements | Induction</div>
                    </div>
                </a>
            </div>
        </div>
        @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['announcements']) &&
        $permissions['announcements'] == true)))
        <!--  <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="messages" data-v-d4a9e6b5="">
        <div class="item-container" data-v-d4a9e6b5="">
            <a href="{{url('announcements/inductions')}}">
            <div class="item-inner-container" data-v-d4a9e6b5="">
                <img tabindex="0" role="button" aria-describedby="rbd-hidden-text-0-hidden-text-0"data-rbd-drag-handle-draggable-id="messages" data-rbd-drag-handle-context-id="0" draggable="false" class="drag-handle" data-v-d4a9e6b5="">
                <img class="item-icon drag-animation-item-icon" src="https://s3.eu-central-1.amazonaws.com/onefid.content.assets/shared/subCategoryIcons/Icon_envelope.png" data-v-d4a9e6b5="" style="background-color: rgb(65, 118, 255);">
                    <div class="name-container" data-v-d4a9e6b5="">Announcements </div>
            </div>
            </a>
        </div>
    </div> -->
        @endif

        @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['tutorial']) &&
        $permissions['tutorial'] == true)))
        <!-- <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="directory" data-v-d4a9e6b5="">
        <div class="item-container" data-v-d4a9e6b5="">
            <a href="{{url('inductions')}}">
            <div class="item-inner-container" data-v-d4a9e6b5="">
                <img tabindex="0" role="button" aria-describedby="rbd-hidden-text-0-hidden-text-0" data-rbd-drag-handle-draggable-id="directory" data-rbd-drag-handle-context-id="0" draggable="false" class="drag-handle" data-v-d4a9e6b5="">
                <img class="item-icon drag-animation-item-icon" src="https://s3.eu-central-1.amazonaws.com/onefid.content.assets/shared/subCategoryIcons/Icon_Directory.png" data-v-d4a9e6b5="" style="background-color: rgb(225, 48, 113);">
                    <div class="name-container" data-v-d4a9e6b5="">Induction</div>
            </div>
            </a>
        </div>
    </div> -->
        @endif
    </div>
    <!-- </div> -->
    @endif
    @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['reports']) &&
    $permissions['reports'] == true)))
    <div class="sidebar-section " data-v-49d408a5="" style="height: ;">
        <div class="sidebar-section-inner-container" data-v-49d408a5="">
            <div class="handle-container" data-v-49d408a5=""><img tabindex="0" role="button"
                    aria-describedby="rbd-hidden-text-0-hidden-text-0"
                    data-rbd-drag-handle-draggable-id="aaf40970-be04-44c0-9058-52f535a6ac9f"
                    data-rbd-drag-handle-context-id="0" draggable="false" class="visibility-hidden drag-handle"
                    data-v-49d408a5="">
                <div class="section-name false" data-v-49d408a5="">Reports</div>
            </div>
            <div class="flex-row-centered" data-v-49d408a5="">
                <a type="button" id="reports_dropdown" onclick="toggle_sidebar(this)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17">
                        <g fill="none" fill-rule="evenodd" transform="translate(0 .5)">
                            <rect width="15" height="15" x=".5" y=".5" stroke="#AAA" rx="4" />
                            <path fill="#AAA" fill-rule="nonzero"
                                d="M9.359 11.7L10.177 10.942 7.802 8.506 10.2 6.104 9.359 5.3 6.2 8.494 6.2 8.506z"
                                transform="rotate(-90 8.2 8.5)" />
                        </g>
                    </svg>
                </a>
                <div class="margin-right-15" data-v-49d408a5="">
                    <div class="dropdown-menu-wrapper" data-v-45dae309="">
                        <div class="dropdown-menu-wrapper-toggle" data-v-45dae309="">
                            <div class="toggle-container" data-v-49d408a5=""><img
                                    src="https://img.icons8.com/material-outlined/64/000000/menu-2.png"
                                    class="meatballs-button dropdown-toggle" data-v-49d408a5=""></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['task_report']) &&
        $permissions['task_report'] == true)))

        <div id="reports_dropdown_content" data-rbd-droppable-id="aaf40970-be04-44c0-9058-52f535a6ac9f"
            data-rbd-droppable-context-id="0" data-v-49d408a5="" style="min-height: 1px;">
            <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="chat"
                data-v-d4a9e6b5="">
                <div class="item-container" data-v-d4a9e6b5="">
                    <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                            aria-describedby="rbd-hidden-text-0-hidden-text-0" data-rbd-drag-handle-draggable-id="chat"
                            data-rbd-drag-handle-context-id="0" draggable="false" class="  drag-handle"
                            data-v-d4a9e6b5="">
                        <a href="{{url('task_report')}}"><img class="item-icon drag-animation-item-icon"
                                src="https://img.icons8.com/external-flatart-icons-flat-flatarticons/64/000000/external-report-project-planing-flatart-icons-flat-flatarticons-1.png"
                                data-v-d4a9e6b5="">
                            <div class="name-container" data-v-d4a9e6b5="">Tasks Report
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['signin_out_report']) &&
        $permissions['signin_out_report'] == true)))
        <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="messages"
            data-v-d4a9e6b5="">
            <div class="item-container" data-v-d4a9e6b5="">
                <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                        aria-describedby="rbd-hidden-text-0-hidden-text-0" data-rbd-drag-handle-draggable-id="chat"
                        data-rbd-drag-handle-context-id="0" draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
                    <a href="{{url('signin_out_report')}}"><img class="item-icon drag-animation-item-icon"
                            src="https://img.icons8.com/external-flatart-icons-flat-flatarticons/64/000000/external-report-project-planing-flatart-icons-flat-flatarticons-1.png"
                            data-v-d4a9e6b5="">
                        <div class="name-container" data-v-d4a9e6b5="">Signin-out Report
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['audit_report']) &&
    $permissions['audit_report'] == true)))
    <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="messages" data-v-d4a9e6b5="">
        <div class="item-container" data-v-d4a9e6b5="">
            <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                    aria-describedby="rbd-hidden-text-0-hidden-text-0" data-rbd-drag-handle-draggable-id="chat"
                    data-rbd-drag-handle-context-id="0" draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
                <a href="{{url('audit_report')}}"><img class="item-icon drag-animation-item-icon"
                        src="https://img.icons8.com/external-flatart-icons-flat-flatarticons/64/000000/external-report-project-planing-flatart-icons-flat-flatarticons-1.png"
                        data-v-d4a9e6b5="">
                    <div class="name-container" data-v-d4a9e6b5="">Audit Report
                </a>
            </div>
        </div>
    </div>
</div>
@endif
@if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['contractor_report']) &&
$permissions['contractor_report'] == true)))
<div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="messages" data-v-d4a9e6b5="">
    <div class="item-container" data-v-d4a9e6b5="">
        <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                aria-describedby="rbd-hidden-text-0-hidden-text-0" data-rbd-drag-handle-draggable-id="chat"
                data-rbd-drag-handle-context-id="0" draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
            <a href="{{url('contractor_report')}}"><img class="item-icon drag-animation-item-icon"
                    src="https://img.icons8.com/external-flatart-icons-flat-flatarticons/64/000000/external-report-project-planing-flatart-icons-flat-flatarticons-1.png"
                    data-v-d4a9e6b5="">
                <div class="name-container" data-v-d4a9e6b5="">Contractor Report
            </a>
        </div>
    </div>
</div>
</div>
@endif
@if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['customer_report']) &&
$permissions['customer_report'] == true)))
<div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="directory" data-v-d4a9e6b5="">
    <div class="item-container" data-v-d4a9e6b5="">
        <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                aria-describedby="rbd-hidden-text-0-hidden-text-0" data-rbd-drag-handle-draggable-id="chat"
                data-rbd-drag-handle-context-id="0" draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
            <a href="{{url('customer_report')}}"><img class="item-icon drag-animation-item-icon"
                    src="https://img.icons8.com/external-flatart-icons-flat-flatarticons/64/000000/external-report-project-planing-flatart-icons-flat-flatarticons-1.png"
                    data-v-d4a9e6b5="">
                <div class="name-container" data-v-d4a9e6b5="">Customer Report
            </a>
        </div>
    </div>
</div>
</div>
@endif
@if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['guard_report']) &&
$permissions['guard_report'] == true)))
<div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="directory" data-v-d4a9e6b5="">
    <div class="item-container" data-v-d4a9e6b5="">
        <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                aria-describedby="rbd-hidden-text-0-hidden-text-0" data-rbd-drag-handle-draggable-id="chat"
                data-rbd-drag-handle-context-id="0" draggable="false" class="  drag-handle" data-v-d4a9e6b5="">

            <div class="name-container" data-v-d4a9e6b5=""><a href="{{url('guard_detail_report')}}"><img
                        class="item-icon drag-animation-item-icon"
                        src="https://img.icons8.com/external-flatart-icons-flat-flatarticons/64/000000/external-report-project-planing-flatart-icons-flat-flatarticons-1.png"
                        data-v-d4a9e6b5="">{{config('custom.guard')}} Report</a>
            </div>
        </div>
    </div>
</div>
@endif
@if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['invoice_report']) &&
$permissions['invoice_report'] == true)))

<div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="messages" data-v-d4a9e6b5="">
    <div class="item-container" data-v-d4a9e6b5="">
        <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                aria-describedby="rbd-hidden-text-0-hidden-text-0" data-rbd-drag-handle-draggable-id="chat"
                data-rbd-drag-handle-context-id="0" draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
            <a href="{{url('invoice_report')}}"><img class="item-icon drag-animation-item-icon"
                    src="https://img.icons8.com/external-flatart-icons-flat-flatarticons/64/000000/external-report-project-planing-flatart-icons-flat-flatarticons-1.png"
                    data-v-d4a9e6b5="">
                <div class="name-container" data-v-d4a9e6b5="">Invoice Report
            </a>
        </div>
    </div>
</div>
</div>
@endif
<div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="messages" data-v-d4a9e6b5="">
    <div class="item-container" data-v-d4a9e6b5="">
        <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                aria-describedby="rbd-hidden-text-0-hidden-text-0" data-rbd-drag-handle-draggable-id="chat"
                data-rbd-drag-handle-context-id="0" draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
            <a href="{{url('invoice_report?type=hour')}}"><img class="item-icon drag-animation-item-icon"
                    src="https://img.icons8.com/external-flatart-icons-flat-flatarticons/64/000000/external-report-project-planing-flatart-icons-flat-flatarticons-1.png"
                    data-v-d4a9e6b5="">
                <div class="name-container" data-v-d4a9e6b5="">Hour Report
            </a>
        </div>
    </div>
</div>
</div>
@if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['paysheet_report']) &&
$permissions['paysheet_report'] == true)))

<div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="directory" data-v-d4a9e6b5="">
    <div class="item-container" data-v-d4a9e6b5="">
        <a href="{{url('guard_payseet')}}">
            <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                    aria-describedby="rbd-hidden-text-0-hidden-text-0" data-rbd-drag-handle-draggable-id="chat"
                    data-rbd-drag-handle-context-id="0" draggable="false" class="  drag-handle" data-v-d4a9e6b5="">

                <div class="name-container" data-v-d4a9e6b5=""><img class="item-icon drag-animation-item-icon"
                        src="https://img.icons8.com/external-flatart-icons-flat-flatarticons/64/000000/external-report-project-planing-flatart-icons-flat-flatarticons-1.png"
                        data-v-d4a9e6b5="">Quick Paysheet
                </div>
            </div>
        </a>
    </div>
</div>
@endif
<!-- <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="directory" data-v-d4a9e6b5="">
<div class="item-container" data-v-d4a9e6b5="">
    <a href="{{url('guard_timesheet')}}">
        <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                aria-describedby="rbd-hidden-text-0-hidden-text-0" data-rbd-drag-handle-draggable-id="chat"
                data-rbd-drag-handle-context-id="0" draggable="false" class="  drag-handle" data-v-d4a9e6b5="">

            <div class="name-container" data-v-d4a9e6b5=""><img class="item-icon drag-animation-item-icon"
                    src="https://img.icons8.com/external-flatart-icons-flat-flatarticons/64/000000/external-report-project-planing-flatart-icons-flat-flatarticons-1.png"
                    data-v-d4a9e6b5="">Timesheet Report
            </div>
        </div>
    </a>
</div>
</div> -->
@if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['incident_report']) &&
$permissions['incident_report'] == true)))

<div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="directory" data-v-d4a9e6b5="">
    <div class="item-container" data-v-d4a9e6b5="">
        <a href="{{url('incident_report_page')}}">
            <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                    aria-describedby="rbd-hidden-text-0-hidden-text-0" data-rbd-drag-handle-draggable-id="chat"
                    data-rbd-drag-handle-context-id="0" draggable="false" class="  drag-handle" data-v-d4a9e6b5="">

                <div class="name-container" data-v-d4a9e6b5=""><img class="item-icon drag-animation-item-icon"
                        src="https://img.icons8.com/external-flatart-icons-flat-flatarticons/64/000000/external-report-project-planing-flatart-icons-flat-flatarticons-1.png"
                        data-v-d4a9e6b5="">Incident Report Page
                </div>
            </div>
        </a>
    </div>
</div>
@endif
@if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['complete_report']) &&
$permissions['complete_report'] == true)))

<div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="directory" data-v-d4a9e6b5="">
    <div class="item-container" data-v-d4a9e6b5="">
        <a href="{{url('guard_complete_report')}}">
            <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                    aria-describedby="rbd-hidden-text-0-hidden-text-0" data-rbd-drag-handle-draggable-id="chat"
                    data-rbd-drag-handle-context-id="0" draggable="false" class="  drag-handle" data-v-d4a9e6b5="">

                <div class="name-container" data-v-d4a9e6b5=""><img class="item-icon drag-animation-item-icon"
                        src="https://img.icons8.com/external-flatart-icons-flat-flatarticons/64/000000/external-report-project-planing-flatart-icons-flat-flatarticons-1.png"
                        data-v-d4a9e6b5="">Complete Paysheet
                </div>
            </div>
        </a>
    </div>
</div>
@endif
@if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['division_consolidation']) &&
$permissions['division_consolidation'] == true)))

<div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="directory" data-v-d4a9e6b5="">
    <div class="item-container" data-v-d4a9e6b5="">
        <a href="{{url('division_consolidation')}}">
            <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                    aria-describedby="rbd-hidden-text-0-hidden-text-0" data-rbd-drag-handle-draggable-id="chat"
                    data-rbd-drag-handle-context-id="0" draggable="false" class="  drag-handle" data-v-d4a9e6b5="">

                <div class="name-container" data-v-d4a9e6b5=""><img class="item-icon drag-animation-item-icon"
                        src="https://img.icons8.com/external-flatart-icons-flat-flatarticons/64/000000/external-report-project-planing-flatart-icons-flat-flatarticons-1.png"
                        data-v-d4a9e6b5="">Division Consolidation
                </div>
            </div>
        </a>
    </div>
</div>
@endif
@if(config('custom.multi_report') == 1)
<div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="directory" data-v-d4a9e6b5="">
    <div class="item-container" data-v-d4a9e6b5="">
        <a href="{{url('combine_report')}}">
            <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                    aria-describedby="rbd-hidden-text-0-hidden-text-0" data-rbd-drag-handle-draggable-id="chat"
                    data-rbd-drag-handle-context-id="0" draggable="false" class="  drag-handle" data-v-d4a9e6b5="">

                <div class="name-container" data-v-d4a9e6b5=""><img class="item-icon drag-animation-item-icon"
                        src="https://img.icons8.com/external-flatart-icons-flat-flatarticons/64/000000/external-report-project-planing-flatart-icons-flat-flatarticons-1.png"
                        data-v-d4a9e6b5="">Multi Report
                </div>
            </div>
        </a>
    </div>
</div>
@endif
@if(config('custom.own_payrates') == 1)
<div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="directory" data-v-d4a9e6b5="">
    <div class="item-container" data-v-d4a9e6b5="">
        <a href="{{url('award_report')}}">
            <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                    aria-describedby="rbd-hidden-text-0-hidden-text-0" data-rbd-drag-handle-draggable-id="chat"
                    data-rbd-drag-handle-context-id="0" draggable="false" class="  drag-handle" data-v-d4a9e6b5="">

                <div class="name-container" data-v-d4a9e6b5=""><img class="item-icon drag-animation-item-icon"
                        src="https://img.icons8.com/external-flatart-icons-flat-flatarticons/64/000000/external-report-project-planing-flatart-icons-flat-flatarticons-1.png"
                        data-v-d4a9e6b5="">Award Report
                </div>
            </div>
        </a>
    </div>
</div>
@endif
</div>
</div>
<!-- </div> -->
@endif
@if(($is_super_admin == 1 || ((isset($permissions['charge_rates']) && $permissions['charge_rates'] == true) ||
(isset($permissions['pay_rates']) && $permissions['pay_rates'] == true))))
<div class="sidebar-section " data-v-49d408a5="" style="height: ;">
    <div class="sidebar-section-inner-container" data-v-49d408a5="">
        <div class="handle-container" data-v-49d408a5=""><img tabindex="0" role="button"
                aria-describedby="rbd-hidden-text-0-hidden-text-0"
                data-rbd-drag-handle-draggable-id="aaf40970-be04-44c0-9058-52f535a6ac9f"
                data-rbd-drag-handle-context-id="0" draggable="false" class="visibility-hidden drag-handle"
                data-v-49d408a5="">
            <div class="section-name false" data-v-49d408a5="">Rates</div>
        </div>
        <div class="flex-row-centered" data-v-49d408a5="">
            <a type="button" id="rates_dropdown" onclick="toggle_sidebar(this)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17">
                    <g fill="none" fill-rule="evenodd" transform="translate(0 .5)">
                        <rect width="15" height="15" x=".5" y=".5" stroke="#AAA" rx="4" />
                        <path fill="#AAA" fill-rule="nonzero"
                            d="M9.359 11.7L10.177 10.942 7.802 8.506 10.2 6.104 9.359 5.3 6.2 8.494 6.2 8.506z"
                            transform="rotate(-90 8.2 8.5)" />
                    </g>
                </svg>
            </a>
            <div class="margin-right-15" data-v-49d408a5="">
                <div class="dropdown-menu-wrapper" data-v-45dae309="">
                    <div class="dropdown-menu-wrapper-toggle" data-v-45dae309="">
                        <div class="toggle-container" data-v-49d408a5=""><img
                                src="https://img.icons8.com/material-outlined/64/000000/menu-2.png"
                                class="meatballs-button dropdown-toggle" data-v-49d408a5=""></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(isset($item->charge_rates) && $item->charge_rates == '1' && config('custom.own_payrates') == 0)
    @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['charge_rates']) &&
    $permissions['charge_rates'] == true)))
    <div id="rates_dropdown_content" data-rbd-droppable-id="aaf40970-be04-44c0-9058-52f535a6ac9f"
        data-rbd-droppable-context-id="0" data-v-49d408a5="" style="min-height: 1px;">
        <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="chat" data-v-d4a9e6b5="">
            <div class="item-container" data-v-d4a9e6b5="">
                <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                        aria-describedby="rbd-hidden-text-0-hidden-text-0" data-rbd-drag-handle-draggable-id="chat"
                        data-rbd-drag-handle-context-id="0" draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
                    <a href="{{url('charged_rates')}}"><img class="item-icon drag-animation-item-icon"
                            src="https://img.icons8.com/external-kiranshastry-lineal-kiranshastry/64/000000/external-dollar-banking-and-finance-kiranshastry-lineal-kiranshastry-6.png"
                            data-v-d4a9e6b5="" style="background-color: rgb(46, 217, 185);">
                        <div class="name-container" data-v-d4a9e6b5="">Charge Rates
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endif
    @if(isset($item->pay_rates) && $item->pay_rates == '1' && config('custom.own_payrates') == 0)
    @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['pay_rates']) &&
    $permissions['pay_rates'] == true)))
    <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="messages" data-v-d4a9e6b5="">
        <div class="item-container" data-v-d4a9e6b5="">
            <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                    aria-describedby="rbd-hidden-text-0-hidden-text-0" data-rbd-drag-handle-draggable-id="messages"
                    data-rbd-drag-handle-context-id="0" draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
                <a href="{{url('payrates')}}"><img class="item-icon drag-animation-item-icon"
                        src="https://img.icons8.com/external-kiranshastry-lineal-kiranshastry/64/000000/external-dollar-banking-and-finance-kiranshastry-lineal-kiranshastry-6.png"
                        data-v-d4a9e6b5="" style="background-color: rgb(65, 118, 255);">
                    <div class="name-container" data-v-d4a9e6b5="">Pay Rates
                </a>
            </div>
        </div>
    </div>
</div>
@endif
@endif
@if(config('custom.own_payrates') == 1)
<div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="messages" data-v-d4a9e6b5="">
    <div class="item-container" data-v-d4a9e6b5="">
        <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                aria-describedby="rbd-hidden-text-0-hidden-text-0" data-rbd-drag-handle-draggable-id="messages"
                data-rbd-drag-handle-context-id="0" draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
            <a href="{{url('payrates_new?type=abn')}}"><img class="item-icon drag-animation-item-icon"
                    src="https://img.icons8.com/external-kiranshastry-lineal-kiranshastry/64/000000/external-dollar-banking-and-finance-kiranshastry-lineal-kiranshastry-6.png"
                    data-v-d4a9e6b5="" style="background-color: rgb(65, 118, 255);">
                <div class="name-container" data-v-d4a9e6b5="">ABN Rates
            </a>
        </div>
    </div>
</div>
</div>
<div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="messages" data-v-d4a9e6b5="">
    <div class="item-container" data-v-d4a9e6b5="">
        <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                aria-describedby="rbd-hidden-text-0-hidden-text-0" data-rbd-drag-handle-draggable-id="messages"
                data-rbd-drag-handle-context-id="0" draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
            <a href="{{url('payrates_new?type=eba')}}"><img class="item-icon drag-animation-item-icon"
                    src="https://img.icons8.com/external-kiranshastry-lineal-kiranshastry/64/000000/external-dollar-banking-and-finance-kiranshastry-lineal-kiranshastry-6.png"
                    data-v-d4a9e6b5="" style="background-color: rgb(65, 118, 255);">
                <div class="name-container" data-v-d4a9e6b5="">EBA Rates
            </a>
        </div>
    </div>
</div>
</div>
<div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="messages" data-v-d4a9e6b5="">
    <div class="item-container" data-v-d4a9e6b5="">
        <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                aria-describedby="rbd-hidden-text-0-hidden-text-0" data-rbd-drag-handle-draggable-id="messages"
                data-rbd-drag-handle-context-id="0" draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
            <a href="{{url('award_payrates')}}"><img class="item-icon drag-animation-item-icon"
                    src="https://img.icons8.com/external-kiranshastry-lineal-kiranshastry/64/000000/external-dollar-banking-and-finance-kiranshastry-lineal-kiranshastry-6.png"
                    data-v-d4a9e6b5="" style="background-color: rgb(65, 118, 255);">
                <div class="name-container" data-v-d4a9e6b5="">Award Rates
            </a>
        </div>
    </div>
</div>
</div>
@endif
</div>
</div>
@endif
<div class="flex-row-centered add-new-feature">
    <div class=""> </div>
</div>
@if(session()->get('userType') == 'admin' && $is_super_admin == 1)
<div class="sidebar-section " data-v-49d408a5="">
    <div class="sidebar-section-inner-container" data-v-49d408a5="">
        <div class="handle-container" data-v-49d408a5=""><img tabindex="0" role="button"
                aria-describedby="rbd-hidden-text-0-hidden-text-0"
                data-rbd-drag-handle-draggable-id="aaf40970-be04-44c0-9058-52f535a6ac9f"
                data-rbd-drag-handle-context-id="0" draggable="false" class="visibility-hidden drag-handle"
                data-v-49d408a5="">
            <div class="section-name false" data-v-49d408a5="">Portal Setting</div>
        </div>
        <div class="flex-row-centered" data-v-49d408a5="">
            <a type="button" id="app_dropdown" onclick="toggle_sidebar(this)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17">
                    <g fill="none" fill-rule="evenodd" transform="translate(0 .5)">
                        <rect width="15" height="15" x=".5" y=".5" stroke="#AAA" rx="4" />
                        <path fill="#AAA" fill-rule="nonzero"
                            d="M9.359 11.7L10.177 10.942 7.802 8.506 10.2 6.104 9.359 5.3 6.2 8.494 6.2 8.506z"
                            transform="rotate(-90 8.2 8.5)" />
                    </g>
                </svg>
            </a>
            <div class="margin-right-15" data-v-49d408a5="">
                <div class="dropdown-menu-wrapper" data-v-45dae309="">
                    <div class="dropdown-menu-wrapper-toggle" data-v-45dae309="">
                        <div class="toggle-container" data-v-49d408a5=""><img
                                src="https://img.icons8.com/material-outlined/64/000000/menu-2.png"
                                class="meatballs-button dropdown-toggle" data-v-49d408a5=""></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="app_dropdown_content" data-rbd-droppable-id="aaf40970-be04-44c0-9058-52f535a6ac9f"
        data-rbd-droppable-context-id="0" data-v-49d408a5="" style="min-height: 1px;">
        <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="chat" data-v-d4a9e6b5="">
            <div class="item-container" data-v-d4a9e6b5="">
                <a href="{{url('portal_email_settings')}}">
                    <div class="item-inner-container" data-v-d4a9e6b5="">
                        <img tabindex="0" role="button" aria-describedby="rbd-hidden-text-0-hidden-text-0"
                            data-rbd-drag-handle-draggable-id="chat" data-rbd-drag-handle-context-id="0"
                            draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
                        <img class="item-icon drag-animation-item-icon"
                            src="https://s3.eu-central-1.amazonaws.com/onefid.content.assets/shared/subCategoryIcons/Icon_envelope.png"
                            data-v-d4a9e6b5="" style="background-color: rgb(46, 217, 185);">
                        <div class="name-container" data-v-d4a9e6b5="">Email
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="directory"
            data-v-d4a9e6b5="">
            <div class="item-container" data-v-d4a9e6b5="">
                <a href="{{url('ph_settings')}}">
                    <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                            aria-describedby="rbd-hidden-text-0-hidden-text-0"
                            data-rbd-drag-handle-draggable-id="directory" data-rbd-drag-handle-context-id="0"
                            draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
                        <img class="item-icon drag-animation-item-icon"
                            src="https://img.icons8.com/ios-glyphs/30/000000/settings--v1.png" data-v-d4a9e6b5=""
                            style="background-color: rgb(225, 48, 113);">
                        <div class="name-container" data-v-d4a9e6b5="">PH Settings
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="directory"
            data-v-d4a9e6b5="">
            <div class="item-container" data-v-d4a9e6b5="">
                <a href="{{url('color_settings')}}">
                    <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                            aria-describedby="rbd-hidden-text-0-hidden-text-0"
                            data-rbd-drag-handle-draggable-id="directory" data-rbd-drag-handle-context-id="0"
                            draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
                        <img class="item-icon drag-animation-item-icon"
                            src="https://img.icons8.com/ios-glyphs/30/000000/settings--v1.png" data-v-d4a9e6b5=""
                            style="background-color: rgb(225, 48, 113);">
                        <div class="name-container" data-v-d4a9e6b5="">Color Settings
                        </div>
                    </div>
                </a>
            </div>
        </div>

    </div>
</div>
@endif
@if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['app_settings']) &&
$permissions['app_settings'] == true)))
<div class="sidebar-section " data-v-49d408a5="" style="height: 185px;">
    <div class="sidebar-section-inner-container" data-v-49d408a5="">
        <div class="handle-container" data-v-49d408a5=""><img tabindex="0" role="button"
                aria-describedby="rbd-hidden-text-0-hidden-text-0"
                data-rbd-drag-handle-draggable-id="aaf40970-be04-44c0-9058-52f535a6ac9f"
                data-rbd-drag-handle-context-id="0" draggable="false" class="visibility-hidden drag-handle"
                data-v-49d408a5="">
            <div class="section-name false" data-v-49d408a5="">App Settings</div>
        </div>
        <div class="flex-row-centered" data-v-49d408a5="">
            <a type="button" id="app_dropdown" onclick="toggle_sidebar(this)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17">
                    <g fill="none" fill-rule="evenodd" transform="translate(0 .5)">
                        <rect width="15" height="15" x=".5" y=".5" stroke="#AAA" rx="4" />
                        <path fill="#AAA" fill-rule="nonzero"
                            d="M9.359 11.7L10.177 10.942 7.802 8.506 10.2 6.104 9.359 5.3 6.2 8.494 6.2 8.506z"
                            transform="rotate(-90 8.2 8.5)" />
                    </g>
                </svg>
            </a>
            <div class="margin-right-15" data-v-49d408a5="">
                <div class="dropdown-menu-wrapper" data-v-45dae309="">
                    <div class="dropdown-menu-wrapper-toggle" data-v-45dae309="">
                        <div class="toggle-container" data-v-49d408a5=""><img
                                src="https://img.icons8.com/material-outlined/64/000000/menu-2.png"
                                class="meatballs-button dropdown-toggle" data-v-49d408a5=""></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="app_dropdown_content" data-rbd-droppable-id="aaf40970-be04-44c0-9058-52f535a6ac9f"
        data-rbd-droppable-context-id="0" data-v-49d408a5="" style="min-height: 1px;">
        <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="chat" data-v-d4a9e6b5="">
            <div class="item-container" data-v-d4a9e6b5="">
                <a href="{{url('basic_setting')}}">
                    <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                            aria-describedby="rbd-hidden-text-0-hidden-text-0" data-rbd-drag-handle-draggable-id="chat"
                            data-rbd-drag-handle-context-id="0" draggable="false" class="  drag-handle"
                            data-v-d4a9e6b5="">
                        <img class="item-icon drag-animation-item-icon"
                            src="https://img.icons8.com/ios-glyphs/30/000000/settings--v1.png" data-v-d4a9e6b5=""
                            style="background-color: rgb(46, 217, 185);">
                        <div class="name-container" data-v-d4a9e6b5="">Basics
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="messages"
            data-v-d4a9e6b5="">
            <div class="item-container" data-v-d4a9e6b5="">
                <a href="{{url('feature_setting')}}">
                    <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                            aria-describedby="rbd-hidden-text-0-hidden-text-0"
                            data-rbd-drag-handle-draggable-id="messages" data-rbd-drag-handle-context-id="0"
                            draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
                        <img class="item-icon drag-animation-item-icon"
                            src="https://img.icons8.com/ios-glyphs/30/000000/settings--v1.png" data-v-d4a9e6b5=""
                            style="background-color: rgb(65, 118, 255);">
                        <div class="name-container" data-v-d4a9e6b5="">Features
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="sidebar-item " data-rbd-draggable-context-id="0" data-rbd-draggable-id="directory"
            data-v-d4a9e6b5="">
            <div class="item-container" data-v-d4a9e6b5="">
                <a href="{{url('notification_setting')}}">
                    <div class="item-inner-container" data-v-d4a9e6b5=""><img tabindex="0" role="button"
                            aria-describedby="rbd-hidden-text-0-hidden-text-0"
                            data-rbd-drag-handle-draggable-id="directory" data-rbd-drag-handle-context-id="0"
                            draggable="false" class="  drag-handle" data-v-d4a9e6b5="">
                        <img class="item-icon drag-animation-item-icon"
                            src="https://img.icons8.com/ios-glyphs/30/000000/settings--v1.png" data-v-d4a9e6b5=""
                            style="background-color: rgb(225, 48, 113);">
                        <div class="name-container" data-v-d4a9e6b5="">Notifications
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- </div> -->

    {{-- uncomment for notificaitons --}}
    {{-- <div class="static-sidebar-item" data-v-5aa85418="">
   <div class="static-sidebar-item-inner-container" data-v-5aa85418="">
      <div class="d-flex align-items-center mb-2">
         <!--begin::Menu wrapper-->
         <div class="btn btn-icon btn-active-color-primary btn-color-gray-400 btn-active-light" data-kt-menu-trigger="click" data-kt-menu-overflow="true" data-kt-menu-placement="top-start" data-kt-menu-flip="top-end" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click" title="" data-bs-original-title="Notifications">
            <!--begin::Svg Icon | path: icons/duotone/Layout/Layout-4-blocks.svg--><span class="svg-icon svg-icon-2 svg-icon-lg-1">
               <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                     <rect x="0" y="0" width="24" height="24"></rect>
                     <rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5"></rect>
                     <path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z" fill="#000000" opacity="0.3"></path>
                 </g>
             </svg>
         </span>
         <!--end::Svg Icon-->
     </div>
     <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true" style="">
        <!--begin::Heading-->
        <div class="d-flex flex-column bgi-no-repeat rounded-top" style="background-image:url('{{asset('')}}media/misc/dropdown-header-bg.png')">
    <!--begin::Title-->
    <h3 class="text-white fw-bold px-9 mt-10 mb-6">Notifications
        <span class="fs-8 opacity-75 ps-3">24 reports</span></h3>
    <!--end::Title-->
    <!--begin::Tabs-->
    <ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-bold px-9">
        <li class="nav-item"> <a class="nav-link text-white opacity-75 opacity-state-100 pb-4" data-bs-toggle="tab"
                href="#kt_topbar_notifications_1">Green</a> </li>
        <li class="nav-item"> <a class="nav-link text-white opacity-75 opacity-state-100 pb-4 active"
                data-bs-toggle="tab" href="#kt_topbar_notifications_2">Welfare</a> </li>
        <li class="nav-item"> <a class="nav-link text-white opacity-75 opacity-state-100 pb-4" data-bs-toggle="tab"
                href="#kt_topbar_notifications_3">Guard Leave</a> </li>
    </ul>
    <!--end::Tabs-->
</div>
<!--end::Heading-->
<!--begin::Tab content-->
<div class="tab-content">
    <!--begin::Tab panel-->
    <div class="tab-pane fade" id="kt_topbar_notifications_1" role="tabpanel">
        <!--begin::Items-->
        <div class="scroll-y mh-325px my-5 px-8">
            <!--begin::Item-->
            <div class="d-flex flex-stack py-4">
                <!--begin::Section-->
                <div class="d-flex align-items-center">
                    <!--begin::Symbol-->
                    <div class="symbol symbol-35px me-4"> <span class="symbol-label bg-light-primary">
                            <!--begin::Svg Icon | path: icons/duotone/Clothes/Crown.svg-->
                            <span class="svg-icon svg-icon-2 svg-icon-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"
                                    version="1.1">
                                    <path
                                        d="M11.2600599,5.81393408 L2,16 L22,16 L12.7399401,5.81393408 C12.3684331,5.40527646 11.7359848,5.37515988 11.3273272,5.7466668 C11.3038503,5.7680094 11.2814025,5.79045722 11.2600599,5.81393408 Z"
                                        fill="#000000" opacity="0.3"></path>
                                    <path
                                        d="M12.0056789,15.7116802 L20.2805786,6.85290308 C20.6575758,6.44930487 21.2903735,6.42774054 21.6939717,6.8047378 C21.8964274,6.9938498 22.0113578,7.25847607 22.0113578,7.535517 L22.0113578,20 L16.0113578,20 L2,20 L2,7.535517 C2,7.25847607 2.11493033,6.9938498 2.31738608,6.8047378 C2.72098429,6.42774054 3.35378194,6.44930487 3.7307792,6.85290308 L12.0056789,15.7116802 Z"
                                        fill="#000000"></path>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                    </div>
                    <!--end::Symbol-->
                    <!--begin::Title-->
                    <div class="mb-0 me-2"> <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bolder">Project
                            Alice</a>
                        <div class="text-gray-400 fs-7">Phase 1 development</div>
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Section-->
                <!--begin::Label--><span class="badge badge-light fs-8">1 hr</span>
                <!--end::Label-->
            </div>
            <!--end::Item-->
            <!--begin::Item-->
            <div class="d-flex flex-stack py-4">
                <!--begin::Section-->
                <div class="d-flex align-items-center">
                    <!--begin::Symbol-->
                    <div class="symbol symbol-35px me-4"> <span class="symbol-label bg-light-danger">
                            <!--begin::Svg Icon | path: icons/duotone/Code/Warning-2.svg-->
                            <span class="svg-icon svg-icon-2 svg-icon-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"
                                    version="1.1">
                                    <path
                                        d="M11.1669899,4.49941818 L2.82535718,19.5143571 C2.557144,19.9971408 2.7310878,20.6059441 3.21387153,20.8741573 C3.36242953,20.9566895 3.52957021,21 3.69951446,21 L21.2169432,21 C21.7692279,21 22.2169432,20.5522847 22.2169432,20 C22.2169432,19.8159952 22.1661743,19.6355579 22.070225,19.47855 L12.894429,4.4636111 C12.6064401,3.99235656 11.9909517,3.84379039 11.5196972,4.13177928 C11.3723594,4.22181902 11.2508468,4.34847583 11.1669899,4.49941818 Z"
                                        fill="#000000" opacity="0.3"></path>
                                    <rect fill="#000000" x="11" y="9" width="2" height="7" rx="1"></rect>
                                    <rect fill="#000000" x="11" y="17" width="2" height="2" rx="1"></rect>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                    </div>
                    <!--end::Symbol-->
                    <!--begin::Title-->
                    <div class="mb-0 me-2"> <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bolder">HR
                            Confidential</a>
                        <div class="text-gray-400 fs-7">Confidential staff documents</div>
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Section-->
                <!--begin::Label--><span class="badge badge-light fs-8">2 hrs</span>
                <!--end::Label-->
            </div>
            <!--end::Item-->
            <!--begin::Item-->
            <div class="d-flex flex-stack py-4">
                <!--begin::Section-->
                <div class="d-flex align-items-center">
                    <!--begin::Symbol-->
                    <div class="symbol symbol-35px me-4"> <span class="symbol-label bg-light-warning">
                            <!--begin::Svg Icon | path: icons/duotone/Communication/Group.svg-->
                            <span class="svg-icon svg-icon-2 svg-icon-warning">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"
                                    version="1.1">
                                    <path
                                        d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                                        fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                    <path
                                        d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                                        fill="#000000" fill-rule="nonzero"></path>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                    </div>
                    <!--end::Symbol-->
                    <!--begin::Title-->
                    <div class="mb-0 me-2"> <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bolder">Company
                            HR</a>
                        <div class="text-gray-400 fs-7">Corporeate staff profiles</div>
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Section-->
                <!--begin::Label--><span class="badge badge-light fs-8">5 hrs</span>
                <!--end::Label-->
            </div>
            <!--end::Item-->
            <!--begin::Item-->
            <div class="d-flex flex-stack py-4">
                <!--begin::Section-->
                <div class="d-flex align-items-center">
                    <!--begin::Symbol-->
                    <div class="symbol symbol-35px me-4"> <span class="symbol-label bg-light-success">
                            <!--begin::Svg Icon | path: icons/duotone/General/Thunder.svg-->
                            <span class="svg-icon svg-icon-2 svg-icon-success">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"></rect>
                                        <path
                                            d="M12.3740377,19.9389434 L18.2226499,11.1660251 C18.4524142,10.8213786 18.3592838,10.3557266 18.0146373,10.1259623 C17.8914367,10.0438285 17.7466809,10 17.5986122,10 L13,10 L13,4.47708173 C13,4.06286817 12.6642136,3.72708173 12.25,3.72708173 C11.9992351,3.72708173 11.7650616,3.85240758 11.6259623,4.06105658 L5.7773501,12.8339749 C5.54758575,13.1786214 5.64071616,13.6442734 5.98536267,13.8740377 C6.10856331,13.9561715 6.25331908,14 6.40138782,14 L11,14 L11,19.5229183 C11,19.9371318 11.3357864,20.2729183 11.75,20.2729183 C12.0007649,20.2729183 12.2349384,20.1475924 12.3740377,19.9389434 Z"
                                            fill="#000000"></path>
                                    </g>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                    </div>
                    <!--end::Symbol-->
                    <!--begin::Title-->
                    <div class="mb-0 me-2"> <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bolder">Project
                            Redux</a>
                        <div class="text-gray-400 fs-7">New frontend admin theme</div>
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Section-->
                <!--begin::Label--><span class="badge badge-light fs-8">2 days</span>
                <!--end::Label-->
            </div>
            <!--end::Item-->
            <!--begin::Item-->
            <div class="d-flex flex-stack py-4">
                <!--begin::Section-->
                <div class="d-flex align-items-center">
                    <!--begin::Symbol-->
                    <div class="symbol symbol-35px me-4"> <span class="symbol-label bg-light-primary">
                            <!--begin::Svg Icon | path: icons/duotone/Communication/Flag.svg-->
                            <span class="svg-icon svg-icon-2 svg-icon-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"
                                    version="1.1">
                                    <path
                                        d="M3.5,3 L5,3 L5,19.5 C5,20.3284271 4.32842712,21 3.5,21 L3.5,21 C2.67157288,21 2,20.3284271 2,19.5 L2,4.5 C2,3.67157288 2.67157288,3 3.5,3 Z"
                                        fill="#000000"></path>
                                    <path
                                        d="M6.99987583,2.99995344 L19.754647,2.99999303 C20.3069317,2.99999474 20.7546456,3.44771138 20.7546439,3.99999613 C20.7546431,4.24703684 20.6631995,4.48533385 20.497938,4.66895776 L17.5,8 L20.4979317,11.3310353 C20.8673908,11.7415453 20.8341123,12.3738351 20.4236023,12.7432941 C20.2399776,12.9085564 20.0016794,13 19.7546376,13 L6.99987583,13 L6.99987583,2.99995344 Z"
                                        fill="#000000" opacity="0.3"></path>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                    </div>
                    <!--end::Symbol-->
                    <!--begin::Title-->
                    <div class="mb-0 me-2"> <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bolder">Project
                            Breafing</a>
                        <div class="text-gray-400 fs-7">Product launch status update</div>
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Section-->
                <!--begin::Label--><span class="badge badge-light fs-8">21 Jan</span>
                <!--end::Label-->
            </div>
            <!--end::Item-->
            <!--begin::Item-->
            <div class="d-flex flex-stack py-4">
                <!--begin::Section-->
                <div class="d-flex align-items-center">
                    <!--begin::Symbol-->
                    <div class="symbol symbol-35px me-4"> <span class="symbol-label bg-light-info">
                            <!--begin::Svg Icon | path: icons/duotone/Design/Image.svg-->
                            <span class="svg-icon svg-icon-2 svg-icon-info">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"
                                    version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                        <path
                                            d="M6,5 L18,5 C19.6568542,5 21,6.34314575 21,8 L21,17 C21,18.6568542 19.6568542,20 18,20 L6,20 C4.34314575,20 3,18.6568542 3,17 L3,8 C3,6.34314575 4.34314575,5 6,5 Z M5,17 L14,17 L9.5,11 L5,17 Z M16,14 C17.6568542,14 19,12.6568542 19,11 C19,9.34314575 17.6568542,8 16,8 C14.3431458,8 13,9.34314575 13,11 C13,12.6568542 14.3431458,14 16,14 Z"
                                            fill="#000000"></path>
                                    </g>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                    </div>
                    <!--end::Symbol-->
                    <!--begin::Title-->
                    <div class="mb-0 me-2"> <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bolder">Banner
                            Assets</a>
                        <div class="text-gray-400 fs-7">Collection of banner images</div>
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Section-->
                <!--begin::Label--><span class="badge badge-light fs-8">21 Jan</span>
                <!--end::Label-->
            </div>
            <!--end::Item-->
            <!--begin::Item-->
            <div class="d-flex flex-stack py-4">
                <!--begin::Section-->
                <div class="d-flex align-items-center">
                    <!--begin::Symbol-->
                    <div class="symbol symbol-35px me-4"> <span class="symbol-label bg-light-warning">
                            <!--begin::Svg Icon | path: icons/duotone/Design/Component.svg-->
                            <span class="svg-icon svg-icon-2 svg-icon-warning">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"
                                    version="1.1">
                                    <path
                                        d="M12.7442084,3.27882877 L19.2473374,6.9949025 C19.7146999,7.26196679 20.003129,7.75898194 20.003129,8.29726722 L20.003129,15.7027328 C20.003129,16.2410181 19.7146999,16.7380332 19.2473374,17.0050975 L12.7442084,20.7211712 C12.2830594,20.9846849 11.7169406,20.9846849 11.2557916,20.7211712 L4.75266256,17.0050975 C4.28530007,16.7380332 3.99687097,16.2410181 3.99687097,15.7027328 L3.99687097,8.29726722 C3.99687097,7.75898194 4.28530007,7.26196679 4.75266256,6.9949025 L11.2557916,3.27882877 C11.7169406,3.01531506 12.2830594,3.01531506 12.7442084,3.27882877 Z M12,14.5 C13.3807119,14.5 14.5,13.3807119 14.5,12 C14.5,10.6192881 13.3807119,9.5 12,9.5 C10.6192881,9.5 9.5,10.6192881 9.5,12 C9.5,13.3807119 10.6192881,14.5 12,14.5 Z"
                                        fill="#000000"></path>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                    </div>
                    <!--end::Symbol-->
                    <!--begin::Title-->
                    <div class="mb-0 me-2"> <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bolder">Icon
                            Assets</a>
                        <div class="text-gray-400 fs-7">Collection of SVG icons</div>
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Section-->
                <!--begin::Label--><span class="badge badge-light fs-8">20 March</span>
                <!--end::Label-->
            </div>
            <!--end::Item-->
        </div>
        <!--end::Items-->
        <!--begin::View more-->
        <div class="py-3 text-center border-top"> <a href="pages/profile/activity.html"
                class="btn btn-color-gray-600 btn-active-color-primary">View All
                <!--begin::Svg Icon | path: icons/duotone/Navigation/Right-2.svg-->
                <span class="svg-icon svg-icon-5">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                        height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                            <rect fill="#000000" opacity="0.5"
                                transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000)"
                                x="7.5" y="7.5" width="2" height="9" rx="1"></rect>
                            <path
                                d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z"
                                fill="#000000" fill-rule="nonzero"
                                transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)">
                            </path>
                        </g>
                    </svg>
                </span>
                <!--end::Svg Icon--></a> </div>
        <!--end::View more-->
    </div>
    <!--end::Tab panel-->
    <!--begin::Tab panel-->
    <div class="tab-pane fade show active" id="kt_topbar_notifications_2" role="tabpanel">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column px-9">
            <!--begin::Section-->
            <div class="pt-10 pb-0">
                <!--begin::Title-->
                <h3 class="text-dark text-center fw-bolder">Get Pro Access</h3>
                <!--end::Title-->
                <!--begin::Text-->
                <div class="text-center text-gray-600 fw-bold pt-1">Outlines keep you honest. They stoping you from
                    amazing poorly about drive</div>
                <!--end::Text-->
                <!--begin::Action-->
                <div class="text-center mt-5 mb-9"> <a href="#" class="btn btn-sm btn-primary px-6"
                        data-bs-toggle="modal" data-bs-target="#kt_modal_upgrade_plan">Upgrade</a> </div>
                <!--end::Action-->
            </div>
            <!--end::Section-->
            <!--begin::Illustration-->
            <div class="text-center px-4"> <img class="mw-100 mh-200px" alt="metronic"
                    src="{{asset('')}}media/illustrations/work.png"> </div>
            <!--end::Illustration-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Tab panel-->
    <!--begin::Tab panel-->
    <div class="tab-pane fade" id="kt_topbar_notifications_3" role="tabpanel">
        <!--begin::Items-->
        <div class="scroll-y mh-325px my-5 px-8">
            <!--begin::Item-->
            <div class="d-flex flex-stack py-4">
                <!--begin::Section-->
                <div class="d-flex align-items-center me-2">
                    <!--begin::Code--><span class="w-70px badge badge-light-success me-4">200 OK</span>
                    <!--end::Code-->
                    <!--begin::Title--><a href="#" class="text-gray-800 text-hover-primary fw-bold">New order</a>
                    <!--end::Title-->
                </div>
                <!--end::Section-->
                <!--begin::Label--><span class="badge badge-light fs-8">Just now</span>
                <!--end::Label-->
            </div>
            <!--end::Item-->
            <!--begin::Item-->
            <div class="d-flex flex-stack py-4">
                <!--begin::Section-->
                <div class="d-flex align-items-center me-2">
                    <!--begin::Code--><span class="w-70px badge badge-light-danger me-4">500 ERR</span>
                    <!--end::Code-->
                    <!--begin::Title--><a href="#" class="text-gray-800 text-hover-primary fw-bold">New customer</a>
                    <!--end::Title-->
                </div>
                <!--end::Section-->
                <!--begin::Label--><span class="badge badge-light fs-8">2 hrs</span>
                <!--end::Label-->
            </div>
            <!--end::Item-->
            <!--begin::Item-->
            <div class="d-flex flex-stack py-4">
                <!--begin::Section-->
                <div class="d-flex align-items-center me-2">
                    <!--begin::Code--><span class="w-70px badge badge-light-success me-4">200 OK</span>
                    <!--end::Code-->
                    <!--begin::Title--><a href="#" class="text-gray-800 text-hover-primary fw-bold">Payment process</a>
                    <!--end::Title-->
                </div>
                <!--end::Section-->
                <!--begin::Label--><span class="badge badge-light fs-8">5 hrs</span>
                <!--end::Label-->
            </div>
            <!--end::Item-->
            <!--begin::Item-->
            <div class="d-flex flex-stack py-4">
                <!--begin::Section-->
                <div class="d-flex align-items-center me-2">
                    <!--begin::Code--><span class="w-70px badge badge-light-warning me-4">300 WRN</span>
                    <!--end::Code-->
                    <!--begin::Title--><a href="#" class="text-gray-800 text-hover-primary fw-bold">Search query</a>
                    <!--end::Title-->
                </div>
                <!--end::Section-->
                <!--begin::Label--><span class="badge badge-light fs-8">2 days</span>
                <!--end::Label-->
            </div>
            <!--end::Item-->
            <!--begin::Item-->
            <div class="d-flex flex-stack py-4">
                <!--begin::Section-->
                <div class="d-flex align-items-center me-2">
                    <!--begin::Code--><span class="w-70px badge badge-light-success me-4">200 OK</span>
                    <!--end::Code-->
                    <!--begin::Title--><a href="#" class="text-gray-800 text-hover-primary fw-bold">API connection</a>
                    <!--end::Title-->
                </div>
                <!--end::Section-->
                <!--begin::Label--><span class="badge badge-light fs-8">1 week</span>
                <!--end::Label-->
            </div>
            <!--end::Item-->
            <!--begin::Item-->
            <div class="d-flex flex-stack py-4">
                <!--begin::Section-->
                <div class="d-flex align-items-center me-2">
                    <!--begin::Code--><span class="w-70px badge badge-light-success me-4">200 OK</span>
                    <!--end::Code-->
                    <!--begin::Title--><a href="#" class="text-gray-800 text-hover-primary fw-bold">Database restore</a>
                    <!--end::Title-->
                </div>
                <!--end::Section-->
                <!--begin::Label--><span class="badge badge-light fs-8">Mar 5</span>
                <!--end::Label-->
            </div>
            <!--end::Item-->
            <!--begin::Item-->
            <div class="d-flex flex-stack py-4">
                <!--begin::Section-->
                <div class="d-flex align-items-center me-2">
                    <!--begin::Code--><span class="w-70px badge badge-light-warning me-4">300 WRN</span>
                    <!--end::Code-->
                    <!--begin::Title--><a href="#" class="text-gray-800 text-hover-primary fw-bold">System update</a>
                    <!--end::Title-->
                </div>
                <!--end::Section-->
                <!--begin::Label--><span class="badge badge-light fs-8">May 15</span>
                <!--end::Label-->
            </div>
            <!--end::Item-->
            <!--begin::Item-->
            <div class="d-flex flex-stack py-4">
                <!--begin::Section-->
                <div class="d-flex align-items-center me-2">
                    <!--begin::Code--><span class="w-70px badge badge-light-warning me-4">300 WRN</span>
                    <!--end::Code-->
                    <!--begin::Title--><a href="#" class="text-gray-800 text-hover-primary fw-bold">Server OS update</a>
                    <!--end::Title-->
                </div>
                <!--end::Section-->
                <!--begin::Label--><span class="badge badge-light fs-8">Apr 3</span>
                <!--end::Label-->
            </div>
            <!--end::Item-->
            <!--begin::Item-->
            <div class="d-flex flex-stack py-4">
                <!--begin::Section-->
                <div class="d-flex align-items-center me-2">
                    <!--begin::Code--><span class="w-70px badge badge-light-warning me-4">300 WRN</span>
                    <!--end::Code-->
                    <!--begin::Title--><a href="#" class="text-gray-800 text-hover-primary fw-bold">API rollback</a>
                    <!--end::Title-->
                </div>
                <!--end::Section-->
                <!--begin::Label--><span class="badge badge-light fs-8">Jun 30</span>
                <!--end::Label-->
            </div>
            <!--end::Item-->
            <!--begin::Item-->
            <div class="d-flex flex-stack py-4">
                <!--begin::Section-->
                <div class="d-flex align-items-center me-2">
                    <!--begin::Code--><span class="w-70px badge badge-light-danger me-4">500 ERR</span>
                    <!--end::Code-->
                    <!--begin::Title--><a href="#" class="text-gray-800 text-hover-primary fw-bold">Refund process</a>
                    <!--end::Title-->
                </div>
                <!--end::Section-->
                <!--begin::Label--><span class="badge badge-light fs-8">Jul 10</span>
                <!--end::Label-->
            </div>
            <!--end::Item-->
            <!--begin::Item-->
            <div class="d-flex flex-stack py-4">
                <!--begin::Section-->
                <div class="d-flex align-items-center me-2">
                    <!--begin::Code--><span class="w-70px badge badge-light-danger me-4">500 ERR</span>
                    <!--end::Code-->
                    <!--begin::Title--><a href="#" class="text-gray-800 text-hover-primary fw-bold">Withdrawal
                        process</a>
                    <!--end::Title-->
                </div>
                <!--end::Section-->
                <!--begin::Label--><span class="badge badge-light fs-8">Sep 10</span>
                <!--end::Label-->
            </div>
            <!--end::Item-->
            <!--begin::Item-->
            <div class="d-flex flex-stack py-4">
                <!--begin::Section-->
                <div class="d-flex align-items-center me-2">
                    <!--begin::Code--><span class="w-70px badge badge-light-danger me-4">500 ERR</span>
                    <!--end::Code-->
                    <!--begin::Title--><a href="#" class="text-gray-800 text-hover-primary fw-bold">Mail tasks</a>
                    <!--end::Title-->
                </div>
                <!--end::Section-->
                <!--begin::Label--><span class="badge badge-light fs-8">Dec 10</span>
                <!--end::Label-->
            </div>
            <!--end::Item-->
        </div>
        <!--end::Items-->
        <!--begin::View more-->
        <div class="py-3 text-center border-top"> <a href="pages/profile/activity.html"
                class="btn btn-color-gray-600 btn-active-color-primary">View All
                <!--begin::Svg Icon | path: icons/duotone/Navigation/Right-2.svg-->
                <span class="svg-icon svg-icon-5">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                        height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                            <rect fill="#000000" opacity="0.5"
                                transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000)"
                                x="7.5" y="7.5" width="2" height="9" rx="1"></rect>
                            <path
                                d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z"
                                fill="#000000" fill-rule="nonzero"
                                transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)">
                            </path>
                        </g>
                    </svg>
                </span>
                <!--end::Svg Icon--></a> </div>
        <!--end::View more-->
    </div>
    <!--end::Tab panel-->
</div>
<!--end::Tab content-->
</div>
<!--begin::Menu-->
<!--end::Menu-->
<!--end::Menu wrapper-->
</div>
</div>
<div class="sidebar-badge-container" data-v-5aa85418=""></div>
</div> --}}




<div class="flex-row-centered add-new-feature">
    <div class=""> </div>
</div>
</div>
@endif
</div>

</div>
</div>
@endif
@stop
