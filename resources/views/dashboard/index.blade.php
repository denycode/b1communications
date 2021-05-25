@extends('layouts.docker')
@section('content')
    <div class="container-fluid">

    <!-- ============================================================== -->
    <!-- Sales Chart and browser state-->
    <!-- ============================================================== -->
    <div class="row">
        <!-- Column -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h5 class="card-title m-b-40">SALES IN 2018</h5>
                            <p>Lorem ipsum dolor sit amet, ectetur adipiscing elit. viverra tellus. ipsumdolorsitda amet, ectetur adipiscing elit.</p>
                            <p>Ectetur adipiscing elit. viverra tellus.ipsum dolor sit amet, dag adg ecteturadipiscingda elitdglj. vadghiverra tellus.</p>
                        </div>
                        <div class="col-md-8 col-sm-6 col-xs-12">
                            <div id="morris-area-chart" style="height:250px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
    </div>
    <!-- ============================================================== -->
    <!-- End Sales Chart -->
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
