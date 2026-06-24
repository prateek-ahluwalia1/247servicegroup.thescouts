<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
		<title>{{ config('custom.title')}}</title>

	<link rel="icon" type="image/png" href="{{config('custom.logo')}}"/>
	<link rel="icon" type="image/png" href="{{config('custom.logo')}}"/>
	@yield('pageCss')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.2/css/fixedHeader.dataTables.min.css">

		  <link rel="stylesheet" href="{{asset('')}}richtext/richtext.min.css">

<?php 
if (session()->has('colors') && session()->get('colors') != '') {
    $p_colors = json_decode(session()->get('colors'), true);
}

?>
<style type="text/css">

/* custom */
/* custom */
.modal_card_custom{
	background-color: #bbbbbb69;
}
.modal_custom_body{
	margin-left: 0% !important;
    margin-right: 0% !important;
}
.modal_custom_body2{
	margin-left: -3% !important;
    margin-right: 0% !important;
}
a {
	color: {{(!empty($p_colors) ? $p_colors['primary_color'] : '#d99f23')}};
	text-decoration: none
}
body {
	background-color: {{(!empty($p_colors) ? $p_colors['primary_background'] : '#f3f6f9')}};
}
.card {
background-color: {{(!empty($p_colors) ? $p_colors['secondary_background'] : '#fff')}};
}

.modal_custom_head{
	margin-top: -3% !important;
    margin-bottom: -2% !important;
}
.loading {
	border: 4px solid #ccc;
    width: 35px;
    height: 35px;
    border-radius: 200%;
    border-top-color: #c4d1cd;
    border-left-color: #7caedd;
    animation: spin 1s infinite ease-in;
    margin-left: 140px;
}
.loader {
  display: none;
  top: 25%;
  left: 25%;
  position: absolute;
  transform: translate(-50%, -50%);
}
@keyframes spin {
  0% {
    transform: rotate(0deg);
  }

  100% {
    transform: rotate(360deg);
  }
}
    .pac-container {
        z-index: 10000 !important;
    }
    .mar_left{
    	margin-left: 3px;
    }

	
</style>
</head>
<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-enabled">

		

	<!--begin::Main-->
		<!--begin::Root-->
		<div class="d-flex- flex-column flex-root" style="display: contents;">
			<!--begin::Page-->
			<div class="page d-flex flex-row flex-column-fluid 1" style="flex: 0 0 auto !important;">
				<!--begin::Aside-->
						<div id="kt_aside" class="aside aside-extended bg-white" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="auto" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_toggle">
				
					@yield('sidebar')

					@yield('content')
					
	<script type="text/javascript">
		var session_usertype="{{session()->get('userType')}}";
		var session_userId="{{session()->get('userId')}}";
		var type_of_bussiness="{{config('custom.guard')}}";
		var asset_url_upload="{{config('asset_url')}}";

					
		var selectable_enabled = '<?php echo (session()->get('userType') == "admin" || session()->get('userType') == "customer") ? true : false ?>';
	</script>

	@yield('main-footer')

	@yield('pageFooter')
	

	
</body>
<script type="text/javascript">
	var base_url = '{{ url('')}}';
	var asset_url = '{{ asset('')}}';
	var token = '<?php echo csrf_token();?>';
</script>
<script type="text/javascript" src="{{asset('')}}richtext/jquery.richtext.js"></script>
<script type="text/javascript" src="{{asset('')}}richtext/jquery.richtext.min.js"></script>
<script src="{{ asset('')}}js/notifications.js"></script>
<script src="{{asset('')}}js/multiselect-dropdown.js"></script>

<script type="text/javascript">
  $("#kt_horizontal_search_advanced_link").on('click', function(e){
	var x = document.getElementById('kt_advanced_search_form');
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
  });
	
function toggle_sidebar(e){


var y =  $(e).attr("id");
var z =  `${y}_content`;
var x = document.getElementById(z);
console.log(z);

  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

	
   		 $('#kt_body').attr("data-kt-aside-minimize","on");
   		 $('.nav-custom').click(function(){
   		 $('#kt_body').attr("data-kt-aside-minimize","off");

   		 }
)
		// $('.modal').modal({
		// 	backdrop: 'static'
		// })
	  $( document ).ready(function() {
		  
		get_count_notes();

		$('.rich_text_content').richText();
		
	  	
	  	// data-kt-aside-minimize
   		 // $('#menu-close-btn').click();
});

function get_count_notes(){
	$.ajax({type: "POST",url: "{{url('get_count_notes')}}", data:{_token:'<?php echo csrf_token();?>'},success: function(result){
		document.getElementById('count_badge').innerHTML = result.count;

		// console.log(result.count);
	}

	});
}

$("#operation_notes_form").on('submit', function(e){
     e.preventDefault();
     // console.log(this.id);
	//  console.log(html_bb);
     var data = $('#'+this.id).serialize();

     $.ajax({type: "POST",url: this.action,data :data ,success: function(result){if(result.success){
     	$('#operation_notes_modal').modal('hide');

									Swal.fire({
													text: result.message,
													icon: "success",
													buttonsStyling: !1,
													confirmButtonText: "Ok, got it!",
													customClass: {
														confirmButton: "btn btn-light"
													}
						})
					}else{Swal.fire({
											text: result.error,
											icon: "error",
											buttonsStyling: !1,
											confirmButtonText: "Ok, got it!",
											customClass: {
												confirmButton: "btn btn-light"
											}
										})}}})

  });


  function get_admin_toid(){
	$('#operation_notes_modal').modal('show');
	$('#toid_div>.multiselect-dropdown').remove();
	$.ajax({type: "POST",url:"{{url('get_admin_toid')}}",data:{_token:'<?php echo csrf_token();?>'} ,success: function(result){
		var siteData2 ='';

		$.each(result, function(id, data) {
				siteData2  +=`<option value="${data.id}">${data.name}</option>` 
			});
			$("#toid").html(siteData2);

	}
	
});

  }

  
  function get_operations(){

	// $(".for_remove").remove();

	$('#operation_notes_modal_view').modal('show');
	$.ajax({type: "POST",url:"{{url('get_operations')}}",data:{_token:'<?php echo csrf_token();?>'} ,success: function(result){
		var siteData2 ='';
		var Lenght=0;
		var message=0;

		$.each(result, function(id, data) {
			if(data.status=='unread'){
				siteData2  +=`<div  class="for_remove d-flex align-items-center bg-light-warning rounded p-5 mb-7">
					<div class="flex-grow-1 me-2">
											<a type="button" onclick="detail_popup(${data.id},${message})">
												<span class="fw-bolder text-gray-800 text-hover-primary fs-6">${data.title}</span>
												<span class="text-muted text-bold  d-block">from:${data.name}</span>
												<span class="text-muted  d-block">${data.created_at}</span>
											</a>
											</div>
												<!--begin::Lable-->
												<span class="badge badge-light-success fs-8 fw-bolder">New</span>
												<!--end::Lable-->
												</div>` 
				$("#inbox_messages").append(siteData2);
			}else{
				siteData2  +=`<div style="background-color:#ffeb9e"  class="for_remove d-flex align-items-center  rounded p-5 mb-7">
					<div class="flex-grow-1 me-2">
											<a type="button" onclick="detail_popup(${data.id},${message})">
												<span class="fw-bolder text-gray-800 text-hover-primary fs-6">${data.title}</span>
												<span class="text-muted text-bold  d-block">from:${data.name}</span>
												<span class="text-muted  d-block">${data.created_at}</span>
											</a>
											</div>
												<!--begin::Lable-->
												<span class="badge badge-light-success fs-8 fw-bolder">Read</span>
												<!--end::Lable-->
												</div>` 
				$("#inbox_messages").append(siteData2);
			}
				
			siteData2='';

			});
	}
	
});
// $('#popup_quick_link').attr("data-kt-menu","true");


//send

$.ajax({type: "POST",url:"{{url('get_operations_send')}}",data:{_token:'<?php echo csrf_token();?>'} ,success: function(result){
		var siteData2 ='';
		var Lenght=0;
		var message=1;

		$.each(result, function(id, data) {
			siteData2  +=`<div  class="for_remove d-flex align-items-center bg-light-warning rounded p-5 mb-7">
					<div class="flex-grow-1 me-2">
											<a type="button" onclick="detail_popup(${data.id},${message})">
												<span class="fw-bolder text-gray-800 text-hover-primary fs-6">${data.title}</span>
												<span class="text-muted text-bold  d-block">to:${data.name}</span>
												<span class="text-muted  d-block">${data.created_at}</span>
											</a>
											</div>
												<!--begin::Lable-->
												<span class="badge badge-light-success fs-8 fw-bolder">New</span>
												<!--end::Lable-->
												</div>` 
				$("#send_messages").append(siteData2);
				
			siteData2='';

			});
	}
	
});
  }

  function detail_popup(id,message){
	$('#operation_notes_modal_view_detail').modal('show');
	$.ajax({type: "POST",url:"{{url('detail_popup_operation')}}",data:{id:id,_token:'<?php echo csrf_token();?>'} ,success: function(result){
		var siteData2 ='';
		var Lenght=0;
		$.each(result, function(id, data) {
	  var siteData2=`
	  <div class="col-xl-12">
									<!--begin::Mixed Widget 9-->
									<div class=" modal_custom_head  card-xl-stretch mb-xl-8">
										<!--begin::Body-->
										<div class=" modal_custom_head card-body d-flex flex-column pb-10 pb-lg-15">
											<div class="flex-grow-1">
												<!--begin::Info-->
												<div class="d-flex align-items-center pe-2 mb-5">
													<span style="font-size: 20px;
												text-align: center;
												float: right;
												margin-left: 41%;
    											font-weight: bold;" class="text-center mb-20">
													${message==1 ? `To` :`From`}

													: ${data.name}</span>
													</div>
												</div>
												<!--end::Info-->
												<!--begin::Link-->
												<a href="#" class="text-dark fw-bolder text-hover-primary fs-4">${data.title}</a>
												<!--end::Link-->
												<!--begin::Desc-->
												<div style="max-width: 100%;overflow: auto;">
												<p class="py-3" style="max-width:100%;overflow:auto;">${data.notes}</p>
												</div>
												<!--end::Desc-->
											</div>
											<!--begin::Team-->
											<div style="float: right;text-align: end;" class="">
										${data.status =='read' ? 
    `<a type="button" class="btn"  data-bs-toggle="tooltip" title="" data-bs-original-title="read" disabled>
												Read
													</a>` 
:`<a type="button" id="mark_as_read_button_${data.id}" onclick="mark_as_read(${data.id})" class="btn btn-primary" data-bs-toggle="tooltip" title="" data-bs-original-title="mark as read">
													Mark As Read
													</a>`}
												
											</div>
											<!--end::Team-->
										</div>
										<!--end::Body-->
									</div>
									<!--end::Mixed Widget 9-->
								</div>   `;
	  $("#detail_operation_div").html(siteData2);
							});
						}
					});

  }
  
function openNotifications()
{
	$('#popup_notifications').attr("data-kt-menu",true);
}

  function get_operations_n_times(){
	document.getElementsByClassName("loader")[0].style.display = "block";

	$("#n_times").addClass("loading");

$(".for_remove").remove();

$.ajax({type: "POST",url:"{{url('get_operations_n_times')}}",data:{times:3,_token:'<?php echo csrf_token();?>'} ,success: function(result){
	var siteData2 ='';
	var Lenght=0;
	var message=0;
	$("#n_times").removeClass("loading");

		if(result.check=="yes"){

	$.each(result.results, function(id, data) {
		console.log("yahio");

		// console.log('count number ');	
			siteData2  +=`<div style="margin: 20px;"  class="for_remove d-flex align-items-center bg-light-warning rounded p-5 mb-7">
				<!--begin::Title-->
											<div class="flex-grow-1 me-2">
											<a type="button" onclick="detail_popup(${data.id},${message})">
												<span class="fw-bolder text-gray-800 text-hover-primary fs-6">${data.title}</span>
												<span class="text-muted text-bold  d-block">from:${data.name}</span>
												<span class="text-muted  d-block">${data.created_at}</span>
											</a>
											</div>
												<!--begin::Lable-->
												<span class="badge badge-light-success fs-8 fw-bolder">New</span>
												<!--end::Lable-->
											</div>` 
			$("#n_times").append(siteData2);
			siteData2='';
	

		});
		$('#popup_quick_link').attr("data-kt-menu",true);
}else{

console.log("entere asdasdhjkasdgjasdjhasdgjhasgdasjhg");

 siteData2 ='<p  class="for_remove d-flex align-items-center bg-light-warning rounded p-5 mb-7">No New Update! </p>';
$("#n_times").html(siteData2);

}
}

});

}

function mark_as_read(id){

	$.ajax({type: "POST",url:"{{url('mark_as_read')}}",data:{id:id,_token:'<?php echo csrf_token();?>'} ,success: function(result){
	$('#mark_as_read_button_'+id).text('Read');
console.log("mark_as_read_button_"+id);

	$('#operation_notes_modal_view_detail').modal('hide');
	$('#mark_as_read_button_'+id).prop('disabled', true);



	}
});

}

function most_recent_operation_note(id){

$.ajax({type: "POST",url:"{{url('most_recent_operation_note')}}",data:{id:id,_token:'<?php echo csrf_token();?>'} ,success: function(result){
	if(result =='')
{
	// alert('null');
}else
	{

$('#operation_notes_modal_view_detail').modal('show');

	var siteData2 ='';
	var Lenght=0;
	// console.log(result[0]);
	$.each(result, function(id, data) {
  var siteData2=`
  <div class="col-xl-12">
								<!--begin::Mixed Widget 9-->
								<div class="modal_custom_head card-xl-stretch mb-xl-8">
									<!--begin::Body-->
									<div class=" modal_custom_head card-body d-flex flex-column pb-10 pb-lg-15">
										<div class="flex-grow-1">
											<!--begin::Info-->
											<div class="d-flex align-items-center pe-2 mb-5">
												<span style="font-size: 20px;
											text-align: center;
											float: right;
											margin-left: 41%;
											font-weight: bold;" class="text-center mb-20">
												From

												: ${data.name}</span>
												</div>
											</div>
											<!--end::Info-->
											<!--begin::Link-->
											<a href="#" class="text-dark fw-bolder text-hover-primary fs-4">${data.title}</a>
											<!--end::Link-->
											<!--begin::Desc-->
											<div style="max-width: 100%;overflow: auto;">
											<p class="py-3" style="max-width: 100%;overflow: auto;">${data.notes}</p>
											</div>
											<!--end::Desc-->
										</div>
										<!--begin::Team-->
										<div style="float: right;text-align: end;" class="">
									${data.status =='read' ? 
`<a type="button" class="btn"  data-bs-toggle="tooltip" title="" data-bs-original-title="read" disabled>
											Read
												</a>` 
:`<a type="button" id="mark_as_read_button_${data.id}" onclick="mark_as_read(${data.id})" class="btn btn-primary" data-bs-toggle="tooltip" title="" data-bs-original-title="mark as read">
												Mark As Read
												</a>`}
											
										</div>
										<!--end::Team-->
									</div>
									<!--end::Body-->
								</div>
								<!--end::Mixed Widget 9-->
							</div>   `;
  $("#detail_operation_div").html(siteData2);
						});
					}
				}
				});


// 				$.ajax({type: "POST",url:"{{url('security_license_expiry_check')}}",data:{_token:'<?php echo csrf_token();?>'} ,success: function(result){
// 	if(result =='')
// {
// 	// alert('null');
// }else
// 	{
// 	}

// }});


				

}

		
		   function count_dashboard(){

$.ajax({type: "POST",url:"{{url('count_dashboard')}}",data:{_token:'<?php echo csrf_token();?>'} ,success: function(result){
// console.log(result.completed_shifts_count);
	$('#ongoing_count').html(result.ongoing_count);
	$('#new_guards_count').html(result.new_guards_count);
	$('#active_guards_count').html(result.active_guards_count);
	$('#pending_guards_count').html(result.pending_guards_count);
	$('#shifts_count').html(result.shifts_count);
	$('#completed_shifts_count').html(result.completed_shifts_count);
	$('#missed_count').html(result.missed_count);
	$('#upcoming_count').html(result.upcoming_count);
	$('#asap_count').html(result.asap_job_notification_counter);
	$('#auto_completed_jobs_count').html(result.auto_completed_jobs_count);
	
	$('#missed_count2').html(result.missed_count);
	$('#upcoming_jobs_count_2').html(result.upcoming_count);
	$('#completed_jobs_count').html(result.completed_jobs_count);
	
	
}
});

}



function deleteguard(id){

var id=id;

Swal.fire({
				text: "Are you sure you want to delete ?",
				icon: "warning",
				showCancelButton: !0,
				buttonsStyling: !1,
				confirmButtonText: "Yes!",
				cancelButtonText: "No, return",
				customClass: {
					confirmButton: "btn btn-primary",
					cancelButton: "btn btn-active-light"
				}
			}).then((function (t) {
				t.value ? (
					$.ajax({type: "POST",url: '/deleteguard/'+id, data:{_token:'<?php echo csrf_token();?>'},success: function(result){
						Swal.fire({
					text: "Deleted Succesfully.",
					icon: "success",
					buttonsStyling: !1,
					confirmButtonText: "Ok, got it!",
					customClass: {
						confirmButton: "btn btn-primary"
					}
				})
			}
					})

				) : "cancel" === t.dismiss && Swal.fire({
					text: "Your action has  been cancelled!.",
					icon: "error",
					buttonsStyling: !1,
					confirmButtonText: "Ok, got it!",
					customClass: {
						confirmButton: "btn btn-primary"
					}
				})
			}))


   }

function roster_progress(){
	$.ajax({type: "POST",url:"{{url('roster_progress')}}",data:{_token:'<?php echo csrf_token();?>'} ,success: function(result){
	var 	dash_completed_shifts=result.completed_shifts;
	var 	dash_months=result.months;
	var dash_shifts=result.shifts;
	roster_progress_append(dash_shifts, dash_completed_shifts, dash_months, result.completed_jobs, result.upcoming_jobs, result.hours);
	}
});
   }

   function shifts_hour_chart(){

	$.ajax({type: "POST",url:"{{url('shifts_hour_chart')}}",data:{_token:'<?php echo csrf_token();?>'} ,success: function(result){

	var dash_shifts=result.shifts;
	get_chart(dash_shifts,result.hours,result.months);
	}
});
        

}

   function dashboard_shift_notes(){
	$.ajax({type: "POST",url:"{{url('get_operations_n_times')}}",data:{times:5,_token:'<?php echo csrf_token();?>'} ,success: function(result){
		var siteData2 ='';
		var Lenght=0;
		var message=0;

		$.each(result, function(id, data) {
			if(data.status=='unread'){
		

					siteData2+=` <!--begin::Item-->
                            <div class="d-flex align-items-center mb-8">
                                <!--begin::Bullet-->
                                <span class="bullet bullet-vertical h-40px bg-primary"></span>
                                <!--end::Bullet-->
								<!--begin::Bullet-->
                                <span class=h-40px bg-primary"> &emsp; </span>
                                <!--end::Bullet-->
                               
                                <!--begin::Description-->
                                <div class="flex-grow-1">
                                    <a type="button" onclick="detail_popup(${data.id},${message})"  class="text-gray-800 text-hover-primary fw-bolder fs-6">${data.title}</a>
                                    <span class="text-muted fw-bold d-block">${data.created_at}</span>
                                </div>
                                <!--end::Description-->
                                <span class="badge badge-light-primary fs-8 fw-bolder">New</span>
                            </div>
                            <!--end:Item-->`;
			}
			// siteData2='';


			});
			$("#dashboard_shift_notes").html(siteData2);
			
		}
	
});
   }

  function call_spinner(){
									let timerInterval;
									Swal.fire({
									  title: 'Please wait!',
									  html: 'It will take some time.',
									  // timer: 10000,
									  timerProgressBar: false,
									  allowOutsideClick: false,
									  didOpen: () => {
									    Swal.showLoading();
									    // const b = Swal.getHtmlContainer().querySelector('b')
									    timerInterval = setInterval(() => {
									     Swal.getTimerLeft()
									    })
									  },
									  willClose: () => {
									    clearInterval(timerInterval)
									  }
									})
								}
								function close_spinner(){
									$('.swal2-container').remove();
									$('.swal2-container').removeClass('swal2-backdrop-show');
									$('.swal2-container').removeClass('swal2-center');
									$('.swal2-container').css('display', 'none !important');

									// Swal.getTimerLeft();
									// Swal.getTimerLeft();
									// Swal.getTimerLeft();
									// console.log('i am called');
								} 
function capitalizeFirstLetter(string) {
  return string.charAt(0).toUpperCase() + string.slice(1);
}
function getAdminsList()
{
	$.ajax({
		type: "POST",
		url: "{{url('getAdminsList')}}",
		success: function(result) {
			var option = '<option value="">Select</option>';
			$.each(result.admins,function(id,data){
				option += '<option value="'+data.id+'">'+data.name+'</option>';
			})
			$('#admin_id').html(option);
		}
	});
}
getAdminsList();

								function fetch_activity_log(){
									$.ajax({
									type: "POST",
									url: "{{url('fetch_activity_log')}}",
									data : {
										admin_id : $('#admin_id').val()
									},
									success: function(result) {
										console.log(result);
										$('#kt_activities_scroll').html('');
										var  html='';
										$.each(result,function(id,data){
											data.action = data.action.replace(/_/g, " ");
											data.action = capitalizeFirstLetter(data.action);
											html+=`<div class="overflow-auto pb-5">
										<!--begin::Record-->
										<div class="d-flex align-items-center border border-dashed border-gray-300 rounded min-w-750px px-7 py-3 mb-5">
											<!--begin::Title-->
											<a type="button" onclick="fetch_log_data(${data.id})" class="fs-5 text-dark text-hover-primary fw-bold w-375px min-w-200px">${data.action}</a>
											<!--end::Title-->
											<!--begin::Label-->
											<div class="min-w-175px pe-2">
												By ${data.user}
											</div>
											<!--end::Label-->
											
											<!--begin::Progress-->
											<div class="min-w-125px pe-2">
												<span class="badge badge-light-primary"> ${data.created_at}</span>
											</div>
											<!--end::Progress-->
											<!--begin::Action-->
											<!--end::Action-->
										</div>
										<!--end::Record-->
									</div>`;
									  
										});
										$('#kt_activities_scroll').html(html);
									}
								})		
								}


								function fetch_log_data(id) {
									$.ajax({
									type: "POST",
									url: "{{url('fetch_log_data')}}",
									data:{id:id,_token:"<?php echo csrf_token();?>"},
									success: function(result) {
									$('#log_data_modal').modal('show');
									console.log(result[0].data);
									var res=JSON.parse(result[0].data);
									$('#log_data_body').html('');
									var html='<div class="d-flex flex-column">';
									$.each(res,function (key,value) {	
										html+=` <li class="d-flex align-items-center py-2">
      										  <span class="bullet me-5"></span>${key} : ${value}
   													 </li>`;
									})
									html+='</div>';
									$('#log_data_body').html(html);
									
								}
							})
						}
// 						 $(function() {
//                     console.log('I am ip')
//     $.get("http://ipinfo.io", function(response) {
//      alert(response.country);
// }, "jsonp");
       
    

// });
</script>
@if(session()->get('image') == '' || session()->get('image') == NULL)
<script type="text/javascript" >
		// alert(`{{session()->get('userName')}}`);
		var firstName =`{{session()->get('userName')}}`;
			// console.log(firstName);
			// var firstName =firstName.text();
			// console.log(firstName);
			var intials = firstName.charAt(0);
			// console.log(intials);

			var profileImage = $('.sidebar_profile').text(intials);
			</script>
			@endif
</html>
