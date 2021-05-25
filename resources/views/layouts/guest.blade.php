<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>{!! config('constant.title') !!}</title>
    @section('head_css')
        @include('assetlib.head_css')
    @show
    <?php
    \App\Library\AssetLib::library('login-register','dashboard3','register-steps','register3','sweetalert','sweet-alert.init','dropify','moment','datetimepicker','clockpicker','bootstrap-datepicker','bootstrap-timepicker','daterangepicker');
    ?>

    @section('css')
        @include('assetlib.css')
    @show
    @section('head_js')
        @include('assetlib.head_js')
    @show
</head>
<body class="skin-default card-no-border">
<div class="preloader">
    <div class="loader">
        <div class="loader__figure"></div>
        <p class="loader__label">{!! config('constant.title') !!}</p>
    </div>
</div>
<div class="progress wd login-progress-bar-custom" id="appprogress"></div>

<section id="wrapper" class="{{isset($wrapper_class) ? $wrapper_class : 'login-register'}}" style="background-image:url(assets/images/background/login-register.jpg); overflow: auto !important; ">
    
    @section('content')
        @yield('content')
    @show

</section>


<?php
\App\Library\AssetLib::library('popper','bootstrap','sweetalert','sweet-alert.init');
?>
@section('footer_js')
    @include('assetlib.js')
@show

<script type="text/javascript">
    $(function() {
        $(".preloader").fadeOut();
    });
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    });
    // ==============================================================
    // Login and Recover Password
    // ==============================================================
    $('#to-recover').on("click", function() {
        $("#loginform").slideUp();
        $("#recoverform").fadeIn();
    });
</script>
<style>
    .progress.wd.login-progress-bar-custom {
    top: 1px;
    margin: 0 auto !important;
    /*left: 37%;*/
    width: 100% !important;
}
</style>
</body>
</html>