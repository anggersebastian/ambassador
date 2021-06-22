<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ isset($landing) ? $landing->title : '' }} Drag and Drop {{ env('APP_NAME') }}</title>
    <meta content="Best Free Open Source Responsive Websites Builder" name="description">
    <link rel="stylesheet" href="{{ asset('grapesjs/stylesheets/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('grapesjs/stylesheets/grapes.min.css?v0.15.10') }}">
    <link rel="stylesheet" href="{{ asset('grapesjs/stylesheets/grapesjs-preset-webpage.min.css') }}">
    <link rel="stylesheet" href="{{ asset('grapesjs/stylesheets/tooltip.css') }}">
    <link rel="stylesheet" href="{{ asset('grapesjs/stylesheets/grapesjs-plugin-filestack.css') }}">
    <link rel="stylesheet" href="{{ asset('grapesjs/stylesheets/demos.css?v3') }}">
    <link rel="stylesheet" href="{{ asset('grapesjs/style.css') }}">

    <!-- <script src="//static.filestackapi.com/v3/filestack.js"></script> -->
    <!-- <script src="js/aviary.js"></script> old //feather.aviary.com/imaging/v3/editor.js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="{{ asset('grapesjs/js/toastr.min.js') }}"></script>

    <script src="{{ asset('bower_components/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('bower_components/ckeditor/config.js') }}"></script>

    <script src="{{ asset('grapesjs/js/grapes.min.js') }}"></script>
    <script src="{{ asset('grapesjs/js/grapesjs-plugin-ckeditor.min.js') }}"></script>
    <script src="{{ asset('grapesjs/js/grapesjs-preset-webpage.min.js?v0.1.11') }}"></script>
    <script src="{{ asset('grapesjs/js/grapesjs-lory-slider.min.js?0.1.5') }}"></script>
    <script src="{{ asset('grapesjs/js/grapesjs-tabs.min.js?0.1.1') }}"></script>
    <script src="{{ asset('grapesjs/js/grapesjs-custom-code.min.js?0.1.2') }}"></script>
    <script src="{{ asset('grapesjs/js/grapesjs-touch.min.js?0.1.1') }}"></script>
    <script src="{{ asset('grapesjs/js/grapesjs-parser-postcss.min.js?0.1.1') }}"></script>
    <script src="{{ asset('grapesjs/js/grapesjs-tooltip.min.js?0.1.1') }}"></script>
    <script src="{{ asset('grapesjs/js/grapesjs-tui-image-editor.min.js?0.1.2') }}"></script>
    <script src="{{ asset('grapesjs/js/grapesjs-typed.min.js') }}"></script>
    <script src="{{ asset('grapesjs/js/grapesjs-component-countdown.min.js') }}"></script>
    <script src="{{ asset('grapesjs/js/grapesjs-blocks-basic.min.js?v=1.1') }}"></script>
    <style>
        {!! $landing->css_content !!}
    </style>
    <base data-url="{{ url('') }}" data-user-id="{{ \Sentinel::check()->id }}" data-csrf="{{ csrf_token() }}" data-landing-id="{{ isset($landing) ? $landing->id : '' }}" data-css="{!! isset($landing) ? $landing->css_content : '' !!}"/>
</head>
<body>
<div style="display: none">
    <div class="gjs-logo-cont">
        <a href="{{ url('') }}"><img class="gjs-logo" src="{{ asset('grapesjs/img/grapesjs-logo-cl.png') }}"></a>
        <div class="gjs-logo-version"></div>
    </div>
</div>
<div id="gjs" style="height:0px; overflow:hidden">
    {!! $landing->html_content !!}
</div>

<div id="info-panel" style="display:none">
    <br/>
    <svg class="info-panel-logo" xmlns="//www.w3.org/2000/svg" version="1"><g id="gjs-logo">
            <path d="M40 5l-12.9 7.4 -12.9 7.4c-1.4 0.8-2.7 2.3-3.7 3.9 -0.9 1.6-1.5 3.5-1.5 5.1v14.9 14.9c0 1.7 0.6 3.5 1.5 5.1 0.9 1.6 2.2 3.1 3.7 3.9l12.9 7.4 12.9 7.4c1.4 0.8 3.3 1.2 5.2 1.2 1.9 0 3.8-0.4 5.2-1.2l12.9-7.4 12.9-7.4c1.4-0.8 2.7-2.2 3.7-3.9 0.9-1.6 1.5-3.5 1.5-5.1v-14.9 -12.7c0-4.6-3.8-6-6.8-4.2l-28 16.2" style="fill:none;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-width:10;stroke:#fff"/>
        </g></svg>
    <br/>
</div>

<script src="{{ asset('grapesjs/main.js') }}"></script>
</body>
</html>
