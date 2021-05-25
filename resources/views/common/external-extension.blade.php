<form class="ajax-Form" enctype="multipart/form-data" method="post" action="{!! URL::to('/common/getextensionslist') !!}">
    {!! csrf_field() !!}
    <div class="row">
        <div class="col-md-12">
            <label for="exampleInputEmail1">External Extension <small class="text-muted">(XXX) XXX-XXXX</small></label>
            <div class="m-b-30">
                <input type="text" name="grplist" class="form-control phone-inputmask" id="phone-mask" im-insert="true"/>
            </div>
        </div>
    </div>

    <div class="form-actions pull-right depend">
        <input type="hidden" name="type" value="external">
        <button type="submit" class="btn waves-effect waves-light btn-success">
            Add
        </button>
        <button type="button" class="btn waves-effect waves-light btn-secondary" data-dismiss="modal">
            Cancel
        </button>
    </div>
</form>

