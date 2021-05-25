<!DOCTYPE html>
<html>
<head>
    <title>Docs</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <script>
        var SETTING_SELECT_COPY_CLIPBOARD = 1;
        var SETTING_IMAGE_EDITOR = 1;
        var SETTING_AJAX_NOTIFICATION = 1;
        var timer_object = [];

    </script>
    <link href="assets/bower_components/nprogress/nprogress.css?ver=0.1" rel="stylesheet" type="text/css" />
    <link href="assets/bower_components/bootstrap/bootstrap.min.css?ver=0.1" rel="stylesheet" type="text/css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/bower_components/clockpicker/dist/bootstrap-clockpicker.min.css?ver=0.1" rel="stylesheet" type="text/css" />
    <!--<link href="http://newworkdesk.allengers.net/assets/bower_components/chosen/chosen.min.css?ver=0.1" rel="stylesheet" type="text/css" />
     -->
    <link href="http://newworkdesk.allengers.net/assets/bower_components/bootstrap/dist/css/bootstrap.min.css?ver=0.1" rel="stylesheet" type="text/css" />
    <link href="assets/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css?ver=0.1" rel="stylesheet" type="text/css" />
    <link href="assets/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput-typeahead.css?ver=0.1" rel="stylesheet" type="text/css" />
    <link href="assets/bower_components/summernote/dist/summernote.css?ver=0.1" rel="stylesheet" type="text/css" />
    <link href="assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css?ver=0.1" rel="stylesheet" type="text/css" />
    <link href="assets/bower_components/uploadfiles/css/fileinput.css?ver=0.1" rel="stylesheet" type="text/css">
    <link href="http://newworkdesk.allengers.net/assets/bower_components/jstree/dist/themes/default/style.min.css?ver=0.1" rel="stylesheet" type="text/css">
    <link href="css/sticky.css?ver=0.1" rel="stylesheet" type="text/css" />
    <link href="elite/css/animate.css?ver=0.1" rel="stylesheet" type="text/css" />
    <link href="elite/css/style.css?ver=0.1" rel="stylesheet" type="text/css" />
    <link href="css/custom.css?ver=0.1" rel="stylesheet" type="text/css" />
    <link href="elite/css/responsive.css?ver=0.1" rel="stylesheet" type="text/css" />
    <link href="elite/css/doc.css?ver=0.1" rel="stylesheet" type="text/css" />
    <link href="elite/css/dashboard.css?ver=0.1" rel="stylesheet" type="text/css" />
    <link href="css/responsive.css?ver=0.1" rel="stylesheet" type="text/css" />
    <!-- Files from AssetLib CSS @ 2019-02-01 00:06:35 -->
    <link href="elite/css/colors/blue.css" id="theme" rel="stylesheet">
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
    <!-- BODY -->
    <style>
        .chosen-container {
            width: 100% !important;
        }
    </style>
    <script src="js/jquery.min.js?ver=0.1" type="text/javascript" ></script>
    <!-- Files from AssetLib JS @ 2019-02-01 00:06:35 -->        <script>
        $(function () {
            $(".preloader").hide();
            if ($('#side-menu').length) {
                // $('#side-menu').metisMenu();
            }

        });
        window.addEventListener("load", function (ev) {
            $(".preloader").hide();
        });
        $(document).ready(function () {
            $(".preloader").hide();
        });
    </script>

    <script>
        $(document).ready(function () {
            setTimeout(function () {
                $("body").removeClass("page-loading");
            }, 1000);
        });
    </script>
</head>
<body class="page-loading">
<!-- Preloader -->
<div class="preloader">
    <div class="cssload-speeding-wheel"></div>
</div>
<div id="wrapper" class="">
    <div class="fixed_header">
        @section('nav')
            @include('layouts.topnav')
        @show

        <script>
            var track_page = 2;

            function autocomplete(id, text) {
                return;
                var addclass = "";
                track_page = 2;
                $('.loading-info').html("");
                $(".loading-info").show();
                $(".loading-info1").show();
                $.ajaxSetup({
                    headers: {'X-CSRF-Token': $('input[name="_token"]').val()}
                });
                $.ajax({
                    // The URL for the request
                    url: "/notification/seen?v=" + new Date().getTime(),
                    // The data to send (will be converted to a query string)
                    data: {id: id, text: text},
                    // Whether this is a POST or GET request
                    type: "POST",
                    // The type of data we expect back
                    dataType: "json",
                })
                // Code to run if the request succeeds (is done);
                // The response is passed to the function
                    .done(function (json) {
                        $(".loading-info").hide();
                        if (text == "chat") {
                            $("#countemailzero").html("");
                            $("#appendchat").html(json.all);
                        } else if (text == "remindernotify") {
                            $("#countreminder").html("");
                        } else {
                            $("#countzero").html("");
                            //$("#appendnotification").html(json.all);
                            // $("#appendticket").html(json.tickets);
                            if (json.all.trim().length == 0) {
                                //notify user if nothing to load
                                $('.loading-info').html("No more records!");
                                //track_page = 2;
                                //return;
                            } else {
                                $('.loading-info').hide(); //hide loading animation once data is received
                                $("#appendnotification").html(json.all); //append data into #results element
                            }
                            if (json.reminder.trim().length == 0) {
                                //notify user if nothing to load
                                $('.loading-info1').html("No more records!");
                                //track_page = 2;
                                //return;
                            } else {
                                $('.loading-info1').hide(); //hide loading animation once data is received
                                $("#appendreminder").html(json.reminder); //append data into #results element
                            }
                        }
                        console.log(json);
                    })
                    // Code to run if the request fails; the raw request and
                    // status codes are passed to the function
                    .fail(function (xhr, status, errorThrown) {
                        $(".loading-info").hide();
                        alert("Sorry, there was a problem!");
                        console.log("Error: " + errorThrown);
                        console.log("Status: " + status);
                        console.dir(xhr);
                    })// Code to run regardless of success or failure;


            }

            $(function () {

                $('#scrollbox').scroll(function () {
                    if ($(".loading-info").css('display') == 'none') {
                        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
                            scrollalert(track_page);
                            track_page++;
                        }
                    }
                });

                function scrollalert(track_page) {
                    $('.loading-info').show(); //show loading animation
                    $.ajaxSetup({
                        headers: {'X-CSRF-Token': $('input[name="_token"]').val()}
                    });
                    $.ajax({
                        url: "/notification/pagination",
                        data: {'page': track_page},
                        type: "POST",
                        // The type of data we expect back
                        dataType: "json",
                    }).done(function (json) {
                        $("#countzero").html("");
                        console.log(json);
                        loading = false; //set loading flag off once the content is loaded

                        if (json.all.trim().length == 0) {
                            //notify user if nothing to load
                            $('.loading-info').html("No more records!");
                            //track_page = 2;
                            //return;
                        } else {
                            $('.loading-info').hide(); //hide loading animation once data is received
                            $("#appendnotification").append(json.all); //append data into #results element
                        }

                        if (json.tickets.trim().length == 0) {
                            //notify user if nothing to load
                            $('.loading-info1').html("No more records!");
                            //track_page = 2;
                            //return;
                        } else {
                            $('.loading-info').hide(); //hide loading animation once data is received
                            $("#appendticket").append(json.tickets); //append data into #results element
                        }

                    })
                        .fail(function (xhr, ajaxOptions, thrownError) { //any errors?
                            alert(thrownError); //alert with HTTP error
                        })
                }
            });
        </script>
        <script>
            $(document).ready(function () {
                ACFn.set_notification = function (F, R) {
                    if (R.count >= 1) {
                        $('#countzero').html(R.count);
                        if (R.count) {
                            //PageTitleNotification.On('(' + R.count + ') New Notification(s)', 'notification');
                        } else {
                            //PageTitleNotification.Off('notification');
                        }
                    } else {
                        //PageTitleNotification.Off('notification');
                    }
                    if (R.chatcount >= 1) {
                        $('#countemailzero').html(R.chatcount);
                    }
                    setTimeout(function () {
                        if (window.stopnotify) {

                        } else {
                            hitNotifyUrl2();
                        }
                    }, 10000);
                }
            })

            function hitNotifyUrl2() {
                if (windowHasFocus) {
                    ACFn.sendAjax("/notication/notify?v=" + new Date().getTime(), 'GET', [], $("body"), {
                        progress: false,
                        showServerError: false
                    });
                } else {
                    setTimeout(function () {
                        hitNotifyUrl2();
                    }, 10000);
                }
            }

            if (typeof SETTING_AJAX_NOTIFICATION != 'undefined' && SETTING_AJAX_NOTIFICATION) {
                setTimeout(function () {
                    hitNotifyUrl2();
                }, 10000);
            }

            function TabshowEvent(obj) {
                $(obj).tab('show');
            }

            var remind = 1;

            function SendAjaxResponse(obj, types) {

                if (types == "company") {
                    var cid = $(obj).val();
                    var url = "/department/ajax/department";
                    var data = {cid: cid};
                    SendAjaxResponse("", "department");
                    setTimeout(function () {
                        selectdepartment();
                    }, 2000);
                } else if (types == "department") {
                    var depid = $(obj).val();
                    var cid = $("#company").val();
                    var url = "/department/ajax/user";
                    var data = {depid: depid, cid: cid};
                }
                else if (types == "category") {
                    var catid = $(obj).val();
                    var url = "/taskcategory/ajax";
                    var data = {catid: catid};
                } else if (types == "addTask") {
                    var catid = "addTask";
                    var url = "/init";
                    var data = {type: catid};
                } else if (types == "remindernotify") {
                    if (remind > 1) {
                        return false;
                    }
                    $("#countreminder").html("");
                    var catid = "remindernotify";
                    var url = "/init";
                    var data = {type: catid};


                }
                if (types != "remindernotify") {
                    $(".preloader").fadeIn();
                }

                $.ajaxSetup({
                    headers: {'X-CSRF-Token': $('input[name="_token"]').val()}
                });
                $.ajax({
                    // The URL for the request
                    url: url,
                    // The data to send (will be converted to a query string)
                    data: data,
                    // Whether this is a POST or GET request
                    type: "POST",
                    // The type of data we expect back
                })
                // Code to run if the request succeeds (is done);
                // The response is passed to the function
                    .done(function (json) {
                        $(".preloader").fadeOut();
                        if (types == "company") {
                            $("#department").html(json);
                        } else if (types == "department") {
                            $("#task_assign").html(json);
                            $("#follower").html(json);
                        }
                        else if (types == "category") {
                            $("#appendsubcatpop").html(json);
                        } else if (types == "addTask") {
                            $("#AddTaskModalL").trigger('click');
                            $("#AddTaskModal").html(json);
                        } else if (types == "remindernotify") {
                            remind++;
                            $("#remindernotification").html(json);
                        }
                    })
                    // Code to run if the request fails; the raw request and
                    // status codes are passed to the function
                    .fail(function (xhr, status, errorThrown) {
                        $(".preloader").fadeOut();
                        console.log("Error: " + errorThrown);
                        console.log("Status: " + status);
                        console.dir(xhr);
                    })// Code to run regardless of success or failure;
            }

            function selectdepartment() {
                $('#department option[value="all"]').prop('selected', true);
            }

            function hidereminder() {
                $("#countreminder").html("");
            }

            $('li.dropdown.reminder a').on('click', function (event) {
                $(this).parent().toggleClass('open');
            });

            $('body').on('click', function (e) {
                if (!$('li.dropdown.reminder').is(e.target)
                    && $('li.dropdown.reminder').has(e.target).length === 0
                    && $('.open').has(e.target).length === 0
                ) {
                    $('li.dropdown.reminder').removeClass('open');
                }
            });
            $(document).ready(function () {

                $('.dropdown').data('open', false);

                $('.dropdown-toggle').click(function () {
                    if ($('#dropdown').data('open')) {
                        $('#dropdown').data('open', false);
                    } else {
                        $('#dropdown').data('open', true);


                        $("body").removeClass("xyz");
                        $("body").removeClass("main-right-open");

                        $(".notififyclick").fadeOut();
                    }
                });

                /*$(document_v1).click(function() {
                    if($('#dropdown').data('open')) {
                        $('#dropdown').data('open', false);
                        update_something();
                    }
                });*/

            });
        </script>
    </div>
    <!-- BEGIN PAGE -->
    <div id="page-wrapper">
        @section('content')
            @yield('content')
        @show
        <!-- /.container-fluid -->
    </div>
    <!-- End div .container -->
    @include('layouts.footer')

    <!-- /.right-sidebar -->

    <style>
        #fade-bg {
            left: auto;
            width: 0%;
            opacity: 0;
            display: block;
            transition: width 0.3s, opacity 0.3s;
            pointer-events: none;
        }
        .main-right-open #fade-bg {
            display: block;
            width: 100%;
            opacity: 1;
            pointer-events: all;
        }
        .right-sidebar {
            right: -310px;
            transition: right 0.3s ease;
            display: block;
            height: 100vh;
        }
        .right-sidebar > div {
            height: 100%;
        }
        .right-sidebar .tab-content {
            height: calc(100% - 44px) !important;
        }
        .right-sidebar .tab-content .tab-pane {
            height: 100%;
        }
        .main-right-open .right-sidebar {
            right: 0;
        }
    </style>
</div>
<!-- END PAGE -->
<!--<div id="myModal5" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
         <div class="modal-content buzz-main" id="buzz-message">
         </div>
   </div>
   <a data-toggle="modal" data-target="#myModal5" class="model_img img-responsive" id="triggermessage"/></a>
   </div>-->
<div class="b-modal __b-popup1__"
     style="position: fixed; top: 0px; right: 0px; bottom: 0px; left: 0px; opacity: 0.7; z-index: 9998; cursor: pointer; background-color: rgb(0, 0, 0); display:none;"></div>
<div class="forget-pwd">
    <div id="popup" style="left: 424.5px; position: absolute; top: 167.5px; z-index: 9999; opacity: 1; display:none;">
        <div class="count123"></div>
        <div id="buzz-message"></div>
    </div>
</div>
<!--
   ================================================
   JAVASCRIPT
   ================================================
   -->
<script src="assets/bower_components/nprogress/nprogress.js?ver=0.1" type="text/javascript" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" ></script>
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" ></script>-->

<script src="assets/bower_components/bootstrap/dist/js/bootstrap.min.js?ver=0.1" type="text/javascript" ></script>
<script src="js/ajax.js?ver=0.1" type="text/javascript" ></script>
<script src="assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js?ver=0.1" type="text/javascript" ></script>
<script src="assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js?ver=0.1" type="text/javascript" ></script>
<script src="assets/bower_components/uploadfiles/js/fileinput.js?ver=0.1" type="text/javascript"></script>
<script src="assets/bower_components/clockpicker/dist/bootstrap-clockpicker.min.js?ver=0.1" type="text/javascript" ></script>
<script src="assets/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js?ver=0.1" type="text/javascript" ></script>
<script src="http://newworkdesk.allengers.net/assets/bower_components/ckeditor/ckeditor.js?ver=0.1" type="text/javascript"></script>
<script src="assets/bower_components/summernote/dist/summernote.min.js?ver=0.1" type="text/javascript" ></script>
<script src="assets/bower_components/summernote/dist/checklist.js?ver=0.1" type="text/javascript" ></script>
<!--<script src="assets/bower_components/fullcalendar/fullcalendar.min.js?ver=0.1" type="text/javascript" ></script>-->
<script src="assets/bower_components/fancybox/dist/jquery.fancybox.min.js?ver=0.1" type="text/javascript" ></script>
<script src="assets/bower_components/jstree/dist/jstree.min.js?ver=0.1" type="text/javascript" ></script>
<script src="elite/plugins/bower_components/Split.js/split.min.js?ver=0.1" type="text/javascript" ></script>
<script src="assets/bower_components/jQuery-contextMenu/dist/jquery.contextMenu.min.js?ver=0.1" type="text/javascript" ></script>
<script src="elite/js/custom.js?ver=0.1" type="text/javascript" ></script>
<script src="js/sticky.js?ver=0.1" type="text/javascript" ></script>
<script src="js/init.js?ver=0.1" type="text/javascript" ></script><!-- Files from AssetLib JS @ 2019-02-01 00:06:35 -->
</body>
</html>
