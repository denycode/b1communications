

    <div class="row">
        <div class="col-md-12">
            <label for="exampleInputEmail1">Extensions</label>
            <div class="m-b-30">
            	<table class="table table-bordered table-hover color-table lkp-table" data-message="No extensions available">
				    <thead>
				         <tr>
				            <th>Extensions ID</th>
				        </tr>
				    </thead>
				    <tbody>
				    	@foreach($eExtensions as $eExtension)
				       		<tr>
                        		<td>
                            		{{$eExtension->extension}} - {{$eExtension->name}}
		                        </td>
                       		</tr>
                    	@endforeach
				    </tbody>
				</table>
            </div>
        </div>
    </div>

   