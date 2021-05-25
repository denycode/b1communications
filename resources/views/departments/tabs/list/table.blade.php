<table id="basic_table2" class="table table-bordered table-hover color-table lkp-table" data-message="No department available">
    <thead>
        <tr>
            <th>Department ID</th>
            <th>Description</th>
            <th>Mode</th>
            <th>Ring Time</th>
            <th>If no answer send call to</th>
            <th>List</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @if(count($dDepartments) > 0)
            @foreach($dDepartments as $dDepartment)
                @include('departments.tabs.list.table-single-row')
            @endforeach
        @endif
    </tbody>
</table>
