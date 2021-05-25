<?php
$n = isset($department) ? false : true;

if($n && (!Auth::user()->IsAdmin && !Auth::user()->IsCSR)){
    $departmentid = \App\Helpers\Helper::findNextDepartmentID(Auth::user()->organization);
} else if ($n && (Auth::user()->IsAdmin || Auth::user()->IsCSR)){
    $departmentid = \App\Helpers\Helper::findNextDepartmentID(Auth::user()->organization);
    if(!$departmentid){
        $departmentid = true;
    }
}else{
    $departmentid = true;
}
?>

@extends('layouts.docker')
@section('content')
    <?php
    //\App\Library\AssetLib::library('footable.bootstrap','contact-app','footable');
    ?>
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                @include('common.header-text',['sectiontext' => 'Department'])
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">{!! $pagetitle !!}</li>
                    </ol>
                    {{--<button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i
                                class="fa fa-plus-circle"></i> Create New</button>--}}
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row border-bottom pb-2">
                            <div class="col-md-12">
                                @if(!$departmentid)
                                    <small class="text-danger font-14">
                                        Department range exceed
                                    </small>
                                @endif
                                <a
                                        href="{!! route('department.index') !!}"
                                        type="button"
                                        class="btn waves-effect waves-light btn-rounded btn-sm btn-info pull-right">
                                    <i class="ti-arrow-left"></i>
                                    &nbsp; Back
                                </a>
                            </div>
                        </div>
                        <div class="form-body mt-3">
                            <form class="ajax-Form" enctype="multipart/form-data" method="post" action="{!! URL::to('/department/update') !!}">
                                {!! csrf_field() !!}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Department ID</label>

                                            <input type="text"
                                                   class="form-control"
                                                   id="grpnum"
                                                   aria-describedby="emailHelp"
                                                   name="grpnum"
                                                   @if(!$n) readonly @endif
                                                   placeholder=""
                                                   value="{!! !$n && isset($department->grpnum) ? $department->grpnum : ((is_numeric($departmentid)) ? $departmentid : '') !!}"
                                            />
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Description</label>
                                            <input type="text" class="form-control" id="description" aria-describedby="emailHelp"
                                                   name="description" placeholder=""
                                                   value="{!! !$n && isset($department->description) ? $department->description : '' !!}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Mode</label>
                                            <select name="strategy" class="form-control">
                                                @foreach($sStrategies as $key => $sStrategy)
                                                    <option @if(!$n && $key == $department->strategy) selected @endif value="{!! $key !!}">{!! $sStrategy !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Ring Time</label>
                                            <select name="grptime" class="form-control">
                                                @for($s = 2; $s <= 60; $s++)
                                                    <option @if(!$n && $s == $department->grptime) selected @endif value="{!! $s !!}">{!! $s !!}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">CID Prefix</label>
                                            <input type="text" class="form-control" id="grppre" aria-describedby="emailHelp"
                                                   name="grppre" placeholder=""
                                                   value="{!! !$n && isset($department->grppre) ? $department->grppre : '' !!}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group" id="sortableParent">
                                            <label for="exampleInputEmail1">
                                                List &nbsp;&nbsp;
                                                @php
                                                    $grplist = (!$n) ? $department->grplist : '';
                                                @endphp
                                                <button
                                                        type="button"
                                                        class="btn waves-effect waves-light btn-sm btn-info ajax-Link"
                                                        data-href="{!! URL::to('/common/getextensionslist?list='.$grplist) !!}"
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
                                            @php
                                                $internalExtensions = $externalExtensions = [];
                                                if(!$n){
                                                    $lists = explode('-',$grplist);
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
                                                }
                                            @endphp
                                            <div class="dd myadmin-dd-empty js-nestable" id="nestable-menu" style="max-width: 100% !important;">
                                                <ol class="dd-list">
                                                    @if(!$n && isset($eExtensionLists))
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
                                                       data-callback="addnewval"
                                                       value=""
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group" style="float: left;width: 100%;">
                                            <label for="exampleInputEmail1">If no answer send call to</label>
                                            <button
                                                    type="button"
                                                    class="btn waves-effect waves-light btn-sm btn-info ajax-Link"
                                                    data-href="{!! URL::to('/common/changedestination') !!}/{!! Crypt::encrypt('postdest') !!}"
                                            >
                                                Change
                                            </button>
                                            <div class="destination_view  postdest form-control" style="float:left;">
                                                {!! !$n && isset($department->postdest) ?
                                                \App\Helpers\Destination::getdestination($department->postdest) : ''; !!}
                                            </div>
                                            <input type="hidden" class="form-control"
                                                   aria-describedby="emailHelp" id="postdest"
                                                   name="postdest"
                                                   value="{!! isset($department->postdest) ? $department->postdest : '' !!}">
                                        </div>
                                    </div>
                                </div>


                                <div class="form-actions pull-right">
                                    @if($departmentid)
                                    <button type="submit" class="btn waves-effect waves-light btn-success">
                                        <?= !$n ? 'Update' : 'Add' ?></button>
                                    <a
                                            href="{!! route('department.index') !!}"
                                            type="button"
                                            class="btn waves-effect waves-light btn-secondary"
                                    >
                                        Cancel
                                    </a>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right sidebar -->
        <!-- ============================================================== -->
        <!-- .right-sidebar -->
    @include('layouts.docker-rightsidebar')
    <!-- ============================================================== -->
        <!-- End Right sidebar -->
        <!-- ============================================================== -->
    </div>
    <script>
        var baseURL = '{!! URL::to('/') !!}';
    </script>
    <script src="{!! URL::to('/') !!}/js/destination.js?ver={{time()}}" type="text/javascript"></script>
@stop



