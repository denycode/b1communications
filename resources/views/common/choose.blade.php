<form class="ajax-Form" enctype="multipart/form-data" method="post" action="{!! URL::to('/common/getextensionslist') !!}">
    {!! csrf_field() !!}
    <div class="row">
        <div class="col-md-12">
            <label for="exampleInputEmail1">Extensions</label>
            <div class="m-b-30">
                <select name="grplist" class="form-control">
                    <option value="">Select</option>
                    @foreach($eExtensions as $eExtension)
                        <option
                                value="{{$eExtension->extension}}::{{$eExtension->name}}"
                        >
                            {{$eExtension->extension}} - {{$eExtension->name}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="form-actions pull-right depend">
        <input type="hidden" name="type" value="internal">
        <button type="submit" class="btn waves-effect waves-light btn-success">
            Add
        </button>
        <button type="button" class="btn waves-effect waves-light btn-secondary" data-dismiss="modal">
            Cancel
        </button>
    </div>
</form>

