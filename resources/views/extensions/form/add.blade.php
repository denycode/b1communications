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
                @include('common.header-text',[
                                            'sectiontext' => 'Extension '.$extension->extension.' ('.$extension->name.')'
                                           
                                            ])
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Edit Extensions</li>
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
                        <div class="form-body">
                            <div class="row border-bottom">
                                <div class="col-md-10">
                                    <ul class="nav nav-tabs customtab2  border-bottom-0 font-14"role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" data-tabid="extension" href="#extension" role="tab" aria-selected="false">
                                                Extension
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" data-tabid="smartfollow" href="#smartfollow" role="tab" aria-selected="false">
                                                Smart Follow
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" data-tabid="voicemail" href="#voicemail" role="tab" aria-selected="false">
                                                VoiceMail
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-2">
                                    <a
                                            href="{{route('extension.index')}}"
                                            type="button"
                                            class="btn waves-effect waves-light btn-rounded btn-sm btn-info pull-right">
                                        <i class="ti-arrow-left"></i>
                                        &nbsp; Back
                                    </a>
                                </div>
                            </div>

                            <!-- Tab panes -->
                            <div class="tab-content br-n pn mt-3">
                                <div class="tab-pane customtab active" id="extension" role="tabpanel">
                                    @include('extensions.form.add-extension')
                                </div>
                                <div class="tab-pane customtab" id="smartfollow" role="tabpanel">
                                    @include('extensions.form.add-smart-follow')
                                </div>
                                <div class="tab-pane customtab" id="voicemail" role="tabpanel">
                                    @include('extensions.form.add-voicemail')
                                </div>
                            </div>
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

