@extends('layout.app')
@extends('layout.sidebar')
@extends('layout.footer')

@section('pageCss')
<base href="../../../">
    <meta charset="utf-8" />
    <title>{{ config('custom.title');}}</title>
            <meta name="keywords" content="{{ config('custom.title')}}" />
    <link rel="canonical" href="Https://preview.keenthemes.com/metronic8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- <link rel="shortcut icon" href="{{asset('')}}media/logos/favicon.ico" /> -->
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{asset('')}}plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('')}}css/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    <link href="{{asset('')}}plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{asset('')}}js/datetimepicker/build/jquery.datetimepicker.min.css" />

    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">


<style type="text/css">
/* .sorting_asc{
background: none !important;
} */
/* .sorting_disabled{
display: none;
} */
/* .sorting_asc{
display: none;
} */
tbody, td, tfoot, th, thead, tr {
border-top: 1px solid #F1416D;
}

table.dataTable thead .sorting{
 background: none !important;
}
.text-dark{
margin-top: 2px;
}

td.details-control {
background: url('{{asset('')}}media/icons/duotone/Navigation/Angle-right.svg') no-repeat center center;
cursor: pointer;
}
tr.shown td.details-control {
background: url('{{asset('')}}media/icons/duotone/Navigation/Angle-right.svg') no-repeat center center;
}
/*expand*/
tr.hide-table-padding td {
padding: 0;
}

.expand-button {
position: relative;
}

.accordion-toggle .expand-button:after
{
position: absolute;
left:.75rem;
top: 50%;
transform: translate(0, -50%);
content: '-';
}
.accordion-toggle.collapsed .expand-button:after
{
content: '+';
}
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {
    background-color: #ddd;
    color:#d99f23;
}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #d99f23;
  color: white;
}
.font_size{
  font-weight: 550;
}
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
</style>


@stop
<!--end::Head-->
<!--begin::Body-->
@section('content')

@section('content')

<!--begin::Form-->
                    <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <!--begin::Header-->
                <div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
                    <!--begin::Container-->
                    <div class="container d-flex align-items-center justify-content-between" id="kt_header_container">
                        <!--begin::Page title-->
                        <div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-2 pb-2 pb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
                            <!--begin::Heading-->
                            <h1 class="text-dark fw-bolder my-0 fs-2">{{config('custom.guard')}} License Details</h1>
                            <!--end::Heading-->
                        </div>
                        <!--end::Page title=-->
                        <!--begin::Wrapper-->
                        <div class="d-flex d-lg-none align-items-center ms-n2 me-2">
                            <!--begin::Aside mobile toggle-->
                            <div class="btn btn-icon btn-active-icon-primary" id="kt_aside_toggle">
                                <!--begin::Svg Icon | path: icons/duotone/Text/Menu.svg-->
                                <span class="svg-icon svg-icon-2x">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <rect fill="#000000" x="4" y="5" width="16" height="3" rx="1.5" />
                                            <path d="M5.5,15 L18.5,15 C19.3284271,15 20,15.6715729 20,16.5 C20,17.3284271 19.3284271,18 18.5,18 L5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 Z M5.5,10 L18.5,10 C19.3284271,10 20,10.6715729 20,11.5 C20,12.3284271 19.3284271,13 18.5,13 L5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 Z" fill="#000000" opacity="0.3" />
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
                        @include('layout.toolbar')	
                        @yield('toolbar')
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Header-->
                <!--begin::Content-->
                <div class=" content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Container-->
                    <div class="container" id="kt_content_container">
                        <!--begin::Form-->
                        <form id="search-form" class="form" action="{{url('job_tracker/timesheet_search')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!--begin::Card-->
                            <div class="card mb-7">
                                <!--begin::Card body-->
                                <div class="card-body">
                                    <!--begin::Compact form-->
                                    <div class="d-flex align-items-center">
                                        <!--begin::Input group-->
      
                                        <!--end::Input group-->
                                        <!--begin:Action-->
                                        <div class="d-flex align-items-center">
                                            {{-- <button type="submit" class="btn btn-primary me-5">Search</button> --}}
                                            <div style="float:left;margin-left: 75px;">
                                                <div style="margin-top: 12px;" class="vac">                  
                                                <label class="switch">
                                                    <input type="checkbox"  name="vaccination" value="on" id="vaccination">
                                                    <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                                    </div>
                                                </label>
                                                </div>
                                                <div style="margin-top: 6px;">
                                                Vaccination
                                                </div>
                            
                                                <div style="margin-top: 12px;">                  
                                                    <label class="switch">
                                                        <input name="visa" id="visa" value="on" type="checkbox">
                                                        <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                                        </div>
                                                    </label>
                                                    </div>
                                                    <div style="margin-top: 6px;">
                                                    Visa
                                                    </div>
                                                    <div style="margin-top: 12px;">                  
                                                        <label class="switch">
                                                            <input name="passport" id="passport" value="on" type="checkbox">
                                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                                            </div>
                                                        </label>
                                                        </div>
                                                        <div style="margin-top: 6px;">
                                                        Passport
                                                        </div>
                            
                                                    <!-- <div style="margin-top: 12px;">                  
                                                        <label class="switch">
                                                            <input name="induction" id="induction" value="on" type="checkbox">
                                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                                            </div>
                                                        </label>
                                                        </div>
                                                        <div style="margin-top: 6px;">
                                                        Induction
                                                        </div> -->
                                                </div>
                            
                                                <div style="float:left;margin-left: 146px;">
                                                    <!-- <div style="margin-top: 12px;">                  
                                                    <label class="switch">
                                                        <input name="working_children" id="working_children" value="on" type="checkbox">
                                                        <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                                        </div>
                                                    </label>
                                                    </div>
                                                    <div style="margin-top: 6px;">
                                                    Working with Children
                                                    </div> -->
                                
                                                    
                                <div style="margin-top: 12px;">                  
                                                        <label class="switch">
                                                            <input name="driver_license" id="driver_license" value="on" type="checkbox">
                                                            <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                                            </div>
                                                        </label>
                                                        </div>
                                                        <div style="margin-top: 6px;">
                                                        Driver License
                                                        </div>
                                    
                                                        <div style="margin-top: 12px;">                  
                                                            <label class="switch">
                                                                <input name="citizenship" id="citizenship" value="on" type="checkbox">
                                                                <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                                                </div>
                                                            </label>
                                                            </div>
                                                            <div style="margin-top: 6px;">
                                                            Citizenship
                                                            </div>
                                                             <div style="margin-top: 12px;">                  
                                                            <label class="switch">
                                                                <input name="firstaid" id="firstaid" value="on" type="checkbox">
                                                                <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                                                </div>
                                                            </label>
                                                            </div>
                                                            <div style="margin-top: 6px;">
                                                            Firstaid
                                                            </div>
                                                    </div>
                            
                                                    <div style="float:left;margin-left: 146px;">
                                                        <div style="margin-top: 12px;">                  
                                                            <label class="switch">
                                                                <input name="security_license" id="security_license" value="on" type="checkbox">
                                                                <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                                                </div>
                                                            </label>
                                                            </div>
                                                            <div style="margin-top: 6px;">
                                                            Security License
                                                            </div>
                                                       
                                    
                                                            <div style="margin-top: 12px;">                  
                                                                <label class="switch">
                                                                    <input name="medicare" id="medicare" value="on" type="checkbox">
                                                                    <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                                                    </div>
                                                                </label>
                                                                </div>
                                                                <div style="margin-top: 6px;">
                                                                Medicare
                                                                </div>
                                                                <div style="margin-top: 12px;">                  
                                                                    <label class="switch">
                                                                        <input name="birth_certificate" id="birth_certificate" value="on" type="checkbox">
                                                                        <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                                                        </div>
                                                                    </label>
                                                                    </div>
                                                                    <div style="margin-top: 6px;">
                                                                    Birth Certificate
                                                                    </div>

                                                        </div>
                            
                                                        <div style="float:left;margin-left: 146px;">
                                                            
                                        
                                                            <!-- <div style="margin-top: 12px;">                  
                                                                <label class="switch">
                                                                    <input name="police_check" id="police_check" value="on" type="checkbox">
                                                                    <div class="slider round"  style="margin-top: 3px;margin-bottom: -2px;">
                                                                    </div>
                                                                </label>
                                                                </div>
                                                                <div style="margin-top: 6px;">
                                                                Police Check
                                                                </div> -->
                                        
                                                                
                                                            </div>
                                                            {{-- <button style="margin-bottom: 20px;text-decoration: none;margin-top: 69px;margin-left: 33px;" type="submit" id="search_data" class="btn-primary btn text-end">Search</button> --}}
                            
                                                
                                        </div>
                                        <!--end:Action-->
                                    </div>
                                    <!--end::Compact form-->
                                    <!--begin::Advance form-->
                                    <div style="display: none" id="kt_advanced_search_form">
                                        <!--begin::Separator-->
                                        <div class="separator separator-dashed mt-9 mb-6"></div>
                                        <!--end::Separator-->
                                        <!--begin::Row-->
                                        <div class="row ">
                                            <!--begin::Col-->
                                                <div class="mb-0">
                                                    <label class=" fs-6 form-label fw-bolder text-dark">From-To</label>
                                                    <input name ="from_to" class="form-control form-control-solid" placeholder="Pick date rage" id="kt_daterangepicker_1"/>
                                                </div>
                                                <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="">
                                                <!--begin::Row-->
                                                <div class="row ">
                                                    <!--begin::Col-->
                                                
                                                           <div id="div_states" class="col-lg-6 ">
                                                        <br>

                                                                      <label class="fs-6 form-label fw-bolder text-dark">Select State</label>
                                                                    <div class="fv-row mb-10 div_states">
                                                                    <select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1" id="State" name="State[]" class="_ac-customer-change">
                                                                        <!-- <option value="">Select Customer</option> -->
                                                                        <option value="Victoria" >Victoria</option>
                                                                        <option value="New South Wales">NSW</option>
                                                                        <option value="Queensland">Queensland</option>
                                                                        <option value="Tasmania">Tasmania</option>
                                                                        <option value="Western Australia">Western Australia</option>
                                                                        <option value="South Australia">South Australia</option>
                                                                        <option value="ACT">ACT</option>
                                                                        </select>
                                                                    </div>
                                                                    </div>
                                                                  <div class="col-lg-6 ">
                                                        <br>

                                                                      <label class="fs-6 form-label fw-bolder text-dark">Select Customer</label>
                                                                    <div class="fv-row mb-10">
                                                                    <select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1" id="customer_name" name="customer_name[]">
                                                                    
                                                                      {{-- @foreach($customers as $result)
                                                                    <option value="{{$result->id}}">{{$result->name}}</option>
                                                                    @endforeach --}}
                                                                    </select>
                                                                    </div>
                                                                    </div>

                                                        
                                            
                                                        <div id="div_guards" class="col-lg-6 ">
                                                                      <label class="fs-6 form-label fw-bolder text-dark">Select {{config('custom.guard')}}</label>
                                                                    <div class="fv-row mb-10">
                                                                        <select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1" id="guard_name" name="guard_name[]">
                                                                            
                                                                                      {{-- @foreach($guards as $result)
                                                                                    <option value="{{$result->id}}">{{$result->name}}</option>

                                                                                    @endforeach --}}
                                                                        </select>
                                                                    </div>
                                                                    </div>
                                                    <div class="col-lg-6" id="guard_type_div">
                                                        <label class="fs-6 form-label fw-bolder text-dark">Select {{config('custom.guard')}} Type</label>
                                                        <!--begin::Select-->
                                                        <!-- <select name="guard_type" id="guard_type" class="form-select form-select-solid" data-control="select2" data-placeholder="Type" data-hide-search="true"> -->
                                                             <select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1" name="guard_type[]" id="guard_type">
                                                            
                                                            <!-- <option value="">Select </option> -->
                                                            <option value="Direct">Direct </option>
                                                            <option value="Contractor">Contractor </option>

                                                            
                                                            
                                                        </select>
                                                        <!--end::Select-->
                                                    </div>
                                                    <!--end::Col-->
                                        
                                                            <div id="div_active" class="col-lg-6 ">
                                                                <label  class="fs-6 form-label fw-bolder text-dark">Select Active Sites</label>
                                                                <div  class="fv-row mb-10">
                                                                <select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1"  id="active_sites" name="address[]" data-placeholder="Select an option">
                                                                </select>
                                                                </div>
                                                                    
                                                                    </div>
                                                                        
                                                                    <div id="div_inactive" class="col-lg-6 ">
                                                                        <label  class="fs-6 form-label fw-bolder text-dark">Select Inactive Sites</label>
                                                                        <div  class="fv-row mb-10"><select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1" id="inactive_sites" name="address[]" data-control="select2" data-placeholder="Select an option">
                                                                        </select>
                                                                        </div>	
                                                                      </div>

                                                                                <!--begin::Col-->
                                                    <div class="col-lg-4">
                                                        <label class="fs-6 form-label fw-bolder text-dark">Jobs</label>
                                                        <!--begin::Radio group-->
                                            
                                                        <!--end::Radio group-->
                                                    </div>

                                                    <!--end::Col-->
                                            
                                                </div>
                                                <!--end::Row-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Row-->
                                        <!--begin::Row-->
                                        <div class="row g-8">
                                            <!--begin::Col-->
                                            <div class="col-xxl-7">
                                                
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="col-xxl-5">
                                                <!--begin::Row-->
                                                <div class="row g-8">
                                                    <!--begin::Col-->
                                                    
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    
                                                    <!--end::Col-->
                                                </div>
                                                <!--end::Row-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Row-->
                                    </div>
                                    <!--end::Advance form-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card-->
                        </form>
                        <!--end::Form-->
                            <!--begin::Toolbar-->
                            <div class="content d-flex flex-column flex-column-fluid">
                                <div class="">
                                                <div class="card" >
                                                <div class="card-body" style="padding: 0">
                                                           
                                                        {{-- cellpadding="0" cellspacing="0" border="0" class="display cell-border" style="width:100%" --}}
                                                        {{-- <div class="row">
                                                        <div class="container"> --}}
                                                        <div id="other-table" style="overflow-x: auto; max-width: 100%;">
                                                        <table id="customers" class="guard_data">
                                                            <thead style="background-color: white;" >
                                                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                                    <th class="min-w-">Name</th>
                                                                    {{-- <th class="min-w-">Vaccination</th>
                                                                    <th class="min-w-">Visa</th>
                                                                    <th class="min-w-">AMG Induction</th>
                                                                    <th class="min-w-">Working with Children</th>
                                                                    <th class="min-w-">Passport</th>
                                                                    <th class="min-w-">Citizenship</th>
                                                                    <th class="min-w-">Driver License</th>
                                                                    <th class="min-w-">Firstaid</th>
                                                                    <th class="min-w-">Medicare</th>
                                                                    <th class="min-w-">Security License</th>
                                                                    <th class="min-w-">Police check</th>
                                                                    <th class="min-w-">Birth Certificate</th> --}}
                                                                    </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($guard as $item)
                                                                <tr>
                                                                    {{-- <td><a href="" onclick="window.open('{{url('guard_profile')}}/{{$item->id}}','_blank')">{{$item->name}}</a></td> --}}
                                                                    <td><a href="{{url('guard_profile')}}/{{$item->id}}" target="_blank">{{$item->name}}</a></td>
                                                                    {{-- <td>{{$item->vaccination_certificate}}</td>
                                                                    <td>{{$item->visa_number}}</td>
                                                                    <td>{{$item->visa_number}}</td>
                                                                    <td>{{$item->guard_working_type}}</td>
                                                                    <td>{{$item->passport_number}}</td>
                                                                    <td>{{$item->citizenship_file}}</td>
                                                                    <td>{{$item->driver_license_file}}</td>
                                                                    <td>{{$item->firstaid_license_file}}</td>
                                                                    <td>{{$item->medicare_file}}</td>
                                                                    <td>{{$item->security_license_file}}</td>
                                                                    <td>{{$item->security_license_file}}</td>
                                                                    <td>{{$item->birthcertificate_file}}</td> --}}
                                                                </tr>
                                                                @endforeach
                                                                                                      
                                                            </tbody>
                                                           
                                                        </table>
                                                    {{-- </div> --}}
                                                    {{-- </div> --}}
                                                    {{-- </div> --}}
                                                    <div id="missed-table" style="display: none;">
                                                        <table  id="missed-example" cellspacing="-2" class=" table-responsive table-fluid  table-hover table-striped  ">
                                                            <thead style="background-color: white" >
                                                                <tr >


                                                                    <th style="display:none;">{{config('custom.guard')}} Payroll Id</th>
                                                                    <th>{{config('custom.guard')}} Name</th>
                                                                    <!-- <th style="display: none">{{config('custom.guard')}} Phone</th> -->

                                                                    <!-- <th id="st">{{config('custom.guard')}} Type</th> -->
                                                                    <!-- <th id="cust">Customer</th> -->
                                                                    <th>Schedule Start Date</th>
                                                                    <th>Schedule Start Time</th>
                                                                    <th>Schedule Finish Time</th>
                                                                    <!-- <th style="display: none">---</th> -->
                                                                    <!-- <th id="ast">Authorized Start Time</th> -->
                                                                    <!-- <th style="display: none">--</th> -->
                                                                    <!-- <th id="aft">Authorized Finish Time</th> -->
                                                                    <!-- <th id="tt">Travel Time</th> -->
                                                                    <!-- <th id="ath">Authorized Total Hours</th> -->
                                                                    <!-- <th class="noExport" id="table_status">Status</th> -->
                                                                    <!-- <th class="noExport" id="status_change_by" style="width:12px !important">Status Change by</th> -->
                                                                    <!-- <th class="noExport" id="bp">Break Payable</th> -->
                                                                    <!-- <th class="noExport" id="bc">Break Chargeable</th> -->
                                                                    <!-- <th style="display: none">Operator Notes</th> -->
                                                                </tr>
                                                            </thead>
                                                            <tbody id="example_body_missed">
                                                                
                                                                                                      
                                                            </tbody>
                                                           
                                                        </table>
                                                    </div>
                                                    </div>
                                                </div>	
                                            </div>	
                                        </div>	
                        
                        <!--end::Tab Content-->
                    <!--end::Container-->
    
    <div class="modal fade" id="kt_modal_export_users" tabindex="-1" aria-hidden="true">
                                        <!--begin::Modal dialog-->
                                        <div class="modal-dialog modal-dialog-centered mw-650px">
                                            <!--begin::Modal content-->
                                            <div class="modal-content">
                                                <!--begin::Modal header-->
                                                <div class="modal-header">
                                                    <!--begin::Modal title-->
                                                    <h2 class="fw-bolder">Export Users</h2>
                                                    <!--end::Modal title-->
                                                    <!--begin::Close-->
                                                
                                                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        
                            <span class="svg-icon svg-icon-2x">X</span>
                           </div>
                                                    <!--end::Close-->
                                                </div>
                                                <!--end::Modal header-->
                                                <!--begin::Modal body-->
                                                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                                    <!--begin::Form-->
                                                    <form id="export_user_form" class="form" action="" method="POST" enctype="multipart/form-data">
                                                @csrf

                                                        <!--begin::Input group-->
                                            
                                                        <!--end::Input group-->
                                                        <!--begin::Input group-->
                                                       
                                                        <!--end::Input group-->
                                                        <!--begin::Actions-->
                                                        <div class="text-center">
                                                            <button type="reset" class="btn btn-white me-3" data-kt-users-modal-action="cancel">Discard</button>
                                                            <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                                                                <span id="form_submit" class="indicator-label">Submit</span>
                                                                <span class="indicator-progress">Please wait...
                                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                            </button>
                                                        </div>
                                                        <!--end::Actions-->
                                                    </form>
                                                    <!--end::Form-->
                                                </div>
                                                <!--end::Modal body-->
                                            </div>
                                            <!--end::Modal content-->
                                        </div>
                                        <!--end::Modal dialog-->
                                    </div>
@stop


    @section('pageFooter')
    <!--end::Scrolltop-->
    <!--end::Main-->
    <!--begin::Javascript-->
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="{{asset('')}}plugins/global/plugins.bundle.js"></script>
    <script src="{{asset('')}}js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Page Custom Javascript(used by this page)-->

    <script src="{{asset('')}}js/custom/widgets.js"></script>
    <script src="{{asset('')}}js/custom/apps/chat/chat.js"></script>
    <script src="{{asset('')}}js/custom/modals/create-app.js"></script>
    <script src="{{asset('')}}js/custom/modals/upgrade-plan.js"></script>
    <script src="{{asset('')}}plugins/global/plugins.bundle.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="{{asset('')}}js/datetimepicker/build/jquery.datetimepicker.full.js"></script>
<script type="text/javascript" src="{{asset('')}}js/datetimepicker/build/jquery.datetimepicker.min.js"></script>
<script type="text/javascript" src="{{asset('')}}js/datetimepicker/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<style>
div.dt-buttons {
    position: relative;
    float: right !important;
}
</style>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    $(document).ready(function() {
        $("input").change(function(e){
            e.preventDefault();
// alert('here');
            var _token = $("input[name='_token']").val();
            var vaccination = $('input[name="vaccination"]:checked').val();
            var visa = $('input[name="visa"]:checked').val();
            var induction = $('input[name="induction"]:checked').val();
            var working_children = $('input[name="working_children"]:checked').val();
            var passport = $('input[name="passport"]:checked').val();
            var citizenship = $('input[name="citizenship"]:checked').val();
            var driver_license = $('input[name="driver_license"]:checked').val();
            var firstaid = $('input[name="firstaid"]:checked').val();
            var medicare = $('input[name="medicare"]:checked').val();
            var security_license = $('input[name="security_license"]:checked').val();
            var police_check = $('input[name="police_check"]:checked').val();
            var birth_certificate = $('input[name="birth_certificate"]:checked').val();
            $.ajax({
                url: "{{ url('guard/guardLicenseSearch') }}",
                type:'POST',
                data: {_token:_token,
                    vaccination:vaccination, 
                    visa:visa, 
                    induction:induction, 
                    working_children:working_children, 
                    passport:passport, 
                    citizenship:citizenship, 
                    driver_license:driver_license, 
                    firstaid:firstaid, 
                    medicare:medicare, 
                    security_license:security_license, 
                    police_check:police_check, 
                    birth_certificate:birth_certificate, 
                    },
            }).done((r)=>{
                $('.guard_data').html(r);
             });
        }); 

        
    });
</script>


@stop