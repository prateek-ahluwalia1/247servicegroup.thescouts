
@extends('layout.app')
@extends('layout.sidebar')
@include('layout.toolbar')	
@extends('layout.footer')

@section('pageCss')
<base href="../../../">
<meta charset="utf-8" />
<title>{{ config('custom.title');}}</title>
<!--begin::Fonts-->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700" />
<!--end::Fonts-->
<!--begin::Global Stylesheets Bundle(used by all pages)-->
<link href="{{asset('')}}plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
<link href="{{asset('')}}css/style.bundle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	/* th,td{
		padding: 5px !important;
	}
	th{
		font-weight: bold !important;
	} */
    div{
        text-transform: capitalize; 
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
</style>
<!--end::Global Stylesheets Bundle-->
@stop

@section('content')

<!--begin::Wrapper-->
<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
	<!--begin::Header-->
	<div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
		<!--begin::Container-->
		<div class="container d-flex align-items-center justify-content-between" id="kt_header_container">
			<!--begin::Page title-->
			<div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-2 pb-2 pb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
				<!--begin::Heading-->
				<h1 class="text-dark fw-bolder my-0 fs-2"></h1>
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
				<a href="{{url('')}}">
					@if(config('custom.business_type')=="demo")
					<img alt="Logo" crossorigin="anonymous" id="bussiness_logo" src="{{asset('')}}media/logo.png" class="h-60px">
					@else
					<img alt="Logo" crossorigin="anonymous" id="bussiness_logo" src="{{config('custom.logo')}}" class="h-60px">
					@endif

				</a>
				<!--end::Logo-->
			</div>
			<!--end::Wrapper-->
			<!--begin::Toolbar wrapper-->
			@include('layout.toolbar')	
			@yield('toolbar')
			<!--end::Toolbar wrapper-->
		</div>
		<!--end::Container-->
	</div>
	<!--end::Header-->
	<!--begin::Content-->
	<!--begin::Card body-->
    <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent" style="margin-left: 33px;margin-right: 22px;">

        <div class="card mb-5 mb-xl-10 tab-pane fade show active"  id="personal_information" role="tabpanel" aria-labelledby="personal_information-tab">
            <!--begin::Card header-->
            <div class="card-header cursor-pointer">
                <!--begin::Card title-->
                <div class="card-title m-0">
                <h3 class="fw-bolder m-0">Site Information</h3>
            </div>
            <div>
                <button type="submit"  onclick="window.open('{{url('job_roster')}}?site={{$value->id}}&customer_id={{$value->customer_id}}','_blank')" style="text-decoration: none;margin-top: 15%;" class="btn-primary btn text-end">Job Roster</button>
            </div>
        </div>
        <!--begin::Card header-->
        <!--begin::Card body-->
        {{-- @foreach($site_detail as $value) --}}
        <table id="customers">
            <tr>
              <th>Name</th>
              <th>Value</th>
              <th>Name</th>
              <th>Value</th>
            </tr>
            <tr>
              <td class="font_size">Level</td>
              <td>{{$value->level}}</td>
              <td class="font_size">State</td>
              <td>{{$value->state}}</td>
            </tr>
            <tr>
              <td class="font_size">State Type</td>
              <td>{{$value->stateType}}</td>
              <td class="font_size">Payrol</td>
              <td>{{$value->payrol}}</td>
            </tr>
              <tr>
              <td class="font_size">Trained</td>
              <td>{{$value->trained}}</td>
              <td class="font_size">Green Call</td>
              <td>{{$value->green_call}}</td>
            </tr>
        </tr>
        <tr>
        <td class="font_size">Welfare Call</td>
        <td>{{$value->welfare_call}}</td>
        <td class="font_size">Welfare Timing</td>
        <td>{{$value->welfare_timing}}</td>
      </tr>
      <tr>
        <td class="font_size">Details</td>
        <td>{{$value->details}}</td>
        <td class="font_size">SOS Phone</td>
        <td>{{$value->sos_phone}}</td>
      </tr>
      <tr>
        <td class="font_size">Start</td>
        <td>{{\Carbon\Carbon::parse($value->start)->format('d-m-Y')}}</td>
        <td class="font_size">End</td>
        <td>{{\Carbon\Carbon::parse($value->end)->format('d-m-Y')}}</td>
      </tr>
      <tr>
        <td class="font_size">Address</td>
        <td>{{$value->address}}</td>
        <td class="font_size">Coordinates</td>
        <td>{{$value->coordinates}}</td>
      </tr>
      <tr>
        <td class="font_size">{{ config('custom.guard') }} Count</td>
        <td>{{$value->guards_count}}</td>
        <td class="font_size">Hourly Rate</td>
        <td>{{$value->hourly_rate}}</td>
      </tr>
      <tr>
        <td class="font_size">Job Status</td>
        <td>{{$value->job_status}}</td>
        <td class="font_size">Status</td>
        <td>{{$value->status}}</td>
      </tr>
      <tr>
        <td class="font_size">Week Schedule</td>
        @if($value->week_schedule === '[]')
        <td>N/A</td>
        @else
        <td>{{$value->week_schedule}}</td>
        @endif
        <td class="font_size">Site Name</td>
        <td>{{$value->site_name}}</td>
      </tr>
      <tr>
        <td class="font_size">Site Description</td>
        <td>{{$value->site_description}}</td>
        <td class="font_size">Other Metro Weekday Day</td>
        <td>{{$value->other_metro_weekday_day}}</td>
      </tr>
      <tr>
        <td class="font_size">Other Metro Weekday Afternoon</td>
        <td>{{$value->other_metro_weekday_afternoon}}</td>
        <td class="font_size">Other Metro Weekday Night</td>
        <td>{{$value->other_metro_weekday_night}}</td>
      </tr>
      <tr>
        <td class="font_size">Other Metro Weekend</td>
        <td>{{$value->other_metro_weekend}}</td>
        <td class="font_size">Other Metro Public Holiday</td>
        <td>{{$value->other_metro_public_holiday}}</td>
      </tr>
      <tr>
        <td class="font_size">Other Regional Weekday Day</td>
        <td>{{$value->other_regional_weekday_day}}</td>
        <td class="font_size">Other Regional Weekday Afternoon</td>
        <td>{{$value->other_regional_weekday_afternoon}}</td>
      </tr>
      <tr>
        <td class="font_size">Other Regional Weekday Night</td>
        <td>{{$value->other_regional_weekday_night}}</td>
        <td class="font_size">Other Regional Weekend</td>
        <td>{{$value->other_regional_weekend}}</td>
      </tr>
      <tr>
        <td class="font_size">Other Regional Public Holiday</td>
        <td>{{$value->other_regional_public_holiday}}</td>
        <td class="font_size">Signin Radius</td>
        <td>{{$value->signin_radius}}</td>
      </tr>
      <tr>
        <td class="font_size">Alert Radius</td>
        <td>{{$value->alert_radius}}</td>
        <td class="font_size">Break</td>
        <td>{{$value->break}}</td>
      </tr>
      <tr>
        <td class="font_size">Chargeable</td>
        <td>{{$value->chargeable}}</td>
        <td class="font_size">Payable</td>
        <td>{{$value->payable}}</td>
      </tr>
      <tr>
        <td  class="font_size">Site Payrate</td>
        <td>{{$value->site_payrate}}</td>
        <td class="font_size">Site Charge Rate</td>
        <td>{{$value->site_charge_rate}}</td>
      </tr>
      <tr>
        <td class="font_size">Site Employer</td>
        <td>{{$value->site_employer}}</td>
        <td class="font_size">Site Chargerate Level</td>
        <td>{{$value->site_chargerate_level}}</td>
      </tr>
      <tr>
        <td class="font_size">Site Payrate Level</td>
        <td>{{$value->site_payrate_level}}</td>
        <td class="font_size">Fatigue</td>
        <td>{{$value->fatigue}}</td>
      </tr>
      <tr>
        <td class="font_size">Payable And Chargeable Time</td>
        <td>{{$value->payable_and_chargeable_time}}</td>
        <td class="font_size">Break Deduction Chargeable</td>
        <td>{{$value->break_deduction_chargeable}}</td>
      </tr>
      <tr>
        <td class="font_size">Site Hours</td>
        <td>{{$value->site_hours}}</td>
        <td class="font_size">Site Type</td>
        <td>{{$value->site_type}}</td>
      </tr>
      <tr>
        <td class="font_size">Unpublished Site</td>
        <td>{{$value->unpublished_site}}</td>
        <td class="font_size">Site Tasks</td>
        @if($value->site_tasks === '[]')
        <td>N/A</td>
        @else
        <td>{{$value->site_tasks}}</td>
        @endif
      </tr>
      <tr>
        <td class="font_size">Pay Rate Apply Date</td>
        <td>{{date('m/d/Y', strtotime($value->apply_date))}}</td>
        <td class="font_size">Charge Rate Apply Date</td>
        <td>{{date('m/d/Y', strtotime($value->charge_apply_date))}}</td>
      </tr>
      <tr>
        <td class="font_size">Date Added</td>
        <td>{{date('m/d/Y H:i:s',$value->date_added)}}</td>
      </tr>
            
          </table>
          
        {{-- @endforeach --}}
        <!--end::Card body-->
    </div>
    {{-- waqas ending --}}
    <!-- begin::tabs by hussain -->

	<!--end::Content-->
	<!--begin::Footer-->
	@section('pageFooter')
	<!--end::Scrolltop-->
	<!--end::Main-->
	<!--begin::Javascript-->
	<!--begin::Global Javascript Bundle(used by all pages)-->
	<script src="{{asset('')}}plugins/global/plugins.bundle.js"></script>
	<script src="{{asset('')}}js/scripts.bundle.js"></script>
	<!--end::Global Javascript Bundle-->
	<!--begin::Page Custom Javascript(used by this page)-->
	<script src="{{asset('')}}js/custom/modals/offer-a-deal.bundle.js"></script>
	<script src="{{asset('')}}js/custom/widgets.js"></script>
	<script src="{{asset('')}}js/custom/apps/chat/chat.js"></script>
	<script src="{{asset('')}}js/custom/modals/create-app.js"></script>
	<script src="{{asset('')}}js/custom/modals/upgrade-plan.js"></script>
	<!--end::Page Custom Javascript-->
	<!--end::Javascript-->
	<script type="text/javascript">
		$("#kt_daterangepicker_1").daterangepicker();

		$( document ).ready(function() {
			MultiselectDropdown();
			$('#kt_daterangepicker_1').on('change', function(){
				loadActivity();
			});

		});
		
	</script>
	@stop
	<!--end::Footer-->
	<!-- </div> -->
	<!--end::Wrapper-->
	@stop
