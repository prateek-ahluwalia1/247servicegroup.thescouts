

 @extends('layout.app')
 @extends('layout.sidebar')
 @include('layout.toolbar')
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
     <link href="{{asset('')}}plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css"/>
     {{-- richtedxt --}}
     <link rel="stylesheet" href="{{asset('')}}richtext/richtext.min.css">
             <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
     <link href="https://cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">
     <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
 
<style>
	.no_profile{
		width: 20px !important;
height: 20px !important;
border-radius: 50% !important;
background: #04c8c8 !important;
font-size: 10px !important;
color: #fff !important;
text-align: center !important;
line-height: 20px !important;
margin: 2px 0 !important;
	}
	</style>


    @stop
    <!--end::Head-->
    <!--begin::Body-->
    @section('content')

        
        	<!--end::Aside-->
				<!--begin::Wrapper-->
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
					<!--begin::Header-->
					<div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
						<!--begin::Container-->
						<div class="container d-flex align-items-center justify-content-between" id="kt_header_container">
							<!--begin::Page title-->
							<div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-2 pb-2 pb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
								<!--begin::Heading-->
								<h1 class="text-dark fw-bolder my-0 fs-2">Feeds</h1>
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
								<a href="index.html" class="d-flex align-items-center">
									<img alt="Logo" src="{{asset('')}}media/logos/logo-demo-3.svg" class="h-30px" />
								</a>
								<!--end::Logo-->
							</div>
							<!--end::Wrapper-->
							@yield('toolbar')
							
						</div>
						<!--end::Container-->
					</div>
					<!--end::Header-->
					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Container-->
						<div class="container" id="kt_content_container">
							<!--begin::Row-->
							<div class="row g-5 g-xl-8">
								<!--begin::Col-->
						<div class="col-xl-6"  id="odd_div">
							<!--begin::Feeds Widget 1-->
							@if(session()->get('userType')=="admin")

							<div class="card mb-5 mb-xl-8">
								<!--begin::Body-->
								<div class="card-body pb-0">
									<form id="form_richtext" action="{{url('create_feed')}}" enctype="multipart/form-data" method="POST">
									<!--begin::Header-->
									<div class="d-flex align-items-center">
										<!--begin::User-->
										<div class="d-flex align-items-center flex-grow-1">
											<!--begin::Avatar-->
											<div class="symbol symbol-45px me-5">
												@if(session()->get('image')!=null )
												<img src="{{config('custom.asset_url')}}{{session()->get('image')}}" onerror="" alt="" />
												@else
														<img src="https://img.icons8.com/material-sharp/50/000000/user.png" >
														@endif
											</div>
											<!--end::Avatar-->
											<!--begin::Info-->
											<div class="d-flex flex-column">
												<a href="#" class="text-gray-800 text-hover-primary fs-6 fw-bolder">
													{{session()->get('userName')}}
												</a>
												<span class="text-gray-400 fw-bold">{{session()->get('userType')}}
												</span>
											</div>
											<input type="hidden" name="post_by_id" id="post_by_id" value="{{session()->get('userId')}}">
											

											<!--end::Info-->
										</div>
										<!--end::User-->
										<!--begin::Menu-->
										<div class="my-0">
											{{-- <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
												<!--begin::Svg Icon | path: icons/duotone/Layout/Layout-4-blocks-2.svg-->
												<span class="svg-icon svg-icon-2">
													<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
														<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
															<rect x="5" y="5" width="5" height="5" rx="1" fill="#000000" />
															<rect x="14" y="5" width="5" height="5" rx="1" fill="#000000" opacity="0.3" />
															<rect x="5" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3" />
															<rect x="14" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3" />
														</g>
													</svg>
												</span>
												<!--end::Svg Icon-->
											</button> --}}
										
										</div>
										<!--end::Menu-->
									</div>
									<!--end::Header-->
									<!--begin::Form-->
									<div id="kt_forms_widget_1_form" class="ql-quil ql-quil-plain pb-3">
										<!--begin::Editor-->
										<div id="kt_forms_widget_1_editor" class="py-6"></div>
										<!--end::Editor-->
										<div class="separator"></div>
										<!--begin::Toolbar-->
										<div id="kt_forms_widget_1_editor_toolbar" class="ql-toolbar d-flex flex-stack py-2">
											<div class="me-2">
												<span class="ql-formats ql-size ms-0">
													<select class="ql-size w-75px"></select>
												</span>
												<span class="ql-formats">
													<button class="ql-bold"></button>
													<button class="ql-italic"></button>
													<button class="ql-underline"></button>
													<button class="ql-strike"></button>
													<button class="ql-image"></button>
													<button class="ql-link"></button>
													<button class="ql-clean"></button>
												</span>
											</div>
											<div class="me-n3">
												<span class="btn btn-icon btn-sm btn-active-color-primary">
													<i class="flaticon2-clip-symbol icon-ms"></i>
												</span>
												<span class="btn btn-icon btn-sm btn-active-color-primary">
													<i class="flaticon2-pin icon-ms"></i>
												</span>
											</div>
										</div>
										<!--end::Toolbar-->
									</div>
									<div style="margin-bottom: 9px" class="text-center">
										<button type="reset" id="kt_modal_new_target_cancel" class="btn btn-white me-3">Cancel</button>
										<button type="submit" id="kt_modal_new_target_submit" class="btn btn-primary">
											<span class="indicator-label">Submit</span>
											<span class="indicator-progress">Please wait...
											<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
										</button>
									</div>
									</form>
									<!--end::Form-->
								</div>
								<!--end::Body-->
							</div>
			@endif
									
									@foreach($odds as $odd)
									<div class="card mb-5 mb-xl-8" >
										<!--begin::Body-->
										<div class="card-body pb-0">
											<!--begin::Header-->
											<div class="d-flex align-items-center mb-3">
												<!--begin::User-->
												<div class="d-flex align-items-center flex-grow-1">
													<!--begin::Avatar-->
													<div class="symbol symbol-45px me-5">
														@if($odd['image']!=null && $odd['image']!='null')
														{{-- onerror="non_profile(this)" id="" alt="" --}}
														<img src="{{config('custom.asset_url')}}{{$odd['image']}}" >
														@else
														<img 	src="https://img.icons8.com/material-sharp/50/000000/user.png" >
														@endif
													</div>
													<!--end::Avatar-->
													<!--begin::Info-->
													<div class="d-flex flex-column">
														<a  class="text-gray-800 text-hover-primary fs-6 fw-bolder">{{$odd['name']}}</a>
														<span class="text-gray-400 fw-bold">{{$odd['role']}}</span>
														<span class="text-gray-400 fw"> {{$odd['created']}}</span>
													</div>
													<!--end::Info-->
												</div>
												<!--end::User-->
												<!--begin::Menu-->
												@if(session()->get('userType')=='admin')

												<div class="my-0">
													<button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
														<!--begin::Svg Icon | path: icons/duotone/Layout/Layout-4-blocks-2.svg-->
														<span class="svg-icon svg-icon-2">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<rect x="5" y="5" width="5" height="5" rx="1" fill="#000000"></rect>
																	<rect x="14" y="5" width="5" height="5" rx="1" fill="#000000" opacity="0.3"></rect>
																	<rect x="5" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3"></rect>
																	<rect x="14" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3"></rect>
																</g>
															</svg>
														</span>
														<!--end::Svg Icon-->
													</button>
													<!--begin::Menu 2-->

													<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold w-200px" data-kt-menu="true">
														<!--begin::Menu item-->
														<div class="menu-item px-3">
															<div class="menu-content fs-6 text-dark fw-bolder px-3 py-4">Quick Actions</div>
														</div>
														<!--end::Menu item-->
														<!--begin::Menu separator-->
														<div class="separator mb-3 opacity-75"></div>
														<!--end::Menu separator-->
														<!--begin::Menu item-->
														{{-- <div class="menu-item px-3">
															<a href="#" class="menu-link px-3">EDIT</a>
														</div> --}}
														<!--end::Menu item-->
														<!--begin::Menu item-->
														<div class="menu-item px-3">
														<a  type="button" onclick="view_feed_status({{$odd['id']}})" class="menu-link px-3" >View</a>
														</div>
														<div class="menu-item px-3">
															

															<a type="button" onclick="delete_feed({{$odd['id']}})" class="menu-link px-3">DELETE</a>
														</div>
														<!--end::Menu item-->
													</div>
													<!--end::Menu 2-->
												</div>
												@endif

												<!--end::Menu-->
											</div>
											<!--end::Header-->
											<!--begin::Post-->
											<div class="mb-7">
												<!--begin::Text-->
												<div class="text-gray-800 mb-5">{!! $odd['html_body'] !!}</div>
												<!--end::Text-->
												<!--begin::Toolbar-->
												{{-- <div class="d-flex align-items-center mb-5">
													<a type="button"  onclick=" $('#comment_section_{{$odd['id']}}').toggle();" class="btn btn-sm btn-light btn-color-muted btn-active-light-success px-4 py-2 me-4">
													
													<span class="svg-icon svg-icon-3">
														<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
															<path d="M16,15.6315789 L16,12 C16,10.3431458 14.6568542,9 13,9 L6.16183229,9 L6.16183229,5.52631579 C6.16183229,4.13107011 7.29290239,3 8.68814808,3 L20.4776218,3 C21.8728674,3 23.0039375,4.13107011 23.0039375,5.52631579 L23.0039375,13.1052632 L23.0206157,17.786793 C23.0215995,18.0629336 22.7985408,18.2875874 22.5224001,18.2885711 C22.3891754,18.2890457 22.2612702,18.2363324 22.1670655,18.1421277 L19.6565168,15.6315789 L16,15.6315789 Z" fill="#000000"></path>
															<path d="M1.98505595,18 L1.98505595,13 C1.98505595,11.8954305 2.88048645,11 3.98505595,11 L11.9850559,11 C13.0896254,11 13.9850559,11.8954305 13.9850559,13 L13.9850559,18 C13.9850559,19.1045695 13.0896254,20 11.9850559,20 L4.10078614,20 L2.85693427,21.1905292 C2.65744295,21.3814685 2.34093638,21.3745358 2.14999706,21.1750444 C2.06092565,21.0819836 2.01120804,20.958136 2.01120804,20.8293182 L2.01120804,18.32426 C1.99400175,18.2187196 1.98505595,18.1104045 1.98505595,18 Z M6.5,14 C6.22385763,14 6,14.2238576 6,14.5 C6,14.7761424 6.22385763,15 6.5,15 L11.5,15 C11.7761424,15 12,14.7761424 12,14.5 C12,14.2238576 11.7761424,14 11.5,14 L6.5,14 Z M9.5,16 C9.22385763,16 9,16.2238576 9,16.5 C9,16.7761424 9.22385763,17 9.5,17 L11.5,17 C11.7761424,17 12,16.7761424 12,16.5 C12,16.2238576 11.7761424,16 11.5,16 L9.5,16 Z" fill="#000000" opacity="0.3"></path>
														</svg>
													</span>
													</a>
													@if($odd['like']== "liked")
													<a type="button" id="feed_like_button_{{$odd['id']}}"  onclick="check_like({{$odd['id']}},{{session()->get('userId')}},this.id)" class=" btn-danger btn btn-sm btn-light btn-color-muted  px-4 py-2">
													<span class="svg-icon svg-icon-2">
														<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
															<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																<polygon points="0 0 24 0 24 24 0 24" />
																<path d="M16.5,4.5 C14.8905,4.5 13.00825,6.32463215 12,7.5 C10.99175,6.32463215 9.1095,4.5 7.5,4.5 C4.651,4.5 3,6.72217984 3,9.55040872 C3,12.6834696 6,16 12,19.5 C18,16 21,12.75 21,9.75 C21,6.92177112 19.349,4.5 16.5,4.5 Z" fill="#000000" fill-rule="nonzero" />
															</g>
														</svg>
													</span>
													</a>
													<a type="button" onclick="count_likes({{$odd['id']}})" class="btn btn-active-success" data-bs-toggle="modal" >
														liked by 
													</a>
													
												@else
												<a type="button" id="feed_like_button_{{$odd['id']}}"  onclick="check_like({{$odd['id']}},{{session()->get('userId')}},this.id)" class="  btn btn-sm btn-light btn-color-muted  px-4 py-2">
													<span class="svg-icon svg-icon-2">
														<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
															<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																<polygon points="0 0 24 0 24 24 0 24" />
																<path d="M16.5,4.5 C14.8905,4.5 13.00825,6.32463215 12,7.5 C10.99175,6.32463215 9.1095,4.5 7.5,4.5 C4.651,4.5 3,6.72217984 3,9.55040872 C3,12.6834696 6,16 12,19.5 C18,16 21,12.75 21,9.75 C21,6.92177112 19.349,4.5 16.5,4.5 Z" fill="#000000" fill-rule="nonzero" />
															</g>
														</svg>
													</span>
													</a>
												
												@endif
											
												</div> --}}
												<!--end::Toolbar-->
											</div>
											<!--end::Post-->
											<!--begin::Replies-->
												
											<div id="comment_section_{{$odd['id']}}">
											@foreach ($odd['comments'] as $item)

												<div class="mb-7 ps-10" id="delete_comment_div_{{$item->id}}">
													<!--begin::Reply-->
													<div class="d-flex mb-5">
														<!--begin::Avatar-->
														<div class="symbol symbol-45px me-5">
															<img src="{{ config('asset_url') ;}}{{$item->image}}" alt="">
														</div>
														<!--end::Avatar-->
														<!--begin::Info-->
														<div class="d-flex flex-column flex-row-fluid">
															<!--begin::Info-->
															<div class="d-flex align-items-center flex-wrap mb-1">
																<a href="#" class="text-gray-800 text-hover-primary fw-bolder me-2">{{$item->name}}</a>
																<span class="text-gray-400 fw-bold fs-7">{{$item->created_at}}</span>
																@if(session()->get('userId')=="$item->commented_by_id")

																<a type="button" onclick="delete_comment({{$item->id}})" class="ms-auto text-gray-400 text-hover-primary fw-bold fs-7">Delete</a>
																@endif
															</div>
															<!--end::Info-->
															<!--begin::Post-->
															<span class="text-gray-800 fs-7 fw-normal pt-1">{{$item->message}}</span>
															<!--end::Post-->
														</div>
														<!--end::Info-->
													</div>
													<!--end::Reply-->
												</div>
											@endforeach

											</div>

											<!--end::Replies-->
											<!--begin::Separator-->
											<div class="separator mb-4"></div>
											<!--end::Separator-->
											<!--begin::Reply input-->
											{{-- <form id="comment-form_{{$odd['id']}}" action="{{url('post_comment')}}" method="POST" enctype="multipart/form-data" >
												<div class="position-relative mb-6">
													@csrf
													<textarea name="message" id="message_{{$odd['id']}}" class="form-control border-0 p-0 pe-10 resize-none min-h-25px" data-kt-autosize="true" rows="1" placeholder="Reply.."></textarea>
													<input type="hidden" name="name" id="name_{{$odd['id']}}" value="{{session()->get('userName')}}">
													<input type="hidden" name="commented_by_id" id="commented_by_id_{{$odd['id']}}" value="{{session()->get('userId')}}">
													<input type="hidden" name="image" id="image_{{$odd['id']}}" value="{{session()->get('image')}}">
													<input type="hidden" name="feed_id" id="feed_id_{{$odd['id']}}" value="{{$odd['id']}}">
	
													
	
													<div class="position-absolute top-0 end-0 me-n5">
														<button type="submit" class=" primary btn btn-primary">Reply</button>
													</div>
												</div>
	
												</form> --}}
											<!--edit::Reply input-->
										</div>
										<!--end::Body-->
									</div>
								
									@endforeach

									{{-- <button class="btn btn-primary w-100 text-center" id="kt_widget_5_load_more_btn">
										<span class="indicator-label">More Feeds</span>
										<span class="indicator-progress">Loading...
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
									</button> --}}
									<!--end::Feeds widget 4, 5 load more-->
								</div>
								<!--end::Col-->
								<!--begin::Col-->
								<div class="col-xl-6"  id="even_div">
									@foreach($evens as $even)
									<div class="card mb-5 mb-xl-8">
										<!--begin::Body-->
										<div class="card-body pb-0">
											<!--begin::Header-->
											<div class="d-flex align-items-center mb-3">
												<!--begin::User-->
												<div class="d-flex align-items-center flex-grow-1">
													<!--begin::Avatar-->
													<div class="symbol symbol-45px me-5">
														@if($even['image']!=null && $even['image']!='null')
														{{-- onerror="non_profile(this)" id="" alt="" --}}
														<img src="{{config('custom.asset_url')}}{{$even['image']}}" >
														@else
														<img 	src="https://img.icons8.com/material-sharp/50/000000/user.png" >
														@endif
														{{-- <img src="{{config('custom.asset_url')}}{{$even['image']}}" onerror="non_profile(this)" id="{{$even['name']}}_{{$even['id']}}" alt=""> --}}
													</div>
													<!--end::Avatar-->
													<!--begin::Info-->
													<div class="d-flex flex-column">
														<a  class="text-gray-800 text-hover-primary fs-6 fw-bolder">{{$even['name']}}</a>
														<span class="text-gray-400 fw-bold">{{$even['role']}}</span>
														<span class="text-gray-400 fw"> {{$even['created']}}</span>
													</div>
													<!--end::Info-->
												</div>
												<!--end::User-->
												<!--begin::Menu-->
												@if(session()->get('userType')=='admin' )

												<div class="my-0">
													<button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
														<!--begin::Svg Icon | path: icons/duotone/Layout/Layout-4-blocks-2.svg-->
														<span class="svg-icon svg-icon-2">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<rect x="5" y="5" width="5" height="5" rx="1" fill="#000000"></rect>
																	<rect x="14" y="5" width="5" height="5" rx="1" fill="#000000" opacity="0.3"></rect>
																	<rect x="5" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3"></rect>
																	<rect x="14" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3"></rect>
																</g>
															</svg>
														</span>
														<!--end::Svg Icon-->
													</button>
													<!--begin::Menu 2-->
													<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold w-200px" data-kt-menu="true">
														<!--begin::Menu item-->
														<div class="menu-item px-3">
															<div class="menu-content fs-6 text-dark fw-bolder px-3 py-4">Quick Actions</div>
														</div>
														<!--end::Menu item-->
														<!--begin::Menu separator-->
														<div class="separator mb-3 opacity-75"></div>
														<!--end::Menu separator-->
														<!--begin::Menu item-->
														{{-- <div class="menu-item px-3">
															<a href="#" class="menu-link px-3">EDIT</a>
														</div> --}}
														<!--end::Menu item-->
														<!--begin::Menu item-->
														<div class="menu-item px-3">
															<a  type="button" onclick="view_feed_status({{$even['id']}})" class="menu-link px-3"> View</a>
														</div>
														<div class="menu-item px-3">
															

															<a type="button" onclick="delete_feed({{$even['id']}})" class="menu-link px-3">DELETE</a>
														</div>
														<!--end::Menu item-->
													</div>
													<!--end::Menu 2-->
												</div>
												@endif

												<!--end::Menu-->
											</div>
											<!--end::Header-->
											<!--begin::Post-->
											<div class="mb-7">
												<!--begin::Text-->
												<div class="text-gray-800 mb-5">{!! $even['html_body'] !!}</div>
												<!--end::Text-->
												<!--begin::Toolbar-->
												<div class="d-flex align-items-center mb-5">
													{{-- <a type="button"  onclick=" $('#comment_section_{{$even['id']}}').toggle();" class="btn btn-sm btn-light btn-color-muted btn-active-light-success px-4 py-2 me-4">
														<!--begin::Svg Icon | path: icons/duotone/Communication/Group-chat.svg-->
													<span class="svg-icon svg-icon-3">
														<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
															<path d="M16,15.6315789 L16,12 C16,10.3431458 14.6568542,9 13,9 L6.16183229,9 L6.16183229,5.52631579 C6.16183229,4.13107011 7.29290239,3 8.68814808,3 L20.4776218,3 C21.8728674,3 23.0039375,4.13107011 23.0039375,5.52631579 L23.0039375,13.1052632 L23.0206157,17.786793 C23.0215995,18.0629336 22.7985408,18.2875874 22.5224001,18.2885711 C22.3891754,18.2890457 22.2612702,18.2363324 22.1670655,18.1421277 L19.6565168,15.6315789 L16,15.6315789 Z" fill="#000000"></path>
															<path d="M1.98505595,18 L1.98505595,13 C1.98505595,11.8954305 2.88048645,11 3.98505595,11 L11.9850559,11 C13.0896254,11 13.9850559,11.8954305 13.9850559,13 L13.9850559,18 C13.9850559,19.1045695 13.0896254,20 11.9850559,20 L4.10078614,20 L2.85693427,21.1905292 C2.65744295,21.3814685 2.34093638,21.3745358 2.14999706,21.1750444 C2.06092565,21.0819836 2.01120804,20.958136 2.01120804,20.8293182 L2.01120804,18.32426 C1.99400175,18.2187196 1.98505595,18.1104045 1.98505595,18 Z M6.5,14 C6.22385763,14 6,14.2238576 6,14.5 C6,14.7761424 6.22385763,15 6.5,15 L11.5,15 C11.7761424,15 12,14.7761424 12,14.5 C12,14.2238576 11.7761424,14 11.5,14 L6.5,14 Z M9.5,16 C9.22385763,16 9,16.2238576 9,16.5 C9,16.7761424 9.22385763,17 9.5,17 L11.5,17 C11.7761424,17 12,16.7761424 12,16.5 C12,16.2238576 11.7761424,16 11.5,16 L9.5,16 Z" fill="#000000" opacity="0.3"></path>
														</svg>
													</span>
													</a>
													@if($even['like']== "liked")
														<a type="button" id="feed_like_button_{{$even['id']}}"  onclick="check_like({{$even['id']}},{{session()->get('userId')}},this.id)" class=" btn-danger btn btn-sm btn-light btn-color-muted  px-4 py-2">
														<span class="svg-icon svg-icon-2">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<polygon points="0 0 24 0 24 24 0 24" />
																	<path d="M16.5,4.5 C14.8905,4.5 13.00825,6.32463215 12,7.5 C10.99175,6.32463215 9.1095,4.5 7.5,4.5 C4.651,4.5 3,6.72217984 3,9.55040872 C3,12.6834696 6,16 12,19.5 C18,16 21,12.75 21,9.75 C21,6.92177112 19.349,4.5 16.5,4.5 Z" fill="#000000" fill-rule="nonzero" />
																</g>
															</svg>
														</span>
														</a>
														<a type="button" onclick="count_likes({{$even['id']}})" class="btn btn-active-success" data-bs-toggle="modal" >
														liked by 
													</a>
													@else
													<a type="button" id="feed_like_button_{{$even['id']}}"  onclick="check_like({{$even['id']}},{{session()->get('userId')}},this.id)" class="btn btn-sm btn-light btn-color-muted  px-4 py-2">
														<span class="svg-icon svg-icon-2">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<polygon points="0 0 24 0 24 24 0 24" />
																	<path d="M16.5,4.5 C14.8905,4.5 13.00825,6.32463215 12,7.5 C10.99175,6.32463215 9.1095,4.5 7.5,4.5 C4.651,4.5 3,6.72217984 3,9.55040872 C3,12.6834696 6,16 12,19.5 C18,16 21,12.75 21,9.75 C21,6.92177112 19.349,4.5 16.5,4.5 Z" fill="#000000" fill-rule="nonzero" />
																</g>
															</svg>
														</span>
														</a>
													
													@endif --}}
												</div>
												<!--end::Toolbar-->
											</div>
											<!--end::Post-->
											<!--begin::Replies-->
											<div id="comment_section_{{$even['id']}}">
												@foreach ($even['comments'] as $item)

												<div class="mb-7 ps-10" id="delete_comment_div_{{$item->id}}">
													<!--begin::Reply-->
													<div class="d-flex mb-5">
														<!--begin::Avatar-->
														<div class="symbol symbol-45px me-5">
															<img src="{{ config('asset_url') ;}}{{$item->image}}" alt="">
														</div>
														<!--end::Avatar-->
														<!--begin::Info-->
														<div class="d-flex flex-column flex-row-fluid">
															<!--begin::Info-->
															<div class="d-flex align-items-center flex-wrap mb-1">
																<a href="#" class="text-gray-800 text-hover-primary fw-bolder me-2">{{$item->name}}</a>
																<span class="text-gray-400 fw-bold fs-7">{{$item->created_at}}</span>
																<a type="button" onclick="delete_comment({{$item->id}})" class="ms-auto text-gray-400 text-hover-primary fw-bold fs-7">Delete</a>

															</div>
															<!--end::Info-->
															<!--begin::Post-->
															<span class="text-gray-800 fs-7 fw-normal pt-1">{{$item->message}}</span>
															<!--end::Post-->
														</div>
														<!--end::Info-->
													</div>
													<!--end::Reply-->
												</div>
											@endforeach
											
											</div>
											<!--end::Replies-->
											<!--begin::Separator-->
											<div class="separator mb-4"></div>
											<!--end::Separator-->
											<!--begin::Reply input-->
											{{-- <form id="comment-form_{{$even['id']}}" action="{{url('post_comment')}}" method="POST" enctype="multipart/form-data" >
												<div class="position-relative mb-6">
													@csrf
													<textarea name="message" id="message_{{$even['id']}}" class="form-control border-0 p-0 pe-10 resize-none min-h-25px" data-kt-autosize="true" rows="1" placeholder="Reply.."></textarea>
													<input type="hidden" name="name" id="name_{{$even['id']}}" value="{{session()->get('userName')}}">
													<input type="hidden" name="commented_by_id" id="commented_by_id_{{$even['id']}}" value="{{session()->get('userId')}}">
													<input type="hidden" name="image" id="image_{{$even['id']}}" value="{{session()->get('image')}}">
													<input type="hidden" name="feed_id" id="feed_id_{{$even['id']}}" value="{{$even['id']}}">
	
													
	
													<div class="position-absolute top-0 end-0 me-n5">
														<button type="submit" class=" primary btn btn-primary">Reply</button>
													</div>
												</div>
	
												</form> --}}
											<!--edit::Reply input-->
										</div>
										<!--end::Body-->
									</div>
								

									@endforeach
								
								</div>
								<!--end::Col-->
							</div>
							<!--end::Row-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Content-->
		


				
					
					<div class="modal fade" tabindex="-1" id="kt_modal_1">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title">LIKED BY</h5>
					
									<!--begin::Close-->
									<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
										<span class="svg-icon svg-icon-2x"></span>
									</div>
									<!--end::Close-->
								</div>
					
								<div class="modal-body">
									<div id="modal_content"></div>
								</div>
					
								<div class="modal-footer">
									<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>

								</div>
							</div>
						</div>
					</div>



					<div class="modal fade" tabindex="-1" id="kt_modal_2">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title">Seen By</h5>
					
									<!--begin::Close-->
									<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
										<span class="svg-icon svg-icon-2x"></span>
									</div>
									<!--end::Close-->
								</div>
					
								<div class="modal-body" id="induction_seen">
									{{-- <p></p> --}}
								</div>
					
								<div class="modal-footer">
									<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
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
 {{-- <script src="{{asset('')}}js/custom/modals/share-earn.js"></script> --}}
 <script src="{{asset('')}}js/custom/widgets.js"></script>
 <script src="{{asset('')}}js/custom/apps/chat/chat.js"></script>
 <script src="{{asset('')}}js/custom/modals/create-app.js"></script>
 <script src="{{asset('')}}js/custom/modals/upgrade-plan.js"></script>
 <script src="{{asset('')}}plugins/global/plugins.bundle.js"></script>
 {{-- richtext --}}
 <script type="text/javascript" src="{{asset('')}}richtext/jquery.richtext.js"></script>
 <script type="text/javascript" src="{{asset('')}}richtext/jquery.richtext.min.js"></script>

 {{-- <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script> --}}
 
 
 <script>




  
$("#form_richtext").on('submit', function(e){
     e.preventDefault();
     console.log(this.id);
	 var post_by_id= $('#post_by_id').val();


 var htmlBody= $('.ql-editor').html();
	
	//  console.log(html_bb);
     var data = $('#'+this.id).serialize();

     $.ajax({type: "POST",url: this.action,data :{post_by_id: post_by_id,_token: '<?php echo csrf_token()?>',htmlBody:htmlBody} ,success: function(result){if(result.success){
     	// $('#induction_modal').modal('hide');

									Swal.fire({
													text: result.message,
													icon: "success",
													buttonsStyling: !1,
													confirmButtonText: "Ok, got it!",
													customClass: {
														confirmButton: "btn btn-light"
													}
						})
						// console.log(result.feed_id);
						window.location.href = "{{ url('/news_and_feeds')}}";
						
						// get_last_row(result.feed_id);

					
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

  function check_like(feed_id,user_id,id){
	
     $.ajax({type: "POST",url: "{{url('check_like')}}",data : {feed_id:feed_id,user_id:user_id,_token: '<?php echo csrf_token()?>'} ,success: function(result){if(result.liked){
				// $('#'+id).addClass("btn-danger");
				console.log('#'+id);
				$('#'+id).addClass("btn-danger");
				

					}else{
							console.log('unlike');
				$('#'+id).removeClass("btn-danger");

							
					}}})
  }
  
$("body").on('submit',"form[id^='comment-form_']", function(e){
     e.preventDefault();
     console.log(this.id);
     var data = $('#'+this.id).serialize();

     $.ajax({type: "POST",url: this.action,data :data ,success: function(result){if(result.success){
     	// $('#induction_modal').modal('hide');
						console.log(result.comment_id);
						get_last_row_comment(result.comment_id);

					
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

//   function get_last_row(id){

// 	$.ajax({
// 		type: "POST",
//         url: "{{url('get_feed')}}",
//         data : {id:id,_token:'<?php echo csrf_token();?>'},
//         success: function(result){
// 			// $('#kt_widget_5_load_more_btn').click();
//         	console.log(result[0]);
//         	// console.log(result0);
//             // result = JSON.parse(result);

// 			$.each(result[0], function(id, data) {
// 				var siteData2 ='';
// 				siteData2  += 	`	<div class="card mb-5 mb-xl-8">
// 										<!--begin::Body-->
// 										<div class="card-body pb-0">
// 											<!--begin::Header-->
// 											<div class="d-flex align-items-center mb-3">
// 												<!--begin::User-->
// 												<div class="d-flex align-items-center flex-grow-1">
// 													<!--begin::Avatar-->
// 													<div class="symbol symbol-45px me-5">
// 														<img src="{{config('custom.asset_url')}}${data.image}" alt="">
// 													</div>
// 													<!--end::Avatar-->
// 													<!--begin::Info-->
// 													<div class="d-flex flex-column">
// 														<a  class="text-gray-800 text-hover-primary fs-6 fw-bolder">${data.name}</a>
// 														<span class="text-gray-400 fw-bold">${data.role}</span>
// 														<span class="text-gray-400 fw"> ${data.created}</span>
// 													</div>
// 													<!--end::Info-->
// 												</div>
// 												<!--end::User-->
// 												<!--begin::Menu-->
// 												<div class="my-0">
// 													<button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
// 														<!--begin::Svg Icon | path: icons/duotone/Layout/Layout-4-blocks-2.svg-->
// 														<span class="svg-icon svg-icon-2">
// 															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
// 																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
// 																	<rect x="5" y="5" width="5" height="5" rx="1" fill="#000000"></rect>
// 																	<rect x="14" y="5" width="5" height="5" rx="1" fill="#000000" opacity="0.3"></rect>
// 																	<rect x="5" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3"></rect>
// 																	<rect x="14" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3"></rect>
// 																</g>
// 															</svg>
// 														</span>
// 														<!--end::Svg Icon-->
// 													</button>
// 													<!--begin::Menu 2-->
// 													<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold w-200px" data-kt-menu="true">
// 														<!--begin::Menu item-->
// 														<div class="menu-item px-3">
// 															<div class="menu-content fs-6 text-dark fw-bolder px-3 py-4">Quick Actions</div>
// 														</div>
// 														<!--end::Menu item-->
// 														<!--begin::Menu separator-->
// 														<div class="separator mb-3 opacity-75"></div>
// 														<!--end::Menu separator-->
// 														<!--begin::Menu item-->
// 														{{-- <div class="menu-item px-3">
// 															<a href="#" class="menu-link px-3">EDIT</a>
// 														</div> --}}
// 														<!--end::Menu item-->
// 														<!--begin::Menu item-->
// 														<div class="menu-item px-3">
// 															<a  type="button" onclick="view_feed_status(${data.id})"  class="menu-link px-3">View</a>
// 														</div>
// 														<div class="menu-item px-3">
															

// 															<a type="button" onclick="delete_feed(${data.id})" class="menu-link px-3">DELETE</a>
// 														</div>
// 														<!--end::Menu item-->
// 													</div>
// 													<!--end::Menu 2-->
// 												</div>
// 												<!--end::Menu-->
// 											</div>
// 											<!--end::Header-->
// 											<!--begin::Post-->
// 											<div class="mb-7">
// 												<!--begin::Text-->
// 												<div class="text-gray-800 mb-5"> ${data.html_body}</div>
// 												<!--end::Text-->
// 												<!--begin::Toolbar-->
// 												<!--<div class="d-flex align-items-center mb-5">
// 													<a href="#" class="btn btn-sm btn-light btn-color-muted btn-active-light-success px-4 py-2 me-4">
													
// 													<span class="svg-icon svg-icon-3">
// 														<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
// 															<path d="M16,15.6315789 L16,12 C16,10.3431458 14.6568542,9 13,9 L6.16183229,9 L6.16183229,5.52631579 C6.16183229,4.13107011 7.29290239,3 8.68814808,3 L20.4776218,3 C21.8728674,3 23.0039375,4.13107011 23.0039375,5.52631579 L23.0039375,13.1052632 L23.0206157,17.786793 C23.0215995,18.0629336 22.7985408,18.2875874 22.5224001,18.2885711 C22.3891754,18.2890457 22.2612702,18.2363324 22.1670655,18.1421277 L19.6565168,15.6315789 L16,15.6315789 Z" fill="#000000"></path>
// 															<path d="M1.98505595,18 L1.98505595,13 C1.98505595,11.8954305 2.88048645,11 3.98505595,11 L11.9850559,11 C13.0896254,11 13.9850559,11.8954305 13.9850559,13 L13.9850559,18 C13.9850559,19.1045695 13.0896254,20 11.9850559,20 L4.10078614,20 L2.85693427,21.1905292 C2.65744295,21.3814685 2.34093638,21.3745358 2.14999706,21.1750444 C2.06092565,21.0819836 2.01120804,20.958136 2.01120804,20.8293182 L2.01120804,18.32426 C1.99400175,18.2187196 1.98505595,18.1104045 1.98505595,18 Z M6.5,14 C6.22385763,14 6,14.2238576 6,14.5 C6,14.7761424 6.22385763,15 6.5,15 L11.5,15 C11.7761424,15 12,14.7761424 12,14.5 C12,14.2238576 11.7761424,14 11.5,14 L6.5,14 Z M9.5,16 C9.22385763,16 9,16.2238576 9,16.5 C9,16.7761424 9.22385763,17 9.5,17 L11.5,17 C11.7761424,17 12,16.7761424 12,16.5 C12,16.2238576 11.7761424,16 11.5,16 L9.5,16 Z" fill="#000000" opacity="0.3"></path>
// 														</svg>
// 													</span>
// 													</a>
// 													<a type="button" id="feed_like_button__${data.id}"  onclick="check_like(${data.id},{{session()->get('userId')}},this.id)" class="btn btn-sm btn-light btn-color-muted  px-4 py-2">
// 														<span class="svg-icon svg-icon-2">
// 															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
// 																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
// 																	<polygon points="0 0 24 0 24 24 0 24" />
// 																	<path d="M16.5,4.5 C14.8905,4.5 13.00825,6.32463215 12,7.5 C10.99175,6.32463215 9.1095,4.5 7.5,4.5 C4.651,4.5 3,6.72217984 3,9.55040872 C3,12.6834696 6,16 12,19.5 C18,16 21,12.75 21,9.75 C21,6.92177112 19.349,4.5 16.5,4.5 Z" fill="#000000" fill-rule="nonzero" />
// 																</g>
// 															</svg>
// 														</span>
// 														</a>
											
// 												</div>-->
// 												<!--end::Toolbar-->
// 											</div>
// 											<!--end::Post-->
// 											<!--begin::Replies-->
												
// 											<div id="comment_section_${data.id}">

// 											</div>

// 											<!--end::Replies-->
// 											<!--begin::Separator-->
// 											<div class="separator mb-4"></div>
// 											<!--end::Separator-->
// 											<!--begin::Reply input-->
// 											<!--<form id="comment-form_${data.id}" action="{{url('post_comment')}}" method="POST" enctype="multipart/form-data" >
// 												<div class="position-relative mb-6">
// 													@csrf
// 													<textarea name="message" id="message_${data.id}" class="form-control border-0 p-0 pe-10 resize-none min-h-25px" data-kt-autosize="true" rows="1" placeholder="Reply.."></textarea>
// 													<input type="hidden" name="name" id="name_${data.id}" value="{{session()->get('userName')}}">
// 													<input type="hidden" name="commented_by_id" id="commented_by_id_${data.id}}" value="{{session()->get('userId')}}">
// 													<input type="hidden" name="image" id="image_${data.id}" value="{{session()->get('image')}}">
// 													<input type="hidden" name="feed_id" id="feed_id_${data.id}" value="${data.id}">
	
// 													<div class="position-absolute top-0 end-0 me-n5">
// 														<button type="submit" class=" primary btn btn-primary">Reply</button>
// 													</div>
// 												</div>
	
// 												</form>-->
// 											<!--edit::Reply input-->
// 										</div>
// 										<!--end::Body-->
// 									</div>`;
// 								if(data.id % 2 == 0){
// 									$("#even_div").append(siteData2);
									
// 								}else{
// 									$("#odd_div").append(siteData2);

// 								}
// 			});

//         }
// 	});


//   }


  
  function get_last_row_comment(id){

$.ajax({
	type: "POST",
	url: "{{url('get_comment')}}",
	data : {id:id,_token:'<?php echo csrf_token();?>'},
	success: function(result){
		// $('#kt_widget_5_load_more_btn').click();
		console.log("enter in comment ");
		// result = JSON.parse(result);

		$.each(result, function(id, data) {
			var siteData2 ='';
			// siteData2  += 	`<div class="d-flex mb-7 ps-10" id="delete_comment_div_${data.id}">
			// 										<!--begin::Avatar-->
			// 										<div class="symbol symbol-45px me-5">
			// 											<img src="{{config('custom.asset_url')}}${data.image}" alt="">
			// 										</div>
			// 										<!--end::Avatar-->
			// 										<!--begin::Info-->
			// 										<div class="d-flex flex-column flex-row-fluid">
			// 											<!--begin::Info-->
			// 											<div class="d-flex align-items-center flex-wrap mb-1">
			// 												<a href="#" class="text-gray-800 text-hover-primary fw-bolder me-2">${data.name}</a>
			// 												<span class="text-gray-400 fw-bold fs-7">${data.created_at}</span>
			// 												<a type="button"  onclick="delete_comment(${data.id})" class="ms-auto text-gray-400 text-hover-primary fw-bold fs-7">Delete</a>
			// 											</div>
			// 											<!--end::Info-->
			// 											<!--begin::Post-->
			// 											<span class="text-gray-800 fs-7 fw-normal pt-1">${data.message}".</span>
			// 											<!--end::Post-->
			// 										</div>
			// 										<!--end::Info-->
			// 									</div>`;
			$("#comment_section_" + data.feed_id).append(siteData2);
			console.log("comment_section_" + data.feed_+id);
		});

	}
});


}
function delete_comment(id){
	
$.ajax({
	type: "POST",
	url: "{{url('delete_comment')}}",
	data : {id:id,_token:'<?php echo csrf_token();?>'},
	success: function(result){
		console.log("deleted");
		$("#delete_comment_div_"+id).remove();
	}
});

}
function delete_feed(id){
	
	$.ajax({
		type: "POST",
		url: "{{url('delete_feed')}}",
		data : {id:id,_token:'<?php echo csrf_token();?>'},
		success: function(result){
			if(result.success){
			Swal.fire({
													text: result.message,
													icon: "success",
													buttonsStyling: !1,
													confirmButtonText: "Ok, got it!",
													customClass: {
														confirmButton: "btn btn-light"
													}
						})
						console.log(result.feed_id);
						// get_last_row(result.feed_id);
						window.location.href = "{{ url('/news_and_feeds')}}";

					
					}
					else{Swal.fire({
											text: result.error,
											icon: "error",
											buttonsStyling: !1,
											confirmButtonText: "Ok, got it!",
											customClass: {
												confirmButton: "btn btn-light"
											}
										})}}})
	
	}
	

 function count_likes(id){
	// #kt_modal_1"

	
$.ajax({
	type: "POST",
	url: "{{url('count_likes')}}",
	data : {id:id,_token:'<?php echo csrf_token();?>'},
	success: function(result){
		console.log("count likes");
		var siteData2 ='<ul class="list-group">';

		$.each(result, function(id, data) {
			siteData2  += 	`<li class="list-group-item list-group-item-warning">${data.liked_by_name}</li>`;
});
	siteData2+=`</ul>`;
		$("#modal_content").html(siteData2);
		$("#kt_modal_1").modal('show');

 }
});
}

function non_profile(e)
{
		e.src=`https://img.icons8.com/material-sharp/50/000000/user.png`;
	// console.log(e.id);
	// name=e.id;
	// 		var intials = name.charAt(0);
	// 		console.log(intials);
	// 		$(e).addClass('no_profile')
	// 		var profileImage = $(e).text(intials);
}
function view_feed_status(id){
	$.ajax({type: "POST",url:"{{url('view_feed_status')}}",data:{id:id,_token:'<?php echo csrf_token();?>'} ,success: function(result){
		var html='';
		$('#induction_seen').empty();

		$('#kt_modal_2').modal('show');
		if(result!=''){

			$.each(result,function(id,data){
				html+=`<p>${data.name} ,</p>`;
				$('#induction_seen').append(html);

			});
			
		}
		else{
			html+=`<p>No view yet</p>`;
				$('#induction_seen').append(html);

		}
		var html='';


}
});
 

}


</script>

     @stop