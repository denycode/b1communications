<table id="basic_table2" class="table table-bordered table-hover color-table lkp-table" data-message="No phonenumbers available">
    <thead>
        <tr>
            <th>Phone Number</th>
            <th>Description</th>
            <th>Destination</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @if(count($pPhoneNumbers) > 0)
            @foreach($pPhoneNumbers as $pPhoneNumber)
                @include('phonenumbers.tabs.list.table-single-row')
            @endforeach
        @endif
    </tbody>
</table>
