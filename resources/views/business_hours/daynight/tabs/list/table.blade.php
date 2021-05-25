<table id="basic_table2" class="table table-bordered table-hover color-table lkp-table" data-message="No announcement available">
    <thead>
        <tr>
            <th>Description</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @if(count($dDaynights) > 0)
            @foreach($dDaynights as $dDaynight)
                @include('business_hours.daynight.tabs.list.table-single-row')
            @endforeach
        @endif
    </tbody>
</table>
