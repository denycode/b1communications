<?php
/**
 * Created by PhpStorm.
 * User: Gurpreet Singh
 * Date: 15-03-2021
 * Time: 01:39 PM
 */
?>
<form class="ajax-Form" enctype="multipart/form-data" method="post" action="{!! URL::to('/organization/unassignedupdate') !!}">
    {!! csrf_field() !!}
    <div class="row">
        <div class="col-md-12">
            <label for="exampleInputEmail1">Users</label>
            <div class="m-b-30">
                <select name="grplist" class="form-control" id="multiselect">
                    <option value="">Select</option>
                    @foreach($uUsers as $uUser)
                        <option
                                value="{{$uUser->id}}::{{$uUser->FullName}}::{{isset($uUser->Organization) ?
                                $uUser->Organization->organization_name :
                                'Unassigned'}}"
                        >
                            {{$uUser->FullName}} ({{isset($uUser->Organization) ? ucwords($uUser->Organization->organization_name) : 'Unassigned'}})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="form-actions pull-right depend">
        <input type="hidden" name="type" value="users">
        <button type="submit" class="btn waves-effect waves-light btn-success">
            Add
        </button>
        <button type="button" class="btn waves-effect waves-light btn-secondary" data-dismiss="modal">
            Cancel
        </button>
    </div>
</form>
<script type="application/javascript">
    /*$(document).ready(function () {
        $("#multiselect").multiselect({
            appendTo: '#modal-popup',
            close: function () {
            },
            header: true, //"Region",
            selectedList: 0, // 0-based index
            nonSelectedText: 'Select Values',
            enableFiltering: true,
            filterBehavior: 'text',
        }).multiselectfilter({label: 'Search'});

        $("#multiselect_ms").attr('style', 'width:100% !important;height: 28px; background-color: white !important;height: calc(1.5em + .5rem + 2px);padding: .25rem .5rem;border-radius: .2rem;background-clip: padding-box;border: 1px solid #e9ecef;font-size: .76563rem;min-height: 38px;');
        $("#multiselect").multiselect('refresh');
    })*/
</script>
