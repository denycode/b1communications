<?php
$n = isset($voicemail) ? false : true;
?>
<form class="ajax-Form" enctype="multipart/form-data" method="post" action="{!! URL::to('/voicemail/update') !!}">
    {!! csrf_field() !!}
    <div class="row">
        <div class="col-md-12">
            <label for="exampleInputEmail1">Voice Mail</label>
            <div class="m-b-30">
                <input type="checkbox" name="status" class="js-switch voice-mail-top" @if(isset($voicemail->status) && $voicemail->status == 1) checked @endif data-color="#009efb" data-size="small" data-switchery="true">
            </div>
        </div>
    </div>
    <div class="inner_sec">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleInputEmail1">Password</label>
                    <input type="text" class="form-control" id="password" aria-describedby="emailHelp"
                           name="password" placeholder=""
                           value="{!! isset($voicemail->password) ? $voicemail->password : (isset($extension->extension) ? $extension->extension : '') !!}">

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <label for="exampleInputEmail1">Voice Mail to Email</label>
                <div class="m-b-30">
                    <input type="checkbox" name="attach" class="js-switch voice-mail" @if(isset($voicemail->attach) && $voicemail->attach == 'yes')  checked @endif data-color="#009efb" data-size="small" data-switchery="true">
                </div>
            </div>
        </div>

        <div class="row depend-vm" style="@if(isset($voicemail->attach) && $voicemail->attach == 'no') display: none; @endif" >
            <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email Address</label>
                    <input type="text" class="form-control" id="email" aria-describedby="emailHelp"
                           name="email" placeholder=""
                           value="{!! isset($voicemail->email) ? $voicemail->email : '' !!}">
                </div>
            </div>
        </div>

        <div class="row delete-vm">
            <div class="col-md-12 ">
                <label for="exampleInputEmail1">Recieve voice mails via email only</label>
                <div class="m-b-30">
                    <input type="checkbox" name="delete" class="js-switch" @if(isset($voicemail->delete) && $voicemail->delete == 'yes')  checked @endif data-color="#009efb" data-size="small" data-switchery="true">
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions pull-right">
        <input type="hidden" id="extension_n" value="{!! isset($extension->extension) ? $extension->extension : '' !!}" name="extension"/>
        <input type="hidden" value="{!! isset($voicemail->pager) !!}" name="pager"/>
        <button type="button" class="btn waves-effect btn-success waves-light send_mail btn-secondary">Send Welcome Email</button>
        <button type="submit" class="btn waves-effect waves-light btn-success">
            <?= !$n ? 'Update' : 'Add' ?></button>
        <a
                href="{!! route('extension.index') !!}"
                type="button"
                class="btn waves-effect waves-light btn-secondary"
        >
            Cancel
        </a>
    </div>
</form>

<script type="application/javascript">
    $(document).ready(function () {
        if($('.voice-mail').is(':checked')) {
            $('.depend-vm').fadeIn('slow');
        }else{
            $('.depend-vm').fadeOut('slow');
            $('.send_mail').fadeOut('slow');
        }
        $('.voice-mail').on('change',function (event) {
            if($(this).is(':checked')) {
                $('.depend-vm').fadeIn('slow');
                $('.delete-vm').fadeIn('slow');
                $('.send_mail').fadeIn('slow');
            }else{
                $('.send_mail').fadeOut('slow');
                $('.depend-vm').fadeOut('slow');
                $('.delete-vm').fadeOut('slow');
                 if($('.js-switch[name="delete"]').is(':checked')) {
                    $('.js-switch[name="delete"]').trigger('click');

                 }
            }
            event.preventDefault();
        });
        $('.voice-mail-top').is(':checked') ?
             $('.inner_sec').fadeIn('slow'):
            $('.inner_sec').fadeOut('slow');

        $('.voice-mail-top').on('change',function () {
            if(!$(this).is(':checked')){

                var data = {
                    'title' : 'Are you sure ?',
                    'text' : '',
                    'butttontext' : '',
                    'cbutttonflag' : true
                };

                ACFn.display_confirm_message(data,cb,{
                    obj : $(this)
                });
                $('.swal2-actions button').click(function(){
                    if($(this).text() == 'Cancel'){
                         $('.voice-mail-top').trigger('click');
                    }
                });
                $(this).attr('checked',false)

            }
            else
                $('.inner_sec').fadeIn('slow');
        });

        /////Send mail
        $("body").on("click", ".send_mail", function (e) {
            var data_arr = {
                extension : $('#extension_n').val(),
                password : $('#password').val(),
                email : $('#email').val(),
            };
            e.preventDefault();

            ACFn.sendAjax('{{URL::to('/')}}/extension/ExtensionSendMail','GET',data_arr);
                /*$.ajax({
                    url: "{{URL::to('/extension/ExtensionSendMail')}}",
                    method: 'get',
                    data: data_arr,
                    beforeSend: function () {
                        NProgress.start();
                    },
                    success: function (data) {
                        var R = ACFn.json_parse(data);
                        if( data['success'] == true ){
                             ACFn.display_message(
                                "Emial Send Succefully.",
                                "Try Again Later",
                                "success",5000);

                        }
                        if( data['success'] == false ){

                        }
                    }
                });*/


            // console.log(F.data("confirm"));

        });
    });

    function cb(params) {

        params.obj.attr('checked',false);
        $('.inner_sec').fadeOut('slow');

    }

    function nc(params) { alert('ithe');
        params.obj.attr('checked',false);
    }

</script>
