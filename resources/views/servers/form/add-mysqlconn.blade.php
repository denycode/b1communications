<?php
$n = isset($sServer) ? false : true;

?>

    {!! csrf_field() !!}
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInputEmail1">Host</label>
                <input type="text" class="form-control" id="host" aria-describedby="emailHelp"
                       name="host"  placeholder=""
                       value="{!! !$n && isset($sServer->host) ? $sServer->host : '' !!}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInputEmail1">User Name</label>
                <input type="text" class="form-control" id="username"
                       aria-describedby="emailHelp"
                       name="username"
                       value="{!! !$n && isset($sServer->username) ? $sServer->username : '' !!}">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInputEmail1">DataBase Name</label>
                 <input type="text" class="form-control" id="dbname"
                       aria-describedby="emailHelp"
                       name="dbname"
                       value="{!! !$n && isset($sServer->dbname) ? $sServer->dbname : '' !!}">
            </div>

        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInputEmail1">Password</label>
                 <input type="text" class="form-control" id="password"
                       aria-describedby="emailHelp"
                       name="password"
                       value="{!! !$n && isset($sServer->password) ? $sServer->password : '' !!}">
            </div>
        </div>
    </div>

    <div class="form-actions pull-right">
        <input type="hidden" class="form-control" id="server" aria-describedby="emailHelp"
                       name="id" readonly placeholder=""
                       value="{!! !$n && isset($sServer->id) ?  Crypt::encrypt($sServer->id)  : Crypt::encrypt(0) !!}">
        <input type="hidden" class="form-control" id="action" aria-describedby="emailHelp"
                       name="action" readonly placeholder=""
                       value="mysqlconn">
        <button type="button" data-action="mysql_conn" class="btn waves-effect waves-light ajax-Link check_connecton btn-secondary" >
                                Check connection
                            </button>
         <?= !$n ? '<button type="submit" class="btn waves-effect waves-light btn-success">Update</button>' : '<button data-nextaction="apiconn" data-action="mysqlconn" type="button" class="btn waves-effect waves-light btn-success check_validation">Next</button>' ?>
        <a
                href="{!! route('server.index') !!}"
                type="button"
                class="btn waves-effect waves-light btn-secondary"
        >
            Cancel
        </a>
    </div>


