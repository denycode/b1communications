<table id="basic_table2" class=" fgfg table table-bordered table-hover color-table lkp-table" data-message="No extensions available">
    <thead>
        <tr>
            <th>Time</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @if(count($timeGroups) > 0)
            @foreach($timeGroups as $timeGroup)
                @include('business_hours.timegroups.tabs.list.table-single-row')
            @endforeach
        @endif
    </tbody>
</table>
