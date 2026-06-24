						@section('deleted_guards')
						<div  id="deleted_guards" >
									<!--begin::Table-->
									<table class="table align-middle table-row-dashed fs-6 gy-5" id="table">
								<!--begin::Table head-->
								<thead>
									<!--begin::Table row-->
									<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
									
										<th class="min-w-125px">Deleted {{config('custom.guard')}}</th>
										<th class="">Phone</th>
										<th class="">State</th>
										<th class="">Last Login</th>
										<th class="text-end min-w-100px"></th>
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
										<td>{{$guard->state}}</td>
								
										<td>{{$guard->last_login}}</td>
										<td class="text-end">
											<div class="menu-item px-3">
												<a type="button" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="" onclick="restoreguard( {{ $guard->id }})" >Restore</a>
											</div>
										</td>
										<!--end::Action=-->
									</tr>
									@endforeach
									<!--end::Table row-->
								</tbody>
								<!--end::Table body-->
									</table>
									<!--end::Table-->
								</div>

								@stop