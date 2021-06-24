<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ambassador | Admin</title>
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
<body class="hold-transition skin-blue fixed sidebar-mini">
<div class="wrapper" id="app">
    <header class="main-header">
        <!-- Logo -->
        <a href="{{ url('backend') }}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini">O</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Ambassador</b></span>
        </a>
        @include("backend.partials.nav")
    </header>

    @include("backend.partials.sidebar")

    <div class="content-wrapper">
        <section class="content-header">
            @yield("page_header")
           

            <ol class="breadcrumb">
                <li>
                    <a href="#">
                        <i class="fa fa-dashboard"></i> Home
                    </a>
                </li>
                <li class="active">Dashboard</li>
            </ol>
        </section>
        <br/>

        @yield('tag_create')
        <section class="content">
            @yield("main")
        </section>
        
    </div>
    



    @include("backend.partials.footer")
    {{--@include("backend.partials.control-sidebar")--}}
    <div class="control-sidebar-bg"></div>

    <!-- The Modal -->
    <div id="modal-image" class="modal-img">
        <!-- The Close Button -->
        <span id="close-modal-image" class="close">&times;</span>
        <!-- Modal Content (The Image) -->
        <img class="modal-content" id="img-place" src="">
        <!-- Modal Caption (Image Text) -->
        <div id="img-caption"></div>
    </div>
</div>

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