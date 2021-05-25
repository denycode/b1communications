<table id="basic_table2" class=" fgfg table table-bordered table-hover color-table lkp-table" data-message="No extensions available">
    <thead>
        <tr>
            <th>Description</th>
            <th>Open Destination</th>
            <th>Closed Destination</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @if(count($timeconditions) > 0)
            @foreach($timeconditions as $timecondition)
                @include('business_hours.timeconditions.tabs.list.table-single-row')
            @endforeach
        @endif
    </tbody>
</table>
