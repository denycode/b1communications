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

        <div class="row">
            <div class="col-md-12">
                <label for="exampleInputEmail1">Recieve voice mails via email only</label>
                <div class="m-b-30">
                    <input type="checkbox" name="delete" class="js-switch" @if(isset($voicemail->delete) && $voicemail->delete == 'yes')  checked @endif data-color="#009efb" data-size="small" data-switchery="true">
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions pull-right">
        <input type="hidden" value="{!! isset($extension->extension) ? $extension->extension : '' !!}" name="extension"/>
        <input type="hidden" value="{!! isset($voicemail->pager) ? $voicemail->pager : '' !!}" name="pager"/>

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
        $('.voice-mail').is(':checked') ?
            $('.depend-vm').fadeIn('slow') :
            $('.depend-vm').fadeOut('slow');

        $('.voice-mail').on('change',function () {
            $(this).is(':checked') ?
                $('.depend-vm').fadeIn('slow') :
                $('.depend-vm').fadeOut('slow');
        });
        $('.voice-mail-top').is(':checked') ?
             $('.inner_sec').fadeIn('slow'):
            $('.inner_sec').fadeOut('slow');

        $('.voice-mail-top').on('change',function () {
            if($(this).is(':checked')){

                var data = {
                    'title' : 'Are you sure ?',
                    'text' : '',
                    'butttontext' : '',
                    'cbutttonflag' : true
                };

                ACFn.display_confirm_message(data,cb,{
                    obj : $(this)
                });
                $(this).attr('checked',false)
            }
            else
                $('.inner_sec').fadeOut('slow');
        });
    })

    function cb(params) {
        params.obj.attr('checked',true);
        $('.inner_sec').fadeIn('slow');
    }

    function nc(params) { alert('ithe');
        params.obj.attr('checked',false);
    }

</script>
