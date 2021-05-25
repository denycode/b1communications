<?php

?>
@extends('layouts.docker')
@section('content')
<div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                @include('common.header-text',['sectiontext' => 'Time Condition Detail'])
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Time Condition Detail</li>
                    </ol>
                </div>
            </div>
        </div>
       	<div class="row">
	        <div class="col-12">
	            <div class="card">
	                <div class="card-body">
	                    <div class="row border-bottom pb-2">
	                        <div class="col-md-12">
	                            <a
	                                    href="{!! route('business_hours.index') !!}#tab=tab_21"
	                                    type="button"
	                                    class="btn waves-effect waves-light btn-rounded btn-sm btn-info pull-right">
	                                <i class="ti-arrow-left"></i>
	                                &nbsp; Back
	                            </a>
	                        </div>
	                    </div>
	                    <div class="form-body mt-3">
							<form class="ajax-Form" enctype="multipart/form-data" method="post" action="{!! URL::to('/businesshours/timeconditionupdate') !!}">
							    {!! csrf_field() !!}
							    <div class="col-md-12">
							    	<div class="row">
								        <div class="col-md-12">
								            <div class="form-group">
								                <label for="exampleInputEmail1">Name</label>
								                <input type="text" class="form-control" id="displayname" aria-describedby="emailHelp"
								                       name="displayname"  placeholder=""
								                       value="{!! isset($timeconditions->displayname) ? $timeconditions->displayname : '' !!}">
								            </div>
								        </div>
								        <div class="col-md-12">
								            <div class="form-group" style="float: left;width: 100%;">
								                <label for="exampleInputEmail1">Open Destination</label>
								                <button
                                                type="button"
                                                class="btn waves-effect waves-light btn-sm btn-info ajax-Link"
                                                data-href="{!! URL::to('/common/changedestination') !!}/{!! Crypt::encrypt('truegoto') !!}"
		                                        >
		                                            Change
		                                        </button>
		                                        <div class="destination_view form-control truegoto" style="float:left;">
		                                            {!! \App\Helpers\Destination::getdestination($timeconditions->truegoto); !!}
		                                        </div>							        
								                <input type="hidden" readonly class="form-control" id="truegoto" aria-describedby="emailHelp"
								                       name="truegoto"  placeholder=""
								                       value="{!! isset($timeconditions->truegoto) ? $timeconditions->truegoto : '' !!}">
								            </div>
								        </div>
								        <div class="col-md-12">
								            <div class="form-group" style="float: left;width: 100%;">
								                <label for="exampleInputEmail1">Closed Destination</label>
								                <button
                                                type="button"
                                                class="btn waves-effect waves-light btn-sm btn-info ajax-Link"
                                                data-href="{!! URL::to('/common/changedestination') !!}/{!! Crypt::encrypt('falsegoto') !!}"
		                                        >
		                                            Change
		                                        </button>
		                                        <div class="destination_view form-control falsegoto" style="float:left;">
		                                            {!! \App\Helpers\Destination::getdestination($timeconditions->falsegoto); !!}
		                                        </div>	
								                <input type="hidden" readonly class="form-control" id="falsegoto" aria-describedby="emailHelp"
								                       name="falsegoto"  placeholder=""
								                       value="{!! isset($timeconditions->falsegoto) ? $timeconditions->falsegoto : '' !!}">
								            </div>
								        </div>
								        <div class="col-md-12">
								            <div class="form-group">
								                <label for="exampleInputEmail1">Description</label>
								                <textarea readonly name="description" id="description" rows="6" class="form-control">{!! isset($timeconditions->description) ? $timeconditions->description : '' !!}</textarea>
								            </div>
								        </div>
								    </div>
							    </div>
								<div class="form-actions pull-right depend">
									<input type="hidden" name="timeconditions_id" value="{!! Crypt::encrypt($timeconditions->timeconditions_id) !!}"/>
									<button type="submit" class="btn waves-effect waves-light btn-success">
										Submit
									</button>
									<button type="button" class="btn waves-effect waves-light btn-secondary" data-dismiss="modal">
										Cancel
									</button>
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





