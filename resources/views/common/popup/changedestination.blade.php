<form class="ajax-Form" enctype="multipart/form-data" method="post" action="{!! URL::to('/common/getpestinationparams') !!}">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <label for="exampleInputEmail1">Select Destination</label>
            <div class="m-b-30">
                <select name="destination" class="form-control" id="change_destination">
                    <option value="">Select</option>
                    @foreach(\App\Http\Controllers\Controller::Destination as $destKey => $destination)
                        <option value="{{ $destKey }}::{{ $destination }}">{{ $destination }}</option>
                    @endforeach
                </select>
                <input type="hidden" name="selector" class="selector" value="{{ $attr }}"/>
            </div>
        </div>
    </div>
    <div class="append_dest"></div>

    <div class="form-actions pull-right depend">
        <button type="submit" class="btn waves-effect waves-light btn-success">
            Add
        </button>
        <button type="button" class="btn waves-effect waves-light btn-secondary" data-dismiss="modal">
            Cancel
        </button>
    </div>
</form>
