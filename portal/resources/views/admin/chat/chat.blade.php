@extends('layout.app')
@extends('layout.sidebar')
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

    <link href="{{ asset('')}}plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    <style>
        #myUL2{
    list-style-type: none;
}
#myUL{
    list-style-type: none;
}

    </style>
    @stop
<!--end::Head-->
<!--begin::Body-->
@section('content')
    <!--begin::Wrapper-->
    <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
        <!--begin::Header-->
        <div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
            <!--begin::Container-->
            <div class="container d-flex align-items-center justify-content-between" id="kt_header_container">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-2 pb-2 pb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
                    <!--begin::Heading-->
                    <h1 class="text-dark fw-bolder my-0 fs-2">Private Chat</h1>
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
                <!--begin::Layout-->
                <div class="d-flex flex-column flex-lg-row">
                    <!--begin::Sidebar-->
                    <div class="flex-column flex-lg-row-auto w-100 w-lg-300px w-xl-400px mb-10 mb-lg-0">
                        <!--begin::Contacts-->
                        <div class="card card-flush">
                            <!--begin::Card header-->
                            <div class="card-header pt-7" id="kt_chat_contacts_header">
                                <!--begin::Form-->
                                <form class="w-100 position-relative" autocomplete="off">
                                    <!--begin::Icon-->
                                    <!--begin::Svg Icon | path: icons/duotone/General/Search.svg-->
                                    <span class="svg-icon svg-icon-2 svg-icon-lg-1 svg-icon-gray-500 position-absolute top-50 ms-5 translate-middle-y">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero" />
                                            </g>
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <!--end::Icon-->
                                    <!--begin::Input-->
                                    <input id="myInput" onkeyup="myFunction()" type="text" class="form-control form-control-solid px-15" name="search" value="" placeholder="Search by username or email..." />
                                    <!--end::Input-->
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-5" id="kt_chat_contacts_body">
                                <!--begin::List-->
                                <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                                    <li class="nav-item">
                                        <a class="nav-link active"  onclick="$('#admins_tab').show();$('#guards_tab').hide();" data-bs-toggle="tab" href="#admins_tab">Admins</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" onclick="$('#admins_tab').hide();$('#guards_tab').show();" data-bs-toggle="tab" href="#guards_tab">{{config('custom.guard')}}s</a>
                                    </li>
                                    
                                </ul> 
                               
                                
                                    <div class="tab-pane fade show active" id="admins_tab" role="tabpanel">
                                        <div class="scroll-y me-n5 pe-5 h-200px h-lg-auto" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_chat_contacts_header" data-kt-scroll-wrappers="#kt_content, #kt_chat_contacts_body" data-kt-scroll-offset="0px">
                                        {{-- <table id="data_table" class=""> --}}
                                            <ul id="myUL2">
                                        <?php
                                        // $id = {{(Session::get('userId')}};
                                           foreach($admins as $admin)
                                            {
                                                if($admin->id==Session::get('userId')){
                                                  continue;
                                                }
                                                        ?>
                                                <li>
                                                <!--begin::User-->
                                    
                                                 <div class="d-flex flex-stack py-4">
                                                 <!--begin::Details-->
                                                 <div class="d-flex align-items-center">
                                                 <!--begin::Avatar-->
                                                 <div class="symbol symbol-45px symbol-circle">
                                                     <span class="symbol-label bg-light-danger text-danger fs-6 fw-bolder">
                                                         <img src="{{$admin->image != '' ? config('custom.asset_url').$admin->image : 'https://img.icons8.com/external-kmg-design-flat-kmg-design/32/000000/external-user-back-to-school-kmg-design-flat-kmg-design.png'}}" alt="" class="w-100">
                                                     </span>
                                                 </div>
                                                 <!--end::Avatar-->
                                                 <!--begin::Details-->
                                                 <div class="ms-5">
                                                    <a  class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2 get_id" value="<?php echo $admin->id?>" type="<?php echo 'admin'?>" id="user<?php echo $admin->id?>"><?php echo $admin->name?></a>
                                                     <div class="fw-bold text-gray-400">{{$admin->email}}</div>
                                                 </div>
                                                 <!--end::Details-->
                                                </div>
                                                <!--end::Details-->
                                             <!--begin::Lat seen-->
                                             <div class="d-flex flex-column align-items-end ms-2">
                                                 <span class="text-muted fs-7 mb-1">Admin</span>
                                             </div>
                                             <!--end::Lat seen-->
                                        </div>  
                                                </li>
                                        <!--end::User-->
    <?php
                                               
                                                }
                                                
                                            ?>
                                        </ul>        
                                </div>
                                </div>

                                    <div class="tab-pane fade" style="display:none" id="guards_tab" role="tabpanel">
                                        <div class="scroll-y me-n5 pe-5 h-200px h-lg-auto" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_chat_contacts_header" data-kt-scroll-wrappers="#kt_content, #kt_chat_contacts_body" data-kt-scroll-offset="0px">
                                            <ul id="myUL">
                                       <?php
                                        foreach($guards as $guard)
                                        {
                                         if($guard->id==Session::get('userId')){
                                             continue;
                                           }
                                            
                                                ?>
                                                 <!--begin::User-->
                                                 <li>
                                                 
                                             <div class="d-flex flex-stack py-4">
                                             <!--begin::Details-->
                                             <div class="d-flex align-items-center">
                                             <!--begin::Avatar-->
                                             
                                             <div class="symbol symbol-45px symbol-circle">
                                                 <span class="symbol-label bg-light-danger text-danger fs-6 fw-bolder">
                                                     <img src="{{$guard->profile_image != '' ? config('custom.asset_url').$guard->profile_image : 'https://img.icons8.com/external-kmg-design-flat-kmg-design/32/000000/external-user-back-to-school-kmg-design-flat-kmg-design.png'}}" class="w-100" />
                                                 </span>
                                             </div>
                                             <!--end::Avatar-->
                                             <!--begin::Details-->
                                             <div class="ms-5">
                                                <a  class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2 get_id" value="<?php echo $guard->id?>" type="<?php echo 'guard'?>" id="user<?php echo $guard->id;?>"><?php echo $guard->name?></a>
                                                 <div class="fw-bold text-gray-400">{{$guard->email}}</div>
                                             </div>
                                             <!--end::Details-->
                                         </div>
                                         <!--end::Details-->
                                         <!--begin::Lat seen-->
                                         <div class="d-flex flex-column align-items-end ms-2">
                                             <span class="text-muted fs-7 mb-1">{{config('custom.guard')}}</span>
                                         </div>
                                         <!--end::Lat seen-->
                                     </div>
                                     <!--end::User-->
                                     <!--begin::Separator-->
                                                 </li>
                                     <!--end::Separator-->
                                                <?php
                                           
                                            }
                                            
                                        ?>
                                            </ul>
                                    </div>
                             
                                       
                                </div>
                                <!--end::List-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Contacts-->
                    </div>
                    <!--end::Sidebar-->
                    <!--begin::Content-->
                    <div class="flex-lg-row-fluid ms-lg-7 ms-xl-10">
                        <!--begin::Messenger-->
                        <div class="card" id="kt_chat_messenger" style="display: none;">
                            <!--begin::Card header-->
                            <div class="card-header" id="kt_chat_messenger_header">
                                <!--begin::Title-->
                                <div class="card-title">
                                    <!--begin::User-->
                                    <div class="d-flex justify-content-center flex-column me-3">
                                        <a  class="fs-4 fw-bolder text-gray-900 text-hover-primary me-1 mb-2 lh-1 chat_name"></a>
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
                               
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body" id="kt_chat_messenger_body">
                                <!--begin::Messages-->
                                <div id="chat_box" class="scroll-y me-n5 pe-5 h-300px h-lg-auto" data-kt-element="messages" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_chat_messenger_header, #kt_chat_messenger_footer" data-kt-scroll-wrappers="#kt_content, #kt_chat_messenger_body" data-kt-scroll-offset="-2px">
                                 
                                   
                                    <!--end::Message(template for in)-->
                                </div>
                                <!--end::Messages-->
                            </div>
                            <!--end::Card body-->
                            <!--begin::Card footer-->
                            <form action="#" id="submit_message"  enctype="multipart/form-data">
                            <div class="card-footer pt-4" id="kt_chat_messenger_footer">
                                <!--begin::Input-->
                                <input type="hidden" name="receiver_id" id="receiver_id">
                                <input type="hidden" name="receiver_type" id="receiver_type">
                                <textarea class="form-control form-control-flush mb-3" rows="1" data-kt-element="input" placeholder="Type a message" id="type_msg" name="message"></textarea>
                                <!--end::Input-->
                                <!--begin:Toolbar-->
                                <div class="d-flex flex-stack">
                                    <!--begin::Actions-->
                                    <div class="d-flex align-items-center me-2">
                                        <!-- <button class="btn btn-sm btn-icon btn-active-light-primary me-1" type="button" data-bs-toggle="tooltip" title="" onclick="readFile('BSbtninfo')">
                                            <i class="bi bi-paperclip fs-3"></i>
                                        </button>
                                        <div style="display: none;">
                                        <input type="file" name="comment_attachment" id="BSbtninfo">
                                        </div>
                                            <i class="bi bi-paperclip fs-3"></i>
                                        </button> -->
                                    </div>
                                    <!--end::Actions-->
                                    <!--begin::Send-->

                                    <input type="submit" class="btn btn-primary"  value="Send" id="send_msg">
                                    <!--end::Send-->
                                </div>
                                <!--end::Toolbar-->
                            </div>
                            </form>
                            <!--end::Card footer-->
                        </div>
                        <!--end::Messenger-->
                    </div>
                    <!--end::Content-->
                </div>
           
            </div>
            <!--end::Container-->
        </div>
        <!--end::Content-->
        <!--begin::Footer-->

    </div>
    </div>
    <!--end::Wrapper-->
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
    <script src="{{asset('')}}js/custom/apps/user-management/roles/list/add.js"></script>
    <script src="{{asset('')}}js/custom/apps/user-management/roles/list/update-role.js"></script>
    <script src="{{asset('')}}js/custom/widgets.js"></script>
    <script src="{{asset('')}}js/custom/apps/chat/chat.js"></script>
    <script src="{{asset('')}}js/custom/modals/create-app.js"></script>
    <script src="{{asset('')}}js/custom/modals/upgrade-plan.js"></script>
    <script src="{{asset('')}}plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

    <!--end::Page Custom Javascript-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"> </script>  
    <script>
        function myFunction() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('myInput');
          filter = input.value.toUpperCase();
          ul = document.getElementById("myUL");
          ul2 = document.getElementById("myUL2");
          li = ul.getElementsByTagName('li');
          li2 = ul2.getElementsByTagName('li');
        
          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }

          for (i = 0; i < li2.length; i++) {
            a = li2[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li2[i].style.display = "";
            } else {
              li2[i].style.display = "none";
            }
          }
        }
        </script>                                
    <script>
    
    
     $(document).ready(function(){
//         oTable = $('#data_table').DataTable();
// // $('#search').keyup(function(){
// //       oTable.search($(this).val()).draw() ;
// // })

// var $rows = $('#data_table tr');
// $('#search').keyup(function() {
//     var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
//     console.log(val );
    
//     $rows.show().filter(function() {
//         var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
//         return !~text.indexOf(val);
//     }).hide();
    
// })
           var user_id;
           var admin_id;
           var chat_name;
           var obj;
           $(".get_id").click(function(e){
            e.preventDefault(); 
            $('#chat_box').html('')
            admin_id= '{{Session()->get('userId')}}';
            user_id = $(this).attr('value');
            obj=$(this);
            var user_type = $(this).attr('type');
             var apnd='';
            const settings = {
                "async": true,
                "crossDomain": true,
                "url": '{{route("load_user_into_chat")}}',
                "data": {
                     user_id: user_id,
                     user_type: user_type,
                    "_token": "{{ csrf_token() }}",
                },
                'dataType': 'json',
                "method": "POST",
            };

            $.ajax(settings).done(function(response) {

                //console.log(response.messages);
                $(".chat_name").html(response.user[0].name);
                $("#receiver_id").val(response.user[0].id);
                $("#receiver_type").val(response.user[0].type);
                chat_name=response.user[0].name;

                if(response.response==true)
                {
                $('#kt_chat_messenger').css('display', '');
              
                $.each(response.messages,function(index,val){
                    // console.log(val.sent);
                    if(val.align=='left')
                    {
                    // alert('reciever')
                     apnd='<div class="d-flex justify-content-start mb-10"><div class="d-flex flex-column align-items-start"><div class="d-flex align-items-center mb-2"> <div class="symbol symbol-35px symbol-circle"><img alt="Pic" src="'+val.image+'" />  </div>    <div class="ms-3"> <a  class="fs-5 fw-bolder text-gray-900 text-hover-primary me-1">'+chat_name+'</a> <span class="text-muted fs-7 mb-1">'+val.send_time+'</span></div></div><div class="p-5 rounded bg-light-info text-dark fw-bold mw-lg-400px text-start" data-kt-element="message-text">'+val.message+'</div></div>  </div>';                  
                     $('#chat_box').append(apnd);
                    }else{
                        
                    apnd='<div class="d-flex justify-content-end mb-10"><div class="d-flex flex-column align-items-end"> <div class="d-flex align-items-center mb-2"><div class="me-3"> <span class="text-muted fs-7 mb-1">'+val.send_time+'</span><a  class="fs-5 fw-bolder text-gray-900 text-hover-primary ms-1">ME</a> </div><div class="symbol symbol-35px symbol-circle"> <img alt="Pic" src="'+val.image+'" /> </div> </div> <div class="p-5 rounded bg-light-primary text-dark fw-bold mw-lg-400px text-end" data-kt-element="message-text">'+val.message+' </div> </div>'
                    $('#chat_box').append(apnd);  
                                     
                     // alert('sender')                          
                    // $('#set_user_1').append(apnd);
                    } 
                  
                });
                $('#chat_box').scroll();
                    $("#chat_box").animate({scrollTop: 10000}, 500);
               }
               else{
                $('#kt_chat_messenger').css('display', '');
                   
                    $('#chat_box').html("<h4 style='color:green' class='text-center'>Sart Chat...</h4>");
                }
              get_chat();      
            });
         });


        $(document).on('submit', '#submit_message', function(e) {
            e.stopPropagation()
            e.preventDefault();
            $(this).append('{{csrf_field()}}');
              
                let formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: `{{route('insert_chat_msg')}}`,
                    dataType: 'json',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                        if ($('#type_msg').val() != '') {
                        var send_time = moment(new Date()).format('DD-MM-YYYY HH:mm');
                        var apnd='<div class="d-flex justify-content-end mb-10"><div class="d-flex flex-column align-items-end"> <div class="d-flex align-items-center mb-2"><div class="me-3"> <span class="text-muted fs-7 mb-1">'+send_time+'</span><a  class="fs-5 fw-bolder text-gray-900 text-hover-primary ms-1">ME</a> </div><div class="symbol symbol-35px symbol-circle"> <img alt="Pic" src="{{asset('')}}media/avatars/150-13.jpg" /> </div> </div> <div class="p-5 rounded bg-light-primary text-dark fw-bold mw-lg-400px text-end" data-kt-element="message-text">'+($('#type_msg').val())+' </div> </div>';
                    }else{
                        $('#BSbtninfo').val('')
                    }
                    $('#chat_box').append(apnd);  
                    $('#type_msg').val('')
                    $('#chat_box').scroll();
                    $("#chat_box").animate({scrollTop: 10000}, 500);
                        // console.log(response);
                    },
                    error: function(response) {
                        //alert(response.response);
                    }
                });
        });
         function get_chat ()
         {
            var intervel = setInterval(function(){ 
                const settings = {
                "async": true,
                "crossDomain": true,
                "url": '{{route("get_chat")}}',
                "data": {
                     // receiver_id: admin_id,
                     receiver_id:   $('#receiver_id').val(),
                     receiver_type:   $('#receiver_type').val(),
                    "_token": "{{ csrf_token() }}",
                },
                'dataType': 'json',
                "method": "POST",
            };
            $.ajax(settings).done(function(response) {

                if(response.response==true){
                   // alert('true')
                  $.each(response.messages,function(index,val){
                   // alert('each');
                    apnd='<div class="d-flex justify-content-start mb-10"><div class="d-flex flex-column align-items-start"><div class="d-flex align-items-center mb-2"> <div class="symbol symbol-35px symbol-circle"><img alt="Pic" src="https://{{asset('')}}media/avatars/150-13.jpg" />  </div>    <div class="ms-3"> <a  class="fs-5 fw-bolder text-gray-900 text-hover-primary me-1">'+chat_name+'</a> <span class="text-muted fs-7 mb-1">'+val.TIMESTAMP_INSERTED+'</span></div></div><div class="p-5 rounded bg-light-info text-dark fw-bold mw-lg-400px text-start" data-kt-element="message-text">'+val.message+'</div></div>  </div>';       
                    $('#chat_box').scroll();
                    $("#chat_box").animate({scrollTop: 10000}, 500);           
                    // $('#chat_box').animate({ scrollTop:  $('#chat_box').offset().top -0 }, 'slow');
                    $('#chat_box').append(apnd);
                   
                });
              
                }
                
                //$('#chat_box').append(apnd);
            });

            }, 15000);
         }
    });

function readFile(id)
{
    $('#'+id).click();
}
</script>   

    @stop