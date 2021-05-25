$(document).ready(function () {
    ACFn.ajax_status_toggle = function (F,R) {
        console.log(F)
        if(R.is_active){
            F.children('i').addClass('fa-check').removeClass('fa-times');

            //F.addClass('btn-success').removeClass('btn-danger');

        }else{

            F.children('i').addClass('fa-times').removeClass('fa-check')
           // F.addClass('btn-danger').removeClass('btn-success');
        }
    }

    ACFn.ajax_extension_updated = function (F,R) {
        if(R.success){
            $('.tab-hash li a[href="#tab_20"]').trigger('show.bs.tab');
            $('.bk-overlay .modal-header .side-close').trigger('click');
        }
    }

    ACFn.ajax_profile_load = function (F,R){
        ACFn.display_message(R.messageTitle,'','success');
        if(R.success){
            $('.side-close').trigger('click');
           $('.tab-hash li a.active').trigger('show.bs.tab');
        }
    }

    ACFn.ajax_update_image = function (F , R) {
        $('.pp_img').attr('src',R.u_img_pth)
        $('.pp').hide();
        ACFn.display_message(R.messageTitle,'','success');
    }

    ACFn.ajax_extensions_list = function (F,R) {
        if(R.success){
            $('#modal-popup').modal('hide');
            if(R.grplist != ""){
                var grplist = R.grplist.split('::');
                if($('#list').val().indexOf($.trim(grplist[0])) == -1){
                    //$('.dd-list').html('');
                    $('#list').val(
                        $('#list').val() == "" ?
                            $.trim(grplist[0]) :
                            $.trim($('#list').val()) + ',' + $.trim(grplist[0])
                    );

                    $('.dd-list').append('<li class="dd-item" data-id="'+$.trim(grplist[0])+'" data-type="internal" data-showas="' + grplist[0] + ' - ' + grplist[1] + '">\n' +
                        ' <div class="dd-handle  dd3-handle"></div>' +
                        ' <div class="dd3-content">' +
                        '' + grplist[0] + ' - ' + grplist[1] + '' +
                        '    <a href="javascript:void(0);" class="btn waves-effect waves-light btn-sm btn-danger pull-right" ' +
                        'onclick="removeExtensionTemp('+$.trim(grplist[0])+',\'list\')">Delete</a> ' +
                        ' </div>\n' +
                        ' </li>');
                    initJS($('#sortableParent'));
                }

            }
        }
    }

    ACFn.ajax_external_extensions_list = function (F,R) {
        if(R.success){
            $('#modal-popup').modal('hide');
            if(R.grplist != ""){
                var grplist = R.grplist.split('::');
                /*if($('#list').val().indexOf($.trim(grplist[0])) == -1){
                    $('#list').val(
                        $('#list').val() == "" ?
                            $.trim(grplist[0]) :
                            $.trim($('#list').val()) + ',' + $.trim(grplist[0])
                    );*/

                    $('.dd-list').append('<li class="dd-item" data-id="'+$.trim(grplist[0])+'" data-type="external" data-showas="' + grplist[1] + ' (External)">\n' +
                        ' <div class="dd-handle  dd3-handle"></div>' +
                        ' <div class="dd3-content">' +
                        '' + grplist[1] + ' (External)' +
                        '    <a href="javascript:void(0);" class="btn waves-effect waves-light btn-sm btn-danger pull-right" ' +
                        'onclick="removeExtensionTemp('+$.trim(grplist[0])+',\'list\')">Delete</a> ' +
                        ' </div>\n' +
                        ' </li>');
                    initJS($('#sortableParent'));
                //}

            }
        }
    }

    /*ACFn.ajax_org_extensions_list = function (F,R) {
        if(R.success){
            $('#modal-popup').modal('hide');
            $('.dd-list').html('');
            var extIds = [];
            $.each(R.grplist,function (key,value) {
                var newVal = value.split('::');
                extIds.push($.trim(newVal[0]));
                $('.dd-list').append('<li class="dd-item" data-id="'+$.trim(newVal[0])+'">\n' +
                    ' <div class="dd-handle  dd3-handle"></div>' +
                    ' <div class="dd3-content">' +
                    '' + newVal[0] + ' - ' + newVal[1] + '' +
                    '    <i class="fas fa-times-circle pull-right" onclick="removeExtensionTemp('+$.trim(newVal[0])+')" style="color: #f84444;"></i> ' +
                    ' </div>\n' +
                    ' </li>');
            })

            $('#list').val(extIds.length > 0 ? extIds.join(',') : '');
            initJS($('#sortableParent'));
        }
    }*/

    ACFn.ajax_org_extensions_list = function (F,R) {
        if(R.success){
            $('#modal-popup').modal('hide');
            if(R.grplist != ""){
                var grplist = R.grplist.split('::');
                if($('#list_extensions').val().indexOf($.trim(grplist[0])) == -1){
                    //$('.dd-list').html('');
                    $('#list_extensions').val(
                        $('#list_extensions').val() == "" ?
                            $.trim(grplist[0]) :
                            $.trim($('#list_extensions').val()) + ',' + $.trim(grplist[0])
                    );

                    $('.l-extensions').append('<li class="list-group-item">\n' +
                        '' + grplist[0] + ' - ' + grplist[1] + '' +
                        '<a href="javascript:void(0);" data-effectonid="list_extensions" onclick="removeOrgElements('+$.trim(grplist[0])+')" class="btn waves-effect waves-light btn-sm btn-danger pull-right">Delete</a>' +
                        ' </li>');
                }
            }
        }
    }

    ACFn.ajax_org_departments_list = function (F,R) {
        if(R.success){
            $('#modal-popup').modal('hide');
            if(R.grplist != ""){
                var grplist = R.grplist.split('::');
                if($('#list_departments').val().indexOf($.trim(grplist[0])) == -1){
                    //$('.dd-list').html('');
                    $('#list_departments').val(
                        $('#list_departments').val() == "" ?
                            $.trim(grplist[0]) :
                            $.trim($('#list_departments').val()) + ',' + $.trim(grplist[0])
                    );

                    $('.l-departments').append('<li class="list-group-item">\n' +
                        grplist[1] + '' +
                        '<a href="javascript:void(0);" data-effectonid="list_departments" onclick="removeOrgElements('+$.trim(grplist[0])+')" class="btn waves-effect waves-light btn-sm btn-danger pull-right">Delete</a>' +
                        ' </li>');
                }
            }
        }
    }

    ACFn.ajax_org_phonenumbers_list = function (F,R) {
        if(R.success){
            $('#modal-popup').modal('hide');
            if(R.grplist != ""){
                var grplist = R.grplist.split('::');
                if($('#list_phonenumbers').val().indexOf($.trim(grplist[0])) == -1){
                    //$('.dd-list').html('');
                    $('#list_phonenumbers').val(
                        $('#list_phonenumbers').val() == "" ?
                            $.trim(grplist[0]) :
                            $.trim($('#list_phonenumbers').val()) + ',' + $.trim(grplist[0])
                    );

                    $('.l-phonenumbers').append('<li class="list-group-item">\n' +
                        '' + grplist[1] + ' - ' + grplist[2] + '' +
                        '<a href="javascript:void(0);" data-effectonid="list_phonenumbers" ' +
                        'onclick="removeOrgElements($(this),'+$.trim(grplist[0])+')" ' +
                        'class="btn waves-effect waves-light btn-sm btn-danger pull-right">Delete</a>' +
                        ' </li>');
                }
            }
        }
    }

    ACFn.ajax_org_users_list = function (F,R) {
        if(R.success){
            $('#modal-popup').modal('hide');
            if(R.grplist != ""){
                var grplist = R.grplist.split('::');
                if($('#list_users').val().indexOf($.trim(grplist[0])) == -1){
                    //$('.dd-list').html('');
                    $('#list_users').val(
                        $('#list_users').val() == "" ?
                            $.trim(grplist[0]) :
                            $.trim($('#list_users').val()) + ',' + $.trim(grplist[0])
                    );

                    /*$('.l-users').append('<li class="list-group-item">\n' +
                        '' + grplist[1] +
                        '<a href="javascript:void(0);" data-effectonid="list-users" ' +
                        'onclick="removeOrgElements($(this),'+$.trim(grplist[0])+')" ' +
                        'class="btn waves-effect waves-light btn-sm btn-danger pull-right">Delete</a>' +
                        ' </li>');*/

                    $('.l-users').append('<li class="list-group-item">\n' +
                        '' + grplist[1] +
                        '' +
                        ' </li>');
                }
            }
        }
    }

    ACFn.ajax_org_announcements_list = function (F,R) {
        if(R.success){
            $('#modal-popup').modal('hide');
            if(R.grplist != ""){
                var grplist = R.grplist.split('::');
                if($('#list_announcements').val().indexOf($.trim(grplist[0])) == -1){
                    //$('.dd-list').html('');
                    $('#list_announcements').val(
                        $('#list_announcements').val() == "" ?
                            $.trim(grplist[0]) :
                            $.trim($('#list_announcements').val()) + ',' + $.trim(grplist[0])
                    );

                    $('.l-announcements').append('<li class="list-group-item">\n' +
                        '' + grplist[1] + '' +
                        '<a href="javascript:void(0);" data-effectonid="list_announcements" ' +
                        'onclick="removeOrgElements($(this),'+$.trim(grplist[0])+')" ' +
                        'class="btn waves-effect waves-light btn-sm btn-danger pull-right">Delete</a>' +
                        ' </li>');
                }
            }
        }
    }


    ACFn.ajax_org_access = function (F , R) {
        $('.orgname').text('').text(R.organization_name);
        $('[title="Access"]').removeClass('btn-success').addClass('btn-info');
        F.removeClass('btn-info').addClass('btn-success');
    }
})




function removeOrgElements(obj,extID) {
    var data = {
        'title': 'Are you sure you want to delete ?',
        'text' : '',
        'butttontext' : 'Yes',
        'cbutttonflag' : true
    };
    ACFn.display_confirm_message(data,deleteOrgElements,{
        obj : obj,
        extid : extID
    });
}

function deleteOrgElements(params) {
    params.obj.parent('li.list-group-item').fadeOut();
    var effectonid = params.obj.data('effectonid');
    //var effectonclass = params.data('effectonclass');
    //$('[data-id="' + params.extid + '"]').remove();
    var listval = $('#' + effectonid).val();
    if(listval != ""){
        var listArr = listval.split(',');
        var newlistArr = $.grep(listArr, function(value) {
            return value != params.extid;
        });
        $('#' + effectonid).val(newlistArr.join(','));
    }
}


function removeExtensionTemp(extID,inputId) {
    var data = {
        'title': 'Are you sure you want to delete ?',
        'text' : '',
        'butttontext' : 'Yes',
        'cbutttonflag' : true
    };
    ACFn.display_confirm_message(data,deleteNestable,{
        extid : extID,
        inputId : inputId
    });
}

function deleteNestable(params) {
    $('[data-id="' + params.extid + '"]').remove();
   /* var listval = $('#' + params.inputId).val();
    if(listval != ""){
        var listArr = listval.split(',');
        var newlistArr = $.grep(listArr, function(value) {
            return value != params.extid;
        });
        $('#' + params.inputId).val(newlistArr.join(','));
    }*/
    initJS($('#sortableParent'));
}
