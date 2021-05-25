<!DOCTYPE html>
<html>
<head>
    <title>Work Desk-@yield('pageTitle')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ URL::asset('elite/img/favicon.ico')}}">
    <script>
        var SETTING_SELECT_COPY_CLIPBOARD = {{\App\Helper\Setting::getValue('SELECT_COPY_CLIPBOARD', 1)}};
        var SETTING_IMAGE_EDITOR = {{\App\Helper\Setting::getValue('IMAGE_EDITOR', 1)}};
        var SETTING_AJAX_NOTIFICATION = {{\App\Helper\Setting::getValue('AJAX_NOTIFICATION', 1)}};

    </script>
    <?php
    \App\Library\AssetLib::library('bootstrap-datepicker',
        'easyautocomplete', 'filer', 'slimscroll',
        'sticky', 'chosen', 'summernote','summernote_custom',
        'emojione', 'emojionearea', 'textautocomplete', 'doc', 'dashboard', 'bootstrap-tagsinput',
        'core-typeahead','clockpicker','fullcalendar');

    $default_theme = "blue";
    $user_theme = Helpers::get_Usermeta('wd_theme');
    if (!empty($user_theme)) {
        $default_theme = $user_theme;
    }
    ?>
    @section('head_css')
        @include('assetlib.head_css')
    @show
    <link href="/elite/css/colors/<?php echo $default_theme; ?>.css" id="theme" rel="stylesheet">
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
<!-- BODY -->
    <style>
        .chosen-container {
            width: 100% !important;
        }
    </style>
    @section('head_js')
        @include('assetlib.head_js')
        <script>
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
        @if(Auth::user())
            <script>
               /* var wsUri = "ws://116.193.162.116:3000/server.php";
                websocket = new WebSocket(wsUri);
                var curr = '<?php echo Auth::user()->id; ?>';
                */
            </script>
        @endif
        @include('common.javascriptvariables')
    @show
    <script>
        $(document).ready(function () {
            setTimeout(function () {
                $("body").removeClass("page-loading");
            }, 1000);
        });
    </script>
</head>
<?php
$uri = $_SERVER["REQUEST_URI"];
$uriArray = explode('/', $uri);

$getrole = Activity::GetRole();
?>
<body class="page-loading">
<!-- Preloader -->
<div class="preloader">
    <div class="cssload-speeding-wheel"></div>
</div>
<div id="wrapper">
    <div class="fixed_header">
        @section('topbar')
            @include('layouts.leftsidebar')
        @show

        @section('topnavigation')
            @include('layouts.nav')
        @show
    </div>
    <!-- BEGIN PAGE -->
    <div id="page-wrapper">
    @section('content')
        @yield('content')
    @show
    <!-- /.container-fluid -->

    </div><!-- End div .container -->
    @include('layouts.footer')
    @include('layouts.rightsidebar')
</div><!-- END PAGE -->
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
</style>
<script>
    function init_Google_Maps_API() {
        if (typeof initEventsForm === "function") {
            initEventsForm();
        }
    }

    $(document).ready(function () {

        /*$(function () {
            $('.panel').lobiPanel({
                sortable: true,
                reload: false,
                editTitle: false
            });
        });*/

        /*
        if (typeof (ACFn) != 'undefined') {
            ACFn.loadSideLayout = function (F, R) {
                $(".bk-overlay").remove();
                $("body").append(R.html);
                setTimeout(function () {
                    $(".bk-overlay").addClass("in");
                    $("body").addClass('bk-overlay-in');
                    initJS($(".bk-overlay"));
                }, 50);
            };
        }
        $("body").on('click', '.bk-overlay .closebtn', function (e) {
            e.preventDefault();
            $(this).parents('.bk-overlay').removeClass("in");
            $(this).parents('.bk-overlay').addClass("out");
            $("body").removeClass('bk-overlay-in');
            setTimeout(function () {
                $(this).parents('.bk-overlay').remove();
            }, 1000);
        });
        */


        // Date Picker
        if (jQuery('.mydatepicker').length) {
            jQuery('.mydatepicker').datepicker();
        }
        if (jQuery('#datepicker').length) {
            jQuery('#datepicker').datepicker();
        }
        if (jQuery('.clockpicker').length) {
            jQuery('.clockpicker').clockpicker();
        }
        if (jQuery('#datepicker-autoclose').length) {
            jQuery('#datepicker-autoclose').datepicker({  //#datepicker-autoclose
                todayBtn: "linked",
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true
            }).on('changeDate', function(e) {
                validateStartEndDate();
            });
        }
        if (jQuery('#datepicker-autoclose1').length) {
            jQuery('#datepicker-autoclose1').datepicker({
                todayBtn: "linked",
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true
            }).on('changeDate', function(e) {
                validateStartEndDate();
            });
        }

        function validateStartEndDate(){
            if((jQuery('#datepicker-autoclose').val() != "" && jQuery('#datepicker-autoclose1').val() != "")){
                //jQuery('#dft_input_from').val() > jQuery('#dft_input_to').val()
                var startDate = jQuery('#datepicker-autoclose').val();

                var startDatePart = startDate.split('-');

                var convertedStartDate = startDatePart[2]+'-'+startDatePart[1]+'-'+startDatePart[0];
                stringStartdate = new Date(convertedStartDate).toISOString();

                var endDate = jQuery('#datepicker-autoclose1').val();
                var endDatePart = endDate.split('-');

                var convertedEndDate = endDatePart[2]+'-'+endDatePart[1]+'-'+endDatePart[0];
                stringEnddate = new Date(convertedEndDate).toISOString();


                if(stringStartdate > stringEnddate){
                    ACFn.display_message('Due Date cannot be less than Start Date  !!', '', 'error', null);
                    jQuery('#datepicker-autoclose1').val('');
                }
            }
        }

        if (jQuery('#datepicker-autoclose2').length) {
            jQuery('#datepicker-autoclose2').datepicker({
                todayBtn: "linked",
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true
            }).on('changeDate', function(e) {
                validateActivityStartEndDate();
            });
        }
        if (jQuery('#datepicker-autoclose3').length) {
            jQuery('#datepicker-autoclose3').datepicker({
                todayBtn: "linked",
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true
            }).on('changeDate', function(e) {
                validateActivityStartEndDate();
            });
        }
        function validateActivityStartEndDate(){
            if((jQuery('#datepicker-autoclose2').val() != "" && jQuery('#datepicker-autoclose3').val() != "")){
                //jQuery('#dft_input_from').val() > jQuery('#dft_input_to').val()
                var startDate = jQuery('#datepicker-autoclose2').val();

                var startDatePart = startDate.split('-');

                var convertedStartDate = startDatePart[2]+'-'+startDatePart[1]+'-'+startDatePart[0];
                stringStartdate = new Date(convertedStartDate).toISOString();

                var endDate = jQuery('#datepicker-autoclose3').val();
                var endDatePart = endDate.split('-');

                var convertedEndDate = endDatePart[2]+'-'+endDatePart[1]+'-'+endDatePart[0];
                stringEnddate = new Date(convertedEndDate).toISOString();


                if(stringStartdate > stringEnddate){
                    ACFn.display_message('Activity To Date cannot be less than From Date !!', '', 'error', null);
                    jQuery('#datepicker-autoclose3').val('');
                }
            }
        }

        if (jQuery('#datepicker-autoclose4').length) {
            jQuery('#datepicker-autoclose4').datepicker({
                todayBtn: "linked",
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true
            });
        }



        if (jQuery('#date-range').length) {
            jQuery('#date-range').datepicker({
                toggleActive: true
            });
        }
        if (jQuery('#datepicker-inline').length) {
            jQuery('#datepicker-inline').datepicker({

                todayHighlight: true
            });
        }
        jQuery('.addon').click(function () {
            jQuery('#datepicker-autoclose').datepicker('show');
        });
        jQuery('.addon1').click(function () {
            jQuery('#datepicker-autoclose1').datepicker('show');
        });
        jQuery('.addon2').click(function () {
            jQuery('#datepicker-autoclose2').datepicker('show');
        });
        jQuery('.addon3').click(function () {
            jQuery('#datepicker-autoclose3').datepicker('show');
        });
        jQuery('.addon4').click(function () {
            jQuery('#datepicker-autoclose4').datepicker('show');
        });

        $(document).on('focus', '.datepicker', function () {
            $(this).datepicker({
                todayBtn: "linked",
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true
            }).on('changeDate', function(e) {
                validateDueStartEndDate();
            })
        });
    });

    function validateDueStartEndDate(){
        if((jQuery('#dft_input_from').val() != "" && jQuery('#dft_input_to').val() != "")){
            //jQuery('#dft_input_from').val() > jQuery('#dft_input_to').val()
            var startDate = jQuery('#dft_input_from').val();

            var startDatePart = startDate.split('-');

            var convertedStartDate = startDatePart[2]+'-'+startDatePart[1]+'-'+startDatePart[0];
            stringStartdate = new Date(convertedStartDate).toISOString();

            var endDate = jQuery('#dft_input_to').val();
            var endDatePart = endDate.split('-');

            var convertedEndDate = endDatePart[2]+'-'+endDatePart[1]+'-'+endDatePart[0];
            stringEnddate = new Date(convertedEndDate).toISOString();


            if(stringStartdate > stringEnddate){
                ACFn.display_message('Due Date cannot be less than Start Date  !!', '', 'error', null);
                jQuery('#dft_input_to').val('');
            }
        }
    }

    var options = {
        url: function (phrase) {
            return "/search/" + phrase;
        },
        //url: "/search/"+term,
        categories: [{
            listLocation: "users",
            maxNumberOfElements: 4,
            header: "--Users--"
        }, {
            listLocation: "tasks",
            maxNumberOfElements: 4,
            header: "--Tasks--"
        }, {
            listLocation: "notes",
            maxNumberOfElements: 4,
            header: "--Notes--"
        }
            <?php if($getrole == "super admin" || $getrole == "team-lead" || $getrole == "mis(infotech)" || $getrole == "implementer" || $getrole == "manager" || $getrole == "sales operator" || $getrole == "sales manager" || $getrole == "HMS(developer)" || $getrole == "HMS(QA)"){ ?>
            , {
                listLocation: "tickets",
                maxNumberOfElements: 4,
                header: "--Tickets--"
            }

            <?php } ?>

        ],

        getValue: function (element) {
            return element.character;
        },

        template: {
            type: "description",
            fields: {
                description: "realName"
            }
        },

        list: {
            maxNumberOfElements: 16,
            onClickEvent: function () {
                redirect();
            },
            onKeyEnterEvent: function () {
                redirect();
            },
            match: {
                enabled: true
            },
            sort: {
                enabled: true
            }
        },

        theme: "square"
    };

    if ($("#searchtext").length) {
        $("#searchtext").easyAutocomplete(options);
    }

    function redirect() {
        var find = $("#searchtext").val();
        $.ajaxSetup({
            headers: {'X-CSRF-Token': $('input[name="_token"]').val()}
        });
        $.ajax({
            url: "/searchterm",
            data: {key: find},
            method: "POST",
            success: function (data) {
                window.location = data;
            }
        });
    }

    var m = 1;
    var n = 1;

    function PreviosSearch() {
        var searchtext = $("#searchtext").val();
        if (!searchtext) {
            $("#showprevious").trigger('click');
            $("#searchtext").focus();
            n = 1;
        }
        m++;
    }

    $("#searchtext").on("keyup", function () {
        if (n == 1) {
            $("#showprevious").trigger('click');
            $("#searchtext").focus();
        }
        n++;
    })
</script>
<script>
    $(document).ready(function () {
        ACFn.new_ticket_added = function (F, R) {
            ACFn.display_message("Ticket Added!", "Ticket Added!", "success");
            $('#side-popup .modal-header .close').trigger('click');
            $(".preloader").hide();
        }
        ACFn.edit_event_form = function (F, R) {
            if (R.success) {
                F[0].reset();
                $("#new-event-modal").removeClass("in");
                $("#new-event-modal").addClass("out");
                $("#new-event-modal").removeClass("bk-overlay");
                $("#new-event-modal").hide();
                $("body").removeClass("bk-overlay-in");
                swal("Event Updated", '', 'success');
                $("#home-calendar").fullCalendar('refetchEvents');
                location.reload();
            } else {
                display_errors(F, R);
            }
        };

        //Bootstrap-TouchSpin
        if ($(".vertical-spin").length) {
            $(".vertical-spin").TouchSpin({
                verticalbuttons: true,
                verticalupclass: 'ti-plus',
                verticaldownclass: 'ti-minus'
            });
        }
        if ($(".vertical-spin").length) {
            var vspinTrue = $(".vertical-spin").TouchSpin({
                verticalbuttons: true
            });
        }
        if (vspinTrue) {
            $('.vertical-spin').prev('.bootstrap-touchspin-prefix').remove();
        }
        if ($("input[name='tch1']").length) {
            $("input[name='tch1']").TouchSpin({
                min: 0,
                max: 100,
                step: 0.1,
                decimals: 2,
                boostat: 5,
                maxboostedstep: 10,
                postfix: '%'
            });
        }


        // Basic
        if ($('.dropify').length) {
            $('.dropify').dropify();
        }

        // Translated
        if ($('.dropify-fr').length) {
            $('.dropify-fr').dropify({
                messages: {
                    default: 'Glissez-déposez un fichier ici ou cliquez',
                    replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                    remove: 'Supprimer',
                    error: 'Désolé, le fichier trop volumineux'
                }
            });
        }

        // Used events
        if ($('#input-file-events').length) {
            var drEvent = $('#input-file-events').dropify();

            drEvent.on('dropify.beforeClear', function (event, element) {
                return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
            });

            drEvent.on('dropify.afterClear', function (event, element) {
                alert('File deleted');
            });

            drEvent.on('dropify.errors', function (event, element) {
                console.log('Has Errors');
            });
        }

        if ($('#input-file-to-destroy').length) {
            var drDestroy = $('#input-file-to-destroy').dropify();
            drDestroy = drDestroy.data('dropify')
            $('#toggleDropify').on('click', function (e) {
                e.preventDefault();
                if (drDestroy.isDropified()) {
                    drDestroy.destroy();
                } else {
                    drDestroy.init();
                }
            })
        }
    });
    var i = 1;
    /*
    websocket.onmessage = function (ev) {
        console.log(ev.data);
        var msg = JSON.parse(ev.data);
        var msgto = msg.to;
        if (msgto == curr) {
            $(".buzz-btn-cancel").trigger('click');
            jQuery(".b-modal").show();
            jQuery("#popup").show();
            jQuery(".count123").text(i + "/" + i);
            var newclass = "";
            if (i == 1) {
                newclass = 'style="margin-top: 0px;"';
            } else {
                newclass = 'style="margin-top: ' + ((i - 1) * 9) + 'px;"';
            }
            //$("#triggermessage").trigger('click');
            //$("#buzz-message").append('<div class="modal-header buzz-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true"> <i class="icon-close"></i></button><h4 class="modal-title" id="myModalLabel">'+msg.user+' Buzzed you! </h4></div><div class="modal-body buzz-body"><div class="col-md-2"><img class="img-responsive" src="'+msg.pic+'"></div><div class="col-md-10 buzz-paragraph"><h4>Hi, I wished to know the status of the task:</h4><p><i class="fa fa-mail-forward"></i><a href="/tasklist/view/'+msg.task_id+'" >'+msg.task+'</a></p></div><p style="text-align:left; padding:10px 10px 0px 0px;">"'+msg.message+'"</p></div><div class="modal-footer buzz-footer"><button type="button" class="btn btn-info waves-effect pull-left" data-dismiss="modal">Reply</button></div>');
            //alert(msg.pic);
            $("#buzz-message").append('<div class="modal-dialog buzz_popup" id="modal-dialog-' + i + '" ' + newclass + '"><div class="modal-content buzz-main"><div class="modal-header buzz-header"><button type="button" class="close" onclick="hidepopup(' + i + ')"> <i class="icon-close"></i></button><h4 class="modal-title" id="myModalLabel">' + msg.user + ' sent you a reminder </h4></div><div class="modal-body buzz-body"><div class="col-md-2"><img class="img-responsive" src="' + msg.pic + '"></div><div class="col-md-10 buzz-paragraph"><h4>Hi, I wished to know the status of the task:</h4><p><i class="fa fa-mail-forward"></i><a href="/tasklist/view/' + msg.task_id + '?action=buzz&tasktype=mytask" >' + msg.task + '</a></p></div><p style="text-align:left; padding:10px 10px 0px 0px;">"' + msg.message + '"</p></div><div class="modal-footer buzz-footer"><button type="button" class="btn btn-info waves-effect pull-left" data-dismiss="modal" onclick="Buzz_Reply(' + i + ')">Reply</button><input type="text" class="form-control pull-left buzz-msg" placeholder="Reply Here" id="buzzreply_' + i + '" name="buzzreply"/><input type="hidden" class="form-control" id="buzz_task_' + i + '"  value="' + msg.task_id + '"/><input type="hidden" class="form-control" id="buzz_by_' + i + '" value="' + msg.by + '"/><input type="hidden" class="form-control" id="buzz_Mtask_' + i + '" value="' + msg.task + '"/><input type="hidden" class="form-control" id="buzz_pic_' + i + '" value="' + msg.pic + '"/><input type="hidden" class="form-control" id="buzz_id_' + i + '" value="' + msg.buzz_id + '"/></div></div></div>');
            var sumval = $('#countreminder').text();
            if (!sumval) {
                var newval = i;
            } else {
                var newval = parseInt(sumval) + parseInt(i);
            }
            $('#countreminder').html(newval);
            $("#appendbuzz").html("<div class='message-center'><a href='/tasklist/view/" + msg.task_id + "?action=reminder&tasktype=mytask&display=reminder' style='border-left:3px solid #fb9678'><div class='user-img'><img src='" + msg.pic + "' alt='user' class='img-circle'> <span class='profile-status online pull-right'></span></div><div class='mail-contnet'><span class='mail-desc'><p>" + msg.user + " sent you a reminder</p><b>" + msg.message + "</b></span><span class='time'>Now</span></div></a></div>");
            jQuery("#buzzreply_" + i).focus();
            i++;
            console.log(msg);

        }
    }*/

    function hidepopup(obj) {
        jQuery("#modal-dialog-" + obj).remove();
        jQuery("#buzzreply_" + (obj - 1)).focus();
        var match = jQuery(".count123").text().split('/');
        jQuery(".count123").text((obj - 1) + "/" + match[1]);
        if ((obj - 1) == '0') {
            jQuery(".b-modal").hide();
            jQuery("#popup").hide();
            i = 1;
        }
    }

    jQuery(".b-modal").on("click", function () {
        jQuery(".b-modal").hide();
        jQuery("#popup").hide();
    });

    function Buzz_Reply(obj) {
        var comment = $("#buzzreply_" + obj).val();
        if (!comment) {
            comment = "Buzz Reply:";
        }
        var task_id = $("#buzz_task_" + obj).val();
        var pic = $("#buzz_pic_" + obj).val();
        var task = $("#buzz_Mtask_" + obj).val();
        var uid = $("#buzz_by_" + obj).val();
        var buzz_id = $("#buzz_id_" + obj).val();
        var msg = {
            message: comment,
            by: curr,
            to: uid,
            task: task,
            pic: pic,
            user: '<?php echo Auth::user()->username; ?>',
            task_id: task_id,
            buzz_id: buzz_id
        };
        websocket.send(JSON.stringify(msg));
        //$("#buzzreply").val("");
        hidepopup(obj);
        $.ajaxSetup({
            headers: {'X-CSRF-Token': $('input[name="_token"]').val()}
        });
        $.ajax({
            // The URL for the request
            url: "/timer/buzz",
            // The data to send (will be converted to a query string)
            data: {task_id: task_id, comment: comment, buzz: uid, reply: buzz_id},
            // Whether this is a POST or GET request
            type: "POST",
            // The type of data we expect back
            dataType: "json",
        })
        // Code to run if the request succeeds (is done);
        // The response is passed to the function
            .done(function (json) {
                console.log(json);
            })
            // Code to run if the request fails; the raw request and
            // status codes are passed to the function
            .fail(function (xhr, status, errorThrown) {
                alert("Sorry, there was a problem!");
                console.log("Error: " + errorThrown);
                console.log("Status: " + status);
                console.dir(xhr);
            })// Code to run regardless of success or failure;
        return false;

    }
</script>
<script>
    $(document).ready(function () {
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('.js-switch').each(function () {
            new Switchery($(this)[0], $(this).data());

        });
        if ($('#myTable').length) {
            $('#myTable').DataTable({"ordering": false});
        }
        $(document).ready(function () {
            if ($('#example').length) {
                var table = $('#example').DataTable({
                    "columnDefs": [
                        {"visible": false, "targets": 2}
                    ],
                    "order": [[2, 'asc']],
                    "displayLength": 25,
                    "drawCallback": function (settings) {
                        var api = this.api();
                        var rows = api.rows({page: 'current'}).nodes();
                        var last = null;

                        api.column(2, {page: 'current'}).data().each(function (group, i) {
                            if (last !== group) {
                                $(rows).eq(i).before(
                                    '<tr class="group"><td colspan="5">' + group + '</td></tr>'
                                );

                                last = group;
                            }
                        });
                    }
                });
            }

            // Order by the grouping
            $('#example tbody').on('click', 'tr.group', function () {
                var currentOrder = table.order()[0];
                if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                    table.order([2, 'desc']).draw();
                } else {
                    table.order([2, 'asc']).draw();
                }
            });
        });
    });

</script>
<script>
    $(document).ready(function () {
        $('.js-favorite-toggle').on('change', function () {
            console.log($(this).prop('checked'));
            console.log($(this).val());
            var url = '/dashboard/starred';
            var data = {
                type_id: $(this).val(),
                type_name: $(this).data('fav-type'),
                is_starred: !$(this).prop('checked')
            };
            ACFn.sendAjax(url, 'post', data, $(this));
            @if(Request::segment(1) == 'starred')
                if(!$(this).prop('checked')){
                    if($('.'+$(this).data('fav-type')+'_'+$(this).val()).length > 0){
                        $('.'+$(this).data('fav-type')+'_'+$(this).val()).remove();
                    }
                }
            @endif
        });
    });

    function Starred(type_id, type_name, is_starred,tabid) {
        $(".preloader").show();
        if(type_name == 'note' || type_name == 'meeting'){
            var fav = $("#star-"+type_id+"_"+tabid+'_grid').prop('checked');
            var fav = $("#star-"+type_id+"_"+tabid+'_list').prop('checked');
        }else{
            var fav = $("#star-"+type_id+"_"+tabid).prop('checked');
        }
        $.ajaxSetup({
            headers: {'X-CSRF-Token': $('input[name="_token"]').val()}
        });
        $.ajax({
            // The URL for the request
            url: "/dashboard/starred",
            // The data to send (will be converted to a query string)
            data: {type_id: type_id, type_name: type_name, is_starred: is_starred},
            // Whether this is a POST or GET request
            type: "POST",
            // The type of data we expect back
            dataType: "json",
        })
        // Code to run if the request succeeds (is done);
        // The response is passed to the function
            .done(function (json) {
                $(".preloader").hide();
                @if(Request::segment(1) == 'starred')
                    if (is_starred == 1) {
                        if (type_name == 'note' || type_name == 'meeting') {
                            if ($('.' + type_name + '_' + type_id + '_grid').length > 0) {
                                $('.' + type_name + '_' + type_id + '_grid').remove();
                            }
                            if ($('.' + type_name + '_' + type_id + '_list').length > 0) {
                                $('.' + type_name + '_' + type_id + '_list').remove();
                            }
                        } else {
                            if ($('.' + type_name + '_' + type_id).length > 0) {
                                $('.' + type_name + '_' + type_id).remove();
                            }
                        }
                    }
                @endif
            })
            // Code to run if the request fails; the raw request and
            // status codes are passed to the function
            .fail(function (xhr, status, errorThrown) {
                $(".preloader").hide();
                alert("Sorry, there was a problem!");
                console.log("Error: " + errorThrown);
                console.log("Status: " + status);
                console.dir(xhr);
            })// Code to run regardless of success or failure;

    }

    function Myday(obj, type_id, type_name, is_day) {
        $(".preloader").show();
        if ($(obj).attr('class') == 'detail_ticket add_day_icon') {
            $(obj).removeClass('add_day_icon');
            $(obj).addClass('add_day_icon_seleted');
        } else {
            $(obj).removeClass('add_day_icon_seleted');
            $(obj).addClass('add_day_icon');
        }
        $.ajaxSetup({
            headers: {'X-CSRF-Token': $('input[name="_token"]').val()}
        });
        $.ajax({
            // The URL for the request
            url: "/dashboard/myday",
            // The data to send (will be converted to a query string)
            data: {type_id: type_id, type_name: type_name, is_day: is_day},
            // Whether this is a POST or GET request
            type: "POST",
            // The type of data we expect back
            dataType: "json",
        })
        // Code to run if the request succeeds (is done);
        // The response is passed to the function
            .done(function (json) {
                $(".preloader").hide();

            })
            // Code to run if the request fails; the raw request and
            // status codes are passed to the function
            .fail(function (xhr, status, errorThrown) {
                $(".preloader").hide();
                alert("Sorry, there was a problem!");
                console.log("Error: " + errorThrown);
                console.log("Status: " + status);
                console.dir(xhr);
            })// Code to run regardless of success or failure;
    }

    function setpriority(task) {
        $(".a_priority").removeClass("active");
        if (task == 'task_priority1') {
            $("#" + task).addClass("active");
            $("#task_priority_1").val("priority1");
        } else if (task == 'task_priority2') {
            $("#" + task).addClass("active");
            $("#task_priority_1").val("priority2");
        } else if (task == 'task_priority3') {
            $("#" + task).addClass("active");
            $("#task_priority_1").val("priority3");
        } else if (task == 'task_priority4') {
            $("#" + task).addClass("active");
            $("#task_priority_1").val("priority4");
        }

    }
</script>
<script>
    jQuery(document).ready(function () {


        /*$(".note-style").remove();
        $(".note-fontname").remove();
        $(".note-height").remove();
        $(".note-table").remove();
        //$(".note-insert").remove();
        $(".note-view").remove();
        $(".note-help").remove();*/

    });
    function getRecentVisits(uid) {
        $.ajax({
            // The URL for the request
            url: "/getRecentVisits",
            // The data to send (will be converted to a query string)
            data: {user_id: uid},
            // Whether this is a POST or GET request
            type: "GET",
            Async : false,
            // The type of data we expect back
            dataType: "json",
        })
        // Code to run if the request succeeds (is done);
        // The response is passed to the function
            .done(function (json) {
                if (typeof(Storage) !== "undefined") {
                    //localStorage.clear(); return false;
                    var recent_visits = JSON.parse(localStorage.getItem("recent_visits"));
                    if (recent_visits == null){
                        recent_visits = [];
                        for(var i = 0; i< json.recent_visits[0]['recent_visits'].length; i++){
                            var entry = {
                                "user_id": json.recent_visits[0]['recent_visits'][i].user_id,
                                "page_title": json.recent_visits[0]['recent_visits'][i].page_title,
                                "url": json.recent_visits[0]['recent_visits'][i].url,
                                "date_time" : json.recent_visits[0]['recent_visits'][i].date_time
                            };
                            localStorage.setItem("entry", JSON.stringify(entry));
                            recent_visits.push(entry);
                        }
                        localStorage.setItem("recent_visits", JSON.stringify(recent_visits));
                    }
                }
            })
            // Code to run if the request fails; the raw request and
            // status codes are passed to the function
            .fail(function (xhr, status, errorThrown) {
                //$(".preloader").hide();
                alert("Sorry, there was a problem!");
                console.log("Error: " + errorThrown);
                console.log("Status: " + status);
                console.dir(xhr);
            })// Code to run regardless of success or failure;
    }
    function recentVisit(uid,request_url,page_title) {

        if (typeof(Storage) !== "undefined") {
            //localStorage.clear(); return false;
            var recent_visits = JSON.parse(localStorage.getItem("recent_visits"));
            if(recent_visits == null) recent_visits = [];

            var checkExist = false;
            var length = recent_visits.length;
            for (var i = 0; i < length; i++) {
                if (recent_visits[i].url == request_url && recent_visits[i].user_id == uid) {
                    checkExist = true;
                    recent_visits.splice(i, 1);
                    break;
                }
            }
            if(checkExist == false && recent_visits.length > 9){
                recent_visits.splice(0, 1);
            }

            if(checkExist == true || recent_visits.length <= 9){
                var entry = {
                    "user_id": uid,
                    "page_title": page_title,
                    "url": request_url,
                    "date_time" : '<?=date('d-m-Y H:i:s');?>'
                };
                localStorage.setItem("entry", JSON.stringify(entry));
                recent_visits.push(entry);
                localStorage.setItem("recent_visits", JSON.stringify(recent_visits));
            }
            var recent_visits = JSON.parse(localStorage.getItem("recent_visits"));
            console.log(recent_visits);
            ACFn.sendAjax("/saveRecentVisits", 'get', {
                user_id: uid,
                recent_visits: recent_visits
            }, null, {
                'progress': ''
            });
        }
    }

    $(document).ready(function () {
        @if(Auth::check())
            var user_id = '<?=Auth::user()->id; ?>';
            var request_url = '<?=Request::url();?>';
            var page_title = $('title').text().split('-');
            if(page_title[1] != ""){
                if (typeof(Storage) !== "undefined") {
                    //localStorage.clear(); return false;
                    var recent_visits = JSON.parse(localStorage.getItem("recent_visits"));
                    if (recent_visits == null){
                        //getRecentVisits(user_id);

                    }
                    setTimeout(function () {
                        var recent_visits = JSON.parse(localStorage.getItem("recent_visits"));
                        console.log(recent_visits);
                        //recentVisit(user_id,request_url,page_title[1]);
                    },1000)
                }

            }
        @endif
    });




    window.setTimeout(function () {
        $(".alert").fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        });
    }, 1000);
</script>
<div id="AddTaskModal" class="modal fade bs-example-modal-lg " tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
</div>
<div class="modal fade bs-example-modal-sm1" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
     aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-md middle_model">
        <div class="modal-content abouttitle col-md-offset-1">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                <h2 style="color:#03a9f3; border-bottom:1px solid #ddd; padding-bottom:15px;padding-left: 18px;"><img
                            src="/elite/img/workdesk_logo.png"><span class="version">V_1.5.6</span></h2>

                <ul>
                    <li><img src="/elite/img/tick.png"> Manage projects & tasks given to self or to team</li>
                    <li><img src="/elite/img/tick.png"> Schedule your work & plan events via Calendar</li>
                    <li><img src="/elite/img/tick.png"> Create / upload documents to be shared with team</li>
                    <li><img src="/elite/img/tick.png"> Maintain records of all Minutes of Meetings</li>
                    <li><img src="/elite/img/tick.png"> Manage & address all service tickets from clients</li>
                    <li><img src="/elite/img/tick.png"> Collaborate with your team using Company Wall and Chat</li>
                </ul>
                <h3 class="modal-title" id="mySmallModalLabel">"Simplifying the way you work"</h3>
            </div>
            <div class="modal-body footer_text">
                <p>A product by <a href="http://www.allengersinfotech.com/" target="_blank">Allengers Infotech</a></p>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

</body>
</html>