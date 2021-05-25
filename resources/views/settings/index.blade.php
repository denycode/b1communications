@extends('layouts.docker')
@section('content')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Settings</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Settings</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="filter-open-close">
                            <div class="filter collapse" id="collapseFilters" aria-expanded="false">
                                <form id="filter_form" class="filter-scroll-js filter-inner respo-filter-myticket" data-title="tickets#24#536" autocomplete="off">


                                </form>
                            </div>
                        </div>
                        <!-- Nav tabs -->
                        <div class="">

                            <ul class="nav nav-tabs tabs-vertical tab-style tab-hash tab-ajax"
                                role="tablist"
                                data-href="settings/get"
                                data-method="post"
                                data-default-tab="dummy">

                                @if(\App\Helpers\Helper::CheckPermission('settings','users','view') || Auth::user()->IsAdmin)
                                    <li class="nav-item">
                                        <a href="#tab_{{\App\Model\Setting::USERS}}" class="nav-link" data-tabid="{{\App\Model\Setting::USERS}}" data-toggle="tab" aria-expanded="true"><span class="hidden-sm-up"><i class="fas fa-users"></i></span> <span class="hidden-xs-down">Users</span></a>
                                    </li>
                                @endif

                                @if(\App\Helpers\Helper::CheckPermission('settings','profile','view') || Auth::user()->IsAdmin)
                                    <li class="nav-item">
                                        <a href="#tab_{{\App\Model\Setting::PROFILE_MASTER}}" class="nav-link" data-tabid="{{\App\Model\Setting::PROFILE_MASTER}}" data-toggle="tab" aria-expanded="true"><span class="hidden-sm-up"><i class="mdi mdi-account"></i></span> <span class="hidden-xs-down">Profiles</span></a>
                                    </li>
                                @endif

                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content br-n pn">
                                <div class="tab-pane active" id="tab_{{\App\Model\Setting::USERS}}" role="tabpanel"></div>
                                <div class="tab-pane" id="tab_{{\App\Model\Setting::PROFILE_MASTER}}" role="tabpanel"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.docker-rightsidebar')
    </div>
@stop
