<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head><base href="../../../">
		<meta charset="utf-8" />
		<title>{{ config('custom.title')}}</title>
		<meta name="description" content="{{ config('custom.title') }}" />
		<meta name="keywords" content="{{ config('custom.title')}}" />
		<link rel="canonical" href="Https://preview.keenthemes.com/metronic8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!-- <link rel="shortcut icon" href="{{ asset(''); }}media/logos/favicon.ico" /> -->
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="{{ asset(''); }}plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="{{ asset(''); }}css/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" style="background-color: #181c32;">
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Authentication - Sign-in -->
			<div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url({{asset('')}}media/illustrations/progress-hd.png)">
				<!--begin::Content-->
				<div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
					<!--begin::Logo-->
					<div class="aside-logo d-none d-lg-flex flex-column align-items-center flex-column-auto " id="kt_aside_logo">
						<a href="{{url('')}}">
					   
							@if(config('custom.business_type')=="demo")
							<img alt="{{ config('custom.title')}}" style="margin-left: 30%;margin-bottom:20%" src="{{asset('')}}media/logo.png" class="h-70px">
							@else
							<img alt="{{ config('custom.title')}}" style="margin-left: 30%;margin-bottom:20%" src="{{config('custom.logo')}}" class="h-70px">
							@endif   
				   </a> 
			   </div>
					<!--end::Logo-->
					<!--begin::Wrapper-->
					<div class="w-lg-500px bg-white rounded shadow-sm p-10 p-lg-15 mx-auto">
						<!--begin::Form-->
						<form class="form w-100" novalidate="novalidate" id="kt_sign_in_for" action="{{ url('/guard_login')  }}" method="POST">
							@csrf
							<!--begin::Heading-->
							<div class="text-center mb-10">
								<!--begin::Title-->
								<h1 class="text-dark mb-3">{{ config('custom.title')}}</h1>
								<h5 class="text-dark mb-3" >Login to {{config('custom.guard')}}</h5>
								<!--end::Title-->
								<!--begin::Link-->
								<!-- <div class="text-gray-400 fw-bold fs-4">New Here?
								<a href="authentication/flows/basic/sign-up.html" class="link-primary fw-bolder">Create an Account</a></div> -->
								<!--end::Link-->
							</div>
							<nav class="nav nav-pills nav-justified">
								<a class="nav-item nav-link "  href="{{url('/')}}">Admin</a>
								<a class="nav-item nav-link active" > {{config('custom.guard')}}</a>
								<a class="nav-item nav-link" href="{{url('customer')}}">Customer</a>
								<a class="nav-item nav-link  " href="{{url('contractor')}}">Contractor</a>
								@if(config('custom.support') == 1)
								<a class="nav-item nav-link " href="{{url('support')}}">Support</a>
								@endif
							  </nav>
							  <br>
							<!--begin::Heading-->
							<!--begin::Input group-->
							<div class="fv-row mb-10">
								<!--begin::Label-->
								<label class="form-label fs-6 fw-bolder text-dark">Email</label>
								<!--end::Label-->
								<!--begin::Input-->
								<input class="form-control form-control-lg form-control-solid" type="text" required name="email" autocomplete="off" />
								<!--end::Input-->
							</div>
							<!--end::Input group-->
							<!--begin::Input group-->
							<div class="fv-row mb-10">
								<!--begin::Wrapper-->
								<div class="d-flex flex-stack mb-2">
									<!--begin::Label-->
									<label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
									<!--end::Label-->
									<!--begin::Link-->
									<a href="{{url('/guard/forgot_password')}}" class="link-primary fs-6 fw-bolder">Forgot Password ?</a>
									<!--end::Link-->
								</div>
								<!--end::Wrapper-->
								<!--begin::Input-->
								<input class="form-control form-control-lg form-control-solid" type="password" required name="password" autocomplete="off" />
								<!--end::Input-->
							</div>
							<!--end::Input group-->
							<!--begin::Actions-->
							<div class="text-center">
								<!--begin::Submit button-->
								<button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
									<span class="indicator-label">Signin</span>
									<span class="indicator-progress">Please wait...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
								</button>
							</div>
						</form>
						<!--end::Form-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Content-->
			</div>
			<!--end::Authentication - Sign-in-->
		</div>
		<!--end::Main-->
		<!--begin::Javascript-->
		<script type="text/javascript">
			var base_url = '{{ url('') }}';
	
		</script>
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="{{ asset(''); }}plugins/global/plugins.bundle.js"></script>
		<script src="{{ asset(''); }}js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Page Custom Javascript(used by this page)-->
		<script src="{{ asset(''); }}js/custom/authentication/sign-in/general.js"></script>
		<!--end::Page Custom Javascript-->
		<!--end::Javascript-->
	</body>
	@if(session('msg'))
<script type="text/javascript">
   toastr.options = {
			  "closeButton": true,
			  "debug": false,
			  "newestOnTop": false,
			  "progressBar": false,
			  "positionClass": "toast-top-center",
			  "preventDuplicates": false,
			  "onclick": null,
			  "showDuration": "300",
			  "hideDuration": "1000",
			  "timeOut": "5000",
			  "extendedTimeOut": "1000",
			  "showEasing": "swing",
			  "hideEasing": "linear",
			  "showMethod": "fadeIn",
			  "hideMethod": "fadeOut"
			};
			toastr.error('{{session("msg")}}', 'Login');
		</script>
@endif
	<!--end::Body-->
</html>