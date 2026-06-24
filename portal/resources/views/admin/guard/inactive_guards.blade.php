@section('inactive_guards')
<div >
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="table">
                <!--begin::Table head-->
                <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                        
                    
                        <th class="min-w-125px">Inactive {{config('custom.guard')}}</th>
                        <!-- <th class="min-w-125px">Role</th> -->
                        <th class="">Phone</th>
                        <th class="">Suburb</th>
                        <th class="">State</th>
                        <th class="">Covid-19</th>
                        <th class="">Admin Approved</th>
                        <th class="">Active Status</th>
                        <th class="">Profile</th>
                        <th class="">Last Login</th>
                        <th class="text-end"></th>
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
                            <div class="form-check form-check-solid form-switch fv-row">

                                @if($guard->covid==1)

                                <input class="form-check-input w-45px h-30px" type="checkbox" id="covid"  name="covid" onchange="covid_status({{$guard->id}},this)" checked="checked">
                                @else

                                <input class="form-check-input w-45px h-30px" type="checkbox" id="covid"  name="covid" onchange="covid_status({{$guard->id}},this)" >
                                    
                                @endif
                                <label class="form-check-label" for="covid"></label>
                            </div>
                        </td>
                        
                        <td>
                            <div class="form-check form-check-solid form-switch fv-row">

                                @if($guard->status == 'active')

                                <input class="form-check-input w-45px h-30px" type="checkbox" id="approval_status" name="approval_status" onchange="admin_approval_status({{$guard->id}},this)" checked="checked">
                                @else

                                <input class="form-check-input w-45px h-30px" type="checkbox" id="approval_status" name="approval_status" onchange="admin_approval_status({{$guard->id}},this)" >
                                    
                                @endif
                            
                            </div>
                        </td>

                        <td>
                            <div class="form-check form-check-solid form-switch fv-row">

                                @if($guard->admin_approved == 1)

                                <input class="form-check-input w-45px h-30px" type="checkbox" id="active_inactive_status" name="active_inactive_status" onchange="guard_active_inactive_status({{$guard->id}},this)" checked="checked">
                                @else

                                <input class="form-check-input w-45px h-30px" type="checkbox" id="active_inactive_status" name="active_inactive_status" onchange="guard_active_inactive_status({{$guard->id}},this)" >
                                    
                                @endif
                            
                            </div>
                        </td>
                    
                        <td>
                            <?php 
                            $percent=0;
                            if($guard->name!='' && $guard->coordinates!='' && $guard->address!='')
                                {	
                                    $percent=$percent+20;
                                }
                                
                                if ($guard->residential_status == 'student') {
            if ($guard->driver_license_file != '') {
                $percent += 8;
            }
            if ($guard->security_license_file != '') {
                $percent += 8;
            }
            if ($guard->visa_file != '') {
                $percent += 7;
            }
            if ($guard->passport_file != '') {
                $percent += 7;
            }
        }elseif($guard->residential_status == 'citizen'){
            if ($guard->driver_license_file != '') {
                $percent += 15;
            }
            if ($guard->security_license_file != '') {
                $percent += 15;
            }
        }elseif ($guard->residential_status == 'subclass-485') {
            if ($guard->driver_license_file != '') {
                $percent += 8;
            }
            if ($guard->security_license_file != '') {
                $percent += 8;
            }
            if ($guard->visa_file != '') {
                $percent += 7;
            }
            if ($guard->passport_file != '') {
                $percent += 7;
            }
        }elseif ($guard->residential_status == 'permanent-resident') {
            if ($guard->driver_license_file != '') {
                $percent += 10;
            }
            if ($guard->security_license_file != '') {
                $percent += 10;
            }
            if ($guard->citizenship_file != '') {
                $percent += 10;
            }
            
        }else {
            if ($guard->driver_license_file != '') {
                $percent += 8;
            }
            if ($guard->security_license_file != '') {
                $percent += 8;
            }
            if ($guard->visa_file != '') {
                $percent += 7;
            }
            if ($guard->passport_file != '') {
                $percent += 7;
            }
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




                        <!--end::Last login=-->
                        <!--begin::Two step=-->
                        <!-- <td></td> -->
                        <!--end::Two step=-->
                        <!--begin::Joined-->
                        <!--begin::Joined-->
                        <!--begin::Action=-->
                


                        <td class="text-end">
                            <div class="d-flex justify-content-end flex-shrink-0">
                                
                                <a href="{{url('edit_guard')}}/{{$guard->id}}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                    <!--begin::Svg Icon | path: icons/duotone/Communication/Write.svg-->
                                    <span class="svg-icon svg-icon-3">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953)"></path>
                                                                <path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                                            </svg>
                                                        </span>
                                    <!--end::Svg Icon-->
                                </a>
                                <a type="button" onclick="deleteUser({{$guard->id}})" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                    <!--begin::Svg Icon | path: icons/duotone/General/Trash.svg-->
                                    <span class="svg-icon svg-icon-3">
                                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                                    <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path>
                                                                    <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path>
                                                                </g>
                                                            </svg>
                                                        </span>
                                    <!--end::Svg Icon-->
                                </a>
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