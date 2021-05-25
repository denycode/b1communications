<table id="basic_table2" class="table table-bordered table-hover color-table lkp-table" data-message="No extensions available">
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @if(count($autoAttendants) > 0)
            @foreach($autoAttendants as $autoAttendant)

                @include('autoattendants.tabs.list.table-single-row')
            @endforeach
        @endif
    </tbody>
</table>
