@extends('layout.app')
@extends('layout.sidebar')
@extends('layout.footer')


@section('pageCss')
<base href="../../../">
<meta charset="utf-8" />
<title>{{ config('custom.title') }}</title>
<meta name="description"
content="{{ config('custom.title') }}" />
<meta name="keywords"
content="{{ config('custom.title')}}" />
<link rel="canonical" href="Https://preview.keenthemes.com/metronic8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<!-- <link rel="shortcut icon" href="{{ asset('') }}media/logos/favicon.ico" /> -->
<!--begin::Fonts-->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700" />
<!--end::Fonts-->
<!--begin::Page Vendor Stylesheets(used by this page)-->
<link href="{{ asset('') }}plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
<!--end::Page Vendor Stylesheets-->
<!--begin::Global Stylesheets Bundle(used by all pages)-->
<link href="{{ asset('') }}plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
<link href="{{ asset('') }}css/style.bundle.css" rel="stylesheet" type="text/css" />

<style type="text/css">

    .image-area {
      position: relative;
      width: 50%;
      background: #333;
  }
  .image-area img{
      max-width: 100%;
      height: auto;
  }
  .remove-image {
    display: none;
    position: absolute;
    top: -10px;
    right: -10px;
    border-radius: 10em;
    padding: 2px 6px 3px;
    text-decoration: none;
    font: 700 21px/20px sans-serif;
/*background: #555;*/
/*border: 3px solid #fff;*/
color: #FFF;
/*box-shadow: 0 2px 6px rgba(0,0,0,0.5), inset 0 2px 4px rgba(0,0,0,0.3);*/
text-shadow: 0 1px 2px rgba(0,0,0,0.5);
-webkit-transition: background 0.5s;
transition: background 0.5s;
}
.edit-image i {
    color: #FFF;
}
.edit-image {
    display: none;
    position: absolute;
    top: -10px;
    left: -10px;
    border-radius: 10em;
    padding: 2px 6px 3px;
    text-decoration: none;
    font: 700 21px/20px sans-serif;
/*background: #555;*/
/*border: 3px solid #fff;*/
color: #FFF;
/*box-shadow: 0 2px 6px rgba(0,0,0,0.5), inset 0 2px 4px rgba(0,0,0,0.3);*/
text-shadow: 0 1px 2px rgba(0,0,0,0.5);
-webkit-transition: background 0.5s;
transition: background 0.5s;
}
.remove-image:hover {
   background: #E54E4E;
/*  padding: 3px 7px 5px;*/
top: -11px;
right: -11px;
}
.remove-image:active {
   background: #E54E4E;
   top: -10px;
   right: -11px;
}
.edit-image:hover {
   background: #E54E4E;
/*  padding: 3px 7px 5px;*/
top: -11px;
left: -11px;
}
.edit-image:active {
   background: #E54E4E;
   top: -10px;
   left: -11px;
}


.pdf-icon {
  font-size: 100%;
  box-sizing: border-box;
  display: block;
  position: relative;
  width: 6em;
  height: 8.5em;
  background-color: #eee;
  background-image: url('https://i.imgur.com/lZ5SgDE.png');
  background-repeat: no-repeat;
  background-size: 85% auto;
  background-position: center 2em;
  border-radius: 1px 2em 1px 1px;
  border: 1px solid #ddd;
}
  .pdf-icon:after{
    content: 'PDF';
    font-family: Arial;
    font-weight: bold;
    font-size: 1.2em;
    text-align: center;
    padding: .2em 0 .1em;
    color: white;
    display: block;
    position: absolute;
    top: .7em;
    left: -1.5em;
    width: 3.4em;
    height: auto;
    background: #da2525;
    border-radius: 2px;
}
</style>
<!--end::Global Stylesheets Bundle-->



@stop

<!--end::Head-->
<!--begin::Body-->

<!--begin::Main-->
<!--begin::Root-->
<?php 
$permissions = array();
$is_super_admin = 0;
if (session()->has('permissions')) {
    $permissions = json_decode(session()->get('permissions'), true);
}
if (session()->has('isAdmin')) {
    $is_super_admin = session()->get('isAdmin');
}
?>
@if (true)
@section('content')
<!--end::Logo-->

<!--begin::Wrapper-->
<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
    <!--begin::Header-->
    <div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header"
    data-kt-sticky-offset="{default: '200px', lg: '300px'}">
    <!--begin::Container-->
    <div class="container d-flex align-items-center justify-content-between" id="kt_header_container">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-2 pb-2 pb-lg-0"
        data-kt-swapper="true" data-kt-swapper-mode="prepend"
        data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
        <!--begin::Heading-->
        <h1 class="text-dark fw-bolder my-0 fs-2">About Us</h1>
        <!--end::Heading-->
    </div>
    <!--end::Page title=-->
    <!--begin::Wrapper-->
    <div class="d-flex d-lg-none align-items-center ms-n2 me-2">
        <!--begin::Aside mobile toggle-->
        <div class="btn btn-icon btn-active-icon-primary" id="kt_aside_toggle">
            <!--begin::Svg Icon | path: icons/duotone/Text/Menu.svg-->
            <span class="svg-icon svg-icon-2x">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <rect x="0" y="0" width="24" height="24" />
                    <rect fill="#000000" x="4" y="5" width="16" height="3"
                    rx="1.5" />
                    <path
                    d="M5.5,15 L18.5,15 C19.3284271,15 20,15.6715729 20,16.5 C20,17.3284271 19.3284271,18 18.5,18 L5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 Z M5.5,10 L18.5,10 C19.3284271,10 20,10.6715729 20,11.5 C20,12.3284271 19.3284271,13 18.5,13 L5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 Z"
                    fill="#000000" opacity="0.3" />
                </g>
            </svg>
        </span>
        <!--end::Svg Icon-->
    </div>
    <!--end::Aside mobile toggle-->
    <!--begin::Logo-->
    <a href="index.html" class="d-flex align-items-center">
        <img alt="Logo" src="{{ config('custom.logo') }}" class="h-30px" />
    </a>
    <!--end::Logo-->
</div>
<!--end::Wrapper-->
@include('layout.toolbar')
@yield('toolbar')

</div>
<!--end::Container-->
</div>
<!--end::Header-->
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Container-->
    <div class="container" id="kt_content_container">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            @if(session()->get('userType')=='admin' && ($is_super_admin == 1 || (isset($permissions['about_us_full_access']) && $permissions['about_us_full_access'] == 'full_access')))
            <div class="row">       
                <div class="col-sm-6" style="float:left;text-align: start;margin-top:4px;">

                </div>
                <div class="col-sm-6 " style="float:right;text-align: end;margin-top:7px;">
                    <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_add_division">

                        @if(empty($about_us)) 
                        <span class="svg-icon svg-icon-2">
                            <i class="fas fa-plus"></i>
                        </span>Add
                        @endif
                        @if(!empty($about_us))
                        <span class="svg-icon svg-icon-2">
                            <i class="fas fa-edit"></i>
                        </span>
                        Edit @endif
                    </button>
                    
                </div>
            </div>
            @endif
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title" style="display: block; width: 100% !important;">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                     <div class="row">
                         <div class="col-12">
                             {{$about_us->about_us}}
                         </div>
                     </div>

                 </div>
                 <!--end::Search-->
             </div>
             <!--begin::Card title-->

             <!--begin::Card body-->
             <div class="tab-content card-body pt-0  ">

                <div class="row">

                    @foreach($about_us->about_us_files as $key => $af)
                    <div class="col">
                        <a href="https://{{request()->getHttpHost()}}/asset_uploads/{{$af;}}" target="_blank" class="text-gray-800 text-hover-primary d-flex flex-column">
                            <!--begin::Image-->
                            <div class="symbol symbol-75px mb-6">
                                <img src="{{asset('')}}media/svg/files/folder-document.svg" alt="">
                            </div>
                            <!--end::Image-->
                            <!--begin::Title-->
                            <!-- <div class="fs-5 fw-bolder mb-2">Finance</div> -->
                            <!--end::Title-->
                        </a>
                    </div>
                    @endforeach

                </div>
                @foreach($files as $f)
                <div class="separator"></div>
                <div class="row p-3">
                    <div class="col">
                        @if($f->file != '')
                        @if(preg_match('/pdf/i', $f->file))
                            <a href="https://{{request()->getHttpHost()}}/asset_uploads/{{$f->file;}}" target="_blank"><span class="pdf-icon"></span></a>
                            @else
                        <div class="image-area">

                            <a href="https://{{request()->getHttpHost()}}/asset_uploads/{{$f->file;}}" target="_blank"><img src="https://{{request()->getHttpHost()}}/asset_uploads/{{$f->file;}}"  alt="{{$f->file_name}}">
                                </a>
                            <a class="remove-image" onclick="deleteImage({{$f->id}})"  style="display: inline;">&#215;</a>
                            <a class="edit-image" onclick="editImage({{$f->id}})"  style="display: inline;"><i class="fas fa-edit"></i></a>
                        </div>
                            @endif

                        @endif
                    </div>
                    <div class="col">
                      <span>File Name: <strong>{{$f->file_name}}</strong></span>
                  </div>
                  <div class="col">
                      <span>Expiry: <strong>{{date('d/m/Y', strtotime($f->expiry))}}</strong></span>
                  </div>
              @if (session()->get('userType') == 'admin') 

                  <div class="col">
                      <i class="fas fa-trash" onclick="deleteFile({{$f->id}})"></i>
                  </div>
            @endif

              </div>
              <div class="separator"></div>

              @endforeach
              @if (session()->get('userType') == 'admin') 
              <div class="row">
                <div class="col-12 text-center mb-4">
                    <button class="btn btn-success" onclick="addMoreFileInput()">Add More File</button>
                </div>
                <div class="separator"></div>
                <div class="col-12 mt-4" id="add-more-div">
                </div>
            </div>
            @endif
        </div>

        <!--end::Card body-->

    </div>
    <!--end::Card-->
</div>
<!--end::Container-->
</div>
<!--end::Content-->
<!--begin::Footer-->

<!--end::Root-->
<!--begin::Drawers-->
<!--begin::Activities drawer-->

<!--end::Chat drawer-->
<!--begin::Exolore drawer toggle-->
<!--end::Container-->
<!-- model add division -->
<div class="modal fade" id="kt_modal_add_division" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder">About Us</h2>
                <!--end::Modal title-->
                <!--begin::Close-->

                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">

                    <span class="svg-icon svg-icon-2x">X</span>
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <form class="form add_bussiness_form" action="{{url('update_about_us')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!--begin::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="required fs-6 fw-bold form-label mb-2">Title:</label>
                        <!--end::Label-->
                        <textarea name="about_us" id="about_us" class="form-control form-control-solid mb-3 mb-lg-0" rows="3">{{$about_us->about_us}}</textarea>
                    </div>
                    <!--end::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="required fs-6 fw-bold form-label mb-2">About Files:</label>
                        <!--end::Label-->
                        <input type="file" multiple class="form-control form-control-md" id="about_files" name="about_files[]"> 
                    </div>
                    <!--begin::Input group-->
                    <!--begin::Input group-->
                    <!-- <div class="fv-row mb-10"> -->
                        <!--begin::Label-->
                        <!-- <label class="required fs-6 fw-bold form-label mb-2">Rate:</label> -->
                        <!--end::Label-->
                        <!-- <input type="number" id="rate" name="rate" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Rate" value="" required="" step="any"> -->
                        <!-- </div> -->
                        <!--end::Input group-->
                        <!--end::Input group-->

                        <!--begin::Actions-->
                        <div class="text-center">
                            <button type="reset" class="btn btn-white me-3" data-kt-users-modal-action="cancel">Discard</button>
                            <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                                <span id="form_submit" class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>

        <!-- model add division -->
<div class="modal fade" id="kt_modal_add_about_file" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder">Update Image</h2>
                <!--end::Modal title-->
                <!--begin::Close-->

                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">

                    <span class="svg-icon svg-icon-2x">X</span>
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <form class="form add_bussiness_form" action="{{url('update_about_us_file')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!--end::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="required fs-6 fw-bold form-label mb-2">About File:</label>
                        <!--end::Label-->
                        <input type="file" multiple class="form-control form-control-md" name="file" required> 
                    </div>
                    <input type="hidden" name="file_id" id="file_id">
                        <!--begin::Actions-->
                        <div class="text-center">
                            <button type="reset" class="btn btn-white me-3" data-kt-users-modal-action="cancel">Discard</button>
                            <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                                <span id="form_submit" class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        @stop
        <!--end::Scrolltop-->
        <!--end::Main-->
        <!--begin::Javascript-->
        <!--begin::Global Javascript Bundle(used by all pages)-->
        @section('pageFooter')
        @endif
        <script src="{{ asset('') }}plugins/global/plugins.bundle.js"></script>
        <script src="{{ asset('') }}js/scripts.bundle.js"></script>
        <!--end::Global Javascript Bundle-->
        <!--begin::Page Vendors Javascript(used by this page)-->
        <script src="{{ asset('') }}plugins/custom/datatables/datatables.bundle.js"></script>
        <!--end::Page Vendors Javascript-->
        <!--begin::Page Custom Javascript(used by this page)-->
        <script src="{{ asset('') }}js/custom/apps/user-management/users/list/table.js"></script>
        <script src="{{ asset('') }}js/custom/apps/user-management/users/list/export-users.js"></script>
        <script src="{{ asset('') }}js/custom/apps/user-management/users/list/add.js"></script>
        <script src="{{ asset('') }}js/custom/widgets.js"></script>
        <script src="{{ asset('') }}js/custom/apps/chat/chat.js"></script>
        <script src="{{ asset('') }}js/custom/modals/create-app.js"></script>
        <script src="{{ asset('') }}js/custom/modals/upgrade-plan.js"></script>
        <!--end::Page Custom Javascript-->
        <!--end::Javascript-->
        <script type="text/javascript">
            $(".add_bussiness_form").on('submit', function(e) {
                e.preventDefault();
            // console.log(this.id)
                var data = new FormData(this);
            // data.append('about_files', $('input#about_files')[0].files[0]);
            // var filesLength=document.getElementById('about_files').files.length;
            // for(var i=0;i<filesLength;i++){
                // data.append("about_files", document.getElementById('about_files').files[0]);
                // data.append("about_files[]", $('input#about_files')[i].files[0]);
            // }
            // console.log(filesLength);
            // return;
            // var data = $('#' + this.id).serialize();
                $.ajax({
                    type: "POST",
                    url: this.action,
                    data: data,
                    dataType: "json",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(result) {
                        if(result.success) {
                            Swal.fire({
                                text: result.message,
                                icon: "success",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-light"
                                }
                            })
                            window.location.href = "{{ url('/about_us')}}";
                        } else {
                            Swal.fire({
                                text: result.error,
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-light"
                                }
                            })
                        }
                    }
                })
            });
            function addMoreFileInput() {
                $.ajax({
                    type: "GET",
                    url: "{{url('getMoreInputs')}}",
                    dataType: "json",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(result) {
                     // console.log(result)
                        $('#add-more-div').html(result);

                    }
                })
            }
            function deleteImage(id) 
            {
                Swal.fire({
                    text: "Are you sure you want to delete this file?",
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
                        $.ajax({type: "POST",url: `{{url('deleteAboutFile')}}/${id}`, data:{_token:'<?php echo csrf_token();?>'},success: function(result){
                            Swal.fire({
                                text: "Deleted Succesfully.",
                                icon: "success",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            })
                            window.location.href = "{{ url('/about_us')}}";
                        }
                    })

                        ) : "cancel" === t.dismiss && Swal.fire({
                            text: "Your action has not been cancelled!.",
                            icon: "error",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        })
                    }))
            }
            function deleteFile(id) 
            {
                Swal.fire({
                    text: "Are you sure you want to delete this file?",
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
                        $.ajax({type: "POST",url: `{{url('deleteAboutFilePer')}}/${id}`, data:{_token:'<?php echo csrf_token();?>'},success: function(result){
                            Swal.fire({
                                text: "Deleted Succesfully.",
                                icon: "success",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            })
                            window.location.href = "{{ url('/about_us')}}";
                        }
                    })

                        ) : "cancel" === t.dismiss && Swal.fire({
                            text: "Your action has not been cancelled!.",
                            icon: "error",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        })
                    }))
            }
            function editImage(id) {
                $('#file_id').val(id);
                $('#kt_modal_add_about_file').modal('show')
            }
        </script>

        @stop
