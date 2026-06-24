						@section('active_guards')
						<div style="max-width: 100%; overflow-x: auto;">
									<!--begin::Table-->
									<table class="table align-middle table-row-dashed fs-6 gy-5 table-responsive" id="table">
										<!--begin::Table head-->
										<thead>
											<!--begin::Table row-->
											<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
												
											
												<th class="min-w-125px">{{config('custom.guard')}}</th>
												<!-- <th class="min-w-125px">Role</th> -->
												<th class="">Phone</th>
												<th class="">Suburb</th>
												<th class="">State</th>
												<th class="">Profile</th>
												<th class="">Last Login</th>
											</tr>
											<!--end::Table row-->
										</thead>
										<!--end::Table head-->
										<!--begin::Table body-->
										<tbody class="text-gray-600 fw-bold">
											<!--begin::Table row-->
											@foreach($guards as $guard)
											<tr>
												<!--begin::Checkbox-->
												
												<!--end::Checkbox-->
												<!--begin::User=--> 
												<td class="d-flex align-items-center">
													<!--begin:: Avatar -->
													<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
															<div class="symbol-label ">
																<img src="{{config('custom.asset_url')}}{{$guard->profile_image}}" alt="" class="w-100" />
															</div>
													</div>
													<!--end::Avatar-->
													<!--begin::User details-->
													<div class="d-flex flex-column">
														<a href="{{url('guard_profile') . '/' . $guard->id}}" class="text-gray-800 text-hover-primary mb-1">{{$guard->name}}</a>
														<span>{{$guard->email}}</span>
													</div>
													<!--begin::User details-->
												</td>
												<!--end::User=-->
												<!--begin::Role=-->


												<!--end::Role=-->
												<!--begin::Last login=-->
												<td>
													{{$guard->phone}}
												</td>
												<td>{{$guard->suburb}}</td>
												<td>{{$guard->state}}</td>
												
											
											
												<td>
													<?php 
													$percent=0;
													if($guard->name!='' && $guard->coordinates!='' && $guard->address!='')
														{	
															$percent=$percent+20;
														}
														
														if($guard->security_license_number!= ''|| $guard->driver_license_number!='' )
														{	
															$percent=$percent+10;
														}
														
														
														if($guard->visa_number!='')
														{	
															$percent=$percent+10;
														}
														if($guard->security_license_file!= ''|| $guard->driver_license_file!='' ){
															$percent=$percent+10;

														}

														if($guard->payroll_abn_number !='' && $guard->payroll_bank_name !=''  && $guard->payroll_bank_account_number !='')
														{	
															$percent=$percent+10;
														}
														
														if($guard->payrates_id !='' && $guard->payrates_id!=null)
														{	
															$percent=$percent+20;
														}
														
														if($guard->specific_customers_id!='' && $guard->specific_customers_id!= null)
														{	
															$percent=$percent+20;
														}
														if($guard->profile_image =='')
														{	
															$percent=$percent-20;
														}
														
														;?>
														<?php 
															DB::table('guards')->where('id', $guard->id)->update(['profile_completion' => $percent]);
														?>
														@if($percent<=50)


														<div class="progress h-5px w-100">
															<div class="progress-bar bg-danger" role="progressbar" style="width: {{$percent}}%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
														</div>
														<span class="fw-bolder fs-6">{{$percent}}%</span>

									

															@else
															<div class="progress h-5px w-100">
																<div class="progress-bar bg-success" role="progressbar" style="width: {{$percent}}%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
																
															</div>
														<span class="fw-bolder fs-6">{{$percent}}%</span>

																	
														@endif
												</td>
												<td>{{$guard->last_login}}</td>

											</tr>
											@endforeach
											<!--end::Table row-->
										</tbody>
										<!--end::Table body-->
									</table>
									<!--end::Table-->
								</div>

								@stop