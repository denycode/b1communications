	@if( $rowkey > 0)
		<hr class="timegroup_{{$timegroup['id']}}detail" style="height:2px;border-width:0;color:gray;background-color:gray">
	@endif
	<div class="row">
		<div class="col-md-3">
			@if($rowkey == 0)
				<div class="form-group">
					<label for="exampleInputEmail1">Time(s)</label>
				</div>
			@endif
		</div>
		<div class="col-md-8 timegroup_{{$timegroup['id']}}detail">
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
								<select data-TG="s{{$timegroup['id']}}hour" name="time[{{$timegroup['id']}}][shour]"
								data-id="s{{$timegroup['id']}}" class="time form-control">
									@for ($i = 0; $i < 24; $i++)
										@if($i<10)
											<option
												@if(isset($parseTimeDateArr['start_hour']) && $parseTimeDateArr['start_hour'] == $i) selected @endif
												value="0{{$i}}"
											>
												0{{$i}}
											</option>
										@else
											<option
											@if(isset($parseTimeDateArr['start_hour']) && $parseTimeDateArr['start_hour'] == $i) selected @endif
											value="{{$i}}"
										>
											{{$i}}
										</option>
									@endif
									@endfor
								</select>

							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select data-TG="s{{$timegroup['id']}}minut" name="time[{{$timegroup['id']}}][sminut]"
								data-id="s{{$timegroup['id']}}" class="time form-control">
									@for ($i = 0; $i < 60; $i++)
										@if($i<10)
											<option
													@if(isset($parseTimeDateArr['start_mintue']) && $parseTimeDateArr['start_mintue'] == $i) selected @endif
											value="0{{$i}}"
											>
												0{{$i}}
											</option>
										@else
											<option
												@if(isset($parseTimeDateArr['start_mintue']) && $parseTimeDateArr['start_mintue'] == $i) selected @endif
										value="{{$i}}"
										>
											{{$i}}
										</option>
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
								<select data-TG="e{{$timegroup['id']}}hour" name="time[{{$timegroup['id']}}][ehour]"
								data-id="e{{$timegroup['id']}}" class="time form-control">
									@for ($i = 0; $i < 24; $i++)
										@if($i<10)
											<option
														@if(isset($parseTimeDateArr['end_hour']) && $parseTimeDateArr['end_hour'] == $i) selected @endif
												value="0{{$i}}"
												>
													0{{$i}}
												</option>
										@else
											<option
													@if(isset($parseTimeDateArr['end_hour']) && $parseTimeDateArr['end_hour'] == $i) selected @endif
											value="{{$i}}"
											>
												{{$i}}
											</option>
										@endif
									@endfor
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<select data-TG="e{{$timegroup['id']}}minut" name="time[{{$timegroup['id']}}][eminut]"
								data-id="e{{$timegroup['id']}}" class="time  form-control">
									@for ($i = 00; $i < 60; $i++)
									@if($i<10)
										<option
												@if(isset($parseTimeDateArr['end_mintue']) && $parseTimeDateArr['end_mintue'] == $i) selected @endif
										value="0{{$i}}"
										>
											0{{$i}}
										</option>
										@else
											<option
												@if(isset($parseTimeDateArr['end_mintue']) && $parseTimeDateArr['end_mintue'] == $i) selected @endif
										value="{{$i}}"
										>
											{{$i}}
										</option>
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
								<select name="week[{{$timegroup['id']}}][sweek]" class="day form-control">
									<option value=""></option>
									@foreach ($week_days as $key => $day)
										<option
											@if(isset($parseTimeDateArr['startDayValue']) && $parseTimeDateArr['startDayValue'] == $key) selected @endif
											value="{{$key}}"
										>
											{{$day}}
										</option>
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

								<select name="week[{{$timegroup['id']}}][eweek]" class="day form-control">
									<option value=""></option>
									@foreach ($week_days as $ekey => $eday)
										<option
											@if(isset($parseTimeDateArr['endDayValue']) && $parseTimeDateArr['endDayValue'] == $ekey) selected @endif
											value="{{$ekey}}"
										>
											{{$eday}}
										</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-1 timegroup_{{$timegroup['id']}}detail">
			<a data-confirm="true" data-title="Are you sure want to delete ?" href="{{URL::to('/')}}/businesshours/timegroupdelete/{{ Crypt::encrypt($timegroup['id']) }}" class="pull-right ajax-Link delete_timeG"><i class="fas fa-trash"></i> </a>
			<input type="hidden" name="timegroup_detail_id[]" value="{{ Crypt::encrypt($timegroup['id']) }}"/>
		</div>
	</div>
	
	