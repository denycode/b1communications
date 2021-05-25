<?php
$n = isset($sServer) ? false : true;

?>

    {!! csrf_field() !!}
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" class="form-control" id="name" aria-describedby="emailHelp"
                       name="name"  placeholder=""
                       value="{!! !$n && isset($sServer->name) ? $sServer->name : '' !!}">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">Description</label>
                <textarea name="description" id="description" rows="6" class="form-control">{!! !$n && isset($sServer->description) ? $sServer->description : '' !!}</textarea>
            </div>
        </div>
    </div>
    <div class="form-actions pull-right">
        <input type="hidden" class="form-control" id="server" aria-describedby="emailHelp"
                       name="id" readonly placeholder=""
                       value="{!! !$n && isset($sServer->id) ?  Crypt::encrypt($sServer->id)  : Crypt::encrypt(0) !!}">
        <input type="hidden" class="form-control" id="action" aria-describedby="emailHelp"
                       name="action" readonly placeholder=""
                       value="general">
        <?= !$n ? '<button type="submit" class="btn waves-effect waves-light btn-success">Update</button>' : '<button data-nextaction="mysqlconn" data-action="general" type="button" class="btn waves-effect waves-light btn-success check_validation">Next</button>' ?>

        <a
                href="{!! route('server.index') !!}"
                type="button"
                class="btn waves-effect waves-light btn-secondary"
        >
            Cancel
        </a>
    </div>


