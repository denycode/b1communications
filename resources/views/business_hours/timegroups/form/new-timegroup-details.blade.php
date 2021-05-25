<hr  class="hr_remove{{$lenght_id}}" style='height:2px;border-width:0;color:gray;background-color:gray;'>
	<div class="row hr_remove{{$lenght_id}}">

		<div class="col-md-3">
				<div class="form-group">
				</div>
		</div>
		<div class="col-md-8 timegroup_detail">
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
								<select  name="time[n{{$lenght_id}}][shour]"
							    class="time form-control">
									@for ($i = 0; $i < 24; $i++)
										@if($i<10)
											<option	value="0{{$i}}">0{{$i}}</option>
										@else
											<option value="{{$i}}">{{$i}}</option>
									@endif
									@endfor
								</select>

							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select name="time[n{{$lenght_id}}][sminut]" class="time form-control">
									@for ($i = 0; $i < 60; $i++)
										@if($i<10)
											<option value="0{{$i}}">0{{$i}}</option>
										@else
											<option value="{{$i}}">{{$i}}</option>
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
								<select name="time[n{{$lenght_id}}][ehour]" class="time form-control">
									@for ($i = 0; $i < 24; $i++)
										@if($i<10)
											<option value="0{{$i}}">0{{$i}}</option>
										@else
											<option value="{{$i}}">{{$i}}</option>
										@endif
									@endfor
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select name="time[n{{$lenght_id}}][eminut]" class="time  form-control">
									@for ($i = 00; $i < 60; $i++)
									@if($i<10)
										<option value="0{{$i}}">0{{$i}}</option>
										@else
											<option value="{{$i}}">{{$i}}</option>
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
								@php
									$week_days = \App\Http\Controllers\Controller::WEEK_DAYS;
								@endphp
								<select name="week[n{{$lenght_id}}][sweek]" class="day form-control">
									<option value=""></option>
									@foreach ($week_days as $key => $day)
										<option value="{{$key}}">{{$day}}</option>
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

								<select name="week[n{{$lenght_id}}][eweek]" class="day form-control">
									<option value=""></option>
									@foreach ($week_days as $ekey => $eday)
										<option value="{{$ekey}}">{{$eday}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-1 timegroup_detail">
			<a data-remove_id="hr_remove{{$lenght_id}}" data-confirm="true" data-title="Are you sure want to delete ?" href="javascript:void(0);" class="pull-right ajax-Link " onclick="remove_new_time($(this));"><i class="fas fa-trash"></i> </a>
			<input type="hidden" name="timegroup_detail_id[]" value="{{ Crypt::encrypt('n'.$lenght_id) }}"/>
		</div>
	</div>
	
		

	