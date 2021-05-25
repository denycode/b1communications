<?php
$n = isset($sServer) ? false : true;

?>

    {!! csrf_field() !!}
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInputEmail1">Application Name</label>
                <input type="text" class="form-control"
                       aria-describedby="emailHelp"
                       name="app_name"
                       value="{!! !$n && isset($sServer->app_name) ? $sServer->app_name : '' !!}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInputEmail1">Client ID</label>
                <input type="text" class="form-control" id="client_id"
                       aria-describedby="emailHelp"
                       name="client_id"
                       value="{!! !$n && isset($sServer->client_id) ? $sServer->client_id : '' !!}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInputEmail1">Client Secret</label>
                <input type="text" class="form-control" id="client_secret"
                       aria-describedby="emailHelp"
                       name="client_secret"
                       value="{!! !$n && isset($sServer->client_secret) ? $sServer->client_secret : '' !!}">
            </div>
        </div>
        
    </div>

    <div class="form-actions pull-right">
        <input type="hidden" class="form-control" id="server" aria-describedby="emailHelp"
                       name="id" readonly placeholder=""
                       value="{!! !$n && isset($sServer->id) ?  Crypt::encrypt($sServer->id)  : Crypt::encrypt(0) !!}">
        <input type="hidden" class="form-control" id="action" aria-describedby="emailHelp"
                       name="action" readonly placeholder=""
                       value="apiconn">
        <button type="button" data-action="app_conn" class="btn waves-effect waves-light  ajax-Link check_connecton btn-secondary" >
                                Check App Connection
                            </button>
        <button type="submit" class="btn waves-effect waves-light btn-success">
            <?= !$n ? 'Update' : 'Add' ?></button>
        <a
                href="{!! route('server.index') !!}"
                type="button"
                class="btn waves-effect waves-light btn-secondary"
        >
            Cancel
        </a>
    </div>


