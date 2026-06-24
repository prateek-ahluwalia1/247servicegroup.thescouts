<div class="row mt-4">
															<div class="col-sm-12 col-md-12 text-center">
																<a target="_blank" href="{{url('generate_complete_activity_report/'.$roster->roster_id)}}" class="btn btn-success" >Generate Report</a>
															</div>
														</div>
                            <div class="row">
                              <div class="col-sm-12">
                                <div class="card-body">
                  <!--begin::Tab Content-->
                  <div class="tab-content">
                   
                    <!--begin::Tab panel-->
                    <div id="kt_activity_week" class="card-body p-0 tab-pane fade show active" role="tabpanel" aria-labelledby="kt_activity_week_tab">
                      <!--begin::Timeline-->
                      <div class="timeline">
                      	@if(!empty($activity['incident_reports']) && count($activity['incident_reports']) > 0)
                      	<div class="timeline-item">
													<!--begin::Timeline line-->
													<div class="timeline-line w-40px"></div>
													<!--end::Timeline line-->
													<!--begin::Timeline icon-->
													<div class="timeline-icon symbol symbol-circle symbol-40px">
														<div class="symbol-label bg-light">
															<!--begin::Svg Icon | path: icons/duotone/General/Attachment2.svg-->
															<span class="svg-icon svg-icon-2 svg-icon-gray-500">
																<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																		<rect x="0" y="0" width="24" height="24"></rect>
																		<path d="M11.7573593,15.2426407 L8.75735931,15.2426407 C8.20507456,15.2426407 7.75735931,15.6903559 7.75735931,16.2426407 C7.75735931,16.7949254 8.20507456,17.2426407 8.75735931,17.2426407 L11.7573593,17.2426407 L11.7573593,18.2426407 C11.7573593,19.3472102 10.8619288,20.2426407 9.75735931,20.2426407 L5.75735931,20.2426407 C4.65278981,20.2426407 3.75735931,19.3472102 3.75735931,18.2426407 L3.75735931,14.2426407 C3.75735931,13.1380712 4.65278981,12.2426407 5.75735931,12.2426407 L9.75735931,12.2426407 C10.8619288,12.2426407 11.7573593,13.1380712 11.7573593,14.2426407 L11.7573593,15.2426407 Z" fill="#000000" opacity="0.3" transform="translate(7.757359, 16.242641) rotate(-45.000000) translate(-7.757359, -16.242641)"></path>
																		<path d="M12.2426407,8.75735931 L15.2426407,8.75735931 C15.7949254,8.75735931 16.2426407,8.30964406 16.2426407,7.75735931 C16.2426407,7.20507456 15.7949254,6.75735931 15.2426407,6.75735931 L12.2426407,6.75735931 L12.2426407,5.75735931 C12.2426407,4.65278981 13.1380712,3.75735931 14.2426407,3.75735931 L18.2426407,3.75735931 C19.3472102,3.75735931 20.2426407,4.65278981 20.2426407,5.75735931 L20.2426407,9.75735931 C20.2426407,10.8619288 19.3472102,11.7573593 18.2426407,11.7573593 L14.2426407,11.7573593 C13.1380712,11.7573593 12.2426407,10.8619288 12.2426407,9.75735931 L12.2426407,8.75735931 Z" fill="#000000" transform="translate(16.242641, 7.757359) rotate(-45.000000) translate(-16.242641, -7.757359)"></path>
																		<path d="M5.89339828,3.42893219 C6.44568303,3.42893219 6.89339828,3.87664744 6.89339828,4.42893219 L6.89339828,6.42893219 C6.89339828,6.98121694 6.44568303,7.42893219 5.89339828,7.42893219 C5.34111353,7.42893219 4.89339828,6.98121694 4.89339828,6.42893219 L4.89339828,4.42893219 C4.89339828,3.87664744 5.34111353,3.42893219 5.89339828,3.42893219 Z M11.4289322,5.13603897 C11.8194565,5.52656326 11.8194565,6.15972824 11.4289322,6.55025253 L10.0147186,7.96446609 C9.62419433,8.35499039 8.99102936,8.35499039 8.60050506,7.96446609 C8.20998077,7.5739418 8.20998077,6.94077682 8.60050506,6.55025253 L10.0147186,5.13603897 C10.4052429,4.74551468 11.0384079,4.74551468 11.4289322,5.13603897 Z M0.600505063,5.13603897 C0.991029355,4.74551468 1.62419433,4.74551468 2.01471863,5.13603897 L3.42893219,6.55025253 C3.81945648,6.94077682 3.81945648,7.5739418 3.42893219,7.96446609 C3.0384079,8.35499039 2.40524292,8.35499039 2.01471863,7.96446609 L0.600505063,6.55025253 C0.209980772,6.15972824 0.209980772,5.52656326 0.600505063,5.13603897 Z" fill="#000000" opacity="0.3" transform="translate(6.014719, 5.843146) rotate(-45.000000) translate(-6.014719, -5.843146)"></path>
																		<path d="M17.9142136,15.4497475 C18.4664983,15.4497475 18.9142136,15.8974627 18.9142136,16.4497475 L18.9142136,18.4497475 C18.9142136,19.0020322 18.4664983,19.4497475 17.9142136,19.4497475 C17.3619288,19.4497475 16.9142136,19.0020322 16.9142136,18.4497475 L16.9142136,16.4497475 C16.9142136,15.8974627 17.3619288,15.4497475 17.9142136,15.4497475 Z M23.4497475,17.1568542 C23.8402718,17.5473785 23.8402718,18.1805435 23.4497475,18.5710678 L22.0355339,19.9852814 C21.6450096,20.3758057 21.0118446,20.3758057 20.6213203,19.9852814 C20.2307961,19.5947571 20.2307961,18.9615921 20.6213203,18.5710678 L22.0355339,17.1568542 C22.4260582,16.76633 23.0592232,16.76633 23.4497475,17.1568542 Z M12.6213203,17.1568542 C13.0118446,16.76633 13.6450096,16.76633 14.0355339,17.1568542 L15.4497475,18.5710678 C15.8402718,18.9615921 15.8402718,19.5947571 15.4497475,19.9852814 C15.0592232,20.3758057 14.4260582,20.3758057 14.0355339,19.9852814 L12.6213203,18.5710678 C12.2307961,18.1805435 12.2307961,17.5473785 12.6213203,17.1568542 Z" fill="#000000" opacity="0.3" transform="translate(18.035534, 17.863961) scale(1, -1) rotate(45.000000) translate(-18.035534, -17.863961)"></path>
																	</g>
																</svg>
															</span>
															<!--end::Svg Icon-->
														</div>
													</div>
													<!--end::Timeline icon-->
													<!--begin::Timeline content-->
													<div class="timeline-content mb-10 mt-n1">
														<!--begin::Timeline heading-->
														<div class="mb-5 pe-3">
															<!--begin::Title-->
															<a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">{{$activity['incident_reports'][0]->activity}}</a>
															<!--end::Title-->
															<!--begin::Description-->
															<div class="d-flex align-items-center mt-1 fs-6">
																<!--begin::Info-->
																<!-- <div class="text-muted me-2 fs-7">Sent at 10:30 PM by</div> -->
																<!--end::Info-->
																<!--begin::User-->
																<!-- <div class="symbol symbol-circle symbol-25px" data-bs-toggle="tooltip" data-bs-boundary="window" data-bs-placement="top" title="" data-bs-original-title="Jan Hummer">
																	<img src="assets/media/avatars/150-6.jpg" alt="img">
																</div> -->
																<!--end::User-->
															</div>
															<!--end::Description-->
														</div>
														<!--end::Timeline heading-->
														<!--begin::Timeline details-->
														<div class="overflow-auto pb-5">
															<div class="d-flex align-items-center border border-dashed border-gray-300 rounded  p-5">
																@foreach($activity['incident_reports'] as $act)
																<!--begin::Item-->
																<div class="d-flex flex-aligns-center pe-10 pe-lg-20">
																	<!--begin::Icon-->
																	<img alt="" class="w-30px me-3" src="{{asset('')}}media/svg/files/pdf.svg">
																	<!--end::Icon-->
																	<!--begin::Info-->
																	<div class="ms-1 fw-bold">
																		<!--begin::Desc-->
																		<a href="{{url('guard/incident_report_pdf/'.$act->record_id)}}" target="_blank" class="fs-6 text-hover-primary fw-bolder">Download</a>
																		<!--end::Desc-->
																		<!--begin::Number-->
																		<div class="text-gray-400">{{date('d/m/Y H:i', strtotime($act->created_at))}}</div>
																		<!--end::Number-->
																	</div>
																	<!--begin::Info-->
																</div>
																<!--end::Item-->

																@endforeach
															</div>
														</div>
														<!--end::Timeline details-->
													</div>
													<!--end::Timeline content-->
												</div>
												@endif

						@if(!empty($activity['green_call']) && count($activity['green_call']) > 0)
						<div class="timeline-item">
													<!--begin::Timeline line-->
													<div class="timeline-line w-40px"></div>
													<!--end::Timeline line-->
													<!--begin::Timeline icon-->
													<div class="timeline-icon symbol symbol-circle symbol-40px me-4">
														<div class="symbol-label bg-light">
															<!--begin::Svg Icon | path: icons/duotone/Communication/Chat2.svg-->
															<span class="svg-icon svg-icon-2 svg-icon-gray-500">
																<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<polygon fill="#000000" opacity="0.3" points="5 15 3 21.5 9.5 19.5"></polygon>
																	<path d="M13.5,21 C8.25329488,21 4,16.7467051 4,11.5 C4,6.25329488 8.25329488,2 13.5,2 C18.7467051,2 23,6.25329488 23,11.5 C23,16.7467051 18.7467051,21 13.5,21 Z M9,8 C8.44771525,8 8,8.44771525 8,9 C8,9.55228475 8.44771525,10 9,10 L18,10 C18.5522847,10 19,9.55228475 19,9 C19,8.44771525 18.5522847,8 18,8 L9,8 Z M9,12 C8.44771525,12 8,12.4477153 8,13 C8,13.5522847 8.44771525,14 9,14 L14,14 C14.5522847,14 15,13.5522847 15,13 C15,12.4477153 14.5522847,12 14,12 L9,12 Z" fill="#000000"></path>
																</svg>
															</span>
															<!--end::Svg Icon-->
														</div>
													</div>
													<!--end::Timeline icon-->
													<!--begin::Timeline content-->
													<div class="timeline-content mb-10 mt-n1">
														<!--begin::Timeline heading-->
														<div class="pe-3 mb-5">
															<!--begin::Title-->
															<div class="fs-5 fw-bold mb-2">Green Call Status:</div>
															<!--end::Title-->
															<!--begin::Description-->
															<div class="d-flex align-items-center mt-1 fs-6">
																<!--begin::Info-->
																<!-- <div class="text-muted me-2 fs-7">Added at 4:23 PM by</div> -->
																<!--end::Info-->
																<!--begin::User-->
																<!-- <div class="symbol symbol-circle symbol-25px" data-bs-toggle="tooltip" data-bs-boundary="window" data-bs-placement="top" title="" data-bs-original-title="Nina Nilson">
																	<img src="assets/media/avatars/150-11.jpg" alt="img">
																</div> -->
																<!--end::User-->
															</div>
															<!--end::Description-->
														</div>
														<!--end::Timeline heading-->
														<!--begin::Timeline details-->
														<div class="overflow-auto pb-5">
															@foreach($activity['green_call'] as $green_call)
															<!--begin::Record-->
															<div class="d-flex align-items-center border border-dashed border-gray-300 rounded min-w-350px px-7 py-3 mb-5">
																<!--begin::Title-->
																<a href="#" class="fs-5 text-dark text-hover-primary fw-bold min-w-200px">Green call before {{$green_call->before_time}} mins</a>
																<!--end::Title-->
																<!--begin::Label-->
																<div class="pe-2">
																	<span class="badge badge-light text-muted">{{$green_call->status}}</span>
																</div>
																<!--end::Label-->
																<div class=" pe-2">
																	<span class="badge badge-light-primary">{{date('d/m/Y H:i', strtotime($green_call->created_at))}}</span>
																</div>
															</div>
															<!--end::Record-->
															@endforeach
														</div>
														<!--end::Timeline details-->
													</div>
													<!--end::Timeline content-->
												</div>
						

						@endif
                        @foreach($activity['activity'] as $act)

                        <div class="timeline-item">
                          <!--begin::Timeline line-->
                          <div class="timeline-line w-40px"></div>
                          <!--end::Timeline line-->
                          <!--begin::Timeline icon-->
                          <div class="timeline-icon symbol symbol-circle symbol-40px">
                            <div class="symbol-label bg-light">
                              <!--begin::Svg Icon | path: icons/duotone/Communication/Thumbtack.svg-->
                              <span class="svg-icon svg-icon-2 svg-icon-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                  <path d="M11.6734943,8.3307728 L14.9993074,6.09979492 L14.1213255,5.22181303 C13.7308012,4.83128874 13.7308012,4.19812376 14.1213255,3.80759947 L15.535539,2.39338591 C15.9260633,2.00286161 16.5592283,2.00286161 16.9497526,2.39338591 L22.6066068,8.05024016 C22.9971311,8.44076445 22.9971311,9.07392943 22.6066068,9.46445372 L21.1923933,10.8786673 C20.801869,11.2691916 20.168704,11.2691916 19.7781797,10.8786673 L18.9002333,10.0007208 L16.6692373,13.3265608 C16.9264145,14.2523264 16.9984943,15.2320236 16.8664372,16.2092466 L16.4344698,19.4058049 C16.360509,19.9531149 15.8568695,20.3368403 15.3095595,20.2628795 C15.0925691,20.2335564 14.8912006,20.1338238 14.7363706,19.9789938 L5.02099894,10.2636221 C4.63047465,9.87309784 4.63047465,9.23993286 5.02099894,8.84940857 C5.17582897,8.69457854 5.37719743,8.59484594 5.59418783,8.56552292 L8.79074617,8.13355557 C9.76799113,8.00149544 10.7477104,8.0735815 11.6734943,8.3307728 Z" fill="#000000"></path>
                                  <polygon fill="#000000" opacity="0.3" transform="translate(7.050253, 17.949747) rotate(-315.000000) translate(-7.050253, -17.949747)" points="5.55025253 13.9497475 5.55025253 19.6640332 7.05025253 21.9497475 8.55025253 19.6640332 8.55025253 13.9497475"></polygon>
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
                              <div class="fs-5 fw-bold mb-2" style="text-align: left;">{{$act->activity}}</div>
                              <!--end::Title-->
                              <!--begin::Description-->
                              <div class="d-flex align-items-center mt-1 fs-6">
                                <!--begin::Info-->
                                <div class="text-muted me-2 fs-7">at {{date('Y-m-d H:i', strtotime($act->created_at))}}</div>
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