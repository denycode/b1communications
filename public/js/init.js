var tooltip_data = [];


function initJS($outer) {

    // Switchery
    if ($outer.find('.js-switch').length) {
        $outer.find('.js-switch').each(function () {
            new Switchery($(this)[0], $(this).data());
        });
    }

    // Switchery
    if ($outer.find('.js-nestable').length) {
       /* $outer.find('.js-nestable').nestable({
            group: 1,
            maxDepth : 1
        }).on('change', updateOutput);*/

        var updateOutput = function(e) {
            var list = e.length ? e : $(e.target),
                output = list.data('output');
            if (window.JSON) {
                var updateVal = window.JSON.parse(window.JSON.stringify(list.nestable('serialize')));
                $('#list').val(window.JSON.stringify(list.nestable('serialize')));
                var ne = [];
                /*$("input[data-role=tagsinput]").tagsinput('removeAll');
                $.each(updateVal,function (index,value) {
                    ne.push(value.id);
                    $("input[data-role=tagsinput]").tagsinput('add', value.id);
                })
                output.val(ne.join(','));*/
            } else {
                output.val('JSON browser support required for this demo.');
            }
        };

        $outer.find('.js-nestable').nestable({
            group: 1,
            maxDepth : 1
        }).on('change', updateOutput);
        updateOutput($('.js-nestable').data('output', $outer.find("#list")));
    }

    if ($outer.find(".tagsinput").length) {
        $outer.find(".tagsinput").tagsinput('items');

        //Custom
        if($outer.find(".tagsinput").attr('data-callback')){
            $('.bootstrap-tagsinput input').attr('data-callback',$outer.find(".tagsinput").data('callback'));
        }
        if($outer.find(".tagsinput").attr('readonly')){
            $('.bootstrap-tagsinput input').attr('readonly',$outer.find(".tagsinput").attr('readonly'));
        }
        //Custom
        $(".tagsinput").on('itemRemoved', function(event) {
            $('.dd-list .dd-item[data-id="'+event.item+'"]').remove();
        });


        $('.bootstrap-tagsinput input').keydown(function( event ) {
            if ( event.which == 13 ) {
                //Custom
                if($(this).data('callback') && $(this).val() != ""){
                    $('.dd-list').append('<li class="dd-item" data-id="'+$(this).val()+'">\n' +
                        '                                <div class="dd-handle">'+$(this).val()+'</div>\n' +
                        '                            </li>')
                    initJS($('#sortableParent'));
                }
                $(this).blur();
                $(this).focus();

                return false;
            }
        })
    }

    // Switchery
    if ($outer.find('.mdate').length) {
        $outer.find('.mdate').bootstrapMaterialDatePicker({ weekStart: 0, time: false });

    }

    if ($outer.find('#table_task').length) {
        $outer.find('#table_task').dataTable({
            scrollY: 407,
            scrollX: true,
            "dom": 'l<"top-data"<"data-search"f><"data-page"p>>rti',
            stateSaveCallback: function (oSettings, oData) {
                // console.log(oData);
                var hash = window.location.hash;
                localStorage.setItem('DataTables_table_task' + hash, JSON.stringify(oData));
            },
            stateLoadCallback: function (oSettings) {
                var hash = window.location.hash;
                return JSON.parse(localStorage.getItem('DataTables_table_task' + hash));
            },
            "paging": false,
            'searching': false,
            "ordering": false,
            "colReorder": true,
            "stateSave": true,
            "buttons": [
                'colvis'
            ]
        })
    }

    if($outer.find('#basic_table2').length){
        $('.c-btn').hide();
        var dtable = $outer.find('#basic_table2').DataTable({
            "width" : "100%",
            dom: 'Bfrtip',
            "paging": false,
            "displayLength": 5,
            'searching': false,
            "ordering": false,
            "colReorder": true,
            "stateSave": true,
            "language": {
                "emptyTable": $outer.find('#basic_table2').data('message') ? $outer.find('#basic_table2').data('message') : "No data available in table"
            },
            "buttons": [{
                extend: 'colvis',
                text: '<i class="fas fa-table ds-c"></i>',
                collectionLayout: 'fixed two-column'
            }]
            //"dom": 'l<"top-data"<"data-search"f><"data-page"p>>rti',
            //responsive: true
        });
        $('.c-btn').html('');
        dtable.buttons().container()
            .appendTo( $('.c-btn') );

        $('#basic_table2').on('column-visibility.dt', function (e, settings, column, state) {
            var numCols = $('#basic_table2').DataTable().columns(':visible').nodes().length;
            console.log(numCols)
            $('#basic_table2').attr('style','width:100% !important')
        });

        setTimeout(function () {
            $('.dt-buttons').css({'padding-top' : '0px','margin-bottom' : '0px'});
            $('.dt-button').prop('title','Set Columns');
            $('.dt-button').prop('class','').addClass('btn btn-light d-none d-lg-block font-16');

            $('.c-btn').show();
        },1000);
    }

    if($outer.find('#basic_table1').length){
        var dtable = $outer.find('#basic_table1').DataTable({
            "width" : "100%",
            dom: 'Bfrtip',
            "paging": false,
            "displayLength": 5,
            'searching': false,
            "ordering": false,
            "stateSave": true,
            "language": {
                "emptyTable": $outer.find('#basic_table1').data('message') ? $outer.find('#basic_table1').data('message') : "No data available in table"
            },
            buttons: []
            //"dom": 'l<"top-data"<"data-search"f><"data-page"p>>rti',
            //responsive: true
        });
    }

    if ($outer.find('.dropify-ticket-attachment').length) {
        $outer.find('.dropify-ticket-attachment').dropify({
            messages: {
                'default': 'Drag and drop / Click to Select / Paste a Screenshot',
                // 'replace': 'Drag and drop or click to replace',
                // 'remove': 'Remove',
                // 'error': 'Ooops, something wrong happended.'
            }
        });
    }


    if ($outer.find("#filer_input").length) {
        $outer.find("#filer_input").filer(
            {
                showThumbs: true,
                addMore: true,
                allowDuplicates: false,
                theme: "default",
                excludeName: null,
                extensions: null,
                changeInput: true,
                showThumbs: true,
                appendTo: null,
                onRemove: function(){
                    setTimeout(function(){
                        $('#input_file').trigger("filer.remove", {id:0});
                        $('#input_file').trigger("filer.reset");
                        }, 1000);

                },
            }
        );
    }
    if ($outer.find("#filer_input1").length) {
        $outer.find("#filer_input1").filer({showThumbs: true, addMore: true, allowDuplicates: false});
    }
    if ($outer.find("#filer_input2").length) {
        $outer.find("#filer_input2").filer({showThumbs: true, addMore: true, allowDuplicates: false});
    }

    if ($outer.find("#filer_input_meeting_task").length) {
        $outer.find("#filer_input_meeting_task").filer({showThumbs: true, addMore: true, allowDuplicates: false});
    }

    if ($outer.find("#filer_input_meeting").length) {
        $outer.find("#filer_input_meeting").filer({showThumbs: true, addMore: true, allowDuplicates: false});
    }

    if ($outer.find("#filer_input_meeting_tasks").length) {
        $outer.find("#filer_input_meeting_tasks").filer({showThumbs: true, addMore: true, allowDuplicates: false});
    }

    if ($outer.find("#filer_input_event").length) {
        $outer.find("#filer_input_event").filer({showThumbs: true, addMore: true, allowDuplicates: false});
    }

    if ($outer.find("a.grouped_elements").length) {
        $outer.find("a.grouped_elements").fancybox({
            prevEffect: 'none',
            nextEffect: 'none',
            closeBtn: false,
            helpers: {
                title: {type: 'inside'},
                buttons: {}
            }
        });
    }

    if ($(".word").length) {
        $(".word").fancybox({
            width: 1000, // or whatever
            height: 600,
            type: 'iframe',
            href: this.href,
        });
    }

    if ($outer.find('#example23').length) {
        $outer.find('#example23').DataTable({
            searching: false, paging: false,
            "stateSave": true,
            "scrollY": 350,
            "scrollX": true,

        });
    }
    if ($outer.find('#upcoming').length) {
        $outer.find('#upcoming').DataTable({
            dom: 'Bfrtip',
            // "ordering": false,
            order: [[4, 'asc']],
            "iDisplayLength": 20,
            buttons: []
        });
    }
    if ($outer.find('#late').length) {
        $outer.find('#late').DataTable({
            dom: 'Bfrtip',
            "ordering": false,
            "iDisplayLength": 20,
            buttons: []
        });
    }
    if ($outer.find('#done').length) {
        $outer.find('#done').DataTable({
            "paging": false,
            "ordering": false,
            "info": false
        });
    }
    if ($outer.find('#taskList').length) {
        $outer.find('#taskList').DataTable({
            dom: 'Bfrtip',
            "ordering": false,
            "iDisplayLength": 20,
            buttons: []
        });
    }

    var config = {
        '.chosen-select': {display_selected_options: false},
        '.chosen-select-deselect': {allow_single_deselect: true, display_selected_options: false},
        '.chosen-select-no-single': {disable_search_threshold: 10, display_selected_options: false},
        '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!', display_selected_options: false},
        '.chosen-select-width': {width: "95%", display_selected_options: false},
        '.chosen-select-disable-search': {disable_search: true}
    }
    for (var selector in config) {
        if ($outer.find(selector).length) {
            if (typeof  ($outer.find(selector).chosen) == 'function') {
                $outer.find(selector).chosen(config[selector]);
            } else {
                console.error('Load Chosen Library');
            }
        }
    }

    if ($outer.find("#timepicker").length) {
        var $timepicker = $outer.find("#timepicker");
        var $parent = $timepicker.parent('div');
        var $timpicker_hour = $parent.find('#timepicker-hour');
        var $timpicker_minute = $parent.find('#timepicker-minute');
        var hours = parseInt($timepicker.val() / 60);
        var minutes = parseInt($timepicker.val() % 60);
        $timpicker_hour.val(hours);
        $timpicker_minute.val(minutes);
        $timpicker_hour.on('change', function () {
            putTime();
        });
        $timpicker_minute.on('change', function () {
            putTime();
        });

        function putTime() {
            var hours = $timpicker_hour.val();
            var minutes = $timpicker_minute.val();
            var calc = (hours * 60) + parseInt(minutes);
            if (calc) {
                $timepicker.val(calc);
            } else {
                $timepicker.val('');
            }
        }
    }

    if ($outer.find('[data-toggle="tooltip"]').length) {
        $outer.find('[data-toggle="tooltip"]').tooltip();
    }

    if ($outer.find('.summernote').length) {
        $outer.find('.summernote').summernote({
            toolbar:[
                // This is a Custom Button in a new Toolbar Area

                ['font', ['bold', 'italic', 'underline']],
                ['fontname',['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph', 'link']],
                ['custom', ['checklist']]
            ],
            height: 350,                 // set editor height
            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            focus: false,                 // set focus to editable area after initializing summernote

            callbacks: {
                onImageUpload: function (data) {
                    data.pop();
                },onPaste: function (e) { console.log('hereee');
                    var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                    e.preventDefault();
                    document.execCommand('insertText', false, bufferText);
                }
            }
        });
        $.each($outer.find('.summernote'), function (index, element) {
            var disabled = $(element).prop('disabled');
            if (disabled) {
                $(element).summernote('disable');
            }
        })
    }

    if ($outer.find("#tickets_table").length) {
        var $table = $outer.find("#tickets_table");
        // console.log($table);
        $table.DataTable({
            scrollY: 380,
            scrollX: true,
            "dom": 'l<"top-data"<"data-search"f><"data-page"p>>rti',
            stateSaveCallback: function (oSettings, oData) {
                // console.log(oData);
                var hash = window.location.hash;
                localStorage.setItem('DataTables_tickets_table' + hash, JSON.stringify(oData));
            },
            stateLoadCallback: function (oSettings) {
                var hash = window.location.hash;
                return JSON.parse(localStorage.getItem('DataTables_tickets_table' + hash));
            },
            "paging": false,
            'searching': false,
            "colReorder": true,
            "stateSave": true,
            "buttons": [
                'colvis'
            ]


        });
    }

    if ($outer.find('#gap_reports_table').length) {
        var $table = $outer.find('#gap_reports_table');
        $table.DataTable({
            searching: false, paging: false,"stateSave": true, "scrollY": true,"scrollX": true,
        });
    }

    if ($outer.find('.ajax-Tooltip').length) {
        // $outer.find('.ajax-Tooltip').on('mouseenter', function () {
        //     var url = $(this).data('href');
        //     var id = $(this).data('tooltip-id');
        //     $(this).data('popover-show', true);
        //     if ($(this).data('popover-loaded')) {
        //         $(this).tooltip('show');
        //     } else if (typeof (tooltip_data[id]) != 'undefined') {
        //         initAjaxTooltip($(this), tooltip_data[id]);
        //     } else {
        //         ACFn.sendAjax(url, 'GET', [], $(this), false);
        //     }
        //
        // })
        // $outer.find('.ajax-Tooltip').on('mouseleave', function () {
        //     $(this).data('popover-show', false);
        //     $(this).tooltip('hide');
        // })
    }

    if ($outer.find('#datepicker-autoclose1').length) {
        $outer.find('#datepicker-autoclose1').datepicker({
            todayBtn: "linked",
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true
        });
    }

    if ($outer.find('.js-datepicker').length) {
        // console.log('datepicker Found');
        $.each($outer.find('.js-datepicker'), function (index, element) {
            $(element).datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                calendarWeeks: true,
                todayHighlight: true
            });
        });
    }

    if ($outer.find('.dev_popover').length) {
        $.each($outer.find('.dev_popover'), function (index, element) {
            // $(element).popover({
            //     html: true,
            //     content: $("#" + $(element).data('id')).html()
            // });
        })
    }

    /*if ($outer.find('.js-slim-scroll').length) {
        $.each($outer.find('.js-slim-scroll'), function (index, element) {
            var height = $(element).data('height');
            var start = $(element).data('start');
            if (!height) {
                height = '200px'
            } else if (height == 'auto') {
                height = '';
            }
            if (!start) {
                start = 'top'
            }
            $(element).slimScroll({
                height: height,
                start: start
            });
        });
    }*/

    if ($outer.find('.timeline-html-popover').length) {
        $outer.find('.timeline-html-popover').on('click', function (e) {
            e.preventDefault();
        })
        $.each($outer.find('.timeline-html-popover'), function (index, element) {
            $(element).popover({
                html: true,
                trigger: 'hover',
                placement: 'right',
                container: 'body',
                template: '<div class="popover timeline-popover fade right in">\n' +
                '    <div class="arrow"></div\n' +
                '    <h3 class="popover-title"></h3>\n' +
                '    <div class="popover-content">\n' +
                '\n' +
                '    </div>\n' +
                '</div>'
            });
        });
    }

    if ($outer.find('.t-f-tooltip').length) {
        // alert('tool');
        $outer.find('.t-f-tooltip').tooltip({
            container: 'body',
            html: true,
            placement: 'auto top'

        });
    }

    if ($outer.find(".phone-inputmask").length) {
        // alert('tool');
        $outer.find(".phone-inputmask").inputmask("(999) 999-9999");
    }
    if ($outer.find('.t-f-tooltip').length) {
        // alert('tool');
        $outer.find('.t-f-tooltip').tooltip({
            container: 'body',
            html: true,
            placement: 'auto top'

        });
    }

    if ($outer.find('.t-t-tooltip').length) {
        // alert('tool');
        $outer.find('.t-t-tooltip').tooltip({
            container: 'body',
            placement: 'auto top'

        });
    }

    if ($outer.find('.ti-t-tooltip').length) {
        // alert('tool');
        $outer.find('.ti-t-tooltip').tooltip({
            container: 'body',
            placement: 'auto top'

        });
    }

    if ($('#startDateId').length) {
        $('#startDateId').datepicker({  //#datepicker-autoclose
            todayBtn: "linked",
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true
        }).on('changeDate', function(e) {
            console.log("sdfgs");
            validateStartEndDate();
            // validateEventStartEndDate();
        });
    }
    if ($('#endDateId').length) {
        $('#endDateId').datepicker({
            todayBtn: "linked",
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true
        }).on('changeDate', function(e) {
            validateStartEndDate();
        });
    }

    jQuery('.addon').click(function () {
        jQuery('#startDateId').datepicker('show');
    });
    jQuery('.addon1').click(function () {
        jQuery('#endDateId').datepicker('show');
    });

    function validateStartEndDate(){
        if((jQuery('#startDateId').val() != "" && jQuery('#endDateId').val() != "")){
            //jQuery('#dft_input_from').val() > jQuery('#dft_input_to').val()
            var startDate = jQuery('#startDateId').val();

            var startDatePart = startDate.split('-');

            var convertedStartDate = startDatePart[2]+'-'+startDatePart[1]+'-'+startDatePart[0];
            stringStartdate = new Date(convertedStartDate).toISOString();

            var endDate = jQuery('#endDateId').val();
            var endDatePart = endDate.split('-');

            var convertedEndDate = endDatePart[2]+'-'+endDatePart[1]+'-'+endDatePart[0];
            stringEnddate = new Date(convertedEndDate).toISOString();


            if(stringStartdate > stringEnddate){
                ACFn.display_message('End Date cannot be less than Start Date  !!', '', 'error', null);
                jQuery('#endDateId').val('');
            }
        }
    }

    if ($outer.find("input[type=text]").length > 0) {
        $outer.find("input[type=text]").attr('autocomplete','off');
    }

    if ($outer.find("input[type=password]").length > 0) {
        $outer.find("input[type=password]").attr('autocomplete','off');
    }

    if ($outer.find("input[type=email]").length > 0) {
        $outer.find("input[type=email]").attr('autocomplete','off');
    }

    if ($outer.find("form").length > 0) {
        $outer.find("form").attr('autocomplete','off');

    }

}



function details_in_popup(link, div_id) {
    //
    // $.ajax({
    //     url: link,
    //     success: function (response) {
    //         $('#' + div_id).html(response);
    //     }
    // });
    return '<div id="' + div_id + '">Loading...</div>';
}

function scroll_div_to_bottom($div) {
    setTimeout(function () {
        // console.log($div.prop("scrollHeight"));
        $div.animate({scrollTop: $div.prop("scrollHeight")}, 0);
    }, 100);

    $div.animate({scrollTop: $div.prop("scrollHeight")}, 0);
}

function scroll_to_div() {

}

function initAjaxTooltip(F, R) {
    // var id = F.data('tooltip-id');

    // $allpopovers = $('[data-tooltip-id="' + id + '"]');
    // if ($allpopovers) {
    //     $allpopovers.each(function (index, element) {
    //         $(element).attr('title', R.html);
    //         $(element).tooltip({
    //             "html": true,
    //             trigger: 'manual',
    //             container: 'body',
    //             'viewport': {selector: '#page-wrapper', padding: 107},
    //             placement: 'auto top',
    //             // "content": R.html
    //         });
    //         $(element).data('popover-loaded', true);
    //     });
    // }
    F.attr('title', R.html);
    F.tooltip({
        html: true,
        trigger: 'manual',
        container: 'body',
        'viewport': {selector: '#page-wrapper', padding: 107},
        placement: 'auto left',
        // "content": R.html
    });
    F.data('popover-loaded', true);
    // F.popover({
    //     "html": true,
    //     trigger: 'manual',
    //     placement: 'auto top',
    //     "content": R.html
    // });
    if (F.data('popover-show')) {
        F.tooltip('show');
    }
}

$("document").ready(function () {

    $("body").on('click', '.dev_popover', function (e) {
        e.preventDefault();
        var $element = $(this);
        if ($element.next().hasClass('popover')) {
            $element.popover("destroy");
        } else {
            $element.popover({
                trigger: 'manual',
                html: true,
                content: $("#" + $element.data('id')).html()
            });

            $element.popover("show");
            $popover = $element.next();
            $popover.find('.dev_slider').slider({
                //ticks: [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100],
                ticks: [0, 50, 100],
                tooltip: 'always',
                tooltip_position: 'bottom',
                min: 0,
                max: 100,
                value: $popover.find('.dev_slider').val(),
                step: 10
            });
            //

        }
    });


    if (typeof NProgress != 'undefined') {
        NProgress.configure({minimum: 0.4});
    }

    $('body').on('mouseenter', '.ajax-Tooltip', function () {
        var url = $(this).data('href');
        var id = $(this).data('tooltip-id');
        $(this).data('popover-show', true);
        if ($(this).data('popover-loaded')) {
            $(this).tooltip('show');
        } else if (typeof (tooltip_data[id]) != 'undefined') {
            initAjaxTooltip($(this), tooltip_data[id]);
        } else {
            ACFn.sendAjax(url, 'GET', [], $(this), {
                progress: 'nprogress',
                showServerError: false
            });
        }

    })
    $('body').on('mouseleave', '.ajax-Tooltip', function () {
        $(this).data('popover-show', false);
        $(this).tooltip('hide');
    })

    ACFn.append_tooltip_data = function (F, R) {
        var id = F.data('tooltip-id');
        tooltip_data[id] = R;
        initAjaxTooltip(F, R);
        return;
        // console.log(R.html);
        // F.html(R.html);
        var id = F.data('tooltip-id');
        $allpopovers = $('[data-tooltip-id="' + id + '"]');
        if ($allpopovers) {
            $allpopovers.each(function (index, element) {
                $(element).attr('title', R.html);
                var placement = $(element).data('placement');
                if(!placement) {
                    placement = 'auto top';
                }
                $(element).tooltip({
                    "html": true,
                    trigger: 'manual',
                    container: 'body',
                    'viewport': {selector: '#page-wrapper', padding: 107},
                    placement: placement,
                    // "content": R.html
                });
                $(element).data('popover-loaded', true);
            });
        }
        // F.popover({
        //     "html": true,
        //     trigger: 'manual',
        //     placement: 'auto top',
        //     "content": R.html
        // });
        if (F.data('popover-show')) {
            F.tooltip('show');
        }
    }

    ACFn.Task_Reset = function (F, R) {
        $('.tab-ajax:first-child').removeClass('active');
        target = $('#autoajax ul');
        if(R.tab_id){
            $('#autoajax li').parent().find('li').removeClass("active");
            $('a[data-tabid=' + R.tab_id + ']').trigger('click');
        }else{
            $('li:first-child', target).removeClass('active');
            $('li:first-child a', target).trigger('click');
        }
        $('#single-task_'+R.task_id+' a').trigger('click');
        if(R.decision){
            $('#single-task_'+R.task_id+' a span').text(R.decision);
        }
        $('#modal-popup').modal('hide');
        $('.bk-overlay').removeClass("in");
        $('.bk-overlay').addClass("out");
        $("body").removeClass('bk-overlay-in');
        setTimeout(function () {
            $('.bk-overlay').remove();
        }, 1000);
        ACFn.display_message(R.messageTitle, '', 'success', null);
    }

    ACFn.Ticket_Reset = function (F, R) {
        $('.tab-ajax:first-child').removeClass('active');
        target = $('#autoajax ul');
        if(R.tab_id){
            $('#autoajax li').parent().find('li').removeClass("active");
            $('a[data-tabid=' + R.tab_id + ']').trigger('click');
        }else{
            $('li:first-child', target).removeClass('active');
            $('li:first-child a', target).trigger('click');
        }
        $('#single-ticket_'+R.ticket_id+' a').trigger('click');
        if(R.decision){
            $('#single-ticket_'+R.ticket_id+' a span').text(R.decision);
        }

        $('#modal-popup').modal('hide');
        $('.bk-overlay').removeClass("in");
        $('.bk-overlay').addClass("out");
        $("body").removeClass('bk-overlay-in');

        setTimeout(function () {
            $('.bk-overlay').remove();


        }, 1000);
        ACFn.display_message(R.messageTitle, '', 'success', null);
    }

    ACFn.append_associate_grid = function(F, R){
        var tab = $('[href="#related"]');
        tab.find('.notify').html('('+R.countt+')');
        $('#related').html(R.associatetask);
        $('#modal-popup').modal('hide');
        $('.bk-overlay').removeClass("in");
        $('.bk-overlay').addClass("out");
        $("body").removeClass('bk-overlay-in');

        setTimeout(function () {
            $('.bk-overlay').remove();


        }, 1000);
        ACFn.display_message(R.messageTitle, '', 'success', null);
    }

    $("body").on("click", ".nav li a", function () {
        if ($(this).data('toggle') == 'tab') {
            var target = $(this).attr('href');
            if ($(target).length) {
                if ($(target).find('.scroll-task').length) {
                    scroll_div_to_bottom($(target).find('.scroll-task'));
                }
            }
        }
    });

    if ($(".scroll-task").length) {
        $(".scroll-task").each(function (index, element) {
            // console.log("scroll to  bottom");
            scroll_div_to_bottom($(element));
        });
    }

    if (typeof (swal) == 'function') { console.log(swal);
        swal.mixin({
            customClass: 'wd_alert',
            padding: 10,
            animation: false
        });
    }
    //

    initJS($("body"));
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
        ACFn.loadModalLayout = function (F, R) {
            $("#modal-popup").remove();
            $("body").append(R.html);
            setTimeout(function () {
                $("#modal-popup").modal('show');
                initJS($("#modal-popup"));
            }, 50);
        }
    }
    $("body").on('click', '.bk-overlay .close, .bk-overlay [type="reset"]', function (e) {
        e.preventDefault();
        $(".note-popover").hide();
        $(this).parents('.bk-overlay').removeClass("in");
        $(this).parents('.bk-overlay').addClass("out");
        $("body").removeClass('bk-overlay-in');
        setTimeout(function () {
            $(this).parents('.bk-overlay').remove();
        }, 1000);
    });

    ACFn.loaddescriptiontab = function (F, R) {
        location.reload();
    }

    $("body").on('change', ".table-developer-percent", function () {
        var data = {
            percent_complete: $(this).val(),
            // id: $(this).parents("tr").data("id")
        };
        ACFn.sendAjax($(this).data('url'), 'get', data, $(this));
    });

    var dev_slider_timeout = null;
    $("body").on('change', ".dev_slider", function (slideEvt) { //change from slide
        var dev_slider = $(this);
        console.log(slideEvt);
        window.clearTimeout(dev_slider_timeout);
        dev_slider_timeout = window.setTimeout(function () {
            var data = {
                percent_complete: slideEvt.value.newValue
            };
            ACFn.sendAjax(dev_slider.data('url'), 'get', data, dev_slider);
        }, 1000);
        // console.log(slideEvt);
        // console.log($(this).val());

    });

    $("body").on("change", '.table-milestone-selector', function () {
        var data = {
            milestone_id: $(this).val()
        };
        ACFn.sendAjax($(this).data('url'), 'get', data, $(this));
    });


    $("body").on("change", '.table-tester-status', function (e) {
        // console.log(e);
        // e.preventDefault();
        var oldValue = '';
        var newValue = $(this).val();
        // console.log(oldValue);
        // console.log(newValue);
        var data = {
            decision: $(this).val()
        };
        $(this).val(oldValue);
        ACFn.sendAjax($(this).data('url'), 'get', data, $(this));
    });

    $("body").on("change", '.table-developer-status', function () {
        var data = {
            decision: $(this).val()
        };
        ACFn.sendAjax($(this).data('url'), 'get', data, $(this));
    });

    $("body").on("change", '.table-manager-status', function () {
        var data = {
            decision: $(this).val()
        };
        ACFn.sendAjax($(this).data('url'), 'get', data, $(this));
    });

    $("body").on("change", '.table-task-status', function () {
        // console.log(e);
        // e.preventDefault();
        var oldValue = '';
        var newValue = $(this).val();
         console.log(oldValue);
         console.log(newValue);
         if(newValue == "RECHECK"){
             $(this).val(oldValue);
         }

        var data = {
            status: newValue,
            // id: $(this).parents("tr").data("id")
        };
        ACFn.sendAjax($(this).data('url'), 'get', data, $(this));
    });

    $('body').on('click', function (e) {
        //did not click a popover toggle or popover
        // console.log('clicked2');
        if (!$(e.target).hasClass('dev_popover')
            && $(e.target).parents('.dev_popover').length === 0
            && $(e.target).parents('.popover.in').length === 0) {
            // console.log('clicked');
            if ($('.popover.in').length) {

                $('.popover.in').prev().popover('destroy');
            }
        }
    });

    ACFn.showtesterrecheckcommentpopup = function (F, R) {

    }

    if (typeof SETTING_SELECT_COPY_CLIPBOARD != 'undefined' && SETTING_SELECT_COPY_CLIPBOARD) {
        var clipboardTimeout = null;
        $("body").on('mouseup', function (e) {
            // console.log(e);
            // console.log('isException : ' + CopyToClipboardObj.isException($(e.target)));

            if (
                $(e.target).parents('form').length > 0 || CopyToClipboardObj.isException(e.target)) {

            } else {
                // console.log($(e.target));
                window.clearTimeout(clipboardTimeout);
                clipboardTimeout = setTimeout(function () {
                    copyToClipboard();
                }, 300);
            }
        });
    }
});

function copyToClipboard() {
    var sel = getSelectedText();
    // console.log("'" + sel + "'");
    if (sel && sel.trim() != '') {
        if ($("#clipboardtextinput").length == 0) {
            var $temp = $("<input id='clipboardtextinput' type='hidden' >");
            $("body").append($temp);
        }
        var field = $("#clipboardtextinput");

        // $("div").text(sel);
        field.val(sel).select();
        document.execCommand("copy");
        clearSelectionClipboard();
        swal.fire({
            customClass: 'swal-wd swal-clipboard',
            title: 'Copied to clipboard',
            timer: 1500,
            backdrop: false,
            toast: true,
            animation: false,
            showConfirmButton: false
        });
        // $temp.remove();
    }
}

function getSelectedText() {
    if (window.getSelection) { // all browsers, except IE before version 7
        var selectionRange = window.getSelection();
        // console.log(selectionRange);
        if ($(selectionRange.anchorNode).is('input')) {
            return false;
        }
        return selectionRange.toString();
    } else {
        if (document.selection.type == 'None') {
            return false;
        } else {
            var textRange = document.selection.createRange();
            return textRange.text;
        }
    }
}

function clearSelectionClipboard() {
    if (document.selection) {
        document.selection.empty();
    } else if (window.getSelection) {
        window.getSelection().removeAllRanges();
    }
}

var PageTitleNotification = {
    Vars: {
        OriginalTitle: document.title,
        Interval: null,
        notification: {},
        speed: 2000,
        displayedNotifications: 0
    },
    On: function (notification, type, intervalSpeed) {
        var _this = this;
        clearInterval(_this.Vars.Interval);
        var speed = _this.Vars.speed;
        if (typeof intervalSpeed != 'undefined') {
            speed = intervalSpeed;
        }
        _this.Vars.notification[type] = notification;

        console.log(_this.Vars.notification);

        // var speed = (typeof intervalSpeed == 'int') ? intervalSpeed : 3000
        _this.Vars.Interval = setInterval(function () {
            var title = _this.Vars.OriginalTitle;
            var totalnotifications = 0;
            $.each(_this.Vars.notification, function (index, value) {
                totalnotifications++;
            });

            if (_this.Vars.displayedNotifications < totalnotifications) {
                _this.Vars.displayedNotifications++;
                var count = 0;
                $.each(_this.Vars.notification, function (index, value) {
                    count++;
                    if (count == _this.Vars.displayedNotifications) {
                        title = value;
                    }
                });
                // title = _this.Vars.displayedNotifications;
            } else {
                _this.Vars.displayedNotifications = 0;
            }
            document.title = title;

            // document.title = (_this.Vars.OriginalTitle == document.title)
            //     ? notification
            //     : _this.Vars.OriginalTitle;
        }, speed);
    },
    Off: function (type) {
        delete this.Vars.notification[type];
        var totalnotifications = 0;
        $.each(this.Vars.notification, function (index, value) {
            totalnotifications++;
        });
        if (totalnotifications == 0) {
            clearInterval(this.Vars.Interval);
        }
        document.title = this.Vars.OriginalTitle;
    }
}


var CopyToClipboardFunctions = function () {
    this.exceptions = [];
    this.addException = function (a) {
        this.exceptions.push(a);
    }
    this.isException = function (a) {
        var flag = false;
        $.each(this.exceptions, function (index, element) {
            if ($(a).parents(element).length) {
                flag = true;
            }
            // console.log(element);
        })
        return flag;
    }
}

window.CopyToClipboardObj = new CopyToClipboardFunctions();
