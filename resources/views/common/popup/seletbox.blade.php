<div class="row">
    <div class="col-md-12">
        <label for="exampleInputEmail1">{!! $label !!}</label>
        <div class="m-b-30">
			<select name="destination_id" class="form-control destination_id">
				<option value="">Select</option>
				{!! $options !!}
			</select>

		</div>
	</div>
</div>
<input type="hidden" name="icon_class" value="{!! $icon !!}">
<input type="hidden" name="org_dest" value="{!! $org_dest !!}">

@if(!empty($vmoptions))
	<div class="row">
		<div class="col-md-12">
			<label for="exampleInputEmail1">Voice Mail Message</label>
			<div class="m-b-30">
				<select name="vmmessage" class="form-control vmmessage">
					<option value="">Select</option>
					{!! $vmoptions !!}
				</select>
				<input type="hidden" value="Voice Mail" icon="{!! $icon !!}" class="vm_field"/>
			</div>
		</div>
	</div>
@endif

