<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    {!! csrf_field() !!}
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>{!! config('constant.title') !!}</title>

    @section('head_css')
        @include('assetlib.head_css')
    @show

    @section('head_js')
        @include('assetlib.head_js')
    @show
    <?php
    \App\Library\AssetLib::library('popper','bootstrap','perfect-scrollbar','waves','sidebarmenu','custom','raphael','morris','sparkline','toast','file-upload','jasny-bootstrap','datepicker','select2','switchery','bootstrap-select','tagsinput','touchspin','multiselect','dff','inputmask','sweetalert','sweet-alert.init','dropify','moment','datetimepicker','clockpicker','bootstrap-datepicker','bootstrap-timepicker','daterangepicker', 'dataTables.bootstrap4', 'dataTables', 'responsive.dataTables','dataTables-fixed-columns','dataTables-buttons','dataTables-colVis','nestable','chosen','tabs','multiselect','style_multiselect','multiselect-jquery-ui','multiselect-filter','inputmask','chat-app');
    ?>
    @section('css')
        @include('assetlib.css')
    @show
    <style>
        /**
        Custom Scroll
         */
        ::-webkit-scrollbar {
            width: 0.7em;
            height: 0.7em;
        }

        ::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        }

        ::-webkit-scrollbar-thumb {
            background-color: lightgrey;
            outline: 1px solid slategrey;
        }

    </style>
</head>
<body class="skin-blue fixed-layout">
<div class="preloader">
    <div class="loader">
        <div class="loader__figure"></div>
        <p class="loader__label">{!! config('constant.title') !!}</p>
    </div>
</div>

<div id="main-wrapper">
    @section('docker-topnav')
        @include('layouts.docker-topnav')
    @show


    @section('docker-leftsidebar')
        @include('layouts.docker-leftsidebar')
    @show

    <div class="page-wrapper">
        @section('content')
            @yield('content')
        @show
    </div>

    @section('docker-footer')
        @include('layouts.docker-footer')
    @show
</div>
@section('footer_js')
    @include('assetlib.js')
@show

<style>
    .bk-overlay {
        position: fixed;
        top: 0;
        z-index: 1003;
        background-color: rgba(0, 0, 0, 0.1);
        left: 0%;
        height: 100%;
        width: 100%;
        transition: background-color 0.5s;
        pointer-events: none;
    }

    .bk-overlay.in {
        background-color: rgba(0, 0, 0, 0.4);
        pointer-events: initial;
    }

    .bk-overlay.out {
        background-color: rgba(0, 0, 0, 0);
        pointer-events: none;
    }

    .bk-overlay .overlay-content {
        transform: translateX(100%);
        transition: transform 0.5s;
        overflow-y: auto;
        height: 100%;
    }

    .bk-overlay.in .overlay-content {
        transform: translateX(0%);
    }

    body.bk-overlay-in {
        overflow: hidden;
    }

    .bootstrap-tagsinput {
        width: 100% !important;
    }
</style>

</body>
</html>
