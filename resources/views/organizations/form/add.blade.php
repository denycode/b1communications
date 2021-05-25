<?php
$n = isset($organization) ? false : true;
$department_range_from = $department_range_to = '';
if(!$n){
    $department_range =  explode('-',$organization->department_range);
    $department_range_from = $department_range[0];
    $department_range_to = $department_range[1];
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
                @include('common.header-text',['sectiontext' => 'Organization'])
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">{!! $title !!}</li>
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
                                <a
                                        href="{!! route('organization.index') !!}"
                                        type="button"
                                        class="btn waves-effect waves-light btn-rounded btn-sm btn-info pull-right">
                                    <i class="ti-arrow-left"></i>
                                    &nbsp; Back
                                </a>
                            </div>
                        </div>
                        <div class="form-body mt-3">
                            <form class="ajax-Form" enctype="multipart/form-data" method="post" action="{!! URL::to('/organization/update') !!}">
                                {!! csrf_field() !!}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">
                                                Organization Name

                                            </label>
                                            <a
                                                    href="javascript:void(0);"
                                                    data-toggle="tooltip"
                                                    class="ti-t-tooltip"
                                                    data-html="true"
                                                    title="{!! \App\Helpers\Helper::showTooltip('organization','organization_name') !!}"
                                            >
                                                <i class="fas fa-question-circle"></i>
                                            </a>

                                            <input
                                                    type="text"
                                                    class="form-control"
                                                    id="organization_name"
                                                    aria-describedby="emailHelp"
                                                    name="organization_name"
                                                    placeholder=""
                                                   value="{!! isset($organization->organization_name) ?
                                                   $organization->organization_name :
                                                   '' !!}">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Server ID</label>
                                            @if($n)
                                                @php $servers = \App\Helpers\DatabaseConnection::getServers(); @endphp
                                                <select
                                                        name="server_ID"
                                                        class="form-control"
                                                >
                                                    <option value="">Select</option>
                                                    @foreach($servers as $server)
                                                        <option
                                                                value="{!! $server->id !!}"
                                                        >
                                                            {!! $server->host !!}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <input
                                                        type="text"
                                                        class="form-control"
                                                        id="server_ID"
                                                        aria-describedby="emailHelp"
                                                        name="server_ID"
                                                        readonly
                                                        value="{!! isset($organization->server->host) ?
                                                   $organization->server->host :
                                                   '' !!}">
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">
                                                Department Range From
                                            </label>
                                            <a
                                                    href="javascript:void(0);"
                                                    data-toggle="tooltip"
                                                    class="ti-t-tooltip"
                                                    data-html="true"
                                                    title="{!! \App\Helpers\Helper::showTooltip('organization','organization_name') !!}"
                                            >
                                                <i class="fas fa-question-circle"></i>
                                            </a>

                                            <input
                                                    type="text"
                                                    class="form-control"
                                                    id="department_range_from"
                                                    aria-describedby="emailHelp"
                                                    name="department_range_from"
                                                    @if(!$n) readonly @endif
                                                    placeholder=""
                                                    value="{!! $department_range_from !!}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">
                                                Department Range To
                                            </label>
                                            <a
                                                    href="javascript:void(0);"
                                                    data-toggle="tooltip"
                                                    class="ti-t-tooltip"
                                                    data-html="true"
                                                    title="{!! \App\Helpers\Helper::showTooltip('organization','organization_name') !!}"
                                            >
                                                <i class="fas fa-question-circle"></i>
                                            </a>

                                            <input
                                                    type="text"
                                                    class="form-control"
                                                    id="department_range_to"
                                                    aria-describedby="emailHelp"
                                                    name="department_range_to"
                                                    @if(!$n) readonly @endif
                                                    placeholder=""
                                                    value="{!! $department_range_to !!}">
                                        </div>
                                    </div>
                                </div>
                                @if(!$n)
                                    @include('organizations.form.tabs')
                                @endif

                                <div class="form-actions pull-right">
                                    <input
                                            type="hidden"
                                            name="enc_id"
                                            value="<?= !$n ?
                                                Crypt::encrypt($organization->id) :
                                                Crypt::encrypt(0) ?>">
                                    <button
                                            type="submit"
                                            class="btn waves-effect waves-light btn-success"
                                    >
                                        <?= !$n ? 'Update' : 'Add' ?>
                                    </button>
                                    <a
                                            href="{!! route('organization.index') !!}"
                                            type="button"
                                            class="btn waves-effect waves-light btn-secondary"
                                    >
                                        Cancel
                                    </a>
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
@stop



