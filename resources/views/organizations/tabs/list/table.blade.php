<table id="basic_table2" class="table table-bordered table-hover color-table lkp-table" data-message="No organizations available">
    <thead>
        <tr>
            <th>Organization Name</th>
            <th>Server ID</th>
            {{--<th>Extension Range</th>--}}
            <th>Status</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @if(count($oOrganizations) > 0)
            @foreach($oOrganizations as $oOrganization)
                @include('organizations.tabs.list.table-single-row')
            @endforeach
        @endif
    </tbody>
</table>
