$(document).ready(function () {
        $("body").on("change", "#change_destination", function (e) {
            var data_arr = {
                dest : $(this).val(),
            };
            ACFn.sendAjax(baseURL+'/common/destinationvalue','GET',data_arr);
            ACFn.ajax_destination_steps = function (F , R){
                $('.append_dest .row').remove();
                $('.append_dest').append(R.html);
            }
        });

        ACFn.ajax_destination_values = function(F,R){
            if(R.success){
                var dest = R.org_dest;
                var destination = R.destination.split('::');
                var dest_val = destination[0];
                var dest_html = destination[1];
                var destination_values = R.destination_id.split('::');
                var id_val = destination_values[0];
                var id_html = destination_values[1];
                var selector = R.selector;
                var icon_class = R.icon_class;
                if(dest == 'Announcement' || dest == 'Auto Attendant'){
                    var html = '<p><i class="'+icon_class+'"></i>  '+dest_html+': '+id_html+'</p>';
                    var input = dest_val+'-'+id_val+',s,1';
                    $('.destination_view.'+selector).empty().append(html);
                    $("#"+selector).val(input);
                }

                if(dest == 'Department' || dest == 'Extension' || dest == 'Time Condition' || dest == 'Hang up call'){
                    var html = '<p><i class="'+icon_class+'"></i>  '+dest_html+': '+id_val+'('+id_html+')</p>';
                    var input = dest_val+','+id_val+',1';
                    $('.destination_view.'+selector).empty().append(html);
                    $("#"+selector).val(input);
                }if(dest == 'Hang up call'){
                    var html = '<p><i class="'+icon_class+'"></i>  '+id_html+'</p>';
                    var input = dest_val+','+id_val+',1';
                    $('.destination_view.'+selector).empty().append(html);
                    $("#"+selector).val(input);
                }if(dest == 'Voice Mail'){
                    if(R.vmmessage){
                        var vmmessage = R.vmmessage.split('::');

                        var html = '<p><i class="'+icon_class+'"></i>  Voice Mail - '+vmmessage[1]+' (Ext ' + id_val + ')</p>';
                        var input = dest_val+','+vmmessage[0]+id_val+',1';
                        $('.destination_view.'+selector).empty().append(html);
                        $("#"+selector).val(input);
                    }
                }
            }
            $('#modal-popup').modal('hide');
        }
    });