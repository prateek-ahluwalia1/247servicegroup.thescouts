
@section('pageCss')
<base href="../../../">
<meta charset="utf-8" />
<title>{{ config('custom.title');}}</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<link rel="canonical" href="Https://preview.keenthemes.com/metronic8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<!-- <link rel="shortcut icon" href="{{ asset('')}}media/logos/favicon.ico" /> -->
<!--begin::Fonts-->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700" />
<!--end::Fonts-->
<!--begin::Page Vendor Stylesheets(used by this page)-->
<link href="{{ asset('')}}plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
<!--end::Page Vendor Stylesheets-->
<!--begin::Global Stylesheets Bundle(used by all pages)-->
<link href="{{ asset('')}}plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
<link href="{{ asset('')}}css/style.bundle.css" rel="stylesheet" type="text/css" />
<!--begin::Wrapper-->
<style>
   .switch {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 24px;
}

.switch input {display:none;}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #eff2f5;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 15px;
  width: 15px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #d99f23;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(28px);
  -ms-transform: translateX(28px);
  transform: translateX(28px);
}

/*------ ADDED CSS ---------*/
.on
{
  display: none;
}

.on, .off
{
  color: white;
  position: absolute;
  transform: translate(-60%,-60%);
  top: 55%;
  left: 58%;
  font-size: 8px;
  font-family: Verdana, sans-serif;
}

input:checked+ .slider .on
{display: block;}

input:checked + .slider .off
{display: none;}

/*--------- END --------*/

/* Rounded sliders */
.slider.round {
  border-radius: 24px;
}

.slider.round:before {
  border-radius: 50%;}
  .button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 16px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  transition-duration: 0.4s;
  cursor: pointer;
}



.button2 {
    border-radius: 13px;
    margin-left: 274px;
  background-color: white; 
  color: black; 
  border: 2px solid #d99f23;
}

.button2:hover {
  background-color: #d99f23;
  color: white;
}
.table td:first-child, .table th:first-child, .table tr:first-child {
    padding-left: 100px;!important
}

    </style>
<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
    <!--begin::Header-->
    <div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header"
        data-kt-sticky-offset="{default: '200px', lg: '300px'}">
        <!--begin::Container-->
        <div class="container d-flex align-items-center justify-content-between" id="kt_header_container">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-2 pb-2 pb-lg-0"
                data-kt-swapper="true" data-kt-swapper-mode="prepend"
                data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
                <!--begin::Heading-->
                @foreach($bussinesss as $data)
                <h1 class="text-dark fw-bolder my-0 fs-2">{{$data->title}}</h1>
                @endforeach
                <!--end::Heading-->
            </div>
            <!--end::Page title=-->
            <!--begin::Wrapper-->
            <div class="d-flex d-lg-none align-items-center ms-n2 me-2">
                <!--begin::Aside mobile toggle-->
                <div class="btn btn-icon btn-active-icon-primary" id="kt_aside_toggle">
                    <!--begin::Svg Icon | path: icons/duotone/Text/Menu.svg-->
                    <span class="svg-icon svg-icon-2x">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <rect fill="#000000" x="4" y="5" width="16" height="3" rx="1.5" />
                                <path
                                    d="M5.5,15 L18.5,15 C19.3284271,15 20,15.6715729 20,16.5 C20,17.3284271 19.3284271,18 18.5,18 L5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 Z M5.5,10 L18.5,10 C19.3284271,10 20,10.6715729 20,11.5 C20,12.3284271 19.3284271,13 18.5,13 L5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 Z"
                                    fill="#000000" opacity="0.3" />
                            </g>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Aside mobile toggle-->
                <!--begin::Logo-->
             
                <!--end::Logo-->
            </div>
            <!--end::Wrapper-->
            {{-- @include('layout.toolbar')
            @yield('toolbar') --}}
            <a href="{{url('bussiness_do_logout')}}" class="btn-primary btn text-end">Log out</a>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Header-->
    <!--begin::Content-->
    {{-- {{dd(Session::get('config_recods'))}} --}}

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Container-->
        <div class="container" id="kt_content_container">
            <!--begin::Card-->
            @if(session()->has('message'))
            <div id="message_hide" class="alert alert-success">
                {{ session()->get('message') }}
            </div>
            @endif
            <a style="margin-bottom: 20px;text-decoration: none;" href="{{url('bussiness_management')}}" class="btn-primary btn text-end">Bussiness Management</a>

            <div class="card">
                <div class="card-body pt-0">
                    @foreach(Session::get('config_recods') as $a)
                    {{-- {{dd($a->job_roster)}} --}}
                    <form method="POST" action="{{url('bussiness_management_config_check')}}">
                        @csrf
                            @foreach($bussinesss as $id)
                            <input type="hidden" name="business_data_id" value="{{$id->id}}">
                            <input type="hidden" name="navigation_bar" value="navigation_bar">
                            @endforeach
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="table">
                        <h4 style="margin-top: 14px;color: #b5b5c3;">Navigation Bar</h4> 
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-">Items</th>
                                <th class="min-w-">Action</th>
                                </tr>
                                <tr>
                                    <td>Dashboard</td>
                                    <td>
                                        <label class="switch">
                                            <input name="dashboard" type="checkbox" @if(isset($a->dashboard) && $a->dashboard == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Guards Login</td>
                                    <td>
                                        <label class="switch">
                                            <input name="guards_login" type="checkbox" @if(isset($a->guards_login) && $a->guards_login == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Customer Login</td>
                                    <td>
                                        <label class="switch">
                                            <input name="customer_login" type="checkbox" @if(isset($a->customer_login) && $a->customer_login == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Contractor Login</td>
                                    <td>
                                        <label class="switch">
                                            <input name="contractor_login" type="checkbox" @if(isset($a->contractor_login) && $a->contractor_login == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Message Icon</td>
                                    <td>
                                        <label class="switch">
                                            <input name="message_icon" type="checkbox" @if(isset($a->message_icon) && $a->message_icon == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Notification Icon</td>
                                    <td>
                                        <label class="switch">
                                            <input name="notification_icon" type="checkbox" @if(isset($a->notification_icon) && $a->notification_icon == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Job Roster</td>
                                    <td>
                                        <label class="switch">
                                            <input name="job_roster" type="checkbox" @if(isset($a->job_roster) && $a->job_roster == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>TimeSheet</td>
                                    <td>
                                        <label class="switch">
                                            <input name="time_sheet" type="checkbox" @if(isset($a->time_sheet) && $a->time_sheet == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Job Tracker</td>
                                    <td>
                                        <label class="switch">
                                            <input name="job_tracker" type="checkbox" @if(isset($a->job_tracker) && $a->job_tracker == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Leave Management</td>
                                    <td>
                                        <label class="switch">
                                            <input name="leave_management" type="checkbox" @if(isset($a->leave_management) &&  $a->leave_management == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <!--end::Table row-->
                                <tr>
                                    <td>Time Clock</td>
                                    <td>
                                        <label class="switch">
                                            <input name="time_clock" type="checkbox"  @if(isset($a->time_clock) && $a->time_clock == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Log User Activities</td>
                                    <td>
                                        <label class="switch">
                                            <input name="log_user_activities" type="checkbox" @if(isset($a->log_user_activities) && $a->log_user_activities == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Guard License</td>
                                    <td>
                                        <label class="switch">
                                            <input name="guard_license" type="checkbox" @if(isset($a->guard_license) && $a->guard_license == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Site List</td>
                                    <td>
                                        <label class="switch">
                                            <input name="site_list" type="checkbox" @if(isset($a->site_list) && $a->site_list == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Administrator</td>
                                    <td>
                                        <label class="switch">
                                            <input name="administrator" type="checkbox" @if(isset($a->administrator) && $a->administrator == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td> Customer </td>
                                    <td>
                                        <label class="switch">
                                            <input name="customer" type="checkbox" @if(isset($a->customer) && $a->customer == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Contractor</td>
                                    <td>
                                        <label class="switch">
                                            <input name="contractor" type="checkbox" @if(isset($a->contractor) && $a->contractor == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Guards</td>
                                    <td>
                                        <label class="switch">
                                            <input name="guards" type="checkbox" @if(isset($a->guards) && $a->guards == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Permissions</td>
                                    <td>
                                        <label class="switch">
                                            <input name="permissions" type="checkbox" @if(isset($a->permissions) && $a->permissions == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Chat</td>
                                    <td>
                                        <label class="switch">
                                            <input name="chat" type="checkbox" @if(isset($a->chat) && $a->chat == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Announcements |  Induction</td>
                                    <td>
                                        <label class="switch">
                                            <input name="announcements_induction" type="checkbox" @if(isset($a->announcements_induction) && $a->announcements_induction == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tasks Report</td>
                                    <td>
                                        <label class="switch">
                                            <input name="tasks_report" type="checkbox" @if(isset($a->tasks_report) && $a->tasks_report == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Contractor Report</td>
                                    <td>
                                        <label class="switch">
                                            <input name="contractor_report" type="checkbox" @if(isset($a->contractor_report) && $a->contractor_report == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td>Report</td>
                                    <td>
                                        <label class="switch">
                                            <input name="report" type="checkbox" @if(isset($a->report) && $a->report == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Invoice Report</td>
                                    <td>
                                        <label class="switch">
                                            <input name="invoice_report" type="checkbox" @if(isset($a->invoice_report) && $a->invoice_report == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Hour Report</td>
                                    <td>
                                        <label class="switch">
                                            <input name="hour_report" type="checkbox" @if(isset($a->hour_report) && $a->hour_report == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Quick Paysheet</td>
                                    <td>
                                        <label class="switch">
                                            <input name="quick_Paysheet" type="checkbox" @if(isset($a->quick_Paysheet) && $a->quick_Paysheet == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Incident Report Page</td>
                                    <td>
                                        <label class="switch">
                                            <input name="incident_report_page" type="checkbox" @if(isset($a->incident_report_page) && $a->incident_report_page == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Complete Paysheet</td>
                                    <td>
                                        <label class="switch">
                                            <input name="complete_paysheet" type="checkbox" @if(isset($a->complete_paysheet) && $a->complete_paysheet == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Division Consolidation</td>
                                    <td>
                                        <label class="switch">
                                            <input name="division_consolidation" type="checkbox" @if(isset($a->division_consolidation) && $a->division_consolidation == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Charge Rates</td>
                                    <td>
                                        <label class="switch">
                                            <input name="charge_rates" type="checkbox" @if(isset($a->charge_rates) && $a->charge_rates == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Pay Rates</td>
                                    <td>
                                        <label class="switch">
                                            <input name="pay_rates" type="checkbox" @if(isset($a->pay_rates) && $a->pay_rates == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>
                                        <label class="switch">
                                            <input name="email" type="checkbox" @if(isset($a->email) && $a->email == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>PH Settings</td>
                                    <td>
                                        <label class="switch">
                                            <input name="ph_settings" type="checkbox" @if(isset($a->ph_settings) && $a->ph_settings == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Color Settings</td>
                                    <td>
                                        <label class="switch">
                                            <input name="color_settings" type="checkbox" @if(isset($a->color_settings) && $a->color_settings == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Basics</td>
                                    <td>
                                        <label class="switch">
                                            <input name="basics" type="checkbox" @if(isset($a->basics) && $a->basics == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Features</td>
                                    <td>
                                        <label class="switch">
                                            <input name="features" type="checkbox" @if(isset($a->features) && $a->features == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Notifications</td>
                                    <td>
                                        <label class="switch">
                                            <input name="notifications" type="checkbox" @if(isset($a->notifications) && $a->notifications == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Each Guard Own Payrates</td>
                                    <td>
                                        <label class="switch">
                                            <input name="own_payrates" type="checkbox" @if(isset($a->own_payrates) && $a->own_payrates == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>

                                 <tr>
                                    <td>Categorized Payrate</td>
                                    <td>
                                        <label class="switch">
                                            <input name="categorized_payrates" type="checkbox" @if(isset($a->categorized_payrates) && $a->categorized_payrates == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td>Signin-Out Report</td>
                                    <td>
                                        <label class="switch">
                                            <input name="signin_out_report" type="checkbox" @if(isset($a->signin_out_report) && $a->signin_out_report == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Audit Report</td>
                                    <td>
                                        <label class="switch">
                                            <input name="audit_report" type="checkbox" @if(isset($a->audit_report) && $a->audit_report == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="text-gray-600 fw-bold">
                            <!--begin::Table row-->

                            <!--end::Table row-->
                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <button style="margin-left: 43%;" class="button button2">Submit</button>
                    </form>
                    @endforeach

                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
            {{-- waqas work start --}}
            
            <div class="card" style="margin-top: 38px;">
                <div class="card-body pt-0">
                    @foreach(Session::get('config_recods1') as $a1)
                    {{-- {{dd($a->job_roster)}} --}}
                    <form method="POST" action="{{url('bussiness_management_config_check')}}">
                        @csrf
                            @foreach($bussinesss as $id)
                            <input type="hidden" name="business_data_id" value="{{$id->id}}">
                            <input type="hidden" name="navigation_bar" value="job_roster_navigation_bar">
                            @endforeach
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="table">
                        <h4 style="margin-top: 14px;color: #b5b5c3;">Job Roster</h4> 
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-">Items</th>
                                <th class="min-w-">Action</th>
                                </tr>
                                
                                
                                <tr>
                                    <td>Select State</td>
                                    <td>
                                        <label class="switch">
                                            <input name="select_state" type="checkbox" @if(isset($a1->select_state) && $a1->select_state == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Select Customer</td>
                                    <td>
                                        <label class="switch">
                                            <input name="select_customer" type="checkbox" @if(isset($a1->select_customer) && $a1->select_customer == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Select Sites</td>
                                    <td>
                                        <label class="switch">
                                            <input name="select_sites" type="checkbox" @if(isset($a1->select_sites) && $a1->select_sites == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                {{-- today working start --}}
                                <tr>
                                    <td>Job Roster Filter</td>
                                    <td>
                                        <label class="switch">
                                            <input name="job_roster_filter" type="checkbox" @if(isset($a1->job_roster_filter) && $a1->job_roster_filter == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Un-published Site</td>
                                    <td>
                                        <label class="switch">
                                            <input name="un_publish_site" type="checkbox" @if(isset($a1->un_publish_site) && $a1->un_publish_site == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Payroll</td>
                                    <td>
                                        <label class="switch">
                                            <input name="payroll" type="checkbox" @if(isset($a1->payroll) && $a1->payroll == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Job Instrcutions File</td>
                                    <td>
                                        <label class="switch">
                                            <input name="job_instrcution_file" type="checkbox" @if(isset($a1->job_instrcution_file) && $a1->job_instrcution_file == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Coordinates</td>
                                    <td>
                                        <label class="switch">
                                            <input name="coordinates" type="checkbox" @if(isset($a1->coordinates) && $a1->coordinates == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Copy this to Current Week</td>
                                    <td>
                                        <label class="switch">
                                            <input name="copy_current_week" type="checkbox" @if(isset($a1->copy_current_week) && $a1->copy_current_week == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Copy Shifts</td>
                                    <td>
                                        <label class="switch">
                                            <input name="copy_shifts" type="checkbox" @if(isset($a1->copy_shifts) && $a1->copy_shifts == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Clear Week</td>
                                    <td>
                                        <label class="switch">
                                            <input name="clear_week" type="checkbox" @if(isset($a1->clear_week) && $a1->clear_week == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Unpublish Week</td>
                                    <td>
                                        <label class="switch">
                                            <input name="unpublish_week" type="checkbox" @if(isset($a1->unpublish_week) && $a1->unpublish_week == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Unassign Week</td>
                                    <td>
                                        <label class="switch">
                                            <input name="unassign_week" type="checkbox" @if(isset($a1->unassign_week) && $a1->unassign_week == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Add Multiple Shifts</td>
                                    <td>
                                        <label class="switch">
                                            <input name="add_multiple_shifts" type="checkbox" @if(isset($a1->add_multiple_shifts) && $a1->add_multiple_shifts == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Sign In Detail</td>
                                    <td>
                                        <label class="switch">
                                            <input name="sign_in_detail" type="checkbox" @if(isset($a1->sign_in_detail) && $a1->sign_in_detail == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Sign Out Detail</td>
                                    <td>
                                        <label class="switch">
                                            <input name="sign_out_detail" type="checkbox" @if(isset($a1->sign_out_detail) && $a1->sign_out_detail == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Break Detail</td>
                                    <td>
                                        <label class="switch">
                                            <input name="break_detail" type="checkbox" @if(isset($a1->break_detail) && $a1->break_detail == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Gree Call</td>
                                    <td>
                                        <label class="switch">
                                            <input name="gree_call" type="checkbox" @if(isset($a1->gree_call) && $a1->gree_call == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Welfare Call</td>
                                    <td>
                                        <label class="switch">
                                            <input name="welfare_call" type="checkbox" @if(isset($a1->welfare_call) && $a1->welfare_call == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tracker</td>
                                    <td>
                                        <label class="switch">
                                            <input name="tracker" type="checkbox" @if(isset($a1->tracker) && $a1->tracker == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Incident Report</td>
                                    <td>
                                        <label class="switch">
                                            <input name="incident_report" type="checkbox" @if(isset($a1->incident_report) && $a1->incident_report == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Shift Task</td>
                                    <td>
                                        <label class="switch">
                                            <input name="shift_task" type="checkbox" @if(isset($a1->shift_task) && $a1->shift_task == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Shift Activity</td>
                                    <td>
                                        <label class="switch">
                                            <input name="shift_activity" type="checkbox" @if(isset($a1->shift_activity) && $a1->shift_activity == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Operation Notes</td>
                                    <td>
                                        <label class="switch">
                                            <input name="operation_notes" type="checkbox" @if(isset($a1->operation_notes) && $a1->operation_notes == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Create Shift Button</td>
                                    <td>
                                        <label class="switch">
                                            <input name="create_shift_button" type="checkbox" @if(isset($a1->create_shift_button) && $a1->create_shift_button == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Shifts Colors</td>
                                    <td>
                                        <label class="switch">
                                            <input name="shift_colors" type="checkbox" @if(isset($a1->shift_colors) && $a1->shift_colors == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Site Type</td>
                                    <td>
                                        <label class="switch">
                                            <input name="site_type" type="checkbox" @if(isset($a1->site_type)  && $a1->site_type == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Site Trained</td>
                                    <td>
                                        <label class="switch">
                                            <input name="site_trained" type="checkbox" @if(isset($a1->site_trained) && $a1->site_trained == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Breaks</td>
                                    <td>
                                        <label class="switch">
                                            <input name="breaks" type="checkbox" @if(isset($a1->breaks) && $a1->breaks == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Welfare Calls</td>
                                    <td>
                                        <label class="switch">
                                            <input name="welfare_calls" type="checkbox" @if(isset($a1->welfare_calls) && $a1->welfare_calls == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Site Hours</td>
                                    <td>
                                        <label class="switch">
                                            <input name="site_hours" type="checkbox" @if(isset($a1->site_hours) && $a1->site_hours == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Charge Rates And Level</td>
                                    <td>
                                        <label class="switch">
                                            <input name="charge_rates_and_level" type="checkbox" @if(isset($a1->charge_rates_and_level) && $a1->charge_rates_and_level == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Signin Radius</td>
                                    <td>
                                        <label class="switch">
                                            <input name="signin_radius" type="checkbox" @if(isset($a1->signin_radius) && $a1->signin_radius == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Radius Alert</td>
                                    <td>
                                        <label class="switch">
                                            <input name="radius_alert" type="checkbox" @if(isset($a1->radius_alert) && $a1->radius_alert == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Job Instrcutions</td>
                                    <td>
                                        <label class="switch">
                                            <input name="job_instrcutions" type="checkbox" @if(isset($a1->job_instrcutions) && $a1->job_instrcutions == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>SOS Phone</td>
                                    <td>
                                        <label class="switch">
                                            <input name="sos_phone" type="checkbox" @if(isset($a1->sos_phone) && $a1->sos_phone == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tasks</td>
                                    <td>
                                        <label class="switch">
                                            <input name="tasks" type="checkbox" @if(isset($a1->tasks) && $a1->tasks == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Start End Date</td>
                                    <td>
                                        <label class="switch">
                                            <input name="start_end_date" type="checkbox" @if(isset($a1->start_end_date) &&  $a1->start_end_date == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Three Dots For Multiple Shifts</td>
                                    <td>
                                        <label class="switch">
                                            <input name="three_dots_shifts" type="checkbox" @if(isset($a1->three_dots_shifts) && $a1->three_dots_shifts == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>View By Guards</td>
                                    <td>
                                        <label class="switch">
                                            <input name="view_guards" type="checkbox" @if(isset($a1->view_guards) && $a1->view_guards == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Shift Site Name</td>
                                    <td>
                                        <label class="switch">
                                            <input name="shift_site_name" type="checkbox" @if(isset($a1->shift_site_name) && $a1->shift_site_name == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Shift Guard Name</td>
                                    <td>
                                        <label class="switch">
                                            <input name="shift_guard_name" type="checkbox" @if(isset($a1->shift_guard_name) && $a1->shift_guard_name == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Shift Available Guards</td>
                                    <td>
                                        <label class="switch">
                                            <input name="shift_available_guard" type="checkbox" @if(isset($a1->shift_available_guard) && $a1->shift_available_guard == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Shift Paybale</td>
                                    <td>
                                        <label class="switch">
                                            <input name="shift_paybale" type="checkbox" @if(isset($a1->shift_paybale) && $a1->shift_paybale == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Paid by</td>
                                    <td>
                                        <label class="switch">
                                            <input name="paid_by" type="checkbox" @if(isset($a1->paid_by) && $a1->paid_by == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Shift Start Time</td>
                                    <td>
                                        <label class="switch">
                                            <input name="shift_start_time" type="checkbox" @if(isset($a1->shift_start_time) && $a1->shift_start_time == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Shift End Time</td>
                                    <td>
                                        <label class="switch">
                                            <input name="shift_end_time" type="checkbox" @if(isset($a1->shift_end_time) && $a1->shift_end_time == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Travel Time</td>
                                    <td>
                                        <label class="switch">
                                            <input name="travel_time" type="checkbox" @if(isset($a1->travel_time)  && $a1->travel_time == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                {{-- today working ending --}}
                                <tr>
                                    <td>Action</td>
                                    <td>
                                        <label class="switch">
                                            <input name="action" type="checkbox" @if(isset($a1->action) && $a1->action == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Publish</td>
                                    <td>
                                        <label class="switch">
                                            <input name="publish" type="checkbox" @if(isset($a1->publish) && $a1->publish == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Add Site</td>
                                    <td>
                                        <label class="switch">
                                            <input name="add_site" type="checkbox" @if(isset($a1->add_site) && $a1->add_site == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Ad-hoc Shift</td>
                                    <td>
                                        <label class="switch">
                                            <input name="ad_shift" type="checkbox" @if(isset($a1->ad_shift) && $a1->ad_shift == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Report</td>
                                    <td>
                                        <label class="switch">
                                            <input name="report" type="checkbox" @if(isset($a1->report) && $a1->report == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Add Guards</td>
                                    <td>
                                        <label class="switch">
                                            <input name="add_guards" type="checkbox" @if(isset($a1->add_guards) && $a1->add_guards == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Send SMS</td>
                                    <td>
                                        <label class="switch">
                                            <input name="sms" type="checkbox" @if(isset($a1->sms) && $a1->sms == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>

<tr>
                                    <td>Send Email</td>
                                    <td>
                                        <label class="switch">
                                            <input name="email" type="checkbox" @if(isset($a1->email) && $a1->email == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Rollover this week</td>
                                    <td>
                                        <label class="switch">
                                            <input name="rollover_this_week" type="checkbox" @if(isset($a1->rollover_this_week) && $a1->rollover_this_week == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Shift Status</td>
                                    <td>
                                        <label class="switch">
                                            <input name="shift_status" type="checkbox" @if(isset($a1->shift_status) && $a1->shift_status == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Continuation</td>
                                    <td>
                                        <label class="switch">
                                            <input name="continuation" type="checkbox" @if(isset($a1->continuation) && $a1->continuation == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Break Management</td>
                                    <td>
                                        <label class="switch">
                                            <input name="break_management" type="checkbox" @if(isset($a1->break_management) && $a1->break_management == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Shift operational Notes icon and color</td>
                                    <td>
                                        <label class="switch">
                                            <input name="operational_notes" type="checkbox" @if(isset($a1->operational_notes) && $a1->operational_notes == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>

                                 <tr>
                                    <td>Covid Marshal</td>
                                    <td>
                                        <label class="switch">
                                            <input name="covid_marshal" type="checkbox" @if(isset($a1->covid_marshal) && $a1->covid_marshal == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Custom Payrates</td>
                                    <td>
                                        <label class="switch">
                                            <input name="custom_payrates" type="checkbox" @if(isset($a1->custom_payrates) && $a1->custom_payrates == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Documents Bypass</td>
                                    <td>
                                        <label class="switch">
                                            <input name="documents_bypass" type="checkbox" @if(isset($a1->documents_bypass) && $a1->documents_bypass == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                               
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="text-gray-600 fw-bold">
                            <!--begin::Table row-->

                            <!--end::Table row-->
                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <button style="margin-left: 43%;" class="button button2">Submit</button>
                    </form>
                    @endforeach

                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            {{-- waqas work ending --}}
            {{-- guards checkbox start --}}
            <div class="card" style="margin-top: 38px;">
                <div class="card-body pt-0">
                    @foreach(Session::get('config_recods2') as $a1)
                    {{-- {{dd($a->job_roster)}} --}}
                    <form method="POST" action="{{url('bussiness_management_config_check')}}">
                        @csrf
                            @foreach($bussinesss as $id)
                            <input type="hidden" name="business_data_id" value="{{$id->id}}">
                            <input type="hidden" name="navigation_bar" value="guards_navigation_bar">
                            @endforeach
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="table">
                        <h4 style="margin-top: 14px;color: #b5b5c3;">Guards</h4> 
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-">Items</th>
                                <th class="min-w-">Action</th>
                                </tr>
                                <tr>
                                    <td>Active Guards</td>
                                    <td>
                                        <label class="switch">
                                            <input name="active_guards" type="checkbox" @if(isset($a1->active_guards) && $a1->active_guards == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Inactive Guards</td>
                                    <td>
                                        <label class="switch">
                                            <input name="inactive_guards" type="checkbox" @if(isset($a1->inactive_guards) && $a1->inactive_guards == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>New Guards</td>
                                    <td>
                                        <label class="switch">
                                            <input name="new_guards" type="checkbox" @if(isset($a1->new_guards) && $a1->inactive_guards == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Pending Guards</td>
                                    <td>
                                        <label class="switch">
                                            <input name="pending_guards" type="checkbox" @if(isset($a1->pending_guards) && $a1->pending_guards == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Deleted Guards</td>
                                    <td>
                                        <label class="switch">
                                            <input name="deleted_guards" type="checkbox" @if(isset($a1->deleted_guards) && $a1->deleted_guards == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Add Guards</td>
                                    <td>
                                        <label class="switch">
                                            <input name="add_guards" type="checkbox" @if(isset($a1->add_guards) && $a1->add_guards == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Site Trained</td>
                                    <td>
                                        <label class="switch">
                                            <input name="site_trained" type="checkbox" @if(isset($a1->site_trained) && $a1->site_trained == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Guard Uniform</td>
                                    <td>
                                        <label class="switch">
                                            <input name="guard_uniform" type="checkbox" @if(isset($a1->guard_uniform) && $a1->guard_uniform == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Guard Work Limitation</td>
                                    <td>
                                        <label class="switch">
                                            <input name="guard_work_limitation" type="checkbox" @if(isset($a1->guard_work_limitation) && $a1->guard_work_limitation == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Leave Management</td>
                                    <td>
                                        <label class="switch">
                                            <input name="leave_management" type="checkbox" @if(isset($a1->leave_management) && $a1->leave_management == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Include Casual Guards In Leave Management</td>
                                    <td>
                                        <label class="switch">
                                            <input name="casual_guards" type="checkbox" @if(isset($a1->casual_guards) && $a1->casual_guards == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Select Customer</td>
                                    <td>
                                        <label class="switch">
                                            <input name="select_customer" type="checkbox" @if(isset($a1->select_customer) && $a1->select_customer == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Gender</td>
                                    <td>
                                        <label class="switch">
                                            <input name="gender" type="checkbox" @if(isset($a1->gender) && $a1->gender == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Dob</td>
                                    <td>
                                        <label class="switch">
                                            <input name="dob" type="checkbox" @if(isset($a1->dob) && $a1->dob == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Postal Code</td>
                                    <td>
                                        <label class="switch">
                                            <input name="postal_code" type="checkbox" @if(isset($a1->postal_code) && $a1->postal_code == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>State</td>
                                    <td>
                                        <label class="switch">
                                            <input name="state" type="checkbox" @if(isset($a1->state) && $a1->state == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>City</td>
                                    <td>
                                        <label class="switch">
                                            <input name="city" type="checkbox" @if(isset($a1->city) && $a1->city == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Suburb</td>
                                    <td>
                                        <label class="switch">
                                            <input name="suburb" type="checkbox" @if(isset($a1->suburb) && $a1->suburb == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>
                                        <label class="switch">
                                            <input name="address" type="checkbox" @if(isset($a1->address) && $a1->address == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Guard Type</td>
                                    <td>
                                        <label class="switch">
                                            <input name="guard_type" type="checkbox" @if(isset($a1->guard_type) && $a1->guard_type == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Password</td>
                                    <td>
                                        <label class="switch">
                                            <input name="password" type="checkbox" @if(isset($a1->password) && $a1->password == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>
                                        <label class="switch">
                                            <input name="email" type="checkbox" @if(isset($a1->email) && $a1->password == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Profile image</td>
                                    <td>
                                        <label class="switch">
                                            <input name="profile_image" type="checkbox" @if(isset($a1->profile_image) && $a1->profile_image == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Coordinates</td>
                                    <td>
                                        <label class="switch">
                                            <input name="coordinates" type="checkbox" @if(isset($a1->coordinates) && $a1->coordinates == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Emergency Contact Name</td>
                                    <td>
                                        <label class="switch">
                                            <input name="emergency_contact_name" type="checkbox" @if(isset($a1->emergency_contact_name) && $a1->emergency_contact_name == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                
                               <!--  <tr>
                                    <td>Emergency Contact Phone</td>
                                    <td>
                                        <label class="switch">
                                            <input name="emergency_contact_phone" type="checkbox" @if(isset($a1->emergency_contact_phone) && $a1->emergency_contact_phone == '1') checked @endif>
                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                            </div>
                                        </label>
                                    </td>
                                </tr> -->
                               
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="text-gray-600 fw-bold">
                            <!--begin::Table row-->

                            <!--end::Table row-->
                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <button style="margin-left: 43%;" class="button button2">Submit</button>
                    </form>
                    @endforeach

                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            {{-- waqas work ending --}}
            {{-- guards checkbox end --}}
        </div>
        <!--end::Container-->
    </div>
  
        <!--end::Modal dialog-->
    </div>


    <script src="{{ asset('')}}plugins/global/plugins.bundle.js"></script>
    <script src="{{ asset('')}}js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Page Vendors Javascript(used by this page)-->
    <script src="{{ asset('')}}plugins/custom/datatables/datatables.bundle.js"></script>
    <!--end::Page Vendors Javascript-->
    <!--begin::Page Custom Javascript(used by this page)-->
    <script src="{{ asset('')}}js/custom/apps/user-management/users/list/table.js"></script>
    <script src="{{ asset('')}}js/custom/apps/user-management/users/list/export-users.js"></script>
    <script src="{{ asset('')}}js/custom/apps/user-management/users/list/add.js"></script>
    <script src="{{ asset('')}}js/custom/widgets.js"></script>
    <script src="{{ asset('')}}js/custom/apps/chat/chat.js"></script>
    <script src="{{ asset('')}}js/custom/modals/create-app.js"></script>
    <script src="{{ asset('')}}js/custom/modals/upgrade-plan.js"></script>
    <!--end::Page Custom Javascript-->
    <!--end::Javascript-->
    <script>
        $('#message_hide').delay(5000).fadeOut('slow');
    </script>




