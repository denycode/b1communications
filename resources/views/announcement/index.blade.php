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
                @include('common.header-text',['sectiontext' => 'Announcements List'])
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">View Announcements</li>
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
                    <div class="card-body pb-0">
                        <div class="filter-open-close">
                            <div class="filter collapse" id="collapseFilters" aria-expanded="false">
                                <form id="filter_form" class="filter-scroll-js filter-inner respo-filter-myticket" data-title="tickets#24#536" autocomplete="off"></form>
                            </div>
                        </div>

                        <div class="row mb-2" style="border-bottom: 1px solid #dee2e6;">
                            <div class="col-md-8">
                            <ul
                                    class="nav nav-tabs customtab2 mt-2 border-bottom-0 font-14 tab-hash tab-ajax"
                                    role="tablist"
                                    data-href="announcement/get"
                                    data-method="get"
                                    data-default-tab="tab_20"
                            >

                                <li class="nav-item" style="border-bottom: 1px solid #dee2e6;display: none;" >
                                    <a class="nav-link" data-toggle="tab" data-tabid="20" href="#tab_20" role="tab" aria-selected="false">
                                    </a>
                                </li>
                            </ul>
                            </div>
                            <div class="col-md-4">
                                <div class="btn-toolbar pull-right" role="toolbar" aria-label="Toolbar with button groups">
                                    <div class="input-group">
                                        <div class="all-pagination pt-1" style="vertical-align: middle;margin: 10px;"></div>
                                        <div class="c-btn" style="display: none;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Tab panes -->
                    <div class="tab-content br-n pn">
                        <div class="tab-pane customtab active" id="tab_20" role="tabpanel"></div>
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
