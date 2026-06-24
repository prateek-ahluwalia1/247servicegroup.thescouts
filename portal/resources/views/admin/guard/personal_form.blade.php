<!--begin::personal_form by hussain-->
@section('personal')
<!-- <form class="mx-auto mw-600px w-100 pt-15 pb-10" novalidate="novalidate" id="kt_create_account_form"> -->

<div class="current" data-kt-stepper-element="content">
	<!--begin::Wrapper-->
	<div class="w-100">
		<!--begin::Heading-->
		<div class="pb-10 pb-lg-15">
			<!--begin::Title-->
			<h2 class="fw-bolder d-flex align-items-center text-dark">Personal 
			<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Contain Personal Information"></i></h2>
		</div>
		<!--end::Heading-->
		<!--begin::Input group-->
		<div class="">

			<form id="personal-form" class="form" action="{{url('personal_form')}}" method="POST" enctype="multipart/form-data">
																    @csrf
					<div class="row">
					<div class="col-md-4 form-group">
						<label for="name" class="col-form-label">First Name</label>
						<input type="text" class="form-control form-control-md" value=" " id="first_name" name="first_name" required> </div>
					<div class="col-md-4 form-group">
						<label for="name" class="col-form-label">Middle Name</label>
						<input type="text" class="form-control form-control-md" value="middle_name " id="middle_name" name="middle_name"> </div>
					<div class="col-md-4 form-group">
						<label for="name" class="col-form-label">Last Name</label>
						<input type="text" class="form-control form-control-md" value="" id="last_name" name="last_name" required> </div>
			</div>
			<div class="row">
			<div class="col-md-6 form-group">
				<label for="recipient-name" class="col-form-label">Profile image </label>
				<input accept="image/png, image/gif, image/jpeg" type="file" onchange="validateSize(this)" type="file" class="form-control form-control-md" id="profileImage" name="profileImage" required> </div>
			</div>
		<div class="row">
			<div class="col-md-6 form-group">
				<label for="recipient-name" class="col-form-label">Email</label>
				<input type="email" class="form-control form-control-md" value=" " name="email" required> </div>
			<div class="col-md-6 form-group">
				<label for="recipient-name" class="col-form-label">Password</label>
				<input type="text" class="form-control form-control-md" value=" " name="password" required> </div>
		</div>
		<div class="row">
			<div class="col-md-6 form-group">
								<label for="recipient-name" class="col-form-label">{{config('custom.guard')}} Type</label>

				<select class="form-control form-control-md" id="guard_type" name="guard_type">
					<option value="direct" name="direct">Direct</option>
					<option value="contractor" name="contractor_type">Contractor</option>
				 </select>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 form-group">
				<label for="recipient-name" class="col-form-label">Phone</label>
				<input type="text" class="form-control form-control-md" placeholder="phone " name="phone"> </div>
			<div class="col-md-6 form-group">
				<label for="recipient-name" class="col-form-label">Address</label>
				<input type="text" class="form-control form-control-md" placeholder="address " name="address" id="googleaddress"> </div>
		</div>
		<div class="row">
		<div class="col-md-12 form-group">
            <label for="recipient-name" class="col-form-label">Coordinates</label>
            <input type="text" class="form-control form-control-md" value="" id="coordinate_display" disabled name="coordinate_display">
            <input type="hidden" class="form-control form-control-md" value="" id="coordinates" name="coordinates">
        </div>
	</div>
		<div class="row">
			<div class="col-md-4 form-group">
				<label for="recipient-name" class="col-form-label">Suburb</label>
				<input type="text" class="form-control form-control-md" value=" " name="suburb" id="locality"> </div>
			<div class="col-md-4 form-group">
				<label for="recipient-name" class="col-form-label">City</label>
				<input type="text" class="form-control form-control-md" value=" " name="city" id="administrative_area_level_2"> </div>
		</div>
		<div class="row">
			<div class="col-md-12 form-group">
				<label for="recipient-name" class="col-form-label">Coordinates</label>
				<input type="text" class="form-control form-control-md" value="coordinates " id="coordinate_display" disabled name="coordinate_display">
				<input type="hidden" class="form-control form-control-md" value=" " id="coordinates" name="coordinates"> </div>
		</div>
		<div class="row">
			<div class="col-md-4 form-group">
				<label for="recipient-name" class="col-form-label">Postal code</label>
				<input type="text" class="form-control form-control-md" value=" " name="postalCode"> </div>
			<div class="col-md-4 form-group">
				<label for="recipient-name" class="col-form-label">Dob</label>
				<input type="date" class="form-control form-control-md" value="dob " name="dob"> </div>
			<div class="col-md-4 form-group">
				<label for="recipient-name" class="col-form-label">Gender</label>
				<select class="form-control form-control-md" name="gender"> </select>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 form-group">
				<label for="recipient-name" class="col-form-label">Emergency contact name</label>
				<input type="text" class="form-control form-control-md" value=" " name="emergencyContactName"> </div>
			<div class="col-md-6 form-group">
				<label for="recipient-name" class="col-form-label">Emergency contact phone</label>
				<input type="text" class="form-control form-control-md" value=" " name="emergencyContactPhone"> </div>
		</div>
		<div class="row">
		</div>
		<div class="row">
                <div class="page-main  page-main-sub col-md-12">
            <div data-role="content">
            <section class="page-aside-section" style="margin:0 auto; padding-top: 0px;">
                <div class="le-custom-dropdown le-custom-dropdown-checkbox" style="margin:0 auto;">
                <h5>Select Customers</h5>
                <div class="le-custom-dropdown-head">
                <h5><small>Select</small></h5>
                <i class="fa md-chevron-down" aria-hidden="true"></i>
                </div>
                <div class="le-custom-dropdown-body">
                <!-- <input type="search" class="le-custom-dropdown_search" placeholder="Search..."> -->
                <div class="le-custom-dropdown_menu">
                <ul class="le-search-menu">
                                       </ul>
                                                                 </div>
                                                    </div>
                                                  </div>
                                                </section>
                                              </div>
                                        </div>
    </div>
	</form>
		</div>
		</div> 
		
		</div> 
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
      <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCS-DB39Kk-Z25C5GWymVGshXIALbjXPGY&libraries=places"></script>


		<script >


			var searchInput = 'googleaddress';
var componentForm = {
    // street_number: 'short_name',
  // route: 'long_name',
  locality: 'long_name',
  administrative_area_level_2: 'short_name',
  administrative_area_level_1: 'short_name',
  // country: 'long_name'
};
$(document).ready(function(){
         var options = {
  componentRestrictions: {country: "au"}
 };
   var autocomplete;
    autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), options, {
        types: ['geocode'],
    });

    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        var near_place = autocomplete.getPlace();
        // console.log(near_place.address_components)
        latitude = near_place.geometry.location.lat();
        logitude = near_place.geometry.location.lng();
        latlng = latitude+","+logitude
        $("#coordinate_display").val(latlng);
        $("#coordinates").val(latlng);
        for (var i = 0; i < near_place.address_components.length; i++) {
            var addressType = near_place.address_components[i].types[0];
            if (componentForm[addressType]) {
              var val = near_place.address_components[i][componentForm[addressType]];
              document.getElementById(addressType).value = val;
            }
          }
        // document.getElementById('latitude_view').innerHTML = near_place.geometry.location.lat();
        // document.getElementById('longitude_view').innerHTML = near_place.geometry.location.lng();
    });

});


		function validateSize(input) {
  const fileSize = input.files[0].size / 1024 / 1024; // in MiB
  if (fileSize > 2) {
    alert('File size exceeds 2 MB');
    document.getElementById("profileImage").value = "";


    // $(file).val(''); //for clearing with Jquery
  } else {
    // Proceed further
  }
}
</script>
		@stop