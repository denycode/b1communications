<?php
$n = isset($smartfollow) ? false : true;
?>
<style>
    .external-ext-list{
        padding: 6px 16px 4px 45px !important;
        color: #888d8d !important;
    }

</style>
<form class="ajax-Form" enctype="multipart/form-data" method="post" action="{!! URL::to('/smartfollow/update') !!}">
    {!! csrf_field() !!}
    <div class="row">
        <div class="col-md-12">
            <label for="exampleInputEmail1">Enable Section</label>
            <div class="m-b-30"><!--todo : still in pending -->
                <input type="checkbox" class="js-switch smart-follow" checked data-color="#009efb" data-size="small" data-switchery="true">
            </div>
        </div>
    </div>

    <div class="row depend-sf">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">Ring main extension first for</label>
                <select name="pre_ring" class="form-control">
                    @for($s = 0; $s <= 60; $s++)
                        <option
                                @if($smartfollow->pre_ring == $s) selected @endif
                                value="{!! $s !!}"
                        >
                            {!! $s !!}
                        </option>
                    @endfor
                </select>
            </div>
        </div>
    </div>

    <div class="row depend-sf">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">Ring other extensions for</label>
                <select name="grptime" class="form-control">
                    @for($s = 0; $s <= 60; $s++)
                        <option
                                @if($smartfollow->grptime == $s) selected @endif
                                value="{!! $s !!}"
                        >
                            {!! $s !!}
                        </option>
                    @endfor
                </select>
            </div>
        </div>
    </div>

    <div class="row depend-sf">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">Ring Type</label>
                <select name="strategy" class="form-control">
                    @foreach($sStrategies as $key => $sStrategy)
                        <option
                                @if($smartfollow->strategy == $key) selected @endif
                                value="{!! $key !!}"
                        >
                            {!! $sStrategy !!}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    @php
        $lists = explode('-',$smartfollow->grplist);
        $internalExtensions = $externalExtensions = [];
        foreach ($lists as $list){
           if (strpos($list, '#') !== false) {  //for External numbers
                 $list = str_replace( '#', '', $list);
                array_push($externalExtensions,$list);
           }else{  //for Internal numbers
                array_push($internalExtensions,$list);
           }
        }

        $ids_ordered = implode(',', $internalExtensions);
        if(!empty($ids_ordered)){
            $connection = \App\Helpers\DatabaseConnection::setConnection(Auth::user()->organization->server);
            $eExtensionLists = $connection->table('users')
            ->whereIn('extension',$lists)
            ->orderByRaw(DB::raw("FIELD(extension, $ids_ordered)"))
            ->get(['extension','name']);
        }

    @endphp
    <div class="row depend-sf">
        <div class="col-md-12">
            <div class="form-group" id="sortableParent">

                <label for="exampleInputEmail1">
                    Extensions to ring &nbsp;&nbsp;
                    <button
                            type="button"
                            class="btn waves-effect waves-light btn-sm btn-info ajax-Link"
                            data-href="{!! URL::to('/common/getextensionslist?list='.implode('-',$internalExtensions)) !!}"
                    >
                        Add Extension
                    </button>
                    &nbsp;&nbsp;
                    <button
                            type="button"
                            class="btn waves-effect waves-light btn-sm btn-info ajax-Link"
                            data-href="{!! URL::to('/common/addexternalextension') !!}"
                    >
                        Add External Number
                    </button>
                </label>

                <div class="dd myadmin-dd-empty js-nestable" id="nestable-menu" style="max-width: 100% !important;">
                    <ol class="dd-list">
                        @if(isset($eExtensionLists))
                            @foreach($eExtensionLists as $eExtensionList)
                                <li class="dd-item" data-id="{!! trim($eExtensionList->extension) !!}" data-type="internal" data-showas="{!! $eExtensionList->extension !!} - {!! $eExtensionList->name !!}">
                                    <div class="dd-handle dd3-handle"></div>
                                    <div class="dd3-content">
                                        {!! $eExtensionList->extension !!} - {!! $eExtensionList->name !!}
                                        <a
                                                href="javascript:void(0);"
                                                class="btn waves-effect waves-light btn-sm btn-danger pull-right"
                                                onclick="removeExtensionTemp('{!! $eExtensionList->extension !!}','list')">
                                            Delete
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        @endif

                        @foreach($externalExtensions as $externalExtension)
                            <li class="dd-item" data-id="{!! trim($externalExtension) !!}" data-type="external" data-showas="{!! \App\Helpers\Helper::format_phonenumber($externalExtension) !!} (External)">
                                <div class="dd-handle dd3-handle"></div>
                                <div class="dd3-content">
                                    {!! \App\Helpers\Helper::format_phonenumber($externalExtension) !!} (External)
                                    <a
                                            href="javascript:void(0);"
                                            class="btn waves-effect waves-light btn-sm btn-danger pull-right"
                                            onclick="removeExtensionTemp('{!! $externalExtension !!}','list_external')">
                                        Delete
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    </ol>
                </div>

                <div class="input-group mb-3">
                    <input type="hidden"
                           id="list"
                           name="grplist"
                           class="form-control"
                    />
                </div>
            </div>
        </div>
    </div>

    <div class="row depend-sf">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">CID Prefix</label>
                <input type="text" class="form-control" id="grppre" aria-describedby="emailHelp"
                       name="grppre" placeholder=""
                       value="{!! isset($smartfollow->grppre) ? $smartfollow->grppre : '' !!}">
            </div>
        </div>
    </div>

    <div class="form-actions pull-right depend-sf">
        <input type="hidden" name="grpnum" value="{!! $smartfollow->grpnum !!}">
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
        $('.smart-follow').is(':checked') ?
            $('.depend-sf').fadeIn('slow') :
            $('.depend-sf').fadeOut('slow');

        $('.smart-follow').on('change',function () {
            $(this).is(':checked') ?
                $('.depend-sf').fadeIn('slow') :
                $('.depend-sf').fadeOut('slow');
        });
    })

</script>
