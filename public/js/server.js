////check connection
     $("body").on("click", ".check_connecton", function (e) {
        e.preventDefault();
        var action = $(this).data('action');
        if( action == 'mysql_conn'){
            var data_arr = {
                host : $('#host').val(),
                username : $('#username').val(),
                password : $('#password').val(),
                dbname : $('#dbname').val(),
                _token : $('[name="_token"]').val(),
                action : action,
            };
        }else if( action == 'app_conn'){
            var data_arr = {
                app_name : $('#app_name').val(),
                client_id : $('#client_id').val(),
                client_secret : $('#client_secret').val(),
                _token : $('[name="_token"]').val(),
                action : action,
            };
        }
       

            $.ajax({
                url: baseURL +'/server/checkconnection',
                method: 'get',
                data: data_arr, 
                beforeSend: function () {
                    NProgress.start();
                },
                success: function (data) {
                    var R = ACFn.json_parse(data);
                    if( data['success'] == true ){
                    
                        ACFn.loadModalLayout($('body'),R)
                    }
                    if( data['success'] == false ){
                    
                        $('[data-action="'+action+'"]').removeClass('btn-secondary').removeClass('btn-success')
                            .addClass('btn-danger')
                            .html('<i class="fa fa-times"></i> Not Connect');
                    }

                },
                error: function (jqXHR, status, error) {
                
                    if (
                        jqXHR.status === 0 ||
                        jqXHR.status == 404 ||
                        jqXHR.status == 500 ||
                        exception === 'parsererror' ||
                        exception === 'timeout' ||
                        exception === 'abort'
                        )
                        {
                            $('[data-action="'+action+'"]').removeClass('btn-secondary').removeClass('btn-success')
                            .addClass('btn-danger')
                            .html('<i class="fa fa-times"></i> Not Connect');
                        }
                    
                    // alert("Server Error! Try again later");
                },
                complete: function () {
                    //$("body").removeClass("ajax-loading");
                    NProgress.done(true);
                }
            });
        
        
        // console.log(F.data("confirm"));

    });
    $("body").on("keyup", ".ajax-Form input", function (e) {
        if($('.check_connecton').hasClass('btn-danger')){
           var action = $('.btn-danger').data('action');
          $('.check_connecton[data-action="'+action+'"]').removeClass('btn-danger').addClass('btn-secondary').html('Check connection');
        }
    });


    ////check validation
    $("body").on("click",".check_validation",function(e){
        var action = $(this).data('action');
        var nextaction = $(this).data('nextaction');
        if(action == 'general'){
            var data_arr = {
                name : $('#name').val(),
                description : $('#description').val(),
                action : action,
            };
        }else if(action == 'mysqlconn'){
            var data_arr = {
                host : $('#host').val(),
                username : $('#username').val(),
                password : $('#password').val(),
                dbname : $('#dbname').val(),
                action : action,
            };
        }

        ACFn.sendAjax(baseURL +'/server/checkvalidation','POST',data_arr,$('#server_form'));
        ACFn.ajax_server_steps = function (F , R){
            console.log(R);
            $('[data-tabid ='+nextaction).trigger('click');
        }
    });

