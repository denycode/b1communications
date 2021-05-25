<?php
/**
 * Created by PhpStorm.
 * User: Gurpreet Singh
 * Date: 15-03-2021
 * Time: 01:39 PM
 */
			$time = $timeGroup->time;
            $w_day = array(
                            "mon"=>"Monday",
                            "tue"=>"Tuesday",
                            "wed"=>"Wednesday",
                            "thu"=>"Thursday",
                            "fri"=>"Friday",
                            "sat"=>"Saturday",
                            "sun"=>"Sunday"
                        );
            $times = explode("|",$time);
            $ampm = explode("-",$times[0]);
            $timeS = date('h:i a',strtotime($ampm[0]));
            $timeS = explode(":",$timeS);
            $timeE = date('h:i a',strtotime($ampm[1]));
            $timeE = explode(":",$timeE);
            if( $times[1] == '*' ){
                $daysw = 'mon';
                $dayew = 'sun';       
            }else 
            {
                $day = explode("-",$times[1]);
                $daysw = $day[0];
                $dayew = $day[1];
            }
            
?>
<form class="ajax-Form" enctype="multipart/form-data" method="post" action="{!! URL::to('/timegroups/update') !!}">
    {!! csrf_field() !!}
    <div class="col-md-12">
    	<div class="row">
    		<div class="col-md-3">
    			<div class="form-group">
    				<label for="exampleInputEmail1">Description</label>
    			</div>
    		</div>
	        <div class="col-md-9">
	            <div class="form-group">
	                <input type="text" name="description" class="form-control" id="exampleInputEmail1"
	                       aria-describedby="emailHelp"
	                       placeholder=""
	                       value="{{$timeGroup_d->description}}"
	                >
	            </div>
	        </div>
	    </div>
	    <div class="row">
    		<div class="col-md-3">
    			<div class="form-group">
    				<label for="exampleInputEmail1">Time(s)</label>
    			</div>
    		</div>
	        <div class="col-md-9">
	            <div class="row">
		    		<div class="col-md-3">
		    			<div class="form-group">
		    				<label for="exampleInputEmail1">Time to Start</label>
		    			</div>
		    		</div>
			        <div class="col-md-9">
			        	<div class="row">
			        		<div class="col-md-6">
					            <div class="form-group">
					             	<select name="stime[]" class="time form-control">
					             		@for ($i=0;$i<23;$i++)
					                		@if($i<10)
					                			@if($timeS[0] == $i)
					                				<option selected="selected" value='0{{$i}}'>0{{$i}}</option>
					                			@else
					                		 		<option  value='0{{$i}}'>0{{$i}}</option>
					                		 	@endif
					                		@else
					                			@if($timeS[0] == $i)
					                				<option selected="selected" value='{{$i}}'>{{$i}}</option>
					                			@else
					                		 		<option  value='{{$i}}'>{{$i}}</option>
					                		 	@endif
					                		@endif
					                		
					                	@endfor 
								    </select>  
					            </div>
					        </div>
					        <div class="col-md-6">
					            <div class="form-group">
					                <select name="stime[]" class="time form-control">
					                	@for ($i=0;$i<60;$i++)
					                		@if($i<10)
					                			@if($timeS[1] == $i)
					                				<option selected="selected" value='0{{$i}}'>0{{$i}}</option>
					                			@else
					                		 		<option  value='0{{$i}}'>0{{$i}}</option>
					                		 	@endif
					                		@else
					                			@if($timeS[1] == $i)
					                				<option selected="selected" value='{{$i}}'>{{$i}}</option>
					                			@else
					                		 		<option  value='{{$i}}'>{{$i}}</option>
					                		 	@endif
					                		@endif
					                		
					                	@endfor
					                	
								    </select>
					            </div>
					        </div>
				        </div>
			        </div>
			    </div>
	            <div class="row">
		    		<div class="col-md-3">
		    			<div class="form-group">
		    				<label for="exampleInputEmail1">Time to Finish</label>
		    			</div>
		    		</div>
			        <div class="col-md-9">
			        	<div class="row">
			        		<div class="col-md-6">
					            <div class="form-group">
					             	<select name="etime[]" class="time form-control">
					             		@for ($i=0;$i<23;$i++)
					                		@if($i<10)
					                			@if($timeE[0] == $i)
					                				<option selected="selected" value='0{{$i}}'>0{{$i}}</option>
					                			@else
					                		 		<option  value='0{{$i}}'>0{{$i}}</option>
					                		 	@endif
					                		@else
					                			@if($timeE[0] == $i)
					                				<option selected="selected" value='{{$i}}'>{{$i}}</option>
					                			@else
					                		 		<option  value='{{$i}}'>{{$i}}</option>
					                		 	@endif
					                		@endif
					                		
					                	@endfor 
								    </select>  
					            </div>
					        </div>
					        <div class="col-md-6">
					            <div class="form-group">
					                <select name="etime[]" class="time  form-control">
					                	@for ($i=0;$i<60;$i++)
					                		@if($i<10)
					                			@if($timeE[1] == $i)
					                				<option selected="selected" value='0{{$i}}'>0{{$i}}</option>
					                			@else
					                		 		<option  value='0{{$i}}'>0{{$i}}</option>
					                		 	@endif
					                		@else
					                			@if($timeE[1] == $i)
					                				<option selected="selected" value='{{$i}}'>{{$i}}</option>
					                			@else
					                		 		<option  value='{{$i}}'>{{$i}}</option>
					                		 	@endif
					                		@endif
					                		
					                	@endfor
					                	
								    </select>
					            </div>
					        </div>
				        </div>
			        </div>
			    </div>
	            <div class="row">
		    		<div class="col-md-3">
		    			<div class="form-group">
		    				<label for="exampleInputEmail1">Week Day Start</label>
		    			</div>
		    		</div>
			        <div class="col-md-9">
			        	<div class="row">
					        <div class="col-md-12">
					            <div class="form-group">
					                <select name="sweek[]" class="day form-control">
					                	@foreach ($w_day as $key => $val)
					                			@if($daysw == $key)
					                				<option selected="selected" value='{{$key}}'>{{$val}}</option>
					                			@else
					                		 		<option  value='{{$key}}'>{{$val}}</option>
					                		 	@endif					                		
					                	@endforeach
					                	
								    </select>
					            </div>
					        </div>
				        </div>
			        </div>
			    </div>
	            <div class="row">
		    		<div class="col-md-3">
		    			<div class="form-group">
		    				<label for="exampleInputEmail1">week Day Finish</label>
		    			</div>
		    		</div>
			        <div class="col-md-9">
			        	<div class="row">
					        <div class="col-md-12">
					            <div class="form-group">
					                <select name="sweek[]" class="day form-control">
					                	@foreach ($w_day as $key => $val)
					                			@if($dayew == $key)
					                				<option selected="selected" value='{{$key}}'>{{$val}}</option>
					                			@else
					                		 		<option  value='{{$key}}'>{{$val}}</option>
					                		 	@endif					                		
					                	@endforeach
					                	
								    </select>
					            </div>
					        </div>
				        </div>
			        </div>
			    </div>
	        </div>
	    </div>
    </div>
    

    <div class="form-actions pull-right depend">
        <input type="hidden" name="type" value="extensions">
        <button type="submit" class="btn waves-effect waves-light btn-success">
            Add
        </button>
        <button type="button" class="btn waves-effect waves-light btn-secondary" data-dismiss="modal">
            Cancel
        </button>
    </div>
</form>
