<?php
$n = isset($autoAttendant) ? false : true;

?>
<form class="ajax-Form" enctype="multipart/form-data" method="post" action="{!! URL::to('/autoattendants/update') !!}">
    {!! csrf_field() !!}
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" class="form-control" id="name" aria-describedby="emailHelp"
                       name="name" placeholder=""
                       value="{!! isset($autoAttendant->name) ? $autoAttendant->name : '' !!}">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">Description</label>
                <input type="text" class="form-control"
                       aria-describedby="emailHelp"
                       name="description"
                       value="{!! !empty($autoAttendant->description) ? $autoAttendant->description : '' !!}">
            </div>
        </div>
    </div>

    
   

    <div class="form-actions pull-right">
        <input type="hidden" name="id" value="{!! !$n && isset($autoAttendant->id) ?  Crypt::encrypt($autoAttendant->id)  : Crypt::encrypt(0) !!}"/>
        <button type="submit" class="btn waves-effect waves-light btn-success">
            <?= !$n ? 'Update' : 'Add' ?></button>
        <a
                href="{!! route('autoattendants.index') !!}"
                type="button"   
                class="btn waves-effect waves-light btn-secondary"
        >
            Cancel
        </a>
    </div>

</form>
