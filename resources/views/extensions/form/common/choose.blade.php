<form class="ajax-Form" enctype="multipart/form-data" method="post" action="{!! URL::to('/common/getextensionslist') !!}">
    {!! csrf_field() !!}
    <div class="row">
        <div class="col-md-12">
            <label for="exampleInputEmail1">Extensions</label>
            <div class="m-b-30">
                <select name="grplist" class="form-control chosen-select" multiple>
                    @foreach($eExtensions as $eExtension)
                        <option
                                {!! in_array($eExtension->extension,$lists) ? 'selected' : '' !!}
                                value="{!! $eExtension->extension !!}"
                        >
                            {!! $eExtension->extension !!}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="form-actions pull-right depend">
        <button type="submit" class="btn waves-effect waves-light btn-success">
            Add
        </button>
        <button type="reset" class="btn waves-effect waves-light btn-secondary">
            Cancel
        </button>
    </div>

</form>


