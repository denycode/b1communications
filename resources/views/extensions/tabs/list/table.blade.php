<table id="basic_table2" class="table table-bordered table-hover color-table lkp-table" data-message="No extensions available">
    <thead>
        <tr>
            <th>Extension</th>
            <th>Name</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @if(count($eExtensions) > 0)
            @foreach($eExtensions as $eExtension)
                @include('extensions.tabs.list.table-single-row')
            @endforeach
        @endif
    </tbody>
</table>
