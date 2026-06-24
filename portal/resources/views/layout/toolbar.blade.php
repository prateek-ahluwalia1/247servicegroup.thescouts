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


            <!--begin::Quick links-->
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