<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME') }} | Admin</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ mix('mix/css/app.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset("bower_components/font-awesome/css/font-awesome.min.css") }}">
    <!-- Ionicons -->
{{-- <link rel="stylesheet" href="{{ asset("bower_components/Ionicons/css/ionicons.min.css") }}"> --}}
<!-- Theme style -->
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <!-- Morris chart -->
{{-- <link rel="stylesheet" href="{{ asset("bower_components/morris.js/morris.css") }}"> --}}
<!-- jvectormap -->
{{-- <link rel="stylesheet" href="{{ asset("bower_components/jvectormap/jquery-jvectormap.css") }}"> --}}
<!-- Date Picker -->
    <link rel="stylesheet" href="{{ asset("bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css") }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset("bower_components/bootstrap-daterangepicker/daterangepicker.css") }}">
    <!-- bootstrap wysihtml5 - text editor -->
    {{-- <link rel="stylesheet" href="{{ asset("plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css") }}"> --}}
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('plugins/sweetalert/sweetalert2.min.css') }}"> --}}

    <link rel="icon"
          type="image/png"
          href="{{ asset('asset/admin/img/favicon.ico') }}" />
    <link rel="stylesheet" href="{{ asset("bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css") }}"/>

@yield("css")
<!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/admin/css/main.css?v=1.3') }}">
    <base data-url="{{ url('') }}"/>
</head>

<body>

<div class="container">
    <!-- Static navbar -->
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">CS {{ env('APP_NAME') }}</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="{{ url('cs') }}">Report</a></li>
                    <li class=""><a href="{{ url('cs-logout') }}">Logout</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
    </nav>

    <!-- Main component for a primary marketing message or call to action -->
    <div class="jumbotron">
        <div class="row">
            @yield('main')
        </div>
    </div>

</div> <!-- /container -->


@yield("js_first")
<!-- jQuery 3 -->
<script src="{{ mix('mix/js/app.js') }}"></script>
{{-- <script src="{{ asset("bower_components/jquery/dist/jquery.min.js") }}"></script> --}}
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset("bower_components/jquery-ui/jquery-ui.min.js") }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>

{{-- <script src="{{ asset("bower_components/moment/min/moment.min.js") }}"></script>
<script src="{{ asset("bower_components/bootstrap-daterangepicker/daterangepicker.js") }}"></script>

<script type="text/javascript" src="{{ asset("bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js") }}"></script> --}}
<!-- datepicker -->
{{-- <script src="{{ asset("bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js") }}"></script> --}}


<script src="{{ asset("js/backend.main.js?v=1.1") }}"></script>
@yield("js")
</body>
</html>
