<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <script src="{{url('admin/js/jquery.min.js')}}"></script>


        <title>{{\App\CompanySetting::find(1)->name}}</title>
        <link href="{{ url('images/upload/'.\App\CompanySetting::find(1)->favicon)}}" rel="icon" type="image/png">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

        <link href="https://jvectormap.com/css/jquery-jvectormap-2.0.3.css" rel="stylesheet">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <link rel="stylesheet" href="{{url('admin/css/sweetalert2.scss')}}">

        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />

        <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" id="theme" rel="stylesheet">
        <link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" id="theme" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        @if(session()->get('locale') == 'english')
            <link href="{{url('admin/css/nucleo.css')}}" rel="stylesheet">
            <link href="{{url('admin/css/all.min.css')}}" rel="stylesheet">
            <link href="{{url('admin/css/animate.css')}}" id="theme" rel="stylesheet">
            <link rel="stylesheet" href="{{url('admin/css/bootstrap-wysihtml5.css')}}" />
            <link type="text/css" href="{{url('admin/css/argon.css?v=1.0.0')}}" rel="stylesheet">
            <link href="{{url('admin/css/custom.css')}}" rel="stylesheet">

        @else

            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.4.0/css/bootstrap-rtl.min.css">

            <link href="{{url('admin/css/custom_rtl.css')}}" rel="stylesheet">


            <style>
                @media (min-width: 768px){
                    .navbar >.container .navbar-brand, .navbar > .container-fluid .navbar-brand {
                        margin-right: -15px;
                        margin-left: 0;
                    }
                }
                .navbar >.container .navbar-brand, .navbar > .container-fluid .navbar-brand {

                    margin-left: 0!important;
                }
                .content-wrapper{
                    margin-left: 0px;
                }

                .main-header > .navbar {
                    margin-left: 0px;
                }

                .content-wrapper, .right-side, .main-footer {
                    margin-left: 0px;
                }
            </style>

            <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">
            <style>
                *, h2,h1,h3,h3,p{
                    font-family: 'Cairo', sans-serif;
                }
                .menuzord-menu li a{
                    font-weight:bold;
                    font-size: 15px!important;
                }
                .fa-fw {
                    width: 1.28571429em;
                    text-align: center;
                    margin-left: 5px;
                }
            </style>

        @endif

            <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    </head>
    <body class="{{ $class ?? '' }}">
        <input type="hidden" value="{{url('/')}}" id="base-url">
        <input type="hidden" value="{{\App\Setting::find(1)->web_onesignal_app_id}}" id="app_id_web">
        <input type="hidden" value="{{Auth::check()?1:0}}" id="auth_role">
        @if(Auth::check())
        <?php $status = \App\Setting::find(1)->license_status; ?>

            @include('admin.layout.sidebar')
            <div class="main-content">
                @include('admin.layout.header')

                        @yield('content')
                        @yield('content_setting')


                @include('admin.layout.footer')
            </div>
        {{-- @elseif(Auth::guard('mainAdmin')->check())

            @include('admin.layout.sidebar')
            <div class="main-content">
                @include('admin.layout.header')
                @yield('content')
                    @include('admin.layout.footer')
            </div> --}}
        @else
            <div class="main-content">
                @yield('content')
            </div>

        @endif

        <style>
            .invalid-feedback ,valid-feedback {
                display: block!important;
            }
        </style>

        <script src="{{url('admin/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{url('admin/js/sweetalert.all.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        @stack('js')

        <script src="{{url('admin/js/argon.js?v=1.0.0')}}"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
        <script src="{{url('admin/js/wysihtml5-0.3.0.js')}}"></script>
        <script src="{{url('admin/js/bootstrap-wysihtml5.js')}}"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
        <script src="{{url('admin/js/notify.js')}}"></script>
        <?php
        $key = \App\Setting::find(1)->map_key;
        ?>
        {{-- <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script> --}}
        <script src="{{url('admin/js/jquery-jvectormap.min.js')}}"></script>
        <script src="{{url('admin/js/jquery-jvectormap-world-mill.js')}}"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
        <script src="{{url('admin/js/googleMap.js')}}"></script>
        <script src="{{url('admin/js/charts.js')}}"></script>
        <script src="{{url('admin/js/lightbox.js')}}"></script>

        <script src="{{url('admin/js/custom.js')}}"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

        <script>

            $('#editButton').click(function(){
                var error = 0;
                var msg = 'An Error Has Occured.\n\nRequired Fields missed are :\n';
                $(':input[required]').each(function(){
                    $(this).css('border','1px solid rgb(202, 209, 215)');
                    if($(this).val() == ''){
                        msg += '\n' + $(this).attr('id') + ' Is A Required Field..';
                        $(this).css('border','2px solid red');
                        if(error == 0){
                            $(this).focus();
                        }
                        error = 1;
                    }
                });

                if(error == 1){
                    var id =  $('.tab-pane').find(':required:invalid').closest('.tab-pane').attr('id');

                    // Find the link that corresponds to the pane and have it show
                    console.log('the id is' + id);
                    $('.nav a[href="#' + id + '"]').tab('show');

                    // Only want to do it once
                    return false;
                }
            });




            $('#addbutton').click(function(){
                var error = 0;
                var msg = 'An Error Has Occured.\n\nRequired Fields missed are :\n';
                $(':input[required]').each(function(){
                    $(this).css('border','1px solid rgb(202, 209, 215)');
                    if($(this).val() == ''){
                        msg += '\n' + $(this).attr('id') + ' Is A Required Field..';
                        $(this).css('border','2px solid red');
                        if(error == 0){
                            $(this).focus();
                        }
                        error = 1;
                    }
                });

                console.log('the error is' + error);
                if(error == 1){
                    var id =  $('.tab-pane').find(':required:invalid').closest('.tab-pane').attr('id');

                    // Find the link that corresponds to the pane and have it show
                    console.log('the id is' + id);
                    $('.nav a[href="#' + id + '"]').tab('show');

                    // Only want to do it once
                    return false;
                }
            });


            @if(session()->get('locale') == 'arabic')
            function deleteData(url, id) {

                Swal.fire({
                    title: 'هل أنت متأكد من عملية الحذف ؟',
                    text: " ",
                    type: 'تحذير',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.value) {

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "DELETE",
                        dataType: "JSON",
                        url: url + '/' + id,
                        success: function (result) {
                            setTimeout(() => {
                                window.location.reload();
                        }, 2000);
                            console.log('result ', result)
                            Swal.fire({
                                type: 'تم العملية بنجاح',
                                title: 'تم الحذف!',
                                text: 'تم الحذف بنجاح للعنصر'
                            })
                        },
                        error: function (err) {
                            console.log('err ', err)
                            Swal.fire({
                                type: 'لا يمكن الحذف',
                                title: 'Oops...',
                                text: 'هناك بيانات مرتبطة بهذا العنصر '
                            })
                        }
                    });
                }
            });

            }

            @endif
function resetFilter(){
    $("#search").find('.form-control').val(null)
    $("#public_search").click()
    $("#search").find('select').val(null).trigger('change')

}
        </script>




        @yield('java_script')
    </body>
</html>
