<html lang="en"><head>
    <meta charset="UTF-8">
    <meta name="" content="Book Apoint">
    <title>OnGrocery</title>

    {{-- <link href="{{url('admin/css/bootstrap.min.css')}}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <script>
      window.console = window.console || function(t) {};
    </script>
    <script>
      if (document.location.search.match(/type=embed/gi)) {
        window.parent.postMessage("resize", "*");
      }
    </script>
    </head>
    <body translate="no" style="background: #e9ecef;">
    <div class="jumbotron text-center">
    <h1 class="display-3">Thank You!</h1>
    <p class="lead">
        <strong style="display:block;">Thanks for purchase OnGrocery </strong>
        <br>
        <strong style="display:block;"><b>Getting Started</b></strong>
        <br>
        get your instalation key and install database to <strong>Getting Startd. </strong>
    </p>
    <hr>
    <p class="lead">
    <a class="btn btn-primary btn-sm" href="{{url('/installer/install')}}" role="button">OnGrocery Installer</a>
    </p>
    </div>

    </body>
    </html>
