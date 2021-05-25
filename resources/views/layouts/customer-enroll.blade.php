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

    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    @section('head_css')
        @include('assetlib.head_css')
    @show

    @section('head_js')
        @include('assetlib.head_js')
    @show
    <?php
    \App\Library\AssetLib::library('popper','bootstrap','perfect-scrollbar','waves','sidebarmenu','custom','raphael','morris','sparkline','toast','dashboard1','file-upload','jasny-bootstrap','datepicker','select2','switchery','bootstrap-select','tagsinput','touchspin','multiselect','dff','inputmask','sweetalert','sweet-alert.init','dropify','moment','datetimepicker','clockpicker','bootstrap-datepicker','bootstrap-timepicker','daterangepicker','wizard');
    ?>
    @section('css')
        @include('assetlib.css')
    @show
</head>
<body class="skin-blue fixed-layout">
<div class="preloader">
    <div class="loader">
        <div class="loader__figure"></div>
        <p class="loader__label">{!! config('constant.title') !!}</p>
    </div>
</div>
<div class="progress wd" id="appprogress"></div>
<div id="main-wrapper">

    <div class="page-wrapper">
        @section('content')
            @yield('content')
        @show
    </div>
</div>
@section('footer_js')
    @include('assetlib.js')
@show

<style>
    @media (min-width: 1024px){
        .footer, .page-wrapper {
             margin-left: 0px !important;
        }
    }

</style>
<script>

    //Custom design form example
    $(".tab-wizard").steps({
        headerTag: "h6",
        bodyTag: "section",
        transitionEffect: "fade",
        titleTemplate: '<span class="step">#index#</span> #title#',
        labels: {
            finish: "Submit"
        },
        onFinished: function (event, currentIndex) {
            swal("Form Submitted!", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lorem erat eleifend ex semper, lobortis purus sed.");

        }
    });


    var form = $(".validation-wizard").show();

    $(".validation-wizard").steps({
        headerTag: "h6",
        bodyTag: "section",
        transitionEffect: "fade",
        titleTemplate: '<span class="step">#index#</span> #title#',
        labels: {
            finish: "Submit"
        },
        onStepChanging: function (event, currentIndex, newIndex) {
            return currentIndex > newIndex || !(3 === newIndex && Number($("#age-2").val()) < 18) && (currentIndex < newIndex && (form.find(".body:eq(" + newIndex + ") label.error").remove(), form.find(".body:eq(" + newIndex + ") .error").removeClass("error")), form.validate().settings.ignore = ":disabled,:hidden", form.valid())
        },
        onFinishing: function (event, currentIndex) {
            return form.validate().settings.ignore = ":disabled", form.valid()
        },
        onFinished: function (event, currentIndex) {
            $(this).submit();
        }
    }), $(".validation-wizard").validate({
        ignore: "input[type=hidden]",
        errorClass: "text-danger",
        successClass: "text-success",
        highlight: function (element, errorClass) {
            $(element).removeClass(errorClass)
        },
        unhighlight: function (element, errorClass) {
            $(element).removeClass(errorClass)
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element)
        },
        rules: {
            email: {
                required : true,
                email: true,
                remote: {
                    url: "/checkemail",
                    type: "post",
                    data : {_token : '{{csrf_token()}}'}
                }
            }
        },
        messages : {
            email: {
                required: "Please enter your email address.",
                email: "Please enter a valid email address.",
                remote: "Email already in use!"
            }
        }
    })

</script>
</body>
</html>