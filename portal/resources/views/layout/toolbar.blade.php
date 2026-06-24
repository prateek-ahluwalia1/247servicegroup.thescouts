		@section('toolbar')

        <!--begin::Toolbar wrapper-->
        <div class="d-flex flex-shrink-0">
            <!--begin::Invite user-->
          
            <!--end::Invite user-->
            <!--begin::Create app-->

            <!--end::Create app-->
           
            <!--begin::Chat-->
             <!--begin::Quick links-->
             <?php $config = []; ?>
             @if(session()->get('config_recods'))
            @foreach(session()->get('config_recods') as $item)
                <?php $config = $item; ?>
            @endforeach
            @endif
        @if(session()->get('userType')=='admin')

        	<!--begin::Drawer toggle-->
          
            <!--end::drawer toggle-->
@if(isset($config->notification_icon) && $config->notification_icon == 1)
             <div class="d-flex ms-3" style="
             width: 100%;">
            
                <div style="margin-left: -75%;" class="btn btn-flex flex-center btn-bg-white btn-text-gray-500 btn-active-color-primary w-40px w-md-auto h-40px px-0 px-md-6"  data-kt-menu-trigger="click" data-kt-menu-overflow="true" data-kt-menu-placement="bottom-start" data-kt-menu-flip="bottom-end" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click" >
                    <a type="button" onclick="get_operations_n_times()" class=" " tooltip=" Operations Notes"  id="operation_notes_button">
                        <span class="notifications">
                            Operation Notes 
                            <span id="count_badge" class="badge badge-primary">0</span>
                        </span>
                      
                        </a>
                  
                </div>
                <!--begin::Menu-->
                       <!--begin::Menu wrapper-->
                      
                <div style="margin-top: 54px !important;" id="popup_quick_link" class="loader menu menu-sub menu-sub-dropdown menu-column w-250px w-lg-325px" data-kt-menu="true">
                    <!--begin::Heading-->
                    <div class="d-flex flex-column flex-center bgi-no-repeat rounded-top px-9 py-10 " style="background-image:url('{{asset('')}}media/misc/dropdown-header-bg.png')">
                        <!--begin::Title-->
                        <h3 class="text-white fw-bold mb-3">Operations Notes</h3>
                        <!--end::Title-->
                    </div>
                    <!--end::Heading-->
                    <!--begin:Nav-->
                    <div class="row g-0">
                        <div id="n_times" class=" loading" style="text-align: center"></div>
                    </div>
                    <!--end:Nav-->
                    <!--begin::View more-->
                    <div class="py-2 text-center border-top">
                        <div class="row">
                            <div class="col-sm-6">
                                <a type="button" onclick="get_admin_toid()" class="btn btn-color-gray-600 btn-active-color-primary">
                                    Create Note      <span class="svg-icon svg-icon-5">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                <rect fill="#000000" opacity="0.5" transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000)" x="7.5" y="7.5" width="2" height="9" rx="1" />
                                                <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                            </g>
                                        </svg>
                                    </span></a>
                            </div>
                            <div class="col-sm-6">
                                <a type="button" onclick="get_operations()" class="btn btn-color-gray-600 btn-active-color-primary">View All
                                    <span class="svg-icon svg-icon-5">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                <rect fill="#000000" opacity="0.5" transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000)" x="7.5" y="7.5" width="2" height="9" rx="1" />
                                                <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                            </g>
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon--></a>
                            </div>
                        </div>
                 
                    </div>
                    <!--end::View more-->
                </div>
                <!--end::Menu-->
                <!--end::Menu wrapper-->
            </div>
            <!--end::Quick links-->
                @endif

            <!--begin::Quick links-->
@if(isset($config->notification_icon) && $config->notification_icon == 1)

             <div class="d-flex ms-3" style="
             width: 100%; margin-right: 30px;">
                <!--begin::Menu wrapper-->
                <div class="btn btn-flex flex-center btn-bg-white btn-text-gray-500 btn-active-color-primary w-40px w-md-auto h-40px px-0 px-md-6"  data-kt-menu-trigger="click" data-kt-menu-overflow="true" data-kt-menu-placement="bottom-start" data-kt-menu-flip="bottom-end" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click" id="notifications_counter_div">
                    <a type="button" class="" tooltip="Notifications" id="">
                        <span class="svg-icon svg-icon-2 svg-icon-lg-1">
                                                <!-- <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                        <rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5"></rect>
                                                        <path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z" fill="#000000" opacity="0.3"></path>
                                                    </g>
                                                </svg> -->
                                                <span id="notification_count_badge" class="badge badge-primary">0</span>
                                            </span>
                        </a>
                </div>
                <!--begin::Menu-->
                <div style="margin-top: 54px !important;" id="popup_quick_link" class="loader menu menu-sub menu-sub-dropdown menu-column w-250px w-lg-500px" data-kt-menu="true">
                    <!--begin::Heading-->
                                            <div class="d-flex flex-column bgi-no-repeat rounded-top" style="background-image:url('{{asset('')}}media/misc/dropdown-header-bg.png')">
                                                <!--begin::Title-->
                                                <h3 class="text-white fw-bold px-9 mt-10 mb-6">Notifications
                                                <!-- <span class="fs-8 opacity-75 ps-3">24 reports</span> -->
                                            </h3>
                                                <!--end::Title-->
                                                <!--begin::Tabs-->
                                                <ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-bold px-9">
                                                    <li class="nav-item">
                                                        <a class="nav-link text-white opacity-75 opacity-state-100 pb-4 active" data-bs-toggle="tab" href="#kt_topbar_notifications_11">Green & Welfare</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link text-white opacity-75 opacity-state-100 pb-4" data-bs-toggle="tab" href="#kt_topbar_notifications_22">Incident</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link text-white opacity-75 opacity-state-100 pb-4" data-bs-toggle="tab" href="#kt_topbar_notifications_33">Guard Leave</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link text-white opacity-75 opacity-state-100 pb-4" data-bs-toggle="tab" href="#kt_topbar_notifications_44">Jobs</a>
                                                    </li>
                                                </ul>
                                                <!--end::Tabs-->
                                            </div>
                                            <!--end::Heading-->
                    
                   <!--begin::Tab content-->
                                            <div class="tab-content">
                                                <!--begin::Tab panel-->
                                                <div class="tab-pane fade show active" id="kt_topbar_notifications_11" role="tabpanel">
                                                    <!--begin::Items-->
                                                    <div class="scroll-y mh-325px my-5 px-8" id="green_call_data">

                                                        
                                                    </div>
                                                    <div class="scroll-y mh-325px my-5 px-8" id="welfare_call_data">

                                                    </div>
                                                    <!--end::Items-->
                                                    
                                                </div>
                                                <!--end::Tab panel-->
                                                <!--begin::Tab panel-->
                                                <div class="tab-pane fade" id="kt_topbar_notifications_22" role="tabpanel">
                                                    <!--begin::Items-->
                                                    <div class="scroll-y mh-325px my-5 px-8" id="incident_report_data">

                                                    </div>
                                                    <!--end::Items-->
                                                </div>
                                                <!--end::Tab panel-->
                                                <!--begin::Tab panel-->
                                                <div class="tab-pane fade" id="kt_topbar_notifications_33" role="tabpanel">
                                                    <!--begin::Items-->
                                                    <div class="scroll-y mh-325px my-5 px-8" id="leave_lcoation_data">
                              
                                                        
                                                    </div>
                                                    <!--end::Items-->
                                                    <!--begin::View more-->
                                                    <div class="py-3 text-center border-top" style="display: none;">
                                                        <a href="pages/profile/activity.html" class="btn btn-color-gray-600 btn-active-color-primary">View All
                                                        <!--begin::Svg Icon | path: icons/duotone/Navigation/Right-2.svg-->
                                                        <span class="svg-icon svg-icon-5">
                                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                    <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                                    <rect fill="#000000" opacity="0.5" transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000)" x="7.5" y="7.5" width="2" height="9" rx="1"></rect>
                                                                    <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)"></path>
                                                                </g>
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon--></a>
                                                    </div>
                                                    <!--end::View more-->
                                                </div>
                                                <!--end::Tab panel-->
                                                <div class="tab-pane fade" id="kt_topbar_notifications_44" role="tabpanel">
                                                    <div class="scroll-y mh-325px my-5 px-8" id="other_notifications_data">
                              
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Tab content-->
                </div>
                <!--end::Menu-->
                <!--end::Menu wrapper-->
            </div>
            <!--end::Quick links-->
            @endif
@if(isset($config->message_icon) && $config->message_icon == 1)

           
            <div class="d-flex align-items-center ms-3" style=" margin-right: 20px;
            width: 100%; ">
                <!--begin::Menu wrapper-->
                <!-- id="kt_drawer_chat_toggle" -->
                <div class="btn btn-icon btn-primary w-40px h-40px pulse pulse-white" style="height: 30px !important;width: 30px !important;" data-kt-menu-trigger="click" data-kt-menu-overflow="true" data-kt-menu-placement="bottom-start" data-kt-menu-flip="bottom-end" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click" >
                    <!--begin::Svg Icon | path: icons/duotone/Communication/Group-chat.svg-->
                    <span class="svg-icon svg-icon-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <path d="M16,15.6315789 L16,12 C16,10.3431458 14.6568542,9 13,9 L6.16183229,9 L6.16183229,5.52631579 C6.16183229,4.13107011 7.29290239,3 8.68814808,3 L20.4776218,3 C21.8728674,3 23.0039375,4.13107011 23.0039375,5.52631579 L23.0039375,13.1052632 L23.0206157,17.786793 C23.0215995,18.0629336 22.7985408,18.2875874 22.5224001,18.2885711 C22.3891754,18.2890457 22.2612702,18.2363324 22.1670655,18.1421277 L19.6565168,15.6315789 L16,15.6315789 Z" fill="#000000" />
                            <path d="M1.98505595,18 L1.98505595,13 C1.98505595,11.8954305 2.88048645,11 3.98505595,11 L11.9850559,11 C13.0896254,11 13.9850559,11.8954305 13.9850559,13 L13.9850559,18 C13.9850559,19.1045695 13.0896254,20 11.9850559,20 L4.10078614,20 L2.85693427,21.1905292 C2.65744295,21.3814685 2.34093638,21.3745358 2.14999706,21.1750444 C2.06092565,21.0819836 2.01120804,20.958136 2.01120804,20.8293182 L2.01120804,18.32426 C1.99400175,18.2187196 1.98505595,18.1104045 1.98505595,18 Z M6.5,14 C6.22385763,14 6,14.2238576 6,14.5 C6,14.7761424 6.22385763,15 6.5,15 L11.5,15 C11.7761424,15 12,14.7761424 12,14.5 C12,14.2238576 11.7761424,14 11.5,14 L6.5,14 Z M9.5,16 C9.22385763,16 9,16.2238576 9,16.5 C9,16.7761424 9.22385763,17 9.5,17 L11.5,17 C11.7761424,17 12,16.7761424 12,16.5 C12,16.2238576 11.7761424,16 11.5,16 L9.5,16 Z" fill="#000000" opacity="0.3" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    <span class="pulse-ring"></span>
                </div>
                <!--begin::Menu-->
                <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true">
                    <!--begin::Heading-->
                    <div class="d-flex flex-column bgi-no-repeat rounded-top" style="background-image:url('{{asset('')}}media/misc/pattern-5.png')">
                        <!--begin::Title-->
                        <h3 class="text-white fw-bold px-9 mt-10 mb-6">Messages
                        <span class="fs-8 opacity-75 ps-3" id="messages-count">0</span></h3>
                        <!--end::Title-->
                        <!--begin::Tabs-->
                        <ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-bold px-9">
                            <li class="nav-item">
                                <a class="nav-link text-white opacity-75 opacity-state-100 pb-4 btn-active-color-primary" data-bs-toggle="tab" href="#kt_topbar_notifications_1">New Message</a>
                            </li>
                        </ul>
                        <!--end::Tabs-->
                    </div>
                    <!--end::Heading-->
                    <!--begin::Tab content-->
                    <div class="tab-content">
                        <!--begin::Tab panel-->
                        <div class="tab-pane fade show active" id="kt_topbar_notifications_1" role="tabpanel">
                            <!--begin::Items-->
                            <div class="scroll-y mh-325px my-5 px-8" id="new-messages-data">
                            
                               
                            </div>
                            <!--end::Items-->
                            <!--begin::View more-->
                            <div class="py-3 text-center border-top" style="display: none;">
                                <a href="pages/profile/activity.html" class="btn btn-color-gray-600 btn-active-color-primary">View All
                                <!--begin::Svg Icon | path: icons/duotone/Navigation/Right-2.svg-->
                                <span class="svg-icon svg-icon-5">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <rect fill="#000000" opacity="0.5" transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000)" x="7.5" y="7.5" width="2" height="9" rx="1" />
                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                        </g>
                                    </svg>
                                </span>
                                <!--end::Svg Icon--></a>
                            </div>
                            <!--end::View more-->
                        </div>
                        <!--end::Tab panel-->
                        
                    
                    </div>
                    <!--end::Tab content-->
                </div>
                <!--end::Menu-->
                <!--end::Menu wrapper-->
            </div>
            <!--end::Chat-->
            @endif
            @endif
            <div class="d-flex ms-3" style="margin-top: 1%;margin-right: 20px;
            width: 100%;">
                <div class="me-0">
                    <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary  menu-dropdown" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                        {{-- <i class="bi bi-three-dots fs-3"></i> --}}
                        <div class="sidebar_profile cursor-pointer symbol symbol-40px symbol-50px me-5 show menu-dropdown" data-kt-menu-trigger="click" data-kt-menu-overflow="true" data-kt-menu-placement="top-start" data-kt-menu-flip="top-end" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click" title="" data-bs-original-title="User profile">
               
                        </div>
                        {{-- style="font-size: 15px;
                        float: right;
                        margin-top: 8%;
                        margin-left: 8px;
                        font-weight: bolder;
                        margin-right: 4px;"
                          margin-top: 8%;
                        margin-left: -11px;
                        margin-right: 4px;"
                        --}}
                        <div  style=" margin-top: 9%;
                        margin-left: -11px;
                        margin-right: 30px;  white-space: nowrap;
                        
                         text-overflow: clip;"
                       
                       class="custom-list-title fw-bold text-gray-800 mb-1" >
                            {{session()->get('userName')}}
                        </div>
                        
                    </button>
                    <!--begin::Menu 3-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3 " data-kt-menu="true" data-popper-placement="bottom-end" style="z-index: 105; position: fixed; inset: 0px auto auto 0px; margin: 0px; transform: translate(1090px, 177px);">
                        <!--begin::Heading-->
                        <div class="menu-item px-3">
                            <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">{{session()->get('userName')}}</div>
                        </div>
                        <!--end::Heading-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            @if(session()->get('userType')=='admin')
                            <a href="{{url('profile'). '/' .session()->get('userId')}}" class="menu-link px-3">My Profile</a>
                            @elseif(session()->get('userType')=='customer')
                            <a href="{{url('customer_profile'). '/' .session()->get('userId')}}" class="menu-link px-3">My Profile</a>
                            @elseif(session()->get('userType')=='contractor')
                            <a href="{{url('contractor_profile'). '/' .session()->get('userId')}}" class="menu-link px-3">My Profile</a>
                            @else
                            <a href="{{url('guard_profile'). '/' .session()->get('userId')}}" class="menu-link px-3">My Profile</a>
                            @endif
                        </div>
                        
                        <div class="menu-item px-3">
                            @if(session()->get('userType')=='admin')
                            <a href="{{url('do_logout')}}" class="menu-link px-3">Logout</a>
                            @elseif(session()->get('userType')=='customer')
                            <a href="{{url('do_logout_customer')}}" class="menu-link px-3">Logout</a>
                            @elseif(session()->get('userType')=='contractor')
                            <a href="{{url('do_logout_contractor')}}" class="menu-link px-3">Logout</a>
                            @else
                            <a href="{{url('do_logout_guard')}}" class="menu-link px-3">Logout</a>
                            @endif
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                       
                    </div>
                    <!--end::Menu 3-->
                  
                </div>
             
            </div>
        </div>
        <!--end::Toolbar wrapper-->
        
   

 
        @stop