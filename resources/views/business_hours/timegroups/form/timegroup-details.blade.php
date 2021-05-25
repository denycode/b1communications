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
                @include('common.header-text',['sectiontext' => 'Time Group'])
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Time Group Detail</li>
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
	                                    href="{!! route('business_hours.index') !!}"
	                                    type="button"
	                                    class="btn waves-effect waves-light btn-rounded btn-sm btn-info pull-right">
	                                <i class="ti-arrow-left"></i>
	                                &nbsp; Back
	                            </a>
	                        </div>
	                    </div>
	                    <div class="form-body mt-3">
							<form class="ajax-Form" enctype="multipart/form-data" method="post" action="{!! URL::to('/businesshours/timegroupsupdate') !!}">
							    {!! csrf_field() !!}
							    <div class="col-md-12">
							    	<div class="row">
							    		<div class="col-md-3">
							    			<div class="form-group">
							    				<label for="exampleInputEmail1">Description</label>
							    			</div>
							    		</div>
								        <div class="col-md-8">
								            <div class="form-group">
								                <input type="text" name="description" class="form-control" id="exampleInputEmail1"
								                       aria-describedby="emailHelp"
								                       placeholder=""
								                       value="{{ isset($timegroups[0]['description']) ? $timegroups[0]['description'] : '' }}"
								                >
								                <input type="hidden" name="timegroupid" class="form-control" 
								                       
								                       value="{{ isset($timegroup_id) ? $timegroup_id : '' }}"
								                >
								            </div>
								        </div>
								    </div>
								        @foreach($timegroups as $rowkey => $timegroup)
											@php $parseTimeDateArr = \App\Helpers\Helper::getDateTime($timegroup['time']); @endphp
												@include('business_hours.timegroups.form.timegroup-details-form')
										@endforeach	
										
													

							    </div>
							     <div class="col-md-12 timegroups_sec"></div>
							    <div class="form-actions pull-left depend">
									<button type="button" class="btn waves-effect waves-light btn-secondary add_new_timegroup" onclick="add_new_timegroup();" data-dismiss="modal">
										Add New
									</button>
								</div>

								<div class="form-actions pull-right depend">
									<input type="hidden" name="type" value="timegroup">
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
    <script type="application/javascript">
	$(document).ready(function(){
		ACFn.ajax_delete_timegroupdetail = function(F, R){
			if(R.success){
				var id = R.timegroupdetail_id;
				$('.timegroup_'+id+'detail').remove();
				$('.timegroup_'+id+'detail').next('hr').remove();
			}

		}; 
		
	});
	function remove_new_time(obj){
		var remove_id = obj.data('remove_id'); 
		$('.'+remove_id).remove();

	}
	function add_new_timegroup(){
		var r_length = $('.timegroups_sec > .row').length;
		$.ajax({
                url: '{!! URL::to("/businesshours/addtimegrouphtml") !!}',
                method: 'get',
                data: { length : r_length}, 
                success: function (data) {
                    var R = ACFn.json_parse(data);
                    if( data['success'] == true ){
						$('.timegroups_sec').append(data['html']);
			        }
                }
            });
	}
</script>
@stop





