<table id="basic_table2" class="table table-bordered table-hover color-table lkp-table" data-message="No announcement available">
    <thead>
        <tr>
            <th>Description</th>
            <th>Post Destination</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @if(count($aAnnouncements) > 0)
            @foreach($aAnnouncements as $aAnnouncement)
                @include('announcement.tabs.list.table-single-row')
            @endforeach
        @endif
    </tbody>
</table>
