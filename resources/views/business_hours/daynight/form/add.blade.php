<?php
$n = isset($data) ? false : true;
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
                @include('common.header-text',['sectiontext' => 'Day & Night Buttons'])
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">{!! $pageTitle !!}</li>
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
                                        href="{!! route('business_hours.index') !!}#tab=tab_22"
                                        type="button"
                                        class="btn waves-effect waves-light btn-rounded btn-sm btn-info pull-right">
                                    <i class="ti-arrow-left"></i>
                                    &nbsp; Back
                                </a>
                            </div>
                        </div>
                        <div class="form-body mt-3">
                            <form class="ajax-Form" enctype="multipart/form-data" method="post" action="{!! URL::to('/businesshours/daynightupdate') !!}">
                                {!! csrf_field() !!}

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Description</label>
                                            <input type="text" class="form-control"
                                                   aria-describedby="emailHelp"
                                                   name="dmode[fc_description]"
                                                   value="{!! !empty($data['fc_description']) ? $data['fc_description'] : '' !!}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group" style="float: left;width: 100%;">
                                            <label for="exampleInputEmail1">Day</label>
                                            <button
                                                    type="button"
                                                    class="btn waves-effect waves-light btn-sm btn-info ajax-Link"
                                                    data-href="{!! URL::to('/common/changedestination') !!}/{!! Crypt::encrypt('day') !!}"
                                            >
                                                Change
                                            </button>
                                            <div class="destination_view  day form-control" style="float:left;">
                                                {!! \App\Helpers\Destination::getdestination($data['day']); !!}
                                            </div>
                                            <input type="hidden" class="form-control"
                                                   aria-describedby="emailHelp" id="day"
                                                   name="dmode[day]"
                                                   value="{!! !empty($data['day']) ? $data['day'] : '' !!}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group" style="float: left;width: 100%;">
                                            <label for="exampleInputEmail1">Night</label>
                                            <button
                                                    type="button"
                                                    class="btn waves-effect waves-light btn-sm btn-info ajax-Link"
                                                    data-href="{!! URL::to('/common/changedestination') !!}/{!! Crypt::encrypt('night') !!}"
                                            >
                                                Change
                                            </button>
                                            <div class="destination_view  night form-control" style="float:left;">
                                                {!! \App\Helpers\Destination::getdestination($data['night']); !!}
                                            </div>
                                            <input type="hidden" class="form-control"
                                                   aria-describedby="emailHelp" id="night"
                                                   name="dmode[night]"
                                                   value="{!! !empty($data['night']) ? $data['night'] : '' !!}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions pull-right">
                                    @if(!$n)
                                        <input type="hidden" name="ext" value="{!! $data['ext'] !!}">
                                        <input type="hidden" name="dmode[day_recording_id]" value="{!! $data['day_recording_id'] !!}">
                                        <input type="hidden" name="dmode[night_recording_id]" value="{!! $data['night_recording_id'] !!}">
                                    @endif
                                    <button type="submit" class="btn waves-effect waves-light btn-success">
                                        <?= !$n ? 'Update' : 'Add' ?></button>
                                    <a
                                            href="{!! route('announcement.index') !!}"
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
    <script>
        var baseURL = '{!! URL::to('/') !!}';
    </script>
    <script src="{!! URL::to('/') !!}/js/destination.js?ver={{time()}}" type="text/javascript"></script>
@stop




