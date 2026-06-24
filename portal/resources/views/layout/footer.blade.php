@section('main-footer')

<script>

//   setInterval(function(){

//     $.ajax({
//       url:"http://localhost/egs-dev/old_portal/index.php/administrator/inbox/check_unread",
//       method:"POST",
//       dataType:'json',
//       success:function(res){
//       if(res.status){
//         toastr.success("Click Here.","You Got New Message",{onclick: function() {
//           window.location.href = "http://localhost/egs-dev/old_portal/index.php/administrator/dashboard/icon_bar_support";
//         }});
//       }

//     }
//   });

//   }, 7000);

// $(document).on('click', '._ac-change-status-roster', function(e) {
//                var confirm = confirmBox('Do you confirm change roster status?');
//                var status = $(this).is(":checked");

//                if(!confirm) {
//                    return;
//                }
//                if (status) {
//                 status = 'completed';
//                }else{
//                 status = 'pending';
//                }
//                uiBlocker();
//                postRequest("http://localhost/egs-dev/old_portal/index.php/administrator/guard/change_roster_status", {roster_id: $(this).attr('data-roster-id'), status : status}, function (response) {
//                    response = JSON.parse(response);
//                    if (response.success) {
//                        successAlert(response.message);
//                        // getGuards();
//                        return;
//                    }
//                    errorAlert(response.message);
//                });
//            });

// setInterval(function(){
// $.ajax({
//         type: "POST",
//         url: "http://localhost/egs-dev/old_portal/index.php/administrator/dashboard/guard_location_at_job_unseen_activity",
//         success: function(result){
//          var data = JSON.parse(result);
//          var notifications = '';
//          var notification_counter = $('#notification_counter').text();
//          if (data.length > 0) {
//           // alert('notification');
//           $.each(data, function(mi,mv){
//           toastr.warning("Click Here.","Guard has left the site!.",{onclick: function() {
//             window.open("http://localhost/egs-dev/old_portal/index.php/administrator/dashboard/new_job_roster?event_id="+mv.event_id);
//            }});
//           notifications += '<a class="list-group-item dropdown-item" target="_blank" href="http://localhost/egs-dev/old_portal/index.php/administrator/dashboard/new_job_roster?event_id='+mv.event_id+'" role="menuitem"><div class="media"><div class="pr-10"><i class="icon md-receipt bg-red-600 white icon-circle" aria-hidden="true"></i></div><div class="media-body"><h6 class="media-heading">Guard has left the site!.</h6></div></div></a>';

//           });
//           notification_counter = (notification_counter *1)  + (data.length *1);
//          }
//          $('.notification_counter').text(notification_counter)
//          $('#notification-list').append(notifications)

//          // $.each(data, function(mi,mv){
//          //  activity += '<tr><td>'+mv.address+'</td><td>'+mv.name+'</td><td>'+mv.start+'</td><td>'+mv.end+'</td><td>'+mv.distance+'</td><td><a href="http://localhost/egs-dev/old_portal/index.php/administrator/dashboard/new_job_roster?event_id='+mv.event_id+'">View Details</a></td></tr>';
//          //  // <i class="site-menu-icon md-eye"></i>
//          // })
//          // $('#guard_activity_at_job').html(activity);
//         }
//         });

// $.ajax({
//         type: "POST",
//         url: "http://localhost/egs-dev/old_portal/index.php/administrator/dashboard/incident_report_unseen",
//         success: function(result){
//          var data = JSON.parse(result);
//          var notifications = '';
//          var notification_counter = $('#notification_counter').text();
//          if (data.length > 0) {
//           // alert('notification');
//           $.each(data, function(mi,mv){
//           toastr.warning("Click Here.","New incident Report.",{onclick: function() {
//             window.open("http://localhost/egs-dev/old_portal/index.php/administrator/dashboard/new_job_roster?event_id="+mv.event_id);
//            }});
//           notifications += '<a class="list-group-item dropdown-item" target="_blank" href="http://localhost/egs-dev/old_portal/index.php/administrator/dashboard/new_job_roster?event_id='+mv.event_id+'" role="menuitem"><div class="media"><div class="pr-10"><i class="icon md-receipt bg-red-600 white icon-circle" aria-hidden="true"></i></div><div class="media-body"><h6 class="media-heading">New incident Report.</h6></div></div></a>';

//           });
//           notification_counter = (notification_counter *1)  + (data.length *1);
//          }
//          $('.notification_counter').text(notification_counter)
//          $('#notification-list').append(notifications)

//          // $.each(data, function(mi,mv){
//          //  activity += '<tr><td>'+mv.address+'</td><td>'+mv.name+'</td><td>'+mv.start+'</td><td>'+mv.end+'</td><td>'+mv.distance+'</td><td><a href="http://localhost/egs-dev/old_portal/index.php/administrator/dashboard/new_job_roster?event_id='+mv.event_id+'">View Details</a></td></tr>';
//          //  // <i class="site-menu-icon md-eye"></i>
//          // })
//          // $('#guard_activity_at_job').html(activity);
//         }
//         });

//         $.ajax({
//         type: "POST",
//         url: "http://localhost/egs-dev/old_portal/index.php/administrator/dashboard/welfare_call_unseen",
//         success: function(result){
//          var data = JSON.parse(result);
//          var notifications = '';
//          var notification_counter = $('#notification_counter').text();
//          if (data.length > 0) {
//           // alert('notification');
//           $.each(data, function(mi,mv){
//           toastr.warning("Click Here.","Welfare call.",{onclick: function() {
//             window.open("http://localhost/egs-dev/old_portal/index.php/administrator/dashboard/new_job_roster?event_id="+mv.event_id);
//            }});
//           notifications += '<a class="list-group-item dropdown-item" target="_blank" href="http://localhost/egs-dev/old_portal/index.php/administrator/dashboard/new_job_roster?event_id='+mv.event_id+'" role="menuitem"><div class="media"><div class="pr-10"><i class="icon md-receipt bg-red-600 white icon-circle" aria-hidden="true"></i></div><div class="media-body"><h6 class="media-heading">Welfare call</h6></div></div></a>';

//           });
//           notification_counter = (notification_counter *1)  + (data.length *1);
//          }
//          $('.notification_counter').text(notification_counter)
//          $('#notification-list').append(notifications)

//          // $.each(data, function(mi,mv){
//          //  activity += '<tr><td>'+mv.address+'</td><td>'+mv.name+'</td><td>'+mv.start+'</td><td>'+mv.end+'</td><td>'+mv.distance+'</td><td><a href="http://localhost/egs-dev/old_portal/index.php/administrator/dashboard/new_job_roster?event_id='+mv.event_id+'">View Details</a></td></tr>';
//          //  // <i class="site-menu-icon md-eye"></i>
//          // })
//          // $('#guard_activity_at_job').html(activity);
//         }
//         });
// }, 10000);


</script>

<div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
						<!--begin::Container-->
						<div class="container d-flex flex-column flex-md-row flex-stack">
							<!--begin::Copyright-->
							<div class="text-dark order-2 order-md-1">
								<span class="text-gray-400 fw-bold me-1">Created by</span>
								<a href="https://247staffingsolutions.com.au/" target="_blank" class="text-muted text-hover-primary fw-bold me-2 fs-6">247 Staffing Solutions</a>
							</div>
							<!--end::Copyright-->
							<!--begin::Menu-->
						<!-- 	<ul class="menu menu-gray-600 menu-hover-primary fw-bold order-1">
								<li class="menu-item">
									<a href="https://keenthemes.com" target="_blank" class="menu-link px-2">About</a>
								</li>
								<li class="menu-item">
									<a href="https://keenthemes.com/support" target="_blank" class="menu-link px-2">Support</a>
								</li>
								<li class="menu-item">
									<a href="https://1.envato.market/EA4JP" target="_blank" class="menu-link px-2">Purchase</a>
								</li>
							</ul> -->
							<!--end::Menu-->
						</div>
						<!--end::Container-->
					</div>



					<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
			<!--begin::Svg Icon | path: icons/duotone/Navigation/Up-2.svg-->
			<span class="svg-icon">
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						<polygon points="0 0 24 0 24 24 0 24" />
						<rect fill="#000000" opacity="0.5" x="11" y="10" width="2" height="10" rx="1" />
						<path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero" />
					</g>
				</svg>
			</span>
			<!--end::Svg Icon-->
		</div>

















			<!-- </div> -->
				<!--end::Wrapper-->
			<!-- </div> -->
			<!--end::Page-->
		<!-- </div> -->



		{{-- toolbar modals  --}}


		     		<!--begin::Modal - Invite Friends-->
					 <div class="modal fade" id="kt_modal_invite_friends" tabindex="-1" aria-hidden="true">
						<!--begin::Modal dialog-->
						<div class="modal-dialog mw-650px">
							<!--begin::Modal content-->
							<div class="modal-content">
								<!--begin::Modal header-->
								<div class="modal-header pb-0 border-0 justify-content-end">
									<!--begin::Close-->
									<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
										<!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
										<span class="svg-icon svg-icon-1">
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
													<rect fill="#000000" x="0" y="7" width="16" height="2" rx="1" />
													<rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1" />
												</g>
											</svg>
										</span>
										<!--end::Svg Icon-->
									</div>
									<!--end::Close-->
								</div>
								<!--begin::Modal header-->
								<!--begin::Modal body-->
								<div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
									<!--begin::Heading-->
									<div class="text-center mb-13">
										<!--begin::Title-->
										<h1 class="mb-3">Invite a Friend</h1>
										<!--end::Title-->
										<!--begin::Description-->
										<div class="text-gray-400 fw-bold fs-5">If you need more info, please check out
										<a href="#" class="link-primary fw-bolder">FAQ Page</a>.</div>
										<!--end::Description-->
									</div>
									<!--end::Heading-->
									<!--begin::Google Contacts Invite-->
									<div class="btn btn-light-primary fw-bolder w-100 mb-8">
									<img alt="Logo" src="assets/media/svg/brand-logos/google-icon.svg" class="h-20px me-3" />Invite Gmail Contacts</div>
									<!--end::Google Contacts Invite-->
									<!--begin::Separator-->
									<div class="separator d-flex flex-center mb-8">
										<span class="text-uppercase bg-white fs-7 fw-bold text-gray-400 px-3">or</span>
									</div>
									<!--end::Separator-->
									<!--begin::Textarea-->
									<textarea class="form-control form-control-solid mb-8" rows="3" placeholder="Type or paste emails here"></textarea>
									<!--end::Textarea-->
									<!--begin::Users-->
									<div class="mb-10">
										<!--begin::Heading-->
										<div class="fs-6 fw-bold mb-2">Your Invitations</div>
										<!--end::Heading-->
										<!--begin::List-->
										<div class="mh-300px scroll-y me-n7 pe-7">
											<!--begin::User-->
											<div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
												<!--begin::Details-->
												<div class="d-flex align-items-center">
													<!--begin::Avatar-->
													<div class="symbol symbol-35px symbol-circle">
														<img alt="Pic" src="assets/media/avatars/150-1.jpg" />
													</div>
													<!--end::Avatar-->
													<!--begin::Details-->
													<div class="ms-5">
														<a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Emma Smith</a>
														<div class="fw-bold text-gray-400">e.smith@kpmg.com.au</div>
													</div>
													<!--end::Details-->
												</div>
												<!--end::Details-->
												<!--begin::Access menu-->
												<div class="ms-2 w-100px">
													<select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
														<option value="1">Guest</option>
														<option value="2" selected="selected">Owner</option>
														<option value="3">Can Edit</option>
													</select>
												</div>
												<!--end::Access menu-->
											</div>
											<!--end::User-->
											<!--begin::User-->
											<div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
												<!--begin::Details-->
												<div class="d-flex align-items-center">
													<!--begin::Avatar-->
													<div class="symbol symbol-35px symbol-circle">
														<span class="symbol-label bg-light-danger text-danger fw-bold">M</span>
													</div>
													<!--end::Avatar-->
													<!--begin::Details-->
													<div class="ms-5">
														<a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Melody Macy</a>
														<div class="fw-bold text-gray-400">melody@altbox.com</div>
													</div>
													<!--end::Details-->
												</div>
												<!--end::Details-->
												<!--begin::Access menu-->
												<div class="ms-2 w-100px">
													<select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
														<option value="1" selected="selected">Guest</option>
														<option value="2">Owner</option>
														<option value="3">Can Edit</option>
													</select>
												</div>
												<!--end::Access menu-->
											</div>
											<!--end::User-->
											<!--begin::User-->
											<div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
												<!--begin::Details-->
												<div class="d-flex align-items-center">
													<!--begin::Avatar-->
													<div class="symbol symbol-35px symbol-circle">
														<img alt="Pic" src="assets/media/avatars/150-2.jpg" />
													</div>
													<!--end::Avatar-->
													<!--begin::Details-->
													<div class="ms-5">
														<a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Max Smith</a>
														<div class="fw-bold text-gray-400">max@kt.com</div>
													</div>
													<!--end::Details-->
												</div>
												<!--end::Details-->
												<!--begin::Access menu-->
												<div class="ms-2 w-100px">
													<select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
														<option value="1">Guest</option>
														<option value="2">Owner</option>
														<option value="3" selected="selected">Can Edit</option>
													</select>
												</div>
												<!--end::Access menu-->
											</div>
											<!--end::User-->
											<!--begin::User-->
											<div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
												<!--begin::Details-->
												<div class="d-flex align-items-center">
													<!--begin::Avatar-->
													<div class="symbol symbol-35px symbol-circle">
														<img alt="Pic" src="assets/media/avatars/150-4.jpg" />
													</div>
													<!--end::Avatar-->
													<!--begin::Details-->
													<div class="ms-5">
														<a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Sean Bean</a>
														<div class="fw-bold text-gray-400">sean@dellito.com</div>
													</div>
													<!--end::Details-->
												</div>
												<!--end::Details-->
												<!--begin::Access menu-->
												<div class="ms-2 w-100px">
													<select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
														<option value="1">Guest</option>
														<option value="2" selected="selected">Owner</option>
														<option value="3">Can Edit</option>
													</select>
												</div>
												<!--end::Access menu-->
											</div>
											<!--end::User-->
											<!--begin::User-->
											<div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
												<!--begin::Details-->
												<div class="d-flex align-items-center">
													<!--begin::Avatar-->
													<div class="symbol symbol-35px symbol-circle">
														<img alt="Pic" src="assets/media/avatars/150-15.jpg" />
													</div>
													<!--end::Avatar-->
													<!--begin::Details-->
													<div class="ms-5">
														<a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Brian Cox</a>
														<div class="fw-bold text-gray-400">brian@exchange.com</div>
													</div>
													<!--end::Details-->
												</div>
												<!--end::Details-->
												<!--begin::Access menu-->
												<div class="ms-2 w-100px">
													<select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
														<option value="1">Guest</option>
														<option value="2">Owner</option>
														<option value="3" selected="selected">Can Edit</option>
													</select>
												</div>
												<!--end::Access menu-->
											</div>
											<!--end::User-->
											<!--begin::User-->
											<div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
												<!--begin::Details-->
												<div class="d-flex align-items-center">
													<!--begin::Avatar-->
													<div class="symbol symbol-35px symbol-circle">
														<span class="symbol-label bg-light-warning text-warning fw-bold">M</span>
													</div>
													<!--end::Avatar-->
													<!--begin::Details-->
													<div class="ms-5">
														<a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Mikaela Collins</a>
														<div class="fw-bold text-gray-400">mikaela@pexcom.com</div>
													</div>
													<!--end::Details-->
												</div>
												<!--end::Details-->
												<!--begin::Access menu-->
												<div class="ms-2 w-100px">
													<select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
														<option value="1">Guest</option>
														<option value="2" selected="selected">Owner</option>
														<option value="3">Can Edit</option>
													</select>
												</div>
												<!--end::Access menu-->
											</div>
											<!--end::User-->
											<!--begin::User-->
											<div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
												<!--begin::Details-->
												<div class="d-flex align-items-center">
													<!--begin::Avatar-->
													<div class="symbol symbol-35px symbol-circle">
														<img alt="Pic" src="assets/media/avatars/150-8.jpg" />
													</div>
													<!--end::Avatar-->
													<!--begin::Details-->
													<div class="ms-5">
														<a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Francis Mitcham</a>
														<div class="fw-bold text-gray-400">f.mitcham@kpmg.com.au</div>
													</div>
													<!--end::Details-->
												</div>
												<!--end::Details-->
												<!--begin::Access menu-->
												<div class="ms-2 w-100px">
													<select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
														<option value="1">Guest</option>
														<option value="2">Owner</option>
														<option value="3" selected="selected">Can Edit</option>
													</select>
												</div>
												<!--end::Access menu-->
											</div>
											<!--end::User-->
											<!--begin::User-->
											<div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
												<!--begin::Details-->
												<div class="d-flex align-items-center">
													<!--begin::Avatar-->
													<div class="symbol symbol-35px symbol-circle">
														<span class="symbol-label bg-light-danger text-danger fw-bold">O</span>
													</div>
													<!--end::Avatar-->
													<!--begin::Details-->
													<div class="ms-5">
														<a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Olivia Wild</a>
														<div class="fw-bold text-gray-400">olivia@corpmail.com</div>
													</div>
													<!--end::Details-->
												</div>
												<!--end::Details-->
												<!--begin::Access menu-->
												<div class="ms-2 w-100px">
													<select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
														<option value="1">Guest</option>
														<option value="2" selected="selected">Owner</option>
														<option value="3">Can Edit</option>
													</select>
												</div>
												<!--end::Access menu-->
											</div>
											<!--end::User-->
											<!--begin::User-->
											<div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
												<!--begin::Details-->
												<div class="d-flex align-items-center">
													<!--begin::Avatar-->
													<div class="symbol symbol-35px symbol-circle">
														<span class="symbol-label bg-light-primary text-primary fw-bold">N</span>
													</div>
													<!--end::Avatar-->
													<!--begin::Details-->
													<div class="ms-5">
														<a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Neil Owen</a>
														<div class="fw-bold text-gray-400">owen.neil@gmail.com</div>
													</div>
													<!--end::Details-->
												</div>
												<!--end::Details-->
												<!--begin::Access menu-->
												<div class="ms-2 w-100px">
													<select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
														<option value="1" selected="selected">Guest</option>
														<option value="2">Owner</option>
														<option value="3">Can Edit</option>
													</select>
												</div>
												<!--end::Access menu-->
											</div>
											<!--end::User-->
											<!--begin::User-->
											<div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
												<!--begin::Details-->
												<div class="d-flex align-items-center">
													<!--begin::Avatar-->
													<div class="symbol symbol-35px symbol-circle">
														<img alt="Pic" src="assets/media/avatars/150-6.jpg" />
													</div>
													<!--end::Avatar-->
													<!--begin::Details-->
													<div class="ms-5">
														<a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Dan Wilson</a>
														<div class="fw-bold text-gray-400">dam@consilting.com</div>
													</div>
													<!--end::Details-->
												</div>
												<!--end::Details-->
												<!--begin::Access menu-->
												<div class="ms-2 w-100px">
													<select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
														<option value="1">Guest</option>
														<option value="2">Owner</option>
														<option value="3" selected="selected">Can Edit</option>
													</select>
												</div>
												<!--end::Access menu-->
											</div>
											<!--end::User-->
											<!--begin::User-->
											<div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
												<!--begin::Details-->
												<div class="d-flex align-items-center">
													<!--begin::Avatar-->
													<div class="symbol symbol-35px symbol-circle">
														<span class="symbol-label bg-light-danger text-danger fw-bold">E</span>
													</div>
													<!--end::Avatar-->
													<!--begin::Details-->
													<div class="ms-5">
														<a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Emma Bold</a>
														<div class="fw-bold text-gray-400">emma@intenso.com</div>
													</div>
													<!--end::Details-->
												</div>
												<!--end::Details-->
												<!--begin::Access menu-->
												<div class="ms-2 w-100px">
													<select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
														<option value="1">Guest</option>
														<option value="2" selected="selected">Owner</option>
														<option value="3">Can Edit</option>
													</select>
												</div>
												<!--end::Access menu-->
											</div>
											<!--end::User-->
											<!--begin::User-->
											<div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
												<!--begin::Details-->
												<div class="d-flex align-items-center">
													<!--begin::Avatar-->
													<div class="symbol symbol-35px symbol-circle">
														<img alt="Pic" src="assets/media/avatars/150-7.jpg" />
													</div>
													<!--end::Avatar-->
													<!--begin::Details-->
													<div class="ms-5">
														<a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Ana Crown</a>
														<div class="fw-bold text-gray-400">ana.cf@limtel.com</div>
													</div>
													<!--end::Details-->
												</div>
												<!--end::Details-->
												<!--begin::Access menu-->
												<div class="ms-2 w-100px">
													<select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
														<option value="1" selected="selected">Guest</option>
														<option value="2">Owner</option>
														<option value="3">Can Edit</option>
													</select>
												</div>
												<!--end::Access menu-->
											</div>
											<!--end::User-->
											<!--begin::User-->
											<div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
												<!--begin::Details-->
												<div class="d-flex align-items-center">
													<!--begin::Avatar-->
													<div class="symbol symbol-35px symbol-circle">
														<span class="symbol-label bg-light-info text-info fw-bold">A</span>
													</div>
													<!--end::Avatar-->
													<!--begin::Details-->
													<div class="ms-5">
														<a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Robert Doe</a>
														<div class="fw-bold text-gray-400">robert@benko.com</div>
													</div>
													<!--end::Details-->
												</div>
												<!--end::Details-->
												<!--begin::Access menu-->
												<div class="ms-2 w-100px">
													<select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
														<option value="1">Guest</option>
														<option value="2">Owner</option>
														<option value="3" selected="selected">Can Edit</option>
													</select>
												</div>
												<!--end::Access menu-->
											</div>
											<!--end::User-->
											<!--begin::User-->
											<div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
												<!--begin::Details-->
												<div class="d-flex align-items-center">
													<!--begin::Avatar-->
													<div class="symbol symbol-35px symbol-circle">
														<img alt="Pic" src="assets/media/avatars/150-17.jpg" />
													</div>
													<!--end::Avatar-->
													<!--begin::Details-->
													<div class="ms-5">
														<a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">John Miller</a>
														<div class="fw-bold text-gray-400">miller@mapple.com</div>
													</div>
													<!--end::Details-->
												</div>
												<!--end::Details-->
												<!--begin::Access menu-->
												<div class="ms-2 w-100px">
													<select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
														<option value="1">Guest</option>
														<option value="2">Owner</option>
														<option value="3" selected="selected">Can Edit</option>
													</select>
												</div>
												<!--end::Access menu-->
											</div>
											<!--end::User-->
											<!--begin::User-->
											<div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
												<!--begin::Details-->
												<div class="d-flex align-items-center">
													<!--begin::Avatar-->
													<div class="symbol symbol-35px symbol-circle">
														<span class="symbol-label bg-light-success text-success fw-bold">L</span>
													</div>
													<!--end::Avatar-->
													<!--begin::Details-->
													<div class="ms-5">
														<a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Lucy Kunic</a>
														<div class="fw-bold text-gray-400">lucy.m@fentech.com</div>
													</div>
													<!--end::Details-->
												</div>
												<!--end::Details-->
												<!--begin::Access menu-->
												<div class="ms-2 w-100px">
													<select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
														<option value="1">Guest</option>
														<option value="2" selected="selected">Owner</option>
														<option value="3">Can Edit</option>
													</select>
												</div>
												<!--end::Access menu-->
											</div>
											<!--end::User-->
											<!--begin::User-->
											<div class="d-flex flex-stack py-4 border-bottom border-gray-300 border-bottom-dashed">
												<!--begin::Details-->
												<div class="d-flex align-items-center">
													<!--begin::Avatar-->
													<div class="symbol symbol-35px symbol-circle">
														<img alt="Pic" src="assets/media/avatars/150-10.jpg" />
													</div>
													<!--end::Avatar-->
													<!--begin::Details-->
													<div class="ms-5">
														<a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">Ethan Wilder</a>
														<div class="fw-bold text-gray-400">ethan@loop.com.au</div>
													</div>
													<!--end::Details-->
												</div>
												<!--end::Details-->
												<!--begin::Access menu-->
												<div class="ms-2 w-100px">
													<select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
														<option value="1" selected="selected">Guest</option>
														<option value="2">Owner</option>
														<option value="3">Can Edit</option>
													</select>
												</div>
												<!--end::Access menu-->
											</div>
											<!--end::User-->
											<!--begin::User-->
											<div class="d-flex flex-stack py-4">
												<!--begin::Details-->
												<div class="d-flex align-items-center">
													<!--begin::Avatar-->
													<div class="symbol symbol-35px symbol-circle">
														<img alt="Pic" src="assets/media/avatars/150-17.jpg" />
													</div>
													<!--end::Avatar-->
													<!--begin::Details-->
													<div class="ms-5">
														<a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">John Miller</a>
														<div class="fw-bold text-gray-400">miller@mapple.com</div>
													</div>
													<!--end::Details-->
												</div>
												<!--end::Details-->
												<!--begin::Access menu-->
												<div class="ms-2 w-100px">
													<select class="form-select form-select-solid form-select-sm" data-control="select2" data-hide-search="true">
														<option value="1">Guest</option>
														<option value="2">Owner</option>
														<option value="3" selected="selected">Can Edit</option>
													</select>
												</div>
												<!--end::Access menu-->
											</div>
											<!--end::User-->
										</div>
										<!--end::List-->
									</div>
									<!--end::Users-->
									<!--begin::Notice-->
									<div class="d-flex flex-stack">
										<!--begin::Label-->
										<div class="me-5 fw-bold">
											<label class="fs-6">Adding Users by Team Members</label>
											<div class="fs-7 text-gray-400">If you need more info, please check budget planning</div>
										</div>
										<!--end::Label-->
										<!--begin::Switch-->
										<label class="form-check form-switch form-check-custom form-check-solid">
											<input class="form-check-input" type="checkbox" value="1" checked="checked" />
											<span class="form-check-label fw-bold text-gray-400">Allowed</span>
										</label>
										<!--end::Switch-->
									</div>
									<!--end::Notice-->
								</div>
								<!--end::Modal body-->
							</div>
							<!--end::Modal content-->
						</div>
						<!--end::Modal dialog-->
					</div>
					<!--end::Modal - Invite Friend-->

					


		       		<!--begin::Modal -OPERation view-->
					   <div class="modal fade" id="operation_notes_modal" tabindex="-1" aria-hidden="true">
						<!--begin::Modal dialog-->
						<div class="modal-dialog modal-dialog-centered mw-900px">
							<!--begin::Modal content-->
							<div class="modal-content">
								<!--begin::Modal header-->
								<div class="modal-header">
									<!--begin::Modal title-->
									<h2>Create Operation Note</h2>
									<!--end::Modal title-->
									<!--begin::Close-->
									<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
										<!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
										<span class="svg-icon svg-icon-1">
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
													<rect fill="#000000" x="0" y="7" width="16" height="2" rx="1" />
													<rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1" />
												</g>
											</svg>
										</span>
										<!--end::Svg Icon-->
									</div>
									<!--end::Close-->
								</div>
								<!--end::Modal header-->
								<!--begin::Modal body-->
								<div class="modal-body py-lg-10 px-lg-10">
								<form id="operation_notes_form" action="{{url('create_operation_notes')}}" method="POST" enctype="multipart/form-data" >
									@csrf
									<div class="w-100">
										
										<div class="row">
											<div class="col-sm-6">
												<div class="fv-row mb-10">
													<label class="d-flex align-items-center fs-5 fw-bold mb-2">
														<span class="required">Title</span>
														<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="" data-bs-original-title="Specify your unique note name" aria-label="Specify your unique note name"></i>
													</label>
													<input type="text" class="form-control form-control-lg form-control-solid" name="title" placeholder="" value="">
												</div>
											</div>
											<div class="col-sm-6 " id="toid_div">
												<label class="fs-6 form-label fw-bolder text-dark">Select Users</label>
												<!--begin::Select-->
												<select  class="form-select form-select-lg form-select-solid  select2-hidden-accessible" data-control="select2" data-placeholder="Select..." data-allow-clear="true" data-hide-search="true" id="toid" name="toid[]" multiple data-select2-id="select2-data-customer_name" tabindex="-1" aria-hidden="true">
													<!-- <select name="toid[]" id="toid" multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="1"> -->
												</select>
											</div>
											<input type="hidden" value="{{session()->get('userId')}}" name="fromid" id="fromid">
										</div>
										<div id="editor" class="form-group d-flex flex-stack mb-8">
											<textarea class="rich_text_content" name="notes" id="notes"></textarea>
										</div>
										<div class="text-center">
											<button type="submit" class="btn btn-active-dark">Submit</button>
										</div>
									</div>
								</form>
								</div>
								<!--end::Modal body-->
							</div>
							<!--end::Modal content-->
						</div>
						<!--end::Modal dialog-->
					</div>
					<!--end::Modal - Create App-->

					<!--begin::Modal -OPERation create-->
					<div class="modal fade" id="operation_notes_modal_view" tabindex="-1" aria-hidden="true">
						<!--begin::Modal dialog-->
						<div class="modal-dialog modal-dialog-centered mw-900px">
							<!--begin::Modal content-->
							<div class="modal-content">
								<!--begin::Modal header-->
								<div class="modal-header">
									<!--begin::Modal title-->
									<h2> Operation Notes</h2>
									<!--end::Modal title-->
									<!--begin::Close-->
									<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
										<!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
										<span class="svg-icon svg-icon-1">
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
													<rect fill="#000000" x="0" y="7" width="16" height="2" rx="1" />
													<rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1" />
												</g>
											</svg>
										</span>
										<!--end::Svg Icon-->
									</div>
									<!--end::Close-->
								</div>
								<!--end::Modal header-->
								<!--begin::Modal body-->
								<div class="modal-body py-lg-10 px-lg-10">
									<div class="col-xl-12">
										<!--begin::List Widget 6-->
										<div class=" card-xl-stretch mb-5 mb-xl-8">
											<!--begin::Header-->
											<div class="card-header border-0">
												<div class="card-toolbar">
													<ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
														<li class="nav-item">
															<a class="nav-link active" data-bs-toggle="tab" href="#inbox_messages">Inbox</a>
														</li>
														<li class="nav-item">
															<a class="nav-link" data-bs-toggle="tab" href="#send_messages">Send Messages</a>
														</li>
														
													</ul>
												</div>
											</div>
											<!--end::Header-->
											<!--begin::Body-->
											<div class="card-body pt-0" id="operations_list">
											
														<div class="tab-content" id="myTabContent">
															<div class="tab-pane fade show active" id="inbox_messages" role="tabpanel">
															</div>
												
															<div class="tab-pane fade" id="send_messages" role="tabpanel">
															</div>
												
															
														</div>
												
											</div>
											<!--end::Body-->
										</div>
										<!--end::List Widget 6-->
									</div>
								</div>
								<!--end::Modal body-->
							</div>
							<!--end::Modal content-->
						</div>
						<!--end::Modal dialog-->
					</div>
					<!--end::Modal - Create App-->
			

					{{-- detail --}}
					<div class="modal fade" id="operation_notes_modal_view_detail" tabindex="-1" aria-hidden="true">
						<!--begin::Modal dialog-->
						<div class="modal-dialog modal-dialog-centered mw-900px">
							<!--begin::Modal content-->
							<div class="modal-content">
								<!--begin::Modal header-->
								<div class="modal-header modal_custom_head">
									<!--begin::Modal title-->
									<!--end::Modal title-->
									<!--begin::Close-->
									<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
										<!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
										<span class="svg-icon svg-icon-1">
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
													<rect fill="#000000" x="0" y="7" width="16" height="2" rx="1" />
													<rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1" />
												</g>
											</svg>
										</span>
										<!--end::Svg Icon-->
									</div>
									<!--end::Close-->
								</div>
								<!--end::Modal header-->
								<!--begin::Modal body-->
								<div id="detail_operation_div" class="modal-body modal_custom_body  py-lg-10 px-lg-10">
									
								</div>
								<!--end::Modal body-->
							</div>
							<!--end::Modal content-->
						</div>
						<!--end::Modal dialog-->
					</div>			
			
					{{-- uncover --}}
					<div class="modal fade" id="uncover_modal" tabindex="-1" aria-hidden="true">
						<!--begin::Modal dialog-->
						<div class="modal-dialog modal-simple modal-sidebar modal-lg">
							<!--begin::Modal content-->
							<div style="height:100% !important; " class="modal-content">
								<!--begin::Modal header-->
								{{-- modal-header modal_custom_head --}}
								<div class="">
									<!--begin::Modal title-->
									<!--end::Modal title-->
									<!--begin::Close-->
								
									<!--end::Close-->
								</div>
								<!--end::Modal header-->
								<!--begin::Modal body-->
								<div id="uncover_modal_body" class="modal-body modal_custom_body  py-lg-10 px-lg-10">
									
								</div>
								<!--end::Modal body-->
								<div class="modal-footer">
									<button data-bs-dismiss="modal" class="btn btn-primary text-center">Close</button>
								</div>
							</div>
							<!--end::Modal content-->
						</div>
						<!--end::Modal dialog-->
					</div>
		
					{{-- uncover --}}
					
			{{-- security --}}
			<div class="modal fade" id="security_modal" tabindex="-1" aria-hidden="true">
				<!--begin::Modal dialog-->
				<div class="modal-dialog modal-simple modal-sidebar2 modal-lg">
					<!--begin::Modal content-->
					<div class="modal-content" style="height:100% !important; ">
						<!--begin::Modal header-->
						{{-- modal-header modal_custom_head --}}
						<div class="">
							<!--begin::Modal title-->
							<!--end::Modal title-->
							<!--begin::Close-->
							{{-- <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
							x
							</div> --}}
							<!--end::Close-->
						</div>
						<!--end::Modal header-->
						<!--begin::Modal body-->
						<div id="security_modal_body" class="modal-body modal_custom_body  py-lg-10 px-lg-10">
							
						</div>
						<!--end::Modal body-->
						<div class="modal-footer">
							<button data-bs-dismiss="modal" class="btn btn-primary text-center">Close</button>
						</div>
					</div>
					<!--end::Modal content-->
				</div>
				<!--end::Modal dialog-->
			</div>

		


			{{-- security --}}
						<!--begin::Chat drawer-->
					<div id="kt_drawer_chat" class="bg-white" data-kt-drawer="true" data-kt-drawer-name="chat" data-kt-drawer-activate="true" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'300px', 'md': '500px'}" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_drawer_chat_toggle" data-kt-drawer-close="#kt_drawer_chat_close">
						<!--begin::Messenger-->
						<div class="card w-100" id="kt_drawer_chat_messenger">
							<!--begin::Card header-->
							<div class="card-header pe-5" id="kt_drawer_chat_messenger_header">
								<!--begin::Title-->
								<div class="card-title">
									<!--begin::User-->
									<div class="d-flex justify-content-center flex-column me-3">
										<a href="#" class="fs-4 fw-bolder text-gray-900 text-hover-primary me-1 mb-2 lh-1" id="chat_reveiver_name"></a>
										<!--begin::Info-->
										<div class="mb-0 lh-1">
											<span class="badge badge-success badge-circle w-10px h-10px me-1"></span>
											<span class="fs-7 fw-bold text-gray-400">Active</span>
										</div>
										<!--end::Info-->
									</div>
									<!--end::User-->
								</div>
								<!--end::Title-->
								<!--begin::Card toolbar-->
								<div class="card-toolbar">
									<!--begin::Close-->
									<div class="btn btn-sm btn-icon btn-active-light-primary" id="kt_drawer_chat_close">
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
									</div>
									<!--end::Close-->
								</div>
								<!--end::Card toolbar-->
							</div>
							<!--end::Card header-->
							<!--begin::Card body-->
							<div class="card-body" id="kt_drawer_chat_messenger_body">
								<!--begin::Messages-->
								<div class="scroll-y me-n5 pe-5" data-kt-element="messages" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_drawer_chat_messenger_header, #kt_drawer_chat_messenger_footer" data-kt-scroll-wrappers="#kt_drawer_chat_messenger_body" data-kt-scroll-offset="0px" id="chat-data-drawer">
								
								</div>
								<!--end::Messages-->
							</div>
							<!--end::Card body-->
							<!--begin::Card footer-->
							<div class="card-footer pt-4" id="kt_drawer_chat_messenger_footer">
								<!--begin::Input-->
								<textarea class="form-control form-control-flush mb-3" rows="1" data-kt-element="input" placeholder="Type a message" id="chat-message"></textarea>
								<input type="hidden" name="receiver_id" id="receiver_id">
								<input type="hidden" name="receiver_type" id="receiver_type">
								<input type="hidden" name="receiver_name" id="receiver_name">
								<input type="hidden" name="receiver_image" id="receiver_image" value="{{asset('media/avatars/150-13.jpg')}}">
								<!--end::Input-->
								<!--begin:Toolbar-->
								<div class="d-flex flex-stack">
									<!--begin::Actions-->
									<div class="d-flex align-items-center me-2">
										<button class="btn btn-sm btn-icon btn-active-light-primary me-1" type="button" data-bs-toggle="tooltip" title="Coming soon">
											<i class="bi bi-paperclip fs-3"></i>
										</button>
										<button class="btn btn-sm btn-icon btn-active-light-primary me-1" type="button" data-bs-toggle="tooltip" title="Coming soon">
											<i class="bi bi-upload fs-3"></i>
										</button>
									</div>
									<!--end::Actions-->
									<!--begin::Send-->
									<button class="btn btn-primary" type="button" data-kt-element="send" onclick="sendUserMessage()">Send</button>
									<!--end::Send-->
								</div>
								<!--end::Toolbar-->
							</div>
							<!--end::Card footer-->
						</div>
						<!--end::Messenger-->
					</div>
					<!--end::Chat drawer-->
					





					<!--begin::Activities drawer-->
		<div id="kt_activities" class="bg-white" data-kt-drawer="true" data-kt-drawer-name="activities" data-kt-drawer-activate="true" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'300px', 'lg': '900px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_activities_toggle" data-kt-drawer-close="#kt_activities_close">
			<div class="card shadow-none">
				<!--begin::Header-->
				<div class="card-header" id="kt_activities_header">
					<h3 class="card-title fw-bolder text-dark">Activity Logs</h3>
					<div class="card-toolbar">
						<button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n5" id="kt_activities_close">
							<!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
							<span class="svg-icon svg-icon-1">
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
					<div>
				</div>
				 @if(session()->get('isAdmin') == 1)
					<div class="container">
					<div class="row">
					<div class="col-sm-12">
						<label class="fs-6 form-label fw-bolder text-dark">Activity Search By</label>
						<select class="form-select form-select-solid" data-control="select2" data-placeholder="" data-hide-search="true" id="admin_id" name="admin_id" onchange="fetch_activity_log()">
						<option value="">Select</option>
						</select>
					</div>
					</div>
				</div>
					@endif
				</div>

				<!--end::Header-->
				<!--begin::Body-->
				<div class="card-body position-relative" id="kt_activities_body">
					<!--begin::Content-->
					<div id="kt_activities_scroll" class="position-relative scroll-y me-n5 pe-5" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_activities_body" data-kt-scroll-dependencies="#kt_activities_header, #kt_activities_footer" data-kt-scroll-offset="5px">
						<!--begin::Timeline items-->
						
						<!--end::Timeline items-->
					</div>
					<!--end::Content-->
				</div>
				<!--end::Body-->
				<!--begin::Footer-->
				<div class="card-footer py-5 text-center" id="kt_activities_footer">
				
				</div>
				<!--end::Footer-->
			</div>
		</div>
		<!--end::Activities drawer-->





		{{-- activity data --}}
	
		
		<div class="modal fade" tabindex="-1" id="log_data_modal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Log Data Detail</h5>
		
						<!--begin::Close-->
						<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
							<span class="svg-icon svg-icon-2x"></span>
						</div>
						<!--end::Close-->
					</div>
		
					<div id="log_data_body" class="modal-body">
					</div>
		
					<div class="modal-footer">
						<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

		@stop