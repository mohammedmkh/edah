
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>{{\App\CompanySetting::find(1)->name}}</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800" rel="stylesheet">

    <link rel="stylesheet" href="{{url('frontend/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('frontend/css/animate.css')}}">
    <link rel="stylesheet" href="{{url('frontend/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{url('frontend/css/aos.css')}}">
    <link rel="stylesheet" href="{{url('frontend/css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{url('frontend/css/ionicons.min.css')}}">
    {{-- <link rel="stylesheet" href="{{url('frontend/css/font-awesome.min.css')}}"> --}}
    <link rel="stylesheet" href="{{url('admin/css/all.min.css')}}">
    <link rel="stylesheet" href="{{url('frontend/css/flaticon.css')}}">

    <!-- Theme Style -->
    <link rel="stylesheet" href="{{url('frontend/css/style.css')}}">
  </head>
  <body>



    @include('frontend.layout.header')
    @yield('content')

    @include('frontend.layout.footer')


    <!-- loader -->
    <div id="loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#cf1d16"/></svg></div>
    <script src="{{url('frontend/js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{url('frontend/js/popper.min.js')}}"></script>
    <script src="{{url('frontend/js/bootstrap.min.js')}}"></script>
    <script src="{{url('frontend/js/owl.carousel.min.js')}}"></script>
    <script src="{{url('frontend/js/jquery.waypoints.min.js')}}"></script>
    <script src="{{url('frontend/js/aos.js')}}"></script>
    <script src="{{url('frontend/js/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{url('frontend/js/magnific-popup-options.js')}}"></script>
    <script src="{{url('frontend/js/main.js')}}"></script>




  </body>
</html>
